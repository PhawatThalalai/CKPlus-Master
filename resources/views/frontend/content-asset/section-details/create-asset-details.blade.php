
{{--
    ตัวแปร
    asset
        car, moto, land
    type
        new, edit
    assetItem
        ก้อนทรัพย์ที่กำลังเปิดแก้ไข คลาส Data_Assets
--}}

<style>
    #InsuranceDT_datepicker .datepicker.datepicker-dropdown.dropdown-menu,
    #InsuranceActDT_datepicker .datepicker.datepicker-dropdown.dropdown-menu,
    #InsuranceRegisterDT_datepicker .datepicker.datepicker-dropdown.dropdown-menu {
        /* col-auto */
        -webkit-box-flex: 0;
        -ms-flex: 0 0 auto;
        flex: 0 0 auto;
        width: auto;
    }
</style>

<style>
    /* ไอคอน ประกันหมดอายุ */
    .notification-icon-sm {
        height: 1.5rem;
        width: 1.5rem;
    }
</style>
    
<link rel="stylesheet" href="{{ URL::asset('assets/css/datepicker-custom.css') }}">

<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>
<script src="{{ URL::asset('assets/js/input-bx-select.js') }}"></script>

<!-- assetType_input_details เก็บประเภททรัพย์ เผื่อได้ใช้ -->
<input type="hidden" name="assetType_input_details" id="assetType_input_details" value="{{@$asset}}">



@if( @$asset == 'land' )

<!-- ข้อมูลชั่วคราว ที่ดิน -->
<div class="p-0 pt-md-4 py-sm-4 p-xl-4 pt-xl-0 pb-md-4 d-none">
    <div class="row g-2 align-self-center">

        <div class="col-6 col-sm-6 col-lg-6 col-xl-6 mb-0">
            <div class="input-bx">
                <input type="text" id="Mid_Price" name="Mid_Price" class="form-control rounded-0 rounded-start ratePrice text-end" placeholder=" " value="{{ number_format(@$midPrice, 0) }}"/>
                <span>ราคาประเมินที่ดิน</span>
                <button class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled d-flex align-items-center border-start-0 rounded-0 rounded-end">
                    บาท
                </button>
            </div>
        </div>
        
    </div>
</div>


<!-- ข้อมูลการครอบครอง -->
<div class="p-0 pt-md-4 py-sm-4 p-xl-4 pt-xl-0 pb-md-4 ">
    <div class="row g-2 align-self-center">
        <div class="col-sm-6 mt-2" id="OccupiedDT_Land_datepicker">
            <div class="input-bx">
                <input type="text" name="OccupiedDT_Land" id="OccupiedDT_Land" class="form-control rounded-0 rounded-start OccupiedDT" placeholder=" " data-date-format="dd/mm/yyyy" data-date-container="#OccupiedDT_Land_datepicker" data-provide="datepicker"  data-date-disable-touch-keyboard="true" data-date-language="th" data-date-today-highlight="true" value="{{ !empty(@$assetItem->OccupiedDT) ? convertDatePHPToHuman($assetItem->OccupiedDT) : '' }}" autocomplete="off" required>
                <span class="text-danger">วันครอบครองล่าสุด</span>
                <button class="btn btn-outline-primary rounded-end d-flex align-items-center openDatepickerBtn rounded-0 rounded-end" type="button">
                    <i class="fas fa-calendar-alt"></i>
                </button>
            </div>
        </div>
        <div class="col-sm-6 mt-2">
            <div class="input-bx">
                <select name="OccupiedTime_Land" id="OccupiedTime_Land" class="form-select OccupiedTime" data-bs-toggle="tooltip" title="ระยะเวลาครอบครอง" required>
                    <option value="" selected>--- ระยะเวลาครอบครอง ---</option>
                </select>
                <span class="text-danger floating-label">ระยะเวลาครอบครอง</span>
            </div>
        </div>
    </div>
</div>

@else

<!-- ข้อมูลชั่วคราว รถ -->
<div class="p-0 pt-md-4 py-sm-4 p-xl-4 pt-xl-0 pb-md-4 d-none">
    <div class="row g-2 align-self-center">

        <div class="col-6 col-sm-6 col-lg col-xl mb-0">
            <div class="input-bx">
                <input type="text" id="Mid_Price" name="Mid_Price" class="form-control rounded-0 rounded-start ratePrice text-end" placeholder=" " value="{{ number_format(@$midPrice, 0) }}" readonly/>
                <span>ราคากลาง</span>
                <button class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled d-flex align-items-center border-start-0 rounded-0 rounded-end">
                    บาท
                </button>
            </div>
        </div>

        <div class="col-6 col-sm-6 col-lg col-xl mb-0">
            <div class="input-bx">
                <input type="text" id="Vehicle_Miles" name="Vehicle_Miles" class="form-control text-end" placeholder=" " value="{{@$assetItem->Vehicle_Miles}}"/>
                <span>เลขไมล์</span>
            </div>
        </div>
        
    </div>
</div>

<!-- ข้อมูลการครอบครอง -->
<div class="p-0 pt-md-4 py-sm-4 p-xl-4 pt-xl-0 pb-md-4 mt-xl-2">
    <div class="row g-2 align-self-center">
        <div class="col-sm-6 mt-2 OccupiedDT_datepicker" id="OccupiedDT_Veh_datepicker">
            <div class="input-bx">
                <input type="text" name="OccupiedDT_Veh" id="OccupiedDT_Veh" class="form-control rounded-0 rounded-start OccupiedDT" placeholder=" " data-provide="datepicker" data-date-format="dd/mm/yyyy" data-date-container="#OccupiedDT_Veh_datepicker" data-date-autoclose="true" data-date-disable-touch-keyboard="true" data-date-language="th" data-date-today-highlight="true" data-date-enable-on-readonly="true" data-date-clear-btn="true" value="{{ !empty(@$assetItem->OccupiedDT) ? convertDatePHPToHuman($assetItem->OccupiedDT) : ( !empty(@$assetDatailFromTagCal->OccupiedDT) ? convertDatePHPToHuman($assetDatailFromTagCal->OccupiedDT) : '' ) }}" autocomplete="off" readonly required>
                <span class="text-danger">วันครอบครองล่าสุด</span>
                <button class="btn btn-outline-primary rounded-end d-flex align-items-center openDatepickerBtn rounded-0 rounded-end" type="button">
                    <i class="fas fa-calendar-alt"></i>
                </button>
            </div>
        </div>

        <div class="col-sm-6 mt-2">
            <div class="input-bx">
                <select name="OccupiedTime_Veh" id="OccupiedTime_Veh" class="form-select OccupiedTime" data-bs-toggle="tooltip" title="ระยะเวลาครอบครอง" required>
                    <option value="" selected>--- ระยะเวลาครอบครอง ---</option>
                </select>
                <span class="text-danger floating-label">ระยะเวลาครอบครอง</span>
            </div>
        </div>
    </div>
</div>

<!-- ข้อมูลประกัน -->
<div class="p-0 p-xl-4 py-sm-4 pt-1 border-top">
    <div class="row g-2 align-self-center">
        <div class="col-6 col-md-6 mb-0">
            <div class="input-bx">
                <select class="form-select InsuranceState" id="InsuranceState" name="InsuranceState" data-bs-toggle="tooltip" title="สถานะประกัน" required>
                    <option value="" selected>-- สถานะ --</option>
                </select>
                <span class="text-danger floating-label">สถานะประกัน</span>
            </div>
        </div>
        <div class="col-6 col-md-6 mb-0">
            <div class="input-bx">
                <select class="form-select InsuranceClass" id="InsuranceClass" name="InsuranceClass" data-bs-toggle="tooltip" title="ชั้นประกันภัย">
                    <option value="" selected>-- ชั้น --</option>
                </select>
                <span class="floating-label" data-inputid="InsuranceClass">ชั้นประกันภัย</span>
            </div>
        </div>
        <div class="col-6 col-md-6 mb-0">
            <div class="input-bx">
                <select class="form-select" id="InsuranceCompany_Id" name="InsuranceCompany_Id" data-bs-toggle="tooltip" title="บริษัทประกัน">
                    <option value="" selected>-- บริษัทประกัน --</option>
                    @foreach(@$CompanyInsurance as $companyIns)
                        <option value="{{$companyIns->id}}">{{$companyIns->CompanayIns_Name}}</option>
                    @endforeach
                </select>
                <span class="floating-label">บริษัทประกัน</span>
            </div>
        </div>
        <div class="col-sm-6 mt-2">
            <div class="input-bx">
                <input type="text" class="form-control" id="PolicyNumber" name="PolicyNumber" value="{{@$assetItem->PolicyNumber}}" autocomplete="off" placeholder=" "/>
                <span class="">เลขกรมธรรม์</span>
            </div>
        </div>
        <div class="col-sm-12 mt-2">
            @php
                if ( !empty(@$assetItem->InsuranceDT) ) {
                    list($ins_startDate, $ins_endDate) = convertDateRangePHPToHuman($assetItem->InsuranceDT);
                } 
            @endphp
            <div class="input-daterange input-group text-center row g-0" id="InsuranceDT_datepicker" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#InsuranceDT_datepicker" data-date-disable-touch-keyboard="true" data-date-language="th" data-date-today-highlight="true" data-date-enable-on-readonly="false">
                <div class="input-bx col">
                    <input type="text" class="form-control rounded-start" name="InsuranceDT_start" id="InsuranceDT_start" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" placeholder=" " autocomplete="off" value="{{@$ins_startDate}}" @required(@$asset == 'car')>
                    <span @class(['text-danger' => @$asset == 'car'])>วันที่ต่อประกัน</span>
                </div>
                <div class="input-bx col">
                    <input type="text" class="form-control rounded-0" name="InsuranceDT_end" id="InsuranceDT_end" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" placeholder=" " autocomplete="off" value="{{@$ins_endDate}}" @required(@$asset == 'car')>
                    <span @class(['text-danger' => @$asset == 'car'])>วันประกันหมดอายุ</span>
                </div>
                <button class="btn btn-outline-primary dropdown-toggle py-0 px-2 col-2 rounded-end dropdown-InsuranceDT" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-calendar fs-4"></i>
                    <i class="mdi mdi-chevron-down fs-5"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end col-auto">
                    <li><a class="dropdown-item _7daysInsExpBtn" href="#" id="7DaysInsurExpBtn">เลือก 7 วันล่วงหน้า</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item _1yearInsExpBtn" href="#">ใส่วันหมดอายุ 1 ปี</a></li>
                </ul>
                <span class="dateexp-feedback badge bg-warning text-center align-items-center my-1 rounded-pill" style="">
                    <span class="align-middle ml-auto me-0 fw-bold" style="font-size: 0.75rem; color:#000000">
                      วันคุ้มครองประกัน หมดอายุแล้ว
                    </span>
                    <img src="{{ asset('assets/images/gif/system_outline/warning.gif') }}" alt="" class="notification-icon-sm">
                </span>
            </div>
        </div>

    </div>
</div>

<!-- ข้อมูล พ.ร.บ. / ทะเบียน -->
<div class="p-0 p-xl-4 py-sm-4 pt-xl-0 pt-sm-0">
    <div class="row g-2 align-self-center">
        
        <div class="col-sm-12 mt-2" id="InsuranceActDT_container">
            @php
                if ( !empty(@$assetItem->InsuranceActDT) ) {
                    list($insAct_startDate, $insAct_endDate) = convertDateRangePHPToHuman($assetItem->InsuranceActDT);
                }
            @endphp
            <div class="input-daterange input-group text-center row g-0" id="InsuranceActDT_datepicker" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#InsuranceActDT_container" data-date-disable-touch-keyboard="true" data-date-language="th" data-date-today-highlight="true">
                <div class="input-bx col">
                    <input type="text" class="form-control rounded-start" name="InsuranceActDT_start" id="InsuranceActDT_start" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" placeholder=" " value="{{@$insAct_startDate}}" autocomplete="off" required>
                    <span class="text-danger">วันที่ต่อ พ.ร.บ.</span>
                </div>
                <div class="input-bx col">
                    <input type="text" class="form-control rounded-0" name="InsuranceActDT_end" id="InsuranceActDT_end" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" placeholder=" " value="{{@$insAct_endDate}}" autocomplete="off" required>
                    <span class="text-danger">วัน พ.ร.บ. หมดอายุ</span>
                </div>
                <button class="btn btn-outline-primary dropdown-toggle py-0 px-2 col-2 rounded-end" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-calendar fs-4"></i>
                    <i class="mdi mdi-chevron-down fs-5"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end col-auto">
                    <li><a class="dropdown-item _7daysInsExpBtn" href="#">เลือก 7 วันล่วงหน้า</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item _1yearInsExpBtn" href="#">ใส่วันหมดอายุ 1 ปี</a></li>
                </ul>
                <span class="dateexp-feedback badge bg-warning text-center align-items-center my-1 rounded-pill" style="">
                    <span class="align-middle ml-auto me-0 fw-bold" style="font-size: 0.75rem; color:#000000">
                      วันคุ้มครอง พ.ร.บ. หมดอายุแล้ว
                    </span>
                    <img src="{{ asset('assets/images/gif/system_outline/warning.gif') }}" alt="" class="notification-icon-sm">
                </span>
            </div>
        </div>

        <div class="col-sm-12 mt-2">
            @php
                if ( !empty(@$assetItem->InsuranceRegisterDT) ) {
                    list($insReg_startDate, $insReg_endDate) = convertDateRangePHPToHuman($assetItem->InsuranceRegisterDT);
                }
            @endphp
            <div class="input-daterange input-group text-center row g-0" id="InsuranceRegisterDT_datepicker" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#InsuranceRegisterDT_datepicker" data-date-disable-touch-keyboard="true" data-date-language="th" data-date-today-highlight="true">
                <div class="input-bx col">
                    <input type="text" class="form-control rounded-start" name="InsuranceRegisterDT_start" id="InsuranceRegisterDT_start" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" autocomplete="off" placeholder=" " value="{{@$insReg_startDate}}" required>
                    <span class="text-danger">วันที่ต่อทะเบียน</span>
                </div>
                <div class="input-bx col">
                    <input type="text" class="form-control rounded-0" name="InsuranceRegisterDT_end" id="InsuranceRegisterDT_end" pattern="[0-9]{2}/[0-9]{2}/[0-9]{4}" autocomplete="off" placeholder=" " value="{{@$insReg_endDate}}" required>
                    <span class="text-danger">วันทะเบียนหมดอายุ</span>
                </div>
                <button class="btn btn-outline-primary dropdown-toggle py-0 px-2 col-2 rounded-end" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="mdi mdi-calendar fs-4"></i>
                    <i class="mdi mdi-chevron-down fs-5"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end col-auto">
                    <li><a class="dropdown-item _7daysInsExpBtn" href="#">เลือก 7 วันล่วงหน้า</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item _1yearInsExpBtn" href="#">ใส่วันหมดอายุ 1 ปี</a></li>
                </ul>
                <span class="dateexp-feedback badge bg-warning text-center align-items-center my-1 rounded-pill" style="">
                    <span class="align-middle ml-auto me-0 fw-bold" style="font-size: 0.75rem; color:#000000">
                      วันคุ้มครองทะเบียน หมดอายุแล้ว
                    </span>
                    <img src="{{ asset('assets/images/gif/system_outline/warning.gif') }}" alt="" class="notification-icon-sm">
                </span>
            </div>
        </div>

    </div>
</div>

<!-- ข้อมูลอื่น ๆ -->
<div class="p-0 p-xl-4 py-sm-4 pt-xl-0 pt-sm-0">
    <div class="row g-2 align-self-center">

        <div class="col-6 col-md-6 mb-0">
            <div class="input-bx">
                <select class="form-select PurposeType" id="PurposeType" name="PurposeType" data-bs-toggle="tooltip" title="รูปแบบรถยนต์">
                    <option value="" selected>-- รูปแบบรถยนต์ --</option>
                </select>
                <span class="floating-label">รูปแบบรถยนต์</span>
            </div>
        </div>
        <div class="col-6 col-md-6 mb-0">
            <div class="input-bx">
                <select class="form-select {{ @$assetDatailFromTagCal->PossessionState_Code != NULL ? 'has-value' : '' }}" id="PossessionState_Code" name="PossessionState_Code" data-bs-toggle="tooltip" title="สถานะครอบครอง">
                    <option value="" selected>-- สถานะครอบครอง --</option>
                    @if( @$assetItem != null )
                        @foreach(@$typePoss as $key => $value)
                            <option value="{{ $value->Code_TypePoss }}" {{ @$assetItem->PossessionState_Code == $value->Code_TypePoss ? 'selected' : '' }}>{{ $value->Name_TypePoss}}</option>
                        @endforeach
                    @elseif( @$assetDatailFromTagCal != null )
                        @foreach(@$typePoss as $key => $value)
                            <option value="{{ $value->Code_TypePoss }}" {{ @$assetDatailFromTagCal->PossessionState_Code == $value->Code_TypePoss ? 'selected' : '' }}>{{ $value->Name_TypePoss}}</option>
                        @endforeach
                    @else
                        @foreach(@$typePoss as $key => $value)
                            <option value="{{ $value->Code_TypePoss }}">{{ $value->Name_TypePoss}}</option>
                        @endforeach
                    @endif
                </select>
                <span class="floating-label">สถานะครอบครอง</span>
            </div>
        </div>
        <div class="col-6 col-md-6 mb-0">
            <div class="input-bx">
                <select class="form-select PossessionOrder" id="PossessionOrder" name="PossessionOrder" data-bs-toggle="tooltip" title="ลำดับครองครอง">
                    <option value="" selected>-- ลำดับครองครอง --</option>
                </select>
                <span class="floating-label">ลำดับครองครอง</span>
            </div>
        </div>
        <div class="col-6 col-md-6 mb-0">
            <div class="input-bx">
                <select class="form-select History_16" id="History_16" name="History_16" data-bs-toggle="tooltip" title="ประวัติหน้า 16">
                    <option value="" selected>-- ประวัติหน้า 16 --</option>
                </select>
                <span class="floating-label">ประวัติหน้า 16.</span>
            </div>
        </div>
        <div class="col-12 mb-0">
            <div class="input-bx">
                <select class="form-select History_18" id="History_18" name="History_18" data-bs-toggle="tooltip" title="ประวัติหน้า 18">
                    <option value="" selected>-- ประวัติหน้า 18 --</option>
                </select>
                <span class="floating-label">ประวัติหน้า 18.</span>
            </div>
        </div>
    </div>
    
</div>

@endif


@include('frontend.content-asset.script')