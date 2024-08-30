<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

class TB_TypeCalculateInt extends Model
{
    protected $table = 'TB_TypeCalculateInt';
    protected $fillable = ['Status','Code_CalInt','Details_CalInt'];


    public static function getTypeCalculateInt(){
        $data = TB_TypeCalculateInt::
        where('Status','active')->get();
        return $data;
    }
}
