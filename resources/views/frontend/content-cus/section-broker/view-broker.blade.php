<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>
@include('components.content-toast.view-toast')

<style>
	/* Variable Declaration */
	:root {
		--shadow: #507abd;
		--bgColor: #5d84c3;
		--ribbonColor: #fff;
	}

	/* The Ribbon */
	.ribbon-page {
		width: 90px;
		height: 60px;
		background-color: var(--ribbonColor);
		position: absolute;
		right: 50px;
		top: -350px;
		animation: drop forwards 0.8s 1s cubic-bezier(0.165, 0.84, 0.44, 1);
		/* box-shadow: 0px 3px 5px rgba(0, 0, 0, 0.2); */
		/* เพิ่มเงาให้กับ Ribbon */
		text-align: center;
		/* จัดกลางเพื่อให้ข้อความอยู่กลาง */
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.ribbon-page:before {
		content: '';
		position: absolute;
		z-index: 2;
		left: 0;
		bottom: -50px;
		border-left: 45px solid var(--ribbonColor);
		border-right: 45px solid var(--ribbonColor);
		border-bottom: 50px solid transparent;
	}

	.ribbon-text {
		margin: 0;
		font-size: 18px;
		font-weight: bold;
		color: var(--shadow);
		/* สีเงาที่กำหนด */
	}

	/* .ribbon:after {
		content: '';
		width: 100px;
		height: 200px;
		position: absolute;
		z-index: 0;
		left: 0;
		bottom: -120px;
		background-color: var(--shadow);
		transform: skewY(35deg) skewX(0);
	} */
	/* Animation Keyframes */
	@keyframes drop {
		0% {
			top: -350px;
		}

		100% {
			top: 0;
		}
	}
</style>

<div class="modal-content">
	<div class="modal-body">
		<div class="card pb-0 mb-0">
			<div class="card-body rounded p-3 bg-info bg-soft bg-opacity-10">
				<div class="ribbon-page">
					<p class="ribbon-text">Broker
						<br>
						<span class="font-size-12 mt-n4">ผู้แนะนำ</span>
					</p>
				</div>

				<div class="d-flex border border-white p-3">
					<div class="flex-shrink-0 me-3">
						<img src="{{ isset($data->image_cus) ? URL::asset(@$data->image_cus) : asset('/assets/images/users/user-1.png') }}" class="avatar-md rounded-circle img-thumbnail hover-slide"" alt="User-Profile-Image">
						<div class="text-center mt-2">
							<button id="status_broker" class="btn {{ @$data->DataCusToBroker->status_Broker == 'active' ? 'btn-primary' : 'btn-danger' }} btn-s btn-sm rounded-pill" type="button">
								<i class="mdi mdi-account-circle font-size-12"></i>
								<span id="txt_status_broker">{{ isset($data->DataCusToBroker) ? @$data->DataCusToBroker->status_Broker : '' }}</span>
							</button>
						</div>
					</div>
					<div class="flex-grow-1 mt-3">
						<div class="d-flex">
							<div class="flex-grow-1">
								<div class="text-muted">
									<h5 class="mb-1 fw-semibold fs-5">
										{{ @$data->Name_Cus }}
										@isset($data->Nickname_cus)
											{{ ' (' . @$data->Nickname_cus . ')' }}
										@endisset
										{{-- <span>
											<a href="{{@$data->DataCusToBroker->Link_Broker}}" target="_blank" rel="noopener noreferrer">
												<i class="fas fa-link" aria-hidden="true"></i>
											</a>
										</span> --}}
									</h5>

									<p class="mb-0 font-size-12">
										@isset($data->NameEng_cus)
											{{ @$data->NameEng_cus }}
										@else
											<span class="text-muted"><em>-</em></span>
										@endisset
									</p>

								</div>
							</div>
						</div>

						<hr>
						<div class="showdata" style="{{ isset($data->DataCusToBroker) ? '' : 'display: none;' }}">
							@include('frontend.content-cus.section-broker.data-broker')
						</div>

						<div class="row show-empty" style="{{ isset($data->DataCusToBroker) ? 'display: none;' : '' }}">
							<div class="col-xl-12 col-lg-12 col-md-12 d-flex align-items-center justify-content-center rounded-3 bg-light pe-3">
								<div class="text-center" style="min-height:7rem; max-height:7rem;">
									<img src="{{ URL::asset('\assets\images\empty-bock.png') }}" class="up-down mt-3" style="width:50px;">
									<br>
									<button id="show_formBroker" class="btn btn-outline-danger btn-sm rounded-pill fw-semibold mt-2" type="button">
										<i class="mdi mdi-account-circle font-size-12"></i> ลงทะเบียนผู้แนะนำ
									</button>
								</div>
							</div>
						</div>
						<div class="show-formdata" style="display: none;">
							@include('frontend.content-cus.section-broker.create-broker')
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer">
		<button type="button" id="create_broker" class="btn btn-primary btn-sm waves-effect waves-light w-md hover-up" style="display: none;">
			<span class="addSpin"><i class="fas fa-download"></i></span> บันทึก
		</button>
		@can('edit-customer-broker')
			<button type="button" id="update_broker" class="btn btn-warning btn-sm waves-effect waves-light w-md hover-up" style="{{ isset($data->DataCusToBroker) ? '' : 'display: none;' }}">
				<span class="addSpin"><i class="fas fa-download"></i></span> แก้ไข
			</button>
		@endcan
		<button type="button" id="btn_closebroker" class="btn btn-secondary btn-sm waves-effect w-md hover-up" data-bs-dismiss="modal">
			<i class="mdi mdi-close-circle-outline"></i> ปิด
		</button>
	</div>
</div>

<script>
	$('#show_formBroker').click(function() {
		let IDCard_cus = $('#IDCard_cus').val();
		let Name_Account = $('#Name_Account').val();
		let Number_Account = $('#Number_Account').val();

		if (IDCard_cus != '' && Name_Account != '' && Number_Account != '') {
			$('.show-empty').slideUp("slow").addClass('d-none');
			$('.show-formdata').slideDown("slow").removeClass('d-none');

			$('#create_broker').attr('style', '');
		} else {
			var span = document.createElement("span");
			span.classList.add('text-muted');
			span.innerHTML = "กรุณากรอกข้อมูลลูกค้าต่อไปนี้ ก่อนลงทะเบียน \n<ul style='text-align: left;font-size: 13px;'>" +
				"<li class='text-danger'>เลขบัตรประชาชน </li>" +
				"<li class='text-danger'>ธนาคาร</li>" +
				"<li class='text-danger'>สาขาธนาคาร</li>" +
				"<li class='text-danger'>เลขบัญชีธนาคาร</li>" +
				"</ul>";

			Swal.fire({
				icon: 'error',
				title: `ข้อมูลไม่ถูกต้อง !`,
				html: span,
				showConfirmButton: true,
			});

			$('#modal_lg').modal('hide');
		}
	});

	$('#update_broker').click(function() {
		$(this).attr('style', 'display:none !important');
		$('#create_broker').attr('style', '');

		$('.showdata').slideUp("slow").attr('style', 'display:none !important');
		$('.show-formdata').slideDown("slow").attr('style', '');
	});

	$('#create_broker').click(function() {
		var dataform = document.querySelectorAll('.needs-validation');
		var validate = validateForms(dataform);

		if (validate == true) {
			let broker_id = $('#broker_id').val();
			let _token = $('input[name="_token"]').val();
			let data = {};
			$("#form_createBroker").serializeArray().map(function(x) {
				data[x.name] = x.value;
			});

			$('#create_broker,#update_broker,#btn_closebroker').prop('disabled', true);
			$('.addSpin').empty();
			$('<span />', {
				class: "spinner-border spinner-border-sm",
				role: "status"
			}).appendTo(".addSpin");

			if (broker_id != '') {
				let link = "{{ route('cus.update', 'id') }}";
				var url = link.replace('id', broker_id);

				var method = "PUT";
				var funs = 'update-broker';
			} else {
				var url = "{{ route('cus.store') }}";
				var method = "POST";
				var funs = 'create-broker';
			}

			$.ajax({
				url: url,
				method: method,
				data: {
					_token: _token,
					funs: funs,
					data: data
				},

				success: function(result) {
					$('#create_broker,#update_broker,#btn_closebroker').prop('disabled', false);
					$('#create_broker').attr('style', 'display:none !important');
					$('#update_broker').attr('style', '');

					$('.addSpin').empty();
					$('.addSpin').html('<i class="fas fa-download"></i>');

					$('.show-formdata').slideUp("slow").attr('style', 'display:none !important');
					$('.showdata').html(result.html).attr('style', '');
					$('#status_broker').removeClass('btn-danger');

					// viewcus
					if (result.status_Broker == 'active') {
						$('.btn_Broker').removeClass('btn-outline-secondary').removeClass('btn-outline-danger').addClass('btn-outline-warning');
						$('#status_broker').addClass('btn-primary');
					} else {
						$('.btn_Broker').removeClass('btn-outline-secondary').removeClass('btn-outline-warning').addClass('btn-outline-danger');
						$('#status_broker').addClass('btn-danger');
					}

					$('#txt_status_broker').html(result.status_Broker);
					$('#broker_id').val(result.broker_id);
					$('.btn_IconBroker').html('<i class="mdi mdi-account-circle" data-bs-toggle="tooltip" title="ผู้แนะนำ"></i>');

					$('.ribbon').attr('style', '');
					$(".toast-success").toast({
						delay: 1500
					}).toast("show");
					$(".toast-success .toast-body .text-body").text(result.message);
				},
				error: function(err) {
					Swal.fire({
						icon: 'error',
						title: `ERROR ` + err.status + ` !!!`,
						text: err.responseJSON.message,
						showConfirmButton: true,
					});

					$('#modal_lg').modal('hide');
				}
			})
		}
	});
</script>
