<?php

namespace App\Http\Controllers\frontend;

use App\Events\AuditsEventions;
use App\Events\frontend\checklistEvents;

use App\Events\frontend\MsTeamsEvent;
use App\Models\TB_Constants\TB_Frontend\TB_StatusAudits;
use App\Models\User;
use Microsoft\Graph\Model;
use ConnectMSTeams;
use DB;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_Constants\TB_Frontend\TB_TypeLoan;
use App\Models\TB_Constants\TB_Frontend\TB_ListCheckDocs;

use App\Models\TB_PactContracts\Pact_Contracts;
use App\Models\TB_PactContracts\Pact_AuditTags;
use App\Models\TB_PactContracts\Pact_AuditTagparts;
use App\Models\TB_PactContracts\Pact_AuditChecklists;

use App\Models\TB_PactContracts\Data_Checklists;
use App\Models\TB_PactContracts\Data_StatusContract;

class AuditController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user_zone = auth()->user()->zone;
        $dataBranch = TB_Branchs::generateQuery();
        $loanCode = $request->loanCode;
        $statusTxt = $request->statusTxt;
        $type = $request->type;
        $Fdate1 = @$request->start;
        $Tdate1 = @$request->end;
        $start = date_create($Fdate1);
        $Fdate = $Fdate1 != NULL ? date_format($start, "Y-m-d") : NULL;

        $end = date_create($Tdate1);
        $Tdate = $Tdate1 != NULL ? date_format($end, "Y-m-d") : NULL;
        $col = 10;
        //  if($request->type == 1){ // view รายการส่งเอกสาร
        //     $title = 'รายการส่งเอกสาร';
        //     $title_small = '(Send Contract)';
        //     $sidebarMain ='adBranch-active';
        //     $sidebarSec = 'sent-active';

        //     $countStatus = Pact_Contracts::where('UserZone',$user_zone)
        //         ->where('Status_Con','complete')
        //         ->when(empty($Fdate1), function ($q) use ($Fdate1,$user_zone) {
        //             return $q->whereNotIn('id',function($query) use ($user_zone) {
        //                         $query->select('PactCon_id')
        //                         ->from('Data_StatusContract')->where('UserZone',$user_zone);
        //             });
        //         })
        //         ->when(!empty($Fdate1)  && !empty($Tdate1), function ($q) use ($Fdate, $Tdate) {
        //             return $q->whereBetween('Date_con', [$Fdate, $Tdate]);
        //         })
        //         ->select('UserBranch', DB::raw('count(*) as total'))->groupBY('UserBranch')->get();

        //     $countDataBranch = array();
        //     foreach ($countStatus as $key => $value) {
        //         $countDataBranch[$value->UserBranch] =  $value->total;
        //     }
        //     return view('frontend.content-audit.view-audit',compact('title','title_small','sidebarMain','sidebarSec','col','dataBranch','countDataBranch','type','Fdate1','Tdate1','statusTxt'));
        //  }
        //  elseif($request->type == 2 || $request->type == 4 ){ // view รายการเอกสารรอรับเข้า    รายการรับเอกสารเข้า

        //     $sidebarMain ='adBranch-active';
        //     if($request->type == 2){
        //         $title = 'รายการเอกสารรอรับเข้า';
        //         $title_small = '(Waiting Recive Contract)';
        //         $sidebarSec = 'waiting-active';
        //     }else{
        //         $title = 'รายการรับเอกสารเข้า';
        //         $title_small = '(Recive Contract)';
        //         $sidebarSec = 'recive-active';
        //     }

        //     $countStatus = Data_StatusContract::where('UserZone',$user_zone)
        //         ->whereNotNull('Branch_Sentdoc')
        //         ->whereNull('Office_Received')
        //         ->select('UserBranch', DB::raw('count(*) as total'))->groupBY('UserBranch')->get();
        //         $countDataBranch = array();
        //         foreach ($countStatus as $key => $value) {
        //             $countDataBranch[$value->UserBranch] =  $value->total;
        //         }
        //         return view('frontend.content-audit.view-audit',compact('title','title_small','sidebarMain','sidebarSec','col','dataBranch','countDataBranch','type','Fdate1','Tdate1','statusTxt'));
        //  }
        //  elseif($request->type == 5 || $request->type == 3){ // view รายการตรวจสอบเอกสาร  รายการเอกสารไม่ครบ
        //     if($request->type == 5){
        //         $title = 'รายการตรวจสอบเอกสาร';
        //         $title_small = '(Audit Documents)';
        //         $sidebarMain ='audit-active';
        //         $sidebarSec = 'auditCheck-active';
        //     }else{
        //         $title = 'รายการเอกสารไม่ครบ';
        //         $title_small = '(Reject Documents)';
        //         $sidebarMain ='adBranch-active';
        //         $sidebarSec = 'reject-active';
        //     }

        //     $countStatus = Data_StatusContract::where('UserZone',$user_zone)
        //         ->whereNotNull('Branch_Sentdoc')
        //         ->whereNotNull('Office_Received')
        //         ->when(!empty($Fdate)  && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
        //             return $q->whereBetween('DateOffice_Received', [$Fdate, $Tdate]);
        //         })
        //         ->whereNotIn('id',function($query) use ($user_zone) {
        //             $query->select('PactCon_id')
        //             ->from('Data_StatusContract')->where('UserZone',$user_zone)->where('Flag_Status','เข้าเซฟ');
        //         })
        //         ->when($request->type == 3, function ($q)  {
        //             return $q->where('Flag_Status','Rejected');
        //         })

        //         ->select('UserBranch', DB::raw('count(*) as total'))->groupBY('UserBranch')->get();

        //     $countDataBranch = array();
        //     foreach ($countStatus as $key => $value) {
        //         $countDataBranch[$value->UserBranch] =  $value->total;
        //     }
        //     return view('frontend.content-audit.view-audit',compact('title','title_small','sidebarMain','sidebarSec','col','dataBranch','countDataBranch','type','Fdate1','Tdate1','statusTxt'));
        //  }elseif($request->type == 6){  // view data รายการเอกสารเข้าเซฟ
        //     $title = 'รายการเอกสารเข้าเซฟ';
        //     $title_small = '(Safe Contract)';
        //     $sidebarMain ='audit-active';
        //     $sidebarSec = 'safe-active';
        //     $col = 12;
        //         $data = Pact_Contracts::where('UserZone',$user_zone)
        //             ->where('Status_Con','complete')
        //             ->when(empty($Fdate),function($q) {
        //                 return $q->whereHas('ContractToStatusCon', function($query) {
        //                     $query->where('Flag_Status', 'สัญญาสมบูรณ์');
        //                  });
        //             })
        //             ->when(!empty($Fdate)  && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
        //                 return $q->whereBetween('Date_con', [$Fdate, $Tdate]);
        //             })
        //             ->get();
        //         return view('frontend.content-audit.view-audit',compact('title','title_small','sidebarMain','sidebarSec','col','dataBranch','type','Fdate1','Tdate1','statusTxt','data'));
        //  }
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->page == 'select-Contracts') {
            $branch = TB_Branchs::where('id', $request->branch)->first();
            $data = DB::table('View_ContractAuditEx1')
                ->where('UserZone', auth()->user()->zone)
                ->where(DB::raw("FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"), '>=', '2024-01-01')
                ->where('BranchSent_Con', $branch->id)
                ->whereNull('Flag_Status')
                ->whereNotNull('Date_monetary')
                ->orderBy('CodeLoan_Con')
                ->get();

            $nameBranch = $branch->Name_Branch;
            return view('frontend.content-audit.section-view.view-selectCont', compact('data', 'nameBranch'));
        } elseif ($request->page == 'Receive-Contracts' or $request->page == 'edited-Contracts') {
            if ($request->page == 'Receive-Contracts') {
                $Flag_Status = 1;
                $title = 'กล่องรับเอกสาร (Receive documents)';
                $redirectUrl = 'Branch-ReceiveConts';
            } else {
                $Flag_Status = 5;
                $title = 'เอกสารแก้ไขแล้ว (Edited documents)';
                $redirectUrl = 'Branch-EditedConts';
            }

            $Branchs = session()->get('dataBranch');
            $countData = DB::table('View_ContractAuditEx1')
                ->where('UserZone', auth()->user()->zone)
                ->where(DB::raw("FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"), '>=', '2024-01-01')
                ->where('Flag_Status', $Flag_Status)
                ->selectRaw('BranchSent_Con, count(*) as total')
                ->groupBy('BranchSent_Con')
                ->get()
                ->reduce(function ($result, $item) {
                    $result[$item->BranchSent_Con] = $item->total;
                    return $result;
                }, []);

            return view('frontend.content-audit.section-view.view-receiveCont', compact('Branchs', 'countData', 'redirectUrl', 'title'));
        } elseif ($request->page == 'Branch-ReceiveConts') {
            $data = DB::table('View_ContractAuditEx1')
                ->where('UserZone', auth()->user()->zone)
                ->where(DB::raw("FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"), '>=', '2024-01-01')
                ->where('BranchSent_Con', $request->branch)
                ->where('Flag_Status', 1)
                ->orderBy('createdTagpart', 'desc')
                ->get();

            $branch_id = $request->branch;
            $view_data = view('frontend.content-audit.section-data.data-branchReceive', compact('data', 'branch_id'))->render();
            return response()->json(['html' => $view_data], 200);
        } elseif ($request->page == 'Branch-EditedConts') {
            $data = DB::table('View_ContractAuditEx1')
                ->where('UserZone', auth()->user()->zone)
                ->where(DB::raw("FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"), '>=', '2024-01-01')
                ->where('BranchSent_Con', $request->branch)
                ->where('Flag_Status', 5)
                ->orderBy('createdTagpart', 'desc')
                ->get();

            $branch_id = $request->branch;
            $view_data = view('frontend.content-audit.section-data.data-branchEdited', compact('data', 'branch_id'))->render();
            return response()->json(['html' => $view_data], 200);
        } elseif ($request->page == 'import-lockers') {
            $branch = TB_Branchs::where('id', $request->branch)->first();
            $data = DB::table('View_ContractAuditEx1')
                ->where('UserZone', auth()->user()->zone)
                ->where('BranchSent_Con', $branch->id)
                ->where('Flag_Status', 6)
                ->whereNotNull('Date_monetary')
                ->orderBy('CodeLoan_Con')
                ->get();

            $nameBranch = $branch->Name_Branch;
            return view('frontend.content-audit.section-view.view-importLockers', compact('data', 'nameBranch'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $zone = auth()->user()->zone;
        $user_name = auth()->user()->email;
        $password = base64_decode(auth()->user()->password_teams);

        $msTeams = auth()->user()->UserToMSTeamsAudit;
        $teams_chanel = $msTeams->Teams_Chanel;
        $group_id = $msTeams->Group_Id;
        $type_team = $msTeams->Type_teams;
        $tokenUser = ConnectMSTeams::getTokenUser($user_name, $password);

        $post = false;
        if ($request->page == 'send-DocCont') {
            $data = DB::table('View_ContractAuditEx1')
                ->whereIn('id', $request->idcont)
                ->get();

            DB::beginTransaction();
            try {
                foreach ($data as $key => $item) {
                    $audit = new Pact_AuditTags;
                    $audit->PactCon_id = $item->id;
                    $audit->Flag_Status = 1; //นำส่งเอกสาร
                    $audit->date_send = Carbon::now();
                    $audit->userInt_send = auth()->user()->id;
                    $audit->Send_by = $request->Send_by;
                    $audit->ems_detail = $request->ems_detail;
                    $audit->message_send = $request->message;
                    $audit->UserZone = auth()->user()->zone;
                    $audit->UserBranch = auth()->user()->branch;
                    $audit->UserInsert = auth()->user()->id;
                    $audit->save();

                    $audit_part = new Pact_AuditTagparts;
                    $audit_part->PactCon_id = $item->id;
                    $audit_part->audit_id = $audit->id;
                    $audit_part->date_TrackPart = Carbon::now();
                    $audit_part->Status_TrackPart = 1; //นำส่งเอกสาร
                    $audit_part->Detail_TrackPart = $request->message;
                    $audit_part->UserZone = auth()->user()->zone;
                    $audit_part->UserBranch = auth()->user()->branch;
                    $audit_part->UserInsert = auth()->user()->id;
                    $audit_part->save();
                }
                DB::commit();

                $title = 'รายการสินเชื่อ ( Loan Informations )';
                $dataBranch2 = TB_Branchs::where('id', $request->id_branch)->first();

                $Fdate = ($request->fdate != null) ? date('Y-m-d', strtotime($request->fdate)) : null;
                $Tdate = ($request->tdate != null) ? date('Y-m-d', strtotime($request->tdate)) : null;
                $result = $this->queryDelevered($request->id_branch, $Fdate, $Tdate);

                $message = 'นำส่งเอกสาร เรียบร้อย';
                $data = $result['dataResult'];
                $countCont = $result['countCont'];
                $arrRole = ['administrator', 'superadmin', 'manager','audit'];
                $Position = auth()->user()->getRoleNames();
                $Approve = $Position->filter(function ($item) use ($arrRole) {
                    return in_array($item, $arrRole);
                });
                $Approve = count($Approve);
                $view_data = view('frontend.content-view.data-sendDocs', compact('data', 'countCont', 'title', 'dataBranch2','Approve'))->render();
                return response()->json(['html' => $view_data, 'data' => count($data), 'idBranch' => $request->id_branch, 'message' => $message], 200);
            } catch (\Exception $e) {
                DB::rollback();

                return response()->json(['message' => 'ดำเนินการไม่สำเร็จ กรุณาลองใหม่อีกครั้ง', 'details' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        } elseif ($request->page == 'received-document') {
            DB::beginTransaction();
            try {
                foreach ($request->auditCont as $key => $item) {
                    $audit = Pact_AuditTags::find($item);
                    $audit->Flag_Status = 2; //รับเอกสาร
                    $audit->date_received = Carbon::now();
                    $audit->userInt_received = auth()->user()->id;
                    $audit->update();

                    $audit_part = new Pact_AuditTagparts;
                    $audit_part->PactCon_id = $audit->PactCon_id;
                    $audit_part->audit_id = $audit->id;
                    $audit_part->date_TrackPart = Carbon::now();
                    $audit_part->Status_TrackPart = 2; //รับเอกสาร
                    $audit_part->Detail_TrackPart = 'เจ้าหน้าที่ตรวจสอบ ได้รับเอกสารแล้วครับ/ค่ะ';
                    $audit_part->UserZone = auth()->user()->zone;
                    $audit_part->UserBranch = auth()->user()->branch;
                    $audit_part->UserInsert = auth()->user()->id;
                    $audit_part->save();
                }
                DB::commit();
                return response()->json(['message' => 'ยืนยันการรับเอกสาร เรียบร้อย'], 200);
            } catch (\Exception $e) {
                DB::rollback();

                return response()->json(['message' => 'ดำเนินการไม่สำเร็จ กรุณาลองใหม่อีกครั้ง', 'details' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        } elseif ($request->page == 'send-message') {
            if ($request->Flag_Status != 3) {
                $Countaudit = Pact_AuditTagparts::where('audit_id', $request->audit_id)->count();
                if ($Countaudit != $request->count_tagpart) {
                    return response()->json(['message' => 'Reset Contents', 'audit_id' => $request->audit_id, 'count_tagpart' => count($Countaudit), 'code' => 205], 500);
                }
            }

            DB::beginTransaction();
            try {
                $audit_part = new Pact_AuditTagparts;
                $audit_part->PactCon_id = $request->Pact_id;
                $audit_part->audit_id = $request->audit_id;
                $audit_part->date_TrackPart = Carbon::now();
                if ($request->Flag_Status == 2) {
                    $audit_part->Status_TrackPart = 3;
                    $audit_part->Detail_TrackPart = 'เจ้าหน้าที่ตรวจสอบ เริ่มทำการตรวจสอบสัญญา';
                } else {
                    $audit_part->Status_TrackPart = $request->Flag_Status;
                    $audit_part->Detail_TrackPart = $request->Detail_TrackPart;
                }
                $audit_part->UserZone = auth()->user()->zone;
                $audit_part->UserBranch = auth()->user()->branch;
                $audit_part->UserInsert = auth()->user()->id;
                $audit_part->save();
                DB::commit();

                $audit = Pact_AuditTags::where('id', $request->audit_id)->first();
                if ($request->Flag_Status > 2 and !empty($request->radiosData)) {
                    event(new checklistEvents($request->Pact_id, $request->audit_id, $audit_part->id, $request->radiosData));

                    if ($request->Flag_Status == 4 || $request->Flag_Status == 5) {
                        // $roleNames = ['audit'];
                        // $auditUser = User::where('zone', $zone)
                        // ->whereHas('roles', function ($query) use ($roleNames) {
                        //     $query->whereIn('name', $roleNames);
                        // })->first();
                        $Domain = url('/');
                        $link_approve =  "<a href='" . $Domain . "/audit/" . $request->Pact_id . "/edit?page=auditCheckContent'>คลิ๊ก</a>";   
                        $user_branch =  $audit->auditTaguserInt->email;
                        $password_branch = base64_decode( $audit->auditTaguserInt->password_teams);
                        $nameTag =  $audit->auditTaguserInt->name;
                       // $tokenUserTag  = ConnectMSTeams::getTokenUser($user_branch, $password_branch);
                        
                        $statusAudit = TB_StatusAudits::where('id',$request->Flag_Status)->first();
                        // if($tokenUser != false && $tokenUserTag != false){
                        //     $dis_user = $tokenUser->createRequest('GET', '/me')
                        //                     ->setReturnType(Model\User::class)
                        //                     ->execute();
            
                                        //$ms_user = json_decode(json_encode($dis_user), true);
                                        // $dis_app = $tokenUserTag->createRequest('GET', '/me')
                                        //     ->setReturnType(Model\User::class)
                                        //     ->execute();
            
                                        //ข้อมูล tag
                                       // $ms_tag = json_decode(json_encode($dis_app), true);
            
                                        //รออนุมัติ
                                        //สร้างข้อความ และ แท็กผูอนุมัติ
                                        $dataArray = $statusAudit->name_th . '<br/> สัญญา ' . $link_approve .'<br/> รายการ'. (isset($request->radiosData['check-edit'])? implode(",", $request->radiosData['check-edit']) : null);
                                            // $dataArray = [
                                            //     "body" => [
                                            //         "contentType" => "html",
                                            //         "content" => "<at id='0'>" . $ms_tag['displayName'] . "</at> " . $statusAudit->name_th . '<br/> สัญญา ' . $link_approve .'<br/> รายการ'. (isset($request->radiosData['check-edit'])? implode(",", $request->radiosData['check-edit']) : null)
                                            //     ],
                                            //     "mentions" => [
                                            //         [
                                            //             "id" => 0,
                                            //             "mentionText" => $ms_tag['displayName'],
                                            //             "mentioned" => [
                                            //                 "user" => [
                                            //                     "displayName" => $ms_tag['displayName'],
                                            //                     "id" => $ms_tag['id'],
                                            //                     "userIdentityType" => "aadUser"
                                            //                 ]
                                            //             ]
                                            //         ]
                                            //     ]
                                            // ];
                                   if($audit->team_id == NULL){
                                        $eventPost = event(new MsTeamsEvent(@$request->audit_id,$user_name, $password,$user_branch, $password_branch,$nameTag, $group_id, $teams_chanel,'',$dataArray,'audit', 'post'));
                                   }else{
                                        $eventPost = event(new MsTeamsEvent(@$request->audit_id,$user_name, $password,$user_branch, $password_branch,$nameTag, $group_id, $teams_chanel,$audit->team_id,$dataArray,'audit', 'replies'));
                                   }
                                    
                        // }else{
                        //     return response(['error' => true , 'message' => 'ไม่สามารถเพิ่มข้อมูลได้ ! เนื่องจากสัญญามีการอนุมัติแล้ว'],500);
                        // }
                    }
                }
                $Flag_Status = $audit_part->Status_TrackPart;
                $view_status = view('frontend.content-audit.section-data.data-statusDoc', compact('audit'))->render();
                $view_massage = view('frontend.content-audit.section-data.data-chatContent', compact('audit'))->render();
                // event(new AuditsEventions($request->audit_id));

                return response()->json(['view_status' => $view_status, 'view_massage' => $view_massage, 'Flag_Status' => $Flag_Status, 'count_tagpart' => count($audit->auditTagToTagpart)], 200);
            } catch (\Exception $e) {
                DB::rollback();

                return response()->json(['message' => 'ดำเนินการไม่สำเร็จ กรุณาลองใหม่อีกครั้ง', 'details' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        } elseif ($request->page == 'import-lockers') {
            $data = DB::table('View_ContractAuditEx1')
                ->whereIn('id', $request->idcont)
                ->get();

            DB::beginTransaction();
            try {
                foreach ($data as $key => $item) {
                    $audit_part = new Pact_AuditTagparts;
                    $audit_part->PactCon_id = $item->id;
                    $audit_part->audit_id = $item->tag_id;
                    $audit_part->date_TrackPart = Carbon::now();
                    $audit_part->Status_TrackPart = 7; //จัดเก็บเอกสาร
                    $audit_part->Detail_TrackPart = $request->message;
                    $audit_part->UserZone = auth()->user()->zone;
                    $audit_part->UserBranch = auth()->user()->branch;
                    $audit_part->UserInsert = auth()->user()->id;
                    $audit_part->save();
                }
                DB::commit();

                $title = 'รายการสินเชื่อ ( Loan Informations )';
                $dataBranch2 = TB_Branchs::where('id', $request->id_branch)->first();

                $Fdate = ($request->fdate != null) ? date('Y-m-d', strtotime($request->fdate)) : null;
                $Tdate = ($request->tdate != null) ? date('Y-m-d', strtotime($request->tdate)) : null;
                $result = $this->queryCompleteDocs($request->id_branch, $Fdate, $Tdate);

                $message = 'จัดเก็บเอกสาร เรียบร้อย';
                $data = $result['dataResult'];

                $view_data = view('frontend.content-view.data-completeDocs', compact('data', 'title', 'dataBranch2'))->render();
                return response()->json(['html' => $view_data, 'data' => count($data), 'idBranch' => $request->id_branch, 'message' => $message], 200);
            } catch (\Exception $e) {
                DB::rollback();

                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if ($request->funs == 'refresh-content') {
            $audit = Pact_AuditTags::find($id);
            $filter = ($audit->auditTagToCont->ContractToTypeLoanLast->id_rateType == 'land' ? 'land' : 'car');
            $listDoc = TB_ListCheckDocs::querygeneral()->filter(function ($item) use ($filter) {
                return $item->typeLoan == $filter;
            });

            $Flag_Status = $audit->Flag_Status;

            $view_checklist = view('frontend.content-audit.section-data.data-listCheckCont', compact('audit', 'listDoc'))->render();
            $view_status = view('frontend.content-audit.section-data.data-statusDoc', compact('audit'))->render();
            $view_massage = view('frontend.content-audit.section-data.data-chatContent', compact('audit'))->render();

            return response()->json(['view_checklist' => $view_checklist, 'view_status' => $view_status, 'view_massage' => $view_massage, 'Flag_Status' => $Flag_Status, 'count_tagpart' => $audit->auditTagToTagpart->count()], 200);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        if ($request->page == 'auditCheckContent') {
            /*** set value search */
            $page_type = 'frontend';
            $page = $request->page;
            $pageUrl = false;
            $typeSreach = 'contract';
            $dataSreach = [
                'namecus' => true,
                'idcardcus' => true,
                'license' => true,
                'contract' => true,
            ];

            $data = Pact_Contracts::find($id);
            $audit = $data->ContToauditTags;

            $filter = ($data->ContractToTypeLoanLast->id_rateType == 'land' ? 'land' : 'car');
            $listDoc = TB_ListCheckDocs::querygeneral()->filter(function ($item) use ($filter) {
                return $item->typeLoan == $filter;
            });

            return view('frontend.content-audit.section-view.view-checkCont', compact('data', 'audit', 'listDoc', 'page_type', 'page', 'pageUrl', 'typeSreach', 'dataSreach'));
        } elseif ($request->page == 'chat-history') {
            $tagpart = Pact_AuditTagparts::where('id', $id)->first();

            $filter = ($tagpart->AuditTag->auditTagToCont->ContractToTypeLoanLast->id_rateType == 'land' ? 'land' : 'car');
            $listDoc = TB_ListCheckDocs::querygeneral()->filter(function ($item) use ($filter) {
                return $item->typeLoan == $filter;
            });

            return view('frontend.content-audit.section-view.view-chatHistory', compact('tagpart','listDoc'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->page == 'update-reject') {
            DB::beginTransaction();
            try {
                $data = Pact_Contracts::where('id',$id)->update([
                    "Flag_Reject" => NULL
                ]);
                DB::commit();
                return response()->json([ 'message' => 'success'], 200);
            } catch (\Exception $e) {
                DB::rollback();

                return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
            }
       }
       
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    private function queryDelevered($idBranch, $Fdate, $Tdate)
    {
        $dataResult = DB::table('View_ContractAuditEx1')
            ->where('UserZone', auth()->user()->zone)
            ->where('BranchSent_Con', $idBranch)
            ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                return $q->whereBetween('Date_monetary', [$Fdate, $Tdate]);
            })
            // ->where(DB::raw("FORMAT (cast(Date_monetary as date), 'yyyy-MM-dd')"),'>=','2024-01-01')
            ->whereNull('Flag_Status')
            ->whereNotNull('Date_monetary')
            ->orderBy('CodeLoan_Con')
            ->get();

        $countCont = DB::table('View_ContractAuditEx1')
            ->where('UserZone', auth()->user()->zone)
            ->where('BranchSent_Con', $idBranch)
            ->where('Flag_Status', 1)
            ->whereNotNull('Date_monetary')
            ->count();

        return array('dataResult' => $dataResult, 'countCont' => $countCont);
    }

    private function queryCompleteDocs($idBranch, $Fdate, $Tdate)
    {
        $dataResult = DB::table('View_ContractAuditEx1')
            ->where('UserZone', auth()->user()->zone)
            ->where('BranchSent_Con', $idBranch)
            ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                return $q->whereBetween('Date_monetary', [$Fdate, $Tdate]);
            })
            ->where('Flag_Status', 6)
            ->whereNotNull('Date_monetary')
            ->orderBy('CodeLoan_Con')
            ->get();

        return array('dataResult' => $dataResult);
    }
}