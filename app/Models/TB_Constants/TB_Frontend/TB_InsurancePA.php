<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

class TB_InsurancePA extends Model
{
    protected $table = 'TB_InsurancePA';
    protected $fillable = [
        'PlanId',
        'Plan_Insur',
        'Limit_Insur',
        'TimeRack12',
        'TimeRack18',
        'TimeRack24',
        'TimeRack30'
        ,
        'TimeRack36',
        'TimeRack42',
        'TimeRack48',
        'TimeRack54',
        'TimeRack60'
        ,
        'TimeRack66',
        'TimeRack72',
        'TimeRack78',
        'TimeRack84',
        'DateEnd'
    ];
}
