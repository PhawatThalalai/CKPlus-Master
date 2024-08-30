<?php

namespace App\Models\TB_PatchContracts\TB_InsideTrackings\PatchPSL;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PatchPSL_SPASTDUE_AREA extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'PatchPSL_SPASTDUE_AREA';
    protected $primaryKey = 'id';
    protected $fillable = [
                            'SPASTDUE_ID',
                            'DETAIL_ID',
                            'DATE_AREA',
                            'PAY_AREA',
                            'STATUS_ASSET',
                            'STATUS_DEBT',
                            'NOTE',
                            'LATLONG',
                            'LINK_IMAGE',
                            'INPUTDT',
                            'INPUT_MONTH',
                            'INPUT_YEAR',
                            'USERID',
                            'FLAG',
                            'PLACE_AREA',
                            'FLAG_ASSET',
                            'FLAG_DEBT',
                            'STATUS_AROUND',
                            'TIME_AREA',
                            'MEMO'
                        ];

    public function ToSPASTDUE()
    {
        return $this->belongsTo(PatchHP_SPASTDUE::class,'SPASTDUE_ID','id');
    }

    public function ToUsername()
    {
        return $this->belongsTo(User::class,'USERID','id');
    }
}
