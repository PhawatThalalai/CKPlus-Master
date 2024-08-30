<?php

namespace App\Models\TB_PactContracts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TB_DataCus\Data_Customers;
use App\Models\User;
use App\Models\TB_PactContracts\Pact_Contracts;

use Illuminate\Database\Eloquent\SoftDeletes;
class Pact_ContractPayee extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'Pact_ContractPayee';
    protected $fillable = ['PactCon_id','Payee_id','UserZone','UserBranch','UserInsert']; 

    public function PayeetoCus()
    {
        return $this->hasOne(Data_Customers::class,'id','Payee_id');
    }
    public function PayeetoUser()
    {
        return $this->belongsTo(User::class,'UserInsert','id');
    }
    public function PayeetoCon()
    {
        return $this->belongsTo(Pact_Contracts::class,'PactCon_id','id');
    }
}
