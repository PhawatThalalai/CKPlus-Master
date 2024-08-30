<style>
    .expens-popover {
      --bs-popover-max-width: 300px;
      --bs-popover-border-color: var(--bs-warning);
      --bs-popover-header-bg: var(--bs-warning);
      --bs-popover-header-color: var(--bs-white);
      --bs-popover-body-padding-x: 1rem;
      --bs-popover-body-padding-y: .5rem;
    }
    </style>


    <div class="">
        <div class="">
            <div class="">
                <form id="formExpenses">
                    <!-- hidden input -->
                    <input type="hidden" value="saveExpenses" name="func" id="func">
                    <input type="hidden" value="{{@csrf_token()}}" name = "_token">
                    <input type="hidden" value="{{  @$data->ContractToDataCusTags->DataCus_id }}" name="Customer_id">
                    <input type="hidden" value="{{ @$data->ContractToDataCusTags->id }}" name="DataTag_id">
                    <input type="hidden" value="{{ @$data->id }}" name="PactCon_id" >
                    <input type="hidden" value="{{ @$data->ContractToOperated->id }}" id="idExp">
                    <input type="hidden" value="{{  @$data->ContractToDataCusTags->Type_Customer }}" id="checkStausCus">
                    <div class="row g-2">
                        {{-- left content --}}
                        <div class="col-xl col-lg-4 col-md-12 col-sm-12 mb-2">
                            <div class="card border border-2 border-light h-100">
                                <div class="card-body">
                                    <div class="row g-1 d-none">
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label fw-semibold fs-6">ยอดจัด</label>
                                                <input type="text" value="{{ number_format(@$data->ContractToCal->Cash_Car,2) }}" name="Cash_Car" onClick="this.setSelectionRange(0, this.value.length)" class="form-control  textSize-13 Cash_Car_cal  bg-light " placeholder="ยอดปิดบัญชี">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label fw-semibold fs-6">ค่าดำเนินการ</label>
                                                <input type="text" value="{{ number_format(@$data->ContractToCal->Process_Car,2) }}" onClick="this.setSelectionRange(0, this.value.length)" class="form-control  textSize-13  bg-light" placeholder=" ค่าดำเนินการ" readonly style="cursor: no-drop">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-1">
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label fw-semibold fs-6">พรบ.</label>
                                                <input type="text" value="{{ number_format(@$data->ContractToOperated->Act_Price,2)}}" onClick="this.setSelectionRange(0, this.value.length)" name="Act_Price" id="Act_Price" class="form-control  textSize-13 Act_Price Act_Price_cal " placeholder="พรบ" >
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label fw-semibold fs-6">ภาษี.</label>
                                                <input type="text" value="{{ number_format(@$data->ContractToOperated->Tax_Price,2) }}" onClick="this.setSelectionRange(0, this.value.length)" name="Tax_Price" id="Tax_Price" class="form-control  textSize-13 Tax_Price Tax_Price_cal " placeholder="ภาษี">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-1">
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label fw-semibold fs-6">ประเมิน</label>
                                                <input type="text" value="{{ number_format(@$data->ContractToOperated->Evaluetion_Price,2) }}" onClick="this.setSelectionRange(0, this.value.length)" name="Evaluetion_Price" id="Evaluetion_Price" class="form-control  textSize-13 Evaluetion_Price Evaluetion_Price_cal " placeholder="ค่าประเมิน" >
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label fw-semibold fs-6">อากร</label>
                                                <input type="text" value="{{ number_format(@$data->ContractToOperated->Duty_Price,2) }}" onClick="this.setSelectionRange(0, this.value.length)" name="Duty_Price" id="Duty_Price" class="form-control  textSize-13 Duty_Price Duty_Price_cal " placeholder=" อากร">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-1">
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label fw-semibold fs-6">ประกันรถ</label>
                                                <input type="text" value="{{number_format(@$data->ContractToOperated->P2_Price,2)}}" onClick="this.setSelectionRange(0, this.value.length)" name="P2_Price" id="P2_Price" class="form-control  textSize-13 P2_Price P2_Price_cal " placeholder="ซื้อ ป2+,ป1">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label fw-semibold fs-6">ประกัน PA</label>
                                                <input type="text" value="{{ number_format( @$data->ContractToOperated->id == NULL ? @$Insurance_PA : @$data->ContractToOperated->Insurance_PA,2) }}" onClick="this.setSelectionRange(0, this.value.length)" name="Insurance_PA"  class="form-control  textSize-13 Insurance_PA bg-light" placeholder="ประกัน PA" readonly style="cursor: no-drop"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-1">
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label fw-semibold fs-6">ปิดบัญชี ณ ที่</label>
                                                <input type="text" value="{{@$data->ContractToOperated->AccountClose_Place }}" class="form-control  textSize-13  " onClick="this.setSelectionRange(0, this.value.length)" name="AccountClose_Place" id="AccountClose_Place" placeholder="ปิดบัญชี ณ ที่" />
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label fw-semibold fs-6">การผ่อน</label>
                                                <select type="text" class="form-select textSize-13 Installment"  name="Installment" id="Installment">
                                                    <option value="" selected>-- การผ่อน --</option>
                                                    <option value="เจ้าของผ่อนเอง" {{ (@$data->ContractToOperated->Installment == 'เจ้าของผ่อนเอง') ? 'selected' : '' }}>เจ้าของผ่อนเอง</option>
                                                    <option value="เจ้าของไม่ได้ผ่อนเอง" {{ (@$data->ContractToOperated->Installment == 'เจ้าของไม่ได้ผ่อนเอง') ? 'selected' : '' }}>เจ้าของไม่ได้ผ่อนเอง</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2 g-1">
                                        <div class="col-lg-12">
                                            <div>
                                                <label class="form-label fw-semibold textSize-13">โอนเงินให้ลูกค้าล่วงหน้า</label>
                                                <input type="text" value="{{@$data->ContractToOperated->ReceiveCashBefore }}" class="form-control  textSize-13  " onClick="this.setSelectionRange(0, this.value.length)" name="ReceiveCashBefore" id="ReceiveCashBefore" placeholder="รับเงินสดล่วงหน้า" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         {{-- right content --}}
                        <div class="col-xl col-lg-4 col-md-12 col-sm-12 mb-2">
                            <div class="card border border-2 border-light h-100">
                                <div class="card-body">
                                    <div class="row g-1">
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label fw-semibold fs-6">ยอดปิดบัญชี</label>
                                                <input type="text" value="{{ number_format(@$data->ContractToOperated->AccountClose_Price,2) }}" name="AccountClose_Price"  class="form-control  textSize-13 AccountClose_Price_cal  {{@$statusClose == false ? 'bg-light' : ''}}" placeholder="ยอดปิดบัญชี" {{@$statusClose == false ? 'readonly' : ''}} style="{{@$statusClose == false ? 'cursor:no-drop' : ''}}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label fw-semibold fs-6">ค่าปิดบัญชี</label>
                                                <input type="text" value="{{ number_format(@$data->ContractToOperated->AccountClose_Price_fee) }}" onClick="this.setSelectionRange(0, this.value.length)" name="AccountClose_Price_fee"  class="form-control  textSize-13 AccountClose_Price_fee AccountClose_Price_fee_cal {{@$statusClose == false ? 'bg-light' : ''}}" placeholder="ค่าดำเนินการปิดบัญชี" {{@$statusClose == false ? 'readonly' : ''}} style="{{@$statusClose == false ? 'cursor:no-drop' : ''}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-1">
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label fw-semibold fs-6">คชจ-ขนส่ง</label>
                                                <input type="text" value="{{ number_format(@$data->ContractToOperated->Tran_Price,2) }}" onClick="this.setSelectionRange(0, this.value.length)" name="Tran_Price" id="Tran_Price" class="form-control  textSize-13 Tran_Price Tran_Price_cal " placeholder="ค่าใช้จ่ายขนส่ง" >
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label fw-semibold fs-6">อื่นๆ</label>
                                                <input type="text" value="{{ number_format(@$data->ContractToOperated->Other_Price,2) }}" onClick="this.setSelectionRange(0, this.value.length)" name="Other_Price" id="Other_Price" class="form-control  textSize-13 Other_Price Other_Price_cal " placeholder=" อื่นๆ">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-1">
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label fw-semibold fs-6">การตลาด</label>
                                                <input type="text" value="{{ number_format(@$data->ContractToOperated->Marketing_Price,2) }}" onClick="this.setSelectionRange(0, this.value.length)" name="Marketing_Price" id="Marketing_Price" class="form-control  textSize-13 Marketing_Price Marketing_Price_cal " placeholder="ค่าการตลาด" >
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label fw-semibold fs-6">ดำเนินการ</label>
                                                <input type="text" value="{{ number_format(@$data->ContractToOperated->id == NULL ? @$Process_Car : @$data->ContractToOperated->Process_Price,2) }}" onClick="this.setSelectionRange(0, this.value.length)" name="Process_Price" id="Process_Price" class="form-control  textSize-13  Process_Price Process_Price_cal bg-light" placeholder=" ค่าดำเนินการ" readonly style="cursor : no-drop;">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-1">
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label fw-semibold fs-6">หักค่างวดล่วงหน้า</label>
                                                <input type="text" value="{{ number_format(@$data->ContractToOperated->DuePrepaid_Price,2) }}" onClick="this.setSelectionRange(0, this.value.length)" name="DuePrepaid_Price" class="form-control  textSize-13 DuePrepaid_Price DuePrepaid_Price_cal " placeholder="หักค่างวดล่วงหน้า"/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label fw-semibold fs-6">เงินดาวน์</label>
                                                <input type="text" value="{{number_format(@$data->ContractToOperated->Downpay_Price,2)}}" onClick="this.setSelectionRange(0, this.value.length)" name="Downpay_Price" class="form-control  textSize-13 " data-toggle="tooltip" title="เงินดาวน์" placeholder="เงินดาวน์">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-1 d-none">
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label fw-semibold fs-6">รวมค่าใช้จ่าย</label>
                                                <input type="text" value="{{ @$data->ContractToOperated->id == NULL ? @$Total_Price : number_format(@$data->ContractToOperated->Total_Price,2) }} " name="Total_Price"  class="form-control  textSize-13 Total_Price bg-light Total_Price_cal is-warning" placeholder="รวมค่าใช้จ่าย" readonly/>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div>
                                                <label class="form-label fw-semibold fs-6">คงเหลือสุทธิ</label>
                                                <input type="text" value="{{ number_format( @$data->ContractToOperated->id == NULL ? @$Balance_Price : @$data->ContractToOperated->Balance_Price,2) }}" name="Balance_Price"  class="form-control  textSize-13 Balance_Price_cal bg-light is-warning" placeholder="ยอดคงเหลือสุทธิ" readonly/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-2 g-1">
                                        <div class="col-lg-12">
                                            <div>
                                                <label class="form-label fw-semibold textSize-13">กำหนดวันโอนส่วนที่เหลือ</label>
                                                <input type="date" value="{{@$data->ContractToOperated->LastTransfer }}" class="form-control  textSize-13  " onClick="this.setSelectionRange(0, this.value.length)" name="LastTransfer" id="LastTransfer" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end content --}}
                        <div class="col-xl-3 col-lg-4 col-md-12 col-sm-12 mb-2">
                            <div class="card bg-primary h-100">
                                <div class="card-body">
                                    <h5 class="mb-3 text-white"><i class="bx bx-file"></i> ยอดจากการคำนวน</h5>
                                    <div class="table-responsive">
                                        <table class="table mb-0 text-white table-hover" style="cursor: context-menu;">
                                            <tbody>
                                                <tr>
                                                    <td> ยอดจัด :</td>
                                                    <td class="text-end">{{ number_format(@$data->ContractToCal->Cash_Car,2) }}</td>
                                                </tr>
                                                <tr data-bs-toggle="popover" data-bs-placement="top" data-bs-custom-class="expens-popover" data-bs-content="
                                                    @if( @$data->ContractToCal->StatusProcess_Car == 'yes')
                                                      รวมค่าดำเนินการมาในหน้าคำนวณ
                                                    @else
                                                       ไม่รวมค่าดำเนินการมาในหน้าคำนวณ
                                                    @endif
                                                ">
                                                    <td><i class="bx {{ @$data->ContractToCal->StatusProcess_Car == 'yes' ? 'bx-plus-circle text-success' : 'bx-minus-circle text-danger' }} fs-5"></i> ค่าดำเนินการ : </td>
                                                    <td class="text-end">{{number_format(@$data->ContractToCal->Process_Car,2) }}</td>
                                                </tr>
                                                <tr data-bs-toggle="popover" data-bs-placement="top" data-bs-custom-class="expens-popover"  data-bs-content="
                                                @if(strtoupper(@$data->ContractToCal->Buy_PA) == 'YES')
                                                    @if( strtoupper(@$data->ContractToCal->Include_PA) == 'YES')
                                                        รวม ค่าประกัน PA มาในหน้าคำนวณ
                                                    @else
                                                        ไม่รวม ค่าประกัน PA มาในหน้าคำนวณ
                                                    @endif
                                                @else
                                                   ไม่ได้ซื้อประกัน
                                                @endif
                                            ">
                                                    <td><i class="bx {{ @$data->ContractToCal->Include_PA == 'yes' ? 'bx-plus-circle text-success' : 'bx-minus-circle text-danger' }} fs-5"></i> ประกัน PA :</td>
                                                    <td class="text-end">{{ number_format( @$data->ContractToCal->Insurance_PA,2) }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <h5 class="mt-4 text-white"><i class="bx bxl-paypal"></i> สรุปยอดค่าใช้จ่าย</h5>
                                    <div class="border border-2 border-warning p-2">
                                        <div class="table-responsive">
                                            <table class="table mb-0 text-white">
                                                <tbody>
                                                    <tr>
                                                        <td>รวมค่าใช้จ่าย :</td>
                                                        <td class="text-end"><span class="totalPay"> {{ @$data->ContractToOperated->id == NULL ? @$Total_Price : number_format(@$data->ContractToOperated->Total_Price,2) }} </span></td>
                                                    </tr>
                                                    <tr>
                                                        <td>คงเหลือสุทธิ :</td>
                                                        <td class="text-end"><span class="SumtotalPay"> {{ number_format( @$data->ContractToOperated->id == NULL ? @$Balance_Price : @$data->ContractToOperated->Balance_Price,2) }} </span></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- end table-responsive -->
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>







