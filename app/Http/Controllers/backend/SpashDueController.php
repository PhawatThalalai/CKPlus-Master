<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\TB_view\View_PatchSPASTDUE_Task;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\URL;
use Log;

use App\Models\User;
use App\Models\TB_view\VWDEBT_RPSPASTDUE;

use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchHP\PatchHP_SPASTDUE;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchPSL\PatchPSL_SPASTDUE;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchTB_SPASTDUE;

use App\Models\TB_Constants\TB_Backend\TB_GROUPDEBT;
use App\Models\TB_Constants\TB_Backend\TB_GROUPKANGDUE;
use App\Models\TB_Constants\TB_Backend\TB_Statusdebt;
use App\Models\TB_Constants\TB_Backend\TB_BILLCOLL;

use App\Models\TB_Constants\TB_Frontend\TB_TypeLoan;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;

/*
use App\Models\TB_PactContracts\Pact_Contracts;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_Contracts;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_Contracts;
use App\Models\TB_PatchContracts\TB_Payments\PatchHP\PatchHP_HDPAYMENT;
use App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_HDPAYMENT;
*/

class SpashDueController extends Controller
{
    public static function getTB($query)
    {
      $dataTB = $query;
      return   Datatables()->of($dataTB)
                ->addIndexColumn()
                ->addColumn('CONTNO2', function ($data) {
                    return '<span class="fw-semibold contno text-secondary">'.@$data->CONTNO.'</span>';
                  })
                ->addColumn('BILLCOLL', function ($data) {
                    return '<i class="btn btn-soft-info btn-sm rounded-pill mdi mdi-map-marker-multiple"></i> '.$data->Name_Branch;
                  })
                  ->addColumn('DUEDATE', function ($data) {
                        return '<p class="mb-1"><i class="btn btn-soft-warning btn-sm rounded-pill bx bx-calendar-event"></i> '.formatDateThai($data->DUEDATE);
                        // .'</p><i class="btn btn-soft-warning btn-sm rounded-pill bx bx-calendar-event"></i> '.formatDateThai($data->LPAYD);
                  })
                  ->addColumn('Details', function ($data) {
                    return '
                    <a class="btn btn-primary btn-rounded btn-sm data-modal-xl" data-link="'.route('datatrack.edit',@$data->pactcon_id).'?page=view-track&loanType='.$data->CODELOAN.'&Contno='.$data->CONTNO.'&EXP='.$data->EXPREAL.'">รายละเอียด</a>';

                  })
                  ->addColumn('trackFollow', function ($data) {
                    return '
                        <a class="border-end px-2" href="'.route('datatrack.edit',@$data->pactcon_id) .'?page=track-follow-up"><i class="mdi mdi-book-arrow-right-outline fs-5"></i></a>
                        <a style="cursor : pointer;" class="data-modal-xl px-2" data-link="'.route('datatrack.edit',@$data->id).'?page=edit-track&ContractID='.@$data->PatchCon_id.'&Contno='.$data->CONTNO.'&loanType='.$data->CODLOAN.'&EXP='.$data->EXPREAL.'"><i class="mdi mdi-file-document-edit-outline fs-5 text-danger"></i></a>';

                  })
                  ->addColumn('LPAYD', function ($data) {
                    return '<i class="btn btn-soft-warning btn-sm rounded-pill bx bx-calendar-event"></i> '.formatDateThai($data->LPAYD);
                  })
                  ->addColumn('INSTALL', function ($data) {
                    // return '<p class="mb-1">'.number_format($data->TOTUPAY,0).'</p><span class="badge rounded-pill badge-soft-warning text-dark font-size-11">'.number_format($data->MinPay,0).'</span>';
                    return '<p class="mb-1">'.number_format($data->MinPay,0).'</p>';

                  })
                  ->addColumn('Appointment', function ($data) {
                    if($data->APPDATE < date('Y-m-d')){
                        return '<p class="mb-1"><i class="bx bx-error text-danger bx-tada fs-4 error "></i>' .formatDateThai($data->APPDATE).'</p><span class="badge rounded-pill badge-soft-warning font-size-11 text-dark">ผิดนัด 0</span>';
                    }else{
                        return '<p class="mb-1"><i class="btn btn-soft-warning btn-sm rounded-pill bx bx-calendar-event"></i>'.formatDateThai($data->APPDATE).'</p><span class="badge rounded-pill badge-soft-warning font-size-11 text-dark">ผิดนัด 0</span>';
                    }
                  })
                  ->addColumn('stdept', function ($data) {

                    if(@$data->STATUS == 'ผ่าน'){
                        return '<span class="fw-semibold"> <i class="bx bxs-check-circle bx-tada fs-5 text-success"></i> '.@$data->STATUS.'</span>';

                    }else{
                        return @$data->STATUS;
                    }
                  })
                  ->addColumn('Name_Cus', function ($data) {
                    $img = $data->image ? URL::asset($data->image) : asset('/assets/images/users/user-1.png') ;
                    return '
                    <div class="d-flex m-auto">
                        <img class="d-flex me-3 rounded-circle" src='.$img.' alt="skote" height="28">
                        <p>'.$data->Name_Cus.'</p>
                    </div>';
                  })
                ->rawColumns(['Details','trackFollow','DUEDATE','LPAYD','BILLCOLL','INSTALL','Appointment','Name_Cus','STATUS','APPDATE','CONTNO2','stdept'])
                ->make(true);
    }

    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        if ($request->page == 'searchDebt') { // กรองข้อมูลในตาราง
            $data = VWDEBT_RPSPASTDUE::whereNotNull('FOLCODE')
            ->whereIn('GroupingType', explode(",",$request->GroupType))
            ->where('GroupingState','Y')
            ->when($request->input('BranchDebt'), function ($query, $BranchDebt) {
                return $query->whereIn('FOLCODE', $BranchDebt);
            })
            ->when($request->input('SALECOD'), function ($query, $SALECOD) {
              return $query->whereIn('SALECOD', $SALECOD);
            })
            ->when($request->input('StatusDebt'), function ($query, $StatusDebt) {
                return $query->whereIn('STATUS', $StatusDebt);
            })
            ->when($request->input('GroupDebt'), function ($query, $GroupDebt) {
              return $query->whereIn('SWEXPPRD', $GroupDebt);
            })
            ->orderBy('DUEDATE', 'ASC')->where('UserZone',auth()->user()->zone)->get();

            return static::getTB($data);


        } elseif($request->page == 'searchBranch'){ // ค้นหาตามการ์ดสาขา
            if($request->BranchDebt == 'allBranch'){
                $data = VWDEBT_RPSPASTDUE::
                whereIn('GroupingType', explode(",",$request->GroupType))
                ->where('GroupingState','Y')
                ->whereNotNull('FOLCODE')
                ->where('UserZone',auth()->user()->zone)->orderBy('DUEDATE', 'ASC')->get();
                $flag = 'allBranch';
            } else {
                $data = VWDEBT_RPSPASTDUE::
                whereIn('GroupingType', explode(",",$request->GroupType))
                ->where('GroupingState','Y')
                ->where('FOLCODE', $request->BranchDebt)
                ->where('UserZone',auth()->user()->zone)->orderBy('DUEDATE', 'ASC')->get();
                $flag = 'Branch';
            }
            return static::getTB($data);

        } elseif($request->page == 'shortcut'){
            $GroupType = $request->GroupType;
            if($request->nameshortcut == 1){ // รายการติดตามวันนี้
                $data = VWDEBT_RPSPASTDUE::TrackListToday($GroupType);
            }
            elseif($request->nameshortcut == 2){ // PAST 2 , PAST 3 (PSL)
                $data = VWDEBT_RPSPASTDUE::Past12PSL($GroupType);
            }
            elseif($request->nameshortcut == 3){ // ส่งรายงานหัวหน้า ,ส่งรายงาน GM (PLM)
                $data = VWDEBT_RPSPASTDUE::SendManagerPSL($GroupType);
            }
            elseif($request->nameshortcut == 4){ // ส่งรายงานหัวหน้า ,ส่งรายงาน GM (30-50)
                $data = VWDEBT_RPSPASTDUE::SendManagerHP($GroupType);
            }
            elseif($request->nameshortcut == 5){ // นัดชำระวันนี้
                $data = VWDEBT_RPSPASTDUE::AppointmentToday($GroupType);
            }
            elseif($request->nameshortcut == 6){ // ดีลวันนี้
                $data = VWDEBT_RPSPASTDUE::DueToday($GroupType);
            }
            elseif($request->nameshortcut == 7){ // ดีลเมื่อวาน
                $data = VWDEBT_RPSPASTDUE::DueYesterday($GroupType);
            }
            return static::getTB($data);

        } elseif ($request->page == 'daily') {
            $page = $request->page;
            $pay_status = TB_Statusdebt::get();
            $year = date("Y");
            $month = $request->month;
            // $branch = $request->branch;
            // $FInstallment = 0;
            // $LInstallment = 1;
            $FInstallment = $request->data['FInstallment'];
            $LInstallment = $request->data['LInstallment'];
            $data = DB::table("VWDEBT_RPSPASTDUEALL")
            ->where('SUMARYDATE', date('Y-m-d'))
            ->where('UserZone', auth()->user()->zone)
            ->when($request->data['branch'], function ($query, $branch) {
                return $query->where('LOCAT', $branch);
            })
            ->when($FInstallment != NULL && $LInstallment != NULL , function ($query) use ($FInstallment,$LInstallment) {
                return $query->whereBetween('EXPREAL', [$FInstallment,$LInstallment]);
            })
            ->when($request->data['pay_status'], function ($query, $pay_status) {
                return $query->where('stdept', $pay_status);
            })
            ->get();

            $branch = TB_Branchs::where('Zone_Branch', auth()->user()->zone)->get();
            $flag = 'allBranch';
            $groupdebt = TB_GROUPDEBT::get();
            $statusdebt = TB_Statusdebt::where('status', 'active')->get();
            return Datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('CON_NO', function ($q) {
                return $q->CONTNO;
            })
            ->addColumn('Name_Branch', function ($q) {

                return $q->NickName_Branch ;
            })
            ->addColumn('Name_Cus', function ($q) {

                return $q->Name_Cus ;
            })
            ->addColumn('name', function ($q) {
                return (@ $q->name != NULL) ? $q->name : '-';
            })
            ->addColumn('DUEDATE', function ($q) {

                return $q->DUEDATE ;
            })
            ->addColumn('TOTUPAY', function ($q) {

                return $q->TOTUPAY ;
            })
            ->addColumn('EXPREAL', function ($q) {

                return $q->EXPREAL ;
            })
            ->addColumn('NEXT_EXPREAL', function ($q) {

                return $q->NEXT_EXPREAL ;
            })
            ->addColumn('SWEXPPRD', function ($q) {

                return $q->SWEXPPRD ;
            })
            ->addColumn('EXP_FRM', function ($q) {

                return $q->EXP_FRM ;
            })
            ->addColumn('EXP_TO', function ($q) {

                return $q->EXP_TO ;
            })
            ->addColumn('NEXT_KDAMT', function ($q) {

                return $q->NEXT_KDAMT ;
            })
            ->addColumn('LPAYD', function ($q) {

                return $q->LPAYD ;
            })
            ->addColumn('LPAYA', function ($q) {

                return $q->LPAYA ;
            })
            ->addColumn('PAYINT', function ($q) {

                return $q->PAYINT ;
            })
            ->addColumn('stdept', function ($q) {
                $bg_color = '';
                if($q->stdept == 'ผ่าน'){
                    $bg_color = 'bg-success';
                }else{
                    $bg_color = 'bg-danger';
                }
                $stdept = '
                <span class="badge '. $bg_color.' font-size-10"> '.$q->stdept.' </span>
                ';
                return $stdept;
            })
            ->rawColumns(['stdept'])
            ->make(true);


        } elseif ($request->page == 'monthly') {
            $page = $request->page;
            $pay_status = TB_Statusdebt::get();
            $year = date("Y");
            $month = $request->data['month'];


            // dd($month);
            // $data = PatchPSL_SPASTDUE::where(DB::raw(" FORMAT (cast(created_at as date), 'yyyy-MM-dd')"), $todayformat)->get();
            // if ($branch == 'allBranch') {
            //     $data = DB::table("VWDEBT_RPSPASTDUEALL")
            //         ->whereYear('LAST_ASSIGNDT', '=', date("Y"))
            //         ->whereMonth('LAST_ASSIGNDT', '=', $month)
            //         ->where('UserZone', auth()->user()->zone)
            //         ->get()
            //         ;
            // } else {
            //     $data = DB::table("VWDEBT_RPSPASTDUEALL")
            //         ->whereYear('LAST_ASSIGNDT', '=', date("Y"))
            //         ->whereMonth('LAST_ASSIGNDT', '=', $month)
            //         ->where('BILLCOLL', $branch)
            //         ->where('UserZone', auth()->user()->zone)
            //         ->get()
            //         ;
            // }

            $FInstallment = $request->data['FInstallment'];
            $LInstallment = $request->data['LInstallment'];

            $data = DB::table("VWDEBT_RPSPASTDUEALL")
            ->whereYear('LAST_ASSIGNDT', '=', date("Y"))
            ->whereMonth('LAST_ASSIGNDT', '=', $month)
            ->where('UserZone', auth()->user()->zone)
            ->when($request->data['branch'], function ($query, $branch) {
                return $query->where('LOCAT', $branch);
            })
            ->when($request->data['pay_status'], function ($query, $pay_status) {
                return $query->where('stdept', $pay_status);
            })
            ->when($FInstallment != NULL && $LInstallment != NULL , function ($query) use ($FInstallment,$LInstallment) {
                return $query->whereBetween('EXPREAL', [$FInstallment,$LInstallment]);
            })
           ->get();

            $branch = TB_Branchs::where('Zone_Branch', auth()->user()->zone)->get();
            $flag = 'allBranch';
            // if($request->branch == 'allBranch'){
            // }

            $groupdebt = TB_GROUPDEBT::get();
            $statusdebt = TB_Statusdebt::where('status', 'active')->get();

            return Datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('CON_NO', function ($q) {
                return $q->CONTNO;
            })
            ->addColumn('Name_Branch', function ($q) {
                return $q->NickName_Branch ;
            })
            ->addColumn('Name_Cus', function ($q) {

                return $q->Name_Cus ;
            })
            ->addColumn('name', function ($q) {
                return (@ $q->name != NULL) ? $q->name : '-';
            })
            ->addColumn('DUEDATE', function ($q) {

                return $q->DUEDATE ;
            })
            ->addColumn('TOTUPAY', function ($q) {

                return $q->TOTUPAY ;
            })
            ->addColumn('EXPREAL', function ($q) {

                return $q->EXPREAL ;
            })
            ->addColumn('NEXT_EXPREAL', function ($q) {

                return $q->NEXT_EXPREAL ;
            })
            ->addColumn('SWEXPPRD', function ($q) {

                return $q->SWEXPPRD ;
            })
            ->addColumn('EXP_FRM', function ($q) {

                return $q->EXP_FRM ;
            })
            ->addColumn('EXP_TO', function ($q) {
                return $q->EXP_TO ;
            })
            ->addColumn('NEXT_KDAMT', function ($q) {

                return $q->NEXT_KDAMT ;
            })
            ->addColumn('LPAYD', function ($q) {

                return $q->LPAYD ;
            })
            ->addColumn('LPAYA', function ($q) {

                return $q->LPAYA ;
            })
            ->addColumn('PAYINT', function ($q) {

                return $q->PAYINT ;
            })
            ->addColumn('stdept', function ($q) {
                $bg_color = '';
                if($q->stdept == 'ผ่าน'){
                    $bg_color = 'bg-success';
                }else{
                    $bg_color = 'bg-danger';
                }
                $stdept = '
                <span class="badge '. $bg_color.' font-size-10"> '.$q->stdept.' </span>
                ';
                return $stdept;
            })
            ->rawColumns(['stdept'])
            ->make(true);

            // $renderHTML = view('backend.content-result.view-table', compact('data', 'branch', 'groupdebt', 'statusdebt', 'flag', 'page', 'pay_status'))->render();
            // return response()->json( $data_arr);
        } elseif ($request->page == 'showTracking') {
            dump(($request));
        }
        /*
        if ($request->page == 'phone') { // กดสอบถาม การแบ่งกลุ่มงานโทร
            $FPERIOD = $request->data['F_PERIOD'];
            $TPERIOD = $request->data['T_PERIOD'];
            $TYPECONT = $request->data['TYPECONT'];
            $group = $request->data['GROUP'];   // กลุ่มแบ่งงาน
            if ($request->data['TYPECONT'] == 'HP') {
                $data = PatchTB_SPASTDUE::Select('LOCAT', PatchTB_SPASTDUE::raw('count(*) as TOTAL'))
                    ->where('UserZone', auth()->user()->zone)
                    ->where('CODLOAN', '2') // 2 เช่าซื้อ
                    ->whereBetween('HLDNO', [ $request->data['F_PERIOD'], $request->data['T_PERIOD'] ])
                    ->groupBy('LOCAT')
                    ->orderBY('LOCAT', 'ASC')
                    ->get();
                $count_all = PatchTB_SPASTDUE::where('UserZone', auth()->user()->zone)
                    ->where('CODLOAN', '2')
                    ->whereBetween('HLDNO', [ $request->data['F_PERIOD'], $request->data['T_PERIOD'] ])
                    ->get()
                    ->count();
            } elseif ($request->data['TYPECONT'] == 'PSL') {
                $data = PatchTB_SPASTDUE::select('LOCAT', PatchTB_SPASTDUE::raw('count(*) as TOTAL'))
                    ->where('UserZone', auth()->user()->zone)
                    ->where('CODLOAN', '1') // 1 เงินกู้
                    ->whereBetween('HLDNO', [ $request->data['F_PERIOD'], $request->data['T_PERIOD'] ])
                    ->groupBy('LOCAT')
                    ->orderBY('LOCAT', 'ASC')
                    ->get();

                // ขาดเงื่อนไข วันที่ --> เช็ค จากวันที่อัปเดต ในตารางจะมีงานเดือนที่แล้วปนอยู่ด้วย

                $count_all = PatchTB_SPASTDUE::where('UserZone', auth()->user()->zone)
                    ->where('CODLOAN', '1')
                    ->whereBetween('HLDNO', [ $request->data['F_PERIOD'], $request->data['T_PERIOD'] ])
                    ->get()
                    ->count();
            }

            return response()->view('backend.content-track.session-task.view-group', compact('data', 'FPERIOD', 'TPERIOD', 'TYPECONT', 'group', 'count_all'));
        }
        */

    }


    public function show($id, Request $request)
    {

        if ($request->page == 'daily') {
            $page = $request->page;
            $pay_status = TB_Statusdebt::get();
            $month = $request->data['monthYear'];
             $branchSelect = $request->data['ID_LOCAT'];
            $FInstallment = $request->data['exp_frm'];
            $LInstallment = $request->data['exp_to'];
            $data = DB::table("VWDEBT_RPSPASTDUEALL")
            ->whereRaw(" format( cast(LAST_ASSIGNDT as date),'MM-yyyy')='".$month."'")
            ->where('UserZone', auth()->user()->zone)
            ->when( $branchSelect != NULL, function ($query) use( $branchSelect) {
                return $query->whereRaw("LOCAT like '".$branchSelect."'");
            })
            ->when($FInstallment != NULL && $LInstallment != NULL , function ($query) use ($FInstallment,$LInstallment) {
                return $query->whereBetween('EXPREAL', [$FInstallment,$LInstallment]);
            })
            // ->when($request->data['pay_status'], function ($query, $pay_status) {
            //     return $query->where('stdept', $pay_status);
            // })
            ->get();

            $branch = TB_Branchs::where('Zone_Branch', auth()->user()->zone)->get();
            $flag = 'allBranch';
            $groupdebt = TB_GROUPDEBT::get();
            $statusdebt = TB_Statusdebt::where('status', 'active')->get();

            
            $renderHTML = view('backend.content-result.view-table', compact('data','branch'))->render();
            return response()->json(['html' => $renderHTML]);
        } elseif ($request->page == 'monthly') {
            $page = $request->page;
            $pay_status = TB_Statusdebt::get();
            $year = date("Y");
            $month = $request->data['month'];


            // dd($month);
            // $data = PatchPSL_SPASTDUE::where(DB::raw(" FORMAT (cast(created_at as date), 'yyyy-MM-dd')"), $todayformat)->get();
            // if ($branch == 'allBranch') {
            //     $data = DB::table("VWDEBT_RPSPASTDUEALL")
            //         ->whereYear('LAST_ASSIGNDT', '=', date("Y"))
            //         ->whereMonth('LAST_ASSIGNDT', '=', $month)
            //         ->where('UserZone', auth()->user()->zone)
            //         ->get()
            //         ;
            // } else {
            //     $data = DB::table("VWDEBT_RPSPASTDUEALL")
            //         ->whereYear('LAST_ASSIGNDT', '=', date("Y"))
            //         ->whereMonth('LAST_ASSIGNDT', '=', $month)
            //         ->where('BILLCOLL', $branch)
            //         ->where('UserZone', auth()->user()->zone)
            //         ->get()
            //         ;
            // }

            $FInstallment = $request->data['FInstallment'];
            $LInstallment = $request->data['LInstallment'];

            $data = DB::table("VWDEBT_RPSPASTDUEALL")
            ->whereYear('LAST_ASSIGNDT', '=', date("Y"))
            ->whereMonth('LAST_ASSIGNDT', '=', $month)
            ->where('UserZone', auth()->user()->zone)
            ->when($request->data['branch'], function ($query, $branch) {
                return $query->where('LOCAT', $branch);
            })
            ->when($request->data['pay_status'], function ($query, $pay_status) {
                return $query->where('stdept', $pay_status);
            })
            ->when($FInstallment != NULL && $LInstallment != NULL , function ($query) use ($FInstallment,$LInstallment) {
                return $query->whereBetween('EXPREAL', [$FInstallment,$LInstallment]);
            })
           ->get();

            $branch = TB_Branchs::where('Zone_Branch', auth()->user()->zone)->get();
            $flag = 'allBranch';
            // if($request->branch == 'allBranch'){
            // }

            $groupdebt = TB_GROUPDEBT::get();
            $statusdebt = TB_Statusdebt::where('status', 'active')->get();

            return Datatables()->of($data)
            ->addIndexColumn()
            ->addColumn('CON_NO', function ($q) {
                return $q->CONTNO;
            })
            ->addColumn('Name_Branch', function ($q) {
                return $q->NickName_Branch ;
            })
            ->addColumn('Name_Cus', function ($q) {

                return $q->Name_Cus ;
            })
            ->addColumn('name', function ($q) {
                return (@ $q->name != NULL) ? $q->name : '-';
            })
            ->addColumn('DUEDATE', function ($q) {

                return $q->DUEDATE ;
            })
            ->addColumn('TOTUPAY', function ($q) {

                return $q->TOTUPAY ;
            })
            ->addColumn('EXPREAL', function ($q) {

                return $q->EXPREAL ;
            })
            ->addColumn('NEXT_EXPREAL', function ($q) {

                return $q->NEXT_EXPREAL ;
            })
            ->addColumn('SWEXPPRD', function ($q) {

                return $q->SWEXPPRD ;
            })
            ->addColumn('EXP_FRM', function ($q) {

                return $q->EXP_FRM ;
            })
            ->addColumn('EXP_TO', function ($q) {
                return $q->EXP_TO ;
            })
            ->addColumn('NEXT_KDAMT', function ($q) {

                return $q->NEXT_KDAMT ;
            })
            ->addColumn('LPAYD', function ($q) {

                return $q->LPAYD ;
            })
            ->addColumn('LPAYA', function ($q) {

                return $q->LPAYA ;
            })
            ->addColumn('PAYINT', function ($q) {

                return $q->PAYINT ;
            })
            ->addColumn('stdept', function ($q) {
                $bg_color = '';
                if($q->stdept == 'ผ่าน'){
                    $bg_color = 'bg-success';
                }else{
                    $bg_color = 'bg-danger';
                }
                $stdept = '
                <span class="badge '. $bg_color.' font-size-10"> '.$q->stdept.' </span>
                ';
                return $stdept;
            })
            ->rawColumns(['stdept'])
            ->make(true);

            // $renderHTML = view('backend.content-result.view-table', compact('data', 'branch', 'groupdebt', 'statusdebt', 'flag', 'page', 'pay_status'))->render();
            // return response()->json( $data_arr);
        } elseif ($request->page == 'showTracking') {
            dump(($request));
        }
    }


    public function edit(Request $request, $id)
    {
        if ($request->page == 'assign') {
            $CODLOAN = $request->CODLOAN;
            $groupingType = $request->type;
            $groupingTemp = $id;
            //--------------------------------------------------------
            $data = View_PatchSPASTDUE_Task::where('UserZone', auth()->user()->zone)
                ->where('CODLOAN', $CODLOAN)
                ->where('GroupingType', $groupingType)
                ->where('GroupingTemp', $groupingTemp)
                ->orderBy('HLDNO')
                ->select("*")
                ->addSelect(DB::raw("CONCAT(ADD_PROVINCE, ' - ', ADD_DISTRICT) AS ADD_DISTRICT"))
                ->get();

            $_locat = $data->first()->LOCAT;
            $branch = TB_Branchs::where('id', $_locat)->first();

            //--------------------------------------------------------
            $dataArray_billcoll = null;
            $dataArray_user = null;
            //--------------------------------------------------------
            $zone[10]='ปัตตานี';
            $zone[20]='หาดใหญ่';
            $zone[30]='นครศรีธรรมราช';
            $zone[40]='กระบี่';
            $zone[50]='สุราษฎร์ธานี';
            //--------------------------------------------------------
            switch ($groupingType) {
                case 'P':
                    $title = "มอบหมายงานโทร";
                    $groupingName = $branch->Name_Branch;
                    $groupingCode = $branch->NickName_Branch;
                    break;
                case 'T':
                    $title = "มอบหมายงานตาม";
                    $groupingName = "กลุ่มที่ ".$groupingTemp;
                    $groupingCode = "T".$groupingTemp;
                    break;
                case 'L':
                    $title = "มอบหมายงานที่ดิน";
                    $groupingName = "กลุ่มที่ ".$groupingTemp;
                    $groupingCode = "L".$groupingTemp;
                    break;
                default:
                    $title = "";
                    break;
            }
            //$title = "มอบหมายงานโทร";
            $zoneName = $zone[auth()->user()->zone];
            //$groupingName = $branch->Name_Branch;
            //$groupingCode = $branch->NickName_Branch;
            $codloanName = "";
            //--------------------------------------------------------
            if ($CODLOAN == '1') {
                $codloanName = "สินเชื่อเงินกู้ (PSL)";
            } else {
                $codloanName = "สินเชื่อเช่าซื้อ (HP)";
            }
            //--------------------------------------------------------
            //TB_BILLCOLL
            $billcoll = TB_BILLCOLL::generateQuery()
                ->pluck('DISPLAY_BILLCOLL', 'id')
                ->all();
            $progressbar = round($data->whereNotNull('FolCode')->count() / $data->count() * 100, 0);
            //--------------------------------------------------------
            return view('backend.content-track.session-task.edit-assign', compact('data', 'title', 'zoneName', 'groupingName', 'groupingCode', 'groupingType', 'groupingTemp', 'CODLOAN', 'codloanName', 'billcoll', 'progressbar'));
        }
        elseif ($request->page == 'assign-all') {
            $groupingType = $request->type;
            //--------------------------------------------------------
            $zone[10]='ปัตตานี';
            $zone[20]='หาดใหญ่';
            $zone[30]='นครศรีธรรมราช';
            $zone[40]='กระบี่';
            $zone[50]='สุราษฎร์ธานี';
            //--------------------------------------------------------
            if ($groupingType == 'P') {
                $title = "มอบหมายงานโทรทั้งหมด";
            } elseif ($groupingType == 'T') {
                $title = "มอบหมายงานตามทั้งหมด";
            } elseif ($groupingType == 'L') {
                $title = "มอบหมายงานที่ดินทั้งหมด";
            } else {
                $title = "";
            }
            $zoneName = $zone[auth()->user()->zone];
            //--------------------------------------------------------
            $data = View_PatchSPASTDUE_Task::where('UserZone', auth()->user()->zone)
                ->where('GroupingType', $groupingType)
                ->orderBy('CODLOAN', 'DESC')
                ->orderBy('GroupingTemp')
                ->orderBy('HLDNO')
                ->get();

            /*
            $billcoll = TB_BILLCOLL::generateQuery()
                ->pluck('DISPLAY_BILLCOLL', 'id')
                ->all();
            */
            // ดึง billcoll ใหม่ เพราะต้องการเก็บไอดีของสาขา ใส่ Selected ให้อัติโนมัติ
            $billcoll = TB_BILLCOLL::where('UserZone', auth()->user()->zone)
                ->where('status', 'Y')
                ->addSelect('id', DB::raw("CONCAT(code_billcoll, ' : ', name_billcoll) AS DISPLAY_BILLCOLL") )
                ->addSelect('UserBranch AS locat_id', 'type_billcoll')
                ->orderBy('DISPLAY_BILLCOLL')
                ->get();

            $branch_name = TB_Branchs::generateQuery(true)->pluck('Name_Branch', 'id');

            return view('backend.content-track.session-task.edit-assign-all', compact('data', 'title', 'zoneName', 'billcoll', 'branch_name', 'groupingType'));
        }

    }

    public function update(Request $request, $id)
    {
        if ($request->page == 'task') {
            if ($request->mode == 'phone') {
                if ($request->func == 'grouping') {
                    // งานโทรแบ่งกลุ่มตามสาขาโดยอัติโนมัติ
                    $F_PERIOD = $request->F_PERIOD;
                    $T_PERIOD = $request->T_PERIOD;
                    $TYPECONT = $request->TYPECONT;
                    $CODLOAN = null;
                    if ($TYPECONT == 'HP') {
                        $CODLOAN = '2';
                    }
                    if ($TYPECONT == 'PSL') {
                        $CODLOAN = '1';
                    }
                    $groupingStack = $request->groupingStack;
                    if ($CODLOAN != null) {
                        try {
                            if ($groupingStack == "false") {
                                // ! แบ่งกลุ่มแบบปกติทั่วไป
                                DB::transaction(function () use ($F_PERIOD, $T_PERIOD, $CODLOAN) {
                                    $updateQuery = "UPDATE p
                                                    SET
                                                        p.GroupingTemp = ranked.GroupRank,
                                                        p.GroupingType = 'P'
                                                    FROM PatchTB_SPASTDUE AS p
                                                    INNER JOIN (
                                                        SELECT
                                                            SPASTDUE.id,
                                                            DENSE_RANK() OVER (ORDER BY BRANCH.id_Contract) AS GroupRank
                                                        FROM PatchTB_SPASTDUE AS SPASTDUE
                                                        LEFT JOIN TB_Branchs AS BRANCH ON BRANCH.id = SPASTDUE.LOCAT
                                                        WHERE SPASTDUE.UserZone = ?
                                                            AND SPASTDUE.CODLOAN = ?
                                                            AND SPASTDUE.HLDNO BETWEEN ? AND ?
                                                            AND (SPASTDUE.CODLOAN <> 1 OR SPASTDUE.CONTTYP <> 3)
                                                            AND SPASTDUE.GroupingType IS NULL
                                                    ) AS ranked ON p.id = ranked.id";
                                    DB::statement($updateQuery, [auth()->user()->zone, $CODLOAN, $F_PERIOD, $T_PERIOD]);
                                });
                            } else {
                                // ! แบ่งกลุ่มซ้ำ ในขณะที่มีการแบ่งกลุ่มอยู่แล้ว
                                DB::transaction(function () use ($F_PERIOD, $T_PERIOD, $CODLOAN) {
                                    $updateQuery = "UPDATE p
                                                    SET
                                                        p.GroupingTemp = ranked.GroupRank,
                                                        p.GroupingType = 'P'
                                                    FROM PatchTB_SPASTDUE AS p
                                                    INNER JOIN (
                                                        SELECT
                                                            SPASTDUE.id,
                                                            (DENSE_RANK() OVER (ORDER BY BRANCH.id_Contract) + QMAX.LAST_GROUP) AS GroupRank
                                                        FROM PatchTB_SPASTDUE AS SPASTDUE
                                                        CROSS JOIN (
                                                            SELECT COALESCE( MAX(GroupingTemp), 0) AS LAST_GROUP
                                                            FROM PatchTB_SPASTDUE
                                                            WHERE GroupingType = 'P'
                                                                AND UserZone = ?
                                                                AND CODLOAN = ?
                                                                AND (CODLOAN <> 1 OR CONTTYP <> 3)
                                                        ) AS QMAX
                                                        LEFT JOIN TB_Branchs AS BRANCH ON BRANCH.id = SPASTDUE.LOCAT
                                                        WHERE SPASTDUE.UserZone = ?
                                                            AND SPASTDUE.CODLOAN = ?
                                                            AND SPASTDUE.HLDNO BETWEEN ? AND ?
                                                            AND (SPASTDUE.CODLOAN <> 1 OR SPASTDUE.CONTTYP <> 3)
                                                            AND SPASTDUE.GroupingType IS NULL
                                                    ) AS ranked ON p.id = ranked.id";
                                    DB::statement($updateQuery, [auth()->user()->zone, $CODLOAN, auth()->user()->zone, $CODLOAN, $F_PERIOD, $T_PERIOD]);
                                });
                            }
                        } catch (\Exception $e) {
                            // จัดการกับ exception ที่นี่
                            return response()->json(['error' => $e->getMessage()], 500);
                        }
                    }
                    //--------------------------------------------------------------------------------------
                    $lastRequest = [
                        "Phone" => [
                            "Tab1" => [
                                "F_PERIOD" => $F_PERIOD,
                                "T_PERIOD" => $T_PERIOD,
                                "TYPECONT" => $TYPECONT
                            ]
                        ]
                    ];
                    //--------------------------------------------------------------------------------------
                    $activeTab = [
                        "Phone" => 1
                    ];
                    //--------------------------------------------------------------------------------------
                    $htmlTab = $this->generatePhoneTab($lastRequest, $activeTab);
                    //--------------------------------------------------------------------------------------
                    return response()->json(['status' => 'success', 'html' => $htmlTab], 200);
                } elseif ($request->func == 'reset') {
                    //-----------------------------------------------------------------
                    DB::beginTransaction();
                    try {
                        $updateQuery = DB::table('PatchTB_SPASTDUE')
                            ->where('UserZone', auth()->user()->zone)
                            ->where('GroupingType', 'P')
                            ->update([
                                'GroupingTemp' => null,
                                'GroupingType' => null,
                                'FOLCODE' => null,
                                'GroupingState' => null,
                            ]);
                        DB::commit();
                    }catch (\Exception $e) {
                        DB::rollback();
                        Log::channel('daily')->error($e->getMessage());
                        return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
                    }
                    //--------------------------------------------------------------------------------------
                    $activeTab = [
                        "Phone" => 1
                    ];
                    //--------------------------------------------------------------------------------------
                    $htmlTab = $this->generatePhoneTab(null, $activeTab);
                    //----------------------------------------------------------------
                    return response()->json(['status' => 'success', 'html' => $htmlTab], 200);
                }
                elseif ($request->func == 'confirm') {
                    //-----------------------------------------------------------------
                    DB::beginTransaction();
                    try {
                        $updateQuery = DB::table('PatchTB_SPASTDUE')
                            ->where('UserZone', auth()->user()->zone)
                            ->where('GroupingType', 'P')
                            ->whereNotNull('GroupingTemp')
                            ->whereNotNull('FOLCODE')
                            ->whereNull('GroupingState')
                            ->update([
                                'GroupingState' => 'Y',
                            ]);
                        DB::commit();
                    }catch (\Exception $e) {
                        DB::rollback();
                        Log::channel('daily')->error($e->getMessage());
                        return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
                    }
                    //--------------------------------------------------------------------------------------
                    $activeTab = [
                        "Phone" => 3
                    ];
                    $htmlTab = $this->generatePhoneTab(null, $activeTab);
                    return response()->json(['status' => 'success', 'html' => $htmlTab], 200);
                }
                elseif ($request->func == 'billcoll') {
                    //--------------------------------------------------------------------------------------
                    // * บันทึกการแก้ไข billcoll จาก Tab 3
                    DB::beginTransaction();
                    try {
                        $data = PatchTB_SPASTDUE::whereIn('id', $request->data['A_SPASTID'])
                            ->update([
                                'FOLCODE' => intval($request->data['BILLCOLL']),
                            ]);
                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        Log::channel('daily')->error($e->getMessage());
                        return response()->json(['message' => $e->getMessage(), 'code' => 500], 500);
                    }
                    //--------------------------------------------------------------------------------------
                    $activeTab = [
                        "Phone" => 3
                    ];
                    $htmlTab = $this->generatePhoneTab(null, $activeTab);
                    return response()->json(['status' => 'success', 'html' => $htmlTab], 200);
                }
            } elseif ($request->mode == 'track') {
                if ($request->func == 'grouping') {
                    // งานโทรแบ่งกลุ่มตามสาขาโดยอัติโนมัติ
                    $F_PERIOD = $request->F_PERIOD;
                    $T_PERIOD = $request->T_PERIOD;
                    $TYPECONT = $request->TYPECONT;
                    $AMOUNT = intval($request->AMOUNT);
                    $CODLOAN = null;
                    if ($TYPECONT == 'HP') {
                        $CODLOAN = '2';
                    }
                    if ($TYPECONT == 'PSL') {
                        $CODLOAN = '1';
                    }
                    $groupingStack = $request->groupingStack;
                    if ($CODLOAN != null) {
                        try {
                            if ($groupingStack == "false") {
                                // ! แบ่งกลุ่มแบบปกติทั่วไป
                                DB::transaction(function () use ($F_PERIOD, $T_PERIOD, $CODLOAN, $AMOUNT) {
                                    $updateQuery = "UPDATE t
                                                    SET
                                                        t.GroupingTemp = ranked.GroupRank,
                                                        t.GroupingType = 'T'
                                                    FROM PatchTB_SPASTDUE AS t
                                                    INNER JOIN (
                                                        SELECT
                                                            SPASTDUE.id,
                                                            NTILE(?) OVER (ORDER BY SPASTDUE.id) AS GroupRank
                                                        FROM PatchTB_SPASTDUE AS SPASTDUE
                                                        WHERE SPASTDUE.UserZone = ?
                                                            AND SPASTDUE.CODLOAN = ?
                                                            AND SPASTDUE.HLDNO BETWEEN ? AND ?
                                                            AND (SPASTDUE.CODLOAN <> 1 OR SPASTDUE.CONTTYP <> 3)
                                                            AND SPASTDUE.GroupingType IS NULL
                                                    ) AS ranked ON t.id = ranked.id";
                                    DB::statement($updateQuery, [$AMOUNT, auth()->user()->zone, $CODLOAN, $F_PERIOD, $T_PERIOD]);
                                });
                            } else {
                                // ! แบ่งกลุ่มซ้ำ ในขณะที่มีการแบ่งกลุ่มอยู่แล้ว
                                DB::transaction(function () use ($F_PERIOD, $T_PERIOD, $CODLOAN, $AMOUNT) {
                                    $updateQuery = "UPDATE t
                                                    SET
                                                        t.GroupingTemp = ranked.GroupRank,
                                                        t.GroupingType = 'T'
                                                    FROM PatchTB_SPASTDUE AS t
                                                    INNER JOIN (
                                                        SELECT
                                                            SPASTDUE.id,
                                                            NTILE(?) OVER (ORDER BY SPASTDUE.id) + QMAX.LAST_GROUP AS GroupRank
                                                        FROM PatchTB_SPASTDUE AS SPASTDUE
                                                        CROSS JOIN (
                                                            SELECT COALESCE( MAX(GroupingTemp), 0) AS LAST_GROUP
                                                            FROM PatchTB_SPASTDUE
                                                            WHERE GroupingType = 'T'
                                                                AND UserZone = ?
                                                                AND CODLOAN = ?
                                                                AND (CODLOAN <> 1 OR CONTTYP <> 3)
                                                        ) AS QMAX
                                                        WHERE SPASTDUE.UserZone = ?
                                                            AND SPASTDUE.CODLOAN = ?
                                                            AND SPASTDUE.HLDNO BETWEEN ? AND ?
                                                            AND (SPASTDUE.CODLOAN <> 1 OR SPASTDUE.CONTTYP <> 3)
                                                            AND SPASTDUE.GroupingType IS NULL
                                                    ) AS ranked ON t.id = ranked.id";
                                    DB::statement($updateQuery, [$AMOUNT, auth()->user()->zone, $CODLOAN, auth()->user()->zone, $CODLOAN, $F_PERIOD, $T_PERIOD]);
                                });
                            }
                        } catch (\Exception $e) {
                            // จัดการกับ exception ที่นี่
                            return response()->json(['error' => $e->getMessage()], 500);
                        }
                    }
                    //--------------------------------------------------------------------------------------
                    $lastRequest = [
                        "Track" => [
                            "Tab1" => [
                                "F_PERIOD" => $F_PERIOD,
                                "T_PERIOD" => $T_PERIOD,
                                "TYPECONT" => $TYPECONT,
                                "AMOUNT" => $AMOUNT
                            ]
                        ]
                    ];
                    //--------------------------------------------------------------------------------------
                    $activeTab = [
                        "Track" => 1
                    ];
                    //--------------------------------------------------------------------------------------
                    $htmlTab = $this->generateTrackTab($lastRequest, $activeTab);
                    //--------------------------------------------------------------------------------------
                    return response()->json(['status' => 'success', 'html' => $htmlTab], 200);
                }
                elseif ($request->func == 'reset') {
                    //-----------------------------------------------------------------
                    DB::beginTransaction();
                    try {
                        $updateQuery = DB::table('PatchTB_SPASTDUE')
                            ->where('UserZone', auth()->user()->zone)
                            ->where('GroupingType', 'T')
                            ->update([
                                'GroupingTemp' => null,
                                'GroupingType' => null,
                                'FOLCODE' => null,
                                'GroupingState' => null,
                            ]);
                        DB::commit();
                    }catch (\Exception $e) {
                        DB::rollback();
                        Log::channel('daily')->error($e->getMessage());
                        return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
                    }
                    //--------------------------------------------------------------------------------------
                    $activeTab = [
                        "Track" => 1
                    ];
                    //--------------------------------------------------------------------------------------
                    $htmlTab = $this->generateTrackTab(null, $activeTab);
                    //----------------------------------------------------------------
                    return response()->json(['status' => 'success', 'html' => $htmlTab], 200);
                }
                elseif ($request->func == 'confirm') {
                    //-----------------------------------------------------------------
                    DB::beginTransaction();
                    try {
                        $updateQuery = DB::table('PatchTB_SPASTDUE')
                            ->where('UserZone', auth()->user()->zone)
                            ->where('GroupingType', 'T')
                            ->whereNotNull('GroupingTemp')
                            ->whereNotNull('FOLCODE')
                            ->whereNull('GroupingState')
                            ->update([
                                'GroupingState' => 'Y',
                            ]);
                        DB::commit();
                    }catch (\Exception $e) {
                        DB::rollback();
                        Log::channel('daily')->error($e->getMessage());
                        return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
                    }
                    //--------------------------------------------------------------------------------------
                    $activeTab = [
                        "Track" => 3
                    ];
                    $htmlTab = $this->generateTrackTab(null, $activeTab);
                    return response()->json(['status' => 'success', 'html' => $htmlTab], 200);
                }
                elseif ($request->func == 'billcoll') {
                    //--------------------------------------------------------------------------------------
                    // * บันทึกการแก้ไข billcoll จาก Tab 3
                    DB::beginTransaction();
                    try {
                        $data = PatchTB_SPASTDUE::whereIn('id', $request->data['A_SPASTID'])
                            ->update([
                                'FOLCODE' => intval($request->data['BILLCOLL']),
                            ]);
                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        Log::channel('daily')->error($e->getMessage());
                        return response()->json(['message' => $e->getMessage(), 'code' => 500], 500);
                    }
                    //--------------------------------------------------------------------------------------
                    $activeTab = [
                        "Track" => 3
                    ];
                    $htmlTab = $this->generateTrackTab(null, $activeTab);
                    return response()->json(['status' => 'success', 'html' => $htmlTab], 200);
                }
            } elseif ($request->mode == 'land') {
                if ($request->func == 'grouping') {
                    // งานโทรแบ่งกลุ่มตามสาขาโดยอัติโนมัติ
                    $F_PERIOD = $request->F_PERIOD;
                    $T_PERIOD = $request->T_PERIOD;
                    $TYPECONT = $request->TYPECONT;
                    $AMOUNT = intval($request->AMOUNT);
                    $CODLOAN = null;
                    if ($TYPECONT == 'HP') {
                        $CODLOAN = '2';
                    }
                    if ($TYPECONT == 'PSL') {
                        $CODLOAN = '1';
                    }
                    $groupingStack = $request->groupingStack;
                    if ($CODLOAN != null) {
                        try {
                            if ($groupingStack == "false") {
                                // ! แบ่งกลุ่มแบบปกติทั่วไป
                                DB::transaction(function () use ($F_PERIOD, $T_PERIOD, $CODLOAN, $AMOUNT) {
                                    $updateQuery = "UPDATE l
                                                    SET
                                                        l.GroupingTemp = ranked.GroupRank,
                                                        l.GroupingType = 'L'
                                                    FROM PatchTB_SPASTDUE AS l
                                                    INNER JOIN (
                                                        SELECT
                                                            SPASTDUE.id,
                                                            NTILE(?) OVER (ORDER BY SPASTDUE.id) AS GroupRank
                                                        FROM PatchTB_SPASTDUE AS SPASTDUE
                                                        WHERE SPASTDUE.UserZone = ?
                                                            AND SPASTDUE.CODLOAN = ?
                                                            AND SPASTDUE.HLDNO BETWEEN ? AND ?
                                                            AND (SPASTDUE.CODLOAN = 1 AND SPASTDUE.CONTTYP = 3)
                                                            AND SPASTDUE.GroupingType IS NULL
                                                    ) AS ranked ON l.id = ranked.id";
                                    DB::statement($updateQuery, [$AMOUNT, auth()->user()->zone, $CODLOAN, $F_PERIOD, $T_PERIOD]);
                                });
                            } else {
                                // ! แบ่งกลุ่มซ้ำ ในขณะที่มีการแบ่งกลุ่มอยู่แล้ว
                                DB::transaction(function () use ($F_PERIOD, $T_PERIOD, $CODLOAN, $AMOUNT) {
                                    $updateQuery = "UPDATE l
                                                    SET
                                                        l.GroupingTemp = ranked.GroupRank,
                                                        l.GroupingType = 'L'
                                                    FROM PatchTB_SPASTDUE AS l
                                                    INNER JOIN (
                                                        SELECT
                                                            SPASTDUE.id,
                                                            NTILE(?) OVER (ORDER BY SPASTDUE.id) + QMAX.LAST_GROUP AS GroupRank
                                                        FROM PatchTB_SPASTDUE AS SPASTDUE
                                                        CROSS JOIN (
                                                            SELECT COALESCE( MAX(GroupingTemp), 0) AS LAST_GROUP
                                                            FROM PatchTB_SPASTDUE
                                                            WHERE GroupingType = 'L'
                                                                AND UserZone = ?
                                                                AND CODLOAN = ?
                                                                AND (CODLOAN = 1 OR CONTTYP = 3)
                                                        ) AS QMAX
                                                        WHERE SPASTDUE.UserZone = ?
                                                            AND SPASTDUE.CODLOAN = ?
                                                            AND SPASTDUE.HLDNO BETWEEN ? AND ?
                                                            AND (SPASTDUE.CODLOAN = 1 AND SPASTDUE.CONTTYP = 3)
                                                            AND SPASTDUE.GroupingType IS NULL
                                                    ) AS ranked ON l.id = ranked.id";
                                    DB::statement($updateQuery, [$AMOUNT, auth()->user()->zone, $CODLOAN, auth()->user()->zone, $CODLOAN, $F_PERIOD, $T_PERIOD]);
                                });
                            }
                        } catch (\Exception $e) {
                            // จัดการกับ exception ที่นี่
                            return response()->json(['error' => $e->getMessage()], 500);
                        }
                    }
                    //--------------------------------------------------------------------------------------
                    $lastRequest = [
                        "Land" => [
                            "Tab1" => [
                                "F_PERIOD" => $F_PERIOD,
                                "T_PERIOD" => $T_PERIOD,
                                "TYPECONT" => $TYPECONT,
                                "AMOUNT" => $AMOUNT
                            ]
                        ]
                    ];
                    //--------------------------------------------------------------------------------------
                    $activeTab = [
                        "Land" => 1
                    ];
                    //--------------------------------------------------------------------------------------
                    $htmlTab = $this->generateLandTab($lastRequest, $activeTab);
                    //--------------------------------------------------------------------------------------
                    return response()->json(['status' => 'success', 'html' => $htmlTab], 200);
                }
                elseif ($request->func == 'reset') {
                    //-----------------------------------------------------------------
                    DB::beginTransaction();
                    try {
                        $updateQuery = DB::table('PatchTB_SPASTDUE')
                            ->where('UserZone', auth()->user()->zone)
                            ->where('GroupingType', 'L')
                            ->update([
                                'GroupingTemp' => null,
                                'GroupingType' => null,
                                'FOLCODE' => null,
                                'GroupingState' => null,
                            ]);
                        DB::commit();
                    }catch (\Exception $e) {
                        DB::rollback();
                        Log::channel('daily')->error($e->getMessage());
                        return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
                    }
                    //--------------------------------------------------------------------------------------
                    $activeTab = [
                        "Land" => 1
                    ];
                    //--------------------------------------------------------------------------------------
                    $htmlTab = $this->generateLandTab(null, $activeTab);
                    //----------------------------------------------------------------
                    return response()->json(['status' => 'success', 'html' => $htmlTab], 200);
                }
                elseif ($request->func == 'confirm') {
                    //-----------------------------------------------------------------
                    DB::beginTransaction();
                    try {
                        $updateQuery = DB::table('PatchTB_SPASTDUE')
                            ->where('UserZone', auth()->user()->zone)
                            ->where('GroupingType', 'L')
                            ->whereNotNull('GroupingTemp')
                            ->whereNotNull('FOLCODE')
                            ->whereNull('GroupingState')
                            ->update([
                                'GroupingState' => 'Y',
                            ]);
                        DB::commit();
                    }catch (\Exception $e) {
                        DB::rollback();
                        Log::channel('daily')->error($e->getMessage());
                        return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
                    }
                    //--------------------------------------------------------------------------------------
                    $activeTab = [
                        "Land" => 3
                    ];
                    $htmlTab = $this->generateLandTab(null, $activeTab);
                    return response()->json(['status' => 'success', 'html' => $htmlTab], 200);
                }
                elseif ($request->func == 'billcoll') {
                    //--------------------------------------------------------------------------------------
                    // * บันทึกการแก้ไข billcoll จาก Tab 3
                    DB::beginTransaction();
                    try {
                        $data = PatchTB_SPASTDUE::whereIn('id', $request->data['A_SPASTID'])
                            ->update([
                                'FOLCODE' => intval($request->data['BILLCOLL']),
                            ]);
                        DB::commit();
                    } catch (\Exception $e) {
                        DB::rollBack();
                        Log::channel('daily')->error($e->getMessage());
                        return response()->json(['message' => $e->getMessage(), 'code' => 500], 500);
                    }
                    //--------------------------------------------------------------------------------------
                    $activeTab = [
                        "Land" => 3
                    ];
                    $htmlTab = $this->generateLandTab(null, $activeTab);
                    return response()->json(['status' => 'success', 'html' => $htmlTab], 200);
                }
            }
        }
        elseif ($request->page == 'group') {
            if ($request->mode == 'phone') {
                $CODLOAN = $request->data['CODLOAN'];
                // * บันทึกการมอบหมายงาน assign
                DB::beginTransaction();
                try {
                    if ($request->flag == 'id') {
                        $data = PatchTB_SPASTDUE::whereIn('id', $request->data['A_SPASTID'])
                            ->update([
                                //'BILLCOLL' => $request->data['BILLCOLL'],
                                'FOLCODE' => intval($request->data['BILLCOLL']),
                            ]);
                    } elseif ($request->flag == 'all') {
                        $groupingTemp = $id;
                        $data = PatchTB_SPASTDUE::where('UserZone', auth()->user()->zone)
                            ->where('CODLOAN', $CODLOAN)
                            ->where('GroupingType', 'P')
                            ->where('GroupingTemp', $groupingTemp)
                            ->update([
                                //'BILLCOLL' => $request->data['BILLCOLL'],
                                'FOLCODE' => intval($request->data['BILLCOLL']),
                            ]);
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::channel('daily')->error($e->getMessage());
                    return response()->json(['message' => $e->getMessage(), 'code' => 500], 500);
                }
                //--------------------------------------------------------------------------------------
                $lastRequest = [
                    "Phone" => [
                        "Tab2" => [
                            'CODLOAN' => $CODLOAN,
                        ]
                    ]
                ];
                //--------------------------------------------------------------------------------------
                $activeTab = [
                    "Phone" => 2
                ];
                $htmlTab = $this->generatePhoneTab($lastRequest, $activeTab);
                //--------------------------------------------------------------------------------------
                return response()->json([
                    'status' => 'success',
                    'message' => 'มอบหมายงานสำเร็จแล้ว!',
                    'html' => $htmlTab
                ], 200);
            } elseif ($request->mode == "track") {
                $CODLOAN = $request->data['CODLOAN'];
                // * บันทึกการมอบหมายงาน assign
                DB::beginTransaction();
                try {
                    if ($request->flag == 'id') {
                        $data = PatchTB_SPASTDUE::whereIn('id', $request->data['A_SPASTID'])
                            ->update([
                                //'BILLCOLL' => $request->data['BILLCOLL'],
                                'FOLCODE' => intval($request->data['BILLCOLL']),
                            ]);
                    } elseif ($request->flag == 'all') {
                        $groupingTemp = $id;
                        $data = PatchTB_SPASTDUE::where('UserZone', auth()->user()->zone)
                            ->where('CODLOAN', $CODLOAN)
                            ->where('GroupingType', 'T')
                            ->where('GroupingTemp', $groupingTemp)
                            ->update([
                                //'BILLCOLL' => $request->data['BILLCOLL'],
                                'FOLCODE' => intval($request->data['BILLCOLL']),
                            ]);
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::channel('daily')->error($e->getMessage());
                    return response()->json(['message' => $e->getMessage(), 'code' => 500], 500);
                }
                //--------------------------------------------------------------------------------------
                $lastRequest = [
                    "Track" => [
                        "Tab2" => [
                            'CODLOAN' => $CODLOAN,
                        ]
                    ]
                ];
                //--------------------------------------------------------------------------------------
                $activeTab = [
                    "Track" => 2
                ];
                $htmlTab = $this->generateTrackTab($lastRequest, $activeTab);
                //--------------------------------------------------------------------------------------
                return response()->json([
                    'status' => 'success',
                    'message' => 'มอบหมายงานสำเร็จแล้ว!',
                    'html' => $htmlTab
                ], 200);
            } elseif ($request->mode == "land") {
                $CODLOAN = $request->data['CODLOAN'];
                // * บันทึกการมอบหมายงาน assign
                DB::beginTransaction();
                try {
                    if ($request->flag == 'id') {
                        $data = PatchTB_SPASTDUE::whereIn('id', $request->data['A_SPASTID'])
                            ->update([
                                //'BILLCOLL' => $request->data['BILLCOLL'],
                                'FOLCODE' => intval($request->data['BILLCOLL']),
                            ]);
                    } elseif ($request->flag == 'all') {
                        $groupingTemp = $id;
                        $data = PatchTB_SPASTDUE::where('UserZone', auth()->user()->zone)
                            ->where('CODLOAN', $CODLOAN)
                            ->where('GroupingType', 'L')
                            ->where('GroupingTemp', $groupingTemp)
                            ->update([
                                //'BILLCOLL' => $request->data['BILLCOLL'],
                                'FOLCODE' => intval($request->data['BILLCOLL']),
                            ]);
                    }
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollBack();
                    Log::channel('daily')->error($e->getMessage());
                    return response()->json(['message' => $e->getMessage(), 'code' => 500], 500);
                }
                //--------------------------------------------------------------------------------------
                $lastRequest = [
                    "Land" => [
                        "Tab2" => [
                            'CODLOAN' => $CODLOAN,
                        ]
                    ]
                ];
                //--------------------------------------------------------------------------------------
                $activeTab = [
                    "Land" => 2
                ];
                $htmlTab = $this->generateLandTab($lastRequest, $activeTab);
                //--------------------------------------------------------------------------------------
                return response()->json([
                    'status' => 'success',
                    'message' => 'มอบหมายงานสำเร็จแล้ว!',
                    'html' => $htmlTab
                ], 200);
            }
        }
        elseif ($request->page == 'assign-all') {
            // * มอบหมายงานทั้งหมด
            if ($request->mode == 'phone') {
                $BILLCOLL = $request->AssignAll_BILLCOLL;
                try {
                    DB::transaction(function () use ($BILLCOLL) {
                        foreach ($BILLCOLL as $codloan => $subArray) {
                            foreach ($subArray as $groupingTemp => $value) {
                                PatchTB_SPASTDUE::where('UserZone', auth()->user()->zone)
                                                ->where('CODLOAN', $codloan)
                                                ->where('GroupingType', 'P')
                                                ->where('GroupingTemp', $groupingTemp)
                                                ->whereNull('FOLCODE')
                                                ->update(['FOLCODE' => intval($value)]);
                            }
                        }
                    });
                } catch (\Exception $e) {
                    Log::channel('daily')->error($e->getMessage());
                    return response()->json(['message' => $e->getMessage(), 'code' => 500], 500);
                }
                //--------------------------------------------------------------------------------------
                $activeTab = [
                    "Phone" => 2
                ];
                $htmlTab = $this->generatePhoneTab(null, $activeTab);
                return response()->json([
                    'status' => 'success',
                    'message' => 'มอบหมายงานสำเร็จแล้ว!',
                    'html' => $htmlTab
                ], 200);
            } elseif ($request->mode == 'track') {
                $BILLCOLL = $request->AssignAll_BILLCOLL;
                try {
                    DB::transaction(function () use ($BILLCOLL) {
                        foreach ($BILLCOLL as $codloan => $subArray) {
                            foreach ($subArray as $groupingTemp => $value) {
                                PatchTB_SPASTDUE::where('UserZone', auth()->user()->zone)
                                                ->where('CODLOAN', $codloan)
                                                ->where('GroupingType', 'T')
                                                ->where('GroupingTemp', $groupingTemp)
                                                ->whereNull('FOLCODE')
                                                ->update(['FOLCODE' => intval($value)]);
                            }
                        }
                    });
                } catch (\Exception $e) {
                    Log::channel('daily')->error($e->getMessage());
                    return response()->json(['message' => $e->getMessage(), 'code' => 500], 500);
                }
                //--------------------------------------------------------------------------------------
                $activeTab = [
                    "Track" => 2
                ];
                $htmlTab = $this->generateTrackTab(null, $activeTab);
                return response()->json([
                    'status' => 'success',
                    'message' => 'มอบหมายงานสำเร็จแล้ว!',
                    'html' => $htmlTab
                ], 200);
            } elseif ($request->mode == 'land') {
                $BILLCOLL = $request->AssignAll_BILLCOLL;
                try {
                    DB::transaction(function () use ($BILLCOLL) {
                        foreach ($BILLCOLL as $codloan => $subArray) {
                            foreach ($subArray as $groupingTemp => $value) {
                                PatchTB_SPASTDUE::where('UserZone', auth()->user()->zone)
                                                ->where('CODLOAN', $codloan)
                                                ->where('GroupingType', 'L')
                                                ->where('GroupingTemp', $groupingTemp)
                                                ->whereNull('FOLCODE')
                                                ->update(['FOLCODE' => intval($value)]);
                            }
                        }
                    });
                } catch (\Exception $e) {
                    Log::channel('daily')->error($e->getMessage());
                    return response()->json(['message' => $e->getMessage(), 'code' => 500], 500);
                }
                //--------------------------------------------------------------------------------------
                $activeTab = [
                    "Land" => 2
                ];
                $htmlTab = $this->generateLandTab(null, $activeTab);
                return response()->json([
                    'status' => 'success',
                    'message' => 'มอบหมายงานสำเร็จแล้ว!',
                    'html' => $htmlTab
                ], 200);
            }
        }
    }

    public function destroy($id)
    {
        //
    }

    public function getEmployees(Request $request)
    {
        ## Read value
        $draw = $request->get('draw');
        $start = $request->get("start");
        $rowperpage = $request->get("length"); // Rows display per page

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column']; // Column index
        $columnName = $columnName_arr[$columnIndex]['data']; // Column name
        $columnSortOrder = $order_arr[0]['dir']; // asc or desc
        $searchValue = $search_arr['value']; // Search value

        // Total records
        $totalRecords = Employees::select('count(*) as allcount')->count();
        $totalRecordswithFilter = Employees::select('count(*) as allcount')->where('name', 'like', '%' . $searchValue . '%')->count();

        // Fetch records
        $records = Employees::orderBy($columnName, $columnSortOrder)
            ->where('employees.name', 'like', '%' . $searchValue . '%')
            ->select('employees.*')
            ->skip($start)
            ->take($rowperpage)
            ->get();

        $data_arr = array();

        foreach ($records as $record) {
            $id = $record->id;
            $username = $record->username;
            $name = $record->name;
            $email = $record->email;

            $data_arr[] = array(
                "id" => $id,
                "username" => $username,
                "name" => $name,
                "email" => $email
            );
        }

        $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecords,
            "iTotalDisplayRecords" => $totalRecordswithFilter,
            "aaData" => $data_arr
        );

        return response()->json($response);
    }

    public function generatePhoneTab($lastRequest, $activeTab)
    {
        $phoneData = View_PatchSPASTDUE_Task::getPhoneData( auth()->user()->zone );
        $groupPhone = $phoneData[0];
        $phone_unassigned = $phoneData[1];
        $phone_unconfirmed = $phoneData[2];
        $billcoll = TB_BILLCOLL::generateQuery()
                        ->pluck('DISPLAY_BILLCOLL', 'id')
                        ->all();
        //--------------------------------------------------------------------------------------
        $unlockTab = [
            "Phone" => [
                1 => true,
                2 => ($groupPhone->count() > 0),
                3 => ($phone_unconfirmed > 0) || ($groupPhone->whereNotNull('GroupingState')->count() > 0),
            ]
        ];
        //--------------------------------------------------------------------------------------
        $highlightsNextTab = false;
        if ($activeTab['Phone'] == 1) {
            $highlightsNextTab = ($groupPhone->count() > 0);
        } elseif ($activeTab['Phone'] == 2) {
            $highlightsNextTab = ($phone_unconfirmed > 0);
        }
        //--------------------------------------------------------------------------------------
        $htmlRender = view('backend.content-track.session-task.tabContent.phone', compact('groupPhone', 'billcoll', 'phone_unassigned','phone_unconfirmed','activeTab','lastRequest','unlockTab','highlightsNextTab'))->render();
        return $htmlRender;
    }

    public function generateTrackTab($lastRequest, $activeTab)
    {
        $trackData = View_PatchSPASTDUE_Task::getTrackData( auth()->user()->zone );
        $groupTrack = $trackData[0];
        $track_unassigned = $trackData[1];
        $track_unconfirmed = $trackData[2];
        $billcoll = TB_BILLCOLL::generateQuery()
                        ->pluck('DISPLAY_BILLCOLL', 'id')
                        ->all();
        //--------------------------------------------------------------------------------------
        $unlockTab = [
            "Track" => [
                1 => true,
                2 => ($groupTrack->count() > 0),
                3 => ($track_unassigned > 0) || ($groupTrack->whereNotNull('GroupingState')->count() > 0),
            ]
        ];
        //--------------------------------------------------------------------------------------
        $highlightsNextTab = false;
        if ($activeTab['Track'] == 1) {
            $highlightsNextTab = ($groupTrack->count() > 0);
        } elseif ($activeTab['Track'] == 2) {
            $highlightsNextTab = ($track_unconfirmed > 0);
        }
        //--------------------------------------------------------------------------------------
        $htmlRender = view('backend.content-track.session-task.tabContent.track', compact('groupTrack', 'billcoll', 'track_unassigned','track_unconfirmed','activeTab','lastRequest','unlockTab','highlightsNextTab'))->render();
        return $htmlRender;
    }

    public function generateLandTab($lastRequest, $activeTab)
    {
        $landData = View_PatchSPASTDUE_Task::getLandData( auth()->user()->zone );
        $groupLand = $landData[0];
        $land_unassigned = $landData[1];
        $land_unconfirmed = $landData[2];
        $billcoll = TB_BILLCOLL::generateQuery()
                        ->pluck('DISPLAY_BILLCOLL', 'id')
                        ->all();
        //--------------------------------------------------------------------------------------
        $unlockTab = [
            "Land" => [
                1 => true,
                2 => ($groupLand->count() > 0),
                3 => ($land_unassigned > 0) || ($groupLand->whereNotNull('GroupingState')->count() > 0),
            ]
        ];
        //--------------------------------------------------------------------------------------
        $highlightsNextTab = false;
        if ($activeTab['Land'] == 1) {
            $highlightsNextTab = ($groupLand->count() > 0);
        } elseif ($activeTab['Land'] == 2) {
            $highlightsNextTab = ($land_unconfirmed > 0);
        }
        //--------------------------------------------------------------------------------------
        $htmlRender = view('backend.content-track.session-task.tabContent.land', compact('groupLand', 'billcoll', 'land_unassigned','land_unconfirmed','activeTab','lastRequest','unlockTab','highlightsNextTab'))->render();
        return $htmlRender;
    }

}
