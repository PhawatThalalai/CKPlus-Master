<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TB_StatusAudits extends Model
{
    use HasFactory;

    protected $table = 'TB_StatusAudits';
    protected $fillable = ['status','code','name_th','name_en'];


    public static function getStatusAudit(){
        $data = TB_StatusAudits::where('status','yes')->orderBy('id','asc')->get();
        return $data ;
     }

}
