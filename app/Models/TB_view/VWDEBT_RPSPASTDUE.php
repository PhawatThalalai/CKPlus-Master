<?php

namespace App\Models\TB_view;

use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_Contracts;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchHP\PatchHP_SPASTDUE_DETAIL;

use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_Contracts;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchPSL\PatchPSL_SPASTDUE_DETAIL;

class VWDEBT_RPSPASTDUE extends Model
{
    use HasFactory;

    protected $table = 'VWDEBT_RPSPASTDUE';
    protected $primaryKey = 'id';
    protected $fillable = [
        'PatchCon_id','pactcon_id','LOCAT','CONTNO','CODLOAN','UserZone','TYPECONT','BILLCOLL','FOLCODE','SALECOD',
        'CONTSTAT','FDATE','LDATE','YDATE','LPAYD','LPAYA','DUEDATE',
        'TOTPRC','TOTNOPAY','TOTUPAY','DAMT','KDAMT','KARBAL',
        'PAYBEFOR','PAYDUE','PAYKANG','PARBAL','LOSTDAY',
        'EXPREAL','REXP_PRD','NEXT_DAMT','NEXT_KDAMT','PAST_DAY',
        'NEXT_EXPREAL','KINTAMT','PAYINT','FOLLOWAMT','PAYFOLLOW','KAROTHR','LASTNOPAY','LAST_ASSIGNDT',
        'SUMARYDATE','GRDCOD','EXP_FRM','EXP_TO','DATE_EXC','GNAME','STATUS',
        'Name_Cus','Phone_cus','houseDistrict_Adds','houseGroup_Adds','houseTambon_Adds','Expr1','Expr2',
        'houseProvince_Adds','assetid','License','SWEXPPRD','stdept','MinPay','Name_Branch','APPDATE'
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
            return $this->hasMany(PatchPSL_SPASTDUE_DETAIL::class,'SPASTDUE_ID','id');
        } elseif ($this->CODLOAN == 2) { // เช่าซื้อ
            return $this->hasMany(PatchHP_SPASTDUE_DETAIL::class,'SPASTDUE_ID','id');

        }
    }

    public function ToSPASTDETAILLatest()
    {
        if ($this->CODLOAN == 1) { // เงินกู้
            return $this->hasOne(PatchPSL_SPASTDUE_DETAIL::class,'SPASTDUE_ID','id')->latest();
        } elseif ($this->CODLOAN == 2) { // เช่าซื้อ
            return $this->hasOne(PatchHP_SPASTDUE_DETAIL::class,'SPASTDUE_ID','id')->latest();

        }
    }


    public static function TrackListToday ($GroupType){ // รายการติดตามวันนี้
        $data = VWDEBT_RPSPASTDUE::whereNotNull('FOLCODE')
        ->where('APPDATE',date('Y-m-d'))
        ->whereIn('GroupingType', explode(",",$GroupType))
        ->where('GroupingState','Y')
        ->orderBy('DUEDATE', 'ASC')->where('UserZone',auth()->user()->zone)->get();
        return $data;
    }

     public static function Past12PSL ($GroupType){  // PAST 2 , PAST 3 (PSL)
        $data = VWDEBT_RPSPASTDUE::whereNotNull('FOLCODE')
        ->whereIn('SWEXPPRD',['4.Past 2','5.Past 3'])
        ->whereIn('GroupingType', explode(",",$GroupType))
        ->where('GroupingState','Y')
        ->where('CODLOAN',1)
        ->orderBy('DUEDATE', 'ASC')->where('UserZone',auth()->user()->zone)->get();
        return $data;
    }
    public static function SendManagerPSL ($GroupType){ // ส่งรายงานหัวหน้า ,ส่งรายงาน GM (PLM)
        $data = VWDEBT_RPSPASTDUE::whereNotNull('FOLCODE')
        ->whereIn('STATUS',['ส่งหัวหน้า','ส่ง GM'])
        ->whereIn('GroupingType', explode(",",$GroupType))
        ->where('GroupingState','Y')
        ->where('CODLOAN',1)
        ->orderBy('DUEDATE', 'ASC')->where('UserZone',auth()->user()->zone)->get();
        return $data;
    }
    public static function SendManagerHP ($GroupType){  // ส่งรายงานหัวหน้า ,ส่งรายงาน GM (30-50)
        $data = VWDEBT_RPSPASTDUE::whereNotNull('FOLCODE')
        ->whereIn('STATUS',['ส่งหัวหน้า','ส่ง GM'])
        ->whereIn('GroupingType', explode(",",$GroupType))
        ->where('GroupingState','Y')
        ->where('CODLOAN',2)
        ->orderBy('DUEDATE', 'ASC')->where('UserZone',auth()->user()->zone)->get();
        return $data;
    }
    public static function AppointmentToday ($GroupType){ // นัดชำระวันนี้
        $data = VWDEBT_RPSPASTDUE::whereNotNull('FOLCODE')
        ->whereIn('GroupingType', explode(",",$GroupType))
        ->where('GroupingState','Y')
        ->where('APPDATE',date('Y-m-d'))
        ->orderBy('DUEDATE', 'ASC')->where('UserZone',auth()->user()->zone)->get();
        return $data;
    }
    public static function DueToday ($GroupType){ // ดีลวันนี้
        $data = VWDEBT_RPSPASTDUE::whereNotNull('FOLCODE')
        ->whereIn('GroupingType', explode(",",$GroupType))
        ->where('GroupingState','Y')
        ->where('DUEDATE',date('Y-m-d'))
        ->orderBy('DUEDATE', 'ASC')->where('UserZone',auth()->user()->zone)->get();
        return $data;
    }
    public static function DueYesterday ($GroupType){ // ดีลเมื่อวาน
        $data = VWDEBT_RPSPASTDUE::whereNotNull('FOLCODE')
        ->whereIn('GroupingType', explode(",",$GroupType))
        ->where('GroupingState','Y')
        ->where('DUEDATE',date('Y-m-d',strtotime("-1 days")))
        ->orderBy('DUEDATE', 'ASC')->where('UserZone',auth()->user()->zone)->get();
        return $data;
    }
}
