<?php

namespace App\Models\TB_PatchContracts\TB_Payments\PatchPSL;
use App\Models\User;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_Contracts;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_paydue;
use Illuminate\Database\Eloquent\Model;

class PatchPSL_DUEPAYMENT extends Model
{
    protected $table = 'PatchPSL_DUEPAYMENT';
    protected $fillable = ['PatchCon_id' ,'TRPID' ,'CONTNO' ,'LOCAT'  ,'TMBILL'  ,'NOPAY'  ,'TONBALANCE'
                    ,'LASTDUEDT' ,'DUEDATE' ,'DUEAMT' ,'DUEINTEFF' ,'DUETONEFF' ,'LASTPAYAMT' ,'LASTPAYDT' ,'PAYDATE'  ,'DELAYDAY'
                    ,'DAYCALINT' ,'INTEFFR' ,'PAYAMT' ,'PAYINTEFF' ,'PAYTON' ,'PAYINTKANG' ,'INTLATEDAY' ,'INTLATERT' ,'INTLATEAMT'
                    ,'NEXTCAPITAL' ,'NEXTINTKANG' ,'SMPAYINTKANG' ,'FLAGAR' ,'USERID' ,'INPUTDATE'
                    ,'UserInsert'  ,'UserBranch' ,'UserZone'];

    public function DUEPAYMENTToContract()
    {
        return $this->belongsTo(PatchPSL_Contracts::class,'PatchCon_id','id');
    }
    public function DUEPAYToTran()
    {
        return $this->belongsTo(PacthPSL_TRPAYMENT::class,'TRPID','id');
    }
    public function DUEPAYToBranch()
    {
        return $this->belongsTo(TB_Branchs::class,'UserBranch','id');
    }
    public function DUEPAYtoUser()
    {
        return $this->belongsTo(User::class,'UserInsert','id');
    }
    public function DUEPAYtoPaydue()
    {
        return $this->hasMany(PatchPSL_paydue::class,'PatchCon_id','id');
    }
 }