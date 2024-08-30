<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

class TB_TypeEmpStatus extends Model
{
    protected $table = 'TB_TypeEmpStatus';
    protected $fillable = ['Flag_Status','Code_PLT','Code_Status','Date_Status','Name_Status','Memo_Status'];

    public static function generateQuery() {
        $resoure = TB_TypeEmpStatus::where('Flag_Status','yes')
            ->orderBY('id', 'asc')
            ->get();

        return $resoure;
    }
}
