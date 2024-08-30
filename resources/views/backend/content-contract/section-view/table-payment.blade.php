<section>
	@if (@$at_heading == true)
		<div class="d-flex m-3 mb-0">
			<div class="flex-shrink-0 me-2">
				<img src="{{ asset('assets/images/gif/book.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
			</div>
			<div class="flex-grow-1 overflow-hidden">
				<h5 class="text-primary fw-semibold">ตารางรับชำระ</h5>
				<p class="text-muted mt-n1 fw-semibold font-size-12">( View Payments List )</p>
				<p class="border-primary border-bottom mt-n2"></p>
			</div>
		</div>
	@endif
	{{-- <div style="cursor: pointer; overflow: auto;  height: 415px;"  class="table-responsive scroll"> --}}
	<div class="table-responsive font-size-11" data-simplebar="init" style="{{ @$tb_height }};  min-height : 415px;">
		<table id="table-installment-schedule" class="table align-middle table-striped table-bordered text-nowrap table-hover font-size-10 table-installment-schedule table-payment " cellspacing="0" width="100%">
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
					<th>ชำระโดย</th>
					<th>ชำระค่างวด</th>
					@if ($contract->CODLOAN == 1)
						<th>ชำระดอกเบี้ย</th>
						<th>ชำระเงินต้น</th>
					@endif
					<th>ส่วนลด</th>
					<th>ชำระค่าปรับ</th>
					<th>ลดค่าปรับ</th>
					<th>ค่าทวงถาม</th>
					<th>ลดทวงถาม</th>
					<th>ชำระสุทธิ</th>
					<th>วันที่เช็ค</th>
					<th>ผู้ลงบันทึก</th>
				</tr>
			</thead>

			@isset($contract->ContractTranpay)
				@php
					@$btn_askN = @$contract->ContractTranpay
					    ->filter(function ($e) {
					        return $e->ASK_FLAG == 'N';
					    })
					    ->first();

					if ($btn_askN == null) {
					    @$btn_flag = @$contract->ContractTranpay
					        ->filter(function ($e) {
					            return $e->FLAG == 'H' and empty($e->ASK_FLAG);
					        })
					        ->last();

					    $btn_Cnpay = true;
					} else {
					    $btn_Cnpay = false;
					}
				@endphp

				<tbody class="tbody-payment">
					@foreach (@$contract->ContractTranpay as $key => $value)
						<tr class="flag-{{ $value->FLAG }} {{ ($btn_Cnpay == true and @$btn_flag->id == $value->id) ? 'showCnpay btn-flag' : '' }} {{ (!empty($btn_askN) and @$btn_askN->id == $value->id) ? 'showCnAsk btn-flag' : '' }}">
							@if (@$item_btn == true)
								<td class="text-center btn-class">
									<div class="d-flex justify-content-center gap-2">
										<a role="button" class="text-success hover-up show-paymentDetail" data-bs-toggle="modal" data-bs-target="#modal_xl_2" data-link="{{ route('payments.show', $value->id) }}?FlagBtn={{ 'payment-Details' }}&CODLOAN={{ @$contract->CODLOAN }}">
											<i class="mdi mdi-eye font-size-16"></i>
										</a>
										<div class="btn-group" data-bs-toggle="tooltip" title="พิมพ์ใบเสร็จ">
											<a role="button" class="hover-up dropdown-toggle font-size-16" data-bs-toggle="dropdown" aria-expanded="false">
												<i class="mdi mdi-printer-check text-info"></i></i>
											</a>
											<div class="dropdown-menu" style="">
												<a role="button" class="dropdown-item d-flex justify-content-start" onclick="Reprint_Payments({{ $value->ChqMas_id }}, {{ $contract->CODLOAN }}, true, 'A4')">
													<i class="bx bx-news text-info fs-5"></i><span class="ms-2 font-size-12"> ฟอร์มใบเสร็จ (A4)</span>
												</a>
												<div class="dropdown-divider"></div>
												<a role="button" class="dropdown-item d-flex justify-content-start" onclick="Reprint_Payments({{ $value->ChqMas_id }}, {{ $contract->CODLOAN }}, true, 'A5')">
													<i class="bx bx-news text-info fs-5"></i><span class="ms-2 font-size-12"> ฟอร์มใบเสร็จ (A5)</span>
												</a>
											</div>
										</div>
										<div class="btn-cancel {{ ($btn_Cnpay == true and @$btn_flag->id == $value->id) ? 'btn-paynt' : '' }} {{ (!empty($btn_askN) and @$btn_askN->id == $value->id) ? 'btn-ask' : '' }}" data-id="{{ $value->ChqMas_id }}" data-codloan="{{ $value->CHQTranContract->CODLOAN }}">
											<a role="button" class="text-danger hover-up btn-cancelPay {{ ($btn_Cnpay == true and @$btn_flag->id == $value->id) ? 'ask-paynt' : 'disabled d-none' }} {{ ($value->FLAG == 'H' and empty($value->ASK_FLAG)) ? '' : 'd-none' }}" data-bs-toggle="tooltip" title="แจ้งยกเลิกใบเสร็จ">
												<i class="mdi mdi-clipboard-text-off-outline font-size-16"></i>
											</a>
											<a role="button" class="text-secondary hover-up btn-cancelAsk {{ $value->ASK_FLAG == 'N' ? '' : 'd-none' }}" data-bs-toggle="tooltip" title="คืนค่า">
												<i class="mdi mdi-replay font-size-16"></i>
											</a>
										</div>
									</div>
								</td>
							@endif
							<td class="text-center">
								<div class="d-flex justify-content-center flag-pay">
									@if ($value->ASK_FLAG == 'N')
										<span class="btn btn-warning btn-sm btn-rounded waves-effect waves-light" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-html="true" data-bs-sanitize="false" data-bs-content='<div class="row px-2">
												<div class="col-5 fw-bold content-info-row">วันขอยกเลิก:</div>
												<div class="col-7 text-end content-info-row">{{ date('Y-m-d H:i:s', strtotime($value->ASK_DT)) }}</div>
												<div class="col-5 fw-bold content-info-row">ผู้ขอยกเลิก:</div>
												<div class="col-7 text-end content-info-row">{{ @$value->CHTranASKID->name }}</div>
											</div>'>
											ขอยกเลิก
										</span>
									@elseif ($value->FLAG == 'H')
										<span class="btn btn-success btn-sm btn-rounded waves-effect waves-light" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-html="true" data-bs-sanitize="false" data-bs-content='<div class="row px-2">
												<div class="col-5 fw-bold content-info-row">วันที่บันทึก:</div>
												<div class="col-7 text-end content-info-row">{{ date('Y-m-d H:i:s', strtotime($value->created_at)) }}</div>
												<div class="col-5 fw-bold content-info-row">ผู้บันทึก:</div>
												<div class="col-7 text-end content-info-row">{{ @$value->CHQTrantoUser->name }}</div>
											</div>'>
											ปกติ
										</span>
									@elseif($value->FLAG == 'C')
										<span class="btn btn-danger btn-sm btn-rounded waves-effect waves-light" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-placement="top" data-bs-html="true" data-bs-sanitize="false" data-bs-content='<div class="row px-2">
												<div class="col-5 fw-bold content-info-row">วันยกเลิก:</div>
												<div class="col-7 text-end content-info-row">{{ date('Y-m-d H:i:s', strtotime($value->CANDT)) }}</div>
												<div class="col-5 fw-bold content-info-row">ผู้ยกเลิก:</div>
												<div class="col-7 text-end content-info-row">{{ @$value->CHTranCANID->name }}</div>
											</div>'>
											ยกเลิก
										</span>
									@endif
								</div>
							</td>
							<td class="text-center ch-alert">{{ @$value->TranToLOCATREC->NickName_Branch }}</td>
							<td class="text-center ch-alert">{{ $value->TMBILL }}</td>
							<td class="text-center ch-alert">{{ date('d-m-Y', strtotime($value->TMBILDT)) }}</td>
							<td class="text-center ch-alert">{{ $value->PAYFOR }}</td>
							<td class="text-center ch-alert">{{ $value->PAYTYP }}</td>
							<td class="text-end ch-alert">{{ number_format($value->PAYAMT, 2) }}</td>
							@if ($contract->CODLOAN == 1)
								<td class="text-end ch-alert">{{ number_format($value->PAYAMT_V, 2) }}</td>
								<td class="text-end ch-alert">{{ number_format($value->PAYAMT_N, 2) }}</td>
							@endif
							<td class="text-end ch-alert">{{ number_format($value->DISCT, 2) }}</td>
							<td class="text-end ch-alert">{{ number_format($value->PAYINT, 2) }}</td>
							<td class="text-end ch-alert">{{ number_format($value->DSCINT, 2) }}</td>
							<td class="text-end ch-alert">{{ number_format($value->PAYFL, 2) }}</td>
							<td class="text-end ch-alert">{{ number_format($value->DSCPAYFL, 2) }}</td>
							<td class="text-end ch-alert">{{ number_format($value->NETPAY, 2) }}</td>
							<td class="text-center ch-alert">{{ @$value->CHQTranCHQMas->CHQDT != null ? date('d-m-Y', strtotime($value->CHQTranCHQMas->CHQDT)) : '' }}</td>
							<td class="text-center ch-alert">{{ @$value->CHQTrantoUser->name }}</td>

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
						<th>{{ @$contract->ContractTranpay->count('BILLNO') }} รายการ</th>
						<th></th>
						<th></th>
						<th></th>
						<th>
							{{ number_format(@$contract->ContractTranpay->where('FLAG', 'H')->sum('PAYAMT'), 2) }}
						</th>
						@if ($contract->CODLOAN == 1)
							<th>
								{{ number_format(@$contract->ContractTranpay->where('FLAG', 'H')->sum('PAYAMT_V'), 2) }}
							</th>
							<th>
								{{ number_format(@$contract->ContractTranpay->where('FLAG', 'H')->sum('PAYAMT_N'), 2) }}
							</th>
						@endif
						<th>
							{{ number_format(@$contract->ContractTranpay->where('FLAG', 'H')->sum('DISCT'), 2) }}
						</th>
						<th>
							{{ number_format(@$contract->ContractTranpay->where('FLAG', 'H')->sum('PAYINT'), 2) }}
						</th>
						<th>
							{{ number_format(@$contract->ContractTranpay->where('FLAG', 'H')->sum('DSCINT'), 2) }}
						</th>
						<th>
							{{ number_format(@$contract->ContractTranpay->where('FLAG', 'H')->sum('PAYFL'), 2) }}
						</th>
						<th>
							{{ number_format(@$contract->ContractTranpay->where('FLAG', 'H')->sum('DSCPAYFL'), 2) }}
						</th>
						<th>
							{{ number_format(@$contract->ContractTranpay->where('FLAG', 'H')->sum('NETPAY'), 2) }}
						</th>
						<th></th>
						<th></th>

					</tr>
				</tfoot>
			@endisset
		</table>
		{{-- </div> --}}
		{{-- <div class="d-flex justify-content-center py-2">
			<i class="bx bxs-left-arrow-circle font-size-18 bx-fade-left"></i>
			<p>
				สกอร์เมาส์ขึ้นลงเพื่อเลื่อนซ้ายขวา
			</p>
			<i class="bx bxs-right-arrow-circle font-size-18 bx-fade-right"></i>
		</div> --}}
	</div>

</section>

<script>
	$(document).ready(function() {
		$('.tbody-payment .flag-C').map(function() {
			return $(this).find("td.ch-alert").addClass('text-decoration-line-through text-danger');
		}).get();
	});

	$('.show-paymentDetail').click(function(e) {
		e.preventDefault();
		var url = $(this).attr('data-link');

		$('#modal_xl_2 .modal-dialog').empty();
		$('#modal_xl_2 .modal-dialog').load(url);
	});
</script>

<script>
	$('.btn-cancel').click(async function() {
		let askpaynt = $(this).hasClass('btn-paynt');
		let cancelAsk = $(this).hasClass('btn-ask');

		let id = $(this).data('id');
		let codloan = $(this).data('codloan');
		if (askpaynt == true && cancelAsk == false) {
			if ($(this).find(".btn-cancelPay.ask-paynt").length != 0) {
				let fun = 'update-ask';
				const result = await askPaynts(id, codloan, fun);

				if (result == 'success') {
					$(this).find(".btn-cancelPay.ask-paynt").addClass('d-none');
					$(this).find(".btn-cancelAsk").removeClass('d-none');

					Swal.fire({
						icon: 'success',
						title: 'แจ้งยกเลิกใบรับ เรียบร้อย !',
						text: 'กรุณารอการอนุมัติ จากผู้ที่มีสิทธิ์ !',
						showConfirmButton: false,
						timer: 1500
					});

					$(this).removeClass('btn-paynt');
					$(this).addClass('btn-ask');
				} else if (result == 'Cancel') {
					$(this).removeClass('btn-paynt');
				} else {
					Swal.fire({
						icon: 'error',
						title: 'ล้มเหลว !',
						text: 'กรุณาตวจสอบความถูกต้องอีกครั้ง !',
						showConfirmButton: false,
						timer: 1500
					});

					$(this).removeClass('btn-paynt');
				}
			}
		} else {
			if ($(this).find(".btn-cancelAsk").length != 0) {
				let fun = 'cancel-ask';
				const result = await CancelAsk(id, codloan, fun);

				if (result == 'success') {
					$(this).find(".btn-cancelAsk").addClass('d-none');
					$(this).find(".btn-cancelPay").removeClass('d-none disabled');

					Swal.fire({
						icon: 'success',
						text: 'คืนค่า เรียบร้อย !',
						showConfirmButton: false,
						timer: 1500
					});

					$(this).addClass('btn-paynt');
					$(this).removeClass('btn-ask');

				} else if (result == 'Cancel') {
					$(this).removeClass('btn-ask');
				} else {
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
		}
	});

	async function askPaynts(id, codloan, fun) {
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
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
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
							$('.showCnpay .flag-pay').empty();
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
							}).appendTo(".showCnpay .flag-pay").popover();

							resolve(response.message);
						} else {
							$(".loading-overlay").attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
							resolve(response.message);
						}
					} catch (error) {
						$(".loading-overlay").attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
						reject('failed');
					}
				} else {
					resolve('Cancel');
				}
			})
		});
	}

	async function CancelAsk(id, codloan, fun) {
		return new Promise((resolve, reject) => {
			let link = "{{ route('payments.destroy', 'id') }}";
			let url = link.replace('id', id);
			let _token = $('input[name="_token"]').val();

			Swal.fire({
				icon: 'warning',
				title: 'คืนค่าขอยกเลิกใบรับ',
				text: 'คุณต้องการคืนค่า แจ้งขอยกเลิกใบรับ หรือไม่ ?',
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
							$('.btn-flag .flag-pay').empty();
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
							}).appendTo(".btn-flag .flag-pay").popover();

							resolve(response.message);
						} else {
							$(".loading-overlay").attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
							resolve(response.message);
						}
					} catch (error) {
						$(".loading-overlay").attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
						reject('failed');
					}
				} else {
					resolve('Cancel');
				}
			})
		});
	}

	$('.cancel-paynt').click(function() {
		let id = $(this).data('id');
		let fun = 'update-pay';

		let link = "{{ route('payments.destroy', 'id') }}";
		let url = link.replace('id', id);
		let _token = $('input[name="_token"]').val();

		$.ajax({
			url: url,
			method: "delete",
			data: {
				_token: _token,
				fun: fun
			},

			success: function(result) {
				// if (result.message == 'success') {

				// 	Swal.fire({
				// 		icon: 'success',
				// 		text: 'ชำระค่างวด เรียบร้อย !',
				// 		showConfirmButton: false,
				// 		timer: 1500
				// 	});
				// } else {

				// }
			}
		})
	});

	// function rpPayments(codloan, typeRp) {
	// 	let id = $('.print_payments').attr('data-mas_id');
	// 	let url = `{{ route('report-backend.show', 'id') }}?codloan=${codloan}&page=rp-paydue&typeRp=${typeRp}`;
	// 	url = url.replace('id', id);

	// 	let newWindow = window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400,name=ใบเสร็จรับเงิน");
	// 	let flag_pt = "{{ session()->put('flag_pt', 'active') }}";

	// 	if (newWindow) {
	// 		let browserWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
	// 		let browserHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

	// 		window.blur(); // ล่วงหน้าต่างของเบราว์เซอร์

	// 		newWindow.focus(); // กลับมาโฟกัสที่หน้าต่าง Modal
	// 		newWindow.resizeTo(browserWidth, browserHeight);
	// 	}
	// }

	function Reprint_Payments(id, codloan, flag_pt, typeRp) {
		let url = `{{ route('report-backend.show', 'id') }}?codloan=${codloan}&page=rp-paydue&flag_pt=${flag_pt}&page=rp-paydue&typeRp=${typeRp}`;
		url = url.replace('id', id);

		console.log(id, codloan, flag_pt, typeRp);

		let newWindow = window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400,name=ใบเสร็จรับเงิน");

		if (newWindow) {
			let browserWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
			let browserHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

			window.blur(); // ล่วงหน้าต่างของเบราว์เซอร์

			newWindow.focus(); // กลับมาโฟกัสที่หน้าต่าง Modal
			newWindow.resizeTo(browserWidth, browserHeight);
		}
	}
</script>

{{-- mouse scroll-slide --}}
{{-- <script>
    document.querySelector('.scroll').addEventListener('wheel', (e) => {
        e.preventDefault();
        const delta = e.deltaY || e.detail || e.wheelDelta;
        document.querySelector('.scroll').scrollLeft += delta;
    });
</script> --}}
