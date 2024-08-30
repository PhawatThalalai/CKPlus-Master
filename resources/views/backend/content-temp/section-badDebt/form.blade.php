<form id="bad-debtForm" class="needs-validation" novalidate>
    <input type="hidden" class="form-control" name="CODLOAN" value="{{ @$data->CODLOAN }}">
    <input type="hidden"class="form-control" name="loanType" value="{{@$data->CONTTYP }}" required placeholder=" " />
    <input type="hidden"class="form-control" name="dataPact_id"value="{{@$data->DataPact_id }}" required placeholder=" " />
    <input type="hidden"class="form-control" name="PatchCon_id"value="{{@$data->id }}" required placeholder=" " />
    <input type="hidden" class="form-control" name="Firstname" value="{{ @$data->PactToCus->Firstname_Cus }}"required placeholder=" " />
    <input type="hidden" class="form-control" name="Lastname" value="{{ @$data->PactToCus->Surname_Cus }}"required placeholder=" " />
    <input type="hidden" class="form-control" name="DataCus_id" value="{{ @$data->DataCus_id }}"required placeholder=" " />

    <input type="hidden" name="page" value="bad-dept">
    <input type="hidden" name="_token" value="{{ @CSRF_TOKEN() }}">
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
                            <div class="mb-2 input-bx">
                                <input type="text"class="form-control" name="CONTNO"
                                    value="{{ @$data->CONTNO }}" required placeholder=" " />
                                <span class="text-danger">เลขที่สัญญา</span>
                                <button type="button"
                                    class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 addContract">
                                    <i class="dripicons-search"></i>
                                </button>

                            </div>
                            <div class="mb-2 input-bx">
                                <input type="text"class="form-control" name="Vehicle_License"
                                    value="{{ @$data->Vehicle_License ?? @$data->PatchToPact->ContractToIndentureAsset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_OldLicense }}"
                                    required placeholder=" " />
                                <span class="text-danger">เลขทะเบียน</span>

                            </div>

                            <div class="mb-2 input-bx">
                                <input type="text" class="form-control" name="name_cus"
                                    value="{{ @$data->PactToCus->Firstname_Cus ?? @$data->Firstname }} {{ @$contract->PactToCus->Surname_Cus ?? @$data->Lastname }}"
                                    required placeholder=" " />
                                <span>ชื่อ-นามสกุล</span>

                            </div>
                            <div class="mb-2 input-bx">
                                <input type="text" class="form-control" name="PRICE"
                                    value="{{ number_format(@$data->TCSHPRC ?? @$data->PRICE, 2) }}" required
                                    placeholder=" " />
                                <span>ราคาขาย</span>

                            </div>
                            <div class="mb-2 input-bx">
                                <input type="text" class="form-control" name="TOTSMACC" value="{{ @$data->TOTSMACC }}" required placeholder=" " />
                                <span class="text-danger">มูลค่าคงเหลือตามบัญชี</span>

                            </div>
                            <div class="mb-2 input-bx">
                                <input type="number" class="form-control" name="REMAININT" value="{{ @$data->REMAININT }}" required placeholder=" " />
                                <span class="text-danger">ดอกผลคงเหลือ</span>

                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <div class="mb-2 input-bx">
                                <input type="text"class="form-control LOCAT" name="LOCAT"
                                    value="{{ @$data->LOCAT }}" required
                                    placeholder=" " />
                                <span class="text-danger">รหัสสาขา</span>
                                <button type="button"
                                    class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 modal_lg"
                                    data-link="{{ route('constants.create') }}?page={{ 'backend' }}&FlagBtn={{ 'LOCAT' }}&modalID={{ 'modal_lg' }}">
                                    <i class="dripicons-menu"></i>
                                </button>
                            </div>
                            <div class="mb-2 input-bx">
                                <input type="text" name="Vehicle_Chassis"
                                    value="{{ @$data->PatchToPact->ContractToIndentureAsset->IndenAssetToDataOwner->OwnershipToAsset->Vehicle_Chassis ??  @$data->Vehicle_Chassis }}"
                                    class="form-control" required placeholder=" " />
                                <span class="text-danger">เลขตัวถัง</span>
                            </div>
                            <div class="mb-2 input-bx">
                                <input type="text" name="SMPAY"
                                    value="{{ @$data->SMPAY != null ? number_format(@$contract->SMPAY, 0) : '' }}"
                                    class="form-control" required placeholder=" " />

                                <span class="text-danger">ชำระเงินแล้ว</span>
                            </div>
                            <div class="mb-2 input-bx">
                                <input type="text" name="EXP_AMT"
                                    value="{{ @$data->EXP_AMT != null ? number_format(@$contract->EXP_AMT, 0) : '' }}"
                                    class="form-control" required placeholder=" " />
                                <span class="text-danger">ยอดค้างชำระ</span>
                            </div>
                            <div class="mb-2 input-bx">
                                <input type="text" name="TYPEBDEBT" value="{{ @$data->TYPEBDEBT }}" class="form-control" required placeholder=" " />
                                <span class="text-danger">ประเภทหนี้สูญ</span>
                            </div>
                            <div class="mb-2 input-bx">
                                <input type="text" class="form-control" name="PRICEASST"
                                    value="{{ number_format(@$data->ContractToIndentureAsset->IndenAssetToDataOwner->Price_Asset ?? @$data->PRICEASST, 2) }}"
                                    required placeholder=" " />
                                <span>ราคาทุนประเมิน</span>
                            </div>
                        </div>
                    </div>
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
                                <input type="text" value="{{ @$data->SDATE }}"  name="SDATE" id=""
                                    class="form-control rounded-0 rounded-start text-start" placeholder="วันที่ทำสัญญา"
                                    data-date-format="dd/mm/yyyy" data-date-container="#datepicker1"
                                    data-provide="datepicker" data-date-disable-touch-keyboard="true"
                                    data-date-language="th" data-date-today-highlight="true"
                                    data-date-enable-on-readonly="true" data-date-clear-btn="true"
                                    autocomplete="off" data-date-autoclose="true">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="horizontal-firstname-input" class="col-sm-4 col-form-label fw-bold text-end">วันที่บันทึกหนี้สูญ</label>
                        <div class="col-sm-7">
                            <div class="" id="datepicker1">
                                <input type="text" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" name="DATEBDEBT" id=""
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
                                    <textarea class="form-control" name="MEMO" id="productdesc" rows="7" >{{ @$data->memo ??  @$dataSeized->memo }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</form>



{{-- กดเพิ่มสัญญา --}}
<script type="text/javascript">
    $(".addContract").click(function() {
        var search = $('.header_inputSearch').val();
        var typeSr = 'contract';
        var page_type = $('.page_type').val();
        var page = $('.page').val();
        var pageUrl = 'bad-debt';
        var _token = $('input[name="_token"]').val();
        var flagTab = 'add-Broker';
        var dataFlag = 'bad-debt';
        $('.page_tmp').val('')
        getDataCus(search,typeSr,page,pageUrl,page_type,_token,flagTab,dataFlag)
    });
</script>



