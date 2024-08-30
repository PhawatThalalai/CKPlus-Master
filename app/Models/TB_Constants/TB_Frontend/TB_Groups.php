<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\TB_Constants\TB_Frontend\TB_GroupLists;
use App\Models\TB_Constants\TB_Frontend\TB_TypeGroups;
use App\Models\User;

class TB_Groups extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'TB_Groups';

    protected $fillable = [
        'groupStatus',
        'groupDate',
        'groupName',
        'groupType',
        'groupHandler',
        'flagSelect',
        'groupZone',
        'groupDesc',
    ];

    protected $dates = [
        'groupDate',
    ];

    public function groupLists()
    {
        return $this->hasMany(TB_GroupLists::class, 'Groups_id');
    }

    public function groupHandlerUser()
    {
        return $this->belongsTo(User::class, 'groupHandler');
    }
}
