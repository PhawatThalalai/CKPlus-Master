<h6 class="font-size-15 mb-1 fw-semibold text-primary mt-1"><i class="mdi mdi-file-edit"></i> รายการตรวจสอบ ( List Documents )</h6>
<form id="listCheck">
	<div class="table-responsive h-100" data-simplebar="init" style="max-height: 550px;  min-height : 550px;">
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
								<input class="form-check-input list-checkdoc check-edit" type="radio" name="listRadios-{{ $list->code }}" value="{{ $list->id }}" {{ (preg_match("/\b$list->id\b/", @$audit->auditTagToChecklist->check_edit))?'checked' : ''}}>
							</div>
						</td>
						<td class="">
							<div class="form-check form-radio form-radio-success d-flex justify-content-center">
								<input class="form-check-input list-checkdoc check-edited" type="radio" name="listRadios-{{ $list->code }}" value="{{ $list->id }}" {{ (preg_match("/\b$list->id\b/", @$audit->auditTagToChecklist->check_edited))?'checked' : ''}}>
							</div>
						</td>						
						<td>
							<div class="form-check form-radio form-radio-success d-flex justify-content-center">
								<input class="form-check-input list-checkdoc check-complete" type="radio" name="listRadios-{{ $list->code }}" value="{{ $list->id }}" {{ (preg_match("/\b$list->id\b/", @$audit->auditTagToChecklist->check_complete))?'checked' : ''}}>
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</form>
