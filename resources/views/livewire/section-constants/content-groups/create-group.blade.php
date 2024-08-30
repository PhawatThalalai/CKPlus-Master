<div wire:ignore.self class="modal fade create-group" tabindex="-1" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" wire:emit="resetForm">
			<div class="modal-header">
				<h5 class="modal-title" id="myLargeModalLabel">Large modal</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="formCreateTask" role="form" novalidate="novalidate">
					<div class="form-group mb-2">
						<label for="taskname" class="col-form-label fw-semibold">ชื่อกลุ่ม<span class="text-danger"> *</span></label>
						<div class="col-lg-12">
							<input wire:model.defer="taskName" type="text" class="form-control validate @error('taskName') is-invalid @enderror" placeholder="Enter Task Name..." required>
							@error('taskName')
								<span class="error">{{ $message }}</span>
							@enderror
						</div>
					</div>
					<div class="form-group mb-2">
						<label for="taskDate" class="col-form-label fw-semibold">วันที่<span class="text-danger"> *</span></label>
						<div class="col-lg-12">
							<input wire:model.defer="taskDate" type="date" class="form-control validate @error('taskDate') is-invalid @enderror" placeholder="Enter Task Date..." required>
							@error('taskDate')
								<span class="error">{{ $message }}</span>
							@enderror
						</div>
					</div>
					<div class="form-group mb-2">
						<label class="col-form-label fw-semibold">ผู้ดูแลกลุ่ม<span class="text-danger"> *</span></label>
						<div class="col-lg-12">
							<select wire:model.defer="taskHandler" class="form-select validate @error('taskHandler') is-invalid @enderror" id="TaskStatus" required>
								<option value="" selected="">Choose..</option>
								<option value="Waiting">Waiting</option>
								<option value="Approved">Approved</option>
								<option value="Pending">Pending</option>
								<option value="Complete">Complete</option>
							</select>
							@error('taskHandler')
								<span class="error">{{ $message }}</span>
							@enderror
						</div>
					</div>

					<div class="form-group mb-2">
						<label for="taskname" class="col-form-label fw-semibold">สาขา<span class="text-danger"> *</span></label>
						<div class="col-lg-12">
							<select wire:model.defer="taskBranch" class="form-select @error('taskBranch') is-invalid @enderror" multiple aria-label="Multiple select example" required>
								@foreach ($dataBranch as $branch)
									<option value="{{ $branch->id }}">{{ $branch->NickName_Branch }} - {{ $branch->Name_Branch }}</option>
								@endforeach
							</select>
							@error('taskBranch')
								<span class="error">{{ $message }}</span>
							@enderror
						</div>
					</div>

					<div>
						<select class="form-select select2 billcoll-select border-warning" data-placeholder="เลือกสาขาที่ต้องการ" data-bs-toggle="tooltip" title="แบ่งงานให้สาขา">
							<option value="AL">Alabama</option>
							<option value="WY">Wyoming</option>
						</select>
					</div>

					<div class="form-group mb-2">
						<label class="col-form-label fw-semibold">รายละเอียด</label>
						<div class="col-lg-12">
							<textarea wire:model.defer="taskdesc" id="taskdesc" class="form-control"></textarea>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" id="createTask" wire:click="storeTask" class="btn btn-primary btn-sm waves-effect waves-light hover-up">
					<span class="addSpin"><i class="fas fa-download"></i></span> บันทึก
				</button>
				<button type="button" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">
					<i class="mdi mdi-close-circle-outline"></i> ปิด
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

@push('styles')
	<link href="{{ URL::asset('/assets/css/select2-custom.css') }}" rel="stylesheet" type="text/css" />
@endpush

@push('scripts')
	<script>
		$('.billcoll-select').select2({
			theme: "bootstrap-5",
			language: "th",
			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
			placeholder: $(this).data('placeholder'),
			allowClear: true,
			dropdownParent: $('.create-group .modal-content'),
		});
	</script>
@endpush
