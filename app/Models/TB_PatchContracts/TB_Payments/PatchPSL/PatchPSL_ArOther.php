<?php

namespace App\Models\TB_PatchContracts\TB_Payments\PatchPSL;
use Illuminate\Database\Eloquent\Model;

class PatchPSL_ArOther extends Model
{
    protected $table = 'PatchPSL_ArOther';
    protected $fillable = ['PatchCon_id'  ,'CONTNO'  ,'PAYFOR'  ,'PAYAMT'  ,'ARDATE'  
                ,'SMPAY'  ,'SMCHQ'  ,'BALANCE'  ,'INPDT'  ,'UserInsert'  ,'UserBranch'  ,'UserZone'];    
}
