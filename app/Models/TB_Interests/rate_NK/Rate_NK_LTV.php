<?php

namespace App\Models\TB_Interests\rate_NK;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate_NK_LTV extends Model
{
    use HasFactory;
    protected $table = 'Rate_NK_LTV';
    protected $fillable = [
        'LTVCode',
        'TypeLeasing',
        'TypeFn',
        'InArea',
        'OcuStrat',
        'OcuEnd',
        'LTV',
        'Credo',
        'MaxCashCar',
        'TextIncome',
        'TextGuaran',
     ];
}
