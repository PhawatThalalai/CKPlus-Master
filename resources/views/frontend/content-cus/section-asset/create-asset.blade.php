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

@include('public-js.scriptAddress')
@include('frontend.content-cus.section-asset.script-asset')

<div class="modal-content">
	<form id="CreateAsset" class="needs-validation" action="#" novalidate>
		@csrf
		<input type="hidden" name="DataCus_id" id="DataCus_id" value="{{ @$data->id }}">

		<div class="d-flex m-3">
			<div class="flex-shrink-0 me-2">
				<img src="{{ asset('assets/images/gif/assetcus.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
			</div>
			<div class="flex-grow-1 overflow-hidden">
				<h5 class="text-primary fw-semibold">เพิ่มทรัพย์ค้ำประกัน (New Assets)</h5>
				<p class="text-muted mt-n1 fw-semibold font-size-12">No. : {{ @$CodeJob }}</p>
				<p class="border-primary border-bottom mt-n2 m-2"></p>
			</div>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

        {{-- <div class="modal-header bg-info bg-soft">
            <img src="{{ asset('assets/images/gif/location-pin.gif') }}" alt="report" class="avatar-sm me-2" style="width:50px;height:50px">
			<h5 class="modal-title fw-semibold" id="data-modal-xl-label">เพิ่มทรัพย์ค้ำประกัน (New Assets)</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div> --}}

		<div class="modal-body">
			<div class="row p-2">
				<div class="col-xl-5 col-lg-5 col-sm-12 text-center bg-light">
					<div class="row align-items-start">
						<div class="col-12 text-center mt-5">
							<img src="{{ asset('assets/images/undraw/asset.svg') }}" alt="" style="width: 150px;">
						</div>
						<div class="col-12 mt-2">
							<h4 class="text-danger fw-bold">{{ @$CodeJob }}</h4>
						</div>
					</div>
				</div>
				<div class="col-xl col-lg col-sm-12">
					<div class="row mx-auto ">
						<div class="col-lg-12 col-md-12">
							<div class="row mb-1">
								<div class="col-sm-12">
									<div class="form-floating mb-0">
										<select name="Type_Asset" class="form-control form-control-sm textSize-13" required>
											<option value="" selected>--- ประเภททรัพย์ ---</option>
											@foreach ($typeAsset as $key => $value)
												<option value="{{ $value->Code_Assets }}">{{ $value->Name_Assets }}</option>
											@endforeach
										</select>
										<label for="Name_Cus" class="fw-bold text-danger">ประเภททรัพย์</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row mb-1 g-1">
								<div class="col-sm-6">
									<div class="form-floating mb-0 ">
										<input type="text" class="form-control " name="Deednumber_Asset" value="" data-bs-toggle="tooltip" title="บ้านเลขที่" placeholder="บ้านเลขที่">
										<label for="Name_Cus" class="fw-bold text-danger">เลขที่โฉนด</label>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-floating mb-0">
										<input type="text" class="form-control" name="Area_Asset" value="" data-bs-toggle="tooltip" title="หมู่" placeholder="หมู่">
										<label for="Name_Cus" class="fw-bold text-danger"> เนื้อที</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row mb-1">
								<div class="col-sm-12">
									<div class="form-floating mb-0">
										@php
											$dataZone = \App\Models\TB_Constants\TB_Frontend\TB_Provinces::selectRaw('Zone_pro, count(*) as total')
											    ->groupBy('Zone_pro')
											    ->orderBY('Zone_pro', 'ASC')
											    ->get();
										@endphp
										<select id="houseZone_Asset" name="houseZone_Asset" class="form-control form-control-sm textSize-13 houseZone selectAdds">
											<option value="" selected>--- ภูมิภาค ---</option>
											@foreach ($dataZone as $key => $Zone)
												<option value="{{ $Zone->Zone_pro }}">{{ $Zone->Zone_pro }}</option>
											@endforeach
										</select>
										<label for="Prefix" class="fw-bold text-danger">-- ภูมิภาค --</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row mb-1">
								<div class="col-sm-12">
									<div class="form-floating mb-0">
										<select id="houseProvince_Asset" name="houseProvince_Asset" class="form-select houseProvince selectAdds">
											<option value="" selected>-- จังหวัด --</option>
										</select>
										<label for="Prefix" class="fw-bold text-danger">-- จังหวัด --</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row mb-1">
								<div class="col-sm-12">
									<div class="form-floating mb-0">
										<select id="houseDistrict_Asset" name="houseDistrict_Asset" class="form-select houseDistrict selectAdds">
											<option value="" selected>-- อำเภอ --</option>
										</select>
										<label for="Prefix" class="fw-bold text-danger">-- อำเภอ --</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row mb-1">
								<div class="col-sm-12">
									<div class="form-floating mb-0">
										<select id="houseTambon_Asset" name="houseTambon_Asset" class="form-select houseTambon selectAdds">
											<option value="" selected>-- ตำบล --</option>
										</select>
										<label for="Prefix" class="fw-bold text-danger">-- ตำบล --</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row mb-1">
								<div class="col-sm-12">
									<div class="form-floating mb-0">
										<input type="text" class="form-control Postal" id="Postal_Asset" name="Postal_Asset" placeholder="ชื่อ-นามสกุล" autocomplete="off">
										<label for="Name_Cus" class="fw-bold text-danger">รหัสไปรษณีย์</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row mb-1">
								<div class="col-sm-12">
									<div class="form-floating mb-0">
										<input type="text" class="form-control" name="Note_Asset" value="" data-bs-toggle="tooltip" title="ชื่อ-นามสกุล" placeholder="ชื่อ-นามสกุล">
										<label for="Name_Cus" class="fw-bold text-danger">รายละเอียด</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row mb-1">
								<div class="col-sm-12">
									<div class="form-floating mb-0">
										<input type="text" class="form-control" id="Asset_Coordinates_Adds3" name="Coordinates_Asset" value="" data-bs-toggle="tooltip" title="ชื่อ-นามสกุล" placeholder="ชื่อ-นามสกุล">
										<label for="Name_Cus" class="fw-bold text-danger">พิกัด</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" id="btn_SubmitAsset" class="btn btn-primary btn-sm waves-effect waves-light hover-up">
					<i class="fas fa-download"></i></span> บันทึก <span class="addSpin">
				</button>
				<button type="button" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">
					<i class="mdi mdi-close-circle-outline"></i> ปิด
				</button>
			</div>
	</form>
</div>
</div>
