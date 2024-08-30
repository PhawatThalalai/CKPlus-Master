<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TB_TypeGroups extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'TB_TypeGroups';

    protected $fillable = [
        'TypeGroup_Status',
        'TypeGroup_Name',
        'TypeGroup_Description'
    ];
}
