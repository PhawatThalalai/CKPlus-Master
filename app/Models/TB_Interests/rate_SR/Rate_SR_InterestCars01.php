<?php

namespace App\Models\TB_Interests\rate_SR;

use Illuminate\Database\Eloquent\Model;

use App\Models\TB_Constants\TB_Frontend\TB_TypeLoan;

class Rate_SR_InterestCars01 extends Model
{
    protected $table = 'Rate_SR_InterestCars01';
    protected $fillable = ['Flag','TypeLoan_Id','Rating',

                            'Cond_OccupiedTime','Cond_YearStart','Cond_YearEnd','Cond_TotalStart','Cond_TotalEnd',
                            'Cond_InstallmentStart','Cond_InstallmentEnd',
                            
                            'Interest','Fee_Rate','Fee_Min','Fee_Max','Fine_Rate','Installment_REC',
                            
                            'Credo_Cond','Credo_BonusLTV',
                            
                            'Note',];
        
    public function InterestToTypeLoan()
    {
        return $this->hasOne(TB_TypeLoan::class,'id','TypeLoan_Id');
    }
}

