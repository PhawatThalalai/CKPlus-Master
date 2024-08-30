<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name=Generator content="Microsoft Word 15 (filtered)">
    <title></title>
    <style>
      .t-table {      
        margin: 300px 10px 15pX 20px;
      }
    </style>
   </head>
  <body >
    @php
   
     $nameCom = $data->ContractToTypeLoan->TypeLoanToCompany->Company_Name;

  @endphp
        <!--111111-->
        <table border="0"  style="font-size: 11px">
        <tbody>
          <tr style="line-height: 75px">
            <th>
            </th>
          </tr>
        </tbody>
      </table>
        <table border="0"  style="font-size: 11px">
          <tbody>
            <tr>
              <th width="362px">
              </th>
            
              <th width="180px" >
                <b>สัญญาเลขที่ :&nbsp;&nbsp; {{ @$data->Contract_Con}}</b>
              </th>
            </tr>
            <tr>
              <th width="292px">
              </th>
              <th width="70px" rowspan="4">
                <img height="52" src="{{ getcwd().'/cache_barcode/'.$NamepathQr.'.svg' }}" alt="qrcode">
              </th>
              <th width="180px" >
                <b>ชื่อ - สกุล :&nbsp;&nbsp; {{@$data->ContractToCus->Name_Cus}}</b>
              </th>
            </tr>
            <tr>
              <th width="362px">
              </th>
              <th width="180px" >
                <b>จำนวนเงิน :&nbsp;&nbsp;{{number_format(@$data->ContractToCal->Period_Rate,2)}}
                  &nbsp;&nbsp; บาท </b>
              </th>
            </tr>
            <tr>
              <th width="362px">
              </th>
              <th width="180px" >
                <b>ชำระทุกวันที่ : &nbsp; {{substr(@$data->DateDue_Con,8,9)}} &nbsp; ของเดือน &nbsp; จำนวน&nbsp; {{number_format(@$data->ContractToCal->Timelack_Car,0)}}&nbsp; งวด</b>
              </th>
            </tr>
            <tr >
              <th width="362px">
              </th>
              <th width="150px" >
                <b>Biller ID  :&nbsp;&nbsp; {{$taxCom}} </b>
              </th>
            </tr>
            <tr  style="line-height:4px;">
              <th width="360px">
              </th>          
            </tr>
            <tr style="line-height:5px;font-size:8px;vertical-align:bottom;">
              <th width="250px" align="left">
              </th>
              <th width=""align="center"  >  
                <img  height="30" width="225" src="{{ getcwd().'/cache_barcode/'.$NamepathBr.'.png' }}" alt="barcode"   />
                <div>{{$Bar}}</div>      
              </th>
            </tr>
          </tbody>
        </table>
        <table border="0"  style="font-size: 11px">
          <tbody>
            <tr style="line-height: 110px">
              <th>
              </th>
            </tr>
          </tbody>
        </table>
        <table  border="0"  >
          <tbody>
            {{-- <tr style="line-height: 10px;">
              <th width="450px">           
              </th>
              <th width="100px" align="right">
              </th>
            </tr> --}}
            <tr >
              <th width="450px">           
              </th>
              <th width="100px" align="right">
              </th>
            </tr>
            <tr>
              <th></th>
            </tr>
            
            <tr>
              <th align="right"> สัญญาเลขที่&nbsp;&nbsp;&nbsp;<b>{{ @$data->Contract_Con}}</b></th>
            </tr>
            <tr>
              <th width="330px">
                ทำที่ {{@$nameCom}}          
              </th>
              <th  align="right">
                วันที่  <b>{{ $newDate = date("d-m-Y", strtotime(@$data->Date_con))}}</b>           
              </th>
            </tr>
            <tr >
              <th width="360px">
                &nbsp;&nbsp;&nbsp; ทำสัญญาฉบับนี้ทำขึ้นระหว่าง <b>{{$nameCom}}</b>
              </th>
              <th width="">
                ซึ่งต่อไปนี้ในสัญญาเรียกว่า “เจ้าของ” 
              </th>
            </tr>
            <tr>
              <th width="280px">
                ฝ่ายหนึ่ง กับ &nbsp;&nbsp;&nbsp;<b>{{@$data->ContractToCus->Prefix.@$data->ContractToCus->Name_Cus}}</b>
              </th>
              <th width="">
                  เลขบัตรประชาชนเลขที่ &nbsp;&nbsp;&nbsp;<b>{{textFormat(@$data->ContractToCus->IDCard_cus,'','')}}</b>
              </th>
            </tr>
            <tr style="line-height: 130%;">
              <th width="320px" rowspan="2">
                @php
                  $dataCusAdd = @$data->ContractToAddress;
                  $dataCus = @$data->ContractToCus;
                @endphp
                ที่อยู่เลขที่ <b>
                {{-- @$cusAdd->houseNumber_Adds." ม.".@$cusAdd->houseGroup_Adds." ต.".
                @$cusAdd->houseTambon_Adds." อ.".@$cusAdd->houseDistrict_Adds." จ.".
                @$cusAdd->houseProvince_Adds." ".@$cusAdd->Postal_Adds --}}
                @php
                  $chkNull = [NULL,'-'] ;  
                 
                @endphp 
                @if(@$dataCusAdd!=NULL)
                {{-- @foreach(@$dataCus->DataCusToDataCusAddsMany as $dataCusAdd)
                  @if($dataCusAdd->Status_Adds != 'inactive' and $dataCusAdd->Type_Adds == 'ADR-0002' ) --}}
                  {{
                  (@$dataCusAdd->houseNumber_Adds != NULL ? @$dataCusAdd->houseNumber_Adds : ''). ' ' .
                  (@$dataCusAdd->houseGroup_Adds != NULL ? "ม.".@$dataCusAdd->houseGroup_Adds : ''). ' ' .
                  (@$dataCusAdd->building_Adds != NULL ? "อาคาร".@$dataCusAdd->building_Adds : ''). ' ' .
                  (@$dataCusAdd->village_Adds != NULL ? "หมู่บ้าน".@$dataCusAdd->village_Adds : ''). ' ' .
                  (@$dataCusAdd->roomNumber_Adds != NULL ? "เลขห้อง". @$dataCusAdd->roomNumber_Adds : ''). ' ' .
                  (@$dataCusAdd->Floor_Adds != NULL ? "ชั้น".@$dataCusAdd->Floor_Adds : ''). ' ' .
                  (@$dataCusAdd->alley_Adds != NULL ? "ซ.".@$dataCusAdd->alley_Adds : ''). ' ' .
                  (@$dataCusAdd->road_Adds != NULL ? "ถ.".@$dataCusAdd->road_Adds : ''). ' ' .
                  (@$dataCusAdd->houseTambon_Adds != NULL ? "ต.".@$dataCusAdd->houseTambon_Adds : ''). ' ' .
                  (@$dataCusAdd->houseDistrict_Adds != NULL ? "อ.".@$dataCusAdd->houseDistrict_Adds : ''). ' ' .
                  (@$dataCusAdd->houseProvince_Adds != NULL ? "จ.". @$dataCusAdd->houseProvince_Adds : ''). ' ' .
                  (@$dataCusAdd->Postal_Adds != NULL ? @$dataCusAdd->Postal_Adds : '') 
                }}
                  {{-- @endif
                @endforeach --}}
                @endif
              </b>
              </th>
              <th width="">
                ซึ่งต่อไปนี้ในสัญญาเรียกว่า “ผู้กู้”
              </th>
            </tr>
            <tr >
              <th>
              </th>
            </tr>
            <tr>
              <th width="" >
                ฝ่ายหนึ่ง ทั้งสองฝ่ายได้ตกลงทำสัญญา ปรากฏข้อความดังต่อไปนี้
              </th>
            </tr>
            <tr>
              <th width="" >
                ข้อ1.เจ้าของตกลงให้เงินกู้ เเละผู้กู้ตกลงกู้ ปรากฏรายละเอียดทรัพย์สินที่นำมากู้ เเละเงินกู้ดังนี้
              </th>
            </tr>
            
            <tr >
              <th>
              </th>
            </tr>
            <tr >
              <th width="250px" align="center"><b>รายละเอียดทรัพย์สิน</b></th>
              <th width="250px" align="center"><b>รายละเอียดเงินกู้ และการชำระเงิน</b></th>
            </tr>
            @php
              $asset = @$data->ContractToIndenAsst[0]->IndenAssetToDataOwner;
              if(!empty($asset)){                 
                                           
                if(@$asset->OwnershipToAsset->TypeAsset_Code == "land"){
                  // $licence = @$asset->OwnershipToAsset->Land_Id;
                  //  $typeAsset = @$asset->OwnershipToAsset->DataAssetToLandType->nametype_car;
                  //  @$brand = @$asset->OwnershipToAsset->Land_SizeRai.' ไร่ '.@$asset->OwnershipToAsset->Land_SizeNgan.' งาน'.@$asset->OwnershipToAsset->Land_SizeSquareWa.' ตรว.' ;
                  $dataLand = \DB::select("SELECT * FROM View_AssetConGroup WHERE CONTNO = '".@$data->Contract_Con."'");
                  $licence = @$dataLand[0]->lincense;
                  $typeAsset = @$dataLand[0]->typeland;
                  $brand = @$dataLand[0]->sizeLand;
                  
                }elseif(@$asset->OwnershipToAsset->TypeAsset_Code == "car" || @$asset->OwnershipToAsset->TypeAsset_Code == "moto"){
                  $typeAsset = @$asset->OwnershipToAsset->DataAssetToRateType->nametype_car;     
                    if($asset->OwnershipToAsset->Vehicle_NewLicense != NULL ){
                        $licence = @$asset->OwnershipToAsset->Vehicle_NewLicense;
                    }else{
                      $licence = @$asset->OwnershipToAsset->Vehicle_OldLicense;
                    }
                    
                    if(@$asset->OwnershipToAsset->TypeAsset_Code == "car"){
                      $brand = @$asset->OwnershipToAsset->AssetToCarBrand->Brand_car;
                      $year = @$asset->OwnershipToAsset->AssetToCarYear->Year_car;
                      $model = @$asset->OwnershipToAsset->AssetToCarModel->Model_car;
                    }else{
                      $brand = @$asset->OwnershipToAsset->AssetToMotoBrand->Brand_moto;
                      $year  = @$asset->OwnershipToAsset->AssetToMotoYear->Year_moto;
                      $model = @$asset->OwnershipToAsset->AssetToMotoModel->Model_moto;
                    }
                    $Vehicle_Color = @$asset->OwnershipToAsset->Vehicle_Color;
                    $Vehicle_Chassis = @$asset->OwnershipToAsset->Vehicle_Chassis;
                    $Vehicle_Engine =  @$asset->OwnershipToAsset->Vehicle_Engine;
                }
              }    
            @endphp
            <tr>
              <th width="130px" >
                ประเภท รถ / ที่ดิน
              </th>
              <th width="100px" >
                {{@$typeAsset}}
              </th>

              <th width="130px">
                ยอดจัด
              </th>
               <th width="130px" align="right"> {{--+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance)+floatval(@$data->ContractToCal->Insurance_PA)) --}}
                @if( @$data->ContractToCal->Buy_PA == "Yes" && @$data->ContractToCal->Include_PA == "Yes" )
                  {{-- ซื้อประกัน และ รวมประกันในยอดจัด --}}
                  {{number_format((floatval(@$data->ContractToCal->Cash_Car)+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance)+floatval(@$data->ContractToCal->Insurance_PA)),2)}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; บาท
                @elseif( @$data->ContractToCal->Buy_PA == "Yes" && @$data->ContractToCal->Include_PA == "No" )
                  {{-- ซื้อประกัน และ ไม่รวมประกันในยอดจัด --}}
                  {{number_format((floatval(@$data->ContractToCal->Cash_Car)+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance)),2)}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; บาท
                @else
                  {{-- ไม่เข้าเงื่อนไขเลย เป็นค่าเริ่มต้น --}}
                  {{number_format((floatval(@$data->ContractToCal->Cash_Car)+floatval(@$data->ContractToCal->Process_Car)+floatval(@$data->ContractToCal->Insurance)+floatval(@$data->ContractToCal->Insurance_PA)),2)}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; บาท
                @endif
              </th>
            </tr>
            <tr>
              <th width="130px" >
                เลขทะเบียน / เลขที่โฉนด
              </th>
              <th width="100px" >
                {{@$licence}}
              </th>
              {{-- <th width="130px">
                ค่าดำเนินการ
              </th>
              <th width="130px" align="right">
                {{ Str::upper(@$data->ContractToCal->StatusProcess_Car) == 'YES'?number_format(@$data->ContractToCal->Process_Car,2):0}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; บาท
              </th> --}}
              <th width="130px">
                หักค่าใช้จ่าย
              </th>
              <th width="130px" align="right">
                {{number_format(@$data->ContractToOperated->Total_Price,2)}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; บาท
              </th> 
            </tr>
            <tr>
              <th width="130px" >
                ยี่ห้อรถ  / ขนาดที่ดิน
              </th>
              <th width="100px" >
                {{@$brand}}
              </th>
              {{-- <th width="130px">
                ประกัน PA
              </th>
              <th width="130px" align="right">
                {{ Str::upper(@$data->ContractToCal->Include_PA) == 'YES'?number_format(@$data->ContractToCal->Insurance_PA,2):0}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; บาท
              </th> --}}
              <th width="130px">
                ได้รับเงิน ณ วันทำสัญญา
              </th>
              <th width="130px" align="right">
                {{number_format(@$data->ContractToOperated->Balance_Price,2)}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; บาท
              </th>
            </tr>
            <tr>
              <th width="50px" >
              รุ่นรถ
              </th>
              <th width="180px" rowspan="2" >
                {{@$model}}
              </th>
              @php
               $loanCode = ['08', '09', '10', '18', '16'];
                  if ($data->ContractToTypeLoan->Loan_Com == 1) {
                     
                      $periodNonVat = @$data->ContractToCal->Period_Rate;
                      $totalRate = floatval(@$data->ContractToCal->Cash_Car) + floatval(@$data->ContractToCal->Process_Car) + floatval(@$data->ContractToCal->Insurance) + floatval(@$data->ContractToCal->Insurance_PA);

                      if (in_array($data->CodeLoan_Con, $loanCode)) {
                          $irrYear = number_format(((@$data->ContractToCal->Profit_Rate / @$totalRate) * 100) / 12, 6);
                      } else {
                          $irrYear = number_format(uft_Calculate_IRR(intval(@$data->ContractToCal->Timelack_Car), -floatval(@$periodNonVat), ($totalRate)), 6);
                      }
                  } else {
                    
                      $periodNonVat = @$data->ContractToCal->Duerate_Rate;

                      $totalRate = floatval(@$data->ContractToCal->Cash_Car) + floatval(@$data->ContractToCal->Process_Car) + floatval(@$data->ContractToCal->Insurance) + floatval(@$data->ContractToCal->Insurance_PA);
                      $irrYear = number_format(uft_Calculate_IRR(intval(@$data->ContractToCal->Timelack_Car), -floatval(@$periodNonVat), ($totalRate)), 6);
                  }   
              @endphp
              <th width="50px">
                ดอกเบี้ย
              </th>
              <th width="200px" align="right">
                {{number_format($irrYear/12,4)}}% &nbsp; ต่อเดือน  ระยะเวลา {{@$data->ContractToCal->Timelack_Car}} &nbsp; เดือน
              </th>
              {{-- <th width="130px">
                ระยะเวลาเช่าซื้อ/ผ่อนเงินกู้
              </th>
              <th width="130px" align="right">
                {{@$data->ContractToCal->Timelack_Car}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; เดือน
              </th> --}}
            </tr>
            <tr>
              <th width="250px" >
              
              </th>
              <th width="130px">
                ราคาเช่าซื้อ/เงินกู้ทั้งสัญญา
              </th>
              <th width="130px" align="right">
                {{number_format(@$data->ContractToCal->TotalPeriod_Rate,2)}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; บาท
              </th>
            
            </tr>
            <tr>
              <th width="250px" >
                ปี  &nbsp;&nbsp;&nbsp;&nbsp; {{@$year}} &nbsp;&nbsp;&nbsp;&nbsp; สี &nbsp;&nbsp;&nbsp;&nbsp; {{@$Vehicle_Color}}
              </th>
              <th width="130px">
                ค่าเช่าซื้อ/ผ่อน เดือนละ
              </th>
              <th width="130px" align="right">
                {{number_format(@$data->ContractToCal->Period_Rate,2)}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; บาท
              </th>
            
            </tr>
            <tr>
              <th width="100px" >
                หมายเลขเครื่องยนต์
              </th>
              <th width="150px" >
                {{@$Vehicle_Engine}}
              </th>
              <th width="130px">
                ชำระทุกวันที่
              </th>
              <th width="130px" align="right">
                {{substr(@$data->DateDue_Con,8,9)}} &nbsp;&nbsp; ของเดือน
              </th>
            </tr>
            <tr>
              <th width="100px" >
                หมายเลขตัวถัง
              </th>
              <th width="150px" >
                {{@$Vehicle_Chassis}}
              </th>
              <th width="130px">
               ประกัน PA
              </th>
              <th width="130px" align="right">
                @if(strtoupper(@$data->ContractToCal->Buy_PA) == 'YES')
                  {{@$data->ContractToCal->DataCalcuToPA->Plan_Insur."   ".number_format(@$data->ContractToCal->DataCalcuToPA->Limit_Insur)}}  บาท
                @endif
                </th>
            </tr>           
          </tbody>
        </table>
      
        <table>
          <tr><th width="80px"><strong>ค่าใช้จ่าย</strong></th></tr>
          <tr>
           
            
            <th width="500px" >
            @if(@$data->ContractToOperated->Act_Price>0)
              พรบ. :	{{number_format(@$data->ContractToOperated->Act_Price,0)."   "}}
            @endif
            @if(@$data->ContractToOperated->Duty_Price>0)
              ประเมิน : {{number_format(@$data->ContractToOperated->Evaluetion_Price,0 )."   "}}    
            @endif
            @if(@$data->ContractToOperated->P2_Price>0)
           
              ประกันรถ : {{number_format(@$data->ContractToOperated->P2_Price,0)."   "}}
           
            @endif
            @if(@$data->ContractToOperated->AccountClose_Price>0)
      
              ยอดปิดบัญชี : {{number_format(@$data->ContractToOperated->AccountClose_Price+@$data->ContractToOperated->AccountClose_Price_fee,0)."   "}}
        
            @endif
         
            </th>
            
          </tr> 
          <tr>
            <th width="500px" >
            @if(@$data->ContractToOperated->Tax_Price>0)           
              ภาษี. : {{number_format(@$data->ContractToOperated->Tax_Price,0)."   "}}        
            @endif
            @if(@$data->ContractToOperated->Tran_Price>0)
        
              ค่าขนส่ง. : {{number_format(@$data->ContractToOperated->Tran_Price,0)."   " }}            
            @endif
            @if(@$data->ContractToOperated->Evaluetion_Price>0)                     
              อากร : {{number_format(@$data->ContractToOperated->Duty_Price,0)."   " }}        
            @endif
            @if(@$data->ContractToOperated->Insurance_PA>0)        
              PA : {{number_format(@$data->ContractToOperated->Insurance_PA,0)."   " }}           
            @endif
            @if(@$data->ContractToOperated->Process_Price>0)           
              ค่าดำเนินการ : {{number_format(@$data->ContractToOperated->Process_Price,0)."   " }}            
            @endif
            @if(@$data->ContractToOperated->Downpay_Price>0)
              เงินดาวน์ : {{number_format(@$data->ContractToOperated->Downpay_Price,0)."   " }}            
            @endif
          </th>
          </tr> 
          <tr>
            <th width="80px" >
              	
            </th>
            <th width="80px" >
             
            </th>
            <th width="80px">
             
            </th>
          
            <th width="130px" align="right">
              รวมค่าใช้จ่าย : {{number_format(@$data->ContractToOperated->Total_Price,2)}}
            </th>
            <th width="130px" align="right">
              ยอดสุทธิ : {{number_format(@$data->ContractToOperated->Balance_Price,2)}}
            </th>
          </tr> 
        </table>
      
  </body>
</html>

