<?php

namespace App\Models\TB_Configs\TB_ConfigsInside;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TB_Billcolls extends Model
{
    use HasFactory;
    protected $table = 'TB_Billcolls';
    protected $fillable = ['name_billcoll'  ,'UserZone' ];
}
