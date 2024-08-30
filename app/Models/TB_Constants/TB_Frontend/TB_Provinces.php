<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

class TB_Provinces extends Model
{
    protected $table = 'TB_Provinces';
    protected $fillable = ['Postcode_pro','Tambon_pro','District_pro','Province_pro','Zone_pro'];
}
