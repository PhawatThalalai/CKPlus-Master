<style>
	.table-payment>tbody>tr:last-child {
		border-bottom: 2px solid rgb(204, 122, 122);
	}
</style>

@php
	$countTHR = $contract->PactToAroth->where('BALANCE', '<>', 0)->isNotEmpty();
	$dataTHR = $contract->PactToAroth->where('BALANCE', '<>', 0);
@endphp

<!-- Nav tabs -->
<ul class="nav nav-pills nav-justified" role="tablist">
	<li class="nav-item waves-effect waves-light" role="presentation">
		<a class="nav-link active" data-bs-toggle="tab" href="#table-1" role="tab" aria-selected="true">
			<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
			<span class="d-none d-sm-block">ตารางค่างวด</span>
		</a>
	</li>
	<li class="nav-item waves-effect waves-light" role="presentation">
		<a class="nav-link btn-view-payother" data-bs-toggle="tab" href="#table-2" role="tab" aria-selected="false" tabindex="-1">
			<span class="d-block d-sm-none"><i class="mdi mdi-cash-plus font-size-16"></i></span>
			<span class="d-none d-sm-block">
				<i class="mdi mdi-cash-plus font-size-16"></i>
				<b>ค่าธรรมเนียมอื่นๆ</b>
				@if (@$contract->pact_to_aroth_count)
					<span class="position-absolute top-0 ms-1 prem ct-tb-view-payother">
						<span class="badge bg-danger rounded-pill">
							{{ @$contract->pact_to_aroth_count }}
						</span>
					</span>
				@endisset
		</span>
	</a>
</li>
</ul>
<!-- Tab panes -->
<div class="tab-content pt-2 text-muted">
<div class="tab-pane active show" id="table-1" role="tabpanel">
	<div class="table-responsive font-size-11" data-simplebar="init" style="max-height: 355px;">
		@if (!empty($Paydue))
			<table class="table table-bordered table-sm mb-0 text text-nowrap table-hover table-payment" style="font-size: 12px;">
				<thead class="sticky-top">
					<tr class="bg-info bg-opacity-80 text-light">
						<th>งวดที่</th>
						<th>วันที่</th>
						<th>ค่างวด</th>
						<th>vat</th>
						{{-- <th>ดอกเบี้ย</th> --}}
						<th>เงินต้น</th>
						<th>วันที่ชำระ</th>
						<th>ยอดชำระ</th>
						<th>วันที่ล่าช้า</th>
						<th>เบี้ยปรับล่าช้า</th>
						<th>ค่าทวงถาม</th>
						{{-- <th>ชำระทวงถาม</th> --}}
						<th>รวมต้องชำระ</th>
					</tr>
				</thead>
				<tbody>
					@php
						$setdamt = 0;
						$setdamt_v = 0;
						$setinterest = 0;
						$setdamt_n = 0;
						$setpayment = 0;
						$setintamt = 0;
						$followamt = 0;
						$payfollow = 0;
						$setSum = 0;
						//  dd($Paydue);
					@endphp
					@if (isset($Paydue))
						@foreach ($Paydue as $row)
							@php
								// if (@$payment) {
								// 	$payamt = (@$row['payamt'] + @$row['intamt']);
								// } else {
								$payamt = @$row['payamt'];
								//}
								$setdamt += $row['dueamt'];
								$setdamt_v += $row['dueamt_v'];
								//@$setinterest += $row['interest'];
								$setdamt_n += $row['dueamt_n'];
								$setpayment += $row['payamt'];
								$setintamt += @$row['intamt'];
								$followamt += @$row['followamt'];
								$payfollow += @$row['payfollow'];
								$setSum += $row['dueamt'] + @$row['intamt'] + (@$row['followamt'] - @$row['payfollow']) - $payamt;
							@endphp
							<tr>
								<td scope="row" class="bg-danger bg-soft text-center">{{ $row['nopay'] }}</td>
								<td scope="row" class="text-center">{{ date('d-m-Y', strtotime($row['duedate'])) }}</td>
								<td scope="row" class="text-end">{{ $row['dueamt'] }}</td>
								<td scope="row" class="text-end">{{ $row['dueamt_v'] }}</td>
								{{-- <td scope="row" class="text-end">{{$row['interest']}}</td> --}}
								<td scope="row" class="text-end">{{ $row['dueamt_n'] }}</td>
								<td scope="row" class="text-center">{{ $row['paydate'] != null ? date('d-m-Y', strtotime($row['paydate'])) : date('d-m-Y') }}</td>
								<td scope="row" class="bg-danger bg-soft text-end">{{ $row['payamt'] }}</td>
								<td scope="row" class="text-end">{{ $row['delayday'] }}</td>
								<td scope="row" class="text-end">{{ @$row['intamt'] }}</td>
								<td scope="row" class="text-end">{{ @$row['followamt'] - @$row['payfollow'] }}</td>
								{{-- <td scope="row" class="text-end text-danger">{{ @$row['payfollow'] }}</td> --}}
								<td scope="row" class="bg-danger bg-soft text-end">{{ number_format($row['dueamt'] + @$row['intamt'] + (@$row['followamt'] - @$row['payfollow']) - @$payamt, 2) }}</td>
							</tr>
						@endforeach
						<tr style="line-height: 200%;">
							<td></td>
						</tr>
						<tr class="bg-info bg-opacity-80 fw-bold text-decoration-underline sticky-bottom text-light">
							<td></td>
							<td></td>
							<td scope="cal" class="text-end">{{ number_format(@$setdamt, 2) }}</td>
							<td scope="cal" class="text-end">{{ number_format(@$setdamt_v, 2) }}</td>
							{{-- <td scope="cal" class="text-end">{{number_format(@$setinterest,2)}}</td> --}}
							<td scope="cal" class="text-end">{{ number_format(@$setdamt_n, 2) }}</td>
							<td></td>
							<td scope="cal" class="text-end">{{ number_format(@$setpayment, 2) }}</td>
							<td></td>
							<td scope="cal" class="text-end">{{ number_format(@$setintamt, 2) }}</td>
							<td scope="cal" class="text-end">{{ number_format(@$followamt - @$payfollow, 2) }}</td>
							{{-- <td scope="cal" class="text-end">{{ number_format(@$payfollow, 2) }}</td> --}}
							<td scope="cal" class="text-end" id="priceCus2">{{ number_format(@$setSum, 2) }}</td>
						</tr>
					@else
						<tr>
							<td>ไม่พบข้อมูล</td>
						</tr>
					@endif
				</tbody>
			</table>
		@else
			<blockquote class="blockquote font-size-16 mb-0">
				<p class="font-size-14">ไม่พบข้อมูล.</p>
				<footer class="blockquote-footer">
					<cite title="Source Title">ลูกค้าไม่มีดิวค้างชำระ ณ. ปัจจุบัน
						<i>&#128522;</i>
					</cite>
				</footer>
			</blockquote>
		@endif
	</div>

	@if ($contract->EXP_AMT != 0)
		<div class="row {{ @$active_table }}">
			<div class="col-6"></div>
			<div class="col-6">
				<div class="table-responsive mt-3">
					<table class="table table-nowrap table-sm">
						<tbody class="fw-semibold font-size-12">
							<tr>
								<td class="border-0 text-end">งวดค้างคงเหลือ</td>
								<td class="border-0 text-end">{{ number_format(($contract->EXP_AMT - @$payAmts < 0 ? 0 : $contract->EXP_AMT - @$payAmts) / $contract->TOT_UPAY, 2) }} งวด</td>
							</tr>
							<tr class="text-danger text-decoration-underline border-danger border-bottom">
								<td width="30px" class="border-0 text-end">ยอดค้างชำระ (เฉพาะค่างวด)</td>
								<td class="border-0 text-end">{{ number_format($contract->EXP_AMT - @$payAmts < 0 ? 0 : $contract->EXP_AMT - @$payAmts, 2) }} บาท</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	@endif
</div>
<div class="tab-pane" id="table-2" role="tabpanel">
	<div class="table-responsive tb-view-payother"></div>
</div>
</div>

<script>
	$('.btn-view-payother').click(function(e) {
		e.preventDefault();
		if ($(this).prop('disabled')) {
			return;
		}

		$('.tb-view-payother').html(`<div>
			<p class="placeholder-glow">
				<span class="placeholder col-6"></span>
				<span class="placeholder w-75"></span>
				<span class="placeholder w-100"></span>
			</p>
		</div>`);

		$(this).prop('disabled', true);
		let cont_id = $('#cont_id').val();
		let codloan = $('#codloan').val();

		let link = "{{ route('payments.show', 'id') }}";
		let url = link.replace('id', cont_id);

		$.ajax({
			url: url,
			method: "GET",
			data: {
				_token: '{{ csrf_token() }}',
				FlagBtn: 'get-AROTHR',
				codloan: codloan,
			},
			success: function(result) {
				$('.tb-view-payother').html(result.html);
				$('.ct-tb-view-payother').html(`<span class="badge bg-danger rounded-pill">` + result.countTHR + `</span>`);
			},
			complete: function() {
				$('.btn-view-payother').prop('disabled', false);
			}
		})
	});
</script>

<script>
	function blinker() {
		$('.prem').fadeOut(1500);
		$('.prem').fadeIn(1500);
	}
	setInterval(blinker, 1500)
</script>
