<?php

namespace App\Models\TB_Configs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TB_ConfigApproveLoanDes extends Model
{
    use HasFactory;

    protected $table = 'TB_ConfigApproveLoanDes';
    protected $fillable = [
        'Code_des',
        'Id_config',
        'Type_title',
        'Status',
        'Value',
        'header',
        'Text_Value'
    ];
}
