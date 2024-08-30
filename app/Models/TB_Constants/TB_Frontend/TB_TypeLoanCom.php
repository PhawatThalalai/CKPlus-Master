<?php

namespace App\Models\TB_Constants\TB_Frontend;

use App\Models\TB_Constants\TB_Frontend\TB_Company;
use App\Models\TB_DataCus\Data_CusTagCalculate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TB_TypeLoanCom extends Model
{
    use HasFactory;

    protected $table = 'TB_TypeLoanCom';
    protected $fillable = ['Flag_Zone','Code_PLT','id_rateType','Loan_Code','Loan_Name','Loan_Group','Loan_Com','Id_Com','Loantype_Con','Description','Flag'];
                            

    public function TypeLoanToCompany()
    {
        return $this->hasOne(TB_Company::class,'id','Id_Com');
    }

  
    public static function generateQuery() {
        $zone = auth()->user()->zone;
        $resoure = TB_TypeLoanCom::where('Flag_Zone',$zone)->orderBY('Loan_Code')->get();
      return $resoure;
    }
}
