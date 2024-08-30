<?php

namespace App\Models\TB_PatchContracts\TB_InsideContracts;
use DB;
use Illuminate\Database\Eloquent\Model;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_Contracts;
use App\Models\TB_PatchContracts\TB_Payments\PacthHP\PacthHP_TRPAYMENT;
use App\Models\TB_PatchContracts\TB_Payments\PatchHP\PatchHP_DUEPAYMENT;
class PatchHP_paydue extends Model
{
    protected $table = 'PatchHP_paydue';
    protected $fillable = ['PatchCon_id',
                            'contno','locat','nopay','ddate','vatrt','damt','damt_v','damt_n',
                            'capital','interest','intrt','capitalbl','daycalint','intamt','delayday'];

    public function PaydueToContract()
    {
        return $this->belongsTo(PatchHP_Contracts::class,'PatchCon_id','id');
    }
    public function PaydueToDuepay()
    {
        return $this->hasOne(PatchHP_DUEPAYMENT::class,'NOPAY','nopay');
    }

    public static function querynopay($PatchCon_id){
        // $query =  DB::select('select a.nopay,a.ddate,a.date1,a.damt,a.capital,a.interest,a.payment,a.intamt,delayday,a.daycalint from PatchHP_paydue a
        // where a.PatchCon_id = '.$PatchCon_id);

        $query = PatchHP_paydue::where('PatchCon_id',$PatchCon_id)->get();
        return $query;
      }
}
