<?php

namespace App\Models\TB_Commission;

use Illuminate\Database\Eloquent\Model;

class Commission_Broker extends Model
{
    protected $table = 'Commission_Brokers';
    protected $fillable = ['Flag','Commission_name','Commission_Interest'];
}
