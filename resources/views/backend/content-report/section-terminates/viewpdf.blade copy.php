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
          @php 
            $line_1 = "ตามที่ คุณ".@$NameCus." ได้ตกลงทำสัญญาเช่าซื้อรถยนต์ยี่ห้อ ".@$BrandCar." หมายเลขทะเบียน ".@$LicenseCar;
            $str_1 = strlen($line_1);
          @endphp
          <tr style="{{ $str_1 > 200 && $str_1 <= 245 ? 'letter-spacing: 0.7px;' : ($str_1 > 245 && $str_1 <= 260 ? 'letter-spacing: 0.35px;' : ($str_1 > 300 && $str_1 < 350 ? 'letter-spacing: 0.1px;' : '')) }}">
            <td width="50px"></td>
            <td width="490px" align="left">{{$line_1}}</td>
          </tr>
          <!-- <tr style="letter-spacing: 0.6px;">
            <td width="50px"></td>
            <td width="490px" align="left">ตามที่ <b>คุณ{{@$NameCus}}</b> ได้ตกลงทำสัญญาเช่าซื้อรถยนต์ยี่ห้อ <b>{{@$BrandCar}}</b> หมายเลขทะเบียน <b>{{@$LicenseCar}}</b></td>
          </tr> -->
          @php 
            $line_2 = "หมายเลขตัวถัง ".@$TankCar." หมายเลขเครื่อง ".@$EngineCar." สี ".@$ColorCar." จาก".@$dataComp->Company_Name;
            $str_2 = strlen($line_2);
          @endphp
          <tr style="{{ $str_2 > 200 && $str_2 <= 245 ? 'letter-spacing: 0.65px;' : ($str_2 > 245 && $str_2 <= 260 ? 'letter-spacing: 0.35px;' : ($str_2 > 300 && $str_2 < 350 ? 'letter-spacing: 0.1px;' : '')) }}">
            <td width="540px" align="left">{{$line_2}}</td>
          </tr>
          <!-- <tr style="letter-spacing: 100%;">
            <td width="540px" align="left">หมายเลขตัวถัง <b>{{@$TankCar}}</b> หมายเลขเครื่อง <b>{{@$EngineCar}}</b> สี <b>{{@$ColorCar}}</b> จาก{{@$dataComp->Company_Name}}</td>
          </tr> -->
          @php 
            if(@$data->PatchToPact->ContractToGuarantor[1] != NULL){
              $line_3 = "ผู้ให้เช่าซื้อ โดยการเช่าซื้อดังกล่าวได้มีคุณ".@$Grantor1." และคุณ".@$Grantor2." เข้าค้ำประกัน ในกรณีที่ผู้เช่าซื้อละเมิดข้อสัญญา";
            }
            else{
              $line_3 = "ผู้ให้เช่าซื้อ โดยการเช่าซื้อดังกล่าวได้มีคุณ".@$Grantor1." เข้าค้ำประกัน ในกรณีที่ผู้เช่าซื้อละเมิดข้อสัญญา";
            }
            $str_3 = strlen($line_3);
            //dd($str_3);
          @endphp
          <tr style="{{ $str_3 > 200 && $str_3 <= 245 ? 'letter-spacing: 0.65px;' : ($str_3 > 245 && $str_3 <= 260 ? 'letter-spacing: 0.35px;' : ($str_3 > 300 && $str_3 <= 350 ? 'letter-spacing: 0.45px;' : ($str_3 > 350 && $str_3 <= 405 ? 'letter-spacing: 0.05px;' : ($str_3 > 405 && $str_3 <= 426 ? 'letter-spacing: -0.35px;' : '')))) }}">
            <td width="540px" align="left">{{$line_3}}</td>
          </tr>
          <!-- <tr style="letter-spacing: 100%;">
            <td width="540px" align="left">ผู้ให้เช่าซื้อ โดยการเช่าซื้อดังกล่าวได้มี<b>คุณ{{@$Grantor1}}{{(@$data->PatchToPact->ContractToGuarantor[1] != NULL)?' และคุณ'.@$Grantor2:''}}</b> เข้าค้ำประกัน ในกรณีที่ผู้เช่าซื้อละเมิดข้อสัญญา</td>
          </tr> -->
          <tr style="letter-spacing: 0.5px;">
            <td width="540px" align="left">รายละเอียดท่านทั้งสองทราบดีอยู่แล้วนั้น</td>
          </tr>
          <tr>
            <td align="right" width="540px" colspan="2"></td>
          </tr>
          <tr style="letter-spacing: 0.3px;">
            <td width="50px"></td>
            <td width="490px" align="left">ปรากฏว่า คุณ <b>{{@$NameCus}}</b> ผู้เช่าซื้อได้ผิดนัดไม่ชำระค่าเช่าซื้อตั้งแต่งวดที่ <b>{{number_format(@$data->EXP_FRM,0)}}</b> ประจำวันที่ <b>{{formatDateThaiLong(@$DATE_FRM->ddate)}}</b></td>
          </tr>
          <tr style="letter-spacing: 0.5px;">
            <td width="540px" align="left">จนถึงวันที่ <b>{{formatDateThaiLong(@$DATE_TO->ddate)}}</b> เป็นจำนวน <b>{{number_format(@$data->EXP_PRD,0)}}</b> งวด คิดเป็นเงิน <b>{{number_format(@$data->EXP_AMT,0)}}</b> บาท (<b>{{IntconvertThai(@$data->EXP_AMT)}}</b>)</td>
          </tr>
          <tr style="letter-spacing: 0.55px;">
            <td width="540px" align="left">และเมื่อวันที่ <b>{{formatDateThaiLong(@$DATE_TO->ddate)}}</b> บริษัท ก็ได้ทำการบอกเลิกสัญญากับ คุณ<b>{{@$NameCus}}</b> ผู้เช่าซื้อแล้ว และ มีผลให้</td>
          </tr>
          <tr style="letter-spacing: 0.8px;">
            <td width="540px" align="left">สัญญาเลิกกันแล้ว <b>คุณ{{@$NameCus}}</b> จึงมีหน้าที่ต้องส่งมอบรถยนต์คืนในสภาพเรียบร้อยใช้การได้ดี</td>
          </tr>
          <tr>
            <td align="right" width="540px" colspan="2"></td>
          </tr>
          <tr style="letter-spacing: 0.1px;">
            <td width="50px"></td>
            <td width="490px" align="left">ต่อมาวันที่ <b>{{formatDateThaiLong(@$data->LPAYD)}}</b> <b>คุณ{{@$NameCus}}</b> ก็ได้ชำระด้วยการโอนเงิน จำนวน <b>{{number_format(@$data->LPAYA,0)}}</b> บาท ซึ่ง ณ ปัจจุบัน</td>
          </tr>
          <tr style="letter-spacing: 0.1px;">
            <td width="540px" align="left"><b>คุณ{{@$NameCus}}</b> ยังคงค้างอยู่ <b>{{number_format(@$data->EXP_PRD,0)}}</b> งวด เป็นเงิน <b>{{number_format(@$data->EXP_AMT,0)}}</b> บาท (<b>{{IntconvertThai(@$data->EXP_AMT)}}</b>)</td>
          </tr>
          <tr>
            <td align="right" width="540px" colspan="2"></td>
          </tr>
          <tr style="letter-spacing: 0.3px;">
            <td width="50px"></td>
            <td width="490px" align="left">ฉะนั้น บริษัทยังคงยืนยันเจตนาเดิมโดยถือเอาหนังสือบอกเลิกสัญญาฉบับวันที่ <b>{{(@$dateTerminate != NULL)?formatDateThaiLong(@$dateTerminate):formatDateThaiLong(date('d-m-Y'))}}</b> เป็นการสิ้นสุด</td>
          </tr>
          <tr style="letter-spacing: 0.3px;">
            <td width="540px" align="left">สัญญาเช่าซื้อ และท่านยังมีหน้าที่ต้องส่งมอบรถยนต์ในสภาพเรียบร้อยใช้การได้ หากท่านทั้งสองยังเพิกเฉยไม่ส่งมอบ</td>
          </tr>
          <tr>
            <td width="540px" align="left" height="120"></td>
          </tr>
      </table>
      <table border="0" width="540px">
        <tr>
          <td width="350px"></td>
          <td width="190px">ขอแสดงความนับถือ</td>
        </tr>
        <tr>
          <td width="340px"></td>
          <td width="200px"></td>
        </tr>
        <tr>
          <td width="340px"><b style="color:blue;">หมายเหตุ {{(@$Note != NULL)?@$Note:'ยังไม่รวมค่าปรับและดอกเบี้ย'}}</b></td>
          <td width="200px"></td>
        </tr>
        <tr>
          <td width="330px"></td>
          <td width="210px">(นางประไพทิพย์ สุวรรณพงค์)</td>
        </tr>
        <tr>
          <td width="340px"></td>
          <td width="200px"></td>
        </tr>
        <tr>
          <td width="360px"></td>
          <td width="180px">ฝ่ายสินเชื่อ</td>
        </tr>
      </table>
    @endif
  </body>
</html>
