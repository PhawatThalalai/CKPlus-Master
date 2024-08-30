<?php

namespace App\Models\TB_Interests\rate_PTN;

use Illuminate\Database\Eloquent\Model;
use App\Models\TB_Assessments\Stat_rateType;

class Rate_PTN_InterestCars01 extends Model
{
    protected $table = 'Rate_PTN_InterestCars01';
    protected $fillable = ['type_Instalment','FlagRate','Ratetype_rate','YearStart_rate','YearEnd_rate','InstalmentStart_rate','InstalmentEnd_rate','Interest_rate'];

    function InterestToRateType(){
        return $this->belongsTo(Stat_rateType::class,'Ratetype_rate','code_car');
    }
}
