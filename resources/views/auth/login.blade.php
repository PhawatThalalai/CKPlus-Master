{{-- <x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="username" value="{{ __('Username') }}" />
                <x-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout> --}}

@extends('layouts.master-without-nav')
<div>
	<div class="container-fluid p-0">
		<div class="row g-0">
			<div class="col-xl-9 col-lg-8">
				<div class="pt-lg-5 px-4" style="background-color:#dbdbdd;">
					<div class="w-100 h-100">
						<img src="{{ URL::asset('/assets/images/web-ck.png') }}" alt="" class="auth-logo-light" style="width:100%;">
					</div>
				</div>
			</div>
			<!-- end col -->
			<div class="col-xl-3 col-lg-4">
				<div class="auth-full-page-content p-md-5 p-4">
					<div class="w-100">
						<div class="d-flex flex-column h-100">
							<div class="mb-4 mb-md-5">
								<a href="index" class="d-block auth-logo">
									<img src="{{ URL::asset('/assets/images/ck-logo.png') }}" alt="" height="50" class="auth-logo-dark">
								</a>
							</div>
							<div class="pt-4">
								<div>
									<h5 class="text-primary">Chookiat Plus+</h5>
									<p class="text-muted">กู้ง่ายคนใต้ด้วยกัน</p>
								</div>
								<div class="mt-4">
									<x-validation-errors class="mb-4" />
									@if (session('status'))
										<div class="mb-4 font-medium text-sm text-green-600">
											{{ session('status') }}
										</div>
									@endif

									<form method="POST" action="{{ route('login') }}">
										@csrf

										<div class="mb-3">
											<x-label for="username" value="{{ __('Username') }}" />
											<x-input id="username" class="form-control mt-1 w-full" type="text" name="username" :value="old('username')" required autofocus autocomplete="username" />
										</div>

										<div class="mb-3">
											<div class="float-end">
												@if (Route::has('password.request'))
													<a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 text-muted" href="{{ route('password.request') }}">
														{{ __('Forgot your password?') }}
													</a>
												@endif
											</div>

											<x-label for="password" value="{{ __('Password') }}" />
											<div class="input-group auth-pass-inputgroup">
												<x-input id="password" class="form-control mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
												<button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
											</div>
										</div>

										<div class="form-check">
											<input class="form-check-input" type="checkbox" id="remember-check">
											<label class="form-check-label" for="remember-check">
												Remember me
											</label>
										</div>

										<div class="mt-3 d-grid">
											<button class="btn btn-primary waves-effect waves-light" type="submit">Log In</button>
										</div>
									</form>

									<div class="mt-4 text-center">
										<h5 class="font-size-14 mb-3">Sign in with</h5>
										<ul class="list-inline">
											<li class="list-inline-item">
												<a href="javascript::void()" class="social-list-item bg-primary text-white border-primary">
													<i class="mdi mdi-facebook"></i>
												</a>
											</li>
											<li class="list-inline-item">
												<a href="javascript::void()" class="social-list-item bg-info text-white border-info">
													<i class="mdi mdi-twitter"></i>
												</a>
											</li>
											<li class="list-inline-item">
												<a href="javascript::void()" class="social-list-item bg-danger text-white border-danger">
													<i class="mdi mdi-google"></i>
												</a>
											</li>
										</ul>
									</div>

									<div class="mt-5 text-center">
										<p>Don't have an account ? <a href="auth-register-2" class="fw-medium text-primary"> Signup now </a> </p>
									</div>
								</div>
							</div>

							<div class="mt-4 mt-md-5 text-center">
								<p class="mb-0">©
									<script>
										document.write(new Date().getFullYear())
									</script> Skote. Crafted with <i class="mdi mdi-heart text-danger"></i> by Devp Chookiat
								</p>
							</div>
						</div>

					</div>
				</div>
			</div>
			<!-- end col -->
		</div>
		<!-- end row -->
	</div>
	<!-- end container-fluid -->
</div>
