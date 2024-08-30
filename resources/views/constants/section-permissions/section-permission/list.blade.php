@extends('layouts.master')
@section('title', 'Permission')
@section('page-backend', 'd-none')

@section('content')
	<div class="container-fluid">
		<!-- start page title -->
		<div class="row">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0 font-size-18">Manage Permission</h4>
					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
							<li class="breadcrumb-item active">Permission Lists</li>
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
							<h5 class="mb-0 card-title flex-grow-1">Permission Lists</h5>
							<div class="flex-shrink-0">
								<button type="button" class="btn btn-primary waves-effect waves-light" data-bs-toggle="modal" data-bs-target=".create-permission-modal">Add New Permission</button>
							</div>
						</div>
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table id="table-permission" class="table align-middle table-nowrap table-hover">
								<thead class="table-light">
									<tr>
										<th scope="col" style="width: 40px;">#</th>
										<th scope="col">Name</th>
										<th scope="col">Action</th>
										<th scope="col">Module</th>
										<th scope="col">Created at</th>
										<th scope="col">Updated at</th>
										<th scope="col">Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($permissions as $key => $permission)
										<tr data-id="{{ @$permission->id }}" data-module-id="{{ @$permission->module_id }}">
											<td class="text-center">
												{{ $key + 1 }}
											</td>
											<td>
												<h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">{{ @$permission->name_en }}</a></h5>
												<p class="text-muted mb-0">{{ @$permission->name_th }}</p>
											</td>
											<td>{{ @$permission->name }}</td>
											<td>
												<span class="badge badge-soft-primary font-size-11 m-1">{{ @$permission->module->{'name_' . app()->getLocale()} }}</span>
											</td>
											<td>{{ @$permission->created_at }}</td>
											<td>{{ @$permission->updated_at }}</td>
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
				</div> <!-- end col -->
			</div> <!-- end row -->
		</div>
	</div>

	<script>
		$(document).ready(function() {
			var table = $('#table-permission').DataTable({
				// order: [
				// 	[3, 'asc']
				// ],
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
