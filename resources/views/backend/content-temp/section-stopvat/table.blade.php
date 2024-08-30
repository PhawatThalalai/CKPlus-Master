<style>
    .selected {
        background: #e9ecef;
    }

    .tr_row {
        transition: 0.15s all ease-in-out;
    }

    .tr_row:hover {
        background: #e9ecef;
    }

    table {
        font-size: 13px;
    }

    tr{
        cursor: pointer;
    }
</style>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                {{-- <div class="card__radio_display">
                    @php
                        $card_radio_data = [
                                [
                                    'icon-url' => 'https://cdn.lordicon.com/jzvoyjzb.json',
                                    'icon-color' => 'primary:#1d6f42,secondary:#ebe6ef',
                                    'icon-stroke' => 'bold',
                                    'sub-icon' => 'fas fa-biking',
                                    'radio-name' => 'saveType',
                                    'btn-name' => 'บันทึกหยุดรับรู้รายได้ตามดิว',
                                    'btn-value' => 'stopvats',
                                    'btn-checked' => true,
                                    'color' => 'info',
                                    'width' => 'full',
                                ],
                                [
                                    'icon-url' => 'https://cdn.lordicon.com/jzvoyjzb.json',
                                    'icon-color' => 'primary:#dc2f02,secondary:#ebe6ef',
                                    'icon-stroke' => 'bold',
                                    'sub-icon' => 'fas fa-biking',
                                    'radio-name' => 'saveType',
                                    'btn-name' => 'ยกเลิกหยุดรับรู้รายได้ตามดิว',
                                    'btn-value' => 'cancel-stopvats',
                                    'btn-checked' => false,
                                    'color' => 'primary',
                                    'width' => 'full',
                                ],
                            ];
                    @endphp
                    @component('components.card-radio')
                        @slot('data', [
                            'data-arr' => $card_radio_data
                        ])
                    @endcomponent

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
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered align-middle nowrap table-sm fs-6 table-hover text-center">
                        <thead class="table-info">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">สาขา</th>
                                <th scope="col">เลขที่สัญญา</th>
                                <th scope="col">วันที่ทำสัญญา</th>
                                <th scope="col">ยอดผ่อนชำระ</th>
                                <th scope="col">วันที่หยุด</th>
                                <th scope="col">ค้างจริง</th>
                                <th scope="col">ค้างงวด</th>
                                <th scope="col">ค้างจาก</th>
                                <th scope="col">ค้างถึง</th>
                                <th scope="col">เงินค้างงวด</th>
                                <th scope="col">พนักงาน</th>
                                <th scope="col">action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $count = 1;
                            @endphp
                            @foreach ($res_data as $item)
                                <tr class="tr_row">
                                    <th scope="row">{{ $count++ }}</th>
                                    @if($item->CODLOAN==1)
                                     <td>{{ $item->ContractLocat->NickName_Branch }}</td>
                                     @else
                                     <td>{{ $item->ContractToBranch->NickName_Branch }}</td>
                                     @endif
                                    <td>{{ $item->CONTNO }}</td>
                                    <td>{{ $item->SDATE }}</td>
                                    <td>{{ number_format($item->TOTPRC,2) }}</td>
                                    <td>{{ $item->DTSTOPV }}</td>
                                    <td><span class="badge badge-soft-success">{{ $item->HLDNO }}</span></td>
                                    <td><span class="badge badge-soft-success">{{ $item->EXP_PRD }}</span></td>
                                    <td>{{ $item->EXP_FRM }}</td>
                                    <td>{{ $item->EXP_TO }}</td>
                                    <td><span class="badge bg-success">{{ number_format($item->EXP_AMT,2) }}</span></td>
                                    <td>
                                       {{ @$saveType=='stopvats'?'':@$item->ContractSTOPV->STOPVToUser->name }}
                                    </td>
                                    <td class="d-flex justify-content-center align-items-center">
                                        <form id="form_data">
                                            <input type="checkbox" id="vats_{{ @$item->CONTNO }}" value="{{ @$item->CONTNO }}" name="vatToarr[]" class="form-check-input font-size-14 ck-vats">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/pages/datatables.init.js"></script>
<script>
    $(document).ready(function() {
        let id_ck = [];
        // ================================================
        // Select all checkbox and add input follow checkbox
        // ================================================
        $("#selectAll").click(function() {
            var id_ck = [];
            $('.ck-vats').prop('checked', true);
            $(".countRow").text($('.ck-vats').length);
            $(".list_input").html("").slideDown('slow');
            $("#form_Stopvat input.ck-vats:checked").toggleClass("selected");
            updateRowStyles();

            if ($('.ck-vats').prop('checked') === true) {
                $('#form_Stopvat input.ck-vats').each(function() {
                    if ($(this).prop('checked')) {
                        id_ck.push($(this).val());
                    }
                });
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
                id_ck = [];
                updateRowStyles();
            } else {
                return null;
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
        $(".list_input").html("").slideDown('slow');
        let count = parseInt($(".countRow").text());
        $('#form_data input.ck-vats:checked').each(function() {
            id_ck.push($(this).val());
        });

        { $(this).prop("checked") ? count++ : count-- }
        $(".countRow").text(count);
    });

    $('#btn_saveStopvat').click(function() {
            var dataform = document.querySelectorAll('#form_Stopvat');
            var validate = validateForms(dataform);
            var saveBtn = document.getElementById('btn_saveStopvat');

            var uniqueArray = Array.from(new Set(id_ck));

            console.log(uniqueArray);

            if (validate == true) {
                if (id_ck.length != 0) {

                    let data = {};
                    $("#form_Stopvat").serializeArray().map(function(x) {
                        data[x.name] = x.value;
                    });

                    swal.fire({
                        title: "Are you sure?",
                        text: "คุณแน่ใจหรือไม่ว่าจะบันทึก",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Yes, save it!",
                        cancelButtonText: "No, cancel!",
                        reverseButtons: true
                        }).then((result) => {
                        if (result.isConfirmed) {
                            $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
                            $.ajax({
                                url: "{{ route('account.store') }}",
                                type: "POST",
                                data: {
                                    page: 'save-stopvat',
                                    data: data,
                                    _token: "{{ @csrf_token() }}",
                                    idstop: id_ck,
                                },
                                success: async function(response) {
                                    $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                                    saveBtn.disabled = true;
                                    await Swal.fire({
                                        icon: 'success',
                                        text: response.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    $('#btn_Stopvat').click();

                                },
                                error: async function(err) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: `ERROR ` + err.status + ` !!!`,
                                        text: err.responseJSON.message,
                                        showConfirmButton: true,
                                    });

                                    $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                                }
                            })
                        } else if (result.dismiss === Swal.DismissReason.cancel) {
                            swal.fire({
                            title: "Cancelled",
                            text: "Your imaginary file is safe :)",
                            icon: "error"
                            });
                        }
                    });
                } else {
                    swal.fire({
                        text: "กรุณาเลือกรายการที่ต้องการบันทึก",
                        icon: "error"
                    });
                }
            }
        });
    });
</script>
