@include('backend.content-track.session-call.script')
@include('components.content-toast.view-toast')
<link rel="stylesheet" href="{{ URL::asset('assets/css/datepicker-custom.css') }}">
<script src="https://cdn.lordicon.com/lordicon.js"></script>


    <div class="modal-content">
        <div class="modal-header" id="Modal-drag" style="cursor:move;">
            <div class="flex-shrink-0 me-2">
                <img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
            </div>
            <div class="flex-grow-1 overflow-hidden">
                <h4 class="text-primary fw-semibold placeholder-glow d-block d-sm-none">บันทึกติดตาม</h4>
                <h4 class="text-primary fw-semibold placeholder-glow d-none d-sm-block">บันทึกติดตามลูกหนี้</h4>
                <p class="text-muted mt-n1 placeholder-glow">{{@$data->CONTNO}}</p>
            </div>
            <button type="button" class="btn btn-success mr-5 pr-5 ml-5 SaveDT d-none" title="บันทึก" aria-label="Close">
                <span class="addSpin"><i class="fas fa-download"></i></span> บันทึก
            </button>
            &nbsp;
            <button type="button" class="btn btn-danger " title="ปิด POP-UP" data-bs-dismiss="modal" aria-label="Close">
                ปิด
            </button>
        </div>
        <div class="modal-body mt-n3">
            <div class="row">
                <div class="col-xl-2 d-none d-xl-block">
                    <div class="card-body">
                        <div id="carouselExampleIndicators" class="carousel carousel-dark slide" data-bs-ride="carousel" data-bs-interval="10000" style="min-height: 28rem; max-height: 28rem;">
                            <div class="carousel-indicators ms-2" style="position:relative;top:0px;">
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                            </div>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <h4 class="card-title text-muted mb-3"><u>ข้อมูลแบ่งงาน</u></h4>
                                    <div data-simplebar style="max-height: 500px;cursor: pointer;">
                                        <ul class="list-unstyled">

                                            <li>
                                                <div class="d-flex">
                                                    <i class="bx bx-calendar text-primary ms-3"></i>
                                                    <div class="ms-3">
                                                        <h6 class="fs-14 mb-2 fw-semibold">วันที่ชำระล่าสุด</h6>
                                                        <span class="me-1">
                                                            {{(@$data->LPAYD != NULL)?date('d-m-Y',strtotime(@$data->LPAYD)):'-'}}
                                                        </span>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="mt-3">
                                                <div class="d-flex">
                                                    <i class="bx bx-money text-primary ms-3"></i>
                                                    <div class="ms-3">
                                                        <h6 class="fs-14 mb-2 fw-semibold">ยอดชำระล่าสุด</h6>
                                                        {{(@$data->LPAYA != NULL)?number_format(@$data->LPAYA):'-'}}
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="mt-3">
                                                <div class="d-flex">
                                                    <i class="bx bx-purchase-tag-alt text-danger ms-3"></i>
                                                    <div class="ms-3">
                                                        <h6 class="fs-14 mb-2 fw-semibold">กลุ่มงวดค้าง</h6>
                                                        <p class="text-muted fs-14 mb-0">
                                                            {{(@$data->SWEXPPRD != NULL)?@$data->SWEXPPRD:'-'}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="mt-3">
                                                <div class="d-flex">
                                                    <i class="bx bx-purchase-tag-alt text-danger ms-3"></i>
                                                    <div class="ms-3">
                                                        <h6 class="fs-14 mb-2 fw-semibold">ยอดค้างชำระ</h6>
                                                        <p class="text-muted fs-14 mb-0">
                                                            {{(@$data->KDAMT != NULL)?number_format(@$data->KDAMT):'-'}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="mt-3">
                                                <div class="d-flex">
                                                    <i class="bx bx-purchase-tag-alt text-danger ms-3"></i>
                                                    <div class="ms-3">
                                                        <h6 class="fs-14 mb-2 fw-semibold">ค้างงวด</h6>
                                                        <p class="text-muted fs-14 mb-0">
                                                            {{@$data->EXP_FRM}} - {{@$data->EXP_TO}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="mt-3">
                                                <div class="d-flex">
                                                    <i class="bx bx-purchase-tag-alt text-danger ms-3"></i>
                                                    <div class="ms-3">
                                                        <h6 class="fs-14 mb-2 fw-semibold">ยอดชำระขั้นต่ำ</h6>
                                                        <p class="text-muted fs-14 mb-0">
                                                            {{(@$data->MinPay != NULL)?number_format(@$data->MinPay):'-'}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>

                                            @if(@$data->PAYAMT > 0)
                                            <li class="mt-3 border-top"></li>
                                            <li class="mt-3">
                                                <div class="d-flex">
                                                    <i class="bx bx-send bx-tada text-warning ms-3"></i>
                                                    <div class="ms-3">
                                                        <h6 class="fs-14 mb-2 fw-semibold">ยอดรับชำระ</h6>
                                                        <p class="text-muted fs-14 mb-0">
                                                            {{(@$data->PAYAMT != NULL)?number_format(@$data->PAYAMT):'-'}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            @endif

                                            @if(@$data->MustPay > 0)
                                            <li class="mt-3">
                                                <div class="d-flex">
                                                    <i class="bx bx-send bx-tada text-warning ms-3"></i>
                                                    <div class="ms-3">
                                                        <h6 class="fs-14 mb-2 fw-semibold">ยอดนัดชำระ</h6>
                                                        <p class="text-muted fs-14 mb-0">
                                                            {{(@$data->MustPay != NULL)?number_format(@$data->MustPay):'-'}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            @endif

                                            @if(@$data->AreaPay > 0)
                                            <li class="mt-3">
                                                <div class="d-flex">
                                                    <i class="bx bx-send bx-tada text-warning ms-3"></i>
                                                    <div class="ms-3">
                                                        <h6 class="fs-14 mb-2 fw-semibold">ค่าลงพื้นที่</h6>
                                                        <p class="text-muted fs-14 mb-0">
                                                            {{(@$data->AreaPay != NULL)?number_format(@$data->AreaPay):'-'}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            @endif

                                        </ul>
                                    </div>
                                </div>
                                <div class="carousel-item ms-3">
                                    <h4 class="card-title text-muted mb-3"><u>ข้อมูลสัญญา</u></h4>
                                    <div>
                                        <ul class="list-unstyled">
                                            <li>
                                                <div class="d-flex">
                                                    <i class="bx bx-layer text-primary fs-4"></i>
                                                    <div class="ms-3">
                                                        <h6 class="fs-14 mb-2 fw-semibold">เลขที่สัญญา</h6>
                                                        <p class="text-primary fs-14 mb-0">
                                                            {{@$contract->CONTNO}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="mt-3">
                                                <div class="d-flex">
                                                    <i class="bx bx-layer text-primary fs-4"></i>
                                                    <div class="ms-3">
                                                        <h6 class="fs-14 mb-2 fw-semibold">ประเภทสัญญา</h6>
                                                        {{@$contract->PatchToPact->ContractToTypeLoan->Loan_Name}} ( {{@$contract->PatchToPact->ContractToTypeLoan->Loan_Code}} )
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                    <h4 class="card-title text-muted mb-3 mt-2">ข้อมูลลูกค้า</h4>
                                    <div data-simplebar style="max-height: 300px;cursor: pointer;">
                                        <ul class="list-unstyled">
                                            <li>
                                                <div class="d-flex">
                                                    <i class="bx bx-user-circle text-primary fs-4"></i>
                                                    <div class="ms-3">
                                                        <h6 class="fs-14 mb-2 fw-semibold">ชื่อ-นามสกุล</h6>
                                                        <p class="text-muted fs-14 mb-0">
                                                            {{@$contract->PatchToPact->ContractToCus->Name_Cus}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="mt-3">
                                                <div class="d-flex">
                                                    <i class="bx bx-id-card text-primary fs-4"></i>
                                                    <div class="ms-3">
                                                        <h6 class="fs-14 mb-2 fw-semibold">บัตรประชาชน</h6>
                                                        <p class="text-muted fs-14 mb-0 input-mask" data-inputmask="'mask': '999-9999999,999-9999999'">
                                                            {{@$contract->PatchToPact->ContractToCus->IDCard_cus}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="mt-3">
                                                <div class="d-flex">
                                                    <i class="bx bx-id-card text-primary fs-4"></i>
                                                    <div class="ms-3">
                                                        <h6 class="fs-14 mb-2 fw-semibold">เบอร์ติดต่อ </h6>
                                                        <p class="text-muted fs-14 mb-0 input-mask" data-inputmask="'mask': '999-9999999,999-9999999'">
                                                            {{@$contract->PatchToPact->ContractToCus->Phone_cus}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="mt-3">
                                                <div class="d-flex">
                                                    <i class="bx bx-link text-primary fs-4"></i>
                                                    <div class="ms-3">
                                                        <h6 class="fs-14 mb-2 fw-semibold">ลิงค์เอกสาร</h6>
                                                        <p class="text-muted fs-14 mb-0 input-mask">
                                                            @if(@$contract->PatchToPact->LinkUpload_Con != NULL)
                                                            <a href="{{@$contract->PatchToPact->LinkUpload_Con}}" class="btn btn-soft-primary btn-sm rounded-pill" target="_blank">ดูอัลบั้ม <i class="fas fa-link ms-1"></i> </a>
                                                            @else 
                                                                -
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                @php 
                                    @$Address = @$contract->PactToCus->DataCusToDataCusAdds;
                                    @$Asset = @$contract->PactToCus->DataCusToDataAssetOne;
                                @endphp
                                <div class="carousel-item ms-3">
                                    <h4 class="card-title text-muted mb-3"><u>ข้อมูลทรัพย์</u></h4>
                                    <div>
                                        <ul class="list-unstyled">
                                            <li>
                                                <div class="d-flex">
                                                    <i class="bx bx-car text-primary fs-4"></i>
                                                    <div class="ms-3">
                                                        <h6 class="fs-14 mb-2 fw-semibold">ยี่ห้อรถ</h6>
                                                        <p class="text-primary fs-14 mb-0">
                                                            {{@$Asset->AssetToCarBrand->Brand_car}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="mt-3">
                                                <div class="d-flex">
                                                    <i class="bx bx-car text-primary fs-4"></i>
                                                    <div class="ms-3">
                                                        <h6 class="fs-14 mb-2 fw-semibold">สี</h6>
                                                        <p class="text-muted fs-14 mb-0">
                                                            {{@$Asset->Vehicle_Color}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="mt-3">
                                                <div class="d-flex">
                                                    <i class="bx bx-car text-primary fs-4"></i>
                                                    <div class="ms-3">
                                                        <h6 class="fs-14 mb-2 fw-semibold">ทะเบียนเก่า</h6>
                                                        <p class="text-muted fs-14 mb-0">
                                                            {{@$Asset->Vehicle_OldLicense}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="mt-3">
                                                <div class="d-flex">
                                                    <i class="bx bx-car text-primary fs-4"></i>
                                                    <div class="ms-3">
                                                        <h6 class="fs-14 mb-2 fw-semibold">ทะเบียนใหม่</h6>
                                                        <p class="text-muted fs-14 mb-0">
                                                            {{(@$Asset->Vehicle_NewLicense != NULL)?@$Asset->Vehicle_NewLicense:'-'}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="mt-3">
                                                <div class="d-flex">
                                                    <i class="bx bx-purchase-tag-alt text-primary fs-4"></i>
                                                    <div class="ms-3">
                                                        <h6 class="fs-14 mb-2 fw-semibold">เลขถัง</h6>
                                                        <p class="text-muted fs-14 mb-0">
                                                            {{(@$Asset->Vehicle_NewChassis != NULL)?@$Asset->Vehicle_NewChassis:@$Asset->Vehicle_Chassis}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="mt-3">
                                                <div class="d-flex">
                                                    <i class="bx bx-purchase-tag-alt text-primary fs-4"></i>
                                                    <div class="ms-3">
                                                        <h6 class="fs-14 mb-2 fw-semibold">เลขเครื่อง</h6>
                                                        <p class="text-muted fs-14 mb-0">
                                                            {{@$Asset->Vehicle_Engine}}
                                                        </p>
                                                    </div>
                                                </div>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <button class="carousel-control-prev d-none" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev" style="left: -1.5rem;">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next d-none" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next" style="right: -1.5rem;">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-xl-10">
                    <div class="card-body">
                        <div id="basic-example" role="application" class="wizard clearfix">
                                <ul class="nav nav-pills nav-justified border-bottom" role="tablist">
                                    <li class="nav-item waves-effect waves-light tabSelected border-start" id="tracklist" role="presentation">
                                        <a class="nav-link active history" data-bs-toggle="tab" href="#profile-1" role="tab" aria-selected="false" tabindex="-1">
                                            <span class="d-block d-sm-none"><i class="bx bx-chat"></i></span>
                                            <span class="d-none d-sm-block"><span class="number"><i id="icon2" class="bx bx-book-content"></i></span> รายการติดตาม</span> 
                                        </a>
                                    </li>
                                    <li class="nav-item waves-effect waves-light tabSelected border-end" id="tracktab" role="presentation">
                                        <a class="nav-link savetrack" data-bs-toggle="tab" href="#home-1" role="tab" aria-selected="true">
                                            <span class="d-block d-sm-none"><i class="bx bx-notepad"></i></span>
                                            <span class="d-none d-sm-block"><span class="number"><i id="icon1" class="bx bx-edit-alt bx-tada"></i></span> บันทึกติดตาม</span> 
                                        </a>
                                    </li>
                                </ul>

                                <div class="tab-content p-2 text-muted mt-3">
                                    <div class="tab-pane savetrack" id="home-1" role="tabpanel">
                                        <form name="formDA" id="formDA" action="#" method="post" enctype="multipart/form-data" novalidate style="font-family: 'Prompt', sans-serif;">
                                            @csrf
                                            <input type="hidden" id="id" name="ID" value="{{@$data->spast_id}}">
                                            <input type="hidden" id="loanType" name="loanType" value="{{@$loanType}}">
                                            <input type="hidden" id="ContractID" name="ContractID" value="{{@$ContractID}}">
                                            <input type="hidden" id="PAGE" name="page" value="store-track">
                                            <input type="hidden" id="INPUTDT" name="INPUTDT" value="{{date('Y-m-d')}}"/>
                                            <input type="hidden" id="CONTNO" name="Contract" value="{{@$contract->CONTNO}}">
                                            <input type="hidden" id="locat" name="locat" value="{{@$contract->LOCAT}}">
                                            <input type="hidden" id="DataCus_id" name="DataCus_id" value="{{@$contract->DataCus_id}}">
                                            <div class="row g-2 mb-2">
                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                                    <div class="row g-2">
                                                        <div class="col-12">
                                                            <div class="">
                                                                <label for="formrow-firstname-input" class="form-label">* ประเภทบันทึก</label>
                                                                <select class="form-select text-dark" id="STATUS_TRACK" name="STATUS_TRACK" placeholder=" ">
                                                                    <option value="" selected>--- เลือกประเภท ---</option>
                                                                    @if(@$count_not < 3)
                                                                        @foreach(@$TrackStatus as $key => $value)
                                                                            <option value="{{@$value->NAME}}">{{@$value->NAME}}</option>
                                                                        @endforeach
                                                                    @else 
                                                                        <option value="งานลงพื้นที่">งานลงพื้นที่</option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="mb-2">
                                                                <label for="formrow-firstname-input" class="form-label">* สถานะติดตาม</label>
                                                                <select class="form-select text-dark" id="RESULT" name="RESULT" placeholder=" ">
                                                                    <option value="" selected>--- เลือกสถานะ ---</option>
                                                                    @if(@$count_not < 3)
                                                                        @foreach(@$Tracklist as $key => $value)
                                                                            <option value="{{@$value->NAME}}">{{@$value->NAME}}</option>
                                                                        @endforeach
                                                                    @else 
                                                                        <option value="ลงพื้นที่">ลงพื้นที่</option>
                                                                        <option value="ลูกค้าคืนรถ">ลูกค้าคืนรถ</option>
                                                                    @endif
                                                                </select>
                                                                <input type="hidden" id="RESULT_SCORE" name="RESULT_SCORE" class="form-control form-control-lg" placeholder=" ">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row g-2">
                                                        <div class="col-6">
                                                            <div class="" id="datepicker1">
                                                                <label for="formrow-firstname-input" class="form-label">วันที่นัด/ติดตามต่อ</label>
                                                                <input type="text" name="DDATE" id="DDATE" value=""
                                                                    class="form-control text-start" placeholder="ป้อนวันที่" min="{{date('Y-m-d',strtotime('+1days'))}}"
                                                                    data-date-format="dd/mm/yyyy" data-date-container="#datepicker1"
                                                                    data-provide="datepicker" data-date-disable-touch-keyboard="true"
                                                                    data-date-language="th" data-date-today-highlight="true"
                                                                    data-date-enable-on-readonly="false" data-date-clear-btn="true"
                                                                    autocomplete="off" data-date-autoclose="true">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mb-2">
                                                                <label for="formrow-firstname-input" class="form-label">ยอดนัดชำระ</label>
                                                                <input type="number" id="PAYDUE" name="PAYDUE" value="" class="form-control" placeholder="ป้อนยอด"/>
                                                                <input type="hidden" id="MinPay" name="MinPay" value="{{@$data->MinPay}}"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                                    <div class="" id="comment-track">
                                                        <div class="row g-2">
                                                            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                                <div class="mb-2">
                                                                    <label for="formrow-firstname-input" class="form-label">* รายละเอียดติดตาม</label>
                                                                    <textarea class="form-control" placeholder="ลงบันทึก" name="NOTE" id="NOTE" maxlength="10000" style="height: 180px" title="รายละเอียดติดตาม" required></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-2 d-none" id="areaLocation">
                                                        <div class="row g-2 content-hide">
                                                            @if(@$loanType == 2)
                                                                <div class="col-9">
                                                                    <div class="mb-2 content-hide" id="location">
                                                                        <label for="formrow-firstname-input" class="form-label text-danger">* พิกัด</label>
                                                                        <div class="input-group">
                                                                            <button id="ShowMaps" class="input-group-text bg-warning" type="button" data-bs-toggle="tooltip" title="แสดงแผนที่">
                                                                                <i class="mdi mdi-map-legend"></i>
                                                                            </button>
                                                                            <input type="text" id="LATLONG" name="LATLONG" value="" class="form-control" placeholder="ป้อน ละติจูด,ลองจิจูด"/>
                                                                            <button id="BtnLocation2" class="input-group-text text-danger" type="button" data-bs-toggle="tooltip" title="ปักหมุดตำแหน่งปัจจุบัน">
                                                                                <i class="mdi mdi-google-maps"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-2 content-hide" id="image_area">
                                                                        <label for="formrow-firstname-input" class="form-label">ลิงค์รูปลงพื้นที่</label>
                                                                        <div class="input-group">
                                                                            <input type="text" id="LINK_IMAGE" name="LINK_IMAGE" value="" class="form-control" placeholder="ป้อน ลิงค์รูปลงพื้นที่"/>
                                                                            <button class="input-group-text" type="button" data-bs-toggle="tooltip">
                                                                                <i class="mdi mdi-link-variant"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-1 content-hide" id="image_area">
                                                                        <label for="formrow-firstname-input" class="form-label" id="text-val-area">ค่าลงพื้นที่</label>
                                                                        <input type="number" id="PAY_AREA" name="PAY_AREA" value="" class="form-control bg-gradient" readonly/>
                                                                    </div>

                                                                </div>
                                                                <div class="col-3">
                                                                    <div class="text-center" id="check_area">
                                                                        <div class="mb-2 mt-4">
                                                                            <img id="ImageBrok" src="{{ URL::asset('assets/images/CK-location.png') }}" class="avatar-sm">
                                                                        </div>
                                                                        <div class="d-flex justify-content-center">
                                                                            <input type="checkbox" id="switch1" switch="success" value="Y" name="FLAG" {{(@$data->AreaPay > 0)?'checked':''}}>
                                                                            <label for="switch1" data-on-label="เปิด" data-off-label="ปิด"></label>
                                                                        </div>
                                                                        <p>ค่าลงพื้นที่</p>
                                                                    </div>
                                                                </div>
                                                            @else 
                                                                <div class="col-12">
                                                                    <div class="mb-2 content-hide" id="location">
                                                                        <label for="formrow-firstname-input" class="form-label">พิกัด</label>
                                                                        <div class="input-group">
                                                                            <button id="ShowMaps" class="input-group-text bg-warning" type="button" data-bs-toggle="tooltip" title="แสดงแผนที่">
                                                                                <i class="mdi mdi-map-legend"></i>
                                                                            </button>
                                                                            <input type="text" id="LATLONG" name="LATLONG" value="" class="form-control" placeholder="ป้อน ละติจูด,ลองจิจูด"/>
                                                                            <button id="BtnLocation2" class="input-group-text text-danger" type="button" data-bs-toggle="tooltip" title="ปักหมุดตำแหน่งปัจจุบัน">
                                                                                <i class="mdi mdi-google-maps"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="mb-2 content-hide">
                                                                        <label for="formrow-firstname-input" class="form-label">ลิงค์รูปลงพื้นที่</label>
                                                                        <div class="input-group">
                                                                            <input type="text" id="LINK_IMAGE" name="LINK_IMAGE" value="" class="form-control" placeholder="ป้อน ลิงค์รูปลงพื้นที่"/>
                                                                            <button class="input-group-text" type="button" data-bs-toggle="tooltip">
                                                                                <i class="mdi mdi-link-variant"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr class="border-bottom">
                                            <img src="{{ URL::asset('assets/images/city1.jpg') }}" alt="" class="img-temp img-fluid mx-auto d-block" style="max-height: 25vh;opacity: 0.1;background-repeat: no-repeat;background-position:50%0;background-size: cover;width:100%;">
                                            <div id="area-part" class="d-none">
                                                <div class="mb-2 content-hide" id="datepicker2">
                                                    <div class="row g-2">
                                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                                            <div class="row g-2 mb-2">
                                                                <div class="col-6">
                                                                    <label for="formrow-firstname-input" class="form-label text-danger">* วันที่ลงพื้นที่</label>
                                                                    <input type="text" name="DDATE2" id="DDATE2" value=""
                                                                        class="form-control text-start" placeholder="ป้อนวันที่ลงพื้นที่" min="{{date('Y-m-d',strtotime('+1days'))}}"
                                                                        data-date-format="dd/mm/yyyy" data-date-container="#datepicker2"
                                                                        data-provide="datepicker" data-date-disable-touch-keyboard="true"
                                                                        data-date-language="th" data-date-today-highlight="true"
                                                                        data-date-enable-on-readonly="true" data-date-clear-btn="true"
                                                                        autocomplete="off" data-date-autoclose="true">
                                                                </div>
                                                                <div class="col-6">
                                                                    <label for="formrow-firstname-input" class="form-label">สถานที่ลงพื้นที่</label>
                                                                    <select class="form-select text-dark" id="PLACE_AREA" name="PLACE_AREA" placeholder=" ">
                                                                        <option value="" selected>--- เลือกสถานที่ ---</option>
                                                                        <option value="บ้านตามที่อยู่">บ้านตามที่อยู่</option>
                                                                        <option value="บ้านเช่า">บ้านเช่า</option>
                                                                        <option value="สถานที่ทำงาน">สถานที่ทำงาน</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            
                                                            <div class="row g-2">
                                                                <div class="col-6">
                                                                    <div class="content-hide">
                                                                        <label for="formrow-firstname-input" class="form-label">สถานะทรัพย์</label>
                                                                        <select class="form-select text-dark" id="STATUS_ASSET" name="STATUS_ASSET" placeholder=" ">
                                                                            <option value="" selected>--- เลือกประเภท ---</option>
                                                                            <option value="เจอ">เจอ</option>
                                                                            <option value="ไม่เจอ">ไม่เจอ</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="content-hide mb-2">
                                                                        <label for="formrow-firstname-input" class="form-label">สถานะใช้งาน</label>
                                                                        <select class="form-select text-dark" id="FLAG_ASSET" name="FLAG_ASSET" placeholder=" ">
                                                                            <option value="" selected>--- เลือกสถานะ ---</option>
                                                                            <option value="ใช้งาน">ใช้งาน</option>
                                                                            <option value="ไม่ใช้งาน">ไม่ใช้งาน</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row g-2">
                                                                <div class="col-12">
                                                                    <div class="mb-2 content-hide" id="note_area1">
                                                                        <label for="formrow-firstname-input" class="form-label">รายละเอียดลงพื้นที่</label>
                                                                        <textarea class="form-control" placeholder="ลงบันทึก" name="NoteArea" id="NoteArea" maxlength="10000" style="height: 107px" title="รายละเอียดติดตาม"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                                                    
                                                            <div class="row g-2">
                                                                <div class="col-6">
                                                                    <div class="content-hide">
                                                                        <label for="formrow-firstname-input" class="form-label">บุคคล</label>
                                                                        <select class="form-select text-dark" id="STATUS_DEBT" name="STATUS_DEBT" placeholder=" ">
                                                                            <option value="" selected>--- เลือกบุคคล ---</option>
                                                                            <option value="ผู้กู้">ผู้กู้</option>
                                                                            <option value="ผู้ค้ำ">ผู้ค้ำ</option>
                                                                            <option value="ผู้ค้ำ2">ผู้ค้ำ2</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="content-hide mb-2">
                                                                        <label for="formrow-firstname-input" class="form-label">สถานะบุคคล</label>
                                                                        <select class="form-select text-dark" id="FLAG_DEBT" name="FLAG_DEBT" placeholder=" ">
                                                                            <option value="" selected>--- เลือกสถานะ ---</option>
                                                                            <option value="เจอ">เจอ</option>
                                                                            <option value="ไม่เจอ">ไม่เจอ</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row g-2">
                                                                <div class="col-6">
                                                                    <div class="content-hide">
                                                                        <label for="formrow-firstname-input" class="form-label">สถานะบุคคลรอบตัว</label>
                                                                        <select class="form-select text-dark" id="STATUS_AROUND" name="STATUS_AROUND" placeholder=" ">
                                                                            <option value="" selected>--- เลือกประเภท ---</option>
                                                                            <option value="บิดา">บิดา</option>
                                                                            <option value="มารดา">มารดา</option>
                                                                            <option value="บุตร">บุตร</option>
                                                                            <option value="พี่น้อง">พี่น้อง</option>
                                                                            <option value="บ้านข้างเคียง">บ้านข้างเคียง</option>
                                                                            <option value="สามี">สามี</option>
                                                                            <option value="ภรรยา">ภรรยา</option>
                                                                            <option value="เพื่อน">เพื่อน</option>
                                                                            <option value="ญาติ">ญาติ</option>
                                                                            <option value="ไม่เจอ">ไม่เจอ</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="content-hide mb-2">
                                                                        <label for="formrow-firstname-input" class="form-label">เวลาที่เจอ</label>
                                                                        <input type="time" name="TIME_AREA" id="TIME_AREA" value="" class="form-control text-start" placeholder="วันที่และเวลาเจอ">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row g-2">
                                                                <div class="col-12">
                                                                    <div class="mb-2 content-hide" id="note_deptor1">
                                                                        <label for="formrow-firstname-input" class="form-label">หมายเหตุ</label>
                                                                        <textarea class="form-control" placeholder="ลงบันทึก" name="MEMO" id="MEMO" maxlength="10000" style="height: 107px" title="รายละเอียดติดตาม"></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-2 mb-2">
                                                <div id="map" style="height: 320px;width:100%;display:none;"></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="tab-pane active history" id="profile-1" role="tabpanel">
                                        <div data-simplebar style="max-height: 500px;cursor: pointer;">
                                            <div id="HistoryDetails">
                                                <span class="mb-2 mt-n1 d-flex justify-content-end font-size-5"><small>{{count(@$contract->ContractToSPASTDUE->ToSPASTDETAIL)}} รายการ</small></span>
                                                @if(count(@$contract->ContractToSPASTDUE->ToSPASTDETAIL) > 0)
                                                    @foreach( @$contract->ContractToSPASTDUE->ToSPASTDETAIL as $i => $value)
                                                        <div class="accordion mb-1" id="accordionPanelsStayOpenExample">
                                                            <div class="accordion-item">
                                                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                                                    <button class="accordion-button border {{auth()->user()->id != $value->USERID?'border-warning':''}} border-2 bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#CuasTag-{{$i}}" aria-expanded="false" aria-controls="CuasTag-{{$i}}">
                                                                        <div class="flex-shrink-0 me-3">
                                                                            <!-- <img src="{{ asset('assets/images/gif/avatar.gif') }}" alt="" class="avatar-sm" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-html="true" title="ผู้บันทึก : {{@$value->ToUsername->name}}"> -->
                                                                            @if(@$value->STATUS <> "" or @$value->RESULT <> "")
                                                                            <a href="#" id="{{@$value->id}}" loanType="{{@$loanType}}" class="Modal2" title="แก้ไข">
                                                                                <i class="bx bxs-edit-alt text-warning"></i>
                                                                            </a>
                                                                            @else 
                                                                                <i class="bx bx bx-chat bx-tada text-primary"></i>
                                                                            @endif
                                                                        </div>
                                                                        <div class="flex-grow-1 overflow-hidden">
                                                                            <h5 class="font-size-10 mb-1">
                                                                                <b>ผู้บันทึก :</b> {{@$value->ToUsername->name}} 
                                                                                <span class="float-end border boder-info d-block d-sm-none font-size-10">{{formatDateThai(@$value->INPUTDT)}}</span>
                                                                                <span class="float-end border boder-info d-none d-sm-block font-size-10">{{formatDateThai(@$value->INPUTDT)}} {{substr(@$value->created_at,10,6)}}</span>
                                                                            </h5>
                                                                            @if(@$value->STATUS <> "" or @$value->RESULT <> "")
                                                                                <p class="text-muted mb-1"><b class="pr-3">{{@$value->STATUS}}: &nbsp;</b><span class="badge rounded-pill {{(@$value->RESULT == 'โทรไม่ติด' or @$value->RESULT == 'ไม่รับสาย')?'bg-danger':'bg-warning'}} font-size-8 mr-2">{{@$value->RESULT}}</span></p>
                                                                            @else 
                                                                                <p class="text-muted mb-1"><span class="pr-3">{!! Str::limit( @$value->NOTE, 35, '...') !!}</span></p>
                                                                            @endif
                                                                        </div>
                                                                    </button>
                                                                </h2>
                                                                <div id="CuasTag-{{$i}}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne" style="">
                                                                    <div class="accordian-header m-1">
                                                                        <div class="row bg-light pt-2 g-2">
                                                                            <div class="col-12">
                                                                                <!-- <span class=""> -->
                                                                                    <div class="card">
                                                                                        <div class="card-footer">
                                                                                            @if(@$value->STATUS == 'งานลงพื้นที่')
                                                                                                <div class="row p-3 mb-2 bg-primary bg-opacity-50">
                                                                                                    <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                                                                                                        <div class="">
                                                                                                            <label for="formrow-firstname-input" class="form-label">วันที่ลงพื้นที่</label>
                                                                                                            <input type="text" value="{{(@$value->ToAREA->DATE_AREA != NULL)?date('d-m-Y',strtotime(@$value->ToAREA->DATE_AREA)):'-'}}" class="form-control mt-n2 mb-2" placeholder="วันที่ลงพื้นที่"/>
                                                                                                        </div>
                                                                                                        <div class="">
                                                                                                            <label for="formrow-firstname-input" class="form-label">สถานลงพื้นที่</label>
                                                                                                            <input type="text" value="{{(@$value->ToAREA->PLACE_AREA != NULL)?date('d-m-Y',strtotime(@$value->ToAREA->PLACE_AREA)):'-'}}" class="form-control mt-n2 mb-2" placeholder="วันที่ลงพื้นที่"/>
                                                                                                        </div>
                                                                                                        @if(@$value->ToAREA->PAY_AREA)
                                                                                                        <div class="">
                                                                                                            <label for="formrow-firstname-input" class="form-label">ค่าลงพื้นที่</label>
                                                                                                            <input type="text" value="{{(@$value->ToAREA->PAY_AREA != NULL)?number_format(@$value->ToAREA->PAY_AREA):'-'}}" class="form-control mt-n2 mb-2" placeholder="วันที่ลงพื้นที่"/>
                                                                                                        </div>
                                                                                                        @endif
                                                                                                        @if(@$value->PAYDUE)
                                                                                                        <div class="">
                                                                                                            <label for="formrow-firstname-input" class="form-label">ยอดนัดชำระ</label>
                                                                                                            <input type="text" value="{{(@$value->PAYDUE != NULL)?@$value->PAYDUE:'-'}}" class="form-control mt-n2 mb-2" placeholder="ยอดนัดชำระ"/>
                                                                                                        </div>
                                                                                                        @endif
                                                                                                        <div class="">
                                                                                                            <label for="formrow-firstname-input" class="form-labe">สถานะทรัพย์</label>
                                                                                                            <input type="text" value="{{(@$value->ToAREA->STATUS_ASSET != NULL)?@$value->ToAREA->STATUS_ASSET:'-'}}" class="form-control mt-n2 mb-2" placeholder="สถานะทรัพย์"/>
                                                                                                        </div>
                                                                                                        <div class="">
                                                                                                            <label for="formrow-firstname-input" class="form-labe">สถานะใช้งาน</label>
                                                                                                            <input type="text" value="{{(@$value->ToAREA->FLAG_ASSET != NULL)?@$value->ToAREA->FLAG_ASSET:'-'}}" class="form-control mt-n2 mb-2" placeholder="สถานะทรัพย์"/>
                                                                                                        </div>
                                                                                                        <div class="">
                                                                                                            <label for="formrow-firstname-input" class="form-labe">บุคคล</label>
                                                                                                            <input type="text" value="{{(@$value->ToAREA->STATUS_DEBT != NULL)?@$value->ToAREA->STATUS_DEBT:'-'}}" class="form-control mt-n2 mb-2" placeholder="สถานะลูกหนี้"/>
                                                                                                        </div>
                                                                                                        <div class="">
                                                                                                            <label for="formrow-firstname-input" class="form-labe">สถานะบุคคล</label>
                                                                                                            <input type="text" value="{{(@$value->ToAREA->FLAG_DEBT != NULL)?@$value->ToAREA->FLAG_DEBT:'-'}}" class="form-control mt-n2 mb-2" placeholder="สถานะลูกหนี้"/>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
                                                                                                        <div class="">
                                                                                                            <label for="formrow-firstname-input" class="form-label">รายละเอียดลงพื้นที่</label>
                                                                                                            <textarea class="form-control mt-n2 mb-2" placeholder="ลงบันทึก" style="height: {{(@$value->PAYDUE)?'164px;':'102px;'}}">{{(@$value->ToAREA->NOTE != NULL)?@$value->ToAREA->NOTE:'-'}}</textarea>
                                                                                                        </div>
                                                                                                        <div class="">
                                                                                                            <label for="formrow-firstname-input" class="form-labe">พิกัด</label>
                                                                                                            <div class="input-group">
                                                                                                                <input type="text" value="{{(@$value->ToAREA->LATLONG != NULL)?@$value->ToAREA->LATLONG:'-'}}" class="form-control mt-n2 mb-2" placeholder="พิกัด"/>
                                                                                                                @if((@$value->ToAREA->LATLONG != NULL))
                                                                                                                    @php
                                                                                                                        @$Setlaglong = explode(",",@$value->ToAREA->LATLONG);
                                                                                                                    @endphp
                                                                                                                    <span class="input-group-text mt-n2 mb-2">
                                                                                                                        <a href="https://www.google.com/maps?q={{@$Setlaglong[0]}},{{@$Setlaglong[1]}}" target="_blank">
                                                                                                                            <i class="bx bx-map-pin font-size-14"></i>
                                                                                                                        </a>
                                                                                                                    </span>
                                                                                                                @endif
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="">
                                                                                                            <label for="formrow-firstname-input" class="form-labe">ลิงค์รูปลงพื้นที่</label>
                                                                                                            <div class="input-group">
                                                                                                                <input type="text" value="{{(@$value->ToAREA->LINK_IMAGE != NULL)?@$value->ToAREA->LINK_IMAGE:'-'}}" class="form-control mt-n2 mb-2" placeholder="พิกัด"/>
                                                                                                                @if((@$value->ToAREA->LINK_IMAGE != NULL))
                                                                                                                    <span class="input-group-text mt-n2 mb-2">
                                                                                                                        <a href="{{@$value->ToAREA->LINK_IMAGE}}" target="_blank">
                                                                                                                            <i class="mdi mdi-link-variant font-size-14"></i>
                                                                                                                        </a>
                                                                                                                    </span>
                                                                                                                @endif
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="">
                                                                                                            <label for="formrow-firstname-input" class="form-label">หมายเหตุ</label>
                                                                                                            <textarea class="form-control mt-n2 mb-2" placeholder="ลงบันทึก" style="height: {{(@$value->PAYDUE)?'164px;':'102px;'}}">{{(@$value->ToAREA->MEMO != NULL)?@$value->ToAREA->MEMO:'-'}}</textarea>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            @else 
                                                                                                <div class="row p-3 mb-2 bg-warning bg-opacity-50 text-dark">
                                                                                                    @if(@$value->STATUS <> "" or @$value->RESULT <> "")
                                                                                                        <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 ">
                                                                                                            <div class="">
                                                                                                                <label for="formrow-firstname-input" class="form-label">วันที่นัดชำระ</label>
                                                                                                                <input type="text" value="{{(@$value->DDATE != NULL)?date('d-m-Y',strtotime(@$value->DDATE)):'-'}}" class="form-control mt-n2 mb-2" placeholder="วันที่นัดชำระ"/>
                                                                                                            </div>
                                                                                                            <div class="">
                                                                                                                <label for="formrow-firstname-input" class="form-label">ยอดนัดชำระ</label>
                                                                                                                <input type="text" value="{{(@$value->PAYDUE != NULL)?@$value->PAYDUE:'-'}}" class="form-control mt-n2" placeholder="ยอดนัดชำระ"/>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
                                                                                                            <div class="">
                                                                                                                <label for="formrow-firstname-input" class="form-label">รายละเอียดติดตาม</label>
                                                                                                                <textarea class="form-control mt-n2" placeholder="ลงบันทึก" style="height: 103px;">{{@$value->NOTE}}</textarea>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    @else 
                                                                                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
                                                                                                            <div class="">
                                                                                                                <label for="formrow-firstname-input" class="form-label">รายละเอียดติดตาม</label>
                                                                                                                <textarea class="form-control mt-n2" placeholder="ลงบันทึก" style="height: 103px;">{{@$value->NOTE}}</textarea>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    @endif
                                                                                                </div>
                                                                                            @endif
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col">
                                                                                            <small class="text-muted mt-n3">{{@$value->created_at}}</small>
                                                                                        </div>
                                                                                    </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="maintenance-img content-image mt-5" style="opacity: 0.2;">
                                                        <img src="{{ URL::asset('assets/images/undraw/undraw_selecting_team_re_ndkb.svg') }}" alt="" class="img-fluid mx-auto d-block" style="max-height: 40vh;">
                                                    </div>
                                                    <!-- <h5 class="text-danger text-center mt-5 font-size-12">--- ไม่มีรายการบันทึก ---</h5> -->
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-light mr-5 pr-5 ml-5 SaveDT d-lg-none d-sm-block text-muted" title="บันทึก" aria-label="Close">
                <span class="addSpin"><i class="fas fa-download"></i></span> บันทึก
            </button>
            <button type="button" class="btn btn-light d-lg-none d-sm-block text-muted" title="ปิด POP-UP" data-bs-dismiss="modal" aria-label="Close">
                ปิด
            </button>
        </div>
    </div>


{{-- input selection --}}
<script>
    $(document).ready(function(){
        $("#tracktab").click(function() {
            $(this).addClass('first current');
            $("#icon1").addClass('bx-tada');
            $("#icon2").removeClass('bx-tada');
            $("#tracklist").removeClass('first current');
        });
        $("#tracklist").click(function() {
            $(this).addClass('first current');
            $("#icon2").addClass('bx-tada');
            $("#icon1").removeClass('bx-tada');
            $("#tracktab").removeClass('first current');
        });
        //ประเภทบันทึก
        $("#STATUS_TRACK").change(function() {
            var status1 = $("#STATUS_TRACK").val();
            if(status1 == 'งานโทร'){
                $(".content-hide").hide();
                $("#RESULT").attr('disabled',false);
                $("#RESULT").attr('required',true);
                $("#RESULT").val('');
                $("#NOTE").attr('required',true);
                $("#LATLONG").attr('required',false);
                $("#DDATE2").attr('required',false);
                $("#PLACE_AREA").attr('required',false);
                $("#NoteArea").attr('required',false);
                $(".img-temp").removeClass('d-none');
                $("#comment-track").removeClass('d-none');
            }
            else if(status1 == 'งานลงพื้นที่'){
                $("#areaLocation").removeClass('d-none');
                $("#area-part").removeClass('d-none');
                $(".content-hide").show();
                $("#LATLONG").attr('required',true);
                $("#DDATE2").attr('required',true);
                $("#PLACE_AREA").attr('required',true);
                $("#NOTE").attr('required',false);
                $("#NoteArea").attr('required',true);
                $(".img-temp").addClass('d-none');
                $("#comment-track").addClass('d-none');
                $("#RESULT").attr('required',false);
                $("#RESULT").val('');
                $("#DDATE").val('');
                $("#NOTE").val('');
            }
            else{
                $(".content-hide").hide();
                $("#comment-track").removeClass('d-none');
                $(".img-temp").removeClass('d-none');
                $('#formDA')[0].reset();
            }
        });
        //สถานะติดตาม
        $("#RESULT").change(function() {
            var status = $("#STATUS_TRACK").val();
            var data = $(this).val();
            if(data == 'โทรไม่ติด' || data == 'ไม่รับสาย') {
                $("#datepicker1").removeClass('d-none');
                $("#appointment1").removeClass('d-none');
                $("#track-part").removeClass('d-none');
                $("#area-part").addClass('d-none');
                $("#DDATE").attr('readonly',true);

                var newdate = new Date();
                newdate.setDate(newdate.getDate() + 1);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var yyyy = newdate.getFullYear();
                if (dd < 10) {
                    var Newdd = '0' + dd;
                }else {
                    var Newdd = dd;
                }
                if (mm < 10) {
                    var Newmm = '0' + mm;
                }else {
                    var Newmm = mm;
                }
                // var resultDate = yyyy + '-' + Newmm + '-' + Newdd;
                var resultDate = Newdd + '/' + Newmm + '/' + yyyy;
                $("#DDATE").val(resultDate);
            }
            else if(data == 'นัดลงพื้นที่') {
                $("#DDATE").attr('data-date-enable-on-readonly', "true");
                $("#DDATE").attr('required',true);
                $("#DDATE").val('');
            }
            else{
                $("#DDATE").attr('data-date-enable-on-readonly', "false");
                $("#DDATE").attr('required',false);
                $("#DDATE").val('');
            }
        });
        //สถานะทรัพย์
        $("#STATUS_ASSET").change(function() {
            var status_asset = $(this).val();
            if(status_asset == 'เจอ') {
                $("#FLAG_ASSET").attr('required',true);
            }
            else{
                $("#FLAG_ASSET").attr('required',false);
            }
        });
        //บุคคล
        $("#STATUS_DEBT").change(function() {
            var status_debt = $(this).val();
            if(status_debt != '') {
                $("#MEMO").attr('required',true);
            }
            else{
                $("#MEMO").attr('required',false);
            }
        });
        //สถานะบุคคล
        $("#FLAG_DEBT").change(function() {
            var flag_debt = $(this).val();
            var ddate = $("#DDATE").val();
            if(flag_debt == 'เจอ') {
                $("#DDATE").val('');
                $("#STATUS_AROUND").val('');
            }
            else{
                $("#DDATE").val(ddate);
            }
        });
        //สถานะบุคคลรอบตัว
        $("#STATUS_AROUND").change(function() {
            var flag_debt = $("#FLAG_DEBT").val();
            var around = $(this).val();
            if(flag_debt == 'ไม่เจอ' || around == 'ไม่เจอ') {
                $("#DDATE").attr('readonly', true);
                var newdate = new Date();
                newdate.setDate(newdate.getDate() + 3);
                var dd = newdate.getDate();
                var mm = newdate.getMonth() + 1;
                var yyyy = newdate.getFullYear();
                if (dd < 10) {
                    var Newdd = '0' + dd;
                }else {
                    var Newdd = dd;
                }
                if (mm < 10) {
                    var Newmm = '0' + mm;
                }else {
                    var Newmm = mm;
                }
                var resultDate = Newdd + '/' + Newmm + '/' + yyyy;
                $("#DDATE").val(resultDate);
            }
            else if(flag_debt != 'ไม่เจอ' || around != 'ไม่เจอ') {
                $("#DDATE").attr('readonly', false);
                $("#DDATE").val('');
            }
            else{
                $("#DDATE").attr('readonly', false);
                $("#DDATE").val('');
            }
        });
    });
</script>

@if(@$loanType == 2)
    <script>
        $("#switch1").change(function() {
            if (this.checked) {
                document.getElementById('PAY_AREA').value = 400;
                document.getElementById('PAY_AREA').removeAttribute('readonly');
                $('#text-val-area').text('ค่าลงพื้นที่');
            } else {
                document.getElementById('PAY_AREA').value = '';
                document.getElementById('PAY_AREA').Attribute('readonly');
                $('#text-val-area').text('.');
            }
        });
    </script>
@endif


<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>

{{-- google maps --}}
<script>
    function appendGoogleMapApis() {
        if (typeof google === 'object' && typeof google.maps === 'object') {
            initMap();
        } else {
            var script = document.createElement("script");
            script.type = "text/javascript";
            script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyCyqGqjIB7DvtpbSmZ14qyhKbA7XQdHw2Y&callback=initMap&language=th";
            document.body.appendChild(script);
        }
    }
    appendGoogleMapApis();
</script>
<script>
    function initMap() {
        //console.log( "initMap" );
        var _center = {};
        var _zoom = 9;
        @if( @$lat != null && @$lng != null )
            //_zoom = 12;
            _center = { lat: {{@$lat}}, lng: {{@$lng}} };
        @endif
        if (_center == null) return;
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: _zoom,
            center: _center
        });

        const infoWindow = new google.maps.InfoWindow();

        // The marker, positioned at Uluru
        const marker = new google.maps.Marker({
            position: _center,
            animation: google.maps.Animation.DROP,
            map: map,
            draggable: true,
            title: "พิกัด",
        });

        marker.addListener("click", (event) => {
            const position = marker.position;
            infoWindow.close();
            infoWindow.setContent(`พิกัด : ${position.lat()},${position.lng()}`);
            infoWindow.open(marker.map, marker);

        });

        function dragEvent(event) {
            const position = event.latLng;
            infoWindow.setContent(`พิกัด : ${position.lat()},${position.lng()}`);
            $("#LATLONG").val( position.lat()+ ","+ position.lng());
        }

        marker.addListener('drag', dragEvent);
        marker.addListener('dragend', dragEvent);
        
        // $("#LATLONG").val( _center.lat + "," + _center.lng);

            // ถ้าเป็นการแก้ไข จะแสดงปุ่ม ปักหมุดตำแหน่งปัจจุบันให้
            const locationButton = document.getElementById('BtnLocation2');
            
            // const locationButton = document.createElement("button");
            // locationButton.textContent = "ปักหมุดตำแหน่งปัจจุบัน";//"Pan to Current Location";
            // locationButton.classList.add("custom-map-control-button");
            // map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);
            locationButton.addEventListener("click", () => {
                // Try HTML5 geolocation.
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            const pos = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude,
                            };

                            marker.setPosition(pos);
                            map.setCenter(pos);

                            infoWindow.close();
                            $("#LATLONG").val( pos.lat + "," + pos.lng );
                        },
                        () => {
                            handleLocationError(true, infoWindow, map.getCenter() );
                        }
                    );
                } else {
                    // Browser doesn't support Geolocation
                    handleLocationError(false, infoWindow, map.getCenter() );
                }
            });
    }
    
    window.initMap = initMap;

    function handleLocationError(
        browserHasGeolocation,
        infoWindow,
        pos,
        map
    ) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(
            browserHasGeolocation
            ? "ล้มเหลว! ไม่สามารถเข้าถึงตำแหน่งปัจจุบัน กรุณาตรวจสอบสิทธิ์การเข้าถึง"
            : "ขออภัย! เบราว์เซอร์ของคุณไม่รองรับการเข้าถึงตำแหน่ง"
        );
        infoWindow.open(map);
    }

</script>