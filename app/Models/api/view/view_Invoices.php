<?php

namespace App\Models\api\view;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\api\user_api;

class view_Invoices extends Model
{
    use HasFactory;

    //protected $connection = 'sqlsrv2';
    protected $table = 'View_getInvoiceDetail';
    protected $fillable = [
        'accountId',
        'invoiceId',
        'invoiceDate',
        'invoiceYear',
        'invoiceNo',
        'customerId',
        'customerFullName',
        'customerAddr',
        'typeId',
        'typeName',
        'typeModel',
        'typeLicense',
        'typeProvince',
        'loanPeriod',
        'paidPerPeriod',
        'DUEAMT',
        'EXP_AMT',
        'EXP_FRM',
        'EXP_TO',
        'EXP_INTAMT',
        'EXP_FOLLOW',
        'totalAmount',
        'ref1',
        'ref2',
        'Company_Addr',
        'Company_Tel',
        'Company_Id',
        'Company_Branch'
    ];

    public function user_api()
    {
        return $this->belongsTo(user_api::class, 'customerId', 'data_customer_id');
    }
}