@include('components.content-calcufinance.Calculate_PTN.new-script')
@include('public-js.scriptVehRate')
{{-- @include('public-js.scriptDataRate') --}}

<style>
	.category {
		text-transform: capitalize;
		font-weight: 700;
		color: #9A9A9A;
	}

	.nav-item .nav-link,
	.nav-tabs .nav-link {
		-webkit-transition: all 300ms ease 0s;
		-moz-transition: all 300ms ease 0s;
		-o-transition: all 300ms ease 0s;
		-ms-transition: all 300ms ease 0s;
		transition: all 300ms ease 0s;
	}

	.tab-Calculate .nav-tabs {
		border: 0;
		padding: 5px 0.7rem;
	}

	.tab-Calculate .nav-tabs>.nav-item>.nav-link {
		color: #888888;
		margin: 0;
		margin-right: 5px;
		background-color: transparent;
		border: 1px solid transparent;
		border-radius: 30px;
		font-size: 14px;
		padding: 11px 23px;
		line-height: 1.5;
	}

	.tab-Calculate .nav-tabs.nav-tabs-neutral>.nav-item>.nav-link {
		color: #FFFFFF;
	}

	.tab-Calculate .nav-tabs.nav-tabs-neutral>.nav-item>.nav-link.active {
		background-color: rgba(255, 255, 255, 0.2);
		color: #FFFFFF;
	}

	.card[data-background-color="orange"] {
		background-color: #f96332;
	}

	[data-background-color="orange"] {
		background-color: #e95e38;
	}

	.data-container {
		background: #eeeeee75;
		padding-top: 10px;
		padding-bottom: 10px;
	}

	.btn-orange {
		background-color: #f96332;
		color: #FFFFFF;
	}
</style>

<style>
	/* กำหนดสไตล์สำหรับฟิลด์ select ที่ disabled */
	.disabled-select {
		background-color: #f2f2f2;
		color: #999;
		cursor: not-allowed;
	}
</style>

<style>
	.disabled-checkbox {
		opacity: 0.5;
		/* Reduced opacity to indicate disabled state */
		pointer-events: none;
		/* Prevent user interaction */
	}
</style>

<div class="modal-content">
	<div class="d-flex m-3">
		<div class="flex-shrink-0 me-2">
			<img src="{{ asset('assets/images/gif/rules.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
		</div>
		<div class="flex-grow-1 overflow-hidden">
			<h5 class="text-primary fw-semibold">ระบบคำนวณยอดจัดไฟแนนซ์</h5>
			<p class="text-muted mt-n1 fw-semibold font-size-12">Tag. : {{ @$tags->Code_Tag }}</p>
			<p class="border-primary border-bottom mt-n2 m-2"></p>
		</div>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>

	<div class="modal-body">
		<form name="form_createCal" id="form_createCal" class="needs-validation" action="#" method="post" enctype="multipart/form-data">
			@csrf
			<input type="hidden" name="type" value="6" />
			<input type="hidden" name="DataTag_id" value="{{ @$tags->id }}" />
			<input type="hidden" name="DataCus_id" value="{{ @$tags->TagToDataCus->id }}" />
			<input type="hidden" name="Cal_id" id="Cal_id" value="{{ @$tags->TagToCulculate->id }}" />

			<div class="clearfix">
				<div class="float-end">
					<div class="input-group input-group-sm">
						<div class="row g-2 mb-2">
							<div class="col-xl-6 col-lg-12 col-md-12">
								<div class="input-bx">
									<select name="Type_Customer" id="Type_Customer" class="form-select text-dark" placeholder=" " required>
										<option value="" selected>--- ประเภทลูกค้า ---</option>
										@foreach ($typeCus as $key => $value)
											<option value="{{ $value->Code_Cus }}" {{ $value->Code_Cus == @$tags->Type_Customer ? 'selected' : '' }}>({{ $value->Code_Cus }}) - {{ $value->Name_Cus }}</option>
										@endforeach
									</select>
									<span class="text-danger">ประเภทลูกค้า</span>
								</div>
							</div>
							<div class="col-xl-6 col-lg-12 col-md-12">
								<div class="input-bx">
									<input type="text" name="DateOccupiedcar" id="DateOccupiedcar" value="{{ isset($tags->TagToCulculate->DateOccupiedcar) ? date('d-m-Y', strtotime(@$tags->TagToCulculate->DateOccupiedcar)) : '' }}" class="form-control text-center font-size-14" data-date-autoclose="true" data-provide="datepicker" data-date-format="dd-mm-yyyy" data-date-language="th" autocomplete="off" data-date-today-btn="linked" data-date-end-date="{{ date('d-m-Y') }}" placeholder="วัน-เดือน-ปี" readonly />
									{{-- <input type="date" name="DateOccupiedcar" id="DateOccupiedcar" value="{{ @$tags->TagToCulculate->DateOccupiedcar }}" class="form-control" title="วันครอบครอง" placeholder=" " required /> --}}
									<input type="date" name="todayOcc" id="todayOcc" value="{{ date('Y-m-d') }}" hidden>
									<span class="text-danger">วันครอบครอง</span>

									{{-- <button type="button" id="count-DateOccup" class="mx-0 btn btn-light border border-secondary w-50 border-opacity-50" title="ระยะเวลาครอบครอง"> {{ @$tags->TagToCulculate->NumDateOccupiedcar }} วัน</button> --}}
									<input type="text" hidden name="NumDateOccupiedcar" id="NumDateOccupiedcar" value="{{ @$tags->TagToCulculate->NumDateOccupiedcar }}">
								</div>
								<label id="count-DateOccup" class="form-check-label text-danger" for="inlineFormCheck" title="ระยะเวลาครอบครอง"></label>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row mb-2">
				<div class="col-xl-12 col-lg-12 col-md-12">
					<div class="accordion accordion-flush border" id="accordionFlushExample">
						<div class="accordion-item">
							<h2 class="accordion-header" id="flush-headingOne">
								<button class="accordion-button fw-medium bg-secondary rounded-top bg-soft bg-opacity-10 p-2" type="button" id="tab-datarate" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
									<h5 class="my-0 text-danger font-size-14">&nbsp;<i class="bx bx-car me-3 ms-2 font-size-18"></i>ข้อมูลทรัพย์สิน</h5>
								</button>
							</h2>
							<div id="flush-collapseOne" class="accordion-collapse collapse show" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" style="">
								<div class="accordion-body text-muted pb-0">
									<div class="row mb-2 g-2">
										<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
											<div class="input-bx">
												<select name="TypeLoans" id="TypeLoans" class="form-select text-dark border-danger TypeLoans typeRateAsset" placeholder=" " required>
													<option value="" selected>--- ประเภทสัญญา ---</option>
													@foreach ($TypeLoan as $key => $value)
														<option value="{{ $value->id_rateType }}" {{ $value->Loan_Code == @$tags->TagToCulculate->CodeLoans ? 'selected' : '' }}>{{ $value->Loan_Code }} - {{ $value->Loan_Name }}</option>
													@endforeach
												</select>
												<input type="hidden" name="CodeLoans" id="CodeLoans" value="{{ @$tags->TagToCulculate->CodeLoans }}" />
												<input type="hidden" id="assetType_input" name="assetType_input" value="{{ @$tags->TagToCulculate->TypeLoans }}" placeholder="ประเภททรัพย์">
												<span class="text-danger">ประเภทสัญญา</span>
											</div>
										</div>
										<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
											<div class="input-bx">
												<input type="text" name="RatePrices" id="RatePrices" value="{{ number_format(@$tags->TagToCulculate->RatePrices, 0) }}" class="form-control border-danger text-end ratePrice" placeholder=" " readonly />
												<span class="text-danger">ราคา</span>
											</div>
										</div>
										<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
											@php
												if (@$tags->TagToCulculate->RatePrice_Car != 0) {
												    $RatePrice_Car = @$tags->TagToCulculate->RatePrice_Car;
												} else {
												    $RatePrice_Car = @$tags->TagToCulculate->RatePrices;
												}
											@endphp
											<div class="input-bx">
												<input type="text" name="RatePrice_Car" id="RatePrice_Car" value="{{ number_format(@$RatePrice_Car, 0) }}" class="form-control border-danger text-end" placeholder=" " readonly />
												<span class="text-danger">ราคาพิเศษ</span>
											</div>
										</div>
									</div>

									<p class="border border-bottom border-orange-500"></p>
									<div id="input_ratetype" class="row g-2">
										<div class="col-xl-6 col-lg-6 col-md-12">
											<div class="row g-2 mb-2">
												<div class="col-xl-6 col-lg-6 col-md-12">
													<div class="input-bx">
														<select name="RateCartypes" class="form-select text-dark typeAsset" placeholder="ประเภทรถ">
															<option value="">--- ประเภทรถ ---</option>
															@isset($datatypeCar)
																@foreach ($datatypeCar as $typeCar)
																	<option value="{{ $typeCar->code_car }}" {{ $typeCar->code_car == @$tags->TagToCulculate->RateCartypes ? 'selected' : '' }}>{{ $typeCar->nametype_car }}</option>
																@endforeach
															@endisset
														</select>
														<input type="hidden" id="showRateCartypes" value="{{ @$tags->TagToCulculate->RateCartypes }}" />
														<input type="hidden" id="v_RateCartypes" name="v_RateCartypes" value="{{ @$tags->TagToCulculate->RateCartypes }}">
														<span class="text-danger">ประเภทรถ</span>
													</div>
												</div>
												<div class="col-xl-6 col-lg-6 col-md-12">
													<div class="input-bx">
														<select class="form-select text-dark Type_PLT" id="Type_PLT" name="Type_PLT" data-toggle="tooltip" title="ประเภทรถ 2">
															<option value="" selected>-- ประเภทรถ 2 --</option>
														</select>
														<span class="text-danger">ประเภทรถ 2</span>
													</div>
												</div>
											</div>
											<div class="row g-2 mb-2">
												<div class="col-xl-6 col-lg-6 col-md-12">
													<div class="input-bx">
														<select name="RateBrands" class="form-select text-dark brandAsset" placeholder="ยี่ห้อรถ">
															<option value="" selected>--- ยี่ห้อรถ ---</option>
														</select>
														<span class="text-danger">ยี่ห้อรถ</span>
													</div>
												</div>
												<div class="col-xl-6 col-lg-6 col-md-12">
													<div class="input-bx">
														<select name="RateGroups" class="form-select text-dark groupAsset" placeholder="กลุ่มรถ">
															<option value="" selected>--- กลุ่มรถ ---</option>
														</select>
														<span class="text-danger">กลุ่มรถ</span>
													</div>
												</div>
											</div>
											<div class="row mb-2">
												<div class="col-xl-12 col-lg-12 col-md-12">
													<div class="input-bx">
														<select class="form-select text-dark yearAsset" placeholder="ปีรถ">
															<option value="" selected>--- ปีรถ ---</option>
														</select>
														<span class="text-danger">ปีรถ</span>
														<input type="hidden" name="RateYears" class="rateYear" value="{{ @$tags->TagToCulculate->RateYears }}">
														<input type="hidden" id="showRateYear" value="{{ @$tags->TagToCulculate->DataCalcuToCarYear->Year_car }}">
													</div>
												</div>
											</div>
										</div>
										<div class="col-xl-6 col-lg-6 col-md-12">
											<div class="row mb-2">
												<div class="col-xl-12 col-lg-12 col-md-12">
													<div class="input-bx">
														<select name="RateModals" id="RateModals" class="form-select text-dark modelAsset model-rate" placeholder="รุ่นรถ">
															<option value="" selected>--- รุ่นรถ ---</option>
														</select>
														<span class="text-danger">รุ่นรถ</span>
													</div>
												</div>
											</div>
											<div class="row mb-2">
												<div class="col-xl-12 col-lg-12 col-md-12 showGear">
													<div class="input-bx">
														<select name="RateGears" id="RateGears" class="form-select text-dark gearCar" placeholder="เกียร์รถ">
															<option value="" selected>--- เกียร์รถ ---</option>
															<option value="Auto" {{ @$tags->TagToCulculate->RateGears == 'Auto' ? 'selected' : '' }}>Auto</option>
															<option value="Manual" {{ @$tags->TagToCulculate->RateGears == 'Manual' ? 'selected' : '' }}>Manual</option>
														</select>
														<span class="text-danger">เกียร์รถ</span>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-xl-6 col-lg-12 col-md-12">
					<div class="card border border-danger">
						<div class="card-header border-danger" style="background-color: #e95e38">
							<h5 class="my-0 text-light font-size-14"><i class="mdi mdi-calculator-variant-outline me-3 font-size-18"></i>รายละเอียดการคำนวณ</h5>
						</div>
						<div class="card-body pb-2">
							<div class="row g-2 mb-2">
								<div class="col-xl-6 col-lg-12 col-md-12">
									<div class="input-bx">
										<input type="text" name="Cash_Car" id="Cash_Car" value="{{ @$tags->TagToCulculate->Cash_Car != 0 ? number_format(@$tags->TagToCulculate->Cash_Car, 0) : '' }}" class="form-control text-dark" data-toggle="tooltip" title="ยอดจัด" placeholder=" " autocomplete="off" required />
										<span class="text-danger">ยอดจัด</span>
									</div>
								</div>
								<div class="col-xl-6 col-lg-12 col-md-12">
									<div class="input-bx">
										<input type="number" name="Process_Car" id="Process_Car" value="{{ @$tags->TagToCulculate->Process_Car != 0 ? intval(@$tags->TagToCulculate->Process_Car) : 0 }}" class="form-control text-dark" data-toggle="tooltip" title="ค่าธรรมเนียม" placeholder=" " autocomplete="off" required />
										<span class="text-danger">ค่าธรรมเนียม</span>
									</div>
								</div>
							</div>
							<div class="row g-2 mb-2 show-Timelack_PRD" style="display: none;">
								<div class="col-xl-12 col-lg-12 col-md-12">
									<div class="input-bx">
										<input type="number" name="Timelack_PRD" id="Timelack_PRD" value="{{ !empty(@$tags->TagToCulculate->Timelack_PRD) ? $tags->TagToCulculate->Timelack_PRD : '' }}" class="form-control text-dark" data-toggle="tooltip" title="งวดคงเหลือเดิม" placeholder=" " autocomplete="off" />
										<span class="text-danger">งวดคงเหลือเดิม</span>
									</div>
								</div>
							</div>
							<div class="row g-2 mb-2">
								<div class="col-xl-6 col-lg-12 col-md-12">
									<div class="input-bx">
										<select name="Timelack_Car" id="Timelack_Car" class="form-select text-dark" data-toggle="tooltip" title="ระยะเวลาผ่อน" required>
											<option value="" selected>--- ระยะเวลาผ่อน ---</option>
											<option value="12" {{ @$tags->TagToCulculate->Timelack_Car == '12' ? 'selected' : '' }}>12 งวด</option>
											<option value="18" {{ @$tags->TagToCulculate->Timelack_Car == '18' ? 'selected' : '' }}>18 งวด</option>
											<option value="24" {{ @$tags->TagToCulculate->Timelack_Car == '24' ? 'selected' : '' }}>24 งวด</option>
											<option value="30" {{ @$tags->TagToCulculate->Timelack_Car == '30' ? 'selected' : '' }}>30 งวด</option>
											<option value="36" {{ @$tags->TagToCulculate->Timelack_Car == '36' ? 'selected' : '' }}>36 งวด</option>
											<option value="42" {{ @$tags->TagToCulculate->Timelack_Car == '42' ? 'selected' : '' }}>42 งวด</option>
											<option value="48" {{ @$tags->TagToCulculate->Timelack_Car == '48' ? 'selected' : '' }}>48 งวด</option>
											<option value="54" {{ @$tags->TagToCulculate->Timelack_Car == '54' ? 'selected' : '' }}>54 งวด</option>
											<option value="60" {{ @$tags->TagToCulculate->Timelack_Car == '60' ? 'selected' : '' }}>60 งวด</option>
											<option value="66" {{ @$tags->TagToCulculate->Timelack_Car == '66' ? 'selected' : '' }}>66 งวด</option>
											<option value="72" {{ @$tags->TagToCulculate->Timelack_Car == '72' ? 'selected' : '' }}>72 งวด</option>
											<option value="78" {{ @$tags->TagToCulculate->Timelack_Car == '78' ? 'selected' : '' }}>78 งวด</option>
											<option value="84" {{ @$tags->TagToCulculate->Timelack_Car == '84' ? 'selected' : '' }}>84 งวด</option>
										</select>
										<span class="text-danger">ระยะเวลาผ่อน</span>
										<button type="button" id="Show-Timelack" class="btn btn-danger border border-danger border-opacity-50 Show-Timelack" data-toggle="tooltip" title="ระยะเวลาผ่อนที่บันทึก">
											{{ @$tags->TagToCulculate->Timelack_Car }}
										</button>
									</div>
								</div>
								<div class="col-xl-6 col-lg-12 col-md-12">
									<div class="input-bx">
										<input type="text" name="Interest_Car" id="Interest_Car" value="{{ @$tags->TagToCulculate->Interest_Car != 0 ? number_format(@$tags->TagToCulculate->Interest_Car, 2) : '' }}" class="form-control text-dark" data-toggle="tooltip" title="ดอกเบี้ยที่บันทึก" placeholder=" " autocomplete="off" required />
										<span class="text-danger">ดอกเบี้ย (%)</span>
										<button type="button" id="Show-interest" class="btn btn-danger border border-danger border-opacity-50 Show-interest" data-toggle="tooltip" title="ดอกเบี้ย (%)">%</button>
									</div>
								</div>
							</div>
							<div class="row g-2 mb-2">
								<div class="col-xl-6 col-lg-12 col-md-12">
									<div class="input-bx">
										<input type="text" name="Interestmore_Car" id="Interestmore_Car" value="{{ @$tags->TagToCulculate->Interestmore_Car != 0 ? number_format(@$tags->TagToCulculate->Interestmore_Car, 2) : '' }}" class="form-control text-dark" data-toggle="tooltip" title="ดอกเบี้ยพิเศษ" placeholder=" " autocomplete="off" />
										<span class="text-danger">ดอกเบี้ยพิเศษ</span>
										<div class="btn-group">
											<button type="button" id="btn_InterestSelect" class="btn btn-warning dropdown-toggle {{ @$data->TagToCulculate->Flag_Interest != null ? '' : 'disabled' }}" data-bs-toggle="dropdown" aria-expanded="false"> <i class="mdi mdi-chevron-down"></i></button>
											<ul class="dropdown-menu" style="" id="InterestSelect">
												<li class="dropdown-item" id="Plus">01. บวกดอกเบี้ย (+)</li>
												<li class="dropdown-item" id="Delete">02. ลบดอกเบี้ย (-)</li>
												<li class="dropdown-item" id="Return">03. คืนค่า</li>
											</ul>
										</div>
									</div>
									<input type="hidden" name="Flag_Interest" id="Flag_Interest" value="{{ @$tags->TagToCulculate->Flag_Interest }}">
								</div>
								<div class="col-xl-6 col-lg-12 col-md-12">
									<div class="input-bx">
										<input type="text" name="totalInterest_Car" id="totalInterest_Car" value="{{ @$tags->TagToCulculate->totalInterest_Car != 0 ? number_format(@$tags->TagToCulculate->totalInterest_Car, 2) : 0 }}" class="form-control text-dark" data-toggle="tooltip" title="รวมดอกเบี้ย" placeholder=" " autocomplete="off" />
										<span class="text-danger">รวมดอกเบี้ย</span>
										<button type="button" class="btn btn-danger border border-danger border-opacity-50"> % </button>
									</div>
									<input type="hidden" name="InterestYear_Car" id="InterestYear_Car" value="{{ @$tags->TagToCulculate->InterestYear_Car != 0 ? number_format(@$tags->TagToCulculate->InterestYear_Car, 0) : 0 }}" class="form-control form-control-sm textSize-13" placeholder="ดอกเบี้ยปี" />
								</div>
							</div>

							<p class="border border-bottom border-danger"></p>
							<div class="row g-2 mb-2">
								<div class="col-xl-6 col-lg-12 col-md-12">
									<div class="input-bx">
										<select name="Promotions" id="Promotions" class="form-select text-dark" data-toggle="tooltip" title="Promotions">
											<option value="" selected>--- Promotions ---</option>
											@foreach (@$dataPro as $key => $item)
												<option value="{{ $item->id }}/{{ $item->Value_pro }}/{{ $item->Type_pro }}" {{ @$item->id == @$tags->TagToCulculate->Promotions ? 'selected' : '' }}>{{ $key + 1 }}. {{ $item->Name_pro }}</option>
											@endforeach
											<option value="ยกเลิก" class="text-red">ยกเลิก</option>
										</select>
										<span class="text-danger">Promotions</span>
									</div>
									<input type="hidden" name="valuePromotion" id="valuePromotion" value="{{ @$tags->TagToCulculate->Promotions }}">
								</div>
								<div class="col-xl-6 col-lg-12 col-md-12">
									<div class="input-bx">
										<input type="number" name="Insurance" id="Insurance" value="{{ @$tags->TagToCulculate->Insurance != 0 ? number_format(@$tags->TagToCulculate->Insurance, 0) : 0 }}" class="form-control text-dark" data-toggle="tooltip" title="ประกันรถ" placeholder=" " autocomplete="off" />
										<span class="">ประกันรถ</span>
										<button type="button" class="btn btn-light border border-secondary border-opacity-50">บาท</button>
									</div>
								</div>
							</div>
						</div>

						<div class="card-body border-top p-2">
							<div class="d-flex flex-wrap">
								<div class="ms-3 me-2">
									<p class="text-muted mb-1 fw-semibold text-decoration-underline">ข้อมูลประกัน PA</p>
									<div class="ms-4 mt-2">
										<div class="d-flex align-middle">
											<div class="square-switch">
												<input type="checkbox" name="showBuy_PA" id="showBuy_PA" switch="bool" {{ @$tags->TagToCulculate->Buy_PA == 'yes' ? 'checked' : '' }} required>
												<label for="showBuy_PA" data-on-label="Yes" data-off-label="No" class="mb-0"></label>
											</div>
											<span class="ms-0 mt-1 fw-semibold" id="txt-Buy_PA"></span>
										</div>
										<div class="input-Include_PA">
											<div class="d-flex align-middle">
												<div class="square-switch">
													<input type="checkbox" name="showInclude_PA" id="showInclude_PA" switch="bool" {{ @$tags->TagToCulculate->Include_PA == 'yes' ? 'checked' : '' }}>
													<label for="showInclude_PA" data-on-label="Yes" data-off-label="No" class="mb-0"></label>
												</div>
												<span class="ms-0 mt-1 fw-semibold" id="txt-Include_PA">
													<span class="{{ @$tags->TagToCulculate->Include_PA == 'yes' ? 'text-success' : 'text-danger' }}">รวมยอดประกันในสินเชื่อ</span>
												</span>
											</div>
										</div>
									</div>
								</div>
								<div class="ms-3 me-2">
									<p class="text-muted mb-1 fw-semibold text-decoration-underline">ข้อมูลการคำนวณ</p>
									<div class="ms-4 mt-2">
										<div class="d-flex align-middle">
											<div class="square-switch">
												<input type="checkbox" name="ShowStatusProcess_Car" id="ShowStatusProcess_Car" switch="bool" {{ @$tags->TagToCulculate->StatusProcess_Car == 'yes' ? 'checked' : '' }} required>
												<label for="ShowStatusProcess_Car" data-on-label="Yes" data-off-label="No" class="mb-0"></label>
											</div>
											<span class="ms-0 mt-1 fw-semibold" id="txt-StatusProcess_Car"></span>
										</div>
									</div>
								</div>

								<div class="ms-auto align-self-end">
									<i class="mdi mdi-car-info display-4 text-light"></i>
								</div>
							</div>
						</div>
					</div>

					<div class="text-center">
						<button type="button" id="button-data1" class="btn btn-info btn-rounded w-md waves-effect waves-light hover-up ClickHover" {{ !empty(@$tags->TagToCulculate) ? 'disabled' : '' }}>
							<span class="cal-addSpin"><i class="bx bx-calculator"></i></span> คำนวณ
						</button>
						<button type="button" id="button-Clear1" class="btn btn-dark btn-rounded w-md waves-effect waves-light hover-up ClickHover {{ (Auth::user()->position != 'Admin' and @$tags->TagToContracts != null and @$tags->TagToContracts->StatusApp_Con == 'อนุมัติ') ? 'd-none' : '' }}" {{ (!empty(@$Contract) and auth::user()->position != 'Admin') ? 'disabled' : '' }}>
							<i class="bx bx-trash"></i> คืนค่า
						</button>
					</div>
				</div>
				<div class="col-xl-6 col-lg-12 col-md-12 data-show" style="{{ isset($tags->TagToCulculate) ? '' : 'display:none !important;' }}">
					<div class="table-responsive">
						<table class="table table-striped align-middle table-nowrap mb-0">
							<thead class="table-info rounded" style="line-height: 105%;">
								<tr class="text-center ">
									<th class="align-middle">ระยะเวลาผ่อน</th>
									<th class="align-middle">ยอดผ่อน Non-PA</th>
									<th class="align-middle d-none showPA">แผน</th>
									<th class="align-middle d-none showPA">ยอดผ่อน +PA</th>
								</tr>
							</thead>
							<tbody class="text-center" id="tb_showdata" style="line-height: 50%;">
							</tbody>
						</table>
					</div>
				</div>
				<div id="data_empty" class="col-xl-6 col-lg-12 col-md-12 d-flex align-items-center justify-content-center" style="{{ !empty($tags->TagToCulculate) ? 'display:none !important;' : '' }}">
					<div class="text-center" style="min-height:15rem; max-height:15rem;">
						<img src="{{ URL::asset('\assets\images\empty-bock.png') }}" class="up-down mt-4" style="width:100px;">
						<h6 class="fw-semibold mt-2">ไม่มีการคำนวณ</h6>
					</div>
				</div>
			</div>

			{{-- value hidden --}}
			<input type="hidden" name="StatusProcess_Car" id="StatusProcess_Car" value="{{ @$tags->TagToCulculate->StatusProcess_Car != 'yes' ? 'yes' : 'no' }}" title="สถานะ ค่าดำเนินการ" />
			<input type="hidden" name="Percent_Car" id="Percent_Car" value="{{ @$tags->TagToCulculate->Percent_Car != 0 ? number_format($tags->TagToCulculate->Percent_Car, 0) : 0 }}" title="% จัดไฟแนนซ์" />
			<input type="hidden" name="Period_Rate" id="Period_Rate" value="{{ @$tags->TagToCulculate->Period_Rate != 0 ? number_format($tags->TagToCulculate->Period_Rate, 0) : 0 }}" title="ค่างวดต่อเดือน" />
			<input type="hidden" name="TotalPeriod_Rate" id="TotalPeriod_Rate" value="{{ @$tags->TagToCulculate->TotalPeriod_Rate != 0 ? number_format($tags->TagToCulculate->TotalPeriod_Rate, 0) : 0 }}" title="ยอดทั้งสัญญา" />

			{{-- input hidden --}}
			<input type="hidden" name="Vat_Rate" id="Vat_Rate" value="{{ @$tags->TagToCulculate->Vat_Rate != null ? $tags->TagToCulculate->Vat_Rate : 7 }}" title="vat" />
			<input type="hidden" name="Tax_Rate" id="Tax_Rate" value="{{ @$tags->TagToCulculate->Tax_Rate != 0 ? $tags->TagToCulculate->Tax_Rate : 0 }}" title="ภาษี" />
			<input type="hidden" name="Tax2_Rate" id="Tax2_Rate" value="{{ @$tags->TagToCulculate->Tax2_Rate != 0 ? $tags->TagToCulculate->Tax2_Rate : 0 }}" title="ระยะผ่อน-1" />
			<input type="hidden" name="Duerate_Rate" id="Duerate_Rate" value="{{ @$tags->TagToCulculate->Duerate_Rate != 0 ? $tags->TagToCulculate->Duerate_Rate : 0 }}" title="ค่างวด" />
			<input type="hidden" name="Duerate2_Rate" id="Duerate2_Rate" value="{{ @$tags->TagToCulculate->Duerate2_Rate != 0 ? $tags->TagToCulculate->Duerate2_Rate : 0 }}" title="ระยะผ่อน-2" />
			<input type="hidden" name="Profit_Rate" id="Profit_Rate" value="{{ @$tags->TagToCulculate->Profit_Rate != 0 ? $tags->TagToCulculate->Profit_Rate : 0 }}" title="กำไรจากยอดจัด" />

			{{-- PA --}}
			<input type="hidden" id="setBuy_PA" name="Buy_PA" value="{{ @$tags->TagToCulculate->Buy_PA != 'yes' ? 'yes' : 'no' }}">
			<input type="hidden" id="setInclude_PA" name="Include_PA" value="{{ @$tags->TagToCulculate->Include_PA == 'yes' ? 'yes' : 'no' }}">
			<input type="hidden" id="Plan_PA" name="Plan_PA" value="{{ @$tags->TagToCulculate->Plan_PA }}">
			<input type="hidden" id="Insurance_PA" name="Insurance_PA" value="{{ @$data->TagToCulculate->Insurance_PA != 0 ? intval($data->TagToCulculate->Insurance_PA) : 0 }}">

			{{-- กอล์ฟเพิ่ม --}}
			<input type="hidden" id="Note_Credo" name="Note_Credo" value="{{ @$tags->TagToCulculate->Note_Credo }}">
			<input type="hidden" id="Credo_Score" value="{{ @$tags->Credo_Score }}" />
			{{-- <input type="text" id="CheckPage" value="{{ $disable }}"> --}}

			{{-- credo --}}
			<input type="hidden" id="config_rate" value="{{ @$tags->TagToConfigCredo->Percen_rate }}">
			<input type="hidden" id="config_score" value="{{ @$tags->TagToConfigCredo->Score_rate }}">

			<input type="hidden" id="rateLTV">
		</form>
	</div>

	<div class="mdaol-foter">
		<div class="showdata-result" style="{{ isset($tags->TagToCulculate) ? '' : 'display:none !important;' }}">
			<div class="row">
				<div class="col-xl-6 col-md-12">
					<div class="card">
						<div class="card-body py-2">
							<div class="d-flex align-items-center mb-3">
								<div class="avatar-xs me-3">
									<span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
										<i class="bx bx-copy-alt"></i>
									</span>
								</div>
								<h5 class="font-size-14 mb-0 text-decoration-underline">ผลการคำนวณ</h5>
							</div>

							<div id="showLTV" class="text-center prem">
								<p class="mb-4"></p>
								<h5 class="text-muted">
									<span id="txtLTV" class="font-size-18"></span>
								</h5>
							</div>

							<div class="row text-center">
								<div class="col-6">
									<div class="mt-3">
										<p class="text-muted mb-1">เปอร์เซ็นจัดไฟแนนซ์</p>
										<span id="ShowPercent" class="font-size-18">
											{{ @$tags->TagToCulculate->Percent_Car != 0 ? number_format($tags->TagToCulculate->Percent_Car, 0) : '0.00' }}
										</span>
										<i class="mdi mdi-percent ms-1 text-success"></i>
									</div>
								</div>

								<div class="col-6">
									<div class="mt-3">
										<h5 class="text-end font-size-15">ค่างวดต่อเดือน :
											<span id="ShowPeriod">
												{{ @$data->TagToCulculate->Period_Rate != 0 ? number_format($data->TagToCulculate->Period_Rate, 0) : '0.0' }}
											</span>
											<i class="mdi mdi-alpha-b-circle-outline ms-1 text-success"></i>
										</h5>
										<h5 class="text-end font-size-15">ยอดทั้งสัญญา :
											<span id="ShowTotalPeriod">
												{{ @$data->TagToCulculate->TotalPeriod_Rate != 0 ? number_format($data->TagToCulculate->TotalPeriod_Rate, 0) : '0.0' }}
											</span>
											<i class="mdi mdi-alpha-b-circle-outline ms-1 text-success"></i>
										</h5>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-xl-6 col-md-12">
					<div class="card mb-0">
						<div class="card-body py-2">
							<div class="d-flex align-items-center mb-3">
								<div class="avatar-xs me-3">
									<span class="avatar-title rounded-circle bg-primary bg-soft text-primary font-size-18">
										<i class="bx bx-copy-alt"></i>
									</span>
								</div>
								<h5 class="font-size-14 mb-0 text-decoration-underline">รายละเอียดประกัน PA</h5>
							</div>
							<div class="text-muted mt-0 ms-5 mt-n3">
								<div class="table-responsive">
									<table class="table table-sm">
										<tbody class="" style="line-height: 130%;">
											<tr>
												<td>แผน :</td>
												<th>
													<span class="showPlan_PA"></span>
												</th>
											</tr>
											<tr>
												<td>ทุนประกัน :</td>
												<th>
													<span class="capital_PA"></span>
												</th>
											</tr>
											<tr>
												<td>ระยะเวลาประกันภัย :</td>
												<th>
													<span class="periodPA"></span>
												</th>
											</tr>
											<tr>
												<td>เบี้ยประกันภัย(รวมภาษีอากร) :</td>
												<th>
													<span class="periodPAtotal"></span>
												</th>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row text-end me-2 mb-2 mt-0 {{ session()->has('btn_flagCal') == true ? 'd-none' : '' }}">
				<div class="col">
					@if (
						!isset($tags->TagToContracts->Date_monetary) ||
							auth()->user()->hasRole(['superadmin', 'administrator']))
						<button type="button" id="btn_SubmitCalculate" class="btn btn-primary btn-sm waves-effect waves-light hover-up" {{ !empty(@$tags->TagToCulculate) ? 'disabled' : '' }}>
							<span class="addSpin"><i class="fas fa-download"></i></span> บันทึก
						</button>
					@endif
					<button type="button" id="btn_closeCal" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">
						<i class="mdi mdi-close-circle-outline"></i> ปิด
					</button>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>
