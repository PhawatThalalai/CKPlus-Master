<div class="card task-box border border-primary border-2 border-opacity-50  {{ @$extraClass }}" id="cmptask-1" style="width:350px;">
    <div class="card-header bg-info bg-soft">
        <div class="row">
            <div class="col-10">
                <h6 class="text-primary fw-semibold"> <i class="bx bx-purchase-tag"></i> {{ @$data['code'] }}</h6>
            </div>
            <div class="col-2 text-end">
                <div class="dropdown float-end me-2">
                    <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end">
                        <span tabindex="0" role="menuitem" class="text-primary text-center dropdown-item" disabled>รายการ</span>
                        <div tabindex="-1" class="dropdown-divider"></div>
                        <a id="edit-about-cus" class="dropdown-item d-flex justify-content-between pe-auto edittask-details data-modal-xl" data-link="{{ route('cus.edit', @$data['id'] ) }}?funs={{ @$funs }}">แก้ไข <i class="bx bx-edit-alt fs-4 text-warning"></i></a>
                        <a id="edit-about-cus" class="dropdown-item d-flex justify-content-between pe-auto edittask-details data-modal-xl" data-link="{{ route('cus.show', @$data['id'] ) }}?funs={{ @$funs }}">ดูข้อมูล <i class="bx bx-show-alt fs-4 text-primary"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<div class="card-body">
			<div class="row">
				<div class="col">
                    <a href="javascript: void(0);" class="text-warning fs-6 fw-semibold" id="task-name" title="{{ @$data['title'] }}">{{ Str::limit(@$data['title'],25) }} <i class="bx bxs-check-circle text-primary {{@$data['title'] == 'ที่อยู่ส่งเอกสาร' ? '' : 'd-none'}}"></i> </a>
					<p class="fw-semibold text-truncate">
						<i class="bx bx-detail m-0 text-success h5"></i> : {{ Str::limit(@$data['data1'],25) }}<br>
						<i class="bx bx-bookmark m-0 text-success h5"></i> : {{ Str::limit(@$data['data2'],25) }}<br>
						<i class="bx bx-spreadsheet m-0 text-success h5"></i> : {{ Str::limit(@$data['data3'],25) }}
					</p>
				</div>
				<div class="col-3 text-end me-2 m-auto">
					<img src="{{ @$data['img'] }}" alt="" width="80px;">
                    <div class="col-12 text-end mt-1">
                        <span class="badge rounded-pill {{ @$data['Status'] == 'กำลังใช้งาน' ? 'badge-soft-success' : 'badge-soft-dark' }}  font-size-12" id="task-status">{{ @$data['Status'] }}</span>
                    </div>
				</div>
			</div>
	</div>
	<div class="card-footer">
		<small class="text-muted fs-6">
            <div class="row d-flex align-items-center">
                <div class="col-6" title="{{ @$data['data4'] }}">
                    <i class="bx bxs-time-five fs-5"></i> {{ @$data['data4'] }}
                </div>
                <div class="col-6 text-end" title="{{ @$data['UserInsert'] }}">
                   <p class="text-muted mb-0 text-truncate"><i class="bx bxs-user-circle"></i> {{ @$data['UserInsert'] }}</p>
                </div>
            </div>

		</small>
	</div>
</div>


