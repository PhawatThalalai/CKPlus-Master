<!-- Right Sidebar -->
<div class="right-bar">
    <div data-simplebar class="h-100">
        <div class="rightbar-title d-flex align-items-center px-3 py-4" style="background-image: linear-gradient(rgba(0, 0, 255, 0.5), rgba(255, 255, 255, 0.5)),  url('{{ asset("assets/images/setting.png") }}');  background-size: cover;  background-repeat: no-repeat;">
            <span class="bg-primary p-2 text-center" style="border-radius:50px; opacity:0.7;">
            <h5 class="m-0 me-0 text-white">Settings</h5>
            </span>

            <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                <i class="mdi mdi-close noti-icon"></i>
            </a>
        </div>

        <!-- Settings -->
        <hr class="mt-0" />

        
            <!-- Nav tabs -->
            {{--
            @if (!empty(trim($__env->yieldContent('page-backend'))))
            <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-bs-toggle="tab" href="#setting1" role="tab" aria-selected="false" tabindex="-1">
                        <span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
                        <span class="d-none d-sm-block">ตั้งค่าระบบ</span> 
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-bs-toggle="tab" href="#layout1" role="tab" aria-selected="false" tabindex="-1">
                        <span class="d-block d-sm-none"><i class="far fa-user"></i></span>
                        <span class="d-none d-sm-block">Layouts</span> 
                    </a>
                </li>
            </ul>
            @else 
            @endif
            --}}
            <h6 class="text-center mb-0">Choose Layouts</h6>

            <!-- Tab panes -->
            {{--
            @if (!empty(trim($__env->yieldContent('page-backend'))))
            <div class="tab-content p-3 text-muted">
                <div class="tab-pane active" id="setting1" role="tabpanel">
                    <ul class="list-unstyled categories-list">
                        <li>
                            <div class="custom-accordion">
                                <a class="text-body fw-medium py-1 d-flex align-items-center" data-bs-toggle="collapse" href="#categories1-collapse" role="button" aria-expanded="false" aria-controls="categories-collapse">
                                    <i class="mdi mdi-car-multiple font-size-18 text-danger me-2"></i> ระบบราคากลาง <i class="mdi mdi-chevron-up accor-down-icon ms-auto"></i>
                                </a>
                                <div class="collapse" id="categories1-collapse">
                                    <div class="card border-0 shadow-none ps-2 mb-0">
                                        <ul class="list-unstyled mb-0">
                                            <li><a href="{{route('dataStatic.index')}}?page={{'frontend'}}&set={{'data-rate'}}&setsub={{'rate-car'}}" class="d-flex align-items-center"><span class="me-auto">รถยนต์</span> <i class="fas fa-car ms-auto"></i></a></li>
                                            <li><a href="{{route('dataStatic.index')}}?page={{'frontend'}}&set={{'data-rate'}}&setsub={{'rate-moto'}}" class="d-flex align-items-center"><span class="me-auto">มอเตอร์ไซต์</span> <i class="fas fa-motorcycle fa-sm ms-auto"></i></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- <li>
                            <a href="{{ route('dataStatic.index') }}?page={{'frontend'}}&set={{'midprices'}}" class="text-body d-flex align-items-center">
                                <i class="mdi mdi-folder-key font-size-18 text-warning me-2"></i> <span class="me-auto">ระบบราคากลาง</span> 
                            </a>
                        </li> -->
                        <li>
                            <a href="{{ route('dataStatic.index') }}?page={{'frontend'}}&set={{'data-contract'}}" class="text-body d-flex align-items-center">
                                <i class="mdi mdi-folder-table font-size-18 text-warning me-2"></i> <span class="me-auto">ตั้งค่าสัญญา</span> 
                                @if(!empty(trim($__env->yieldContent('data-contract'))))
                                    <i class="mdi mdi-circle-medium text-danger font-size-18"></i>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dataStatic.index') }}?page={{'frontend'}}&set={{'data-companies'}}" class="text-body d-flex align-items-center">
                                <i class="mdi mdi-folder-home font-size-18 text-warning me-2"></i> <span class="me-auto">ตั้งค่าข้อมูลบริษัท</span> 
                                @if(!empty(trim($__env->yieldContent('data-companies'))))
                                    <i class="mdi mdi-circle-medium text-danger font-size-18"></i>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dataStatic.index') }}?page={{'frontend'}}&set={{'data-interest'}}" class="text-body d-flex align-items-center">
                                <i class="mdi mdi-folder-star font-size-18 text-warning me-2"></i> <span class="me-auto">ตั้งค่าดอกเบี้ย</span>
                                @if(!empty(trim($__env->yieldContent('data-interest'))))
                                    <i class="mdi mdi-circle-medium text-danger font-size-18"></i>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dataStatic.index') }}?page={{'frontend'}}&set={{'data-general'}}" class="text-body d-flex align-items-center">
                                <i class="mdi mdi-folder-cog font-size-18 text-warning me-2"></i> <span class="me-auto">ตั้งค่าทั่วไป</span> 
                                @if(!empty(trim($__env->yieldContent('data-general'))))
                                    <i class="mdi mdi-circle-medium text-danger font-size-18"></i>
                                @endif
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dataStatic.index') }}?page={{'backend'}}&set={{'data-debt'}}" class="text-body d-flex align-items-center">
                                <i class="mdi mdi-folder-pound font-size-18 text-warning font-size-18"></i> <span class="me-auto">ตั้งค่าระบบหนี้</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-pane" id="layout1" role="tabpanel">
                    <!-- <h6 class="text-center mb-0">Layouts</h6> -->
                    <div class="p-4">
                        <div class="mb-2">
                            <img src="{{ asset("assets/images/layouts/layout-1.jpg") }}" class="img-fluid img-thumbnail" alt="">
                        </div>

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                            <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                        </div>

                        <div class="mb-2">
                            <img src="{{ asset("assets/images/layouts/layout-2.jpg") }}" class="img-fluid img-thumbnail" alt="">
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch" data-bsStyle="assets/css/bootstrap-dark.min.css" data-appStyle="assets/css/app-dark.min.css">
                            <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                        </div>

                        <!-- <div class="mb-2">
                            <img src="{{ asset("assets/images/layouts/layout-3.jpg") }}" class="img-fluid img-thumbnail" alt="">
                        </div>
                        <div class="form-check form-switch mb-5">
                            <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch" data-appStyle="assets/css/app-rtl.min.css">
                            <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                        </div>

                        <div class="mb-2">
                            <img src="{{ asset("assets/images/layouts/layout-4.jpg") }}" class="img-thumbnail" alt="layout images">
                        </div>
                        <div class="form-check form-switch mb-5">
                            <input class="form-check-input theme-choice" type="checkbox" id="dark-rtl-mode-switch">
                            <label class="form-check-label" for="dark-rtl-mode-switch">Dark RTL Mode</label>
                        </div> -->

                    </div>
                </div>
            </div>
            @else 
                <!-- <h6 class="text-center mb-0">Layouts</h6> -->
            @endif
            --}}
                
            <div class="p-4">
                <div class="mb-2">
                    <img src="{{ asset("assets/images/layouts/layout-1.jpg") }}" class="img-fluid img-thumbnail" alt="">
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                    <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                </div>

                <div class="mb-2">
                    <img src="{{ asset("assets/images/layouts/layout-2.jpg") }}" class="img-fluid img-thumbnail" alt="">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch" data-bsStyle="assets/css/bootstrap-dark.min.css" data-appStyle="assets/css/app-dark.min.css">
                    <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                </div>

                <!-- <div class="mb-2">
                    <img src="{{ asset("assets/images/layouts/layout-3.jpg") }}" class="img-fluid img-thumbnail" alt="">
                </div>
                <div class="form-check form-switch mb-5">
                    <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch" data-appStyle="assets/css/app-rtl.min.css">
                    <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                </div>

                <div class="mb-2">
                    <img src="{{ asset("assets/images/layouts/layout-4.jpg") }}" class="img-thumbnail" alt="layout images">
                </div>
                <div class="form-check form-switch mb-5">
                    <input class="form-check-input theme-choice" type="checkbox" id="dark-rtl-mode-switch">
                    <label class="form-check-label" for="dark-rtl-mode-switch">Dark RTL Mode</label>
                </div> -->

            </div>

        

    </div> <!-- end slimscroll-menu-->
</div>
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>
