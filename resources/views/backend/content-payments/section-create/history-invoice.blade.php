    <div class="modal-content">
        <div class="d-flex m-3 mb-0">
            <div class="flex-shrink-0 me-2">
                <img src="{{ asset('assets/images/gif/book.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
            </div>
            <div class="flex-grow-1 overflow-hidden">
                <h5 class="text-primary fw-semibold">ตารางค่างวดและตารางรับชำระ</h5>
                <p class="text-muted mt-n1 fw-semibold font-size-12">( Installment and Payments )</p>
                <p class="border-primary border-bottom mt-n2"></p>
            </div>
            <button type="button" id="closeModalHis" class="btn-close" data-bs-toggle="modal" data-bs-target="#{{ @$modalID }}" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="table-responsive font-size-11" data-simplebar="init">
                <table id="table-installment-schedule" class="table align-middle table-bordered text-nowrap table-hover font-size-10 table-installment-schedule table-payment" cellspacing="0" width="100%">
                    <thead class="table-warning sticky-top" style="line-height: 100%;">
                        <tr class="text-center">
                            <th>#</th>
                            <th>วันที่บันทึก</th>
                            <th>เลขเอกสาร</th>
                            <th>รหัสการชำระ</th>
                            <th>ประเภทการชำระ</th>
                            <th>ยอดรับชำระ</th>
                            <th>ลูกหนี้อื่น</th>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody class="tbody-payment">
                        @foreach ($data as $item )
                        <tr class="text-center {{ $item->STATUSPAY == 'yes' ? 'bg-success bg-soft fw-semibold' : '' }}">
                            <td class="text-center btn-class">
                                <div class="d-flex justify-content-center gap-2">
                                    @if($item->STATUSPAY == 'yes')
                                    <a role="button" class="text-success hover-up" onclick="rpPayments(98039, 2, true)" data-bs-toggle="tooltip" aria-label="พิมพ์ใบเสร็จ">
                                        <i class="mdi mdi-printer-check font-size-16"></i>
                                    </a>
                                    <div class="btn-cancel btn-paynt " data-id="98039" data-codloan="2">
                                        <a role="button" class="text-danger hover-up btn-cancelPay ask-paynt " data-bs-toggle="tooltip" aria-label="แจ้งยกเลิกใบเสร็จ">
                                            <i class="mdi mdi-clipboard-text-off-outline font-size-16"></i>
                                        </a>
                                        <a role="button" class="text-secondary hover-up btn-cancelAsk d-none" data-bs-toggle="tooltip" aria-label="คืนค่า">
                                            <i class="mdi mdi-replay font-size-16"></i>
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </td>
                             <td>{{ $item->created_at }}</td>
                             <td>{{ $item->DOCNO }}</td>
                             <td>{{ $item->PAYFOR_CODE }}</td>
                             <td>{{ $item->PAYFOR_NAME }}</td>
                             <td>{{ $item->INPUTPAY }}</td>
                             <td>{{ $item->DEBTOTH }}</td>
                             <td><i id="btn-selectINV" class="mdi mdi-circle-edit-outline spinnerINV fs-4 text-warning" style="cursor: pointer;" onclick="Viewinvoice({{ $item->id }})"></i> <span class="spinner-border spinner-border-sm spinnerINV" role="status" aria-hidden="true" style="display: none;"></span></td>
                            </tr>
                        @endforeach

                    </tbody>
                    {{-- <tfoot class="table-warning sticky-bottom text-center" style="line-height: 130%;">
                        <tr class="text-center">
                            <th>#</th>
                            <th>สถานะ</th>
                            <th>สาขารับ</th>
                            <th>เลขที่ใบรับ</th>
                            <th>วันที่ชำระ</th>
                            <th>ชำระค่า</th>
                            <th>ชำระโดย</th>
                            <th>ชำระค่างวด</th>
                            <th>ส่วนลด</th>
                            <th>ชำระค่าปรับ</th>
                            <th>ลดค่าปรับ</th>
                            <th>ค่าทวงถาม</th>
                            <th>ชำระสุทธิ</th>
                            <th>วันที่เช็ค</th>
                        </tr>
                    </tfoot> --}}
                </table>
            </div>
        </div>
    </div>

    {{-- เรียกดูใบแจ้งหนี --}}
    <script>

        Viewinvoice = (id) => {
            $("#btn-selectINV").prop('disabled',true)
            $('.spinnerINV').toggle()
            $.ajax({
                url : '{{ route('payments.show',0) }}',
                type : 'GET',
                data : {
                    FlagBtn : 'getActiveINV',
                    flag : 'search',
                    _token : '{{ @CSRF_TOKEN() }}',
                    id : id
                },
                success : (res) =>{
                    $('.spinnerINV').toggle()
                    $("#btn-selectINV").prop('disabled',false)
                    sessionStorage.setItem('TOTBLC',res.TOTBLC)
                    $('#content-form').html(res.html)
                    $('.content-PayOther').html(res.htmlTB)
					$("#btn-newInvoice").show()
                    $('#btn-saveInvoice').hide()
                    $('.btn-next').show().prop('disabled',false)
                    $('#id_invoice').val(res.data.id)
                    $('#paymentPatch').val( $("#PatchCon_id").val())
                    $('#closeModalHis').trigger("click")
                    $('#modal_xl .modal-content').empty();
                },
                error : (err) => {
                    $('.spinnerINV').toggle()
                    $("#btn-selectINV").prop('disabled',false)
                },complete : ()=>{

                }
            })
        }
    </script>
