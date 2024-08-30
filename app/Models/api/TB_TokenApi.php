<?php

namespace App\Models\api;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TB_TokenApi extends Model
{
    use HasFactory;

    protected $table = 'TB_TokenApi';
    protected $fillable = ['token_name', 'token_id', 'secret_key', 'type_token', 'token_exp'];
}
