<?php

namespace App\Models\TB_Interests\rate_PTN;

use Illuminate\Database\Eloquent\Model;
use App\Models\TB_Assessments\Stat_rateType;

class Rate_PTN_InterestCars02 extends Model
{
    protected $table = 'Rate_PTN_InterestCars02';
    protected $fillable = ['FlagRate','Ratetype_rate','YearStart_rate','YearEnd_rate','InstalmentStart_rate','InstalmentEnd_rate','Interest_rate'];
}
