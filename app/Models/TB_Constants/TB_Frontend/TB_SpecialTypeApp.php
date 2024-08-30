<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TB_SpecialTypeApp extends Model
{
    use HasFactory;
    protected $table = 'TB_SpecialTypeApp';
    protected $fillabe = ['Special_Name','FlagApprove'];

    public static function getdata(){
        $SpApp = "";
        $q = TB_SpecialTypeApp::select('id','Special_Name')->get();

        foreach($q as $item){
            $SpApp .= $item->id.':"'.$item->Special_Name.'",';
        }

        return $SpApp;
    }
}
