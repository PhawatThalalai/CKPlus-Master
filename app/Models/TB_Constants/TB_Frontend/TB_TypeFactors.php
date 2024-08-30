<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

class TB_TypeFactors extends Model
{
    protected $table = 'TB_TypeFactors';
    protected $fillable = ['Flag_Factors','Code_PLT','Code_Factors','Date_Factors','Name_Factors','Memo_Factors'];

    public static function generateQuery() {
        $resoure = TB_TypeFactors::where('Flag_Factors','yes')
            ->orderBY('id', 'asc')
            ->get();

        return $resoure;
    }
}
