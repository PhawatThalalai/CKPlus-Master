<?php

namespace App\Models\TB_Logs;

use App\Models\TB_PactContracts\Pact_AuditTagparts;
use App\Models\TB_PactContracts\Pact_AuditTags;
use App\Models\TB_PactContracts\Pact_Contracts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log_AuditChecklists extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $table = 'Log_AuditChecklists';
    protected $primaryKey = 'audit_id';
    protected $fillable = [
        'PactCon_id',
        'audit_id',
        'auditTagprt_id',
        'check_edit',
        'check_edited',
        'check_complete',
        'UserZone',
        'UserBranch',
        'UserInsert'
    ];

    public function AuditTagpart()
    {
        return $this->belongsTo(Pact_AuditTagparts::class, 'auditTagprt_id', 'id');
    }
    public function AuditTag()
    {
        return $this->belongsTo(Pact_AuditTags::class, 'audit_id', 'id');
    }
    public function ChecklistToCont()
    {
        return $this->belongsTo(Pact_Contracts::class, 'PactCon_id', 'id');
    }
}
