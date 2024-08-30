<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>หนังสือทวงถาม</title>
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
    @foreach($data as $key => $row)
        @php 
            if($row->ToPact->CodeLoan_Con == '01'){
                $contract = $row->ToPact->ContractToConHP;
            }
            elseif($row->ToPact->CodeLoan_Con == '02'){
                $contract = $row->ToPact->ContractToConPSL;
            }
            @$Guarantor1 = @$row->ToPact->ContractToGuarantor[0]->GuarantorToGuarantorCus;
            @$GuarantorAdds1 = @$Guarantor1->DataCusToDataCusAdds;
            @$Guarantor2 = @$row->ToPact->ContractToGuarantor[1]->GuarantorToGuarantorCus;
            @$GuarantorAdds2 = @$Guarantor2->DataCusToDataCusAdds;
            @$Asset = @$row->ToPact->DataCusToDataAssetOne;
        @endphp
        @if($row->ToPact->CodeLoan_Con == '02')
            @if(@$Guarantor1 != NULL)
                <table border="0" width="100%">
                    <tr style="line-height: 90%">
                        <td width="540px"><h1>{{@$row->View_GuardConLetter->Company_Name}}</h1></td>
                    </tr>
                    <tr style="line-height: 100%">
                        <td width="540px" style="letter-spacing: 0.5px;font-size:18px;">{{@$row->View_GuardConLetter->Company_Addr}} โทรศัพท์ {{@$row->View_GuardConLetter->Company_Tel}}</td>
                    </tr>
                    <tr style="line-height: 100%">
                        <td width="540px"></td>
                    </tr>
                </table>
                <hr style="height:1px;width:540px;">
                <table border="0" width="100%">
                    <tr>
                        <td width="540px" height="35px;"></td>
                    </tr>
                    <tr>
                        <td width="150px"></td>
                        <td width="50px"><b>กรุณาส่ง</b></td>
                        <td width="320px">{{@$Guarantor1->Name_Cus}} (ผู้ค้ำประกัน 1)</td>
                    </tr>
                    <tr>
                        <td width="200px"></td>
                        <td width="340px">เลขที่ {{@$GuarantorAdds1->houseNumber_Adds}} ม.{{str_replace("ม.","",@$GuarantorAdds1->houseGroup_Adds)}} {{@$GuarantorAdds1->village_Adds}}</td>
                    </tr>
                    <tr>
                        <td width="200px"></td>
                        <td width="340px">ต.{{@$GuarantorAdds1->houseTambon_Adds}} อ.{{@$GuarantorAdds1->houseDistrict_Adds}} จ.{{@$GuarantorAdds1->houseProvince_Adds}}</td>
                    </tr>
                    <tr>
                        <td width="200px"></td>
                        <td width="340px"><b>{{@$GuarantorAdds1->Postal_Adds}}</b></td>
                    </tr>
                    <tr>
                        <td width="540px"></td>
                    </tr>
                </table>
                <table border="0" width="100%">
                    <tr>
                        <td width="50px"></td>
                        <td width="340px"></td>
                        <td width="150px" style="letter-spacing: 0.5px;">วันที่ <b>{{formatDateThaiLongPS(@$row->View_GuardConLetter->PRINTDT)}}</b></td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px"></td>
                    </tr>
                    <tr style="line-height: 120%">
                        <td width="50px"><b>เรื่อง</b></td>
                        <td width="410px">แจ้งให้มาชำระหนี้ สัญญากู้ยืม,ค้ำประกันเลขที่ ({{$row->CONTNO}})</td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 120%">
                        <td width="50px"><b>เรียน</b></td>
                        <td width="410px" style="letter-spacing: 0.5px;">{{@$Guarantor1->Name_Cus}} (ผู้ค้ำประกัน 1)</td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 200%">
                        <td width="50px"></td>
                        <td width="410px"></td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="50px"></td>
                        <td width="490px" style="text-align: justify;letter-spacing: 0.5px;">ตามที่ <b>ท่าน</b> ได้ตกลงทำสัญญาค้ำประกันการกู้ยืม ตามสัญญาค้ำประกันเลขที่ ({{$row->CONTNO}})</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="30px" align="left">ไปจาก</td>
                        <td width="220px" align="center"><b>{{@$row->View_GuardConLetter->Company_Name}}</b></td>
                        <td width="180px" align="left">ตามสัญญากู้ยืม / ค้ำประกัน ลงวันที่</td>
                        <td width="110px" align="left"><b>{{formatDateThaiLongPS(@$contract->SDATE)}}</b></td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px" style="text-align: justify;letter-spacing: 0.5px;">รายละเอียดท่านทั้งสองแจ้งชัดดีอยู่แล้วนั้น บัดนี้ท่านได้ค้างชำระเงินกู้ยืมจำนวน <b>{{@$row->View_GuardConLetter->EXP_PRD}}</b> งวด ติดต่อกันเป็นจำนวนเงิน</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="280px" style="letter-spacing: 0.2px;word-break: break-all; white-space: normal;"><b>{{number_format(@$row->View_GuardConLetter->EXP_AMT,2)}}</b> บาท <b>{{IntconvertThai(@$row->View_GuardConLetter->EXP_AMT)}}</b></td>
                        <td width="260px" style="letter-spacing: 0.4px;">และค่าใช้จ่ายเป็นเบี้ยปรับ ดอกเบี้ยผิดนัดตามกฏหมาย</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px" style="letter-spacing: 0.7px;">พร้อมค่าใช้จ่ายในการติดตามและอื่นๆ</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="50px"></td>
                        <td width="490px" style="letter-spacing: 0.65px;">ฉะนั้น ขอให้ดำเนินการตรวจสอบ และหากมีเหตุขัดข้องประการใด ขอให้ท่านไปพบ ณ ที่ทำการบริษัทฯ</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px" style="letter-spacing: 0.75px;">หรือหากท่านชำระเงินตามรายการข้างต้นเป็นที่เรียบร้อยแล้วหรือมีผิดพลาดประการใด ทางบริษัทฯ ขอท่าน</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px" style="letter-spacing: 0.75px;">โปรดแจ้งบริษัทฯ ทราบโดยด่วน โดยทางบริษัทฯมีความจำเป็นต้องขอเรียนเตือนท่านมาชำระส่วนที่ค้างทั้งหมด</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px" style="letter-spacing: 0.75px;">ให้แล้วเสร็จภายใน <b>7</b> วัน นับตั้งแต่วันที่ท่านได้รับหนังสือฉบับนี้ มิฉะนั้นบริษัทฯ มีความจำเป็นต้องดำเนิน</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px" style="letter-spacing: 0.75px;">ตามเงื่อนไขสัญญาต่อไป</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="50px"></td>
                        <td width="490px" style="text-align: justify;letter-spacing: 0.5px;">จึงเรียนมาเพื่อโปรดดำเนินการด่วน</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="350px"></td>
                        <td width="190px" style="letter-spacing: 0.3px;"><b>ขอแสดงความนับถือ</b></td>
                    </tr>
                    <tr style="line-height: 350%">
                        <td width="540px"></td>
                    </tr>
                    @php 
                        if(auth()->user()->zone == 10){ //PN
                            $authorize = 'นางประไพทิพย์ สุวรรณพงค์';
                        }
                        elseif(auth()->user()->zone == 20){ //HY
                            $authorize = 'นายธวัชชัย โรจน์วัชราภิบาล';
                        }
                        elseif(auth()->user()->zone == 30){ //NK
                            $authorize = '';
                        }
                        elseif(auth()->user()->zone == 40){ //KB
                            $authorize = '';
                        }
                        elseif(auth()->user()->zone == 50){ //SR
                            $authorize = '';
                        }
                    @endphp
                    <tr style="line-height: 150%">
                        <td width="330px"></td>
                        <td width="210px" style="letter-spacing: 0.3px;">(นางประไพทิพย์ สุวรรณพงค์)</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="355px"></td>
                        <td width="185px" style="letter-spacing: 0.3px;"><b>ผู้รับมอบอำนาจ</b></td>
                    </tr>
                    <tr style="line-height: 400%">
                        <td width="540px"></td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px" style="letter-spacing: 0.3px;">หากท่านได้นำเงินดังกล่าวไปชำระก่อนได้รับจดหมายฉบับนี้ ทางบริษัทต้องขออภัยมา ณ ที่นี้ด้วย</td>
                    </tr>
                </table>
                <p></p>
            @endif
        @elseif($row->ToPact->CodeLoan_Con == '01')
            @if(@$Guarantor1 != NULL)
                <table border="0" width="100%">
                    <tr style="line-height: 90%">
                        <td width="540px"><h1>{{@$row->View_GuardConLetter->Company_Name}}</h1></td>
                    </tr>
                    <tr style="line-height: 100%">
                        <td width="540px" style="letter-spacing: 0.5px;font-size:18px;">{{@$row->View_GuardConLetter->Company_Addr}}</td>
                    </tr>
                    <tr style="line-height: 100%">
                        <td width="540px" style="letter-spacing: 0.5px;font-size:18px;">โทรศัพท์ {{@$row->View_GuardConLetter->Company_Tel}} แฟกซ์ {{(@$row->View_GuardConLetter->Company_fax?@$row->View_GuardConLetter->Company_fax:'-')}}</td>
                    </tr>
                    <tr style="line-height: 100%">
                        <td width="540px"></td>
                    </tr>
                </table>
                <hr style="height:1px;width:540px;">
                <table border="0" width="100%">
                    <tr>
                        <td width="540px" height="25px;"></td>
                    </tr>
                    <tr>
                        <td width="150px"></td>
                        <td width="50px"><b>กรุณาส่ง</b></td>
                        <td width="320px"></td>
                    </tr>
                    <tr>
                        <td width="150px"></td>
                        <td width="50px"></td>
                        <td width="320px">{{@$Guarantor1->Name_Cus}} (ผู้ค้ำประกัน)</td>
                    </tr>
                    <tr>
                        <td width="200px"></td>
                        <td width="340px">เลขที่ {{@$GuarantorAdds1->houseNumber_Adds}} ม.{{str_replace("ม.","",@$GuarantorAdds1->houseGroup_Adds)}} {{@$GuarantorAdds1->village_Adds}}</td>
                    </tr>
                    <tr>
                        <td width="200px"></td>
                        <td width="340px">ต.{{@$GuarantorAdds1->houseTambon_Adds}} อ.{{@$GuarantorAdds1->houseDistrict_Adds}} จ.{{@$GuarantorAdds1->houseProvince_Adds}}</td>
                    </tr>
                    <tr>
                        <td width="200px"></td>
                        <td width="340px"><b>{{@$GuarantorAdds1->Postal_Adds}}</b></td>
                    </tr>
                    <tr>
                        <td width="540px"></td>
                    </tr>
                </table>
                <table border="0" width="100%">
                    <tr>
                        <td width="50px"></td>
                        <td width="340px"></td>
                        <td width="150px" style="letter-spacing: 0.5px;">วันที่ <b>{{formatDateThaiLongPS(@$row->View_GuardConLetter->PRINTDT)}}</b></td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="540px"></td>
                    </tr>
                    <tr style="line-height: 120%">
                        <td width="50px"><b>เรื่อง</b></td>
                        <td width="410px"><u><b>แจ้งให้ชำระหนี้ค่างวด</b></u></td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 120%">
                        <td width="50px"><b>เรียน</b></td>
                        <td width="150px" style="letter-spacing: 0.5px;">{{@$row->View_GuardConLetter->Name_Cus}}</td>
                        <td width="260px" style="letter-spacing: 0.5px;">ผู้เช่าซื้อ</td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 120%">
                        <td width="50px"><b>เรียน</b></td>
                        <td width="150px" style="letter-spacing: 0.5px;">{{@$Guarantor1->Name_Cus}}</td>
                        <td width="260px" style="letter-spacing: 0.5px;">ผู้ค้ำประกัน</td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 120%">
                        <td width="50px">@if(@$Guarantor2)<b>เรียน</b>@endif</td>
                        <td width="150px" style="letter-spacing: 0.5px;">@if(@$Guarantor2){{@$Guarantor1->Name_Cus}}@endif</td>
                        <td width="260px" style="letter-spacing: 0.5px;">@if(@$Guarantor2) ผู้ค้ำประกัน @endif</td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="50px"></td>
                        <td width="410px"></td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="50px"></td>
                        <td width="150px" style="text-align: justify;letter-spacing: 0.5px;">ตามที่ท่านได้เช่าซื้อรถยนต์ยี่ห้อ</td>
                        <td width="150px" align="center" style="text-align: justify;letter-spacing: 0.5px;"><b>{{@$row->View_GuardConLetter->Brands}}</b></td>
                        <td width="30px" style="text-align: justify;letter-spacing: 0.5px;">แบบ</td>
                        <td width="160px" align="center" style="text-align: justify;letter-spacing: 0.5px;"><b>{{@$row->View_GuardConLetter->Groups}}</b></td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="10px" align="left">สี</td>
                        <td width="100px" align="center"><b>{{@$row->View_GuardConLetter->Vehicle_Color}}</b></td>
                        <td width="70px" align="left">หมายเลขตัวถัง</td>
                        <td width="150px" align="center"><b>{{@$row->View_GuardConLetter->Vehicle_Chassis}}</b></td>
                        <td width="80px" align="left">หมายเลขเครื่อง</td>
                        <td width="130px" align="right"><b>{{@$row->View_GuardConLetter->Vehicle_Engine}}</b></td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="60px" align="left">เลขทะเบียน</td>
                        <td width="120px" align="center"><b>{{@$row->View_GuardConLetter->typeLicense}}</b></td>
                        <td width="270px" align="left">ของบริษัทฯบัดนี้ตามหลักฐานของทางบริษัทฯ อ้างอิงเลขที่สัญญา</td>
                        <td width="90px" align="right"><b>{{@$row->CONTNO}}</b></td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="50px"></td>
                        <td width="60px" style="letter-spacing: 0.65px;">ตั้งแต่งวดที่</td>
                        <td width="40px" align="center" style="letter-spacing: 0.65px;"><b>{{@$row->View_GuardConLetter->EXP_FRM}}</b></td>
                        <td width="45px" style="letter-spacing: 0.65px;">ถึงงวดที่</td>
                        <td width="40px" align="center" style="letter-spacing: 0.65px;"><b>{{@$row->View_GuardConLetter->EXP_TO}}</b></td>
                        <td width="35px" style="letter-spacing: 0.65px;">รวม</td>
                        <td width="45px" align="center" style="letter-spacing: 0.65px;"><b>{{@$row->View_GuardConLetter->EXP_PRD}}</b></td>
                        <td width="100px" style="letter-spacing: 0.65px;">งวด เป็นจำนวนเงิน</td>
                        <td width="90px" align="center" style="letter-spacing: 0.65px;"><b>{{number_format(@$row->View_GuardConLetter->EXP_AMT,2)}}</b></td>
                        <td width="35px" align="right" style="letter-spacing: 0.65px;">บาท</td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="145px" style="letter-spacing: 0.75px;">และมียอดคงเหลือตามสัญญา</td>
                        <td width="120px" align="center" style="letter-spacing: 0.75px;"><b>{{number_format(@$row->View_GuardConLetter->TOTPRC - @$row->View_GuardConLetter->SMPAY,2)}}</b></td>
                        <td width="275px" style="letter-spacing: 0.65px;">บาท (ทั้งนี้ไม่รวมดอกเบี้ย และค่าใช้จ่ายอื่นๆ)</td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="50px" style="letter-spacing: 0.75px;"></td>
                        <td width="490px" style="letter-spacing: 0.75px;">ฉะนั้น ขอให้ท่ายตรวจสอบ และชำระเงินที่ค้างชำระดำงกล่าวข้างต้นพร้อมค่าใช้จ่ายให้กับทางบริษัทฯ</td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="60px" style="letter-spacing: 0.75px;">ภายในวันที่</td>
                        <td width="140px" align="center" style="letter-spacing: 0.75px;"><b>{{formatDateThaiLongPS(date('Y-m-d', strtotime(@$row->View_GuardConLetter->PRINTDT . ' +7 days')))}}</b></td>
                        <td width="340px" style="letter-spacing: 0.3px;">หรือถ้าท่านมีเหตุขัดข้องประการใด ขอให้ท่านได้ไปพบ ณ ที่ทำการบริษัทฯ</td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="540px" style="letter-spacing: 0.75px;">ภายในกำหนดเวลาดังกล่าว มิฉะนั้นบริษัทฯ จะดำเนินการตามเงื่อนไข แห่งสัญญาต่อไป</td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="50px"></td>
                        <td width="490px" style="text-align: justify;letter-spacing: 0.75px;">อนึ่ง หากท่านชำระเงินตามรายการข้างต้นเรียบร้อยแล้ว หรือมีข้อผิดพลาดประการใด ก็ขอความ</td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="540px" style="letter-spacing: 0.75px;">กรุณาจากท่านได้โปรดแจ้งให้กับทางบริษัทฯทราบด่วน บริษัทฯหวังว่าจะได้รับความร่วมมือจากท่านอย่างดี</td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="540px" style="letter-spacing: 0.5px;">ขอขอบคุณล่วงหน้า ณ ที่นี้ด้วย</td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="350px"></td>
                        <td width="190px" style="letter-spacing: 0.3px;"><b>ขอแสดงความนับถือ</b></td>
                    </tr>
                    <tr style="line-height: 350%">
                        <td width="540px"></td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="355px"></td>
                        <td width="185px" style="letter-spacing: 0.3px;"><b>ผู้มีอำนาจลงนาม</b></td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="540px"><b>หมายเหตุ</b></td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="40px"></td>
                        <td width="500px" style="letter-spacing: 0.5px;">- หากท่านมีปัญหาในการชำระค่างวด หรือยังไม่ได้รับใบเสร็จของการชำระเงินล่าสุด โปรดติดต่อบริษัทฯ</td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="40px"></td>
                        <td width="500px" style="letter-spacing: 0.3px;">โทร {{@$row->View_GuardConLetter->Company_Tel}} แฟกซ์ {{(@$row->View_GuardConLetter->Company_fax?@$row->View_GuardConLetter->Company_fax:'-')}} หรือตรวจสอบด้วยตัวเองที่บริษัทฯ</td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="40px"></td>
                        <td width="500px">- หากท่านเปลี่ยนแปลงที่อยู่ใหม่โปรดส่งรายละเอียดที่อยู่ใหม่ให้กับทางบริษัทฯทราบทันที่เพื่อประโยชน์ของตัวท่านเอง</td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="540px" style="font-size:14px;">หมายเหตุ หากไม่ชำระตามกำหนด ท่านต้องเสียค่าติดตามเพิ่มพร้อมค่างวดในงวดถัดไป</td>
                    </tr>
                </table>
                <p></p>
            @endif

        @endif
    @endforeach
  </body>
</html>