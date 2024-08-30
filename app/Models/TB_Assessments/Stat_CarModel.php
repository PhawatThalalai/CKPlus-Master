<?php

namespace App\Models\TB_Assessments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stat_CarModel extends Model
{
    use SoftDeletes;
    protected $table = 'Stat_CarModel';
    protected $fillable = ['id' ,'Brand_id' ,'Group_id' ,'Ratetype_id' ,'Model_car' ,'Tank_No','Topcar','UserZone','UserBranch','UserInsert'];
    public function modelToBrandCar()
    {
      return $this->belongsTo(Stat_CarBrand::class,'Brand_id','id');
    }
    public function modelToGroupCar()
    {
      return $this->belongsTo(Stat_CarGroup::class,'Group_id','id');
    }
    public function modelCartype()
    {
      return $this->belongsTo(Stat_rateType::class,'Ratetype_id','code_car');
    }

    public static function getModelArray()
    {
        return static::select('id', 'Model_car AS model')
            ->pluck('model','id')
            ->toArray();
    }

    public static function getModelArrayWithTopcar()
    {
        return static::select('id','Model_Car AS model', 'Topcar')
          ->where('Status_model','!=','no')
          ->orWhereNull('Status_model')
          ->get()
          ->groupBy('id')
          ->map(function ($item) {
              return [
                  'name' => $item[0]->model,
                  'Topcar' => $item[0]->Topcar
              ];
          })
          ->toArray();
    }

}
