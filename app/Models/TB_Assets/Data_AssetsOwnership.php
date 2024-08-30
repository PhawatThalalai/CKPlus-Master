<?php

namespace App\Models\TB_Assets;

use App\Models\TB_PactContracts\Pact_Contracts;
use App\Models\TB_PactContracts\Pact_Indentures_Assets;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\TB_Assets\Data_Assets;
use App\Models\TB_Assets\Data_AssetsDetails;
use App\Models\TB_DataCus\Data_Customers;

use App\Models\User;
use App\Models\TB_Constants\TB_Frontend\TB_statusAssetOwners;

class Data_AssetsOwnership extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'Data_AssetsOwnerships';
    protected $fillable = [
        'State_Ownership',
        'DataCus_Id',
        'DataAsset_Id',
        'CONTSTAT',
        'CLOSAR',
        'UserZone',
        'UserBranch',
        'UserInsert',
        'UserUpdate'
    ];


    public function OwnershipToAsset()
    {
        return $this->hasOne(Data_Assets::class, 'id', 'DataAsset_Id');
    }
    public function OwnershipToAssetDetail()
    {
        return $this->belongsTo(Data_AssetsDetails::class, 'id', 'DataAssetOwn_Id');
    }
    public function OwnershipToCus()
    {
        return $this->hasOne(Data_Customers::class, 'id', 'DataCus_Id');

    }
    public function OwnershipToUser()
    {
        return $this->belongsTo(User::class, 'UserInsert', 'id');
    }
    public function OwnershipToUserUpdate()
    {
        return $this->belongsTo(User::class, 'UserUpdate', 'id');
    }
    public function OwnershipToPactIndenture()
    {
        return $this->belongsTo(Pact_Indentures_Assets::class, 'id', 'Asset_id');
    }

    public function StatusOwnership()
    {
        return $this->hasOne(TB_statusAssetOwners::class, 'name', 'State_Ownership');
    }

}
