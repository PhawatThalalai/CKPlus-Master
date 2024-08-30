<?php

namespace App\Models\TB_Constants\TB_Frontend;
use App\Models\TB_Constants\TB_Frontend\Data_CreditBanks;
use App\Models\TB_Constants\TB_Frontend\TB_Company;

use App\Models\TB_PactContracts\Pact_CreditBanks;
use Illuminate\Database\Eloquent\Model;

class TB_BankAccounts extends Model
{
    protected $table = 'TB_BankAccounts';
    protected $fillable = ['Com_Id' ,'Account_Bank' ,'Account_Name' ,'Account_Number','company_bank','company_type','User_Zone','Flag_Bank','Inside_Active'];

    public function BankToCredit()
    {
        return $this->hasOne(Pact_CreditBanks::class,'Bank_id','id')->latest();
    }
    public function BankToCreditMany()
    {
        return $this->hasMany(Pact_CreditBanks::class,'Bank_id','id')->orderby('id','DESC');
    }
    public function BankToCompany()
    {
        return $this->belongsTo(TB_Company::class,'Com_Id','id');
    }

    

}
