<?php

namespace App\Models\TB_temp\TMP_ARLOST;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_Contracts;

class TMP_ARLOSTHP extends Model
{
    use SoftDeletes;

    protected $table = 'TMP_ARLOSTHP';
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
        return $this->belongsTo(PatchHP_Contracts::class,'PatchCon_id','id');
    }

}
