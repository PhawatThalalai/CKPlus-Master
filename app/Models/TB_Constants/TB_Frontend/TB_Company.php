<?php

namespace App\Models\TB_Constants\TB_Frontend;

use Illuminate\Database\Eloquent\Model;
use App\Models\TB_Constants\TB_Frontend\TB_BankAccounts;
use App\Models\TB_Constants\TB_Frontend\TB_TypeLoanCom;
class TB_Company extends Model
{
    protected $table = 'TB_Company';
    protected $fillable = ['Company_Id','Company_Branch' ,'Company_Name' ,'Company_Addr','Company_Addr1'
      ,'Company_HouseNum' ,'Company_Road','Company_Province' ,'Company_District'  ,'Company_Tambon' ,'Company_Zipcode'
      ,'Company_Tel','Company_fax' ,'Company_Zone' ,'RD_Department','Company_Type','Credo_Score','Credo_percen','View_payment'];

    public function CompanyToBankAcc()
    {
        return $this->hasMany(TB_BankAccounts::class,'Com_Id','id');
    }

    public function CompanyToTypeLoanCom()
    {
        return $this->hasMany(TB_TypeLoanCom::class,'Id_Com','id');
    }
    
    /**
     * ดึงข้อมูลบริษัท ตามโซนและประเภท (เงินกู้/เช่าซื้อ)
     *
     * @param string $zone
     * @param string $codeloan
     * 
     * @return Model
     */
    public static function getCompanyByZoneAndCodeLoan($zone, $codeloan)
    {
        // แปลงค่า $zone กับ type จากสตริงเป็นจำนวนเต็ม
        $zoneAsInt = intval($zone);
        $codeloanAsInt = intval($codeloan);
        return self::where('Company_Zone', $zoneAsInt)
                    ->where('Company_Type', $codeloanAsInt)
                    ->first();
    }
    
}
