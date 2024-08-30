<div class="container">
    <div class="row g-2">
        <div class="col-xl-4 col-lg-12 col-md-12 col-sm-12">
            <div class="card overflow-hidden shadow-sm rounded-4 h-100">
                <div class="bg-info bg-soft">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary p-3">
                                {{-- <h5 class="text-primary">Welcome Back !</h5> --}}
                            </div>
                        </div>
                        <div class="col-5 align-self-end">
                            <img src="{{ URL::asset('/assets/images/profile-img.png') }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="avatar-md profile-user-wid mb-4">
                                <img id="" src="{{ isset($data['data']->image_cus) ? URL::asset(@$data['data']->image_cus) : asset('/assets/images/users/user-1.png') }}" style="width: 100px; height: 100px;" class="img-thumbnail rounded-circle hover-up mb-2 boreder-img" alt="User-Profile-Image">
                            </div>
                        </div>

                        <div class="col-sm-8 text-end">
                            <div class="mt-2">
                                <div class="">
                                    <a href="{{ route('cus.index') }}?page={{'profile-cus'}}&id={{ @$data['data']->id }}" target="_blank" class="btn btn-primary waves-effect waves-light btn-sm  rounded-pill" type="button">ดูโปรไฟล์ <i class="mdi mdi-arrow-right ms-1"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h4 class="card-title text-muted mb-3">ข้อมูลทั่วไป (Personal Information)</h4>
                        <div data-simplebar="init" style="cursor: pointer;"><div class="simplebar-wrapper" style="margin: 0px;"><div class="simplebar-height-auto-observer-wrapper"><div class="simplebar-height-auto-observer"></div></div><div class="simplebar-mask"><div class="simplebar-offset" style="right: 0px; bottom: 0px;"><div class="simplebar-content-wrapper" style="height: auto; overflow: hidden; padding-right: 0px; padding-bottom: 0px;"><div class="simplebar-content" style="padding: 0px;">
                            <ul class="list-unstyled">
                                <li>
                                    <div class="d-flex">
                                        <i class="bx bx-user-circle text-primary fs-4"></i>
                                        <div class="ms-3">
                                            <h6 class="fs-14 mb-2 fw-semibold">ชื่อ-นามสกุล</h6>
                                            <p class="text-muted fs-14 mb-0">
                                                {{ @$data['data']->Name_Cus != NULL ? @$data['data']->Name_Cus : '-' }} <br>
                                                <span class="text-primary">
                                                    <b>{{ @$data['data']->Nickname_cus != NULL ? @$data['data']->Nickname_cus : '-' }}</b>
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="mt-3">
                                    <div class="d-flex">
                                        <i class="bx bx-id-card text-primary fs-4"></i>
                                        <div class="ms-3">
                                            <h6 class="fs-14 mb-2 fw-semibold">เลขประจำตัวประชาชน</h6>
                                            <p class="text-muted fs-14 mb-0 input-mask" data-inputmask="'mask': '9-9999-99999-99-9'">{{ @$data['data']->IDCard_cus != NULL ? @$data['data']->IDCard_cus : '-' }}</p>
                                                <span class="text-primary">
                                                    <span class="font-size-12 fw-semibold">วันหมดอายุ</span>
                                                    <span class="font-size-12 fw-semibold">{{ @$data['data']->IdcardExpire_cus != NULL ? @$data['data']->IdcardExpire_cus : '-' }}</span>
                                                    @if(@$data['data']->IdcardExpire_cus < date('Y-m-d'))
                                                        <i class="bx bx-x fs-5 fa-fade bx-tada text-danger" data-bs-toggle="tooltip" aria-label="บัตรประชาชนหมดอายุแล้ว !"></i>
                                                    @else
                                                        <i class="bx bx-check fs-5 fa-fade bx-tada text-success" data-bs-toggle="tooltip" aria-label="บัตรประชาชนยังไม่หมดอายุ"></i>
                                                    @endif
                                                </span>
                                        </div>
                                    </div>
                                </li>
                                <li class="mt-3">
                                    <div class="d-flex">
                                        <i class="bx bx-phone text-primary fs-4"></i>
                                        <div class="ms-3">
                                            <h6 class="fs-14 mb-2 fw-semibold">เบอร์ติดต่อ</h6>
                                            <p class="text-muted fs-14 mb-0 input-mask" data-inputmask="'mask': '999-999-9999,999-999-9999'">{{ @$data['data']->Phone_cus != NULL ? @$data['data']->Phone_cus : '-' }}</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div></div></div></div><div class="simplebar-placeholder" style="width: auto; height: 198px;"></div></div><div class="simplebar-track simplebar-horizontal" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div><div class="simplebar-track simplebar-vertical" style="visibility: hidden;"><div class="simplebar-scrollbar" style="transform: translate3d(0px, 0px, 0px); display: none;"></div></div></div>
                    </div>
                </div>
                <div class="card-footer" style="display: block;">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-evenly">
                            <small class="fw-semibold text-secondary"><i class="bx bxs-user-circle fs-5 m-auto"></i> {{ @$data['data']->UserInsert }}</small><br>
                            <small class="fw-semibold text-secondary d-none d-sm-inline" data-bs-toggle="tooltip" title="{{ @$data['data']->updated_at }}"><i class="bx bxs-time-five fs-5"></i> {{ \Carbon\Carbon::parse(@$data['data']->updated_at)->locale('th_TH')->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl col-lg col-md-12 col-sm-12">
            <div class="row g-2 mb-4">
                <div class="col-xl-6 col-sm-12">
                    <div class="card shadow-sm rounded-4 h-100">
                        <div class="card-body">
                            <p class="fw-semibold"><i class="bx bx-map"></i> {{ @$data['title-general'] }}</p>
                            <div class="row">
                                <div class="col-4 text-primary">วันเดือนปีเกิด : </div>
                                <div class="col text-end fw-semibold mb-3">{{ @$data['data']->Birthday_cus != NULL ? @$data['data']->Birthday_cus : '-' }}</div>
                            </div>
                            <div class="row">
                                <div class="col-4 text-primary">เพศ : </div>
                                <div class="col text-end fw-semibold mb-3">{{ @$data['data']->Gender_cus != NULL ? @$data['data']->Gender_cus : '-' }}</div>
                            </div>
                            <div class="row">
                                <div class="col-4 text-primary">การเปลี่ยนชื่อ : </div>
                                <div class="col text-end fw-semibold mb-3">{{ @$data['data']->Namechange_cus != NULL ? @$data['data']->Namechange_cus  : '-'}}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6 col-sm-12 ">
                    <div class="card shadow-sm rounded-4 h-100" style="background: rgb(77,191,230);
                    background: linear-gradient(299deg, rgba(77,191,230,1) 0%, rgba(197,235,252,1) 50%, rgba(249,229,249,1) 100%);">
                        <div class="card-header bg-transparent">
                            <div class="row">
                                <div class="col m-auto text-end">
                                    <i class="fab fa-cc-mastercard fs-1 text-danger align-middle me-2"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-body d-flex align-items-center justify-content-center">
                            <div class="row ">
                                <div class="col text-center">
                                    <div class="col fw-semibold fs-5">{{ @$data['data']->Number_Account != NULL ? @$data['data']->Number_Account : '-' }}</div>
                                    <p class="text-muted mb-0">เลขบัญชี</p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent" style="display:block;">
                            <div class="row">
                                <div class="col-6">
                                    <p class="text-muted mb-0">ธนาคาร</p>
                                    <h6 class="fw-semibold">{{ @$data['data']->Name_Account != NULL ? @$data['data']->Name_Account : '-' }}</h6>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="text-muted mb-0">สาขา</p>
                                    <h6 class="fw-semibold">{{ @$data['data']->Branch_Account != NULL ? @$data['data']->Branch_Account : '-' }}</h6>
                                </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="card profile-user-card-margin shadow-sm rounded-4 h-100">
                        <div class="card-body">
                            <p class="fw-semibold"><i class="bx bx-map"></i> {{ @$data['title-address'] }}</p>
                            <div class="contentAdds">
                                <ul class="nav nav-pills mb-3 nav-justified" id="pills-tab" role="tablist">
                                    @foreach( @$data['data']->DataCusToDataCusAddsMany as $value)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link   {{ $loop->iteration == '1' ? 'active' : '' }}" id="pills-tab-{{ $value->id }}" data-bs-toggle="pill" data-bs-target="#tab-{{ $value->id }}" type="button" role="tab">{{ $value->DataCusAddsToTypeAdds->Name_Address }} </button>
                                    </li>
                                    @endforeach
                                </ul>
                                <div class="tab-content">
                                    @foreach(@$data['data']->DataCusToDataCusAddsMany  as $item)
                                    <div class="tab-pane fade {{ $loop->iteration == '1' ? 'show active' : '' }}" id="tab-{{ $item->id }}" role="tabpanel" aria-labelledby="pills-tab-{{ $value->id }}">
                                        <div class="row mb-3 fw-semibold">
                                            <div class="col-xl col-lg col-md-6 col-sm-4 text-primary">TAG Address : </div>
                                            <div class="col-xl col-lg col-md-6 col-sm-8 text-end fw-semibold">{{ @$item->Code_Adds != NULL ? @$item->Code_Adds : '-' }}</div>
                                            <div class="col-xl col-lg col-md-6 col-sm-4 text-primary">บ้านเลขที่ / หมู่ : </div>
                                            <div class="col-xl col-lg col-md-6 col-sm-8 text-end fw-semibold">{{ @$item->houseNumber_Adds != NULL ? @$item->houseNumber_Adds : '-' }} / {{ @$item->alley_Adds != NULL ? @$item->alley_Adds : '-' }}</div>
                                        </div>
                                        <div class="row mb-3 fw-semibold">
                                            <div class="col-xl col-lg col-md-6 col-sm-4 text-primary">ตำบล : </div>
                                            <div class="col-xl col-lg col-md-6 col-sm-8 text-end fw-semibold">{{ @$item->houseTambon_Adds != NULL ? @$item->houseTambon_Adds : '-' }}</div>
                                            <div class="col-xl col-lg col-md-6 col-sm-4 text-primary">อำเภอ : </div>
                                            <div class="col-xl col-lg col-md-6 col-sm-8 text-end fw-semibold">{{ @$item->houseDistrict_Adds != NULL ? @$item->houseDistrict_Adds : '-' }}</div>
                                        </div>
                                        <div class="row fw-semibold mb-3">
                                            <div class="col-xl col-lg col-md-6 col-sm-4 text-primary">จังหวัด : </div>
                                            <div class="col-xl col-lg col-md-6 col-sm-8 text-end fw-semibold">{{ @$item->houseProvince_Adds != NULL ?  @$item->houseProvince_Adds : '-' }}</div>
                                            <div class="col-xl col-lg col-md-6 col-sm-4 text-primary">รหัสไปรษณีย์ : </div>
                                            <div class="col-xl col-lg col-md-6 col-sm-8 text-end fw-semibold">{{ @$item->Postal_Adds != NULL ? @$item->Postal_Adds : '-' }}</div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



