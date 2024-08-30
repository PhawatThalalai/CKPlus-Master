<?php

namespace App\Models\TB_PactContracts;

use Illuminate\Database\Eloquent\Model;

use App\Models\TB_DataCus\Data_CusAssets;
use App\Models\TB_PactContracts\Pact_Contracts;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pact_ContractsGuar_Assets extends Model
{
    use SoftDeletes;
    protected $table = 'Pact_ContractsGuar_Assets';
    protected $fillable = [ 'DataTag_id','PactCon_id','Guarantor_id','GuarAsset_id',
                            
                            'UserZone','UserBranch','UserInsert'];

    
    public function GuarAssetToContract()
    {
        return $this->belongsTo(Pact_Contracts::class,'PactCon_id','id');
    }

    public function GuarAssetToDataCusAsset()
    {
        return $this->hasOne(Data_CusAssets::class,'id','GuarAsset_id');
    }
 
}

