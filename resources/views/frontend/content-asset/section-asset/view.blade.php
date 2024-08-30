@extends('layouts.master')
@section('title', 'data assets')
@section('assets-active', 'mm-active')
@section('page-backend', 'd-none')

@section('content')
	{{-- setup search --}}
	@include('components.content-toast.view-toast')
	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])
	@component('components.breadcrumb')
		@slot('title')
			DATA ASSETS
		@endslot
		@slot('title_small')
			(ข้อมูลทรัพย์)
		@endslot
		@slot('menu')
			ระบบ ฐานทรัพย์
		@endslot
		@slot('sub_menu')
			รายการ ทรัพย์
		@endslot
	@endcomponent

	<div class="card">
		<div class="card-body">
			<div class="row pt-3 mb-2 search-box-top" style="display: none">
				<div class="col-lg-12">
					<div class="text-center">
						<div class="row mb-1">
							<div class="col-12 d-flex justify-content-between">
								<span>
									<span class="text-search" style="cursor: pointer;"></span>
									<span class="text-search-selected" style="cursor: pointer;"></span>
								</span>

								<span class="mt-4 mt-sm-0 float-sm-end d-sm-flex align-items-center">
									<div class="search-box me-2">
										<div class="position-relative d-flex">
											<button class="btn btn-light hover-up position-absolute btn_assetpage">
												<i class="bx bx-search-alt font-size-14"></i>
											</button>
											<input type="text" id="inputSr_assetpage" class="form-control bg-light border-light rounded ps-5 inputAssetSeachTopBar" placeholder="Enter asset ...">
											<!--
												<span class="btn btn-outline-primary btn_assetpage">
													<i class="bx bx-search-alt search-icon hover-up" style="cursor: pointer"></i>
												</span>
												-->
										</div>
									</div>
									<div class="btn-group">
										<button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
											<i class="mdi mdi-chevron-down"></i>
										</button>
										<div class="dropdown-menu">
											<a class="dropdown-item d-flex justify-content-start type-assets typeAsset-license" data-value="license">
												<i class="bx bx-wrench text-info fs-4"></i><span class="ms-2"> เลขทะเบียน</span>
											</a>
											<a class="dropdown-item d-flex justify-content-start type-assets typeAsset-chassis" data-value="chassis">
												<i class="bx bx-wrench text-info fs-4"></i><span class="ms-2"> เลขถัง</span>
											</a>
											<a class="dropdown-item d-flex justify-content-start type-assets typeAsset-land_id" data-value="land_id">
												<i class="bx bx-map text-info fs-4"></i><span class="ms-2"> เลขที่โฉนด</span>
											</a>
										</div>
									</div>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<input type="text" hidden class="page-typeAssetSr">
			<div id="content-assets">
				<div class="content-loading m-5" style="display: none !important">
					<br><br>
					<div class="lds-facebook mb-6">
						<div></div>
						<div></div>
						<div></div>
					</div>
				</div>
				<div class="container-asset">
					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<div class="text-center mb-5">
									<h4 class="fw-semibold">Search asset infomations</h4>
								</div>
							</div>
						</div>
						<div class="row align-items-center pt-4">
							<div class="col-md-6 col-sm-8">
								<div>
									<img src="assets/images/crypto/features-img/img-1.png" alt="" class="img-fluid mx-auto d-block">
								</div>
							</div>
							<div class="col-md-5 ms-auto">
								<div class="mt-4 mt-md-auto">
									<div class="d-flex align-items-center mb-2">
										<div class="features-number fw-semibold display-4 me-3">ประเภท</div>
										<h3 class="mb-0 text-info up-down text-selected text-danger">กรุณาเลือกประเภท</h3>
									</div>
									<p class="text-danger text-opacity-75">โปรดระบุประเภทการค้นหาของทรัพย์ ระบบจะแสดงการครอบครอง และรายละเอียดของทรัพย์.</p>
									<div class="input-group bg-light rounded">
										<input type="text" id="input_assetSearch" class="form-control bg-transparent border-0 inputAssetSearch" placeholder="กรุณาเลือกประเภทก่อน" aria-label="Recipient's username" aria-describedby="button-addon2">
										<div class="btn-group" data-bs-toggle="tooltip" title="ประเภท">
											<button type="button" class="btn btn-secondary dropdown-toggle btn-soft-secondary me-1" data-bs-toggle="dropdown" aria-expanded="false">
												<span id="type_selectSr"></span> <i class="mdi mdi-chevron-down"></i>
											</button>
											<div class="dropdown-menu">
												<a class="dropdown-item d-flex justify-content-start type-assets typeAsset-license" data-value="license">
													<i class="bx bx-wrench text-info fs-4"></i><span class="ms-2"> เลขทะเบียน</span>
												</a>
												<a class="dropdown-item d-flex justify-content-start type-assets typeAsset-chassis" data-value="chassis">
													<i class="bx bx-wrench text-info fs-4"></i><span class="ms-2"> เลขถัง</span>
												</a>
												<a class="dropdown-item d-flex justify-content-start type-assets typeAsset-land_id" data-value="land_id">
													<i class="bx bx-map text-info fs-4"></i><span class="ms-2"> เลขที่โฉนด</span>
												</a>
											</div>
										</div>
										<button class="btn btn-primary btn_search" type="button" data-bs-toggle="tooltip" title="ค้นหา">
											<span class="addSpin"><i class="bx bx-search-alt"></i></span>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col asset-detail">
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			$('.type-assets').click(function() {
				let clickedClass = $(this).attr('data-value');

				if (clickedClass == 'license') {
					$('.text-selected').text('รถยนต์ / รถจักรยานยนต์');
					$('#input_assetSearch,#inputSr_assetpage').attr('placeholder', 'กรอกเลขทะเบียน...');
				} else if (clickedClass == 'chassis') {
					$('.text-selected').text('รถยนต์ / รถจักรยานยนต์');
					$('#input_assetSearch,#inputSr_assetpage').attr('placeholder', 'กรอกเลขถัง...');
				} else {
					$('.text-selected').text('ที่ดิน');
					$('#input_assetSearch,#inputSr_assetpage').attr('placeholder', 'กรอกเลขที่โฉนด...');
				}
				$('.text-selected').removeClass('text-danger');

				$('#input_assetSearch,#inputSr_assetpage').val('');
				$('#input_assetSearch').focus();
				$('.type-assets').removeClass('active');

				$('.typeAsset-' + clickedClass).addClass('active');
				$('.page-typeAssetSr').val($(this).attr('data-value'));
			});

			$('.btn_search,.btn_assetpage').click(function() {
				event.preventDefault();

				var buttonClicked = $(this);

				let type_search = $('.page-typeAssetSr').val();
				if ($(this).hasClass('btn_search')) {
					var input_search = $('#input_assetSearch').val();
					$('#inputSr_assetpage').val(input_search);
				} else {
					var input_search = $('#inputSr_assetpage').val();
				}

				if (input_search && type_search) {
					$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
					$(this).attr('disabled', true).find('.addSpin').html('<span class="spinner-border spinner-border-sm" role="status"></span>');

					if ($(this).hasClass('btn_assetpage')) {
						$('.asset-detail').slideUp('slow');
					}

					$.ajax({
						url: "{{ route('asset.SearchData') }}",
						method: 'post',
						data: {
							_token: "{{ @csrf_token() }}",
							mode: 'data-assets',
							input_search: input_search,
							type_search: type_search,
						},
						success: function(result) {
							$('.search-box-top').fadeIn().attr('style', '');
							$('.container-asset').slideDown('slow').html(result.html);
							$('.text-search').html('รายการค้นหา : <span class="text-primary">' + input_search + '</span>');

							$(".toast-success").toast({
								delay: 1500
							}).toast("show");
							$(".toast-success .toast-body .text-body").text("ค้นหาสำเร็จ");
						},
						error: function(err) {
							Swal.fire({
								icon: 'error',
								title: `ERROR ` + err.status + ` !!!`,
								text: err.responseJSON.message,
								showConfirmButton: true,
							});
						},
						complete: function() {
							$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **

							buttonClicked.attr('disabled', false);
							buttonClicked.find('.addSpin').html('');
							//$('.btn_search').find('.addSpin').html('<i class="bx bx-search-alt"></i>');
						}
					});
				} else {
					if (type_search == '') {
						var textSwal = 'กรุณาเลือกประเภท ก่อนค้นหา. !';
					} else if (input_search == '') {
						var textSwal = 'กรุณากรอกข้อมูลให้ครบถ้วน ก่อนค้นหา. !';
					}

					Swal.fire({
						icon: 'warning',
						title: `แจ้งเตือน`,
						text: textSwal,
						showConfirmButton: false,
						timer: 2000,
					});
				}
			});

			$('.text-search').click(function() {
				$('.asset-detail').slideUp();
				$('.text-search-selected').html('');

				$('.container-asset').slideDown('slow');
			});

			EnterToSubmit('inputAssetSearch', 'btn_search');
			EnterToSubmit('inputAssetSeachTopBar', 'btn_assetpage');

		});
	</script>
@endsection
