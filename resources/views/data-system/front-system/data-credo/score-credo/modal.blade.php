<script src="{{ URL::asset('/assets/js/pages/form-validation.init.js')}}"></script>

<style>
    .form-floating {
		position: relative;
		display: flex;
		width: 100%;
		font-size: 12px;
		/* width: 300px; */
	}
</style>

@if(@$mode == 'create')
    <form name="formAdd" id="formAdd" action="#" method="post" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="modal-content">
            <div class="d-flex m-3 mb-0">
                <div class="flex-shrink-0 me-2">
                    <img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
                </div>
                <div class="flex-grow-1 overflow-hidden">
                    <h5 class="text-primary fw-semibold pt-2 font-size-15">เพิ่ม Score Credo</h5>
                    <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>{{@$page}}</h6>
                    <p class="border-primary border-bottom mt-2"></p>
                </div>
                <input type="hidden" id="page" value="{{@$page}}">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-n4">
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-2 mb-2">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="SCORE_CREDO" name="SCORE_CREDO" class="form-control" placeholder="Score Credo" required>
                                            <label for="Contract">Score Credo</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-2">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="NOTE_CREDO" name="NOTE_CREDO" class="form-control" placeholder="Remark">
                                            <label for="Contract">Remark</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-2 mb-2">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="PRECENT_CREDO" name="PRECENT_CREDO" class="form-control" placeholder="Precent Credo" required>
                                            <label for="Contract">Precent Credo</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mt-4 mt-lg-0">
                                            <h5 class="font-size-12">เปิดปิด  Score Credo</h5>
                                            <div class="d-flex">
                                                <div class="square-switch">
                                                    <input type="checkbox" id="square-switch3" switch="bool" name="FLAG" value="yes">
                                                    <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-n4">
                <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> -->
                <button type="button" id="SaveData" class="btn btn-primary rounded-pill me-2">
                    <i class="mdi mdi-content-save-edit"></i> Save
                </button>
            </div>
        </div>
    </form>
@elseif(@$mode == 'edit')
    <form name="formUp" id="formUp" action="#" method="post" enctype="multipart/form-data" novalidate style="font-family: 'Prompt', sans-serif;">
        @csrf
        @method('put')
        <div class="modal-content">
            <div class="d-flex m-3 mb-0">
                <div class="flex-shrink-0 me-2">
                    <img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
                </div>
                <div class="flex-grow-1 overflow-hidden">
                    <h5 class="text-primary fw-semibold pt-2 font-size-15">เเก้ไข Score Credo</h5>
                    <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>{{@$page}}</h6>
                    <p class="border-primary border-bottom mt-2"></p>
                </div>
                <input type="hidden" id="page" value="{{@$page}}">
                <input type="hidden" id="id" value="{{@$data->id}}">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-n4">
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-2 mb-2">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="SCORE_CREDO" name="SCORE_CREDO" value="{{$data->Score_rate}}" class="form-control" placeholder="Score Credo" required>
                                            <label for="Contract">Score Credo</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-2">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="NOTE_CREDO" name="NOTE_CREDO" value="{{$data->Notes}}" class="form-control" placeholder="Remark">
                                            <label for="Contract">Remark</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-2 mb-2">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="PERCENT_CREDO" name="PERCENT_CREDO" value="{{$data->Percen_rate}}" class="form-control" placeholder="Precent Credo" required>
                                            <label for="Contract">Precent Credo</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mt-4 mt-lg-0">
                                            <h5 class="font-size-12 mb-1">เปิดปิด  Score Credo</h5>
                                            <div class="d-flex">
                                                <div class="square-switch">
                                                    <input type="checkbox" id="square-switch3" switch="bool" name="FLAG" value="Y" {{(@$data->status == 'Y')?'checked':''}}>
                                                    <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-n4">
                <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> -->
                <button type="button" id="SaveData" class="btn btn-primary rounded-pill me-2">
                    <i class="mdi mdi-content-save-move"></i> Update
                </button>
            </div>
        </div>
    </form>
@endif

{{-- Create Data --}}
<script>
  $("#SaveData").click(function(){

    var data = {};$("#formAdd").serializeArray().map(function(x){data[x.name] = x.value;});
    console.log(data);
    
    if ($("#formAdd").valid() == true) {
        
    }
    else{
      // $("#loading_editGuarantor").attr('style', ''); // ***** แสดงตัวโหลด *****
      swal.fire({
              icon : 'warning',
              title : 'ข้อมูลไม่ครบ !',
              text : 'กรุณากรอกข้อมูลให้ครบถ้วน',
              timer: 3000,
              showConfirmButton: true,
            })
    }      
  });
</script>

{{-- validate form --}}
<script>
    $(function () {
        $('#formAdd,#formUp').validate({
            errorElement: 'span',
                errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>

