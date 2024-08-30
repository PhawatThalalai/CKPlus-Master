<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TB_StatusApprove extends Model
{
    use HasFactory;
    protected $table = 'TB_StatusApprove';
    protected $fillable = ['Status_Approve','flag'];
}
