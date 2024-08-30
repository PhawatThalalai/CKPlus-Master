<?php

namespace App\Models\TB_PatchContracts\TB_InsideTrackings;

use App\Models\TB_Constants\TB_Backend\TB_BILLCOLL;
use App\Models\TB_view\View_ConCus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;

use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_Contracts;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchHP\PatchHP_SPASTDUE_DETAIL;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchHP\PatchHP_SPASTDUE_AREA;

use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_Contracts;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchPSL\PatchPSL_SPASTDUE_DETAIL;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchPSL\PatchPSL_SPASTDUE_AREA;

use App\Models\TB_DataCus\Data_Customers;
use App\Models\TB_PactContracts\Pact_Contracts;

class PatchTB_SPASTDUE extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'PatchTB_SPASTDUE';
    protected $primaryKey = 'id';
    protected $fillable = [
        'pactcon_id',
        'PatchCon_id',
        'LOCAT',
        'CONTNO',
        'CODLOAN',
        'TYPECONT',
        'BILLCOLL',
        'FOLCODE',
        'SALECOD',
        'CONTSTAT',
        'FDATE',
        'LDATE',
        'YDATE',
        'LPAYD',
        'LPAYA',
        'DUEDATE',

        'TOTPRC',
        'TOTNOPAY',
        'TOTUPAY',
        'DAMT',
        'KDAMT',
        'KARBAL',
        'PAYBEFOR',
        'PAYDUE',
        'PAYKANG',
        'PARBAL',
        'LOSTDAY',
        'EXPREAL',
        'REXP_PRD',
        'NEXT_DAMT',
        'NEXT_KDAMT',
        'PAST_DAY',
        'NEXT_EXPREAL',
        'KINTAMT',
        'PAYINT',
        'FOLLOWAMT',
        'PAYFOLLOW',
        'KAROTHR',
        'LASTNOPAY',
        'LAST_ASSIGNDT',

        'SUMARYDATE',
        'GRDCOD',
        'EXP_FRM',
        'EXP_TO',
        'DATE_EXC',
        'GNAME',
        'STATUS',
        'ZONE',
        'TRACK_FEE',
        'TRACK_SUM',
        'LOW_FEE',
        'LOW_SUM',
        'MinPay',
        'MustPay',

        'GroupingState',
        'GroupingType',
        'GroupingTemp',
        'APPDATE' // วันนัดชำระ
    ];

    public function ToContract()
    {
        if ($this->CODLOAN == 1) { // เงินกู้
            return $this->belongsTo(PatchPSL_Contracts::class, 'CONTNO', 'CONTNO');
        } elseif ($this->CODLOAN == 2) { // เช่าซื้อ
            return $this->belongsTo(PatchHP_Contracts::class, 'CONTNO', 'CONTNO');
        }
    }

    public function ToSPASTDETAIL()
    {
        if ($this->CODLOAN == 1) { // เงินกู้
            return $this->hasMany(PatchPSL_SPASTDUE_DETAIL::class, 'SPASTDUE_ID', 'id')->orderBy('id', 'DESC');
        } elseif ($this->CODLOAN == 2) { // เช่าซื้อ
            return $this->hasMany(PatchHP_SPASTDUE_DETAIL::class, 'SPASTDUE_ID', 'id')->orderBy('id', 'DESC');

        }
    }

    public function ToSPASTAREA()
    {
        if ($this->CODLOAN == 1) { // เงินกู้
            return $this->hasMany(PatchPSL_SPASTDUE_AREA::class, 'SPASTDUE_ID', 'id')->latest();
        } elseif ($this->CODLOAN == 2) { // เช่าซื้อ
            return $this->hasMany(PatchHP_SPASTDUE_AREA::class, 'SPASTDUE_ID', 'id')->latest();

        }
    }

    public function SPASTDUEToConHP()
    {
        return $this->belongsTo(PatchHP_Contracts::class, 'pactcon_id', 'id');
    }
    public function SPASTDUEToConPSL()
    {
        return $this->belongsTo(PatchPSL_Contracts::class, 'pactcon_id', 'id');
    }


    /*
    public function ToContract()
    {
        return $this->belongsTo(PatchHP_Contracts::class,'CONTNO','CONTNO');
    }

    public function ToSPASTDETAIL()
    {
        return $this->hasMany(PatchHP_SPASTDUE_DETAIL::class,'SPASTDUE_ID','id')->orderBy('id','DESC');
    }

    public function ToContract()
    {
        return $this->belongsTo(PatchPSL_Contracts::class,'CONTNO','CONTNO');
    }

    public function ToSPASTDETAIL()
    {
        return $this->hasMany(PatchPSL_SPASTDUE_DETAIL::class,'SPASTDUE_ID','id')->orderBy('id','DESC');
    }
    */

    public function ToUser()
    {
        return $this->belongsTo(User::class, 'BILLCOLL', 'id');
    }

    public function ToSalecode()
    {
        return $this->belongsTo(User::class, 'SALECOD', 'id');
    }

    public function ToBranch()
    {
        return $this->belongsTo(TB_Branchs::class, 'LOCAT', 'id');
    }

    public function ToBILLCOLL()
    {
        return $this->belongsTo(TB_BILLCOLL::class, 'FOLCODE', 'id');
    }

    /**
     * ค้นหากลุ่มงานโทรตาม zone ที่กำหนด
     *
     * @param string $userZone Zone ของผู้ใช้
     * @return Collection
     */
    public static function getGroupPhone($userZone)
    {
        return self::where('UserZone', $userZone)
                    ->where('GroupingType', 'P')
                    ->orderBy('GroupingTemp')
                    ->orderBy('HLDNO')
                    //->with('ToCustomer')
                    ->get();
    }

    /**
     * คำนวณจำนวนงานโทรไม่ได้กำหนดกลุ่ม
     *
     * @param string $userZone Zone ของผู้ใช้
     * @return int
     */
    public static function countUnassignedPhones($userZone)
    {
        $groupPhone = self::getGroupPhone($userZone);

        $phone_unassigned = 0;
        $phone_unassigned += $groupPhone->where('CODLOAN', '1')->whereNull('FOLCODE')->groupBy('GroupingTemp')->count();
        $phone_unassigned += $groupPhone->where('CODLOAN', '2')->whereNull('FOLCODE')->groupBy('GroupingTemp')->count();

        return $phone_unassigned;
    }


    /**
     * ตรวจสอบว่าทุกงานโทรที่แบ่งกลุ่มแล้ว ได้มอบหมายหมดหรือไม่
     *
     * @param string $userZone Zone ของผู้ใช้
     * @return bool
     */
    public static function checkAllAssignedAnyCodeLoanPhones($userZone)
    {
        $groupPhone = self::getGroupPhone($userZone);

        $loanGroups = [];
        $hirePurchaseGroups = [];

        foreach ($groupPhone as $item) {
            if ($item->CODLOAN == 1) {
                if (!isset($loanGroups[$item->GroupingTemp])) {
                    $loanGroups[$item->GroupingTemp] = true;
                }
                if (is_null($item->FOLCODE)) {
                    $loanGroups[$item->GroupingTemp] = false;
                }
            } elseif ($item->CODLOAN == 2) {
                if (!isset($hirePurchaseGroups[$item->GroupingTemp])) {
                    $hirePurchaseGroups[$item->GroupingTemp] = true;
                }
                if (is_null($item->FOLCODE)) {
                    $hirePurchaseGroups[$item->GroupingTemp] = false;
                }
            }
        }

        $allLoanAssigned = !empty($loanGroups) && !in_array(false, $loanGroups, true);
        $allHirePurchaseAssigned = !empty($hirePurchaseGroups) && !in_array(false, $hirePurchaseGroups, true);

        //dd($loanGroups, $hirePurchaseGroups);

        $result = $allLoanAssigned || $allHirePurchaseAssigned;

        return $result;
    }

    /**
     * เช็คจำนวนงานที่ยังไม่ได้คอนเฟิร์ม
     *
     * @param string $userZone Zone ของผู้ใช้
     * @return int
     */
    public static function countUnconfirmedPhones($userZone)
    {
        $groupPhone = self::getGroupPhone($userZone);
        /*
        $phone_unassigned = 0;
        $phone_unassigned += $groupPhone->where('CODLOAN', '1')->where('GroupingState', '!=', 'Y')->groupBy('GroupingTemp')->count();
        $phone_unassigned += $groupPhone->where('CODLOAN', '2')->where('GroupingState', '!=', 'Y')->groupBy('GroupingTemp')->count();
        */
        $unconfirm = 0;
        if ($groupPhone->where('CODLOAN', '1')->whereNotNull('GroupingTemp')->whereNull('FOLCODE')->count() == 0) {
            $unconfirm += $groupPhone->where('CODLOAN', '1')
                ->whereNotNull('FOLCODE')
                ->where('GroupingState', '!=', 'Y')
                ->groupBy('FOLCODE')
                ->count();
        }
        if ($groupPhone->where('CODLOAN', '2')->whereNotNull('GroupingTemp')->whereNull('FOLCODE')->count() == 0) {
            $unconfirm += $groupPhone->where('CODLOAN', '2')
                ->whereNotNull('FOLCODE')
                ->where('GroupingState', '!=', 'Y')
                ->groupBy('FOLCODE')
                ->count();
        }
        return $unconfirm;
    }

    public function getCusName()
    {
        return $this->ToCustomer ? $this->ToCustomer->Name_Cus : null;
    }


    public function ToCustomer(): HasOneThrough
    {
        return $this->hasOneThrough(
            Data_Customers::class,
            Pact_Contracts::class,
            'id', // Foreign key on the Pact_Con table...
            'id', // Foreign key on the Data_Cus table...
            'pactcon_id', // Local key on the PatchTB_SPASTDUE table...
            'DataCus_id' // Local key on the Pact_Con table...
        );
    }

    /*
    public function ToCustomer()
    {
        return $this->belongsTo(View_ConCus::class, 'CONTNO', 'CONTNO');
    }
    */

}
