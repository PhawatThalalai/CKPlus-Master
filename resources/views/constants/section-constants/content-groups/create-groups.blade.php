<style>
	.selected {
		background-color: #fbd7d7;
	}
</style>
<div class="modal-content" wire:emit="resetForm">
	<div class="modal-header">
		<h5 class="modal-title d-flex align-items-center"><i class="mdi mdi-account-group me-2 font-size-22 text-info"></i> Create Groups</h5>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>
	<form id="formCreateTask" role="form" novalidate="novalidate">
		<div class="modal-body pt-0">
			<div class="row">
				<div class="col">
					<div class="form-group mb-1">
						<label for="taskname" class="col-form-label fw-semibold">ชื่อกลุ่ม<span class="text-danger"> *</span></label>
						<div class="col-lg-12">
							<input name="taskName" type="text" class="form-control" placeholder="Enter Task Name..." required>
						</div>
					</div>
				</div>
				<div class="col">
					<div class="form-group mb-1">
						<label for="taskDate" class="col-form-label fw-semibold">วันที่<span class="text-danger"> *</span></label>
						<div class="col-lg-12">
							<div class="position-relative" id="search_box">
								<input name="taskDate" type="text" class="form-control rounded-0 rounded-start text-center" value="{{ date('d-m-Y') }}" placeholder="Enter Task Date" autocomplete="off" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#search_box" data-date-format="dd-mm-yyyy" data-date-language="th" data-date-today-highlight="true" data-date-enable-on-readonly="true" readonly required>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="form-group mb-1">
				<label for="taskType" class="col-form-label fw-semibold">ประเภท<span class="text-danger"> *</span></label>
				<div class="col-lg-12 cl-select2">
					<div class="input-group">
						<select name="taskType[]" id="taskType" class="form-control form-select select2 taskType-select2 validate is-invalid" data-placeholder="เลือกประเภทที่ต้องการ" required multiple>
							@isset($dataTypeGroup)
								@foreach ($dataTypeGroup as $TypeGroup)
									<option value="{{ $TypeGroup->id }}">{{ $TypeGroup->TypeGroup_Name }}</option>
								@endforeach
							@endisset
						</select>
						<button id="PassIdCard" class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled bg-success text-white" style="opacity:1; display: none">
							<i class="fa fa-check"></i>
						</button>
						<button id="FailIdCard" class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled bg-danger text-white rounded-2" style="opacity:1; display: none">
							<i class="fa fa-times"></i>
						</button>
					</div>
				</div>
			</div>

			<div class="form-group mb-1">
				<label class="col-form-label fw-semibold">ผู้ดูแลกลุ่ม<span class="text-danger"> (ถ้ามี)</span></label>
				<div class="col-lg-12">
					<select name="taskHandler[]" id="taskHandler" class="form-select select2 taskHandler-select2" data-placeholder="ผู้ดูแลกลุ่ม" multiple>
						@isset($userHandler)
							@foreach (@$userHandler as $user)
								<option value="{{ $user->id }}">{{ $user->name }} - ({{ $user->getRoleNames()->implode(', ') }})</option>
							@endforeach
						@endisset
					</select>
				</div>
			</div>

			<div class="form-group mb-1">
				<label for="taskname" class="col-form-label fw-semibold">สาขา
					<span class="text-danger"> *</span>
					<div class="d-flex mb-1">
						<div class="form-check me-3">
							<input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="BRANCH">
							<label class="form-check-label" for="flexRadioDefault1">
								ข้อมูลสาขา (BRANCH)
							</label>
						</div>
						<div class="form-check">
							<input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="BILLCOLLS">
							<label class="form-check-label" for="flexRadioDefault2">
								ข้อมูลสาขาตาม BILLCOLLS
							</label>
						</div>
					</div>
					<span class="text-danger">
						@isset($txtCountBranch)
							( {{ $txtCountBranch }} selected)
						@endisset
					</span>
				</label>
				<div class="col-lg-12 div-taskBranch" style="display: none;">
					<select name="taskBranch[]" id="taskBranch" class="form-select select2 taskBranch-select2" data-placeholder="เลือกสาขาที่ต้องการ" multiple>
						@isset($dataBranch)
							@foreach (@$dataBranch as $branch)
								<option value="{{ $branch->id }}">{{ $branch->NickName_Branch }} - {{ $branch->Name_Branch }}</option>
							@endforeach
						@endisset
					</select>
				</div>
				{{-- <div class="col-lg-12 div-taskbillcoll" style="display: none;">
					<select name="taskbillcoll[]" id="taskbillcoll" class="form-select select2 taskbillcoll-select2" data-placeholder="เลือก billcoll ที่ต้องการ" multiple required>
						@isset($dataBILLCOLL)
							@foreach (@$dataBILLCOLL as $BILLCOLL)
								<option value="{{ $BILLCOLL->id }}">{{ $BILLCOLL->code_billcoll }} - {{ $BILLCOLL->name_billcoll }}</option>
							@endforeach
						@endisset
					</select>
				</div> --}}
			</div>

			<div class="row div-taskbillcoll" style="display: none;">
				<div class="col-xl-6 col-lg-6 col-sm-12">
					<select id="select_billcoll" class="form-select select2 province-license-select license-input" data-placeholder="เลือก billcoll ที่ต้องการ" data-namealert="billcoll">
						<option value="" selected>--- เลือก billcoll ---</option>
						@foreach ($dataBILLCOLL as $BILLCOLL)
							<option value="{{ $BILLCOLL->id }}">{{ $BILLCOLL->code_billcoll }} - {{ $BILLCOLL->name_billcoll }}</option>
						@endforeach
					</select>
					<div class="table-responsive font-size-11" data-simplebar="init" style="max-height: 355px;">
						<table class="table table-bordered table-sm mb-0 text text-nowrap" style="font-size: 12px;">
							<tbody id="tbPaydue">
								<!-- Rows will be rendered here -->
							</tbody>
							<tfoot>
								<tr>
									<td colspan="2" class="text-center fw-semibold text-danger" id="rowCount">จำนวนรายการ: 0</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
				<div class="col-xl-6 col-lg-6 col-sm-12">
					<div class="avatar-title bg-transparent border border-danger text-center rounded">
						<code>.border-danger</code>
					</div>
				</div>
			</div>

			<div class="form-group mb-2">
				<label class="col-form-label fw-semibold">รายละเอียด</label>
				<div class="col-lg-12">
					<textarea name="taskdesc" id="taskdesc" class="form-control"></textarea>
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

<link href="{{ URL::asset('/assets/css/select2-custom.css') }}" rel="stylesheet" type="text/css" />

<script>
	$(document).ready(function() {
		var selectedValues = {}; // Object to store selected values

		function updateRowCount() {
			var rowCount = $('#tbPaydue tr.data-tbPaydue').length;
			$('#rowCount').text('จำนวนรายการ: ' + rowCount);
		}

		function updateTaskbillcoll() {
			$('#taskbillcoll').val(Object.values(selectedValues));
		}

		$('#select_billcoll').change(function() {
			var selectedOption = $(this).find('option:selected');
			var billcollId = selectedOption.val();
			var billcollText = selectedOption.text();

			if (billcollId && !selectedValues[billcollId]) {
				// Add the selected value to the object
				selectedValues[billcollId] = billcollId;

				// Render the selected value into tbPaydue
				var newRow = '<tr class="data-tbPaydue" data-id="' + billcollId +
					'"><td scope="row" class="bg-soft text-center">' + billcollText +
					'</td><td class="text-center"><button role="button" class="btn btn-danger btn-sm delete-row" data-id="' + billcollId +
					'">ลบ</button></td></tr>';

				$('#tbPaydue').append(newRow);

				// Update taskbillcoll input field value
				updateTaskbillcoll();
				// Update row count
				updateRowCount();

				// Clear the selected option
				$(this).val('').trigger('change');
			} else if (selectedValues[billcollId]) {
				console.log("Value already selected: ", billcollId); // Debugging
			} else {
				console.log("No option selected"); // Debugging
			}
		});

		// Event delegation for dynamically added delete buttons
		$('#tbPaydue').on('click', '.delete-row', function() {
			var billcollId = $(this).data('id');
			delete selectedValues[billcollId];
			$(this).closest('tr').remove(); // Remove the row from the table

			// Update taskbillcoll input field value
			updateTaskbillcoll();
			// Update row count
			updateRowCount();
		});

		// Event delegation for changing row color on click
		$('#tbPaydue').on('click', 'tr.data-tbPaydue', function() {
			$('#tbPaydue tr.data-tbPaydue').removeClass('selected');
			$(this).addClass('selected');
		});

		$("#createTask").click(function(e) {
			e.preventDefault();
			let dataform = document.querySelectorAll('#formCreateTask');
			let validate = validateForms(dataform);

			if (validate) {
				let data = {};
				data['taskType'] = $("#taskType").val();
				data['taskType'] = Array.isArray(data['taskType']) ? data['taskType'] : [data['taskType']];

				data['taskHandler'] = $("#taskHandler").val();
				data['taskHandler'] = Array.isArray(data['taskHandler']) ? data['taskHandler'] : [data['taskHandler']];

				data['taskBranch'] = $("#taskBranch").val();
				data['taskBranch'] = Array.isArray(data['taskBranch']) ? data['taskBranch'] : [data['taskBranch']];

				data['taskbillcoll'] = $("#taskbillcoll").val();
				data['taskbillcoll'] = Object.values(selectedValues);
				// data['taskbillcoll'] = Array.isArray(data['taskbillcoll']) ? data['taskbillcoll'] : [data['taskbillcoll']];

				$("#formCreateTask").serializeArray().map(function(x) {
					if (x.name !== 'taskType[]' && x.name !== 'taskBranch[]' && x.name !== 'taskbillcoll[]' && x.name !== 'taskHandler[]') {
						data[x.name] = x.value;
					}
				});

				$.ajax({
					url: "{{ route('dataStatic.store') }}",
					method: 'post',
					data: {
						_token: "{{ @csrf_token() }}",
						store: 'data-groups',
						data: data
					},
					success: function(response) {
						$('.content-page').html(response.html);
						$('#modal_lg').modal('hide');

						$(".toast-success").toast({
							delay: 1500
						}).toast("show");
						$(".toast-success .toast-body .text-body").text('Successful');
					},
					error: function(response) {

					}
				});
			}
		});

		// Initial row count
		updateRowCount();
	});
</script>

<script>
	$(document).ready(function() {
		initSelect2();
	});

	$('input[type=radio][name=flexRadioDefault]').change(function() {
		if (this.id == 'flexRadioDefault1') {
			$('.div-taskBranch').show();
			$('.div-taskbillcoll').hide();
			$('#taskBranch').attr('required', true); // เพิ่ม required
			$('#taskbillcoll').removeAttr('required'); // ลบ required
		} else if (this.id == 'flexRadioDefault2') {
			$('.div-taskbillcoll').show();
			$('.div-taskBranch').hide();
			$('#taskbillcoll').attr('required', true); // เพิ่ม required
			$('#taskBranch').removeAttr('required'); // ลบ required
		}
	});
</script>

<script>
	function initSelect2() {
		$('.select2').select2({
			theme: "bootstrap-5",
			language: "th",
			width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
			placeholder: $(this).data('placeholder'),
			allowClear: true,
			dropdownParent: $('#modal_lg .modal-content'),

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
		});
	}
</script>
