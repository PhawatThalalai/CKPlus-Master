<?php

namespace App\Models\TB_PactContracts;

use Illuminate\Database\Eloquent\Model;

use App\Models\TB_Constants\TB_Frontend\TB_RelationsCus;
use App\Models\TB_Constants\TB_Frontend\TB_TypeSecurities;

use App\Models\TB_DataCus\Data_Customers;
use App\Models\TB_DataCus\Data_CusCareers;
use App\Models\TB_DataCus\Data_CusAddress;
use App\Models\TB_DataCus\Data_CusAssets;
use App\Models\TB_PactContracts\Pact_Contracts;
use App\Models\TB_PactContracts\Pact_ContractsGuar_Assets;
use App\Models\User;

use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Pact_ContractsGuarantor extends Model
{
    protected $table = 'Pact_ContractsGuarantor';
    protected $fillable = [ 'DataTag_id','PactCon_id','Guarantor_id','TypeRelation_Cus',

                            'GuaranAdds1_id','GuaranAdds2_id','GuaranAsset_id','TypeSecurities_Guar','GuaranCareers_id',

                            'UserZone','UserBranch','UserInsert'];


    public function GuarantorToContract()
    {
        return $this->belongsTo(Pact_Contracts::class,'PactCon_id','id');
    }

    public function GuarantorToGuarantorCus()
    {
        return $this->belongsTo(Data_Customers::class,'Guarantor_id','id');
    }

    public function GuarantorToTypeRelation()
    {
        return $this->hasOne(TB_RelationsCus::class,'Code_Rela','TypeRelation_Cus');
    }

    public function GuarantorToTypeSecurities()
    {
        return $this->hasOne(TB_TypeSecurities::class,'Code_Secur','TypeSecurities_Guar');
    }

    public function DataCusToDataGuarCareer()
    {
        return $this->hasOne(Data_CusCareers::class,'id','GuaranCareers_id');
    }
    public function GuarantorToDataGuarAdds()
    {
        return $this->hasOne(Data_CusAddress::class,'id','GuaranAdds1_id');
    }
    public function GuarantorToDataGuarAsset()
    {
        return $this->hasMany(Pact_ContractsGuar_Assets::class,'PactCon_id','PactCon_id');
    }

    public function GuarantorToDataCusAssetLast()
    {
        return $this->hasOne(Data_CusAssets::class,'DataCus_id','Guarantor_id')->latest();
    }

    public function GuarantortoUser()
    {
        return $this->belongsTo(User::class,'UserInsert','id');
    }




}

