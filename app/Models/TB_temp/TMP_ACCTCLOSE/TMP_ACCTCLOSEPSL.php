<?php

namespace App\Models\TB_temp\TMP_ACCTCLOSE;
use DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use App\Models\User;
use App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_Contracts;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_Constants\TB_Backend\TB_PAYFOR;
use App\Models\TB_DataCus\Data_CusAddress;
use App\Models\TB_DataCus\Data_Customers;

class TMP_ACCTCLOSEPSL extends Model
{
    use SoftDeletes;

    protected $table = 'TMP_ACCTCLOSEPSL';
    protected $fillable = [ 'PatchCon_id', "dataPact_id",
        'LOCAT', 'CRLOCAT', 'DOCNO', 'CANDATE', 'CONTNO', 'CUSCOD',

        'SNAM', 'NAME1', 'NAME2', 'STRNO', 'REGNO', 'SDATE',
        'TOTPRC', 'SMPAY', 'BILLCOL', 'CHECKER', 'USERRQ', 'HOTBOOK', 'PAYFOR', 'MEMO1',

        'REXP_PRD',  'EXP_FRM', 'EXP_TO', 'EXP_AMT',
        'TOTBAL', 'PROFBAL', 'KANGINT', 'KANGOTH', 'KANGFOLL',
        
        'TOTALKANG', 'DISCT', 'EXPRESSAMT', 'PAYAMT',
        'EXPDATE', 'INPDATE', 'VATBALANCE',

        'T_NOPAY', 'P_NOPAY', 'RQNOPAY',
        
        // เพิ่ม ช่อง
        // ลงชื่อคนอนุมัติ
        // เวลาที่กดอนุมัติ
        // สถานะอนุมัติแล้ว ?
        
        'UserInsert', 'UserBranch', 'UserZone', 'USERID',

        'INTKANGTOTAL', 'DSCPERCEN', 'PAYINTKANG', 'DISCT_EX'
    ]; 

    public function AccCloseToContract()
    {
        return $this->belongsTo(PatchPSL_Contracts::class,'PatchCon_id','id');
    }

    public function AccCloseToBranch()
    {
        return $this->belongsTo(TB_Branchs::class,'LOCAT','id');
    }

    public function AccCloseToUser()
    {
        return $this->belongsTo(User::class,'USERID','id');
    }
    public function AccCloseToPayFor()
    {
        return $this->belongsTo(TB_PAYFOR::class,'PAYFOR','FORCODE');
    }
    public function AccCloseToCustomer()
    {
        return $this->belongsTo(Data_Customers::class, 'CUSCOD', 'id');
    }

    public function AccCloseToCusAddress(): HasOneThrough
    {
        return $this->hasOneThrough(
            Data_CusAddress::class,
            PatchPSL_Contracts::class,
            'id', // Foreign key on the Pact_Con table...
            'id', // Foreign key on the Data_Cus table...
            'PatchCon_id', // Local key on the PatchTB_SPASTDUE table...
            'USEADD' // Local key on the Pact_Con table...
        );
    }

}
