@include('public-js.constants')

<div class="modal-content">
	<div class="d-flex m-3 mb-0">
		<div class="flex-shrink-0 me-2">
			{{-- <img src="{{ asset('assets/images/payment.jpg') }}" alt="" class="avatar-sm"> --}}
			<img src="{{ asset('assets/images/gif/coins.gif') }}" alt="" class="avatar-sm">
		</div>
		<div class="flex-grow-1 overflow-hidden">
			<h5 class="text-primary fw-semibold">บันทึกรับชำระเงิน (New Payments)</h5>
			<p class="text-muted mt-n1 fw-semibold  font-size-12">เลขที่ใบรับ : {{ @$Billno }}</p>
			<p class="border-primary border-bottom mt-n2"></p>
		</div>
		{{-- <button type="button" class="btn-close btn-disabled" data-bs-dismiss="modal" aria-label="Close"></button> --}}
	</div>

	<div class="modal-body scroll">
		<form id="form-create-payments" class="needs-validation" novalidate>
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
											<button type="button" class="btn btn-block btn-outline-success w-xs {{ @$TYPEPAY == 'Payment' || $flag_page == 'payment-Details' ? 'active' : '' }}">ชำระค่างวด</button>
											<button type="button" class="btn btn-block btn-outline-success w-xs {{ @$TYPEPAY == 'Payother' ? 'active' : '' }}">ชำระค่าอื่นๆ</button>
										</div>
									</div>
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
									<div class="col-4">
										<div class="input-bx">
											<input type="text" name="PAYFOR" id="PAYFOR_CODE" value="{{ @$status_PAYFOR }}" class="form-control PAYFOR_CODE" readonly required placeholder=" " />
											<span>รหัสชำระ</span>
											<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 modal-constant disabled" data-bs-toggle="modal" data-bs-target="#modal_sd" data-link="{{ route('constants.create') }}?page={{ 'backend' }}&FlagBtn={{ 'PAYFOR' }}&modalID={{ 'modal_xl_2' }}" disabled>
												<i class="dripicons-menu"></i>
											</button>
										</div>
									</div>
									<div class="col-8">
										<div class="input-bx">
											<input type="text" id="PAYFOR_NAME" value="{{ @$status_PAYFOR == '006' ? 'ชำระค่างวด' : 'รับชำระค่างวดปิดบัญชี' }}" class="form-control PAYFOR_NAME" readonly />
										</div>
									</div>
								</div>
								<div class="row g-2 mb-1">
									<div class="col-4">
										<div class="input-bx">
											<input type="text" name="PAYTYP" id="PAYTYP_CODE" value="{{ @$transaction->PAYTYP }}" class="form-control border-danger PAYTYP_CODE" required placeholder=" " autocomplete="off" />
											<span class="text-danger">ชำระโดย</span>
											<button type="button" class="mx-0 btn btn-light border border-danger border-opacity-50 font-size-10 constant-PAYTYP" data-bs-toggle="modal" data-bs-target="#modal_sd" data-link="{{ route('constants.create') }}?page={{ 'backend' }}&FlagBtn={{ 'PAYTYP' }}&modalID={{ 'modal_xl_2' }}" {{ $flag_page == 'payment-Details' ? 'disabled' : '' }}>
												<i class="dripicons-menu"></i>
											</button>
										</div>
									</div>
									<div class="col-8">
										<div class="input-bx">
											<input type="text" id="PAYTYP_NAME" value="{{ @$transaction->PAYTYPCODE->PAYDESC }}" class="form-control border-danger PAYTYP_NAME" readonly />
										</div>
									</div>
								</div>
								<div class="row g-2 mb-1">
									<div class="col-4">
										<div class="row g-2 align-self-center">
											<div class="col-md-12">
												<div class="form-floating">
													<textarea class="form-control" placeholder="Leave a comment here" name="pay_memo" id="pay_memo" maxlength="65535" style="height: 118px">{{ @$transaction->Memo }}</textarea>
													<label for="pay_memo" class="fw-bold text-muted">หมายเหตุ</label>
												</div>
											</div>
										</div>
									</div>
									<div class="col-8">
										<div id="PAYTYP_TRAN" class="">
											<div class="mb-1">
												<div class="input-bx">
													<input type="text" name="CHQDT" id="CHQDT" value="{{ @$transaction->CHQTranCHQMas->CHQDT }}" class="form-control text-center font-size-14" id="date_viewDuepay" data-date-autoclose="true" data-provide="datepicker" data-date-format="dd-mm-yyyy" data-date-language="th" autocomplete="off" data-date-today-btn="linked" placeholder="วัน-เดือน-ปี" />
													<span>วันที่โอน</span>
												</div>
											</div>
											<div class="row mb-1">
												<div class="col">
													<div class="input-bx">
														<input type="text" id="PAYINACC_NAME" value="{{ @$transaction->CHQTranCHQMas->CHQMasBackAccount->company_bank }}" class="form-control PAYINACC_NAME" readonly placeholder=" " />
														<span>บริษัท</span>
														<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 constant-INACC" data-bs-toggle="modal" data-bs-target="#modal_lg_2" data-link="{{ route('constants.create') }}?page={{ 'backend' }}&FlagBtn={{ 'PAYINACC' }}&modalID={{ 'modal_xl_2' }}&comType={{ @$contract->CODLOAN }}&zone={{ @$contract->UserZone }}" {{ $flag_page == 'payment-Details' ? 'disabled' : '' }}>
															<i class="dripicons-menu"></i>
														</button>
													</div>
													<input hidden type="text" name="PAYINACC" id="PAYINACC_CODE" class="form-control PAYINACC_CODE" title="ธนาคาร" />
												</div>
											</div>
											<div class="row g-2">
												<div class="col">
													<div class="input-bx">
														<input type="text" id="BANKNAME" value="{{ @$transaction->CHQTranCHQMas->CHQMasBackAccount->Account_Bank }}" class="form-control BANKNAME" readonly placeholder=" " />
														<span>ธนาคาร</span>
													</div>
												</div>
												<div class="col">
													<div class="input-bx">
														<input type="text" id="PAYINACC_NUMBER" value="{{ @$transaction->CHQTranCHQMas->CHQMasBackAccount->Account_Number }}" class="form-control PAYINACC_NUMBER" readonly placeholder=" " />
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
									<div class="mb-3 up-down">
										<img src="{{ asset('assets/images/payment-1.png') }}" alt="" class="avatar-lg">
									</div>
								</div>
								<div class="row mb-1 g-2">
									<div class="col-6">
										<div class="input-bx">
											<input type="date" name="BILLDT" id="BILLDT" value="{{ @$BILLDT }}" class="form-control border-danger text-end" placeholder=" " readonly />
											<span class="text-danger">วันที่รับเงิน</span>
											<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-14"><i class="bx bx-calendar text-info"></i></button>
										</div>
									</div>
									<div class="col-6">
										<div class="input-bx">
											<input type="text" value="{{ number_format(@$NETPAY, 2) }}" class="form-control text-end border-danger" placeholder=" " readonly />
											<span class="text-danger">ยอดชำระ</span>
											<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">บาท</button>
										</div>
									</div>
								</div>
								<div class="row mb-1">
									<div class="col-12">
										<div class="input-bx">
											<input type="text" name="PAYAMT" id="PAYAMT" value="{{ number_format(@$PAYAMT, 2) }}" class="form-control text-end" required placeholder=" " readonly />
											<span>ยอดค่างวด</span>
											<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">บาท</button>
										</div>
									</div>
								</div>
								<div class="row mb-1 g-2">
									<div class="col-6">
										<div class="input-bx">
											<input type="text" name="PAYINT" id="PAYINT" value="{{ number_format(@$PAYINT, 0) }}" class="form-control text-end" placeholder=" " readonly />
											<span>เบี้ยปรับล่าช้า</span>
											<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">บาท</button>
										</div>
									</div>
									<div class="col-6">
										<div class="input-bx">
											<input type="text" name="DSCINT" id="DSCINT" value="{{ number_format(@$DSCINT, 0) }}" class="form-control text-end" title="ส่วนลด" placeholder=" " autocomplete="off" readonly />
											<span>ส่วนลดเบี้ยปรับ</span>
											<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">บาท</button>
										</div>
									</div>
								</div>
								<div class="row mb-1 g-2">
									<div class="col-6">
										<div class="input-bx">
											<input type="text" name="payfollow" id="payfollow" value="{{ number_format(@$payfollow, 0) }}" class="form-control text-end" placeholder=" " readonly />
											<span>ค่าทวงถาม</span>
											<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">บาท</button>
										</div>
									</div>
									<div class="col-6">
										<div class="input-bx">
											<input type="text" name="DSCPAYFL" id="DSCPAYFL" value="{{ number_format(@$DSCPAYFL, 0) }}" class="form-control text-end" title="ส่วนลด ค่าทวงถาม" placeholder=" " autocomplete="off" readonly />
											<span>ส่วนลดทวงถาม</span>
											<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">บาท</button>
										</div>
									</div>
								</div>
								<div class="row mb-1 g-2">
									<div class="col-6 {{ @$status_PAYFOR == '006' ? 'd-none' : '' }}">
										<div class="input-bx">
											<input type="text" name="DISCT" id="DISCT" value="{{ isset($transaction->DISCT) ? number_format(@$transaction->DISCT, 0) : '' }}" class="form-control text-end border-danger DISCT" title="ส่วนลดปิดบัญชี" placeholder=" " oninput="this.value = this.value.replace(/[a-zA-Z0-9ก-๙\s]/g, '');" {{ @$status_PAYFOR == '006' ? '' : 'required' }} autocomplete="off" />
											<span class="text-danger">ส่วนลดปิดบัญชี</span>
											<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">บาท</button>
											<button type="button" id="btn_sh_disct" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-14" data-link="{{ route('payments.show', @$contract->id ?? 0) }}?FlagBtn={{ 'disACtoModal' }}&CODLOAN={{ @$contract->CODLOAN }}&datePay={{ @$BILLDT }}">
												<i class="bx bx-search-alt text-info"></i>
											</button>
										</div>
									</div>
									<div class="{{ @$status_PAYFOR == '006' ? 'col-12' : 'col-6' }}">
										<div class="input-bx">
											<input type="text" class="form-control text-end border-danger" id="sumPay" name="sumPay" value="{{ number_format(@$NETPAY - @$DSCINT - @$DSCPAYFL - @$transaction->DISCT, 2) }}" placeholder="รวมยอดสุทธิ + ส่วนลดเบี้ยปรับ + ส่วนลดทวงถาม" readonly>
											{{-- <input type="text" name="view_sumPay" id="view_sumPay" value="{{ number_format(@$PAYAMT - @$DSCINT - @$DSCPAYFL, 2) }}" class="form-control text-end border-danger" readonly /> --}}
											<span class="text-danger">ยอดรับสุทธิ</span>
											<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">บาท</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				{{-- ser value --}}
				<input type="hidden" name="TYPEPAY" id="TYPEPAY" value="{{ @$TYPEPAY }}" placeholder="ประเภทชำระ">
				<input type="hidden" id="dic_officer" value="500" placeholder="ส่วนลดเจ้าหน้าที">
				<input type="hidden" id="sum_dicint" placeholder="รวมส่วนลด">
				{{-- <input  type="text" id="sumPay" name="sumPay" value="{{ @$PAYAMT - @$DSCINT - @$DSCPAYFL }}" placeholder="รวมยอดสุทธิ + ส่วนลดเบี้ยปรับ + ส่วนลดทวงถาม"> --}}
			</div>
		</form>
	</div>
	<div class="modal-footer float-end">
		<div class="btn-group">
			<button type="button" id="div_btnPrint" class="btn btn-info btn-sm w-md hover-up dropdown-toggle d-none" data-bs-toggle="dropdown" aria-expanded="false">
				<i class="mdi mdi-printer-check"></i> พิมพ์ใบเสร็จ <i class="mdi mdi-chevron-down"></i>
			</button>
			<div class="dropdown-menu" style="">
				<a target="_blank" class="dropdown-item d-flex justify-content-start print_payments" data-mas_id="" onclick="rpPayments({{ @$contract->CODLOAN }},'A4')">
					<i class="bx bx-news text-info fs-5"></i><span class="ms-2 font-size-12"> ฟอร์มใบเสร็จ (A4)</span>
				</a>
				<div class="dropdown-divider"></div>
				<a target="_blank" class="dropdown-item d-flex justify-content-start print_payments" data-mas_id="" onclick="rpPayments({{ @$contract->CODLOAN }}, 'A5')">
					<i class="bx bx-news text-info fs-5"></i><span class="ms-2 font-size-12"> ฟอร์มใบเสร็จ (A5)</span>
				</a>
			</div>
		</div>
		{{-- <a target="_blank" class="btn btn-info btn-sm w-md hover-up d-none" data-mas_id="" onclick="rpPayments({{ $contract->CODLOAN }}, null)">
			<i class="mdi mdi-printer-check"></i> พิมพ์ใบเสร็จ
		</a> --}}
		<button type="button" id="create_payments" data-id="{{ @$contract->id }}" data-codloan="{{ @$contract->CODLOAN }}" class="btn btn-success btn-sm w-md hover-up btn-disabled {{ $flag_page == 'payment-Details' ? 'd-none' : '' }}">
			<span class="addSpin"><i class="fas fa-download"></i></span> รับชำระ
		</button>
		<button type="button" id="close_payments" class="btn btn-danger btn-sm w-md waves-effect hover-up btn-disabled {{ $flag_page == 'payment-Details' ? 'd-none' : '' }}" data-bs-dismiss="modal">
			<i class="mdi mdi-close-circle-outline"></i> ยกเลิก
		</button>

		<button type="button" class="btn btn-secondary btn-sm w-md waves-effect hover-up {{ $flag_page != 'payment-Details' ? 'd-none' : '' }}" data-bs-toggle="modal" data-bs-target="#modal_xl" data-bs-dismiss="modal" aria-label="Close">
			<i class="mdi mdi-arrow-left-circle"></i> ย้อนกลับ
		</button>
	</div>
</div>

<script>
	$(document).ready(function() {
		// $('.PAYTYP_CODE').on('keypress', function(e) {
		// 	if (e.keyCode === 13 || e.which === 13) {
		// 		$(".PAYFOR_CODE").focus();
		// 		let BILLDT = $('#BILLDT').val();
		// 		let payTypValue = $('#PAYTYP_CODE').val();

		// 		console.log('keypress: ' + payTypValue);

		// 		if (payTypValue == '01' && BILLDT != '{{ date('Y-m-d') }}') {
		// 			$('#PAYTYP_CODE,#PAYTYP_NAME').val('');
		// 			Swal.fire({
		// 				icon: 'error',
		// 				title: `ไม่สามารถดำเนินการ`,
		// 				text: 'กรณีรับชำระเงินสด ต้องชำระเป็นวันปัจจุบันเท่านั้น !',
		// 				showConfirmButton: true,
		// 			});
		// 		}
		// 	}
		// });
		$('#DSCINT').on('keypress change', function(e) {
			if (e.keyCode === 13 || e.which === 13 || e.type === 'change') {
				let DSCINT = $(this).val();
				let PAYAMT = $('#PAYAMT').val().replace(/,/g, '');
				let PAYINT = $('#PAYINT').val().replace(/,/g, '');
				let payfollow = $('#payfollow').val().replace(/,/g, '');
				let DSCPAYFL = $('#DSCPAYFL').val().replace(/,/g, '');

				if (DSCINT == '') {
					DSCINT = 0;
				} else {
					if (parseFloat(DSCINT) > parseFloat(PAYINT)) {
						Swal.fire({
							icon: 'error',
							text: 'ไม่สามารถให้ส่วนลดมากกว่า ยอดเบี้ยปรับล่าช้า !',
							showConfirmButton: true,
							allowEnterKey: true,
							timer: 1500
						});

						DSCINT = 0;
						$(this).val('');
						// return
					}
				}

				if (payfollow == '') {
					DSCINT = 0;
				}
				if (DSCPAYFL == '') {
					DSCPAYFL = 0;
				}

				let sumpay = ((parseFloat(PAYINT) - parseFloat(DSCINT)) + (parseFloat(payfollow) - parseFloat(DSCPAYFL)));
				$('#sumPay').val(addCommas((parseFloat(PAYAMT) + parseFloat(sumpay)).toFixed(2)));

				$('#DSCPAYFL').focus();
			}
		});
		$('#DSCPAYFL').on('keypress change', function(e) {
			if (e.keyCode === 13 || e.which === 13 || e.type === 'change') {
				let DSCPAYFL = $(this).val();
				let PAYAMT = $('#PAYAMT').val().replace(/,/g, '');
				let PAYINT = $('#PAYINT').val().replace(/,/g, '');
				let DSCINT = $('#DSCINT').val().replace(/,/g, '');
				let payfollow = $('#payfollow').val().replace(/,/g, '');

				if (DSCPAYFL == '') {
					DSCPAYFL = 0;
				} else {
					if (parseFloat(DSCPAYFL) > parseFloat(payfollow)) {
						Swal.fire({
							icon: 'error',
							text: 'ไม่สามารถให้ส่วนลดมากกว่า ค่าทวงถาม !',
							showConfirmButton: true,
							allowEnterKey: true,
							timer: 1500
						});

						DSCPAYFL = 0;
						$(this).val('');
						// return
					}
				}

				if (PAYAMT == '') {
					PAYAMT = 0;
				}
				if (DSCINT == '') {
					DSCINT = 0;
				}

				let sumpay = ((parseFloat(PAYINT) - parseFloat(DSCINT)) + (parseFloat(payfollow) - parseFloat(DSCPAYFL)));
				$('#sumPay').val(addCommas((parseFloat(PAYAMT) + parseFloat(sumpay)).toFixed(2)));
			}
		});

		$(".modal-constant").click(function() {
			$('#modal_sd').on('hidden.bs.modal', function(e) {
				var payForValue = $('#PAYFOR_CODE').val();

				if (payForValue !== '006') {
					$('#DISCT').prop('required', true);
					$('.show-disct').show(); // แสดงส่วนของ DISCT
				} else {
					$('#DISCT').prop('required', false);
					$('.show-disct').hide(); // ซ่อนส่วนของ DISCT
				}
			});
		});

		// ใช้ได้ ****************************
		$("#btn_sh_disct").click(function(e) {
			e.preventDefault();
			var url = $(this).attr('data-link');
			$(".loading-overlay").fadeIn().attr('style', ''); // แสดงตัวโหลด

			$('#modal_sd .modal-dialog').empty();
			$('#modal_sd .modal-dialog').load(url, function(response, status, xhr) {
				if (status === 'success') {
					$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ซ่อนตัวโหลด

					// คำนวณค่า z-index ใหม่
					var zIndex = 1050 + 10 * $(".modal:visible").length;

					$('#modal_sd').css('z-index', zIndex);
					$('#modal_sd').modal('show');

					// ใช้ setTimeout เพื่อให้แน่ใจว่าค่า z-index ถูกตั้งหลังจาก modal ถูกแสดง
					setTimeout(function() {
						// ตั้งค่า z-index ของ backdrop และ stack class เพื่อให้ซ้อนกัน
						$('.modal-backdrop').css('z-index', zIndex - 1).addClass('modal-stack');
						$('#modal_sd').css('z-index', zIndex);
						console.log("Modal zIndex set to: " + $('#modal_sd').css('z-index'));
						console.log("Backdrop zIndex set to: " + $('.modal-backdrop').css('z-index'));

						// $('#modal_sd').css('z-index', zIndex);
						// $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');

						// console.log("Modal zIndex set to: " + $('#modal_sd').css('z-index'));
						// console.log("Backdrop zIndex set to: " + $('.modal-backdrop').css('z-index'));
					}, 0);


					// ใช้ setTimeout เพื่อให้แน่ใจว่าค่า z-index ถูกตั้งหลังจาก modal ถูกแสดง
					// setTimeout(function() {
					// 	$('#modal_sd').css('z-index', zIndex);
					// 	var visibleModals = $(".modal:visible").not('#modal_sd');
					// 	console.log("Visible modals: " + visibleModals.length);
					// 	visibleModals.each(function(index) {
					// 		$(this).css('z-index', zIndex - 20 - (index * 10));
					// 	});
					// 	$('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
					// 	console.log("Modal zIndex set to: " + $('#modal_sd').css('z-index'));
					// 	console.log("Backdrop zIndex set to: " + $('.modal-backdrop').css('z-index'));
					// }, 0);


					// // ตั้งค่า backdrop ก่อนแสดง modal
					// $('#modal_sd').modal({
					// 	backdrop: 'static',
					// 	keyboard: false
					// }).on('shown.bs.modal', function() {
					// 	$('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
					// 	console.log("Backdrop zIndex set to: " + $('.modal-backdrop').css('z-index'));
					// });
				} else {
					console.log('Load failed');
				}
			});
		});

		// chage backdrop
		$('#modal_sd').on('hidden.bs.modal', function() {
			if ($(this).find('modal-OTP')) {
				let zindex = parseInt($(".modal:visible").css('z-index'));
				$('.modal-backdrop.modal-stack').css('z-index', zindex - 1).removeClass('modal-stack');
			}
		});

		// $('#constant-PAYTYP').on("show.bs.modal", ".modal", function() {
		// 	console.log('show.bs.modal');
		// 	var zIndex = 1040 + 10 * $(".modal:visible").length;
		// 	$(this).css("z-index", zIndex);
		// 	setTimeout(function() {
		// 		$(".modal-backdrop")
		// 			.not(".modal-stack")
		// 			.css("z-index", zIndex - 1)
		// 			.addClass("modal-stack");
		// 	}, 0);
		// });
	});

	// $(document).on('show.bs.modal', '.modal', function() {
	// 	const zIndex = 1040 + 10 * $('.modal:visible').length;
	// 	$(this).css('z-index', zIndex);
	// 	setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack'));
	// });
</script>

<script>
	$('#create_payments').click(function() {
		let dataform = document.querySelectorAll('#form-create-payments');
		let validate = validateForms(dataform);

		if (validate == true) {
			$('.btn-disabled').prop('disabled', true);
			$(this).prop('disabled', true);

			$('.addSpin').empty();
			$('<span />', {
				class: "spinner-border spinner-border-sm",
				role: "status"
			}).appendTo(".addSpin");

			let CODLOAN = $(this).data('codloan');
			let id = $(this).data('id');
			let type = $('#TYPEPAY').val();

			let data = {};
			let arrPay = {};
			$("#form-create-payments").serializeArray().map(function(x) {
				data[x.name] = x.value;
			});

			$.ajax({
				url: "{{ route('payments.store') }}",
				method: "post",
				data: {
					_token: '{{ @csrf_token() }}',
					id: id,
					page: 'payments',
					CODLOAN: CODLOAN,
					data: data,
					type: type
				},

				success: async function(result) {
					$('.view-contract').slideDown('slow').html(result.viewCon);
					$('.view-tb-duepay').html(result.html);
					$('.view-contentPay').hide();

					$('#priceCus').val(result.priceCus);
					$('#intamtCus').val(result.intamtCus);
					$('#vfollowCus').val(result.vfollowCus);

					// reset show
					$('.btGroup-pay').val('');
					$('.btn-stantlog').val('');
					$('.btGroup-showPay').empty();
					$('.btGroup-showPay').append('0.00');
					$('#DateSer').val(result.DateSer);

					// reset btn
					$('#btn-Payments').prop("disabled", true);
					$('.btGroup-pay').prop("disabled", true);
					$('.btn-typePay').prop('checked', false).removeClass('active');

					// show btn prints
					// await build_btnPayments(result.CHQMas_id,CODLOAN);
					$('.print_payments').attr('data-mas_id', result.CHQMas_id)
					$('#div_btnPrint').removeClass('d-none');

					$('#create_payments').addClass('d-none')
					$('#close_payments').addClass('d-none')

					Swal.fire({
						icon: 'success',
						text: result.message,
						showConfirmButton: false,
						timer: 1500
					});
				},
				error: function(err) {
					Swal.fire({
						icon: 'error',
						title: `ERROR ` + err.status + ` !!!`,
						text: err.responseJSON.message,
						showConfirmButton: true,
					});
				},
				complete: function() {
					$('.addSpin').empty();

					$('.btn-disabled').prop('disabled', false);
					$('#create_payments').prop('disabled', false);
				}
			})
		}
	});

	// report payments
	function build_btnPayments(mas_id, contcodloan) {
		let url = `{{ route('report-backend.show', ':id') }}?codloan=${contcodloan}&page=rp-paydue`;
		url = url.replace(':id', mas_id);

		$('.print_payments').attr('href', url);
		let flag_pt = "{{ session()->put('flag_pt', 'active') }}";
	}

	function rpPayments(codloan, typeRp) {
		let id = $('.print_payments').attr('data-mas_id');
		let url = `{{ route('report-backend.show', 'id') }}?codloan=${codloan}&page=rp-paydue&typeRp=${typeRp}`;
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

	$('.print_payments').click(function() {
		$('#modal_xl_2').modal('hide');
	});

	$('[data-bs-toggle="tooltip"]').tooltip();

	// $('#print_payments').click(function() {
	// 	let contcodloan = $(this).data('codloan');
	// 	let idMas = 21;
	// 	let page = 'rp-paydue';

	// 	let link = "{{ route('report-backend.show', 'id') }}?codloan={{ 'contcodloan' }}&page={{ 'rp-paydue' }}";
	// 	link = link.replace('id', idMas);
	// 	let url = link.replace('contcodloan', contcodloan);

	// 	let flag_pt = "{{ session()->put('flag_pt', '123') }}";
	// 	$('#print_payments').attr('href', url);
	// });
</script>
