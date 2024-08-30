<?php

namespace App\Models\TB_temp\TMP_CTS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TMP_CTSPAYMENTS extends Model
{
    use HasFactory;
    protected $table = 'TMP_CTSPAYMENTS';
    protected $primaryKey = 'PAY_ID';
    protected $fillable = ['HEADER_ID', 'LOCAT' ,'CRLOCAT' ,'REFNO1', 'CUSCOD', 'SNAME', 'NAME1', 'NAME2',
                    'CONTNO' ,'TOTUPAY' ,'ARBAL' ,'TOTLKANG' ,'KINTAMT', 'EXPREAL', 'GRDCOD', 'GRDCAL',
                    'PAYLIMITAMT' ,'TMPBILDT' ,'TMPBILNO' ,'PAYDATE' ,'PAYTMIE', 'PAYAMT', 'PAYINT', 'PAYAMOUNT',
                    'BANKACCNO' ,'BILLCOLL' ,'POSTBL' ,'USERID', 'INPDATE', 'FLCHECK', 'LAST_NOTEDT'];
}
