<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\TB_Assets\Data_AssetsOwnership;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_RENEWCONTRACT;
use App\Models\TB_temp\TMP_ARLOST\TMP_ARLOSTHP;
use App\Models\TB_temp\TMP_ARLOST\TMP_ARLOSTPSL;
use App\Models\TB_temp\TMP_INVOICE\TMP_INVOICE;
use App\Models\TB_temp\TMP_WAITHOLD\TMP_WAITHOLDHP;
use App\Models\TB_temp\TMP_WAITHOLD\TMP_WAITHOLDPSL;

use App\Models\TB_PactContracts\Pact_Contracts;
use App\Models\TB_DataCus\Data_Customers;

use App\Models\TB_Constants\TB_Frontend\TB_Branchs;

use App\Models\TB_Temp\TMP_CONTRACTS\TMP_CANCONTRACTHP;
use App\Models\TB_Temp\TMP_CONTRACTS\TMP_CANCONTRACTPSL;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        if ($request->page_type == 'frontend') {
            $typeSr = $request->typeSr;

            if ($request->typeSr == 'selectAsset') {
                $data = Data_AssetsOwnership::where('DataCus_id', $request->DataCus_id)->orderBy('id', 'DESC')->get();
                $PactCon_id = $request->PactCon_id;
                $DataCus_id = $request->DataCus_id;

                //$checkAsset = Pact_Indentures_Assets::where('PactCon_id',$PactCon_id)->get();
                $contract = Pact_Contracts::where('id', $PactCon_id)->first();
                $html = view('frontend.content-con.section-asset.show-asset', compact('data', 'typeSr', 'PactCon_id', 'DataCus_id', 'contract'))->render();
                return response()->json(['html' => $html]);
            } else { //search datacus
                $tabPage = (($request->flagTab == 'add-Broker') ? $request->flagTab : null);

                if ($request->typeSr == 'namecus') {
                    $value = '%' . $request->search . '%';
                    $data = Data_Customers::whereNull('deleted_at')
                        ->when(!empty($tabPage), function ($q) {
                            return $q->whereHas('DataCusToBroker', function ($q) {
                                $q->where('status_Broker', 'active');
                            });
                        })
                        ->where('Name_Cus', 'like', $value)
                        ->limit(50)
                        ->get();
                } elseif ($request->typeSr == 'idcardcus') {
                    $value = str_replace(["_", "-"], "", $request->search);
                    $data = Data_Customers::whereNull('deleted_at')
                        ->when(!empty($tabPage), function ($q) {
                            return $q->whereHas('DataCusToBroker', function ($q) {
                                $q->where('status_Broker', 'active');
                            });
                        })
                        ->where('IDCard_cus', $value)
                        ->limit(50)
                        ->get();
                } elseif ($request->typeSr == 'license') {
                    $value = '%' . $request->search . '%';
                    $data = Data_Customers::whereHas('DataCusToDataAsset', function ($q) use ($value) {
                        $q->where('Vehicle_OldLicense', 'like', $value)
                            ->orwhere('Vehicle_NewLicense', 'like', $value);
                    })
                        ->with([
                            'DataCusToDataAsset' => function ($q) use ($value) {
                                $q->where('Vehicle_OldLicense', 'like', $value)
                                    ->orwhere('Vehicle_NewLicense', 'like', $value);
                            }
                        ])
                        ->limit(50)
                        ->get();

                } elseif ($request->typeSr == 'contract') {
                    $value = str_replace(["_", "-"], "", $request->search);


                    // $data = Pact_Contracts::whereNull('deleted_at')
                    //     ->when(!empty($tabPage) , function ($q)  {
                    //         return $q-> whereHas('DataCusToBroker', function($q){
                    //             $q->where('status_Broker', 'ปกติ');
                    //         });
                    //     })
                    //     ->where('Contract_Con', $value)
                    //     ->limit(50)
                    //     ->get();
                    $data = DB::table('View_ContractCon')
                        ->select(
                            'Approve_monetary',
                            'ConfirmApp_Con',
                            'ConfirmDocApp_Con',
                            'DocApp_Con',
                            'Date_con',
                            'DateCheck_Bookcar',
                            'id',
                            'Contract_Con',
                            'CodeLoan_Con',
                            'Loan_Name',
                            'Date_monetary',
                            'Name_Cus',
                            'licence',
                            'cash',
                            'id_rateType',
                            'brand',
                            'image_cus'
                        )
                        ->where('Contract_Con', $value)
                        ->limit(50)
                        ->get();

                } elseif ($request->typeSr == 'phone') {
                    $value = str_replace(["_", "-"], "", $request->search);
                    $value = '%' . $value . '%';
                    $data = Data_Customers::whereNull('deleted_at')
                        ->when(!empty($tabPage), function ($q) {
                            return $q->whereHas('DataCusToBroker', function ($q) {
                                $q->where('status_Broker', 'active');
                            });
                        })
                        ->where(function ($q) use ($value) {
                            $q->whereRaw(replacePhone(getFirstPhone('Phone_cus')) . ' like ?', [$value])
                                ->orWhereRaw(replacePhone(getSecondPhone('Phone_cus')) . ' like ?', [$value]);
                        })
                        ->limit(50)
                        ->get();
                }

                // 10 รายการแรก
                if ($request->pageUrl == 'add-Guaran' || $request->pageUrl == 'add-Payee') {
                    $data = Data_Customers::orderBy('id', 'DESC')->where('Status_Cus', 'active')->limit(10)->get();
                } else if ($request->pageUrl == 'add-Broker') {
                    $data = Data_Customers::whereHas('DataCusToBroker', function ($q) {
                        $q->where('status_Broker', 'active');
                    })->limit(10)
                        ->get();
                }

                $page = $request->page;
                $pageUrl = $request->pageUrl;
                $flagTab = $request->flagTab;
                return response()->view('components.content-search.section-frontend.data-search', compact('data', 'page', 'pageUrl', 'typeSr', 'flagTab'));
            }
        } elseif ($request->page_type == 'backend') {
            if ($request->typeSr == 'namecus') {
                $value = '%' . $request->search . '%';
                $data = Data_Customers::where('Name_Cus', 'like', $value)
                    ->whereHas('DataCusToContracts', function ($q) {
                        $q->where('Flag_Inside', 'Y');
                    })
                    ->with([
                        'DataCusToContracts' => function ($q) {
                            $q->where('Flag_Inside', 'Y');
                        }
                    ])
                    ->withoutEagerLoads()
                    ->limit(50)
                    ->get();
            } elseif ($request->typeSr == 'idcardcus') {
                $value = str_replace(["_", "-"], "", $request->search);
                $data = Data_Customers::where('IDCard_cus', $value)
                    ->whereHas('DataCusToContracts', function ($q) {
                        $q->where('Flag_Inside', 'Y');
                    })
                    ->with([
                        'DataCusToContracts' => function ($q) {
                            $q->where('Flag_Inside', 'Y');
                        }
                    ])
                    ->withoutEagerLoads()
                    ->limit(50)
                    ->get();
            } elseif ($request->typeSr == 'license') {
                $value = '%' . $request->search . '%';
                $data = Data_Customers::whereHas('DataCusToDataAsset', function ($q) use ($value) {
                    $q->where('Vehicle_OldLicense', 'like', $value)
                        ->orwhere('Vehicle_NewLicense', 'like', $value);
                })
                    ->with([
                        'DataCusToDataAsset' => function ($q) use ($value) {
                            $q->where('Vehicle_OldLicense', 'like', $value)
                                ->orwhere('Vehicle_NewLicense', 'like', $value);
                        }
                    ])
                    ->whereHas('DataCusToContracts', function ($q) {
                        $q->where('Flag_Inside', 'Y');
                    })
                    ->with([
                        'DataCusToContracts' => function ($q) {
                            $q->where('Flag_Inside', 'Y');
                        }
                    ])
                    ->withoutEagerLoads()
                    ->limit(50)
                    ->get();

            } elseif ($request->typeSr == 'contract') {
                $value = str_replace(["_", "-"], "", $request->search);
                $data = Pact_Contracts::where('Contract_Con', $request->search)
                    ->where('Flag_Inside', 'Y')
                    // ->with([
                    //     'DataCusToContracts' => function ($q) {
                    //         $q->where('Flag_Inside', 'Y');
                    //     }
                    // ])
                    ->withoutEagerLoads()
                    ->limit(50)
                    ->get();
            }

            // สอบถามรถยึด
            if ($request->page_tmp == 'search-seized') {
                if ($request->typeSr == 'contract') {

                    $firstQuery = TMP_WAITHOLDPSL::select('dataPact_id')->whereNotNull('dataPact_id')->where('UserZone', auth()->user()->zone);
                    $secondQuery = TMP_WAITHOLDHP::select('dataPact_id')->whereNotNull('dataPact_id')->where('UserZone', auth()->user()->zone);
                    $select = array_column($firstQuery->union($secondQuery)->get()->toArray(), 'dataPact_id');

                } else {

                    $firstQuery = TMP_WAITHOLDPSL::select('DataCus_id')->whereNotNull('DataCus_id')->where('UserZone', auth()->user()->zone);
                    $secondQuery = TMP_WAITHOLDHP::select('DataCus_id')->whereNotNull('DataCus_id')->where('UserZone', auth()->user()->zone);

                    $select = $firstQuery->union($secondQuery)->get()->toArray();
                    $select = array_column($firstQuery->union($secondQuery)->get()->toArray(), 'DataCus_id');


                }
                if ($request->page_tmp == 'search-seized' && $request->search == NULL) {


                    $dataA = Pact_Contracts::
                        WhereHas('ContractToConPSL', function ($query) {
                            $query->whereHas('ContractToHLD')->where('UserZone', auth()->user()->zone);
                        })
                        ->limit(50);



                    $dataB = Pact_Contracts::
                        WhereHas('ContractToConHP', function ($query) {
                            $query->whereHas('ContractToHLD')->where('UserZone', auth()->user()->zone);
                        })
                        ->limit(50);


                    $data = $dataA->union($dataB)->get();



                } else {
                    $data = $data->filter(function ($q) use ($select) {
                        return in_array($q->id, $select);
                    });
                }
            } elseif ($request->page_tmp == 'search-baddebt') {
                // $model = TMP_ARLOSTPSL::query()
                if ($request->typeSr == 'contract') {
                    $queryA = TMP_ARLOSTPSL::whereNotNull('dataPact_id')->where('UserZone', auth()->user()->zone)->get()->toArray();
                    $query = TMP_ARLOSTHP::whereNotNull('dataPact_id')->where('UserZone', auth()->user()->zone)->get()->union($queryA)->toArray();
                    $select = array_column($query, 'dataPact_id');
                } else {
                    $queryA = TMP_ARLOSTPSL::whereNotNull('DataCus_id')->where('UserZone', auth()->user()->zone)->get()->toArray();
                    $query = TMP_ARLOSTHP::whereNotNull('DataCus_id')->where('UserZone', auth()->user()->zone)->get()->union($queryA)->toArray();

                    $select = array_column($query, 'DataCus_id');
                }
                if ($request->page_tmp == 'search-baddebt' && $request->search == NULL) {
                    $queryA = TMP_ARLOSTPSL::whereNotNull('DataCus_id')->where('UserZone', auth()->user()->zone)->get()->toArray();
                    $query = TMP_ARLOSTHP::whereNotNull('DataCus_id')->where('UserZone', auth()->user()->zone)->get()->union($queryA)->toArray();

                    $select = array_column($query, 'DataCus_id');

                    $data = Pact_Contracts::
                        whereIn('DataCus_id', $select)
                        ->limit(50)
                        ->get();

                } else {
                    $data = $data->filter(function ($q) use ($select) {
                        return in_array($q->id, $select);
                    });
                }
            } elseif ($request->page_tmp == 'ask_terminate') {
                if ($data != NULL) {
                    if ($request->typeSr == 'contract') {
                        if ($data[0]->CodeLoan_Con == '01') {
                            $Getdata = TMP_CANCONTRACTHP::where('CONTNO', $data[0]->Contract_Con)->count();
                        } else {
                            $Getdata = TMP_CANCONTRACTPSL::where('CONTNO', $data[0]->Contract_Con)->count();
                        }
                    } else {
                        if ($data[0]->DataCusToContracts[0]->CodeLoan_Con == '02') {
                            $Getdata = TMP_CANCONTRACTHP::where('CONTNO', $data[0]->DataCusToContracts[0]->Contract_Con)->count();
                        } else {
                            $Getdata = TMP_CANCONTRACTPSL::where('CONTNO', $data[0]->DataCusToContracts[0]->Contract_Con)->count();
                        }
                    }
                }
                if ($Getdata > 0) {
                    $data = $data;
                } else {
                    $data = [];
                }
            } elseif ($request->page_tmp == 'search-recontract') {
                // $model = TMP_ARLOSTPSL::query()
                if ($request->typeSr == 'contract') {
                    $query = PatchPSL_RENEWCONTRACT::whereNotNull('dataPact_id')->where('UserZone', auth()->user()->zone)->get()->toArray();
                    $select = array_column($query, 'dataPact_id');
                } else {
                    $query = PatchPSL_RENEWCONTRACT::whereNotNull('DataCus_id')->where('UserZone', auth()->user()->zone)->get()->toArray();
                    $select = array_column($query, 'DataCus_id');
                }
                if ($request->page_tmp == 'search-recontract' && $request->search == NULL) {
                    $query = PatchPSL_RENEWCONTRACT::whereNotNull('DataCus_id')->where('UserZone', auth()->user()->zone)->get()->toArray();
                    $select = array_column($query, 'DataCus_id');

                    $data = Pact_Contracts::
                        whereIn('DataCus_id', $select)
                        ->limit(50)
                        ->get();

                } else {
                    $data = $data->filter(function ($q) use ($select) {
                        return in_array($q->id, $select);
                    });
                }
            } elseif ($request->page_tmp == 'search-inv') {
                if ($request->typeSr == 'contract') {
                    $query = TMP_INVOICE::whereNotNull('PactCon_id')->where('UserZone', auth()->user()->zone)->get()->toArray();
                    $select = array_column($query, 'dataPact_id');
                } else {
                    $query = TMP_INVOICE::whereNotNull('PactCon_id')->where('UserZone', auth()->user()->zone)->get()->toArray();
                    $select = array_column($query, 'DataCus_id');
                }
                if ($request->page_tmp == 'search-inv' && $request->search == NULL) {
                    $query = TMP_INVOICE::whereNotNull('DataCus_id')->where('UserZone', auth()->user()->zone)->get()->toArray();
                    $select = array_column($query, 'DataCus_id');

                    $data = Pact_Contracts::
                        whereIn('DataCus_id', $select)
                        ->limit(50)
                        ->get()->ContractToInvoice;


                } else {
                    $data = $data->filter(function ($q) use ($select) {
                        return in_array($q->id, $select);
                    });
                }
            }

            $page = $request->page;
            $pageUrl = $request->pageUrl;
            $typeSr = $request->typeSr;
            $page_tmp = ($request->page_tmp) ? $request->page_tmp : null;

            return response()->view('components.content-search.section-backend.data-search', compact('data', 'page', 'pageUrl', 'typeSr', 'page_tmp'));
        } elseif ($request->page_type == 'constants') {
            if ($request->typeSr == 'selectZones') {
                $data = TB_Branchs::where('Zone_Branch', $request->data['zone'])
                    ->where('Branch_Active', 'yes')
                    ->get();
            }
        } elseif ($request->page_type == 'otp') {
            try {
                $otp = random_int(10000, 99999);
                session()->put('otp_' . $request->patchCont_id . '/' . $request->codloan, $otp);

                return response()->json(['otp' => $otp, 'message' => 'ส่งรหัส OTP สำเร็จ']);
            } catch (\Exception $e) {

                session()->forget('otp_' . $request->patchCont_id . '/' . $request->codloan);
                return response()->json(['message' => 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง']);
            }
        }
    }

    public function unlock_screen(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Your session has expired. Please log in again.']);
        }

        // $previousUrl = url()->previous();
        $previousUrl = session()->get('url.intended');

        $user = Auth::user();
        if (Hash::check($request->password, $user->password)) {
            // Password is correct
            return response()->json(['success' => true, 'previous_url' => $previousUrl]);
        } else {
            // Password is incorrect
            return response()->json(['success' => false, 'message' => 'The provided password is incorrect.']);
        }
    }
}
