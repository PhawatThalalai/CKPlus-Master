<style>
	.ribbon-2 {
		--f: 10px;
		/* control the folded part*/
		--r: 15px;
		/* control the ribbon shape */
		--t: 10px;
		/* the top offset */
		position: absolute;
		inset: var(--t) calc(-1*var(--f)) auto auto;
		padding: 0 10px var(--f) calc(10px + var(--r));
		clip-path:
			polygon(0 0, 100% 0, 100% calc(100% - var(--f)), calc(100% - var(--f)) 100%,
				calc(100% - var(--f)) calc(100% - var(--f)), 0 calc(100% - var(--f)),
				var(--r) calc(50% - var(--f)/2));
		background: #f54462;
		box-shadow: 0 calc(-1*var(--f)) 0 inset #0005;
	}
</style>

<div class="row mb-4">
	<div class="col-xl-4 col-lg-3 col-md-6 col-sm-12">
		<div class="card m-0 text-center bg-light h-100">
			<div class="d-flex flex-row-reverse asset-flag-bookmark-card-info">
				<div class="px-2">
					<span class="badge rounded-0 font-size-13 text-white triangle-success flag-bookmark fw-bold">
						<i class="mdi mdi-check-underline-circle h5 m-0"></i> active
					</span>
					<div class="triangle-success triangle"></div>
				</div>
			</div>

			<div class="">
				<div class="row hover-slide">
					<div class="col align-self-end">
						@if (@$asset->TypeAsset_Code == 'car' || @$asset->TypeAsset_Code == 'moto')
							<img src="{{ $asset->TypeAsset_Code == 'moto' ? URL::asset('/assets/images/asset/motorbike.png') : asset('/assets/images/asset/astCar.png') }}" alt="" class="img-fluid rounded-circle border border-3 border-success p-1" style="max-width: 40%; height: auto;">
						@else
							<img src="{{ URL::asset('/assets/images/asset/real-estate.png') }}" alt="" class="img-fluid rounded-circle border border-3 border-success p-1" style="max-width: 40%; height: auto;">
						@endif
					</div>
				</div>
			</div>

			<div class="my-2">
				<div class="col">
					<button class="rounded-pill btn-sm btn btn-soft-info fs-4" type="button">
						ประเภท : {{ (@$asset->TypeAsset_Code == 'moto' or $asset->TypeAsset_Code == 'car') ? @$asset->AssetToTypeAsset->Name_TypeAsset : @$asset->DataAssetToLandType->nametype_car }}
					</button>
				</div>
			</div>

			<div class="my-2">
				@switch(@$asset->Status_Asset)
					@case('Active')
						<span class="m-auto badge rounded-pill badge-success bg-success font-size-12" id="task-status">กำลังใช้งาน</span>
					@break

					@case('Blacklist')
					@case('Inactive')
						<span class="m-auto badge rounded-pill badge-danger bg-danger font-size-12" id="task-status">แบล็กลิสต์</span>
					@break

					@case('Hide')
						<span class="m-auto badge rounded-pill badge-dark bg-dark font-size-12" id="task-status">ถูกลบแล้ว</span>
					@break

					@default
						<span class="text-muted">ไม่ทราบสถานะ</span>
				@endswitch
			</div>

			@php
				if (roleUpdateStateAsset() == 'enabled') {
					$can_update_stateasset = true;
				} else {
					$can_update_stateasset = false;
				}
			@endphp

			@if (@$can_update_stateasset)
				<div class="mb-2 d-flex flex-wrap justify-content-center">

					@if ($asset->Status_Asset == 'Inactive' || $asset->Status_Asset == 'Blacklist')
						<a class="deletetask btn btn-success d-flex align-items-center m-1 updateState-dataAssetBtn" href="#" data-newstate="Active" data-assetid="{{ @$asset->id }}"><i class="bx bx-check fs-4 text-light pe-2"></i> เปิดใช้งาน</a>
					@endif

					@if ($asset->Status_Asset == 'Active')
						<a class="deletetask btn btn-danger d-flex align-items-center m-1 updateState-dataAssetBtn" href="#" data-newstate="Blacklist" data-assetid="{{ @$asset->id }}"><i class="bx bx-block fs-4 text-light pe-2"></i> ตั้งแบล็กลิสต์</a>
					@endif

					@hasrole(['superadmin', 'administrator'])
						@if ($asset->Status_Asset != 'Hide')
							<a class="deletetask btn btn-danger d-flex align-items-center m-1 delete-dataAssetBtn" href="#" data-assetid="{{ @$asset->id }}"><i class="bx bxs-trash fs-4 text-light pe-2"></i> ลบทรัพย์นี้</a>
						@endif
					@endhasrole

					<!--
						ยังไม่เปิดระบบกู้คืนทรัพย์
						<a class="deletetask btn btn-success d-flex align-items-center updateState-dataAssetBtn" href="#" data-newstate="Inactive" data-assetid="{{ @$asset->id }}"><i class="bx bx-revision fs-4 text-light pe-2"></i> กู้คืน</a>
					-->

				</div>
			@endif

		</div>
	</div>
	<div class="col-xl-8 col-lg-9 col-md-6 col-sm-12">
		<div class="h-100">
			<div class="px-4 border-bottom">
				@if (@$asset->TypeAsset_Code == 'car' || @$asset->TypeAsset_Code == 'moto')
					<div class="row mt-1 mb-0">
						<div class="mt-4 mt-md-auto">
							<a href="javascript: void(0);" class="text-primary">ประเภท</a>
							<h4 class="mt-1 mb-3">
								{{ @$asset->TypeAsset_Code == 'moto' ? @$asset->AssetToMotoBrand->Brand_moto . ' ' . @$asset->AssetToMotoGroup->Group_moto : @$asset->AssetToCarBrand->Brand_car . ' ' . @$asset->AssetToCarGroup->Group_car }}
								( {{ @$asset->TypeAsset_Code == 'moto' ? @$asset->AssetToMotoYear->Year_moto : @$asset->AssetToCarYear->Year_car }} )
							</h4>
							<div class="d-flex align-items-center mb-2">
								{{-- <h4 class="features-number fw-semibold display-6 me-3">MITSUBISHI : </h4> --}}
								{{-- <h4 class="mb-0 text-success">รถยนต์</h4> --}}
							</div>
							<h5 class="mb-4 text-warning fw-semibold">ราคากลาง : <span class="text-muted me-2"> {{ number_format(@$asset->Price_Asset, 2) }} บาท</span></h5>

							<p class="text-muted">
								<ins>รายละเอียดทรัพย์</ins>
								<span> :</span>
							</p>
							<div class="row mt-2">
								<div class="col-sm-6">
									<div class="text-muted">
										<p class="mb-2 hover-up">
											<i class="mdi mdi-alert-circle-check-outline text-success me-1"></i>
											<span class="fw-semibold"> ยี่ห้อรถ : </span>
											{{ @$asset->TypeAsset_Code == 'moto' ? @$asset->AssetToMotoBrand->Brand_moto : @$asset->AssetToCarBrand->Brand_car }}
										</p>
										<p class="mb-2 hover-up">
											<i class="mdi mdi-alert-circle-check-outline text-success me-1"></i>
											<span class="fw-semibold"> กลุ่มรถ : </span>
											{{ @$asset->TypeAsset_Code == 'moto' ? @$asset->AssetToMotoGroup->Group_moto : @$asset->AssetToCarGroup->Group_car }}
										</p>
										<p class="mb-2 hover-up">
											<i class="mdi mdi-alert-circle-check-outline text-success me-1"></i>
											<span class="fw-semibold"> รุ่นรถ : </span>
											{{ @$asset->TypeAsset_Code == 'moto' ? @$asset->AssetToMotoModel->Model_moto : @$asset->AssetToCarModel->Model_car }}
										</p>
										<p class="mb-2 hover-up">
											<i class="mdi mdi-alert-circle-check-outline text-success me-1"></i>
											<span class="fw-semibold"> ปีรถ : </span>
											{{ @$asset->TypeAsset_Code == 'moto' ? @$asset->AssetToMotoYear->Year_moto : @$asset->AssetToCarYear->Year_car }}
										</p>
										<p class="mb-2 hover-up">
											<i class="mdi mdi-alert-circle-check-outline text-success me-1"></i>
											<span class="fw-semibold"> เกียร์รถ : </span>
											{{ @$asset->Vehicle_Gear }}
										</p>
										<p class="mb-2 hover-up">
											<i class="mdi mdi-alert-circle-check-outline text-success me-1"></i>
											<span class="fw-semibold"> สีรถ : </span>
											{{ @$asset->Vehicle_Color }}
										</p>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="text-muted">
										<p class="mb-2 hover-up">
											<i class="mdi mdi-alert-circle-check-outline text-success me-1"></i>
											<span class="fw-semibold"> ทะเบียนเก่า : </span>
											{{ @$asset->Vehicle_OldLicense }}
										</p>
										<p class="mb-2 hover-up">
											<i class="mdi mdi-alert-circle-check-outline text-success me-1"></i>
											<span class="fw-semibold"> ทะเบียนใหม่ : </span>
											{{ @$asset->Vehicle_NewLicense }}
										</p>
										<p class="mb-2 hover-up">
											<i class="mdi mdi-alert-circle-check-outline text-success me-1"></i>
											<span class="fw-semibold"> เลขถัง : </span>
											{{ @$asset->Vehicle_Chassis }}
										</p>
										<p class="mb-2 hover-up">
											<i class="mdi mdi-alert-circle-check-outline text-success me-1"></i>
											<span class="fw-semibold"> เลขเครื่อง : </span>
											{{ @$asset->Vehicle_Engine }}
										</p>
										<p class="mb-2 hover-up">
											<i class="mdi mdi-alert-circle-check-outline text-success me-1"></i>
											<span class="fw-semibold"> เลขไมล์ : </span>
											{{ @$asset->Vehicle_Miles }}
										</p>
										<p class="mb-2 hover-up">
											<i class="mdi mdi-alert-circle-check-outline text-success me-1"></i>
											<span class="fw-semibold"> เลข CC : </span>
											{{ @$asset->Vehicle_CC }}
										</p>
									</div>
								</div>
							</div>
						</div>
					</div>
				@else
				@endif
			</div>
		</div>
	</div>
</div>

<section id="roadmap">
	<div class="container">
		<div class="row mb-2">
			<div class="col-lg-12">
				<div class="text-center">
					<h4 class="bg-danger bg-opacity-10 py-2 text-muted rounded-pill">รายละเอียดการครอบครองทรัพย์</h4>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<div class="hori-timeline" dir="ltr">
					<div class="owl-carousel owl-theme events navs-carousel" id="timeline-carousel">
						@foreach ($asset->AssetToManyOwner as $key => $owner)
							<div class="item event-list" style="cursor: pointer;">
								<div class="px-1">
									<div class="event-date">
										<div class="text-primary mb-1"> {{ formatDateThaiLong(@$owner->created_at) }} </div>
										<h5 class="mb-4 text-truncate">{{ @$owner->OwnershipToCus->Name_Cus }}</h5>
									</div>
									<div class="event-down-icon">
										<span><i class="bx bx bx-user-circle h1 text-primary down-arrow-icon"></i></span>
									</div>
									<div class="hover-slide">
										<div class="card border border-primary text-start h-100" style="margin-bottom: 0px">
											<input type="hidden" name="id_cardEvent">
											<div class="card-body">
												<div class="float-end">
													<div class="box">
														<div class="ribbon-2 text-light">ลำดับที่ {{ count(@$asset->AssetToManyOwner) - $key }} &nbsp;</div>
													</div>
												</div>
												<div>
													<h5 class="font-size-13 card-title">
														<a href="javascript: void(0);" class="text-warning">
															สถานะ : <span>{{ @$owner->State_Ownership }}</span>
														</a>
													</h5>
													<p class="text-muted mb-2 mt-n1 font-size-12 blockquote-footer text-truncate"><em> {{ @$owner->StatusOwnership->name_th }}</em></p>
													<div class="row mt-2">
														<div class="col-12">
															<p class="mb-2">
																<i class="bx bxs-purchase-tag bg-soft m-0 text-success h5"></i>
																<span class="fw-semibold"> สถานะ : </span>
																<span class="float-end">
																	@if (@$owner->OwnershipToPactIndenture)
																		<span class="text-muted"> {{ @$owner->OwnershipToPactIndenture->IndenAssetToContract->StatusApp_Con }}</span>
																	@else
																		<em class="text-secondary text-opacity-50">-</em>
																	@endif
																</span>
																<br>
																<i class="bx bx-fridge bg-soft m-0 text-success h5"></i>
																<span class="fw-semibold"> เลขสัญญา : </span>
																<span class="float-end">
																	@if (@$owner->OwnershipToPactIndenture)
																		<a href="{{ route('contract.edit', @$owner->OwnershipToPactIndenture->IndenAssetToContract->id) }}?funs={{ 'contract' }}" target="_blank">
																			<span class="text-primary">{{ @$owner->OwnershipToPactIndenture->IndenAssetToContract->Contract_Con }}</span>
																		</a>
																	@else
																		<em class="text-secondary text-opacity-50">-</em>
																	@endif
																</span>
																<br>
																<i class="mdi mdi-calendar bg-soft m-0 text-success h5"></i>
																<span class="fw-semibold"> วันที่ผูกพัน : </span>
																<span class="float-end">
																	@if (@$owner->OwnershipToPactIndenture)
																		<span class="text-muted">{{ formatDateThaiLong(@$owner->OwnershipToPactIndenture->created_at) }}</span>
																	@else
																		<em class="text-secondary text-opacity-50">-</em>
																	@endif
																</span>
															</p>
														</div>
													</div>
												</div>
											</div>
											<div class="card-footer mt-n4" style="padding-bottom: 0px">
												<div class="dropdown float-start me-2">
													<h5 class="font-size-13 card-title">
														<span class="text-warning">
															<i class="mdi mdi-account-circle-outline"></i> : {{ @$owner->OwnershipToUser->name }}
														</span>
													</h5>
													<p class="text-muted mb-2 font-size-12 mt-n1 blockquote-footer">
														<em>
															<span class="text-secondary text-opacity-50">
																{{ @$owner->OwnershipToUser->UserToBranch->Name_Branch }} ({{ @$owner->OwnershipToUser->UserToBranch->Zone_Branch }})
															</span>
														</em>
													</p>
												</div>
												<div class="dropdown float-end mt-1">
													<button type="button" class="rounded-circle btn-sm btn btn-info hover-up" data-bs-toggle="tooltip" title="รายละเอียดเพิ่มเติม">
														<i class="bx bx-show-alt m-0 font-size-15"></i>
													</button>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						@endforeach

						{{-- <div class="item event-list active" style="cursor: pointer;">
							<div class="px-1">
								<div class="event-date">
									<div class="text-primary mb-1"> February, 2020 </div>
									<h5 class="mb-4 text-truncate">นายบูรกีนี อาแว</h5>
								</div>
								<div class="event-down-icon">
									<span><i class="bx bx bx-user-circle h1 text-primary down-arrow-icon"></i></span>
								</div>
								<div class="hover-slide">
									<div class="card border border-primary text-start h-100" style="margin-bottom: 0px">
										<input type="hidden" name="id_cardEvent">

										<div class="card-body">
											<div class="float-end">
												<div class="box">
													<div class="ribbon-2 text-light">ลำดับที่ 1 &nbsp;</div>
												</div>
											</div>
											<div>
												<h5 class="font-size-13 card-title">
													<a href="javascript: void(0);" class="text-warning">
														สถานะ : <span>ครอบครองชั่วคร่าว</span>
													</a>
												</h5>
												<p class="text-muted mb-2 mt-n1 font-size-12 blockquote-footer text-truncate"><em> ครอบครองชั่วคร่าว</em></p>
												<div class="row mt-2">
													<div class="col-12">
														<p class="mb-2">
															<i class="mdi mdi-calendar m-0 text-success h5"></i>
															<span class="fw-semibold"> วันที่ผูกพัน : </span>
															<span class="float-end">
																<em class="text-secondary text-opacity-50">-</em>
															</span>
															<br>
															<i class="mdi mdi-call-merge hover-up bg-soft m-0 text-success h5"></i>
															<span class="fw-semibold"> สัญญาผูกพัน : </span>
															<span class="float-end">
																<em class="text-secondary text-opacity-50">-</em>
															</span>
														</p>
													</div>
												</div>
											</div>
										</div>
										<div class="card-footer mt-n4" style="padding-bottom: 0px">
											<div class="dropdown float-start me-2">
												<h5 class="font-size-13 card-title">
													<span class="text-warning">
                                                        <i class="mdi mdi-account-circle-outline"></i> : 
                                                    </span>
												</h5>
												<p class="text-muted mb-2 font-size-12 mt-n1 blockquote-footer">
													<em>
														<span class="text-secondary text-opacity-50">ไม่พบข้อมูล</span>
													</em>
												</p>
											</div>
											<div class="dropdown float-end mt-1">
												<button type="button" class="rounded-circle btn-sm btn btn-info hover-up" data-bs-toggle="tooltip" title="รายละเอียดเพิ่มเติม">
													<i class="mdi mdi-book-search m-0 font-size-15"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="item event-list">
							<div>
								<div class="event-date">
									<div class="text-primary mb-1">March, 2020</div>
									<h5 class="mb-4">ICO Launch Platform</h5>
								</div>
								<div class="event-down-icon">
									<i class="bx bx-down-arrow-circle h1 text-primary down-arrow-icon"></i>
								</div>

								<div class="mt-3 px-3">
									<p class="text-muted">New common language will be more simple than existing.</p>
								</div>
							</div>
						</div>
					</div> --}}
					</div>
				</div>
			</div>
		</div>
</section>

<script>
	$(function() {
		$(".input-mask").inputmask();
		$('[data-bs-toggle="tooltip"]').tooltip();
	});
</script>

<!-- ICO landing init -->
<script src="{{ URL::asset('/assets/js/pages/ico-landing.init.js') }}"></script>

<script>
	$(document).off('click', '.updateState-dataAssetBtn').on('click', '.updateState-dataAssetBtn', function(e) {
		e.preventDefault();
		console.log($(this).data('assetid'));
		console.log($(this).data('newstate'));
		var assetId = $(this).data('assetid');
		var newState = $(this).data('newstate');

		var filter_asset = $("#filter_asset").val();

		var helpText = "";
		switch (newState) {
			case 'Active':
				helpText = "<p class='m-0 text-dark'>อัปเดตสถานะทรัพย์นี้เป็น <strong class='text-success'><i class='bx bx-check fs-4'></i> เปิดใช้งาน</strong> ?</p>"
				break;
			case 'Blacklist':
				helpText = "<p class='m-0 text-dark'>อัปเดตสถานะทรัพย์นี้เป็น <strong class='text-danger'><i class='bx bx-x fs-4'></i> แบล็กลิสต์</strong> ?</p>"
				break;
			case 'Hide':
				helpText = "<p class='m-0 text-dark'>คุณต้องการที่จะ <strong class='text-danger'><i class='bx bxs-trash fs-4'></i> ลบทรัพย์</strong> นี้ ?</p>"
				break;
			default:
				return;
				break;
		}
		//-----------------------------------------------------------
		Swal.fire({
			icon: 'warning',
			title: 'กรุณาตรวจสอบ',
			html: helpText,
			showCancelButton: true,
			focusConfirm: false,
			confirmButtonText: 'ยืนยัน',
			cancelButtonText: 'ยกเลิก',
			confirmButtonColor: '#d33',
			showLoaderOnConfirm: true,
			allowEscapeKey: false,
			allowEnterKey: false,
			preConfirm: function(login) {
				var link = `{{ route('asset.update', 'id') }}`;
				var url = link.replace('id', assetId);
				return $.ajax({
					url: url,
					type: 'put',
					data: {
						_token: '{{ csrf_token() }}',
						mod: 'state',
						Status_Asset: newState,
						page: 'asset',
					},
					complete: function(data) {
						console.log(data);
					},
					success: function(result) {
						console.log("success!");
						console.log(result);
						Swal.fire({
							icon: 'success',
							title: 'สำเร็จ!',
							text: result.message,
							showConfirmButton: false,
							timer: 1500
						});
						$('.asset-detail').slideUp('slow').slideDown('slow').html(result.html);
					},
					error: function(xhr, status, error) {
						// Get the error message from the response
						var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "ข้อผิดพลาดที่ไม่รู้จัก :'(";
						var errorFile = xhr.responseJSON.file ? xhr.responseJSON.file : '';
						errorFile = errorFile.replace(/^.*[\\\/]/, '');
						var errorLine = xhr.responseJSON.line ? xhr.responseJSON.line : '';
						var errorHtml = "<p>" + errorMessage + "</p>";
						errorHtml += "<p class='m-0 small'>" + errorFile + " <strong>(บรรทัดที่ " + errorLine + ")</strong></p>";
						// Display the error message using SweetAlert2
						Swal.fire({
							icon: 'error',
							title: error,
							html: `<p class="m-0">ขออภัย! เกิดข้อผิดพลาด กดดูเพิ่มเติมเพื่อแสดงรายละเอียด</p><p class="my-1 small">(${status})</p>`,
							showCancelButton: true,
							confirmButtonText: 'ดูเพิ่มเติม',
							cancelButtonText: 'OK'
						}).then((result) => {
							if (result.isConfirmed) {
								// If the user clicks "More Details," show the detailed error message in a new SweetAlert2 modal
								Swal.fire({
									icon: 'error',
									title: 'รายละเอียด',
									//text: errorMessage,
									html: errorHtml,
									confirmButtonText: 'OK'
								});
							}
						});
					}
				});
			},
			allowOutsideClick: () => !Swal.isLoading()
		});
		//-----------------------------------------------------------
	});

	$(document).off('click', '.delete-dataAssetBtn').on('click', '.delete-dataAssetBtn', function(e) {
		e.preventDefault();
		console.log($(this).data('assetid'));
		var assetId = $(this).data('assetid');
		var filter_asset = $("#filter_asset").val();
		var helpText = "<p class='m-0 text-dark'>คุณต้องการที่จะ <strong class='text-danger'><i class='bx bxs-trash fs-4'></i> ลบทรัพย์</strong> นี้ ?</p><p class='m-0 pt-2 text-danger fw-bold small'>* การดำเนินการนี้จะเป็นการลบทรัพย์นี้ทิ้ง *<br>* ข้อมูลการครอบครองทรัพย์นี้จากลูกค้าทุกคนจะหายไปด้วย *</p>";
		//-----------------------------------------------------------
		Swal.fire({
			icon: 'warning',
			title: 'กรุณาตรวจสอบ',
			html: helpText,
			showCancelButton: true,
			focusConfirm: false,
			confirmButtonText: 'ยืนยัน',
			cancelButtonText: 'ยกเลิก',
			confirmButtonColor: '#d33',
			showLoaderOnConfirm: true,
			allowEscapeKey: false,
			allowEnterKey: false,
			preConfirm: function(login) {
				var link = `{{ route('asset.destroy', 'id') }}`;
				var url = link.replace('id', assetId);
				return $.ajax({
					url: url,
					type: 'DELETE',
					data: {
						_token: '{{ csrf_token() }}',
						mod: 'asset',
						page: 'asset',
					},
					complete: function(data) {
						console.log(data);
					},
					success: function(result) {
						console.log("success!");
						console.log(result);
						Swal.fire({
							icon: 'success',
							title: 'สำเร็จ!',
							text: result.message,
							showConfirmButton: false,
							timer: 1500
						});
						$('.asset-detail').slideUp('slow').slideDown('slow').html(result.html);
					},
					error: function(xhr, status, error) {
						// Get the error message from the response
						var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "ข้อผิดพลาดที่ไม่รู้จัก :'(";
						var errorFile = xhr.responseJSON.file ? xhr.responseJSON.file : '';
						errorFile = errorFile.replace(/^.*[\\\/]/, '');
						var errorLine = xhr.responseJSON.line ? xhr.responseJSON.line : '';
						var errorHtml = "<p>" + errorMessage + "</p>";
						errorHtml += "<p class='m-0 small'>" + errorFile + " <strong>(บรรทัดที่ " + errorLine + ")</strong></p>";
						// Display the error message using SweetAlert2
						Swal.fire({
							icon: 'error',
							title: error,
							html: `<p class="m-0">ขออภัย! เกิดข้อผิดพลาด กดดูเพิ่มเติมเพื่อแสดงรายละเอียด</p><p class="my-1 small">(${status})</p>`,
							showCancelButton: true,
							confirmButtonText: 'ดูเพิ่มเติม',
							cancelButtonText: 'OK'
						}).then((result) => {
							if (result.isConfirmed) {
								// If the user clicks "More Details," show the detailed error message in a new SweetAlert2 modal
								Swal.fire({
									icon: 'error',
									title: 'รายละเอียด',
									//text: errorMessage,
									html: errorHtml,
									confirmButtonText: 'OK'
								});
							}
						});
					}
				});
			},
			allowOutsideClick: () => !Swal.isLoading()
		});
		//-----------------------------------------------------------

	});
</script>
