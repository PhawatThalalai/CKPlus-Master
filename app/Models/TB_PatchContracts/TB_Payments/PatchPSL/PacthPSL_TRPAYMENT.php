<?php

namespace App\Models\TB_PatchContracts\TB_Payments\PatchPSL;
use App\Models\User;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_Contracts;
use Illuminate\Database\Eloquent\Model;

class PatchPSL_TRPAYMENT extends Model
{
    protected $table = 'PatchPSL_TRPAYMENT';
    protected $fillable = ['PatchCon_id' ,'LOCAT' ,'TEMPBILL' ,'PAYCODE' ,'PAYDESC' ,'ITEMAMT'
                    ,'DISCOUNT' ,'NETAMT' ,'USERID' ,'INPDATE' ,'FLAG' ,'ARCONTNO'
                    ,'UserInsert'  ,'UserBranch' ,'UserZone'];
    
    public function TranToBranch()
    {
        return $this->belongsTo(TB_Branchs::class,'UserBranch','id');
    }
    public function TranToContract()
    {
        return $this->belongsTo(PatchPSL_Contracts::class,'PatchCon_id','id');
    }
    public function TranToUser()
    {
        return $this->belongsTo(User::class,'UserInsert','id');
    }           
}
