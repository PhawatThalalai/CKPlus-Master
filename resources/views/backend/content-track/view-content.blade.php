@extends('layouts.master')
@section('title', 'Data Tracks')
@section('datatrack-active', 'mm-active')
@section('datatrack-p4-active', 'mm-active')
@section('page-frontend','d-none')

@section('content')
	<!--Bootstrap javascript plugins dragable-->
	<!-- <script src="{{ URL::asset('/assets/js/bootstrap-dialog.min.js') }}"></script> -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.4/font/bootstrap-icons.css">

	<style>
		.card-height {
			height: 360px;
		}

		@media only screen and (max-width: 1240px) {
			.card-height {
				height: auto;
			}
		}
	</style>
	<style>
		.hidden-input {
			display: none;
		}
	</style>

	@include('components.content-toast.view-toast')
	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])
	<!-- start page title -->
	@include('public-js.toggletab-profile')
	@component('components.breadcrumb')
		@slot('title')
			Track info
		@endslot
		@slot('title_small')
			(บันทึกติดตาม)
		@endslot
		@slot('btn_refresh')
			true
		@endslot
	@endcomponent

	<!-- end page title -->
	<div class="row">
		<div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 hidden-side-detail">
			@include('components.content-user.backend.view-profile-b-end', [
				'page' => 'contracts',
				'pact' => @$pact,
			])
		</div>

		<div id="col-display" class="col-xl-9 col-lg-12 col-md-12 col-sm-12">
			<div class="tab-content text-muted">
				<div class="tab-pane fade active show" id="data_home" role="tabpanel">
					@if (isset($contract))
						@include('components.content-contract.backend.card-contracts', ['contract' => @$contract, 'active_memo' => 'true'])
						<div class="">
							<div class="section bg-white p-1 mb-1">
								<ul class="nav nav-pills nav-fill bg-transparent " id="pills-tab" id="formTabs" role="tablist">
									<li class="nav-item me-1 tabLi" id="TRACK" role="presentation">
										<div class=" mini-stats-wid nav-link border border-primary  waves-effect waves-light active " id="step1-tab" role="tab" data-bs-toggle="tab" data-bs-target='#step1-tabpane' aria-controls="step1-tabpane" aria-selected="false">
											<div class="card-body">
												<div class="d-flex">
													<div class="flex-grow-1">
														<p class="fw-medium mb-2 fs-5">รายละเอียดติดตาม</p>
														<h6 class="mb-0">{{ @$contract->CONTNO }}</h6>
													</div>
													<div class="flex-shrink-0 align-self-center">
														<div class="mini-stat-icon avatar-sm rounded-circle">
															<span class="avatar-title bg-info bg-soft text-info font-size-24">
																<i class="bx bx-book-bookmark"></i>
															</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</li>
									<li class="nav-item me-1 tabLi" id="AROTHR" role="presentation">
										<div class="mini-stats-wid nav-link border border-primary   waves-effect waves-light" id="step2-tab" role="tab" data-bs-toggle="tab" data-bs-target='#step2-tabpane' aria-controls="step2-tabpane" aria-selected="false">
											<div class="card-body">
												<div class="d-flex">
													<div class="flex-grow-1">
														<p class="fw-medium mb-2 fs-5">รายละเอียดลูกหนี้อื่น</p>
														<h6 class="mb-0" id="TextAroth">{{ @$contract->PactToAroth->last()->ARCONT }}</h6>
													</div>
													<div class="flex-shrink-0 align-self-center" data-bs-toggle="tooltip" title="เพิ่มลูกหนี้อื่น">
														<a class="modal_lg hover-up" data-bs-toggle="modal" data-bs-target="#modal_lg" data-link="{{ route('datatrack.create') }}?page={{ 'create-aroth' }}&id={{ @$pact_id }}&loanType={{ @$loanType }}&Dcode={{ '601' }}" style="cursor:pointer;">
															<div class="mini-stat-icon avatar-sm rounded-circle">
																<span class="avatar-title bg-warning bg-soft text-warning font-size-24">
																	<i id="AR-icon" class="bx bx-money"></i>
																</span>
															</div>
														</a>
													</div>
												</div>
											</div>
										</div>
									</li>
									<li class="nav-item me-1 tabLi hidden-input" id="DEPOSIT" role="presentation">
										<div class="mini-stats-wid nav-link border border-primary waves-effect waves-light" id="step3-tab" role="tab" data-bs-toggle="tab" data-bs-target='#step3-tabpane' aria-controls="step3-tabpane" aria-selected="false">
											<div class="card-body">
												<div class="d-flex">
													<div class="flex-grow-1">
														<p class="fw-medium mb-2 fs-5">รับฝากค่างวด</p>
														<h6 class="mb-0" id="TextHDpayment">{{ @$contract->PactToHDpayment->last()->TEMPBILL }}</h6>
													</div>
													<div class="flex-shrink-0 align-self-center" data-bs-toggle="tooltip" title="เพิ่มรับฝากค่างวด">
														<a class="modal_lg hover-up" data-bs-toggle="modal" data-bs-target="#modal_lg" data-link="{{ route('datatrack.create') }}?page={{ 'create-deposit' }}&id={{ @$pact_id }}&loanType={{ @$loanType }}&Dcode={{ '602' }}" style="cursor:pointer;">
															<div class="mini-stat-icon avatar-sm rounded-circle">
																<span class="avatar-title bg-success bg-soft text-success font-size-24">
																	<i id="DP-icon" class="bx bx-dollar-circle"></i>
																</span>
															</div>
														</a>
													</div>
												</div>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
						<div class="tab-content" id="formTabsContent">
							<!-- <div class="card"> -->
							<div class="tab-pane fade active show" id="step1-tabpane" role="tabpanel" aria-labelledby="step1-tab" tabindex="0">
								<div class="bg-white section mb-1" style="padding-top:0px; padding-bottom:0px;height:420px;">
									<div class="row p-4">
										<div class="card-body mr-1">
											<div id="TrackDetails" class="mb-0">
												@include('backend.content-track.session-call.view-call')
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="step2-tabpane" role="tabpanel" aria-labelledby="step2-tab" tabindex="0">
								<div class="bg-white section mb-1" style="padding-top:0px; padding-bottom:0px;height:420px;">
									<div class="row p-4">
										<div class="card-body">
											<div id="ArotherDetails" class="mb-0">
												@include('backend.content-track.session-arother.view-arother', ['page' => 'VIEW-AROTH'])
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane fade" id="step3-tabpane" role="tabpanel" aria-labelledby="step3-tab" tabindex="0">
								<div class="bg-white section mb-1" style="padding-top:0px; padding-bottom:0px;height:420px;">
									<div class="row p-4">
										<div class="card-body">
											<div id="DepositDetails" class="mb-0">
												@include('backend.content-track.session-deposit.view-deposit')
											</div>
										</div>
									</div>
								</div>
							</div>
							<!-- </div> -->
						</div>
					@else
						<div class="card card-body">
							<div class="row justify-content-center">
								<div class="col-12">
									<div class="maintenance-img">
										<img src="{{ asset('assets/images/undraw/undraw_delivery.svg') }}" alt="" class="img-fluid mx-auto d-block" style="max-height: 570px;">
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
	<!-- end row -->

	<div class="modal fade" id="ModalToggle2" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
		<div class="modal-dialog modal-dialog2 modal-xl">
			<div class="modal-content border border-primary" id="Modal-drag" style="cursor:move;">
				<div data-role="header" class="modal-header bg-primary">
					<!-- <div class="flex-shrink-0 me-2">
																														<img src="{{ asset('assets/images/signature.png') }}" alt="" class="avatar-xs" style="width:50px;">
																										</div> -->
					<h5 data-role="title" class="modal-title Modal2-header" id="exampleModalToggleLabel2">
						<i class="mdi mdi-comment-edit-outline"></i>
						แก้ไขบันทึก
					</h5>
					<button type="button" id="CloseModal3" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div data-role="body" class="modal-body">
					<div class="row">
						<div class="col-md-12 col-lg-3 border-end col-sm-12 d-none d-xl-block">
							<img src="{{ URL::asset('assets/images/CK-location.png') }}" alt="" class="img-temp img-fluid mx-auto d-block mt-5" style="max-height: 25vh;opacity: 0.1;background-repeat: no-repeat;background-position:50%0;background-size: cover;">
						</div>
						<div class="col-md-12 col-lg-9">
							<form name="update-detail" id="update-detail" action="#" method="post" enctype="multipart/form-data" novalidate style="font-family: 'Prompt', sans-serif;">
								@csrf
								@method('put')
								<input type="hidden" id="ID" name="id">
								<input type="hidden" id="loanType" name="loanType" value="{{ @$loanType }}">
								<input type="hidden" id="ContractID" name="ContractID" value="{{ @$contract->id }}">
								<input type="hidden" id="PAGE" name="page" value="update-spastdetail">
								<div class="row g-2 mb-2">
									<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
										<div id="track-part" class="">
											<div class="row">
												<div class="col-12">
													<div class="mb-2  content-hide" id="datepicker1">
														<label for="formrow-firstname-input" class="form-label">วันที่นัด</label>
														<input type="text" name="DDATE" id="DDATE" value="" class="form-control text-start" placeholder="ป้อนวันที่นัด" min="{{ date('Y-m-d', strtotime('+1days')) }}" data-date-format="dd/mm/yyyy" data-date-container="#datepicker1" data-provide="datepicker" data-date-disable-touch-keyboard="true" data-date-language="th" data-date-today-highlight="true" data-date-enable-on-readonly="true" data-date-clear-btn="true" autocomplete="off" data-date-autoclose="true">
													</div>
												</div>
												<div class="col-12">
													<div class="mb-2  content-hide" id="appointment1">
														<label for="formrow-firstname-input" class="form-label">ยอดนัดชำระ</label>
														<input type="number" id="PAYDUE" name="PAYDUE" value="" class="form-control" placeholder="ป้อนยอด" />
														<input type="hidden" id="MinPay" name="MinPay" value="{{ @$data->MinPay }}" />
													</div>
												</div>
											</div>
										</div>
										<div class="mb-2">
											<label for="formrow-firstname-input" class="form-label">รายละเอียดติดตาม</label>
											<textarea class="form-control" placeholder="ลงบันทึก" name="NOTE" id="NOTE" maxlength="10000" style="height: 343px" title="รายละเอียดติดตาม" required></textarea>
										</div>
									</div>
									<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
										<div id="area-part" class="">
											<div class="mb-2 content-hide" id="datepicker2">
												<div class="row">
													<div class="col-9">
														<label for="formrow-firstname-input" class="form-label">วันที่ลงพื้นที่</label>
														<input type="text" name="DDATE2" id="DDATE2" value="" class="form-control text-start" placeholder="ป้อนวันที่ลงพื้นที่" min="{{ date('Y-m-d', strtotime('+1days')) }}" data-date-format="dd/mm/yyyy" data-date-container="#datepicker2" data-provide="datepicker" data-date-disable-touch-keyboard="true" data-date-language="th" data-date-today-highlight="true" data-date-enable-on-readonly="true" data-date-clear-btn="true" autocomplete="off" data-date-autoclose="true">
													</div>
													<div class="col-3">
														<label for="formrow-firstname-input" class="form-label" id="text-val-area">.</label>
														<input type="number" id="PAY_AREA" name="PAY_AREA" value="" class="form-control bg-gradient" readonly />
													</div>
												</div>
											</div>
											<div class="mb-2 content-hide" id="status_assets">
												<div class="row">
													<div class="col-12 mb-2">
														<label for="formrow-firstname-input" class="form-label">สถานะทรัพย์</label>
														<select class="form-select text-dark" id="STATUS_ASSET" name="STATUS_ASSET" data-bs-toggle="tooltip" title="ประเภทติดตาม" placeholder=" ">
															<option value="" selected>--- เลือกประเภท ---</option>
															<option value="เจอ">เจอ</option>
															<option value="ไม่เจอ">ไม่เจอ</option>
														</select>
													</div>
													<div class="col-12">
														<label for="formrow-firstname-input" class="form-label">สถานะลูกหนี้</label>
														<select class="form-select text-dark" id="STATUS_DEBT" name="STATUS_DEBT" data-bs-toggle="tooltip" title="สถานะลูกหนี้" placeholder=" ">
															<option value="" selected>--- เลือกประเภท ---</option>
															<option value="เจอ">เจอ</option>
															<option value="ไม่เจอ">ไม่เจอ</option>
														</select>
													</div>
												</div>

											</div>
											<div class="row">
												<div class="col-12">
													<div class="mb-2 content-hide" id="note_area1">
														<label for="formrow-firstname-input" class="form-label">รายละเอียดลงพื้นที่</label>
														<textarea class="form-control" placeholder="ลงบันทึก" name="NoteArea" id="NoteArea" maxlength="10000" style="height: 120px" title="รายละเอียดติดตาม"></textarea>
													</div>
												</div>
											</div>
											<div class="mb-2 content-hide" id="datepicker2">
												<div class="row">
													@if (@$loanType == 2)
														<div class="col-9">
															<div class="mb-2 content-hide" id="location">
																<label for="formrow-firstname-input" class="form-label">พิกัด</label>
																<div class="input-group">
																	<button id="ShowMaps" class="input-group-text bg-warning" type="button" data-bs-toggle="tooltip" title="แสดงแผนที่">
																		<i class="mdi mdi-map-legend"></i>
																	</button>
																	<input type="text" id="LATLONG" name="LATLONG" value="" class="form-control" placeholder="ป้อน ละติจูด,ลองจิจูด" />
																	<button id="BtnLocation2" class="input-group-text text-danger" type="button" data-bs-toggle="tooltip" title="ปักหมุดตำแหน่งปัจจุบัน">
																		<i class="mdi mdi-google-maps"></i>
																	</button>
																</div>
															</div>
															<div class="mb-2 content-hide" id="image_area">
																<label for="formrow-firstname-input" class="form-label">ลิงค์รูปลงพื้นที่</label>
																<div class="input-group">
																	<!-- <input type="file" name="IMAGE_AREA" class="form-control" id="inputGroupFile02"> -->
																	<input type="text" id="LINK_IMAGE" name="LINK_IMAGE" value="" class="form-control" placeholder="ป้อน ลิงค์รูปลงพื้นที่" />
																	<button class="input-group-text" type="button" data-bs-toggle="tooltip">
																		<i class="mdi mdi-link-variant"></i>
																	</button>
																</div>
															</div>

														</div>
														<div class="col-3">
															<div class="text-center" id="check_area">
																<div class="mb-3 mt-4">
																	<img id="ImageBrok" src="{{ URL::asset('assets/images/CK-location.png') }}" class="avatar-sm">
																</div>
																<div class="d-flex justify-content-center">
																	<input type="checkbox" id="switch1" switch="success" value="Y" name="FLAG" {{ @$data->AreaPay > 0 ? 'checked' : '' }}>
																	<label for="switch1" data-on-label="เปิด" data-off-label="ปิด"></label>
																</div>
																<p>ค่าลงพื้นที่</p>
															</div>
														</div>
													@else
														<div class="col-12">
															<div class="mb-2 content-hide" id="location">
																<label for="formrow-firstname-input" class="form-label">พิกัด</label>
																<div class="input-group">
																	<button id="ShowMaps" class="input-group-text bg-warning" type="button" data-bs-toggle="tooltip" title="แสดงแผนที่">
																		<i class="mdi mdi-map-legend"></i>
																	</button>
																	<input type="text" id="LATLONG" name="LATLONG" value="" class="form-control" placeholder="ป้อน ละติจูด,ลองจิจูด" />
																	<button id="BtnLocation2" class="input-group-text text-danger" type="button" data-bs-toggle="tooltip" title="ปักหมุดตำแหน่งปัจจุบัน">
																		<i class="mdi mdi-google-maps"></i>
																	</button>
																</div>
															</div>
															<div class="mb-2 content-hide" id="image_area">
																<label for="formrow-firstname-input" class="form-label">ลิงค์รูปลงพื้นที่</label>
																<div class="input-group">
																	<!-- <input type="file" name="IMAGE_AREA" class="form-control" id="inputGroupFile02"> -->
																	<input type="text" id="LINK_IMAGE" name="LINK_IMAGE" value="" class="form-control" placeholder="ป้อน ลิงค์รูปลงพื้นที่" />
																	<button class="input-group-text" type="button" data-bs-toggle="tooltip">
																		<i class="mdi mdi-link-variant"></i>
																	</button>
																</div>
															</div>

														</div>
													@endif
												</div>
											</div>

										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
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

	<script>
		$('.modal-content').resizable({
			minHeight: 300,
			minWidth: 300
		});
		$('.modal-dialog').draggable({
			handle: "#Modal-drag"
		});
	</script>

	{{-- icon on select tab --}}
	<script>
		$(document).on('click', '.tabLi', function(e) {
			var li = $(this).attr('id');
			if (li == 'AROTHR') {
				$("#AR-icon").removeClass("bx bx-money");
				$("#AR-icon").addClass("bx bxs-file-plus bx-tada");
				$("#DP-icon").removeClass("bx bxs-file-plus bx-tada");
				$("#DP-icon").addClass("bx bx-dollar-circle");
			} else if (li == 'DEPOSIT') {
				$("#DP-icon").removeClass("bx bx-dollar-circle");
				$("#DP-icon").addClass("bx bxs-file-plus bx-tada");
				$("#AR-icon").removeClass("bx bxs-file-plus bx-tada");
				$("#AR-icon").addClass("bx bx-money");
			} else {
				$("#AR-icon").removeClass("bx bxs-file-plus bx-tada");
				$("#AR-icon").addClass("bx bx-money");
				$("#DP-icon").removeClass("bx bxs-file-plus bx-tada");
				$("#DP-icon").addClass("bx bx-dollar-circle");
			}
		});
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
		document.addEventListener('keydown', function(event) {
			// Check if the shortcut key (e.g., Ctrl+H) is pressed
			if (event.ctrlKey && event.key === '/') {
				event.preventDefault(); // Prevent the default action (if any)
				const hiddenInputs = document.querySelectorAll('.hidden-input');
				hiddenInputs.forEach(input => {
					if (input.style.display === 'none' || input.style.display === '') {
						input.style.display = 'block';
					} else {
						input.style.display = 'none';
					}
				});
			}
		});
	</script>
@endsection
