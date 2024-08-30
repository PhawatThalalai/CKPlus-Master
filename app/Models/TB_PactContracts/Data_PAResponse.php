<?php

namespace App\Models\TB_PactContracts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data_PAResponse extends Model
{
    use HasFactory;
    protected $table = 'Data_PAResponse';
    protected $fillable =     
    [
        'DataCus_id'
        ,'DataPact_id'
        ,'ContractNumber'
        ,'PolicyNumber'
        ,'NotificationNumber'
        ,'PolicyNumber2'
        ,'NotificationNumber2'
        ,'URLPrint'
        ,'URLPrintCopy'
        ,'URLPrintCard'
        ,'URLPrintApp'
        ,'TransactionID'
        ,'TransactionResponseDt'
        ,'TransactionResponseTime'
        ,'MsgStatusCd'
        ,'ErrorMessage'
        ,'TaxInvoiceNo'
    ];
}
