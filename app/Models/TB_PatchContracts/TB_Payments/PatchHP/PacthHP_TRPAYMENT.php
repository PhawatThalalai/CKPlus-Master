<?php

namespace App\Models\TB_PatchContracts\TB_Payments;

use Illuminate\Database\Eloquent\Model;

class PatchHP_TRPAYMENT extends Model
{
    protected $table = 'PatchHP_TRPAYMENT';
    protected $fillable = ['PatchCon_id' ,'LOCAT' ,'TEMPBILL' ,'PAYCODE' ,'PAYDESC' ,'ITEMAMT'
                    ,'DISCOUNT' ,'NETAMT' ,'USERID' ,'INPDATE' ,'FLAG' ,'ARCONTNO'
                    ,'UserInsert'  ,'UserBranch' ,'UserZone'];
}
