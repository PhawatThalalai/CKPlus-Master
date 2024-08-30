<?php

namespace App\Models\api\view;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\api\user_api;

class view_Receipts extends Model
{
    use HasFactory;
   // protected $connection = 'sqlsrv2';
    protected $table = 'View_getReceiptDetail';

    protected $fillable = [
        'accountId',
        'customerId',
        'receiptId',
        'receiptDate',
        'receiptYear',
        'receiptAmount',
        'totalPayAmount',
        'chookiatTaxNo',
        'chookiatAddr',
        'chookiatName',
        'chookiatPhone',
        'receiptNo',
        'loanNo',
        'customerFullName',
        'customerAddr',
        'amountPrincipal',
        'amountInterest',
        'amountInterestOverdue',
        'amountFollowUp',
        'totalAmount',
        'PayAmount',
        'totalPrincipal',
        'discountInterestOverdue',
        'discountFollowUp',
        'discount',
        'totprc',
        'remarkTxt',
        'totalBalanceTxt',
        'sumPay'
    ];

    protected $casts = [
        'receiptAmount' => 'double',
        'amountPrincipal' => 'double',
        'amountInterestOverdue' => 'double',
        'amountFollowUp' => 'double',
        'totalAmount' => 'double',
        'totalBalance' => 'double',
        'discount' => 'double',
        'totalPayAmount' => 'double',
        'totalPrincipal' => 'double',
        'discountInterestOverdue' => 'double',
        'discountFollowUp' => 'double',
        'totprc' => 'double'
    ];

    public function user_api()
    {
        return $this->belongsTo(user_api::class, 'customerId', 'data_customer_id');
    }
}
