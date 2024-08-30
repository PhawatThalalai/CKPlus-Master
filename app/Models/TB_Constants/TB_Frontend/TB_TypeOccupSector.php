<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

class TB_TypeOccupSector extends Model
{
    protected $table = 'TB_TypeOccupSectors';
    protected $fillable = ['Flag_Sector','Code_PLT','Code_Sector','Date_Sector','Name_Sector','Memo_Sector'];

    public static function generateQuery() {
        $resoure = TB_TypeOccupSector::where('Flag_Sector','yes')
            ->orderBY('id', 'asc')
            ->get();

        return $resoure;
    }
}
