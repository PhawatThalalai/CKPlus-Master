<?php

namespace App\Models\TB_Letter;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Data_TKANGPAY extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'Data_TKANGPAY';
    protected $fillable =     
    [
        'pactcon_id'
        ,'LOCAT'
        ,'DOCNO'
        ,'DOCDT'
        ,'CONTNO'
        ,'CUSCOD'
        ,'NOPAY'
        ,'STRNO'
        ,'GCODE'
        ,'SDATE'
        ,'FDATE'
        ,'LPAYD'
        ,'TOTPRC'
        ,'TOTDWN'
        ,'TOT_UPAY'
        ,'SMPAY'
        ,'EXP_AMT'
        ,'EXP_PRD'
        ,'GEXPPRD'
        ,'EXP_FRM'
        ,'EXP_TO'
        ,'LPAYA'
        ,'PAYDWN'
        ,'KANGDWN'
        ,'KANGINT'
        ,'LETTER'
        ,'FORCODE'
        ,'BILLCOLL'
        ,'OLD_STAT'
        ,'NEW_STAT'
        ,'FLAG'
        ,'PRNNO'
        ,'USERID'
        ,'INPDATE'
        ,'ARBAL'
        ,'LTNO'
        ,'POSTLT'
        ,'TCSHPRC'
        ,'CRSCHEMA'
        ,'duedate'
        ,'d_due'
        ,'userzone'
        ,'userbranch'
    ];
}
