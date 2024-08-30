<?php

namespace App\Models\TB_DOC;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\TB_DOC\TYPE_TAKE_DOC;
// use App

class TAKE_DOC extends Model
{
    use HasFactory;
    protected $table = 'TB_TAKE_DOC';
    protected $fillable = [
        'id', 'CONTNO', 'LOGORID', 'PERSON_TAKE', 'PERSON_GIF', 'PERSON_VERIFY',
        'TAKE_ST', 'TAKEDT', 'RETURN_ST', 'PERSON_RETURN', 'PERKEEP_RETURN', 'RETURNDT',
        'DOC_IMG_LINK', 'NOTE', 'USER_ZONE', 'Brance', 'TYPE_Loans', 'REQTAKE_DT', 'TAKETYPE',
        'PERSON_TAKE',
    ];

    public function ToUser() {
        return $this->belongsTo(USER::class, 'PERSON_TAKE', 'id');
    }

    public function ToTypeTake() {
        return $this->belongsTo(TYPE_TAKE_DOC::class, 'TAKETYPE', 'id');
    }

    // public function ToBrach() {
    //     return $this->belongsTo(TB_Branchs::class, 'Brance', 'id');
    // }
}
