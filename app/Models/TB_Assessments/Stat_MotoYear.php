<?php

namespace App\Models\TB_Assessments;

use Illuminate\Database\Eloquent\Model;

class Stat_MotoYear extends Model
{
    protected $table = 'Stat_MotoYear';
    protected $fillable = ['id','Brand_id','Group_id','Model_id','Ratetype_id','Year_moto','PriceAT_moto','PriceAT_old','PriceMT_moto','PriceMT_old','Status_year','UserZone','UserBranch','UserInsert','Link_moto','Profile_moto'];

    public function yearToBrandMoto()
    {
      return $this->belongsTo(Stat_MotoBrand::class,'Brand_id','id');
    }
    public function yearToGroupMoto()
    {
      return $this->belongsTo(Stat_MotoGroup::class,'Group_id','id');
    }
    public function yearToModelMoto()
    {
      return $this->belongsTo(Stat_MotoModel::class,'Model_id','id');
    }
    public function yearMototype()
    {
      return $this->belongsTo(Stat_rateType::class,'Ratetype_id','code_car');
    }

    public function yearToGroupAll()
    {
      return $this->hasMany(Stat_MotoGroup::class,'Brand_id','Brand_id');
    }
    public function yearToModelAll()
    {
      return $this->hasMany(Stat_MotoModel::class,'Group_id','Group_id');
    }
    public function yearToYearAll()
    {
      return $this->hasMany(Stat_MotoYear::class,'Model_id','Model_id');
    }

    public static function getAllMotoData() {
      return static::select(
          'Ratetype_id',
          'Brand_id',
          'Group_id',
          'Year_moto',
          'Model_id',
          'id',
          'PriceAT_moto',
          'PriceMT_moto'
      )
      ->where('Status_year','!=','no')
      ->orWhereNull('Status_year')
      ->orderBy('Ratetype_id')
      ->orderBy('Brand_id')
      ->orderBy('Group_id')
      ->orderBy('Year_moto')
      ->orderBy('Model_id')
      ->get()
      ->groupBy('Ratetype_id')
      ->map(function ($ratetype) {
          return $ratetype->groupBy('Brand_id')
              ->map(function ($brand) {
                  return $brand->groupBy('Group_id')
                      ->map(function ($group) {
                          return $group->groupBy('Year_moto')
                              ->map(function ($year) {
                                  return $year->groupBy('Model_id')
                                      ->map(function ($model) {
                                          return $model->map(function ($item) {
                                              return [
                                                  'year_id' => $item->id,
                                                  'price' => $item->PriceAT_moto,
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
