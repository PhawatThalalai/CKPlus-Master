<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TB_ListCheckDocs extends Model
{
    use HasFactory;

    protected $table = 'TB_ListCheckDocs';
    protected $fillable = ['typeLoan','status','code','name_th','name_en'];

    public static function querygeneral(){
        $result = TB_ListCheckDocs::where('status', 'yes')
            ->orderBY('code','asc')
            ->get();
        
        return $result;
    }
}
