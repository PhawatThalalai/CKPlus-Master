<?php

namespace App\Models\TB_Assessments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stat_CarGroup extends Model
{
    use SoftDeletes;
    protected $table = 'Stat_CarGroup';
    protected $fillable = ['id','Brand_id' ,'Ratetype_id','Group_car','UserZone','UserBranch','UserInsert'];

    public function groupToBrandCar()
    {
      return $this->belongsTo(Stat_CarBrand::class,'Brand_id','id');
    }
    public function groupCartype()
    {
      return $this->belongsTo(Stat_rateType::class,'Ratetype_id','code_car');
    }
    public static function getGroupArray()
    {
        return static::select('id', 'Group_car AS group')
            ->where('Status_group','!=','no')
            ->orWhereNull('Status_group')
            ->pluck('group','id')
            ->toArray();
    }
}
