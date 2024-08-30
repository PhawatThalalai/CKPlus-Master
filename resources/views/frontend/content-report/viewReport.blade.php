
@if (@$form == 'Contract')
	<section class="content" style="font-family: 'Prompt', sans-serif;">
		<div class="modal-content text-dark">
			<div class="d-flex m-3">
				<div class="flex-shrink-0 me-2">
					<script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
					<lord-icon src="https://cdn.lordicon.com/rfbqeber.json" trigger="loop" style="width:50px;height:50px">
					</lord-icon>
				</div>
				<div class="flex-grow-1 overflow-hidden">
					<h4 class="text-primary fw-semibold">รายงาน (Report)</h4>
					<p class="border-primary border-bottom mt-n2"></p>
				</div>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>

			<form name="Report_Contract" target="_blank" class="form-Validate" action="{{ route('report.create') }}" method="get" enctype="multipart/form-data">
				@csrf
				@method('put')
				<input type="hidden" name="form" value="{{ @$form }}" />
				<input type="hidden" name="report" value="{{ @$report }}" />

				<div class="mx-3">
					<div class="row ">
						<div class="row m-2">
							<div class="col-12 col-lg-6">
								<div class="form-group row mb-0">
									<label class="col-sm-3 col-form-label text-right textSize-13">จากวันที่ :</label>
									<div class="col-sm-7">
										<input type="date" name="Fdate" value="{{ date('Y-m-d') }}" class="form-control form-control-sm textSize-13" title="จากวันที่" required />
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="form-group row mb-0">
									<label class="col-sm-3 col-form-label text-right textSize-13">ถึงวันที่ :</label>
									<div class="col-sm-7">
										<input type="date" name="Tdate" value="{{ date('Y-m-d') }}" class="form-control form-control-sm textSize-13" title="ถึงวันที่" required />
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="form-group row mb-0">
									<label class="col-sm-3 col-form-label text-right textSize-13">สัญญา :</label>
									<div class="col-sm-7">
										<select name="TypeLoans" class="form-control form-control-sm textSize-13 is-warning" title="ประเภทสัญญา">
											<option value="" selected>--- ประเภทสัญญา ---</option>
											@foreach ($TypeLoan as $key => $value)
												<option value="{{ $value->Loan_Code }}-{{ $value->Loan_Name }}-{{ $value->id_rateType }}">{{ $value->Loan_Code }} - {{ $value->Loan_Name }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="form-group row mb-0">
									<label class="col-sm-3 col-form-label text-right textSize-13">สาขา :</label>
									<div class="col-sm-7">
										<select name="Branch_Con" class="form-control form-control-sm textSize-13" {{ @$type == 2 ? 'disabled' : '' }}>
											<option value="" selected>--- สาขา ---</option>
											@foreach (@$dataBranchs as $key => $value)
												<option value="{{ $value->id }}">({{ $value->NickName_Branch }}) - {{ $value->Name_Branch }}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="form-group row mb-0">
									<label class="col-sm-3 col-form-label text-right textSize-13">สถานะ :</label>
									<div class="col-sm-7">
										<select name="Status_Con" class="form-control form-control-sm textSize-13">
											<option value="" selected>--- สถานะ ---</option>
											<option value="active">รออนุมัติ</option>
											<option value="complete">อนุมัติ</option>
										</select>
									</div>
								</div>
							</div>
							<div class="col-12 col-lg-6">
								<div class="form-group row mb-0">
									<label class="col-sm-3 col-form-label text-right textSize-13">Zone :</label>
									<div class="col-sm-7">
										<select name="Zone_Con" class="form-control form-control-sm textSize-13" {{ @$report != 'PAReport' ? 'disabled' : '' }}>
											<option value="" selected>---Zone---</option>
											<option value="All">All Zone</option>
											{{-- <option value="10" >ปัตตานี</option>
                                            <option value="20" >หาดใหญ่</option>
                                            <option value="30" >นครศรีธรรมราช</option>
                                            <option value="40" >กระบี่</option>
                                            <option value="50" >สุราษฎร์ธานี</option> --}}
										</select>
									</div>
								</div>
							</div>
                            @if(strtolower(@$report) == 'os4kh')
                                <div class="row mt-4">
                                    <div class="col-12 text-center">
                                        <fieldset class="reset rounded-3 border-primary border-opacity-10">
                                            <legend class="reset fw-bold text-primary text-start fs-6" style="letter-spacing: 0.1rem">ข้อมูลแบบฟอร์มเพิ่มเติม</legend>
                                            <div class="px-2 py-2">
                                                <div class="mb-2">
                                                    <div class="row g-1 m-0">
                                                        <div class="col-4 ps-1 text-start">
                                                            <span class="">ชื่อ - สกุล</span>
                                                            <input type="text" class="form-control text-center license-input form-control-sm" id="" name="nameForm" autocomplete="off" placeholder="ชื่อ - สกุล" required/>
                                                        </div>
                                                        <div class="col-4 pe-1 text-start">
                                                            <span class="">ตำแหน่ง</span>
                                                            <input type="text" class="form-control text-center license-input form-control-sm" id="" name="Position" autocomplete="off" placeholder="ตำแหน่ง" required/>
                                                        </div>
                                                        <div class="col-4 pe-1 text-start">
                                                            <span class="">วันที่ยื่น</span>
                                                            <input type="date" class="form-control text-center license-input form-control-sm" id="" name="dateSend" autocomplete="off"  placeholder="วันที่ยื่น" required/>
                                                        </div>

                                                    </div>

                                                </div>

                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            @endif
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-sm bg-info SizeText hover-up">
							<i class="bx bxs-printer me-1"></i> พิมพ์
						</button>
					</div>
				</div>
			</form>
		</div>
	</section>
@elseif(@$form == 'Datacus' || @$form == 'audit')
	<section class="content" style="font-family: 'Prompt', sans-serif;">
		<div class="modal-content">
			<div class="d-flex m-3">
				<div class="flex-shrink-0 me-2">
					<script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
					<lord-icon src="https://cdn.lordicon.com/rfbqeber.json" trigger="loop" style="width:50px;height:50px">
					</lord-icon>
				</div>
				<div class="flex-grow-1 overflow-hidden">
					<h4 class="text-primary fw-semibold">รายงาน (Report)</h4>
					<p class="border-primary border-bottom mt-n2"></p>
				</div>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form name="Report_Contract" target="_blank" class="form-Validate" action="{{ route('report.create') }}" method="get" enctype="multipart/form-data">
				@csrf
				@method('put')
				<input type="hidden" name="form" value="{{ @$form }}" />
				<input type="hidden" name="report" value="{{ @$report }}" />

				<div class="mx-3">
					<div class="row textSize-13">
						<div class="col-12 col-lg-6">
							<div class="form-group row mb-0">
								<label class="col-sm-3 col-form-label text-right textSize-13">ผู้เรียก :</label>
								<div class="col-sm-7">
									<input type="text" value="{{ auth()->user()->username }}" class="form-control form-control-sm textSize-13" title="ผู้เรียกรายงาน" readonly />
								</div>
							</div>
						</div>
					</div>
					<div class="row textSize-13">
						<div class="col-12 col-lg-6">
							<div class="form-group row mb-0">
								<label class="col-sm-3 col-form-label text-right textSize-13">จากวันที่ :</label>
								<div class="col-sm-7">
									<input type="date" name="Fdate" value="{{ date('Y-m-d') }}" class="form-control form-control-sm textSize-13" title="จากวันที่" required />
								</div>
							</div>
						</div>
						<div class="col-12 col-lg-6">
							<div class="form-group row mb-0">
								<label class="col-sm-3 col-form-label text-right textSize-13">ถึงวันที่ :</label>
								<div class="col-sm-7">
									<input type="date" name="Tdate" value="{{ date('Y-m-d') }}" class="form-control form-control-sm textSize-13" title="ถึงวันที่" required />
								</div>
							</div>
						</div>
					</div>
					<div class="row textSize-13">
						<div class="col-12 col-lg-6">
							<div class="form-group row mb-0">
								<label class="col-sm-3 col-form-label text-right textSize-13">สาขา :</label>
								<div class="col-sm-7">
									<select name="Branch_Con" class="form-control rounded-pill me-2 shadow-sm" style="border:none;">
										<option value="" selected>--- สาขา ---</option>
										@foreach (@$dataBranchs as $key => $value)
											<option value="{{ $value->id }}">({{ $value->NickName_Branch }}) - {{ $value->Name_Branch }}</option>
										@endforeach
									</select>
								</div>
							</div>
						</div>
						@if (@$form == 'audit')
							<div class="col-12 col-lg-6">
								<div class="form-group row mb-0">
									<label class="col-sm-3 col-form-label text-right textSize-13">สถานะเอกสาร :</label>
									<div class="col-sm-7">
										<select name="statusTxt" id="statusTxt" class="form-control rounded-pill me-2 shadow-sm" style="border:none;">
											<option value="">--เลือกสถานะ--</option>
											@foreach (@$status_audit as $row)
												<option value="{{ $row->id }}" {{ @$row->id == @$data['statusTxt'] ? 'selected' : '' }}>{{ $row->name_th }}</option>
											@endforeach
											<option value="all" {{ 'all' == @$data['statusTxt'] ? 'selected' : '' }}>สถานะทั้งหมด</option>
										</select>
									</div>
								</div>
							</div>
						@elseif (@$form == 'Datacus')
							<div class="col-12 col-lg-6">
								<div class="form-group row mb-0">
									<label class="col-sm-3 col-form-label text-right textSize-13">สถานะเอกสาร :</label>
									<div class="col-sm-7">
										<select name="statusTxt" id="statusTxt" class="form-control rounded-pill me-2 shadow-sm" style="border:none;">
											<option value="">--เลือกสถานะ--</option>
											@foreach (@$status_custag as $row)
												<option value="{{ $row->Memo_StatusTag }}" {{ @$row->Memo_StatusTag == @$data['statusTxt'] ? 'selected' : '' }}>{{ $row->Name_StatusTag }}</option>
											@endforeach
											<option value="all" {{ 'all' == @$data['statusTxt'] ? 'selected' : '' }}>สถานะทั้งหมด</option>
										</select>
									</div>
								</div>
							</div>
						@endif

					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-sm bg-info SizeText hover-up">
						<i class="bx bxs-printer me-1"></i> พิมพ์
					</button>
				</div>
			</form>
		</div>
	</section>
@elseif(@$form == 'commission')
	<section class="content" style="font-family: 'Prompt', sans-serif;">
		<div class="modal-content">
			<div class="d-flex m-3">
				<div class="flex-shrink-0 me-2">
					<script src="https://cdn.lordicon.com/ritcuqlt.js"></script>
					<lord-icon src="https://cdn.lordicon.com/rfbqeber.json" trigger="loop" style="width:50px;height:50px">
					</lord-icon>
				</div>
				<div class="flex-grow-1 overflow-hidden">
					<h4 class="text-primary fw-semibold">รายงาน (Report)</h4>
					<p class="border-primary border-bottom mt-n2"></p>
				</div>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form name="Report_Contract" target="_blank" class="form-Validate" action="{{ route('report.create') }}" method="get" enctype="multipart/form-data">
				@csrf
				@method('put')
				<input type="hidden" name="form" value="{{ @$form }}" />
				<input type="hidden" name="report" value="{{ @$report }}" />

				<div class="mx-3">
					<div class="row textSize-13">
						<div class="col-6 col-lg-12">
							<div class="form-group row mb-0">
								<label class="col-sm-3 col-form-label text-right textSize-13">ผู้เรียก :</label>
								<div class="col-sm-7">
									<input type="text" value="{{ auth()->user()->name }}" class="form-control form-control-sm textSize-13" title="ผู้เรียกรายงาน" readonly />
								</div>
							</div>
						</div>
					</div>
					<div class="row textSize-13">
						<div class="col-6 col-lg-12">
							<div class="form-group row mb-0">
								<label class="col-sm-3 col-form-label text-right textSize-13">Month View :</label>
								<div class="col-sm-7">
									<div class="position-relative" id="datepicker4">
										<input type="text" name="Month" class="form-control form-control-sm" data-date-container="#datepicker4" data-provide="datepicker" data-date-language="th" data-date-format="mm-yyyy" data-date-autoclose="true" data-date-min-view-mode="1" readonly>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-sm bg-info SizeText hover-up">
						<i class="bx bxs-printer me-1"></i> พิมพ์
					</button>
				</div>
			</form>
		</div>
	</section>
@endif
