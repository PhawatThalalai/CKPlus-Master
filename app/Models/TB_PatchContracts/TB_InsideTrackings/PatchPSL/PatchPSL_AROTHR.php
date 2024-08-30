<?php

namespace App\Models\TB_PatchContracts\TB_InsideTrackings\PatchPSL;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\TB_Constants\TB_Backend\TB_PAYFOR;
use App\Models\User;
use App\Models\TB_PactContracts\Pact_Contracts;

class PatchPSL_AROTHR extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'PatchPSL_AROTHR';
    protected $fillable = [
                            'PatchCon_id','Spast_id','ARCONT','TSALE','CONTNO','LOCAT','PAYFOR','PAYAMT','VATRT',
                            'TAXNO','NOPAY','ARDATE','SMPAY','DISCOUNT','SMCHQ','BALANCE','USERID','INPDT','DDATE',
                            'BILLCOLL','FLAG','STATUS','USERDEL','MEMO','UserZone'
                        ];

    public static function generateCode() {
        $Job = PatchPSL_AROTHR::latest('id')->first();
        if($Job == NULL){
            $Code = 'AAR-'.substr(date('Y'),2,2).date('m').'0001';
        }else{
            $StrNum = substr($Job->ARCONT, -4) + 1;
            $num = "1000";
            $SubStr = substr($num.$StrNum, -4);
            $Code = 'AAR-'.substr(date('Y'),2,2).date('m').$SubStr;
        }
        return $Code;
    }
    
    public function PAYCODE()
    {
      return $this->belongsTo(TB_PAYFOR::class,'PAYFOR','FORCODE');
    }

    public function ARBILLCOLL()
    {
      return $this->belongsTo(User::class,'BILLCOLL','id');
    }

    public function PAYUSERID()
    {
      return $this->belongsTo(User::class,'USERID','id');
    }

    public function PatchToPact()
    {
        return $this->belongsTo(Pact_Contracts::class, 'CONTNO', 'Contract_Con');
    }

}
