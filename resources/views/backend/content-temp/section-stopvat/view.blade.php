@extends('layouts.master')
@section('title', 'account')
@section('account-active', 'mm-active')
@section('account-sub1-active', 'mm-active')
@section('account-p1-active', 'mm-active')
@section('page-frontend', 'd-none')

@section('content')
	<style>
		.more__option {
			padding: 5px 10px;
			margin-top: -7px;
			border-radius: 5px;
			background: #9a8c98;
		}

		.con__more {
			display: flex;
		}

		.icon {
			color: #fff;
			font-weight: 500;
		}

		.countRow {
			height: 35px;
			width: 75px;
			display: flex;
			font-size: 18px;
			justify-content: center;
			align-items: center;
			margin-top: -7px;
			margin-right: -7px;
			border-radius: 5px;
			background: #F5F5F5;
			color: #4361ee;
			font-weight: 500;
		}

		@media (max-width: 992px) {
			.more__option {
				margin: 5px 0 5px 0;
				display: flex;
				justify-content: center;
				align-content: center;
			}

			.countRow {
				width: 100%;
				margin: 5px 0 5px 0;
				margin-right: -7px;
			}
		}
	</style>
	@include('public-js.constants')
	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])
	@component('components.breadcrumb')
		@slot('title')
			บันทึกหยุดรับรู้รายได้ตามดิว
		@endslot
		@slot('menu')
			บัญชี
		@endslot
		@slot('sub_menu')
			บันทึกรับรู้รายได้
		@endslot
	@endcomponent
	@include('components.content-loading.spinner')
	<form id="form_Stopvat" class="needs-validation" novalidate>
		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-body border-bottom">
						<div class="row g-3">
							<div class="col-xxl-6 col-lg-6">
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

								<div class="row g-2">
									<div class="col">
										<div class="input-bx">
											<input type="text" value="" name="CONTNO" class="form-control" placeholder="" />
											<span>เลขที่สัญญา</span>
										</div>
									</div>
								</div>
								{{-- <div class="row visually-hidden">
									<div class="col-12">
										<div class="input-bx">
											<input type="text" name="CONTNO" value="" class="form-control border-danger" required placeholder=" " />
											<span>เลขที่สัญญา</span>
										</div>
									</div>
								</div> --}}
							</div>
							<div class="col-xxl-6 col-lg-6">
								<div class="row g-2 mb-2">
									<div class="col-6">
										<div class="d-flex text-danger">
											<h5 class="font-size-13 fw-semibold bx-fade-right"><i class="bx bxs-bell font-size-18"></i> ต้องทำปรับปรุงงวดก่อนทุกครั้ง !</h5>
										</div>
									</div>
									<div class="col-6">
										<div class="input-bx">
											<input type="number" name="NOPAY" value="3" class="form-control text-end border-danger" placeholder=" " />
											<span>สำหรับลูกหนี้มากกว่าหรือเท่ากับ</span>
											<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">
												งวด
											</button>
										</div>
									</div>
								</div>
								<div class="row g-2">
									<div class="col-6">
										<div class="input-bx">
											<select id="type_loan" name="type_loan" class="form-select text-dark border-danger" data-bs-toggle="tooltip" required placeholder=" ">
												<option value="" selected>-- ประเภทสินเชื่อ --</option>
												<option value="HP">สินเชื่อเช่าซื้อ (HP)</option>
												<option value="PSL">สินเชื่อเงินกู้ (PSL)</option>
											</select>
											<span>ประเภทสินเชื่อ</span>
										</div>
									</div>
									<div class="col-6">
										<div class="input-bx">
											<input type="date" name="DATEVAT" value="{{ date('Y-m-d') }}" class="form-control border-danger" required placeholder=" " />
											<span>วันที่หยุด</span>
										</div>
									</div>
								</div>
							</div>
							<div style="margin-top: 10px;" class="col-12">
								<div class="card__radio_display_full gap-3">
									@php
										$card_radio_data = [
										    [
										        'icon-url' => 'https://cdn.lordicon.com/jzvoyjzb.json',
										        'icon-color' => 'primary:#1d6f42,secondary:#ebe6ef',
										        'icon-stroke' => 'bold',
										        'sub-icon' => 'fas fa-biking',
										        'radio-name' => 'saveType',
										        'btn-name' => 'บันทึกหยุดรับรู้รายได้ตามดิว',
										        'btn-value' => 'stopvats',
										        'btn-checked' => true,
										        'color' => 'info',
										        'width' => 'full',
										    ],
										    [
										        'icon-url' => 'https://cdn.lordicon.com/jzvoyjzb.json',
										        'icon-color' => 'primary:#dc2f02,secondary:#ebe6ef',
										        'icon-stroke' => 'bold',
										        'sub-icon' => 'fas fa-biking',
										        'radio-name' => 'saveType',
										        'btn-name' => 'ยกเลิกหยุดรับรู้รายได้ตามดิว',
										        'btn-value' => 'cancel-stopvats',
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

										<div class="con__more visually-hidden">
											<div class="countRow"> </div>
											<div class="more__option dropdown ms-auto" data-bs-toggle="tooltip" title="เพิ่มเติม">
												<a class="text-muted font-size-16" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
													<i class="mdi mdi-dots-horizontal icon"></i>
												</a>
												<div class="dropdown-menu dropdown-menu-end">
													<a id="selectAll" class="dropdown-item d-flex justify-content-between pe-auto" role="button">
														เลือกทั้งหมด <i class="mdi mdi-format-list-checks fs-5 text-info"></i>
													</a>
													<a id="ClearselectAll" class="dropdown-item d-flex justify-content-between pe-auto" role="button">
														ล้างค่า <i class="mdi mdi-format-list-checks fs-5 text-info"></i>
													</a>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div style="margin-top: 0px;" class="col-12">
									<div class="position-relative h-100 hstack gap-3">
										<button type="button" id="btn_Stopvat" class="btn btn-secondary h-100 w-100"><i class="mdi mdi-filter-outline align-middle"></i> Filter</button>
										<button type="button" id="btn_saveStopvat" class="btn btn-success h-100 w-100 visually-hidden"><i class='bx bx-save align-middle'></i> Save</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div>
				<div class="bar"><span class="percent"></span></div>
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

				// $('.card-input-type').click((e)=>{
				//     alert($(e.currenTarget).attr("name"))
				// })
				$('#btn_Stopvat').click(function() {
					var dataform = document.querySelectorAll('#form_Stopvat');
					var loading = document.getElementById('staticBackdrop');
					var radioEl = document.getElementById('radio_id');
					var saveBTN = document.querySelector('#btn_saveStopvat');
					var moreEL = document.querySelector('.con__more');
					var validate = validateForms(dataform);

					let data = {};
					$("#form_Stopvat").serializeArray().map(function(x) {
						data[x.name] = x.value;
					});

					if (validate == true) {
						if (data.saveType) {
							$(".countRow").text(('0'));
							// $('#staticBackdrop').modal('show');
							$(".loading-overlay").fadeIn().attr('style', '');
							savetype_data = data.saveType;

							$.ajax({
								url: "{{ route('account.index') }}",
								type: "GET",
								data: {
									page: 'stopcont-vats',
									data: data,
									_token: "{{ @csrf_token() }}",
								},

								success: async function(response) {
									$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
									//await $('#staticBackdrop').modal('hide');
									Swal.fire({
										icon: 'success',
										text: response.message,
										showConfirmButton: false,
										timer: 1500
									});

									if (response.data_res.length != 0) {
										saveBTN.classList.remove('visually-hidden');
										saveBTN.disabled = false;
										moreEL.classList.remove('visually-hidden');
									}

									$('#show_data').html(response.htmlEl).slideDown('slow');
								},
								error: function(err) {
									$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
									Swal.fire({
										icon: 'error',
										title: `ERROR ` + err.status + ` !!!`,
										text: err.responseJSON.message,
										showConfirmButton: true,
									});

									$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
								}
							})
						} else {
							Swal.fire({
								icon: 'error',
								text: 'กรุณาเลือกรายการบันทึกรับรู้รายได้',
								showConfirmButton: true,
							})
						}
					}
				});
			});
		</script>
	@endsection
