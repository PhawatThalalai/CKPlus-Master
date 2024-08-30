@extends('layouts.master')
@section('title', 'index')
@section('masterTrack-active', 'mm-active')
@section('Track01-active', 'mm-active')
@section('page-frontend', 'd-none')

@section('content')
	{{-- setup search --}}
	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])

	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="text-center">
					<h5 class="display-6 fw-medium">Coming Soon</h5>
					<div class="row justify-content-center mt-5">
						<div class="col-sm-4">
							<div class="maintenance-img">
								<img src="assets/images/undraw/inoffice.svg" alt="" class="img-fluid mx-auto d-block">
							</div>
						</div>
					</div>
					<h4 class="mt-4">Welcome to Backend</h4>
					<p class="text-muted">It will be as simple as Occidental in fact it will be Occidental.</p>

					{{-- <div class="row justify-content-center mt-3">
						<div class="col-md-8">
							<div data-countdown="2024/12/31" class="counter-number">
								<div class="coming-box">00 <span>Days</span></div>
								<div class="coming-box">00 <span>Hours</span></div>
								<div class="coming-box">00 <span>Minutes</span></div>
								<div class="coming-box">00 <span>Seconds</span></div>
							</div>
						</div>
					</div> --}}
				</div>
			</div>
		</div>
	</div>

	<!-- Plugins -->
	<script src="{{ URL::asset('/assets/libs/jquery-countdown/jquery-countdown.min.js') }}"></script>
	<!-- oming-soon init -->
	<script src="{{ URL::asset('/assets/js/pages/coming-soon.init.js') }}"></script>

	<script>
		$(document).ready(function() {
			$(function() {
				$(".input-mask").inputmask();
				$('[data-bs-toggle="tooltip"]').tooltip();

				$('textarea').maxlength({
					alwaysShow: true,
					warningClass: "badge bg-info",
					limitReachedClass: "badge bg-danger"
				});
			});
		});
	</script>
@endsection

{{-- @section('script')
<!-- Session timeout js -->
<script src="{{ URL::asset('/assets/libs/curiosityx/curiosityx.min.js') }}"></script>

<!-- Session timeout js -->
<script src="{{ URL::asset('/assets/js/pages/session-timeout.init.js') }}"></script>
@endsection --}}
