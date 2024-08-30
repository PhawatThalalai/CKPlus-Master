<?php
namespace App\Models\TB_PatchContracts\TB_Payments\PatchPSL;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_Contracts;
use App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_CHQMas;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchPSL\PatchPSL_AROTHR;

use App\Models\TB_Constants\TB_Backend\TB_PAYFOR;
use App\Models\TB_Constants\TB_Backend\TB_PAYTYP;

class PatchPSL_CHQTran extends Model
{
    use SoftDeletes;

    protected $table = 'PatchPSL_CHQTran';
    protected $fillable = [
        'PatchCon_id',
        'ChqMas_id',
        'AR_id',
        'TMBILL',
        'TMBILDT',
        'CHQNO',
        'PAYFOR',
        'CONTNO',
        'PAYTYP',
        'PAYAMT',
        'PAYAMT_N',
        'PAYAMT_V',
        'DISCT',
        'PAYINT',
        'DSCINT',
        'NETPAY',
        'PAYDT',
        'NOPAY',
        'F_PAR',
        'F_PAY',
        'L_PAR',
        'L_PAY',
        'TAXNO',
        'TAXFL',
        'FLAG',
        'ASK_FLAG',
        'ASK_DT',
        'ASK_USERID',
        'CANRQ',
        'CANRQDT',
        'CANDT',
        'CAN_USERID',
        'VATRTPAY',
        'VATAMTPAY',
        'DEBT_BALANCE',
        'PAYFL',
        'DSCPAYFL',
        'LOCATPAY',
        'LOCATREC',
        'TON_BALANCE',
        'NEXTCAPITAL',
        'PAYINDUE',
        'UserInsert',
        'UserBranch',
        'UserZone',
        'Memo'
    ];

    public function CHQTranCHQMas()
    {
        return $this->belongsTo(PatchPSL_CHQMas::class, 'ChqMas_id', 'id');
    }
    public function CHQTranContract()
    {
        return $this->belongsTo(PatchPSL_Contracts::class, 'PatchCon_id', 'id');
    }
    public function CHQTranAR()
    {
        return $this->belongsTo(PatchPSL_AROTHR::class, 'AR_id', 'id');
    }

    public function CHQTranToBranch()
    {
        return $this->belongsTo(TB_Branchs::class, 'UserBranch', 'id');
    }
    public function TranToLOCATREC()
    {
        return $this->belongsTo(TB_Branchs::class, 'LOCATREC', 'id');
    }


    public function CAN_USERID()
    {
        return $this->belongsTo(User::class, 'CAN_USERID', 'id');
    }
    public function CHTranASKID()
    {
        return $this->belongsTo(User::class, 'ASK_USERID', 'id');
    }
    public function CHTranCANID()
    {
        return $this->belongsTo(User::class, 'CAN_USERID', 'id');
    }

    public function CHQTrantoUser()
    {
        return $this->belongsTo(User::class, 'UserInsert', 'id');
    }
    public function PAYCODE()
    {
        return $this->belongsTo(TB_PAYFOR::class, 'PAYFOR', 'FORCODE');
    }

    public function PAYTYPCODE()
    {
        return $this->belongsTo(TB_PAYTYP::class, 'PAYTYP', 'PAYCODE');
    }
}
