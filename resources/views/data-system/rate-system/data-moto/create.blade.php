<script src="{{ URL::asset('/assets/js/bootstrap-dialog.min.js') }}"></script>

<form name="formAdd" id="formAdd" action="#" method="post" enctype="multipart/form-data" novalidate>
    @csrf
    <div class="modal-content" id="Modal-drag">
        <div class="d-flex m-3 mb-0">
            <div class="flex-shrink-0 me-2">
                <img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
            </div>
            <div class="flex-grow-1 overflow-hidden">
                <h4 class="text-primary fw-semibold">เพิ่มรายการ</h4>
                <p class="text-muted mt-n1">{{@$title}}</p>
                <p class="border-primary border-bottom mt-n2"></p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        @if(@$create == 'brand')
            <div class="card">
                <div class="card-body">
                    <div class="modal-body mt-n3">
                        <div class="row">
                            <div class="col-md-12 col-lg-4">
                                <!-- <h5 class="card-title mb-4">ข้อมูลการติดตามลูกหนี้</h5> -->
                                <div class="text-center">
                                    <div class="mb-1 mt-n3">
                                        <!-- <img src="{{ asset('assets/images/payment-1.png') }}" alt="" class="avatar-lg"> -->
                                        <img id="ImageBrok" src="assets/images/coming-soon.svg" class="avatar-lg">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-8">
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <div class="input-bx">
                                            <input type="text" id="BRANDCAR" name="BRANDCAR" class="form-control" placeholder=" " data-bs-toggle="tooltip" title="ยี่ห้อรถ" required/>
                                            <span>ยี่ห้อรถ</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-n4">
                <button type="button" id="SaveBrand" class="btn btn-primary">
                    <i class="bx bx-save"></i> Save
                </button>
            </div>
        @elseif(@$create == 'group') 
            <div class="card">
                <div class="card-body">
                    <div class="modal-body mt-n3">
                        <div class="row">
                            <div class="col-md-12 col-lg-4">
                                <!-- <h5 class="card-title mb-4">ข้อมูลการติดตามลูกหนี้</h5> -->
                                <div class="text-center">
                                    <div class="mb-1 mt-n3">
                                        <img id="ImageBrok" src="assets/images/coming-soon.svg" class="avatar-lg">
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <input type="checkbox" id="switch1" switch="danger">
                                        <label for="switch1" data-on-label="เปิด" data-off-label="ปิด"></label>
                                    </div>
                                    <p>การมองเห็น</p>
                                    <input type="hidden" name="BRAND_ID" value="{{@$brand_id}}">
                                    <input type="hidden" id="STATUS" name="STATUS">
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-8">
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <div class="input-bx mb-2">
                                            <input type="text" id="BRANDCAR" name="BRANDCAR" value="{{@$brand_name}}" class="form-control" placeholder=" " data-bs-toggle="tooltip" title="ยี่ห้อรถ" required/>
                                            <span>ยี่ห้อรถ</span>
                                        </div>
                                        <div class="input-bx mb-2">
                                            <select id="TYPECAR" name="TYPECAR" class="form-select text-dark" placeholder=" " data-bs-toggle="tooltip" title="ประเภทรถ" required>
                                                <option value="">--- เลือกประเภทรถ ---</option>
                                                @foreach(@$carType as $key => $value)
                                                    <option value="{{$value->code_car}}">{{$key+1}}. {{$value->nametype_car}}</option>
                                                @endforeach
                                            </select>
                                            <span>ประเภทรถ</span>
                                        </div>
                                        <div class="input-bx">
                                            <input type="text" id="GROUPCAR" name="GROUPCAR" class="form-control" data-bs-toggle="tooltip" title="กลุ่มรถ" placeholder=" " required/>
                                            <span>กลุ่มรถ</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-n4">
                <button type="button" id="SaveGroup" class="btn btn-primary">
                    <i class="bx bx-save"></i> Save
                </button>
            </div>
        @elseif(@$create == 'model')
            <div class="card">
                <div class="card-body">
                    <div class="modal-body mt-n3">
                        <div class="row">
                            <div class="col-md-12 col-lg-4">
                                <div class="text-center">
                                    <div class="mb-3 mt-n3">
                                        <img id="ImageBrok" src="assets/images/coming-soon.svg" class="avatar-lg">
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <input type="checkbox" id="switch2" switch="danger">
                                        <label for="switch2" data-on-label="เปิด" data-off-label="ปิด"></label>
                                    </div>
                                    <p>การมองเห็น</p>
                                    <div class="d-flex justify-content-center">
                                        <input type="checkbox" id="switch3" switch="danger">
                                        <label for="switch3" data-on-label="ใช่" data-off-label="ไม่"></label>
                                    </div>
                                    <p>รุ่นกลาง</p>
                                    <input type="hidden" name="BRAND_ID" value="{{@$brand_id}}">
                                    <input type="hidden" name="GROUP_ID" value="{{@$group_id}}">
                                    <input type="hidden" id="STATUS" name="STATUS">
                                    <input type="hidden" id="TOPCAR" name="TOPCAR">
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-8">
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <div class="input-bx mb-2">
                                            <input type="text" id="BRANDCAR" name="BRANDCAR" value="{{@$data->groupToBrandMoto->Brand_moto}}" class="form-control" placeholder=" " data-bs-toggle="tooltip" title="ยี่ห้อรถ" readonly/>
                                            <span>ยี่ห้อรถ</span>
                                        </div>
                                        <div class="input-bx mb-2">
                                            <input type="text" id="GROUPCAR" name="GROUPCAR" value="{{@$data->Group_moto}}" class="form-control" placeholder=" " data-bs-toggle="tooltip" title="ยี่ห้อรถ" readonly/>
                                            <span>กลุ่มรถ</span>
                                        </div>
                                        <div class="input-bx mb-2">
                                            <select id="TYPECAR" name="TYPECAR" class="form-select text-dark" placeholder=" " data-bs-toggle="tooltip" title="ประเภทรถ" required>
                                                <option value="">--- เลือกประเภทรถ ---</option>
                                                @foreach(@$carType as $key => $value)
                                                    <option value="{{$value->code_car}}" {{(@$data->Ratetype_id == $value->code_car)?'selected':''}}>{{$key+1}}. {{$value->nametype_car}}</option>
                                                @endforeach
                                            </select>
                                            <span>ประเภทรถ</span>
                                        </div>
                                        <div class="input-bx mb-2">
                                            <input type="text" id="MODELCAR" name="MODELCAR" class="form-control" data-bs-toggle="tooltip" title="รุ่นรถ" placeholder=" " required/>
                                            <span>รุ่นรถ</span>
                                        </div>
                                        <div class="input-bx">
                                            <input type="text" id="TANKCAR" name="TANKCAR" class="form-control" data-bs-toggle="tooltip" title="เลขตัวถัง" placeholder=" "/>
                                            <span>เลขตัวถัง</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-n4">
                <button type="button" id="SaveModel" class="btn btn-primary">
                    <i class="bx bx-save"></i> Save
                </button>
            </div>
        @elseif(@$create == 'yearcar')
            <div class="card">
                <input type="hidden" name="store" value="yearcar">
                <input type="hidden" name="BRAND_ID" value="{{@$brand_id}}">
                <input type="hidden" name="GROUP_ID" value="{{@$group_id}}">
                <input type="hidden" name="MODEL_ID" value="{{@$model_id}}">
                <input type="hidden" name="RATE_ID" value="{{@$rate_id}}">
                <input type="hidden" name="MODEL_NAME" value="{{(@$data != NULL)?@$data->yearToModelCar->Model_car:@$modelname}}">
                <div class="card-body">
                    <div class="modal-body mt-n4">
                        <h5 class="text-primary fw-semibold text-center mb-3">รุ่น : {{(@$data != NULL)?@$data->yearToModelMoto->Model_moto:@$modelname}}</h5>
                        <div class="row g-2 align-self-center border-top">
                            <div class="table-responsive font-size-11" data-simplebar="init" style="max-height : 390px;">
                                <table class="table align-middle table-hover tbl_code_with_mark">
                                    <thead class="sticky-top">
                                        <tr class="table-light">
                                            <th class="font-size-12" style="width: 20%;">
                                                ปีรถ
                                            </th>
                                            <th class="font-size-12" style="width: 35%;">
                                                Price AT
                                            </th>
                                            <th class="font-size-12" style="width: 35%;">
                                                Price MT
                                            </th>
                                            <th class="font-size-12 text-center" style="width: 10%;">
                                                <!-- <i class="bx bx-plus-circle"></i> -->
                                                <!-- <button type="button" class="btn btn-xs btn-success btn-rounded waves-effect"></button> -->
                                                <span id="addYear" class="badge badge-pill bg-success rounded-pill font-size-12 btn_row_add_below_end" style="cursor:pointer;">
                                                    เพิ่ม
                                                </span>
                                                <!-- # -->
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="width: 20%;">
                                                <div class="input-bx mb-2">
                                                    <input type="hidden" id="YEARCAR" name="YEARCAR[]" class="form-control list" placeholder=" " data-bs-toggle="tooltip" title="ปีรถ" required/>
                                                    <span>ปีรถ</span>
                                                </div>
                                            </td>
                                            <td style="width: 35%;">
                                                <div class="input-bx mb-2">
                                                    <input type="hidden" id="PRICE_AT" name="PRICE_AT[]" class="form-control list" placeholder=" " data-bs-toggle="tooltip" title="Price AT"/>
                                                    <span>Price AT</span>
                                                </div>
                                            </td>
                                            <td style="width: 35%;">
                                                <div class="input-bx mb-2">
                                                    <input type="hidden" id="PRICE_MT" name="PRICE_MT[]" class="form-control list" placeholder=" " data-bs-toggle="tooltip" title="Price MT"/>
                                                    <span>Price MT</span>
                                                </div>
                                            </td>
                                            <td style="width: 10%;">
                                                <div class="input-bx mb-2">
                                                    <!-- <button type="button" class="btn btn-xs btn-success btn-rounded waves-effect"></button> -->
                                                    <button type="button" class="btn btn-xs btn-danger btn-rounded waves-effect btn_row_delete">
                                                        ลบ
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-n4">
                <button type="button" id="SaveYear" class="btn btn-primary">
                    <i class="bx bx-save"></i> Save
                </button>
            </div>
        @endif 
    </div>
</form>

@if(@$create == 'brand')
    {{-- Create Brand --}}
    <script>
        $("#SaveBrand").click(function(){
            var data = {};$("#formAdd").serializeArray().map(function(x){data[x.name] = x.value;});
            if ($("#formAdd").valid() == true) {
                $.ajax({
                    url: "{{ route('MotoRate.store') }}",
                    method: 'POST',
                    data:{
                        _token:'{{ csrf_token() }}',
                        store: 'brand',
                        data:data,
                    },

                    success: function(result) {
                    $('#Modal-lg').modal('hide');
                    $('#Modal-xl').modal('hide');
                    swal.fire({
                        icon : 'success',
                        title : 'บันทึกข้อมูลสำเร็จ',
                        timer: 1500,
                        showConfirmButton: false,
                    })
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                    // $("#BrandDetails1").html(result);
                    // $("#BrandDetails2").html(result);
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
@elseif(@$create == 'group')
    {{-- Create Group --}}
    <script>
        $("#SaveGroup").click(function(){
            var data = {};$("#formAdd").serializeArray().map(function(x){data[x.name] = x.value;});
            if ($("#formAdd").valid() == true) {
                $.ajax({
                    url: "{{ route('MotoRate.store') }}",
                    method: 'POST',
                    data:{
                        _token:'{{ csrf_token() }}',
                        store: 'group',
                        data:data,
                    },

                    success: function(result) {
                    $('#Modal-lg').modal('hide');
                    $('#Modal-xl').modal('hide');
                    swal.fire({
                        icon : 'success',
                        title : 'บันทึกข้อมูลสำเร็จ',
                        timer: 1500,
                        showConfirmButton: false,
                    })
                    // $("#BrandDetails1").html(result);
                    $("#GroupDetails").html(result);
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
    <script>
        $("#switch1").on('click', function() {
            if ($("#switch1").is(':checked'))
                $("#STATUS").val('yes');
            else {
                $("#STATUS").val('');
            }
        });
    </script>
@elseif(@$create == 'model')
    {{-- Create model --}}
    <script>
        $("#SaveModel").click(function(){
            var data = {};$("#formAdd").serializeArray().map(function(x){data[x.name] = x.value;});
            if ($("#formAdd").valid() == true) {
                $.ajax({
                    url: "{{ route('MotoRate.store') }}",
                    method: 'POST',
                    data:{
                        _token:'{{ csrf_token() }}',
                        store: 'model',
                        data:data,
                    },

                    success: function(result) {
                        $('#Modal-lg').modal('hide');
                        $('#Modal-xl').modal('hide');
                        swal.fire({
                            icon : 'success',
                            title : 'บันทึกข้อมูลสำเร็จ',
                            timer: 1500,
                            showConfirmButton: false,
                        })
                        $("#ModelDetails").html(result);
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

    <script>
        $("#switch2").on('click', function() {
            if ($("#switch2").is(':checked'))
                $("#STATUS").val('yes');
            else {
                $("#STATUS").val('');
            }
        });
        $("#switch3").on('click', function() {
            if ($("#switch3").is(':checked'))
                $("#TOPCAR").val('yes');
            else {
                $("#TOPCAR").val('');
            }
        });
    </script>
@elseif(@$create == 'yearcar')
    {{-- Create yearcar --}}
    <script>
        $("#SaveYear").click(function(){
            var data = $('#formAdd').serialize();
            if ($("#formAdd").valid() == true) {
                $.ajax({
                    url: "{{ route('MotoRate.store') }}",
                    method: 'POST',
                    data:data,
                    success: function(result) {
                        // console.log(result);
                        $('#Modal-lg').modal('hide');
                        $('#Modal-xl').modal('hide');
                        swal.fire({
                            icon : 'success',
                            title : 'บันทึกข้อมูลสำเร็จ',
                            timer: 1500,
                            showConfirmButton: false,
                        })
                        $("#YearcarDetails").html(result);
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

    <script>
        $(".btn_row_add_below_end").on('click', function(e){
            var tableBody = $(document).find('.tbl_code_with_mark').find("tbody");
            var trLast = tableBody.find("tr:last");
            var trNew = trLast.clone();
            trLast.after(trNew);
        });
        $(document).on('click',".btn_row_delete", function(e){
            var r = $(this).closest('tr').remove();
        });
    </script>

    <script>
        function addCommas(nStr) {
            nStr += '';
            x = nStr.split('.');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }
        // $('#PRICE_AT,#PRICE_MT').on("input", function () {

        //     var GetPriceAT = $("#PRICE_AT").val();
        //     var PriceAT = GetPriceAT.replace(",", "");

        //     var GetPriceMT = $("#PRICE_MT").val();
        //     var PriceMT = GetPriceMT.replace(",", "");

        //     $("#PRICE_AT").val(addCommas(PriceAT));
        //     $("#PRICE_MT").val(addCommas(PriceMT));
        // });
    </script>
@endif

{{-- validate form --}}
<script>
    $(function () {
        $('#formAdd').validate({
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


