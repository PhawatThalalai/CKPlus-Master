<?php

namespace App\Models\TB_Logs;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Log_ContractsBuyer extends Model
{
    protected $table = 'Log_ContractsBuyer';
    protected $fillable = ['Data_id' ,'date' ,'status' ,'model'  ,'tagInput'  ,'detail'  ,'UserInsert'];

    public function LogsToUser()
    {
        return $this->belongsTo(User::class,'UserInsert','id');
    }
}
