<div class="row g-1">
	<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 pb-4  pt-1">
		<div class="card shadow-sm rounded-4 h-100 bg-light">
			<div class="bg-info bg-soft">
				<div class="row">
					<div class="col-7">
						<div class="text-primary p-3">
							{{-- <h5 class="text-primary">Welcome Back !</h5> --}}
						</div>
					</div>
					<div class="col-5 align-self-end">
						<img src="{{ URL::asset('/assets/images/profile-img.png') }}" alt="" class="img-fluid">
					</div>
				</div>
			</div>
			<div class="card-body pt-0">
				<div class="row">
					<div class="col-sm-4">
						<div class="avatar-md profile-user-wid mb-4">
							<img id="" src="{{ isset($data['data']->image_cus) ? URL::asset(@$data['data']->image_cus) : asset('/assets/images/users/user-1.png') }}" style="width: 100px; height: 100px;" class="img-thumbnail rounded-circle hover-up mb-2 boreder-img" alt="User-Profile-Image">
						</div>
					</div>

					<div class="col-sm-8 text-end">
						<div class="mt-2">
							<div class="">
								{{-- <span class="badge rounded-pill text-bg-danger px-3">รายการ</span> --}}
								{{-- <a href="{{ route('cus.index') }}?page={{'profile-cus'}}&id={{ @$data['data']->id }}" target="_blank" class="btn btn-primary waves-effect waves-light btn-sm  rounded-pill" type="button">ดูโปรไฟล์ <i class="mdi mdi-arrow-right ms-1"></i></a> --}}
							</div>
						</div>
					</div>
				</div>
				<div class="row mb-3">
					<h6 class="text-muted mb-3 fw-semibold">ข้อมูลทั่วไป (Personal Information)</h6>
					<div class="col-4 text-start font-size-11">ผู้ทำรายการ</div>
					<div class="col-8 text-end">
						<span class="badge rounded-pill bg-success bg-soft text-success">{{ Auth::user()->name }}</span>
					</div>
				</div>
				<div class="row">
					<h6 class="text-muted mb-3 fw-semibold ">ข้อมูลบัญชี (Data Account)</h6>
					<div class="row" style="max-height: 190px; overflow-y : scroll;">
						<div class="col">
							@foreach (@$DatabankAccount as $item)
								<div class="">
									<div class="py-2 border-bottom">
										<h5 class="font-size-13 fw-semibold"><i class="bx bxs-label me-1 text-danger"></i>{{ @$item->Account_Bank }}</h5>
										{{-- <div class="progress animated-progess progress-sm">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ @$percent }}%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="85"></div>
                                        </div> --}}
										<h5 class="font-size-11 mt-1">ยอดคงเหลือ<span class="float-end text-success">{{ @$item->Amount_after != null ? number_format(@$item->Amount_after, 2) : 0 }}</span></h5>
									</div>
								</div>
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
		<div class="d-flex scroll pb-2" style="overflow-x : scroll;">
			@foreach (@$data->ContractToPayee as $item)
				@php
					$amount = 0;
					if (@$item->status_Payee == 'Payee') {
						$amount = floatval(@$item->PayeetoCon->ContractToOperated->Balance_Price) - floatval($item->transferCash);
						$balance = floatval(@$item->PayeetoCon->ContractToOperated->Balance_Price) ;
					} else {
					    $amount = floatval(@$item->PayeetoCon->ContractToOperated->AccountClose_Price) - floatval($item->transferCash);
					    $balance = floatval(@$item->PayeetoCon->ContractToOperated->AccountClose_Price);
					}
				@endphp
				@component('components.content-card.card-account-treas')
					@slot('data', [
						'id' => @$item->id,
						'index' => $loop->iteration,
						'idCus' => @$item->PayeetoCus->id,
						'nameCusTH' => @$item->PayeetoCus->Name_Cus,
						'nameCusENG' => @$item->PayeetoCus->NameEng_cus,
						'imageCus' => @$item->PayeetoCus->image_cus,
						'typeCus' => @$item->PayeetoCon->ContractToDataCusTags->TagToTypeCusRe->Name_CusResource, // แหล่งที่มาลูกค้า
						'typeCusFN' => @$item->PayeetoCon->ContractToDataCusTags->TagToStatusCus->Code_Cus, // ประเภทลูกค้า
						'typeStatus' => @$item->PayeetoCon->ContractToDataCusTags->TagToStatusCus->Name_Cus, // ประเภทลูกค้า
						'status' => @$item->status_Payee,
						'statusTxt' => @$item->status_Payee == 'Payee' ? 'ผู้รับเงิน' : 'ปิดบัญชี', // broker or Cus
						'numberAccount' => @$item->PayeetoCus->Number_Account,
						'nameAccount' => @$item->PayeetoCus->Name_Account,
						'branchAccount' => @$item->PayeetoCus->Branch_Account,
						'Phone' => @$item->PayeetoCus->Phone_cus,
						'amount' => $amount,
						'balance' => $balance,
						'transactionDate' => date('Y-m-d'),
						'bankAccount' => @$DatabankAccount,
						'bankAccountReceive' => @$item->PayeetoCus->DataCusToCom->CompanyToBankAcc,
						'pact_id' => @$data->id,
						'Bank_Close' => @$data->Bank_Close,
						'FlagSpecial_Trans' => @$data->FlagSpecial_Trans, // ปิดบัญชี
						'Date_BookSpecial' => @$data->Date_BookSpecial, // รับเล่มทะเบียน
						'Loan_com' => $data->ContractToTypeLoan->Loan_Com,
						'Balance_Price' => @$item->PayeetoCon->ContractToOperated->Balance_Price,
						'transferCash' => @$item->transferCash,
						'statusTransfer' => @$item->Date_Payee_montary != null ? 'yes' : 'no',
						'transferBank' => @$item->transferBank,
						'status_Payee' => @$item->status_Payee,
						'AccountClose_Price' => @$item->PayeetoCon->ContractToOperated->AccountClose_Price,
						'CodeLoan_Con' => @$data->CodeLoan_Con,
						'checkCom' => @$checkCom,
						'btn_idTransfer' => 'payee_'.@$item->id,
						'Pay_method' => @$item->Pay_method,
						'Person_Close' => @$item->Person_Close,
						'Status_Com' => @$item->PayeetoCus->Status_Com,
						])
					@endcomponent
				@endforeach
					@php
						$typeBroker  = array('1'=>'นายหน้าทั่วไป','2'=>'จดทะเบียน','3'=>'พนักงาน');
					@endphp
				@foreach (@$data->ContractToBrokers as $item)
					@component('components.content-card.card-account-treas')
						@slot('data', [
							'id' => @$item->id,
							'index' => $loop->iteration,
							'idCus' => @$item->BrokertoCus->id,
							'nameCusTH' => @$item->BrokertoCus->Name_Cus,
							'nameCusENG' => @$item->BrokertoCus->NameEng_cus,
							'imageCus' => @$item->BrokertoCus->image_cus,
							'typeCus' => @$item->BrokertoCus->CusToCusTagOne->TagToTypeCusRe->Name_CusResource,
							'status' => 'Broker',
							'statusTxt' => 'ผู้แนะนำ', // broker or Cus
							'numberAccount' => @$item->BrokertoCus->Number_Account,
							'nameAccount' => @$item->BrokertoCus->Name_Account,
							'branchAccount' => @$item->BrokertoCus->Branch_Account,
							'Phone' => @$item->BrokertoCus->Phone_cus,
							'amount' => floatval(@$item->SumCom_Broker) - floatval(@$item->transferCash),
							'balance' => @$item->SumCom_Broker,
							'transactionDate' => date('Y-m-d'),
							'bankAccount' => @$DatabankAccount,
							'pact_id' => @$data->id,
							'FlagSpecial_Trans' => @$data->FlagSpecial_Trans, // ปิดบัญชี
							'Date_BookSpecial' => @$data->Date_BookSpecial, // รับเล่มทะเบียน
							'Loan_com' => $data->ContractToTypeLoan->Loan_Com,
							'Balance_Price' => @$item->SumCom_Broker,
							'transferCash' => @$item->transferCash,
							'Date_Brk_montary' => @$item->Date_Brk_montary,
							'statusTransfer' => floatval(@$item->SumCom_Broker) - floatval(@$item->transferCash) == 0 ? 'yes' : '',
							'transferBank' => @$item->transferBank,
							'typeBroker'=> $typeBroker[$item->BrokertoCus->DataCusToBroker->type_Broker],
							'btn_idTransfer' => 'broker_'.@$item->id,
							'Pay_method' => @$item->Pay_method,
							'Person_Close' => @$item->Person_Close,
							'Status_Com' => @$item->BrokertoCus->Status_Com,

							])
						@endcomponent
					@endforeach
				</div>
			</div>
		</div>

		<script>

			$(".typeCash").change(function(e){ 
					if( $(e.currentTarget).is(":checked") ){ // check if the radio is checked
						var val = $(e.currentTarget).val();
						console.log(val); // retrieve the value
					}
			});


			$('.btn-transfer').click((e) => {
				e.preventDefault();
				let idBank = $('#idBank').val()
				let cusID = $(e.currentTarget).attr("cusID");
				let status = $(e.currentTarget).attr("status");
				let bank = $(e.currentTarget).attr("bank");
				let accout_status = $('option:selected', '#Bank_idReceive-'+bank).attr('accout-status')
				let bankCheck = $('#Bank_id-' + bank).val()
				let bankReceiveCheck = $('#Bank_idReceive-'+bank).val()
				let btn_id = e.currentTarget.id;
				let typeCash = $("input[id=Pay_method-"+bank+"]:checked").val();
				$('.accout_status').val(accout_status)

				if(typeCash == null){
					swal.fire({
						icon: 'warning',
						title: 'แจ้งเตือน !',
						text: 'กรุณาเลือกประเภทการชำระเงิน',
					})

					return
				}	
				if (bankCheck != '' && bankReceiveCheck != '') {
					$('.loading').show()
					$('.transfered').hide()
					$('.btn-transfer').prop('disabled', true);
					$('#cancelApprove').prop('disabled', true);
					$('#cancelApprove').hide();
					
					$.ajax({
						url: '{{ route('treas.store') }}',
						type: 'POST',
						data: $('#transfer' + status + '-' + cusID).serialize(),
						success: (res) => {
							// $('#content-transfer').html(res.pageTransfer)
							$('#'+btn_id).html('โอนเงินแล้ว <i class="bx bx-transfer"></i>').removeClass('btn-primary').addClass('btn-success');
							$('.input-'+btn_id).val(0);
							if (res.contents != null) {
								var navtab = $('.nav-item').find('.active').attr('data-tabCont');
								var navcount = $('.nav-item').find('.active').attr('data-count');
								var loan = $(".card-com.type_loan.border-primary").attr("data-typeloan");

								$('#data-treas #row_'+res.contents).hide();
								if (navtab == 'nav-old') {
									if (loan == 1) {
										let num = $('.span-CKP-OLD').text();
										$('.span-CKP-OLD').text(parseInt(num - 1));
									}else{
										let num = $('.span-CKL-OLD').text();
										$('.span-CKL-OLD').text(parseInt(num - 1));
									}
									$('.nav-countContOld').text(parseInt(navcount - 1));
								}else{
									if (loan == 1) {
										let num = $('.span-CKP-NEW').text();
										$('.span-CKP-NEW').text(parseInt(num - 1));
									}else{
										let num = $('.span-CKL-NEW').text();
										$('.span-CKL-NEW').text(parseInt(num - 1));
									}
									$('.nav-countContNew').text(parseInt(navcount - 1));
								}
							}

							swal.fire({
								icon: 'success',
								title: res.title,
								text: res.message,
								timer: 2000
							})
						},
						error: (err) => {
							if (err.flag_transfer != '') {
								if (err.flag_transfer == 'received') {
									$('#'+btn_id).html('โอนเงินแล้ว <i class="bx bx-transfer"></i>').removeClass('btn-primary').addClass('btn-success');
									$('#cancelApprove').prop('disabled', true);
								}
							}

							swal.fire({
								icon: 'error',
								title: err.responseJSON.title,
								text:  err.responseJSON.message,
							})
						},
						complete: () => {
							$('.loading').hide()
							$('.transfered').show()
							$('.addSpin').empty();
							$('.btn-transfer').prop('disabled', false);
						}
					})
				} else {
					swal.fire({
						icon: 'warning',
						title: 'แจ้งเตือน !',
						text: 'กรุณาเลือกบัญชีธนาคาร ให้ครบ ก่อนทำการโอนเงินออก',
					})
				}
			})
		</script>

		{{-- mouse scroll-slide --}}
		<script>
			document.querySelector('.scroll').addEventListener('wheel', (e) => {
				e.preventDefault();
				const delta = e.deltaY || e.detail || e.wheelDelta;
				document.querySelector('.scroll').scrollLeft += delta;
			});
		</script>
