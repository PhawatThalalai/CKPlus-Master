<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <style>
        @page {
            margin: 1;
        }
        @font-face {
            font-family: 'THSarabun';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabun.ttf') }}") format('truetype');
        }
        @font-face {
            font-family: 'THSarabun';
            font-style: normal;
            font-weight: normal;
            src: url("{{ public_path('fonts/THSarabun Bold.ttf') }}") format('truetype');
        }
        body {
            font-family: "THSarabun";
            margin: 1;
        }
        .fontTemp{
            color:red;
        }
        .hideContent{
            color: ;
        }
        .border-color{
            border-left-color: ;
        }
    </style>
  </head>

  <body>
    <table border="0" width="535px">
        <tr>
            <td width="535px" align="center" colspan="3"><h1 style="font-size: 30px;"><u class="hideContent">สัญญากู้ยืมขายฝาก</u></h1></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="3"><h1 class="hideContent" style="font-size: 18px;">{{@$dataComp->Company_Name}}</h1></td>
        </tr>
        <tr>
            <td width="400px" align="left" colspan="2"><p class="hideContent" style="font-size: 14px;">สำนักงานใหญ่ : {{@$dataComp->Company_Addr}}</p></td>
            <td width="135px" align="right"><p class="hideContent" style="font-size: 12px;"><b>คำเสนอขอใช้บริการสินเชื่อกู้ยืมเงิน</b></p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="3"><p class="hideContent" style="font-size: 14px;">สำนักงานใหญ่ : {{@$dataComp->Company_Addr}}</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="3"><p class="hideContent" style="font-size: 14px;"></p></td>
        </tr>
        <tr>
            <td width="200px" align="right"><p class="hideContent" style="font-size: 14px;">สัญญากู้ยืมเงินเลขที่</p></td>
            <td width="100px" align="center"><p style="font-size: 14px;"> <span class="fontTemp"><b>{{@$data->CONTNO}}</b></span></p></td>
            <td width="45px" align="center"><p class="hideContent" style="font-size: 14px;">เลขคุม</p></td>
            <td width="110px" align="center"><p style="font-size: 14px;"> <span class="fontTemp"><b></b></span></p></td>
            <td width="80px" align="center"><p class="hideContent" style="font-size: 14px;"></p></td>
        </tr>
        <tr>
            <td width="190px" align="right"><p class="hideContent" style="font-size: 14px;">สาขา</p></td>
            <td width="50px" align="center"><p style="font-size: 14px;"> <span class="fontTemp"><b></b></span></p></td>
            <td width="45px" align="center"><p class="hideContent" style="font-size: 14px;">รหัสสาขา</p></td>
            <td width="70px" align="center"><p style="font-size: 14px;"> <span class="fontTemp"><b></b></span></p></td>
            <td width="25px" align="center"><p class="hideContent" style="font-size: 14px;">วันที่</p></td>
            <td width="60px" align="center"><p style="font-size: 14px;"> <span class="fontTemp"><b>{{(@$data->SDATE != NULL)?date('d/m/Y', strtotime($data->SDATE . ' +543 years')):''}}</b></span></p></td>
            <td width="25px" align="center"><p class="hideContent" style="font-size: 14px;">เวลา</p></td>
            <td width="70px" align="center"><p style="font-size: 14px;"> <span class="fontTemp"><b></b></span></p></td>
        </tr>
    </table>
    @php 
        @$Address = @$data->PactToCus->DataCusToDataCusAdds;
        @$Asset = @$data->PactToCus->DataCusToDataAssetOne;
        @$Career = @$data->PactToCus->DataCusToDataCusCareer;
    @endphp
    <table border="0" width="535px">
        <tr>
            <td width="535px" align="left" class="border-color" colspan="3" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid;"><h1 style="font-size: 14px;"><b class="hideContent"> สำหรับเจ้าหน้าที่</b></h1></td>
        </tr>
        <tr>
            <td width="120px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 12px;"> รายละเอียดหลักประกัน ยี่ห้อรถ</p></td>
            <td width="65px" align="left"><p style="font-size: 12px;"> <span class="fontTemp">{{@$Asset->AssetToCarBrand->Brand_car}}</span></p></td>
            <td width="15px" align="left"><p class="hideContent" style="font-size: 12px;">รุ่น</p></td>
            <td width="55px" align="left"><p style="font-size: 12px;"> <span class="fontTemp">{{@$Asset->AssetToCarGroup->Group_car}}</span></p></td>
            <td width="70px" align="left"><p class="hideContent" style="font-size: 12px;">เกียร์</p></td>
            <td width="10px" align="left"><p class="hideContent" style="font-size: 12px;">ปี</p></td>
            <td width="35px" align="center"><p style="font-size: 12px;"> <span class="fontTemp">{{@$Asset->AssetToCarYear->Year_car}}</span></p></td>
            <td width="10px" align="left"><p class="hideContent" style="font-size: 12px;">สี</p></td>
            <td width="35px" align="center"><p style="font-size: 12px;"> <span class="fontTemp">{{@$Asset->Vehicle_Color}}</span></p></td>
            <td width="65px" align="left"><p class="hideContent" style="font-size: 12px;">ขนาดเครื่องยนต์</p></td>
            <td width="40px" align="center"><p style="font-size: 12px;"> <span class="fontTemp">{{@$Asset->Vehicle_CC}}</span></p></td>
            <td width="15px" align="right" style="border-right-style: solid;"><p class="hideContent" style="font-size: 12px;">ซีซี</p></td>
        </tr>
        <tr>
            <td width="60px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 12px;"> เลขเครื่องยนต์</p></td>
            <td width="70px" align="left"><p style="font-size: 12px;"> <span class="fontTemp">{{@$Asset->Vehicle_Engine}}</span></p></td>
            <td width="40px" align="left"><p class="hideContent" style="font-size: 12px;">เลขตัวถัง</p></td>
            <td width="100px" align="left"><p style="font-size: 12px;"> <span class="fontTemp">{{(@$Asset->Vehicle_NewChassis != NULL)?@$Asset->Vehicle_NewChassis:@$Asset->Vehicle_Chassis}}</span></p></td>
            <td width="75px" align="left"><p class="hideContent" style="font-size: 12px;">ระยะเวลาครอบครอง</p></td>
            <td width="30px" align="center"><p style="font-size: 12px;"><span class="fontTemp"></span></p></td>
            <td width="10px" align="left"><p class="hideContent"style="font-size: 12px;">ปี</p></td>
            <td width="30px" align="center"><p style="font-size: 12px;"><span class="fontTemp"></span></p></td>
            <td width="60px" align="left"><p class="hideContent" style="font-size: 12px;">เดือนเลขทะเบียน</p></td>
            <td width="60px" align="center" style="border-right-style: solid;"><p style="font-size: 12px;"><span class="fontTemp">{{(@$Asset->Vehicle_NewLicense != NULL)?@$Asset->Vehicle_NewLicense:@$Asset->Vehicle_OldLicense}}</span></p></td>
        </tr>
        <tr>
            <td width="40px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 12px;"> จังหวัด</p></td>
            <td width="70px" align="left"><p style="font-size: 12px;"> <span class="fontTemp"></span></p></td>
            <td width="50px" align="left"><p class="hideContent" style="font-size: 12px;">วันจดทะเบียน</p></td>
            <td width="120px" align="left"><p style="font-size: 12px;"> <span class="fontTemp"></span></p></td>
            <td width="70px" align="left"><p class="hideContent" style="font-size: 12px;">วันครบกำหนดภาษี</p></td>
            <td width="70px" align="center"><p style="font-size: 12px;"><span class="fontTemp"></span></p></td>
            <td width="45px" align="left"><p class="hideContent" style="font-size: 12px;">ระยะทาง</p></td>
            <td width="70px" align="center" style="border-right-style: solid;"><p style="font-size: 12px;"><span class="fontTemp">{{@$Asset->Vehicle_Miles}}</span></p></td>
        </tr>
        <tr>
            <td width="60px" align="left" style="border-left-style: solid;border-top-style: solid;"><p class="hideContent" style="font-size: 12px;"> ราคารถเงินสด</p></td>
            <td width="68px" align="center" style="border-top-style: solid;"><p style="font-size: 12px;"> <span class="fontTemp">{{number_format(@$data->CAPITALBL,2)}}</span></p></td>
            <td width="17px" align="left" style="border-top-style: solid;"><p class="hideContent" style="font-size: 12px;">บาท </p></td>
            <td width="34px" align="left" style="border-top-style: solid;"><p class="hideContent" style="font-size: 12px;">เงินดาวน์</p></td>
            <td width="65px" align="center" style="border-top-style: solid;"><p style="font-size: 12px;"> <span class="fontTemp">{{number_format(@$data->NDAWN,2)}}</span></p></td>
            <td width="17px" align="left" style="border-top-style: solid;"><p class="hideContent" style="font-size: 12px;">บาท </p></td>
            <td width="25px" align="left" style="border-top-style: solid;"><p class="hideContent" style="font-size: 12px;">ยอดจัด</p></td>
            <td width="60px" align="center" style="border-top-style: solid;"><p style="font-size: 12px;"><span class="fontTemp">{{number_format(@$data->TCSHPRC,2)}}</span></p></td>
            <td width="17px" align="left" style="border-top-style: solid;"><p class="hideContent" style="font-size: 12px;">บาท </p></td>
            <td width="50px" align="left" style="border-top-style: solid;"><p class="hideContent" style="font-size: 12px;">ยอดสินเชื่อรวม</p></td>
            <td width="60px" align="center" style="border-top-style: solid;"><p style="font-size: 12px;"><span class="fontTemp">{{number_format(@$data->TOTPRC,2)}}</span></p></td>
            <td width="17px" align="left" style="border-top-style: solid;"><p class="hideContent" style="font-size: 12px;">บาท </p></td>
            <td width="45px" align="left" style="border-top-style: solid;border-right-style: solid;"><p class="hideContent" style="font-size: 12px;">อัตราดอกเบี้ย</p></td>
        </tr>
        <tr>
            <td width="105px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 12px;"> และค่าธรรมเนียมการใช้วงเงิน</p></td>
            <td width="45px" align="left"><p style="font-size: 12px;"> <span class="fontTemp">{{number_format((@$data->Interest_IRR*12),2)}}</span></p></td>
            <td width="25px" align="left"><p class="hideContent" style="font-size: 12px;">%ต่อปี</p></td>
            <td width="50px" align="left"><p class="hideContent" style="font-size: 12px;">แบ่งชำระเป็น</p></td>
            <td width="50px" align="left"><p style="font-size: 12px;"> <span class="fontTemp">{{number_format(@$data->T_NOPAY,0)}}</span></p></td>
            <td width="15px" align="left"><p class="hideContent" style="font-size: 12px;">งวด</p></td>
            <td width="40px" align="left"><p class="hideContent" style="font-size: 12px;">ค่างวด</p></td>
            <td width="60px" align="center"><p style="font-size: 12px;"><span class="fontTemp">{{number_format(@$data->TOT_UPAY,2)}}</span></p></td>
            <td width="17px" align="left"><p class="hideContent" style="font-size: 12px;">บาท </p></td>
            <td width="60px" align="left"><p class="hideContent" style="font-size: 12px;">ชำระงวดแรกวันที่</p></td>
            <td width="68px" align="center" style="border-right-style: solid;"><p style="font-size: 12px;"><span class="fontTemp">{{(@$data->FDATE != NULL)?date('d/m/Y', strtotime(@$data->FDATE . ' +543 years')):''}}</span></p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="3" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid;"><h1  style="font-size: 14px;"><b class="hideContent"> สำหรับลูกค้า</b></h1></td>
        </tr>
        <tr>
            <td width="130px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 12px;"> ชื่อผู้กู้ นาย/นาง/น.ส./นิติบุคคล</p></td>
            <td width="130px" align="left"><p style="font-size: 12px;"> <span class="fontTemp">{{@$data->PactToCus->Prefix}}{{@$data->PactToCus->Name_Cus}}</span></p></td>
            <td width="30px" align="left"><p class="hideContent" style="font-size: 12px;">ชื่อเล่น</p></td>
            <td width="57px" align="left"><p style="font-size: 12px;"> <span class="fontTemp">{{@$data->PactToCus->Nickname_cus}}</span></p></td>
            <td width="38px" align="left"><p class="hideContent" style="font-size: 12px;">ยศ (ถ้ามี)</p></td>
            <td width="60px" align="left"><p style="font-size: 12px;"> <span class="fontTemp"></span></p></td>
            <td width="90px" align="left" style="border-right-style: solid;"><p class="hideContent" style="font-size: 12px;">ผู้ค้ำประกัน</p></td>
        </tr>
        <tr>
            <td width="120px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 12px;"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;บัตรประจำตัวประชาชน</p></td>
            <td width="35px" align="right"><p class="hideContent" style="font-size: 12px;">อื่นๆ</p></td>
            <td width="105px" align="left"><p style="font-size: 12px;"> <span class="fontTemp"></span></p></td>
            <td width="30px" align="left"><p class="hideContent" style="font-size: 12px;">เลขที่</p></td>
            <td width="120px" align="left"><p style="font-size: 12px;"> <span class="fontTemp">{{@$data->PactToCus->IDCard_cus}}</span></p></td>
            <td width="45px" align="left"><p class="hideContent" style="font-size: 12px;">วันออกบัตร</p></td>
            <td width="80px" align="left" style="border-right-style: solid;"><p style="font-size: 12px;"> <span class="fontTemp"></span></p></td>
        </tr>
        <tr>
            <td width="60px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 12px;"> บัตรหมดอายุ</p></td>
            <td width="65px" align="left"><p style="font-size: 12px;"> <span class="fontTemp">{{(@$data->PactToCus->IdcardExpire_cus != NULL)?date('d/m/Y', strtotime(@$data->PactToCus->IdcardExpire_cus . ' +543 years')):''}}</span></p></td>
            <td width="110px" align="right" ><p class="hideContent" style="font-size: 12px;">วันเดือนปีเกิด/วันจดทะเบียน</p></td>
            <td width="80px" align="left"><p style="font-size: 12px;"> <span class="fontTemp">{{(@$data->PactToCus->Birthday_cus != NULL)?date('d/m/Y', strtotime(@$data->PactToCus->Birthday_cus . ' +543 years')):''}}</span></p></td>
            <td width="20px" align="left"><p class="hideContent" style="font-size: 12px;">อายุ</p></td>
            <td width="30px" align="left"><p style="font-size: 12px;"> <span class="fontTemp">{{calculateAge(@$data->PactToCus->Birthday_cus)}}</span></p></td>
            <td width="10px" align="left"><p class="hideContent" style="font-size: 14px;">ปี</p></td>
            <td width="35px" align="left"><p class="hideContent" style="font-size: 14px;">สัญชาติ</p></td>
            <td width="25px" align="left"><p style="font-size: 14px;"><span class="fontTemp">{{@$data->PactToCus->Nationality_cus}}</span></p></td>
            <td width="50px" align="left"><p class="hideContent" style="font-size: 14px;">วุฒิการศึกษา</p></td>
            <td width="50px" align="left" style="border-right-style: solid;"><p style="font-size: 14px;"> <span class="fontTemp"></span></p></td>
        </tr>
        <tr>
            <td width="535px" align="left" style="border-left-style: solid;border-right-style: solid;"><p class="hideContent" style="font-size: 14px;"> E-mail</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" style="border-left-style: solid;border-top-style: solid;"><p class="hideContent" style="font-size: 12px;"> สถานภาพที่อยู่ปัจจุบัน</p></td>
        </tr>
        <tr>
            <td width="60px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 12px;"> ที่อยู่ปัจจุบันเลขที่</p></td>
            <td width="35px" align="left"><p style="font-size: 12px;"> <span class="fontTemp">{{@$Address->houseNumber_Adds}}</span></p></td>
            <td width="18px" align="left" ><p class="hideContent" style="font-size: 12px;">หมู่ที่</p></td>
            <td width="22px" align="left"><p style="font-size: 12px;"> <span class="fontTemp">{{str_replace("ม.","",@$Address->houseGroup_Adds)}}</span></p></td>
            <td width="65px" align="left"><p class="hideContent" style="font-size: 12px;">หมู่บ้าน/ร้าน/บริษัท</p></td>
            <td width="75px" align="left"><p style="font-size: 12px;"> <span class="fontTemp">ม.{{str_replace("ม.","",@$Address->houseGroup_Adds)}} บ้าน{{@$Address->village_Adds}}</span></p></td>
            <td width="45px" align="left"><p class="hideContent" style="font-size: 12px;">ตรอก/ซอย</p></td>
            <td width="40px" align="left"><p style="font-size: 12px;"> <span class="fontTemp"></span></p></td>
            <td width="20px" align="left"><p class="hideContent" style="font-size: 12px;">ถนน</p></td>
            <td width="55px" align="left"><p style="font-size: 12px;"><span class="fontTemp"></span></p></td>
            <td width="50px" align="left"><p class="hideContent" style="font-size: 12px;">แขวง/ตำบล</p></td>
            <td width="50px" align="left" style="border-right-style: solid;"><p style="font-size: 12px;"> <span class="fontTemp">ต.{{@$Address->houseTambon_Adds}}</span></p></td>
        </tr>
        <tr>
            <td width="40px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 12px;"> เขต/อำเภอ</p></td>
            <td width="60px" align="left"><p style="font-size: 12px;"> <span class="fontTemp">อ.{{@$Address->houseDistrict_Adds}}</span></p></td>
            <td width="25px" align="left" ><p class="hideContent" style="font-size: 12px;">จังหวัด</p></td>
            <td width="75px" align="left"><p style="font-size: 12px;"> <span class="fontTemp">จ.{{@$Address->houseProvince_Adds}}</span></p></td>
            <td width="45px" align="left"><p class="hideContent" style="font-size: 12px;">รหัสไปรษณีย์</p></td>
            <td width="45px" align="left"><p style="font-size: 12px;"> <span class="fontTemp">{{@$Address->Postal_Adds}}</span></p></td>
            <td width="55px" align="left"><p class="hideContent" style="font-size: 12px;">โทรศัพท์(บ้าน)</p></td>
            <td width="95px" align="left"><p style="font-size: 12px;"> <span class="fontTemp"></span></p></td>
            <td width="25px" align="left"><p class="hideContent" style="font-size: 12px;">มือถือ</p></td>
            <td width="70px" align="left" style="border-right-style: solid;"><p style="font-size: 12px;"> <span class="fontTemp">{{substr(@$data->PactToCus->Phone_cus,0,10)}}</span></p></td>
        </tr>
        <tr>
            <td width="190px" align="left" style="border-left-style: solid;border-top-style: solid;"><p class="hideContent" style="font-size: 12px;"> สถานภาพ</p></td>
            <td width="85px" align="left" style="border-top-style: solid;"><p class="hideContent" style="font-size: 12px;">ชื่อคู่สมรส นาย/นาง/น.ส.</p></td>
            <td width="155px" align="left" style="border-top-style: solid;"><p style="font-size: 12px;"><span class="fontTemp">{{@$data->PactToCus->Mate_cus}}</span></p></td>
            <td width="25px" align="left" style="border-top-style: solid;"><p class="hideContent" style="font-size: 12px;">อาชีพ</p></td>
            <!-- <td width="80px" align="left" style="border-top-style: solid;border-right-style: solid;"><p style="font-size: 12px;"><span class="fontTemp">{{@$Career->CusCareerToTBCareerCus->Name_Career}}</span></p></td> -->
            <td width="80px" align="left" style="border-top-style: solid;border-right-style: solid;"><p style="font-size: 12px;"><span class="fontTemp"></span></p></td>
        </tr>
        <tr>
            <td width="150px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 12px;"> ที่อยู่</p></td>
            <td width="15px" align="left"><p class="hideContent" style="font-size: 12px;">ระบุ</p></td>
            <td width="115px" align="left"><p style="font-size: 12px;"> <span class="fontTemp"></span></p></td>
            <td width="55px" align="left"><p class="hideContent" style="font-size: 12px;">โทรศัพท์</p></td>
            <td width="95px" align="left"><p style="font-size: 12px;"> <span class="fontTemp"></span></p></td>
            <td width="25px" align="left"><p class="hideContent" style="font-size: 12px;">มือถือ</p></td>
            <td width="80px" align="left" style="border-right-style: solid;"><p style="font-size: 12px;"> <span class="fontTemp">{{substr(@$data->PactToCus->Mate_Phone,0,10)}}</span></p></td>
        </tr>
        <tr>
            <td width="535px" align="left" style="border-left-style: solid;border-right-style: solid;border-top-style: solid;"><p class="hideContent" style="font-size: 12px;"></p></td>
        </tr>
        <tr>
            <td width="535px" align="left" style="border-left-style: solid;border-right-style: solid;"><p class="hideContent" style="font-size: 12px;"></p></td>
        </tr>
        <tr>
            <td width="535px" align="left" style="border-left-style: solid;border-right-style: solid;"><p class="hideContent" style="font-size: 12px;"></p></td>
        </tr>
        <tr>
            <td width="535px" align="left" style="border-left-style: solid;border-right-style: solid;"><p class="hideContent" style="font-size: 12px;"></p></td>
        </tr>
        <tr>
            <td width="535px" align="left" style="border-left-style: solid;border-right-style: solid;"><p class="hideContent" style="font-size: 12px;"></p></td>
        </tr>
        <tr>
            <td width="535px" align="left" style="border-left-style: solid;border-right-style: solid;"><p class="hideContent" style="font-size: 12px;"></p></td>
        </tr>
        <tr>
            <td width="535px" align="left" style="border-left-style: solid;border-right-style: solid;"><p class="hideContent" style="font-size: 12px;"></p></td>
        </tr>
        <tr>
            <td width="535px" align="left" style="border-left-style: solid;border-right-style: solid;"><p class="hideContent" style="font-size: 12px;"></p></td>
        </tr>
        <tr>
            <td width="535px" align="left" style="border-left-style: solid;border-right-style: solid;border-top-style: solid;"><p class="hideContent" style="font-size: 12px;">วัตถุประสงค์การขอกู้ยืมเงิน</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" style="border-left-style: solid;border-right-style: solid;border-top-style: solid;"><p class="hideContent" style="font-size: 12px;">สถานที่จัดส่งเอกสาร</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" style="border-left-style: solid;border-right-style: solid;"><p class="hideContent" style="font-size: 12px;"></p></td>
        </tr>
    </table>
  </body>
</html>