<?php

namespace App\Models\TB_PatchContracts\TB_Payments\AutoPay;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data_AutoPayPsl extends Model
{
    protected $table = 'Data_AutoPayPsl';
    protected $fillable = ['HEADER_ID'   ,'RECORD_TYPE'  ,'SEQ_NO'  ,'BANK_CODE'  ,'COMPANY_ACCOUNT'  ,'PAYMENT_DATE'
    ,'PAYMENT_TIME'  ,'CUSTOMER_NAME'  ,'REF1'  ,'REF2'   ,'REF3'  ,'BRANCH_NO'  ,'TELLER_NO'  ,'TRANSACTION_KIND'   ,'TRANSACTION_CODE'
    ,'CHEQUE_NO'   ,'AMOUNT'   ,'CHEQUE_BANK_CODE'   ,'POSTBL'];
}
