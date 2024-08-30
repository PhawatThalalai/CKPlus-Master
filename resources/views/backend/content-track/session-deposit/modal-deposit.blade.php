@include('backend.content-track.script')
@include('components.content-toast.view-toast')

@php 
//dd(@$data->PatchToPact);
@endphp

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

{{--<form name="formAdd" id="formAdd" action="#" method="post" enctype="multipart/form-data" novalidate>
  @csrf
    <input type="hidden" id="loanType" name="loanType" value="{{@$loanType}}">
    <input type="hidden" id="DataPact_id" name="DataPact_id" value="{{@$contract->id}}">
    <input type="hidden" id="DataCus_id" name="DataCus_id" value="{{@$contract->DataCus_id}}">
    <input type="hidden" id="CUSCODE" name="CUSCODE" value="{{@$data->PatchToPact->ContractToCus->IDCard_cus}}">
    <div class="modal-content">
        <div class="d-flex m-3 mb-0">
            <div class="flex-shrink-0 me-2">
                <img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
            </div>
            <div class="flex-grow-1 overflow-hidden">
                <h4 class="text-primary fw-semibold">บันทึกรับฝากค่างวด</h4>
                @if(@$loanType == 2)
                    @php 
                        $HD_Code = App\Models\TB_PatchContracts\TB_Payments\PatchHP\PatchHP_HDPAYMENT::generateCode();
                    @endphp
                @else 
                    @php 
                        $HD_Code = App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_HDPAYMENT::generateCode();
                    @endphp
                @endif
                <p class="text-muted mt-n1">{{@$HD_Code}}</p>
                <p class="border-primary border-bottom mt-n2"></p>
                <input type="hidden" name="TEMPBILL" value="{{@$HD_Code}}">
                <input type="hidden" id="BILLHD" value="{{@$HD_Code}}">
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body mt-n4">
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <!-- <h5 class="card-title mb-3">ข้อมูลการติดตามลูกหนี้</h5> -->
                            <!-- <div class="text-center">
                                <div class="mb-3 mt-n3">
                                    <img src="{{ asset('assets/images/payment-1.png') }}" alt="" class="avatar-lg">
                                </div>
                            </div> -->
                            <div class="row g-2 mb-1">
                                <div class="col-6">
                                    <div class="form-floating">
                                        <input type="date" id="DateAdd" name="DateAdd" class="form-control" value="{{ date('Y-m-d') }}" min="{{date('Y-m-d')}}" placeholder="วันที่ออกงานติดตาม" required>
                                        <label for="floatingnameInput">วันที่รับเงิน</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating">
                                        <input type="date" id="DateAppoint" name="DateAppoint" class="form-control" min="{{date('Y-m-d')}}" placeholder="วันที่นัดชำระ" required>
                                        <!-- <input type="text" id="DateAppoint" name="DateAppoint" class="form-control datepickerTH" placeholder="วัน/เดือน/ปี" data-date-container="#datepicker" data-provide="datepicker" data-date-language="th" data-date-autoclose="true"> -->
                                        <label for="floatingnameInput">วันที่แจ้งโอน</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2 mb-1">
                                <div class="col-6">
                                    <div class="form-floating">
                                        <input type="text" id="LOCAT" name="LOCAT" value="{{@$contract->UserBranch}}" class="form-control" placeholder="อัตราภาษี">
                                        <label for="floatingnameInput">สาขา</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating">
                                        <input type="text" id="CONTNO" name="Contract" value="{{@$contract->CONTNO}}" class="form-control" placeholder="เลขที่สัญญา">
                                        <label for="Contract">เลขที่สัญญา</label>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row g-2 mb-4">
                                <div class="col-6">
                                    <div class="form-floating">
                                        <select id="TypeDept" name="TypeDept" class="form-select TypeDept" required>
                                            <option value="">--- ประเภทลูกหนี้ ---</option>
                                            <option value="ติดต่อไม่ได้">1. ติดต่อไม่ได้</option>
                                            <option value="ไม่รับสาย">2. ไม่รับสาย</option>
                                            <option value="เปลี่ยนเบอร์">3. เปลี่ยนเบอร์</option>
                                            <option value="ติดต่อได้">4. ติดต่อได้</option>
                                            <option value="อื่นๆ">5. อื่นๆ</option>
                                        </select>
                                        <label for="floatingSelectGrid">ประเภทลูกหนี้</label>
                                    </div>
                                </div>
                            </div> -->
                            <div class="row g-2">
                                <!-- <div class="col-12">
                                    <label class="text-muted" style="padding:0px 10px;position:relative;top:10px;font-size:12px;">หมายเหตุ</label>
                                    <textarea name="Note" id="Note" class="form-control" rows="4"></textarea>
                                </div> -->
                                <div class="form-floating">
                                    <textarea class="form-control" placeholder="Leave a comment here" name="Note" id="Note" maxlength="10000" style="height: 160px"></textarea>
                                    <label for="Note">หมายเหตุ</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="mb-3 mt-n3">
                                    <img src="{{ asset('assets/images/payment-1.png') }}" alt="" class="avatar-lg">
                                </div>
                            </div>
                            <div class="row g-2 mb-2">
                                <div class="col-6 col-md-5">
                                    <div class="input-bx">
                                        <input type="text" id="PAYFOR_CODE" name="PayCode" value="{{@$Dcode}}" class="form-control" placeholder=" " required/>
                                        <span>รหัสชำระ</span>
                                        <button class="input-group-text Modal-xl-2" type="button" data-bs-toggle="modal" data-bs-target="#Modal-xl-2" data-link="{{ route('constants.create') }}?page={{'backend'}}&FlagBtn={{'PAYFOR'}}&modalID={{'Modal-xl'}}">
                                            <i class="dripicons-menu"></i>
                                        </button>
                                    </div>
                                </div>
                                @php 
                                    @$PAYFOR_NAME = \App\Models\TB_Constants\TB_Backend\TB_PAYFOR::Where('FORCODE',@$Dcode)->first();
                                @endphp
                                <div class="col-6 col-md-7">
                                    <div class="input-bx">
                                        <input type="text" id="PAYFOR_NAME" value="{{@$PAYFOR_NAME->FORDESC}}" class="form-control" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2 mb-2">
                                <div class="col-6 col-md-5">
                                    <div class="input-bx">
                                        <input type="text" id="FOLLOWCODE" name="FollowCode" class="form-control" placeholder=" " required/>
                                        <span>ทีมติดตาม</span>
                                        <button class="input-group-text Modal-xl-2" type="button" data-bs-toggle="modal" data-bs-target="#Modal-xl-2" data-link="{{ route('constants.create') }}?page={{'backend'}}&FlagBtn={{'FOLCODE'}}&modalID={{'Modal-xl'}}">
                                            <i class="dripicons-menu"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6 col-md-7">
                                    <div class="input-bx">
                                        <input type="text" id="FOLLOWNAME" class="form-control" readonly/>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2 mb-1">
                                <div class="col-12">
                                    <div class="input-bx">
                                        <input type="number" id="AmountPaid" name="AmountPaid" class="form-control" placeholder=" " required>
                                        <span>จำนวนเงิน</span>
                                        <button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">บาท</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2 mb-1">
                                <div class="col-12">
                                    <div class="input-bx">
                                        <input type="number" id="MoneyPaid" name="MoneyPaid" class="form-control" placeholder=" ">
                                        <span>ชำระแล้ว</span>
                                        <button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">บาท</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer mt-n3">
            <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> -->
            <button type="button" id="SaveData" class="btn btn-primary">
            <i class="bx bx-save"></i> Save
            </button>
        </div>
    </div>
</form>--}}

<div class="modal-content">
	<div class="d-flex m-3">
		<div class="flex-shrink-0 me-2">
			<img src="{{ asset('assets/images/payment.png') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
		</div>
        @if(@$loanType == 2)
            @php 
                $HD_Code = App\Models\TB_PatchContracts\TB_Payments\PatchHP\PatchHP_HDPAYMENT::generateCode();
            @endphp
        @else 
            @php 
                $HD_Code = App\Models\TB_PatchContracts\TB_Payments\PatchPSL\PatchPSL_HDPAYMENT::generateCode();
            @endphp
        @endif
		<div class="flex-grow-1 overflow-hidden">
			<h5 class="text-primary fw-semibold font-size-15">บันทึกรับฝากค่างวด</h5>
			<p class="text-muted mt-n1 fw-semibold font-size-12">Bill no : {{ @$HD_Code }}</p>
			<p class="border-primary border-bottom mt-n2 m-2"></p>
            <input type="hidden" id="BILLHD" value="{{@$HD_Code}}">
		</div>
	</div>
	<div class="modal-body">
		<form name="formAdd" id="formAdd" class="needs-validation" action="#" method="post" enctype="multipart/form-data">
			@csrf
            <input type="hidden" id="loanType" name="loanType" value="{{@$loanType}}">
            <input type="hidden" id="DataPact_id" name="DataPact_id" value="{{@$contract->id}}">
            <input type="hidden" id="DataCus_id" name="DataCus_id" value="{{@$contract->DataCus_id}}">
            <input type="hidden" id="locat" name="locat" value="{{@$contract->LOCAT}}">
            <input type="hidden" id="CUSCODE" name="CUSCODE" value="{{@$contract->PatchToPact->ContractToCus->IDCard_cus}}">
            <input type="hidden" name="TEMPBILL" value="{{@$HD_Code}}">

			<div class="row mb-2">
				<div class="col-xl-3 col-lg-3 col-md-3 col-sm-12 text-center">
					<div class="bg-light mini-stat-icon rounded-3 py-3 h-100 profile d-flex align-items-center justify-content-center">
						<div class="avatar-md mx-auto hover-slide">
							<span class="avatar-title rounded-circle bg-success fs-1">
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
                                        <input type="date" id="DateAppoint" name="DateAppoint" class="form-control" placeholder=" ">
                                        <span>วันที่แจ้งโอน</span>
                                    </div> -->
                                    <div class="input-bx" id="datepicker1">
                                        <input type="text" name="DateAppoint" id="DateAppoint" value="{{date('d/m/Y')}}"
                                            class="form-control text-start" placeholder="" min="{{date('Y-m-d',strtotime('+1days'))}}"
                                            data-date-format="dd/mm/yyyy" data-date-container="#datepicker1"
                                            data-provide="datepicker" data-date-disable-touch-keyboard="true"
                                            data-date-language="th" data-date-today-highlight="true"
                                            data-date-enable-on-readonly="true" data-date-clear-btn="true"
                                            autocomplete="off" data-date-autoclose="true" required>
                                        <span>วันที่นัดชำระ</span>
                                    </div>
								</div>
							</div>
							<div class="row g-2 align-self-center">
								<div class="col-sm-12 my-2">
                                    <div class="input-bx">
                                        <input type="text" id="CONTNO" name="Contract" value="{{@$contract->CONTNO}}" class="form-control" placeholder=" ">
                                        <span>เลขที่สัญญา</span>
                                    </div>
								</div>
								<!-- <div class="col-sm-6 my-2">
                                    <div class="form-floating">
                                        <input type="number" id="VATRT" name="VATRT" value="7" class="form-control" placeholder="อัตราภาษี">
                                        <label for="floatingnameInput">อัตราภาษี</label>
                                        <button class="input-group-text" type="button">
                                            %
                                        </button>
                                    </div>
								</div> -->
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
                                        <input type="text" id="PAYFOR_CODE" name="PayCode" value="{{@$Dcode}}" class="form-control PAYFOR_CODE" placeholder=" " required>
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
                                        <input type="number" id="MoneyPaid" name="MoneyPaid" class="form-control" placeholder=" ">
                                        <span>ชำระแล้ว</span>
                                        <button class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">บาท</button>
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
		<button type="button" class="btn btn-secondary btn-sm waves-effect w-md hover-up" data-bs-dismiss="modal">
			<i class="mdi mdi-close-circle-outline"></i> ปิด
		</button>
	</div>
</div>

{{-- Create Data --}}
<script>
  $("#SaveData").click(function(){

    var data = {};$("#formAdd").serializeArray().map(function(x){data[x.name] = x.value;});
    var TextHDpayment = $("#BILLHD").val();
    // console.log(data);
    
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
              page: 'store-deposit',
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
              $("#TextHDpayment").text(TextHDpayment);
              $("#DepositDetails").html(result);
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
        $('#FOLLOWCODE').on('keypress', function (e){
			if (e.keyCode === 13 || e.which === 13) {
				$("#PAYFOR_CODE").focus();
			}
        });
        $('#PAYFOR_CODE').on('change', function (e){
            let val = $(this).val();
			if (val != '') {
				$("#AmountPaid").focus();
			}
        });
    });
</script>
