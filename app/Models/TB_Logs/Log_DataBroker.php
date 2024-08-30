<?php

namespace App\Models\TB_Logs;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\TB_Data_Broker\Data_Broker;
class Log_DataBroker extends Model
{
    protected $table = 'Log_DataBroker';
    protected $fiallable = ['id','Data_id','date','status','model','tagInput','details','UserInsert'];

    public function LogsBRKToUser()
    {
        return $this->belongsTo(User::class,'UserInsert','id');
    }
    public function LogsBRKToBroker()
    {
        return $this->belongsTo(Data_Broker::class,'Data_id','id');
    }
}
