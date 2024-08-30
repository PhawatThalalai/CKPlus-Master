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
			table-layout: fixed;
			width: 100%;
			border-collapse: collapse;
			vertical-align: middle;
		}

		td {
			white-space: nowrap;
		}

		.font-size-8 {
			font-size: 8px;
		}

		.font-size-12 {
			font-size: 12px;
		}

		.font-size-14 {
			font-size: 14px;
		}

		.font-size-18 {
			font-size: 18px;
		}

		.text-right {
			text-align: right;
		}

		.text-center {
			text-align: center;
		}

		.text-bold {
			font-weight: bold;
		}

		.cell-heading {
			text-align: left;
		}

		.cell-content {
			text-align: center;
			font-weight: bold;
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

	<table  border="0" width="100%" style="margin: 0px;">
		<tr class="font-size-14">
			<td>{{$_data->Company_Name}}</td>
		</tr>
		<tr class="font-size-14">
			<td>{{$_data->Company_Addr}}</td>
		</tr>
		<tr class="font-size-14">
			<td>เลขประจำตัวผู้เสียภาษี {{$_data->Company_Id}}</td>
		</tr>
		<tr>
			<td></td>
		</tr>
		<tr>
			<td></td>
		</tr>
	</table>

	<table  border="0" width="100%" style="margin: 0px;">
		<tr>
			<td width="40%" class="text-right" style="padding:5px; border-spacing:5px;">กรุณาส่ง &nbsp;&nbsp;</td>
			<td width="60%">&nbsp;&nbsp; {{$_data->Name_Cus}}</td>
		</tr>
		<tr>
			<td width="40%"></td>
			@php
				$cus_add1 = "";
				if (isset($_data->houseNumber_Adds) && $_data->houseNumber_Adds != "-") {
					$cus_add1 .= " เลขที่ {$_data->houseNumber_Adds}";
				}
				if (isset($_data->houseGroup_Adds) && $_data->houseGroup_Adds != "-") {
					$cus_add1 .= " ม.{$_data->houseGroup_Adds}";
				}
				if (isset($_data->building_Adds) && $_data->building_Adds != "-") {
					$cus_add1 .= " อาคาร{$_data->building_Adds}";
				}
				if (isset($_data->village_Adds) && $_data->village_Adds != "-") {
					$cus_add1 .= " หมู่บ้าน{$_data->village_Adds}";
				}
				if (isset($_data->roomNumber_Adds) && $_data->roomNumber_Adds != "-") {
					$cus_add1 .= " ห้อง {$_data->roomNumber_Adds}";
				}
				if (isset($_data->Floor_Adds) && $_data->Floor_Adds != "-") {
					$cus_add1 .= " ชั้น {$_data->Floor_Adds}";
				}
				if (isset($_data->alley_Adds) && $_data->alley_Adds != "-") {
					$cus_add1 .= " ซอย {$_data->alley_Adds}";
				}
				if (isset($_data->road_Adds) && $_data->road_Adds != "-") {
					$cus_add1 .= " ถ.{$_data->road_Adds}";
				}
			@endphp
			<td width="60%">&nbsp;&nbsp; {{$cus_add1}}</td>
		</tr>
		<tr>
			<td width="40%"></td>
			<td width="60%">&nbsp;&nbsp; ต.{{$_data->houseTambon_Adds}} อ.{{$_data->houseDistrict_Adds}}</td>
		</tr>
		<tr>
			<td width="40%"></td>
			<td width="60%">&nbsp;&nbsp; {{$_data->houseProvince_Adds}} {{$_data->Postal_Adds}}</td>
		</tr>
		<tr style="line-height: 99%">
			<td colspan="2"></td>
		</tr>
		<tr style="line-height: 99%">
			<td colspan="2"></td>
		</tr>
		<tr style="line-height: 99%">
			<td colspan="2"></td>
		</tr>
	</table>

	<table  border="0" width="100%" style="width: auto;">
		<tr>
			<th class="title-page" width="55%" style="color:black; text-decoration: underline; background-color: powderblue"> ใบแจ้งการชําระเงินค่างวด/แบบฟอร์มการชําระเงิน (Pay-in Slip)</th>
			<th width="45%"></th>
		</tr>
	</table>

	<table  border="0" width="100%" class="font-size-12">
		<tr>
			<td width="8%" class="cell-heading">
				เลขทะเบียน
			</td>
			<td width="24%" class="cell-content">
				{{ @$_data->lincense }}
			</td>
			<td width="23%" class="cell-heading">
				วันที่ออกใบแจ้งหนี้ชำระงวด
			</td>
			<td width="15%" class="cell-content">
				{{ formatDateThaiShort_monthNum( date('Y-m-d') ) }}
			</td>
			<td width="12%" class="cell-heading">
				เลขที่สัญญา 
			</td>
			<td width="18%" class="cell-content">
				{{@$_data->CONTNO}}
			</td>
		</tr>
	</table>
	<table  border="0" width="100%" class="font-size-12">
		<tr>
			<td width="20%" class="cell-heading">
				จำนวนงวดที่ผ่อนชำระ
			</td>
			<td width="6%" class="cell-content">
				{{ number_format(@$_data->T_NOPAY,0) }}
			</td>
			<td width="6%" class="cell-heading">
				งวด
			</td>
			<td width="15%" class="cell-heading">
				ยอดผ่อนชำระต่องวด
			</td>
			<td width="19%" class="cell-content">
				{{number_format(@$_data->DUEAMT,2)}}
			</td>
			<td width="4%" class="cell-heading">
				บาท
			</td>
			<td width="15%" class="cell-heading">
				วันครบกำหนดชำระ 
			</td>
			<td width="15%" class="cell-content">
				{{ formatDateThaiShort_monthNum(@$_data->DUEDATE) }}
			</td>
		</tr>
	</table>

	<table border="0" width="100%" style="background-color: lightgray" class="font-size-14">
		<tr>
			<th class="text-center fw-bold" width="50%"><b>รายการ / Description</b></th>
			<th class="fw-bold" width="50%" align="right"><b>จำนวนเงิน(บาท) / Amount in Baht &nbsp;&nbsp;</b></th>
		</tr>
	</table>

	<table border="0" width="100%" class="font-size-14">
		<tr>
			<td width="16%">&nbsp; ค่างวดประจำงวดที่</td>
			<td width="5%" class="text-bold text-center">{{ @$_data->NOPAY }}</td>
			<td width="49%">วันที่ {{ formatDateThaiLongPS(@$_data->DUEDATE) }}</td>
			<td width="30%" class="text-right">
				{{ number_format($_data->DUEAMT,2) }} &nbsp;
			</td>
		</tr>
		<tr>
			<td width="16%">&nbsp; จำนวนงวดค้างชำระ</td>
			<td width="5%" class="text-bold text-center">{{ number_format(0,0) }}</td>
			<td width="49%">งวด ( งวดที่ {{ number_format(@$_data->EXP_FRM,0) }} ถึงงวดที่ {{ number_format(@$_data->EXP_TO,0) }} )</td>
			<td width="30%" class="text-right">
				{{ number_format($_data->EXP_AMT,2) }} &nbsp;
			</td>
		</tr>
		<tr>
			<td width="70%">&nbsp; เบี้ยปรับล่าช้า</td>
			<td width="30%" class="text-right">{{ number_format($_data->EXP_INTAMT,2) }} &nbsp;</td>
		</tr>
		<tr>
			<td width="70%">&nbsp; ค่าใช้จ่ายในการทวงถามหนี้คงค้าง</td>
			<td width="30%" class="text-right">{{ number_format($_data->EXP_FOLLOW,2) }} &nbsp;</td>
		</tr>
	</table>

	<table border="0" width="100%" class="font-size-14">
		<tr>
			<td width="80%">&nbsp; <b>ยอดเงินที่ต้องชำระ</b></td>
			@php
				$totalAmount = $_data->DUEAMT + $_data->EXP_AMT + $_data->EXP_INTAMT + $_data->EXP_FOLLOW;
			@endphp
			<td width="20%" class="text-right fw-bold" style="background-color: lightgrey"><b>{{ number_format($totalAmount,2) }}</b>&nbsp;&nbsp;</td>
		</tr>
	</table>

	<table width="100%" style="font-size: 5px;">
		<tr>
			<td></td>
		</tr>
	</table>

	<table border="0" width="100%" style="border: 1px soild #ccc;">
		<tr class="font-size-14">
			<th style="vertical-align: middle;">&nbsp; ข้อควรทราบและพึงระวัง!</th>
		</tr>
		<tr class="font-size-12">
			<td style="vertical-align: middle;">
				<ul style="list-style-type: none; padding: 5px !important;">
					<li>* หากชำระเงินน้อยกว่าที่ระบุไว้ในใบแจ้งการชำระเงินค่างวด อาจทำให้ไม่เพียงพอต่อการชำระค่างวดและทำให้ค้างชำระงวด</li>
					<li>* ชำระค่างวดไม่ครบ / ชำระค่างวดล่าช้า จะมีค่าใช้จ่ายในการทวงถามหนี้ และจะคิดเบี้ยปรับผิดนัด</li>
					<li>* หากประสบปัญหาการชำระหนี้ตามสัญญาสินเชื่อ (กรุณาติดต่อสาขาทันทีเพื่อร่วมกันแก้ไขปัญหาให้เหมาะสมกับความสามารถในการชำระหนี้)</li>
				</ul>
			</td>
		</tr>
	</table>

	{{--
	<table width="100%" style="font-size: 5px;">
		<tr>
			<td></td>
		</tr>
	</table>
	
	<p style="line-height: 1%; border-top: 1px dashed #888; padding-bottom: 0px; margin-bottom: 0px;"></p>
	--}}

	<table width="100%" style="font-size: 10px;">
		<tr>
			<td></td>
		</tr>
	</table>

	<table width="100%" style="font-size: 10px; border-top: 1px dashed #444;">
		<tr>
			<td></td>
		</tr>
	</table>

	<table border="0" width="100%" style="border-top: 0px soild transparent;">
		<tr>
			<th style="vertical-align: middle; background-color:powderblue;">&nbsp; ใบนำฝากชำระเงินค่าสินค้าหรือบริการ (Bill Payment Pay-in-Slip)</th>
		</tr>
	</table>

	<table border="0" class="font-size-14">
		<tbody>
		  <tr>
			<td width="5%">
				&nbsp; ที่อยู่
			</td>
			<td width="65%">
				{{$_data->Company_Name}}<br>
				{{$_data->Company_Addr}}
			</td>
			<td width="30%" align="right" class="font-size-12">
			  โปรดเรียกเก็บค่าธรรมเนียมจากผู้ชำระ &nbsp;
			</td>
		  </tr>
		  <tr>
			@php
				$fax_text = "";
				if (isset($_data->Company_fax)) {
					$fax_text = "แฟกซ์ {$_data->Company_fax}";
				}	
			@endphp
			<td width="50%">
				&nbsp;เบอร์โทร. โทร {{ formatPhone($_data->Company_Tel) }} {{$fax_text}}
			</td>
			<td width="25%" style="border-left: 1px soild #aaa; border-top: 1px soild #aaa; border-right: 1px soild #aaa;">
				
			</td>
			<td width="25%" style="border-top: 1px soild #aaa; border-right: 1px soild #aaa;">
				&nbsp;วันที่
			</td>
		  </tr>
		  <tr>
			<td rowspan="4" style="line-height: 150%;">
				{{-- <img height="12" src="{{ asset('assets/images/payments/checkbox.png') }}" alt="checkbox">  --}}
				&nbsp;
				{{-- <input type="checkbox" name="box" value="1" readonly="true"/> --}}
				<br>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img height="25" src="{{ asset('assets/images/payments/all_bank-v2.png') }}" alt="bank">
				<br>
				<input type="checkbox" name="box" value="1" readonly="true"/> ธนาคารที่ให้บริการรับชําระบิล Biller ID : {{$_data->Company_Id}}
			</td>
			<td width="11%" style="border-left: 1px soild #aaa; border-top: 1px soild #aaa;">
				&nbsp; ชื่อลูกค้า
			</td>
			<td width="39%" style="border-top: 1px soild #aaa; border-right: 1px soild #aaa;">
				&nbsp;&nbsp; {{$_data->Name_Cus}}
			</td>
		  </tr>
		  <tr>
			<td width="11%" style="border-left: 1px soild #aaa; border-top: 1px soild #aaa;">
				&nbsp; เลขอ้างอิง 1
			</td>
			<td width="39%" style="border-top: 1px soild #aaa; border-right: 1px soild #aaa;">
				&nbsp;&nbsp; {{@$ref_code1}}
			</td>
		  </tr>
		  <tr>
			<td width="11%" style="border-left: 1px soild #aaa; border-top: 1px soild #aaa;">
				&nbsp; เลขอ้างอิง 2
			</td>
			<td width="39%" style="border-top: 1px soild #aaa; border-right: 1px soild #aaa;">
				&nbsp;&nbsp; {{@$ref_code2}}
			</td>
		  </tr>
		  <tr>
			<td width="11%" style="border-left: 1px soild #aaa; border-top: 1px soild #aaa; border-bottom: 1px soild #aaa;">
				&nbsp; จำนวนเงิน
			</td>
			<td width="30%" align="center" style="border-top: 1px soild #aaa; border-bottom: 1px soild #aaa;">
				&nbsp; {{number_format($_data->DUEAMT,2)}}
			</td>
			<td width="9%" style="border-top: 1px soild #aaa; border-right: 1px soild #aaa; border-bottom: 1px soild #aaa;">
				&nbsp; บาท
			</td>
		  </tr>
		  <tr>
			<td width="100%" class="font-size-12">
				(ค่าธรรมเนียมไม่เกิน 5 บาท/รายการ ในช่องทางอิเล็กทรอนิคส์ และไม่เกิน 20 บาท/รายการ ในช่องทางสาขา)
			</td>
		  </tr>
		</tbody>
	</table>

	<table class="font-size-14">
		<tbody>
		<tr align="center">
			<th width="25%" style="border-width: 0.5px; border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5;" class="bold-text">
			  <span>รับชำระด้วยเงินสดเท่านั้น</span>
			</th>
			<th width="25%" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5;" class="bold-text">
			  <span>จำนวนเงิน/AMOUNT</span>
			</th>
			<th width="37.5%" style="border-style: none;">
			</th>
			<th width="12.5%" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5" align="center">
			  บาท/BAHT
			</th>
		  </tr>
		  <tr align="center">
			<th width="25%" style="border-style: solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5;" class="bold-text">
			  <span>จำนวนเงินเป็นตัวอักษร</span>
			</th>
			<th width="75%" style="border-style: solid;  border-bottom-style: solid; border-right-style: solid;">
			</th>
		  </tr>
		  <tr>
			<th width="75%" rowspan="2" style="border: none;" class="font-size-14">
			  ชื่อผู้นำฝาก&nbsp;_________________________<br>
			  โทรศัพท์&nbsp;&nbsp;&nbsp;&nbsp;_________________________
			</th>
			<th width="25%" style="border-style: 1px solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid; background-color: #FBE4D5;" align="center">
			  <span>สำหรับเจ้าหน้าที่ธนาคาร</span>
			</th>
		  </tr>
		  <tr>
			<th width="25%" style="border-style: 1px solid; border-bottom-style: solid; border-left-style: solid; border-right-style: solid;" class="font-size-12">
			  ผู้รับเงิน
			</th>
		  </tr>
		</tbody>
	</table>
	
	<table  width="100%" style="font-size: 10px;">
		<tr>
			<td></td>
		</tr>
	</table>

	<table >
		<tbody>
			<tr style="line-height:5px;font-size:8px;vertical-align:bottom;">
				<td width="50%" align="left" class="font-size-8">  
					<img  height="30" width="225" src="{{ getcwd().'/cache_barcode/'.$NamepathBr.'.png' }}" alt="barcode"/>
					<div>{{$Bar}}</div>
				</td>
				<td width="50%" align="right">
					<img height="50" src="{{ getcwd().'/cache_barcode/'.$NamepathQr.'.svg' }}" alt="qrcode">
				</td>
			</tr>
		</tbody>
	</table>
</body>

</html>
