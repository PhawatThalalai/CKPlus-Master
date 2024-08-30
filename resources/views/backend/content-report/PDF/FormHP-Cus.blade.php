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
    <table border="0" width="535px">
        <tr>
            <td width="535px" align="center" colspan="3"><h1 style="font-size: 30px;"><u class="hideContent">สัญญาเช่าซื้อรถยนต์</u></h1></td>
        </tr>
        <tr>
            <td width="330px" align="right" colspan="2"><p class="hideContent" style="font-size: 20px;"><b>สัญญาเลขที่</b></p></td>
            <td width="35px"><p style="font-size: 18px;"></p></td>
            <td width="170px"><p style="font-size: 16px;"> <span class="fontTemp">{{@$data->CONTNO}}</span></p></td>
        </tr>
        <tr>
            <td width="40px" align="right"></td>
            <td width="105px" align="left"><p class="hideContent" style="font-size: 16px;">สัญญาฉบับนี้ทำเมื่อวันที่</p></td>
            <td width="200px" align="left"><p style="font-size: 14px;"> <span class="fontTemp">{{(@$data->SDATE != NULL)?date('d/m/Y', strtotime($data->SDATE . ' +543 years')):''}}</span></p></td>
            <td width="190px" align="right"><p class="hideContent" style="font-size: 16px;letter-spacing:0.1px;"><span class="hideContent">ณ {{@$dataComp->Company_Name}}</span></p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="3"><p class="hideContent" style="font-size: 16px;letter-spacing:0.1px;"><span class="hideContent">สำนักงานเลขที่ {{@$dataComp->Company_Addr}}</span></p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="3"><p class="hideContent" style="font-size: 14px;">ระหว่าง <span class="hideContent">{{@$dataComp->Company_Name}}</span> ซึ่งต่อไปในสัญญานี้จะเรียกว่า <b>"เจ้าของ"</b> ฝ่ายหนึ่ง</p></td>
        </tr>
        @php 
            @$Address = @$data->PactToCus->DataCusToDataCusAdds;
            @$Asset = @$data->PactToCus->DataCusToDataAssetOne;
        @endphp
        <tr>
            <td width="15px" align="left"><p class="hideContent" style="font-size: 16px;">กับ</p></td>
            <td width="185px" align="left"><p style="font-size: 14px;"><span class="fontTemp">{{@$data->PactToCus->Name_Cus}}</span></p></td>
            <td width="60px" align="right"><p class="hideContent" style="font-size: 16px;">อยู่บ้านเลขที่</p></td>
            <td width="275px" align="left"><p style="font-size: 14px;"><span class="fontTemp"> {{@$Address->houseNumber_Adds}} ม.{{str_replace("ม.","",@$Address->houseGroup_Adds)}} ต.{{@$Address->houseTambon_Adds}} อ.{{@$Address->houseDistrict_Adds}} จ.{{@$Address->houseProvince_Adds}} {{@$Address->Postal_Adds}}</span></p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="3"><p class="hideContent" style="font-size: 16px;letter-spacing:0.8px;">ซึ่งต่อไปในสัญญานี้จะเรียกว่า <b>"ผู้เช่าซื้อ"</b> ฝ่ายหนึ่ง  ทั้งสองฝ่ายตกลงทำสัญญากันมีข้อความดังกล่าวต่อไปนี้</p></td>
        </tr>
        <tr>
            <td width="40px" align="left"><p style="font-size: 16px;"> </p></td>
            <td width="495px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> ข้อ 1. เจ้าของตกลงให้เช่าซื้อและผู่เช่าซื้อตกลงเช่าซื้อ ปรากฏรายละเอียดรถยนต์ที่เช่าซื้อและค่าเช่าซื้อดังนี้</p></td>
        </tr>
    </table>
    <table border="0" width="535px">
        <tr>
            <td width="535px" align="center" class="border-color" colspan="3" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid;"><h1 style="font-size: 16px;"><b class="hideContent">รายละเอียดของรถยนต์ และค่าเช่าซื้อ</b></h1></td>
        </tr>
        <tr>
            <td width="535px" align="center" colspan="3" style="border-style: solid; border-left-style: solid; border-right-style: solid;"><h2><u class="hideContent">รายละเอียดของรถยนต์</u></h2></td>
        </tr>
        <tr>
            <td width="70px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 16px;"> ยี่ห้อรถ</p></td>
            <td width="90px" align="left"><p style="font-size: 14px;"> <span class="fontTemp">{{@$Asset->AssetToCarBrand->Brand_car}}</span></p></td>
            <td width="90px" align="left"><p class="hideContent" style="font-size: 16px;">รุ่น/แบบ</p></td>
            <td width="95px" align="left"><p style="font-size: 14px;"> <span class="fontTemp">{{@$Asset->AssetToCarGroup->Group_car}}</span></p></td>
            <td width="70px" align="left"><p class="hideContent" style="font-size: 16px;">ประเภท</p></td>
            <td width="120px" align="left" style="border-right-style: solid;"><p style="font-size: 14px;"> <span class="fontTemp">{{@$Asset->AssetToTypeAsset->Name_TypeAsset}}</span></p></td>
        </tr>
        <tr>
            <td width="70px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 16px;"> เกียร์</p></td>
            <td width="90px" align="left"><p style="font-size: 14px;"> <span class="fontTemp">{{@$Asset->Vehicle_Gear}}</span></p></td>
            <td width="90px" align="left"><p class="hideContent" style="font-size: 16px;">รุ่นปี</p></td>
            <td width="95px" align="left"><p style="font-size: 14px;"> <span class="fontTemp">{{@$Asset->AssetToCarYear->Year_car}}</span></p></td>
            <td width="70px" align="left"><p class="hideContent" style="font-size: 16px;">สี</p></td>
            <td width="120px" align="left" style="border-right-style: solid;"><p style="font-size: 14px;"> <span class="fontTemp">{{@$Asset->Vehicle_Color}}</span></p></td>
        </tr>
        <tr>
            <td width="70px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 16px;"> ตัวถังรถ</p></td>
            <td width="90px" align="left"><p style="font-size: 16px"> <span class="fontTemp"></span></p></td>
            <td width="90px" align="left"><p class="hideContent" style="font-size: 16px;">หมายเลขเครื่องยนต์</p></td>
            <td width="95px" align="left"><p style="font-size: 14px;"> <span class="fontTemp">{{@$Asset->Vehicle_Engine}}</span></p></td>
            <td width="70px" align="left"><p class="hideContent" style="font-size: 16px;">หมายเลขตัวถัง</p></td>
            <td width="120px" align="left" style="border-right-style: solid;"><p style="font-size: 14px;"> <span class="fontTemp">{{(@$Asset->Vehicle_NewChassis != NULL)?@$Asset->Vehicle_NewChassis:@$Asset->Vehicle_Chassis}}</span></p></td>
        </tr>
        <tr>
            <td width="70px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 16px;"> สถาพรถยนต์</p></td>
            <td width="90px" align="left"><p style="font-size: 14px;"> <span class="fontTemp">เก่า</span></p></td>
            <td width="90px" align="left"><p class="hideContent" style="font-size: 16px;">โดยมีระยะทาง</p></td>
            <td width="95px" align="left"><p style="font-size: 14px;"> <span class="fontTemp">{{@$Asset->Vehicle_Miles}}</span></p></td>
            <td width="70px" align="left" ><p class="hideContent" style="font-size: 16px;">กม./ไมล์</p></td>
            <td width="120px" align="left" style="border-right-style: solid;"><p style="font-size: 16px;"></p></td>
        </tr>
        <tr>
            <td width="70px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 16px;"> วันจดทะเบียน</p></td>
            <td width="90px" align="left"><p style="font-size: 16px;"> </p></td>
            <td width="90px" align="left"><p class="hideContent" style="font-size: 16px;">เลขทะเบียน</p></td>
            <td width="95px" align="left"><p style="font-size: 14px;"> <span class="fontTemp">{{(@$Asset->Vehicle_NewLicense != NULL)?@$Asset->Vehicle_NewLicense:@$Asset->Vehicle_OldLicense}}</span></p></td>
            <td width="70px" align="left" ><p class="hideContent" style="font-size: 16px;">จังหวัด</p></td>
            <td width="120px" align="left" style="border-right-style: solid;"><p style="font-size: 14px;"> <span class="fontTemp">{{@$Asset->Vehicle_NewLicense_Province}}</span></p></td>
        </tr>
        <tr>
            <td width="535px" align="center" colspan="3" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid;"><h1  style="font-size: 16px;"><b class="hideContent">วิธีคำนวณผลประโยชน์และค่าเช่าซื้อ</b></h1></td>
        </tr>
        <tr>
            <td width="330px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 16px;"> 1. ราคาเงินสดของรถยนต์</p></td>
            <td width="150px" align="right"><p style="font-size: 14px;"> <span class="fontTemp">{{number_format(@$data->NCSHPRC,2)}}</span></p></td>
            <td width="15px" align="left"><p style="font-size: 16px;"></p></td>
            <td width="40px" align="left" style="border-right-style: solid;"><p class="hideContent" style="font-size: 16px;">บาท</p></td>
        </tr>
        <tr>
            <td width="330px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 16px;"> 2. เงินจอง</p></td>
            <td width="150px" align="right"><p style="font-size: 14px;"> <span class="fontTemp">0.00</span></p></td>
            <td width="15px" align="left"><p style="font-size: 16px;"></p></td>
            <td width="40px" align="left" style="border-right-style: solid;"><p class="hideContent" style="font-size: 16px;">บาท</p></td>
        </tr>
        <tr>
            <td width="330px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 16px;"> 3. เงินลงทุน (ราคาสด + ค่าใช้จ่าย)</p></td>
            <td width="150px" align="right"><p style="font-size: 14px;"> <span class="fontTemp">{{number_format(@$data->NCSHPRC+@$data->NDAWN,2)}}</span></p></td>
            <td width="15px" align="left"><p style="font-size: 16px;"></p></td>
            <td width="40px" align="left" style="border-right-style: solid;"><p class="hideContent" style="font-size: 16px;">บาท</p></td>
        </tr>
        <tr>
            <td width="330px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 16px;"> 4. หัก เงินชำระครั้งแรก (เงินดาวน์)</p></td>
            <td width="150px" align="right"><p style="font-size: 14px;"> <span class="fontTemp">{{number_format(@$data->NDAWN,2)}}</span></p></td>
            <td width="15px" align="left"><p style="font-size: 16px;"></p></td>
            <td width="40px" align="left" style="border-right-style: solid;"><p class="hideContent" style="font-size: 16px;">บาท</p></td>
        </tr>
        <tr>
            <td width="330px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 16px;"> 5. คงเหลือเงินที่ต้องที่ต้องชำระถ้าซื้อเป็นเงินสด</p></td>
            <td width="150px" align="right"><p style="font-size: 14px;"> <span class="fontTemp">{{(@$data->NCSHPRC != NULL)?number_format(@$data->NCSHPRC,2):''}}</span></p></td>
            <td width="15px" align="left"><p style="font-size: 16px;"></p></td>
            <td width="40px" align="left" style="border-right-style: solid;"><p class="hideContent" style="font-size: 16px;">บาท</p></td>
        </tr>
        <tr>
            <td width="330px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 16px;"> 6. บวก อัตราดกอเบี้ยคงที่ต่อปี <b>(Flat Interest Rate)</b>  7.80  % ต่อปี เป็นเวลา</p></td>
            <td width="150px" align="right"><p style="font-size: 14px;"> <span class="fontTemp">{{number_format(@$data->T_NOPAY,0)}}</span></p></td>
            <td width="15px" align="left"><p style="font-size: 16px;"></p></td>
            <td width="40px" align="left" style="border-right-style: solid;"><p class="hideContent" style="font-size: 16px;">บาท</p></td>
        </tr>
        <tr>
            <td width="10px" align="left" style="border-left-style: solid;"></td>
            <td width="320px" align="left" ><p class="hideContent" style="font-size: 16px;"> ข้อ 5 X[ดอกเบี้ยคงที่ X (จำนวนเวลาที่ผ่อนทั้งหมด / 12)]</p></td>
            <td width="150px" align="right"><p style="font-size: 14px;"> <span class="fontTemp">{{number_format(@$data->NETPROFIT,2)}}</span></p></td>
            <td width="15px" align="left"><p style="font-size: 16px;"></p></td>
            <td width="40px" align="left" style="border-right-style: solid;"><p class="hideContent" style="font-size: 16px;">บาท</p></td>
        </tr>
        <tr>
            <td width="330px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 16px;"> 7. ราคาเช่าซื้อทั้งหมด</p></td>
            <td width="150px" align="right"><p style="font-size: 14px;"> <span class="fontTemp">{{number_format(@$data->TOTPRC,2)}}</span></p></td>
            <td width="15px" align="left"><p style="font-size: 16px;"> </p></td>
            <td width="40px" align="left" style="border-right-style: solid;"><p class="hideContent" style="font-size: 16px;">บาท</p></td>
        </tr>
        <tr>
            <td width="330px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 16px;"> 8. ค่าเช่าซื้องวดละ</p></td>
            <td width="150px" align="right"><p style="font-size: 14px;"> <span class="fontTemp">{{number_format( @$data->TOT_UPAY - ( ( @$data->TOT_UPAY * 7 )  / 107 ),2)}}</span></p></td>
            <td width="15px" align="left"><p style="font-size: 16px;"> </p></td>
            <td width="40px" align="left" style="border-right-style: solid;"><p class="hideContent" style="font-size: 16px;">บาท</p></td>
        </tr>
        <tr>
            <td width="80px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 16px;"> ชำระภายในวันที่ </p></td>
            <td width="50px" align="center"><p style="font-size: 14px;"><span class="fontTemp">{{substr(@$data->FDATE,8,2)}}</span></p></td>
            <td width="70px" align="left"><p class="hideContent" style="font-size: 16px;">ของทุกเดือน</p></td>
            <td width="10px" align="left"><p style="font-size: 16px;"></p></td>
            <td width="80px" align="left"><p class="hideContent" style="font-size: 16px;">เริ่มงวดแรกวันที่</p></td>
            <td width="190px" align="right"><p style="font-size: 14px;"><span class="fontTemp">{{date('d/m/Y', strtotime($data->FDATE . ' +543 years'))}}</span></p></td>
            <td width="55px" align="left" style="border-right-style: solid;"><p style="font-size: 16px;"></p></td>
        </tr>
        <tr>
            <td width="125px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 16px;"> ค่าเช่าซื้อรวมภาษีมูลค่าเพิ่ม </p></td>
            <td width="65px" align="left"><p class="hideContent" style="font-size: 14px;"> <span class="fontTemp">{{number_format(@$data->TOT_UPAY,2)}}</span></p></td>
            <td width="190px" align="left"><p class="hideContent" style="font-size: 16px;">ค่าภาษีมูลค่าเพิ่มที่ชำระในแต่ละงวด</p></td>
            <td width="100px" align="right"><p style="font-size: 14px;"><span class="fontTemp">{{number_format(((@$data->TOT_UPAY * 7)  / 107),2)}}</span></p></td>
            <td width="15px" align="left" ><p style="font-size: 16px;"></p></td>
            <td width="40px" align="left" style="border-right-style: solid;"><p class="hideContent" style="font-size: 16px;">บาท</p></td>
        </tr>
        <tr>
            <td width="330px" align="left" style="border-left-style: solid;"><p class="hideContent" style="font-size: 16px;"> ค่าภาษีมูลค่าเพิ่มขณะทำสัญญาเท่ากับอัตราร้อยละ</p></td>
            <td width="150px" align="left"><p style="font-size: 16px;"> <span class="fontTemp">-{{number_format(@$data->VATRT,0)}}-</span></p></td>
            <td width="15px" align="left"><p style="font-size: 16px;"></p></td>
            <td width="40px" align="left" style="border-right-style: solid;"><p style="font-size: 16px;"></p></td>
        </tr>
        <tr>
            <td width="330px" align="left" style="border-left-style: solid;border-bottom-style: solid;"><p class="hideContent" style="font-size: 16px;"> อัตราดอกเบี้ยที่แท้จริง <b>(Effective Interrest Rate)</b> ในอัตราร้อยละ</p></td>
            <!-- <td width="120px" align="left" style="border-bottom-style: solid;"><p style="font-size: 14px;"><span class="fontTemp">{{number_format((@$data->Interest_IRR*12)/100,2)}}</span></p></td> -->
            <td width="120px" align="left" style="border-bottom-style: solid;"><p style="font-size: 14px;"><span class="fontTemp">{{number_format((@$data->Interest_IRR*12),2)}}</span></p></td>
            <td width="40px" align="left" style="border-bottom-style: solid;"><p class="hideContent" style="font-size: 16px;">ต่อปี)</p></td>
            <td width="45px" align="left" style="border-right-style: solid;border-bottom-style: solid;"><p style="font-size: 16px;"></p></td>
        </tr>
    </table>
    <table border="0" width="535px">
        <tr>
            <td width="40px" align="left"><p style="font-size: 16px;"> </p></td>
            <td width="495px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> ข้อ 2. ผู้เช่าซื้อตกลงยินยอมผูกพันตามข้อกำหนดและเงื่อนไขต่างๆตามสัญญาต่อท้ายสัญญาเช่าซื้อฉบับนี้</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="3"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> ทุกประการ และให้ถือว่าสัญญาต่อท้ายสัญญาเช่าซื้อเป็นส่วนหนึ่งของสัญญาเช่าซื้อนี้ด้วย</p></td>
        </tr>
        <tr>
            <td width="40px" align="left"><p style="font-size: 16px;"> </p></td>
            <td width="495px" align="left" colspan="2"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> สัญญาฉบับนี้ทำขึ้นสองฉบับมีข้อความถูกต้องตรงกันมอบไว้ให้คู่สัญญาเก็บไว้ฝ่ายละหนึ่งฉบับ</p></td>
        </tr>
        <tr>
            <td width="535px" align="left" colspan="3"><p class="hideContent" style="font-size: 16px;letter-spacing:0.2px;"> คู่สัญญาได้อ่านและเข้าใจในสัญญาโดยละเอียดตลอดแล้ว จึงลงลายมือชื่อและประทับตรา ไว้เป็นสำคัญต่อพยาน</p></td>
        </tr>
    </table>
    <br>
    <br>
    <table border="0" width="550px" align="center">
        <tr style="font-size: 16px;letter-spacing:0.2px;">
            <td width="160px" align="right"><p class="hideContent"><b>ลงชื่อ</b></p></td>
            <td width="220px"align="center" class="border-color" style="border-bottom-style: dotted;"></td>
            <td width="170px" align="left"><p class="hideContent"><b>ผู้เช่าซื้อ</b></p></td>
        </tr>
        <tr>
            <td width="170px" align="right"><p class="hideContent">(</p></td>
            <td width="200px"align="center"></td>
            <td width="180px" align="left"><p class="hideContent">)</p></td>
        </tr>
        <tr>
            <td colspan="3"></td>
        </tr>
        <tr style="font-size: 16px;letter-spacing:0.2px;">
            <td width="160px" align="right"><p class="hideContent"><b>ลงชื่อ</b></p></td>
            <td width="220px"align="center" class="border-color"  style="border-bottom-style: dotted;"></td>
            <td width="170px" align="left"><p class="hideContent"><b>เจ้าของ</b></p></td>
        </tr>
        <tr>
            <td width="170px" align="right"><b class="hideContent">(</b></td>
            <td width="200px"align="center"><p style="font-size: 16px;letter-spacing:0.2px;"><span class="hideContent"><b>{{@$dataComp->Company_Name}}</b></span></p></td>
            <td width="180px" align="left"><b class="hideContent">)</b></td>
        </tr>
        <tr>
            <td colspan="3"></td>
        </tr>
        <tr style="font-size: 16px;letter-spacing:0.2px;">
            <td width="220px" align="right"><span class="hideContent">ลงชื่อ...........................................พยาน</span></td>
            <td width="100px"align="center"></td>
            <td width="230px" align="left"><span class="hideContent">ลงชื่อ.....................................พยาน</span></td>
        </tr>
        <tr style="font-size: 16px;letter-spacing:0.2px;">
            <td width="75px" align="right"><p class="hideContent">(</p></td>
            <td width="80px" align="right"></td>
            <td width="45px" align="right"><p class="hideContent">)</p></td>
            <td width="140px"align="center"></td>
            <td width="110px" align="left"><p class="hideContent">(</p></td>
            <td width="100px" align="left"><p class="hideContent">)</p></td>
        </tr>
    </table>
  </body>
</html>