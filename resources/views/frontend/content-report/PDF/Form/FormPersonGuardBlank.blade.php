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
      .fontBlss{
        font-family: 'TFPimpakarn';
        font-weight: bolder;
        font-size:8pt;
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
          $date2 = new DateTime( $data->Date_monetary);
        //   $date2 = new DateTime( $data->Date_con);

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
               <?php
            //    $dateCon = explode(" ",formatDateThaiLongPS($data->Date_con));
               $dateCon = explode(" ",formatDateThaiLongPS($data->Date_monetary));

             ?>

      <p style="position:absolute; left : 530px; right : 10px; top:75px;" class="fontBls">{{$dateCon[0]}}</p>
      <p style="position:absolute; left : 580px; right : 10px; top:75px;" class="fontBls">{{$dateCon[1]}}</p>
      <p style="position:absolute; left : 670px; right : 10px; top:75px;" class="fontBls">{{$dateCon[2]}}</p>



      <p style="position:absolute; left : 200px; right : 10px; top:100px;" class="fontBls">{{ $DataCus->Firstname_Cus.' '.$DataCus->Surname_Cus }}</p>
      <p style="position:absolute; left : 410px; right : 10px; top:100px;" class="fontBls">{{ @$CusAge->y }}</p>
      <p style="position:absolute; left : 520px; right : 10px; top:100px;" class="fontBls">{{(@$dataCusAdd->houseNumber_Adds != NULL ? @$dataCusAdd->houseNumber_Adds : ''). ' ' .
      (@$dataCusAdd->houseGroup_Adds != NULL ? " หมู่ ".@$dataCusAdd->houseGroup_Adds : '')}}</p>


      <p style="position:absolute; left : 120px; right : 10px; top:120px;" class="fontBls">{{ (@$dataCusAdd->alley_Adds != NULL ? @$dataCusAdd->alley_Adds : ' - ')  }}</p>
      <p style="position:absolute; left : 210px; right : 10px; top:120px;" class="fontBls">{{ (@$dataCusAdd->road_Adds != NULL ? @$dataCusAdd->road_Adds : ' - ')  }}</p>
      <p style="position:absolute; left : 330px; right : 10px; top:120px;" class="fontBls">{{ (@$dataCusAdd->houseTambon_Adds != NULL ? @$dataCusAdd->houseTambon_Adds : '')  }} </p>
      <p style="position:absolute; left : 500px; right : 10px; top:120px;" class="fontBls">{{ (@$dataCusAdd->houseDistrict_Adds != NULL ? @$dataCusAdd->houseDistrict_Adds : '')  }}</p>

      <p style="position:absolute; left : 80px; right : 10px; top:140px;" class="fontBls">{{ (@$dataCusAdd->houseProvince_Adds != NULL ?  @$dataCusAdd->houseProvince_Adds : '') }} </p>
      <p style="position:absolute; left : 220px; right : 10px; top:140px;" class="fontBls">{{ formatPhone(@$DataCus->Phone_cus) }}</p>
      <p style="position:absolute; left : 420px; right : 10px; top:140px;" class="fontBls">{{ textFormat(@$DataCus->IDCard_cus) }}</p>


      <p style="position:absolute; left : 220px; right : 10px; top:200px;" class="fontBls">{{ $DataCusCon->Firstname_Cus.' '.$DataCusCon->Surname_Cus }}</p>
      <p style="position:absolute; left : 240px; right : 10px; top:220px;" class="fontBls">{{number_format((floatval(@$data->ContractToCal->Cash_Car)+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance)+floatval(@$data->ContractToCal->Insurance_PA)),2)}}</p>
      <p style="position:absolute; left : 380px; right : 10px; top:220px;" class="fontBls">{{ IntconvertThai((floatval(@$data->ContractToCal->Cash_Car)+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance)+floatval(@$data->ContractToCal->Insurance_PA))) }}</p>


      <p style="position:absolute; left : 150px; right : 10px; top:245px;" class="fontBls">{{ @$data->Contract_Con }}</p>
      <p style="position:absolute; left : 350px; right : 10px; top:245px;" class="fontBls">{{$dateCon[0]}}</p>
      <p style="position:absolute; left : 410px; right : 10px; top:245px;" class="fontBls">{{$dateCon[1]}}</p>
      <p style="position:absolute; left : 520px; right : 10px; top:245px;" class="fontBls">{{$dateCon[2]}}</p>


        {{-- <table border="0" style="width: 100%" >
          <tbody>
            <tr align="center" >
              <td align="left "> </td>
              <td align="left"> </td>
            </tr>
            <tr align="right"  >
              <td style="height: 2cm" colspan="2"></td>
            </tr>
            <tr align="" >

              <td colspan="2" >
                <span class="fontBlss" style="margin-left : 500px;">{{$dateCon[0]}}</span>
                <span class="fontBlss" style="margin-left : 40px;">{{$dateCon[1]}}</span>
                <span class="fontBlss" style="margin-left :40px;"> {{$dateCon[2] }}</span>
              </td>
            </tr>
            <tr align="" style="line-height:0.4cm">
              <td   colspan="2"><span > <span class="fontBlss" style="margin-left : 200px;">{{ $DataCus->Firstname_Cus.' '.$DataCus->Surname_Cus }}</span>
                <span class="fontBlss" style="margin-left : 180px;">{{ $CusAge->y }}</span>
                <span class="fontBlss" style="margin-left : 120px;">{{ (@$dataCusAdd->houseNumber_Adds != NULL ? @$dataCusAdd->houseNumber_Adds : '')  }} หมู่ {{ (@$dataCusAdd->houseGroup_Adds != NULL ? @$dataCusAdd->houseGroup_Adds : '')  }}</span>
                <br/>
                <span class="fontBlss" style="margin-left :100px;">{{ (@$dataCusAdd->alley_Adds != NULL ? @$dataCusAdd->alley_Adds : ' - ')  }}</span>
                <span class="fontBlss" style="margin-left : 100px;">{{ (@$dataCusAdd->road_Adds != NULL ? @$dataCusAdd->road_Adds : ' - ')  }}</span>
                <span class="fontBlss" style="margin-left : 150px;">{{ (@$dataCusAdd->houseTambon_Adds != NULL ? @$dataCusAdd->houseTambon_Adds : '')  }}</span>
                <span class="fontBlss" style="margin-left : 150px;">{{ (@$dataCusAdd->houseDistrict_Adds != NULL ? @$dataCusAdd->houseDistrict_Adds : '')  }}</span>
                 <br/>
                 <span class="fontBlss" style="margin-left :50px;">{{ (@$dataCusAdd->houseProvince_Adds != NULL ?  @$dataCusAdd->houseProvince_Adds : '')  }}</span>
                 <span class="fontBlss" style="margin-left : 140px;">{{ formatPhone(@$DataCus->Phone_cus) }}</span>
                 <span class="fontBlss" style="margin-left : 200px;">{{ textFormat(@$DataCus->IDCard_cus) }}</span> </td>
            </tr>
            <tr align=""  >
              <td  colspan="2"   style="height: 2cm;text-indent: 70px;"></td>
            </tr>

            <tr align="" >
              <td colspan="2" style="line-height: 0.4cm" >
                <span class="fontBlss" style="margin-left :250px;">{{ $DataCusCon->Firstname_Cus.' '.$DataCusCon->Surname_Cus }}</span>
                <br/>
                <span class="fontBlss" style="margin-left : 250px;"> @if( @$data->ContractToCal->Buy_PA == "Yes" && @$data->ContractToCal->Include_PA == "Yes" )
                {{-- ซื้อประกัน และ รวมประกันในยอดจัด --}}
                {{-- {{number_format((floatval(@$data->ContractToCal->Cash_Car)+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance)+floatval(@$data->ContractToCal->Insurance_PA)),2)}}
              @elseif( @$data->ContractToCal->Buy_PA == "Yes" && @$data->ContractToCal->Include_PA == "No" ) --}}
                {{-- ซื้อประกัน และ ไม่รวมประกันในยอดจัด --}}
                {{-- {{number_format((floatval(@$data->ContractToCal->Cash_Car)+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance)),2)}}
              @else --}}
                {{-- ไม่เข้าเงื่อนไขเลย เป็นค่าเริ่มต้น --}}
                {{-- {{number_format((floatval(@$data->ContractToCal->Cash_Car)+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance)+floatval(@$data->ContractToCal->Insurance_PA)),2)}}
              @endif</span>  --}}
              {{-- <span class="fontBlss"style="margin-left : 100px;">{{ IntconvertThai((floatval(@$data->ContractToCal->Cash_Car)+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance)+floatval(@$data->ContractToCal->Insurance_PA))) }}</span>
             <br/>
                   <span class="fontBlss" style="margin-left:150px;">{{ @$data->Contract_Con }}</span>
                   <span class="fontBlss"  style="margin-left : 150px;"> {{$dateCon[0]}}</span>
                   <span class="fontBlss" style="margin-left : 40px;">{{$dateCon[1]}}</span>
                   <span class="fontBlss" style="margin-left :70px;"> {{$dateCon[2] }}</span>

              </td>
            </tr>
            <tr align="">
              <td  colspan="2" style="height: 6cm"><span style="margin-left : 50px;"> </span> </td>
            </tr>
          </tbody> --}}
        {{-- </table>  --}}
    </body>
</html>
