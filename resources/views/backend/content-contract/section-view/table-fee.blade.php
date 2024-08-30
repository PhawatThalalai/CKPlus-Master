<style>
	.hiddenRow {
		padding: 0 !important;
	}
</style>

<section>
	@if (@$at_heading == true)
		<div class="d-flex m-3 mb-0">
			<div class="flex-shrink-0 me-2">
				<img src="{{ asset('assets/images/gif/book.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
			</div>
			<div class="flex-grow-1 overflow-hidden">
				<h5 class="text-primary fw-semibold">ค่าธรรมเนียมอื่นๆ</h5>
				<p class="text-muted mt-n1 fw-semibold font-size-12">( View Other Fees List )</p>
				<p class="border-primary border-bottom mt-n2"></p>
			</div>
		</div>
	@endif
	<div class="table-responsive font-size-11" data-simplebar="init" style="{{ @$tb_height }}; min-height : 415px;">
		{{-- <table class="table table-striped table-bordered table-hover table-head-fixed text-nowrap font-size-10" cellspacing="0" width="100%">
			<thead class="table-warning sticky-top" style="line-height: 100%;">
				<tr class="text-center">
					@if (@$item_btn == true)
						<th>#</th>
					@endif
					<th>สถานะ</th>
					<th>สาขารับ</th>
					<th>เลขที่ใบรับ</th>
					<th>วันที่ชำระ</th>
					<th>ชำระค่า</th>
					<th>รายการ</th>
					<th>ยอดชำระ</th>
					<th>ส่วนลด</th>
				</tr>
			</thead>
			@isset($contract->ContractTranFee)
				<tbody class="tbody-fee">
					@foreach (@$contract->ContractTranFee as $key => $value)
						<tr class="flag-{{ $value->FLAG }}">
							@if (@$item_btn == true)
								<td class="text-center">
									<div class="d-flex justify-content-center gap-2">
										<a role="button" class="text-success hover-up" data-bs-toggle="tooltip" title="พิมพ์ใบเสร็จ">
											<i class="mdi mdi-printer-check font-size-16"></i>
										</a>
										<a role="button" data-id="{{ $value->id }}" class="text-danger hover-up cancel-paynt {{ $value->FLAG != 'C' ? '' : 'disabled' }}" data-bs-toggle="tooltip" title="ขอยกเลิกใบเสร็จ">
											<i class="mdi mdi-clipboard-text-off-outline font-size-16"></i>
										</a>
									</div>
								</td>
							@endif
							<td class="text-center">
								<div class="d-flex justify-content-center">
									@if ($value->FLAG == 'H')
										<span class="btn btn-success btn-sm btn-rounded waves-effect waves-light" data-bs-toggle="popover" data-bs-placement="top" data-bs-html="true" data-bs-sanitize="false" data-bs-content='<div class="row px-2">
											<div class="col-5 fw-bold content-info-row">วันที่บันทึก:</div>
											<div class="col-7 text-end content-info-row">{{ $value->created_at }}</div>
											<div class="col-5 fw-bold content-info-row">ผู้บันทึก:</div>
											<div class="col-7 text-end content-info-row">{{ $value->CHQTrantoUser->name }}</div>
											</div>'>
											ปกติ
										</span>
									@elseif($value->FLAG == 'C')
										<span class="btn btn-danger btn-sm btn-rounded waves-effect waves-light flag-pay" data-bs-toggle="popover" data-bs-placement="top" data-bs-html="true" data-bs-sanitize="false" data-bs-content='<div class="row px-2">
											<div class="col-5 fw-bold content-info-row">วันยกเลิก:</div>
											<div class="col-7 text-end content-info-row">{{ $value->created_at }}</div>
											<div class="col-5 fw-bold content-info-row">ผู้ยกเลิก:</div>
											<div class="col-7 text-end content-info-row">{{ $value->CHQTrantoUser->name }}</div>
											</div>'>
											ยกเลิก
										</span>
									@endif
								</div>
							</td>
							<td class="text-center ch-alert">{{ $value->TranToLOCATREC->NickName_Branch }}</td>
							<td class="text-center ch-alert">{{ $value->TMBILL }}</td>
							<td class="text-center ch-alert">{{ date('d-m-Y', strtotime($value->TMBILDT)) }}</td>
							<td class="text-center ch-alert">{{ $value->PAYFOR }}</td>
							<td class="text-center ch-alert">{{ $value->PAYCODE->FORDESC }}</td>
							<td class="text-end ch-alert">{{ number_format($value->PAYAMT, 2) }}</td>
							<td class="text-end ch-alert">{{ number_format($value->DISCT, 2) }}</td>
						</tr>
					@endforeach
				</tbody>
				<tfoot class="table-warning sticky-bottom text-center" style="line-height: 130%;">
					<tr>
						@if (@$item_btn == true)
							<th></th>
						@endif
						<th></th>
						<th></th>
						<th>{{ @$contract->ContractTranFee->count('BILLNO') }} รายการ</th>
						<th></th>
						<th></th>
						<th></th>
						<th>
							{{ number_format(@$contract->ContractTranFee->where('FLAG', 'H')->sum('PAYAMT'), 2) }}
						</th>
						<th>
							{{ number_format(@$contract->ContractTranFee->where('FLAG', 'H')->sum('DISCT'), 2) }}
						</th>
					</tr>
				</tfoot>
			@endisset
		</table> --}}

		<table class="table align-middle table-striped table-bordered table-hover table-head-fixed text-nowrap font-size-10" cellspacing="0" width="100%">
			<thead class="table-warning sticky-top" style="line-height: 100%;">
				<tr class="text-center">
					<th style="width: 10px"></th>
					@if (@$item_btn == true)
						<th style="width: 30px">#</th>
					@endif
					<th>สถานะ</th>
					<th>สาขารับ</th>
					<th>เลขที่ใบรับ</th>
					<th>วันที่รับ</th>
					<th>ชำระโดย</th>
					<th>ยอดชำระ</th>
				</tr>
			</thead>
			@isset($contract->ContractCHQMasfee)
				@foreach (@$contract->ContractCHQMasfee as $key => $value)
					<tbody class="tbody-fee">
						<tr class="flag-{{ $value->FLAG }} accordion-toggle" data-bs-toggle="collapse" data-bs-target="#fee_{{ $value->id }}">
							<td>
								<a role="button" class="text-secondary {{(count($value->CHMasToCHTranMn) != 0)? '' : 'disabled'}}" data-bs-toggle="tooltip" title="รายการเพิ่มเติม">
									<i class="mdi mdi-eye-plus font-size-16"></i>
								</a>
							</td>
							@if (@$item_btn == true)
								<td class="text-center">
									<div class="d-flex justify-content-center gap-2">
										<a role="button" class="text-success hover-up" data-bs-toggle="tooltip" title="พิมพ์ใบเสร็จ">
											<i class="mdi mdi-printer-check font-size-16"></i>
										</a>

										<div class="btnOther-cancel {{ ($value->FLAG == 'H' and empty($value->ASK_FLAG)) ? 'btn-paynt' : 'btn-ask' }}" data-id="{{ $value->id }}" data-codloan="{{ $value->CHQMasContract->CODLOAN }}">
											<a role="button" class="text-danger hover-up Other-paynt {{ ($value->FLAG == 'H' and empty($value->ASK_FLAG)) ? '' : 'd-none' }}" data-bs-toggle="tooltip" title="แจ้งยกเลิกใบเสร็จ">
												<i class="mdi mdi-clipboard-text-off-outline font-size-16"></i>
											</a>
											<a role="button" class="text-secondary hover-up Other-ask {{ $value->ASK_FLAG == 'N' ? '' : 'd-none' }}" data-bs-toggle="tooltip" title="คืนค่า">
												<i class="mdi mdi-replay font-size-16"></i>
											</a>
										</div>
									</div>
								</td>
							@endif
							<td class="text-center">
								<div class="d-flex justify-content-center flagFee_{{ $value->id }}">
									@if ($value->ASK_FLAG == 'N')
										<span class="btn btn-warning btn-sm btn-rounded waves-effect waves-light" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-html="true" data-bs-sanitize="false" data-bs-content='<div class="row px-2">
												<div class="col-5 fw-bold content-info-row">วันขอยกเลิก:</div>
												<div class="col-7 text-end content-info-row">{{ date('Y-m-d H:i:s', strtotime($value->ASK_DT)) }}</div>
												<div class="col-5 fw-bold content-info-row">ผู้ขอยกเลิก:</div>
												<div class="col-7 text-end content-info-row">{{ @$value->CHMasASKID->name }}</div>
											</div>'>
											ขอยกเลิก
										</span>
									@elseif ($value->FLAG == 'H')
										<span class="btn btn-success btn-sm btn-rounded waves-effect waves-light" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-html="true" data-bs-sanitize="false" data-bs-content='<div class="row px-2">
												<div class="col-5 fw-bold content-info-row">วันที่บันทึก:</div>
												<div class="col-7 text-end content-info-row">{{ date('Y-m-d H:i:s', strtotime($value->created_at)) }}</div>
												<div class="col-5 fw-bold content-info-row">ผู้บันทึก:</div>
												<div class="col-7 text-end content-info-row">{{ @$value->CHQMastoUser->name }}</div>
											</div>'>
											ปกติ
										</span>
									@elseif($value->FLAG == 'C')
										<span class="btn btn-danger btn-sm btn-rounded waves-effect waves-light" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-html="true" data-bs-sanitize="false" data-bs-content='<div class="row px-2">
												<div class="col-5 fw-bold content-info-row">วันยกเลิก:</div>
												<div class="col-7 text-end content-info-row">{{ date('Y-m-d H:i:s', strtotime($value->CANDT)) }}</div>
												<div class="col-5 fw-bold content-info-row">ผู้ยกเลิก:</div>
												<div class="col-7 text-end content-info-row">{{ @$value->CHMasCANID->name }}</div>
											</div>'>
											ยกเลิก
										</span>
									@endif
								</div>
							</td>
							<td class="text-center ch-alert">{{ $value->BrLOCATREC->Name_Branch }}</td>
							<td class="text-center ch-alert">{{ $value->BILLNO }}</td>
							<td class="text-center ch-alert">{{ date('d-m-Y', strtotime($value->PAYDT)) }}</td>
							<td class="text-center ch-alert">{{ $value->PAYTYP }}</td>
							<td class="text-end ch-alert">{{ number_format($value->CHQAMT, 2) }}</td>
						</tr>

						@if(count($value->CHMasToCHTranMn) != 0)
							<tr class="flag-{{ $value->FLAG }}">
								<td colspan="12" class="hiddenRow">
									<div class="accordian-body collapse" id="fee_{{ $value->id }}">
										<table class="table table-striped table-hover table table-bordered">
											<thead>
												<tr class="table-success text-center">
													<th>วันที่รับ</th>
													<th>ชำระค่า</th>
													<th>รายการ</th>
													<th>ยอดชำระ</th>
													<th>ส่วนลด</th>
													<th>ยอดสุทธิ</th>
													<th>วันที่ตั้งหนี้</th>
												</tr>
											</thead>
											@foreach ($value->CHMasToCHTranMn as $key => $item)
												<tbody class="table-light">
													<tr>
														<td class="text-center ch-alert">{{ date('d-m-Y', strtotime(@$item->PAYDT)) }}</td>
														<td class="text-center ch-alert">{{ @$item->PAYFOR }}</td>
														<td class="text-center ch-alert">{{ @$item->PAYCODE->FORDESC }}</td>
														<td class="text-end ch-alert">{{ number_format(@$item->PAYAMT, 2) }}</td>
														<td class="text-end ch-alert">{{ number_format(@$item->DISCT, 2) }}</td>
														<td class="text-end ch-alert">{{ number_format(@$item->NETPAY, 2) }}</td>
														<td class="text-center ch-alert">{{ date('d-m-Y', strtotime(@$item->CHQTranAR->ARDATE)) }}</td>
													</tr>
												</tbody>
											@endforeach
										</table>
									</div>
								</td>
							</tr>
						@endif
					</tbody>
				@endforeach
				<tfoot class="table-warning sticky-bottom text-center" style="line-height: 130%;">
					<tr>
						<th></th>
						@if (@$item_btn == true)
							<th></th>
						@endif
						<th></th>
						<th></th>
						<th>{{ @$contract->ContractCHQMasfee->count('BILLNO') }} รายการ</th>
						<th></th>
						<th></th>
						<th>
							{{ number_format(@$contract->ContractCHQMasfee->where('FLAG', 'H')->sum('CHQAMT'), 2) }}
						</th>
					</tr>
				</tfoot>
			@endisset
		</table>
	</div>
</section>

<script>
	$(document).ready(function() {
		$('.tbody-fee .flag-C').map(function() {
			return $(this).find("td.ch-alert").addClass('text-decoration-line-through text-danger');
		}).get();
	});
</script>
<script>
	$('.btnOther-cancel').click(async function() {
		let Otherpaynt = $(this).hasClass('btn-paynt');
		let OtherAsk = $(this).hasClass('btn-ask');

		let id = $(this).data('id');
		let codloan = $(this).data('codloan');

		if (Otherpaynt == true && OtherAsk == false) {
			let fun = 'update-ask';
			const result = await askOtherPaynts(id, codloan, fun);

			if (result == 'success') {
				$(this).find(".Other-paynt").addClass('d-none');
				$(this).find(".Other-ask").removeClass('d-none');

				Swal.fire({
					icon: 'success',
					text: 'แจ้งยกเลิกใบรับ เรียบร้อย !',
					showConfirmButton: false,
					timer: 1500
				});

				$(this).removeClass('btn-paynt');
				$(this).addClass('btn-ask');
			}else if (result == 'Cancel') {
				$(this).removeClass('btn-paynt');
			}else {
				Swal.fire({
					icon: 'error',
					title: 'ล้มเหลว !',
					text: 'กรุณาตวจสอบความถูกต้องอีกครั้ง !',
					showConfirmButton: false,
					timer: 1500
				});

				$(this).removeClass('btn-paynt');
			}
		} else {
			let fun = 'cancel-ask';
			const result = await CancelOtherAsk(id, codloan, fun);

			if (result == 'success') {
				$(this).find(".Other-ask").addClass('d-none');
				$(this).find(".Other-paynt").removeClass('d-none');

				Swal.fire({
					icon: 'success',
					text: 'คืนค่า เรียบร้อย !',
					showConfirmButton: false,
					timer: 1500
				});

				$(this).addClass('btn-paynt');
				$(this).removeClass('btn-ask');
			}else if (result == 'Cancel') {
				$(this).removeClass('btn-ask');
			}else {
				Swal.fire({
					icon: 'error',
					title: 'ล้มเหลว !',
					text: 'กรุณาตวจสอบความถูกต้องอีกครั้ง !',
					showConfirmButton: false,
					timer: 1500
				});

				$(this).removeClass('btn-ask');
			}
		}
	});

	async function askOtherPaynts(id, codloan, fun) {
		return new Promise((resolve, reject) => {
			let link = "{{ route('payments.destroy', 'id') }}";
			let url = link.replace('id', id);
			let _token = $('input[name="_token"]').val();

			Swal.fire({
				icon: 'warning',
				text: 'ต้องการ ขอยกเลิกใบรับ หรือไม่ ?',
				showCancelButton: true,
				confirmButtonText: 'ยืนยัน',
				cancelButtonText: 'ยกเลิก',
				confirmButtonColor: '#4CC552',
				cancelButtonColor: '#E55451',
			}).then(async (result) => {
				if (result.isConfirmed) {
					$(".loading-overlay").attr('style', ''); //** แสดงตัวโหลด **
					try {
						const response = await $.ajax({
							url: url,
							method: "delete",
							data: {
								_token: _token,
								CODLOAN: codloan,
								fun: fun
							}
						});

						if (response.message == 'success') {
							$('.tbody-fee .flagFee_'+id).empty();
							$(".loading-overlay").attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **

							$('<span />', {
								class: "btn btn-warning btn-sm btn-rounded waves-effect waves-light",
								"data-bs-toggle": "popover",
								"data-bs-trigger": "hover",
								"data-bs-placement": "top",
								"data-bs-html": "true",
								"data-bs-sanitize": "false",
								"data-bs-content": '<div class="row px-2">' +
									'<div class="col-5 fw-bold content-info-row">วันขอยกเลิก:</div>' +
									'<div class="col-7 text-end content-info-row">' + response.datetime + '</div>' +
									'<div class="col-5 fw-bold content-info-row">ผู้ขอยกเลิก:</div>' +
									'<div class="col-7 text-end content-info-row">' + response.user + '</div>' +
									'</div>',
								text: "ขอยกเลิก"
							}).appendTo('.tbody-fee .flagFee_'+id).popover();

							resolve(response.message);
						} else {
							$(".loading-overlay").attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
							resolve(response.message);
						}
					} catch (error) {
						$(".loading-overlay").attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
						reject('failed');
					}
				}else {
					resolve('Cancel');
				}
			})
		});
	}

	async function CancelOtherAsk(id, codloan, fun) {
		return new Promise((resolve, reject) => {
			let link = "{{ route('payments.destroy', 'id') }}";
			let url = link.replace('id', id);
			let _token = $('input[name="_token"]').val();

			Swal.fire({
				icon: 'warning',
				text: 'คืนค่า แจ้งขอยกเลิกใบรับ หรือไม่ ?',
				showCancelButton: true,
				confirmButtonText: 'คืนค่า',
				cancelButtonText: 'ยกเลิก',
				confirmButtonColor: '#4CC552',
				cancelButtonColor: '#E55451',
			}).then(async (result) => {
				if (result.isConfirmed) {
					$(".loading-overlay").attr('style', ''); //** แสดงตัวโหลด **
					try {
						const response = await $.ajax({
							url: url,
							method: "delete",
							data: {
								_token: _token,
								CODLOAN: codloan,
								fun: fun
							}
						});

						if (response.message == 'success') {
							$('.tbody-fee .flagFee_'+id).empty();
							$(".loading-overlay").attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **

							$('<span />', {
								class: "btn btn-success btn-sm btn-rounded waves-effect waves-light",
								"data-bs-toggle": "popover",
								"data-bs-trigger": "hover",
								"data-bs-placement": "top",
								"data-bs-html": "true",
								"data-bs-sanitize": "false",
								"data-bs-content": '<div class="row px-2">' +
									'<div class="col-5 fw-bold content-info-row">วันที่บันทึก:</div>' +
									'<div class="col-7 text-end content-info-row">' + response.datetime + '</div>' +
									'<div class="col-5 fw-bold content-info-row">ผู้บันทึก:</div>' +
									'<div class="col-7 text-end content-info-row">' + response.user + '</div>' +
									'</div>',
								text: "ปกติ"
							}).appendTo('.tbody-fee .flagFee_'+id).popover();

							resolve(response.message);
						} else {
							$(".loading-overlay").attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
							resolve(response.message);
						}
					} catch (error) {
						$(".loading-overlay").attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
						reject('failed');
					}
				}else {
					resolve('Cancel');
				}
			})
		});
	}
</script>
