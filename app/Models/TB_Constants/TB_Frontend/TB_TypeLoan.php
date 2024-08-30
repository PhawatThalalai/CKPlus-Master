<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;
use App\Models\TB_DataCus\Data_CusTagCalculate;

use App\Models\TB_Constants\TB_Frontend\TB_Company;
use App\Models\User;

class TB_TypeLoan extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'TB_TypeLoans';
    protected $fillable = ['Code_PLT','id_rateType','Loan_Code','Loan_Name','Loan_Group','Loan_Com','Loantype_Con','Description',
                            'Flagzone_PTN','Flagzone_HY','Flagzone_NK','Flagzone_KB','Flagzone_SR'];

    public function TypeLoanToDataCulcu()
    {
        return $this->hasOne(Data_CusTagCalculate::class,'CodeLoans','Loan_Code');
    }
   
    public function TypeLoanToCompany()
    {
        return $this->hasOne(TB_Company::class,'Company_Type','Loan_Com')->where('Company_Zone', auth()->user()->zone);
    }

  
    public static function generateQuery() {
            $zone = auth()->user()->zone;
            $resoure = TB_TypeLoan::when((@$zone == 10), function($q) {
                    return $q->where('Flagzone_PTN', 'active');
                })
                ->when((@$zone == 20), function($q) {
                    return $q->where('Flagzone_HY', 'active');
                })
                ->when((@$zone == 30), function($q) {
                    return $q->where('Flagzone_NK', 'active');
                })
                ->when((@$zone == 40), function($q) {
                    return $q->where('Flagzone_KB', 'active');
                })
                ->when((@$zone == 50), function($q) {
                    return $q->where('Flagzone_SR', 'active');
                })
                ->get();

      return $resoure;
    }

    public static function getTypeLeasing() {
        $data = TB_TypeLoan::where('Loan_Com','2')->get();
        return $data;
    }
}
