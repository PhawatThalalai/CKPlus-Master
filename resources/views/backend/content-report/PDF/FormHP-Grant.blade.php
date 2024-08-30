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
            color:black;
        }
        .hideContent{
            color: white;
        }
        .border-color{
            border-left-color: white;
        }
    </style>
  </head>

  <body>
    <br>
    <table border="0" width="535px">
        <tr>
            <td width="535px" align="center" colspan="3"><h1 style="font-size: 20px;"><u class="hideContent">สัญญาค้ำประกันเช่าซื้อ</u></h1></td>
        </tr>
        <tr>
            <td width="70px" align="left"><p class="hideContent" style="font-size: 16px;"><b>สัญญาเลขที่</b></p></td>
            <td width="130px"><p style="font-size: 16px;"> <span class="fontTemp">{{@$data->CONTNO}}</span></p></td>
            <td width="335px"><p style="font-size: 16px;"></p></td>
        </tr>
        <tr>
            <td width="300px" align="left"><p style="font-size: 16px;"></p></td>
            <td width="235px"><p style="font-size: 16px;"><span class="fontTemp">ทำที่ {{@$dataComp->Company_Name}}</span></p></td>
        </tr>
        <tr>
            <td width="300px" align="left"><p style="font-size: 16px;"></p></td>
            <td width="235px"><p style="font-size: 16px;"><span class="fontTemp">{{@$dataComp->Company_Addr}}</span></p></td>
        </tr>
        <tr>
            <td width="240px" align="right"><p class="hideContent" style="font-size: 16px;">วันที่</p></td>
            <td width="15px" align="right"></td>
            <td width="280px" align="left"><p class="hideContent" style="font-size: 16px;"><span class="fontTemp">{{(@$data->SDATE != NULL)?date('d/m/Y', strtotime($data->SDATE . ' +543 years')):''}}</span></p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="3"><p class="hideContent" style="font-size: 16px;letter-spacing:0.1px;"><span class="hideContent">สัญญาค้ำประกันฉบับนี้ทำขึ้นเพื่อเป็นหลักฐานว่า</span></p></td>
        </tr>
        @php 
            @$Guarantor1 = @$data->PatchToPact->ContractToGuarantor[0]->GuarantorToGuarantorCus;
            @$GuarantorAdds1 = @$Guarantor1->DataCusToDataCusAdds;
            @$Guarantor2 = @$data->PatchToPact->ContractToGuarantor[1]->GuarantorToGuarantorCus;
            @$GuarantorAdds2 = @$Guarantor2->DataCusToDataCusAdds;
            @$Asset = @$data->PactToCus->DataCusToDataAssetOne;
        @endphp
        <tr>
            <td width="15px" align="left"><p class="hideContent" style="font-size: 16px;">(1)</p></td>
            <td width="55px" align="left"></td>
            <td width="300px" align="left"><p style="font-size: 14px;"><span class="fontTemp">{{@$Guarantor1->Name_Cus}}</span></p></td>
            <td width="45px" align="left"><p class="hideContent" style="font-size: 16px;">อายุ</p></td>
            <td width="100px" align="left"><p class="hideContent" style="font-size: 14px;"> <span class="fontTemp">{{calculateAge(@$Guarantor1->Birthday_cus)}}</span></p></td>
            <td width="20px" align="right"><p class="hideContent" style="font-size: 16px;">ปี</p></td>
        </tr>
        <tr>
            <td width="70px" align="left"><p class="hideContent" style="font-size: 16px;">อยู่บ้านเลขที่</p></td>
            <td width="300px" align="left"><p style="font-size: 14px;"><span class="fontTemp">{{@$GuarantorAdds1->houseNumber_Adds}} ม.{{str_replace("ม.","",@$GuarantorAdds1->houseGroup_Adds)}} {{@$GuarantorAdds1->village_Adds}} ต.{{@$GuarantorAdds1->houseTambon_Adds}} อ.{{@$GuarantorAdds1->houseDistrict_Adds}} จ.{{@$GuarantorAdds1->houseProvince_Adds}} {{@$GuarantorAdds1->Postal_Adds}}</span></p></td>
            <td width="165px" align="left"><p class="hideContent" style="font-size: 16px;"></p></td>
        </tr>
        <tr>
            <td width="70px" align="left"><p class="hideContent" style="font-size: 16px;">และ (2)</p></td>
            <td width="300px" align="left"><p style="font-size: 14px;"><span class="fontTemp">{{@$Guarantor2->Name_Cus}}</span></p></td>
            <td width="45px" align="left"><p class="hideContent" style="font-size: 16px;">อายุ</p></td>
            <td width="100px" align="left"><p class="hideContent" style="font-size: 14px;"> <span class="fontTemp">{{calculateAge(@$Guarantor2->Birthday_cus)}}</span></p></td>
            <td width="20px" align="right"><p class="hideContent" style="font-size: 16px;">ปี</p></td>
        </tr>
        <tr>
            <td width="70px" align="left"><p class="hideContent" style="font-size: 16px;">อยู่บ้านเลขที่</p></td>
            <td width="300px" align="left"><p style="font-size: 14px;"><span class="fontTemp">{{@$GuarantorAdds2->houseNumber_Adds}} ม.{{str_replace("ม.","",@$GuarantorAdds2->houseGroup_Adds)}} {{@$GuarantorAdds2->village_Adds}} ต.{{@$GuarantorAdds2->houseTambon_Adds}} อ.{{@$GuarantorAdds2->houseDistrict_Adds}} จ.{{@$GuarantorAdds2->houseProvince_Adds}} {{@$GuarantorAdds2->Postal_Adds}}</span></p></td>
            <td width="165px" align="left"><p class="hideContent" style="font-size: 16px;"></p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="3"><p class="hideContent" style="font-size: 16px;letter-spacing:0.4px;">ซึ่งต่อไปในสัญญานี้จะเรียกว่า <b>"ผู้ค้ำประกัน"</b> ฝ่ายหนึ่ง กับ {{@$dataComp->Company_Name}} ซึ่งต่อไปในสัญญานี้</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="3"><p class="hideContent" style="font-size: 16px;letter-spacing:0.4px;">เรียกว่า <b>"เจ้าของ"</b> ฝ่ายหนึ่ง</p></td>
        </tr>
    </table>
    <table border="0" width="535px">
        <tr>
            <td width="50px" align="left"><p class="hideContent" style="font-size: 16px;letter-spacing:0.4px;"></p></td>
            <td width="275px" align="left"><p class="hideContent" style="font-size: 16px;letter-spacing:0.4px;">ผู้ค้ำประกันยินยอมเข้าค้ำประกันการชำระหนี้ค่าเช่าซื้อของ</p></td>
            <td width="210px"><p style="font-size: 14px;"> <span class="fontTemp">{{@$data->PactToCus->Name_Cus}}</span></p></td>
        </tr>
        <tr>
            <td width="325px" align="left"><p class="hideContent" style="font-size: 16px;letter-spacing:0.4px;">ซึ่งต่อไปในสัญญานี้จะเรียกว่า "ผู้เช่าซื้อ" ตามสัญญาเช่าซื้อ ฉบับเลขที่</p></td>
            <td width="210px"><p style="font-size: 14px;"> <span class="fontTemp">{{@$data->CONTNO}}</span></p></td>
        </tr>
        <tr>
            <td width="50px" align="left"><p class="hideContent" style="font-size: 16px;letter-spacing:0.4px;">ลงวันที่</p></td>
            <td width="135px"><p style="font-size: 14px;"> <span class="fontTemp">{{(@$data->SDATE != NULL)?date('d/m/Y', strtotime($data->SDATE . ' +543 years')):''}}</span></p></td>
            <td width="75px" align="left"><p class="hideContent" style="font-size: 16px;letter-spacing:0.4px;">เป็นรถยนต์ยี่ห้อ</p></td>
            <td width="85px"><p style="font-size: 14px;"> <span class="fontTemp">{{@$Asset->AssetToCarBrand->Brand_car}}</span></p></td>
            <td width="95px" align="left"><p class="hideContent" style="font-size: 16px;letter-spacing:0.4px;">หมายเลขทะเบียน</p></td>
            <td width="95px"><p style="font-size: 14px;"> <span class="fontTemp">{{(@$Asset->Vehicle_NewLicense != NULL)?@$Asset->Vehicle_NewLicense:@$Asset->Vehicle_OldLicense}}</span></p></td>
        </tr>
        <tr>
            <td width="100px" align="left"><p class="hideContent" style="font-size: 16px;letter-spacing:0.4px;">หมายเลขเครื่องยนต์</p></td>
            <td width="110px"><p style="font-size: 14px;"> <span class="fontTemp">{{@$Asset->Vehicle_Engine}}</span></p></td>
            <td width="75px" align="left"><p class="hideContent" style="font-size: 16px;letter-spacing:0.4px;">หมายเลขตัวถัง</p></td>
            <td width="160px"><p style="font-size: 14px;"> <span class="fontTemp">{{(@$Asset->Vehicle_NewChassis != NULL)?@$Asset->Vehicle_NewChassis:@$Asset->Vehicle_Chassis}}</span></p></td>
            <td width="15px" align="left"><p class="hideContent" style="font-size: 16px;letter-spacing:0.4px;">สี</p></td>
            <td width="75px"><p style="font-size: 14px;"> <span class="fontTemp">{{@$Asset->Vehicle_Color}}</span></p></td>
        </tr>
        <tr>
            <td width="200px" align="left"><p class="hideContent" style="font-size: 16px;letter-spacing:0.4px;">โดยมีวงเงินค้ำประกัน เป็นจำนวนเงิน</p></td>
            <td width="80px"><p style="font-size: 14px;"> <span class="fontTemp">{{number_format(@$data->TOTPRC,2)}}</span></p></td>
            <td width="25px" align="left"><p class="hideContent" style="font-size: 16px;letter-spacing:0.4px;">บาท</p></td>
            <td width="5px" align="left"><p class="hideContent" style="font-size: 16px;letter-spacing:0.4px;">(</p></td>
            <td width="220px" align="center"><p style="font-size: 14px;"> <span class="fontTemp">{{IntconvertThai(@$data->TOTPRC)}}</span></p></td>
            <td width="5px" align="right"><p class="hideContent" style="font-size: 16px;letter-spacing:0.4px;">)</p></td>
        </tr>
        <tr>
            <td width="165px" align="left"><p class="hideContent" style="font-size: 16px;letter-spacing:0.4px;">โดยมีระยะเวลาในการค้ำประกัน</p></td>
            <td width="60px"><p style="font-size: 14px;"> <span class="fontTemp">{{number_format(@$data->T_NOPAY,0)}}</span></p></td>
            <td width="310px" align="left"><p class="hideContent" style="font-size: 16px;letter-spacing:0.4px;">งวด</p></td>
        </tr>
    </table>
    <table border="0" width="535px">
        <tr>
            <td width="40px" align="left"><p style="font-size: 16px;"> </p></td>
            <td width="495px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> นอกจากผู้ค้ำประกัน xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> เช่น ค่าภาษีมูลค่าเพิ่ม xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> ทวงถามหรือฟ้องร้อง xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> ดังต่อไปนี้ผู้ค้ำประกันยินยอมผูกผันตนด้วย คือ</p></td>
        </tr>
        <tr>
            <td width="40px" align="left"><p style="font-size: 16px;"> </p></td>
            <td width="495px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> ข้อ 1. xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> xxxxxxxxxxxxxxxxxxxxxxxxx</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"></p></td>
        </tr>
        <tr>
            <td width="40px" align="left"><p style="font-size: 16px;"> </p></td>
            <td width="495px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> ข้อ 2. xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> xxxxxxxxxxxxxxxxxxxxxxx</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"></p></td>
        </tr>
        <tr>
            <td width="40px" align="left"><p style="font-size: 16px;"> </p></td>
            <td width="495px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> ข้อ 3. xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</p></td>
        </tr>
    </table>
  </body>
</html>