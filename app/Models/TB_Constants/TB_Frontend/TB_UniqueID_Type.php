<?php
namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

class TB_UniqueID_Type extends Model
{
    protected $table = 'TB_UniqueID_Type';
    protected $fillable = ['id','Status','Code','Value','Detail_Card'];

    public static function GetTypeCard(){
        $resoure = TB_UniqueID_Type::where('Status','active')
            ->orderBY('id', 'asc')
            ->get();

        return $resoure ;
    }
}
