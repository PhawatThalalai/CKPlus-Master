<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TB_statusAssetOwners extends Model
{
    use HasFactory;

    protected $table = 'TB_StatusAssetOwners';
    protected $fillable = ['status','code','name','name_th'];
}
