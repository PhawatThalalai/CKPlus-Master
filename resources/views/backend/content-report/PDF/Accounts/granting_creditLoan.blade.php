<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <style>
      @page {
         size: landscape;
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
         /* @font-face {
             font-family: 'TFPimpakarn';
             font-style: italic;
             font-weight: normal;
             src: url({{ asset('fonts/THSarabunNew Italic.ttf') }}) format('truetype');
         }
         @font-face {
             font-family: 'TFPimpakarn';
             font-style: italic;
             font-weight: bold;
             src: url({{ asset('fonts/THSarabunNew BoldItalic.ttf') }}) format('truetype');
         } */
         body {
             font-family: "TFPimpakarn";
         }
     .circle {
         top:4rem;
         left:4rem;
     }
     .border_black {
         /* border: solid 1px black;
 
 
         height: 20px;*/
 
         display: inline-block;
         line-height: 0.3cm;
         border: solid 1px black;
 
         margin-right: 2px;
         width: 12px;
         /* margin: 1px; */
         /* vertical-align: 7px; */
 
     }
 
     html { margin: 20px}
 
 
     .borderTB  > table,.borderTB  >tr,.borderTB  >td,.borderTB  >th {
             border: 1px solid black;
             border-collapse: collapse;
         }
 
         table {
          border-collapse: collapse;
          width: 100%;
        }

        th {
          background: rgba(72, 191, 227, 0.9);
          border-top: 4px solid rgba(105, 48, 192, 0.6);
        }

        th, td {
          text-align: left;
        }
  
 </style>
  </head>
  <body>
    <div  style=" text-align: center;line-height: 0.4cm">
       <h3>รายงานทำสัญญาเงินกู้เพื่อแผนกบัญชี</h3> 
       <h3>ระหว่างวันที่ {{formatDateThaiShort_monthNum(@$Fdate)}} ถึงวันที่ {{formatDateThaiShort_monthNum(@$Tdate)}}</h3>
    </div> 
    <p align="right">วันที่พิมพ์ : {{FormatDatethaiLong(date('d-m-Y'))}} <br/>ผู้พิมพ์ : {{auth()->user()->name}}</p>
  <hr  >
  
 
  <!-- <h5 style="line-height:-5px;">รวม {{count(@$data)}} รายการ</h5> -->
  <table width="100%">
    <thead>
      <tr style="line-height:100%;background-color:#F2F0EF;">
        <th align="center" >ลำดับ</th>
        <th align="center" >เลขที่สัญญา</th>
        <th align="center" >ชื่อลูกค้า</th>
        <th align="center" >เลขตัวถัง</th>
        <th align="center" >ยี่ห้อ</th>
        <th align="center" >วันที่ทำสัญญา</th>
        <th align="center" >งวดเเรก</th>
        <th align="center" >เงินต้น</th>
        <th align="center" >ดอกเบี้ย</th>
        <th align="center" >ยอดผ่อนชำระ</th>
        <th align="center" >จำนวน</th>
        <th align="center" >ค่างวด</th>
      </tr>
    </thead>
    <tbody>

       
      @foreach($data as $key => $value)
        @php
              $brand = explode(' ', @$value->typeModel);   
        @endphp
          <tr style="line-height: 0.5cm">
            <td align="center" >{{@$key+1}}</td>
            <td align="left" > {{@$value->CONTNO}}</td>
            <td align="left" > {{@$value->Name_Cus}}</td>
            <td align="left" > {{@$value->Vehicle_Chassis != '' || null ? @$value->Vehicle_Chassis : 'ไม่มีข้อมูล' }}</td>
            <td align="center"  > {{@$brand[0] != '' || null ? @$brand[0] : 'ไม่มีข้อมูล' }}</td>
            <td align="center"  > {{@$value->SDATE}}</td>
            <td align="center"  > {{@$value->FDATE}}</td>
            <td align="center"  > {{ number_format(@$value->TCSHPRC, 2) }}</td>
            <td align="center"  > {{ number_format(@$value->NETPROFIT, 2) }}</td>
            <td align="center"  > {{ number_format(@$value->TOTPRC, 2) }}</td>
            <td align="center"  > {{ number_format(@$value->T_NOPAY, 2) }}</td>
            <td align="center"  > {{ number_format(@$value->TOT_UPAY, 2) }}</td>

          </tr>
    
      @endforeach
          {{-- <tr style="line-height: 150%">
            <td align="center" width="150px">รวม {{@$Count}} ราย</td>
            <td align="center" width="410px">รวมยอดจัด {{number_format(@$TotalCash)}} บาท</td>
          </tr> --}}
    </tbody>
  </table> 
  <br>
</body>
</html>
