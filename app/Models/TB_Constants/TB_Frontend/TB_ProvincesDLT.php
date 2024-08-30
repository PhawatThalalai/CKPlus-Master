<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

class TB_ProvincesDLT extends Model
{
    // use HasFactory;
    protected $table = 'TB_ProvincesDLT';
    protected $fillable = ['Status_pro','Province_pro'];

    public static function getProvincesDLT(){
        $data = TB_ProvincesDLT::where('Status_pro','active')->get();
        return $data;
    }
}
