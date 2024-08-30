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


                // $dateCon = explode(" ",formatDateThaiLongPS(@$data->Date_con));
                $dateCon = explode(" ",formatDateThaiLongPS($data->Date_monetary));

                $dateDue = explode(" ",formatDateThaiLongPS(@$data->DateDue_Con));
             @endphp

         <p style="position:absolute; left : 20px; right : 10px; top:70px;" class="fontBl">สัญญาเลขที่ {{ @$data->Contract_Con }} </p>
         <p style="position:absolute; left : 500px; right : 10px; top:80px;" class="fontBl">{{$dateCon[0]}}</p>
         <p style="position:absolute; left : 570px; right : 10px; top:80px;" class="fontBl">{{$dateCon[1]}}</p>
         <p style="position:absolute; left : 660px; right : 10px; top:80px;" class="fontBl">{{$dateCon[2]}}</p>



         <p style="position:absolute; left : 200px; right : 10px; top:110px;" class="fontBl">{{ @$DataCus->Name_Cus }} </p>
         <p style="position:absolute; left : 480px; right : 10px; top:110px;" class="fontBl">{{ @$CusAge->y }}</p>
         <p style="position:absolute; left : 600px; right : 10px; top:110px;" class="fontBl">{{(@$dataCusAdd->houseNumber_Adds != NULL ? @$dataCusAdd->houseNumber_Adds : ''). ' ' .
          (@$dataCusAdd->houseGroup_Adds != NULL ? " หมู่ ".@$dataCusAdd->houseGroup_Adds : '')}}</p>



          <p style="position:absolute; left : 370px; right : 10px; top:135px;" class="fontBl">{{ (@$dataCusAdd->houseTambon_Adds != NULL ? @$dataCusAdd->houseTambon_Adds : '')  }} </p>
          <p style="position:absolute; left : 600px; right : 10px; top:135px;" class="fontBl">{{ (@$dataCusAdd->houseDistrict_Adds != NULL ? @$dataCusAdd->houseDistrict_Adds : '')  }}</p>

          <p style="position:absolute; left : 80px; right : 10px; top:160px;" class="fontBl">{{ (@$dataCusAdd->houseProvince_Adds != NULL ?  @$dataCusAdd->houseProvince_Adds : '') }} </p>
          <p style="position:absolute; left : 250px; right : 10px; top:160px;" class="fontBl">{{ formatPhone(@$DataCus->Phone_cus) }}</p>
          <p style="position:absolute; left : 500px; right : 10px; top:160px;" class="fontBl">{{ textFormat(@$DataCus->IDCard_cus) }}</p>


          @php
          if( @$data->ContractToCal->Buy_PA == "yes" && @$data->ContractToCal->Include_PA == "yes" )
          {
            $totalPrice = (floatval(@$data->ContractToCal->Cash_Car)+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance)+floatval(@$data->ContractToCal->Insurance_PA));
          }
          elseif( @$data->ContractToCal->Buy_PA == "yes" && @$data->ContractToCal->Include_PA == "no" )
          {   $totalPrice =  (floatval(@$data->ContractToCal->Cash_Car)+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance));
          }
          else
          { $totalPrice = (floatval(@$data->ContractToCal->Cash_Car)+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance)+floatval(@$data->ContractToCal->Insurance_PA));
          }

      @endphp

          <p style="position:absolute; left : 500px; right : 10px; top:260px;" class="fontBl"> {{number_format($totalPrice,2)}} </p>
          <p style="position:absolute; left : 20px; right : 10px; top:280px;" class="fontBl">{{ IntconvertThai($totalPrice) }}</p>

          <p style="position:absolute; left : 400px; right : 10px; top:330px;" class="fontBl"> {{ number_format((@$ConFinance->totalInterest_Car*12),2) }}% </p>

          <p style="position:absolute; left : 460px; right : 10px; top:360px;" class="fontBl">{{ @$ConFinance->Timelack_Car }}</p>
          <p style="position:absolute; left : 620px; right : 10px; top:360px;" class="fontBl">{{ number_format(@$ConFinance->Period_Rate,0) }}</p>

          <p style="position:absolute; left : 100px; right : 10px; top:385px;" class="fontBl">{{ IntconvertThai(@$ConFinance->Period_Rate) }}</p>
          <p style="position:absolute; left : 490px; right : 10px; top:385px;" class="fontBl">{{$dateDue[0]}}</p>
          <p style="position:absolute; left : 550px; right : 10px; top:385px;" class="fontBl">{{$dateDue[1]}}</p>
          <p style="position:absolute; left : 640px; right : 10px; top:385px;" class="fontBl">{{$dateDue[2]}}</p>

          <p style="position:absolute; left : 150px; right : 10px; top:410px;" class="fontBl">{{ @$data->DateDue_Con != NULL ? date_format(date_create(@$data->DateDue_Con),'d') : ' 1 ' }}</p>

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
          <p style="position:absolute; left : 520px; right : 10px; top:620px;" class="fontBl">{{@$Land_Id}}</p>
          <p style="position:absolute; left : 20px; right : 10px; top:650px;" class="fontBl"> ต.{{@$Land_Tambon}} อ.{{@$Land_District}}  จ.{{@$Land_Province}} </p>



        {{-- <table border="1" style="width: 100%" >
          <tbody>
            <tr align="center" >
              <td align="left "> </td>
              <td align="left"> </td>
            </tr>
            <tr align="right"  >
              <td style="height: 2.2cm" colspan="2"></td>
            </tr>
            <tr align=""style="height:0.5cm">
              <td colspan=""><span class="fontBl" style="margin-left : 20px;">สัญญาเลขที่ {{ @$data->Contract_Con }}</span> </td>

                <td>
                  <span class="fontBl" style="">{{$dateCon[0]}}</span>
                  <span class="fontBl" style="">{{$dateCon[1]}}</span>
                  <span class="fontBl" style="">{{$dateCon[2] }}</span>
                </td>
            </tr>
            <tr align="" style="line-height:0.4cm">
              <td   colspan="2"><span > <span class="fontBl" style="margin-left : 190px;">{{ @$DataCus->Name_Cus }}</span>
                <span class="fontBl" style="margin-left : 160px;">{{ @$CusAge->y }}</span>
              <span class="fontBl" style="margin-left : 120px;">{{(@$dataCusAdd->houseNumber_Adds != NULL ? @$dataCusAdd->houseNumber_Adds : ''). ' ' .
                (@$dataCusAdd->houseGroup_Adds != NULL ? " หมู่ ".@$dataCusAdd->houseGroup_Adds : '')}}</span>
                <br/> <span class="fontBl" style="margin-left : 350px;">{{ (@$dataCusAdd->houseTambon_Adds != NULL ? @$dataCusAdd->houseTambon_Adds : '')  }}</span>
                <span class="fontBl" style="margin-left : 150px;">{{ (@$dataCusAdd->houseDistrict_Adds != NULL ? @$dataCusAdd->houseDistrict_Adds : '')  }}</span>
                <br/><span class="fontBl" style="margin-left : 70px;">{{ (@$dataCusAdd->houseProvince_Adds != NULL ?  @$dataCusAdd->houseProvince_Adds : '') }}</span>
                <span class="fontBl" style="margin-left : 150px;">{{ formatPhone(@$DataCus->Phone_cus) }}</span>
                <span class="fontBl" style="margin-left : 150px;">{{ textFormat(@$DataCus->IDCard_cus) }}</span>
              </td>
            </tr>
            <tr align="" >
              <td colspan="2"style="height: 1.5cm">
              </td>
            </tr>
            <tr align="" >
              <td colspan="2"style="height: 2.2cm">
                <span class="fontBl" style="margin-left :500px;" >
                @php
                  if( @$data->ContractToCal->Buy_PA == "yes" && @$data->ContractToCal->Include_PA == "yes" )
                  {
                    $totalPrice = (floatval(@$data->ContractToCal->Cash_Car)+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance)+floatval(@$data->ContractToCal->Insurance_PA));
                  }
                  elseif( @$data->ContractToCal->Buy_PA == "yes" && @$data->ContractToCal->Include_PA == "no" )
                  {   $totalPrice =  (floatval(@$data->ContractToCal->Cash_Car)+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance));
                  }
                  else
                  { $totalPrice = (floatval(@$data->ContractToCal->Cash_Car)+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance)+floatval(@$data->ContractToCal->Insurance_PA));
                  }

              @endphp
                    {{number_format($totalPrice,2)}}
              </span> <br/>
              <span class="fontBl" style="margin-left :30px;" >{{ IntconvertThai($totalPrice) }}</span> </td>
            </tr>


            <tr align="" >
              <td  colspan="2"   style="text-indent: 70px;"><span class="fontBl" style="margin-left : 330px;">{{ number_format((@$ConFinance->totalInterest_Car*12),2) }}%</span> </td>
            </tr>
            <tr align="" style="line-height:0.4cm">
              <td colspan="2" style="text-indent: 70px;"><span class="fontBl" style="margin-left : 390px;">{{ @$ConFinance->Timelack_Car }}</span>
                   <span class="fontBl" style="margin-left : 150px;">{{ number_format(@$ConFinance->Period_Rate,0) }}</span>  <br>
                   <span class="fontBl" style="margin-left : 100px;" >{{ IntconvertThai(@$ConFinance->Period_Rate) }}</span>
                   <span class="fontBl" style="margin-left : 250px;"> {{$dateDue[0]}}</span>
                  <span class="fontBl" style="margin-left : 40px;">{{$dateDue[1]}}</span>
                  <span class="fontBl" style="margin-left :40px;"> {{$dateDue[2] }}</span>
                  <br> <span class="fontBl"  style="margin-left : 150px;">{{ @$data->DateDue_Con != NULL ? date_format(date_create(@$data->DateDue_Con),'d') : ' ' }}</span> </td>
            </tr>
            <tr align="">
              <td  colspan="2" style="height: 4.7cm"><span style="margin-left : 50px;"><br/></span> </td>
            </tr>

            <tr align=""  style="line-height:0.4cm">
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
              <td   colspan="2" ><span class="fontBl" style="margin-left : 530px;">{{@$Land_Id}} </span>
             <br/>
                <span class="fontBl" style="margin-left : 10px;"> ต.{{@$Land_Tambon}} อ.{{@$Land_District}}  จ.{{@$Land_Province}} </span>
              </td>
            </tr>
          </tbody>
        </table> --}}
    </body>
</html>
