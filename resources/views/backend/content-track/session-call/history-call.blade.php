@include('components.content-toast.view-toast')
<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>
<script src="{{ URL::asset('/assets/js/bootstrap-dialog.min.js')}}"></script>

<div class="modal-content">
    <div class="modal-header" id="Modal-drag" style="cursor:move;">
        <div class="flex-shrink-0 me-2">
            <img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h4 class="text-primary fw-semibold placeholder-glow d-block d-sm-none">ประวัติการ</h4>
            <h4 class="text-primary fw-semibold placeholder-glow d-none d-sm-block">ประวัติการบันทึก</h4>
            <p class="text-muted mt-n1 placeholder-glow">{{@$contract->CONTNO}}</p>
        </div>
        <button type="button" class="btn btn-danger " title="ปิด POP-UP" data-bs-dismiss="modal" aria-label="Close">
            ปิด
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-12">
                <div data-simplebar="init" style="max-height: 560px;">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs nav-tabs-custom justify-content-center pt-2 mt-n3" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" data-bs-toggle="tab" href="#all-post" role="tab" aria-selected="true">
                                            ตามเดือน
                                        </a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" data-bs-toggle="tab" href="#archive" role="tab" aria-selected="false" tabindex="-1">
                                            ทั้งหมด  
                                        </a>
                                    </li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content p-4">
                                    <div class="tab-pane active show" id="all-post" role="tabpanel">
                                        <div>
                                            <div class="col-xl-12">
                                                <!-- <div class="card"> -->
                                                    <div class="accordion" id="accordionExample">
                                                        @if(count(@$data) > 0)
                                                            @foreach( @$data as $i => $value)
                                                                <div class="accordion mb-1" id="accordionPanelsStayOpenExample">
                                                                    <div class="accordion-item">
                                                                        <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                                                            <button class="accordion-button border {{auth()->user()->id != $value->USERID?'border-warning':''}} border-2 bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#CuasTag-{{$i}}" aria-expanded="false" aria-controls="CuasTag-{{$i}}">
                                                                                <div class="flex-shrink-0 me-3">
                                                                                    <!-- <img src="{{ asset('assets/images/gif/avatar.gif') }}" alt="" class="avatar-sm" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-html="true" title="ผู้บันทึก : {{@$value->ToUsername->name}}"> -->
                                                                                    @if(@$value->STATUS <> "" or @$value->RESULT <> "")
                                                                                        <i class="bx bxs-user text-warning"></i>
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
                                                        @endif
                                                    </div>
                                                <!-- </div> -->
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="archive" role="tabpanel">
                                        <div>
                                            <!-- <div class="row justify-content-center"> -->
                                                <div class="col-xl-12">
                                                    @if(count(@$dataALL) > 0)
                                                        @foreach(@$dataALL as $key => $all)
                                                            <div class="{{@$key == 0?'':'mt-4'}}">
                                                                <div class="d-flex flex-wrap">
                                                                    <div class="me-2">
                                                                        <!-- <h4 class="font-size-14">{{@$all->INPUT_MONTH}}</h4> -->
                                                                    </div>
                                                                    <div class="ms-auto">
                                                                        <span class="badge badge-soft-success badge-pill float-end ms-1 font-size-12">{{@$all->INPUT_YEAR}}</span><span class="badge badge-soft-primary badge-pill float-end ms-1 font-size-12">{{@$all->INPUT_MONTH}}</span>
                                                                    </div>
                                                                </div>
                                                                @php 
                                                                    if(@$loanType == 1){
                                                                        @$data = \App\Models\TB_PatchContracts\TB_InsideTrackings\PatchPSL\PatchPSL_SPASTDUE_DETAIL::where('CONTNO',@$contract->CONTNO)->where('INPUT_MONTH',@$all->INPUT_MONTH)->orderBy('id','desc')->get();

                                                                    }
                                                                    else{
                                                                        @$data = \App\Models\TB_PatchContracts\TB_InsideTrackings\PatchHP\PatchHP_SPASTDUE_DETAIL::where('CONTNO',@$contract->CONTNO)->where('INPUT_MONTH',@$all->INPUT_MONTH)->orderBy('id','desc')->get();
                                                                    }
                                                                @endphp

                                                                <div class="list-group list-group-flush">
                                                                    @foreach(@$data as $value)
                                                                        <!-- <a href="blog-details.html" class="list-group-item text-muted"><i class="mdi mdi-circle-medium me-1"></i> Beautiful Day with Friends</a> -->
                                                                        <div class="accordion mb-1" id="accordionPanelsStayOpenExample">
                                                                            <div class="accordion-item">
                                                                                <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                                                                    <button class="accordion-button border {{auth()->user()->id != $value->USERID?'border-warning':''}} border-2 bg-white collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#CuasTag-{{$value->id}}" aria-expanded="false" aria-controls="CuasTag-{{$value->id}}">
                                                                                        <div class="flex-shrink-0 me-3">
                                                                                            <!-- <img src="{{ asset('assets/images/gif/avatar.gif') }}" alt="" class="avatar-sm" data-bs-toggle="tooltip" data-bs-placement="left" data-bs-html="true" title="ผู้บันทึก : {{@$value->ToUsername->name}}"> -->
                                                                                            @if(@$value->STATUS <> "" or @$value->RESULT <> "")
                                                                                                <i class="bx bxs-user text-warning"></i>
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
                                                                                <div id="CuasTag-{{$value->id}}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-headingOne" style="">
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
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    @else 
                                                        <div class="maintenance-img content-image mt-5" style="opacity: 0.2;">
                                                            <img src="{{ URL::asset('assets/images/undraw/undraw_selecting_team_re_ndkb.svg') }}" alt="" class="img-fluid mx-auto d-block" style="max-height: 40vh;">
                                                        </div>
                                                    @endif

                                                    <!-- <div class="mt-5">
                                                        <div class="d-flex flex-wrap">
                                                            <div class="me-2">
                                                                <h4>2019</h4>
                                                            </div>
                                                            <div class="ms-auto">
                                                                <span class="badge badge-soft-success badge-pill float-end ms-1 font-size-12">06</span>
                                                            </div>
                                                        </div>
                                                        <hr class="mt-2">

                                                        <div class="list-group list-group-flush">
                                                            <a href="blog-details.html" class="list-group-item text-muted"><i class="mdi mdi-circle-medium me-1"></i> Coffee with Friends</a>
                                                            
                                                            <a href="blog-details.html" class="list-group-item text-muted"><i class="mdi mdi-circle-medium me-1"></i> Neque porro quisquam est</a>
                                                            
                                                            <a href="blog-details.html" class="list-group-item text-muted"><i class="mdi mdi-circle-medium me-1"></i> Quis autem vel eum iure</a>

                                                            <a href="blog-details.html" class="list-group-item text-muted"><i class="mdi mdi-circle-medium me-1"></i> Cras mi eu turpis</a>
                                                            
                                                            <a href="blog-details.html" class="list-group-item text-muted"><i class="mdi mdi-circle-medium me-1"></i> Drawing a sketch</a>
                                                            
                                                            <a href="blog-details.html" class="list-group-item text-muted"><i class="mdi mdi-circle-medium me-1"></i> Project discussion with team</a>
                                                            
                                                        </div>
                                                    </div>

                                                    <div class="mt-5">
                                                        <div class="d-flex flex-wrap">
                                                            <div class="me-2">
                                                                <h4>2018</h4>
                                                            </div>
                                                            <div class="ms-auto">
                                                                <span class="badge badge-soft-success badge-pill float-end ms-1 font-size-12">03</span>
                                                            </div>
                                                        </div>
                                                        <hr class="mt-2">

                                                        <div class="list-group list-group-flush">
                                                            <a href="blog-details.html" class="list-group-item text-muted"><i class="mdi mdi-circle-medium me-1"></i> Beautiful Day with Friends</a>
                                                            
                                                            <a href="blog-details.html" class="list-group-item text-muted"><i class="mdi mdi-circle-medium me-1"></i> Drawing a sketch</a>
                                                            
                                                            <a href="blog-details.html" class="list-group-item text-muted"><i class="mdi mdi-circle-medium me-1"></i> Project discussion with team</a>
                                                            
                                                        </div>
                                                    </div> -->
                                                </div>
                                            <!-- </div> -->
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

<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>