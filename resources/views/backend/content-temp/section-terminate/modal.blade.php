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

<form name="formAdd" id="formAdd" action="#" method="post" enctype="multipart/form-data" novalidate>
    @csrf
    <input type="text" id="codloan" name="codloan" value="{{@$codloan}}">
    <input type="text" id="DataPact_id" name="DataPact_id" value="{{@$data->id}}">
    <div class="modal-content">
        <div class="d-flex m-3 mb-0" id="Modal-drag" style="cursor:move;">
            <div class="flex-shrink-0 me-2">
                <img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
            </div>
            <div class="flex-grow-1 overflow-hidden">
                <h4 class="text-primary fw-semibold">บันทึกก่อนพิมพ์</h4>
                <p class="text-muted mt-n1">หนังสือยืนยันบอกเลิกสัญญา</p>
                <p class="border-primary border-bottom mt-n2"></p>
            </div>
            <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
        </div>
        <div class="modal-body mt-n4">
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <div class="d-flex justify-content-center m-5">
                        <img class="img-fluid" src="{{ URL::asset('assets/images/undraw/undraw_resume_folder.svg') }}" style="height:25vh;" alt="Card image cap">
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="row g-2 mb-2">
                        <div class="col-12 col-md-12">
                            <div class="input-bx">
                                <input type="date" id="DatePrint" name="DatePrint" value="{{date('Y-m-d')}}" class="form-control" placeholder=" " required/>
                                <span>วันที่พิมพ์</span>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-12 col-md-12">
                            <div class="input-bx">
                                <input type="date" id="DateTerminate" name="DateTerminate" class="form-control" placeholder=" " required/>
                                <span>วันที่บอกเลิก</span>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-12 col-md-12">
                            <div class="form-floating">
                                <textarea class="form-control" placeholder="Leave a comment here" id="Note" name="Note" maxlength="2500" style="height: 10rem;"></textarea>
                                <label for="Note_cus" class="text-muted">หมายเหตุ</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer mt-n3">
            <button type="button" id="PrintForm" data-id="{{@$pact_id}}" class="btn btn-primary btn-sm waves-effect waves-light w-md hover-up">
                <span class="addSpin"><i class="fas fa-print"></i></span> พิมพ์
            </button>
            <button type="button" class="btn btn-secondary btn-sm waves-effect w-md hover-up" data-bs-dismiss="modal">
                <i class="mdi mdi-close-circle-outline"></i> ปิด
            </button>
            <a href="github-desktop://openRepo/https://github.com/username/repo">Open in GitHub Desktop</a>
        </div>
    </div>
</form>

<script>
  $("#PrintForm").click(function(){

    var data = {};$("#formAdd").serializeArray().map(function(x){data[x.name] = x.value;});
    
    if ($("#formAdd").valid() == true) {
        let id = $(this).data('id');
        let datePrint = $("#DatePrint").val();
        let dateTerminate = $("#DateTerminate").val();
        let Note = $("#Note").val();
        let url = "{{route('report-backend.show', ':id')}}?page={{'rp-terminate'}}&codloan={{@$data->CODLOAN}}&datePrint={{':datePrint'}}&dateTerminate={{':dateTerminate'}}&Note={{':Note'}}";
            url = url.replace(':id', id);
            url = url.replace(':datePrint', datePrint);
            url = url.replace(':dateTerminate', dateTerminate);
            url = url.replace(':Note', Note);
        window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes");
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