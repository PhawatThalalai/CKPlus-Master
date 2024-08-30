<?php

namespace App\Models\TB_Interests\rate_KB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rate_KB_InterestCars02 extends Model
{
    protected $table = 'Rate_KB_InterestCars02';
    protected $fillable = [ 'Flag'    ,'Status_Code'    ,'Type_leasing'    ,'Possession_month'    ,'Car_yearS'    ,'Car_yearE'
    ,'LTV'    ,'Interrest_car'    ,'Grade'];
}
