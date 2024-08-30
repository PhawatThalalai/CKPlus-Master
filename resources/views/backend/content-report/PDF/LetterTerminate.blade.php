<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>หนังสือบอกเลิก</title>
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
            if(@$row->View_GuardConLetter->typeCode == 'car'){
                @$typeCode = 'รถยนต์';
            }
            elseif(@$row->View_GuardConLetter->typeCode == 'moto'){
                @$typeCode = 'มอเตอร์ไซต์';
            }
            elseif(@$row->View_GuardConLetter->typeCode == 'land'){
                @$typeCode = 'ที่ดิน';
            }
            $temp_FRM = '+' . (intval($row->View_GuardConLetter->EXP_FRM) - 1) . ' months';
        @endphp
        @if($row->ToPact->CodeLoan_Con == '01')
            @if(@$Guarantor1 != NULL)
                <table border="0" width="100%">
                    <tr style="line-height: 90%">
                        <td width="540px"><h1>{{@$row->View_GuardConLetter->Company_Name}}</h1></td>
                    </tr>
                    <tr style="line-height: 100%">
                        <td width="540px" style="letter-spacing: 0.5px;font-size:18px;">โทรศัพท์ {{@$row->View_GuardConLetter->Company_Tel}} แฟกซ์ {{(@$row->View_GuardConLetter->Company_fax?@$row->View_GuardConLetter->Company_fax:'-')}}</td>
                    </tr>
                    <tr style="line-height: 100%">
                        <td width="540px" style="letter-spacing: 0.5px;font-size:18px;">{{@$row->View_GuardConLetter->Company_Addr}}</td>
                    </tr>
                    <tr style="line-height: 100%">
                        <td width="540px"></td>
                    </tr>
                </table>
                <hr style="height:1px;width:540px;">
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
                        <td width="50px">เรื่อง</td>
                        <td width="410px"><b>บอกเลิกสัญญาเช่าซื้อ เลขที่ {{@$contract->CONTNO}}</b></td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 120%">
                        <td width="50px">เรียน</td>
                        <td width="200px" style="letter-spacing: 0.5px;"><b>{{@$row->View_GuardConLetter->Name_Cus}}</b></td>
                        <td width="210px" style="letter-spacing: 0.5px;">(ผู้เช่าซื้อ)</td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 120%">
                        <td width="50px">ที่อยู่</td>
                        <td width="410px" style="letter-spacing: 0.5px;">{{@$row->View_GuardConLetter->cusaddress}}</td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 120%">
                        <td width="50px">เรียน</td>
                        <td width="200px" style="letter-spacing: 0.5px;"><b>{{@$Guarantor1->Name_Cus}}</b></td>
                        <td width="210px" style="letter-spacing: 0.5px;">(ผู้ค้ำประกัน)</td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 120%">
                        <td width="50px">ที่อยู่</td>
                        <td width="410px" style="letter-spacing: 0.5px;">{{@$GuarantorAdds1->houseNumber_Adds}} ม.{{str_replace("ม.","",@$GuarantorAdds1->houseGroup_Adds)}} {{@$GuarantorAdds1->village_Adds}} ต.{{@$GuarantorAdds1->houseTambon_Adds}} อ.{{@$GuarantorAdds1->houseDistrict_Adds}} จ.{{@$GuarantorAdds1->houseProvince_Adds}} {{@$GuarantorAdds1->Postal_Adds}}</td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="50px"></td>
                        <td width="410px"></td>
                        <td width="80px"></td>
                    </tr>
                </table>
                <table border="0" width="100%">
                    <tr style="line-height: 130%">
                        <td width="50px"></td>
                        <td width="30px" style="letter-spacing: 0.5px;">ตามที่</td>
                        <td width="180px" align="center" style="letter-spacing: 0.5px;"><b>{{@$row->View_GuardConLetter->Name_Cus}}</b></td>
                        <td width="210px" align="center" style="letter-spacing: 0.4px;">ผู้เช่าซื้อ ได้ทำสัญญาเช่าซื้อทรัพย์สินประเภท </td>
                        <td width="70px" align="right" style="letter-spacing: 0.5px;"><b>{{@$typeCode}}</b></td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="20px" align="left">ยี่ห้อ</td>
                        <td width="100px" align="center"><b>{{@$row->View_GuardConLetter->Brands}}</b></td>
                        <td width="15px" align="left">รุ่น</td>
                        <td width="125px" align="center"><b>{{@$row->View_GuardConLetter->Groups}}</b></td>
                        <td width="80px" align="left">หมายเลขทะเบียน</td>
                        <td width="130px" align="center"><b>{{@$row->View_GuardConLetter->typeLicense}}</b></td>
                        <td width="70px" align="right">หมายเลขเครื่อง</td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="120px" align="left"><b>{{@$row->View_GuardConLetter->Vehicle_Engine}}</b></td>
                        <td width="70px" align="left">หมายเลขตัวถัง</td>
                        <td width="150px" align="center"><b>{{@$row->View_GuardConLetter->Vehicle_Chassis}}</b></td>
                        <td width="30px" align="left">ไปจาก</td>
                        <td width="170px" align="right" style="letter-spacing: 0.5px;">{{@$row->View_GuardConLetter->Company_Name}}</td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="120px" align="left" style="letter-spacing: 0.5px;">เป็นเงินค่าเช่าซื้อทั้งสิ้น</td>
                        <td width="160px" align="center"><b>{{number_format(@$contract->TCSHPRC,2)}} บาท</b></td>
                        <td width="260px" align="right"><b>({{IntconvertThai(@$contract->TCSHPRC)}})</b></td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="25px" align="left" style="letter-spacing: 0.5px;">โดยมี</td>
                        <td width="200px" align="center"><b>{{@$Guarantor1->Name_Cus}}</b></td>
                        <td width="315px" align="right" style="letter-spacing: 0.3px;">ผู้ค้ำประกัน ได้ตกลงทำสัญญาค้ำประกันการเช่าซื้อ โดยยอมรับผิดอย่าง</td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="540px" align="left" style="letter-spacing: 0.5px;">ลูกหนี้ร่วมกับผู้เช่าซื้อนั้น</td>
                    </tr>
                </table>
                <table border="0" width="100%">
                    <tr style="line-height: 130%">
                        <td width="50px"></td>
                        <td width="270px" style="letter-spacing: 0.5px;">บัดนี้ ปรากฏว่าผู้เช่าซื้อได้ค้างชำระค่าเช่าซื้อ ตั้งแต่งวดที่</td>
                        <td width="40px" align="center" style="letter-spacing: 0.65px;"><b>{{@$row->View_GuardConLetter->EXP_FRM}}</b></td>
                        <td width="55px" style="letter-spacing: 0.5px;">ประจำวันที่</td>
                        <td width="125px" align="right" style="letter-spacing: 0.65px;"><b>{{formatDateThaiLongPS(date("Y-m-d",strtotime(@$temp_FRM,strtotime($contract->FDATE))))}}</b></td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="25px" style="letter-spacing: 0.75px;">รวม</td>
                        <td width="40px" align="center" style="letter-spacing: 0.75px;"><b>{{ceil(@$row->View_GuardConLetter->EXP_PRD)}}</b></td>
                        <td width="100px" style="letter-spacing: 0.65px;">งวด เป็นจำนวนเงิน</td>
                        <td width="110px" align="center" style="letter-spacing: 0.65px;"><b>{{number_format(@$row->View_GuardConLetter->EXP_AMT,2)}}</b></td>
                        <td width="25px" style="letter-spacing: 0.65px;">บาท</td>
                        <td width="240px" align="right" style="letter-spacing: 0.65px;"><b>({{IntconvertThai(@$row->View_GuardConLetter->EXP_AMT)}})</b></td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="540px" style="letter-spacing: 0.7px;">บริษัทฯจึงขอให้ท่านเงินจำนวนดังกล่าว มาชำระให้เสร็จสิ้น ณ ที่ทำการบริษัทฯภายใน 30 วัน นับตั้งแต่วันที่ท่าน</td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="540px" style="letter-spacing: 0.75px;">ได้รับหรือถือว่าได้รับหนังสือฉบับนี้</td>
                    </tr>
                </table>
                <table border="0" width="100%">
                    <tr style="line-height: 130%">
                        <td width="50px"></td>
                        <td width="490px" style="letter-spacing: 0.3px;">หากครบกำหนดดังกล่าวข้างต้น แล้วท่านเพิกเฉยไม่ดำเนินการตามหนังสือฉบับนี้ บริษัทฯขอถือว่าหนังสือฉบับนี้</td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="540px" style="letter-spacing: 0.55px;">เป็นหนังสือบอกเลิกสัญญาเช่าซื้อดังกล่าวข้างต้น และท่านมีหน้าที่ต้องส่งมอบทรัพย์สินที่เช่าซื้อคืนในสภาพเรียบร้อย</td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="540px" style="letter-spacing: 0.45px;">และใช้การได้ดี ภายใน 7 วัน นับตั้งแต่วันที่ครบกำหนดชำระหนี้ดังกล่าวข้างต้น หากท่านเพิกเฉย บริษัทฯมีความจำเป็น</td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="540px" style="letter-spacing: 0.5px;">ต้องดำเนินคดีกับท่านทันที และท่านยังต้องรับผิดชอบในความเสียหายอันพึงเกิดทั้งปวงด้วย</td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="50px"></td>
                        <td width="490px" style="letter-spacing: 0.5px;">หากท่านมีการชำระเงินจำนวนดังกล่าวเป็นที่เรียบร้อยแล้ว ทางบริษัทฯต้องขออภัย ณ โอกาสนี้ด้วย</td>
                    </tr>
                    <tr style="line-height: 400%">
                        <td width="540px"></td>
                    </tr>
                    <tr style="line-height: 130%">
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
                        <td width="210px" style="letter-spacing: 0.3px;">({{@$authorize}})</td>
                    </tr>
                    <tr style="line-height: 130%">
                        <td width="355px"></td>
                        <td width="185px" style="letter-spacing: 0.3px;"><b>ผู้มีอำนาจลงนาม</b></td>
                    </tr>
                    <tr style="line-height: 250%">
                        <td width="540px"></td>
                    </tr>
                    <tr style="line-height: 100%">
                        <td width="540px" style="letter-spacing: 0.3px;"><b>หมายเหตุ ไม่รวมค่าปรับและดอกเบี้ย</b></td>
                    </tr>
                </table>
                <p></p>
            @endif
        @elseif($row->ToPact->CodeLoan_Con == '02')
            @if(@$Guarantor1 != NULL)
                <table border="0" width="100%">
                    <tr style="line-height: 90%">
                        <td width="540px"><h1>{{@$row->View_GuardConLetter->Company_Name}}</h1></td>
                    </tr>
                    <tr style="line-height: 100%">
                        <td width="540px" style="letter-spacing: 0.5px;font-size:18px;">โทรศัพท์ {{@$row->View_GuardConLetter->Company_Tel}}</td>
                    </tr>
                    <tr style="line-height: 100%">
                        <td width="540px" style="letter-spacing: 0.5px;font-size:18px;">{{@$row->View_GuardConLetter->Company_Addr}}</td>
                    </tr>
                    <tr style="line-height: 100%">
                        <td width="540px"></td>
                    </tr>
                </table>
                <hr style="height:1px;width:540px;">
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
                        <td width="410px">บอกเลิกสัญญากู้ยืมเงิน และขอให้ชำระหนี้กู้ยืมคืน เลขที่สัญญา {{$row->CONTNO}}</td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 120%">
                        <td width="50px"><b>เรียน</b></td>
                        <td width="150px" style="letter-spacing: 0.5px;">{{@$row->View_GuardConLetter->Name_Cus}}</td>
                        <td width="260px" style="letter-spacing: 0.5px;">ผู้กู้</td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 120%">
                        <td width="50px"><b></b></td>
                        <td width="150px" style="letter-spacing: 0.5px;">{{@$Guarantor1->Name_Cus}}</td>
                        <td width="260px" style="letter-spacing: 0.5px;">ผู้ค้ำประกัน</td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 200%">
                        <td width="540px"></td>
                    </tr>
                    <tr style="line-height: 120%">
                        <td width="50px"><b>อ้างอิงถึง</b></td>
                        <td width="150px" style="letter-spacing: 0.5px;">สัญญากู้ยืมเงิน ฉบับลงวันที่</td>
                        <td width="260px" style="letter-spacing: 0.5px;">{{date('d/m/Y',strtotime($contract->SDATE))}}</td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 120%">
                        <td width="50px"><b></b></td>
                        <td width="150px" style="letter-spacing: 0.5px;">สัญญาค้ำประกัน ฉบับลงวันที่</td>
                        <td width="260px" style="letter-spacing: 0.5px;">{{(@$Guarantor1->Name_Cus != NULL)?date('d/m/Y',strtotime($contract->SDATE)):''}}</td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 200%">
                        <td width="540px"></td>
                    </tr>
                </table>
                <table border="0" width="100%">
                    <tr style="line-height: 150%">
                        <td width="50px"></td>
                        <td width="150px" style="letter-spacing: 0.2px;">ตามที่ท่านได้ทำสัญญากู้ยืมเงินกับ</td>
                        <td width="190px" align="center" style="letter-spacing: 0.1px;">{{@$row->View_GuardConLetter->Company_Name}}</td>
                        <td width="150px" style="letter-spacing: 0.1px;">ไว้ตามสัญญากู้ยืมเงิน ฉบับลง วันที่</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="60px" align="left">{{date('d/m/Y',strtotime(@$contract->SDATE))}}</td>
                        <td width="480px" align="right" style="letter-spacing: -0.1px;">เป็นเงินจำนวน {{number_format(@$contract->TCSHPRC,2)}} บาท ({{IntconvertThai(@$contract->TCSHPRC)}}) โดยคิดดอกเบี้ยตามสัญญาฉบับ</td>
                        <!-- <td width="130px" align="left"></td> -->
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="510px" style="letter-spacing: 0.6px;">ดังกล่าวกำหนดไว้ โดยมีกำหนดชำระคืนเป็นรายงวด งวดละเดือน เดือนละ {{number_format($contract->TOT_UPAY,2)}} บาท จำนวน {{number_format($contract->T_NOPAY,0)}} งวด</td>
                        <td width="30px" align="right" style="letter-spacing: 0.6px;">โดยมี</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <!-- <td width="465px" style="letter-spacing: 0.6px;">กำหนดให้ชำระหมดภายในวันที่ {{date('d/m/Y', strtotime(@$contract->LDATE . ' +7 days'))}} เนื่องจากท่านมิได้ชำระหนี้สัญญากู้ยืมตามกำหนด</td> -->
                        <td width="465px" style="letter-spacing: 0.6px;">กำหนดให้ชำระหมดภายในวันที่ {{date('d/m/Y', strtotime(@$contract->LDATE))}} เนื่องจากท่านมิได้ชำระหนี้สัญญากู้ยืมตามกำหนด</td>
                        <td width="75px" align="right" style="letter-spacing: 0.1px;">โดยค้างชำระหนี้</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="140px" style="letter-spacing: 0.5px;">ตั้งแต่งวดที่ {{@$row->View_GuardConLetter->EXP_FRM}} จนถึงปัจจุบัน</td>
                        <td width="400px" align="right" style="letter-spacing: 0.5px;">เป็นเงินจำนวน {{number_format(@$row->View_GuardConLetter->EXP_AMT,2)}} บาท ({{IntconvertThai(@$row->View_GuardConLetter->EXP_AMT)}})</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="180px" style="letter-spacing: 0.2px;">{{@$row->View_GuardConLetter->Company_Name}}</td>
                        <td width="360px" align="right" style="letter-spacing: 0.2px;">ในฐานะผู้ให้กู้จึงไม่ประสงค์จะทำสัญญากู้ยืมกับท่านอีกต่อไป จึงขอบอกเลิกสัญญา</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px" style="letter-spacing: 0.3px;">และขอให้ท่านนำเงินกู้ยืมที่ยังคงค้างชำระมาชำระคืนให้แก่ {{@$row->View_GuardConLetter->Company_Name}} ทั้งหมดทันที</td>
                    </tr>
                    <tr style="line-height: 200%">
                        <td width="540px"></td>
                    </tr>
                </table>
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
                <table border="0" width="100%">
                    <tr style="line-height: 150%">
                        <td width="220px" style="letter-spacing: 0.65px;">บัดนี้ ข้าพเจ้า {{@$authorize}}</td>
                        <td width="320px" align="right" style="letter-spacing: 0.5px;">ผู้รับมอบอำนาจจากบริษัทฯ มีความจำเป็นที่จะต้องกราบเรียนท่านได้</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="170px" style="letter-spacing: 0.75px;">โปรดนำเงินที่ค้างชำระ จำนวนเงิน</td>
                        <td width="80px" align="center" style="letter-spacing: 0.75px;">{{number_format(@$row->View_GuardConLetter->EXP_AMT,2)}}</td>
                        <td width="25px" align="left" style="letter-spacing: 0.75px;">บาท</td>
                        <td width="265px" align="right" style="letter-spacing: 0.75px;">({{IntconvertThai(@$row->View_GuardConLetter->EXP_AMT)}}) พร้อม</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px" style="letter-spacing: 0.6px;">ดอกเบี้ยที่กำหนดไว้ในสัญญากู้ยืม ดอกเบี้ยผิดนัด และค่าใช้จ่ายต่างๆของบริษัทฯ หรือค่าใช้จ่ายในการติดตามทรัพย์</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px" style="letter-spacing: 0.4px;">กลับคืน ภายในระยะเวลา 30 วัน หากท่านยังคงเพิกเฉยข้าพเจ้ามีความจำเป็นจะต้องดำเนินการตามกฏหมายต่อไป</td>
                    </tr>
                    <tr style="line-height: 400%">
                        <td width="540px"></td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="350px"></td>
                        <td width="190px" style="letter-spacing: 0.3px;"><b>ขอแสดงความนับถือ</b></td>
                    </tr>
                    <tr style="line-height: 350%">
                        <td width="540px"></td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="330px"></td>
                        <td width="210px" style="letter-spacing: 0.3px;">({{@$authorize}})</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="355px"></td>
                        <td width="185px" style="letter-spacing: 0.3px;"><b>ผู้รับมอบอำนาจ</b></td>
                    </tr>
                    <tr style="line-height: 250%">
                        <td width="540px"></td>
                    </tr>
                    <tr style="line-height: 100%">
                        <td width="540px" style="letter-spacing: 0.3px;"><b>**หมายเหตุ ไม่รวมค่าปรับและดอกเบี้ย</b></td>
                    </tr>
                </table>
                <p></p>
            @endif
        @endif
    @endforeach
  </body>
</html>