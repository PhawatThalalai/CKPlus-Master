<?php

namespace App\Models\TB_Constants\TB_Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TB_GROUPKANGDUE extends Model
{
    use HasFactory;
    protected $table = 'TB_GROUPKANGDUE';
    protected $fillable = 
    ['GCODE'
    ,'GDESC'
    ,'MEMO1'
    ,'FLAG'
    ,'FEXP_PRD'
    ,'TEXP_PRD'
    ,'LETTER'
    ,'FORCODE'
    ,'COST_FRM'
    ,'COST_TO'
    ,'EXPDAYF'
    ,'EXPDAYT'
    ,'DELAYDAY'];
}
