<?php

namespace App\Models\TB_DataCus;

use Illuminate\Database\Eloquent\Model;
use App\Models\TB_DataCus\Data_Customers;
use App\Models\TB_Constants\TB_Frontend\TB_CareerCus;

use App\Models\TB_PactContracts\Pact_ContractsGuarantor;

class Data_CusCareers extends Model
{
    protected $table = 'Data_CusCareers';
    protected $fillable = ['DataCus_id',
                            'date_Cus','Code_Cus','Ordinal_Cus','Status_Cus',
                            'Career_Cus','DetailCareer_Cus','Workplace_Cus','Income_Cus',
                            'BeforeIncome_Cus','AfterIncome_Cus','IncomeNote_Cus',
                            'UserZone','UserBranch','UserInsert','Main_Career'];

    public function CusCareerToDataCus()
    {
        return $this->belongsTo(Data_Customers::class,'DataCus_id','id');
    }

    public function CusCareerToTBCareerCus()
    {
        return $this->hasOne(TB_CareerCus::class,'Code_Career','Career_Cus');
    }

    public function CusCareerToGuarantor()
    {
        return $this->belongsTo(Pact_ContractsGuarantor::class,'id','GuaranCareers_id');
    }
}
