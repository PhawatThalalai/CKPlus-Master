<?php

namespace App\Models\TB_DataCus;

use App\Models\TB_Interests\rate_HY\Rate_HY_InterestCars1;
use Illuminate\Database\Eloquent\Model;
use App\Models\TB_DataCus\Data_CusTags;

use App\Models\TB_Constants\TB_Frontend\TB_TypeLoan;
use App\Models\TB_Constants\TB_Frontend\TB_TypeLoanCom;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_Constants\TB_Frontend\TB_InsurancePA;

use App\Models\TB_Assessments\Stat_CarYear;
use App\Models\TB_Assessments\Stat_MotoYear;

use App\Models\TB_Assets\Data_Assets;
use App\Models\TB_Interests\rate_HY\Rate_HY_LTV;
use App\Models\TB_Interests\rate_HY\Rate_HY_LTVCAR;
use App\Models\TB_Interests\rate_HY\Rate_HY_InterestCars2;
use App\Models\TB_Interests\rate_NK\Rate_NK_InterestCars1;
use App\Models\TB_Interests\rate_NK\Rate_NK_LTV;
use App\Models\TB_Interests\rate_NK\Rate_NK_LTVCAR;
use App\Models\TB_Interests\rate_NK\Rate_NK_InterestCars2;

class Data_CusTagCalculate extends Model
{
    protected $table = 'Data_CusTagCalculates';
    protected $fillable = ['DataCus_id','DataTag_id',
                            'Date_Calcu','CodeLoans','TypeLoans','RateCartypes','RateBrands','RateGroups','RateModals','RateYears','RateGears','RatePrices','Type_PLT',
                            'Promotions','Cash_Car','Process_Car','StatusProcess_Car','Percent_Car','Timelack_Car','Interest_Car','Interestmore_Car','Flag_Interest','totalInterest_Car','InterestYear_Car',
                            'Vat_Rate','Period_Rate','Tax_Rate','Tax2_Rate','Duerate_Rate','Duerate2_Rate','Profit_Rate','TotalPeriod_Rate','TotalPeriodNonPa','TypeAssetsPoss',
                            'DateOccupiedcar','NumDateOccupiedcar','RatePrice_Car','Cus_grade','Payment_Due','Payment_Status','TotalLand_Rate','Insurance','Insurance_PA','Plan_PA',
                            'Rate_ownership1','Rate_ownership2','Rate_ownership3','Rate_ownership4','Rate_ownership5','Rate_trade1','Rate_trade2','Rate_trade3','Commission','Note_Cal','Note_Credo','Prices_balance','Result_rate','UserZone','UserBranch','UserInsert'];

    public function DataCalcuToDataTag()
    {
        return $this->belongsTo(Data_CusTags::class,'DataTag_id','id');
    }
    public function DataCalcuToTypeLoan()
    {
        return $this->belongsTo(TB_TypeLoan::class,'CodeLoans','Loan_Code');
    }
    public function DataCalcuToCarYear()
    {
        return $this->belongsTo(Stat_CarYear::class,'RateYears','id');
    }
    public function DataCalcuToMotoYear()
    {
        return $this->belongsTo(Stat_MotoYear::class,'RateYears','id');
    }
    public function DataCalcuToBranch()
    {
        return $this->belongsTo(TB_Branchs::class,'UserBranch','id');
    }
    public function DataCalcuToAsset()
    {
        return $this->hasOne(Data_Assets::class,'id','dataTagCal_id');
    }
    public function DataCalcuToPA()
    {
        return $this->hasOne(TB_InsurancePA::class,'id','Plan_PA');
    }
    public function DataCalcuToRateHY()
    {
        return $this->hasMany(Rate_HY_LTV::class,'TypeLeasing','CodeLoans');
    }
    public function DataCalcuToRateHYLTVCAR()
    {
        return $this->hasOne(Rate_HY_LTVCAR::class,'IdYears','RateYears');
    }
    public function DataCalcuToRateNK()
    {
        return $this->hasMany(Rate_NK_LTV::class,'TypeLeasing','CodeLoans');
    }
    public function DataCalcuToRateNKLTVCAR()
    {
        return $this->hasOne(Rate_NK_LTVCAR::class,'IdYears','RateYears');
    }

    public function DataCalcuToInterestHY()
    {
        return $this->hasMany(Rate_HY_InterestCars2::class,'Type_Leasing','CodeLoans');
    }
    public function DataCalcuToInterestNK()
    {
        return $this->hasMany(Rate_NK_InterestCars2::class,'Type_Leasing','CodeLoans');
    }
    public function DataCalcuToInterestHY01()
    {
        return $this->hasMany(Rate_HY_InterestCars1::class,'Type_Leasing','CodeLoans');
    }
    public function DataCalcuToInterestNK01()
    {
        return $this->hasMany(Rate_NK_InterestCars1::class,'Type_Leasing','CodeLoans');
    }

    public function ContractToTypeLoanLast()
    {
        return $this->hasOne(TB_TypeLoanCom::class,'Loan_Code','CodeLoans')->where('Flag','Y')->where('Flag_Zone',$this->UserZone);
    }
    
    public function CheckAssetNotCreated()
    {
        $result = false;
        if ($this->TypeLoans == 'car') {
            if ($this->RateCartypes == null || $this->RateBrands == null || $this->RateGroups == null || $this->RateModals == null || $this->RateYears == null || $this->RateGears == null ) {
                return false;
            }
            $dataAsset = Data_Assets::where('DataCus_Id', $this->DataCus_id)
                ->where('Status_Asset', 'Active')
                ->where('Vehicle_Type', $this->RateCartypes)
                ->where('Vehicle_Brand', $this->RateBrands)
                ->where('Vehicle_Group', $this->RateGroups)
                ->where('Vehicle_Model', $this->RateModals)
                ->where('Vehicle_Year', $this->RateYears)
                ->where('Vehicle_Gear', $this->RateGears)
                ->first();
            $result = ($dataAsset == null);
        } elseif ($this->TypeLoans == 'moto') {
            if ($this->RateCartypes == null || $this->RateBrands == null || $this->RateGroups == null || $this->RateModals == null || $this->RateYears == null) {
                return false;
            }
            $dataAsset = Data_Assets::where('DataCus_Id', $this->DataCus_id)
                ->where('Status_Asset', 'Active')
                ->where('Vehicle_Type', $this->RateCartypes)
                ->where('Vehicle_Brand', $this->RateBrands)
                ->where('Vehicle_Group', $this->RateGroups)
                ->where('Vehicle_Model', $this->RateModals)
                ->where('Vehicle_Year', $this->RateYears)
                ->first();
            $result = ($dataAsset == null);
        }
        return $result;
    }

    public function hasCreatedAsset(): bool
    {
        if ($this->TypeLoans == 'car' || $this->TypeLoans == 'moto') {
            return Data_Assets::where('dataTagCal_id', $this->id)->exists();
        } else {
            return false;
        }
    }

    public function getYearVehValue()
    {
        if ($this->RateYears == null) {
            return null;
        } else {
            if ($this->TypeLoans == 'car') {
                return Stat_CarYear::select('Year_car')->where('id', $this->RateYears)->first()->Year_car;
            } elseif ($this->TypeLoans == 'moto') {
                return Stat_MotoYear::select('Year_moto')->where('id', $this->RateYears)->first()->Year_moto;
            }
        }
    }

}
