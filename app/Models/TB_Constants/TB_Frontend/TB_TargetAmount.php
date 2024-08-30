<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\User;

class TB_TargetAmount extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'TB_TargetAmount';
    protected $fillable = ['TypeTarget_id','Target_Branch','Target_User','Target_Month','Target_Year','Target_Typcus','Target_Amount','Target_Zone','created_month'];

    public function ToBranch()
    {
        return $this->belongsTo(TB_Branchs::class,'Target_Branch','id');
    }

    public function ToUser()
    {
        return $this->belongsTo(User::class,'Target_User','id');
    }

}
