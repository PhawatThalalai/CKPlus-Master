<?php

namespace App\Models\TB_temp\TMP_CTS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TMP_CTSDETAILS extends Model
{
    use HasFactory;
    protected $table = 'TMP_CTSDETAILS';
    protected $primaryKey = 'DETAIL_ID';
    protected $fillable = ['HEADER_ID', 'RECORD_TYPE' ,'SEQ_NO' ,'BANK_CODE',
                    'COMPANY_ACCOUNT' ,'PAYMENT_DATE' ,'PAYMENT_TIME' ,'CUSTOMER_NAME',
                    'REF1' ,'REF2' ,'REF3' ,'BRANCH_NO' ,'TELLER_NO' ,'TRANSACTION_KIND' ,'TRANSACTION_CODE',
                    'CHEQUE_NO' ,'AMOUNT' ,'CHEQUE_BANK_CODE' ,'POSTBL'];
}
