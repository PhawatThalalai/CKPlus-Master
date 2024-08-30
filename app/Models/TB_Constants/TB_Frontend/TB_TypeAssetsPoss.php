<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

use App\Models\TB_Assets\Data_AssetsDetails;

class TB_TypeAssetsPoss extends Model
{
    protected $table = 'TB_TypeAssetsPoss';
    protected $fillable = [ 'Flag_TypePoss','Code_TypePoss','Name_TypePoss'];

    public function TypeInsToAssetDetails()
    {
        return $this->belongsTo(Data_AssetsDetails::class,'Code_TypePoss','PossessionState_Code');
    }

    public static function generateQuery() {
        $resoure = TB_TypeAssetsPoss::where('Flag_TypePoss','yes')
            ->get();

        return $resoure;
    }
}
