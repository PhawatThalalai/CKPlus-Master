@include('backend.content-track.script')
@include('components.content-toast.view-toast')

<script src="{{ URL::asset('/assets/js/pages/form-validation.init.js')}}"></script>
<script src="{{ URL::asset('/assets/js/pages/toastr.init.js')}}"></script>

<style>
	.card__radio_display {
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 5px;
	}

	.radio__card {
		display: flex;
		align-items: center;
		padding: 5px 50px 5px 50px;
	}
	.radio__card__el {
		display: flex;
		align-items: center;
		justify-content: center;
		margin-left: 8px;
	}

	@media screen and (max-width: 992px) {
		.radio__card {
			width: 100%;
		}

		.card__radio_display {
			display: inline;
		}
	}
</style>

<div class="modal-content">
	<div class="d-flex m-3">
		<div class="flex-shrink-0 me-2">
			<img src="{{ asset('assets/images/payment.png') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
		</div>
		<div class="flex-grow-1 overflow-hidden">
			<h5 class="text-primary fw-semibold font-size-15">พิมพ์ใบกำกับค่างวด</h5>
			<p class="text-muted mt-n1 fw-semibold font-size-12"></p>
			<p class="border-primary border-bottom mt-n2 m-2"></p>
            <input type="hidden" id="BILL" value="">
		</div>
	</div>
	<div class="modal-body">
		<form name="formPrint" id="formPrint" class="needs-validation" action="#" method="post" enctype="multipart/form-data">
			@csrf 
			<input type="hidden" id="page" name="page" value="{{@$page}}">
			<div class="row mb-2">
				<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 text-center">
					<div class="bg-light mini-stat-icon rounded-3 py-3 profile d-flex align-items-center justify-content-center">
						<div class="avatar-sm mx-auto hover-slide">
							<span class="avatar-title rounded-circle bg-warning fs-1">
								<i class="bx bx-money bx-tada"></i>
							</span>
						</div>
					</div>
				</div>
				<div class="col-xl col-lg col-md col-sm-12">
					<div class="row g-2">
						<div class="col-xl-12 col-lg-12">
							<div class="row g-2 align-self-center">
								<div class="col-sm-6 my-2">
                                    <div class="input-bx" id="datepicker1">
                                        <input type="text" name="START" id="START" value="{{date('d/m/Y')}}"
                                            class="form-control text-start" placeholder=""
                                            data-date-format="dd/mm/yyyy" data-date-container="#datepicker1"
                                            data-provide="datepicker" data-date-disable-touch-keyboard="true"
                                            data-date-language="th" data-date-today-highlight="true"
                                            data-date-enable-on-readonly="true" data-date-clear-btn="true"
                                            autocomplete="off" data-date-autoclose="true" required>
                                        <span>จากวันที่</span>
                                    </div>
								</div>
								<div class="col-sm-6 my-2">
                                    <div class="input-bx" id="datepicker2">
                                        <input type="text" name="END" id="END" value="{{date('d/m/Y')}}"
                                            class="form-control text-start" placeholder=""
                                            data-date-format="dd/mm/yyyy" data-date-container="#datepicker1"
                                            data-provide="datepicker" data-date-disable-touch-keyboard="true"
                                            data-date-language="th" data-date-today-highlight="true"
                                            data-date-enable-on-readonly="true" data-date-clear-btn="true"
                                            autocomplete="off" data-date-autoclose="true" required>
                                        <span>ถึงวันที่</span>
                                    </div>
								</div>
							</div>
						</div>
					</div>

					<div class="row g-2">
						<div class="col-xl-12 col-lg-12 d-flex justify-content-center">
							<div class="row g-2 align-self-center">
								<div class="col-sm-6 my-2">
									<div class="form-group col-12 mb-0">
										<div class="card__radio_display" id="typeForm">
											<label class="card-radio-label mb-2 form-inline">
												<div class="radio__card btn btn-outline-success waves-effect waves-light">
													<input class="form-check-input" type="radio" name="typeReport" id="type-file1" value="EXCEL" required>
													<div class="radio__card__el">
														<lord-icon id="icon" src="https://cdn.lordicon.com/ujxzdfjx.json" trigger="loop" delay="2000" stroke="bold" colors="primary:#1d6f42,secondary:#ebe6ef" style="width:30px;height:30px; margin-right: 3px"></lord-icon>
														<span style="margin-left: 2px">EXL</span>
													</div>
												</div>
											</label>
										</div>
									</div>
									<input type="hidden" id="type-selcted" name="type-selcted" value="">
								</div>
								<div class="col-sm-6 my-2">
									<div class="form-group col-12 mb-0">
										<div class="card__radio_display" id="typeForm">
											<label class="card-radio-label mb-2">
												<div class="radio__card  btn btn-outline-danger waves-effect waves-light">
													<input class="form-check-input" type="radio" name="typeReport" id="type-file2" value="PDF" required>
													<div class="radio__card__el">
														<lord-icon id="icon" src="https://cdn.lordicon.com/ujxzdfjx.json" trigger="loop" delay="2000" stroke="bold" colors="primary:#dc2f02,secondary:#ebe6ef" style="width:30px;height:30px; margin-right: 3px"></lord-icon>
														<span style="margin-left: 2px">PDF</span>
													</div>
												</div>
											</label>
										</div>
									</div>
									<input type="hidden" id="type-selcted" name="type-selcted" value="">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<button type="button" id="PrintForm" class="btn btn-primary btn-sm waves-effect waves-light w-md hover-up">
			<span class="addSpin"><i class="fas fa-print"></i></span> พิมพ์
		</button>
		<button type="button" id="CloseData" class="btn btn-secondary btn-sm waves-effect w-md hover-up" data-bs-dismiss="modal" aria-label="Close">
			<i class="mdi mdi-close-circle-outline"></i> ปิด
		</button>
	</div>
</div>

<script>
	$('#CloseData').click(function() {
		$("#btn_search").removeAttr('disabled',true);
	});
</script>

<script>
	$(function() {
		$("#type-file1").change(function() {
			var data = $(this).val();
			if(data == 'EXCEL') {
				$("#type-file1").attr('checked', true);
				$("#type-file2").attr('required', false);
				$("#type-selcted").val('EXCEL');
			} 
			else {
				$("#type-file2").attr('checked', false);
				$("#type-selcted").val('');
			}
		});
		$("#type-file2").change(function() {
			var data = $(this).val();
			if(data == 'PDF') {
				$("#type-file2").attr('checked', true);
				$("#type-file1").attr('required', false);
				$("#type-selcted").val('PDF');
			} 
			else {
				$("#type-file1").attr('checked', false);
				$("#type-selcted").val('');
			}
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
            }else{
                isvalid = true;
            }
        });
        return isvalid;
    }
</script>

<script>
  $("#PrintForm").click(function(){
	var dataform = document.querySelectorAll('#formPrint');
	var validate = validateForms(dataform);

	if (validate == true) {
        let page = $("#page").val();
        let dateStart = $("#START").val();
        let dateEnd = $("#END").val();
        let type = $("#type-selcted").val();
        let url = "{{route('tax.show',[0])}}?page={{':page'}}&start={{':start'}}&end={{':end'}}&type={{':type'}}";
            url = url.replace(':page', page);
            url = url.replace(':start', dateStart);
            url = url.replace(':end', dateEnd);
            url = url.replace(':type', type);
        window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes");
    }
    else{
      swal.fire({
        icon : 'warning',
        title : 'ข้อมูลไม่ครบ !',
        text : 'กรุณาเลือกรูปแบบไฟล์ก่อนพิมพ์',
        timer: 2000,
        showConfirmButton: false,
      })
    }      
  });
</script>