@php
    switch ($groupingType) {
        case 'P':
            $_Type = "Phone";
            $_type = "phone";
            $_card_bg = "bg-primary";
            break;
        case 'T':
            $_Type = "Track";
            $_type = "track";
            $_card_bg = "bg-warning";
            break;
        case 'L':
            $_Type = "Land";
            $_type = "land";
            $_card_bg = "bg-success";
            break;
        default:
            $_Type = "";
            $_type = "";
            break;
    }
@endphp

<form name="FormAssign{{$_Type}}" id="FormAssign{{$_Type}}" action="{{ route('datatrack.update',0) }}" method="post" enctype="multipart/form-data" novalidate style="font-family: 'Prompt', sans-serif;">
    @csrf
    @method('put')
    <input type="hidden" name="CODLOAN" value="{{@$CODLOAN}}">
    
    <div class="modal-content overflow-visible">

        <!-- หัวการ์ดแบบใหญ่ -->
        <div class="card overflow-hidden m-0 shadow-none d-none d-lg-block d-md-none">
            <div @class(['bg-primary' => $groupingType == 'P',
                'bg-warning' => $groupingType == 'T',
                'bg-success' => $groupingType == 'L',
                'bg-soft'])>
                <div class="row">
                    <div class="col">
                        <div @class(['text-primary' => $groupingType == 'P',
                            'text-dark' => $groupingType == 'T',
                            'text-success' => $groupingType == 'L',
                            'p-3 fw-bold p-4'])>
                            <h4 @class(['text-primary' => $groupingType == 'P',
                                'text-dark' => $groupingType == 'T',
                                'text-success' => $groupingType == 'L',
                                'fw-semibold'])>{{@$title}}</h5>
                            <p>โซน {{@$zoneName}}</p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-xl-3 align-self-end">
                        @if( $groupingType == 'P')
                            <img src="{{ asset('assets/images/task-phone.png') }}" alt="" class="img-fluid">
                        @endif
                        @if( $groupingType == 'T')
                            <img src="{{ asset('assets/images/task-track.png') }}" alt="" class="img-fluid">
                        @endif
                        @if( $groupingType == 'L')
                            <img src="{{ asset('assets/images/task-land.png') }}" alt="" class="img-fluid">
                        @endif
                    </div>
                    <div class="col-auto me-3 mt-3">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0 pb-1">
                <div class="row">
                    <div class="col-sm-4 col-lg-2 d-flex justify-content-center d-flex justify-content-center">
                        <div class="avatar-md profile-user-wid mb-4">
                            <span class="avatar-title rounded-circle bg-light border border-light border-3 shadow-lg">
                                <span @class([
                                    'bg-primary bg-opacity-25 text-primary' => $groupingType == 'P',
                                    'bg-warning bg-opacity-25 text-dark' => $groupingType == 'T',
                                    'bg-success bg-opacity-25 text-success' => $groupingType == 'L',
                                    'avatar-title rounded-circle font-size-24'
                                ])>
                                    {{@$groupingCode}}
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-8">
                        <div class="mb-4" style="margin-top: -2rem;">
                            <h3 class="text-truncate fw-semibold">
                                {{@$groupingName}}
                            </h3>
                            <p class="text-muted text-truncate">
                                กลุ่มที่ {{@$groupingTemp}} {{@$codloanName}}
                            </p>
                            <div class="progress progress-lg">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-info progressbar-subgroup" role="progressbar" style="width: {{$progressbar}}%;" aria-valuenow="{{$progressbar}}" aria-valuemin="0" aria-valuemax="100"><strong>{{$progressbar}}%</strong></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2">
                        <div class="pt-3">
                            <div class="col-12">
                                <h5 class="font-size-15 fw-semibold">{{$data->count()}}</h5>
                                <p class="text-muted mb-0">จำนวนงาน</p>
                            </div>
                        </div>
                    </div>

                    {{-- 
                    <div class="col-sm-4">
                        <div class="pt-3">

                            <div class="row">
                                <div class="col-6">
                                </div>
                                <div class="col-6">
                                    <h5 class="font-size-15 fw-semibold">{{$data->count()}}</h5>
                                    <p class="text-muted mb-0">จำนวนงาน</p>
                                </div>
                            </div>

                        </div>
                    </div>
                    --}}
                </div>
            </div>
        </div>

        <!-- หัวการ์ดแบบเล็ก -->
        <div class="card overflow-hidden m-0 shadow-none d-block d-md-block d-lg-none">
            <div @class(['bg-primary' => $groupingType == 'P',
                'bg-warning' => $groupingType == 'T',
                'bg-success' => $groupingType == 'L',
                'bg-soft'])>
                <div class="row">
                    <div class="col">
                        <div @class(['text-primary' => $groupingType == 'P',
                            'text-dark' => $groupingType == 'T',
                            'text-success' => $groupingType == 'L',
                            'p-3 fw-bold p-4'])>
                            <h4 @class(['text-primary' => $groupingType == 'P',
                                'text-dark' => $groupingType == 'T',
                                'text-success' => $groupingType == 'L',
                                'fw-semibold'])>{{@$title}}</h5>
                            <p>โซน {{@$zoneName}}</p>
                        </div>
                    </div>
                    <div class="col-auto me-3 mt-3">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
            </div>
            <div class="card-body pt-0 pb-1">
                <div class="row">
                    <div class="col-sm-2 col-lg-2 d-flex justify-content-center d-flex justify-content-center">
                        <div class="avatar-sm mb-4" style="margin-top: -30px;">
                            <span class="avatar-title rounded-circle bg-light border border-light border-3 shadow-lg">
                                <span @class([
                                    'bg-primary bg-opacity-25 text-primary' => $groupingType == 'P',
                                    'bg-warning bg-opacity-25 text-dark' => $groupingType == 'T',
                                    'bg-success bg-opacity-25 text-success' => $groupingType == 'L',
                                    'avatar-title rounded-circle font-size-14'
                                ])>
                                    {{@$groupingCode}}
                                </span>
                            </span>
                        </div>
                    </div>
                    <div class="col col-sm-8">
                        <div class="mb-4" style="margin-top: -2rem;">
                            <h3 class="text-truncate fw-semibold">
                                {{@$groupingName}}
                            </h3>
                            <p class="text-muted text-truncate">
                                กลุ่มที่ {{@$groupingTemp}} {{@$codloanName}}
                            </p>
                            <div class="progress progress-lg">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-info progressbar-subgroup" role="progressbar" style="width: {{$progressbar}}%;" aria-valuenow="{{$progressbar}}" aria-valuemin="0" aria-valuemax="100"><strong>{{$progressbar}}%</strong></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto col-sm-2">
                        <div class="pt-3">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="font-size-15 fw-semibold">{{$data->count()}}</h5>
                                    <p class="text-muted small mb-0">จำนวนงาน</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-body pt-0">

            <div class="row">

                <div class="col-12 col-xl-3">
                    <!-- เมนู หัวฟอร์ม -->
                    <div class="card shadow-none border border-primary border-opacity-50 rounded-3">
                        <div class="card-body text-primary">
                            <h4 class="card-title m-0">จัดกลุ่มย่อย (ถ้ามี)</h4>
                            <p class="card-title-desc m-0">สามารถแบ่งกลุ่มย่อย เพื่อมอบหมายงานแต่ละกลุ่มย่อยได้</p>

                            <div class="edit-assign-setsubgroup gap-3">
                                <div class="row row-cols-lg-2 row-cols-xl-1 g-3 align-items-center mt-xl-1">
                                    <div class="col-12 col-sm-6">
                                        <div class="input-bx">
                                            <select id="MODE" name="MODE" class="form-select" data-bs-toggle="tooltip" title="กลุ่มงาน" required>
                                                <option value="" selected>--- วิธีการแบ่งกลุ่ม ---</option>
                                                <option value="1">1. แบ่งตามจำนวน</option>
                                                <option value="2">2. แบ่งตามพนักงานขาย</option>
                                                <option value="3">3. แบ่งตามกลุ่มค้างงวด</option>
                                                <option value="4">4. แบ่งตามจังหวัด</option>
                                                <option value="5">5. แบ่งตามอำเภอ</option>
                                            </select>
                                            <span class="text-danger floating-label">วิธีการแบ่งกลุ่ม</span>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6">
                                        <div class="input-bx">
                                            <input type="number" id="AMOUNTSUB" name="AMOUNTSUB" min="1" class="form-control" data-bs-toggle="tooltip" title="จำนวนกลุ่ม" placeholder=" " readonly>
                                            <span class="floating-label"><i class="bx bx-label"></i> จำนวนกลุ่ม</span>
                                        </div>
                                    </div>

                                </div>

                                <div class="btn-group col-auto col-xl-12 ms-auto">
                                    <button type="button" class="btn btn-outline-primary waves-effect waves-light w-sm excuteGroupBtn" id="ExcuteSubGroup">
                                        <i class="mdi mdi-view-grid-outline d-block d-xl-inline-block font-size-16"></i>
                                        <span class="text-nowrap">จัดกลุ่ม</span>
                                    </button>
                                    <button type="button" class="btn btn-outline-primary dropdown-toggle dropdown-toggle-split excuteGroupBtn" data-bs-toggle="dropdown" aria-expanded="false" style="max-width: 2rem;">
                                        <i class="mdi mdi-chevron-down"></i>
                                        <span class="visually-hidden">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item excuteGroupBtn" id="ExcuteSubGroup-All" href="#">ทุกงาน</a></li>
                                        <li><a class="dropdown-item excuteGroupBtn" id="ExcuteSubGroup-Unassign" href="#">เฉพาะงานที่ยังไม่ได้มอบหมาย</a></li>
                                    </ul>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>

                <div class="col-12 col-xl-9">
                    <div class="container px-2" id="Results_Subgroup">

                        <!-- กลุ่มงานทั้งหมด สามารถบันทึกได้ทันที จะบันทึกแบบทั้งกลุ่ม -->
                        <div class="row align-items-end">
                            <div class="col-12 col-sm d-flex">
                                <a href="#collapseAssign_1" class="d-flex flex-row align-items-center flex-fill collapsed" data-bs-toggle="collapse" role="button">
                                    <span class="collapse-arrow-icon d-flex align-items-center me-2">
                                        <i class="bx bx-caret-down font-size-14"></i>
                                    </span>
                                    <span class="fw-bold font-size-12">
                                        งานทั้งหมด
                                    </span>
                                    <span class="fw-bold font-size-12 mx-2">
                                        ({{$data->count()}} รายการ)
                                    </span>
                                </a>
                            </div>
                            <div class="col-12 col-lg-6 row g-2 m-0 justify-content-end align-items-end">
                                <div class="col col-sm offset-3 m-0">
                                    <select class="form-select billcoll-select border-warning" id="AllPort_BILLCOLL" data-placeholder="กำหนดพนักงานเก็บเงิน" data-bs-toggle="tooltip" title="พนักงานเก็บเงิน" data-groupid="1">
                                        <option value="" selected>-- กำหนดพนักงานเก็บเงิน --</option>
                                        @foreach($billcoll as $i => $value)
                                            <option value="{{$i}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-auto m-0 mx-2">
                                    <button type="button" class="btn btn-outline-success btnSaveAllPort" data-groupid="1" data-grouptype="number">
                                        <i class="fas fa-save"></i> บันทึก <span class="addSpin"></span>
                                    </button>
                                </div>
                                
                            </div>
                        </div>
                        <hr class="border my-1">
                        <div class="collapse" id="collapseAssign_1">
                            <div class="overflow-auto mb-4" style="max-height: 10rem;">
                                <table class="table table-sm table-striped table-borderless m-0 text-center small text-nowrap table-subgroup">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>สาขา</th>
                                            <th>ประเภท</th>
                                            <th>เลขที่สัญญา</th>
                                            <th>ชื่อ-สกุล ลูกค้า</th>
                                            <th>ค้างจริง</th>
                                            <th>พนักงานเก็บเงิน</th>
                                            <th>พนักงานขาย</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(@$data as $key => $row)
                                            <tr>
                                                <th scope="row">{{@$key+1}}</th>
                                                <td>
                                                    <h6 class="m-0"><span class="badge text-bg-primary" data-bs-toggle="tooltip" data-bs-title="{{$row->branch_name}}">{{$row->branch_code}}</span></h6>
                                                </td>
                                                <td>
                                                    <h6 class="m-0"><span class="badge text-bg-dark" data-bs-toggle="tooltip" data-bs-title="{{$row->Loan_Name}}">{{@$row->TYPECONT}}</span></h6>
                                                </td>
                                                <td>{{@$row->CONTNO}}</td>
                                                <td>{{@$row->cus_name}}</td>
                                                <td>{{number_format(@$row->HLDNO,2)}}</td>
                                                <td>
                                                    @empty($row->billcoll_code)
                                                        -
                                                    @else
                                                        {{ $row->billcoll_code }}
                                                    @endempty
                                                </td>
                                                <td>{{@$row->sale_name}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
        
                    </div>
                </div>

            </div>


        </div>
        <div class="modal-footer mt-n3">
            <button type="button" class="btn btn-secondary btn-sm btnCloseModal" data-bs-dismiss="modal" aria-label="Close">
                <i class="fas fa-share"></i> ปิด
            </button>
        </div>
    </div>
</form>

<script src="{{ URL::asset('assets/js/input-bx-select.js') }}"></script>

{{--
<script type="text/javascript">
$(function() {
    $("#ExcuteGroup").on('click', function() {
        $('#showDataGroup').show();
        $('#showDataTable').hide();
    });
    $("#MODE").click( function() {
        let GetVal = $(this).val();
        if(GetVal == '1'){
            $('#GroupSub').slideDown();
        }
        else if(GetVal == '2'){
            $('#GroupSub').slideUp();
        }
    });
});
</script>
--}}

<script>

    $('[data-bs-toggle="tooltip"]').tooltip();

</script>

<!-- สคริปต์ปุ่มเมนู -->
<script>

    $("#MODE").click( function() {
        let GetVal = $(this).val();
        if(GetVal == '1') {
            $('#AMOUNTSUB').val('1');
            $('#AMOUNTSUB').removeAttr('readonly');
        } else {
            $('#AMOUNTSUB').val('');
            $('#AMOUNTSUB').attr('readonly', 'readonly');
        }
    });
    
    function ExcuteSubGroupFunction(all_port = true) {
        if ( $("#MODE").val() == 1 ) {  // แบ่งกลุ่มตาม จำนวน
            if ( $("#AMOUNTSUB").val() == "" ) {
                swal.fire({
                    icon : 'warning',
                    title : 'ข้อมูลไม่ครบ !',
                    text : 'กรุณากรอกข้อมูลให้ครบถ้วน',
                    timer: 2000,
                    showConfirmButton: false,
                })
                return;
            }
            if (all_port) {
                groupByNumber( Number( $("#AMOUNTSUB").val() ) );
            } else {
                groupByNumber_Unassign( Number( $("#AMOUNTSUB").val() ) );
            }
        } else if ( $("#MODE").val() == 2 ) {   // แบ่งกลุ่มตาม พนักงานขาย
            if (all_port) {
                groupBySaleCode();
            } else {
                groupBySaleCode_Unassign();
            }
        } else if ( $("#MODE").val() == 3 ) {   // แบ่งกลุ่มตาม กลุ่มค้างงวด
            //$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
            if (all_port) {
                groupByGroupPass();
            } else {
                groupByGroupPass_Unassign();
            }
            //$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
        } else if ( $("#MODE").val() == 4 ) {   // แบ่งกลุ่มตาม จังหวัด
            if (all_port) {
                groupByProvince(); // ADD_PROVINCE
            } else {
                groupByProvince_Unassign();
            }
        } else if ( $("#MODE").val() == 5 ) {   // แบ่งกลุ่มตาม อำเภอ
            if (all_port) {
                groupByDistrict(); // ADD_PROVINCE
            } else {
                groupByDistrict_Unassign();
            }
        } else {
            swal.fire({
                icon : 'warning',
                title : 'ข้อมูลไม่ครบ !',
                text : 'กรุณากรอกข้อมูลให้ครบถ้วน',
                timer: 2000,
                showConfirmButton: false,
            })
        }
    }

    $("#ExcuteSubGroup,#ExcuteSubGroup-All").on('click', function() {
        ExcuteSubGroupFunction(true);
    });

    $("#ExcuteSubGroup-Unassign").on('click', function() {
        ExcuteSubGroupFunction(false);
    });

</script>

<!-- สคริปต์สำหรับแบ่งกลุ่ม -->
<script>

    var all_port = @json($data);
    var billcoll = @json($billcoll);

    var grouped_port = [];
    // ตั้งค่าเริ่มต้น grouped_port
    grouped_port.push(all_port);

    var nf = new Intl.NumberFormat("th-TH", {
		minimumFractionDigits: 2,
		maximumFractionDigits: 2,
	});

    var dataArray_user = @json(@$dataArray_user);
    var dataArray_billcoll = @json(@$dataArray_billcoll);

    var locat = '{{@$locat}}';
    var salecode_array = [];
    var salecode_name = [];
    var grouppass_array = [];
    var addprovince_array = [];
    var adddistrict_array = []; // ADD_DISTRICT

    function groupByNumber( amount ) {
        grouped_port = [];
        for (let index = 0; index < amount; index++) {
            grouped_port.push( [] );
        }
        $.each( all_port, function( index, item ) {
            grouped_port[ index % amount ].push(item);
        });
        DrawSubgroupResults('number');
    }

    function groupByNumber_Unassign( amount ) {
        grouped_port = [];
        grouped_port.push( [] );
        //------------------------------------------------
        for (let index = 0; index < amount; index++) {
            grouped_port.push( [] );
        }
        //------------------------------------------------
        let all_port_notAssign = [];
        $.each( all_port, function( index, item ) {
            if ( item.FOLCODE == null ) {
                all_port_notAssign.push(item);
            } else {
                grouped_port[0].push(item);
            }
        });
        //------------------------------------------------
        $.each( all_port_notAssign, function( index, item ) {
            grouped_port[ (index % amount) + 1 ].push(item);
        });
        //------------------------------------------------
        DrawSubgroupResults('number', 'unassign');
    }
    
    function groupBySaleCode() {
        grouped_port = [];
        salecode_array = [];
        salecode_name = [];
        $.each( all_port, function( index, item ) {
            var salecode =  item.SALECOD;
            if ( salecode_array.indexOf(salecode) < 0 ) { // เป็นจริง ถ้าเกิด salecode ยังไม่มีใน อาร์เรย์ grouped_port
                grouped_port.push( [] );
                salecode_array.push(item.SALECOD);
                salecode_name.push(item.sale_name);
            }
            grouped_port[ salecode_array.indexOf(salecode) ].push(item);
        });
        DrawSubgroupResults('salecode');
    }

    function groupBySaleCode_Unassign() {
        grouped_port = [];
        salecode_array = [];
        salecode_name = [];
        //------------------------------------------------
        grouped_port.push( [] );
        salecode_array.push( '' );
        salecode_name.push( '' );
        let all_port_notAssign = [];
        $.each( all_port, function( index, item ) {
            if ( item.FOLCODE == null ) {
                all_port_notAssign.push(item);
            } else {
                grouped_port[0].push(item);
            }
        });
        //------------------------------------------------
        $.each( all_port_notAssign, function( index, item ) {
            var salecode =  item.SALECOD;
            if ( salecode_array.indexOf(salecode) < 0 ) { // เป็นจริง ถ้าเกิด salecode ยังไม่มีใน อาร์เรย์ grouped_port
                grouped_port.push( [] );
                salecode_array.push(item.SALECOD);
                salecode_name.push(item.sale_name);
            }
            grouped_port[ salecode_array.indexOf(salecode) ].push(item);
        });
        //------------------------------------------------
        DrawSubgroupResults('salecode', 'unassign');
    }

    function groupByGroupPass() {
        // GroupPass = SWEXPPRD
        grouped_port = [];
        grouppass_array = [];
        //----------------------------------------------
        var cloned_all_port = [...all_port];
        //----------------------------------------------
        cloned_all_port = cloned_all_port.map(item => {
            if (item.SWEXPPRD === null || item.SWEXPPRD === undefined) {
                return { ...item, SWEXPPRD: " " };
            }
            return item;
        });
        //----------------------------------------------
        cloned_all_port.sort((a, b) => a.SWEXPPRD.localeCompare(b.SWEXPPRD));
        $.each( cloned_all_port, function( index, item ) {
            var grouppass =  item.SWEXPPRD;
            if ( grouppass_array.indexOf(grouppass) < 0 ) { // เป็นจริง ถ้าเกิด salecode ยังไม่มีใน อาร์เรย์ grouped_port
                grouped_port.push( [] );
                grouppass_array.push(item.SWEXPPRD);
            }
            grouped_port[ grouppass_array.indexOf(grouppass) ].push(item);
        });
        DrawSubgroupResults('grouppass');
    }

    function groupByGroupPass_Unassign() {
        grouped_port = [];
        grouppass_array = [];
        //------------------------------------------------
        grouped_port.push( [] );
        grouppass_array.push( '' );
        let all_port_notAssign = [];
        $.each( all_port, function( index, item ) {
            if ( item.FOLCODE == null ) {
                all_port_notAssign.push(item);
            } else {
                grouped_port[0].push(item);
            }
        });
        //------------------------------------------------
        all_port_notAssign = all_port_notAssign.map(item => {
            if (item.SWEXPPRD === null || item.SWEXPPRD === undefined) {
                return { ...item, SWEXPPRD: " " };
            }
            return item;
        });
        //----------------------------------------------
        all_port_notAssign.sort((a, b) => a.SWEXPPRD.localeCompare(b.SWEXPPRD));
        $.each( all_port_notAssign, function( index, item ) {
            var grouppass =  item.SWEXPPRD;
            if ( grouppass_array.indexOf(grouppass) < 0 ) { // เป็นจริง ถ้าเกิด salecode ยังไม่มีใน อาร์เรย์ grouped_port
                grouped_port.push( [] );
                grouppass_array.push(item.SWEXPPRD);
            }
            grouped_port[ grouppass_array.indexOf(grouppass) ].push(item);
        });
        //------------------------------------------------
        DrawSubgroupResults('grouppass', 'unassign');
    }

    // ADD_PROVINCE
    function groupByProvince() {
        // GroupPass = SWEXPPRD
        grouped_port = [];
        addprovince_array = [];
        //----------------------------------------------
        var cloned_all_port = [...all_port];
        cloned_all_port.sort((a, b) => a.ADD_PROVINCE.localeCompare(b.ADD_PROVINCE));
        $.each( cloned_all_port, function( index, item ) {
            var province =  item.ADD_PROVINCE;
            if ( addprovince_array.indexOf(province) < 0 ) { // เป็นจริง ถ้าเกิด salecode ยังไม่มีใน อาร์เรย์ grouped_port
                grouped_port.push( [] );
                addprovince_array.push(item.ADD_PROVINCE);
            }
            grouped_port[ addprovince_array.indexOf(province) ].push(item);
        });
        DrawSubgroupResults('province');
    }

    function groupByProvince_Unassign() {
        grouped_port = [];
        addprovince_array = [];
        //------------------------------------------------
        grouped_port.push( [] );
        addprovince_array.push( '' );
        let all_port_notAssign = [];
        $.each( all_port, function( index, item ) {
            if ( item.FOLCODE == null ) {
                all_port_notAssign.push(item);
            } else {
                grouped_port[0].push(item);
            }
        });
        //------------------------------------------------
        all_port_notAssign.sort((a, b) => a.ADD_PROVINCE.localeCompare(b.ADD_PROVINCE));
        $.each( all_port_notAssign, function( index, item ) {
            var province =  item.ADD_PROVINCE;
            if ( addprovince_array.indexOf(province) < 0 ) { // เป็นจริง ถ้าเกิด salecode ยังไม่มีใน อาร์เรย์ grouped_port
                grouped_port.push( [] );
                addprovince_array.push(item.ADD_PROVINCE);
            }
            grouped_port[ addprovince_array.indexOf(province) ].push(item);
        });
        //------------------------------------------------
        DrawSubgroupResults('province', 'unassign');
    }

    // ADD_DISTRICT
    function groupByDistrict() {
        // GroupPass = SWEXPPRD
        grouped_port = [];
        adddistrict_array = [];
        //----------------------------------------------
        var cloned_all_port = [...all_port];
        cloned_all_port.sort((a, b) => a.ADD_DISTRICT.localeCompare(b.ADD_DISTRICT));
        $.each( cloned_all_port, function( index, item ) {
            var district =  item.ADD_DISTRICT;
            if ( adddistrict_array.indexOf(district) < 0 ) { // เป็นจริง ถ้าเกิด ADD_DISTRICT ยังไม่มีใน อาร์เรย์ grouped_port
                grouped_port.push( [] );
                adddistrict_array.push(item.ADD_DISTRICT);
            }
            grouped_port[ adddistrict_array.indexOf(district) ].push(item);
        });
        DrawSubgroupResults('district');
    }

    function groupByDistrict_Unassign() {
        grouped_port = [];
        adddistrict_array = [];
        //------------------------------------------------
        grouped_port.push( [] );
        adddistrict_array.push( '' );
        let all_port_notAssign = [];
        $.each( all_port, function( index, item ) {
            if ( item.FOLCODE == null ) {
                all_port_notAssign.push(item);
            } else {
                grouped_port[0].push(item);
            }
        });
        //------------------------------------------------
        all_port_notAssign.sort((a, b) => a.ADD_DISTRICT.localeCompare(b.ADD_DISTRICT));
        $.each( all_port_notAssign, function( index, item ) {
            var district =  item.ADD_DISTRICT;
            if ( adddistrict_array.indexOf(district) < 0 ) { // เป็นจริง ถ้าเกิด ADD_DISTRICT ยังไม่มีใน อาร์เรย์ grouped_port
                grouped_port.push( [] );
                adddistrict_array.push(item.ADD_DISTRICT);
            }
            grouped_port[ adddistrict_array.indexOf(district) ].push(item);
        });
        //------------------------------------------------
        DrawSubgroupResults('district', 'unassign');
    }

    function DrawSubgroupResults(groupType, unassign = null) {
        // Results_Subgroup
        $("#Results_Subgroup").empty();

        // วน Loop แสดงข้อมูลแต่ละกลุ่ม
        $.each( grouped_port, function( index, item ) {

            let header_grouped_text = "";
            let saleCode_data = "";
            let groupPass_data = "";
            let addProvince_data = "";
            let addDistrict_data = "";
            if ( ( unassign != null && unassign == 'unassign' ) && index == 0) {
                // Head unassign
                header_grouped_text = "งานที่ถูกมอบหมายแล้ว";
            } else {
                if (groupType == 'number') {
                    header_grouped_text = `กลุ่มที่ถูกแบ่งที่ ${index+1}`;
                    //----------------------------------
                    if ( unassign != null && unassign == 'unassign' ) {
                        header_grouped_text = `กลุ่มที่ถูกแบ่งที่ ${index}`;
                    }
                }
                if (groupType == 'salecode') {
                    header_grouped_text = `${salecode_name[index]}`;
                    saleCode_data = `data-salecode="${salecode_array[index]}"`;
                }
                if (groupType == 'grouppass') {
                    header_grouped_text = `${grouppass_array[index]}`;
                    groupPass_data = `data-grouppass="${grouppass_array[index]}"`;
                }
                if (groupType == 'province') {
                    header_grouped_text = `${addprovince_array[index]}`;
                    addProvince_data = `data-province="${addprovince_array[index]}"`;
                }
                if (groupType == 'district') {
                    header_grouped_text = `${adddistrict_array[index]}`;
                    addDistrict_data = `data-district="${adddistrict_array[index]}"`;
                }
            }
            //----------------------------------------------------------
            var new_div = $('<div class="row align-items-end">');
            //----------------------------------------------------------
            var a_container = $('<div class="col-12 col-sm d-flex">');
            var a_tag = $(`<a href="#collapseAssign_${index+1}" class="d-flex flex-row align-items-center flex-fill collapsed" data-bs-toggle="collapse" role="button">`);
            
            var a_icon = $('<span class="collapse-arrow-icon d-flex align-items-center me-2"><i class="bx bx-caret-down font-size-14"></i></span>');
            var a_name = $(`<span class="fw-bold font-size-12">${header_grouped_text}</span>`);
            var a_size = $(`<span class="fw-bold font-size-12 mx-2">(${item.length} รายการ)</span>`);

            a_tag.append(a_icon);
            a_tag.append(a_name);
            a_tag.append(a_size);
            a_container.append(a_tag);
            new_div.append(a_container);
            //----------------------------------------------------------
            if ( ( unassign != null && unassign == 'unassign' ) && index == 0) {
                // Head unassign
            } else {
                var form_container = $('<div class="col-12 col-lg-6 row g-2 m-0 justify-content-end align-items-end">');
                var select_container = $('<div class="col col-sm offset-3 m-0">');
                var button_container = $('<div class="col-auto m-0 mx-2">');
                var select_tag = $(`<select class="form-select billcoll-select border-warning" id="G_${index+1}_BILLCOLL" data-placeholder="กำหนดพนักงานเก็บเงิน" data-bs-toggle="tooltip" title="พนักงานเก็บเงิน" data-groupid="${index+1}">`);
                var option_tag = $(`<option value="" selected>-- กำหนดพนักงานเก็บเงิน --</option>`);
                select_tag.append(option_tag);
                Object.entries(billcoll).sort((a, b) => a[1].localeCompare(b[1])).forEach(([key, value]) => {
                    select_tag.append(`<option value="${key}">${value}</option>`);
                });
                select_container.append(select_tag);

                var button_tag = $(`<button type="button" class="btn btn-outline-success btnSaveSubGroup" data-groupid="${index+1}" data-grouptype="${groupType}" ${saleCode_data}${groupPass_data}${addProvince_data}${addDistrict_data}><i class="fas fa-save"></i> บันทึก <span class="addSpin"></span></button>`);
                button_container.append(button_tag);

                form_container.append(select_container);
                form_container.append(button_container);
                new_div.append(form_container);
            }
            //----------------------------------------------------------
            var hr_tag = $(`<hr class="border my-1">`);
            //----------------------------------------------------------
            var collapse_div = $(`<div class="collapse" id="collapseAssign_${index+1}">`);
            var overflow_div = $(`<div class="overflow-auto mb-4" style="max-height: 10rem;">`);
            var subTable = DrawSubGroupedTable(item);
            overflow_div.append(subTable);
            collapse_div.append(overflow_div);
            //----------------------------------------------------------
            $("#Results_Subgroup").append(new_div);
            $("#Results_Subgroup").append(hr_tag);
            $("#Results_Subgroup").append(collapse_div);

        });

        // ใส่คำสั่งให้ปุ่มเซฟ
        BindSaveFunctiontoBtn("btnSaveSubGroup");

        // ทำให้ Tooltip ทำงาน
        $('[data-bs-toggle="tooltip"]').tooltip();

    }

    function DrawSubGroupedTable(item) {
        var table = $(`<table class="table table-sm table-striped table-borderless m-0 text-center small text-nowrap table-subgroup">`);
        var thead = $(`<thead class="table-light">`);
            var thead_tr = $("<tr>");
                thead_tr.append("<th>#</th>");
                thead_tr.append("<th>สาขา</th>");
                thead_tr.append("<th>ประเภท</th>");
                thead_tr.append("<th>เลขที่สัญญา</th>");
                thead_tr.append("<th>ชื่อ-สกุล ลูกค้า</th>");
                thead_tr.append("<th>ค้างจริง</th>");
                thead_tr.append("<th>พนักงานเก็บเงิน</th>");
                thead_tr.append("<th>พนักงานขาย</th>");
            thead.append(thead_tr);
        var tbody = $(`<tbody>`);
            item.forEach((element,index) => {
                var tbody_tr = $("<tr>");
                    tbody_tr.append(`<th>${index+1}</th>`);
                    tbody_tr.append(`<td><h6 class="m-0"><span class="badge text-bg-primary" data-bs-toggle="tooltip" data-bs-title="${element.branch_name}">${element.branch_code}</span></h6></td>`);
                    tbody_tr.append(`<td><h6 class="m-0"><span class="badge text-bg-dark" data-bs-toggle="tooltip" data-bs-title="${element.Loan_Name}">${element.TYPECONT}</span></h6></td>`);
                    tbody_tr.append(`<td>${element.CONTNO}</td>`);
                    tbody_tr.append(`<td>${element.cus_name}</td>`);
                    tbody_tr.append(`<td>${nf.format(element.HLDNO)}</td>`);
                    if (element.billcoll_code != null) {
                        tbody_tr.append(`<td>${element.billcoll_code}</td>`);
                    } else {
                        tbody_tr.append(`<td>-</td>`);
                    }
                    tbody_tr.append(`<td>${element.sale_name}</td>`);
                tbody.append(tbody_tr);
            });
        table.append(thead);
        table.append(tbody);
        return table;
    }

    function BindSaveFunctiontoBtn(className) {
        $(`.${className}`).click( function() {
            var clickedBtn = $(this);
            var group_id = clickedBtn.data('groupid');
            var group_type = clickedBtn.data('grouptype');

            var select_billcoll = $(`#G_${group_id}_BILLCOLL`).val();

            console.log( select_billcoll );

            if (select_billcoll == '') {
                Swal.fire({
                    title: "กรุณาตรวจสอบ",
                    icon: "warning",
                    text: `กรุณาเลือกพนักงานเก็บเงินของกลุ่มที่ ${group_id}`,
                    confirmButtonText: 'เข้าใจแล้ว',
                });
                return;
            }

            ProcessSaveGroupBtn(clickedBtn, group_id, select_billcoll);

        });
    }

    function ProcessSaveGroupBtn(clickedBtn, group_id, select_billcoll) {
        // ล็อคทุกปุ่ม
        DisableAllButton(clickedBtn);
        //
        var update_spast_id = [];
        $.each( grouped_port[group_id - 1], function( index, item ) {
            update_spast_id.push( item.spast_id );
        });
        console.log( update_spast_id );
        // ส่ง ajax
        $.ajax({
            url: "{{ route('spast.update', 0 ) }}",
            method: "PUT",
            data: {
                _token:'{{ csrf_token() }}',
                page: 'group',
                mode: '{{$_type}}',
                flag: 'id',
                data: {
                    CODLOAN: '{{@$CODLOAN}}',
                    BILLCOLL: select_billcoll,
                    A_SPASTID: update_spast_id,
                },
            },
            complete: function(data) {
                ReturnActiveButton(clickedBtn); // ปลดล็อคปุ่ม
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
                UpdateGroup( group_id, select_billcoll);
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

    function DisableAllButton(clickedBtn) {
        $('<span />', {
			class: "spinner-border spinner-border-sm",
			role: "status"
		}).appendTo( $(clickedBtn).find(".addSpin") );
        //------------------------------------------------
        $('#MODE').attr('disabled',true);
        $('#AMOUNTSUB').attr('disabled',true);
        $('.excuteGroupBtn').attr('disabled',true);
        //------------------------------------------------
        $("#modal_xl_2 .btn-close,.btnCloseModal").attr('disabled',true);
        //------------------------------------------------
        $('.billcoll-select').each(function() {
            $(this).attr('disabled',true);
        });
        $('.btnSaveSubGroup,.btnSaveAllPort').each(function() {
            $(this).attr('disabled',true);
        });
        //------------------------------------------------
        //$('#saveAllGroupBtn').attr('disabled',true);
    }

    function ReturnActiveButton(clickedBtn) {
        $(clickedBtn).find(".addSpin").empty();
        ////------------------------------------------------
        $('#MODE').attr('disabled',false);
        $('#AMOUNTSUB').attr('disabled',false);
        $('.excuteGroupBtn').attr('disabled',false);
        //------------------------------------------------
        $("#modal_xl_2 .btn-close,.btnCloseModal").attr('disabled',false);
        //------------------------------------------------
        $('.billcoll-select').each(function() {
            $(this).attr('disabled',false);
        });
        $('.btnSaveSubGroup,.btnSaveAllPort').each(function() {
            $(this).attr('disabled',false);
        });
        //------------------------------------------------
        //$('#saveAllGroupBtn').attr('disabled',false);
    }

    /*
    $(document).ready(function() {

        $( '#single-select-clear-field' ).select2( {
            theme: "bootstrap-5",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            allowClear: true
        } );

    });
    */

    function SaveAllGroupBtnClicked() {
        // ล็อคทุกปุ่ม
        //DisableAllButton(clickedBtn);

        // คำสั่งบันทึกทุกกลุ่ม

        //ReturnActiveButton(clickedBtn); // ปลดล็อคปุ่ม
    }

    function UpdateGroup(groupId, newBillcoll_value) {
        var target_grouped = grouped_port[ groupId - 1 ];

        // อัพเดตค่าของ port ใหม่่
        $.each( target_grouped, function( index, item ) {
            item.FOLCODE = newBillcoll_value;
            item.BILLCOLL = newBillcoll_value;
            item.billcoll_name = billcoll[newBillcoll_value];
            var port = all_port.find((element) => element.spast_id == item.spast_id);
            port.FOLCODE = newBillcoll_value;
            port.BILLCOLL = newBillcoll_value;
            port.billcoll_name = billcoll[newBillcoll_value];
        });

        // อัพเดตตารางใหม่
        var table_container = $(`#collapseAssign_${groupId} .overflow-auto`);
        table_container.empty();
        var subTable = DrawSubGroupedTable(target_grouped);
        table_container.append(subTable);

        // อัพเดตแถบความคืบหน้า
        let totalPorts = all_port.length;
        let nonNullFolCodeCount = all_port.filter(obj => obj.FOLCODE !== null).length;
        let progressPercentage = (nonNullFolCodeCount / totalPorts) * 100;
        let roundedDownProgressPercentage = Math.floor(progressPercentage);
        //console.log(`Progress: ${roundedDownProgressPercentage}%`);
        
        // อัพเดต progress bar
        $(".progressbar-subgroup").css('width', roundedDownProgressPercentage + '%')
                                .attr('aria-valuenow', roundedDownProgressPercentage)
                                .find('strong').text(roundedDownProgressPercentage + '%');
        
    }

    //BineSaveFunctiontoBtn("btnSaveAllPort");
    $(`.btnSaveAllPort`).click( function() {
        var clickedBtn = $(this);

        var select_billcoll = $(`#AllPort_BILLCOLL`).val();

        if (select_billcoll == '') {
            Swal.fire({
                title: "กรุณาตรวจสอบ",
                icon: "warning",
                text: `กรุณาเลือกพนักงานเก็บเงินก่อน`,
                confirmButtonText: 'เข้าใจแล้ว',
            });
            return;
        }

        //ProcessSaveGroupBtn(clickedBtn, group_id, select_billcoll);
        // ล็อคทุกปุ่ม
        DisableAllButton(clickedBtn);
        //

        // ส่ง ajax
        $.ajax({
            url: "{{ route('spast.update', $groupingTemp ) }}",
            method: "PUT",
            data: {
                _token:'{{ csrf_token() }}',
                page: 'group',
                mode: '{{$_type}}',
                flag: 'all',
                data: {
                    CODLOAN: '{{@$CODLOAN}}',
                    BILLCOLL: select_billcoll,
                },
            },
            complete: function(data) {
                ReturnActiveButton(clickedBtn); // ปลดล็อคปุ่ม
            },
            success: function(result) {
                //-----------------------------------------
                $("#{{$_type}}-tabContent").html(result.html);
                UpdateGroup( 1, select_billcoll);
                //-----------------------------------------
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ!',
                    text: result.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    // เนื่องจากเป็นการอัพเดตทั้งหมด จึงปิด Modal หลังจากบันทึก
                    $('#modal_xl_2').modal('hide');
                });
                //-----------------------------------------
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

    });

</script>
