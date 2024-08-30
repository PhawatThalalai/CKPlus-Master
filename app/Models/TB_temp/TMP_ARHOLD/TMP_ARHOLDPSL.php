<?php

namespace App\Models\TB_temp\TMP_ARHOLD;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_Contracts;

class TMP_ARHOLDPSL extends Model
{
    use SoftDeletes;

    protected $table = 'TMP_ARHOLDPSL';
    protected $fillable = [ "id",  "PatchCon_id", "dataPact_id", "LOCAT",  "CONTNO",  "CUSCOD",  "SNAM",  "NAME1",  "NAME2",  "STRNO",  "REGNO",  "SDATE",  "TOTPRC",  "NPRICE",  "VATPRC",  "SMPAY",  "SMCHQ",  "TOTBAL",  "NETBAL",  "VATBAL",  "EXP_AMT",  "BOOKVAL",  "BOOKVAT",  "N_NETCST",  "N_NETVAT",  "N_NETTOT",  "YDATE",  "YLOCAT",  "BILLCOLL",  "CHECKER",  "FLAG", "MEMO1",  "TYPHOLD",  "BALPROF",  "BALVAT",  "NPROFIT",  "GCODE",  "POSTGL",  "REFDOCNO",  "UserInsert",  "UserBranch",  "UserZone"
    ]; 

    public function ARHoldToContract()
    {
        return $this->belongsTo(PatchPSL_Contracts::class,'PatchCon_id','id');
    }

}
