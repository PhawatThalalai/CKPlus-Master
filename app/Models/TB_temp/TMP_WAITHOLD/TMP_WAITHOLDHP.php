<?php

namespace App\Models\TB_temp\TMP_WAITHOLD;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_Contracts;


class TMP_WAITHOLDHP extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $table = 'TMP_WAITHOLDHP';
    protected $fillable = [
        'DataCus_id',
        'PatchCon_id',
        'dataPact_id',
        'CODLOAN',
        'CONTNO',
        'SDATE',
        'LOCAT',
        'Vehicle_Chassis',
        'Vehicle_NewLicense',
        'TOTPRC',
        'SMPAY',
        'BALANCE',
        'DEBTBALANCE',
        'EXP_PRD',
        'EXP_FRM',
        'EXP_TO',
        'CONTSTAT',
        'OLDCODE',
        'OLDNAME',
        'PAYFOR_CODE',
        'PAYFOR_NAME',
        'YDATE',
        'NETYDATE',
        'memo',
        'RBOOKVALUE',
        'RTAX',
        'RINT',
        'TBOOKVALUE',
        'TTAX',
        'TINT',
        'BEFORETAX',
        'TAXVALUE',
        'STSSTOCK',
        'asset_id',
        'AMOUNT',
        'DEBTINT',
        'UserZone',
        'UserBranch',
        'UserInsert'
    ];

    public function PatchContract()
    {
        return $this->belongsTo(PatchHP_Contracts::class, 'PatchCon_id', 'id');
    }
}
