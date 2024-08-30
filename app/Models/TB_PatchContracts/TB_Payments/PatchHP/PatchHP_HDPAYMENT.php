<?php

namespace App\Models\TB_PatchContracts\TB_Payments\PatchHP;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_Contracts;
use Illuminate\Database\Eloquent\Model;

class PatchHP_HDPAYMENT extends Model
{
    protected $table = 'PatchHP_HDPAYMENT';
    protected $fillable = ['PatchCon_id'  ,'TRPID'  ,'LOCAT'   ,'TEMPBILL'  ,'TEMPDATE' ,'CUSCODE' ,'CONTNO'
      ,'TYPCODE' ,'USERECV','BILLCOLL' ,'TOTAMT' ,'INPDATE'  ,'USERID'  ,'REMARK' ,'CANDATE'
      ,'CANCID' ,'FLAG' ,'BILLAMT' ,'APTYPE' ,'ARTYPE' ,'TFDATE' ,'TFTIME' ,'BOOKNO' ,'PAY_ID' ,'POSTGL','STATUS'
      ,'USERDEL','UserInsert'  ,'UserBranch' ,'UserZone'];

    public static function generateCode() {
      $Job = PatchHP_HDPAYMENT::latest('id')->first();
      if($Job == NULL){
          $Code = 'KBI-'.substr(date('Y'),2,2).date('m').'0001';
      }else{
          $StrNum = substr($Job->TEMPBILL, -4) + 1;
          $num = "1000";
          $SubStr = substr($num.$StrNum, -4);
          $Code = 'KBI-'.substr(date('Y'),2,2).date('m').$SubStr;
      }
      return $Code;
    }
}
