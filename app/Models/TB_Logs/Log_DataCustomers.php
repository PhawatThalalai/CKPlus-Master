<?php

namespace App\Models\TB_Logs;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Log_DataCustomers extends Model
{
    protected $table = 'Log_DataCustomers';
    protected $fillable = ['id','Data_id','date','status','model','tagInput','details','UserInsert'];

    public function LogsToUser()
    {
        return $this->belongsTo(User::class,'UserInsert','id');
    }
}

