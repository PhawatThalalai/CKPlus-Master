<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;
use App\Models\TB_DataCus\Data_CusTracking;

class TB_StatusCustomers extends Model
{
    protected $table = 'TB_StatusCustomers';
    protected $fillable = ['Flag_Cus','Code_Cus','Date_Cus','Name_Cus','Memo_Cus'];

    public function StatusCusToDataTracking()
    {
        return $this->belongsTo(Data_CusTracking::class,'Code_Cus','Type_Customer');
    }

    public static function generateQuery() {
        $zone = auth()->user()->zone;
        $resoure = TB_StatusCustomers::where('Flag_Cus','yes')
            ->when((@$zone == 10), function($q) {
                return $q->where('Flagzone_PTN', 'active');
            })
            ->when((@$zone == 20), function($q) {
                return $q->where('Flagzone_HY', 'active');
            })
            ->when((@$zone == 30), function($q) {
                return $q->where('Flagzone_NK', 'active');
            })
            ->when((@$zone == 40), function($q) {
                return $q->where('Flagzone_KB', 'active');
            })
            ->when((@$zone == 50), function($q) {
                return $q->where('Flagzone_SR', 'active');
            })
            ->orderBY('id', 'asc')
            ->get();

        return $resoure;
    }
}
