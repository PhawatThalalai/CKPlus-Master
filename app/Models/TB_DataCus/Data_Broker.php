<?php

namespace App\Models\TB_DataCus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\TB_DataCus\Data_Customers;
use App\Models\TB_Constants\TB_Frontend\TB_TypeBroker;
class Data_Broker extends Model
{
    use SoftDeletes;
    protected $table = 'Data_Brokers';
    protected $fillable = ['DataCus_id',
                            'status_Broker','date_Broker','type_Broker','nickname_Broker','location_Broker','note_Broker',
                            'Link_Broker','UserZone','UserBranch','UserInsert'];

    public function BrokerToDataCus()
    {
        return $this->belongsTo(Data_Customers::class,'DataCus_id','id');
    }
    public function BrokerToType()
    {
        return $this->belongsTo(TB_TypeBroker::class,'type_Broker','id');
    }
}
