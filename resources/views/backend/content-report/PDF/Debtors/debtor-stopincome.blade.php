@php
	$count = 0;
@endphp
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8">
	<title></title>
	<style>
		@page {
			size: landscape;
		}

		@font-face {
			font-family: 'TFPimpakarn';
			font-style: normal;
			font-weight: normal;
			src: url({{ asset('fonts/TF Pimpakarn.ttf') }});
			/* src: url({{ asset('fonts/THSarabunNew.ttf') }}) format('truetype'); */
		}

		@font-face {
			font-family: 'TFPimpakarn';
			font-style: normal;
			font-weight: bold;
			src: url({{ asset('fonts/TF Pimpakarn Bol.ttf') }}) format('truetype');
		}

		/* @font-face {
													font-family: 'TFPimpakarn';
													font-style: italic;
													font-weight: normal;
													src: url({{ asset('fonts/THSarabunNew Italic.ttf') }}) format('truetype');
									}
									@font-face {
													font-family: 'TFPimpakarn';
													font-style: italic;
													font-weight: bold;
													src: url({{ asset('fonts/THSarabunNew BoldItalic.ttf') }}) format('truetype');
									} */
		body {
			font-family: "TFPimpakarn";
		}

		.circle {
			top: 4rem;
			left: 4rem;
		}

		.border_black {
			/* border: solid 1px black;
	
	
									height: 20px;*/
			display: inline-block;
			line-height: 0.3cm;
			border: solid 1px black;
			margin-right: 2px;
			width: 12px;
			/* margin: 1px; */
			/* vertical-align: 7px; */
		}

		html {
			margin: 20px
		}

		.borderTB>table,
		.borderTB>tr,
		.borderTB>td,
		.borderTB>th {
			border: 1px solid black;
			border-collapse: collapse;
		}

		table {
			border-collapse: collapse;
			width: 100%;
		}

		th {
			background: rgba(72, 191, 227, 0.9);
			border-top: 4px solid rgba(105, 48, 192, 0.6);
		}

		th,
		td {
			text-align: left;
		}

		.total-row {
			border-radius: 5px;
			margin-top: 10px;
			width: 100%;
			padding: 10px;
			background-color: #8d99ae;
		}
	</style>
</head>

<body style="">
	<div style=" text-align: center; height: 0.4cm">
		<h3 style=" text-align: center; height: 0.4cm">{{ $tableLoan != 'PSL' ? 'รายงานการลูกหนี้หยุดรับรู้ vat' : 'รายงานการลูกหนี้หยุดรับรู้รายได้' }}</h3>
		{{-- <h4>บริษัท ชูเกียรติพร๊อพเพอร์ตี้ จำกัด</h4> --}}
	</div>
	<p align="right">วันที่พิมพ์ : {{ FormatDatethaiLong(date('d-m-Y')) }} <br />ผู้พิมพ์ : {{ auth()->user()->name }}</p>
	<hr>

	{{-- <!-- <h5 style="line-height:-5px;">รวม {{//count(@$data)}} รายการ</h5> --> --}}
	<table width="100%" style="height: 0.4cm;">
		<thead>
			<tr style="line-height:100%;background-color:#F2F0EF;">
				{{-- @if ($Loan == '') --}}
				<th align="center">สาขา</th>
				<th align="center">เลขที่สัญญา</th>
				<th align="center">ชื่อลูกค้า</th>
				<th align="center">วันที่ทำสัญญา</th>
				<th align="center">ยอดผ่อน</th>
				<th align="center">ค้างงวด</th>
				<th align="center">ค้างงวดที่</th>
				<th align="center">เงินค้างงวด</th>
				<th align="center">วันหยุดรับรู้</th>
				{{-- @else
                
            @endif --}}
			</tr>
		</thead>
		<tbody>
			@foreach ($response as $res)
				@php
					$count++;
				@endphp
				<tr width="100%" style="line-height: 0.5cm">
					<td align="center">{{ @$res->StopVATLocat->NickName_Branch }}</td>
					<td align="center">{{ @$res->CONTNO }}</td>
					<td align="center">{{ @$res->UserStopVat->Name_Cus }}</td>
					<td align="center">{{ @$res->SDATE }}</td>
					<td align="center">{{ @$res->TOTPRC }}</td>
					<td align="center">{{ number_format(@$res->EXP_PRD, 2) }}</td>
					<td align="center">{{ @$res->EXP_FRM . ' - ' . @$res->EXP_TO }}</td>
					<td align="center">{{ number_format(@$res->EXP_AMT, 2) }}</td>
					<td align="center">{{ @$res->STOPVDT }}</td>
				</tr>
			@endforeach
			<tr width="100%" style="line-height: 0.5cm; border-top:4px solid #8d99ae; background: #F2F0EF;">
				<td colspan="9" style="padding-left: 5px;">รวมยอดรายการทั้งหมด {{ $count }} รายการ</td>
			</tr>
		</tbody>
	</table>
</body>

</html>
