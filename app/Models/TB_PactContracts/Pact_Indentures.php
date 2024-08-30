<?php

namespace App\Models\TB_PactContracts;

use Illuminate\Database\Eloquent\Model;
use App\Models\TB_PactContracts\Pact_Contracts;
use App\Models\TB_DataCus\Data_Customers;
use App\Models\TB_Assets\Data_Assets;
use App\Models\TB_DataCus\Data_CusAddress;
use App\Models\TB_DataCus\Data_CusCareers;

class Pact_Indentures extends Model
{
    protected $table = 'Pact_Indentures';
    protected $fillable = ['DataTag_id','PactCon_id',
                            'Customer_id','CusAddress1_id','CusAddress2_id','CusAddress3_id',
                            'Guarantor_id','TypeRelation_Cus','GuaranAdds1_id','GuaranAdds2_id','TypeSecurities_Guar','GuaranAsset_id',
                            'Asset_id','Installment_Con'];
                            
    public function IndentureToContract()
    {
        return $this->belongsTo(Pact_Contracts::class,'PactCon_id','id');
    }

    public function IndentureToAsset()
    {
        return $this->belongsTo(Data_Assets::class,'Asset_id','id');
    }

    public function IndentureToCus()
    {
        return $this->belongsTo(Data_Customers::class,'Customer_id','id');
    }

    public function IndentureToAdds1()
    {
        return $this->belongsTo(Data_CusAddress::class,'CusAddress1_id','id');
    }
    public function IndentureToAdds2()
    {
        return $this->belongsTo(Data_CusAddress::class,'CusAddress2_id','id');
    }
    public function IndentureToAdds3()
    {
        return $this->belongsTo(Data_CusAddress::class,'CusAddress3_id','id');
    }
    public function IndentureToCusCareer()
    {
        return $this->belongsTo(Data_CusCareers::class,'CusCareer_id','id');
    }

}
