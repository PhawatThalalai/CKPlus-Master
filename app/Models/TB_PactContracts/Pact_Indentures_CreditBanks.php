<?php

namespace App\Models\TB_PactContracts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pact_Indentures_CreditBanks extends Model
{
    use HasFactory;

    protected $table = 'Pact_CreditBanks';
    protected $fillable = ['id'];
}
