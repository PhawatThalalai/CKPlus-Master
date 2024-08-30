<?php

namespace App\Models\TB_PactContracts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TB_PactContracts\Pact_Contracts;

class Pact_Checklists extends Model
{
    use HasFactory;

    protected $table = 'Pact_Checklists';
    protected $fillable = [
        'PactCon_id',
        'TagComm_id',
        'B1_Check_1',
        'B1_Check_2',
        'B1_Check_3',
        'B1_Check_4',
        'B1_Check_5',
        'B1_Check_6',
        'B1_Check_7',
        'B1_Check_8',
        'B1_Check_9',
        'B1_Check_10',
        'B1_Check_11',
        'B1_Check_12',
        'B1_Check_13',
        'B1_Check_14',
        'B1_Check_15',
        'B1_Check_16',
        'B1_Check_17',
        'B1_Check_18',
        'Checker_Location',
        'Memo_Check',
        'UserZone',
        'UserBranch',
        'UserInsert'
    ];

    public function PactChecktoCon()
    {
        return $this->belongsTo(Pact_Contracts::class, 'PactCon_id', 'id');
    }

}
