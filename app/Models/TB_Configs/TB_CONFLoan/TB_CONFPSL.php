<?php

namespace App\Models\TB_Configs\TB_CONFLoan;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TB_CONFPSL extends Model
{
    use HasFactory;
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
}
