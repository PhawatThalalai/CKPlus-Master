<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    @php 
    //dd(@$data->PactToCus->DataCusToDataAssetOne);
      @$NameCus = @$data->PactToCus->Firstname_Cus.'  '.@$data->PactToCus->Surname_Cus;
      @$Grantor1 = @$data->PatchToPact->ContractToGuarantor[0]->GuarantorToGuarantorCus->Firstname_Cus.'  '.@$data->PatchToPact->ContractToGuarantor[0]->GuarantorToGuarantorCus->Surname_Cus;
      @$Grantor2 = @$data->PatchToPact->ContractToGuarantor[1]->GuarantorToGuarantorCus->Firstname_Cus.'  '.@$data->PatchToPact->ContractToGuarantor[1]->GuarantorToGuarantorCus->Surname_Cus;
      @$BrandCar = @$data->PactToCus->DataCusToDataAssetOne->AssetToCarBrand->Brand_car;
      @$LicenseCar = (@$data->PactToCus->DataCusToDataAssetOne->Vehicle_NewLicense != NULL)?@$data->PactToCus->DataCusToDataAssetOne->Vehicle_NewLicense :@$data->PactToCus->DataCusToDataAssetOne->Vehicle_OldLicense; 
      @$TankCar = @$data->PactToCus->DataCusToDataAssetOne->Vehicle_Chassis;
      @$EngineCar = @$data->PactToCus->DataCusToDataAssetOne->Vehicle_Engine;
      @$ColorCar = @$data->PactToCus->DataCusToDataAssetOne->Vehicle_Color;

      @$count_Namecus = strlen(@$NameCus);

      if(@$codloan == 2){
        @$DATE_FRM = \App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_paydue::where('PatchCon_id',$data->id)->where('nopay',number_format(@$data->EXP_FRM,0))->first();
        @$DATE_TO = \App\Models\TB_PatchContracts\TB_InsideContracts\PatchHP_paydue::where('PatchCon_id',$data->id)->where('nopay',number_format(@$data->EXP_TO,0))->first();
      }else{
        @$DATE_FRM = \App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_paydue::where('PatchCon_id',$data->id)->where('nopay',number_format(@$data->EXP_FRM,0))->first();
        @$DATE_TO = \App\Models\TB_PatchContracts\TB_InsideContracts\PatchPSL_paydue::where('PatchCon_id',$data->id)->where('nopay',number_format(@$data->EXP_TO,0))->first();
      }

    @endphp
    @if(@$codloan == 2)
    {{@$codloan}}
    @else
      <table border="0" width="540px">
          <tr>
            <td align="center" colspan="2"><h1>{{@$dataComp->Company_Name}}</h1></td>
          </tr>
          <tr>
            <td align="center" colspan="2"><h3>{{@$dataComp->Company_Addr}} โทร {{@$dataComp->Company_fax}}</h3></td>
          </tr>
          <tr>
            <td align="center" colspan="2"></td>
          </tr>
          <tr>
            <td align="center" colspan="2"><hr height="2"></td>
          </tr>
          <tr>
            <td width="20px"></td>
            <td width="520px"><b>{{@$data->CONTNO}}</b></td>
          </tr>
          <tr>
            <td align="right" colspan="2">วันที่ {{(@$datePrint != NULL)?formatDateThaiLong(@$datePrint):formatDateThaiLong(date('d-m-Y'))}}</td>
          </tr>
          <tr>
            <td align="right" colspan="2"></td>
          </tr>
          <tr>
            <td width="20px"></td>
            <td width="60px" align="left">เรื่อง</td>
            <td width="460px">ขอยืนยันการบอกเลิกสัญญา</td>
          </tr>
          <tr>
            <td width="20px"></td>
            <td width="60px" align="left">เรียน</td>
            <td width="150px">1.คุณ{{@$NameCus}}</td>
            <td width="310px" align="left">ผู้เช่าซื้อ</td>
          </tr>
          <tr>
            <td width="20px"></td>
            <td width="60px" align="left"></td>
            <td width="150px">2.คุณ{{@$Grantor1}}</td>
            <td width="310px" align="left">ผู้ค้ำประกัน</td>
          </tr>
          @if(@$data->PatchToPact->ContractToGuarantor[1] != NULL)
          <tr>
            <td width="20px"></td>
            <td width="60px" align="left"></td>
            <td width="150px">3.คุณ{{@$Grantor2}}</td>
            <td width="310px" align="left">ผู้ค้ำประกัน</td>
          </tr>
          @endif
          <tr>
            <td align="right" width="540px" colspan="2"></td>
          </tr>
          <tr>
            <td width="50px"></td>
            <td width="25px" align="left">ตามที่</td>
            @php 
              $data_1 = @$NameCus;
              $str_1 = strlen($data_1);
            @endphp
            <td width="100px" align="center" style="{{ $str_1 > 0 && $str_1 <= 47 ? 'letter-spacing: -0.1px;' : ($str_1 > 47 && $str_1 <= 50 ? 'letter-spacing: -0.4px;' : ($str_1 > 50 && $str_1 <= 53 ? 'letter-spacing: -0.7px;' : '')) }}">
              <b>คุณ{{$data_1}}</b>
            </td>
            <td width="140px" align="left">ได้ตกลงทำสัญญาเช่าซื้อรถยนต์ยี่ห้อ</td>
            @php 
              $data_2 = @$BrandCar;
              $str_2 = strlen($data_2);
            @endphp
            <td width="70px" align="center" style="{{ $str_2 > 0 && $str_2 <= 47 ? 'letter-spacing: -0.1px;' : ($str_2 > 47 && $str_2 <= 50 ? 'letter-spacing: -0.4px;' : ($str_2 > 50 && $str_2 <= 53 ? 'letter-spacing: -0.7px;' : '')) }}">
              <b>{{@$data_2}}</b>
            </td>
            <td width="73px" align="left">หมายเลขทะเบียน</td>
            @php 
              $data_3 = @$LicenseCar;
              $str_3 = strlen($data_3);
            @endphp
            <td width="82px" align="right" style="{{ $str_3 > 0 && $str_3 <= 47 ? 'letter-spacing: -0.1px;' : ($str_3 > 47 && $str_3 <= 50 ? 'letter-spacing: -0.4px;' : ($str_3 > 50 && $str_3 <= 53 ? 'letter-spacing: -0.7px;' : '')) }}">
              <b>{{@$data_3}}</b>
            </td>
          </tr>
          <tr style="letter-spacing: 100%;">
            <td width="60px" align="left">หมายเลขตัวถัง</td>
            @php 
              $data_4 = @$TankCar;
              $str_4 = strlen($data_4);
            @endphp
            <td width="120px" align="left" style="{{ $str_4 > 0 && $str_4 <= 47 ? 'letter-spacing: -0.1px;' : ($str_4 > 47 && $str_4 <= 50 ? 'letter-spacing: -0.4px;' : ($str_4 > 50 && $str_4 <= 53 ? 'letter-spacing: -0.7px;' : '')) }}">
              <b>{{@$data_4}}</b>
            </td>
            <td width="64px" align="left">หมายเลขเครื่อง</td>
            @php 
              $data_5 = @$EngineCar;
              $str_5 = strlen($data_5);
            @endphp
            <td width="70px" align="left" style="{{ $str_5 > 0 && $str_5 <= 47 ? 'letter-spacing: -0.1px;' : ($str_5 > 47 && $str_5 <= 50 ? 'letter-spacing: -0.4px;' : ($str_5 > 50 && $str_5 <= 53 ? 'letter-spacing: -0.7px;' : '')) }}">
              <b>{{@$data_5}}</b>
            </td>
            @php 
              $data_6 = @$ColorCar;
              $str_6 = strlen($data_6);
            @endphp
            <td width="65px" align="left" style="{{ $str_6 > 0 && $str_6 <= 47 ? 'letter-spacing: -0.1px;' : ($str_6 > 47 && $str_6 <= 50 ? 'letter-spacing: -0.4px;' : ($str_6 > 50 && $str_6 <= 53 ? 'letter-spacing: -0.7px;' : '')) }}">
              สี<b>{{@$data_6}}</b>
            </td>
            @php 
              $data_7 = @$dataComp->Company_Name;
              $str_7 = strlen($data_7);
            @endphp
            <td width="160px" align="right" style="{{ $str_7 > 0 && $str_7 <= 47 ? 'letter-spacing: 0.5px;' : ($str_7 > 47 && $str_7 <= 50 ? 'letter-spacing: 0.3px;' : ($str_7 > 50 && $str_7 <= 53 ? 'letter-spacing: 0.1px;' : 'letter-spacing: -0.3px;')) }}">
              จาก<b>{{@$data_7}}</b>
            </td>
          </tr>
          <tr style="text-align: justify;">
            <td width="540px" align="left">ผู้ให้เช่าซื้อ โดยการเช่าซื้อดังกล่าวได้มี<b>คุณ{{@$Grantor1}}{{(@$data->PatchToPact->ContractToGuarantor[1] != NULL)?' และคุณ'.@$Grantor2:''}}</b> เข้าค้ำประกัน ในกรณีที่ผู้เช่าซื้อละเมิดข้อสัญญา</td>
          </tr>
          <tr style="letter-spacing: 0.5px;">
            <td width="540px" align="left">รายละเอียดท่านทั้งสองทราบดีอยู่แล้วนั้น</td>
          </tr>
          <tr>
            <td align="right" width="540px" colspan="2"></td>
          </tr>
          <tr style="letter-spacing: 0.3px;text-align: justify;">
            <td width="50px"></td>
            <td width="400px" align="left">ปรากฏว่า คุณ <b>{{@$NameCus}}</b> ผู้เช่าซื้อได้ผิดนัดไม่ชำระค่าเช่าซื้อตั้งแต่งวดที่ <b>{{number_format(@$data->EXP_FRM,0)}}</b> ประจำวันที่</td>
            <td width="90px" align="right"><b>{{formatDateThaiLong(@$DATE_FRM->ddate)}}</b></td>
          </tr>
          <tr style="text-align: justify;">
            <td width="540px" align="left">จนถึงวันที่ <b>{{formatDateThaiLong(@$DATE_TO->ddate)}}</b> เป็นจำนวน <b>{{number_format(@$data->EXP_PRD,0)}}</b> งวด คิดเป็นเงิน <b>{{number_format(@$data->EXP_AMT,0)}}</b> บาท (<b>{{IntconvertThai(@$data->EXP_AMT)}}</b>) และเมื่อวันที่ <b>{{formatDateThaiLong(@$DATE_TO->ddate)}}</b> บริษัท ก็ได้ทำการบอกเลิกสัญญากับ คุณ<b>{{@$NameCus}}</b> ผู้เช่าซื้อแล้ว และ มีผลให้สัญญาเลิกกันแล้ว <b>คุณ{{@$NameCus}}</b> จึงมีหน้าที่ต้องส่งมอบรถยนต์คืนในสภาพเรียบร้อยใช้การได้ดี</td>
          </tr>
          <!-- <tr style="letter-spacing: 0.55px;">
            <td width="540px" align="left">และเมื่อวันที่ <b>{{formatDateThaiLong(@$DATE_TO->ddate)}}</b> บริษัท ก็ได้ทำการบอกเลิกสัญญากับ คุณ<b>{{@$NameCus}}</b> ผู้เช่าซื้อแล้ว และ มีผลให้</td>
          </tr> -->
          <!-- <tr style="letter-spacing: 0.8px;">
            <td width="540px" align="left">สัญญาเลิกกันแล้ว <b>คุณ{{@$NameCus}}</b> จึงมีหน้าที่ต้องส่งมอบรถยนต์คืนในสภาพเรียบร้อยใช้การได้ดี</td>
          </tr> -->
          <!-- <tr>
            <td align="right" width="540px" colspan="2"></td>
          </tr> -->
          <!-- <tr style="text-align: justify;">
            <td width="540px">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ปรากฏว่า คุณ <b>{{@$NameCus}}</b> ผู้เช่าซื้อได้ผิดนัดไม่ชำระค่าเช่าซื้อตั้งแต่งวดที่ <b>{{number_format(@$data->EXP_FRM,0)}}</b> ประจำวันที่ <b>{{formatDateThaiLong(@$DATE_FRM->ddate)}}</b>
              จนถึงวันที่ <b>{{formatDateThaiLong(@$DATE_TO->ddate)}}</b> เป็นจำนวน <b>{{number_format(@$data->EXP_PRD,0)}}</b> งวด คิดเป็นเงิน <b>{{number_format(@$data->EXP_AMT,0)}}</b> บาท (<b>{{IntconvertThai(@$data->EXP_AMT)}}</b>)
              และเมื่อวันที่ <b>{{formatDateThaiLong(@$DATE_TO->ddate)}}</b> บริษัท ก็ได้ทำการบอกเลิกสัญญากับ คุณ<b>{{@$NameCus}}</b> ผู้เช่าซื้อแล้ว และมีผลให้สัญญาเลิกกันแล้ว <b>คุณ{{@$NameCus}}</b> จึงมีหน้าที่ต้องส่งมอบรถยนต์คืนในสภาพเรียบร้อยใช้การได้ดี
            </td>
          </tr> -->
          <tr>
            <td align="right" width="540px" colspan="2"></td>
          </tr>
          <tr style="letter-spacing: 0.4px;text-align: justify;">
            <td width="50px"></td>
            <td width="490px" align="right">ต่อมาวันที่ <b>{{formatDateThaiLong(@$data->LPAYD)}}</b> <b>คุณ{{@$NameCus}}</b> ก็ได้ชำระด้วยการโอนเงิน จำนวน <b>{{number_format(@$data->LPAYA,0)}}</b> บาท ซึ่ง ณ ปัจจุบัน</td>
          </tr>
          <tr style="letter-spacing: 0.1px;">
            <td width="540px" align="left"><b>คุณ{{@$NameCus}}</b> ยังคงค้างอยู่ <b>{{number_format(@$data->EXP_PRD,0)}}</b> งวด เป็นเงิน <b>{{number_format(@$data->EXP_AMT,0)}}</b> บาท (<b>{{IntconvertThai(@$data->EXP_AMT)}}</b>)</td>
          </tr>
          <tr>
            <td align="right" width="540px" colspan="2"></td>
          </tr>
          <tr style="letter-spacing: 0.55px;text-align: justify;">
            <td width="50px"></td>
            <td width="490px" align="right">ฉะนั้น บริษัทยังคงยืนยันเจตนาเดิมโดยถือเอาหนังสือบอกเลิกสัญญาฉบับวันที่ <b>{{(@$dateTerminate != NULL)?formatDateThaiLong(@$dateTerminate):formatDateThaiLong(date('d-m-Y'))}}</b> เป็นการสิ้นสุด</td>
          </tr>
          <tr style="letter-spacing: 0.3px;">
            <td width="540px" align="left">สัญญาเช่าซื้อ และท่านยังมีหน้าที่ต้องส่งมอบรถยนต์ในสภาพเรียบร้อยใช้การได้ หากท่านทั้งสองยังเพิกเฉยไม่ส่งมอบ</td>
          </tr>
          <tr>
            <td width="540px" align="left" height="100"></td>
          </tr>
      </table>
      <table border="0" width="540px">
        <tr>
          <td width="350px"></td>
          <td width="190px">ขอแสดงความนับถือ</td>
        </tr>
        <tr>
          <td width="330px"></td>
          <td width="210px"></td>
        </tr>
        <tr>
          <td width="330px"><b style="color:blue;">หมายเหตุ {{(@$Note != NULL)?@$Note:'ยังไม่รวมค่าปรับและดอกเบี้ย'}}</b></td>
          <td width="210px"></td>
        </tr>
        <tr>
          <td width="330px"></td>
          <td width="120px" align="center">({{(@$staff != NULL)?@$staff:'นางประไพทิพย์ สุวรรณพงค์'}})</td>
          <td width="90px"></td>
        </tr>
        <tr>
          <td width="330px"></td>
          <td width="210px"></td>
        </tr>
        <tr>
          <td width="330px"></td>
          <td width="120px" align="center">ฝ่ายสินเชื่อ</td>
          <td width="90px"></td>
        </tr>
      </table>
    @endif
  </body>
</html>
