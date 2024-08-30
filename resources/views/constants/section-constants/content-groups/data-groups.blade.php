<style>
	.highlight-text-danger {
		color: rgb(235, 4, 4);
		text-decoration: underline;
	}
</style>
<div>
	<div class="card">
		<div class="card-body">
			<ul class="list-inline user-chat-nav mb-0 float-end">
				<li class="list-inline-item d-sm-inline-block me-auto">
					<div class="dropdown">
						<div class="" data-bs-toggle="tooltip" title="new group">
							<button id="createTask" type="button" class="btn nav-btn btn-light waves-effect hover-up modal_lg" data-link="{{ route('dataStatic.create') }}?page={{ 'constants' }}&module={{ 'create-groups' }}">
								<i class="bx bx-plus bx-xs"></i>
							</button>
						</div>
					</div>
				</li>
			</ul>

			<h4 class="card-title mb-4">รายการแบ่งกลุ่ม</h4>
			<div id="task-1">
				@isset($dataGroup)
					<div id="upcoming-task" class="pb-1 task-list">
						<div class="row">
							@foreach ($dataGroup as $group)
								<div class="col-xl-4 col-lg-6 col-sm-6">
									<div class="card task-box hover-up {{ $group->groupStatus !== 'active' ? 'bg-secondary bg-opacity-25' : '' }}" id="uptask-{{ $group->id }}">
										<div class="card-body">
											<div class="dropdown float-end">
												<a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
													<i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
												</a>
												<div class="dropdown-menu dropdown-menu-end">
													<a class="dropdown-item d-flex justify-content-between pe-auto edittask-details modal_lg" id="taskedit" data-id="#uptask-{{ $group->id }}" data-link="{{ route('dataStatic.edit', $group->id) }}?page={{ 'constants' }}&module={{ 'edit-groups' }}">
														แก้ไข
														<i class="bx bxs-edit fs-5 text-warning"></i>
													</a>
													<a role="button" class="dropdown-item d-flex justify-content-between pe-auto {{ $group->groupStatus !== 'active' ? 'activeTask' : 'inactiveTask' }}" href="#" id="eventtask" data-id="#uptask-{{ $group->id }}">
														{{ $group->groupStatus !== 'active' ? 'เปิดใช้งาน' : 'ปิดใช้งาน' }}
														<i class="bx bx-grid-alt fs-5 text-primary"></i>
													</a>
												</div>
											</div> <!-- end dropdown -->
											<div class="float-end ml-2">
												<span class="badge rounded-pill {{ $group->groupStatus == 'active' ? 'badge-soft-success' : 'badge-soft-danger' }} font-size-12 fw-semibold" id="task-status">{{ $group->groupStatus }}</span>
											</div>

											<div>
												<h5 class="font-size-15"><a href="javascript: void(0);" class="text-dark" id="task-name">{{ $group->groupName }}</a></h5>
												{{-- <p class="text-muted mb-4">{{ $group->groupDesc }}</p> --}}
											</div>

											<ul class="ps-3 mb-4 text-muted" id="task-desc">
												@php
													$groupTypeIds = explode(',', $group->groupType);
													$dataGroupType = App\Models\TB_Constants\TB_Frontend\TB_TypeGroups::wherein('id', $groupTypeIds)->get();
													$typeGroupNames = $dataGroupType->pluck('TypeGroup_Name')->implode(',');
												@endphp

												<li class="py-1">{{ $typeGroupNames }}</li>
												<li class="py-1">{{ $group->groupDesc ?? '-' }}</li>
											</ul>

											<div class="avatar-group float-start task-assigne">
												@foreach (@$group->groupLists as $groupList)
													@if ($loop->index > 2)
														<div class="avatar-group-item">
															<a href="javascript: void(0);" class="d-inline-block">
																<div class="avatar-xs">
																	<span class="avatar-title rounded-circle bg-info text-white font-size-16">
																		{{ $loop->count - $loop->index }}+
																	</span>
																</div>
															</a>
														</div>
													@break

												@else
													<div class="avatar-group-item avatar-xs">
														<span class="avatar-title rounded-circle bg-danger text-white font-size-16" data-bs-toggle="tooltip" title="{{ $groupList->branchs->Name_Branch }}">
															{{ strtoupper(substr(@$groupList->branchs->NickName_Branch, 0, 3)) }}
														</span>
													</div>
												@endif
											@endforeach
										</div>

										<div class="text-end">
											<h5 class="font-size-15 mb-1" id="task-budget">
												<div class="d-flex align-items-center justify-content-end">
													<i class="bx bxs-user-circle me-1"></i> ผู้ดูแล
												</div>
											</h5>
											<p class="mb-0 text-muted">
												@php
													$userNames = \App\Models\User::whereIn('id', explode(',', $group->groupHandler))
													    ->pluck('name')
													    ->toArray();
													$userNamesString = implode(',', $userNames);
												@endphp

												{{ $userNamesString }}
											</p>
										</div>
									</div>
									<div class="px-4 py-3 border-top">
										<ul class="list-inline mb-0">
											<li class="list-inline-item me-3">
												<span class="badge bg-success">Completed</span>
											</li>
											<li class="list-inline-item me-3">
												<i class="bx bx-calendar me-1"></i> {{ @$group->created_at != null ? @$group->created_at->format('d-m-Y H:i:s') : null }}
											</li>
											{{-- <li class="list-inline-item me-3">
												<i class="bx bx-comment-dots me-1"></i> 214
											</li> --}}
										</ul>
									</div>
								</div>
							</div>
						@endforeach
					</div>
				@endisset
			</div>
		</div>
	</div>
</div>

<link href="{{ URL::asset('/assets/css/select2-custom.css') }}" rel="stylesheet" type="text/css" />

<script>
	$(document).ready(function() {
		$('.inactiveTask').on('click', function() {
			let taskid = $(this).data('id');
			let id = taskid.split('-')[1];
			let taskName = $(taskid).find('#task-name').text(); // หรือ .html() ถ้าคุณต้องการ HTML

			Swal.fire({
				icon: "warning",
				title: `ยืนยันปิดกลุ่ม`,
				html: '<span class="text-title">คุณต้องการปิดกลุ่ม <span class="highlight-text-danger">' + taskName + '</span> หรือไม่ ?.</span>',
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: 'ตกลง',
				cancelButtonText: 'ยกเลิก',
			}).then((result) => {
				if (result.isConfirmed) {
					let link = "{{ route('dataStatic.destroy', 'id') }}";
					let url = link.replace('id', id);

					$(taskid).find('#task-status').text('inactive');
					$(taskid).find('#task-status').removeClass('badge-soft-success').addClass('badge-soft-danger');
					$(taskid).addClass('bg-secondary bg-opacity-25');

					$.ajax({
						url: url,
						method: 'delete',
						data: {
							_token: "{{ @csrf_token() }}", // แก้ไขตรงนี้เป็น csrf_token()
							destroy: 'inactive-groups'
						},
						success: function(response) {
							$('.content-page').html(response.html);
							$(".toast-success").toast({
								delay: 1500
							}).toast("show");
							$(".toast-success .toast-body .text-body").text('Successful');

							$(taskid).find('#eventtask').removeClass('inactiveTask').addClass('activeTask').html('เปิดใช้งาน <i class="bx bx-grid-alt fs-5 text-primary"></i>');
						},
						error: function(response) {
							$(taskid).find('#task-status').text('active');
							$(taskid).find('#task-status').removeClass('badge-soft-danger').addClass('badge-soft-success');
							$(taskid).removeClass('bg-secondary bg-opacity-25');

							$(taskid).find('#eventtask').removeClass('activeTask').addClass('inactiveTask').html('ปิดใช้งาน <i class="bx bx-grid-alt fs-5 text-primary"></i>');
							Swal.fire({
								icon: 'error',
								title: `ดำเนินการไม่สำเร็จ !`,
								text: 'พบข้อผิดพลาด กรุณาลองใหม่อีกครั้ง',
								showConfirmButton: true,
							});
						}
					});
				}
			});
		});

		$('.activeTask').on('click', function() {
			let taskid = $(this).data('id');
			let id = taskid.split('-')[1];
			let taskName = $(taskid).find('#task-name').text(); // หรือ .html() ถ้าคุณต้องการ HTML

			Swal.fire({
				icon: "info",
				title: `เปิดใช้งานกลุ่ม`,
				html: '<span class="text-title">คุณต้องการเปิดกลุ่ม <span class="highlight-text-danger">' + taskName + '</span> หรือไม่ ?.</span>',
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: 'ตกลง',
				cancelButtonText: 'ยกเลิก',
			}).then((result) => {
				if (result.isConfirmed) {
					let link = "{{ route('dataStatic.destroy', 'id') }}";
					let url = link.replace('id', id);

					$(taskid).find('#task-status').text('active');
					$(taskid).find('#task-status').addClass('badge-soft-success').removeClass('badge-soft-danger');
					$(taskid).removeClass('bg-secondary bg-opacity-25');

					$.ajax({
						url: url,
						method: 'delete',
						data: {
							_token: "{{ @csrf_token() }}", // แก้ไขตรงนี้เป็น csrf_token()
							destroy: 'active-groups'
						},
						success: function(response) {
							$('.content-page').html(response.html);
							$(".toast-success").toast({
								delay: 1500
							}).toast("show");
							$(".toast-success .toast-body .text-body").text('Successful');

							$(taskid).find('#eventtask').removeClass('activeTask').addClass('inactiveTask').html('ปิดใช้งาน <i class="bx bx-grid-alt fs-5 text-primary"></i>');
						},
						error: function(response) {
							$(taskid).find('#task-status').text('inactive');
							$(taskid).find('#task-status').addClass('badge-soft-danger').removeClass('badge-soft-success');
							$(taskid).addClass('bg-secondary bg-opacity-25');

							$(taskid).find('#eventtask').removeClass('inactiveTask').addClass('activeTask').html('เปิดใช้งาน <i class="bx bx-grid-alt fs-5 text-primary"></i>');
							Swal.fire({
								icon: 'error',
								title: `ดำเนินการไม่สำเร็จ !`,
								text: 'พบข้อผิดพลาด กรุณาลองใหม่อีกครั้ง',
								showConfirmButton: true,
							});
						}
					});
				}
			});
		});


	});
</script>
