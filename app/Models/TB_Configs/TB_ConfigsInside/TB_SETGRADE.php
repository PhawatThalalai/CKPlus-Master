<?php

namespace App\Models\TB_Configs\TB_ConfigsInside;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TB_SETGRADE extends Model
{
    protected $table = 'TB_SETGRADE';
    protected $fillable = ['GRDCOD'  ,'GRDDES'  ,'GRDCAL10'  ,'GRDCAL20'  ,'GRDCAL30'  ,'GRDCAL40'  ,'GRDCAL50'];
}
