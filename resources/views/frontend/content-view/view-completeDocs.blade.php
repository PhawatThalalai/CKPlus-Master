@extends('layouts.master')
@section('title', 'data-warehoure')
@section('Checkerloans-active', 'mm-active')
@section('audit-active', 'mm-active')
@section('data-warehoure-active', 'mm-active')
@section('page-backend', 'd-none')

@section('content')
	<style>
		/* .dateHide span{
									display:none;
			} */
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

	@component('components.content-date.date-range')
		@slot('data', [
			'page' => @$page,
			'Fdate' => @$Fdate1,
			'Tdate' => @$Tdate1,
			'statusTxt' => @$statusTxt,
			'status_cus' => @$status_cus,
			])
			@slot('btn', [
				'btn_statuscus' => false,
				'btn_print' => false,
				])
			@endcomponent

			<div class="row p-2 d-xl-none d-lg-none d-md-none">
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

					@pushOnce('scripts')
						<script>
							$(".viewWalkin1").DataTable({
								"responsive": false,
								"autoWidth": false,
								"ordering": true,
								"lengthChange": true,
								"order": [
									[0, "asc"]
								],
								"pageLength": 10,
							});
						</script>

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
					@endpushOnce
				@endsection
