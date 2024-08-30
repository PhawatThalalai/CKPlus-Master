@extends('layouts.master')
@section('title', 'Save letter')
@section('report-active', 'mm-active')
@section('report-track-active', 'mm-active')
@section('report-track-savePrintlet', 'mm-active')
@section('page-frontend', 'd-none')

@section('content')
	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])
	@include('public-js.constants')
	@component('components.breadcrumb')
		@slot('title')
			บันทึกส่งจดหมาย (SAVE LETTER)
		@endslot
		@slot('menu')
			รายการลูกหนี้
		@endslot
		@slot('sub_menu')
			บันทึกส่งจดหมาย
		@endslot
	@endcomponent

	<style>
		.img-fluid {
			width: 350px;
		}
	</style>

	<form id="formsave_lettle" class="needs-validation" novalidate>
		<div class="row">
			<div class="col">
				<div class="card">
					<div class="card-body border-bottom">
						<div class="row g-3">
							<div id="con_in" class="col-xxl-5 col-lg-6">
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
									<input type="hidden" name="ID_LOCAT" class="ID_LOCAT" value="{{ auth()->user()->UserToBranch->id_Contract }}" required>
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
							</div>
							<div id="con_in2" class="col-xxl-5 col-lg-6">
								<div class="row g-2 mb-2">
									<div class="col-12">
										<div id="search_box">
											<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#search_box" data-date-format="dd-mm-yyyy" data-date-language="th">
												<div class="col-12">
													<div class="input-bx">
														<input type="text" class="form-control py-2 form-control-sm textSize-13" name="Fdate" id="Fdate" value="{{ date('d-m-Y') }}" placeholder="Start Date" readonly required>
														<span>จากวันที่</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="row g-2">
									<div class="col-12">
										<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#search_box" data-date-format="dd-mm-yyyy" data-date-language="th">
											<div class="col-12">
												<div class="input-bx">
													<input type="text" class="form-control py-2 form-control-sm textSize-13" name="Tdate" id="Tdate" value="{{ date('d-m-Y') }}" placeholder="End Date" readonly required>
													<span>ถึงวันที่</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div id="con_btn" class="col-xxl-2 col-lg-12">
								<div class="position-relative h-100 hstack gap-3">
									<button type="button" id="btnSave" class="btn btn-secondary waves-effect waves-light h-100 w-100"><i class="mdi mdi-filter-outline align-middle"></i> Filter</button>
									<button id="filterEdit" type="button" class="btn btn-warning waves-effect waves-light d-flex justify-content-center align-items-center visually-hidden h-100" style="width: 100%;">
										<div id="spinnerExport" class="spinner-border mx-2" role="status" style="width: 20px; height: 20px; display: none;">
											<span class="visually-hidden">Loading...</span>
										</div>
										<div>
											<i class="fas fa-highlighter"></i>
											<span id="Edit">Edit</span>
										</div>
									</button>
									<button id="subBtnExport" type="button" class="btn btn-primary waves-effect waves-light d-flex justify-content-center align-items-center visually-hidden h-100" style="width: 100%;">
										<div id="spinnerExport" class="spinner-border mx-2" role="status" style="width: 20px; height: 20px; display: none;">
											<span class="visually-hidden">Loading...</span>
										</div>
										<div>
											<i class="bx bx-printer"></i>
											<span>พิมพ์ใบนำส่ง</span>
										</div>
									</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		{{-- body --}}
		<div id="show_data">
			<div class="card">
				<div class="d-flex justify-content-center m-5">
					<img class="img-fluid" src="{{ URL::asset('assets/images/mockup/letter.png') }}" alt="Card image cap">
				</div>
			</div>
		</div>
	</form>
	<script>
		$(document).ready(function() {
			var dataform = document.querySelectorAll('#formsave_lettle');
			const formStyle = document.getElementById('con_in');
			const formStyle2 = document.getElementById('con_in2');
			var validate = validateForms(dataform);

			$("#btnSave").click(function() {
				$('#btnSave').prop('disabled', true);
				$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
				let data = {};
				$("#formsave_lettle").serializeArray().map(function(x) {
					data[x.name] = x.value;
				});

				if (validate == true) {
					$.ajax({
						url: "{{ route('letter.index') }}",
						type: "GET",
						data: {
							page: 'saveLet',
							data: data,
						},
						success: async function(res) {
							$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
							$('#filterEdit').removeClass('visually-hidden');
							$('#btnSave').prop('disabled', false);
							$("#con_btn").removeClass("col-xxl-2");
							formStyle.style.width = "50%";
							formStyle2.style.width = "50%";
							$('#show_data').html(res.resHtml).slideDown('slow');
						},
						error: async function(err) {
							$('#btnSave').prop('disabled', false);
							$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
							Swal.fire({
								icon: 'error',
								text: err.responseJSON.message,
								showConfirmButton: false,
								timer: 1500
							});
						}
					});
				}
			});
		});
	</script>
@endsection
