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
                    <h5 class="text-primary fw-semibold pt-2 font-size-15">เพิ่มโปรโมชั่น</h5>
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
                                            <input type="text" id="PROMOTION_NAME" name="PROMOTION_NAME" class="form-control" placeholder="ชื่อโปรโมชั่น" required>
                                            <label for="Contract">ชื่อโปรโมชั่น</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <select id="PROMOTION_TYPE" name="PROMOTION_TYPE" class="form-control" required>
                                                <option value="">--- เลือกโปรโมชั่น ---</option>
                                                <option value="1">ลดดอกเบี้ย%</option>
                                                <option value="2">ส่วนลดยอดเงิน</option>
                                                <option value="3">ส่วนลดPA %</option>
                                            </select>
                                            <label for="floatingSelectGrid">ประเภทโปรโมชั่น</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="DETAIL" name="DETAIL" placeholder="Leave a comment here" maxlength="10000" style="height: 50px"></textarea>
                                        <label for="Note">รายละเอียด</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="date" id="START_DATE" name="START_DATE" class="form-control" placeholder="วันเริ่มโปรโมชั่น" required>
                                            <label for="Contract">วันเริ่มโปรโมชั่น</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="date" id="END_DATE" name="END_DATE" class="form-control" placeholder="วันสิ้นสุดโปรโมชั่น" required>
                                            <label for="Contract">วันสิ้นสุดโปรโมชั่น</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="DISCOUNT" name="DISCOUNT" class="form-control" placeholder="ส่วนลด">
                                            <label for="Contract">ส่วนลด</label>
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
                    <h5 class="text-primary fw-semibold pt-2 font-size-15">เเก้ไขโปรโมชั่น</h5>
                    <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>{{@$page}}</h6>
                    <p class="border-primary border-bottom mt-2"></p>
                </div>
                <input type="hidden" id="page" name="PAGE" value="{{@$page}}">
                <input type="hidden" id="id" name="ID" value="{{@$data->id}}">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-n4">
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="PROMOTION_NAME" name="PROMOTION_NAME" value="{{$data->Name_pro}}" class="form-control" placeholder="ชื่อโปรโมชั่น" required>
                                            <label for="Contract">ชื่อโปรโมชั่น</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <select id="PROMOTION_TYPE" name="PROMOTION_TYPE" class="form-select" required>
                                                <option value="">--- เลือกโปรโมชั่น ---</option>
                                                <option value="1" {{(@$data->Type_pro==1)?'selected':''}}>ลดดอกเบี้ย%</option>
                                                <option value="2" {{(@$data->Type_pro==2)?'selected':''}}>ส่วนลดยอดเงิน</option>
                                                <option value="3" {{(@$data->Type_pro==3)?'selected':''}}>ส่วนลดPA %</option>
                                            </select>
                                            <label for="floatingSelectGrid">ประเภทโปรโมชั่น</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="DETAIL" name="DETAIL" placeholder="Leave a comment here" maxlength="10000" style="height: 110px">{{$data->Detail_pro}}</textarea>
                                        <label for="Note">รายละเอียด</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="DISCOUNT" name="DISCOUNT" value="{{$data->Value_pro}}" class="form-control" placeholder="ส่วนลด">
                                            <label for="Contract">ส่วนลด</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="date" id="START_DATE" name="START_DATE" value="{{$data->Start_pro}}" class="form-control" placeholder="วันเริ่มโปรโมชั่น" required>
                                            <label for="Contract">วันเริ่มโปรโมชั่น</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="date" id="END_DATE" name="END_DATE" value="{{$data->End_pro}}" class="form-control" placeholder="วันสิ้นสุดโปรโมชั่น" required>
                                            <label for="Contract">วันสิ้นสุดโปรโมชั่น</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="mt-4 mt-lg-0">
                                            <h5 class="font-size-12 mb-1">เปิดปิดโปรโมชั่น</h5>
                                            <div class="d-flex">
                                                <div class="square-switch">
                                                    <input type="checkbox" id="square-switch3" switch="bool" name="FLAG" value="yes" {{(@$data->Status_pro == 'yes')?'checked':''}}>
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
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> -->
                <button type="button" id="UpdateData" class="btn btn-primary rounded-pill me-2">
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
    if ($("#formAdd").valid() == true) {
        // $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
        $.ajax({
            url: "{{ route('dataStatic.store') }}",
            method: 'POST',
            data:{
              _token:'{{ csrf_token() }}',
              store: 'promotion',
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
              $('#dataPromotions').html(result).show('slow');
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
                    update: 'promotion',
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
                    $("#dataPromotions").html(result).show('slow');
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

