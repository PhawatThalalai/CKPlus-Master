<?php

namespace App\Models\api\view;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\api\user_api;

class view_Payments extends Model
{
    use HasFactory;
    //protected $connection = 'sqlsrv2';
    protected $table = 'View_getPaymentDetail';

    protected $fillable = [
        'accountId',
        'customerId',
        'ref1',
        'Company_Id',
        'Company_Branch',
        'ref2',
        'exp_amt',
        'blDue',
        'followAmt',
        'payINTAMT'
    ];

    protected $casts = [
        'exp_amt' => 'double',
        'blDue' => 'double',
        'followAmt' => 'double',
        'payINTAMT' => 'double'
    ];

    public function user_api()
    {
        return $this->belongsTo(user_api::class, 'customerId', 'data_customer_id');
    }
}
