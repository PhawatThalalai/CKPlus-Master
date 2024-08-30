<?php

namespace App\Models\TB_PatchContracts\TB_InsideContracts;

use App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_DUEPAYMENT;

use Illuminate\Database\Eloquent\Model;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_Contracts;
use DB;

class PatchPSL_paydue extends Model
{
    protected $table = 'PatchPSL_paydue';
    protected $fillable = ['PatchCon_id',
                            'contno','locat','nopay','ddate','damt','capital','interest','irr','capitalbl','daycalint'];

    public function PaydueToContract()
    {
        return $this->belongsTo(PatchPSL_Contracts::class,'PatchCon_id','id');
    }

    public function PaydueToDuepay()
    {
        return $this->hasOne(PatchPSL_DUEPAYMENT::class,'NOPAY','nopay');
    }


    public static function querynopay($PatchCon_id){
        // $query =  DB::select('select a.nopay,a.ddate,a.date1,a.damt,a.capital,a.interest,a.payment,a.V_PAYMENT,a.N_PAYMENT,
        // b.INTLATEDAY,b.INTLATEAMT,b.TONBALANCE,a.daycalint from PatchPSL_paydue a
        // left join PatchPSL_DUEPAYMENT b on a.nopay = b.NOPAY and a.PatchCon_id = b.PatchCon_id
        // where a.PatchCon_id = '.$PatchCon_id);

        $query = PatchPSL_paydue::where('PatchCon_id',$PatchCon_id)
            ->with(['PaydueToDuepay' => function ($query) use($PatchCon_id){
                return $query->where('PatchCon_id', $PatchCon_id);
            }])
            ->get();

        return $query;
    }
}
