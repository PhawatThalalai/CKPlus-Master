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
        font-size:14pt;
      }

      html {
        margin: 40px ;
      }
  </style>

      <body class="body">
        @php
          $DataCusCon = $data->ContractToCus; // ลูกค้า
          $DataCus = $guard->GuarantorToGuarantorCus; // ลูกค้า
          $LoanCom = $data->ContractToComOne; // บริษัท
          $dataCusAdd =  $guard->GuarantorToGuarantorCus->DataCusToDataCusAdds; // ที่อยู่ที่ใช้ในการทำสัญญา
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
              <td align="left "> </td>
              <td align="left"> </td>
            </tr>
            <tr align="right"  >
              <td style="height: 3.8cm" colspan="2"></td>
            </tr>
            <tr align=""style="height:0.5cm">
              <?php
                // $dateCon = explode(" ",formatDateThaiLongPS($data->Date_con));
                $dateCon = explode(" ",formatDateThaiLongPS($data->Date_monetary));
              ?>

              <td colspan="2"><span class="fontBl" style="margin-left : 520px;">{{$dateCon[0]}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$dateCon[1]}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$dateCon[2] }}</span></td>
            </tr>
            <tr align="" style="line-height:0.4cm">
              <td   colspan="2"><span > <span class="fontBl" style="margin-left : 170px;">{{ $DataCus->Name_Cus }}</span> <span class="fontBl" style="margin-left : 220px;">{{ $CusAge->y }}</span><span class="fontBl" style="margin-left : 80px;">{{(@$dataCusAdd->houseNumber_Adds != NULL ? @$dataCusAdd->houseNumber_Adds : ''). ' ' .
                (@$dataCusAdd->houseGroup_Adds != NULL ? " หมู่ ".@$dataCusAdd->houseGroup_Adds : '')}}</span>
                <br/> <span class="fontBl" style="margin-left : 350px;">{{ (@$dataCusAdd->houseTambon_Adds != NULL ? @$dataCusAdd->houseTambon_Adds : '')  }}</span>
                <span class="fontBl" style="margin-left : 150px;">{{ (@$dataCusAdd->houseDistrict_Adds != NULL ? @$dataCusAdd->houseDistrict_Adds : '')  }}</span>
                <br/><span class="fontBl" style="margin-left : 50px;">{{ (@$dataCusAdd->houseProvince_Adds != NULL ?  @$dataCusAdd->houseProvince_Adds : '') }}</span>
                <span class="fontBl" style="margin-left : 150px;">{{ formatPhone(@$DataCus->Phone_cus) }}</span> </td>
            </tr>
            <tr align="" >
              <td colspan="2"style="height: 3.8cm"><span class="fontBl" style="margin: 10cm"> @if( @$data->ContractToCal->Buy_PA == "Yes" && @$data->ContractToCal->Include_PA == "Yes" )
                {{-- ซื้อประกัน และ รวมประกันในยอดจัด --}}
                {{number_format((floatval(@$data->ContractToCal->Cash_Car)+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance)+floatval(@$data->ContractToCal->Insurance_PA)),2)}}
              @elseif( @$data->ContractToCal->Buy_PA == "Yes" && @$data->ContractToCal->Include_PA == "No" )
                {{-- ซื้อประกัน และ ไม่รวมประกันในยอดจัด --}}
                {{number_format((floatval(@$data->ContractToCal->Cash_Car)+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance)),2)}}
              @else
                {{-- ไม่เข้าเงื่อนไขเลย เป็นค่าเริ่มต้น --}}
                {{number_format((floatval(@$data->ContractToCal->Cash_Car)+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance)+floatval(@$data->ContractToCal->Insurance_PA)),2)}}
              @endif</span>
              <span class="fontBl" style="margin: 1cm">{{ IntconvertThai((floatval(@$data->ContractToCal->Cash_Car)+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance)+floatval(@$data->ContractToCal->Insurance_PA))) }}</span> </td>
            </tr>
            {{-- <tr align="">
              <td  colspan="2" >โดยผู้กู้ได้รับเงินที่กู้ไว้ครบถ้วนแล้วในวันทำสัญญานี้โดยรับเป็นเงินสด/เช็คของธนาคาร........................................................สาขา....................................เช็คเลขที่.........................</td>
            </tr>
            <tr align="">
              <td   colspan="2">ลงวันที่ <span class="fontBl">{{$data->Date_monetary}}</span> จำนวนเงิน <span class="fontBl">{{ number_format(@$ConOperateFee->Balance_Price,2) }}</span> บาท  ( <span class="fontBl">{{ IntconvertThai(@$ConOperateFee->Balance_Price) }}</span> )</td>
            </tr> --}}

            <tr align="" >
              <td  colspan="2"   style="text-indent: 70px;"><span class="fontBl" style="margin-left : 330px;">{{ number_format((@$ConFinance->totalInterest_Car*12),2) }}%</span> </td>
            </tr>
            <tr align="" style="line-height:0.4cm">
              <td colspan="2" style="text-indent: 70px;"><span class="fontBl" style="margin-left : 380px;">{{ $ConFinance->Timelack_Car }}</span>
                   <span class="fontBl" style="margin-left : 150px;">{{ number_format(@$ConFinance->Period_Rate,0) }}</span>  <br>
                   <span class="fontBl" style="margin-left : 100px;" >{{ IntconvertThai(@$ConFinance->Period_Rate) }}</span>
                   <span class="fontBl" style="margin-left : 290px;">{{ formatDateThaiLongPS($data->DateDue_Con) }}</span>
                <br> <span class="fontBl"  style="margin-left : 120px;">{{ @$data->DateDue_Con != NULL ? date_format(date_create(@$data->DateDue_Con),'d') : ' 111' }}</span> </td>
            </tr>
            <tr align="">
              <td  colspan="2" style="height: 5cm"><span style="margin-left : 50px;"><br/></span> </td>
            </tr>

            <tr align="" style="line-height:0.4cm">
              @php
                  $detailAsset = '';
                  $Land_Id = '';
                  $Land_Tambon = '';
                  $Land_District = '';
                  $Land_Province = '';
                   if($data->ContractToIndentureAsset2!=NULL && count($data->ContractToIndentureAsset2)>0){
                      foreach ($data->ContractToIndentureAsset2 as $key => $value) {
                        $asset = $value->IndenAssetToDataOwner->OwnershipToAsset;
                        $Land_Id .= $asset->Land_Id.',';
                        $Land_Tambon = $asset->Land_Tambon;
                        $Land_District = $asset->Land_District;
                         $Land_Province = $asset->Land_Province;
                        $detailAsset .= $asset->DataAssetToLandType->nametype_car.' เลขที่ '.$asset->Land_Id .' ตำบล '.$asset->Land_Tambon.' อำเภอ '.$asset->Land_District.' จังหวัด '.$asset->Land_Province.', ';
                      }
                   }


              @endphp
              <td   colspan="2" ><span class="fontBl" style="margin-left : 480px;">{{$Land_Id}} </span>
                <span class="fontBl" style="margin-left : 80px;">{{$Land_Tambon}}</span><br/>
                <span class="fontBl" style="margin-left : 80px;"> อ.{{$Land_District}}  จ.{{$Land_Province}} </span>
              </td>
            </tr>
          </tbody>
        </table>
    </body>
</html>
