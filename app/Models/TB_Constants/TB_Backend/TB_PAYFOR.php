<?php

namespace App\Models\TB_Constants\TB_Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TB_PAYFOR extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'TB_PAYFOR';
    protected $fillable = [
                            'FORCODE' ,'FORDESC' ,'SNCSET' ,'TAXFL' ,'MEMO1' ,'ACC_CODE',
                            'REGFL' ,'ESTPRICE' ,'STATUS' ,'FORDEP','STATUSREG'
                        ];

    public static function generatePaycode() {
        $resoure = TB_PAYFOR::where('STATUS','Y')
            ->orderBY('id', 'asc')
            ->get();
        return $resoure;
    }
}
