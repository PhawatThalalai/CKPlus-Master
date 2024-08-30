@extends('layouts.master')
@section('title', 'Contract')
@section('report-active', 'mm-active')
@section('report-track-active', 'mm-active')
@section('report-track-billstmt', 'mm-active')
@section('page-frontend', 'd-none')

@section('content')

	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])
	@include('public-js.toggletab-profile')

	@component('components.breadcrumb')
		@slot('title')
			หนังสือแจ้งค่างวด
		@endslot
		@slot('title_small')
			(Billing Statement)
		@endslot
		@slot('menu')
			รายงาน
		@endslot
		@slot('sub_menu')
			รายงานลูกหนี้
		@endslot
	@endcomponent

	@include('public-js.scriptConstantPreload', ['FlagBtn' => 'LOCAT'])

	{{--
    <button type="button" onclick="openGoogle()" class="btn btn-primary h-100 "><i class="bx bx-search-alt align-middle"></i> Button</button>
    <button type="button" onclick="printBtn()" class="btn btn-primary h-100 "><i class="bx bx-search-alt align-middle"></i> Button</button>
     --}}

	<style>
		/* Add this CSS to change cursor to pointer when hovering over table rows */
		#table_billing_stmt tbody tr {
			cursor: pointer;
		}
	</style>

	<div class="card">
		<div class="card-body border-bottom">
			<form id="form_billing_statement" class="needs-validation" novalidate>
				<div class="row g-3">
					<div class="col-xxl-4 col-lg-4 col-md-12 align-items-center">
						<div class="row g-2">
							<div class="col-4">
								<div class="input-bx">
									<input type="text" name="LOCAT" id="LOCAT" value="{{ auth()->user()->UserToBranch->NickName_Branch }}" class="form-control LOCAT" placeholder=" " />
									<span>สาขาที่รับ</span>
									<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 modal_lg d-flex align-items-center" data-link="{{ route('constants.create') }}?page={{ 'backend' }}&FlagBtn={{ 'LOCAT' }}&modalID={{ 'modal_lg' }}">
										<i class="d-flex dripicons-menu"></i>
									</button>
								</div>
							</div>
							<div class="col-8">
								<div class="input-bx">
									<input type="text" class="form-control LOCATNAME" value="{{ auth()->user()->UserToBranch->Name_Branch }}" readonly />
								</div>
							</div>
							<input type="hidden" name="ID_LOCAT" class="ID_LOCAT" value="{{ auth()->user()->UserToBranch->id }}">
						</div>
					</div>
					<div class="col-xxl-6 col-lg-8 col-md-12">

						<div class="row g-0">
							<div class="col-lg-9 col-sm-8 col-8" id="DueDT_datepicker">
								<div class="input-daterange input-group text-center row g-2" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#DueDT_datepicker" data-date-disable-touch-keyboard="true" data-date-language="th" data-date-today-highlight="true">
									<div class="col-6">
										<div class="input-bx">
											<input type="text" class="form-control" name="DueDT_start" id="DueDT_start" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" placeholder=" " autocomplete="off" required />
											<span class="text-danger">วันที่ดิวจาก</span>
										</div>
									</div>
									<div class="col-6">
										<div class="input-bx">
											<input type="text" class="form-control" name="DueDT_end" id="DueDT_end" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" placeholder=" " autocomplete="off" required />
											<span class="text-danger">ถึงวันที่</span>
										</div>
									</div>
								</div>
							</div>

							<div class="col-lg-3 col-sm-4 col-4">
								<div class="input-bx">
									<input type="text" name="CONTNO" id="CONTNO" value="" class="form-control" placeholder=" " />
									<span>เลขที่สัญญา</span>
								</div>
							</div>
						</div>

					</div>
					<div class="col-xxl-2 col-lg-12">
						<div class="position-relative h-100 hstack gap-3">
							<button type="button" id="btn_serach" class="btn btn-success h-100 w-100"><i class="bx bx-search-alt align-middle"></i> ค้นหา</button>
							<button type="button" id="btn_print" class="btn btn-primary h-100 w-100 disabled" onclick="printBtn()"><i class="bx bx-printer align-middle"></i> พิมพ์</button>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>

	{{-- body --}}
	<div class="card" id="welcome_page">
		<div class="d-flex justify-content-center m-5">
			<img class="img-fluid" src="{{ URL::asset('assets/images/undraw/letter-requesting-payment.png') }}" alt="Card image cap">
		</div>
	</div>
	<div id="content_data" style="display: none;">

	</div>

	<script>
		$(document).ready(function() {
			let initialFormState = $('#form_billing_statement').serialize();
			let hasSearched = false;

			function disablePrintButton() {
				$('#btn_print').addClass('disabled');
			}

			function enablePrintButton() {
				$('#btn_print').removeClass('disabled');
			}

			function checkFormChanges() {
				let currentFormState = $('#form_billing_statement').serialize();
				if (currentFormState !== initialFormState) {
					disablePrintButton();
				} else if (hasSearched) {
					enablePrintButton();
				}
			}

			// Event listener for input changes
			$('#form_billing_statement input').on('input change', function() {
				checkFormChanges();
			});

			$('#btn_serach').click(function() {
				var dataform = document.querySelectorAll('#form_billing_statement');
				var validate = validateForms(dataform);

				if (validate == true) {
					let data = {};
					$("#form_billing_statement").serializeArray().map(function(x) {
						data[x.name] = x.value;
					});

					$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
					$.ajax({
						url: "{{ route('view-backend.index') }}",
						method: "get",
						data: {
							page: 'billing-stmt',
							ajax: true,
							data: data,
							//_token: "{{ @csrf_token() }}",
						},
						complete: function(event) {
							$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
						},
						success: function(result) {
							console.log(result);
							Swal.fire({
								icon: 'success',
								text: result.message,
								showConfirmButton: false,
								timer: 1500
							});
							$('#content_data').html(result.html);
							$('#content_data').show();
							$('#welcome_page').hide();
							if (result.data_size > 0) {

								initialFormState = $('#form_billing_statement').serialize();
								hasSearched = true;
								enablePrintButton();

							} else {
								//$("#btn_print").addClass('disabled');

								//initialFormState = $('#form_billing_statement').serialize();
								hasSearched = false;
								disablePrintButton();

							}
						},
						error: function(err) {
							Swal.fire({
								icon: 'error',
								title: `ERROR ` + err.status + ` !!!`,
								text: err.responseJSON.message,
								showConfirmButton: true,
							});
							$('#content_data').hide();
							$('#welcome_page').show();
						}
					})
				}
			});

		})
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
	</script>

	<!--
					<script>
						$('#btn_serach').click(function() {
							var dataform = document.querySelectorAll('#form_billing_statement');
							var validate = validateForms(dataform);

							if (validate == true) {
								let data = {};
								$("#form_billing_statement").serializeArray().map(function(x) {
									data[x.name] = x.value;
								});

								$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
								$.ajax({
									url: "{{ route('view-backend.index') }}",
									method: "get",
									data: {
										page: 'billing-stmt',
										ajax: true,
										data: data,
										//_token: "{{ @csrf_token() }}",
									},
									complete: function(event) {
										$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
									},
									success: function(result) {
										console.log(result);
										Swal.fire({
											icon: 'success',
											text: result.message,
											showConfirmButton: false,
											timer: 1500
										});
										$('#content_data').html(result.html);
										$('#content_data').show();
										$('#welcome_page').hide();
										if (result.data_size > 0) {
											$("#btn_print").removeClass('disabled');
										} else {
											$("#btn_print").addClass('disabled');
										}
									},
									error: function(err) {
										Swal.fire({
											icon: 'error',
											title: `ERROR ` + err.status + ` !!!`,
											text: err.responseJSON.message,
											showConfirmButton: true,
										});
										$('#content_data').hide();
										$('#welcome_page').show();
									}
								})
							}
						});
					</script>
					-->

	<script>
		function rpPayments(codloan) {
			let id = $('#print_payments').attr('data-mas_id');
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

	<script>
		function printBtn() {

			var dataform = document.querySelectorAll('#form_billing_statement');
			var validate = validateForms(dataform);

			if (validate == true) {
				let parameter = "";
				$("#form_billing_statement").serializeArray().map(function(x) {
					parameter += `&${x.name}=${x.value}`;
				});

				let url = `{{ route('report-backend.show', 1) }}?page=billingstmt&mode=all${parameter}`;
				console.log(url);

				let newWindow = window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400,name=ใบเสร็จรับเงิน");
				if (newWindow) {
					let browserWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
					let browserHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
					window.blur(); // ล่วงหน้าต่างของเบราว์เซอร์
					newWindow.focus(); // กลับมาโฟกัสที่หน้าต่าง Modal
					newWindow.resizeTo(browserWidth, browserHeight);
				}

				/*
				$.ajax({
				    url: "{{ route('report-backend.show', 1) }}?",
				    method: "GET",
				    data: {
				        page: 'billingstmt',
				        data: data,
				    },
				    complete: function(data) {
				        
				    },
				    success: function(result){
				        let newWindow = window.open("", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400,name=ใบเสร็จรับเงิน");
				        if (newWindow) {
				            let browserWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
				            let browserHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
				            window.blur(); // ล่วงหน้าต่างของเบราว์เซอร์
				            newWindow.document.body.innerHTML = result;//"HELLO!";
				            newWindow.focus(); // กลับมาโฟกัสที่หน้าต่าง Modal
				            newWindow.resizeTo(browserWidth, browserHeight);
				        }
				    },
				    error: function(xhr, status, error) {
				        // Get the error message from the response
				        var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "ข้อผิดพลาดที่ไม่รู้จัก :'(";
				        var errorFile = xhr.responseJSON.file ? xhr.responseJSON.file : '';
				        errorFile = errorFile.replace(/^.*[\\\/]/, '');
				        var errorLine = xhr.responseJSON.line ? xhr.responseJSON.line : '';
				        var errorHtml = "<p>" + errorMessage +"</p>";
				        errorHtml += "<p class='m-0 small'>" + errorFile + " <strong>(บรรทัดที่ " + errorLine + ")</strong></p>";
				        // Display the error message using SweetAlert2
				        Swal.fire({
				            icon: 'error',
				            title: error,
				            html: `<p class="m-0">ขออภัย! เกิดข้อผิดพลาด กดดูเพิ่มเติมเพื่อแสดงรายละเอียด</p><p class="my-1 small">(${status})</p>`,
				            showCancelButton: true,
				            confirmButtonText: 'ดูเพิ่มเติม',
				            cancelButtonText: 'OK'
				        }).then((result) => {
				            if (result.isConfirmed) {
				                // If the user clicks "More Details," show the detailed error message in a new SweetAlert2 modal
				                Swal.fire({
				                    icon: 'error',
				                    title: 'รายละเอียด',
				                    //text: errorMessage,
				                    html: errorHtml,
				                    confirmButtonText: 'OK'
				                });
				            }
				        });
				    }
				})
				*/
			}


		}
	</script>

	<script>
		function openGoogle() {
			let newWindow = window.open("", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400,name=ใบเสร็จรับเงิน");
			if (newWindow) {
				let browserWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
				let browserHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
				window.blur(); // ล่วงหน้าต่างของเบราว์เซอร์
				newWindow.document.body.innerHTML = "HELLO!";
				newWindow.focus(); // กลับมาโฟกัสที่หน้าต่าง Modal
				newWindow.resizeTo(browserWidth, browserHeight);
			}
		}
	</script>

@endsection
