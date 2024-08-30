<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

use App\Models\TB_Assets\Data_Assets;

class TB_TypeAssets extends Model
{
    protected $table = 'TB_TypeAssets';
    protected $fillable = [ 'Flag_TypeAsset',
                            'CodeId_TypeAsset','Code_TypeAsset','Kind_TypeAsset',
                            'Name_TypeAsset'
    ];

    public function TypeAssetToAsset()
    {
        # TypeAsset มีได้หลาย Asset
        return $this->hasMany(Data_Assets::class,'TypeAsset_Code','Code_TypeAsset');
    }
}
