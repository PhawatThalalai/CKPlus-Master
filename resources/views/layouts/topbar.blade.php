<style>
	.sub-topbar-menu {
		display: none;
		opacity: 0;
		transition: opacity 0.5s ease-in-out;
	}

	.sub-topbar-menu.show {
		display: block;
		opacity: 1;
	}

	/* เปลี่ยนสีเมื่อ hover ทั้งหมด */
	.dropdown-megamenu li a:hover {
		color: #ff0077;
		transition: color 0.3s ease-in-out;
	}

	@keyframes fadeIn {
		from {
			opacity: 0;
		}

		to {
			opacity: 1;
		}
	}

	@keyframes fadeOut {
		from {
			opacity: 1;
		}

		to {
			opacity: 0;
		}
	}
</style>

<header id="page-topbar">
	<div class="navbar-header">
		<div class="d-flex">
			<!-- LOGO -->
			<div class="navbar-brand-box">
				@php
					if (session()->get('h_page') == 'frontend') {
					    $route = route('home.index');
					    $iconRoute = session()->get('h_page');

					    $title = 'ระบบ การ์ดสัญญา';
					    $page = 'backend';
					} else {
					    $route = route('home.index');
					    $iconRoute = session()->get('h_page');

					    $title = 'ระบบ ขออนุมัติสินเชื่อ';
					    $page = 'frontend';
					}
				@endphp
				<a href="{{ @$route }}" class="logo logo-dark">
					<span class="logo-sm">
						<img src="{{ URL::asset('/assets/images/logo_ck.png') }}" alt="" height="30">
					</span>
					<span class="logo-lg">
						<img src="{{ URL::asset('/assets/images/banner-sidebar.png') }}" alt="" height="70">
					</span>
				</a>

				<a href="{{ @$route }}" class="logo logo-light">
					<span class="logo-sm">
						<img src="{{ URL::asset('/assets/images/logo_ck.png') }}" alt="" height="30">
					</span>
					<span class="logo-lg">
						<img src="{{ URL::asset('/assets/images/banner-sidebar.png') }}" alt="" height="70">
					</span>
				</a>
			</div>

			<button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
				<i class="fa fa-fw fa-bars"></i>
			</button>

			<!-- App Search-->
			<span class="app-search d-none d-lg-block" @style(['display: none !important;' => @$hideSearchTopbar == true])>
				{{-- <div class="position-relative">
                    <input type="text" class="form-control" placeholder="@lang('translation.Search')">
                    <span class="bx bx-search-alt"></span>
                </div> --}}

				<div class="position-relative input-group">
					<input type="text" class="form-control rounded-pill header_inputSearch" placeholder="Search...">
					<span class="bx bx-search-alt search-icon hover-up header_btnSearch" style="cursor: pointer"></span>

					<button class="btn btn-outline-secondary dropdown-toggle waves-effect waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border:none; border-radius:40px;right: 38px;">
						<i class="mdi mdi-dots-vertical"></i>
					</button>
					<ul class="dropdown-menu dropdown-menu-end">
						<li><a class="dropdown-item type-Select typ-namecus {{ empty(@$dataSreach['namecus']) ? 'd-none' : '' }}" value="namecus">ชื่อ-สกุล</a></li>
						<li><a class="dropdown-item type-Select typ-idcardcus {{ empty(@$dataSreach['idcardcus']) ? 'd-none' : '' }}" value="idcardcus">เลขบัตรประชาชน</a></li>
						<li><a class="dropdown-item type-Select typ-license {{ empty(@$dataSreach['license']) ? 'd-none' : '' }}" value="license">เลขป้ายทะเบียน</a></li>
						<li><a class="dropdown-item type-Select typ-contract {{ empty(@$dataSreach['contract']) ? 'd-none' : '' }}" value="contract">เลขที่สัญญา</a></li>
					</ul>

					<input type="hidden" class="header-typeSr" value="{{ @$typeSreach }}">
				</div>
			</span>

			<!-- mega menu -->
			@hasrole(['superadmin', 'administrator', 'manager'])
				<div class="dropdown dropdown-mega d-none d-lg-block ms-2">
					<button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-haspopup="false" aria-expanded="false">
						<span key="t-megamenu">Mega Menu</span>
						<i class="mdi mdi-chevron-down"></i>
					</button>
					<div class="dropdown-menu dropdown-megamenu">
						<div class="row">
							<div class="col-sm-10">
								<div class="row">
									@if (Gate::check('systems-users') || Gate::check('systems-permission'))
										<div class="col-md-3">
											<h5 class="font-size-14 mt-0 fw-semibold" key="t-ui-components">System Administrator</h5>

											<ul class="vstack gap-2">
												@can('systems-users')
													<li>
														<a href="{{ route('permission.index') }}?page={{ 'systems-users' }}&funs={{ 'users' }}" key="t-users">ข้อมูลผู้ใช้งาน ( Users )</a>
													</li>
												@endcan
												@can('systems-permission')
													<li>
														<a href="{{ route('permission.index') }}?page={{ 'systems-permission' }}&funs={{ 'roles' }}" key="t-roles">กำหนดกลุ่มผู้ใช้งาน ( Roles )</a>
													</li>
													<li>
														<a href="{{ route('permission.index') }}?page={{ 'systems-permission' }}&funs={{ 'modules' }}" key="t-modules">กำหนดสิทธิ์ใช้งานตามกลุ่ม ( Modules )</a>
													</li>
													<li>
														<a href="{{ route('permission.index') }}?page={{ 'systems-permission' }}&funs={{ 'permissions' }}" key="t-permission">กำหนดสิทธิ์ใช้งาน ( Permissions )</a>
													</li>
												@endcan
											</ul>
										</div>
									@endif

									@if (Gate::check('systems-users') || Gate::check('systems-permission'))
										<div class="col-md-3">
											<h5 class="font-size-14 mt-0 fw-semibold" key="t-ui-components">ข้อมูลเบื้องต้น </h5>
											<ul class="vstack gap-2">
												<li>
													<a href="{{ route('dataStatic.index') }}?page={{ 'frontend' }}&set={{ 'data-companies' }}" key="t-text">กำหนดข้อมูลบริษัท ( Company )</a>
												</li>
												<li>
													<a href="{{ route('dataStatic.index') }}?page={{ 'frontend' }}&set={{ 'data-companies' }}&active={{ 'branch' }}" key="t-text">กำหนดข้อมูลสาขา ( Branchs )</a>
												</li>
												<li>
													<a href="#" class="title-topbar-menu">กำหนดข้อมูลราคากลาง ( Cost Appraisal )</a>
													<ul class="sub-topbar-menu" aria-expanded="false">
														<li class="mb-1 mt-1">
															<a href="{{ route('dataStatic.index') }}?page={{ 'frontend' }}&set={{ 'data-rate' }}&setsub={{ 'rate-car' }}">ราคากลาง รถยนต์</a>
														</li>
														<li class="mb-1 mt-1">
															<a href="{{ route('dataStatic.index') }}?page={{ 'frontend' }}&set={{ 'data-rate' }}&setsub={{ 'rate-moto' }}">ราคากลาง รถจักรยานยนต์</a>
														</li>
													</ul>
												</li>
												<li>
													<a href="{{ route('dataStatic.index') }}?page={{ 'frontend' }}&set={{ 'data-interest' }}" class="title-topbar-menu">กำหนดข้อมูลดอกเบี้ย ( Interast Rates )</a>
												</li>
											</ul>
										</div>
										<div class="col-md-3">
											<h5 class="font-size-14 mt-0 fw-semibold" key="t-ui-components">ข้อมูลค่าคงที</h5>
											<ul class="vstack gap-2">
												<li>
													<a href="#" class="title-topbar-menu">กำหนดค่าคงที ( Generals )</a>
													<ul class="sub-topbar-menu" aria-expanded="false">
														<li class="mb-1 mt-1"><a href="{{ route('dataStatic.index') }}?page={{ 'frontend' }}&set={{ 'data-general' }}&active={{ 'customer' }}">ค่าคงที ลูกค้า </a></li>
														<li class="mb-1 mt-1"><a href="{{ route('dataStatic.index') }}?page={{ 'frontend' }}&set={{ 'data-general' }}&active={{ 'region' }}">ค่าคงที ภูมิภาค </a></li>
														<li class="mb-1 mt-1"><a href="{{ route('dataStatic.index') }}?page={{ 'frontend' }}&set={{ 'data-general' }}&active={{ 'ะฟเ' }}">ค่าคงที ติดตาม (tag)</a></li>
													</ul>
												</li>
												<li>
													<a href="#" class="title-topbar-menu">กำหนดข้อมูลลูกค้า ( Customers )</a>
													<ul class="sub-topbar-menu" aria-expanded="false">
														<li class="mb-1 mt-1"><a href="{{ route('dataStatic.index') }}?page={{ 'frontend' }}&set={{ 'data-general' }}&active={{ 'cus_info' }}" class="">ข้อมูลลูกค้า</a></li>
														<li class="mb-1 mt-1"><a href="{{ route('dataStatic.index') }}?page={{ 'frontend' }}&set={{ 'data-general' }}&active={{ 'address' }}" class="">ข้อมูลที่อยู่ / ข้อมูลอาชีพ</a></li>
													</ul>
												</li>
												<li>
													<a href="#" class="title-topbar-menu">กำหนดข้อมูลทรัพย์สิน ( Assets )</a>
													<ul class="sub-topbar-menu" aria-expanded="false">
														<li class="mb-1 mt-1"><a href="" class="">ข้อมูลทรัพย์สิน</a></li>
													</ul>
												</li>
												<li>
													<a href="#" class="title-topbar-menu">กำหนดข้อมูลสัญญา ( Contracts )</a>
												</li>
											</ul>
										</div>
										<div class="col-md-3">
											<h5 class="font-size-14 mt-0 fw-semibold" key="t-ui-components">ตั้งค่าใช้งานระบบ</h5>
											<ul class="vstack gap-2">
												<li>
													<a href="#" class="title-topbar-menu mb-1">ตั้งค่าอนุมัติสินเชื่อ ( Approve loans )</a>
												</li>
											</ul>
										</div>
									@endif

									@if (session()->get('h_page') == 'backend')
										<div class="col-md-3">
											<h5 class="font-size-14 mt-0 fw-semibold" key="t-ui-components">ระบบฐานสัญญา (Backend)</h5>
											<ul class="vstack gap-2">
												<li>
													<a href="{{ route('contracts.index') }}?page=edit-contract" key="t-text">แก้ไขข้อมูลสัญญา (Edit Contract)</a>
												</li>
											</ul>
										</div>
									@endif
								</div>
							</div>
							<div class="col-sm-2">
								<div>
									<img src="{{ URL::asset('/assets/images/megamenu-img.png') }}" alt="" width="180px;" class="img-fluid mx-auto d-block">
								</div>
							</div>
						</div>
					</div>
				</div>
			@endhasrole
		</div>

		<div class="d-flex">
			<div class="dropdown d-inline-block d-lg-none ms-2">
				<button type="button" class="btn header-item noti-icon waves-effect header_btnSearch_Mobile">
					<i class="mdi mdi-magnify"></i>
				</button>
				{{-- <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-search-dropdown">

					<form class="p-3">
						<div class="form-group m-0">
							<div class="input-group">
								<input type="text" class="form-control" placeholder="@lang('translation.Search')" aria-label="Search input">
								<button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
							</div>
						</div>
					</form>
				</div> --}}
			</div>

			{{-- <div class="dropdown d-inline-block">
				<button type="button" class="btn header-item waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					@switch(Session::get('lang'))
						@case('ru')
							<img src="{{ URL::asset('/assets/images/flags/russia.jpg') }}" alt="Header Language" height="16">
						@break

						@case('it')
							<img src="{{ URL::asset('/assets/images/flags/italy.jpg') }}" alt="Header Language" height="16">
						@break

						@case('de')
							<img src="{{ URL::asset('/assets/images/flags/germany.jpg') }}" alt="Header Language" height="16">
						@break

						@case('es')
							<img src="{{ URL::asset('/assets/images/flags/spain.jpg') }}" alt="Header Language" height="16">
						@break

						@default
							<img src="{{ URL::asset('/assets/images/flags/us.jpg') }}" alt="Header Language" height="16">
					@endswitch
				</button>
				<div class="row dropdown-menu dropdown-menu-end">
					<div class="card p-4" style="background-image: linear-gradient(rgba(0, 0, 255, 0.5), rgba(255, 255, 255, 0.5)),  url('assets/images/city1.jpg');  background-size: cover;  background-repeat: no-repeat;  top:-6px;">

					</div>

					<!-- item-->
					<a href="{{ url('index/en') }}" class="dropdown-item notify-item language" data-lang="eng">
						<img src="{{ URL::asset('/assets/images/flags/us.jpg') }}" alt="user-image" class="me-1" height="12"> <span class="align-middle">English</span>
					</a>
					<!-- item-->
					<a href="{{ url('index/es') }}" class="dropdown-item notify-item language" data-lang="sp">
						<img src="{{ URL::asset('/assets/images/flags/spain.jpg') }}" alt="user-image" class="me-1" height="12"> <span class="align-middle">Spanish</span>
					</a>

					<!-- item-->
					<a href="{{ url('index/de') }}" class="dropdown-item notify-item language" data-lang="gr">
						<img src="{{ URL::asset('/assets/images/flags/germany.jpg') }}" alt="user-image" class="me-1" height="12"> <span class="align-middle">German</span>
					</a>

					<!-- item-->
					<a href="{{ url('index/it') }}" class="dropdown-item notify-item language" data-lang="it">
						<img src="{{ URL::asset('/assets/images/flags/italy.jpg') }}" alt="user-image" class="me-1" height="12"> <span class="align-middle">Italian</span>
					</a>

					<!-- item-->
					<a href="{{ url('index/ru') }}" class="dropdown-item notify-item language" data-lang="ru">
						<img src="{{ URL::asset('/assets/images/flags/russia.jpg') }}" alt="user-image" class="me-1" height="12"> <span class="align-middle">Russian</span>
					</a>
				</div>
			</div> --}}

			{{-- <div class="dropdown d-none d-lg-inline-block ms-1">
				<button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="bx bx-customize"></i>
				</button>
				<div class="row dropdown-menu dropdown-menu-lg dropdown-menu-end">
					<div class="card p-4" style="background-image: linear-gradient(rgba(0, 0, 255, 0.5), rgba(255, 255, 255, 0.5)),  url('assets/images/city1.jpg');  background-size: cover;  background-repeat: no-repeat;  top:-6px;">

					</div>
					<div class="px-lg-2">
						<div class="row g-0">
							<div class="col">
								<a class="dropdown-icon-item" href="#">
									<img src="{{ URL::asset('/assets/images/brands/github.png') }}" alt="Github">
									<span>GitHub</span>
								</a>
							</div>
							<div class="col">
								<a class="dropdown-icon-item" href="#">
									<img src="{{ URL::asset('/assets/images/brands/bitbucket.png') }}" alt="bitbucket">
									<span>Bitbucket</span>
								</a>
							</div>
							<div class="col">
								<a class="dropdown-icon-item" href="#">
									<img src="{{ URL::asset('/assets/images/brands/dribbble.png') }}" alt="dribbble">
									<span>Dribbble</span>
								</a>
							</div>
						</div>

						<div class="row g-0">
							<div class="col">
								<a class="dropdown-icon-item" href="#">
									<img src="{{ URL::asset('/assets/images/brands/dropbox.png') }}" alt="dropbox">
									<span>Dropbox</span>
								</a>
							</div>
							<div class="col">
								<a class="dropdown-icon-item" href="#">
									<img src="{{ URL::asset('/assets/images/brands/mail_chimp.png') }}" alt="mail_chimp">
									<span>Mail Chimp</span>
								</a>
							</div>
							<div class="col">
								<a class="dropdown-icon-item" href="#">
									<img src="{{ URL::asset('/assets/images/brands/slack.png') }}" alt="slack">
									<span>Slack</span>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div> --}}
			<div class="dropdown d-none d-lg-inline-block ms-1">
				{{-- @hasrole(['superadmin', 'administrator']) --}}
				<a href="{{ @$route }}" data-bs-trigger="hover focus" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-content="{{ $title }}">
					<button class="btn header-item noti-icon waves-effect">
						<i class="bx bx-clinic"></i>
					</button>
				</a>
				{{-- @endhasrole --}}

				{{-- <button type="button" class="btn header-item noti-icon waves-effect" data-toggle="fullscreen">
					<i class="bx bx-fullscreen"></i>
				</button> --}}
			</div>
			<div class="dropdown d-inline-block">
				<button type="button" class="btn header-item noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<i class="bx bx-bell bx-tada"></i>
					<span class="badge bg-danger rounded-pill">3</span>
				</button>
				<div class="row dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown">
					<div class="card p-4" style="background-image: linear-gradient(rgba(0, 0, 255, 0.5), rgba(255, 255, 255, 0.5)),  url('assets/images/city1.jpg');  background-size: cover;  background-repeat: no-repeat;  top:-6px;">

					</div>
					<div class="p-3">
						<div class="row align-items-center">
							<div class="col">
								<h6 class="m-0" key="t-notifications"> @lang('translation.Notifications') </h6>
							</div>
							<div class="col-auto">
								<a href="#!" class="small" key="t-view-all"> @lang('translation.View_All')</a>
							</div>
						</div>
					</div>
					<div data-simplebar style="max-height: 230px;">
						<a href="" class="text-reset notification-item">
							<div class="d-flex">
								<div class="avatar-xs me-3">
									<span class="avatar-title bg-primary rounded-circle font-size-16">
										<i class="bx bx-cart"></i>
									</span>
								</div>
								<div class="flex-grow-1">
									<h6 class="mt-0 mb-1" key="t-your-order">@lang('translation.Your_order_is_placed')</h6>
									<div class="font-size-12 text-muted">
										<p class="mb-1" key="t-grammer">@lang('translation.If_several_languages_coalesce_the_grammar')</p>
										<p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago">@lang('translation.3_min_ago')</span></p>
									</div>
								</div>
							</div>
						</a>
						<a href="" class="text-reset notification-item">
							<div class="d-flex">
								<img src="{{ URL::asset('/assets/images/users/avatar-3.jpg') }}" class="me-3 rounded-circle avatar-xs" alt="user-pic">
								<div class="flex-grow-1">
									<h6 class="mt-0 mb-1">@lang('translation.James_Lemire')</h6>
									<div class="font-size-12 text-muted">
										<p class="mb-1" key="t-simplified">@lang('translation.It_will_seem_like_simplified_English')</p>
										<p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-hours-ago">@lang('translation.1_hours_ago')</span></p>
									</div>
								</div>
							</div>
						</a>
						<a href="" class="text-reset notification-item">
							<div class="d-flex">
								<div class="avatar-xs me-3">
									<span class="avatar-title bg-success rounded-circle font-size-16">
										<i class="bx bx-badge-check"></i>
									</span>
								</div>
								<div class="flex-grow-1">
									<h6 class="mt-0 mb-1" key="t-shipped">@lang('translation.Your_item_is_shipped')</h6>
									<div class="font-size-12 text-muted">
										<p class="mb-1" key="t-grammer">@lang('translation.If_several_languages_coalesce_the_grammar')</p>
										<p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-min-ago">@lang('translation.3_min_ago')</span></p>
									</div>
								</div>
							</div>
						</a>
						<a href="" class="text-reset notification-item">
							<div class="d-flex">
								<img src="{{ URL::asset('/assets/images/users/avatar-4.jpg') }}" class="me-3 rounded-circle avatar-xs" alt="user-pic">
								<div class="flex-grow-1">
									<h6 class="mt-0 mb-1">@lang('translation.Salena_Layfield')</h6>
									<div class="font-size-12 text-muted">
										<p class="mb-1" key="t-occidental">@lang('translation.As_a_skeptical_Cambridge_friend_of_mine_occidental')</p>
										<p class="mb-0"><i class="mdi mdi-clock-outline"></i> <span key="t-hours-ago">@lang('translation.1_hours_ago')</span></p>
									</div>
								</div>
							</div>
						</a>
					</div>
					<div class="p-2 border-top d-grid">
						<a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
							<i class="mdi mdi-arrow-right-circle me-1"></i> <span key="t-view-more">@lang('translation.View_More')</span>
						</a>
					</div>
				</div>
			</div>

			<div class="dropdown d-inline-block">
				<button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					<img class="rounded-circle header-profile-user" src="{{ isset(Auth::user()->profile_photo_url) ? asset(Auth::user()->profile_photo_url) : asset('/assets/images/users/avatar-1.jpg') }}" alt="{{ Auth::user()->name }}">
					<span class="d-none d-xl-inline-block ms-1" key="t-henry">{{ ucfirst(Auth::user()->name) }}</span>
					<i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
				</button>
				<div class="dropdown-menu dropdown-menu-end">
					<div class="row">
						<div class="col">
							<div class="card p-3" style="background-image: linear-gradient(rgba(0, 0, 255, 0.5), rgba(255, 255, 255, 0.5)),  url('{{ asset('assets/images/city1.jpg') }}');  background-size: cover;  background-repeat: no-repeat;  top:-6px;">
								<div class="row">
									<div class="col-3">
										<img class="rounded-circle header-profile-user" src="{{ isset(Auth::user()->profile_photo_url) ? asset(Auth::user()->profile_photo_url) : asset('/assets/images/users/avatar-1.jpg') }}"alt="Header Avatar">
									</div>
									<div class="col-9 d-flex m-auto">
										<span class="text-light" key="t-henry"><b>{{ ucfirst(Auth::user()->name) }}</b></span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- item-->
					<a class="dropdown-item" href="{{ route('profile.show') }}">
						<i class="bx bx-user font-size-16 align-middle me-1"></i>
						<span key="t-profile">Profile</span>
					</a>
					<a class="dropdown-item" href="#"><i class="bx bx-wallet font-size-16 align-middle me-1"></i> <span key="t-my-wallet">@lang('translation.My_Wallet')</span></a>
					<a class="dropdown-item d-block" href="#" data-bs-toggle="modal" data-bs-target=".change-password"><span class="badge bg-success float-end">11</span><i class="bx bx-wrench font-size-16 align-middle me-1"></i> <span key="t-settings">@lang('translation.Settings')</span></a>
					<a class="dropdown-item" href="#"><i class="bx bx-lock-open font-size-16 align-middle me-1"></i> <span key="t-lock-screen">@lang('translation.Lock_screen')</span></a>
					<div class="dropdown-divider"></div>
					<form id="logout_bt" method="POST" action="{{ route('logout') }}">
						@csrf
						<button href="{{ route('logout') }}" type="submit" class="dropdown-item text-danger">
							<i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
							<span key="t-logout">Logout</span>
						</button>
					</form>
					{{-- <a class="dropdown-item text-danger" href="javascript:void();" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i>
                    <span key="t-logout">@lang('translation.Logout')</span>
                </a> --}}
				</div>
			</div>
			<div class="dropdown d-inline-block">
				<button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
					<i class="bx bx-cog bx-spin"></i>
				</button>
			</div>
		</div>
	</div>
</header>

<!--  Change-Password example -->
<div class="modal fade change-password" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myLargeModalLabel">Change Password</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form method="POST" id="change-password">
					@csrf
					<input type="hidden" value="{{ Auth::user()->id }}" id="data_id">
					<div class="mb-3">
						<label for="current_password">Current Password</label>
						<input id="current-password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" autocomplete="current_password" placeholder="Enter Current Password" value="{{ old('current_password') }}">
						<div class="text-danger" id="current_passwordError" data-ajax-feedback="current_password"></div>
					</div>

					<div class="mb-3">
						<label for="newpassword">New Password</label>
						<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" autocomplete="new_password" placeholder="Enter New Password">
						<div class="text-danger" id="passwordError" data-ajax-feedback="password"></div>
					</div>

					<div class="mb-3">
						<label for="userpassword">Confirm Password</label>
						<input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="new_password" placeholder="Enter New Confirm password">
						<div class="text-danger" id="password_confirmError" data-ajax-feedback="password-confirm"></div>
					</div>

					<div class="mt-3 d-grid">
						<button class="btn btn-primary waves-effect waves-light UpdatePassword" data-id="{{ Auth::user()->id }}" type="submit">Update Password</button>
					</div>
				</form>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
	document.addEventListener('DOMContentLoaded', function() {
		var titleMenus = document.querySelectorAll('.title-topbar-menu');

		// ตรวจสอบว่ามี .title-menu หรือไม่
		if (titleMenus.length > 0) {
			titleMenus.forEach(function(titleMenu) {
				titleMenu.addEventListener('click', function() {
					var subMenu = this.nextElementSibling;

					// ตรวจสอบว่า subMenu ไม่ใช่ null ก่อนที่จะใช้งาน
					if (subMenu !== null) {
						if (subMenu.classList.contains('show')) {
							subMenu.classList.remove('show');
							subMenu.style.animation = 'fadeOut 0.5s';
						} else {
							subMenu.classList.add('show');
							subMenu.style.animation = 'fadeIn 0.5s';
						}
					}
				});
			});
		}
	});
</script>
