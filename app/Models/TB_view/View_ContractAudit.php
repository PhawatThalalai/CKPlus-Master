<?php

namespace App\Models\TB_view;

use App\Models\TB_PactContracts\Pact_ContractBrokers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View_ContractAudit extends Model
{
    use HasFactory;

    protected $table = 'View_ContractAuditEx1';


    public function ViewAuditToBrokers()
    {
        return $this->hasMany(Pact_ContractBrokers::class,'PactCon_id','id');
    }
}
