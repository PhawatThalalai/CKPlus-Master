@extends('layouts.master')
@section('title', 'customers')
@section('datacus-active', 'mm-active')
@section('cus-active', 'mm-active')
@section('page-backend', 'd-none')

@section('content')

	<style>
		.blockbtn {
			pointer-events: none;
		}
	</style>
	{{-- setup search --}}
	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])
	@component('components.breadcrumb')
		@slot('title')
			Customer info
		@endslot
		@slot('title_small')
			(ข้อมูลลูกค้า)
		@endslot
		@slot('menu')
			ระบบ ฐานลูกค้า
		@endslot
		@slot('sub_menu')
			รายการ ลูกค้า
		@endslot
	@endcomponent

	<div class="row g-3">
		<!-- แผง การ์ด โปรไฟล์ ด้านซ้าย -->
		<div class="col-xl-3 col-lg-12 col-md-12 col-sm-12">
			<div id="card-profile">
				@include('components.content-user.view-card-profile', ['data' => @$data])
			</div>
		</div>
		@isset($data)
			<div class="col-xl-9 col-lg-12 col-md-12 col-sm-12">
				<div class="tab-content text-muted" id="viewCus_tabContent">
					<div class="tab-pane active show" id="data_user" role="tabpanel">
						<!-- header Tab panes -->
						<ul class="nav nav-pills nav-justified section bg-white p-3" role="tablist">
							<li class="nav-item waves-effect waves-light btn-tab" role="presentation" onclick="getContent('card-user','content_cus')">
								<a class="nav-link active" data-bs-toggle="tab" href="#card-user" role="tab" aria-selected="true">
									<span class="d-block d-sm-none"><i class="far fa-user"></i></span>
									<span class="d-none d-sm-block">
										<i class="far fa-user icon_content_cus"></i>
										<span class="loading_content_cus"></span>
										<b>รายละเอียดลูกค้า</b>
									</span>
								</a>
							</li>

							<li class="nav-item waves-effect waves-light btn-tab {{ @$flag }}" role="presentation" onclick="getContent('card-tag','content_tag')">
								<a class="nav-link" data-bs-toggle="tab" href="#card-tag" role="tab" aria-selected="false" tabindex="-1">
									<span class="d-block d-sm-none"><i class="fas fa-user-tag"></i></span>
									<span class="d-none d-sm-block">
										<i class="fas fa-user-tag icon_content_tag"></i>
										<span class="loading_content_tag"></span>
										<b>บันทึกติดตาม</b>
									</span>
								</a>
							</li>
						</ul>
						<!-- Tab panes -->
						<div class="tab-content pt-1 text-muted">
							<div class="tab-pane active show" id="card-user" role="tabpanel">
								<div id="content_cus">
								</div>
								<div class="content_cus" style="display: none;">
									@include('frontend.content-cus.section-error.user-empty')
								</div>
								<div class="mt-n2">
									<div class="card">
										<div class="card-body">
											<ul class="nav nav-pills nav-justified" role="tablist">
												<li class="nav-item waves-effect waves-light btn-tab" onclick="getContent('insert-adds','user-address','{{ @$data->id }}')" role="presentation" onclick="resetScroll('scroll-slide-1');">
													<a class="nav-link active" data-bs-toggle="tab" href="#user-address" role="tab" aria-selected="true">
														<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
														<span class="d-none d-sm-block">ข้อมูลที่อยู่ <span class="loading_user-address"></span></span>
													</a>
												</li>
												<li class="nav-item waves-effect waves-light btn-tab" onclick="getContent('insert-Career','user-career','{{ @$data->id }}')" role="presentation" onclick="resetScroll('scroll-slide-2');">
													<a class="nav-link" data-bs-toggle="tab" href="#user-career" role="tab" aria-selected="false" tabindex="-1">
														<span class="d-block d-sm-none"><i class="far fa-user"></i></span>
														<span class="d-none d-sm-block">ข้อมูลอาชีพ <span class="loading_user-career"></span></span>
													</a>
												</li>
												<li class="nav-item waves-effect waves-light btn-tab" onclick="getContent('insert-Asset','user-asset','{{ @$data->id }}')" role="presentation" onclick="resetScroll('scroll-slide-3');">
													<a class="nav-link" data-bs-toggle="tab" href="#user-asset" role="tab" aria-selected="false" tabindex="-1">
														<span class="d-block d-sm-none"><i class="far fa-envelope"></i></span>
														<span class="d-none d-sm-block">ทรัพย์ค้ำประกัน <span class="loading_user-asset"></span></span>
													</a>
												</li>
											</ul>
											<div class="tab-content p-3">
												<div class="tab-pane fade active show" id="user-address" role="tabpanel"></div>
												<div class="user-address" style="display: none;">
													@include('frontend.content-cus.section-error.card-user-empty')
												</div>
												<div class="tab-pane fade" id="user-career" role="tabpanel"></div>
												<div class="user-career" style="display: none;">
													@include('frontend.content-cus.section-error.card-user-empty')
												</div>
												<div class="tab-pane fade" id="user-asset" role="tabpanel"></div>
												<div class="user-asset" style="display: none;">
													@include('frontend.content-cus.section-error.card-user-empty')
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="tab-pane" id="card-tag" role="tabpanel">
								<div id="content_tag">
								</div>
								<div class="content_tag" style="display: none;">
									@include('frontend.content-cus.section-error.card-tag-empty')
								</div>
							</div>
						</div>
					</div>
					<div class="tab-pane" id="data_asset" role="tabpanel" data-loaded="fail">
						<div class="content-loading m-3" style="display: none !important">
							<br><br>
							<div class="lds-facebook mb-6">
								<div></div>
								<div></div>
								<div></div>
							</div>
						</div>
						<div id="content_asset">
							<!-- สำหรับโหลดหน้าทรัพย์มาใส่ตรงนี้ -->

							<style>
								.assetView-card-body-4-card,
								.assetView-card-body-2-card {
									background-image: linear-gradient(to bottom, rgba(var(--bs-light-rgb), 0.6) 0%, rgba(var(--bs-light-rgb), 0.9) 100%), url('{{ asset('assets/images/undraw/undraw_empty_street.svg') }}');
								}
							</style>
							<div class="card m-0" style="overflow: hidden;">
								<div style ="position: absolute; top: 3rem; left:2rem; z-index: 2;">

									<div class="d-flex align-items-center" style="right: auto; left: 1em; position: relative; bottom: 1em; font-size: large;">

										<a style="background-color: rgba(186, 209, 246, 1); display: block; width: 3.5em; height: 3.5em; border-radius: 50%; box-shadow: 0 4px 10px 0 hsla(0, 0%, 0%, .26); color: rgb(59, 130, 246); text-align: center; line-height: 4.4; cursor: wait;">
											<i class="spinner-border" style="transition: transform .2s; line-height: 4rem;"></i>
										</a>

									</div>

								</div>

								<!-- card-body Asset View 4 Card -->
								<div class="card-body bg-light assetView-card-body-4-card px-0 pb-0">
									<nav aria-label="filter asset card" class="position-absolute end-0 pe-5 filter-asset">
										<ul class="nav nav-pills justify-content-end">
											<li class="nav-item">
												<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">ตัวกรอง :</a>
											</li>
											<li class="nav-item filter-lastest-asset">
												<a class="nav-link disabled placeholder">
													<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
												</a>
											</li>
										</ul>
									</nav>
									<nav @style(['visibility: visible;'])>
										<ul class="pagination justify-content-center">
											<li class="page-item prev">
												<a class="page-link disabled placeholder" role="button" data-bs-slide="prev" aria-label="Previous">
													<span aria-hidden="true">&laquo;</span>
												</a>
											</li>
											{{-- Create Asset Page Button --}}
											<li class="page-item active"><a class="page-link disabled placeholder" data-bs-slide-to="0">1</a></li>
											<li class="page-item next">
												<a class="page-link disabled placeholder" role="button" data-bs-slide="next" aria-label="Next">
													<span aria-hidden="true">&raquo;</span>
												</a>
											</li>
										</ul>
									</nav>
									{{-- var_dump(@$dataAsset) --}}
									{{-- $countAssetCard --}}
									<div id="carouselAssetList_c4" class="carousel carousel-asset-4card slide" data-bs-interval="false">
										<div class="carousel-inner" style="min-height: 42rem; max-height: 40rem;">
											{{-- Create All Asset Pages (1 Page have 4 Card) --}}
											<div class="carousel-item active">
												<div class="row p-3 px-4">
													<div class="col-lg-6 px-3">
														{{-- Asset Card --}}
														<div style="min-height: 16rem;" class="card rounded-4 hover-up asset-card-hover cardasst placeholder-glow">
															<div class="card-header bg-transparent border-bottom text-uppercase rounded-top" style="--bs-border-radius: 1rem;">
																<div class="d-flex align-items-center">
																	<span class="placeholder col-2 bg-info"></span>
																	<span class="placeholder ms-auto col-5"></span>
																</div>
															</div>
															<div class="card-body p-2">

																<div class="row h-100">
																	<div class="col border-end">

																		<!-- แสดงสถานะประกัน เเฉพาะ รถยนต์ เท่านั้น -->

																		<!-- รูปภาพทรัพย์ -->
																		<div class="col-12 m-auto text-center my-5">
																			<div class="spinner-grow" style="width: 1rem; height: 1rem;" role="status">
																				<span class="visually-hidden">Loading...</span>
																			</div>
																		</div>

																		<div class="col-12 mt-2 text-center">
																			<h5 class="fw-semibold placeholder col-8"></h5>
																			<div class="row">
																				<div class="col-6 text-center border-end px-1">
																					<p class="fw-semibold fs-6 mb-0">ประเภท</p>
																					<p class="m-0 placeholder col-6"></p>
																				</div>
																				<div class="col-6 text-center px-1">
																					<p class="fw-semibold fs-6 mb-0 placeholder col-9"></p>
																					<p class="m-0"><span class="placeholder col-8"></span> ฿</p>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-12 col-md-7 d-none d-md-block">
																		<table class="table table-sm table-nowrap mb-0 asset-table-card-info">
																			<tbody>
																				<tr>
																					<th scope="row"><i class="bx bx-info-circle text-success"></i> <span class="placeholder col-12"></span></th>
																					<td class="text-end"><span class="placeholder col-6"></span></td>
																				</tr>
																				<tr>
																					<th scope="row"><i class="bx bx-info-circle text-success"></i> <span class="placeholder col-4"></span></th>
																					<td class="text-end"><span class="placeholder col-6"></span></td>
																				</tr>
																				<tr>
																					<th scope="row"><i class="bx bx-info-circle text-success"></i> <span class="placeholder col-6"></span></th>
																					<td class="text-end"><span class="placeholder col-6"></span></td>
																				</tr>
																				<tr>
																					<th scope="row"><i class="bx bx-info-circle text-success"></i> <span class="placeholder col-8"></span></th>
																					<td class="text-end"><span class="placeholder col-6"></span></td>
																				</tr>
																				<tr>
																					<th scope="row"><i class="bx bx-info-circle text-success"></i> <span class="placeholder col-4"></span></th>
																					<td class="text-end"><span class="placeholder col-10"></span></td>
																				</tr>
																				<tr>
																					<th scope="row"><i class="bx bx-info-circle text-success"></i> <span class="placeholder col-6"></span></th>
																					<td class="text-end"><span class="placeholder col-8"></span></td>
																				</tr>
																			</tbody>
																		</table>
																	</div>
																</div>

															</div>
															<div class="card-footer rounded-bottom" style="--bs-border-radius: 1rem;">
																<div class="row px-2">

																	<div class="col-5 d-grid text-center">
																		<a href="#" tabindex="-1" class="rounded-pill btn-sm btn btn-outline-primary disabled placeholder col-6"></a>
																	</div>

																	<span class="col align-items-center">
																		<i class="bx bxs-time-five fs-5 me-1"></i><span class="placeholder col-6"></span>
																	</span>

																	<span class="col align-items-center">
																		<i class="bx bxs-time-five fs-5 me-1"></i><span class="placeholder col-6"></span>
																	</span>

																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>

								<!-- card-body Asset View 2 Card -->
								<div class="card-body bg-light assetView-card-body-2-card px-0 pb-0">
									<nav aria-label="filter asset card" class="position-absolute end-0 pe-5 filter-asset">
										<ul class="nav nav-pills justify-content-end">
											<li class="nav-item">
												<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">ตัวกรอง :</a>
											</li>
											<li class="nav-item filter-lastest-asset">
												<a class="nav-link disabled placeholder">
													<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
												</a>
											</li>
										</ul>
									</nav>
									<nav @style(['visibility: visible;'])>
										<ul class="pagination justify-content-center">
											<li class="page-item prev">
												<a class="page-link disabled placeholder" role="button" data-bs-slide="prev" aria-label="Previous">
													<span aria-hidden="true">&laquo;</span>
												</a>
											</li>
											{{-- Create Asset Page Button --}}
											<li class="page-item active"><a class="page-link disabled placeholder" data-bs-slide-to="0">1</a></li>
											<li class="page-item next">
												<a class="page-link disabled placeholder" role="button" data-bs-slide="next" aria-label="Next">
													<span aria-hidden="true">&raquo;</span>
												</a>
											</li>
										</ul>
									</nav>
									{{-- var_dump(@$dataAsset) --}}
									{{-- $countAssetCard --}}
									<div id="carouselAssetList_c2" class="carousel carousel-asset-2card slide" data-bs-interval="false">
										<div class="carousel-inner" style="min-height: 42rem; max-height: 40rem;">
											{{-- Create All Asset Pages (1 Page have 4 Card) --}}
											<div class="carousel-item active">
												<div class="row p-3 px-4">
													<div class="col-lg-12 px-3">
														{{-- Asset Card --}}
														<div style="min-height: 16rem;" class="card rounded-4 hover-up asset-card-hover cardasst placeholder-glow">
															<div class="card-header bg-transparent border-bottom text-uppercase rounded-top" style="--bs-border-radius: 1rem;">
																<div class="d-flex align-items-center">
																	<span class="placeholder col-2 bg-info"></span>
																	<span class="placeholder ms-auto col-5"></span>
																</div>
															</div>
															<div class="card-body p-2">

																<div class="row h-100">
																	<div class="col border-end">

																		<!-- แสดงสถานะประกัน เเฉพาะ รถยนต์ เท่านั้น -->

																		<!-- รูปภาพทรัพย์ -->
																		<div class="col-12 m-auto text-center my-5">
																			<div class="spinner-grow" style="width: 1rem; height: 1rem;" role="status">
																				<span class="visually-hidden">Loading...</span>
																			</div>
																		</div>

																		<div class="col-12 mt-2 text-center">
																			<h5 class="fw-semibold placeholder col-8"></h5>
																			<div class="row">
																				<div class="col-6 text-center border-end px-1">
																					<p class="fw-semibold fs-6 mb-0">ประเภท</p>
																					<p class="m-0 placeholder col-6"></p>
																				</div>
																				<div class="col-6 text-center px-1">
																					<p class="fw-semibold fs-6 mb-0 placeholder col-9"></p>
																					<p class="m-0"><span class="placeholder col-8"></span> ฿</p>
																				</div>
																			</div>
																		</div>
																	</div>
																	<div class="col-12 col-md-7 d-none d-md-block">
																		<table class="table table-sm table-nowrap mb-0 asset-table-card-info">
																			<tbody>
																				<tr>
																					<th scope="row"><i class="bx bx-info-circle text-success"></i> <span class="placeholder col-12"></span></th>
																					<td class="text-end"><span class="placeholder col-6"></span></td>
																				</tr>
																				<tr>
																					<th scope="row"><i class="bx bx-info-circle text-success"></i> <span class="placeholder col-4"></span></th>
																					<td class="text-end"><span class="placeholder col-6"></span></td>
																				</tr>
																				<tr>
																					<th scope="row"><i class="bx bx-info-circle text-success"></i> <span class="placeholder col-6"></span></th>
																					<td class="text-end"><span class="placeholder col-6"></span></td>
																				</tr>
																				<tr>
																					<th scope="row"><i class="bx bx-info-circle text-success"></i> <span class="placeholder col-8"></span></th>
																					<td class="text-end"><span class="placeholder col-6"></span></td>
																				</tr>
																				<tr>
																					<th scope="row"><i class="bx bx-info-circle text-success"></i> <span class="placeholder col-4"></span></th>
																					<td class="text-end"><span class="placeholder col-10"></span></td>
																				</tr>
																				<tr>
																					<th scope="row"><i class="bx bx-info-circle text-success"></i> <span class="placeholder col-6"></span></th>
																					<td class="text-end"><span class="placeholder col-8"></span></td>
																				</tr>
																			</tbody>
																		</table>
																	</div>
																</div>

															</div>
															<div class="card-footer rounded-bottom" style="--bs-border-radius: 1rem;">
																<div class="row px-2">

																	<div class="col-5 d-grid text-center">
																		<a href="#" tabindex="-1" class="rounded-pill btn-sm btn btn-outline-primary disabled placeholder col-6"></a>
																	</div>

																	<span class="col align-items-center">
																		<i class="bx bxs-time-five fs-5 me-1"></i><span class="placeholder col-6"></span>
																	</span>

																	<span class="col align-items-center">
																		<i class="bx bxs-time-five fs-5 me-1"></i><span class="placeholder col-6"></span>
																	</span>

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
					</div>
					<div class="tab-pane" id="data_contract" role="tabpanel">
						@include('frontend.content-possession.view')
					</div>
				</div>
			</div>
		@else
			<div class="col-xl-9 col-lg-12 col-md-12 col-sm-12">
				<div class="card" style="min-height : 36.5rem; justify-content:center;">
					@component('components.content-empty.view-empty')
						@slot('btn_icon')
							<i class="bx bx-search-alt-2"></i>
						@endslot
						@slot('data', [
							// 'id' => @$item->id,
							'headtitle' => 'ยังไม่มีข้อมูลลูกค้า !',
							'title' => 'กรุณาเพิ่มลูกค้าใหม่ หรือสอบถามลูกค้า',
							'title_btn' => 'สอบถาม',
							'name_btn' => 'searchUser',
							])
						@endcomponent
					</div>
				</div>
			@endisset
		</div>

		</div>

		<script type="text/javascript">
			$(".searchUser").click(function() {
				var search = $('.header_inputSearch').val();
				var typeSr = 'namecus';
				var page_type = $('.page_type').val();
				var page = $('.page').val();
				var pageUrl = '';
				var _token = $('input[name="_token"]').val();
				var flagTab = '';

				getDataCus(search, typeSr, page, pageUrl, page_type, _token, flagTab)
			});
		</script>

		{{-- click tab content --}}
		<script>
			$(function() {
				sessionStorage.removeItem('element');
				sessionStorage.removeItem('DataCus_id');
				sessionStorage.setItem('DataCus_id', '{{ @$data->id }}')
				getContent('card-user', 'content_cus')
				getContent('insert-adds', 'user-address')

			})
			getContent = async (funs, element) => {

				let DataCus_id = sessionStorage.getItem('DataCus_id')
				let datasession = sessionStorage.getItem('element');

				if (element != datasession && DataCus_id != '') {
					sessionStorage.setItem('element', element);
					// console.log('Tab next');
					$('<span />', {
						class: "spinner-border spinner-border-sm",
						role: "status"
					}).appendTo(".loading_" + element); // show spinner btn
					$('.btn-tab').addClass('blockbtn') // block btn

					$('#' + element).html('') // clear html
					$('.' + element).show() // show placeholder
					$('.icon_' + element).hide() // hide icon


					$.ajax({
						url: '{{ route('cus.show', 0) }}',
						type: 'GET',
						data: {
							DataCus_id: DataCus_id,
							funs: funs,
							_token: '{{ @csrf_token() }}'
						},
						success: (res) => {
							$('.icon_' + element).show() // hide icon
							$('.' + element).hide()
							$('.btn-tab').removeClass('blockbtn')
							$('#' + element).html(res.html)
							$(".loading_" + element).empty()
						},
						error: (err) => {
							$('.btn-tab').removeClass('blockbtn')
							$(".loading_" + element).empty()
							$('.thenError').show()
							// $(element).html('error !')
						}
					})
				} else {
					console.log('Tab Now');
					// $('.btn-tab').addClass('blockbtn')
				}
			}
		</script>
	@endsection
