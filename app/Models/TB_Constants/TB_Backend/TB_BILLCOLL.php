<?php

namespace App\Models\TB_Constants\TB_Backend;

use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_view\VWDEBT_RPSPASTDUE;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

// ! เหลือ Migrations ยังไม่เสร็จ

class TB_BILLCOLL extends Model
{
    use SoftDeletes;

    protected $table = 'TB_Billcolls';
    protected $fillable = ['code_billcoll', 'name_billcoll', 'UserZone', 'status', 'type_billcoll', 'note_billcoll', 'UserBranch', 'show_phone', 'show_tidtam'];

    public static function generateQuery() {
        $resoure = TB_BILLCOLL::where('UserZone', auth()->user()->zone)
            ->where('status', 'Y')
            ->addSelect('id', DB::raw("CONCAT(code_billcoll, ' : ', name_billcoll) AS DISPLAY_BILLCOLL"))
            ->orderBy('DISPLAY_BILLCOLL');
        return $resoure;
    }

    public function BillCollToViewSpash()
    {
        return $this->hasMany(VWDEBT_RPSPASTDUE::class,'FOLCODE','id');
    }

    public function BillCollToBranch()
    {
        return $this->hasMany(TB_Branchs::class, 'id', 'UserBranch');
    }

}
