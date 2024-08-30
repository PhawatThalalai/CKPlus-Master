<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8">
	<title></title>
	<style>
		@page {
			size: portrait;
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
	</style>
</head>

<body style="">
	<div style=" text-align: center; height: 0.4cm">
		<h3 style=" text-align: center; height: 0.4cm">รายงานการรับชำระประจำวัน</h3>
		<h4>ระหว่างวันที่ {{ formatDateThaiShort_monthNum(@$Fdate) }} ถึงวันที่ {{ formatDateThaiShort_monthNum(@$Tdate) }}</h4>
	</div>
	<p align="right">วันที่พิมพ์ : {{ FormatDatethaiLong(date('d-m-Y')) }} <br />ผู้พิมพ์ : {{ auth()->user()->name }}</p>
	<hr style="border: 1px solid">

	<table>
		<thead>
			<tr>
				<th align="center">สาขา</th>
				<th align="center">ประเภท </th>
				<th align="center">ชำระค่า</th>
				<th align="center">ชำระ</th>
				<th align="center">{{ $tableLoan == 'PSL' ? 'เงินต้น' : 'ยอดไม่รวมVAT' }}</th>
				<th align="center">{{ $tableLoan == 'PSL' ? 'ดอกเบี้ย' : 'VAT' }}</th>
				<th align="center">ส่วนลด</th>
				<th align="center">ค่าปรับ</th>
				<th align="center">ส่วนลดค่าปรับ</th>
				<th align="center">ค่าทวงถาม</th>
				<th align="center">ส่วนลดทวงถาม</th>
				<th align="center">รับสุทธิ</th>
			</tr>
		</thead>
		<tbody>

			@foreach ($groupedData as $key => $value)
				<tr>
					<td style="height: 10px;"></td>
				</tr>
				<tr style="background: #ffd6ff; border-top: 3px solid #ffd8be; margin-top: 10px;">
					<td colspan="12" style="padding-left: 5px;"> {{ $key }}</td>
				</tr>
				@foreach ($value as $key => $item)
					<tr>
						<td> </td>
						<td colspan="11"> {{ $key }}</td>
					</tr>
					@foreach ($item as $key => $item2)
						<tr>
							<td> </td>
							<td> </td>
							<td align="right">( {{ $item2->CPAYFOR }} ) {{ $item2->PAYFOR }} </td>
							<td align="right">{{ number_format($item2->payamt, 2) }} </td>
							<td align="right">{{ number_format($item2->PAYAMT_N, 2) }} </td>
							<td align="right">{{ number_format($item2->PAYAMT_V, 2) }} </td>
							<td align="right">{{ number_format($item2->DISCT, 2) }} </td>
							<td align="right">{{ number_format($item2->PAYINT, 2) }} </td>
							<td align="right">{{ number_format($item2->DSCINT, 2) }} </td>
							<td align="right">{{ number_format($item2->PAYFL, 2) }} </td>
							<td align="right">{{ number_format($item2->DSCPAYFL, 2) }} </td>
							<td align="right">{{ number_format($item2->NETPAY, 2) }} </td>

						</tr>
					@endforeach
					@php

					@endphp
					<tr>
						<td> </td>
						<td> </td>
						<td>รวมชำระ</td>
						<td align="right">
							{{ number_format(
							    array_sum(
							        array_map(function ($obj) {
							            return $obj->payamt;
							        }, $item),
							    ),
							    2,
							) }}
						</td>
						<td align="right">{{ number_format(
						    array_sum(
						        array_map(function ($obj) {
						            return $obj->PAYAMT_N;
						        }, $item),
						    ),
						    2,
						) }}
						</td>
						<td align="right">{{ number_format(
						    array_sum(
						        array_map(function ($obj) {
						            return $obj->PAYAMT_V;
						        }, $item),
						    ),
						    2,
						) }}
						</td>
						<td align="right">{{ number_format(
						    array_sum(
						        array_map(function ($obj) {
						            return $obj->DISCT;
						        }, $item),
						    ),
						    2,
						) }}
						</td>
						<td align="right">{{ number_format(
						    array_sum(
						        array_map(function ($obj) {
						            return $obj->PAYINT;
						        }, $item),
						    ),
						    2,
						) }}
						</td>
						<td align="right">{{ number_format(
						    array_sum(
						        array_map(function ($obj) {
						            return $obj->DSCINT;
						        }, $item),
						    ),
						    2,
						) }}
						</td>
						<td align="right">{{ number_format(
						    array_sum(
						        array_map(function ($obj) {
						            return $obj->PAYFL;
						        }, $item),
						    ),
						    2,
						) }}
						</td>
						<td align="right">{{ number_format(
						    array_sum(
						        array_map(function ($obj) {
						            return $obj->DSCPAYFL;
						        }, $item),
						    ),
						    2,
						) }}
						</td>
						<td align="right">{{ number_format(
						    array_sum(
						        array_map(function ($obj) {
						            return $obj->NETPAY;
						        }, $item),
						    ),
						    2,
						) }}
						</td>

					</tr>
				@endforeach
			@endforeach
			<tr style="border-top: 4px solid #003049; background:#fdf0d5;">
				<td> </td>
				<td> </td>
				<td>รวมชำระ</td>
				<td align="right">
					{{ number_format($data->sum('payamt'), 2) }}
				</td>
				<td align="right">
					{{ number_format($data->sum('PAYAMT_N'), 2) }}
				</td>
				<td align="right">
					{{ number_format($data->sum('PAYAMT_V'), 2) }}
				</td>
				<td align="right">
					{{ number_format($data->sum('DISCT'), 2) }}
				</td>
				<td align="right">
					{{ number_format($data->sum('PAYINT'), 2) }}
				</td>
				<td align="right">
					{{ number_format($data->sum('DSCINT'), 2) }}
				</td>
				<td align="right">
					{{ number_format($data->sum('PAYFL'), 2) }}
				</td>
				<td align="right">
					{{ number_format($data->sum('DSCPAYFL'), 2) }}
				</td>
				<td align="right">
					{{ number_format($data->sum('NETPAY'), 2) }}
				</td>

			</tr>
		</tbody>
	</table>

</body>

</html>
