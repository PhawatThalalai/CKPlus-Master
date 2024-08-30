
<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>
<script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
<style>

	/* ทำให้ form-floating มีขนาดเล็กลง */
	.form-floating > .form-select {
		/* padding-top: 1.625rem;
		padding-bottom: 0.625rem;*/
		padding-top: 1rem;
		padding-bottom: 0.625rem;
	}

	.form-floating > .form-control:focus, .form-floating > .form-control:not(:placeholder-shown), .form-floating > .form-control-plaintext:focus, .form-floating > .form-control-plaintext:not(:placeholder-shown) {
		/* padding-top: 1.625rem;
		padding-bottom: 0.625rem; */
		padding-top: 1rem;
		padding-bottom: 0.5rem;
	}

	.form-floating > .form-control, .form-floating > .form-control-plaintext {
		/* padding: 1rem 0.75rem; */
		padding: 1rem 0.75rem;
	}

	.form-floating > .form-control, .form-floating > .form-control-plaintext, .form-floating > .form-select {
		/* height: calc(3.5rem + 2px);
		line-height: 1.25; */
		height: calc(2.5rem + 2px);
		line-height: 1.25;
	}

	.form-floating > label {
		/* padding: 1rem 0.75rem; */
		padding: 0.8rem 0.6rem;
	}

	.form-floating > .form-control:focus ~ label, .form-floating > .form-control:not(:placeholder-shown) ~ label, .form-floating > .form-control-plaintext ~ label, .form-floating > .form-select ~ label {
		/* -webkit-transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
		transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem); */
		-webkit-transform: scale(0.85) translateY(-0.775rem) translateX(0.15rem);
		transform: scale(0.85) translateY(-0.775rem) translateX(0.15rem);
	}

</style>
@include('frontend.content-cus.section-carreer.script-career')
<div class="modal-content">
	<form name="edit_Careers" id="edit_Careers" class="form-Validate"  enctype="multipart/form-data">
		@csrf
		<input type="hidden" name="type" value="3" />
		<input type="hidden" name="id" value="{{@$data->id}}" />
		<input type="hidden" name="last_id_Career" id="last_id_Career">
		<input type="hidden" name="DataCus_id" id="DataCus_id" value="{{@$data->DataCus_id}}">

		<div class="d-flex m-3">
			<div class="flex-shrink-0 me-2">
				<img src="{{ asset('assets/images/gif/suitcase.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
			</div>
			<div class="flex-grow-1 overflow-hidden">
				<h5 class="text-primary fw-semibold">แก้ไขอาชีพ (Edit Jobs)</h5>
				<p class="text-muted mt-n1 fw-semibold font-size-12">No. : {{@$data->Code_Cus}}</p>
				<p class="border-primary border-bottom mt-n2 m-2"></p>
			</div>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

		<div class="modal-body">
			<div class="row p-2">
				<div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 text-center m-auto">
					<div class="row align-items-start">
						<div class="col-12 text-center">
							<img src="{{ asset('assets/images/undraw/career.svg') }}" alt="" style="width: 200px;">
						</div>
						<div class="col-12 mt-2">
							<h4 class="text-danger fw-bold">{{@$data->Code_Cus}}</h4>
						</div>
					</div>
				</div>
				<div class="col-xl-7 col-lg-7 col-md-12 col-sm-12 border-start">
                    <div class="row mx-auto">
                        <div class="col-12 col-md-12">
                            <div class="row mb-1">
                                <div class="col-12">
                                    <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                        <input class="form-check-input" type="checkbox" name="SwitchStatus_Cus" id="SwitchStatus_Cus" {{@$data->Status_Cus == 'active' ? 'checked' : ''}}>
                                        <label class="form-check-label {{@$data->Status_Cus == 'active' ? 'text-success' : 'text-mute'}}" id="text-status" for="SwitchStatus_Cus">{{@$data->Status_Cus == 'active' ? 'กำลังใช้งาน' : 'ปิดใช้งาน'}}</label>
                                        <input type="hidden" value="{{@$data->Status_Cus}}" name="Status_Cus" id="Status_Cus">
                                    </div>
                                </div>
                            </div>
                        </div>
					</div>
					<div class="row mx-auto ">
						<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
							<div class="row mb-1">
								<div class="col-sm-12">
									<div class="form-floating mb-0">
										<select name="Main_Career" class="form-control form-control-sm textSize-13 border" required>
											<option value="" selected>--- ประเภทอาชีพ ---</option>
											<option value="yes" {{ (@$data->Main_Career == 'yes' ? 'selected' : '') }} >กำหนดเป็นอาชีพหลัก</option>
											<option value="no" {{ (@$data->Main_Career == 'no' ? 'selected' : '') }}>กำหนดเป็นอาชีพรอง</option>
										</select>
										<label for="Name_Cus" class="fw-bold text-danger">ประเภทอาชีพ</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
							<div class="row mb-1">
								<div class="col-sm-12">
									<div class="form-floating mb-0 ">
										<select name="Career_Cus" id="Career_Cus" class="form-control form-control-sm textSize-13" required>
										<option value="" selected>--- อาชีพ ---</option>
										@foreach($typeCareer as $value)
											<option value="{{$value->Code_Career}}" {{(@$value->Code_Career == @$data->Career_Cus)?'selected':''}}>({{$value->Code_Career}}) - {{@$value->Name_Career}}</option>
										@endforeach
										</select>
										<label for="Career_Cus" class="fw-bold text-danger">อาชีพ</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
							<div class="row mb-1 g-2">
								<div class="col-sm-12">
									<div class="form-floating mb-0">
										<input type="text" class="form-control" name="Income_Cus" value="{{@$data->Income_Cus}}"  data-bs-toggle="tooltip" title="รายได้" placeholder="รายได้" >
										<label for="Income_Cus" class="fw-bold text-danger">รายได้</label>
									</div>
								</div>
                                <div class="col-sm-12">
                                    <div class="form-floating mb-0">
                                        <input type="text" class="form-control" name="BeforeIncome_Cus" value="{{@$data->BeforeIncome_Cus}}" data-bs-toggle="tooltip" title="หักค่าใช้จ่าย" placeholder="หักค่าใช้จ่าย" >
                                        <label for="BeforeIncome_Cus" class="fw-bold text-danger">หักค่าใช้จ่าย</label>
                                    </div>
                                </div>
							</div>
						</div>
						<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
							<div class="row mb-1 g-2">
								<div class="col-sm-12">
									<div class="form-floating mb-0">
										<input type="text" class="form-control" name="AfterIncome_Cus" value="{{@$data->AfterIncome_Cus}}" data-bs-toggle="tooltip" title="คงเหลือ" placeholder="คงเหลือ" >
										<label for="AfterIncome_Cus" class="fw-bold text-danger">คงเหลือ</label>
									</div>
								</div>
                                <div class="col-12">
                                    <div class="form-floating mb-0">
                                        <input type="text" class="form-control" name="Workplace_Cus" value="{{@$data->Workplace_Cus}}" value="{{@$data->Workplace_Cus}}" data-bs-toggle="tooltip" title="สถานที่ทำงาน" placeholder="สถานที่ทำงาน" required>
                                        <label for="Workplace_Cus" class="fw-bold text-danger">สถานที่ทำงาน</label>
                                    </div>
                                </div>
							</div>
						</div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                            <div class="row mb-1">
                                <div class="col-sm-12">
                                    <div class="form-floating mb-0">
                                        <input type="text" class="form-control" id="Coordinates" name="Coordinates" value="{{@$data->Coordinates}}" placeholder="พิกัดอาชีพ" autocomplete="off" required>
                                        <label for="Coordinates" class="fw-bold text-danger">พิกัด</label>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
							<div class="row mb-1">
								<div class="col-12">
									<div class="form-floating mb-0">
										<textarea rows="2" name="IncomeNote_Cus" class="form-control form-control-sm textSize-13">{{@$data->IncomeNote_Cus}}</textarea>
                                        <label for="IncomeNote_Cus" class="fw-bold text-danger">หมายเหตุ</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
        <div class="modal-footer">
            <button type="button" id="btn_EditCareer" class="btn btn-primary btn-sm waves-effect waves-light hover-up btn_editUser">
				<span class="addSpin"><i class="fas fa-download"></i></span> บันทึก
            </button>
            <button type="button" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">
				<i class="mdi mdi-close-circle-outline"></i> ปิด
			</button>
        </div>
    </form>
</div>




