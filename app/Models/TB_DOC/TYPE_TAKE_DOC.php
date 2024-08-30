<?php

namespace App\Models\TB_DOC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TYPE_TAKE_DOC extends Model
{
    use HasFactory;
    protected $table = 'TB_TYPE_TAKE';
    protected $fillable = [
        'id', 'name_th', 'name_en', 'flag_st', 'created_at' ,'updated_at'
    ];
}
