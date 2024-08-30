<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>

    <style>
      @font-face {
           font-family: 'TFPimpakarn';
           font-style: normal;
           font-weight: normal;
           src: url({{ public_path ('fonts/TF Pimpakarn.ttf') }});
           /* src: url({{ asset('fonts/THSarabunNew.ttf') }}) format('truetype'); */
       }
       @font-face {
           font-family: 'TFPimpakarn';
           font-style: normal;
           font-weight: bold;
           src: url({{ public_path ('fonts/TF Pimpakarn Bol.ttf') }}) format('truetype');
       }
     td.container > div {
         width: 100%;
         height: 100%;
         overflow:hidden;
     }
     td.container {
         height: 10px;
     }
     body {
           font-family: "TFPimpakarn";
       }

   .page_break { page-break-before: always; }

   </style>

    <SCRIPT>
      function toggleOption(thisselect) {
          var selected = thisselect.options[thisselect.selectedIndex].value;
          toggleRow(selected);
      }

      function toggleRow(id) {
        var row = document.getElementById(id);
        if (row.style.display == '') {
          row.style.display = 'none';
        }
        else {
           row.style.display = '';
        }
      }

      function showRow(id) {
        var row = document.getElementById(id);
        row.style.display = '';
      }

      function hideRow(id) {
        var row = document.getElementById(id);
        row.style.display = 'none';
      }

      function hideAll() {
       hideRow('optionA');
       hideRow('optionB');
       hideRow('optionC');
       hideRow('optionD');
     }
    </SCRIPT>

  </head>
  <body>
    <table border="0" style="line-height: 5px">
      <tr >
        <td width="800px" align="center" >
          <h2 align="center" style="font-weight: bold;">รายงาน ตามยอดจัดรวม</h2>
        </td>
        <td width="200px" align="right">
          พิมพ์ : {{ date('d-m-Y') }}
        </td>
      </tr>
      <tr >
        <td width="800px" align="center">
         วันที่ {{formatDateThaiLong($Fdate)}} ถึง วันที่ {{formatDateThaiLong($Tdate)}}
        </td>
        <td width="200px" align="right">
          ผู้พิมพ์ : {{ auth()->user()->name }}
        </td>
      </tr>
  </table>
  <hr>
    <table border="1" style="line-height: 10px">
      <thead>
        <tr align="center">
          <th align="center" width="70px" style="background-color: #f4fdff;" rowspan="2"><b>ประเภทรถ</b></th>
          <th align="center" width="70px" style="background-color: #f4fdff;" rowspan="2"><b>ผู้แนะนำ</b></th>
          <th align="center" width="70px" style="background-color: #77e8fc;" colspan="2"><b>ปัตตานี</b></th>
          <th align="center" width="70px" style="background-color: #77e8fc;" colspan="2"><b>หาดใหญ่</b></th>
          <th align="center" width="70px" style="background-color: #77e8fc;" colspan="2"><b>นครศรี</b></th>
          <th align="center" width="70px" style="background-color: #77e8fc;" colspan="2"><b>กระบี่</b></th>
          <th align="center" width="70px" style="background-color: #77e8fc;" colspan="2"><b>สุราษฏร์</b></th>
          <th align="center" width="90px" style="background-color: #ffd105;"colspan="2"><b>รวม</b></th>
        </tr>
        <tr>
          <th align="center" width="35px" style="background-color: #77e8fc;" ><b>ชซ</b></th>
          <th align="center" width="35px" style="background-color: #77e8fc;" ><b>งก</b></th>
          <th align="center" width="35px" style="background-color: #77e8fc;" ><b>ชซ</b></th>
          <th align="center" width="35px" style="background-color: #77e8fc;" ><b>งก</b></th>
          <th align="center" width="35px" style="background-color: #77e8fc;" ><b>ชซ</b></th>
          <th align="center" width="35px" style="background-color: #77e8fc;" ><b>งก</b></th>
          <th align="center" width="35px" style="background-color: #77e8fc;" ><b>ชซ</b></th>
          <th align="center" width="35px" style="background-color: #77e8fc;" ><b>งก</b></th>
          <th align="center" width="35px" style="background-color: #77e8fc;" ><b>ชซ</b></th>
          <th align="center" width="35px" style="background-color: #77e8fc;" ><b>งก</b></th>
          <th align="center" width="35px" style="background-color: #ffd105;" ><b>ชซ</b></th>
          <th align="center" width="35px" style="background-color: #ffd105;" ><b>งก</b></th>
        </tr>
      </thead>
      <tbody>
        <tr align="center">
          <td width="" rowspan="2" style="background-color: #ffd105">
            กรรมสิทธิ์
          </td>
          <td width="">มีผู้แนะนำ</td>
          <td width="">
            @php
              $count01 = 0;
              $count01 = @$DatanotNull['รถกรรมสิทธิ์'][0] + @$DatanotNull['ที่ดิน'][0];
            @endphp
            {{@$count01}}
          </td>
          <td width="">
            @php
              $count06 = 0;
              $count06 = @$DatanotNull['รถกรรมสิทธิ์'][6] + @$DatanotNull['ที่ดิน'][6];
            @endphp
            {{@$count06}}
          </td>
          <td width="">
            @php
              $count02 = 0;
              $count02 = @$DatanotNull['รถกรรมสิทธิ์'][1] + @$DatanotNull['ที่ดิน'][1];
            @endphp
            {{@$count02}}
          </td>
          <td width="">
            @php
              $count07 = 0;
              $count07 = @$DatanotNull['รถกรรมสิทธิ์'][7] + @$DatanotNull['ที่ดิน'][7];
            @endphp
            {{@$count07}}
          </td>
          <td width="">
            @php
              $count03 = 0;
              $count03 = @$DatanotNull['รถกรรมสิทธิ์'][2] + @$DatanotNull['ที่ดิน'][2];
            @endphp
            {{@$count03}}
          </td>
          <td width="">
            @php
              $count08 = 0;
              $count08 = @$DatanotNull['รถกรรมสิทธิ์'][8] + @$DatanotNull['ที่ดิน'][8];
            @endphp
            {{@$count08}}
          </td>
          <td width="">
            @php
              $count04 = 0;
              $count04 = @$DatanotNull['รถกรรมสิทธิ์'][3] + @$DatanotNull['ที่ดิน'][3];
            @endphp
            {{@$count04}}
          </td>
          <td width="">
            @php
              $count09 = 0;
              $count09 = @$DatanotNull['รถกรรมสิทธิ์'][9] + @$DatanotNull['ที่ดิน'][9];
            @endphp
            {{@$count09}}
          </td>
          <td width="">
            @php
              $count05 = 0;
              $count05 = @$DatanotNull['รถกรรมสิทธิ์'][4] + @$DatanotNull['ที่ดิน'][4];
            @endphp
            {{@$count05}}
          </td>
          <td width="">
            @php
              $count10 = 0;
              $count10 = @$DatanotNull['รถกรรมสิทธิ์'][10] + @$DatanotNull['ที่ดิน'][10];
            @endphp
            {{@$count10}}
          </td>
          <td width="" style="background-color: #ffd105;">
            @php
              $countSum = 0;
              $countSum = @$DatanotNull['รถกรรมสิทธิ์'][5] + @$DatanotNull['ที่ดิน'][5];
            @endphp
            {{@$countSum}}
          </td>
          <td width="" style="background-color: #ffd105;">
            @php
              $countSum2 = 0;
              $countSum2 = @$DatanotNull['รถกรรมสิทธิ์'][11] + @$DatanotNull['ที่ดิน'][11];
            @endphp
            {{@$countSum2}}
          </td>
        </tr>
        <tr align="center" >
          <td width="">ไม่มีผู้แนะนำ</td>
          <td width="">
            @php
              $count06 = 0;
              $count06 = @$DataisNull['รถกรรมสิทธิ์'][0] + @$DataisNull['ที่ดิน'][0];
            @endphp
            {{@$count06}}
          </td>
          <td width="">
            @php
              $count26 = 0;
              $count26 = @$DataisNull['รถกรรมสิทธิ์'][6] + @$DataisNull['ที่ดิน'][6];
            @endphp
            {{@$count26}}
          </td>
          <td width="">
            @php
              $count07 = 0;
              $count07 = @$DataisNull['รถกรรมสิทธิ์'][1] + @$DataisNull['ที่ดิน'][1];
            @endphp
            {{@$count07}}
          </td>
          <td width="">
            @php
              $count27 = 0;
              $count27 = @$DataisNull['รถกรรมสิทธิ์'][7] + @$DataisNull['ที่ดิน'][7];
            @endphp
            {{@$count27}}
          </td>
          <td width="">
            @php
              $count08 = 0;
              $count08 = @$DataisNull['รถกรรมสิทธิ์'][2] + @$DataisNull['ที่ดิน'][2];
            @endphp
            {{@$count08}}
          </td>
          <td width="">
            @php
              $count28 = 0;
              $count28 = @$DataisNull['รถกรรมสิทธิ์'][8] + @$DataisNull['ที่ดิน'][8];
            @endphp
            {{@$count28}}
          </td>
          <td width="">
            @php
              $count09 = 0;
              $count09 = @$DataisNull['รถกรรมสิทธิ์'][3] + @$DataisNull['ที่ดิน'][3];
            @endphp
            {{@$count09}}
          </td>
          <td width="">
            @php
              $count29 = 0;
              $count29 = @$DataisNull['รถกรรมสิทธิ์'][9] + @$DataisNull['ที่ดิน'][9];
            @endphp
            {{@$count29}}
          </td>
          <td width="">
            @php
              $count10 = 0;
              $count10 = @$DataisNull['รถกรรมสิทธิ์'][4] + @$DataisNull['ที่ดิน'][4];
            @endphp
            {{@$count10}}
          </td>
          <td width="">
            @php
              $count30 = 0;
              $count30 = @$DataisNull['รถกรรมสิทธิ์'][10] + @$DataisNull['ที่ดิน'][10];
            @endphp
            {{@$count30}}
          </td>
          <td width="" style="background-color: #ffd105;">
            @php
              $countSum02 = 0;
              $countSum02 = @$DataisNull['รถกรรมสิทธิ์'][5] + @$DataisNull['ที่ดิน'][5];
            @endphp
            {{@$countSum02}}
          </td>
          <td width="" style="background-color: #ffd105;">
            @php
              $countSum20 = 0;
              $countSum20 = @$DataisNull['รถกรรมสิทธิ์'][11] + @$DataisNull['ที่ดิน'][11];
            @endphp
            {{@$countSum20}}
          </td>
        </tr>
        <tr align="center">
          <td width="" rowspan="2" style="background-color: #ffd105">
            ซื้อขาย
          </td>
          <td width="">มีผู้แนะนำ</td>
          <td width="">{{(@$DatanotNull['รถซื้อขาย'][0] != NULL)?@$DatanotNull['รถซื้อขาย'][0] :0}}</td>
          <td width="">{{(@$DatanotNull['รถซื้อขาย'][6] != NULL)?@$DatanotNull['รถซื้อขาย'][6] :0}}</td>
          <td width="">{{(@$DatanotNull['รถซื้อขาย'][1] != NULL)?@$DatanotNull['รถซื้อขาย'][1] :0}}</td>
          <td width="">{{(@$DatanotNull['รถซื้อขาย'][7] != NULL)?@$DatanotNull['รถซื้อขาย'][7] :0}}</td>
          <td width="">{{(@$DatanotNull['รถซื้อขาย'][2] != NULL)?@$DatanotNull['รถซื้อขาย'][2] :0}}</td>
          <td width="">{{(@$DatanotNull['รถซื้อขาย'][8] != NULL)?@$DatanotNull['รถซื้อขาย'][8] :0}}</td>
          <td width="">{{(@$DatanotNull['รถซื้อขาย'][3] != NULL)?@$DatanotNull['รถซื้อขาย'][3] :0}}</td>
          <td width="">{{(@$DatanotNull['รถซื้อขาย'][9] != NULL)?@$DatanotNull['รถซื้อขาย'][9] :0}}</td>
          <td width="">{{(@$DatanotNull['รถซื้อขาย'][4] != NULL)?@$DatanotNull['รถซื้อขาย'][4] :0}}</td>
          <td width="">{{(@$DatanotNull['รถซื้อขาย'][10] != NULL)?@$DatanotNull['รถซื้อขาย'][10] :0}}</td>
          <td width="" style="background-color: #ffd105;">{{(@$DatanotNull['รถซื้อขาย'][5] != NULL)?@$DatanotNull['รถซื้อขาย'][5] :0}}</td>
          <td width="" style="background-color: #ffd105;">{{(@$DatanotNull['รถซื้อขาย'][11] != NULL)?@$DatanotNull['รถซื้อขาย'][11] :0}}</td>
        </tr>
        <tr align="center" >
          <td width="">ไม่มีผู้แนะนำ</td>
          <td width="">{{(@$DataisNull['รถซื้อขาย'][0] != NULL)?@$DataisNull['รถซื้อขาย'][0] :0}}</td>
          <td width="">{{(@$DataisNull['รถซื้อขาย'][6] != NULL)?@$DataisNull['รถซื้อขาย'][6] :0}}</td>
          <td width="">{{(@$DataisNull['รถซื้อขาย'][1] != NULL)?@$DataisNull['รถซื้อขาย'][1] :0}}</td>
          <td width="">{{(@$DataisNull['รถซื้อขาย'][7] != NULL)?@$DataisNull['รถซื้อขาย'][7] :0}}</td>
          <td width="">{{(@$DataisNull['รถซื้อขาย'][2] != NULL)?@$DataisNull['รถซื้อขาย'][2] :0}}</td>
          <td width="">{{(@$DataisNull['รถซื้อขาย'][8] != NULL)?@$DataisNull['รถซื้อขาย'][8] :0}}</td>
          <td width="">{{(@$DataisNull['รถซื้อขาย'][3] != NULL)?@$DataisNull['รถซื้อขาย'][3] :0}}</td>
          <td width="">{{(@$DataisNull['รถซื้อขาย'][9] != NULL)?@$DataisNull['รถซื้อขาย'][9] :0}}</td>
          <td width="">{{(@$DataisNull['รถซื้อขาย'][4] != NULL)?@$DataisNull['รถซื้อขาย'][4] :0}}</td>
          <td width="">{{(@$DataisNull['รถซื้อขาย'][10] != NULL)?@$DataisNull['รถซื้อขาย'][10] :0}}</td>
          <td width="" style="background-color: #ffd105;">{{(@$DataisNull['รถซื้อขาย'][5] != NULL)?@$DataisNull['รถซื้อขาย'][5] :0}}</td>
          <td width="" style="background-color: #ffd105;">{{(@$DataisNull['รถซื้อขาย'][11] != NULL)?@$DataisNull['รถซื้อขาย'][11] :0}}</td>
        </tr>
        <tr align="center" >
          <td width="" rowspan="2" style="background-color: #ffd105">
            รถรีไฟแนนซ์
          </td>
          <td width="">มีผู้แนะนำ</td>
          <td width="">{{(@$DatanotNull['รถรีไฟแนนซ์'][0] != NULL)?@$DatanotNull['รถรีไฟแนนซ์'][0] :0}}</td>
          <td width="">{{(@$DatanotNull['รถรีไฟแนนซ์'][6] != NULL)?@$DatanotNull['รถรีไฟแนนซ์'][6] :0}}</td>
          <td width="">{{(@$DatanotNull['รถรีไฟแนนซ์'][1] != NULL)?@$DatanotNull['รถรีไฟแนนซ์'][1] :0}}</td>
          <td width="">{{(@$DatanotNull['รถรีไฟแนนซ์'][7] != NULL)?@$DatanotNull['รถรีไฟแนนซ์'][7] :0}}</td>
          <td width="">{{(@$DatanotNull['รถรีไฟแนนซ์'][2] != NULL)?@$DatanotNull['รถรีไฟแนนซ์'][2] :0}}</td>
          <td width="">{{(@$DatanotNull['รถรีไฟแนนซ์'][8] != NULL)?@$DatanotNull['รถรีไฟแนนซ์'][8] :0}}</td>
          <td width="">{{(@$DatanotNull['รถรีไฟแนนซ์'][3] != NULL)?@$DatanotNull['รถรีไฟแนนซ์'][3] :0}}</td>
          <td width="">{{(@$DatanotNull['รถรีไฟแนนซ์'][9] != NULL)?@$DatanotNull['รถรีไฟแนนซ์'][9] :0}}</td>
          <td width="">{{(@$DatanotNull['รถรีไฟแนนซ์'][4] != NULL)?@$DatanotNull['รถรีไฟแนนซ์'][4] :0}}</td>
          <td width="">{{(@$DatanotNull['รถรีไฟแนนซ์'][10] != NULL)?@$DatanotNull['รถรีไฟแนนซ์'][10] :0}}</td>
          <td width="" style="background-color: #ffd105;">{{(@$DatanotNull['รถรีไฟแนนซ์'][5] != NULL)?@$DatanotNull['รถรีไฟแนนซ์'][5] :0}}</td>
          <td width="" style="background-color: #ffd105;">{{(@$DatanotNull['รถรีไฟแนนซ์'][11] != NULL)?@$DatanotNull['รถรีไฟแนนซ์'][11] :0}}</td>

        </tr>
        <tr align="center" >
          <td width="">ไม่มีผู้แนะนำ</td>
          <td width="">{{(@$DataisNull['รถรีไฟแนนซ์'][0] != NULL)?@$DataisNull['รถรีไฟแนนซ์'][0] :0}}</td>
          <td width="">{{(@$DataisNull['รถรีไฟแนนซ์'][6] != NULL)?@$DataisNull['รถรีไฟแนนซ์'][6] :0}}</td>
          <td width="">{{(@$DataisNull['รถรีไฟแนนซ์'][1] != NULL)?@$DataisNull['รถรีไฟแนนซ์'][1] :0}}</td>
          <td width="">{{(@$DataisNull['รถรีไฟแนนซ์'][7] != NULL)?@$DataisNull['รถรีไฟแนนซ์'][7] :0}}</td>
          <td width="">{{(@$DataisNull['รถรีไฟแนนซ์'][2] != NULL)?@$DataisNull['รถรีไฟแนนซ์'][2] :0}}</td>
          <td width="">{{(@$DataisNull['รถรีไฟแนนซ์'][8] != NULL)?@$DataisNull['รถรีไฟแนนซ์'][8] :0}}</td>
          <td width="">{{(@$DataisNull['รถรีไฟแนนซ์'][3] != NULL)?@$DataisNull['รถรีไฟแนนซ์'][3] :0}}</td>
          <td width="">{{(@$DataisNull['รถรีไฟแนนซ์'][9] != NULL)?@$DataisNull['รถรีไฟแนนซ์'][9] :0}}</td>
          <td width="">{{(@$DataisNull['รถรีไฟแนนซ์'][4] != NULL)?@$DataisNull['รถรีไฟแนนซ์'][4] :0}}</td>
          <td width="">{{(@$DataisNull['รถรีไฟแนนซ์'][10] != NULL)?@$DataisNull['รถรีไฟแนนซ์'][10] :0}}</td>
          <td width="" style="background-color: #ffd105;">{{(@$DataisNull['รถรีไฟแนนซ์'][5] != NULL)?@$DataisNull['รถรีไฟแนนซ์'][5] :0}}</td>
          <td width="" style="background-color: #ffd105;">{{(@$DataisNull['รถรีไฟแนนซ์'][11] != NULL)?@$DataisNull['รถรีไฟแนนซ์'][11] :0}}</td>
        </tr>
        <tr align="center" style="background-color: #ffd105;font-weight: bold;">
          <td width="" colspan="2">รวม</td>
          <td width="">
            {{(@$DatanotNull['รถกรรมสิทธิ์'][0]+@$DataisNull['รถกรรมสิทธิ์'][0]+@$DatanotNull['ที่ดิน'][0]+@$DataisNull['ที่ดิน'][0]+@$DatanotNull['รถซื้อขาย'][0]+@$DataisNull['รถซื้อขาย'][0]+@$DatanotNull['รถรีไฟแนนซ์'][0]+@$DataisNull['รถรีไฟแนนซ์'][0])}}
          </td>
          <td width="">
            {{(@$DatanotNull['รถกรรมสิทธิ์'][6]+@$DataisNull['รถกรรมสิทธิ์'][6]+@$DatanotNull['ที่ดิน'][6]+@$DataisNull['ที่ดิน'][6]+@$DatanotNull['รถซื้อขาย'][6]+@$DataisNull['รถซื้อขาย'][6]+@$DatanotNull['รถรีไฟแนนซ์'][6]+@$DataisNull['รถรีไฟแนนซ์'][6])}}
          </td>
          <td width="">
            {{(@$DatanotNull['รถกรรมสิทธิ์'][1]+@$DataisNull['รถกรรมสิทธิ์'][1]+@$DatanotNull['ที่ดิน'][1]+@$DataisNull['ที่ดิน'][1]+@$DatanotNull['รถซื้อขาย'][1]+@$DataisNull['รถซื้อขาย'][1]+@$DatanotNull['รถรีไฟแนนซ์'][1]+@$DataisNull['รถรีไฟแนนซ์'][1])}}
          </td>
          <td width="">
            {{(@$DatanotNull['รถกรรมสิทธิ์'][7]+@$DataisNull['รถกรรมสิทธิ์'][7]+@$DatanotNull['ที่ดิน'][7]+@$DataisNull['ที่ดิน'][7]+@$DatanotNull['รถซื้อขาย'][7]+@$DataisNull['รถซื้อขาย'][7]+@$DatanotNull['รถรีไฟแนนซ์'][7]+@$DataisNull['รถรีไฟแนนซ์'][7])}}
          </td>
          <td width="">
            {{(@$DatanotNull['รถกรรมสิทธิ์'][2]+@$DataisNull['รถกรรมสิทธิ์'][2]+@$DatanotNull['ที่ดิน'][2]+@$DataisNull['ที่ดิน'][2]+@$DatanotNull['รถซื้อขาย'][2]+@$DataisNull['รถซื้อขาย'][2]+@$DatanotNull['รถรีไฟแนนซ์'][2]+@$DataisNull['รถรีไฟแนนซ์'][2])}}
          </td>
          <td width="">
            {{(@$DatanotNull['รถกรรมสิทธิ์'][8]+@$DataisNull['รถกรรมสิทธิ์'][8]+@$DatanotNull['ที่ดิน'][8]+@$DataisNull['ที่ดิน'][8]+@$DatanotNull['รถซื้อขาย'][8]+@$DataisNull['รถซื้อขาย'][8]+@$DatanotNull['รถรีไฟแนนซ์'][8]+@$DataisNull['รถรีไฟแนนซ์'][8])}}
          </td>
          <td width="">
            {{(@$DatanotNull['รถกรรมสิทธิ์'][3]+@$DataisNull['รถกรรมสิทธิ์'][3]+@$DatanotNull['ที่ดิน'][3]+@$DataisNull['ที่ดิน'][3]+@$DatanotNull['รถซื้อขาย'][3]+@$DataisNull['รถซื้อขาย'][3]+@$DatanotNull['รถรีไฟแนนซ์'][3]+@$DataisNull['รถรีไฟแนนซ์'][3])}}
          </td>
          <td width="">
            {{(@$DatanotNull['รถกรรมสิทธิ์'][9]+@$DataisNull['รถกรรมสิทธิ์'][9]+@$DatanotNull['ที่ดิน'][9]+@$DataisNull['ที่ดิน'][9]+@$DatanotNull['รถซื้อขาย'][9]+@$DataisNull['รถซื้อขาย'][9]+@$DatanotNull['รถรีไฟแนนซ์'][9]+@$DataisNull['รถรีไฟแนนซ์'][9])}}
          </td>
          <td width="">
            {{(@$DatanotNull['รถกรรมสิทธิ์'][4]+@$DataisNull['รถกรรมสิทธิ์'][4]+@$DatanotNull['ที่ดิน'][4]+@$DataisNull['ที่ดิน'][4]+@$DatanotNull['รถซื้อขาย'][4]+@$DataisNull['รถซื้อขาย'][4]+@$DatanotNull['รถรีไฟแนนซ์'][4]+@$DataisNull['รถรีไฟแนนซ์'][4])}}
          </td>
          <td width="">
            {{(@$DatanotNull['รถกรรมสิทธิ์'][10]+@$DataisNull['รถกรรมสิทธิ์'][10]+@$DatanotNull['ที่ดิน'][10]+@$DataisNull['ที่ดิน'][10]+@$DatanotNull['รถซื้อขาย'][10]+@$DataisNull['รถซื้อขาย'][10]+@$DatanotNull['รถรีไฟแนนซ์'][10]+@$DataisNull['รถรีไฟแนนซ์'][10])}}
          </td>
          <td width="" style="background-color: #ffd105;">
            {{(@$DatanotNull['รถกรรมสิทธิ์'][5]+@$DataisNull['รถกรรมสิทธิ์'][5]+@$DatanotNull['ที่ดิน'][5]+@$DataisNull['ที่ดิน'][5]+@$DatanotNull['รถซื้อขาย'][5]+@$DataisNull['รถซื้อขาย'][5]+@$DatanotNull['รถรีไฟแนนซ์'][5]+@$DataisNull['รถรีไฟแนนซ์'][5])}}
          </td>
          <td width="" style="background-color: #ffd105;">
            {{(@$DatanotNull['รถกรรมสิทธิ์'][11]+@$DataisNull['รถกรรมสิทธิ์'][11]+@$DatanotNull['ที่ดิน'][11]+@$DataisNull['ที่ดิน'][11]+@$DatanotNull['รถซื้อขาย'][11]+@$DataisNull['รถซื้อขาย'][11]+@$DatanotNull['รถรีไฟแนนซ์'][11]+@$DataisNull['รถรีไฟแนนซ์'][11])}}
          </td>
        </tr>
      </tbody>
    </table>
    {{-- <h4 align="left" style="line-height: 3px"><u>จำนวนจัด ตามประเภทสินเชื่อ</u></h4>
    <table border="1" style="line-height: 10px">
      <thead>
        <tr align="center">
          <th align="center" width="200px" style="background-color: #f4fdff;"><b>ประเภทสินเชื่อ</b></th>
          <th align="center" width="100px" style="background-color: #77e8fc;"><b>ปัตตานี</b></th>
          <th align="center" width="100px" style="background-color: #77e8fc;"><b>หาดใหญ่</b></th>
          <th align="center" width="100px" style="background-color: #77e8fc;"><b>นครศรี</b></th>
          <th align="center" width="100px" style="background-color: #77e8fc;"><b>กระบี่</b></th>
          <th align="center" width="100px" style="background-color: #77e8fc;"><b>สุราษฏร์</b></th>
          <th align="center" width="110px" style="background-color: #ffd105;"><b>รวม</b></th>
        </tr>
      </thead>
      <tbody>
        <tr align="center" >
          <td width="200px" style="background-color: #ffd105">
            สินเชื่อ เช่าซื้อ
          </td>
          <td width="100px">{{@$dataCont[1]->PN}}</td>
          <td width="100px">{{@$dataCont[1]->HY}}</td>
          <td width="100px">{{@$dataCont[1]->NK}}</td>
          <td width="100px">{{@$dataCont[1]->KB}}</td>
          <td width="100px">{{@$dataCont[1]->SR}}</td>
          <td width="110px" style="background-color: #ffd105;">{{@$dataCont[1]->Zoneall}}</td>
        </tr>
        <tr align="center" >
          <td width="200px" style="background-color: #ffd105">
            สินเชื่อ เงินกู้
          </td>
          <td width="100px">{{@$dataCont[0]->PN}}</td>
          <td width="100px">{{@$dataCont[0]->HY}}</td>
          <td width="100px">{{@$dataCont[0]->NK}}</td>
          <td width="100px">{{@$dataCont[0]->KB}}</td>
          <td width="100px">{{@$dataCont[0]->SR}}</td>
          <td width="110px" style="background-color: #ffd105;">{{@$dataCont[0]->Zoneall}}</td>
        </tr>
        <tr align="center" style="background-color: #ffd105;font-weight: bold;">
          <td width="200px">
            ผลรวม
          </td>
          <td width="100px">{{(@$dataCont[0]->PN + @$dataCont[1]->PN)}}</td>
          <td width="100px">{{(@$dataCont[0]->HY + @$dataCont[1]->HY)}}</td>
          <td width="100px">{{(@$dataCont[0]->NK + @$dataCont[1]->NK)}}</td>
          <td width="100px">{{(@$dataCont[0]->KB + @$dataCont[1]->KB)}}</td>
          <td width="100px">{{(@$dataCont[0]->SR + @$dataCont[1]->SR)}}</td>
          <td width="110px" style="background-color: #ffd105;">{{(@$dataCont[0]->Zoneall + @$dataCont[1]->Zoneall)}}</td>
        </tr>
      </tbody>
    </table> --}}

    <h4 align="left" style="line-height: 3px"><u>ยอดเงิน สืนเชื่อรวม</u></h4>
    <table border="1" style="line-height: 10px">
      <thead>
        <tr align="center" >
          <th align="center" width="200px" style="background-color: #f4fdff;"><b>สำนักงาน</b></th>
          <th align="center" width="100px" style="background-color: #77e8fc;"><b>จำนวน เช่าซื้อ</b></th>
          <th align="center" width="100px" style="background-color: #77e8fc;"><b>สินเชื่อ เช่าซื้อ</b></th>
          <th align="center" width="100px" style="background-color: #77e8fc;"><b>จำนวน เงินกู้</b></th>
          <th align="center" width="100px" style="background-color: #77e8fc;"><b>สินเชื่อ เงินกู้</b></th>
          <th align="center" width="100px" style="background-color: #77e8fc;"><b>จำนวนรวม</b></th>
          <th align="center" width="100px" style="background-color: #77e8fc;"><b>รวม</b></th>
          <th align="center" width="100px" style="background-color: #ffd105;"><b>ยอดจัดเฉลี่ย/เคส</b></th>
        </tr>
      </thead>
      <tbody>
        <tr align="center" >
          <td width="200px" style="background-color: #ffd105">ปัตตานี</td>
          <td width="100px">{{@$dataCont[1]->PN}}</td>
          <td width="100px">{{(@$dataPrice[10][0] != NULL)?number_format(@$dataPrice[10][0],0) :0}}</td>
          <td width="100px">{{@$dataCont[0]->PN}}</td>
          <td width="100px">{{(@$dataPrice[10][1] != NULL)?number_format(@$dataPrice[10][1],0) :0}}</td>
          <td width="100px">{{@$dataCont[0]->PN+@$dataCont[1]->PN}}</td>
          <td width="100px">{{(@$dataPrice[10][2] != NULL)?number_format(@$dataPrice[10][2],0) :0}}</td>
          <td width="100px">{{(@$dataPrice[10][3] != NULL)?number_format(@$dataPrice[10][3],0) :0}}</td>
        </tr>
        <tr align="center" >
          <td width="200px" style="background-color: #ffd105">หาดใหญ่</td>
          <td width="100px">{{@$dataCont[1]->HY}}</td>
          <td width="100px">{{(@$dataPrice[20][0] != NULL)?number_format(@$dataPrice[20][0],0) :0}}</td>
          <td width="100px">{{@$dataCont[0]->HY}}</td>
          <td width="100px">{{(@$dataPrice[20][1] != NULL)?number_format(@$dataPrice[20][1],0) :0}}</td>
          <td width="100px">{{@$dataCont[0]->HY+@$dataCont[1]->HY}}</td>
          <td width="100px">{{(@$dataPrice[20][2] != NULL)?number_format(@$dataPrice[20][2],0) :0}}</td>
          <td width="100px">{{(@$dataPrice[20][3] != NULL)?number_format(@$dataPrice[20][3],0) :0}}</td>
        </tr>
        <tr align="center" >
          <td width="200px" style="background-color: #ffd105">นครศรี</td>
          <td width="100px">{{@$dataCont[1]->NK}}</td>
          <td width="100px">{{(@$dataPrice[30][0] != NULL)?number_format(@$dataPrice[30][0],0) :0}}</td>
          <td width="100px">{{@$dataCont[0]->NK}}</td>
          <td width="100px">{{(@$dataPrice[30][1] != NULL)?number_format(@$dataPrice[30][1],0) :0}}</td>
          <td width="100px">{{@$dataCont[0]->NK+@$dataCont[1]->NK}}</td>
          <td width="100px">{{(@$dataPrice[30][2] != NULL)?number_format(@$dataPrice[30][2],0) :0}}</td>
          <td width="100px">{{(@$dataPrice[30][3] != NULL)?number_format(@$dataPrice[30][3],0) :0}}</td>
        </tr>
        <tr align="center" >
          <td width="200px" style="background-color: #ffd105">กระบี่</td>
          <td width="100px">{{@$dataCont[1]->KB}}</td>
          <td width="100px">{{(@$dataPrice[40][0] != NULL)?number_format(@$dataPrice[40][0],0) :0}}</td>
          <td width="100px">{{@$dataCont[0]->KB}}</td>
          <td width="100px">{{(@$dataPrice[40][1] != NULL)?number_format(@$dataPrice[40][1],0) :0}}</td>
          <td width="100px">{{@$dataCont[0]->KB+@$dataCont[1]->KB}}</td>
          <td width="100px">{{(@$dataPrice[40][2] != NULL)?number_format(@$dataPrice[40][2],0) :0}}</td>
          <td width="100px">{{(@$dataPrice[40][3] != NULL)?number_format(@$dataPrice[40][3],0) :0}}</td>
        </tr>
        <tr align="center" >
          <td width="200px" style="background-color: #ffd105">สุราษฏร์</td>
          <td width="100px">{{@$dataCont[1]->SR}}</td>
          <td width="100px">{{(@$dataPrice[50][0] != NULL)?number_format(@$dataPrice[50][0],0) :0}}</td>
          <td width="100px">{{@$dataCont[0]->SR}}</td>
          <td width="100px">{{(@$dataPrice[50][1] != NULL)?number_format(@$dataPrice[50][1],0) :0}}</td>
          <td width="100px">{{@$dataCont[0]->SR+@$dataCont[1]->SR}}</td>
          <td width="100px">{{(@$dataPrice[50][2] != NULL)?number_format(@$dataPrice[50][2],0) :0}}</td>
          <td width="100px">{{(@$dataPrice[50][3] != NULL)?number_format(@$dataPrice[50][3],0) :0}}</td>
        </tr>
         <tr align="center" style="font-weight: bold;background-color: #ffd105">
          <td width="200px">ผลรวม</td>
          <td width="100px">{{@$dataCont[1]->PN+@$dataCont[1]->HY+@$dataCont[1]->NK+@$dataCont[1]->KB+@$dataCont[1]->SR}}</td>
          <td width="100px">
            @php
              $sumLeasing = 0;
              $sumLeasing = (@$dataPrice[10][0] + @$dataPrice[20][0] + @$dataPrice[30][0] + @$dataPrice[40][0] + @$dataPrice[50][0]);
            @endphp
            {{number_format($sumLeasing,0)}}
          </td>
          <td width="100px">{{@$dataCont[0]->PN+@$dataCont[0]->HY+@$dataCont[0]->NK+@$dataCont[0]->KB+@$dataCont[0]->SR}}</td>
          <td width="100px">
            @php
              $sumLoan = 0;
              $sumLoan = (@$dataPrice[10][1] + @$dataPrice[20][1] + @$dataPrice[30][1] + @$dataPrice[40][1] + @$dataPrice[50][1]);
            @endphp
            {{number_format($sumLoan,0)}}
          </td>
          <td width="100px">{{(@$dataCont[1]->PN+@$dataCont[1]->HY+@$dataCont[1]->NK+@$dataCont[1]->KB+@$dataCont[1]->SR)+(@$dataCont[0]->PN+@$dataCont[0]->HY+@$dataCont[0]->NK+@$dataCont[0]->KB+@$dataCont[0]->SR)}}</td>
          <td width="100px">
            @php
              $sumAll = 0;
              $sumAll = (@$dataPrice[10][2] + @$dataPrice[20][2] + @$dataPrice[30][2] + @$dataPrice[40][2] + @$dataPrice[50][2]);
            @endphp
            {{number_format($sumAll,0)}}
          </td>
          <td width="100px">
            @php
              $sumAllPresent = 0;
              if((@$dataCont[0]->Zoneall + @$dataCont[1]->Zoneall) > 0){
                $sumAllPresent = ((@$sumAll / (@$dataCont[0]->Zoneall + @$dataCont[1]->Zoneall)));
              } else {
                $sumAllPresent = 0 ;
              }
            @endphp
            {{number_format($sumAllPresent,0)}}
          </td>
        </tr>
      </tbody>
    </table>

    <h4 align="left" style="line-height: 3px"><u>สัดส่วนเคส มีผู้แนะนำ</u></h4>
    <table border="1" style="line-height: 10px">
      <thead>
        <tr align="center" >
          <th align="center" width="200px" style="background-color: #f4fdff;"><b>สำนักงาน</b></th>
          <th align="center" width="100px" style="background-color: #77e8fc;"><b>จำนวนเคส</b></th>
          <th align="center" width="100px" style="background-color: #77e8fc;"><b>เคสมีผู้แนะนำ</b></th>
          <th align="center" width="100px" style="background-color: #77e8fc;"><b>ยอดจัดรวม</b></th>
          <th align="center" width="100px" style="background-color: #77e8fc;"><b>ค่าผู้แนะนำรวม</b></th>
          <th align="center" width="100px" style="background-color: #ffd105;"><b>สัดส่วนเคสมีผู้แนะนำ</b></th>
          <th align="center" width="110px" style="background-color: #ffd105;"><b>ยอดจัดเคสมีผู้แนะนำ</b></th>
        </tr>
      </thead>
      <tbody>
        <tr align="center" >
          <td width="200px" style="background-color: #ffd105">ปัตตานี</td>
          <td width="100px">{{(@$SumBroker[10][0] != NULL)?@$SumBroker[10][0] :0}}</td>
          <td width="100px">{{(@$SumBroker[10][1] != NULL)?@$SumBroker[10][1] :0}}</td>
          <td width="100px">{{(@$SumBroker[10][2] != NULL)?number_format(@$SumBroker[10][2],2) :0}}</td>
          <td width="100px">{{(@$SumBroker[10][3] != NULL)?number_format(@$SumBroker[10][3],2) :0}}</td>
          <td width="100px">
            {{-- @php
              $Brok04_1 = ((@$dataBroker[0]->broker_n != NULL)?@$dataBroker[0]->broker_n :0);
              $Broktotal04_1 = ((@$dataBroker[0]->con != NULL)?@$dataBroker[0]->con :0);
              $sumBrok04_1 = @$Broktotal04_1==0?0:((@$Brok04_1 / @$Broktotal04_1) * 100);
            @endphp --}}
            {{-- {{number_format($sumBrok04_1,2)}} % --}}
            {{(@$SumBroker[10][4] != NULL)?number_format(@$SumBroker[10][4],2) :0}} %
          </td>
          <td width="110px">
            {{-- @php
              $Brok04_6 = ((@$dataBroker[0]->broker_price != NULL)?@$dataBroker[0]->broker_price :0);
              $Broktotal04_6 = ((@$dataBroker[0]->total != NULL)?@$dataBroker[0]->total :0);
              $sumBrok04_6 = @$Broktotal04_6==0?0:((@$Brok04_6 / @$Broktotal04_6) * 100);
            @endphp
            {{number_format($sumBrok04_6,2)}} % --}}
            {{(@$SumBroker[10][5] != NULL)?number_format(@$SumBroker[10][5],2) :0}} %
          </td>
        </tr>
        <tr align="center">
          <td width="200px" style="background-color: #ffd105">หาดใหญ่</td>
          <td width="100px">{{(@$SumBroker[20][0] != NULL)?@$SumBroker[20][0] :0}}</td>
          <td width="100px">{{(@$SumBroker[20][1] != NULL)?@$SumBroker[20][1] :0}}</td>
          <td width="100px">{{(@$SumBroker[20][2] != NULL)?number_format(@$SumBroker[20][2],2) :0}}</td>
          <td width="100px">{{(@$SumBroker[20][3] != NULL)?number_format(@$SumBroker[20][3],2) :0}}</td>
          <td width="100px">
            {{-- @php
              $Brok04_1 = ((@$dataBroker[0]->broker_n != NULL)?@$dataBroker[0]->broker_n :0);
              $Broktotal04_1 = ((@$dataBroker[0]->con != NULL)?@$dataBroker[0]->con :0);
              $sumBrok04_1 = @$Broktotal04_1==0?0:((@$Brok04_1 / @$Broktotal04_1) * 100);
            @endphp --}}
            {{-- {{number_format($sumBrok04_1,2)}} % --}}
            {{(@$SumBroker[20][4] != NULL)?number_format(@$SumBroker[20][4],2) :0}} %
          </td>
          <td width="110px">
            {{-- @php
              $Brok04_6 = ((@$dataBroker[0]->broker_price != NULL)?@$dataBroker[0]->broker_price :0);
              $Broktotal04_6 = ((@$dataBroker[0]->total != NULL)?@$dataBroker[0]->total :0);
              $sumBrok04_6 = @$Broktotal04_6==0?0:((@$Brok04_6 / @$Broktotal04_6) * 100);
            @endphp
            {{number_format($sumBrok04_6,2)}} % --}}
            {{(@$SumBroker[20][5] != NULL)?number_format(@$SumBroker[20][5],2) :0}} %
          </td>
        </tr>
        <tr align="center" >
          <td width="200px" style="background-color: #ffd105">นครศรี</td>
          <td width="100px">{{(@$SumBroker[30][0] != NULL)?@$SumBroker[30][0] :0}}</td>
          <td width="100px">{{(@$SumBroker[30][1] != NULL)?@$SumBroker[30][1] :0}}</td>
          <td width="100px">{{(@$SumBroker[30][2] != NULL)?number_format(@$SumBroker[30][2],2) :0}}</td>
          <td width="100px">{{(@$SumBroker[30][3] != NULL)?number_format(@$SumBroker[30][3],2) :0}}</td>
          <td width="100px">
            {{-- @php
              $Brok04_1 = ((@$dataBroker[0]->broker_n != NULL)?@$dataBroker[0]->broker_n :0);
              $Broktotal04_1 = ((@$dataBroker[0]->con != NULL)?@$dataBroker[0]->con :0);
              $sumBrok04_1 = @$Broktotal04_1==0?0:((@$Brok04_1 / @$Broktotal04_1) * 100);
            @endphp --}}
            {{-- {{number_format($sumBrok04_1,2)}} % --}}
            {{(@$SumBroker[30][4] != NULL)?number_format(@$SumBroker[30][4],2) :0}} %
          </td>
          <td width="110px">
            {{-- @php
              $Brok04_6 = ((@$dataBroker[0]->broker_price != NULL)?@$dataBroker[0]->broker_price :0);
              $Broktotal04_6 = ((@$dataBroker[0]->total != NULL)?@$dataBroker[0]->total :0);
              $sumBrok04_6 = @$Broktotal04_6==0?0:((@$Brok04_6 / @$Broktotal04_6) * 100);
            @endphp
            {{number_format($sumBrok04_6,2)}} % --}}
            {{(@$SumBroker[30][5] != NULL)?number_format(@$SumBroker[30][5],2) :0}} %
          </td>
        </tr>
        <tr align="center" >
          <td width="200px" style="background-color: #ffd105">กระบี่</td>
          <td width="100px">{{(@$SumBroker[40][0] != NULL)?@$SumBroker[40][0] :0}}</td>
          <td width="100px">{{(@$SumBroker[40][1] != NULL)?@$SumBroker[40][1] :0}}</td>
          <td width="100px">{{(@$SumBroker[40][2] != NULL)?number_format(@$SumBroker[40][2],2) :0}}</td>
          <td width="100px">{{(@$SumBroker[40][3] != NULL)?number_format(@$SumBroker[40][3],2) :0}}</td>
          <td width="100px">
            {{-- @php
              $Brok04_1 = ((@$dataBroker[0]->broker_n != NULL)?@$dataBroker[0]->broker_n :0);
              $Broktotal04_1 = ((@$dataBroker[0]->con != NULL)?@$dataBroker[0]->con :0);
              $sumBrok04_1 = @$Broktotal04_1==0?0:((@$Brok04_1 / @$Broktotal04_1) * 100);
            @endphp --}}
            {{-- {{number_format($sumBrok04_1,2)}} % --}}
            {{(@$SumBroker[40][4] != NULL)?number_format(@$SumBroker[40][4],2) :0}} %
          </td>
          <td width="110px">
            {{-- @php
              $Brok04_6 = ((@$dataBroker[0]->broker_price != NULL)?@$dataBroker[0]->broker_price :0);
              $Broktotal04_6 = ((@$dataBroker[0]->total != NULL)?@$dataBroker[0]->total :0);
              $sumBrok04_6 = @$Broktotal04_6==0?0:((@$Brok04_6 / @$Broktotal04_6) * 100);
            @endphp
            {{number_format($sumBrok04_6,2)}} % --}}
            {{(@$SumBroker[40][5] != NULL)?number_format(@$SumBroker[40][5],2) :0}} %
          </td>
        </tr>
        <tr align="center" >
          <td width="200px" style="background-color: #ffd105">สุราษฏร์</td>
          <td width="100px">{{(@$SumBroker[50][0] != NULL)?@$SumBroker[50][0] :0}}</td>
          <td width="100px">{{(@$SumBroker[50][1] != NULL)?@$SumBroker[50][1] :0}}</td>
          <td width="100px">{{(@$SumBroker[50][2] != NULL)?number_format(@$SumBroker[50][2],0) :0}}</td>
          <td width="100px">{{(@$SumBroker[50][3] != NULL)?number_format(@$SumBroker[50][3],0) :0}}</td>
          <td width="100px">
            {{-- @php
              $Brok04_1 = ((@$dataBroker[0]->broker_n != NULL)?@$dataBroker[0]->broker_n :0);
              $Broktotal04_1 = ((@$dataBroker[0]->con != NULL)?@$dataBroker[0]->con :0);
              $sumBrok04_1 = @$Broktotal04_1==0?0:((@$Brok04_1 / @$Broktotal04_1) * 100);
            @endphp --}}
            {{-- {{number_format($sumBrok04_1,2)}} % --}}
            {{(@$SumBroker[50][4] != NULL)?number_format(@$SumBroker[50][4],2) :0}} %
          </td>
          <td width="110px">
            {{-- @php
              $Brok04_6 = ((@$dataBroker[0]->broker_price != NULL)?@$dataBroker[0]->broker_price :0);
              $Broktotal04_6 = ((@$dataBroker[0]->total != NULL)?@$dataBroker[0]->total :0);
              $sumBrok04_6 = @$Broktotal04_6==0?0:((@$Brok04_6 / @$Broktotal04_6) * 100);
            @endphp
            {{number_format($sumBrok04_6,2)}} % --}}
            {{(@$SumBroker[50][5] != NULL)?number_format(@$SumBroker[50][5],2) :0}} %
          </td>
        </tr>
         <tr align="center" style="font-weight: bold;background-color: #ffd105">
          <td width="200px">ผลรวม</td>
          <td width="100px">
            {{-- {{(@$dataCont[0]->Zoneall + @$dataCont[1]->Zoneall)}} --}}
            @php
              $sumdataCon = 0;
              $sumdataCon = (@$SumBroker[10][0] + @$SumBroker[20][0] + @$SumBroker[30][0] + @$SumBroker[40][0] + @$SumBroker[50][0]);
            @endphp
            {{number_format(@$sumdataCon,0)}}
          </td>
          <td width="100px">
            @php
              $sumdata04 = 0;
              $sumdata04 = (@$SumBroker[10][1] + @$SumBroker[20][1] + @$SumBroker[30][1] + @$SumBroker[40][1] + @$SumBroker[50][1]);
            @endphp
            {{number_format(@$sumdata04,0)}}
          </td>
          <td width="100px">
            @php
              $sumAll = 0;
              $sumAll = (@$SumBroker[10][2] + @$SumBroker[20][2] + @$SumBroker[30][2] + @$SumBroker[40][2] + @$SumBroker[50][2]);
            @endphp
            {{number_format($sumAll,0)}}
          </td>
          <td width="100px">
            @php
              $sumBroker = 0;
              $sumBroker = (@$SumBroker[10][3] + @$SumBroker[20][3] + @$SumBroker[30][3] + @$SumBroker[40][3] + @$SumBroker[50][3]);
            @endphp
            {{number_format($sumBroker,0)}}
          </td>
          <td width="100px">
            @php
            if((@$dataCont[0]->Zoneall + @$dataCont[1]->Zoneall) > 0){
              $sumAllBrok = (((@$sumdata04 / (@$dataCont[0]->Zoneall + @$dataCont[1]->Zoneall)) * 100));
            } else {
              $sumAllBrok = 0;
            }
            @endphp
            {{number_format($sumAllBrok,2)}} %
          </td>
          <td width="110px">
            @php
            if(@$sumAll > 0){
              $sumAllBrokPrice = (((@$sumBroker / @$sumAll) * 100));
            } else {
              $sumAllBrokPrice = 0;
            }
            @endphp
            {{number_format($sumAllBrokPrice,2)}} %
          </td>
        </tr>
      </tbody>
    </table>

    <h4 align="left"><u>จำนวนจัด ตามประเภทสินเชื่อ</u></h4>
    <table border="1" style="line-height: 10px">
      <thead>
        <tr align="center" >
          <th align="center" width="100px" style="background-color: #f4fdff;"><b>ประเภทสินเชื่อ</b></th>
          <th align="center" width="120px" style="background-color: #77e8fc;" colspan="2"><b>ปัตตานี</b></th>
          <th align="center" width="120px" style="background-color: #77e8fc;" colspan="2"><b>หาดใหญ่</b></th>
          <th align="center" width="120px" style="background-color: #77e8fc;" colspan="2"><b>นครศรี</b></th>
          <th align="center" width="120px" style="background-color: #77e8fc;" colspan="2"><b>กระบี่</b></th>
          <th align="center" width="120px" style="background-color: #77e8fc;" colspan="2"><b>สุราษฏร์</b></th>
          <th align="center" width="120px" style="background-color: #ffd105;" colspan="2"><b>รวม</b></th>
          <th align="center" width="120px" style="background-color: #ffd105;" ><b>เฉลี่ย</b></th>
        </tr>
      </thead>
      <tbody>
        @php
          $data1 = 0;
            $data2 = 0;
            $data3 = 0;
            $data4 = 0;
            $data5 = 0;
            $data6 = 0;
            $data7 = 0;
            $data8 = 0;
            $data9 = 0;
            $data10 = 0;
            $data11 = 0;
            $data12 = 0;
        @endphp
        @for($i=0;$i<count($dataLoan);$i++)
        <tr align="center">
          <td align="left" width="100px" style="background-color: #ffd105">
            {{@$dataLoan[$i][0]}}
          </td>
          @php
            $data1 = $data1+@$dataLoan[$i][1];
            $data2 = $data2+@$dataLoan[$i][2];
            $data3 = $data3+@$dataLoan[$i][3];
            $data4 = $data4+@$dataLoan[$i][4];
            $data5 = $data5+@$dataLoan[$i][5];
            $data6 = $data6+@$dataLoan[$i][6];
            $data7 = $data7+@$dataLoan[$i][7];
            $data8 = $data8+@$dataLoan[$i][8];
            $data9 = $data9+@$dataLoan[$i][9];
            $data10 = $data10+@$dataLoan[$i][10];
            $data11 = $data11+@$dataLoan[$i][11];
            $data12 = $data12+@$dataLoan[$i][12];
          @endphp
          <td width="50px">{{@$dataLoan[$i][1]}}</td>
          <td width="70px">{{number_format(@$dataLoan[$i][2],2)}}</td>
          <td width="50px">{{@$dataLoan[$i][3]}}</td>
          <td width="70px">{{number_format(@$dataLoan[$i][4],2)}}</td>
          <td width="50px">{{@$dataLoan[$i][5]}}</td>
          <td width="70px">{{number_format(@$dataLoan[$i][6],2)}}</td>
          <td width="50px">{{@$dataLoan[$i][7]}}</td>
          <td width="70px">{{number_format(@$dataLoan[$i][8],2)}}</td>
          <td width="50px">{{@$dataLoan[$i][9]}}</td>
          <td width="70px">{{number_format(@$dataLoan[$i][10],2)}}</td>
          <td width="50px" style="background-color: #ffd105;">{{@$dataLoan[$i][11]}}</td>
          <td width="70px" style="background-color: #ffd105;">{{number_format(@$dataLoan[$i][12],2)}}</td>
          @php
              if(@$dataLoan[$i][11]>0){
               $priceLoan =number_format(@$dataLoan[$i][12]/@$dataLoan[$i][11],2);
              }else{
                $priceLoan = 0;
              }
          @endphp
          <td width="70px" style="background-color: #ffd105;">{{$priceLoan}}</td>

        </tr>
        @endfor
        <tr align="center" style="background-color: #ffd105">
          <td width="100px" >
            รวม
          </td>
          <td width="50px" rowspan="2">{{number_format(@$data1)}}</td>
          <td width="70px">{{number_format(@$data2,2)}}</td>
          <td width="50px" rowspan="2">{{number_format(@$data3)}}</td>
          <td width="70px">{{number_format(@$data4,2)}}</td>
          <td width="50px" rowspan="2">{{number_format(@$data5)}}</td>
          <td width="70px">{{number_format(@$data6,2)}}</td>
          <td width="50px" rowspan="2">{{number_format(@$data7)}}</td>
          <td width="70px">{{number_format(@$data8,2)}}</td>
          <td width="50px" rowspan="2">{{number_format(@$data9)}}</td>
          <td width="70px">{{number_format(@$data10,2)}}</td>
          <td width="50px" rowspan="2" >{{@$data11}}</td>
          <td width="70px"  rowspan="2">{{number_format(@$data12,2)}}</td>
          @php
              if(@$data11>0){
                  $d11=number_format(@$data12/@$data11,2);
              }else{
                $d11= 0;
              }
          @endphp
          <td width="70px"  rowspan="2">{{$d11}}</td>
        </tr>
        <tr align="center" style="background-color: #ffd105">
          <td width="100px" >
            เฉลี่ย
          </td>
          @php
              if(@$data1>0){
                $p1 =number_format(@$data2/@$data1,2);
              }else{
                $p1 = 0;
              }
          @endphp
          <td width="70px">{{$p1}}</td>
          @php
              if(@$data3>0){
                $p2 =number_format(@$data4/@$data3,2);
              }else{
                $p2 = 0;
              }
          @endphp
          <td width="70px">{{$p2}}</td>
          @php
              if(@$data5>0){
                $p3 =number_format(@$data6/@$data5,2);
              }else{
                $p3 = 0;
              }
          @endphp
          <td width="70px">{{$p3}}</td>
           @php
              if(@$data7>0){
                $p4 =number_format(@$data8/@$data7,2);
              }else{
                $p4 = 0;
              }
          @endphp
          <td width="70px">{{$p4}}</td>
          @php
            if(@$data9>0){
              $p5 =number_format(@$data10/@$data9,2);
            }else{
              $p5 = 0;
            }
          @endphp
          <td width="70px">{{$p5}}</td>


        </tr>
      </tbody>
    </table>


    <h4 align="left" class="page_break"><u>ยอดจัดเฉลี่ย ตามประเภทสินเชื่อ</u></h4>
    <table border="1" style="line-height: 10px">
      <thead>
        <tr align="center" > 
          <th align="center" width="100px" style="background-color: #f4fdff;"><b>ประเภทสินเชื่อ</b></th> 
          <th align="center" width="120px" style="background-color: #f4fdff;" ><b>สำนักงาน</b></th>                  
          <th align="center" width="80px" style="background-color: #77e8fc;" ><b>จำนวนสัญญา</b></th>
          <th align="center" width="80px" style="background-color: #77e8fc;" ><b>LTV เฉลี่ย</b></th>
          <th align="center" width="80px" style="background-color: #77e8fc;"><b>ยอดจัดเฉลี่ย</b></th>
          <th align="center" width="80px" style="background-color: #ffd105;" ><b>จำนวน น้อยกว่า 30 วัน</b></th>
          <th align="center" width="80px" style="background-color: #ffd105;" ><b>AVG น้อยกว่า 30 วัน</b></th>
          <th align="center" width="80px" style="background-color: #ffd105;" ><b>จำนวน 30 - 60 วัน</b></th>
          <th align="center" width="80px" style="background-color: #ffd105;" ><b>AVG 30 - 60 วัน</b></th>
          <th align="center" width="80px" style="background-color: #ffd105;" ><b>จำนวน 60 วันขึ้นไป</b></th>
          <th align="center" width="80px" style="background-color: #ffd105;" ><b>AVG 60 วันขึ้นไป</b></th>
        </tr>
      </thead>
      <tbody>
          @foreach($avgProduct as $avgData)
          <tr>
            <td width="70px">{{$avgData->Loan_Name}}</td>
            <td width="50px" align="center" style="background-color: #ffd105;" >{{$zoneName[$avgData->UserZone]}}</td>
            <td width="50px" align="center">{{$avgData->Contno}}</td>
            <td width="50px" align="center">{{number_format($avgData->LTV*100,2)}}%</td>
            <td width="70px" align="right">{{number_format($avgData->Avgcash,2)}}</td>
            <td width="50px" align="center">{{number_format($avgData->ConMin30,0)}}</td>
            <td width="50px" align="center">{{number_format($avgData->MIN30*100,2)}}%</td>
            <td width="50px" align="center">{{number_format($avgData->ConMax30,2)}}</td>
            <td width="70px" align="center">{{number_format($avgData->MAX30*100,2)}}%</td>
            <td width="50px" align="center">{{number_format($avgData->ConMax60,0)}}</td>
            <td width="50px" align="center">{{number_format($avgData->MAX60*100,2)}}%</td>
          </tr>
          @endforeach
          <tr>
            <td width="50px" align="center" style="background-color: #ffd105;" colspan="2">รวม</td>
            <td width="50px" align="center">{{collect($avgProduct)->sum('Contno')}}</td>
            @php
                if(collect($avgProduct)->sum('RateCar')>0){
                  $e1 = number_format((collect($avgProduct)->sum('Allcash')/collect($avgProduct)->sum('RateCar'))*100,2);
                }else{
                  $e1 = 0;
                }
            @endphp
            <td width="50px" align="center">{{$e1}}%</td>
            <td width="70px" align="right">{{number_format((collect($avgProduct)->sum('Allcash')/collect($avgProduct)->sum('Contno')),2)}}</td>
            @php
                if(collect($avgProduct)->sum('Contno')>0){
                  $e2 = number_format((collect($avgProduct)->sum('ConMin30')/collect($avgProduct)->sum('Contno')) * 100,2);
                }else{
                  $e2 = 0;
                }
            @endphp
            <td width="50px" align="center">{{collect($avgProduct)->sum('ConMin30')}}</td>
            <td width="50px" align="center">{{$e2}}%</td>
            <td width="70px" align="center">{{collect($avgProduct)->sum('ConMax30')}}</td>
            @php
                if(collect($avgProduct)->sum('Contno')>0){
                  $e3 = number_format((collect($avgProduct)->sum('ConMax30')/collect($avgProduct)->sum('Contno')) * 100,2);
                }else{
                  $e3 = 0;
                }
            @endphp
            <td width="50px" align="center">{{$e3}}%</td>
            <td width="50px" align="center">{{collect($avgProduct)->sum('ConMax60')}}</td>
            @php
                if(collect($avgProduct)->sum('Contno')>0){
                  $e4 = number_format((collect($avgProduct)->sum('ConMax60')/collect($avgProduct)->sum('Contno')) * 100,2);
                }else{
                  $e4 = 0;
                }
            @endphp
            <td width="50px" align="center">{{$e4}}%</td>

          </tr>
      </tbody>
    </table>
  </body>
</html>
