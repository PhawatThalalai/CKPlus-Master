@extends('layouts.master')
@section('title', 'modules')
@section('page-backend', 'd-none')

@section('content')
	<div class="container-fluid">
		<!-- start page title -->
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0 font-size-18">Manage Module</h4>

					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
							<li class="breadcrumb-item active">Module Lists</li>
						</ol>
					</div>

				</div>
			</div>
		</div>
		<!-- end page title -->

		@if (session('success'))
			<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
				{{ session('success') }}
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
			</div>
		@elseif($errors->any())
			<div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
				@foreach ($errors->all() as $error)
					<div>{{ $error }}</div>
				@endforeach
				<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
		@endif
		<script>
			// Automatically close the alert after 3 seconds
			setTimeout(function() {
				$(".alert").alert('close');
			}, 3000);
		</script>

		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-body border-bottom">
						<div class="d-flex align-items-center">
							<h5 class="mb-0 card-title flex-grow-1">Module Lists</h5>
							<div class="flex-shrink-0">
								<button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".create-module-modal">Add New Module</button>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div id="event-result"></div>
						<div class="table-responsive">
							<table id="table-module" class="table align-middle table-nowrap table-hover">
								<thead class="table-light">
									<tr>
										<th scope="col" style="width: 40px;">#</th>
										<th scope="col">Name</th>
										<th scope="col">action</th>
										<th scope="col">Permissions</th>
										<th scope="col">Created at</th>
										<th scope="col">Updated at</th>
										<th scope="col">Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($modules as $key => $module)
										<tr data-id="{{ $module->id }}">
											<td class="text-center">{{ $key + 1 }}</td>
											<td>
												<h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">{{ $module->name_en }}</a></h5>
												<p class="text-muted mb-0">{{ $module->name_th }}</p>
											</td>
											<td class="text-center">{{ $module->action }}</td>
											<td class="text-center">
												<span class="badge badge-soft-warning font-size-12 m-1">{{ $module->permissions->count() }}</span>
											</td>
											<td>{{ $module->created_at }}</td>
											<td>{{ $module->updated_at }}</td>
											<td>
												<ul class="list-inline font-size-20 contact-links mb-0">
													<li class="list-inline-item px-2">
														<a href="javascript: void(0);" class="btn-edit" title="Edit"><i class="bx bx-edit"></i></a>
													</li>
													<li class="list-inline-item px-2">
														<a href="javascript: void(0);" class="btn-delete" title="Delete"><i class="bx bx-trash-alt"></i></a>
													</li>
												</ul>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>

					</div>
				</div>
			</div> <!-- end col -->
		</div> <!-- end row -->
	</div>

	<!-- Modal Create Module Center -->
	<div class="modal fade create-module-modal" tabindex="-1" role="dialog" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Create Module</h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<form id="form-create" action="{{ route('permission.store') }}?funs={{ 'create-modules' }}" method="POST">
						@csrf
						<div class="mb-3">
							<label for="action" class="form-label">Action</label>
							<select class="form-select" id="action" name="action" required>
								<option selected="" disabled="" value="">Select...</option>
								<option>fontend</option>
								<option>backend</option>
							</select>
						</div>
						<div class="mb-3">
							<label for="name_en" class="form-label">Name (EN)</label>
							<input type="text" class="form-control" id="name_en" name="name_en" placeholder="Example ระบบ..." required>
						</div>
						<div class="mb-3">
							<label for="name_th" class="form-label">Name (TH)</label>
							<input type="text" class="form-control" id="name_th" name="name_th" required>
						</div>
						<div class="text-center">
							<button type="submit" class="btn btn-primary me-sm-3 me-1">Create Module</button>
							<button type="reset" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close">Discard</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
		$(document).ready(function() {
			var table = $('#table-module').DataTable({
				order: [
					[2, 'desc']
				],
				columnDefs: [{
						orderable: false,
						targets: [0, -1]
					}, // Disable ordering for the hidden column
				],
				rowReorder: {
					selector: 'tr td:nth-child(1)',
					dataSrc: 1, // Specify the index of the column containing the icon
				}
			})
		});
	</script>
@endsection
