<?php

namespace App\Models\TB_Constants\TB_Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TB_GROUPDEBT extends Model
{
    use HasFactory;

    protected $table = 'TB_GROUPDEBT';
    protected $fillable = [
        'CODE',
        'MEMO',
        'FLAG',
        'FEXP_PRD',
        'TEXP_PRD',
        'LETTER',
    ];


}
