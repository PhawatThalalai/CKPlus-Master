<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title></title>

  </head>
  <style>
      @font-face {
            font-family: 'THSarabun';
            font-style: normal;
            font-weight: normal;
            src: url({{ asset('fonts/THSarabun.ttf') }});
            /* src: url({{ asset('fonts/THSarabunNew.ttf') }}) format('truetype'); */
        }
        @font-face {
            font-family: 'THSarabun Bold';
            font-style: normal;
            font-weight: bold;
            src: url({{ asset('fonts/THSarabun Bold.ttf') }});
            /* src: url({{ asset('fonts/THSarabunNew.ttf') }}) format('truetype'); */
        }

        @font-face {
            font-family: 'TFPimpakarn';
            font-style: normal;
            font-weight: normal;
            src: url({{ asset('fonts/TF Pimpakarn.ttf') }});
            /* src: url({{ asset('fonts/THSarabunNew.ttf') }}) format('truetype'); */
        }
        @font-face {
            font-family: 'TFPimpakarn';
            font-style: normal;
            font-weight: bold;
            src: url({{ asset('fonts/TF Pimpakarn Bol.ttf') }}) format('truetype');
        }

      .page_break { page-break-before: always; }
      body {
        /* color : white; */
        font-family: 'THSarabun';
        font-size: 12pt;
      }
      u {
          border-bottom: 2px dotted #000;
          text-decoration: none;
          margin : 10px;
          /* position: absolute; */
          /* top: 80px; */
          /* right: 0; */

      }
      .fontBl{
        font-family: 'TFPimpakarn';
        font-weight: bolder;
        font-size:12pt;
      }

      html {
        margin: 40px ;
      }
  </style>

      <body class="body">
        @php
          $DataCus = $data->ContractToCus; // ลูกค้า
          $LoanCom = $data->ContractToComOne; // บริษัท
          $dataCusAdd =  @$data->ContractToAddress; // ที่อยู่ที่ใช้ในการทำสัญญา
          $ConFinance = $data->ContractToCal; // ข้อมูลการจัด
          $ConOperateFee = $data->ContractToOperated; // รายละเอียดค่าใช้จ่าย

          $date1 = new DateTime($DataCus->Birthday_cus);
        //   $date2 = new DateTime( $data->Date_con);
          $date2 = new DateTime( $data->Date_monetary);
          $CusAge = $date1->diff($date2);

          $cusAdd = (@$dataCusAdd->houseNumber_Adds != NULL ? @$dataCusAdd->houseNumber_Adds : ''). ' ' .
                  (@$dataCusAdd->houseGroup_Adds != NULL ? " หมู่ ".@$dataCusAdd->houseGroup_Adds : ''). ' ' .
                  (@$dataCusAdd->building_Adds != NULL ? " อาคาร ".@$dataCusAdd->building_Adds : ''). ' ' .
                  (@$dataCusAdd->village_Adds != NULL ? " หมู่บ้าน ".@$dataCusAdd->village_Adds : ''). ' ' .
                  (@$dataCusAdd->roomNumber_Adds != NULL ? " เลขห้อง ". @$dataCusAdd->roomNumber_Adds : ''). ' ' .
                  (@$dataCusAdd->Floor_Adds != NULL ? " ชั้น ".@$dataCusAdd->Floor_Adds : ''). ' ' .
                  (@$dataCusAdd->alley_Adds != NULL ? " ซอย ".@$dataCusAdd->alley_Adds : ''). ' ' .
                  (@$dataCusAdd->road_Adds != NULL ? " ถนน ".@$dataCusAdd->road_Adds : ''). ' ' .
                  (@$dataCusAdd->houseTambon_Adds != NULL ? " ตำบล ".@$dataCusAdd->houseTambon_Adds : ''). ' ' .
                  (@$dataCusAdd->houseDistrict_Adds != NULL ? " อำเภอ ".@$dataCusAdd->houseDistrict_Adds : ''). ' ' .
                  (@$dataCusAdd->houseProvince_Adds != NULL ? " จังหวัด ". @$dataCusAdd->houseProvince_Adds : ''). ' ' .
                  (@$dataCusAdd->Postal_Adds != NULL ? " ".@$dataCusAdd->Postal_Adds : '') ;
        //  dump($dataCusAdd);
        @endphp

        <table border="0" style="width: 100%" >
          <tbody>
            <tr align="center" >
              <td align="left ">
                {{$LoanCom->Company_Name.($LoanCom->Company_Branch == 0 ?' ( สำนักงานใหญ่ )' : ' ( สาขาที่'.sprintf("%05d",$LoanCom->Company_Branch). ')')}}<br/>
                {{ @$LoanCom->Company_Addr }} <br/>
                {{'โทร. 092-218-5555'}}
                {{ 'Tax-id : '.@$LoanCom->Company_Id }}
              </td>
              <td align="left"> <font  style="text-align: center;line-height: 30px; font-family: 'TFPimpakarn';  font-size:16pt; font-weight : bold;">สัญญากู้ยืม</font> </td>
            </tr>
            <tr align="right" >
              <td style="margin: 3cm;" colspan="2"><span class="fontBl">ทำที่ {{ $LoanCom->Company_Name }}</span> </td>
            </tr>
            <tr align="right">
              {{-- <td colspan="2"><span class="fontBl">{{ formatDateThaiLongPS($data->Date_con) }}</span></td> --}}
              <td colspan="2"><span class="fontBl">{{ formatDateThaiLongPS($data->Date_monetary) }}</span></td>

            </tr>
            <tr align="">
              <td   colspan="2"><span style="margin-left : 50px;">สัญญานี้ทำขึ้นระหว่าง <span class="fontBl">{{ $DataCus->Name_Cus }}</span> อายุ <span class="fontBl">{{ $CusAge->y }}</span> ปี อยู่บ้านเลขที่ {{ $cusAdd  }}
              โทรศัพท์ <span class="fontBl">{{ formatPhone(@$DataCus->Phone_cus) }}</span> ซึ่งต่อไปในสัญญานี้จะเรียกว่า “ผู้กู้” ฝ่ายหนึ่ง กับ <span class="fontBl">{{ $LoanCom->Company_Name }}</span>
              อยู่บ้านเลขที่ {{ @$LoanCom->Company_Addr }}
              โทรศัพท์ {{ @$LoanCom->Company_Tel }} ซึ่งต่อไปในสัญญานี้จะเรียกว่า “ผู้ให้กู้” อีกฝ่ายหนึ่ง คู่สัญญาทั้งสองฝ่ายได้ตกลงกันดังต่อไปนี้</span></td>
            </tr>
            <tr align="" style="text-indent: 70px;">
              <td   style="margin: 3cm"  colspan="2">ข้อ 1.  ผู้ให้กู้ตกลงให้กู้ และผู้กู้ตกลงกู้เงินจากผู้ให้กู้เป็นเงินจำนวน  <span class="fontBl"> @if( @$data->ContractToCal->Buy_PA == "Yes" && @$data->ContractToCal->Include_PA == "Yes" )
                {{-- ซื้อประกัน และ รวมประกันในยอดจัด --}}
                {{number_format((floatval(@$data->ContractToCal->Cash_Car)+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance)+floatval(@$data->ContractToCal->Insurance_PA)),2)}}
              @elseif( @$data->ContractToCal->Buy_PA == "Yes" && @$data->ContractToCal->Include_PA == "No" )
                {{-- ซื้อประกัน และ ไม่รวมประกันในยอดจัด --}}
                {{number_format((floatval(@$data->ContractToCal->Cash_Car)+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance)),2)}}
              @else
                {{-- ไม่เข้าเงื่อนไขเลย เป็นค่าเริ่มต้น --}}
                {{number_format((floatval(@$data->ContractToCal->Cash_Car)+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance)+floatval(@$data->ContractToCal->Insurance_PA)),2)}}
              @endif</span> บาท
            ({{ IntconvertThai((floatval(@$data->ContractToCal->Cash_Car)+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance)+floatval(@$data->ContractToCal->Insurance_PA))) }}) </td>
            </tr>
            {{-- <tr align="">
              <td  colspan="2" >โดยผู้กู้ได้รับเงินที่กู้ไว้ครบถ้วนแล้วในวันทำสัญญานี้โดยรับเป็นเงินสด/เช็คของธนาคาร........................................................สาขา....................................เช็คเลขที่.........................</td>
            </tr>
            <tr align="">
              <td   colspan="2">ลงวันที่ <span class="fontBl">{{$data->Date_monetary}}</span> จำนวนเงิน <span class="fontBl">{{ number_format(@$ConOperateFee->Balance_Price,2) }}</span> บาท  ( <span class="fontBl">{{ IntconvertThai(@$ConOperateFee->Balance_Price) }}</span> )</td>
            </tr> --}}
            <tr align="">
              <td  colspan="2"   style="text-indent: 70px;">ข้อ 2.  ผู้กู้ตกลงที่จะชำระดอกเบี้ยแก่ผู้ให้กู้ในอัตราดอกเบี้ยร้อยละ <span class="fontBl">{{ number_format((@$ConFinance->totalInterest_Car*12),2) }}%</span> ต่อปี</td>
            </tr>
            <tr align="">
              <td   colspan="2" style="text-indent: 70px;">ข้อ 3. ผู้กู้ตกลงว่าจะชำระเงินต้นพร้อมดอกเบี้ยโดยผ่อนชำระเป็นงวดๆ จำนวน <span class="fontBl">{{ $ConFinance->Timelack_Car }}</span> งวด
                  เป็นเงินงวดละ <span class="fontBl">{{ number_format(@$ConFinance->Period_Rate,0) }}</span> บาท <br>( <span class="fontBl">{{ IntconvertThai(@$ConFinance->Period_Rate) }}</span> )  งวดแรกเริ่มชำระใน <span class="fontBl" style="{{ $data->DateDue_Con == NULL ? 'color: rgb(255, 255, 255); margin : 5px;' : 'color: black; margin : 5px;' }}">{{ formatDateThaiLongPS($data->DateDue_Con) }}</span>
             และงวดต่อไป <br> ทุกๆวันที่ <span class="fontBl" style="{{ $data->DateDue_Con == NULL ? 'color: rgb(255, 255, 255);' : 'color: black; margin : 5px;' }}">{{ @$data->DateDue_Con != NULL ? date_format(date_create(@$data->DateDue_Con),'d') : '1234' }}</span> ของเดือนถัดไป จนกว่าจะครบถ้วน </td>
            </tr>
            <tr align="">
              <td    colspan="2"><span style="margin-left : 50px;">ข้อ 4. กรณีมีการค้างชำระ ผู้ให้กู้จะนำค่างวดดังกล่าวไปหักกับค่าเบี้ยปรับ ค่าใช้จ่ายต่างๆและเงินจำนวนอื่นใดที่ผู้ให้กู้ต้องเสียไปในการทวงถามให้ชำระค่างวดก่อน จึงจะนำเงินส่วนที่เหลือชำระเป็นค่างวด</span> </td>
            </tr>
            <tr align="">
              <td   colspan="2" ><span style="margin-left : 50px;">ข้อ 5. ผู้กู้สัญญาว่า หากผู้กู้ย้ายภูมิลำเนาจากที่ระบุไว้ในสัญญานี้ ผู้กู้จะแจ้งที่อยู่ใหม่ให้ผู้ให้กู้ทราบเป็นหนังสือ ถ้ามิได้แจ้งผู้กู้ตกลงให้ ถือการบอกกล่าวหรือการแจ้งเป็นหนังสือที่เกี่ยวสัญญานี้ไปยังที่อยู่ตามที่ระบุไว้เป็นที่อยู่ของผู้กู้ข้างต้นนี้เป็นภูมิลำเนาของผู้กู้</span> </td>
            </tr>
            <tr align="">
              <td style="max-width :540px;"  colspan="2">
                <span style="margin-left : 50px;">ข้อ 6. หากผู้กู้ผิดข้อตกลงข้อใดข้อหนึ่งแห่งสัญญานี้ผู้กู้ยินยอมรับผิดชดใช้ค่าเสียหายบรรดาที่ผู้ให้กู้จะพึงได้รับอันเนื่องจาก การผิดข้อตกลงดังกล่าว รวมทั้งค่าใช้จ่ายในการแจ้งเตือนให้ชำระหนี้ทวงถามให้ชำระหนี้ตลอดจนค่าฤชาธรรมเนียมค่าทนายความและ ค่าใช้จ่ายในการดำเนินคดีให้ชำระหนี้ตามสัญญานี้ ให้แก่ผู้ให้กู้ด้วย</span>
              </td>
            </tr>
            <tr align="">
              @php
                  $detailAsset = '';
                   if($data->ContractToIndentureAsset2!=NULL && count($data->ContractToIndentureAsset2)>0){
                      foreach ($data->ContractToIndentureAsset2 as $key => $value) {
                        $asset = $value->IndenAssetToDataOwner->OwnershipToAsset;
                        $detailAsset .= $asset->DataAssetToLandType->nametype_car.' เลขที่ '.$asset->Land_Id .' ตำบล '.$asset->Land_Tambon.' อำเภอ '.$asset->Land_District.' จังหวัด '.$asset->Land_Province.', ';
                      }
                   }
              @endphp
              <td   colspan="2"><span style="margin-left : 50px;">ข้อ 7. เพื่อเป็นหลักประกันการชำระหนี้ตามสัญญานี้ ผู้กู้ได้นำ  <span class="fontBl">{{$detailAsset}}</span> ให้ผู้ให้กู้ยึดถือไว้เป็นประกันจนกว่าผู้ให้กู้จะได้รับชำระหนี้ตาม สัญญานี้จนเต็มจำนวน ซึ่งผู้กู้ขอรับรองว่าทรัพย์สินที่นำมาวางเป็นประกัน เป็นกรรมสิทธิ์โดยชอบด้วยกฎหมายแต่เพียงผู้เดียวของผู้กู้ และเป็นทรัพย์สิน ที่ปราศจากภาระติดพันใดๆ</span></td>
            </tr>
            <tr align="">
              <td   colspan="2"><span style="margin-left : 50px;">สัญญานี้ได้ทำขึ้นเป็นสองฉบับ  มีข้อความถูกต้องตรงกันให้คู่สัญญายึดถือไว้ฝ่ายละหนึ่งฉบับ คู่สัญญาได้อ่านและเข้าใจข้อความในสัญญานี้โดยตลอดแล้ว และได้รับสำเนาสัญญาไป 1 ฉบับแล้ว จึงลงลายมือชื่อไว้เป็นหลักฐาน</span></td>
            </tr>
            <tr >
              <td  align="center" ><br/><span style="align:'center'">ลงชื่อ………………………………….ผู้ให้กู้  </span>
                  <br/><span style="align:'center'">( {{ $LoanCom->Company_Name }} )</span></td>
              <td align="center" ><br/><span style="align:'center'">ลงชื่อ………………………………….ผู้กู้  </span>
                <br/><span style="align:'center'"> ( {{ $DataCus->Name_Cus }} )</span></td>
            </tr>
            <tr >
              <td  align="center" ><br/><span style="align:'center'">ลงชื่อ………………………………….ผู้กู้    </span>
                  <br/><span style="align:'center'">(.............................................)</span></td>
              <td align="center" ><br/><span style="align:'center'">ลงชื่อ………………………………….ผู้กู้  </span>
                <br/><span style="align:'center'"> (.............................................)</span></td>
            </tr>
            <tr >
              <td  align="center" ><br/><span style="align:'center'">ลงชื่อ………………………………….พยาน  </span>
                  <br/><span style="align:'center'"> (.............................................)</span></td>
              <td align="center" ><br/><span style="align:'center'">ลงชื่อ………………………………….พยาน  </span>
                <br/><span style="align:'center'">  (.............................................)</span></td>
            </tr>
          </tbody>
        </table>
    </body>
</html>
