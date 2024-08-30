@php 
//dd(@$contract,@$contract->PactToCanCont);
@endphp
<div class="row">
    <div class="col-xl-7 col-lg-6 col-md-12 col-sm-12">
        <div class="card mb-3">
            <input type="hidden" name="page" value="terminate-letter">
            <input type="hidden" id="loanType" name="loanType" value="{{@$loanType}}">
            <input type="hidden" id="DataPact_id" name="DataPact_id" value="{{@$contract->id}}">
            <input type="hidden" id="pact_id" name="pact_id" value="{{@$pact->id}}">
            <input type="hidden" id="ID" name="ID" value="{{@$contract->PactToCanCont->id}}">
            <div class="card-body">
                <div class="row g-2 mb-2">
                    <div class="col-4">
                        <div class="input-bx">
                            <input type="text" value="{{ auth()->user()->UserToBranch->NickName_Branch }}" class="form-control LOCAT" required placeholder=" " />
                            <!-- <input type="hidden" name="LOCAT" id="LOCAT" value="{{ auth()->user()->UserToBranch->id_Contract }}" class="form-control LOCAT" required placeholder=" " /> -->
                            <input type="hidden" name="LOCAT" id="LOCAT" value="{{@$contract->LOCAT}}" class="form-control LOCAT" required placeholder=" " />
                            <span>สาขาที่รับ</span>
                            <button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 modal_lg" data-link="{{ route('constants.create') }}?page={{ 'backend' }}&FlagBtn={{ 'LOCAT' }}&modalID={{ 'modal_lg' }}">
                                <i class="dripicons-menu"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-bx">
                            <input type="text" class="form-control LOCATNAME" value="{{ auth()->user()->UserToBranch->Name_Branch }}" readonly/>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-bx">
                            <input type="text" name="CANNO" value="{{(@$contract->PactToCanCont != null) ?@$contract->PactToCanCont->CANNO: @$Billno}}" class="form-control" required placeholder=" " />
                            <span>เลขที่บอกเลิก</span>
                        </div>
                    </div>
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-4">
                        <div class="input-bx">
                            <input type="text" id="CONTNO" name="CONTNO" value="{{@$contract->CONTNO}}" class="form-control" required placeholder=" " required/>
                            <span class="text-danger">เลขที่สัญญา</span>
                            <button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 header_btnSearch">
                                <i class="dripicons-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-bx">
                            <input type="text" name="SDATE" value="{{(@$contract != NULL)?date('d-m-Y',strtotime(@$contract->SDATE)):''}}" class="form-control" required placeholder=" " required/>
                            <span class="text-danger">วันที่ทำสัญญา</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-bx">
                            <input type="date" name="CANDATE" value="{{date('Y-m-d')}}" class="form-control" required placeholder=" " required/>
                            <span>วันที่บอกเลิก</span>
                        </div>
                    </div>
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-4">
                        <div class="input-bx">
                            <input type="text" id="OLDCODE" name="CONTSTAT" value="{{@$contract->CONTSTAT}}" class="form-control OLDCODE" required placeholder=" " />
                            <span>สถานะเดิม</span>
                            <button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 modal_lg" data-link="{{ route('constants.create') }}?page={{ 'backend' }}&FlagBtn={{ 'OLDSTAT' }}&modalID={{ 'modal_lg' }}">
                                <i class="dripicons-menu"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-bx">
                            @php 
                                @$OLD_NAME = \App\Models\TB_Constants\TB_Backend\TB_TYPCONT::Where('CONTTYP',@$contract->CONTSTAT)->first();
                            @endphp
                            <input type="text" id="OLDNAME" value="{{@$OLD_NAME->CONTDESC}}" class="form-control OLDNAME" required placeholder=" " readonly/>
                        </div>
                    </div>
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-4">
                        <div class="input-bx">
                            <input type="text" value="{{(@$contract->PactToCus->DataCusToDataAssetOne->Vehicle_NewLicense != NULL)?@$contract->PactToCus->DataCusToDataAssetOne->Vehicle_NewLicense :@$contract->PactToCus->DataCusToDataAssetOne->Vehicle_OldLicense}}" class="form-control" required placeholder=" " />
                            <span class="text-danger">เลขทะเบียน</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-bx">
                            <input type="text" value="{{@$contract->PactToCus->DataCusToDataAssetOne->Vehicle_Chassis}}" class="form-control" required placeholder=" " />
                            <span class="text-danger">เลขตัวถัง</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-bx">
                            <input type="number" name="TOTPRC" value="{{(@$contract->CODLOAN == 1)?@$contract->TCSHPRC:@$contract->NCSHPRC}}" class="form-control" required placeholder=" " />
                            <span class="text-danger">ราคาขาย</span>
                        </div>
                    </div>
                </div>
                @php
                    if (@$contract->CODLOAN == 1){
                        if(@$contract->CONTTYP == 1 || @$contract->CONTTYP == 2){
                            @$ContBalance = number_format(@$contract->TONBALANCE, 2);
                        }else{
                            @$ContBalance = number_format(@$contract->TOTPRC - @$contract->SMPAY, 2);
                        }
                    }
                    else{
                        @$ContBalance = number_format(@$contract->TOTPRC - @$contract->SMPAY, 2);
                    }
                @endphp
                <div class="row g-2 mb-3">
                    <div class="col-4">
                        <div class="input-bx">
                            <input type="text" value="{{@$contract->PactToCus->Firstname_Cus}}" class="form-control" required placeholder=" " />
                            <span class="text-danger">ชื่อลูกค้า</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-bx">
                            <input type="text" value="{{@$contract->PactToCus->Surname_Cus}}" class="form-control" required placeholder=" " />
                            <span class="text-danger">สกุลลูกค้า</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-bx">
                            <input type="number" name="SMPAY" value="{{ @$contract->SMPAY != null ? str_replace(',','',@$contract->SMPAY) : '' }}" class="form-control" required placeholder=" " />
                            <span class="text-danger">ชำระเงินแล้ว</span>
                        </div>
                    </div>
                </div>
                <div class="row g-2 mb-2 border-top">
                    <div class="col-4">
                        <div class="input-bx">
                            <input type="number" name="TOTBAL" value="{{(@$contract != NULL)?str_replace(',','',@$ContBalance):''}}" class="form-control" required placeholder=" " />
                            <span>ยอดคงเหลือ</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-bx">
                            <input type="number" name="EXP_AMT" value="{{ @$contract->EXP_AMT != null ? str_replace(',','',@$contract->EXP_AMT) : '' }}" class="form-control" required placeholder=" " />
                            <span>ยอดค้างชำระ</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-bx">
                            <input type="number" name="PAYAMT" value="" class="form-control" placeholder=" " />
                            <span>ค่าค้างปรับ</span>
                        </div>
                    </div>
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-4">
                        <div class="input-bx">
                            <input type="text" name="EXP_FRM" value="{{ @$contract->EXP_PRD != null ?(@$contract->EXP_PRD) : '' }}" class="form-control" required placeholder=" " />
                            <span>ค้างงวด</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-bx">
                            <input type="text" name="EXP_TO" value="{{ @$contract->EXP_FRM != null ?(@$contract->EXP_FRM) : '' }}" class="form-control" required placeholder=" " />
                            <span>ค้างจาก</span>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-bx">
                            <input type="text" name="REXP_PRD" value="{{ @$contract->EXP_TO != null ?(@$contract->EXP_TO) : '' }}" class="form-control" required placeholder=" " />
                            <span>ค้างถึง</span>
                        </div>
                    </div>
                </div>
                <div class="row g-2 mb-2">
                    <div class="col-4">
                        <div class="input-bx">
                            <input type="text" id="NEWCODE" name="CAUSE" value="{{(@$contract != null) ?'H' : '' }}" class="form-control NEWCODE" required placeholder=" " />
                            <span class="text-danger">สาเหตุ</span>
                            <button type="button" class="mx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 modal_lg" data-link="{{ route('constants.create') }}?page={{ 'backend' }}&FlagBtn={{ 'NEWSTAT' }}&modalID={{ 'modal_lg' }}">
                                <i class="dripicons-menu"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-bx">
                            @php 
                                @$NEW_NAME = \App\Models\TB_Constants\TB_Backend\TB_TYPCONT::Where('CONTTYP','H')->first();
                            @endphp
                            <input type="text" id="NEWNAME" class="form-control NEWNAME" value="{{(@$contract != null) ?@$NEW_NAME->CONTDESC: '' }}" readonly/>
                        </div>
                    </div>
                </div>
                <div class="row g-2">
                    <div class="col-4">
                        <div class="input-bx">
                            <input type="text" id="PAYFOR_CODE" name="PayCode" value="{{(@$contract != null) ?'600': '' }}" class="form-control PAYFOR_CODE" required placeholder=" " />
                            <span class="text-danger">ชำระค่า</span>
                            <button type="button" class="mmx-0 btn btn-light border border-secondary border-opacity-50 font-size-10 modal_lg" data-link="{{ route('constants.create') }}?page={{ 'backend' }}&FlagBtn={{'PAYFOR'}}&modalID={{ 'modal_lg' }}">
                                <i class="dripicons-menu"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-bx">
                            @php 
                                @$PAYFOR_NAME = \App\Models\TB_Constants\TB_Backend\TB_PAYFOR::Where('FORCODE','600')->first();
                            @endphp
                            <input type="text" id="PAYFOR_NAME" class="form-control PAYFOR_NAME" value="{{(@$contract != null) ?@$PAYFOR_NAME->FORDESC: '' }}" readonly/>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="input-bx">
                            <input type="number" name="TOTUPAY" value="{{(@$contract->PactToCanCont != null) ?@$contract->PactToCanCont->TOTUPAY: ''}}" class="form-control" placeholder=" " required/>
                            <span class="text-danger">จำนวนเงิน</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-5 col-lg-6 col-md-12 col-sm-12">
        <div class="card mb-3 bg-light bg-soft border border-info">
            <div class="card-body pt-2">
                <div class="row mb-0">
                    <div class="col-4"></div>
                    <label for="horizontal-firstname-input" class="col-sm-7 col-form-label fw-bold text-primary text-center">รายการรับชำระล่าสุด</label>
                </div>

                <div class="row mb-2">
                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label fw-bold text-end">วันที่บอกเลิก</label>
                    <div class="col-sm-7">
                        <div class="input-bx" id="datepicker1">
                            <input type="text" name="LASTCANDT" id="LASTCANDT" value="{{(@$contract->PactToCanCont != null)?date('d/m/Y',strtotime(@$contract->PactToCanCont->CANDATE)): '' }}"
                                class="form-control rounded-0 rounded-start text-start" placeholder="วันที่บอกเลิก"
                                data-date-format="dd/mm/yyyy" data-date-container="#datepicker1"
                                data-provide="datepicker" data-date-disable-touch-keyboard="true"
                                data-date-language="th" data-date-today-highlight="true"
                                data-date-enable-on-readonly="true" data-date-clear-btn="true"
                                autocomplete="off" data-date-autoclose="true" required>
                        </div>
                        <!-- <button type="button" class="btn btn-outline-info" style="position: absolute; right: -1.8rem; top: 0; z-index: 1;">
                            <i class="fas fa-calendar-alt"></i>
                        </button> -->
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label fw-bold text-end">วันที่ชำระ</label>
                    <div class="col-sm-7">
                        <div class="input-bx" id="datepicker2">
                            <input type="text" name="PAYDATE" id="DateOccupiedcar2" value="{{(@$contract->PactToCanCont != null) ?date('d/m/Y',strtotime(@$contract->PactToCanCont->PAYDATE)): '' }}"
                                class="form-control rounded-0 rounded-start text-start" placeholder="วันที่ชำระ"
                                data-date-format="dd/mm/yyyy" data-date-container="#datepicker2"
                                data-provide="datepicker" data-date-disable-touch-keyboard="true"
                                data-date-language="th" data-date-today-highlight="true"
                                data-date-enable-on-readonly="true" data-date-clear-btn="true"
                                autocomplete="off" data-date-autoclose="true" required>
                        </div>
                        <!-- <button type="button" class="btn btn-outline-info" style="position: absolute; right: -1.8rem; top: 0; z-index: 1;">
                            <i class="fas fa-calendar-alt"></i>
                        </button> -->
                    </div>
                </div>

                <hr class="border-top border-2">

                <div class="row mb-2">
                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label fw-bold text-end">จำนวนเงิน</label>
                    <div class="col-sm-7">
                        <input type="number" name="PAYMENT" class="form-control" value="{{(@$contract->PactToCanCont != null) ?@$contract->PactToCanCont->PAYMENT: '' }}" placeholder="จำนวนเงิน">
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label fw-bold text-end">ค้างงวด</label>
                    <div class="col-sm-7">
                        <input type="text" name="KEXP_AMT" class="form-control" value="{{(@$contract->PactToCanCont != null) ?@$contract->PactToCanCont->KEXP_AMT: '' }}" placeholder="ค้างงวด">
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label fw-bold text-end">ยอดเงินคงค้าง</label>
                    <div class="col-sm-7">
                        <input type="number" name="KEXP_PRD" class="form-control" value="{{(@$contract->PactToCanCont != null) ?@$contract->PactToCanCont->KEXP_AMT: '' }}" placeholder="ยอดเงินคงค้าง">
                    </div>
                </div>

                <div class="row mb-2">
                    <label for="horizontal-firstname-input" class="col-sm-4 col-form-label fw-bold text-end">หมายเหตุ</label>
                    <div class="col-sm-7">
                        <div class="form-floating">
                            <textarea class="form-control" id="MEMO1" name="MEMO1"  placeholder="Leave a comment here" maxlength="2500" style="height: 7rem;">{{(@$contract->PactToCanCont != null) ?@$contract->PactToCanCont->MEMO1: '' }}</textarea>
                            <!-- <label for="Note_cus" class="fw-bold">บันทึก</label> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(".header_btnSearch,.header_btnSearch2").click(function() {
        $('.data-modal-search').modal('show');
    });
</script>