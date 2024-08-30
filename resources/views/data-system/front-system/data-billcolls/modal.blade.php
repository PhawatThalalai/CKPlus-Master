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

<style>
    #UserBranch option:disabled {
        background: #ccc;
    }
    [data-layout-mode="dark"] .form-select:disabled {
        color: #74788d;
        background-color: #222;
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
                    <h5 class="text-primary fw-semibold pt-2 font-size-15">เพิ่มพนักงานเก็บเงิน</h5>
                    <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>{{@$page}}</h6>
                    <p class="border-primary border-bottom mt-2"></p>
                </div>
                <input type="hidden" id="page" value="{{@$page}}">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-n4 mx-2 mb-1">
                <div class="row g-2 my-2">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-floating">
                            <input type="text" id="code_billcoll" name="code_billcoll" class="form-control" placeholder="รหัสพนักงานเก็บเงิน" autocomplete="off" required>
                            <label for="code_billcoll">รหัสพนักงานเก็บเงิน</label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-floating">
                            <input type="text" id="name_billcoll" name="name_billcoll" class="form-control" placeholder="ชื่อพนักงานเก็บเงิน" autocomplete="off">
                            <label for="name_billcoll">ชื่อพนักงานเก็บเงิน</label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-floating">
                            <select class="form-select" id="type_billcoll" name="type_billcoll" required>
                                <option value="" selected>-- เลือกประเภทพนักงานเก็บเงิน --</option>
                                <option value="B">สาขา</option>
                                <option value="T">อื่น ๆ (บุคคล/ทีมตาม)</option>
                            </select>
                            <label for="type_billcoll">ประเภทพนักงานเก็บเงิน</label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-floating">
                            <select class="form-select" id="UserBranch" name="UserBranch">
                                <option value="" selected>-- เลือกสาขา --</option>
                                @foreach(@$dataBranch as $key => $item)
                                    <option value="{{$item->id}}" >{{$item->NickName_Branch}} : {{$item->Name_Branch}}</option>
                                @endforeach
                            </select>
                            <label for="UserBranch">สาขา</label>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12">
                        <div class="form-floating">
                            <textarea name="note_billcoll" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                            <label for="floatingTextarea2">Comments</label>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-12">
                        <div class="mt-4 mt-lg-0">
                            <h5 class="font-size-12 mb-1 fw-bold">สถานะใช้งานพนักงานเก็บเงิน</h5>
                            <div class="d-flex">
                                <div class="square-switch">
                                    <input type="checkbox" id="square-switch3" switch="bool" name="status" value="Y" checked>
                                    <label for="square-switch3" data-on-label="เปิด" data-off-label="ปิด"></label>
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
    <form name="formUpdate" id="formUpdate" action="#" method="post" enctype="multipart/form-data" novalidate style="font-family: 'Prompt', sans-serif;">
        @csrf
        @method('put')
        <div class="modal-content">
            <div class="d-flex m-3 mb-0">
                <div class="flex-shrink-0 me-2">
                    <img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
                </div>
                <div class="flex-grow-1 overflow-hidden">
                    <h5 class="text-primary fw-semibold pt-2 font-size-15">แก้ไขพนักงานเก็บเงิน</h5>
                    <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>{{@$page}}</h6>
                    <p class="border-primary border-bottom mt-2"></p>
                </div>
                <input type="hidden" id="page" name="PAGE" value="{{@$page}}">
                <input type="hidden" id="id" name="ID" value="{{@$data->id}}">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-n4 mx-2 mb-1">
                <div class="row g-2 my-2">
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-floating">
                            <input type="text" id="code_billcoll" name="code_billcoll" class="form-control" placeholder="รหัสพนักงานเก็บเงิน" value="{{@$data->code_billcoll}}" autocomplete="off" required>
                            <label for="code_billcoll">รหัสพนักงานเก็บเงิน</label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-floating">
                            <input type="text" id="name_billcoll" name="name_billcoll" class="form-control" placeholder="ชื่อพนักงานเก็บเงิน" value="{{@$data->name_billcoll}}" autocomplete="off">
                            <label for="name_billcoll">ชื่อพนักงานเก็บเงิน</label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-floating">
                            <select class="form-select" id="type_billcoll" name="type_billcoll" required>
                                <option value="" selected>-- เลือกประเภทพนักงานเก็บเงิน --</option>
                                <option value="B" @selected(@$data->type_billcoll == 'B')>สาขา</option>
                                <option value="T" @selected(@$data->type_billcoll == 'T')>อื่น ๆ (บุคคล/ทีมตาม)</option>
                            </select>
                            <label for="type_billcoll">ประเภทพนักงานเก็บเงิน</label>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-floating">
                            <select class="form-select" id="UserBranch" name="UserBranch">
                                <option value="" selected>-- เลือกสาขา --</option>
                                @foreach(@$dataBranch as $key => $item)
                                    <option value="{{$item->id}}" @selected($item->id == @$data->UserBranch)>{{$item->NickName_Branch}} : {{$item->Name_Branch}}</option>
                                @endforeach
                            </select>
                            <label for="UserBranch">สาขา</label>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-12">
                        <div class="form-floating">
                            <textarea name="note_billcoll" class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px">{{@$data->note_billcoll}}</textarea>
                            <label for="floatingTextarea2">Comments</label>
                        </div>
                    </div>

                    <div class="col-md-12 col-lg-12">
                        <div class="mt-4 mt-lg-0">
                            <h5 class="font-size-12 mb-1 fw-bold">สถานะใช้งานพนักงานเก็บเงิน</h5>
                            <div class="d-flex">
                                <div class="square-switch">
                                    <input type="checkbox" id="square-switch3" switch="bool" name="status" value="Y" @checked(@$data->status == 'Y')>
                                    <label for="square-switch3" data-on-label="เปิด" data-off-label="ปิด"></label>
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
    </form>
@endif

{{-- Create Data --}}
<script>
$("#SaveData").click(function(){
    var data = {};$("#formAdd").serializeArray().map(function(x){data[x.name] = x.value;});   
    if ($("#formAdd").valid() == true) {
        $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
        $.ajax({
            url: "{{ route('dataStatic.store') }}",
            method: 'POST',
            data:{
                _token:'{{ csrf_token() }}',
                store: 'billcolls',
                data:data,
            },
            complete: function(data) {
                $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
            },
            success: function(result) {
                $('#Modal-xl').modal('hide');
                //$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                swal.fire({
                    icon : 'success',
                    text : 'บันทึกข้อมูลสำเร็จ',
                    timer: 3500,
                    dangerMode: true,
                })
                $('#dataBillcolls').html(result).show('slow');
                $('[data-bs-toggle="tooltip"]').tooltip();
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
            $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
            $.ajax({
                url: "{{ route('dataStatic.update',0) }}",
                method: 'PUT',
                // data:data,
                data:{
                    _token:'{{ csrf_token() }}',
                    update: 'billcolls',
                    data:data,
                },
                complete: function(data) {
                    $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                },
                success: function(result) {
                    $('#Modal-xl').modal('hide');
                    swal.fire({
                        icon : 'success',
                        title : 'อัพเดทข้อมูลสำเร็จ',
                        timer: 1500,
                        showConfirmButton: false,
                    })
                    $("#dataBillcolls").html(result).show('slow');
                    $('[data-bs-toggle="tooltip"]').tooltip();
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

<!-- สคริปต์อัพเดต type_billcoll -->
<script>
    function RefreshTypeBillColl() {
        var type = $("#type_billcoll").val();
        var userBranch = $("#UserBranch");

        if (type === "") {
            userBranch.prop('disabled', true).prop('required', false).val("");
        } else if (type === "B") {
            userBranch.prop('disabled', false).prop('required', true);
            userBranch.find("option").each(function() {
                $(this).prop('disabled', false);
            });
        } else if (type === "T") {
            userBranch.prop('disabled', false).prop('required', false).val("");
            userBranch.find("option").each(function(index) {
                if (index !== 0) {
                    $(this).prop('disabled', true);
                } else {
                    $(this).prop('selected', true);
                }
            });
        }
    }

    $(document).ready(function() {
        $("#type_billcoll").change(RefreshTypeBillColl);
        RefreshTypeBillColl();
    });
</script>

