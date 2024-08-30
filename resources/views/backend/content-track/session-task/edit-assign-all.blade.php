@php
    switch ($groupingType) {
        case 'P':
            $_type = "phone";
            break;
        case 'T':
            $_type = "track";
            break;
        case 'L':
            $_type = "land";
            break;
        default:
            $_type = "";
            break;
    }
@endphp


<form name="FormAssignAll" id="FormAssignAll" action="{{ route('spast.update',0) }}" method="post" enctype="multipart/form-data" novalidate style="font-family: 'Prompt', sans-serif;">
    @csrf
    @method('put')
    <input type="hidden" name="page" value="assign-all">
    @if($groupingType == 'P')
        <input type="hidden" name="mode" value="phone">
    @elseif($groupingType == 'T')
        <input type="hidden" name="mode" value="track">
    @elseif($groupingType == 'L')
        <input type="hidden" name="mode" value="land">
    @endif
    
    <div class="modal-content">
        <div class="d-flex m-3 mb-0">
            <div class="flex-shrink-0 me-2">
                <img src="{{ asset('assets/images/gif/demand.gif') }}" alt="" class="avatar-sm">
            </div>
            <div class="flex-grow-1 overflow-hidden">
                <h4 class="text-primary fw-semibold">{{@$title}}</h4>
                <p class="text-muted mt-n1">โซน {{@$zoneName}}</p>
                <p class="border-primary border-bottom mt-n2"></p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body pt-0">

            <div class="alert alert-info" role="alert">
                <i class="fas fa-info-circle pe-2"></i>มอบหมายงานทั้งหมดในคราวเดียวกันได้ โดยจะมอบหมายงานเฉพาะงานในกลุ่มที่ยังไม่ได้มอบหมายเท่านั้น
            </div>

            <h5 class="text-primary">สินเชื่อเช่าซื้อ (HP)</h5>
            <div class="table-responsive">
                <table class="table table-sm table-hover table-borderless align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>กลุ่มที่</th>
                            <th>ชื่อกลุ่ม</th>
                            <th>จำนวนงานที่เหลือ</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @if(@$data->where('CODLOAN','2')->whereNull('FOLCODE')->count() > 0)
                            @php
                                $_codloan = 2;
                            @endphp
                            @forEach(@$data->where('CODLOAN','2')->whereNull('FOLCODE')->groupBy('GroupingTemp') as $group)
                                @php
                                    $_locat = $group->first()->LOCAT;
                                    $_groupingtemp = $group->first()->GroupingTemp;
                                    $_groupingtype = $group->first()->GroupingType;
                                    //---------------------------------------------------
                                    $count_all = $data->where('CODLOAN','2')->where('GroupingTemp', $_groupingtemp)->count();
                                    $progressbar = round( ($count_all - $group->count()) / $count_all * 100, 0);
                                    //$progressbar = rand(0,100);
                                @endphp
                                <tr>
                                    <th>{{$_groupingtemp}}</th>
                                    <td class="text-start"
                                        @if($progressbar > 0)
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="แบ่งไปแล้ว {{$progressbar}}%"
                                        @endif>
                                        @if($groupingType == 'P')
                                            {{ @$branch_name[$_locat] }}
                                        @endif
                                        @if($groupingType == 'T' || $groupingType == 'L')
                                            กลุ่มที่ {{ $_groupingtemp }}
                                        @endif
                                        <div class="progress" style="height: 2.5px;">
                                            <div class="progress-bar" role="progressbar" style="width: {{$progressbar}}%;" aria-valuenow="{{$progressbar}}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td>{{$group->count()}}</td>
                                    <td>
                                        <select class="form-select billcoll-select" name="AssignAll_BILLCOLL[{{$_codloan}}][{{$_groupingtemp}}]" id="AssignAll_BILLCOLL_{{$_codloan}}_{{$_groupingtemp}}" data-bs-toggle="tooltip" title="พนักงานเก็บเงิน" required>
                                            <option value="" selected>-- กำหนดพนักงานเก็บเงิน --</option>
                                            @if( $groupingType == 'P' )
                                                @foreach($billcoll as $i => $value)
                                                    <option value="{{$value->id}}" @selected($_locat == $value->locat_id)>{{$value->DISPLAY_BILLCOLL}}</option>
                                                @endforeach
                                            @else
                                                @foreach($billcoll as $i => $value)
                                                    <option value="{{$value->id}}">{{$value->DISPLAY_BILLCOLL}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">- ยังไม่มีรายการรอบันทึก -</td>
                            </tr>
                        @endif
                    </tbody>
                </table>

            </div>

            <h5 class="text-primary">สินเชื่อเงินกู้ (PSL)</h5>
            <div class="table-responsive">
                <table class="table table-sm table-hover table-borderless align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>กลุ่มที่</th>
                            <th>ชื่อกลุ่ม</th>
                            <th>จำนวนงานที่เหลือ</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="table-group-divider">
                        @if(@$data->where('CODLOAN','1')->whereNull('FOLCODE')->count() > 0)
                            @php
                                $_codloan = 1;
                            @endphp
                            @forEach(@$data->where('CODLOAN','1')->whereNull('FOLCODE')->groupBy('GroupingTemp') as $group)
                                @php
                                    $_locat = $group->first()->LOCAT;
                                    $_groupingtemp = $group->first()->GroupingTemp;
                                    $_groupingtype = $group->first()->GroupingType;
                                    //---------------------------------------------------
                                    $count_all = $data->where('CODLOAN','1')->where('GroupingTemp', $_groupingtemp)->count();
                                    $progressbar = round( ($count_all - $group->count()) / $count_all * 100, 0);
                                    //$progressbar = rand(0,100);
                                @endphp
                                <tr>
                                    <th>{{$_groupingtemp}}</th>
                                    <td class="text-start"
                                        @if($progressbar > 0)
                                            data-bs-toggle="tooltip" data-bs-placement="bottom" title="แบ่งไปแล้ว {{$progressbar}}%"
                                        @endif>
                                        @if($groupingType == 'P')
                                            {{ @$branch_name[$_locat] }}
                                        @endif
                                        @if($groupingType == 'T' || $groupingType == 'L')
                                            กลุ่มที่ {{ $_groupingtemp }}
                                        @endif
                                        <div class="progress" style="height: 2.5px;">
                                            <div class="progress-bar" role="progressbar" style="width: {{$progressbar}}%;" aria-valuenow="{{$progressbar}}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td>{{$group->count()}}</td>
                                    <td>
                                        <select class="form-select billcoll-select" name="AssignAll_BILLCOLL[{{$_codloan}}][{{$_groupingtemp}}]" id="AssignAll_BILLCOLL_{{$_codloan}}_{{$_groupingtemp}}" data-bs-toggle="tooltip" title="พนักงานเก็บเงิน" required>
                                            <option value="" selected>-- กำหนดพนักงานเก็บเงิน --</option>
                                            @if( $groupingType == 'P' )
                                                @foreach($billcoll as $i => $value)
                                                    <option value="{{$value->id}}" @selected($_locat == $value->locat_id)>{{$value->DISPLAY_BILLCOLL}}</option>
                                                @endforeach
                                            @else
                                                @foreach($billcoll as $i => $value)
                                                    <option value="{{$value->id}}">{{$value->DISPLAY_BILLCOLL}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">- ยังไม่มีรายการรอบันทึก -</td>
                            </tr>
                        @endif
                    </tbody>

                </table>

            </div>

        </div>
        <div class="modal-footer mt-n3">
            @if(@$data->whereNull('FOLCODE')->count() > 0)
                <button type="submit" class="btn btn-success btn-sm btnSaveAssignAll">
                    <i class="fas fa-save"></i> บันทึก
                </button>
            @endif
            <button type="button" class="btn btn-secondary btn-sm btnCloseModal" data-bs-dismiss="modal" aria-label="Close">
                <i class="fas fa-share"></i> ปิด
            </button>
        </div>
    </div>
</form>

<script src="{{ URL::asset('assets/js/input-bx-select.js') }}"></script>

<script>

    $('[data-bs-toggle="tooltip"]').tooltip();

</script>

<!-- validate form -->
<script>
    $(function () {
        $('#FormAssignAll').validate({
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

        $( "#FormAssignAll" ).on( "submit", function( event ) {
            //alert( "Handler for `submit` called." );

            console.log("Submit Form!");
            if ( $("#FormAssignAll").valid() == true ) {
                console.log("validate!");

                Swal.fire({
                    title: 'ยืนยันการบันทึก',
                    text: "จะมอบหมายงานที่เหลือให้กับงานที่ยังไม่ได้แบ่งทันที",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'บันทึก',
                    cancelButtonText: 'ยกเลิก', 
                }).then((result) => {
                    if (result.isConfirmed) {
                        //AjaxRequestGroupingPhone(true);
                        console.log("confirm!");
                        $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
                        // ส่ง ajax
                        $.ajax({
                            url: "{{ route('spast.update', 0 ) }}",
                            method: "PUT",
                            data: $('#FormAssignAll').serialize(),
                            complete: function(data) {
                                $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                            },
                            success: function(result) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'สำเร็จ!',
                                    text: result.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                $("#{{$_type}}-tabContent").html(result.html);
                                $('#modal_lg').modal('hide');
                            },
                            error: function(err) {
                                Swal.fire({
                                    icon: 'error',
                                    title: `ERROR ` + err.status + ` !!!`,
                                    text: err.responseJSON.message,
                                    showConfirmButton: true,
                                });
                            },
                        });
                        
                    }
                });

            }
            else {
                swal.fire({
                    icon : 'warning',
                    title : 'ข้อมูลไม่ครบ !',
                    text : 'กรุณากรอกข้อมูลให้ครบถ้วน',
                    timer: 2000,
                    showConfirmButton: false,
                    //confirmButtonText: "เข้าใจแล้ว", 
                });
            }

            event.preventDefault();
        });
    });
</script>
