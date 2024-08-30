@extends('layouts.master')
@section('title', 'Payments')
@section('payments-active', 'mm-active')
@section('payments-paydue-active', 'mm-active')
@section('page-frontend', 'd-none')

@section('content')
	<style>
		.dataSearch-popover {
			--bs-popover-max-width: 300px;
			--bs-popover-border-color: var(--bs-white);
			--bs-popover-header-bg: var(--bs-info);
			--bs-popover-header-color: var(--bs-white);
			--bs-popover-body-padding-x: 1rem;
			--bs-popover-body-padding-y: .5rem;
		}
	</style>
	<style>
		/* Custom style swal to adjust text font size */
		.highlight-text-style {
			color: rgb(12, 180, 12);
			text-decoration: underline;
		}

		.highlight-text-alert {
			color: rgb(227, 25, 3);
			text-decoration: underline;
		}

		.text-title {
			font-size: 0.9rem;
		}
	</style>

	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'pageUrl' => 'payments', 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])
	@include('components.content-toast.view-toast')
	@include('backend.content-payments.scripts')
	@include('public-js.toggletab-profile')

	@component('components.breadcrumb')
		@slot('title')
			Payments info
		@endslot
		@slot('title_small')
			(รับชำระค่างวด)
		@endslot
		@slot('menu')
			ระบบการเงิน
		@endslot
		@slot('sub_menu')
			รับชำระค่างวด
		@endslot
	@endcomponent

	{{-- Modal ปิดบัญชี --}}
	@component('components.content-modal.modal-custom')
		@slot('data', [
			'id' => 'modal_closeAC',
			'class' => 'modal-lg',
			'btn_class' => 'closeAC_btn',
			])
		@endcomponent

		{{-- Modal ส่วนลดปิดบัญชี --}}
		@component('components.content-modal.modal-custom')
			@slot('data', [
				'id' => 'modal_discountAC',
				'class' => 'modal-lg',
				'btn_class' => 'discountAC_btn',
				])
			@endcomponent

			<div class="row">
				{{-- <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12" id="profile-container"></div> --}}
				<div class="col-xl-3 col-lg-12 col-md-12 col-sm-12">
					@include('components.content-user.backend.view-profile-b-end', [
						'page' => 'payments',
						'pact' => @$pact,
					])
				</div>
				<div class="col-xl-9 col-lg-12 col-md-12 col-sm-12">
					<div class="tab-content text-muted">
						<div class="tab-pane fade active show" id="data_home" role="tabpanel">
							@if (isset($contract))
								<div class="row g-2">
									<div class="col-lg-6 col-md-6 col-sm-12">
										<div class="view-contract pb-1">
											@include('components.content-contract.backend.card-contracts', ['contract' => @$contract, 'active_memo' => 'false'])
										</div>
										<div class="view-contentPay" style="display: none;"></div>
										<div class="row g-2 mt-n2 content_cardpay">
											<div class="col-12 placeholder-glow mb-3">
												<div class="section bg-white p-1 pt-2 mb-1">
													<ul class="nav nav-pills nav-fill bg-transparent " id="pills-tab" role="tablist">
														<li class="nav-item me-1" role="presentation">
															<div class=" mini-stats-wid nav-link border border-secondary waves-effect waves-light">
																<div class="card-body" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" data-bs-title="<p class='fw-semibold mb-0 d-flex flex-wrap align-items-center'><i class='bx bx-error-circle me-1'></i>รายละเอียดยอดรับชำระขั้นต่ำ</p>" data-bs-custom-class="dataSearch-popover" data-bs-content="
																	<div class='text-muted'>
																		<p class='mb-1 d-flex justify-content-between'>
																			<span><i class='mdi mdi-circle-medium align-middle text-primary me-1'></i> ยอดค่างวด :</span>
																			<span>{{ number_format(@$contract->ContractToSPASTDUE->MinPay, 2) }}</span>
																		</p>
																		<p class='mb-1 d-flex justify-content-between'>
																			<span><i class='mdi mdi-circle-medium align-middle text-primary me-1'></i> ยอดเบี้ยปรับ :</span>
																			<span>{{ number_format(@$ResultMinPay['totalIntAmt'], 2) }}</span>
																		</p>
																		<p class='mb-1 d-flex justify-content-between'>
																			<span><i class='mdi mdi-circle-medium align-middle text-primary me-1'></i> ยอดค่าทวงถาม :</span>
																			<span>{{ number_format(@$ResultMinPay['totalFollow'], 2) }}</span>
																		</p>
																	</div>">
																	<div class="d-flex">
																		<div class="flex-grow-1">
																			<p class="text-muted mb-2"><i class="mdi mdi-wallet me-1 text-warning fw-semibold"></i>ยอดขั้นต่ำ</p>
																			<h5 class="mb-0">
																				{{ number_format(@$contract->ContractToSPASTDUE->MinPay + (@$ResultMinPay['totalIntAmt'] + @$ResultMinPay['totalFollow']), 2) }}
																			</h5>
																		</div>
																		<div class="flex-shrink-0 align-self-center">
																			<div class="avatar-sm ms-auto">
																				<div class="avatar-title bg-light rounded-circle text-primary font-size-20">
																					<i class="bx bxs-message-square-dots"></i>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</li>
														<li class="nav-item me-1" role="presentation">
															<div class=" mini-stats-wid nav-link border border-secondary waves-effect waves-light">
																<div class="card-body">
																	<div class="d-flex">
																		<div class="flex-grow-1">
																			<p class="text-muted mb-2"><i class="mdi mdi-wallet me-1 text-warning fw-semibold"></i>ยอดทีมตาม</p>
																			<h5 class="mb-0">{{ number_format(@$contract->ContractToSPASTDUE->MustPay, 2) }}</h5>
																		</div>
																		<div class="flex-shrink-0 align-self-center">
																			<div class="avatar-sm ms-auto">
																				<div class="avatar-title bg-light rounded-circle text-primary font-size-20 icon_loadMustPay">
																					<i class="bx bx-rotate-right"></i>
																				</div>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</li>
													</ul>
												</div>
											</div>
										</div>
										<div class="row g-2 loading_content_cardpay" style="display: none;">
											<div class="col-12 placeholder-glow mb-3">
												<div class="section bg-white p-1 mb-1">
													<ul class="nav nav-pills nav-fill bg-transparent " id="pills-tab" role="tablist">
														<li class="nav-item me-1" role="presentation">
															<div class=" mini-stats-wid nav-link border border-secondary waves-effect waves-light " id="step1-tab" role="tab" data-bs-toggle="tab" data-bs-target="#step1-tab-pane" aria-controls="step1-tab-pane" aria-selected="true">
																<div class="card-body">
																	<div class="d-flex">
																		<div class="flex-grow-1">
																			<p class="fw-medium mb-2 fs-5"><span class="placeholder col-6"></span></p>
																			<h6 class="mb-0"><span class="placeholder col-6"></span></h6>
																		</div>
																		<div class="flex-shrink-0 align-self-center">
																			<div class="mini-stat-icon avatar-sm rounded-circle">
																				<span class="avatar-title bg-info bg-soft text-info font-size-24">
																				</span>
																			</div>
																		</div>
																	</div>
																</div>
															</div>
														</li>
														<li class="nav-item me-1" role="presentation">
															<div class=" mini-stats-wid nav-link border border-secondary waves-effect waves-light" id="step2-tab" role="tab" data-bs-toggle="tab" data-bs-target="#step2-tab-pane" aria-controls="step2-tab-pane" aria-selected="false" tabindex="-1">
																<div class="card-body">
																	<div class="d-flex">
																		<div class="flex-grow-1">
																			<p class="fw-medium mb-2 fs-5"><span class="placeholder col-6"></span></p>
																			<h6 class="mb-0"><span class="placeholder col-6"></span></h6>
																		</div>
																		<div class="flex-shrink-0 align-self-center">
																			<div class="mini-stat-icon avatar-sm rounded-circle">
																				<span class="avatar-title bg-warning bg-soft text-warning font-size-24">
																				</span>
																			</div>
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
									<div class="col-lg-6 col-md-6 col-sm-12">
										@include('backend.content-payments.section-view.view-duepay')
									</div>
								</div>

								<div class="row mt-n2">
									<div class="col-12">
										<div class="card">
											<div class="card-body">
												<div class="content-loading m-3" style="display: none !important">
													<br><br>
													<div class="lds-facebook mb-6">
														<div></div>
														<div></div>
														<div></div>
													</div>
												</div>
												<div class="view-tb-duepay">
													@if (@$contract->CODLOAN == 1)
														@include('backend.content-payments.section-view.view-tb-duepay')
													@else
														@include('backend.content-payments.section-view.view-tb-duepay-2')
													@endif
												</div>
											</div>
										</div>
									</div>
								</div>
							@else
								<div class="card card-body">
									<div class="row justify-content-center">
										<div class="col-12">
											<div class="maintenance-img">
												<img src="{{ asset('assets/images/bg-pays.png') }}" alt="" class="img-fluid mx-auto d-block" style="max-height: 600px;">
											</div>
										</div>
									</div>
								</div>
							@endif
						</div>
						<div class="tab-pane fade" id="data_contract_user" role="tabpanel">
							<div class="content_contract_user_loading">
								@include('backend.content-contract.section-loading.loading-user')
							</div>
							<div class="content_contract_user_nav" id="content_contract_user"> </div>
						</div>
						<div class="tab-pane fade" id="data_contract_details" role="tabpanel">
							<div class="content_contract_loading">
								@include('backend.content-contract.section-loading.loading-con')
							</div>
							<div class="content_contract_nav" id="content_contract"></div>

						</div>
						<div class="tab-pane fade" id="data_contract_lists" role="tabpanel">
							<div class="content_contract_poss_loading">
								@include('backend.content-contract.section-loading.loading-poss')
							</div>
							<div class="content_contract_poss_nav" id="content_contract_poss"> </div>
						</div>
					</div>
				</div>
			</div>

			<script>
				$(function() {
					document.querySelectorAll('[data-bs-toggle="popover"]')
						.forEach(popover => {
							new bootstrap.Popover(popover, {
								html: true,
							})
						})
				});
			</script>

			<script>
				$(document).on('click', '.constant-PAYTYP,.modal-constant', function(e) {
					e.preventDefault();
					var url = $(this).attr('data-link');

					// คำนวณค่า z-index ใหม่
					let zIndex = 1040 + 10 * $(".modal:visible").length;
					console.log(zIndex, $(".modal:visible").length);

					$('#modal_sd .modal-dialog').empty();
					$('#modal_sd .modal-dialog').load(url, function(response, status, xhr) {
						if (status === 'success') {
							// $('#modal_sd').css('z-index', zIndex + 1).modal('show');
							// $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
							$('#modal_sd').modal('show');

							// ใช้ setTimeout เพื่อให้แน่ใจว่าค่า z-index ถูกตั้งหลังจาก modal ถูกแสดง
							setTimeout(function() {
								$('.modal-backdrop').css('z-index', zIndex - 1).addClass('modal-stack');
								console.log("Backdrop zIndex set to: " + $('.modal-backdrop').css('z-index'));
							}, 0);
						} else {
							console.log('Load failed');
						}
					});

					$('#modal_sd').on('hidden.bs.modal', function(e) {
						var payTypValue = $('#PAYTYP_CODE').val();
						var dateinputPay = $('#BILLDT').val();

						if (payTypValue == '01') {
							if (dateinputPay != '{{ date('Y-m-d') }}') {
								$('#PAYTYP_CODE,#PAYTYP_NAME').val('');
								Swal.fire({
									icon: 'error',
									title: `ไม่สามารถดำเนินการ`,
									text: 'กรณีรับชำระเงินสด ต้องชำระเป็นวันปัจจุบันเท่านั้น !',
									showConfirmButton: true,
								});
								$('#CHQDT,#PAYINACC_NAME,#PAYINACC_CODE,#PAYINACC_NUMBER,#BANKNAME').val('');
								return; // Prevent further execution if the condition is met
							} else {
								$('#CHQDT,#PAYINACC_NAME,#PAYINACC_CODE,#PAYINACC_NUMBER,#BANKNAME').val('');
							}
						} else if (payTypValue == '04') {
							$('#CHQDT').val('{{ date('d-m-Y') }}');
						}
					});
				});

				$(document).on('click', '.constant-INACC,.constant-FOLCODE', function(e) {
					e.preventDefault();
					var url = $(this).attr('data-link');

					$('#modal_lg_2 .modal-dialog').empty();
					$('#modal_lg_2 .modal-dialog').load(url);
				});

				$(document).on('click', '.modal-overdue-paydue', function(e) {
					e.preventDefault();
					var url = $(this).attr('data-link');

					$('#modal_lg_2 .modal-dialog').empty();
					$('#modal_lg_2 .modal-dialog').load(url, function(response, status, xhr) {
						if (status === 'success') {
							$('#modal_lg_2').modal('show');
						} else {
							console.log('Load failed');
						}
					});
				});

				$(document).on('click', '.search-invoice', function(e) {
					e.preventDefault();
					var url = $(this).attr('data-link');

					$('#modal_xl .modal-dialog').empty();
					$('#modal_xl .modal-dialog').load(url, function(response, status, xhr) {
						console.log(response, status, xhr);
						if (status === 'success') {
							$('#modal_xl').modal('show');
						} else {
							console.log('Load failed');
						}
					});
				});
			</script>

			<script>
				$(function() {
					sessionStorage.setItem('DataPact_id', '{{ @$contract->DataPact_id }}')
					sessionStorage.setItem('DataCus_id', '{{ @$contract->DataCus_id }}')
					sessionStorage.setItem('PatchCon_id', '{{ @$contract->id }}')

					sessionStorage.removeItem("tab")

					// var tabId = sessionStorage.getItem('tabId');
					// var currentDataPactId = sessionStorage.getItem('DataPact_id');

					// if (!tabId || tabId !== currentDataPactId) {
					// 	sessionStorage.removeItem('profileLoaded-' + tabId);
					// 	tabId = currentDataPactId;
					// 	sessionStorage.setItem('tabId', tabId);
					// }

					// var profileHtml = sessionStorage.getItem('profileLoaded-' + tabId);

					// if (!profileHtml) {
					// 	let DataPact_id = '{{ @$contract->DataPact_id }}';
					// 	let url = "{{ route('contracts.show', ':ID') }}"
					// 	$.ajax({
					// 		url: url.replace(":ID", DataPact_id),
					// 		method: 'GET',
					// 		data: {
					// 			page: 'profile-content',
					// 			_token: "{{ @CSRF_TOKEN() }}"
					// 		},
					// 		success: function(data) {
					// 			profileHtml = data.html;
					// 			document.getElementById('profile-container').innerHTML = profileHtml;
					// 			sessionStorage.setItem('profileLoaded-' + tabId, profileHtml);
					// 		}
					// 	});
					// } else {
					// 	document.getElementById('profile-container').innerHTML = profileHtml;
					// }
				})


				$('.icon_loadMustPay').on('click', function() {
					$(this).html('<div class="spinner-border spinner-border-sm text-primary" role="status" data-bs-toggle="tooltip" title="loading..."></div>');
					// $.ajax({
					// 	url: '{{ route('payments.show', @$contract->id ?? 0) }}',
					// 	type: 'GET',
					// 	data: {
					// 		page: 'backend',
					// 		FlagBtn: 'MustPay',
					// 		CODLOAN: '{{ @$contract->CODLOAN }}',
					// 		CONTTYP: '{{ @$contract->CONTTYP }}',
					// 	},
					// 	success: function(data) {

					// 	},
					// 	error: function() {

					// 	},
					// 	complete: function() {
					// 		$(".toast-success").toast({
					// 			delay: 1500
					// 		}).toast("show");
					// 		$(".toast-success .toast-body .text-body").text('อัพเดทข้อมูลเรียบร้อยแล้ว');

					// 		$('.icon_loadMustPay').html('<i class="mdi mdi-history"></i>');
					// 	}
					// });
				});
			</script>

			<script>
				getTabNav = (tab) => {
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
			{{-- livewire --}}
			{{-- <script>
				window.addEventListener('swal:error', function(e) {
					Swal.fire(e.detail);
				});
				window.addEventListener('swal:success', function(e) {
					Swal.fire(e.detail);
				});
			</script>
			<script>
				window.addEventListener('close-modal', event => {
					$('.modal-data-xl').modal('hide');
				})
			</script>
			<script>
				document.addEventListener('livewire:load', function() {
					document.addEventListener('focus-input', event => {
						const input = document.getElementById(event.detail.id);
						input.focus();
					});
				});
			</script> --}}
		@endsection
