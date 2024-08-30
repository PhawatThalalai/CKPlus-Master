<?php

namespace App\Models\TB_Temp\TMP_CONTRACTS;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TMP_CANCONTRACTHP extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'TMP_CANCONTRACTHP';
    protected $fillable = [
                            'PatchCon_id','dataPact_id','CODLOAN','LOCAT','CANNO','CONTNO','SDATE','TOTPRC','SMPAY','TOTBAL',
                            'EXP_AMT','CANDATE','CANSTAT','BILLCOLL','CHECKER','USERCN','CONTSTAT','PAYFOR','PAYAMT','MEMO1',
                            'REXP_PRD','EXP_FRM','EXP_TO','KANGINT','TOTUPAY','PAYDATE','PAYMENT','KEXP_AMT','KEXP_PRD','LASTCANDT'
                        ];
}
