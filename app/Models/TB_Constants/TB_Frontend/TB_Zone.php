<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TB_Zone extends Model
{
    use HasFactory;

    protected $table = 'TB_Zone';
    protected $fillable = ['Zone_Name', 'Zone_Code'];
}
