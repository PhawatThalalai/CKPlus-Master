<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>
@if (count(@$tags->TagToTagPart) != 0)
	<div class="d-flex align-items-start">
		@if (@$flag != 'show')
			<div class="me-2">
				<h6 class="card-title mb-3 font-size-14">รายละเอียดติดตาม</h6>
			</div>
			@can('create-tagpart')
				<div class="dropdown ms-auto">
					<span class="float-end mt-n2" data-bs-toggle="tooltip" title="เพิ่มบันทึกติดตาม">
						<ul class="list-inline user-chat-nav text-end mb-0">
							<li class="list-inline-item d-sm-inline-block me-auto">
								<div class="dropdown">
									<button class="btn nav-btn hover-up modal_lg" type="button" data-link="{{ route('tags.create') }}?funs={{ 'create-tagpart' }}&id={{ $id }}" {{ @$filter_tagPart }}>
										<i class="mdi mdi-clipboard-plus-outline bx-xs"></i>
									</button>
								</div>
							</li>
						</ul>
					</span>
				</div>
			@endcan
		@endif
	</div>

	<div data-simplebar="init" style="max-height: 235px;">
		<div class="shadow-sm">
			<table class="table table-bordered table-hover mb-0 ">
				<tbody class="bg-light sticky-top font-size-13">
					<tr>
						<th scope="col" class="text-center">ลำดับ</th>
						<th scope="col" class="text-center">รายละเอียด</th>
						<th scope="col" class="text-center">ลงชื่อ</th>
						{{-- <th scope="col" class="text-center">#</th> --}}
					</tr>
				</tbody>
				<tbody>
					@foreach (@$tags->TagToTagPart as $key => $item)
						<tr class="{{ ($item->Status_TrackPart == 'TAG-0004' or $item->Status_TrackPart == 'TAG-0005') ? 'table-warning' : '' }}">
							<td class="text-center">{{ $key + 1 }}</td>
							<td>
								<h5 class="font-size-12 text-truncate">
									<a href="javascript: void(0);" class="text-dark">
										<i class="bx bx-calendar-event align-middle me-1 text-success"></i>{{ formatDateThaiLong(@$item->created_at) }} เวลา {{ @$item->created_at->format('H:i:s') }}
										@if (@$item->Status_TrackPart == 'TAG-0001' or $item->Status_TrackPart == 'TAG-0004' or $item->Status_TrackPart == 'TAG-0005')
											<span class="text-warning fw-semibold">
											@elseif (@$item->Status_TrackPart == 'TAG-0002')
												<span class="text-danger fw-semibold">
												@elseif (@$item->Status_TrackPart == 'TAG-0003')
													<span class="text-success fw-semibold">
										@endif
										({{ @$item->TagPartToStateTagParts->Name_StatusTag }})
										</span>
									</a>
								</h5>

								<p class="text-muted mb-0 mt-n1 font-size-12 blockquote-footer">
									@empty(!@$item->Detail_TrackPart)
										{{ @$item->Detail_TrackPart }}
									@else
										<em class="text-secondary text-opacity-50">ไม่พบข้อมูล</em>
									@endempty
								</p>
								@empty(!@$item->Duedate_TrackPart)
									<p class="text-muted mb-0 mt-0 font-size-12 blockquote-footer">
										<em><span class="text-danger fw-semibold">นัดหมายครั้งถัดไป : </span>
											{{ date('d-m-Y', strtotime($item->Duedate_TrackPart)) }}
										</em>
									</p>
								@endempty
							</td>
							<td class="text-nowrap">
								<span>
									<i class="bx bx-user-circle align-middle me-1 text-success"></i>{{ @$item->getUserName() }} <em>({{ @$item->getNameRoles() }})</em>
									<p class="text-muted mb-2 mt-0 font-size-12 blockquote-footer">
										<em>{{ @$item->TagpartToBranch->Name_Branch }}</em>
									</p>
								</span>
							</td>
							{{-- <td>
								@can('edit-tagpart')
									<div class="d-flex justify-content-center">
										<a href="javascript:void(0);" class="text-success hover-up"><i class="bx bx-edit-alt font-size-18"></i></a>
									</div>
								@endcan
							</td> --}}
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@else
	@if (@$flag != 'show')
		@component('components.content-empty.view-empty')
			@slot('tb_style')
				style="min-height:15rem; max-height:15rem;"
			@endslot
			@slot('btn_icon')
				<i class="bx bx-comment-dots"></i>
			@endslot
			@slot('data_link')
				data-link="{{ route('tags.create') }}?funs={{ 'create-tagpart' }}&id={{ $id }}"
			@endslot
			@slot('data', [
				// 'id' => @$item->id,
				'title' => 'ยังไม่มีข้อมูลรายละเอียดติดตาม',
				'title_btn' => 'เพิ่มรายละเอียด',
				'name_btn' => 'modal_lg',
				])
			@endcomponent
		@else
			@component('components.content-empty.view-empty')
				@slot('tb_style')
					style="min-height:15rem; max-height:15rem;"
				@endslot
				@slot('btn_icon')
					<i class="bx bxs-user-circle"></i>
				@endslot
				@slot('data_link')
					href="{{ route('cus.index') }}?page={{ 'profile-cus' }}&id={{ @$DataCus_id }}"
				@endslot
				@slot('data', [
					'title' => 'ยังไม่มีข้อมูลรายละเอียดติดตาม',
					'title_btn' => 'ไปยังโปรไฟล์',
					])
				@endcomponent
			@endif
		@endif

		<script>
			$(function() {
				$('[data-bs-toggle="tooltip"]').tooltip()
			})
		</script>
