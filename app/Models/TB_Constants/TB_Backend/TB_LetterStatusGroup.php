<?php

namespace App\Models\TB_Constants\TB_Backend;

use Illuminate\Database\Eloquent\Model;

use App\Models\TB_Constants\TB_Backend\TB_PAYFOR;

class TB_LetterStatusGroup extends Model
{
    protected $table = 'TB_LetterStatusGroup';
    protected $fillable = ['Flag_Letter','Code_Letter','Name_Letter','Cond_HoldStart','Cond_HoldEnd','Pay_Letter','PAYFOR_CODE','Past_Due','Auto_Letter','Memo_Letter'];

    
    public static function generateQuery() {
        $resoure = TB_LetterStatusGroup::where('Flag_Letter','active')->first();
        return $resoure;
    }

    public function LetterToPAYFOR()
    {
        return $this->hasOne(TB_PAYFOR::class,'FORCODE','PAYFOR_CODE');
    }
}
