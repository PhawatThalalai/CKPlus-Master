<?php

namespace App\Models\TB_Assessments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stat_CarYear extends Model
{
    use SoftDeletes;
    protected $table = 'Stat_CarYear';
    protected $fillable = ['id','Brand_id','Group_id','Model_id','Ratetype_id','Year_car','PriceAT_car','PriceAT_old','PriceMT_car','PriceMT_old','UserZone','UserBranch','UserInsert','Link_car','Profile_car'];

    public function yearToBrandCar()
    {
      return $this->belongsTo(Stat_CarBrand::class,'Brand_id','id');
    }
    public function yearToGroupCar()
    {
      return $this->belongsTo(Stat_CarGroup::class,'Group_id','id');
    }
    public function yearToModelCar()
    {
      return $this->belongsTo(Stat_CarModel::class,'Model_id','id');
    }
    public function yearCartype()
    {
      return $this->belongsTo(Stat_rateType::class,'Ratetype_id','code_car');
    }
    
  
   
    public function yearToGroupAll()
    {
      return $this->hasMany(Stat_CarGroup::class,'Brand_id','Brand_id');
    }
    public function yearToModelAll()
    {
      return $this->hasMany(Stat_CarModel::class,'Group_id','Group_id');
    }
    public function yearToYearAll()
    {
      return $this->hasMany(Stat_CarYear::class,'Group_id','Group_id');
    }

    public static function getAllCarData() {
      return static::select(
          'Ratetype_id',
          'Brand_id',
          'Group_id',
          'Year_car',
          'Model_id',
          'id',
          'PriceAT_car',
          'PriceMT_car'
      )
      ->where('Status_year','!=','no')
      ->orWhereNull('Status_year')
      ->orderBy('Ratetype_id')
      ->orderBy('Brand_id')
      ->orderBy('Group_id')
      ->orderBy('Year_car')
      ->orderBy('Model_id')
      ->get()
      ->groupBy('Ratetype_id')
      ->map(function ($ratetype) {
          return $ratetype->groupBy('Brand_id')
              ->map(function ($brand) {
                  return $brand->groupBy('Group_id')
                      ->map(function ($group) {
                          return $group->groupBy('Year_car')
                              ->map(function ($year) {
                                  return $year->groupBy('Model_id')
                                      ->map(function ($model) {
                                          return $model->map(function ($item) {
                                              return [
                                                  'year_id' => $item->id,
                                                  'Auto' => $item->PriceAT_car,
                                                  'Manual' => $item->PriceMT_car,
                                              ];
                                          });
                                      });
                              });
                      });
              });
      })
      ->toArray();
    }

}
