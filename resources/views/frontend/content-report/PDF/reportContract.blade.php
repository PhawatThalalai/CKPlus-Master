<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8">
	<title></title>

</head>
<style>
	.page_break {
		page-break-before: always;
	}
</style>
<label>วันที่ : {{ date('d-m-Y') }}</label>

<h3 class="card-title p-3" align="center" style="line-height: 3px;">แบบฟอร์มขออนุมัติ {{ @$data->ContractToTypeLoan->Loan_Name }}</h3>

<hr>
@php
	$nameCom = @$data->ContractToComOne->Company_Name;
	// $cusAdd1 = @$data->ContractToIndenture->IndentureToAdds1;
	// $cusAdd2 = @$data->ContractToIndenture->IndentureToAdds2;
	// $cusAdd4 = @$data->ContractToIndenture->IndentureToAdds3;
	$cusAdd3 = @$data->ContractToCus->DataCusToDataCusCareer;
	$asset = @$data->ContractToIndenture->IndentureToAsset;
	$dataCus = @$data->ContractToCus;
@endphp

<body style="margin-top: 0 0 0px;">
	<table border="0">
		<tbody>
			<tr align="center">
				<th width="180px">{{ $nameCom }}</th>
				<th width="180px">เลขที่สัญญา <b>{{ @$data->Contract_Con }}</b></th>
				<th width="180px">วันที่ทำสัญญา <b>{{ @$data->Date_monetary != null ? date('d-m-Y', strtotime(@$data->Date_monetary)) : '' }}</b></th>
			</tr>
		</tbody>
	</table>

	<h4 align="left"><u>รายละเอียดผู้เช่าซื้อ</u></h4>
	<table border="1">
		<thead>
			<tr align="center">
				<th class="text-center" width="180px">ชื่อ</th>
				<th class="text-center" width="60px">ชื่อเล่น</th>
				<th class="text-center" width="120px">สถานะ</th>
				<th class="text-center" width="180px">เบอร์โทรศัพท์</th>
			</tr>
		</thead>
		<tbody>
			<tr align="center" style="background-color: yellow;">
				<td width="180px"> <b>{{ @$dataCus->Name_Cus }}</b></td>
				<td width="60px"> <b>{{ @$dataCus->Nickname_cus }}</b></td>
				<td width="120px"> <b>{{ @$dataCus->Marital_cus }}</b></td>

				{{-- แบบเก่า <td width="180px"> <b>{{ str_replace(',', ',     ', @$dataCus->Phone_cus) }}</b></td> --}}

				<td width="180px">
					@if ( !empty( getFirstPhone_php(@$dataCus->Phone_cus) ) )
						<b>{{formatPhoneNumber( getFirstPhone_php(@$dataCus->Phone_cus), '99 9999 9999' )}}</b>
					@endif
					@php
						$phone_cus_2 = "";
						if ( empty(@$dataCus->Phone_cus2) ) {
							$_phone_numbers = explode(',', @$dataCus->Phone_cus);
							if ( isset($_phone_numbers[1]) ) {
								$phone_cus_2 = $_phone_numbers[1];
							}
						} else {
							$phone_cus_2 = @$dataCus->Phone_cus2;
						}
					@endphp
					@if ( !empty( $phone_cus_2 ) )
						<b>, {{formatPhoneNumber( $phone_cus_2, '99 9999 9999')}}</b>
					@endif
				</td>

			</tr>
		</tbody>
	</table>
	<table border="1">
		<tr>
			<th align="right" width="120px"> เลขบัตรประชาชน &nbsp;</th>
			<th class="text-center" width="120px" style="background-color: yellow;"> <b>{{ textFormat(@$dataCus->IDCard_cus) }}</b></th>
			<th class="text-center" width="205px"> ประวัติเปลี่ยนชื่อ : <b>{{ @$dataCus->Namechange_cus }}</b></th>
			<th class="text-center" width="95px"> ใบขับขี่ : <b>{{ @$dataCus->Driver_cus }}</b></th>
		</tr>
		@foreach (@$dataCus->DataCusToDataCusAddsMany as $dataCusAdd)
			@if (@$dataCusAdd->Status_Adds != 'inactive')
				<tr>
					<th align="right" width="120px"> {{ @$dataCusAdd->DataCusAddsToTypeAdds->Name_Address }} &nbsp;</th>
					<th class="text-center" width="420px" style="background-color: yellow;"> <b>{{ (@$dataCusAdd->houseNumber_Adds != null ? @$dataCusAdd->houseNumber_Adds : '') . ' ' . (@$dataCusAdd->houseGroup_Adds != null ? 'ม.' . @$dataCusAdd->houseGroup_Adds : '') . ' ' . (@$dataCusAdd->building_Adds != null ? 'อาคาร' . @$dataCusAdd->building_Adds : '') . ' ' . (@$dataCusAdd->village_Adds != null ? 'หมู่บ้าน' . @$dataCusAdd->village_Adds : '') . ' ' . (@$dataCusAdd->roomNumber_Adds != null ? 'เลขห้อง' . @$dataCusAdd->roomNumber_Adds : '') . ' ' . (@$dataCusAdd->Floor_Adds != null ? 'ชั้น' . @$dataCusAdd->Floor_Adds : '') . ' ' . (@$dataCusAdd->alley_Adds != null ? 'ซ.' . @$dataCusAdd->alley_Adds : '') . ' ' . (@$dataCusAdd->road_Adds != null ? 'ถ.' . @$dataCusAdd->road_Adds : '') . ' ' . (@$dataCusAdd->houseTambon_Adds != null ? 'ต.' . @$dataCusAdd->houseTambon_Adds : '') . ' ' . (@$dataCusAdd->houseDistrict_Adds != null ? 'อ.' . @$dataCusAdd->houseDistrict_Adds : '') . ' ' . (@$dataCusAdd->houseProvince_Adds != null ? 'จ.' . @$dataCusAdd->houseProvince_Adds : '') . ' ' . (@$dataCusAdd->Postal_Adds != null ? @$dataCusAdd->Postal_Adds : '') }}
						</b></th>
				</tr>
			@endif
		@endforeach
		{{--
        @if (@$data->ContractToIndenture->CusAddress1_id)
        <tr>
          <th align="right" width="120px">ที่อยู่ปัจจุบัน &nbsp;</th>
          <th class="text-center" width="420px" style="background-color: yellow;"> <b>
            {{(@$cusAdd1->houseNumber_Adds != NULL ? @$cusAdd1->houseNumber_Adds : ''). ' ' .
              (@$cusAdd1->houseGroup_Adds != NULL ? "ม.".@$cusAdd1->houseGroup_Adds : ''). ' ' .
              (@$cusAdd1->building_Adds != NULL ? "อาคาร".@$cusAdd1->building_Adds : ''). ' ' .
              (@$cusAdd1->village_Adds != NULL ? "หมู่บ้าน".@$cusAdd1->village_Adds : ''). ' ' .
              (@$cusAdd1->roomNumber_Adds != NULL ? "เลขห้อง". @$cusAdd1->roomNumber_Adds : ''). ' ' .
              (@$cusAdd1->Floor_Adds != NULL ? "ชั้น".@$cusAdd1->Floor_Adds : ''). ' ' .
              (@$cusAdd1->alley_Adds != NULL ? "ซ.".@$cusAdd1->alley_Adds : ''). ' ' .
              (@$cusAdd1->road_Adds != NULL ? "ถ.".@$cusAdd1->road_Adds : ''). ' ' .
              (@$cusAdd1->houseTambon_Adds != NULL ? "ต.".@$cusAdd1->houseTambon_Adds : ''). ' ' .
              (@$cusAdd1->houseDistrict_Adds != NULL ? "อ.".@$cusAdd1->houseDistrict_Adds : ''). ' ' .
              (@$cusAdd1->houseProvince_Adds != NULL ? "จ.". @$cusAdd1->houseProvince_Adds : ''). ' ' .
              (@$cusAdd1->Postal_Adds != NULL ? @$cusAdd1->Postal_Adds : '')
            }}</b></th>
        </tr>
        @endif

        @if (@$data->ContractToIndenture->CusAddress2_id)
        <tr>
          <th align="right" width="120px"> ส่งเอกสาร &nbsp;</th>
          <th class="text-center" width="420px" style="background-color: yellow;"> <b>{{
            (@$cusAdd2->houseNumber_Adds != NULL ? @$cusAdd2->houseNumber_Adds : ''). ' ' .
            (@$cusAdd2->houseGroup_Adds != NULL ? "ม.".@$cusAdd2->houseGroup_Adds : ''). ' ' .
            (@$cusAdd2->building_Adds != NULL ? "อาคาร".@$cusAdd2->building_Adds : ''). ' ' .
            (@$cusAdd2->village_Adds != NULL ? "หมู่บ้าน".@$cusAdd2->village_Adds : ''). ' ' .
            (@$cusAdd2->roomNumber_Adds != NULL ? "เลขห้อง". @$cusAdd2->roomNumber_Adds : ''). ' ' .
            (@$cusAdd2->Floor_Adds != NULL ? "ชั้น".@$cusAdd2->Floor_Adds : ''). ' ' .
            (@$cusAdd2->alley_Adds != NULL ? "ซ.".@$cusAdd2->alley_Adds : ''). ' ' .
            (@$cusAdd2->road_Adds != NULL ? "ถ.".@$cusAdd2->road_Adds : ''). ' ' .
            (@$cusAdd2->houseTambon_Adds != NULL ? "ต.".@$cusAdd2->houseTambon_Adds : ''). ' ' .
            (@$cusAdd2->houseDistrict_Adds != NULL ? "อ.".@$cusAdd2->houseDistrict_Adds : ''). ' ' .
            (@$cusAdd2->houseProvince_Adds != NULL ? "จ.". @$cusAdd2->houseProvince_Adds : ''). ' ' .
            (@$cusAdd2->Postal_Adds != NULL ? @$cusAdd2->Postal_Adds : '')
          }}</b></th>
        </tr>
        @endif
        @if (@$data->ContractToIndenture->CusAddress3_id)
        <tr>
          <th align="right" width="120px">ที่อยู่ตามทะเบียน &nbsp;</th>
          <th class="text-center" width="420px" style="background-color: yellow;"> <b>{{
            (@$cusAdd4->houseNumber_Adds != NULL ? @$cusAdd4->houseNumber_Adds : ''). ' ' .
            (@$cusAdd4->houseGroup_Adds != NULL ? "ม.".@$cusAdd4->houseGroup_Adds : ''). ' ' .
            (@$cusAdd4->building_Adds != NULL ? "อาคาร".@$cusAdd4->building_Adds : ''). ' ' .
            (@$cusAdd4->village_Adds != NULL ? "หมู่บ้าน".@$cusAdd4->village_Adds : ''). ' ' .
            (@$cusAdd4->roomNumber_Adds != NULL ? "เลขห้อง". @$cusAdd4->roomNumber_Adds : ''). ' ' .
            (@$cusAdd4->Floor_Adds != NULL ? "ชั้น".@$cusAdd4->Floor_Adds : ''). ' ' .
            (@$cusAdd4->alley_Adds != NULL ? "ซ.".@$cusAdd4->alley_Adds : ''). ' ' .
            (@$cusAdd4->road_Adds != NULL ? "ถ.".@$cusAdd4->road_Adds : ''). ' ' .
            (@$cusAdd4->houseTambon_Adds != NULL ? "ต.".@$cusAdd4->houseTambon_Adds : ''). ' ' .
            (@$cusAdd4->houseDistrict_Adds != NULL ? "อ.".@$cusAdd4->houseDistrict_Adds : ''). ' ' .
            (@$cusAdd4->houseProvince_Adds != NULL ? "จ.". @$cusAdd4->houseProvince_Adds : ''). ' ' .
            (@$cusAdd4->Postal_Adds != NULL ? @$cusAdd4->Postal_Adds : '')
          }}</b></th>
        </tr>
       @endif
     --}}
		{{-- <tr>
          <th align="right" width="120px"> สถานที่ทำงาน &nbsp;</th>
          <th class="text-center" width="420px" style="background-color: yellow;"> <b>{{$dataCus->DataCusToDataCusCareer->Workplace_Cus}}</b></th>
        </tr> --}}

		<tr>
			<th align="right" width="120px"> ทรัพย์ค้ำประกัน &nbsp;</th>
			<th class="text-center" width="120px" style="background-color: yellow;"> <b>{{ @$dataCus->DataCusToDataCusAsset->Status_Asset == 'active' ? @$dataCus->DataCusToDataCusAsset->DataCusAssetToTypeAsset->Name_Assets : '-' }}</b></th>
			<th align="right" width="60px"> เลขที่โฉนด &nbsp;</th>
			<th class="text-center" width="145px" style="background-color: yellow;"> <b>{{ @$dataCus->DataCusToDataCusAsset->Status_Asset == 'active' ? @$dataCus->DataCusToDataCusAsset->Deednumber_Asset : '-' }}</b></th>
			<th align="right" width="40px"> เนื้อที่ &nbsp;</th>
			<th class="text-center" width="55px" style="background-color: yellow;"> <b>{{ @$dataCus->DataCusToDataCusAsset->Status_Asset == 'active' ? @$dataCus->DataCusToDataCusAsset->Area_Asset : '-' }}</b></th>
		</tr>
		@foreach (@$dataCus->DataCusToDataCusCareerMany as $value)
			@if ($value->Status_Cus == 'active')
				<tr>
					<th align="right" width="120px"> {{ @$value->Main_Career == 'yes' ? 'อาชีพหลัก' : 'อาชีพรอง' }} &nbsp;</th>
					<th class="text-center" width="120px" style="background-color: yellow;">
						@if (@$value->Career_Cus == 'CR-0018')
							<b>{{ @$value->DetailCareer_Cus }}</b>
						@else
							<b>{{ @$value->CusCareerToTBCareerCus->Name_Career }}</b>
						@endif
					</th>
					<th align="right" width="60px"> สถานะผู้เช่าซื้อ &nbsp;</th>
					<th class="text-center" width="145px" style="background-color: yellow;"> <b>{{ @$data->ContractToDataCusTags->TagToStatusCus->Name_Cus }}</b></th>
				</tr>
				<tr>
					<th align="right" width="120px"> รายได้ &nbsp;</th>
					<th class="text-center" width="120px" style="background-color: yellow;">
						<b>{{ number_format(@$value->Income_Cus, 0) }}</b>
					</th>
					<th align="right" width="60"> หักค่าใช้จ่าย &nbsp;</th>
					<th class="text-center" width="60" style="background-color: yellow;">
						<b>{{ number_format(@$value->BeforeIncome_Cus, 0) }}</b>
					</th>
					<th align="right" width="85"> รายได้หลังหัก คชจ. &nbsp;</th>
					<th align="left" width="95" style="background-color: yellow;">
						<b>{{ number_format(@$value->AfterIncome_Cus, 0) }}</b>
					</th>
				</tr>
				<tr>
					<th align="right" width="120px"> สถานที่ทำงาน &nbsp;</th>
					<th class="text-center" width="420px" style="background-color: yellow;"> <b>{{ @$value->Workplace_Cus }}</b></th>
				</tr>
			@endif
		@endforeach
		<tr>
			<th align="right" width="120px"> คู่สมรส &nbsp;</th>
			<th class="text-center" width="120px" style="background-color: yellow;">
				@if (is_numeric(@$dataCus->Mate_cus))
					<b> {{ @$dataCus->DataCusMateToDataCus->Mate_cus != null ? @$dataCus->DataCusMateToDataCus->Name_Cus : '-' }}</b>
				@else
					<b> {{ @$dataCus->Mate_cus }}</b>
				@endif
			</th>
			<th align="right" width="60"> เบอร์โทรศัพท์ &nbsp;</th>
			<th class="text-center" width="145" style="background-color: yellow;">
				@if (is_numeric(@$dataCus->Mate_cus))
					<b> {{ @$dataCus->DataCusMateToDataCus->Phone_cus != null ? @$dataCus->DataCusMateToDataCus->Phone_cus : '-' }}</b>
				@else
					<b> {{ @$dataCus->Mate_Phone }}</b>
				@endif
			</th>
		</tr>
		<tr>
			<th align="right" width="120px"> บุคคลอ้างอิง &nbsp;</th>
			<th class="text-center" width="120px" style="background-color: yellow;">
				@if (is_numeric(@$dataCus->Reference) && @$data->Date_con < '2024-01-01')
					<b> {{ @$dataCus->DataCusReferenceToDataCus->Name_Cus != null ? @$dataCus->DataCusReferenceToDataCus->Name_Cus : '-' }}</b>
				@else
					<b> {{ @$data->Cus_Ref }}</b>
				@endif
			</th>
			<th align="right" width="60"> เบอร์โทรศัพท์ &nbsp;</th>
			<th class="text-center" width="145" style="background-color: yellow;">
				@if (is_numeric(@$dataCus->Reference) && @$data->Date_con < '2024-01-01')
					<b> {{ @$dataCus->DataCusReferenceToDataCus->Phone_cus != null ? @$dataCus->DataCusReferenceToDataCus->Phone_cus : '-' }}</b>
				@else
					<b> {{ @$data->PhoneCus_Ref }}</b>
				@endif
			</th>
		</tr>
	</table>

	@if (!empty($data->ContractToGuarantor))
		@foreach ($data->ContractToGuarantor as $key => $Guarantor)
			<h4 align="left"><u>รายละเอียดผู้ค้ำ {{ $key + 1 }}</u></h4>
			<table border="1">
				@php
					$GurranToCus = @$Guarantor->GuarantorToGuarantorCus;
					$GurranAdd1 = @$Guarantor->GuarantorToDataGuarAdds; //ที่อยู่
					$GurranCareer = @$Guarantor->DataCusToDataGuarCareer; //อาชีพ
					$GurranAsset = @$Guarantor->GuarantorToDataGuarAsset; //หลักทรัพย์
					$GurranAssetLast = @$Guarantor->GuarantorToDataCusAssetLast; //หลักทรัพย์

				@endphp
				<thead>
					<tr align="center">
						<th class="text-center" width="180px">ชื่อ</th>
						<th class="text-center" width="60px">ชื่อเล่น</th>
						<th class="text-center" width="120px">สถานะ</th>
						<th class="text-center" width="180px">เบอร์โทรศัพท์</th>
					</tr>
				</thead>
				<tbody>
					<tr align="center" style="background-color: yellow;">
						<td width="180px"> <b>{{ @$GurranToCus->Name_Cus }}</b></td>
						<td width="60px"> <b>{{ @$GurranToCus->Nickname_cus }}</b></td>
						<td width="120px"> <b>{{ @$GurranToCus->Marital_cus }}</b></td>
						{{-- <td width="180px"> <b>{{ str_replace(',', ',     ', @$GurranToCus->Phone_cus) }}</b></td> --}}

						<td width="180px">
							@if ( !empty( getFirstPhone_php(@$GurranToCus->Phone_cus) ) )
								<b>{{formatPhoneNumber( getFirstPhone_php(@$GurranToCus->Phone_cus), '99 9999 9999' )}}</b>
							@endif
							@php
								$phone_cus_2 = "";
								if ( empty(@$GurranToCus->Phone_cus2) ) {
									$_phone_numbers = explode(',', @$GurranToCus->Phone_cus);
									if ( isset($_phone_numbers[1]) ) {
										$phone_cus_2 = $_phone_numbers[1];
									}
								} else {
									$phone_cus_2 = @$GurranToCus->Phone_cus2;
								}
							@endphp
							@if ( !empty( $phone_cus_2 ) )
								<b>, {{formatPhoneNumber( $phone_cus_2, '99 9999 9999')}}</b>
							@endif
						</td>

					</tr>
				</tbody>
			</table>
			<table border="1">
				<tr>
					<th align="right" width="120px"> เลขบัตรประชาชน &nbsp;</th>
					<th class="text-center" width="120px" style="background-color: yellow;"> <b>{{ textFormat(@$GurranToCus->IDCard_cus) }}</b></th>
					<th class="text-center" width="205px"> ประวัติเปลี่ยนชื่อ : <b>{{ @$GurranToCus->Namechange_cus }}</b></th>
					<th class="text-center" width="95px"> ใบขับขี่ : <b>{{ @$GurranToCus->Driver_cus }}</b></th>
				</tr>
				@foreach ($GurranToCus->DataCusToDataCusAddsMany as $DataGurranAdd)
					@if ($DataGurranAdd->Status_Adds != 'inactive')
						<tr>
							<th align="right" width="120px"> {{ @$DataGurranAdd->DataCusAddsToTypeAdds->Name_Address }} &nbsp;</th>
							<th class="text-center" width="420px" style="background-color: yellow;"> <b>{{ (@$DataGurranAdd->houseNumber_Adds != null ? @$DataGurranAdd->houseNumber_Adds : '') . ' ' . (@$DataGurranAdd->houseGroup_Adds != null ? 'ม.' . @$DataGurranAdd->houseGroup_Adds : '') . ' ' . (@$DataGurranAdd->building_Adds != null ? 'อาคาร' . @$DataGurranAdd->building_Adds : '') . ' ' . (@$DataGurranAdd->village_Adds != null ? 'หมู่บ้าน' . @$DataGurranAdd->village_Adds : '') . ' ' . (@$DataGurranAdd->roomNumber_Adds != null ? 'เลขห้อง' . @$DataGurranAdd->roomNumber_Adds : '') . ' ' . (@$DataGurranAdd->Floor_Adds != null ? 'ชั้น' . @$DataGurranAdd->Floor_Adds : '') . ' ' . (@$DataGurranAdd->alley_Adds != null ? 'ซ.' . @$DataGurranAdd->alley_Adds : '') . ' ' . (@$DataGurranAdd->road_Adds != null ? 'ถ.' . @$DataGurranAdd->road_Adds : '') . ' ' . (@$DataGurranAdd->houseTambon_Adds != null ? 'ต.' . @$DataGurranAdd->houseTambon_Adds : '') . ' ' . (@$DataGurranAdd->houseDistrict_Adds != null ? 'อ.' . @$DataGurranAdd->houseDistrict_Adds : '') . ' ' . (@$DataGurranAdd->houseProvince_Adds != null ? 'จ.' . @$DataGurranAdd->houseProvince_Adds : '') . ' ' . (@$DataGurranAdd->Postal_Adds != null ? @$DataGurranAdd->Postal_Adds : '') }}</b></th>
						</tr>
					@endif
				@endforeach
				<tr>
					<th align="right" width="120px"> สถานที่ทำงาน &nbsp;</th>
					<th class="text-center" width="420px" style="background-color: yellow;"> <b>{{ @$GurranToCus->DataCusToDataCusCareer->Workplace_Cus }}</b></th>
				</tr>
				<tr>
					<th align="right" width="120px"> ประเภทหลักทรัพย์ &nbsp;</th>
					<th class="text-center" width="120px" style="background-color: yellow;"> <b>{{ @$GurranAssetLast->DataCusAssetToTypeAsset->Name_Assets != null ? @$GurranAssetLast->DataCusAssetToTypeAsset->Name_Assets : '-' }}</b></th>
					<th align="right" width="60px"> เลขที่โฉนด &nbsp;</th>
					<th class="text-center" width="145px" style="background-color: yellow;"> <b>{{ @$GurranAssetLast->Deednumber_Asset != null ? @$GurranAssetLast->Deednumber_Asset : '-' }}</b></th>
					<th align="right" width="40px"> เนื้อที่ &nbsp;</th>
					<th class="text-center" width="55px" style="background-color: yellow;"> <b>{{ @$GurranAssetLast->Area_Asset != null ? @$GurranAssetLast->Area_Asset : '-' }}</b></th>
				</tr>
				@foreach (@$GurranToCus->DataCusToDataCusCareerMany as $value)
					@if ($value->Status_Cus == 'active')
						<tr>
							<th align="right" width="120px"> อาชีพ &nbsp;</th>
							<th class="text-center" width="120px" style="background-color: yellow;">
								{{--
                <b>{{@$GurranToCus->DataCusToDataCusCareer->CusCareerToTBCareerCus->Name_Career}}</b></th>
              <th align="right" width="60px"> สถานะผู้เช่าซื้อ &nbsp;</th>
              <th class="text-center" width="145px" style="background-color: yellow;"> <b>ผู้ค้ำ</b></th>
            </tr>
            <tr>
              <th align="right" width="120px"> รายได้ &nbsp;</th>
              <th class="text-center" width="120px" style="background-color: yellow;">
                <b>{{number_format(@$GurranToCus->DataCusToDataCusCareer->Income_Cus,0)}}</b>
              </th>
              <th align="right" width="60"> หักค่าใช้จ่าย &nbsp;</th>
              <th class="text-center" width="60" style="background-color: yellow;">
                <b>{{number_format(@$GurranToCus->DataCusToDataCusCareer->BeforeIncome_Cus)}}</b>
              </th>
              <th align="right" width="85"> รายได้หลังหัก คชจ. &nbsp;</th>
              <th align="left" width="95" style="background-color: yellow;">
                <b>{{number_format(@$GurranToCus->DataCusToDataCusCareer->AfterIncome_Cus)}} &nbsp;</b>
              </th>
            </tr>
            --}}

								@if (@$value->Career_Cus == 'CR-0018')
									<b>{{ @$value->DetailCareer_Cus }}</b>
								@else
									<b>{{ @$value->CusCareerToTBCareerCus->Name_Career }}</b>
								@endif
							</th>
							<th align="right" width="60px"> สถานะผู้เช่าซื้อ &nbsp;</th>
							<th class="text-center" width="145px" style="background-color: yellow;"> <b>ผู้ค้ำ</b></th>
						</tr>
						<tr>
							<th align="right" width="120px"> รายได้ &nbsp;</th>
							<th class="text-center" width="120px" style="background-color: yellow;">
								<b>{{ number_format(@$value->Income_Cus, 0) }}</b>
							</th>
							<th align="right" width="60"> หักค่าใช้จ่าย &nbsp;</th>
							<th class="text-center" width="60" style="background-color: yellow;">
								<b>{{ number_format(@$value->BeforeIncome_Cus, 0) }}</b>
							</th>
							<th align="right" width="85"> รายได้หลังหัก คชจ. &nbsp;</th>
							<th align="left" width="95" style="background-color: yellow;">
								<b>{{ number_format(@$value->AfterIncome_Cus, 0) }}</b>
							</th>
						</tr>
					@endif
				@endforeach
				<tr>
					<th align="right" width="120px"> คู่สมรส &nbsp;</th>
					<th class="text-center" width="120px" style="background-color: yellow;">
						@if (is_numeric(@$GurranToCus->Mate_cus))
							<b>{{ @$GurranToCus->DataCusMateToDataCus->Name_Cus != null ? @$GurranToCus->DataCusMateToDataCus->Name_Cus : '-' }}</b>
						@else
							<b>{{ @$GurranToCus->Mate_cus }}</b>
						@endif
					</th>
					<th align="right" width="60"> เบอร์โทรศัพท์ &nbsp;</th>
					<th class="text-center" width="145" style="background-color: yellow;">
						@if (is_numeric(@$GurranToCus->Mate_cus))
							<b>{{ @$GurranToCus->DataCusMateToDataCus->Phone_cus != null ? @$GurranToCus->DataCusMateToDataCus->Phone_cus : '-' }}</b>
						@else
							<b>{{ @$GurranToCus->Mate_Phone }}</b>
						@endif
					</th>
				</tr>
				{{--
            <tr>
              <th align="right" width="120px"> อาชีพ &nbsp;</th>
              <th class="text-center" width="120px" style="background-color: yellow;"> <b>{{@$GurranCareer->CusCareerToTBCareerCus->Name_Career}}</b></th>
              <th align="right" width="60px"> หักค่าใช้จ่าย &nbsp;</th>
              <th class="text-center" width="60px" style="background-color: yellow;"> <b>{{@$GurranAsset->Area_Asset}}</b></th>
              <th align="right" width="85px"> รายได้หลังหัก คชจ. &nbsp;</th>
              <th class="text-center" width="95px" style="background-color: yellow;"> <b>{{@$GurranAsset->Note_Asset}}</b></th>
            </tr>
            <tr>
              <th align="right" width="120px"> รายได้ &nbsp;</th>
              <th align="left" width="120px" style="background-color: yellow;"> <b>{{number_format(@$GurranCareer->Income_Cus,0)}} </b></th>
              <th align="right" width="60px"> ความสัมพันธ์ &nbsp;</th>
              <th align="right" width="60" style="background-color: yellow;"> <b>{{@$Guarantor->GuarantorToTypeRelation->Name_Rela}} &nbsp;</b></th>

              <th align="right" width="60px"> ประวัติซื้อ &nbsp;</th>
              <th class="text-center" width="60" style="background-color: yellow;"> <b>{{@$data->ConstoGuarantor->puchase_GT}}</b></th>
              <th align="right" width="85px"> ประวัติค้ำ &nbsp;</th>
              <th class="text-center" width="95" style="background-color: yellow;"> <b>{{@$data->ConstoGuarantor->support_GT}}</b></th>
            </tr> --}}
			</table>
		@endforeach
	@endif
	@php
		$calculate = @$data->ContractToCal;
	@endphp
	@if (@$data->ContractToTypeLoan->id_rateType != 'person')
		@php
			$assetAll = @$data->ContractToIndentureAsset2;
			$count = 1;
		@endphp
		@if (@$data->ContractToTypeLoan->id_rateType == 'land')
			<h4 align="left"><u>รายละเอียดที่ดิน</u></h4>
			<table border="1">
				@foreach ($assetAll as $asset)
					<tr>
						<th align="right" width="120px"> {{ $count++ }}. ประเภทหลักทรัพย์ &nbsp;</th>
						<th align="right" width="120px" style="background-color: yellow;">
							<b>{{ @$asset->IndenAssetToDataOwner->OwnershipToAsset->AssetToTypeAsset->Name_TypeAsset }} &nbsp;</b>

						</th>
						<th align="right" width="105px"> เลขที่โฉนด/เลขที่ดิน &nbsp;</th>
						<th align="right" width="100px" style="background-color: yellow;"> <b>{{ @$asset->IndenAssetToDataOwner->OwnershipToAsset->Land_Id }} &nbsp;</b></th>
						<th align="right" width="95px" style="background-color: yellow;"> <b>{{ @$asset->IndenAssetToDataOwner->OwnershipToAsset->Land_ParcelNumber }} &nbsp;</b></th>
					</tr>
					<tr>
						<th align="right" width="120px"> ระวาง &nbsp;</th>
						<th align="right" width="120px" style="background-color: yellow;"> <b>{{ @$asset->IndenAssetToDataOwner->OwnershipToAsset->Land_SheetNumber }} &nbsp;</b></th>
						<th align="right" width="105px"> หน้าสำรวจ &nbsp;</th>
						<th align="right" width="195px" style="background-color: yellow;"> <b>{{ @$asset->IndenAssetToDataOwner->OwnershipToAsset->Land_TambonNumber }} &nbsp;</b></th>
					</tr>
					<tr>
						<th align="right" width="120px"> เล่ม / หน้า &nbsp;</th>
						<th align="right" width="60px" style="background-color: yellow;"> <b>{{ @$asset->IndenAssetToDataOwner->OwnershipToAsset->Land_Book }} &nbsp;</b></th>
						<th align="right" width="60px" style="background-color: yellow;"> <b>{{ @$asset->IndenAssetToDataOwner->OwnershipToAsset->Land_BookPage }} &nbsp;</b></th>
						<th align="right" width="105px"> เนื้อที่ &nbsp;</th>
						<th align="right" width="195px" style="background-color: yellow;"> <b>{{ @$asset->IndenAssetToDataOwner->OwnershipToAsset->Land_SizeRai }} &nbsp;ไร่ &nbsp;{{ @$asset->IndenAssetToDataOwner->OwnershipToAsset->Land_SizeNgan }} &nbsp;งาน &nbsp;{{ @$asset->IndenAssetToDataOwner->OwnershipToAsset->Land_SizeSquareWa }} &nbsp;ตารางวา </b></th>
					</tr>
					<tr>
						<th align="right" width="120px"> ตำบล &nbsp;</th>
						<th class="right" width="120px" style="background-color: yellow;"> <b>{{ @$asset->IndenAssetToDataOwner->OwnershipToAsset->Land_Tambon }}</b></th>
						<th align="right" width="105px"> อำเภอ &nbsp;</th>
						<th class="right" width="195px" style="background-color: yellow;"> <b>{{ @$asset->IndenAssetToDataOwner->OwnershipToAsset->Land_District }}</b></th>
					</tr>
					<tr>
						<th align="right" width="120px"> จังหวัด &nbsp;</th>
						<th class="right" width="120px" style="background-color: yellow;"> <b>{{ @$asset->IndenAssetToDataOwner->OwnershipToAsset->Land_Province }}</b></th>
						<th align="right" width="105px"> เลขไปรษณีย์ &nbsp;</th>
						<th class="right" width="195px" style="background-color: yellow;"> <b>{{ @$asset->IndenAssetToDataOwner->OwnershipToAsset->Land_PostalCode }}</b></th>
					</tr>

					<tr>
						<th align="right" width="120px"> ระยะเวลาครอบครอง &nbsp;</th>
						<th class="right" width="120px" style="background-color: yellow;"> <b>{{ @$asset->IndenAssetToDataOwner->OwnershipToAssetDetail->OccupiedTime }}</b></th>
						<th align="right" width="105px"> วันครอบครองล่าสุด &nbsp;</th>
						<th class="right" width="195px" style="background-color: yellow;"> <b>{{ date('d-m-Y', strtotime(@$asset->IndenAssetToDataOwner->OwnershipToAssetDetail->OccupiedDT)) }}</b></th>
					</tr>
					<tr>
						<th align="right" width="120px"> ราคากลาง &nbsp;</th>
						<th align="left" width="120px" style="background-color: yellow;"> <b>{{ number_format(@$asset->IndenAssetToDataOwner->OwnershipToAsset->Price_Asset, 2) }} &nbsp;</b></th>
					</tr>
					<tr>
						<th align="right" width="120px"> รายละเอียดที่ดิน&nbsp;</th>
						<th class="text-center" width="420px" style="background-color: yellow;"> <b>{{ @$asset->IndenAssetToDataOwner->OwnershipToAsset->Land_Detail }}</b></th>
					</tr>
				@endforeach
			</table>
		@elseif(@$data->ContractToTypeLoan->id_rateType == 'car' || @$data->ContractToTypeLoan->id_rateType == 'moto')
			@if (count($assetAll) != 0 && $assetAll != null)
				<h4 align="left"><u>รายละเอียดรถ</u></h4>
				@foreach ($assetAll as $asset)
					@if (@$asset->IndenAssetToDataOwner->OwnershipToAsset->TypeAsset_Code == 'car' || @$asset->IndenAssetToDataOwner->OwnershipToAsset->TypeAsset_Code == 'moto')
						@if (@$asset->IndenAssetToDataOwner->OwnershipToAsset->TypeAsset_Code == 'car')
							@php
								$brand = @$asset->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarBrand->Brand_car;
								$group = @$asset->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarGroup->Group_car;
								$model = @$asset->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarModel->Model_car;
								$gear = @$asset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Gear;
								$year = @$asset->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarYear->Year_car;
							@endphp
						@else
							@php
								$brand = @$asset->IndenAssetToDataOwner->OwnershipToAsset->AssetToMotoBrand->Brand_moto;
								$group = @$asset->IndenAssetToDataOwner->OwnershipToAsset->AssetToMotoGroup->Group_moto;
								$model = @$asset->IndenAssetToDataOwner->OwnershipToAsset->AssetToMotoModel->Model_moto;
								$gear = @$asset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Gear;
								$year = @$asset->IndenAssetToDataOwner->OwnershipToAsset->AssetToMotoYear->Year_moto;
							@endphp
						@endif
						@php
							$Vehicle_Color = @$asset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Color;
							$Vehicle_Chassis = @$asset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Chassis;
							$Vehicle_Engine = @$asset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Engine;
						@endphp
					@endif

					<table border="1">
						<thead>
							<tr align="center">
								<th class="text-center" width="120px">ยี่ห้อ</th>
								<th class="text-center" width="60px">ปี</th>
								<th class="text-center" width="60px">สี</th>
								<th class="text-center" width="105px">ป้ายเดิม</th>
								<th class="text-center" width="100px">ป้ายใหม่</th>
								<th class="text-center" width="95px">เลขไมล์</th>
							</tr>
						</thead>
						<tbody>
							<tr align="center" style="background-color: yellow;">
								<td width="120px"> <b>{{ @$brand }}</b></td>
								<td width="60px"> <b>{{ @$year }}</b></td>
								<td width="60px"> <b>{{ @$Vehicle_Color }}</b></td>
								<td width="105px"> <b>{{ @$asset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_OldLicense }}</b></td>
								<td width="100px"> <b>{{ @$asset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_NewLicense }}</b></td>
								<td width="95px"> <b>{{ @$asset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Miles }}</b></td>
							</tr>
						</tbody>
					</table>
					<table border="1">
						<tr>
							<th align="right" width="120px"> เลขตัวถัง &nbsp;</th>
							<th align="left" width="120px" style="background-color: yellow;">
								<b>{{ @$asset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Chassis }}</b>
							</th>
							<th align="right" width="105px"> เลขเครื่อง &nbsp;</th>
							<th align="left" width="195px" style="background-color: yellow;"> <b>{{ @$asset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Engine }}&nbsp;</b></th>
						</tr>
						<tr>
							<th align="right" width="120px"> ประเภทรถ &nbsp;</th>
							<th align="left" width="120px" style="background-color: yellow;">
								<b>{{ @$asset->IndenAssetToDataOwner->OwnershipToAsset->DataAssetToRateType->nametype_car }}</b>
							</th>
							<th align="right" width="105px"> กลุ่มรถ &nbsp;</th>
							<th align="left" width="195px" style="background-color: yellow;"> <b>{{ @$group }} &nbsp;</b></th>
						</tr>
						<tr>
							<th align="right" width="120px"> รุ่นรถ &nbsp;</th>
							<th align="left" width="420px" style="background-color: yellow;"> <b>{{ @$model }}</b></th>
						</tr>
						<tr>
							<th align="right" width="120px"> เกียร์รถ &nbsp;</th>
							<th align="left" width="120px" style="background-color: yellow;"> <b>{{ @$gear }}</b></th>
							<th align="right" width="105px"> ราคากลาง &nbsp;</th>
							<th align="left" width="195px" style="background-color: yellow;"> <b>{{ number_format(@$asset->IndenAssetToDataOwner->OwnershipToAsset->Price_Asset, 2) }} &nbsp;</b></th>
						</tr>
					</table>
				@endforeach
			@endif
		@endif
	@endif
	<br />
	<h4 class="page_break" align="left"><u>รายละเอียดยอดจัด</u></h4>
	<table border="1">
		<tr>
			<th align="right" width="120px"> เปอร์เซ็นต์จัดไฟแนนซ์ &nbsp;</th>
			<th align="left" width="120px" style="background-color: yellow;"> <b> {{ @$calculate->Percent_Car }}% &nbsp;</b></th>
			<th align="right" width="105px"> ยอดจัด &nbsp;</th>
			@php
				$valPa = 0;
				if (strtoupper(@$calculate->Buy_PA) == 'YES' && strtoupper(@$calculate->Include_PA) == 'YES') {
				    $valPa = @$calculate->Insurance_PA;
				}
				// เช็ค การรวมค่าธรรมเนียมในยอดจัด
				$_valProcess_Car = 0;
				if (strtoupper(@$calculate->StatusProcess_Car) == 'YES') {
				    $_valProcess_Car = @$calculate->Process_Car;
				}
			@endphp
			<th align="left" width="{{ @$data->ContractToOperated->Downpay_Price != null ? '100px' : '195px' }}" style="background-color: yellow;"> <b>{{ number_format(floatval(@$calculate->Cash_Car) + floatval(@$_valProcess_Car) + floatval(@$calculate->Insurance) + floatval(@$valPa), 2) }}</b></th>
			@if (!empty(@$data->ContractToOperated->Downpay_Price))
				<th align="right" width="40px"> เงินดาวน์ &nbsp;</th>
				<th align="left" width="55px" style="background-color: yellow;"> <b>{{ number_format(floatval(@$data->ContractToOperated->Downpay_Price), 2) }}</b></th>
			@endif
		</tr>
		{{-- <tr>
          <th align="right" width="120px"> &nbsp;</th>
          <th align="right" width="120px" style="background-color: yellow;"> <b> </b></th>
          <th align="right" width="105px"> ค่าดำเนินการ &nbsp;</th>
          <th align="right" width="195px" style="background-color: yellow;"> <b>{{number_format(@$calculate->Process_Car,2)}} &nbsp;</b></th>
        </tr> --}}
		<tr>
			<th align="right" width="120px"> ค่างวดก่อน Vat &nbsp;</th>
			<th align="left" width="120px" style="background-color: yellow;">
				@if (@$data->ContractToTypeLoan->id_rateType != 'land')
					<b>{{ number_format(@$calculate->Duerate_Rate, 2) }} &nbsp;</b>
				@endif
			</th>
			<th align="right" width="105px"> ดอกเบี้ย/เดือน &nbsp;</th>
			<th align="left" width="195px" style="background-color: yellow;"><b> {{ number_format(@$calculate->totalInterest_Car, 3) }} &nbsp;</b></th>
		</tr>
		<tr>
			<th align="right" width="120px"> VAT {{ @$calculate->Vat_Rate }}% &nbsp;</th>
			<th align="left" width="120px" style="background-color: yellow;">
				@if (@$data->ContractToTypeLoan->id_rateType != 'land')
					<b>{{ number_format(@$calculate->Vat_Rate, 2) }}&nbsp;</b>
				@endif
			</th>
			<th align="right" width="105px"> ดอกเบี้ยรายปี (Promo) &nbsp;</th>
			<th align="left" width="195px" style="background-color: yellow;"> <b>{{ number_format(@$calculate->InterestYear_Car, 3) }} &nbsp;</b></th>
		</tr>
		<tr>
			<th align="right" width="120px"> ยอดก่อนPA</th>
			<th align="left" width="120px" style="background-color: yellow;"> <b>{{ number_format(@$calculate->TotalPeriodNonPa, 2) }}&nbsp;</b></th>
			<th align="right" width="105px">ระยะเวลาผ่อน &nbsp;</th>
			<th align="left" width="195px" style="background-color: yellow;"> <b> {{ @$calculate->Timelack_Car }} งวด &nbsp;</b></th>
		</tr>
		<tr>
			<th align="right" width="120px"> ปิดที่ &nbsp;</th>
			<th align="left" width="120px" style="background-color: yellow;"> <b> {{ @$data->ContractToOperated->AccountClose_Place }} &nbsp;</b> </th>
			<th align="right" width="105px">ชำระต่องวด &nbsp;</th>
			<th align="left" width="195px" style="background-color: yellow;"> <b> {{ number_format(@$calculate->Period_Rate, 2) }} &nbsp;</b></th>
		</tr>
		<tr>
			<th align="right" width="120px"> ยอดปิดบัญชี &nbsp;</th>
			<th align="left" width="120px" style="background-color: yellow;"> <b>{{ number_format(@$data->ContractToOperated->AccountClose_Price, 2) }} &nbsp;</b></th>
			<th align="right" width="105px"> ยอดผ่อนชำระทั้งหมด &nbsp;</th>
			<th align="left" width="195px" style="background-color: yellow;"> <b>{{ number_format(@$calculate->TotalPeriod_Rate, 2) }} &nbsp;</b></th>
		</tr>
		@php
			if (@$data->ContractToTypeLoan->Loan_Group == '1') {
			    $intersetAll = @$calculate->Tax_Rate2;
			    $nonvat = floatval(@$calculate->Duerate2_Rate) - (floatval(@$calculate->Cash_Car) + floatval(@$_valProcess_Car) + floatval(@$valPa));
			} else {
			    $intersetAll = 0;
			    $nonvat = floatval(@$calculate->Profit_Rate);
			}
		@endphp
		<tr>
			<th align="right" width="120px"> วันที่ชำระงวดแรก &nbsp;</th>
			@if (@$data->DateDue_Con != null)
				<th align="left" width="120px" style="background-color: yellow;"> <b>{{ date('d-m-Y', strtotime(@$data->DateDue_Con)) }} &nbsp;</b></th>
			@else
				<th align="left" width="120px" style="background-color: yellow;"> <b> &nbsp;</b></th>
			@endif
			<th align="right" width="105px"> ดอกผลทั้งสัญญา &nbsp;</th>
			<th align="left" width="195px" style="background-color: yellow;"> <b>{{ number_format(@$nonvat, 2) }} &nbsp;</b></th>
		</tr>
		<tr>
			<th align="right" width="120px"> แบบ &nbsp;</th>
			<th align="left" width="120px" style="background-color: yellow;">

				@if (@$data->ContractToTypeLoan->id_rateType == 'car' || @$data->ContractToTypeLoan->id_rateType == 'moto')
					<b>{{ @$assetAll[0]->IndenAssetToDataOwner->OwnershipToAssetDetail->AssetToTypePoss->Name_TypePoss }} &nbsp;</b>
				@endif
				{{-- ของเดิม @$data->ContractToIndenture->IndentureToAsset->AssetToAssetDeatil->AssetToTypePoss->Name_TypePoss --}}

			</th>
			<th align="right" width="105px"> ภาษีเช่าซื้อ &nbsp;</th>
			<th align="left" width="195px" style="background-color: yellow;"> <b>{{ number_format(@$calculate->Tax2_Rate, 2) }} &nbsp;</b></th>
		</tr>
		<tr>
			<th align="right" width="120px"> ประกันรถ &nbsp;</th>
			<th align="left" width="120px" style="background-color: yellow;"> <b>{{ number_format(@$calculate->Insurance, 2) }} &nbsp;</b></th>
			<th align="right" width="105px"> ประกัน PA &nbsp;</th>
			<th align="left" width="195px" style="background-color: yellow;"> <b>{{ strtoupper(@$calculate->Buy_PA) == 'YES' && strtoupper(@$calculate->Include_PA) == 'YES' ? number_format(@$calculate->Insurance_PA, 2) : 0 }} &nbsp;</b></th>
		</tr>
	</table>

	<h4 align="left"><u>รายละเอียดค่าใช้จ่าย</u></h4>
	@php
		$Payee = @$data->ContractToPayee;
		$Broker = @$data->ContractToBrokers;
		$dataExpen = @$data->ContractToOperated;
	@endphp
	<table border="1">
		<tr>
			<th align="right" width="120px"> ภาษี &nbsp;</th>
			<th align="left" width="120px" style="background-color: yellow;"> <b>{{ number_format(@$dataExpen->Tax_Price, 2) }} &nbsp;</b></th>
			<th align="right" width="105px"> พ.ร.บ. &nbsp;</th>
			<th align="left" width="195px" style="background-color: yellow;"> <b>{{ number_format(@$dataExpen->Act_Price, 2) }} &nbsp;</b></th>

		</tr>
		<tr>
			<th align="right" width="120px"> ประกัน &nbsp;</th>
			<th align="left" width="120px" style="background-color: yellow;"> <b>{{ number_format(@$dataExpen->P2_Price, 2) }} &nbsp;</b></th>
			<th align="right" width="105px"> ประกัน PA &nbsp;</th>
			<th align="left" width="195px" style="background-color: yellow;"> <b>{{ number_format(@$dataExpen->Insurance_PA, 2) }} &nbsp;</b></th>
		</tr>
		<tr>
			<th align="right" width="120px"> ค่าประเมิณ &nbsp;</th>
			<th align="left" width="120px" style="background-color: yellow;"> <b>{{ number_format(@$dataExpen->Evaluetion_Price, 2) }} &nbsp;</b></th>
			<th align="right" width="105px"> ค่าขนส่ง &nbsp;</th>
			<th align="left" width="195px" style="background-color: yellow;"> <b>{{ number_format(@$dataExpen->Tran_Price, 2) }} &nbsp;</b></th>
		</tr>
		<tr>
			<th align="right" width="120px"> ค่าอื่นๆ&nbsp;</th>
			<th align="left" width="120px" style="background-color: yellow;"> <b>{{ number_format(@$dataExpen->Other_Price, 2) }} &nbsp;</b></th>
			<th align="right" width="105px"> ค่าอากร &nbsp;</th>
			<th align="left" width="195px" style="background-color: yellow;"> <b>{{ number_format(@$dataExpen->Duty_Price, 2) }} &nbsp;</b></th>
		</tr>
		<tr>
			<th align="right" width="120px"> การตลาด &nbsp;</th>
			<th align="left" width="120px" style="background-color: yellow;"> <b>{{ number_format(@$dataExpen->Marketing_Price, 2) }} &nbsp;</b></th>
			<th align="right" width="105px"> หักค่างวดล่วงหน้า &nbsp;</th>
			<th align="left" width="195px" style="background-color: yellow;"> <b>{{ number_format(@$dataExpen->DuePrepaid_Price, 2) }} &nbsp;</b></th>
		</tr>
		<tr>
			<th align="right" width="120px"> ค่าใช้จ่ายรวม &nbsp;</th>
			<th align="left" width="120px" style="background-color: yellow;"> <b>{{ number_format(@$dataExpen->Total_Price - @$dataExpen->Process_Price, 2) }} &nbsp;</b></th>
			<th align="right" width="105px"> การผ่อน &nbsp;</th>
			<th align="left" width="195px" style="background-color: yellow;"> <b>{{ @$dataExpen->Installment }}</b></th>
		</tr>
		{{-- @if (@$dataExpen->BRK_Payee != null)
          <tr>
            <th align="right" width="120px"> ธนาคาร &nbsp;</th>
            <th align="left"  width="120px" style="background-color: yellow;"> <b>{{@$dataExpen->OperatedToBrokerPayee->NameAccount_Broker}} &nbsp;</b></th>
            <th align="right" width="105px"> เลขที่บัญชี &nbsp;</th>
            <th align="left"  width="195px" style="background-color: yellow;"> <b>{{@$dataExpen->OperatedToBrokerPayee->Account_Broker}} &nbsp;</b></th>
          </tr>
          <tr>
            <th align="right" width="120px"> สาขา &nbsp;</th>
            <th align="left"  width="120px" style="background-color: yellow;"> <b>{{@$dataExpen->OperatedToBrokerPayee->AccountBranch_Broker}} &nbsp;</b></th>
            <th align="right" width="105px" > ยอดโอนลูกค้า &nbsp;</th>
            <th align="left"  width="195px" style="background-color: yellow;"><b>{{number_format(@$data->ContractToOperated->Balance_Price)}}</b> บาท &nbsp;</th>
          </tr>
          <tr>
            <th align="right" width="120px" > เบอร์โทรศัพท์ &nbsp;</th>
            <th align="left"  width="120px" style="background-color: yellow;"> <b>{{@$dataExpen->OperatedToBrokerPayee->Phone_Broker}} &nbsp;</b></th>
            <th align="right" width="105px"> ผู้รับเงิน &nbsp;</th>
            <th align="left"  width="195px" style="background-color: yellow;"> <b>{{@$dataPayee->Name_Cus}}</b></th>
          </tr>
          <tr>
            <th width="540px"></th>
          </tr>
        @else --}}

		@if ($Payee != null && count($Payee) > 0)
			<tr>
				<th align="center" colspan = "4"><b>ข้อมูลผู้รับเงิน</b></th>
			</tr>
			@foreach ($Payee as $dataPayee)
				<tr>
					<th align="right" width="120px"> ผู้รับเงิน &nbsp;</th>
					<th align="left" width="120px" style="background-color: yellow;"> <b>{{ @$dataPayee->PayeetoCus->Name_Cus }}</b></th>
					<th align="right" width="105px"> เบอร์โทรศัพท์ &nbsp;</th>
					<th align="left" width="195px" style="background-color: yellow;">
						{{-- <b>{{ @$dataPayee->PayeetoCus->Phone_cus }} &nbsp;</b> --}}
						@if ( !empty( getFirstPhone_php(@$dataPayee->PayeetoCus->Phone_cus) ) )
							<b> {{formatPhoneNumber( getFirstPhone_php(@$dataPayee->PayeetoCus->Phone_cus), '99 9999 9999' )}}</b>
						@endif
						@php
							$phone_cus_2 = "";
							if ( empty(@$dataPayee->PayeetoCus->Phone_cus2) ) {
								$_phone_numbers = explode(',', @$dataPayee->PayeetoCus->Phone_cus);
								if ( isset($_phone_numbers[1]) ) {
									$phone_cus_2 = $_phone_numbers[1];
								}
							} else {
								$phone_cus_2 = @$dataPayee->PayeetoCus->Phone_cus2;
							}
						@endphp
						@if ( !empty( $phone_cus_2 ) )
							<b>, {{formatPhoneNumber( $phone_cus_2, '99 9999 9999')}}</b>
						@endif
					</th>
				</tr>
				<tr>
					<th align="right" width="120px"> ธนาคาร &nbsp;</th>
					<th align="left" width="120px" style="background-color: yellow;"> <b>{{ @$dataPayee->PayeetoCus->Name_Account }} &nbsp;</b></th>
					<th align="right" width="105px"> เลขที่บัญชี &nbsp;</th>
					<th align="left" width="195px" style="background-color: yellow;"> <b>{{ @$dataPayee->PayeetoCus->Number_Account }} &nbsp;</b></th>
				</tr>

				<!-- โอนเงินให้ลูกค้าล่วงหน้า -->
				@if( @$data->ContractToOperated->ReceiveCashBefore > 0 )
					<tr>
						<th align="right" width="120px"> สาขา &nbsp;</th>
						<th align="left" width="120px" style="background-color: yellow;"> <b>{{ @$dataPayee->PayeetoCus->Branch_Account }} &nbsp;</b></th>
						<th align="right" width="105px"> {{ @$dataPayee->status_Payee == 'Payee' ? 'ยอดโอนลูกค้าล่วงหน้า' : 'ยอดโอนปิดบัญชี' }} &nbsp;</th>
						<th align="left" width="195px" style="background-color: yellow;"> <b>{{ number_format(@$dataPayee->status_Payee == 'Payee' ? @$data->ContractToOperated->ReceiveCashBefore : @$data->ContractToOperated->AccountClose_Price, 2) }}</b> บาท &nbsp;</th>
					</tr>
					@if( @$dataPayee->status_Payee == 'Payee' )
						<tr>
							<th align="right" width="120px">วันครบกำหนดโอนส่วนที่เหลือ &nbsp;</th>
							<th align="left" width="120px" style="background-color: yellow;"> <b>{{ @$data->ContractToOperated->LastTransfer != null ? date('d-m-Y', strtotime(@$data->ContractToOperated->LastTransfer)) : '' }}</b></th>
							<th align="right" width="105px"> ยอดโอนเงินลูกค้าส่วนที่เหลือ &nbsp;</th>
							<th align="left" width="195px" style="background-color: yellow;"> <b>{{ number_format(@$data->ContractToOperated->Balance_Price - @$data->ContractToOperated->ReceiveCashBefore, 2) }}</b> บาท &nbsp;</th>
						</tr>
						<tr>
							<th align="right" width="240px" colspan="2"></th>
							<th align="right" width="105px"> ยอดโอนเงินลูกค้าสุทธิ &nbsp;</th>
							<th align="left" width="195px" style="background-color: yellow;"> <b>{{ number_format(@$data->ContractToOperated->Balance_Price, 2) }}</b> บาท &nbsp;</th>
						</tr>
					@endif
				@else
				<tr>
					<th align="right" width="120px"> สาขา &nbsp;</th>
					<th align="left" width="120px" style="background-color: yellow;"> <b>{{ @$dataPayee->PayeetoCus->Branch_Account }} &nbsp;</b></th>
					<th align="right" width="105px"> {{ @$dataPayee->status_Payee == 'Payee' ? 'ยอดโอนลูกค้า' : 'ยอดโอนปิดบัญชี' }} &nbsp;</th>
					<th align="left" width="195px" style="background-color: yellow;"> <b>{{ number_format(@$dataPayee->status_Payee == 'Payee' ? @$data->ContractToOperated->Balance_Price : @$data->ContractToOperated->AccountClose_Price, 2) }}</b> บาท &nbsp;</th>
				</tr>
				@endif

			@endforeach

		@endif

		@if ($Broker != null && count($Broker) > 0)
			<tr>
				<th align="center" colspan = "4"><b>ข้อมูลผู้แนะนำ</b></th>
			</tr>
			@foreach ($Broker as $dataBroker)
				<tr>
					<th align="right" width="120px"> ผู้แนะนำ &nbsp;</th>
					<th align="left" width="120px" style="background-color: yellow;"> <b>{{ @$dataBroker->BrokertoCus->Name_Cus }}</b></th>
					<th align="right" width="105px"> ธนาคาร &nbsp;</th>
					<th align="left" width="195px" style="background-color: yellow;"> <b>{{ @$dataBroker->BrokertoCus->Name_Account }} &nbsp;</b></th>
				</tr>
				<tr>
					<th align="right" width="120px"> เลขที่บัญชี &nbsp;</th>
					<th align="left" width="120px" style="background-color: yellow;"> <b>{{ @$dataBroker->BrokertoCus->Number_Account }} &nbsp;</b></th>
					<th align="right" width="105px"> สาขา &nbsp;</th>
					<th align="left" width="195px" style="background-color: yellow;"> <b>{{ @$dataBroker->BrokertoCus->Branch_Account }} &nbsp;</b></th>
				</tr>
				<tr>
					<th align="right" width="120px"> ค่าคอม หลังหัก &nbsp;</th>
					<th align="left" width="120px" style="background-color: yellow;"> <b>{{ number_format(@$dataBroker->SumCom_Broker, 2) }}</b> บาท &nbsp;</th>
					<th align="right" width="105px"> เบอร์โทรศัพท์ &nbsp;</th>
					<th align="left" width="195px" style="background-color: yellow;"> <b>{{ @$dataBroker->BrokertoCus->Phone_cus }}</b></th>
				</tr>
			@endforeach
		@endif
		<tr>
			<th align="center" colspan = "4"><b>ข้อมูลการขออนุมัติ</b></th>
		</tr>
		<tr>
			<th align="right" width="120px"> เจ้าหน้าที่สินเชื่อ &nbsp;</th>
			<th align="left" width="120px" style="background-color: yellow;"> <b>{{ @$data->ContractToUserApp->name }}</b></th>
			<th align="right" width="105px"> สาขา &nbsp;</th>
			<th align="left" width="195px" style="background-color: yellow;"> <b>{{ @$data->ContractToBranch->Name_Branch }}</b></th>
		</tr>
		<tr>
			<th align="right" width="120px"> ผู้อนุมัติ &nbsp;</th>
			<th align="left" width="120px" style="background-color: yellow;"> <b>{{ @$data->ContractToConfirmApp->name }}</b></th>
			<th align="right" width="105px"> วันที่อนุมัติ &nbsp;</th>
			<th align="left" width="195px" style="background-color: yellow;"> <b>{{ @$data->DateConfirmApp_Con != null ? date('d-m-Y', strtotime(@$data->DateConfirmApp_Con)) : '' }} &nbsp;</b></th>
		</tr>
		<tr>
			<th align="right" width="120px"> ขออนุมัติพิเศษ &nbsp;</th>
			<th align="left" width="120px" style="background-color: yellow;"> <b> {{ @$data->ContractToBookSpecial->Special_Name != null ? @$data->ContractToBookSpecial->Special_Name : '-' }} &nbsp;</b></th>
			<th align="right" width="105px">วันที่โอนเงิน &nbsp;</th>
			<th align="left" width="195px" style="background-color: #90F084;"> <b>{{ @$data->Date_monetary != null ? date('d-m-Y', strtotime(@$data->Date_monetary)) : '' }}</b></th>
		</tr>
		<tr>
			<th align="right" width="120px"> วัตถุประสงค์/เหตุผล &nbsp;</th>
			<th class="text-center" width="420px" style="background-color: yellow;"> <b>{{ @$data->Memo_Con }}</b></th>
		</tr>
	</table>

	{{-- <h4 align="left"><u>รายละเอียดเพิ่มเติม</u></h4>
      <table border="1">
        <tbody>
          <tr>
            <th align="right" width="120px"> Credo Code &nbsp;</th>
            <th class="text-center" width="120px" style="background-color: yellow;"> <b>{{@$data->ContractToDataCusTags->Credo_Code}}</b></th>
            <th align="right" width="105px"> หมายเหตุ Credo &nbsp;</th>
            <th class="text-center" width="195px" style="background-color: yellow;"> <b>{{@$data->ContractToDataCusTags->Credo_Note}}</b></th>
          </tr>
          <tr>
            <th align="right" width="120px"> รายละเอียดอาชีพ &nbsp;</th>
            <th class="text-center" width="420px" style="background-color: yellow;"> <b>{{@$data->ConstoBuyers->CareerDetail_buyer}}</b></th>
          </tr>
          <tr>
            <th align="right" width="120px"> วัตถุประสงค์/เหตุผล &nbsp;</th>
            <th class="text-center" width="420px" style="background-color: yellow;"> <b>{{@$data->Memo_Objective}}</b></th>
          </tr>
          <tr>
            <th align="right" width="120px"> ผลการตรวจสอบ &nbsp;</th>
            <th class="text-center" width="420px" style="background-color: yellow;"> <b>{{@$data->Check_Prefer}}</b></th>
          </tr>
          <tr>
            <th class="text-center" width="540px"></th>
          </tr>
          <tr>
            <th align="right" width="120px"> ผลประเมินพนักงาน &nbsp;</th>
            <th class="text-center" width="420px" style="background-color: yellow;"> <b>{{@$data->Check_RateScore}}</b></th>
          </tr>
          <tr>
            <th align="right" width="120px"> คะแนนบริการลูกค้า &nbsp;</th>
            <th class="text-center" width="420px" style="background-color: yellow;"> <b>{{@$data->Check_Customer}}</b></th>
          </tr>
          <tr>
            <th align="right" width="120px"> คะแนนบริการนายหน้า &nbsp;</th>
            <th class="text-center" width="420px" style="background-color: yellow;"> <b>{{@$data->Check_broker}}</b></th>
          </tr>
        </tbody>
      </table> --}}
</body>

</html>
