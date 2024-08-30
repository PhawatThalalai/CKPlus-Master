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
                    <h5 class="text-primary fw-semibold pt-2 font-size-15">เพิ่มบริษัท</h5>
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
                                            <input type="text" id="TAXID" name="TAXID" class="form-control" placeholder="TAX ID" required>
                                            <label for="Contract">TAX ID</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="CODE" name="CODE" class="form-control" placeholder="รหัสสาขา" required>
                                            <label for="Contract">รหัสสาขา</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <!-- <div class="form-floating">
                                            <input type="text" id="TYPECOMPANY" name="TYPECOMPANY" class="form-control" placeholder="ประเภทบริษัท" required>
                                            <label for="Contract">ประเภทบริษัท</label>
                                        </div> -->
                                        <div class="form-floating">
                                            <select id="TYPECOMPANY" name="TYPECOMPANY" class="form-select" required>
                                                <option value="">--- เลือกประเภทบริษัท ---</option>
                                                <option value="1">เงินกู้</option>
                                                <option value="2">ลิสซิ่ง</option>
                                            </select>
                                            <label for="floatingSelectGrid">ประเภทบริษัท</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="PHONE" name="PHONE" class="form-control" placeholder="เบอร์โทร">
                                            <label for="Contract">เบอร์โทร</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="NAMECOMPANY" name="NAMECOMPANY" class="form-control" placeholder="ชื่อบริษัท" required>
                                            <label for="Contract">ชื่อบริษัท</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="ADDRCOMPANY" name="ADDRCOMPANY" placeholder="Leave a comment here" maxlength="10000" style="height: 150px" required></textarea>
                                        <label for="Note">ที่อยู่</label>
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
                    <h5 class="text-primary fw-semibold pt-2 font-size-15">เเก้ไขบริษัท</h5>
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
                                            <input type="text" id="TAXID" name="TAXID" value="{{@$data->Company_Id}}" class="form-control" placeholder="TAX ID" required>
                                            <label for="Contract">TAX ID</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="CODE" name="CODE" value="{{@$data->Company_Branch}}" class="form-control" placeholder="รหัสสาขา" required>
                                            <label for="Contract">รหัสสาขา</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <select id="TYPECOMPANY" name="TYPECOMPANY" class="form-select" required>
                                                <option value="">--- เลือกประเภทบริษัท ---</option>
                                                <option value="1" {{(@$data->Company_Type === '1')?'selected':''}}>เงินกู้</option>
                                                <option value="2" {{(@$data->Company_Type === '2')?'selected':''}}>ลิสซิ่ง</option>
                                            </select>
                                            <label for="floatingSelectGrid">ประเภทบริษัท</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="PHONE" name="PHONE" value="{{@$data->Company_Tel}}" class="form-control" placeholder="เบอร์โทร">
                                            <label for="Contract">เบอร์โทร</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="NAMECOMPANY" name="NAMECOMPANY" value="{{@$data->Company_Name}}" class="form-control" placeholder="ชื่อบริษัท" required>
                                            <label for="Contract">ชื่อบริษัท</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="ADDRCOMPANY" name="ADDRCOMPANY" placeholder="Leave a comment here" maxlength="10000" style="height: 150px" required>{{@$data->Company_Addr}}</textarea>
                                        <label for="Note">ที่อยู่</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-n4">
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
              store: 'company',
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
              $('#dataCompanies').html(result).show('slow');
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
                    update: 'company',
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
                    $('#dataCompanies').html(result).show('slow');
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