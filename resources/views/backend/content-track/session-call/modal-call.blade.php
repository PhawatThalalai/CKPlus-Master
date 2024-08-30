@include('backend.content-track.script')
@include('components.content-toast.view-toast')

<script src="{{ URL::asset('/assets/js/pages/form-validation.init.js')}}"></script>
<script src="{{ URL::asset('/assets/js/pages/toastr.init.js')}}"></script>
<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>

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

@php 
//dd(@$data->ContractToSPASTDUE->ASSIGN);
@endphp

<form name="formDeliver" id="formDeliver" action="#" method="post" enctype="multipart/form-data" novalidate>
    @csrf
    @method('put')
    <div class="modal-content">
        <div class="modal-header sticky-top" id="Modal-drag" style="cursor:move;">
            <div class="flex-shrink-0 me-2">
                <img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
            </div>
            <div class="flex-grow-1 overflow-hidden">
                <h4 class="text-primary fw-semibold placeholder-glow d-block d-sm-none">มอบหมาย</h4>
                <h4 class="text-primary fw-semibold placeholder-glow d-none d-sm-block">มอบหมายงาน</h4>
                <p class="text-muted mt-n1 placeholder-glow">{{@$data->CONTNO}}</p>
            </div>
            <button type="button" class="btn btn-success mr-5 pr-5 ml-5 SaveData" title="บันทึก" aria-label="Close">
                <span class="addSpin1"><i class="fas fa-download"></i></span> บันทึก
            </button>
            &nbsp;
            <button type="button" class="btn btn-danger " title="ปิด POP-UP" data-bs-dismiss="modal" aria-label="Close">
                ปิด
            </button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <input type="hidden" id="id" name="id" value="{{@$data->id}}">
                    <input type="hidden" id="loanType" name="loanType" value="{{@$loanType}}">
                    <input type="hidden" id="spast_id" name="spast_id" value="{{@$data->ContractToSPASTDUE->id}}">
                    <input type="hidden" id="contno" name="contno" value="{{@$data->CONTNO}}">
                    <input type="hidden" id="page" name="page" value="deliver-track">
                    <div class="card">
                        <div class="card-body">
                            <div class="text-center">
                                <div class="mb-1" style="height:25vh;">
                                    <br>
                                    <br>
                                    <br>
                                    <img src="{{ asset('assets/images/payment-1.png') }}" alt="" class="avatar-lg">
                                </div>
                                <input type="hidden" id="DateDeliver" name="DateDeliver" class="form-control" value="{{ date('Y-m-d') }}" min="{{date('Y-m-d')}}" placeholder="วันที่ออกงานติดตาม" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="row g-2">
                        <div class="col-12">
                            <div class="content-hide">
                                <label for="formrow-firstname-input" class="form-label">มอบหมาย</label>
                                <select class="form-select text-dark" id="ASSIGN" name="ASSIGN" placeholder=" " required>
                                    <option value="" selected>--- เลือกมอบหมาย ---</option>
                                    <!-- <option value="สาขา" >สาขา</option>
                                    <option value="หัวหน้า">หัวหน้า</option>
                                    <option value="GM">GM</option> -->
                                    @foreach(@$TrackDeliver as $key => $value)
                                        <option value="{{@$value->NAME}}" {{(@$data->ContractToSPASTDUE->ASSIGN == @$value->NAME)?'selected':''}}>{{@$value->NAME}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="content-hide mb-2">
                                <label for="formrow-firstname-input" class="form-label">หมายเหตุ</label>
                                <textarea class="form-control" placeholder="ลงบันทึก" name="MEMO" id="MEMO" maxlength="10000" style="height: 180px" title="หมายเหตุ" required>{{@$data->ContractToSPASTDUE->MEMO}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer mt-n3">
            <button type="button" class="btn btn-light mr-5 pr-5 ml-5 SaveData text-muted" title="บันทึก" aria-label="Close">
                <span class="addSpin1"><i class="fas fa-download"></i></span> บันทึก
            </button>
            <button type="button" class="btn btn-light text-muted" title="ปิด POP-UP" data-bs-dismiss="modal" aria-label="Close">
                ปิด
            </button>
        </div>
    </div>
</form>

{{-- Create Job Trackings --}}
<script>
  $(".SaveData").click(function(){

    var dataform = document.querySelectorAll('#formDeliver');
    var validate = validateForms(dataform);
    var data = $('#formDeliver').serialize();
        
    if (validate == true) {
        $('.SaveDT').prop('disabled', true);
        $('.addSpin1').empty();
        $('<span />', {
            class: "spinner-border spinner-border-sm",
            role: "status"
        }).appendTo(".addSpin1");
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

{{-- update deliver --}}
<script>
    $(".SaveData").click(function(){
        var dataform = document.querySelectorAll('#formDeliver');
        var validate = validateForms(dataform);
        var data = $('#formDeliver').serialize();
    
        if (validate == true) {
            $('.SaveData').prop('disabled', true);
            $('.addSpin1').empty();
            $('<span />', {
                class: "spinner-border spinner-border-sm",
                role: "status"
            }).appendTo(".addSpin1");
            $.ajax({
                url: "{{ route('datatrack.update',0) }}",
                method: 'PUT',
                data:data,

                success: function(result) {
                    $('#modal_lg').modal('hide');
                    swal.fire({
                        icon : 'success',
                        title : 'ส่งมอบสำเร็จ',
                        timer: 1500,
                        showConfirmButton: false,
                    })
                    $("#TrackDetails").html(result);
                }
            });
        }    
    });
</script>