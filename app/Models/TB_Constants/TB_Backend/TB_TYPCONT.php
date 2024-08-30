<?php

namespace App\Models\TB_Constants\TB_Backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TB_TYPCONT extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'TB_TYPCONT';
    protected $fillable = ['FLAG' ,'CONTTYP' ,'DATECONT' ,'CONTDESC' ,'EXPFM' ,'EXPTO'];

    public static function generateQuery() {
        $resoure = TB_TYPCONT::where('FLAG','yes')
            ->orderBY('id', 'asc')
            ->get();

        return $resoure;
    }
}
