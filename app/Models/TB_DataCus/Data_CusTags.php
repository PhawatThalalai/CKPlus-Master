<?php

namespace App\Models\TB_DataCus;

use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\TB_DataCus\Data_Customers;
use App\Models\TB_DataCus\Data_CusTagCalculate;
use App\Models\TB_DataCus\Data_CusTagParts;

use App\Models\TB_PactContracts\Pact_Contracts;

use App\Models\TB_Constants\TB_Frontend\TB_StatusCustomers;
use App\Models\TB_Constants\TB_Frontend\TB_TypeCusResources;
use App\Models\TB_Constants\TB_Frontend\TB_TypeCredo;
use App\Models\TB_Constants\TB_Frontend\TB_Branchs;

use App\Models\TB_Logs\Data_CredoFragments;
use App\Models\TB_Logs\Data_CredoCodes;
use App\Models\TB_Configs\Config_Credos;

class Data_CusTags extends Model
{
    protected $table = 'Data_CusTags';
    protected $fillable = [
        'DataCus_id',
        'date_Tag',
        'Code_Tag',
        'Status_Tag',
        'Ordinal_Tag',
        'BranchCont',
        'Type_Customer',
        'Resource_Customer',
        'Credo_Code',
        'Credo_Score',
        'Credo_Score2',
        'Credo_Status',
        'Credo_Date',
        'successor',
        'successor_date',
        'successor_status',
        'Note_Tag',
        'flag_reject',
        'MI_label',
        'MI_probability',
        'UserZone',
        'UserBranch',
        'UserInsert'
    ];

    public function TagToDataCus()
    {
        return $this->belongsTo(Data_Customers::class, 'DataCus_id', 'id');
    }

    public function TagToCulculate()
    {
        return $this->hasOne(Data_CusTagCalculate::class, 'DataTag_id', 'id');
    }
    public function TagToTagPart()
    {
        return $this->hasMany(Data_CusTagParts::class, 'DataTag_id', 'id')->orderBy('id', 'desc');
    }
    public function QueryTagPart()
    {
        return $this->hasOne(Data_CusTagParts::class, 'DataTag_id', 'id')->latest();
    }


    public function TagToContracts()
    {
        return $this->hasOne(Pact_Contracts::class, 'DataTag_id', 'id');
    }
    public function TagToStatusCus()
    {
        return $this->hasOne(TB_StatusCustomers::class, 'Code_Cus', 'Type_Customer');
    }
    public function TagToTypeCusRe()
    {
        return $this->hasOne(TB_TypeCusResources::class, 'Code_CusResource', 'Resource_Customer');
    }
    public function TagToCredo()
    {
        return $this->belongsTo(TB_TypeCredo::class, 'Credo_Status', 'Code_Credo');
    }
    public function TagToBranch()
    {
        return $this->belongsTo(TB_Branchs::class, 'UserBranch', 'id');
    }
    public function TagBranchCont()
    {
        return $this->belongsTo(TB_Branchs::class, 'BranchCont', 'id');
    }
    public function TagToFragments()
    {
        return $this->belongsTo(Data_CredoFragments::class, 'Credo_Code', 'referenceNumber');
    }
    public function TagToConfigCredo()
    {
        return $this->hasOne(Config_Credos::class, 'UserZone', 'UserZone');
    }
    public function TagUserID()
    {
        return $this->belongsTo(User::class, 'UserInsert', 'id');
    }
    public function successorID()
    {
        return $this->belongsTo(User::class, 'successor', 'id');
    }

    public function TagToDataCredo()
    {
        return $this->belongsTo(Data_CredoCodes::class, 'Credo_Code', 'credo_code');
    }

    public function getUserInsert()
    {
        if (is_numeric($this->UserInsert)) {
            return $this->TagUserID->name;
        } else {
            return $this->UserInsert;
        }
    }

    public function ViewtoDataCus()
    {
        return $this->belongsTo(Data_Customers::class, 'DataCus_id', 'id');
    }
}
