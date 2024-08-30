<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

class TB_TypeUnregulatedLoan extends Model
{
    protected $table = 'TB_TypeUnregulatedLoan';
    protected $fillable = ['Flag_Unreg','Code_PLT','Code_Unreg','Date_Unreg','Name_Unreg','Memo_Unreg'];

    public static function generateQuery() {
        $resoure = TB_TypeUnregulatedLoan::where('Flag_Unreg','yes')
            ->orderBY('id', 'asc')
            ->get();

        return $resoure;
    }
}
