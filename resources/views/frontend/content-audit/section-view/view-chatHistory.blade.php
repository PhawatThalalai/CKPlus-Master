<div class="modal-content">
	<div class="modal-body">
		<div class="mt-0">
			<h5 class="font-size-15 fw-semibold"><i class="bx bx-message-dots text-muted align-middle me-1"></i> Comments :</h5>
			<div>
				<div class="d-flex py-3 border-bottom">
					<div class="flex-shrink-0 me-3">
						<div class="avatar-xs">
							<div class="avatar-title rounded-circle bg-light text-primary">
								<img src="{{ isset(Auth::user()->profile_photo_url) ? asset(Auth::user()->profile_photo_url) : asset('/assets/images/users/avatar-1.jpg') }}" alt="{{ Auth::user()->name }}" class="avatar-xs rounded-circle" alt="">
							</div>
						</div>
					</div>
					<div class="flex-grow-1">
						<h5 class="font-size-14 mb-1 fw-semibold text-primary">{{$tagpart->TagpartToUser->name}} ({{ implode(', ', $tagpart->TagpartToUser->getRoleNames()->toArray()) }})
							<small class="text-muted float-end" data-bs-toggle="tooltip" title="{{ date('d-m-Y H:i:s', strtotime($tagpart->created_at)) }}">{{ $tagpart->created_at->Locale('th_TH')->DiffForHumans() }}</small>
						</h5>
						<p class="text-muted mt-2 bg-light p-3 rounded-2">
								<i class="text-success mdi mdi-reply"></i> {{ @$tagpart->Detail_TrackPart }}
						</p>
						{{-- <div>
							<a href="javascript: void(0);" class="text-success"><i class="mdi mdi-reply"></i> Reply</a>
						</div> --}}
					</div>
				</div>
				<div class="table-responsive h-100" data-simplebar="init" style="max-height: 410px;  min-height : 410px;">
					<table class="table table-sm align-middle table-striped-columns table-hover mb-0">
						<thead class="table-info font-size-12 sticky-top">
							<tr class="text-center">
								<th style="width: 70%;">รายการ</th>
								<th style="width: 10%;">แก้ไข</th>
								<th style="width: 10%;">แก้ไขเรียบร้อย</th>
								<th style="width: 10%;">เรียบร้อย</th>
							</tr>
						</thead>
						<tbody id="scrollable-tbody" class="font-size-12">
							@foreach ($listDoc as $key => $list)
								<tr style="line-height: 210%;">
									<th scope="row" class=" text-truncate">{{ $key + 1 }}. {{ $list->name_th }}</th>
									<td class="">
										<div class="form-check form-radio form-radio-danger d-flex justify-content-center">
											<input class="form-check-input list-checkdoc check-edit" type="radio" name="listRadios-{{ $list->code }}" value="{{ $list->id }}" {{ (preg_match("/\b$list->id\b/", @$tagpart->TagpartToLog->check_edit))?'checked' : ''}}>
										</div>
									</td>
									<td class="">
										<div class="form-check form-radio form-radio-success d-flex justify-content-center">
											<input class="form-check-input list-checkdoc check-edited" type="radio" name="listRadios-{{ $list->code }}" value="{{ $list->id }}" {{ (preg_match("/\b$list->id\b/", @$tagpart->TagpartToLog->check_edited))?'checked' : ''}}>
										</div>
									</td>						
									<td>
										<div class="form-check form-radio form-radio-success d-flex justify-content-center">
											<input class="form-check-input list-checkdoc check-complete" type="radio" name="listRadios-{{ $list->code }}" value="{{ $list->id }}" {{ (preg_match("/\b$list->id\b/", @$tagpart->TagpartToLog->check_complete))?'checked' : ''}}>
										</div>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">
			<i class="mdi mdi-close-circle-outline"></i> ปิด
		</button>
	</div>
</div>