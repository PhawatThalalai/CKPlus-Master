<div>
	<div class="card">
		<div class="card-body">
			<ul class="list-inline user-chat-nav mb-0 float-end">
				<li class="list-inline-item d-sm-inline-block me-auto">
					<div class="dropdown">
						<div class="" data-bs-toggle="tooltip" title="new group">
							<button wire:click='showModalFormCreate()' id="createTask" type="button" class="btn nav-btn btn-light waves-effect hover-up" data-bs-toggle="modal" data-bs-target=".create-group">
								<i class="bx bx-edit-alt bx-xs"></i>
							</button>
						</div>

						<div class="content-group">
							{{-- <livewire:section-constants.content-groups.create-group /> --}}
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
									<div class="card task-box hover-up" id="uptask-{{ $group->id }}">
										<div class="card-body">
											<div class="dropdown float-end">
												<a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
													<i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
												</a>
												<div class="dropdown-menu dropdown-menu-end">
													<a class="dropdown-item edittask-details" href="#" id="taskedit" data-id="#uptask-{{ $group->id }}" data-bs-toggle="modal" data-bs-target=".bs-example-modal-lg">Edit</a>
													<a class="dropdown-item deletetask" href="#" data-id="#uptask-{{ $group->id }}">Delete</a>
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
											</ul>

											<div class="avatar-group float-start task-assigne">
												@foreach ($group->groupLists as $groupList)
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
															{{ strtoupper(substr($groupList->branchs->NickName_Branch, 0, 3)) }}
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
											<p class="mb-0 text-muted">{{ !empty(@$group->groupHandler) ? @$group->groupHandlerUser->name : '-' }}</p>
										</div>
									</div>
									<div class="px-4 py-3 border-top">
										<ul class="list-inline mb-0">
											<li class="list-inline-item me-3">
												<span class="badge bg-success">Completed</span>
											</li>
											<li class="list-inline-item me-3">
												<i class="bx bx-calendar me-1"></i> {{ $group->created_at->format('d-m-Y H:i:s') }}
											</li>
											<li class="list-inline-item me-3">
												<i class="bx bx-comment-dots me-1"></i> 214
											</li>
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

@include('livewire.section-constants.content-groups.create-group-1')
</div>
