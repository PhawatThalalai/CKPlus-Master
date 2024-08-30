<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Middleware\RoleOrPermissionMiddleware;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

use App\Models\TB_Assets\Data_AssetsOwnership;
use App\Models\TB_Constants\TB_Frontend\TB_BankAccounts;
use App\Models\TB_Constants\TB_Frontend\TB_StatusAudits;
use App\Models\TB_Constants\TB_Frontend\TB_TypeBroker;
use App\Models\TB_Constants\TB_Frontend\TB_Zone;
use App\Models\TB_DataCus\Data_Broker;

use App\Models\TB_Logs\Log_ContractsCon;
use App\Models\TB_Logs\Data_CredoCodes;
use App\Models\TB_PactContracts\Pact_Contracts;
use App\Models\TB_PactContracts\View_ReportPAData;

use App\Models\TB_view\View_ContractAudit;
use App\Models\TB_DataCus\Data_CusTags;
use App\Models\TB_DataCus\Data_Customers;

use App\Models\TB_Constants\TB_Frontend\Data_CreditBanks;
use App\Models\TB_Constants\TB_Frontend\TB_Prefix;
use App\Models\TB_Constants\TB_Frontend\TB_UniqueID_Type;
use App\Models\TB_Constants\TB_Frontend\TB_StatusTagParts;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_Constants\TB_Frontend\TB_TypeLoan;
use App\Models\TB_Constants\TB_Frontend\TB_StatusCon;
use App\Models\TB_Constants\TB_Frontend\TB_BankThai;



class ViewController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $page = $request->page;
            $pageEnable = ['credit-loans', 'data-warehoure', 'financial-approval'];

            if (in_array($page, $pageEnable)) {
                // Auth::getDefaultDriver()
                // $this->middleware('permission:' . $page . '-view', ['only' => ['index']]);
                return (new RoleOrPermissionMiddleware)->handle($request, $next, $page);
            } else {
                return $next($request);
            }
        });
    }
    public function index(Request $request)
    {
        $user_zone = auth()->user()->zone;
        $dataBranch = TB_Branchs::generateQuery();
        $status_cus = TB_StatusTagParts::get();
        $type_broker = TB_TypeBroker::get();
        $status_audit = TB_StatusAudits::getStatusAudit();
        $statusTxt = $request->statusTxt;
        $page = $request->page;
        $Fdate1 = @$request->start;
        $Tdate1 = @$request->end;
        $btn_statuscus = false;
        $btn_print = false;
        $btn_statuscon = false;
        $btn_statusaudit = false;
        $start = date_create($Fdate1);
        $Fdate = ($Fdate1 != NULL) ? date_format($start, "Y-m-d") : null;
        $end = date_create($Tdate1);
        $Tdate = ($Tdate1 != NULL) ? date_format($end, "Y-m-d") : null;

        if ($request->page == 'walkin-cus') {
            $title = 'CUSTOMER INFO';
            $title_small = '(รายการรับลูกค้า)';
            $menu = 'ระบบ ข้อมูลประจำวัน';
            $sub_menu = 'รายการลูกค้า';

            $sidebarMain = 'trackcus-active';
            $sidebarSec = 'viewcus-active';

            if (empty($Fdate) or empty($Tdate)) {
                $Fdate = date('Y-m-d');
                $Tdate = date('Y-m-d');
            }
            $countDataBranch = Data_Customers::
                when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereBetween('date_Cus', [$Fdate, $Tdate]);
                })
                ->selectRaw('UserBranch, count(*) as total')
                ->groupBy('UserBranch')
                ->where('UserZone', $user_zone)
                ->get()
                ->reduce(function ($result, $item) {
                    $result[$item->UserBranch] = $item->total;
                    return $result;
                }, []);

            return view('frontend.content-view.view-cus', compact('title', 'title_small', 'menu', 'sub_menu', 'sidebarMain', 'sidebarSec', 'dataBranch', 'countDataBranch', 'Fdate1', 'Tdate1', 'status_cus', 'statusTxt', 'page'));
        } elseif ($request->page == 'tracking-cus') {
            $title = 'CUSTOMER TRACKING';
            $title_small = '(ติดตามลูกค้า)';
            $menu = 'ระบบ ข้อมูลประจำวัน';
            $sub_menu = 'รายการติดตามลูกค้า';

            $sidebarMain = 'trackcus-active';
            $sidebarSec = 'Track02-active';
            $btn_statuscus = false;
            $btn_print = true;

            $countDataBranch = Data_CusTags::where('UserZone', $user_zone)
                ->whereHas('ViewtoDataCus', function ($query) {
                    $query->where('Status_Cus', '!=', 'cancel');
                })

                ->when($statusTxt != 'all', function ($q) use ($statusTxt) {
                    return $q->where('Status_Tag', $statusTxt != '' ? $statusTxt : 'active');
                })

                ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereBetween('date_Tag', [$Fdate, $Tdate]);
                })

                ->selectRaw('BranchCont, count(*) as total')
                ->groupBy('BranchCont')
                // ->whereIn('successor_status',['','completed'])
                ->get()
                ->reduce(function ($result, $item) {
                    $result[$item->BranchCont] = $item->total;
                    return $result;
                }, []);

            // ->when(empty($Fdate) , function($q) use ($Fdate) {
            //     return $q->where(DB::raw(" FORMAT (cast(date_Tag as date), 'yyyy-MM')"),date('Y-m'));
            // })

            // $CountdataCus = $dataCusSelect2->select('UserBranch', DB::raw('count(*) as total'))->groupBY('UserBranch')->get();
            $dataCus = ''; //$dataCusSelect->orderBY('date_Tag', 'DESC')->get();

            // $countDataBranch = array();
            // foreach ($CountdataCus as $key => $value) {
            //     $countDataBranch[$value->UserBranch] = $value->total;
            // }

            return view('frontend.content-view.view-cus', compact('title', 'title_small', 'menu', 'sub_menu', 'sidebarMain', 'btn_statuscus', 'btn_print', 'sidebarSec', 'dataBranch', 'dataCus', 'countDataBranch', 'page', 'Fdate1', 'Tdate1', 'status_cus', 'statusTxt'));
        } elseif ($request->page == 'tracking-gm') {
            $title = 'CUSTOMER TRACKING GM';
            $title_small = '(ติดตามส่ง GM)';
            $menu = 'ระบบ ข้อมูลประจำวัน';
            $sub_menu = 'รายการลูกค้า';

            $sidebarMain = 'trackcus-active';
            $sidebarSec = 'Track03-active';

            $statusCus = true;
            $dataCusSelect2 = Data_CusTags::where('UserZone', $user_zone)
                ->whereHas('TagToDataCus', function ($query) {
                    $query->where('Status_Cus', '!=', 'cancel');
                })
                ->where('successor_status', 'active')
                ->where('Status_Tag', $statusTxt != '' ? $statusTxt : 'active')
                ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereBetween('date_Tag', [$Fdate, $Tdate]);
                });

            $CountdataCus = $dataCusSelect2->select('UserBranch', DB::raw('count(*) as total'))->groupBY('UserBranch')->get();
            $dataCus = ''; //$dataCusSelect->orderBY('date_Tag', 'DESC')->get();

            $countDataBranch = array();
            foreach ($CountdataCus as $key => $value) {
                $countDataBranch[$value->UserBranch] = $value->total;
            }

            return view('frontend.content-view.view-cus', compact('title', 'title_small', 'menu', 'sub_menu', 'sidebarMain', 'sidebarSec', 'btn_statuscus', 'btn_print', 'dataBranch', 'dataCus', 'countDataBranch', 'Fdate1', 'Tdate1', 'status_cus', 'statusTxt', 'page'));
        } elseif ($request->page == 'brokers') {
            $title = 'BROKER INFO ';
            $title_small = '(ข้อมูลนายหน้า)';
            $menu = 'ระบบ ข้อมูลประจำวัน';
            $sub_menu = 'รายการนายหน้า';

            $sidebarMain = 'broker-active';
            $sidebarSec = 'broker02-active';

            if (empty($Fdate) or empty($Tdate)) {
                $Fdate = date('Y-m-d');
                $Tdate = date('Y-m-d');
            }

            $countDataBranch = Data_Broker::where('UserZone', $user_zone)
                ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereBetween('date_Broker', [$Fdate, $Tdate]);
                })
                ->when(!empty($statusTxt), function ($q) use ($statusTxt) {
                    return $q->where('type_Broker', $statusTxt);
                })
                ->with([
                    'BrokerToDataCus' => function ($query) {
                        return $query->where('Status_Cus', '!=', 'cancel');
                    }
                ])
                ->selectRaw('UserBranch, count(*) as total')
                ->groupBy('UserBranch')
                ->get()
                ->reduce(function ($result, $item) {
                    $result[$item->UserBranch] = $item->total;
                    return $result;
                }, []);

            $dataCus = '';



            return view('frontend.content-view.view-broker', compact('title', 'title_small', 'menu', 'sub_menu', 'sidebarMain', 'sidebarSec', 'dataBranch', 'dataCus', 'countDataBranch', 'Fdate1', 'Tdate1', 'status_cus', 'statusTxt', 'page', 'type_broker'));
        } elseif ($request->page == 'assets') {
            $title = 'ASSET DATA DAILY';
            $title_small = '(ข้อมูลบันทึกทรัพย์สิน)';
            $menu = 'ระบบ ข้อมูลบันทึกทรัพย์สิน';
            $sub_menu = 'รายการทรัพย์สิน';

            $sidebarMain = 'trackcus-active';
            $sidebarSec = 'Track02-active';
            $btn_print = false;
            $btn_statuscus = false;

            // $countDataBranch = DB::table('View_DataAssetDetail')
            $countDataBranch = Data_AssetsOwnership::
                selectRaw('UserBranch,count(UserBranch) as total')
                ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereRaw("FORMAT (cast(created_at as date), 'yyyy-MM-dd') between '" . $Fdate . "' and '" . $Tdate . "' ");
                })
                ->when(empty($Fdate) || empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereRaw("FORMAT (cast(created_at as date), 'yyyy-MM-dd') = FORMAT (cast(GETDATE() as date), 'yyyy-MM-dd')  ");
                })
                ->where('UserZone', $user_zone)
                ->groupBy('UserBranch')
                ->get()
                ->reduce(function ($result, $item) {
                    $result[$item->UserBranch] = $item->total;
                    return $result;
                }, []);
            return view('frontend.content-view.view-asset', compact('title', 'title_small', 'menu', 'sub_menu', 'sidebarMain', 'btn_statuscus', 'btn_print', 'sidebarSec', 'dataBranch', 'countDataBranch', 'page', 'Fdate1', 'Tdate1', 'status_cus', 'statusTxt'));
        } elseif ($request->page == 'profile-cus') {
            $id = $request->id;
            $data = Data_Customers::where('id', $id)
                ->with([
                    'DataCusToDataCusTag' => function ($query) {
                        return $query->orderBy('id', 'DESC');
                    }
                ])
                ->first();

            return view('frontend.content-cus.view-cus', compact('data', 'page'));
        } elseif ($request->page == 'new-cus') {
            $TBPrefix = TB_Prefix::queryPrefix();
            $TypeCard = TB_UniqueID_Type::GetTypeCard();
            $NameAccount = TB_BankThai::get();
            $TBZone = TB_Zone::get();

            return view('frontend.content-cus.create-cus', compact('TBPrefix', 'TBZone', 'TypeCard', 'NameAccount', 'page'));
        } elseif ($request->page == 'approve-loans') {
            /*** reset value */
            $Fdate = ($Fdate1 != NULL) ? date_format($start, "Y-m-d") : '';
            $Tdate = ($Tdate1 != NULL) ? date_format($end, "Y-m-d") : '';

            $loanCode = $request->loanCode;
            $statusTxt = $request->statusTxt;

            $loanTb = TB_TypeLoan::where('Loan_Code', $loanCode)->first();
            $StatusCon = TB_StatusCon::where('Active', 'yes')->get();

            $title = 'สินเชื่อ ' . $loanTb->Loan_Name;
            $title_small = '(Contract Loans' . ' ( ' . $loanTb->Loan_Code . ' ))';
            $menu = 'ระบบ อนุมัตืสินเชือ';
            $sub_menu = 'สินเชือ ' . (($loanTb->Loan_Com == 2) ? 'เช่าซื้อ' : 'เงินกู้');

            $sidebarMain = $loanTb->Loan_Com . '-active';
            $sidebarSec = $loanTb->Loan_Com . $loanTb->Loan_Group . '-active';
            $sidebarTs = $loanTb->id_rateType . $loanTb->Loan_Code . '-active';

            $countDataBranch = Pact_Contracts::where('UserZone', $user_zone)
                ->where('CodeLoan_Con', $loanCode)
                ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereBetween('Date_con', [$Fdate, $Tdate]);
                })
                ->when(!empty($statusTxt), function ($q) use ($statusTxt) {
                    return $q->where('Status_Con', $statusTxt);
                })
                ->when(empty($statusTxt), function ($q) use ($statusTxt) {
                    return $q->whereIN('Status_Con', ['active', 'pending', 'complete']);
                })
                //->where('Status_Con', $statusTxt != '' ? $statusTxt : 'active')
                ->selectRaw('BranchSent_Con, count(*) as total')
                ->groupBy('BranchSent_Con')
                ->get()
                ->reduce(function ($result, $item) {
                    $result[$item->BranchSent_Con] = $item->total;
                    return $result;
                }, []);

            return view(
                'frontend.content-view.view-cont',
                compact(
                    'title',
                    'title_small',
                    'menu',
                    'sub_menu',
                    'sidebarMain',
                    'sidebarSec',
                    'btn_statuscon',
                    'StatusCon',
                    'btn_print',
                    'sidebarTs',
                    'page',
                    'dataBranch',
                    'loanTb',
                    'loanCode',
                    'statusTxt',
                    'Fdate1',
                    'Tdate1',
                    'countDataBranch',
                    'page',
                )
            );
        } elseif ($request->page == 'sendoffice') {
            $btn_statusaudit = true;
            $title = 'รายการ เอกสารรอนำส่ง';
            $title_small = '(waiting for delivered)';

            $countDataBranch = DB::table('View_ContractAuditEx1')
                ->where('UserZone', $user_zone)
                ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereRaw("cast(Date_monetary as date) between '" . $Fdate . "' and '" . $Tdate . "'");
                })
                ->where(DB::raw("FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"), '>=', '2024-01-01')
                ->when($statusTxt != 'all', function ($q) use ($statusTxt) {
                    return $q->where('Flag_Status', $statusTxt != '' ? $statusTxt : NULL);
                })
                ->whereNotNull('Date_monetary')
                ->selectRaw('BranchSent_Con, count(*) as total')
                ->groupBy('BranchSent_Con')
                ->get()
                ->reduce(function ($result, $item) {
                    $result[$item->BranchSent_Con] = $item->total;
                    return $result;
                }, []);


            return view(
                'frontend.content-view.view-sendDocs',
                compact(
                    'title',
                    'title_small',
                    'btn_statuscon',
                    'btn_statusaudit',
                    'btn_print',
                    'dataBranch',
                    'Fdate1',
                    'Tdate1',
                    'countDataBranch',
                    'status_audit',
                    'page',
                    'statusTxt'
                )
            );
        } elseif ($request->page == 'credit-loans') {
            $this->resetSession_alll();
            $title = 'รายการ เอกสารตรวจสอบ';
            $title_small = '(Check Document lists)';

            $countDataBranch = DB::table('View_ContractAuditEx1')
                ->where('UserZone', $user_zone)
                ->where(DB::raw("FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"), '>=', '2024-01-01')
                ->whereIn('Flag_Status', [2, 3])
                ->selectRaw('BranchSent_Con, count(*) as total')
                ->groupBy('BranchSent_Con')
                ->get()
                ->reduce(function ($result, $item) {
                    $result[$item->BranchSent_Con] = $item->total;
                    return $result;
                }, []);

            $countReceived = DB::table('View_ContractAuditEx1')
                ->where('UserZone', auth()->user()->zone)
                ->where('Flag_Status', 1)
                ->where(DB::raw("FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"), '>=', '2024-01-01')
                ->count();

            $countEdited = DB::table('View_ContractAuditEx1')
                ->where('UserZone', auth()->user()->zone)
                ->where('Flag_Status', 5)
                ->where(DB::raw("FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"), '>=', '2024-01-01')
                ->count();

            session()->put('dataBranch', $dataBranch);
            return view(
                'frontend.content-view.view-auditCheck',
                compact(
                    'title',
                    'title_small',
                    'btn_statuscon',
                    'btn_print',
                    'dataBranch',
                    'Fdate1',
                    'Tdate1',
                    'countDataBranch',
                    'page',
                    'countReceived',
                    'countEdited'
                )
            );
        } elseif ($request->page == 'rejectDocs') {
            $title = 'รายการ เอกสารไม่สมบูรณ์';
            $title_small = '(document corrections)';

            $countDataBranch = DB::table('View_ContractAuditEx1')
                ->where('UserZone', $user_zone)
                ->where('Flag_Status', 4)
                ->selectRaw('BranchSent_Con, count(*) as total')
                ->groupBy('BranchSent_Con')
                ->get()
                ->reduce(function ($result, $item) {
                    $result[$item->BranchSent_Con] = $item->total;
                    return $result;
                }, []);


            return view(
                'frontend.content-view.view-rejectDocs',
                compact(
                    'title',
                    'title_small',
                    'btn_statuscon',
                    'btn_print',
                    'dataBranch',
                    'Fdate1',
                    'Tdate1',
                    'countDataBranch',
                    'page'
                )
            );
        } elseif ($request->page == 'data-warehoure') {
            $title = 'รายการ เอกสารรอเข้าเซฟ';
            $title_small = '(document corrections)';

            $countDataBranch = DB::table('View_ContractAuditEx1')
                ->where('UserZone', $user_zone)
                ->where('Flag_Status', 6)
                ->selectRaw('BranchSent_Con, count(*) as total')
                ->groupBy('BranchSent_Con')
                ->get()
                ->reduce(function ($result, $item) {
                    $result[$item->BranchSent_Con] = $item->total;
                    return $result;
                }, []);


            return view(
                'frontend.content-view.view-completeDocs',
                compact(
                    'title',
                    'title_small',
                    'btn_statuscon',
                    'btn_print',
                    'dataBranch',
                    'Fdate1',
                    'Tdate1',
                    'countDataBranch',
                    'page'
                )
            );
        } elseif ($request->page == 'financial-approval') {
            $title = 'รายการ โอนเงินสินเชื่อ';
            $title_small = '(loan transfer)';

            $credit_Balance = Data_CreditBanks::where('Bank_Zone', $user_zone)
                ->where('Date_CreditIn', date('Y-m-d'))
                ->get();

            $bank = TB_BankAccounts::where('User_Zone', $user_zone)->get();

            $countContractNow = DB::table('View_ContractAuditEx1')
                ->where('UserZone', $user_zone)
                ->whereNotIn('Status_Con', ['cancel', 'close'])
                ->whereNull('Date_Approve_tranfers')
                ->whereNotNull('nameConfirm')
                ->whereDate('DateConfirmApp_Con', Carbon::today())
                ->selectRaw('Loan_Com, count(*) as total')
                ->groupBy('Loan_Com')
                ->get()
                ->reduce(function ($result, $item) {
                    $result[$item->Loan_Com] = $item->total;
                    return $result;
                }, []);


            $countContractOld = DB::table('View_ContractAuditEx1')
                ->where('UserZone', $user_zone)
                ->whereNotIn('Status_Con', ['cancel', 'close'])
                // ->whereNull('Date_monetary')
                ->whereNotNull('nameConfirm')
                ->whereNull('Date_Approve_tranfers')
                ->whereDate('DateConfirmApp_Con', '<=', Carbon::yesterday())
                ->selectRaw('Loan_Com, count(*) as total')
                ->groupBy('Loan_Com')
                ->get()
                ->reduce(function ($result, $item) {
                    $result[$item->Loan_Com] = $item->total;
                    return $result;
                }, []);

            return view(
                'frontend.content-view.view-treas',
                compact(
                    'bank',
                    'countContractNow',
                    'countContractOld',
                    'credit_Balance',
                    'title',
                    'title_small',
                    'page'
                )
            );
        } elseif ($request->page == 'data-assets') {
            return view('frontend.content-asset.section-asset.view', compact('page'));
        } elseif ($request->page == 'rejectedPA') {
            $title = 'CONTRACTS PA REJECTED';
            $title_small = '(สัญญาประกัน PA ไม่สมบูรณ์)';
            $menu = 'ระบบ ตรวจเอกสาร';
            $sub_menu = 'ยื่นขอประกัน';

            $sidebarMain = 'Checkerloans-active';
            $sidebarSec = 'navPa-active';
            $btn_statuscus = false;
            $btn_print = true;

            $countDataBranch = View_ReportPAData::where('UserZone', $user_zone)
                ->whereHas('ViewtoDataCus', function ($query) {
                    $query->where('Status_Cus', '!=', 'cancel');
                })
                ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereBetween('Date_monetary', [$Fdate, $Tdate]);
                })

                // ->when($statusTxt != 'all', function ($q) use ($statusTxt) {
                //     return $q->where('Status_Tag', $statusTxt != '' ? $statusTxt : 'active');
                // })
                ->selectRaw('BranchSent_Con, count(*) as total')
                ->groupBy('BranchSent_Con')
                ->get()
                ->reduce(function ($result, $item) {
                    $result[$item->BranchSent_Con] = $item->total;
                    return $result;
                }, []);
            // dd( $countDataBranch);


            // $CountdataCus = $dataCusSelect2->select('UserBranch', DB::raw('count(*) as total'))->groupBY('UserBranch')->get();
            $dataCus = ''; //$dataCusSelect->orderBY('date_Tag', 'DESC')->get();

            // $countDataBranch = array();
            // foreach ($CountdataCus as $key => $value) {
            //     $countDataBranch[$value->UserBranch] = $value->total;
            // }

            return view('frontend.content-view.view-rejectedPA', compact('title', 'title_small', 'menu', 'sub_menu', 'sidebarMain', 'btn_statuscus', 'btn_print', 'sidebarSec', 'dataBranch', 'dataCus', 'countDataBranch', 'page', 'Fdate1', 'Tdate1', 'status_cus', 'statusTxt'));
        } elseif ($request->page == 'PP-Lead') {
            $title = 'CUSTOMER PP LEAD';
            $title_small = '(ลูกค้าออนไลน์)';
            $menu = 'ระบบ ข้อมูลประจำวัน';
            $sub_menu = 'ลูกค้าออนไลน์';

            $sidebarMain = 'trackcus-active';
            $sidebarSec = 'PP-Lead-active';

            if (empty($Fdate) or empty($Tdate)) {
                $Fdate = date('Y-m-d');
                $Tdate = date('Y-m-d');
            }
            $countDataBranch = Data_Customers::
                when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereBetween('date_Cus', [$Fdate, $Tdate]);
                })
                ->selectRaw('UserBranch, count(*) as total')
                ->groupBy('UserBranch')
                ->where('UserZone', $user_zone)
                ->where('type_Cus', 'api')
                ->get()
                ->reduce(function ($result, $item) {
                    $result[$item->UserBranch] = $item->total;
                    return $result;
                }, []);

            return view('frontend.content-view.view-cus', compact('title', 'title_small', 'menu', 'sub_menu', 'sidebarMain', 'sidebarSec', 'dataBranch', 'countDataBranch', 'Fdate1', 'Tdate1', 'status_cus', 'statusTxt', 'page'));
        }
    }
    public function store(Request $request)
    {
        $user_zone = auth()->user()->zone;
        $statusTxt = $request->statusTxt;
        $Fdate1 = @$request->start;
        $Tdate1 = @$request->end;
        $id = @$request->id;

        $start = date_create($Fdate1);
        $Fdate = ($Fdate1 != NULL) ? date_format($start, 'Y-m-d') : null;
        $end = date_create($Tdate1);
        $Tdate = ($Tdate1 != NULL) ? date_format($end, 'Y-m-d') : null;

        $dataBranch2 = TB_Branchs::where('id', $request->id)->first();

        if ($request->page == 'walkin-cus') {
            if (empty($Fdate) or empty($Tdate)) {
                $Fdate = date('Y-m-d');
                $Tdate = date('Y-m-d');
            }

            $dataCus = Data_Customers::
                when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereBetween('date_Cus', [$Fdate, $Tdate]);
                })
                ->where('UserBranch', $request->id)
                ->where('UserZone', $user_zone)->get();

            $returnHTML = view('frontend.content-view.data-Cus', compact('dataCus', 'dataBranch2'))->render();
            return response()->json(['html' => $returnHTML]);
        } elseif ($request->page == 'tracking-cus') { //tag datacus
            $dataCus = Data_CusTags::leftJoin('Data_Customers', function ($join) {
                $join->on('Data_CusTags.DataCus_id', '=', 'Data_Customers.id');
            })
                ->leftJoin('Data_CusTagCalculates', function ($join) {
                    $join->on('Data_CusTags.id', '=', 'Data_CusTagCalculates.DataTag_id');
                })
                ->leftJoin('TB_TypeLoans', function ($join) {
                    $join->on('TB_TypeLoans.Loan_Code', '=', 'Data_CusTagCalculates.CodeLoans');
                })
                // เพิ่มผู้ลงบันทึก
                ->leftJoin('users AS User_Insert', function ($join) {
                    $join->on('Data_CusTags.UserInsert', '=', 'User_Insert.id');
                })
                ->selectRaw("Data_Customers.Prefix,Data_Customers.PrefixOther,
                    Data_Customers.Name_Cus,Data_Customers.date_Cus,
                    Data_Customers.Phone_cus,Data_Customers.image_cus,
                    Data_Customers.Status_Cus,Data_Customers.id as cusid,Data_CusTags.date_Tag,
                    Data_CusTags.Status_Tag,Data_CusTags.Code_Tag,TB_TypeLoans.Loan_Name,
                    Data_CusTags.successor_status, User_Insert.name AS user_insert_name,Data_CusTags.id,Data_CusTags.flag_reject")


                ->when($statusTxt != 'all', function ($q) use ($statusTxt) {
                    return $q->where('Data_CusTags.Status_Tag', $statusTxt != '' ? $statusTxt : 'active');

                })

                ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereBetween('Data_CusTags.date_Tag', [$Fdate, $Tdate]);
                })
                ->where('Data_Customers.Status_Cus', '!=', 'cancel')
                ->where('Data_CusTags.BranchCont', $request->id)
                // ->whereNotIn('successor_status',['active'])
                ->where('Data_CusTags.UserZone', $user_zone)
                ->orderBY('Data_CusTags.date_Tag', 'DESC')
                ->get();


            $returnHTML = view('frontend.content-view.data-tagCus', compact('dataCus', 'dataBranch2'))->render();
            return response()->json(['html' => $returnHTML]);
        } elseif ($request->page == 'assets') {

            $dataAsset = Data_AssetsOwnership::
                // $dataAsset = DB::table('View_DataAssetDetail')
                when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereRaw("FORMAT (cast(created_at as date), 'yyyy-MM-dd') between '" . $Fdate . "' and '" . $Tdate . "' ");
                })
                ->when(empty($Fdate) || empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereRaw("FORMAT (cast(created_at as date), 'yyyy-MM-dd') = FORMAT (cast(GETDATE() as date), 'yyyy-MM-dd')  ");
                })
                ->where('UserZone', $user_zone)
                ->where('UserBranch', $request->id)
                ->orderBY('id', 'ASC')
                ->get();

            $returnHTML = view('frontend.content-view.data-asset', compact('dataAsset', 'dataBranch2'))->render();
            return response()->json(['html' => $returnHTML]);
        } elseif ($request->page == 'tracking-gm') {
            $dataCus = Data_CusTags::leftJoin('Data_Customers', function ($join) {
                $join->on('Data_CusTags.DataCus_id', '=', 'Data_Customers.id');
            })
                ->leftJoin('Data_CusTagCalculates', function ($join) {
                    $join->on('Data_CusTags.id', '=', 'Data_CusTagCalculates.DataTag_id');
                })
                ->leftJoin('TB_TypeLoans', function ($join) {
                    $join->on('TB_TypeLoans.Loan_Code', '=', 'Data_CusTagCalculates.CodeLoans');
                })
                ->selectRaw("Data_Customers.Prefix,Data_Customers.PrefixOther,
                    Data_Customers.Name_Cus,Data_Customers.date_Cus,
                    Data_Customers.Phone_cus,Data_Customers.image_cus,
                    Data_Customers.Status_Cus,Data_Customers.id,Data_CusTags.date_Tag,
                    Data_CusTags.Status_Tag,Data_CusTags.Code_Tag,TB_TypeLoans.Loan_Name,
                    Data_CusTags.successor")
                ->where('Data_CusTags.Status_Tag', $statusTxt != '' ? $statusTxt : 'active')
                ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereBetween('Data_CusTags.date_Tag', [$Fdate, $Tdate]);
                })
                ->where('Data_Customers.Status_Cus', '!=', 'cancel')
                ->where('Data_CusTags.UserZone', $user_zone)
                ->where('Data_CusTags.BranchCont', $request->id)
                ->where('successor_status', 'active')
                ->orderBY('Data_CusTags.date_Tag', 'DESC')
                ->get();

            $returnHTML = view('frontend.content-view.data-tagGM', compact('dataCus', 'dataBranch2'))->render();
            return response()->json(['html' => $returnHTML]);
        } elseif ($request->page == 'brokers') {

            if (empty($Fdate) or empty($Tdate)) {
                $Fdate = date('Y-m-d');
                $Tdate = date('Y-m-d');
            }

            $dataCus = Data_Broker::where('UserZone', $user_zone)
                ->with([
                    'BrokerToDataCus' => function ($query) {
                        return $query->where('Status_Cus', '!=', 'cancel');
                    }
                ])
                ->where('UserBranch', $request->id)
                ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereBetween('date_Broker', [$Fdate, $Tdate]);
                })
                ->when(!empty($statusTxt), function ($q) use ($statusTxt) {
                    return $q->where('type_Broker', $statusTxt);
                })->get();

            $returnHTML = view('frontend.content-view.data-broker', compact('dataCus', 'dataBranch2'))->render();
            return response()->json(['html' => $returnHTML]);
        } elseif ($request->page == 'approve-loans') {
            $loanCode = $request->loanCode;
            $loanTb = TB_TypeLoan::where('Loan_Code', $loanCode)->first();
            $title = ' รายการขออนุมัติสัญญา (' . $loanTb->Loan_Code . ')' . ' ' . $loanTb->Loan_Name;

            /*** reset value */
            $Fdate = ($Fdate1 != NULL) ? date_format($start, "Y-m-d") : '';
            $Tdate = ($Tdate1 != NULL) ? date_format($end, "Y-m-d") : '';

            // $test = Pact_Contracts::selectRaw('Pact_Contracts.id, Pact_Contracts.Contract_Con')
            //     ->where('Pact_Contracts.CodeLoan_Con', $loanCode)
            //     ->where('Pact_Contracts.UserBranch', $id)
            //     ->where('Pact_Contracts.UserZone', $user_zone)
            //     ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
            //         return $q->whereBetween('Pact_Contracts.Date_con', [$Fdate, $Tdate]);
            //     })
            //     ->when(!empty($statusTxt), function ($q) use ($statusTxt) {
            //         return $q->where('Pact_Contracts.Status_Con', $statusTxt);
            //     })
            //     ->with(['ContractToIndentureAsset2' => function ($query) {
            //         $query->select('id', 'PactCon_id', 'Asset_id');
            //         $query->with(['IndenAssetToDataOwner' => function ($subQuery) {
            //             $subQuery->select('id', 'TypeAsset_Code');
            //         }]);
            //     }])
            //     ->get();

            // dd($test);

            // $data = Pact_Contracts::leftJoin('Data_CusTagCalculates', 'Pact_Contracts.DataTag_id', '=', 'Data_CusTagCalculates.DataTag_id')
            //     ->leftJoin('Data_Customers', 'Pact_Contracts.DataCus_id', '=', 'Data_Customers.id')
            //     ->leftJoin(\DB::raw('(SELECT * FROM Pact_Indentures_Assets A WHERE id = (SELECT MAX(id) FROM Pact_Indentures_Assets B WHERE A.PactCon_id=B.PactCon_id)) AS t2'), 'Pact_Contracts.id', '=', 't2.PactCon_id')
            //     ->leftJoin('Data_Assets', 'Data_Assets.id', '=', 't2.Asset_id')
            //     ->leftJoin('TB_TypeLoans', 'TB_TypeLoans.Loan_Code', '=', 'Pact_Contracts.CodeLoan_Con')
            //     ->leftJoin('Stat_rateTypes', 'Stat_rateTypes.code_car', '=', 'Data_Assets.Land_Type')
            //     ->leftJoin('Stat_CarBrand', 'Data_Assets.Vehicle_Brand', '=', 'Stat_CarBrand.id')
            //     ->leftJoin('Stat_MotoBrand', 'Data_Assets.Vehicle_Brand', '=', 'Stat_MotoBrand.id')
            //     ->selectRaw("Pact_Contracts.Approve_monetary, Pact_Contracts.ConfirmApp_Con, Pact_Contracts.ConfirmDocApp_Con, Pact_Contracts.DocApp_Con, Pact_Contracts.Date_con, Pact_Contracts.DateCheck_Bookcar, Pact_Contracts.id, Pact_Contracts.Contract_Con, TB_TypeLoans.Loan_Name, Pact_Contracts.Date_monetary, Data_Customers.Name_Cus,
            //         CASE
            //             WHEN TB_TypeLoans.id_rateType = 'land' THEN Stat_rateTypes.nametype_car
            //             WHEN TB_TypeLoans.id_rateType IN ('car', 'moto') AND Data_Assets.Vehicle_NewLicense IS NOT NULL THEN Data_Assets.Vehicle_NewLicense
            //             ELSE Data_Assets.Vehicle_OldLicense
            //         END AS licence,
            //         CASE
            //             WHEN TB_TypeLoans.id_rateType = 'land' THEN Data_Assets.Land_Id
            //             ELSE ''
            //         END AS brand,
            //         CASE
            //             WHEN Data_CusTagCalculates.Buy_PA = 'Yes' AND Data_CusTagCalculates.Include_PA = 'Yes' THEN Data_CusTagCalculates.Cash_Car + Data_CusTagCalculates.Process_Car + Data_CusTagCalculates.Insurance_PA
            //             ELSE Data_CusTagCalculates.Cash_Car + Data_CusTagCalculates.Process_Car
            //         END AS cash,
            //         TB_TypeLoans.id_rateType")
            //     ->where('Pact_Contracts.UserZone', $user_zone)
            //     ->where('CodeLoan_Con', $loanCode)
            //     ->when(!empty($id), function ($q) use ($id) {
            //         return $q->where('Pact_Contracts.UserBranch', $id);
            //     })
            //     ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
            //         return $q->whereBetween('Pact_Contracts.Date_con', [$Fdate, $Tdate]);
            //     })
            //     ->when(!empty($statusTxt), function ($q) use ($statusTxt) {
            //         return $q->where('Pact_Contracts.Status_Con', $statusTxt);
            //     })
            //     ->get();

            $data = DB::table('View_ContractCon')
                ->select(
                    'Approve_monetary',
                    'ConfirmApp_Con',
                    'ConfirmDocApp_Con',
                    'DocApp_Con',
                    'Date_con',
                    'Status_Con',
                    'StatusApp_Con',
                    'DateCheck_Bookcar',
                    'id',
                    'Contract_Con',
                    'Loan_Name',
                    'Date_monetary',
                    'Name_Cus',
                    'licence',
                    'cash',
                    'id_rateType',
                    'brand',
                    'image_cus'
                )
                ->where('UserZone', $user_zone)
                ->where('CodeLoan_Con', $loanCode)
                ->when(!empty($id), function ($q) use ($id) {
                    return $q->where('BranchSent_Con', $id);
                })
                ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereBetween('Date_con', [$Fdate, $Tdate]);
                })
                ->when(empty($statusTxt), function ($q) use ($statusTxt) {
                    return $q->whereIN('Status_Con', ['active', 'pending', 'complete']);
                })
                ->when(!empty($statusTxt), function ($q) use ($statusTxt) {
                    return $q->where('Status_Con', $statusTxt);
                })
                ->get();

            $returnHTML = view('frontend.content-view.data-contract', compact('data', 'loanCode', 'title', 'dataBranch2'))->render();
            return response()->json(['html' => $returnHTML]);
        } elseif ($request->page == 'sendoffice') {
            $title = 'รายการสินเชื่อ ( Loan Informations )';
            /*** reset value */
            $Fdate = ($Fdate1 != NULL) ? date_format($start, "Y-m-d") : '';
            $Tdate = ($Tdate1 != NULL) ? date_format($end, "Y-m-d") : '';

            $data = DB::table('View_ContractAuditEx1')
                ->where('UserZone', $user_zone)
                ->where('BranchSent_Con', $id)
                ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereRaw("cast(Date_monetary as date) between '" . $Fdate . "' and '" . $Tdate . "'");
                })
                ->where(DB::raw("FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"), '>=', '2024-01-01')
                ->when($statusTxt != 'all', function ($q) use ($statusTxt) {
                    return $q->where('Flag_Status', $statusTxt != '' ? $statusTxt : NULL);
                })
                ->whereNotNull('Date_monetary')
                ->orderBy('CodeLoan_Con')
                ->get();

            $countCont = DB::table('View_ContractAuditEx1')
                ->where('UserZone', $user_zone)
                ->where('BranchSent_Con', $id)
                ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereRaw("cast(Date_monetary as date) between '" . $Fdate . "' and '" . $Tdate . "'");
                })
                ->where(DB::raw("FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"), '>=', '2024-01-01')
                ->when($statusTxt != 'all', function ($q) use ($statusTxt) {
                    return $q->where('Flag_Status', $statusTxt != '' ? $statusTxt : 1);
                })
                // ->where('Flag_Status','1')
                ->whereNotNull('Date_monetary')
                ->count();

            $arrRole = ['administrator', 'superadmin', 'manager', 'audit'];
            $Position = auth()->user()->getRoleNames();
            $Approve = $Position->filter(function ($item) use ($arrRole) {
                return in_array($item, $arrRole);
            });
            $Approve = count($Approve);

            $returnHTML = view('frontend.content-view.data-sendDocs', compact('data', 'title', 'dataBranch2', 'countCont', 'Fdate', 'Tdate', 'statusTxt', 'Approve'))->render();
            return response()->json(['html' => $returnHTML]);
        } elseif ($request->page == 'rejectDocs') {
            $title = 'รายการสินเชื่อ ( Loan Informations )';
            /*** reset value */
            $Fdate = ($Fdate1 != NULL) ? date_format($start, "Y-m-d") : '';
            $Tdate = ($Tdate1 != NULL) ? date_format($end, "Y-m-d") : '';

            $data = DB::table('View_ContractAuditEx1')
                ->where('UserZone', $user_zone)
                ->where('BranchSent_Con', $id)
                ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereBetween('Date_monetary', [$Fdate, $Tdate]);
                })
                ->where('Flag_Status', 4)
                ->whereNotNull('Date_monetary')
                ->orderBy('CodeLoan_Con')
                ->get();

            $returnHTML = view('frontend.content-view.data-rejectDocs', compact('data', 'title', 'dataBranch2', 'Fdate', 'Tdate'))->render();
            return response()->json(['html' => $returnHTML]);
        } elseif ($request->page == 'credit-loans') {
            $title = 'รายการสินเชื่อ ( Loan Informations )';
            $data = DB::table('View_ContractAuditEx1')
                ->where('UserZone', $user_zone)
                ->where(DB::raw("FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"), '>=', '2024-01-01')
                ->whereIn('Flag_Status', [2, 3])
                ->where('BranchSent_Con', $id)
                ->get();

            $returnHTML = view('frontend.content-view.data-auditCheck', compact('data', 'title', 'dataBranch2'))->render();
            return response()->json(['html' => $returnHTML]);
        } elseif ($request->page == 'data-warehoure') {
            $title = 'รายการสินเชื่อ ( Loan Informations )';

            /*** reset value */
            $Fdate = ($Fdate1 != NULL) ? date_format($start, "Y-m-d") : '';
            $Tdate = ($Tdate1 != NULL) ? date_format($end, "Y-m-d") : '';

            $data = DB::table('View_ContractAuditEx1')
                ->where('UserZone', $user_zone)
                ->where('Flag_Status', 6)
                ->where('BranchSent_Con', $id)
                ->get();

            $returnHTML = view('frontend.content-view.data-completeDocs', compact('data', 'title', 'dataBranch2', 'Fdate', 'Tdate'))->render();
            return response()->json(['html' => $returnHTML]);
        } elseif ($request->page == 'financial-approval') {
            // $data = View_ContractAudit::
            //     where('UserZone', $user_zone)
            //     ->whereNotNull('nameConfirm')
            //     ->whereNull('Date_monetary')
            //     ->whereRaw('Balance_Price - CASE WHEN transferCash IS NULL THEN 0 ELSE transferCash END > 0')
            //     ->where('Loan_Com',$request->type_loan)
            //     ->when($request->dataTab == 'tabNow', function ($q) {
            //         return $q->whereDate('DateConfirmApp_Con',  Carbon::today());
            //     })
            //     ->when($request->dataTab == 'tabOld', function ($q) {
            //         return $q->whereDate('DateConfirmApp_Con', '<' ,Carbon::today());
            //     })
            //     ->get();

            $data = View_ContractAudit::where('UserZone', $user_zone)
                ->whereNotNull('nameConfirm') // ConfirmApp_Con
                ->whereNotIn('Status_Con', ['cancel', 'close'])
                ->whereNull('Date_Approve_tranfers')
                // ->whereNull('Date_monetary')
                ->whereNotNull('nameConfirm')
                ->where('Loan_Com', $request->type_loan)
                ->when($request->dataTab == 'tabNow', function ($q) {
                    return $q->whereDate('DateConfirmApp_Con', Carbon::today());
                })
                ->when($request->dataTab == 'tabOld', function ($q) {
                    return $q->whereDate('DateConfirmApp_Con', '<', Carbon::today());
                })
                ->get();
            $returnHTML = view('frontend.content-view.data-treas', compact('data'))->render();
            return response()->json(['html' => $returnHTML]);
        } elseif ($request->page == 'rejectedPA') { //tag datacus
            $dataCon = View_ReportPAData::whereNull('Flag_PARespon')->where('BranchSent_Con', $request->id)
                ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereBetween('Date_monetary', [$Fdate, $Tdate]);
                })
                ->get();
            $returnHTML = view('frontend.content-view.data-rejectedPA', compact('dataCon', 'dataBranch2'))->render();
            return response()->json(['html' => $returnHTML]);
        } elseif ($request->page == 'PP-Lead') {
            if (empty($Fdate) or empty($Tdate)) {
                $Fdate = date('Y-m-d');
                $Tdate = date('Y-m-d');
            }

            $dataCus = Data_CredoCodes::leftJoin('Data_Customers', function ($join) {
                $join->on('Data_CredoCodes.data_customer_id', '=', 'Data_Customers.id');
            })->leftJoin('Data_CusTags', function ($join) {
                $join->on('Data_CusTags.DataCus_id', '=', 'Data_Customers.id')
                    ->whereRaw('Data_CusTags.id = (select MAX(id) from Data_CusTags where DataCus_id =Data_Customers.id  )');
            })
                ->leftJoin('Data_CusTagCalculates', function ($join) {
                    $join->on('Data_CusTags.id', '=', 'Data_CusTagCalculates.DataTag_id');
                })
                ->leftJoin('TB_TypeLoans', function ($join) {
                    $join->on('TB_TypeLoans.Loan_Code', '=', 'Data_CusTagCalculates.CodeLoans');
                })
                ->selectRaw("Data_Customers.Prefix,Data_Customers.PrefixOther,
                    Data_Customers.Name_Cus,Data_Customers.date_Cus,
                    Data_Customers.Phone_cus,Data_Customers.image_cus,
                    Data_Customers.Status_Cus,Data_Customers.id,Data_CusTags.date_Tag,
                    Data_CusTags.Status_Tag,Data_CusTags.Code_Tag,TB_TypeLoans.Loan_Name,
                    Data_CusTags.successor")
                ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereRaw('cast(Data_CredoCodes.created_at as date) between ? and ?', [$Fdate, $Tdate]);
                })
                ->where('Data_Customers.Status_Cus', '!=', 'cancel')
                ->where('Data_Customers.UserZone', $user_zone)
                ->where('Data_Customers.UserBranch', $request->id)
                ->where('Data_Customers.type_Cus', 'api')
                ->orderBY('Data_CredoCodes.created_at', 'DESC')
                ->get();

            $returnHTML = view('frontend.content-view.data-Cus', compact('dataCus', 'dataBranch2'))->render();
            return response()->json(['html' => $returnHTML]);
        }
    }

    public function show($id, Request $request)
    {
        if ($request->funs == 'getLogRejectedPA') {
            $data_con = Log_ContractsCon::where('Data_id', $id)->get();
            return view('frontend.content-con.RejectedPa', compact('data_con'));
        }
    }

    private function resetSession_alll()
    {
        session()->forget('dataBranch');
    }
}
