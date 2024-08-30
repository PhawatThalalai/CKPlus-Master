@extends('layouts.master')
@section('title', 'account')
@section('account-active', 'mm-active')
@section('account-sub1-active', 'mm-active')
@section('account-p2-active', 'mm-active')
@section('page-frontend', 'd-none')

@section('content')
	@include('public-js.constants')
	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])
	@component('components.breadcrumb')
		@slot('title')
			สอบถามหยุดรับรู้รายได้ตามดิว
		@endslot
		@slot('menu')
			บัญชี
		@endslot
		@slot('sub_menu')
			สอบถามหยุดรับรู้รายได้
		@endslot
	@endcomponent

	@include('components.content-loading.spinner')
	{{-- <form id="form_Stopvat" class="needs-validation" action="{{ route('ReportAcc.create') }}" method="GET" novalidate> --}}
	<form id="form_Stopvat" class="needs-validation" novalidate>
		<input class="visually-hidden" type="text" value="Debtor" name="report">
		<input class="visually-hidden" type="text" value="Account" name="form">
		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-body border-bottom">
						<div class="row g-3">
							<div class="col-xxl-5 col-lg-6">
								<div class="row g-2 mb-2">
									<div class="col-4">
										<div class="input-bx">
											<input type="text" name="LOCAT" id="LOCAT" value="{{ auth()->user()->UserToBranch->NickName_Branch }}" class="form-control LOCAT" required placeholder=" " />
											<span>สาขาที่รับ</span>
											<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 modal_lg" data-link="{{ route('constants.create') }}?page={{ 'backend' }}&FlagBtn={{ 'LOCAT' }}&modalID={{ 'modal_lg' }}">
												<i class="dripicons-menu"></i>
											</button>
										</div>
									</div>
									<div class="col-8">
										<div class="input-bx">
											<input type="text" class="form-control LOCATNAME" value="{{ auth()->user()->UserToBranch->Name_Branch }}" readonly />
										</div>
									</div>
									<input type="hidden" name="ID_LOCAT" class="ID_LOCAT" value="{{ auth()->user()->UserToBranch->id_Contract }}">
								</div>
								<div id="username" class="row g-2">
									<div class="col-4">
										<div class="input-bx">
											<input type="text" value="{{ auth()->user()->username }}" class="form-control" required placeholder=" " />
											<span>พนักงาน</span>
											<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">
												<i class="dripicons-menu"></i>
											</button>
										</div>
									</div>
									<div class="col-8">
										<div class="input-bx">
											<input type="text" value="{{ auth()->user()->name }}" class="form-control" readonly />
										</div>
									</div>
								</div>
								<div id="card-radio" class="row g-2 visually-hidden">
									<div class="col-12">
										<div class="card__radio_display_full">
											@php
												$card_radio_data = [
												    [
												        'icon-url' => 'https://cdn.lordicon.com/ujxzdfjx.json',
												        'icon-color' => 'primary:#1d6f42,secondary:#ebe6ef',
												        'icon-stroke' => 'bold',
												        'sub-icon' => 'fas fa-biking',
												        'radio-name' => 'export_type',
												        'btn-name' => 'EXCEL',
												        'btn-value' => 'EXCEL',
												        'btn-checked' => true,
												        'color' => '',
												        'width' => 'full',
												    ],
												    [
												        'icon-url' => 'https://cdn.lordicon.com/ujxzdfjx.json',
												        'icon-color' => 'primary:#dc2f02,secondary:#ebe6ef',
												        'icon-stroke' => 'bold',
												        'sub-icon' => 'fas fa-biking',
												        'radio-name' => 'export_type',
												        'btn-name' => 'PDF',
												        'btn-value' => 'PDF',
												        'btn-checked' => false,
												        'color' => 'danger',
												        'width' => 'full',
												    ],
												];
											@endphp
											@component('components.content-radiocard.radio-full')
												@slot('data', [
													'data-arr' => $card_radio_data,
													])
												@endcomponent
											</div>
										</div>
									</div>
								</div>
								<div class="col-xxl-5 col-lg-6">
									<div class="row g-2 mb-1">
										<div class="col-12">
											<div class="card__radio_display_full">
												@php
													$card_radio_data = [
													    [
													        'icon-url' => 'https://cdn.lordicon.com/jtiihjyw.json',
													        'icon-color' => 'primary:#1d6f42,secondary:#ebe6ef',
													        'icon-stroke' => 'bold',
													        'sub-icon' => 'fas fa-biking',
													        'radio-name' => 'TypeLoans',
													        'btn-name' => 'เงินกู้',
													        'btn-value' => 'PSL',
													        'btn-checked' => true,
													        'color' => 'info',
													        'width' => 'full',
													    ],
													    [
													        'icon-url' => 'https://cdn.lordicon.com/jtiihjyw.json',
													        'icon-color' => 'primary:#dc2f02,secondary:#ebe6ef',
													        'icon-stroke' => 'bold',
													        'sub-icon' => 'fas fa-biking',
													        'radio-name' => 'TypeLoans',
													        'btn-name' => 'เช่าซื้อ',
													        'btn-value' => 'HP',
													        'btn-checked' => false,
													        'color' => 'primary',
													        'width' => 'full',
													    ],
													];
												@endphp
												@component('components.content-radiocard.radio-full')
													@slot('data', [
														'data-arr' => $card_radio_data,
														])
													@endcomponent
												</div>
											</div>
										</div>
										<div class="row g-2">
											<div class="col-12">
												<div id="search_box">
													<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#search_box" data-date-format="dd-mm-yyyy" data-date-language="th">
														<div class="col-6">
															<div class="input-bx">
																<input type="text" class="form-control form-control-sm textSize-13" name="Fdate" id="Fdate" value="{{ date('d-m-Y') }}" placeholder="Start Date" readonly>
																<span>จากวันที่</span>
															</div>
														</div>
														<div class="col-6">
															<div class="input-bx">
																<input type="text" class="form-control form-control-sm textSize-13" name="Tdate" id="Tdate" value="{{ date('d-m-Y') }}" placeholder="End Date" readonly>
																<span>ถึงวันที่</span>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="col-xxl-2 col-lg-12">
										<div class="position-relative h-100 hstack gap-3">
											<button type="button" id="btn_Stopvat" class="btn btn-secondary h-100 w-100"><i class="mdi mdi-filter-outline align-middle"></i> Filter</button>
											<button type="button" id="btn_reportStopvat" class="btn btn-success h-100 w-100 visually-hidden"><i class="bx bx-search-alt align-middle"></i> Report</button>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				{{-- body --}}
				<div class="card" id="show_data">
					<div class="d-flex justify-content-center m-5">
						<img class="img-fluid" src="{{ URL::asset('assets/images/undraw/undraw_user_flow.svg') }}" alt="Card image cap">
					</div>
				</div>
			</form>
			<script>
				$(document).ready(function() {
					var dataform = document.querySelectorAll('#form_Stopvat');
					var validate = validateForms(dataform);
					var saveBTN = document.querySelector('#btn_reportStopvat');
					var useerBox = document.querySelector('#username');
					var cardBox = document.querySelector('#card-radio');

					$('#btn_Stopvat').click(function() {
						if (validate == true) {
							$(".loading-overlay").fadeIn().attr('style', '');
							let data = {};
							$("#form_Stopvat").serializeArray().map(function(x) {
								data[x.name] = x.value;
							});

							$.ajax({
								url: "{{ route('account.index') }}",
								type: "GET",
								data: {
									page: 'summarize-vats',
									data: data,
									_token: "{{ @csrf_token() }}",
								},

								success: async function(response) {
									Swal.fire({
										icon: 'success',
										text: response.message,
										showConfirmButton: false,
										timer: 1500
									});

									if (response.res_data.length != 0) {
										saveBTN.classList.remove('visually-hidden');
										useerBox.classList.add('visually-hidden');
										cardBox.classList.remove('visually-hidden');
									} else {
										saveBTN.classList.add('visually-hidden');
									}

									$('#show_data').html(response.htmlEl).slideDown('slow');
									$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
								},
								error: async function(err) {
									$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
									Swal.fire({
										icon: 'error',
										title: `ERROR ` + err.status + ` !!!`,
										text: err.responseJSON.message,
										showConfirmButton: true,
									});
								}
							})
						}
					});

					// =====================================================================
					// expoert report													   =		
					// =====================================================================
					$("#btn_reportStopvat").click(function() {
						let data = {};
						$("#form_Stopvat").serializeArray().map(function(d) {
							data[d.name] = d.value;
						});

						// =====================================================================
						// check expoert 													   =		
						// =====================================================================
						if (Object.values(data).length == 9) {
							swal.fire({
								text: "Are you sure export data?",
								icon: "warning",
								showCancelButton: true,
								confirmButtonText: "Yes, export it!",
								cancelButtonText: "No, cancel!",
								reverseButtons: true
							}).then((result) => {
								if (result.isConfirmed) {
									$(".loading-overlay").fadeIn().attr('style', '');
									$.ajax({
										url: "{{ route('ReportAcc.create') }}",
										type: "GET",
										data: {
											data: data,
											report: 'Debtor',
											form: 'Account',
										},
										success: async function(res) {
											$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
											Swal.fire({
												icon: 'success',
												text: `export type ${data.export_type} successfully`,
												showConfirmButton: false,
												timer: 5500
											});
											window.open("{{ route('ReportAcc.create') }}" + "?" + new URLSearchParams(data), "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=100");
										},
										error: async function(err) {
											$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
											Swal.fire({
												icon: 'error',
												title: `ERROR ` + err.status + ` !!!`,
												text: err.responseJSON.message,
												showConfirmButton: true,
											});
										}
									});
								} else if (result.dismiss === Swal.DismissReason.cancel) {
									swal.fire({
										title: "Cancelled",
										text: "Your imaginary file is safe :)",
										icon: "error"
									});
								}
							});
						} else {
							Swal.fire({
								icon: 'error',
								text: 'กรุณาเลือกประเภทที่ต้องการ export',
								showConfirmButton: false,
								timer: 1500
							});
						}
					});
				});
			</script>
		@endsection
