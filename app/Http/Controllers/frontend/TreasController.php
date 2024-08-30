<?php

namespace App\Http\Controllers\frontend;

use App\Events\frontend\LogDataContract;
use App\Events\frontend\MsTeamsEvent;
use ChubbApiRequest;
use App\Models\TB_Assets\Data_AssetsOwnership;
use App\Models\TB_Constants\TB_Frontend\TB_Company;
use App\Models\TB_DataCus\Data_Customers;
use App\Models\TB_PactContracts\Pact_Indentures_Assets;
use ConnectMSTeams;
use Microsoft\Graph\Model;
use Illuminate\Http\Request;

use App\Models\TB_Constants\TB_Frontend\TB_TypeLoanCom;
use App\Models\TB_Constants\TB_Frontend\TB_BankAccounts;
use App\Models\TB_Constants\TB_Frontend\TB_TypeLoan;
use App\Models\TB_Constants\TB_Frontend\Data_CreditBanks;

use App\Models\TB_PactContracts\Data_AgentInsurance;
use App\Models\TB_PactContracts\Pact_ContractBrokers;
use App\Models\TB_PactContracts\Pact_ContractPayee;
use App\Models\TB_PactContracts\Pact_CreditBanks;
use App\Models\TB_PactContracts\Pact_Operatedfees;
use App\Models\TB_PactContracts\Pact_Contracts;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use DB;

// trait
use App\Traits\TreasDetectionLimits;


class TreasController extends Controller
{

    use TreasDetectionLimits;
    public function index(Request $request)
    {
        if ($request->page == 'view') {
            $user_zone = auth()->user()->zone;
            $statusTxt = $request->statusTxt;
            $StatusCon = NULL;
            $loanCode = NULL;
            $page = 'view';
            $Fdate1 = @$request->start;
            $Tdate1 = @$request->end;
            $id = @$request->id;
            $loan = $request->type_loan;
            $start = date_create($Fdate1);
            $Fdate = ($Fdate1 != NULL) ? date_format($start, 'Y-m-d') : date('Y-m-d');
            $end = date_create($Tdate1);
            $Tdate = ($Tdate1 != NULL) ? date_format($end, 'Y-m-d') : date('Y-m-d');

            $typeLoan = TB_TypeLoanCom::generateQuery();
            $loantype = array();

            foreach ($typeLoan as $loan) {
                $loantype[$loan->Loan_Code] = $loan->Loan_Group;
            }

            $credit_Balance = Data_CreditBanks::where('Bank_Zone', $user_zone)
                ->where('Date_CreditIn', date('Y-m-d'))->get();

            // $data = DB::table('View_ContractCon')
            // ->select('Approve_monetary','ConfirmApp_Con','ConfirmDocApp_Con','DocApp_Con',
            // 'Date_con','DateCheck_Bookcar', 'id', 'Contract_Con', 'Loan_Name','Date_monetary','Name_Cus',
            // 'licence','cash','id_rateType','brand', 'image_cus','Name_Branch','DateConfirmApp_Con')
            // ->where('UserZone', $user_zone)
            // ->when(!empty($Fdate) && !empty($newtdate), function ($q) use ($Fdate, $Tdate) {
            //     return $q->whereBetween(DB::raw(" FORMAT (cast(DateConfirmApp_Con as date), 'yyyy-MM-dd')"),[$Fdate, $Tdate]);
            // })
            // ->where('StatusApp_Con' ,'=', 'อนุมัติ')
            // ->get();
            // $data =  collect(DB::select("select d.Loan_Com,sum(b.Balance_Price) as price,sum(c.Commission_Broker_Prices) as broker_price,count(a.Contract_Con) as count_con from Pact_Contracts a
            // left join [dbo].[Pact_Operatedfees] b on a.id = b.PactCon_id
            // left join [dbo].[Pact_ContractBrokers] c on a.id = c.PactCon_id
            // left join TB_TypeLoans d on a.CodeLoan_Con = d.Loan_Code
            // where  FORMAT (cast(a.DateConfirmApp_Con as date), 'yyyy-MM-dd') between '".$Fdate."' and '".$Tdate."'
            // and a.UserZone ='".$user_zone."'
            // group by d.Loan_Com"))->keyBy('Loan_Com');

            @$data = Pact_Contracts::limit(50)->get();

            return view('frontend.content-treas.view', compact('data', 'Fdate1', 'Tdate1', 'statusTxt', 'StatusCon', 'loanCode', 'page'));
        }
    }

    public function create(Request $request)
    {
        if ($request->page == 'transfer') {
            $checkCom = NULL;
            $is_flag = false;    //active redirect modal
            $checkCom = null;
            $data = Pact_Contracts::find($request->id);
            $CodeLoan_Con = $data->CodeLoan_Con;
            $FlagSpecial_Trans = $data->FlagSpecial_Trans; // ปิดบัญชี
            $Date_BookSpecial = $data->Date_BookSpecial; // รับเล่มทะเบียน
            $Code_Cus = @$data->ContractToDataCusTags->TagToStatusCus->Code_Cus; // ประเภทลูกค้า
            $SearchClose = $data->ContractToPayee->filter(function ($query) {
                return $query->status_Payee == 'CloseAcount';
            })->first();

            if ($SearchClose != NULL) {
                $checkCom = TB_Company::where('Company_Id', $SearchClose->PayeetoCus->IDCard_cus)
                    ->where('Company_Zone', $SearchClose->PayeetoCus->UserZone)
                    ->first();
            }
            $FlagTransfer = $this->checkPayee($CodeLoan_Con, $Date_BookSpecial, $FlagSpecial_Trans, $Code_Cus); // เช็คผู้รับเงิน
            $bankAccount = DB::table('View_BankBalance')->where('User_Zone', auth()->user()->zone)->where('company_type', $data->ContractToTypeLoan->Loan_Com)->get();
            $DatabankAccount = $bankAccount;
            return view('frontend.content-treas.view-transfer', compact('data', 'bankAccount', 'is_flag', 'FlagTransfer', 'DatabankAccount', 'checkCom'));
        } elseif ($request->page == 'addCredit') {
            $bankAccount = TB_BankAccounts::where('User_Zone', auth()->user()->zone)
                ->where('company_type', $request->com)
                ->where('Flag_Bank', 'yes')
                ->get();

            return view('frontend.content-treas.addCredit', compact('bankAccount'));
        } elseif ($request->page == 'history-transfer') {

            return view('frontend.content-treas.history-transfer');
        } elseif ($request->page == 'show-transfer') {
            $typeloan = $request->typeloan;
            $Fdate = date("Y-m-d", strtotime($request->fdate));
            $Tdate = date("Y-m-d", strtotime($request->tdate));

            $data = DB::table('View_ContractAuditEx1')
                ->where('UserZone', auth()->user()->zone)
                ->whereNotNull('nameConfirm')
                ->whereNotIn('Status_Con', ['cancel', 'close'])
                ->whereNotNull('Date_Approve_tranfers')
                ->when(!empty($typeloan), function ($q) use ($typeloan) {
                    return $q->where('Loan_Com', $typeloan);
                })
                ->when(!empty($Fdate) && !empty($Tdate), function ($q) use ($Fdate, $Tdate) {
                    return $q->whereBetween(DB::raw('CONVERT(date, Date_monetary)'), [$Fdate, $Tdate]);
                })
                ->get();

            $uniqueLoanCode = $data->unique('Loan_Code')->pluck('Loan_Code')->toArray();
            $typeloans = TB_TypeLoan::whereIn('Loan_Code', $uniqueLoanCode)
                ->select('id', 'Loan_Code', 'Loan_Name')
                ->get();

            $view = view('frontend.content-treas.data-history', compact('data', 'typeloans'))->render();
            return response()->json(['html' => $view]);
        }
    }

    public function store(Request $request)
    {
        if ($request->page == 'manage-credit') {
            $transferResultBroker = NULL;
            $transferResult = NULL;
            $subject = NULL;

            if ($request->TransactionDetail == 'withdraw' || $request->TransactionDetail == 'withdraw-credit') {
                $expenses = ($request->expenses) * (-1);
            } else {
                $expenses = $request->expenses;
            }

            $bankAccount = TB_BankAccounts::where('id', $request->Bank_id)
                ->where('User_Zone', auth()->user()->zone)
                ->first();
            if ($request->status == 'Payee' || $request->status == 'CloseAcount' || $request->status == 'Broker') {
                $Credits = $this->checkCreditTransfer($request->Bank_id, $expenses);
                if ($Credits and $Credits != "notEnough") {
                    $totalBalance = $Credits['totalBalance'];
                    $Bank_Zone = $Credits['Bank_Zone'];
                    $data = Pact_Contracts::find($request->pact_id);

                    $result = $this->manageCredittransfer($data, $expenses, $request, $bankAccount);

                    return response(['error' => $result['error'], 'contents' => $result['contents'], 'title' => $result['title'], 'message' => $result['message']], $result['code']);
                } elseif ($Credits == "notEnough") {
                    return response(['error' => true, 'contents' => null, 'title' => 'ยอดไม่เพียงพอ (Insufficient funds)', 'message' => 'กรุณาตรวจสอบยอดเครติด หรือเพิ่มเครดิตของบัญชี. !'], 500);
                } else {
                    return response(['error' => true, 'contents' => null, 'title' => 'ไม่พบข้อมูล (Not found)', 'message' => 'ไม่สามารถทำรายการได้ กรุณาตรวจสอบใหม่อีกครั้ง. !'], 500);
                }
            } else {
                DB::beginTransaction();
                try {
                    $dataCreditBanks = $this->CreditBanks($request, $expenses, $bankAccount);

                    DB::commit();
                    $flag = true;
                    $banktransaction = $bankAccount->BankToCreditMany;
                    $viewTran = view('frontend.content-treas.tab-transaction', compact('banktransaction', 'flag'))->render();
                    return response()->json(['Amount_after' => $dataCreditBanks->Amount_after, 'viewTran' => $viewTran, 'idBank' => $bankAccount->id], 200);
                } catch (\Exception $e) {
                    DB::rollback();
                    return response(['error' => true, 'message' => $e->getMessage()], 500);
                }
            }
        }
    }

    public function show(Request $request, $id)
    {
        if ($request->funs == 'show-transferCont') {
            $is_flag = true;    //active redirect modal
            $checkCom = NULL;
            $data = Pact_Contracts::find($id);

            $SearchClose = $data->ContractToPayee->filter(function ($query) {
                return $query->status_Payee == 'CloseAcount';
            })->first();

            if ($SearchClose != NULL) {
                $checkCom = TB_Company::where('Company_Id', $SearchClose->PayeetoCus->IDCard_cus)->first();
            }

            $bankAccount = TB_BankAccounts::where('User_Zone', auth()->user()->zone)->get();
            $DatabankAccount = DB::table('View_BankBalance')->where('User_Zone', auth()->user()->zone)->where('company_type', $data->ContractToTypeLoan->Loan_Com)->get();

            return view('frontend.content-treas.view-transfer', compact('data', 'bankAccount', 'is_flag', 'DatabankAccount', 'checkCom'));

        } elseif ($request->funs == 'getTransaction') {
            $date = date_create($request->dateTran);
            $banktransaction = Pact_CreditBanks::where('Bank_id', $request->Bankid)
                // ->whereBetween('transactionDate',[ date_create($request->date) , date('Y-m-d') ])
                ->when($request->dateTran, function ($q) use ($date) {
                    return $q->whereBetween('transactionDate', [$date, date('Y-m-d')]);
                })
                ->orderBy('id', 'DESC')
                ->get();

            $flag = true;
            $html = view('frontend.content-treas.tab-transaction', compact('banktransaction', 'flag'))->render();
            return response()->json(['html' => $html]);
        }
    }

    public function edit($id, Request $request)
    {
        //
    }

    public function update(Request $request, $id)
    {
        if ($request->fun == 'editMemo') {
            $data = Pact_CreditBanks::find($id);
            if ($data->Memo != @$request->Memo) { // เช็คค่าซ้ำ
                $data->Memo = @$request->Memo;
                $data->update();
            }
            return response()->json(['Memo' => @$request->Memo]);
        }elseif ($request->fun =='reject') {

            $data = Pact_Contracts::find($id);             

                    DB::beginTransaction();
                    try {

                        // เคลียร์ข้อมูลใน Pact
                        
                        $data->ConfirmApp_Con = null;
                        $data->DateConfirmApp_Con = null;
                        $data->Status_Con = 'pending';
                        $data->StatusApp_Con = 'รออนุมัติ';
                        $data->update();

                        DB::commit();
                        $subject = "ยกเลิกการโอนเงินข้อมูลผิด รอตรวจสอบอีกครั้ง";
                        $link_acc = "";
                        $one_drive = "";
                        // $tokenUserTag = ConnectMSTeams::getTokenUser($user_approve, $password_approve);
                        $user_Tag = @$data->ContractToUserApprove->email;
                        $password_Tag = base64_decode(@$data->ContractToUserApprove->password_teams);
                        $nameTag = @$data->ContractToUserApprove->name;
                        $Msteams_Id = $data->Msteams_Id;
    
                        $this->Teams($subject, $user_Tag, $password_Tag, $nameTag, $Msteams_Id);

                        $eventLog = event(new LogDataContract(@$data->id, 'reject', 'LogDataContract', '..', 'ยกเลิกการโอนเงินข้อมูลผิด', auth()->user()->id));
                        return 200;

                    } catch (\Exception $e) {
                        DB::rollBack();
                        return response(["error" => true , "message" => $e->getMessage()],500);
                    }

                
           
        }
    }

    public function destroy($id)
    {
        //
    }

    private function manageCredittransfer($data, $expenses, $request, $bankAccount)
    {
        switch ($request->status) {
            case 'Payee':
                DB::beginTransaction();
                try {

                    $transferPayee = $this->checktransferPayee($data);
                    if ($transferPayee == false) {
                        $render = ['error' => true, 'contents' => null, 'title' => 'ไม่สามารถดำเนินการได้', 'message' => 'กรุณาโอนยอดให้แก่ ผู้ปิดบัญชี ก่อนผู้รับเงิน. !', 'code' => 500];
                        return $render;
                    }
                    $dataPayee = $this->updateContractPayee($request, $expenses, $data->ContractToOperated->Balance_Price, $data->ContractToPayee);
                    if ($dataPayee['status'] == false) {
                        $render = ['error' => true, 'contents' => null, 'flag_transfer' => 'received', 'title' => 'ดำเนินการล้มเหลว', 'message' => $dataPayee['data']->PayeetoCus->Name_Cus . ' ได้รับการโอนเงินเรียบร้อยแล้ว. !', 'code' => 500];
                        return $render;
                    }

                    $FlagTransfer = $this->checkPayee($data->CodeLoan_Con, $data->Date_BookSpecial, $data->FlagSpecial_Trans, $data->Code_Cus);
                    if ($FlagTransfer == false) {
                        $render = ['error' => true, 'contents' => null, 'title' => 'ไม่สามารถดำเนินการได้', 'message' => 'สัญญานี้ยังไม่ได้ระบุ ได้รับเล่มหรือเอกสาร กรุณาตรวจสอบใหม่อีกครั้ง.', 'code' => 500];
                        return $render;
                    }

                    $this->updateOperatedfees($data, $expenses, $request);
                    $contents = null;
                    $tranferbalance = $this->checktransferBalance($data);
                    if ($tranferbalance == true) {
                        $this->ProcessDueDate($data, $request);
                        $contents = $data->id;
                    }



                    $user_Tag = $data->ContractToUserBranch->email;
                    $password_Tag = base64_decode($data->ContractToUserBranch->password_teams);
                    $nameTag = $data->ContractToUserBranch->name;
                    $Msteams_Id = $data->Msteams_Id;

                    $subject = "การเงิน โอนเงินเรียบร้อย (" . $data->ContractToTypeLoan->Loan_Name . ") " . $data->Contract_Con . "   " . $data->ContractToDataCusTags->TagToDataCus->Name_Cus . " สาขา" . $data->ContractToBranch->Name_Branch . " วันที่ " . date('d-m-Y');
                    $this->CreditBanks($request, $expenses, $bankAccount);

                    DB::commit();
                    $this->Teams($subject, $user_Tag, $password_Tag, $nameTag, $Msteams_Id);
                     event(new LogDataContract(@$data->id, 'update', 'LogDataContract', '..', 'การเงิน โอนเงินเรียบร้อย', auth()->user()->id));
                    $render = ['error' => false, 'contents' => $contents, 'title' => 'สำเร็จ !', 'message' => 'โอนเงินผู้รับ ' . $dataPayee['data']->PayeetoCus->Name_Cus . ' เรียบร้อย.', 'code' => 200];
                    return $render;
                } catch (\Throwable $e) {
                    DB::rollback();

                    $render = ['error' => true, 'contents' => null, 'title' => 'ล้มเหลว !', 'message' => 'ดำเนินการไม่สำเร็จ กรุณาลองใหม่อีกครั้ง.', 'code' => 500];
                    return $render;
                }
                break;
            case 'CloseAcount':
                DB::beginTransaction();
                try {
                    $dataPayee = $this->updateContractPayee($request, $expenses, $data->ContractToOperated->AccountClose_Price, null);
                    if ($dataPayee['status'] == false) {
                        $render = ['error' => true, 'contents' => null, 'title' => 'ดำเนินการล้มเหลว', 'message' => $dataPayee['data']->PayeetoCus->Name_Cus . ' ได้รับการโอนเงินเรียบร้อยแล้ว. !', 'code' => 500];
                        return $render;
                    }

                    $user_Tag = $data->ContractToUserBranch->email;
                    $password_Tag = base64_decode($data->ContractToUserBranch->password_teams);
                    $nameTag = $data->ContractToUserBranch->name;
                    $Msteams_Id = $data->Msteams_Id;

                    $subject = "การเงิน โอนเงิน ปิดบัญชี เรียบร้อย (" . $data->ContractToTypeLoan->Loan_Name . ") " . $data->Contract_Con . "   " . $data->ContractToDataCusTags->TagToDataCus->Name_Cus . " สาขา" . $data->ContractToBranch->Name_Branch . " วันที่ " . date('d-m-Y');

                    $contents = null;
                    $tranferbalance = $this->checktransferBalance($data);

                    if ($tranferbalance == true) {
                        $this->ProcessDueDate($data, $request);
                        $data = Pact_Contracts::find($request->pact_id);
                        $data->FlagSpecial_Trans = auth()->user()->id;
                        $data->Date_FlagSpecial = date('Y-m-d H:i:s');
                        $data->Bank_Close = @$request->Bank_id;
                        $data->update();

                        $contents = $data->id;
                    }

                    $this->CreditBanks($request, $expenses, $bankAccount);
                    DB::commit();
                    $this->Teams($subject, $user_Tag, $password_Tag, $nameTag, $Msteams_Id);
                     event(new LogDataContract(@$data->id, 'update', 'LogDataContract', '..', 'การเงิน โอนเงิน ปิดบัญชี เรียบร้อย', auth()->user()->id));

                    $render = ['error' => false, 'contents' => $contents, 'title' => 'สำเร็จ !', 'message' => 'โอนเงินให้ ' . $dataPayee['data']->PayeetoCus->Name_Cus . ' เรียบร้อย.', 'code' => 200];
                    return $render;
                } catch (\Throwable $e) {
                    DB::rollback();

                    $render = ['error' => true, 'contents' => null, 'title' => 'ล้มเหลว !', 'message' => 'ดำเนินการไม่สำเร็จ กรุณาลองใหม่อีกครั้ง.', 'code' => 500];
                    return $render;
                }
                break;
            case 'Broker':
                DB::beginTransaction();
                try {
                    $dataBRK = Pact_ContractBrokers::where('Broker_id', $request->CusID)->where('PactCon_id', $request->pact_id)->first();
                    $result = ($dataBRK->SumCom_Broker - ($dataBRK->transferCash + ($expenses * (-1))));
                    $contents = null;

                    if ($result == 0 and empty($dataBRK->Date_Brk_montary)) {
                        $dataBRK->transferCash = ($dataBRK->transferCash + ($expenses * (-1)));
                        $dataBRK->Date_Brk_montary = date('Y-m-d H:i:s');
                        $dataBRK->transferBank = $request->Bank_id;
                        $dataBRK->Pay_method = @$request->Pay_method;
                        $dataBRK->Person_Close = @$request->Person_Close;
                        $dataBRK->update();

                        $transferResultBroker = $data->ContractToBrokers->sum('SumCom_Broker') - $data->ContractToBrokers->sum('transferCash');
                        $transferResult = $this->checktransferBalance($data);

                        $data = Pact_Contracts::find($request->pact_id);
                        if ($transferResultBroker == 0 && $transferResult == true) {
                            $data->Date_Approve_tranfers = date('Y-m-d H:i:s');
                            $data->Commission_Trans = auth()->user()->id;
                            $data->Date_Commission = date('Y-m-d H:i:s');

                            $contents = $data->id;
                        } else {
                            $data->Commission_Trans = auth()->user()->id;
                            $data->Date_Commission = date('Y-m-d H:i:s');
                        }
                        $data->update();

                        $render = ['error' => false, 'contents' => $contents, 'title' => 'สำเร็จ !', 'message' => 'โอนเงินผู้แนะนำ ' . $dataBRK->BrokertoCus->Name_Cus . ' เรียบร้อย.', 'code' => 200];
                        $this->CreditBanks($request, $expenses, $bankAccount);
                    } else {
                        if ($result > 0) {
                            $dataBRK->transferCash = ($dataBRK->transferCash + ($expenses * (-1)));
                            $dataBRK->transferBank = $request->Bank_id;
                            $dataBRK->update();

                            $render = ['error' => false, 'contents' => null, 'title' => 'สำเร็จ !', 'message' => 'โอนเงินให้ผู้แนะนำ ' . $dataBRK->BrokertoCus->Name_Cus . 'จำนวน ' . $dataBRK->transferCash . ' บาท.', 'code' => 200];
                            $this->CreditBanks($request, $expenses, $bankAccount);
                        } else {
                            $render = ['error' => true, 'contents' => null, 'title' => 'ดำเนินการล้มเหลว', 'message' => $dataBRK->BrokertoCus->Name_Cus . ' ได้รับการโอนเงินเรียบร้อยแล้ว. !', 'code' => 500];
                        }
                    }
                    DB::commit();
                    event(new LogDataContract(@$data->id, 'update', 'LogDataContract', '..', 'การเงิน โอนเงิน โอนเงินให้ผู้แนะนำ เรียบร้อย', auth()->user()->id));

                    return $render;
                } catch (\Throwable $e) {
                    DB::rollback();

                    $render = ['error' => true, 'contents' => null, 'title' => 'ล้มเหลว !', 'message' => 'ดำเนินการไม่สำเร็จ กรุณาลองใหม่อีกครั้ง.', 'code' => 500];
                    return $render;
                }
                break;
            default:
                break;
        }
    }

    private function updateOperatedfees($data, $expenses, $request)
    {
        $dataOPR = Pact_Operatedfees::where('PactCon_id', $request->pact_id)->first();

        $result = ($dataOPR->Balance_Price - ($dataOPR->transferCash + ($expenses * (-1))));

        if ($result >= 0) {
            $dataOPR->transferCash = ($dataOPR->transferCash + ($expenses * (-1)));
            $dataOPR->transferBank = $request->Bank_id;
            $dataOPR->update();
        }

        return $dataOPR;
    }

    private function updateContractPayee($request, $expenses, $totalBalance, $collectionToUpdate = null)
    {
        $dataPayee = Pact_ContractPayee::where('Payee_id', $request->CusID)->where('PactCon_id', $request->pact_id)->first();
        $result = ($totalBalance - ($dataPayee->transferCash + ($expenses * (-1))));
        if ($result == 0 and empty($dataPayee->Date_Payee_montary)) {
            $dataPayee->transferCash = ($dataPayee->transferCash + ($expenses * (-1)));
            $dataPayee->Date_Payee_montary = date('Y-m-d H:i:s');
            $dataPayee->transferBank = $request->Bank_id;
            $dataPayee->Pay_method = $request->Pay_method;
            $dataPayee->Person_Close = @$request->Person_Close;

            $dataPayee->update();
            if ($collectionToUpdate) {
                $collectionToUpdate->transform(function ($item) use ($dataPayee) {
                    if ($item->id == $dataPayee->id) {
                        $item->transferBank = $dataPayee->transferBank;
                        $item->transferCash = $dataPayee->transferCash;
                        $item->Date_Payee_montary = $dataPayee->Date_Payee_montary;
                    }

                    return $item;
                });
            }
            return ['data' => $dataPayee, 'status' => true];
        } else {
            if ($result > 0) {
                $dataPayee->transferCash = ($dataPayee->transferCash + ($expenses * (-1)));
                $dataPayee->transferBank = $request->Bank_id;
                $dataPayee->Pay_method = $request->Pay_method;
                $dataPayee->Person_Close = $request->Person_Close;
                $dataPayee->update();

                if ($collectionToUpdate) {
                    $collectionToUpdate->transform(function ($item) use ($dataPayee) {
                        if ($item->id == $dataPayee->id) {
                            $item->transferBank = $dataPayee->transferBank;
                            $item->transferCash = $dataPayee->transferCash;
                        }
                        return $item;
                    });
                }

                return ['data' => $dataPayee, 'status' => true];
            } else {
                return ['data' => $dataPayee, 'status' => false];
            }
        }
    }

    private function ProcessDueDate($data, $request)
    {
        // สร้างวันดีล and post teams
        $duedate = $this->generateDueDate($data->CodeLoan_Con);
        // agent
        $callAgent = NULL;
        if (strtoupper(@$data->ContractToCal->Buy_PA) == "YES") {
            $callAgent = $this->manageAgent(floatval(@$data->ContractToCal->Insurance_PA), auth()->user()->zone);
        }

        $data = Pact_Contracts::find($request->pact_id);
        $data->Date_monetary = date('Y-m-d H:i:s');
        $data->DateDue_Con = $duedate;
        $data->Approve_monetary = auth()->user()->id;
        $data->Status_Con = 'transfered';
        $data->StatusApp_Con = 'โอนเงินเรียบร้อย';
        $data->Id_AgentPA = @$callAgent['agent'];

        if (empty($data->ContractToBrokers)) {
            $data->Date_Approve_tranfers = date('Y-m-d H:i:s');
        } else {
            $transferResultBroker = $data->ContractToBrokers->sum('SumCom_Broker') - $data->ContractToBrokers->sum('transferCash');
            if ($transferResultBroker == 0) {
                $data->Date_Approve_tranfers = date('Y-m-d H:i:s');
            }
        }
        $data->update();

        // Flag กลับไปอัพเดทสถานะการใช้งานทรัพย์
        $Indent = $data->ContractToIndentureAsset2->pluck('Asset_id');
        $checkAsset = Data_AssetsOwnership::whereIn('id', $Indent)->orderBy('id', 'DESC')->update([
            "State_Ownership" => 'Contract'
        ]);

        $flagCon_Cus = Data_Customers::where('id', $data->DataCus_id)->update([
            "Flag_Con" => 'Y'
        ]);

        if (strtoupper(@$data->ContractToCal->Buy_PA) == "YES" && $callAgent != NULL) {
            //$callAgent = $data->ContractToAgent;
            //  ChubbApiRequest::sendAndGetPA($callAgent['Producercode'], $data);

        }

        return true;
    }

    private function CreditBanks($request, $expenses, $bankAccount)
    {
        if ($request->Bank_idReceive != $request->Bank_id) {
            $dataCreditBanks = new Pact_CreditBanks;
            $dataCreditBanks->Bank_id = $request->Bank_id;
            $dataCreditBanks->expenses = $expenses;
            $dataCreditBanks->Amount_after = $expenses + $bankAccount->BankToCredit->Amount_after ?? 0;
            $dataCreditBanks->Amount_before = $bankAccount->BankToCredit->Amount_after ?? 0;
            $dataCreditBanks->TransactionDetail = $request->TransactionDetail;
            $dataCreditBanks->TransactionTxt = $request->TransactionTxt;
            $dataCreditBanks->Bank_Zone = $bankAccount->User_Zone;
            $dataCreditBanks->transactionDate = Carbon::now();
            $dataCreditBanks->Memo = $request->Memo;
            $dataCreditBanks->Pay_method = @$request->Pay_method;
            $dataCreditBanks->Person_Close = @$request->Person_Close;
            $dataCreditBanks->Con_receive = @$request->pact_id;
            $dataCreditBanks->Cus_receive = @$request->CusID;
            $dataCreditBanks->UserInsert = auth()->user()->id;
            $dataCreditBanks->save();
            if ($request->accout_status == 'receive') {
                $dataBank = Pact_CreditBanks::where('Bank_id', $request->Bank_idReceive)->orderBy('id', 'DESC')->first();
                $dataCreditBanks = new Pact_CreditBanks;
                $dataCreditBanks->Bank_id = $request->Bank_idReceive;
                $dataCreditBanks->expenses = $expenses * (-1);
                $dataCreditBanks->Amount_after = ($expenses * (-1)) + $dataBank->Amount_after ?? 0;
                $dataCreditBanks->Amount_before = $dataBank->Amount_after ?? 0;
                $dataCreditBanks->TransactionDetail = 'receive';
                $dataCreditBanks->TransactionTxt = 'ได้รับยอดโอน (RECEIVE)';
                $dataCreditBanks->Bank_Zone = $bankAccount->User_Zone;
                $dataCreditBanks->transactionDate = Carbon::now();
                $dataCreditBanks->Memo = $request->Memo;
                $dataCreditBanks->Pay_method = $request->Pay_method;
                $dataCreditBanks->Person_Close = @$request->Person_Close;
                $dataCreditBanks->Con_receive = @$request->pact_id;
                $dataCreditBanks->Cus_receive = @$request->CusID;
                $dataCreditBanks->UserInsert = auth()->user()->id;
                $dataCreditBanks->save();
            }

            return $dataCreditBanks;
        }

        return false;
    }

    private function Teams($subject, $user_Tag, $password_Tag, $nameTag, $Msteams_Id)
    {
        if ($subject != NULL) {
            if (auth()->user()->UserToMSTeams != NULL) {
                $user_name = auth()->user()->email;
                $password = base64_decode(auth()->user()->password_teams);

                $msTeams = auth()->user()->UserToMSTeams;
                $teams_chanel = $msTeams->Teams_Chanel;
                $group_id = $msTeams->Group_Id;
                $type_team = $msTeams->Type_teams;

                // $tokenUser = ConnectMSTeams::getTokenUser($user_name, $password);

                //  $tokenUserTag = ConnectMSTeams::getTokenUser($user_Tag,  $password_Tag);

                // if($tokenUser !=false && $tokenUserTag !=false ){

                //     $dis_user = $tokenUser->createRequest('GET', '/me')
                //             ->setReturnType(Model\User::class)
                //             ->execute();

                //     $dis_Checker = $tokenUserTag->createRequest('GET', '/me')
                //             ->setReturnType(Model\User::class)
                //             ->execute();


                //ข้อมูล tag
                // $ms_tag = json_decode(json_encode($dis_Checker), true);

                $dataArray = $subject;
                // $dataArray = [
                //     "body" => [
                //         "contentType"=>"html",
                //             "content" => "<at id='0'>".$ms_tag['displayName']."</at> ".$subject
                //     ],
                //     "mentions"=>[
                //         [
                //             "id"=> 0,
                //             "mentionText"=> $ms_tag['displayName'],
                //             "mentioned"=> [
                //                 "user"=> [
                //                     "displayName"=>$ms_tag['displayName'],
                //                     "id"=>$ms_tag['id'],
                //                     "userIdentityType"=> "aadUser"
                //                 ]
                //             ]
                //         ]
                //     ]
                // ];

                if (!empty($subject)) {

                    $eventPost = event(new MsTeamsEvent('', $user_name, $password, $user_Tag, $password_Tag, $nameTag, $group_id, $teams_chanel, $Msteams_Id, $dataArray, $type_team, 'replies'));
                    $post = true;
                    // try{
                    //     $post_ms = $tokenUser->createRequest('POST', '/teams/'.$group_id.'/channels/'.$teams_chanel.'/messages/'.$Msteams_Id.'/replies')
                    //         ->attachBody($dataArray)
                    //         ->setReturnType(Model\User::class)
                    //         ->execute();
                    //         $post = true;

                    //     }catch (\Exception $e) {
                    //         $post = false;

                    //     }
                    return $post;
                }


                // }else{
                //     // return response()->json(['status'=>'error','text' => 'กรุณาตรวจสอบ  Username และ Passwrod กับผู้ดูเเลระบบ','user'=>'']);
                //     return response(['error' => true, 'message' => 'กรุณาตรวจสอบ  Username และ Passwrod กับผู้ดูเเลระบบ !'], 500);
                // }
            } else {
                // return response()->json(['status'=>'error','text' => 'กรุณาตรวจสอบ  Username และ Passwrod กับผู้ดูเเลระบบ','user'=>'']);
                return response(['error' => true, 'message' => 'กรุณาตรวจสอบ  Username และ Passwrod กับผู้ดูเเลระบบ !'], 500);
            }
        }
    }

    public static function manageAgent($PA, $Agent_Zone)
    {
        $dataagent = Data_AgentInsurance::where('Agent_Zone', $Agent_Zone)
            ->where('Status_Agent', 'Yes')
            ->orderBy('Step', 'ASC')->get();
        $agent = null;
        $agentCode = null;
        $selectedAgents = [];

        $total = $dataagent->sum('Limit_Agent') - $dataagent->sum('Balance') <= 0;
        if ($total) {
            Data_AgentInsurance::where('Agent_Zone', $Agent_Zone)
                ->where('Status_Agent', 'Yes')
                ->update([
                    'Balance' => 0,
                ]);
        }

        $dataagent = Data_AgentInsurance::where('Agent_Zone', $Agent_Zone)
            ->where('Status_Agent', 'Yes')
            ->orderBy('Step', 'ASC')->get();

        foreach ($dataagent as $item) {
            if ($item->Limit_Agent - $item->Balance >= 0) {
                $item->update([
                    'Balance' => $item->Balance + $PA,
                ]);
                $agent = $item->id;
                $agentCode = $item->Code_Agent;
                $Producercode = $item->Producercode;
                $selectedAgents[] = $item->id;
                break;
            } else {
                $selectedAgents[] = null;
            }
        }


        return ['agent' => $agent, 'agentCode' => $agentCode, 'Producercode' => $Producercode];
    }

    // private function sendAndGetPA($callAgent, $data)
    // {
    //     //  dd( $callAgent['agentCode']  );
    //     $chubbApi = new ChubbApiRequest;
    //     $chubbApi->getToken();


    //     $Timelack = 0;
    //     $dataCusPA = DB::table('View_ReportPAData')->where('Status_Con', '<>', 'cancel')
    //         ->where('Contract_Con', '102402530001')->first();
    //       if(@$dataCusPA->Timelack_Car>84){
    //           $Timelack = round(84/12);
    //       }else{
    //           $Timelack =round(@$dataCusPA->Timelack_Car/12);
    //       }
    //       //$callAgent['agentCode']
    //       $package = $chubbApi->GetPaPackage( $callAgent['agentCode'],$Timelack,@$data->ContractToCal->DataCalcuToPA->PlanId);


    //    // @$dataCusPA->Date_monetary
    //    $yearPA = '+'.($Timelack/12).' year';
    //     @$datemonetary = explode(' ',@$dataCusPA->Date_monetary);
    //     $paStop = date('Y-m-d', strtotime($yearPA,strtotime( $datemonetary[0])));

    //       $dataArr = [
    //         "CompanyCode" =>  $callAgent['agentCode'] ,

    //         "PolicyStatus" => "N",
    //         "ContractNumber" => ($dataCusPA->Contract_Con),
    //         "CampaignCode" => $package[0]['CampaignCode'],
    //         "InsureType" => "P",
    //         "InsureTitleName" => $dataCusPA->Prefix,
    //         "InsureName" => $dataCusPA->Firstname_Cus,
    //         "InsureLastName" => $dataCusPA->Surname_Cus,
    //         "InsureIDCardNo" => ($dataCusPA->IDCard_cus),
    //         "InsureIDCardType" => "P1",
    //         "InsureDateOfBirth" => $dataCusPA->Birthday_cus,
    //         "InsureGender" => $dataCusPA->Detail_Sex == "ชาย" ? 'M' : 'F',
    //         "InsureOccupation" => null,
    //         "InsureAddress1" => $dataCusPA->houseNumber_Adds . " ม." . $dataCusPA->houseGroup_Adds,
    //         "InsureAddress2" => " ",
    //         "InsureSubDistrict" => $dataCusPA->houseTambon_Adds,
    //         "InsureDistrict" => $dataCusPA->houseDistrict_Adds,
    //         "InsureProvince" => $dataCusPA->houseProvince_Adds,
    //         "InsureZipcode" => $dataCusPA->Postal_Adds,
    //         "InsureTelMobile" => $dataCusPA->Phone_cus,
    //         "InsureEmail" => "",
    //         "BeneficiaryName" => $dataCusPA->Company_Name,
    //         "BeneficiaryRelation" => "เจ้าหนี้",
    //         "BeneficiaryTel" => null,
    //         "SaleDate" => $datemonetary[0],
    //         "SaleName" => null,
    //         "EffectiveDate" => $datemonetary[0],
    //         "ExpiryDate" => $paStop,
    //         "PackageCode" => $package[0]['PackageCode'],
    //         "GrossPremium" => $package[0]['Premium'],
    //         "Stamp" => $package[0]['Stamp'],
    //         "SBT" => $package[0]['Vat'],
    //         "TotalPremium" => $package[0]['TotalPremium'],
    //         "InsurePassportNo" => null,
    //         "Language" => "T",
    //         "CampaignType" => $package[0]['CampaignType'],
    //         "IsRenew" => false,
    //         "PreviousPolicyNumber" => ""
    //       ];


    //       $checkValue = $chubbApi->verifyIssue($dataArr);

    //       if(@$checkValue['Status']!=NULL && @$checkValue['Status'] == 'true'){
    //             $ResponseData = $chubbApi->Issue($dataArr,$data);
    //       }else{
    //         return response(['error' => true, 'message' => @$checkValue['Errors'] ], 500);
    //       }



    // }
}
