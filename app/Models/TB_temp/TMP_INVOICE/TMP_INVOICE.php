<?php

namespace App\Models\TB_temp\TMP_INVOICE;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_Contracts;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_Contracts;

use App\Models\TB_Constants\TB_Frontend\TB_BankAccounts;

class TMP_INVOICE extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'TMP_INVOICE';
    protected $fillable = [
        'DataCus_id',
        'PatchCon_id',
        'PactCon_id',
        'CODLOAN',
        'DATENOPAY',
        'CONTNO',
        'PAYFOR',
        'PAYFOR_NAME',
        'PAYINACC',
        'PAYINACC_NAME',
        'LOCAT',
        'EXP_FRM',
        'EXP_TO',
        'EXP_FRM',
        'EXP_FRM',
        'DOCNO',
        'DOCDATE',
        'TOTALPAYMENTS',
        'PERIODDEBT',
        'INTLATEAMT',
        'DEBTOTH',
        'IDAROTH',
        'PAYDATE',
        'PAYAMT',
        'PAYINTAMT',
        'FOLLOWAMT',
        'PAYLATE',
        'PAYDUEAMT',
        'BALPAYAMT',
        'NEEDPAY',
        'userInsert',
        'INPUTPAY',
        'DEPCASH',
        'HOLDCASH',
        'TOTPAY',
        'AMTPAY',
        'B_INTAMT',
        'DISCB_INTAMT',
        'PAYFOLLOW',
        'DISCPAYFOLLOW',
        'TOTBLC',
        'PAYOTH',
        'HOLDCASHNEXT',
        'STATUSPAY',
        'DISCAROTH',
        'TOTBLINT',
        'DISCPAYOTH',
        'TOTPAYOTH',
        'DSCINT',
        'DSCPAYFL',
        'TOTOTH',
        'OUTSBL',
        'PAYFOR_CODE',
        'PAYFOR_NAME',
        'DISCCLOSESYS',
        'DISCCLOSEAC',
        'NETBALANCE',
        'CAPITALBLVAL',
        'UserZone'
    ];

    public function ContractHP()
    {
        return $this->belongsTo(PatchHP_Contracts::class, 'PactCon_id', 'id');
    }

    public function ContractPSL()
    {
        return $this->belongsTo(PatchPSL_Contracts::class, 'PactCon_id', 'id');
    }

    public function InvoiceToBank()
    {
        return $this->hasOne(TB_BankAccounts::class, 'id', 'PAYINACC');
    }


}
