<?php

namespace App\Models\TB_PatchContracts\TB_Payments\PatchHP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatchHP_HEADPAYMENT extends Model
{
    use HasFactory;

    protected $table = 'PatchHP_HEADPAYMENT';
    protected $fillable = [
        'PatchCon_id',
        'LOCAT',
        'INPUTDT',
        'CONTNO',
        'TOTAMT',
        'PAYAMT',
        'BALANC',
        'STATUS',
    ];
}
