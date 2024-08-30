<div class="row">
    <div class="col-xl-6">
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div class="d-flex justify-content-start align-items-center">
                        <div class="card-title m-0">{{ @$data['fullname'] }}</div>
                        @isset($data['nickname'])
                            <div class="px-2 d-none d-sm-block">{{ ' (' . @$data['nickname'] . ')' }}</div>
                        @endisset
                    </div>
                    <a href="javascript: void(0);" class="btn btn-primary waves-effect waves-light btn-sm">View Profile <i class="mdi mdi-arrow-right ms-1"></i></a>
                </div>
                <div class="text-primary d-none d-sm-block"><b>{{ '' . @$data['NameEng'] . '' }}</b></div>
                <div class="col-xl-4 col-lg-3 col-md-3 col-sm-4 col-4 align-items-end mt-2" style="position: absolute; bottom: 0; right: 0;">
                    <div>
                        <img src="{{ URL::asset('/assets/images/crypto/features-img/img-1.png') }}" alt="" class="img-fluid d-block">
                    </div>
                </div>

                <div class="d-flex flex-row align-items-end my-3">
                    <i class="bx bx-user-circle text-primary fs-4 pe-2"></i>
                    <div class="pe-2 fw-semibold text-dark">เกรดลูกค้า</div>
                    <p class="text-muted fs-14 text-break mb-0">{{ @$data['grade'] }}</p>
                </div>
                <div class="d-flex flex-row align-items-end my-3">
                    {{ @$id_card_icon }}
                    <div class="d-none d-sm-block ps-2 fw-semibold text-dark">{{ @$id_card_name }}</div>
                    <p @if (empty(@$data['typeidcard']) || $data['typeidcard'] == '324001')
                                class="text-muted ps-2 fs-14 mb-0 input-mask" data-inputmask="'mask': '9-9999-99999-99-9'"
                            @else
                                class="text-muted ps-2 fs-14 mb-0"
                            @endif>
                            {{ @$data['idcard'] }}
                        </p>
                </div>
                <div class="d-flex flex-row align-items-end my-3">
                    <i class="bx bx-phone text-primary fs-4 pe-2"></i>
                    <div class="d-none d-sm-block pe-2 fw-semibold text-dark">เบอร์ติดต่อ</div>
                    <p class="text-muted fs-14 mb-0 input-mask" data-inputmask="'mask': '999-999-9999,999-999-9999'">{{ @$data['phone'] }}</p>
                </div>
                <div class="d-flex flex-row align-items-end my-3">
                    <i class="bx bx-customize text-primary fs-4 pe-2"></i>
                    <div class="d-none d-sm-block pe-2 fw-semibold text-dark">รหัสลูกค้า</div>
                    <p class="text-muted fs-14 text-break mb-0">{{ @$data['code'] }}</p>
                </div>
            </div>
        </div>
        <!-- end card -->

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-nowrap mb-0">
                        <tbody>
                            <tr>
                                <th scope="row">วันเดือนปีเกิด :</th>
                                <td>
                                    @isset($data['Birthday'])
                                        {{ formatDateThai(@$data['Birthday']) }}
                                        <em> ({{ calculateAge(@$data['Birthday']) }} ปี)</em>
                                    @else
                                        -
                                    @endisset
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">เพศ :</th>
                                <td>
                                    @isset($data['Gender'])
                                        {{ @$Display_Gender }}
                                    @else
                                        -
                                    @endisset
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">สัญชาติ :</th>
                                <td>
                                    @isset($data['Nationality'])
                                        {{ @$data['Nationality'] }}
                                    @else
                                        -
                                    @endisset
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">ศาสนา :</th>
                                <td>
                                    @isset($data['Religion'])
                                        {{ @$data['Religion'] }}
                                    @else
                                        -
                                    @endisset
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">สถานะสมรส :</th>
                                <td>
                                    @isset( $data['Marital'] )
                                        {{ @$data['Marital'] }}
                                        @if( @$data['Marital'] != "โสด" )
                                            <ul class="list-unstyled mb-0 text-primary">
                                                <li>
                                                    <ul>
                                                        <li>คู่สมรส <b>{{ @$data['Mate'] }}</b></li>
                                                        <li>เบอร์โทรคู่สมรส <b>{{ @$data['MatePhone'] }}</b></li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        @endif
                                    @else
                                        -
                                    @endisset
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">ธนาคาร :</th>
                                <td>
                                    @isset( $data['Account'] )
                                        {{ @$data['Account'] }}
                                        <ul class="list-unstyled mb-0 text-primary">
                                            <li>
                                                <ul>
                                                    <li>สาขา <b>{{ @$data['AccountBranch'] }}</b></li>
                                                    <li>เลขที่บัญชี <b>{{ @$data['AccountNumber'] }}</b></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    @else
                                        -
                                    @endisset
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="mt-3 d-flex flex-wrap align-items-center">
                    @isset( $data['facebook'] )
                        <span class="text-primary p-2">
                            <i class="bx bxl-facebook-square fs-4" data-bs-toggle="tooltip" title="Facebook"></i>
                            <b>
                                {{ @$data['facebook']}}
                            </b>
                        </span>
                    @endisset
                    @isset( $data['Line'] )
                        <span class="text-success p-2">
                            <i class="fab fa-line fa-line fs-4" data-bs-toggle="tooltip" title="Line ID"></i>
                            <b>
                                {{ @$data['Line']}}
                            </b>
                        </span>
                    @endisset
                    @isset( $data['Driver'] )
                        {{ @$Display_Driver }}
                    @endisset
                    @isset( $data['Namechange'] )
                        {{ @$Display_Namechange }}
                    @endisset
                </div>

            </div>
        </div>
        <!-- end card -->

    </div>         
    
    <div class="col-xl-6">

        <div class="card mb-3">
            <div class="card-body">

                @php
                    $CusAdds01 = null;
                    $CusAdds02 = null;
                    $CusAdds03 = null;
                    if ( $data['dataCus']->DataCusToDataCusAddsMany->isNotEmpty() ) {
                        $CusAdds01 = $data['dataCus']->DataCusToDataCusAddsMany->filter(function ($row) {
                            return $row->Type_Adds == 'ADR-0001' && $row->Status_Adds == 'active';
                        })->first();
                    }
                    if ( $data['dataCus']->DataCusToDataCusAddsMany->isNotEmpty() ) {
                        $CusAdds02 = $data['dataCus']->DataCusToDataCusAddsMany->filter(function ($row) {
                            return $row->Type_Adds == 'ADR-0002' && $row->Status_Adds == 'active';
                        })->first();
                    }
                    if ( $data['dataCus']->DataCusToDataCusAddsMany->isNotEmpty() ) {
                        $CusAdds03 = $data['dataCus']->DataCusToDataCusAddsMany->filter(function ($row) {
                            return $row->Type_Adds == 'ADR-0003' && $row->Status_Adds == 'active';
                        })->first();
                    }
                @endphp

                <p class="card-title">ข้อมูลที่อยู่</p>

                <div class="accordion" id="accordionCusAdds">
                    
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingCusAdds1">
                            <button class="accordion-button fw-medium collapsed {{ empty($CusAdds01) ? 'opacity-25 pe-none' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCusAdds1" aria-expanded="flase" aria-controls="collapseCusAdds1">
                                <h5 class="font-size-13 card-title mb-0"><i class="mdi mdi mdi-home fs-5"></i> ที่อยู่ปัจจุบัน</h5>
                            </button>
                        </h2>
                        <div id="collapseCusAdds1" class="accordion-collapse collapse" aria-labelledby="headingCusAdds1" data-bs-parent="#accordionCusAdds" style="">
                            <div class="accordion-body">
                                @if( !empty($CusAdds01) ) {{-- ตรวจสอบว่า $CusAdds01 มีอยู่จริง --}}
                                    <dl class="row mb-0">
                                        <dd class="col-sm-2">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>เลขที่</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds01->houseNumber_Adds)
                                                        {{$CusAdds01->houseNumber_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-2">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>หมู่</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds01->houseGroup_Adds)
                                                        {{$CusAdds01->houseGroup_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>อาคาร</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds01->building_Adds)
                                                        {{$CusAdds01->building_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>หมู่บ้าน</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds01->village_Adds)
                                                        {{$CusAdds01->village_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-2">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>ห้อง</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds01->roomNumber_Adds)
                                                        {{$CusAdds01->roomNumber_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-2">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>ชั้นที่</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds01->Floor_Adds)
                                                        {{$CusAdds01->Floor_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>ซอย</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds01->alley_Adds)
                                                        {{$CusAdds01->alley_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>ถนน</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds01->road_Adds)
                                                        {{$CusAdds01->road_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>ภูมิภาค</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds01->houseZone_Adds)
                                                        {{$CusAdds01->houseZone_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>จังหวัด</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds01->houseProvince_Adds)
                                                        {{$CusAdds01->houseProvince_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>อำเภอ</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds01->houseDistrict_Adds)
                                                        {{$CusAdds01->houseDistrict_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>ตำบล</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds01->houseTambon_Adds)
                                                        {{$CusAdds01->houseTambon_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>รหัสไปรษณีย์</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds01->Postal_Adds)
                                                        {{$CusAdds01->Postal_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>พิกัด</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds01->Coordinates_Adds)
                                                        {{$CusAdds01->Coordinates_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                    </dl>
                                    <div class="text-muted">
                                        @isset( $CusAdds01->Detail_Adds )
                                            <strong class="d-flex text-dark border-1 border-bottom border-dark border-opacity-25">รายละเอียด</strong>
                                            {{$CusAdds01->Detail_Adds}}
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingCusAdds2">
                            <button class="accordion-button fw-medium collapsed {{ empty($CusAdds02) ? 'opacity-25 pe-none' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCusAdds2" aria-expanded="false" aria-controls="collapseCusAdds2">
                                <h5 class="font-size-13 card-title mb-0"><i class="mdi mdi-home-export-outline fs-5"></i> ที่อยู่จัดส่งเอกสาร</h5>
                            </button>
                        </h2>
                        <div id="collapseCusAdds2" class="accordion-collapse collapse" aria-labelledby="headingCusAdds2" data-bs-parent="#accordionCusAdds" style="">
                            <div class="accordion-body">
                                @if( !empty($CusAdds02) )
                                    <dl class="row mb-0">
                                        <dd class="col-sm-2">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>เลขที่</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds02->houseNumber_Adds)
                                                        {{$CusAdds02->houseNumber_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-2">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>หมู่</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds02->houseGroup_Adds)
                                                        {{$CusAdds02->houseGroup_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>อาคาร</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds02->building_Adds)
                                                        {{$CusAdds02->building_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>หมู่บ้าน</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds02->village_Adds)
                                                        {{$CusAdds02->village_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-2">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>ห้อง</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds02->roomNumber_Adds)
                                                        {{$CusAdds02->roomNumber_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-2">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>ชั้นที่</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds02->Floor_Adds)
                                                        {{$CusAdds02->Floor_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>ซอย</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds02->alley_Adds)
                                                        {{$CusAdds02->alley_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>ถนน</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds02->road_Adds)
                                                        {{$CusAdds02->road_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>ภูมิภาค</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds02->houseZone_Adds)
                                                        {{$CusAdds02->houseZone_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>จังหวัด</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds02->houseProvince_Adds)
                                                        {{$CusAdds02->houseProvince_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>อำเภอ</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds02->houseDistrict_Adds)
                                                        {{$CusAdds02->houseDistrict_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>ตำบล</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds02->houseTambon_Adds)
                                                        {{$CusAdds02->houseTambon_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>รหัสไปรษณีย์</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds02->Postal_Adds)
                                                        {{$CusAdds02->Postal_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>พิกัด</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds02->Coordinates_Adds)
                                                        {{$CusAdds02->Coordinates_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                    </dl>
                                    <div class="text-muted">
                                        @isset( $CusAdds02->Detail_Adds )
                                            <strong class="d-flex text-dark border-1 border-bottom border-dark border-opacity-25">รายละเอียด</strong>
                                            {{$CusAdds02->Detail_Adds}}
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingCusAdds3">
                            <button class="accordion-button fw-medium collapsed {{ empty($CusAdds03) ? 'opacity-25 pe-none' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCusAdds3" aria-expanded="false" aria-controls="collapseCusAdds3">
                                <h5 class="font-size-13 card-title mb-0"><i class="mdi mdi-home-account fs-5"></i> ที่อยู่ตามสำเนาทะเบียนบ้าน</h5>
                            </button>
                        </h2>
                        <div id="collapseCusAdds3" class="accordion-collapse collapse" aria-labelledby="headingCusAdds3" data-bs-parent="#accordionCusAdds" style="">
                            <div class="accordion-body">
                                @if( !empty($CusAdds03) )
                                    <dl class="row mb-0">
                                        <dd class="col-sm-2">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>เลขที่</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds03->houseNumber_Adds)
                                                        {{$CusAdds03->houseNumber_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-2">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>หมู่</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds03->houseGroup_Adds)
                                                        {{$CusAdds03->houseGroup_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>อาคาร</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds03->building_Adds)
                                                        {{$CusAdds03->building_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>หมู่บ้าน</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds03->village_Adds)
                                                        {{$CusAdds03->village_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-2">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>ห้อง</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds03->roomNumber_Adds)
                                                        {{$CusAdds03->roomNumber_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-2">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>ชั้นที่</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds03->Floor_Adds)
                                                        {{$CusAdds03->Floor_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>ซอย</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds03->alley_Adds)
                                                        {{$CusAdds03->alley_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>ถนน</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds03->road_Adds)
                                                        {{$CusAdds03->road_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>ภูมิภาค</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds03->houseZone_Adds)
                                                        {{$CusAdds03->houseZone_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>จังหวัด</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds03->houseProvince_Adds)
                                                        {{$CusAdds03->houseProvince_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>อำเภอ</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds03->houseDistrict_Adds)
                                                        {{$CusAdds03->houseDistrict_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>ตำบล</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds03->houseTambon_Adds)
                                                        {{$CusAdds03->houseTambon_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>รหัสไปรษณีย์</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds03->Postal_Adds)
                                                        {{$CusAdds03->Postal_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                        <dd class="col-sm-4">
                                            <fieldset class="text-muted">
                                                <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>พิกัด</strong></legend>
                                                <p class="mb-0 text-end">
                                                    @isset($CusAdds03->Coordinates_Adds)
                                                        {{$CusAdds03->Coordinates_Adds}}
                                                    @else
                                                        -
                                                    @endisset
                                                </p>
                                            </fieldset>
                                        </dd>
                                    </dl>
                                    <div class="text-muted">
                                        @isset( $CusAdds03->Detail_Adds )
                                            <strong class="d-flex text-dark border-1 border-bottom border-dark border-opacity-25">รายละเอียด</strong>
                                            {{$CusAdds03->Detail_Adds}}
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if( count($data['dataCus']->DataCusToDataCusCareerMany) > 0)
                    <p class="card-title mt-3">ข้อมูลอาชีพ</p>
                    <div class="accordion" id="accordionCusCareer">
                        @foreach($data['dataCus']->DataCusToDataCusCareerMany as $value)
                            @php
                                $nameCarreer = "";
                                if ($value->Career_Cus == 'CR-0018') { # อาชีพอื่น ๆ
                                    $nameCarreer = $value->DetailCareer_Cus;
                                } else {
                                    $nameCarreer = $value->CusCareerToTBCareerCus->Name_Career;
                                }
                            @endphp
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingCusCareer{{($loop->index)+1}}">
                                    <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCusCareer{{($loop->index)+1}}" aria-expanded="flase" aria-controls="collapseCusCareer{{($loop->index)+1}}">
                                        <h5 class="font-size-13 card-title mb-0"><i class="mdi mdi-account-cowboy-hat fs-5"></i> อาชีพ {{$nameCarreer}}</h5>
                                        @if( $value->Status_Cus == 'active' )
                                            <div class="float-end" style="position: absolute; right: 4em;">
                                                <span class="badge rounded-pill badge-soft-success  font-size-12" id="task-status">กำลังใช้งาน</span>
                                                <br>
                                            </div>
                                        @endif
                                    </button>
                                </h2>
                                <div id="collapseCusCareer{{($loop->index)+1}}" class="accordion-collapse collapse" aria-labelledby="headingCusCareer{{($loop->index)+1}}" data-bs-parent="#accordionCusCareer" style="">
                                    <div class="accordion-body">
                                        <dl class="row mb-0">
                                            <dd class="col-sm-4">
                                                <fieldset class="text-muted">
                                                    <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>ประเภท</strong></legend>
                                                    <p class="mb-0 text-end">{{ $value->CusCareerToTBCareerCus->Name_Career }}</p>
                                                </fieldset>
                                            </dd>
                                            @if( $value->Career_Cus == 'CR-0018' ) {{-- อาชีพอื่น ๆ --}}
                                                <dd class="col-sm-4">
                                                    <fieldset class="text-muted">
                                                        <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>ระบุ</strong></legend>
                                                        <p class="mb-0 text-end">{{ $value->DetailCareer_Cus }}</p>
                                                    </fieldset>
                                                </dd>
                                                <dd class="col-sm-4">
                                            @else
                                                <dd class="col-sm-8">
                                            @endif
                                                    <fieldset class="text-muted">
                                                        <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>สถานที่ทำงาน</strong></legend>
                                                        <p class="mb-0 text-end">{{$value->Workplace_Cus}}</p>
                                                    </fieldset>
                                            </dd>
                                            <dd class="col-sm-4">
                                                <fieldset class="text-muted">
                                                    <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>รายได้</strong></legend>
                                                    <p class="mb-0 text-end">{{ number_format($value->Income_Cus, 0) }} บาท</p>
                                                </fieldset>
                                            </dd>
                                            <dd class="col-sm-4">
                                                <fieldset class="text-muted">
                                                    <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>หักค่าใช้จ่าย</strong></legend>
                                                    <p class="mb-0 text-end">{{ number_format($value->BeforeIncome_Cus, 0) }} บาท</p>
                                                </fieldset>
                                            </dd>
                                            <dd class="col-sm-4">
                                                <fieldset class="text-muted">
                                                    <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>คงเหลือ</strong></legend>
                                                    <p class="mb-0 text-end">{{ number_format($value->AfterIncome_Cus, 0) }} บาท</p>
                                                </fieldset>
                                            </dd>
                                        </dl>
                                        <div class="text-muted">
                                            @isset( $value->IncomeNote_Cus )
                                                <strong class="d-flex text-dark border-1 border-bottom border-dark border-opacity-25">รายละเอียด</strong>
                                                {{$value->IncomeNote_Cus}}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        @endforeach
                    </div>
                @endif

                @if( count($data['dataCus']->DataCusToDataCusAssetsMany) > 0)
                    <p class="card-title mt-3">ข้อมูลทรัพย์ค้ำประกัน</p>
                    <div class="accordion" id="accordionCusAsset">
                        @foreach($data['dataCus']->DataCusToDataCusAssetsMany as $value)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingCusAsset{{($loop->index)+1}}">
                                    <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCusAsset{{($loop->index)+1}}" aria-expanded="flase" aria-controls="collapseCusAsset{{($loop->index)+1}}">
                                        <h5 class="font-size-13 card-title mb-0"><i class="mdi mdi-briefcase-account fs-5"></i> ทรัพย์ค้ำ {{$value->DataCusAssetToTypeAsset->Name_Assets}}</h5>
                                        @if( $value->Status_Asset == 'active' )
                                        <div class="float-end" style="position: absolute; right: 4em;">
                                            <span class="badge rounded-pill badge-soft-success  font-size-12" id="task-status">กำลังใช้งาน</span>
                                            <br>
                                        </div>
                                    @endif
                                    </button>
                                </h2>
                                <div id="collapseCusAsset1" class="accordion-collapse collapse" aria-labelledby="headingCusAsset{{($loop->index)+1}}" data-bs-parent="#accordionCusAsset" style="">
                                    <div class="accordion-body">
                                        <dl class="row mb-0">
                                            <dd class="col-sm-4">
                                                <fieldset class="text-muted">
                                                    <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>เลขที่โฉนด</strong></legend>
                                                    <p class="mb-0 text-end">{{$value->Deednumber_Asset}}</p>
                                                </fieldset>
                                            </dd>
                                            <dd class="col-sm-8">
                                                <fieldset class="text-muted">
                                                    <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>เนื้อที่</strong></legend>
                                                    <p class="mb-0 text-end">{{$value->Area_Asset}}</p>
                                                </fieldset>
                                            </dd>
                                            
                                            <dd class="col-sm-4">
                                                <fieldset class="text-muted">
                                                    <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>ภูมิภาค</strong></legend>
                                                    <p class="mb-0 text-end">{{$value->houseZone_Asset}}</p>
                                                </fieldset>
                                            </dd>
                                            <dd class="col-sm-4">
                                                <fieldset class="text-muted">
                                                    <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>จังหวัด</strong></legend>
                                                    <p class="mb-0 text-end">{{$value->houseProvince_Asset}}</p>
                                                </fieldset>
                                            </dd>
                                            <dd class="col-sm-4">
                                                <fieldset class="text-muted">
                                                    <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>อำเภอ</strong></legend>
                                                    <p class="mb-0 text-end">{{$value->houseDistrict_Asset}}</p>
                                                </fieldset>
                                            </dd>
                                            <dd class="col-sm-4">
                                                <fieldset class="text-muted">
                                                    <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>ตำบล</strong></legend>
                                                    <p class="mb-0 text-end">{{$value->houseTambon_Asset}}</p>
                                                </fieldset>
                                            </dd>
                                            <dd class="col-sm-4">
                                                <fieldset class="text-muted">
                                                    <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>รหัสไปรษณีย์</strong></legend>
                                                    <p class="mb-0 text-end">{{$value->Postal_Asset}}</p>
                                                </fieldset>
                                            </dd>
                                            <dd class="col-sm-4">
                                                <fieldset class="text-muted">
                                                    <legend class="font-size-12 m-0 text-dark border-1 border-bottom border-dark border-opacity-25"><strong>พิกัด</strong></legend>
                                                    <p class="mb-0 text-end">{{$value->Coordinates_Asset}}</p>
                                                </fieldset>
                                            </dd>
                                        </dl>
                                        <div class="text-muted">
                                            @isset( $value->Note_Asset )
                                                <strong class="d-flex text-dark border-1 border-bottom border-dark border-opacity-25">รายละเอียด</strong>
                                                {{$value->Note_Asset}}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
        
    </div>
</div>

