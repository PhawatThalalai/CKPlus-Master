@include('public-js.constants')

<div class="modal-content">
	<div class="d-flex m-3 mb-0">
		<div class="flex-shrink-0 me-2">
			<img src="{{ asset('assets/images/gif/dividends.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
		</div>
		<div class="flex-grow-1 overflow-hidden">
			<h5 class="text-primary fw-semibold">รายละเอียดการค้างชำระ (ใบแจ้งหนี้) </h5>
			<p class="text-muted mt-n1 fw-semibold font-size-12">เลขที่เอกสาร : {{ @$runBill }}</p>
			<p class="border-primary border-bottom mt-n2"></p>
		</div>
        <button type="button" class="btn-close" data-bs-toggle="modal" data-bs-target="#{{ @$modalID }}" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>
	<div class="modal-body scroll" style="max-height:450px; overflow-y:scroll;">
        <form id="form-payments">
            <input type="hidden" value="save-paymentInvoice" name="">
            <input type="hidden" value="{{ @$data->id }}" name="" id="id_invoice">
            <input type="hidden" value="{{ @$data->CODLOAN ?? @$contract->CODLOAN}}" name="" id="CODLOAN">
            <input type="hidden" value="{{ @$data->PatchCon_id }}" name="" id="paymentPatch">
            <input type="text" value="{{ @$data->DATENOPAY }}" id="BILLDT">
            <div class="row g-3">
                {{-- left content --}}
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body">
                            <h6 class="card-title">ข้อมูลการรับชำระ</h6>
                            <div class="row g-2 mb-1">
                                <div class="col-4">
                                    <div class="input-bx">
                                        <input type="text" name="LOCATREC" value="{{ auth()->user()->id }}" class="form-control" placeholder=" " readonly />
                                        <span>สาขาที่รับ</span>
                                        <button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10"><i class="dripicons-menu"></i></button>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="input-bx">
                                        <input type="text" class="form-control" value="{{ auth()->user()->UserToBranch->Name_Branch }}" readonly />
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2 mb-1">
                                <div class="col-4">
                                    <div class="input-bx">
                                        <input type="text" name="PAYTYP" id="PAYTYP_CODE"  class="form-control PAYTYP_CODE" required placeholder="" autocomplete="off" />
                                        <span>ชำระโดย</span>
                                        <button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 constant-PAYTYP" data-bs-toggle="modal" data-bs-target="#modal_sd" data-link="{{ route('constants.create') }}?page={{ 'backend' }}&FlagBtn={{ 'PAYTYP' }}&modalID={{ 'modal_xl' }}">
                                            <i class="dripicons-menu"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="input-bx">
                                        <input type="text" id="PAYTYP_NAME"class="form-control PAYTYP_NAME" readonly />
                                    </div>
                                    <div id="PAYTYP_TRAN" class="">
                                        <div class="mb-1 mt-1">
                                            <div class="input-bx">
                                                <input type="date" name="CHQDT" id="CHQDT" class="form-control" />
                                                <span>วันที่โอน</span>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <div class="col">
                                                <div class="input-bx">
                                                    <input type="text" id="PAYINACC_NAME" class="form-control PAYINACC_NAME" readonly placeholder=" " />
                                                    <span>ธนาคาร</span>
                                                    <button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 constant-INACC" data-bs-toggle="modal" data-bs-target="#modal_lg_2" data-link="{{ route('constants.create') }}?page={{ 'backend' }}&FlagBtn={{ 'PAYINACC' }}&modalID={{ 'modal_xl' }}&comType={{ @$contract->CODLOAN }}&zone={{ @$contract->UserZone }}">
                                                        <i class="dripicons-menu"></i>
                                                    </button>
                                                </div>
                                                <input type="hidden" name="PAYINACC" id="PAYINACC_CODE" class="form-control PAYINACC_CODE" title="ธนาคาร" />
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col">
                                                <div class="input-bx">
                                                    <input type="text" id="PAYINACC_NUMBER" class="form-control PAYINACC_NUMBER" readonly placeholder=" " />
                                                    <span>เลขบัญชี</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2 mb-1">
                                <div class="col-4">
                                    <div class="input-bx">
                                        <input type="text" name="PAYFOR" id="PAYFOR_CODE" value="{{ @$data->PAYFOR_CODE }}" class="form-control PAYFOR_CODE" readonly required placeholder=" " />
                                        <span>รหัสชำระ</span>
                                        <button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 " disabled data-bs-toggle="modal" data-bs-target="#modal_sd" data-link="{{ route('constants.create') }}?page={{ 'backend' }}&FlagBtn={{ 'PAYFOR' }}&modalID={{ 'modal_xl' }}" {{ @$contract->CODLOAN == 1 ? 'disabled' : '' }}>
                                            <i class="dripicons-menu"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="input-bx">
                                        <input type="text" id="PAYFOR_NAME" value="{{ @$data->PAYFOR_NAME }}" class="form-control PAYFOR_NAME" readonly />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right content  --}}
                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <span id="ContentTBINS">
                        <div class="loading">
                            <div class="lds-facebook">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </span>
                </div>
            </div>
        </form>
    </div>
    <div class="modal-footer">
        <button type="button" id="receivePay" class="btn btn-sm btn-success waves-effect waves-light w-sm hover-up">
            <span class="d-block d-sm-none"><i class="fas fa-download"></i></span>
            <span class="d-none d-sm-block">
                <i class="fas fa-download icon-save"></i> <span class="spinner-border spinner-border-sm spinner-save" style="display:none;"></span>
                รับชำระ
            </span>
        </button>
        <button type="button" id="printInvoice" onclick="rpPayments({{ @$contract->CODLOAN }})" class="btn btn-sm btn-secondary waves-effect waves-light w-sm hover-up" style="display:none;">
            <span class="d-block d-sm-none"><i class="fas fa-download"></i></span>
            <span class="d-none d-sm-block">
                <i class="fas fa-download icon-save"></i> <span class="spinner-border spinner-border-sm spinner-save" style="display:none;"></span>
                พิมพ์ใบเสร็จ
            </span>
        </button>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#{{ @$modalID }}" data-bs-dismiss="modal" aria-label="Close">ย้อนกลับ</button>

    </div>
</div>



    {{-- กดรับชำระ --}}
    <script>
        $('#receivePay').click(()=>{
        let PAYTYP_CODE = $('#PAYTYP_CODE').val()
        let CHQDT = $('#CHQDT').val()
        let PAYINACC_NAME = $('#PAYINACC_NAME').val()
        let PAYINACC_NUMBER = $('#PAYINACC_NUMBER').val()

        // เช็คค่าชำระโดย
        if(PAYTYP_CODE == ''){
            swal.fire({
                icon: 'warning',
                title: 'ข้อมูลไม่ครบ !',
                text : 'กรุณากรอกข้อมูลการชำระ',
                timer: 2000
            })
            return
        }
        //เช็คเงินโอน
        if(PAYTYP_CODE == '04' && CHQDT == '' && PAYINACC_NAME == '' && PAYINACC_NUMBER == ''){
            swal.fire({
                icon: 'warning',
                title: 'ข้อมูลไม่ครบ !',
                text : 'กรุณากรอกข้อมูลการโอนให้เรียบร้อย',
                timer: 2000
            })
            return
        }
            let arrPay = {}
            let data = {}
                $('#body-payotherINV tr').map(function() {
                var idOth = $(this).find('.idOth').text();
                var payfor = $(this).find('.payfor').text();
                var payamt = $(this).find('.payamt').text();
                var dicint = $(this).find('.dicint').text();

                if (arrPay[payfor] == null)
					arrPay[payfor] = []
					arrPay[payfor].push({
						id: idOth,
						payamt: payamt.replace(/,/g, ''),
						dicint: dicint.replace(/,/g, '') // เพิ่มค่า dicint เข้าไปใน arrPay
					});
            }).get();

            $("#form-payments").serializeArray().map(function(x) {
					data[x.name] = x.value;
			});

            $('#receivePay').prop('disabled',true)
            $.ajax({
					url: '{{ route('payments.store') }}',
					type: 'POST',
					data: {
                        page : 'save-paymentInvoice',
                        arrPay : arrPay,
                        data : data,
                        id : $('#paymentPatch').val(),
                        id_invoice : $('#id_invoice').val(),
                        CODLOAN : $('#CODLOAN').val(),
                        _token : '{{ @CSRF_TOKEN() }}'
                    },
					success: (res) => {
                        $('#receivePay').prop('disabled',true)
                        $('#printInvoice').show()
                        $('#receivePay,#btn-close,.btn-close').hide()
                        $('#btn-back').hide()

                        $('.view-contract').html(res.viewCon)
                        $('.view-tb-duepay').html(res.html)


                        sessionStorage.setItem('reportArr',res.reportArr)


                        swal.fire({
							icon: 'success',
							title: 'สำเร็จ !',
                            text : 'ชำระค่าธรรมเนียมอื่นๆเรียบร้อย',
							timer: 2000
						})
                    },
                    error : (err) => {
                        $('#receivePay').prop('disabled',false)

                    }
            })

        })

    </script>








