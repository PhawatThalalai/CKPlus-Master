<?php

namespace App\Models\TB_Constants\TB_Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TB_TRSTATUSASSET extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'TB_TRSTATUSASSET';
    protected $fillable = [
                            'CODE' ,'NAME' ,'STATUS'
                        ];

    public static function generateCode() {
        $resoure = TB_TRSTATUSASSET::where('STATUS','Y')
            ->orderBY('id', 'asc')
            ->get();
        return $resoure;
    }
}
