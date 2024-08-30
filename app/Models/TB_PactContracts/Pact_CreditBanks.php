<?php

namespace App\Models\TB_PactContracts;

use App\Models\TB_PactContracts\Pact_Contracts;
use App\Models\User;
use App\Models\TB_DataCus\Data_Customers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pact_CreditBanks extends Model
{
    use HasFactory;
    protected $table = 'Pact_CreditBanks';
    protected $fillable = [
     'Bank_id'
    ,'Credit_add'
    ,'Amount'
    ,'Bank_Zone'
    ,'UserInsert' ];
    


    public function CreditToUser()
    {
        return $this->hasOne(User::class,'id','UserInsert');
    }
    public function CusRecieveToCus()
    {
        return $this->hasOne(Data_Customers::class,'id','Cus_receive');
    }

    public function ConRecieveToCon()
    {
        return $this->hasOne(Pact_Contracts::class,'id','Con_receive');
    }

}


