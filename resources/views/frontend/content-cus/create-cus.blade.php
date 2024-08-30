@extends('layouts.master')
@section('title', 'New Customer')
@section('datacus-active', 'mm-active')
@section('newcus-active', 'mm-active')
@section('page-backend', 'd-none')

@section('content')
	<style>
		.card-wall-profile {
			background-position: bottom right;
			background-image: url("{{ asset('/assets/images/profile-img.png') }}");
			background-size: contain;
			background-repeat: no-repeat;
		}
	</style>

	<link rel="stylesheet" href="{{ URL::asset('assets/css/datepicker-custom.css') }}">

	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])
	@include('components.content-toast.view-toast')
	@component('components.breadcrumb')
		@slot('title')
			Create New Customer
		@endslot
		@slot('title_small')
			(สร้างลูกค้าใหม่)
		@endslot
		@slot('menu')
			ระบบ ฐานลูกค้า
		@endslot
		@slot('sub_menu')
			รายการ ลูกค้า
		@endslot
	@endcomponent

	<form id="formCreateCus" class="needs-validation" action="#" novalidate>
		@csrf
		<div class="row g-0 mb-3">
			<div class="col-xl-2 col-lg-3 col-md-3 col-12">
				<div class="card rounded-0 m-0 text-center bg-primary bg-soft h-100">
					<div class="card-body card-wall-profile h-100 border-primary border-top border-opacity-25">
						<h5 class="fw-bold m-3 bg-primary bg-opacity-25 rounded-3 py-2 text-start text-sm-center m-xl-0 ps-4 ps-sm-0"><i class="mdi mdi-account-star fs-4"></i> ลูกค้าใหม่</h5>
						<div class="row d-none d-sm-flex" style="padding-top: 5rem;">
							<div class="avatar-md profile-user-wid mb-4 col text-center">
								<img id="ImageBrok" src="{{ asset('/assets/images/users/user-1.png') }}" style="min-width: 8rem;height: 8rem;" class="img-thumbnail rounded-circle hover-up mb-2 boreder-img" alt="User-Profile-Image">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-10 col-lg-9 col-md-9 col-12">
				<div class="card rounded-0 m-0 border-primary border-opacity-25">
					<div class="card-body">
						<div class="row">
							<!-- คอลัมน์ฝั่งซ้าย -->
							<div class="col-12 col-lg-12 col-xl-6">
								<!-- ข้อมูลติดต่อ -->
								<div class="p-0 p-xl-4 pt-xl-0 pt-lg-0 pt-md-0 py-sm-4">
									<div class="row g-2 align-self-center">
										<div class="col-sm-auto col-md col-xl-12 mt-2">
											<select class="form-select" id="Type_Card" name="Type_Card" data-bs-toggle="tooltip" title="ชนิดเลขบัตรที่ใช้">
												<option value="" selected>-- ชนิดบัตร --</option>
												@foreach (@$TypeCard as $value)
													<option value="{{ $value->Code }}">{{ $value->Detail_Card }}</option>
												@endforeach
											</select>
										</div>
										<div class="col-6 col-sm-auto my-2">
											<label class="visually-hidden" for="autoSizingSelect">Preference</label>
											<div class="input-bx">
												<select class="form-select" id="Prefix" name="Prefix" required>
													<option value="" selected>-- คำนำหน้า --</option>
													@foreach (@$TBPrefix as $value)
														<option value="{{ $value->Detail_Prefix }}">{{ $value->Detail_Prefix }}</option>
													@endforeach
													<option value="อื่น ๆ">อื่น ๆ</option>
												</select>
												<span class="floating-label text-danger">คำนำหน้า</span>
											</div>
										</div>
										<div class="col-6 col-sm-3 my-2">
											<div class="input-bx">
												<input type="text" class="form-control" id="PrefixOther" name="PrefixOther" data-bs-toggle="tooltip" title="อื่่น ๆ (ระบุ)" placeholder=" " readonly />
												<span>ระบุ</span>
											</div>
										</div>
									</div>
									<div class="row g-2 align-self-center">
										<div class="col-sm my-2">
											<div class="input-bx">
												<input type="text" name="Firstname_Cus" id="Firstname_Cus" class="form-control" placeholder=" " required />
												<span class="text-danger">ชื่อจริง</span>
											</div>
										</div>
										<div class="col-sm-5 my-2 col-input-surname">
											<div class="input-bx">
												<input type="text" name="Surname_Cus" id="Surname_Cus" class="form-control" placeholder=" " />
												<span>นามสกุล</span>
											</div>
										</div>
										<div class="col-sm-3 my-2 col-input-nickname">
											<div class="input-bx">
												<input type="text" name="Nickname_cus" id="Nickname_cus" class="form-control" placeholder=" " />
												<span>ชื่อเล่น</span>
											</div>
										</div>
									</div>
									<div class="row g-2 align-self-center">
										<div class="col-sm my-2">
											<div class="input-bx">
												<input type="text" name="NameEng_cus" id="NameEng_cus" class="form-control" placeholder=" " />
												<span>ชื่อภาษาอังกฤษ</span>
											</div>
										</div>

										<!--
											<div class="col-sm-6 my-2">
												<div class="input-bx">
													<input type="text" name="Phone_cus" id="Phone_cus" class="form-control rounded-0 rounded-start input-mask" data-inputmask="'mask': '999-9999999,999-9999999'" id="Phone_cus" name="Phone_cus" placeholder=" " data-bs-toggle="tooltip" title="เบอร์ติดต่อ" required />
													<span class="text-danger">เบอร์ติดต่อ</span>
													<button class="mx-0 btn btn-light rounded-0 rounded-end border border-secondary border-opacity-50 border-start-0 disabled d-flex align-items-center">
														<i class="fas fa-phone"></i>
													</button>
												</div>
											</div>
											
											<div class="col-sm-6 my-2">
												<div class="input-bx">
													<input type="text" name="Phone_cus" id="Phone_cus" class="form-control rounded-0 rounded-start input-mask" data-inputmask="'mask': '999-9999999'" name="Phone_cus" placeholder=" " data-bs-toggle="tooltip" title="เบอร์ติดต่อ 1" required />

													<input type="text" name="Phone_cus_2" id="Phone_cus_2" class="form-control rounded-0 input-mask border-start-0" data-inputmask="'mask': '999-9999999'" placeholder=" " data-bs-toggle="tooltip" title="เบอร์ติดต่อ 2"/>

													<span class="text-danger">เบอร์ติดต่อ</span>
													<button class="mx-0 btn btn-light rounded-0 rounded-end border border-secondary border-opacity-50 border-start-0 disabled d-flex align-items-center">
														<i class="fas fa-phone"></i>
													</button>
												</div>
											</div>
											-->

										<div class="col-sm my-2">
											<div class="input-bx">
												<input type="text" id="Phone_cus" class="form-control input-mask" data-inputmask="'mask': '999-9999999'" name="Phone_cus" placeholder=" " data-bs-toggle="tooltip" title="เบอร์ติดต่อ 1" required autocomplete="off" />
												<span class="text-danger">เบอร์ติดต่อ 1</span>
											</div>
											<div class="row align-items-start">
												<span id="PhoneSuccess" class="text-success fw-bold small col-12" style="display: none;">
													<i class="fa fa-check"></i>
													สามารถใช้เบอร์โทรนี้ได้
												</span>
												<span id="PhoneError" class="text-danger fw-bold small col-12" style="display: none;">
													<i class="fa fa-times"></i>
													เบอร์โทรนี้มีในระบบแล้ว
												</span>
												<span id="PhoneLoading" class="text-muted fw-bold small col-12" style="display: none;">
													<div class="spinner-border spinner-border-sm" style="--bs-spinner-width: 0.75rem; --bs-spinner-height: 0.75rem;" role="status">
														<span class="visually-hidden">Loading...</span>
													</div>
													กำลังตรวจสอบ...
												</span>
											</div>
										</div>

										<div class="col-sm my-2">
											<div class="input-bx">
												<input type="text" name="Phone_cus2" id="Phone_cus2" class="form-control input-mask" data-inputmask="'mask': '999-9999999'" placeholder=" " data-bs-toggle="tooltip" title="เบอร์ติดต่อ 2" autocomplete="off" />
												<span class="">เบอร์ติดต่อ 2</span>
											</div>
										</div>

									</div>
								</div>
								<!-- ข้อมูลเลขบัตร -->
								<div class="p-0 pt-2 pb-sm-4 p-xl-4 pt-xl-0 pb-md-4">
									<div class="row g-2 align-self-center mb-1">
										<div class="col-sm col-md col-lg-6 col-xl-6 mt-2" id="StatusCom_show" style="display:none;">
											<div class="input-bx">
												<select id="Status_Com" name="Status_Com" class="form-select" data-bs-toggle="tooltip" title="ประเภทบริษัท">
													<option value="" selected>-- ประเภทบริษัท --</option>
													<option value="IN">บริษัทในเครือชูเกิยรติ</option>
													<option value="OUT">บริษัทนอกสังกัด</option>
												</select>
												<span class="floating-label">ประเภทบริษัท</span>
											</div>
										</div>
										<div class="col-sm col-md col-lg-6 col-xl-6 mt-2" id="branch_show" style="display:none;">
											<div class="input-bx">
												<input type="number" name="Branch_id" id="Branch_id" class="form-control" value="0">
												<span>สาขา</span>
											</div>
										</div>
									</div>
									<div class="row g-2 align-self-center">
										<div class="col-sm col-md col-lg col-xl-6 mt-2">
											<input type="hidden" id="dataCon" value="">
											<input type="hidden" id="userRole" value="">
											<div class="input-bx">
												<input type="text" id="IDCard_cus" name="IDCard_cus" class="form-control input-mask rounded-0 rounded-start" data-inputmask="'mask': '9-9999-99999-99-9'" data-bs-toggle="tooltip" title="เลขบัตรประชาชน" placeholder=" " data-checkedvalue="" data-checkingvalue="" data-fail="true" autocomplete="off" />
												<span>เลขบัตร</span>
												<button class="mx-0 btn btn-light border border-secondary border-opacity-50 border-start-0 rounded-0 rounded-end disabled d-flex align-items-center">
													<i class="fas fa-id-card"></i>
												</button>
												<button id="ProgressIdCard" class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled bg-info text-white" style="opacity: 1; display: none;">
													<div class="spinner-border spinner-border-sm" role="status">
														<span class="visually-hidden">Loading...</span>
													</div>
												</button>
												<button id="PassIdCard" class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled bg-success text-white" style="opacity:1; display: none">
													<i class="fa fa-check"></i>
												</button>
												<button id="FailIdCard" class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled bg-danger text-white rounded-2" style="opacity:1; display: none">
													<i class="fa fa-times"></i>
												</button>
											</div>

											<div class="Show-alert form-group row mb-0" style="display:none;">
												<div class="col text-center">
													<div class="input-group d-flex justify-content-center">
														<span class="error text-danger"></span>
													</div>
												</div>
											</div>
										</div>
										<div class="col-sm col-md col-lg col-xl-6 mt-2" id="IdcardExpire_datepicker">
											<div class="input-bx">
												<input type="text" name="IdcardExpire_cus" id="IdcardExpire_cus" class="form-control rounded-0 rounded-start" placeholder=" " data-date-format="dd/mm/yyyy" data-date-container="#IdcardExpire_datepicker" data-provide="datepicker" data-date-autoclose="true" data-date-disable-touch-keyboard="true" data-date-language="th" data-date-today-highlight="true" data-date-enable-on-readonly="true" data-date-clear-btn="true" data-date-orientation="auto" data-bs-toggle="tooltip" data-bs-placement="top" title="วันหมดอายุบัตร (ปี ค.ศ.)" readonly autocomplete="off" required>
												<span>บัตรหมดอายุ</span>
												<button class="btn btn-outline-primary rounded-0 rounded-end d-flex align-items-center openDatepickerBtn" type="button">
													<i class="fas fa-calendar-alt"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
								<!-- ข้อมูลส่วนตัว -->
								<div class="p-0 pt-2 pb-sm-4 p-xl-4 pt-xl-2 pb-md-4">
									<div class="row g-2 align-self-center">
										<div class="col-6 col-sm-4 col-lg-3 col-xl-4 mt-2" id="Birthday_datepicker">
											<div class="input-bx">
												<input type="text" name="Birthday_cus" id="Birthday_cus" class="form-control rounded-0 rounded-start Birthday_cus" placeholder=" " data-date-format="dd/mm/yyyy" data-date-container="#Birthday_datepicker" data-provide="datepicker" data-date-autoclose="true" data-date-disable-touch-keyboard="true" data-date-language="th" data-date-today-highlight="true" data-date-enable-on-readonly="true" data-date-clear-btn="true" data-date-end-date="0d" data-date-orientation="top left" data-bs-toggle="tooltip" data-bs-placement="bottom" title="วันเดือนปีเกิด (ปี ค.ศ.)" readonly autocomplete="off" required>
												<span>วันเดือนปีเกิด</span>
												<button class="btn btn-outline-primary rounded-0 rounded-end d-flex align-items-center openDatepickerBtn" type="button">
													<i class="fas fa-calendar-alt"></i>
												</button>
											</div>
										</div>
										<div class="col-6 col-sm-4 col-lg-2 col-xl-4 mt-2">
											<div class="input-bx">
												<input type="text" name="display_age" id="display_age" class="form-control rounded-0 rounded-start" placeholder=" " data-bs-toggle="tooltip" title="อายุ (ปี)" readonly />
												<span>อายุ</span>
												<button class="mx-0 btn btn-light rounded-0 rounded-end border border-secondary border-opacity-50 border-start-0 disabled d-flex align-items-center">
													ปี
												</button>
											</div>
										</div>
										<div class="col-6 col-sm-4 col-lg-2 col-xl-4 mt-2">
											<select id="Gender_cus" name="Gender_cus" class="form-select" data-bs-toggle="tooltip" title="เพศ">
												<option value="" selected>-- เพศ --</option>
												<option value="ชาย">ชาย</option>
												<option value="หญิง">หญิง</option>
											</select>
										</div>
										<div class="col-6 col-sm-4 col-lg-2 col-xl-4 mt-2">
											<select id="Nationality_cus" name="Nationality_cus" class="form-select" data-bs-toggle="tooltip" title="สัญชาติ">
												<option value="" selected>-- สัญชาติ --</option>
												<option value="ไทย">ไทย</option>
											</select>
										</div>
										<div class="col-6 col-sm-4 col-lg-3 col-xl-4 mt-2">
											<select id="Religion_cus" name="Religion_cus" class="form-select" data-bs-toggle="tooltip" title="ศาสนา">
												<option value="" selected>-- ศาสนา --</option>
												<option value="อิสลาม">อิสลาม</option>
												<option value="พุทธ">พุทธ</option>
												<option value="คริสต์">คริสต์</option>
												<option value="อื่นๆ">อื่นๆ</option>
											</select>
										</div>
										<div class="col-6 col-sm-4 col-lg-3 col-xl-4 mt-2">
											<select id="Driver_cus" name="Driver_cus" class="form-select" data-bs-toggle="tooltip" title="ใบขับบี่">
												<option value="" selected>-- ใบขับขี่ --</option>
												<option value="มี">มี</option>
												<option value="ไม่มี">ไม่มี</option>
											</select>
										</div>
										<div class="col-12 col-sm-4 col-lg-3 col-xl-4 mt-2">
											<select id="Namechange_cus" name="Namechange_cus" class="form-select" data-bs-toggle="tooltip" title="ประวัติเปลี่ยนชื่อ">
												<option value="" selected>-- ประวัติเปลี่ยนชื่อ --</option>
												<option value="ไม่เคยเปลี่ยนชื่อและนามสกุล">ไม่เคยเปลี่ยนชื่อและนามสกุล</option>
												<option value="มีการเปลี่ยนชื่อ">มีการเปลี่ยนชื่อ</option>
												<option value="มีการเปลี่ยนนามสกุล">มีการเปลี่ยนนามสกุล</option>
												<option value="มีการเปลี่ยนทั้งชื่อและนามสกุล">มีการเปลี่ยนทั้งชื่อและนามสกุล</option>
											</select>
										</div>
										<div class="col-6 col-sm-4 col-lg-3 col-xl-4 mt-2">
											<div class="input-bx">
												<input type="text" id="Social_facebook" name="Social_facebook" class="form-control rounded-0 rounded-start" placeholder=" " />
												<span>Facebook</span>
												<button class="mx-0 btn btn-light rounded-0 rounded-end border border-secondary border-opacity-50 border-start-0 p-0 px-2 disabled d-flex align-items-center">
													<i class="bx bxl-facebook-square fs-4 text-primary"></i>
												</button>
											</div>
										</div>
										<div class="col-6 col-sm-4 col-lg-3 col-xl-4 mt-2">
											<div class="input-bx">
												<input type="text" id="Social_Line" name="Social_Line" class="form-control rounded-0 rounded-start" placeholder=" " />
												<span>Line ID</span>
												<button class="mx-0 btn btn-light rounded-0 rounded-end border border-secondary border-opacity-50 p-0 px-2 border-start-0 disabled d-flex align-items-center">
													<i class="fab fa-line fa-line fs-4 text-success"></i>
												</button>
											</div>
										</div>
									</div>

								</div>
							</div>
							<!-- คอลัมน์ฝั่งขวา -->
							<div class="col-12 col-lg-12 col-xl-6">
								<!-- ข้อมูลคู่สมรส -->
								<div class="p-0 pt-md-4 py-sm-4 p-xl-4 pt-xl-0 pb-md-4 ">
									<div class="row g-2 align-self-center">
										<div class="col-sm-auto col-md col-xl-12 mt-2">
											<label class="visually-hidden" for="Marital_cus">สถานะสมรส</label>
											<select id="Marital_cus" name="Marital_cus" class="form-select">
												<option value="" selected>-- สถานะสมรส --</option>
												<option value="โสด">โสด</option>
												<option value="สมรสจดทะเบียน">สมรสจดทะเบียน</option>
												<option value="สมรสไม่จดทะเบียน">สมรสไม่จดทะเบียน</option>
												<option value="หย่าร้าง">หย่าร้าง</option>
												<option value="หม้าย">หม้าย</option>
											</select>
										</div>
										<div class="col-sm col-md col-lg col-xl-6 mt-2">
											<div class="input-bx">
												<input type="text" class="form-control" id="Mate_cus" name="Mate_cus" data-bs-toggle="tooltip" title="คู่สมรส" placeholder=" " readonly />
												<span>ชื่อนามสกุลคู่สมรส</span>
											</div>
										</div>
										<div class="col-sm col-md col-lg col-xl mt-2">
											<div class="input-bx">
												<input type="text" class="form-control rounded-0 rounded-start input-mask" data-inputmask="'mask': '999-999-9999'" name="Mate_Phone" id="Mate_Phone" data-bs-toggle="tooltip" title="เบอร์โทรคู่สมรส" placeholder=" " readonly />
												<span>เบอร์โทรคู่สมรส</span>
												<button class="mx-0 btn btn-light rounded-0 rounded-end border border-secondary border-opacity-50 border-start-0 disabled d-flex align-items-center">
													<i class="fas fa-phone"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
								<!-- ข้อมูลการเงิน -->
								<div class="p-0 pt-2 pb-sm-4 p-xl-4 pt-xl-0 pb-md-4">
									<div class="row g-2 align-self-center mb-2">
										<div class="col-sm-auto col-md col-xl-12 mt-2">
											<label class="visually-hidden" for="Name_Account">ธนาคาร</label>
											<select id="Name_Account" name="Name_Account" class="form-select">
												<option value="" selected>-- ธนาคาร --</option>
												@foreach ($NameAccount as $value)
													<option value="{{ $value->Bank_name }}">{{ $value->Bank_name }}</option>
												@endforeach
											</select>
										</div>
										<div class="col-sm col-md col-lg col-xl-6 mt-2">
											<div class="input-bx">
												<input type="text" class="form-control" id="Branch_Account" name="Branch_Account" data-bs-toggle="tooltip" title="สาขา" placeholder=" " />
												<span>สาขา</span>
											</div>
										</div>
										<div class="col-sm col-md col-lg col-xl mt-2">
											<div class="input-bx">
												<input type="text" class="form-control" id="Number_Account" name="Number_Account" data-bs-toggle="tooltip" title="เลขบัญชี" placeholder=" " autocomplete="off" />
												<span>เลขบัญชี</span>
											</div>
										</div>
									</div>
									@hasrole(['administrator', 'superadmin'])
										<div class="row g-2 align-self-center ">
											<div class="col-sm col-md col-lg col-xl-6 mt-2">
												<div class="input-group">
													<label class="visually-hidden " for="Marital_cus">zone</label>
													<select id="zone_cus" name="zone_cus" class="form-select border-danger zone_input rounded-start" data-bs-toggle="tooltip" title="zone" required>
														<option value="" selected>--- zone ---</option>
														@foreach ($TBZone as $zone)
															<option value="{{ $zone->Zone_Code }}">({{ $zone->Zone_Code }}) - {{ $zone->Zone_Name }}</option>
														@endforeach
													</select>
													<button class="mx-0 btn btn-light rounded-0 rounded-end border border-secondary border-opacity-50 border-start-0 disabled d-flex align-items-center">
														<span class="addSpinZone"><i class="bx bxs-map-pin"></i></span>
													</button>
												</div>
											</div>
											<div class="col-sm col-md col-lg col-xl mt-2">
												<label class="visually-hidden " for="Marital_cus">สาขาลูกค้า</label>
												<select id="branch_cus" name="branch_cus" class="form-select houseProvince border-danger branch_input" data-bs-toggle="tooltip" title="สาขาลูกค้า" required>
													<option value="" selected>-- สาขาลูกค้า --</option>
												</select>
											</div>
										</div>
									@endhasrole
								</div>
								<!-- ข้อมูลอื่น ๆ -->
								<div class="p-0 pt-3 px-md-4 pt-xl-0">
									<div class="row g-2 align-self-center">
										<div class="col-md-12">
											<div class="form-floating">
												<textarea class="form-control" placeholder="Leave a comment here" name="Note_cus" id="Note_cus" maxlength="65535" style="height: 150px"></textarea>
												<label for="Note_cus" class="fw-bold">หมายเหตุ</label>
											</div>
										</div>
									</div>
									<div class="row g-2 align-self-center"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		@can('create-customer')
			<div class="row justify-content-end">
				<div class="col d-flex justify-content-end">
					<button type="button" class="btn btn-primary waves-effect waves-light hover-up w-md btn_createCus">
						<span class="addSpin"><i class="fas fa-download"></i></span> สร้างลูกค้าใหม่
					</button>
				</div>
			</div>
		@endcan
	</form>

	@include('frontend.content-cus.script')
	@include('public-js.scriptZoneBranch')

	<script src="{{ URL::asset('assets/js/input-bx-select.js') }}"></script>

@endsection
