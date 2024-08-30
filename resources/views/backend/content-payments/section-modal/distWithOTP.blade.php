<style>
	@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap");

	.plans {
		display: -webkit-box;
		display: -ms-flexbox;
		display: flex;
		-webkit-box-pack: justify;
		-ms-flex-pack: justify;
		justify-content: space-between;
		max-width: 970px;
		/* padding: 85px 50px; */
		-webkit-box-sizing: border-box;
		box-sizing: border-box;
		/* background: #fff; */
		/* border-radius: 20px; */
		/* -webkit-box-shadow: 0px 8px 10px 0px #d8dfeb; */
		/* box-shadow: 0px 8px 10px 0px #d8dfeb; */
		-webkit-box-align: center;
		-ms-flex-align: center;
		align-items: center;
		-ms-flex-wrap: wrap;
		flex-wrap: wrap;
	}

	.plans .plan input[type="radio"] {
		position: absolute;
		opacity: 0;
	}

	.plans .plan {
		cursor: pointer;
		width: 100%;
		/* Change from 48.5% to 100% */
		margin-bottom: 15px;
		/* Add some margin for spacing */
		display: block;
		/* Ensure labels are block elements */
	}

	.plans .plan .plan-content {
		display: -webkit-box;
		display: -ms-flexbox;
		display: flex;
		padding: 13px;
		padding-bottom: 5px;
		-webkit-box-sizing: border-box;
		box-sizing: border-box;
		border: 2px solid #e1e2e7;
		border-radius: 10px;
		-webkit-transition: -webkit-box-shadow 0.4s;
		transition: -webkit-box-shadow 0.4s;
		-o-transition: box-shadow 0.4s;
		transition: box-shadow 0.4s;
		transition: box-shadow 0.4s, -webkit-box-shadow 0.4s;
		position: relative;
	}

	.plans .plan .plan-content img {
		margin-right: 30px;
		height: 72px;
	}

	.plans .plan .plan-details span {
		margin-bottom: 10px;
		display: block;
		font-size: 18px;
		line-height: 24px;
		color: #252f42;
	}

	.container .title {
		font-size: 20px;
		font-weight: 500;
		-ms-flex-preferred-size: 100%;
		flex-basis: 100%;
		color: #252f42;
		margin-bottom: 20px;
	}

	.plans .plan .plan-details p {
		color: #646a79;
		font-size: 13px;
		line-height: 18px;
	}

	.plans .plan .plan-content:hover {
		-webkit-box-shadow: 0px 3px 5px 0px #e8e8e8;
		box-shadow: 0px 3px 5px 0px #e8e8e8;
	}

	.plans .plan input[type="radio"]:checked+.plan-content:after {
		content: "";
		position: absolute;
		height: 15px;
		width: 15px;
		background: #216fe0;
		right: 20px;
		top: 20px;
		border-radius: 100%;
		border: 3px solid #fff;
		-webkit-box-shadow: 0px 0px 0px 2px #0066ff;
		box-shadow: 0px 0px 0px 2px #0066ff;
	}

	.plans .plan input[type="radio"]:checked+.plan-content {
		border: 2px solid #216ee0;
		background: #eaf1fe;
		-webkit-transition: ease-in 0.3s;
		-o-transition: ease-in 0.3s;
		transition: ease-in 0.3s;
	}

	@media screen and (max-width: 991px) {
		.plans {
			margin: 0 20px;
			-webkit-box-orient: vertical;
			-webkit-box-direction: normal;
			-ms-flex-direction: column;
			flex-direction: column;
			-webkit-box-align: start;
			-ms-flex-align: start;
			align-items: flex-start;
			padding: 40px;
		}

		.plans .plan {
			width: 100%;
		}

		/* .plan.complete-plan {
			margin-top: 20px;
		} */
		.plans .plan .plan-content .plan-details {
			width: 70%;
			display: inline-block;
		}

		.plans .plan input[type="radio"]:checked+.plan-content:after {
			top: 45%;
			-webkit-transform: translate(-50%);
			-ms-transform: translate(-50%);
			transform: translate(-50%);
		}
	}

	@media screen and (max-width: 767px) {
		.plans .plan .plan-content .plan-details {
			width: 60%;
			display: inline-block;
		}
	}

	@media screen and (max-width: 540px) {
		.plans .plan .plan-content img {
			margin-bottom: 20px;
			height: 56px;
			-webkit-transition: height 0.4s;
			-o-transition: height 0.4s;
			transition: height 0.4s;
		}

		.plans .plan input[type="radio"]:checked+.plan-content:after {
			top: 20px;
			right: 10px;
		}

		.plans .plan .plan-content .plan-details {
			width: 100%;
		}

		.plans .plan .plan-content {
			padding: 20px;
			-webkit-box-orient: vertical;
			-webkit-box-direction: normal;
			-ms-flex-direction: column;
			flex-direction: column;
			-webkit-box-align: baseline;
			-ms-flex-align: baseline;
			align-items: baseline;
		}
	}
</style>

<div class="modal-content">
	<div class="d-flex m-3 mb-0">
		<div class="flex-shrink-0 me-2">
			<img src="{{ asset('assets/images/gif/dividends.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
		</div>
		<div class="flex-grow-1 overflow-hidden">
			<h5 class="text-primary fw-semibold">ส่วนลดการปิดบัญชี</h5>
			<p class="text-muted mt-n1 fw-semibold font-size-12">( Account Closing Discount )</p>
			<p class="border-primary border-bottom mt-n2"></p>
		</div>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>
	<div class="modal-body pt-0">
		<div class="border p-3 pt-0 pb-0 rounded">
			<div class="d-flex align-items-center mb-2">
				<div class="avatar-xs me-3">
					<span class="avatar-title rounded-circle bg-warning-subtle text-warning font-size-18">
						@if (@$contract->CODLOAN == 1) {{-- เงินกู้ --}}
							@if (@$contract->CONTTYP == 1)
								@if (@$contract->TYPECON == '02')
									<i class='bx bxs-car bx-tada fs-4'></i>
								@elseif(@$contract->TYPECON == '03')
									<i class='bx bx-cycling bx-burst fs-4'></i>
								@endif

								@php
									$dp_dscpercen = 100;
								@endphp
							@elseif(@$contract->CONTTYP == 2)
								<i class='bx bxs-landmark bx-tada fs-4'></i>
								@php
									$dp_dscpercen = 50;
								@endphp
							@elseif(@$contract->CONTTYP == 3)
								<i class='bx bxs-landmark bx-tada fs-4'></i>

								@php
									$dp_dscpercen = 0;
								@endphp
							@endif
						@elseif(@$contract->CODLOAN == 2)
							<i class='bx bxs-car bx-tada fs-4'></i>

							@php
								$dp_dscpercen = @$calCloseAC->dscpercen;
							@endphp
						@endif
					</span>
				</div>
				<strong class="flex-fill">สัญญา : {{ @$contract->ContractTypeLoan->Loan_Name }}</strong>
				@if (@$contract->CODLOAN == 2)
					(ดิวที่ <span class="px-1" id="dp_nopay">{{ @$calCloseAC->nopay }}</span>/{{ number_format(@$contract->T_NOPAY, 0) }} )
				@endif
			</div>

			<p class="text-warning mb-1 font-size-14">กรุณาเลือกประเภทส่วนลด (ประจำวันที่ {{ formatDateThaiShort(@$calCloseAC->paydate) }})</p>
			{{-- <div class="d-flex flex-wrap">
				<div>
					<div class="title">กรุณาเลือกประเภทส่วนลด</div>
					<p class="text-warning mb-1">ประจำวันที่ {{ formatDateThaiLong(@$calCloseAC->paydate) }}</p>
					<h4 class="mb-3">
						<u>ส่วนลด</u> : <span id="view_disamount">{{ @$calCloseAC->dscint != 0 ? number_format(@$calCloseAC->dscint, 2) : 0 }}</span> บาท
						<span class="badge bg-success align-bottom">
							{{ number_format($dp_dscpercen, 0) }} %
						</span>
						<i class="mdi mdi-arrow-up ms-0 text-success"></i>
					</h4>
					<p id="show_sentOTP" class="text-info mb-0 text-decoration-underline" style="cursor: pointer;">
						<span>ขอส่วนลดเพิ่ม</span><i class="mdi mdi-arrow-down-thin-circle-outline ms-1"></i>
					</p>
				</div>
				<div class="ms-auto align-self-end">
					<i class="bx bxs-contact display-4 text-light"></i>
				</div>
			</div>

			<div class="title">กรุณาเลือกประเภทส่วนลด</div> --}}
			<div class="">
				<div class="plans">
					<label class="plan basic-plan" for="nonDis">
						<input type="radio" name="typeDiscount" id="nonDis" value="0" />
						<div class="plan-content">
							<img loading="lazy" src="https://raw.githubusercontent.com/ismailvtl/ismailvtl.github.io/master/images/life-saver-img.svg" alt="" />
							<div class="plan-details">
								<span>ไม่ให้ส่วนลด</span>
								<p>
								<footer class="blockquote-footer font-size-13">เลือกไม่ให้ส่วนลดกับสัญญานี้ (ส่วนลดเป็น 0 บาท).</footer>
								</p>
							</div>
						</div>
					</label>
					<label class="plan basic-plan" for="disShow">
						<input type="radio" id="disShow" name="typeDiscount" value="{{ @$calCloseAC->dscint ?? 0 }}" />
						<div class="plan-content">
							<img loading="lazy" src="https://raw.githubusercontent.com/ismailvtl/ismailvtl.github.io/master/images/potted-plant-img.svg" alt="" />
							<div class="plan-details">
								<span>ส่วนลด {{ @$calCloseAC->dscint != 0 ? number_format(@$calCloseAC->dscint, 0) : 0 }} บาท
									<small class="badge bg-success align-bottom">
										{{ number_format($dp_dscpercen, 0) }} %
									</small>
								</span>
								<p>
								<footer class="blockquote-footer font-size-13">เลือกส่วนลดจากระบบคำนวณมาให้ โดยส่วนลดจะขึ้นอยู่กับแต่ละประเภทสัญญา.</footer>
								</p>
							</div>
						</div>
					</label>
					<label class="plan complete-plan" for="inputDis">
						<input type="radio" id="inputDis" name="typeDiscount" value="otp" />
						<div class="plan-content">
							<img loading="lazy" src="https://raw.githubusercontent.com/ismailvtl/ismailvtl.github.io/master/images/potted-plant-img.svg" alt="" />
							<div class="plan-details">
								<span>ระบุส่วนลด</span>
								<p>
								<footer class="blockquote-footer font-size-13">เลือกระบุส่วนลดตามที่ต้องการ (ยืนยัน otp).</footer>
								</p>

								<small>
									<div class="content-otp" style="display: none;">
										@include('components.content-otp.otp', [
											'patchCont_id' => @$contract->id,
											'codloan' => @$contract->CODLOAN,
										])
									</div>
								</small>
							</div>
						</div>
					</label>
				</div>
			</div>

			{{-- <div class="content-otp" style="display: none;">
				@include('components.content-otp.otp', [
					'patchCont_id' => @$contract->id,
					'codloan' => @$contract->CODLOAN,
				])
			</div> --}}
		</div>
	</div>
	<div class="modal-footer">
		<div class="row">
			<div class="col text-right">
				{{-- <button type="button" class="btn btn-warning btn-sm waves-effect hover-up">ขอส่วนลดเพิ่ม</button> --}}
				<button id="btn_selectDis" type="button" class="btn btn-success btn-sm w-md waves-effect hover-up"><i class="mdi mdi-checkbox-marked-circle-outline me-1"></i>เลือก</button>
				<button type="button" class="btn btn-secondary btn-sm w-md waves-effect hover-up" data-bs-dismiss="modal" aria-label="Close"><i class="mdi mdi-close-circle-outline me-1"></i>ปิด</button>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('input[name="typeDiscount"]').on('change', function() {
			let sumPay = $('#sumPay').val().replace(/,/g, '');
			let disamount = $(this).val().replace(/,/g, '');
			let typePlan = $(this).attr('id');

			if (typePlan == 'inputDis') {
				$('.content-otp').toggle(500);
				$('#btn_selectDis').attr('disabled', true);
			} else if (typePlan == 'disShow' || typePlan == 'nonDis') {
				$('.content-otp').hide(500);
				$('#btn_selectDis').attr('disabled', false);
			}
		});
	});

	function PlanDiscounts(disamount) {
		let PAYAMT = $('#PAYAMT').val().replace(/,/g, '');
		let sumAmounts = parseFloat(PAYAMT) - parseFloat(disamount);

		return sumAmounts;
	}

	$(document).ready(function() {
		$('#show_sentOTP').click(function() {
			$('.content-otp').toggle(500);

			// Get the current state of the button
			let isDisabled = $('#btn_selectDis').prop('disabled');

			// Set the opposite state
			$('#btn_selectDis').prop('disabled', !isDisabled);
		});

		$('#btn_selectDis').click(function() {
			var disamount = $('input[name="typeDiscount"]:checked').val().replace(/,/g, '');
			disamount = Math.trunc(parseFloat(disamount));
			let resourceDis = PlanDiscounts(disamount);

			$('.DISCT').val(parseFloat(disamount).toLocaleString('en'));
			$('#sumPay').val(resourceDis.toLocaleString('en'));

			$(".toast-success").toast({
				delay: 5000
			}).toast("show");
			$(".toast-success .toast-body .text-body").text('เพิ่มส่วนลดสำเร็จ');

			$('#modal_sd').modal('hide');
		});

		// $.ajax({
		// 	url: "",
		// 	type: "POST",
		// 	data: {
		// 		_token: "{{ csrf_token() }}",
		// 		otp: otp,
		// 		dis_amount: dis_amount
		// 	},
		// 	success: function(response) {
		// 		if (response.status == 'success') {
		// 			$(".toast-success").toast({
		// 				delay: 5000
		// 			}).toast("show");
		// 			$(".toast-success .toast-body .text-body").text(response.message);

		// 			$('#btn_selectDis').attr('disabled', false);
		// 			$('#dis_amount').val('');
		// 			$('#user_sentOTP').val('');
		// 			$('.content-otp').hide(500);
		// 		} else {
		// 			$(".toast-error").toast({
		// 				delay: 5000
		// 			}).toast("show");
		// 			$(".toast-error .toast-body .text-body").text(response.message);
		// 		}
		// 	},
		// 	error: function(xhr, status, error) {
		// 		console.log(xhr.responseText);
		// 	}
		// });
	});



	$('[data-bs-toggle="tooltip"]').tooltip();
</script>
