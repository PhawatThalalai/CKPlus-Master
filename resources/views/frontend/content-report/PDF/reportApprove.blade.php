<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<meta charset="utf-8">
	<title></title>

	<style>
		td.container>div {
			width: 100%;
			height: 100%;
			overflow: hidden;
		}

		td.container {
			height: 20px;
		}
	</style>

	<SCRIPT>
		function toggleOption(thisselect) {
			var selected = thisselect.options[thisselect.selectedIndex].value;
			toggleRow(selected);
		}

		function toggleRow(id) {
			var row = document.getElementById(id);
			if (row.style.display == '') {
				row.style.display = 'none';
			} else {
				row.style.display = '';
			}
		}

		function showRow(id) {
			var row = document.getElementById(id);
			row.style.display = '';
		}

		function hideRow(id) {
			var row = document.getElementById(id);
			row.style.display = 'none';
		}

		function hideAll() {
			hideRow('optionA');
			hideRow('optionB');
			hideRow('optionC');
			hideRow('optionD');
		}
	</SCRIPT>

</head>
<br>
<table border="0">
	<tbody>
		<tr>
			<th width="100px"></th>
			<th width="600px" align="center">
				<h2 class="card-title p-3" align="center" style="font-weight: bold;line-height:1px;">รายงานอนุมัติ {{ @$nameLoans }} {{ @$codeLoans }}</h2>
				<h4 class="card-title p-3" align="center">จากวันที่ {{ date('d-m-Y', strtotime($Fdate)) }} ถึงวันที่ {{ date('d-m-Y', strtotime($Tdate)) }}</h4>
			</th>
			<th width="100px" align="right">
				<h5 class="card-title p-3" style="line-height:1px;">พิมพ์ : {{ date('d-m-Y') }}</h5>
				<h5 class="card-title p-3">ผู้พิมพ์ : {{ auth()->user()->name }}</h5>
			</th>
		</tr>
	</tbody>
</table>
<hr>

<body>
	<br />
	<table border="1">
		<thead>
			<tr align="center" style="line-height: 250%;">
				<th align="center" width="50px" style="background-color: #33FF00;"><b>ยี่ห้อ</b></th>
				<th align="center" width="35px" style="background-color: #BEBEBE;"><b>สาขา</b></th>
				<th align="center" width="50px" style="background-color: #BEBEBE;"><b>ทะเบียน</b></th>
				<th align="center" width="50px" style="background-color: #BEBEBE;"><b>ยอดจัด</b></th>
				<th align="center" width="60px" style="background-color: #BEBEBE;"><b>เพิ่มเติม</b></th>
				<th align="center" width="40px" style="background-color: #FFFF00;"><b>ขนส่ง/ภาษี</b></th>
				<th align="center" width="45px" style="background-color: #FFFF00;"><b>อื่นๆ/ประเมิน</b></th>
				<th align="center" width="40px" style="background-color: #FFFF00;"><b>อต./ประกัน</b></th>
				<th align="center" width="50px" style="background-color: #FFFF00;"><b>ดนก./ล้วงหน้า</b></th>
				<th align="center" width="45px" style="background-color: #BEBEBE;"><b>รวมค่าใช้จ่าย</b></th>
				<th align="center" width="35px" style="background-color: #BEBEBE;"><b>คงเหลือ</b></th>
				<th align="center" width="30px" style="background-color: #BEBEBE;"><b>หัก %</b></th>
				<th align="center" width="110px" style="background-color: #BEBEBE;"><b>ผู้รับเงิน</b></th>
				<th align="center" width="110px" style="background-color: #BEBEBE;"><b>ผู้รับคอม</b></th>
				<th align="center" width="65px" style="background-color: #BEBEBE;"><b>รวม</b></th>
			</tr>
		</thead>
		<tbody>
			@php
				$sumArcsum = 0;
				$sumbalance = 0;
				$sumall = 0;
				$sumtopcar = 0;
				$sumtotalkprice = 0;
				$sumbalanceprice = 0;
				$sumcommitprice = 0;
				$SumCom = 0;
			@endphp
			@foreach (@$data as $key => $value)
				@if ($value->Status_Con != 'cancel')
					@php
						$sumtopcar += @$value->ContractToDataCusTags->TagToCulculate->Cash_Car + floatval(@$value->ContractToDataCusTags->TagToCulculate->StatusProcess_Car=='yes'? @$value->ContractToDataCusTags->TagToCulculate->Process_Car:0);

						@$sumtotran_Price += str_replace(',', '', @$value->ContractToOperated->Tran_Price);
						@$sumtoother_Price += str_replace(',', '', @$value->ContractToOperated->Other_Price);

						@$sumtoevaluetion_Price += str_replace(',', '', @$value->ContractToOperated->Evaluetion_Price);
						@$sumtoduty_Price += str_replace(',', '', @$value->ContractToOperated->Duty_Price);
						@$sumtomarketing_Price += str_replace(',', '', @$value->ContractToOperated->Marketing_Price);

						@$sumtototal_Price += str_replace(',', '', @$value->ContractToOperated->Total_Price);

						@$sumbalanceprice += str_replace(',', '', @$value->ContractToOperated->Balance_Price);
						if (@$value->ContractToBrokers != null) {
						    @$sumcommitprice += str_replace(',', '', @$value->ContractToBrokers->sum('SumCom_Broker'));
						}

						@$SumPA += str_replace(',', '', @$value->ContractToDataCusTags->TagToCulculate->Insurance_PA);
						@$SumProcess += str_replace(',', '', @$value->ContractToOperated->Process_Price) + str_replace(',', '', @$value->ContractToDataCusTags->TagToCulculate->StatusProcess_Car=='yes'? @$value->ContractToDataCusTags->TagToCulculate->Process_Car:0) + @$value->ContractToOperated->AccountClose_Price_fee;
					@endphp
					<tr align="center" style="line-height: 200%;">
						<td width="50px" rowspan="2" style="background-color: #33FF00; line-height:450%;">
							@if (@$value->ContractToIndentureAsset2[0]->IndenAssetToDataOwner->OwnershipToAsset->TypeAsset_Code == 'car')
								{{ @$value->ContractToIndentureAsset2[0]->IndenAssetToDataOwner->OwnershipToAsset->AssetToCarBrand->Brand_car }}
							@elseif (@$value->ContractToIndentureAsset2[0]->IndenAssetToDataOwner->OwnershipToAsset->TypeAsset_Code == 'moto')
								{{ @$value->ContractToIndentureAsset2[0]->IndenAssetToDataOwner->OwnershipToAsset->AssetToMotoBrand->Brand_moto }}
							@endif
						</td>
						<td width="35px" rowspan="2" style="line-height:450%;">{{ @$value->ContractToBranch->NickName_Branch }}</td>
						<td width="50px" rowspan="2" style="line-height:450%;">
              {{ @$value->ContractToIndentureAsset2[0]->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_OldLicense }}
            </td>
						<td width="50px" style="line-height:250%;">
							{{ number_format(@$value->ContractToDataCusTags->TagToCulculate->Cash_Car, 2) }}
						</td>
						<td width="60px" style="line-height:250%;">
							@if (@$value->ContractToOperated->Act_Price != 0)
								พรบ. {{ number_format(@$value->ContractToOperated->Act_Price) }}
							@endif
						</td>
						<td width="40px" style="background-color: #FFFF00; line-height:250%;">{{ number_format(@$value->ContractToOperated->Tran_Price, 0) }}</td>
						<td width="45px" style="background-color: #FFFF00; line-height:250%;">{{ number_format(@$value->ContractToOperated->Other_Price, 0) }}</td>
						<td width="40px" style="background-color: #FFFF00; line-height:250%;">{{ number_format(@$value->ContractToOperated->Duty_Price + @$value->ContractToOperated->Marketing_Price, 0) }}</td>
						<td width="50px" style="background-color: #FFFF00; line-height:250%;">{{ number_format(@$value->ContractToOperated->Process_Price, 0) }}</td>
						<td width="45px" rowspan="2" style="line-height:450%;">
							@php
								$SumTotal = @$value->ContractToOperated->Total_Price;

								// if (@$value->ContractToOperated->AccountClose_Price != 0) {
								//   $SumTotal -= @$value->ContractToOperated->AccountClose_Price;
								// }
								// if (@$value->ContractToOperated->Act_Price != 0) {
								//   $SumTotal -= @$value->ContractToOperated->Act_Price;
								// }
								// if (@$value->ContractToOperated->Process_Price != 0) {
								//   $SumTotal -= @$value->ContractToOperated->Process_Price;
								// }
								if (@$value->ContractToOperated->DuePrepaid_Price != 0) {
								  $SumTotal -= @$value->ContractToOperated->DuePrepaid_Price;
								}
							@endphp
							{{ number_format($SumTotal, 0) }}
						</td>
						<td width="35px" rowspan="2" style="line-height:450%;">{{ number_format(@$value->ContractToOperated->Balance_Price, 0) }}</td>
						<td width="30px" rowspan="2" style="line-height:450%;">{{ number_format(@$value->ContractToOperated->SumCom_Broker, 0) }}</td>
						<td width="110px" style="line-height:250%;">{{ @$value->ContractToPayee->where('status_Payee', 'Payee')->first()->PayeetoCus->Name_Cus }}</td>
						<td width="110px" style="line-height:250%;">
							@if (@$value->ContractToBrokers != null and count(@$value->ContractToBrokers) > 0)
								<ul>
									@foreach (@$value->ContractToBrokers as $valueBK)
										<li>{{ @$valueBK->BrokertoCus->Name_Cus }}</li>
									@endforeach
								</ul>
							@endif
						</td>
						<td width="65px" style="background-color: #33FF00; line-height:250%;">
							{{-- @if (@$value->ContractToPayee->IDCard_cus == @$value->ContractToOperated->OperatedToBroker->IDCard_Broker)
                  @php
                    $ArcSum = @$value->ContractToOperated->Balance_Price + @$value->ContractToOperated->SumCom_Broker;
                    $sumArcsum = $sumArcsum + $ArcSum;
                  @endphp
                  รวม : {{number_format($ArcSum,2)}}
                @else --}}
							@php
								$sumArcsum = $sumArcsum + @$value->ContractToOperated->Balance_Price;
							@endphp

							ยอด :
                @if ($value->ContractToDataCusTags->Type_Customer == 'CUS-0009')
                  {{ number_format(@$value->ContractToOperated->AccountClose_Price, 2) }}
                @else
                  {{ number_format(@$value->ContractToOperated->Balance_Price, 2) }}
                @endif
							{{-- @endif --}}
						</td>
					</tr>
					<tr align="center" style="line-height: 200%;">
						<td width="50px">
							{{ number_format(@$value->ContractToDataCusTags->TagToCulculate->StatusProcess_Car=='yes'? @$value->ContractToDataCusTags->TagToCulculate->Process_Car:0, 0) }}
						</td>
						<td width="60px">
							@if (@$value->ContractToOperated->AccountClose_Price != 0)
								ปิดบัญชี {{ number_format(@$value->ContractToOperated->AccountClose_Price) }}
							@endif
						</td>
						<td width="40px" style="background-color: #FFFF00;">
							{{ number_format(@$value->ContractToOperated->Tax_Price, 0) }}
						</td>
						<td width="45px" style="background-color: #FFFF00;">
							{{ number_format(@$value->ContractToOperated->Evaluetion_Price, 0) }}
						</td>
						<td width="40px" style="background-color: #FFFF00;">
							{{ number_format(@$value->ContractToOperated->P2_Price, 0) }}
						</td>
						<td width="50px" style="background-color: #FFFF00;">
							{{ number_format(@$value->ContractToOperated->DuePrepaid_Price, 0) }}
						</td>
						<td width="110px">
							{{ '' }}
						</td>
						<td width="110px">
							@if (@$value->ContractToBrokers != null and count(@$value->ContractToBrokers) > 0)
								<ul>
									@foreach (@$value->ContractToBrokers as $valueBK)
										<li>{{ @$valueBK->BrokertoCus->NameEng_Broker }}</li>
									@endforeach
								</ul>
							@endif
							{{-- {{@$value->ContractToOperated->OperatedToBroker->NameEng_Broker}} --}}
						</td>
						<td width="65px">
							@if (@$value->ContractToBrokers != null and count(@$value->ContractToBrokers) > 0)
								<ul>
									@foreach (@$value->ContractToBrokers as $valueSum)
										<li> {{ number_format(@$valueSum->SumCom_Broker, 2) }}</li>
									@endforeach
								</ul>
							@endif
							{{-- @if (!empty(@$value->ContractToOperated->Broker_id))
                  @if (@$value->ContractToOperated->OperatedToCus->IDCard_cus != @$value->ContractToOperated->OperatedToBroker->IDCard_Broker)
                    @php
                      $SumCom += @$value->ContractToOperated->SumCom_Broker;
                    @endphp
                    คอม : {{number_format(@$value->ContractToOperated->SumCom_Broker,2)}}
                  @endif
                @endif --}}
						</td>
					</tr>
					<tr align="center" style="line-height: 200%;">
						<td width="85px" colspan="2" style="background-color: #FFFF00;">
							สัญญา : {{ @$value->Contract_Con }}
						</td>
						<td width="50px"></td>
						<td width="50px">
							@if (strtoupper($value->ContractToDataCusTags->TagToCulculate->Include_PA) == 'YES')
								+PA : {{ number_format(@$value->ContractToDataCusTags->TagToCulculate->Insurance_PA, 0) }}
							@endif
						</td>
						<td width="60px">
							@if (@$value->ContractToOperated->AccountClose_Price_fee != 0)
								ค่าปิดบัญชี {{ number_format(@$value->ContractToOperated->AccountClose_Price_fee, 0) }}
							@endif
						</td>
						<td width="505px" colspan="13">
						</td>
						<td width="65px" style="background-color: #FFFF00;">
							{{ @$value->StatusApp_Con }}
						</td>
					</tr>
					<br>
				@endif
			@endforeach

			@php
				$sumall = $sumArcsum + $sumbalance;
			@endphp
			<tr align="center">
				<td width="200px" style="background-color: #FFFF00; line-height:250%;">รวมยอดจัดเป็นคัน {{ count(@$data) }} คัน</td>
				<td width="125px" style="background-color: #00FFFF; line-height:250%;">รวมยอด +PA {{ number_format(@$SumPA, 2) }}</td>
				<td width="100px" style="background-color: #00FFFF; line-height:250%;">รวมค่าดำเนินการ {{ number_format(@$SumProcess, 2) }}</td>
				<td width="120px" style="background-color: #00FFFF; line-height:250%;"></td>
				<td width="130px" style="background-color: #FFFF00; line-height:250%;">รวมค่ารถ {{ number_format(@$sumbalanceprice, 2) }}</td>
				<td width="140px" style="background-color: #FFFF00; line-height:250%;">รวมค่าคอม {{ number_format(@$sumcommitprice, 2) }}</td>
			</tr>
			<tr align="center">
				<td width="200px" style="background-color: #FFFF00; line-height:250%;">รวมยอดจัดเป็นเงิน {{ number_format(@$sumtopcar, 2) }}</td>
				<td width="125px" style="background-color: #00FFFF; line-height:250%;">รวมค่าใช้จ่ายขนส่ง {{ number_format(@$sumtotran_Price + @$sumtoother_Price, 2) }}</td>
				<td width="100px" style="background-color: #00FFFF; line-height:250%;">รวมค่าใช้จ่ายบริษัท {{ number_format(@$sumtoevaluetion_Price + @$sumtoduty_Price + @$sumtomarketing_Price, 2) }}</td>
				<td width="120px" style="background-color: #00FFFF; line-height:250%;">รวมค่าใช้จ่ายทั้งหมด {{ number_format(@$sumtototal_Price, 2) }}</td>
				<td width="270px" style="background-color: #FFFF00; line-height:250%;">ยอดรวมอนุมัติ {{ number_format(@$sumall, 2) }}</td>
			</tr>
		</tbody>
	</table>
</body>

</html>
