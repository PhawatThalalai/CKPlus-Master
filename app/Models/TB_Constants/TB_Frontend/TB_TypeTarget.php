<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TB_TypeTarget extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'TB_TypeTarget';
    protected $fillable = ['Target_Code','Target_Name' ,'Target_Status'];

    public static function generateQuery(){
        $type = TB_TypeTarget::where('Target_Status','active')->get();
        return $type;
    }

    public static function generateCode() {
        $Query = TB_TypeTarget::orderBy('id','desc')->first();
        if($Query == NULL){
            $Code = 'TR-'.'001';
        }else{
            $StrNum = substr($Query->Target_Code, -3) + 1;
            $num = "100";
            $SubStr = substr($num.$StrNum, -3);
            $Code = 'TR-'.$SubStr;
        }
        return $Code;
    }
}
