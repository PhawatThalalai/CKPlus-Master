<?php

namespace App\Models\TB_PactContracts;

use Illuminate\Database\Eloquent\Model;
use App\Models\TB_PactContracts\Pact_Contracts;
use App\Models\TB_DataBroker\Data_Broker;
use App\Models\TB_Commission\Commission_Broker;
use App\Models\TB_DataCus\Data_Customers;
use App\Models\TB_DataCus\Data_CusCareers;
use App\Models\TB_DataCus\Data_CusTagCalculate;

class Pact_Operatedfees extends Model
{
    protected $table = 'Pact_Operatedfees';
    protected $fillable = ['Customer_id','DataTag_id','PactCon_id',
                            'Payee_id','Broker_id','FalgCom_Broker','Commission_Broker','SumCom_Broker',
                            'AccountClose_Price','P2_Price','Act_Price','Tax_Price','Insurance_PA',
                            'Process_Price','DuePrepaid_Price',
                            'Tran_Price','Other_Price','Evaluetion_Price','Duty_Price','Marketing_Price','Downpay_Price',
                            'Total_Price','Balance_Price','AccountClose_Place','Note_fee','ReceiveCashBefore','LastTransfer'];

    public function OperatedToContract()
    {
        return $this->belongsTo(Pact_Contracts::class,'PactCon_id','id');
    }
    public function OperatedToBroker()
    {
        return $this->belongsTo(Data_Broker::class,'Broker_id','id');
    }
    public function OperatedToCus()
    {
        return $this->belongsTo(Data_Customers::class,'Payee_id','id');
    }
    public function OperatedToCommission()
    {
        return $this->belongsTo(Commission_Broker::class,'Commission_Broker','id');
    }
    public function OperatedToCusCal()
    {
        return $this->belongsTo(Data_CusTagCalculate::class,'DataTag_id','DataTag_id');
    }
    public function OperatedToBrokerPayee()
    {
        return $this->belongsTo(Data_Broker::class,'BRK_Payee','id');
    }

}
