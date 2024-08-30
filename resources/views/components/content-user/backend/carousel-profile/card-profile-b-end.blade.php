<div class="card">

    <div id="carouselExampleIndicators" class="carousel carousel-dark slide position-relative">

        <button class="position-absolute top-50 start-100 translate-middle btn btn-sm btn-outline-primary rounded" style="--bs-btn-padding-y: .125rem; --bs-btn-padding-x: .4rem; z-index: 1;" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <i class="mdi mdi-arrow-right font-size-16"></i>
        </button>
        <button class="position-absolute top-50 start-0 translate-middle btn btn-sm btn-outline-primary rounded" style="--bs-btn-padding-y: .125rem; --bs-btn-padding-x: .4rem; z-index: 1;" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <i class="mdi mdi-arrow-left font-size-16"></i>
        </button>

        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="bg-primary carousel-btn-indicator active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" class="bg-primary carousel-btn-indicator" aria-label="Slide 2"></button>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active carousel-item-profile-b-end">

                <div class="row g-2">
                    <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12">
                        <div class="card-body pb-0">
                            <h4 class="card-title text-muted bg-info bg-opacity-10 text-center">Contract Information</h4>
                            <div>
                                <ul class="list-unstyled m-0">
                                    <li class="mt-3">
                                        <div class="d-flex">
                                            <i class="bx bx-analyse text-primary fs-4"></i>
                                            <div class="ms-3">
                                                <h6 class="fs-14 mb-2 fw-semibold">เลขที่สัญญา</h6>
                                                <p class="text-primary fs-14 mb-0">
                                                    502401990000
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mt-3">
                                        <div class="d-flex">
                                            <i class="bx bx-map text-primary fs-4"></i>
                                            <div class="ms-3">
                                                <h6 class="fs-14 mb-2 fw-semibold">สาขา</h6>
                                                <p class="text-muted fs-14 mb-0">
                                                    CKT - สำนักงานใหญ่
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mt-3">
                                        <div class="d-flex">
                                            <i class="bx bx-layer text-primary fs-4"></i>
                                            <div class="ms-3">
                                                <h6 class="fs-14 mb-2 fw-semibold">ประเภทสัญญา</h6>
                                                {{ @$data['NameCon'] }}
                                                @if (!empty(@$data['typeCon']))
                                                    ( {{ @$data['typeCon'] }} )
                                                @endif
                                                เงินกู้รถยนต์ ( 02 )
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12">
                        <div class="card-body">
                            <h4 class="card-title text-muted bg-info bg-opacity-10 text-center">Personal Information</h4>
                            <div>
                                <ul class="list-unstyled m-0">
                                    <li class="mt-3">
                                        <div class="d-flex">
                                            <i class="bx bx-user-circle text-primary fs-4"></i>
                                            <div class="ms-3">
                                                <h6 class="fs-14 mb-2 fw-semibold">ชื่อ-นามสกุล</h6>
                                                <p class="text-muted fs-14 mb-0">
                                                    นายเกรียงไกร ชีพนุรัตน์ (เป)
                                                    @isset($data['NameEng'])
                                                        <br>
                                                        <span class="text-primary">
                                                            <b>{{ '' . @$data['NameEng'] . '' }}</b>
                                                        </span>
                                                    @endisset
    
                                                    <br>
                                                        <span class="text-primary">
                                                            <b>Kriangkral</b>
                                                        </span>
    
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mt-3">
                                        <div class="d-flex">
                                            {{ @$id_card_icon }}
                                            <i class="bx bx-id-card text-primary fs-4"></i>
    
                                            <div class="ms-3">
                                                <h6 class="fs-14 mb-2 fw-semibold">{{ @$id_card_name }} เลขประจำตัวประชาชน </h6>
                                                @isset($data['idcard'])
                                                    <p @if (empty(@$data['typeidcard']) || @$data['typeidcard'] == '324001') class="text-muted fs-14 mb-0 input-mask" data-inputmask="'mask': '9-9999-99999-99-9'" @else class="text-muted fs-14 mb-0" @endif>
                                                        {{ @$data['idcard'] }}
                                                    </p>
                                                    {{-- {{ @$id_card_exp }} --}}
                                                @endisset
    
                                                <p class="text-muted fs-14 mb-0">
                                                    1-8402-00015-27-4
                                                </p>
    
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="carousel-item carousel-item-profile-b-end">
                <div class="row g-2">
                    <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12">
                        <div class="card-body pb-0">
                            <h4 class="card-title text-muted bg-info bg-opacity-10 text-center">Asset Information</h4>
                            <div>
                                <ul class="list-unstyled">
                                    <li class="mt-3">
                                        <div class="d-flex">
                                            {{ @$asset_icon }}
                                            <i class="bx bx-car text-primary fs-4"></i>
    
                                            <div class="ms-3">
                                                <h6 class="fs-14 mb-2 fw-semibold">{{ @$asset_data['title'] }} เลขทะเบียน</h6>
                                                @if (@$asset_data['title'] == 'เลขทะเบียน')
                                                    <span class="me-1" data-bs-toggle="tooltip" data-bs-html="true" aria-label="ป้ายเดิม" title="ป้ายเดิม">
                                                        <i class="mdi mdi-card-bulleted-outline h5 text-success"></i> {{ @$asset_data['value'] }}
                                                    </span>
                                                @else
                                                    {{ @$asset_data['value'] }}
                                                @endif
    
                                                <span class="me-1" data-bs-toggle="tooltip" data-bs-html="true" aria-label="ป้ายใหม่" title="ป้ายใหม่">
                                                    <i class="mdi mdi-card-bulleted-outline h5 text-success"></i> ผฉ5310 สฎ
                                                </span>
                                            
                                            </div>
                                        </div>
                                    </li>
    
                                    <li class="mt-3">
                                        <div class="d-flex">
                                            <i class="bx bx-search-alt text-primary fs-4"></i>
                                            <div class="ms-3">
                                                <h6 class="fs-14 mb-2 fw-semibold">เลขตัวถัง</h6>
                                                MP1TFR86H7T176854
                                            </div>
                                        </div>
                                    </li>
    
                                    <li class="mt-3">
                                        <div class="d-flex">
                                            <i class="bx bx-purchase-tag-alt text-primary fs-4"></i>
                                            <div class="ms-3">
                                                <h6 class="fs-14 mb-2 fw-semibold">ราคาขาย</h6>
                                                <p class="text-muted fs-14 mb-0">
                                                    100,000 ฿
                                                </p>
                                            </div>
                                        </div>
                                    </li>
    
                                </ul>
                            </div>
                        </div>
                    </div>
    
                    <div class="col-xl-12 col-lg-6 col-md-6 col-sm-12">
                        <div class="card-body">
                            <h4 class="card-title text-muted bg-info bg-opacity-10 text-center">Payment Information</h4>
                            <div>
                                <ul class="list-unstyled">
                                    <li class="mt-3">
                                        <div class="d-flex">
                                            <i class="bx bx-money text-primary fs-4"></i>
                                            <div class="ms-3">
                                                <h6 class="fs-14 mb-2 fw-semibold">ชำระเงินแล้ว</h6>
                                                <p class="text-muted fs-14 mb-0">
                                                    100,000 ฿
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mt-3">
                                        <div class="d-flex">
                                            <i class="bx bx-dollar-circle text-primary fs-4"></i>
                                            <div class="ms-3">
                                                <h6 class="fs-14 mb-2 fw-semibold">ยอดคงเหลือ</h6>
                                                <p class="text-muted fs-14 mb-0">
                                                    100,000 ฿
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="mt-3">
                                        <div class="d-flex">
                                            <i class="bx bx-money text-danger fs-4"></i>
                                            <div class="ms-3">
                                                <h6 class="fs-14 mb-2 fw-semibold">ยอดค้างชำระ</h6>
                                                <p class="text-muted fs-14 mb-0">
                                                    100,000 ฿
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>

<!-- สคิรปต์การทำงานของ carousel-profile -->
<script>

</script>