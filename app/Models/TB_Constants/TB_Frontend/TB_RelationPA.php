<?php

namespace App\Models\TB_Constants\TB_Frontend;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TB_RelationPA extends Model
{
    use HasFactory;
    protected $table = 'TB_RelationPA';
    protected $fillable = ['code','name'];
}
