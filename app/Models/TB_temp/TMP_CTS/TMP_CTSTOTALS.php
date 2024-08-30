<?php

namespace App\Models\TB_temp\TMP_CTS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TMP_CTSTOTALS extends Model
{
    use HasFactory;
    protected $table = 'TMP_CTSTOTALS';
    protected $primaryKey = 'TOTAL_ID';
    protected $fillable = ['HEADER_ID', 'RECORD_TYPE' ,'SEQ_NO' ,'BANK_CODE',
                    'COMPANY_ACCOUNT' ,'TOTAL_DEBIT_AMOUT' ,'TOTAL_DEBIT_TRANSACTION' ,
                    'TOTAL_CREDIT_AMOUNT' ,'TOTAL_CREDIT_TRANSACTION'];
}
