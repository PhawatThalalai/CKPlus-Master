@include('public-js.constants')

<div class="card mb-2">
	<div class="card-header bg-transparent border-bottom">
		<div class="d-flex flex-wrap align-items-end">
			<div class="me-2">
				<h5 class="card-title mt-1 mb-0 font-size-13 text-primary">
					<i class="bx bx-calculator"></i> คำนวณยอดรับชำระ
				</h5>
			</div>
			<div class="btn-group card-header-tabs ms-auto" role="group" aria-label="Basic radio toggle button group">
				{{--
					<input type="radio" class="btn-check btn-typePay" name="btnradio" id="Payment">
					<label class="btn btn-outline-success" for="Payment">ชำระค่างวด</label>
					<input type="radio" class="btn-check btn-typePay" name="btnradio" id="Payother">
					<label class="btn btn-outline-success" for="Payother">ชำระค่าอื่นๆ</label>
				--}}
				<div class="row">
					<div class="col text-end me-2">
						<button type="button" id="Payment" class="btn btn-outline-success rounded-pill btn-typePay">
							ชำระค่างวด <i class="bx bxs-plus-circle"></i>
						</button>
						<button type="button" id="Payother" class="btn btn-outline-success rounded-pill btn-typePay">
							ชำระค่าอื่นๆ <i class="bx bxs-plus-circle"></i>
						</button>
					</div>
				</div>
			</div>

			{{-- <ul class="nav nav-tabs nav-tabs-custom card-header-tabs ms-auto" role="tablist">
					<li class="nav-item" role="presentation">
						<a class="btn btn-success btn-typePay" id="Payment" data-bs-toggle="tab" href="#post-recent" role="tab" aria-selected="true">
							ชำระค่างวด
						</a>
					</li>
					<li class="nav-item" role="presentation">
						<a class="btn btn-success btn-typePay" id="Payother" data-bs-toggle="tab" href="#post-popular" role="tab" aria-selected="false" tabindex="-1">
							ชำระค่าอื่นๆ
						</a>
					</li>
				</ul> --}}
		</div>
	</div>
	<div class="card-body mt-n2 pb-2">
		<div class="tab-content">
			<div class="row mb-2">
				<div class="col-12">
					<div class="input-bx">
						<input type="text" name="dateDue" id="dateDue" value="{{ date('d-m-Y') }}" class="form-control text-center font-size-14" id="date_viewDuepay" data-date-autoclose="true" data-provide="datepicker" data-date-format="dd-mm-yyyy" data-date-language="th" autocomplete="off" data-date-today-btn="linked" />
						<span class="text-info">วันที่รับชำระ</span>
						<button type="button" id="btn_Due" class="mx-0 btn btn-soft-info border border-sbtn-info border-opacity-50 font-size-13 w-xs" data-id="{{ @$contract->id }}" data-codloan="{{ @$contract->CODLOAN }}" data-bs-toggle="tooltip" title="ค้นหา">
							<i class="mdi mdi-calendar-refresh"></i>
						</button>
					</div>
				</div>
			</div>
			<div class="row mb-2">
				<div class="col-12">
					<div class="input-bx">
						<input type="text" name="view_payment" id="view_payment" class="form-control text-end border-danger btGroup-pay font-size-14" autocomplete="off" autofocus placeholder=" " disabled oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
						<span class="text-danger">ยอดรับชำระ</span>
						<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-13">
							บาท
						</button>
					</div>
				</div>
			</div>
			<div class="row g-2 mb-2">
				<div class="col-6">
					<div class="input-bx">
						<input type="text" name="view_payint" id="view_payint" class="form-control text-end border-danger btGroup-pay font-size-14" autocomplete="off" placeholder=" " disabled oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
						<span class="text-danger">ส่วนลดเบี้ยปรับ</span>
						<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-13">
							บาท
						</button>
					</div>
				</div>
				<div class="col-6">
					<div class="input-bx">
						<input type="text" name="view_dscint" id="view_dscint" class="form-control text-end border-danger btGroup-pay font-size-14" autocomplete="off" placeholder=" " disabled oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
						<span class="text-danger">ส่วนลดทวงถาม</span>
						<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-13">
							บาท
						</button>
					</div>
				</div>
			</div>
			<div class="row mb-4">
				<div class="col-12">
					<div class="input-bx">
						<input type="text" name="payment" id="payment" class="form-control text-end border-danger btGroup-pay font-size-14" readonly />
						<span class="text-danger">ยอดหักลูกหนี้</span>
						<button type="button" id="btn_calculatePay" class="mx-0 btn btn-soft-danger border border-danger border-opacity-50 font-size-13 w-xs d-none" data-bs-toggle="tooltip" title="คำนวณ">
							<i class="bx bx-calculator"></i>
						</button>
						<button type="button" id="btn_clearinputPay" class="mx-0 btn btn-soft-danger border border-danger border-opacity-50 font-size-13 w-xs" data-bs-toggle="tooltip" title="ล้างค่า">
							<i class="bx bxs-eraser"></i>
						</button>
					</div>
				</div>
			</div>
			<div class="d-flex justify-content-center gap-2 mt-3 mb-2">
				<div class="btn-group" data-bs-toggle="tooltip" title="เพิ่มเติม">
					<button type="button" id="btn-Payother" class="btn btn-soft-info btn-rounded border border-info border-opacity-50 chat-send w-md waves-effect waves-light dropdown-toggle py-1 btn-lg" data-bs-toggle="dropdown" aria-expanded="false" {{ @$contract == null ? 'disabled' : '' }}>
						<i class="bx bx-list-plus"></i>
					</button>
					<div class="dropdown-menu" style="cursor:pointer;">
						<button class="dropdown-item modal_md d-flex justify-content-start" data-link="{{ route('payments.create') }}?funs={{ 'search-debt' }}&id={{ @$contract->id }}&CODLOAN={{ @$contract->CODLOAN }}">
							<i class="bx bx-table text-info fs-4"></i><span class="ms-2"> สอบถามยอดค้าง</span>
						</button>
						<button class="dropdown-item data-modal-xl d-flex justify-content-start" data-link="{{ route('payments.create') }}?funs={{ 'tb-paydue' }}&id={{ @$contract->id }}&CODLOAN={{ @$contract->CODLOAN }}">
							<i class="bx bx-table text-info fs-4"></i><span class="ms-2"> ตารางค่างวด</span>
						</button>
						<button class="dropdown-item data-modal-xl-2 d-flex justify-content-start" data-link="{{ route('payments.show', @$contract->id) }}?page={{ 'backend' }}&FlagBtn={{ 'OVRDUE' }}&CODLOAN={{ @$contract->CODLOAN }}&CONTTYP={{ @$contract->CONTTYP }}">
							<i class="bx bx-table text-info fs-4"></i><span class="ms-2"> ตารางแสดงยอดเบี้ยปรับ</span>
						</button>
						<button class="dropdown-item data-modal-xl-2 d-flex justify-content-start" data-link="{{ route('payments.create') }}?funs={{ 'OVRDUE' }}&id={{ @$contract->id }}&CODLOAN={{ @$contract->CODLOAN }}">
							<i class="bx bx-receipt text-info fs-4"></i><span class="ms-2">บันทึกออกใบแจ้งหนี้</span>
						</button>
						<button class="dropdown-item closeAC_btn d-flex justify-content-start" data-link="{{ route('payments.create') }}?funs=closeAC&id={{ @$contract->id }}&CODLOAN={{ @$contract->CODLOAN }}">
							<i class="bx bx-receipt text-info fs-4"></i><span class="ms-2">บันทึกปิดบัญชี</span>
						</button>
					</div>
				</div>
				<div data-bs-toggle="tooltip" title="รับชำระ">
					<button type="button" id="btn-Payments" class="btn btn-soft-success btn-rounded border border-success border-opacity-50 chat-send w-md waves-effect waves-light py-1 btn-lg" data-id="{{ @$contract->id }}" data-codloan="{{ @$contract->CODLOAN }}" data-conttyp="{{ @$contract->CONTTYP }}" disabled>
						<i class="bx bx-dollar-circle bx-tada"></i>
					</button>
				</div>
				{{-- <div data-bs-toggle="tooltip" title="รีเฟรช">
					<button type="button" id="btn_Due" class="btn btn-outline-secondary btn-rounded chat-send w-md waves-effect waves-light py-1 btn-lg" data-id="{{ @$contract->id }}" data-codloan="{{ @$contract->CODLOAN }}">
						<i class="mdi mdi-calendar-refresh"></i>
					</button>
				</div> --}}
			</div>

			@isset($contract)
				{{-- set value --}}
				<input type="text" hidden id="btn-typePayments" title="ประเภทชำระ">
				<input type="text" hidden id="codloan" value="{{ @$contract->CODLOAN }}" title="ประเภทสัญญา">
				<input type="text" hidden id="conttyp" value="{{ @$contract->CONTTYP }}" title="CONTTYP">
				<input type="text" hidden id="cont_id" value="{{ @$contract->id }}" title="contract_id">

				<input type="text" hidden id="DateSer" value="{{ @$DateSer }}" placeholder="วันที่ชำระปัจจุบัน">
				<input type="text" hidden id="priceCus" value="{{ $priceCus }}" placeholder="ยอดชำระทั้งหมด (ในตาราง)">
				<input type="text" hidden id="intamtCus" value="{{ $intamtCus }}" placeholder="ยอดเบี้ยปรับล่าช้าทั้งหมด (ในตาราง)">
				<input type="text" hidden id="vfollowCus" value="{{ $vfollowCus }}" placeholder="ยอดค่าทวงถามทั้งหมด (ในตาราง)">

				{{-- set Aroth --}}
				<input type="text" hidden id="PactToAroth" value="{{ count(@$contract->PactToAroth) }}" title="จำนวนรายการลูกหนี้อื่น">
				<input type="text" hidden id="totblc" value="{{ @$TOTBLC }}" title="ยอดคงเหลือตัดงวด">
				<input type="text" hidden id="StatPayOther" value="{{ @$StatPayOther }}" title="สถานะลูกหนี้ตามรหัส">
				<input type="text" hidden id="StatPayOther_N" value="{{ @$StatPayOther_N }}" title="สถานะลูกหนี้ตามรนอกหัส">
			@endisset
		</div>
	</div>
</div>
