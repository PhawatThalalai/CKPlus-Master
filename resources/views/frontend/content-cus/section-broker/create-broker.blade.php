spanspanspan<form name="form_createBroker" id="form_createBroker" class="needs-validation" action="#" novalidate>
	@csrf

	<input type="hidden" name="cus_id" id="cus_id" value={{ @$data->id }}>
	<input type="hidden" name="broker_id" id="broker_id" value={{ @$data->DataCusToBroker->id }}>

	<input type="hidden" id="IDCard_cus" value={{ @$data->IDCard_cus }}>
	<input type="hidden" id="Name_Account" value={{ @$data->Name_Account }}>
	<input type="hidden" id="Number_Account" value={{ @$data->Number_Account }}>

	<div class="row mb-1">
		<div class="col-xl-6 col-lg-12">
			<div class="input-bx">
				<select class="form-select text-dark" id="status_Broker" name="status_Broker" data-toggle="tooltip" title="สถานะนายหน้า" required>
					<option value="" selected>-- สถานะนายหน้า --</option>
					<option value="active" {{ @$data->DataCusToBroker->status_Broker == 'active' ? 'selected' : '' }}>ปกติ</option>
					<option value="cancel" {{ @$data->DataCusToBroker->status_Broker == 'cancel' ? 'selected' : '' }}>ยกเลิก</option>
					<option value="backlist" {{ @$data->DataCusToBroker->status_Broker == 'backlist' ? 'selected' : '' }}>backlist</option>
				</select>
				<span class="text-danger">สถานะนายหน้า</span>
			</div>
		</div>

		<div class="col-xl-6 col-lg-12">
			<div class="input-bx">
				<select class="form-select text-dark" id="type_Broker" name="type_Broker" data-toggle="tooltip" title="ประเภทผู้แนะนำ" required>
					<option value="" selected>-- ประเภทผู้แนะนำ --</option>
					@foreach ($typeBroker as $value)
						<option value="{{ $value->id }}" {{ $value->id == @$data->DataCusToBroker->type_Broker ? 'selected' : '' }}>{{ $value->Name_typeBroker }}</option>
					@endforeach
				</select>
				<span class="text-danger">ประเภทผู้แนะนำ</span>
			</div>
		</div>
	</div>
	<div class="row mb-1">
		<div class="col-xl-6 col-lg-12">
			<div class="input-bx">
				<input type="text" name="nickname_Broker" id="nickname_Broker" value="{{ @$data->DataCusToBroker->nickname_Broker }}" class="form-control" data-bs-toggle="tooltip" title="ชื่อเล่น / ฉายา" placeholder=" " autocomplete="off" required />
				<span class="text-danger">ชื่อเล่น / ฉายา</span>
			</div>
		</div>
		<div class="col-xl-6 col-lg-12">
			<div class="input-bx">
				<input type="text" name="location_Broker" id="location_Broker" value="{{ @$data->DataCusToBroker->location_Broker }}" class="form-control" data-bs-toggle="tooltip" title="สถานที่ตั้ง" placeholder=" " autocomplete="off" required />
				<span class="text-danger">สถานที่ตั้ง</span>
			</div>
		</div>
	</div>
	<div class="row mb-1">
		<div class="col-xl-12 col-lg-12">
			<div class="input-bx">
				<input type="text" name="Link_Broker" id="Link_Broker" value="{{ @$data->DataCusToBroker->Link_Broker }}" class="form-control" data-bs-toggle="tooltip" title="อัลบั้มนายหน้า" placeholder=" " autocomplete="off" required />
				<span class="text-danger">อัลบั้มนายหน้า</span>
				<a target="_blank" class="btn btn-light rounded-end d-flex align-items-center">
					<i class="fas fa-link text-primary"></i>
				</a>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="form-floating">
				<textarea name="note_Broker" id="note_Broker" class="form-control" placeholder="Leave a comment here" maxlength="65535" style="height: 100px">{{ @$data->DataCusToBroker->note_Broker }}</textarea>
				<label for="note_Broker" class="fw-bold">หมายเหตุ</label>
			</div>
		</div>
	</div>
</form>
