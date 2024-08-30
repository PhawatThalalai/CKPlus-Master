<?php

namespace App\Models\TB_Constants\TB_Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TB_PAYTYP extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'TB_PAYTYP';
    protected $fillable = [
                            'PAYCODE' ,'PAYDESC' ,'RLBILL','SNCSET' ,'MEMO1' ,'ACC_CODE',
                            'ACCTCOD' ,'ACCMSTCOD' ,'STATUS'
                        ];

    public static function generatePayType() {
        $resoure = TB_PAYTYP::where('STATUS','Y')
            ->orderBY('id', 'asc')
            ->get();
        return $resoure;
    }
}
