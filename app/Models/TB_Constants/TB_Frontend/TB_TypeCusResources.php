<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;
use App\Models\TB_DataCus\Data_CusTracking;

class TB_TypeCusResources extends Model
{
    protected $table = 'TB_TypeCusResources';
    protected $fillable = ['Flag_CusResource','Code_CusResource','Date_CusResource','Name_CusResource','Memo_CusResource'];

    public function TypeCusReToDataTracking()
    {
        return $this->belongsTo(Data_CusTracking::class,'Code_CusResource','Resource_Customer');
    }

    public static function generateQuery() {
        $resoure = TB_TypeCusResources::where('Flag_CusResource','yes')
            ->orderBY('id', 'asc')
            ->get();

        return $resoure;
    }

    public static function generateCode() {
        $Query = TB_TypeCusResources::orderBy('id','desc')->first();
        if($Query == NULL){
            $Code = 'CRS-'.'0001';
        }else{
            $StrNum = substr($Query->Code_CusResource, -4) + 1;
            $num = "1000";
            $SubStr = substr($num.$StrNum, -4);
            $Code = 'CRS-'.$SubStr;
        }
        return $Code;
    }
}
