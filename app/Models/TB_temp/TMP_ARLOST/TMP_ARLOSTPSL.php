<?php

namespace App\Models\TB_temp\TMP_ARLOST;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_Contracts;

class TMP_ARLOSTPSL extends Model
{
    use SoftDeletes;

    protected $table = 'TMP_ARLOSTPSL';
    protected $fillable = [
        'PatchCon_id'
        ,'DataCus_id'
        ,'dataPact_id'
        ,'LOCAT'
        ,'CONTNO'
        ,'Vehicle_License'
        ,'Firstname'
        ,'Lastname'
        ,'PRICE'
        ,'TOTSMACC'
        ,'REMAININT'
        ,'Vehicle_Chassis'
        ,'SMPAY'
        ,'EXP_AMT'
        ,'TYPEBDEBT'
        ,'PRICEASST'
        ,'SDATE'
        ,'DATEBDEBT'
        ,'MEMO'
        ,'UserInsert'
        ,'UserBranch'
        ,'UserZone'
    ];

    public function ARLostToContract()
    {
        return $this->belongsTo(PatchPSL_Contracts::class,'PatchCon_id','id');
    }

}
