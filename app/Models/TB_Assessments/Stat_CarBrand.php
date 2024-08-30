<?php

namespace App\Models\TB_Assessments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stat_CarBrand extends Model
{
    use SoftDeletes;
    protected $table = 'Stat_CarBrand';
    protected $fillable = ['id','Brand_car','UserZone','UserBranch','UserInsert'];
    

    public static function getBrandArray()
    {
        return static::select('id', 'Brand_car AS brand')
            ->pluck('brand','id')
            ->toArray();
    }
}
