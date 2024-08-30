
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
	.card-adds:hover{
		scale : 1;
		transition : 0.3s;
		z-index : 1;
	}
	.card-adds{
		scale:0.9;
		transition : 0.3s;
	}


</style>
@include('public-js.scriptAddress')
 @include('frontend.content-cus.section-address.script-address')
<div class="modal-content">
	<form id="edit_Address" class="needs-validation"  novalidate>
		@csrf
		<input type="hidden" name="type" value="2" />
		<input type="hidden" name="id" value="{{@$data->id}}" />
		<input type="hidden" name="last_id" id="last_id">
		<input type="hidden" name="DataCus_id" id="DataCus_id" value=" {{@$data->DataCus_id}}">

        <div class="d-flex m-3">
			<div class="flex-shrink-0 me-2">
				<img src="{{ asset('assets/images/gif/home.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
			</div>
			<div class="flex-grow-1 overflow-hidden">
				<h5 class="text-primary fw-semibold">ที่อยู่ลูกค้า (View Address)</h5>
				<p class="text-muted mt-n1 fw-semibold font-size-12">No. : {{ @$data->Code_Adds }}</p>
				<p class="border-primary border-bottom mt-n2 m-2"></p>
			</div>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>

		<div class="modal-body">
			<div class="row p-2">
				<div class="col-xl-5 col-sm-12 mb-1 text-center bg-light">
					<div class="row pt-2 g-1 mb-2 mt-1">
						<div class="col-xl col-md col-sm-12">
							<h4 class="fw-semibold"></h4>
						</div>
						<textarea name="" id="arrAdress" cols="30" rows="10" hidden>{{ @$dataAdds }}</textarea>
					</div>

					<div class="row align-items-start">
						<div class="col-12 text-center">
							<img src="assets/images/undraw/undraw_home.svg" alt="" style="width: 150px;">
						</div>
						<div class="col-12 mt-2">
							<h4 class="text-danger fw-bold">{{@$data->Code_Adds}}</h4>
						</div>
					</div>
                    <div class="">
                        <button type="button" class="btn btn-outline-primary rounded-pill mb-1">{{ @$data->DataCusAddsToTypeAdds->Name_Address }}</button>
                    </div>
                    <div class="row bg-white bg-opacity-50">
                        <div class="form-switch form-switch-md my-2">
                            <input class="form-check-input" type="checkbox" name="SwitchStatus_Adds" id="SwitchStatus_Adds" {{@$data->Status_Adds == 'active' ? 'checked' : ''}} disabled>
                            <label class="form-check-label {{@$data->Status_Adds == 'active' ? 'text-success' : 'text-mute'}}" id="text-status" for="SwitchStatus_Adds">{{@$data->Status_Adds == 'active' ? 'กำลังใช้งาน' : 'ปิดใช้งาน'}}</label>
                            <input type="hidden" value="{{@$data->Status_Adds}}" name="Status_Adds" id="Status_Adds">
                        </div>
                    </div>
				</div>
				<div class="col">
					<div class="row mx-auto ">
						<div class="col-lg-6 col-md-12">
							<div class="row mb-1">
								<!-- <label class="col-sm-3 col-form-label">ประเภทที่อยู่ : </label> -->
								<div class="col-xl-12 col-md-12 col-lg-12 col-sm-12">
									<div class="form-floating mb-0">
									<select name="Type_Adds" class="form-control form-control-sm textSize-13 bg-light" style="pointer-events: none;" required>
										<option value="" selected>--- ประเภทที่อยู่ ---</option>
										@foreach($typeAdds as $key => $value)
										<option value="{{$value->Code_Address}}" {{ ($value->Code_Address == @$data->Type_Adds) ? 'selected' : '' }}>{{$value->Name_Address}}</option>
										@endforeach
									</select>
										<label for="Name_Cus" class="fw-bold text-danger">ประเภทที่อยู่</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row mb-1 g-1">
								<!-- <label class="col-sm-3 col-form-label ">บ้านเลขที่ / หมู่ :</label> -->
								<div class="col-xl-6 col-md-12 col-lg-6 col-sm-12">
									<div class="form-floating mb-0 ">
										<input type="text" class="form-control " name="houseNumber_Adds" id="houseNumber_Adds" value="{{@$data->houseNumber_Adds}}"  placeholder="บ้านเลขที่" autocomplete="off" required disabled>
										<label for="Name_Cus" class="fw-bold text-danger">บ้านเลขที่</label>
									</div>
								</div>
								<div class="col-xl-6 col-md-12 col-lg-6 col-sm-12">
									<div class="form-floating mb-0">
										<input type="text" class="form-control" name="houseGroup_Adds" id="houseGroup_Adds" value="{{@$data->houseGroup_Adds}}"  placeholder="หมู่" autocomplete="off" required disabled>
										<label for="Name_Cus" class="fw-bold text-danger">หมู่</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row mb-1 g-1">
								<div class="col-xl-6 col-md-12 col-lg-6 col-sm-12">
									<div class="form-floating mb-0">
										<input type="text" class="form-control" name="building_Adds" id="building_Adds" value="{{@$data->building_Adds}}"  placeholder="ชื่อ-นามสกุล" autocomplete="off" disabled>
										<label for="Name_Cus" class="fw-bold text-danger">อาคาร</label>
									</div>
								</div>
								<div class="col-xl-6 col-md-12 col-lg-6 col-sm-12">
									<div class="form-floating mb-0">
										<input type="text" class="form-control" name="village_Adds" id="village_Adds" value="{{@$data->village_Adds}}"  placeholder="ชื่อ-นามสกุล" autocomplete="off" disabled>
										<label for="Name_Cus" class="fw-bold text-danger">หมู่บ้าน</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row mb-1 g-1">
								<div class="col-xl-6 col-md-12 col-lg-6 col-sm-12">
									<div class="form-floating mb-0">
										<input type="text" class="form-control" name="roomNumber_Adds" id="roomNumber_Adds" value="{{@$data->roomNumber_Adds}}"  placeholder="ชื่อ-นามสกุล" autocomplete="off" disabled>
										<label for="Name_Cus" class="fw-bold text-danger">เลขที่ห้อง</label>
									</div>
								</div>
								<div class="col-xl-6 col-md-12 col-lg-6 col-sm-12">
									<div class="form-floating mb-0">
										<input type="text" class="form-control" name="Floor_Adds" id="Floor_Adds" value="{{@$data->Floor_Adds}}"  placeholder="ชื่อ-นามสกุล" autocomplete="off" disabled>
										<label for="Name_Cus" class="fw-bold text-danger">ชั้นที่</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row mb-1 g-1">
								<div class="col-xl-6 col-md-12 col-lg-6 col-sm-12">
									<div class="form-floating mb-0">
										<input type="text" class="form-control" name="alley_Adds" id="alley_Adds" value="{{@$data->alley_Adds}}"  placeholder="ชื่อ-นามสกุล" autocomplete="off" disabled>
										<label for="Name_Cus" class="fw-bold text-danger">ซอย</label>
									</div>
								</div>
								<div class="col-xl-6 col-md-12 col-lg-6 col-sm-12">
									<div class="form-floating mb-0">
										<input type="text" class="form-control" name="road_Adds" id="road_Adds" value="{{@$data->road_Adds}}"  placeholder="ชื่อ-นามสกุล " autocomplete="off" disabled>
										<label for="Name_Cus" class="fw-bold text-danger">ถนน</label>
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
										<select id="houseZone_Adds" name="houseZone_Adds" class="form-control form-control-sm textSize-13 houseZone" disabled>
										<option value="" selected>--- ภูมิภาค ---</option>
										@foreach($dataZone as $key => $Zone)
											<option value="{{$Zone->Zone_pro}}" {{ ($Zone->Zone_pro == @$data->houseZone_Adds) ? 'selected' : '' }}>{{$Zone->Zone_pro}}</option>
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
										@php
										$Province = \App\Models\TB_Constants\TB_Frontend\TB_Provinces::where('Zone_pro',@$data->houseZone_Adds)
											->selectRaw('Province_pro, count(*) as total')
											->groupBy('Province_pro')
											->orderBY('Province_pro', 'ASC')
											->get();
										@endphp
										<select id="houseProvince_Adds" name="houseProvince_Adds" class="form-control form-control-sm textSize-13 houseProvince" disabled>
										<option value="" selected>--- จังหวัด ---</option>
										@foreach($Province as $key => $value)
											<option value="{{$value->Province_pro}}" {{ ($value->Province_pro == @$data->houseProvince_Adds) ? 'selected' : '' }}>{{$value->Province_pro}}</option>
										@endforeach
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
										@php
										$District = \App\Models\TB_Constants\TB_Frontend\TB_Provinces::where('Province_pro',@$data->houseProvince_Adds)
											->selectRaw('District_pro, count(*) as total')
											->groupBy('District_pro')
											->orderBY('District_pro', 'ASC')
											->get();
										@endphp
										<select id="houseDistrict_Adds" name="houseDistrict_Adds" class="form-control form-control-sm textSize-13 houseDistrict" disabled>
										<option value="" selected>--- อำเภอ ---</option>
										@foreach($District as $key => $value)
											<option value="{{$value->District_pro}}" {{ ($value->District_pro == @$data->houseDistrict_Adds) ? 'selected' : '' }}>{{$value->District_pro}}</option>
										@endforeach
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
										@php
										$Tambon = \App\Models\TB_Constants\TB_Frontend\TB_Provinces::where('District_pro',@$data->houseDistrict_Adds)
											->selectRaw('Tambon_pro, count(*) as total')
											->groupBy('Tambon_pro')
											->orderBY('Tambon_pro', 'ASC')
											->get();
										@endphp
										<select id="houseTambon_Adds" name="houseTambon_Adds" class="form-control form-control-sm textSize-13 houseTambon" disabled>
										<option value="" selected>--- ตำบล ---</option>
										@foreach($Tambon as $key => $value)
											<option value="{{$value->Tambon_pro}}" {{ ($value->Tambon_pro == @$data->houseTambon_Adds) ? 'selected' : '' }}>{{$value->Tambon_pro}}</option>
										@endforeach
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
										<input type="text" class="form-control Postal" id="Postal_Adds" name="Postal_Adds" value="{{@$data->Postal_Adds}}" placeholder="ชื่อ-นามสกุล" autocomplete="off" required disabled>
										<label for="Name_Cus" class="fw-bold text-danger">รหัสไปรษณีย์</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row mb-1">
								<div class="col-sm-12">
									<div class="form-floating mb-0">
										<input type="text" class="form-control" id="Cus_Coordinates_Adds3" name="Coordinates_Adds" value="{{@$data->Coordinates_Adds}}" placeholder="ชื่อ-นามสกุล" autocomplete="off" required disabled>
										<label for="Name_Cus" class="fw-bold text-danger">พิกัด</label>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-6 col-md-12">
							<div class="row mb-1">
								<div class="col-sm-12">
									<div class="form-floating mb-0">
										<input type="text" class="form-control" name="Detail_Adds" id="Detail_Adds" value="{{@$data->Detail_Adds}}" placeholder="ชื่อ-นามสกุล" autocomplete="off" required disabled>
										<label for="Name_Cus" class="fw-bold text-danger">รายละเอียด</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
        </div>
        <div class="modal-footer">
			<button type="button" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">ปิด</button>
		</div>
	</form>
</div>








