<?php

namespace App\Models\TB_Logs;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Log_ContractsOperate extends Model
{
    protected $table = 'Log_ContractsOperate';
    protected $fillable = ['Data_id' ,'date' ,'status' ,'model'  ,'tagInput'  ,'detail'  ,'UserInsert'];

    public function LogsToUser()
    {
        return $this->belongsTo(User::class,'UserInsert','id');
    }
}
