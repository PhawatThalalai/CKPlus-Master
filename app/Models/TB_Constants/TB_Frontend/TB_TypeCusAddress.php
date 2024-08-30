<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;
use App\Models\TB_DataCus\Data_CusAddress;

class TB_TypeCusAddress extends Model
{
    protected $table = 'TB_TypeCusAddress';
    protected $fillable = ['Flag_Address','Code_Address','Date_Address','Name_Address','Memo_Address'];

    public function TypeAddsToDataCusAdds()
    {
        return $this->belongsTo(Data_CusAddress::class,'Code_Address','Type_Adds');
    }

    public static function generateQuery() {
        $resoure = TB_TypeCusAddress::where('Flag_Address','yes')
            ->orderBY('id', 'asc')
            ->get();

        return $resoure;
    }
}
