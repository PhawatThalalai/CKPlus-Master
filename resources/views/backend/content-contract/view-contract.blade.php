@extends('layouts.master')
@section('title', 'Contract')
@section('contract-p1-active', 'mm-active')
@section('page-frontend', 'd-none')

@section('content')
	@include('components.content-search.view-search', ['page_type' => $page_type, 'pageUrl' => @$pageUrl, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])
	@include('public-js.toggletab-profile')

	@component('components.breadcrumb')
		@slot('title')
			About Contract
		@endslot
		@slot('title_small')
			(รายละเอียดสัญญา)
		@endslot
	@endcomponent

	{{-- Modal แก้ไขสัญญา --}}
	@component('components.content-modal.modal-custom')
		@slot('data', [
			'id' => 'modal_editContract',
			'class' => 'modal-xl modal-dialog-scrollable',
			'btn_class' => 'editContract_btn',
			])
		@endcomponent

		<div class="row">
			<div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 hidden-side-detail">
				<div id="card-profile-b-end">
					@include('components.content-user.backend.view-profile-b-end', [
						'page' => 'contracts',
						'pact' => @$pact,
					])
				</div>
			</div>
			@if (@$contract != null)
				<div id="col-display" class="col-xl-9 col-lg-12 col-md-12 col-sm-12">
					<div class="tab-content text-muted">
						<div class="tab-pane fade active show" id="data_home" role="tabpanel">
							@include('backend.content-contract.section-content.contract-view')
						</div>
						<div class="tab-pane fade" id="data_contract_user" role="tabpanel">
							<div class="content_contract_user_loading">
								@include('backend.content-contract.section-loading.loading-user')
							</div>
							<div class="content_contract_user_nav" id="content_contract_user"> </div>
						</div>
						<div class="tab-pane fade" id="data_contract_details" role="tabpanel">
							....
						</div>
						<div class="tab-pane fade" id="data_contract_lists" role="tabpanel">
							<div class="content_contract_poss_loading">
								@include('backend.content-contract.section-loading.loading-poss')
							</div>
							<div class="content_contract_poss_nav" id="content_contract_poss"> </div>
						</div>
					</div>
				</div>
			@else
				<div id="col-display" class="col-xl-9 col-lg-12 col-md-12 col-sm-12">
					<div class="card card-body">
						<div class="row justify-content-center">
							<div class="col-12">
								<div class="maintenance-img">
									<img src="{{ asset('assets/images/emptycon.png') }}" alt="" class="img-fluid mx-auto d-block" style="max-height: 600px;">
								</div>
							</div>
						</div>
					</div>
				</div>
			@endif
		</div>

		<script>
			$(function() {
				sessionStorage.setItem('DataPact_id', '{{ @$contract->DataPact_id }}')
				sessionStorage.setItem('DataCus_id', '{{ @$contract->DataCus_id }}')
				sessionStorage.setItem('PatchCon_id', '{{ @$contract->id }}')
				sessionStorage.removeItem("tab")

			})
		</script>

		<script>
			$('.nav-item .mini-stat-icon').click(() => {
				$('.btn-point').removeClass('bg-info bg-soft text-info');
				$('.btn-point').addClass('bg-warning bg-soft text-warning')
				$('.btn-con').addClass('pe-none');
			})
			$('.btn-point').removeClass('bg-warning bg-soft text-warning');
			$('.btn-point').addClass('bg-info bg-soft text-info')
			$('.btn-con').addClass('pe-none');
		</script>

		<script>
			getTabNav = (tab) => {
				console.log('.' + tab + '_nav');
				console.log('.' + tab + '_loading');

				let getSessionview = sessionStorage.getItem('tab')
				let DataPact_id = sessionStorage.getItem('DataPact_id')

				if (tab != getSessionview) {
					$('.alink').css({
						"pointer-events": "none",
						"filter": "grayscale(100%)"
					});
					$('.' + tab + '_nav').hide()
					$('.' + tab + '_loading').show()


					url = "{{ route('contracts.show', ':ID') }}"
					$.ajax({
						url: url.replace(":ID", DataPact_id),
						type: "GET",
						data: {
							page: 'get-contentCon',
							tab: tab,
							_token: "{{ @CSRF_TOKEN() }}"
						},
						success: (res) => {
							$('.alink').css({
								"pointer-events": "",
								"filter": ""
							});
							$('.' + tab + '_nav').show()
							$('.' + tab + '_loading').hide()
							$('#' + tab).html(res.html)
							sessionStorage.setItem('tab', tab)

						},
						error: async (err) => {
							$('.alink').css({
								"pointer-events": "",
								"filter": ""
							});
							$('.' + tab + '_nav').show()
							$('.' + tab + '_loading').hide()


							sessionStorage.setItem('tab', tab)
							await swal.fire({
								icon: 'error',
								title: 'ERROR !',
								text: 'โหลดข้อมูลไม่สำเร็จ กรุณาตรวจสอบเครือข่าย หรือลองใหม่อีกครั้ง'
							})
							$('#icon_' + tab).trigger('click')
						}
					})
				} else {
					sessionStorage.removeItem('tab')
				}

			}
		</script>

		<script>
			document.addEventListener('keydown', function(event) {
				// Check if the shortcut key (e.g., Ctrl+H) is pressed
				if (event.ctrlKey && event.key === ',') {
					event.preventDefault(); // Prevent the default action (if any)
					const hiddenSides = document.querySelectorAll('.hidden-side-detail');
					const colDisplay = $("#col-display");
					hiddenSides.forEach(input => {
						if (input.style.display === 'block' || input.style.display === '') {
							input.style.display = 'none';
							colDisplay.removeClass('col-xl-9').addClass('col-xl-12');
						} else {
							input.style.display = 'block';
							colDisplay.removeClass('col-xl-12').addClass('col-xl-9');
						}
					});
				}
			});
			document.addEventListener('keydown', function(event) {
				// Check if the shortcut key (e.g., Ctrl+H) is pressed
				if (event.ctrlKey && event.key === '.') {
					// Get all hidden inputs
					const hiddenTabs = document.querySelectorAll('.hidden-tab-detail');
					hiddenTabs.forEach(input => {
						if (input.style.display === 'block' || input.style.display === '') {
							input.style.display = 'none';
						} else {
							input.style.display = 'block';
						}
					});
				}
			});
		</script>
	@endsection
