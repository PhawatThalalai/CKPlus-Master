<style>
    .more__option {
        padding: 5px 10px; 
        margin-top: -7px; 
        border-radius: 5px;
        background: #9a8c98;
    }

    .con__more {
        display: flex;
    }

    .icon {
        color: #fff;
        font-weight: 500;
    }

    .countRow {
        height: 35px;
        width: 75px;
        display: flex;
        font-size: 18px;
        justify-content: center;
        align-items: center;
        margin-top: -7px; 
        margin-right: -7px;
        border-radius: 5px;
        background: #F5F5F5;
        color: #4361ee;
        font-weight: 500;
    }

    .title {
        font-size: 16px;
        font-weight: 600;
    }

    .btnHm {
        width: 25px;
        height: 25px;
        display: flex;
        justify-content: center;
        align-items: center;
        color: #fff;
        border-radius: 50%;
        background: #0000FF;
        border: none;
        text-decoration: none;
    }

    .form_con {
        width: 30%;
        max-height: 330px;
        transition: 0.2s all ease-in-out;
    }

    .tb_con  {
        width: 70%;
        transition: 0.2s all ease-in-out;
    }

    body {
        --sb-track-color: #F5F5F5;
        --sb-thumb-color: #3B82F6;
        --sb-size: 5px;
    }
    
    .accor {
        margin-top: 10px;
        height: 335px;
        overflow-y: scroll;
        padding: 5px;
    }
    
    .accor::-webkit-scrollbar {
        width: var(--sb-size);
    }
    
    .accor::-webkit-scrollbar-track {
        background: var(--sb-track-color);
        border-radius: 4px;
    }
    
    .accor::-webkit-scrollbar-thumb {
        background: var(--sb-thumb-color);
        border-radius: 4px;
    }
    
    @supports not selector(::-webkit-scrollbar) {
        .accor {
            scrollbar-color: var(--sb-thumb-color)
                            var(--sb-track-color);
        }
    }

    .table-responsive {
        width: 100%;
    }
    
    .table-responsive::-webkit-scrollbar {
        height: var(--sb-size);
    }
    
    .table-responsive::-webkit-scrollbar-track {
        background: var(--sb-track-color);
        border-radius: 4px;
    }
    
    .table-responsive::-webkit-scrollbar-thumb {
        background: var(--sb-thumb-color);
        border-radius: 4px;
    }
    
    @supports not selector(::-webkit-scrollbar) {
        .table-responsive {
            scrollbar-color: var(--sb-thumb-color)
                            var(--sb-track-color);
        }
    }

    .numStyle {
        width: 25px;
        height: 25px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 50%;
        background-color: #3B82F6;
        color: #fff;
    }

    .data__con {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
    }

    .btn__con {
        display: flex;
        justify-content: space-between;
        gap: 10px;
    }

    @media (max-width: 992px) {
       .data__con {
            display: block;
        }

        .form_con {
            width: 100%;
        }

        .tb_con  {
            width: 100%;
        }
    }

    .tr_row {
        transition: 0.2s all ease-in-out;
    }
    
    .selected {
        background: #e9ecef;
    }


    .tr_row:hover {
        background: #e9ecef;
    }
</style>

<div class="data__con">
    <div class="tb_con card px-2 py-3">
        <div class="card-body">
            <div class="table-responsive">
                <table id="datatable" class="table table-bordered align-middle nowrap">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">สาขา</th>
                            @if (@$page == 'edit-save-letter')
                                <th scope="col">EMS NO</th>
                            @endif
                            <th scope="col">เลขที่สัญญา</th>
                            <th scope="col">คำหน้าชื่อ</th>
                            <th scope="col">ชื่อลูกค้า</th>
                            <th scope="col">นามสกุล</th>
                            <th scope="col">วันที่ทำสัญญา</th>
                            <th scope="col">เบอร์โทร</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $count = 1;
                        @endphp
                        @foreach ($response as $index => $values)
                            <tr class="tr_row">
                                <td scope="row">{{ $count++ }}</td>
                                <td>{{ @$values->LOCAT }}</td>
                                @if (@$values->EMSNO != null)
                                    <td>{{ @$values->EMSNO }}</td>
                                @endif
                                <td>{{ @$values->CONTNO }}</td>
                                <td>{{ @$values->ToPact->ContractToCus->Prefix !== null ? @$values->ToPact->ContractToCus->Prefix : '-not found-' }}</td>
                                <td>{{ @$values->ToPact->ContractToCus->Firstname_Cus }}</td>
                                <td>{{ @$values->ToPact->ContractToCus->Surname_Cus !== null ? @$values->ToPact->ContractToCus->Surname_Cus : '-' }}</td>
                                <td>{{ @$values->PRINTDT }}</td>
                                <td>{{ @$values->ToPact->ContractToCus->Phone_cus }}</td>
                                <td class="d-flex justify-content-center align-items-center">
                                    <form id="form_data">
                                        @if (@$page != 'edit-save-letter')
                                            <input type="checkbox" id="vats_{{ @$values->id }}" value="{{ @$values->id }},{{ $values->LOCAT }},{{ $values->USERID }},{{ $values->ToPact->ContractToCus->Name_Cus }},{{ $values->id }},{{ @$values->ToPact->ContractToCus->Phone_cus }},{{ $values->CONTNO }}" name="vatToarr[]" class="form-check-input font-size-14 ck-vats">
                                        @else
                                            <input type="checkbox" id="vats_{{ @$values->id }}" value="{{ @$values->id }},{{ $values->LOCAT }},{{ $values->USERID }},{{ $values->ToPact->ContractToCus->Name_Cus }},{{ $values->id }},{{ @$values->ToPact->ContractToCus->Phone_cus }},{{ $values->CONTNO }},{{ $values->EMSNO }}" name="vatToarr[]" class="form-check-input font-size-14 ck-vats">
                                        @endif
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div> 
    </div>

    <div class="form_con card px-2 py-3">
        <div class="con_ly d-flex justify-content-between">
            <div class="title">
                <span>บันทึกส่งจดหมายชำระงวดแรก</span>
            </div>
            <div>
                {{-- <button id="btnSlide" class="btnHm">
                    <i class="bx bxs-grid"></i>
                </button> --}}
                <div class="con__more">
                    <div class="countRow"> </div>
                    <div class="more__option dropdown ms-auto" data-bs-toggle="tooltip" title="เพิ่มเติม">
                        <a class="text-muted font-size-16" role="button" data-bs-toggle="dropdown" aria-haspopup="true">
                            <i class="mdi mdi-dots-horizontal icon"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a id="selectAll" class="dropdown-item d-flex justify-content-between pe-auto" role="button">
                                เลือกทั้งหมด <i class="mdi mdi-format-list-checks fs-5 text-info"></i>
                            </a>
                            <a id="ClearselectAll" class="dropdown-item d-flex justify-content-between pe-auto" role="button">
                                ล้างค่า <i class="mdi mdi-format-list-checks fs-5 text-info"></i>
                            </a>
                            <a id="GenEms" class="dropdown-item d-flex justify-content-between pe-auto" role="button">
                                Generate EMS <i class='bx bx-git-repo-forked fs-5 text-info' ></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="input-ems">
            <div class="d-flex justify-content-center">
                <img class="img-fluid" src="{{ URL::asset('assets/images/letter.png') }}">
            </div>
            <div class="inputs" style="display: none;">
                <form id="saveLetter">
                    <div class="accordion my-3 list_input accor" id="accordionExample">
    
                    </div>
                    <div class="btn__con">
                        <button id="subBtnlet" type="submit" class="btn btn-success waves-effect waves-light d-flex justify-content-center align-items-center" style="width: 100%;">
                            <div id="spinnerBtn" class="spinner-border mx-2" role="status" style="width: 20px; height: 20px; display: none;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <div>
                                <i class="bx bx-archive-in"></i>
                                <span id="updateEdit">{{ @$page === 'edit-save-letter' ? 'แก้ไขบันทึกส่งจดหมาย' : 'บันทึกส่งจดหมาย' }}</span>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/pages/datatables.init.js"></script>   
<script>
    $(document).ready(function() {
        $(".countRow").text(0);
        let EMSNO = 0;
        let countForm = 0;
        let fristNo = '';
        let Country = '';
        let dataEms = {};


        // ================================================
        // Export data to PDF
        // ================================================
        $("#subBtnExport").click(function() {
            let data = {};
            let URLdata = [];
            let URLParams = '';
            let page = {
                page: 'exportLetter',
            };

            Object.entries(dataEms).forEach(([key, value]) => {
                URLParams += `&data[${key}]=${value}`;
            });

            console.log('from url', URLParams);

            $.ajax({
                url: "{{ route('report-backend.create') }}",
                type: "GET",
                data: {
                    page: 'exportLetter',
                    data: dataEms,
                    _token: "{{ csrf_token() }}",
                },
                success: async function(res) {
                    window.open("{{ route('report-backend.create') }}" + "?" + new URLSearchParams(page) + "&" + new URLSearchParams(URLParams), "_blank","toolbar=yes,scrollbars=yes,resizable=yes,top=100,left=100");
                },
                error: async function(err) {
                    console.log(err);
                }
            });
        });

        // ================================================
        // Select all checkbox and add input follow checkbox
        // ================================================
        $("#selectAll").click(function() {
            var id_ck = [];
            $('.ck-vats').prop('checked', true);
            $(".countRow").text($('.ck-vats').length);
            $(".list_input").html("").slideDown('slow');
            $("#form_data input.ck-vats:checked").toggleClass("selected");
            updateRowStyles();
            
            if ($('.ck-vats').prop('checked') === true) {
                var countInput = 1;
                $('.img-fluid').css('display', 'none');
                $('.inputs').css('display', 'block');
                $('.form_con').css('max-height', '455px');

                $('#form_data input.ck-vats').each(function() {
                    if ($(this).prop('checked')) {
                        id_ck.push($(this).val());
                    }
                });

                // ================================================
                // loop element input
                // ================================================
                for (let index = 0; index < $('.ck-vats').length; index++) {
                    const item = id_ck[index].split(",");
                    console.log(item);
                    var listItem = `
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading_${ item[0] }">
                                    <button class="accordion-button fw-medium gap-x-3 py-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_${ item[0] }" aria-expanded="true" aria-controls="collapse_${ item[0] }">
                                        <div class="numStyle">${countInput}</div>
                                        <div class="mx-2">
                                            <span class='text-primary err_con rounded px-2 bg-primary bg-opacity-50 d-flex justify-content-center align-items-center'>
                                                <lord-icon
                                                    src="https://cdn.lordicon.com/aycieyht.json"
                                                    trigger="loop"
                                                    stroke="bold"
                                                    colors="primary:#4030e8,secondary:#08a88a"
                                                    style="width:30px;height:30px">
                                                </lord-icon>
                                                <span class="mx-1">${item[7]}</span>
                                            </span>    
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse_${ item[0] }" class="accordion-collapse collapse show" aria-labelledby="heading_${ item[0] }" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row g-2">
                                            <div class="col-6 d-flex" style="width: 100%; column-gap: 10px;">
                                                <div class="input-bx" style="width: 30%;">
                                                    <input type="text" value="${item[1]}" name="" class="form-control"  placeholder=" " readonly/>
                                                    <span>รหัสสาขา</span>
                                                </div>
                                                <div class="input-bx" id="datepicker1" style="width: 70%;">
                                                    <div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#search_box" data-date-format="dd-mm-yyyy" data-date-language="th">
                                                        <div class="input-bx">
                                                            <input type="text" class="form-control py-2 form-control-sm textSize-13" name="" id="Fdate" value="{{date('d-m-Y')}}" placeholder="Start Date"  readonly required>
                                                            <span>วันที่ส่ง</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 d-flex" style="width: 100%; column-gap: 10px;">
                                                <div class="input-bx" style="width: 30%;">
                                                    <input type="text" value="${item[2]}" name="" class="form-control"  placeholder=" " readonly/>
                                                    <span>รหัสลูกค้า</span>
                                                </div>
                                                <div class="input-bx" style="width: 70%;">
                                                    <input type="text" value="${item[3]}" name="" class="form-control"  placeholder=" " readonly/>
                                                    <span>ชื่อลูกค้า</span>
                                                </div>
                                            </div>
                                            <div class="col-6 d-flex" style="width: 100%; column-gap: 10px;">
                                                <div class="input-bx" style="width: 100%;">
                                                    <input type="text" value="${item[5]}" name="" class="form-control"  placeholder=" "/>
                                                    <span>เบอร์โทรลูกค้า</span>
                                                </div>
                                            </div>
                                             <div class="col-6 d-flex" style="width: 100%; column-gap: 10px;">
                                                <div class="input-bx" style="width: 100%;">
                                                    <input type="text" id="EMS_${countInput}" value="${fristNo !== '' ? fristNo : ''}" name="EMS_${item[0]}" class="form-control" required placeholder=" " />
                                                    <span>รหัสขึ้นต้น</span>
                                                </div>
                                                <div class="input-bx" style="width: 100%;">
                                                    <input type="text" id="EMSNO_${countInput}" value="${EmsNo !== '' ? EmsNo : ''}" name="EMSNO_${item[0]}" class="form-control" required placeholder=" " />
                                                    <span>บาร์โค๊ด</span>
                                                </div>
                                                <div class="input-bx" style="width: 100%;">
                                                    <input type="text" id=verify_${countInput}" value="" name="verify_${item[0]}" class="form-control" required placeholder=" " />
                                                    <span>เลข ตส.</span>
                                                </div>
                                                <div class="input-bx" style="width: 100%;">
                                                    <input type="text" id="Contry_${countInput}" value="${Country !== '' ? Country : ''}" name="${item[0]}" class="form-control" required placeholder=" " />
                                                    <span>ตัวย่อ</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    `;

                    $(".list_input").append(listItem);
                    countInput++;
                }
            } else {
                return null;
            }
        });

        // ================================================
        // Clear checkbox and input
        // ================================================
        $("#ClearselectAll").click(function() {
            if ($('.ck-vats').prop('checked') !== false) {
                $('.ck-vats').prop('checked', false);
                $(".countRow").text(('0'));
                $(".list_input").html("").slideDown('slow');
                $('.img-fluid').css('display', 'block');
                $('.inputs').css('display', 'none');
                $('.form_con').css('max-height', '330px');
                updateRowStyles();
            } else {
                return null;
            }
        });
        
        $("#GenEms").click(function() {
            console.log('test');
        });

        // ================================================
        // save data to database
        // ================================================
        $("#saveLetter").submit(function(e) {
            e.preventDefault();
            $("#spinnerBtn").css('display', 'block');
            $('#subBtnlet').prop('disabled', true);
            $('#btnSave').prop('disabled', true);
            $("#filterEdit").prop('disabled', true);
            $("#saveLetter").prop('disabled', true);

            let data = {};
            $("#saveLetter").serializeArray().map(function(x) {
                data[x.name] = x.value;
            });

            console.log(data);

            $.ajax({
                type: "POST",
                url: "{{ route('letter.store') }}",
                data: {
                    page: 'saveLetter',
                    resHtml: "{{ empty(@$page) ? 'saveLetter' : 'edit-save-letter' }}",
                    data: data,
                    _token: "{{ csrf_token() }}",
                },
                success: function(res) {
                    dataEms = data;
                    $("#spinnerBtn").css('display', 'none');
                    $('#subBtnlet').prop('disabled', true);
                    $('#btnSave').prop('disabled', false);
                    $('#subBtnExport').removeClass('visually-hidden');
                    $('.ck-vats').prop('disabled', true);$('#subBtnlet').prop('disabled', true);
                    $("#filterEdit").prop('disabled', false);
                    $("#saveLetter").prop('disabled', false);

                    @if(empty(@$page))
                        $("#btnSave").click();
                    @else
                        $("#filterEdit").click();
                    @endif

                    Swal.fire({
                        icon: 'success',
                        text: res.message,
                        showConfirmButton: false,
                        timer: 1500
                    });

                    console.log(res);
                },
                error: function(err) {
                    $("#spinnerBtn").css('display', 'none');
                    $('#subBtnlet').prop('disabled', false);
                    $('#btnSave').prop('disabled', false);
                    $("#filterEdit").prop('disabled', false);
                    $("#saveLetter").prop('disabled', false);

                    Swal.fire({
                        icon: 'error',
                        text: err.responseJSON.message,
                        showConfirmButton: false,
                        timer: 1500
                    });

                    console.log(err);
                }
            });
        });

        $("#filterEdit").click(function(e) {
            $('#btnSave').prop('disabled', true);
            $("#filterEdit").prop('disabled', true);
            let data = {};
            $("#formsave_lettle").serializeArray().map(function(x) {
                data[x.name] = x.value;
            });
            $.ajax({
                url: "{{ route('letter.create') }}",
                type: "GET",
                data: {
                    data: data,
                    page: 'edit-save-letter',
                    _token: "{{ csrf_token() }}",
                },
                success: function(res) {
                    $('#btnSave').prop('disabled', false);
                    $("#filterEdit").prop('disabled', false);
                    $('#show_data').html(res.resHtml).slideDown('slow');
                    console.log(res);
                },
                error: function(err) {
                    $('#btnSave').prop('disabled', false);
                    $("#filterEdit").prop('disabled', false);
                    log(err);
                }
            });
        });

        // ================================================
        // func post target on click row to func onChange on table
        // ================================================        
        $(".table").on('click', 'tr', function() {
            if ($(event.target).is("input:checkbox")) {
                return;
            }
            if ($('.ck-vats').prop('disabled') === true) {
                return;
            }
            $(this).toggleClass("selected");
            $(this).find("input:checkbox").trigger("click");
        });

        // ================================================
        // func get target from fucn post on table
        // ================================================        
        $(".table").on('change', 'input:checkbox', function() {
            var id_ck = [];
            $(".list_input").html("").slideDown('slow');
            let count = parseInt($(".countRow").text());
            $('#form_data input.ck-vats:checked').each(function() {
                id_ck.push($(this).val());
            });

            { $(this).prop("checked") ? count++ : count-- }
            $(".countRow").text(count);
            
            if (count > 0) {
                $('.img-fluid').css('display', 'none');
                $('.inputs').css('display', 'block');
                $('.form_con').css('max-height', '455px');
                // $('.tr_row').css('background', '#e9ecef');
                var countInput = 1;
                let EmsNo = EMSNO;

                // console.log(data);

                // ================================================
                // loop element input
                // ================================================
                for (let index = 0; index < id_ck.length; index++) {
                    const item = id_ck[index].split(",");
                    if (EmsNo !== 0) {
                        EmsNo++;
                    }
                    console.log(item);
                    let listItem;
                    
                    @if (@$page != 'edit-save-letter')
                        listItem = `
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading_${ item[0] }">
                                    <button class="accordion-button fw-medium gap-x-3 py-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_${ item[0] }" aria-expanded="true" aria-controls="collapse_${ item[0] }">
                                        <div class="numStyle">${countInput}</div>
                                        <div class="mx-2">
                                            <span class='text-primary err_con rounded px-2 bg-primary bg-opacity-50 d-flex justify-content-center align-items-center'>
                                                <lord-icon
                                                    src="https://cdn.lordicon.com/aycieyht.json"
                                                    trigger="loop"
                                                    stroke="bold"
                                                    colors="primary:#4030e8,secondary:#08a88a"
                                                    style="width:30px;height:30px">
                                                </lord-icon>
                                                <span class="mx-1">${item[7]}</span>
                                            </span>    
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse_${ item[0] }" class="accordion-collapse collapse show" aria-labelledby="heading_${ item[0] }" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row g-2">
                                            <div class="col-6 d-flex" style="width: 100%; column-gap: 10px;">
                                                <div class="input-bx" style="width: 30%;">
                                                    <input type="text" value="${item[1]}" name="" class="form-control"  placeholder=" " readonly/>
                                                    <span>รหัสสาขา</span>
                                                </div>
                                                <div class="input-bx" id="datepicker1" style="width: 70%;">
                                                    <div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#search_box" data-date-format="dd-mm-yyyy" data-date-language="th">
                                                        <div class="input-bx">
                                                            <input type="text" name="DATE_EMS_${item[0]}" id="DATE_EMS_${item[0]}" class="form-control py-2 form-control-sm textSize-13" id="Fdate" value="{{date('d-m-Y')}}" placeholder="Start Date"  readonly required>
                                                            <span>วันที่ส่ง</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 d-flex" style="width: 100%; column-gap: 10px;">
                                                <div class="input-bx" style="width: 30%;">
                                                    <input type="text" value="${item[2]}" name="" class="form-control"  placeholder=" " readonly/>
                                                    <span>รหัสลูกค้า</span>
                                                </div>
                                                <div class="input-bx" style="width: 70%;">
                                                    <input type="text" value="${item[3]}" name="" class="form-control"  placeholder=" " readonly/>
                                                    <span>ชื่อลูกค้า</span>
                                                </div>
                                            </div>
                                            <div class="col-6 d-flex" style="width: 100%; column-gap: 10px;">
                                                <div class="input-bx" style="width: 100%;">
                                                    <input type="text" value="${item[5]}" name="" class="form-control"  placeholder=" "/>
                                                    <span>เบอร์โทรลูกค้า</span>
                                                </div>
                                            </div>
                                            <div class="col-6 d-flex" style="width: 100%; column-gap: 10px;">
                                                <div class="input-bx" style="width: 100%;">
                                                    <input type="text" id="EMS_${countInput}" value="${fristNo !== '' ? fristNo : ''}" name="EMS_${item[0]}" class="form-control" required placeholder=" " />
                                                    <span>รหัสขึ้นต้น</span>
                                                </div>
                                                <div class="input-bx" style="width: 100%;">
                                                    <input type="text" id="EMSNO_${countInput}" value="${EmsNo !== '' ? EmsNo : ''}" name="EMSNO_${item[0]}" class="form-control" required placeholder=" " />
                                                    <span>บาร์โค๊ด</span>
                                                </div>
                                                <div class="input-bx" style="width: 100%;">
                                                    <input type="text" id=verify_${countInput}" value="" name="verify_${item[0]}" class="form-control" required placeholder=" " />
                                                    <span>เลข ตส.</span>
                                                </div>
                                                <div class="input-bx" style="width: 100%;">
                                                    <input type="text" id="Contry_${countInput}" value="${Country !== '' ? Country : ''}" name="${item[0]}" class="form-control" required placeholder=" " />
                                                    <span>ตัวย่อ</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    @else
                        listItem = `
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading_${ item[0] }">
                                    <button class="accordion-button fw-medium gap-x-3 py-2" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_${ item[0] }" aria-expanded="true" aria-controls="collapse_${ item[0] }">
                                        <div class="numStyle">${countInput}</div>
                                        <div class="mx-2">
                                            <span class='text-primary err_con rounded px-2 bg-primary bg-opacity-50 d-flex justify-content-center align-items-center'>
                                                <lord-icon
                                                    src="https://cdn.lordicon.com/aycieyht.json"
                                                    trigger="loop"
                                                    stroke="bold"
                                                    colors="primary:#4030e8,secondary:#08a88a"
                                                    style="width:30px;height:30px">
                                                </lord-icon>
                                                <span class="mx-1">${item[7]}</span>
                                            </span>    
                                        </div>
                                    </button>
                                </h2>
                                <div id="collapse_${ item[0] }" class="accordion-collapse collapse show" aria-labelledby="heading_${ item[0] }" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="row g-2">
                                            <div class="col-6 d-flex" style="width: 100%; column-gap: 10px;">
                                                <div class="input-bx" style="width: 30%;">
                                                    <input type="text" value="${item[1]}" name="" class="form-control"  placeholder=" " readonly/>
                                                    <span>รหัสสาขา</span>
                                                </div>
                                                <div class="input-bx" id="datepicker1" style="width: 70%;">
                                                    <div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#search_box" data-date-format="dd-mm-yyyy" data-date-language="th">
                                                        <div class="input-bx">
                                                            <input type="text" name="DATE_EMS_${item[0]}" id="DATE_EMS_${item[0]}" class="form-control py-2 form-control-sm textSize-13" id="Fdate" value="{{date('d-m-Y')}}" placeholder="Start Date"  readonly required>
                                                            <span>วันที่ส่ง</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6 d-flex" style="width: 100%; column-gap: 10px;">
                                                <div class="input-bx" style="width: 30%;">
                                                    <input type="text" value="${fristNo}" name="" class="form-control"  placeholder=" " readonly/>
                                                    <span>รหัสลูกค้า</span>
                                                </div>
                                                <div class="input-bx" style="width: 70%;">
                                                    <input type="text" value="${item[3]}" name="" class="form-control"  placeholder=" " readonly/>
                                                    <span>ชื่อลูกค้า</span>
                                                </div>
                                            </div>
                                            <div class="col-6 d-flex" style="width: 100%; column-gap: 10px;">
                                                <div class="input-bx" style="width: 100%;">
                                                    <input type="text" value="${item[5]}" name="" class="form-control"  placeholder=" "/>
                                                    <span>เบอร์โทรลูกค้า</span>
                                                </div>
                                            </div>
                                            <div class="col-6 d-flex" style="width: 100%; column-gap: 10px;">
                                                <div class="input-bx" style="width: 100%;">
                                                    <input type="text" id="EMS_${countInput}" value="${fristNo !== '' ? fristNo : ''}" name="EMS_${item[0]}" class="form-control" required placeholder=" " />
                                                    <span>รหัสขึ้นต้น</span>
                                                </div>
                                                <div class="input-bx" style="width: 100%;">
                                                    <input type="text" id="EMSNO_${countInput}" value="${EmsNo !== '' ? EmsNo : ''}" name="EMSNO_${item[0]}" class="form-control" required placeholder=" " />
                                                    <span>บาร์โค๊ด</span>
                                                </div>
                                                <div class="input-bx" style="width: 100%;">
                                                    <input type="text" id=verify_${countInput}" value="" name="verify_${item[0]}" class="form-control" required placeholder=" " />
                                                    <span>เลข ตส.</span>
                                                </div>
                                                <div class="input-bx" style="width: 100%;">
                                                    <input type="text" id="Contry_${countInput}" value="${Country !== '' ? Country : ''}" name="${item[0]}" class="form-control" required placeholder=" " />
                                                    <span>ตัวย่อ</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    @endif
                    
                    $(".list_input").append(listItem);
                    $(`#EMS_${countInput}`).on("change", function() {
                        fristNo = $(this).val();
                    });

                    $(`#EMSNO_${countInput}`).on("change", function() {
                        EMSNO = $(this).val();
                    });

                    $(`#Contry_${countInput}`).on("change", function() {
                        Country = $(this).val();
                    });
                    countInput++;
                }
            } else {
                $('.img-fluid').css('display', 'block');
                $('.inputs').css('display', 'none');
                $('.form_con').css('max-height', '330px');
            }
        });

        // ================================================
        // func update row styles on table
        // ================================================ 
        function updateRowStyles() {
            $('.table tbody tr').each(function() {
                if ($(this).find(".ck-vats").is(":checked")) {
                    // $(this).addClass("selected").find("input, select").prop("disabled", true);
                    $(this).addClass("selected").find("input, select");
                } else {
                    // $(this).removeClass("selected").find("input, select").prop("disabled", false);
                    $(this).removeClass("selected").find("input, select");
                }
            });
        }
    });
</script>
