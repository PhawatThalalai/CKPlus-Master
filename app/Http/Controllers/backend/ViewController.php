<?php

namespace App\Http\Controllers\backend;

use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;
use Hash;

use App\Models\TB_view\View_PatchSPASTDUE_Task;
use App\Models\TB_view\VWDEBT_RPSPASTDUE;

use App\Models\TB_Constants\TB_Frontend\TB_Branchs;

use App\Models\TB_Constants\TB_Backend\TB_Statusdebt;
use App\Models\TB_Constants\TB_Backend\TB_CONFPSL;
use App\Models\TB_Constants\TB_Backend\TB_CONFHP;
use App\Models\TB_Constants\TB_Backend\TB_TRLIST;
use App\Models\TB_Constants\TB_Backend\TB_BILLCOLL;
use App\Models\TB_Constants\TB_Backend\TB_GROUPDEBT;
use App\Models\TB_Constants\TB_Backend\TB_GROUPKANGDUE;

use App\Models\TB_Constants\TB_Frontend\TB_Groups;
use App\Models\TB_Constants\TB_Frontend\TB_GroupLists;

use App\Models\TB_PactContracts\Pact_Contracts;

use App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_CHQMas;
use App\Models\TB_PatchContracts\TB_Payments\PatchHP\PatchHP_CHQMas;

use App\Models\TB_DOC\TAKE_DOC;
use App\Models\TB_DOC\TYPE_TAKE_DOC;

class ViewController extends Controller
{
    public static function query($user_zone, $newfdate, $newtdate, $id)
    {
        $query = Pact_Contracts::where('UserZone', $user_zone)
            ->whereNotNull('Date_monetary')
            ->whereNull('Flag_Inside')
            //  ->where(DB::raw(" FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"), '>', '2024-03-31')
            ->when(!empty($id), function ($q) use ($id) {
                return $q->where('BranchSent_Con', $id);
            })
            ->when(!empty($newfdate) && !empty($newtdate), function ($q) use ($newfdate, $newtdate) {
                return $q->whereBetween(DB::raw(" FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"), [$newfdate, $newtdate]);
            });

        return $query;
    }
    public function index(Request $request)
    {
        $user_zone = auth()->user()->zone;
        $dataBranch = TB_Branchs::generateQuery();
        $page = $request->page;
        $branchId = $request->id;

        if ($request->page == 'create-cont') { //view contract
            /*** set value search */
            $page = 'create-cont';
            $Fdate1 = @$request->start;
            $Tdate1 = @$request->end;

            $start = date_create($Fdate1);
            $newfdate = ($Fdate1 != NULL) ? date_format($start, "Y-m-d") : NULL;
            $end = date_create($Tdate1);
            $newtdate = ($Tdate1 != NULL) ? date_format($end, "Y-m-d") : NULL;

            $user_zone = auth()->user()->zone;
            $loanCode = '01';

            $dataBranch = TB_Branchs::generateQuery();
            // $loanTb = TB_TypeLoan::where('Loan_Code',$loanCode)->first();
            $Branch = static::query($user_zone, $newfdate, $newtdate, $branchId)->select('BranchSent_Con', DB::raw('count(*) as total'))->groupBY('BranchSent_Con')->get();

            $countDataBranch = array();
            foreach ($Branch as $key => $value) {
                $countDataBranch[$value->BranchSent_Con] = $value->total;
            }

            return view('backend.content-view.section-contract.view-contract', compact('dataBranch', 'countDataBranch', 'page', 'Fdate1', 'Tdate1'));
        } elseif ($request->page == 'contract') {
            return view('backend.content-contract.view-contract', compact('page'));
        } elseif ($request->page == 'payments') {
            return view('backend.content-payments.view-payment', compact('page'));
        } elseif ($request->page == 'cn-pays') {
            // ดึง Role ของผู้ใช้ปัจจุบัน
            $userRoles = auth()->user()->getRoleNames()->toArray();

            // กำหนด Role ที่อนุญาตให้เข้าใช้งาน
            $userArr = ['administrator', 'superadmin', 'audit', 'manager', 'accountings'];
            // ตรวจสอบว่า Role ของผู้ใช้ตรงกับ Role ที่อนุญาตหรือไม่
            $chkRole = count(array_intersect($userArr, $userRoles)) > 0;

            // ถ้าผู้ใช้มีสิทธิ์ให้เข้าใช้งานได้ปกติ
            if ($chkRole) {
                $Fdate1 = @$request->start;
                $Tdate1 = @$request->end;

                $start = date_create($Fdate1);
                $newfdate = ($Fdate1 != NULL) ? date_format($start, "Y-m-d") : NULL;
                $end = date_create($Tdate1);
                $newtdate = ($Tdate1 != NULL) ? date_format($end, "Y-m-d") : NULL;

                $dataPsl = PatchPSL_CHQMas::select('id', 'PatchCon_id', 'CONTNO', 'LOCATREC', 'BILLNO', 'PAYTYP', 'CHQAMT', 'PAYDT', 'ASK_DT', 'ASK_USERID', 'TYPEPAY')
                    ->where('ASK_FLAG', 'N')
                    ->where('UserZone', auth()->user()->zone)
                    ->when(!empty($newfdate) && !empty($newtdate), function ($q) use ($newfdate, $newtdate) {
                        return $q->whereBetween(DB::raw(" FORMAT (cast(PAYDT as date), 'yyyy-MM-dd')"), [$newfdate, $newtdate]);
                    })
                    ->get();

                $dataHp = PatchHP_CHQMas::select('id', 'PatchCon_id', 'CONTNO', 'LOCATREC', 'BILLNO', 'PAYTYP', 'CHQAMT', 'PAYDT', 'ASK_DT', 'ASK_USERID', 'TYPEPAY')
                    ->where('ASK_FLAG', 'N')
                    ->where('UserZone', auth()->user()->zone)
                    ->when(!empty($newfdate) && !empty($newtdate), function ($q) use ($newfdate, $newtdate) {
                        return $q->whereBetween(DB::raw(" FORMAT (cast(PAYDT as date), 'yyyy-MM-dd')"), [$newfdate, $newtdate]);
                    })
                    ->get();

                return view('backend.content-payments.section-CnPay.view-CnPay', compact('dataPsl', 'dataHp', 'page', 'Fdate1', 'Tdate1'));
            } else {
                // ถ้าผู้ใช้ไม่มีสิทธิ์ ให้แสดงข้อความ "ไม่มีสิทธิ์"
                return response('ไม่มีสิทธิ์', 403);
            }
        } elseif ($request->page == 'imp-pays') {
            session()->forget('detailBank');
            session()->forget('dataHeader');
            session()->forget('dataDetails');
            session()->forget('dataFooter');

            return view('backend.content-payments.section-view.view-import', compact('page'));
        } elseif ($request->page == 'imp-payslist') {
            return view('backend.content-payments.section-view.view-paylist', compact('page'));
        } elseif ($request->page == 'imp-autopayment') {
            $check_process = DB::table('VWBC_REPPAYDAILY')
                ->where('STAT', 'Y')
                ->where('POSTBL', 'N')
                ->get();

            return view('backend.content-payments.section-view.view-autopay', compact('check_process', 'page'));
        } elseif ($request->page == 'track-create-task') {    //บันทึกแบ่งกลุ่มลูกหนี้
            $hideSearchTopbar = true;
            //---------------------------------------------------------------------------
            $phoneData = View_PatchSPASTDUE_Task::getPhoneData(auth()->user()->zone);
            $groupPhone = $phoneData[0];
            $phone_unassigned = $phoneData[1];
            $phone_unconfirmed = $phoneData[2];
            //-------------------
            $trackData = View_PatchSPASTDUE_Task::getTrackData(auth()->user()->zone);
            $groupTrack = $trackData[0];
            $track_unassigned = $trackData[1];
            $track_unconfirmed = $trackData[2];
            //-------------------
            $landData = View_PatchSPASTDUE_Task::getLandData(auth()->user()->zone);
            $groupLand = $landData[0];
            $land_unassigned = $landData[1];
            $land_unconfirmed = $landData[2];
            //-------------------
            $billcoll = TB_BILLCOLL::generateQuery()
                ->pluck('DISPLAY_BILLCOLL', 'id')
                ->all();
            //--------------------------------------------------
            $activePhoneTab = 1;
            if ($phone_unconfirmed > 0) {
                $activePhoneTab = 3;
            } elseif ($phone_unassigned > 0) {
                $activePhoneTab = 2;
            }
            //-------------------
            $activeTrackTab = 1;
            if ($track_unconfirmed > 0) {
                $activeTrackTab = 3;
            } elseif ($track_unassigned > 0) {
                $activeTrackTab = 2;
            }
            //-------------------
            $activeLandTab = 1;
            if ($land_unconfirmed > 0) {
                $activeLandTab = 3;
            } elseif ($land_unassigned > 0) {
                $activeLandTab = 2;
            }
            //-------------------
            $activeTab = [
                "Phone" => $activePhoneTab,
                "Track" => $activeTrackTab,
                "Land" => $activeLandTab,
            ];
            $unlockTab = [
                "Phone" => [
                    1 => true,
                    2 => ($groupPhone->count() > 0),
                    3 => ($phone_unconfirmed > 0) || ($groupPhone->whereNotNull('GroupingState')->count() > 0),
                ],
                "Track" => [
                    1 => true,
                    2 => ($groupTrack->count() > 0),
                    3 => ($track_unconfirmed > 0) || ($groupTrack->whereNotNull('GroupingState')->count() > 0),
                ],
                "Land" => [
                    1 => true,
                    2 => ($groupLand->count() > 0),
                    3 => ($land_unconfirmed > 0) || ($groupLand->whereNotNull('GroupingState')->count() > 0),
                ]
            ];
            //--------------------------------------------------
            return view('backend.content-track.view-tasks', compact('hideSearchTopbar', 'groupPhone', 'billcoll', 'phone_unassigned', 'phone_unconfirmed', 'groupTrack', 'track_unassigned', 'track_unconfirmed', 'groupLand', 'land_unassigned', 'land_unconfirmed', 'activeTab', 'unlockTab', 'page'));
        } elseif ($request->page == 'track-list-call') {      //view รายการกลุ่มงานโทร
            $title = 'รายการแบ่งกลุ่มลูกหนี้งานโทร';
            $mmactive = 'datatrack-p2-active';
            $Fdate1 = @$request->start;
            $Tdate1 = @$request->end;

            $start = date_create($Fdate1);
            $newfdate = ($Fdate1 != NULL) ? date_format($start, "Y-m-d") : NULL;
            $end = date_create($Tdate1);
            $newtdate = ($Tdate1 != NULL) ? date_format($end, "Y-m-d") : NULL;

            $data = VWDEBT_RPSPASTDUE::select('id', 'PatchCon_id', 'EXPREAL', 'CONTNO', 'BILLCOLL', 'DUEDATE', 'SWEXPPRD', 'MinPay', 'LPAYD', 'pactcon_id', 'CODLOAN', 'stdept', 'Name_Cus', 'Phone_cus')
                ->where('UserZone', auth()->user()->zone)
                ->whereIn('GroupingType', ['P,L'])
                ->where('GroupingState', 'Y')
                ->get();

            // $branch = TB_Branchs::where('Zone_Branch', auth()->user()->zone)->get();
            $branch = TB_BILLCOLL::select('id', 'code_billcoll', 'name_billcoll', 'UserZone', 'UserBranch')
                ->where('UserZone', auth()->user()->zone)
                ->whereNotNull('show_phone')
                ->get();
            $groupdebt = TB_GROUPDEBT::get();
            $statusdebt = TB_TRLIST::where('STATUS', 'Y')->get();
            $flag = 'allBranch';
            $GroupType = 'P,L';

            $count = [
                "TrackListToday" => $TrackListToday = VWDEBT_RPSPASTDUE::TrackListToday($GroupType)->count(),
                "Past12PSL" => $Past12PSL = VWDEBT_RPSPASTDUE::Past12PSL($GroupType)->count(),
                "SendManagerPSL" => $SendManagerPSL = VWDEBT_RPSPASTDUE::SendManagerPSL($GroupType)->count(),
                "SendManagerHP" => $SendManagerHP = VWDEBT_RPSPASTDUE::SendManagerHP($GroupType)->count(),
                "AppointmentToday" => $AppointmentToday = VWDEBT_RPSPASTDUE::AppointmentToday($GroupType)->count(),
                "DueToday" => $DueToday = VWDEBT_RPSPASTDUE::DueToday($GroupType)->count(),
                "DueYesterday" => $DueYesterday = VWDEBT_RPSPASTDUE::DueYesterday($GroupType)->count()
            ];

            $userId = 462;
            $permissBillcoll = TB_GroupLists::whereHas('groups', function ($query) use ($userId) {
                $query->whereRaw('EXISTS (SELECT 1 FROM STRING_SPLIT(groupHandler, \',\') AS value WHERE value.value = ?)', [$userId])
                    ->where('groupType', 3);
            })
                ->without('branchs')
                ->get()
                ->pluck('listBranch_id', 'listBranch_id')
                ->all();

            return view('backend.content-track.session-list.view-list-track', compact('mmactive', 'title', 'page', 'data', 'groupdebt', 'statusdebt', 'branch', 'Fdate1', 'Tdate1', 'flag', 'GroupType', 'count', 'permissBillcoll'));
        } elseif ($request->page == 'track-list-follow') {    //view รายการกลุ่มงานตาม
            $title = 'รายการแบ่งกลุ่มลูกหนี้งานตาม';
            $mmactive = 'datatrack-p3-active';
            $Fdate1 = @$request->start;
            $Tdate1 = @$request->end;

            $start = date_create($Fdate1);
            $newfdate = ($Fdate1 != NULL) ? date_format($start, "Y-m-d") : NULL;
            $end = date_create($Tdate1);
            $newtdate = ($Tdate1 != NULL) ? date_format($end, "Y-m-d") : NULL;

            $data = VWDEBT_RPSPASTDUE::select('id', 'PatchCon_id', 'EXPREAL', 'CONTNO', 'BILLCOLL', 'DUEDATE', 'SWEXPPRD', 'MinPay', 'LPAYD', 'pactcon_id', 'CODLOAN', 'stdept', 'Name_Cus', 'Phone_cus')
                ->where('UserZone', auth()->user()->zone)->whereIn('GroupingType', ['T'])->where('GroupingState', 'Y')->get();


            // $branch = TB_Branchs::where('Zone_Branch', auth()->user()->zone)->get();
            $branch = TB_BILLCOLL::where('UserZone', auth()->user()->zone)->whereNotNull('show_tidtam')->get();
            $groupdebt = TB_GROUPDEBT::get();
            $statusdebt = TB_TRLIST::where('STATUS', 'Y')->get();
            $flag = 'allBranch';
            $GroupType = 'T';

            $count = [
                "TrackListToday" => $TrackListToday = VWDEBT_RPSPASTDUE::TrackListToday($GroupType)->count(),
                "Past12PSL" => $Past12PSL = VWDEBT_RPSPASTDUE::Past12PSL($GroupType)->count(),
                "SendManagerPSL" => $SendManagerPSL = VWDEBT_RPSPASTDUE::SendManagerPSL($GroupType)->count(),
                "SendManagerHP" => $SendManagerHP = VWDEBT_RPSPASTDUE::SendManagerHP($GroupType)->count(),
                "AppointmentToday" => $AppointmentToday = VWDEBT_RPSPASTDUE::AppointmentToday($GroupType)->count(),
                "DueToday" => $DueToday = VWDEBT_RPSPASTDUE::DueToday($GroupType)->count(),
                "DueYesterday" => $DueYesterday = VWDEBT_RPSPASTDUE::DueYesterday($GroupType)->count()
            ];

            return view('backend.content-track.session-list.view-list-track', compact('mmactive', 'title', 'page', 'data', 'groupdebt', 'statusdebt', 'branch', 'Fdate1', 'Tdate1', 'flag', 'GroupType', 'count'));
        } elseif ($request->page == 'daily') {      //view daily
            $Fdate1 = @$request->start;
            $Tdate1 = @$request->end;

            $start = date_create($Fdate1);
            $newfdate = ($Fdate1 != NULL) ? date_format($start, "Y-m-d") : NULL;
            $end = date_create($Tdate1);
            $newtdate = ($Tdate1 != NULL) ? date_format($end, "Y-m-d") : NULL;

            $pay_status = TB_Statusdebt::get();
            $branch = TB_Branchs::where('Zone_Branch', auth()->user()->zone);

            $todayformat = date('Y-m');
            // $today = Carbon::today();
            // $todayformat = $today->format('Y-m-d');

            $data = VWDEBT_RPSPASTDUE::where(DB::raw(" FORMAT (cast(LAST_ASSIGNDT as date), 'yyyy-MM')"), $todayformat)
                ->where('UserZone', $user_zone)->limit(100)->get();

            return view('backend.content-result.view-daily', compact('Fdate1', 'Tdate1', 'todayformat', 'pay_status', 'data', 'branch', 'page'));
        } elseif ($request->page == 'monthly') {      //view monthly
            $Fdate1 = @$request->start;
            $Tdate1 = @$request->end;

            $start = date_create($Fdate1);
            $newfdate = ($Fdate1 != NULL) ? date_format($start, "Y-m-d") : NULL;
            $end = date_create($Tdate1);
            $newtdate = ($Tdate1 != NULL) ? date_format($end, "Y-m-d") : NULL;
            $pay_status = TB_Statusdebt::get();
            $branch = TB_Branchs::where('Zone_Branch', auth()->user()->zone)->get();


            $today = Carbon::today();
            $MYFormat = $today->format('Y-m');
            $monthformat = $today->format('m');
            $yearformat = $today->format('Y');
            // $data = PatchPSL_SPASTDUE::where(DB::raw(" FORMAT (cast(created_at as date), 'yyyy-MM-dd')"),$todayformat)->get();
            // $data =  DB::table("VWDEBT_RPSPASTDUEALL")
            // ->where(DB::raw(" FORMAT (cast(LAST_ASSIGNDT as date), 'yyyy-MM')"), $MYFormat)
            // ->where('UserZone',auth()->user()->zone)
            // ->get();
            $data = NULL;
            return view('backend.content-result.view-monthly', compact('Fdate1', 'Tdate1', 'data', 'pay_status', 'monthformat', 'yearformat', 'branch', 'page'));
        } elseif ($request->page == 'track-follow-up') {  //view บันทึกข้อมูลลูกหนี้
            $Fdate1 = @$request->start;
            $Tdate1 = @$request->end;

            $start = date_create($Fdate1);
            $newfdate = ($Fdate1 != NULL) ? date_format($start, "Y-m-d") : NULL;
            $end = date_create($Tdate1);
            $newtdate = ($Tdate1 != NULL) ? date_format($end, "Y-m-d") : NULL;

            $Tracklist = TB_TRLIST::generateTrackcode();
            return view('backend.content-track.view-content', compact('Fdate1', 'Tdate1', 'Tracklist', 'page'));
        } elseif ($request->page == 'terminate-letter') {
            $Fdate1 = @$request->start;
            $Tdate1 = @$request->end;

            $start = date_create($Fdate1);
            $newfdate = ($Fdate1 != NULL) ? date_format($start, "Y-m-d") : NULL;
            $end = date_create($Tdate1);
            $newtdate = ($Tdate1 != NULL) ? date_format($end, "Y-m-d") : NULL;

            return view('backend.content-temp.section-terminate.view', compact('Fdate1', 'Tdate1', 'page'));

        } elseif ($request->page == 'view-seized') {
            return view('backend.content-temp.section-seized.view-seized', compact('page'));
        } elseif ($request->page == 'veh-confiscation') {
            return view('backend.content-temp.section-confiscation.view', compact('page'));
        } elseif ($request->page == 'bad-debt') {
            $Fdate1 = @$request->start;
            $Tdate1 = @$request->end;

            $start = date_create($Fdate1);
            $newfdate = ($Fdate1 != NULL) ? date_format($start, "Y-m-d") : NULL;
            $end = date_create($Tdate1);
            $newtdate = ($Tdate1 != NULL) ? date_format($end, "Y-m-d") : NULL;

            $cacheKey = 'testView';
            Cache::forget($cacheKey);

            return view('backend.content-temp.section-badDebt.view', compact('Fdate1', 'Tdate1', 'page'));
        } elseif ($request->page == 'printlet') { //พิมพ์จดหมายลูกหนี้
            $Fdate1 = @$request->start;
            $Tdate1 = @$request->end;

            $start = date_create($Fdate1);
            $newfdate = ($Fdate1 != NULL) ? date_format($start, "Y-m-d") : NULL;
            $end = date_create($Tdate1);
            $newtdate = ($Tdate1 != NULL) ? date_format($end, "Y-m-d") : NULL;

            $GCODE = TB_GROUPKANGDUE::where('FLAG', 'Y')->get();

            return view('backend.content-printlet.view-let', compact('Fdate1', 'Tdate1', 'GCODE', 'page'));
        } elseif ($request->page == 'renew-contract') {
            $Fdate1 = @$request->start;
            $Tdate1 = @$request->end;

            $start = date_create($Fdate1);
            $newfdate = ($Fdate1 != NULL) ? date_format($start, "Y-m-d") : NULL;
            $end = date_create($Tdate1);
            $newtdate = ($Tdate1 != NULL) ? date_format($end, "Y-m-d") : NULL;
            return view('backend.content-temp.section-recontract.view-recontract', compact('Fdate1', 'Tdate1', 'page'));
        } elseif ($request->page == 'billing-stmt') { // billing-statement
            if (!empty($request->ajax) and $request->ajax == true) {
                if (!empty($request->data['ID_LOCAT'])) {
                    $locat = $request->data['ID_LOCAT'];
                } else {
                    $locat = null;
                }
                $zone = \Auth::user()->zone;
                if (!empty($request->data['DueDT_start'])) {
                    $due_start = convertDateHumanToPHP($request->data['DueDT_start']);
                } else {
                    $due_start = null;
                }
                if (!empty($request->data['DueDT_end'])) {
                    $due_end = convertDateHumanToPHP($request->data['DueDT_end']);
                } else {
                    $due_end = null;
                }
                if (!empty($request->data['CONTNO'])) {
                    $contno = "%" . $request->data['CONTNO'] . "%";
                } else {
                    $contno = null;
                }
                //---------------------------------------------------------------
                $data = DB::table('View_InvoiceDetail')->whereBetween('DUEDATE', [$due_start, $due_end])
                    ->when(!empty($locat), function ($q) use ($locat) {
                        return $q->where('LOCAT', $locat);
                    })
                    ->where('Company_Zone', 'like', $zone)
                    ->when(!empty($contno), function ($q) use ($contno) {
                        return $q->where('CONTNO', 'like', $contno);
                    })
                    ->orderBy('CONTNO')
                    ->get();

                $returnHTML = view('backend.content-temp.section-billingstmt.view-table-billingStmt', compact('data'))->render();
                return response()->json([
                    'message' => 'ค้นหาสำเร็จ',
                    'html' => $returnHTML,
                    'data_size' => count($data),
                ]);
            }
            $hideSearchTopbar = true;
            return view('backend.content-temp.section-billingstmt.view-billingStmt', compact('hideSearchTopbar', 'page'));
        } elseif ($request->page == 'invoice-normal') { //ออกใบกำกับค่างวดปกติ
            $Fdate1 = @$request->start;
            $Tdate1 = @$request->end;

            $start = date_create($Fdate1);
            $newfdate = ($Fdate1 != NULL) ? date_format($start, "Y-m-d") : NULL;
            $end = date_create($Tdate1);
            $newtdate = ($Tdate1 != NULL) ? date_format($end, "Y-m-d") : NULL;

            $CODENUM = DB::select("SELECT TAXDT,COUNT(TAXDT) as NUM FROM PatchHP_Taxtran WHERE TAXDT = (SELECT MAX(CAST(TAXDT AS DATE)) FROM PatchHP_Taxtran WHERE TAXTYP = 'D' AND UserZone = '" . auth()->user()->zone . "') GROUP BY TAXDT");

            return view('backend.content-tax.view-invoice-normal', compact('Fdate1', 'Tdate1', 'CODENUM', 'page'));
        } elseif ($request->page == 'invoice-before') { //ออกใบกำกับค่างวดก่อนดิว
            $Fdate1 = @$request->start;
            $Tdate1 = @$request->end;

            $start = date_create($Fdate1);
            $newfdate = ($Fdate1 != NULL) ? date_format($start, "Y-m-d") : NULL;
            $end = date_create($Tdate1);
            $newtdate = ($Tdate1 != NULL) ? date_format($end, "Y-m-d") : NULL;

            $CODENUM = DB::select("SELECT INPDT,COUNT(INPDT) as NUM FROM PatchHP_Taxtran WHERE INPDT = (SELECT MAX(CAST(INPDT AS DATE)) FROM PatchHP_Taxtran WHERE TAXTYP = 'B' AND UserZone = '" . auth()->user()->zone . "') GROUP BY INPDT");

            return view('backend.content-tax.view-invoice-before', compact('Fdate1', 'Tdate1', 'CODENUM', 'page'));
        } elseif ($request->page == 'summarize-vats') {
            return view('backend.content-temp.section-summarize.view-stopvat', compact('page'));
        } elseif ($request->page == 'stopcont-vats') {
            return view('backend.content-temp.section-stopvat.view', compact('page'));
        } elseif ($request->page == 'savePrintlet') {
            return view('backend.content-printlet.save-printlet.view-save', compact('page'));
        } elseif ($request->page == 'take-document') {
            $dataTypeTake = TYPE_TAKE_DOC::all();
            return view('backend.content-take-doc.take-document.view', compact('dataTypeTake', 'page'));
        } elseif ($request->page == 'process-document') {
            return view('backend.content-take-doc.take-document.view', compact('page'));
        } elseif ($request->page == 'list-take-document') {
            return view('backend.content-take-doc.list-take-document.view', compact('page'));
        }
    }

    public function store(Request $request)
    {
        $userRoles = auth()->user()->getRoleNames()->toArray();

        // กำหนด Role ที่อนุญาตให้เข้าใช้งาน
        $userArr = ['superadmin', 'administrator'];

        // ตรวจสอบว่า Role ของผู้ใช้ตรงกับ Role ที่อนุญาตหรือไม่
        $chkRole = count(array_intersect($userArr, $userRoles)) > 0;

        $user_zone = auth()->user()->zone;
        $Fdate1 = @$request->start;
        $Tdate1 = @$request->end;
        $page = $request->page;
        $id = $request->id;

        $start = date_create($Fdate1);
        $newfdate = ($Fdate1 != NULL) ? date_format($start, "Y-m-d") : NULL;
        $end = date_create($Tdate1);
        $newtdate = ($Tdate1 != NULL) ? date_format($end, "Y-m-d") : NULL;

        $dataBranch2 = TB_Branchs::where('id', $request->id)->first();

        if ($request->page == 'create-cont') {
            // $data = static::query($user_zone,$newfdate,$newtdate,$id)->get();
            $data = Pact_Contracts::leftJoin('Data_Customers', function ($join) {
                $join->on('Pact_Contracts.DataCus_id', '=', 'Data_Customers.id');
            })
                ->when(!$chkRole, function ($q) {
                    return $q->whereNull('Flag_Inside');
                })

                ->leftJoin('TB_TypeLoans', function ($join) {
                    $join->on('TB_TypeLoans.Loan_Code', '=', 'Pact_Contracts.CodeLoan_Con');
                })
                ->selectRaw("Pact_Contracts.Flag_Inside, Pact_Contracts.id, Pact_Contracts.Contract_Con, Pact_Contracts.CodeLoan_Con, Pact_Contracts.BranchSent_Con, TB_TypeLoans.Loan_Name, Pact_Contracts.Date_monetary,Pact_Contracts.DateDue_Con, Data_Customers.Name_Cus")
                ->where('Pact_Contracts.UserZone', $user_zone)
                ->where('Pact_Contracts.Date_monetary', '<>', NULL)
                //->where(DB::raw(" FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"), '>', '2024-03-31')
                ->when(!empty($id), function ($q) use ($id) {
                    return $q->where('Pact_Contracts.BranchSent_Con', $id);
                })
                ->when(!empty($newfdate) && !empty($newtdate), function ($q) use ($newfdate, $newtdate) {
                    return $q->whereBetween(DB::raw("cast(Pact_Contracts.Date_monetary as date)"), [$newfdate, $newtdate]);
                })
                ->get();

            $returnHTML = view('backend.content-view.section-contract.data-contract', compact('data', 'newfdate', 'newtdate', 'dataBranch2'))->render();
            return response()->json(['html' => $returnHTML]);
        } elseif ($request->page == 'imp-payslist') {
            // call view
            dd($request);
        }
    }

    public function create(Request $request)
    {
        if ($request->type == 1) {
            $newfdate = @$request->newfdate;
            $newtdate = @$request->newtdate;
            $loanCode = ['08', '09', '10', '18', '16'];
            $data = Pact_Contracts::where('id', $request->id)->first();
            if ($data->ContractToTypeLoan->Loan_Com == 1) {
                $Config = TB_CONFPSL::generateQuery();
                $periodNonVat = @$data->ContractToCal->Period_Rate;
                $processcar = @$data->ContractToCal->StatusProcess_Car == 'yes' ? @$data->ContractToCal->Process_Car : 0;
                $conpa = (@$data->ContractToCal->Buy_PA == 'yes' && @$data->ContractToCal->Include_PA == 'yes') ? @$data->ContractToCal->Insurance_PA : 0;
                $totalRate = floatval(@$data->ContractToCal->Cash_Car) + floatval($processcar) + floatval($conpa);

                if (in_array($data->CodeLoan_Con, $loanCode)) {
                    $irrYear = number_format(((@$data->ContractToCal->Profit_Rate / @$totalRate) * 100) / 12, 6);
                } else {
                    $irrYear = number_format(uft_Calculate_IRR(intval(@$data->ContractToCal->Timelack_Car), -floatval(@$periodNonVat), ($totalRate)), 6);
                    // dd($irrYear,intval(@$data->ContractToCal->Timelack_Car), -floatval(@$periodNonVat), ($totalRate));
                }

            } else {
                $Config = TB_CONFHP::generateQuery();
                $periodNonVat = @$data->ContractToCal->Duerate_Rate;
                $processcar = @$data->ContractToCal->StatusProcess_Car == 'yes' ? @$data->ContractToCal->Process_Car : 0;
                $conpa = (@$data->ContractToCal->Buy_PA == 'yes' && @$data->ContractToCal->Include_PA == 'yes') ? @$data->ContractToCal->Insurance_PA : 0;

                $totalRate = floatval(@$data->ContractToCal->Cash_Car) + floatval($processcar) + floatval($conpa);
                $irrYear = number_format(uft_Calculate_IRR(intval(@$data->ContractToCal->Timelack_Car), -floatval(@$periodNonVat), ($totalRate)), 6);
                // $irrYear = 0.08307;
            }

            // $testIRR = uft_Calculate_IRR(intval(@$data->ContractToDataCusTags->DataCusTagToDataCulcu->Timelack_Car),-floatval($periodNonVat),(@$data->ContractToDataCusTags->DataCusTagToDataCulcu->Cash_Car + @$data->ContractToDataCusTags->DataCusTagToDataCulcu->Process_Car));
            // dd(intval(@$data->ContractToDataCusTags->DataCusTagToDataCulcu->Timelack_Car),-floatval(@$periodNonVat),(@$data->ContractToDataCusTags->DataCusTagToDataCulcu->Cash_Car + @$data->ContractToDataCusTags->DataCusTagToDataCulcu->Process_Car),$testIRR,$periodNonVat);
            $type = $request->type;
            return view('backend.content-view.section-contract.create-contracts', compact('data', 'type', 'Config', 'periodNonVat', 'irrYear', 'newfdate', 'newtdate'));
        }
    }
}
