<?php

namespace App\Models\TB_Assets;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//use App\Models\TB_DataCus\Data_CusAssets;
use App\Models\TB_DataCus\Data_Customers;

use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_Constants\TB_Frontend\TB_TypeAssets;
use App\Models\TB_Constants\TB_Frontend\TB_TypeVehicle;
use App\Models\TB_Constants\TB_Frontend\TB_TypeAssetsBldg;

use App\Models\TB_Assessments\Stat_rateType;
use App\Models\TB_Assessments\Stat_CarBrand;
use App\Models\TB_Assessments\Stat_CarGroup;
use App\Models\TB_Assessments\Stat_CarModel;
use App\Models\TB_Assessments\Stat_CarYear;

use App\Models\TB_Assessments\Stat_MotoBrand;
use App\Models\TB_Assessments\Stat_MotoGroup;
use App\Models\TB_Assessments\Stat_MotoModel;
use App\Models\TB_Assessments\Stat_MotoYear;

use App\Models\TB_Assets\Data_AssetsDetails;
use App\Models\TB_Assets\Data_AssetsOwnership;
use App\Models\TB_Configs\Config_JobRunAssets;

use App\Models\TB_PactContracts\Pact_Indentures;
use App\Models\TB_PactContracts\Pact_Indentures_Assets;

use App\Models\User;

class Data_Assets extends Model
{
    use SoftDeletes;

    protected $table = 'Data_Assets';
    protected $fillable = ['Flag_Asset','Code_Asset','Status_Asset','TypeAsset_Code','Price_Asset',

                            'Vehicle_OldLicense','Vehicle_OldLicense_Text','Vehicle_OldLicense_Number','Vehicle_OldLicense_Province',

                            'Vehicle_NewLicense','Vehicle_NewLicense_Text','Vehicle_NewLicense_Number','Vehicle_NewLicense_Province',
                            
                            'Vehicle_Chassis','Vehicle_NewChassis','Vehicle_Engine','Vehicle_Color','Vehicle_Miles','Vehicle_CC','Vehicle_Type',
                            'Vehicle_Brand','Vehicle_Group','Vehicle_Model','Vehicle_Year','Vehicle_Gear',
                            'Land_Type','Land_Id','Land_ParcelNumber','Land_SheetNumber','Land_TambonNumber','Land_Book','Land_BookPage',
                            'Land_SizeRai','Land_SizeNgan','Land_SizeSquareWa',
                            'Land_Zone','Land_Province','Land_District','Land_PostalCode','Land_Coordinates','Land_Detail',
                            'Land_BuildingType','Land_BuildingKind','Land_BuildingStorey','Land_BuildingSize',
                            'dataTagCal_id',
                            'UserZone','UserBranch','UserInsert','UserUpdate','CRCOST'];

    public function AssetToTypeAsset()
    {
        return $this->hasOne(TB_TypeAssets::class,'Code_TypeAsset','TypeAsset_Code');
    }

    public function AssetToAssetDeatil()
    {
        # old
        #return $this->hasOne(Data_AssetsDetails::class,'DataAsset_Id','id');
        # new
        return $this->hasOneThrough(
            Data_AssetsDetails::class,
            Data_AssetsOwnership::class,
            'DataAsset_Id', // Foreign key on the environments table...
            'id', // Foreign key on the deployments table...
            'id', // Local key on the projects table...
            'DataAssetDetail_Id' // Local key on the environments table...
        );
    }

    /*
    public function AssetToDataCus()
    {
        return $this->hasOne(Data_Customers::class,'id','DataCus_Id');
    }
    */

    public function AssetToManyOwner()
    {
        return $this->hasMany(Data_AssetsOwnership::class,'DataAsset_Id','id');
    }

    public function AssetToOwnership()
    {
        return $this->belongsTo(Data_AssetsOwnership::class,'id','DataAsset_Id')->latest();
    }
    public function AssetToDataCus()
    {
        return $this->hasManyThrough(
            Data_Customers::class, Data_AssetsOwnership::class,
            'DataAsset_Id', 'id','id', 'DataCus_Id');
    }

    //------------------
    // รถยนต์/มอเตอร์ไซค์
    //------------------

    public function getYearVehValue()
    {
        if ($this->Vehicle_Year == null) {
            return null;
        } else {
            if ($this->TypeAsset_Code == 'car') {
                return Stat_CarYear::select('Year_car')->where('id', $this->Vehicle_Year)->first()->Year_car;
            } elseif ($this->TypeAsset_Code == 'moto') {
                return Stat_MotoYear::select('Year_moto')->where('id', $this->Vehicle_Year)->first()->Year_moto;
            }
        }
    }

    

    public function getBrandType()
    {
        switch ($this->TypeAsset_Code) {
            case 'car':
                return Stat_CarBrand::select('Brand_car AS Name')->where('id', $this->Vehicle_Brand)->first()->Name;
            case 'moto':
                return Stat_MotoBrand::select('Brand_moto AS Name')->where('id', $this->Vehicle_Brand)->first()->Name;
            case 'land':
                return Stat_rateType::select('nametype_car AS Name')->where('code_car', $this->Land_Type)->first()->Name;
            default:
                return null;
        }
    }

    public function getLicense()
    {
        if ($this->TypeAsset_Code == "land") {
            return $this->Land_ParcelNumber; // เลขที่ดิน
        } else {
            // เช็คทะเบียนใหม่ - input แบบแยก
            if ( empty($this->Vehicle_NewLicense_Text) ) {
                // เช็คทะเบียนใหม่ - input เดิม
                if ( empty($this->Vehicle_NewLicense) ) {
                    // เช็คทะเบียนเก่า - input แบบแยก
                    if ( empty($this->Vehicle_OldLicense_Text) ) {
                        if ( empty($this->Vehicle_OldLicense) ) {
                            return null;
                        } else {
                            return $this->Vehicle_OldLicense;
                        }
                    } else {
                        return $this->Vehicle_OldLicense_Text." ".$this->Vehicle_OldLicense_Number." ".$this->Vehicle_OldLicense_Province;
                    }
                } else {
                    return $this->Vehicle_NewLicense;
                }
                
            } else {
                return $this->Vehicle_NewLicense_Text." ".$this->Vehicle_NewLicense_Number." ".$this->Vehicle_NewLicense_Province;
            }
        }
    }

    public function getModel()
    {
        switch ($this->TypeAsset_Code) {
            case 'car':
                return Stat_CarModel::select('Model_car AS Name')->where('id', $this->Vehicle_Model)->first()->Name;
            case 'moto':
                return Stat_MotoModel::select('Model_moto AS Name')->where('id', $this->Vehicle_Model)->first()->Name;
            case 'land':
                return $this->Land_Province;
            default:
                return null;
        }
    }

    public function getVehMidPrice()
    {
        // If Vehicle Year is not set, return 0
        if (is_null($this->Vehicle_Year)) {
            return 0;
        }
    
        // Check TypeAsset_Code
        if ($this->TypeAsset_Code == 'car') {
            // If Vehicle Gear is not set, return 0
            if (is_null($this->Vehicle_Gear)) {
                return 0;
            }
    
            // Fetch the appropriate price based on Vehicle Gear
            $column = ($this->Vehicle_Gear == 'Auto') ? 'PriceAT_car' : 'PriceMT_car';
            $price = Stat_CarYear::where('id', $this->Vehicle_Year)->value($column);
    
            // Return price or 0 if not found
            return $price ?? 0;
    
        } elseif ($this->TypeAsset_Code == 'moto') {
            // Fetch the price for motorcycles
            $price = Stat_MotoYear::where('id', $this->Vehicle_Year)->value('PriceAT_moto');
    
            // Return price or 0 if not found
            return $price ?? 0;
        }
    
        // Default return 0 if TypeAsset_Code is not recognized
        return 0;
    }
    
    public function getMidPrice()
    {
        if ($this->TypeAsset_Code == 'land') {
            return $this->Price_Asset;
        } elseif ($this->TypeAsset_Code == 'car' || $this->TypeAsset_Code == 'moto') {
            return $this->getVehMidPrice();
        }
        return 0;
    }


    // ประเภทรถ
    public function AssetToCarType()
    {
        return $this->belongsTo(Stat_rateType::class,'Vehicle_Type','code_car');
    }
    // รถยนต์ - ยี่ห้อรถ
    public function AssetToCarBrand()
    {
        return $this->belongsTo(Stat_CarBrand::class,'Vehicle_Brand','id');
    }
    // รถยนต์ - กลุ่มรถ
    public function AssetToCarGroup()
    {
        return $this->belongsTo(Stat_CarGroup::class,'Vehicle_Group','id');
    }
    // รถยนต์ - รุ่นรถ
    public function AssetToCarModel()
    {
        return $this->belongsTo(Stat_CarModel::class,'Vehicle_Model','id');
    }
    //รถยนต์ - ปีรถ
    public function AssetToCarYear()
    {
        return $this->belongsTo(Stat_CarYear::class,'Vehicle_Year','id');
    }

    // มอเตอร์ไซค์ - ยี่ห้อรถ
    public function AssetToMotoBrand()
    {
        return $this->belongsTo(Stat_MotoBrand::class,'Vehicle_Brand','id');
    }
    // มอเตอร์ไซค์ - กลุ่มรถ
    public function AssetToMotoGroup()
    {
        return $this->belongsTo(Stat_MotoGroup::class,'Vehicle_Group','id');
    }
    // มอเตอร์ไซค์ - รุ่นรถ
    public function AssetToMotoModel()
    {
        return $this->belongsTo(Stat_MotoModel::class,'Vehicle_Model','id');
    }
    // มอเตอร์ไซค์ - ปีรถ
    public function AssetToMotoYear()
    {
        return $this->belongsTo(Stat_MotoYear::class,'Vehicle_Year','id');
    }

    public function AssetToTypeVehicle()
    {
        return $this->belongsTo(TB_TypeVehicle::class,'Vehicle_Type_PLT','Code_PLT');
    }

    //------------------
    // ที่ดิน
    //------------------

    // ประเภทที่ดิน
    public function DataAssetToLandType()
    {
        return $this->hasOne(Stat_rateType::class,'code_car','Land_Type');
    }

    //------------------
    // สัญญา
    //------------------

    /* น่าจะเลิกใช้แล้ว */
    public function AssetToPactIndentures()
    {
        return $this->belongsTo(Pact_Indentures::class,'Asset_id','id');
    }

    public function DataAssetToRateType()
    {
        return $this->belongsTo(Stat_rateType::class,'Vehicle_Type','code_car');
    }

    /* ทรัพย์ ชี้ ไปที่สัญญา แบบใหม่ มีหลายทรัพย์ได้ */
    public function AssetToPactIndenturesAsset()
    {
        return $this->belongsTo(Pact_Indentures_Assets::class,'Asset_id','id');
    }

    // TB_TypeAssetsBldg
    public function AssetToTypeAssetsBldg()
    {
        return $this->belongsTo(TB_TypeAssetsBldg::class,'Land_BuildingType','Code_TypeBldg');
    }

    //-----------------
    // แท็กคำนวณ
    //-----------------
    // เก็บ dataTagCal_id
    public function DataAssetToDataCalcu()
    {
        return $this->belongsTo(Data_CusTagCalculate::class,'dataTagCal_id','id');
    }
    public function AssetToBranch()
    {
        return $this->belongsTo(TB_Branchs::class,'UserBranch','id');
    }


    // ทั่วไป
    public function getLastUpdate()
    {
        return '';//max($this->updated_at, $this->AssetToAssetDeatil->updated_at);
    }

    public function getAllInsEXP()
    {
        return Data_AssetsDetails::where('DataAsset_Id', $this->id)->get()->map( function($item) {
            $ins_exp = $item->CheckExpired('InsuranceDT', false);
            $ins_warning = $item->CheckExpired('InsuranceDT', true);

            $ins_act_exp = $item->CheckExpired('InsuranceActDT', false);
            $ins_act_warning = $item->CheckExpired('InsuranceActDT', false);

            $ins_reg_exp = $item->CheckExpired('InsuranceRegisterDT', false);
            $ins_reg_warning = $item->CheckExpired('InsuranceRegisterDT', false);

            $item->setAttribute('InsEXP', $ins_exp);
            $item->setAttribute('InsWarning', $ins_exp);
            $item->setAttribute('InsActEXP', $ins_act_exp);
            $item->setAttribute('InsActWarning', $ins_act_warning);
            $item->setAttribute('InsRegisterEXP', $ins_reg_exp);
            $item->setAttribute('InsRegisterWarning', $ins_reg_warning);

            return collect($item->toArray())
                ->only(['InsEXP', 'InsWarning', 'InsActEXP', 'InsActWarning', 'InsRegisterEXP', 'InsRegisterWarning'])
                ->all();
        });
    }

    public function AssetTogetUserIns()
    {
        return $this->hasOne(User::class,'id','UserInsert')->withTrashed();
    }

    public function getUserInsert()
    {
        if ( is_numeric($this->UserInsert) ) {
            return $this->AssetTogetUserIns->name;
        } else {
            return $this->UserInsert;
        }
    }

    public function canTransfer()
    {
        $owner = $this->AssetToManyOwner()->where(function ($query) {
            $query->where('State_Ownership', 'Active')
                ->orWhere('State_Ownership', 'Process')
                ->orWhere('State_Ownership', 'Transfer');
        });
        return $owner->count() == 0;
    }

    public function isBlacklist()
    {
        return $this->Status_Asset == 'Blacklist';
    }

    public function getOwnerContract()
    {
        return $this->AssetToManyOwner()->where('State_Ownership', 'Contract');
    }


}

