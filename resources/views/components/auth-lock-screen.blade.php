@extends('layouts.master-without-nav')
@section('title', 'lock screen')
@section('body')

	<body>
	@endsection

	@section('content')
		@include('components.content-toast.view-toast')

		<div class="account-pages my-5 pt-sm-5">
			<div class="container">
				<div class="row justify-content-center">
					<div class="col-md-8 col-lg-6 col-xl-5">
						<div class="card overflow-hidden">
							<div class="bg-primary bg-soft">
								<div class="row">
									<div class="col-7">
										<div class="text-primary p-4">
											<h5 class="text-primary">Lock screen</h5>
											<p>Enter your password to unlock the screen!</p>
										</div>
									</div>
									<div class="col-5 align-self-end">
										<img src="{{ URL::asset('/assets/images/profile-img.png') }}" alt="" class="img-fluid">
									</div>
								</div>
							</div>
							<div class="card-body pt-0">
								<div>
									<a href="index">
										<div class="avatar-md profile-user-wid mb-4">
											<span class="avatar-title rounded-circle bg-light">
												<img src="{{ URL::asset('assets/images/logo_ck.png') }}" alt="" class="rounded-circle" height="100">
											</span>
										</div>
									</a>
								</div>
								<div class="p-2">
									<form id="unlock-form">
										@csrf

										<div class="user-thumb text-center mb-4">
											<img src="{{ isset(Auth::user()->profile_photo_url) ? asset(Auth::user()->profile_photo_url) : asset('/assets/images/users/avatar-1.jpg') }}" class="rounded-circle img-thumbnail avatar-md" alt="thumbnail">
											<h5 class="font-size-15 mt-3">{{ Auth::user()->name }}</h5>
										</div>

										<div class="mb-3">
											<label for="userpassword">Password</label>
											<input type="password" class="form-control" id="userpassword" placeholder="Enter password">
										</div>
										<div id="error-message" class="alert alert-danger mt-2 d-none"></div>

										<div class="text-end">
											{{-- <button class="btn btn-primary w-md waves-effect waves-light" type="submit"><i class="bx bx-lock-open-alt"></i> Unlock</button> --}}
											<button class="btn btn-primary w-md waves-effect waves-light" type="button" id="unlock-btn">
												<i class="bx bx-lock-open-alt"></i> Unlock
											</button>
										</div>

									</form>
								</div>

							</div>
						</div>
						<div class="mt-5 text-center">
							{{-- <p>Not you ? return <a href="auth-login" class="fw-medium text-primary"> Sign In </a> </p> --}}
							<p>©
								<script>
									document.write(new Date().getFullYear())
								</script> Skote. Crafted with <i class="mdi mdi-heart text-danger"></i> by Devp Chookiat
							</p>
						</div>

					</div>
				</div>
			</div>
		</div>

		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script>
			$(document).ready(function() {
				function unlockScreen() {
					$('#unlock-btn').html('<i class="bx bx-loader bx-spin"></i> Unlock');
					$.ajax({
						url: '{{ route('unlock_screen') }}',
						type: 'POST',
						data: {
							_token: '{{ csrf_token() }}',
							password: $('#userpassword').val()
						},
						success: function(response) {
							if (response.success) {
								$(".toast-success").toast({
									delay: 1500
								}).toast("show");
								$(".toast-success .toast-body .text-body").text('connected successfully');

								window.location.href = response.previous_url ? response.previous_url : 'index';
							} else {
								if (response.message === 'Your session has expired. Please log in again.') {
									window.location.href = '{{ route('login') }}';
								} else {
									$('#error-message').text(response.message).removeClass('d-none');
									$('#userpassword').val('');

									setTimeout(function() {
										$('#error-message').fadeOut('slow', function() {
											$(this).addClass('d-none').show();
										});
									}, 3000);
								}
							}
						},
						error: function(xhr) {
							if (xhr.status === 419) { // CSRF token mismatch
								$('#error-message').text('Your session has expired. Please refresh the page and try again.').removeClass('d-none');
								window.location.href = '{{ route('login') }}';
							} else {
								$('#error-message').text('An error occurred. Please try again.').removeClass('d-none');
							}
							$('#userpassword').val('');

							setTimeout(function() {
								$('#error-message').fadeOut('slow', function() {
									$(this).addClass('d-none').show();
								});
							}, 3000);
						},
						complete: function() {
							$('#unlock-btn').html('<i class="bx bx-lock-open-alt"></i> Unlock');
						}
					});
				}

				$('#unlock-btn').click(function(e) {
					e.preventDefault();
					unlockScreen();
				});

				$('#userpassword').keypress(function(e) {
					if (e.which == 13) { // Enter key pressed
						e.preventDefault();
						unlockScreen();
					}
				});
			});
		</script>
	@endsection
