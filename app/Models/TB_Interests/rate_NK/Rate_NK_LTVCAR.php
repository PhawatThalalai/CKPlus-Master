<?php

namespace App\Models\TB_Interests\rate_NK;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TB_Interests\rate_NK\Rate_NK_LTV;

class Rate_NK_LTVCAR extends Model
{
    use HasFactory;
    protected $table = 'Rate_NK_LTVCAR';
    protected $fillable = [
        'RateCartypes'
        ,'RateBrands'
        ,'RateGroups'
        ,'RateYears'
        ,'RateModals'
        ,'RateGears'
        ,'LTVCode'
        ,'IdYears'
     ];

     public function LTVCarToLTV()
     {
         return $this->hasMany(Rate_NK_LTV::class,'LTVCode','LTVCode');
     }
}
