<?php

namespace App\Models\TB_Interests\rate_PTN;

use Illuminate\Database\Eloquent\Model;

class Rate_PTN_InterestCars03 extends Model
{
    protected $table = 'Rate_PTN_InterestCars03';
    protected $fillable = ['FlagRate','Ratetype_rate','YearStart_rate','YearEnd_rate','InstalmentStart_rate','InstalmentEnd_rate','Interest_rate'];
}
