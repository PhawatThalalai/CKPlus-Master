<?php

namespace App\Models\TB_DataCus;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\TB_Constants\TB_Frontend\TB_Company;
use App\Models\TB_Constants\TB_Frontend\TB_Zone;
use App\Models\TB_Logs\Data_CredoCodes;
use App\Models\TB_PactContracts\Pact_ContractBrokers;
use App\Models\TB_temp\TMP_WAITHOLD\TMP_WAITHOLDHP;

use App\Models\TB_DataCus\Data_CusCareers;
use App\Models\TB_DataCus\Data_CusAddress;
use App\Models\TB_DataCus\Data_CusAssets;
use App\Models\TB_DataCus\Data_CusTags;
use App\Models\TB_DataCus\Data_Broker;

use App\Models\TB_Assets\Data_Assets;
use App\Models\TB_Assets\Data_AssetsOwnership;
use App\Models\User;

use App\Models\TB_PactContracts\Pact_Contracts;
use App\Models\TB_PactContracts\Pact_ContractsGuarantor;

use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_Constants\TB_Frontend\TB_UniqueID_Type;
use App\Models\TB_Constants\TB_Frontend\TB_Prefix;

use App\Models\api\user_api;


class Data_Customers extends Model
{
    use SoftDeletes, HasApiTokens, HasFactory, Notifiable, HasRoles, HasProfilePhoto;

    protected $table = 'Data_Customers';
    protected $fillable = [
        'id',
        'date_Cus',
        'Code_Cus',
        'Status_Cus',
        'type_Cus',
        'Prefix',
        'PrefixOther',
        'Name_Cus',
        'Firstname_Cus',
        'Surname_Cus',
        'Nickname_cus',
        'NameEng_cus',
        'Type_Card',
        'IDCard_cus',
        'Branch_id',
        'IdcardExpire_cus',
        'Status_Com',
        'Birthday_cus',
        'Gender_cus',
        'Phone_cus',
        'Phone_cus2',
        'Marital_cus',
        'Nationality_cus',
        'Religion_cus',
        'Mate_cus',
        'Driver_cus',
        'Namechange_cus',
        'Social_Line',
        'Social_facebook',
        'image_cus',
        'Name_Account',
        'Branch_Account',
        'Number_Account',
        'Note_cus',
        'UserZone',
        'UserBranch',
        'UserInsert',
        'Flag_Con'
    ];

    public function DataCusToDataCusCareer()
    {
        return $this->hasOne(Data_CusCareers::class, 'DataCus_id', 'id')->latest();
    }
    public function DataCusToDataCusAdds()
    {
        return $this->hasOne(Data_CusAddress::class, 'DataCus_id', 'id')->latest();
    }
    public function DataCusToDataCusAddsMany()
    {
        return $this->hasMany(Data_CusAddress::class, 'DataCus_id', 'id');
    }
    public function DataCusToDataCusAsset()
    {
        return $this->hasOne(Data_CusAssets::class, 'DataCus_id', 'id')->latest();
    }
    public function CusToCusTagOne()
    {
        return $this->hasOne(Data_CusTags::class, 'DataCus_id', 'id')->latest();
    }
    public function DataCusToDataCusTag()
    {
        return $this->hasMany(Data_CusTags::class, 'DataCus_id', 'id');
    }
    public function DataCusToAPI()
    {
        return $this->hasOne(user_api::class, 'data_customer_id', 'id');
    }

    /*
    public function DataCusToDataAsset()
    {
        return $this->hasOne(Data_Assets::class,'DataCus_Id','id');
    }
    */
    public function DataCusToAssetOwnership()
    {
        return $this->hasMany(Data_AssetsOwnership::class, 'DataCus_Id', 'id');
    }
    public function DataCusToDataAsset()
    {
        return $this->hasManyThrough(
            Data_Assets::class,
            Data_AssetsOwnership::class,
            'DataCus_Id',
            'id',
            'id',
            'DataAsset_Id'
        );
    }

    public function DataCusToContracts()
    {
        return $this->hasMany(Pact_Contracts::class, 'DataCus_id', 'id')->orderBY('Date_monetary', 'desc');
    }

    public function DataCusToContractsGuarantor()
    {
        return $this->hasMany(Pact_ContractsGuarantor::class, 'Guarantor_id', 'id');
    }

    public function DataCusToContractsBroker()
    {
        return $this->hasMany(Pact_ContractBrokers::class, 'Broker_id', 'id')->latest()->limit(5);
    }
    public function DataCusToConBrokerCount()
    {
        return $this->hasMany(Pact_ContractBrokers::class, 'Broker_id', 'id');
    }
    public function DataCusToBroker()
    {
        return $this->hasOne(Data_Broker::class, 'DataCus_id', 'id');
    }

    public function DataCusMateToDataCus()
    {
        return $this->belongsTo(Data_Customers::class, 'Mate_cus', 'id');
    }
    public function DataCusReferenceToDataCus()
    {
        return $this->belongsTo(Data_Customers::class, 'Reference', 'id');
    }
    public function DataCusToBranch()
    {
        return $this->belongsTo(TB_Branchs::class, 'UserBranch', 'id');
    }
    public function DataCusToTypeCard()
    {
        return $this->belongsTo(TB_UniqueID_Type::class, 'Type_Card', 'Code');
    }
    public function DataCusToDataCusCareerMany()
    {
        return $this->hasMany(Data_CusCareers::class, 'DataCus_id', 'id')->orderby('Main_Career', 'DESC');
    }
    public function DataCusToPrefix()
    {
        return $this->belongsTo(TB_Prefix::class, 'Detail_Prefix', 'Prefix');
    }

    public function DataCusToDataCusAssetsMany()
    {
        return $this->hasMany(Data_CusAssets::class, 'DataCus_id', 'id')->orderby('Main_Asset', 'DESC');
    }

    public function DataCusToDataAssetMany()
    {
        return $this->hasMany(Data_Assets::class, 'DataCus_Id', 'id');
    }

    public function DataCusToDataAssetOne()
    {
        return $this->hasOne(Data_Assets::class, 'DataCus_Id', 'id')->latest();
    }

    public function DataCusToUser()
    {
        return $this->hasOne(User::class, 'id', 'UserInsert')->withTrashed();
    }
    public function DataCusToZone()
    {
        return $this->hasOne(TB_Zone::class, 'Zone_Code', 'UserZone');
    }

    public function DataCusToCom()
    {
        return $this->hasOne(TB_Company::class, 'Company_Id', 'IDCard_cus')->where('Company_Zone', $this->UserZone);
    }

    //-----------------------------------------------------------------------

    // ฟังก์ชัน เรียกจากลูกค้าไปยังสัญญาต่าง ๆ
    public function GuarContracts()
    {
        return $this->hasManyThrough(Pact_Contracts::class, Pact_ContractsGuarantor::class, 'Guarantor_id', 'id', 'id', 'PactCon_id');
    }

    public function BrokerContracts()
    {
        return $this->hasManyThrough(Pact_Contracts::class, Pact_ContractBrokers::class, 'Broker_id', 'id', 'id', 'PactCon_id');
    }

    public function PayeeContracts()
    {
        return $this->hasManyThrough(Pact_Contracts::class, Pact_ContractBrokers::class, 'Broker_id', 'id', 'id', 'PactCon_id');
    }

    public function customerCredo()
    {
        return $this->hasMany(Data_CredoCodes::class, 'data_customer_id', 'id');
    }


    // functions all
    public function is_can_edit_idcard()
    {
        //-------------------------------------------------------------
        // ฟช สำหรับตรวจสอบว่า ลูกค้ามีสัญญาที่สถานะโอนเงินแล้วหรือไม่
        // ถ้ามีสัญญาที่โอนแล้วครอบครองอยู่ ก็จะให้แก้ไม่ได้ (ยกเวินสิทธิ์แอดมิน)
        $con = $this->DataCusToContracts()->where('Status_Con', 'transfered')->exists();
        $guar_con = $this->GuarContracts()->where('Status_Con', 'transfered')->exists();
        $broker_con = $this->BrokerContracts()->where('Status_Con', 'transfered')->exists();
        $payee_con = $this->PayeeContracts()->where('Status_Con', 'transfered')->exists();
        //-------------------------------------------------------------
        // เช็คว่า user เป็นที่กำหนดหรือไม่ ถ้าใช่ จะสามารถแก้ไขได้ โดยไม่สนสถานะสัญญา
        $userArr = ['administrator', 'superadmin', 'audit', 'manager', 'supervisor'];

        $userRole = auth()->user()->getRoleNames();
        $chkUser = $userRole->filter(function ($item) use ($userArr) {
            return in_array($item, $userArr);
        });
        $userPer = count($chkUser) > 0;
        //-------------------------------------------------------------
        return $userPer || ($con === false && $guar_con === false && $broker_con === false && $payee_con === false);
    }
    //-----------------------------------------------------------------------

    public function getUserInsert()
    {
        if (is_numeric($this->UserInsert)) {
            return $this->DataCusToUser->name;
        } else {
            return $this->UserInsert;
        }
    }
    public function apicredoCodes()
    {
        return $this->hasMany(Data_CredoCodes::class, 'data_customer_id', 'id');
    }

    public function CusToHLD()
    {
        return $this->hasOne(TMP_WAITHOLDHP::class, 'DataCus_id', 'id');
    }



}

