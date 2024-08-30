<?php

namespace App\Models\TB_temp\TMP_STOPVAT;

use App\Models\User;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_DataCus\Data_Customers;

class TMP_STOPVATPSL extends Model
{
    use SoftDeletes;

    protected $table = 'TMP_STOPVATPSL';
    protected $fillable = [
        "PatchCon_id",
        "dataPact_id",
        "LOCAT",
        "CONTNO",
        "CUSCOD",
        "SDATE",
        "STOPVDT",
        "STOPVFL",
        "TOTPRC",
        "EXP_PRD",
        "EXP_FRM",
        "EXP_TO",
        "EXP_AMT",
        "USERSTOPV",
        "INPDATE",
        "GRDCOD",
        "UserInsert",
        "UserBranch",
        "UserZone"
    ];

    public function StopVATLocat()
    {
        return $this->belongsTo(TB_Branchs::class, 'LOCAT', 'id');
    }

    public function UserStopVat()
    {
        return $this->belongsTo(Data_Customers::class, 'CUSCOD', 'id');
    }

    public function STOPVToUser()
    {
        return $this->belongsTo(User::class, 'UserInsert', 'id');

    }
}
