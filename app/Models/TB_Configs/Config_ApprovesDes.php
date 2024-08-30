<?php

namespace App\Models\TB_Configs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config_ApprovesDes extends Model
{
    use HasFactory;
    protected $table = 'TB_ConfigApproveDes';
    protected $fillable = [
        'Code_des',
        'TxtAsset',
        'TxtGuaran',
        'TxtPayee',
        'TxtBroker',
        'TxtExpenses',
        'TxtApprove'
    ];
}
