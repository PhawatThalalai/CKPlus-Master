<?php

namespace App\Models\TB_Configs\TB_ConfigsInside;

use Illuminate\Database\Eloquent\Model;

class Config_RunPSL_BillTmp extends Model
{
    protected $table = 'Config_RunPSL_BillTmp';
    protected $fillable = ['Flag_Tags','Code_Tags','Date_Tags','Zone_Tags','UserAdd_Tags'];

    public static function generateJobnumber(){
        $Job = Config_RunPSL_BillTmp::whereYear('Date_Tags',date('Y'))->where('Zone_Tags',auth()->user()->zone)->latest('id')->first();
        if($Job != NULL){
            $StrNum = substr($Job->Code_Tags, -4) + 1;
            $num = "1000";
            $SubStr = substr($num.$StrNum, -4);

            if (substr($Job->Date_Tags,5,2) != date('m')) {
                $CodeJob = 'TAG-'.$Job->Zone_Tags.substr(date('Y'),2,2).date('m').'0001';
            }else {
                $CodeJob = 'TAG-'.$Job->Zone_Tags.substr(date('Y'),2,2).date('m').$SubStr;
            }
        }else{
            $CodeJob = 'TAG-'.auth()->user()->zone.substr(date('Y'),2,2).date('m').'0001';
        }
        return $CodeJob;
    }

    public static function createJobnumber(){
        $Job = Config_RunPSL_BillTmp::whereYear('Date_Tags',date('Y'))->where('Zone_Tags',auth()->user()->zone)->latest('id')->first();
        if ($Job != NULL) {
                $Job->Flag_Tags = NULL;
            $Job->update();
            
            $StrNum = substr($Job->Code_Tags, -4) + 1;
            $num = "1000";
            $SubStr = substr($num.$StrNum, -4);
            
            if (substr($Job->Date_Tags,5,2) != date('m')) {
                $CodeJob = 'TAG-'.$Job->Zone_Tags.substr(date('Y'),2,2).date('m').'0001';
            }else {
                $CodeJob = 'TAG-'.$Job->Zone_Tags.substr(date('Y'),2,2).date('m').$SubStr;
            }
        }else {
            $CodeJob = 'TAG-'.auth()->user()->zone.substr(date('Y'),2,2).date('m').'0001';
        }

        $RunJob = new Config_RunPSL_BillTmp([
            'Flag_Tags' => 'Y',
            'Code_Tags' => $CodeJob,
            'Date_Tags' => date('Y-m-d'),
            'Zone_Tags' => auth()->user()->zone,
            'UserAdd_Tags' => auth()->user()->name,
        ]);
        $RunJob->save();
        
        return $CodeJob;
    }
}
