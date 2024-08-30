<?php

namespace App\Models\TB_DataCus;

use Illuminate\Database\Eloquent\Model;
use App\Models\TB_DataCus\Data_Customers;
use App\Models\TB_Constants\TB_Frontend\TB_TypeCusAddress;

use App\Models\TB_PactContracts\Pact_ContractsGuarantor;

class Data_CusAddress extends Model
{
    protected $table = 'Data_CusAddress';
    protected $fillable = ['DataCus_id',
                            'date_Adds','Code_Adds','Status_Adds','Ordinal_Adds',
                            'Type_Adds','houseNumber_Adds','houseGroup_Adds','houseZone_Adds','houseProvince_Adds',
                            'building_Adds','village_Adds','roomNumber_Adds','Floor_Adds','alley_Adds','road_Adds',
                            'houseDistrict_Adds','houseTambon_Adds','Postal_Adds','Detail_Adds','Coordinates_Adds','Registration_number',
                            'UserZone','UserBranch','UserInsert'];

    public function DataCusAddsToDataCus()
    {
        return $this->belongsTo(Data_Customers::class,'DataCus_id','id');
    }

    public function DataCusAddsToTypeAdds()
    {
        return $this->hasOne(TB_TypeCusAddress::class,'Code_Address','Type_Adds');
    }

    public function DataCusAddsToGuarantor()
    {
        return $this->belongsTo(Pact_ContractsGuarantor::class,'id','GuaranAdds1_id');
    }

}
