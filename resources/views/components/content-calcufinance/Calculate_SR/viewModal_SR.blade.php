<script src="{{ URL::asset('assets/js/input-bx-select.js') }}"></script>
@include('components.content-calcufinance.Calculate_SR.script')
@include('public-js.scriptVehRate')

<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>

<style>
    option:disabled {
        background: #ccc;
    }

    .card-table-year {
        position: absolute;
        left: -6rem;
        overflow: hidden;
    }

    .teble-year {
        width: 5%;
    }

    /* --bs-table-accent-bg: var(--bs-table-striped-bg); */
    #table_instl_container .table-striped-col > thead > tr:nth-child(2) > :nth-child(odd) {
        --bs-table-accent-bg: var(--bs-table-striped-bg);
    }
    #table_instl_container .table-striped-col > :not(caption):not(thead):not(footer) > tr > :nth-child(even) {
        --bs-table-accent-bg: var(--bs-table-striped-bg);
    }
</style>

<!-- Scrollbar Thin -->
<style>

    ::-webkit-scrollbar-corner { background: rgba(0,0,0,0.5); }

    /* Works on Chrome, Edge, and Safari */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }

    /* Track */
    ::-webkit-scrollbar-track {
        background: transparent;
    }

    /* Handle */
    ::-webkit-scrollbar-thumb {
        background-color: #cccccc;
        border-radius: 10px;
        border: 3px solid #cccccc;
    }
</style>

<!-- ตารางคำนวณ -->
<style>
    #table_instl_container table {
        margin-top: 0px !important;
        margin-bottom: 0px !important;
    }
</style>

<!-- sweetalert2 toast -->
<style>
    .cal-sr-toast-popup .swal2-title {
        margin-top: 0rem !important;
        margin-bottom: 0rem !important;
    }
    .cal-sr-toast-popup .swal2-html-container {
        margin-top: 0rem !important;
        margin-bottom: 0rem !important;
    }
</style>

<div class="modal-content" id="modalContent">
    <div class="modal-header py-1">
        <div class="flex-shrink-0 me-2">
            <img src="{{ asset('assets/images/gif/sale.gif') }}" alt="" class="avatar-sm">
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h5 class="text-primary fw-semibold m-0">คำนวณสินเชื่อไฟแนนซ์</h5>
            <p class="text-muted my-0 fw-semibold font-size-12">โซนสุราษฎร์ธานี</p>
            <p class="border-primary border-bottom m-0"></p>
        </div>
        <button type="button" class="btn-close btn-disabled btn_closeCal" data-bs-dismiss="modal"
            aria-label="Close"></button>
    </div>
    <div class="modal-body py-0">

        <div class="overlay d-flex" id="overlay_loading" style="display: none !important">
            <div class="spinner-border d-flex m-auto text-light" style="width: 5rem; height: 5rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

        <form name="createCalculates" id="createCalculates" class="form-Validate needs-validation" method="post"
            enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="type" value="6" />
            <input type="hidden" name="DataTag_id" value="{{ @$tags->id }}" />
            <input type="hidden" name="Cal_id" id="Cal_id" value="{{ @$tags->TagToCulculate->id }}" />
            <input type="hidden" name="DataCus_id" value="{{ @$tags->DataCus_id }}" />

            <!--
            <div class="d-flex m-1 mb-0">
                <div class="flex-shrink-0 me-2">
                    <img src="{{ asset('assets/images/gif/sale.gif') }}" alt="" class="avatar-sm">
                </div>
                <div class="flex-grow-1 overflow-hidden">
                    <h5 class="text-primary fw-semibold">คำนวณสินเชื่อไฟแนนซ์</h5>
                    <p class="text-muted mt-n1 fw-semibold mb-2 font-size-12">โซนสุราษฎร์ธานี</p>
                    <p class="border-primary border-bottom m-0"></p>
                </div>
                <button type="button" class="btn-close btn-disabled btn_closeCal" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            -->

            <div class="offcanvas offcanvas-start" tabindex="-1" data-bs-scroll="true" data-bs-backdrop="false"
                id="offcanvasYearTable" style="width: 7rem;">
                <div class="offcanvas-header py-2">
                    <h5 class="offcanvas-title fw-semibold" id="offcanvasExampleLabel">ตารางปี</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body pt-0 px-1">

                    <table class="table table-sm text-center table-bordered table-striped table-striped-columns">
                        <thead class="table-light" style="position: sticky; top: 0;">
                            <tr>
                                <th class="text-primary">ค.ศ.</th>
                                <th class="text-danger">พ.ศ.</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for ($i = date('Y') - 25; $i <= date('Y'); $i++)
                                <tr>
                                    <td>
                                        <strong class="text-primary">{{ $i }}</strong>
                                    </td>
                                    <td>
                                        <strong class="text-danger">{{ $i + 543 }}</strong>
                                    </td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>

                </div>
            </div>

            <div class="row">

                <!-- เงื่อนไข -->
                <div class="col-12 col-lg-6 col-xl-3 bg-primary bg-soft border border-primary border-opacity-10 pb-2">

                    <h6 class="my-2 fw-bold bg-primary bg-soft rounded-pill text-center">
                        <i class="fas fa-tasks fs-5"></i> เงื่อนไข
                    </h6>

                    <div class="my-2">
                        <div class="input-bx">
                            <select @class([
                                'form-select',
                                'has-value' => @$tags->Type_Customer != NULL,
                            ]) id="Code_Cus-calTag" name="Type_Customer" data-bs-toggle="tooltip" title="ประเภทลูกค้า">
                                <option value="" selected>-- ประเภทลูกค้า --</option>
                                @foreach ($typeCus as $key => $value)
                                    <option value="{{ $value->Code_Cus }}"
                                        {{ @$tags->Type_Customer != null && @$tags->Type_Customer == $value->Code_Cus ? 'selected' : '' }}>
                                        {{ $value->Name_Cus }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger floating-label">ประเภทลูกค้า</span>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="input-bx">
                            <input type="text" name="DateOccupiedcar" id="DateOccupiedcar"
                                class="form-control rounded-0 rounded-start text-center" placeholder=" "
                                data-date-format="dd/mm/yyyy" data-date-container="#modalContent"
                                data-provide="datepicker" data-date-disable-touch-keyboard="true"
                                data-date-language="th" data-date-today-highlight="true"
                                data-date-enable-on-readonly="true" data-date-clear-btn="true"
                                data-date-orientation="bottom" data-bs-toggle="tooltip" data-bs-placement="top"
                                title="วันครอบครองล่าสุด (ปี ค.ศ.)" readonly autocomplete="off" required value="{{ !empty(@$tags->TagToCulculate->DateOccupiedcar) ? convertDatePHPToHuman($tags->TagToCulculate->DateOccupiedcar) : '' }}">
                            <button
                                class="btn btn-light rounded-0 border-dark border-opacity-10 border-top-1 border-bottom-1 border-start-0 border-end-1 rounded-end d-flex align-items-center openDatepickerBtn"
                                type="button">
                                <i class="fas fa-calendar-alt"></i>
                            </button>
                            <!--
                            <button
                                class="btn btn-light border-top-1 border-end-1 border-bottom-1 border-dark border-opacity-10 dropdown-toggle rounded-0 rounded-end dropdown-InsuranceDT px-2"
                                type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-angle-down"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end col-auto">
                                <li><a class="dropdown-item _Today_DateOccupied" href="#">วันนี้</a></li>
                                <li><a class="dropdown-item _30Day_DateOccupied" href="#">30 วัน</a></li>
                                <li><a class="dropdown-item _60Day_DateOccupied" href="#">60 วัน</a></li>
                                <li><a class="dropdown-item _90Day_DateOccupied" href="#">90 วัน</a></li>
                            </ul>
                            -->
                            <span class="text-danger floating-label">วันครอบครองล่าสุด</span>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="input-bx col">
                            <input type="text" name="NumDateOccupiedcar" id="NumDateOccupiedcar"
                                class="form-control rounded-0 rounded-start text-center" placeholder=" " readonly value="{{ @$tags->TagToCulculate->NumDateOccupiedcar }}">
                            <button
                                class="btn btn-light border border-dark border-opacity-25 border-start-0 rounded-0 rounded-end d-flex align-items-center disabled">
                                วัน
                            </button>
                            <span class="floating-label">ระยะเวลาครอบครอง</span>
                        </div>
                    </div>

                    <div class="mb-2">
                        <div class="input-bx">
                            <select class="form-select TypeLoansNotRefresh typeRateAsset {{ !empty($tags->TagToCulculate->CodeLoans) ? 'has-value' : '' }}" id="TypeLoans" name="TypeLoans"
                                data-bs-toggle="tooltip" title="เลือกประเภทสัญญา" required {{ @$tags->TagToContracts != NULL ? "aria-readonly=true readonly" : '' }}>
                                <option value="" data-loancode="00" data-loangroup="0" data-idrateType="" @disabled(@$tags->TagToContracts != NULL) selected>--- ประเภทสัญญา ---</option>
                                @foreach ($TypeLoan as $key => $value)
                                    <option value="{{ $value->id_rateType }}"
                                        data-loancode="{{ $value->Loan_Code }}"
                                        data-loangroup="{{ $value->Loan_Group }}"
                                        data-idrateType="{{ $value->id_rateType }}"
                                        @php
                                        if (@$tags->TagToCulculate->CodeLoans != null && @$tags->TagToCulculate->CodeLoans == $value->Loan_Code) {
                                            echo "selected";
                                        } elseif (@$tags->TagToContracts != NULL) {
                                            echo "disabled";
                                        }    
                                        @endphp
                                        {{-- @$tags->TagToCulculate->CodeLoans != null && @$tags->TagToCulculate->CodeLoans == $value->Loan_Code ? 'selected' : '' --}}>{{ $value->Loan_Code }} -
                                        {{ $value->Loan_Name }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger floating-label">ประเภทสัญญา</span>
                        </div>
                    </div>

                    <input type="hidden" name="CodeLoans" id="CodeLoans"
                            value="{{ @$tags->TagToCulculate->CodeLoans }}"
                            class="form-control form-control-sm textSize-13" />

                    <!-- assetType สำหรับใช้แยกประเภทว่าสร้างทรัพย์อะไร -->
                    <input type="hidden" id="assetType_input" name="assetType_input" value="{{@$asset}}">

                    <div class="mb-2 input_PossessionState_Code">
                        <div class="input-bx">
                            @php
                                $typePoss = \App\Models\TB_Constants\TB_Frontend\TB_TypeAssetsPoss::where('Flag_TypePoss', 'yes')->get();
                            @endphp
                            <select class="form-select {{ !empty($tags->TagToCulculate->TypeAssetsPoss) ? 'has-value' : '' }}" id="TypeAssetsPoss" name="TypeAssetsPoss"
                                data-bs-toggle="tooltip" title="สถานะครอบครอง">
                                <option value="" selected>-- สถานะครอบครอง --</option>
                                @foreach (@$typePoss as $key => $value)
                                    @if ($value->Code_TypePoss != 'APS-0003')
                                        <option value="{{ $value->Name_TypePoss }}"
                                            data-codetype="{{ $value->Code_TypePoss }}"
                                            {{ @$tags->TagToCulculate->TypeAssetsPoss == $value->Name_TypePoss ? 'selected' : '' }}>
                                            {{ $value->Name_TypePoss }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <span class="text-danger floating-label">สถานะครอบครอง</span>
                        </div>
                    </div>

                </div>

                <!-- ข้อมูลรถ -->
                <div class="col-12 col-lg-6 col-xl-3 bg-light border border-dark border-opacity-10 pb-2">

                    <h6 class="my-2 fw-bold bg-secondary bg-soft rounded-pill text-center">
                        <i class="fas fa-cog fs-5"></i> ข้อมูลรถ
                    </h6>

                    <div class="my-2 input_RateCartypes">
                        <div class="row g-2">
                            <div class="col-12 col-sm-6">
                                <div class="input-bx">
                                    <select class="form-select typeAsset {{ !empty($tags->TagToCulculate->RateCartypes) ? 'has-value' : '' }}" id="RateCartypes" name="RateCartypes" data-bs-toggle="tooltip" title="ประเภทรถ">
                                        <option value="" selected>-- ประเภทรถ 1 --</option>
                                        {{-- ถ้ามีข้อมูล datatypeCar อยู่จริง ให้สร้าง dropdown --}}
                                        @if( @$datatypeCar != NULL )
                                            @foreach(@$datatypeCar as $typeCar)                                          
                                                <option value="{{$typeCar->code_car}}" {{$typeCar->code_car == @$tags->TagToCulculate->RateCartypes ? 'selected':''}}>{{$typeCar->nametype_car}}</option>
                                            @endforeach 
                                        @endif

                                    </select>
                                    <span class="floating-label">ประเภทรถ 1</span>
                                </div>
                            </div>
                            
                            <div class="col-12 col-sm-6">
                                <div class="input-bx">
                                    <select class="form-select Type_PLT" id="Type_PLT" name="Type_PLT"
                                        data-bs-toggle="tooltip" title="ประเภทรถสำหรับ ธปท.">
                                        <option value="" selected>-- ประเภทรถ 2 --</option>
        
                                    </select>
                                    <span class="floating-label">ประเภทรถ 2</span>
                                </div>
                            </div>

                            

                        </div>
                    </div>

                    <div class="mb-2 input_RateBrands">
                        <div class="input-bx">
                            <select class="form-select brandAsset" id="RateBrands" name="RateBrands"
                                data-bs-toggle="tooltip" title="กลุ่มรถ">
                                <option value="" selected>-- ยี่ห้อรถ --</option>

                            </select>
                            <span class="floating-label">ยี่ห้อรถ</span>
                        </div>
                    </div>

                    <div class="my-2 input_RateGroups">
                        <div class="row g-2">

                            <div class="col-12 col-sm">
                                <div class="input-bx">
                                    <select class="form-select groupAsset" id="RateGroups" name="RateGroups"
                                        data-bs-toggle="tooltip" title="กลุ่มรถ">
                                        <option value="" selected>-- กลุ่มรถ --</option>
                                    </select>
                                    <span class="floating-label">กลุ่มรถ</span>
                                </div>
                            </div>
                            
                            <div class="col-12 col-sm-auto">
                                <div class="input-bx">
                                    <select class="form-select yearAsset" id="RateYears" data-bs-toggle="tooltip" title="ปีรถ">
                                        <option value="" selected>-- ปีรถ --</option>
                                    </select>
                                    <span class="floating-label">ปีรถ</span>
                                </div>
                                <input type="hidden" name="RateYears" class="rateYear">
                            </div>

                        </div>
                    </div>

                    <div class="mb-2 input_RateModals">
                        <div class="input-bx">
                            <select class="form-select modelAsset" id="RateModals" name="RateModals"
                                data-bs-toggle="tooltip" title="รุ่นรถ">
                                <option value="" selected>-- รุ่นรถ --</option>

                            </select>
                            <span class="floating-label">รุ่นรถ</span>
                        </div>
                    </div>

                    <div class="mb-2 input_RateGear">
                        <div class="input-bx">
                            <select class="form-select gearCar" id="RateGears" name="RateGears"
                                data-bs-toggle="tooltip" title="เกียร์รถ">
                                <option value="" selected>-- เกียร์รถ --</option>
                            </select>
                            <span class="floating-label">เกียร์รถ</span>
                        </div>
                    </div>

                </div>

                <!-- ราคากลาง -->
                <div class="col-12 col-lg-6 col-xl-3 bg-primary bg-soft border border-primary border-opacity-10 pb-2">

                    <h6 class="my-2 fw-bold bg-primary bg-soft rounded-pill text-center">
                        <i class="fas fa-sign fs-5"></i> วงเงินประเมินสูงสุด
                    </h6>

                    <ul class="ps-3 m-0">
                        <li>ยอดจัดสูงสุด คำนวณจาก LTV</li>
                        <li>หากเป็น 0 คือ ไม่สามารถจัดได้ หากยังต้องการจัดให้ติดต่อผู้บริหาร</li>
                        <li id="helptext_rate3" style="display: none;">ค้ำหลักทรัพย์ คือ ผู้ค้ำ/ผู้เช่าซื้อมีเอกสาร</li>
                    </ul>

                    <div class="my-2 LTV_ownership">
                        <div class="row g-0">
                            <button
                                class="btn btn-light border border-dark border-opacity-25 border-end-0 rounded-0 rounded-start d-flex align-items-center disabled col-auto pe-2">
                                <i class="fas fa-sign fs-5"></i>
                            </button>
                            <div class="input-bx col">
                                <input type="text" name="Rate_ownership1" id="LTV_ownership_value" class="form-control rounded-0"
                                    placeholder=" " readonly >
                                <button
                                    class="btn btn-light border border-dark border-opacity-25 border-start-0 rounded-0 rounded-end d-flex align-items-center disabled">
                                    บาท
                                </button>
                                <span class="text-dark floating-label">ยอดจัดสูงสุด</span>
                            </div>
                        </div>
                    </div>

                    <div class="my-2 showRatePrice">
                        <div class="row g-0">
                            <button
                                class="btn btn-light border border-dark border-opacity-25 border-end-0 rounded-0 rounded-start d-flex align-items-center disabled col-auto pe-2">
                                <i class="fas fa-sign fs-5"></i>
                            </button>
                            <div class="input-bx col">
                                <input type="text" name="RatePrices" id="RatePrices" class="form-control rounded-0 ratePrice"
                                    placeholder=" " value="{{@$tags->TagToCulculate->RatePrices}}">
                                <button
                                    class="btn btn-light border border-dark border-opacity-25 border-start-0 rounded-0 rounded-end d-flex align-items-center disabled">
                                    บาท
                                </button>
                                <span class="text-dark floating-label">ราคาประเมินที่ดิน</span>
                            </div>
                        </div>

                        <input type="hidden" name="Percent_Car" id="Percent_Car" value="{{@$tags->TagToCulculate->RatePrices}}">

                    </div>

                    <div class="LTV_trade">

                        <div class="my-2">
                            <div class="row g-0">
                                <button
                                    class="btn btn-light border border-dark border-opacity-25 border-end-0 rounded-0 rounded-start d-flex align-items-center disabled col-auto pe-2">
                                    <i class="fas fa-user-alt fs-5"></i>
                                </button>
                                <div class="input-bx col">
                                    <input type="text" name="Rate_trade1" id="LTV_trade_value_1"
                                        class="form-control rounded-0" placeholder=" " readonly>
                                    <button
                                        class="btn btn-light border border-dark border-opacity-25 border-start-0 rounded-0 rounded-end d-flex align-items-center disabled">
                                        บาท
                                    </button>
                                    <span class="text-dark floating-label">ประเมินค้ำรายได้</span>
                                </div>
                            </div>
                        </div>

                        <div class="my-2">
                            <div class="row g-0">
                                <button
                                    class="btn btn-light border border-dark border-opacity-25 border-end-0 rounded-0 rounded-start d-flex align-items-center disabled col-auto pe-2">
                                    <i class="fas fa-house-user fs-5"></i>
                                </button>
                                <div class="input-bx col">
                                    <input type="text" name="Rate_trade2" id="LTV_trade_value_2"
                                        class="form-control rounded-0" placeholder=" " readonly>
                                    <button
                                        class="btn btn-light border border-dark border-opacity-25 border-start-0 rounded-0 rounded-end d-flex align-items-center disabled">
                                        บาท
                                    </button>
                                    <span class="text-dark floating-label">ประเมินค้ำเจ้าบ้าน/สปก.</span>
                                </div>
                            </div>
                        </div>

                        <div class="my-2">
                            <div class="row g-0">
                                <button
                                    class="btn btn-light border border-dark border-opacity-25 border-end-0 rounded-0 rounded-start d-flex align-items-center disabled col-auto pe-2">
                                    <i class="fas fa-user-tag fs-5"></i>
                                </button>
                                <div class="input-bx col">
                                    <input type="text" name="Rate_trade3" id="LTV_trade_value_3"
                                        class="form-control rounded-0" placeholder=" " readonly>
                                    <button
                                        class="btn btn-light border border-dark border-opacity-25 border-start-0 rounded-0 rounded-end d-flex align-items-center disabled">
                                        บาท
                                    </button>
                                    <span class="text-dark floating-label">ประเมินค้ำหลักทรัพย์</span>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <!-- ข้อมูลสัญญา -->
                <div class="col-12 col-lg-6 col-xl-3 bg-light border border-dark border-opacity-10 pb-2">

                    <h6 class="my-2 fw-bold bg-secondary bg-soft rounded-pill text-center">
                        <i class="fas fa-file-signature fs-5"></i> ข้อมูลสัญญา
                    </h6>

                    <div class="my-2">
                        <div class="input-bx">
                            <input type="text" name="Cash_Car" id="Cash_Car"
                                class="form-control rounded-0 rounded-start" placeholder=" " required value="{{ number_format(@$tags->TagToCulculate->Cash_Car) }}" autocomplete="off">
                            <button
                                class="btn btn-light border border-dark border-opacity-25 border-start-0 rounded-0 rounded-end d-flex align-items-center disabled">
                                บาท
                            </button>
                            <span class="text-danger floating-label">ยอดจัด (ไม่รวมค่าธรรมเนียม)</span>
                        </div>
                    </div>

                    <div class="my-2">
                        <div class="row g-0">
                            <button
                                class="btn btn-light border border-dark border-opacity-25 border-end-0 rounded-0 rounded-start d-flex align-items-center disabled col-auto">
                                <i class="fas fa-hourglass-half fs-5"></i>
                            </button>
                            <div class="input-bx col">
                                <select @class([
                                    'form-select rounded-0 rounded-end',
                                    'has-value' => @$tags->TagToCulculate->Timelack_Car != NULL,
                                ]) id="Timelack_Car"
                                    name="Timelack_Car" data-bs-toggle="tooltip" title="ระยะเวลาผ่อน" required>
                                    <option value="" selected>-- ระยะเวลาผ่อน --</option>

                                    @for ($timelack_i = 6; $timelack_i <= 84; $timelack_i += 6)
                                        <option value="{{$timelack_i}}" @style(['display: none;' => $timelack_i == 6]) @selected(@$tags->TagToCulculate != NULL && $tags->TagToCulculate->Timelack_Car == $timelack_i )>{{$timelack_i}} งวด</option>
                                    @endfor
                                    <!-- 
                                    <option value="6" style="display: none;">6 งวด</option>
                                    <option value="12">12 งวด</option>
                                    <option value="18">18 งวด</option>
                                    <option value="24">24 งวด</option>
                                    <option value="30">30 งวด</option>
                                    <option value="36">36 งวด</option>
                                    <option value="42">42 งวด</option>
                                    <option value="48">48 งวด</option>
                                    <option value="54">54 งวด</option>
                                    <option value="60">60 งวด</option>
                                    <option value="66">66 งวด</option>
                                    <option value="72">72 งวด</option>
                                    <option value="78">78 งวด</option>
                                    <option value="84">84 งวด</option>
                                    -->

                                </select>
                                <span class="text-danger floating-label">ระยะเวลาผ่อน</span>
                            </div>
                        </div>
                    </div>

                    <div class="my-2">
                        <div class="row g-0">
                            <div class="input-bx col">
                                <input type="number" name="Interest_Car" id="Interest_Car"
                                    class="form-control rounded-0 rounded-start text-center" placeholder=" " data-input-y="InterestYear_Car" min="0.01" step="0.01" required>
                                <span class="text-danger floating-label">ดอกเบี้ย (ต่อเดือน)</span>
                            </div>
                            <div class="input-bx col">
                                <input type="number" name="InterestYear_Car" id="InterestYear_Car"
                                    class="form-control rounded-0 rounded-end border-start-0 text-center" placeholder=" " data-input-m="Interest_Car" min="0.01" step="0.01" required>
                                <span class="text-danger floating-label">ดอกเบี้ย (ต่อปี)</span>
                            </div>
                        </div>
                    </div>

                    <!-- fa-money-bill-trend-up -->
                    <!-- 
                    <div class="my-2">
                        <div class="col-6 col-sm-12 col-md-12 col-lg-6 col-xl-12">
                            <div class="input-bx">
                                <input type="text" name="Interest_Car" id="Interest_Car"
                                    class="form-control rounded-0 rounded-start" inputmode="numeric" placeholder=" " required>
                                <button
                                    class="btn btn-light border border-dark border-opacity-25 border-start-0 rounded-0 rounded-end d-flex align-items-center disabled text-nowrap">
                                    ต่อเดือน
                                </button>
                                <span class="text-danger floating-label">ดอกเบี้ย (%)</span>
                            </div>
                        </div>
                    </div>
                    <div class="my-2">
                        <div class="col-6 col-sm-12 col-md-12 col-lg-6 col-xl-12">
                            <div class="input-bx">
                                <input type="text" name="InterestYear_Car" id="InterestYear_Car"
                                    class="form-control rounded-0 rounded-start" inputmode="numeric" placeholder=" " required>
                                <button
                                    class="btn btn-light border border-dark border-opacity-25 border-start-0 rounded-0 rounded-end d-flex align-items-center disabled text-nowrap">
                                    ต่อปี
                                </button>
                                <span class="text-danger floating-label">ดอกเบี้ย (%)</span>
                            </div>
                        </div>
                    </div>
                    -->

                    <div class="my-2 mb-3">
                        <div class="form-check form-check-inline me-2">
                            <input class="form-check-input border border-primary border-opacity-50" type="radio" name="StatusProcess_Car" id="StatusProcess_Car_Yes" value="yes" @checked( @$tags->TagToCulculate == NULL || @$tags->TagToCulculate->StatusProcess_Car == 'yes' || @$tags->TagToCulculate->StatusProcess_Car == NULL )>
                            <label class="form-check-label fw-bold" for="StatusProcess_Car_Yes">
                                รวมค่าธรรมเนียมในยอดจัด
                            </label>
                        </div>
                        <div class="form-check form-check-inline me-0">
                            <input class="form-check-input border border-primary border-opacity-50" type="radio" name="StatusProcess_Car" id="StatusProcess_Car_No" value="no" @checked( @$tags->TagToCulculate->StatusProcess_Car == 'no' )>
                            <label class="form-check-label fw-bold" for="StatusProcess_Car_No">
                                ไม่รวม
                            </label>
                            <i class="fas fa-question-circle text-info" data-bs-toggle="tooltip"
                                title="กรณีที่ไม่รวม ค่าธรรมเนียมจะหักเป็นค่าใช้จ่ายของลูกค้า (สัญญาขายฝาก/จำนองที่ดิน)"></i>
                        </div>
                    </div>

                    {{-- 
                    <div class="my-2">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input class="form-check-input" type="checkbox" id="SwitchCheckSizemd" checked
                                ng-disabled="true" readonly>
                            <label class="form-check-label fw-bold"
                                for="SwitchCheckSizemd">รวมค่าธรรมเนียมในยอดจัด</label>
                            <i class="fas fa-question-circle text-info" data-bs-toggle="tooltip"
                                title="กรณีที่ไม่รวม ค่าธรรมเนียมจะหักเป็นค่าใช้จ่ายของลูกค้า (เฉพาะสัญญาขายฝาก/จำนองที่ดิน)"></i>
                        </div>
                    </div>
                    --}}

                    <input type="hidden" name="Fee_Max" id="Fee_Max"/>
                    <input type="hidden" name="Fee_Min" id="Fee_Min"/>
                    <input type="hidden" name="Fee_Rate" id="Fee_Rate"/>
                    <input type="hidden" name="Fine_Rate" id="Fine_Rate"/>

                    <input type="hidden" name="Credo_Cond" id="Credo_Cond"/>
                    <input type="hidden" name="Credo_BonusLTV" id="Credo_BonusLTV"/>

                    <input type="hidden" name="Installment_REC" id="Installment_REC"/>

                    <div class="my-2">
                        <div class="row g-0">
                            <div class="input-bx col">
                                <input type="text" name="Process_Car" id="Process_Car"
                                    class="form-control rounded-0 rounded-start text-end" placeholder=" " autocomplete="off" required>
                                <button
                                    class="btn btn-light border border-dark border-opacity-25 border-start-0 rounded-0 rounded-end d-flex align-items-center disabled">
                                    บาท
                                </button>
                                <span class="floating-label">ค่าธรรมเนียม</span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- กราฟค่างวด -->
                <div class="col-12 col-lg-12 col-xl-6 bg- bg-soft border border- border-opacity-10 p-0">
                    <div id="table_instl_container">
                        
                    </div>
                </div>

                <!-- ข้อมูลประกัน -->
                <div class="col-12 col-lg-6 col-xl-3 bg-light border border-dark border-opacity-10 pb-2">

                    <h6 class="my-2 fw-bold bg-secondary bg-soft rounded-pill text-center">
                        <i class="fas fa-car-crash fs-5"></i> ประกัน PA
                    </h6>

                    <input type="hidden" id="Plan_PA" name="Plan_PA" value="{{ @$tags->TagToCulculate->Plan_PA }}">
                    <input type="hidden" id="Insurance_PA" name="Insurance_PA" value="{{ @$tags->TagToCulculate->Insurance_PA }}">

                    <div class="my-2">
                        <div class="form-check form-check-inline form-check-success me-2">
                            <input class="form-check-input border border-primary border-opacity-50" type="radio" name="Buy_PA" id="Buy_PA_Yes" value="yes" @checked( @$tags->TagToCulculate == NULL || @$tags->TagToCulculate->Buy_PA == 'yes')>
                            <label class="form-check-label fw-bold text-success" for="Buy_PA_Yes">
                                ซื้อประกัน PA
                            </label>
                        </div>
                        <div class="form-check form-check-inline form-check-danger me-0">
                            <input class="form-check-input border border-danger border-opacity-50" type="radio" name="Buy_PA" id="Buy_PA_No" value="no" @checked(@$tags->TagToCulculate->Buy_PA == 'no' || @$tags->TagToCulculate == null)>
                            <label class="form-check-label fw-bold text-danger" for="Buy_PA_No">
                                ไม่ซื้อประกัน PA
                            </label>
                        </div>
                    </div>

                    <!--
                    <div class="my-2">

                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input class="form-check-input" type="checkbox" id="SwitchCheckSizemd">
                            <label class="form-check-label fw-bold" for="SwitchCheckSizemd">ซื้อประกัน PA</label>
                        </div>

                    </div>
                    -->

                    <div class="my-2">
                        <input type="text" name="Plan_PA_Show" id="Plan_PA_Show"
                            class="form-control fw-bold text-primary" placeholder="แผน: วงเงินสินเชื่อ" readonly>
                    </div>

                    <div class="my-2">
                        <div class="input-bx col">
                            <input type="text" name="Show_Insurance_PA" id="Show_Insurance_PA"
                                class="form-control rounded-0 rounded-start fw-bold text-primary text-end" placeholder=" " readonly>
                            <button
                                class="btn btn-light border border-dark border-opacity-25 border-start-0 rounded-0 rounded-end d-flex align-items-center disabled">
                                บาท
                            </button>
                            <span class="floating-label">เบี้ยประกัน</span>
                        </div>
                    </div>

                    <div class="my-2 input_PA_include">
                        <div class="form-check form-check-inline form-check-primary me-2">
                            <input class="form-check-input border border-primary border-opacity-50" type="radio" name="Include_PA" id="Include_PA_Yes" value="yes" @checked(@$tags->TagToCulculate->Include_PA == 'yes')>
                            <label class="form-check-label fw-bold text-primary" for="Include_PA_Yes">
                                รวมประกันในยอดจัด
                            </label>
                        </div>
                        <div class="form-check form-check-inline form-radio-danger me-0">
                            <input class="form-check-input border border-danger border-opacity-50 " type="radio" name="Include_PA" id="Include_PA_No" value="no" @checked(@$tags->TagToCulculate->Include_PA == 'no' || @$tags->TagToCulculate == null)>
                            <label class="form-check-label fw-bold text-danger" for="Include_PA_No">
                                ไม่รวมประกัน
                            </label>
                            <i class="fas fa-question-circle text-danger" data-bs-toggle="tooltip"
                                title="กรณีที่ไม่รวม เบี้ยประกันจะหักเป็นค่าใช้จ่ายของลูกค้า"></i>
                        </div>
                    </div>

                    <!-- 
                    <div class="my-2">
                        <div class="form-check form-switch form-switch-md" dir="ltr">
                            <input class="form-check-input" type="checkbox" id="SwitchCheckSizemd">
                            <label class="form-check-label fw-bold" for="SwitchCheckSizemd">รวมประกันในยอดจัด</label>
                            <i class="fas fa-question-circle text-info" data-bs-toggle="tooltip"
                                title="กรณีที่ไม่รวม เบี้ยประกันจะหักเป็นค่าใช้จ่ายของลูกค้า"></i>
                        </div>
                    </div>
                    -->

                    <h6 class="my-2 mt-3 fw-bold bg-secondary bg-soft rounded-pill text-center">
                        <i class="fas fa-bullhorn fs-5"></i> โปรโมชั่น
                    </h6>

                    <div class="my-2">
                        <div class="row g-0">
                            <button
                                class="btn btn-light border border-dark border-opacity-25 border-end-0 rounded-0 rounded-start d-flex align-items-center disabled col-auto pe-2">
                                <i class="fas fa-bullhorn fs-5"></i>
                            </button>
                            <div class="input-bx col">
                                <select @class([
                                    'form-select rounded-0 rounded-end',
                                    'has-value' => @$tags->TagToCulculate->Promotions != NULL,
                                ]) id="Promotions"
                                    name="Promotions" style="{{@$tags->DataCusTagToContracts->Status_Con == 'complete' ? 'pointer-events: none;' : '' }}">
                                    <option value="" selected>-- ไม่ได้ใช้โปรโมชั่น --</option>
                                    @empty( $tags->TagToCulculate->Promotions )
                                        <!-- กรณีที่ไม่มีข้อมูลโปรโมชั่นเลือกไว้ -->
                                        @foreach ($dataPro as $key => $item)

                                            @if( \Carbon\Carbon::createFromFormat( 'Y-m-d', $item->End_pro)->isFuture() )
                                                <option value="{{$item->id}}/{{ number_format($item->Value_pro, 2) }}/{{$item->Type_pro}}" data-namepro="{{$item->Name_pro}}">{{$key+1}}. {{$item->Name_pro}}</option>
                                            @endif

                                        @endforeach
                                    @else
                                        <!-- กรณีที่มีข้อมูลโปรโมชั่นที่เลือก -->
                                        @foreach ($dataPro as $key => $item)

                                            @if( @$item->id == @$tags->TagToCulculate->Promotions )
                                                <option value="{{$item->id}}/{{ number_format($item->Value_pro, 2) }}/{{$item->Type_pro}}" data-namepro="{{$item->Name_pro}}" selected>{{$key+1}}. {{$item->Name_pro}}</option>
                                            @elseif( \Carbon\Carbon::createFromFormat( 'Y-m-d', $item->End_pro)->isFuture() )
                                                <option value="{{$item->id}}/{{ number_format($item->Value_pro, 2) }}/{{$item->Type_pro}}" data-namepro="{{$item->Name_pro}}">{{$key+1}}. {{$item->Name_pro}}</option>
                                            @endif

                                        @endforeach
                                    @endempty
                                </select>
                                <span class="floating-label">โปรโมชั่น</span>
                            </div>

                            {{-- valuePromotion --}}
                            <input type="hidden" id="valuePromotion" name="valuePromotion" value="{{@$tags->TagToCulculate->Promotions}}">
                        </div>
                    </div>

                    <h6 class="my-2 mt-3 fw-bold bg-secondary bg-soft rounded-pill text-center">
                        <i class="far fa-window-restore fs-5"></i> สัญญาอ้างอิง
                    </h6>

                    <div class="my-2">
                        <div class="input-bx">
                            <input type="text" name="Contract_old" id="Contract_old"
                                    class="form-control" placeholder=" " value="{{ @$tags->TagToCulculate->Contract_old }}">
                            <span class="floating-label">เลขที่สัญญาอ้างอิง (ถ้ามี)</span>
                        </div>
                        <div class="text-muted text-center">สำหรับรีไฟแนนท์ หรือขยายสัญญาที่ดิน</div>
                    </div>

                </div>

                <!-- ผลสรุป -->
                <div class="col-12 col-lg-6 col-xl-3 bg-primary bg-soft border border-primary border-opacity-10 pb-2 cal-panel">

                    <h6 class="my-2 fw-bold bg-primary bg-soft rounded-pill text-center">
                        <i class="fas fa-calculator fs-5"></i> คำนวณ
                    </h6>

                    <input type="hidden" name="Vat_Rate" id="Vat_Rate" value="{{@$tags->TagToCulculate->Vat_Rate}}">
                    <input type="hidden" name="Period_Rate" id="Period_Rate" value="{{@$tags->TagToCulculate->Period_Rate}}">
                    <input type="hidden" name="Tax_Rate" id="Tax_Rate" value="{{@$tags->TagToCulculate->Tax_Rate}}">
                    <input type="hidden" name="Tax2_Rate" id="Tax2_Rate" value="{{@$tags->TagToCulculate->Tax2_Rate}}">
                    <input type="hidden" name="Duerate_Rate" id="Duerate_Rate" value="{{@$tags->TagToCulculate->Duerate_Rate}}">
                    <input type="hidden" name="Duerate2_Rate" id="Duerate2_Rate" value="{{@$tags->TagToCulculate->Duerate2_Rate}}">
                    <input type="hidden" name="Profit_Rate" id="Profit_Rate" value="{{@$tags->TagToCulculate->Profit_Rate}}">
                    <input type="hidden" name="TotalPeriod_Rate" id="TotalPeriod_Rate" value="{{@$tags->TagToCulculate->TotalPeriod_Rate}}">
                    <input type="hidden" name="totalInterest_Car" id="totalInterest_Car" value="{{@$tags->TagToCulculate->totalInterest_Car}}">
                    <input type="hidden" name="Note_Credo" id="Note_Credo" value="{{@$tags->TagToCulculate->Note_Credo}}">
                    <input type="hidden" id="CheckPage" value="{{$disable}}">
                    <input type="hidden" id="Credo_Score" value="{{@$tags->Credo_Score}}" />

                    <dl class="row p-0 m-0 text-end">

                        <dt class="col-sm-6">รวมยอดจัด</dt>
                        <dd class="col-sm-6 border-bottom" id="TotalTop">0.00 ฿</dd>

                        <dd class="col-sm-12 border-bottom" id="TotalTop_sum"><span class="fst-italic">(0.00)</span></dd>

                        <dt class="col-sm-6">ชำระต่องวด</dt>
                        <dd class="col-sm-6 border-bottom" id="Period" style="color: #f96332; font-weight: bold;">
                            0.00 ฿</dd>

                        <dt class="col-sm-6">ระยะเวลาผ่อน</dt>
                        <dd class="col-sm-6 border-bottom" id="Timelack" style="color: #f96332; font-weight: bold;">
                            0 งวด</dd>

                        <dt class="col-sm-6">รวมยอดชำระ</dt>
                        <dd class="col-sm-6 border-bottom border-danger border-2 mb-2"
                            style="box-shadow: 0 2px 0 red;" id="TotalPeriod">0.00 ฿</dd>

                        <dt class="col-sm-6 tax-display">ภาษี</dt>
                        <dd class="col-sm-6 tax-display" id="Tax_Number">0.00 ฿</dd>
                        <dt class="col-sm-6 tax-display">รวมภาษี</dt>
                        <dd class="col-sm-6 tax-display" id="Tax_Total">0.00 ฿</dd>

                        <dt class="col-sm-6 tax-display">ค่างวดดิบ</dt>
                        <dd class="col-sm-6 tax-display" id="Duerate">0.00 ฿</dd>
                        <dt class="col-sm-6 tax-display">รวมค่างวดดิบ</dt>
                        <dd class="col-sm-6 tax-display" id="Duerate_Total">0.00 ฿</dd>

                        <dt class="col-sm-6">รวมดอกเบี้ย</dt>
                        <dd class="col-sm-6" id="Interest_Price">0.00 ฿</dd>

                    </dl>


                </div>

            </div>

            @if ($tags != null && $tags->TagToCulculate != null)
                @method('PUT')
            @endif

        </form>

    </div>

    <div class="modal-footer py-1">

        <div class="d-flex justify-content-between row w-100">
            <div class="d-flex col-12 col-lg-6">
                <button class="btn btn-outline-info btn-sm me-2" id="YearTableBtn" type="button" data-bs-toggle="offcanvas"
                    data-bs-target="#offcanvasYearTable" aria-controls="offcanvasScrolling">
                    <i class="bx bx-table align-middle"></i> ตารางปี
                </button>
                <button class="btn btn-outline-dark btn-sm" id="PrintTableBtn" type="button">
                    <i class="bx bx-printer align-middle"></i> ปริ้นต์ตารางค่างวด
                </button>
            </div>
            <div class="d-flex flex-row-reverse col-12 col-lg-6">

                @if( @$tags->Type_Customer != NULL )

                    <button type="button"
                        class="btn btn-primary btn-sm waves-effect waves-light hover-up btn_SaveCal ms-2" id="btn_SubmitCalculate">
                        <i class="fas fa-download"></i> บันทึก <span class="addSpin"></span>
                    </button>

                @endif

                <button type="button" class="btn btn-secondary btn-sm waves-effect hover-up btn_closeCal"
                    data-bs-dismiss="modal" id="btn_closeCal">
                    <i class="mdi mdi-close-circle-outline"></i> ปิด
                </button>
            </div>
        </div>

    </div>

</div>
