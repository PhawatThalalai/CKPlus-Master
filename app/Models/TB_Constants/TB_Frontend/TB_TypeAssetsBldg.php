<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

use App\Models\TB_Assets\Data_Assets;

class TB_TypeAssetsBldg extends Model
{
    protected $table = 'TB_TypeAssetsBldg';
    protected $fillable = [ 'Flag_TypeBldg','Code_TypeBldg','Name_TypeBldg','No_Building'];

    public function TypeBldgToAsset()
    {
        return $this->belongsTo(Data_Assets::class,'Code_TypeBldg','Land_BuildingType');
    }

    public static function generateQuery() {
        $resoure = TB_TypeAssetsBldg::where('Flag_TypeBldg','yes')
            ->get();

        return $resoure;
    }
}
