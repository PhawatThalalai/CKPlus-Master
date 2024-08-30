<?php

namespace App\Models\TB_PactContracts;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TB_Constants\TB_Frontend\TB_StatusAudits;
use App\Models\TB_PactContracts\Pact_AuditTagparts;
use App\Models\TB_PactContracts\Pact_AuditChecklists;

class Pact_AuditTags extends Model
{
    use HasFactory;
    protected $table = 'Pact_AuditTags';
    protected $fillable = [
        'PactCon_id',
        'team_id',
        'Flag_Status',
        'team_id',
        'Status_Code',
        'date_send',
        'userInt_send',
        'Send_by',
        'ems_detail',
        'message_send',
        'date_received',
        'userInt_received',
        'date_locker',
        'status_locker',
        'userInt_locker',
        'UserZone',
        'UserBranch',
        'UserInsert'
    ];

    public function auditTagToCont()
    {
        return $this->belongsTo(Pact_Contracts::class, 'PactCon_id', 'id');
    }
    public function auditTagToTagpart()
    {
        return $this->hasMany(Pact_AuditTagparts::class, 'audit_id', 'id');
    }
    public function auditTagToChecklist()
    {
        return $this->hasOne(Pact_AuditChecklists::class, 'audit_id', 'id');
    }

    public function StatusAudit()
    {
        return $this->belongsTo(TB_StatusAudits::class, 'Flag_Status', 'id');
    }

    public function auditTaguserInt()
    {
        return $this->belongsTo(User::class,'userInt_send','id');
    }
}