<?php

namespace App\Models\TB_Interests\rate_SR;

use Illuminate\Database\Eloquent\Model;

class Rate_SR_LTV extends Model
{
    protected $table = 'Rate_SR_LTV';
    protected $fillable = ['Status_LTV','Rating',

                            'TypeAsset','TypeAssetsPoss','Code_Cus','OccupiedDay_Start','OccupiedDay_End','code_car','Brand_id','Group_car','Evaluate_guar',

                            'LTV','RatePrice','Mod_PCT',
                            
                            'Detail_LTV'];

}
