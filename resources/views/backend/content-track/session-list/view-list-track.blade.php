@extends('layouts.master')
@section('title', 'Task Group')
@section('datatrack-active', 'mm-active')
@section('datatrack', 'mm-active')
@section(@$mmactive, 'mm-active')
@section('page-frontend', 'd-none')
@include('public-js\reRender')
@section('content')

	@include('components.content-toast.view-toast')
	@component('components.breadcrumb')
		@slot('title')
			{{ @$title }} ( {{ @$page }} )
		@endslot
		@slot('menu')
			ระบบลูกหนี้
		@endslot
		@slot('sub_menu')
			{{ @$title }}
		@endslot
	@endcomponent
	<style>
		div.dataTables_processing div {
			display: none;
		}

		div.dataTables_processing {
			background-color: transparent;
		}
	</style>

	<input type="hidden" value="{{ $GroupType }}" id="GroupType">
	<div class="row">
		<div class="card bg-light">
			<div style="cursor: pointer; overflow: auto;  height: auto;" class="scroll">
				<div class="d-flex pt-2">
					@component('components.content-card.card-Allbranch')
						@slot('data', [
							'id_branch' => 'allBranch',
							])
						@endcomponent
						@foreach ($branch as $item)
							@php
								$pass = $item->BillCollToViewSpash
								    ->whereIn('GroupingType', explode(',', $GroupType))
								    ->where('GroupingState', 'Y')
								    ->filter(function ($query) {
								        return $query->stdept == 'ผ่าน';
								    });
							@endphp
							@component('components.content-card.card-branch')
								@slot('data', [
									'index' => $loop->iteration,
									'NickName_Branch' => $item->code_billcoll,
									'Name_Branch' => $item->name_billcoll,
									'count' => $item->BillCollToViewSpash->whereIn('GroupingType', explode(',', $GroupType))->where('GroupingState', 'Y')->count('LOCAT') ?? 0,
									'percent' => count($pass) > 0 ? (count($pass) / $item->BillCollToViewSpash->whereIn('GroupingType', explode(',', $GroupType))->where('GroupingState', 'Y')->count('LOCAT')) * 100 : 0,
									'id_branch' => $item->id,
									'permiss_billcoll' => (isset($permissBillcoll[$item->id]) && $permissBillcoll[$item->id] == $item->id) || auth()->user()->branch == $item->UserBranch ? 'active' : '',
									])
								@endcomponent
							@endforeach
						</div>
					</div>
				</div>
			</div>
			<div class="row mb-2">
				<div class="col-12">
					<div id="shortcut">
						@include('backend.content-track.session-list.shortCut')
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xl-12">
					<div class="card">
						<div class="card-body">
							<div class="row px-2">
								<div class="col">
									<div id="content-filter">
										@include('backend.content-track.session-list.view-filter')
									</div>
									<div id="contentDebt" class="justify-content-center" style="display: flex;">
										<img src="{{ asset('assets/images/undraw/imgDebtlist.svg') }}" alt="" style="width : 40%">
									</div>
									<div id="contentTable" style="display: none; ">
										@include('backend.content-track.session-list.view-table')
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<script>
				$(function() {
					$('.contents').removeClass('container-fluid')
					$('.contents').addClass('px-4')

				})
			</script>

			<script>
				$('.btn-filter').click(() => {
					$('#filter').slideToggle(500)
				})

				$('.btn-search').click(() => {
					$('.result-filter').slideToggle(500)
				})
			</script>

			<script>
				$('.card-branch').click((e) => {
					if ($(e.currentTarget).attr('card-active') != 'active') {
						$(".toast-error").toast({
							delay: 3000
						}).toast("show");
						$(".toast-error .toast-body .text-body").text('คุณไม่มีสิทธิดูข้อมูลสาขานี้ !');

						return false;
					}

					let GroupType = $('#GroupType').val()
					$('#spinnerLoading').show()
					let branch = $(e.currentTarget).attr('card-id')
					$(".createContract").DataTable({
						processing: true, // for show progress bar,
						"language": {
							'processing': `
                            <span class="">
                                <span id="loading-spinner-ck" >
                                <img src="{{ URL::asset('/assets/images/CK-LOGO3.png') }}" alt=""  class="t rounded-circle" alt="">
                                <span class="spinner outer">
                                    <span class="spinner inner">
                                        <span class="spinner eye">
                                            <span >
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </span>
                        </span>`
						},

						pageLength: 10,
						processing: true,
						serverSide: true,
						searching: true,
						ordering: true,
						columnDefs: [{
							orderable: false,
							targets: "no-sort"
						}],
						ajax: {
							url: '{{ route('spast.store') }}',
							type: 'POST',
							data: {
								page: 'searchBranch',
								BranchDebt: branch,
								GroupType: GroupType,
								_token: '{{ @csrf_token() }}'
							}

						},
						columns: [{
								data: 'CONTNO',
								"className": "bg-info bg-soft fw-semibold text-secondary"
							},
							{
								data: 'stdept'
							},
							{
								data: 'Name_Cus'
							},
							{
								data: 'BILLCOLL'
							},
							{
								data: 'DUEDATE'
							},
							{
								data: 'SWEXPPRD'
							},
							{
								data: 'INSTALL'
							},
							{
								data: 'Appointment'
							},
							{
								data: 'trackFollow'
							},
						],
						bDestroy: true,
						drawCallback: function(res) {
							console.log(res._iRecordsTotal);
							// $('#spinnerLoading').hide()
							if (res._iRecordsTotal != 0) {
								$('#contentTable').show();
								$('#contentDebt').hide();
							} else {
								$('#contentTable').hide();
								$('#contentDebt').show();
							}
						}
					});
				})
			</script>

			<script>
				shortcut = (nameshortcut, GroupType, elements) => {
					$(this).removeClass('btn-secondary btn-soft-secondary')
					$(".createContract").DataTable({
						processing: true, // for show progress bar,
						"language": {
							'processing': `
                            <span class="">
                                <span id="loading-spinner-ck" >
                                <img src="{{ URL::asset('/assets/images/CK-LOGO3.png') }}" alt=""  class="t rounded-circle" alt="">
                                <span class="spinner outer">
                                    <span class="spinner inner">
                                        <span class="spinner eye">
                                            <span >
                                            </span>
                                        </span>
                                    </span>
                                </span>
                            </span>
                        </span>`
						},

						pageLength: 10,
						processing: true,
						serverSide: true,
						searching: true,
						ordering: true,
						columnDefs: [{
							orderable: false,
							targets: "no-sort"
						}],
						ajax: {
							url: '{{ route('spast.store') }}',
							type: 'POST',
							data: {
								page: 'shortcut',
								GroupType: GroupType,
								nameshortcut: nameshortcut,
								_token: '{{ @csrf_token() }}'
							}

						},
						columns: [{
								data: 'CONTNO',
								"className": "bg-info bg-soft fw-semibold text-secondary"
							},
							{
								data: 'stdept'
							},
							{
								data: 'Name_Cus'
							},
							{
								data: 'BILLCOLL'
							},
							{
								data: 'DUEDATE'
							},
							{
								data: 'SWEXPPRD'
							},
							{
								data: 'INSTALL'
							},
							{
								data: 'Appointment'
							},
							{
								data: 'trackFollow'
							},
						],
						bDestroy: true,
						drawCallback: function(res) {
							$('.btn-shortCut').removeClass('btn-soft-info').addClass('btn-soft-secondary')
							$('#' + elements).removeClass('btn-soft-secondary').addClass('btn-soft-info')
							if (res._iRecordsTotal != 0) {
								$('#contentTable').show();
								$('#contentDebt').hide();
							} else {
								$('#contentTable').hide();
								$('#contentDebt').show();
							}
						}
					});
				}
			</script>

			<script>
				$('.card-branch').click((e) => {
					$('.card-branch').removeClass('bg-info bg-soft')
					$(e.currentTarget).addClass('bg-info bg-soft')
					$('.btn-shortCut').removeClass('btn-soft-info').addClass('btn-soft-secondary')

				})
			</script>

			<script>
				$(document).on('click', '.Modal-xl', function(e) {
					e.preventDefault();
					var url = $(this).attr('data-link');
					$('#Modal-xl .modal-dialog').load(url);
				});
			</script>

			<script>
				$(".animated-progress span").each(function() {
					$(this).animate({
							width: $(this).attr("data-progress") + "%",
						},
						1000
					);
					$(this).text($(this).attr("data-progress") + "%");
				});
			</script>

			{{-- mouse scroll-slide --}}
			<script>
				document.querySelector('.scroll').addEventListener('wheel', (e) => {
					e.preventDefault();
					const delta = e.deltaY || e.detail || e.wheelDelta;
					document.querySelector('.scroll').scrollLeft += delta;
				});
			</script>

		@endsection
