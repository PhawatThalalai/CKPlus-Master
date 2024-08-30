@extends('layouts.master')
@section('title', 'roles')
@section('role-permission-active', 'mm-active')
@section('role-active', 'mm-active')
@section('page-backend', 'd-none')

@section('content')
	<style>
		/*--------------- tree --------------*/
		.tree {
			min-height: 20px;
			padding: 19px;
			margin-bottom: 20px;
			/* background-color: #fbfbfb; */
			border: 1px solid #999;
			-webkit-border-radius: 4px;
			-moz-border-radius: 4px;
			border-radius: 4px;
			-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
			-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05);
			box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.05)
		}

		.tree li {
			list-style-type: none;
			margin: 0;
			padding: 10px 5px 0 5px;
			position: relative
		}

		.tree li::before,
		.tree li::after {
			content: '';
			left: -20px;
			position: absolute;
			right: auto
		}

		.tree li::before {
			border-left: 1px solid #999;
			bottom: 50px;
			height: 100%;
			top: 0;
			width: 1px
		}

		.tree li::after {
			border-top: 1px solid #999;
			height: 20px;
			top: 25px;
			width: 25px
		}

		.tree li span {
			-moz-border-radius: 5px;
			-webkit-border-radius: 5px;
			border: 1px solid #999;
			border-radius: 5px;
			display: inline-block;
			padding: 3px 8px;
			text-decoration: none
		}

		.tree li.parent_li>span {
			cursor: pointer
		}

		.tree>ul>li::before,
		.tree>ul>li::after {
			border: 0
		}

		.tree li:last-child::before {
			height: 25px
		}

		.tree li.parent_li>span:hover,
		.tree li.parent_li>span:hover+ul li span {
			background: #eee;
			border: 1px solid #94a0b4;
			color: #000
		}

		.tree li.closed>ul>li {
			display: none;
		}

		.tree li.closed::before,
		.tree li.closed::after {
			display: none;
		}
	</style>

	<div class="row">
		<div class="col-12">
			<div class="page-title-box d-sm-flex align-items-center justify-content-between">
				<h4 class="mb-sm-0 font-size-18">Manage Role</h4>
				<div class="page-title-right">
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
						<li class="breadcrumb-item active">Create Role</li>
					</ol>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<div class="card">
				<div class="card-body">
					<h4 class="card-title mb-4">Create New Role</h4>
					<form id="form-editRoles" class="needs-validation outer-repeater" method="POST" novalidate>
						@csrf
						@method('PUT')

						<div data-repeater-list="outer-group" class="outer">
							<div data-repeater-item class="outer">
								<div class="form-group row mb-1">
									<label for="code" class="col-form-label col-lg-2 fw-semibold">Code</label>
									<div class="col-lg-8">
										<input id="code" name="code" type="text" value="{{ old('code', $role->code) }}" class="form-control" placeholder="Enter Role Code..." required>
									</div>
								</div>
								<div class="form-group row mb-4">
									<label for="name_en" class="col-form-label col-lg-2 fw-semibold">Name</label>
									<div class="col-lg-4 mb-3 mb-md-3 mb-lg-0">
										<input id="name_en" name="name_en" type="text" value="{{ old('code', $role->name_en) }}" class="form-control" placeholder="EN" required>
									</div>
									<div class="col-lg-4">
										<input id="name_th" name="name_th" type="text" value="{{ old('code', $role->name_th) }}" class="form-control" placeholder="TH" required>
									</div>
								</div>

								<div class="row justify-content-center">
									<div class="col-xl-8">
										<div class="clearfix">
                                            <div class="float-end">
                                                <button type="button" id="btn_permission" class="btn btn-sm btn-dark ms-3" data-id="{{ $role->id }}">
													<span class="permission-icon d-none"><i class="mdi mdi-loading mdi-spin me-1 font-size-12"></i></span>SAVE
												</button>
                                            </div>
                                            <h6 class="card-title fw-semibold font-size-13">Permissions (Administrator Access)
												<i class="bx bx-info-circle bx-xs" data-bs-toggle="tooltip" data-bs-placement="top" title="Allows a full access to the system"></i>
											</h6>
                                        </div>

										<div class="mt-4">
											<div class="d-flex flex-wrap bg-primary bg-soft p-2 rounded">
												<div class="me-2">
													<h6 class="fw-semibold">Settings System Mega Menu</h6>
												</div>
												<div class="ms-auto">
													<div class="d-flex align-items-center">
														<div class="form-check">
															<input class="form-check-input" type="checkbox" id="StAll_modules" />
															<label class="form-check-label fw-semibold" for="StAll_modules">
																Select All
															</label>
														</div>
													</div>
												</div>
											</div>
											<div class="row mb-0">
												<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
													<div class="tree well mb-1">
														<ul>
															<li>
																<span><i class="icon-folder-open"></i> module</span> <a class="text-primary">Settings Mega menu</a>
																<ul>
																	@foreach ($menu_mega as $action)
																		<li>
																			<span><i class="icon-minus-sign"></i> ระบบ</span> <a class="text-primary">{{ $action->name_th }} ({{ $action->name_en }})</a>
																			<ul>
																				@foreach ($action->permissions as $key => $permission)
																					<li>
																						<div class="d-flex">
																							<span><i class="icon-leaf"></i> {{ $key + 1 }}.</span>
																							<div class="form-check me-3 me-lg-5 ms-2 mt-1">
																								<input class="form-check-input checkbox-item-modules font-size-14" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="checkbox-{{ $permission->id }}" @if (in_array($permission->id, $role_permissions)) checked @endif />
																								<label class="form-check-label" for="checkbox-{{ $permission->id }}">
																									{{ $permission->name_en }} ({{ $permission->name_th }})
																								</label>
																							</div>
																						</div>
																					</li>
																				@endforeach
																			</ul>
																		</li>
																	@endforeach
																</ul>
															</li>
														</ul>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
													<div class="tree well">
														<ul>
															<li>
																<span><i class="icon-folder-open"></i> module</span> <a class="text-primary">Settings action Mega menu</a>
																<ul>
																	@foreach ($maga_action as $module)
																		<li>
																			<span><i class="icon-minus-sign"></i> ระบบ</span> <a class="text-primary">{{ $module->name_th }} ({{ $module->name_en }})</a>
																			<ul>
																				@foreach ($module->permissions as $key => $permission)
																					<li>
																						<div class="d-flex">
																							<span><i class="icon-leaf"></i> {{ $key + 1 }}.</span>
																							<div class="form-check me-3 me-lg-5 ms-2 mt-1">
																								<input class="form-check-input checkbox-item-modules font-size-14" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="checkbox-{{ $permission->id }}" @if (in_array($permission->id, $role_permissions)) checked @endif />
																								<label class="form-check-label" for="checkbox-{{ $permission->id }}">
																									{{ $permission->name_en }} ({{ $permission->name_th }})
																								</label>
																							</div>
																						</div>
																					</li>
																				@endforeach
																			</ul>
																		</li>
																	@endforeach
																</ul>
															</li>
														</ul>
													</div>
												</div>
											</div>
										</div>

										<div class="mt-4">
											<div class="d-flex flex-wrap bg-primary bg-soft p-2 rounded">
												<div class="me-2">
													<h6 class="fw-semibold">Settings system Frontend</h6>
												</div>
												<div class="ms-auto">
													<div class="d-flex align-items-center">
														<div class="form-check">
															<input class="form-check-input" type="checkbox" id="StAll_modules" />
															<label class="form-check-label fw-semibold" for="StAll_modules">
																Select All
															</label>
														</div>
													</div>
												</div>
											</div>
											<div class="row mb-0">
												<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
													<div class="tree well mb-1">
														<ul>
															<li>
																<span><i class="icon-folder-open"></i> module</span> <a class="text-primary">Settings Menu frontend</a>
																<ul>
																	@foreach ($menu_front as $module)
																		<li>
																			<span><i class="icon-minus-sign"></i> ระบบ</span> <a class="text-primary">{{ $module->name_th }} ({{ $module->name_en }})</a>
																			<ul>
																				@foreach ($module->permissions as $key => $permission)
																					<li>
																						<div class="d-flex">
																							<span><i class="icon-leaf"></i> {{ $key + 1 }}.</span>
																							<div class="form-check me-3 me-lg-5 ms-2 mt-1">
																								<input class="form-check-input checkbox-item-modules font-size-14" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="checkbox-{{ $permission->id }}" @if (in_array($permission->id, $role_permissions)) checked @endif />
																								<label class="form-check-label" for="checkbox-{{ $permission->id }}">
																									{{ $permission->name_en }} ({{ $permission->name_th }})
																									{{-- {{ $permission->{'name_' . app()->getLocale()} }} --}}
																								</label>
																							</div>
																						</div>
																					</li>
																				@endforeach
																			</ul>
																		</li>
																	@endforeach
																</ul>
															</li>
														</ul>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
													<div class="tree well">
														<ul>
															<li>
																<span><i class="icon-folder-open"></i> module</span> <a class="text-primary">Settings action frontend</a>
																<ul>
																	@foreach ($action_front as $action)
																		<li>
																			<span><i class="icon-minus-sign"></i> ระบบ</span> <a class="text-primary">{{ $action->name_th }} ({{ $action->name_en }})</a>
																			<ul>
																				@foreach ($action->permissions as $key => $permission)
																					<li>
																						<div class="d-flex">
																							<span><i class="icon-leaf"></i> {{ $key + 1 }}.</span>
																							<div class="form-check me-3 me-lg-5 ms-2 mt-1">
																								<input class="form-check-input checkbox-item-modules font-size-14" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="checkbox-{{ $permission->id }}" @if (in_array($permission->id, $role_permissions)) checked @endif />
																								<label class="form-check-label" for="checkbox-{{ $permission->id }}">
																									{{ $permission->name_en }} ({{ $permission->name_th }})
																									{{-- {{ $permission->{'name_' . app()->getLocale()} }} --}}
																								</label>
																							</div>
																						</div>
																					</li>
																				@endforeach
																			</ul>
																		</li>
																	@endforeach
																</ul>
															</li>
														</ul>
													</div>
												</div>
											</div>
										</div>

										{{-- <div class="mt-4">
											<div class="d-flex flex-wrap bg-primary bg-soft p-2 rounded">
												<div class="me-2">
													<h6 class="fw-semibold">Settings system Backend</h6>
												</div>
												<div class="ms-auto">
													<div class="d-flex align-items-center">
														<div class="form-check">
															<input class="form-check-input" type="checkbox" id="StAll_views" />
															<label class="form-check-label fw-semibold" for="StAll_views">
																Select All
															</label>
														</div>
													</div>
												</div>
											</div>
											<div class="row mb-0">
												<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
													<div class="tree well">
														<ul>
															<li>
																<span><i class="icon-folder-open"></i> module</span> <a class="text-primary">Settings Menu backend</a>
																<ul>
																	@foreach ($menu_font as $menu)
																		<li>
																			<span><i class="icon-minus-sign"></i> ระบบ</span> <a class="text-primary">{{ $menu->name_th }} ({{ $menu->name_en }})</a>
																			<ul>
																				@foreach ($menu->permissions as $key => $permission)
																					<li>
																						<div class="d-flex">
																							<span><i class="icon-leaf"></i> {{ $key + 1 }}.</span>
																							<div class="form-check me-3 me-lg-5 ms-2 mt-1">
																								<input class="form-check-input checkbox-item-views font-size-14" type="checkbox" name="permissions[]" value="{{ $permission->id }}" id="checkbox-{{ $permission->id }}" @if (in_array($permission->id, $role_permissions)) checked @endif />
																								<label class="form-check-label" for="checkbox-{{ $permission->id }}">
																									{{ $permission->name_en }} ({{ $permission->name_th }})
																								</label>
																							</div>
																						</div>
																					</li>
																				@endforeach
																			</ul>
																		</li>
																	@endforeach
																</ul>
															</li>
														</ul>
													</div>
												</div>
											</div>
										</div> --}}
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
		$('#btn_permission').click(function() {
			let permissions = {};
			// $("#form-editRoles").serializeArray().map(function(x) {
			// 	permissions[x.name] = x.value;
			// });

			$("input[name='permissions[]']:checked").each(function() {
				permissions[$(this).val()] = $(this).val();
			});
			
			if ($.isEmptyObject(permissions)) {
				Swal.fire({
					icon: 'warning',
					text: 'กรุณา เพิ่มสิทธิ์ (Permission) ก่อนบันทึก !',
					showConfirmButton: false,
					timer: 1500
				});
			} else {
				$('.permission-icon').removeClass('d-none');
				$('#btn_permission').prop("disabled", true);

				let id = $(this).data('id');
				let code = $('#code').val();
				let name_en = $('#name_en').val();
				let name_th = $('#name_th').val();

				let url = "{{ route('permission.update', 'id') }}";
				url = url.replace('id', id);

				$.ajax({
					url: url,
					method: "put",
					data: {
						_token: "{{ @csrf_token() }}",
						id: id,
						code: code,
						name_en: name_en,
						name_th: name_th,
						permissions: permissions,
						page: 'roles-edit'
					},

					success: function(result) {
						$('#btn_permission').prop("disabled", false);
						$('.permission-icon').addClass('d-none');

						Swal.fire({
							icon: 'success',
							text: result.message,
							showConfirmButton: false,
							timer: 1500
						});
					},
					error: function(err) {
						$('#btn_permission').prop("disabled", false);
						$('.permission-icon').addClass('d-none');

						Swal.fire({
							icon: 'error',
							title: `ERROR ` + err.status + ` !!!`,
							text: err.responseJSON.message,
							showConfirmButton: true,
						});
					}
				})
			}
		});
	</script>

	<script>
		$(document).ready(function() {
			$("#StAll_modules").change(function() {
				if ($(this).prop("checked")) {
					$(".checkbox-item-modules").prop("checked", $(this).prop("checked"));
				} else {
					var role_permissions = @json($role_permissions);
					$(".checkbox-item-modules").prop("checked", false);
					$.each(role_permissions, function(index, value) {
						$("#checkbox-" + value).prop("checked", true);
					});
				}
			});

			// Individual checkboxes
			$(".checkbox-item-modules").change(function() {
				if ($(".checkbox-item-modules:checked").length === $(".checkbox-item-modules").length) {
					$("#StAll_modules").prop("checked", true);
				} else {
					$("#StAll_modules").prop("checked", false);
				}
			});

			$("#StAll_views").change(function() {
				if ($(this).prop("checked")) {
					$(".checkbox-item-views").prop("checked", $(this).prop("checked"));
				} else {
					var role_permissions = @json($role_permissions);
					$(".checkbox-item-views").prop("checked", false);
					$.each(role_permissions, function(index, value) {
						$("#checkbox-" + value).prop("checked", true);
					});
				}
			});

			// Individual checkboxes
			$(".checkbox-item-views").change(function() {
				if ($(".checkbox-item-views:checked").length === $(".checkbox-item-views").length) {
					$("#StAll_views").prop("checked", true);
				} else {
					$("#StAll_views").prop("checked", false);
				}
			});
		})
	</script>

	<script>
		//*************** table tree *************//
		$(function() {
			// เพิ่มคลาส closed ให้กับรายการแรกที่อยู่ใน .tree.well
			$('.tree.well > ul > li:first-child').addClass('closed');

			$('.tree li:has(ul)').addClass('parent_li').find(' > span').attr('title', 'Permissions');
			$('.tree li.parent_li > span').on('click', function(e) {
				var children = $(this).parent('li.parent_li').find(' > ul > li');
				if (children.is(":visible")) {
					children.hide('fast');
					$(this).attr('title', 'Expand this branch').find(' > i').addClass('icon-plus-sign').removeClass('icon-minus-sign');
				} else {
					children.show('fast');
					$(this).attr('title', 'Permissions').find(' > i').addClass('icon-minus-sign').removeClass('icon-plus-sign');
				}
				e.stopPropagation();
			});
		});
	</script>
@endsection
