<?php

namespace App\Models\TB_PactContracts;

use App\Models\TB_DataCus\Data_Customers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View_ReportPAData extends Model
{
    use HasFactory;

    protected $table = 'View_ReportPAData';
    protected $fillable = [
        "DataCus_id"
        ,"Contract_Con"
        ,"Date_monetary"
        ,"Loan_Name"
        ,"Prefix"
        ,"Name_Cus"
        ,"Firstname_Cus"
        ,"Surname_Cus"
        ,"Name_Career"
        ,"IDCard_cus"
        ,"Birthday_cus"
        ,"Detail_Sex"
        ,"houseNumber_Adds"
        ,"houseGroup_Adds"
        ,"building_Adds"
        ,"village_Adds"
        ,"Floor_Adds"
        ,"alley_Adds"
        ,"road_Adds"
        ,"houseTambon_Adds"
        ,"houseDistrict_Adds"
        ,"houseProvince_Adds"
        ,"Postal_Adds"
        ,"Phone_cus"
        ,"UserInsert"
        ,"BranchSent_Con"
        ,"UserZone"
        ,"Zone_Name"
        ,"Company_Name"
        ,"Name_Branch"
        ,"CodeLoan_Con"
        ,"Buy_PA"
        ,"id"
        ,"Plan_Insur"
        ,"Limit_Insur"
        ,"TimeRack12"
        ,"TimeRack18"
        ,"TimeRack24"
        ,"TimeRack30"
        ,"TimeRack36"
        ,"TimeRack42"
        ,"TimeRack48"
        ,"TimeRack54"
        ,"TimeRack60"
        ,"TimeRack66"
        ,"TimeRack72"
        ,"TimeRack78"
        ,"TimeRack84"
        ,"Timelack_Car"
        ,"Status_Con"
        ,"Approve_monetary"
        ,"Name_Agent"
        ,"Code_Agent"
        ,"Career_Cus"
        ,"DetailCareer_Cus"
        ,"Insurance_PA"
        ,"name"
        ,"Flag_PARespon"
        ,"Date_con"
    ];


    public function ViewtoDataCus()
    {
        return $this->belongsTo(Data_Customers::class,'DataCus_id','id');
    }
}
