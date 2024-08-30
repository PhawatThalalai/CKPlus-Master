<style>
	.rotate {
		-moz-transition: all .1s linear;
		-webkit-transition: all .1s linear;
		transition: all .1s linear;
	}

	.rotate.down {
		-moz-transform: rotate(180deg);
		-webkit-transform: rotate(180deg);
		transform: rotate(180deg);
	}
</style>

<div class="card" id="card-payother">
	<div class="card-body pt-2">
		@isset($PayOther)
			<ul class="nav nav-pills nav-justified" role="tablist">
				@foreach ($PayOther as $PAYFOR => $items)
					<li class="nav-item waves-effect waves-light" role="presentation">
						<a class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab" href="#tab-{{ $PAYFOR }}" role="tab" aria-selected="true">
							<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
							<span class="d-none d-sm-block fw-bold">{{ $items[0]->PAYCODE->FORDESC }} ({{ $PAYFOR }})</span>
						</a>
					</li>
				@endforeach
			</ul>
			<div class="tab-content text-muted">
				@foreach ($PayOther as $itempay => $items)
					{{-- <div class="table-responsive">
						<table class="table table-editable table-nowrap align-middle table-edits">
							<thead>
								<tr>
									<th>ID</th>
									<th>Name</th>
									<th>Age</th>
									<th>Gender</th>
									<th>Edit</th>
								</tr>
							</thead>
							<tbody>
								<tr data-id="1">
									<td data-field="id" style="width: 80px">1</td>
									<td data-field="name">David McHenry</td>
									<td data-field="age">24</td>
									<td data-field="gender">Male</td>
									<td style="width: 100px">
										<a class="btn btn-outline-secondary btn-sm edit" title="Edit">
											<i class="fas fa-pencil-alt"></i>
										</a>
									</td>
								</tr>
								<tr data-id="2">
									<td>2</td>
									<td data-field="name">Frank Kirk</td>
									<td data-field="age">22</td>
									<td>Male</td>
									<td>
										<a class="btn btn-outline-secondary btn-sm edit" title="Edit">
											<i class="fas fa-pencil-alt"></i>
										</a>
									</td>
								</tr>
							</tbody>
						</table>
					</div> --}}

					<div class="tab-pane {{ $loop->first ? 'active show' : '' }}" id="tab-{{ $itempay }}" role="tabpanel">
						<div class="table-responsive">
							<table class="table align-middle table-nowrap text-nowrap table-hover table-check font-size-12 table-editable table-edits">
								<thead class="table-light">
									<tr class="text-center bg-info bg-opacity-80">
										<th style="width: 20px;">
											#
											{{-- <div class="form-check font-size-16">
												<input class="form-check-input" type="checkbox" id="checkAll">
												<label class="form-check-label" for="checkAll"></label>
											</div> --}}
										</th>
										<th>วันตั้งหนี้</th>
										<th>รหัสชำระ</th>
										<th>รายการ</th>
										<th>ยอดลูกหนี้</th>
										<th>ส่วนลด</th>
										<th></th>
									</tr>
								</thead>
								@foreach ($items as $key => $item)
									<tbody class="tbody-pay">
										<tr data-id="{{ $item->id }}" id="item-{{ $item->id }}">
											<td>
												<div class="form-check font-size-16">
													<input type="checkbox" style="height: 18px;" class="form-check-input idCkeck-{{ $item->id }}" name="item_payother" id="{{ $item->id }}" data-arothr="{{ $item->PAYAMT }}" data-payfor="{{ $item->PAYFOR }}" data-payamt="{{ $item->PAYAMT }}">
													<label class="form-check-label" for="orderidcheck01"></label>
												</div>
											</td>
											<td class="text-center">
												<button type="button" class="btn btn-light btn-sm btn-rounded waves-effect waves-light">
													<i class="bx bx-calendar-event text-info"></i>
												</button>
												<span class="">{{ date('d-m-Y', strtotime(@$item->INPDT)) }}</span>
											</td>
											<td class="text-center">
												<button type="button" class="btn btn-soft-info btn-sm btn-rounded PAYFOR">
													{{ @$item->PAYFOR }}
												</button>
											</td>
											<td class="text-center">
												<button type="button" class="btn btn-success btn-sm btn-rounded align-center">
													{{ @$item->PAYCODE->FORDESC }}
												</button>
											</td>
											<td class="text-end PAYAMT idPayt-{{ $item->id }}">{{ number_format($item->PAYAMT - $item->SMPAY, 2) }}</td>
											<td class="text-end dicint" data-field="DISCT" data-id="{{ $item->id }}" data-type="number">{{ number_format($item->DISCOUNT, 2) }}</td>
											<td class="text-center btn-edit">
												<a class="btn btn-outline-warning btn-sm edit d-none" title="Edit">
													<i class="fas fa-pencil-alt" title="Edit"></i>
												</a>
											</td>
										</tr>
									</tbody>
								@endforeach
							</table>
						</div>
					</div>
				@endforeach
			</div>
		@endisset
		@empty($PayOther)
			<blockquote class="blockquote font-size-16 mb-0">
				<p class="font-size-14">ไม่พบข้อมูล.</p>
				<footer class="blockquote-footer"><cite title="Source Title">โปรดตรวจสอบ รายการลูกหนี้อื่นของลูกค้า</cite></footer>
			</blockquote>
		@endempty
	</div>
</div>

<script>
	$('#checkAll').on('change', function() {
		$('.table-check .form-check-input').prop('checked', $(this).prop("checked"));
	});

	// $('.table-check .form-check-input').change(function() {
	// 	let id = $(this).attr('id');
	// 	let tb_price = $(this).data('arothr');
	// 	let tb_payfor = $(this).data('payfor');
	// 	let pay_arothr = $('#sum_arothr').val().replace(/,/g, '');

	// 	if (pay_arothr == '') {
	// 		var sum_arothr = 0;
	// 	} else {
	// 		var sum_arothr = pay_arothr;
	// 	}

	// 	if ($(this).is(':checked')) {
	// 		var html = $('.tbody-pay #item-' + id).prop('outerHTML');
	// 		$("#body-payother").append(html);

	// 		$('#body-payother .idCkeck-' + id).prop('checked', true);
	// 		$('#body-payother .idCkeck-' + id).prop('disabled', true);

	// 		// $('#sum_arothr').val(addCommas(parseFloat(sum_arothr) + parseFloat(tb_price)));
	// 		// dicintSum();
	// 	} else {
	// 		$("#body-payother #item-" + id).remove();
	// 		// $('#sum_arothr').val(addCommas(parseFloat(sum_arothr) - parseFloat(tb_price)));
	// 	}

	// 	// reset input required
	// 	if ($('.table-check .tbody-pay .form-check-input:checked').length == 0) {
	// 		$('#sum_arothr').val('');

	// 		$('#PAYAMT').val('');
	// 		$('#PAYAMT').prop('readonly', true);
	// 	} else {
	// 		$('#PAYAMT').prop('readonly', false);
	// 	}
	// });

	// function dicintSum() {
	// 	let dicintValues = $('.tbody-pay .dicint').map(function() {
	// 		return parseInt($(this).html()) || 0;
	// 	}).get();

	// 	let dicintSum = dicintValues.reduce((sum, value) => sum + value, 0);
	// 	$('#DISCT').val(dicintSum);
	// }
</script>

{{-- edit table --}}
<script src="{{ URL::asset('/assets/libs/table-edits/table-edits.min.js') }}"></script>
<script src="{{ URL::asset('/assets/js/pages/table-editable-payment.int.js') }}"></script>
