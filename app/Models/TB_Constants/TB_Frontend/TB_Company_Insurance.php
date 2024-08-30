<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

class TB_Company_Insurance extends Model
{
    protected $table = 'TB_Company_Insurance';
    protected $fillable = ['Flag_active', 'CompanayIns_Name'];

}
