<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TB_StatusCon extends Model
{
    protected $table = 'TB_StatusCon';
    protected $fillable = ['Active','order','Name_StatusCon','Memo_StatusCon','Description'];

    public static function getStatusCon(){
       $data = TB_StatusCon::where('Active','yes')->orderBy('order','asc')->get();
       return $data ;
    }
}
