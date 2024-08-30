
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
@include('public-js.scriptAddress')
@include('frontend.content-cus.section-asset.script-asset')
<div class="modal-content">
	<form id="edit_Asset" class="needs-validation" action="#" novalidate>
	@csrf
		<input type="hidden" name="type" value="3" />
		<input type="hidden" name="id" value="{{@$data->id}}" />
		<input type="hidden" name="last_id_Career" id="last_id_Career">
		<input type="hidden" name="DataCus_id" id="DataCus_id" value="{{@$data->DataCus_id}}">

        {{-- <div class="modal-header bg-info bg-soft">
            <img src="{{ asset('assets/images/gif/location-pin.gif') }}" alt="report" class="avatar-sm me-2" style="width:50px;height:50px">
			<h5 class="modal-title fw-semibold" id="data-modal-xl-label">แก้ไขทรัพย์ค้ำประกัน (Edit Assets)</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div> --}}

        <div class="d-flex m-3">
			<div class="flex-shrink-0 me-2">
				<img src="{{ asset('assets/images/gif/assetcus.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
			</div>
			<div class="flex-grow-1 overflow-hidden">
				<h5 class="text-primary fw-semibold">ทรัพย์ค้ำประกัน (View Assets)</h5>
				<p class="text-muted mt-n1 fw-semibold font-size-12">No. : {{@$data->Code_Asset}}</p>
				<p class="border-primary border-bottom mt-n2 m-2"></p>
			</div>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

		<div class="modal-body">
			<div class="row p-2">
				<div class="col-5 text-center bg-light">
					<div class="row align-items-start">
						<div class="col-12 pt-2 text-center">
						<h2>แก้ไขทรัพย์ค้ำ</h2>
						</div>
						<div class="col-12 text-center">
							<img src="assets/images/asset.png" alt="" style="width: 100px;">
						</div>
						<div class="col-12 mt-2">
							<h4 class="text-danger fw-bold">{{@$data->Code_Asset}}</h4>
						</div>
					</div>

				</div>
				<div class="col">
				<div class="row mx-auto">
						<div class="col-12 col-md-12">
							<div class="row mb-1">
								<div class="col-12">
									<div class="form-check form-switch form-switch-md mb-3" dir="ltr">
										<input class="form-check-input" type="checkbox" name="SwitchStatus_Asst" id="SwitchStatus_Asst" {{@$data->Status_Asset == 'active' ? 'checked' : ''}}>
										<label class="form-check-label {{@$data->Status_Asset == 'active' ? 'text-success' : 'text-mute'}}" id="text-status" for="SwitchStatus_Asst">{{@$data->Status_Asset == 'active' ? 'กำลังใช้งาน' : 'ปิดใช้งาน'}}</label>
										<input type="hidden" value="{{@$data->Status_Asset}}" name="Status_Asset" id="Status_Asset">
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row mx-auto ">
						<div class="col-lg-12 col-md-12">
							<div class="row mb-1">
								<div class="col-sm-12">
									<div class="form-floating mb-0">
									<select name="Type_Asset" class="form-control form-control-sm textSize-13" required>
										<option value="" selected>--- ประเภททรัพย์ ---</option>
										@foreach($typeAsset as $key => $value)
											<option value="{{$value->Code_Assets}}" {{ ($value->Code_Assets == @$data->Type_Asset) ? 'selected' : '' }}>{{$value->Name_Assets}}</option>
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
										<input type="text" class="form-control " name="Deednumber_Asset" value="{{@$data->Deednumber_Asset}}" data-bs-toggle="tooltip" title="บ้านเลขที่" placeholder="บ้านเลขที่" required>
										<label for="Name_Cus" class="fw-bold text-danger">เลขที่โฉนด</label>
									</div>
								</div>
								<div class="col-sm-6">
									<div class="form-floating mb-0">
										<input type="text" class="form-control" name="Area_Asset" value="{{@$data->Area_Asset}}" data-bs-toggle="tooltip" title="หมู่" placeholder="หมู่" required>
										<label for="Name_Cus" class="fw-bold text-danger"> เนื้อที</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row mb-1">
								<!-- <label for="view_Phone_cus" class="col-sm-3 col-form-label">ภูมิภาค :</label> -->
								<div class="col-sm-12">
									<div class="form-floating mb-0">
									@php
									$dataZone = \App\Models\TB_Constants\TB_Frontend\TB_Provinces::selectRaw('Zone_pro, count(*) as total')
										->groupBy('Zone_pro')
										->orderBY('Zone_pro', 'ASC')
										->get();
									@endphp
									<select id="houseZone_Asset" name="houseZone_Asset" class="form-control form-control-sm textSize-13 houseZone">
									<option value="" selected>--- ภูมิภาค ---</option>
									@foreach($dataZone as $key => $Zone)
										<option value="{{$Zone->Zone_pro}}" {{ ($Zone->Zone_pro == @$data->houseZone_Asset) ? 'selected' : '' }}>{{$Zone->Zone_pro}}</option>
									@endforeach
									</select>
										<label for="Prefix" class="fw-bold text-danger">-- ภูมิภาค --</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row mb-1">
								<!-- <label for="view_Phone_cus" class="col-sm-3 col-form-label">จังหวัด :</label> -->
								<div class="col-sm-12">
									<div class="form-floating mb-0">
									@php
                  $Province = \App\Models\TB_Constants\TB_Frontend\TB_Provinces::where('Zone_pro',@$data->houseZone_Asset)
                    ->selectRaw('Province_pro, count(*) as total')
                    ->groupBy('Province_pro')
                    ->orderBY('Province_pro', 'ASC')
                    ->get();
                @endphp
                <select id="houseProvince_Asset" name="houseProvince_Asset" class="form-control form-control-sm textSize-13 houseProvince">
                  <option value="" selected>--- จังหวัด ---</option>
                  @foreach($Province as $key => $value)
                    <option value="{{$value->Province_pro}}" {{ ($value->Province_pro == @$data->houseProvince_Asset) ? 'selected' : '' }}>{{$value->Province_pro}}</option>
                  @endforeach
                </select>
										<label for="Prefix" class="fw-bold text-danger">-- จังหวัด --</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row mb-1">
								<!-- <label for="view_Phone_cus" class="col-sm-3 col-form-label">อำเภอ :</label> -->
								<div class="col-sm-12">
									<div class="form-floating mb-0">
									@php
                  $District = \App\Models\TB_Constants\TB_Frontend\TB_Provinces::where('Province_pro',@$data->houseProvince_Asset)
                    ->selectRaw('District_pro, count(*) as total')
                    ->groupBy('District_pro')
                    ->orderBY('District_pro', 'ASC')
                    ->get();
                @endphp
                <select id="houseDistrict_Asset" name="houseDistrict_Asset" class="form-control form-control-sm textSize-13 houseDistrict">
                  <option value="" selected>--- อำเภอ ---</option>
                  @foreach($District as $key => $value)
                    <option value="{{$value->District_pro}}" {{ ($value->District_pro == @$data->houseDistrict_Asset) ? 'selected' : '' }}>{{$value->District_pro}}</option>
                  @endforeach
                </select>
										<label for="Prefix" class="fw-bold text-danger">-- อำเภอ --</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row mb-1">
								<!-- <label for="view_Phone_cus" class="col-sm-3 col-form-label">ตำบล :</label> -->
								<div class="col-sm-12">
									<div class="form-floating mb-0">
									@php
                  $Tambon = \App\Models\TB_Constants\TB_Frontend\TB_Provinces::where('District_pro',@$data->houseDistrict_Asset)
                    ->selectRaw('Tambon_pro, count(*) as total')
                    ->groupBy('Tambon_pro')
                    ->orderBY('Tambon_pro', 'ASC')
                    ->get();
                @endphp
                <select id="houseTambon_Asset" name="houseTambon_Asset" class="form-control form-control-sm textSize-13 houseTambon">
                  <option value="" selected>--- ตำบล ---</option>
                  @foreach($Tambon as $key => $value)
                    <option value="{{$value->Tambon_pro}}" {{ ($value->Tambon_pro == @$data->houseTambon_Asset) ? 'selected' : '' }}>{{$value->Tambon_pro}}</option>
                  @endforeach
                </select>
										<label for="Prefix" class="fw-bold text-danger">-- ตำบล --</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row mb-1">
								<!-- <label for="view_Birthday_cus" class="col-sm-3 col-form-label">รายละเอียด :</label> -->
								<div class="col-sm-12">
									<div class="form-floating mb-0">
										<input type="text" class="form-control Postal" id="Postal_Asset" name="Postal_Asset" value="{{@$data->Postal_Asset}}" placeholder="ชื่อ-นามสกุล" autocomplete="off" required>
										<label for="Name_Cus" value="{{@$data->Postal_Asset}}" class="fw-bold text-danger">รหัสไปรษณีย์</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row mb-1">
								<!-- <label for="view_Birthday_cus" class="col-sm-3 col-form-label">รายละเอียด :</label> -->
								<div class="col-sm-12">
									<div class="form-floating mb-0">
										<textarea name="Note_Asset" rows="2" class="form-control form-control-sm textSize-13" placeholder="รายละเอียด">{{@$data->Note_Asset}}</textarea>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row mb-1">
								<!-- <label for="view_Birthday_cus" class="col-sm-3 col-form-label">พิกัด :</label> -->
								<div class="col-sm-12">
									<div class="form-floating mb-0">
										<input type="text" class="form-control" id="Asset_Coordinates_Adds3" name="Coordinates_Asset" value="{{@$data->Coordinates_Asset}}"  data-bs-toggle="tooltip" title="ชื่อ-นามสกุล" placeholder="ชื่อ-นามสกุล" required>
										<label for="Name_Cus" class="fw-bold text-danger">พิกัด</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</form>
 </div>
</div>


