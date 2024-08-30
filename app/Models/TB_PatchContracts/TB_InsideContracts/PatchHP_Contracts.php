<?php

namespace App\Models\TB_PatchContracts\TB_InsideContracts;

use App\Models\TB_Constants\TB_Backend\TB_BILLCOLL;
use App\Models\TB_temp\TMP_STOPVAT\TMP_STOPVATHP;
use App\Models\TB_temp\TMP_WAITHOLD\TMP_WAITHOLDHP;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

use App\Models\TB_PactContracts\Pact_Contracts;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_paydue;
use App\Models\TB_PatchContracts\TB_Payments\PatchHP\PatchHP_HDPAYMENT;
use App\Models\TB_PatchContracts\TB_Payments\PatchHP\PatchHP_CHQMas;
use App\Models\TB_PatchContracts\TB_Payments\PatchHP\PatchHP_CHQTran;

use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchHP\PatchHP_AROTHR;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchTB_SPASTDUE;
use App\Models\TB_view\View_PatchSPASTDUE;

use App\Models\TB_Constants\TB_Backend\TB_TYPCONT;
use App\Models\TB_Constants\TB_Frontend\TB_TypeLoan;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;

use App\Models\TB_DataCus\Data_Customers;
use App\Models\TB_Temp\TMP_CONTRACTS\TMP_CANCONTRACTHP;

use App\Models\TB_temp\TMP_INVOICE\TMP_INVOICE;


class PatchHP_Contracts extends Model
{
    protected $table = 'PatchHP_Contracts';
    protected $fillable = [
        'DataCus_id',
        'DataTag_id',
        'DataPact_id',
        'DataAsset_id',
        'CONTNO',
        'CODLOAN',
        'CONTTYP',
        'CONTSTAT',
        'SDATE',
        'FDATE',
        'LDATE',
        'CREATE_LDUE',
        'LPAYD',
        'LPAYA',
        'DLDAY',
        'CLOSAR',
        'CLOSTAT',
        'NCSHPRC',
        'VCSHPRC',
        'TCSHPRC',
        'INTFLATRATE',
        'Interest_IRR',
        'TOT_UPAY',
        'TOTPRC',
        'APPLICANT',
        'BALANC',
        'NETPROFIT',
        'INTKPAY',
        'CAPITALBL',
        'GRDCOD',
        'LIMITIRR',
        'PERIOD',
        'T_NOPAY',
        'INTLATE',
        'LOCAT',
        'FDATEINT',
        'SMPAY',
        'VATRT',
        'NPRICE',
        'VATPRICE',
        'NOPAY',
        'EXP_PRD',
        'EXP_AMT',
        'EXP_FRM',
        'EXP_TO',
        'EXP_DAY',
        'EXP_REAL',
        'NDAWN',
        'VATDAWN',
        'TOTDAWN',
        'TAXNO',
        'TAXDT',
        'BILLCOLL',
        'HLDNO',
        'LOANCON',
        'MTHDDIS',
        'USEADD',
        'RECONTNO',
        'CARRDT',
        'SO',
        'MEMO',
        'TYPECON',
        'UserInsert',
        'UserBranch',
        'UserZone',
        'SPASTDUE_ID',
        'SPASTDUE_STATUS',
        'DTSTOPV',
        'FLSTOPV',
        'SALECOD',
        'Id_Com',
        'BARCODENO',
        'YDATE',
        'YSTAT'
    ];

    public function PatchToPact()
    {
        return $this->belongsTo(Pact_Contracts::class, 'DataPact_id', 'id');
    }

    public function ContractPaydue()
    {
        return $this->hasMany(PatchHP_paydue::class, 'PatchCon_id', 'id')->orderBy('nopay', 'asc');
    }
    public function ContractUser()
    {
        return $this->belongsTo(User::class, 'UserInsert', 'id');
    }
    public function ContractCHQMaspay()
    {
        return $this->hasMany(PatchHP_CHQMas::class, 'PatchCon_id', 'id')
            ->where('TYPEPAY', 'Payment')->orderBy('BILLDT', 'asc');
    }
    public function ContractTranAll()
    {
        return $this->hasMany(PatchHP_CHQTran::class, 'PatchCon_id', 'id')->orderBy('TMBILDT', 'asc');
    }
    public function ContractTranpay()
    {
        return $this->hasMany(PatchHP_CHQTran::class, 'PatchCon_id', 'id')
            // ->whereIn('PAYFOR', ['006', '007']);
            ->where('PAYFOR', 'LIKE', '0%')->orderBy('TMBILDT', 'asc');
    }
    public function ContractCHQMasfee()
    {
        return $this->hasMany(PatchHP_CHQMas::class, 'PatchCon_id', 'id')
            ->where('TYPEPAY', 'Payother')->orderBy('BILLDT', 'asc');
    }
    public function PactToAroth()
    {
        return $this->hasMany(PatchHP_AROTHR::class, 'CONTNO', 'CONTNO')->orderBy('ARDATE', 'asc');
    }
    public function PactToHDpayment()
    {
        return $this->hasMany(PatchHP_HDPAYMENT::class, 'PatchCon_id', 'id');
    }
    public function PactToStatus()
    {
        return $this->belongsTo(TB_TYPCONT::class, 'CONTSTAT', 'CONTTYP');
    }

    public function ContractToBranch()
    {
        return $this->belongsTo(TB_Branchs::class, 'LOCAT', 'id');
    }
    public function ContractBILLCOLLToBranch()
    {
        return $this->belongsTo(TB_BILLCOLL::class, 'BILLCOLL', 'id');
    }

    public function ContractCHQMasAll()
    {
        return $this->hasMany(PatchHP_CHQMas::class, 'PatchCon_id', 'id');
    }

    public function ContractToSPASTDUE()
    {
        return $this->hasOne(PatchTB_SPASTDUE::class, 'PatchCon_id', 'id')
            ->where('CODLOAN', '2')->latest();
    }
    public function ToTB_SPASTDUE()
    {
        return $this->hasMany(PatchTB_SPASTDUE::class, 'CONTNO', 'CONTNO')->orderBy('id', 'desc');
    }
    public function PactToCus()
    {
        return $this->hasOne(Data_Customers::class, 'id', 'DataCus_id');
    }
    public function PactToCanCont()
    {
        return $this->hasOne(TMP_CANCONTRACTHP::class, 'CONTNO', 'CONTNO')->latest();
    }
    public function ContractTypeLoan()
    {
        return $this->belongsTo(TB_TypeLoan::class, 'TYPECON', 'Loan_Code');
    }
    public function ContractToInvoice()
    {
        return $this->hasMany(TMP_INVOICE::class, 'PatchCon_id', 'id');
    }

    public function ContractToInvoiceOne()
    {
        return $this->hasOne(TMP_INVOICE::class, 'PactCon_id', 'DataPact_id')->latest();
    }
    // public function ToVWDEBT_RPSPASTDUE()
    // {
    //     return $this->hasMany(VWDEBT_RPSPASTDUE::class, 'CONTNO', 'CONTNO')->orderBy('id','desc');
    // }
    public function ToView_PatchSPASTDUE()
    {
        return $this->hasMany(View_PatchSPASTDUE::class, 'CONTNO', 'CONTNO')->orderBy('spast_id', 'desc');
    }


    public function ContractToHLD()
    {
        return $this->hasOne(TMP_WAITHOLDHP::class, 'PatchCon_id', 'id');
    }

    public function ContractSTOPV()
    {
        return $this->hasOne(TMP_STOPVATHP::class, 'CONTNO', 'CONTNO')->where('STOPVFL', 'S')->latest();
    }
}
