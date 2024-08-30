<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8">
	<title></title>

	<style>
		@page {
			margin: 3%;
		}

		@font-face {
			font-family: 'THSarabun';
			font-style: normal;
			font-weight: normal;
			src: url("{{ public_path('fonts/THSarabun.ttf') }}") format('truetype');
		}

		@font-face {
			font-family: 'THSarabun';
			font-style: Bold;
			font-weight: Bold;
			src: url("{{ public_path('fonts/THSarabun Bold.ttf') }}") format('truetype');
		}

		@font-face {
			font-family: 'THSarabun';
			font-style: Italic;
			font-weight: Italic;
			src: url("{{ public_path('fonts/THSarabun Italic.ttf') }}") format('truetype');
		}

		body {
			font-family: "THSarabun";
			margin: 1;
		}

		table {
			width: 100%;
			border-collapse: collapse;
		}

		/* .h-tbody{
			height: 134px;
		} */
		.txt-td {
			height: 134px;
			vertical-align: top;
		}

		.spac-ms {
			padding-left: 5px;
		}

		.spac-md {
			padding-right: 5px;
		}

		.rs-margin {
			margin: 0px;
		}
	</style>

<body>
	<table border="0" width="100%" style="margin-bottom: 5px;">
		<tr style="line-height: 80%">
			<td width="80%"></td>
			<td width="20%" align="right">
				{{-- <P class="rs-margin">พิมพ์ : {{ date('d-m-Y', strtotime($CHQMas->BILLDT)) }}</P> --}}
				<P class="rs-margin">พิมพ์ : {{ date('d-m-Y') }}</P>
				<P class="rs-margin">เลขที่ใบรับ : {{ $CHQMas->BILLNO }}</P>
				<P class="rs-margin">วันที่ชำระ : {{ formatDateThaiShort(@$CHQMas->BILLDT)}}</P>
				
			</td>
		</tr>
	</table>

	<table border="0" width="100%" style="margin-bottom: 5px">
		<tr style="line-height: 90%;">
			<td width="10%">ชื่อ - นามสกุล :</td>
			<td width="30%">{{ $contcus->Prefix . ' ' . $contcus->Name_Cus }}</td>
			<td width="8%">เลขสัญญา : </td>
			<td width="40%">{{ $contcus->CONTNO }}</td>
		</tr>
		<tr style="line-height: 90%;">
			<td width="10%">
				<div style="margin-bottom: 40px;">ที่อยู่ :</div>
			</td>
			<td width="30%">
				<div style="margin-bottom: 25px;">
					<p class="rs-margin">{{ $contcus->houseNumber_Adds . '  หมู่ที่ ' . $contcus->houseGroup_Adds }} &nbsp;&nbsp;&nbsp; ต.{{ $contcus->houseTambon_Adds }}</p>
					<p class="rs-margin">{{ 'อ.' . $contcus->houseDistrict_Adds }} &nbsp;&nbsp;&nbsp; จ.{{ $contcus->houseProvince_Adds }}&nbsp;&nbsp;{{ $contcus->Postal_Adds }}</p>
				</div>
			</td>
			<td width="8%">
				<div style="margin-bottom: 40px;">ทรัพย์ :</div>
			</td>
			<td width="40%">
				@if ($contcus->id_rateType == 'land')
					<table border="0">
						<tr>
							<td width="15%">ประเภท :</td>
							<td width="35%">{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->DataAssetToLandType->nametype_car }}</td>
							<td width="17%">เลขที่โฉนด :</td>
							<td>{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Land_Id }}</td>
						</tr>
						<tr>
							<td>เลขที่ดิน :</td>
							<td>{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Land_ParcelNumber }}</td>
							<td>เล่ม/หน้า :</td>
							<td>{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Land_Book . '/' . @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Land_BookPage }}</td>
						</tr>
						<tr>
							<td>อำเภอ :</td>
							<td>{{ Str::limit(@$contasset->IndenAssetToDataOwner->OwnershipToAsset->Land_District, 25) }}</td>
							<td>จังหวัด :</td>
							<td>{{ Str::limit(@$contasset->IndenAssetToDataOwner->OwnershipToAsset->Land_Province, 25) }}</td>
						</tr>
					</table>
				@else
					<table border="0">
						<tr>
							<td width="16%">ประเภท :</td>
							<td width="45%">{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarType->nametype_car }}</td>
							<td width="16%">ยี่ห้อ :</td>
							<td>{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarBrand->Brand_car }}</td>
						</tr>
						<tr>
							<td width="16%">กลุ่ม :</td>
							<td>{{ Str::limit(@$contasset->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarGroup->Group_car, 25) }}</td>
							<td width="16%">ปี :</td>
							<td>{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarYear->Year_car }}</td>
						</tr>
						<tr>
							<td width="16%">รุ่น :</td>
							<td>{{ Str::limit(@$contasset->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarModel->Model_car, 25) }}</td>
							<td width="16%">ทะเบียน :</td>
							<td>{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_NewLicense == null ? @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_OldLicense : @$contasset->IndenAssetToDataOwner->Vehicle_NewLicense }}</td>
						</tr>
					</table>
				@endif
			</td>
		</tr>
	</table>

	<span>ชำระโดย : {{ @$CHQMas->CHMasPAYTYP->PAYDESC }} วันที่ชำระ : {{ formatDateThaiShort(@$CHQMas->BILLDT)}}</span>
	<table border="1" width="100%">
		<thead>
			<tr style="background-color: #D9E2F3;">
				<th width="5%">ลำดับ</th>
				<th width="30%">ชำระค่า</th>
				<th width="15%">หักลูกหนี้</th>
				<th width="10%">ส่วนลด</th>
				<th width="10%">ค่าปรับ</th>
				<th width="10%">ลดค่าปรับ</th>
				<th width="10%">ค่าทวงถาม</th>
				<th width="10%">ลดทวงถาม</th>
				<th width="20%">รับสุทธิ</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($CHQTran as $key => $item)
				<tr>
					<td align="center">{{ @$key+1 }}</td>
					<td class="spac-ms">
						@php
							if($contcus->Loan_Com==1){
								@$due = @$item->F_PAR . ' ' . @$item->F_PAY . ' ' . @$item->L_PAR . ' ' . @$item->L_PAY;
							}else{
								@$due = @$item->F_PAR . ' ' . @$item->F_PAY . ' ' . @$item->L_PAR . ' ' . @$item->L_PAY;
							}
							
						@endphp
						{{ @$item->PAYCODE->FORDESC }} &nbsp;&nbsp;
						({{ @$due }})
					</td>
					<td align="right" class="spac-md">{{ number_format($item->PAYAMT, 2) }}</td>
					<td align="right" class="spac-md">{{ number_format($item->DISCT, 2) }}</td>
					<td align="right" class="spac-md">{{ number_format($item->PAYINT, 2) }}</td>
					<td align="right" class="spac-md">{{ number_format($item->DSCINT, 2) }}</td>
					<td align="right" class="spac-md">{{ number_format($item->PAYFL, 2) }}</td>
					<td align="right" class="spac-md">{{ number_format($item->DSCPAYFL, 2) }}</td>
					<td align="right" class="spac-md">{{ number_format($item->NETPAY, 2) }}</td>
				</tr>
			@endforeach
		</tbody>
		<tfoot>
			<tr style="background-color: #FBE4D5">
				<td colspan="2" align="center">จำนวนเงินเป็นตัวอักษร</td>
				<td colspan="5" align="center">{{ IntconvertThai($CHQMas->CHQAMT) }}</td>
				<td class="spac-md" align="right">จำนวนเงิน</td>
				<td class="spac-md" align="right">{{ number_format($CHQMas->CHQAMT, 2) }}</td>
			</tr>
		</tfoot>
	</table>
	@if($contcus->CODLOAN==1 && $contcus->CONTTYP == 1 )
	{{-- <span>ลูกหนี้คงเหลือ : {{ number_format(($contcus->TOTPRC - $contcus->SMPAY), 2) }} บาท</span> --}}
	@else
	<span>ลูกหนี้คงเหลือ : {{ number_format(($contcus->TOTPRC - $contcus->SMPAY), 2) }} บาท</span>
	@endif
	<table border="0" width="100%" style="margin-top: 7px;">
		<tr>
			<td width="70%">
				<span><b>ใบเสร็จรับเงินฉบับนี้จะสมบูรณ์เมื่อปรากฏลายเซ็นของผู้รับเงินครบถ้วนและเช็คของท่านผ่านบัญชีบริษัทฯ เรียบร้อยแล้ว.</b></span>
			</td>
			<td width="30%" align="center">
				<span><b>ผู้รับเงิน__________________________</b></span>
			</td>
		</tr>
		<tr style="line-height: 50%">
			<td colspan="2">
				<p style="border-style: dashed; border-top: 0px; font-size: 2px; border-width: 1px;"></p>
			</td>
		</tr>
	</table>

	{{-- <table border="1" width="100%"> --}}
	<table border="0" width="100%" style="margin-top: 10px; border: 1px solid; border-color: #dfdfdf">
		<thead>
			<tr style="line-height: 130%; background-color: #D9E2F3; font-size: 17px">
				<th align="left" class="spac-ms" colspan="3">
					<span><b> ใบเสร็จรับชำระเงินหรือบริการ</b></span>
					<span><b> (Bill PaymentPay-in-Slip)</b></span>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td class="spac-ms" width="50%" style="display: flex; align-items: center; width: 100%;">
					<p class="rs-margin">{{ $contcus->Company_Name }}</p>
					<p class="rs-margin">{{ $contcus->Company_Addr }}</p>
					<p class="rs-margin">โทร. {{ $contcus->Company_Tel }} แฟกซ์. {{ $contcus->Company_fax }}</p>

					<p style="margin-bottom: 0px;"><b>ธนาคารอื่นๆ ที่ให้บริการรับชำระบิล Biler ID : {{ $contcus->Company_Id }}</b></p>
					<img src="{{ asset('assets/images/payments/all_bank-v2.png') }}" alt="" width="180px">
				</td>
				<td width="50%" colspan="2">
					<p class="rs-margin" align="right"><b>โปรดเรียกเก็บค่าธรรมเนียมตากผู้ชำระเงิน</b> &nbsp;</p>
					{{-- <table border="1" style="border-style: solid;border-left-style: solid; border-right-style: solid; !important"> --}}
					<table border="1">
						<thead>
							<tr align="left" style="line-height: 100%; background-color: #D9E2F3; border-bottom: 1px solid;">
								<th class="spac-ms" style="border-right: 1px solid;">สาขา </th>
								<th class="spac-ms">วันที่ </th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="spac-ms" colspan="2">ชื่อลูกค้า : &nbsp;&nbsp;&nbsp; {{ $contcus->Prefix . ' ' . $contcus->Name_Cus }}</td>
							</tr>
							<tr>
								<td class="spac-ms" width="50%">Customer No. (Ref. No.1) : </td>
								<td class="spac-ms" width="50%"> {{ $contcus->CONTNO }} </td>
							</tr>
							<tr>
								<td class="spac-ms" width="50%">Customer No. (Ref. No.2) : </td>
								<td class="spac-ms" width="50%"> 006 </td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<tr>
				<td></td>
				<td align="center" style="border: 1px solid;border-color: #dfdfdf; padding-top: 5px;">
					<img height="50" src="{{ getcwd() . '/cache_barcode/' . $_namefile[1] . '.svg' }}" alt="qrcode">
				</td>
				<td align="center" style="border: 1px solid;border-color: #dfdfdf; padding-top: 5px;">
					<span style="">
						<img height="30" width="225" src="{{ getcwd() . '/cache_barcode/' . $_namefile[0] . '.png' }}" alt="barcode" />
						<div>{{ $_namefile[2] }}</div>
					</span>
				</td>
			</tr>
		</tbody>
	</table>

	<br>
	<table border="1" width="100%">
		<tr align="center">
			<td width="47%" style="background-color: #FBE4D5">จำนวนเงิน (Amount)</td>
			<td width="33%"></td>
			<td width="20%" style="background-color: #FBE4D5">บาท (Baht)</td>
		</tr>
	</table>

	<table border="1" width="100%">
		<tr align="center">
			<td width="30%" style="background-color: #FBE4D5">จำนวนเงินเปนตัวอักษร (Amount in Words)</td>
			<td width="70%"></td>
		</tr>
	</table>

	<table border="1" width="100%">
		<tr class="spac-ms">
			<td align="left" width="47%" style="border-bottom: none; padding-left: 5px;">ผู้นำฝาก / Deposit By ..........................................................................</td>
			<td align="center" width="53%" style="background-color: #D9E2F3;">สำหรับเจ้าหน้าที่ธนาคาร</td>
		</tr>
		<tr class="spac-ms">
			<td align="left" width="47%" style="border-top: none; padding-left: 5px;">โทรศัพท์ / Telephone .........................................................................</td>
			<td align="center" width="53%">ผู้รับเงิน .....................................................................................................................</td>
		</tr>
	</table>

	<p style="border-style: dashed; border-top: 0px; font-size: 2px; border-width: 1px; margin-top: 20px; margin-bottom: 20px;"></p>
	<table border="0" width="100%" style="margin-bottom: 5px;">
		<tr style="line-height: 80%">
			<td width="80%"></td>
			<td width="20%" align="right">
				{{-- <P class="rs-margin">พิมพ์ : {{ date('d-m-Y', strtotime($CHQMas->BILLDT)) }}</P> --}}
				<P class="rs-margin">พิมพ์ : {{ date('d-m-Y') }}</P>
				<P class="rs-margin">เลขที่ใบรับ : {{ $CHQMas->BILLNO }}</P>
			</td>
		</tr>
	</table>

	<table border="0" width="100%">
		<tr style="background-color: #D9E2F3">
			<td width="10%" style="border-bottom: none; border-right: none; padding-left: 5px;">ชื่อ - นามสกุล :</td>
			<td width="55%" style="border-bottom: none; border-left: none; padding-left: 5px;"> {{ $contcus->Prefix . ' ' . $contcus->Name_Cus }} </td>
			<td width="15%" style="border-bottom: none; border-right: none; padding-left: 5px;">เลขสัญญา : </td>
			<td width="20%" style="border-bottom: none; border-left: none; padding-left: 5px;"> {{ $contcus->CONTNO }} </td>
		</tr>
		<tr style="border-top: none; padding-left: 5px;background-color: #D9E2F3">
			<td width="10%" style="border-top: none; border-right: none; padding-left: 5px;">ที่อยู่ :</td>
			<td width="55%" style="border-top: none; border-left: none; padding-left: 5px;">
				<p class="rs-margin">
					{{ $contcus->houseNumber_Adds }} หมู่ที่ {{ $contcus->houseGroup_Adds }} ต.{{ $contcus->houseTambon_Adds }}
					อ.{{ $contcus->houseDistrict_Adds }} จ.{{ $contcus->houseProvince_Adds }} {{ $contcus->Postal_Adds }}
				</p>
			</td>
			<td width="15%" style="border-top: none; border-right: none; padding-left: 5px;">เลขที่ผู้เสีบภาษี : </td>
			<td width="20%" style="border-top: none; border-left: none; padding-left: 5px;"> {{ @$contcus->IDCard_cus }} </td>
		</tr>
		<tr>
			<td colspan="2" class="spac-ms">
				@if ($contcus->id_rateType == 'land')
					<table border="0">
						<tr>
							<td width="11%"><b>ประเภท :</b></td>
							<td>{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->DataAssetToLandType->nametype_car }}</td>
							<td width="13%"><b>เลขที่โฉนด : </b></td>
							<td width="15%">{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Land_Id }}</td>
							<td width="11%"><b>เลขที่ดิน : </b></td>
							<td>{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Land_ParcelNumber }}</td>
						</tr>
						<tr style="line-height: 90%;">
							<td><b>ระวาง : </b></td>
							<td>{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Land_SheetNumber }}</td>
							<td><b>หน้าสำรวจ : </b></td>
							<td>{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Land_TambonNumber }}</td>
							<td><b>เล่ม/หน้า : </b></td>
							<td>{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Land_Book . '/' . @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Land_BookPage }}</td>
						</tr>
						<tr style="line-height: 90%;">
							<td><b>เนื้อที่ : </b></td>
							<td>
								{{ (empty(@$contasset->IndenAssetToDataOwner->OwnershipToAsset->Land_SizeRai) ? '-' : @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Land_SizeRai) }}  
								{{ (empty(@$contasset->IndenAssetToDataOwner->OwnershipToAsset->Land_SizeNgan) ? '-' : @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Land_SizeNgan) }}  
								{{ (empty(@$contasset->IndenAssetToDataOwner->OwnershipToAsset->Land_SizeSquareWa) ? '-' : @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Land_SizeSquareWa) }}  
								(ไร-งาน-ตรว.)
							</td>
							<td><b>อำเภอ : </b></td>
							<td>{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Land_District }}</td>
							<td><b>จังหวัด : </b></td>
							<td>{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Land_Province }}</td>
						</tr>
						<tr>
							<td style="border-bottom: 0.05px dashed;" colspan="6"></td>
						</tr>
					</table>
					<table border="0">
						<tr style="line-height: 90%;">
							<td width="12%"><b>ชำระโดย : </b></td>
							<td>{{ @$CHQMas->CHMasPAYTYP->PAYDESC }}</td>
							<td width="15%"><b>งวดที่ : </b></td>
							<td>{{ @$due }}</td>
						</tr>
					</table>
				@else
					<table border="0">
						<tr>
							<td width="11%"><b>ประเภท :</b></td>
							<td>{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarType->nametype_car }}</td>
							<td width="11%"><b>ยี่ห้อ : </b></td>
							<td width="15%">{{ Str::limit(@$contasset->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarBrand->Brand_car, 30) }}</td>
							<td width="11%"><b>กลุ่ม : </b></td>
							<td>{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarGroup->Group_car }}</td>
						</tr>
						<tr style="line-height: 90%;">
							<td width="11%"><b>ปี : </b></td>
							<td>{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarYear->Year_car }}</td>
							<td width="11%"><b>รุ่น : </b></td>
							<td colspan="3">{{ Str::limit(@$contasset->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarModel->Model_car, 40) }}</td>
						</tr>
						<tr style="line-height: 90%;">
							<td width="11%"><b>เกียร์ : </b></td>
							<td>{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Gear }}</td>
							<td width="11%"><b>สี/ขนาด : </b></td>
							<td>{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Color . ' - ' . @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_CC }}</td>
							<td width="11%"><b>ทะเบียน : </b></td>
							<td>{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_NewLicense == null ? @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_OldLicense : @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_NewLicense }}</td>
						</tr>
						<tr>
							<td style="border-bottom: 0.05px dashed;" colspan="6"></td>
						</tr>
					</table>
					<table border="0">
						<tr>
							<td width="12%"><b>เลขตัวถัง : </b></td>
							<td width="34%">{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Chassis }}</td>
							<td width="15%"><b>เลขเครื่อง : </b></td>
							<td>{{ @$contasset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Engine }}</td>
						</tr>
						<tr style="line-height: 90%;">
							<td width="12%"><b>ชำระโดย : </b></td>
							<td>{{ @$CHQMas->CHMasPAYTYP->PAYDESC }}</td>
							<td width="15%"><b>งวดที่ : </b></td>
							<td>{{ $due }}</td>
						</tr>
					</table>
				@endif
			</td>
			<td>
				<table border="0" class="spac-ms">
					<tr>
						<td>ชำระค่างวด</td>
					</tr>
					<tr>
						<td>ส่วนลด</td>
					</tr>
					<tr>
						<td>ค่าปรับ</td>
					</tr>
					<tr>
						<td>ส่วนลดค่าปรับ</td>
					</tr>
					<tr>
						<td>ค่าทวงถาม</td>
					</tr>
					<tr>
						<td>ส่วนลดทวงถาม</td>
					</tr>
				</table>
			</td>
			<td>
				<table border="0" class="spac-md">
					<tr>
						<td align="right">
							<b>{{ number_format($CHQTran->sum('PAYAMT'), 2) }}</b>
						</td>
					</tr>
					<tr>
						<td align="right">
							<b>{{ number_format($CHQTran->sum('DISCT'), 2) }}</b>
						</td>
					</tr>
					<tr>
						<td align="right">
							<b>{{ number_format($CHQTran->sum('PAYINT'), 2) }}</b>
						</td>
					</tr>
					<tr>
						<td align="right">
							<b>{{ number_format($CHQTran->sum('DSCINT'), 2) }}</b>
						</td>
					</tr>
					<tr>
						<td align="right">
							<b>{{ number_format($CHQTran->sum('PAYFL'), 2) }}</b>
						</td>
					</tr>
					<tr>
						<td align="right">
							<b>{{ number_format($CHQTran->sum('DSCPAYFL'), 2) }}</b>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table border="0" width="100%">
		<tr style="background-color: #FBE4D5;line-height: 100%;">
			<td align="center" width="30%" style="border: 1px groove; border-color: #838383;">จำนวนเงินเปนตัวอักษร (Amount in Words)</td>
			<td align="center" width=35%" style="border: 1px groove; border-color: #838383;">{{ IntconvertThai($CHQMas->CHQAMT) }}</td>
			<td align="center" width="15%" style="border: 1px groove; border-color: #838383;"><b>รับชำระสุทธิ</b></td>
			<td align="right" width="20%" class="spac-md" style="border: 1px groove; border-color: #838383;"><b>{{ number_format($CHQMas->CHQAMT, 2) }}</b></td>
		</tr>
		<tr style="line-height: 60%;">
			<td align="center"><b>ผู้รับเงิน__________________________</b></td>
			<td align="left" class="spac-ms">
				<p class="rs-margin" style="font-size: 11px">ใบเสร็จรับเงินฉบับนี้จะสมบูรณ์เมื่อปรากฏลายเซ็นของผู้รับเงินครบถ้วน</p>
				<p class="rs-margin" style="font-size: 11px">และเช็คของท่านผ่านบัญชีบริษัทฯ เรียบร้อยแล้ว.</p>
			</td>
			@if($contcus->CODLOAN==1 && $contcus->CONTTYP == 1 )
			{{-- <td align="center" style="background-color: #FBE4D5; border: 1px groove; border-color: #838383;"><b>ลูกหนี้คงเหลือ</b></td>
			<td align="right" class="spac-md" style="background-color: #FBE4D5; border: 1px groove; border-color: #838383;"><b>{{ number_format(($contcus->TOTPRC - $contcus->SMPAY), 2) }}</b></td> --}}
			@else
			<td align="center" style="background-color: #FBE4D5; border: 1px groove; border-color: #838383;"><b>ลูกหนี้คงเหลือ</b></td>
			<td align="right" class="spac-md" style="background-color: #FBE4D5; border: 1px groove; border-color: #838383;"><b>{{ number_format(($contcus->TOTPRC - $contcus->SMPAY), 2) }}</b></td>
			@endif
		</tr>
	</table>
</body>

</html>
