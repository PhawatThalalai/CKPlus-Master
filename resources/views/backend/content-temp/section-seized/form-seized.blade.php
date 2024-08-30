@include('components.content-modal.modal-xl-2')
<style>
    .disabled-link {
      pointer-events: none;
      opacity: 0.7;
    }
</style>

<form id="formSeized">
    <input type="text"  id="IDHLD" value="{{ @$data->ContractToHLD->id ?? @$dataSeized->id  }}">
    <input type="hidden" name="CODLOAN" id="CODLOAN" value="{{ @$data->CODLOAN ?? @$dataSeized->CODLOAN  }}">
    <input type="hidden" name="CONTTYP" id="CONTTYP" value="{{ @$dataSeized->PatchContract->CONTTYP  }}">
    <input type="hidden" name="page" value="save-seized">
    <input type="hidden" name="_token" value="{{ @CSRF_TOKEN() }}">
    <input type="hidden" name="DataPact_id" value="{{ @$data->DataPact_id ?? @$dataSeized->dataPact_id  }}">
    <input type="hidden" name="PatchCon_id" value="{{ @$data->id ?? @$dataSeized->PatchCon_id  }}">
    <input type="hidden" name="DataCus_id" value="{{ @$data->DataCus_id ?? @$dataSeized->DataCus_id  }}">
    <input type="hidden" name="asset_id" value="{{ @$data->PatchToPact->ContractToIndentureAsset->IndenAssetToDataOwner->OwnershipToAsset->id ?? @$dataSeized->asset_id  }}">


    <div class="row">
        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-center m-5">
                        <img class="img-fluid" src="{{ URL::asset('assets/images/undraw/undraw_resume_folder.svg') }}" style="height:40vh;" alt="Card image cap">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row g-2 mb-2">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="input-bx">
                                <input type="text" id="CONTNO" name="CONTNO" value="{{ @$data->CONTNO ?? @$dataSeized->CONTNO }}" class="form-control" required placeholder=" " required/>
                                <span class="text-danger">เลขที่สัญญา</span>
                                <button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 addContract"  style="display: {{ @$dataSeized != NULL ? 'none;' : '' }}">
                                    <i class="dripicons-search"></i>
                                </button>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="input-bx">
                                <input type="text" id="CONTNO" name="LOCAT" value="{{ @$data->LOCAT ?? @$dataSeized->LOCAT }}" class="form-control" required placeholder=" " required/>
                                <span class="text-danger">รหัสสาขา</span>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="input-bx">
                                <input type="text" id="" name="Vehicle_Chassis" value="{{ @$data->PatchToPact->ContractToIndentureAsset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Chassis ??  @$dataSeized->Vehicle_Chassis }}" class="form-control" required placeholder=" "/>
                                <span class="text-danger">เลขตัวถัง</span>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="input-bx">
                                <input type="text" name="Vehicle_NewLicense" value="{{ @$dataSeized->Vehicle_NewLicense ?? @$data->PatchToPact->ContractToIndentureAsset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_OldLicense }}" class="form-control" required placeholder=" " required/>
                                <span class="text-danger">เลขทะเบียน</span>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="input-bx">
                                <input type="text" id="CONTNO" name="TOTPRC" value="{{ @$data->TOTPRC ??  @$dataSeized->TOTPRC }}" class="form-control" required placeholder=" " required/>
                                <span class="text-danger">ยอดเงินกู้</span>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="input-bx">
                                <input type="text" name="SMPAY" value="{{ @$data->SMPAY ??  @$dataSeized->SMPAY }}" class="form-control" required placeholder=" " required/>
                                <span class="text-danger">ชำระเงินแล้ว</span>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="input-bx">
                                <input type="text" id="CONTNO" name="BALANCE" value="{{  number_format( ( @$data->TOTPRC -  @$data->TOTDAWN ) -  @$data->SMPAY,2) }}" class="form-control" required/>
                                <span class="text-danger">ยอดคงเหลือ</span>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="input-bx">
                                <input type="text" name="DEBTBALANCE" value="{{  number_format( ( @$data->TOTPRC -  @$data->TOTDAWN ) -  @$data->SMPAY,2) }}" class="form-control" required/>
                                <span class="text-danger">ยอดค้างชำระ</span>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="input-bx">
                                <input type="text" id="" name="AMOUNT" value="{{ @$dataSeized->AMOUNT ?? 0}}" class="form-control" required placeholder=" " required/>
                                <span class="text-danger">จำนวนเงิน</span>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="input-bx">
                                <input type="text" id="" name="DEBTINT" value="{{ @$calCloseAC->INTLATEAMT + @$calCloseAC->PAYFOLLOW + (@$calCloseAC->Aroth ?? 0) }}" class="form-control" required placeholder=" " required/>
                                <span class="text-danger">ค้างค่าปรับ</span>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 my-3">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                            <div class="input-bx">
                                <input type="text" id="EXP_PRD" name="EXP_PRD" value="{{ @$calCloseAC->INTLATEAMT ?? 0 }}" class="form-control" required placeholder=" " required/>
                                <span class="">ค้างค่าปรับ</span>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                            <div class="input-bx">
                                <input type="text" name="EXP_FRM" value="{{ @$calCloseAC->PAYFOLLOW ?? 0 }}" class="form-control" required placeholder=" " required/>
                                <span class="">ค้างค่าติดตาม</span>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                            <div class="input-bx">
                                <input type="text" name="EXP_TO" value="{{ @$calCloseAC->Aroth ?? 0 }}" class="form-control" required placeholder=" " required/>
                                <span class="">ค้างลูกหนี้อื่น</span>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                            <div class="input-bx">
                                <input type="text" id="EXP_PRD" name="EXP_PRD" value="{{@$data->EXP_PRD ??  @$dataSeized->EXP_PRD }}" class="form-control border-info" required placeholder=" " required/>
                                <span class="text-info">ค้างงวด</span>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                            <div class="input-bx">
                                <input type="text" name="EXP_FRM" value="{{ @$data->EXP_FRM ??  @$dataSeized->EXP_FRM }}" class="form-control border-info" required placeholder=" " required/>
                                <span class="text-info">ค้างจาก</span>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                            <div class="input-bx">
                                <input type="text" name="EXP_TO" value="{{ @$data->EXP_TO ??  @$dataSeized->EXP_TO }}" class="form-control border-info" required placeholder=" " required/>
                                <span class="text-info">ค้างถึง</span>
                            </div>
                        </div>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="input-bx">
                                <input type="text" id="CONTSTAT" name="CONTSTAT" value="{{ @$data->CONTSTAT ??  @$dataSeized->CONTSTAT }}" class="form-control" required placeholder=" " />
                                <span class="text-danger">สถานะเดิม</span>
                                <button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 header_btnSearch">
                                    <i class="dripicons-menu"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="input-bx">
                                <input type="date" name="SDATE" value="{{ @$data->SDATE ??  @$dataSeized->SDATE }}" class="form-control" required placeholder=" " required/>
                                <span>วันที่ทำสัญญา</span>
                            </div>
                        </div>
                    </div>
                    <div class="row g-2 mb-2">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="input-bx">
                                <input type="text" name="OLDCODE" id="OLDCODE" value="{{ @$data->OLDCODE ??  @$dataSeized->OLDCODE }}" class="form-control OLDCODE" required="" placeholder=" ">
                                <span class="text-danger">สาเหตุ</span>
                                <button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 constant-PAYFOR" data-link="{{ route('constants.create') }}?page={{ 'backend' }}&FlagBtn={{ 'OLDSTAT' }}&modalID={{ '' }}">
                                    <i class="dripicons-menu"></i>
                                </button>
                            </div>

                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="input-bx mb-2">
                                <input type="text" id="OLDNAME" name="OLDNAME" value="{{ @$data->OLDNAME ??  @$dataSeized->OLDNAME }}" class="form-control OLDNAME" required readonly />
                            </div>
                        </div>
                    </div>

                    {{-- <div class="row g-2 mb-2">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="input-bx">
                                <input type="text" name="PAYFOR_CODE" id="PAYFOR_CODE"  value="{{ @$data->PAYFOR_CODE ??  @$dataSeized->PAYFOR_CODE }}" class="form-control PAYFOR_CODE" required="" placeholder=" ">
                                <span class="text-danger">ชำระค่า</span>
                                <button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 constant-PAYFOR"  data-link="{{ route('constants.create') }}?page={{ 'backend' }}&FlagBtn={{ 'PAYFOR' }}&modalID={{ '' }}">
                                    <i class="dripicons-menu"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="input-bx mb-2">
                                <input type="text" id="PAYFOR_NAME" name="PAYFOR_NAME" value="{{ @$data->PAYFOR_NAME ??  @$dataSeized->PAYFOR_NAME }}" class="form-control PAYFOR_NAME" required readonly />
                            </div>
                        </div>
                    </div> --}}



                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-3 col-md-12 col-sm-12">
            <div class="card mb-3 bg-light bg-soft border border-info h-100">
                <div class="card-body">
                    <div class="row mb-2">
                        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label fw-bold text-end">วันที่ทำสัญญา</label>
                        <div class="col-sm-7">
                            <div class="" id="datepicker1">
                                <input type="text" value="{{ @$data->SDATE ??  @$dataSeized->SDATE }}"  name="SDATE" id=""
                                    class="form-control rounded-0 rounded-start text-start" placeholder="วันที่ทำสัญญา"
                                    data-date-format="dd/mm/yyyy" data-date-container="#datepicker1"
                                    data-provide="datepicker" data-date-disable-touch-keyboard="true"
                                    data-date-language="th" data-date-today-highlight="true"
                                    data-date-enable-on-readonly="true" data-date-clear-btn="true"
                                    autocomplete="off" data-date-autoclose="true" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label fw-bold text-end">วันที่ยึด</label>
                        <div class="col-sm-7">
                            <div class="" id="datepicker1">
                                <input type="text" value="{{ @$data->YDATE == NULL && @$dataSeized->YDATE == NULL ? date('Y-m-d') : @$data->YDATE ?? @$dataSeized->YDATE }}" name="YDATE" id=""
                                    class="form-control rounded-0 rounded-start text-start" placeholder="วันที่บอกเลิก"
                                    data-date-format="yyyy-mm-dd" data-date-container="#datepicker1"
                                    data-provide="datepicker" data-date-disable-touch-keyboard="true"
                                    data-date-language="th" data-date-today-highlight="true"
                                    data-date-enable-on-readonly="true" data-date-clear-btn="true"
                                    autocomplete="off" data-date-autoclose="true" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label fw-bold text-end">วันที่ยึดขาดสุทธิ</label>
                        <div class="col-sm-7">
                            <div class="" id="datepicker1">
                                <input type="text" value="{{ @$dataSeized->NETYDATE }}" name="NETYDATE" id=""
                                    class="form-control rounded-0 rounded-start text-start" placeholder="วันที่บอกเลิก"
                                    data-date-format="yyyy-mm-dd" data-date-container="#datepicker1"
                                    data-provide="datepicker" data-date-disable-touch-keyboard="true"
                                    data-date-language="th" data-date-today-highlight="true"
                                    data-date-enable-on-readonly="true" data-date-clear-btn="true"
                                    autocomplete="off" data-date-autoclose="true" required>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label fw-bold text-end">หมายเหตุ</label>
                        <div class="col-sm-7">
                            <div class="">
                                    <textarea class="form-control" name="memo" id="" rows="7" >{{ @$data->memo ??  @$dataSeized->memo }}</textarea>
                            </div>
                        </div>
                    </div>

                    @if(@$dataSeized->STSSTOCK == 'Y' || @$data->ContractToHLD->STSSTOCK == 'Y')
                        <p class="border-secondary border-bottom py-2"></p>
                        <div class="d-flex justify-content-center align-items-center pt-4">
                            <img class="img-fluid" src="{{ URL::asset('assets/images/seized.svg') }}" style="width:35%" alt="Card image cap">
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col text-end">
            <div class="">
                <button type="button" class="btn btn-dark waves-effect waves-light w-sm searchContract">
                    <i class="mdi mdi-account-search d-block font-size-16"></i> สอบถาม
                </button>
                <span id="btn-content" style="display: {{ @$dataSeized == NULL && @$data->ContractToHLD == NULL ? 'none;' : '' }}">
                    <a type="button" data-link="{{ route('account.create') }}?page={{'CreateToStock'}}&IDHLD={{@$dataSeized->id ?? @$data->ContractToHLD->id}}&CODLOAN={{ @$dataSeized->CODLOAN ?? @$data->CODLOAN }}&CONTNO={{@$dataSeized->CONTNO ?? @$data->CONTNO}}&CONTTYP={{@$dataSeized->PatchContract->CONTTYP }}" id="toStock" class="btn btn-info waves-effect waves-light w-sm modal_md toStock">
                        <i class="mdi mdi-car-arrow-right d-block font-size-16"></i>
                        @if(@$dataSeized->STSSTOCK == 'Y')
                            <span class="textStock">ข้อมูลสต๊อก</span>
                        @else
                            <span class="textStock">นำเข้าสต็อก</span>
                        @endif
                    </a>
                </span>
                <div id="groupPrint" class="btn-group dropup" style="display: {{ @$dataSeized == NULL && @$data->ContractToHLD == NULL ? 'none;' : '' }}">
                    <button type="button" class="btn btn-info waves-effect waves-light w-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" ><i class="mdi mdi-printer-check d-block font-size-16"></i> พิมพ์</button>
                    <div class="dropdown-menu" style="cursor: pointer;">
                        <a class="dropdown-item modal_lg" data-link="{{ route('report-backend.show', 0) }}?page={{'rp-seized'}}&type={{1}}&DataPact={{ @$data->ContractToHLD->DataPact_id ?? @$dataSeized->dataPact_id }}">1. ใบตรวจรับสินค้า</a>
                        <a class="dropdown-item modal_lg" data-link="{{ route('report-backend.show', 0) }}?page={{'rp-seized'}}&type={{2}}&DataPact={{ @$data->ContractToHLD->DataPact_id ?? @$dataSeized->dataPact_id }}">2. ให้ใช้สิทธิซื้อคืน (ผู้เช่าซื้อ)</a>
                        <a class="dropdown-item modal_lg" data-link="{{ route('report-backend.show', 0) }}?page={{'rp-seized'}}&type={{3}}&DataPact={{ @$data->ContractToHLD->DataPact_id ?? @$dataSeized->dataPact_id }}">3. ให้ใช้สิทธิซื้อคืน (ผู้ค้ำประกัน)</a>
                        <a class="dropdown-item modal_lg" data-link="{{ route('report-backend.show', 0) }}?page={{'rp-seized'}}&type={{4}}&DataPact={{ @$data->ContractToHLD->DataPact_id ?? @$dataSeized->dataPact_id }}">4. หนังสือแจ้งขายทอดตลาดรถยึด</a>
                        <a class="dropdown-item modal_lg" data-link="{{ route('report-backend.show', 0) }}?page={{'rp-seized'}}&type={{5}}&DataPact={{ @$data->ContractToHLD->DataPact_id ?? @$dataSeized->dataPact_id }}">5. หนังสือแจ้งให้ทราบการขายทอดตลาด<(ขาดทุน)</a>
                    </div>
                </div>
                <span id="btnStock"></span>

                <button type="button" id="update" class="btn btn-warning waves-effect waves-light w-sm btn-save"  style="display: {{ @$dataSeized == NULL ? 'none;' : '' }}">
                    <i class="mdi mdi-content-save d-block font-size-16"></i> <i class="mdi mdi-spin mdi-loading d-block d-none font-size-16"></i> อัพเดท
                </button>

                <button type="button" id="save" class="btn btn-success waves-effect waves-light w-sm btn-save"  style="display: {{ @$data == NULL && @$data->ContractToHLD == NULL   ? 'none;' : '' }}">
                    <i class="mdi mdi-content-save d-block font-size-16"></i> <i class="mdi mdi-spin mdi-loading d-block d-none font-size-16"></i> บันทึก
                </button>

                <button id="btn-clear" type="button" class="btn btn-danger waves-effect waves-light w-sm" style="display: {{ @$dataSeized == NULL && @$data == NULL ? 'none;' : '' }}">
                    <i class="mdi mdi-book-cancel-outline d-block font-size-16"></i>  {{ @$dataSeized == NULL && @$data->ContractToHLD == NULL ? 'ยกเลิก' : 'เพิ่มใหม่' }}
                </button>

                <button type="button" id="btn-delete" class="btn btn-danger waves-effect waves-light w-sm"  style="display: {{ @$dataSeized == NULL && @$data->ContractToHLD == NULL ? 'none;' : '' }}">
                    <i class="mdi mdi-eraser d-block font-size-16"></i> ลบ
                </button>


            </div>
        </div>
    </div>
</form>


<script>
    $('#btn-clear').click(()=>{
        $('#formSeized input[type=text]').val("")
        $(".toStock , #formSeized button").not(".searchContract,.addContract").hide()
        $('.addContract').show()
    })
</script>

<script>
    $(function(){
        $('.input-bx input').addClass('text-end')
    })
</script>

<script>
    $('.btn-save').click(()=>{
        let dataform = $('#formSeized')
        let validate = validateForms(dataform);
        if(validate){
            $('.mdi-loading').removeClass('d-none')
            $('.mdi-content-save').addClass('d-none')
            $('.btn-save').prop('disabled',true)
            let data = $('#formSeized').serialize()
            $.ajax({
                url : '{{ route('account.store') }}',
                type : 'POST',
                data : data,
                success : (res)=>{
                    $('#toStock,#groupPrint,#update,#btn-delete').show()
                    $('#save,#btn-clear').hide()



                    $('.mdi-loading').addClass('d-none')
                    $('.mdi-content-save').removeClass('d-none')
                    $('.btn-save').prop('disabled',false)
                    console.log(res);
                    $('#btn-content').show().html(`
                    <a type="button" data-link="{{ route('account.create') }}?page={{'CreateToStock'}}&IDHLD=${res.IDHLD}&CODLOAN={{@$data->CODLOAN}}&CONTNO={{@$data->CONTNO}}&CONTTYP={{@$dataSeized->PatchContract->CONTTYP }}" id="toStock" class="btn btn-info waves-effect waves-light w-sm modal_md toStock">
                        <i class="mdi mdi-car-arrow-right d-block font-size-16"></i> <span class="textStock">นำเข้าสต็อก</span>
                    </a>
                    `)
                    swal.fire({
                        icon : 'success',
                        title : 'สำเร็จ !',
                        text : 'บันทึกยึดรอไถ่ถอนเรียบร้อย',
                        timer : 2000
                    })
                },
                error : ()=>{
                    $('.mdi-loading').addClass('d-none')
                    $('.mdi-content-save').removeClass('d-none')
                    $('.btn-save').prop('disabled',false)
                    swal.fire({
                        icon : 'error',
                        title : 'ไม่สำเร็จ !',
                        text : 'บันทึกข้อมูลไม่สำเร็จ',
                        timer : 2000
                    })
                }
            })
        }
    })

    $('#btn-delete').click(()=>{
        let IDHLD = $('#IDHLD').val()
        let url = "{{ route('account.destroy',':ID') }}"
        $.ajax({
                url : url.replace(":ID",IDHLD),
                type : 'DELETE',
                data : {
                    page : 'deleteSeized',
                    CODLOAN : $('#CODLOAN').val(),
                    _token : '{{ @CSRF_TOKEN() }}'
                },
                success : (res)=>{
                    swal.fire({
                        icon : 'success',
                        title : 'สำเร็จ !',
                        text : 'ลบรายการยึดรอไถ่ถอนเรียบร้อย',
                        timer : 2000
                    })
                $('#form-seized').html(res.html)

                },
                error : ()=>{
                    swal.fire({
                        icon : 'error',
                        title : 'ไม่สำเร็จ !',
                        text : 'ลบรายการไม่สำเร็จ',
                        timer : 2000
                    })
                }
            })
    })
</script>

<script>
    $(document).on('click', '.constant-PAYFOR', function(e) {
        e.preventDefault();
        var url = $(this).attr('data-link');

        $('#modal_sd .modal-dialog').empty();
        $('#modal_sd .modal-dialog').load(url, function(response, status, xhr) {
            if (status === 'success') {
                $('#modal_sd').modal('show');
            } else {
                console.log('Load failed');
            }
        });

    });
</script>


<script>
    $(function() {
        $("#CancleBTN").click(function() {
            $('#form_terminate').removeClass('was-validated');
            $('form :input').val('');
            $(".header_btnSearch").removeAttr('disabled',true);
            $("#card-1").removeClass('d-none');
            $("#card-2").addClass('d-none');
        });
    });
</script>

{{-- กดเพิ่มสัญญา --}}
<script type="text/javascript">
    $(".addContract").click(function() {
        var search = $('.header_inputSearch').val();
        var typeSr = 'contract';
        var page_type = $('.page_type').val();
        var page = $('.page').val();
        var pageUrl = 'view-seized';
        var _token = $('input[name="_token"]').val();
        var flagTab = 'add-Broker';
        $('.page_tmp').val('')
        getDataCus(search,typeSr,page,pageUrl,page_type,_token,flagTab)
    });
</script>

{{-- สอบถาม --}}
<script type="text/javascript">
    $(".searchContract").click(function() {
        var search = $('.header_inputSearch').val();
        var typeSr = 'contract';
        var page_type = $('.page_type').val();
        var page = $('.page').val();
        var pageUrl = 'search-seized';
        var _token = $('input[name="_token"]').val();
        var flagTab = 'add-Broker';
        var dataFlag = 'search-seized';
        $('.page_tmp').val('search-seized')
        getDataCus(search,typeSr,page,pageUrl,page_type,_token,flagTab,dataFlag)
    });
</script>








