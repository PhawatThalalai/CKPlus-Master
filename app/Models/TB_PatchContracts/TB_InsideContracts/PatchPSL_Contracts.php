<?php

namespace App\Models\TB_PatchContracts\TB_InsideContracts;

use App\Models\TB_temp\TMP_STOPVAT\TMP_STOPVATPSL;
use App\Models\TB_temp\TMP_WAITHOLD\TMP_WAITHOLDPSL;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_Constants\TB_Frontend\TB_TypeLoan;
use App\Models\TB_Constants\TB_Backend\TB_TYPCONT;

use App\Models\TB_PactContracts\Pact_Contracts;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_paydue;

use App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_CHQMas;
use App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_CHQTran;
use App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_DUEPAYMENT;
use App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_HDPAYMENT;

use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchPSL\PatchPSL_AROTHR;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchTB_SPASTDUE;
use App\Models\TB_view\VWDEBT_RPSPASTDUE;
use App\Models\TB_view\View_PatchSPASTDUE;
use App\Models\TB_Temp\TMP_CONTRACTS\TMP_CANCONTRACTPSL;

use App\Models\TB_temp\TMP_INVOICE\TMP_INVOICE;

use App\Models\TB_DataCus\Data_Customers;
use App\Models\TB_DataCus\Data_CusAddress;
use App\Models\TB_Assets\Data_Assets;

class PatchPSL_Contracts extends Model
{
    protected $table = 'PatchPSL_Contracts';
    protected $fillable = [
        'id',
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
        'LPAYD',
        'LPAYA',
        'DLDAY',
        'CLOSAR',
        'CLOSTAT',
        'TCSHPRC',
        'INTFLATRATE',
        'Interest_IRR',
        'TOT_UPAY',
        'N_UPAY',
        'L_UPAY',
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
        'PAYTON',
        'PAYINT',
        'LASTDUEDATE',
        'TONBALANCE',
        'NOPAY',
        'EXP_DAY',
        'EXP_PRD',
        'EXP_AMT',
        'EXP_FRM',
        'EXP_TO',
        'BILLCOLL',
        'HLDNO',
        'LOANCON',
        'MTHDDIS',
        'USEADD',
        'RECONTNO',
        'CARRDT',
        'SO',
        'MEMO',
        'UserInsert',
        'UserBranch',
        'UserZone',
        'SPASTDUE_ID',
        'SPASTDUE_STATUS',
        'TYPECON',
        'SALECOD',
        'Id_Com',
        'BARCODENO',
        'YDATE',
        'YSTAT'
    ];

    /**----------- fontend ------------------ */
    public function PatchToPact()
    {
        return $this->belongsTo(Pact_Contracts::class, 'DataPact_id', 'id');
    }
    public function PactToCus()
    {
        return $this->hasOne(Data_Customers::class, 'id', 'DataCus_id');
    }
    public function PatchCusAsset()
    {
        return $this->hasOne(Data_Assets::class, 'id', 'DataAsset_id');
    }
    public function PatchCusAdds()
    {
        return $this->belongsTo(Data_CusAddress::class, 'USEADD', 'id');
    }

    /**--------------------------------------- */

    public function ContractPaydue()
    {
        return $this->hasMany(PatchPSL_paydue::class, 'PatchCon_id', 'id');
    }
    public function ContractPaydue2() // ตารางภาระหนี้
    {
        return $this->hasMany(PatchPSL_paydue::class, 'PatchCon_id', 'id');
    }
    public function ContractDUEPAYMENT()
    {
        return $this->hasMany(PatchPSL_DUEPAYMENT::class, 'PatchCon_id', 'id')->orderBy('NOPAY', 'asc');
    }
    public function ContractPaydueLoan()
    {
        return $this->hasMany(PatchPSL_paydueLoan::class, 'PatchCon_id', 'id')->orderBy('nopay', 'asc');
    }
    public function ContractUser()
    {
        return $this->belongsTo(User::class, 'UserInsert', 'id');
    }
    public function ContractLocat()
    {
        return $this->belongsTo(TB_Branchs::class, 'LOCAT', 'id');
    }
    public function ContractCHQMaspay()
    {
        return $this->hasMany(PatchPSL_CHQMas::class, 'PatchCon_id', 'id')
            ->where('TYPEPAY', 'Payment')->orderBy('BILLDT', 'asc');
    }
    public function ContractCHQMasfee()
    {
        return $this->hasMany(PatchPSL_CHQMas::class, 'PatchCon_id', 'id')
            ->where('TYPEPAY', 'Payother')->orderBy('BILLDT', 'asc');
    }
    public function ContractTranpay()
    {
        return $this->hasMany(PatchPSL_CHQTran::class, 'PatchCon_id', 'id')
            // ->whereIn('PAYFOR', ['006', '007']);
            ->whereRaw("SUBSTRING(PAYFOR,1,1) = '0' ")->orderBy('TMBILDT', 'asc');
    }
    public function ContractTranFee()
    {
        return $this->hasMany(PatchPSL_CHQTran::class, 'PatchCon_id', 'id')
            ->whereNotIn('PAYFOR', ['006', '007'])->orderBy('TMBILDT', 'asc');
    }

    public function PactToAroth()
    {
        return $this->hasMany(PatchPSL_AROTHR::class, 'PatchCon_id', 'id')->orderBy('ARDATE', 'asc');
    }

    public function PactToHDpayment()
    {
        return $this->hasMany(PatchPSL_HDPAYMENT::class, 'PatchCon_id', 'id');
    }

    public function PactToStatus()
    {
        return $this->belongsTo(TB_TYPCONT::class, 'CONTSTAT', 'CONTTYP');
    }
    public function ContractToSPASTDUE()
    {
        return $this->hasOne(PatchTB_SPASTDUE::class, 'PatchCon_id', 'id')
            ->where('CODLOAN', '1')->latest();
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

    public function PactToCanCont()
    {
        return $this->hasOne(TMP_CANCONTRACTPSL::class, 'CONTNO', 'CONTNO')->latest();
    }

    // public function ToVWDEBT_RPSPASTDUE()
    // {
    //     return $this->hasMany(VWDEBT_RPSPASTDUE::class, 'CONTNO', 'CONTNO')->orderBy('id','desc');
    // }

    public function ToView_PatchSPASTDUE()
    {
        // return $this->hasMany(View_PatchSPASTDUE::class, 'CONTNO', 'CONTNO')->orderBy('spast_id', 'desc');
        return $this->hasMany(View_PatchSPASTDUE::class, 'CONTNO', 'CONTNO')->latest();

    }

    public function ContractToHLD()
    {
        return $this->hasOne(TMP_WAITHOLDPSL::class, 'PatchCon_id', 'id');
    }

    public function ContractSTOPV()
    {
        return $this->hasOne(TMP_STOPVATPSL::class, 'CONTNO', 'CONTNO')->where('STOPVFL', 'S')->latest();
    }

}
