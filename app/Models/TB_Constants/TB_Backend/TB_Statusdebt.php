<?php

namespace App\Models\TB_Constants\TB_Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TB_Statusdebt extends Model
{
    use HasFactory;


    protected $table = 'TB_Statusdebt';
    protected $fillable = ['status','code','name'];
}

