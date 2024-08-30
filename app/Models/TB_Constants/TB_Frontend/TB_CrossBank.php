<?php

namespace App\Models\TB_Constants\TB_Frontend;

use App\Models\TB_Configs\Config_CrossBanks;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TB_Constants\TB_Frontend\TB_Company;

class TB_CrossBank extends Model
{
    use HasFactory;

    protected $table = 'TB_CrossBanks';
    protected $fillable = ['status' ,'actions' ,'code' ,'bank_th' ,'company_th' ,'accountbank' ,'details' ,'company_type' ,'zone', 'zone_th'];

    public function CrossbankConfig()
    {
        return $this->hasOne(Config_CrossBanks::class,'cross_zone','zone');
    }

    public function CrossbankZone()
    {
        return $this->belongsTo(TB_Company::class,'Com_Id','id');
    }
}
