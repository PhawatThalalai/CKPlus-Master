<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>
<section class="content" style="font-family: 'Prompt', sans-serif;">
	<div class="modal-content">
		<form name="formCont" action="#" method="post" class="form-Validate" enctype="multipart/form-data" id="formCont">
			@csrf
			<input type="hidden" name="CodeLoan_Con" value="{{ @$data->CodeLoan_Con }}">
			<input type="hidden" name="newfdate" value="{{ @$newfdate }}">
			<input type="hidden" name="newtdate" value="{{ @$newtdate }}">
			<input type="hidden" name="type" value="{{ @$type }}">
			<input type="hidden" name="DataPact_id" value="{{ @$data->id }}">
			<input type="hidden" name="UserBranch" value="{{ @$data->UserBranch }}">
			<input type="hidden" name="DataTag_id" value="{{ @$data->DataTag_id }}">
			<input type="hidden" name="DataCus_id" value="{{ @$data->DataCus_id }}">
			{{-- <input type="hidden" name="DataAsset_id" value="{{ @$data->ContractToIndenture->Asset_id }}"> --}}
			<input type="hidden" id="Loan_Com" name="Loan_Com" value="{{ @$data->ContractToTypeLoan->Loan_Com }}">

			<input type="hidden" name="CONTTYP" value="{{ @$data->ContractToTypeLoan->Loan_Backend }}">
			<input type="hidden" name="APPLICANT" value="{{ @$data->ContractToUserApp->id }}">
			<input type="hidden" name="LOCAT" value="{{ @$data->ContractToBranch->id }}">
			<input type="hidden" name="CONTNO" value="{{ @$data->Contract_Con }}">
			<input type="hidden" name="SALECOD" value="{{ @$data->DocApp_Con }}">
			<input type="hidden" name="Id_Com" value="{{ @$data->ContractToTypeLoan->Id_Com }}">
			@php

				if ($data->ContractToDataCusTags->TagToCulculate->StatusProcess_Car == 'yes') {
				    $processCar = floatval($data->ContractToDataCusTags->TagToCulculate->Process_Car);
				} else {
				    $processCar = 0;
				}
				if ($data->ContractToDataCusTags->TagToCulculate->Buy_PA == 'yes' && @$data->ContractToDataCusTags->TagToCulculate->Include_PA == 'yes') {
				    $paRate = floatval(@$data->ContractToDataCusTags->TagToCulculate->Insurance_PA);
				} else {
				    $paRate = 0;
				}

				$sumTotal = floatval(@$data->ContractToDataCusTags->TagToCulculate->Cash_Car) + $processCar + $paRate + floatval(@$data->ContractToDataCusTags->TagToCulculate->Insurance);
				// dd(floatval(@$data->ContractToDataCusTags->TagToCulculate->Cash_Car), $processCar, $paRate, floatval(@$data->ContractToDataCusTags->TagToCulculate->Insurance));
			@endphp

			@php
				// Downpay
				if (@$data->ContractToOperated->Downpay_Price != 0) {
				    $Set_VATDAWN = (@$data->ContractToOperated->Downpay_Price * @$data->ContractToDataCusTags->TagToCulculate->Vat_Rate) / (@$data->ContractToDataCusTags->TagToCulculate->Vat_Rate + 100);
				    $Set_NDAWN = @$data->ContractToOperated->Downpay_Price - $Set_VATDAWN;
				} else {
				    $Set_VATDAWN = 0.0;
				    $Set_NDAWN = @$data->ContractToOperated->Downpay_Price;
				}

				// vat
				if (@$data->ContractToDataCusTags->TagToCulculate->Tax_Rate != 0) {
				    $sumTotal = $sumTotal + $Set_NDAWN;
				    $Set_VCSHPRC = @$sumTotal * (@$data->ContractToDataCusTags->TagToCulculate->Vat_Rate / 100);
				    $Set_NCSHPRC = $sumTotal;
				} else {
				    $Set_VCSHPRC = 0.0;
				    $Set_NCSHPRC = $sumTotal;
				}

				//dd(@$sumTotal, $data->ContractToDataCusTags->TagToCulculate->Vat_Rate / 100);

				$newInterest_Car = (floatval(@$data->ContractToDataCusTags->TagToCulculate->Profit_Rate) / @$data->ContractToDataCusTags->TagToCulculate->Timelack_Car / $sumTotal) * 100 * 12;
			@endphp

			<input type="hidden" name="VCSHPRC" value="{{ number_format(@$Set_VCSHPRC, 2) }}">
			<input type="hidden" name="NCSHPRC" value="{{ number_format(@$Set_NCSHPRC, 2) }}">
			<input type="hidden" name="VATDAWN" value="{{ number_format(@$Set_VATDAWN, 2) }}">
			<input type="hidden" name="NDAWN" value="{{ number_format(@$Set_NDAWN, 2) }}">
			<input type="hidden" name="totinterest" value="{{ floatval(@$data->ContractToDataCusTags->TagToCulculate->Profit_Rate - @$data->ContractToDataCusTags->TagToCulculate->Tax2_Rate) }}">
			<input type="hidden" name="INTFLATRATE" value="{{ @$newInterest_Car }}" placeholder="ดอกเบี้ย flat-rate">
			{{-- <input type="text" name="" value="{{ @$data->ContractToDataCusTags->TagToCulculate->totalInterest_Car }}" placeholder="ดอกเบี้ย flat-rate">	 --}}
			<div class="d-flex m-3">
				<div class="flex-shrink-0 me-2">
					<img class="" src="{{ URL::asset('assets/images/gif/edit-document.gif') }}" alt="" style="width: 50px">
				</div>
				<div class="flex-grow-1 overflow-hidden">
					<h5 class="text-primary fw-semibold font-size-15">สร้างการ์ดลูกหนี้ (Craete contract cards)</h5>
					<p class="text-muted mt-n1">contract : {{ @$data->Contract_Con }}</p>
					<p class="border-primary border-bottom mt-n2"></p>
				</div>
				<button type="button" class="btn-close btn-close-modal" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="mx-3">
				<div class="row ">
					<div class="col-sm-12 col-md-12 col-lg-4 col-xl-4  border-light border-end" id="Profile_Cus">
						<div class="row text-center m-2">
							<button type="button" class=" btn btn-primary bg-gradient waves-effect waves-light p-3 mb-2 rounded-pill ">
								เลขสัญญา : {{ @$data->Contract_Con }}
							</button>
						</div>
						<div class="row mt-1 text-center">
							<div class="col-lg-12 col-md-12">
								<img id="ImageCus" src="{{ isset($data->ContractToCus->image_cus) ? URL::asset(@$data->ContractToCus->image_cus) : asset('/assets/images/OIP.png') }}" style="width: 150px; height: 150px;" class="rounded-circle border border-5 border-white hover-up p-1" alt="User-Profile-Image">
							</div>
						</div>
						<div class="row mt-2 text-center">
							<div class="col-lg-12 col-md-12 mb-0">
								<h3 class="mb-1">{{ @$data->ContractToCus->Name_Cus }}</h3>
							</div>
						</div>

						<div class="table-responsive">
							<table class="table table-sm table-nowrap mb-0">
								<tbody class="text-center">
									<tr>
										<th scope="row">ประเภทสัญญา :</th>
										<td>
											{{ @$data->ContractToTypeLoan->Loan_Name }}
											<input type="text" value="{{ @$data->ContractToTypeLoan->Loan_Name }}" class="form-control ViewField d-none" placeholder="เลขที่สัญญา" readonly />
										</td>
									</tr>
									<tr>
										<th scope="row">วันที่ทำสัญญา :</th>
										<td>
											{{ formatDateThaiLong(date_format(date_create(@$data->Date_monetary), 'd-m-Y')) }}
											<input type="date" name="SDATE" value="{{ date_format(date_create(@$data->Date_monetary), 'Y-m-d') }}" class="form-control ViewField d-none" placeholder="วันที่ทำสัญญา" readonly />
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
					<div class="col-sm col-md col-lg col-xl">
						<div class="">
							<div class="row m-2">
								<button type="button" class=" btn btn-primary bg-gradient waves-effect waves-light p-3 mb-4 rounded-pill ">
									ข้อมูลสัญญา (Contract Deatails)
								</button>
								<div class="col border-light border-end">

									<div class="table-responsive">
										<table class="table table-sm table-nowrap mb-0">
											<tbody>
												<tr>
													<th scope="row">ราคาขายผ่อน :</th>
													<td>
														{{ number_format(@$data->ContractToDataCusTags->TagToCulculate->TotalPeriod_Rate + @$data->ContractToOperated->Downpay_Price, 2) }}
														<input type="hidden" name="TOTPRC" value="{{ number_format(@$data->ContractToDataCusTags->TagToCulculate->TotalPeriod_Rate + @$data->ContractToOperated->Downpay_Price, 2) }}" class="form-control form-control-sm textSize-13" placeholder="ราคาขายผ่อน" readonly />
													</td>
												</tr>
												<tr>
													<th scope="row">ผ่อนชำระ :</th>
													<td>
														1
														<input type="hidden" name="PERIOD" value="1" class="form-control form-control-sm textSize-13" placeholder="ผ่อนชำระ" readonly />
													</td>
												</tr>
												<tr>
													<th scope="row">งวดละ :</th>
													<td>
														{{ number_format(@$data->ContractToDataCusTags->TagToCulculate->Period_Rate, 2) }}
														<input type="hidden" name="TOT_UPAY" value="{{ number_format(@$data->ContractToDataCusTags->TagToCulculate->Period_Rate, 2) }}" class="form-control form-control-sm textSize-13" placeholder="ค่างวดงวดละ" readonly />
													</td>
												</tr>
												<tr>
													<th scope="row">ต้นทุนกู้ยืม :</th>
													<td>
														{{ number_format(@$sumTotal + $Set_VCSHPRC, 2) }}
														<input type="hidden" name="TCSHPRC" value="{{ number_format(@$sumTotal + $Set_VCSHPRC, 2) }}" class="form-control form-control-sm textSize-13" placeholder="0" readonly />
													</td>
												</tr>
												@if (@$data->ContractToOperated->Downpay_Price != 0)
													<tr>
														<th scope="row">เงินดาวน์ :</th>
														<td>
															{{ number_format(@$data->ContractToOperated->Downpay_Price, 2) }}
															<input type="hidden" name="TOTDAWN" value="{{ number_format(@$data->ContractToOperated->Downpay_Price, 2) }}" class="form-control form-control-sm textSize-13" placeholder="0" readonly />
														</td>
													</tr>
												@endif
												<tr>
													<th scope="row">ดอกเบี้ยต่อปี :</th>
													<td>

														{{-- @php
                                        $totalRate = floatval(@$data->ContractToDataCusTags->TagToCulculate->Cash_Car) + floatval(@$data->ContractToDataCusTags->TagToCulculate->Process_Car)+ floatval(@$data->ContractToDataCusTags->TagToCulculate->Insurance)+ floatval(@$data->ContractToDataCusTags->TagToCulculate->Insurance_PA);
                                      @endphp --}}
														{{ $irrYear }}
														<input type="hidden" name="Interest_IRR" value="{{ $irrYear }}" class="form-control form-control-sm textSize-13" placeholder="0" readonly />
													</td>
												</tr>
												@if (@$data->ContractToTypeLoan->Loan_Com == 2)
													<tr>
														<th scope="row">vat :</th>
														<td>
															{{ @$data->ContractToDataCusTags->TagToCulculate->Vat_Rate }}
															<input type="hidden" name="VATRT" value="{{ @$data->ContractToDataCusTags->TagToCulculate->Vat_Rate }}" class="form-control form-control-sm textSize-13" placeholder="vat" readonly />
														</td>
													</tr>
												@endif
												<tr>
													<th scope="row">จำนวนที่ผ่อน :</th>
													<td>
														{{ @$data->ContractToDataCusTags->TagToCulculate->Timelack_Car }}
														<input type="hidden" name="T_NOPAY" value="{{ @$data->ContractToDataCusTags->TagToCulculate->Timelack_Car }}" class="form-control form-control-sm textSize-13" placeholder="จำนวนที่ผ่อน" readonly />
													</td>
												</tr>
												<tr>
													<th scope="row">ดิวงวดแรก :</th>
													<td>
														{{ formatDateThaiLong(date_format(date_create(date('Y-m-d', strtotime(@$data->DateDue_Con))), 'd-m-Y')) }}
														<input type="date" name="FDATE" value="{{ date('Y-m-d', strtotime(@$data->DateDue_Con)) }}" class="form-control form-control-sm textSize-13 d-none" readonly />
													</td>
												</tr>
												<tr>
													<th scope="row">ดิวงวดสุดท้าย :</th>
													<td>
														{{ formatDateThaiLong(date_format(date_create(Paydue_LDATE(@$data->DateDue_Con, @$data->ContractToDataCusTags->TagToCulculate->Timelack_Car)), 'd-m-Y')) }}
														<input type="date" name="LDATE" value="{{ Paydue_LDATE(@$data->DateDue_Con, @$data->ContractToDataCusTags->TagToCulculate->Timelack_Car) }}" class="form-control form-control-sm textSize-13 d-none" readonly />
													</td>
												</tr>
											</tbody>
										</table>
									</div>

								</div>
								<div class="col">

									<div class="table-responsive">
										<table class="table table-sm table-nowrap mb-0">
											<tbody>
												<tr>
													<th scope="row">วันล่าช้าไม่เกิน :</th>
													<td>
														{{ @$Config->LATENFINE }}
														<input type="hidden" name="DLDAY" value="{{ @$Config->LATENFINE }}" class="form-control form-control-sm textSize-13 is-warning" placeholder="วันล่าช้าไม่เกิน" required />

													</td>
												</tr>
												<tr>
													<th scope="row">เบี้ยปรับล่าช้า :</th>
													<td>
														{{ number_format(@$Config->LATEPER, 2) }}
														<input type="hidden" name="INTLATE" value="{{ @$Config->LATEPER }}" class="form-control form-control-sm textSize-13 is-warning" placeholder="เบี้ยปรับล่าช้า" required />

													</td>
												</tr>
												<tr>
													<th scope="row">วันที่คิดดอกเบี้ย :</th>
													<td>
														{{ formatDateThaiLong(date('d-m-Y', strtotime('-30 days', strtotime(@$data->DateDue_Con)))) }}
														<input type="date" name="FDATEINT" value="{{ date('Y-m-d', strtotime('-30 days', strtotime(@$data->DateDue_Con))) }}" class="form-control form-control-sm textSize-13 is-warning bg-light d-none" data-toggle="tooltip" title="วันที่โอนเงิน : {{ date('d-m-Y', strtotime(@$data->DateDue_Con)) }}" readonly />
													</td>
												</tr>
											</tbody>
										</table>
									</div>

								</div>
							</div>

						</div>
					</div>
				</div>

			</div>
			<div class="modal-footer">
				<div class="row">
					<div class="col text-right">
						<button type="button" id="SaveData2" class="btn btn-primary btn-sm textSize-13 hover-up SaveData">
							<span class="textSize-13 text-white"><i class="fas fa-download"></i> บันทึกสัญญา <span class="addSpin"></span></span>
						</button>
						<button type="button" class="btn btn-secondary btn-sm waves-effect hover-up btn-close-modal" data-bs-dismiss="modal">
							<i class="mdi mdi-close-circle-outline"></i> ปิด
						</button>
					</div>
				</div>
			</div>

			<input type="hidden" name="MTHDDIS" value="{{ @$Config->MTHDDIS }}" placeholder="วิธีคำนวณยอดตัดสด" required />
			<input type="hidden" name="USEADD" value="{{ @$data->Adds_Con }}" placeholder="ที่อยู่ออกเอกสาร" required />

		</form>
	</div>

</section>

<script>
	$(document).ready(function() {
		$('[data-toggle="tooltip"]').tooltip();
	});
</script>

<script>
	$(function() {
		var Loan_Com = $('#Loan_Com').val();
		$(".SaveData").click(function(e) {
			e.preventDefault();

			Swal.fire({
				icon: "info",
				title: "ยืนยันการสร้างสัญญา ?",
				showDenyButton: false,
				showCancelButton: true,
				confirmButtonText: "ยืนยัน",
				// denyButtonText: `ยังไม่สร้าง`
			}).then((result) => {
				if (result.isConfirmed) {
					if ($("#formCont").valid() == true) {
						$('.SaveData').prop('disabled', true);
						$('.btn-close-modal').prop('disabled', true);
						$('<span />', {
							class: "spinner-border spinner-border-sm",
							role: "status"
						}).appendTo(".addSpin");
						$.ajax({
							url: "{{ route('contracts.store') }}",
							method: 'post',
							data: $('#formCont').serialize(),
							success: async function(response) {
								$('.SaveData').prop('disabled', true);
								$('.btn-close-modal').prop('disabled', true);

								await swal.fire({
									icon: 'success',
									title: 'บันทึกข้อมูลสำเร็จ',
									text: 'นำเข้าข้อมูลเรียบร้อย',
									timer: 1500,
									showConfirmButton: false,
								})
								await $('#modal_xl_2').modal('toggle');
								$('#viewDataBranch').html(response.html)
								$(`#row${response.idNow}`).addClass('bg-success bg-soft');
								setTimeout(() => {
									$(`#row${response.idNow}`).removeClass('bg-success bg-soft');
								}, 6000);


							},
							error: function(err) {
								console.log(err);
								$('.addSpin').hide();
								$('.SaveData').prop('disabled', false);
								$('.btn-close-modal').prop('disabled', false);
								swal.fire({
									icon: 'error',
									title: `ERROR ! ${err.status} บันทึกข้อมูลไม่สำเร็จ`,
									// text :'ไม่สามารถบันทึกข้อมูลได้ในขณะนี้ โปรดติดต่อ Programmer',
									text: `${err.responseJSON.message}`,

									showConfirmButton: true,
								})
							}
						});

					}
				} else if (result.isDenied) {
					Swal.fire("Changes are not saved", "", "info");
				}
			});



		});
	});
</script>
