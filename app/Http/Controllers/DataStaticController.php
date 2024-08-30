<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

use App\Models\TB_Constants\TB_Backend\TB_CONFPSL;
use App\Models\TB_Constants\TB_Backend\TB_CONFHP;
use App\Models\TB_Constants\TB_Backend\TB_GRADECONT;
use App\Models\TB_Constants\TB_Backend\TB_TRLIST;
use App\Models\TB_Constants\TB_Backend\TB_TRDELIVER;

use App\Models\TB_Constants\TB_Frontend\TB_BankAccounts;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_Constants\TB_Frontend\TB_ConfigMSTeams;
use App\Models\TB_Constants\TB_Frontend\TB_TypeLoan;
use App\Models\TB_Constants\TB_Frontend\TB_CareerCus;
use App\Models\TB_Constants\TB_Frontend\TB_TypeCusResources;
use App\Models\TB_Constants\TB_Frontend\TB_TypeCusAddress;
use App\Models\TB_Constants\TB_Frontend\TB_RelationsCus;
use App\Models\TB_Constants\TB_Frontend\TB_StatusCustomers;
use App\Models\TB_Constants\TB_Frontend\TB_TypeSecurities;
use App\Models\TB_Constants\TB_Frontend\TB_TypeCredo;
use App\Models\TB_Constants\TB_Frontend\TB_Company;
use App\Models\TB_Constants\TB_Frontend\TB_TypeTarget;
use App\Models\TB_Constants\TB_Frontend\TB_TargetAmount;
use App\Models\TB_Constants\TB_Frontend\TB_Groups;
use App\Models\TB_Constants\TB_Frontend\TB_TypeGroups;

use App\Models\TB_Constants\TB_Backend\TB_BILLCOLL;
use App\Models\TB_Constants\TB_Backend\TB_DSCRATEHP;

use App\Models\TB_Packages\TB_Promotios;

use App\Models\TB_Interests\rate_HY\Rate_HY_InterestCars1;
use App\Models\TB_Interests\rate_HY\Rate_HY_InterestCars2;
use App\Models\TB_Interests\rate_HY\Rate_NK_InterestCars1;
use App\Models\TB_Interests\rate_HY\Rate_NK_InterestCars2;
use App\Models\TB_Interests\rate_KB\Rate_KB_InterestCars01;
use App\Models\TB_Interests\rate_PTN\Rate_PTN_InterestCars01;
use App\Models\TB_Interests\rate_SR\Rate_SR_InterestCars01;

use App\Models\TB_Assessments\Stat_rateType;
use App\Models\TB_Assessments\Stat_CarBrand;
use App\Models\TB_Assessments\Stat_MotoBrand;

use App\Models\TB_Configs\Config_Credos;

use App\Models\TB_DOC\TYPE_TAKE_DOC;

use App\Traits\UserApproved;

class DataStaticController extends Controller
{
    use UserApproved;

    public function index(Request $request)
    {
        if ($request->page == 'frontend') {
            if ($request->set == 'data-rate') {
                if ($request->setsub == 'rate-car') {
                    $data = Stat_CarBrand::get();
                    $title_small = 'ราคากลางรถยนต์';
                    // dd('dsokfjoidgj');
                    return view('data-system.rate-system.data-car.view', compact('data', 'title_small'));
                } elseif ($request->setsub == 'rate-moto') {
                    $data = Stat_MotoBrand::get();
                    $title_small = 'ราคากลางมอเตอร์ไซต์';
                    return view('data-system.rate-system.data-moto.view', compact('data', 'title_small'));
                }
            } elseif ($request->set == 'data-contract') {
                $data = NULL;
                $set = $request->set;
                $title_small = 'ตั้งค่าสัญญา';

            } elseif ($request->set == 'data-companies') {
                if ($request->setsub == null) {
                    $data = NULL;
                    $set = $request->set;
                    $title_small = 'ตั้งค่าข้อมูลบริษัท';
                } elseif ($request->setsub == 'companies-name') {
                    $data = Stat_MotoBrand::get();
                    // dd($data);
                    $title_small = 'ราคากลางมอเตอร์ไซต์';
                }
            } elseif ($request->set == 'data-interest') {
                $data = NULL;
                $set = $request->set;
                $title_small = 'ตั้งค่าดอกเบี้ย';
            } elseif ($request->set == 'data-general') {
                $data = NULL;
                $set = $request->set;
                $title_small = 'ตั้งค่าทั่วไป';
            } elseif ($request->set == 'data-intogroup') {
                $data = NULL;
                $set = $request->set;
                $title_small = 'ตั้งค่าเป้าสาขา';
            }
            $page = $request->page;
            return view('data-system.front-system.view', compact('data', 'page', 'set', 'title_small'));
        } elseif ($request->page == 'backend') {
            if ($request->set == 'data-debt') {

            } elseif ($request->set == 'data-payoth') {
                $data = NULL;
                $set = $request->set;
                $title_small = 'ตั้งค่าการชำระลูกหนี้อื่น';
            } elseif ($request->set == 'data-dscratehp') { // ส่วนลดปิดบัญชีเช่าซื้อ dsc-rate-hp
                //$data = NULL;
                $data = (new TB_DSCRATEHP)->getTableInfo();
                $set = $request->set;
                $title_small = 'ส่วนลดปิดบัญชีเช่าซื้อ';
            } elseif ($request->set == 'data-gradecont') {
                // $data = NULL;
                $data = TB_GRADECONT::get();
                $set = $request->set;
                $title_small = 'ตั้งค่าเกรดสัญญา';
                $page = $request->page;
                return view('data-system.back-system.data-gradecont.view', compact('data', 'page', 'set', 'title_small'));
            } elseif ($request->set == 'data-track') {
                $data = NULL;
                $set = $request->set;
                $title_small = 'งานบันทึกติดตาม';
            }
            $page = $request->page;
            return view('data-system.back-system.view', compact('data', 'page', 'set', 'title_small'));
        } elseif ($request->page == 'constants') {
            if ($request->module == 'data-groups') {
                $set = $request->set;
                $title = 'กำหนดกลุ่มสาขา';

                // Artisan::call('cache:clear');
                // dump(Cache::get('dataBranch'));

                $dataGroup = TB_Groups::withTrashed()
                    // ->with([
                    //     'groupLists' => function ($query) {
                    //         return $query->withTrashed();
                    //     }
                    // ])
                    ->get();
                $page = $request->page;
                return view('constants.section-constants.content-groups.view', compact('dataGroup', 'page', 'set', 'title'));
            }
        } else if ($request->page == 'config-take-document') {
            $dataTypeTake = TYPE_TAKE_DOC::all();

            return view('data-system.back-system.conf-type-takedoc.view', compact('dataTypeTake'));
        } else if ($request->page == 'fix-loan') {
            return view('data-system.back-system.data-confLoan.view');
        }
    }

    public function create(Request $request)
    {
        $u_zone = auth()->user()->zone;

        if ($request->page == 'frontend') {
            $page = $request->page;
            $mode = $request->mode;
            if ($request->modal == 'companies') {
                return view('data-system.front-system.data-companies.modal', compact('page', 'mode'));
            } elseif ($request->modal == 'branches') {
                $dataHQ = TB_Branchs::selectRaw("lat, lon")->where('Zone_Branch', $u_zone)->where('Head_Office', 'yes')->get()[0];
                $lat = $dataHQ->lat;
                $lon = $dataHQ->lon;
                return view('data-system.front-system.data-branches.modal', compact('page', 'mode', 'lat', 'lon'));
            } elseif ($request->modal == 'bank') {
                $dataCom = TB_Company::where('Company_Zone', $u_zone)->get();
                return view('data-system.front-system.data-banks.modal', compact('page', 'mode', 'dataCom'));
            } elseif ($request->modal == 'targets-type') {
                $codeType = TB_TypeTarget::generateCode();
                return view('data-system.front-system.data-type-targets.modal', compact('codeType', 'page', 'mode'));
            } elseif ($request->modal == 'targets') {
                $codeType = TB_TypeTarget::generateQuery();
                $dataBranch = TB_Branchs::where('Zone_Branch', $u_zone)->where('Branch_Active', 'yes')->orderBy('id_Contract')->get();
                if (@$u_zone == 10) {
                    $Flagzone = 'Flagzone_PTN';
                } elseif (@$u_zone == 20) {
                    $Flagzone = 'Flagzone_HY';
                } elseif (@$u_zone == 30) {
                    $Flagzone = 'Flagzone_NK';
                } elseif (@$u_zone == 40) {
                    $Flagzone = 'Flagzone_KB';
                } elseif (@$u_zone == 50) {
                    $Flagzone = 'Flagzone_SR';
                }
                $dataTypecus = TB_StatusCustomers::where($Flagzone, 'active')->where('Flag_Cus', 'yes')->get();
                // dd($dataTypecus);
                // dump($mode);
                if ($mode == 'create-past' or $mode == 'edit') {
                    $month = $request->month;
                    $year = $request->year;
                    $dataTarget = TB_TargetAmount::where('created_month', $month)
                        ->where('Target_Year', $year)
                        ->where('Target_Zone', $u_zone)
                        ->orderBy('id', 'asc')
                        // ->latest()->limit($count)
                        ->get();
                    // dd($dataTarget);
                    return view('data-system.front-system.data-targets.modal', compact('dataBranch', 'dataTypecus', 'codeType', 'page', 'mode', 'dataTarget'));
                }
                return view('data-system.front-system.data-targets.modal', compact('dataBranch', 'dataTypecus', 'codeType', 'page', 'mode'));
            } elseif ($request->modal == 'ms-teams') {
                return view('data-system.front-system.data-msteams.modal', compact('page', 'mode'));
            } elseif ($request->modal == 'contract-type') {
                @$setpage = 'contract-type';
                return view('data-system.front-system.data-contracts.contract-type.modal', compact('page', 'mode', 'setpage'));
            } elseif ($request->modal == 'contract-number') {
                @$setpage = 'contract-number';
                return view('data-system.front-system.data-contracts.modal', compact('page', 'mode', 'setpage'));
            } elseif ($request->modal == 'promotion') {
                return view('data-system.front-system.data-promotions.modal', compact('page', 'mode'));
            } elseif ($request->modal == 'interest') {
                $rateType = Stat_rateType::get();
                return view('data-system.front-system.data-interests.interest_PTN.modal', compact('page', 'mode', 'rateType'));
            } elseif ($request->modal == 'career') {
                return view('data-system.front-system.data-careers.modal', compact('page', 'mode'));
            } elseif ($request->modal == 'resources') {
                return view('data-system.front-system.data-resources.modal', compact('page', 'mode'));
            } elseif ($request->modal == 'address') {
                return view('data-system.front-system.data-address.modal', compact('page', 'mode'));
            } elseif ($request->modal == 'relation') {
                return view('data-system.front-system.data-relations.modal', compact('page', 'mode'));
            } elseif ($request->modal == 'status-customer') {
                return view('data-system.front-system.data-customers.modal', compact('page', 'mode'));
            } elseif ($request->modal == 'status-loan') {
                return view('data-system.front-system.data-statusloans.modal', compact('page', 'mode'));
            } elseif ($request->modal == 'status-credo') {
                return view('data-system.front-system.data-credo.status-credo.modal', compact('page', 'mode'));
            } elseif ($request->modal == 'score-credo') {
                return view('data-system.front-system.data-credo.score-credo.modal', compact('page', 'mode'));
            } elseif ($request->modal == 'billcolls') {
                $dataBranch = TB_Branchs::where('Zone_Branch', $u_zone)
                    ->where('Branch_Active', 'yes')
                    ->orderBy('NickName_Branch')
                    ->get();
                return view('data-system.front-system.data-billcolls.modal', compact('page', 'mode', 'dataBranch'));

            }
        } elseif ($request->page == 'backend') {
            // dd($request);
            $page = $request->page;
            $mode = $request->mode;
            if ($request->modal == 'gradecont') {
                $data = TB_GRADECONT::select('OVERDUE')->orderBy('OVERDUE', 'desc')->first();
                // dd($data);
                return view('data-system.back-system.data-gradecont.modal', compact('page', 'mode','data'));
            } elseif ($request->modal == 'trlist') {
                $data = TB_TRLIST::generateCode();
                return view('data-system.back-system.data-trlist.modal', compact('page', 'mode','data'));
            } elseif ($request->modal == 'trdeliver') {
                $data = TB_TRDELIVER::generateCode2();
                return view('data-system.back-system.data-trdeliver.modal', compact('page', 'mode','data'));
            }

        } elseif ($request->page == 'constants') {
            if ($request->module == 'create-groups') {
                $minutes = 30; // กำหนดเวลาในการแคชเป็น 10 นาที

                if (!Cache::has('dataBranch')) {
                    $dataBranch = TB_Branchs::where('Zone_Branch', auth()->user()->zone)
                        ->where('Branch_Active', 'yes')
                        ->get();

                    Cache::put('dataBranch', $dataBranch, $minutes);
                } else {
                    $dataBranch = Cache::get('dataBranch');
                }

                if (!Cache::has('dataBILLCOLL')) {
                    $dataBILLCOLL = TB_BILLCOLL::whereNotNull('status')->where('UserZone', auth()->user()->zone)->get();

                    Cache::put('dataBILLCOLL', $dataBILLCOLL, $minutes);
                } else {
                    $dataBILLCOLL = Cache::get('dataBILLCOLL');
                }

                if (!Cache::has('dataTypeGroup')) {
                    $dataTypeGroup = TB_TypeGroups::where('TypeGroup_Status', 'Y')->get();
                    Cache::put('dataTypeGroup', $dataTypeGroup, $minutes);
                } else {
                    $dataTypeGroup = Cache::get('dataTypeGroup');
                }

                if (!Cache::has('userHandler')) {
                    $userHandler = $this->getUserHandlerGroup();
                    Cache::put('userHandler', $userHandler, $minutes);
                } else {
                    $userHandler = Cache::get('userHandler');
                }

                return view('constants.section-constants.content-groups.create-groups', compact('dataBranch', 'dataBILLCOLL', 'dataTypeGroup', 'userHandler'));
            }
        }
    }

    public function show(Request $request, $id)
    {
        $page = $request->page;
        $setpage = $request->setpage;
        $u_zone = auth()->user()->zone;

        if ($request->page == 'frontend') {
            if ($request->setpage == 'company') {               //ส่วนตั้งค่าบริษัท
                $data = TB_Company::where('Company_Zone', $u_zone)->get();
                $returnHTML = view('data-system.front-system.data-companies.view', compact('page', 'setpage', 'data', 'u_zone'))->render();
                return response()->json(['html' => $returnHTML]);
            } elseif ($request->setpage == 'branch') {
                $data = TB_Branchs::where('Zone_Branch', $u_zone)->orderBy('id_Contract')->get();
                $returnHTML = view('data-system.front-system.data-branches.view', compact('page', 'setpage', 'data', 'u_zone'))->render();
                return response()->json(['html' => $returnHTML]);
            } elseif ($request->setpage == 'bank') {
                $data = TB_BankAccounts::where('User_Zone', $u_zone)->get();
                $returnHTML = view('data-system.front-system.data-banks.view', compact('page', 'setpage', 'data', 'u_zone'))->render();
                return response()->json(['html' => $returnHTML]);
            } elseif ($request->setpage == 'target-type') {
                $data = TB_TypeTarget::generateQuery();
                $returnHTML = view('data-system.front-system.data-type-targets.view', compact('page', 'setpage', 'data', 'u_zone'))->render();
                return response()->json(['html' => $returnHTML]);
            } elseif ($request->setpage == 'target-branch') {
                // dd($request);
                $data = TB_TargetAmount::select('created_month', 'Target_Year', 'Target_Zone')->where('Target_Zone', $u_zone)->groupby('created_month', 'Target_Year', 'Target_Zone')->orderBy('created_month', 'desc')->get();
                // $data = TB_TargetAmount::where('Target_Month',date('m'))->where('Target_Year',date('Y'))->where('Target_Zone',$u_zone )->get();
                // dump($data);
                $returnHTML = view('data-system.front-system.data-targets.view', compact('page', 'setpage', 'data', 'u_zone'))->render();
                return response()->json(['html' => $returnHTML]);
            } elseif ($request->setpage == 'ms-teams') {
                $data = TB_ConfigMSTeams::where('User_Zone', $u_zone)->get();
                $returnHTML = view('data-system.front-system.data-msteams.view', compact('page', 'setpage', 'data', 'u_zone'))->render();
                return response()->json(['html' => $returnHTML]);
            } elseif ($request->setpage == 'categories') {
                $dataPSL = TB_CONFPSL::get();
                $dataHP = TB_CONFHP::get();
                $data = $dataPSL->concat($dataHP);
                // dd($data);
                $returnHTML = view('data-system.front-system.data-categories.view', compact('page', 'setpage', 'data', 'u_zone'))->render();
                return response()->json(['html' => $returnHTML]);
            } elseif ($request->setpage == 'contract-type') {     //ส่วนตั้งค่าสัญญา
                $data = TB_TypeLoan::orderBy('Loan_Code')->get();
                $returnHTML = view('data-system.front-system.data-contracts.contract-type.view', compact('page', 'setpage', 'data', 'u_zone'))->render();
                return response()->json(['html' => $returnHTML]);
            } elseif ($request->setpage == 'promotion') {
                $data = TB_Promotios::where('Zone_pro', $u_zone)->orderBy('Code_pro')->get();
                $returnHTML = view('data-system.front-system.data-promotions.view', compact('page', 'setpage', 'data', 'u_zone'))->render();
                return response()->json(['html' => $returnHTML]);
            } elseif ($request->setpage == 'interest') {
                // $data = TB_Company::where('Company_Zone',10)->get();
                // $returnHTML = view('data-system.front-system.data-interests.view', compact('page','setpage','data','u_zone'))->render();
                // return response()->json(['html' => $returnHTML]);
                $data = NULL;
                $rateType = Stat_rateType::get();
                if ($u_zone == '10') {
                    $data = Rate_PTN_InterestCars01::get();
                    $f_zone = "PTN";
                    $returnHTML = view('data-system.front-system.data-interests.interest_PTN.view', compact('page', 'setpage', 'data', 'u_zone', 'f_zone'))->render();
                    return response()->json(['html' => $returnHTML]);
                } elseif ($u_zone == '20') {
                    $interestLoan = ($request->interestLoan == NULL) ? '1' : $request->interestLoan;
                    if ($interestLoan == 1) {
                        $data = Rate_HY_InterestCars1::get();
                    } else {
                        $data = Rate_HY_InterestCars2::get();
                    }
                    $f_zone = "HY";
                } elseif ($u_zone == '30') {
                    $interestLoan = ($request->interestLoan == NULL) ? '1' : $request->interestLoan;
                    if ($interestLoan == 1) {

                        $data = Rate_NK_InterestCars1::get();
                    } else {
                        $data = Rate_NK_InterestCars2::get();
                    }

                    $f_zone = "NK";
                } elseif ($u_zone == '40') {
                    $data = Rate_KB_InterestCars01::get();

                    $f_zone = "KB";
                } elseif ($u_zone == '50') {
                    $data = Rate_SR_InterestCars01::get();
                    $f_zone = "SR";
                }
                if ($data != NULL) {
                    return '<div class="error-page">
                                <div class="error-content">
                                <h3 class="text-red"><i class="fas fa-exclamation-triangle text-danger prem"></i> ไม่มีการตั้งค่า. !</h3>

                                </div>
                            </div>';
                }
            } elseif ($request->setpage == 'status-customer') {   //ส่วนตั้งค่าทั่วไป
                $data = TB_StatusCustomers::orderBy('Code_Cus')->get();
                $returnHTML = view('data-system.front-system.data-customers.view', compact('page', 'setpage', 'data', 'u_zone'))->render();
                return response()->json(['html' => $returnHTML]);
            } elseif ($request->setpage == 'resoure') {
                $data = TB_TypeCusResources::orderBy('Code_CusResource')->get();
                $returnHTML = view('data-system.front-system.data-resources.view', compact('page', 'setpage', 'data', 'u_zone'))->render();
                return response()->json(['html' => $returnHTML]);
            } elseif ($request->setpage == 'career') {
                $data = TB_CareerCus::orderBy('Code_Career')->get();
                $returnHTML = view('data-system.front-system.data-careers.view', compact('page', 'setpage', 'data', 'u_zone'))->render();
                return response()->json(['html' => $returnHTML]);
            } elseif ($request->setpage == 'address') {
                $data = TB_TypeCusAddress::orderBy('Code_Address')->get();
                $returnHTML = view('data-system.front-system.data-address.view', compact('page', 'setpage', 'data', 'u_zone'))->render();
                return response()->json(['html' => $returnHTML]);
            } elseif ($request->setpage == 'relation') {
                $data = TB_RelationsCus::orderBy('Code_Rela')->get();
                $returnHTML = view('data-system.front-system.data-relations.view', compact('page', 'setpage', 'data', 'u_zone'))->render();
                return response()->json(['html' => $returnHTML]);
            } elseif ($request->setpage == 'status-loan') {
                $data = TB_TypeSecurities::orderBy('Code_Secur')->get();
                $returnHTML = view('data-system.front-system.data-statusloans.view', compact('page', 'setpage', 'data', 'u_zone'))->render();
                return response()->json(['html' => $returnHTML]);
            } elseif ($request->setpage == 'status-credo') {
                $data = TB_TypeCredo::orderBy('Code_Credo')->get();
                $returnHTML = view('data-system.front-system.data-credo.status-credo.view', compact('page', 'setpage', 'data', 'u_zone'))->render();
                return response()->json(['html' => $returnHTML]);
            } elseif ($request->setpage == 'score-credo') {
                // $data = Config_Credos::where('UserZone',$u_zone )->get();
                $data = Config_Credos::get();
                $returnHTML = view('data-system.front-system.data-credo.score-credo.view', compact('page', 'setpage', 'data', 'u_zone'))->render();
                return response()->json(['html' => $returnHTML]);
            } elseif ($request->setpage == 'billcoll') {
                $data = TB_BILLCOLL::where('UserZone', $u_zone)->orderBy('id')->get();
                $returnHTML = view('data-system.front-system.data-billcolls.view', compact('page', 'setpage', 'data', 'u_zone'))->render();
                return response()->json(['html' => $returnHTML]);
            }
        }
        elseif ($request->page == 'backend') {
            if ($request->setpage == 'gradecont') {               //ส่วนตั้งค่าเกรดสัญญา
                $data = TB_GRADECONT::get();
                $returnHTML = view('data-system.back-system.data-gradecont.view', compact('page', 'setpage', 'data', 'u_zone'))->render();
                return response()->json(['html' => $returnHTML]);
            } elseif ($request->setpage == 'trlist') {           //รายการโทรติดตาม
                $data = TB_TRLIST::get();
                $returnHTML = view('data-system.back-system.data-trlist.view', compact('page', 'setpage', 'data', 'u_zone'))->render();
                return response()->json(['html' => $returnHTML]);
            } elseif ($request->setpage == 'trdeliver') {        //รายการส่งมอบ
                $data = TB_TRDELIVER::get();
                $returnHTML = view('data-system.back-system.data-trdeliver.view', compact('page', 'setpage', 'data', 'u_zone'))->render();
                return response()->json(['html' => $returnHTML]);
            }
        }
    }

    public function store(Request $request)
    {
        $u_zone = auth()->user()->zone;
        if ($u_zone == 10) {
            $province = 'ปัตตานี';
        } elseif ($u_zone == 20) {
            $province = 'สงขลา';
        } elseif ($u_zone == 30) {
            $province = 'นครศรีธรรมราช';
        } elseif ($u_zone == 40) {
            $province = 'กระบี่';
        } elseif ($u_zone == 50) {
            $province = 'สุราษฎร์ธานี';
        }

        if ($request->store == 'contract-type') {
            $dataCT = new TB_TypeLoan;
            $dataCT->id_rateType = $request->data['CONT_TYPE'];
            $dataCT->Loan_Code = $request->data['CONT_CODE'];
            $dataCT->Loan_Name = $request->data['CONT_NAME'];
            $dataCT->Code_PLT = $request->data['CODE_PLT'];
            if (@$u_zone == 10) {
                $dataCT->Flagzone_PTN = 'active';
            } elseif (@$u_zone == 20) {
                $dataCT->Flagzone_HY = 'active';
            } elseif (@$u_zone == 30) {
                $dataCT->Flagzone_NK = 'active';
            } elseif (@$u_zone == 40) {
                $dataCT->Flagzone_KB = 'active';
            } elseif (@$u_zone == 50) {
                $dataCT->Flagzone_SR = 'active';
            }
            $dataCT->save();

            $data = TB_TypeLoan::orderBy('Loan_Code')->get();
            return response()->view('data-system.front-system.data-contracts.contract-type.data', compact('data', 'u_zone'));
        } elseif ($request->store == 'promotion') {
            $dataCode = TB_Promotios::where('Zone_pro', $u_zone)->latest('id')->first();
            if ($dataCode != NULL) {
                $StrNum = substr($dataCode->Code_pro, -4) + 1;
                $num = "10000";
                $SubStr = substr($num . $StrNum, -4);
            } else {
                $SubStr = '0001';
            }

            $dataPromotion = new TB_Promotios;
            $dataPromotion->Code_pro = "PR-" . $SubStr;
            $dataPromotion->Zone_pro = $u_zone;
            $dataPromotion->Name_pro = $request->data['PROMOTION_NAME'];
            $dataPromotion->Type_pro = $request->data['PROMOTION_TYPE'];
            $dataPromotion->Value_pro = $request->data['DISCOUNT'];
            $dataPromotion->Detail_pro = $request->data['DETAIL'];
            $dataPromotion->Start_pro = $request->data['START_DATE'];
            $dataPromotion->End_pro = $request->data['END_DATE'];
            $dataPromotion->Status_pro = 'yes';
            $dataPromotion->save();

            $data = TB_Promotios::where('Zone_pro', $u_zone)->orderBy('Code_pro')->get();
            return response()->view('data-system.front-system.data-promotions.data', compact('data', 'u_zone'));
        } elseif ($request->store == 'company') {
            $data = new TB_Company;
            $data->Company_Id = $request->data['TAXID'];
            $data->Company_Branch = $request->data['CODE'];
            $data->Company_Name = $request->data['NAMECOMPANY'];
            $data->Company_Addr = $request->data['ADDRCOMPANY'];
            $data->Company_Tel = $request->data['PHONE'];
            $data->Company_Type = $request->data['TYPECOMPANY'];
            $data->Company_Zone = $u_zone;
            $data->save();

            $data = TB_Company::where('Company_Zone', $u_zone)->get();
            return response()->view('data-system.front-system.data-companies.data', compact('data', 'u_zone'));
        } elseif ($request->store == 'resoure') {
            $code = TB_TypeCusResources::generateCode();
            $data = new TB_TypeCusResources;
            $data->Code_CusResource = $code;
            $data->Date_CusResource = date('Y-m-d');
            $data->Name_CusResource = $request->data['NAME_RESOURCES'];
            $data->Flag_CusResource = $request->data['FLAG'];
            $data->save();

            $data = TB_TypeCusResources::orderBy('Code_CusResource')->get();
            return response()->view('data-system.front-system.data-resources.data', compact('data', 'u_zone'));
        } elseif ($request->store == 'branches') {
            // $dataBranch = new TB_Branchs;
            // $dataBranch->id_Contract = $request->data['CODE'];
            // $dataBranch->Name_Branch = $request->data['NAME_TH'];
            // $dataBranch->NickName_Branch = $request->data['NAME_EN'];
            // $dataBranch->Zone_Branch = $u_zone;
            // $dataBranch->province_Branch = $province;
            // $dataBranch->Branch_Active = 'yes';
            // $dataBranch->save();

            $dataLatLon = $request->data['Position_branch'];
            $dataSplit = explode(",", $dataLatLon);
            $Flag = empty($request->data['FLAG']) ? 'no' : $request->data['FLAG'];

            $response = TB_Branchs::create([
                "id_Contract" => $request->data['CODE'],
                "Name_Branch" => $request->data['NAME_TH'],
                "NickName_Branch" => $request->data['NAME_EN'],
                "Zone_Branch" => $u_zone,
                "province_Branch" => $request->data['Province'],
                "lat" => $dataSplit[0],
                "lon" => $dataSplit[1],
                "line_id" => $request->data['LineId'],
                "open_time" => $request->data['OpenDate'],
                "address" => $request->data['Branch_Address'],
                "phoneNo" => $request->data['PhoneNumber'],
                "Branch_Active" => $Flag,
            ]);

            $data = TB_Branchs::where('Zone_Branch', $u_zone)->orderBy('id_Contract')->get();
            return response()->view('data-system.front-system.data-branches.data', compact('data', 'u_zone'));
        } elseif ($request->store == 'banks') {
            $Setdata = explode("|", $request->data['TYPECOMPANY']);
            $dataBank = new TB_BankAccounts;
            $dataBank->Com_Id = $Setdata[0];
            $dataBank->Account_Bank = $request->data['BANK_NAME'];
            $dataBank->Account_Number = $request->data['NO_ACCOUNT'];
            $dataBank->Account_Name = $request->data['NAME_ACCOUNT'];
            $dataBank->company_bank = $Setdata[1];
            $dataBank->company_type = $Setdata[0];
            $dataBank->User_Zone = $u_zone;
            $dataBank->Flag_Bank = 'yes';
            $dataBank->Inside_Active = @$request->data['INSIDE'];
            $dataBank->save();

            $data = TB_BankAccounts::where('User_Zone', $u_zone)->get();
            return response()->view('data-system.front-system.data-banks.data', compact('data', 'u_zone'));
        } elseif ($request->store == 'targets-type') {
            $data = new TB_TypeTarget;
            $data->Target_Code = $request->data['TARGET_CODE'];
            $data->Target_Name = $request->data['TARGET_NAME'];
            $data->Target_Status = @$request->data['TARGET_STATUS'];
            $data->save();

            $data = TB_TypeTarget::get();
            return response()->view('data-system.front-system.data-type-targets.data', compact('data', 'u_zone'));
        } elseif ($request->store == 'targets') {
            // dd($request);
            DB::beginTransaction();
            try {
                $GetType = $request->TARGET_TYPE;
                $GetMonth = $request->TARGET_MONTH;
                $GetYear = $request->TARGET_YEAR;
                $GetZone = $request->TARGET_ZONE;
                $GetBranch = $request->TARGET_BRANCH;
                $GetTypecus = $request->TARGET_TYPECUS;
                $GetUser = $request->TARGET_USER;
                $GetAmount = $request->TARGET_AMOUNT;

                for ($i = 0; $i < count($request->TARGET_BRANCH); $i++) {
                    // $data = new TB_TargetAmount;
                    //     $data->TypeTarget_id = $GetType;
                    //     $data->Target_Branch = $GetBranch[$i];
                    //     // $data->Target_month = $GetMonth;
                    //     $data->Target_month = date('m');
                    //     $data->Target_Year = date('Y');
                    //     $data->Target_Typcus = $GetTypecus[$i];
                    //     $data->Target_User = $GetUser[$i];
                    //     $data->Target_Amount = $GetAmount[$i];
                    //     $data->Target_Zone = $GetZone;
                    // $data->save();

                    $data = TB_TargetAmount::updateOrCreate(
                        [
                            'Target_Branch' => $GetBranch[$i],
                            'Target_User' => @$GetUser[$i],
                            'created_month' => date('m'),
                            'Target_Year' => $GetYear,
                        ],
                        [
                            'TypeTarget_id' => @$GetType,
                            'Target_Branch' => @$GetBranch[$i],
                            'Target_Month' => @$GetMonth,
                            'Target_Year' => @$GetYear,
                            // 'Target_Typcus' => @$GetTypecus[$i],
                            'Target_Typcus' => @$GetTypecus,
                            'Target_User' => @$GetUser[$i],
                            'Target_Amount' => @$GetAmount[$i],
                            'Target_Zone' => @$GetZone,
                            'created_month' => date('m'),
                        ]
                    );
                    // dd($data);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                Log::channel('daily')->error($e->getMessage());
                return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
            }

            $data = TB_TargetAmount::select('created_month', 'Target_Year', 'Target_Zone')->where('Target_Zone', $u_zone)->groupby('created_month', 'Target_Year', 'Target_Zone')->orderBy('created_month', 'desc')->get();
            return response()->view('data-system.front-system.data-targets.data', compact('data', 'u_zone'));

        } elseif ($request->store == 'ms-teams') {

        } elseif ($request->store == 'data-groups') {
            DB::beginTransaction();
            try {
                $task = new TB_Groups();
                $task->groupStatus = 'active';
                $task->groupName = $request->data['taskName'];
                $task->groupDate = date('Y-m-d', strtotime($request->data['taskDate']));
                $task->groupType = implode(',', $request->data['taskType']);
                $task->groupHandler = (isset($request->data['taskHandler']) ? implode(',', $request->data['taskHandler']) : null);
                $task->flagSelect = $request->data['flexRadioDefault'];
                $task->groupZone = auth()->user()->zone;
                $task->groupDesc = $request->data['taskdesc'];
                $task->save();

                if ($request->data['flexRadioDefault'] == 'BRANCH') {
                    $dataloop = $request->data['taskBranch'];
                } else {
                    $dataloop = $request->data['taskbillcoll'];
                }

                foreach ($dataloop as $data) {
                    $task->groupLists()->create([
                        'listStatus' => 'active',
                        'listDate' => date('Y-m-d', strtotime($request->data['taskDate'])),
                        'listBranch_id' => $data,
                    ]);
                }
                DB::commit();

                $dataGroup = TB_Groups::withTrashed()
                    ->with([
                        'groupLists' => function ($query) {
                            // return $query->withTrashed();
                        }
                    ])->get();
                $viewData = view('constants.section-constants.content-groups.data-groups', compact('dataGroup'))->render();
                return response()->json(['html' => $viewData, 'code' => 200], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['message' => $e->getMessage(), 'code' => 500], 500);
            }
        } elseif ($request->store == 'billcolls') {
            $dataBillColl = new TB_BILLCOLL;
            $dataBillColl->code_billcoll = $request->data['code_billcoll'];
            $dataBillColl->name_billcoll = $request->data['name_billcoll'] ?? null;
            $dataBillColl->UserZone = $u_zone;
            $dataBillColl->status = $request->data['status'] ?? null;
            $dataBillColl->type_billcoll = $request->data['type_billcoll'];
            $dataBillColl->note_billcoll = $request->data['note_billcoll'];
            $dataBillColl->UserBranch = $request->data['UserBranch'];
            $dataBillColl->save();

            $data = TB_BILLCOLL::where('UserZone', $u_zone)->orderBy('id')->get();
            return response()->view('data-system.front-system.data-billcolls.data', compact('data', 'u_zone'));
        } else if ($request->store === 'createTypeLoan') {
            try {
                $data = $request->data;
                $userZone = auth()->user()->zone;
                $userId = auth()->user()->id;
                $Flag = empty($data['FLAG']) ? 'inactive' : 'active';

                if ($request->type === 'HP') {
                    $create = TB_CONFHP::create([
                        'FLAG' => $Flag, 
                        'LATEPER' => $data['LATEPER'],
                        'INT' => $data['INT'],
                        'LATENFINE' => $data['LATENFINE'],
                        'VAT' => $data['VAT'],
                        'DISCOUNT' => $data['DISCOUNT'],
                        'MTHDDIS' => $data['MTHDDIS'],
                        'USEADD' => $userId,
                        'ZONE' => $userZone,
                    ]);

                    $response = TB_CONFHP::where('ZONE', $userZone)->get();

                    $resView = view('data-system.back-system.data-confLoan.conf.view', compact('response'))->render();
                } else {
                    $create = TB_CONFPSL::create([
                        'FLAG' => $Flag, 
                        'LATEPER' => $data['LATEPER'],
                        'INT' => $data['INT'],
                        'LATENFINE' => $data['LATENFINE'],
                        'VAT' => $data['VAT'],
                        'DISCOUNT' => $data['DISCOUNT'],
                        'MTHDDIS' => $data['MTHDDIS'],
                        'USEADD' => $userId,
                        'ZONE' => $userZone,
                    ]);

                    $response = TB_CONFPSL::where('ZONE', $userZone)->get();

                    $resView = view('data-system.back-system.data-confLoan.conf.view', compact('response'))->render();
                }

                return response()->json([
                    "message" => "create loan success",
                    "resHtml" => $resView,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    "message" => $e->getMessage(),
                ], 500);
            }
        } else if ($request->up == 'updateTypeLoan') {
            try {
                $data = $request->data;
                $typeLoan = $request->typeLoan;
                $Flag = empty($data['FLAG']) ? 'inactive' : 'active';
    
                if ($request->typeLoan === "PSL") {
                    $update = TB_CONFPSL::where('id', $request->id)
                    ->update([
                        'FLAG' => $Flag, 
                        'LATEPER' => $data['LATEPER'],
                        'INT' => $data['INT'],
                        'LATENFINE' => $data['LATENFINE'],
                        'VAT' => $data['VAT'],
                        'DISCOUNT' => $data['DISCOUNT'],
                        'MTHDDIS' => $data['MTHDDIS'],
                    ]);

                    $response = TB_CONFPSL::
                    where('ZONE', $u_zone)->get();
                } else {
                    $update = TB_CONFHP::where('id', $request->id)
                    ->update([
                        'FLAG' => $Flag,
                        'LATEPER' => $data['LATEPER'],
                        'INT' => $data['INT'],
                        'LATENFINE' => $data['LATENFINE'],
                        'VAT' => $data['VAT'],
                        'DISCOUNT' => $data['DISCOUNT'],
                        'MTHDDIS' => $data['MTHDDIS'],
                    ]);

                    $response = TB_CONFHP::
                    where('ZONE', $u_zone)->get();
                }

                $resView = view('data-system.back-system.data-confLoan.conf.view', compact('response'))->render();

                return response()->json([
                    "message" => "update loan success",
                    "resHtml" => $resView,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    "message" => $e->getMessage(),
                ], 500);
            }
        }
    }

    public function edit(Request $request, $id)
    {
        $page = $request->page;
        $mode = $request->mode;
        $u_zone = auth()->user()->zone;

        if ($request->page == 'frontend') {

            if ($request->modal == 'companies') {
                $data = TB_Company::where('id', $id)->first();
                return view('data-system.front-system.data-companies.modal', compact('page', 'mode', 'data'));
            } elseif ($request->modal == 'branches') {
                $data = TB_Branchs::where('id', $id)->first();
                return view('data-system.front-system.data-branches.modal', compact('page', 'mode', 'data'));
            } elseif ($request->modal == 'bank') {
                $data = TB_BankAccounts::where('id', $id)->first();
                $dataCom = TB_Company::where('Company_Zone', $u_zone)->get();
                return view('data-system.front-system.data-banks.modal', compact('page', 'mode', 'data', 'dataCom'));
            } elseif ($request->modal == 'ms-teams') {
                $data = TB_ConfigMSTeams::where('id', $id)->first();
                return view('data-system.front-system.data-msteams.modal', compact('page', 'mode', 'data'));
            } elseif ($request->modal == 'contract-type') {
                $data = TB_TypeLoan::where('id', $id)->first();
                return view('data-system.front-system.data-contracts.contract-type.modal', compact('page', 'mode', 'data', 'u_zone'));
            }
            // elseif ($request->modal == 'contract-number') {
            //     $data = $tb_contract->where('id',$id )->first();
            //     return view('data-system.front-system.data-contracts.contract-number.modal', compact('page','mode','data','u_zone'));
            // }
            elseif ($request->modal == 'targets-type') {
                $data = TB_TypeTarget::where('id', $id)->first();
                return view('data-system.front-system.data-type-targets.modal', compact('page', 'mode', 'data', 'u_zone'));
            } elseif ($request->modal == 'target-branch') {
                $data = TB_TargetAmount::where('id', $id)->first();
                $codeType = TB_TypeTarget::generateQuery();
                $dataBranch = TB_Branchs::where('Zone_Branch', $u_zone)->where('Branch_Active', 'yes')->orderBy('id_Contract')->get();
                if (@$u_zone == 10) {
                    $Flagzone = 'Flagzone_PTN';
                } elseif (@$u_zone == 20) {
                    $Flagzone = 'Flagzone_HY';
                } elseif (@$u_zone == 30) {
                    $Flagzone = 'Flagzone_NK';
                } elseif (@$u_zone == 40) {
                    $Flagzone = 'Flagzone_KB';
                } elseif (@$u_zone == 50) {
                    $Flagzone = 'Flagzone_SR';
                }
                $dataTypecus = TB_StatusCustomers::where($Flagzone, 'active')->where('Flag_Cus', 'yes')->get();
                return view('data-system.front-system.data-targets.edit', compact('page', 'mode', 'data', 'codeType', 'dataBranch', 'dataTypecus', 'u_zone'));
                // return view('data-system.front-system.data-targets.modal', compact('page','mode','data','u_zone'));
            } elseif ($request->modal == 'promotion') {
                $data = TB_Promotios::where('id', $id)->first();
                return view('data-system.front-system.data-promotions.modal', compact('page', 'mode', 'data', 'u_zone'));
            } elseif ($request->modal == 'interest_PTN') {
                $rateType = Stat_rateType::get();
                $data = Rate_PTN_InterestCars01::where('id', $id)->first();
                return view('data-system.front-system.data-interests.interest_PTN.modal', compact('page', 'mode', 'data', 'u_zone', 'rateType'));
            } elseif ($request->modal == 'career') {
                $data = TB_CareerCus::where('id', $id)->first();
                // $data = TB_CareerCus::orderBy('Code_Career')->get();
                return view('data-system.front-system.data-careers.modal', compact('page', 'mode', 'data', 'u_zone'));
            } elseif ($request->modal == 'resource') {
                $data = TB_TypeCusResources::where('id', $id)->first();
                return view('data-system.front-system.data-resources.modal', compact('page', 'mode', 'data', 'u_zone'));
            } elseif ($request->modal == 'address') {
                $data = TB_TypeCusAddress::where('id', $id)->first();
                return view('data-system.front-system.data-address.modal', compact('page', 'mode', 'data', 'u_zone'));
            } elseif ($request->modal == 'relation') {
                $data = TB_RelationsCus::where('id', $id)->first();
                return view('data-system.front-system.data-relations.modal', compact('page', 'mode', 'data', 'u_zone'));
            } elseif ($request->modal == 'status-customer') {
                $data = TB_StatusCustomers::where('id', $id)->first();
                return view('data-system.front-system.data-customers.modal', compact('page', 'mode', 'data', 'u_zone'));
            } elseif ($request->modal == 'status-loan') {
                $data = TB_TypeSecurities::where('id', $id)->first();
                return view('data-system.front-system.data-statusloans.modal', compact('page', 'mode', 'data', 'u_zone'));
            } elseif ($request->modal == 'status-credo') {
                $data = TB_TypeCredo::where('id', $id)->first();
                return view('data-system.front-system.data-credo.status-credo.modal', compact('page', 'mode', 'data', 'u_zone'));
            } elseif ($request->modal == 'score-credo') {
                $data = Config_Credos::where('id', $id)->first();
                return view('data-system.front-system.data-credo.score-credo.modal', compact('page', 'mode', 'data', 'u_zone'));
            } elseif ($request->modal == 'billcolls') {
                $data = TB_BILLCOLL::where('id', $id)->first();
                $dataBranch = TB_Branchs::where('Zone_Branch', $u_zone)
                    ->where('Branch_Active', 'yes')
                    ->orderBy('NickName_Branch')
                    ->get();
                return view('data-system.front-system.data-billcolls.modal', compact('page', 'mode', 'data', 'u_zone', 'dataBranch'));
            }

        } elseif ($request->page == 'backend') {
            if ($request->reqType === 'edit') {
                $typeLoan = $request->typeLoan;
                $reqType = $request->reqType;

                if ($typeLoan === "PSL") {
                    $resModal = TB_CONFPSL::where('id', $id)->first();
                } else {
                    $resModal = TB_CONFHP::where('id', $id)->first();
                }

                return view('data-system.back-system.data-confLoan.conf.modal', compact('typeLoan', 'reqType', 'resModal'));
            }
        } elseif ($request->page == 'constants') {
            if ($request->module == 'edit-groups') {
                $minutes = 30; // กำหนดเวลาในการแคชเป็น 10 นาที

                if (!Cache::has('dataBranch')) {
                    $dataBranch = TB_Branchs::where('Zone_Branch', auth()->user()->zone)
                        ->where('Branch_Active', 'yes')
                        ->get();
                    Cache::put('dataBranch', $dataBranch, $minutes);
                } else {
                    $dataBranch = Cache::get('dataBranch');
                }

                if (!Cache::has('dataBILLCOLL')) {
                    $dataBILLCOLL = TB_BILLCOLL::whereNotNull('status')->where('UserZone', auth()->user()->zone)->get();

                    Cache::put('dataBILLCOLL', $dataBILLCOLL, $minutes);
                } else {
                    $dataBILLCOLL = Cache::get('dataBILLCOLL');
                }

                if (!Cache::has('dataTypeGroup')) {
                    $dataTypeGroup = TB_TypeGroups::where('TypeGroup_Status', 'Y')->get();
                    Cache::put('dataTypeGroup', $dataTypeGroup, $minutes);
                } else {
                    $dataTypeGroup = Cache::get('dataTypeGroup');
                }

                if (!Cache::has('userHandler')) {
                    $userHandler = $this->getUserHandlerGroup();
                    Cache::put('userHandler', $userHandler, $minutes);
                } else {
                    $userHandler = Cache::get('userHandler');
                }

                $dataGroup = TB_Groups::withTrashed()
                    ->with([
                        'groupLists' => function ($query) {
                            // return $query->withTrashed();
                        }
                    ])
                    ->where('id', $id)
                    ->first();

                return view('constants.section-constants.content-groups.edit-groups', compact('dataBranch', 'dataBILLCOLL', 'dataTypeGroup', 'userHandler', 'dataGroup'));
            }
        }
    }

    public function update(Request $request, $id)
    {
        $u_zone = auth()->user()->zone;

        if ($request->update == 'contract-type') {
            // dd($request);
            $dataCT = TB_TypeLoan::where('id', $request->data['ID'])->first();
            $dataCT->id_rateType = $request->data['CONT_TYPE'];
            $dataCT->Loan_Code = $request->data['CONT_CODE'];
            $dataCT->Loan_Name = $request->data['CONT_NAME'];
            $dataCT->Code_PLT = $request->data['CODE_PLT'];
            if (@$u_zone == 10) {
                $dataCT->Flagzone_PTN = @$request->data['FLAG'];
            } elseif (@$u_zone == 20) {
                $dataCT->Flagzone_HY = @$request->data['FLAG'];
            } elseif (@$u_zone == 30) {
                $dataCT->Flagzone_NK = @$request->data['FLAG'];
            } elseif (@$u_zone == 40) {
                $dataCT->Flagzone_KB = @$request->data['FLAG'];
            } elseif (@$u_zone == 50) {
                $dataCT->Flagzone_SR = @$request->data['FLAG'];
            }
            $dataCT->update();

            $data = TB_TypeLoan::orderBy('Loan_Code')->get();
            return response()->view('data-system.front-system.data-contracts.contract-type.data', compact('data', 'u_zone'));
        } elseif ($request->update == 'targets-type') {
            $dataType = TB_TypeTarget::where('id', $request->data['ID'])->first();
            $dataType->Target_Name = @$request->data['TARGET_NAME'];
            $dataType->Target_Status = @$request->data['TARGET_STATUS'];
            $dataType->update();

            $data = TB_TypeTarget::orderBy('Target_Code')->get();
            return response()->view('data-system.front-system.data-type-targets.data', compact('data', 'u_zone'));
        } elseif ($request->update == 'promotion') {
            $dataPromotion = TB_Promotios::where('id', $request->data['ID'])->first();
            $dataPromotion->Name_pro = $request->data['PROMOTION_NAME'];
            $dataPromotion->Type_pro = $request->data['PROMOTION_TYPE'];
            $dataPromotion->Value_pro = $request->data['DISCOUNT'];
            $dataPromotion->Detail_pro = $request->data['DETAIL'];
            $dataPromotion->Start_pro = $request->data['START_DATE'];
            $dataPromotion->End_pro = $request->data['END_DATE'];
            $dataPromotion->Status_pro = @$request->data['FLAG'];
            $dataPromotion->update();

            $data = TB_Promotios::where('Zone_pro', $u_zone)->orderBy('Code_pro')->get();
            return response()->view('data-system.front-system.data-promotions.data', compact('data', 'u_zone'));
        } elseif ($request->update == 'company') {
            $dataCompany = TB_Company::where('id', $request->data['ID'])->first();
            $dataCompany->Company_Id = $request->data['TAXID'];
            $dataCompany->Company_Branch = $request->data['CODE'];
            $dataCompany->Company_Name = $request->data['NAMECOMPANY'];
            $dataCompany->Company_Addr = $request->data['ADDRCOMPANY'];
            $dataCompany->Company_Tel = $request->data['PHONE'];
            $dataCompany->Company_Type = $request->data['TYPECOMPANY'];
            $dataCompany->Company_Zone = $u_zone;
            $dataCompany->update();

            $data = TB_Company::where('Company_Zone', $u_zone)->get();
            return response()->view('data-system.front-system.data-companies.data', compact('data', 'u_zone'));

        } elseif ($request->update == 'resoure') {
            $dataResource = TB_TypeCusResources::where('id', $request->data['ID'])->first();
            $dataResource->Name_CusResource = $request->data['NAME_RESOURCES'];
            $dataResource->Flag_CusResource = @$request->data['FLAG'];
            $dataResource->update();

            $data = TB_TypeCusResources::orderBy('Code_CusResource')->get();
            return response()->view('data-system.front-system.data-resources.data', compact('data', 'u_zone'));

        } elseif ($request->update == 'branches') {
            // $dataBranch = TB_Branchs::where('id', $request->data['ID'])->first();
            // $dataBranch->id_Contract = $request->data['CODE'];
            // $dataBranch->Name_Branch = $request->data['NAME_TH'];
            // $dataBranch->NickName_Branch = $request->data['NAME_EN'];
            // $dataBranch->Zone_Branch = $u_zone;
            // $dataBranch->Branch_Active = @$request->data['FLAG'];
            // $dataBranch->update();

            $dataLatLon = $request->data['Position_branch'];
            $dataSplit = explode(",", $dataLatLon);
            $Flag = empty($request->data['FLAG']) ? 'no' : $request->data['FLAG'];

            $response = TB_Branchs::where('id', $request->data['ID'])->update([
                "id_Contract" => $request->data['CODE'],
                "Name_Branch" => $request->data['NAME_TH'],
                "NickName_Branch" => $request->data['NAME_EN'],
                "Zone_Branch" => $u_zone,
                "province_Branch" => $request->data['Province'],
                "lat" => $dataSplit[0],
                "lon" => $dataSplit[1],
                "line_id" => $request->data['LineId'],
                "open_time" => $request->data['OpenDate'],
                "address" => $request->data['Branch_Address'],
                "phoneNo" => $request->data['PhoneNumber'],
                "Branch_Active" => $Flag,
            ]);

            $data = TB_Branchs::where('Zone_Branch', $u_zone)->orderBy('id_Contract')->get();
            return response()->view('data-system.front-system.data-branches.data', compact('data', 'u_zone'));
        } elseif ($request->update == 'banks') {
            $Setdata = explode("|", $request->data['TYPECOMPANY']);
            // $dataBank = new TB_BankAccounts;
            $dataBank = TB_BankAccounts::where('id', $request->data['ID'])->first();
            $dataBank->Com_Id = $Setdata[0];
            $dataBank->Account_Bank = $request->data['BANK_NAME'];
            $dataBank->Account_Number = $request->data['NO_ACCOUNT'];
            $dataBank->Account_Name = $request->data['NAME_ACCOUNT'];
            $dataBank->company_bank = $Setdata[1];
            $dataBank->company_type = $Setdata[0];
            $dataBank->User_Zone = $u_zone;
            $dataBank->Flag_Bank = @$request->data['FLAG'];
            $dataBank->Inside_Active = @$request->data['INSIDE'];
            $dataBank->update();

            $data = TB_BankAccounts::where('User_Zone', $u_zone)->get();
            return response()->view('data-system.front-system.data-banks.data', compact('data', 'u_zone'));
        } elseif ($request->update == 'targets') {

        } elseif ($request->update == 'ms-teams') {

        } elseif ($request->update == 'data-groups') {
            DB::beginTransaction();
            try {
                $task = TB_Groups::where('id', $id)->first();
                $task->groupStatus = 'active';
                $task->groupName = $request->data['taskName'];
                $task->groupDate = date('Y-m-d', strtotime($request->data['taskDate']));
                $task->groupType = implode(',', $request->data['taskType']);
                $task->groupHandler = (isset($request->data['taskHandler']) ? implode(',', $request->data['taskHandler']) : null);
                $task->flagSelect = $request->data['flexRadioDefault'];
                $task->groupZone = auth()->user()->zone;
                $task->groupDesc = $request->data['taskdesc'];
                $task->update();
                $task->groupLists()->forceDelete();

                if ($request->data['flexRadioDefault'] == 'BRANCH') {
                    $dataloop = $request->data['taskBranch'];
                } else {
                    $dataloop = $request->data['taskbillcoll'];
                }

                foreach ($dataloop as $data) {
                    $task->groupLists()->create([
                        'listStatus' => 'active',
                        'listDate' => date('Y-m-d', strtotime($request->data['taskDate'])),
                        'listBranch_id' => $data,
                    ]);
                }
                DB::commit();

                $dataGroup = TB_Groups::withTrashed()
                    // ->with([
                    //     'groupLists' => function ($query) {
                    //         return $query->withTrashed();
                    //     }
                    // ])->get();
                    ->get();
                $viewData = view('constants.section-constants.content-groups.data-groups', compact('dataGroup'))->render();
                return response()->json(['html' => $viewData, 'code' => 200], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['message' => $e->getMessage(), 'code' => 500], 500);
            }
        } elseif ($request->update == 'billcolls') {
            $dataBillColl = TB_BILLCOLL::where('id', $request->data['ID'])->first();
            $dataBillColl->code_billcoll = $request->data['code_billcoll'];
            $dataBillColl->name_billcoll = $request->data['name_billcoll'] ?? null;
            $dataBillColl->UserZone = $u_zone;
            $dataBillColl->status = $request->data['status'] ?? null;
            $dataBillColl->type_billcoll = $request->data['type_billcoll'];
            $dataBillColl->note_billcoll = $request->data['note_billcoll'];
            $dataBillColl->UserBranch = $request->data['UserBranch'];
            $dataBillColl->update();

            $data = TB_BILLCOLL::where('UserZone', $u_zone)->orderBy('id')->get();
            return response()->view('data-system.front-system.data-billcolls.data', compact('data', 'u_zone'));
        } elseif ($request->update == 'editable-table') { // คลิกที่ช่องแล้วบันทึกตาราง

            $id = $request->input('id');
            $column = $request->input('column');
            $value = $request->input('value');

            // ตรวจสอบตารางที่จะบันทึก แล้วเรียกใช้ Model นั้น ๆ
            if ($request->table == 'TB_DSCRATEHP') {
                $row = TB_DSCRATEHP::find($id);
            }
            
            if ($row) {
                $row->$column = $value;
                if ($row->save()) {
                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['success' => false]);
                }
            } else {
                return response()->json(['success' => false]);
            }
        } elseif ($request->update == 'gradecont') {
            if ($request->ajax()) {
                TB_GRADECONT::where('OVERDUE',$request->pk)->update([
                    $request->name => $request->value
                ]);
                return response()->json(['success' => true]);
            }
        } elseif ($request->update == 'trlist') {
            $dataList = TB_TRLIST::where('id', $request->data['ID'])->first();
            $dataList->NAME = $request->data['NAME'];
            $dataList->STATUS = (@$request->data['STATUS']!=null)?@$request->data['STATUS']:'N';
            $dataList->update();

            $data = TB_TRLIST::get();
            return response()->view('data-system.back-system.data-trlist.data', compact('data', 'u_zone'));
        } elseif ($request->update == 'trlist') {
            DB::beginTransaction();
            try {
                $dataList = TB_TRLIST::where('id', $request->data['ID'])->first();
                $dataList->NAME = $request->data['NAME'];
                $dataList->STATUS = (@$request->data['STATUS']!=null)?@$request->data['STATUS']:'N';
                $dataList->update();

                DB::commit();
                $data = TB_TRLIST::get();
                return response()->view('data-system.back-system.data-trlist.data', compact('data', 'u_zone'));
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['message' => $e->getMessage(), 'code' => 500], 500);
            }
        } elseif ($request->update == 'trdeliver') {
            DB::beginTransaction();
            try {
                $dataDeliver = TB_TRDELIVER::where('id', $request->data['ID'])->first();
                $dataDeliver->NAME = $request->data['NAME'];
                $dataDeliver->STATUS = (@$request->data['STATUS']!=null)?@$request->data['STATUS']:'N';
                $dataDeliver->update();

                DB::commit();
                $data = TB_TRDELIVER::get();
                return response()->view('data-system.back-system.data-trdeliver.data', compact('data','u_zone'));
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['message' => $e->getMessage(), 'code' => 500], 500);
            }
        }
        
    }
    public function destroy(Request $request, $id)
    {
        if ($request->destroy == 'inactive-groups') {
            DB::beginTransaction();
            try {
                $data = TB_Groups::where('id', $id)->withTrashed()->first();
                $data->update([
                    'groupStatus' => 'inactive',
                ]);
                $data->groupLists()->update([
                    'listStatus' => 'inactive',
                    'deleted_at' => Carbon::now(),
                ]);
                $data->delete();
                DB::commit();

                $dataGroup = TB_Groups::withTrashed()
                    ->with([
                        'groupLists' => function ($query) {
                            return $query->withTrashed();
                        }
                    ])->get();
                $viewData = view('constants.section-constants.content-groups.data-groups', compact('dataGroup'))->render();
                return response()->json(['html' => $viewData, 'code' => 200], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['code' => 500], 500);
            }
        } elseif ($request->destroy == 'active-groups') {
            DB::beginTransaction();
            try {
                $data = TB_Groups::where('id', $id)->withTrashed()->first();
                $data->update([
                    'groupStatus' => 'active',
                ]);
                $data->restore();
                $data->groupLists()->restore();
                $data->groupLists()->update([
                    'listStatus' => 'active',
                ]);
                DB::commit();

                $dataGroup = TB_Groups::withTrashed()
                    ->with([
                        'groupLists' => function ($query) {
                            return $query->withTrashed();
                        }
                    ])->get();
                $viewData = view('constants.section-constants.content-groups.data-groups', compact('dataGroup'))->render();
                return response()->json(['html' => $viewData, 'code' => 200], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['code' => 500], 500);
            }
        }
    }
}