<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

class TB_TypeCredo extends Model
{
    
    protected $table = 'TB_TypeCredo';
    protected $fillable = ['Flag_Credo','Code_Credo','Date_Credo','Name_Credo','Memo_Credo'];
    
    public static function generateQuery() {
        $resoure = TB_TypeCredo::where('Flag_Credo','yes')
            ->orderBY('Code_Credo', 'asc')
            ->get();

        return $resoure;
    }
}
