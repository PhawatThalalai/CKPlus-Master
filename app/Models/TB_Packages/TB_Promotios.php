<?php

namespace App\Models\TB_Packages;

use Illuminate\Database\Eloquent\Model;

class TB_Promotios extends Model
{
    protected $table = 'TB_promotios';
    protected $fillable = ['Zone_pro','Status_pro','Type_pro',
                            'Code_pro','Name_pro','Value_pro','Detail_pro','Start_pro','End_pro'];

    public function PromoToDataCus()
    {
        return $this->hasMany(Data_customer::class,'Code_Pro','Code_pro');
    }

    public static function generateQuery() {
        $resoure = TB_Promotios::where('Status_pro','yes')
            ->where('Zone_pro',auth()->user()->zone)
            ->get();

        return $resoure;
    }
}
