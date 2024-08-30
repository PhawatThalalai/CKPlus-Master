<div id="active-{{ @$data['id'] }}" class="item event-list {{ @$active }}" style="cursor: pointer;">
	<div class="px-1 ">
		<label data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" data-bs-title="<p class='fw-semibold mb-0'> <i class='bx bx-error-circle'></i> ข้อมูลรายละเอียด </p>" data-bs-custom-class="tag-popover" data-bs-content="
			<div class='row d-flex justify-content-between'>
				<div class='col-12 border-top border-light py-2'>
					<span class='fw-semibold me-2'> ผู้สร้าง : </span>
					<span class='float-end'>
						{{ @$data['UserInsert'] }}
					</span>
					<br>
					<span class='fw-semibold me-2'> สาขา : </span>
					<span class='float-end'>
						{{ @$data['UserBranch'] }}
					</span>
				</div>
			</div>">
			{{-- <div class="event-date" data-bs-toggle="tooltip" title="ผู้สร้าง : {{ @$data['UserInsert'] }} ({{ @$data['UserBranch'] }})"> --}}
			<div class="event-date">
				<div class="text-primary mb-1"> {{ formatDateThaiLong(@$data['date_Tag']) }} ({{ @$data['created_at']->format('H:i:s') }}) </div>
				<h5 class="mb-2 text-truncate ">{{ @$data['ConBranchNc'] }} - ({{ @$data['Code_Tag'] }})</h5>
			</div>
			<div class="event-down-icon" id="icon-{{ @$data['id'] }}">
				<span>{{ @$icon_state }}</span>
			</div>
		</label>
		{{-- card-wrapper slide_from_bottom --}}
		<div class="hover-slide">
			<div class="card border border-primary text-start h-100" style="margin-bottom: 0px">
				<input type="hidden" name="id_cardEvent" id="id_cardEvent">

				<div class="card-body">
					<div class="float-end">
						<span class="active_tag">
							@if (@$data['Status_Tag'] == 'active')
								<span class="badge rounded-pill badge-soft-success font-size-11" style="margin-top: 12.5px;">
									<span>กำลังใช้งาน</span>
								</span>
							@endif
						</span>
						<div class="box">
							<div class="ribbon-2 text-light">รายการที่ {{ @$count_card }} &nbsp;</div>
						</div>
						{{-- <span class="badge rounded-pill badge-soft-success font-size-13" id="task-status" data-bs-toggle="tooltip" title="รายละเอียดติดตาม">
							<i class="bx bx-comment-dots bx-tada align-middle me-1"></i><span id="tagpart-{{ @$data['id'] }}">{{ @$data['tagpart'] }}</span>
						</span><br> --}}
					</div>
					<div>
						<h5 class="font-size-13 card-title">
							<a href="javascript: void(0);" class="text-warning">
								สถานะ : <span id="tagstatus-{{ @$data['id'] }}">{{ @$status_card }}</span>
							</a>
						</h5>
						<p class="text-muted mb-2 mt-n1 font-size-12 blockquote-footer text-truncate"><em> {{ @$data['TypeCus'] }} ({{ @$data['ReCus'] }})</em></p>
						<div class="row mt-2">
							<div class="col-12">
								<p class="mb-2">
									<i class="bx bx-home-circle m-0 text-success h5"></i>
									<span class="fw-semibold"> สาขา : </span>
									<span class="float-end">
										@empty(!@$data['ConBranch'])
											{{ @$data['ConBranch'] }}
										@else
											<em class="text-secondary text-opacity-50">-</em>
										@endempty
									</span>
									<br>
									<i class="bx bx-fridge hover-up bg-soft m-0 text-success h5"></i>
									<span class="fw-semibold"> สัญญา : </span>
									<span class="float-end tag03-{{ @$data['id'] }}" id="contract-{{ @$data['id'] }}">
										@empty(!@$data['Contract'])
											<a href="{{ route('contract.edit', @$data['Contract_id']) }}?funs={{ 'contract' }}" target="_blank">{{ @$data['Contract'] }}</a>
										@else
											<em class="text-secondary text-opacity-50">-</em>
										@endempty
									</span>
									<br>
									<i class="mdi mdi-label-variant-outline text-success h5"></i>
									<span class="fw-semibold"> ประเภท : </span>
									<span class="float-end tag03-{{ @$data['id'] }}" id="typecont-{{ @$data['id'] }}">
										@empty(!@$data['LoanName'])
											{{ @$data['LoanName'] }} ({{ @$data['LoanCode'] }})
										@else
											<em class="text-secondary text-opacity-50">-</em>
										@endempty
									</span>
									<br>
									<i class="mdi mdi-clipboard-account-outline m-0 text-success h5"></i>
									<span class="fw-semibold"> ผู้ส่ง : </span>
									<span class="float-end text-truncate tag03-{{ @$data['id'] }}" id="sentcont-{{ @$data['id'] }}">
										@empty(!@$data['UserSent'])
											{{ @$data['UserSent'] }} ({{ implode(', ', @$data['UserPosition']->toArray()) }})
										@else
											<em class="text-secondary text-opacity-50">-</em>
										@endempty
									</span>
								</p>
							</div>
						</div>
					</div>
				</div>
				<div class="card-footer mt-n4" style="padding-bottom: 0px">
					<div class="dropdown float-start me-2">
						<h5 class="font-size-13 card-title">
							<span class="text-warning" id="credoCode-{{ @$data['id'] }}">Credo : {{ @$data['CredoCode'] }}</span>
						</h5>
						<p class="text-muted mb-2 font-size-12 mt-n1 blockquote-footer">
							<em id="credoStat-{{ @$data['id'] }}">
								@if (@$data['CredoStat'])
									{{ @$data['CredoStat'] }}
								@else
									<span class="text-secondary text-opacity-50">ไม่พบข้อมูล</span>
								@endif
							</em>
						</p>
					</div>
					<div class="dropdown float-end mt-1">
						<button type="button" id="{{ @$data['id'] }}" class="rounded-circle btn-sm btn btn-danger hover-up search-credo" data-PhoneNumber="{{ @$data['PhoneNumber'] }}" data-credoScore="{{ @$data['CredoScore'] }}" data-bs-toggle="tooltip" title="เชื่อมต่อ credo">
							<i class="mdi mdi-cellphone-nfc m-0 font-size-15"></i>
						</button>
					</div>
				</div>
			</div>
			<div class="mt-1">
				<div class="float-start rounded prem" data-bs-toggle="tooltip" title="ส่งมอบ : {{ @$data['successor'] }}" data-bs-placement="bottom">
					<button type="button" class="btn btn-soft-danger waves-effect waves-light successor-{{ @$data['id'] }}" style="display: {{ !empty(@$data['successor']) && @$data['successorStatus'] == 'active' ? '' : 'none' }}">
						<i class="mdi mdi-account-tie-voice-outline align-middle font-size-15"></i>
					</button>
				</div>

				<div class="float-end rounded" data-bs-toggle="tooltip" title="คำนวณยอดจัด" data-bs-placement="bottom">
					<button id="btn_cal-{{ @$data['id'] }}" type="button" class="btn btn-outline-warning waves-effect waves-light btn-calculate" data-credoScore="{{ @$data['CredoScore'] }}" data-link="{{ route('ControlCenter.create') }}?funs={{ 'calculates' }}&zone={{ auth()->user()->zone }}&id={{ @$data['id'] }}">
						<i class="bx bx-calculator align-middle font-size-16"></i>
					</button>
				</div>
				<div class="float-end rounded me-1" data-bs-toggle="tooltip" title="รายละเอียดติดตาม" data-bs-placement="bottom">
					<button id="task-status" type="button" class="btn btn-outline-warning waves-light position-relative card-event" data-id="{{ @$data['id'] }}">
						<i class="bx bx-comment-dots align-middle font-size-16"></i>
						<span id="tagpart-{{ @$data['id'] }}" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success">
							{{ @$data['tagpart'] }}
						</span>
					</button>
				</div>
				<div class="float-end rounded me-1 " data-bs-toggle="tooltip" title="เพิ่มเติม" data-bs-placement="bottom">
					<div class="dropdown dropdown-menu-end">
						<a href="#" class="dropdown-toggle arrow-none btn btn-outline-warning waves-effect waves-light" data-bs-toggle="dropdown" aria-expanded="false">
							<i class="bx bx-list-ul align-middle font-size-16"></i>
						</a>
						<div class="dropdown-menu">
							<a role="button" id="sentGM_{{ @$data['id'] }}" class="dropdown-item d-flex justify-content-between pe-auto btn-sentGM {{ (!empty(@$data['successorStatus']) and @$data['successorStatus'] == 'active') ? 'd-none' : '' }}" data-id="{{ @$data['id'] }}" data-tag="{{ @$data['Code_Tag'] }}" data-bs-toggle="modal" data-bs-target=".form-SentGM">
								ส่งมอบ GM <i class="mdi mdi-account-switch fs-5 text-primary"></i>
							</a>
							<a role="button" id="sentBranch_{{ @$data['id'] }}" class="dropdown-item d-flex justify-content-between pe-auto btn-sentBranch {{ @$data['successorStatus'] == 'active' ? '' : 'd-none' }}" data-id="{{ @$data['id'] }}" data-tag="{{ @$data['Code_Tag'] }}" data-user="{{ @$data['successor_id'] }}">
								ส่งคืนสาขา <i class="bx bx-home-circle fs-5 text-primary"></i>
							</a>
							@can('edit-tag')
								<a role="button" class="dropdown-item d-flex justify-content-between pe-auto {{ @$data['Status_Tag'] != 'inactive' ? 'data-modal-xl-2' : '' }}" data-link="{{ route('tags.edit', @$data['id']) }}?funs={{ 'edit-tag' }}">
									แก้ไขรายการ <i class="bx bx-edit-alt fs-5 text-warning"></i>
								</a>
							@endcan
							<a class="dropdown-item d-flex justify-content-between pe-auto" href="{{ route('report.create') }}?type=Quatation&id={{ @$data['id'] }}" target="_blank">
								พิมพ์ใบเสนอ <i class="bx bxs-printer fs-5 text-info"></i>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
