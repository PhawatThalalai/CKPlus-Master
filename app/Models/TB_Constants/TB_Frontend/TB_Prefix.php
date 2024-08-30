<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

class TB_Prefix extends Model
{
    protected $table = 'TB_Prefix';
    protected $fillable = ['flag','Code_Prefix','Detail_Prefix'];


    public static function queryPrefix(){
        $prefix = TB_Prefix::where('flag', 'active')
            ->orderBY('Code_Prefix')
            ->get();
        return $prefix;
    }
}
