<?php

namespace App\Models\TB_PatchContracts\TB_InsideTrackings\PatchHP;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchHP\PatchHP_SPASTDUE;
use App\Models\TB_PatchContracts\TB_InsideTrackings\PatchHP\PatchHP_SPASTDUE_AREA;

class PatchHP_SPASTDUE_DETAIL extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'PatchHP_SPASTDUE_DETAIL';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'SPASTDUE_ID',
                            'CONTNO',
                            'STATUS',
                            'DDATE',
                            'RESULT',
                            'SCORE',
                            'NOTE',
                            'INPUTDT',
                            'INPUT_MONTH',
                            'INPUT_YEAR',
                            'USERID',
                            'FLAG',
                            'MinPay',
                            'PAYDUE'
                        ];

    public function ToSPASTDUE()
    {
        return $this->belongsTo(PatchHP_SPASTDUE::class,'SPASTDUE_ID','id');
    }

    public function ToAREA()
    {
        return $this->hasOne(PatchHP_SPASTDUE_AREA::class,'DETAIL_ID','id');
    }

    public function ToUsername()
    {
        return $this->belongsTo(User::class,'USERID','id');
    }

}
