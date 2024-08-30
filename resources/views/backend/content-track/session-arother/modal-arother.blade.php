@include('backend.content-track.script')
@include('components.content-toast.view-toast')

<script src="{{ URL::asset('/assets/js/pages/form-validation.init.js')}}"></script>
<script src="{{ URL::asset('/assets/js/pages/toastr.init.js')}}"></script>

<style>
    .form-floating {
		position: relative;
		display: flex;
		width: 100%;
		font-size: 12px;
		/* width: 300px; */
	}

	.signup-form input[type=text],
	select {
		border: none;
		border-bottom: 2px solid darkgrey;
		background-color: inherit;
		display: block;
		width: 100%;
		margin: none;
	}

	.signup-form input[type=text]:focus,
	select:focus {
		outline: none;
	}

	.form-group .line {
		height: 1px;
		width: 0px;
		position: absolute;
		background-color: darkgrey;
		display: inline-block;
		transition: .3s width ease-in-out;
		position: relative;
		top: -14px;
		margin-bottom: 0;
		padding-bottom: 0;
	}

	.signup-form input[type=text]:focus+.line,
	select:focus+.line {
		width: 100%;
		background-color: #02add7;
	}
</style>

<div class="modal-content">
	<div class="d-flex m-3">
		<div class="flex-shrink-0 me-2">
			<img src="{{ asset('assets/images/payment.png') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
		</div>
		<div class="flex-grow-1 overflow-hidden">
			<h5 class="text-primary fw-semibold font-size-15">บันทึกลูกหนี้อื่น</h5>
			<p class="text-muted mt-n1 fw-semibold font-size-12">Bill no : {{ @$Billno }}</p>
			<p class="border-primary border-bottom mt-n2 m-2"></p>
            <input type="hidden" id="BILL" value="{{ @$Billno }}">
		</div>
	</div>
	<div class="modal-body">
		<form name="formAdd" id="formAdd" class="needs-validation" action="#" method="post" enctype="multipart/form-data">
			@csrf
            <input type="hidden" id="loanType" name="loanType" value="{{@$loanType}}">
            <input type="hidden" id="DataPact_id" name="DataPact_id" value="{{@$contract->id}}">
            <input type="hidden" id="UserZone" name="UserZone" value="{{@$contract->UserZone}}">
            <input type="hidden" id="DataTag_id" name="DataTag_id" value="{{@$contract->DataTag_id}}">
            <input type="hidden" id="locat" name="locat" value="{{@$contract->LOCAT}}">
            <input type="hidden" id="CUSCODE" name="CUSCODE" value="{{@$contract->PatchToPact->ContractToCus->IDCard_cus}}">
            <input type="hidden" id="REF_SPASTDUE" name="REF_SPASTDUE" value="{{@$contract->ToView_PatchSPASTDUE[0]->spast_id}}">
			<div class="row mb-2">
				<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 text-center">
					<div class="bg-light mini-stat-icon rounded-3 py-3 h-100 profile d-flex align-items-center justify-content-center">
						<div class="avatar-md mx-auto hover-slide">
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
                                    <div class="input-bx">
                                        <input type="date" id="DateAdd" name="DateAdd" class="form-control" value="{{ date('Y-m-d') }}" placeholder=" " readonly>
                                        <span>วันที่บันทึก</span>
                                    </div>
								</div>
								<div class="col-sm-6 my-2">
                                    <!-- <div class="input-bx">
                                        <input type="date" id="DateAppoint" name="DateAppoint" class="form-control" min="{{date('Y-m-d')}}" placeholder=" ">
                                        <span>วันที่นัดชำระ</span>
                                    </div> -->
                                    <div class="input-bx" id="datepicker1">
                                        <input type="text" name="DateAppoint" id="DateAppoint" value=""
                                            class="form-control text-start" placeholder="" min="{{date('Y-m-d',strtotime('+1days'))}}"
                                            data-date-format="dd/mm/yyyy" data-date-container="#datepicker1"
                                            data-provide="datepicker" data-date-disable-touch-keyboard="true"
                                            data-date-language="th" data-date-today-highlight="true"
                                            data-date-enable-on-readonly="true" data-date-clear-btn="true"
                                            autocomplete="off" data-date-autoclose="true">
                                        <span>วันที่นัดชำระ</span>
                                    </div>
								</div>
							</div>
							<div class="row g-2 align-self-center">
								<div class="col-sm-6 my-2">
                                    <div class="input-bx">
                                        <input type="text" id="CONTNO" name="Contract" value="{{@$contract->CONTNO}}" class="form-control" placeholder=" ">
                                        <span>เลขที่สัญญา</span>
                                    </div>
								</div>
								<div class="col-sm-6 my-2">
                                    <div class="input-bx">
                                        <input type="number" id="VATRT" name="VATRT" value="7" class="form-control" placeholder=" ">
                                        <span>อัตราภาษี</span>
                                        <button class="input-group-text" type="button">
                                            %
                                        </button>
                                    </div>
								</div>
							</div>
                            <div class="row mb-2">
								<div class="col-md-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" placeholder="Leave a comment here" name="Note" id="Note" maxlength="10000" style="height: 100px"></textarea>
                                        <label for="Note">หมายเหตุ</label>
                                    </div>
								</div>
							</div>
                            <hr class="mt-n1">
							<div class="row g-2 align-self-center border-top">
								<div class="col-sm-6 my-2">
                                    <div class="input-bx">
                                        <input type="text" id="PAYFOR_CODE" name="PayCode" value="" class="form-control PAYFOR_CODE" placeholder=" " required>
                                        <span>รหัสชำระ</span>
                                        <button class="input-group-text modal_md" type="button" data-bs-toggle="modal" data-bs-target="#modal_md" data-link="{{ route('constants.create') }}?page={{'backend'}}&FlagBtn={{'PAYFOR'}}&modalID={{'modal_lg'}}">
                                            <i class="dripicons-menu"></i>
                                        </button>
                                    </div>
								</div>
								<div class="col-sm-6 my-2">
                                    <div class="input-bx">
                                        <input type="text" id="PAYFOR_NAME" value="" class="form-control PAYFOR_NAME" placeholder=" ">
                                        <span>ชื่อรหัสชำระ</span>
                                    </div>
								</div>
							</div>
							<div class="row g-2 align-self-center">
								<div class="col-sm-6 my-2">
                                    <div class="input-bx">
                                        <input type="text" id="FOLLOWCODE" name="FollowCode" class="form-control" placeholder=" ">
                                        <span>ทีมติดตาม</span>
                                        <button class="input-group-text modal_md" type="button" data-bs-toggle="modal" data-bs-target="#modal_md" data-link="{{ route('constants.create') }}?page={{'backend'}}&FlagBtn={{'FOLCODE'}}&modalID={{'modal_lg'}}">
                                            <i class="dripicons-menu"></i>
                                        </button>
                                    </div>
								</div>
								<div class="col-sm-6 my-2">
                                    <div class="input-bx">
                                        <input type="text" type="text" id="FOLLOWNAME" class="form-control" placeholder=" ">
                                        <span>ชื่อทีมติดตาม</span>
                                    </div>
								</div>
							</div>
                            <div class="row g-2 align-self-center">
								<div class="col-sm-6 my-2">
                                    <div class="input-bx">
                                        <input type="number" id="AmountPaid" name="AmountPaid" class="form-control" placeholder=" " required>
                                        <span>จำนวนเงิน</span>
                                        <button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">บาท</button>
                                    </div>
								</div>
								<div class="col-sm-6 my-2">
                                    <div class="input-bx">
                                        <input type="number" id="Discount" name="Discount" value="0" class="form-control" placeholder=" ">
                                        <span>ส่วนลด</span>
                                        <button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">บาท</button>
                                    </div>
								</div>
							</div>
                            <div class="row g-2 align-self-center">
								<div class="col-sm-6 my-2">

								</div>
								<div class="col-sm-6 my-2">
                                    <div class="input-bx">
                                        <input type="number" id="TOT_SUM" name="TOT_SUM" class="form-control" placeholder=" ">
                                        <span class="text-danger">รวมสุทธิ</span>
                                        <button class="mx-0 btn btn-dark border border-secondary border-opacity-50 font-size-10 text-danger">บาท</button>
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
		<button type="button" id="SaveData" class="btn btn-primary btn-sm waves-effect waves-light w-md hover-up">
			<span class="addSpin"><i class="fas fa-download"></i></span> บันทึก
		</button>
		<button type="button" class="btn btn-secondary btn-sm waves-effect w-md hover-up" data-bs-dismiss="modal" aria-label="Close">
			<i class="mdi mdi-close-circle-outline"></i> ปิด
		</button>
	</div>
</div>

{{-- Create Data --}}
<script>
  $("#SaveData").click(function(){

    var data = {};$("#formAdd").serializeArray().map(function(x){data[x.name] = x.value;});
    var TextAroth = $("#BILL").val();
    console.log(data);
    
    if ($("#formAdd").valid() == true) {
        $('#SaveData').prop('disabled', true);
        $('.addSpin').empty();
        $('<span />', {
            class: "spinner-border spinner-border-sm",
            role: "status"
        }).appendTo(".addSpin");
        
        $.ajax({
            url: "{{ route('datatrack.store') }}",
            method: 'POST',
            data:{
              _token:'{{ csrf_token() }}',
              page: 'store-aroth',
              data:data,
            },

            success: function(result) {
              $('#modal_lg').modal('hide');
              $('#modal_xl').modal('hide');
              swal.fire({
                icon : 'success',
                title : 'บันทึกข้อมูลสำเร็จ',
                timer: 1500,
                showConfirmButton: false,
              })
              $("#TextAroth").text(TextAroth);
              $("#ArotherDetails").html(result);
            },
            error: function(err) {
                Swal.fire({
                    icon: 'error',
                    title: `ERROR ` + err.status + ` !!!`,
                    text: err.responseJSON.message,
                    showConfirmButton: true,
                });
                $('#modal_lg').modal('hide');
                $('#modal_xl').modal('hide');
            }
        });
    }
    else{
      // $("#loading_editGuarantor").attr('style', ''); // ***** แสดงตัวโหลด *****
      swal.fire({
              icon : 'warning',
              title : 'ข้อมูลไม่ครบ !',
              text : 'กรุณากรอกข้อมูลให้ครบถ้วน',
              timer: 2000,
              showConfirmButton: false,
            })
    }      
  });
</script>

{{-- check Enter --}}
<script>
    $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
	$(document).ready(function(){
        $('#DateAppoint').on('keypress', function (e){
			if (e.keyCode === 13 || e.which === 13) {
				$("#FOLLOWCODE").focus();
			}
        });
        $('#PAYFOR_CODE').on('change', function (e){
            let val = $(this).val();
            if (val != '') {
                $("#FOLLOWCODE").focus();
            }
        });
        $('#FOLLOWCODE').on('keypress', function (e){
			if (e.keyCode === 13 || e.which === 13) {
				$("#AmountPaid").focus();
			}
        });
        
        // $('#PAYFOR_CODE').on('keypress', function (e){
		// 	if (e.keyCode === 13 || e.which === 13) {
		// 		$("#Note").focus();
		// 	}
        // });
    });
</script>

<script>
  $( document ).ready(function() {
    $('#AmountPaid,#Discount').on('input',function(){
      var GetAmount = $("#AmountPaid").val();
      var GetDiscount = $("#Discount").val();
      console.log(GetAmount,GetDiscount);
      var GetSum = parseInt(GetAmount) - parseInt(GetDiscount);
        $("#TOT_SUM").val(GetSum);
    });
  });
</script>