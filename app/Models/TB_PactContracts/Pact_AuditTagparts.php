<?php

namespace App\Models\TB_PactContracts;

use App\Models\TB_Logs\Log_AuditChecklists;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User;
use App\Models\TB_PactContracts\Pact_AuditTags;

class Pact_AuditTagparts extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'Pact_AuditTagparts';
    protected $fillable = [
        'PactCon_id',
        'audit_id',
        'date_TrackPart',
        'Status_TrackPart',
        'Detail_TrackPart',
        'UserZone',
        'UserBranch',
        'UserInsert'
    ];

    public function AuditTag()
    {
        return $this->belongsTo(Pact_AuditTags::class, 'audit_id', 'id');
    }

    public function TagpartToLog()
    {
        return $this->HasOne(Log_AuditChecklists::class, 'auditTagprt_id', 'id');
    }
    public function TagpartToUser()
    {
        return $this->HasOne(User::class, 'id', 'UserInsert');
    }
}
