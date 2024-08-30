<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;

class TB_ConfigMSTeams extends Model
{
    protected $table = 'TB_ConfigMSTeams';
    protected $fillable = ['ClientSecret_Id' ,'Tenant_Id' ,'Client_Id' ,'Teams_Chanel' 
                            ,'Group_Id','User_Zone' ,'Teams_Active','Type_teams'];
}
