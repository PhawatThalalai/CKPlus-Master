<?php

namespace App\Models\TB_Logs;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Log_DataAssets extends Model
{
    protected $table = 'Log_DataAssets';
    protected $fillable = ['id','Data_id','date','status','model','tagInput','details','UserInsert'];

    public function LogsToUser()
    {
        return $this->belongsTo(User::class,'UserInsert','id');
    }
}

