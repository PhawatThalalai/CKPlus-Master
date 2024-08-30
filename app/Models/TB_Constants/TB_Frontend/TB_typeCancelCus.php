<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

class TB_typeCancelCus extends Model
{
    protected $table = 'TB_TypeCancelCus';
    protected $fillable = ['Flag_type','Code_type','Date_type','Name_type','Memo_type'];

    public static function generateQuery() {
        $resoure = TB_typeCancelCus::where('Flag_type','yes')
            ->orderBY('Code_type', 'asc')
            ->get();

        return $resoure;
    }
}
