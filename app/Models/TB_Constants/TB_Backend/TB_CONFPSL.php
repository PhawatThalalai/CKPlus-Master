<?php

namespace App\Models\TB_Constants\TB_Backend;

use Illuminate\Database\Eloquent\Model;

class TB_CONFPSL extends Model
{
    protected $table = 'TB_CONFPSL';
    protected $fillable = [
        'id',
        'FLAG', 
        'LATEPER',
        'INT',
        'LATENFINE',
        'VAT',
        'DISCOUNT',
        'MTHDDIS',
        'USEADD',
        'ZONE',
    ];

    public static function generateQuery() {
        $resoure = TB_CONFPSL::where('FLAG','active')->first();

        return $resoure;
    }
}
