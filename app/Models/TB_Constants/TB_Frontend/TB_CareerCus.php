<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;
use App\Models\TB_DataCus\Data_Customers;

class TB_CareerCus extends Model
{
    protected $table = 'TB_CareerCus';
    protected $fillable = ['Flag_Career','Code_Career','Date_Career','Name_Career','Memo_Career'];

    public function TBCareerCusToDataCus()
    {
        return $this->belongsTo(Data_Customers::class,'Code_Career','Career_cus');
    }

    public static function generateQuery() {
        $resoure = TB_CareerCus::where('Flag_Career','yes')
            ->orderBY('id', 'asc')
            ->get();

        return $resoure;
    }
}
