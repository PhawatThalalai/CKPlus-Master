<?php

namespace App\Models\TB_Constants\TB_Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TB_TRDELIVER extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'TB_TRDELIVER';
    protected $fillable = [
                            'CODE' ,'NAME' ,'STATUS'
                        ];

    public static function generateCode() {
        $resoure = TB_TRDELIVER::where('STATUS','Y')
            ->orderBY('id', 'asc')
            ->get();
        return $resoure;
    }

    public static function generateCode2() {
        $Query = TB_TRDELIVER::orderBy('id','desc')->first();
        if($Query == NULL){
            $Code = 'DE'.'001';
        }else{
            $StrNum = substr($Query->CODE, -3) + 1;
            $num = "100";
            $SubStr = substr($num.$StrNum, -3);
            $Code = 'DE'.$SubStr;
        }
        return $Code;
    }
}
