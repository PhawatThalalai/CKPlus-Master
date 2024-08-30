<?php

namespace App\Models\TB_PactContracts;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\TB_PactContracts\Pact_AuditTags;
use App\Models\TB_PactContracts\Pact_Contracts;

class Pact_AuditChecklists extends Model
{
    use HasFactory;

    // ระบุว่าไม่มี auto-incrementing primary key
    public $incrementing = false;
    protected $table = 'Pact_AuditChecklists';
    protected $primaryKey = 'audit_id';
    protected $fillable = [
        'PactCon_id',
        'audit_id',
        'auditTagprt_id',
        'check_edit',
        'check_edited',
        'check_complete',
    ];

    public function AuditTag()
    {
        return $this->belongsTo(Pact_AuditTags::class, 'audit_id', 'id');
    }
    public function ChecklistToCont()
    {
        return $this->belongsTo(Pact_Contracts::class, 'PactCon_id', 'id');
    }
}
