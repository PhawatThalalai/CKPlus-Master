<?php

namespace App\Models\TB_Constants\TB_Frontend;

use App\Models\TB_Constants\TB_Backend\TB_BILLCOLL;
use App\Models\TB_view\VWDEBT_RPSPASTDUE;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class TB_Branchs extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'TB_Branchs';
    protected $fillable =   ['id_Contract','id_Contract_1','Name_Branch','NickName_Branch','Zone_Branch',
                            'Branch_Locate','Loan_Active','Traget_Branch','province_Branch', 'branch_name',
                            'address', 'lat', 'lon', 'open_time', 'phoneNo' , 'line_id', 'branch_smart',
                            'Branch_Active',
                            ];

    public function BranchToUser()
    {
        return $this->belongsTo(User::class,'Name_Branch','branch');
    }

    public function BranchToViewSpash()
    {
        return $this->hasMany(VWDEBT_RPSPASTDUE::class,'LOCAT','id');
    }

    public function BranchToBillcoll()
    {
        return $this->hasOne(TB_BILLCOLL::class,'UserBranch','id');
    }


    public static function generateQuery($ignoreActive = false) {
        $resoure = TB_Branchs::where('Zone_Branch', auth()->user()->zone)
            ->when(!$ignoreActive, function ($query) {
                return $query->where('Branch_Active', 'yes');
            })
            ->orderBY('id_Contract', 'asc')
            ->get();

        return $resoure;
    }

}
