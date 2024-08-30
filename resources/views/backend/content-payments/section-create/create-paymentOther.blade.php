@include('public-js.constants')

<div class="modal-content">
	<div class="d-flex m-3 mb-0">
		<div class="flex-shrink-0 me-2">
			{{-- <img src="{{ asset('assets/images/payment.jpg') }}" alt="" class="avatar-sm"> --}}
			<img src="{{ asset('assets/images/gif/coins.gif') }}" alt="" class="avatar-sm">
		</div>
		<div class="flex-grow-1 overflow-hidden">
			<h5 class="text-primary fw-semibold">บันทึกรับชำระค่าธรรมเนียมอื่นๆ (New Payments Others)</h5>
			<p class="text-muted mt-n1 fw-semibold  font-size-12">เลขที่ใบรับ : {{ @$Billno }}</p>
			<p class="border-primary border-bottom mt-n2"></p>
		</div>
		{{-- <button type="button" class="btn-close btn-disabled" data-bs-dismiss="modal" aria-label="Close"></button> --}}
	</div>

	<div class="modal-body scroll">
		<form id="form_createpayother" class="needs-validation" novalidate>
			<div class="mt-n4">
				<div class="row">
					<div class="col-md-12 col-lg-6 g-2">
						<div class="card">
							<div class="card-body pt-2">
								<div class="row justify-content-start g-2 mb-2">
									<div class="col-4">
										<div class="d-flex text-danger">
											<h5 class="font-size-13 fw-semibold bx-fade-right"><i class="bx bxs-bell font-size-18"></i> ประเภทการชำระเงิน</h5>
										</div>
										<div class="btn-group btn-group-example" role="group">
											<button type="button" class="btn btn-block btn-outline-success w-xs {{ @$TYPEPAY == 'Payment' ? 'active' : '' }}">ชำระค่างวด</button>
											<button type="button" class="btn btn-block btn-outline-success w-xs {{ @$TYPEPAY == 'Payother' ? 'active' : '' }}">ชำระค่าอื่นๆ</button>
										</div>
									</div>
									{{-- <div class="col-8 d-flex align-items-end">
										<div class="input-bx">
											<input type="text" name="search_invoice" id="search_invoice" class="form-control border-info" required placeholder=" " autocomplete="off" />
											<span>เลขเอกสารใบแจ้งหนี้</span>
											<button type="button" class="mx-0 btn btn-soft-info border border-info border-opacity-50 search-invoice" data-bs-toggle="modal" data-bs-target="#modal_xl" data-link="{{ route('payments.show', @$contract->id) }}?FlagBtn={{ 'search-invoice' }}&modalID={{ 'modal_xl_2' }}">
												<i class="bx bx-search-alt font-size-13"></i>
											</button>
										</div>
									</div> --}}
								</div>
								<div class="row g-2 mb-1">
									<div class="col-4">
										<div class="input-bx">
											<input type="text" name="LOCATREC" value="{{ auth()->user()->id }}" class="form-control border-warning" placeholder=" " readonly />
											<span class="text-warning">สาขาที่รับ</span>
											<button type="button" class="mx-0 btn btn-light border border-warning border-opacity-50 font-size-10"><i class="dripicons-menu"></i></button>
										</div>
									</div>
									<div class="col-8">
										<div class="input-bx">
											<input type="text" class="form-control border-warning" value="{{ auth()->user()->UserToBranch->Name_Branch }}" readonly />
										</div>
									</div>
								</div>
								<div class="row g-2 mb-1">
									<div class="col-12">
										<div class="input-bx">
											<input type="text" name="PAYFOR" id="PAYFOR_OTHER" class="form-control" required readonly placeholder=" " />
											<span>รหัสชำระ</span>
										</div>
									</div>
								</div>
								<div class="row g-2 mb-1">
									<div class="col-4">
										<div class="input-bx">
											<input type="text" name="PAYTYP" id="PAYTYP_CODE" class="form-control border-danger PAYTYP_CODE" required placeholder=" " autocomplete="off" />
											<span class="text-danger">ชำระโดย</span>
											<button type="button" class="mx-0 btn btn-light border border-danger border-opacity-50 font-size-10 constant-PAYTYP" data-bs-toggle="modal" data-bs-target="#modal_sd" data-link="{{ route('constants.create') }}?page={{ 'backend' }}&FlagBtn={{ 'PAYTYP' }}&modalID={{ 'modal_xl_2' }}">
												<i class="dripicons-menu"></i>
											</button>
										</div>
									</div>
									<div class="col-8">
										<div class="input-bx">
											<input type="text" id="PAYTYP_NAME" class="form-control border-danger PAYTYP_NAME" readonly />
										</div>
									</div>
								</div>

								<div class="row g-2 mb-1">
									<div class="col-4">
										<div class="row g-2 align-self-center">
											<div class="col-md-12">
												<div class="form-floating">
													<textarea class="form-control" placeholder="Leave a comment here" name="pay_memo" id="pay_memo" maxlength="65535" style="height: 118px"></textarea>
													<label for="pay_memo" class="fw-bold text-muted">หมายเหตุ</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-8">
										<div id="PAYTYP_TRAN" class="">
											<div class="mb-1">
												<div class="input-bx">
													<input type="text" name="CHQDT" id="CHQDT" class="form-control text-center font-size-14" data-date-autoclose="true" data-provide="datepicker" data-date-format="dd-mm-yyyy" data-date-language="th" autocomplete="off" data-date-today-btn="linked" placeholder="วัน-เดือน-ปี" />
													<span>วันที่โอน</span>
												</div>
											</div>
											<div class="row mb-1">
												<div class="col">
													<div class="input-bx">
														<input type="text" id="PAYINACC_NAME" class="form-control PAYINACC_NAME" readonly placeholder=" " />
														<span>บริษัท</span>
														<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 constant-INACC" data-bs-toggle="modal" data-bs-target="#modal_lg_2" data-link="{{ route('constants.create') }}?page={{ 'backend' }}&FlagBtn={{ 'PAYINACC' }}&modalID={{ 'modal_xl_2' }}&comType={{ @$contract->CODLOAN }}&zone={{ @$contract->UserZone }}">
															<i class="dripicons-menu"></i>
														</button>
													</div>
													<input type="hidden" name="PAYINACC" id="PAYINACC_CODE" class="form-control PAYINACC_CODE" title="ธนาคาร" />
												</div>
											</div>
											<div class="row g-2">
												<div class="col">
													<div class="input-bx">
														<input type="text" id="BANKNAME" class="form-control BANKNAME" readonly placeholder=" " />
														<span>ธนาคาร</span>
													</div>
												</div>
												<div class="col">
													<div class="input-bx">
														<input type="text" id="PAYINACC_NUMBER" class="form-control PAYINACC_NUMBER" readonly placeholder=" " />
														<span>เลขบัญชี</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>
					<div class="col-md-12 col-lg-6">
						<div class="card">
							<div class="card-body pt-2">
								<h5 class="card-title border-bottom"><i class="mdi mdi-wallet me-1"></i> ข้อมูลการรับชำระ</h5>
								<div class="text-center">
									<div class="mb-3">
										<img src="{{ asset('assets/images/payment-1.png') }}" alt="" class="avatar-lg">
									</div>
								</div>
								<div class="row mb-1">
									<div class="col-12">
										<div class="input-bx">
											<input type="text" value="{{ date('d-m-Y', strtotime($BILLDT)) }}" class="form-control border-danger text-center font-size-14" id="date_payOther" data-date-autoclose="true" data-provide="datepicker" data-date-format="dd-mm-yyyy" data-date-language="th" autocomplete="off" readonly disabled />
											<input type="date" hidden name="BILLDT" id="BILLDT" value="{{ @$BILLDT }}" class="form-control border-danger text-end" />
											<span class="text-danger">วันที่รับเงิน</span>
											<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-13"><i class="bx bx-calendar-event"></i></button>
										</div>
									</div>
								</div>
								<div class="row mb-1 g-2">
									<div class="col-6">
										<div class="input-bx">
											<input type="text" name="sum_arothr" id="sum_arothr" class="form-control text-end" required placeholder=" " readonly />
											<span>ยอกรวมลูกหนี้อื่น</span>
											<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">บาท</button>
										</div>
									</div>
									<div class="col-6">
										<div class="input-bx">
											<input type="text" name="PAYAMT" id="PAYAMT" class="form-control text-end" required placeholder=" " readonly autocomplete="off" />
											<span>ยอดชำระ</span>
											<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">บาท</button>
										</div>
									</div>
								</div>
								<div class="row mb-1">
									<div class="col-12">
										<div class="input-bx">
											<input type="text" name="DISINT" id="DISINT" class="form-control text-end" placeholder=" " readonly />
											<span>ส่วนลดรวม</span>
											<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">บาท</button>
										</div>
									</div>
								</div>
								<div class="row mb-1">
									<div class="col-12">
										<div class="input-bx">
											<input type="text" name="sumPay" id="sumPay" class="form-control text-end border-danger" readonly />
											<span class="text-danger">ยอดรับสุทธิ</span>
											<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">บาท</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="d-flex align-items-center mt-n3">
					<h5 class="mb-0 card-title flex-grow-1 text-muted"><i class="mdi mdi-wallet me-1"></i> รายการลูกหนี้อื่น</h5>
					<div class="flex-shrink-0 me-3">
						<div class="input-bx">
							<button type="button" id="btn-payother" data-clicked="false" class="btn btn-success waves-effect waves-light">
								<i class="text-btn-payother">ยืนยันรายการ </i> <i class="bx bx-chevron-down rotate"></i>
							</button>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						@include('backend.content-payments.section-view.view-payother')
					</div>
				</div>

				<div class="row p-3 mt-n2" id="table-payother" style="display: none;">
					<div class="col-12">
						<table class="table align-middle table-nowrap table-check">
							<thead class="table-light">
								<tr>
									<th style="width: 20px;" class="align-middle">#</th>
									<th class="align-middle text-center">วันตั้งหนี้</th>
									<th class="align-middle text-center">รหัสชำระ</th>
									<th class="align-middle text-center">รายการ</th>
									<th class="align-middle">ยอดลูกหนี้</th>
									<th class="align-middle">ส่วนลด</th>
								</tr>
							</thead>
							<tbody id="body-payother">
								{{-- content --}}
							</tbody>
						</table>
					</div>
				</div>

				{{-- ser value --}}
				<input type="text" hidden name="TYPEPAY" id="TYPEPAY" value="{{ @$TYPEPAY }}" placeholder="ประเภทชำระ">
				<input type="text" hidden id="dic_officer" value="500" placeholder="ส่วนลดเจ้าหน้าที">
				<input type="text" hidden id="sum_dicint" placeholder="รวมส่วนลด">
				<input type="text" hidden id="isActiveTable" value="false">
			</div>
		</form>
	</div>
	<div class="modal-footer float-end">
		<a target="_blank" id="btn_printpayother" class="btn btn-info btn-sm w-md hover-up d-none" data-mas_id="" onclick="rpPayments({{ $contract->CODLOAN }})">
			<i class="mdi mdi-printer-check"></i> พิมพ์ใบเสร็จ
		</a>
		<button type="button" id="btn_payother" data-id="{{ $contract->id }}" data-codloan="{{ $contract->CODLOAN }}" class="btn btn-success btn-sm w-md hover-up btn-disabled" disabled>
			<span class="addSpin"><i class="fas fa-download"></i></span> บันทึก
		</button>
		<button type="button" id="btn_payotherClose" class="btn btn-secondary btn-sm w-md waves-effect hover-up btn-disabled" data-bs-dismiss="modal">
			<i class="mdi mdi-close-circle-outline"></i> ปิด
		</button>
	</div>
</div>

<script>
	// สร้างตารางของ PAYFOR อื่นๆ
	function buildingTables() {
		$("#body-payother").empty();
		let selectedRows = $('.tbody-pay input[type="checkbox"]:checked').closest('tr');
		// ตัด <td> ที่มี class .edit ออก
		// selectedRows.find('.btn-edit').remove();

		// ดึง HTML สำหรับแต่ละ <tr> และใช้ .get() เพื่อแปลงให้เป็น Array
		let htmlArray = selectedRows.map(function() {
			return $(this).prop('outerHTML');
		}).get();

		// รวม HTML ใน Array เป็นสตริงเดียว
		let htmlToAppend = htmlArray.join('');

		// เพิ่ม HTML ลงใน #body-payother
		$("#body-payother").append(htmlToAppend);
		$('#body-payother .btn-edit').remove();
		// เพิ่ม checked และ disabled ให้กับ checkbox ของ #body-payother
		$("#body-payother input[type='checkbox']").prop({
			'checked': true,
			'disabled': true
		});

		// ตรวจสอบว่ามีการเลือก PAYFOR อื่นๆ หรือไม่
		checklisterOuters();
	}

	// คำนวณผลรวมของ PAYAMT และนำไปแสดงใน #totalAmount
	function checklisterOuters() {
		var bodyPayother = $('#body-payother');
		var inputValue = $('#PAYAMT').val() == '' ? 0 : $('#PAYAMT').val().replace(/,/g, '');

		if (bodyPayother.children().length == 0) {
			$('#PAYFOR_OTHER').val('');
			$('#sum_arothr').val(0.00);
			$('#DISINT').val(0.00);
			$('#sumPay').val(0.00);
		} else {
			var dataRows = bodyPayother.find('tr');
			var arrData = dataRows.map(function() {
				var payfor = $(this).find('.PAYFOR').text().trim();
				var payamt = parseFloat($(this).find('.PAYAMT').text().trim().replace(',', '')) || 0;
				var dicint = parseFloat($(this).find('.dicint').text().trim().replace(',', '')) || 0;

				return {
					payfor: payfor,
					payamt: payamt,
					dicint: dicint
				};
			}).get();

			// นำ arrData มาทำการ unique และกำหนดค่าลงใน #PAYFOR_OTHER
			var uniquePayfor = $.unique(arrData.map(item => item.payfor));
			$('#PAYFOR_OTHER').val(uniquePayfor);

			// คำนวณผลรวมของ PAYAMT และนำไปแสดงใน #totalAmount
			var totalAmount = arrData.reduce((acc, item) => acc + item.payamt, 0);
			$('#sum_arothr').val(addCommas(totalAmount.toFixed(2)));

			// คำนวณผลรวมของ dicint และนำไปแสดงใน #totalDicint
			var totalDicint = arrData.reduce((acc, item) => acc + item.dicint, 0);
			$('#DISINT').val(totalDicint.toFixed(2));

			$('#sumPay').val(addCommas((parseFloat(inputValue) + parseFloat(totalDicint)).toFixed(2)));
		}
	}

	// สร้าง Promise สำหรับ buildingTables()
	function buildingTablesPromise() {
		return new Promise(function(resolve) {
			buildingTables();
			resolve();
		});
	}

	$('#btn-payother').on('click', async function() {
		let price = $('#PAYAMT').val();
		let sumArothr = $('#sum_arothr').val();
		let isActiveTable = $('#isActiveTable').val();

		if (isActiveTable == 'true') {
			Swal.fire({
				icon: 'error',
				title: 'ไม่สามารถเพิ่มข้อมูลได้',
				text: 'กรุณาทำการแก้ไขส่วนลดให้เรียบร้อย ก่อนทำการเพิ่มข้อมูล',
				showConfirmButton: true,
				timer: 2000
			});

			return false;
		}

		if ($(this).data('clicked')) {
			$('#table-payother').slideUp(500);
			$('#card-payother').slideDown(500);

			$(this).data('clicked', false).removeClass('btn-info').addClass('btn-success');
			$(this).find('.text-btn-payother').text('ยันยันรายการ');

			$('#btn_payother').prop('disabled', true);
		} else {
			let checkPayother = $('.tbody-pay .form-check-input:checked').length;
			let body_payother = $('#body-payother .form-check-input:checked').length;

			// check list payment other
			if (checkPayother != body_payother) {
				$('#PAYAMT').val('');
			}

			if (checkPayother == 0) {
				$('#PAYAMT').val('').prop('readonly', true);
				$('#btn_payother').prop('disabled', true);

			} else {
				$('#PAYAMT').prop('readonly', false);
				$('#btn_payother').prop('disabled', false);
			}
			await buildingTablesPromise();

			$(this).data('clicked', true).removeClass('btn-success').addClass('btn-info');
			$(this).find('.text-btn-payother').text('เลือกรายการ');

			$('#card-payother').slideUp(500);
			$('#table-payother').slideDown(500);
		}

		$(".rotate").toggleClass("down");
	});
</script>

<script>
	$(document).ready(function() {
		$('.PAYTYP_CODE').on('keypress', function(e) {
			if (e.keyCode === 13 || e.which === 13) {
				$(".PAYFOR_CODE").focus();

			}
		});
		$('#PAYAMT').on('input', function() {
			let sum_arothr = Number($('#sum_arothr').val().replace(/,/g, ''));
			let inputValue = Number($(this).val().replace(/,/g, ''));
			let DISINT = Number($('#DISINT').val().replace(/,/g, ''));

			if ((inputValue + DISINT) > sum_arothr) {
				Swal.fire({
					icon: 'error',
					title: 'แจ้งเตือน !',
					text: 'ยอดชำระเงินไม่ถูกต้อง กรุณากรอกยอดชำระใหม่อีกครั้ง !',
					showConfirmButton: true,
					timer: 2000
				});

				$(this).val('');
				$('#sumPay').val(addCommas((parseFloat(DISINT)).toFixed(2)));
				return
			} else {

				$(this).val(addCommas(inputValue));
				$('#sumPay').val(addCommas((parseFloat(inputValue) + parseFloat(DISINT)).toFixed(2)));
			}
		});

		// $('#btn_payother').click(function() {
		// 	let dataform = document.querySelectorAll('#form_createpayother');
		// 	let validate = validateForms(dataform);
		// 	let sum_arothr = Number($('#sum_arothr').val().replace(/,/g, ''));
		// 	let PAYAMT = Number($('#PAYAMT').val().replace(/,/g, ''));
		// 	let sumPay = Number($('#sumPay').val().replace(/,/g, ''));

		// 	if (sum_arothr == 0) {
		// 		showAlert('error', 'แจ้งเตือน !', 'กรุณาเลือกรายการลูกหนี้อื่นๆ ก่อนรับชำระ !');
		// 		return;
		// 	}

		// 	if (sum_arothr > sumPay) {
		// 		showAlert('error', 'แจ้งเตือน !', 'ยอดชำระเงินไม่ถูกต้อง กรุณากรอกยอดชำระใหม่อีกครั้ง !');
		// 		return;
		// 	}

		// 	if (PAYAMT == 0 || PAYAMT == '') {
		// 		showAlert('error', 'แจ้งเตือน !', 'กรุณากรอกยอดชำระเงิน ก่อนรับชำระ !');
		// 		return;
		// 	}

		// 	if (validate == true) {
		// 		$('.btn-disabled').prop('disabled', true);
		// 		$('.addSpin').html('<span class="spinner-border spinner-border-sm" role="status"></span>');

		// 		let CODLOAN = $(this).data('codloan');
		// 		let id = $(this).data('id');
		// 		let type = $('#TYPEPAY').val();
		// 		let page = 'payments';
		// 		let _token = $('input[name="_token"]').val();
		// 		let data = {};
		// 		let arrPay = {};

		// 		dataform.map(function(x) {
		// 			data[x.name] = x.value;
		// 		});

		// 		$('#body-payother input[name="item_payother"]:checked').each(function() {
		// 			let payfor = $(this).data('payfor');
		// 			let idpay = $(this).attr('id');
		// 			let payamt = $(this).data('payamt');
		// 			let dicint = $(this).closest('tr').find('.dicint').text();

		// 			arrPay[payfor] = arrPay[payfor] || [];
		// 			arrPay[payfor].push({
		// 				id: idpay,
		// 				payamt: payamt,
		// 				dicint: dicint
		// 			});
		// 		});

		// 		$.ajax({
		// 			url: "{{ route('payments.store') }}",
		// 			method: "post",
		// 			data: {
		// 				_token: _token,
		// 				id: id,
		// 				page: page,
		// 				CODLOAN: CODLOAN,
		// 				data: data,
		// 				arrPay: arrPay,
		// 				type: type
		// 			},
		// 			success: async function(result) {
		// 				$('.view-tb-duepay').html(result.html);
		// 				$('.view-contract').html(result.viewCon);
		// 				$('#priceCus').val(result.priceCus);
		// 				$('.btGroup-pay').val('');
		// 				$('.btn-stantlog').val('');
		// 				$('.btGroup-showPay').empty().append('0.00');
		// 				$('#DateSer').val(result.DateSer);
		// 				$('#btn-Payments').prop("disabled", true);
		// 				$('.btGroup-pay').prop("disabled", true);
		// 				$('.btn-typePay').prop('checked', false);
		// 				$('.btn-disabled').prop('disabled', false);
		// 				$('#btn_printpayother').attr('data-mas_id', result.CHQMas_id).removeClass('d-none');
		// 				$('#btn_payother, #btn_payotherClose').addClass('d-none');

		// 				showAlert('success', '', result.message);
		// 			},
		// 			error: function(err) {
		// 				$('.btn-disabled').prop('disabled', false);
		// 				$('.addSpin').empty();
		// 				showAlert('error', 'ERROR ' + err.status + ' !!!', err.responseJSON.message);
		// 			}
		// 		});
		// 	}
		// });

		$('#btn_payother').click(function() {
			let dataform = document.querySelectorAll('#form_createpayother');
			let validate = validateForms(dataform);
			let sum_arothr = Number($('#sum_arothr').val().replace(/,/g, ''));
			let PAYAMT = Number($('#PAYAMT').val().replace(/,/g, ''));
			let sumPay = Number($('#sumPay').val().replace(/,/g, ''));

			if (sum_arothr == 0) {
				showAlert('error', 'แจ้งเตือน !', 'กรุณาเลือกรายการลูกหนี้อื่นๆ ก่อนรับชำระ !');
				return;
			}
			if (sum_arothr > sumPay) {
				showAlert('error', 'แจ้งเตือน !', 'ยอดชำระเงินไม่ถูกต้อง กรุณากรอกยอดชำระใหม่อีกครั้ง !');
				return;
			}
			if (PAYAMT == 0 || PAYAMT == '') {
				showAlert('error', 'แจ้งเตือน !', 'กรุณากรอกยอดชำระเงิน ก่อนรับชำระ !');
				return;
			}

			if (validate) {
				$('.btn-disabled').prop('disabled', true);

				$('.addSpin').empty();
				$('<span />', {
					class: "spinner-border spinner-border-sm",
					role: "status"
				}).appendTo(".addSpin");

				let CODLOAN = $(this).data('codloan');
				let id = $(this).data('id');
				let type = $('#TYPEPAY').val();

				let page = 'payments';
				let _token = $('input[name="_token"]').val();

				let data = {};
				let arrPay = {};
				$("#form_createpayother").serializeArray().map(function(x) {
					data[x.name] = x.value;
				});

				$('#body-payother input[name="item_payother"]:checked').map(function() {
					var payfor = $(this).data('payfor');
					var idpay = $(this).attr('id');
					var payamt = $(this).data('payamt');
					var dicint = $(this).closest('tr').find('.dicint').text(); // ใช้ $(this) เพื่ออ้างอิงถึง Element ปัจจุบัน

					if (arrPay[payfor] == null)
						arrPay[payfor] = []
					arrPay[payfor].push({
						id: idpay,
						payamt: payamt,
						dicint: dicint.replace(/,/g, '') // เพิ่มค่า dicint เข้าไปใน arrPay
					});
				}).get();

				$.ajax({
					url: "{{ route('payments.store') }}",
					method: "post",
					data: {
						_token: _token,
						id: id,
						page: page,
						CODLOAN: CODLOAN,
						data: data,
						arrPay: arrPay,
						type: type
					},

					success: async function(result) {
						$('.view-tb-duepay').html(result.html);
						$('.view-contract').html(result.viewCon);
						$('#priceCus').val(result.priceCus);

						// reset show
						$('.btGroup-pay').val('');
						$('.btn-stantlog').val('');
						$('.btGroup-showPay').empty();
						$('.btGroup-showPay').append('0.00');
						$('#DateSer').val(result.DateSer);

						// reset btn
						$('#btn-Payments').prop("disabled", true);
						$('.btGroup-pay').prop("disabled", true);
						$('.btn-typePay').prop('checked', false);

						$('.btn-disabled').prop('disabled', false);

						// show btn prints
						// await build_btnPayments(result.CHQMas_id,CODLOAN);
						$('#btn_printpayother').attr('data-mas_id', result.CHQMas_id)
						$('#btn_printpayother').removeClass('d-none');

						$('#btn_payother').addClass('d-none')
						$('#btn_payotherClose').addClass('d-none')

						Swal.fire({
							icon: 'success',
							text: result.message,
							showConfirmButton: false,
							timer: 1500
						});
					},
					error: function(err) {
						$('.btn-disabled').prop('disabled', false);
						$('.addSpin').empty();

						Swal.fire({
							icon: 'error',
							title: ERROR + err.status + ` !!!`,
							text: err.responseJSON.message,
							showConfirmButton: true,
						});
					}
				})
			}
		});

		$('#btn_printpayother').click(function() {
			$('#modal_xl_2').modal('hide');
		});
	});

	function showAlert(icon, title, text) {
		Swal.fire({
			icon: icon,
			title: title,
			text: text,
			showConfirmButton: icon === 'error' ? true : false,
			timer: icon === 'error' ? 2000 : 1500,
		});
	}

	// report payments
	function build_btnPayments(mas_id, contcodloan) {
		let url = `{{ route('report-backend.show', ':id') }}?codloan=${contcodloan}&page=rp-paydue`;
		url = url.replace(':id', mas_id);

		$('#btn_printpayother').attr('href', url);
		let flag_pt = "{{ session()->put('flag_pt', 'active') }}";
	}

	function rpPayments(codloan) {
		let id = $('#btn_printpayother').attr('data-mas_id');
		let url = `{{ route('report-backend.show', 'id') }}?codloan=${codloan}&page=rp-paydue`;
		url = url.replace('id', id);

		let newWindow = window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400,name=ใบเสร็จรับเงิน");
		let flag_pt = "{{ session()->put('flag_pt', 'active') }}";

		if (newWindow) {
			let browserWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
			let browserHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

			window.blur(); // ล่วงหน้าต่างของเบราว์เซอร์

			newWindow.focus(); // กลับมาโฟกัสที่หน้าต่าง Modal
			newWindow.resizeTo(browserWidth, browserHeight);
		}
	}
</script>
