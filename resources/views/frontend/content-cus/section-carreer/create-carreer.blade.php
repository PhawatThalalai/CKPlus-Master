<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>
<script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
<style>
	/* ทำให้ form-floating มีขนาดเล็กลง */
	.form-floating>.form-select {
		/* padding-top: 1.625rem;
		padding-bottom: 0.625rem;*/
		padding-top: 1rem;
		padding-bottom: 0.625rem;
	}

	.form-floating>.form-control:focus,
	.form-floating>.form-control:not(:placeholder-shown),
	.form-floating>.form-control-plaintext:focus,
	.form-floating>.form-control-plaintext:not(:placeholder-shown) {
		/* padding-top: 1.625rem;
		padding-bottom: 0.625rem; */
		padding-top: 1rem;
		padding-bottom: 0.5rem;
	}

	.form-floating>.form-control,
	.form-floating>.form-control-plaintext {
		/* padding: 1rem 0.75rem; */
		padding: 1rem 0.75rem;
	}

	.form-floating>.form-control,
	.form-floating>.form-control-plaintext,
	.form-floating>.form-select {
		/* height: calc(3.5rem + 2px);
		line-height: 1.25; */
		height: calc(2.5rem + 2px);
		line-height: 1.25;
	}

	.form-floating>label {
		/* padding: 1rem 0.75rem; */
		padding: 0.8rem 0.6rem;
	}

	.form-floating>.form-control:focus~label,
	.form-floating>.form-control:not(:placeholder-shown)~label,
	.form-floating>.form-control-plaintext~label,
	.form-floating>.form-select~label {
		/* -webkit-transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem);
		transform: scale(0.85) translateY(-0.5rem) translateX(0.15rem); */
		-webkit-transform: scale(0.85) translateY(-0.775rem) translateX(0.15rem);
		transform: scale(0.85) translateY(-0.775rem) translateX(0.15rem);
	}
</style>

@include('frontend.content-cus.section-carreer.script-career')

<div class="modal-content">
	<form name="CreateCareer" id="CreateCareer" class="needs-validation" action="#" method="post" enctype="multipart/form-data">
		@csrf
		<input type="hidden" name="DataCus_id" id="DataCus_id" value="{{ @$data->id }}">

		<div class="d-flex m-3">
			<div class="flex-shrink-0 me-2">
				<img src="{{ asset('assets/images/gif/suitcase.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
			</div>
			<div class="flex-grow-1 overflow-hidden">
				<h5 class="text-primary fw-semibold">เพิ่มอาชีพ (New Jobs)</h5>
				<p class="text-muted mt-n1 fw-semibold font-size-12">No. : {{ @$CodeJob }}</p>
				<p class="border-primary border-bottom mt-n2 m-2"></p>
			</div>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>


		<div class="modal-body">
			<div class="row px-2">
				<div class="col-xl-5 col-md-12 col-lg-12 col-sm-12 text-center bg-light">
					<div class="row pt-2">
						<div class="col-xl col-md col-sm-12">
							<div class="card-adds card p-3">
								<div class="form-check">
									<input class="form-check-input fs-5 Type_Carreer" type="radio" value="yes" id="career_1" name="main_Career">
									<label class="form-check-label fs-6" for="career_1">
										กำหนดเป็นอาชีพหลัก
									</label>
								</div>
							</div>
						</div>
						<div class="col-xl col-md col-sm-12">
							<div class="card-adds card p-3">
								<div class="form-check">
									<input class="form-check-input fs-5 Type_Carreer" type="radio" value="no" id="career_2" name="main_Career">
									<label class="form-check-label fs-6" for="career_2">
										กำหนดเป็นอาชีพรอง
									</label>
								</div>
							</div>
						</div>
					</div>
                    <div class="row align-items-start">
						<div class="col-12 text-center">
							<img src="{{ asset('assets/images/undraw/career.svg') }}" alt="" style="width: 170px;">
						</div>
						<div class="col-12 mt-2">
							<h4 class="text-danger fw-bold">{{ @$CodeJob }}</h4>
						</div>
					</div>
				</div>
				<div class="col-xl col-md-12 col-lg-12 col-sm-12">
					<div class="row mx-auto">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<div class="row mb-1">
								<div class="col-sm-12">
									<div class="form-floating mb-0">
										<select name="Career_Cus" id="Career_Cus" class="form-control form-control-sm textSize-13" required>
											<option value="" selected>--- อาชีพ ---</option>
											@foreach ($typeCareer as $value)
												<option value="{{ $value->Code_Career }}">({{ $value->Code_Career }}) - {{ @$value->Name_Career }}</option>
											@endforeach
										</select>
										<label for="Career_Cus" class="fw-bold text-danger">อาชีพ</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="row mb-1">
								<div class="col-xl-12 col-sm-12">
									<div class="form-floating mb-0">
										<input type="text" class="form-control" name="Income_Cus" data-bs-toggle="tooltip" title="รายได้" placeholder="รายได้">
										<label for="Income_Cus" class="fw-bold text-danger">รายได้</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="row mb-1 g-2">
								<div class="col-xl-6 col-lg-6 col-sm-12">
									<div class="form-floating mb-0">
										<input type="text" class="form-control" name="BeforeIncome_Cus" data-bs-toggle="tooltip" title="หักค่าใช้จ่าย" placeholder="หักค่าใช้จ่าย">
										<label for="BeforeIncome_Cus" class="fw-bold text-danger">หักค่าใช้จ่าย</label>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6  col-sm-12">
									<div class="form-floating mb-0">
										<input type="text" class="form-control" name="AfterIncome_Cus" data-bs-toggle="tooltip" title="คงเหลือ" placeholder="คงเหลือ" >
										<label for="AfterIncome_Cus" class="fw-bold text-danger">คงเหลือ</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12 col-sm-12">
							<div class="row mb-1">
								<div class="col-sm-12">
									<div class="form-floating mb-0">
										<input type="text" class="form-control" name="Workplace_Cus" data-bs-toggle="tooltip" title="สถานที่ทำงาน" placeholder="สถานที่ทำงาน" required>
										<label for="Workplace_Cus" class="fw-bold text-danger">สถานที่ทำงาน</label>
									</div>
								</div>
							</div>
						</div>
                        <div class="col-lg-6 col-md-12">
                            <div class="row mb-1">
                                <div class="col-sm-12">
                                    <div class="form-floating mb-0">
                                        <input type="text" class="form-control" id="Cus_Coordinates" name="Coordinates" placeholder="พิกัดอาชีพ" autocomplete="off" required>
                                        <label for="Cus_Coordinates" class="fw-bold text-danger">พิกัด</label>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
							<div class="row mb-1">
								<div class="col-12">
									<div class="form-floating mb-0">
										<textarea rows="2" name="IncomeNote_Cus" class="form-control form-control-sm textSize-13"></textarea>
                                        <label for="IncomeNote_Cus" class="fw-bold text-danger">หมายเหตุ</label>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn_SubmitCareer" class="btn btn-primary btn-sm waves-effect waves-light hover-up">
					<i class="fas fa-download"></i></span> บันทึก <span class="addSpin">
				</button>
				<button type="button" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">
					<i class="mdi mdi-close-circle-outline"></i> ปิด
				</button>
			</div>
		</div>
	</form>
</div>


