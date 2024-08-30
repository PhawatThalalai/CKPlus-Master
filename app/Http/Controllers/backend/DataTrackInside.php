<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Log;

use App\Models\TB_view\VWDEBT_RPSPASTDUE;
use App\Models\TB_view\View_PatchSPASTDUE;

use App\Models\TB_Constants\TB_Backend\TB_TRLIST;
use App\Models\TB_Constants\TB_Backend\TB_TRSTATUS;
use App\Models\TB_Constants\TB_Backend\TB_TRDELIVER;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchTB_SPASTDUE;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchHP\PatchHP_SPASTDUE_DETAIL;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchHP\PatchHP_SPASTDUE_AREA;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchPSL\PatchPSL_SPASTDUE_DETAIL;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchPSL\PatchPSL_SPASTDUE_AREA;

use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchHP\PatchHP_AROTHR;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchPSL\PatchPSL_AROTHR;

use App\Models\TB_PactContracts\Pact_Contracts;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_Contracts;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_Contracts;
use App\Models\TB_PatchContracts\TB_Payments\PatchHP\PatchHP_HDPAYMENT;
use App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_HDPAYMENT;

class DataTrackInside extends Controller
{

    public function index(Request $request) {
        //
    }

    public function create(Request $request) {   //select contract
        if($request->page == 'create-aroth') { //บันทึกลูกหนี้อื่น
            $pact = Pact_Contracts::where('id',$request->id)->first();
            if ($request->loanType == 1) {     //เงินกู้
                $contract = $pact->ContractToConPSL;
            }else{                                              //เช่าซื้อ
                $contract = $pact->ContractToConHP;
            }
            $BILLDT = date('Y-m-d');
            $Billno = $this->runBill($contract, $BILLDT,'AR');
            $loanType = $request->loanType;
            $Dcode = $request->Dcode;
            return view('backend.content-track.session-arother.modal-arother',compact('contract','loanType','Dcode','Billno'));
        }
        elseif($request->page == 'create-deposit') { //บันทึกรับฝากค่างวด
            $pact = Pact_Contracts::where('id',$request->id)->first();
            if ($request->loanType == 1) {     //เงินกู้
                $contract = $pact->ContractToConPSL;
            }else{                                              //เช่าซื้อ
                $contract = $pact->ContractToConHP;
            }
            $loanType = $request->loanType;
            $Dcode = $request->Dcode;
            return view('backend.content-track.session-deposit.modal-deposit',compact('contract','loanType','Dcode'));
        }
    }

    public function store(Request $request){
        if($request->page == "store-aroth"){    //บันทึกลูกหนี้อื่น
            $pact = Pact_Contracts::where('DataTag_id',$request->data['DataTag_id'])->first();
            if ($pact->ContractToTypeLoan->Loan_Com == 2) {     //เช่าซื้อ
                $contract = $pact->ContractToConHP;
            }else{                                                  //เงินกู้
                $contract = $pact->ContractToConPSL;
            }

            $BILLDT = date('Y-m-d');
            $Billno = $this->runBill($contract, $BILLDT,'AR');
            if($request->data['loanType'] == 2){
                DB::beginTransaction();
                try {
                    $Setdata = PatchHP_AROTHR::where('PatchCon_id',$request->data['DataPact_id'])->where('STATUS','Active')->latest()->first();
                    if($Setdata != NULL){
                        $Setdata->FLAG = 'N';
                        $Setdata->update();
                    }
                    $dataArother = new PatchHP_AROTHR([
                        'PatchCon_id' => $request->data['DataPact_id'],
                        'Spast_id' => $request->data['REF_SPASTDUE'],
                        'ARCONT' => $Billno,
                        'TSALE' => 'H',
                        'CONTNO' => $request->data['Contract'],
                        'LOCAT' => $request->data['locat'],
                        'PAYFOR' => $request->data['PayCode'],         //รหัสชำระ
                        'PAYAMT' => $request->data['AmountPaid'],
                        'VATRT' => $request->data['VATRT'],
                        'TAXNO' => NULL,
                        'NOPAY' => @$contract->ContractToSPASTDUE->LASTNOPAY,
                        'ARDATE' => $request->data['DateAdd'],
                        // 'SMPAY' => $request->data['MoneyPaid'],
                        'DISCOUNT' => $request->data['Discount'],
                        'BALANCE' => $request->data['AmountPaid'] - $request->data['Discount'],
                        'USERID' => auth()->user()->id,
                        'INPDT' => date('Y-m-d'),
                        'DDATE' => ($request->data['DateAppoint'] != NULL)?convertDateHumanToPHP($request->data['DateAppoint']):NULL,
                        'BILLCOLL' => $request->data['FollowCode'],
                        'MEMO' => $request->data['Note'],
                        'FLAG' => 'H',
                        'STATUS' => 'Active',
                        'UserZone' => $request->data['UserZone'],

                        ]);
                    $dataArother->save();
                    DB::commit();
                }catch (\Exception $e) {
                    DB::rollback();
                    Log::channel('daily')->error($e->getMessage());
                    // return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
                }
            }
            else{
                DB::beginTransaction();
                try {
                    $Setdata = PatchPSL_AROTHR::where('PatchCon_id',$request->data['DataPact_id'])->where('STATUS','Active')->latest()->first();
                    if($Setdata != NULL){
                        $Setdata->FLAG = 'N';
                        $Setdata->update();
                    }
                    $dataArother = new PatchPSL_AROTHR([
                        'PatchCon_id' => $request->data['DataPact_id'],
                        'Spast_id' => $request->data['REF_SPASTDUE'],
                        'ARCONT' => $Billno,
                        'TSALE' => 'H',
                        'CONTNO' => $request->data['Contract'],
                        'LOCAT' => $request->data['locat'],
                        'PAYFOR' => $request->data['PayCode'], //รหัสชำระ
                        'PAYAMT' => $request->data['AmountPaid'],
                        'VATRT' => $request->data['VATRT'],
                        'TAXNO' => NULL,
                        'NOPAY' => @$contract->ContractToSPASTDUE->LASTNOPAY,
                        'ARDATE' => $request->data['DateAdd'],
                        // 'SMPAY' => $request->data['MoneyPaid'],
                        'DISCOUNT' => $request->data['Discount'],
                        'BALANCE' => $request->data['AmountPaid'] - $request->data['Discount'],
                        'USERID' => auth()->user()->id,
                        'INPDT' => date('Y-m-d'),
                        'DDATE' => ($request->data['DateAppoint'] != NULL)?convertDateHumanToPHP($request->data['DateAppoint']):NULL,
                        'BILLCOLL' => $request->data['FollowCode'],
                        'MEMO' => $request->data['Note'],
                        'FLAG' => 'H',
                        'STATUS' => 'Active',
                        'UserZone' => $request->data['UserZone'],
                        ]);
                    $dataArother->save();
                    DB::commit();
                }catch (\Exception $e) {
                    DB::rollback();
                    Log::channel('daily')->error($e->getMessage());
                    // return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
                }
            }

            $loanType = $request->data['loanType'];
            $page = 'VIEW-AROTH';

            $message = auth()->user()->name." บันทึกลูกหนี้อื่น"."ไอดี:".$request->data['DataPact_id']." รหัสชำระ:".$request->data['PayCode']." จำนวนเงิน:".$request->data['AmountPaid'];
            Log::build([
                'driver' => 'daily',
                'path' => storage_path('logs/backend/arother/data_aroth.log'),
            ])->warning($message);

            return response()->view('backend.content-track.session-arother.view-arother', compact('contract','loanType','page'));

        }
        elseif($request->page == "store-deposit"){    //บันทึกรับฝากค่างวด
            $pact = Pact_Contracts::where('DataCus_id',$request->data['DataCus_id'])->first();
            // if ($pact->ContractToTypeLoan->Loantype_Con == 2) {     //เช่าซื้อ
            if ($pact->ContractToTypeLoan->Loan_Com == 2) {     //เช่าซื้อ
                $contract = $pact->ContractToConHP;
            }else{                                                  //เงินกู้
                $contract = $pact->ContractToConPSL;
            }

            if($request->data['loanType'] == 2){
                DB::beginTransaction();
                try {
                    $Setdata = PatchHP_HDPAYMENT::where('PatchCon_id',$request->data['DataPact_id'])->where('STATUS','Active')->latest()->first();
                    if($Setdata != NULL){
                        $Setdata->FLAG = 'N';
                        $Setdata->update();
                    }
                    $dataHD = new PatchHP_HDPAYMENT([
                        'PatchCon_id' => $request->data['DataPact_id'],
                        'LOCAT' => auth()->user()->branch,
                        'TEMPBILL' => $request->data['TEMPBILL'],
                        'TEMPDATE' => $request->data['DateAdd'],
                        'TFDATE' => convertDateHumanToPHP($request->data['DateAppoint']),
                        'CUSCODE' => $request->data['CUSCODE'],
                        'CONTNO' => $request->data['Contract'],
                        'TYPCODE' => $request->data['PayCode'], //รหัสชำระ
                        'USERECV' => auth()->user()->id,
                        'BILLCOLL' => $request->data['FollowCode'],
                        'TOTAMT' => $request->data['AmountPaid'],
                        'REMARK' => $request->data['Note'],
                        'BILLAMT' => $request->data['MoneyPaid'],
                        'USERID' => auth()->user()->id,
                        'INPDATE' => date('Y-m-d'),
                        'FLAG' => 'Y',
                        'STATUS' => 'Active',
                        ]);
                    $dataHD->save();
                    DB::commit();
                }catch (\Exception $e) {
                    DB::rollback();
                    Log::channel('daily')->error($e->getMessage());
                    // return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
                }
            }
            else{
                DB::beginTransaction();
                try {
                    $Setdata = PatchPSL_HDPAYMENT::where('PatchCon_id',$request->data['DataPact_id'])->where('STATUS','Active')->latest()->first();
                    if($Setdata != NULL){
                        $Setdata->FLAG = 'N';
                        $Setdata->update();
                    }
                    $dataHD = new PatchPSL_HDPAYMENT([
                        'PatchCon_id' => $request->data['DataPact_id'],
                        'LOCAT' => auth()->user()->branch,
                        'TEMPBILL' => $request->data['TEMPBILL'],
                        'TEMPDATE' => $request->data['DateAdd'],
                        'TFDATE' => convertDateHumanToPHP($request->data['DateAppoint']),
                        'CUSCODE' => $request->data['CUSCODE'],
                        'CONTNO' => $request->data['Contract'],
                        'TYPCODE' => $request->data['PayCode'], //รหัสชำระ
                        'USERECV' => auth()->user()->id,
                        'BILLCOLL' => $request->data['FollowCode'],
                        'TOTAMT' => $request->data['AmountPaid'],
                        'REMARK' => $request->data['Note'],
                        'BILLAMT' => $request->data['MoneyPaid'],
                        'USERID' => auth()->user()->id,
                        'INPDATE' => date('Y-m-d'),
                        'FLAG' => 'Y',
                        'STATUS' => 'Active',
                        ]);
                    $dataHD->save();
                    DB::commit();
                }catch (\Exception $e) {
                    DB::rollback();
                    Log::channel('daily')->error($e->getMessage());
                    // return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
                }
            }
            // $contract = session()->get('contract');
            $message = auth()->user()->name." บันทึกรับฝาก"."ไอดี:".$request->data['DataPact_id']." รหัสชำระ:".$request->data['PayCode']." จำนวนเงิน:".$request->data['AmountPaid'];
            Log::build([
                'driver' => 'daily',
                'path' => storage_path('logs/backend/hdpayment/data_hdpayment.log'),
            ])->warning($message);

            $loanType = $request->data['loanType'];
            return response()->view('backend.content-track.session-deposit.view-deposit', compact('contract','loanType'));

        }
        elseif($request->page == "store-track"){ //บันทึกติดตาม
            if($request->loanType == 2){
                DB::beginTransaction();
                try {
                    $Setdata = PatchHP_SPASTDUE_DETAIL::where('SPASTDUE_ID',$request->ID)->latest()->first();
                    if($Setdata != NULL){
                        $Setdata->FLAG = 'N';
                        $Setdata->update();
                    }
                    $dataDetail = new PatchHP_SPASTDUE_DETAIL;
                        $dataDetail->SPASTDUE_ID = $request->ID;
                        $dataDetail->DDATE = ($request->DDATE != NULL)?convertDateHumanToPHP($request->DDATE):NULL;
                        $dataDetail->CONTNO = $request->Contract;
                        $dataDetail->STATUS = $request->STATUS_TRACK;
                        $dataDetail->RESULT = $request->RESULT;
                        $dataDetail->SCORE = $request->RESULT_SCORE;
                        $dataDetail->NOTE = $request->NOTE;
                        $dataDetail->INPUTDT = $request->INPUTDT;
                        $dataDetail->MinPay = str_replace(",","",$request->MinPay);
                        $dataDetail->PAYDUE = $request->PAYDUE;
                        $dataDetail->USERID = auth()->user()->id;
                        $dataDetail->INPUT_MONTH = date('m');
                        $dataDetail->INPUT_YEAR = date('Y');
                        $dataDetail->FLAG = 'Y';
                    $dataDetail->save();

                    if($request->STATUS_TRACK == 'งานลงพื้นที่'){
                        $dataArea = new PatchHP_SPASTDUE_AREA;
                            $dataArea->SPASTDUE_ID = $request->ID;
                            $dataArea->DETAIL_ID = $dataDetail->id;
                            $dataArea->DATE_AREA = ($request->DDATE2 != NULL)?convertDateHumanToPHP($request->DDATE2):'';
                            $dataArea->PAY_AREA = ($request->PAY_AREA != NULL)?str_replace(",","",$request->PAY_AREA):0;
                            $dataArea->NOTE = $request->NoteArea;
                            $dataArea->STATUS_ASSET = $request->STATUS_ASSET;
                            $dataArea->STATUS_DEBT = $request->STATUS_DEBT;
                            $dataArea->LATLONG = $request->LATLONG;
                            $dataArea->LINK_IMAGE = @$request->LINK_IMAGE;
                            $dataArea->INPUTDT = date('Y-m-d');
                            $dataArea->USERID = auth()->user()->id;
                            $dataArea->FLAG = @$request->FLAG;
                            $dataArea->PLACE_AREA = @$request->PLACE_AREA;
                            $dataArea->FLAG_ASSET = @$request->FLAG_ASSET;
                            $dataArea->FLAG_DEBT = @$request->FLAG_DEBT;
                            $dataArea->STATUS_AROUND = @$request->STATUS_AROUND;
                            $dataArea->TIME_AREA = @$request->TIME_AREA;
                            $dataArea->MEMO = @$request->MEMO;
                            $dataArea->INPUT_MONTH = date('m');
                            $dataArea->INPUT_YEAR = date('Y');
                        $dataArea->save();

                        if(@$request->FLAG == 'Y'){
                            // dd('Auto');
                            $pact = Pact_Contracts::where('DataCus_id',$request->DataCus_id)->first();
                            if ($pact->ContractToTypeLoan->Loan_Com == 2) {     //เช่าซื้อ
                                $contract = $pact->ContractToConHP;
                            }else{                                              //เงินกู้
                                $contract = $pact->ContractToConPSL;
                            }
                            $BILLDT = date('Y-m-d');
                            $Billno = $this->runBill($contract, $BILLDT,'AR');
                            $Setdata = PatchHP_AROTHR::where('PatchCon_id',$request->ContractID)->where('STATUS','Active')->latest()->first();
                            // dd($BILLDT,$Billno,$Setdata);
                            if($Setdata != NULL){
                                $Setdata->FLAG = 'N';
                                $Setdata->update();
                            }
                            $dataArother = new PatchHP_AROTHR([
                                'PatchCon_id' => $request->ContractID,
                                'Spast_id' => $request->ID,
                                'ARCONT' => $Billno,
                                'TSALE' => 'H',
                                'CONTNO' => $request->Contract,
                                'LOCAT' => $request->locat,
                                'PAYFOR' => '507',         //รหัสชำระลงพื้นที่
                                'PAYAMT' => ($request->PAY_AREA != NULL)?str_replace(",","",$request->PAY_AREA):0,
                                'TAXNO' => NULL,
                                'NOPAY' => @$contract->ContractToSPASTDUE->LASTNOPAY,
                                'ARDATE' => date('Y-m-d'),
                                'BALANCE' => ($request->PAY_AREA != NULL)?str_replace(",","",$request->PAY_AREA):0,
                                'USERID' => auth()->user()->id,
                                'INPDT' => date('Y-m-d'),
                                'FLAG' => 'H',
                                'STATUS' => 'Active',
                                'UserZone' => $contract->UserZone,
                            ]);
                            $dataArother->save();
                        }
                    }

                    $data = PatchTB_SPASTDUE::where('id',$request->ID)->first();
                    $contract = PatchHP_Contracts::where('id',$request->ContractID)->first();
                    $pact = Pact_Contracts::where('Contract_Con',$contract->CONTNO)->first();

                    $message = auth()->user()->name." บันทึก ".$request->RESULT_SCORE."  รายละเอียด ".$request->NOTE;
                    Log::build([
                        'driver' => 'daily',
                        'path' => storage_path('logs/backend/tracking/data_track.log'),
                        ])->info($message);
                    DB::commit();

                }catch (\Exception $e) {
                    DB::rollback();
                    Log::channel('daily')->error($e->getMessage());
                    // return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
                }
            }
            else{
                DB::beginTransaction();
                try {
                    $Setdata = PatchPSL_SPASTDUE_DETAIL::where('SPASTDUE_ID',$request->ID)->latest()->first();
                    if($Setdata != NULL){
                        $Setdata->FLAG = 'N';
                        $Setdata->update();
                    }
                    $dataDetail = new PatchPSL_SPASTDUE_DETAIL;
                        $dataDetail->SPASTDUE_ID = $request->ID;
                        $dataDetail->DDATE = ($request->DDATE != NULL)?convertDateHumanToPHP($request->DDATE):NULL;
                        $dataDetail->CONTNO = $request->Contract;
                        $dataDetail->STATUS = $request->STATUS_TRACK;
                        $dataDetail->RESULT = $request->RESULT;
                        $dataDetail->SCORE = $request->RESULT_SCORE;
                        $dataDetail->NOTE = $request->NOTE;
                        $dataDetail->INPUTDT = $request->INPUTDT;
                        $dataDetail->MinPay = str_replace(",","",$request->MinPay);
                        $dataDetail->PAYDUE = $request->PAYDUE;
                        $dataDetail->USERID = auth()->user()->id;
                        $dataDetail->INPUT_MONTH = date('m');
                        $dataDetail->INPUT_YEAR = date('Y');
                        $dataDetail->FLAG = 'Y';
                    $dataDetail->save();

                    if($request->STATUS_TRACK == 'งานลงพื้นที่'){
                        $dataArea = new PatchPSL_SPASTDUE_AREA;
                            $dataArea->SPASTDUE_ID = $request->ID;
                            $dataArea->DETAIL_ID = $dataDetail->id;
                            $dataArea->DATE_AREA = ($request->DDATE2 != NULL)?convertDateHumanToPHP($request->DDATE2):'';
                            $dataArea->PAY_AREA = ($request->PAY_AREA != NULL)?str_replace(",","",$request->PAY_AREA):0;
                            $dataArea->NOTE = $request->NoteArea;
                            $dataArea->STATUS_ASSET = $request->STATUS_ASSET;
                            $dataArea->STATUS_DEBT = $request->STATUS_DEBT;
                            $dataArea->LATLONG = $request->LATLONG;
                            $dataArea->LINK_IMAGE = $request->LINK_IMAGE;
                            $dataArea->INPUTDT = date('Y-m-d');
                            $dataArea->USERID = auth()->user()->id;
                            $dataArea->FLAG = 'N';
                            $dataArea->PLACE_AREA = @$request->PLACE_AREA;
                            $dataArea->FLAG_ASSET = @$request->FLAG_ASSET;
                            $dataArea->FLAG_DEBT = @$request->FLAG_DEBT;
                            $dataArea->STATUS_AROUND = @$request->STATUS_AROUND;
                            $dataArea->TIME_AREA = @$request->TIME_AREA;
                            $dataArea->MEMO = @$request->MEMO;
                            $dataArea->INPUT_MONTH = date('m');
                            $dataArea->INPUT_YEAR = date('Y');
                        $dataArea->save();

                        // if(@$request->FLAG == 'Y'){
                        //     dd('Auto');
                        // }
                    }

                    $data = PatchTB_SPASTDUE::where('id',$request->ID)->first();
                    $contract = PatchPSL_Contracts::where('id',$request->ContractID)->first();
                    $pact = Pact_Contracts::where('Contract_Con',$request->Contract)->first();


                    $message = auth()->user()->name." บันทึก ".$request->RESULT_SCORE."  รายละเอียด ".$request->NOTE;
                    Log::build([
                        'driver' => 'daily',
                        'path' => storage_path('logs/backend/tracking/data_track.log'),
                        ])->info($message);
                    DB::commit();
                }catch (\Exception $e) {
                    DB::rollback();
                    Log::channel('daily')->error($e->getMessage());
                    // return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
                }
            }
            $user_session = auth()->user()->id;
            $ContractID = $request->ContractID;
            $loanType = $request->loanType;

            $message = auth()->user()->name." บันทึกงานติดตาม"."ไอดี:".$request->DataPact_id." ให้คะแนน:".$request->RESULT_SCORE." รายละเอียด:".$request->NOTE;
            Log::build([
                'driver' => 'daily',
                'path' => storage_path('logs/backend/tracking/data_track.log'),
            ])->warning($message);

            $DDATE = ($request->DDATE != NULL)?convertDateHumanToPHP($request->DDATE):NULL;
            if($DDATE < date('Y-m-d')){
                $text = '<p class="mb-1"><i class="bx bx-error text-danger bx-tada fs-4 error "></i>' .formatDateThai($DDATE).'</p><span class="badge rounded-pill badge-soft-warning font-size-11 text-dark">ผิดนัด 0</span>';
            }else{
                $text = '<p class="mb-1"><i class="btn btn-soft-warning btn-sm rounded-pill bx bx-calendar-event"></i>'.formatDateThai($DDATE).'</p><span class="badge rounded-pill badge-soft-warning font-size-11 text-dark">ผิดนัด 0</span>';
            }
            $html = view('backend.content-track.session-call.view-call', compact('pact','data','contract','loanType','user_session','ContractID'))->render();
            return response()->json(["html" => $html , "RESULT" => $request->RESULT , "CONTNO" => $request->Contract , "DDATE" => $text]);
        }
    }

    public function show(Request $request, $id) {   //select contract
    }

    public function edit(Request $request, $id) {   //select contract
        $page = $request->page;
        if($request->page == 'track-follow-up') {
            $pact = Pact_Contracts::selectRaw('id, DataCus_id, CodeLoan_Con, Contract_Con , Id_Com')
                ->where('id', $id)
                ->first();
            if ($pact->ContractToTypeLoan->Loan_Com == 1) { //เงินกู้
                $PatchCon_id = $pact->ContractToConPSL->id;
                $contract = PatchPSL_Contracts::where('DataPact_id', $pact->id)
                    // ->with('ContractCHQMaspay')
                    ->with([
                        'ContractPaydue' => function ($query) use ($PatchCon_id) {
                            $query->whereNotNull('date1')
                                ->with([
                                    'PaydueToDuepay' => function ($query) use ($PatchCon_id) {
                                        $query->where('PatchCon_id', $PatchCon_id);
                                    }
                                ]);
                        }
                    ])
                    ->first();
            } else { //เช่าซื้อ
                $PatchCon_id = $pact->ContractToConHP->id;
                $contract = PatchHP_Contracts::where('DataPact_id', $pact->id)
                    // ->with('ContractCHQMaspay')
                    ->first();
            }

            $tab = $request->tab;
            $loanType = $pact->ContractToTypeLoan->Loan_Com;
            $pact_id = $pact->id;
            return view('backend.content-track.view-content',compact('pact','contract','tab','loanType', 'page', 'pact_id'));
        }
        elseif($request->page == 'edit-track'){
            $data = View_PatchSPASTDUE::where('spast_id',$id)->first();
            $loanType = $request->loanType;
            $DataCus = $request->DataCus;
            $ContractID = $request->ContractID;
            $EXP = $request->EXP;

            $pact = Pact_Contracts::where('Contract_Con',$request->Contno)->first();
            if ($request->loanType == 1) {     //เงินกู้
                $contract = $pact->ContractToConPSL;
            }else{                                              //เช่าซื้อ
                $contract = $pact->ContractToConHP;
            }
            $BILLDT = date('Y-m-d');
            $Billno = $this->runBill($contract, $BILLDT,'AR');
            $TrackStatus = TB_TRSTATUS::generateTrackcode();
            $Tracklist = TB_TRLIST::generateTrackcode();

            @$count_not = @$contract->ContractToSPASTDUE->ToSPASTDETAIL()->whereIn('RESULT',['โทรไม่ติด','ไม่รับสาย'])->count();

            switch ( auth()->user()->zone ) {
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
                    if ( auth()->user()->branch == 56 ) { // ชุมพร
                        $lat = 10.317454;
                        $lng = 99.0841286;
                    } else {
                        $lat = 9.138239;
                        $lng = 99.321748;
                    }
                    break;
            }
            return view('backend.content-track.session-call.edit-call', compact('pact','data','loanType','DataCus','ContractID','contract','Billno','Tracklist','TrackStatus','EXP','lat','lng','count_not'));
        }
        elseif($request->page == 'view-track'){
            $loanType = $request->loanType;
            $page = $request->page;
            $pact = Pact_Contracts::where('Contract_Con',$request->Contno)->first();
            if ($request->loanType == 1) {     //เงินกู้
                $contract = $pact->ContractToConPSL;
                $data = PatchPSL_SPASTDUE_DETAIL::where('SPASTDUE_ID',$id)->orderBy('id','desc')->get();
                $dataALL = PatchPSL_SPASTDUE_DETAIL::select('INPUT_MONTH', 'INPUT_YEAR')
                        ->where('CONTNO', $request->Contno)
                        ->groupBy('INPUT_MONTH', 'INPUT_YEAR')
                        ->orderBy('INPUT_MONTH', 'desc')
                        ->get();
            }else{                                              //เช่าซื้อ
                $contract = $pact->ContractToConHP;
                $data = PatchHP_SPASTDUE_DETAIL::where('SPASTDUE_ID',$id)->orderBy('id','desc')->get();
                $dataALL = PatchHP_SPASTDUE_DETAIL::select('INPUT_MONTH', 'INPUT_YEAR')
                        ->where('CONTNO', $request->Contno)
                        ->groupBy('INPUT_MONTH', 'INPUT_YEAR')
                        ->orderBy('INPUT_MONTH', 'desc')
                        ->get();
            }
            $EXP = $request->EXP;

            return view('backend.content-track.session-call.history-call', compact('data','loanType','page','contract','EXP','dataALL'));
        }
        elseif($request->page == 'view-invoice'){
            $loanType = $request->loanType;
            $page = $request->page;
            $pact = Pact_Contracts::where('Contract_Con',$request->Contno)->first();
            if ($request->loanType == 1) {     //เงินกู้
                $contract = $pact->ContractToConPSL;

            }else{                                              //เช่าซื้อ
                $contract = $pact->ContractToConHP;
            }
            // check รายการใบแจ้งหนี้ ล่าสุด
            $FLAGINV = @$contract->ContractToInvoiceOne->DATENOPAY >= date('Y-m-d') && @$contract->ContractToInvoiceOne->STATUSPAY == NULL;
            $runBill = $this->runBillINVOICE($contract, date('Y-m-d'));
            // dd($contract,$FLAGINV,$runBill);

            return view('backend.content-track.session-call.invoice-debt', compact('contract', 'runBill', 'FLAGINV'));
        }
        elseif($request->page == 'edit-tracklist'){
            if($request->loanType == 2){
                $data = PatchHP_SPASTDUE_DETAIL::where('id',$request->id)->first();
            }
            else{
                $data = PatchPSL_SPASTDUE_DETAIL::where('id',$request->id)->first();
            }
            return response()->json([
                'data' => $data,
                'dataSmart' => NULL,
                'dataCqtran' => NULL,
            ]);
        }
        elseif($request->page == 'edit-aroth'){
            if($request->loantype == 1){
                $data = PatchPSL_AROTHR::where('id',$id)->first();
            }
            elseif($request->loantype == 2){
                $data = PatchHP_AROTHR::where('id',$id)->first();
            }
            return view('backend.content-track.session-arother.edit-arother',compact('data'));
        }
        elseif($request->page == 'deliver-track'){
            if($request->loanType == 1){
                $data = PatchPSL_Contracts::where('CONTNO',$request->Contno)->first();
            }
            elseif($request->loanType == 2){
                $data = PatchHP_Contracts::where('CONTNO',$request->Contno)->first();
            }
            $TrackDeliver = TB_TRDELIVER::generateCode();
            $loanType = $request->loanType;
            return view('backend.content-track.session-call.modal-call',compact('data','loanType','TrackDeliver'));
        }

    }

    public function update(Request $request, $id){
        if($request->page == 'update-spastdetail'){
            if($request->loanType == 2){
                DB::beginTransaction();
                try {
                    $dataDetail = PatchHP_SPASTDUE_DETAIL::where('id',$request->id)->first();
                        $dataDetail->DDATE = $request->DDATE1;
                        $dataDetail->RESULT = $request->RESULT1;
                        $dataDetail->PAYDEUE = $request->MustPay1;
                        $dataDetail->NOTE = $request->NOTE1;
                    $dataDetail->update();
                    DB::commit();

                    $data = PatchTB_SPASTDUE::where('id',$dataDetail->SPASTDUE_ID)->first();
                    $contract = PatchHP_Contracts::where('id',$request->ContractID)->first();

                }catch (\Exception $e) {
                    DB::rollback();
                    Log::channel('daily')->error($e->getMessage());
                    // return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
                }
            }
            else{
                DB::beginTransaction();
                try {
                    $dataDetail = PatchPSL_SPASTDUE_DETAIL::where('id',$request->id)->first();
                        $dataDetail->DDATE = $request->DDATE1;
                        $dataDetail->RESULT = $request->RESULT1;
                        $dataDetail->PAYDUE = $request->MustPay1;
                        $dataDetail->NOTE = $request->NOTE1;
                    $dataDetail->update();
                    $data = PatchTB_SPASTDUE::where('id',$dataDetail->SPASTDUE_ID)->first();
                    $contract = PatchPSL_Contracts::where('id',$request->ContractID)->first();
                    DB::commit();
                }catch (\Exception $e) {
                    DB::rollback();
                    Log::channel('daily')->error($e->getMessage());
                    // return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
                }
            }
            $user_session = auth()->user()->id;
            $ContractID = $request->ContractID;
            $loanType = $request->loanType;
            return response()->view('backend.content-track.session-call.view-call', compact('data','contract','user_session','ContractID','loanType'));
        }
        elseif($request->page == 'update-aroth'){
            // dd($request);
            if($request->data['loanType'] == '01'){
                DB::beginTransaction();
                try {
                    $dataAroth = PatchHP_AROTHR::where('id',$request->data['id'])->first();
                        $dataAroth->PAYFOR = $request->data['PayCode'];
                        $dataAroth->BILLCOLL = $request->data['FollowCode'];
                        $dataAroth->PAYAMT = $request->data['AmountPaid'];
                        $dataAroth->DISCOUNT = $request->data['Discount'];
                        $dataAroth->BALANCE = $request->data['AmountPaid'] - $request->data['Discount'];
                        $dataAroth->MEMO = $request->data['Note'];
                    $dataAroth->update();
                    DB::commit();
                }catch (\Exception $e) {
                    DB::rollback();
                    Log::channel('daily')->error($e->getMessage());
                    // return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
                }
            }
            else{
                DB::beginTransaction();
                try {
                    $dataAroth = PatchPSL_AROTHR::where('id',$request->data['id'])->first();
                        $dataAroth->PAYFOR = $request->data['PayCode'];
                        $dataAroth->BILLCOLL = $request->data['FollowCode'];
                        $dataAroth->PAYAMT = $request->data['AmountPaid'];
                        $dataAroth->DISCOUNT = $request->data['Discount'];
                        $dataAroth->BALANCE = $request->data['AmountPaid'] - $request->data['Discount'];
                        $dataAroth->MEMO = $request->data['Note'];
                    $dataAroth->update();
                    DB::commit();
                }catch (\Exception $e) {
                    DB::rollback();
                    Log::channel('daily')->error($e->getMessage());
                    // return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
                }
            }

            $pact = Pact_Contracts::where('Contract_Con',$request->data['Contract'])->first();
            // if ($pact->ContractToTypeLoan->Loantype_Con == 2) {     //เช่าซื้อ
            if ($pact->ContractToTypeLoan->Loan_Com == 2) {     //เช่าซื้อ
                $contract = $pact->ContractToConHP;
            }else{                                                  //เงินกู้
                $contract = $pact->ContractToConPSL;
            }

            $loanType = $request->data['loanType'];
            $page = 'VIEW-AROTH';
            return response()->view('backend.content-track.session-arother.view-arother', compact('contract','loanType','page'));
        }
        elseif($request->page == "refresh-track"){
            // $data = PatchTB_SPASTDUE::where('id',$request->ID)->first();
            // $contract = PatchHP_Contracts::where('id',$request->ContractID)->first();
            // $pact = Pact_Contracts::where('Contract_Con',$contract->CONTNO)->first();

            $pact = Pact_Contracts::where('Contract_Con',$request->CONTNO)->first();
            if ($pact->ContractToTypeLoan->Loan_Com == 2) {     //เช่าซื้อ
                $contract = $pact->ContractToConHP;
            }else{                                                  //เงินกู้
                $contract = $pact->ContractToConPSL;
            }
            $data = null;
            $user_session = auth()->user()->id;
            $ContractID = $request->ContractID;
            $loanType = $request->loanType;
            return response()->view('backend.content-track.session-call.view-call', compact('data','contract','user_session','ContractID','loanType'));
        }
        elseif($request->page == "deliver-track"){
            $data = PatchTB_SPASTDUE::where('id',$request->spast_id)->first();
            if($data != NULL){
                DB::beginTransaction();
                try {
                    $data->ASSIGN = $request->ASSIGN;
                    $data->MEMO = $request->MEMO;
                    $data->update();
                    DB::commit();
                }catch (\Exception $e) {
                    DB::rollback();
                    Log::channel('daily')->error($e->getMessage());
                    return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
                }
            }
            if($request->loanType == 2){
                $contract = PatchHP_Contracts::where('CONTNO',$request->contno)->first();
            }
            else{
                $contract = PatchPSL_Contracts::where('CONTNO',$request->contno)->first();
            }
            $loanType = $request->loanType;
            return response()->view('backend.content-track.session-call.view-call', compact('data','contract','loanType'));
        }
    }

    public function destroy(Request $request, $id){
        if ($request->page == 'del-aroth') {          // ยกเลิกใบเสร็จ Aroth
            if($request->loan == 2){
                DB::beginTransaction();
                try {
                    $dataArother = PatchHP_AROTHR::where('id',$id)->first();
                    $dataArother->STATUS = 'Cancel';
                    $dataArother->USERDEL = auth()->user()->id;
                    $dataArother->update();

                    $Arother = PatchHP_AROTHR::where('PatchCon_id',$request->pact_id)->where('STATUS','Active')->latest()->first();
                    if($Arother != NULL){
                        $Arother->FLAG = 'Y';
                        $Arother->update();
                    }
                    DB::commit();
                }catch (\Exception $e) {
                    DB::rollback();
                    Log::channel('daily')->error($e->getMessage());
                    // return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
                }

            }
            else{
                DB::beginTransaction();
                try {
                    $dataArother = PatchPSL_AROTHR::where('id',$id)->first();
                        $dataArother->STATUS = 'Cancel';
                        $dataArother->USERDEL = auth()->user()->id;
                    $dataArother->update();

                    $Arother = PatchPSL_AROTHR::where('PatchCon_id',$request->pact_id)->where('STATUS','Active')->latest()->first();
                    if($Arother != NULL){
                        $Arother->FLAG = 'Y';
                        $Arother->update();
                    }
                    DB::commit();
                }catch (\Exception $e) {
                    DB::rollback();
                    Log::channel('daily')->error($e->getMessage());
                    // return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
                }
            }

            $pact = Pact_Contracts::where('DataCus_id',$request->cusid)->first();
            // if ($pact->ContractToTypeLoan->Loantype_Con == 2) {     //เช่าซื้อ
            if ($pact->ContractToTypeLoan->Loan_Com == 2) {     //เช่าซื้อ
                $contract = $pact->ContractToConHP;
            }else{                                                  //เงินกู้
                $contract = $pact->ContractToConPSL;
            }
            $loanType = $request->loanType;

            return response()->view('backend.content-track.session-arother.view-arother', compact('contract','loanType'));
        }
        elseif ($request->page == 'del-deposit') {          // ยกเลิกใบเสร็จ รับฝากค่างวด
            if($request->loan == 2){
                DB::beginTransaction();
                try {
                    $dataArother = PatchHP_HDPAYMENT::where('id',$id)->first();
                    $dataArother->STATUS = 'Cancel';
                    $dataArother->USERDEL = auth()->user()->id;
                    $dataArother->update();

                    $Arother = PatchHP_HDPAYMENT::where('PatchCon_id',$request->pact_id)->where('STATUS','Active')->latest()->first();
                    if($Arother != NULL){
                        $Arother->FLAG = 'Y';
                        $Arother->update();
                    }
                    DB::commit();
                }catch (\Exception $e) {
                    DB::rollback();
                    Log::channel('daily')->error($e->getMessage());
                    // return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
                }

            }
            else{
                DB::beginTransaction();
                try {
                    $dataArother = PatchPSL_HDPAYMENT::where('id',$id)->first();
                        $dataArother->STATUS = 'Cancel';
                        $dataArother->USERDEL = auth()->user()->id;
                    $dataArother->update();

                    $Arother = PatchPSL_HDPAYMENT::where('PatchCon_id',$request->pact_id)->where('STATUS','Active')->latest()->first();
                    if($Arother != NULL){
                        $Arother->FLAG = 'Y';
                        $Arother->update();
                    }
                    DB::commit();
                }catch (\Exception $e) {
                    DB::rollback();
                    Log::channel('daily')->error($e->getMessage());
                    // return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    return response()->json(['message' => $e->getMessage(), 'code' => 'เกิดข้อผิดพลาด'], 500);
                }
            }

            $pact = Pact_Contracts::where('DataCus_id',$request->cusid)->first();
            // if ($pact->ContractToTypeLoan->Loantype_Con == 2) {     //เช่าซื้อ
            if ($pact->ContractToTypeLoan->Loan_Com == 2) {     //เช่าซื้อ
                $contract = $pact->ContractToConHP;
            }else{                                                  //เงินกู้
                $contract = $pact->ContractToConPSL;
            }
            $loanType = $request->loan;

            return response()->view('backend.content-track.session-deposit.view-deposit', compact('contract','loanType'));
        }

    }

    private function runBill($contract, $BILLDT, $tx_header){
        if (@$contract->CODLOAN == 1) {
            @$dataBill = DB::select("SELECT dbo.uft_runbillArPsl(?,?,?,?,?)", [intval($contract->TYPECON), intval($contract->UserZone), intval($contract->LOCAT), $BILLDT, $tx_header]);
        } else {
            @$dataBill = DB::select("SELECT dbo.uft_runbillArHp(?,?,?,?,?)", [intval($contract->TYPECON), intval($contract->UserZone), intval($contract->LOCAT), $BILLDT, $tx_header]);
        }
        @$txtbill = json_decode(json_encode(@$dataBill), true);
        @$Billno = @$txtbill[0][''];

        return @$Billno;
    }

    private function runBillINVOICE($contract, $BILLDT){
        $locatpay = auth()->user()->UserToBranch->id_Contract;
        $dataBill = DB::select("SELECT dbo.uft_runbillInv(?,?,?,?,?)", [($contract->TYPECON), $contract->UserZone, $contract->LOCAT, $BILLDT, 'INV-']);
        $Billno = json_decode(json_encode($dataBill), true)[0][''];

        return $Billno;
    }
}
