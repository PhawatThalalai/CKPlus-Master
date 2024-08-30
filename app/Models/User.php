<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\TB_Constants\TB_Frontend\TB_Branchs;
use App\Models\TB_Constants\TB_Frontend\TB_ConfigMSTeams;
use App\Models\TB_Constants\TB_Frontend\TB_Company;

use App\Models\TB_DataCus\Data_CusTags;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasProfilePhoto, Notifiable, TwoFactorAuthenticatable, SoftDeletes, HasRoles;


    protected $table = 'users';
    protected $fillable = [
        'status',
        'name',
        'username',
        'email',
        'phone',
        'password',
        'password_token',
        'password_teams',
        'zone',
        'branch',
        'guard_name',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    protected $appends = [
        'profile_photo_url',
    ];
    public function UserToBranch()
    {
        return $this->hasOne(TB_Branchs::class, 'id', 'branch');
    }
    public function UserToMSTeams()
    {
        return $this->hasOne(TB_ConfigMSTeams::class, 'User_Zone', 'zone')->where('Teams_Active', 'yes')->where('Type_teams', 'contracts');
    }

    public function UserToMSTeamsAudit()
    {
        return $this->hasOne(TB_ConfigMSTeams::class, 'User_Zone', 'zone')->where('Teams_Active', 'yes')->where('Type_teams', 'audit');
    }

    public function UserToCom()
    {
        return $this->hasMany(TB_Company::class, 'Company_Zone', 'zone');
    }


    public static function generateQuery()
    {
        $resoure = User::where('zone', auth()->user()->zone)
            ->orderBY('branch', 'asc')
            ->get();

        return $resoure;
    }
}
