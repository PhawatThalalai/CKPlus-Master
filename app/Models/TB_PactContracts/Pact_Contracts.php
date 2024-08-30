<?php

namespace App\Models\TB_PactContracts;

use App\Models\TB_Constants\TB_Frontend\TB_SpecialTypeApp;
use App\Models\TB_temp\TMP_INVOICE\TMP_INVOICE;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

use App\Models\TB_DataCus\Data_Customers;
use App\Models\TB_DataCus\Data_CusAddress;
use App\Models\TB_DataCus\Data_CusTags;
use App\Models\TB_DataCus\Data_CusTagCalculate;

use App\Models\TB_Constants\TB_Frontend\TB_TypeLoanCom;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_Constants\TB_Frontend\TB_BankAccounts;
use App\Models\TB_Constants\TB_Frontend\TB_Company;
use App\Models\TB_Constants\TB_Frontend\TB_StatusCon;

use App\Models\TB_PactContracts\Pact_ContractBrokers;
use App\Models\TB_PactContracts\Pact_ContractPayee;
use App\Models\TB_PactContracts\Pact_ContractsGuarantor;
use App\Models\TB_PactContracts\Pact_Operatedfees;
use App\Models\TB_PactContracts\Pact_Indentures_Assets;
use App\Models\TB_PactContracts\Pact_Indentures;

use App\Models\TB_PactContracts\Pact_AuditTags;

use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_Contracts;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_Contracts;

class Pact_Contracts extends Model
{
    protected $table = 'Pact_Contracts';
    protected $fillable = [
        'DataCus_id',
        'DataTag_id',
        'FlagActices_Con',
        'NameActices_Con',
        'CodeLoan_Con',
        'Contract_Con',
        'Status_Con',
        'UserSent_Con',
        'BranchSent_Con',
        'Date_con',
        'UserApp_Con',
        'StatusApp_Con',
        'UserCancel_Con',
        'DateCancel_Con',
        'DocApp_Con',
        'DateDocApp_Con',
        'ConfirmDocApp_Con',
        'DateConfirmDocApp_Con',
        'AuditDoc_Con',
        'DateAuditDoc_Con',
        'ConfirmApp_Con',
        'DateConfirmApp_Con',
        'Checkers_Con',
        'Date_Checkers',
        'Check_Bookcar',
        'DateCheck_Bookcar',
        'LinkBookcar',
        'Special_Bookcar',
        'DateSpecial_Bookcar',
        'BookSpecial_Trans',
        'Date_BookSpecial',
        'LinkBookSpecial',
        'Email_Con',
        'Msteams_Id',
        'LinkUpload_Con',
        'DateDue_Con',
        'Approve_monetary',
        'Date_monetary',
        'Commission_Trans',
        'Date_Commission',
        'FlagSpecial_Trans',
        'Date_FlagSpecial',
        'Bank_Close',
        'Bank_Out',
        'Adds_Con',
        'Memo_Objective',
        'Memo_Con',
        'Cus_Ref',
        'PhoneCus_Ref',
        'Data_Reg',
        'Data_UnReg',
        'Data_Purpose',
        'Data_TypeLoan',
        'Data_Factors',
        'Flag_Inside',
        'Flag_Reject',
        'Id_AgentPA',
        'Id_Com',
        'UserZone',
        'UserBranch',
        'UserInsert',
        'UserApp_relevant',
        'MI_label',
        'MI_probability',
        'Beneficiary_PA',
        'Relations_PA'
    ];

    public function ContractToDataCusTags()
    {
        return $this->belongsTo(Data_CusTags::class, 'DataTag_id', 'id');
    }

    public function ContractToIndenture()
    {
        return $this->hasOne(Pact_Indentures::class, 'PactCon_id', 'id');
    }
    public function ContractToIndentureAsset()
    {
        return $this->hasOne(Pact_Indentures_Assets::class, 'PactCon_id', 'id');
    }
    public function ContractToIndentureAsset2()
    {
        return $this->hasMany(Pact_Indentures_Assets::class, 'PactCon_id', 'id');
    }
    public function ContractToGuarantor()
    {
        return $this->hasMany(Pact_ContractsGuarantor::class, 'PactCon_id', 'id')->orderBy('id', 'ASC');
    }
    public function ContractToOperated()
    {
        return $this->hasOne(Pact_Operatedfees::class, 'PactCon_id', 'id');
    }
    public function ContractToUserApprove()
    {
        return $this->belongsTo(User::class, 'UserApp_Con', 'id')->withTrashed();
    }
    public function ContractToUserBranch()
    {
        return $this->belongsTo(User::class, 'UserSent_Con', 'id')->withTrashed();
    }
    public function ContractToTypeLoan()
    {
        return $this->belongsTo(TB_TypeLoanCom::class, 'Id_Com', 'Id_Com')->where('Loan_Code', $this->CodeLoan_Con);
    }

    public function ContractToTypeLoanLast()
    {
        return $this->belongsTo(TB_TypeLoanCom::class, 'CodeLoan_Con', 'Loan_Code')->where('Flag', 'Y')->where('Flag_Zone', $this->UserZone);
    }

    public function ContractToBranch()
    {
        return $this->belongsTo(TB_Branchs::class, 'BranchSent_Con', 'id');
    }
    public function ContractToCus()
    {
        return $this->belongsTo(Data_Customers::class, 'DataCus_id', 'id');
    }
    public function ContractToFirmApprove()
    {
        return $this->belongsTo(User::class, 'ConfirmDocApp_Con', 'id')->withTrashed();
    }
    public function ContractToUserApp()
    {
        return $this->belongsTo(User::class, 'DocApp_Con', 'id')->withTrashed();
    }
    public function ContractToConfirmApp()
    {
        return $this->belongsTo(User::class, 'ConfirmApp_Con', 'id')->withTrashed();
    }
    public function ContractToBankClose()
    {
        return $this->belongsTo(TB_BankAccounts::class, 'Bank_Close', 'id');
    }
    public function ContractToBankOut()
    {
        return $this->belongsTo(TB_BankAccounts::class, 'Bank_Out', 'id');
    }
    public function ContractToAudittor()
    {
        return $this->hasOne(Pact_Checklists::class, 'PactCon_id', 'id');
    }
    public function ContractToCompany()
    {
        return $this->hasMany(TB_Company::class, 'Company_Zone', 'UserZone');
    }
    public function ContractToCom()
    {
        return $this->hasMany(TB_Company::class, 'id', 'Id_Com');
    }

    public function ContractToComOne()
    {
        return $this->hasOne(TB_Company::class, 'id', 'Id_Com');
    }
    public function ContractToStCon()
    {
        return $this->hasOne(TB_StatusCon::class, 'Status_Con', 'Name_StatusCon');
    }
    public function ContractToBrokers()
    {
        return $this->hasMany(Pact_ContractBrokers::class, 'PactCon_id', 'id');
    }
    public function ContractToPayee()
    {
        return $this->hasMany(Pact_ContractPayee::class, 'PactCon_id', 'id')->orderby('status_Payee', 'ASC');

    }

    public function ContractToAddress()
    {
        return $this->hasOne(Data_CusAddress::class, 'id', 'Adds_Con');

    }

    public function ContractToCal()
    {
        return $this->hasOne(Data_CusTagCalculate::class, 'DataTag_id', 'DataTag_id');
    }

    public function ContToauditTags()
    {
        return $this->hasOne(Pact_AuditTags::class, 'PactCon_id', 'id');
    }

    // ----------------- inside ------------- //
    public function ContractToConHP()
    {
        return $this->hasOne(PatchHP_Contracts::class, 'DataPact_id', 'id');
    }
    public function ContractToConPSL()
    {
        return $this->hasOne(PatchPSL_Contracts::class, 'DataPact_id', 'id');
    }

    public function ContractToIndenAsst()
    {
        return $this->hasMany(Pact_Indentures_Assets::class, 'PactCon_id', 'id');
    }

    public function ContractToBookSpecial()
    {
        return $this->hasOne(TB_SpecialTypeApp::class, 'id', 'BookSpecial_Type');
    }

    public function ContractToAgent()
    {
        return $this->hasOne(Data_AgentInsurance::class, 'id', 'Id_AgentPA');
    }

    public function ContractToInvoice()
    {
        return $this->hasMany(TMP_INVOICE::class, 'PactCon_id', 'id');
    }

    public function ContractToCONTNO()
    {
        if($this->ContractToTypeLoan->Loan_Com == 1){
            return $this->hasOne(PatchPSL_Contracts::class,'id','DataPact_id');
        }else{
            return $this->hasOne(PatchHP_Contracts::class,'id','DataPact_id');

        }
    }
}
