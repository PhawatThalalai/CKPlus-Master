@extends('layouts.master')
@section('title', 'account')
@section('account-active', 'mm-active')
@section('account-sub1-active', 'mm-active')
@section('account-p4-active', 'mm-active')
@section('page-frontend', 'd-none')

@section('content')
	<link rel="stylesheet" href="{{ URL::asset('assets/css/datepicker-custom.css') }}">
	<style>
		.carousel-btn-indicator {
			width: 0.4rem !important;
			height: 0.4rem !important;
			border-radius: 100%;
		}

		/* สำหรับหน้าจอที่มีขนาดน้อยกว่า 1200px */
		@media (max-width: 1199px) {
			.carousel-item-profile-b-end {
				min-height: 15rem;
				max-height: 15rem;
			}
		}

		/* สำหรับหน้าจอที่มีขนาด 1200px ขึ้นไป */
		@media (min-width: 1200px) {
			.carousel-item-profile-b-end {
				min-height: 30rem;
				max-height: 30rem;
			}
		}
	</style>

	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])
	@component('components.breadcrumb')
		@slot('title')
			บันทึกยึดตัดทำขาย <small class="font-small">(เปลี่ยนรถยึดเป็นรถเก่า)</small>
		@endslot
		@slot('menu')
			บัญชี
		@endslot
		@slot('sub_menu')
			บันทึกยึดตัดทำขาย
		@endslot
	@endcomponent

	<form id="form_Stopvat" class="needs-validation" novalidate>

		<div class="row">

			<!-- การ์ดข้อมูลฝั่งซ้าย -->
			<div class="col-xl-3 col-lg-12 col-md-12 col-sm-12">

				<div class="card">

					<div id="carouselExampleIndicators" class="carousel carousel-dark slide position-relative">

						<button class="position-absolute top-50 start-100 translate-middle btn btn-sm btn-outline-primary rounded" style="--bs-btn-padding-y: .125rem; --bs-btn-padding-x: .4rem; z-index: 1;" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
							<i class="mdi mdi-arrow-right font-size-16"></i>
						</button>
						<button class="position-absolute top-50 start-0 translate-middle btn btn-sm btn-outline-primary rounded" style="--bs-btn-padding-y: .125rem; --bs-btn-padding-x: .4rem; z-index: 1;" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
							<i class="mdi mdi-arrow-left font-size-16"></i>
						</button>

						<div class="carousel-indicators">
							<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="bg-primary carousel-btn-indicator active" aria-current="true" aria-label="Slide 1"></button>
							<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" class="bg-primary carousel-btn-indicator" aria-label="Slide 2"></button>
						</div>

						<div class="carousel-inner">
							<div class="carousel-item active carousel-item-profile-b-end">

								<div class="row g-2">
									<div class="col-xl-12 col-lg-6 col-md-6 col-sm-6 col-12">
										<div class="card-body pb-0">
											<h4 class="card-title text-muted bg-info bg-opacity-10 text-center">Contract Information</h4>
											<div>
												<ul class="list-unstyled m-0">
													<li class="mt-3">
														<div class="d-flex">
															<i class="bx bx-analyse text-primary fs-4"></i>
															<div class="ms-3">
																<h6 class="fs-14 mb-2 fw-semibold">เลขที่สัญญา</h6>
																<p class="text-primary fs-14 mb-0">
																	502401990000
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
												</ul>
											</div>
										</div>
									</div>

									<div class="col-xl-12 col-lg-6 col-md-6 col-sm-6 col-12">
										<div class="card-body pb-0">
											<h4 class="card-title text-muted bg-info bg-opacity-10 text-center">Personal Information</h4>
											<div>
												<ul class="list-unstyled">
													<li class="mt-3">
														<div class="d-flex">
															<i class="bx bx-user-circle text-primary fs-4"></i>
															<div class="ms-3">
																<h6 class="fs-14 mb-2 fw-semibold">ชื่อ-นามสกุล</h6>
																<p class="text-muted fs-14 mb-0">
																	นายเกรียงไกร ชีพนุรัตน์ (เป)
																	@isset($data['NameEng'])
																		<br>
																		<span class="text-primary">
																			<b>{{ '' . @$data['NameEng'] . '' }}</b>
																		</span>
																	@endisset

																	<br>
																	<span class="text-primary">
																		<b>Kriangkral</b>
																	</span>

																</p>
															</div>
														</div>
													</li>
													<li class="mt-3">
														<div class="d-flex">
															{{ @$id_card_icon }}
															<i class="bx bx-id-card text-primary fs-4"></i>

															<div class="ms-3">
																<h6 class="fs-14 mb-2 fw-semibold">{{ @$id_card_name }} เลขประจำตัวประชาชน </h6>
																@isset($data['idcard'])
																	<p @if (empty(@$data['typeidcard']) || @$data['typeidcard'] == '324001') class="text-muted fs-14 mb-0 input-mask" data-inputmask="'mask': '9-9999-99999-99-9'" @else class="text-muted fs-14 mb-0" @endif>
																		{{ @$data['idcard'] }}
																	</p>
																	{{-- {{ @$id_card_exp }} --}}
																@endisset

																<p class="text-muted fs-14 mb-0">
																	1-8402-00015-27-4
																</p>

															</div>
														</div>
													</li>
												</ul>
											</div>
										</div>
									</div>
								</div>

							</div>

							<div class="carousel-item carousel-item-profile-b-end">
								<div class="row g-2">
									<div class="col-xl-12 col-lg-6 col-md-6 col-sm-6 col-12">
										<div class="card-body pb-0">
											<h4 class="card-title text-muted bg-info bg-opacity-10 text-center">Asset Information</h4>
											<div>
												<ul class="list-unstyled m-0">
													<li class="mt-3">
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
										</div>
									</div>

									<div class="col-xl-12 col-lg-6 col-md-6 col-sm-6 col-12">
										<div class="card-body pb-0">
											<h4 class="card-title text-muted bg-info bg-opacity-10 text-center">Payment Information</h4>
											<div>
												<ul class="list-unstyled">
													<li class="mt-3">
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

								</div>
							</div>

						</div>
					</div>

				</div>

			</div>

			<!-- ข้อมูลของเมนู -->
			<div class="col-xl-9 col-lg-12 col-md-12 col-sm-12">

				<div class="row">
					<div class="col-xl-7 col-lg-6 col-md-6 col-sm-6">
						<div class="card mb-3">
							<div class="card-body">

								<div class="col-12">
									<div class="input-bx">
										<select class="form-select groupAsset" id="Vehicle_Group" name="Vehicle_Group" data-bs-toggle="tooltip" title="กลุ่มรถ" required>
											<option value="" selected>--- สาเหตุที่ยึด ---</option>
											<option>...</option>
										</select>
										<span class="text-danger floating-label">สาเหตุที่ยึด</span>
									</div>
								</div>

								<div class="col-12 mt-3">
									<div class="input-bx">
										<select class="form-select groupAsset" id="Vehicle_Group" name="Vehicle_Group" data-bs-toggle="tooltip" title="กลุ่มรถ" required>
											<option value="" selected>--- สถานที่เก็บ ---</option>
											<option>...</option>
										</select>
										<span class="text-danger floating-label">สถานที่เก็บ</span>
									</div>
								</div>

								<div class="col-12 mt-3">
									<div class="input-bx">
										<select class="form-select groupAsset" id="Vehicle_Group" name="Vehicle_Group" data-bs-toggle="tooltip" title="กลุ่มรถ" required>
											<option value="" selected>--- กลุ่มสินค้า ---</option>
											<option>...</option>
										</select>
										<span class="text-danger floating-label">กลุ่มสินค้า</span>
									</div>
								</div>

								<div class="col-12 mt-3">
									<div class="input-bx" id="OccupiedDT_Veh_datepicker">
										<input type="text" name="DateOccupiedcar" id="DateOccupiedcar" class="form-control rounded-0 rounded-start text-center" placeholder=" " data-date-format="dd/mm/yyyy" data-date-container="#OccupiedDT_Veh_datepicker" data-provide="datepicker" data-date-disable-touch-keyboard="true" data-date-language="th" data-date-today-highlight="true" data-date-enable-on-readonly="true" data-date-clear-btn="true" data-date-orientation="bottom" data-bs-toggle="tooltip" data-bs-placement="top" title="วันครอบครองล่าสุด (ปี ค.ศ.)" readonly autocomplete="off" required>
										<button class="btn btn-light rounded-0 rounded-end border-dark border-opacity-10 border-top-1 border-bottom-1 border-end-1 border-start-0 d-flex align-items-center openDatepickerBtn" type="button">
											<i class="fas fa-calendar-alt"></i>
										</button>
										<span class="text-danger floating-label">วันที่เข้าสต็อก</span>
									</div>
								</div>

								<div class="col-md-12 mt-3">
									<div class="form-floating">
										<textarea class="form-control" placeholder="Leave a comment here" id="Note_cus" maxlength="65535" style="height: 5rem;"></textarea>
										<label for="Note_cus" class="fw-bold">บันทึก</label>
									</div>
								</div>

							</div>
						</div>
					</div>

					<div class="col-xl-5 col-lg-6 col-md-6 col-sm-6">
						<div class="card mb-3 bg-light bg-soft border border-info">
							<div class="card-body pt-2">

								<div class="row mb-0">
									<div class="col-4"></div>
									<label for="horizontal-firstname-input" class="col-sm-7 col-form-label fw-bold text-primary text-center">ตามรับเงินจริง</label>
								</div>

								<div class="row mb-2">
									<label for="horizontal-firstname-input" class="col-sm-4 col-form-label fw-bold text-end">เงินต้นคงเหลือ</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="" placeholder="Username">
										<button class="btn btn-outline-info" style="position: absolute; right: -1.8rem; top: 0; z-index: 1;">
											<i class="fas fa-calendar-alt"></i>
										</button>
									</div>
								</div>

								<div class="row mb-2">
									<label for="horizontal-firstname-input" class="col-sm-4 col-form-label fw-bold text-end">ดอกผลคงเหลือ</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="" placeholder="Username">
									</div>
								</div>

								<div class="row mb-0">
									<div class="col-4"></div>
									<label for="horizontal-firstname-input" class="col-sm-7 col-form-label fw-bold text-primary text-center">ตามกำหนดชำระ</label>
								</div>

								<div class="row mb-2">
									<label for="horizontal-firstname-input" class="col-sm-4 col-form-label fw-bold text-end">เงินต้นคงเหลือ</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="" placeholder="Username">
									</div>
								</div>

								<div class="row mb-2">
									<label for="horizontal-firstname-input" class="col-sm-4 col-form-label fw-bold text-end">ดอกผลคงเหลือ</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="" placeholder="Username">
									</div>
								</div>

								<div class="row mb-2">
									<label for="horizontal-firstname-input" class="col-sm-4 col-form-label fw-bold text-end">ราคาประเมิน</label>
									<div class="col-sm-7">
										<input type="text" class="form-control" value="" placeholder="Username">
									</div>
								</div>

							</div>
						</div>
					</div>

				</div>

				<div class="d-flex flex-wrap flex-row-reverse gap-2">
					<button type="button" id="PrintBTN" class="btn btn-info waves-effect waves-light w-sm" disabled>
						<i class="mdi mdi-printer-settings d-block font-size-16"></i> พิมพ์
					</button>
					<button id="CancleBTN" type="button" class="btn btn-danger waves-effect waves-light w-sm" disabled>
						<i class="mdi mdi-book-cancel-outline d-block font-size-16"></i> ยกเลิก
					</button>
					<button id="SaveBTN" type="button" class="btn btn-success waves-effect waves-light w-sm" disabled>
						<i class="mdi mdi-book-arrow-down-outline d-block font-size-16"></i> บันทึก
					</button>
					<button type="button" class="btn btn-info waves-effect waves-light w-sm">
						<i class="mdi mdi-book-search-outline d-block font-size-16"></i> ค้นหา
					</button>
				</div>

			</div>

		</div>

		<div class="card profile-user-card-margin mt-3 d-none">
			<div class="row">

				<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
					<div class="card-body pb-0 pb-lg-3">
						<h4 class="card-title text-muted mb-3">Contract Information</h4>
						<div>
							<ul class="list-unstyled">
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

							</ul>
						</div>
					</div>
				</div>

				<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
					<div class="card-body pb-0 pb-lg-3">
						<h4 class="card-title text-muted mb-3">Personal Information</h4>
						<div data-simplebar style="max-height: 230px;cursor: pointer;">
							<ul class="list-unstyled">
								<li>
									<div class="d-flex">
										<i class="bx bx-user-circle text-primary fs-4"></i>
										<div class="ms-3">
											<h6 class="fs-14 mb-2 fw-semibold">ชื่อ-นามสกุล</h6>
											<p class="text-muted fs-14 mb-0">
												นายเกรียงไกร ชีพนุรัตน์ (เป)
												@isset($data['NameEng'])
													<br>
													<span class="text-primary">
														<b>{{ '' . @$data['NameEng'] . '' }}</b>
													</span>
												@endisset

												<br>
												<span class="text-primary">
													<b>Kriangkral</b>
												</span>

											</p>
										</div>
									</div>
								</li>
								<li class="mt-3">
									<div class="d-flex">
										{{ @$id_card_icon }}
										<i class="bx bx-id-card text-primary fs-4"></i>

										<div class="ms-3">
											<h6 class="fs-14 mb-2 fw-semibold">{{ @$id_card_name }} เลขประจำตัวประชาชน </h6>
											@isset($data['idcard'])
												<p @if (empty(@$data['typeidcard']) || @$data['typeidcard'] == '324001') class="text-muted fs-14 mb-0 input-mask" data-inputmask="'mask': '9-9999-99999-99-9'" @else class="text-muted fs-14 mb-0" @endif>
													{{ @$data['idcard'] }}
												</p>
												{{-- {{ @$id_card_exp }} --}}
											@endisset

											<p class="text-muted fs-14 mb-0">
												1-8402-00015-27-4
											</p>

										</div>
									</div>
								</li>
								{{-- 
								<li class="mt-3">
									<div class="d-flex">
										<i class="bx bx-phone text-primary fs-4"></i>
										<div class="ms-3">
											<h6 class="fs-14 mb-2 fw-semibold">เบอร์ติดต่อ</h6>
											<p class="text-muted fs-14 mb-0 input-mask" data-inputmask="'mask': '999-999-9999,999-999-9999'">
												{{ @$data['phone'] }}
												093-672-8649,___-___-____
											</p>
										</div>
									</div>
								</li>
								--}}
							</ul>
						</div>
					</div>
				</div>

				<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
					<div class="card-body pb-0 pb-sm-0 pb-md-3 pb-lg-3">
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
					</div>
				</div>

				<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
					<div class="card-body pb-0 pb-sm-0 pb-md-3 pb-lg-3">
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

			</div>
		</div>

		<div class="row g-2 d-none">
			<!-- การ์ดใบที่ 1 -->
			<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
				<div class="card mb-3">
					<div class="card-body">

						<div class="col-12">
							<div class="input-bx">
								<select class="form-select groupAsset" id="Vehicle_Group" name="Vehicle_Group" data-bs-toggle="tooltip" title="กลุ่มรถ" required>
									<option value="" selected>--- สาเหตุที่ยึด ---</option>
									<option>...</option>
								</select>
								<span class="text-danger floating-label">สาเหตุที่ยึด</span>
							</div>
						</div>

						<div class="col-12 mt-3">
							<div class="input-bx">
								<select class="form-select groupAsset" id="Vehicle_Group" name="Vehicle_Group" data-bs-toggle="tooltip" title="กลุ่มรถ" required>
									<option value="" selected>--- สถานที่เก็บ ---</option>
									<option>...</option>
								</select>
								<span class="text-danger floating-label">สถานที่เก็บ</span>
							</div>
						</div>

						<div class="col-12 mt-3">
							<div class="input-bx">
								<select class="form-select groupAsset" id="Vehicle_Group" name="Vehicle_Group" data-bs-toggle="tooltip" title="กลุ่มรถ" required>
									<option value="" selected>--- กลุ่มสินค้า ---</option>
									<option>...</option>
								</select>
								<span class="text-danger floating-label">กลุ่มสินค้า</span>
							</div>
						</div>

						<div class="col-12 mt-3">
							<div class="input-bx" id="OccupiedDT_Veh_datepicker">
								<input type="text" name="DateOccupiedcar" id="DateOccupiedcar" class="form-control rounded-0 rounded-start text-center" placeholder=" " data-date-format="dd/mm/yyyy" data-date-container="#OccupiedDT_Veh_datepicker" data-provide="datepicker" data-date-disable-touch-keyboard="true" data-date-language="th" data-date-today-highlight="true" data-date-enable-on-readonly="true" data-date-clear-btn="true" data-date-orientation="bottom" data-bs-toggle="tooltip" data-bs-placement="top" title="วันครอบครองล่าสุด (ปี ค.ศ.)" readonly autocomplete="off" required>
								<button class="btn btn-light rounded-0 rounded-end border-dark border-opacity-10 border-top-1 border-bottom-1 border-end-1 border-start-0 d-flex align-items-center openDatepickerBtn" type="button">
									<i class="fas fa-calendar-alt"></i>
								</button>
								<span class="text-danger floating-label">วันที่เข้าสต็อก</span>
							</div>
						</div>

					</div>
				</div>
			</div>

			<!-- การ์ดใบที่ 2 -->
			<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
				<div class="card mb-3 bg-light bg-soft border border-info">
					<div class="card-body pt-2">

						<div class="row mb-0">
							<div class="col-4"></div>
							<label for="horizontal-firstname-input" class="col-sm-7 col-form-label fw-bold text-primary text-center">ตามรับเงินจริง</label>
						</div>

						<div class="row mb-2">
							<label for="horizontal-firstname-input" class="col-sm-4 col-form-label fw-bold text-end">เงินต้นคงเหลือ</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" value="" placeholder="Username">
								<button class="btn btn-outline-info" style="position: absolute; right: -1.8rem; top: 0; z-index: 1;">
									<i class="fas fa-calendar-alt"></i>
								</button>
							</div>
						</div>

						<div class="row mb-2">
							<label for="horizontal-firstname-input" class="col-sm-4 col-form-label fw-bold text-end">ดอกผลคงเหลือ</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" value="" placeholder="Username">
							</div>
						</div>

						<div class="row mb-0">
							<div class="col-4"></div>
							<label for="horizontal-firstname-input" class="col-sm-7 col-form-label fw-bold text-primary text-center">ตามกำหนดชำระ</label>
						</div>

						<div class="row mb-2">
							<label for="horizontal-firstname-input" class="col-sm-4 col-form-label fw-bold text-end">เงินต้นคงเหลือ</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" value="" placeholder="Username">
							</div>
						</div>

						<div class="row mb-2">
							<label for="horizontal-firstname-input" class="col-sm-4 col-form-label fw-bold text-end">ดอกผลคงเหลือ</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" value="" placeholder="Username">
							</div>
						</div>

						<div class="row mb-2">
							<label for="horizontal-firstname-input" class="col-sm-4 col-form-label fw-bold text-end">ราคาประเมิน</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" value="" placeholder="Username">
							</div>
						</div>

					</div>
				</div>
			</div>

			<!-- การ์ดใบที่ 3 -->
			<div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
				<div class="card mb-3">
					<div class="card-body">

						<div class="col-md-12">
							<div class="form-floating">
								<textarea class="form-control bg-warning bg-soft" placeholder="Leave a comment here" id="Note_cus" maxlength="65535" style="height: 170px"></textarea>
								<label for="Note_cus" class="fw-bold">บันทึก</label>
							</div>
						</div>

					</div>
				</div>
			</div>

		</div>

	</form>

	<script>
		$(function() {
			const carousel = new bootstrap.Carousel('#carouselExampleIndicators')

			$('#carouselExampleIndicators').bind('mousewheel', function(e) {
				if (e.originalEvent.wheelDelta / 120 > 0) {
					$(this).carousel('next');
				} else {
					$(this).carousel('prev');
				}
			});

		});
	</script>

	<script>
		//const carousel = new bootstrap.Carousel('#myCarousel')
	</script>

	<script>
		$('#btn_Stopvat').click(function() {
			var dataform = document.querySelectorAll('#form_Stopvat');
			var validate = validateForms(dataform);

			if (validate == true) {
				let data = {};
				$("#form_Stopvat").serializeArray().map(function(x) {
					data[x.name] = x.value;
				});

				$.ajax({
					url: "{{ route('account.index') }}",
					method: "get",
					page: 'stopcont-vats',
					data: {
						data: data,
						_token: "{{ @csrf_token() }}",
					},

					success: async function(result) {
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
			}
		});
	</script>

	<script src="{{ URL::asset('assets/js/input-bx-select.js') }}"></script>

@endsection
