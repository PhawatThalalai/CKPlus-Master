@extends('layouts.master')
@section('title', 'users')
@section('page-mega', 'active')

@section('content')
	<div class="container-fluid">
		<div class="row mt-n5">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0 font-size-18">Manage User</h4>

					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
							<li class="breadcrumb-item active">User Lists</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
		<!-- end page title -->

		<div class="row">
			<div class="col">
				<div class="card">
					<div class="d-flex m-3">
						<div class="flex-shrink-0 me-4 mt-2">
							<img src="{{ URL::asset('assets/images/gif/avatar.gif') }}" alt="" style="width: 50px;">
						</div>
						<div class="flex-grow-1 overflow-hidden border-primary border-bottom">
							<h5 class="text-primary fw-semibold pt-2 font-size-15">User Lists</h5>
						</div>
						<div class="flex-shrink-1 border-primary border-bottom">
							<div class="list-inline-item user-chat-nav">
								<div class="dropdown">
									<button class="btn nav-btn bg-info text-white shadow-sm hover-up modal_lg" type="button" data-link="{{ route('permission.create') }}?page={{ 'users-create' }}" data-bs-toggle="tooltip" title="เพิ่มผู้ใช้">
										<i class="bx bx-user-plus"></i>
									</button>
									<button class="btn nav-btn bg-danger text-white shadow-sm hover-up modal_lg" type="button" data-link="{{ route('permission.create') }}?page={{ 'users-restore' }}" data-bs-toggle="tooltip" title="ถังขยะผู้ใช้">
										<i class="mdi mdi-account-clock"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body my-0 px-2">
						<div class="table-responsive content-user">
							@include('constants.section-users.list')
						</div>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
@endsection
