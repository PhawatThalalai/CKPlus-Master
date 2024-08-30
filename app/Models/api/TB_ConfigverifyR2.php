<?php

namespace App\Models\api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TB_ConfigverifyR2 extends Model
{
    use HasFactory;

    protected $table = 'TB_ConfigverifyR2';
    protected $fillable = [
        'code_r1',
        'code_r2',
    ];
}
