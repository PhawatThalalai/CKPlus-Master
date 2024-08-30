<div class="card task-box border border-primary h-100" id="cmptask-1" style="width:350px;">
	<div class="card-body">
		<div class="dropdown float-end me-2">
			<a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
				<i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
			</a>
			<div class="dropdown-menu dropdown-menu-end">
				<a id="edit-about-cus" class="dropdown-item edittask-details data-modal-xl-2" data-link="{{ route('cus.edit', @$data['DataCus_id'] != null ? @$data['DataCus_id'] : 0) }}?type={{ @$type }}&id={{ @$data['id'] }}">แก้ไข</a>
			</div>
		</div>
		<div class="float-end">
			<span class="badge rounded-pill {{ @$data['Status_Adds'] == 'active' ? 'badge-soft-success' : 'badge-soft-dark' }}  font-size-12" id="task-status">{{ @$data['Status_Adds'] == 'active' ? 'กำลังใช้งาน' : 'ปิดใช้งาน' }}</span>
			<br>
		</div>
		<div>
			<h5 class="font-size-14 card-title"><a href="javascript: void(0);" class="text-warning" id="task-name">{{ @$data->DataCusAddsToTypeAdds->Name_Address }}</a>
				@if (@$data['Main'] == 'yes' || @$data['Type_Adds'] == 'ADR-0002')
					<span class="badge rounded-circle text-bg-primary"><i class="bx bx-check fs-7 fw-semibold"></i></span>
				@endif
			</h5>
			<h5 class="text-muted mt-n1 mb-2 blockquote-footer font-size-11"><em> {{ @$data['Code_Adds'] }} </em></h5>
			<div class="row mt-3">
				<div class="col">
					<p class="fw-semibold text-truncate">
						<i class="bx bx-detail m-0 text-success h5"></i> : {{ @$data['houseTambon_Adds'] }}<br>
						<i class="bx bx-bookmark m-0 text-success h5"></i> : {{ @$data['houseDistrict_Adds'] }}<br>
						<i class="bx bx-spreadsheet m-0 text-success h5"></i> : {{ @$data['houseProvince_Adds'] }}
					</p>
				</div>
				<div class="col text-end me-2 m-auto">
					<img src="{{ asset('assets/images/home-address.png') }}" alt="" width="70px;">
				</div>
			</div>
		</div>
	</div>
	<div class="card-footer">
		<small class="text-muted fs-6">
			{{ @$data->created_at->DiffForHumans() }}
		</small>
	</div>
</div>
