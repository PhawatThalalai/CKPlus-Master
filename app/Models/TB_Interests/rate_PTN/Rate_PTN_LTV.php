<?php

namespace App\Models\TB_Interests\rate_PTN;

use Illuminate\Database\Eloquent\Model;

class Rate_PTN_LTV extends Model
{
    protected $table = 'Rate_PTN_LTV';
    protected $fillable = ['Date_LTV','Status_LTV','value_LTV','Detail_LTV'];

    public static function generateQuery() {
        $resoure = Rate_PTN_LTV::where('Status_LTV','active')->first();

        return $resoure;
    }
}
