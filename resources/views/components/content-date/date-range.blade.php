{{-- <div class="row mb-1 search-box-top">
	<div class="col-12">
		<form action="#" method="get" class="mt-4 mt-sm-0 float-sm-end d-sm-flex">
			<div class="me-1">
				<div class="position-relative">
					<div class="row g-1 text-end">
						<div class="col-xl-3 col-lg-3 col-sm mb-1">
							@if (@$btn['btn_statuscus'] == true)
								<select name="statusTxt" id="statusTxt" class="form-control rounded-pill me-2 shadow-sm" style="border:none;">
									<option value="">--เลือกสถานะ--</option>
									@foreach ($data['status_cus'] as $row)
										<option value="{{ $row->Memo_StatusTag }}" {{ @$row->Memo_StatusTag == @$data['statusTxt'] ? 'selected' : '' }}>{{ $row->Name_StatusTag }}</option>
									@endforeach
								</select>
							@endif

							@if (@$btn['btn_statusbroker'] == false && !empty(@$data['type_broker']))
								<select name="statusTxt" id="statusTxt" class="form-control rounded-pill me-2 shadow-sm" style="border:none;">
									<option value="">--เลือกสถานะ--</option>
									@foreach (@$data['type_broker'] as $row)
										<option value="{{ @$row->id }}" {{ @$row->id == @$data['statusTxt'] ? 'selected' : '' }}>{{ @$row->Name_typeBroker }}</option>
									@endforeach
								</select>
							@endif

							@if (@$btn['btn_statuscon'] == true)
								<select name="statusTxt" id="statusTxt" class="form-control rounded-pill me-2 shadow-sm" style="border:none;">
									<option value="">--เลือกสถานะ--</option>
									@foreach (@$data['StatusCon'] as $row)
										<option value="{{ $row->Name_StatusCon }}" {{ @$row->Name_StatusCon == @$data['statusTxt'] ? 'selected' : '' }}>{{ $row->Memo_StatusCon }}</option>
									@endforeach
								</select>
							@endif
						</div>
						<div class="col-xl-7 col-lg-7 col-sm-12 mb-1">
							<div class="input-daterange input-group" id="datepicker6" data-date-format="dd M, yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#datepicker6">
								<input type="text" class="form-control me-2 " name="start" id="start" value="{{ @$data['Fdate'] }}" placeholder="Start Date" style="border:none; border-radius:25px;">
								<input type="text" class="form-control " name="end" id="end" value="{{ @$data['Tdate'] }}" placeholder="End Date" style="border:none; border-radius:25px;">
							</div>
						</div>

						<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 d-none d-sm-none d-md-block">
							<div class="col-4 list-inline-item user-chat-nav ">
								<div class="dropdown" data-bs-toggle="tooltip" title="ค้นหา">
									<button class="btn nav-btn section bg-white bg-soft hover-up " type="submit" aria-haspopup="true" aria-expanded="false">
										<i class="bx bx-search"></i>
									</button>
								</div>
							</div>
							<div class="col list-inline-item user-chat-nav ">
								<div class="dropdown" data-bs-toggle="tooltip" title="พิมพ์">
									<button class="btn nav-btn section bg-white bg-soft hover-up" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="bx bx-printer"></i>
									</button>
									<div class="dropdown-menu p-1">
										<div class="d-grid gap-1">
											<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 3 }}" class="btn btn-warning border border-white btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">1. รายงานอนุมัติสินเชื่อ</a>
											<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 4 }}" class="btn btn-warning border border-white btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">2. รายงานตามเลขที่สัญญา</a>
											<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 6 }}" class="btn btn-warning border border-white btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">3. รายงานตามยอดจัดรวม</a>

											<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 3 }}" class="btn btn-warning border border-white btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">1. รายงานยอดจัด</a>
											<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 2 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">2. รายงานสัญญา</a>
											<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 1 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">3. รายงานตามเลขที่สัญญา</a>
											<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 3 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">4. รายงานอนุมัติสินเชื่อ</a>
											<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 7 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">5. รายงานการทำประกัน</a>
											<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 8 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">6. รายงานPrivot</a>
											<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 9 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">7. อส 4ข.</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12 d-xl-none d-lg-none d-md-none d-grid gap-2 mb-1">
							<button class="btn btn btn-soft-info  waves-effect waves-light btn  rounded-pill " type="submit" aria-haspopup="true" aria-expanded="false">
								<i class="bx bx-search"></i> ค้นหา
							</button>
						</div>
						<div class="col d-xl-none d-lg-none d-md-none d-grid gap-2">
							<button class="btn btn-light waves-effect waves-light btn  rounded-pill" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="bx bx-printer"></i> ออกรายงาน
							</button>
							<div class="dropdown-menu p-1">
								<div class="d-grid gap-1">
									<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 3 }}" class="btn btn-warning border border-white btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">1. รายงานยอดจัด</a>
									<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 2 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">2. รายงานสัญญา</a>
									<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 1 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">3. รายงานตามเลขที่สัญญา</a>
									<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 3 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">4. รายงานอนุมัติสินเชื่อ</a>
									<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 7 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">5. รายงานการทำประกัน</a>
									<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 8 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">6. รายงานPrivot</a>
									<a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 9 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">7. อส 4ข.</a>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>
	</div>

	<input type="hidden" id="type" name="type" value="{{ @$data['type'] }}">
	</form>
</div>
</div> --}}

<div class="row search-box-top" >
    <div class="col-12">
        <form class="float-sm-end d-sm-flex align-items-center" >
            <div class="search-box">
                <div class="position-relative" id="search_box">
                    <div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#search_box" data-date-format="dd-mm-yyyy" data-date-language="th">
                        @if (@$btn['btn_statuscus'] == true)
                            <select name="statusTxt" id="statusTxt" class="form-control rounded-pill me-2 shadow-sm" style="border:none;">
                                <option value="">--เลือกสถานะ--</option>
                                @foreach ($data['status_cus'] as $row)
                                    <option value="{{ $row->Memo_StatusTag }}" {{ @$row->Memo_StatusTag == @$data['statusTxt'] ? 'selected' : '' }}>{{ $row->Name_StatusTag }}</option>
                                @endforeach
                                <option value="all" {{ 'all' == @$data['statusTxt'] ? 'selected' : '' }}>สถานะทั้งหมด</option>
                            </select>
                        @endif

                        @if (@$btn['btn_statusbroker'] == false && !empty(@$data['type_broker']))
                            <select name="statusTxt" id="statusTxt" class="form-control rounded-pill me-2 shadow-sm" style="border:none;">
                                <option value="">--เลือกสถานะ--</option>
                                @foreach (@$data['type_broker'] as $row)
                                    <option value="{{ @$row->id }}" {{ @$row->id == @$data['statusTxt'] ? 'selected' : '' }}>{{ @$row->Name_typeBroker }}</option>
                                @endforeach
                            </select>
                        @endif

                        @if (@$btn['btn_statuscon'] == true)
                            <select name="statusTxt" id="statusTxt" class="form-control rounded-pill me-2 shadow-sm" style="border:none;">
                                <option value="">--เลือกสถานะ--</option>
                                @foreach (@$data['StatusCon'] as $row)
                                    <option value="{{ $row->Name_StatusCon }}" {{ @$row->Name_StatusCon == @$data['statusTxt'] ? 'selected' : '' }}>{{ $row->Memo_StatusCon }}</option>
                                @endforeach
                            </select>
                        @endif

                        @if (@$btn['btn_statusaudit'] == true)
                            <select name="statusTxt" id="statusTxt" class="form-control rounded-pill me-2 shadow-sm" style="border:none;">
                                <option value="">--เลือกสถานะ--</option>
                                @foreach (@$data['status_audit'] as $row)
                                    <option value="{{ $row->id }}" {{ @$row->id == @$data['statusTxt'] ? 'selected' : '' }}>{{ $row->name_th }}</option>
                                @endforeach
                                <option value="all" {{ 'all' == @$data['statusTxt'] ? 'selected' : '' }}>สถานะทั้งหมด</option>
                            </select>

                        @endif
                        {{-- <div class="input-group">
                            <input type="text" class="form-control" name="start" id="start" value="{{ @$data['Fdate'] }}" placeholder="Start Date">
                            <input type="text" class="form-control" name="end" id="end" value="{{ @$data['Tdate'] }}" placeholder="End Date">
                        </div> --}}
                        <input type="text" class="form-control shadow-sm me-2" name="start" id="start" value="{{ @$data['Fdate'] }}" placeholder="Start Date" autocomplete="off" style="border:none; border-radius:25px;" readonly>
                        <input type="text" class="form-control shadow-sm" name="end" id="end" value="{{ @$data['Tdate'] }}" placeholder="End Date" autocomplete="off" style="border:none; border-radius:25px;" readonly>
                    </div>
                </div>
            </div>
            <div class="">
                <ul class="nav nav-pills product-view-nav justify-content-center mt-sm-0">
                    <li class="nav-item">
                        <div class="list-inline-item user-chat-nav">
                            <div class="dropdown" data-bs-toggle="tooltip" title="ค้นหา">
                                <button class="btn nav-btn section bg-white bg-soft shadow-sm hover-up" type="submit" aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-search-alt"></i>
                                </button>
                            </div>
                        </div>
                    </li>
                    @if (@$btn['btn_print'] == true)
                        <li class="nav-item">
                            <div class="list-inline-item user-chat-nav">
                                <div class="dropdown" data-bs-toggle="tooltip" title="พิมพ์">
                                    <button class="btn nav-btn section bg-white bg-soft hover-up" type="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="bx bx-printer"></i>
                                    </button>
                                    <div class="dropdown-menu p-1">
                                        <div class="d-grid gap-1">
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 3 }}" class="btn btn-warning border border-white btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">1. รายงานอนุมัติสินเชื่อ</a>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 4 }}" class="btn btn-warning border border-white btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">2. รายงานตามเลขที่สัญญา</a>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 6 }}" class="btn btn-warning border border-white btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">3. รายงานตามยอดจัดรวม</a>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 3 }}" class="btn btn-warning border border-white btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">1. รายงานยอดจัด</a>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 2 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">2. รายงานสัญญา</a>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 1 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">3. รายงานตามเลขที่สัญญา</a>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 3 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">4. รายงานอนุมัติสินเชื่อ</a>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 7 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">5. รายงานการทำประกัน</a>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 8 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">6. รายงานPrivot</a>
                                            <a href="#" data-bs-toggle="modal" data-bs-target="#data-modal-xl" data-link="{{ route('report.index') }}?from=1&type={{ 5 }}&flag={{ 9 }}" class="btn btn-warning btn-sm hover-up data-modal-xl-2" data-backdrop="static" data-keyboard="false" title="เลือกรายการ">7. อส 4ข.</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endif
					@if(@$btn['btn_refresh'] == true)
						<li class="nav-item ms-2">
							<div class="list-inline-item user-chat-nav">
								<div class="dropdown" data-bs-toggle="tooltip" title="รีเฟรช">
									<button class="btn nav-btn section bg-success text-light shadow-sm hover-up btn_refresh" type="button" aria-haspopup="true" aria-expanded="false">
										<i class="bx bx-revision"></i>
									</button>
								</div>
							</div>
						</li>
					@endif
                </ul>
            </div>

            <input type="hidden" id="page" name="page" value="{{ @$data['page'] }}">
            @if (@$data['page'] == 'approve-loans')
                <input type="hidden" id="loanCode" name="loanCode" value="{{ @$data['loanCode'] }}">
            @endif
        </form>
    </div>
</div>

