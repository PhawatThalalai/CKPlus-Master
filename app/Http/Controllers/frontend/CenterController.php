<?php

namespace App\Http\Controllers\frontend;

use App\Events\frontend\LogDataContract;
use App\Events\frontend\LogDataCusTag;

use App\Models\TB_PactContracts\Pact_Contracts;
use Illuminate\Http\Request;
use ConnectCredo;
use App\Models\User;
use DB;
use App\Http\Controllers\Controller;

use App\Traits\UserApproved;

use App\Models\TB_Configs\Config_Credos;
use App\Models\TB_Logs\Data_CredoCodes;

use App\Models\TB_Assessments\Stat_rateType;
use App\Models\TB_Assessments\Stat_CarBrand;
use App\Models\TB_Assessments\Stat_CarGroup;
use App\Models\TB_Assessments\Stat_CarModel;
use App\Models\TB_Assessments\Stat_CarYear;
use App\Models\TB_Assessments\Stat_MotoBrand;
use App\Models\TB_Assessments\Stat_MotoGroup;
use App\Models\TB_Assessments\Stat_MotoModel;
use App\Models\TB_Assessments\Stat_MotoYear;
use App\Models\TB_Assets\Data_Assets;

use App\Models\TB_Constants\TB_Frontend\TB_TypeLoanCom;
use App\Models\TB_Constants\TB_Frontend\TB_TypeVehicle;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_Constants\TB_Frontend\TB_InsurancePA;
use App\Models\TB_Constants\TB_Frontend\TB_Provinces;
use App\Models\TB_Constants\TB_Frontend\TB_StatusCustomers;
use App\Models\TB_Constants\TB_Frontend\TB_StatusTagParts;
use App\Models\TB_Constants\TB_Frontend\TB_TypeAssets;
use App\Models\TB_Constants\TB_Frontend\TB_TypeAssetsPoss;
use App\Models\TB_Constants\TB_Frontend\TB_TypeLoan;

use App\Models\TB_DataBroker\Data_Broker;
use App\Models\TB_DataCus\Data_CusTagCalculate;
use App\Models\TB_DataCus\Data_CusTags;
use App\Models\TB_DataCus\Data_Customers;

use App\Models\TB_Interests\rate_HY\Rate_HY_InterestCars1;
use App\Models\TB_Interests\rate_HY\Rate_HY_InterestCars2;
use App\Models\TB_Interests\rate_HY\Rate_HY_LTV;
use App\Models\TB_Interests\rate_HY\Rate_HY_LTVCAR;

use App\Models\TB_Interests\rate_KB\Rate_KB_InterestCars01;
use App\Models\TB_Interests\rate_KB\Rate_KB_InterestCars02;
use App\Models\TB_Interests\rate_NK\Rate_NK_InterestCars1;
use App\Models\TB_Interests\rate_NK\Rate_NK_InterestCars2;
use App\Models\TB_Interests\rate_NK\Rate_NK_LTVCAR;
use App\Models\TB_Interests\rate_NK\Rate_NK_LTV;
use App\Models\TB_Interests\rate_PTN\Rate_PTN_LTV;
use App\Models\TB_Interests\rate_SR\Rate_SR_InterestCars01;
use App\Models\TB_Interests\rate_SR\Rate_SR_LTV;
use App\Models\TB_Interests\rate_SR\Rate_SR_LTV_Reference;
use App\Models\TB_Logs\Data_CredoFragments;
use App\Models\TB_Packages\TB_Promotios;
use App\Models\TB_PactContracts\Pact_Operatedfees;

class CenterController extends Controller
{
    use UserApproved;
    public function index(Request $request)
    {
        $zone = auth()->user()->zone;
        $userBranch = ($request->userBranch == NULL) ? auth()->user()->branch : $request->userBranch;
        $userPosition = auth()->user()->position;
        $userID = auth()->user()->id;
        $type = $request->type;
        $dataBranch = TB_Branchs::generateQuery();

        if ($request->type == 1) { //view walk-in
            $dateSearch = $request->dateSearch;
            $SetFdate = substr($dateSearch, 0, 10);
            $Fdate = date('Y-m-d', strtotime($SetFdate));

            $SetTdate = substr($dateSearch, 13, 21);
            $Tdate = date('Y-m-d', strtotime($SetTdate));
            $position = array('Admin', 'MANAGER', 'MASTER');

            $data = Data_customer::where('UserZone', $zone)
                ->when(!empty($request->dateSearch), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereBetween('date_Cus', [$Fdate, $Tdate]);
                })
                ->when(empty($request->dateSearch), function ($q) use ($Fdate, $Tdate) {
                    return $q->where('date_Cus', '>=', date('Y-m-d'));
                })
                // ->when(!in_array($userPosition, $position) , function($q) use ($userBranch) {
                //     return $q->where('UserBranch',$userBranch);
                // })
                ->orderBY('date_Cus', 'DESC')
                ->get();




            return view('view_DataCus.view', compact('data', 'dataBranch', 'type', 'dateSearch', 'FlagTab', 'userBranch', 'position', 'userPosition'));
        } elseif ($request->type == 2) { //view Track
            $dateSearch = $request->dateSearch;
            $statusTxt = $request->statusTxt;
            $SetFdate = substr($dateSearch, 0, 10);
            $Fdate = date('Y-m-d', strtotime($SetFdate));

            $SetTdate = substr($dateSearch, 13, 21);
            $Tdate = date('Y-m-d', strtotime($SetTdate));

            if ($request->dateSearch == NULL) {
                $data = Data_CusTags::where('UserZone', $zone)
                    ->where('Status_Tag', '=', 'active')
                    ->orderBY('date_Tag', 'DESC')
                    ->get();
            } else {
                $data = Data_CusTags::where('UserZone', $zone)
                    ->whereHas('DataCusTagToDataCus', function ($query) {
                        $query->where('Status_Cus', '!=', 'cancel');
                    })
                    ->when(!empty($statusTxt), function ($q) use ($statusTxt) {
                        return $q->where('Status_Tag', $statusTxt);
                    })
                    ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                        return $q->whereBetween('date_Tag', [$Fdate, $Tdate]);
                    })
                    ->orderBY('date_Tag', 'DESC')
                    ->get();
            }
            $status_cus = TB_StatusTagParts::get();
            return view('view_DataCus.viewTracking', compact('data', 'dataBranch', 'type', 'dateSearch', 'FlagTab', 'status_cus', 'statusTxt'));
        } elseif ($request->type == 3) {
            $zone = auth()->user()->zone;
            $userBranch = ($request->userBranch == NULL) ? auth()->user()->branch : $request->userBranch;
            $userPosition = auth()->user()->position;
            $type = $request->type;
            $dataBranch = TB_Branchs::generateQuery();
            $dateSearch = $request->dateSearch;
            $SetFdate = substr($dateSearch, 0, 10);
            $Fdate = date('Y-m-d', strtotime($SetFdate));

            $SetTdate = substr($dateSearch, 13, 21);
            $Tdate = date('Y-m-d', strtotime($SetTdate));
            $position = array('Admin', 'MANAGER', 'MASTER');


            $data = data_Broker::where('UserZone', $zone)
                ->when(!empty($request->dateSearch), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereBetween('date_Broker', [$Fdate, $Tdate]);
                })
                ->when(empty($request->dateSearch), function ($q) use ($Fdate, $Tdate) {
                    return $q->where('date_Broker', '>=', date('Y-m-d'));
                })
                // ->when(!in_array($userPosition, $position) , function($q) use ($userBranch) {
                //     return $q->where('UserBranch',$userBranch);
                // })
                ->orderBY('date_Broker', 'DESC')
                ->get();

            return view('view_DataBroker.view', compact('data', 'dataBranch', 'type', 'dateSearch', 'FlagTab', 'userBranch', 'position', 'userPosition'));
        } elseif ($request->type == 4) {
            $dateSearch = $request->dateSearch;
            $statusTxt = $request->statusTxt;
            $SetFdate = substr($dateSearch, 0, 10);
            $Fdate = date('Y-m-d', strtotime($SetFdate));

            $SetTdate = substr($dateSearch, 13, 21);
            $Tdate = date('Y-m-d', strtotime($SetTdate));

            if ($request->dateSearch == NULL) {

                $data = Data_CusTags::where('Status_Tag', 'active')
                    ->whereHas('QueryTagPart', function ($q) {
                        $q->whereNotNull('Userfollow_TrackPart');
                    })
                    ->with('QueryTagPart')
                    ->with('DataCusTagToDataCus')
                    ->get();
            } else {

                $data = Data_CusTags::where('Status_Tag', 'active')
                    ->whereHas('QueryTagPart', function ($q) {
                        $q->whereNotNull('Userfollow_TrackPart');
                    })
                    ->with('QueryTagPart')
                    ->with('DataCusTagToDataCus')
                    ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                        return $q->whereBetween('date_Tag', [$Fdate, $Tdate]);
                    })
                    ->orderBY('date_Tag', 'DESC')
                    ->get();
            }
            $status_cus = TB_StatusTagParts::get();
            return view('view_DataCus.viewCusToGM', compact('data', 'dataBranch', 'type', 'dateSearch', 'FlagTab', 'status_cus', 'statusTxt'));
        } elseif ($request->type == 5) { //view Asset
            $dateSearch = $request->dateSearch;
            $SetFdate = substr($dateSearch, 0, 10);
            $Fdate = date('Y-m-d', strtotime($SetFdate));

            $SetTdate = substr($dateSearch, 13, 21);
            $Tdate = date('Y-m-d', strtotime($SetTdate));
            $position = array('Admin', 'MANAGER', 'MASTER');

            $data = Data_Assets::where('UserZone', $zone)
                ->where('Status_Asset', '!=', 'Hide')
                ->when(!empty($request->dateSearch), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereBetween('created_at', [$Fdate, $Tdate]);
                })
                ->when(empty($request->dateSearch), function ($q) use ($Fdate, $Tdate) {
                    return $q->where('created_at', '>=', date('Y-m-d'));
                })
                ->orderBY('created_at', 'DESC')
                ->get();

            return view('view_DataAsset.view', compact('data', 'dataBranch', 'type', 'dateSearch', 'FlagTab', 'userBranch', 'position', 'userPosition'));
        }
    }

    public function create(Request $request)
    {

        if ($request->funs == 'calculates') {
            //$tags = Data_CusTags::where('id', $request->id)->first();
            // if (@$tags->TagToCulculate->TypeLoans != NULL) {
            $TypeVehicle = TB_TypeVehicle::where('Flag_Vehicle', 'yes')->get()->toArray();
            $dataCar = array(
                "all" => Stat_CarYear::getAllCarData(),
                "brand" => Stat_CarBrand::getBrandArray(),
                "group" => Stat_CarGroup::getGroupArray(),
                "model" => Stat_CarModel::getModelArrayWithTopcar()
            );
            $dataMoto = array(
                "all" => Stat_MotoYear::getAllMotoData(),
                "brand" => Stat_MotoBrand::getBrandArray(),
                "group" => Stat_MotoGroup::getGroupArray(),
                "model" => Stat_MotoModel::getModelArray()
            );
            // ยกเลิกระบบ session ใส่ตัวแปร 'TypeVehicle', 'dataCar', 'dataMoto' เข้าไปใน view ทุกโซนแล้ว
            if ($request->zone == 10) {
                $tags = Data_CusTags::where('id', $request->id)->first();
                $TypeLoan = TB_TypeLoanCom::generateQuery();
                $typeCus = TB_StatusCustomers::generateQuery();
                $dataPro = TB_Promotios::generateQuery();

                // flag btn view customer
                if (!empty(@$request->FlagPage)) {
                    session()->put('btn_flagCal', true);
                } else {
                    session()->forget('btn_flagCal');
                }

                // $disable = '';
                // if (!empty(@$request->idCont)) {
                //     $Contract = Pact_Contracts::where('id', $request->idCont)
                //         ->where('Status_Con', 'complete')
                //         ->first();
                // }

                // if (@$data->DataCusTagToContracts != NULL) {
                //     $disable = "disabled";
                // }

                $datatypeCar = null;
                if (@$tags->TagToCulculate->TypeLoans != NULL) {
                    $value = @$tags->TagToCulculate->TypeLoans;

                    $datatypeCar = Stat_rateType::where('type_car', $value)->get();
                }

                return view('components.content-calcufinance.Calculate_PTN.view', compact('tags', 'TypeLoan', 'typeCus', 'dataPro', 'datatypeCar', 'TypeVehicle', 'dataCar', 'dataMoto'));
            } elseif ($request->zone == 20) {
                $tags = Data_CusTags::where('id', $request->id)->first();
                $dataPro = TB_Promotios::generateQuery();
                $TypeLoan = TB_TypeLoanCom::generateQuery();
                $TypeAssetsPoss = TB_TypeAssetsPoss::get();
                $typeCus = TB_StatusCustomers::generateQuery();

                $type = $request->type;
                $disable = "";
                $year = NULL;

                if ($request->FlagPage != NULL) {
                    $FlagPage = 'Y';
                } else {
                    $FlagPage = NULL;
                }

                if (@$tags->DataCusTagToContracts != NULL) {
                    $disable = "disabled";
                }

                $datatypeCar = "";
                if (@$tags->TagToCulculate->TypeLoans != NULL) {
                    $value = @$tags->TagToCulculate->TypeLoans;

                    $datatypeCar = Stat_rateType::where('type_car', $value)->get();
                }

                // โชว์เรท LTV ตอนเปิดครั้งแรก
                if (@$tags->TagToCulculate->RateYears != NULL) {
                    if (@$tags->TagToCulculate->TypeLoans == 'moto') {
                        $Searchyear = Stat_MotoYear::find(@$tags->TagToCulculate->RateYears);
                        $year = $Searchyear->Year_moto;
                    } else {
                        $Searchyear = Stat_CarYear::find(@$tags->TagToCulculate->RateYears);
                        $year = $Searchyear->Year_car;
                    }
                }
                // $LTVCAR = @$tags->TagToCulculate->DataCalcuToRateHYLTVCAR->LTVCode;

                if (@$tags->TagToCulculate->CodeLoans != 03 && $year != NULL) {
                    $RateBrands = @$tags->TagToCulculate->RateBrands;
                    $LTVCAR = Rate_HY_LTVCAR::orwhereRaw("FlagCar = 'Cartypes-" . @$tags->TagToCulculate->RateCartypes . "' and Year_Start is NULL and Year_End is NULL")
                        ->orwhereRaw("FlagCar = 'Brands-" . @$tags->TagToCulculate->RateBrands . "' and Year_Start is NULL and Year_End is NULL")
                        ->when(@$tags->TagToCulculate->RateCartypes != 'C06', function ($q) use ($RateBrands, $year) {
                            return $q->orwhereRaw("FlagCar = 'Brands-" . $RateBrands . "' and ? between Year_Start and Year_End", [@$year]);
                        })
                        // ->orwhereRaw("FlagCar = 'Brands-".$request->RateBrands."' and ? between Year_Start and Year_End", [@$year])
                        ->orwhereRaw("FlagCar = 'Cartypes-" . @$tags->TagToCulculate->RateCartypes . "' and ? between Year_Start and Year_End", [@$year])
                        ->orwhereRaw("FlagCar = 'Brands-" . $RateBrands . ",Cartypes-" . @$tags->TagToCulculate->RateCartypes . "' and Year_Start is NULL and Year_End is NULL")
                        ->first();
                } else {
                    $LTVCAR = NULL;
                }
                $ArrTypeAssetsPoss = [
                    'รถกรรมสิทธิ์' => 'APS-0001',
                    'รถซื้อขาย' => 'APS-0002',
                    'รถรีไฟแนนซ์' => 'APS-0003',
                ];
                $ArrLand = ['04', '15', '16', '18'];
                $TypeLeasing = @$tags->TagToCulculate->CodeLoans;
                $TagTypeAssetsPoss = @$ArrTypeAssetsPoss[@$tags->TagToCulculate->TypeAssetsPoss];

                if (in_array($TypeLeasing, $ArrLand) == false && $request->FlagPage != 'Y') {
                    if (@$LTVCAR->LTVCarToLTV != NULL) {
                        $txtCar = 'จัดอยู่ในรุ่นเรทต่ำ*';
                        $LTVCode = @$LTVCAR->LTVCode;
                        $LTV = @$LTVCAR->LTVCarToLTV->filter(function ($query) use ($LTVCode, $TypeLeasing, $TagTypeAssetsPoss) {
                            return $query->LTVCode == $LTVCode && $query->TypeLeasing == $TypeLeasing && $query->TypeFn == $TagTypeAssetsPoss;
                        })->sortBy('OcuStart');
                    } else {
                        $LTVCode = 'LTV-001';
                        $txtCar = NULL;
                        $LTV = Rate_HY_LTV::where('LTVCode', $LTVCode)->where('TypeLeasing', $TypeLeasing)->where('TypeFn', $TagTypeAssetsPoss)->get();
                    }
                } else {
                    $LTV = NULL;
                    $txtCar = NULL;
                }



                // ตารางค่างวด ตอนเปิดครั้งแรก
                // dd(@$tags->TagToCulculate->RateYears);
                // $year = @$tags->TagToCulculate->DataCalcuToCarYear->Year_car;
                $CodeLoans = @$tags->TagToCulculate->CodeLoans;

                if ($CodeLoans == 04 || $CodeLoans == 15 || $CodeLoans == 16 || $CodeLoans == 18) {
                    $txtCar = NULL;
                    $Flagdata = @$tags->TagToCulculate->DataCalcuToInterestHY;
                    if ($Flagdata != NULL) {
                        $data = $Flagdata->filter(function ($query) use ($CodeLoans) {
                            return $query->Type_Leasing == $CodeLoans;
                        });
                    } else {
                        $data = NULL;
                    }
                } else {
                    if ($CodeLoans == 01) {
                        $Flagdata = @$tags->TagToCulculate->DataCalcuToInterestHY01;
                    } else {
                        $Flagdata = @$tags->TagToCulculate->DataCalcuToInterestHY;
                    }
                    if ($Flagdata != NULL) {
                        $data = $Flagdata->filter(function ($query) use ($year) {
                            return $year <= $query->Year_End && $year >= $query->Year_Start;
                        });
                    } else {
                        $data = NULL;
                    }
                }
                // dd($year,$data,$Flagdata != NULL);
                @$Date_con = @$tags->TagToContracts->Date_con;
                $Type_Customer = @$tags->Type_Customer;
                $RatePrices = @$tags->TagToCulculate->RatePrices;
                $Buy_PA = @$tags->TagToCulculate->Buy_PA;
                $Include_PA = @$tags->TagToCulculate->Include_PA;
                $Cash_Car = @$tags->TagToCulculate->Cash_Car;
                $operate_fees = @$tags->TagToCulculate->Process_Car;
                $statusOPR = @$tags->TagToCulculate->StatusProcess_Car;
                $Timelack_Car = @$tags->TagToCulculate->Timelack_Car;
                $Interest_Car = number_format(@$tags->TagToCulculate->Interest_Car, 2);
                // $dataPA = TB_InsurancePA::where('DateEnd','<=',$Date_con)->orderBy('Limit_Insur', 'asc')->get();
                // $dataPA = TB_InsurancePA::whereRaw('? between DateStart and DateEnd', [$Date_con ?? $tags->date_Tag])->orderBy('Limit_Insur', 'asc')->get();
                $dataPA = TB_InsurancePA::orderBy('Limit_Insur', 'asc')->get();

                return view('components.content-calcufinance.Calculate_HY.viewModal_HY', compact('type', 'TypeLoan', 'TypeAssetsPoss', 'dataPro', 'tags', 'disable', 'FlagPage', 'datatypeCar', 'LTV', 'RatePrices', 'txtCar', 'data', 'Buy_PA', 'Include_PA', 'Cash_Car', 'operate_fees', 'statusOPR', 'dataPA', 'Timelack_Car', 'Interest_Car', 'typeCus', 'Type_Customer', 'TypeVehicle', 'dataCar', 'dataMoto'));
            } elseif ($request->zone == 30) {
                $tags = Data_CusTags::where('id', $request->id)->first();
                $dataPro = TB_Promotios::generateQuery();
                $TypeLoan = TB_TypeLoanCom::generateQuery();
                $TypeAssetsPoss = TB_TypeAssetsPoss::get();
                $typeCus = TB_StatusCustomers::generateQuery();
                $type = $request->type;
                $disable = "";
                $year = NULL;

                if ($request->FlagPage != NULL) {
                    $FlagPage = 'Y';
                } else {
                    $FlagPage = NULL;
                }

                if (@$tags->DataCusTagToContracts != NULL) {
                    $disable = "disabled";
                }

                $datatypeCar = "";

                if (@$tags->TagToCulculate->TypeLoans != NULL) {
                    $value = @$tags->TagToCulculate->TypeLoans;

                    $datatypeCar = Stat_rateType::where('type_car', $value)->get();
                }
                // else{
                //     $datatypeCar = Stat_rateType::get();
                // }


                // โชว์เรท LTV ตอนเปิดครั้งแรก
                if (@$tags->TagToCulculate->RateYears != NULL) {
                    if (@$tags->TagToCulculate->TypeLoans == 'moto') {
                        $Searchyear = Stat_MotoYear::find(@$tags->TagToCulculate->RateYears);
                        $year = $Searchyear->Year_moto;
                    } else {
                        $Searchyear = Stat_CarYear::find(@$tags->TagToCulculate->RateYears);
                        $year = $Searchyear->Year_car;
                    }
                }
                // $LTVCAR = @$tags->TagToCulculate->DataCalcuToRateHYLTVCAR->LTVCode;

                if (@$tags->TagToCulculate->CodeLoans != 03) {
                    $LTVCAR = Rate_NK_LTVCAR::orwhereRaw("FlagCar = 'Cartypes-" . @$tags->TagToCulculate->RateCartypes . "' and Year_Start is NULL and Year_End is NULL")
                        ->orwhereRaw("FlagCar = 'Brands-" . @$tags->TagToCulculate->RateBrands . "' and Year_Start is NULL and Year_End is NULL")
                        ->orwhereRaw("FlagCar = 'Brands-" . @$tags->TagToCulculate->RateBrands . "' and ? between Year_Start and Year_End", [@$year])
                        ->orwhereRaw("FlagCar = 'Cartypes-" . @$tags->TagToCulculate->RateCartypes . "' and ? between Year_Start and Year_End", [@$year])
                        ->orwhereRaw("FlagCar = 'Brands-" . @$tags->TagToCulculate->RateBrands . ",Cartypes-" . @$tags->TagToCulculate->RateCartypes . "' and Year_Start is NULL and Year_End is NULL")
                        ->first();
                } else {
                    $LTVCAR = NULL;
                }

                $ArrTypeAssetsPoss = [
                    'รถกรรมสิทธิ์' => 'APS-0001',
                    'รถซื้อขาย' => 'APS-0002',
                    'รถรีไฟแนนซ์' => 'APS-0003',
                ];
                $ArrLand = ['04', '15', '16', '18'];
                $TypeLeasing = @$tags->TagToCulculate->CodeLoans;
                $TagTypeAssetsPoss = @$ArrTypeAssetsPoss[@$tags->TagToCulculate->TypeAssetsPoss];

                if (in_array($TypeLeasing, $ArrLand) == false && $request->FlagPage != 'Y') {
                    if (@$LTVCAR->LTVCarToLTV != NULL) {

                        $txtCar = 'จัดอยู่ในรุ่นเรทต่ำ*';
                        $LTVCode = @$LTVCAR->LTVCode;
                        $LTV = @$LTVCAR->LTVCarToLTV->filter(function ($query) use ($LTVCode, $TypeLeasing, $TagTypeAssetsPoss) {
                            return $query->LTVCode == $LTVCode && $query->TypeLeasing == $TypeLeasing && $query->TypeFn == $TagTypeAssetsPoss;
                        });
                    } else {
                        $LTVCode = 'LTV-001';
                        $txtCar = NULL;
                        $LTV = Rate_NK_LTV::where('LTVCode', $LTVCode)->where('TypeLeasing', $TypeLeasing)->where('TypeFn', $TagTypeAssetsPoss)->get();
                    }
                } else {
                    $LTV = NULL;
                    $txtCar = NULL;
                }


                // ตารางค่างวด ตอนเปิดครั้งแรก
                // $year = @$tags->TagToCulculate->DataCalcuToCarYear->Year_car;
                $CodeLoans = @$tags->TagToCulculate->CodeLoans;

                if ($CodeLoans == 04 || $CodeLoans == 15 || $CodeLoans == 16 || $CodeLoans == 18) {
                    $txtCar = NULL;
                    $Flagdata = @$tags->TagToCulculate->DataCalcuToInterestNK;
                    $Type_Customer = @$tags->Type_Customer == 'CUS-0004' ? @$tags->Type_Customer : NULL;
                    $TypeCusGood = @$tags->TagToCulculate->TypeCusGood == 'yes' ? 'yes' : NULL;
                    if ($Flagdata != NULL) {

                        $data = $Flagdata->filter(function ($query) use ($CodeLoans, $Type_Customer, $TypeCusGood) {
                            // return  $query->Type_Leasing == $CodeLoans && $query->Status_Code == $Type_Customer ;

                            if ($TypeCusGood == NULL) {
                                return $query->Type_Leasing == $CodeLoans && $query->Status_Code == NULL;
                            } else {
                                return $query->Type_Leasing == $CodeLoans && $query->Status_Code == 'CUS-0004';
                            }
                        });
                    } else {
                        $data = NULL;
                    }
                } else {
                    $Type_Customer = @$tags->Type_Customer == 'CUS-0004' ? @$tags->Type_Customer : NULL;
                    $TypeCusGood = @$tags->TagToCulculate->TypeCusGood == 'yes' ? 'yes' : NULL;
                    if ($CodeLoans == 01) {
                        $Flagdata = @$tags->TagToCulculate->DataCalcuToInterestNK01;
                    } else {
                        $Flagdata = @$tags->TagToCulculate->DataCalcuToInterestNK;
                    }

                    if ($Flagdata != NULL) {
                        $data = $Flagdata->filter(function ($query) use ($year, $Type_Customer, $TypeCusGood) {

                            if ($TypeCusGood == NULL) {
                                return $year <= $query->Year_End && $year >= $query->Year_Start && $query->Status_Code == NULL;
                            } else {
                                return $year <= $query->Year_End && $year >= $query->Year_Start && $query->Status_Code == $Type_Customer;
                            }
                        });
                    } else {
                        $data = NULL;
                    }
                }
                $IntSpecial = @$tags->TagToCulculate->Interest_Car;
                @$Date_con = @$tags->TagToContracts->Date_con;
                $Type_Customer = @$tags->Type_Customer;
                $RatePrices = @$tags->TagToCulculate->RatePrices;
                $Buy_PA = @$tags->TagToCulculate->Buy_PA;
                $Include_PA = @$tags->TagToCulculate->Include_PA;
                $Cash_Car = @$tags->TagToCulculate->Cash_Car;
                $operate_fees = @$tags->TagToCulculate->Process_Car;
                $statusOPR = @$tags->TagToCulculate->StatusProcess_Car;
                $Timelack_Car = @$tags->TagToCulculate->Timelack_Car;
                $Interest_Car = number_format(@$tags->TagToCulculate->Interest_Car, 2);

                // $dataPA = TB_InsurancePA::where('flag', 'yes')->orderBy('Limit_Insur', 'asc')->get();
                // $dataPA = TB_InsurancePA::whereRaw('? between DateStart and DateEnd', [@$Date_con ?? $tags->date_Tag])->orderBy('Limit_Insur', 'asc')->get();
                $dataPA = TB_InsurancePA::orderBy('Limit_Insur', 'asc')->get();


                return view('components.content-calcufinance.Calculate_NK.viewModal_NK', compact('type', 'TypeLoan', 'TypeAssetsPoss', 'dataPro', 'tags', 'disable', 'FlagPage', 'datatypeCar', 'LTV', 'RatePrices', 'txtCar', 'data', 'Buy_PA', 'Include_PA', 'Cash_Car', 'operate_fees', 'statusOPR', 'dataPA', 'Timelack_Car', 'Interest_Car', 'typeCus', 'Type_Customer', 'TypeVehicle', 'dataCar', 'dataMoto', 'IntSpecial',));
            } elseif ($request->zone == 40) {
                $tags = Data_CusTags::where('id', $request->id)->first();
                $dataPro = TB_Promotios::generateQuery();
                $TypeLoan = TB_TypeLoanCom::generateQuery();
                $typeCus = TB_StatusCustomers::generateQuery();
                $TypeAssetsPoss = TB_TypeAssetsPoss::get();

                $Limit_Insur = 0;
                if (@$tags != NULL) {
                    foreach (@$tags->TagToDataCus->DataCusToDataCusTag as $dataTaag) {
                        if ($dataTaag->Status_Tag == 'complete' && ($dataTaag->TagToContracts->Status_Con <> 'cancel' && $dataTaag->TagToContracts->Date_monetary != NULL)) {
                            $Limit_Insur = $Limit_Insur + @$dataTaag->TagToCulculate->DataCalcuToPA->Limit_Insur;
                        }
                    }
                }

                $type = $request->type;
                $disable = "";
                $year = NULL;

                if ($request->FlagPage != NULL) {
                    $FlagPage = 'Y';
                } else {
                    $FlagPage = NULL;
                }

                if (@$tags->DataCusTagToContracts != NULL) {
                    $disable = "disabled";
                }

                $datatypeCar = NULL;
                if (@$tags->TagToCulculate->TypeLoans != NULL) {
                    $value = @$tags->TagToCulculate->TypeLoans;

                    $datatypeCar = Stat_rateType::where('type_car', $value)->get();
                }
                // dd($datatypeCar);

                return view('components.content-calcufinance.Calculate_KB.viewModal_KB', compact('type', 'TypeLoan', 'datatypeCar', 'TypeAssetsPoss', 'dataPro', 'tags', 'disable', 'FlagPage', 'typeCus', 'Limit_Insur', 'TypeVehicle', 'dataCar', 'dataMoto'));
            } elseif ($request->zone == 50) {
                $typeCus = TB_StatusCustomers::generateQuery();
                $tags = Data_CusTags::where('id', $request->id)->first();
                $dataPro = TB_Promotios::generateQuery();
                $TypeLoan = TB_TypeLoanCom::generateQuery();
                $InterstRule = Rate_SR_InterestCars01::where('Flag', 'yes')
                    ->leftJoin('TB_TypeLoans', function ($query) {
                        return $query->on('TB_TypeLoans.id', 'Rate_SR_InterestCars01.TypeLoan_Id');
                    })->select('Loan_Code', 'TypeLoan_Id', 'Rating', 'Cond_OccupiedTime', 'Cond_YearStart', 'Cond_YearEnd', 'Cond_InstallmentStart', 'Cond_InstallmentEnd', 'Cond_TotalStart', 'Cond_TotalEnd', 'Interest', 'Fee_Rate', 'Fee_Min', 'Fee_Max', 'Fine_Rate', 'Installment_REC', 'Credo_Cond', 'Credo_BonusLTV')->get();

                // $Date_con = @$tags->TagToContracts->Date_con;
                // $insurPrice = TB_InsurancePA::whereRaw('? between DateStart and DateEnd', [@$Date_con ?? @$tags->date_Tag])->orderBy('Limit_Insur', 'asc')->get();
                // $insurPrice = TB_InsurancePA::where('flag', 'yes')->orderBy('Limit_Insur', 'asc')->get();
                $insurPrice = TB_InsurancePA::orderBy('Limit_Insur', 'asc')->get();
                $typeRate = Stat_rateType::getRateTypeArray();
                $ltv_table = Rate_SR_LTV::where('Status_LTV', 'active')->get();
                $ltv_rate = Rate_SR_LTV_Reference::where('Status', 'active')->get();
                $typeAsset = TB_TypeAssets::select('Code_TypeAsset', 'CodeId_TypeAsset')->pluck('CodeId_TypeAsset', 'Code_TypeAsset');

                if (!empty(@$request->idCont)) {
                    $idCont = @$request->idCont;
                } else {
                    $idCont = null;
                }

                $type = $request->type;
                $disable = "";
                if (@$tags->TagToCulculate != NULL) {
                    $disable = "disabled";
                }

                //---------------------------------------------------------
                // datatypeCar กับ asset ไว้ใช้ตอนแก้ไขหน้าคำนวณ
                // จะเป็นตัวแปรทำให้สร้าง dropdown ประเภทรถเริ่มต้นให้อัติโนมัติ
                $datatypeCar = null;
                $asset = null;
                if (@$tags->TagToCulculate->TypeLoans != NULL) {
                    $_type_car = @$tags->TagToCulculate->TypeLoans;
                    $datatypeCar = Stat_rateType::where('type_car', $_type_car)->get();
                    $asset = $_type_car;
                }
                //---------------------------------------------------------

                return view('components.content-calcufinance.Calculate_SR.viewModal_SR', compact('type', 'typeCus', 'TypeLoan', 'InterstRule', 'tags', 'idCont', 'disable', 'insurPrice', 'dataPro', 'typeRate', 'ltv_table', 'ltv_rate', 'typeAsset', 'datatypeCar', 'asset', 'TypeVehicle', 'dataCar', 'dataMoto'));
            }
        } elseif ($request->funs == 'check-datacus') {
            $microlist = ['11', '12', '13', '17'];
            $data = Data_Customers::where('id', $request->idCus)
                ->whereNotNull('IDCard_cus')
                ->whereNotNull('IdcardExpire_cus')
                ->whereNotNull('Type_Card')
                ->whereNotNull('Birthday_cus')
                ->whereNotNull('Phone_cus')
                ->first();

            if ($data) {
                $asset = $data->DataCusToAssetOwnership->whereIn('State_Ownership', ['Active', 'Transfer']);

                if (empty($data->CusToCusTagOne->Credo_Status)) {
                    $message = 'กรุณา active credo ก่อนส่งจัดไฟแนนซ์ !';
                    return response()->json(['message' => $message, 'code' => 428], 500);
                } elseif (empty($data->CusToCusTagOne->TagToCulculate)) {
                    $message = 'กรุณา คำนวณสินเชือ ก่อนส่งจัดไฟแนนซ์ !';
                    return response()->json(['message' => $message, 'code' => 428], 500);
                } else {

                    if ($asset->isEmpty() && in_array($data->CusToCusTagOne->TagToCulculate->CodeLoans, $microlist) == false) {
                        return response()->json(['message' => 'ไม่พบข้อมูลสินทรัพย์ กรุณาเพิ่มข้อมูลสินทรัพย์ !', 'code' => 428], 500);
                    }

                    $ExpireCard = (isCardExpired($data->IdcardExpire_cus) ? null : true);
                    $filterAdds = (empty($data->DataCusToDataCusAdds) ? null : true);

                    if (@$data->DataCusToDataCusAddsMany != null) {
                        $checkAdds = @$data->DataCusToDataCusAddsMany->filter(function ($query) {
                            return (@$query->Type_Adds == 'ADR-0001' || @$query->Type_Adds == 'ADR-0002') && @$query->Status_Adds == 'active';
                        });
                    }
                    $filterCareer = (empty($data->DataCusToDataCusCareer) ? null : true);

                    if (!$ExpireCard) {
                        $ResponseErr = 'err';
                        $ExpireCard = 'บัตรประชาชนลูกค้า ใกล้หมดอายุหรือหมดอายุแล้ว';
                    }
                    // if (!$filterAdds) {
                    //     $ResponseErr = 'err';
                    //     $filterAdds = 'กรุณาเพิ่ม ข้อมูลที่อยู่ลูกค้า';
                    // }
                    if (count(@$checkAdds) < 2) {
                        $ResponseErr = 'err';
                        $filterAdds = 'กรุณาเพิ่ม ที่อยู่ปัจจุบัน และที่อยู่ส่งเอกสารของลูกค้า ก่อนส่งจัดไฟแนนซ์';
                    }
                    if (!$filterCareer) {
                        $ResponseErr = 'err';
                        $filterCareer = 'กรุณาเพิ่ม ข้อมูลอาชีพลูกค้า';
                    }

                    if (isset($ResponseErr)) {
                        return response()->json(['ExpireCard' => $ExpireCard, 'filterAdds' => $filterAdds, 'filterCareer' => $filterCareer, 'code' => 406], 500);
                    } else {

                        $userApp = $this->getUsersByRoles(auth()->user()->zone, $request->tag_id);
                        return response()->json(['userApp' => $userApp, 'code' => 200], 200);
                    }
                }
            } else {
                $code = 401;
                $message = 'กรุณาตรวจสอบ ข้อมูลลูกค้าก่อนส่งจัดไฟแนนซ์ !';
                return response()->json(['message' => $message, 'code' => $code], 500);
            }
        } elseif ($request->funs == 'sendPaAgain') {
            $data = Pact_Contracts::find($request->id_con);
            if (true) {
                $callAgent = $data->ContractToAgent;
            }
            \ChubbApiRequest::sendAndGetPA($callAgent->Producercode, $data);
        }
    }

    public function SearchData(Request $request)
    {
        if ($request->funs == 'rate') {
            $asset = $request->asset;
            $value = $request->value;

            $v_select = @$request->v_RateCartypes;

            $TypeVehicle = TB_TypeVehicle::where('Flag_Vehicle', 'yes')->get()->toArray();
            $datatypeCar = Stat_rateType::where('type_car', $value)->get();

            if ($asset == 'car') {
                $optiontypeCar = '<option value="" selected>--- ประเภทรถ ---</option>';
            } elseif ($asset == 'moto') {
                $optiontypeCar = '<option value="" selected>--- เกียร์รถ ---</option>';
            } elseif ($asset == 'land') {
                $optiontypeCar = '<option value="" selected>--- ประเภทที่ดิน ---</option>';
            } elseif ($asset == 'person') {
                $optiontypeCar = null;
            }

            foreach ($datatypeCar as $typeCar) {
                if ($typeCar->code_car == $v_select) {
                    $selected = "selected";
                } else {
                    $selected = "";
                }
                $optiontypeCar .= "<option value=" . $typeCar->code_car . " " . $selected . ">" . $typeCar->nametype_car . "</option>";
            }

            return $optiontypeCar;
        }

        if ($request->type == 1) { //Search Address
            if ($request->Flag == 1) { //ภาค
                $data = TB_Provinces::where('Zone_pro', $request->value)
                    ->selectRaw('Province_pro, count(*) as total')
                    ->groupBy('Province_pro')
                    ->orderBY('Province_pro', 'ASC')
                    ->get();
            } elseif ($request->Flag == 2) { //จังหวัด
                $data = TB_Provinces::where('Province_pro', $request->value)
                    ->selectRaw('District_pro, count(*) as total')
                    ->groupBy('District_pro')
                    ->orderBY('District_pro', 'ASC')
                    ->get();
            } elseif ($request->Flag == 3) { //อำเภอ
                $data = TB_Provinces::where('District_pro', $request->value)
                    ->selectRaw('Tambon_pro, count(*) as total')
                    ->groupBy('Tambon_pro')
                    ->orderBY('Tambon_pro', 'ASC')
                    ->get();
            } elseif ($request->Flag == 4) { //ตำบล
                $data = TB_Provinces::where('Tambon_pro', $request->value)
                    ->where('District_pro', $request->District)
                    ->where('Province_pro', $request->Province)
                    ->select('Postcode_pro')
                    ->first();
            }
            return response()->json($data);
        } elseif ($request->type == 2) { //Search user branch
            $value = explode("-", $request->value);
            $idBranch = $value[0];

            $data = User::QueryUserApproved($idBranch, $request->tagId, $request->codeloan);
            return response()->json($data);
        } elseif ($request->type == 3) { //Search Score Credo
            DB::beginTransaction();
            try {
                $dataCredo = Data_CredoCodes::where('statusActive', 'N')->where('tel_cus', $request->PhoneNumber)->first();
                if (!isset($dataCredo)) {
                    return response()->json(['credoCode' => null, 'credoScore' => 0], 200);
                    // return response()->json(['title' => 'ไม่พบข้อมูล', 'massage' => 'เบอร์โทรศัพท์นี้ยังไม่ลงทะเบียน โปรดตรวจสอบใหม่อีกครั้ง !'], 500);
                } else {
                    if ($dataCredo->credo_flag != 'Y') {
                        $Score = ConnectCredo::postScore($dataCredo->credo_code);
                        $Credo_Status = null;

                        if ($Score['statusCode'] == 200) {
                            $chk_inLog = Data_CredoFragments::where('referenceNumber', $dataCredo->credo_code)->first();
                            if (empty($chk_inLog)) {
                                $fragments = $Score['data']['fragments'];

                                $data_Fragment = new Data_CredoFragments;
                                $data_Fragment->referenceNumber = @$Score['data']['datasetInfo']['referenceNumber'];
                                $data_Fragment->uploadDate = @$Score['data']['datasetInfo']['uploadDate'];
                                $data_Fragment->device_id = @$Score['deviceId'];
                                $data_Fragment->scores = ($Score['GetScore'] != 0) ? json_encode($Score['data']['scores']) : 0;
                                for ($i = 0; $i < 10; $i++) {
                                    $data_Fragment->{'fragments' . ($i + 1)} = (isset($fragments[$i])) ? json_encode($fragments[$i]) : null;
                                }
                                $data_Fragment->save();
                            }

                            $Credo_Status = 'CD-0005';
                            $Credo_Date = date('Y-m-d H:i:s');
                            $Credo_Score = @$Score['data']['scores'][1]['value'];
                            $Credo_Score2 = @$Score['data']['scores'][0]['value'];
                        } else {
                            $Credo_Status = null;
                            $Credo_Date = null;
                            $Credo_Score = 0;
                            $Credo_Score2 = 0;
                        }

                        // update data credo
                        $dataCredo->Credo_Status = @$Credo_Status;
                        $dataCredo->Credo_Date = @$Credo_Date;
                        $dataCredo->credo_score = @$Credo_Score;
                        $dataCredo->credo_score2 = @$Credo_Score2;
                    } else {
                        $Credo_Date = $dataCredo->credo_date;
                        $Credo_Score = $dataCredo->credo_score;
                        $Credo_Score2 = $dataCredo->credo_score2;
                        $Credo_Status = 'CD-0005';
                    }
                    $dataTag = Data_CusTags::where('id', $request->tag)->first();
                    $dataTag->Credo_Code = $dataCredo->credo_code;
                    $dataTag->Credo_Score = @$Credo_Score;
                    $dataTag->Credo_Score2 = @$Credo_Score2;
                    $dataTag->Credo_Date = @$Credo_Date;
                    $dataTag->Credo_Status = @$Credo_Status;
                    $dataTag->update();

                    $dataCredo->data_tag_id = $dataTag->id;
                    $dataCredo->credo_flag = 'Y';
                    $dataCredo->statusActive = 'Y';
                    $dataCredo->update();
                    DB::commit();

                    return response()->json(['credoCode' => $dataCredo->credo_code, 'credoScore' => $Credo_Score], 200);
                }
            } catch (\Exception $e) {
                DB::rollBack();

                return response()->json(['title' => 'ระบบล้มเหลว', 'massage' => 'การเชื่อมต่อล้มเหลว โปรดลองอีกครั้ง'], 500);
            }
        } elseif ($request->funs == 'CalKB') { //Search Interest KB
            if ($request->Flagtag == 1) {
                $zone = auth()->user()->zone;
                $TypeLoans = $request->TypeLoans;
                $Type_Customer = $request->Type_Customer;
                $typeAsset = $request->typeAsset;
                $yearAsset = $request->yearAsset;
                $TypeAssetsPoss = $request->TypeAssetsPoss;
                $numDateOccupiedcar = $request->numDateOccupiedcar;
                $DateOldCon = $request->DateOldCon;
                $Payment_Status = $request->Payment_Status;
                $cus_grade = $request->cus_grade;
                $Interest_old = $request->Interest_old;

                $typeLoan = TB_TypeLoan::where('Loan_Code', $request->TypeLoans)->first();
                $Credo_rate = Config_Credos::where('UserZone', $zone)
                    ->where('status', 'Y')->first();
                $credo_score = @$Credo_rate->Score_rate == NULL ? 0 : @$Credo_rate->Score_rate;
                $Credo_percen = @$Credo_rate->Percen_rate == NULL ? 0 : @$Credo_rate->Percen_rate;


                $dataType = Rate_KB_InterestCars01:: //->where('Status_Code','=',$CustomerType)
                    when($Type_Customer != 'CUS-0009' && ($TypeLoans == '02' && $Type_Customer != 'CUS-0006'), function ($q) use ($Type_Customer, $yearAsset) {
                        return $q->where('Status_Code', '=', $Type_Customer)->whereRaw('? between Car_yearS and Car_yearE', [$yearAsset]);
                    })
                    ->when($TypeLoans == '02' && $Type_Customer == 'CUS-0006', function ($q) use ($Type_Customer, $TypeLoans, $yearAsset) {
                        return $q->where('Status_Code', '=', 'CUS-0001')->whereRaw('? between Car_yearS and Car_yearE', [$yearAsset]);
                    })
                    ->when($TypeLoans != '02', function ($q) use ($Type_Customer) {
                        return $q->where('Status_Code', '=', $Type_Customer);
                    })
                    // ->when(($typeAsset=='C05' || $typeAsset=='C02' ) && $TypeLoans == '02' ,  function($q) use ($typeAsset) {
                    //         return $q->where('Group_Cartype','LIKE',"%{$typeAsset}%")->whereNotNull('Group_Cartype');
                    //     })
                    // ->when($typeAsset!='C05' && $typeAsset!='C02' && $TypeLoans == '02' , function($q) use ($typeAsset) {
                    //         return $q->whereNull('Group_Cartype');
                    //     })
                    ->when(!empty($cus_grade) && ($TypeLoans == '02' && $Type_Customer != 'CUS-0006'), function ($q) use ($cus_grade) {
                        return $q->where('grade', '=', $cus_grade);
                    })

                    ->when(!empty($cus_grade) && $TypeLoans != '02', function ($q) use ($cus_grade) {
                        return $q->where('grade', '=', $cus_grade);
                    })
                    ->when(!empty($TypeAssetsPoss), function ($q) use ($TypeAssetsPoss) {
                        return $q->where('Possessiontypecar', '=', $TypeAssetsPoss);
                    })
                    ->when(!empty($Payment_Status), function ($q) use ($Payment_Status) {
                        return $q->where('Payment_Status', '=', $Payment_Status);
                    })

                    ->where('Type_leasing', '=', $TypeLoans)
                    ->where('Flag', '<>', 'no')
                    ->orderBy('Possession_month', 'ASC')->get();

                $dayarr = array(80, '0', '', '', '');

                $numOccInt = 0;
                //|| $Type_Customer == 'CUS-0008'
                // if (($Type_Customer == 'CUS-0006' ) && $TypeLoans == '02') {
                //     $numOccInt = $DateOldCon;
                // } else {
                $numOccInt = $numDateOccupiedcar;
                // }
                $Percen_Rate = 0;

                if (!empty($dataType)) {
                    foreach ($dataType as $row) {
                        if (intval($numOccInt) >= intval($row->Possession_month) || $TypeLoans == "17") {
                            //|| $Type_Customer == 'CUS-0008'

                            $Percen_Rate = $row->Percen_Rate;
                            $Interrests = $row->Interrests;
                            $chkIncome = $row->Text_alert;
                            $guarantee = $row->Text_alert2;
                            $Process_Rate = $row->Process_Rate;
                            $score = $credo_score;
                            $Installment = $row->Installment;
                            $Total_Rate = $row->Total_Rate;
                            $typeLoan_group = $typeLoan->Loan_Group;
                            $Adjusted = $row->Adjusted;
                            $dayarr = array($Percen_Rate, floatval($Interrests), $chkIncome, $guarantee, floatval($Process_Rate), $score, $Credo_percen, $Installment, $Total_Rate, $typeLoan_group, $Adjusted);
                            if (($Type_Customer == 'CUS-0006') && ($TypeLoans == '02' || $TypeLoans == '03')) {

                                $rate2 = Rate_KB_InterestCars02::where('Status_Code', $Type_Customer)
                                    ->when($cus_grade != NULL && ($TypeLoans == '02' || $TypeLoans == '03'), function ($q) use ($cus_grade) {
                                        return $q->where('Grade', '=', $cus_grade);
                                    })
                                    ->whereRaw(intval($numDateOccupiedcar) . '>=Possession_month')
                                    ->whereRaw('? between Car_yearS and Car_yearE', [$request->yearAsset])->first();
                                if ($rate2 != NULL) {
                                    $Percen_Rate = $Percen_Rate + $rate2->LTV;
                                    $Intrate = round($Interrests + $rate2->Interrest_car, 2);
                                    $Interrests = $Intrate;
                                    $chkIncome = $chkIncome;
                                    $guarantee = $guarantee;
                                    $Process_Rate = $Process_Rate;
                                    $score = $credo_score;
                                    $Installment = $Installment;
                                    $Total_Rate = $Total_Rate;
                                    $typeLoan_group = $typeLoan->Loan_Group;
                                    $Adjusted = $row->Adjusted;
                                    $dayarr = array($Percen_Rate, floatval($Interrests), $chkIncome, $guarantee, floatval($Process_Rate), $score, $Credo_percen, $Installment, $Total_Rate, $typeLoan_group, $Adjusted);
                                } else {

                                    $dayarr = array(80, '0', '', '', '');
                                }
                            }
                        } else {

                            break;
                        }
                    }
                } else {
                    $dayarr = array(80, '0', '', '', '');
                }
                return response()->json($dayarr);
            } elseif ($request->Flagtag == 2) {
                $dataPA = TB_InsurancePA::orderBy('Limit_Insur', 'asc')->get();
                $html = view('components.content-calcufinance.Calculate_KB.tb_install', compact('request', 'dataPA'))->render();

                return response()->json(['dataPA' => $dataPA, 'html' => $html]);
            } elseif ($request->Flagtag == 3) {
                $TypeLoans = @$request->TypeLoans;
                $dataCus_id = @$request->dataCus_id;
                $dataLastCon = DB::select("select top(1) b.CodeLoan_Con,b.Contract_Con,b.Date_monetary,c.totalInterest_Car from Data_Customers a
                left join Pact_Contracts b on a.id = b.DataCus_id
                left join Data_CusTagCalculates c on c.DataTag_id = b.DataTag_id
                where b.Date_monetary is not null and b.Status_Con <> 'cancel' and a.id ='" . $dataCus_id . "' and b.CodeLoan_Con = '" . $TypeLoans . "' order by b.id desc");

                return response()->json($dataLastCon);
            }
        } elseif ($request->funs == 'Interest-PTN') {
            if ($request->Flag == 1) {
                if ($request->CodeLoans == '01') { // installments
                    $data = DB::table('Rate_PTN_InterestCars01')
                        ->where('FlagRate', 'yes')
                        ->where('Ratetype_rate', $request->typeAsset)
                        ->whereRaw('? between YearStart_rate and YearEnd_rate', [$request->yearAsset])
                        ->orderBy('InstalmentEnd_rate', 'desc')
                        ->first();


                    return response()->json($data);
                } elseif ($request->CodeLoans == '02') {
                    # code...
                }
            } else {
                if ($request->CodeLoans == '01') { // Timelack_Car
                    if (!empty($request->Cal_id)) {
                        $calculate = Data_CusTagCalculate::where('id', $request->Cal_id)->first();
                        if (!empty(@$calculate)) {
                            if ($calculate->Date_Calcu <= '2023-01-14') {
                                $data = DB::table('Rate_PTN_InterestCars01')
                                    ->where('type_Instalment', '1')
                                    ->where('FlagRate', 'yes')
                                    ->where('Ratetype_rate', $request->typeAsset)
                                    ->whereRaw('? between YearStart_rate and YearEnd_rate', [(int) $request->yearAsset])
                                    ->whereRaw('? between InstalmentStart_rate and InstalmentEnd_rate', [(int) $request->Timelack])
                                    ->orderBy('Instalm entEnd_rate', 'desc')
                                    ->first();
                            } else {
                                $data = DB::table('Rate_PTN_InterestCars01')
                                    ->where('type_Instalment', '2')
                                    ->where('FlagRate', 'yes')
                                    ->whereRaw('? between InstalmentStart_rate and InstalmentEnd_rate', [(int) $request->Timelack])
                                    ->orderBy('InstalmentEnd_rate', 'asc')
                                    ->first();
                            }
                        }
                    } else {
                        $data = DB::table('Rate_PTN_InterestCars01')
                            ->where('type_Instalment', '2')
                            ->where('FlagRate', 'yes')
                            ->whereRaw('? between InstalmentStart_rate and InstalmentEnd_rate', [(int) $request->Timelack])
                            ->orderBy('InstalmentEnd_rate', 'asc')
                            ->first();
                    }
                } elseif ($request->CodeLoans == '02') {
                    $data = DB::table('Rate_PTN_InterestCars02')
                        ->where('FlagRate', 'yes')
                        ->whereRaw('? between InstalmentStart_rate and InstalmentEnd_rate', [(int) $request->Timelack])
                        ->orderBy('InstalmentEnd_rate', 'asc')
                        ->first();
                } elseif ($request->CodeLoans == '03') {
                    $data = DB::table('Rate_PTN_InterestCars03')
                        ->where('FlagRate', 'yes')
                        ->whereRaw('? between CashStart_rate and CashEnd_rate', [(int) $request->Cash_Car])
                        ->whereRaw('? between InstalmentStart_rate and InstalmentEnd_rate', [(int) $request->Timelack])
                        ->orderBy('InstalmentEnd_rate', 'asc')
                        ->first();
                } elseif ($request->CodeLoans == '04') {
                    $data = DB::table('Rate_PTN_InterestLand04')
                        ->where('FlagRate', 'yes')
                        ->where('InstalmentStart_rate', $request->Timelack)
                        ->orderBy('InstalmentStart_rate', 'desc')
                        ->first();
                }
                return response()->json($data);
            }
        } elseif ($request->funs == 'Interest-HYNK') { //Search Interest Hatyai/Nakon
            $tags = Data_CusTags::where('id', $request->DataTag_id)->first();
            if ($request->Flagtag == 1) { //Search Interest Hatyai
                $typeCus = ['CUS-0004', 'CUS-0005', 'CUS-0006'];
                if ($request->RateYears != NULL) {
                    if ($request->TypeLoans == 'moto') {
                        $Searchyear = Stat_MotoYear::find($request->RateYears);
                        $year = $Searchyear->Year_moto;
                    } else {
                        $Searchyear = Stat_CarYear::find($request->RateYears);
                        $year = $Searchyear->Year_car;
                    }
                }

                //  dd($request->CodeLoans,$request->TypeLoans,$request->ype_Leasing);
                if ($request->Type_Leasing != 03 && @$year != NULL) {
                    $RateBrands = $request->RateBrands;
                    $LTVCar = Rate_HY_LTVCAR::orwhereRaw("FlagCar = 'Cartypes-" . $request->RateCartypes . "' and Year_Start is NULL and Year_End is NULL")
                        ->orwhereRaw("FlagCar = 'Brands-" . $request->RateBrands . "' and Year_Start is NULL and Year_End is NULL")
                        ->when($request->RateCartypes != 'C06', function ($q) use ($RateBrands, $year) {
                            return $q->orwhereRaw("FlagCar = 'Brands-" . $RateBrands . "' and ? between Year_Start and Year_End", [@$year]);
                        })
                        // ->orwhereRaw("FlagCar = 'Brands-".$request->RateBrands."' and ? between Year_Start and Year_End", [@$year])
                        ->orwhereRaw("FlagCar = 'Cartypes-" . $request->RateCartypes . "' and ? between Year_Start and Year_End", [@$year])
                        ->orwhereRaw("FlagCar = 'Brands-" . $request->RateBrands . ",Cartypes-" . $request->RateCartypes . "' and Year_Start is NULL and Year_End is NULL")
                        ->first();
                } else {
                    $LTVCar = NULL;
                }
                $Type_Leasing = $request->CodeLoans;
                $Credo_Score = $request->Credo_Score;
                if ($Type_Leasing == 01) {
                    $data = Rate_HY_InterestCars1::where('Type_Leasing', $Type_Leasing)
                        ->whereRaw('? between Year_Start and Year_End', [$year])
                        ->get();
                } elseif ($Type_Leasing == 02 || $Type_Leasing == 06) {
                    $data = Rate_HY_InterestCars2::where('Type_Leasing', $Type_Leasing)
                        ->where('Flag', 'yes')
                        ->whereRaw('? between Year_Start and Year_End', [$year])
                        ->get();
                } elseif ($Type_Leasing == 04 || $Type_Leasing == 15 || $Type_Leasing == 16 || $Type_Leasing == 18 || $Type_Leasing == 11 || $Type_Leasing == 17) {
                    $data = Rate_HY_InterestCars2::where('Flag', 'yes')
                        ->where('Type_Leasing', $Type_Leasing)
                        ->get();
                } elseif ($Type_Leasing == 03) {
                    $data = Rate_HY_InterestCars2::where('Flag', 'yes')
                        ->where('Type_Leasing', $Type_Leasing)
                        ->whereRaw('? between Year_Start and Year_End', [$year])
                        ->get();
                }

                //get LTV
                if ($request->LTV == 'getLTV') {
                    if ($LTVCar != NULL) { // เทียบรุ่นรถเรทต่ำ ว่าตรงกันกับใน DB หรือไม่ ถ้าตรง...
                        $dataLTV = $LTVCar->LTVCarToLTV;
                        $Type_Leasing = $request->Type_Leasing;
                        $Type_Customer = $request->Type_Customer;
                        $LTVCode = $LTVCar->LTVCode;
                        $TypeAssetCode = $request->TypeAssetCode;

                        if (in_array($Type_Customer, $typeCus)) { // กรณีเป็น refinance
                            $LTV = $dataLTV->filter(function ($query) use ($LTVCode, $Type_Leasing, $TypeAssetCode) {
                                return $query->LTVCode == $LTVCode && $query->TypeLeasing == $Type_Leasing && $query->TypeFn == $TypeAssetCode;
                            })->sortBy('OcuStart');
                        } else {
                            $LTV = $dataLTV->filter(function ($query) use ($LTVCode, $Type_Leasing, $TypeAssetCode) {
                                return $query->LTVCode == $LTVCode && $query->TypeLeasing == $Type_Leasing && $query->TypeFn == $TypeAssetCode;
                            })->sortBy('OcuStart');
                        }

                        $txtCar = 'จัดอยู่ในรุ่นเรทต่ำ*';
                        $RatePrices = str_replace(',', '', $request->RatePrices);
                        $html = view('components.content-calcufinance.Calculate_HY.LTV-Rate', compact('LTV', 'RatePrices', 'txtCar', 'Credo_Score', 'Type_Customer'))->render();
                        return response()->json(['html' => $html]);
                    } else {
                        if (in_array($request->Type_Customer, $typeCus)) { // กรณีเป็น refinance
                            $LTV = Rate_HY_LTV::where('TypeFn', $request->TypeAssetCode)
                                ->where('LTVCode', 'LTV-001')
                                ->where('TypeLeasing', $request->Type_Leasing)
                                ->orderBy('OcuStart')
                                ->get();
                        } else { // กรณีเป็น เคสปกติ ไม่ใช่refinance
                            $LTV = Rate_HY_LTV::where('TypeLeasing', $request->Type_Leasing)
                                ->where('TypeFn', $request->TypeAssetCode)
                                ->where('LTVCode', 'LTV-001')
                                ->orderBy('OcuStart')
                                ->get();
                        }
                        // dd($LTV);
                        $RatePrices = str_replace(',', '', $request->RatePrices);
                        $html = view('components.content-calcufinance.Calculate_HY.LTV-Rate', compact('LTV', 'RatePrices', 'Credo_Score'))->render();
                        return response()->json(['html' => $html]);
                    }
                }
                $Date_con = @$tags->TagToContracts->Date_con;
                $Type_Customer = $request->Type_Customer; // ประเภทลูกค้า
                $Interest_Car = $request->Interest_Car;
                $Cash_Car = str_replace(',', '', $request->Cash_Car);
                $Timelack_Car = $request->Timelack_Car;
                $statusOPR = $request->statusOPR;
                $Buy_PA = $request->Buy_PA;
                $Include_PA = $request->Include_PA;
                $dataPA = TB_InsurancePA::orderBy('Limit_Insur', 'asc')->get();
                // $dataPA = TB_InsurancePA::whereRaw('? between DateStart and DateEnd', [@$Date_con ?? $tags->date_Tag])->orderBy('Limit_Insur', 'asc')->get();

                $html = view('components.content-calcufinance.Calculate_HY.tb_install', compact('data', 'dataPA', 'Cash_Car', 'Interest_Car', 'Timelack_Car', 'statusOPR', 'Buy_PA', 'Include_PA', 'Type_Customer'))->render();
                return response()->json(['dataRate' => $data, 'dataPA' => $dataPA, 'html' => $html]);
            } elseif ($request->Flagtag == 2) { //Search Interest Nakon
                $typeCus = ['CUS-0004', 'CUS-0005', 'CUS-0006'];

                if ($request->RateYears != NULL) {
                    if ($request->TypeLoans == 'moto') {
                        $Searchyear = Stat_MotoYear::find($request->RateYears);
                        $year = $Searchyear->Year_moto;
                    } else {
                        $Searchyear = Stat_CarYear::find($request->RateYears);
                        $year = $Searchyear->Year_car;
                    }
                }

                if ($request->Type_Leasing != 03) {
                    $LTVCar = Rate_NK_LTVCAR::orwhereRaw("FlagCar = 'Cartypes-" . $request->RateCartypes . "' and Year_Start is NULL and Year_End is NULL")
                        ->orwhereRaw("FlagCar = 'Brands-" . $request->RateBrands . "' and Year_Start is NULL and Year_End is NULL")
                        ->orwhereRaw("FlagCar = 'Brands-" . $request->RateBrands . "' and ? between Year_Start and Year_End", [@$year])
                        ->orwhereRaw("FlagCar = 'Cartypes-" . $request->RateCartypes . "' and ? between Year_Start and Year_End", [@$year])
                        ->orwhereRaw("FlagCar = 'Brands-" . $request->RateBrands . ",Cartypes-" . $request->RateCartypes . "' and Year_Start is NULL and Year_End is NULL")
                        ->first();
                } else {
                    $LTVCar = NULL;
                }

                $Type_Leasing = $request->CodeLoans;
                $Credo_Score = $request->Credo_Score;
                if ($request->TypeCusGood == 'yes' && $request->Type_Customer == 'CUS-0004') {
                    if ($Type_Leasing == 01) {
                        $data = Rate_NK_InterestCars1::where('Type_Leasing', $Type_Leasing)
                            ->where('Status_Code', 'CUS-0004')
                            ->whereRaw('? between Year_Start and Year_End', [$year])
                            ->get();
                    } elseif ($Type_Leasing == 02 || $Type_Leasing == 06) {
                        $data = Rate_NK_InterestCars2::where('Type_Leasing', $Type_Leasing)
                            ->where('Flag', 'yes')
                            ->where('Status_Code', 'CUS-0004')
                            ->whereRaw('? between Year_Start and Year_End', [$year])
                            ->get();
                    } elseif ($Type_Leasing == 04 || $Type_Leasing == 15 || $Type_Leasing == 16 || $Type_Leasing == 18 || $Type_Leasing == 11 || $Type_Leasing == 17) {
                        $data = Rate_NK_InterestCars2::where('Flag', 'yes')
                            ->where('Status_Code', 'CUS-0004')
                            ->where('Type_Leasing', $Type_Leasing)
                            ->get();
                    } elseif ($Type_Leasing == 03) {
                        $data = Rate_NK_InterestCars2::where('Flag', 'yes')
                            ->where('Type_Leasing', $Type_Leasing)
                            ->where('Status_Code', 'CUS-0004')
                            ->whereRaw('? between Year_Start and Year_End', [$year])
                            ->get();
                    }
                } else {
                    if ($Type_Leasing == 01) {
                        $data = Rate_NK_InterestCars1::where('Type_Leasing', $Type_Leasing)
                            ->whereRaw('? between Year_Start and Year_End', [$year])
                            ->where('Status_Code', NULL)
                            ->get();
                    } elseif ($Type_Leasing == 02 || $Type_Leasing == 06) {
                        $data = Rate_NK_InterestCars2::where('Type_Leasing', $Type_Leasing)
                            ->where('Flag', 'yes')
                            ->where('Status_Code', NULL)
                            ->whereRaw('? between Year_Start and Year_End', [$year])
                            ->get();
                    } elseif ($Type_Leasing == 04 || $Type_Leasing == 15 || $Type_Leasing == 16 || $Type_Leasing == 18 || $Type_Leasing == 11 || $Type_Leasing == 17) {
                        $data = Rate_NK_InterestCars2::where('Flag', 'yes')
                            ->where('Type_Leasing', $Type_Leasing)
                            ->where('Status_Code', NULL)
                            ->get();
                    } elseif ($Type_Leasing == 03) {
                        $data = Rate_NK_InterestCars2::where('Flag', 'yes')
                            ->where('Type_Leasing', $Type_Leasing)
                            ->where('Status_Code', NULL)
                            ->whereRaw('? between Year_Start and Year_End', [$year])
                            ->get();
                    }
                }


                //get LTV
                if ($request->LTV == 'getLTV') {
                    if ($LTVCar != NULL) { // เทียบรุ่นรถเรทต่ำ ว่าตรงกันกับใน DB หรือไม่ ถ้าตรง...
                        $dataLTV = $LTVCar->LTVCarToLTV;
                        $Type_Leasing = $request->Type_Leasing;
                        $Type_Customer = $request->Type_Customer;
                        $LTVCode = $LTVCar->LTVCode;
                        $TypeAssetCode = $request->TypeAssetCode;

                        if (in_array($Type_Customer, $typeCus)) { // กรณีเป็น refinance
                            $LTV = $dataLTV->filter(function ($query) use ($LTVCode, $Type_Leasing, $TypeAssetCode) {
                                return $query->LTVCode == $LTVCode && $query->TypeLeasing == $Type_Leasing && $query->TypeFn == $TypeAssetCode;
                            })->sortBy('OcuStart');
                        } else {
                            $LTV = $dataLTV->filter(function ($query) use ($LTVCode, $Type_Leasing, $TypeAssetCode) {
                                return $query->LTVCode == $LTVCode && $query->TypeLeasing == $Type_Leasing && $query->TypeFn == $TypeAssetCode;
                            })->sortBy('OcuStart');
                        }

                        $txtCar = 'จัดอยู่ในรุ่นเรทต่ำ*';
                        $RatePrices = str_replace(',', '', $request->RatePrices);
                        $html = view('components.content-calcufinance.Calculate_NK.LTV-Rate', compact('LTV', 'RatePrices', 'txtCar', 'Credo_Score', 'Type_Customer'))->render();
                        return response()->json(['html' => $html]);
                    } else {
                        if (in_array($request->Type_Customer, $typeCus)) { // กรณีเป็น refinance
                            $LTV = Rate_NK_LTV::where('TypeFn', $request->TypeAssetCode)
                                ->where('LTVCode', 'LTV-001')
                                ->where('TypeLeasing', $request->Type_Leasing)
                                ->orderBy('OcuStart')
                                ->get();
                        } else { // กรณีเป็น เคสปกติ ไม่ใช่refinance
                            $LTV = Rate_NK_LTV::where('TypeLeasing', $request->Type_Leasing)
                                ->where('TypeFn', $request->TypeAssetCode)
                                ->where('LTVCode', 'LTV-001')
                                ->orderBy('OcuStart')
                                ->get();
                        }
                        // dd($LTV);
                        $RatePrices = str_replace(',', '', $request->RatePrices);
                        $html = view('components.content-calcufinance.Calculate_NK.LTV-Rate', compact('LTV', 'RatePrices', 'Credo_Score'))->render();
                        return response()->json(['html' => $html]);
                    }
                }
                $IntSpecial = @$request->IntSpecial;
                $Date_con = @$tags->TagToContracts->Date_con;
                $Type_Customer = $request->Type_Customer; // ประเภทลูกค้า
                $Interest_Car = $request->Interest_Car;
                $Cash_Car = str_replace(',', '', $request->Cash_Car);
                $Timelack_Car = $request->Timelack_Car;
                $statusOPR = $request->statusOPR;
                $Buy_PA = $request->Buy_PA;
                $Include_PA = $request->Include_PA;
                $dataPA = TB_InsurancePA::orderBy('Limit_Insur', 'asc')->get();
                // รับค่าจาก checkbox (ค่า 'on' ถ้าถูกติ๊ก)
                $checkboxValue = $request->input('checkInterest', 'off'); // Default เป็น 'off' ถ้าไม่ได้ติ๊ก
                $editProcess_Car = $request->input('checkProcess', 'off'); // Default เป็น 'off' ถ้าไม่ได้ติ๊ก
                $InterestValue = $request->input('EditInterestVal');
                $InterestYearValue = $request->input('InterestYearValue');
                $ProcessValue = $request->input('EditProcess');
                // dd($data);
                // $dataPA = TB_InsurancePA::whereRaw('? between DateStart and DateEnd', [@$Date_con ?? $tags->date_Tag])->orderBy('Limit_Insur', 'asc')->get();
                $html = view('components.content-calcufinance.Calculate_NK.tb_install', compact('data', 'dataPA', 'Cash_Car', 'Interest_Car', 'Timelack_Car', 'statusOPR', 'Buy_PA', 'Include_PA', 'Type_Customer', 'IntSpecial', 'checkboxValue', 'editProcess_Car', 'InterestValue', 'InterestYearValue', 'ProcessValue'))->render();
                return response()->json(['dataRate' => $data, 'dataPA' => $dataPA, 'html' => $html]);
            }
        } elseif ($request->type == 7) { //Search Interest SR
            $all_rule = Rate_SR_InterestCars01::where('Flag', 'yes')
                ->where('TypeLoan_Id', TB_TypeLoan::where('Loan_Code', $request->loan_code)->first()->id)
                ->get();
            $filtered_rule = $all_rule->filter(function ($item, $key) use ($request) {
                $check_rule = [];
                //--------------------------------------
                if (!empty($item->Cond_YearStart)) {
                    array_push($check_rule, (!empty($request->yearCar) && intval($request->yearCar) >= $item->Cond_YearStart && intval($request->yearCar) <= $item->Cond_YearEnd));
                } else {
                    array_push($check_rule, true);
                }
                //------------------------------------------
                if (!empty($item->Cond_InstallmentStart)) {
                    array_push($check_rule, (!empty($request->instl) && intval($request->instl) >= $item->Cond_InstallmentStart && intval($request->instl) <= $item->Cond_InstallmentEnd));
                } else {
                    array_push($check_rule, true);
                }
                //------------------------------------------
                if (!empty($item->Cond_TotalStart)) {
                    if (!empty($item->Cond_TotalEnd)) {
                        array_push($check_rule, (!empty($request->total) && intval($request->total) >= $item->Cond_TotalStart && intval($request->total) <= $item->Cond_TotalEnd));
                    } else {
                        array_push($check_rule, (!empty($request->total) && intval($request->total) >= $item->Cond_TotalStart));
                    }
                } else {
                    array_push($check_rule, true);
                }
                //--------------------------------------
                return !in_array(false, $check_rule);
            });
            //return response()->json($filtered_rule);
            $rule = $filtered_rule->sortByDesc('Rating')->first();
            //-------------------------------------------------------

            /*
            TypeAsset
            TypeAssetsPoss
            Code_Cus
            OccupiedDay_Start
            OccupiedDay_End
            code_car
            Brand_id
            Group_car
            Evaluate_guar
            */

            $id_rateType = TB_TypeLoan::where('Loan_Code', $request->loan_code)->first()->id_rateType;
            if ($id_rateType != "person") {
                $TypeAsset = TB_TypeAssets::where('Code_TypeAsset', '=', $id_rateType)->first()->CodeId_TypeAsset;
            } else {
                $TypeAsset = '';
            }

            $all_ltv = Rate_SR_LTV::where('Status_LTV', 'active')
                ->where('TypeAsset', $TypeAsset)
                ->get();
            $filtered_ltv = $all_ltv->filter(function ($item, $key) use ($request) {
                $check_rule = [];
                //--------------------------------------
                if (!empty($item->TypeAssetsPoss)) {
                    array_push($check_rule, (!empty($request->asset_poss) && strcmp($request->asset_poss, $item->TypeAssetsPoss) == 0));
                } else {
                    array_push($check_rule, true);
                }
                //--------------------------------------
                if (!empty($item->Code_Cus)) {
                    array_push($check_rule, (!empty($request->code_cus) && strcmp($request->code_cus, $item->Code_Cus) == 0));
                } else {
                    array_push($check_rule, true);
                }
                //--------------------------------------
                if (!empty($item->OccupiedDay_Start)) {
                    if (!empty($item->OccupiedDay_End)) {
                        array_push($check_rule, (!empty($request->num_occupied) && $request->num_occupied >= $item->OccupiedDay_Start && $request->num_occupied <= $item->OccupiedDay_End));
                    } else {
                        array_push($check_rule, (!empty($request->num_occupied) && $request->num_occupied >= $item->OccupiedDay_Start));
                    }
                } else {
                    array_push($check_rule, true);
                }
                //--------------------------------------
                if (!empty($item->code_car)) {
                    array_push($check_rule, (!empty($request->code_car) && strcmp($request->code_car, $item->code_car) == 0));
                } else {
                    array_push($check_rule, true);
                }
                //--------------------------------------
                if (!empty($item->Brand_id)) {
                    array_push($check_rule, (!empty($request->Brand_id) && $request->Brand_id == $item->Brand_id));
                } else {
                    array_push($check_rule, true);
                }
                //--------------------------------------
                if (!empty($item->Group_car)) {
                    if (!empty($request->Group_car)) {
                        $_group_car_name = Stat_CarGroup::where('id', $request->Group_car)->first()->Group_car;
                        array_push($check_rule, (strcmp($_group_car_name, $item->Group_car) == 0));
                    } else {
                        array_push($check_rule, false);
                    }
                } else {
                    array_push($check_rule, true);
                }
                //--------------------------------------
                return !in_array(false, $check_rule);
            });
            //--------------------------------------------------------
            $filtered_ltv = $filtered_ltv->sortByDesc('Rating');
            if ($request->asset_poss == 'APS-0002') { // รถซื้อขาย
                $_ltv_guar_income = $filtered_ltv->where('Evaluate_guar', 'guar_income')->first();
                $_ltv_guar_land = $filtered_ltv->where('Evaluate_guar', 'guar_land')->first();
                $_ltv_guar_asset = $filtered_ltv->where('Evaluate_guar', 'guar_asset')->first();
                if ($_ltv_guar_income != null && $_ltv_guar_land != null && $_ltv_guar_asset != null) {
                    $collection_ltv = collect([
                        $_ltv_guar_income,
                        $_ltv_guar_land,
                        $_ltv_guar_asset
                    ]);
                } else {
                    $collection_ltv = collect([]);
                }
            } else {
                $collection_ltv = $filtered_ltv->take(1);
            }
            $ltv_result = [];
            //------------------------------------------------------------------------------
            if ($collection_ltv->isEmpty()) { // ถ้าหา LTV ไม่เจอเลย ให้เป็น 0
                if (count($collection_ltv) > 0) {
                    foreach ($collection_ltv as $item) {
                        array_push($ltv_result, 0);
                    }
                } else {
                    array_push($ltv_result, 0);
                }
            }
            if ($collection_ltv->isNotEmpty()) { // ถ้าหา LTV เจอ ให้ทำการหา LTV Ref ต่อ
                //---------------------------------------------------------------
                if (count(array_keys($collection_ltv->pluck('LTV')->toArray(), 'direct')) == count($collection_ltv)) {
                    // LTV direct
                    foreach ($collection_ltv as $ltv_item) {
                        array_push($ltv_result, $ltv_item->RatePrice * 100);
                    }
                } else {
                    // Find LTV Ref
                    $ltv_reference = Rate_SR_LTV_Reference::where('Status', 'active')->get();
                    if (!empty($request->code_car)) {
                        $ltv_reference = $ltv_reference->where('code_car', $request->code_car);
                    }
                    if (!empty($request->Brand_id)) {
                        $ltv_reference = $ltv_reference->where('Brand_id', $request->Brand_id);
                    }
                    $filtered_ltv_reference = $ltv_reference->filter(function ($item, $key) use ($request) {
                        $check_rule = [];
                        //--------------------------------------
                        if (!empty($item->Group_car_name)) {
                            if (!empty($request->Group_car)) {
                                $_group_car_name = Stat_CarGroup::where('id', $request->Group_car)->first()->Group_car;
                                if (preg_match('/^\/.+\/[a-z]*$/', $item->Group_car_name)) {
                                    //echo "The string is a regular expression pattern";
                                    array_push($check_rule, preg_match($item->Group_car_name, $_group_car_name) == 1);
                                } else {
                                    //echo "The string is not a regular expression pattern";
                                    array_push($check_rule, (strcmp($_group_car_name, $item->Group_car_name) == 0));
                                }
                            } else {
                                array_push($check_rule, false);
                            }
                        } else {
                            array_push($check_rule, true);
                        }
                        //--------------------------------------
                        if (!empty($item->Model_car_name)) {
                            if (!empty($request->Model_car)) {
                                $_model_car_name = Stat_CarModel::where('id', $request->Model_car)->first()->Model_car;
                                if (preg_match('/^\/.+\/[a-z]*$/', $item->Model_car_name)) {
                                    //echo "The string is a regular expression pattern";
                                    array_push($check_rule, preg_match($item->Model_car_name, $_model_car_name) == 1);
                                } else {
                                    //echo "The string is not a regular expression pattern";
                                    array_push($check_rule, (strcmp($_model_car_name, $item->Model_car_name) == 0));
                                }
                            } else {
                                array_push($check_rule, false);
                            }
                        } else {
                            array_push($check_rule, true);
                        }
                        //--------------------------------------
                        if (!empty($item->Year_Start)) {
                            array_push($check_rule, (!empty($request->yearCar) && intval($request->yearCar) >= $item->Year_Start && intval($request->yearCar) <= $item->Year_End));
                        } else {
                            array_push($check_rule, true);
                        }
                        //--------------------------------------
                        return !in_array(false, $check_rule);
                    })->sortBy(function ($item) {
                        $itemArray = $item->toArray();
                        return count(array_filter($itemArray, function ($value, $key) {
                            return !is_null($value) && in_array($key, ['Group_car_name', 'Model_car_name', 'Year_Start', 'Year_End']);
                        }, ARRAY_FILTER_USE_BOTH));
                    }, SORT_REGULAR, true);
                    $ltv_reference_result = $filtered_ltv_reference->first();
                    //----------------------------------------------------------
                    foreach ($collection_ltv as $ltv_item) {
                        if ($ltv_item->LTV == 'direct') {
                            array_push($ltv_result, $ltv_item->RatePrice * 100);
                        } else {
                            $mod_PCT = 0;
                            if (!empty($ltv_item->Mod_PCT)) {
                                $mod_PCT = intval($ltv_item->Mod_PCT);
                            }
                            if (!$ltv_reference_result) {
                                $ltv_ref = 0;
                                $mod_PCT = 0;
                            }
                            if ($ltv_reference_result) {
                                $ltv_ref = $ltv_reference_result->{$ltv_item->LTV};
                            }
                            array_push($ltv_result, ($ltv_ref * $ltv_item->RatePrice) + $mod_PCT);
                        }
                    }
                }
                //--------------------------------------------------------
            }
            //------------------------------------------------------------------------------
            /*
            // code_cus
            // loan_group
            // asset_poss
            // num_occupied
            $ltv_result = [];
            $all_ltv = Rate_SR_LTV::where('Status_LTV','active');
            if ($request->asset_poss == 'APS-0002') { // รถซื้อขาย
                $ltv = $all_ltv->where('Cond_TypeAssetsPoss', $request->asset_poss)->first();
                $ltv_result = [
                    $ltv->LTV_g1,
                    $ltv->LTV_g2,
                    $ltv->LTV_g3
                ];
            } else if ($request->asset_poss == 'APS-0001') {
                $all_ltv = $all_ltv->where('Cond_LoanGroup', $request->loan_group)
                    ->where('Cond_TypeAssetsPoss', $request->asset_poss)
                    ->get();
                $filtered_ltv = $all_ltv->filter(function ($item, $key) use($request){
                    $check_rule = [];
                    //--------------------------------------
                    if ( !empty($item->Cond_OccupiedDay_Start) ) {
                        if ( !empty($item->Cond_OccupiedDay_End) ) {
                            array_push( $check_rule, ( !empty($request->num_occupied) && $request->num_occupied >= $item->Cond_OccupiedDay_Start && $request->num_occupied <= $item->Cond_OccupiedDay_End ) );
                        } else {
                            array_push( $check_rule, ( !empty($request->num_occupied) && $request->num_occupied >= $item->Cond_OccupiedDay_Start ) );
                        }
                    } else {
                        array_push($check_rule, true);
                    }
                    //--------------------------------------
                    return !in_array(false, $check_rule);
                });
                $ltv = $filtered_ltv->first();
                $ltv_result = [$ltv->LTV];
            }
            */
            if ($rule != null && $ltv_result != null) {
                $_typeSuccess = 1;
                return response()->json([
                    'state' => 'success',
                    'Type_Success' => $_typeSuccess,
                    'Interest' => $rule->Interest,
                    'Fee_Rate' => $rule->Fee_Rate,
                    'Fee_Min' => $rule->Fee_Min,
                    'Fee_Max' => $rule->Fee_Max,
                    'Fine_Rate' => $rule->Fine_Rate,
                    'Installment_REC' => $rule->Installment_REC,
                    'Credo_Cond' => $rule->Credo_Cond,
                    'Credo_BonusLTV' => $rule->Credo_BonusLTV,
                    'LTV' => $ltv_result
                ]);
            } elseif ($rule == null && $ltv_result != null) {
                $_typeSuccess = 2;
                return response()->json([
                    'state' => 'success',
                    'Type_Success' => $_typeSuccess,
                    'LTV' => $ltv_result
                ]);
            } else {
                return response()->json([
                    'state' => 'error'
                ]);
            }
        } elseif ($request->type == 8) { //update Credo Status
            $dataTag = Data_CusTags::where('id', $request->tag)->first();
            $dataTag->Credo_Score = 0;
            $dataTag->Credo_Status = $request->value;
            $dataTag->Credo_Date = date('Y-m-d H:i:s');
            $dataTag->update();

            if ($dataTag->TagToDataCredo) {
                $dataTag->TagToDataCredo->update([
                    'credo_status' => $request->value,
                    'credo_date' => date('Y-m-d H:i:s')
                ]);
            }

            return response()->json(['credoName' => $dataTag->TagToCredo->Name_Credo, 'credoScore' => $dataTag->Credo_Score]);
        } elseif ($request->type == 9) { //insurance PA
            $tags = Data_CusTags::where('id', $request->DataTag_id)->first();
            $Date_con = @$tags->TagToContracts->Date_con;
            $data = TB_InsurancePA::orderBy('Limit_Insur', 'asc')->get();
            // $data = TB_InsurancePA::whereRaw('? between DateStart and DateEnd', [$Date_con ?? $tags->date_Tag])->orderBy('Limit_Insur', 'asc')->get();

            return response()->json(['insurPrice' => $data]);
        } elseif ($request->funs == 'cal-LTV') { //LTV PTN
            // $LTV = Rate_PTN_LTV::generateQuery($request->countdate);
            $LTV = Rate_PTN_LTV::where('Status_LTV', 'active')
                ->whereRaw('? between DateCtStart_LTV and DateCtEnd_LTV', $request->countdate)
                ->first();

            return response()->json($LTV);
        }
    }

    public function store(Request $request)
    {
        if ($request->type == 6) { // save Calcurate
            DB::beginTransaction();
            try {
                $calculate = new Data_CusTagCalculate;
                $calculate->DataCus_id = $request->data['DataCus_id'];
                $calculate->DataTag_id = $request->data['DataTag_id'];
                $calculate->Date_Calcu = date('Y-m-d');
                $calculate->CodeLoans = $request->data['CodeLoans'];
                $calculate->TypeLoans = $request->data['TypeLoans'];
                $calculate->RateCartypes = @$request->data['RateCartypes'];
                $calculate->RateBrands = @$request->data['RateBrands'];
                $calculate->RateGroups = @$request->data['RateGroups'];
                $calculate->RateModals = @$request->data['RateModals'];
                $calculate->RateYears = @$request->data['RateYears'];
                $calculate->RateGears = @$request->data['RateGears'];
                $calculate->Type_PLT = @$request->data['Type_PLT'];
                $calculate->Payment_Due = @$request->data['Payment_Due'];
                $calculate->RatePrices = floatval($request->data['RatePrices'] == NULL ? 0.00 : str_replace(",", "", $request->data['RatePrices']));
                $calculate->TypeAssetsPoss = @$request->data['TypeAssetsPoss'];
                $calculate->DateOldCon = @$request->data['DateOldCon'];
                $calculate->Contract_old = @$request->data['Contract_old'];
                $calculate->Interest_old = floatval(@$request->data['Interest_old'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Interest_old']));
                $calculate->TypeCusGood = @$request->data['TypeCusGood'];
                if (auth()->user()->zone == '50') {
                    $calculate->DateOccupiedcar = convertDateHumanToPHP(@$request->data['DateOccupiedcar']);
                } else {
                    $calculate->DateOccupiedcar = date('Y-m-d', strtotime(@$request->data['DateOccupiedcar']));
                }

                $calculate->NumDateOccupiedcar = @$request->data['NumDateOccupiedcar'];
                $calculate->DateInArea = @$request->data['DateInArea'];
                $calculate->NumDateInArea = @$request->data['NumDateInArea'];
                $calculate->RatePrice_Car = floatval(@$request->data['RatePrice_Car'] == NULL ? 0.00 : str_replace(",", "", @$request->data['RatePrice_Car']));
                $calculate->Cus_grade = @$request->data['Cus_grade'];
                $calculate->Payment_Status = @$request->data['Payment_Status'];
                $calculate->Promotions = @$request->data['valuePromotion'];
                $calculate->Cash_Car = floatval($request->data['Cash_Car'] == NULL ? 0.00 : str_replace(",", "", $request->data['Cash_Car']));
                $calculate->Process_Car = floatval($request->data['Process_Car'] == NULL ? 0.00 : str_replace(",", "", $request->data['Process_Car']));
                $calculate->StatusProcess_Car = @$request->data['StatusProcess_Car'];
                $calculate->Insurance = floatval(@$request->data['Insurance'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Insurance']));
                $calculate->Insurance_PA = floatval(@$request->data['Insurance_PA'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Insurance_PA']));
                $calculate->Plan_PA = @$request->data['Plan_PA'];
                $calculate->Percent_Car = floatval(@$request->data['Percent_Car'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Percent_Car']));
                $calculate->Timelack_Car = @$request->data['Timelack_Car'];
                $calculate->Timelack_PRD = @$request->data['Timelack_PRD'];
                $calculate->Interest_Car = floatval(@$request->data['Interest_Car'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Interest_Car']));
                $calculate->Interestmore_Car = floatval(@$request->data['Interestmore_Car'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Interestmore_Car']));
                $calculate->Flag_Interest = @$request->data['Flag_Interest'];
                // $calculate->editStatus = (@$request->data['editStatus'] == NULL ? '0' : @$request->data['editStatus']);


                $calculate->totalInterest_Car = floatval(@$request->data['totalInterest_Car'] == NULL ? 0.00 : str_replace(",", "", @$request->data['totalInterest_Car']));

                $calculate->InterestYear_Car = floatval(@$request->data['InterestYear_Car'] == NULL ? 0.00 : str_replace(",", "", @$request->data['InterestYear_Car']));
                if (in_array($request->data['CodeLoans'], array("01", "05", "07"))) {
                    $calculate->Vat_Rate = @$request->data['Vat_Rate'];
                }
                $calculate->Period_Rate = floatval(@$request->data['Period_Rate'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Period_Rate']));
                $calculate->Tax_Rate = floatval(@$request->data['Tax_Rate'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Tax_Rate']));
                $calculate->Tax2_Rate = floatval(@$request->data['Tax2_Rate'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Tax2_Rate']));
                $calculate->Duerate_Rate = floatval(@$request->data['Duerate_Rate'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Duerate_Rate']));
                $calculate->Duerate2_Rate = floatval(@$request->data['Duerate2_Rate'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Duerate2_Rate']));
                $calculate->Profit_Rate = floatval(@$request->data['Profit_Rate'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Profit_Rate']));
                $calculate->TotalPeriod_Rate = floatval(@$request->data['TotalPeriod_Rate'] == NULL ? 0.00 : str_replace(",", "", @$request->data['TotalPeriod_Rate']));
                $calculate->TotalPeriodNonPa = floatval(@$request->data['TotalPeriodNonPa'] == NULL ? 0.00 : str_replace(",", "", @$request->data['TotalPeriodNonPa']));
                $calculate->TotalLand_Rate = floatval(@$request->data['TotalLand_Rate'] == NULL ? 0.00 : str_replace(",", "", @$request->data['TotalLand_Rate']));
                $calculate->Rate_ownership1 = floatval(@$request->data['Rate_ownership1'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Rate_ownership1']));
                $calculate->Rate_ownership2 = floatval(@$request->data['Rate_ownership2'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Rate_ownership2']));
                $calculate->Rate_ownership3 = floatval(@$request->data['Rate_ownership3'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Rate_ownership3']));
                $calculate->Rate_ownership4 = floatval(@$request->data['Rate_ownership4'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Rate_ownership4']));
                $calculate->Rate_ownership5 = floatval(@$request->data['Rate_ownership5'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Rate_ownership5']));
                $calculate->Rate_trade1 = floatval(@$request->data['Rate_trade1'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Rate_trade1']));
                $calculate->Rate_trade2 = floatval(@$request->data['Rate_trade2'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Rate_trade2']));
                $calculate->Rate_trade3 = floatval(@$request->data['Rate_trade3'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Rate_trade3']));
                $calculate->Note_Cal = @$request->data['Note_Cal'];
                $calculate->Note_Credo = @$request->data['Note_Credo'];
                $calculate->Prices_balance = floatval(@$request->data['Prices_balance'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Prices_balance']));
                $calculate->Result_rate = floatval(@$request->data['Result_rate'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Result_rate']));
                $calculate->Commission = floatval(@$request->data['Commission'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Commission']));
                $calculate->Buy_PA = @$request->data['Buy_PA'];
                $calculate->Include_PA = @$request->data['Include_PA'];

                $calculate->UserZone = auth()->user()->zone;
                $calculate->UserBranch = auth()->user()->branch;
                $calculate->UserInsert = auth()->user()->id;
                $calculate->save();

                Data_CusTags::where('id', [$request->data['DataTag_id']])->update(['Type_Customer' => @$request->data['Type_Customer']]);

                DB::commit();
                $eventLog = event(new LogDataCusTag($calculate->DataTag_id, 'insert', 'LogDataCusTag', 'create-Calculate', 'สร้างคำนวณสินเชือ', auth()->user()->id));

                $message = 'บันทึกคำนวณสินเชือ เรียบร้อย';
                return response()->json(['message' => $message, 'code' => 200]);
            } catch (\Exception $e) {

                DB::rollback();
                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        }
    }

    public function update(Request $request, $id)
    {
        if ($request->type == 6) { // update Calcurate
            DB::beginTransaction();
            try {
                $calculate = Data_CusTagCalculate::where('id', $id)->first();
                $calculate->CodeLoans = $request->data['CodeLoans'];
                $calculate->TypeLoans = $request->data['TypeLoans'];
                $calculate->RateCartypes = @$request->data['RateCartypes'];
                $calculate->RateBrands = @$request->data['RateBrands'];
                $calculate->RateGroups = @$request->data['RateGroups'];
                $calculate->RateModals = @$request->data['RateModals'];
                $calculate->RateYears = @$request->data['RateYears'];
                $calculate->RateGears = @$request->data['RateGears'];
                $calculate->Type_PLT = @$request->data['Type_PLT'];
                $calculate->Payment_Due = @$request->data['Payment_Due'];
                $calculate->RatePrices = floatval($request->data['RatePrices'] == NULL ? 0.00 : str_replace(",", "", $request->data['RatePrices']));
                $calculate->TypeAssetsPoss = @$request->data['TypeAssetsPoss'];
                $calculate->DateOldCon = @$request->data['DateOldCon'];
                $calculate->Contract_old = @$request->data['Contract_old'];
                $calculate->Interest_old = floatval(@$request->data['Interest_old'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Interest_old']));

                $calculate->TypeCusGood = @$request->data['TypeCusGood'];
                if ($calculate->UserZone == '50') {
                    $calculate->DateOccupiedcar = convertDateHumanToPHP(@$request->data['DateOccupiedcar']);
                } else {
                    $calculate->DateOccupiedcar = date('Y-m-d', strtotime(@$request->data['DateOccupiedcar']));
                }

                $calculate->NumDateOccupiedcar = @$request->data['NumDateOccupiedcar'];
                $calculate->DateInArea = @$request->data['DateInArea'];
                $calculate->NumDateInArea = @$request->data['NumDateInArea'];
                $calculate->RatePrice_Car = floatval(@$request->data['RatePrice_Car'] == NULL ? 0.00 : str_replace(",", "", @$request->data['RatePrice_Car']));
                $calculate->Cus_grade = @$request->data['Cus_grade'];
                $calculate->Payment_Status = @$request->data['Payment_Status'];
                $calculate->Promotions = @$request->data['valuePromotion'];
                // $calculate->editStatus = (@$request->data['editStatus'] == NULL ? '0' : @$request->data['editStatus']);

                $calculate->Cash_Car = floatval($request->data['Cash_Car'] == NULL ? 0.00 : str_replace(",", "", $request->data['Cash_Car']));
                $calculate->Process_Car = floatval($request->data['Process_Car'] == NULL ? 0.00 : str_replace(",", "", $request->data['Process_Car']));
                $calculate->StatusProcess_Car = @$request->data['StatusProcess_Car'];
                $calculate->Insurance = floatval(@$request->data['Insurance'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Insurance']));
                $calculate->Insurance_PA = floatval(@$request->data['Insurance_PA'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Insurance_PA']));
                $calculate->Plan_PA = @$request->data['Plan_PA'];

                $calculate->Percent_Car = floatval(@$request->data['Percent_Car'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Percent_Car']));
                $calculate->Timelack_Car = @$request->data['Timelack_Car'];
                $calculate->Timelack_PRD = @$request->data['Timelack_PRD'];
                $calculate->Interest_Car = floatval(@$request->data['Interest_Car'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Interest_Car']));
                $calculate->Interestmore_Car = floatval(@$request->data['Interestmore_Car'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Interestmore_Car']));
                $calculate->Flag_Interest = @$request->data['Flag_Interest'];
                $calculate->InterestYear_Car = floatval(@$request->data['InterestYear_Car'] == NULL ? 0.00 : str_replace(",", "", @$request->data['InterestYear_Car']));

                $calculate->totalInterest_Car = floatval(@$request->data['totalInterest_Car'] == NULL ? 0.00 : str_replace(",", "", @$request->data['totalInterest_Car']));

                //if ($request->data['CodeLoans'] == '01') {
                if (in_array($request->data['CodeLoans'], array("01", "05", "07"))) {
                    $calculate->Vat_Rate = @$request->data['Vat_Rate'];
                }

                $calculate->Period_Rate = floatval(@$request->data['Period_Rate'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Period_Rate']));
                $calculate->Tax_Rate = floatval(@$request->data['Tax_Rate'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Tax_Rate']));
                $calculate->Tax2_Rate = floatval(@$request->data['Tax2_Rate'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Tax2_Rate']));
                $calculate->Duerate_Rate = floatval(@$request->data['Duerate_Rate'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Duerate_Rate']));
                $calculate->Duerate2_Rate = floatval(@$request->data['Duerate2_Rate'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Duerate2_Rate']));
                $calculate->Profit_Rate = floatval(@$request->data['Profit_Rate'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Profit_Rate']));
                $calculate->TotalPeriod_Rate = floatval(@$request->data['TotalPeriod_Rate'] == NULL ? 0.00 : str_replace(",", "", @$request->data['TotalPeriod_Rate']));
                $calculate->TotalPeriodNonPa = floatval(@$request->data['TotalPeriodNonPa'] == NULL ? 0.00 : str_replace(",", "", @$request->data['TotalPeriodNonPa']));
                $calculate->TotalLand_Rate = floatval(@$request->data['TotalLand_Rate'] == NULL ? 0.00 : str_replace(",", "", @$request->data['TotalLand_Rate']));

                $calculate->Rate_ownership1 = floatval(@$request->data['Rate_ownership1'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Rate_ownership1']));
                $calculate->Rate_ownership2 = floatval(@$request->data['Rate_ownership2'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Rate_ownership2']));
                $calculate->Rate_ownership3 = floatval(@$request->data['Rate_ownership3'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Rate_ownership3']));
                $calculate->Rate_ownership4 = floatval(@$request->data['Rate_ownership4'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Rate_ownership4']));
                $calculate->Rate_ownership5 = floatval(@$request->data['Rate_ownership5'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Rate_ownership5']));
                $calculate->Rate_trade1 = floatval(@$request->data['Rate_trade1'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Rate_trade1']));
                $calculate->Rate_trade2 = floatval(@$request->data['Rate_trade2'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Rate_trade2']));
                $calculate->Rate_trade3 = floatval(@$request->data['Rate_trade3'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Rate_trade3']));

                $calculate->Note_Cal = @$request->data['Note_Cal'];
                $calculate->Note_Credo = @$request->data['Note_Credo'];
                $calculate->Prices_balance = floatval(@$request->data['Prices_balance'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Prices_balance']));
                $calculate->Result_rate = floatval(@$request->data['Result_rate'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Result_rate']));

                $calculate->Commission = floatval(@$request->data['Commission'] == NULL ? 0.00 : str_replace(",", "", @$request->data['Commission']));
                $calculate->Buy_PA = @$request->data['Buy_PA'];
                $calculate->Include_PA = @$request->data['Include_PA'];
                $calculate->UserUpdate = auth()->user()->id;
                $calculate->update();

                Data_CusTags::where('id', [$request->data['DataTag_id']])->update(['Type_Customer' => @$request->data['Type_Customer']]);

                $html = NULL;
                if (@$calculate->DataCalcuToDataTag->TagToContracts != NULL) {
                    $idCon = @$calculate->DataCalcuToDataTag->TagToContracts->id;
                    $ContractExpenses = Pact_Operatedfees::where('PactCon_id', $idCon)->first();


                    if ($ContractExpenses != NULL) {
                        $totalFees = floatval($ContractExpenses->Total_Price);
                        if ($calculate->StatusProcess_Car == "no") {
                            $totalFees = ($totalFees - floatval($ContractExpenses->Process_Price)) + floatval($calculate->Process_Car);
                            $ContractExpenses->Process_Price = floatval($calculate->Process_Car);
                        } else {
                            $totalFees = ($totalFees - floatval($ContractExpenses->Process_Price));
                            $ContractExpenses->Process_Price = 0;
                        }

                        if (($calculate->Buy_PA == "yes" && $calculate->Include_PA == "no")) {

                            $totalFees = ($totalFees - floatval($ContractExpenses->Insurance_PA)) + floatval($calculate->Insurance_PA);
                            $ContractExpenses->Insurance_PA = floatval($calculate->Insurance_PA);
                        } else {
                            $totalFees = ($totalFees - floatval($ContractExpenses->Insurance_PA));
                            $ContractExpenses->Insurance_PA = 0;
                        }
                        $balncePrice = floatval($calculate->Cash_Car) - floatval($totalFees);
                        $ContractExpenses->Balance_Price = ($balncePrice == NULL ? 0 : $balncePrice);
                        $ContractExpenses->Total_Price = ($totalFees == NULL ? 0 : $totalFees);

                        $ContractExpenses->update();
                        $data = $ContractExpenses;
                        $html = view('frontend.content-con.section-expenses.view-expens', compact('data'))->render();
                    }
                }
                DB::commit();

                if (@$calculate->DataCalcuToDataTag->TagToContracts != NULL) {
                    $eventLog = event(new LogDataContract(@$calculate->DataCalcuToDataTag->TagToContracts->id, 'update', 'LogCalculateContract', 'Update-Calculate', 'แก้คำนวณสินเชือ Tag ID:' . @$calculate->DataCalcuToDataTag->id, auth()->user()->id));
                } else {
                    $eventLog = event(new LogDataCusTag($calculate->DataTag_id, 'update', 'LogDataCusTag', 'Update-Calculate', 'แก้คำนวณสินเชือ', auth()->user()->id));
                }

                $message = 'อัพเดตคำนวณสินเชือ เรียบร้อย';
                return response()->json(['message' => $message, 'code' => 200, 'html' => $html]);
            } catch (\Exception $e) {

                DB::rollback();
                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        }
    }

    public function show(Request $request, $id)
    {
        if ($request->type == 1 || $request->type == 2) { // แสดงแผนที่
            $type = $request->type;
            $input_tag_id = $request->inputid;
            $lat = null;
            $lng = null;
            if ($request->coord != ":coord") {
                $parts = explode(',', $request->coord);
                $lat = $parts[0];
                $lng = $parts[1];
            } else {
                switch (auth()->user()->zone) {
                    case 10: // PTN
                        $lat = 6.761831;
                        $lng = 101.323255;
                        break;
                    case 20: // HY
                        $lat = 7.008647;
                        $lng = 100.474688;
                        break;
                    case 30: // NK
                        $lat = 8.430398;
                        $lng = 99.963122;
                        break;
                    case 40: // KB
                        $lat = 8.0863;
                        $lng = 98.906284;
                        break;
                    case 50: // SR
                        if (auth()->user()->branch == 56) { // ชุมพร
                            $lat = 10.317454;
                            $lng = 99.0841286;
                        } else {
                            $lat = 9.138239;
                            $lng = 99.321748;
                        }
                        break;
                }
            }
            return view('view_MapCoordinates.viewMapCoordinates', compact('type', 'input_tag_id', 'lat', 'lng'));
        } elseif ($request->type == 'getInsurance') {
            $data = TB_InsurancePA::where('Limit_Insur', '>=', $request->totalInstallments)->orderBy('Limit_Insur', 'asc')->first();
            return response()->json(["insuranceData" => $data]);
        }
    }
}
