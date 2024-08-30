<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

class TB_StatusTagParts extends Model
{
    protected $table = 'TB_StatusTagParts';
    protected $fillable = ['Flag_StatusTag','Code_StatusTag','Date_StatusTag','Name_StatusTag','Memo_StatusTag'];

    public static function generateQuery() {
        $resoure = TB_StatusTagParts::where('Flag_StatusTag','yes')
            ->orderBY('id', 'asc')
            ->get();

        return $resoure;
    }
}
