<style>
	.signup-form input[type=text],
	select {
		border: none;
		border-bottom: 2px solid darkgrey;
		background-color: inherit;
		display: block;
		width: 100%;
		margin: none;
	}

	.signup-form input[type=text]:focus,
	select:focus {
		outline: none;
	}

	.form-group .line {
		height: 1px;
		width: 0px;
		position: absolute;
		background-color: darkgrey;
		display: inline-block;
		transition: .3s width ease-in-out;
		position: relative;
		top: -14px;
		margin-bottom: 0;
		padding-bottom: 0;
	}

	.signup-form input[type=text]:focus+.line,
	select:focus+.line {
		width: 100%;
		background-color: #02add7;
	}
</style>

<!--  Extra Large modal example -->
<div id="modal-createPay" wire:ignore.self class="modal fade modal-data-xl" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-xl">
		{{-- <form autocomplete="off" id="create_payments" class="needs-validation" action="#" novalidate> --}}
		<form autocomplete="off" id="create_payments" wire:submit.prevent="savePayments" class="needs-validation" novalidate>
			<div class="modal-content">
				<div class="d-flex m-3 mb-0">
					<div class="flex-shrink-0 me-2">
						<img src="{{ asset('assets/images/payment.jpg') }}" alt="" class="avatar-sm">
					</div>
					<div class="flex-grow-1 overflow-hidden">
						<h4 class="text-primary fw-semibold">บันทึกรับชำระเงิน (New Payments)</h4>
						<p class="text-muted mt-n1">New Payments</p>
						<p class="border-primary border-bottom mt-n2"></p>
					</div>
					<button type="button" wire:click='closeModal' class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body mt-n4">
					<div class="row">
						<div class="col-md-12 col-lg-6">
							<div class="card">
								<div class="card-body">
									<div class="row justify-content-start mb-2">
										<div class="col-auto">
											<div class="d-flex text-danger">
												<h5 class="font-size-13 fw-semibold bx-fade-right"><i class="bx bxs-bell font-size-18"></i> ประเภทการชำระเงิน</h5>
											</div>
											<div class="btn-group btn-group-example" role="group">
												<button type="button" class="btn btn-outline-success w-xs">ชำระค่างวด</button>
												<button type="button" class="btn btn-outline-primary w-xs">ชำระค่าอื่นๆ</button>
											</div>
										</div>
									</div>
									<div class="row g-2 mb-1">
										<div class="col-4">
											<div class="input-bx">
												<input type="text" name="PAYTYP_CODE" id="PAYTYP_CODE" class="form-control is-valid" required="" required />
												<span>ชำระโดย</span>
												<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 data-modal-standard" data-bs-toggle="modal" data-bs-target="#data-modal-standard" data-link="{{ route('constants.create') }}?page={{ 'backend' }}&FlagBtn={{ 'PAYTYP' }}&modalID={{ '.modal-data-xl' }}">
													<i class="dripicons-menu"></i>
												</button>
											</div>
										</div>
										<div class="col-8">
											<div class="input-bx">
												<input type="text" name="PAYTYP_NAME" id="PAYTYP_NAME" class="form-control" readonly />
											</div>
											<div class="mt-1">
												<div class="input-bx">
													<input type="text" class="form-control" />
													<span>วันที่โอน</span>
												</div>
											</div>
										</div>
									</div>
									<div class="row g-2 mb-1">
										<div class="col-4">
											<div class="input-bx">
												<input type="text" name="PAYFOR_CODE" id="PAYFOR_CODE" class="form-control" required="" required />
												<span>รหัสชำระ</span>
												<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 data-modal-standard" data-bs-toggle="modal" data-bs-target="#data-modal-standard" data-link="{{ route('constants.create') }}?page={{ 'backend' }}&FlagBtn={{ 'PAYFOR' }}&modalID={{ '.modal-data-xl' }}">
													<i class="dripicons-menu"></i>
												</button>
											</div>
										</div>
										<div class="col-8">
											<div class="input-bx">
												<input type="text" name="PAYFOR_NAME" id="PAYFOR_NAME" class="form-control" readonly />
											</div>
										</div>
									</div>
									<div class="row g-2 mb-1">
										<div class="col-4">
											<div class="input-bx">
												<input type="text" class="form-control" required="" />
												<span>ธนาคาร</span>
												<button name="PAYINACC" id="PAYINACC" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10"><i class="dripicons-menu"></i></button>
											</div>
										</div>
										<div class="col-8">
											<div class="input-bx">
												<input type="text" class="form-control" readonly />
											</div>
										</div>
									</div>
									<div class="row g-2 mb-1">
										<div class="col-4">
											<div class="input-bx">
												<input type="text" name="branchPay" class="form-control" required="" />
												<span>สาขาที่รับ</span>
												<button name="LOCAT" id="LOCAT" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10"><i class="dripicons-menu"></i></button>
											</div>
										</div>
										<div class="col-8">
											<div class="input-bx">
												<input type="text" class="form-control" readonly />
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-lg-6">
							<div class="card">
								<div class="card-body">
									<h5 class="card-title">ข้อมูลการรับชำระ</h5>
									<div class="text-center">
										<div class="mb-1 mt-n3">
											<img src="{{ asset('assets/images/payment-1.png') }}" alt="" class="avatar-lg">
										</div>
									</div>
									<div class="row g-2 mb-1">
										<div class="col-6">
											<div class="input-bx">
												<input type="date" name="Duepay" class="form-control" value="{{ @$Duepay }}" />
												<span>วันที่รับเงิน</span>
											</div>
										</div>
										<div class="col-6">
											<div class="input-bx">
												<input type="text" name="" class="form-control" value="MP1-21070003" />
												<span>เลขที่ใบรับ</span>
											</div>
										</div>
									</div>

									<div class="row mb-1">
										<div class="col-12">
											<div class="input-bx">
												<input type="text" value="{{ !empty(@$inputPayment) ? number_format(@$inputPayment, 2) : '' }}" class="form-control text-end" required="" required />
												<span>ยอดชำระ</span>
												<button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">บาท</button>
											</div>
										</div>
									</div>
									<div class="row mb-1">
										<div class="col-12">
											<div class="input-bx">
												<input type="text" value="{{ !empty(@$interest) ? number_format(@$interest, 2) : '' }}" class="form-control text-end" required="" required />
												<span>เบี้ยปรับล่าช้า</span>
												<button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">บาท</button>
											</div>
										</div>
									</div>
									<div class="row mb-1">
										<div class="col-12">
											<div class="input-bx">
												<input type="text" name="" id="" class="form-control text-end" />
												<span>ส่วนลด</span>
												<button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">บาท</button>
											</div>
										</div>
									</div>
									<div class="row mb-1">
										<div class="col-12">
											<div class="input-bx">
												<input type="text" name="" id="" class="form-control text-end" />
												<span>ยอดรับสุทธิ</span>
												<button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">บาท</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					{{-- <h5 class="font-size-15">ตารางการชำระ</h5>
					<div class="row">
						<div class="col-12">
							<div class="card">
								<div class="card-body">
									<div class="row">
										<div class="col">
											<div class="text-end">
												
											</div>
										</div>
									</div>

									<div class="table-responsive">
										<table class="table align-middle table-nowrap table-check">
											<thead class="table-light">
												<tr>
													<th style="width: 20px;" class="align-middle">
														<div class="form-check font-size-16">
															<input class="form-check-input" type="checkbox" id="checkAll">
															<label class="form-check-label" for="checkAll"></label>
														</div>
													</th>
													<th class="align-middle">Order ID</th>
													<th class="align-middle">Billing Name</th>
													<th class="align-middle">Date</th>
													<th class="align-middle">Total</th>
													<th class="align-middle">Payment Status</th>
													<th class="align-middle">Payment Method</th>
													<th class="align-middle">View Details</th>
													<th class="align-middle">Action</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>
														<div class="form-check font-size-16">
															<input class="form-check-input" type="checkbox" id="orderidcheck01">
															<label class="form-check-label" for="orderidcheck01"></label>
														</div>
													</td>
													<td><a href="javascript: void(0);" class="text-body fw-bold">#SK2540</a> </td>
													<td>Neal Matthews</td>
													<td>
														07 Oct, 2019
													</td>
													<td>
														$400
													</td>
													<td>
														<span class="badge badge-pill badge-soft-success font-size-12">Paid</span>
													</td>
													<td>
														<i class="fab fa-cc-mastercard me-1"></i> Mastercard
													</td>
													<td>
														<!-- Button trigger modal -->
														<button type="button" class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target=".orderdetailsModal">
															View Details
														</button>
													</td>
													<td>
														<div class="d-flex gap-3">
															<a href="javascript:void(0);" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
															<a href="javascript:void(0);" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<div class="form-check font-size-16">
															<input class="form-check-input" type="checkbox" id="orderidcheck02">
															<label class="form-check-label" for="orderidcheck02"></label>
														</div>
													</td>
													<td><a href="javascript: void(0);" class="text-body fw-bold">#SK2541</a> </td>
													<td>Jamal Burnett</td>
													<td>
														07 Oct, 2019
													</td>
													<td>
														$380
													</td>
													<td>
														<span class="badge badge-pill badge-soft-danger font-size-12">Chargeback</span>
													</td>
													<td>
														<i class="fab fa-cc-visa me-1"></i> Visa
													</td>
													<td>
														<!-- Button trigger modal -->
														<button type="button" class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target=".orderdetailsModal">
															View Details
														</button>
													</td>
													<td>
														<div class="d-flex gap-3">
															<a href="javascript:void(0);" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
															<a href="javascript:void(0);" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a>
														</div>
													</td>
												</tr>
												<tr>
													<td>
														<div class="form-check font-size-16">
															<input class="form-check-input" type="checkbox" id="orderidcheck03">
															<label class="form-check-label" for="orderidcheck03"></label>
														</div>
													</td>
													<td><a href="javascript: void(0);" class="text-body fw-bold">#SK2542</a> </td>
													<td>Juan Mitchell</td>
													<td>
														06 Oct, 2019
													</td>
													<td>
														$384
													</td>
													<td>
														<span class="badge badge-pill badge-soft-success font-size-12">Paid</span>
													</td>
													<td>
														<i class="fab fa-cc-paypal me-1"></i> Paypal
													</td>
													<td>
														<!-- Button trigger modal -->
														<button type="button" class="btn btn-primary btn-sm btn-rounded" data-bs-toggle="modal" data-bs-target=".orderdetailsModal">
															View Details
														</button>
													</td>
													<td>
														<div class="d-flex gap-3">
															<a href="javascript:void(0);" class="text-success"><i class="mdi mdi-pencil font-size-18"></i></a>
															<a href="javascript:void(0);" class="text-danger"><i class="mdi mdi-delete font-size-18"></i></a>
														</div>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div> --}}
				</div>
				<div class="modal-footer float-end">
					<button type="submit" id="update_payments" class="btn btn-success btn-sm w-md hover-up">บันทึก</button>
					<button type="button" class="btn btn-secondary btn-sm w-md waves-effect hover-up" data-bs-dismiss="modal">ปิด</button>
				</div>
			</div>
		</form>
	</div>
</div>

{{-- <script>
	$('#update_payments').click(function() {
		// var dataform = document.querySelectorAll('.needs-validation');
		// var validate = validateForms(dataform);

		// if (validate == true) {
		// 	var type = 1;
		// 	var _token = $('input[name="_token"]').val();
		// 	var data = {};
		// 	$("#create_payments").serializeArray().map(function(x) {
		// 		data[x.name] = x.value;
		// 	});

		// 	$.ajax({
		// 		url: "{{ route('tags.store') }}",
		// 		method: "post",
		// 		data: {
		// 			_token: _token,
		// 			type: type,
		// 			data: data
		// 		},

		// 		success: function(result) {
		// 			$('.card-tagPart').addClass('d-none');
		// 			$('#data_tag').html(result);
		// 			$('#data-modal-lg').modal('hide');

		// 			Swal.fire({
		// 				icon: 'success',
		// 				text: 'New Tag successful !',
		// 				showConfirmButton: false,
		// 				timer: 1500
		// 			});
		// 		}
		// 	})
		// }
	});
</script>

<script>
	function validateForms(dataform) {
		var isvalid = false;
		Array.prototype.slice.call(dataform).forEach(function(form) {
			if (!form.checkValidity()) {
				event.preventDefault();
				event.stopPropagation();

				form.classList.add('was-validated');

				isvalid = false;
			} else {
				isvalid = true;
			}
		});
		return isvalid;
	}
</script> --}}

<script>
	$('#checkAll').on('change', function() {
		$('.table-check .form-check-input').prop('checked', $(this).prop("checked"));
	});
	$('.table-check .form-check-input').change(function() {
		if ($('.table-check .form-check-input:checked').length == $('.table-check .form-check-input').length) {
			$('#checkAll').prop('checked', true);
		} else {
			$('#checkAll').prop('checked', false);
		}
	});
</script>

<script>
	$(document).ready(function() {
		$('#PAYTYP_CODE').on('keypress', function(e) {
			if (e.keyCode === 13 || e.which === 13) {
				$("#PAYFOR_CODE").focus();
			}
		});
	});
</script>

<script>
	$(document).on('click', '.data-modal-standard', function(e) {
		e.preventDefault();
		var url = $(this).attr('data-link');
		$('#data-modal-standard .modal-dialog').load(url);
	});
</script>
