@extends('layouts.master')
@section('title', 'Contract')
@section('contract-p1-active', 'mm-active')
@section('page-frontend', 'd-none')

@section('content')

	@include('components.content-search.view-search', ['page_type' => @$page_type, 'page' => @$page, 'pageUrl' => @$pageUrl, 'typeSreach' => @$typeSreach, 'dataSreach' => @$dataSreach])

	@component('components.breadcrumb')
		@slot('title')
			Edit Contract
		@endslot
		@slot('title_small')
			(แก้ไขข้อมูลสััญญา)
		@endslot
		@slot('btnSearch', true)
	@endcomponent

	<div class="row">
		<div class="col-xl-3 col-lg-12 col-md-12 col-sm-12">
			<div id="card-profile-b-end">
				@include('components.content-user.backend.view-profile-b-end', [
					'megaMenu' => true,
					'page' => 'contracts',
					'pact' => @$pact,
				])
			</div>
		</div>
		@if (@$contract != null)
			<div class="col-xl-9 col-lg-12 col-md-12 col-sm-12">
				<div class="card ">
					<form id="edit_contract" class="modal-content needs-validation" action="#" novalidate>
						@csrf
						<input type="hidden" name="page" id="page" value="viewContract">
						<input type="hidden" name="funs" value="edit">
						{{-- <input type="hidden" name="id" value="{{@$contract->id}}"> --}}
						<input type="hidden" name="id" value="{{ @$pact->id }}">

						<div class="card-body">

							<div class="row g-2">
								<div class="col-xl-4 col-12">

									<fieldset class="reset border-1 border-primary border-opacity-25 rounded-3 mb-2">
										<legend class="reset">
											<h6 class="text-primary fw-semibold mb-3"><i class="mdi mdi-finance fs-4"></i> ข้อมูลดอกเบี้ย</h6>
										</legend>
										<div class="row g-2">

											<div class="row g-2 col-xl-12 col-lg-8 col-8">
												<div class="col-xl-12 col-lg-6 col-6 mb-xl-3 mb-lg-2">
													<div class="input-bx">
														<input type="text" name="INTLATE" id="INTLATE" class="form-control text-end" placeholder=" " value="{{ number_format(@$contract->INTLATE, 2) }}" required />
														<span class="text-danger">เบี้ยปรับต่อเดือน</span>
														<button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 disabled">%</button>
													</div>
												</div>
												<div class="col-xl-12 col-lg-6 col-6 mb-xl-3 mb-lg-1">
													<div class="input-bx">
														<input type="text" name="DLDAY" id="DLDAY" class="form-control text-end" placeholder=" " value="{{ @$contract->DLDAY }}" required />
														<span class="text-danger">วันล่าช้า</span>
														<button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 disabled">วัน</button>
													</div>
												</div>
												<div class="col-xl-12 col-lg-6 col-6 mb-xl-3 mb-lg-1">
													<div class="input-bx">
														<input type="text" name="VATRT" id="VATRT" class="form-control text-end" placeholder=" " value="{{ number_format(@$contract->VATRT, 2) }}" @required(@$contract->CODLOAN == 2) @readonly(@$contract->CONTTYP != 2) />
														<span class="text-danger">ภาษี</span>
														<button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 disabled">%</button>
													</div>
												</div>
												<div class="col-xl-12 col-lg-6 col-6 mb-xl-3 mb-lg-1">
													<div class="input-bx">
														<input type="text" name="MAXINT" id="MAXINT" class="form-control text-end" placeholder=" " value="24" readonly />
														<span>ดอกเบี้ยต่อปี</span>
														<button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 disabled">%</button>
													</div>
												</div>
											</div>

											<div class="col-xl-12 col-lg-4 col-4">
												<div class="d-felx">
													<div class="d-flex justify-content-center">
														<div>
															<span class="bg-light fw-bold text-danger" style="font-size: 0.65rem; padding: 0 10px; letter-spacing: 0.1rem; border-radius: 16px; color: #7f8fa6;">วิธีคำนวณส่วนลดตัดสด</span>
															<div class="form-check my-2">
																<input class="form-check-input" type="radio" name="MTHDDIS" id="flexRadioDefault1" value="skb">
																<label class="form-check-label" for="flexRadioDefault1">
																	เปอร์เซ็นส่วนลด สคบ
																</label>
															</div>
															<div class="form-check my-2">
																<input class="form-check-input" type="radio" name="MTHDDIS" id="flexRadioDefault2" value="n" checked>
																<label class="form-check-label" for="flexRadioDefault2">
																	เปอร์เซ็นส่วนลดปกติ
																</label>
															</div>
														</div>
													</div>
												</div>
											</div>

											{{-- 
                                            <div class="col-xl-12 col-lg-8 col-6 mb-xl-3 mb-lg-1">
                                                <span class="bg-light fw-bold text-danger" style="font-size: 0.65rem; padding: 0 10px; letter-spacing: 0.1rem; border-radius: 16px; color: #7f8fa6;">วิธีคำนวณส่วนลดตัดสด</span>
                                                <div class="form-check my-2">
                                                    <input class="form-check-input" type="radio" name="MTHDDIS" id="flexRadioDefault1" value="skb">
                                                    <label class="form-check-label" for="flexRadioDefault1">
                                                        เปอร์เซ็นส่วนลด สคบ
                                                    </label>
                                                </div>
                                                <div class="form-check my-2">
                                                    <input class="form-check-input" type="radio" name="MTHDDIS" id="flexRadioDefault2" value="n" checked>
                                                    <label class="form-check-label" for="flexRadioDefault2">
                                                        เปอร์เซ็นส่วนลดปกติ
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6 mb-2 d-none">
                                                <span class="bg-light fw-bold text-danger" style="font-size: 0.65rem; padding: 0 10px; letter-spacing: 0.1rem; border-radius: 16px; color: #7f8fa6;">การคำนวณเบี้ยปรับ</span>
                                                <div class="form-check my-2">
                                                    <input class="form-check-input" type="radio" name="MTHDFINE" id="flexRadioDefault_2_1" value="mmr">
                                                    <label class="form-check-label" for="flexRadioDefault_2_1">
                                                        อัตรา MRR. + ค่าคงที่
                                                    </label>
                                                </div>
                                                <div class="form-check my-2">
                                                    <input class="form-check-input" type="radio" name="MTHDFINE" id="flexRadioDefault_2_2" value="month" checked>
                                                    <label class="form-check-label" for="flexRadioDefault_2_2">
                                                        อัตราเปอร์เซ็นต่อเดือน
                                                    </label>
                                                </div>
                                            </div>
                                            --}}
										</div>
									</fieldset>

								</div>
								<div class="col-xl-8 col-12">
									<fieldset class="reset border-1 border-primary border-opacity-25 rounded-3">
										<legend class="reset">
											<h6 class="text-primary fw-semibold mb-3"><i class="mdi mdi-file-document-outline fs-4"></i> ข้อมูลสัญญาและเอกสาร</h6>
										</legend>
										<div class="col-sm-12">
											<div class="row g-2 d-flex align-items-center">
												<div class="col-4">
													<div class="input-bx">
														<input type="type" name="CONTSTAT" id="CONTSTAT" class="form-control" placeholder=" " value="{{ @$contract->CONTSTAT }}" readonly required />
														<span class="text-danger">สถานะสัญญา</span>
														<button class="mx-0 btn btn-light border border-secondary border-opacity-50 modal_lg d-flex align-items-center" data-link="{{ route('constants.create') }}?page={{ 'backend' }}&FlagBtn={{ 'CONTSTAT' }}">
															<i class="d-flex dripicons-menu"></i>
														</button>
													</div>
												</div>
												<div class="col-8">
													<input type="type" name="CONTDESC" id="CONTDESC" class="form-control" placeholder=" " value="{{ @$contract->PactToStatus->CONTDESC }}" readonly />
												</div>
											</div>
											<div class="row g-2 mt-3 d-flex align-items-center">
												<div class="col-4 mb-2">
													<div class="input-bx">
														<input type="text" name="RECONTNO" id="RECONTNO" class="form-control" placeholder=" " value="" />
														<span>สัญญาที่ Re.</span>
													</div>
												</div>
												<div class="col-4 mb-2">
													<div class="input-bx">
														<input type="date" name="CARRDT" id="CARRDT" class="form-control" placeholder=" " value="" />
														<span>วันที่ปล่อยรถ</span>
													</div>
												</div>
												<div class="col-4 mb-2">
													<div class="input-bx">
														<input type="text" name="SO" id="SO" class="form-control" placeholder=" " value="" />
														<span>ใบอนุมัติขาย</span>
													</div>
												</div>

												@php
													@$data['dataCus'] = @$contract->PatchToPact->ContractToCus;
													@$CusAdds01 = null;
													@$CusAdds02 = null;
													@$CusAdds03 = null;

													if (@$data['dataCus']->DataCusToDataCusAddsMany->isNotEmpty()) {
													    @$CusAdds01 = @$data['dataCus']->DataCusToDataCusAddsMany
													        ->filter(function ($row) {
													            return $row->Type_Adds == 'ADR-0001' && $row->Status_Adds == 'active';
													        })
													        ->first();
													}
													if (@$data['dataCus']->DataCusToDataCusAddsMany->isNotEmpty()) {
													    @$CusAdds02 = @$data['dataCus']->DataCusToDataCusAddsMany
													        ->filter(function ($row) {
													            return $row->Type_Adds == 'ADR-0002' && $row->Status_Adds == 'active';
													        })
													        ->first();
													}
													if (@$data['dataCus']->DataCusToDataCusAddsMany->isNotEmpty()) {
													    @$CusAdds03 = @$data['dataCus']->DataCusToDataCusAddsMany
													        ->filter(function ($row) {
													            return $row->Type_Adds == 'ADR-0003' && $row->Status_Adds == 'active';
													        })
													        ->first();
													}

													//----------------------------
													@$AddsCheck = @$CusAdds02 != null ? 2 : (@$CusAdds01 != null ? 1 : 3);
													//----------------------------
													if (@$contract->USEADD != null) {
													    if (@$contract->USEADD == 'ADR-0001') {
													        @$AddsCheck = $CusAdds01 != null ? 1 : (@$CusAdds02 != null ? 2 : 3);
													    } elseif (@$contract->USEADD == 'ADR-0003') {
													        @$AddsCheck = $CusAdds03 != null ? 3 : (@$CusAdds02 != null ? 2 : 1);
													    }
													}
													//----------------------------
												@endphp

												<div class="col-12 mb-2 flex-column">
													<span class="bg-light fw-bold text-danger" style="font-size: 0.65rem; padding: 0 10px; letter-spacing: 0.1rem; border-radius: 16px; color: #7f8fa6;">ที่อยู่ออกเอกสาร</span>
													<div class="form-check-label mt-2">
														<div class="btn-group d-flex flex-wrap" role="group" aria-label="Basic radio toggle button group">
															<input type="radio" class="btn-check" name="USEADD" id="useAdds01" value="ADR-0001" autocomplete="off" @disabled($CusAdds01 == null) @if ($AddsCheck == 1) checked @endif>
															<label class="btn btn-outline-primary col-4 m-0 d-flex flex-column justify-content-center" for="useAdds01">
																<i class="mdi mdi mdi-home fs-5"></i>
																ที่อยู่ปัจจุบัน
															</label>

															<input type="radio" class="btn-check" name="USEADD" id="useAdds02" value="ADR-0002" autocomplete="off" @disabled($CusAdds02 == null) @if ($AddsCheck == 2) checked @endif>
															<label class="btn btn-outline-primary col-4 m-0 d-flex flex-column justify-content-center" for="useAdds02">
																<i class="mdi mdi-home-export-outline fs-5"></i>
																ที่อยู่จัดส่งเอกสาร
															</label>

															<input type="radio" class="btn-check" name="USEADD" id="useAdds03" value="ADR-0003" autocomplete="off" @disabled($CusAdds03 == null) @if ($AddsCheck == 3) checked @endif>
															<label class="btn btn-outline-primary col-4 m-0 d-flex flex-column justify-content-center" for="useAdds03">
																<i class="mdi mdi-home-account fs-5"></i>
																ที่อยู่ตามสำเนาทะเบียนบ้าน
															</label>
														</div>
													</div>

												</div>
											</div>
										</div>
									</fieldset>

									<div class="col-md-12 p-3 px-1">
										<div class="form-floating">
											<textarea class="form-control" placeholder="Leave a comment here" name="MEMO" id="MEMO" maxlength="65535" style="height: 100px">{{ @$contract->MEMO }}</textarea>
											<label for="Note_cus" class="fw-bold">หมายเหตุ</label>
										</div>
									</div>

								</div>
							</div>

							<div class="col text-end pt-2">
								<button type="button" id="edit_contract_Save" class="btn btn-success btn waves-effect waves-light w-sm textSize-13 hover-up">
									<span class="textSize-13 text-white">
										<i class="fas fa-download"></i> บันทึก <span class="addSpin"></span>
									</span>
								</button>
								<button type="button" class="d-none btn btn-secondary btn waves-effect waves-light w-sm hover-up btn-close-modal" data-bs-dismiss="modal">
									<i class="fas fa-share"></i> ปิด
								</button>
							</div>

						</div>
					</form>
				</div>
			</div>
		@else
			<div class="col-xl-9 col-lg-12 col-md-12 col-sm-12">
				<div class="card card-body justify-content-center h-100">
					<div class="row justify-content-center">
						<div class="col-12">
							<div class="maintenance-img">
								<img src="{{ asset('assets/images/undraw/undraw_text_field_htlv.svg') }}" alt="" class="img-fluid mx-auto d-block" style="max-height: 500px;">
							</div>
						</div>
					</div>
				</div>
			</div>
		@endif
	</div>

	@if (!empty(@$contract))
		<script>
			$(document).ready(function() {
				$('#edit_contract_Save').click(function() {
					var dataform = document.querySelectorAll('#edit_contract');
					var validate = validateForms(dataform);
					if (validate == true) {

						$(this).prop('disabled', true);
						$('<span />', {
							class: "spinner-border spinner-border-sm",
							role: "status"
						}).appendTo(".addSpin");

						var type = 1;
						var _token = $('input[name="_token"]').val();
						var data = {};
						$("#edit_contract").serializeArray().map(function(x) {
							data[x.name] = x.value;
						});

						/*
						if ($('#page').val() == 'Customer') {
						    var url = '{{ route('cus.update', 0) }}';
						}
						*/
						var url = '{{ route('contracts.update', @$contract->id) }}';

						$.ajax({
							url: url,
							method: "PUT",
							data: {
								_token: _token,
								type: type,
								CODLOAN: parseInt('{{ @$contract->CODLOAN }}'),
								data: data
							},
							complete: function(event) {
								$('.addSpin').hide();
								$(this).prop('disabled', false);
							},
							success: function(result) {
								//$('#modal_editContract').modal('hide');
								Swal.fire({
									icon: 'success',
									text: 'บันทึกสำเร็จ! \nหน้าเว็บจะรีเฟรชเองอัติโนมัติ',
									showConfirmButton: true,
									ConfirmButtonText: 'เข้าใจแล้ว',
								});
								// อัพเดตสถานะ กับ หมายเหตุด้านนอก หลังจากกดเซฟ
								//$('#card-profile-b-end').html(result.viewProfile);
								//$('#card-contracts').html(result.viewCon);
								//$('#content_cus').html(result);

								// Refresh the page
								location.reload();
							},
							error: function(err) {
								swal.fire({
									icon: 'error',
									title: `ERROR ! ${err.status} บันทึกข้อมูลไม่สำเร็จ`,
									// text :'ไม่สามารถบันทึกข้อมูลได้ในขณะนี้ โปรดติดต่อ Programmer',
									text: `${err.responseJSON.message}`,
									showConfirmButton: true,
								})
							}
						})


					} else {
						console.log('not validate !!');
					}
				});
			});
		</script>
	@endif

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
	</script>

@endsection
