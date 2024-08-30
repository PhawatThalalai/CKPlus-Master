<style>

	.dscint-tooltip {
		--bs-tooltip-bg: var(--bs-primary);
	}

	.dblUnderlined {
		border-bottom: 3px double;
	}

	.overlay-exist-ac {
		position: absolute;
		display: none;
		width: 100%;
		height: 100%;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		background-color: rgba(0,0,0,0.5);
		z-index: 4;
		cursor: auto;
		outline-color: rgba(0,0,0,0.5);
		outline-style: solid;
		outline-width: 1px;
	}
	
</style>

<div class="modal-content" id="modal-closeAC-content">

	<input type="hidden" id="acccloset_selected_id" name="acccloset_selected_id" value="0">

	<form name="form_closeAC" action="#" method="post" class="form-Validate needs-validation" enctype="multipart/form-data" id="form_closeAC">
	  	@csrf
		<div class="d-flex m-3 mb-0">
			<div class="flex-shrink-0 me-2">
				<img src="{{ asset('assets/images/gif/coins.gif') }}" alt="icon" class="avatar-sm">
			</div>
			<div class="flex-grow-1 overflow-hidden">
				<h5 class="text-primary fw-semibold">บันทึกขอปิดบัญชี</h5>
				<p class="text-muted mt-n1 fw-semibold font-size-12 mb-2">
					Loan Closure Request Form

					<!-- เงินต้นคงเหลือ (เฉพาะเงินกู้) / ลูกหนี้คงเหลือ (เฉพาะเช่าซื้อ)-->
					<input type="hidden" name="_tonbalance" id="_tonbalance" value="{{ @$calCloseAC->tonbalance }}">

					<!-- ดอกเบี้ยคงค้าง (เงินกู้/เช่าซื้อ) : ดอกเบี้ยที่เกิดจากการค้างแต่ละดิว -->
					<input type="hidden" name="_payintkang" id="_payintkang" value="{{ @$calCloseAC->payintkang }}"> 

					<!-- ดอกเบี้ยคงเหลือ (เฉพาะเงินกู้) : ดอกเบี้ยคงเหลือที่จะถูกนำมาคิดส่วนลด-->
					<input type="hidden" name="_intkangtotal" id="_intkangtotal" value="{{ @$calCloseAC->intkangtotal }}"> 
					
					<!-- ส่วนลดดอกเบี้ย (เฉพาะเช่าซื้อ/เงินกู้ที่ดิน) -->
					<input type="hidden" name="_dscint" id="_dscint" value="{{ @$calCloseAC->dscint }}">
					 
					<!-- ส่วนลดดอกเบี้ย % (เฉพาะเช่าซื้อ/เงินกู้ที่ดิน) -->
					<input type="hidden" name="_dscpercen" id="_dscpercen" value="{{@$calCloseAC->dscpercen}}">
					<!-- งวดที่ปิดบัญชี (เฉพาะเช่าซื้อ) -->
					<input type="hidden" name="_nopay" id="_nopay" value="{{@$calCloseAC->nopay}}"> 

					<!-- ค้างค่าปรับ -->
					<input type="hidden" name="_int_late_amt" id="_int_late_amt" value="{{ @$calCloseAC->INTLATEAMT }}"> 
					<!-- ค้างค่าทวงถาม -->
					<input type="hidden" name="_letter" id="_letter" value="{{ @$calCloseAC->PAYFOLLOW }}"> 
					<!-- ค้างค่า ลูกหนี้อื่น (ค่าติดตาม) -->
					<input type="hidden" name="_other" id="_other" value="{{ @$calCloseAC->Aroth }}">

					<!-- ข้อมูลสัญญา -->
					<!-- โค้ดโลน 1 เงินกู้ 2 เช่าซื้อ -->
					<input type="hidden" name="codeloan" id="codeloan" value="{{@$contract->CODLOAN}}"> 

					<input type="hidden" name="patch_id" id="patch_id" value="{{@$contract->id}}">
					<input type="hidden" name="conttyp" id="conttyp" value="{{@$contract->CONTTYP}}">
					<input type="hidden" name="contno" id="contno" value="{{@$contract->CONTNO}}">
					<input type="hidden" name="contlocat" id="contlocat" value="{{@$contract->LOCAT}}">

					<input type="hidden" name="summary" id="closure_summary" value="0">

				</p>
				<p class="border-primary border-bottom mt-n2"></p>
				{{-- var_dump($calCloseAC) --}}
			</div>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="mx-3" id="cardBodyCLA">
			<div class="row">
				<div class="col-lg-6 col-12">
					<!-- ข้อมูลเบื้องต้น -->
					<div class="row g-2 mb-1">
						<div class="col-6 my-2">
							<div class="input-bx">
								<input type="text" name="docno" placeholder=" " value="{{ @$docno }}" class="form-control form-control-sm rounded-0 rounded-start cla-docno" data-bs-toggle="tooltip" title="เลขที่เอกสาร" required readonly />
								<span>เลขที่เอกสาร</span>
								@if( @$existing_close->count() > 0 )
									<button type="button" class="mx-0 btn btn-primary border border-primary border-opacity-50 d-flex align-items-center border-start-0 rounded-0 rounded-end search-cla-docs-btn">
											<span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle notification-cla" style="padding: 0.35rem !important;">
												<span class="visually-hidden">New alerts</span>
											</span>
										<i class="fas fa-search"></i>
									</button>
								@else
									<button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled d-flex align-items-center border-start-0 rounded-0 rounded-end">
										<i class="fas fa-search"></i>
									</button>
								@endif
							</div>
						</div>
						<div class="col-6 my-2">
							<div class="input-bx">
								<input type="text" name="doc_date" id="doc_date" placeholder=" " value="{{ date('d/m/Y') }}" class="form-control form-control-sm text-center rounded-0 rounded-start" data-date-format="dd/mm/yyyy" {{-- data-date-container="#modalContent" --}} data-provide="datepicker" data-date-disable-touch-keyboard="true" data-date-enable-on-readonly="false" data-date-language="th" data-bs-toggle="tooltip" title="วันที่เอกสาร" autocomplete="off" required readonly />
								<span>วันที่เอกสาร</span>
								<button class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled d-flex align-items-center border-start-0 rounded-0 rounded-end">
									<i class="fas fa-calendar-alt"></i>
								</button>
							</div>
						</div>
					</div>

					<input type="hidden" name="PAYFOR_CODE" value="{{ $_payfor->FORCODE }}"/>
					<input type="hidden" name="PAYFOR_NAME" id="PAYFOR_NAME" value="{{ $_payfor->FORDESC }}" />

					<!-- การ์ดข้อมูลสัญญา -->
					<div class="card border border-secondary border-opacity-25 bg-secondary bg-opacity-10 text-muted font-size-11 mb-3 shadow-sm">
						<div class="card-body p-3">
							<div class="row g-2">
								<div class="col-6 d-flex align-items-center">
									<div class="small">สาขา</div>
									<div class="flex-fill fw-bold text-center border-dark border-bottom border-opacity-25" id="cd_locat">{{ ($LOCAT->NickName_Branch != null)?$LOCAT->NickName_Branch : $LOCAT->Name_Branch }}</div>
								</div>
								<div class="col-6 d-flex">
									<div class="small">เลขที่สัญญา</div>
									<div class="flex-fill fw-bold text-center border-dark border-bottom border-opacity-25" id="cd_contno">{{ $contract->CONTNO }}</div>
								</div>
							</div>
							<div class="row g-2 pt-2">
								<div class="col-6 d-flex align-items-center">
									<div class="small">ยอดผ่อนชำระ</div>
									<div class="flex-fill fw-bold text-end border-dark border-bottom border-opacity-25" id="cd_totprc">{{ number_format(@$contract->TOTPRC,2) }}</div>
								</div>
								<div class="col-6 d-flex align-items-center">
									<div class="small">ชำระเงินแล้ว</div>
									<div class="flex-fill fw-bold text-end border-dark border-bottom border-opacity-25" id="cd_smpay">{{ number_format(@$contract->SMPAY,2) }}</div>
								</div>
							</div>
							<div class="row g-2 pt-2">
								<div class="col-6 d-flex align-items-center">
									<div class="small">ยอดคงเหลือ</div>
									<div class="flex-fill fw-bold text-end border-dark border-bottom border-opacity-25" id="cd_balan">{{ number_format(@$contract->TOTPRC-@$contract->SMPAY,2) }}</div>
								</div>
								<div class="col-6 d-flex align-items-center">
									<div class="small">ยอดค้างชำระ</div>
									<div class="flex-fill fw-bold text-end border-dark border-bottom border-opacity-25" id="cd_expamt">{{ number_format(@$contract->EXP_AMT,2) }}</div>
								</div>
							</div>
							<div class="row g-2 pt-2">
								<div class="col-4 d-flex align-items-center">
									<div class="small">ค้างงวด</div>
									<div class="flex-fill fw-bold text-center text-danger border-dark border-bottom border-opacity-25" id="cd_expprd">{{ number_format(@$contract->EXP_PRD,0) }}</div>
								</div>
								<div class="col-4 d-flex align-items-center">
									<div class="small">ค้างจาก</div>
									<div class="flex-fill fw-bold text-center text-danger border-dark border-bottom border-opacity-25" id="cd_expfrm">{{ number_format(@$contract->EXP_FRM,0) }}</div>
								</div>
								<div class="col-4 d-flex align-items-center">
									<div class="small">ค้างถึง</div>
									<div class="flex-fill fw-bold text-center text-danger  border-dark border-bottom border-opacity-25" id="cd_expto">{{ number_format(@$contract->EXP_TO,0) }}</div>
								</div>
							</div>
							<div class="row g-2 pt-2">
								<div class="col-12 d-flex align-items-center">
									<div class="small">ผู้ทำรายการ</div>
									<div class="flex-fill fw-bold text-center border-dark border-bottom border-opacity-25" id="cd_user">{{ auth()->user()->name }} ({{ auth()->user()->username }})</div>
								</div>
							</div>
							<div class="row g-2 pt-2">
								<div class="col-12 d-flex align-items-center">
									<div class="small">ชำระค่า</div>
									<div class="flex-fill fw-bold text-center border-dark border-bottom border-opacity-25" id="cd_payfor">{{ $_payfor->FORCODE }} - {{ $_payfor->FORDESC }}</div>
								</div>
							</div>
						</div>
					</div>

					
					<div class="row g-2 mb-1">
						<div class="col my-2">
							<div class="input-bx">
								<select class="form-select text-danger fw-bold" name="speedBookFee_option" id="speedBookFee_option" style="padding-top: 8px; padding-bottom: 6px; font-size: 0.7109375rem;">
									<option value="N">ไม่ต้องการเร่งเล่ม</option>
									<option value="Y">ต้องการเร่งเล่ม</option>
								</select>
							</div>
						</div>
						<div class="col my-2" id="input_speedBookFee" style="">
							<div class="input-bx">
								<input type="text" name="speedBookFee_value" id="speedBookFee_value" class="form-control form-control-sm rounded-0 rounded-start text-end updateSummaryClose" placeholder=" " value="{{number_format(0,2)}}" data-bs-toggle="tooltip" title="ค่าบริการเร่งเล่ม" readonly/>
								<span class="label-speed-book">ค่าบริการเร่งเล่ม</span>
								<button class="mx-0 btn btn-light border border-secondary border-start-0 border-opacity-50 font-size-10 disabled rounded-0 rounded-end">บาท</button>
							</div>
						</div>
					</div>
					<div class="row g-2 mb-1">

						@if(@$contract->CODLOAN == 1 && @$contract->CONTTYP == 1)
							<!-- เงินกู้ รถยนต์ / มอเตอร์ไซค์ ส่วนลด 100% ไม่มีส่วนลดดอกเบี้ย เพราะ ไม่ได้คิดดอกเบี้ยคงค้าง กำหนด % ดอกเบี้ยเองไม่ได้ -->
							<div class="col-6 my-2">
								<div class="input-bx">
									<input type="number" name="dscpercen" id="dscpercen" class="form-control form-control-sm rounded-0 rounded-start text-end" placeholder=" " required="" value="100" min="0" max="100" step="0.01" autocomplete="off" readonly/>
									<span class="">ส่วนลดดอกเบี้ย%</span>
									<button class="mx-0 btn btn-light border border-secondary border-opacity-50 border-start-0 font-size-10 disabled rounded-0 rounded-end">%</button>
								</div>
							</div>
							<div class="col-6 my-2">
								<div class="input-bx" data-bs-toggle="tooltip" title="รวมส่วนลดไปแล้ว" data-bs-custom-class="dscint-tooltip">
									<input type="text" name="discount_value" id="discount_value" class="form-control form-control-sm rounded-0 rounded-start text-end" placeholder=" " value="0.00" autocomplete="off" readonly/>
									<span>ส่วนลดดอกเบี้ย</span>
									<button class="mx-0 btn btn-light border border-secondary border-opacity-50 border-start-0 font-size-10 disabled rounded-0 rounded-end">บาท</button>
								</div>
							</div>
						@else
							<!-- สัญญาเช่าซื้อ และ สัญญาเงินกู้อื่น ๆ (เงินกู้ที่ดิน/ขายฝากจำนอง) ใส่ % เองได้  -->
							<div class="col-6 my-2">
								<div class="input-bx">
									<input type="number" name="dscpercen" id="dscpercen" class="form-control form-control-sm rounded-0 rounded-start text-end updateSummaryClose" placeholder=" " required="" value="{{number_format(@$calCloseAC->dscpercen,2)}}" min="0" max="100" step="0.01" autocomplete="off"/>
									<span class="text-danger">ส่วนลดดอกเบี้ย%</span>
									<button class="mx-0 btn btn-light border border-secondary border-opacity-50 border-start-0 font-size-10 disabled rounded-0 rounded-end">%</button>
								</div>
							</div>
							<div class="col-6 my-2">
								<div class="input-bx">
									<input type="text" name="discount_value" id="discount_value" class="form-control form-control-sm rounded-0 rounded-start text-end text-success" placeholder=" " value="{{ number_format(0, 2) }}" data-bs-toggle="tooltip" title="ส่วนลดดอกเบี้ย" autocomplete="off" readonly/>
									<span class="text-success">ส่วนลดดอกเบี้ย</span>
									<button class="mx-0 btn btn-light border border-secondary border-opacity-50 border-start-0 font-size-10 disabled rounded-0 rounded-end">บาท</button>
								</div>
							</div>
						@endif
					</div>
					<div class="row g-2 mb-1">
						<div class="col-6 my-2">

							@if(@$contract->CODLOAN == 1 && @$contract->CONTTYP == 1)
								<!-- เงินกู้ รถยนต์ / มอเตอร์ไซค์ เปลี่ยนวันที่ไม่ได้ -->
								<div class="input-bx" data-bs-toggle="tooltip" title="เลือกวันปัจจุบันได้เท่านั้น" data-bs-custom-class="dscint-tooltip">
									<input type="text" name="paymentDueDate" id="paymentDueDate" placeholder=" " value="{{date('d/m/Y')}}" class="form-control form-control-sm text-center rounded-0 rounded-start" autocomplete="off"  required readonly />
									<button class="btn btn-light disabled border border-secondary border-opacity-50 rounded-0 rounded-end border-start-0 d-flex align-items-center" type="button">
										<i class="fas fa-calendar-alt"></i>
									</button>
									<span class="floating-label">กำหนดชำระถึงวันที่</span>
								</div>
							@else
								<div class="input-bx">
									<input type="text" name="paymentDueDate" id="paymentDueDate" placeholder=" " value="{{date('d/m/Y')}}" class="form-control form-control-sm text-center rounded-0 rounded-start" autocomplete="off" required readonly />
									<button class="btn btn-primary border border-secondary border-opacity-50 rounded-0 rounded-end border-start-0 d-flex align-items-center openDatepickerBtn" type="button">
										<i class="fas fa-calendar-alt"></i>
									</button>
									<span class="text-danger floating-label">กำหนดชำระถึงวันที่</span>
								</div>
							@endif

						</div>
						<div class="col-6 my-2">
							<div class="input-bx">
								<input type="text" name="discount_extra_value" id="discount_extra_value" class="form-control form-control-sm rounded-0 rounded-start text-end updateSummaryClose" placeholder=" " value="{{ number_format(0, 2) }}" data-bs-toggle="tooltip" title="ส่วนลดเพิ่มเติม" autocomplete="off" />
								<span class="text-danger">ส่วนลดเพิ่มเติม</span>
								<button class="mx-0 btn btn-light border border-secondary border-opacity-50 border-start-0 font-size-10 disabled rounded-0 rounded-end">บาท</button>
							</div>
						</div>
					</div>
					<div class="row g-2 mb-2 mb-md-1">
						<div class="col-md-12">
							<div class="form-floating">
								<textarea class="form-control" placeholder="Leave a comment here" name="Note_CloseAC" id="Note_CloseAC" maxlength="65535" style="height: 100px"></textarea>
								<label for="Note_CloseAC" class="fw-bold">หมายเหตุ</label>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-12">

					<div class="alert alert-info d-flex" role="alert">
						@if( @$contract->CODLOAN == 1 ) {{-- เงินกู้ --}}
							@if( @$contract->CONTTYP == 1 )
								@if( @$contract->TYPECON == '02')
									<i class='bx bxs-car bx-tada fs-4 pe-2'></i>
								@elseif( @$contract->TYPECON == '03' )
									<i class='bx bx-cycling bx-burst fs-4 pe-2'></i>
								@endif
								<strong class="flex-fill">{{@$contract->ContractTypeLoan->Loan_Name}}</strong> ลดดอกเบี้ย <b class="px-1">100%</b>
							@elseif( @$contract->CONTTYP == 2 )
								<i class='bx bxs-landmark bx-tada fs-4 pe-2'></i>
								<strong class="flex-fill">{{@$contract->ContractTypeLoan->Loan_Name}}</strong> ลดดอกเบี้ย <b class="px-1" id="dp_dscpercen">50%</b>
							@elseif( @$contract->CONTTYP == 3 )
								<i class='bx bxs-landmark bx-tada fs-4 pe-2'></i>
								<strong class="flex-fill">{{@$contract->ContractTypeLoan->Loan_Name}}</strong>
							@endif
						@elseif( @$contract->CODLOAN == 2 )
							<i class='bx bxs-car bx-tada fs-4 pe-2'></i>
							<strong class="flex-fill">{{@$contract->ContractTypeLoan->Loan_Name}}</strong> (ดิวที่ <span class="px-1" id="dp_nopay">{{@$calCloseAC->nopay}}</span>/{{number_format(@$contract->T_NOPAY,0)}} ส่วนลด <b class="px-1" id="dp_dscpercen">{{number_format(@$calCloseAC->dscpercen,0)}}%</b>)
						@endif
					</div>

					{{-- ดอกเบี้ยที่คิดนำมาจากงวดที่ยังไม่จ่าย ไม่สนใจการจ่ายล่วงหน้า --}}

					<h3 class="text-primary font-size-15 fw-bold">สรุปรายการ</h3>
					<div class="table-responsive">
						<table class="table table-nowrap table-sm">
							<tbody>
								<tr>
									<td></td>
									<td>
										<i class="fas fa-star font-size-10"></i>
										@if(@$contract->CODLOAN == 1)
											<!-- เงินกู้ จะแสดง เงินต้นคงเหลือ -->
											เงินต้นคงเหลือ
										@else
											<!-- เช่าซื้อ จะแสดง ลูกหนี้คงเหลือ (+ดอกเบี้ยแล้ว) -->
											ลูกหนี้คงเหลือ
										@endif
									</td>
									<td class="text-end text-info" id="dp_balance"></td>
								</tr>
								<tr class="loan-int-closure-table">
									<td></td>
									<td>ดอกเบี้ยคงค้าง</td>
									<td class="text-end text-info" id="dp_interest"></td>
								</tr>
								<tr class="loan-int-closure-table">
									<td></td>
									<td>ดอกเบี้ยคงเหลือ</td>
									<td class="text-end text-info" id="dp_intkangtotal"></td>
								</tr>
								<tr>
									<td></td>
									<td>ค้างค่าปรับล่าช้า</td>
									<td class="text-end" id="dp_fine"></td>
								</tr>
								<tr>
									<td></td>
									<td>ค้างค่าทวงถาม</td>
									<td class="text-end" id="dp_letter"></td>
								</tr>
								<tr>
									<td></td>
									<td>ลูกหนี้อื่น</td>
									<td class="text-end" id="dp_other"></td>
								</tr>
								<tr id="tb_row_speedBookFee">
									<td></td>
									<td class="text-danger">ค่าบริการเร่งเล่ม</td>
									<td class="text-end" id="dp_speedBookFee"></td>
								</tr>
								<tr class="bg-secondary bg-opacity-10">
									<td colspan="2" class="text-end">ยอดรวมย่อย</td>
									<td class="text-end fw-bold" id="dp_subTotal"></td>
								</tr>
								<tr id="tr_discount_value">
									<td colspan="2" class="border-0 text-end">
										<strong>หัก ส่วนลดดอกเบี้ย</strong>
									</td>
									<td class="border-0 text-end text-success" id="dp_discount"></td>
								</tr>
								<tr id="tr_discount_extra_value">
									<td colspan="2" class="border-0 text-end">
										<strong>หัก ส่วนลดเพิ่มเติม</strong>
									</td>
									<td class="border-0 text-end text-success" id="dp_discount_extra"></td>
								</tr>
								<tr class="bg-secondary bg-opacity-10">
									<td colspan="2" class="text-end">รวมส่วนลด</td>
									<td class="text-end fw-bold" id="dp_sumDisc"></td>
								</tr>
								<tr>
									<td colspan="2" class="border-0 text-end">
										<strong>รวมต้องชำระ</strong>
									</td>
									<td class="border-0 text-end text-danger">
										<h4 class="m-0 dblUnderlined fw-bolder" id="dp_summary"></h4>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<!-- <h3 class="text-danger text-end font-size-15 fw-bold"><u>กำหนดชำระถึงวันที่ <span id="dp_paymentDueDate"></span></u></h3> -->
				</div>
			</div>

			<div class="accordion mt-3" id="accordionPanelsStayOpenExample">
				<div class="accordion-item">
					<h2 class="accordion-header" id="panelsStayOpen-headingOne">
						<button class="accordion-button collapsed p-2" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
						Debug $calCloseAC
						</button>
					</h2>
					<div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne">
						<div class="accordion-body p-2">
							<div class="row">
								<div class="col-6">
									<pre>{{ var_dump(@$contract) }}</pre>
								</div>
								<div class="col-6">
									<pre>{{ var_dump(@$calCloseAC) }}</pre>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
		<div class="mx-3" id="searchTableCLA" style="display: none;">
			<div class="row">
				<div class="col-lg-6 col-12">
					<!-- ข้อมูลเบื้องต้น -->
					<div class="row g-2 mb-1">
						<div class="col-6 my-2">
							<div class="input-bx">
								<input type="text" name="docno" placeholder=" " value="{{ @$docno }}" class="form-control form-control-sm rounded-0 rounded-start cla-docno" data-bs-toggle="tooltip" title="เลขที่เอกสาร" required readonly />
								<span>เลขที่เอกสาร</span>
								<button type="button" class="mx-0 btn btn-primary border border-primary border-opacity-50 d-flex align-items-center border-start-0 rounded-0 rounded-end search-cla-docs-btn">
									<i class="fas fa-arrow-left"></i>
								</button>
							</div>
						</div>
						
					</div>

				</div>
				<div class="col-lg-6 col-12">

				</div>
			</div>
			<div class="table-responsive">
				<table class="table table-striped table-hover text-center align-middle">
					<thead class="table-light">
						<tr>
							<th scope="col">#</th>
							<th scope="col">เลขเอกสาร</th>
							<th scope="col">กำหนดชำระ</th>
							<th scope="col">ผู้ทำรายการ</th>
							<th scope="col">วันที่สร้าง</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						@foreach( @$existing_close as $key => $value)
						<tr data-itemid="{{$value->id}}">
							<th scope="row">{{$loop->index+1}}</th>
							<td>{{$value->DOCNO}}</td>
							<td>{{$value->EXPDATE}}</td>
							<td>{{$value->AccCloseToUser->name}}</td>
							<td>{{$value->created_at}}</td>
							<td>
								<button type="button" class="btn btn-sm btn-secondary search-cla-btn" data-itemindex="{{$loop->index}}">
									<i class="fas fa-check"></i>
								</button>
							</td>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						
					</tfoot>
				</table>
			</div>
		</div>
		<div class="modal-footer">
			<div class="row">
				<div class="col text-right">
					@if( @$contract->CODLOAN == 2 ) {{-- เช่าซื้อ --}}
						<button type="button" id="discountAC_btn" class="btn btn-info btn-sm waves-effect waves-light w-sm textSize-13 hover-up discountAC_btn d-none" data-link="{{ route('payments.show', @$contract->id )}}?FlagBtn=discountAC&id={{@$contract->id}}&CODLOAN={{@$contract->CODLOAN}}&flagPage=create&payDueDT=" role="button" disabled>
							<span class="textSize-13 text-white"><i class="far fa-eye"></i> ส่วนลดปิดบัญชี <span class="addSpin"></span></span>
						</button>
					@endif
					{{-- 
					<div class="btn-group">
						<button type="button" id="printDataAC_btn" class="btn btn-primary dropdown-toggle btn-sm waves-effect waves-light w-sm hover-up" data-bs-toggle="dropdown" aria-expanded="false" disabled>
							<i class="fa fa-print"></i> พิมพ์ <i class="mdi mdi-chevron-down"></i>
						</button>

						<a class="d-none" href="{{ route('report-backend.show', @$contract->id) }}?page=close-ac&CODLOAN={{ @$contract->CODLOAN }}&type=1" target="_blank" class="dropdown-item">ใบอนุมัติทางการเงิน</a>

						<div class="dropdown-menu">
							<a class="dropdown-item" href="#" id="print_dropdown_1" target="_blank">ใบอนุมัติทางการเงิน</a>
							<a class="dropdown-item" href="#" id="print_dropdown_2" target="_blank">Payin Slip</a>
						</div>
					</div>
					--}}
					<button type="button" id="printDataAC_btn" class="btn btn-primary btn-sm waves-effect waves-light w-sm hover-up printDataAc_btn" disabled>
						<i class="fa fa-print"></i> พิมพ์
					</button>
					<button type="button" id="SaveDataAC_btn" class="btn btn-success btn-sm waves-effect waves-light w-sm textSize-13 hover-up SaveDataAC_btn">
						<span class="textSize-13 text-white"><i class="fas fa-download"></i> บันทึก <span class="addSpin"></span></span>
					</button>
					<button type="button" class="btn btn-secondary btn-sm waves-effect waves-light w-sm hover-up" data-bs-dismiss="modal"><i class="fas fa-share"></i> ปิด</button>
				</div>
			</div>
		</div>
	</form>
</div>

<!-- สคริปต์ทั่วไปของหน้าปิดบัญชี -->
<script>
	var nf = new Intl.NumberFormat("th-TH", {
		//style: "currency",
		//currency: "THB",
		//currencyDisplay: "name",
		minimumFractionDigits: 2,
		maximumFractionDigits: 2,
	});
	var thb_currency = " บาท";

	function roundToTwoDecimalPlaces(num) {
		return Math.round((num + Number.EPSILON) * 100) / 100;
	}
	
	function RefreshSummary() {
		// ประกาศตัวแปรต่าง ๆ 
		let balance = 0; // เงินต้นคงเหลือ
		let int_paykang = 0; // ดอกเบี้ยคงค้าง (ดอกเบี้ยถึงงวดปัจจุบันที่ยังไม่จ่าย)
		let int_bal = 0; // ดอกเบี้ยคงเหลือ (ดอกเบี้ยในงวดที่เหลือที่ยังไม่ถึง --> จะถูกนำไปคิดส่วนลด)

		let fine = 0; // เบี้ยปรับล่าช้า
		let letter = 0; // ค่าทวงถาม
		let other = 0; // ลูกหนี้อื่น

		let speed_book = 0; // ค่าเร่งเล่ม
		let dscpercen = 0;
		let discount = 0;
		let discount_ex = 0;

		let subTotal = 0;
		let sumDisc = 0;
		let summary = 0;

		// codeloan
		var codeloan = $('#codeloan').val();

		// รับค่าตัวแปรต่าง ๆ
		if ($("#_tonbalance").val() != '') {
			balance = Number($("#_tonbalance").val());
		}
		if ($("#_payintkang").val() != '') {
			int_paykang = Number($("#_payintkang").val());
		}
		if ($("#_intkangtotal").val() != '') {
			int_bal = Number($("#_intkangtotal").val());
		}

		if ($("#_int_late_amt").val() != '') {
			fine = Number($("#_int_late_amt").val().replace(/,/g,''));
		}
		if ($("#_letter").val() != '') {
			letter = Number($("#_letter").val().replace(/,/g,''));
		}
		if ($("#_other").val() != '') {
			other = Number($("#_other").val().replace(/,/g,''));
		}
		
		if ($("#speedBookFee_value").val() != '') {
			speed_book = Number($("#speedBookFee_value").val().replace(/,/g,''));
		}
		//------------------------------------------------------------------------------
		if ($("#dscpercen").val() != '') {
			dscpercen = Number($("#dscpercen").val().replace(/,/g,''));
		}
		if (codeloan == 1) { // เงินกู้
			discount = roundToTwoDecimalPlaces( int_bal * dscpercen / 100 );
		} else if (codeloan == 2) {  // เช่าซื้อ
			discount = roundToTwoDecimalPlaces( int_paykang * dscpercen / 100 );
		}
		$("#discount_value").val( nf.format(discount) );
		//------------------------------------------------------------------------------
		if ($("#discount_extra_value").val() != '') {
			discount_ex = Number($("#discount_extra_value").val().replace(/,/g,''));
		}
		
		// แสดงผลตัวแปร
		$("#dp_balance").html(nf.format(balance) + thb_currency);
		$("#dp_interest").html(nf.format(int_paykang) + thb_currency);
		$("#dp_intkangtotal").html(nf.format(int_bal) + thb_currency);

		$("#dp_interest").html(nf.format(int_paykang) + thb_currency);
		$("#dp_intkangtotal").html(nf.format(int_bal) + thb_currency);

		$("#dp_fine").html(nf.format(fine) + thb_currency);
		$("#dp_letter").html(nf.format(letter) + thb_currency);
		$("#dp_other").html(nf.format(other) + thb_currency);
		$("#dp_speedBookFee").html(nf.format(speed_book) + thb_currency);

		if (codeloan == 1) {
			// เงินกู้
			subTotal = balance + int_paykang + int_bal + fine + letter + other + speed_book;
		} else {
			// เช่าซื้อ
			subTotal = balance + fine + letter + other + speed_book;
		}

		$("#dp_subTotal").html(nf.format(subTotal) + thb_currency);

		$("#dp_discount").html(nf.format(discount*-1) + thb_currency);
		$("#dp_discount_extra").html(nf.format(discount_ex*-1) + thb_currency);

		sumDisc = discount + discount_ex;
		$("#dp_sumDisc").html(nf.format(sumDisc) + thb_currency);

		summary = subTotal - discount - discount_ex;
		$("#dp_summary").html(nf.format(summary) + thb_currency);
		$("#closure_summary").val(summary);

		// ส่วนการแสดงซ่อน บรรทัดตารางที่จำเป็น
		if (speed_book > 0) {
			$("#tb_row_speedBookFee").show();
		} else {
			$("#tb_row_speedBookFee").hide();
		}
		if (discount > 0) {
			$("#tr_discount_value").show();
		} else {
			$("#tr_discount_value").hide();
		}
		if (discount_ex > 0) {
			$("#tr_discount_extra_value").show();
		} else {
			$("#tr_discount_extra_value").hide();
		}
		//--------------------------------------------
		if (codeloan == 2) {
			// เช่าซื้อ
			$(".loan-int-closure-table").hide();
			$("#dp_nopay").html( $("#_nopay").val() );
			$("#dp_dscpercen").html( ( parseFloat($("#dscpercen").val()) ).toFixed(2) + "%" );
		}
		//--------------------------------------------
		
	}

	RefreshSummary()

	$("#speedBookFee_option").on("change", function() {
		if ($("#speedBookFee_option").val() == "Y") {
			// ต้องการเร่งเล่ม
			document.getElementById("speedBookFee_value").required = true;
			$("#speedBookFee_value").attr("readonly", false); 
			$(".label-speed-book").addClass("text-danger");
			$("#speedBookFee_value").val(null);
			$("#speedBookFee_value").focus();
		} else {
			// ไม่ต้องการเร่งเล่ม
			document.getElementById("speedBookFee_value").required = false;
			$("#speedBookFee_value").attr("readonly", true); 
			$(".label-speed-book").removeClass("text-danger");
			$("#speedBookFee_value").val(0.00);
		}
		RefreshSummary();
	});

	$(".updateSummaryClose").on("input", function() {
		RefreshSummary();
	});

</script>

<!-- สคริปต์ bootstrap datepicker -->
<script>
	$(document).ready(function() {
		$('#paymentDueDate').datepicker({
			format: 'dd/mm/yyyy',
			container: '#modal-closeAC-content',
			autoclose: true,
			language: 'th',
			todayHighlight: true,
			enableOnReadonly: {{ (@$contract->CODLOAN == 1 && @$contract->CONTTYP == 1) ? 'false' : 'true' }}, // สัญญาเงินกู้ จะเปลี่ยนวันที่ไม่ได้
			clearBtn: false,
			toggleTooltip: true,
			tooltipPlacement: 'top',
			disableTouchKeyboard: true,
			startDate: "0d",
			daysOfWeekDisabled: '0', // เลือกวันอาทิตย์ไม่ได้
		}).on('changeDate', function(e) {
			//console.log(e);
			//console.log(e.date);
			//return;
			if ( e.date !== "undefined" ) {
				$("#dp_paymentDueDate").html(e.date.toLocaleString('th-TH', {
					dateStyle: 'long'
				}));
				$(".loading-overlay").attr('style', ''); //** แสดงตัวโหลด **
				$.ajax({
					url: "{{ route('payments.create') }}",
					type: 'GET',
					data: {
						id: '{{ $contract->id }}',
						funs: 'closeAC',
						flag: 'ajax',
						_token: '{{ @csrf_token() }}',
						codloan: '{{ $contract->CODLOAN }}',
						conttyp: '{{ $contract->CONTTYP }}',
						contno: '{{ $contract->CONTNO }}',
						locat: '{{ $contract->LOCAT }}',
						dateDuePay: $("#paymentDueDate").val()
					},
					complete: function() {
						$('.addSpin').html('')
						$(".loading-overlay").attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
					},
					success: function(response) {
						//console.log('success');
						//console.log(response);
						$("#_balance").val( response['tonbalance'] ); // เงินต้นคงเหลือ
						$("#_payintkang").val( response['payintkang'] ); // ดอกเบี้ยคงค้าง
						$("#_intkangtotal").val( response['intkangtotal'] ); // ดอกเบี้ยคงเหลือ

						@if( @$contract->CODLOAN == 2 )
							// เฉพาะเช่าซื้อเท่านั้น
							// ส่วนลดดอกเบี้ย %
							if ( response['dscpercen'] != $("#_dscpercen").val() ) {
								$("#_dscpercen").val( response['dscpercen'] );
								$("#dscpercen").val( response['dscpercen'] );
							}
							//$("#_dscint").val( response['dscint'] ); // ส่วนลดดอกเบี้ย
							//$("#_dscpercen").val( response['dscpercen'] ); // ส่วนลดดอกเบี้ย %
							$("#_nopay").val( response['nopay'] ); // งวดที่ปิดบัญชี
						@endif

						$("#_int_late_amt").val( response['INTLATEAMT'] ); // ค้างค่าปรับ
						$("#_letter").val( response['PAYFOLLOW'] ); // ค้างค่าทวงถาม
						$("#_other").val( response['Aroth'] ); // ลูกหนี้อื่น

						RefreshSummary();
						//-----------------------------------------------------------------------------------------
						@if( @$contract->CODLOAN == 2 ) {{-- เช่าซื้อ --}}
							// ปุ่ม ส่วนลดปิดบัญชี ตอนนี้ยังซ่อนไว้ก่อน
							// ทำให้ปุ่มกลับมาพร้อมใช้
							$("#discountAC_btn").prop('disabled', false);
							$('.addSpin').html('')
							// อัพเดต URL ของปุ่มดูส่วนลดปิดบัญชี (เติมวันที่เข้าไปใน input)
							var url = $("#discountAC_btn").data('link');
							var valueToAdd = $("#paymentDueDate").val();
							if (url.includes('payDueDT=')) {
								// If the parameter exists, replace its value with the new one
								url = url.replace(/payDueDT=([^&]*)/, 'payDueDT=' + encodeURIComponent(valueToAdd));
							} else {
								url += encodeURIComponent('&payDueDT=' + valueToAdd);
							}
							$("#discountAC_btn").attr('data-link', url);
						@endif
						//-----------------------------------------------------------------------------------------
						$('.addSpin').html('')
						$(".loading-overlay").attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
					},
					error: function(xhr, status, error) {
                        // Get the error message from the response
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "ข้อผิดพลาดที่ไม่รู้จัก :'(";
                        var errorFile = xhr.responseJSON.file ? xhr.responseJSON.file : '';
                        errorFile = errorFile.replace(/^.*[\\\/]/, '');
                        var errorLine = xhr.responseJSON.line ? xhr.responseJSON.line : '';
                        var errorHtml = "<p>" + errorMessage +"</p>";
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
                    }
				});
			}
		});

		$(".openDatepickerBtn").on('click', function() {
			//$(this).siblings('input').focus();
			$('#paymentDueDate').datepicker('show');
		});
	});
</script>

<script>
	function validateForms(dataform) {
		var isvalid = false;
		Array.prototype.slice.call(dataform).forEach(function(form) {
			if (!form.checkValidity()) {
				event.preventDefault();
				event.stopPropagation();

				form.classList.add('was-validated');

				isvalid = false;
			} else {
				isvalid = true;
			}
		});
		return isvalid;
	}

	$('[data-bs-toggle="tooltip"]').tooltip();
	
</script>

<!-- สคริปต์ปุ่มบันทึก -->
<script>
	$(document).ready(function() {

		$('.SaveDataAC_btn').click(function() {
			var dataform = document.querySelectorAll('.needs-validation');
			var validate = validateForms(dataform);
			if (validate == true) {
				var type = 1;
				var _token = $('input[name="_token"]').val();
				var data = {};
				$("#form_closeAC").serializeArray().map(function(x) {
					data[x.name] = x.value;
				});

				$('<span />', {
					class : "spinner-border spinner-border-sm",
					role : "status"
				}).appendTo("#SaveDataAC_btn.addSpin");
				$(".loading-overlay").attr('style', ''); //** แสดงตัวโหลด **
				
				$.ajax({
					url: "{{ route('payments.store') }}",
					method: "POST",
					data: {
						_token: '{{ csrf_token() }}',
						page: 'closeAC',
						data: data
					},
					complete: function() {
						$('#SaveDataAC_btn.addSpin').html('')
						$(".loading-overlay").attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
					},
					success: function(result) {
						Swal.fire({
							icon: 'success',
							title: 'บันทึกสำเร็จ!',
							text: 'บันทึกสำเร็จแล้ว ในตอนนี้สามารถพิมพ์ได้',
							confirmButtonText: 'เข้าใจแล้ว',
						});
						$('#printDataAC_btn').prop('disabled', false);
						$('#SaveDataAC_btn').prop('disabled', true);
						$('#acccloset_selected_id').val(result.itemid);

						// เซฟเสร็จแล้ว จะล็อค input ข้างหลังทั้งหมด
						$('#dscpercen').attr('readonly','readonly');
						$('#discount_extra_value').attr('readonly','readonly');
						$('#Note_CloseAC').attr('readonly','readonly');
						$('#paymentDueDate').datepicker('destroy');
						$('#paymentDueDate').siblings('.openDatepickerBtn').addClass('disabled');
						$('#speedBookFee_option option:not(:selected)').each( function() {
							$(this).prop('disabled', true);
						});
						$('#speedBookFee_value').attr('readonly','readonly');
					},
					error: function(xhr, status, error) {
                        // Get the error message from the response
                        var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "ข้อผิดพลาดที่ไม่รู้จัก :'(";
                        var errorFile = xhr.responseJSON.file ? xhr.responseJSON.file : '';
                        errorFile = errorFile.replace(/^.*[\\\/]/, '');
                        var errorLine = xhr.responseJSON.line ? xhr.responseJSON.line : '';
                        var errorHtml = "<p>" + errorMessage +"</p>";
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
                    }

				})
			}
		});

		$('.printDataAc_btn').click(function() {
			console.log("print_click!");
			
			// {{ route('report-backend.show', @$contract->id) }}?page=close-ac&CODLOAN={{ @$contract->CODLOAN }}&type=1"
			var itemid = $("#acccloset_selected_id").val();

			let url = `{{ route('report-backend.show', @$contract->id) }}?page=close-ac&CODLOAN={{ @$contract->CODLOAN }}&type=approve&itemid=${itemid}`;
            console.log( url );

            let newWindow = window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400,name=ใบอนุมัติขอปิดบัญชี");
            if (newWindow) {
                let browserWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
                let browserHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
                window.blur(); // ล่วงหน้าต่างของเบราว์เซอร์
                newWindow.focus(); // กลับมาโฟกัสที่หน้าต่าง Modal
                newWindow.resizeTo(browserWidth, browserHeight);
            }

		});

	});
</script>

@if( @$existing_close->count() > 0 )
<!-- สคริปต์โหลดข้อมูลที่เคยบันทึก -->
<script>
	$(document).ready(function() {

		var existing_close = @json($existing_close);

		$('#newAccClose_Btn').click(function() {
			$('.overlay-exist-ac').fadeOut( function() {
				$('.overlay-exist-ac').attr('style','display:none!important;')
			});
		});

	});

</script>

<script>

	var nf = new Intl.NumberFormat("th-TH", {
		//style: "currency",
		//currency: "THB",
		//currencyDisplay: "name",
		minimumFractionDigits: 2,
		maximumFractionDigits: 2,
	});

	var df = new Intl.DateTimeFormat('en-US', {
		day: '2-digit',
		month: '2-digit',
		year: 'numeric',
		timeZone: 'UTC'  // ตั้งค่าเขตเวลาเป็น UTC หากต้องการรับวันที่ในเขตเวลา UTC
	});


	// search-cla-docs-btn
	var existing_close = @json($existing_close);

	$('.search-cla-docs-btn').click(function() {
		$(".notification-cla").hide();
		if ( $("#cardBodyCLA").is(":visible") ) {
			$(".modal-footer").slideUp();
			$("#cardBodyCLA").slideUp('easeOutQuart', function() {
				$("#searchTableCLA").slideDown();
			});
		} else {
			$("#searchTableCLA").slideUp('easeOutQuart', function() {
				$("#cardBodyCLA").slideDown();
				$(".modal-footer").slideDown();
			});
		}
	});

	function LoadExistingCLA(index) {
		$('.cla-docno').val( existing_close[index]['DOCNO'] );
		var date_created_at = new Date(existing_close[index]['created_at']);
		$('#doc_date').val( df.format( date_created_at ) );
		$('#_tonbalance').val( existing_close[index]['TOTBAL'] );
		$('#_payintkang').val( existing_close[index]['PAYINTKANG'] );
		$('#_intkangtotal').val( existing_close[index]['INTKANGTOTAL'] );
		$('#_dscint').val( existing_close[index]['DISCT'] );
		$('#_dscpercen').val( existing_close[index]['DSCPERCEN'] );
		$('#_nopay').val( existing_close[index]['P_NOPAY'] );
		$('#_int_late_amt').val( existing_close[index]['KANGINT'] );
		$('#_letter').val( existing_close[index]['KANGFOLL'] );
		$('#_other').val( existing_close[index]['KANGOTH'] );

		// อัพเดตข้อมูลในการ์ดด้วย
		//----------------------
		let ex_cla = existing_close[index];
		$("#cd_locat").html(ex_cla['LOCAT']);
		$("#cd_contno").html(ex_cla['CONTNO']);

		$("#cd_totprc").html( nf.format(ex_cla['TOTPRC']) );
		$("#cd_smpay").html( nf.format(ex_cla['SMPAY']) );
		$("#cd_balan").html( nf.format(ex_cla['TOTPRC'] - ex_cla['SMPAY']) );
		$("#cd_expamt").html( nf.format(ex_cla['EXP_AMT']) );

		$("#cd_expprd").html( parseFloat(ex_cla['REXP_PRD']).toFixed(0) );
		$("#cd_expfrm").html(ex_cla['EXP_FRM']);
		$("#cd_expto").html(ex_cla['EXP_TO']);
		$("#cd_user").html( `${ex_cla['UserInsert']} (${ex_cla['USERID']})` );
		$("#cd_payfor").html( `${ex_cla['PAYFOR']} - ${ex_cla['PAYFOR']}` );
		//----------------------

		$('#dscpercen').val( existing_close[index]['DSCPERCEN'] );

		$('#speedBookFee_option').val( existing_close[index]['HOTBOOK'] );
		$('#speedBookFee_value').val( nf.format(existing_close[index]['EXPRESSAMT']) );
		var date_exp = new Date(existing_close[index]['EXPDATE']);
		$('#paymentDueDate').val( df.format(date_exp) );

		$('#discount_value').val( nf.format(existing_close[index]['DISCT']) );
		$('#discount_extra_value').val( nf.format(existing_close[index]['DISCT_EX']) );
		$('#Note_CloseAC').val( existing_close[index]['MEMO1'] );
			
		RefreshSummary();
	}

	$('.search-cla-btn').click(function() {
		LoadExistingCLA( $(this).data('itemindex') )
		var claid = existing_close[ $(this).data('itemindex') ]['id']
		$('#acccloset_selected_id').val(claid);

		// เมื่อโหลดเสร็จแล้ว จะล็อค input ข้างหลังทั้งหมด
		$('#dscpercen').attr('readonly','readonly');
		$('#discount_extra_value').attr('readonly','readonly');
		$('#Note_CloseAC').attr('readonly','readonly');
		$('#paymentDueDate').datepicker('destroy');
		$('#paymentDueDate').siblings('.openDatepickerBtn').addClass('disabled');
		$('#speedBookFee_option option:not(:selected)').each( function() {
			$(this).prop('disabled', true);
		});
		$('#speedBookFee_value').attr('readonly','readonly');
		$('#printDataAC_btn').prop('disabled', false);
		$('#SaveDataAC_btn').prop('disabled', true);
		
		$("#searchTableCLA").slideUp('easeOutQuart', function() {
			$("#cardBodyCLA").slideDown();
			$(".modal-footer").slideDown();
		});

	});
	

</script>
@endif