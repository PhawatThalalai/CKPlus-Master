@include('backend.content-track.script')
@include('components.content-toast.view-toast')

<script src="{{ URL::asset('/assets/js/pages/form-validation.init.js')}}"></script>
<script src="{{ URL::asset('/assets/js/pages/toastr.init.js')}}"></script>

<div class="modal-content">
	<div class="d-flex m-3">
		<div class="flex-shrink-0 me-2">
			<img src="{{ asset('assets/images/payment.png') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
		</div>
		<div class="flex-grow-1 overflow-hidden">
			<h5 class="text-primary fw-semibold font-size-15">Reprint Letter</h5>
			<p class="text-muted mt-n1 fw-semibold font-size-12"></p>
			<p class="border-primary border-bottom mt-n2 m-2"></p>
            <input type="hidden" id="BILL" value="">
		</div>
	</div>
	<div class="modal-body">
		<form name="formPrint" id="formPrint" class="needs-validation" action="#" method="post" enctype="multipart/form-data">
			@csrf
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
					<div class="row g-2 h-100">
						<div class="col-xl-12 col-lg-12">
							<div class="row g-2 align-self-center">
								<div class="col-sm-6 my-2">
                                    <div class="input-bx" id="datepicker0">
                                        <!-- <input type="date" id="DatePrint" name="DatePrint" class="form-control" value="{{ date('Y-m-d') }}" placeholder=" " required> -->
										<input type="text" name="DatePrint" id="DatePrint" value="{{date('d/m/Y')}}"
											class="form-control text-start" placeholder=""
											data-date-format="dd/mm/yyyy" data-date-container="#datepicker1"
											data-provide="datepicker" data-date-disable-touch-keyboard="true"
											data-date-language="th" data-date-today-highlight="true"
											data-date-enable-on-readonly="false" data-date-clear-btn="true"
											autocomplete="off" data-date-autoclose="true" readonly>
                                        <span>วันที่พิมพ์</span>
                                    </div>
								</div>
								<div class="col-sm-6 my-2">
                                    <div class="input-bx">
                                        <select id="GCODE" name="GCODE" class="form-select text-dark" data-bs-toggle="tooltip" required placeholder=" ">
                                            <option value="" selected>-- ค้างงวด --</option>
                                            @foreach(@$GCODE as $row)
                                                <option value="{{@$row->GCODE}}">{{@$row->GCODE}} | {{@$row->GDESC}}</option>
                                            @endforeach
                                        </select>
                                        <span>ค้างงวด</span>
                                    </div>
								</div>
							</div>
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
				</div>
			</div>
		</form>
	</div>
	<div class="modal-footer">
		<button type="button" id="PrintData" class="btn btn-primary btn-sm waves-effect waves-light w-md hover-up">
			<span class="addSpin"><i class="fas fa-search"></i></span> ค้นหา
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

{{-- PrintData --}}
<script>
	$('#PrintData').click(function() {
		var dataform = document.querySelectorAll('#formPrint');
		var validate = validateForms(dataform);

		if (validate == true) {
			$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
			let data = {};
			$("#formPrint").serializeArray().map(function(x) {
				data[x.name] = x.value;
			});

			$.ajax({
				url: "{{ route('letter.show',[0]) }}",
				method: "get",
				data: {
					data: data,
					_token: "{{ @csrf_token() }}",
					page: 'reprint-letter',
				},
	
				success: async function(result) {
					console.log(result);
					$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
					$('#modal_lg').modal('hide');
					// Swal.fire({
					// 	icon: 'success',
					// 	text: 'ดึงข้อมูลสำเร็จ',
					// 	showConfirmButton: false,
					// 	timer: 1500
					// });
					$('.btnControl,.check-input').prop('disabled', false);
					$('#v-tabContent').hide();
					$('.contentData').hide();
					$('.contentPrinted').html(result.viewData).fadeIn('slow');
				},
				error: function(err) {
					Swal.fire({
						icon: 'error',
						title: `ERROR ` + err.status + ` !!!`,
						text: err.responseJSON.message,
						showConfirmButton: true,
					});
				}
			})
		}
	});
</script>
