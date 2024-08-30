<form name="formUpdate" id="formUpdate" action="#" method="post" enctype="multipart/form-data" novalidate>
    @csrf
    @method('put')
    <div class="modal-content">
        <div class="d-flex m-3 mb-0" id="Modal-drag" style="cursor:move;">
            <div class="flex-shrink-0 me-2">
                <img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
            </div>
            <div class="flex-grow-1 overflow-hidden">
                <h4 class="text-primary fw-semibold">แก้ไขรายการ</h4>
                <p class="text-muted mt-n1">{{@$title}}</p>
                <p class="border-primary border-bottom mt-n2"></p>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        @if(@$edit == 'yearcar')
            <div class="card">
                <input type="hidden" name="update" value="yearcar">
                <input type="hidden" name="BRAND_ID" value="{{@$brand_id}}">
                <input type="hidden" name="GROUP_ID" value="{{@$group_id}}">
                <input type="hidden" name="MODEL_ID" value="{{@$model_id}}">
                <input type="hidden" name="RATE_ID" value="{{@$rate_id}}">
                <input type="hidden" name="MODEL_NAME" value="{{(@$data[0] != NULL)?@$data[0]->yearToModelMoto->Model_moto:@$modelname}}">
                <div class="card-body">
                    <div class="modal-body mt-n4">
                        <h5 class="text-primary fw-semibold text-center mb-3">รุ่น : {{(@$data != NULL)?@$data[0]->yearToModelMoto->Model_moto:@$modelname}}</h5>
                        <div class="row g-2 align-self-center border-top">
                            <div class="table-responsive font-size-11" data-simplebar="init" style="max-height : 390px;">
                                <table class="table align-middle table-check" id="dynamic_field">
                                    <thead class="sticky-top">
                                        <tr class="table-light">
                                            <th class="font-size-12">
                                                ลำดับ
                                            </th>
                                            <th class="font-size-12">
                                                ปีรถ
                                            </th>
                                            <th class="font-size-12">
                                                Price AT
                                            </th>
                                            <th class="font-size-12">
                                                Price MT
                                            </th>
                                            <th class="font-size-12 text-center">
                                                การเห็น
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $key => $value)
                                            <tr>
                                                <td style="width: 10%;">
                                                    <div class="avatar-xs">
                                                        <span class="avatar-title rounded-circle bg-warning bg-gradient">
                                                            {{$key+1}}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td style="width: 25%;">
                                                    <div class="input-bx mb-2">
                                                        <input type="text" id="YEARCAR" name="YEARCAR[]" value="{{@$value->Year_moto}}" class="form-control list" placeholder=" " data-bs-toggle="tooltip" title="ปีรถ"/>
                                                        <!-- <span>ปีรถ</span> -->
                                                    </div>
                                                </td>
                                                <td style="width: 25%;">
                                                    <div class="input-bx mb-2">
                                                        <input type="text" id="PRICE_AT" name="PRICE_AT[]" value="{{number_format(@$value->PriceAT_moto)}}" class="form-control list" placeholder=" " data-bs-toggle="tooltip" title="Price AT"/>
                                                        <!-- <span>Price AT</span> -->
                                                    </div>
                                                </td>
                                                <td style="width: 25%;">
                                                    <div class="input-bx mb-2">
                                                        <input type="text" id="PRICE_MT" name="PRICE_MT[]" value="{{number_format(@$value->PriceMT_moto)}}" class="form-control list" placeholder=" " data-bs-toggle="tooltip" title="Price MT"/>
                                                        <!-- <span>Price MT</span> -->
                                                    </div>
                                                </td>
                                                <td class="font-size-12" style="width: 15%;">
                                                    <!-- <div class="form-check form-checkbox-outline form-check-danger">
                                                        <input class="form-check-input" type="checkbox" id="customCheckcolor5">
                                                        <label class="form-check-label" for="customCheckcolor5"></label>
                                                    </div> -->
                                                    <!-- <div class="form-check form-checkbox-outline form-check-danger font-size-16"> -->
                                                    <!-- <div class="form-check font-size-16">
                                                        <input class="form-check-input" type="checkbox" id="{{@$key+1}}" value="yes" name="STATUS[]" {{ (@$value->Status_year != NULL ) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="{{@$key+1}}"></label>
                                                    </div> -->
                                                    <div class="d-flex justify-content-center">
                                                        <input type="checkbox" id="{{@$key+1}}" value="yes" name="STATUS[]" switch="danger" {{ (@$value->Status_year == NULL ) ? 'checked' : '' }}>
                                                        <label for="{{@$key+1}}" data-on-label="เปิด" data-off-label="ปิด"></label>
                                                    </div>
                                                    <input type="hidden" name="ID[]" value="{{@$value->id}}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-n4">
                <button type="button" id="UpdateYear" class="btn btn-primary">
                    <i class="bx bx-save"></i> Update
                </button>
            </div>
        @elseif(@$edit == 'pricecar') 
            <div class="card">
                <input type="hidden" name="ID" value="{{@$data->id}}">
                <input type="hidden" name="BRAND_ID" value="{{@$data->Brand_id}}">
                <input type="hidden" name="GROUP_ID" value="{{@$data->Group_id}}">
                <input type="hidden" name="MODEL_ID" value="{{@$data->Model_id}}">
                <input type="hidden" name="RATE_ID" value="{{@$data->Ratetype_id}}">
                <input type="hidden" name="MODEL_NAME" value="{{@$data->yearToModelMoto->Model_moto}}">
                <div class="card-body">
                    <div class="modal-body mt-n3">
                        <div class="row">
                            <div class="col-md-12 col-lg-4">
                                <div class="text-center">
                                    <div class="mb-3 mt-n3">
                                        <!-- <img src="{{ asset('assets/images/payment-1.png') }}" alt="" class="avatar-lg"> -->
                                        <!-- <img id="ImageBrok" src="assets/images/coming-soon.svg" class="avatar-lg"> -->
                                        
                                        <!-- <img src="https://onedrive.live.com/embed?resid=1DC1DA0B4AF0A0B8%21237402&amp;authkey=%21AF5WVrowbvcQFNY&amp;width=235&amp;height=346" alt="" class="p-1 mb-2 rounded-circle border" style="width: 120px; height: 120px;"> -->
                                        <img src="{{(@$data->Profile_moto != NULL)?@$data->Profile_moto:'assets/images/coming-soon.svg'}}" alt="" class="p-1 mb-2 rounded-circle border" style="width: 120px; height: 120px;">
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <input type="checkbox" id="switch9" switch="danger" value="Y" name="STATUS" {{(@$data->Status_year == 'Y')?'checked':''}}>
                                        <label for="switch9" data-on-label="เปิด" data-off-label="ปิด"></label>
                                    </div>
                                    <!-- <div class="square-switch">
                                        <input type="checkbox" id="square-switch3" switch="bool" checked="">
                                        <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
                                    </div> -->
                                    <p>การมองเห็น</p>
                                    <br>
                                    <br>
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-8">
                                            <div class="input-bx mb-1">
                                                <input type="text" value="{{number_format(@$data->PriceAT_old)}}" class="form-control border border-white text-center" placeholder=" "/>
                                                <span class="text-warning">Price AT ก่อนปรับ</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row d-flex justify-content-center">
                                        <div class="col-8">
                                            <div class="input-bx">
                                                <input type="text" value="{{number_format(@$data->PriceMT_old)}}" class="form-control border border-white text-center" placeholder=" "/>
                                                <span class="text-warning">Price MT ก่อนปรับ</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-8">
                                <div class="row mb-2">
                                    <div class="col-12 col-md-12">
                                        <div class="input-bx mb-2">
                                            <input type="text" id="BRANDCAR" name="BRANDCAR" value="{{@$data->yearToBrandMoto->Brand_moto}}" class="form-control" placeholder=" " data-bs-toggle="tooltip" title="ยี่ห้อรถ" readonly/>
                                            <span>ยี่ห้อรถ</span>
                                        </div>
                                        <div class="input-bx mb-2">
                                            <input type="text" id="GROUPCAR" name="GROUPCAR" value="{{@$data->yearToGroupMoto->Group_moto}}" class="form-control" placeholder=" " data-bs-toggle="tooltip" title="ยี่ห้อรถ" readonly/>
                                            <span>กลุ่มรถ</span>
                                        </div>
                                        <div class="input-bx mb-2">
                                            <input type="text" id="MODELCAR" name="MODELCAR" value="{{@$data->yearToModelMoto->Model_moto}}" class="form-control" placeholder=" " data-bs-toggle="tooltip" title="รุ่นรถ" readonly/>
                                            <span>รุ่นรถ</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 align-self-center border-top">
                                    <div class="col-6 col-md-6">
                                        <div class="input-bx mb-2">
                                            <select id="TYPECAR" name="TYPECAR"  class="form-select text-dark" placeholder=" " data-bs-toggle="tooltip" title="ประเภทรถ" readonly>
                                                <option value="">--- เลือกประเภทรถ ---</option>
                                                @foreach(@$carType as $key => $value)
                                                    <option value="{{$value->code_car}}" {{(@$data->Ratetype_id == $value->code_car)?'selected':''}}>{{$key+1}}. {{$value->nametype_car}}</option>
                                                @endforeach
                                            </select>
                                            <span>ประเภทรถ</span>
                                        </div>
                                        <div class="input-bx mb-2">
                                            <input type="hidden" id="PRICE_AT_OLD" name="PRICE_AT_OLD" value="{{number_format(@$data->PriceAT_moto)}}"/>
                                            <input type="text" id="PRICE_AT" name="PRICE_AT" value="{{number_format(@$data->PriceAT_moto)}}" class="form-control" placeholder=" " data-bs-toggle="tooltip" title="Price AT" required/>
                                            <span class="text-danger">Price AT</span>
                                        </div>
                                    </div>
                                    <div class="col-6 col-md-6">
                                        <div class="input-bx mb-2">
                                            <input type="text" id="YEARCAR" name="YEARCAR" value="{{@$data->Year_moto}}" class="form-control" data-bs-toggle="tooltip" title="ปีรถ" placeholder=" "/>
                                            <span>ปีรถ</span>
                                        </div>
                                        <div class="input-bx mb-2">
                                            <input type="hidden" id="PRICE_MT_OLD" name="PRICE_MT_OLD" value="{{number_format(@$data->PriceMT_moto)}}"/>
                                            <input type="text" id="PRICE_MT" name="PRICE_MT" value="{{number_format(@$data->PriceMT_moto)}}" class="form-control" placeholder=" " data-bs-toggle="tooltip" title="Price MT" required/>
                                            <span class="text-danger">Price MT</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 align-self-center border-top mb-2">
                                    <div class="col-12 col-md-12">
                                        <div class="input-bx mb-0">
                                            <input type="text" id="PROFILE_MOTO" name="PROFILE_MOTO" value="{{@$data->Profile_moto}}" class="form-control" placeholder=" " data-bs-toggle="tooltip" title="ยี่ห้อรถ"/>
                                            <span>ลิงค์โปรไฟล์รถ</span>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="input-bx mb-2">
                                            <input type="text" id="LINK_MOTO" name="LINK_MOTO" value="{{@$data->Link_moto}}" class="form-control" placeholder=" " data-bs-toggle="tooltip" title="ยี่ห้อรถ"/>
                                            <span>ลิงค์รูปรถ</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-n4 justify-content-between">
                <small class="fw-semibold text-secondary text-start">
                  <i class="bx bxs-time-five"></i> แก้ไขเมื่อ : {{(@$data->updated_at != NULL)?\Carbon\Carbon::parse(@$data->updated_at)->locale('th_TH')->diffForHumans():''}}
                </small>
                <button type="button" id="UpdatePrice" class="btn btn-primary">
                    <i class="bx bx-save"></i> Update
                </button>
            </div>
        @elseif(@$edit == 'modelcar') 
            <div class="card">
                <input type="hidden" name="ID" value="{{@$data->id}}">
                <input type="hidden" name="GROUP_ID" value="{{@$data->Group_id}}">
                <div class="card-body">
                    <div class="modal-body mt-n3">
                        <div class="row">
                            <div class="col-md-12 col-lg-4">
                                <div class="text-center">
                                    <div class="mb-3 mt-n3">
                                        <!-- <img src="{{ asset('assets/images/payment-1.png') }}" alt="" class="avatar-lg"> -->
                                        <img id="ImageBrok" src="assets/images/coming-soon.svg" class="avatar-lg">
                                    </div>
                                    <!-- <div class="d-flex justify-content-center">
                                        <input type="checkbox" id="switch1" switch="dark" value="yes" name="STATUS" {{(@$data->Status_model == NULL)?'checked':''}}>
                                        <label for="switch1" data-on-label="เปิด" data-off-label="ปิด"></label>
                                    </div>
                                    <div class="square-switch">
                                        <input type="checkbox" id="square-switch3" switch="bool" checked="">
                                        <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
                                    </div>
                                    <p>การมองเห็น</p> -->
                                    <div class="d-flex justify-content-center">
                                        <input type="checkbox" id="switch2" switch="danger" value="yes" name="TOPCAR" {{(@$data->Topcar == 'yes')?'checked':''}}>
                                        <label for="switch2" data-on-label="ใช่" data-off-label="ไม่"></label>
                                    </div>
                                    <p>รุ่นกลาง</p>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-8">
                                <div class="row mb-2">
                                    <div class="col-12 col-md-12">
                                        <div class="input-bx mb-2">
                                            <input type="text" id="BRANDCAR" name="BRANDCAR" value="{{@$data->modelToBrandMoto->Brand_moto}}" class="form-control" placeholder=" " data-bs-toggle="tooltip" title="ยี่ห้อรถ" readonly/>
                                            <span>ยี่ห้อรถ</span>
                                        </div>
                                        <div class="input-bx mb-2">
                                            <input type="text" id="GROUPCAR" name="GROUPCAR" value="{{@$data->modelToGroupMoto->Group_moto}}" class="form-control" placeholder=" " data-bs-toggle="tooltip" title="ยี่ห้อรถ" readonly/>
                                            <span>กลุ่มรถ</span>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="row g-2 align-self-center border-top">
                                    <div class="col-12 col-md-12">
                                        <div class="input-bx mb-2">
                                            <input type="text" id="MODELCAR" name="MODELCAR" value="{{@$data->Model_moto}}" class="form-control" placeholder=" " data-bs-toggle="tooltip" title="รุ่นรถ"/>
                                            <span>รุ่นรถ</span>
                                        </div>
                                        <div class="input-bx mb-2">
                                            <select id="TYPECAR" name="TYPECAR" class="form-select text-dark" placeholder=" " data-bs-toggle="tooltip" title="ประเภทรถ">
                                                <option value="">--- เลือกประเภทรถ ---</option>
                                                @foreach(@$carType as $key => $value)
                                                    <option value="{{$value->code_car}}" {{(@$data->Ratetype_id == $value->code_car)?'selected':''}}>{{$key+1}}. {{$value->nametype_car}}</option>
                                                @endforeach
                                            </select>
                                            <span>ประเภทรถ</span>
                                        </div>
                                        <div class="input-bx mb-2">
                                            <input type="text" id="TANKCAR" name="TANKCAR" value="{{@$data->Tank_No}}" class="form-control" placeholder=" " data-bs-toggle="tooltip" title="เลขถัง"/>
                                            <span>เลขถัง</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-n4">
                <button type="button" id="UpdateModel" class="btn btn-primary">
                    <i class="bx bx-save"></i> Update
                </button>
            </div>
        @elseif(@$edit == 'groupcar') 
            <div class="card">
                <input type="hidden" name="ID" value="{{@$data->id}}">
                <input type="hidden" name="BRAND_ID" value="{{@$data->Brand_id}}">
                <div class="card-body">
                    <div class="modal-body mt-n3">
                        <div class="row">
                            <div class="col-md-12 col-lg-4">
                                <div class="text-center">
                                    <div class="mb-3 mt-n3">
                                        <img id="ImageBrok" src="assets/images/coming-soon.svg" class="avatar-lg">
                                    </div>
                                    <!-- <div class="d-flex justify-content-center">
                                        <input type="checkbox" id="switch1" switch="dark" value="yes" name="STATUS" {{(@$data->Status_group == NULL)?'checked':''}}>
                                        <label for="switch1" data-on-label="เปิด" data-off-label="ปิด"></label>
                                    </div>
                                    <div class="square-switch">
                                        <input type="checkbox" id="square-switch3" switch="bool" checked="">
                                        <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
                                    </div>
                                    <p>การมองเห็น</p> -->
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-8">
                                <div class="row mb-2">
                                    <div class="col-12 col-md-12">
                                        <div class="input-bx mb-2">
                                            <input type="text" id="BRANDCAR" name="BRANDCAR" value="{{@$data->groupToBrandMoto->Brand_moto}}" class="form-control" placeholder=" " data-bs-toggle="tooltip" title="ยี่ห้อรถ" readonly/>
                                            <span>ยี่ห้อรถ</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 align-self-center border-top">
                                    <div class="col-12 col-md-12">
                                        <div class="input-bx mb-2">
                                            <input type="text" id="GROUPCAR" name="GROUPCAR" value="{{@$data->Group_moto}}" class="form-control" placeholder=" " data-bs-toggle="tooltip" title="กลุ่มรถ"/>
                                            <span>กลุ่มรถ</span>
                                        </div>
                                        <div class="input-bx mb-2">
                                            <select id="TYPECAR" name="TYPECAR"  class="form-select text-dark" placeholder=" " data-bs-toggle="tooltip" title="ประเภทรถ">
                                                <option value="">--- เลือกประเภทรถ ---</option>
                                                @foreach(@$carType as $key => $value)
                                                    <option value="{{$value->code_car}}" {{(@$data->Ratetype_id == $value->code_car)?'selected':''}}>{{$key+1}}. {{$value->nametype_car}}</option>
                                                @endforeach
                                            </select>
                                            <span>ประเภทรถ</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-n4">
                <button type="button" id="UpdateGroup" class="btn btn-primary">
                    <i class="bx bx-save"></i> Update
                </button>
            </div>
        @elseif(@$edit == 'yearprice')
            <div class="card">
                <input type="hidden" name="update" value="yearprice">
                <input type="hidden" name="BRAND_ID" value="{{@$brand_id}}">
                <input type="hidden" name="GROUP_ID" value="{{@$group_id}}">
                <input type="hidden" name="MODEL_ID" value="{{@$model_id}}">
                <input type="hidden" name="RATE_ID" value="{{@$rate_id}}">
                <input type="hidden" name="MODEL_NAME" value="{{(@$data[0] != NULL)?@$data[0]->yearToModelMoto->Model_moto:@$modelname}}">
                <div class="card-body">
                    <div class="modal-body mt-n4">
                        <div class="row align-self-center border-bottom mb-2">
                            <div class="col-4 col-md-4">
                                <div class="input-bx mb-2">
                                    <select id="TYPERATE" name="TYPERATE" class="form-select text-dark border border-danger" placeholder=" " data-bs-toggle="tooltip" title="รูปแบบ" required>
                                        <option value="">--- เลือก ---</option>
                                        <option value="up">ปรับราคาขึ้น</option>
                                        <option value="down">ปรับราคาลง</option>
                                    </select>
                                    <span>รูปแบบ</span>
                                </div>
                            </div>
                            <div class="col-4 col-md-4">
                                <div class="input-bx mb-2">
                                    <input type="text" id="AT_RATE" name="AT_RATE" value="0" class="form-control" placeholder=" " data-bs-toggle="tooltip" title="ราคาปรับ"/>
                                    <span>ราคา AT</span>
                                </div>
                            </div>
                            <div class="col-4 col-md-4">
                                <div class="input-bx mb-2">
                                    <input type="text" id="MT_RATE" name="MT_RATE" value="0" class="form-control" placeholder=" " data-bs-toggle="tooltip" title="ราคาปรับ"/>
                                    <span>ราคา MT</span>
                                    <button type="button" id="RUNRATE" class="input-group-text bg-success text-white">
                                        <i class="bx bx-repost"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <h5 class="text-primary fw-semibold text-center mb-3">รุ่น : {{(@$data != NULL)?@$data[0]->yearToModelMoto->Model_moto:@$modelname}}</h5>
                        <div class="row g-2 align-self-center border-top">
                            <div class="table-responsive font-size-11" data-simplebar="init" style="max-height : 390px;">
                                {{--<table class="table align-middle table-check" id="dynamic_field">
                                    <thead class="sticky-top">
                                        <tr class="table-light">
                                            <th class="font-size-12" style="width: 10%;">
                                                ลำดับ
                                            </th>
                                            <th class="font-size-12" style="width: 30%;">
                                                ปีรถ
                                            </th>
                                            <th class="font-size-12" style="width: 30%;">
                                                Price AT
                                            </th>
                                            <th class="font-size-12" style="width: 30%;">
                                                Price MT
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $key => $value)
                                            <tr>
                                                <td style="width: 10%;">
                                                    <div class="avatar-xs">
                                                        <span class="avatar-title rounded-circle bg-warning bg-gradient">
                                                            {{$key+1}}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td style="width: 30%;">
                                                    <div class="input-bx mb-2">
                                                        <input type="text" id="YEARCAR" name="YEARCAR[]" value="{{@$value->Year_moto}}" class="form-control border border-none" placeholder=" " data-bs-toggle="tooltip" title="ปีรถ"/>
                                                    </div>
                                                </td>
                                                <td style="width: 30%;">
                                                    <div class="input-bx mb-2">
                                                        <input type="text" id="PRICE_AT" name="PRICE_AT[]" value="{{number_format(@$value->PriceAT_moto)}}" class="form-control border border-none" placeholder=" " data-bs-toggle="tooltip" title="Price AT"/>
                                                    </div>
                                                </td>
                                                <td style="width: 30%;">
                                                    <div class="input-bx mb-2">
                                                        <input type="text" id="PRICE_MT" name="PRICE_MT[]" value="{{number_format(@$value->PriceMT_moto)}}" class="form-control border border-none" placeholder=" " data-bs-toggle="tooltip" title="Price MT"/>
                                                    </div>
                                                    <input type="hidden" name="ID[]" value="{{@$value->id}}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>--}}
                                <table class="table align-middle table-check" id="dynamic_field">
                                    <thead class="sticky-top">
                                        <tr class="table-light">
                                            <th class="font-size-12" style="width: 10%;">
                                                ลำดับ
                                            </th>
                                            <th class="font-size-12" style="width: 25%;">
                                                ปีรถ
                                            </th>
                                            <th class="font-size-12" style="width: 15%;">
                                                Price AT (เดิม)
                                            </th>
                                            <th class="font-size-12" style="width: 15%;">
                                                Price AT
                                            </th>
                                            <th class="font-size-12" style="width: 15%;">
                                                Price MT (เดิม)
                                            </th>
                                            <th class="font-size-12" style="width: 15%;">
                                                Price MT
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $key => $value)
                                            <tr>
                                                <td style="width: 10%;">
                                                    <div class="avatar-xs">
                                                        <span class="avatar-title rounded-circle bg-warning bg-gradient">
                                                            {{$key+1}}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td style="width: 25%;">
                                                    <div class="input-bx mb-2">
                                                        <input type="text" id="YEARCAR" name="YEARCAR[]" value="{{@$value->Year_car}}" class="form-control border border-none" placeholder=" " data-bs-toggle="tooltip" title="ปีรถ"/>
                                                    </div>
                                                </td>
                                                <td style="width: 15%;">
                                                    <div class="input-bx mb-2">
                                                        <input type="text" value="{{number_format(@$value->PriceAT_old)}}" class="form-control border border-none" placeholder=" " data-bs-toggle="tooltip" title="Price AT" readonly/>
                                                    </div>
                                                </td>
                                                <td style="width: 15%;">
                                                    <div class="input-bx mb-2">
                                                        <input type="text" id="PRICE_AT" name="PRICE_AT[]" value="{{number_format(@$value->PriceAT_moto)}}" class="form-control border border-none" placeholder=" " data-bs-toggle="tooltip" title="Price AT"/>
                                                    </div>
                                                </td>
                                                <td style="width: 15%;">
                                                    <div class="input-bx mb-2">
                                                        <input type="text" value="{{number_format(@$value->PriceMT_old)}}" class="form-control border border-none" placeholder=" " data-bs-toggle="tooltip" title="Price MT" readonly/>
                                                    </div>
                                                </td>
                                                <td style="width: 15%;">
                                                    <div class="input-bx mb-2">
                                                        <input type="text" id="PRICE_MT" name="PRICE_MT[]" value="{{number_format(@$value->PriceMT_moto)}}" class="form-control border border-none" placeholder=" " data-bs-toggle="tooltip" title="Price MT"/>
                                                    </div>
                                                    <input type="hidden" name="ID[]" value="{{@$value->id}}">
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(@$edit == 'brandmoto')
            <div class="card">
                <input type="hidden" name="KEY" value="{{@$key}}">
                <input type="hidden" name="ID" value="{{@$data->id}}">
                <div class="card-body">
                    <div class="modal-body mt-n3">
                        <div class="row">
                            <div class="col-md-12 col-lg-4">
                                <div class="text-center">
                                    <div class="mb-3 mt-n3">
                                        <!-- <img src="{{ asset('assets/images/payment-1.png') }}" alt="" class="avatar-lg"> -->
                                        <img id="ImageBrok" src="assets/images/coming-soon.svg" class="avatar-lg">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-8">
                                <div class="row">
                                    <div class="col-12 col-md-12">
                                        <div class="input-bx">
                                            <input type="text" id="BRANDCAR" name="BRANDCAR" value="{{@$data->Brand_moto}}" class="form-control" placeholder=" " data-bs-toggle="tooltip" title="ยี่ห้อรถ"/>
                                            <span>ยี่ห้อรถ</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-n4">
                <button type="button" class="btn btn-danger DelBrand" data-id="{{@$data->id}}" data-name="{{@$data->Brand_moto}}">
                    <i class="bx bx-save"></i> Delete
                </button>
                <button type="button" id="UpdateBrand" class="btn btn-primary">
                    <i class="bx bx-save"></i> Update
                </button>
            </div>
        @endif 
        
    </div>
</form>

@if(@$edit == 'yearcar')
    {{-- Update Yearcar --}}
    <script>
        $("#UpdateYear").click(function(){

            // var data = {};$("#formUpdate").serializeArray().map(function(x){data[x.name] = x.value;});
            var data = $('#formUpdate').serialize();
            
            if ($("#formUpdate").valid() == true) {
                $.ajax({
                    url: "{{ route('MotoRate.update',0) }}",
                    method: 'PUT',
                    data:data,

                    success: function(result) {
                    $('#Modal-lg').modal('hide');
                    $('#Modal-xl').modal('hide');
                    swal.fire({
                        icon : 'success',
                        title : 'อัพเดทข้อมูลสำเร็จ',
                        timer: 1500,
                        showConfirmButton: false,
                    })
                    $("#YearcarDetails").html(result);
                    }
                });
            }    
        });
    </script>
@elseif(@$edit == 'yearprice')
    {{-- Update Yearcar --}}
    <script>
        $("#RUNRATE").click(function(){

            // var data = {};$("#formUpdate").serializeArray().map(function(x){data[x.name] = x.value;});
            var data = $('#formUpdate').serialize();
            
            if ($("#formUpdate").valid() == true) {
                $.ajax({
                    url: "{{ route('MotoRate.update',0) }}",
                    method: 'PUT',
                    data:data,

                    success: function(result) {
                        $('#Modal-lg').modal('hide');
                        $('#Modal-xl').modal('hide');
                        swal.fire({
                            icon : 'success',
                            title : 'อัพเดทข้อมูลสำเร็จ',
                            timer: 1500,
                            showConfirmButton: false,
                        })
                        $("#YearcarDetails").html(result);
                        // $("#YearpriceDetails").html(result);
                    }
                });
            }     
        });
    </script>
    <script>
        $('#AT_RATE,#MT_RATE').on("input", function () {

            var GetPriceAT = $("#AT_RATE").val();
            var PriceAT = GetPriceAT.replace(",", "");

            var GetPriceMT = $("#MT_RATE").val();
            var PriceMT = GetPriceMT.replace(",", "");

            $("#AT_RATE").val(addCommas(PriceAT));
            $("#MT_RATE").val(addCommas(PriceMT));
        });
    </script>
@elseif(@$edit == 'pricecar') 
    {{-- Update Price --}}
    <script>
        $("#UpdatePrice").click(function(){

            var data = {};$("#formUpdate").serializeArray().map(function(x){data[x.name] = x.value;});
            // var data = $('#formUpdate').serialize();
            
            if ($("#formUpdate").valid() == true) {
                $.ajax({
                    url: "{{ route('MotoRate.update',0) }}",
                    method: 'PUT',
                    // data:data,
                    data:{
                        _token:'{{ csrf_token() }}',
                        update: 'pricecar',
                        data:data,
                    },

                    success: function(result) {
                        $('#Modal-lg').modal('hide');
                        $('#Modal-xl').modal('hide');
                        swal.fire({
                            icon : 'success',
                            title : 'อัพเดทข้อมูลสำเร็จ',
                            timer: 1500,
                            showConfirmButton: false,
                        })
                        $("#YearcarDetails").html(result);
                        // $("#YearpriceDetails").html(result);
                    }
                });
            }     
        });
    </script>
    <script>
        $('#PRICE_AT,#PRICE_MT').on("input", function () {

            var GetPriceAT = $("#PRICE_AT").val();
            var PriceAT = GetPriceAT.replace(",", "");

            var GetPriceMT = $("#PRICE_MT").val();
            var PriceMT = GetPriceMT.replace(",", "");

            $("#PRICE_AT").val(addCommas(PriceAT));
            $("#PRICE_MT").val(addCommas(PriceMT));
        });
    </script>
@elseif(@$edit == 'modelcar') 
    {{-- Update Model --}}
    <script>
        $("#UpdateModel").click(function(){

            var data = {};$("#formUpdate").serializeArray().map(function(x){data[x.name] = x.value;});
            // var data = $('#formUpdate').serialize();
            
            if ($("#formUpdate").valid() == true) {
                $.ajax({
                    url: "{{ route('MotoRate.update',0) }}",
                    method: 'PUT',
                    // data:data,
                    data:{
                        _token:'{{ csrf_token() }}',
                        update: 'modelcar',
                        data:data,
                    },

                    success: function(result) {
                        $('#Modal-lg').modal('hide');
                        $('#Modal-xl').modal('hide');
                        swal.fire({
                            icon : 'success',
                            title : 'อัพเดทข้อมูลสำเร็จ',
                            timer: 1500,
                            showConfirmButton: false,
                        })
                        $("#ModelDetails").html(result);
                        // $("#YearpriceDetails").html(result);
                    }
                });
            }   
        });
    </script>
@elseif(@$edit == 'groupcar') 
    {{-- Update Group --}}
    <script>
        $("#UpdateGroup").click(function(){

            var data = {};$("#formUpdate").serializeArray().map(function(x){data[x.name] = x.value;});
            // var data = $('#formUpdate').serialize();
            
            if ($("#formUpdate").valid() == true) {
                $.ajax({
                    url: "{{ route('MotoRate.update',0) }}",
                    method: 'PUT',
                    // data:data,
                    data:{
                        _token:'{{ csrf_token() }}',
                        update: 'groupcar',
                        data:data,
                    },

                    success: function(result) {
                        $('#Modal-lg').modal('hide');
                        $('#Modal-xl').modal('hide');
                        swal.fire({
                            icon : 'success',
                            title : 'อัพเดทข้อมูลสำเร็จ',
                            timer: 1500,
                            showConfirmButton: false,
                        })
                        $("#GroupDetails").html(result);
                        // $("#YearpriceDetails").html(result);
                    }
                });
            }    
        });
    </script>
@elseif(@$edit == 'brandmoto') 
    {{-- Update Brand --}}
    <script>
        $("#UpdateBrand").click(function(){

            var data = {};$("#formUpdate").serializeArray().map(function(x){data[x.name] = x.value;});
            // var data = $('#formUpdate').serialize();
            
            if ($("#formUpdate").valid() == true) {
                $.ajax({
                    url: "{{ route('MotoRate.update',0) }}",
                    method: 'PUT',
                    // data:data,
                    data:{
                        _token:'{{ csrf_token() }}',
                        update: 'brandmoto',
                        data:data,
                    },

                    success: function(result) {
                        $('#Modal-lg').modal('hide');
                        $('#Modal-xl').modal('hide');
                        swal.fire({
                            icon : 'success',
                            title : 'อัพเดทข้อมูลสำเร็จ',
                            timer: 1500,
                            showConfirmButton: false,
                        })
                        $("#GroupDetails").html(result);
                    }
                });
            }    
        });
    </script>
    {{-- delete --}}
    <script>
        $(document).on('click', '.DelBrand', function(e) {
            e.preventDefault();
            let id = $(this).data('id');
            let name = $(this).data("name");

            Swal.fire({
                title: 'คุณแน่ใจหรือไม่?',
                text: "ลบรายการ " + name,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            })
            .then( (value) => {
                if (value.isConfirmed) { // กด OK 
                    let del = 'brand';
                    let _url = "{{ route('MotoRate.destroy', ':id' ) }}";
                    _url = _url.replace(':id', id);
                    $.ajax({
                    url: _url,
                    method:"DELETE",
                    data:{
                            _token:'{{ csrf_token() }}',
                            del:del,
                            id:id,
                        },
                        success:function(result){ //เสร็จแล้วทำอะไรต่อ
                            Swal.fire({
                                icon: 'success',
                                // title: 'นำออกสำเร็จ!',
                                text: "ลบข้อมูลเรียบร้อย",
                                timer: 3000
                            });
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                            // $("#GroupDetails").html(result);
                            // $('#showModel').addClass('d-none');
                            // $('#showModelDetail').addClass('d-none');
                        }
                    });
                }
                else{
                    // Swal.fire('Changes are not saved', '', 'info');
                }
            });
        });
    </script>
@endif

{{-- validate form --}}
<script>
    $(function () {
        $('#formAdd').validate({
            errorElement: 'span',
                errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>

<script>
    function addCommas(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }
</script>

{{-- table-check --}}
<script>
	$('#checkAll').on('change', function() {
		$('.table-check .form-check-input').prop('checked', $(this).prop("checked"));
	});
</script>