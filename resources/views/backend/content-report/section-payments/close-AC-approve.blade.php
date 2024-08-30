<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8">
	<title></title>

	<style>
		@page {
			margin: 0%;
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
			margin: 0px;
		}

		table {
			width: 100%;
			height: 100%;
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

		/* กำหนดสไตล์เซลล์ในตาราง */

	</style>

	<style>

		.head-report {
            color:black;
			text-decoration: underline;
			background-color: powderblue;
        }
		.head-topic {
			color: black;
			background-color: powderblue;
			border-bottom: 1pt solid blue;
		}
		.text-right {
			text-align: right;
		}

		.text-left {
			text-align: left;
		}


		.text-center {
			text-align: center;
		}
		.text-bold {
			font-weight: bold;
		}
		.text-underline {
			text-decoration: underline;
		}

		.cell-heading {
			text-align: left;
		}

		.cell-content {
			text-align: center;
			font-weight: bold;
		}

		.text-blue {
			color: blue;
		}


	</style>

<body>

	<table border="0" width="100%" style="margin: 0px;">
		<tr>
			<td width="65%" style="font-size: 14px;">{{$company->Company_Name}}</td>
			<td rowspan="3" width="35%">
				<div class="head-report text-center" style="font-size: 20px;">
					ใบขอยอดอนุมัติปิดบัญชี
				</div>
				<span class="text-center" style="font-size: 14px;">{{ @$data->DOCNO }}</span>
			</td>
		</tr>
		<tr style="font-size: 14px;">
			<td>{{$company->Company_Addr}}</td>
		</tr>
		<tr style="font-size: 14px;">
			<td>โทร {{ formatPhone($company->Company_Tel) }} @if(isset($company->Company_fax)) แฟกซ์ {{ textFormat( preg_replace('/[^0-9]/', '', $company->Company_fax), '__-____-____', '-' ) }} @endif</td>
		</tr>
	</table>

	<table width="100%" style="font-size: 5px;">
		<tr>
			<td></td>
		</tr>
	</table>

	<table border="0" width="100%" style="margin: 0px;">
		<tr>
			<td style="text-align: left;">วันที่พิมพ์ {{ date('d/m/Y') }}</td>
			<td style="text-align: right;">สำหรับลูกค้า</td>
		</tr>
	</table>

	<table width="100%" style="font-size: 5px;">
		<tr>
			<td></td>
		</tr>
	</table>

	<table border="0" width="100%">
		<tr>
			<td class="head-topic text-left">
				&nbsp; รายละเอียดลูกค้า (1AC-20020008)
			</td>
		</tr>
	</table>

	<table width="100%" style="font-size: 5px;">
		<tr>
			<td></td>
		</tr>
	</table>
	
	<!-- รายละเอียดลูกค้า สัญญา -->
	<table border="0" width="100%">
		<tr>
			<td width="10%">
				สาขา
			</td>
			<td width="45%" class="cell-content text-left"> {{$branch->Name_Branch}} ({{$branch->NickName_Branch}}) - {{sprintf("%02d", $branch->id_Contract)}}</td>
			<td width="15%">
				เลขที่สัญญา
			</td>
			<td width="30%" class="cell-content">
				{{$data->CONTNO}}
			</td>
		</tr>
		<tr>
			<td width="10%">
				ชื่อลูกค้า
			</td>
			<td width="45%" class="cell-content text-left"> {{$data->AccCloseToCustomer->Name_Cus}}</td>
			<td width="15%">
				วันที่ทำสัญญา
			</td>
			<td width="30%" class="cell-content">
				{{ formatDateThaiShort_monthNum(@$data->SDATE) }}
			</td>
		</tr>
		<tr>
			<td width="10%">
				ที่อยู่
			</td>
			@php
				$data_cusadd = $data->AccCloseToCusAddress;
				$cus_add1 = "";
				if (isset($data_cusadd->houseNumber_Adds) && $data_cusadd->houseNumber_Adds != "-") {
					$cus_add1 .= " เลขที่ {$data_cusadd->houseNumber_Adds}";
				}
				if (isset($data_cusadd->houseGroup_Adds) && $data_cusadd->houseGroup_Adds != "-") {
					$cus_add1 .= " ม.{$data_cusadd->houseGroup_Adds}";
				}
				if (isset($data_cusadd->building_Adds) && $data_cusadd->building_Adds != "-") {
					$cus_add1 .= " อาคาร{$data_cusadd->building_Adds}";
				}
				if (isset($data_cusadd->village_Adds) && $data_cusadd->village_Adds != "-") {
					$cus_add1 .= " หมู่บ้าน{$data_cusadd->village_Adds}";
				}
				if (isset($data_cusadd->roomNumber_Adds) && $data_cusadd->roomNumber_Adds != "-") {
					$cus_add1 .= " ห้อง {$data_cusadd->roomNumber_Adds}";
				}
				if (isset($data_cusadd->Floor_Adds) && $data_cusadd->Floor_Adds != "-") {
					$cus_add1 .= " ชั้น {$data_cusadd->Floor_Adds}";
				}
				if (isset($data_cusadd->alley_Adds) && $data_cusadd->alley_Adds != "-") {
					$cus_add1 .= " ซอย {$data_cusadd->alley_Adds}";
				}
				if (isset($data_cusadd->road_Adds) && $data_cusadd->road_Adds != "-") {
					$cus_add1 .= " ถ.{$data_cusadd->road_Adds}";
				}
			@endphp
			<td width="90%">{{$cus_add1}}</td>
		</tr>
		<tr>
			<td width="10%"></td>
			<td width="90%"> ต.{{$data_cusadd->houseTambon_Adds}} อ.{{$data_cusadd->houseDistrict_Adds}}</td>
		</tr>
		<tr>
			<td width="10%"></td>
			<td width="90%"> {{$data_cusadd->houseProvince_Adds}} {{$data_cusadd->Postal_Adds}}</td>
		</tr>
	</table>
	
	<table width="100%" style="font-size: 5px;">
		<tr>
			<td></td>
		</tr>
	</table>

	<table border="0" width="100%">
		<tr>
			<td class="head-topic text-left">
				&nbsp; รายละเอียดสินค้า
			</td>
		</tr>
	</table>

	<table width="100%" style="font-size: 5px;">
		<tr>
			<td></td>
		</tr>
	</table>
	
	{{--
		+"typeModel": "TOYOTA FORTUNER"
		+"typeLicense": "กร-2221 สงขลา"
		+"typeProvince": null
		+"Vehicle_Chassis": "MR0YZ59G700030362"
		+"Vehicle_Type_PLT": "0763900002"
		+"Price_Asset": "395000"
	--}}

	@if( isset($contasset) )
		@if( $contasset->TypeAsset_Code == "car" || $contasset->TypeAsset_Code == "moto" )
			<table border="0" width="100%">
				<tr>
					<td width="15%">
						ยี่ห้อ - รุ่น
					</td>
					<td width="85%" class="cell-content text-left">
						{{ $contasset->getBrandType() }} - {{ $contasset->getModel() }}
					</td>
				</tr>
				<tr>
					<td width="15%">
						ทะเบียนรถ
					</td>
					<td width="35%" class="cell-content text-left">
						{{ $contasset->getLicense() }}
					</td>
					<td width="20%">
						เลขตัวถัง/เลขที่โฉนด
					</td>
					<td width="30%" class="cell-content text-left">
						[เลขตัวถัง/เลขที่โฉนด]
					</td>
				</tr>
				<tr>
					<td width="15%">
						สี
					</td>
					<td width="35%" class="cell-content text-left">
						[สี]
					</td>
					<td width="20%">
						เลขเครื่อง
					</td>
					<td width="30%" class="cell-content text-left">
						[เลขเครื่อง]
					</td>
				</tr>
			</table>
		@elseif( $contasset->TypeAsset_Code == "land" )
			<table border="0" width="100%">
				<tr>
					<td width="10%"></td>
					<td width="10%">
						ชนิด
					</td>
					<td width="30%" class="cell-content text-left">
						{{ $contasset->getBrandType() }}
					</td>
					<td width="20%">
						เลขที่ดิน
					</td>
					<td width="30%" class="cell-content text-left">
						{{ $contasset->getLicense() }}
					</td>
				</tr>
				<tr>
					<td width="10%"></td>
					<td width="10%">
						รุ่น
					</td>
					<td width="30%" class="cell-content text-left">
						{{ $contasset->getModel() }}
					</td>
					<td width="20%">
						เลขตัวถัง/เลขที่โฉนด
					</td>
					<td width="30%" class="cell-content text-left">
						[เลขตัวถัง/เลขที่โฉนด]
					</td>
				</tr>
				<tr>
					<td width="10%"></td>
					<td width="10%">
						สี
					</td>
					<td width="30%" class="cell-content text-left">
						[สี]
					</td>
					<td width="20%">
						เลขเครื่อง
					</td>
					<td width="30%" class="cell-content text-left">
						[เลขเครื่อง]
					</td>
				</tr>
			</table>
		@endif
	@endif

	<!-- รายละเอียดการชำระ -->
	<table width="100%" style="font-size: 5px;">
		<tr>
			<td></td>
		</tr>
	</table>

	<table border="0" width="100%">
		<tr>
			<td class="head-topic text-left">
				&nbsp; รายละเอียดการชำระ
			</td>
		</tr>
	</table>

	<table width="100%" style="font-size: 5px;">
		<tr>
			<td></td>
		</tr>
	</table>

	<table border="0" width="100%">
		<tr>
			<td width="10%"></td>
			<td width="15%">
				ยอดผ่อนชำระ
			</td>
			<td width="20%" class="text-right text-blue">
				999,999.00
			</td>
			<td width="10%"></td>
			<td width="20%">
				จำนวนงวดทั้งหมด
			</td>
			<td width="10%" class="text-blue text-bold text-center">
				24
			</td>
			<td width="20%">
				งวด
			</td>
		</tr>
		<tr>
			<td width="10%"></td>
			<td width="15%">
				ชำระแล้ว
			</td>
			<td width="20%" class="text-right text-blue">
				999,999.00
			</td>
			<td width="10%"></td>
			<td width="20%">
				จำนวนงวดที่ผ่อนมาแล้ว
			</td>
			<td width="10%" class="text-blue text-bold text-center">
				24
			</td>
			<td width="20%">
				งวด
			</td>
		</tr>
		<tr>
			<td width="10%"></td>
			<td width="15%">
				ยอดคงเหลือ
			</td>
			<td width="20%" class="text-right text-blue">
				999,999.00
			</td>
			<td width="10%"></td>
			<td width="20%">
				ชำระทุกวันที่
			</td>
			<td width="10%" class="text-blue text-bold text-center">
				24
			</td>
			<td width="20%">
				ของทุกเดือน
			</td>
		</tr>
		<tr>
			<td width="10%"></td>
			<td width="15%">
				ค่าปรับล่าช้า
			</td>
			<td width="20%" class="text-right text-blue">
				999,999.00
			</td>
			<td width="10%"></td>
			<td width="20%">
				ของปิดบัญชีงวดที่
			</td>
			<td width="10%" class="text-blue text-bold text-center">
				24
			</td>
			<td width="20%">
				งวด
			</td>
		</tr>
		<tr>
			<td width="10%"></td>
			<td width="20%">
				ค้างค่าธรรมเนียมล่าช้า
			</td>
			<td width="15%" class="text-right text-blue">
				999,999.00
			</td>
		</tr>
		<tr>
			<td width="10%"></td>
			<td width="15%">
				ส่วนลด
			</td>
			<td width="20%" class="text-right text-blue">
				999,999.00
			</td>
		</tr>
		<tr>
			<td width="10%"></td>
			<td width="15%" class="text-underline">
				รวมยอดค้างชำระ
			</td>
			<td width="20%" class="text-underline text-right text-blue text-bold">
				999,999.00
			</td>
			<td width="10%"></td>
		</tr>
	</table>

	<!-- ลูกหนี้อื่น -->
	<table width="100%" style="font-size: 5px;">
		<tr>
			<td></td>
		</tr>
	</table>

	<table border="0" width="100%">
		<tr>
			<td class="head-topic text-left">
				&nbsp; รายละเอียดลูกหนี้อื่น ๆ
			</td>
		</tr>
	</table>

	<table width="100%" style="font-size: 14px;">
		<tr>
			<th width="15%" class="head-topic text-center">
				เลขเอกสาร
			</th>
			<th width="15%" class="head-topic text-center">
				วันที่
			</th>
			<th width="25%" class="head-topic">
				ค้างชำระค่า
			</th>
			<th width="15%" class="head-topic text-center">
				จำนวนเงิน
			</th>
			<th width="15%" class="head-topic text-center">
				ชำระแล้ว
			</th>
			<th width="15%" class="head-topic text-center">
				ลูกหนี้คงเหลือ
			</th>
		</tr>
		<tr>
			<td width="15%" class="text-center">
				เลขเอกสาร
			</td>
			<td width="15%" class="text-center">
				วันที่
			</td>
			<td width="25%" class="">
				ค้างชำระค่า
			</td>
			<td width="15%" class=" text-center">
				จำนวนเงิน
			</td>
			<td width="15%" class="text-center">
				ชำระแล้ว
			</td>
			<td width="15%" class="text-center">
				ลูกหนี้คงเหลือ
			</td>
		</tr>
	</table>

	<table width="100%" style="font-size: 5px;">
		<tr>
			<td></td>
		</tr>
	</table>

	

</body>

</html>
