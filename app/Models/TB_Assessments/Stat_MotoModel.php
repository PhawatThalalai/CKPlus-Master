<?php

namespace App\Models\TB_Assessments;

use Illuminate\Database\Eloquent\Model;

class Stat_MotoModel extends Model
{
    protected $table = 'Stat_MotoModel';
    protected $fillable = ['id' ,'Brand_id' ,'Group_id' ,'Ratetype_id' ,'Model_moto' ,'Topcar' ,'Tank_No','UserZone','UserBranch','UserInsert'];
    public function modelToBrandMoto()
    {
      return $this->belongsTo(Stat_MotoBrand::class,'Brand_id','id');
    }
    public function modelToGroupMoto()
    {
      return $this->belongsTo(Stat_MotoGroup::class,'Group_id','id');
    }
    public function modelMototype()
    {
      return $this->belongsTo(Stat_rateType::class,'Ratetype_id','code_car');
    }

    public static function getModelArray()
    {
        return static::select('id', 'Model_moto AS model')
            ->where('Status_model','!=','no')
            ->orWhereNull('Status_model')
            ->pluck('model','id')
            ->toArray();
    }

}
