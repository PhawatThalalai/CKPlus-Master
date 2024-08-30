<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
    <label align="right">พิมพ์ : {{formatDateThaiLongPS(date('Y-m-d'))}}</label>
      <h1 class="card-title p-3" style="line-height: 5px;">รายงาน ออกใบกำกับค่างวดปกติ</h1>
      <p class="card-title" align="left" style="line-height: -5px;">จากวันที่ {{ formatDateThaiShort_monthNum($start) }} ถึงวันที่ {{ formatDateThaiShort_monthNum($end) }}</p>
      <hr>
  <body>
      <br>
      <table border="1">
        <!-- <thead> -->
          <tr style="background-color:#DFC7FB;">
            <td width="30px;"> <b>ลำดับ</b></td>
            <td width="80px;"> <b>วันที่ออกใบกำกับ</b></td>
            <td width="90px;"> <b>เลขใบกำกับภาษี</b></td>
            <td width="45px;"> <b>สาขา</b></td>
            <td width="70px;"> <b>เลขที่สัญญา</b></td>
            <td width="160px;"> <b>ชื่อ-สกุล</b></td>
            <td width="60px;"> <b>NETAMT</b></td>
            <td width="60px;"> <b>VATAMT</b></td>
            <td width="60px;"> <b>TOTAMT</b></td>
            <td width="35px;"> <b>FPAR</b></td>
            <td width="35px;"> <b>FPAY</b></td>
            <td width="35px;"> <b>LPAR</b></td>
            <td width="35px;"> <b>LPAY</b></td>
          </tr>
        <!-- </thead> -->
        <tbody>
          @foreach($data as $key => $value)
            @php
              @$totalNETAMT += @$value->NETAMT; 
              @$totalVATAMT += @$value->VATAMT;
              @$totalTOTAMT += @$value->TOTAMT;
            @endphp
            <tr>
              <td width="30px;" align="center">{{@$key+1}}</td>
              <td width="80px;" align="center"> {{formatDateThaiShort_monthNum(@$value->TAXDT)}}</td>
              <td width="90px;" align="left"> {{@$value->TAXNO}}</td>
              <td width="45px;" align="left"> {{@$value->NickName_Branch}}</td>
              <td width="70px;" align="left"> {{@$value->CONTNO}}</td>
              <td width="160px;" align="left"> {{@$value->prefix.@$value->firstname_cus.'     '.@$value->surname_cus}}</td>
              <td width="60px;" align="right"> {{number_format(@$value->NETAMT,2)}}&nbsp;&nbsp;</td>
              <td width="60px;" align="right"> {{number_format(@$value->VATAMT,2)}}&nbsp;&nbsp;</td>
              <td width="60px;" align="right"> {{number_format(@$value->TOTAMT,2)}}&nbsp;&nbsp;</td>
              <td width="35px;" align="center"> {{@$value->FPAR}}</td>
              <td width="35px;" align="center"> {{@$value->FPAY}}</td>
              <td width="35px;" align="center"> {{@$value->LPAR}}</td>
              <td width="35px;" align="center"> {{@$value->LPAY}}</td>
            </tr>
          @endforeach
            <tr>
              <td width="475px;" colspan="6" style="background-color:#DFC7FB;"></td>
              <td width="60px;" align="right"> {{number_format(@$totalNETAMT,2)}}&nbsp;&nbsp;</td>
              <td width="60px;" align="right"> {{number_format(@$totalVATAMT,2)}}&nbsp;&nbsp;</td>
              <td width="60px;" align="right"> {{number_format(@$totalTOTAMT,2)}}&nbsp;&nbsp;</td>
              <td width="140px;" style="background-color:#DFC7FB;"></td>
            </tr>
        </tbody>
      </table>
  </body>
</html>