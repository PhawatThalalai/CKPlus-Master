<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8" />
	<title> @yield('title') | Chookiat Plus+</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
	<meta content="Themesbrand" name="author" />
	<!-- App favicon -->
	<link rel="shortcut icon" href="{{ URL::asset('assets/images/logo_ck.png') }}">
	<script src="https://cdn.lordicon.com/lordicon.js"></script>

	@include('layouts.head-css')

	{{-- @vite('resources/css/app.css') --}}
	<style>
		/* Hide scrollbar for Chrome, Safari and Opera */
		body::-webkit-scrollbar {
			display: none;
		}

		/* Hide scrollbar for IE and Edge */
		body {
			-ms-overflow-style: none;
		}

		.highlight-text-style {
			color: rgb(12, 180, 12);
			text-decoration: underline;
		}

		.swal-alert-danger {
			color: rgb(235, 19, 4);
			/* text-decoration: underline; */
		}

		.swal-title {
			font-size: 0.9rem;
		}
	</style>

	<style>
		.lds-facebook {
			display: inline-block;
			position: absolute;
			width: 80px;
			height: 80px;
			top: 50%;
			left: 50%;
			transform: translate(-50%, -50%);
		}

		.lds-facebook div {
			display: inline-block;
			position: absolute;
			left: 8px;
			width: 16px;
			background: #cef;
			animation: lds-facebook 1.2s cubic-bezier(0, 0.5, 0.5, 1) infinite;
		}

		.lds-facebook div:nth-child(1) {
			left: 8px;
			animation-delay: -0.24s;
		}

		.lds-facebook div:nth-child(2) {
			left: 32px;
			animation-delay: -0.12s;
		}

		.lds-facebook div:nth-child(3) {
			left: 56px;
			animation-delay: 0;
		}

		@keyframes lds-facebook {
			0% {
				top: 8px;
				height: 64px;
			}

			50%,
			100% {
				top: 24px;
				height: 32px;
			}
		}
	</style>

	{{-- <livewire:styles /> --}}
	@livewireStyles
</head>

@section('body')
	@include('components.content-modal.modal-sm')
	@include('components.content-modal.modal-md')
	@include('components.content-modal.modal-sd')
	@include('components.content-modal.modal-lg')
	@include('components.content-modal.modal-lg-2')
	@include('components.content-modal.modal-xl')
	@include('components.content-modal.modal-xl-2')
	@include('components.content-modal.modal-xl-static')

	@include('layouts.head-js')

	{{-- <body data-sidebar="dark" class="vertical-collpsed" style="font-family: 'Prompt', sans-serif;"> --}}

	<body data-topbar="dark" data-layout="horizontal" data-layout-size="" data-layout-scrollable="false" data-layout-mode="light" style="font-family: 'Prompt', sans-serif;">
	@show
	<!-- Begin page -->
	<div id="layout-wrapper">

		{{-- @if (empty($__env->yieldContent('page-mega'))) --}}
		@include('layouts.topbar2')
		@include('layouts.navbar')
		{{-- @endif --}}
		{{-- @include('layouts.topbar')
			@include('layouts.sidebar') --}}

		<!-- ============================================================== -->
		<!-- Start right Content here -->
		<!-- ============================================================== -->
		<div class="main-content">
			<div class="page-content">
				<div class="contents container-fluid" id="pageContents">
					<div id="preloader">
						<div class="lds-facebook">
							<div></div>
							<div></div>
							<div></div>
						</div>
					</div>

					{{-- ตัวโหลดเก่า --}}

					{{-- <div class="loading-overlay d-flex flex-column justify-content-center align-items-center" style="display: none !important">
						<div class="d-flex text-light" role="status">
							<span class="loader">Loading...</span>
						</div>
					</div> --}}

					{{-- ตัวโหลดใหม่  --}}
					<div class="loading-overlay d-flex flex-column justify-content-center align-items-center" style="display: none !important">
						<span class="">
							<span id="loading-spinner-ck">
								<img src="{{ URL::asset('/assets/images/CK-LOGO3.png') }}" alt="" class="t rounded-circle" alt="">
								<span class="spinner outer">
									<span class="spinner inner">
										<span class="spinner eye">
											<span>
											</span>
										</span>
									</span>
								</span>
							</span>
						</span>`

						<div class="card rounded-pill px-4 border border-secondary border-3" style="top:70px;">
							<h6 class="fw-semibold mt-1 mb-1">กำลังโหลด ...</h6>
						</div>

					</div>

					<meta name="csrf-token" content="{{ csrf_token() }}">
					@yield('content')
				</div>
				<!-- container-fluid -->
			</div>
			<!-- End Page-content -->
			@include('layouts.footer')
		</div>
		<!-- end main content-->
		@livewireScripts
		{{-- <livewire:scripts /> --}}
	</div>

	<!-- END layout-wrapper -->

	<!-- Right Sidebar -->
	@include('layouts.right-sidebar')
	<!-- /Right-bar -->

	<!-- JAVASCRIPT -->
	@include('layouts.vendor-scripts')

	<script>
		$(document).on('click', '.data-modal-xl', function(e) {
			$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
			e.preventDefault();
			var url = $(this).attr('data-link');
			$('#modal_xl .modal-dialog').load(url, function(response, status, xhr) {
				if (status === 'success') {
					$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
					$('#modal_xl').modal('show');
					// $('#modal_xl .modal-dialog').load(url);
				} else {
					$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
					console.log('Load failed');
				}
			});
		});

		$(document).on('click', '.data-modal-xl-2', function(e) {
			$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
			e.preventDefault();

			var url = $(this).attr('data-link');
			$('#modal_xl_2 .modal-xl').load(url, function(response, status, xhr) {
				if (status === 'success') {
					$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
					$('#modal_xl_2').modal('show');
					// $('#modal_xl_2 .modal-xl').load(url);
				} else {
					$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
					Swal.fire({
						icon: 'error',
						title: JSON.parse(response).title,
						html: '<span class="swal-title swal-alert-danger">' + JSON.parse(response).message + '</span>',
						confirmButtonText: 'ตกลง',
						confirmButtonColor: '#0d6efd',
					});
				}
			});
		});

		$(document).on('click', '.modal_lg', function(e) {
			$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
			e.preventDefault();

			var url = $(this).attr('data-link');
			$('#modal_lg .modal-lg').load(url, function(response, status, xhr) {
				if (status === 'success') {
					$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
					$('#modal_lg').modal('show');
				} else {
					$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **

					if (xhr.status == 401) {
						Swal.fire({
							icon: 'error',
							title: xhr.status + ' ' + xhr.statusText + ` !!!`,
							text: response,
							showConfirmButton: true,
							// timer: 1500
						});
					} else {
						Swal.fire({
							icon: 'error',
							title: xhr.status + ' ' + xhr.statusText + ` !!!`,
							text: response,
							showConfirmButton: true,
							// timer: 1500
						});
					}
				}
			});
		});

		$(document).on('click', '.modal_md', function(e) {
			$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
			e.preventDefault();

			var url = $(this).attr('data-link');
			$('#modal_md .modal-md').load(url, function(response, status, xhr) {
				if (status === 'success') {
					$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
					$('#modal_md').modal('show');
					// $('#modal_lg .modal-lg').load(url);
				} else {
					$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
					console.log('Load failed');
				}
			});
		});

		$(document).on('click', '.modal_sm', function(e) {
			$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
			e.preventDefault();

			var url = $(this).attr('data-link');
			$('#modal_sm .modal-sm').load(url, function(response, status, xhr) {
				if (status === 'success') {
					$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
					$('#modal_sm').modal('show');
					// $('#modal_lg .modal-lg').load(url);
				} else {
					$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
					console.log('Load failed');
				}
			});
		});

		$(document).ready(function() {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
		});
	</script>
</body>

</html>

{{-- disable click back right --}}
{{-- <script type="text/javascript">
	function preventBack() {
		window.history.forward();
	}
	setTimeout(preventBack, 0);

	window.onunload = function() {
		null;
	};
	window.onload = function() {
		preventBack();
	};
</script> --}}

{{-- <script type="text/javascript">
	for (i = 0; i < 50; i++) {
		history.pushState({}, '');
	}
</script> --}}

{{-- <script>
	$(document).ready(function() {
		history.pushState(null, null, document.URL);
		window.addEventListener('popstate', function() {
			history.pushState(null, null, document.URL);
		});
	});
</script> --}}

{{-- <script>
	function activePage() {
		let content = setTimeout(showpage, 3000);
	}

	function showpage() {
		document.getElamentById('preloader').style.display = 'none';
		document.getElamentById('pageContents').style.display = 'bolck';
	}
</script> --}}

{{-- disable click left all --}}
{{-- <script>
	document.addEventListener('contextmenu', event => event.preventDefault());
</script> --}}

{{-- disable menu new tabs --}}
{{-- <script>
	for(var els = document.getElementsByTagName('a'), i = els.length; i--;){
		var href = els[i].href;
		els[i].href = 'javascript:void(0);';
		els[i].onclick = (function(el, href){
			return function(){
				window.location.href = href;
			};
		})(els[i], href);
	}
</script> --}}

<!-- Session timeout js -->
<script src="{{ URL::asset('/assets/libs/curiosityx/curiosityx.min.js') }}"></script>

<!-- Session timeout js -->
<script src="{{ URL::asset('/assets/js/pages/session-timeout.init.js') }}"></script>
@stack('scripts')
