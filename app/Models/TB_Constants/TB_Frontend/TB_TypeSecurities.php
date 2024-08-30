<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

use App\Models\TB_PactContracts\Pact_ContractsGuarantor;

class TB_TypeSecurities extends Model
{
    protected $table = 'TB_TypeSecurities';
    protected $fillable = ['Flag_Secur','Code_Secur','Date_Secur','Name_Secur','Memo_Secur'];

    public function TypeSecuritiesToGuarantor()
    {
        return $this->hasMany(Pact_ContractsGuarantor::class,'TypeSecurities_Guar','Code_Secur');
    }

    public static function getTypeSecurities() {
       $data =  TB_TypeSecurities::where('Flag_Secur','yes')->get();
       return $data;
    }

}
