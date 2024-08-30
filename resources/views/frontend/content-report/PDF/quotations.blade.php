<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name=Generator content="Microsoft Word 15 (filtered)">
    <title></title>
  </head>
  <body>
    <table border="0">
      @php


          $namecomp = @$data->TagToCulculate->DataCalcuToTypeLoan->TypeLoanToCompany;
          $logo = getcwd().'\assets\images\leasingLogo1.jpg';
        
      @endphp
      <tbody>
        <tr>
          <td width="100" rowspan="4"><img class="center" width="150"  src="{{ $logo}}"></td>
          <td width="600" align="left">&nbsp;&nbsp;&nbsp; {{@$namecomp->Company_Name}}</td>         
        </tr>
        <tr >
        
          <td width="600"  align="left">&nbsp;&nbsp;&nbsp;{{ @$namecomp->Company_Addr}}</td>
        </tr>
        <tr >
          
          <td width="600"  align="left">&nbsp;&nbsp;&nbsp; โทร.&nbsp; {{@$namecomp->Company_Tel}}</td>
        </tr>
        <tr >
          
          <td width="600"  align="left">&nbsp;&nbsp;&nbsp; เว็บไซต์ : www.chookiatleasing.com   Page: www.facebook.com/chookiatleasing</td>
        </tr>
        <tr >
          <td></td>
        </tr>
      </tbody>
    </table>
    <br>

    <table border="0" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid">
      <tbody>
        <tr style="line-height: 200%; background-color: #D9E2F3;">
          <th width="100%" align="center" colspan="5">
              ใบเสนอราคา {{@$data->TagToCulculate->DataCalcuToTypeLoan->Loan_Name}}
          </th>
        </tr>
        <tr>
          <th></th>
          <th></th>
          <th></th>
          
          <th colspan="2"  align="left">วันที่เอกสาร &nbsp;&nbsp;&nbsp;{{@$data->date_Tag}}</th>
        </tr>
        <tr>
          <th align="left" width="15%">ชื่อลูกค้า</th>
          <th align="left">{{@$data->TagToDataCus->Name_Cus}}</th>
          <th align="left" colspan="2">          
         </th>
          
          <th></th>
        </tr>
        <tr>
          <th align="left">โทรศัพท์</th>
          <th align="left">{{@$data->TagToDataCus->Phone_cus}}</th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
        @if(@$data->TagToCulculate->DataCalcuToTypeLoan->id_rateType=='car'||@$data->TagToCulculate->DataCalcuToTypeLoan->id_rateType=='moto')
          @php
              if(@$data->TagToCulculate->DataCalcuToTypeLoan->id_rateType=='car'){
                $brand = @$data->TagToCulculate->DataCalcuToCarYear->yearToBrandCar->Brand_car;
                $model = @$data->TagToCulculate->DataCalcuToCarYear->yearToModelCar->Model_car;
                $year = @$data->TagToCulculate->DataCalcuToCarYear->Year_car;
              }else{
                $brand = @$data->TagToCulculate->DataCalcuToMotoYear->yearToBrandMoto->Brand_moto;
                $model = @$data->TagToCulculate->DataCalcuToMotoYear->yearToModelMoto->Model_moto;
                $year = @$data->TagToCulculate->DataCalcuToMotoYear->Year_moto;
              }
          @endphp
        <tr>
          <th align="left">ยี่ห้อรถ</th>
          <th align="left">{{@$brand}}</th>
          <th align="left" width="30%">รุ่นรถ &nbsp;&nbsp;{{@$model}}</th>
          <th align="left">ปี &nbsp;&nbsp;&nbsp;{{@$year }}</th>
          <th align="left"></th>
        </tr>
        <tr>
          <th align="left">วันที่ครอบครอง</th>
          <th align="left">{{@$data->TagToCulculate->DateOccupiedcar}}</th>
          <th align="left"></th>
          <th align="left"></th>
          <th></th>
        </tr>
        {{-- @elseif($dataCus->TypeEstate != "person")
        <tr>
          <th align="left">ประเภทที่ดิน</th>
          <th align="left">{{$land->nametype_car}}</th>
          <th align="left">เลขที่ดิน </th>
          <th align="left">{{$dataCus->Id_Land}}</th>
          <th align="left"> &nbsp;&nbsp;&nbsp;</th>
        </tr>
        <tr>
          <th align="left">ขนาดที่ดิน</th>
          <th align="left">{{$dataCus->Size_Land}}</th>
          <th align="left">วันที่ครอบครอง</th>
          <th align="left">{{$dataCus->DateOccupiedcar}}</th>
          <th></th>
        </tr>--}}
        @endif 
        <tr>
          <th colspan="5" align="left">ข้อมูลไฟแนนท์</th>
        </tr>
        {{-- @if($dataCus->TypeEstate != "person")
        <tr>
          <th align="left">เรทยอดจัด	</th>
          <th align="left">{{number_format($data->Pricerate_car,2)}} &nbsp; บาท</th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
        @endif --}}
        @php
          $paCash = (@$data->TagToCulculate->Buy_PA == "yes" && @$data->TagToCulculate->Include_PA == "yes")? @$data->TagToCulculate->Insurance_PA:0;    
          $pa = @$data->TagToCulculate->Buy_PA == "yes"? @$data->TagToCulculate->Insurance_PA:0;    

       @endphp
       <tr>
          <th align="left">ยอดจัด</th>
          <th align="left">{{number_format((@$data->TagToCulculate->Cash_Car+@$data->TagToCulculate->Process_Car+$paCash),2)}} &nbsp; บาท</th>
          <th align="left">ประกัน PA&nbsp; {{ number_format($pa,0)}} &nbsp;บาท</th>
          <th align="left">ระยะเวลา&nbsp; {{@$data->TagToCulculate->Timelack_Car}} &nbsp; เดือน</th>
          <th></th>
        </tr>
        <tr>
          <th align="left">ดอกเบี้ย</th>
          <th align="left">{{number_format(@$data->TagToCulculate->totalInterest_Car,3)}} &nbsp; ต่อเดือน</th>
          <th align="left">ผ่อนเดือนละ  &nbsp;{{number_format(@$data->TagToCulculate->Period_Rate,0)}} &nbsp; บาท</th>
          <th align="left"></th>
          <th></th>
        </tr>
        <tr >
          <th></th>
          <th></th>
          <th></th>
          <th></th>
          <th></th>
        </tr>
        <tr>
          <th align="left">พนักงาน  </th>
          <th align="left">{{@$data->UserInsert}}</th>
          <th align="left" >สาขา &nbsp;&nbsp;{{@$data->TagToCulculate->DataCalcuToBranch->Name_Branch}}</th>
          <th align="left"></th>
          <th></th>
        </tr>
        
      </tbody>
    </table>

    <p style="border-style: dashed;"></p>
    <br>
    <table border="1" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid;font-size:small">
      <tbody>
        <tr style="line-height: 200%; background-color: #D9E2F3;">
          <th rowspan="2" align="center">เอกสารลูกค้า</th>
          <th colspan="2" align="center">ทรัพย์สิน</th>          
        </tr>
        <tr  style="line-height: 200%; background-color: #D9E2F3;">
          
          <th align="center">รถยนต์ / มอเตอร์ไซต์</th>
          <th align="center">ที่ดิน</th>
        </tr>
        <tr>
          <th align="left">บัตรประชาชน ผู้กู้ ผู้ค้ำประกัน ตัวจริง</th>
          <th align="left">เล่มทะเบียนตัวจริง</th>
          <th align="left">โฉนด หรือ นส 3 ตัวจริง</th>
        </tr >
        <tr align="left">
          <th >ทะเบียนบ้าน ผู้กู้ ผู้ค้ำประกัน ตัวจริง</th>
          <th>เอกสารสัญญาเช่าซื้อ (รีไฟแนนท์)</th>
          <th>มีถนนคอนกรีตหรือ ถนนลาดยางตัดผ่าน</th>
        </tr>
        <tr align="left">
          <th>อายุ 25 – 60 ปี</th>
          <th>ใบเสร็จค่างวด 3 งวดล่าสุด  (รีไฟแนนท์)</th>
          <th>ใบประเมินราคาที่ดิน โดยต้องเป็นเดือนเดียวกับที่อนุมัติเงินกู้</th>
        </tr>
        <tr align="left">
          <th>ภูมิลำเนาอยู่ในจังหวัดที่สาขาตั้งอยู่</th>
          <th>เอกสารประกอบที่มารายได้</th>
          <th>ใบเสร็จ การประเมินราคาที่ดิน</th>
        </tr>
        <tr align="left">
          <th></th>
          <th></th>
          <th>ใบระวาง</th>
        </tr>
        
      </tbody>
    </table>
    
    <br>
    <br>
    <p >หมายเหตุ : เอกสารฉบับนี้มีอายุ 1 เดือนจากวันที่เอกสาร โปรโมชั่น หรือดอกเบี้ย อาจปรับเปลี่ยนตามที่บริษัทกำหนด</p>

  </body>
</html>

