<style>
    .card-wall-asset {
        position: relative;
    }
    .card-wall-asset:before {
        content: ' ';
        display: block;
        position: absolute;
        left: 0;
        top: 25%;
        width: 100%;
        height: 75%;
        opacity: 0.45;
        background-image: url("{{ asset('/assets/images/undraw/undraw_empty_street.svg') }}");
        background-repeat: no-repeat;
        background-position: bottom, right;
        background-size: contain;
    }
    .card-wall-content {
        position: relative;
    }

</style>

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

    .card-wall-pic-asset {
        display: flex;
        align-content: flex-end;
        flex-wrap: wrap;
        margin-top: 1rem;
        margin-bottom: 2rem;
        flex: 1;
    }

    .license-car-plate {
        display: flex;
        align-content: flex-start;
        flex-wrap: wrap;
        flex: 1;
        justify-content: center;
    }

    @media (min-width: 992px) {
        .card-wall-pic-asset {
            display: flex;
            align-content: flex-end;
            flex-wrap: wrap;
            margin-top: 1rem;
            margin-bottom: 2rem;
            flex: none;
        }
    }

    @media (min-width: 1200px) {
        .card-wall-pic-asset {
            display: flex;
            align-content: flex-end;
            flex-wrap: wrap;
            margin-top: 5rem;
            margin-bottom: 1rem
            flex: 1;
        }
    }

</style>

<style>
    .input-bx input:focus ~ .help-input-message {
        opacity: 1;
        transform: translateY(0);
    }

    .help-input-message {
        display: block;
        position: absolute;
        top: 100%;
        opacity: 0;
        transform: translateY(10px);
        transition: opacity 0.3s, transform 0.3s;
        white-space: nowrap;
        pointer-events: none;
        z-index: 4;
    }
</style>

<link rel="stylesheet" href="{{ URL::asset('assets/css/datepicker-custom.css') }}">

<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>
<script src="{{ URL::asset('assets/js/input-bx-select.js') }}"></script>

<div class="modal-content">
	
	<div class="modal-body">
		<div class="d-flex m-3 mb-0">
			<div class="flex-shrink-0 me-2">
				<img src="{{ asset('assets/images/gif/suitcase.gif') }}" alt="" class="avatar-sm">
			</div>
			<div class="flex-grow-1 overflow-hidden">
				<h5 class="text-primary fw-semibold">{{ @$title }}</h5>
				<p class="text-muted mt-n1 fw-semibold font-size-12">{{ @$subtitle }}</p>
				<p class="border-primary border-bottom mt-n2"></p>
			</div>
			<button type="button" class="btn-close btn-disabled btn_closeAsset" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
        
        <!-- assetType สำหรับใช้แยกประเภทว่าสร้างทรัพย์อะไร -->
        <input type="hidden" id="assetType_input" name="assetType_input" value="{{@$asset}}">

        <!-- newAsset_DataCusId สำหรับใช้จำไอดีลูกค้า -->
        <input type="hidden" id="newAsset_DataCusId" name="newAsset_DataCusId" value="{{@$dataCusId}}">

        <!-- dataOwnerId สำหรับใช้จำไอดี Ownership -->
        <input type="hidden" id="asset_DataOwnId" name="asset_DataOwnId" value="{{@$dataOwnId}}">

        <div class="row">

            @if(@$asset == 'car' || @$asset == 'moto')
            <!-- ฟอร์ม ยานพาหนะ -->
            <form id="formCreateVehicle" class="needs-validation" action="#" novalidate>
                @csrf
                <input type="hidden" name="title" value="{{ @$title }}">
                <input type="hidden" name="asset_id" id="asset_id" value="{{ @$assetItem->id }}">
                @if( @$type == 'new')
                    <input type="hidden" name="dataTagCal_id" value="{{ @$assetFromTagCal != NULL && @$assetFromTagCal->dataTagCal_id != NULL ? @$assetFromTagCal->dataTagCal_id : ''}}" />
                @elseif( @$type == 'edit' )
                    <input type="hidden" name="dataTagCal_id" value="{{ @$assetItem->dataTagCal_id }}" />
                @endif

                <!-- การ์ดยานพาหนะ -->
                <div class="card px-0 rounded-0 m-0 card-asset-input" id="card-careate-vehicle" @style([
                    "display: none;" => @$asset != 'car' && @$asset != 'moto', 
                    ])>

                    <div class="row g-0 mb-0">
                        <div class="col-xl-2 col-lg-3 col-12">
            
                            <!-- การ์ดกำแพงฝั่งซ้าย -->
                            <div class="card rounded-0 m-0 text-center bg-primary bg-soft h-100">
                                <div class="card-body px-2 h-100">

                                    <div class="d-flex flex-column align-items-stretch h-100">
                                        
                                        <h5 class="fw-bold bg-primary bg-opacity-25 rounded-3 py-2 d-flex align-items-center px-2">
                                            <span id="createAsset_label_veh" class="flex-fill">
                                                @if( @$asset == 'car')
                                                    รถยนต์
                                                @elseif( @$asset == 'moto')
                                                    มอเตอร์ไซค์
                                                @endif
                                            </span>
                                        </h5>
                                        
                                        {{-- 
                                        <div class="d-none d-sm-flex h-100 d-flex align-items-center">
                                            <div class="avatar-md col text-center mb-md-4">
                                                <img
                                                    id="createAsset_profile_veh"
                                                    @if( @$asset == 'car')
                                                        src="{{ asset('/assets/images/asset/astCar.png') }}" 
                                                    @elseif( @$asset == 'moto')
                                                        src="{{ asset('/assets/images/asset/motorbike.png') }}" 
                                                    @endif
                                                    style="min-width: 8rem;height: 8rem;"
                                                    class="img-thumbnail rounded-circle hover-up mb-2 boreder-img" alt="User-Profile-Image">
                                            </div>
                                        </div>
                                        
                                        <div class="container mt-0 mt-sm-5 mt-md-2">
                                            <div class="row">
                                                <div class="col-auto m-auto">
                                                    <div class="license-plate bg-white text-dark border border-dark px-4 py-2">
                                                        กข 1234
                                                        <div class="province">Bangkok</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        --}}

                                        <div class="d-flex flex-column align-items-stretch h-100">

                                            <div class="card-wall-pic-asset">
                                                <div class="avatar-md col text-center mb-md-4">
                                                    <img
                                                        id="createAsset_profile_veh"
                                                        @if( @$asset == 'car')
                                                            src="{{ asset('/assets/images/asset/astCar.png') }}" 
                                                        @elseif( @$asset == 'moto')
                                                            src="{{ asset('/assets/images/asset/motorbike.png') }}" 
                                                        @endif
                                                        style="min-width: 8rem;height: 8rem;"
                                                        class="img-thumbnail rounded-circle hover-up mb-2 boreder-img" alt="User-Profile-Image">
                                                </div>
                                            </div>
                                            <div class="license-car-plate">
                                                <div class="p-2 bg-light text-dark border border-dark flex-grow-0 flex-lg-grow-1 w-50">
                                                    @if( @$asset == 'car')
                                                        <h3 class="m-0 fw-bold text-dark">
                                                            <span id="license_text">กข</span>
                                                            <span id="license_number">1234</span>
                                                        </h3>
                                                        <span id="license_province">กรุงเทพมหานคร</span>
                                                    @elseif( @$asset == 'moto')
                                                        <h3 class="m-0 fw-bold text-dark" id="license_text">กขค</h3>
                                                        <span id="license_province">กรุงเทพมหานคร</span>
                                                        <h3 class="m-0 fw-bold text-dark" id="license_number">123</h3>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                    </div>
            
                                </div>
                            </div>
            
                        </div>
                        <div class="col-xl-10 col-lg-9 col-md-12 col-12">
                            <div class="card rounded-0 m-0">
                                <div class="card-body py-1">
            
                                    <div class="row">
                                        <!-- คอลัมน์ฝั่งซ้าย -->
                                        <div class="col-12 col-lg-12 col-xl-6">

                                            <!-- ข้อมูล ป้ายทะเบียนเก่า -->
                                            <fieldset class="reset rounded-3 border-primary border-opacity-10">
                                                @php
                                                    //-------------------------------
                                                    //$province_license_opt = App\Models\TB_Constants\TB_Frontend\TB_Provinces::select('Province_pro')
                                                        //->orderBY('Province_pro', 'ASC')
                                                        //->distinct()
                                                        //->get();

                                                    $province_license_opt = App\Models\TB_Constants\TB_Frontend\TB_ProvincesDLT::getProvincesDLT();
                                                    //-------------------------------
                                                    $v_oldLicense = "";
                                                    if ( @$assetItem != null ) {
                                                        if ( empty(@$assetItem->Vehicle_OldLicense_Text) ) {
                                                            $v_oldLicense = @$assetItem->Vehicle_OldLicense;
                                                        } else {
                                                            $v_oldLicense = @$assetItem->Vehicle_OldLicense_Text;
                                                        }
                                                    }
                                                    //-------------------------------
                                                    $v_newLicense = "";
                                                    if ( @$assetItem != null ) {
                                                        if ( empty(@$assetItem->Vehicle_NewLicense_Text) ) {
                                                            $v_newLicense = @$assetItem->Vehicle_NewLicense;
                                                        } else {
                                                            $v_newLicense = @$assetItem->Vehicle_NewLicense_Text;
                                                        }
                                                    }
                                                    //-------------------------------
                                                @endphp
                                                <legend class="reset text-primary fw-bold px-2" style="letter-spacing: 0.1rem">ป้ายทะเบียนเก่า</legend>
                                                <div class="px-2">
                                                    <div class="mb-2">
                                                        <div class="row g-0 m-0">
                                                            <div class="col-4 pe-1">
                                                                <div class="input-bx">
                                                                    <input type="text" class="form-control text-center license-input" id="Vehicle_OldLicense_Text" name="Vehicle_OldLicense_Text" data-bs-toggle="tooltip" title="ป้ายทะเบียนเดิม" placeholder=" " value="{{@$v_oldLicense}}" autocomplete="off" data-namealert="ป้ายทะเบียน(อักษร/คำ)" required/>
                                                                    <span class="text-danger">อักษร/คำ</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 px-1">
                                                                <div class="input-bx">
                                                                    <input type="text" class="form-control text-center license-input" id="Vehicle_OldLicense_Number" name="Vehicle_OldLicense_Number" data-bs-toggle="tooltip" title="ป้ายทะเบียนเดิม" placeholder=" " value="{{@$assetItem->Vehicle_OldLicense_Number}}" autocomplete="off" data-namealert="ป้ายทะเบียน(ตัวเลข)" required/>
                                                                    <span class="text-danger">ตัวเลข</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 ps-1">
                                                                <div>
                                                                    <select class="form-select select2 province-license-select license-input" id="Vehicle_OldLicense_Province" name="Vehicle_OldLicense_Province" data-placeholder="จังหวัด" data-namealert="ป้ายทะเบียน(จังหวัด)" required>
                                                                        <option value="" selected>--- เลือกจังหวัด ---</option>
                                                                        @foreach( $province_license_opt as $province_item )
                                                                            @if( @$assetItem != null )
                                                                                <option value="{{$province_item->Province_pro}}" {{ (@$assetItem->Vehicle_OldLicense_Province == @$province_item->Province_pro) ? "selected" : "" }}>{{$province_item->Province_pro}}</option>
                                                                            @else
                                                                                <option value="{{$province_item->Province_pro}}">{{$province_item->Province_pro}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    
                                                </div>
                                            </fieldset>

                                            <!-- ข้อมูล ป้ายทะเบียนใหม่ -->
                                            <fieldset class="reset rounded-3 border-primary border-opacity-10 mt-2">
                                                <legend class="reset text-primary fw-bold px-2" style="letter-spacing: 0.1rem">ป้ายทะเบียนใหม่ <small>(เช่าซื้อ)</small></legend>
                                                <div class="px-2">
                                                    <div class="mb-2">
                                                        <div class="row g-0 m-0">
                                                            <div class="col-4 pe-1">
                                                                <div class="input-bx">
                                                                    <input type="text" class="form-control text-center license-input" id="Vehicle_NewLicense_Text" name="Vehicle_NewLicense_Text" data-bs-toggle="tooltip" title="ป้ายทะเบียนใหม่ (ถ้ามี)" placeholder=" " value="{{@$v_newLicense}}" autocomplete="off" data-namealert="ป้ายทะเบียนใหม่(อักษร/คำ)"/>
                                                                    <span class="">อักษร/คำ</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 px-1">
                                                                <div class="input-bx">
                                                                    <input type="text" class="form-control text-center license-input" id="Vehicle_NewLicense_Number" name="Vehicle_NewLicense_Number" data-bs-toggle="tooltip" title="ป้ายทะเบียนใหม่ (ถ้ามี)" placeholder=" " value="{{@$assetItem->Vehicle_NewLicense_Number}}" autocomplete="off" data-namealert="ป้ายทะเบียนใหม่(ตัวเลข)"/>
                                                                    <span class="">ตัวเลข</span>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 ps-1">
                                                                <div>
                                                                    <select class="form-select select2 province-license-select license-input" id="Vehicle_NewLicense_Province" name="Vehicle_NewLicense_Province" data-placeholder="จังหวัด" data-namealert="ป้ายทะเบียนใหม่(จังหวัด)">
                                                                        <option value="" selected>--- เลือกจังหวัด ---</option>
                                                                        @foreach( $province_license_opt as $province_item )
                                                                            @if( @$assetItem != null )
                                                                                <option value="{{$province_item->Province_pro}}" {{-- (@$assetItem->Vehicle_NewLicense_Province == @$province_item->Province_pro) ? "selected" : "" --}}>{{$province_item->Province_pro}}</option>
                                                                            @else
                                                                                <option value="{{$province_item->Province_pro}}">{{$province_item->Province_pro}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    
                                                </div>
                                            </fieldset>
                                            
                                            <!-- ข้อมูลทั่วไปรถ -->
                                            <div class="p-0 p-xl-4 pt-xl-2 pt-lg-2 pt-md-2 pt-sm-2 py-sm-4">

                                                {{-- 
                                                <div class="row g-2 align-self-center">
                                                    <div class="col-sm-6 mt-2">
                                                        <div class="input-bx">
                                                            <input type="text" class="form-control" id="Vehicle_OldLicense" name="Vehicle_OldLicense" data-bs-toggle="tooltip" title="ป้ายทะเบียนเดิม" placeholder=" " value="{{@$assetItem->Vehicle_OldLicense}}" required/>
                                                            <span class="text-danger">ทะเบียนเก่า</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 mt-2">
                                                        <div class="input-bx">
                                                            <input type="text" class="form-control" class="form-control form-control-sm textSize-13" id="Vehicle_NewLicense" name="Vehicle_NewLicense" data-bs-toggle="tooltip" title="(ถ้าไม่มีไม่ต้องใส่)" placeholder=" " value="{{@$assetItem->Vehicle_NewLicense}}"/>
                                                            <span>ทะเบียนใหม่</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                --}}

                                                <div class="col-sm-12 my-2 position-relative">
                                                    <div class="input-bx">
                                                        <input type="text" class="form-control rounded-0 rounded-start" id="Vehicle_Chassis" name="Vehicle_Chassis" data-bs-toggle="tooltip" title="ระบุเลขถังอย่างน้อย 5 หลัก" data-fail="{{ empty(@$assetItem->Vehicle_Chassis) ? 'true' : 'false' }}" placeholder=" " value="{{@$assetItem->Vehicle_Chassis}}" autocomplete="off" required/>
                                                        <span class="text-danger">เลขถัง</span>
                                                        <button id="Progress_Chassis" class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled d-flex align-items-center bg-info text-white rounded-0 rounded-end" style="opacity: 1;">
                                                            <div class="spinner-border spinner-border-sm" role="status">
                                                                <span class="visually-hidden">Loading...</span>
                                                            </div>
                                                        </button>
                                                        <button id="Pass_Chassis" class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled d-flex align-items-center bg-success text-white rounded-0 rounded-end" style="opacity: 1;">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                        <button id="Fail_Chassis" class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled d-flex align-items-center bg-danger text-white rounded-0 rounded-end" style="opacity: 1;">
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                        <p class="help-input-message mt-1 p-2 badge font-size-12 fw-bold text-dark bg-warning">ใส่เฉพาะตัวเลข ตัวอักษรภาษาอังกฤษพิมพ์ใหญ่ หรือจุด(.) เท่านั้น</p>
                                                    </div>
                                                    
                                                </div>
                                                <div class="row g-2 align-self-center">
                                                    <div class="col-sm-auto my-2 d-flex align-items-center">
                                                        <div class="form-check form-check-inline">
                                                            <input class="form-check-input" type="checkbox" id="Vehicle_HasNewChassis" value="Vehicle_HasNewChassis" @checked(!empty(@$assetItem->Vehicle_NewChassis))>
                                                            <label class="form-check-label" for="Vehicle_HasNewChassis">มีกำหนดตอกเลขตัวรถใหม่</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm my-2">
                                                        <div class="input-bx">
                                                            <input type="text" class="form-control" id="Vehicle_NewChassis" name="Vehicle_NewChassis" placeholder=" " value="{{@$assetItem->Vehicle_NewChassis}}" autocomplete="off" @readonly(empty(@$assetItem->Vehicle_NewChassis))/>
                                                            <span class="" data-inputid="Vehicle_NewChassis">เลขตัวรถใหม่</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-2 align-self-center">
                                                    <div class="col-sm-6 my-2">
                                                        <div class="input-bx">
                                                            <input type="text" class="form-control" id="Vehicle_Engine" name="Vehicle_Engine" placeholder=" " value="{{@$assetItem->Vehicle_Engine}}" autocomplete="off" required/>
                                                            <span class="text-danger">เลขเครื่อง</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 my-2">
                                                        <div class="input-bx">
                                                            <input type="text" class="form-control" id="Vehicle_Color" name="Vehicle_Color" placeholder=" " value="{{@$assetItem->Vehicle_Color}}" required/>
                                                            <span class="text-danger">สีรถ</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-2 align-self-center">
                                                    <div class="col-sm-6 mt-2">
                                                        <div class="input-bx">
                                                            <input type="text" class="form-control" id="Vehicle_Miles" name="Vehicle_Miles" placeholder=" " data-bs-toggle="tooltip" title="เลขไมล์" value="{{@$assetItem->Vehicle_Miles}}" autocomplete="off" required/>
                                                            <span class="text-danger">เลขไมล์</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 mt-2">
                                                        <div class="input-bx">
                                                            <input type="text" class="form-control" id="Vehicle_CC" name="Vehicle_CC" placeholder=" " data-bs-toggle="tooltip" title="CC" value="{{@$assetItem->Vehicle_CC}}" autocomplete="off" required/>
                                                            <span class="text-danger">CC</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- ข้อมูลประเภทรถ -->
                                            <div class="p-0 pt-md-4 py-sm-4 p-xl-4 pb-md-4 border-top">
                                                <div class="row g-2 align-self-center">

                                                    <div class="col-6 col-md-6 mb-0">
                                                        <div class="input-bx">
                                                            <select class="form-select typeAsset" id="Vehicle_Type" name="Vehicle_Type" data-bs-toggle="tooltip" title="ประเภทรถ 1" required>
                                                                <option value="" selected>-- ประเภทรถ 1 --</option>
                                                                @if( @$typeRate != null )
                                                                    @foreach( @$typeRate as $key => $value)
                                                                        @if( strtolower(@$value->type_car) == $asset )
                                                                            {{-- ถ้ามีข้อมูล assetItem อยู่จริง ให้เพิ่ม selected --}}
                                                                            @if( @$assetItem != null )
                                                                                @if( @$type == 'view' || @$type == 'edit' )
                                                                                    <option value="{{ $value->code_car }}" {{ ($assetItem->Vehicle_Type == @$value->code_car) || ($assetItem->Land_Type == @$value->code_car) ? "selected" : "" }}>{{ $value->nametype_car }}</option>
                                                                                @else
                                                                                    <option value="{{ $value->code_car }}">{{ $value->nametype_car }}</option>
                                                                                @endif
                                                                            @elseif( @$assetFromTagCal != NULL )
                                                                                {{-- ถ้ามีข้อมูล ทรัพย์จาก Tag คำนวณ อยู่จริง ให้เพิ่ม selected --}}
                                                                                <option value="{{ $value->code_car }}" {{ ($assetFromTagCal->Vehicle_Type == @$value->code_car) || ($assetFromTagCal->Land_Type == @$value->code_car) ? "selected" : "" }}>{{ $value->nametype_car }}</option>
                                                                            @else
                                                                                <option value="{{ $value->code_car }}">{{ $value->nametype_car }}</option>
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <span class="text-danger floating-label">ประเภทรถ 1</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6 col-md-6 mb-0">
                                                        <div class="input-bx">
                                                            <select class="form-select Type_PLT" id="Vehicle_Type_PLT" name="Vehicle_Type_PLT" data-bs-toggle="tooltip" title="ประเภทรถ 2" required>
                                                                <option value="" selected>-- ประเภทรถ 2 --</option>
                                                            </select>
                                                            <span class="text-danger floating-label">ประเภทรถ 2</span>
                                                        </div>
                                                    </div>
                                                    

                                                    <div class="col-6 col-md-6 col-lg-5 col-xl-6 mb-0">
                                                        <div class="input-bx">
                                                            <select class="form-select brandAsset" id="Vehicle_Brand" name="Vehicle_Brand" data-bs-toggle="tooltip" title="ยี่ห้อรถ" required>
                                                                <option value="" selected>--- ยี่ห้อรถ ---</option>
                                                            </select>
                                                            <span class="text-danger floating-label">ยี่ห้อรถ</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-6 col-md-6 col-lg-4 col-xl-6 mb-0">
                                                        <div class="input-bx">
                                                            <select class="form-select groupAsset" id="Vehicle_Group" name="Vehicle_Group" data-bs-toggle="tooltip" title="กลุ่มรถ" required>
                                                                <option value="" selected>--- กลุ่มรถ ---</option>
                                                            </select>
                                                            <span class="text-danger floating-label">กลุ่มรถ</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-6 col-md-6 col-lg-3 col-xl-6 mb-0">
                                                        <div class="input-bx">
                                                            <select class="form-select yearAsset" data-bs-toggle="tooltip" id="Vehicle_Year" title="ปีรถ" required>
                                                                <option value="" selected>--- ปีรถ ---</option>
                                                            </select>
                                                            <span class="text-danger floating-label">ปีรถ</span>
                                                        </div>
                                                        <input type="hidden" name="Vehicle_Year" class="rateYear">
                                                    </div>

                                                    <div class="col-6 col-md-6 col-lg col-xl-6 mb-0">
                                                        <div class="input-bx">
                                                            <select class="form-select modelAsset" id="Vehicle_Model" name="Vehicle_Model" data-bs-toggle="tooltip" title="รุ่นรถ" required>
                                                                <option value="" selected>--- รุ่นรถ ---</option>
                                                            </select>
                                                            <span class="text-danger floating-label">รุ่นรถ</span>
                                                        </div>
                                                    </div>

                                                    <div class="row g-2 m-0 p-0">

                                                        <div class="col-6 col-md-6 col-lg-auto col-xl-6 mb-0 showGear" @style([
                                                            'display: none;' => @$asset != 'car'
                                                            ])>
                                                            <div class="input-bx">
                                                                <select class="form-select gearCar" id="Vehicle_Gear" name="Vehicle_Gear" data-bs-toggle="tooltip" title="เกียร์รถ" @required(@$asset == 'car')>
                                                                    <option value="" selected>--- เกียร์รถ ---</option>
                                                                </select>
                                                                <span @class(['floating-label', 'text-danger' => @$asset == 'car'])>เกียร์รถ</span>
                                                            </div>
                                                        </div>
    
                                                        <div class="col-6 col-sm-6 col-lg col-xl mb-0">
                                                            <div class="input-bx">
                                                                <input type="text" id="Mid_Price" name="Mid_Price" class="form-control rounded-0 rounded-start ratePrice text-end" placeholder=" " value="{{@$assetItem->Mid_Price}}" readonly/>
                                                                <span>ราคากลาง</span>
                                                                <button class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled d-flex align-items-center border-start-0 rounded-0 rounded-end">
                                                                    บาท
                                                                </button>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    

                                                </div>
                                            </div>

                                        </div>
                                        <!-- คอลัมน์ฝั่งขวา -->
                                        <div class="col-12 col-lg-12 col-xl-6">

                                            <!-- ข้อมูลการครอบครอง -->
                                            <div class="p-0 pt-md-4 py-sm-4 p-xl-4 pt-xl-0 pb-md-4 mt-xl-2">
                                                <div class="row g-2 align-self-center">
                                                    <div class="col-sm-6 mt-2 OccupiedDT_datepicker" id="OccupiedDT_Veh_datepicker">
                                                        <div class="input-bx">
                                                            <input type="text" name="OccupiedDT_Veh" id="OccupiedDT_Veh" class="form-control rounded-0 rounded-start OccupiedDT" placeholder=" " data-date-format="dd/mm/yyyy" data-date-container="#OccupiedDT_Veh_datepicker" data-provide="datepicker" data-date-autoclose="true" data-date-disable-touch-keyboard="true" data-date-language="th" data-date-today-highlight="true" value="{{ !empty(@$assetItem->OccupiedDT) ? convertDatePHPToHuman($assetItem->OccupiedDT) : ( !empty(@$assetDatailFromTagCal->OccupiedDT) ? convertDatePHPToHuman($assetDatailFromTagCal->OccupiedDT) : '' ) }}" autocomplete="off" required>
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
                                            <div class="p-0 p-xl-4 py-sm-4 border-top">
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
                                            <div class="p-0 p-xl-4 py-sm-4 border-top">
                                                <div class="row g-2 align-self-center">
                                                    
                                                    <div class="col-sm-12 mt-2">
                                                        @php
                                                            if ( !empty(@$assetItem->InsuranceActDT) ) {
                                                                list($insAct_startDate, $insAct_endDate) = convertDateRangePHPToHuman($assetItem->InsuranceActDT);
                                                            }
                                                        @endphp
                                                        <div class="input-daterange input-group text-center row g-0" id="InsuranceActDT_datepicker" data-date-format="dd/mm/yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#InsuranceActDT_datepicker" data-date-disable-touch-keyboard="true" data-date-language="th" data-date-today-highlight="true">
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
                                            <div class="p-0 p-xl-4 py-sm-4 border-top">
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

                                        </div>
                                    </div>
            
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </form>
            @endif

            @if(@$asset == 'land')
            <!-- ฟอร์ม ที่ดิน -->
            <form id="formCreateLand" class="needs-validation" action="#" novalidate>
                @csrf
                <input type="hidden" name="funs" id="funs" value="{{ @$funs }}">
                <input type="hidden" name="title" value="{{ @$title }}">
                <input type="hidden" name="asset_id" id="asset_id" value="{{ @$assetItem->id }}">
                <input type="hidden" name="dataTagCal_id" value="{{ @$assetFromTagCal != NULL && @$assetFromTagCal->dataTagCal_id != NULL ? @$assetFromTagCal->dataTagCal_id : ''}}" />

                <!-- การ์ดที่ดิน -->
                <div class="card px-0 rounded-0 m-0 card-asset-input" id="card-careate-land" @style([
                    "display: none;" => @$asset != 'land',
                    ])>
                    <div class="row g-0 mb-0">
                        <div class="col-xl-2 col-lg-3 col-12">
            
                            <div class="card rounded-0 m-0 text-center bg-primary bg-soft h-100">
                                <div class="card-body px-2 h-100">
                                    
                                    <div class="d-flex flex-column align-items-stretch h-100">
                                        
                                        <h5 class="fw-bold bg-primary bg-opacity-25 rounded-3 py-2 d-flex align-items-center px-2">
                                            <span class="flex-fill">
                                                ที่ดิน
                                            </span>
                                        </h5>

                                        <div class="d-none d-sm-flex h-100 d-flex align-items-center">
                                            <div class="avatar-md col text-center mb-md-4">
                                                <img id="createAsset_profile_veh" src="{{ asset('/assets/images/asset/real-estate.png') }}" style="min-width: 8rem;height: 8rem;" class="img-thumbnail rounded-circle hover-up mb-2 boreder-img" alt="User-Profile-Image">
                                            </div>
                                        </div>
                                        
                                    </div>
            
                                </div>
                            </div>
            
                        </div>
                        <div class="col-xl-10 col-lg-9 col-md-12 col-12">
                            <div class="card rounded-0 m-0">
                                <div class="card-body">
            
                                    
                                    <div class="row">
                                        <!-- คอลัมน์ฝั่งซ้าย -->
                                        <div class="col-12 col-lg-12 col-xl-6">

                                            <!-- ข้อมูลทั่วไปที่ดิน -->
                                            <div class="p-0 pt-md-4 py-sm-4 p-xl-4 pt-xl-0 pb-md-4 pb-xl-2">

                                                <div class="row g-2 align-self-center">

                                                    <div class="col-12 my-2">
                                                        <div class="input-bx">
                                                            <select class="form-select" id="Land_Type" name="Land_Type" data-bs-toggle="tooltip" title="ประเภทหลักทรัพย์" required>
                                                                <option value="" selected>-- ประเภทหลักทรัพย์ --</option>
                                                                @if( @$typeRate != null )
                                                                    @foreach( @$typeRate as $key => $value)
                                                                        @if( strtolower(@$value->type_car) == $asset )
                                                                            {{-- ถ้ามีข้อมูล assetItem อยู่จริง ให้เพิ่ม selected --}}
                                                                            @if( @$assetItem != null )
                                                                                @if( @$type == 'view' || @$type == 'edit' )
                                                                                    <option value="{{ $value->code_car }}" {{ ($assetItem->Vehicle_Type == @$value->code_car) || ($assetItem->Land_Type == @$value->code_car) ? "selected" : "" }}>{{ $value->nametype_car }}</option>
                                                                                @else
                                                                                    <option value="{{ $value->code_car }}">{{ $value->nametype_car }}</option>
                                                                                @endif
                                                                            @else
                                                                                <option value="{{ $value->code_car }}">{{ $value->nametype_car }}</option>
                                                                            @endif
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                            <span class="text-danger floating-label">ประเภทหลักทรัพย์</span>
                                                        </div>
                                                    </div>
                                                </div>

                                                {{--
                                                <div class="input-bx">
                                                    <input type="text" class="form-control rounded-0 rounded-start" id="Vehicle_Chassis" name="Vehicle_Chassis" data-bs-toggle="tooltip" title="ระบุเลขถัง 11-17 หลัก" data-fail="{{ empty(@$assetItem->Vehicle_Chassis) ? 'true' : 'false' }}" placeholder=" " value="{{@$assetItem->Vehicle_Chassis}}" autocomplete="off" required/>
                                                    <span class="text-danger">เลขถัง</span>
                                                    <button id="Progress_Chassis" class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled d-flex align-items-center bg-info text-white rounded-0 rounded-end" style="opacity: 1;">
                                                        <div class="spinner-border spinner-border-sm" role="status">
                                                            <span class="visually-hidden">Loading...</span>
                                                        </div>
                                                    </button>
                                                    <button id="Pass_Chassis" class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled d-flex align-items-center bg-success text-white rounded-0 rounded-end" style="opacity: 1;">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                    <button id="Fail_Chassis" class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled d-flex align-items-center bg-danger text-white rounded-0 rounded-end" style="opacity: 1;">
                                                        <i class="fa fa-times"></i>
                                                    </button>
                                                </div>
                                                --}}
                                                <div class="row g-2 align-self-center">
                                                    <div class="col-sm-6 my-2">
                                                        <div class="input-bx">
                                                            <input type="text" class="form-control" id="Land_Id" name="Land_Id" placeholder=" " value="{{@$assetItem->Land_Id}}" required autocomplete="off" data-fail="{{ empty(@$assetItem->Land_Id) ? 'true' : 'false' }}" data-namealert="เลขที่โฉนด"/>
                                                            <span class="text-danger">เลขที่โฉนด</span>

                                                            <button id="Progress_LandId" class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled d-flex align-items-center bg-info text-white rounded-0 rounded-end" style="opacity: 1;">
                                                                <div class="spinner-border spinner-border-sm" role="status">
                                                                    <span class="visually-hidden">Loading...</span>
                                                                </div>
                                                            </button>
                                                            <button id="Pass_LandId" class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled d-flex align-items-center bg-success text-white rounded-0 rounded-end" style="opacity: 1;">
                                                                <i class="fa fa-check"></i>
                                                            </button>
                                                            <button id="Fail_LandId" class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled d-flex align-items-center bg-danger text-white rounded-0 rounded-end" style="opacity: 1;">
                                                                <i class="fa fa-times"></i>
                                                            </button>

                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 my-2">
                                                        <div class="input-bx">
                                                            <input type="text" class="form-control" id="Land_ParcelNumber" name="Land_ParcelNumber" placeholder=" " value="{{@$assetItem->Land_ParcelNumber}}" required autocomplete="off"/>
                                                            <span class="text-danger">เลขที่ดิน</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-2 align-self-center">
                                                    <div class="col-sm-6 my-2">
                                                        <div class="input-bx">
                                                            <input type="text" class="form-control" id="Land_SheetNumber" name="Land_SheetNumber" placeholder=" " value="{{@$assetItem->Land_SheetNumber}}" required autocomplete="off"/>
                                                            <span class="text-danger">ระวาง</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 my-2">
                                                        <div class="input-bx">
                                                            <input type="text" class="form-control" id="Land_TambonNumber" name="Land_TambonNumber" placeholder=" " value="{{@$assetItem->Land_TambonNumber}}" required autocomplete="off"/>
                                                            <span class="text-danger">หน้าสำรวจ</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row g-2 align-self-center">
                                                    <div class="col-sm-6 my-2">
                                                        <div class="input-bx">
                                                            <input type="text" class="form-control" id="Land_Book" name="Land_Book" placeholder=" " value="{{@$assetItem->Land_Book}}" required autocomplete="off"/>
                                                            <span class="text-danger">เล่ม</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6 my-2">
                                                        <div class="input-bx">
                                                            <input type="text" class="form-control" id="Land_BookPage" name="Land_BookPage" placeholder=" " value="{{@$assetItem->Land_BookPage}}" required autocomplete="off"/>
                                                            <span class="text-danger">หน้า</span>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            <!-- ข้อมูล เนื้อที่ ราคา -->
                                            <fieldset class="reset rounded-3 border-primary border-opacity-10">
                                                <legend class="reset text-primary fw-bold px-2" style="letter-spacing: 0.1rem">ข้อมูลที่ดิน</legend>
                                                <div class="p-2">
                                                    <div class="mb-2">
                                                        <label class="fw-bold text-danger col-12 m-0 d-none">เนื้อที่ :</label>
                                                        <div class="row g-0 m-0">
                                                            <div class="col-4 pe-1">
                                                                <div class="input-bx">
                                                                    <input type="text" name="Land_SizeRai" id="Land_SizeRai" class="form-control rounded-0 rounded-start" placeholder=" " value="{{ empty(@$assetItem->Land_SizeRai) ? 0 : @$assetItem->Land_SizeRai}}" required="" autocomplete="off" data-namealert="เนื้อที่ (ไร่)">
                                                                    <button class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled d-flex align-items-center border-start-0 rounded-0 rounded-end">
                                                                        ไร่
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 px-1">
                                                                <div class="input-bx">
                                                                    <input type="text" name="Land_SizeNgan" id="Land_SizeNgan" class="form-control rounded-0 rounded-start" placeholder=" " value="{{ empty(@$assetItem->Land_SizeNgan) ? 0 : @$assetItem->Land_SizeNgan}}" required="" autocomplete="off" data-namealert="เนื้อที่ (งาน)">
                                                                    <button class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled d-flex align-items-center border-start-0 rounded-0 rounded-end">
                                                                        งาน
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="col-4 ps-1">
                                                                <div class="input-bx">
                                                                    <input type="text" name="Land_SizeSquareWa" id="Land_SizeSquareWa" class="form-control rounded-0 rounded-start" placeholder=" " value="{{ empty(@$assetItem->Land_SizeSquareWa) ? 0 : @$assetItem->Land_SizeSquareWa}}" required="" autocomplete="off" data-namealert="เนื้อที่ (ตร.ว.)">
                                                                    <button class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled d-flex align-items-center border-start-0 rounded-0 rounded-end">
                                                                        ตร.ว.
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row g-2 align-self-center">
                                                        <div class="col-12 my-2">
                                                            <div class="input-bx">
                                                                <input type="text" name="Appraisal_Price" id="Appraisal_Price" class="form-control text-end rounded-0 rounded-start" placeholder=" " value="{{@$assetItem->Price_Asset}}" autocomplete="off" required/>
                                                                <span class="text-danger">ราคาประเมินที่ดิน</span>
                                                                <button class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled d-flex align-items-center border-start-0 rounded-0 rounded-end">
                                                                    บาท
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </fieldset>

                                            <!-- ข้อมูล สิ่งปลูกสร้าง -->
                                            <fieldset class="reset rounded-3 border-primary border-opacity-10 mt-3">
                                                <legend class="reset text-primary fw-bold px-2" style="letter-spacing: 0.1rem">ข้อมูลสิ่งปลูกสร้าง</legend>
                                                <div class="p-2">
                                                    <div class="row g-2 align-self-center">

                                                        <div class="col-6 col-md-6 mb-0">
                                                            <div class="input-bx">
                                                                <select class="form-select" id="Land_BuildingType" name="Land_BuildingType" data-bs-toggle="tooltip" title="ประเภท" data-namealert="ประเภทสิ่งปลูกสร้าง" required>
                                                                    <option value="" selected>--- ประเภท ---</option>
                                                                    @if( @$assetItem != null )
                                                                        @foreach(@$typeBldg as $key => $value)
                                                                            <option value="{{ $value->Code_TypeBldg }}" {{ $value->No_Building != null ? "data-nobuilding=Y" : ''}} {{ @$assetItem->Land_BuildingType == $value->Code_TypeBldg ? 'selected' : '' }}>{{ $value->Name_TypeBldg}}</option>
                                                                        @endforeach
                                                                    @else
                                                                        @foreach(@$typeBldg as $key => $value)
                                                                            <option value="{{ $value->Code_TypeBldg }}" {{ $value->No_Building != null ? "data-nobuilding=Y" : ''}}>{{ $value->Name_TypeBldg}}</option>
                                                                        @endforeach
                                                                    @endif
                                                                </select>
                                                                <span class="text-danger floating-label" data-inputid="Land_BuildingType">ประเภท</span>
                                                            </div>
                                                        </div>
    
                                                        <div class="col-6 col-md-6 col-lg-5 col-xl-6 mb-0">
                                                            <div class="input-bx">
                                                                <select class="form-select Land_BuildingKind" id="Land_BuildingKind" name="Land_BuildingKind" data-bs-toggle="tooltip" title="ลักษณะบ้าน" required>
                                                                    <option value="" selected>--- ชนิดบ้าน ---</option>
                                                                </select>
                                                                <span class="text-danger floating-label" data-inputid="Land_BuildingKind">ชนิดบ้าน</span>
                                                            </div>
                                                        </div>
    
                                                        <div class="col-6 col-md-6 col-lg-4 col-xl-6 mb-0">
                                                            <div class="input-bx">
                                                                <select class="form-select Land_BuildingStorey" id="Land_BuildingStorey" name="Land_BuildingStorey" data-bs-toggle="tooltip" title="จำนวนชั้น" required>
                                                                    <option value="" selected>--- จำนวนชั้น ---</option>
                                                                </select>
                                                                <span class="text-danger floating-label" data-inputid="Land_BuildingStorey">จำนวนชั้น</span>
                                                            </div>
                                                        </div>
    
                                                        <div class="col-6 col-md-6 col-lg-3 col-xl-6 mb-0">
                                                            <div class="input-bx">
                                                                <input type="text" name="Land_BuildingSize" id="Land_BuildingSize" class="form-control text-end rounded-0 rounded-start" placeholder=" " value="{{@$assetItem->Land_BuildingSize}}" required autocomplete="off"/>
                                                                <span class="text-danger" data-inputid="Land_BuildingSize">พื้นที่สิ่งปลูกสร้าง</span>
                                                                <button class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled d-flex align-items-center border-start-0 rounded-0 rounded-end">
                                                                    ตร.ม.
                                                                </button>
                                                            </div>
                                                        </div>
    
                                                    </div>
                                                </div>
                                            </fieldset>

                                        </div>
                                        <!-- คอลัมน์ฝั่งขวา -->
                                        <div class="col-12 col-lg-12 col-xl-6">
                                            
                                            <!-- ข้อมูลการครอบครอง -->
                                            <div class="p-0 pt-md-4 py-sm-4 p-xl-4 pt-xl-0 pb-md-4 ">
                                                <div class="row g-2 align-self-center">
                                                    <div class="col-sm-6 mt-2" id="OccupiedDT_Land_datepicker">
                                                        <div class="input-bx">
                                                            <input type="text" name="OccupiedDT_Land" id="OccupiedDT_Land" class="form-control rounded-0 rounded-start OccupiedDT" placeholder=" " data-date-format="dd/mm/yyyy" data-date-container="#OccupiedDT_Land_datepicker" data-provide="datepicker"  data-date-disable-touch-keyboard="true" data-date-language="th" data-date-today-highlight="true" data-date-autoclose="true" value="{{ !empty(@$assetItem->OccupiedDT) ? convertDatePHPToHuman($assetItem->OccupiedDT) : '' }}" autocomplete="off" required>
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

                                            <!-- ข้อมูลภูมิภาค จังหวัด -->
                                            <div class="p-0 p-xl-4 py-sm-4 border-top">

                                                <div class="row g-2 align-self-center">

                                                    <div class="col-6 col-md-6 mb-0">
                                                        <div class="input-bx">
                                                            @php
                                                                $dataZone = \App\Models\TB_Constants\TB_Frontend\TB_Provinces::selectRaw('Zone_pro, count(*) as total')
                                                                    ->groupBy('Zone_pro')
                                                                    ->orderBY('Zone_pro', 'ASC')
                                                                    ->get();
                                                            @endphp
                                                            <select @class([
                                                                'form-select houseZone',
                                                                'has-value' => !empty(@$assetItem->Land_Zone),
                                                            ]) id="Land_Zone" name="Land_Zone" data-bs-toggle="tooltip" title="ภูมิภาค" required>
                                                                <option value="" selected>--- ภูมิภาค ---</option>
                                                                @if( @$assetItem != null )
                                                                    @foreach($dataZone as $key => $Zone)
                                                                        <option value="{{$Zone->Zone_pro}}" {{ @$assetItem->Land_Zone == $Zone->Zone_pro ? 'selected' : '' }}>{{$Zone->Zone_pro}}</option>
                                                                    @endforeach
                                                                @else
                                                                    @foreach($dataZone as $key => $Zone)
                                                                        <option value="{{$Zone->Zone_pro}}">{{$Zone->Zone_pro}}</option>
                                                                    @endforeach
                                                                @endif
                                                                
                                                            </select>
                                                            <span class="text-danger floating-label">ภูมิภาค</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-6 col-md-6 col-lg-5 col-xl-6 mb-0">
                                                        <div class="input-bx">
                                                            <select @class([
                                                                'form-select houseProvince',
                                                                'has-value' => !empty(@$assetItem->Land_Province),
                                                            ]) id="Land_Province" name="Land_Province" data-bs-toggle="tooltip" title="จังหวัด" required>
                                                                <option value="" selected>--- จังหวัด ---</option>
                                                                @if( !empty(@$assetItem->Land_Province) )
                                                                    <option value="{{ $assetItem->Land_Province }}" selected>{{ $assetItem->Land_Province}}</option>
                                                                @endif
                                                            </select>
                                                            <span class="text-danger floating-label">จังหวัด</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-6 col-md-6 col-lg-4 col-xl-6 mb-0">
                                                        <div class="input-bx">
                                                            <select @class([
                                                                'form-select houseDistrict',
                                                                'has-value' => !empty(@$assetItem->Land_District),
                                                            ]) id="Land_District" name="Land_District" data-bs-toggle="tooltip" title="อำเภอ" required>
                                                                <option value="" selected>--- อำเภอ ---</option>
                                                                @if( !empty(@$assetItem->Land_District) )
                                                                    <option value="{{ $assetItem->Land_District }}" selected>{{ $assetItem->Land_District}}</option>
                                                                @endif
                                                            </select>
                                                            <span class="text-danger floating-label">อำเภอ</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-6 col-md-6 col-lg-3 col-xl-6 mb-0">
                                                        <div class="input-bx">
                                                            <select @class([
                                                                'form-select houseTambon',
                                                                'has-value' => !empty(@$assetItem->Land_Tambon),
                                                            ]) id="Land_Tambon" name="Land_Tambon" data-bs-toggle="tooltip" title="ตำบล" required>
                                                                <option value="" selected>--- ตำบล ---</option>
                                                                @if( !empty(@$assetItem->Land_Tambon) )
                                                                    <option value="{{ $assetItem->Land_Tambon }}" selected>{{ $assetItem->Land_Tambon}}</option>
                                                                @endif
                                                            </select>
                                                            <span class="text-danger floating-label">ตำบล</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-6 col-md-6 col-lg col-xl-6 mb-0">
                                                        <div class="input-bx">
                                                            <input type="text" class="form-control Postal" id="Land_PostalCode" name="Land_PostalCode" placeholder=" " value="{{@$assetItem->Land_PostalCode}}" required/>
                                                            <span class="text-danger">เลขไปรษณีย์</span>
                                                        </div>
                                                    </div>

                                                    <div class="col-6 col-md-6 col-lg-auto col-xl-6 mb-0">
                                                        <div class="input-bx">
                                                            <input type="text" class="form-control rounded-0 rounded-start" id="Land_Coordinates" name="Land_Coordinates" placeholder=" " value="{{@$assetItem->Land_Coordinates}}"/>
                                                            <span class="">พิกัด</span>
                                                            <button class="mx-0 btn btn-light border border-secondary border-opacity-50 disabled d-flex align-items-center border-start-0 rounded-0 rounded-end">
                                                                <i class="fas fa-map-marker-alt"></i>
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <!-- ข้อมูลอื่น ๆ -->
                                            <div class="p-0 pt-md-4 py-sm-4 p-xl-4 pb-md-4 border-top">

                                                <div class="row g-2 align-self-center">
                                                    <div class="col-md-12">
                                                        <div class="form-floating">
                                                            <textarea class="form-control" placeholder="Leave a comment here" id="Land_Detail" name="Land_Detail" maxlength="65535" style="height: 200px">{{ @$assetItem->Land_Detail }}</textarea>
                                                            <label for="Land_Detail" class="fw-bold">รายละเอียดที่ดิน</label>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    
            
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
            @endif
                
        </div>

        <div class="modal-footer">

            @if( @$type == 'new')
                <button type="button" class="btn btn-primary btn-sm waves-effect waves-light hover-up btn_createAsset">
                    <i class="fas fa-download"></i> สร้างทรัพย์ใหม่ <span class="addSpin">
                </button>
            @elseif( @$type == 'edit' )
                <button type="button" class="btn btn-primary btn-sm waves-effect waves-light hover-up btn_editAsset">
                    <i class="fas fa-download"></i> บันทึก <span class="addSpin">
                </button>
            @endif
            <button type="button" class="btn btn-secondary btn-sm waves-effect hover-up btn_closeAsset" data-bs-dismiss="modal">
                <i class="mdi mdi-close-circle-outline"></i> ปิด
            </button>
            
        </div>
        
    </div>
</div>

@include('frontend.content-asset.script')