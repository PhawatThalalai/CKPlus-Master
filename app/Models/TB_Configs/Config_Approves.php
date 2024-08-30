<?php

namespace App\Models\TB_Configs;

use App\Models\TB_Configs\TB_ConfigApproveLoanDes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TB_Configs\Config_ApprovesDes;

class Config_Approves extends Model
{
    use HasFactory;

    protected $table = 'TB_ConfigApprove';
    protected $fillable = [
        'Code_Cus',
        'Loan_Code',
        'Code_des'
    ];

    public function ConfigApproveToDesApprove()
    {
        return $this->hasOne(Config_ApprovesDes::class,'Code_des','Code_des');
    }

    public function ConfigApproveToDesApproveMany()
    {
        return $this->hasMany(TB_ConfigApproveLoanDes::class,'Code_des','Code_des');
    }
}
