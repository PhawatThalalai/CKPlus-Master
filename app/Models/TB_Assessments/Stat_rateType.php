<?php

namespace App\Models\TB_Assessments;

use Illuminate\Database\Eloquent\Model;


class Stat_rateType extends Model
{
    protected $table = 'Stat_rateTypes';
    protected $fillable = ['Flag_car','type_car','code_car','nametype_car','UserZone','UserBranch','UserInsert'];

    public static function getRateTypeArray()
    {
        return static::select('code_car', 'nametype_car AS name')
            ->pluck('name','code_car')
            ->toArray();
    }
    
}
