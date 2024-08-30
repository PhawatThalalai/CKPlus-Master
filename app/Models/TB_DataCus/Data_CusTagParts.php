<?php

namespace App\Models\TB_DataCus;

use Illuminate\Database\Eloquent\Model;
use App\Models\TB_DataCus\Data_CusTags;

use App\Models\TB_Constants\TB_Frontend\TB_StatusTagParts;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;

use App\Models\User;

class Data_CusTagParts extends Model
{
    protected $table = 'Data_CusTagParts';
    protected $fillable = [
        'DataCus_id',
        'DataTag_id',
        'date_TrackPart',
        'Code_TrackPart',
        'Flag_TrackPart',
        'Ordinal_TrackPart',
        'Status_TrackPart',
        'Duedate_TrackPart',
        'Userfollow_TrackPart',
        'StatusCancel_TrackPart',
        'Detail_TrackPart',
        'UserZone',
        'UserBranch',
        'UserInsert'
    ];

    public function TagPartToTag()
    {
        return $this->belongsTo(Data_CusTags::class, 'DataTag_id', 'id');
    }
    public function TagPartToStateTagParts()
    {
        return $this->belongsTo(TB_StatusTagParts::class, 'Status_TrackPart', 'Code_StatusTag');
    }
    public function TagPartToUserName()
    {
        return $this->belongsTo(User::class, 'UserInsert', 'name')->withTrashed();
    }
    public function TagPartToUserID()
    {
        return $this->belongsTo(User::class, 'UserInsert', 'id')->withTrashed();
    }
    public function DataCusTagPartToUserTracking()
    {
        return $this->belongsTo(User::class, 'Userfollow_TrackPart', 'id');
    }
    public function TagpartToBranch()
    {
        return $this->belongsTo(TB_Branchs::class, 'UserBranch', 'id');
    }

    public function getUserName()
    {
        if (is_numeric($this->UserInsert)) {
            return $this->TagPartToUserID->name;
        } else {
            return $this->UserInsert;
        }
    }
    public function getNameRoles()
    {
        $user = is_numeric($this->UserInsert) ? $this->TagPartToUserID : $this->TagPartToUserName;
        $roles = optional($user)->roles()->get();

        if ($roles) {
            return implode(', ', $roles->pluck('name')->toArray());
        } else {
            return '';
        }
    }

}
