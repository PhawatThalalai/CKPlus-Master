<?php

namespace App\Models\TB_Logs;

use App\Models\TB_PactContracts\Pact_Contracts;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Log_ContractsCon extends Model
{
    protected $table = 'Log_ContractsCon';
    protected $fillable = ['Data_id' ,'date' ,'status' ,'model'  ,'tagInput'  ,'details'  ,'UserInsert'];

    public function LogsToUser()
    {
        return $this->belongsTo(User::class,'UserInsert','id');
    }

    public function LogsToPact()
    {
        return $this->hasOne(Pact_Contracts::class,'id','Data_id');
    }
}
