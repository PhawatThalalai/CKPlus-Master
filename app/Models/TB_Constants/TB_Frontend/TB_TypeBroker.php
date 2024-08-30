<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

class TB_TypeBroker extends Model
{
    protected $table = 'TB_TypeBroker';
    protected $fillable = ['Flag_typeBroker','Code_typeBroker','Date_typeBroker','Name_typeBroker','Memo_typeBroker'];

    public static function generateQuery() {
        $resoure = TB_TypeBroker::where('Flag_typeBroker','Y')
            ->orderBY('id', 'asc')
            ->get();

        return $resoure;
    }
}
