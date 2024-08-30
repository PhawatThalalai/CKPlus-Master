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
  <body style="">
    <div  style=" text-align: center; height: 0.4cm">
       <h3 style=" text-align: center; height: 0.4cm">รายงานทำสัญญาเช่าซื้อเพื่อแผนกบัญชี</h3> 
       <h3>ระหว่างวันที่ {{formatDateThaiShort_monthNum(@$Fdate)}} ถึงวันที่ {{formatDateThaiShort_monthNum(@$Tdate)}}</h3>
    </div> 
    <p align="right">วันที่พิมพ์ : {{FormatDatethaiLong(date('d-m-Y'))}} <br/>ผู้พิมพ์ : {{auth()->user()->name}}</p>
  <hr  >
  
 
  <!-- <h5 style="line-height:-5px;">รวม {{count(@$data)}} รายการ</h5> -->
  <table width="100%">
    <thead>
      <tr style="line-height:100%;background-color:#F2F0EF;">
        <th align="center" >ลำดับ<br/>ยี่ห้อ </th>
        <th align="center" >เลขที่สัญญา<br/>ทะเบียน  </th>
        <th align="center" >ชื่อลูกค้า <br/> เลขตัวถัง</th>
        <th align="center" >วันที่ทำสัญญา<br/>งวดเเรก</th>
        <th align="center" >จำนวนงวด<br/>ค่างวดรวม</th>
        <th align="center" >ค่างวด <br/>ภาษีค่างวด</th>
        <th align="center" >มูลค่าขายสด<br/>มูลค่าดาวน์</th>
        <th align="center" >ภาษีขายสด <br/>ภาษีดาวน์</th>
        <th align="center" >ขายสดรวมภาษี<br/>ดาวน์รวมภาษี</th>
        <th align="center" >มูลค่าทุน<br/>ดอกผลเช้าซื้อ</th>
        <th align="center" >ภาษีทุน<br/>ภาษีขาย</th>
        <th align="center" >ทุนรวมภาษี<br/>ราคารวมภาษี </th>
        <th align="center" >กำไรขายสด<br/>กำไรขายผ่อน</th>
        <th align="center" >มูลค่าขายผ่อน<br/>ลูกหนี้ทั้งสัญญา</th>
      </tr>
    </thead>
    <tbody>

       
      @foreach($data as $key => $value)
        @php
              $brand = explode(' ', @$value->typeModel);   
               
        @endphp
          <tr style="line-height: 0.5cm; border-bottom: 1px solid #000;">
            <td align="center" >{{@$key+1}}<br/> {{$brand[0]}}</td>
            <td align="left" > {{@$value->CONTNO}}<br/> {{@$value->typeLicense}}</td>
            <td align="left" > {{@$value->Name_Cus}}<br/>{{@$value->Vehicle_Chassis}}</td>
            <td align="left" >{{formatDateThaiShort_monthNum(@$value->SDATE)}}<br/>{{formatDateThaiShort_monthNum(@$value->FDATE)}} </td>
            <td align="center"  >{{number_format(@$value->T_NOPAY,0)}}<br/>{{number_format(@$value->dueNoVat+@$value->VatDue,2)}}</td>
            <td align="center"  >{{number_format(@$value->dueNoVat,2)}}<br/>{{number_format(@$value->VatDue,2)}} </td>
            <td align="center"  >{{number_format(@$value->TonNoVat,2)}}<br/>{{number_format(@$value->NDAWN,2)}}  </td>
            <td align="center"  >{{number_format(@$value->VatTon,2)}}<br/>{{number_format(@$value->VATDAWN,2)}}  </td>
            <td align="center"  > {{number_format(@$value->TotTon,2)}}<br/>{{number_format(@$value->TOTDAWN,2)}}</td>
            <td align="center"  >{{number_format(@$value->CRNOVAT,2)}} <br/>{{number_format(@$value->NETPROFIT,2)}} </td>
            <td align="center"  >{{number_format( @$value->CRVAT ,2)}} <br/> {{number_format(@$value->VATPRICE,2)}}</td>
            <td align="center"  > {{number_format(@$value->TOTCOST ,2)}} <br/>{{number_format(@$value->TOTPRC,2)}}</td>
            <td align="center"  > {{number_format(@$value->TonNoVat-@$value->CRNOVAT,2)}}<br/>{{number_format((@$value->TOTPRC-@$value->VATPRICE)-@$value->CRNOVAT,2)}}</td>
            <td align="center"  > {{number_format((@$value->TOTPRC-@$value->VATPRICE),2)}}<br/>{{number_format(@$value->balance,2)}}</td>
             
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
