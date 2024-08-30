<?php

namespace App\Models\TB_Assessments;

use Illuminate\Database\Eloquent\Model;

class Stat_MotoGroup extends Model
{
    protected $table = 'Stat_MotoGroup';
    protected $fillable = ['id','Brand_id' ,'Ratetype_id','Group_moto','UserZone','UserBranch','UserInsert'];

    public function groupToBrandMoto()
    {
      return $this->belongsTo(Stat_MotoBrand::class,'Brand_id','id');
    }

    public static function getGroupArray()
    {
        return static::select('id', 'Group_moto AS group')
            ->where('Status_group','!=','no')
            ->orWhereNull('Status_group')
            ->pluck('group','id')
            ->toArray();
    }

}
