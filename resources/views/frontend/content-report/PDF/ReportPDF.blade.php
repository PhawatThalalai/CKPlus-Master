<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
    <div class="form-inline"  style="line-height:-30%;">
      <h4>รายการ Score Credo</h4> 
      <label align="right">วันที่พิมพ์ : {{FormatDatethaiLong(date('d-m-Y'))}}</label>
    </div>
  <hr style="line-height:45%;">
  <body>
  <p style="line-height:20%;" align="right">ผู้พิมพ์ : {{auth()->user()->name}}</p>
  <!-- <h5 style="line-height:-5px;">รวม {{@count(@$data)}} รายการ</h5> -->
  <table border="1">
    <thead>
      <tr style="line-height: 150%;background-color:#F2F0EF;">
        <th align="center" width="30px"><b>ลำดับ</b></th>
        <th align="center" width="120px"><b>ชื่อลูกค้า</b></th>
        <th align="center" width="120px"><b>เบอร์โทร</b></th>
        <th align="center" width="80px"><b>Credo Code</b></th>
        <th align="center" width="60px"><b>Credo Score</b></th>
        <th align="center" width="70px"><b>ยอดจัด</b></th>
        <th align="center" width="80px"><b>เปอร์เซ็นต์ยอดจัด</b></th>
      </tr>
    </thead>
    <tbody>
      @php 
        @$i = 1;
      @endphp
      @foreach($data as $key => $value)
        @if(@$value->DataCusToDataCusTag->Credo_Status != NULL)
          @php 
            @$TotalCash += $value->DataCusToDataCusTag->DataCusTagToDataCulcu->Cash_Car;
          @endphp
          <tr style="line-height: 150%">
            <td align="center" width="30px">{{@$i++}}</td>
            <td align="left" width="120px"> {{@$value->Name_Cus}}</td>
            <td align="left" width="120px"> {{@$value->Phone_cus}}</td>
            <td align="left" width="80px"> {{@$value->DataCusToDataCusTag->Credo_Code}}</td>
            <td align="center" width="60px"> {{@$value->DataCusToDataCusTag->Credo_Score}}</td>
            <td align="center" width="70px"> {{number_format(@$value->DataCusToDataCusTag->DataCusTagToDataCulcu->Cash_Car,2)}}</td>
            <td align="center" width="80px"> {{number_format(@$value->DataCusToDataCusTag->DataCusTagToDataCulcu->Percent_Car)}} %</td>
          </tr>
        @endif
        @php 
          @$Count = $i - 1;
        @endphp
      @endforeach
          <tr style="line-height: 150%">
            <td align="center" width="150px">รวม {{@$Count}} ราย</td>
            <td align="center" width="410px">รวมยอดจัด {{number_format(@$TotalCash)}} บาท</td>
          </tr>
    </tbody>
  </table> 
  <br>
</body>
</html>
