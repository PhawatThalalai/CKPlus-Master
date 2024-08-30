<style>
	ul.nav-tab-contract-b-end a.nav-link.active span.avatar-title {
		/* .bg-info.bg-soft */
		background-color: rgba(80, 165, 241, 0.25) !important;
		/* .text-info */
		--bs-text-opacity: 1;
		color: rgba(var(--bs-info-rgb), var(--bs-text-opacity)) !important;
	}

	.nav-tab-contract-b-end .nav-item .nav-link::after {
		background-color: #55b6e6;
	}

	a.disabled {
		color: gray;
		cursor: not-allowed;
	}
</style>

<!-- start page -->
<div class="h-100">
	<div class="card overflow-hidden m-0 shadow-none" style="z-index: 1;">
		<div class="bg-primary bg-soft">
			<div class="row">
				<div class="col-7">
					<div class="text-primary p-3">
						<h5 class="text-primary">Welcome Back !</h5>
					</div>
				</div>
				<div class="col-5 align-self-end">
					<img src="{{ URL::asset('/assets/images/profile-img.png') }}" alt="" class="img-fluid">
				</div>
			</div>
		</div>
		<div class="card-body pt-0">
			<div class="row py-3">
				<div class="avatar-md profile-user-wid mb-4 col text-center">
					<img id="ImageBrok" src="{{ checkURL($data['image']) == '200' ? URL::asset(@$data['image']) : asset('/assets/images/users/user-1.png') }}" style="width: 150px; height: 150px;" class="img-thumbnail rounded-circle hover-up mb-2 boreder-img" alt="User-Profile-Image">
				</div>
			</div>
			<div class="row pt-2 mb-0">
				<div class="col-sm-12">
					<p class="text-muted mb-0 text-center">
						<span class="btn btn-outline-success btn-sm mb-2 font-size-15 rounded-pill" style="min-width : 120px;"> {{ @$data['status'] != null ? @$data['status'] : 'สถานะสัญญา' }}</span>
					</p>
				</div>
			</div>
		</div>

		@if (!empty(@$data['contractId']) && @$megaMenu == false)
			<ul class="nav nav-tabs nav-tabs-custom nav-justified nav-tab-contract-b-end border-0" role="tablist">
				<li class="nav-item d-none" role="presentation">
					<a class="nav-link alink active" data-bs-toggle="tab" href="#data_home" role="tab" aria-selected="true">
						<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
						<div class="d-none d-sm-block flex-fill">
							<div class="d-flex justify-content-center mini-stats-wid">
								<div class="flex-shrink-0 align-self-center">
									<div class="mini-stat-icon avatar-xs rounded-circle" data-bs-toggle="tooltip" title="ข้อมูลลูกค้า">
										<span class="avatar-title hover-up bg-warning bg-soft text-warning font-size-20">
											<i class="bx bx-user-circle"></i>
										</span>
									</div>
								</div>
							</div>
						</div>
					</a>
				</li>
				<li class="nav-item" role="presentation">
					<a id="icon_content_contract_user" onclick="getTabNav('content_contract_user')" class="nav-link alink" data-bs-toggle="tab" href="#data_contract_user" role="tab" aria-selected="false" tabindex="-1">
						<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
						<div class="d-none d-sm-block flex-fill">
							<div class="d-flex justify-content-center mini-stats-wid">
								<div class="flex-shrink-0 align-self-center">
									<div class="mini-stat-icon avatar-xs rounded-circle" data-bs-toggle="tooltip" title="ข้อมูลลูกค้า">
                                        <span class="avatar-title hover-up bg-warning bg-soft text-warning font-size-20 ">
                                            {{-- main-icon --}}
											<i class="bx bx-user-circle content_contract_user_nav"></i>
                                            {{-- icon-loading --}}
                                            <i class="text-info bx bxs-hourglass-bottom bx-tada content_contract_user_loading" style="display: none;"></i>
										</span>


									</div>
								</div>
							</div>
						</div>
					</a>
				</li>
				<li class="nav-item" role="presentation">
					<a id="icon_content_contract" onclick="getTabNav('content_contract')" class="nav-link btn-con alink" data-bs-toggle="tab" href="#data_contract_details" role="tab" aria-selected="false" tabindex="-1">
						<span class="d-block d-sm-none"> <i class="bx bx-file"></i> </span>
						<div class="d-none d-sm-block flex-fill">
							<div class="d-flex justify-content-center mini-stats-wid">
								<div class="flex-shrink-0 align-self-center">
									<div class="mini-stat-icon avatar-xs rounded-circle" data-bs-toggle="tooltip" title="ข้อมูลสัญญา">
                                        <span class="avatar-title hover-up bg-warning bg-soft text-warning font-size-20 ">
                                            {{-- main-icon --}}
											<i class="bx bx bx-file content_contract_nav"></i>
                                            {{-- icon-loading --}}
                                            <i class="text-info bx bxs-hourglass-bottom bx-tada content_contract_loading" style="display: none;"></i>
										</span>

									</div>
								</div>
							</div>
						</div>
					</a>
				</li>
				<li class="nav-item" role="presentation">
					<a id="icon_content_contract_poss" class="nav-link alink" onclick="getTabNav('content_contract_poss')" data-bs-toggle="tab" href="#data_contract_lists" role="tab" aria-selected="false" tabindex="-1">
						<span class="d-block d-sm-none"><i class="far fa-user"></i></span>
						<div class="d-none d-sm-block flex-fill">
							<div class="d-flex justify-content-center mini-stats-wid">
								<div class="flex-shrink-0 align-self-center">
									<div class="mini-stat-icon avatar-xs rounded-circle" data-bs-toggle="tooltip" title="สัญญาครอบครอง">
                                        <span class="avatar-title hover-up bg-warning bg-soft text-warning font-size-20 ">
                                            {{-- main-icon --}}
											<i class="bx bx-archive content_contract_poss_nav"></i>
                                            {{-- icon-loading --}}
                                            <i class="text-info bx bxs-hourglass-bottom bx-tada content_contract_poss_loading" style="display: none;"></i>
										</span>
									</div>
								</div>
							</div>
						</div>
					</a>
				</li>
				<li class="nav-item accordion accordion-flush accordion-item border-0">
					<div class="nav-link">
						<div class="d-block flex-fill">
							<div class="d-flex justify-content-center mini-stats-wid">
								<div class="flex-shrink-0 align-self-center">
									<div class="mini-stat-icon avatar-xs rounded-circle">
										<button id="flush-headingOne" class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne" style="-webkit-box-shadow: none; padding: 0.5rem 0.5rem">
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</li>
			</ul>
		@endif

	</div>

	@if(!empty(@$data['contractId']))
		<div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample" style="position: relative; top: -2px;">
			<div class="card m-0">
				<div class="card-body p-2">
					<div class="accordion-body text-muted">
						<div class="row text-center">
							<div class="col-3 mb-3 @if (@$page == 'tracking') opacity-25 pe-none @endif">
								<a class="alink" href="{{ route('datatrack.edit', @$data['contractId']) }}?page={{ 'track-follow-up' }}">
									<span class="d-block d-sm-none text-center"><i class="bx bxs-user-voice"></i></span>
									<div class="d-none d-sm-block flex-fill">
										<div class="d-flex justify-content-center mini-stats-wid">
											<div class="flex-shrink-0 align-self-center">
												<div class="mini-stat-icon avatar-xs rounded-circle" data-bs-toggle="tooltip" title="รายละเอียดติดตาม">
													<span class="avatar-title hover-up bg-primary bg-soft text-primary font-size-20">
														<i class="bx bxs-user-voice"></i>
													</span>
												</div>
											</div>
										</div>
									</div>
									<small>บันทึกติดตาม</small>
								</a>
							</div>
							<div class="col-3 mb-2 @if (@$page == 'payments') opacity-25 pe-none @endif">
								<a class="alink" href="{{ route('payments.edit', @$data['contractId']) }}?page={{ 'payments' }}">
									<span class="d-block d-sm-none text-center"><i class="far fa-user"></i></span>
									<div class="d-none d-sm-block flex-fill">
										<div class="d-flex justify-content-center mini-stats-wid">
											<div class="flex-shrink-0 align-self-center">
												<div class="mini-stat-icon avatar-xs rounded-circle" data-bs-toggle="tooltip" title="รับชำระค่างวด">
													<span class="avatar-title hover-up bg-primary bg-soft text-primary font-size-20">
														<i class="fas fa-cash-register fs-5"></i>
													</span>
												</div>
											</div>
										</div>
									</div>
									<small>รับชำระค่างวด</small>
								</a>
							</div>
                            <div class="col-3 mb-3 @if (@$page == 'contracts') opacity-25 pe-none @endif">
							</div>
							<div class="col-3 mb-2">

							</div>
						</div>

						<div class="d-flex flex-wrap gap-2 justify-content-around d-none">
							<a class="" href="#data_contract_lists">
								<span class="d-block d-sm-none text-center"><i class="far fa-user"></i></span>
								<div class="d-none d-sm-block flex-fill">
									<div class="d-flex justify-content-center mini-stats-wid">
										<div class="flex-shrink-0 align-self-center">
											<div class="mini-stat-icon avatar-xs rounded-circle" data-bs-toggle="tooltip" title="สัญญาครอบครอง">
												<span class="avatar-title hover-up bg-primary bg-soft text-primary font-size-20">
													<i class="fas fa-cash-register fs-5"></i>
												</span>
											</div>
										</div>
									</div>
								</div>
								<small>รับชำระค่างวด</small>
							</a>
							<a class="" href="#data_contract_lists">
								<span class="d-block d-sm-none text-center"><i class="far fa-user"></i></span>
								<div class="d-none d-sm-block flex-fill">
									<div class="d-flex justify-content-center mini-stats-wid">
										<div class="flex-shrink-0 align-self-center">
											<div class="mini-stat-icon avatar-xs rounded-circle" data-bs-toggle="tooltip" title="สัญญาครอบครอง">
												<span class="avatar-title hover-up bg-primary bg-soft text-primary font-size-20">
													<i class="fas fa-user-tag fs-5"></i>
												</span>
											</div>
										</div>
									</div>
								</div>
								<small class="font-size-10">รายละเอียดติดตาม</small>
							</a>
							<a class="" href="#data_contract_lists">
								<span class="d-block d-sm-none text-center"><i class="far fa-user"></i></span>
								<div class="d-none d-sm-block flex-fill">
									<div class="d-flex justify-content-center mini-stats-wid">
										<div class="flex-shrink-0 align-self-center">
											<div class="mini-stat-icon avatar-xs rounded-circle" data-bs-toggle="tooltip" title="สัญญาครอบครอง">
												<span class="avatar-title hover-up bg-primary bg-soft text-primary font-size-20">
													<i class="bx bx-archive"></i>
												</span>
											</div>
										</div>
									</div>
								</div>
								<small>รับชำระค่างวด</small>
							</a>
							<a class="" href="#data_contract_lists">
								<span class="d-block d-sm-none text-center"><i class="far fa-user"></i></span>
								<div class="d-none d-sm-block flex-fill">
									<div class="d-flex justify-content-center mini-stats-wid">
										<div class="flex-shrink-0 align-self-center">
											<div class="mini-stat-icon avatar-xs rounded-circle" data-bs-toggle="tooltip" title="สัญญาครอบครอง">
												<span class="avatar-title hover-up bg-primary bg-soft text-primary font-size-20">
													<i class="bx bx-archive"></i>
												</span>
											</div>
										</div>
									</div>
								</div>
								<small>รับชำระค่างวด</small>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endif

	<div class="card profile-user-card-margin mt-3">
		<div class="row">
			<div class="col-xl-12 col-lg-6 col-md-6 col-sm-12">
				<div class="card-body">
					<h4 class="card-title text-muted mb-3">Contract Information</h4>
					<div data-simplebar style="max-height: 230px;cursor: pointer;">
						<ul class="list-unstyled">
							<li>
								<div class="d-flex">
									<i class="bx bx-analyse text-primary fs-4"></i>
									<div class="ms-3">
										<h6 class="fs-14 mb-2 fw-semibold">เลขที่สัญญา</h6>
										<p class="text-primary fs-14 mb-0">
											{{ @$data['contract'] }}
											{{-- @isset($data['NameEng'])
												<br>
												<span class="text-primary">
													<b>{{ '' . @$data['NameEng'] . '' }}</b>
												</span>
											@endisset --}}
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
									</div>
								</div>
							</li>
							<li class="mt-3">
								<div class="d-flex">
									{{ @$asset_icon }}
									<div class="ms-3">
										<h6 class="fs-14 mb-2 fw-semibold">{{ @$asset_data['title'] }}</h6>
										@if (@$asset_data['title'] == 'เลขทะเบียน')
											<span class="me-1" data-bs-toggle="tooltip" data-bs-html="true" aria-label="ป้ายเดิม" title="ป้ายเดิม">
												<i class="mdi mdi-card-bulleted-outline h5 text-success"></i> {{ @$asset_data['value'] }}
											</span>
										@else
											{{ @$asset_data['value'] }}
										@endif
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="col-xl-12 col-lg-6 col-md-6 col-sm-12 mt-xl-n4">
				<div class="card-body">
					<h4 class="card-title text-muted mb-3">Personal Information</h4>
					<div data-simplebar style="max-height: 230px;cursor: pointer;">
						<ul class="list-unstyled">
							<li>
								<div class="d-flex">
									<i class="bx bx-user-circle text-primary fs-4"></i>
									<div class="ms-3">
										<h6 class="fs-14 mb-2 fw-semibold">ชื่อ-นามสกุล</h6>
										<p class="text-muted fs-14 mb-0">
											{{ @$data['fullname'] }}
											@isset($data['nickname'])
												{{ ' (' . @$data['nickname'] . ')' }}
											@endisset
											@isset($data['NameEng'])
												<br>
												<span class="text-primary">
													<b>{{ '' . @$data['NameEng'] . '' }}</b>
												</span>
											@endisset
										</p>
									</div>
								</div>
							</li>
							<li class="mt-3">
								<div class="d-flex">
									{{ @$id_card_icon }}
									<div class="ms-3">
										<h6 class="fs-14 mb-2 fw-semibold">{{ @$id_card_name }}</h6>
										@isset($data['idcard'])
											<p @if (empty(@$data['typeidcard']) || @$data['typeidcard'] == '324001') class="text-muted fs-14 mb-0 input-mask" data-inputmask="'mask': '9-9999-99999-99-9'" @else class="text-muted fs-14 mb-0" @endif>
												{{ @$data['idcard'] }}
											</p>
											{{-- {{ @$id_card_exp }} --}}
										@endisset
									</div>
								</div>
							</li>
							<li class="mt-3">
								<div class="d-flex">
									<i class="bx bx-phone text-primary fs-4"></i>
									<div class="ms-3">
										<h6 class="fs-14 mb-2 fw-semibold">เบอร์ติดต่อ</h6>
										<p class="text-muted fs-14 mb-0 input-mask" data-inputmask="'mask': '999-999-9999,999-999-9999'">{{ @$data['phone'] }}</p>
									</div>
								</div>
							</li>
						</ul>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- end page -->
