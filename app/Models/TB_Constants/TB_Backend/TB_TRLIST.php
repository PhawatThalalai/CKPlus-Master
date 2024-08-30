<?php

namespace App\Models\TB_Constants\TB_Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TB_TRLIST extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'TB_TRLIST';
    protected $fillable = [
                            'CODE' ,'NAME' ,'STATUS'
                        ];

    public static function generateTrackcode() {
        $resoure = TB_TRLIST::where('STATUS','Y')
            ->orderBY('id', 'asc')
            ->get();
        return $resoure;
    }

    public static function generateCode() {
        $Query = TB_TRLIST::orderBy('id','desc')->first();
        if($Query == NULL){
            $Code = 'TR'.'001';
        }else{
            $StrNum = substr($Query->CODE, -3) + 1;
            $num = "100";
            $SubStr = substr($num.$StrNum, -3);
            $Code = 'TR'.$SubStr;
        }
        return $Code;
    }
}
