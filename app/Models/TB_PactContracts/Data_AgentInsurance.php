<?php

namespace App\Models\TB_PactContracts;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data_AgentInsurance extends Model
{
    use HasFactory;

    protected $table = 'Data_AgentInsurance';
    protected $fillable =
    [
    'id',
    'Status_Agent'
    ,'Producercode'
    ,'Code_Agent'
    ,'Step'
    ,'Name_Agent'
    ,'Phone_Agent'
    ,'Limit_Agent'
    ,'Balance'
    ,'Agent_Zone'
    ,'Count_Limit'
    ,'status'
    ,'UserInsert'
    ,'UserUpdate'
    ];
}
