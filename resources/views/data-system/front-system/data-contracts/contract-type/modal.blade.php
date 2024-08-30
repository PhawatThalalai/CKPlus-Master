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
                    <h5 class="text-primary fw-semibold pt-2 font-size-15">เพิ่มประเภทสัญญา</h5>
                    <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>{{@$page}}</h6>
                    <p class="border-primary border-bottom mt-2"></p>
                </div>
                <input type="hidden" id="page" value="{{@$page}}">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-n4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="CONT_NAME" name="CONT_NAME" class="form-control" placeholder="ชื่อสัญญา" required>
                                            <label for="Contract">ชื่อสัญญา</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <select id="CONT_TYPE" name="CONT_TYPE" class="form-control" required>
                                                <option value="">--เลือกประเภทสัญญา--</option>
                                                <option value="car">รถยนต์</option>
                                                <option value="moto">รถมอเตอร์ไซต์</option>
                                                <option value="land">ที่ดิน</option>
                                                <option value="person">ส่วนบุคคล</option>
                                            </select>
                                            <label for="floatingSelectGrid">ประเภทสัญญา</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="CONT_CODE" name="CONT_CODE" class="form-control" placeholder="รหัสสัญญา" required>
                                            <label for="Contract">รหัสสัญญา</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="CODE_PLT" name="CODE_PLT" class="form-control" placeholder="CODE PLT" required>
                                            <label for="Contract">CODE PLT</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-n4">
                    <button type="button" id="SaveData" class="btn btn-primary rounded-pill me-2">
                        <i class="mdi mdi-content-save-edit"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </form>
@elseif(@$mode == 'edit')
    <form name="formUpdate" id="formUpdate" action="#" method="post" enctype="multipart/form-data" novalidate style="font-family: 'Prompt', sans-serif;">
        @csrf
        @method('put')
        <div class="modal-content">
            <div class="d-flex m-3 mb-0">
                <div class="flex-shrink-0 me-2">
                    <img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
                </div>
                <div class="flex-grow-1 overflow-hidden">
                    <h5 class="text-primary fw-semibold pt-2 font-size-15">เเก้ไขประเภทสัญญา</h5>
                    <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>{{@$page}}</h6>
                    <p class="border-primary border-bottom mt-2"></p>
                </div>
                <input type="hidden" id="page" name="PAGE" value="{{@$page}}">
                <input type="hidden" id="id" name="ID" value="{{@$data->id}}">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-n4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="CONT_NAME" name="CONT_NAME" value="{{@$data->Loan_Name}}" class="form-control" placeholder="ชื่อสัญญา" required>
                                            <label for="Contract">ชื่อสัญญา</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-5">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <select id="CONT_TYPE" name="CONT_TYPE" class="form-select" required>
                                                <option value="">--เลือกประเภทสัญญา--</option>
                                                <option value="car" {{(@$data->id_rateType=='car')?'selected':''}}>รถยนต์</option>
                                                <option value="moto" {{(@$data->id_rateType=='moto')?'selected':''}}>รถมอเตอร์ไซต์</option>
                                                <option value="land" {{(@$data->id_rateType=='land')?'selected':''}}>ที่ดิน</option>
                                                <option value="person" {{(@$data->id_rateType=='person')?'selected':''}}>ส่วนบุคคล</option>
                                            </select>
                                            <label for="floatingSelectGrid">ประเภทสัญญา</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="CONT_CODE" name="CONT_CODE" value="{{@$data->Loan_Code}}" class="form-control" placeholder="รหัสสัญญา" required>
                                            <label for="Contract">รหัสสัญญา</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="CODE_PLT" name="CODE_PLT" value="{{@$data->Code_PLT}}" class="form-control" placeholder="CODE PLT" required>
                                            <label for="Contract">CODE PLT</label>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    if(@$u_zone == 10) {
                                        $active =  $data->Flagzone_PTN;
                                    }elseif(@$u_zone == 20) {
                                        $active = $data->Flagzone_HY;
                                    }elseif(@$u_zone == 30){
                                        $active =  $data->Flagzone_NK;
                                    }elseif(@$u_zone == 40){
                                        $active = $data->Flagzone_KB;
                                    }elseif(@$u_zone == 50){
                                        $active = $data->Flagzone_SR;
                                    }
                                @endphp
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mt-4 mt-lg-0">
                                            <h5 class="font-size-12 mb-1">เปิดปิดประเภทสัญญา</h5>
                                            <div class="d-flex">
                                                <div class="square-switch">
                                                    <input type="checkbox" id="square-switch3" switch="bool" name="FLAG" value="active" {{($active=='active')?'checked':''}}>
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
                <div class="modal-footer mt-n4">
                    <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> -->
                    <button type="button" id="UpdateData" class="btn btn-primary rounded-pill me-2">
                        <i class="mdi mdi-content-save-move"></i> Update
                    </button>
                </div>
            </div>
        </div>
    </form>
@endif

{{-- Create Data --}}
<script>
  $("#SaveData").click(function(){
    var data = {};$("#formAdd").serializeArray().map(function(x){data[x.name] = x.value;});   
    if ($("#formAdd").valid() == true) {
        // $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
        $.ajax({
            url: "{{ route('dataStatic.store') }}",
            method: 'POST',
            data:{
              _token:'{{ csrf_token() }}',
              store: 'contract-type',
              data:data,
            },
            success: function(result) {
              $('#Modal-xl').modal('hide');
            //   $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
              swal.fire({
                icon : 'success',
                text : 'บันทึกข้อมูลสำเร็จ',
                timer: 3500,
                dangerMode: true,
              })
              $('#dataContract').html(result).show('slow');
            }
        });
    }
    else{
        // $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
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

{{-- Update Data --}}
<script>
    $("#UpdateData").click(function(){
        var data = {};$("#formUpdate").serializeArray().map(function(x){data[x.name] = x.value;});
        if ($("#formUpdate").valid() == true) {
            $.ajax({
                url: "{{ route('dataStatic.update',0) }}",
                method: 'PUT',
                // data:data,
                data:{
                    _token:'{{ csrf_token() }}',
                    update: 'contract-type',
                    data:data,
                },

                success: function(result) {
                    // $('.modal-backdrop').remove();
                    $('#Modal-xl').modal('hide');
                    swal.fire({
                        icon : 'success',
                        title : 'อัพเดทข้อมูลสำเร็จ',
                        timer: 1500,
                        showConfirmButton: false,
                    })
                    $("#dataContract").html(result).show('slow');
                }
            });
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

