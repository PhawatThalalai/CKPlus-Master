@extends('layouts.master')
@section('title', 'account')
@section('account-active', 'mm-active')
@section('account-sub2-active', 'mm-active')
@section('account-p6-active', 'mm-active')
@section('page-frontend', 'd-none')
@section('content')
	<style>
		@media (max-width: 428px) {
			.custom-btn {
				width: auto !important;
				/* Override the w-sm width */
			}
		}
	</style>
	<link rel="stylesheet" href="{{ URL::asset('assets/css/datepicker-custom.css') }}">

	@include('backend.content-temp.section-terminate.script')
	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])
	@component('components.breadcrumb')
		@slot('title')
			บันทึกหนังสือยืนยันบอกเลิกสัญญา
		@endslot
		@slot('menu')
			บัญชี
		@endslot
		@slot('sub_menu')
			หนังสือยืนยันบอกเลิกสัญญา
		@endslot
	@endcomponent
	<form id="form_terminate" class="needs-validation" novalidate>
		@csrf
		<div class="row">
			<div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 d-none d-xl-block">
				<div id="card-1" class="card">
					<div class="card-body">
						<div class="d-flex justify-content-center m-5">
							<img class="img-fluid" src="{{ URL::asset('assets/images/undraw/undraw_resume_folder.svg') }}" style="height:31vh;" alt="Card image cap">
						</div>
					</div>
				</div>
				<div id="card-2" class="card d-none">
					<div class="card-body">
						<h4 class="card-title text-muted mb-2 bg-info bg-opacity-10 text-center">Contract Information</h4>
						<div>
							<ul class="list-unstyled mb-0">
								<li>
									<div class="d-flex border-info border-bottom border-opacity-25 py-1">
										<i class="bx bx-analyse text-primary fs-4"></i>
										<div class="ms-2 d-flex flex-fill">
											<h6 class="fs-14 mb-0 fw-semibold me-auto">เลขที่สัญญา</h6>
											<p class="text-primary fs-14 mb-0">
												{{ @$data['contract'] }}
												502302019999
											</p>
										</div>
									</div>
								</li>
								<li class="">
									<div class="d-flex border-info border-bottom border-opacity-25 py-1">
										<i class="bx bx-map text-primary fs-4"></i>
										<div class="ms-2 d-flex flex-fill">
											<h6 class="fs-14 mb-0 fw-semibold me-auto">สาขา</h6>
											<p class="text-muted fs-14 mb-0">
												CKT - สำนักงานใหญ่
											</p>
										</div>
									</div>
								</li>
								<li class="">
									<div class="d-flex border-info border-bottom border-opacity-25 py-1">
										<i class="bx bx-layer text-primary fs-4"></i>
										<div class="ms-2 d-flex flex-fill">
											<h6 class="fs-14 mb-0 fw-semibold me-auto">ประเภทสัญญา</h6>
											<p class="text-muted fs-14 mb-0">
												{{ @$data['NameCon'] }}
												@if (!empty(@$data['typeCon']))
													( {{ @$data['typeCon'] }} )
												@endif
												เงินกู้รถยนต์ ( 02 )
											</p>
										</div>
									</div>
								</li>
							</ul>
						</div>
						<h4 class="card-title text-muted mb-2 mt-4 bg-info bg-opacity-10 text-center">Personal Information</h4>
						<div data-simplebar style="max-height: 230px;cursor: pointer;">
							<ul class="list-unstyled m-0">
								<li>
									<div class="d-flex border-info border-bottom border-opacity-25 py-1">
										<i class="bx bx-user-circle text-primary fs-4"></i>
										<div class="ms-2 d-flex flex-fill">
											<h6 class="fs-14 mb-0 fw-semibold me-auto">ชื่อ-นามสกุล</h6>
											<div class="d-flex flex-column">
												<p class="text-muted fs-14 mb-0 text-end">
													นายเกรียงไกร ชีพนุรัตน์ (เป)
												</p>
												<span class="text-primary fw-bold text-end">
													Kriangkral
												</span>
											</div>

										</div>
									</div>
								</li>
								<li class="">
									<div class="d-flex border-info border-bottom border-opacity-25 py-1">
										<i class="bx bx-id-card text-primary fs-4"></i>
										<div class="ms-2 d-flex flex-fill">
											<h6 class="fs-14 mb-0 fw-semibold me-auto">เลขประจำตัวประชาชน</h6>
											<p class="text-muted fs-14 mb-0">
												1-8402-00015-27-4
											</p>
										</div>
									</div>
								</li>
							</ul>
						</div>
						<h4 class="card-title text-muted mb-2 mt-4 bg-info bg-opacity-10 text-center">Asset Information</h4>
						<div>
							<ul class="list-unstyled m-0">
								<li>
									<div class="d-flex border-info border-bottom border-opacity-25 py-1">
										<i class="bx bx-car text-primary fs-4"></i>
										<div class="ms-2 d-flex flex-fill">
											<h6 class="fs-14 mb-0 fw-semibold me-auto">เลขทะเบียน</h6>
											<div class="d-flex flex-column">
												<span class="me-1" data-bs-toggle="tooltip" data-bs-html="true" aria-label="ป้ายเดิม" title="ป้ายเดิม">
													<i class="mdi mdi-card-bulleted-outline h5 text-success"></i> ผฉ5310 สฎ
												</span>
												<span class="me-1" data-bs-toggle="tooltip" data-bs-html="true" aria-label="ป้ายใหม่" title="ป้ายใหม่">
													<i class="mdi mdi-card-bulleted-outline h5 text-success"></i> ผฉ5310 สฎ
												</span>
											</div>
										</div>
									</div>
								</li>
								<li class="">
									<div class="d-flex border-info border-bottom border-opacity-25 py-1">
										<i class="bx bx-search-alt text-primary fs-4"></i>
										<div class="ms-2 d-flex flex-fill">
											<h6 class="fs-14 mb-0 fw-semibold me-auto">เลขตัวถัง</h6>
											<p class="text-muted fs-14 mb-0">
												MP1TFR86H7T176854
											</p>
										</div>
									</div>
								</li>
								<li class="">
									<div class="d-flex border-info border-bottom border-opacity-25 py-1">
										<i class="bx bx-purchase-tag-alt text-primary fs-4"></i>
										<div class="ms-2 d-flex flex-fill">
											<h6 class="fs-14 mb-0 fw-semibold me-auto">ราคาขาย</h6>
											<p class="text-muted fs-14 mb-0">
												100,000 ฿
											</p>
										</div>
									</div>
								</li>
							</ul>
						</div>
						<h4 class="card-title text-muted mb-2 mt-4 bg-info bg-opacity-10 text-center">Payment Information</h4>
						<div>
							<ul class="list-unstyled m-0">
								<li>
									<div class="d-flex border-info border-bottom border-opacity-25 py-1">
										<i class="bx bx-money text-primary fs-4"></i>
										<div class="ms-2 d-flex flex-fill">
											<h6 class="fs-14 mb-0 fw-semibold me-auto">ชำระเงินแล้ว</h6>
											<p class="text-muted fs-14 mb-0">
												100,000 ฿
											</p>
										</div>
									</div>
								</li>
								<li class="">
									<div class="d-flex border-info border-bottom border-opacity-25 py-1">
										<i class="bx bx-dollar-circle text-primary fs-4"></i>
										<div class="ms-2 d-flex flex-fill">
											<h6 class="fs-14 mb-0 fw-semibold me-auto">ยอดคงเหลือ</h6>
											<p class="text-muted fs-14 mb-0">
												100,000 ฿
											</p>
										</div>
									</div>
								</li>
								<li class="">
									<div class="d-flex border-info border-bottom border-opacity-25 py-1">
										<i class="bx bx-money text-danger fs-4"></i>
										<div class="ms-2 d-flex flex-fill">
											<h6 class="fs-14 mb-0 fw-semibold me-auto">ยอดค้างชำระ</h6>
											<p class="text-muted fs-14 mb-0">
												100,000 ฿
											</p>
										</div>
									</div>
								</li>
							</ul>
						</div>

						<div id="carouselExampleIndicators" class="carousel carousel-dark h-100 slide d-none" data-interval="false" style="min-height: 28rem; max-height: 28rem;">
							<div class="carousel-indicators m-0">
								<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
								<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
							</div>
							<div class="carousel-inner">
								<div class="carousel-item p-2 active">
									<h4 class="card-title text-muted mb-3">Contract Information</h4>
									<div>
										<ul class="list-unstyled">
											<li>
												<div class="d-flex bg-info bg-opacity-10 py-1">
													<i class="bx bx-analyse text-primary fs-4"></i>
													<div class="ms-2 d-flex flex-fill">
														<h6 class="fs-14 mb-0 fw-semibold me-auto">เลขที่สัญญา</h6>
														<p class="text-primary fs-14 mb-0">
															{{ @$data['contract'] }}
															502302019999
														</p>
													</div>
												</div>
											</li>
											<li class="">
												<div class="d-flex py-1">
													<i class="bx bx-map text-primary fs-4"></i>
													<div class="ms-2 d-flex flex-fill">
														<h6 class="fs-14 mb-0 fw-semibold me-auto">สาขา</h6>
														<p class="text-muted fs-14 mb-0">
															CKT - สำนักงานใหญ่
														</p>
													</div>
												</div>
											</li>
											<li class="">
												<div class="d-flex bg-info bg-opacity-10 py-1">
													<i class="bx bx-layer text-primary fs-4"></i>
													<div class="ms-2 d-flex flex-fill">
														<h6 class="fs-14 mb-0 fw-semibold me-auto">ประเภทสัญญา</h6>
														<p class="text-muted fs-14 mb-0">
															{{ @$data['NameCon'] }}
															@if (!empty(@$data['typeCon']))
																( {{ @$data['typeCon'] }} )
															@endif
															เงินกู้รถยนต์ ( 02 )
														</p>
													</div>
												</div>
											</li>

											{{--
											<li>
												<div class="d-flex">
													<i class="bx bx-analyse text-primary fs-4"></i>
													<div class="ms-3">
														<h6 class="fs-14 mb-2 fw-semibold">เลขที่สัญญา</h6>
														<p class="text-primary fs-14 mb-0">
															{{ @$data['contract'] }}
															502302019999
														</p>
													</div>
												</div>
											</li>

											<li class="mt-3">
												<div class="d-flex">
													<i class="bx bx-map text-primary fs-4"></i>
													<div class="ms-3">
														<h6 class="fs-14 mb-2 fw-semibold">สาขา</h6>
														<p class="text-muted fs-14 mb-0">
															CKT - สำนักงานใหญ่
														</p>
													</div>
												</div>
											</li>

											<li class="mt-3">
												<div class="d-flex">
													<i class="bx bx-layer text-primary fs-4"></i>
													<div class="ms-3">
														<h6 class="fs-14 mb-2 fw-semibold">ประเภทสัญญา</h6>
														{{ @$data['NameCon'] }}
														@if (!empty(@$data['typeCon']))
															( {{ @$data['typeCon'] }} )
														@endif
														เงินกู้รถยนต์ ( 02 )
													</div>
												</div>
											</li>
											--}}

										</ul>
									</div>
									<h4 class="card-title text-muted mb-3">Personal Information</h4>
									<div data-simplebar style="max-height: 230px;cursor: pointer;">
										<ul class="list-unstyled">
											<li>
												<div class="d-flex bg-info bg-opacity-10 py-1">
													<i class="bx bx-user-circle text-primary fs-4"></i>
													<div class="ms-2 d-flex flex-fill">
														<h6 class="fs-14 mb-0 fw-semibold me-auto">ชื่อ-นามสกุล</h6>
														<div class="d-flex flex-column">
															<p class="text-muted fs-14 mb-0 text-end">
																นายเกรียงไกร ชีพนุรัตน์ (เป)
															</p>
															<span class="text-primary fw-bold text-end">
																Kriangkral
															</span>
														</div>

													</div>
												</div>
											</li>
											<li class="">
												<div class="d-flex py-1">
													<i class="bx bx-id-card text-primary fs-4"></i>
													<div class="ms-2 d-flex flex-fill">
														<h6 class="fs-14 mb-0 fw-semibold me-auto">เลขประจำตัวประชาชน</h6>
														<p class="text-muted fs-14 mb-0">
															1-8402-00015-27-4
														</p>
													</div>
												</div>
											</li>
										</ul>
									</div>
									<h4 class="card-title text-muted mb-3">Asset Information</h4>
									<div>
										<ul class="list-unstyled">
											<li>
												<div class="d-flex bg-info bg-opacity-10 py-1">
													<i class="bx bx-car text-primary fs-4"></i>
													<div class="ms-2 d-flex flex-fill">
														<h6 class="fs-14 mb-0 fw-semibold me-auto">เลขทะเบียน</h6>
														<div class="d-flex flex-column">
															<span class="me-1" data-bs-toggle="tooltip" data-bs-html="true" aria-label="ป้ายเดิม" title="ป้ายเดิม">
																<i class="mdi mdi-card-bulleted-outline h5 text-success"></i> ผฉ5310 สฎ
															</span>
															<span class="me-1" data-bs-toggle="tooltip" data-bs-html="true" aria-label="ป้ายใหม่" title="ป้ายใหม่">
																<i class="mdi mdi-card-bulleted-outline h5 text-success"></i> ผฉ5310 สฎ
															</span>
														</div>
													</div>
												</div>
											</li>
											<li class="">
												<div class="d-flex py-1">
													<i class="bx bx-map text-primary fs-4"></i>
													<div class="ms-2 d-flex flex-fill">
														<h6 class="fs-14 mb-0 fw-semibold me-auto">สาขา</h6>
														<p class="text-muted fs-14 mb-0">
															CKT - สำนักงานใหญ่
														</p>
													</div>
												</div>
											</li>
											<li class="">
												<div class="d-flex bg-info bg-opacity-10 py-1">
													<i class="bx bx-layer text-primary fs-4"></i>
													<div class="ms-2 d-flex flex-fill">
														<h6 class="fs-14 mb-0 fw-semibold me-auto">ประเภทสัญญา</h6>
														<p class="text-muted fs-14 mb-0">
															{{ @$data['NameCon'] }}
															@if (!empty(@$data['typeCon']))
																( {{ @$data['typeCon'] }} )
															@endif
															เงินกู้รถยนต์ ( 02 )
														</p>
													</div>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<div class="carousel-item p-2">
									<h4 class="card-title text-muted mb-3">Asset Information</h4>
									<div data-simplebar style="max-height: 230px;cursor: pointer;">
										<ul class="list-unstyled">

											<li>
												<div class="d-flex">
													{{ @$asset_icon }}
													<i class="bx bx-car text-primary fs-4"></i>

													<div class="ms-3">
														<h6 class="fs-14 mb-2 fw-semibold">{{ @$asset_data['title'] }} เลขทะเบียน</h6>
														@if (@$asset_data['title'] == 'เลขทะเบียน')
															<span class="me-1" data-bs-toggle="tooltip" data-bs-html="true" aria-label="ป้ายเดิม" title="ป้ายเดิม">
																<i class="mdi mdi-card-bulleted-outline h5 text-success"></i> {{ @$asset_data['value'] }}
															</span>
														@else
															{{ @$asset_data['value'] }}
														@endif

														<span class="me-1" data-bs-toggle="tooltip" data-bs-html="true" aria-label="ป้ายใหม่" title="ป้ายใหม่">
															<i class="mdi mdi-card-bulleted-outline h5 text-success"></i> ผฉ5310 สฎ
														</span>

													</div>
												</div>
											</li>

											<li class="mt-3">
												<div class="d-flex">
													<i class="bx bx-search-alt text-primary fs-4"></i>
													<div class="ms-3">
														<h6 class="fs-14 mb-2 fw-semibold">เลขตัวถัง</h6>
														MP1TFR86H7T176854
													</div>
												</div>
											</li>

											<li class="mt-3">
												<div class="d-flex">
													<i class="bx bx-purchase-tag-alt text-primary fs-4"></i>
													<div class="ms-3">
														<h6 class="fs-14 mb-2 fw-semibold">ราคาขาย</h6>
														<p class="text-muted fs-14 mb-0">
															100,000 ฿
														</p>
													</div>
												</div>
											</li>

										</ul>
									</div>
									<h4 class="card-title text-muted mb-3">Payment Information</h4>
									<div data-simplebar style="max-height: 230px;cursor: pointer;">
										<ul class="list-unstyled">
											<li>
												<div class="d-flex">
													<i class="bx bx-money text-primary fs-4"></i>
													<div class="ms-3">
														<h6 class="fs-14 mb-2 fw-semibold">ชำระเงินแล้ว</h6>
														<p class="text-muted fs-14 mb-0">
															100,000 ฿
														</p>
													</div>
												</div>
											</li>
											<li class="mt-3">
												<div class="d-flex">
													<i class="bx bx-dollar-circle text-primary fs-4"></i>
													<div class="ms-3">
														<h6 class="fs-14 mb-2 fw-semibold">ยอดคงเหลือ</h6>
														<p class="text-muted fs-14 mb-0">
															100,000 ฿
														</p>
													</div>
												</div>
											</li>
											<li class="mt-3">
												<div class="d-flex">
													<i class="bx bx-money text-danger fs-4"></i>
													<div class="ms-3">
														<h6 class="fs-14 mb-2 fw-semibold">ยอดค้างชำระ</h6>
														<p class="text-muted fs-14 mb-0">
															100,000 ฿
														</p>
													</div>
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev" style="left: -1.5rem;">
								<span class="carousel-control-prev-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Previous</span>
							</button>
							<button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next" style="right: -1.5rem;">
								<span class="carousel-control-next-icon" aria-hidden="true"></span>
								<span class="visually-hidden">Next</span>
							</button>
						</div>

					</div>
				</div>
			</div>

			<div class="col-xl-9 col-lg-12 col-md-12 col-sm-12">
				<div id="info">
					@include('backend.content-temp.section-terminate.info')
				</div>
				<div class="d-flex flex-wrap flex-row-reverse gap-1">
					<button type="button" id="PrintBTN" class="btn btn-info waves-effect waves-light w-sm custom-btn" disabled>
						<span class="d-block d-sm-none"><i class="mdi mdi-printer-settings"></i></span>
						<span class="d-none d-sm-block"><i class="mdi mdi-printer-settings d-block"></i> พิมพ์</span>
					</button>
					<button id="CancleBTN" type="button" class="btn btn-danger waves-effect waves-light w-sm custom-btn" disabled>
						<span class="d-block d-sm-none"><i class="mdi mdi-book-cancel-outline"></i></span>
						<span class="d-none d-sm-block"><i class="mdi mdi-book-cancel-outline d-block"></i> ยกเลิก</span>
					</button>
					<button id="SaveBTN" type="button" class="btn btn-success waves-effect waves-light w-sm custom-btn" disabled>
						<span class="d-block d-sm-none"><i class="mdi mdi-book-arrow-down-outline"></i></span>
						<span class="d-none d-sm-block"><i class="mdi mdi-book-arrow-down-outline d-block"></i> บันทึก</span>
					</button>
					<button type="button" class="btn btn-dark waves-effect waves-light w-sm custom-btn header_btnSearch2">
						<span class="d-block d-sm-none"><i class="mdi mdi-account-search"></i></span>
						<span class="d-none d-sm-block"><i class="mdi mdi-account-search d-block"></i> สอบถาม</span>
					</button>
				</div>
			</div>
		</div>
	</form>

	<div id="myModal" class="modal fade show" tabindex="-1" aria-labelledby="myModalLabel" aria-modal="true" role="dialog">
		<div class="modal-dialog">
			<form name="formAdd" id="formAdd" action="#" method="post" enctype="multipart/form-data" novalidate>
				@csrf
				<input type="hidden" id="md_loanType" name="md_loanType" value="{{ @$loanType }}">
				<input type="hidden" id="md_pact_id" name="md_pact_id" value="{{ @$pact->id }}">
				<div class="modal-content">
					<div class="d-flex m-3 mb-0" id="Modal-drag" style="cursor:move;">
						<div class="flex-shrink-0 me-2">
							<img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
						</div>
						<div class="flex-grow-1 overflow-hidden">
							<h4 class="text-primary fw-semibold">บันทึกก่อนพิมพ์</h4>
							<p class="text-muted mt-n1">หนังสือยืนยันบอกเลิกสัญญา</p>
							<p class="border-primary border-bottom mt-n2"></p>
						</div>
						<!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
					</div>
					<div class="modal-body mt-n4">
						<div class="row">
							<div class="col-md-12 col-lg-6">
								<div class="d-flex justify-content-center m-5">
									<img class="img-fluid" src="{{ URL::asset('assets/images/undraw/undraw_resume_folder.svg') }}" style="height:25vh;" alt="Card image cap">
								</div>
							</div>
							<div class="col-md-12 col-lg-6">
								<div class="row g-2 mb-2">
									<div class="col-12 col-md-12">
										<div class="input-bx">
											<input type="date" id="DatePrint" name="DatePrint" value="{{ date('Y-m-d') }}" class="form-control" placeholder=" " required />
											<span>วันที่พิมพ์</span>
										</div>
									</div>
								</div>
								<div class="row g-2 mb-2">
									<div class="col-12 col-md-12">
										<div class="input-bx">
											<input type="text" id="DateTerminate" name="DateTerminate" class="form-control" placeholder=" " readonly />
											<span>วันที่บอกเลิก</span>
										</div>
									</div>
								</div>
								<div class="row g-2 mb-2">
									<div class="col-12 col-md-12">
										<div class="form-floating">
											<textarea class="form-control" placeholder="Leave a comment here" id="Note" name="Note" maxlength="2500" style="height: 10rem;"></textarea>
											<label for="Note_cus" class="text-muted">หมายเหตุ</label>
										</div>
									</div>
								</div>
								<div class="row g-2 mb-2">
									<div class="col-12 col-md-12">
										<div class="input-bx">
											<input type="text" id="DateTerminate" name="DateTerminate" class="form-control" placeholder=" " readonly />
											<span>วันที่บอกเลิก</span>
										</div>
									</div>
								</div>
								<div class="row g-2 mb-2">
									<div class="col-12 col-md-12">
										<div class="input-bx">
											<input type="text" id="NameStaff" name="NameStaff" class="form-control" placeholder=" " />
											<span>เจ้าหน้าที่</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer mt-n3">
						<button type="button" id="PrintData" data-id="{{ @$pact_id }}" class="btn btn-primary btn-sm waves-effect waves-light w-md hover-up">
							<span class="addSpin"><i class="fas fa-download"></i></span> พิมพ์
						</button>
						<button type="button" class="btn btn-secondary btn-sm waves-effect w-md hover-up" data-bs-dismiss="modal">
							<i class="mdi mdi-close-circle-outline"></i> ปิด
						</button>
						<a href="github-windows://openRepo/https://github.com/HakimMasa/AppLaw">GitHub</a>
						<a href="fastreport://openReport?reportPath='C:/Users/Hakim Masa/Desktop/CANCONTRACT.frx'">FastReport</a>
						<!-- <a href="fastreport://openReport?Path=C:/Users/HakimMasa/Desktop/CANCONTRACT.frx">FastReport 2</a>						 -->
					</div>
				</div>
			</form>
		</div>
	</div>

@endsection
