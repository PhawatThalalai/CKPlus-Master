<?php

namespace App\Models\api\view;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\api\user_api;

class view_leasingAccounts extends Model
{
    use HasFactory;

    //protected $connection = 'sqlsrv2';
    protected $table = 'View_getLeasingAccount';
    protected $fillable = [
        'accountId',
        'datacus_id',
        'datapact_id',
        'typecon',
        'accountStatus',
        'typeId',
        'typeName',
        'typeModel',
        'typeLicense',
        'typeProvince',
        'totalAmount',
        'totalPaid',
        'totalBalance',
        'periodNo',
        'periodCount',
        'paidPerPeriod',
        'paymentDueDate',
        'updateTime',
        'creditHealth',
        'contractNo',
        'customerId',
        'contractValue',
        'capitalValue',
        't_nopay',
        'tot_upay',
        'startDate',
        'paidDueDate',
        'overdueInterest',
        'overdueFollowUp',
        'overduePaid'
    ];

    public function user_api()
    {
        return $this->belongsTo(user_api::class, 'datacus_id');
    }

}
