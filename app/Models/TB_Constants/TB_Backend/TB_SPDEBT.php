<?php

namespace App\Models\TB_Constant\TB_Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TB_SPDEBT extends Model
{
    use HasFactory;
    protected $table = 'TB_SPDEBT';
    protected $fillable = ['month_debt','f_date','l_date'];
}
