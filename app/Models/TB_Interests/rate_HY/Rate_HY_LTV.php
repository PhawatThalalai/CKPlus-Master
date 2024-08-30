<?php

namespace App\Models\TB_Interests\rate_HY;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate_HY_LTV extends Model
{
    use HasFactory;
    protected $table = 'Rate_HY_LTV';
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
