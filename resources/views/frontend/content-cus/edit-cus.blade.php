<link rel="stylesheet" href="{{ URL::asset('assets/css/datepicker-custom.css') }}">
<script src="{{ URL::asset('assets/js/input-bx-select.js') }}"></script>

<div class="modal-content">
	<form id="edit_dataCus" class="needs-validation" action="#" novalidate>
		@csrf
		<input type="hidden" name="funs" id="funs" value="{{ @$funs }}">
		<input type="hidden" name="title" value="{{ @$title }}">
		<input type="hidden" name="id" value="{{ @$data['id'] }}">
		<input type="hidden" name="page" value="profile-cus">

		<div class="modal-body">
			<div class="d-flex m-3 mb-0">
				<div class="flex-shrink-0 me-2">
					<img src="{{ asset('assets/images/gif/avatar.gif') }}" alt="" class="avatar-sm">
				</div>
				<div class="flex-grow-1 overflow-hidden">
					<h5 class="text-primary fw-semibold">{{ @$title }}</h5>
					{{-- <p class="text-muted mt-n1 fw-semibold  font-size-12">รหัสลูกค้า : {{ @$data->Code_Cus }}.</p> --}}
					<p class="text-muted mt-n1 fw-semibold font-size-12">{{ @$sub_topic }}</p>
					<p class="border-primary border-bottom mt-n2"></p>
				</div>
				<button type="button" class="btn-close btn-disabled" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<div class="row">
				<!-- คอลัมน์ฝั่งซ้าย -->
				<div class="col-12 col-lg-12 col-xl-6">
					<!-- ข้อมูลติดต่อ -->
					<div class="p-0 p-xl-4 pt-xl-2 pt-lg-2 pt-md-0 py-sm-4">
						<div class="row g-2 align-self-center">
							<div class="col-sm-auto col-md col-xl-12 mt-2">
								<select class="form-select" id="Type_Card" name="Type_Card" data-bs-toggle="tooltip" title="ชนิดเลขบัตรที่ใช้">
									<option value="" selected>-- ชนิดบัตร --</option>
									@foreach (@$TypeCard as $value)
										<option value="{{ $value->Code }}" {{ @$data['Type_Card'] == $value->Code ? 'selected' : '' }}>{{ $value->Detail_Card }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-6 col-sm-auto my-2">
								<label class="visually-hidden" for="autoSizingSelect">Preference</label>
								<div class="input-bx">
									<select @class(['form-select', 'has-value' => !empty(@$data['Prefix'])]) id="Prefix" name="Prefix" required>
										<option value="" selected>-- คำนำหน้า --</option>
										@foreach (@$TBPrefix as $value)
											<option value="{{ $value->Detail_Prefix }}" {{ $value->Detail_Prefix == @$data['Prefix'] ? 'selected' : '' }}>{{ $value->Detail_Prefix }}</option>
										@endforeach
										<option value="อื่น ๆ" {{ @$data['Prefix'] == 'อื่น ๆ' ? 'selected' : '' }}>อื่น ๆ</option>
									</select>
									<span class="floating-label text-danger">คำนำหน้า</span>
								</div>
							</div>
							<div class="col-6 col-sm-3 my-2">
								<div class="input-bx">
									<input type="text" class="form-control" id="PrefixOther" name="PrefixOther" data-bs-toggle="tooltip" title="อื่่น ๆ (ระบุ)" placeholder=" " @readonly(@$data['Prefix'] != 'อื่น ๆ') @required(@$data['Prefix'] == 'อื่น ๆ') />
									<span @class(['text-danger' => @$data['Prefix'] == 'อื่น ๆ'])>ระบุ</span>
								</div>
							</div>
						</div>
						<div class="row g-2 align-self-center">
							<div class="col-sm my-2">
								<div class="input-bx">
									<input type="text" class="form-control" id="Firstname_Cus" name="Firstname_Cus" value="{{ @$data['Firstname_Cus'] }}" data-bs-toggle="tooltip" title="ชื่อจริง" placeholder=" " />
									<span class="text-danger">ชื่อจริง</span>
								</div>
							</div>
							<div class="col-sm-5 my-2 col-input-surname" @style(['display: none;' => @$data['Type_Card'] == '324003'])>
								<div class="input-bx">
									<input type="text" class="form-control" id="Surname_Cus" name="Surname_Cus" value="{{ @$data['Surname_Cus'] }}" data-bs-toggle="tooltip" title="นามสกุล" placeholder=" " @readonly(@$data['Type_Card'] == '324003') />
									<span>นามสกุล</span>
								</div>
							</div>
							<div class="col-sm-3 my-2 col-input-nickname" @style(['display: none;' => @$data['Type_Card'] == '324003'])>
								<div class="input-bx">
									<input type="text" class="form-control" id="Nickname_cus" name="Nickname_cus" value="{{ @$data['Nickname_cus'] }}" data-bs-toggle="tooltip" title="ชื่อเล่น" placeholder=" " @readonly(@$data['Type_Card'] == '324003') />
									<span>ชื่อเล่น</span>
								</div>
							</div>
						</div>
						<div class="row g-2 align-self-center">
							<div class="col-sm my-2">
								<div class="input-bx">
									<input type="text" class="form-control" id="NameEng_cus" name="NameEng_cus" value="{{ @$data['NameEng_cus'] }}" data-bs-toggle="tooltip" title="ชื่อภาษาอังกฤษ" placeholder=" " />
									<span>ชื่อภาษาอังกฤษ</span>
								</div>
							</div>
							{{-- 
							<div class="col-sm-6 my-2">
								<div class="input-bx">
									<input type="text" class="form-control input-mask" data-inputmask="'mask': '999-9999999,999-9999999'" id="Phone_cus" name="Phone_cus" value="{{ @$data['Phone_cus'] }}" placeholder=" " data-bs-toggle="tooltip" title="เบอร์ติดต่อ" />
									<span class="text-danger">เบอร์ติดต่อ</span>
									<button class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled d-flex align-items-center">
										<i class="fas fa-phone"></i>
									</button>
								</div>
							</div>
							--}}
							<div class="col-sm my-2">

								<div class="input-bx">
									<input type="text" class="form-control input-mask" data-inputmask="'mask': '999-9999999'" id="Phone_cus" name="Phone_cus" value="{{ @$data['Phone_cus'] }}" placeholder=" " data-bs-toggle="tooltip" title="เบอร์ติดต่อ 1"/>
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
								@php
									$phone_cus_2 = "";
                                    if ( empty(@$data['Phone_cus2']) ) {
										$_phone_numbers = explode(',', @$data['Phone_cus']);
										if ( isset($_phone_numbers[1]) ) {
											$phone_cus_2 = $_phone_numbers[1];
										}
									} else {
										$phone_cus_2 = @$data['Phone_cus2'];
									}
								@endphp
								<div class="input-bx">
									<input type="text" class="form-control input-mask" data-inputmask="'mask': '999-9999999'" id="Phone_cus2" name="Phone_cus2" value="{{ @$phone_cus_2 }}" placeholder=" " data-bs-toggle="tooltip" title="เบอร์ติดต่อ 2" autocomplete="off"/>
									<span class="">เบอร์ติดต่อ 2</span>
								</div>
							</div>

						</div>
					</div>
					<!-- ข้อมูลเลขบัตร -->
					<div class="p-0 pt-2 pb-sm-4 p-xl-4 pt-xl-0 pb-md-4">
						<div class="row g-2 align-self-center">
							<div class="col-sm col-md col-lg col-xl my-2" id="branch_show" style="display:none;">
								<div class="input-bx">
									<input type="number" name="Branch_id" id="Branch_id" class="form-control" value="{{ @$data['Branch_id'] != null ? @$data['Branch_id'] : 0 }}">
									<span>สาขา</span>
								</div>
							</div>
							<div class="col-sm col-md col-lg col-xl my-2" id="StatusCom_show" style="display:none;">
								<div class="input-bx">
									<select id="Status_Com" name="Status_Com" @class(['form-select', 'has-value' => !empty(@$data['Status_Com'])]) data-bs-toggle="tooltip" title="ประเภทบริษัท">
										<option value="" selected>-- ประเภทบริษัท --</option>
										<option value="IN" {{ @$data['Status_Com'] == 'IN' ? 'selected' : '' }}>บริษัทในเครือชูเกิยรติ</option>
										<option value="OUT" {{ @$data['Status_Com'] == 'OUT' ? 'selected' : '' }}>บริษัทนอกสังกัด</option>
									</select>
									<span class="floating-label">ประเภทบริษัท</span>
								</div>
							</div>
						</div>
						<div class="row g-2 align-self-center">
							<div class="col-sm col-md col-lg col-xl-6 mt-2">

								@if (@$data->is_can_edit_idcard() === false)
									<span class="position-absolute top-50 start-0 translate-middle text-danger" style="z-index: 1;" data-bs-toggle="tooltip" title="ไม่สามารถแก้ไขได้ เนื่องจากมีความเกี่ยวข้องกับสัญญาที่โอนเงินแล้ว">
										<i class="fas fa-exclamation-circle fs-5"></i>
										<span class="visually-hidden">Alerts</span>
									</span>
								@endif

								<div class="input-bx">
									<input type="text" id="IDCard_cus" name="IDCard_cus" class="form-control input-mask" data-inputmask="'mask': '9-9999-99999-99-9'" data-bs-toggle="tooltip" title="เลขบัตรประชาชน" placeholder=" " value="{{ @$data['IDCard_cus'] }}" data-originalvalue="{{ @$data['IDCard_cus'] }}" data-checkedvalue="{{ @$data['IDCard_cus'] }}" data-checkingvalue="" data-fail="{{ empty(@$data['IDCard_cus']) ? 'true' : 'false' }}" @readonly(@$data->is_can_edit_idcard() === false) />
									<span>เลขบัตร</span>
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
											<span class="error"></span>
										</div>
									</div>
								</div>

							</div>
							<div class="col-sm col-md col-lg col-xl mt-2" id="IdcardExpire_datepicker">
								<div class="input-bx">
									<input type="text" name="IdcardExpire_cus" id="IdcardExpire_cus" class="form-control rounded-0 rounded-start" placeholder=" " data-date-format="dd/mm/yyyy" data-date-container="#IdcardExpire_datepicker" data-provide="datepicker" data-date-autoclose="true" data-date-disable-touch-keyboard="true" data-date-language="th" data-date-today-highlight="true" data-date-enable-on-readonly="true" data-date-clear-btn="true" data-date-orientation="top" data-bs-toggle="tooltip" data-bs-placement="bottom" title="วันหมดอายุบัตร (ปี ค.ศ.)" readonly autocomplete="off" value="{{ !empty(@$data['IdcardExpire_cus']) ? convertDatePHPToHuman($data['IdcardExpire_cus']) : '' }}">
									<span>บัตรหมดอายุ</span>
									<button class="btn btn-outline-primary rounded-end d-flex align-items-center openDatepickerBtn rounded-0 rounded-end" type="button">
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
									<div class="input-bx">
										<input type="text" name="Birthday_cus" id="Birthday_cus" class="form-control Birthday_cus rounded-0 rounded-start" placeholder=" " data-date-format="dd/mm/yyyy" data-date-container="#Birthday_datepicker" data-provide="datepicker" data-date-autoclose="true" data-date-disable-touch-keyboard="true" data-date-language="th" data-date-today-highlight="true" data-date-enable-on-readonly="true" data-date-clear-btn="true" data-date-end-date="0d" data-date-orientation="top" data-bs-toggle="tooltip" data-bs-placement="bottom" title="วันเดือนปีเกิด (ปี ค.ศ.)" readonly autocomplete="off" required value="{{ !empty(@$data['Birthday_cus']) ? convertDatePHPToHuman($data['Birthday_cus']) : '' }}">
										<span>วันเดือนปีเกิด</span>
										<button class="btn btn-outline-primary rounded-end d-flex align-items-center openDatepickerBtn rounded-0 rounded-end" type="button">
											<i class="fas fa-calendar-alt"></i>
										</button>
									</div>
								</div>
							</div>
							<div class="col-6 col-sm-4 col-lg-2 col-xl-4 mt-2">
								<div class="input-bx">
									<input type="text" name="display_age" id="display_age" class="form-control rounded-0 rounded-start" placeholder=" " data-bs-toggle="tooltip" title="อายุ (ปี)" disabled value="{{ !empty(@$data['Birthday_cus']) ? calculateAge($data['Birthday_cus']) : '' }}" />
									<span>อายุ</span>
									<button class="mx-0 btn btn-light border border-secondary border-opacity-50 border-start-0 rounded-0 rounded-end disabled d-flex align-items-center">
										ปี
									</button>
								</div>
							</div>
							<div class="col-6 col-sm-4 col-lg-2 col-xl-4 mt-2">
								<select id="Gender_cus" name="Gender_cus" class="form-select" data-bs-toggle="tooltip" title="เพศ">
									<option value="" selected>-- เพศ --</option>
									<option value="ชาย" {{ @$data['Gender_cus'] == 'ชาย' ? 'selected' : '' }}>ชาย</option>
									<option value="หญิง" {{ @$data['Gender_cus'] == 'หญิง' ? 'selected' : '' }}>หญิง</option>
								</select>
							</div>
							<div class="col-6 col-sm-4 col-lg-2 col-xl-4 mt-2">
								<select id="Nationality_cus" name="Nationality_cus" class="form-select" data-bs-toggle="tooltip" title="สัญชาติ">
									<option value="" selected>-- สัญชาติ --</option>
									<option value="ไทย" {{ @$data['Nationality_cus'] == 'ไทย' ? 'selected' : '' }}>ไทย</option>
								</select>
							</div>
							<div class="col-6 col-sm-4 col-lg-3 col-xl-4 mt-2">
								<select id="Religion_cus" name="Religion_cus" class="form-select" data-bs-toggle="tooltip" title="ศาสนา">
									<option value="" selected>-- ศาสนา --</option>
									<option value="อิสลาม" {{ @$data['Religion_cus'] == 'อิสลาม' ? 'selected' : '' }}>อิสลาม</option>
									<option value="พุทธ" {{ @$data['Religion_cus'] == 'พุทธ' ? 'selected' : '' }}>พุทธ</option>
									<option value="คริสต์" {{ @$data['Religion_cus'] == 'คริสต์' ? 'selected' : '' }}>คริสต์</option>
									<option value="อื่นๆ" {{ @$data['Religion_cus'] == 'อื่นๆ' ? 'selected' : '' }}>อื่นๆ</option>
								</select>
							</div>
							<div class="col-6 col-sm-4 col-lg-3 col-xl-4 mt-2">
								<select id="Driver_cus" name="Driver_cus" class="form-select" data-bs-toggle="tooltip" title="ใบขับบี่">
									<option value="" selected>-- ใบขับขี่ --</option>
									<option value="มี" {{ @$data['Driver_cus'] == 'มี' ? 'selected' : '' }}>มี</option>
									<option value="ไม่มี" {{ @$data['Driver_cus'] == 'ไม่มี' ? 'selected' : '' }}>ไม่มี</option>
								</select>
							</div>
							<div class="col-12 col-sm-4 col-lg-3 col-xl-4 mt-2">
								<select id="Namechange_cus" name="Namechange_cus" class="form-select" data-bs-toggle="tooltip" title="ประวัติเปลี่ยนชื่อ">
									<option value="" selected>-- ประวัติเปลี่ยนชื่อ --</option>
									<option value="ไม่เคยเปลี่ยนชื่อและนามสกุล" {{ @$data['Namechange_cus'] == 'ไม่เคยเปลี่ยนชื่อและนามสกุล' ? 'selected' : '' }}>ไม่เคยเปลี่ยนชื่อและนามสกุล</option>
									<option value="มีการเปลี่ยนชื่อ" {{ @$data['Namechange_cus'] == 'มีการเปลี่ยนชื่อ' ? 'selected' : '' }}>มีการเปลี่ยนชื่อ</option>
									<option value="มีการเปลี่ยนนามสกุล" {{ @$data['Namechange_cus'] == 'มีการเปลี่ยนนามสกุล' ? 'selected' : '' }}>มีการเปลี่ยนนามสกุล</option>
									<option value="มีการเปลี่ยนทั้งชื่อและนามสกุล" {{ @$data['Namechange_cus'] == 'มีการเปลี่ยนทั้งชื่อและนามสกุล' ? 'selected' : '' }}>มีการเปลี่ยนทั้งชื่อและนามสกุล</option>
								</select>
							</div>
							<div class="col-6 col-sm-4 col-lg-3 col-xl-4 mt-2">
								<div class="input-bx">
									<input type="text" name="Social_facebook" id="Social_facebook" value="{{ @$data['Social_facebook'] }}" class="form-control rounded-0 rounded-start" data-bs-toggle="tooltip" title="Facebook" placeholder=" " />
									<span>Facebook</span>
									<button class="mx-0 btn btn-light border border-secondary border-opacity-50 border-start-0 rounded-0 rounded-end p-0 px-2 disabled d-flex align-items-center">
										<i class="bx bxl-facebook-square fs-4 text-primary"></i>
									</button>
								</div>
							</div>
							<div class="col-6 col-sm-4 col-lg-3 col-xl-4 mt-2">
								<div class="input-bx">
									<input type="text" name="Social_Line" id="Social_Line" value="{{ @$data['Social_Line'] }}" class="form-control rounded-0 rounded-start" data-bs-toggle="tooltip" title="Line ID" placeholder=" " />
									<span>Line ID</span>
									<button class="mx-0 btn btn-light border border-secondary border-opacity-50 border-start-0 rounded-0 rounded-end p-0 px-2 disabled d-flex align-items-center">
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
					<div class="p-0 pt-md-4 py-sm-4 p-xl-4 pt-xl-3 pb-md-4 ">
						<div class="row g-2 align-self-center">
							<div class="col-sm-auto col-md col-xl-12 mt-2">
								<label class="visually-hidden" for="Marital_cus">สถานะสมรส</label>
								<select id="Marital_cus" name="Marital_cus" class="form-select">
									<option value="" selected>-- สถานะสมรส --</option>
									<option value="โสด" {{ @$data['Marital_cus'] == 'โสด' ? 'selected' : '' }}>โสด</option>
									<option value="สมรสจดทะเบียน" {{ @$data['Marital_cus'] == 'สมรสจดทะเบียน' ? 'selected' : '' }}>สมรสจดทะเบียน</option>
									<option value="สมรสไม่จดทะเบียน" {{ @$data['Marital_cus'] == 'สมรสไม่จดทะเบียน' ? 'selected' : '' }}>สมรสไม่จดทะเบียน</option>
									<option value="หย่าร้าง" {{ @$data['Marital_cus'] == 'หย่าร้าง' ? 'selected' : '' }}>หย่าร้าง</option>
									<option value="หม้าย" {{ @$data['Marital_cus'] == 'หม้าย' ? 'selected' : '' }}>หม้าย</option>
								</select>
							</div>
							<div class="col-sm col-md col-lg col-xl-6 mt-2">
								<div class="input-bx">
									<input type="text" name="Mate_cus" id="Mate_cus" value="{{ @$data['Mate_cus'] }}" class="form-control" data-bs-toggle="tooltip" title="คู่สมรส" placeholder=" " {{ str_contains(@$data['Marital_cus'], 'สมรส') ? '' : 'readonly' }}>
									<span>ชื่อนามสกุลคู่สมรส</span>
								</div>
							</div>
							<div class="col-sm col-md col-lg col-xl mt-2">
								<div class="input-bx">
									<input type="text" name="Mate_Phone" id="Mate_Phone" value="{{ @$data['Mate_Phone'] }}" class="form-control input-mask rounded-0 rounded-start" data-inputmask="'mask': '999-999-9999'" data-bs-toggle="tooltip" title="เบอร์โทรคู่สมรส" placeholder=" " {{ str_contains(@$data['Marital_cus'], 'สมรส') ? '' : 'readonly' }}>
									<span>เบอร์โทรคู่สมรส</span>
									<button class="mx-0 btn btn-light border border-secondary border-opacity-50 border-start-0 rounded-0 rounded-end disabled d-flex align-items-center">
										<i class="fas fa-phone"></i>
									</button>
								</div>
							</div>
						</div>
					</div>
					<!-- ข้อมูลการเงิน -->
					<div class="p-0 pt-2 pb-sm-4 p-xl-4 pt-xl-0 pb-md-4">
						<div class="row g-2 align-self-center">
							<div class="col-sm-auto col-md col-xl-12 mt-2">
								<label class="visually-hidden" for="Name_Account">ธนาคาร</label>
								<select id="Name_Account" name="Name_Account" class="form-select">
									<option value="" selected>-- ธนาคาร --</option>
									@foreach ($NameAccount as $value)
										<option value="{{ $value->Bank_name }}" {{ @$data->Name_Account == $value->Bank_name ? 'selected' : '' }}>{{ $value->Bank_name }}</option>
									@endforeach
								</select>
							</div>
							<div class="col-sm col-md col-lg col-xl-6 mt-2">
								<div class="input-bx">
									<input type="text" class="form-control" id="Branch_Account" name="Branch_Account" value="{{ @$data['Branch_Account'] }}" data-bs-toggle="tooltip" title="สาขา" placeholder=" " />
									<span>สาขา</span>
								</div>
							</div>
							<div class="col-sm col-md col-lg col-xl mt-2">
								<div class="input-bx">
									<input type="text" class="form-control" id="Number_Account" name="Number_Account" value="{{ @$data['Number_Account'] }}" data-bs-toggle="tooltip" title="เลขบัญชี" placeholder=" " />
									<span>เลขบัญชี</span>
								</div>
							</div>
						</div>
						<div class="row g-2 align-self-center">

						</div>
					</div>
					<!-- ข้อมูลอื่น ๆ -->
					<div class="p-0 pb-sm-4 p-xl-4 pt-xl-3 pb-md-4">
						<div class="row g-2 align-self-center">
							<div class="col-md-12">
								<div class="form-floating">
									<textarea class="form-control" placeholder="Leave a comment here" id="Note_cus" name="Note_cus" maxlength="65535" style="height: 170px">{{ @$data['Note_cus'] }}</textarea>
									<label for="Note_cus" class="fw-bold">หมายเหตุ</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="border-top px-xl-5">
				<div class="row pt-3">

					@php
						if (@$data->Status_Cus == 'blacklist') {
						    /*
							if((auth::user()->position!="MANAGER" &&  auth::user()->position!="Admin")){
								$statusChk = "disabled";
							}else{
								$statusChk = "required";
							}
							*/
						    $statusChk = 'required';
						} else {
						    $statusChk = 'required';
						}
					@endphp

					{{-- <div class="col-3">
						<div class="mb-3">
							<label class="fw-semibold text-danger">
								<i class="far fa-user"></i> สถานะลูกค้า
							</label>
							@can('cus-status')
								<select class="form-select border border-2 border-warning" name="Status_Cus" {{ $statusChk }}>
									<option value="">--- สถานะ ---</option>
									<option {{ @$data['Status_Cus'] == 'active' ? 'selected' : '' }} value="active">ใช้งาน</option>
									<option {{ @$data['Status_Cus'] == 'cancel' ? 'selected' : '' }} value="cancel">ยกเลิก</option>
									<option {{ @$data['Status_Cus'] == 'blacklist' ? 'selected' : '' }} value="blacklist">แบล็คลิสต์</option>
								</select>
							@else
								<input type="text" value="{{ @$data['Status_Cus'] }}" name="Status_Cus" class="form-select border border-2 border-warning" readonly>
							@endcan
						</div>
					</div> --}}

					<div class="col-12">
						<div class="mb-3">
							<label class="fw-semibold">
								<i class="fas fa-link"></i> ลิงก์รูปโปรไฟล์ (URL Avatar)
							</label>
							<div class="input-group form-inline gap-1">
								<input type="url" value="{{ @$data['image_cus'] }}" name="LinkUpload_Con" class="form-control url_link_input" placeholder="(https://) Google Drives, One Drives">
								<span class="input-group-append">
									<a href="" target="_blank" rel="noopener noreferrer">
										<button type="button" class="btn btn-outline-primary">
											<i class="fas fa-link" aria-hidden="true"></i>
										</button>
									</a>
								</span>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary btn-sm waves-effect waves-light hover-up btn_editDataCus" data-id="{{ @$data['id'] }}">
				<i class="fas fa-download"></i> บันทึก <span class="addSpin"></span>
			</button>
			<button type="button" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">
				<i class="mdi mdi-close-circle-outline"></i> ปิด
			</button>
		</div>
	</form>
</div>

<script>
	$(document).ready(function() {

		$('.btn_editDataCus').click(function() {
			var dataform = document.querySelectorAll('#edit_dataCus');
			var validate = validateForms(dataform);

			if ($("#IDCard_cus").val() != '' && $("#IDCard_cus").data('fail') == true) {
				Swal.fire({
					icon: 'warning',
					title: 'กรุณาตรวจสอบ',
					text: "กรุณาใส่เลขบัตรประชาชนที่ถูกต้อง",
					confirmButtonText: 'เข้าใจแล้ว',
				});
				return;
			}

			if ($('#Type_Card').val() != '324003') {
				// ถ้า เป็นเลขผูเสียภาษี ไม่ต้องเช็ควันเกิด
				if ($("#Birthday_cus").val() != '') {
					var birthday = $("#Birthday_cus").datepicker("getDate");
					if (birthday != null) {
						var age = moment().diff(birthday, 'years');
						$('#display_age').val(age);
						if (age < 20 || age > 100) {
							Swal.fire({
								icon: 'warning',
								title: 'กรุณาตรวจสอบ',
								html: 'อายุลูกค้าไม่อยู่ในเงื่อนไข <i>(' + age + ' ปี)</i><br><u class="text-danger">วันเดือนปีเกิดต้องเป็นปี <b>ค.ศ.</b> เท่านั้น</u>',
								confirmButtonText: 'เข้าใจแล้ว',
							});
							return;
						}
					}
				}
			}

			if (validate == true) {
				$(this).prop('disabled', true);

				let id = $(this).data('id');
				let funs = $('#funs').val();
				let data = {};
				$("#edit_dataCus").serializeArray().map(function(x) {
					data[x.name] = x.value;
				});
				let _token = $('input[name="_token"]').val();

				let link = "{{ route('cus.update', 'id') }}";
				let url = link.replace('id', id);

				$('<span />', {
					class: "spinner-border spinner-border-sm",
					role: "status"
				}).appendTo(".addSpin");

				$.ajax({
					url: url,
					method: "PUT",
					data: {
						_token: _token,
						funs: funs,
						data: data
					},
					success: function(result) {
						Swal.fire({
							icon: 'success',
							title: 'สำเร็จ!',
							text: result.message,
							showConfirmButton: false,
							timer: 1500
						});
						$('#modal_xl').modal('hide');

						$('#content_cus').html(result.html_card_user);
						$('#card-profile').html(result.html_view_profile);
					},
					error: function(xhr, status, error) {
						$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
						// Get the error message from the response
						var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "ข้อผิดพลาดที่ไม่รู้จัก :'(";
						var errorFile = xhr.responseJSON.file ? xhr.responseJSON.file : '';
						errorFile = errorFile.replace(/^.*[\\\/]/, '');
						var errorLine = xhr.responseJSON.line ? xhr.responseJSON.line : '';
						var errorHtml = "<p>" + errorMessage + "</p>";
						errorHtml += "<p class='m-0 small'>" + errorFile + " <strong>(บรรทัดที่ " + errorLine + ")</strong></p>";
						// Display the error message using SweetAlert2
						Swal.fire({
							icon: 'error',
							title: error,
							html: `<p class="m-0">ขออภัย! เกิดข้อผิดพลาด กดดูเพิ่มเติมเพื่อแสดงรายละเอียด</p><p class="my-1 small">(${status})</p>`,
							showCancelButton: true,
							confirmButtonText: 'ดูเพิ่มเติม',
							cancelButtonText: 'OK'
						}).then((result) => {
							if (result.isConfirmed) {
								// If the user clicks "More Details," show the detailed error message in a new SweetAlert2 modal
								Swal.fire({
									icon: 'error',
									title: 'รายละเอียด',
									//text: errorMessage,
									html: errorHtml,
									confirmButtonText: 'OK'
								});
							}
						});
					},
					complete: function(data) {
						$('.addSpin').empty();
						$('.btn_editDataCus').prop('disabled', false);
					}
				})
			}
		});
	});
</script>

<script>
	$(".url_link_input").on('input blur', function() {
		var link = $(this).val();
		$(this).siblings('span').find('a').attr("href", link);
	})
</script>

@include('frontend.content-cus.script')
