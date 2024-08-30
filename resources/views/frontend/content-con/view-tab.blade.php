
<style>

	.alert-popover {
		--bs-popover-max-width: 300px;
		--bs-popover-border-color: var(--bs-danger);
		--bs-popover-header-bg: var(--bs-danger);
		--bs-popover-header-color: var(--bs-white);
		--bs-popover-body-padding-x: 1rem;
		--bs-popover-body-padding-y: .5rem;
	}
</style>
<div class="container text-center">
    <div style="cursor: pointer; overflow: auto;" class="mt-2">
        <ul class="nav nav-pills" id="pills-tab" id="formTabs" role="tablist">
            <div class="d-flex contenthead alltab" >
                <li class="nav-item p-2 tabContract" onclick="getContent('section-asset','section-asset')"  id="asset-tab"  style="width:180px;">
                    <div class="col-12">
                        <button type="button" class="btn bg-tranparent border-0 position-relative mt-1">
                            <img class="section-asset img-defualt btnTab {{ @$tab == 'section-asset' ? 'filter-img' : '' }}" src="{{ URL::asset('\assets\images\contract\asset-management.png') }}" alt="" style="width: 30%;">
                            @if(count(@$data->ContractToIndentureAsset2) != 0)
                                <span class="position-absolute top-0 start-80 translate-middle badge rounded-circle bg-success bg-soft" >
                                    <i class="bx bx-check bx-tada text-success"></i>
                                </span>
                            @else
                            <span class="position-absolute top-0 start-80 translate-middle badge rounded-circle bg-danger bg-soft" >
                                <i class="bx bx-x bx-tada text-danger" data-toggle="popover" data-bs-placement="top" data-bs-title="<p class='fw-semibold mb-0'> <i class='bx bx-error-circle'></i> ข้อมูลทรัพย์ ! </p>" data-bs-custom-class="alert-popover" data-bs-content="
                                    <div class='row'>
                                        <div class='col-12 fs-6 fw-semibold'>
                                            โปรดตรวจสอบว่ามีการเพิ่มข้อมูลทรัพย์เรียบร้อยแล้ว หากไม่พบทรัพย์ที่ค้นหา <br>
                                            โปรดตรวจสอบว่าได้มีการเพิ่มทรัพย์หน้าลูกค้า หรือ ทรัพย์ผูกกับสัญญาอื่นๆอยู่หรือไม่
                                        </div>
                                        <div class='col-12 fs-6 text-center text-danger fw-semibold border-top border-light py-2 bg-light'><i class='bx bx-bulb'></i> เพิ่มข้อมูลให้ครบถ้วนก่อนทำการขออนุมัติ</div>
                                    </div>">
                                </i>
                            </span>
                            @endif
                        </button>
                    </div>
                    <div class="col-12 py-2">
                        <span class="fs-5 fw-semibold text-secondary">ทรัพย์</span>
                    </div>
                </li>
                <li class="nav-item p-2 tabContract " onclick="getContent('section-guarantor','section-guarantor')" id="guarantor-tab" role="tab" data-bs-toggle="tab" data-bs-target='#guarantor-tab-pane'  aria-controls="guarantor-tab-pane" aria-selected="false" style="width:180px;"><span>
                    <div class="col-12">
                        <button type="button" class="btn bg-tranparent border-0 position-relative mt-1">
                            <img class="section-guarantor img-defualt {{ @$tab == 'section-guarantor' ? 'filter-img' : '' }}" src="{{ URL::asset('\assets\images\contract\qualification.png') }}" alt="" style="width: 30%;">
                         @if(count(@$data->ContractToGuarantor) != 0)
                            <span class="position-absolute top-0 start-80 translate-middle badge rounded-circle bg-success bg-soft" >
                                <i class="bx bx-check bx-tada text-success" ></i>
                            </span>
                            @else
                                <span class="position-absolute top-0 start-80 translate-middle badge rounded-circle bg-warning bg-soft" >
                                    <i class="bx bx-user-plus bx-tada text-warning" data-toggle="popover" data-bs-placement="top" data-bs-title="<p class='fw-semibold mb-0'> <i class='bx bx-error-circle'></i> ข้อมูลผู้ค้ำ ! </p>" data-bs-custom-class="alert-popover" data-bs-content="
                                        <div class='row'>
                                            <div class='col-12 fs-6 fw-semibold'>
                                                * กรณีสัญญาที่ต้องการผู้ค้ำสามารถกดแทป ตามด้วยกดปุ่ม <i class='bx bxs-plus-square'></i> <br>
                                                * ถ้าไม่มีข้อมูลผู้ค้ำ สมารถเพิ่มผู้ค้ำได้ในหน้า <u>ข้อมูลลูกค้า</u>
                                            </div>
                                            <div class='col-12 fs-6 text-center text-danger fw-semibold border-top border-light py-2 bg-light'><i class='bx bx-bulb'></i> เพิ่มข้อมูลให้ครบถ้วนก่อนทำการขออนุมัติ</div>
                                        </div>">
                                    </i>
                                </span>
                            @endif
                        </button>
                    </div>
                    <div class="col-12 py-1">
                    <span class="fs-5 fw-semibold  text-secondary">ผู้ค้ำ</span>
                    </div>
                </li>
                <li class="nav-item p-2 tabContract " onclick="getContent('section-Payee','section-Payee')" id="Payee-tab" role="tab" data-bs-toggle="tab" data-bs-target='#Payee-tab-pane' aria-controls="Payee-tab-pane" aria-selected="false" style="width:180px;"><span>
                    <div class="col-12">
                        <button type="button" class="btn bg-tranparent border-0 position-relative mt-1">
                            <img class="section-Payee img-defualt btnTab {{ @$tab == 'section-Payee' ? 'filter-img' : '' }}" src="{{ URL::asset('\assets\images\contract\coin.png') }}" alt="" style="width: 30%;">
                            @php
                                $ArrTypeCus = ['CUS-0004','CUS-0005','CUS-0006'];
                            @endphp
                            @if((in_array(@$data->ContractToDataCusTags->Type_Customer,$ArrTypeCus) == false && count(@$data->ContractToPayee) == 1) || (in_array(@$data->ContractToDataCusTags->Type_Customer,$ArrTypeCus) == true && count(@$data->ContractToPayee) == 2) )
                            <span class="position-absolute top-0 start-80 translate-middle badge rounded-circle bg-success bg-soft" >
                                <i class="bx bx-check bx-tada text-success" ></i>
                            </span>
                            @else
                                <span class="position-absolute top-0 start-80 translate-middle badge rounded-circle bg-danger bg-soft" >
                                    <i class="bx bx-x bx-tada text-danger" data-toggle="popover" data-bs-placement="top" data-bs-title="<p class='fw-semibold mb-0'> <i class='bx bx-error-circle'></i> ข้อมูลผู้รับเงิน ! </p>" data-bs-custom-class="alert-popover" data-bs-content="
                                    <div class='row'>
                                        <div class='col-12 fs-6 fw-semibold'>
                                            โปรดตรวจสอบว่ามีการเพิ่มข้อมูลผู้รับเงินแล้ว หรือ กรณี <u>รีไฟแนนซ์</u> ให้ตรวจสอบว่าได้มีการเพิ่มผู้รับเงินและผู้รับยอดปิดบัญชีแล้ว
                                        </div>
                                        <div class='col-12 fs-6 text-center text-danger fw-semibold border-top border-light py-2 bg-light'><i class='bx bx-bulb'></i> เพิ่มข้อมูลให้ครบถ้วนก่อนทำการขออนุมัติ</div>
                                    </div>">
                                </i>
                                </span>
                            @endif
                        </button>
                    </div>
                    <div class="col-12 py-2">
                    <span class="fs-5 fw-semibold  text-secondary">ผู้รับเงิน</span>
                    </div>
                    </span>
                </li>
                <li class="nav-item p-2 tabContract " onclick="getContent('section-Broker','section-Broker')" id="Broker-tab" role="tab" data-bs-toggle="tab" data-bs-target='#Broker-tab-pane' aria-controls="Broker-tab-pane" aria-selected="false" style="width:180px;">
                    <div class="col-12">
                        <button type="button" class="btn bg-tranparent border-0 position-relative mt-1">
                            <img class="section-Broker img-defualt btnTab {{ @$tab == 'section-Broker' ? 'filter-img' : '' }} " src="{{ URL::asset('\assets\images\contract\broker.png') }}" alt="" style="width: 30%;">
                                @php
                                    $arrBRKCheck = [];
                                    if (count(@$data->ContractToBrokers) != 0) {
                                        foreach (@$data->ContractToBrokers as $item){
                                             array_push($arrBRKCheck,@$item->SumCom_Broker) ;
                                        }
                                    }
                                @endphp

                            @if(in_array(null, $arrBRKCheck) != true )
                              @if(count(@$data->ContractToBrokers) != 0)
                                <span class="position-absolute top-0 start-80 translate-middle badge rounded-circle bg-success bg-soft" >
                                    <i class="bx bx-check bx-tada text-success" ></i>
                                </span>
                              @else
                              <span class="position-absolute top-0 start-80 translate-middle badge rounded-circle bg-warning bg-soft" >
                                <i class="bx bx-user-plus bx-tada text-warning" data-toggle="popover" data-bs-placement="top" data-bs-title="<p class='fw-semibold mb-0'> <i class='bx bx-error-circle'></i> ข้อมูลผู้แนะนำ ! </p>" data-bs-custom-class="alert-popover" data-bs-content="
                                    <div class='row'>
                                        <div class='col-12 fs-6 fw-semibold'>
                                            * กรณีสัญญาที่ต้องการผู้แนะนำสามารถกดแทป ตามด้วยกดปุ่ม <i class='bx bxs-plus-square'></i> <br>
                                            * ถ้าไม่มีข้อมูลผู้แนะนำ สมารถเพิ่มผู้แนะนำได้ในหน้า <u>ข้อมูลลูกค้า</u> แล้วทำการ <u>ลงทะเบียนผู้แนะนำ</u>
                                        </div>
                                        <div class='col-12 fs-6 text-center text-danger fw-semibold border-top border-light py-2 bg-light'><i class='bx bx-bulb'></i> เพิ่มข้อมูลให้ครบถ้วนก่อนทำการขออนุมัติ</div>
                                    </div>">
                                </i>
                            </span>
                              @endif
                            @else
                                <span class="position-absolute top-0 start-80 translate-middle badge rounded-circle bg-danger bg-soft" >
                                    <i class="bx bx-x bx-tada text-danger" data-toggle="popover" data-bs-placement="top" data-bs-title="<p class='fw-semibold mb-0'> <i class='bx bx-error-circle'></i> ข้อมูลผู้แนะนำ ! </p>" data-bs-custom-class="alert-popover" data-bs-content="
                                        <div class='row'>
                                            <div class='col-12 fs-6 fw-semibold'>
                                                * กรุณาตรวจสอบว่าได้มีการเพิ่มค่าคอม ฯ ให้กับผู้แนะนำแล้ว <br>
                                                โดยสามารถเพิ่มได้ที่ปุ่ม <i class='bx bxl-bitcoin fs-5 text-warning'></i>
                                            </div>
                                            <div class='col-12 fs-6 text-center text-danger fw-semibold border-top border-light py-2 bg-light'><i class='bx bx-bulb'></i> เพิ่มข้อมูลให้ครบถ้วนก่อนทำการขออนุมัติ</div>
                                        </div>">
                                    </i>
                                </span>
                            @endif
                        </button>
                    </div>
                    <div class="col-12 py-2">
                    <span class="fs-5 fw-semibold  text-secondary">ผู้แนะนำ</span>
                    </div>
                </li>
                <li class="nav-item p-2 tabContract " onclick="getContent('section-expens','section-expens')" id="expenses-tab" role="tab" data-bs-toggle="tab" data-bs-target='#expenses-tab-pane' aria-controls="expenses-tab-pane" aria-selected="false" style="width:180px;">
                    <div class="col-12">
                        <button type="button" class="btn bg-tranparent border-0 position-relative mt-1">
                            <img class="section-expens img-defualt btnTab {{ @$tab == 'section-expens' ? 'filter-img' : '' }}" src="{{ URL::asset('\assets\images\contract\money.png') }}" alt="" style="width: 30%;">
                            @if(@$data->ContractToOperated != NULL)
                            <span class="position-absolute top-0 start-80 translate-middle badge rounded-circle bg-success bg-soft" >
                                <i class="bx bx-check bx-tada text-success" ></i>
                            </span>
                            @else
                                <span class="position-absolute top-0 start-80 translate-middle badge rounded-circle bg-danger bg-soft" >
                                    <i class="bx bx-x bx-tada text-danger" data-toggle="popover" data-bs-placement="top" data-bs-title="<p class='fw-semibold mb-0'> <i class='bx bx-error-circle'></i> ข้อมูลค่าใช้จ่าย ! </p>" data-bs-custom-class="alert-popover" data-bs-content="
                                    <div class='row'>
                                        <div class='col-12 fs-6 fw-semibold'>
                                            กรุณาเพิ่มรายละเอียดค่าใช้จ่ายสำหรับสัญญานี้
                                        </div>
                                        <div class='col-12 fs-6 text-center text-danger fw-semibold border-top border-light py-2 bg-light'><i class='bx bx-bulb'></i> เพิ่มข้อมูลให้ครบถ้วนก่อนทำการขออนุมัติ</div>
                                    </div>">
                                </i>
                                </span>
                            @endif
                        </button>
                    </div>
                    <div class="col-12 py-2">
                    <span class="fs-5 fw-semibold  text-secondary">ค่าใช้จ่าย</span>
                    </div>
                </li>
                <li class="nav-item p-2 tabContract " onclick="getContent('section-contract','section-contract')"  id="approve-tab" role="tab" data-bs-target='#approve-tab-pane' data-bs-toggle="tab" aria-controls="approve-tab-pane" aria-selected="false" style="width:180px;">
                    <div class="col-12">
                        @php
                             @$land_type = $data->ContractToTypeLoan->id_rateType;
                            if(( @$data->DateCheck_Bookcar == NULL && @$data->DateSpecial_Bookcar == NULL && $land_type !='land') || ( @$data->LinkUpload_Con == NULL || @$data->ContractToAudittor->StatusApprove != 'Y' || @$data->Adds_Con == NULL )){ // เช็คว่ามีการเลือก ทรัพย์ ผู้รับเงิน หรือเพิ่มค่าใช้จ่ายในหน้าสัญญาแล้วยัง
                                $dataCheckCon = false;
                            } else {
                                $dataCheckCon = true;
                            }
                        @endphp
                        <button type="button" class="btn bg-tranparent border-0 position-relative mt-1">
                            <img class="section-contract img-defualt btnTab {{ @$tab == 'section-contract' ? 'filter-img' : '' }}" src="{{ URL::asset('\assets\images\contract\approve2.png') }}" alt="" style="width: 30%;">
                            @if(@$dataCheckCon == true)
                                <span class="position-absolute top-0 start-80 translate-middle badge rounded-circle bg-success bg-soft" >
                                    <i class="bx bx-check bx-tada text-success" ></i>
                                </span>
                            @else
                                <span class="position-absolute top-0 start-80 translate-middle badge rounded-circle bg-danger bg-soft" >
                                    <i class="bx bx-x bx-tada text-danger" data-toggle="popover" data-bs-placement="top" data-bs-title="<p class='fw-semibold mb-0'> <i class='bx bx-error-circle'></i> ข้อมูลการอนุมัติ ! </p>" data-bs-custom-class="alert-popover" data-bs-content="
                                        <div class='row'>
                                            <div class='col-12 fs-6 fw-semibold'>
                                                กรุณาตรวจสอบความถูกต้อง <br>
                                                * รายละเอียดการตรวจสอบเอกสาร <br>
                                                * ที่อยู่ที่ใช้ในการทำสัญญา <br>
                                                @if($land_type !='land')
                                                * เช็คแล่มทะเบียน และการขออนุมัติพิเศษ <br>
                                                @endif
                                            </div>
                                            <div class='col-12 fs-6 text-center text-danger fw-semibold border-top border-light py-2 bg-light'><i class='bx bx-bulb'></i> เพิ่มข้อมูลให้ครบถ้วนก่อนทำการขออนุมัติ</div>
                                        </div>">
                                    </i>
                                </span>
                            @endif
                        </button>
                    </div>
                    <div class="col-12 py-2">
                    <span class="fs-5 fw-semibold  text-secondary">อนุมัติ</span>
                    </div>
                </li>
            </div>
        </ul>
    </div>
</div>

<script>
    $(function(){
        $('[data-toggle="popover"]').popover({
            html: true,
            trigger: 'hover'
        })
    })
</script>



