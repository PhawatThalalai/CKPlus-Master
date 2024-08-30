<?php

namespace App\Models\TB_Interests\rate_SR;

use Illuminate\Database\Eloquent\Model;

class Rate_SR_LTV_Reference extends Model
{
    protected $table = 'Rate_SR_LTV_Reference';
    protected $fillable = ['Status',

                            'code_car','Brand_id','Group_car_name','Model_car_name','Year_Start','Year_End',

                            'LTV_1','LTV_2','LTV_3','LTV_4','LTV_5','LTV_6','LTV_7',

                            'LTV_8','LTV_9','LTV_10','LTV_11',
                            
                            'Detail_LTV'];

}
