<?php

namespace App\Http\Controllers\frontend;

use App\Models\TB_Configs\Config_Approves;
use App\Models\TB_Constants\TB_Frontend\TB_AlertTeams;
use App\Models\TB_Constants\TB_Frontend\TB_ListCheckDocs;
use App\Models\TB_Constants\TB_Frontend\TB_RelationPA;
use App\Models\TB_Constants\TB_Frontend\TB_SpecialTypeApp;
use App\Models\TB_Constants\TB_Frontend\TB_StatusApprove;
use ConnectCredo;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Controllers\Controller;
use Microsoft\Graph\Graph;
use Microsoft\Graph\Model;
use ConnectMSTeams;
use Log;
use DB;
use App\Models\User;

// trait
use App\Traits\UserApproved;
use App\Traits\UserCheckRole;

use App\Models\TB_Assets\Data_Assets;
use App\Models\TB_Assets\Data_AssetsOwnership;
// Model
use App\Events\frontend\LogDataContract;
use App\Events\frontend\MsTeamsEvent;

use App\Models\TB_PactContracts\Pact_Contracts;
use App\Models\TB_PactContracts\Data_Checklists;

use App\Models\TB_DataCus\Data_Customers;

use App\Models\TB_Constants\TB_Frontend\TB_TypeLoan;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_Constants\TB_Frontend\TB_TypeLoanCom;
use App\Models\TB_Constants\TB_Frontend\TB_TypePurposeCode;
use App\Models\TB_Constants\TB_Frontend\TB_Commission;
use App\Models\TB_Constants\TB_Frontend\TB_StatusCon;
use App\Models\TB_Constants\TB_Frontend\TB_TypeSecurities;
use App\Models\TB_Constants\TB_Frontend\TB_RelationsCus;

use App\Models\TB_PactContracts\Pact_ContractsGuarantor;
use App\Models\TB_PactContracts\Pact_ContractsGuar_Assets;
use App\Models\TB_PactContracts\Pact_Operatedfees;
use App\Models\TB_PactContracts\Pact_Checklists;
use App\Models\TB_PactContracts\Pact_Indentures_Assets;
use App\Models\TB_PactContracts\Pact_ContractBrokers;
use App\Models\TB_PactContracts\Pact_ContractPayee;


// log
use App\Models\TB_Logs\Log_ContractsAudit;
use App\Models\TB_Logs\Log_ContractsBuyer;
use App\Models\TB_Logs\Log_ContractsCon;
use App\Models\TB_Logs\Log_ContractsOperate;

class ConController extends Controller
{
    use UserApproved, UserCheckRole;
    public function index(Request $request)
    {
        $user_zone = auth()->user()->zone;
        $loanCode = $request->loanCode;
        $dateSearch = $request->dateSearch;
        $statusTxt = $request->statusTxt;

        $dateSplit = explode(" - ", $dateSearch);
        $newfdate = ($dateSearch != NULL) ? date('Y-m-d', strtotime($dateSplit[0])) : '';
        $newtdate = ($dateSearch != NULL) ? date('Y-m-d', strtotime($dateSplit[1])) : '';

        $dataBranch = TB_Branchs::generateQuery();
        $loanTb = TB_TypeLoan::where('Loan_Code', $loanCode)->first();

        if ($request->dateSearch == NULL) {
            $data = Pact_Contracts::where('CodeLoan_Con', $loanCode)
                ->where('UserZone', $user_zone)
                ->where('Status_Con', 'active')
                ->get();
        } else {
            $data = Pact_Contracts::where('CodeLoan_Con', $loanCode)
                ->where('UserZone', $user_zone)
                ->when(!empty($newfdate) && !empty($newtdate), function ($q) use ($newfdate, $newtdate) {
                    return $q->whereBetween(DB::raw(" FORMAT (cast(Date_con as date), 'yyyy-MM-dd')"), [$newfdate, $newtdate]);
                })
                ->when(!empty($statusTxt), function ($q) use ($statusTxt) {
                    return $q->where('Status_Con', $statusTxt);
                })
                ->get();
        }

        return view('frontend.content-con.view', compact('data', 'dataBranch', 'loanTb', 'loanCode', 'statusTxt', 'dateSearch'));
    }

    public function create(Request $request)
    {
        if ($request->type == 'EditExpenses') { //
            // $data = Pact_Operatedfees::where('PactCon_id', $request->id)->first();
            $data = Pact_Contracts::where('id', $request->id)->first();
            $arrStatus = ['CUS-0004', 'CUS-0005', 'CUS-0006', 'CUS-0009'];
            $Process_Car = 0;
            $Insurance_PA = 0;
            $Total_Price = 0;

            $totalFees = 0;

            $balance = floatval(@$data->ContractToCal->Cash_Car);
            $totalFees = @$data->ContractToOperated->Total_Price == NULL ? 0 : floatval(@$data->ContractToOperated->Total_Price);

            if (@$data->ContractToCal->StatusProcess_Car == "no") {
                $totalFees = ($totalFees - floatval(@$data->ContractToCal->Process_Price)) + floatval(@$data->ContractToCal->Process_Car);
                $Process_Car = floatval(@$data->ContractToCal->Process_Car);
            } else {
                $Process_Car = 0;
            }
            if ((strtoupper(@$data->ContractToCal->Buy_PA) == "YES" && strtoupper(@$data->ContractToCal->Include_PA) == "NO")) {

                $totalFees = ($totalFees - floatval(@$data->ContractToOperated->Insurance_PA)) + floatval(@$data->ContractToCal->Insurance_PA);
                $Insurance_PA = floatval(@$data->ContractToCal->Insurance_PA);

            } else {
                $totalFees = ($totalFees - floatval(@$data->ContractToOperated->Insurance_PA));
                $Insurance_PA = 0;
            }
            $Balance_Price = floatval(@$data->ContractToCal->Cash_Car) - floatval($totalFees);
            $Total_Price = $totalFees;

            $statusClose = in_array(@$data->ContractToDataCusTags->Type_Customer, $arrStatus);

            return view('frontend.content-con.section-expenses.create-expens', compact('data', 'Insurance_PA', 'Total_Price', 'Balance_Price', 'Process_Car', 'statusClose'));
        }
    }

    public function store(Request $request)
    {
        $dataPact = Pact_Contracts::where('id', $request->PactCon_id)->first();
        $roleNum = $this->checkRoleEditLoans($dataPact->CodeLoan_Con, $dataPact->Status_Con);
        $arrStatus = ['active'];
        //dd($roleNum ,$dataPact->CodeLoan_Con,$dataPact->Status_Con,auth()->user()->getRoleNames());
        if (in_array($dataPact->Status_Con, $arrStatus) || $roleNum > 0) {
            if ($request->func == 'addBroker') {
                $datacheck = Pact_ContractBrokers::select('PactCon_id', 'Broker_id')->where('PactCon_id', $request->PactCon_id)->where('Broker_id', $request->idCus)->first();
                $DataInTrash = Pact_ContractBrokers::onlyTrashed()->where('PactCon_id', $request->PactCon_id)->where('Broker_id', $request->idCus)->first(); // ค้นหาข้อมูลที่เคยลบ
                if ($datacheck == NULL) {
                    if ($DataInTrash == NULL) { // ถ้าไม่มีข้อมูลที่เคยลบจะทำการ insert ข้อมูลใหม่
                        DB::beginTransaction();
                        try {
                            $dataBRK = new Pact_ContractBrokers;
                            $dataBRK->PactCon_id = $request->PactCon_id;
                            $dataBRK->Broker_id = $request->idCus;
                            $dataBRK->UserZone = auth()->user()->zone;
                            $dataBRK->UserInsert = auth()->user()->id;
                            $dataBRK->UserBranch = auth()->user()->branch;
                            $dataBRK->save();
                            DB::commit();
                            Log::channel('daily')->info($dataBRK);
                            $eventLog = event(new LogDataContract(@$request->PactCon_id, 'insert', 'LogBrokerContract', 'create-broker', 'เพิ่ม Broker ID:' . $dataBRK->id, auth()->user()->id));

                        } catch (\Exception $e) {
                            Log::channel('daily')->warning($e->getMessage());
                            DB::rollBack();
                        }

                    } else { // ถ้ามีข้อมูลที่เคยลบจะกู้คืนข้อมูลเดิม

                        // เคลียร์ข้อมูลค่าคอมก่อนกู้คืน
                        $DataInTrash->TypeCom = NULL;
                        $DataInTrash->Commission_Broker = NULL;
                        $DataInTrash->Commission_Broker_Prices = NULL;
                        $DataInTrash->SumCom_Broker = NULL;
                        $DataInTrash->update();

                        // กู้คืนข้อมูล
                        $DataInTrash->restore();
                        $eventLog = event(new LogDataContract(@$request->PactCon_id, 'restore', 'LogBrokerContract', 'create-broker', 'กู้คืน Broker ID:' . $DataInTrash->id, auth()->user()->id));

                    }
                    $tab = 'section-Broker';
                    $com = TB_Commission::where('status', 'active')->get();
                    $data = Pact_ContractBrokers::where('PactCon_id', $request->PactCon_id)->get();
                    $returnHTML = view('frontend.content-con.section-broker.view-Broker', compact('data', 'com'))->render();
                    $data = Pact_Contracts::where('id', $request->PactCon_id)->first();
                    $renderTab = view('frontend.content-con.view-tab', compact('data', 'tab'))->render();


                    return response()->json(['html' => $returnHTML, 'renderTab' => $renderTab]);
                } else {
                    return response(['error' => true, 'message' => 'มีข้อมูลผู้แนะนำในสัญญานี้แล้ว !'], 500);
                }

            } elseif ($request->func == 'addGuaran') {
                // dd($request->idAsset);
                $datacheck = Pact_ContractsGuarantor::where('PactCon_id', $request->PactCon_id)->where('Guarantor_id', @$request->Guarantor_id)->first();
                if ($datacheck == NULL) {
                    DB::beginTransaction();
                    try {
                        $data = new Pact_ContractsGuarantor;
                        $data->PactCon_id = $request->PactCon_id;
                        $data->DataTag_id = $request->DataTag_id;
                        $data->Guarantor_id = $request->Guarantor_id;
                        $data->TypeRelation_Cus = $request->RelationsCus;
                        $data->TypeSecurities_Guar = $request->Securities;
                        $data->GuaranAdds1_id = $request->GuaranAdds1_id;
                        $data->UserZone = auth()->user()->zone;
                        $data->UserInsert = auth()->user()->id;
                        $data->UserBranch = auth()->user()->branch;
                        $data->save();

                        if ($request->idAsset != NULL) { // ถ้าไม่มีข้อมูลจะทำการ insert ข้อมูลเข้าไปใหม่

                            foreach ($request->idAsset as $item) {
                                $DataInTrash = Pact_ContractsGuar_Assets::onlyTrashed()->where('Guarantor_id', @$request->Guarantor_id)->where('PactCon_id', $request->PactCon_id)->where('GuarAsset_id', $item)->first();
                                if ($DataInTrash == NULL) { // เช็คข้อมูลที่เคยลบว่ามีข้อมูลอยู่หรือไม่
                                    $dataasst = new Pact_ContractsGuar_Assets;
                                    $dataasst->DataTag_id = $request->DataTag_id;
                                    $dataasst->PactCon_id = $request->PactCon_id;
                                    $dataasst->Guarantor_id = $request->Guarantor_id;
                                    $dataasst->GuarAsset_id = $item;
                                    $dataasst->UserZone = auth()->user()->zone;
                                    $dataasst->UserBranch = auth()->user()->branch;
                                    $dataasst->UserInsert = auth()->user()->id;
                                    $dataasst->save();
                                } else { // ถ้ามีข้อมูลอยู่ให้เรียกข้อมูลเก่าขึ้นมาแทน
                                    $DataInTrash->restore();
                                    $eventLog = event(new LogDataContract(@$request->PactCon_id, 'insert', 'LogGuaranContract', 'Restore-Guarantor', 'เพิ่ม ผู้ค้ำ ID:' . $data->id, auth()->user()->id));

                                }
                            }
                        }


                        // dd($dataasst);
                        DB::commit();
                        $eventLog = event(new LogDataContract(@$request->PactCon_id, 'insert', 'LogGuaranContract', 'create-Guarantor', 'เพิ่ม ผู้ค้ำ ID:' . $data->id, auth()->user()->id));
                        $tab = 'section-guarantor';
                        $data = Pact_ContractsGuarantor::where('PactCon_id', $request->PactCon_id)->get();
                        $returnHTML = view('frontend.content-con.section-guaran.view-guaran', compact('data'))->render();
                        $data = Pact_Contracts::where('id', $request->PactCon_id)->first();
                        $renderTab = view('frontend.content-con.view-tab', compact('data', 'tab'))->render();
                        return response()->json(['html' => $returnHTML, 'renderTab' => $renderTab]);
                    } catch (\Exception $e) {
                        DB::rollBack();
                        return response(['error' => true, 'message' => 'ไม่สามารถเพิ่มผู้ค้ำได้ !'], 500);

                    }
                } else {
                    return response(['error' => true, 'message' => 'มีผู้ค้ำคนนี้ในสัญญาแล้ว !'], 500);
                }
            } elseif ($request->func == 'addPayee') {
                $datacheck = Pact_ContractPayee::where('PactCon_id', $request->PactCon_id)->where('Payee_id', $request->idCus)->first(); // เช็คผู้รับเงิน
                $statusPayCheck = Pact_ContractPayee::where('PactCon_id', $request->PactCon_id)->where('status_Payee', $request->status_Payee)->first(); // เช็คสถานะผู้รับเงิน
                $DataInTrash = Pact_ContractPayee::onlyTrashed()->where('PactCon_id', $request->PactCon_id)->where('Payee_id', $request->idCus)->where('status_Payee', $request->status_Payee)->first(); // ค้นหาข้อมูลที่เคยลบ
                if ($statusPayCheck == NULL) {
                    if ($datacheck == NULL) {
                        if ($DataInTrash == NULL) {
                            DB::beginTransaction();
                            try {
                                $data = new Pact_ContractPayee;
                                $data->PactCon_id = $request->PactCon_id;
                                $data->Payee_id = $request->idCus;
                                $data->status_Payee = $request->status_Payee;
                                $data->UserZone = auth()->user()->zone;
                                $data->UserInsert = auth()->user()->id;
                                $data->UserBranch = auth()->user()->branch;
                                $data->save();
                                DB::commit();
                                $eventLog = event(new LogDataContract(@$request->PactCon_id, 'insert', 'LogPayeeContract', 'create-Payee', 'เพิ่ม ผู้รับเงิน ID:' . $data->Payee_id, auth()->user()->id));

                            } catch (\Exception $e) {
                                DB::rollBack();
                            }
                        } else {
                            $DataInTrash->restore();
                            $eventLog = event(new LogDataContract(@$request->PactCon_id, 'restore', 'LogPayeeContract', 'restore-Payee', 'เพิ่ม ผู้รับเงิน ID:' . $DataInTrash->Payee_id, auth()->user()->id));

                        }
                        $tab = 'section-Payee';
                        $dataPay = Pact_ContractPayee::where('PactCon_id', $request->PactCon_id)->get();
                        $data = Pact_Contracts::where('id', $request->PactCon_id)->first();
                        $returnHTML = view('frontend.content-con.section-payee.view-payee', compact('dataPay'))->render();
                        $renderTab = view('frontend.content-con.view-tab', compact('data', 'tab'))->render();
                        return response()->json(['html' => $returnHTML, 'renderTab' => $renderTab]);

                    } else {
                        return response(['Payee' => 'fail', 'message' => 'มีผู้รับเงินคนนี้ในสัญญาแล้ว !']);
                    }
                } else {
                    return response(['StatusPayee' => 'fail', 'message' => 'ไม่สามารถเลือกผู้รับเงินที่มีสถานะเดียวกันได้ !']);
                }
            }
            if ($request->func == 'saveExpenses') {
                DB::beginTransaction();
                try {
                    $dataEXP = new Pact_Operatedfees;
                    $dataEXP->Customer_id = $request->Customer_id;
                    $dataEXP->DataTag_id = $request->DataTag_id;
                    $dataEXP->PactCon_id = $request->PactCon_id;
                    $this->saveExpenses($dataEXP, $request);

                    DB::commit();
                    $eventLog = event(new LogDataContract(@$request->PactCon_id, 'insert', 'LogExpensesContract', 'create-Expenses', 'เพิ่ม รายละเอียดการชำระเงิน ID:' . $dataEXP->id, auth()->user()->id));
                    $tab = 'section-expens';
                    $data = Pact_Operatedfees::where('PactCon_id', $request->PactCon_id)->first();
                    $html = view('frontend.content-con.section-expenses.view-expens', compact('data'))->render();
                    $data = Pact_Contracts::where('id', $request->PactCon_id)->first();
                    $renderTab = view('frontend.content-con.view-tab', compact('data', 'tab'))->render();
                    return response()->json(['html' => $html, 'renderTab' => $renderTab]);

                } catch (\Exception $e) {
                    DB::rollBack();
                }

            } elseif ($request->func == 'addAsset') {
                $datacheck = Pact_Indentures_Assets::where('PactCon_id', $request->PactCon_id)->where('Asset_id', $request->idasst)->first();
                $DataInTrash = Pact_Indentures_Assets::onlyTrashed()->where('PactCon_id', $request->PactCon_id)->where('Asset_id', $request->idasst)->first(); // ค้นหาข้อมูลที่เคยลบ
                if ($datacheck == NULL) {
                    if ($DataInTrash == NULL) {
                        DB::beginTransaction();
                        try {
                            $dataAsst = new Pact_Indentures_Assets;
                            $dataAsst->DataTag_id = $request->DataTag_id;
                            $dataAsst->PactCon_id = $request->PactCon_id;
                            $dataAsst->Asset_id = $request->idasst;
                            $dataAsst->UserZone = auth()->user()->zone;
                            $dataAsst->UserBranch = auth()->user()->branch;
                            $dataAsst->UserInsert = auth()->user()->id;
                            $dataAsst->save();

                            // Flag กลับไปอัพเดทสถานะการใช้งานทรัพย์
                            $Owner = Data_AssetsOwnership::where('id', $request->idasst)->first();
                            if ($Owner->State_Ownership == 'Transfer') {
                                if ($Owner->deleted_at == NULL) {
                                    $status = 'TransferProcess';
                                } else {
                                    $status = 'Transfer';
                                }
                            } else {
                                if ($Owner->deleted_at == NULL) {
                                    $status = 'Process';
                                } else {
                                    $status = 'Active';
                                }
                            }
                            $Owner->State_Ownership = $status;
                            $Owner->update();

                            DB::commit();
                            $eventLog = event(new LogDataContract(@$request->PactCon_id, 'insert', 'LogAssetsContract', 'create-Assets', 'เพิ่ม ทรัพย์ในสัญญา ID:' . $dataAsst->Asset_id, auth()->user()->id));


                        } catch (\Exception $e) {
                            DB::rollBack();
                        }
                    } else {
                        $DataInTrash->restore();
                        $eventLog = event(new LogDataContract(@$request->PactCon_id, 'restore', 'LogAssetsContract', 'restore-Assets', 'เพิ่ม ทรัพย์ในสัญญา ID:' . $DataInTrash->Asset_id, auth()->user()->id));

                        $Owner = Data_AssetsOwnership::where('id', $request->idasst)->first();
                        if ($Owner->State_Ownership == 'Transfer') {
                            if ($Owner->deleted_at == NULL) {
                                $status = 'TransferProcess';
                            } else {
                                $status = 'Transfer';
                            }
                        } else {
                            if ($Owner->deleted_at == NULL) {
                                $status = 'Process';
                            } else {
                                $status = 'Active';
                            }
                        }
                        $Owner->State_Ownership = $status;
                        $Owner->update();

                    }
                    $tab = 'section-asset';
                    $data = Pact_Indentures_Assets::where('PactCon_id', $request->PactCon_id)->get();
                    $returnHTML = view('frontend.content-con.section-asset.view-asset', compact('data'))->render();
                    $data = Pact_Contracts::where('id', $request->PactCon_id)->first();
                    $renderTab = view('frontend.content-con.view-tab', compact('data', 'tab'))->render();
                    return response()->json(['html' => $returnHTML, 'renderTab' => $renderTab]);
                } else {
                    return response(['error' => true, 'message' => 'มีทรัพย์นี้ในสัญญาแล้ว'], 500);
                }
            } elseif ($request->func == 'addDocument') {      //Add document

                // if($request->App_Outlet == null && auth()->user()->zone == 40){
                //     return response(['error' => true, 'message' => 'ข้อมูลไม่ครบ' ,"text" => 'กรุณากรอกเงื่อนไขการอนุมัติ'], 500);
                // }
                DB::beginTransaction();
                try {
                    $chkListChk = Pact_Checklists::where('PactCon_id', $request->PactCon_id)->first();
                    if ($chkListChk == NULL) {
                        $chkListChk = new Pact_Checklists;
                        $chkListChk->PactCon_id = $request->PactCon_id;
                        $txtLog = 'เพิ่ม การตรวจสอบเอกสาร';
                        $flafLog = 'insert';
                    } else {
                        $txtLog = 'อัพเดท การตรวจสอบเอกสาร';
                        $flafLog = 'update';

                    }

                    if ($chkListChk->PactChecktoCon->DateDocApp_Con != NULL) {
                        $chkListChk->UserAppCheck = @$request->textarr;
                    } else {
                        $chkListChk->UserBranchCheck = @$request->textarr;
                    }

                    $chkListChk->B1_Check_1 = @$request->B1_Check_1;
                    $chkListChk->B1_Check_2 = @$request->B1_Check_2;
                    $chkListChk->B1_Check_3 = @$request->B1_Check_3;
                    $chkListChk->B1_Check_4 = @$request->B1_Check_4;
                    $chkListChk->B1_Check_5 = @$request->B1_Check_5;
                    $chkListChk->B1_Check_6 = @$request->B1_Check_6;
                    $chkListChk->B1_Check_7 = @$request->B1_Check_7;
                    $chkListChk->B1_Check_8 = @$request->B1_Check_8;
                    $chkListChk->B1_Check_9 = @$request->B1_Check_9;
                    $chkListChk->B1_Check_10 = @$request->B1_Check_10;
                    $chkListChk->B1_Check_11 = @$request->B1_Check_11;
                    $chkListChk->B1_Check_12 = @$request->B1_Check_12;
                    $chkListChk->B1_Check_13 = @$request->B1_Check_13;
                    $chkListChk->B1_Check_14 = @$request->B1_Check_14;
                    $chkListChk->B1_Check_15 = @$request->B1_Check_15;
                    $chkListChk->B1_Check_16 = @$request->B1_Check_16;
                    $chkListChk->B1_Check_17 = @$request->B1_Check_17;
                    $chkListChk->B1_Check_18 = @$request->B1_Check_18;
                    $chkListChk->StatusApprove = @$request->StatusApprove;
                    $chkListChk->statusDoc = @$request->valCheck;
                    // $chkListChk->UserAppCheck = @$request->UserAppCheck;
                    // $chkListChk->UserBranchCheck = @$request->UserBranchCheck;
                    // $chkListChk->Correct = @$request->Correct;


                    $data = Pact_Contracts::where('id', $request->PactCon_id)->first();
                    $data->App_Outlet = @$request->App_Outlet;
                    $data->update();

                    $chkListChk->UserZone = auth()->user()->zone;
                    $chkListChk->UserInsert = auth()->user()->id;
                    $chkListChk->UserBranch = auth()->user()->branch;
                    $chkListChk->save();

                    if ($request->valCheck != NULL && $request->valCheck == "notPass") {

                        // อัพเดทสถานะเอกสาร
                        $chkListChk->StatusApprove = NULL;
                        $chkListChk->save();

                        $datatest = Pact_Contracts::where('id', $request->PactCon_id)->first();
                        $datatest->DocApp_Con = NULL;
                        $datatest->DateDocApp_Con = NULL;
                        $datatest->Status_Con = 'active';
                        $datatest->StatusApp_Con = 'สร้างสัญญา';
                        $datatest->save();

                        $data = Pact_Contracts::where('id', $request->PactCon_id)->first();

                        $subject = "เอกสารไม่ครบ";
                        $doclist = "";
                        $listNotNull = array(1, 2, 3, 4, 5, 6, 7, 8, 9);
                        $listerror = "";

                        foreach ($listNotNull as $list) {

                            $Clist = "B1_Check_" . $list;
                            if ($chkListChk->$Clist == NULL) {
                                $listerror .= $list . ",";
                            }
                        }

                        $doclist = $listerror;

                        $user_name = auth()->user()->email;
                        $password = base64_decode(auth()->user()->password_teams);

                        // $user_approve = $data->ContractToUserApprove->email;
                        // $password_approve = base64_decode($data->ContractToUserApprove->password_teams);

                        //user สาขา
                        $user_branch = $data->ContractToUserBranch->email;
                        $password_branch = base64_decode($data->ContractToUserBranch->password_teams);
                        $nameTag = $data->ContractToUserBranch->name;

                        $msTeams = auth()->user()->UserToMSTeams;
                        $teams_chanel = $msTeams->Teams_Chanel;
                        $group_id = $msTeams->Group_Id;
                        $type_team = $msTeams->Type_teams;
                        // $tokenUser = ConnectMSTeams::getTokenUser($user_name, $password);

                        // $tokenUserTag = ConnectMSTeams::getTokenUser($user_branch, $password_branch);

                        // $post = false;

                        // if ($tokenUser != false && $tokenUserTag != false) {

                        // $dis_user = $tokenUser->createRequest('GET', '/me')
                        //     ->setReturnType(Model\User::class)
                        //     ->execute();

                        //$ms_user = json_decode(json_encode($dis_user), true);

                        // $dis_app = $tokenUserTag->createRequest('GET', '/me')
                        //     ->setReturnType(Model\User::class)
                        //     ->execute();

                        //ข้อมูล tag
                        // $ms_tag = json_decode(json_encode($dis_app), true);

                        //รออนุมัติ

                        //สร้างข้อความ และ แท็กผูอนุมัติ
                        $dataArray = $subject . "<br/>" . 'รายการเอกสาร ' . $doclist;
                        // $dataArray = [
                        //     "body" => [
                        //         "contentType" => "html",
                        //         "content" => "<at id='0'>" . $ms_tag['displayName'] . "</at> " . $subject . "<br/>" . 'รายการเอกสาร ' . $doclist
                        //     ],
                        //     "mentions" => [
                        //             [
                        //                 "id" => 0,
                        //                 "mentionText" => $ms_tag['displayName'],
                        //                 "mentioned" => [
                        //                     "user" => [
                        //                         "displayName" => $ms_tag['displayName'],
                        //                         "id" => $ms_tag['id'],
                        //                         "userIdentityType" => "aadUser"
                        //                     ]
                        //                 ]
                        //             ]
                        //         ]
                        // ];

                        //สาขาสร้าง โพสขออนุมัติ

                        $eventPost = event(new MsTeamsEvent(@$data->id, $user_name, $password, $user_branch, $password_branch, $nameTag, $group_id, $teams_chanel, $data->Msteams_Id, $dataArray, $type_team, 'replies'));
                        // try{
                        //     $post_ms = $tokenUser->createRequest('POST', '/teams/'.$group_id.'/channels/'.$teams_chanel.'/messages/'.$data->Msteams_Id.'/replies')
                        //             ->attachBody($dataArray)
                        //             ->setReturnType(Model\User::class)
                        //             ->execute();
                        //             $post = true;


                        //         //     $data->DocApp_Con = NULL;
                        //         //     $data->DateDocApp_Con = NULL;
                        //         // $data->update();

                        // }catch (\Exception $e) {
                        //     $post = $e->getMessage();

                        // }

                        // } else {
                        //     $post = false;
                        //     DB::rollBack();
                        //     return response()->json(['FlagCon' => 'error', 'text' => 'กรุณาติดต่อ กับผู้ดูเเลระบบ โปรตรวจสอบ USER PASSWORD ', 'user' => '']);
                        // }

                        $txtLog = 'กำหนดสถานะเอกสารเป็น ไม่ผ่าน';
                        $flafLog = 'reject';


                    }

                    DB::commit();
                    $eventLog = event(new LogDataContract(@$chkListChk->id, $flafLog, 'LogDocumentsContract', 'Manage-Documents', $txtLog . ' ID:' . $chkListChk->id, auth()->user()->id));
                    $data = Pact_Contracts::where('id', $request->PactCon_id)->first();
                    // $arrRole = ['administrator', 'superadmin', 'supervisor', 'manager', 'finances'];
                    $arrRole = $this->checkRoleEditLoansList(@$data->Status_Con);
                    $Approve_Position = (@$data->UserApp_Con != NULL) ? @$data->ContractToUserApprove->getRoleNames() : '';
                    $Approve = $Approve_Position->filter(function ($item) use ($arrRole) {
                        return in_array($item, $arrRole);
                    });

                    $tab = 'section-contract';
                    $htmlheader = view('frontend.content-con.view-headerCon', compact('data', 'roleNum'))->render();
                    $html = view('frontend.content-con.section-approve.view-approve', compact('data', 'Approve'))->render();
                    $renderTab = view('frontend.content-con.view-tab', compact('data', 'tab'))->render();
                    return response()->json(['html' => $html, 'renderTab' => $renderTab, 'htmlheader' => $htmlheader]);

                } catch (\Exception $e) {
                    DB::rollBack();
                }
            }
        } else {
            if ($dataPact->Status_Con == 'pending') {
                $text = 'กรุณายกเลิกการขออนุมัติก่อนทำการ แก้ไขข้อมูล';
            } else {
                $text = '';
            }
            return response(['error' => true, 'message' => 'ไม่สามารถแก้ข้อมูลได้ ! ในขณะสัญญา "' . $dataPact->StatusApp_Con . '"', "text" => $text], 500);
        }
    }

    public function edit(Request $request, $id)
    {
        $type = $request->type;
        if ($request->funs == 'contract') {
            $data = Pact_Contracts::where('id', $id)->first();

            $com = TB_Commission::where('status', 'active')->get();
            $page_type = 'frontend';
            $page = 'contract';
            $pageUrl = 'contract';
            $typeSreach = 'contract';
            $dataSreach = [
                'namecus' => true,
                'idcardcus' => true,
                'license' => true,
                'contract' => true,
            ];

            $roleNum = $this->checkRoleEditLoans($data->CodeLoan_Con, $data->Status_Con);
            return view('frontend.content-con.view', compact('data', 'page_type', 'page', 'pageUrl', 'typeSreach', 'dataSreach', 'com', 'roleNum'));
        } elseif ($request->funs == 'EditCardCon') { // แก้ไขการ์ดหน้าสัญญา
            $data = Pact_Contracts::where('id', $id)->first();
            $dataPurpose = TB_TypePurposeCode::generateQuery();
            $StatusCon = TB_StatusCon::getStatusCon();
            $userApp = $this->getUsersByRoles(auth()->user()->zone, $data->DataTag_id);

            return view('frontend.content-con.Profile', compact('type', 'data', 'userApp', 'dataPurpose', 'StatusCon'));
        } elseif ($request->funs == 'editDoc') { // แก้ไขจัดการเอกสารการขออนุมัติ
            if (@$request->flagModal == 'yes') { // เปิดตอนอนุมัติ
                $is_flag = true;    //active redirect modal
            } else {
                $is_flag = false;    //active redirect modal
            }
            $App_Outlet = TB_StatusApprove::where('flag', 'yes')->get();
            $TypeLoans = $request->TypeLoans == 'car' || $request->TypeLoans == 'moto' ? 'car' : $request->TypeLoans;
            $Pact = Pact_Contracts::where('id', $id)->first();
            $roleNum = $this->checkRoleEditLoans($Pact->CodeLoan_Con, $Pact->Status_Con);
            $dataList = TB_ListCheckDocs::where('typeLoan', $TypeLoans)->get();
            $data = Pact_Checklists::where('PactCon_id', $id)->first();
            return view('frontend.content-con.section-document.view-doc', compact('data', 'is_flag', 'dataList', 'Pact', 'roleNum', 'App_Outlet'));
        } elseif ($request->type == 'editRef') { // แก้ไขบุคคลอ้างอิง
            $data = Pact_Contracts::where('id', $id)->first();
            return view('frontend.content-con.section-approve.modal-ref', compact('data'));
        } elseif ($request->type == 'editBeneficiary') { // แก้ไขบุคคลอ้างอิง
            $data = Pact_Contracts::where('id', $id)->first();
            $TBRealtion = TB_RelationPA::where('flag',strtolower('yes'))->get();
            return view('frontend.content-con.section-approve.modal-beneficiary', compact('data','TBRealtion'));
        } elseif ($request->funs == 'editAddsCon') { // แก้ไขที่อยู่ในการทำสัญญา
            $data = Pact_Contracts::where('id', $id)->first();
            return view('frontend.content-con.section-approve.modal-addsCon', compact('data'));
        } elseif ($request->funs == 'editGuaran') { // แก้ไขผู้ค้ำการ์ดหน้าสัญญา
            $data = Pact_ContractsGuarantor::find($id);
            $relaCus = TB_RelationsCus::getRelationsCus();
            $TypeSecur = TB_TypeSecurities::getTypeSecurities();
            return view('frontend.content-con.section-guaran.edit-Guaran', compact('data', 'relaCus', 'TypeSecur'));
        } elseif ($request->funs == 'EditStatusCon') {
            if (Gate::denies('edit-status-loans')) {
                // abort(403, 'คุณไม่มีสิทธิ์ในการแก้ไขบทบาทนี้');
                $errorMessage = 'คุณไม่มีสิทธิ์ในการแก้ไขบทบาทนี้';
                return response()->json('คุณไม่มีสิทธิ์ในการแก้ไขสถานะสัญญา', 403, [], JSON_UNESCAPED_UNICODE);
            }
            $data = Pact_Contracts::where('id', $id)->first();
            $StatusCon = TB_StatusCon::getStatusCon();
            return view('frontend.content-con.view-StatusCon', compact('data', 'StatusCon'));
        }
    }

    public function show(Request $request, $id)
    {
        $type = $request->type;
        if ($request->type == 'HistoryCon') { // ประวัติหน้าสัญญา
            $data_con = Log_ContractsCon::where('Data_id', $id)->get();
            return view('frontend.content-con.History', compact('type', 'data_con'));
        } elseif ($request->type == 'PreviewCon') { // พรีวิวสัญญา
            $data = Pact_Contracts::where('id', $id)->first();
            if ($data->ContractToIndentureAsset2 != NULL && count($data->ContractToIndentureAsset2) > 0) {
                $dataArr = array();
                foreach ($data->ContractToIndentureAsset2 as $key => $value) {
                    $dataArr[] = $value->IndenAssetToDataOwner->OwnershipToAsset->AssetToManyOwner->pluck('id');
                    $dataArr = array_merge($dataArr);
                }
                //dd($dataArr[0]);
                $Indent = $dataArr[0];
                $CheckIndent = Pact_Indentures_Assets::
                    leftJoin('Pact_Contracts', 'Pact_Contracts.id', '=', 'Pact_Indentures_Assets.PactCon_id')
                    ->wherein('Pact_Indentures_Assets.Asset_id', $Indent)
                    ->where('Pact_Contracts.Status_Con', 'transfered')
                    ->get();
            } else {
                $CheckIndent = [];
            }

            //$CheckIndent = Data_AssetsOwnership::where('DataCus_Id',$data->DataCus_id)->where('State_Ownership','Contract')->orderBy('id','DESC')->count();

            //->count();
            $arrLeasing = TB_TypeLoan::getTypeLeasing()->toArray();
            $arrLeasing_Code = array_column($arrLeasing, 'Loan_Code');
            // dd($arrLeasing_Code);
            $checkOwner = Data_AssetsOwnership::where('DataCus_Id', $data->DataCus_id)->where('State_Ownership', 'Transfer')->orderBy('id', 'DESC')->get();

            $arrCheck = [];

            if (count($data->ContractToPayee) != 0) {
                foreach ($data->ContractToPayee as $item) {  // Check Payee
                    array_push(
                        $arrCheck,
                        @$item->ContractToPayee->IDCard_cus,
                        @$item->ContractToPayee->Name_Account,
                        @$item->ContractToPayee->Number_Account,
                    );
                }
            } else {
                array_push($arrCheck, null);
            }


            foreach ($data->ContractToIndentureAsset2 as $item) {  // Check  Broker
                array_push(
                    $arrCheck,
                    @$item->id,
                );
            }

            foreach ($data->ContractToBrokers as $item) {  // Check  Broker
                array_push(
                    $arrCheck,
                    @$item->BrokertoCus->IDCard_cus,
                    @$item->BrokertoCus->Name_Account,
                    @$item->BrokertoCus->Number_Account,
                    @$item->Commission_Broker,
                    @$item->SumCom_Broker,
                );
            }
            // $arrRole = ['administrator', 'superadmin', 'supervisor', 'manager', 'finances'];
            $arrRole = $this->roleApprove(@$data->CodeLoan_Con);
            // dd( $this->checkRoleEditLoansList(@$data->Status_Con));
            $Approve_Position = @$data->ContractToUserApprove->getRoleNames();
            $Approve = $Approve_Position->filter(function ($item) use ($arrRole) {
                return in_array($item, $arrRole);
            });

            $userRole = auth()->user()->getRoleNames();
            $userApprove = $userRole->filter(function ($item) use ($arrRole) {
                return in_array($item, $arrRole);
            });

            $html = view('frontend.content-con.section-preview.preview', compact('data', 'arrCheck', 'CheckIndent', 'Approve', 'userApprove'))->render();
            return $html;
        } elseif ($request->type == 'GuaranInfo') { // ข้อมูลเพิ่มเติมผู้ค้ำตอนเลือกหน้าสัญญา
            $data = Data_Customers::where('id', $request->idCus)
                ->with([
                    'DataCusToDataCusAddsMany' => function ($query) {
                        $query->where('Type_Adds', 'ADR-0002');
                    }
                ])->first();
            $TypeSecur = TB_TypeSecurities::getTypeSecurities();
            $relaCus = TB_RelationsCus::getRelationsCus();
            $html = view('frontend.content-con.section-guaran.guaran-info', compact('data', 'TypeSecur', 'relaCus'))->render();
            return response()->json(['html' => $html]);
        } elseif ($request->type == 'section-asset') {  // กด tab ทรัพย์
            $data = Pact_Indentures_Assets::where('PactCon_id', $request->PactCon_id)->get();
            $html = view('frontend.content-con.section-asset.view-asset', compact('data'))->render();
            return response()->json(['html' => $html]);
        } elseif ($request->type == 'section-guarantor') { // กด tab ผู้ค้ำ
            $data = Pact_ContractsGuarantor::where('PactCon_id', $request->PactCon_id)->orderBy('id', 'ASC')->get();
            $html = view('frontend.content-con.section-guaran.view-guaran', compact('data'))->render();
            return response()->json(['html' => $html]);
        } elseif ($request->type == 'section-Payee') { // กด tab ผู้รับเงิน
            $dataPay = Pact_ContractPayee::where('PactCon_id', $request->PactCon_id)->get();
            $dataPact = Pact_Contracts::where('id', $request->PactCon_id)->first();
            $html = view('frontend.content-con.section-payee.view-payee', compact('dataPay', 'dataPact'))->render();
            return response()->json(['html' => $html]);
        } elseif ($request->type == 'section-Broker') { // กด tab ผู้แนะนำ
            $data = Pact_ContractBrokers::where('PactCon_id', $request->PactCon_id)->get();
            $com = TB_Commission::where('status', 'active')->get();
            $html = view('frontend.content-con.section-broker.view-Broker', compact('data', 'com'))->render();
            return response()->json(['html' => $html]);
        } elseif ($request->type == 'section-expens') { // กด tab รายละเอียดค่าใช้จ่าย
            $PactCon_id = $request->PactCon_id;
            $data = Pact_Operatedfees::where('PactCon_id', $PactCon_id)->first();
            $html = view('frontend.content-con.section-expenses.view-expens', compact('data', 'PactCon_id'))->render();
            return response()->json(['html' => $html]);
        } elseif ($request->type == 'section-contract') { // กด tab อนุมัติ
            $data = Pact_Contracts::where('id', $request->PactCon_id)->first();
            $Indent = $data->ContractToIndentureAsset2->pluck('Asset_id');
            $CheckIndent = Pact_Indentures_Assets::
                leftJoin('Pact_Contracts', 'Pact_Contracts.id', '=', 'Pact_Indentures_Assets.PactCon_id')
                ->wherein('Pact_Indentures_Assets.Asset_id', $Indent)
                ->where('Pact_Contracts.Status_Con', 'transfered')
                ->get();

            $checkOwner = Data_AssetsOwnership::where('DataCus_Id', $data->DataCus_id)->where('State_Ownership', 'Transfer')->orderBy('id', 'DESC')->get();

            // $checkAsset = Data_AssetsOwnership::whereIn('id',$Indent)->orderBy('id','DESC')->get();

            // $status = 'Active';
            // $t = $checkAsset->filter(function ($query) use ($status) {
            //     return $query->State_Ownership == $status;
            // });
            // $arrRole = ['administrator', 'superadmin', 'supervisor', 'manager', 'finances'];
            $arrRole = $this->checkRoleEditLoansList(@$data->Status_Con);
            $Approve_Position = @$data->ContractToUserApprove->getRoleNames();
            $Approve = $Approve_Position->filter(function ($item) use ($arrRole) {
                return in_array($item, $arrRole);
            });


            $SpApp = TB_SpecialTypeApp::getdata();
            $html = view('frontend.content-con.section-approve.view-approve', compact('data', 'CheckIndent', 'checkOwner', 'Approve', 'SpApp'))->render();
            return response()->json(['html' => $html]);
        } elseif ($request->funs == 'showGuaran') { // ดูข้อมูลเพิ่มเติมผู้ค้ำตอนกดจากการ์ด
            $data = Pact_ContractsGuarantor::find($id);
            $relaCus = TB_RelationsCus::getRelationsCus();
            $TypeSecur = TB_TypeSecurities::getTypeSecurities();
            return view('frontend.content-con.section-guaran.showdata', compact('data', 'relaCus', 'TypeSecur'));
        } elseif ($request->funs == 'showPayee') { // ดูข้อมูลเพิ่มเติมผู้รับเงินตอนกดจากการ์ด
            $data = Pact_ContractPayee::find($id);
            return view('frontend.content-con.section-payee.showdata', compact('data'));
        } elseif ($request->funs == 'showBroker') { // ดูข้อมูลเพิ่มเติมผู้แนะนำตอนกดจากการ์ด
            $data = Pact_ContractBrokers::find($id);
            return view('frontend.content-con.section-broker.showdata', compact('data'));
        } elseif ($request->funs == 'showAsset') { // ดูข้อมูลเพิ่มเติมผู้แนะนำตอนกดจากการ์ด
            $data = Data_Assets::find($id);
            return view('frontend.content-con.section-asset.showdata', compact('data'));
        } elseif ($request->funs == 'showHelper') { // ดูตัวช่วย
            $data = Pact_Contracts::where('id', $id)->first();
            $Code_Cus = $data->ContractToDataCusTags->Type_Customer;
            $Loan_Code = $data->CodeLoan_Con;
            $data_Approve = Config_Approves::where('Code_Cus', $Code_Cus)->first();
            $microlist = ['11', '12', '13', '17'];
            $assetIndent = false;
            // checkIndentAsset
            if ($data->ContractToIndentureAsset2 != NULL && count($data->ContractToIndentureAsset2) > 0) {
                $dataArr = array();
                foreach ($data->ContractToIndentureAsset2 as $key => $value) {
                    $dataArr[] = $value->IndenAssetToDataOwner->OwnershipToAsset->AssetToManyOwner->pluck('id');
                    $dataArr = array_merge($dataArr);
                }
                $Indent = $dataArr[0];

                $CheckIndent = Pact_Indentures_Assets::
                    leftJoin('Pact_Contracts', 'Pact_Contracts.id', '=', 'Pact_Indentures_Assets.PactCon_id')
                    ->wherein('Pact_Indentures_Assets.Asset_id', $Indent)
                    ->where('Pact_Contracts.Status_Con', 'transfered')
                    ->whereNotIn('Pact_Contracts.Contract_Con', [$data->Contract_Con])
                    ->get();
            } else {
                $CheckIndent = [];
            }
            if (count($CheckIndent) > 0 && in_array($Loan_Code, $microlist) == false) {
                $assetIndent = true; // ยังมีทรัพย์ผูกอยู่ในสัญญาอื่น
            }






            return view('frontend.content-con.section-preview.helper-preview', compact('data', 'data_Approve', 'assetIndent', 'CheckIndent'));
        }
    }

    public function update(Request $request, $id)
    {

        $dataPact = Pact_Contracts::where('id', $request->PactCon_id)->first();
        $roleNum = $this->checkRoleEditLoans($dataPact->CodeLoan_Con, $dataPact->Status_Con);
        $arrStatus = ['active'];

        if ($request->funs != null && $request->func != 'saveExpenses') {
            if (in_array($dataPact->Status_Con, $arrStatus) || $roleNum > 0) {
                if ($request->funs == 'UpdateCardCon') {  // อัพเดทหน้าโปรไฟล์สัญญา
                    DB::beginTransaction();
                    try {
                        $status = ['transfered', 'cancel', 'close', 'complete'];
                        //อนุมัติ
                        $data = Pact_Contracts::where('id', $id)->first();
                        $UserApp_relevant = @$request->UserApp_relevant != NULL ? implode(',', @$request->UserApp_relevant) : NULL;
                        $data->Date_con = convertDateHumanToPHP($request->Date_con);
                        $data->Data_Purpose = $request->dataPurpose;
                        $data->UserApp_Con = $request->UserApp_Con;
                        $data->LinkUpload_Con = $request->LinkUpload_Con;
                        $data->linkChecker = $request->linkChecker;
                        $data->LinkBookcar = $request->LinkBookcar; // ลิงก์เช็คเล่มทะเบียน
                        $data->LinkBookSpecial = $request->LinkBookSpecial; // ลิงก์ได้รับเล่มทะเบียน
                        $data->UserApp_relevant = @$UserApp_relevant;
                        $data->Memo_Con = $request->Memo_Contracts;

                        $data->update();
                        DB::commit();

                        event(new LogDataContract(@$request->PactCon_id, 'update', 'LogDataContract', 'update-CardCon', 'แก้ไขโปรไฟล์สัญญา ID:' . $data->id, auth()->user()->id));

                        $tab = 'section-contract';
                        $htmlheader = view('frontend.content-con.view-headerCon', compact('data', 'roleNum'))->render();
                        $renderTab = view('frontend.content-con.view-tab', compact('data', 'tab'))->render();
                        return response()->json(['status' => 'success', 'htmlheader' => $htmlheader, 'renderTab' => $renderTab], 200);

                    } catch (\Exception $e) {
                        DB::rollBack();

                        return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    }
                } elseif ($request->funs == 'UpdateCom') { // อัพเดทค่าคอม
                    DB::beginTransaction();
                    try {
                        $dataCom = Pact_ContractBrokers::where('id', $request->idBrk)->first();

                        $dataCom->FlagCom_Broker = $request->flag;
                        $dataCom->TypeCom = $request->typeCom;
                        $dataCom->Commission_Broker = floatval(str_replace(',', '', $request->commission));
                        $dataCom->Commission_Broker_Prices = 0;
                        $dataCom->SumCom_Broker = floatval(str_replace(',', '', $request->totalCom));
                        $dataCom->update();
                        // dd( $request->commission , floatval(str_replace(',', '', $request->commission)));
                        DB::commit();
                        event(new LogDataContract(@$request->PactCon_id, 'update', 'LogBrokerContract', 'update-Commission', 'แก้ไขค่าคอมมิชชั่น ID:' . $dataCom->id, auth()->user()->id));

                        $tab = 'section-Broker';
                        $com = TB_Commission::where('status', 'active')->get();
                        $data = Pact_ContractBrokers::where('PactCon_id', $request->PactCon_id)->get();
                        $returnHTML = view('frontend.content-con.section-broker.view-Broker', compact('data', 'com'))->render();

                        $data = Pact_Contracts::where('id', $request->PactCon_id)->first();
                        $renderTab = view('frontend.content-con.view-tab', compact('data', 'tab'))->render();

                        return response()->json(['html' => $returnHTML, 'renderTab' => $renderTab], 200);

                    } catch (\Exception $e) {
                        DB::rollBack();

                        return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    }
                } elseif ($request->funs == 'addRef') { // เพิ่มบุคคลอ้างอิง
                    DB::beginTransaction();
                    try {
                        $data = Pact_Contracts::where('id', $id)->first();
                        $data->Cus_Ref = $request->Cus_Ref;
                        $data->PhoneCus_Ref = $request->PhoneCus_Ref;
                        $data->update();
                        DB::commit();

                        event(new LogDataContract(@$data->id, 'update', 'LogDataContract', 'update-Contract', 'เพิ่มบุคคลอ้างอิง : ' . $request->Cus_Ref . 'เบอร์ :' . $request->PhoneCus_Ref, auth()->user()->id));

                        $html = view('components.content-contract.section-contract.Cusref', compact('data'))->render();
                        $htmlHeaderCard = view('frontend.content-con.view-headerCon', compact('data'))->render();
                        return response()->json(['html' => $html, 'htmlHeaderCard' => $htmlHeaderCard], 200);
                    } catch (\Exception $e) {
                        DB::rollBack();

                        return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    }
                } elseif ($request->funs == 'removeRef') { // ลบบุคคลอ้างอิง
                    DB::beginTransaction();
                    try {
                        $data = Pact_Contracts::where('id', $id)->first();
                        $data->Cus_Ref = NULL;
                        $data->PhoneCus_Ref = NULL;
                        $data->update();
                        DB::commit();

                        event(new LogDataContract(@$data->id, 'update', 'LogDataContract', 'update-Contract', 'ลบบุคคลอ้างอิง', auth()->user()->id));

                        $html = view('components.content-contract.section-contract.Cusref', compact('data'))->render();
                        $htmlHeaderCard = view('frontend.content-con.view-headerCon', compact('data'))->render();
                        return response()->json(['html' => $html, 'htmlHeaderCard' => $htmlHeaderCard], 200);
                    } catch (\Exception $e) {
                        DB::rollBack();

                        return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    }
                } elseif ($request->funs == 'addBeneficiary') { // เพิ่มผู้รับผลประโยชน์
                    DB::beginTransaction();
                    try {
                        $data = Pact_Contracts::where('id', $id)->first();
                        $data->Beneficiary_PA = $request->Beneficiary_PA;
                        $data->Relations_PA = $request->Relations_PA == 'otherRelation' ? $request->InputRelation : $request->Relations_PA ;
                        $data->update();
                        DB::commit();

                        event(new LogDataContract(@$data->id, 'update', 'LogDataContract', 'update-Contract', 'เพิ่มผู้รับผลประโยชน์ : ' . $request->Beneficiary_PA . 'ความสัมพันธ์ :' . $request->Relations_PA, auth()->user()->id));

                        $html = view('components.content-contract.section-contract.CusBenaficiary', compact('data'))->render();
                        $htmlHeaderCard = view('frontend.content-con.view-headerCon', compact('data'))->render();
                        return response()->json(['html' => $html, 'htmlHeaderCard' => $htmlHeaderCard], 200);
                    } catch (\Exception $e) {
                        DB::rollBack();

                        return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    }
                } elseif ($request->funs == 'removeBeneficiary') { // ลบผู้รับผลประโยชน์
                    DB::beginTransaction();
                    try {
                        $data = Pact_Contracts::where('id', $id)->first();
                        $data->Beneficiary_PA = NULL;
                        $data->Relations_PA = NULL;
                        $data->update();
                        DB::commit();

                        event(new LogDataContract(@$data->id, 'update', 'LogDataContract', 'update-Contract', 'ลบผู้รับผลประโยชน์', auth()->user()->id));

                        $html = view('components.content-contract.section-contract.CusBenaficiary', compact('data'))->render();
                        $htmlHeaderCard = view('frontend.content-con.view-headerCon', compact('data'))->render();
                        return response()->json(['html' => $html, 'htmlHeaderCard' => $htmlHeaderCard], 200);
                    } catch (\Exception $e) {
                        DB::rollBack();

                        return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    }
                } elseif ($request->funs == 'addAddCon') { // ที่อยู่ในการใช้ทำสัญญา
                    DB::beginTransaction();
                    try {
                        $data = Pact_Contracts::where('id', $id)->first();
                        $data->Adds_Con = $request->Adds_Con;
                        $data->update();

                        DB::commit();
                        event(new LogDataContract(@$data->id, 'update', 'LogDataContract', 'update-Contract', 'เพิ่มที่อยู่ในสัญญา ID:' . $request->Adds_Con, auth()->user()->id));

                        $tab = 'section-contract';
                        $htmlHeaderCard = view('frontend.content-con.view-headerCon', compact('data'))->render();
                        $renderTab = view('frontend.content-con.view-tab', compact('data', 'tab'))->render();
                        return response()->json(['addressText' => $request->Adds_Con, 'htmlHeaderCard' => $htmlHeaderCard, 'renderTab' => $renderTab], 200);
                    } catch (\Exception $e) {
                        DB::rollBack();

                        return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    }
                } elseif ($request->func == 'editGuaran') { //แก้ไขข้อมูลผู้ค้ำหลังจากเลือกในหน้าสัญญา
                    $data = Pact_ContractsGuarantor::where('PactCon_id', $request->PactCon_id)->where('Guarantor_id', $request->Guarantor_id)->first();
                    DB::beginTransaction();
                    try {
                        $data->TypeRelation_Cus = $request->RelationsCus;
                        $data->TypeSecurities_Guar = $request->Securities;
                        $data->update();

                        if ($request->idAsset != NULL) {
                            Pact_ContractsGuar_Assets::
                                where('Guarantor_id', $request->Guarantor_id)
                                ->where('PactCon_id', $request->PactCon_id)
                                ->delete();

                            foreach ($request->idAsset as $item) {
                                $DataInTrash = Pact_ContractsGuar_Assets::onlyTrashed()->where('Guarantor_id', $request->Guarantor_id)->where('PactCon_id', $request->PactCon_id)->where('GuarAsset_id', $item)->first();
                                if ($DataInTrash == NULL) { // เช็คข้อมูลที่เคยลบว่ามีข้อมูลอยู่หรือไม่
                                    $dataasst = new Pact_ContractsGuar_Assets;
                                    $dataasst->DataTag_id = $request->DataTag_id;
                                    $dataasst->PactCon_id = $request->PactCon_id;
                                    $dataasst->Guarantor_id = $request->Guarantor_id;
                                    $dataasst->GuarAsset_id = $item;
                                    $dataasst->UserZone = auth()->user()->zone;
                                    $dataasst->UserBranch = auth()->user()->branch;
                                    $dataasst->UserInsert = auth()->user()->id;
                                    $dataasst->save();
                                } else { // ถ้ามีข้อมูลอยู่ให้เรียกข้อมูลเก่าขึ้นมาแทน
                                    $DataInTrash->restore();
                                }
                            }
                        }
                        DB::commit();
                        $eventLog = event(new LogDataContract(@$data->id, 'update', 'LogGuaranContract', 'update-Contract', 'แก้ไขข้อมูลเพิ่มเติมผู้ค้า ID:' . $request->Guarantor_id, auth()->user()->id));

                    } catch (\Exception $e) {
                        DB::rollBack();
                        Log::error($e->getMessage());

                        return response(['error' => true, 'message' => 'ไม่สามารถเพิ่มผู้ค้ำได้ !'], 500);
                    }
                } elseif ($request->funs == 'editStatusCon') { // อัพเดทสถานะสัญญา
                    DB::beginTransaction();
                    try {

                        $arrStatusCon = [
                            'cancel' => ['active', 'pending', 'cancel', 'close'],
                            'pending' => ['active', 'pending', 'cancel', 'close'],
                            'complete' => ['pending', 'active', 'complete', 'cancel', 'close'],
                            'active' => ['active', 'cancel', 'close'],
                            'transfered' => ['transfered', 'cancel', 'close'],
                            'close' => ['active', 'pending', 'active', 'complete', 'cancel', 'close']
                        ];

                        $data = Pact_Contracts::where('id', $request->PactCon_id)->first();
                        $checkStatusCon = in_array($request->Status_Con, $arrStatusCon[$data->Status_Con]);
                        if ($checkStatusCon) {
                            if ($request->Status_Con == 'cancel') {
                                $Date_monetary = NULL;
                                $data->Approve_monetary = NULL;
                                $data->UserCancel_Con = auth()->user()->name;
                                $data->DateCancel_Con = date('Y-m-d H:i:s');
                                $data->Status_Con = 'cancel';
                                $Indent = $data->ContractToIndentureAsset2->pluck('Asset_id');
                                $statusAss = '';
                                $checkStatus = Data_AssetsOwnership::whereIn('id', $Indent)->orderBy('id', 'DESC')->first();
                                if ($checkStatus != NULL) {
                                    if ($checkStatus->State_Ownership == 'Process') {
                                        $statusAss = 'Active';
                                    } elseif ($checkStatus->State_Ownership == 'TransferProcess') {
                                        $statusAss = 'Transfer';
                                    } else {
                                        $statusAss = 'Cancel';
                                    }

                                    $checkAsset = Data_AssetsOwnership::whereIn('id', $Indent)->orderBy('id', 'DESC')->update([
                                        "State_Ownership" => $statusAss
                                    ]);
                                }
                            } elseif ($request->Status_Con == 'close') {
                                $data->Status_Con = 'close';
                                $Indent = $data->ContractToIndentureAsset2->pluck('Asset_id');
                                $checkAsset = Data_AssetsOwnership::whereIn('id', $Indent)->orderBy('id', 'DESC')->update([
                                    "State_Ownership" => 'Completed'
                                ]);
                            } elseif ($request->Status_Con == 'transfered') {
                                $data->Status_Con = 'transfered';
                            } elseif ($request->Status_Con == 'complete' && $data->Status_Con != 'transfered') {
                                $data->Status_Con = 'complete';
                            } else {
                                //
                            }

                            switch ($request->Status_Con) {
                                case 'active':
                                    $data->DocApp_Con = null;
                                    $data->DateDocApp_Con = null;
                                    $data->ConfirmApp_Con = null;
                                    $data->DateConfirmApp_Con = null;
                                    $data->ConfirmDocApp_Con = null;
                                    $data->DateSpecial_Bookcar = null;
                                    $data->BookSpecial_Type = null;
                                    $data->Msteams_Id = null;
                                    break;
                                case 'pending':
                                    $data->ConfirmApp_Con = null;
                                    $data->DateConfirmApp_Con = null;
                                    break;
                                default:
                                //
                            }
                            $data->Status_Con = $request->Status_Con;
                            $data->Memo_Con = $request->Memo_Contracts;
                            $data->Date_monetarStatusApp_Con;
                            $data->StatusApp_Con = $request->StatusApp_Con;
                            $data->Date_monetary = $request->Date_monetary;
                            $data->update();
                        } else {
                            return response()->json(['message' => 'ผิดพลาด !', 'text' => 'ไม่สามารถเลือกสถานะสัญญาข้ามลำดับได้'], 500);

                        }

                        DB::commit();
                        event(new LogDataContract(@$data->id, 'update', 'LogDataContract', 'update-Contract', 'แก้ไขสถานะสัญญา ID:' . $data->id, auth()->user()->id));

                        // $html = view('frontend.content-con.view-headerCon', compact('data'))->render();
                        $tab = 'section-contract';
                        $htmlheader = view('frontend.content-con.view-headerCon', compact('data', 'roleNum'))->render();
                        $renderTab = view('frontend.content-con.view-tab', compact('data'))->render();
                        return response()->json(['status' => 'success', 'htmlheader' => $htmlheader, 'renderTab' => $renderTab], 200);

                    } catch (\Exception $e) {
                        DB::rollBack();

                        return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    }
                } elseif ($request->funs == 'RemoveSpecialApprove') { // เคลียร์ขออนุมัติพิเศษ
                    $data = Pact_Contracts::where('id', $id)->first();
                    DB::beginTransaction();
                    try {
                        if ($data->Status_Con == 'active') {
                            $data->Special_Bookcar = NULL;
                            $data->DateSpecial_Bookcar = NULL;
                            $data->BookSpecial_Type = NULL;
                            $data->update();

                            // $arrRole = ['administrator', 'superadmin', 'supervisor', 'manager', 'finances'];
                            $arrRole = $this->checkRoleEditLoansList(@$data->Status_Con);

                            $Approve_Position = @$data->ContractToUserApprove->getRoleNames();
                            $Approve = $Approve_Position->filter(function ($item) use ($arrRole) {
                                return in_array($item, $arrRole);
                            });
                            DB::commit();
                            $SpApp = TB_SpecialTypeApp::getdata();
                            $tab = 'section-contract';
                            $htmlheader = view('frontend.content-con.view-headerCon', compact('data'))->render();
                            $html = view('frontend.content-con.section-approve.view-approve', compact('data', 'Approve', 'SpApp'))->render();
                            $renderTab = view('frontend.content-con.view-tab', compact('data', 'tab'))->render();
                            return response()->json(['status' => 'success', 'html' => $html, 'htmlheader' => $htmlheader, 'renderTab' => $renderTab], 200);
                        } else {
                            return response(['error' => true, 'message' => 'ไม่สามารถแก้ข้อมูลได้ ! ในขณะสัญญา "' . $data->StatusApp_Con . '"', "text" => ' '], 500);
                        }
                    } catch (\Exception $e) {
                        DB::rollBack();

                        return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    }
                } elseif ($request->funs == 'RemoveCheckBookCar') { // เคลียร์เช็คเล่มทะเบียน
                    DB::beginTransaction();
                    try {
                        $data = Pact_Contracts::where('id', $id)->first();
                        $data->Check_Bookcar = NULL;
                        $data->LinkBookcar = NULL;
                        $data->DateCheck_Bookcar = NULL;
                        $data->update();

                        // $arrRole = ['administrator', 'superadmin', 'supervisor', 'manager', 'finances'];
                        $arrRole = $this->checkRoleEditLoansList(@$data->Status_Con);

                        $Approve_Position = @$data->ContractToUserApprove->getRoleNames();
                        $Approve = $Approve_Position->filter(function ($item) use ($arrRole) {
                            return in_array($item, $arrRole);
                        });
                        DB::commit();

                        $tab = 'section-contract';
                        $htmlheader = view('frontend.content-con.view-headerCon', compact('data'))->render();
                        $html = view('frontend.content-con.section-approve.view-approve', compact('data', 'Approve'))->render();
                        $renderTab = view('frontend.content-con.view-tab', compact('data', 'tab'))->render();
                        return response()->json(['status' => 'success', 'html' => $html, 'htmlheader' => $htmlheader, 'renderTab' => $renderTab], 200);
                    } catch (\Exception $e) {
                        DB::rollBack();

                        return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    }
                } elseif ($request->funs == 'Removeapprove') { // เคลียร์ได้รับเล่ม
                    DB::beginTransaction();
                    try {
                        $data = Pact_Contracts::where('id', $id)->first();
                        $data->BookSpecial_Trans = NULL;
                        $data->LinkBookSpecial = NULL;
                        $data->Date_BookSpecial = NULL;
                        $data->update();

                        // $arrRole = ['administrator', 'superadmin', 'supervisor', 'manager', 'finances'];
                        $arrRole = $this->checkRoleEditLoansList(@$data->Status_Con);

                        $Approve_Position = @$data->ContractToUserApprove->getRoleNames();
                        $Approve = $Approve_Position->filter(function ($item) use ($arrRole) {
                            return in_array($item, $arrRole);
                        });
                        DB::commit();

                        $tab = 'section-contract';
                        $htmlheader = view('frontend.content-con.view-headerCon', compact('data'))->render();
                        $html = view('frontend.content-con.section-approve.view-approve', compact('data', 'Approve'))->render();
                        $renderTab = view('frontend.content-con.view-tab', compact('data', 'tab'))->render();
                        return response()->json(['status' => 'success', 'html' => $html, 'htmlheader' => $htmlheader, 'renderTab' => $renderTab], 200);
                    } catch (\Exception $e) {
                        DB::rollBack();

                        return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    }
                } elseif ($request->funs == 'Removechecker') { // เคลียร์ checker
                    DB::beginTransaction();
                    try {
                        $data = Pact_Contracts::where('id', $id)->first();
                        $data->Checkers_Con = NULL;
                        $data->linkChecker = NULL;
                        $data->Date_Checkers = NULL;
                        $data->update();

                        // $arrRole = ['administrator', 'superadmin', 'supervisor', 'manager', 'finances'];
                        $arrRole = $this->checkRoleEditLoansList(@$data->Status_Con);

                        $Approve_Position = @$data->ContractToUserApprove->getRoleNames();
                        $Approve = $Approve_Position->filter(function ($item) use ($arrRole) {
                            return in_array($item, $arrRole);
                        });
                        DB::commit();

                        $tab = 'section-contract';
                        $htmlheader = view('frontend.content-con.view-headerCon', compact('data'))->render();
                        $html = view('frontend.content-con.section-approve.view-approve', compact('data', 'Approve'))->render();
                        $renderTab = view('frontend.content-con.view-tab', compact('data', 'tab'))->render();
                        return response()->json(['status' => 'success', 'html' => $html, 'htmlheader' => $htmlheader, 'renderTab' => $renderTab], 200);
                    } catch (\Exception $e) {
                        DB::rollBack();

                        return response()->json(['message' => $e->getMessage(), 'code' => $e->getCode()], 500);
                    }
                }
            } else {
                if ($dataPact->Status_Con == 'pending') {
                    $text = 'กรุณายกเลิกการขออนุมัติก่อนทำการ แก้ไขข้อมูล';
                } else {
                    $text = '';
                }
                return response(['error' => true, 'message' => 'ไม่สามารถแก้ข้อมูลได้ ! ในขณะสัญญา "' . $dataPact->StatusApp_Con . '"', "text" => $text], 500);
            }
        } elseif ($request->funs == null && $request->func != 'saveExpenses') {
            //-------//
            if ($request->type == 'approve') {    //อนุมัติ - team
                $user_zone = auth()->user()->zone;
                $typeLoan = TB_TypeLoanCom::generateQuery();
                $loantype = array();

                foreach ($typeLoan as $loan) {
                    $loantype[$loan->Loan_Code] = $loan->Loan_Group;
                }

                $data = Pact_Contracts::where('id', $id)->first();
                //User Now Login to team


                $Domain = url('/');
                $license = "";
                if (@$data->ContractToTypeLoan->id_rateType != 'person') {
                    $asset = @$data->ContractToIndenture->IndentureToAsset;
                    if (@$data->ContractToTypeLoan->id_rateType == 'land') {
                        $license = "เลขที่โฉนด " . @$asset->Land_Id;
                    } else {

                        $license = "ทะเบียนรถ " . @$asset->Vehicle_NewLicense != NULL ? @$asset->Vehicle_NewLicense : @$asset->Vehicle_OldLicense;
                        @$miData = ConnectCredo::getDataMI(@$data->DataTag_id);

                    }
                }
                if (auth()->user()->UserToMSTeams != NULL && $data->Status_Con != "cancel") {
                    $user_name = auth()->user()->email;
                    $password = base64_decode(auth()->user()->password_teams);
                    $namePost = auth()->user()->name;
                    // เช็คการอนุมัติพิเศษ
                    if (@$data->ContractToBookSpecial->FlagApprove == 'yes' && $data->ConfirmDocApp_Con == NULL) {
                        $userSpecialApp = User::where('zone', auth()->user()->zone)
                            ->whereHas('roles', function ($query) {
                                $query->whereIn('name', ['manager']);
                            })->first();
                        $user_approve = $userSpecialApp->email;
                        $password_approve = base64_decode($userSpecialApp->password_teams);
                        $nameTag = $userSpecialApp->name;
                        $textSpecialApp = ' พิเศษ(' . $data->ContractToBookSpecial->Special_Name . ')';
                    } else {
                        $user_approve = @$data->ContractToUserApprove->email;
                        $password_approve = base64_decode(@$data->ContractToUserApprove->password_teams);
                        $nameTag = @$data->ContractToUserApprove->name;
                        $textSpecialApp = '';
                    }

                    $msTeams = auth()->user()->UserToMSTeams;
                    $teams_chanel = $msTeams->Teams_Chanel;
                    $group_id = $msTeams->Group_Id;
                    $type_team = $msTeams->Type_teams;

                    // $tokenUser = ConnectMSTeams::getTokenUser($user_name, $password);
                    if ($data->DocApp_Con == NULL && $request->DocApp_Con != NULL) {

                        //รออนุมัติ
                        if ($loantype[$data->CodeLoan_Con] == 1) {
                            $subject = "ขออนุมัติเคสเช่าซื้อ" . $textSpecialApp . " (" . $data->ContractToTypeLoan->Loan_Name . ") " . $license . " " . $data->Contract_Con . "   " . $data->ContractToDataCusTags->TagToDataCus->Name_Cus . " สาขา" . $data->ContractToBranch->Name_Branch . " วันที่ " . date('d-m-Y');
                        } else if ($loantype[$data->CodeLoan_Con] == 2) {
                            $subject = "ขออนุมัติเงินกู้" . $textSpecialApp . "  (" . $data->ContractToTypeLoan->Loan_Name . ") " . $license . " " . $data->Contract_Con . "   " . $data->ContractToDataCusTags->TagToDataCus->Name_Cus . " สาขา" . $data->ContractToBranch->Name_Branch . " วันที่ " . date('d-m-Y');
                        } else if ($loantype[$data->CodeLoan_Con] == 3) {
                            $subject = "ขออนุมัติเงินกู้ไมโคร" . $textSpecialApp . " (" . $data->ContractToTypeLoan->Loan_Name . ") " . $license . " " . $data->Contract_Con . "   " . $data->ContractToDataCusTags->TagToDataCus->Name_Cus . " สาขา" . $data->ContractToBranch->Name_Branch . " วันที่ " . date('d-m-Y');
                        }
                        $link_approve = "<a href='" . $Domain . "/contract/" . $data->id . "/edit?funs=contract&loanCode=" . $data->CodeLoan_Con . "'>คลิ๊ก</a>";

                        //tag ผู้อนุมัติ
                        //   $tokenUserTag = ConnectMSTeams::getTokenUser($user_approve, $password_approve);
                    } elseif ($request->cancel_app != NULL) {

                        if (auth()->user()->id == $data->DocApp_Con || $roleNum > 0) {
                            if ($data->ConfirmApp_Con == NULL) {

                                DB::beginTransaction();
                                try {

                                    // เคลียร์ข้อมูลใน Pact
                                    
                                    $data->DocApp_Con = null;
                                    $data->DateDocApp_Con = null;
                                    $data->Status_Con = 'active';
                                    $data->StatusApp_Con = 'สร้างสัญญา';
                                    $data->update();

                                    DB::commit();
                                    $subject = "ยกเลิกขออนุมัติ เอกสารไม่ครบ รอตรวจสอบอีกครั้ง";
                                    $link_acc = "";
                                    $one_drive = "";
                                    // $tokenUserTag = ConnectMSTeams::getTokenUser($user_approve, $password_approve);

                                    $eventLog = event(new LogDataContract(@$data->id, 'reject', 'LogDataContract', '..', 'ยกเลิกการขออนุมัติ', auth()->user()->id));

                                } catch (\Exception $e) {
                                    DB::rollBack();
                                }

                            } else {
                                return response()->json(['status' => 'error', 'text' => 'อนุมัติเรียบร้อยเเล้ว กรุณาติดต่อผู้อนุมัติเพื่อทำการยกเลิก', 'user' => '']);
                            }
                        } else {
                            return response()->json(['status' => 'error', 'message' => 'ไม่มีมสิทธิ์ยกเลิกอนุมัติ !', 'text' => ' สิทธิการยกเลิกเป็นของ ' . $data->ContractToUserApp->name], 500);
                        }
                    } elseif ($data->ConfirmApp_Con == NULL && $request->ConfirmApp_Con != NULL) {
                        // ตรวจสอบว่ามีการอนุมัติเคสพิเศษแล้วยัง
                        if ($data->BookSpecial_Type != NULL && $data->ConfirmDocApp_Con == NULL && $data->ContractToBookSpecial->FlagApprove == 'yes') {
                            return response()->json(['status' => 'error', 'text' => 'กรุณาดำเนินการการอนุมัติเคสพิเศษ ก่อนการอนุมัติสัญญา', 'user' => '']);
                        }
                        //อนุมัติ
                        if ($data->DocApp_Con != NULL && ($data->ContractToAudittor->statusDoc == 'Pass' || $request->statusDoc == 'Pass')) { ///&& $data->Doc == "Pass"
                            if ($loantype[$data->CodeLoan_Con] == 1) {
                                $subject = "อนุมัติเคสเช่าซื้อ (" . $data->ContractToTypeLoan->Loan_Name . ") " . $data->Contract_Con . "   " . $data->ContractToDataCusTags->TagToDataCus->Name_Cus . " สาขา" . $data->ContractToBranch->Name_Branch . " วันที่ " . date('d-m-Y');
                            } else if ($loantype[$data->CodeLoan_Con] == 2) {
                                $subject = "อนุมัติเงินกู้  (" . $data->ContractToTypeLoan->Loan_Name . ") " . $data->Contract_Con . "   " . $data->ContractToDataCusTags->TagToDataCus->Name_Cus . " สาขา" . $data->ContractToBranch->Name_Branch . " วันที่ " . date('d-m-Y');
                            } else if ($loantype[$data->CodeLoan_Con] == 3) {
                                $subject = "อนุมัติเงินกู้ไมโคร (" . $data->ContractToTypeLoan->Loan_Name . ") " . $data->Contract_Con . "   " . $data->ContractToDataCusTags->TagToDataCus->Name_Cus . " สาขา" . $data->ContractToBranch->Name_Branch . " วันที่ " . date('d-m-Y');
                            }
                            $link_acc = "<br/> การเงินโอนยอด" . "<a href='" . $Domain . "/view?page=financial-approval" . "'>คลิ๊ก</a>";

                            //tag แผนก การเงินใน
                            $userAccount = User::where('zone', auth()->user()->zone)
                                ->whereHas('roles', function ($query) {
                                    $query->whereIn('name', ['financial-inside']);
                                })->first();
                            $user_approve = $userAccount->email;
                            $password_approve = base64_decode($userAccount->password_teams);
                            $nameTag = $userAccount->name;
                            // $tokenUserTag = ConnectMSTeams::getTokenUser($user_approve,$password_approve);
                            $eventLog = event(new LogDataContract(@$data->id, 'update', 'LogDataContract', 'update-Contract', 'อนุมัติสัญญา', auth()->user()->id));
                        } else {
                            return response()->json(['status' => 'error', 'text' => 'ยังไม่มีการขออนุมัติ หรือตรวจสอบเอกสาร \n  กรุณารอ หรือสอบถามไปยังสาขา', 'user' => '']);
                        }
                    } elseif ($data->ConfirmDocApp_Con == NULL && $request->ConfirmDocApp_Con != NULL) {
                        // อนุมัติำสัญญา
                        if ($data->DocApp_Con != NULL && $data->ConfirmDocApp_Con == NULL) {
                            $subject = "อนุมัติเคสพิเศษ (" . $data->ContractToTypeLoan->Loan_Name . ") " . $data->Contract_Con . "   " . $data->ContractToDataCusTags->TagToDataCus->Name_Cus . " สาขา" . $data->ContractToBranch->Name_Branch . " วันที่ " . date('d-m-Y');
                            //tag หาผู้อนุมัติสัญญา
                            $user_approve = @$data->ContractToUserApprove->email;
                            $password_approve = base64_decode(@$data->ContractToUserApprove->password_teams);
                            $nameTag = @$data->ContractToUserApprove->name;

                            $link_approve = "<a href='" . $Domain . "/contract/" . $data->id . "/edit?funs=contract&loanCode=" . $data->CodeLoan_Con . "'>คลิ๊ก</a>";
                            $eventLog = event(new LogDataContract(@$data->id, 'update', 'LogDataContract', 'update-Contract', 'อนุมัติเคสพิเศษ', auth()->user()->id));
                        } else {
                            return response()->json(['status' => 'error', 'text' => 'ยังไม่มีการขออนุมัติ กรุณารอ หรือสอบถามไปยังสาขา', 'user' => '']);
                        }
                    } elseif ($data->Date_BookSpecial == NULL && $request->Date_BookSpecial != NULL) {
                        //เช่าซื้อ
                        if (@$data->ContractToTypeLoan->id_rateType == 'car') {
                            $subject = "ได้รับเล่มทะเบียน  (" . $data->ContractToTypeLoan->Loan_Name . ") " . $data->Contract_Con . "   " . $data->ContractToDataCusTags->TagToDataCus->Name_Cus . " สาขา" . $data->ContractToBranch->Name_Branch . " วันที่ " . date('d-m-Y');

                        } else {
                            $subject = "ได้รับเอกสาร  (" . $data->ContractToTypeLoan->Loan_Name . ") " . $data->Contract_Con . "   " . $data->ContractToDataCusTags->TagToDataCus->Name_Cus . " สาขา" . $data->ContractToBranch->Name_Branch . " วันที่ " . date('d-m-Y');
                        }

                        $link_acc = "<br/> การเงินโอนยอด" . "<a href='" . $Domain . "/view?page=financial-approval" . "'>คลิ๊ก</a>";

                        //tag แผนก การเงินใน
                        $userAccount = User::where('zone', auth()->user()->zone)
                            ->whereHas('roles', function ($query) {
                                $query->whereIn('name', ['financial-inside']);
                            })->first();

                        $user_approve = $userAccount->email;
                        $password_approve = base64_decode($userAccount->password_teams);
                        $nameTag = $userAccount->name;
                        // $tokenUserTag = ConnectMSTeams::getTokenUser($user_approve,$password_approve);
                    }


                    $one_drive = '<br/> เอกสารแนบ ' . "<a href='" . $data->LinkUpload_Con . "' >คลิ๊ก</a>";
                    $post = false;

                    //รออนุมัติ
                    //สร้างข้อความ และ แท็กผูอนุมัติ

                    if (($data->DocApp_Con == NULL && $request->DocApp_Con != NULL)) {
                        $dataArray = $subject . "<br/>" . 'รายการขออนุมัติ ' . $link_approve . $one_drive;

                        // แทกหลายคน
                        if ($data->UserApp_relevant != NULL) {
                            $post = $this->alertTeams($data->id, 'pending', @$textSpecialApp);
                        } else {
                            if ($data->Msteams_Id == NULL) {
                                $eventPost = event(new MsTeamsEvent(@$data->id, $user_name, $password, $user_approve, $password_approve, $nameTag, $group_id, $teams_chanel, '', $dataArray, $type_team, 'post'));
                            } else {
                                $eventPost = event(new MsTeamsEvent(@$data->id, $user_name, $password, $user_approve, $password_approve, $nameTag, $group_id, $teams_chanel, $data->Msteams_Id, $dataArray, $type_team, 'replies'));
                            }
                            $post = true;
                            $eventLog = event(new LogDataContract(@$data->id, 'update', 'LogDataContract', 'update-Contract', 'ขออนุมัติสัญญา', auth()->user()->id));
                        }




                    } elseif (($data->ConfirmDocApp_Con == NULL && $request->ConfirmDocApp_Con != NULL)) {
                        $dataArray = $subject . "<br/>" . 'รายการขออนุมัติ ' . $link_approve . $one_drive;
                        if ($data->Msteams_Id == NULL) {
                            $eventPost = event(new MsTeamsEvent(@$data->id, $user_name, $password, $user_approve, $password_approve, $nameTag, $group_id, $teams_chanel, '', $dataArray, $type_team, 'post'));
                        } else {
                            $eventPost = event(new MsTeamsEvent(@$data->id, $user_name, $password, $user_approve, $password_approve, $nameTag, $group_id, $teams_chanel, $data->Msteams_Id, $dataArray, $type_team, 'replies'));
                        }

                        $post = true;
                        $eventLog = event(new LogDataContract(@$data->id, 'update', 'LogDataContract', 'update-Contract', 'ขออนุมัติสัญญา', auth()->user()->id));



                    } elseif (($data->ConfirmDocApp_Con == NULL && $request->ConfirmDocApp_Con != NULL) || ($data->ConfirmApp_Con == NULL && $request->ConfirmApp_Con != NULL) || ($data->Date_BookSpecial == NULL && $request->Date_BookSpecial != NULL) || ($data->ConfirmDocApp_Con == NULL && $request->ConfirmDocApp_Con != NULL) || $request->cancel_app != NULL) { //อนุมัติโอนเงิน

                        //อนุมัติไม่ใช่เช่าซื้อ
                        //เช่าซื้อ
                        //โอนปิดบัญชี
                        //ได้รับเล่ม
                        $dataArray = $subject . $link_acc . $one_drive;
                        // $dataArray = [

                        $eventPost = event(new MsTeamsEvent(@$data->id, $user_name, $password, $user_approve, $password_approve, $nameTag, $group_id, $teams_chanel, $data->Msteams_Id, $dataArray, $type_team, 'replies'));
                        $post = true;

                    }

                    if ($post == true) {
                        if ($data->DocApp_Con == NULL && $request->DocApp_Con != NULL) {
                            $data->DocApp_Con = $request->DocApp_Con;
                            $data->DateDocApp_Con = date('Y-m-d H:i:s');
                            $data->Status_Con = "pending";
                            $data->StatusApp_Con = "รออนุมัติ";
                            //  $data->Msteams_Id = $id_teams;
                            $data->MI_label = @$miData->label;
                            $data->MI_probability = @$miData->probability;
                            $data->update();

                            $value = $data->ContractToUserApp->name;
                            $idText = 'DocApp_Con';
                            $alerttxt = 'ขออนุมัติเรียบร้อย';

                        } elseif ($data->ConfirmDocApp_Con == NULL && $request->ConfirmDocApp_Con != NULL) {
                            $data->ConfirmDocApp_Con = $request->ConfirmDocApp_Con;
                            $data->DateConfirmDocApp_Con = date('Y-m-d H:i:s');
                            $data->update();

                            $idText = "ConfirmDocApp_Con";
                            $alerttxt = 'อนุมัติสัญญาเรียบร้อย';
                            $value = $data->ContractToFirmApprove->name;

                        } elseif ($data->ConfirmApp_Con == NULL && $request->ConfirmApp_Con != NULL) {
                            $data->ConfirmApp_Con = $request->ConfirmApp_Con;
                            $data->DateConfirmApp_Con = date('Y-m-d H:i:s');
                            $data->Status_Con = "complete";
                            $data->StatusApp_Con = "อนุมัติ";
                            $data->update();

                            $value = $data->ContractToConfirmApp->name;
                            $idText = 'ConfirmApp_Con';
                            $alerttxt = 'อนุมัติสัญญาเรียบร้อย';


                            // save

                            if (@$request->page == 'DocumentsApprove') {
                                $chkListChk = Pact_Checklists::where('PactCon_id', $id)->first();
                                $chkListChk->StatusApprove = 'Y';
                                $chkListChk->statusDoc = 'Pass';
                                $chkListChk->update();
                            }

                        } elseif ($data->Date_BookSpecial == NULL && $request->Date_BookSpecial != NULL) {
                            $data->BookSpecial_Trans = $request->Date_BookSpecial;
                            $data->LinkBookSpecial = $request->LinkBookSpecial;
                            $data->Date_BookSpecial = date('Y-m-d H:i:s');
                            $data->update();

                            $value = date('Y-m-d');
                            $idText = 'Date_BookSpecial';
                            $alerttxt = 'บันทึกรับเล่มทะเบียนเรียบร้อย';
                        } elseif ($request->cancel_app != NULL) {

                            $value = $request->cancel_app;
                            $idText = 'cancel_app';
                            $alerttxt = 'ยกเลิกขออนุมัติเรียบร้อย';


                        }
                        $dataCon = Pact_Contracts::where('id', $id)->first();
                        $data = $dataCon;
                        // $arrRole = ['administrator', 'superadmin', 'supervisor', 'manager', 'finances'];
                        $arrRole = $this->checkRoleEditLoansList(@$data->Status_Con);

                        $Approve_Position = @$data->ContractToUserApprove->getRoleNames();
                        $Approve = $Approve_Position->filter(function ($item) use ($arrRole) {
                            return in_array($item, $arrRole);
                        });


                        $htmlHeader = view('frontend.content-con.view-headerCon', compact('data'))->render();
                        $html = view('frontend.content-con.section-approve.view-approve', compact('data', 'Approve'))->render();
                        $tab = 'section-contract';
                        $renderTab = view('frontend.content-con.view-tab', compact('data', 'tab'))->render();
                        return response()->json(['status' => 'success', 'text' => $alerttxt, 'textValue' => $value, 'id' => $idText, 'html' => $html, "htmlHeader" => $htmlHeader, "renderTab" => $renderTab]);
                        //update
                    } else {
                        return response()->json(['status' => 'error', 'text' => 'กรุณาติดต่อ กับผู้ดูเเลระบบ โปรตรวจสอบ USER PASSWORD ' . $post, 'user' => '']);
                    }
                } else {
                    return response()->json(['status' => 'error', 'text' => 'สัญญานี้ถูกยกเลิกเเล้ว', 'user' => '']);
                }

            } elseif ($request->type == 'checker') {   //checker

                DB::beginTransaction();
                try {
                    $data = Pact_Contracts::where('id', $id)->first();
                    if ($data->Date_Checkers == NULL && $request->Checkers_Con != NULL) {  //Checkers
                        $data->Checkers_Con = $request->Checkers_Con;
                        $data->linkChecker = @$request->linkChecker;
                        $data->Date_Checkers = date('Y-m-d H:i:s');
                        $idText = "Checkers_Con";
                        $value = date('Y-m-d');
                        $text = 'บันทึกการลงพื้นที่เรียบร้อย';

                    }

                    $data->update();
                    // $arrRole = ['administrator', 'superadmin', 'supervisor', 'manager', 'finances'];
                    $arrRole = $this->checkRoleEditLoansList(@$data->Status_Con);

                    $Approve_Position = @$data->ContractToUserApprove->getRoleNames();
                    $Approve = $Approve_Position->filter(function ($item) use ($arrRole) {
                        return in_array($item, $arrRole);
                    });
                    DB::commit();
                    $eventLog = event(new LogDataContract(@$data->id, 'update', 'LogDataContract', 'update-' . $idText, $text . ' ID:' . $data->id, auth()->user()->id));
                    $tab = 'section-contract';
                    $htmlheader = view('frontend.content-con.view-headerCon', compact('data'))->render();
                    $html = view('frontend.content-con.section-approve.view-approve', compact('data', 'Approve'))->render();
                    $renderTab = view('frontend.content-con.view-tab', compact('data', 'tab'))->render();
                    return response()->json(['status' => 'success', 'html' => $html, 'htmlheader' => $htmlheader, 'renderTab' => $renderTab, 'text' => $text]);

                } catch (\Exception $e) {
                    DB::rollBack();
                }
            } elseif ($request->type == 'CheckBookCar') { // เช็คเล่ม
                DB::beginTransaction();
                try {
                    $data = Pact_Contracts::where('id', $id)->first();
                    if ($data->DateCheck_Bookcar == NULL && $request->DateCheck_Bookcar != NULL) {        //เช็คเล่ม
                        $data->Check_Bookcar = $request->DateCheck_Bookcar;
                        $data->LinkBookcar = $request->LinkBookcar;
                        $data->DateCheck_Bookcar = date('Y-m-d H:i:s');
                        $idText = "DateCheck_Bookcar";
                        $value = date('Y-m-d');
                        $text = 'เช็คเล่มทะเบียนเรียบร้อย';
                    }

                    $data->update();
                    // $arrRole = ['administrator', 'superadmin', 'supervisor', 'manager', 'finances'];
                    $arrRole = $this->checkRoleEditLoansList(@$data->Status_Con);
                    $Approve_Position = @$data->ContractToUserApprove->getRoleNames();
                    $Approve = $Approve_Position->filter(function ($item) use ($arrRole) {
                        return in_array($item, $arrRole);
                    });
                    DB::commit();
                    $eventLog = event(new LogDataContract(@$data->id, 'update', 'LogDataContract', 'update-' . $idText, $text . ' ID:' . $data->id, auth()->user()->id));
                    $tab = 'section-contract';
                    $htmlheader = view('frontend.content-con.view-headerCon', compact('data'))->render();
                    $html = view('frontend.content-con.section-approve.view-approve', compact('data', 'Approve'))->render();
                    $renderTab = view('frontend.content-con.view-tab', compact('data', 'tab'))->render();
                    return response()->json(['status' => 'success', 'html' => $html, 'htmlheader' => $htmlheader, 'renderTab' => $renderTab, 'text' => $text]);

                } catch (\Exception $e) {
                    DB::rollBack();
                }
            } elseif ($request->type == 'SpecialApprove') { // ขออนุมัติพิเศษ
                DB::beginTransaction();
                try {
                    $data = Pact_Contracts::where('id', $id)->first();
                    if ($data->DateSpecial_Bookcar == NULL && $request->DateSpecial_Bookcar != NULL) {  //ขออนุมัติพิเศษ
                        $data->BookSpecial_Type = @$request->BookSpecial_Type;
                        $data->Special_Bookcar = $request->DateSpecial_Bookcar;
                        $data->DateSpecial_Bookcar = date('Y-m-d H:i:s');
                        $idText = "DateSpecial_Bookcar";
                        $value = date('Y-m-d');
                        $text = 'ส่งขออนุมัติพิเศษเรียบร้อย';

                    }
                    $data->update();
                    // $arrRole = ['administrator', 'superadmin', 'supervisor', 'manager', 'finances'];
                    $arrRole = $this->checkRoleEditLoansList(@$data->Status_Con);
                    $Approve_Position = @$data->ContractToUserApprove->getRoleNames();
                    $Approve = $Approve_Position->filter(function ($item) use ($arrRole) {
                        return in_array($item, $arrRole);
                    });
                    DB::commit();
                    $eventLog = event(new LogDataContract(@$data->id, 'update', 'LogDataContract', 'update-' . $idText, $text . ' ID:' . $data->id, auth()->user()->id));
                    $tab = 'section-contract';
                    $SpApp = TB_SpecialTypeApp::getdata();
                    $htmlheader = view('frontend.content-con.view-headerCon', compact('data'))->render();
                    $html = view('frontend.content-con.section-approve.view-approve', compact('data', 'Approve'))->render();
                    $renderTab = view('frontend.content-con.view-tab', compact('data', 'tab', 'SpApp'))->render();
                    return response()->json(['status' => 'success', 'html' => $html, 'htmlheader' => $htmlheader, 'renderTab' => $renderTab, 'text' => $text]);

                } catch (\Exception $e) {
                    DB::rollBack();
                }
            }
        } else {
            $CodeLoan_Con = $dataPact->CodeLoan_Con;
            $FlagSpecial_Trans = $dataPact->FlagSpecial_Trans; // ปิดบัญชี
            $Date_BookSpecial = $dataPact->Date_BookSpecial; // รับเล่มทะเบียน
            $Code_Cus = @$dataPact->ContractToDataCusTags->TagToStatusCus->Code_Cus; // ประเภทลูกค้า
            $arrLoan = ['01', '16', '17', '18', '05', '07'];
            $arrStatus = ['active'];
            $FlagTransferFirst = false;
            $FlagTransferClose = false;
            $FlagTransfer = false;

            if (in_array($CodeLoan_Con, $arrLoan)) {
                $FlagTransferFirst = true;
            }

            if ($Code_Cus == 'CUS-0004') {
                $FlagTransferClose = true;
            }

            if (($FlagTransferFirst == true || $FlagTransferClose == true) && $Date_BookSpecial == NULL) {
                $FlagTransfer = true;
            } else {
                if (in_array($dataPact->Status_Con, $arrStatus) || $roleNum > 0) {
                    $FlagTransfer = true;
                } else {
                    $FlagTransfer = false;
                }
            }
            if ($FlagTransfer == true) {
                if ($request->func == 'saveExpenses') { // อัพเดทรายละเอียดค่าใช้จ่าย
                    DB::beginTransaction();
                    try {
                        $dataEXP = Pact_Operatedfees::find($id);
                        $this->saveExpenses($dataEXP, $request);

                        if (($request->Downpay_Price != NULL && $request->Downpay_Price > 0) && ($dataEXP->Downpay_Price == NULL || $dataEXP->Downpay_Price != $request->Downpay_Pricet)) {
                            $msTeams = auth()->user()->UserToMSTeams;
                            $teams_chanel = $msTeams->Teams_Chanel;
                            $group_id = $msTeams->Group_Id;
                            $type_team = $msTeams->Type_teams;
                            //user login
                            $user_name = auth()->user()->email;
                            $password = base64_decode(auth()->user()->password_teams);
                            $namePost = auth()->user()->name;
                            // $tokenUser = ConnectMSTeams::getTokenUser($user_name, $password);

                            //tag ผู้อนุมัติ
                            $user_approve = $dataEXP->OperatedToContract->ContractToUserApprove->email;
                            $password_approve = base64_decode($dataEXP->OperatedToContract->ContractToUserApprove->password_teams);
                            $nameTag = $dataEXP->OperatedToContract->ContractToUserApprove->name;
                            //$tokenUserTag = ConnectMSTeams::getTokenUser($user_approve,$password_approve);
                            // if ($tokenUser != false && $tokenUserTag != false) {

                            // $dis_user = $tokenUser->createRequest('GET', '/me')
                            //     ->setReturnType(Model\User::class)
                            //     ->execute();

                            //$ms_user = json_decode(json_encode($dis_user), true);

                            // $dis_app = $tokenUserTag->createRequest('GET', '/me')
                            //     ->setReturnType(Model\User::class)
                            //     ->execute();

                            //ข้อมูล tag
                            // $ms_tag = json_decode(json_encode($dis_app), true);


                            $subject = "ได้รับเงินดาวน์ จำนวน (" . $request->Downpay_Price . ") เรียบร้อยแล้ว  (" . $dataEXP->OperatedToContract->ContractToTypeLoan->Loan_Name . ") " . $dataEXP->OperatedToContract->Contract_Con . "   " . $dataEXP->OperatedToContract->ContractToCus->Name_Cus . " สาขา" . $dataEXP->OperatedToContract->ContractToBranch->Name_Branch . " วันที่ " . date('d-m-Y');
                            $dataArray = $subject;
                            // $dataArray = [
                            //     "body" => [
                            //         "contentType" => "html",
                            //         "content" => "<at id='0'>" . $ms_tag['displayName'] . "</at> " . $subject
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

                            $eventPost = event(new MsTeamsEvent(@$dataEXP->OperatedToContract->id, $user_name, $password, $user_approve, $password_approve, $nameTag, $group_id, $teams_chanel, $dataEXP->OperatedToContract->Msteams_Id, $dataArray, $type_team, 'replies'));
                            // try{


                            //     $post_ms = $tokenUser->createRequest('POST', '/teams/'.$group_id.'/channels/'.$teams_chanel.'/messages/'.$dataEXP->OperatedToContract->Msteams_Id.'/replies')
                            //         ->attachBody($dataArray)
                            //         ->setReturnType(Model\User::class)
                            //         ->execute();
                            //     $postdown = "success";
                            // }catch (\Exception $e) {
                            //     $postdown = "error";

                            // }


                            // }

                        }


                        DB::commit();
                        $eventLog = event(new LogDataContract(@$request->PactCon_id, 'update', 'LogExpensesContract', 'update-Expenses', 'แก้ไขรายละเอียดค่าใช้จ่าย ID:' . $dataEXP->id, auth()->user()->id));
                        $data = Pact_Operatedfees::where('PactCon_id', $request->PactCon_id)->first();
                        $html = view('frontend.content-con.section-expenses.view-expens', compact('data'))->render();
                        return response()->json(['html' => $html]);

                        // เพิ่ม teams

                    } catch (\Exception $e) {
                        DB::rollBack();
                    }
                }
            } else {
                if ($dataPact->Status_Con == 'pending') {
                    $text = 'กรุณายกเลิกการขออนุมัติก่อนทำการ แก้ไขข้อมูล';
                } else {
                    $text = '';
                }
                return response(['error' => true, 'message' => 'ไม่สามารถแก้ข้อมูลได้ ! ในขณะสัญญา "' . $dataPact->StatusApp_Con . '"', "text" => $text], 500);
            }

        }

    }

    public function destroy(Request $request, $id)
    {
        $roleNum = 0;
        $userArr = ['administrator', 'audit', 'manager', 'supervisor'];
        $userRole = auth()->user()->getRoleNames();
        $chkRole = $userRole->filter(function ($item) use ($userArr) {
            return in_array($item, $userArr);
        });
        $roleNum = count($chkRole);
        $dataPact = Pact_Contracts::where('id', $request->PactCon_id)->first();
        if (($dataPact->Status_Con == 'active' || $roleNum > 0)) {
            if ($request->funs == 'removeGuaran') {
                $tab = 'section-guarantor';
                Pact_ContractsGuarantor::where('id', $id)->delete();
                Pact_ContractsGuar_Assets::where('Guarantor_id', $id)->where('PactCon_id', $request->PactCon_id)->delete();
                $data = Pact_ContractsGuarantor::where('PactCon_id', $request->PactCon_id)->get();
                $returnHTML = view('frontend.content-con.section-guaran.view-guaran', compact('data'))->render();
                $data = Pact_Contracts::where('id', $request->PactCon_id)->first();
                $renderTab = view('frontend.content-con.view-tab', compact('data', 'tab'))->render();
                $eventLog = event(new LogDataContract(@$data->id, 'delete', 'LogGuarantorContract', 'delete-Guarantor', 'ลบผู้ค้ำออกจากสัญญา ID:' . $id, auth()->user()->id));
                return response()->json(['html' => $returnHTML, 'renderTab' => $renderTab]);
            } elseif ($request->func == 'removePayee') {
                Pact_ContractPayee::find($id)->delete();
                $tab = 'section-Payee';
                $dataPay = Pact_ContractPayee::where('PactCon_id', $request->PactCon_id)->get();
                $returnHTML = view('frontend.content-con.section-payee.view-payee', compact('dataPay'))->render();
                $data = Pact_Contracts::where('id', $request->PactCon_id)->first();
                $renderTab = view('frontend.content-con.view-tab', compact('data', 'tab'))->render();
                $eventLog = event(new LogDataContract(@$data->id, 'delete', 'LogPayeeContract', 'delete-Payee', 'ลบผู้รับเงินออกจากสัญญา ID:' . $id, auth()->user()->id));
                return response()->json(['html' => $returnHTML, 'renderTab' => $renderTab]);
            } elseif ($request->func == 'removeBroker') {
                //  Pact_ContractBrokers::onlyTrashed()->find($id)->restore();
                //  dd(Pact_ContractBrokers::onlyTrashed()->get());
                // dd(Pact_ContractBrokers::withTrashed()->get());
                Pact_ContractBrokers::find($id)->delete();
                $tab = 'section-Broker';
                $com = TB_Commission::where('status', 'active')->get();
                $data = Pact_ContractBrokers::where('PactCon_id', $request->PactCon_id)->get();
                $returnHTML = view('frontend.content-con.section-broker.view-Broker', compact('data', 'com'))->render();
                $data = Pact_Contracts::where('id', $request->PactCon_id)->first();
                $renderTab = view('frontend.content-con.view-tab', compact('data', 'tab'))->render();
                $eventLog = event(new LogDataContract(@$data->id, 'delete', 'LogBrokerContract', 'delete-Broker', 'ลบผู้แนะนำออกจากสัญญา ID:' . $id, auth()->user()->id));
                return response()->json(['html' => $returnHTML, 'renderTab' => $renderTab]);
            } elseif ($request->func == 'removeAsset') {
                Pact_Indentures_Assets::where('PactCon_id', $request->PactCon_id)->where('Asset_id', $id)->delete();
                $tab = 'section-Asset';
                $data = Pact_Indentures_Assets::where('PactCon_id', $request->PactCon_id)->get();
                $returnHTML = view('frontend.content-con.section-asset.view-asset', compact('data'))->render();
                $data = Pact_Contracts::where('id', $request->PactCon_id)->first();
                $renderTab = view('frontend.content-con.view-tab', compact('data', 'tab'))->render();
                $eventLog = event(new LogDataContract(@$data->id, 'delete', 'LogAssetContract', 'delete-Asset', 'ลบทรัพย์ออกจากสัญญา ID:' . $id, auth()->user()->id));

                // Flag กลับไปอัพเดทสถานะการใช้งานทรัพย์
                $Owner = Data_AssetsOwnership::where('id', $id)->first();
                $Owner->State_Ownership = 'Active';
                $Owner->update();

                return response()->json(['html' => $returnHTML, 'renderTab' => $renderTab]);
            }
        } else {
            if ($dataPact->Status_Con == 'pending') {
                $text = 'กรุณายกเลิกการขออนุมัติก่อนทำการ แก้ไขข้อมูล';
            } else {
                $text = '';
            }
            return response(['error' => true, 'message' => 'ไม่สามารถแก้ข้อมูลได้ ! ในขณะสัญญา "' . $dataPact->StatusApp_Con . '"', "text" => $text], 500);
        }
    }
    private function saveExpenses($data, $request)
    { // for save and update
        $data->AccountClose_Price = str_replace(',', '', $request->AccountClose_Price);
        $data->AccountClose_Price_fee = str_replace(',', '', $request->AccountClose_Price_fee);
        $data->P2_Price = str_replace(',', '', $request->P2_Price);
        $data->Insurance_PA = str_replace(',', '', $request->Insurance_PA);
        $data->Act_Price = str_replace(',', '', $request->Act_Price);
        $data->Tax_Price = str_replace(',', '', $request->Tax_Price);
        $data->Tran_Price = str_replace(',', '', $request->Tran_Price);
        $data->Other_Price = str_replace(',', '', $request->Other_Price);
        $data->Evaluetion_Price = str_replace(',', '', $request->Evaluetion_Price);
        $data->Duty_Price = str_replace(',', '', $request->Duty_Price);
        $data->Marketing_Price = str_replace(',', '', $request->Marketing_Price);
        $data->Downpay_Price = str_replace(',', '', $request->Downpay_Price);
        $data->DuePrepaid_Price = str_replace(',', '', $request->DuePrepaid_Price);
        $data->Process_Price = str_replace(',', '', $request->Process_Price);
        $data->Total_Price = str_replace(',', '', $request->Total_Price);
        $data->Balance_Price = str_replace(',', '', $request->Balance_Price);
        $data->transferCash = 0;
        $data->AccountClose_Place = $request->AccountClose_Place;
        $data->Installment = $request->Installment;
        $data->Note_fee = str_replace(',', '', $request->Note_fee);
        $data->ReceiveCashBefore = str_replace(',', '', @$request->ReceiveCashBefore);
        $data->LastTransfer = @$request->LastTransfer;
        $data->UserZone = auth()->user()->zone;
        $data->UserBranch = auth()->user()->branch;
        $data->UserInsert = auth()->user()->id;
        $data->save();
    }

    private function alertTeams($id, $status, $textSpecialApp)
    {
        $textSpecialApp = $textSpecialApp != NULL ? $textSpecialApp : " ";
        $data = Pact_Contracts::where('id', $id)->first();
        $codeLoan = $data->ContractToTypeLoan->Loan_Group;

        if ($status == 'pending') {
            $getUser = User::whereIn('id', explode(',', $data->UserApp_relevant . "," . $data->UserApp_Con))->get();
            $link = "<br/>" . 'รายการขออนุมัติ ' . "<a href='" . url('/') . "/contract/" . $data->id . "/edit?funs=contract&loanCode=" . $data->CodeLoan_Con . "'>คลิ๊ก</a>";

        } elseif ($status == 'approve') {
            $getUser = User::where('zone', auth()->user()->zone)
                ->whereHas('roles', function ($query) {
                    $query->whereIn('name', ['financial-inside']);
                })->limit(1)->get();
            $link = "<br/>" . 'รายการขออนุมัติ ' . "<a href='" . url('/') . "/contract/" . $data->id . "/edit?funs=contract&loanCode=" . $data->CodeLoan_Con . "'>คลิ๊ก</a>";

        } elseif ($status == 'transfer') {
            $getUser = User::where('id', $data->UserSent_Con)->get();
            $codeLoan = NULL;
            $link = "<br/> การเงินโอนยอด" . "<a href='" . url('/') . "/view?page=financial-approval" . "'>คลิ๊ก</a>";

        } elseif ($status == 'cancel') {
            $getUser = User::whereIn('id', explode(',', $data->UserApp_relevant))->get();
            $link = "<br/>" . 'รายการขออนุมัติ ' . "<a href='" . url('/') . "/contract/" . $data->id . "/edit?funs=contract&loanCode=" . $data->CodeLoan_Con . "'>คลิ๊ก</a>";
            $codeLoan = NULL;

            // update Pact
            $data->DocApp_Con = null;
            $data->DateDocApp_Con = null;
            $data->Status_Con = 'active';
            $data->StatusApp_Con = 'สร้างสัญญา';
            $data->update();

        }
        $one_drive = '<br/> เอกสารแนบ ' . "<a href='" . $data->LinkUpload_Con . "' >คลิ๊ก</a>";
        // get meaage
        $AlertTeams = TB_AlertTeams::where('Status', $status)->where('CodeLoan', @$codeLoan)->first();


        $msTeams = auth()->user()->UserToMSTeams;
        $teams_chanel = $msTeams->Teams_Chanel;
        $group_id = $msTeams->Group_Id;

        if (true) {
            $subject = str_replace(
                ['%TypeName', '%Contno', '%NameCus', '%Branch', '%Date', '%txtSpecial'],
                [
                    $data->ContractToTypeLoan->Loan_Name,
                    $data->Contract_Con,
                    $data->ContractToDataCusTags->TagToDataCus->Name_Cus,
                    $data->ContractToBranch->Name_Branch,
                    date('d-m-Y'),
                    @$textSpecialApp
                ],
                $AlertTeams->message
            );
        }

        $dataArrayAtt = [];
        $createArray = [];
        $mentions = [];
        $dataArray = '';
        $check = true;

        foreach ($getUser as $key => $item) {
            $dataArray .= '<at id="' . $key . '">' . $item->name . '</at> ';
            $tokenUser = ConnectMSTeams::getTokenUser($item->email, base64_decode($item->password_teams));

            if ($tokenUser == false) {
                $check = false;
                break;
            }

            $dis_app = $tokenUser->createRequest('GET', '/me')
                ->setReturnType(Model\User::class)
                ->execute();
            $ms_tag = json_decode(json_encode($dis_app), true);


            $createArray = [
                "id" => $key,
                "mentionText" => $item->name,
                "mentioned" => [
                    "user" => [
                        "displayName" => $ms_tag['displayName'],
                        "id" => $ms_tag['id'],
                        "userIdentityType" => "aadUser"
                    ]
                ]
            ];
            array_push($mentions, $createArray);

        }

        $dataArrayAtt['mentions'] = $mentions;
        $dataArrayAtt['body'] = [
            "contentType" => "html",
            "content" => $dataArray . $subject . $link . $one_drive
        ];


        if ($check) {
            // เช็คว่าโพสหรือว่าคอมเม้น
            if ($data->Msteams_Id == NULL) {
                try {
                    $UserBranch = @$data->ContractToUserBranch->email;
                    $password_Branch = base64_decode(@$data->ContractToUserBranch->password_teams);
                    // $tokenUserPost = ConnectMSTeams::getTokenUser($UserBranch,$password_Branch);
                    $tokenUserPost = ConnectMSTeams::getTokenUser(auth()->user()->email, base64_decode(auth()->user()->password_teams));
                    $post_ms = $tokenUserPost->createRequest('POST', '/teams/' . $group_id . '/channels/' . $teams_chanel . '/messages')
                        ->attachBody($dataArrayAtt)
                        ->setReturnType(Model\User::class)
                        ->execute();
                    $dataPost = json_decode(json_encode($post_ms), true);
                    $id_teams = $dataPost['id'];  //id post เก็บลงฐาน
                    $data = Pact_Contracts::where('id', $id)->first();
                    $data->Msteams_Id = $id_teams;
                    $data->update();

                } catch (\Exception $e) {
                    $postdown = $e->getMessage();
                }
            } else {
                try {
                    $tokenUserRepired = ConnectMSTeams::getTokenUser(auth()->user()->email, base64_decode(auth()->user()->password_teams));
                    $post_ms = $tokenUserRepired->createRequest('POST', '/teams/' . $group_id . '/channels/' . $teams_chanel . '/messages/' . $data->Msteams_Id . '/replies')
                        ->attachBody($dataArrayAtt)
                        ->setReturnType(Model\User::class)
                        ->execute();
                    $postdown = "success";
                } catch (\Exception $e) {
                    $postdown = $e->getMessage();

                }
            }
        } else {
            return response(['error' => true, 'message' => 'ดำเนินการได้ !'], 500);
        }
        return true;
    }
}
