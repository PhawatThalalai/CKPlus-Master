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
        font-size:18pt;
      }
      .fontBl2{
        font-family: 'TFPimpakarn';
        font-weight: bolder;
        font-size:16pt;
      }

      html {
        margin: 40px ;
      }
  </style>

      <body class="body">
        @php
          $DataCus = $data->ContractToCus; // ลูกค้า
          $LoanCom = $data->ContractToComOne; // บริษัท
          $dataCusAdd =  $data->ContractToCus->DataCusToDataCusAddsMany->
                            filter(function ($item) {
                          return $item->Type_Adds=='ADR-0002';
                        })->first(); // ที่อยู่ที่ใช้ในการทำสัญญา
          $ConFinance = $data->ContractToCal; // ข้อมูลการจัด
          $ConOperateFee = $data->ContractToOperated; // รายละเอียดค่าใช้จ่าย

          $date1 = new DateTime($DataCus->Birthday_cus);
        //   $date2 = new DateTime( $data->Date_con);
          $date2 = new DateTime( $data->Date_monetary);

          $CusAge = $date1->diff($date2);

          $cusAdd = (@$dataCusAdd->houseNumber_Adds != NULL ? @$dataCusAdd->houseNumber_Adds : ''). ' ' .
                  (@$dataCusAdd->houseGroup_Adds != NULL ? " หมู่ ".@$dataCusAdd->houseGroup_Adds : ''). ' ' .
                  (@$dataCusAdd->building_Adds != NULL && strlen(@$dataCusAdd->building_Adds)>3? " อาคาร ".@$dataCusAdd->building_Adds : ''). ' ' .
                  (@$dataCusAdd->village_Adds != NULL && strlen(@$dataCusAdd->village_Adds)>3 ? " หมู่บ้าน ".@$dataCusAdd->village_Adds : ''). '<br/>' .
                  (@$dataCusAdd->roomNumber_Adds != NULL && strlen(@$dataCusAdd->roomNumber_Adds)>3 ? " เลขห้อง ". @$dataCusAdd->roomNumber_Adds : ''). ' ' .
                  (@$dataCusAdd->Floor_Adds != NULL && strlen(@$dataCusAdd->Floor_Adds)>3 ? " ชั้น ".@$dataCusAdd->Floor_Adds : ''). ' ' .
                  (@$dataCusAdd->alley_Adds != NULL && strlen(@$dataCusAdd->alley_Adds)>3 ? " ซอย ".@$dataCusAdd->alley_Adds : ''). ' ' .
                  (@$dataCusAdd->road_Adds != NULL  && strlen(@$dataCusAdd->road_Adds)>3 ? " ถนน ".@$dataCusAdd->road_Adds.'<br/>' : ''). '  ' .
                  (@$dataCusAdd->houseTambon_Adds != NULL ? " ตำบล ".@$dataCusAdd->houseTambon_Adds : ''). ' ' .
                  (@$dataCusAdd->houseDistrict_Adds != NULL ? " อำเภอ ".@$dataCusAdd->houseDistrict_Adds.'<br/>' : ''). '  ' .
                  (@$dataCusAdd->houseProvince_Adds != NULL ? " จังหวัด ". @$dataCusAdd->houseProvince_Adds.'<br/>' : ''). '  ' .
                  (@$dataCusAdd->Postal_Adds != NULL ? " ".@$dataCusAdd->Postal_Adds : '') ;

        @endphp

        <table border="0" style="width: 100%" >
          <tbody>
            <tr align="" >
              <td style="line-height: 6cm">&nbsp;</td>
              <td >

            </td>
            </tr>
            <tr align="">
              <td colspan="2"><span style="margin-left : 150px;" class="fontBl">
                       กรุณาส่ง {{ $DataCus->Name_Cus }} โทรศัพท์ {{ formatPhone(@$DataCus->Phone_cus) }}
              </span>
            </td>
            </tr>
            <tr align="" style="line-height: 0.5cm">
              <td style="width: 150px"></td>
              <td >
                    <span class="fontBl2">ที่อยู่ @php echo $cusAdd;  @endphp</span>
            </td>
            </tr>

          </tbody>
        </table>
    </body>
</html>
