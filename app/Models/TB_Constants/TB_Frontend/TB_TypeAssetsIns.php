<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

use App\Models\TB_Assets\Data_AssetsDetails;

class TB_TypeAssetsIns extends Model
{
    protected $table = 'TB_TypeAssetsIns';
    protected $fillable = [ 'Flag_TypeIns','Code_TypeIns','Name_TypeIns'];

    public function TypeInsToAssetDetails()
    {
        return $this->belongsTo(Data_AssetsDetails::class,'Code_TypeIns','InsuranceType_Code');
    }

    public static function generateQuery() {
        $resoure = TB_TypeAssetsIns::where('Flag_TypeIns','yes')
            ->get();

        return $resoure;
    }
}
