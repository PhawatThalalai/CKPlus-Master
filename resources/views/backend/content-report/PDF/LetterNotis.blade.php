<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>หนังสือโนติส</title>
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
                    <tr style="line-height: 150%">
                        <td width="540px"></td>
                    </tr>
                    <tr style="line-height: 120%">
                        <td width="460px"><b>เลขที่ {{@$contract->CONTNO}}</b></td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px"></td>
                    </tr>
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
                        <td width="410px"><b>ขอให้ชำระหนี้</b></td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 120%">
                        <td width="50px">เรียน</td>
                        <td width="170px" style="letter-spacing: 0.5px;"><b>{{@$row->View_GuardConLetter->Name_Cus}}</b></td>
                        <td width="240px" style="letter-spacing: 0.5px;">ผู้เช่าซื้อ</td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 120%">
                        <td width="50px"></td>
                        <td width="170px" style="letter-spacing: 0.5px;"><b>{{@$Guarantor1->Name_Cus}}</b></td>
                        <td width="240px" style="letter-spacing: 0.5px;">ผู้ค้ำประกัน</td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 120%">
                        <td width="50px"></td>
                        <td width="170px" style="letter-spacing: 0.5px;"><b>{{(@$Guarantor2->Name_Cus!=NULL)?@$Guarantor2->Name_Cus:''}}</b></td>
                        <td width="240px" style="letter-spacing: 0.5px;">@if(@$Guarantor2->Name_Cus!=NULL)ผู้ค้ำประกัน@endif</td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 300%">
                        <td width="540px"></td>
                    </tr>
                </table>
                <table border="0" width="100%">
                    <tr style="line-height: 150%">
                        <td width="50px"></td>
                        <td width="30px" style="letter-spacing: 0px;">ตามที่</td>
                        <td width="180px" align="center" style="letter-spacing: 0.5px;"><b>{{@$row->View_GuardConLetter->Company_Name}}</b></td>
                        <td width="280px" align="right" style="letter-spacing: 0.2px;">ได้ทำการบอกเลิกสัญญาเช่าซื้อกับท่าน ตามสัญญาเช่าซื้อรถยนต์</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="135px" align="left" style="letter-spacing: 0.1px;">ฉบับลงวันที่ {{formatDateThaiLongPS(@$contract->SDATE)}}</td>
                        <td width="90px" align="center" style="letter-spacing: 0.1px;">เป็นรถยนต์ยี่ห้อ</td>
                        <td width="90px" align="center"><b>{{@$row->View_GuardConLetter->Groups}}</b></td>
                        <td width="85px" align="center" style="letter-spacing: 0.1px;">หมายเลขทะเบียน</td>
                        <td width="90px" align="center" style="letter-spacing: 0.1px;"><b>{{@$row->View_GuardConLetter->typeLicense}}</b></td>
                        <td width="50px" align="right" style="letter-spacing: 0.3px;">สี{{@$row->View_GuardConLetter->Vehicle_Color}}</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="70px" align="left">หมายเลขตัวถัง</td>
                        <td width="150px" align="center"><b>{{@$row->View_GuardConLetter->Vehicle_Chassis}}</b></td>
                        <td width="80px" align="left">หมายเลขเครื่อง</td>
                        <td width="120px" align="center"><b>{{@$row->View_GuardConLetter->Vehicle_Engine}}</b></td>
                        <td width="120px" align="left"></td>
                    </tr>
                </table>
                <table border="0" width="100%">
                    <tr style="line-height: 150%">
                        <td width="50px"></td>
                        <td width="150px" style="letter-spacing: 0.5px;">โดยการเช่าซื้อดังกล่าวได้มี</td>
                        <td width="290px" align="center" style="letter-spacing: 0.2px;"><b>{{@$Guarantor1->Name_Cus}} @if(@$Guarantor2!=NULL), {{@$Guarantor2->Name_Cus}} @endif</b></td>
                        <td width="50px" align="right" style="letter-spacing: 0.2px;">ค้ำประกัน</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px" align="left" style="letter-spacing: 0.5px;">โดยผู้ค้ำประกันยอมรับผิดอย่างลูกหนี้ร่วม ในกรณีผู้เช่าซื้อละเมิดข้อสัญญา รายละเอียดท่านทั้งสองทราบดีอยู่แล้วนั้น</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="50px"></td>
                        <td width="490px" style="letter-spacing: 0.7px;">ปรากฏว่า บัดนี้ได้พ้นกำหนดตามที่หนังสือบอกเลิกสัญญาแล้ว แต่ท่านทั้งสองยังมิได้</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px" align="left" style="letter-spacing: 0.5px;">ส่งมอบรถยนต์คืน หรือชำระหนี้แต่อย่างใด</td>
                    </tr>
                </table>
                <table border="0" width="100%">
                    <tr style="line-height: 150%">
                        <td width="50px"></td>
                        <td width="250px" align="left" style="letter-spacing: 0.4px;">ฉะนั้น ข้าพเจ้าในฐานะทนายความผู้รับมอบอำนาจจาก</td>
                        <td width="180px" align="center" style="letter-spacing: 0.5px;">{{@$row->View_GuardConLetter->Company_Name}}</td>
                        <td width="60px" align="right" style="letter-spacing: 0.25px;">ผู้ให้เช่าซื้อ</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px" align="left" style="letter-spacing: 0.8px;">จึงขอให้ท่านทั้งสองมาดำเนินการส่งมอบรถยนต์ หรือชำระหนี้ที่ค้างชำระ เงินค้างชำระเช่าซื้อ ดอกเบี้ยผิดนัด</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px" align="left" style="letter-spacing: 0.6px;">และภาษี จนถึงวันที่ <b>{{formatDateThaiLongPS(date("Y-m-d",strtotime(@$temp_FRM,strtotime($contract->FDATE))))}}</b> เป็นจำนวนเงิน <b>{{number_format(@$row->View_GuardConLetter->EXP_AMT,2)}}</b> บาท ({{IntconvertThai(@$row->View_GuardConLetter->EXP_AMT)}})</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px" style="letter-spacing: 0.7px;">มาชำระ ณ {{@$row->View_GuardConLetter->Company_Name}} ภายใน 7 วัน นับตั้งแต่วันที่ท่านได้รับหนังสือ หากท่านทั้งสองเพิกเฉย</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px" style="letter-spacing: 0.5px;">ไม่ชำระหนี้ดังกล่าวอีก ข้าพเจ้ามีความจำเป็นอย่างยิ่งที่จะต้องดำเนินคดีกับท่านทั้งสองตามกฏหมายต่อไป</td>
                    </tr>
                    <tr style="line-height: 300%">
                        <td width="540px"></td>
                    </tr>
                </table>
                <table border="0" width="100%">
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
                    <tr style="line-height: 150%">
                        <td width="540px"></td>
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
                    <tr style="line-height: 150%">
                        <td width="540px"></td>
                    </tr>
                    <tr style="line-height: 120%">
                        <td width="60px"><b>สัญญาเลขที่</b></td>
                        <td width="480px"><b>{{$row->CONTNO}}</b></td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px"></td>
                    </tr>
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
                        <td width="410px">แจ้งเตือนขอให้ชำระหนี้</td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 120%">
                        <td width="50px"><b>เรียน</b></td>
                        <td width="170px" style="letter-spacing: 0.5px;">{{@$row->View_GuardConLetter->Name_Cus}}</td>
                        <td width="240px" style="letter-spacing: 0.5px;">ผู้กู้</td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 120%">
                        <td width="50px"><b></b></td>
                        <td width="170px" style="letter-spacing: 0.5px;">{{@$Guarantor1->Name_Cus}}</td>
                        <td width="240px" style="letter-spacing: 0.5px;">ผู้ค้ำประกัน</td>
                        <td width="80px"></td>
                    </tr>
                    <tr style="line-height: 300%">
                        <td width="540px"></td>
                    </tr>
                </table>
                <table border="0" width="100%">
                    <tr style="line-height: 150%">
                        <td width="50px"></td>
                        <td width="490px" style="letter-spacing: -0.1px;">ตามที่ท่านได้ทำสัญญากู้ยืมเงินกับ {{@$row->View_GuardConLetter->Company_Name}} ไว้ตามสัญญากู้ยืมเงิน ฉบับลง วันที่ {{date('d/m/Y',strtotime(@$contract->SDATE))}}</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="65px" align="left" style="letter-spacing: 0.1px;">เป็นเงินจำนวน</td>
                        <td width="90px" align="center" style="letter-spacing: 0.1px;">{{number_format(@$contract->TCSHPRC,2)}}</td>
                        <td width="20px" align="left" style="letter-spacing: 0.1px;">บาท</td>
                        <td width="175px" align="center" style="letter-spacing: 0.1px;">({{IntconvertThai(@$contract->TCSHPRC)}})</td>
                        <td width="190px" align="right" style="letter-spacing: 0.3px;">โดยคิดดอกเบี้ยตามสัญญาฉบับที่กำหนดไว้</td>
                        <!-- <td width="130px" align="left"></td> -->
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px" style="letter-spacing: 0.6px;">โดยมีกำหนดชำระคืนเป็นรายงวด งวดละเดือน เดือนละ {{number_format($contract->TOT_UPAY,2)}} บาท ({{IntconvertThai(@$contract->TOT_UPAY)}}) จำนวน {{number_format($contract->T_NOPAY,0)}}</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="25px" style="letter-spacing: 0.6px;">งวด</td>
                        <td width="460px" style="letter-spacing: 0px;">โดยมีกำหนดให้ชำระหมดภายในวันที่ {{date('d/m/Y', strtotime(@$contract->LDATE))}} ทั้งนี้เนื่องจากผู้กู้ยังคงมิได้ชำระหนี้สัญญากู้ยืมตามกำหนด</td>
                        <td width="55px" align="right" style="letter-spacing: 0px;">โดยค้างชำระ</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="160px" style="letter-spacing: 0.3px;">หนี้ตั้งแต่ งวดที่ {{@$row->View_GuardConLetter->EXP_FRM}} จนถึงงวดที่ {{@$row->View_GuardConLetter->EXP_TO}}</td>
                        <td width="75px" align="center" style="letter-spacing: 0.5px;">เป็นเงินจำนวน</td>
                        <td width="120px" align="center" style="letter-spacing: 0.5px;">{{number_format(@$row->View_GuardConLetter->EXP_AMT,2)}} บาท</td>
                        <td width="185px" align="right" style="letter-spacing: 0.5px;">({{IntconvertThai(@$row->View_GuardConLetter->EXP_AMT)}})</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px" align="left" style="letter-spacing: 0.25px;">ฉะนั้นขอให้ท่านตรวจสอบยอดค้างชำระ และชำระเงินกู้ยืมดังกล่าวข้างต้น พร้อมค่าใช้จ่ายในการทวงถาม และติดตามทรัพย์</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px" align="left" style="letter-spacing: 0.25px;">ให้แก่บริษัท ฯ ภายในระยะเวลา 15 วัน นับแต่ได้รับหนังสือฉบับนี้ หากปรากฏว่ามีเหตุขัดข้องประการใด ขอให้ท่านได้โปรด</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px" align="left" style="letter-spacing: 0.15px;">ไปพบ ณ ที่ทำการบริษัท ฯ ภายในระยะเวลาดังกล่าว มิเช่นนั้นทางบริษัท ฯ ขอสงวนสิทธิ์ และดำเนินการตามเงื่อนไขในสัญญา</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px" style="letter-spacing: 0.3px;">ต่อไป</td>
                    </tr>
                    <tr style="line-height: 300%">
                        <td width="540px"></td>
                    </tr>
                </table>
                <table border="0" width="100%">
                    <tr style="line-height: 150%">
                        <td width="540px" style="letter-spacing: 0.15px;">อนึ่งหากท่านได้ชำระเงินตามรายการข้างต้นเป็นที่เรียบร้อยแล้ว หรือมีเหตุผิดพลาดประการใด ทางบริษัทฯขอความกรุณาเรียน</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px" style="letter-spacing: 0.3px;">แจ้งให้บริษัทฯ ทราบโดยด่วน และทางบริษัทฯต้องขออภัยหากท่านได้ชำระเป็นที่ครบถ้วนแล้ว ทางบริษัทฯหวังว่าจะได้รับ</td>
                    </tr>
                    <tr style="line-height: 150%">
                        <td width="540px" style="letter-spacing: 0.2px;">ความร่วมมือจากท่าน และขอขอบพระคุณท่านไว้ล่วงหน้า ณ ที่นี้ด้วย</td>
                    </tr>
                    <tr style="line-height: 300%">
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
                        <td width="350px"></td>
                        <td width="190px" style="letter-spacing: 0.3px;"><b>ขอแสดงความนับถือ</b></td>
                    </tr>
                    <tr style="line-height: 300%">
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
                </table>
                <p></p>
            @endif
        @endif
    @endforeach
  </body>
</html>