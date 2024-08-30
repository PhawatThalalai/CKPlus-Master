@extends('layouts.master')
@section('title', 'roles')
@section('page-mega', 'active')

@section('content')
	<div class="container-fluid">
		<!-- start page title -->
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0 font-size-18">Manage Role</h4>
					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
							<li class="breadcrumb-item active">Role Lists</li>
						</ol>
					</div>
				</div>
			</div>
		</div>
		<!-- end page title -->

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body border-bottom">
						<div class="d-flex align-items-center">
							<h5 class="mb-0 card-title flex-grow-1">Role Lists</h5>
							<div class="flex-shrink-0">
								<div class="list-inline-item user-chat-nav">
									<div class="dropdown" data-bs-toggle="tooltip" title="Add New Role">
										<button class="btn nav-btn bg-info text-white shadow-sm hover-up" type="button" data-bs-toggle="modal" data-bs-target=".create-roles-modal">
											<i class="mdi mdi-sitemap"></i>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="content-roles">
							@include('constants.section-permissions.section-role.data-list')
						</div>
					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>
	<!-- end container-fluid -->

	<div class="modal fade create-roles-modal" tabindex="-1" aria-labelledby="myLargeModalLabel" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="myLargeModalLabel"><i class="mdi mdi-sitemap font-size-22 text-info me-2"></i>สร้างบทบาท ( New roles )</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="create_roles" class="needs-validation" action="#" method="post" enctype="multipart/form-data" novalidate>
						@csrf
						<div class="mb-3">
							<label for="code_role" class="form-label">code (รหัส)</label>
							<input type="text" class="form-control" id="code_role" name="code_role" required>
						</div>
						<div class="mb-3">
							<label for="name_role" class="form-label">active (บาทบาท)</label>
							<input type="text" class="form-control" id="name_role" name="name_role" required>
						</div>
						<div class="mb-3">
							<label for="name_en_role" class="form-label">name_en (ภาษาอังกฤษ)</label>
							<input type="text" class="form-control" id="name_en_role" name="name_en_role" required>
						</div>
						<div class="mb-3">
							<label for="name_th_role" class="form-label">name_th (ภาษาไทย)</label>
							<input type="text" class="form-control" id="name_th_role" name="name_th_role" required>
						</div>
						<div class="text-center">
							<button type="button" id="btn_createRoles" class="btn btn-sm btn-primary hover-up">create role</button>
							<button type="button" class="btn btn-sm btn-secondary hover-up" data-bs-dismiss="modal" aria-label="Close">Discard</button>
						</div>
					</form>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div>

	<script>
		$('#btn_createRoles').click(function() {
			var dataform = document.querySelectorAll('#create_roles');
			var validate = validateForms(dataform);

			if (validate) {
				$('#btn_createRoles').prop('disabled', true);
				
				$.ajax({
					url: "{{ route('permission.store') }}",
					method: 'POST',
					data: {
						"_token": "{{ csrf_token() }}",
						"page": "roles-create",
						"code_role": $('#code_role').val(),
						"name_role": $('#name_role').val(),
						"name_en_role": $('#name_en_role').val(),
						"name_th_role": $('#name_th_role').val(),
					},
					success: function(result) {
						$('.content-roles').html(result.view);
						$('.create-roles-modal').modal('hide');

						Swal.fire({
							icon: 'success',
							title: 'บันทึกข้อมูลสำเร็จ',
							showConfirmButton: false,
							timer: 1500
						});
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
						$('#btn_createRoles').prop('disabled', false);
					}
				});
			} else {
				Swal.fire({
					icon: 'error',
					text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
					showConfirmButton: false,
					timer: 1500
				});
			}
		});
	</script>
@endsection
