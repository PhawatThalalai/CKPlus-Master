@extends('layouts.master')
@section('title', 'Checklist')
@section('Checkerloans-active', 'mm-active')
@section('audit-active', 'mm-active')
@section('credit-loans-active', 'mm-active')
@section('page-backend', 'd-none')

@section('content')
	<style>
		.dateHide p {
			display: none;
		}

		.h-loading {
			/* height: 500px;
					min-height: 500px; */
			top: 30%;
		}
	</style>

	{{-- setup search --}}
	@include('components.content-search.view-search', ['page_type' => @$page_type, 'page' => @$page, 'pageUrl' => @$pageUrl, 'typeSreach' => @$typeSreach, 'dataSreach' => @$dataSreach])
	@component('components.breadcrumb')
		@slot('title')
			{{ $title }}
		@endslot
		@slot('title_small')
			{{ $title_small }}
		@endslot
		@slot('menu')
			ระบบ ตรวจสอบสินเชื่อ
		@endslot
		@slot('sub_menu')
			รายการ ตรวจสอบ
		@endslot
	@endcomponent

	<div class="row p-2 d-xl-none d-lg-none d-md-none">
		<div class="row g-2">
			<div class="col-6">
				<div class="d-grid gap-2">
					<button type="button" class="btn btn-success waves-effect btn-label waves-light data-modal-xl-2 btn-rounded me-1 text-truncate" data-link="{{ route('audit.create') }}?page={{ 'Receive-Contracts' }}" data-bs-toggle="tooltip" title="กล่องรับเอกสาร">
						<span class="label-icon"><span class="badge bg-danger prem countReceived-all">{{ @$countReceived }}</span></span> กล่องรับเอกสาร
					</button>
				</div>
			</div>
			<div class="col-6">
				<div class="d-grid gap-2">
					<button type="button" class="btn btn-warning waves-effect btn-label waves-light data-modal-xl-2 btn-rounded text-truncate" data-link="{{ route('audit.create') }}?page={{ 'edited-Contracts' }}" data-bs-toggle="tooltip" title="เอกสารแก้ไขแล้ว">
						<span class="label-icon"><span class="badge bg-danger prem countReject-all">{{ @$countEdited }}</span></span> เอกสารแก้ไขแล้ว
					</button>
				</div>
			</div>
		</div>
		<div class="card shadow-sm p-3 bg-light">
			<h5 class="font-size-14"><b>สาขาทั้งหมด (All Branch)</b></h5>
			<div style="cursor: pointer; overflow: auto;  height: auto;" class="scroll-slide">
				<div id="container">
					@component('components.content-branch.card-branch')
						@slot('data', [
							'dataBranch' => @$dataBranch,
							'countDataBranch' => @$countDataBranch,
							])
						@endcomponent
					</div>
				</div>
			</div>
		</div>

		<div class="row mt-1">
			<div class="col-xl-2 col-lg-2 col-md-3 shadow-sm d-none d-sm-none d-md-block">
				<div class="row g-2">
					<div class="col-6">
						<div class="d-grid gap-2">
							<button type="button" class="btn btn-success waves-effect btn-label waves-light data-modal-xl-2 btn-rounded me-1 text-truncate" data-link="{{ route('audit.create') }}?page={{ 'Receive-Contracts' }}" data-bs-toggle="tooltip" title="กล่องรับเอกสาร">
								<span class="label-icon"><span class="badge bg-danger prem countReceived-all">{{ @$countReceived }}</span></span> กล่องรับเอกสาร
							</button>
						</div>
					</div>
					<div class="col-6">
						<div class="d-grid gap-2">
							<button type="button" class="btn btn-warning waves-effect btn-label waves-light data-modal-xl-2 btn-rounded text-truncate" data-link="{{ route('audit.create') }}?page={{ 'edited-Contracts' }}" data-bs-toggle="tooltip" title="เอกสารแก้ไขแล้ว">
								<span class="label-icon"><span class="badge bg-danger prem countReject-all">{{ @$countEdited }}</span></span> เอกสารแก้ไขแล้ว
							</button>
						</div>
					</div>
				</div>

				<div class="mt-1">
					@component('components.content-branch.select-branch')
						@slot('data', [
							'dataBranch' => @$dataBranch,
							'countDataBranch' => @$countDataBranch,
							])
						@endcomponent
					</div>
				</div>
				<div class="col-xl-10 col-lg-10 col-md-9">
					<div class="tab-content" id="v-pills-tabContent">
						@component('components.content-page.welcome-select')
							@slot('title')
								ข้อมูลลูกค้า
							@endslot
						@endcomponent
						<div class="content-loading" style="display: none !important">
							<div class="lds-facebook h-loading">
								<div></div>
								<div></div>
								<div></div>
							</div>
						</div>
						<div class="col" id="viewDataBranch"></div>
					</div>
				</div>
			</div>

			<input type="hidden" id="page" name="page" value="{{ @$page }}">

			@pushOnce('scripts')
				<script>
					$('.branchClick,.branchClickCard').click(function() {
						var idName = $(this).attr("id");
						var id = idName.split("-");
						var page = $('#page').val();
						var fdate = $('#start').val();
						var tdate = $('#end').val();
						var statusTxt = $('#statusTxt').val();
						var BranchChk = $("#id_branch").val();

						if (idName != 'tabs-' + BranchChk) {
							viewData(id[1], page, fdate, tdate, statusTxt);
						}

						$(`.branchClickCard`).removeClass('btn btn-info text-white');
						$(`.activecard-${idName}`).addClass('btn btn-info text-white');
						$(`.branchClick`).removeClass('btn-info text-white');
						$(`.active-${idName}`).addClass('btn-info text-white');
					});

					viewData = (id, page, fdate, tdate, statusTxt) => {
						$('#viewDataBranch').hide();
						$(".content-loading").fadeIn().attr('style', ''); //** แสดงตัวโหลด **

						$.ajax({
							url: '{{ route('view.store') }}',
							type: 'POST',
							data: {
								page: page,
								id: id,
								start: fdate,
								end: tdate,
								statusTxt: statusTxt,
								_token: "{{ @csrf_token() }}",
							},
							success: (response) => {
								$(".content-loading").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
								$('#viewDataBranch').html(response.html).slideDown('slow');
							}
						});
					}
				</script>

				<script>
					function BranchSent(form) {
						//console.log($('#'+form).closest("form").attr('id'));
						// var data = $('#'+form).serialize(); 
						var _token = $('input[name="_token"]').val();
						var type = '1';
						var data = new Array();
						$('input[name="Branch_Sentdoc[]"]:checked').each(function() {
							data.push($(this).val());
						});

						Swal.fire({
							title: 'ใส่วิธีการจัดส่ง',
							icon: 'warning',
							input: 'text',
							inputAttributes: {
								autocapitalize: 'off'
							},
							showCancelButton: true,
							confirmButtonText: 'ส่งเอกสาร',
							showLoaderOnConfirm: true,
							preConfirm: (dataSend) => {
								var sentVal = $('#sentVal').val();
								var type = 2;
								if (dataSend != "") {
									$.ajax({
										url: '{{ route('audit.store') }}',
										method: "POST",
										dataType: 'json',
										data: {
											_token: _token,
											type: 'send',
											data: data,
											textSend: dataSend
										},

										success: function(result) {
											if (result.flag == 'success') {
												for (var key in result.dataStatus) {
													var statustxt = '#Statustxt' + result.dataStatus[key];
													var Branch_Sentdoc = '#Branch_Sentdoc' + result.dataStatus[key];
													var tranfer = '.tranfer' + result.dataStatus[key];
													$(Branch_Sentdoc).hide();
													$(Branch_Sentdoc).prop('checked', false);
													$(statustxt).text("ส่งเอกสาร");
													$(tranfer).text(result.tranfer);

												}
												swal.fire({
													text: "ส่งเรียบร้อย",
													icon: "success",
													timer: 1500,
												});
											}
										}
									});
								}
							}
						});
					}
				</script>

				<script>
					document.querySelector('.scroll-slide').addEventListener('wheel', (e) => {
						e.preventDefault();
						const delta = e.deltaY || e.detail || e.wheelDelta;
						document.querySelector('.scroll-slide').scrollLeft += delta;
					});
				</script>
			@endpushOnce
		@endsection
