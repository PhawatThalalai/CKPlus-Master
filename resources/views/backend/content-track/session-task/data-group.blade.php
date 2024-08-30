{{-- 
<style>
    .form-floating {
        position: relative;
        display: flex;
        width: 100%;
        font-size: 12px;
    }

    .input-bx {
        position: relative;
        display: flex;
        width: 100%;
    }

    .input-bx input {
        width: 100%;
        padding: 7px;
        border: 1px solid #cacfd6;
        border-radius: 4px;
        outline: none;
        transition: 0.4s;
    }

    .input-bx span {
        position: absolute;
        left: 0;
        padding: 10px;
        font-size: 12px;
        color: #7f8fa6;
        text-transform: uppercase;
        pointer-events: none;
        transition: 0.4s;
    }

    .input-bx input:valid~span,
    .input-bx input:focus~span {
        /* color: #3742fa; */
        transform: translateX(10px) translateY(-7px);
        font-size: 0.65rem;
        font-weight: 600;
        padding: 0 10px;
        background: #fff;
        letter-spacing: 0.1rem;
    }
    
    .BtnStatus{
        padding: 10px 25px 10px 25px;
    }
</style>
--}}

<style>
    .toggleTable_Btn {
        transition: transform 0.2s ease-in-out;
    }
    .toggleTable_Btn.toggleTable_Show {
        transform: rotate(180deg);
    }
    /* Set a fixed height for the tbody and enable scrolling */
    .table-group-container {
        max-height: 15rem; /* Adjust this value as needed */
        overflow-y: scroll;
    }
    .table-group-header {
        position:sticky;
        top: 0 ;
    }

    .modal-content { overflow: visible !important; }

    #GroupTable {
        max-height: 40rem;
        overflow-y: scroll;
    }

    #GroupTable table thead th {
        position: sticky;
        top: 0; /* Don't forget this, required for the stickiness */
    }

</style>

<style>
    /* ไอคอน ประกันหมดอายุ */
    .notification-icon-xs {
        height: 1rem;
        width: 1rem;
    }
</style>



<form name="FormAddData" id="FormAddData" action="{{ route('datatrack.update',0) }}" method="post" enctype="multipart/form-data" novalidate style="font-family: 'Prompt', sans-serif;">
  @csrf
  @method('put')
  <input type="hidden" name="type" value="2">
  <input type="hidden" name="TYPECONT" value="{{@$TYPECONT}}">
  <input type="hidden" name="LOCAT" value="{{@$locat}}">
  
    <div class="modal-content">
        <div class="d-flex m-3 mb-0">
            <div class="flex-shrink-0 me-2">
                <img src="{{ asset('assets/images/gif/load-balancer.gif') }}" alt="" class="avatar-sm">
            </div>
            <div class="flex-grow-1 overflow-hidden">
                <h4 class="text-primary fw-semibold">มอบหมายงาน</h4>
                <p class="text-muted mt-n1">({{@$locat_index}}) สาขา{{$branch->Name_Branch}}</p>
                <p class="border-primary border-bottom mt-n2"></p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body pt-0">

            <div class="row">
                <div class="col-12 px-3">
                    <div class="card col-12 m-0 bg-info bg-soft">
                        <div class="row col row-cols-lg-auto g-3 align-items-center my-1 mb-4 mx-1">
                            <div class="col-12">
                                <div class="input-bx">
                                    <select id="MODE" name="MODE" class="form-select" data-bs-toggle="tooltip" title="กลุ่มงาน" required>
                                        <option value="" selected>--- เลือกกลุ่มงาน ---</option>
                                        <option value="1">1. แบ่งตามจำนวน</option>
                                        <option value="2">2. แบ่งตามพนักงานขาย</option>
                                    </select>
                                    <span class="text-danger floating-label">กลุ่มงาน</span>
                                </div>
                            </div>
        
                            <div class="col-12" id="GroupSub" style="display:none;">
                                <div class="input-bx">
                                    <input type="number" id="AMOUNTSUB" name="AMOUNTSUB" min="1" class="form-control" data-bs-toggle="tooltip" title="จำนวนกลุ่ม" placeholder=" " required>
                                    <span class="floating-label"><i class="bx bx-label"></i> จำนวนกลุ่ม</span>
                                </div>
                            </div>
                          
                            <div class="col-12">
                                <div class="form-check pb-2">
                                    <input class="form-check-input" type="radio" name="typeOfGrouping" id="GroupAll_CheckBox" checked>
                                    <label class="form-check-label" for="GroupAll_CheckBox">
                                        แบ่งกลุ่ม ทุกงาน (ค่าเริ่มต้น)
                                    </label>
                                    <i class="fas fa-question-circle text-info" data-bs-toggle="tooltip" title="นำทุกงานมาแบ่งกลุ่ม โดยไม่สนว่าเป็นงานที่มอบหมายไปแล้วหรือไม่ ใช้สำหรับการแบ่งงานครั้งแรกหรือการแบ่งงานใหม่อีกครั้ง"></i>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="typeOfGrouping" id="GroupOnlyUnGroup_CheckBox">
                                    <label class="form-check-label" for="GroupOnlyUnGroup_CheckBox">
                                        แบ่งกลุ่ม เฉพาะงานที่ยังไม่ได้มอบหมาย
                                    </label>
                                </div>
                                {{-- 
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="GroupAllCheckBox" checked>
                                    <label class="form-check-label" for="GroupAllCheckBox">
                                        แบ่งงานใหม่ทั้งหมด 
                                    </label>
                                </div>
                                --}}
                            </div>

                            <div class="col-12 mt-1">
                                <button type="button" id="ExcuteGroup" class="btn btn-primary waves-effect waves-light w-sm">
                                    <i class="bx bx-grid-alt align-middle d-block font-size-16"></i> แบ่งกลุ่ม
                                </button>
                            </div>

                        </div>
                        <p class="text-dark m-0" style="position: absolute; right: 1rem; bottom: 0.25rem;">รายการทั้งหมด <strong>{{@$COUNT}}</strong> งาน</p>
                    </div>
                </div>

                <div class="mb-3 mt-2 pe-0" id="GroupTable">
                    <table class="table table-striped m-0 table-group text-center">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>เลขที่สัญญา</th>
                                <th>ชื่อ-สกุล ลูกค้า</th>
                                <th>สาขาที่ตาม</th>
                                <th>เจ้าหน้าที่ติดตาม</th>
                                <th>สถานะ</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(@$data as $key => $row)
                                <tr>
                                    <th scope="row">{{@$key+1}}</th>
                                    <td class="text-start">{{@$row->Contno}}</td>
                                    <td class="text-start">{{@$row->Name_Cus}}</td>
                                    <td>
                                        @if( empty($row->BillCollName) )
                                            -
                                        @else
                                            {{@$row->BillCollName}}
                                        @endif
                                    </td>
                                    <td>
                                        @if( empty($row->FolName) )
                                            -
                                        @else
                                            {{@$row->FolName}}
                                        @endif
                                    </td>
                                    <td>{{@$row->ContStat}}</td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            {{-- 
            <div class="row">
                <div class="col-md-12 col-lg-4">
                    <div class="card border" data-simplebar="init" style="max-height: 500px;">
                        <div class="card-body">
                        <a href="#!" class="px-3 py-2 rounded bg-light bg-opacity-50 d-block mb-1">รายการทั้งหมด <span class="badge text-bg-info float-end bg-opacity-100">{{@$COUNT}}</span></a>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-8">
                    <div class="card border" data-simplebar="init" style="max-height: 500px;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-5 col-md-5">
                                    <div class="form-floating">
                                        <select id="MODE" name="MODE" class="form-select" required>
                                            <option value="">- เลือกกลุ่มงาน -</option>
                                            <option value="1">1. กำหนดกลุ่มเอง</option>
                                            <option value="2">2. ตาม SALECOD</option>
                                        </select>
                                        <label for="floatingnameInput"><strong><i class="bx bx-label"></i> กลุ่มงาน</strong></label>
                                    </div>
                                </div>
                                <div class="col-5 col-md-5">
                                    <div class="form-floating" id="GroupSub" style="display:none;">
                                        <input type="number" id="AMOUNTSUB" name="AMOUNTSUB" class="form-control" placeholder="จำนวนกลุ่ม" required>
                                        <label for="floatingnameInput"><strong><i class="bx bx-label"></i> จำนวนกลุ่ม</strong></label>
                                    </div>
                                    <div class="form-floating" id="GroupTemp">
                                        <input type="number" class="form-control" placeholder="จำนวนกลุ่ม" readonly>
                                    </div>
                                </div>
                                <div class="col-2 col-md-2">
                                    <div class="input-bx">
                                        <button type="button" id="ExcuteGroup" class="btn btn-primary waves-effect">
                                            <i class="bx bx-hourglass bx-spin font-size-14 align-middle"></i> ประมวล
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12 mt-n3">
                    <div class="card border" data-simplebar="init" style="max-height: 300px;">
                        <div class="card-body">
                            <div id="showDataTable">
                                <table class="table m-0 table-group">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>CONTNO</th>
                                            <th>NAME</th>
                                            <th>BILLCOLL</th>
                                            <th>SALECOD</th>
                                            <th>CONSTAT</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(@$data as $key => $row)
                                            <tr>
                                                <th scope="row">{{@$key+1}}</th>
                                                <td>{{@$row->CONTNO}}</td>
                                                <td>{{@$row->ToContract->PatchToPact->ContractToCus->Name_Cus}}</td>
                                                <td>{{@$row->BILLCOLL}}</td>
                                                <td>{{@$row->SALECOD}}</td>
                                                <td>{{@$row->CONTSTAT}}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div id="showDataGroup" style="display:none;">
                                <div class="row mb-3">
                                        @for ($i = 0; $i < 3; $i++)
                                            <div class="col-lg-4">
                                                <div class="card task-box border border-secondary" id="cmptask-1">
                                                    <div class="card-body">
                                                        <div class="dropdown float-end">
                                                            <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                                                            </a>
                                                            <div class="dropdown-menu dropdown-menu-end">
                                                                <a class="dropdown-item edittask-details Modal-xl" data-bs-toggle="modal" data-bs-target="#Modal-xl" data-link="{{ route('datatrack.edit', 98) }}?type={{4}}&TYPECONT={{@$TYPECONT}}&GROUP={{@$GROUP}}&LAYER={{2}}&GroupNo={{$i+1}}" style="cursor:pointer;">
                                                                    <i class="bx bx-log-in text-primary"></i> มอบหมายงาน
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <div class="float-end">
                                                            <span class="badge rounded-pill badge-soft-warning font-size-12" id="task-status">Wait</span><br>
                                                        </div>
                                                        <div>
                                                            <h5 class="font-size-15 card-title">
                                                                <a href="javascript: void(0);" class="text-dark" id="task-name">
                                                                    กลุ่มงานที่ {{$i+1}}
                                                                </a>
                                                            </h5>
                                                            <div class="row">
                                                                <div class="text-muted mt-4">
                                                                    <h4 class="mb-2"><i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>
                                                                    <div class>
                                                                        <div class="progress">
                                                                            <div class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-footer">
                                                        <small class="text-muted float-start">
                                                            จำนวน: {{50}} ราย.
                                                        </small>
                                                        <small class="text-muted float-end">
                                                            BILLCOLL: ....
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            --}}
        </div>
        <div class="modal-footer mt-n3">
            <button type="button" id="saveAllGroupBtn" class="btn btn-primary">
                <i class="bx bx-save"></i> บันทึกทั้งหมด
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
    $("#ExcuteGroup").on('click', function() {
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
            if ( $("#AMOUNTSUB").val() <= 0 ) {
                swal.fire({
                    icon : 'warning',
                    title : 'ข้อมูลไม่ถูกต้อง !',
                    text : 'กรุณากรอกตัวเลขที่ถูกต้อง',
                    timer: 2000,
                    showConfirmButton: false,
                })
                return;
            }
            //------------------------------------------------
            if ( $('#GroupAll_CheckBox').is(':checked') ) {
                groupByNumber( Number( $("#AMOUNTSUB").val() ) );
            }
            if ( $('#GroupOnlyUnGroup_CheckBox').is(':checked') ) {
                groupByNumber_Unassign( Number( $("#AMOUNTSUB").val() ) );
            }
            //------------------------------------------------
        } else if ( $("#MODE").val() == 2 ) {   // แบ่งกลุ่มตาม พนักงานขาย
            //------------------------------------------------
            if ( $('#GroupAll_CheckBox').is(':checked') ) {
                groupBySaleCode();
            }
            if ( $('#GroupOnlyUnGroup_CheckBox').is(':checked') ) {
                groupBySaleCode_Unassign();
            }
            //------------------------------------------------
        } else {
            swal.fire({
                icon : 'warning',
                title : 'ข้อมูลไม่ครบ !',
                text : 'กรุณากรอกข้อมูลให้ครบถ้วน',
                timer: 2000,
                showConfirmButton: false,
            })
        }
    });

    $("#MODE").click( function() {
        let GetVal = $(this).val();
        if(GetVal == '1'){
            $('#GroupSub').slideDown();
        } else {
            $('#GroupSub').slideUp();
        }
    });

</script>

<!-- สคริปต์สำหรับแบ่งกลุ่ม -->
<script>

    var all_port = @json($data);
    
    /*
    all_port.forEach(element => {
        all_port.push(element);
    });
    all_port.forEach(element => {
        all_port.push(element);
    });
    all_port.forEach(element => {
        all_port.push(element);
    });
    all_port.forEach(element => {
        all_port.push(element);
    });
    all_port.forEach(element => {
        all_port.push(element);
    });
    all_port.forEach(element => {
        all_port.push(element);
    });
    */

    var grouped_port = [];

    var dataArray_user = @json($dataArray_user);
    var dataArray_billcoll = @json($dataArray_billcoll);

    var locat = '{{@$locat}}';
    var salecode_array = [];
    var salecode_name = [];
    
    function groupByNumber( amount ) {
        grouped_port = [];
        for (let index = 0; index < amount; index++) {
            grouped_port.push( [] );
        }
        $.each( all_port, function( index, item ) {
            grouped_port[ index % amount ].push(item);
        });
        DrawGroupedTable('number');
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
            if ( item.BillColl == locat && item.FolCode == null ) {
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
        DrawGroupedTable('number', 'unassign');
    }

    function DrawGroupedTable(groupType, unassign = null) {
        $("#GroupTable tbody").empty();

        $.each( grouped_port, function( index, item ) {

            let header_grouped_text = "";
            let saleCode_data = "";
            if (groupType == 'number') {
                header_grouped_text = `กลุ่มที่ถูกแบ่งที่ ${index+1} </strong>`;
                //----------------------------------
                if ( unassign != null && unassign == 'unassign' ) {
                    header_grouped_text = `กลุ่มที่ถูกแบ่งที่ ${index} </strong>`;
                }
            }
            if (groupType == 'salecode') {
                header_grouped_text = `${salecode_name[index]} </strong>`;
                saleCode_data = `data-salecode="${salecode_array[index]}"`;
            }
            
            let new_row = $('<tr>');
            let new_cell = $('<td colspan="7" class="p-0">');
            let _table = $(`<table id="tableGroup_${index+1}" cellpadding="0" cellspacing="0" class="table table-sm table-striped m-0 table-group text-center tbl-accordion-nested">`);
            
            let _thead = $('<thead class="table-light table-group-header">');
            let _row = $('<tr>');
            let _cell = $(`<th class="align-middle">${index+1}</th>
                <td class="align-middle text-start" colspan="2" scope="row">
                    <strong>${header_grouped_text} </strong> <em>(จำนวน ${item.length} งาน)</em>
                </td>
                <td class="align-middle text-start">
                    <div>  
                        <select class="form-select select2 billcoll-select border-warning" id="G_${index+1}_BILLCOLL" data-placeholder="เลือกสาขาที่ต้องการ" data-bs-toggle="tooltip" title="แบ่งงานให้สาขา" data-groupid="${index+1}">
                            <option></option>
                        </select>
                    </div>
                </td>
                <td class="align-middle text-start">
                    <div>  
                        <select class="form-select select2 folcode-select" id="G_${index+1}_FOLCODE" data-placeholder="เจ้าหน้าที่ติดตาม (ถ้ามี)" data-bs-toggle="tooltip" title="แบ่งงานให้พนักงาน" data-groupid="${index+1}">
                            <option></option>
                        </select>
                    </div>
                </td>
                <td>
                    <button type="button" id="" class="btn btn-success waves-effect saveOneGroup_Btn" data-groupid="${index+1}" data-grouptype="${groupType}" ${saleCode_data}>
                        <i class="bx bx-save font-size-14 align-middle"></i> บันทึก <span class="addSpin"></span>
                    </button>

                    <span class="notification-button badge bg-warning text-center align-items-center my-1 rounded-circle" style="display: none;" data-bs-toggle="tooltip" title="งานบางส่วนในกลุ่มนี้มีการแบ่งงานแล้ว การบันทึกอีกครั้งจะเป็นการแทนที่ด้วยข้อมูลล่าสุด">
                        <img src="{{ asset('assets/images/gif/system_outline/warning.gif') }}" alt="" class="notification-icon-xs">
                    </span>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-light text-end rounded-circle toggleTable_Btn">
                        <i class="fas fa-angle-up fs-4 p-1"></i>    
                    </button>
                </td>`);

            if ( ( unassign != null && unassign == 'unassign' ) && index == 0) {
                // ถ้าเป็นการแบ่งงานแบบเฉพาะงานที่ไม่ได้มอบหมาย ให้แถวแรกเป็นการแสดงงานที่แบ่งแล้ว
                _cell = $(`<th class="align-middle"></th>
                    <td class="align-middle text-start" colspan="2" scope="row">
                        <strong>งานที่ถูกมอบหมายแล้ว </strong> <em>(จำนวน ${item.length} งาน)</em>
                    </td>
                    <td>
                        <select class="form-select" style="visibility: hidden;">
                            <option></option>
                        </select>
                    </td>
                    <td>
                        <select class="form-select" style="visibility: hidden;">
                            <option></option>
                        </select>
                    </td>
                    <td>
                        <button class="btn btn-success" style="visibility: hidden;">
                            <i class="bx bx-save font-size-14 align-middle"></i> บันทึก
                        </button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-sm btn-light text-end rounded-circle toggleTable_Btn">
                            <i class="fas fa-angle-up fs-4 p-1"></i>    
                        </button>
                    </td>`);
            }
            
            _row.append(_cell);
            _thead.append(_row);

            let _tbody = $('<tbody class="scrollable-tbody">');
            var have_folcoe_already = false;
            
            $.each( item, function( j, contract ) {

                let green_row_class = '';

                let billcoll_display = contract['BillCollName'] == null ? '-' : contract['BillCollName'];
                let folcod_display;
                if ( contract['FolName'] == null ) {
                    folcod_display = '-';
                } else {
                    folcod_display = contract['FolName'];
                    have_folcoe_already = true;
                    green_row_class = 'class="table-success"';
                }
                
                _tbody.append(`<tr ${green_row_class}>
                    <th scope="row">${index+1} - ${j+1}</th>
                    <td class="text-start">${contract['Contno']}</td>
                    <td class="text-start">${contract['Name_Cus']}</td>
                    <td>${billcoll_display}</td>
                    <td>${folcod_display}</td>
                    <td>${contract['ContStat']}</td>
                    <td></td>
                `);
            });

            _table.append(_thead);
            _table.append(_tbody);

            var new_div = $('<div class="table-group-container">');
            new_div.append(_table);

            new_cell.append(new_div);
            new_row.append(new_cell);
            $("#GroupTable tbody:first").append(new_row);

            if ( have_folcoe_already == true) {
                $(`#tableGroup_${index+1} .notification-button`).fadeIn();
            }

        });

        $('.tbl-accordion-nested').each(function(){
            var thead = $(this).find('thead');
            var tbody = $(this).find('tbody');

            //tbody.hide();
            tbody.find("tr td, tr th").each( function () {
                $(this).hide();
            })

            tbody.find("tr:not(:first-child)").each(function (index ) {
                $(this).css('animation-delay',index *0.5 +'s');
            });  

            thead.find(".toggleTable_Btn").click(function(){
                $(this).toggleClass("toggleTable_Show");
                tbody.find("tr td, tr th").each( function (index) {
                    /*
                    $(this).delay(index*1).animate({
                        height: "toggle",
                        opacity: "toggle"
                    }, 100);
                    */
                    //$(this).delay(index*1).toggle(100);
                    $(this).toggle();
                })
            })

        });

        $("#modal_xl_2").removeAttr("tabindex", "-1");

        $( '.billcoll-select' ).select2( {
            theme: "bootstrap-5",
            language: "th",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            allowClear: true,
            dropdownParent: $('#modal_xl_2 .modal-content'),
            data: dataArray_billcoll,
            //containerCssClass: 'border-warning',
        });

        //$( $('.billcoll-select').select2("container") ).addClass("border-warning");

        $('.billcoll-select').on('change', function (e) {
            //var data = e.params.data;
            var data = $(this).select2('data')[0];
            // data.text
            // $( '#G_2_FOLCODE' ) .empty().trigger("change");
            var group_id = $(this).data('groupid');
            $(`#G_${group_id}_FOLCODE`).empty().trigger("change");
            var branch_name = data.text.replaceAll(' ', '').split("-")[1];
            var _optgroup = document.createElement("OPTGROUP");
            _optgroup.setAttribute("label", branch_name);
            $.each( dataArray_user, function( i, item ) {
                if (item.text == branch_name) {
                    $.each( item.children, function( j, user ) {
                        var newOption = new Option(user.text, user.id);
                        _optgroup.appendChild(newOption);
                    })
                }
            });
            $(`#G_${group_id}_FOLCODE`).append(_optgroup).trigger('change');
            $(`#G_${group_id}_FOLCODE`).val(null).trigger('change');
        });

        $( '.folcode-select' ).select2( {
            theme: "bootstrap-5",
            language: "th",
            width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
            placeholder: $( this ).data( 'placeholder' ),
            allowClear: true,
            dropdownParent: $('#modal_xl_2 .modal-content'),
            //data: dataArray_user,
        } );

        $( '.billcoll-select' ).val('{{@$locat}}');
        $( '.billcoll-select' ).trigger('change');

        // ถ้าเป็นการแบ่งกลุ่มตามพนักงานขาย ให้ใส่ค่าพนักงานคนนั้นรอไว้
        if ( groupType == 'salecode') {
            $( '.folcode-select' ).each( function(i) {
                $(this).val( salecode_array[i] );
                $(this).trigger('change');
            });
        }

        $(".saveOneGroup_Btn").click( function() {
            var clickedBtn = $(this);
            var group_id = clickedBtn.data('groupid');
            var group_type = clickedBtn.data('grouptype'); 

            var select_billcoll = $(`#G_${group_id}_BILLCOLL`).val();
            var select_folcode = $(`#G_${group_id}_FOLCODE`).val();

            var select_billcoll_text = $(`#G_${group_id}_BILLCOLL`).find(":selected").text();
            var select_folcode_text = $(`#G_${group_id}_FOLCODE`).find(":selected").text();

            console.log( select_billcoll );
            console.log( select_folcode );

            if (select_billcoll == '' || select_billcoll == null) {
                Swal.fire({
                    title: "กรุณาตรวจสอบ",
                    icon: "warning",
                    text: `กรุณาเลือกสาขาที่ต้องการมอบหมายงานของกลุ่มที่ ${group_id}`,
                    confirmButtonText: 'เข้าใจแล้ว',
                });
                return;
            }

            if (select_folcode == '' || select_folcode == null) {
                /*
                Swal.fire({
                    title: "กรุณาตรวจสอบ",
                    icon: "warning",
                    text: `กรุณาเลือกสาขาที่ต้องการมอบหมายงานของกลุ่มที่ ${group_id}`,
                    confirmButtonText: 'เข้าใจแล้ว',
                });
                */
                Swal.fire({
                    title: 'มอบงานให้สาขาแบบไม่ระบุพนักงาน',
                    text: "ยังไม่ได้เลือก \"เจ้าหน้าที่ติดตาม\" หากยืนยันจะเป็นการมอบหมายงานให้สาขาแบบไม่ระบุพนักงาน",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ไม่ระบุพนักงาน',
                    cancelButtonText: 'ยกเลิก',
                }).then((result) => {
                    if (result.isConfirmed) {
                        ProcessSaveGroupBtn(clickedBtn, group_id, select_billcoll, select_folcode, select_billcoll_text, select_folcode_text);
                    } else if ( result.dismiss === Swal.DismissReason.cancel ) {
                        /* Read more about handling dismissals below */
                        //result.dismiss === Swal.DismissReason.cancel
                        return;
                    }
                })

            } else {
                ProcessSaveGroupBtn(clickedBtn, group_id, select_billcoll, select_folcode, select_billcoll_text, select_folcode_text);
            }

        });

        $('[data-bs-toggle="tooltip"]').tooltip();

    }

    function groupBySaleCode() {
        grouped_port = [];
        salecode_array = [];
        salecode_name = [];
        $.each( all_port, function( index, item ) {
            var salecode =  item.SaleCod;
            if ( salecode_array.indexOf(salecode) < 0 ) { // เป็นจริง ถ้าเกิด salecode ยังไม่มีใน อาร์เรย์ grouped_port
                grouped_port.push( [] );
                salecode_array.push(item.SaleCod);
                salecode_name.push(item.SaleName);
            }
            grouped_port[ salecode_array.indexOf(salecode) ].push(item);
        });
        DrawGroupedTable('salecode');
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
            if ( item.BillColl == locat && item.FolCode == null ) {
                all_port_notAssign.push(item);
            } else {
                grouped_port[0].push(item);
            }
        });
        //------------------------------------------------
        $.each( all_port_notAssign, function( index, item ) {
            var salecode =  item.SaleCod;
            if ( salecode_array.indexOf(salecode) < 0 ) { // เป็นจริง ถ้าเกิด salecode ยังไม่มีใน อาร์เรย์ grouped_port
                grouped_port.push( [] );
                salecode_array.push(item.SaleCod);
                salecode_name.push(item.SaleName);
            }
            grouped_port[ salecode_array.indexOf(salecode) ].push(item);
        });
        //------------------------------------------------
        DrawGroupedTable('salecode', 'unassign');
    }

    function ProcessSaveGroupBtn(clickedBtn, group_id, select_billcoll, select_folcode, select_billcoll_text, select_folcode_text) {
        // ล็อคทุกปุ่ม
        DisableAllButton(clickedBtn);
        //
        var port_update = [];
        $.each( grouped_port[group_id - 1], function( index, item ) {
            port_update.push( item.Contno );
        });
        // ส่ง ajax
        $.ajax({
            url: "{{ route('spast.update', @$locat ) }}",
            method: "PUT",
            data: {
                _token:'{{ csrf_token() }}',
                page: 'group',
                mode: 'phone',
                data: {
                    TYPECONT: '{{@$TYPECONT}}',
                    BILLCOLL: select_billcoll,
                    FOLCODE: select_folcode,
                    port_data: port_update,
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
                /*
                $('#modal_xl').modal('hide');
                $('#content_cus').html(result.html_card_user);
                $('#card-profile').html(result.html_view_profile);
                */
                UpdateGroup( group_id, select_billcoll, select_folcode, select_billcoll_text, select_folcode_text);
            },
            error: function(xhr, status, error) {
                // Get the error message from the response
                var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "ข้อผิดพลาดที่ไม่รู้จัก :'(";
                var errorFile = xhr.responseJSON.file ? xhr.responseJSON.file : '';
                errorFile = errorFile.replace(/^.*[\\\/]/, '');
                var errorLine = xhr.responseJSON.line ? xhr.responseJSON.line : '';
                var errorHtml = "<p>" + errorMessage +"</p>";
                errorHtml += "<p class='m-0 small'>" + errorFile + " <strong>(บรรทัดที่ " + errorLine + ")</strong></p>";
                // Display the error message using SweetAlert2
                Swal.fire({
                    icon: 'error',
                    title: error,
                    html: `<p class="m-0">ขออภัย! เกิดข้อผิดพลาด กดดูเพิ่มเติมเพื่อแสดงรายละเอียด</p><p class="my-1 small">(${status})</p>`,
                    showCancelButton: true,
                    confirmButtonText: 'ดูเพิ่มเติม',
                    cancelButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If the user clicks "More Details," show the detailed error message in a new SweetAlert2 modal
                        Swal.fire({
                            icon: 'error',
                            title: 'รายละเอียด',
                            //text: errorMessage,
                            html: errorHtml,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
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
        $('#ExcuteGroup').attr('disabled',true);
        $('#GroupAllCheckBox').attr('disabled',true);
        //------------------------------------------------
        $("#modal_xl_2 .btn-close").attr('disabled',true);
        //------------------------------------------------
        $('.billcoll-select').each(function() {
            $(this).attr('disabled',true);
        });
        $('.folcode-select').each(function() {
            $(this).attr('disabled',true);
        });
        $('.saveOneGroup_Btn').each(function() {
            $(this).attr('disabled',true);
        });
        //------------------------------------------------
        $('#saveAllGroupBtn').attr('disabled',true);
    }

    function ReturnActiveButton(clickedBtn) {
        $(clickedBtn).find(".addSpin").empty();
        ////------------------------------------------------
        $('#MODE').attr('disabled',false);
        $('#AMOUNTSUB').attr('disabled',false);
        $('#ExcuteGroup').attr('disabled',false);
        $('#GroupAllCheckBox').attr('disabled',false);
        //------------------------------------------------
        $("#modal_xl_2 .btn-close").attr('disabled',false);
        //------------------------------------------------
        $('.billcoll-select').each(function() {
            $(this).attr('disabled',false);
        });
        $('.folcode-select').each(function() {
            $(this).attr('disabled',false);
        });
        $('.saveOneGroup_Btn').each(function() {
            $(this).attr('disabled',false);
        });
        //------------------------------------------------
        $('#saveAllGroupBtn').attr('disabled',false);
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

    function UpdateGroup(groupId, newBillcoll_value, newFolcode_value, newBillcoll_name, newFolcode_name) {

        var _tbody = $(`#tableGroup_${groupId} tbody`);
        _tbody.empty();

        var billcoll_name = newBillcoll_name.replaceAll(' ', '').split("-")[0];

        $.each( grouped_port[ groupId - 1 ], function( index, item ) {
            item.BillColl = newBillcoll_value;
            item.BillCollName = billcoll_name;
            item.FolCode = newFolcode_value;
            item.FolName = newFolcode_name;

            let billcoll_display = item['BillCollName'] == null ? '-' : item['BillCollName'];
            let folcod_display = item['FolName'] == null ? '-' : item['FolName'];

            _tbody.append(`<tr class="table-success">
                <th scope="row">${groupId} - ${index+1}</th>
                <td class="text-start">${item['Contno']}</td>
                <td class="text-start">${item['Name_Cus']}</td>
                <td>${billcoll_display}</td>
                <td>${folcod_display}</td>
                <td>${item['ContStat']}</td>
                <td></td>
            `);

        });

        $(`#tableGroup_${groupId} .notification-button`).fadeIn();
    }


</script>

<script>
    // saveAllGroupBtn
    $("#saveAllGroupBtn").on('click', function() {

        Swal.fire({
            title: 'บันทึกทั้งหมด',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ยืนยัน',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                
            } else if ( result.dismiss === Swal.DismissReason.cancel ) {
                /* Read more about handling dismissals below */
                //result.dismiss === Swal.DismissReason.cancel

                return;
            }
        })


    });

</script>