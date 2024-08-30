<?php

namespace App\Models\TB_Assets;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Models\TB_Assets\Data_Assets;
use App\Models\TB_Assets\Data_AssetsOwnership;

use App\Models\TB_Constants\TB_Frontend\TB_TypeAssetsIns;
use App\Models\TB_Constants\TB_Frontend\TB_TypeAssetsPoss;

class Data_AssetsDetails extends Model
{
    protected $table = 'Data_AssetsDetails';
    protected $fillable = ['FlagEdit_AssetDetails','DataAssetOwn_Id',
                            'OccupiedDT','OccupiedTime',
                            'InsuranceType_Code','InsuranceState','InsuranceClass','InsuranceCompany_Id','PolicyNumber','InsuranceDT','InsuranceActDT','InsuranceRegisterDT','PurposeType','PossessionState_Code',
                            'PossessionOrder','History_16','History_18',
                            'MilesNumber',

                            'MidPrice', 'OccupiedDate',

                            'UserZone','UserBranch','UserInsert','UserUpdate'];

    /*
    public function DeatilToAsset()
    {
        # 1 AssetDetail จะมีได้เพียง 1 Asset
        return $this->belongsTo(Data_Assets::class,'DataAsset_Id','id');
    }

    public function AssetToTypeIns() // เหมือนจะไม่ได้ใช้แล้ว
    {
        return $this->hasOne(TB_TypeAssetsIns::class,'Code_TypeIns','InsuranceType_Code');
    }
    */

    public function DeatilToAssetOwner()
    {
        # 1 AssetDetail จะมีได้เพียง 1 Asset
        return $this->hasOne(Data_AssetsOwnership::class,'DataAssetOwn_Id','id');
    }

    public function AssetToTypePoss()
    {
        return $this->hasOne(TB_TypeAssetsPoss::class,'Code_TypePoss','PossessionState_Code');
    }

    public function CheckExpired(string $type, bool $warning)
    {
        $result = false;
        switch ($type) {
            case 'InsuranceDT':
                $getDate = $this->InsuranceDT;
                break;
            case 'InsuranceActDT':
                $getDate = $this->InsuranceActDT;
                break;
            case 'InsuranceRegisterDT':
                $getDate = $this->InsuranceRegisterDT;
                break;
            default:
                $getDate = null;
                break;
        }
        if ($getDate != null) {
            $today = Carbon::now();
            $inputDate = substr($getDate, -10);
            $dateExp = Carbon::parse($inputDate);
            if ($warning) {
                $nextDayCheck = Carbon::now()->addDay(30);
                if ($dateExp->between($today, $nextDayCheck)) {
                    $result = true;
                }
            } else {
                if ($today->gt($dateExp)) {
                    $result = true;
                }
            }
        }
        return $result;
    }

}

