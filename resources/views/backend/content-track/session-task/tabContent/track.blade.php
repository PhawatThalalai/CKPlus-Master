<!-- ปุ่มแท็บหัวข้อ -->
<div class="mt-5">
    <div class="position-relative m-4" id="TrackTabList" role="tablist">
        <div class="progress" id="track_progress" style="height: 3px;">
            <div class="progress-bar bg-warning" role="progressbar" style="width: {{ (@$activeTab["Track"]-1) / (3-1) * 100 }}%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <button type="button" @class(['tab-form-step-btn nav-link position-absolute top-0 start-0 translate-middle btn btn-sm text-light rounded-pill btn-warning', 'active' => @$activeTab["Track"] == 1]) id="track-tab-1" data-bs-toggle="pill" data-bs-target="#track-tab-pane-1" role="tab" data-tabnumber="1">
            1
            <span @class(["label-tabbtn position-absolute start-50 translate-middle badge rounded-pill fw-bold font-size-14", 'text-secondary' => @$activeTab["Track"] < 1,'text-dark' => @$activeTab["Track"] >= 1]) style="top: -1.5rem;">
                แบ่งกลุ่ม
            </span>
        </button>
        
        <button type="button" @class(['tab-form-step-btn nav-link position-absolute top-0 start-50 translate-middle btn btn-sm text-light rounded-pill', 'btn-secondary' => @$activeTab["Track"] < 2, 'btn-warning' => @$activeTab["Track"] >= 2, 'active' => @$activeTab["Track"] == 2]) id="track-tab-2" data-bs-toggle="pill" data-bs-target="#track-tab-pane-2" role="tab" data-tabnumber="2">
            @if( $track_unassigned > 0 )
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $track_unassigned }}
                    <span class="visually-hidden">unassign group</span>
                </span>
            @endif
            2
            <span @class(["label-tabbtn position-absolute start-50 translate-middle badge rounded-pill fw-bold font-size-14", 'text-secondary' => @$activeTab["Track"] < 2,'text-dark' => @$activeTab["Track"] >= 2]) style="top: -1.5rem;">
                มอบหมาย
            </span>
        </button>
        <button type="button" @class(['tab-form-step-btn nav-link position-absolute top-0 start-100 translate-middle btn btn-sm text-light rounded-pill', 'btn-secondary' => @$activeTab["Track"] != 3, 'btn-warning' => @$activeTab["Track"] >= 3, 'active' => @$activeTab["Track"] == 3]) class="" id="track-tab-3" data-bs-toggle="pill" data-bs-target="#track-tab-pane-3" role="tab" aria-controls="track-tab-3" aria-selected="false" data-tabnumber="3">
            @if( $track_unconfirmed > 0 )
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $track_unconfirmed }}
                    <span class="visually-hidden">unconfirmed group</span>
                </span>
            @endif
            3 
            <span @class(["label-tabbtn position-absolute start-50 translate-middle badge rounded-pill fw-bold font-size-14", 'text-secondary' => @$activeTab["Track"] < 3,'text-dark' => @$activeTab["Track"] >= 3]) style="top: -1.5rem;">
                ยืนยัน
            </span>
        </button>
    </div>
</div>

<!-- เงื่อนไขการปลดล็อคแท็บ -->
<input type="hidden" name="UnlockTrackTab1" value="{{@$unlockTab["Track"][1]}}">
<input type="hidden" name="UnlockTrackTab2" value="{{@$unlockTab["Track"][2]}}">
<input type="hidden" name="UnlockTrackTab3" value="{{@$unlockTab["Track"][3]}}">

<div class="d-flex justify-content-between mt-5">
    <button role="button" id="TrackTabHelp_Prev" class="btn btn-sm btn-rounded btn-light" onclick="TrackTabPrevBtnClicked()">
        <i class="bx bx-left-arrow-alt fe-2"></i>
        ขั้นตอนก่อนหน้า
    </button>
    <button role="button" id="TrackTabHelp_Next" @class(["btn btn-sm btn-rounded btn-light", "glow-secondary" => @$highlightsNextTab ]) onclick="TrackTabNextBtnClicked()">
        ขั้นตอนถัดไป
        <i class="bx bx-right-arrow-alt fe-2"></i>
    </button>
</div>

<div class="tab-content mt-2" id="TrackTabContent">

    <!-- แท็บที่ 1 -->
    <div @class(['tab-pane fade', 'show active' => $activeTab["Track"] == 1]) id="track-tab-pane-1" role="tabpanel" aria-labelledby="track-tab-1" tabindex="0">

        <!-- เมนู หัวฟอร์ม -->
        <div class="card shadow-none border border-warning border-opacity-50 rounded-3">

            <div class="row g-0">
                <div class="col-12">
                    <div class="card-body bg-warning bg-soft text-dark">
                        <h4 class="card-title m-0">ขั้นที่ 1 แบ่งกลุ่มลูกหนี้</h4>
                        <p class="card-title-desc mb-2">แยกรายการลูกหนี้ออกเป็นกลุ่มต่าง ๆ สำหรับกลุ่มงานตาม ให้ระบุจำนวนกลุ่มที่ต้องแบ่ง</p>
                        <form name="grouping-track" id="grouping-track" autocomplete="off">
                            @method('PUT')
                            @csrf
                            <input type="hidden" name="page" value="task">
                            <input type="hidden" name="mode" value="track">
                            <input type="hidden" name="func" value="grouping">
                            <input type="hidden" name="groupingStack" value="0">

                            <div class="hstack gap-1 gap-sm-3">
                                <div class="row row-cols-lg-3 g-2 g-md-3 align-items-center me-auto">
                                    <div class="col-12 col-sm-6 col-lg-6 col-xl">
                                        <div class="input-bx">
                                            @if(isset($lastRequest["Track"]["Tab1"]["TYPECONT"]))
                                                <select name="TYPECONT" class="form-select TYPECONT has-value" data-bs-toggle="tooltip" title="ประเภทสัญญา" required>
                                                    <option value="" selected>--- เลือกประเภท ---</option>
                                                    <option value="HP" @selected($lastRequest["Track"]["Tab1"]["TYPECONT"] == 'HP')>1. สินเชื่อเช่าซื้อ (HP)</option>
                                                    <option value="PSL" @selected($lastRequest["Track"]["Tab1"]["TYPECONT"] == 'PSL')>2. สินเชื่อเงินกู้ (PSL)</option>
                                                </select>
                                            @else
                                                <select name="TYPECONT" class="form-select TYPECONT" data-bs-toggle="tooltip" title="ประเภทสัญญา" required>
                                                    <option value="" selected>--- เลือกประเภท ---</option>
                                                    <option value="HP">1. สินเชื่อเช่าซื้อ (HP)</option>
                                                    <option value="PSL">2. สินเชื่อเงินกู้ (PSL)</option>
                                                </select>
                                            @endif
                                            <span class="text-danger floating-label">ประเภทสัญญา</span>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6 col-lg-6 col-xl">
                                        <div class="input-bx">
                                            <input type="number" name="AMOUNT" min="1" class="form-control text-center" placeholder=" " value="{{@$lastRequest["Track"]["Tab1"]["AMOUNT"]}}" required>
                                            <span class="text-danger"><i class="bx bxs-grid-alt"></i> จำนวนกลุ่ม</span>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6 col-lg-6 col-xl">
                                        <div class="input-bx">
                                            <input type="number" min="0" step="0.01" name="F_PERIOD" class="form-control text-center" placeholder=" " value="{{@$lastRequest["Track"]["Tab1"]["F_PERIOD"]}}" required>
                                            <span class="text-danger"><i class="bx bx-label"></i> ค้างงวดที่</span>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-6 col-lg-6 col-xl">
                                        <div class="input-bx">
                                            <input type="number" min="0" step="0.01" name="T_PERIOD" class="form-control text-center" placeholder=" " value="{{@$lastRequest["Track"]["Tab1"]["T_PERIOD"]}}" required>
                                            <span class="text-danger"><i class="bx bx-label"></i> ถึงงวดที่</span>
                                        </div>
                                    </div>
                                    

                                </div>

                                <button type="button" class="btn btn-secondary waves-effect waves-light w-sm" id="ExcuteGroupingTrackBtn">
                                    <i class="mdi mdi-cog d-block font-size-16"></i>
                                    <span class="text-nowrap">จัดกลุ่ม</span>
                                </button>
                                <div class="vr"></div>
                                <button type="button" class="btn btn-outline-danger waves-effect waves-light w-sm" id="ResetGroupingTrackBtn" @disabled(@$groupTrack->count() == 0)>
                                    <i class="mdi mdi-undo-variant d-block font-size-16"></i>
                                    <span class="text-nowrap">รีเซ็ต</span>
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
                
            </div>
        </div>

        <h2 class="card-title">ดูผลการจัดกลุ่ม</h2>

        <!-- เนื้อหาตัวฟอร์ม -->
        <div id="track-result-grouping" class="mt-3">

            @if(@$groupTrack->count() == 0)
                <p class="text-muted">- ยังไม่มีการแบ่งกลุ่ม -</p>
            @endif

            @if(@$groupTrack->where('CODLOAN','2')->count() > 0)
                <a href="#collapseTrackTab1_HP" class="d-flex flex-row collapsed link-warning-darker" data-bs-toggle="collapse" role="button">
                    <span class="collapse-arrow-icon d-flex align-items-center me-2">
                        <i class="bx bx-caret-down font-size-14"></i>
                    </span>
                    <span>
                        สินเชื่อเช่าซื้อ (HP)
                    </span>
                    <span class="fw-bold font-size-12 mx-2">
                        {{@$groupTrack->where('CODLOAN','2')->groupBy('GroupingTemp')->count()}} กลุ่ม
                    </span>
                </a>
                <hr class="border mt-0">
                <div class="collapse" id="collapseTrackTab1_HP">
                    <div class="row row-cols-2 row-cols-md-2 row-cols-sm-3 row-cols-xl-4 g-4 mb-4">
                        @forEach(@$groupTrack->where('CODLOAN','2')->groupBy('GroupingTemp') as $group)
                            @php
                                $_locat = $group->first()->LOCAT;
                            @endphp
                            <div class="col">
                                <div class="card hover-up border m-0" data-bs-toggle="tooltip" data-bs-html="true" title='<div class="d-flex flex-column"><b class="text-start"><i class="bx bx-box fs-6 me-1"></i>
                                    กลุ่ม {{ $group->first()->GroupingTemp }}</b><span class="text-start text-danger"><i class="bx bx-error fs-6 me-1"></i>ค้าง
                                    {{ number_format($group->min('HLDNO'), 2) }} - {{ number_format($group->max('HLDNO'), 2) }}</span></div>'>
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium mb-2 fw-bold text-truncate">
                                                    งานตาม กลุ่มที่ {{ $group->first()->GroupingTemp }}
                                                </p>
                                                <h4 class="mb-0">{{@$group->count()}}</h4>
                                            </div>
                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm">
                                                    <span class="avatar-title rounded-circle bg-warning bg-opacity-25 text-dark font-size-16">
                                                        T{{ $group->first()->GroupingTemp }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(@$groupTrack->where('CODLOAN','1')->count() > 0)
                <a href="#collapseTrackTab1_PSL" class="d-flex flex-row collapsed link-warning-darker" data-bs-toggle="collapse" role="button">
                    <span class="collapse-arrow-icon d-flex align-items-center me-2">
                        <i class="bx bx-caret-down font-size-14"></i>
                    </span>
                    <span>
                        สินเชื่อเงินกู้ (PSL)
                    </span>
                    <span class="fw-bold font-size-12 mx-2">
                        {{@$groupTrack->where('CODLOAN','1')->groupBy('GroupingTemp')->count()}} กลุ่ม
                    </span>
                </a>
                <hr class="border mt-0">
                <div class="collapse" id="collapseTrackTab1_PSL">
                    <div class="row row-cols-2 row-cols-md-2 row-cols-sm-3 row-cols-xl-4 g-4 mb-4">
                        @forEach(@$groupTrack->where('CODLOAN','1')->groupBy('GroupingTemp') as $group)
                            @php
                                $_locat = $group->first()->LOCAT;
                            @endphp
                            <div class="col">
                                <div class="card hover-up border m-0" data-bs-toggle="tooltip" data-bs-html="true" title='<div class="d-flex flex-column"><b class="text-start"><i class="bx bx-box fs-6 me-1"></i>
                                    กลุ่ม {{ $group->first()->GroupingTemp }}</b><span class="text-start text-danger"><i class="bx bx-error fs-6 me-1"></i>ค้าง
                                    {{ number_format($group->min('HLDNO'), 2) }} - {{ number_format($group->max('HLDNO'), 2) }}</span></div>'>
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-grow-1">
                                                <p class="text-muted fw-medium mb-2 fw-bold text-truncate">
                                                    งานตาม กลุ่มที่ {{ $group->first()->GroupingTemp }}
                                                </p>
                                                <h4 class="mb-0">{{@$group->count()}}</h4>
                                            </div>
                                            <div class="flex-shrink-0 align-self-center">
                                                <div class="mini-stat-icon avatar-sm">
                                                    <span class="avatar-title rounded-circle bg-warning bg-opacity-25 text-dark font-size-16">
                                                        T{{ $group->first()->GroupingTemp }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
        
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            
        </div>

    </div>

    <!-- แท็บที่ 2 -->
    <div @class(['tab-pane fade', 'show active' => $activeTab["Track"] == 2]) id="track-tab-pane-2" role="tabpanel" aria-labelledby="track-tab-2" tabindex="0">

        <!-- เมนู หัวฟอร์ม -->
        <div class="card shadow-none border border-warning border-opacity-50 rounded-3">
            <div class="card-body bg-warning bg-soft text-dark">

                <div class="float-end">

                    <a class="btn btn-outline-secondary waves-effect waves-light w-sm modal_lg" data-link="{{ route('spast.edit', 0) }}?page=assign-all&type=T">
                        <i class="bx bx-layer font-size-16"></i>
                        <span class="text-nowrap">มอบหมายทั้งหมด</span>
                    </a>

                </div>

                <h4 class="card-title m-0">ขั้นที่ 2 กำหนดพนักงานเก็บเงิน</h4>
                <p class="card-title-desc m-0">เลือกพนักงานเก็บเงินที่รับผิดชอบในแต่ละกลุ่มลูกหนี้ สามารถมอบหมายโดยเลือกบันทึกตามกลุ่มย่อยได้ (ถ้ามี)</p>

            </div>
        </div>

        <h2 class="card-title d-none">ผลการจัดกลุ่ม</h2>

        <!-- เนื้อหาตัวฟอร์ม -->
        <div id="track-result-setbillcall" class="mt-3">

            @if(@$groupTrack->count() == 0)
                <p class="text-muted">- ยังไม่มีการแบ่งกลุ่ม -</p>
            @endif

            @if(@$groupTrack->where('CODLOAN','2')->count() > 0)
                @php
                    $_codloan = 2;
                @endphp
                <a href="#collapseTrackTab2_HP"
                    @isset($lastRequest["Track"]["Tab2"]["CODLOAN"])
                        @class(['d-flex flex-row link-warning-darker', 'collapsed' => $lastRequest["Track"]["Tab2"]["CODLOAN"] != '2'])
                    @else
                        class="d-flex flex-row link-warning-darker collapsed"
                    @endisset data-bs-toggle="collapse" role="button">
                    <span class="collapse-arrow-icon d-flex align-items-center me-2">
                        <i class="bx bx-caret-down font-size-14"></i>
                    </span>
                    <span>
                        สินเชื่อเช่าซื้อ (HP)
                    </span>
                    <span class="fw-bold font-size-12 mx-2">
                        {{@$groupTrack->where('CODLOAN','2')->groupBy('GroupingTemp')->count()}} กลุ่ม
                    </span>
                </a>
                <hr class="border mt-0">
                <div @class(['collapse', 'show' => @$lastRequest["Track"]["Tab2"]["CODLOAN"] == '2']) id="collapseTrackTab2_HP">
                    <div class="row row-cols-2 row-cols-md-2 row-cols-sm-3 row-cols-xl-4 g-4 mb-4">
                        @forEach(@$groupTrack->where('CODLOAN','2')->groupBy('GroupingTemp') as $group)
                            @php
                                $_groupingtemp = $group->first()->GroupingTemp;
                                $_groupingtype = $group->first()->GroupingType;
                                $progressbar = round($group->whereNotNull('FOLCODE')->count() / $group->count() * 100, 0);
                                //$progressbar = rand(0,100);
                            @endphp
                            <div class="col">

                                <div class="card border border-dark">
                                    <div class="text-uppercase" style="position: absolute; left: 1rem; top: 1rem;">
                                        <span class="badge rounded-pill badge-soft-dark font-size-11 text-dark">
                                            #{{ $_groupingtemp }}
                                        </span>
                                    </div>
                                    <div class="card-body p-3">
                                        
                                        <div class="d-flex justify-content-end mb-3">
                                            <a class="btn btn-secondary waves-effect waves-light data-modal-xl-2" data-link="{{ route('spast.edit', $_groupingtemp) }}?page=assign&type={{$_groupingtype}}&CODLOAN={{$_codloan}}">
                                                <i class="bx bx-log-in"></i> มอบหมาย
                                            </a>
                                        </div>
            
                                        <h4 class="card-title text-truncate">
                                            งานตาม กลุ่มที่ {{ $_groupingtemp }}
                                        </h4>
            
                                        <div @class(['progress progress-lg', 'border border-danger' => $progressbar == 0])>
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: {{$progressbar}}%;" aria-valuenow="{{$progressbar}}" aria-valuemin="0" aria-valuemax="100"><strong>{{$progressbar}}%</strong></div>
                                        </div>
            
                                    </div>
                                    <div class="card-footer p-2 d-flex justify-content-between text-muted">
                                        <small>
                                            T{{ $_groupingtemp }}
                                        </small>
                                        <small>
                                            จำนวน {{ number_format(@$group->count()) }} งาน
                                        </small>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(@$groupTrack->where('CODLOAN','1')->count() > 0)
                @php
                    $_codloan = 1;
                @endphp
                <a href="#collapseTrackTab2_PSL"
                    @isset($lastRequest["Track"]["Tab2"]["CODLOAN"])
                        @class(['d-flex flex-row link-warning-darker', 'collapsed' => $lastRequest["Track"]["Tab2"]["CODLOAN"] != '1'])
                    @else
                        class="d-flex flex-row link-warning-darker collapsed"
                    @endisset data-bs-toggle="collapse" role="button">
                    <span class="collapse-arrow-icon d-flex align-items-center me-2">
                        <i class="bx bx-caret-down font-size-14"></i>
                    </span>
                    <span>
                        สินเชื่อเงินกู้ (PSL)
                    </span>
                    <span class="fw-bold font-size-12 mx-2">
                        {{@$groupTrack->where('CODLOAN','1')->groupBy('GroupingTemp')->count()}} กลุ่ม
                    </span>
                </a>
                <hr class="border mt-0">
                <div @class(['collapse', 'show' => @$lastRequest["Track"]["Tab2"]["CODLOAN"] == '1']) id="collapseTrackTab2_PSL">
                    <div class="row row-cols-2 row-cols-md-2 row-cols-sm-3 row-cols-xl-4 g-4 mb-4">
                        @forEach(@$groupTrack->where('CODLOAN','1')->groupBy('GroupingTemp') as $group)
                            @php
                                $_groupingtemp = $group->first()->GroupingTemp;
                                $_groupingtype = $group->first()->GroupingType;
                                $progressbar = round($group->whereNotNull('FOLCODE')->count() / $group->count() * 100, 0);
                            @endphp
                            <div class="col">

                                <div class="card border border-dark">
                                    <div class="text-uppercase" style="position: absolute; left: 1rem; top: 1rem;">
                                        <span class="badge rounded-pill badge-soft-dark font-size-11 text-dark">
                                            #{{ $_groupingtemp }}
                                        </span>
                                    </div>
                                    <div class="card-body p-3">
            
                                        
                                        <div class="d-flex justify-content-end mb-3">
                                            <a class="btn btn-secondary waves-effect waves-light data-modal-xl-2" data-link="{{ route('spast.edit', $_groupingtemp) }}?page=assign&type={{$_groupingtype}}&CODLOAN={{$_codloan}}">
                                                <i class="bx bx-log-in"></i> มอบหมาย
                                            </a>
                                        </div>
            
                                        <h4 class="card-title text-truncate">
                                            งานตาม กลุ่มที่ {{ $_groupingtemp }}
                                        </h4>
            
                                        <div @class(['progress progress-lg', 'border border-danger' => $progressbar == 0])>
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: {{$progressbar}}%;" aria-valuenow="{{$progressbar}}" aria-valuemin="0" aria-valuemax="100"><strong>{{$progressbar}}%</strong></div>
                                        </div>
            
                                    </div>
                                    <div class="card-footer p-2 d-flex justify-content-between text-muted">
                                        <small>
                                            T{{ $_groupingtemp }}
                                        </small>
                                        <small>
                                            จำนวน {{ number_format(@$group->count()) }} งาน
                                        </small>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>

    </div>

    <!-- แท็บที่ 3 -->
    <div @class(['tab-pane fade', 'show active' => $activeTab["Track"] == 3]) id="track-tab-pane-3" role="tabpanel" aria-labelledby="track-tab-3" tabindex="0">

        <!-- เมนู หัวฟอร์ม -->
        <div @class(["card shadow-none border border-warning border-opacity-50 rounded-3",
        "d-none" => ( @$groupTrack->count() == @$groupTrack->whereNotNull('GroupingState')->count() ) ])>
            <div class="card-body bg-warning bg-soft text-dark">
                <h4 class="card-title m-0">ขั้นที่ 3 ตรวจสอบและยืนยันการแบ่งกลุ่ม</h4>
                <p class="card-title-desc m-0">ตรวจสอบและยืนยันการเปลี่ยนแปลงการแบ่งกลุ่มลูกหนี้ สามารถแก้ไขพนักงานเก็บเงินตามรายการที่ต้องการได้</p>
            </div>
        </div>

        <!-- เนื้อหาตัวฟอร์ม -->
        <div id="track-result-validate" class="mt-3">

            @if(@$groupTrack->count() <= 0)
                <p class="text-muted">- ยังไม่มีการแบ่งกลุ่ม -</p>
            @elseif( @$groupTrack->count() == @$groupTrack->whereNotNull('GroupingState')->count() )
                <!-- แบ่งทุกงานหมดแล้ว -->
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="d-flex align-items-center" style="position: absolute; left: 10%; right: 10%; top: 10%; bottom: 10%;">
                            <div class="alert alert-success m-0 h-auto" role="alert" style="--bs-alert-bg: #d6f3e9dd">
                                <h4 class="alert-heading fw-bolder">เสร็จแล้ว!</h4>
                                <p>คุณได้ทำการยืนยันการแบ่งงานเสร็จสิ้นแล้ว สามารถตรวจสอบรายการแบ่งงานที่แบ่งเสร็จแล้วในรายงานแบ่งกลุ่มลูกหนี้ตามประเภทการแบ่งงานได้ หากต้องการแก้ไขพนักงานเก็บเงินของสัญญาที่บันทึกแบ่งกลุ่มไปแล้ว ให้แก้ไขในในหน้าสัญญานั้น ๆ</p>
                                <hr class="border border-success border-opacity-10">
                                <p class="mb-0">หากมีปัญหาเรื่องการแบ่งงาน สามารถกดรีเซ็ตการแบ่งกลุ่มเพื่อเริ่มแบ่งงานใหม่อีกครั้ง หรือติดต่อโปรแกรมเมอร์</p>
                            </div>
                        </div>
                        <div class="maintenance-img">
                            <img src="{{ asset('assets/images/undraw/undraw_completing_re_i7ap.svg') }}" alt="" class="img-fluid mx-auto d-block" style="max-height: 300px;">
                        </div>
                    </div>
                </div>
            @else
                @if(@$groupTrack->where('CODLOAN','2')->whereNull('GroupingState')->whereNotNull('FOLCODE')->count() > 0)
                    <a href="#collapseTrackTab3_HP" class="d-flex flex-row link-warning-darker collapsed" data-bs-toggle="collapse" role="button">
                        <span class="collapse-arrow-icon d-flex align-items-center me-2">
                            <i class="bx bx-caret-down font-size-14"></i>
                        </span>
                        <span>
                            สินเชื่อเช่าซื้อ (HP)
                        </span>
                        <span class="fw-bold font-size-12 mx-2">
                            {{@$groupTrack->where('CODLOAN','2')->whereNull('GroupingState')->whereNotNull('FOLCODE')->groupBy('FOLCODE')->count()}} พนักงานเก็บเงิน
                        </span>
                    </a>
                    <hr class="border mt-0">
                    <div class="collapse ps-4" id="collapseTrackTab3_HP">
                        @forEach(@$groupTrack->where('CODLOAN','2')->whereNull('GroupingState')->whereNotNull('FOLCODE')->groupBy('FOLCODE') as $group)
                            @php
                                $_folcode = $group->first()->FOLCODE;
                            @endphp
                            <a href="#collapseTrackTab3_HP_BillColl_{{$_folcode}}" class="d-flex flex-row link-warning-darker collapsed" data-bs-toggle="collapse" role="button">
                                <span class="collapse-arrow-icon d-flex align-items-center me-2">
                                    <i class="bx bx-caret-down font-size-14"></i>
                                </span>
                                <span>
                                    <i class="fas fa-users"></i>
                                    {{ @$billcoll[$_folcode] }}
                                </span>
                                <span class="fw-bold font-size-12 mx-2">
                                    ({{@$group->count()}} รายการ)
                                </span>
                            </a>
                            <hr class="border mt-0 mb-2">
                            <div class="collapse mb-2" id="collapseTrackTab3_HP_BillColl_{{$_folcode}}">
                                <div class="no-scrollbar overflow-billcoll mb-2">
                                    <table class="table table-sm table-borderless m-0 text-center text-nowrap table-subgroup table-editbillcoll table-track-editbillcoll" data-editbillcoll="track">
                                        <thead class="table-light">
                                            <tr>
                                                <th></th>
                                                <th>#</th>
                                                <th>สาขา</th>
                                                <th>ประเภท</th>
                                                <th>เลขที่สัญญา</th>
                                                <th>ชื่อ-สกุล ลูกค้า</th>
                                                <th>ค้างจริง</th>
                                                <th>พนักงานขาย</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(@$group as $key => $row)
                                                <tr data-portid="{{$row->spast_id}}">
                                                    <td class="text-center">
                                                        <input type="checkbox" class="form-check" data-editbillcoll="track">
                                                    </td>
                                                    <th scope="row">{{@$key+1}}</th>
                                                    <td>
                                                        <h6 class="m-0"><span class="badge text-bg-primary" data-bs-toggle="tooltip" data-bs-title="{{@$row->branch_name}}">{{@$row->branch_code}}</span></h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0"><span class="badge text-bg-dark" data-bs-toggle="tooltip" data-bs-title="{{@$row->Loan_Name}}">{{@$row->TYPECONT}}</span></h6>
                                                    </td>
                                                    <td class="text-center">{{@$row->CONTNO}}</td>
                                                    <td>{{@$row->cus_name}}</td>
                                                    <td>{{number_format(@$row->HLDNO,2)}}</td>
                                                    <td>{{@$row->sale_name}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @elseif(@$groupTrack->where('CODLOAN','2')->whereNotNull('GroupingState')->count() > 0)

                    <div class="alert alert-success" role="alert">
                        <i class="fas fa-check-circle pe-2"></i>บันทึกยืนยันการแบ่งกลุ่ม <em>สินเชื่อเช่าซื้อ (HP)</em> ไปแล้ว <b>{{@$groupTrack->where('CODLOAN','2')->whereNotNull('GroupingState')->whereNotNull('FOLCODE')->groupBy('FOLCODE')->count()}} พนักงานเก็บเงิน</b>
                    </div>

                @endif

                @if(@$groupTrack->where('CODLOAN','1')->whereNull('GroupingState')->whereNotNull('FOLCODE')->count() > 0)
                    <a href="#collapseTrackTab3_PSL" class="d-flex flex-row link-warning-darker collapsed" data-bs-toggle="collapse" role="button">
                        <span class="collapse-arrow-icon d-flex align-items-center me-2">
                            <i class="bx bx-caret-down font-size-14"></i>
                        </span>
                        <span>
                            สินเชื่อเงินกู้ (PSL)
                        </span>
                        <span class="fw-bold font-size-12 mx-2">
                            {{@$groupTrack->where('CODLOAN','1')->whereNull('GroupingState')->whereNotNull('FOLCODE')->groupBy('FOLCODE')->count()}} พนักงานเก็บเงิน
                        </span>
                    </a>
                    <hr class="border mt-0">
                    <div class="collapse ps-4" id="collapseTrackTab3_PSL">
                        @forEach(@$groupTrack->where('CODLOAN','1')->whereNull('GroupingState')->whereNotNull('FOLCODE')->groupBy('FOLCODE') as $group)
                            @php
                                $_folcode = $group->first()->FOLCODE;
                            @endphp
                            <a href="#collapseTrackTab3_PSL_BillColl_{{$_folcode}}" class="d-flex flex-row link-warning-darker collapsed" data-bs-toggle="collapse" role="button">
                                <span class="collapse-arrow-icon d-flex align-items-center me-2">
                                    <i class="bx bx-caret-down font-size-14"></i>
                                </span>
                                <span>
                                    <i class="fas fa-users"></i>
                                    {{ @$billcoll[$_folcode] }}
                                </span>
                                <span class="fw-bold font-size-12 mx-2">
                                    ({{@$group->count()}} รายการ)
                                </span>
                            </a>
                            <hr class="border mt-0 mb-2">
                            <div class="collapse mb-2" id="collapseTrackTab3_PSL_BillColl_{{$_folcode}}">
                                <div class="no-scrollbar overflow-billcoll mb-2">
                                    <table class="table table-sm table-borderless m-0 text-center text-nowrap table-subgroup table-editbillcoll table-track-editbillcoll" data-editbillcoll="track">
                                        <thead class="table-light">
                                            <tr>
                                                <th></th>
                                                <th>#</th>
                                                <th>สาขา</th>
                                                <th>ประเภท</th>
                                                <th>เลขที่สัญญา</th>
                                                <th>ชื่อ-สกุล ลูกค้า</th>
                                                <th>ค้างจริง</th>
                                                <th>พนักงานขาย</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(@$group as $key => $row)
                                                <tr data-portid="{{$row->spast_id}}">
                                                    <td class="text-center">
                                                        <input type="checkbox" class="form-check" data-editbillcoll="track">
                                                    </td>
                                                    <th scope="row">{{@$key+1}}</th>
                                                    <td>
                                                        <h6 class="m-0"><span class="badge text-bg-primary" data-bs-toggle="tooltip" data-bs-title="{{@$row->branch_name}}">{{@$row->branch_code}}</span></h6>
                                                    </td>
                                                    <td>
                                                        <h6 class="m-0"><span class="badge text-bg-dark" data-bs-toggle="tooltip" data-bs-title="{{@$row->Loan_Name}}">{{@$row->TYPECONT}}</span></h6>
                                                    </td>
                                                    <td class="text-center">{{@$row->CONTNO}}</td>
                                                    <td>{{@$row->cus_name}}</td>
                                                    <td>{{number_format(@$row->HLDNO,2)}}</td>
                                                    <td>{{@$row->sale_name}}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @elseif(@$groupTrack->where('CODLOAN','1')->whereNotNull('GroupingState')->count() > 0)

                    <div class="alert alert-success" role="alert">
                        <i class="fas fa-check-circle pe-2"></i>บันทึกยืนยันการแบ่งกลุ่ม <em>สินเชื่อเงินกู้ (PSL)</em> ไปแล้ว <b>{{@$groupTrack->where('CODLOAN','1')->whereNotNull('GroupingState')->whereNotNull('FOLCODE')->groupBy('FOLCODE')->count()}} พนักงานเก็บเงิน</b>
                    </div>

                @endif

                @if(@$groupTrack->whereNull('GroupingState')->count() > 0)
                    <div class="mt-5 d-flex justify-content-end">
                        <button type="button" class="btn btn-success waves-effect waves-light w-sm" id="ConfirmTrackBtn">
                            <i class="mdi mdi-content-save d-block font-size-16"></i>
                            <span class="text-nowrap">ยืนยัน</span>
                        </button>
                    </div>
                @endif
            @endif

            

        </div>

        <div class="sliding-edit-billcoll-panel bg-light bg-gradient border border-secondary border-opacity-50 shadow-lg" id="EditBillColl_Track_Panel" data-editbillcoll="track">

            <div class="edit-billcoll-panel-content">

                <div class="card-header m-0 bg-secondary bg-gradient border-bottom border-secondary border-opacity-10 d-flex flex-row justify-content-between align-items-center">
                    <span class="h6 m-0 fw-bold text-light">
                        <i class="fas fa-user-edit pe-2"></i>แก้ไขพนักงานเก็บเงิน <span class="count-billcoll-hold"></span>
                    </span>
                    <div class="btn btn-sm btn-dark position-relative editBillCollToggleBtn" id="EditBillColl_Track_ToggleBtn" data-target="#EditBillColl_Track_Panel">
                        <i class="mdi mdi-arrow-expand-up font-size-13 toggle-billcoll-btn-icon"></i>

                        
                        <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger rounded-circle noti-dot" style="display: none;">
                            <span class="visually-hidden">notification</span>
                        </span>
                        

                    </div>
                </div>

                <div class="d-flex flex-row justify-content-between align-items-center p-2 ps-3 bg-dark bg-opacity-10">
                    <span class="text-muted">เลือกอยู่ <span class="fw-bold selectedCount">0</span> รายการ</span>
                    <button class="btn btn-sm btn-warning d-flex align-items-center clearAll-track-billcoll-item-Btn">
                        <i class="fas fa-broom"></i> ล้างทั้งหมด
                    </button>
                </div>

                <!-- Example of selected item -->
                <div class="edit-billcoll-itemselected exampleItem d-none">
                    <input type="hidden" name="id" value="">
                    <span class="fw-bold mx-auto" data-bs-toggle="tooltip" title="Tooltip Example">Item Name</span>
                    <button class="btn btn-sm btn-danger d-flex align-items-center remove-billcoll-item-btn">
                        <i class="fas fa-times d-flex"></i>
                    </button>
                </div>
                
                <div class="edit-billcoll-itemlist">
                    <div class="text-center p-4 text-muted placeholder-message">ยังไม่ได้เลือกรายการ</div>
                </div>
                <div class="p-2 bg-light bg-opacity-10 border-top border-secondary border-opacity-10 row g-0 m-0 justify-content-end align-items-end">
                    <div class="col col-sm m-0">
                        <select class="form-select billcoll-select border-warning" id="EditPort_Track_BILLCOLL" name="BILLCOLL" data-placeholder="กำหนดพนักงานเก็บเงิน">
                            <option value="" selected>-- กำหนดพนักงานเก็บเงิน --</option>
                            @foreach($billcoll as $i => $value)
                                <option value="{{$i}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-auto m-0 ms-2">
                        <button type="button" class="btn btn-outline-success btnEditBillCollPort" id="EditBillcollPort_Track_SaveBtn" data-editbillcoll="track">
                            <i class="fas fa-save"></i><span class="addSpin"></span>
                        </button>
                    </div>
                </div>

            </div>
            
        </div>

    </div>
    

</div>

<!-- สคริปต์จัดการเรื่อง Tab -->
<script>
    document.querySelectorAll('#TrackTabList button[data-bs-toggle="pill"]').forEach(function(buttonElement) {
        buttonElement.addEventListener('hide.bs.tab', function (e) {
            /*
            var buttonNewTab = e.relatedTarget
            $(buttonNewTab).addClass("preactive-tab");
            */
        });

        buttonElement.addEventListener('show.bs.tab', function (e) {
            var buttonNewTab = e.target;
            //console.log( "กำลังเปิดแท็บที่: " + $(buttonNewTab).data("tabnumber") );
            var newTab_index = parseInt($(buttonNewTab).data("tabnumber"));
            var next_unlock = checkTrackTabUnlock(newTab_index);
            if (next_unlock == false) {
                swal.fire({
                    icon : 'warning',
                    title : 'ขออภัย',
                    text : 'กรุณาดำเนินการตามขั้นตอน',
                    timer: 2000,
                    confirmButtonText: "เข้าใจแล้ว",
                });
                e.preventDefault();
                return;
            }
            var buttonOldTab = e.relatedTarget
            $(buttonOldTab).removeClass("preactive-tab");
            $(buttonNewTab).addClass("preactive-tab");
            refreshTrackTabStep();
            //e.preventDefault(); // ยกเลิกการเปลี่ยนแท็บหากเงื่อนไขไม่ถูกต้อง
        });

    });

    var MAX_TRACK_TAB = 3

    function refreshTrackTabStep() {
        $('#TrackTabList button[data-bs-toggle="pill"]').removeClass("btn-warning btn-secondary");
        //--------------------------------------------------------------------------------
        var found_active = false;
        var count_step = 0;
        var active_step = 0;
        $('#TrackTabList button[data-bs-toggle="pill"]').each(function(i, obj) {
            $(obj).removeClass("btn-warning btn-secondary");
            $(obj).find(".label-tabbtn").removeClass("text-dark text-secondary");
            //-------------------------------------------
            if (found_active == true) {
                $(obj).addClass("btn-secondary");
                $(obj).find(".label-tabbtn").addClass("text-secondary");
            } else {
                $(obj).addClass("btn-warning");
                $(obj).find(".label-tabbtn").addClass("text-dark");
            }
            count_step += 1;
            //-------------------------------------------
            // ! เนื่องจากเช็คด้วย class active ไม่ได้ จึงเช็คด้วย class preactive-tab แทน
            // เนื่องจาก class active ถูกเพิ่มทีหลังจาก Event นี้เกิด
            if ( obj.classList.contains("preactive-tab") ) {
                found_active = true;
                active_step = count_step;
            }
        });
        var progressBarWidth = ((active_step - 1) / (MAX_TRACK_TAB - 1)) * 100;
        $("#track_progress .progress-bar").width(progressBarWidth+"%");
        //--------------------------------------------------------------------------------
        // เอาที่ส่องแสงในปุ่ม Next ออก
        $("#TrackTabHelp_Next").removeClass("glow-secondary");
        refreshTrackTabHelpBtn(active_step);
    }

    function refreshTrackTabHelpBtn(active_step) {
        $("#TrackTabHelp_Prev,#TrackTabHelp_Next").removeClass("disabled");
        if (active_step == 1) {
            // First Step
            $("#TrackTabHelp_Prev").addClass("disabled");
        } else {
            var next_unlock = checkTrackTabUnlock(active_step+1);
            if (next_unlock == false) {
                $("#TrackTabHelp_Next").addClass("disabled");
            }
        }
        if (active_step == MAX_TRACK_TAB) {
            // Final Step
            $("#TrackTabHelp_Next").addClass("disabled");
        }
    }

    function checkTrackTabUnlock(tab) {
        var unlock = $(`input[name="UnlockTrackTab${tab}"]`).val();
        return unlock == 1;
    }

    function getTrackTabActive() {
        return parseInt( $("#TrackTabList button.active").data("tabnumber") );
    }

    // สคริปต์ปุ่มถัดไป / ก่อนหน้า
    function TrackTabPrevBtnClicked() {
        var current_tab = getTrackTabActive();
        $(`#track-tab-${current_tab-1}`).click();
    }
    function TrackTabNextBtnClicked() {
        var current_tab = getTrackTabActive();
        $(`#track-tab-${current_tab+1}`).click();
    }

    // Refresh ปุ่ม Help เมื่อเริ่มต้น
    refreshTrackTabHelpBtn( getTrackTabActive() );

</script>

<!-- P1 ปุ่มจัดกลุ่มใหม่ -->
<script>

    var have_track_group_HP = false;
    var have_track_group_PSL = false;
    @if(@$groupTrack->where('CODLOAN','2')->count() > 0)
        have_track_group_HP = true;
    @endif
    @if(@$groupTrack->where('CODLOAN','1')->count() > 0)
        have_track_group_PSL = true;
    @endif

    $("#ExcuteGroupingTrackBtn").click(function(){
        var data = {};$("#grouping-track").serializeArray().map(function(x){data[x.name] = x.value;});
        if ($("#grouping-track").valid() == true) {
            
            var _typecont = $("#grouping-track .TYPECONT").val();
            if ( (have_track_group_HP == true && _typecont == 'HP') || (have_track_group_PSL == true && _typecont == 'PSL') ) {
                Swal.fire({
                    title: 'มีการจัดกลุ่มอยู่แล้ว',
                    text: "จะแบ่งกลุ่มเพิ่มเฉพาะรายการที่ยังไม่ได้แบ่งกลุ่ม",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'ใช่ จัดกลุ่มเพิ่ม',
                    cancelButtonText: 'เดี๋ยวก่อน', 
                    footer: '<p class="m-0 text-muted d-flex justify-content-center align-items-center">กลุ่มที่ถูกจัดเพิ่มจะกลายเป็น<span class="fw-bold d-flex align-items-center"><i class="mdi mdi-sticker-plus-outline fs-5 mx-2"></i>กลุ่มใหม่</span></p><p class="m-0 text-muted d-flex justify-content-center align-items-center">หากต้องการแบ่งกลุ่มใหม่ทั้งหมดให้กด<span class="fw-bold text-danger d-flex align-items-center"><i class="mdi mdi-undo-variant fs-5 mx-2"></i>รีเซ็ต</span></p>',
                }).then((result) => {
                    if (result.isConfirmed) {
                        AjaxRequestGroupingTrack(true);
                    }
                });
            } else {
                // * แบ่งกลุ่ม
                AjaxRequestGroupingTrack(false);
            }
        }
        else{
            swal.fire({
                icon : 'warning',
                title : 'ข้อมูลไม่ครบ !',
                text : 'กรุณากรอกข้อมูลให้ครบถ้วน',
                timer: 2000,
                showConfirmButton: false,
            });
        }
    });

    
    function AjaxRequestGroupingTrack(groupingStack = false) {

        $("#grouping-track input[name='groupingStack']").val(groupingStack);

        $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
        $("#ExcuteGroupingTrackBtn i").addClass('mdi-spin');
        $.ajax({
            url: "{{ route('spast.update', 0) }}",
            type: 'POST',
            data: $('#grouping-track').serialize(),
            complete: function(data) {
                $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                $("#ExcuteGroupingTrackBtn i").removeClass('mdi-spin');
            },
            success: function(result) {
                swal.fire({
                    icon : 'success',
                    title : 'แบ่งกลุ่มสำเร็จ',
                    timer: 5000,
                    showConfirmButton: true,
                });
                $("#track-tabContent").html(result.html);
            },
            error: function(xhr, status, error) {
                // Get the error message from the response
                var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : "ข้อผิดพลาดที่ไม่รู้จัก :'(";
                var errorFile = xhr.responseJSON.file ? xhr.responseJSON.file : '';
                errorFile = errorFile.replace(/^.*[\\\/]/, '');
                var errorLine = xhr.responseJSON.line ? xhr.responseJSON.line : '';
                var errorHtml = "<p>" + errorMessage +"</p>";
                errorHtml += "<p class='m-0 small'>" + errorFile + " <strong>(บรรทัดที่ " + errorLine + ")</strong></p>";
                // Display the error message using SweetAlert2
                Swal.fire({
                    icon: 'error',
                    title: error,
                    html: `<p class="m-0">ขออภัย! เกิดข้อผิดพลาด กดดูเพิ่มเติมเพื่อแสดงรายละเอียด</p><p class="my-1 small">(${status})</p>`,
                    showCancelButton: true,
                    confirmButtonText: 'ดูเพิ่มเติม',
                    cancelButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If the user clicks "More Details," show the detailed error message in a new SweetAlert2 modal
                        Swal.fire({
                            icon: 'error',
                            title: 'รายละเอียด',
                            //text: errorMessage,
                            html: errorHtml,
                            confirmButtonText: 'OK'
                        });
                    }
                });
            }
        });
    }
    
</script>

<!-- P1 ปุ่มรีเซ็ตกลุ่ม -->
<script>
    $("#ResetGroupingTrackBtn").click(function(){

        Swal.fire({
            title: 'รีเซ็ตการแบ่งกลุ่ม',
            text: "จะล้างการแบ่งกลุ่มและการแบ่งงานทั้งหมด",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่ รีเซ็ต',
            cancelButtonText: 'เดี๋ยวก่อน',
        }).then((result) => {
            if (result.isConfirmed) {
                $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
                $.ajax({
                    url : "{{ route('spast.update',0) }}",
                    type : 'POST',
                    data :  {
                        _method: 'PUT',
                        page: 'task',
                        mode: 'track',
                        func: 'reset',
                        _token : '{{ @CSRF_TOKEN() }}'
                    },
                    complete: function(data) {
                        $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                    },
                    success : function(result) {
                        swal.fire({
                            icon : 'success',
                            title : 'รีเซ็ตการแบ่งกลุ่มสำเร็จ',
                            timer: 5000,
                            showConfirmButton: true,
                        });
                        $("#track-tabContent").html(result.html);
                    },
                    error : (err)=> {
                        swal.fire({
                            icon : 'error',
                            text : 'รีเซ็ตการแบ่งกลุ่มไม่สำเร็จ',
                        })
                    }
                });
            }
        });

    });
</script>

<!-- P3 -->
<script>
    $(document).ready(function() {
        // ปุ่มเปิด Panel Edit BillColl
        $('#EditBillColl_Track_ToggleBtn').on('click', function() {
            var target = $(this).data('target');
            $(`${target}`).toggleClass('open');
            $(this).find('.noti-dot').hide();
            $(this).removeClass("glow-danger");
        });
        // คลิกแถวแล้ว CheckBox
        $('.table-track-editbillcoll tr').click(function(event) {
            if (event.target.type !== 'checkbox') {
                $(':checkbox', this).trigger('click');
            }
        });
        // CheckBox แล้วไฮไลท์แถว
        $(".table-track-editbillcoll tr input[type='checkbox']").change(function (e) {
            if ($(this).is(":checked")) { //If the checkbox is checked
                //Add class on checkbox checked
                $(this).closest('tr').addClass("table-active");

                var typeeditbillcoll = $(this).data('editbillcoll');
                var portid = $(this).closest('tr').data('portid');

                var contno = $(this).closest('tr').find('td:eq(3)').html();
                var cus_name = $(this).closest('tr').find('td:eq(4)').html();

                var text_display = `${contno}`;
                var tooltip = `${cus_name}`;

                addEditBillCollPortItem(typeeditbillcoll, portid, text_display, tooltip);

            } else {
                //Remove class on checkbox uncheck
                $(this).closest('tr').removeClass("table-active");

                var typeeditbillcoll = $(this).data('editbillcoll');
                var portid = $(this).closest('tr').data('portid');
                removeEditBillCollPortItem(typeeditbillcoll, portid);

            }
            
        });
        // ปุ่มล้างทั้งหมด
        $(".clearAll-track-billcoll-item-Btn").on('click', function() {
            $(this).parent().siblings(".edit-billcoll-itemlist").find(".remove-billcoll-item-btn").click();
        });
        // ปุ่มบันทึก
        $("#EditBillcollPort_Track_SaveBtn").on('click', function() {
            var typeport = $(this).data('editbillcoll');
            //--------------------------------------------------------
            var panel = null;
            var portid = [];
            var port_help = [];
            if (typeport == 'track') {
                panel = $("#EditBillColl_Track_Panel");
            }
            var itemlist = $(panel).find(".edit-billcoll-panel-content .edit-billcoll-itemlist");
            $(itemlist).find('input[name="id"]').each(function() {
                portid.push($(this).val());
                var span = $(this).siblings('span');
                port_help.push(`${$(span).html()} - ${$(span).data('tooltiptext')}`)
            });
            if (portid.length == 0) {
                Swal.fire({
                    title: "กรุณาตรวจสอบ",
                    icon: "warning",
                    text: `ยังไม่ได้เลือกสัญญาที่จะแก้ไขเลย`,
                    confirmButtonText: 'เข้าใจแล้ว',
                });
                return;
            }
            //--------------------------------------------------------
            var select_billcoll = '';
            var select_billcoll_display = '';
            if (typeport == 'track') {
                select_billcoll = $(`#EditPort_Track_BILLCOLL`).val();
                select_billcoll_display = $(`#EditPort_Track_BILLCOLL option:selected`).text();
            }
            //--------------------------------------------------------
            if (select_billcoll == '') {
                Swal.fire({
                    title: "กรุณาตรวจสอบ",
                    icon: "warning",
                    text: `กรุณาเลือกพนักงานเก็บเงินก่อน`,
                    confirmButtonText: 'เข้าใจแล้ว',
                });
                return;
            }
            //--------------------------------------------------------
            let contrainerHtml = "<div class='input-invalid-alert text-info fw-bold overflow-auto font-size-13 bg-info bg-opacity-10 rounded-1 py-2' style='max-height:10rem; scrollbar-width: thin;'>" + port_help.join('<br>') + `</div><p class='my-2'>พนักงานเก็บเงิน: <mark>${select_billcoll_display}</mark></p>`;
            Swal.fire({
                title: "แก้ไขพนักงานเก็บเงิน",
                icon: "question",
                html: contrainerHtml, //port_help.join('<br>'),
                showCancelButton: true,
                confirmButtonColor: '#34c38f',
                cancelButtonColor: '#d33',
                confirmButtonText: 'ใช่ บันทึก',
                cancelButtonText: 'เดี๋ยวก่อน', 
            }).then((result) => {
                if (result.isConfirmed) {
                    $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
                    $.ajax({
                        url : "{{ route('spast.update',0) }}",
                        type : 'POST',
                        data :  {
                            _method: 'PUT',
                            page: 'task',
                            mode: 'track',
                            func: 'billcoll',
                            _token : '{{ @CSRF_TOKEN() }}',
                            data: {
                                CODLOAN: '{{@$CODLOAN}}',
                                BILLCOLL: select_billcoll,
                                A_SPASTID: portid,
                            },
                        },
                        complete: function(data) {
                            $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                        },
                        success : function(result) {
                            swal.fire({
                                icon : 'success',
                                title : 'แก้ไขพนักงานเก็บเงินสำเร็จ',
                                showConfirmButton: true,
                                confirmButtonText: 'เข้าใจแล้ว',
                            }).then(() => {
                                $("#track-tabContent").html(result.html);
                            });
                        },
                        error : (err)=> {
                            swal.fire({
                                icon : 'error',
                                text : 'แก้ไขพนักงานเก็บเงินไม่สำเร็จ',
                            })
                        }
                    });
                }
            });
        });
        
    });

</script>

<!-- P3 ยืนยันการบันทึก -->
<script>
    $("#ConfirmTrackBtn").click(function(){

        Swal.fire({
            title: 'บันทึกยืนยันการแบ่งกลุ่ม',
            text: "จะยืนยันการแบ่งกลุ่มที่แสดงทั้งหมด",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่ ยืนยัน',
            cancelButtonText: 'เดี๋ยวก่อน', 
        }).then((result) => {
            if (result.isConfirmed) {
                $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
                $.ajax({
                    url : "{{ route('spast.update',0) }}",
                    type : 'POST',
                    data :  {
                        _method: 'PUT',
                        page: 'task',
                        mode: 'track',
                        func: 'confirm',
                        _token : '{{ @CSRF_TOKEN() }}'
                    },
                    complete: function(data) {
                        $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                    },
                    success : function(result) {
                        swal.fire({
                            icon : 'success',
                            title : 'ยืนยันการแบ่งกลุ่มสำเร็จ',
                            showConfirmButton: true,
                            confirmButtonText: 'เข้าใจแล้ว',
                        }).then(() => {
                            $("#track-tabContent").html(result.html);
                        });
                    },
                    error : (err)=> {
                        swal.fire({
                            icon : 'error',
                            text : 'ยืนยันการแบ่งกลุ่มไม่สำเร็จ',
                        })
                    }
                });
            }
        });

    });
</script>

<script src="{{ URL::asset('assets/js/input-bx-select.js') }}"></script>

<script>
    $(document).ready(function(){
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>