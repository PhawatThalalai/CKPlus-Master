@extends('layouts.master')
@section('title', 'create contracts')
@section('center-p1-active', 'mm-active')
@section('page-frontend', 'd-none')

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
	<!-- <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"> -->
	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])
	@include('components.content-modal.modal-xl-2')
	@include('components.content-modal.modal-xl')

	@component('components.breadcrumb')
		@slot('title')
			contracts info
		@endslot
		@slot('title_small')
			(ข้อมูลลูกค้า)
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

			<input type="hidden" id="page" name="page" value="{{ @$page }}">

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
									@slot('buttonTitle')
										contrack
									@endslot
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
									@slot('buttonTitle')
										'contrack'
									@endslot
								@endcomponent
							</div>
						</div>
						<div class="col-xl-10 col-lg-10 col-md-9">
							<div class="tab-content" id="v-pills-tabContent">
								@component('components.content-page.welcome-content')
									@slot('title')
										ข้อมูลสัญญา
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

					{{-- <div class="row bg-danger">
		<div class="col-xl-2 col-md-3 shadow-sm p-2 d-none d-sm-none d-md-block">
			@component('components.content-branch.select-branch')
				@slot('data', [
    'dataBranch' => @$dataBranch,
    'countDataBranch' => @$countDataBranch,
])
				@slot('buttonTitle')
					'contrack'
				@endslot
			@endcomponent
		</div>
		<div class="col-xl col-md-9 p-2">
			<div class="tab-content" id="v-pills-tabContent">
				@component('components.content-page.welcome')
					@slot('title')
						ข้อมูลลูกค้า
					@endslot
				@endcomponent
				<div class="row">
					<div class="col" id="viewDataBranch">

					</div>
				</div>
			</div>
		</div>
	</div> --}}

					@pushOnce('scripts')
						<script>
							$(".createContract").DataTable({
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

								viewData(id[1], page, fdate, tdate, statusTxt);
								$(`.branchClickCard`).removeClass('btn btn-info text-white');
								$(`.activecard-${idName}`).addClass('btn btn-info text-white');
								$(`.branchClick`).removeClass('btn-info text-white');
								$(`.active-${idName}`).addClass('btn-info text-white');


							});
							viewData = (id, page, fdate, tdate, statusTxt) => {
								$('#viewDataBranch').hide();
								$(".content-loading").fadeIn().attr('style', ''); //** แสดงตัวโหลด **

								$.ajax({
									url: '{{ route('view-backend.store') }}',
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

						{{-- <script>
			$(document).on('click', '.data-modal-xl-2', function(e) {
                console.log('dfsdf');
				e.preventDefault();
				var url = $(this).attr('data-link');
				$('#modal_xl_2 .modal-xl').load(url);
			});
		</script> --}}
					@endpushOnce
				@endsection
