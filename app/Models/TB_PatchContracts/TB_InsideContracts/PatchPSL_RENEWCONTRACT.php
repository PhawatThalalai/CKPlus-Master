<?php

namespace App\Models\TB_PatchContracts\TB_InsideContracts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatchPSL_RENEWCONTRACT extends Model
{
    use HasFactory;

    protected $table = 'PatchPSL_RENEWCONTRACT';
    protected $fillable = [
        'PatchCon_id'
        ,'DataCus_id'
        ,'DataPact_id'
        ,'LOCAT'
        ,'RENEWNO'
        ,'CANDATE'
        ,'CONTNO'
        ,'CUSCOD'
        ,'SNAM'
        ,'NAME1'
        ,'NAME2'
        ,'STRNO'
        ,'REGNO'
        ,'SDATE'
        ,'TOTPRC'
        ,'T_NOPAY'
        ,'SMPAY'
        ,'TOTBAL'
        ,'EXP_AMT'
        ,'BILLCOLL'
        ,'CHECKER'
        ,'USERCN'
        ,'CONTSTAT'
        ,'FUPAY'
        ,'LUPAY'
        ,'MEMO1'
        ,'REXP_PRD'
        ,'EXP_FRM'
        ,'EXP_TO'
        ,'KANGINT'
        ,'LDATE'
        ,'otherPay'
        ,'BLTCSHPRC'
        ,'RETCSHPRC'
        ,'FEERATE'
        ,'FEETOTAMT'
        ,'FEEAMT'
        ,'FLRATE'
        ,'NPROFIT'
        ,'RETOTPRC'
        ,'ALLTOTPRC'
        ,'RETNOPAY'
        ,'REFUPAY'
        ,'RENUPAY'
        ,'RELUPAY'
        ,'REFLAG'
        ,'NEWCONTNO',
        'UserZone',
        'UserInsert'
    ];
}
