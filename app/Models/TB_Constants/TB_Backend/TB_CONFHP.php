<?php

namespace App\Models\TB_Constants\TB_Backend;

use Illuminate\Database\Eloquent\Model;

class TB_CONFHP extends Model
{
    protected $table = 'TB_CONFHP';
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
        $resoure = TB_CONFHP::where('FLAG','active')->first();

        return $resoure;
    }
}
