@extends('layouts.master')
@section('title', 'Import Payments')
@section('payments-active', 'mm-active')
@section('payments-auto-active', 'mm-active')
@section('autopaylist-active', 'mm-active')
@section('page-frontend', 'd-none')

@section('content')
	<link rel="stylesheet" href="{{ URL::asset('assets/css/datepicker-custom.css') }}">

	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])
	@component('components.breadcrumb')
		@slot('title')
			รายการนำเข้า
		@endslot
		@slot('title_small')
			(list payments)
		@endslot
		@slot('menu')
			ระบบการเงิน
		@endslot
		@slot('sub_menu')
			ระบบตัดเงินอัตโนมัติ
		@endslot
	@endcomponent

	<div class="row search-box-top mb-1">
		<div class="col-12">
			<div class="float-sm-end d-sm-flex align-items-center">
				<div class="search-box">
					<div class="position-relative" id="search_box">
						<div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#search_box" data-date-format="dd-mm-yyyy" data-date-language="th">
							<select name="typestatusPay" id="typestatusPay" class="form-control rounded-pill me-2 shadow-sm" style="border:none;">
								<option value="">--- รายการ ---</option>
								<option value="Y">สัญญาที่ตรวจสอบพบ</option>
								<option value="N">สัญญาที่ตรวจสอบไม่พบ</option>
							</select>

							<input type="text" class="form-control shadow-sm me-2" name="start" id="start" value="{{ date('d-m-Y') }}" placeholder="Start Date" autocomplete="off" style="border:none; border-radius:25px;" readonly>
							<input type="text" class="form-control shadow-sm" name="end" id="end" value="{{ date('d-m-Y') }}" placeholder="End Date" autocomplete="off" style="border:none; border-radius:25px;" readonly>
						</div>
					</div>
				</div>
				<div class="">
					<ul class="nav nav-pills product-view-nav justify-content-center mt-sm-0">
						<li class="nav-item">
							<div class="list-inline-item user-chat-nav btn-history">
								<div class="dropdown" data-bs-toggle="tooltip" title="ค้นหา">
									<button id="btn_searchData" class="btn nav-btn section bg-white bg-soft shadow-sm hover-up" type="submit" aria-haspopup="true" aria-expanded="false">
										<i class="bx bx-search-alt"></i>
									</button>
								</div>
							</div>
						</li>
						<li class="nav-item">
							<div class="list-inline-item user-chat-nav">
								<div class="dropdown" data-bs-toggle="tooltip" title="พิมพ์">
									<button class="btn nav-btn section bg-white bg-soft hover-up" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="bx bx-printer"></i>
									</button>
									<div class="dropdown-menu p-1">
										<div class="d-grid gap-1">
											<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 3 }}" class="btn btn-warning border border-white btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">1. รายงานอนุมัติสินเชื่อ</a>
											<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 4 }}" class="btn btn-warning border border-white btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">2. รายงานตามเลขที่สัญญา</a>
											<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 6 }}" class="btn btn-warning border border-white btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">3. รายงานตามยอดจัดรวม</a>
											<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 3 }}" class="btn btn-warning border border-white btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">1. รายงานยอดจัด</a>
											<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 2 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">2. รายงานสัญญา</a>
											<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 1 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">3. รายงานตามเลขที่สัญญา</a>
											<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 3 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">4. รายงานอนุมัติสินเชื่อ</a>
											<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 7 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">5. รายงานการทำประกัน</a>
											<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 8 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">6. รายงานPrivot</a>
											<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 9 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">7. อส 4ข.</a>
										</div>
									</div>
								</div>
							</div>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col" id="content_data">
			{{-- body --}}
			<div class="card" id="welcome_page">
				<div class="d-flex justify-content-center m-5">
					<img class="img-fluid" src="{{ URL::asset('assets/images/undraw/undraw_user_flow.svg') }}" alt="Card image cap">
				</div>
			</div>
		</div>
	</div>

	<script>
		$('#btn_searchData').click(function() {
			$(".loading-overlay").fadeIn().attr('style', '');

			let typestatusPay = $('#typestatusPay').val();
			let fdate = $('#start').val();
			let tdate = $('#end').val();

			$.ajax({
				url: "{{ route('view-backend.store') }}",
				method: "POST",
				data: {
					typestatusPay: typestatusPay,
					fdate: fdate,
					tdate: tdate,
					page: 'imp-payslist',
					_token: "{{ @csrf_token() }}",
				},
				success: function(result) {
					$(".loading-overlay").fadeOut().attr('style', 'display:none !important');

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
				}
			})
		});
	</script>
@endsection
