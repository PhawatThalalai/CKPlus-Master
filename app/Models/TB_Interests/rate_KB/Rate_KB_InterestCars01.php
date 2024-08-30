<?php

namespace App\Models\TB_Interests\rate_KB;

use Illuminate\Database\Eloquent\Model;
use App\Models\TB_Constants\TB_Frontend\TB_TypeLoan;
use App\Models\TB_Constants\TB_Frontend\TB_StatusCustomers;
class Rate_KB_InterestCars01 extends Model
{
    protected $table = 'Rate_KB_InterestCars01';
    protected $fillable = [ 'Status_Code' ,'Adjusted','Possessiontypecar' ,'Possession_rang' ,'Possession_month','Group_Cartype','loanplan',
                'grade' ,'Percen_Rate' ,'Interrests' ,'Payment_Status'  ,'Process_Rate'   ,'Total_Rate'  ,'Rate_Cache',
                'Type_leasing' ,'Type_Loan'  ,'Text_alert'  ,'Text_alert2'];

    public function InterestToTypeLoan()
    {
        return $this->belongsTo(TB_TypeLoan::class,'Type_leasing','Loan_Code');
    }
    public function InterestToStatusCustomers()
    {
        return $this->belongsTo(TB_StatusCustomers::class,'Status_Code','Code_Cus');
    }
}

