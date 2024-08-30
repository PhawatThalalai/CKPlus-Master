<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

use App\Models\TB_PactContracts\Pact_ContractsGuarantor;

class TB_RelationsCus extends Model
{
    protected $table = 'TB_RelationsCus';
    protected $fillable = ['Flag_Rela','Code_Rela','Date_Rela','Name_Rela','Memo_Rela'];

    public function TypeRelationToGuarantor()
    {
        return $this->hasMany(Pact_ContractsGuarantor::class,'TypeRelation_Cus','Code_Rela');
    }

    public static function getRelationsCus() {
       $data =  TB_RelationsCus::where('Flag_Rela','yes')->get();
       return $data;
    }
    
}
