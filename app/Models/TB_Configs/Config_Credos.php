<?php

namespace App\Models\TB_Configs;

use Illuminate\Database\Eloquent\Model;
use App\Models\TB_DataCus\Data_CusTags;
class Config_Credos extends Model
{
    protected $table = 'Config_Credos';
    protected $fillable = ['status' ,'Score_rate' ,'Percen_rate' ,'Notes' ,'UserZone'];
    
    public function ConfigCredoToDataCusTag()
    {
        return $this->belongsTo(Data_CusTags::class,'UserZone','UserZone');
    }
}
