<div class="row mt-1">
    <div class="col-xl-6 col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="flex-shrink-0 me-3">
                        <img src="{{ asset('assets/images/gif/cloud.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
                    </div>
                    <div class="flex-grow-1 align-self-center">
                        <div class="text-muted">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h6 class="text-primary fw-semibold">ฐานข้อมูลเช่าซื้อ</h6>
                                    <p class="text-muted mt-n1 fw-semibold font-size-12">( HP Loan Informations )</p>
                                </div>
                                <div class="ms-3">
                                    <span class="badge badge-soft-danger font-size-12 me-1 Hp-badge"> {{ isset($dataHp) ? count($dataHp) : 0 }} รายการ</span>
                                </div>
                            </div>
                            <p class="border-primary border-bottom mt-n2"></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        @php
                            @$HpPay = @$dataHp
                                ->filter(function ($e) {
                                    return $e->TYPEPAY == 'Payment';
                                })
                                ->count();
                            
                            @$Hpother = @$dataHp
                                ->filter(function ($e) {
                                    return $e->TYPEPAY == 'Payother';
                                })
                                ->count();
                        @endphp
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#tabHp_pay" role="tab" aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="fas fa-calendar-day"></i>
                                        <span class="position-absolute top-0 ms-1 prem">
                                            <span class="badge bg-danger rounded-pill Hp_pay-d-none">
                                                {{ @$HpPay }}
                                            </span>
                                        </span>
                                    </span>
                                    <span class="d-none d-sm-block fw-semibold text-muted"><i class="fas fa-calendar-day"></i> ตารางรับชำระ
                                        <span class="position-absolute top-0 ms-1 prem">
                                            <span class="badge bg-danger rounded-pill Hp_pay">
                                                {{ @$HpPay }}
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#tabHp_payother" role="tab" aria-selected="true">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-cash-plus font-size-16"></i>
                                        <span class="position-absolute top-0 ms-1 prem">
                                            <span class="badge bg-danger rounded-pill Hp_payother-d-none">
                                                {{ @$Hpother }}
                                            </span>
                                        </span>
                                    </span>
                                    <span class="d-none d-sm-block fw-semibold text-muted"><i class="mdi mdi-cash-plus font-size-16"></i> ค่าธรรมเนียมอื่นๆ
                                        <span class="position-absolute top-0 ms-1 prem">
                                            <span class="badge bg-danger rounded-pill Hp_payother">
                                                {{ @$Hpother }}
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content text-muted">
                            <div class="tab-pane active show" id="tabHp_pay" role="tabpanel">
                                <div class="table-responsive font-size-11" data-simplebar="init" style="max-height : 300px;">
                                    <table class="table text-nowrap align-middle table-sm mb-0">
                                        <thead class="bg-light sticky-top" style="line-height: 200%;">
                                            <tr class="text-center">
                                                <th colspan="2">เลขสัญญา</th>
                                                <th>สาขารับ</th>
                                                <th>เลขที่ใบรับ</th>
                                                <th>วันที่รับ</th>
                                                <th>ยอดรับชำระ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (@$dataHp as $item)
                                                @if (@$item->TYPEPAY == 'Payment')
                                                    <tr class="tbPay-{{ @$item->id }}">
                                                        <td class="d-flex justify-content-center">
                                                            <a role="button" class="text-danger hover-up btn-CnPay" data-id="{{ @$item->id }}" data-db="Hp" data-btn="Hp_pay" data-bs-toggle="tooltip" title="ยกเลิกใบเสร็จ">
                                                                <i class="mdi mdi-sticker-remove font-size-16"></i>
                                                            </a>
                                                        </td>
                                                        <td class="text-center">{{ @$item->CONTNO }}</td>
                                                        <td class="text-center">{{ @$item->BrLOCATREC->NickName_Branch }}</td>
                                                        <td class="text-center">
                                                            <span class="badge badge-pill badge-soft-danger font-size-11">
                                                                {{ @$item->BILLNO }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">{{ date('d-m-Y', strtotime(@$item->PAYDT)) }}</td>
                                                        <td class="text-end">{{ number_format(@$item->CHQAMT, 2) }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabHp_payother" role="tabpanel">
                                <div class="table-responsive font-size-11" data-simplebar="init" style="max-height : 300px;">
                                    <table class="table text-nowrap align-middle table-sm mb-0">
                                        <thead class="bg-light sticky-top" style="line-height: 200%;">
                                            <tr class="text-center">
                                                <th colspan="2">เลขสัญญา</th>
                                                <th>สาขารับ</th>
                                                <th>เลขที่ใบรับ</th>
                                                <th>วันที่รับ</th>
                                                <th>ยอดรับชำระ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (@$dataHp as $item)
                                                @if (@$item->TYPEPAY == 'Payother')
                                                    <tr class="tbPay-{{ @$item->id }}">
                                                        <td class="d-flex justify-content-center">
                                                            <a role="button" class="text-danger hover-up btn-CnPay" data-id="{{ @$item->id }}" data-db="Hp" data-btn="Hp_payother" data-bs-toggle="tooltip" title="ยกเลิกใบเสร็จ">
                                                                <i class="mdi mdi-sticker-remove font-size-16"></i>
                                                            </a>
                                                        </td>
                                                        <td class="text-center">{{ @$item->CONTNO }}</td>
                                                        <td class="text-center">{{ @$item->BrLOCATREC->NickName_Branch }}</td>
                                                        <td class="text-center">
                                                            <span class="badge badge-pill badge-soft-danger font-size-11">
                                                                {{ @$item->BILLNO }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">{{ date('d-m-Y', strtotime(@$item->PAYDT)) }}</td>
                                                        <td class="text-end">{{ number_format(@$item->CHQAMT, 2) }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-lg-6 col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex align-items-start">
                    <div class="flex-shrink-0 me-3">
                        <img src="{{ asset('assets/images/gif/cloud.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
                    </div>
                    <div class="flex-grow-1 align-self-center">
                        <div class="text-muted">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <h6 class="text-primary fw-semibold">ฐานข้อมูลเงินกู้</h6>
                                    <p class="text-muted mt-n1 fw-semibold font-size-12">( PSL Loan Informations )</p>
                                </div>
                                <div class="ms-3">
                                    <span class="badge badge-soft-danger font-size-12 me-1 Psl-badge"> {{ isset($dataPsl) ? count($dataPsl) : 0 }} รายการ</span>
                                </div>
                            </div>
                            <p class="border-primary border-bottom mt-n2"></p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        @php
                            @$PslPay = @$dataPsl
                                ->filter(function ($e) {
                                    return $e->TYPEPAY == 'Payment';
                                })
                                ->count();
                            
                            @$Pslother = @$dataPsl
                                ->filter(function ($e) {
                                    return $e->TYPEPAY == 'Payother';
                                })
                                ->count();
                        @endphp
                        <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" data-bs-toggle="tab" href="#tabPsl_pay" role="tab" aria-selected="false" tabindex="-1">
                                    <span class="d-block d-sm-none"><i class="fas fa-calendar-day"></i>
                                        <span class="position-absolute top-0 ms-1 prem">
                                            <span class="badge bg-danger rounded-pill Psl_pay-d-none">
                                                {{ @$PslPay }}
                                            </span>
                                        </span>
                                    </span>
                                    <span class="d-none d-sm-block fw-semibold text-muted"><i class="fas fa-calendar-day"></i> ตารางรับชำระ
                                        <span class="position-absolute top-0 ms-1 prem">
                                            <span class="badge bg-danger rounded-pill Psl_pay">
                                                {{ @$PslPay }}
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" data-bs-toggle="tab" href="#tabPsl_payother" role="tab" aria-selected="true">
                                    <span class="d-block d-sm-none"><i class="mdi mdi-cash-plus font-size-16"></i>
                                        <span class="position-absolute top-0 ms-1 prem">
                                            <span class="badge bg-danger rounded-pill Psl_payother-d-none">
                                                {{ @$Pslother }}
                                            </span>
                                        </span>
                                    </span>
                                    <span class="d-none d-sm-block fw-semibold text-muted"><i class="mdi mdi-cash-plus font-size-16"></i> ค่าธรรมเนียมอื่นๆ
                                        <span class="position-absolute top-0 ms-1 prem">
                                            <span class="badge bg-danger rounded-pill Psl_payother">
                                                {{ @$Pslother }}
                                            </span>
                                        </span>
                                    </span>
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content text-muted">
                            <div class="tab-pane active show" id="tabPsl_pay" role="tabpanel">
                                <div class="table-responsive font-size-11" data-simplebar="init" style="max-height : 300px;">
                                    <table class="table text-nowrap align-middle table-sm mb-0">
                                        <thead class="bg-light sticky-top" style="line-height: 200%;">
                                            <tr class="text-center">
                                                <th colspan="2">เลขสัญญา</th>
                                                <th>สาขารับ</th>
                                                <th>เลขที่ใบรับ</th>
                                                <th>วันที่รับ</th>
                                                <th>ยอดรับชำระ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (@$dataPsl as $item)
                                                @if (@$item->TYPEPAY == 'Payment')
                                                    <tr class="tbPay-{{ @$item->id }}">
                                                        <td class="d-flex justify-content-center">
                                                            <a role="button" class="text-danger hover-up btn-CnPay" data-id="{{ @$item->id }}" data-db="Psl" data-btn="Psl_pay" data-bs-toggle="tooltip" title="ยกเลิกใบเสร็จ">
                                                                <i class="mdi mdi-sticker-remove font-size-16"></i>
                                                            </a>
                                                        </td>
                                                        <td class="text-center">{{ @$item->CONTNO }}</td>
                                                        <td class="text-center">{{ @$item->BrLOCATREC->NickName_Branch }}</td>
                                                        <td class="text-center">
                                                            <span class="badge badge-pill badge-soft-danger font-size-11">
                                                                {{ @$item->BILLNO }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">{{ date('d-m-Y', strtotime(@$item->PAYDT)) }}</td>
                                                        <td class="text-end">{{ number_format(@$item->CHQAMT, 2) }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane" id="tabPsl_payother" role="tabpanel">
                                <div class="table-responsive font-size-11" data-simplebar="init" style="max-height : 300px;">
                                    <table class="table text-nowrap align-middle table-sm mb-0">
                                        <thead class="bg-light sticky-top" style="line-height: 200%;">
                                            <tr class="text-center">
                                                <th colspan="2">เลขสัญญา</th>
                                                <th>สาขารับ</th>
                                                <th>เลขที่ใบรับ</th>
                                                <th>วันที่รับ</th>
                                                <th>ยอดรับชำระ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (@$dataPsl as $item)
                                                @if (@$item->TYPEPAY == 'Payother')
                                                    <tr class="tbPay-{{ @$item->id }}">
                                                        <td class="d-flex justify-content-center">
                                                            <a role="button" class="text-danger hover-up btn-CnPay" data-id="{{ @$item->id }}" data-db="Psl" data-btn="Psl_payother" data-bs-toggle="tooltip" title="ยกเลิกใบเสร็จ">
                                                                <i class="mdi mdi-sticker-remove font-size-16"></i>
                                                            </a>
                                                        </td>
                                                        <td class="text-center">{{ @$item->CONTNO }}</td>
                                                        <td class="text-center">{{ @$item->BrLOCATREC->NickName_Branch }}</td>
                                                        <td class="text-center">
                                                            <span class="badge badge-pill badge-soft-danger font-size-11">
                                                                {{ @$item->BILLNO }}
                                                            </span>
                                                        </td>
                                                        <td class="text-center">{{ date('d-m-Y', strtotime(@$item->PAYDT)) }}</td>
                                                        <td class="text-end">{{ number_format(@$item->CHQAMT, 2) }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- สคริปต์ ปุ่มยกเลิกใบเสร็จ -->
<script>
    $('.btn-CnPay').click(function() {
        let id = $(this).data('id');
        let typePay = $(this).data('db');
        let btnPay = $(this).data('btn');
        let fun = 'cancel-pay';

        Swal.fire({
            text: 'ต้องการยกเลิกใบรับ หรือไม่ ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#4CC552',
            cancelButtonColor: '#E55451',
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก',
        }).then((result) => {
            if (result.isConfirmed) {
                try {
                    let link = "{{ route('payments.destroy', 'id') }}";
                    let url = link.replace('id', id);
                    let _token = $('input[name="_token"]').val();

                    $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
                    $.ajax({
                        url: url,
                        method: "delete",
                        data: {
                            _token: _token,
                            typePay: typePay,
                            fun: fun
                        },
                        complete: function(data) {
                            $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                        },
                        success: function(result) {
                            if (result.message == 'success') {
                                let count = (parseFloat($('.' + btnPay).text() - 1));
                                $('.tbPay-' + id).hide(500);
                                $('.' + btnPay).html(count);
                                $('.' + btnPay + 'd-none').html(count);

                                let Sumcount = (parseFloat($('.' + typePay + '-badge').text() - 1));
                                $('.' + typePay + '-badge').html(Sumcount + ' รายการ');

                                Swal.fire({
                                    icon: 'success',
                                    text: 'ยกเลิกใบรับ เรียบร้อย!',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'ล้มเหลว !',
                                    text: 'กรุณาตวจสอบรายการหรือกด Refreash อีกครั้ง !',
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        },
                        error: function(err) {
                            Swal.fire({
                                icon: 'error',
                                title: 'ล้มเหลว !',
                                text: 'กรุณาตวจสอบความถูกต้องอีกครั้ง !',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                } catch (error) {
                    // การจัดการข้อผิดพลาดที่เกิดขึ้นระหว่างเรียกใช้งาน Ajax
                    console.log('เกิดข้อผิดพลาดในการเรียกใช้งาน Ajax: ' + error);
                }
            }
        })
    });
</script>

<!-- สคริปต์ จัดการตัวกระพริบ -->
<script>
    function blinker() {
        $('.prem').fadeOut(1500);
        $('.prem').fadeIn(1500);
    }
    setInterval(blinker, 1500)
</script>
