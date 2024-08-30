@extends('layouts.master')
@section('title', 'TAKE-DOC')
@section('report-active', 'mm-active')
@section('report-track-active', 'mm-active')
@section('report-track-savePrintlet', 'mm-active')
@section('page-frontend', 'd-none')

@section('content')
	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])
	@include('public-js.constants')
	@component('components.breadcrumb')
		@slot('title')
			รายการขอเบิกเอกสาร (TAKE DOCUMENT)
		@endslot
		@slot('menu')
			ระบบขอเบิกเอกสาร
		@endslot
		@slot('sub_menu')
			รายการขอเบิกเอกสาร
		@endslot
	@endcomponent

	<form id="formsearchDOC" class="needs-validation" novalidate>
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
									<button type="submit" id="btnSave" class="btn btn-secondary waves-effect waves-light h-100 w-100"><i class="mdi mdi-filter-outline align-middle"></i> Filter</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>

	{{-- body --}}
	<div id="show_data">
		<div class="card">
			<div class="d-flex justify-content-center m-5">
				<img class="img-fluid" src="{{ URL::asset('assets/images/svg/verify.svg') }}" style="width: 400px;" alt="Card image cap">
			</div>
		</div>
	</div>
	<script>
		$(document).ready(function() {
			$("#formsearchDOC").submit(function(e) {
				try {
					e.preventDefault();

					let data = {};
					$("#formsearchDOC").serializeArray().map(function(x) {
						data[x.name] = x.value;
					});

					for (let key in data) {
						if (data[key] === '') {
							throw new Error(`กรุณากรอกข้อมูลให้ครบ`);
						}
					}

					$.ajax({
						url: "{{ route('takeDoc.index') }}",
						type: "GET",
						data: {
							data: data,
							page: 'list-reqtakeDoc',
							_token: "{{ csrf_token() }}",
						},
						success: function(res) {
							Swal.fire({
								position: "center",
								icon: "success",
								text: res.message,
								showConfirmButton: false,
								timer: 2000
							});
							$('#show_data').html(res.resHtml).slideDown('slow');
						},
						error: function(err) {
							Swal.fire({
								position: "center",
								icon: "error",
								text: 'ไม่สามารถดำเนินการได้',
								showConfirmButton: false,
								timer: 2000
							});
						}
					});
				} catch (error) {
					Swal.fire({
						position: "center",
						icon: "warning",
						text: error,
						showConfirmButton: false,
						timer: 2000
					});
				}
			});
		});
	</script>
@endsection
