<?php

namespace App\Models\TB_Interests\rate_HY;

use Illuminate\Database\Eloquent\Model;
use App\Models\TB_Constants\TB_Frontend\TB_TypeLoan;
class Rate_HY_InterestCars1 extends Model
{
    protected $table = 'Rate_HY_InterestCars01';
    protected $fillable = [ 'Flag','Year_Start','Year_End','Installment','Interest','Operation_Fee','Percent_Rate1','Percent_Rate2','Percent_Rate3','Percent_Rate4'
    ,'Percent_Rate5','Percent_Rate6','Type_Leasing','Commission','Vat','Credo_Score','Percent_Credo','Percent_Credo_Refi' ];
    
    public function InterestToTypeLoan()
    {
        return $this->belongsTo(TB_TypeLoan::class,'Type_Leasing','Loan_Code');
    }


}
