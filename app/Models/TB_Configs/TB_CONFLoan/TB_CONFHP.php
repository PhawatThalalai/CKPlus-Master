<?php

namespace App\Models\TB_Configs\TB_CONFLoan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TB_CONFHP extends Model
{
    use HasFactory;
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
}
