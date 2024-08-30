<?php

namespace App\Models\TB_Configs;

use App\Models\TB_Constants\TB_Frontend\TB_CrossBank;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config_CrossBanks extends Model
{
    use HasFactory;
    
    protected $table = 'Config_CrossBanks';
    protected $fillable = ['cross_id' ,'HeadRecType' ,'HeadSeqNo' ,'HeadBankCode' ,'HeadCompAcc' ,'HeadCompName' ,'HeadEffDate' ,'HeadServiceCode',
            'DetailRecType' ,'DetailSeqNo' ,'DetailBankCode' ,'DetailCompAcc' ,'DetailPaymentDate' ,'DetailPaymentTime' ,'DetailCustName' ,'DetailRef1',
            'DetailRef2' ,'DetailRef3' ,'DetailBranchNo' ,'DetailTellerNo' ,'DetailKindTransaction' ,'DetailTransactionCode' ,'DetailChequeNo' ,'DetailAmount',
            'DetailChequeBankCode' ,
            'TotalRecType' ,'TotalSeqNo' ,'TotalBankCode' ,'TotalCompAccode' ,'TotalDebitAmount' ,'TotalDebitTransaction' ,'TotalCreditAmount', 'TotalCreditTransaction'];

    public function cf_Crossbank()
    {
        return $this->belongsTo(TB_CrossBank::class,'cross_id','id');
    }
}
