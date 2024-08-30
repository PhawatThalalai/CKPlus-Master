<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

class TB_TypeLoanRegulations extends Model
{
    protected $table = 'TB_TypeLoanRegulations';
    protected $fillable = ['Flag_Loan','Code_PLT','Code_Loan','Date_Loan','Name_Loan','Memo_Loan'];

    public static function generateQuery() {
        $resoure = TB_TypeLoanRegulations::where('Flag_Loan','yes')
            ->orderBY('id', 'asc')
            ->get();

        return $resoure;
    }
}
