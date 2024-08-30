<?php

namespace App\Models\TB_Constants\TB_Frontend;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TB_AlertTeams extends Model
{
    use HasFactory;
    protected $table = 'TB_AlertTeams';
    protected $fillable =  ['CodeLoan
    ,Status
    ,message'];
}
