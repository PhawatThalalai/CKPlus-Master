<?php

namespace App\Models\TB_Interests\rate_HY;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TB_Interests\rate_HY\Rate_HY_LTV;

class Rate_HY_LTVCAR extends Model
{
    use HasFactory;
    protected $table = 'Rate_HY_LTVCAR';
    protected $fillable = [
        'RateCartypes'
        ,'RateBrands'
        ,'RateGroups'
        ,'RateYears'
        ,'RateModals'
        ,'RateGears'
        ,'LTVCode'
        ,'IdYears'
        ,'FlagCar'
     ];

     public function LTVCarToLTV()
     {
         return $this->hasMany(Rate_HY_LTV::class,'LTVCode','LTVCode');
     }
}
