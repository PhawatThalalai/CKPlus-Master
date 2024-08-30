<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

class Data_CreditBanks extends Model
{
    protected $table = 'Data_CreditBanks';
    protected $fillable = ['Bank_id'  ,'PactCon_id','Date_CreditIn' ,'Credit_Daliy' ,'Credit_Balance' ,'Amount','Status_Pay','Bank_Zone','UserInsert'];
}
