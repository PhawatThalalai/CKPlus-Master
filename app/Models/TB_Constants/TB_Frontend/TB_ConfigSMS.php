<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TB_ConfigSMS extends Model
{
    use HasFactory;

    protected $table = 'TB_ConfigSMS';
    protected $fillable = ['status' ,'api_key' ,'secret_key' ,'name' ,'project_key' ,'description'];
}
