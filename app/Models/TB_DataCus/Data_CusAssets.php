<?php

namespace App\Models\TB_DataCus;

use Illuminate\Database\Eloquent\Model;
use App\Models\TB_DataCus\Data_Customers;
use App\Models\TB_Constants\TB_Frontend\TB_TypeCusAssets;

use App\Models\TB_PactContracts\Pact_ContractsGuarantor;

class Data_CusAssets extends Model
{
    protected $table = 'Data_CusAssets';
    protected $fillable = ['DataCus_id',
                            'date_Asset','Code_Asset','Status_Asset','Ordinal_Asset','Type_Asset','Deednumber_Asset','Area_Asset',
                            'houseZone_Asset','houseProvince_Asset','houseDistrict_Asset','houseTambon_Asset','Postal_Asset',
                            'Coordinates_Asset','Note_Asset','UserZone','UserBranch','UserInsert'];

    public function DataCusAssetToDataCus()
    {
        return $this->belongsTo(Data_Customers::class,'DataCus_id','id');
    }

    public function DataCusAssetToTypeAsset()
    {
        return $this->hasOne(TB_TypeCusAssets::class,'Code_Assets','Type_Asset');
    }

    public function DataCusAssetToGuarantor()
    {
        return $this->belongsTo(Pact_ContractsGuarantor::class,'id','GuaranAsset_id');
    }
}
