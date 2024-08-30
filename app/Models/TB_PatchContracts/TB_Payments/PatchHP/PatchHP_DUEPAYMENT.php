<?php

namespace App\Models\TB_PatchContracts\TB_Payments\PatchHP;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_Contracts;
use Illuminate\Database\Eloquent\Model;

class PatchHP_DUEPAYMENT extends Model
{
    protected $table = 'PatchHP_DUEPAYMENT';
    protected $fillable = ['PatchCon_id' ,'TRPID' ,'CONTNO' ,'LOCAT'  ,'TMBILL'  ,'NOPAY'  ,'TONBALANCE'
                    ,'LASTDUEDT' ,'DUEDATE' ,'DUEAMT' ,'DUEINTEFF' ,'DUETONEFF' ,'LASTPAYAMT' ,'LASTPAYDT' ,'PAYDATE'  ,'DELAYDAY'
                    ,'DAYCALINT' ,'INTEFFR' ,'PAYAMT' ,'PAYINTEFF' ,'PAYTON' ,'PAYINTKANG' ,'INTLATEDAY' ,'INTLATERT' ,'INTLATEAMT'
                    ,'NEXTCAPITAL' ,'NEXTINTKANG' ,'SMPAYINTKANG' ,'FLAGAR' ,'USERID' ,'INPUTDATE'
                    ,'UserInsert'  ,'UserBranch' ,'UserZone'];

    public function DUEPAYMENTToContract()
    {
        return $this->belongsTo(PatchHP_Contracts::class,'PatchCon_id','id');
    }
}
