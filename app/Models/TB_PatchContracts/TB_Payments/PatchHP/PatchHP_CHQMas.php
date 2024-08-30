<?php

namespace App\Models\TB_PatchContracts\TB_Payments\PatchHP;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;
use App\Models\TB_Constants\TB_Frontend\TB_BankAccounts;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_Contracts;
use App\Models\TB_PatchContracts\TB_Payments\PatchHP\PatchHP_CHQTran;

class PatchHP_CHQMas extends Model
{
    use SoftDeletes;

    protected $table = 'PatchHP_CHQMas';
    protected $fillable = [
        'PatchCon_id',
        'Bill_Id',
        'CONTNO',
        'LOCATPAY',
        'LOCATREC'
        ,
        'BILLNO',
        'BILLDT',
        'PAYTYP',
        'PAYFOR'
        ,
        'CHQDT',
        'RECVDT',
        'CHQAMT',
        'CHQDISINT',
        'PAYINACC',
        'PAYDT',
        'CHQTMP',
        'TAXNO',
        'FLAG',
        'ASK_FLAG',
        'ASK_DT',
        'ASK_USERID'
        ,
        'CANDT',
        'CAN_USERID',
        'TAXFL',
        'MEMO'
        ,
        'INPDT',
        'UserInsert',
        'UserBranch',
        'UserZone'
    ];

    public function CHQMasContract()
    {
        return $this->belongsTo(PatchHP_Contracts::class, 'PatchCon_id', 'id');
    }
    public function CHMasToCHTranMn()
    {
        return $this->hasMany(PatchHP_CHQTran::class, 'ChqMas_id', 'id');
    }
    public function CHMasToCHTranOn()
    {
        return $this->hasOne(PatchHP_CHQTran::class, 'ChqMas_id', 'id');
    }
    public function BrLOCATREC()
    {
        return $this->belongsTo(TB_Branchs::class, 'LOCATREC', 'id');
    }

    public function CHQMasToBranch()
    {
        return $this->belongsTo(TB_Branchs::class, 'UserBranch', 'id');
    }
    public function CHQMastoUser()
    {
        return $this->belongsTo(User::class, 'UserInsert', 'id');
    }
    public function CHMasASKID()
    {
        return $this->belongsTo(User::class, 'ASK_USERID', 'id');
    }
    public function CHMasCANID()
    {
        return $this->belongsTo(User::class, 'CAN_USERID', 'id');
    }
    public function CHQMasBackAccount()
    {
        return $this->hasOne(TB_BankAccounts::class, 'id', 'PAYINACC');
    }
}
