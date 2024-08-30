<div class="modal-content">
    <div class="d-flex m-3 mb-0">
        <div class="flex-shrink-0 me-2">
            <img src="{{ asset('assets/images/gif/dividends.gif') }}" alt="report" class="avatar-sm"
                style="width:50px;height:50px">
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h5 class="text-primary fw-semibold">สอบถามยอดค้าง </h5>
            <p class="text-muted mt-n1 fw-semibold font-size-12">วันที่ : {{ date('y-m-d') }}</p>
            <p class="border-primary border-bottom mt-n2"></p>
        </div>
        <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
    </div>
    <div class="modal-body px-4" style="">
        <input type="hidden" id="id" value="{{ $id }}">
        <input type="hidden" id="CODLOAN" value="{{ $CODLOAN }}">

        <div class="gap-1 d-flex justify-content-center align-items-center mb-4">

                <div class="" id="datepicker1">
                    <input type="text" value="{{ date('Y-m-d') }}" id="dateSearch"
                        class="form-control rounded-0 rounded-start text-start" placeholder="วันที่ค้นหา"
                        data-date-format="yyyy-mm-dd" data-date-container="#datepicker1"
                        data-provide="datepicker" data-date-disable-touch-keyboard="true"
                        data-date-language="th" data-date-today-highlight="true"
                        data-date-enable-on-readonly="true" data-date-clear-btn="true"
                        autocomplete="off" data-date-autoclose="true" required>
                </div>
                <button type="button" id="searchInt" class="btn btn-primary">ค้นหา <span style="display: none;" class="spinner-search spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span></button>

        </div>
        <div class="row">
            <div class="col">
                <h4 class="card-title mb-4"> <i class="bx bxs-file"></i> รวมยอดค้างชำระ</h4>
                <div class="table-responsive">
                    <table class="table align-middle table-nowrap table">
                        <tbody>
                            <tr>
                                <td style="width: 50px;">
                                    <div class="font-size-22 text-warning">
                                        <i class="bx bxs-info-circle bx-tada"></i>
                                   </div>
                                </td>
                                <td>
                                    <div class="">
                                        <h5 class="font-size-14 mb-0 fw-semibold">ค้างค่างวด</h5>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-end">
                                        <h5 class="font-size-14 text-muted mb-0 fw-semibold"><span id="period">0.00</span> บาท
                                        </h5>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50px;">
                                    <div class="font-size-22 text-warning">
                                        <i class="bx bxs-info-circle bx-tada"></i>
                                   </div>
                                </td>
                                <td>
                                    <div class="">
                                        <h5 class="font-size-14 mb-0 fw-semibold">ค้างค่าปรับ</h5>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-end">
                                        <h5 class="font-size-14 text-muted mb-0 fw-semibold"><span id="int">0.00</span> บาท
                                        </h5>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 50px;">
                                    <div class="font-size-22 text-warning">
                                          <i class="bx bxs-info-circle bx-tada"></i>
                                    </div>
                                </td>
                                <td>
                                    <div class="">
                                        <h5 class="font-size-14 mb-0 fw-semibold">ค้างลูกหนี้อื่น</h5>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-end">
                                        <h5 class="font-size-14 text-muted mb-0 fw-semibold"><span id="aroth">0.00</span> บาท
                                        </h5>
                                    </div>
                                </td>
                            </tr>
                            <tr class=" border border-danger border-2 border-bottom">
                                <td style="width: 50px;">
                                    <div class="font-size-22 text-success">
                                        <i class="bx bxs-flag"></i>
                                    </div>
                                </td>
                                <td>
                                    <div class="">
                                        <h5 class="font-size-14 mb-0 fw-semibold">รวมยอดค้าง</h5>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-end">
                                        <h5 class="font-size-14 text-muted mb-0 fw-semibold"><span id="total">0.00</span> บาท
                                        </h5>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>



    </div>
    <div class="modal-footer">
        <button type="button" id="btn-close" class="btn btn-sm btn-secondary waves-effect waves-light w-sm hover-up"
            data-bs-dismiss="modal" aria-label="Close">
            <span class="d-block d-sm-none"><i class="mdi mdi-close-circle-outline"></i></span>
            <span class="d-none d-sm-block">
                <i class="mdi mdi-close-circle-outline"></i>
                ปิด
            </span>
        </button>
    </div>
</div>
</div>
</div>

<script>
    $('#searchInt').click(()=>{
        $('.spinner-search').show()
        $('#searchInt').prop('disabled',true)
        let url = '{{ route('payments.show',':ID') }}'
        let id = $('#id').val()
        let date = $('#dateSearch').val()
        let CODLOAN = $('#CODLOAN').val()
        $.ajax({
            url : url.replace(':ID',id),
            type : 'GET',
            data : {
                id : id,
                FlagBtn : 'searchDebt',
                date : date,
                CODLOAN : CODLOAN,
                _token : '{{ @CSRF_TOKEN() }}'
            },
            success : (res)=>{
                 $('.spinner-search').hide()
                 $('#searchInt').prop('disabled',false)
                console.log(res);

                let data = [{
                    "ค้างค้างค่างวด" : res.dataPatch.EXP_AMT,
                    "ค้างค่าปรับ" : res.calCloseAC.INTLATEAMT,
                    "ค้างลูกหนี้อื่น" : res.calCloseAC.Aroth,


                }]
                console.table(data)
                let EXP_AMT = parseFloat(res.dataPatch.EXP_AMT) || 0
                let INTLATEAMT = parseFloat(res.calCloseAC.INTLATEAMT) || 0
                let Aroth = parseFloat(res.calCloseAC.Aroth) || 0
                let total = EXP_AMT + INTLATEAMT + Aroth

                $('#period').html(EXP_AMT.toLocaleString())
                $('#int').html(INTLATEAMT.toLocaleString())
                $('#aroth').html(Aroth.toLocaleString())
                $('#total').html(total.toLocaleString())

            },
            error : (err)=>{
                $('.spinner-search').hide()
                 $('#searchInt').prop('disabled',false)
            }
        })
    })
</script>
