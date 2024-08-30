<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;
use App\Models\TB_DataCus\Data_CusAssets;

class TB_TypeCusAssets extends Model
{
    protected $table = 'TB_typeCusAssets';
    protected $fillable = ['Flag_Assets','Code_Assets','Date_Assets','Name_Assets','Memo_Assets'];

    public function TypeCusAssetToDataCusAsset()
    {
        return $this->belongsTo(Data_CusAssets::class,'Code_Assets','Type_Asset');
    }

    public static function generateQuery() {
        $resoure = TB_TypeCusAssets::where('Flag_Assets','yes')
            ->orderBY('id', 'asc')
            ->get();

        return $resoure;
    }
}
