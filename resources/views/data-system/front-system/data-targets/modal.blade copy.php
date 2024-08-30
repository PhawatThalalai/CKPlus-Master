<script src="{{ URL::asset('/assets/js/pages/form-validation.init.js')}}"></script>
<link href="{{ URL::asset('/assets/css/select2-custom.css') }}" rel="stylesheet" type="text/css" />

@if(@$mode == 'create')
    <style>
        .select2-selection__clear {
            display: none !important;
        }
    </style>
    <form name="formAdd" id="formAdd" action="#" method="post" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="modal-content">
            <div class="d-flex m-3 mb-0">
                <div class="flex-shrink-0 me-2">
                    <img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
                </div>
                <div class="flex-grow-1 overflow-hidden">
                    <h5 class="text-primary fw-semibold pt-2 font-size-15">เพิ่ม เป้าสาขาใหม่</h5>
                    <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>{{@$page}}</h6>
                    <p class="border-primary border-bottom mt-2"></p>
                </div>
                <input type="hidden" id="page" name="PAGE" value="{{@$page}}">
                <input type="hidden" id="store" name="store" value="targets">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-n4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-3">
                                <div class="mb-3">
                                    <label for="formrow-email-input" class="form-label">ประเภทเป้า</label>
                                    <select name="TARGET_TYPE" id="TARGET_TYPE" class="form-select select2" placeholder="ประเภทเป้า" required>
                                        <option value="">---เลือกประเภทเป้า---</option>
                                        @foreach ($codeType as $key => $value)
                                        <option value="{{@$value->id}}">{{@$value->Target_Name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <input type="hidden" id="TARGET_ZONE" name="TARGET_ZONE" value="{{auth()->user()->zone}}" class="form-control" placeholder="ZONE">
                            </div>
                            <div class="col-md-12 col-lg-3">
                                <div class="mb-3">
                                    <label for="formrow-email-input" class="form-label">เป้าเดือน</label>
                                    <select id="TARGET_MONTH" class="form-select list select2" data-placeholder="เลือกเป้าเดือน" multiple="" required>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ @$i }}" {{(@$i == date('m')) ? 'selected' : '' }}>{{$i}}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-3">
                                <div class="row g-2 mb-3">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="TARGET_YEAR" name="TARGET_YEAR" value="{{date('Y')}}" class="form-control select2" placeholder="เป้าปี" required>
                                            <label for="Contract">เป้าปี</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-3">
                                <div class="form-floating text-center">
                                    <!-- <input type="text" id="TARGET_ZONE" class="form-control bg-warning" placeholder="ZONE"> -->
                                    <img src="{{ asset('assets/images/banner-sidebar.png') }}" alt="" height="50">
                                </div>
                            </div>
                        </div>
                        <div class="row g-2 align-self-center border-top">
                            <div class="table-responsive font-size-11" data-simplebar="init" style="max-height : 430px;">
                                <table class="table align-middle table-hover tbl_code_with_mark">
                                    <thead class="sticky-top">
                                        <tr class="table-light">
                                            <th class="font-size-12" style="width: 5%;">
                                                #
                                            </th>
                                            <th class="font-size-12" style="width: 20%;">
                                                ชื่อสาขา
                                            </th>
                                            <th class="font-size-12" style="width: 25%;">
                                                กลุ่มลูกค้า
                                            </th>
                                            <th class="font-size-12" style="width: 25%;">
                                                พนักงาน
                                            </th>
                                            <th class="font-size-12" style="width: 20%;">
                                                ยอดเป้า
                                            </th>
                                            <th class="font-size-12" style="width: 5%;">
                                                #
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(@$dataBranch as $key => $value)
                                            <tr>
                                                <td style="width: 5%;">
                                                    <div class="avatar-xs btn_row_key{{$key+1}}">
                                                        <span class="avatar-title rounded-circle bg-warning bg-gradient">
                                                            {{$key+1}}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td style="width: 20%;">
                                                    <div class="input-bx mb-1">
                                                        <input type="text" value="{{$value->Name_Branch}}" class="form-control border border-white btn_row_branch{{$key+1}}" placeholder=" " data-bs-toggle="tooltip" title="ชื่อสาขา"/>
                                                        <input type="hidden" id="TARGET_BRANCH" name="TARGET_BRANCH[]" value="{{$value->id}}" required/>
                                                    </div>
                                                </td>
                                                <td style="width: 25%;">
                                                    <div class="col-lg-12 cl-select2">
                                                        <div class="input-group">
                                                            <select id="TARGET_TYPECUS{{$key+1}}" class="form-select list select2" data-placeholder="เลือกกลุ่มลูกค้า" multiple="" required>
                                                                @foreach($dataTypecus as $key1 => $value1)
                                                                    <option value="{{$value1->id}}">{{$value1->Name_Cus}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <input type="hidden" id="TARGET_DETAIL{{$key+1}}" name="TARGET_TYPECUS[]" value="" class="form-control w-25" placeholder=" " data-bs-toggle="tooltip" title="ชื่อสาขา"/>
                                                    </div>
                                                </td>
                                                <td style="width: 25%;">
                                                    @php 
                                                        @$dataStaff = \App\Models\User::where('zone',auth()->user()->zone)->where('branch',@$value->id)->get();
                                                    @endphp
                                                    <div class="col-lg-12 cl-select2">
                                                        <div class="input-group">
                                                            <select id="TARGET_USER{{$key+1}}" name="TARGET_USER[]" class="form-control" data-placeholder="เลือกพนักงาน">
                                                                <option value="">&nbsp;&nbsp;&nbsp;เลือกพนักงาน</option>
                                                                @foreach($dataStaff as $key2 => $value2)
                                                                    <option value="{{$value2->id}}">{{$value2->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td style="width: 20%;">
                                                    <div class="input-bx mb-1">
                                                        <input type="number" id="TARGET_AMOUNT" name="TARGET_AMOUNT[]" value="{{@$value->Traget_Branch}}" class="form-control list" placeholder=" " data-bs-toggle="tooltip" title="ยอดเป้า" required/>
                                                    </div>
                                                </td>
                                                <td style="width: 5%;">
                                                    <button type="button" class="btn btn-xs btn-success btn-rounded waves-effect btn_row_add{{$key+1}}" style="cursor:pointer;">
                                                        <i class="bx bx-plus"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-xs btn-danger btn-rounded waves-effect btn_row_delete{{$key+1}} d-none">
                                                        <i class="bx bx-minus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-n4">
                    <button type="button" id="SaveData" class="btn btn-primary rounded-3 me-2">
                        <span class="addSpin"><i class="mdi mdi-content-save-edit"></i></span> บันทึก
                    </button>
                </div>
            </div>
        </div>
    </form>
@elseif(@$mode == 'create-past')
    <style>
        .select2-selection__clear {
            display: none !important;
        }
        .select2-search {
            display: none !important;
        }
        .select2-search--inline {
            display: none !important;
        }
    </style>
    
    <form name="formAdd" id="formAdd" action="#" method="post" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="modal-content">
            <div class="d-flex m-3 mb-0">
                <div class="flex-shrink-0 me-2">
                    <img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
                </div>
                <div class="flex-grow-1 overflow-hidden">
                    <h5 class="text-primary fw-semibold pt-2 font-size-15">เรียกเป้าเดือน</h5>
                    <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>{{@$page}}</h6>
                    <p class="border-primary border-bottom mt-2"></p>
                </div>
                <input type="hidden" id="page" name="PAGE" value="{{@$page}}">
                <input type="hidden" id="store" name="store" value="targets">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-n4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-3">
                                <!-- <div class="card">
                                    <div class="card-body"> -->
                                        <div class="row g-2 mb-3">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <select name="TARGET_TYPE" id="TARGET_TYPE" class="form-select" placeholder="ประเภทเป้า" required>
                                                        <option value="">---เลือกประเภทเป้า---</option>
                                                        @foreach ($codeType as $key => $value)
                                                        <option value="{{@$value->id}}" {{(@$dataTarget[0]->TypeTarget_id == @$value->id)?'selected':''}}>{{@$value->Target_Name}}</option>
                                                        @endforeach
                                                    </select>
                                                    <label for="Contract">ประเภทเป้า</label>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="TARGET_ZONE" name="TARGET_ZONE" value="{{auth()->user()->zone}}" class="form-control" placeholder="ZONE">
                                        <!-- <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="TARGET_ZONE" name="TARGET_ZONE" value="{{auth()->user()->zone}}" class="form-control" placeholder="ZONE">
                                                    <label for="Contract">ZONE</label>
                                                </div>
                                            </div>
                                        </div> -->
                                        
                                    <!-- </div>
                                </div> -->
                            </div>
                            <div class="col-md-12 col-lg-3">
                                <div class="row g-2 mb-3">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="TARGET_MONTH" name="TARGET_MONTH" value="" class="form-control" placeholder="เป้าเดือน" required>
                                            <label for="Contract">เป้าเดือน {{@$dataTarget[0]->Target_Month}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-3">
                                <div class="row g-2 mb-3">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="TARGET_YEAR" name="TARGET_YEAR" value="" class="form-control" placeholder="เป้าปี" required>
                                            <label for="Contract">เป้าปี {{@$dataTarget[0]->Target_Year}}</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-3">
                                <div class="form-floating text-center">
                                    <!-- <input type="text" id="TARGET_ZONE" class="form-control bg-warning" placeholder="ZONE"> -->
                                    <img src="{{ asset('assets/images/banner-sidebar.png') }}" alt="" height="50">
                                </div>
                            </div>
                        </div>
                        <div class="row g-2 align-self-center border-top">
                            <div class="table-responsive font-size-11" data-simplebar="init" style="max-height : 500px;">
                                <table class="table align-middle table-hover tbl_code_with_mark">
                                    <thead class="sticky-top">
                                        <tr class="table-light">
                                        <th class="font-size-12" style="width: 5%;">
                                                #
                                            </th>
                                            <th class="font-size-12" style="width: 20%;">
                                                ชื่อสาขา
                                            </th>
                                            <th class="font-size-12" style="width: 25%;">
                                                กลุ่มลูกค้า
                                            </th>
                                            <th class="font-size-12" style="width: 25%;">
                                                พนักงาน
                                            </th>
                                            <th class="font-size-12" style="width: 20%;">
                                                ยอดเป้า
                                            </th>
                                            <th class="font-size-12" style="width: 5%;">
                                                #
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count(@$dataTarget) > 0)
                                            @foreach(@$dataTarget as $key => $value)
                                                <tr>
                                                    <td style="width: 5%;">
                                                        <div class="avatar-xs btn_row_key{{$key+1}}">
                                                            <span class="avatar-title rounded-circle bg-warning bg-gradient">
                                                                {{$key+1}}
                                                            </span>
                                                        </div>
                                                    </td>
                                                    <td style="width: 20%;">
                                                        <div class="input-bx mb-1">
                                                            <input type="text" value="{{$value->ToBranch->Name_Branch}}" class="form-control border border-white" placeholder=" " data-bs-toggle="tooltip" title="ชื่อสาขา"/>
                                                            <input type="hidden" id="TARGET_BRANCH" name="TARGET_BRANCH[]" value="{{$value->Target_Branch}}" required/>
                                                            <input type="hidden" id="TARGET_ID" value="{{$value->id}}" required/>
                                                            <!-- <span>ชื่อสาขา</span> -->
                                                        </div>
                                                    </td>
                                                    <td style="width: 25%;">
                                                        @php 
                                                            @$TypeCus = explode(",",@$value->Target_Typcus);
                                                        @endphp
                                                        <div class="col-lg-12 cl-select2">
                                                            <div class="input-group">
                                                                <select id="TARGET_TYPECUS{{$key+1}}" class="form-select select2" data-placeholder="เลือกกลุ่มลูกค้า" required multiple="">
                                                                        @foreach($dataTypecus as $key1 => $value1)
                                                                            <option value="{{$value1->id}}" {{($value1->id == @$TypeCus[$key1] || $value1->id == @$TypeCus[1] || $value1->id == @$TypeCus[2] || $value1->id == @$TypeCus[3] || $value1->id == @$TypeCus[4])?'selected':''}}>{{$value1->Name_Cus}}</option>
                                                                        @endforeach
                                                                </select>
                                                            </div>
                                                            <input type="hidden" id="TARGET_DETAIL{{$key+1}}" name="TARGET_TYPECUS[]" value="{{@$value->Target_Typcus}}" class="form-control w-25" placeholder=" " data-bs-toggle="tooltip" title="ชื่อสาขา"/>
                                                        </div>
                                                    </td>
                                                    <td style="width: 25%;">
                                                        @php 
                                                            @$dataStaff = \App\Models\User::where('zone',auth()->user()->zone)->where('branch',@$value->Target_Branch)->get();
                                                        @endphp
                                                        <div class="col-lg-12 cl-select2">
                                                            <div class="input-group">
                                                                <select id="TARGET_USER{{$key+1}}" name="TARGET_USER[]" class="form-select" data-placeholder="เลือกพนักงาน">
                                                                    <option value="">&nbsp;&nbsp;&nbsp;เลือกพนักงาน</option>
                                                                    @foreach($dataStaff as $key2 => $value2)
                                                                        <option value="{{$value2->id}}" {{($value2->id == @$value->Target_User)?'selected':''}}>{{$value2->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td style="width: 20%;">
                                                        <div class="input-bx mb-1">
                                                            <input type="number" id="TARGET_AMOUNT" name="TARGET_AMOUNT[]" value="{{$value->Target_Amount}}" class="form-control list" placeholder=" " data-bs-toggle="tooltip" title="ยอดเป้า" required/>
                                                        </div>
                                                    </td>
                                                    <td style="width: 5%;">
                                                        <button type="button" class="btn btn-xs btn-success btn-rounded waves-effect btn_row_add{{$key+1}}" style="cursor:pointer;">
                                                            <i class="bx bx-plus"></i>
                                                        </button>
                                                        <button type="button" class="btn btn-xs btn-danger btn-rounded waves-effect btn_row_delete{{$key+1}} d-none">
                                                            <i class="bx bx-minus"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="6" class="text-center">--- ไม่พบข้อมูลเดือนก่อนหน้า ---</td>
                                            </tr> 
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-n4">
                    <button type="button" id="SaveData" class="btn btn-primary rounded-3 me-2">
                        <!-- <i class="mdi mdi-content-save-edit"></i> Save -->
                        <span class="addSpin"><i class="mdi mdi-content-save-edit"></i></span> บันทึก
                    </button>
                </div>
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
                    <h5 class="text-primary fw-semibold pt-2 font-size-15">เเก้ไข MS Teams</h5>
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
                        <!-- <div class="card">
                            <div class="card-body"> -->
                                <div class="row g-2 mb-3">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <select name="TARGET_TYPE" id="TARGET_TYPE" class="form-select" placeholder="ประเภทเป้า" required>
                                                <option value="">---เลือกประเภทเป้า---</option>
                                                
                                            </select>
                                            <label for="Contract">ประเภทเป้า</label>
                                        </div>
                                    </div>
                                </div>
                                
                            <!-- </div>
                        </div> -->
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <!-- <div class="card">
                            <div class="card-body"> -->
                                <div class="row g-2 mb-3">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="date" id="TARGET_MONTH" value="{{date('Y-m-01')}}" class="form-control" placeholder="เป้าเดือน" readonly>
                                            <label for="Contract">เป้าเดือน</label>
                                        </div>
                                    </div>
                                </div>
                            <!-- </div>
                        </div> -->
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-n4">
                <button type="button" id="updateData" class="btn btn-primary rounded-pill me-2">
                    <i class="mdi mdi-content-save-move"></i> Update
                </button>
            </div>
        </div>
    </form>
@endif

{{-- Create Data --}}
<script>
    $("#SaveData").click(function(){
        var data = $('#formAdd').serialize();
        if ($("#formAdd").valid() == true) {
            $('.addSpin').empty();
            $('<span />', {
                class: "spinner-border spinner-border-sm",
                role: "status"
            }).appendTo(".addSpin");
            $("#SaveData").attr('disabled',true);
            $.ajax({
                url: "{{ route('dataStatic.store') }}",
                method: 'POST',
                data:data,
                success: function(result) {
                    // console.log(result);
                    $('#Modal-lg').modal('hide');
                    $('#Modal-xl').modal('hide');
                    $('#Modal-xxl').modal('hide');
                    $('.addSpin').empty();
                    swal.fire({
                        icon : 'success',
                        title : 'บันทึกข้อมูลสำเร็จ',
                        timer: 1500,
                        showConfirmButton: false,
                    })
                    $('#dataTarget').html(result).show('slow');
                    $("#SaveData").attr('disabled',false);
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
            // $(".list").addClass('is-invalid');
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

{{-- select2 --}}
<script>
	$(document).ready(function() {
		initSelect2();
        // for (let i = 0; i <= {{count(@$dataBranch)}}; i++) {
        //     $('#formAdd').validate({
        //         rules: {
        //             TARGET_TYPECUSi: {
        //                 required: true,
        //                 minlength: 1 // Require at least one option to be selected
        //             }
        //         },
        //         messages: {
        //             TARGET_TYPECUSi: {
        //                 required: "Please select at least one option."
        //             }
        //         },
        //         errorPlacement: function(error, element) {
        //             if (element.is('select') && element.hasClass('select2')) {
        //                 error.insertAfter(element.next('.select2-container'));
        //             } else {
        //                 error.insertAfter(element);
        //             }
        //         }
        //     });
        // }
	});
    
    function initSelect2() {
        $('.select2').select2({
            theme: "bootstrap-5",
            language: "th",
            // width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: true,

            // กำหนดขนาดข้อความในตัวเลือก
            templateResult: function(state) {
                if (!state.id) {
                    return state.text;
                }
                return $('<span>' + state.text + '</span>').css('font-size', '12px'); // ตัวอย่าง: กำหนดขนาดเป็น 16px
            },
            templateSelection: function(state) {
                if (!state.id) {
                    return state.text;
                }
                return $('<span>' + state.text + '</span>').css('font-size', '10px'); // ตัวอย่าง: กำหนดขนาดเป็น 16px
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        for (let i = 0; i <= {{count(@$dataBranch)}}; i++) {
            $('#TARGET_TYPECUS'+i).on('change', function() {
                $(this).next().find('.select2-search--inline').hide();
                // $(this).removeClass('select2-search--inline');
                $('#TARGET_TYPECUS2').addClass('select2-search__field');
                var selectedOptions = $(this).val();
                $('#TARGET_DETAIL'+i).val(selectedOptions.join(','));
            });
        }
    });
</script>

<script>
    $(document).ready(function() {
        for (let i = 0; i <= {{count(@$dataBranch)}}; i++) {
            $(".btn_row_add"+i).on('click', function(e){
                // Find the current table row
                // initSelect2();
                var currentRow = $(this).closest('tr');
                // Clone the current row
                var newRow = currentRow.clone();
                // Insert the new row after the current row
                currentRow.after(newRow);

                // Initialize Select2 on the target element within the new row
                newRow.find('#TARGET_TYPECUS'+i).attr('id', 'TARGET_TYPECUS_'+i);
                newRow.find('#TARGET_TYPECUS'+i).attr('data-select2-id', 'TARGET_TYPECUS_'+i);
                // newRow.find('#TARGET_TYPECUS'+i+1).select2();

                // Hide the button in the new row
                newRow.find('.btn_row_key'+i).addClass('d-none'); // Change 'd-none' to your desired hide class
                // newRow.find('.btn_row_branch'+i).addClass('d-none'); // Change 'd-none' to your desired hide class
                newRow.find('.btn_row_add'+i).addClass('d-none'); // Change 'd-none' to your desired hide class
                newRow.find('.btn_row_delete'+i).removeClass('d-none'); // Change 'd-none' to your desired hide class
            });
            $(document).on('click',".btn_row_delete"+i, function(e){
                $(this).closest('tr').remove();
            });
        }
    });
</script>