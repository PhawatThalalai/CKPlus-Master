<?php

namespace App\Models\TB_Assessments;

use Illuminate\Database\Eloquent\Model;

class Stat_MotoBrand extends Model
{
    protected $table = 'Stat_MotoBrand';
    protected $fillable = ['id','Brand_moto','UserZone','UserBranch','UserInsert'];

    public static function getBrandArray()
    {
        return static::select('id', 'Brand_moto AS brand')
            ->pluck('brand','id')
            ->toArray();
    }

}
