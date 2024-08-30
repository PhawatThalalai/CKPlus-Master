<?php

namespace App\Models\TB_view;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class View_CusConLetter extends Model
{
    use HasFactory;

    protected $table = 'View_CusconLetter';
    protected $fillable =     
    [
       'INPDATE'
      ,'GuardName'
      ,'GuardPhone'
      ,'Guardaddress'
      ,'Name_Cus'
      ,'Phone_cus'
      ,'cusaddress'
      ,'CONTNO'
      ,'typeModel'
      ,'Vehicle_Chassis'
      ,'Vehicle_Engine'
      ,'typeLicense'
      ,'typeProvince'
      ,'NOPAY'
      ,'EXP_FRM'
      ,'EXP_TO'
      ,'EXP_PRD'
      ,'EXP_AMT'
      ,'typeLetter'
      ,'userzone'
      ,'Company_Id'
      ,'Company_Name'
      ,'Company_Addr'
      ,'Company_Tel'
      ,'TYPECON'
    ];
}
