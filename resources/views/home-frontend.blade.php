@extends('layouts.master')
@section('title', 'index')
@section('masterTrack-active', 'mm-active')
@section('Track01-active', 'mm-active')
@section('page-backend', 'd-none')

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
								<img src="assets/images/coming-soon.svg" alt="" class="img-fluid mx-auto d-block">
							</div>
						</div>
					</div>
					<h4 class="mt-2">Welcome to Fontend</h4>
					<p class="text-muted">It will be as simple as Occidental in fact it will be Occidental.</p>

					<div class="row justify-content-center mt-3">
						<div class="col-md-8">
							<div data-countdown="2024/12/31" class="counter-number">
								<div class="coming-box">00 <span>Days</span></div>
								<div class="coming-box">00 <span>Hours</span></div>
								<div class="coming-box">00 <span>Minutes</span></div>
								<div class="coming-box">00 <span>Seconds</span></div>
							</div>
						</div> <!-- end col-->
					</div> <!-- end row-->
				</div>
			</div>
		</div>
	</div>

	<!-- Plugins -->
	<script src="{{ URL::asset('/assets/libs/jquery-countdown/jquery-countdown.min.js') }}"></script>
	<!-- oming-soon init -->
	<script src="{{ URL::asset('/assets/js/pages/coming-soon.init.js') }}"></script>
@endsection
