<?php

namespace App\Models\TB_view;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_Contracts;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchHP\PatchHP_SPASTDUE_DETAIL;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchHP\PatchHP_SPASTDUE_AREA;

use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_Contracts;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchPSL\PatchPSL_SPASTDUE_DETAIL;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchPSL\PatchPSL_SPASTDUE_AREA;

class View_PatchSPASTDUE extends Model
{
    use HasFactory;

    protected $table = 'View_PatchSPASTDUE';
    protected $primaryKey = 'id';
    protected $fillable = [
        'pactcon_id','LOCAT','CONTNO','CODLOAN','UserZone','TYPECONT','BILLCOLL','FOLCODE','SALECOD',
        'CONTSTAT','FDATE','LDATE','YDATE','LPAYD','LPAYA','DUEDATE',
        'TOTPRC','TOTNOPAY','TOTUPAY','DAMT','KDAMT','KARBAL',
        'PAYBEFOR','PAYDUE','PAYKANG','PARBAL','LOSTDAY',
        'EXPREAL','REXP_PRD','NEXT_DAMT','NEXT_KDAMT','PAST_DAY',
        'NEXT_EXPREAL','KINTAMT','PAYINT','FOLLOWAMT','PAYFOLLOW','KAROTHR','LASTNOPAY','LAST_ASSIGNDT',
        'SUMARYDATE','GRDCOD','EXP_FRM','EXP_TO','DATE_EXC','GNAME','STATUS',
        'Name_Cus','Phone_cus','houseDistrict_Adds','houseGroup_Adds','houseTambon_Adds','Expr1','Expr2',
        'houseProvince_Adds','assetid','License','SWEXPPRD','stdept','MinPay',
    ];

    public function ToContract()
    {
        if ($this->CODLOAN == 1) { // เงินกู้
            return $this->belongsTo(PatchPSL_Contracts::class,'CONTNO','CONTNO');
        } elseif ($this->CODLOAN == 2) { // เช่าซื้อ
            return $this->belongsTo(PatchHP_Contracts::class,'CONTNO','CONTNO');
        }
    }

    public function ToSPASTDETAIL()
    {
        if ($this->CODLOAN == 1) { // เงินกู้
            return $this->hasMany(PatchPSL_SPASTDUE_DETAIL::class,'SPASTDUE_ID','spast_id');
        } elseif ($this->CODLOAN == 2) { // เช่าซื้อ
            return $this->hasMany(PatchHP_SPASTDUE_DETAIL::class,'SPASTDUE_ID','spast_id');
            
        }
    }

    public function ToSPASTAREA()
    {
        if ($this->CODLOAN == 1) { // เงินกู้
            return $this->hasMany(PatchPSL_SPASTDUE_AREA::class,'SPASTDUE_ID','spast_id')->latest();
        } elseif ($this->CODLOAN == 2) { // เช่าซื้อ
            return $this->hasMany(PatchHP_SPASTDUE_AREA::class,'SPASTDUE_ID','spast_id')->latest();
        }
    }
}
