<div wire:ignore.self class="modal fade create-group" tabindex="-1" aria-labelledby="myLargeModalLabel" style="display: none;" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content" wire:emit="resetForm">
			<div class="modal-header">
				<h5 class="modal-title" id="myLargeModalLabel">Large modal</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form id="formCreateTask" wire:submit.prevent='storeTask' role="form" novalidate="novalidate">
				<div class="modal-body">
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
							<div class="position-relative" id="search_box">
								<input wire:model.defer="taskDate" type="text" class="form-control rounded-0 rounded-start validate @error('taskDate') is-invalid @enderror" value="{{ date('d-m-Y') }}" placeholder="Enter Task Date" autocomplete="off" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#search_box" data-date-format="dd-mm-yyyy" data-date-language="th" data-date-today-highlight="true" data-date-enable-on-readonly="true" readonly required>
								@error('taskDate')
									<span class="error">{{ $message }}</span>
								@enderror
							</div>
						</div>
					</div>

					<div class="form-group mb-2">
						<label for="taskType" class="col-form-label fw-semibold">ประเภท<span class="text-danger"> *</span></label>
						<div class="col-lg-12">
							<select wire:model.defer="taskType" id="taskType" class="form-select select2 lw-select2 border-warning @error('taskType') is-invalid @enderror" data-placeholder="เลือกสาขาที่ต้องการ" multiple required>
								@isset($dataTypeGroup)
									@foreach ($dataTypeGroup as $TypeGroup)
										<option value="{{ $TypeGroup->id }}">{{ $TypeGroup->TypeGroup_Name }}</option>
									@endforeach
								@endisset
							</select>
						</div>
					</div>

					<div class="form-group mb-2">
						<label class="col-form-label fw-semibold">ผู้ดูแลกลุ่ม<span class="text-danger"> (ถ้ามี)</span></label>
						<div class="col-lg-12">
							<select wire:model.defer="taskHandler" class="form-select validate @error('taskHandler') is-invalid @enderror" id="TaskStatus">
								<option value="" selected>--- ผู้ดูแลกลุ่ม ---</option>
								@isset($userHandler)
									@foreach (@$userHandler as $user)
										<option value="{{ $user->id }}">{{ $user->name }} - ({{ $user->getRoleNames()->implode(', ') }})</option>
									@endforeach
								@endisset
							</select>
							@error('taskHandler')
								<span class="error">{{ $message }}</span>
							@enderror
						</div>
					</div>

					<div class="form-group mb-2">
						<label for="taskname" class="col-form-label fw-semibold">สาขา
							<span class="text-danger"> *</span>
							<span class="text-danger">
								@isset($txtCountBranch)
									( {{ $txtCountBranch }} selected)
								@endisset
							</span>
						</label>
						<div class="col-lg-12">
							<select wire:model.defer="taskBranch" id="taskBranch" class="form-select select2 taskBranch-select2 border-warning" data-placeholder="เลือกสาขาที่ต้องการ" multiple required>
								@isset($dataBranch)
									@foreach (@$dataBranch as $branch)
										<option value="{{ $branch->id }}">{{ $branch->NickName_Branch }} - {{ $branch->Name_Branch }}</option>
									@endforeach
								@endisset
							</select>
							@error('taskBranch')
								<span class="error">{{ $message }}</span>
							@enderror
						</div>
					</div>

					<div class="form-group mb-2">
						<label class="col-form-label fw-semibold">รายละเอียด</label>
						<div class="col-lg-12">
							<textarea wire:model.defer="taskdesc" id="taskdesc" class="form-control"></textarea>
						</div>
					</div>
				</div>

				<div class="modal-footer">
					<button type="submit" id="createTask" class="btn btn-primary btn-sm waves-effect waves-light hover-up">
						<span class="addSpin"><i class="fas fa-download"></i></span> บันทึก
					</button>
					<button type="button" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">
						<i class="mdi mdi-close-circle-outline"></i> ปิด
					</button>
				</div>
			</form>
		</div>
	</div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->

<link href="{{ URL::asset('/assets/css/select2-custom.css') }}" rel="stylesheet" type="text/css" />

@push('scripts')
	<script>
		document.addEventListener('livewire:load', function() {
			Livewire.hook('message.processed', (message, component) => {
				initSelect2();

				// $('.create-group .modal-content .taskBranch').on('change', function() {
				// 	@this.countSelectedBranch();
				// });
			});
		});

		document.addEventListener('livewire:load', function() {
			$('#datepicker6').datepicker({
				format: 'dd-mm-yyyy',
				autoclose: true,
			}).on('changeDate', function(e) {
				@this.set('taskDate', e.format());
			});

			Livewire.on('resetForm', function() {
				$('#datepicker6').datepicker('clearDates');
				$('#taskType').val(null).trigger('change');
			});
		});

		window.addEventListener('closeModalFormCreate', event => {
			$('.create-group').modal('hide');
			// alert('Name updated to: ' + event.detail.massages);
			$(".toast-success").toast({
				delay: 1500
			}).toast("show");
			$(".toast-success .toast-body .text-body").text(event.detail.massages);
		})
	</script>

	<script>
		function initSelect2() {
			$('.lw-select2').select2({
					theme: "bootstrap-5",
					language: "th",
					width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
					placeholder: $(this).data('placeholder'),
					allowClear: true,
					dropdownParent: $('.create-group .modal-content'),

					// กำหนดขนาดข้อความในตัวเลือก
					templateResult: function(state) {
						if (!state.id) {
							return state.text;
						}
						return $('<span>' + state.text + '</span>').css('font-size', '12px'); // ตัวอย่าง: กำหนดขนาดเป็น 16px
					},
					templateSelection: function(state) {
						if (!state.id) {
							return state.text;
						}
						return $('<span>' + state.text + '</span>').css('font-size', '12px'); // ตัวอย่าง: กำหนดขนาดเป็น 16px
					}
				})
				.on('change', function(e) {
					@this.set('taskType', $(this).val());
				});

			$('.taskBranch-select2').select2({
					theme: "bootstrap-5",
					language: "th",
					width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
					placeholder: $(this).data('placeholder'),
					allowClear: true,
					dropdownParent: $('.create-group .modal-content'),

					// กำหนดขนาดข้อความในตัวเลือก
					templateResult: function(state) {
						if (!state.id) {
							return state.text;
						}
						return $('<span>' + state.text + '</span>').css('font-size', '12px'); // ตัวอย่าง: กำหนดขนาดเป็น 16px
					},
					templateSelection: function(state) {
						if (!state.id) {
							return state.text;
						}
						return $('<span>' + state.text + '</span>').css('font-size', '12px'); // ตัวอย่าง: กำหนดขนาดเป็น 16px
					}
				})
				.on('change', function(e) {
					@this.set('taskBranch', $(this).val());
				});
		}
	</script>
@endpush
