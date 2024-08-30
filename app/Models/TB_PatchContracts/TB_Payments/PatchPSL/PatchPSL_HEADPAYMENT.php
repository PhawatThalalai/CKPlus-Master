<?php

namespace App\Models\TB_PatchContracts\TB_Payments\PatchPSL;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatchPSL_HEADPAYMENT extends Model
{
    use HasFactory;

    protected $table = 'PatchPSL_HEADPAYMENT';
    protected $fillable = [
        'PatchCon_id',
        'LOCAT',
        'INPUTDT',
        'CONTNO',
        'TOTAMT',
        'PAYAMT',
        'BALANC',
        'STATUS'
    ];
}
