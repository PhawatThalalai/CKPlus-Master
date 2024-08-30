@include('public-js.constants')

<form id="form-invoice" >

    <input type="hidden" name="DataCus_id" id="DataCus_id">
    <input type="hidden" name="page" value="save-invoice">
    <input type="hidden" name="dateNow" id="dateNow" value="{{ date('Y-m-d') }}">
    <input type="text" name="IDAROTH" id="AROTHR" value="{{@$data["data"]->IDAROTH}}">
    <input type="hidden" name="EXP_FRM" id="EXP_FRM" >
    <input type="hidden" name="EXP_TO" id="EXP_TO" >
    <input type="hidden" name="DOCDATE" id="DOCDATE" value="{{ @$data["data"]->DOCDATE }}" placeholder="วันที่สร้างบิล" alt="วันที่สร้างบิล">
    <input type="hidden" name="TOTALPAYMENTS" id="TOTALPAYMENTS" value="{{ @$data["data"]->TOTALPAYMENTS }}" placeholder="ยอดที่ต้องชำระ" alt="ยอดที่ต้องชำระ">
    <input type="hidden" name="PERIODDEBT" id="PERIODDEBT" value="{{ @$data["data"]->PERIODDEBT }}" placeholder="ยอดจาก Seaech" alt="ยอดจาก Seaech">
    <input type="hidden" name="INTLATEAMT" id="INTLATEAMT" value="{{ @$data["data"]->INTLATEAMT }}" placeholder="ค้างเบี้ยปรับ"  alt="ค้างเบี้ยปรับ">
    <input type="hidden" name="FOLLOWAMT" id="FOLLOWAMT" value="{{ @$data["data"]->FOLLOWAMT }}" placeholder="ค้างค่าทวงถาม" alt="ค้างค่าทวงถาม">
    <input type="text" name="DEBTOTH" id="DEBTOTH" value="{{ @$data["data"]->TOTOTH }}" placeholder="ลูกหนี้อื่น" alt="ลูกหนี้อื่น">
    <input type="hidden" value="0" name="DSCINT" id="DSCINT" value="{{ @$data["data"]->DSCINT }}" placeholder="ส่วนลดเบี้ยปรับ" alt="ส่วนลดเบี้ยปรับ">
    <input type="hidden" value="0" name="DSCPAYFL" id="DSCPAYFL" value="{{ @$data["data"]->DSCPAYFL }}" placeholder="ส่วนลดค่าทวงถาม" alt="ส่วนลดค่าทวงถาม">
    <input type="hidden" name="B_INTAMT" id="B_INTAMT" value="{{ @$data["data"]->B_INTAMT }}" placeholder="เบี้ยปรับ" alt="เบี้ยปรับ">
    <input type="hidden" name="PAYFOLLOW" id="PAYFOLLOW" value="{{ @$data["data"]->PAYFOLLOW }}" placeholder="ค่าทวงถาม" alt="ค่าทวงถาม">
    <input type="hidden" name="TOTBLCOTH" id="TOTBLCOTH" value="{{ @$data["data"]->TOTBLC }}" placeholder="ยอดหลังหักลูกหนี้อื่น" alt="ยอดหลังหักลูกหนี้อื่น">
    <input type="hidden" name="PAYAMT" id="PAYAMT" value="{{ @$data["data"]->PAYAMT }}" placeholder="ยอดหลังหักค่าปรับและค่าทวงถาม" alt="ยอดหลังหักค่าปรับและค่าทวงถาม">
    <input type="hidden" name="OUTSBL" id="OUTSBL" value="{{ @$data["data"]->OUTSBL }}" placeholder="เงินค้างงวด" alt="เงินค้างงวด">
    <input type="hidden" id="deleted_at" value="{{ @$data["data"]->deleted_at }}" placeholder="deleted_at" alt="deleted_at">
    <input type="hidden" id="STATUSPAY" value="{{ @$data["data"]->STATUSPAY }}" placeholder="STATUSPAY" alt="STATUSPAY">
    <input type="hidden" name ="CAPITALBLVAL" id="CAPITALBLVAL" value="{{ @$data["data"]->CAPITALBLVAL }}" placeholder="CAPITALBLVAL" alt="CAPITALBLVAL">



    <div class="container mt-n2">
        <p class="text-muted mb-2 fw-semibold text-decoration-underline"><i class="mdi mdi-wallet me-1"></i> งวดการชำระ</p>
        <div class="row mb-2">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="row g-1">
                    <div class="col-6">
                        <div class="input-bx">
                            <input type="date" name="DATENOPAY" id="DATENOPAY" value="{{ date('Y-m-d') }}" min="{{ date('Y-m-d') }}" class="form-control" required placeholder=" " />
                        </div>
                    </div>
                    <div class="col-6 d-grid">
                        <button type="button" class="btn btn-info btn_date">ค้นหา <i class="bx bx-search-alt-2 icon-dateSearch bx-tada"></i><span class="spinner-border spinner-border-sm spinner-dateSearch" style="display: none;"></span></button>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 d-grid">
                @if(@$data['FLAGINV'] == true)
                <div class="alert alert-warning d-flex align-items-center" role="alert">
                    <span class="fw-semibold"><i class="bx bxs-info-circle"></i> รายการใบแจ้งหนี้ประจำวันที่ยังไม่ได้ใช้งาน
                        <span id = "getIctiveInv" style="cursor: pointer;"><u>ดูรายการ</u><span class="spinner-border spinner-border-sm spinnerINV" role="status" aria-hidden="true" style="display: none;"></span></span>
                        <div class="spinner-border spinner-border-sm" id="spinner-view" style="display: none;"></div>
                    </span>
                </div>
                @endif
            </div>
        </div>

        <span id="formStyle">
            {{-- search invoice --}}
            <div class="row mb-3 g-3">
                <div class="col-sm-12 col-xl-6 col-lg-12 col-md-12 text-center">
                    <div class="card shadow-sm h-100 ">
                        <div class="card-body ">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 text-center">
                                    <div class="text-warning">
                                        <i class="bx bx-wallet fs-2"></i>
                                    </div>
                                    <p class="text-muted mb-2 fs-6 fw-semibold">ยอดที่ต้องชำระ</p>
                                    <p>
                                        <span id="TOTALPAYMENT" class="fs-5"> {{ @$data['data']->TOTALPAYMENTS ?? 0.00 }} </span>
                                    </p>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 text-center">
                                    <div class="text-warning">
                                        <i class="bx bx-dollar-circle fs-2"></i>
                                    </div>
                                    <p class="text-muted mb-2 fs-6 fw-semibold">ยอดคงเหลือ</p>
                                    <p>
                                        <span class="fs-5" id="CAPITALBL">
                                            {{ @$data['data']->CAPITALBLVAL ?? 0.00 }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-xl-6 col-lg-12 col-md-12">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <p class="text-muted mb-2 fw-semibold text-decoration-underline"><i class="mdi mdi-wallet me-1"></i> รวมรายละเอียดการชำระ</p>
                            <table class="table table-striped table-sm mb-0">
                                <tr>
                                    <th>เงินค้างงวด</th>
                                    <td class="text-end OutstandingBalance"><span id="fs-6"> {{ @$data['data']->OUTSBL ?? 0.00 }} </span> บาท</td>
                                </tr>
                                <tr>
                                    <th>ค้างเบี้ยปรับ</th>
                                    <td class="text-end"><span class="INTLATEAMT fs-6"> {{ @$data['data']->INTLATEAMT ?? 0.00 }}</span> บาท</td>
                                </tr>
                                <tr>
                                    <th>ค้างค่าทวงถาม</th>
                                    <td class="text-end"><span class="FOLLOWAMT fs-6"> {{ @$data['data']->FOLLOWAMT ?? 0.00 }}</span> บาท</td>
                                </tr>
                                <tr>
                                    <th>ค้างลูกหนี้อื่น <i><small class="text-mute">( ค่าลงพื้นที่,ค่าติดตาม )</small></i> </th>
                                    <td class="text-end fs-6"><span class="DEBTOTH"> {{ @$data['data']->DEBTOTH ?? 0.00 }}</span> บาท</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            
            
            <div class="row g-3">
                <div class="col-sm-12 col-xl-6 col-lg-12 col-md-12 text-center">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <div class="row g-1 mt-1">
                                    <p class="text-muted mb-2 mt-2 fw-semibold"><i class="mdi mdi-wallet me-1"></i>รหัสชำระ</p>
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-1">
                                        <div class="input-bx">
                                            <input type="text" name="PAYFOR_CODE" id="PAYFOR_CODE" data-index="1" onClick="this.setSelectionRange(0, this.value.length)" class="form-control PAYFOR_CODE nextInputform" value="{{ @$data["data"]->PAYFOR_CODE ?? 0 }}"  required placeholder=" " autocomplete = "off" />
                                            <span>รหัสชำระ</span>
                                            <button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 modal-constant constant-PAYTYP" data-bs-toggle="modal" data-bs-target="#modal_sd" data-link="{{ route('constants.create') }}?page={{ 'backend' }}&FlagBtn={{ 'PAYFOR' }}&modalID={{ 'modal_xl_2' }}">
                                                <i class="dripicons-menu"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-1">
                                        <div class="input-bx">
                                            <input type="text" id="PAYFOR_NAME" name="PAYFOR_NAME" value="{{ @$data["data"]->PAYFOR_NAME }}" class="form-control PAYFOR_NAME "readonly />
                                        </div>
                                    </div>
                                    <p class="text-muted mb-2 mt-2 fw-semibold"><i class="mdi mdi-wallet me-1"></i>ข้อมูลการรับชำระ</p>
                                    <div class="row g-1">
                                        <div class="col-xl col-lg col-md-12 col-sm-12 mb-1">
                                            <div class="input-bx">
                                                <input type="text" onClick="this.setSelectionRange(0, this.value.length)" name="INPUTPAY" id="INPUTPAY" data-index="2" class="form-control calPay clearValue text-end nextInputform SSinput calpayments" value="{{ @$data["data"]->INPUTPAY ?? 0 }}" autocomplete="off"/>
                                                <span class="fw-semibold">ยอดชำระ</span>
                                            </div>
                                        </div>
                                        <div class="col-xl col-lg col-md-12 col-sm-12 mb-1 contentDisc" style="display:none;">
                                            {{-- <div class="input-bx">
                                                <input type="text" onClick="this.setSelectionRange(0, this.value.length)" name="DISCCLOSEAC" id="DISCCloseAC" class="form-control clearValue text-end nextInputform SSinput calpayments caldsc border border-danger" value="{{ @$data["data"]->DISCCLOSEAC ?? 0 }}" required="" readonly autocomplete="off" />
                                                <span class="text-danger">ส่วนลดปิดบัญชี</span>

                                            </div> --}}
                                            <div class="input-bx">
                                                <input type="text" name="DISCCLOSEAC" id="DISCT" class="form-control text-end border-danger clearValue nextInputform SSinput calpayments  DISCT"
                                              title="ส่วนลดปิดบัญชี" placeholder=" " oninput="" autocomplete="off" />
                                                <span class="text-danger">ส่วนลดปิดบัญชี</span>
                                                <button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10">บาท</button>
                                                <button type="button" id="btn_sh_disct" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-14 " data-link="{{ route('payments.show', @$data["contract"]->id) }}?FlagBtn={{ 'disACtoModal' }}&CODLOAN={{ @$data["contract"]->CODLOAN }}&datePay={{ date('Y-m-d') }}">
                                                    <i class="bx bx-search-alt text-info"></i>
                                                </button>
                                               </div>
                                        </div>
                                    </div>
                                    <div class="row g-1">
                                    </div>
                                    <div class="row g-1" id="discount-content">
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-1">
                                            <div class="input-bx">
                                                <input type="text" onClick="this.setSelectionRange(0, this.value.length)" name="" onblur="$('#DSCINT').val( $(this).val() )" id="DISCB_INTAMT" data-index="3" class="form-control calpayments clearValue caldsc text-end nextInputform SSinput border border-danger" value="0" required="" autocomplete="off" />
                                                <span class="text-danger">ส่วนลดเบี้ยปรับ</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-1">
                                            <div class="input-bx">
                                                <input type="text" onClick="this.setSelectionRange(0, this.value.length)" name="" id="DISCPAYFOLLOW" onblur="$('#DSCPAYFL').val( $(this).val() )" data-index="4" class="form-control calpayments clearValue caldsc text-end nextInputform SSinput border border-danger" value="0" autocomplete="off" />
                                                <span class="text-danger">ส่วนลดค่าทวงถาม</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-1">
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-1">
                                            <div class="input-bx">
                                                <input type="text" onClick="this.setSelectionRange(0, this.value.length)" name="DISCAROTH" id="DISCAROTH"  class="form-control cal-oth clearValue text-end nextInputform SSinput border border-danger" value="0" required="" autocomplete="off" readonly/>
                                                <span class="text-danger">ส่วนลดลูกหนี้อื่น</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-1">
                                            <div class="input-bx">
                                                <input type="number" name="TOTBLC" id="TOTBLC" class="form-control clearValue text-end SSinput" value="{{ @$data["data"]->TOTBLC }}"  autocomplete="off" />
                                                <span class="fw-semibold">ยอดชำระ + ส่วนลด</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-1 d-none">
                                            <div class="input-bx">
                                                <input type="number" name="TOTPAY" id="TOTPAY" class="form-control clearValue text-end SSinput" value="{{ @$data["data"]->TOTPAY }}"  autocomplete="off" />
                                                <span class="fw-semibold">TOTPAY</span>
                                            </div>
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-1">
                                            <div class="input-bx">
                                                <input type="number" name="NETBALANCE" id="NETBALANCE" class="form-control clearValue text-end SSinput" value="{{ @$data["data"]->NETBALANCE }}"  autocomplete="off" readonly/>
                                                <span class="fw-semibold">คงเหลือสุทธิ</span>
                                            </div>
                                        </div>

                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 mb-1">
                                            <div class="input-bx">
                                                <input type="number" name="HLDCASH" id="HLDCASH" class="form-control clearValue text-end SSinput" value="{{ @$data["data"]->NETBALANCE }}"  autocomplete="off" readonly/>
                                                <span class="fw-semibold">เงินตั้งพัก</span>
                                            </div>
                                        </div>
                                    </div>

                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row g-1 elementCal mt-1">
                                <div class="col text-center d-grid">
                                    <button type="button" data-index="5" class="btn btn-outline-danger btn-sm waves-effect waves-light rounded-pill  calInvoice btn-blocked ">
                                        <div class="spinner-border spinner-border-sm spinner-cal " role="status" style="display:none;"> </div>
                                        <span class="icon-cal">
                                            <i class="bx bx-calculator font-size-14 bx-tada"></i>
                                        </span>
                                        คำนวณ
                                    </button>
                                </div>
                                <div class="col text-center d-grid">
                                    <button type="button" id="btn-clear" class="btn btn-secondary btn-sm waves-effect waves-light rounded-pill btn-blocked">
                                        <span class="">
                                            <i class="bx bxs-eraser font-size-14"></i>
                                            คืนค่า
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-6 col-lg-12 col-md-12">
                    <span id="ContentTBINS">
                        <div class="card shadow-sm h-100 bg-light">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">
                                        <div id="contentTBAroth"></div>
                                    </div>
                                </div>
                                <div class="content-PayOther"></div>
                            </div>
                        </div>
                    </span>
                </div>
            </div>
        </span>
    </div>

</form>

<script>
    $("#btn_sh_disct").click(function(e) {
   var url = $(this).attr('data-link');
   $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **

   // $('#modal_sd .modal-dialog').empty().addClass('modal-dialog-centered');
   $('#modal_sd .modal-dialog').empty();
   $('#modal_sd .modal-dialog').load(url, function(response, status, xhr) {
    if (status === 'success') {
     $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **

     let zindex = parseInt($(".modal:visible").css('z-index'));

     $('#modal_sd').css('z-index', zindex + 10).addClass('modal-OTP');
     $('.modal-backdrop').not('.modal-stack').css('z-index', zindex + 9).addClass('modal-stack');

     // var zIndex = 1060 + (10 * $('.modal:visible').not(this).length);
     // $(this).css('z-index', zIndex);
     // setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack'));

     $('#modal_sd').modal('show');
    } else {
     // console.log('Load failed');
    }
   });
  });



  $('#modal_sd').on('hidden.bs.modal', function() {
   if ($(this).find('modal-OTP')) {
    let zindex = parseInt($(".modal:visible").css('z-index'));
    $('.modal-backdrop.modal-stack').css('z-index', zindex - 1).removeClass('modal-stack');
   }
  });
</script>







