<?php

namespace App\Models\TB_temp\TMP_CTS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TMP_CTSHEADERS extends Model
{
    use HasFactory;
    protected $table = 'TMP_CTSHEADERS';
    protected $primaryKey = 'HEADER_ID';
    protected $fillable = ['RECORD_TYPE', 'SEQ_NO' ,'BANK_CODE' ,
                    'COMPANY_ACCOUNT' ,'COMPANY_NAME' ,'EFF_DATE' ,'SERVICE_CODE'];
}
