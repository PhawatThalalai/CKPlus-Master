<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

class TB_TypePurposeCode extends Model
{
    protected $table = 'TB_TypePurposeCodes';
    protected $fillable = ['Flag_Purpose','Code_PLT','Code_Purpose','Date_Purpose','Name_Purpose','Memo_Purpose'];

    public static function generateQuery() {
        $resoure = TB_TypePurposeCode::where('Flag_Purpose','yes')
            ->orderBY('id', 'asc')
            ->get();

        return $resoure;
    }
}
