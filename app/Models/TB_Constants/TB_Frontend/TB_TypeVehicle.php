<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

class TB_TypeVehicle extends Model
{
    protected $table = 'TB_TypeVehicle';
    protected $fillable = ['Flag_Vehicle','Code_PLT','Date_Vehicle','Name_Vehicle','Cond_Regex','Memo_Vehicle'];



}
