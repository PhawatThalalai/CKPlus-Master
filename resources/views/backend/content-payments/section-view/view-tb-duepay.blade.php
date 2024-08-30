<style>
	.table-payment>tbody>tr:last-child {
		border-bottom: 2px solid rgb(204, 122, 122);
	}
</style>

@php
	$countTHR = $contract->PactToAroth->where('BALANCE', '<>', 0)->isNotEmpty();
@endphp

<!-- Nav tabs -->
<ul class="nav nav-pills nav-justified" role="tablist">
	<li class="nav-item waves-effect waves-light" role="presentation">
		<a class="nav-link active" data-bs-toggle="tab" href="#table-1" role="tab" aria-selected="true">
			<span class="d-block d-sm-none"><i class="fas fa-calendar-day"></i></span>
			<span class="d-none d-sm-block">
				<i class="fas fa-calendar-day"></i>
				<b>ตารางค่างวด</b>
			</span>
		</a>
	</li>
	<li class="nav-item waves-effect waves-light" role="presentation">
		<a class="nav-link btn-view-payother" data-bs-toggle="tab" href="#table-2" role="tab" aria-selected="false" tabindex="-1">
			<span class="d-block d-sm-none"><i class="mdi mdi-cash-plus font-size-16"></i></span>
			<span class="d-none d-sm-block">
				<i class="mdi mdi-cash-plus font-size-16"></i>
				<b>ค่าธรรมเนียมอื่นๆ</b>
				@if (@$countTHR)
					<span class="position-absolute top-0 ms-1 prem ct-tb-view-payother">
						<span class="badge bg-danger rounded-pill">
							{{ count($contract->PactToAroth->where('BALANCE', '<>', 0)) }}
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
			<table class="table table-bordered table-sm mb-0 text text-nowrap table-hover table-payment table-paydue" style="font-size: 12px;">
				<thead class="sticky-top">
					<tr class="bg-info bg-opacity-80 text-light">
						<th>งวดที่</th>
						<th>วันที่</th>
						{{-- <th>จำนวนวัน</th> --}}
						<th>ค่างวด</th>
						<th>ดอกเบี้ย</th>
						<th>เงินต้น</th>
						<th>วันที่ชำระ</th>
						<th>ยอดชำระ</th>
						<th>ชำระดอกเบี้ย</th>
						<th>ชำระเงินต้น</th>
						<th>วันที่ล่าช้า</th>
						<th>เบี้ยปรับล่าช้า</th>
						<th>ค่าทวงถาม</th>
						{{-- <th>ชำระทวงถาม</th> --}}
						<th>รวมต้องชำระ</th>
					</tr>
				</thead>
				<tbody>
					@php
						$setdueamt = 0;
						$setdueinteff = 0;
						$setduetoneff = 0;
						$setpayamt = 0;
						$setpayinteff = 0;
						$setpayton = 0;
						$setINTLATEAMT = 0;
						$setSum = 0;
						$followamt = 0;
						$payfollow = 0;
					@endphp

					@foreach ($Paydue as $row)
						@php
							if ($contract->CONTTYP != 3) {
							    $dueamt = @$row['dueamt'];
							} else {
							    $dueamt = @$row['dueamt'] + @$row['duetoneff'];
							}

							// if (@$payment) {
							// 	$payamt = @$row['payamt'] + @$row['INTLATEAMT'];
							// } else {
							$payamt = @$row['payamt'];
							//}

							$setdueamt += @$row['dueamt'];
							$setdueinteff += @$row['dueinteff'];
							$setduetoneff += @$row['duetoneff'];
							$setpayamt += @$row['payamt'];
							$setpayinteff += @$row['payinteff'];
							$setpayton += @$row['payton'];
							$setINTLATEAMT += @$row['INTLATEAMT'];
							$setSum += @$dueamt + @$row['INTLATEAMT'] + (@$row['followamt'] - @$row['payfollow']) - @$payamt;
							$followamt += @$row['followamt'];
							$payfollow += @$row['payfollow'];
						@endphp
						<tr class="data-tbPaydue">
							<td scope="row" class="bg-danger bg-soft text-center">{{ @$row['nopay'] }}</td>
							<td scope="row" class="text-center">{{ date('d-m-Y', strtotime(@$row['duedate'])) }}</td>
							{{-- <td scope="row">{{@$row['delayday']}}</td> --}}
							<td scope="row" class="bg-danger bg-soft text-end">{{ @$row['dueamt'] }}</td>
							<td scope="row" class="text-end">{{ @$row['dueinteff'] }}</td>
							<td scope="row" class="text-end">{{ @$row['duetoneff'] }}</td>
							<td scope="row" class="text-center">{{ date('d-m-Y', strtotime(@$row['paydate'])) }}</td>
							<td scope="row" class="bg-danger bg-soft text-end">{{ @$row['payamt'] }}</td>
							<td scope="row" class="text-end">{{ @$row['payinteff'] }}</td>
							<td scope="row" class="text-end">{{ @$row['payton'] }}</td>
							<td scope="row" class="text-end">{{ @$row['intlateday'] }}</td>
							<td scope="row" class="text-end">{{ @$row['INTLATEAMT'] }}</td>
							<td scope="row" class="text-end">{{ @$row['followamt'] - @$row['payfollow'] }}</td>
							{{-- <td scope="row" class="text-end text-danger">{{ @$row['payfollow'] }}</td> --}}
							<td scope="row" class="bg-danger bg-soft text-end">
								{{ number_format(@$row['followamt'] - @$row['payfollow'] + @$row['INTLATEAMT'] + @$dueamt - @$payamt, 2) }}
							</td>
						</tr>
					@endforeach
					<tr style="line-height: 200%;">
						<td></td>
					</tr>
				</tbody>
                <tfoot>
                    <tr class="bg-info bg-opacity-80 text-light fw-bold text-decoration-underline sticky-bottom">
						<td></td>
						<td></td>
						<td scope="cal" class="text-end">{{ number_format(@$setdueamt, 2) }}</td>
						<td scope="cal" class="text-end">{{ number_format(@$setdueinteff, 2) }}</td>
						<td scope="cal" class="text-end">{{ number_format(@$setduetoneff, 2) }}</td>
						<td></td>
						<td scope="cal" class="text-end">{{ number_format(@$setpayamt, 2) }}</td>
						<td scope="cal" class="text-end">{{ number_format(@$setpayinteff, 2) }}</td>
						<td scope="cal" class="text-end">{{ number_format(@$setpayton, 2) }}</td>
						<td></td>
						<td scope="cal" class="text-end">{{ number_format(@$setINTLATEAMT, 2) }}</td>
						<td scope="cal" class="text-end">{{ number_format(@$followamt - @$payfollow, 2) }}</td>
						{{-- <td scope="cal" class="text-end">{{ number_format(@$payfollow, 2) }}</td> --}}
						<td scope="cal" class="text-end" id="priceCus2">{{ number_format(@$setSum, 2) }}</td>
					</tr>
                </tfoot>
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
							@php
								$nopay_Bl = ($contract->EXP_AMT - @$payAmts) / $contract->TOT_UPAY;
								$nopay = $nopay_Bl > 0 ? $nopay_Bl : 0;
								$kang_bl = $contract->EXP_AMT - @$payAmts;
								$kang = $kang_bl > 0 ? $kang_bl : 0;
							@endphp
							<tr>
								<td class="border-0 text-end">งวดค้างคงเหลือ</td>
								<td class="border-0 text-end">{{ number_format($nopay, 2) }} งวด</td>
							</tr>
							<tr class="text-danger text-decoration-underline border-danger border-bottom">
								<td width="30px" class="border-0 text-end">ยอดค้างชำระ (เฉพาะค่างวด)</td>
								<td class="border-0 text-end">{{ number_format($kang, 2) }} บาท</td>
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
		console.log('click');
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
				console.log(result);

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
