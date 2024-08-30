<?php

namespace App\Models\TB_PactContracts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TB_DataCus\Data_Customers;
use App\Models\User;

use Illuminate\Database\Eloquent\SoftDeletes;
class Pact_ContractBrokers extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'Pact_ContractBrokers';
    protected $fillable = ['PactCon_id','Broker_id','FlagCom_Broker','Commission_Broker','Commission_Broker_Prices','SumCom_Broker'];

    public function BrokertoCus()
    {
        return $this->hasOne(Data_Customers::class,'id','Broker_id');
    }
    public function BrokertoUser()
    {
        return $this->belongsTo(User::class,'UserInsert','id');
    }
    public function BrokertoCon()
    {
        return $this->belongsTo(Pact_Contracts::class,'PactCon_id','id');
    }
}
