<section>
	@if (@$at_heading == true)
		<div class="d-flex m-3 mb-0">
			<div class="flex-shrink-0 me-2">
				<img src="{{ asset('assets/images/gif/book.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
			</div>
			<div class="flex-grow-1 overflow-hidden">
				<h5 class="text-primary fw-semibold">ตารางค่างวด</h5>
				<p class="text-muted mt-n1 fw-semibold font-size-12">( View Duepayments List )</p>
				<p class="border-primary border-bottom mt-n2"></p>
			</div>
		</div>
	@endif
	<div class="table-responsive font-size-11" data-simplebar="init" style="{{ @$tb_height }}; min-height : 415px;">
		<table class="table table-striped table-bordered table-hover table-head-fixed text-nowrap font-size-10" cellspacing="0" width="100%">
			<thead class="table-warning sticky-top" style="line-height: 100%;">
				<tr class="text-center">
					<th>งวดที่</th>
					<th>กำหนดชำระ</th>
					<th>ค่างวด</th>
					@if ((@$contract->CONTTYP == 1 || @$contract->CONTTYP == 2) && @$contract->CODLOAN == 1)
						<th>ดอกเบี้ย</th>
						<th>เงินต้น</th>
						<th>เบี้ยปรับ</th>
						<th>ค่าทวงถาม</th>
						<th>วันที่ชำระ</th>
						<th>ยอดชำระ</th>
						<th class="bg-danger text-light">ชำระดอกเบี้ย</th>
						<th class="bg-danger text-light">ชำระเงินต้น</th>
						<th class="bg-danger text-light">เงินต้นคงเหลือ</th>
					@elseif (@$contract->CONTTYP == 1 && @$contract->CODLOAN == 2)
						<th>เบี้ยปรับ</th>
						<th>ค่าทวงถาม</th>
						<th>วันที่ชำระ</th>
						<th>ยอดชำระ</th>
						<th>เลขใบกำกับ</th>
						<th>วันที่ใบกำกับ</th>
					@elseif (@$contract->CONTTYP == 3 && @$contract->CODLOAN == 1)
						<th>เบี้ยปรับ</th>
						<th>ค่าทวงถาม</th>
						<th>วันที่ชำระ</th>
						<th>ยอดชำระ</th>
					@endif
				</tr>
			</thead>
			@if ((@$contract->CONTTYP == 1 ) && @$contract->CODLOAN == 1)
				<tbody class="font-size-11">
					@foreach (@$contract->ContractDUEPAYMENT as $key => $value)
						<tr>
							<td class="text-center">{{ @$value->NOPAY }}</td>
							<td class="text-center">{{ date('d-m-Y', strtotime(@$value->DUEDATE)) }}</td>
							<td class="text-end">{{ number_format(@$value->DUEAMT, 2) }}</td>
							<td class="text-end">{{ number_format(@$value->DUEINTEFF, 2) }}</td>
							<td class="text-end">{{ number_format(@$value->DUETONEFF, 2) }}</td>
							<td class="text-end">{{ number_format(@$value->INTLATEAMT, 2) }}</td>
							<td class="text-end">{{ number_format(@$value->FOLLOWAMT, 2) }}</td>
							<td class="text-center">
								@if (@$value->PAYDATE != null)
									{{ date('d-m-Y', strtotime($value->PAYDATE)) }}
								@else
									<em class="text-secondary text-opacity-50">ไม่พบข้อมูล</em>
								@endif
							</td>
							<td class="text-end">{{ number_format(@$value->PAYAMT, 2) }}</td>
							<td class="text-end">{{ number_format(@$value->PAYINTEFF, 2) }}</td>
							<td class="text-end">{{ number_format(@$value->PAYTON, 2) }}</td>
							<td class="text-end">{{ number_format(@$value->TONBALANCE, 2) }}</td>
						</tr>

						@php
							@$sumPAYAMT += @$value->PAYAMT;
							@$sumPAYINTEEF += @$value->PAYINTEFF;
							@$sumPAYTON += @$value->PAYTON;
							@$sumAmount += @$value->TONBALANCE ;
						@endphp
					@endforeach
				</tbody>
				<tfoot class="table-warning sticky-bottom" style="line-height: 130%;">
					<tr>
						<th class="text-center">ผ่อน {{ $contract->ContractDUEPAYMENT->count('nopay') }}</th>
						<th></th>
						<th class="text-end">{{ number_format(@$contract->ContractDUEPAYMENT->sum('DUEAMT'), 2) }}</th>
						<th class="text-end">{{ number_format(@$contract->ContractDUEPAYMENT->sum('DUEINTEFF'), 2) }}</th>
						<th class="text-end">{{ number_format(@$contract->ContractDUEPAYMENT->sum('DUETONEFF'), 2) }}</th>
						<th class="text-end">{{ number_format(@$contract->ContractDUEPAYMENT->sum('INTLATEAMT'), 2) }}</th>
						<th class="text-end">{{ number_format(@$contract->ContractDUEPAYMENT->sum('FOLLOWAMT'), 2) }}</th>
						<th></th>
						<th class="text-end">{{ number_format(@$sumPAYAMT, 2) }}</th>
						<th class="text-end">{{ number_format(@$sumPAYINTEEF, 2) }}</th>
						<th class="text-end">{{ number_format(@$sumPAYTON, 2) }}</th>
						<th class="text-end"> </th>
					</tr>
				</tfoot>
			@elseif(@$contract->CONTTYP == 2 && @$contract->CODLOAN == 1)
				<tbody class="font-size-11">
					@foreach (@$contract->ContractPaydueLoan as $key => $value)
						<tr>
							<td class="text-center">{{ @$value->nopay }}</td>
							<td class="text-center">{{ date('d-m-Y', strtotime(@$value->ddate)) }}</td>
							<td class="text-end">{{ number_format(@$value->damt, 2) }}</td>
							<td class="text-end">{{ number_format(@$value->capital, 2) }}</td>
							<td class="text-end">{{ number_format(@$value->interest, 2) }}</td>
							<td class="text-end">{{ number_format(@$value->intamt , 2) }}</td>
							<td class="text-end">{{ number_format(@$value->FOLLOWAMT , 2) }}</td>
							<td class="text-center">
								@if (@$value->date1 != null)
									{{ date('d-m-Y', strtotime($value->date1)) }}
								@else
									<em class="text-secondary text-opacity-50">ไม่พบข้อมูล</em>
								@endif
							</td>
							<td class="text-end">{{ number_format(@$value->payment, 2) }}</td>
							<td class="text-end">{{ number_format(@$value->V_PAYMENT, 2) }}</td>
							<td class="text-end">{{ number_format(@$value->N_PAYMENT, 2) }}</td>
							<td class="text-end">{{ number_format(@$value->capitalbl , 2) }}</td>
						</tr>

						@php
							@$sumPAYAMT += @$value->pament;
							@$sumPAYINTEEF += @$value->V_PAYMENT;
							@$sumPAYTON += @$value->N_PAYMENT;
							@$sumAmount += @$value->capitalbl ;
						@endphp
					@endforeach
				</tbody>
				<tfoot class="table-warning sticky-bottom" style="line-height: 130%;">
					<tr>
						<th class="text-center">ผ่อน {{ $contract->ContractPaydueLoan->count('nopay') }}</th>
						<th></th>
						<th class="text-end">{{ number_format(@$contract->ContractPaydueLoan->sum('damt'), 2) }}</th>
						<th class="text-end">{{ number_format(@$contract->ContractPaydueLoan->sum('capital'), 2) }}</th>
						<th class="text-end">{{ number_format(@$contract->ContractPaydueLoan->sum('interest'), 2) }}</th>
						<th class="text-end">{{ number_format(@$contract->ContractPaydueLoan->sum('intamt') , 2) }}</th>
						<th class="text-end">{{ number_format(@$contract->ContractPaydueLoan->sum('FOLLOWAMT') , 2) }}</th>
						<th></th>
						<th class="text-end">{{ number_format(@$sumPAYAMT, 2) }}</th>
						<th class="text-end">{{ number_format(@$sumPAYINTEEF, 2) }}</th>
						<th class="text-end">{{ number_format(@$sumPAYTON, 2) }}</th>
						<th class="text-end"></th>
					</tr>
				</tfoot>
			@elseif (@$contract->CONTTYP == 1 && @$contract->CODLOAN == 2)
				<tbody class="font-size-11">
					@foreach (@$contract->ContractPaydue as $key => $value)
						<tr>
							<td class="text-center">{{ @$value->nopay }}</td>
							<td class="text-center">{{ date('d-m-Y', strtotime(@$value->ddate)) }}</td>
							<td class="text-end">{{ number_format(@$value->damt, 2) }}</td>
							<td class="text-end">{{ number_format(@$value->intamt , 2) }}</td>
							<td class="text-end">{{ number_format(@$value->FOLLOWAMT , 2) }}</td>
							<td class="text-center">{{ @$value->date1 != null ? date('d-m-Y', strtotime($value->date1)) : '' }}</td>
							<td class="text-end">{{ $value->payment != null ? number_format($value->payment, 2) : '0.00' }}</td>
							<td class="text-end">{{ @$value->taxno }}</td>
							<td class="text-center">{{ @$value->taxdate != null ? date('d-m-Y', strtotime($value->taxdate)) : '' }}</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot class="table-warning sticky-bottom" style="line-height: 130%;">
					<tr>
						<th class="text-center">ผ่อน {{ $contract->ContractPaydue()->count('nopay') }}</th>
						<th></th>
						<th class="text-end">{{ number_format($contract->ContractPaydue->sum('damt'), 2) }} บาท</th>
						<th class="text-end">{{ number_format(@$contract->ContractPaydue->sum('intamt') , 2) }}</th>
						<th class="text-end">{{ number_format(@$contract->ContractPaydue->sum('FOLLOWAMT') , 2) }}</th>
						<th></th>
						<th class="text-end">{{ number_format($contract->ContractPaydue->sum('payment'), 2) }} บาท</th>
						<th></th>
						<th></th>
					</tr>
				</tfoot>
			@elseif (@$contract->CONTTYP == 3 && @$contract->CODLOAN == 1)
				<tbody class="font-size-11">
					@foreach (@$contract->ContractPaydueLoan as $key => $value)
						<tr>
							<td class="text-center">{{ @$value->nopay }}</td>
							<td class="text-center">{{ date('d-m-Y', strtotime(@$value->ddate)) }}</td>
							<td class="text-end">{{ number_format(@$value->damt, 2) }}</td>
							<td class="text-end">{{ number_format(@$value->intamt , 2) }}</td>
							<td class="text-end">{{ number_format(@$value->FOLLOWAMT , 2) }}</td>
							<td class="text-center">{{ @$value->date1 != null ? date('d-m-Y', strtotime($value->date1)) : '' }}</td>
							<td class="text-end">{{ $value->payment != null ? number_format($value->payment, 2) : '0.00' }}</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot class="table-warning sticky-bottom" style="line-height: 130%;">
					<tr>
						<th class="text-center">ผ่อน {{ $contract->ContractPaydueLoan()->count('nopay') }}</th>
						<th></th>
						<th class="text-end">{{ number_format($contract->ContractPaydueLoan->sum('damt'), 2) }} บาท</th>
						<th class="text-end">{{ number_format(@$contract->ContractPaydue->sum('intamt') , 2) }}</th>
						<th class="text-end">{{ number_format(@$contract->ContractPaydue->sum('FOLLOWAMT') , 2) }}</th>
						<th></th>
						<th class="text-end">{{ number_format($contract->ContractPaydueLoan->sum('payment'), 2) }} บาท</th>
					</tr>
				</tfoot>
			@endif
		</table>
	</div>
</section>
