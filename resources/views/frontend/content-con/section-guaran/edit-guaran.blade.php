<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>
@include('frontend\content-con\section-guaran\script-guaran')

<div class="modal-content">
    <div class="d-flex m-3">
        <div class="flex-shrink-0 me-2">
            <img src="{{ asset('assets/images/gif/home.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h5 class="text-primary fw-semibold">แก้ไขข้อมูลผู้ค้ำประกัน (Edit Guarantor)</h5>
            <p class="text-muted mt-n1 fw-semibold font-size-12">No. : {{ @$data->GuarantorToGuarantorCus->IDCard_cus }}</p>
            <p class="border-primary border-bottom mt-n2 m-2"></p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row px-3">
            <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12  border border-primary border-opacity-75 border-2 rounded-4">
                <div class="col-12 text-center pt-4">
                    <img src="{{ URL::asset('\assets\images\users\avatar-1.jpg') }}" alt="" class="p-1 mb-2 rounded-circle border border-3" style="width:125px;">
                </div>
                <div class="row">
                    <div class="col-6 py-2 text-start fw-semibold">ชื่อ</div>
                    <div class="col-6 py-2 text-end ">{{ @$data->GuarantorToGuarantorCus->Firstname_Cus }}</div>
                    <div class="col-6 py-2 text-start fw-semibold">นามสกุล</div>
                    <div class="col-6 py-2 text-end ">{{ @$data->GuarantorToGuarantorCus->Surname_Cus }}</div>
                    <div class="col-6 py-2 text-start fw-semibold">เลขบัตรประชาชน</div>
                    <div class="col-6 py-2 text-end ">{{ @$data->GuarantorToGuarantorCus->IDCard_cus }}</div>
                    <div class="col-6 py-2 text-start fw-semibold">วันที่รับ</div>
                    <div class="col-6 py-2 text-end ">{{ @$data->GuarantorToGuarantorCus->date_Cus }}</div>
                </div>
            </div>

            <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12">
                <form id="editGuarantor" class="needs-validation"  novalidate>
                    <input type="hidden" name="func" value="editGuaran">
                    <input type="hidden" name="Guarantor_id" value="{{ @$data->Guarantor_id }}">
                    <input type="hidden" name="idasst" value="{{ @$data->id }}">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h4 class="d-flex">
                                ข้อมูลเพิ่มเติมผู้ค้ำ
                            </h4>
                        </div>
                        <div class="card-body textSize-13" >

                            <div class="row g-1">
                                <p class="fw-semibold"><i class="bx bx-user-check"></i> ช้อมูลผู้ค้ำประกัน</p>
                                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group row mb-0">
                                    <label for="RelationsCus" class="col-sm-4 col-form-label text-end text-red">ความสัมพันธ์ : </label>
                                    <div class="col-sm-7">
                                    <select class="form-select " id="RelationsCus" name="RelationsCus" required>
                                        <option value="" selected>--- ความสัมพันธ์ ---</option>
                                        @foreach(@$relaCus as $value)
                                        <option value="{{@$value->Code_Rela }}" {{ @$value->Code_Rela == @$data->TypeRelation_Cus ? 'selected' : '' }}>{{$loop->iteration}}. {{ @$value->Name_Rela }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                </div>
                                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group row mb-0">
                                    <label for="Securities" class="col-sm-4 col-form-label text-end text-red">แบบค้ำ : </label>
                                    <div class="col-sm-7">
                                    <select class="form-select " id="Securities" name="Securities" required>
                                        <option value="" selected>--- แบบค้ำ ---</option>
                                        @foreach(@$TypeSecur as $value)
                                        <option value="{{@$value->Code_Secur }}" {{ @$value->Code_Secur == @$data->TypeSecurities_Guar ? 'selected' : '' }}>{{$loop->iteration}}. {{ @$value->Name_Secur }}</option>
                                        @endforeach
                                    </select>
                                    </div>
                                </div>
                                </div>

                            </div>
                            <div class="col-12 border border-bottom my-3"></div>

                            <div class="row g-1">
                                <p class="fw-semibold"><i class="bx bx-map-pin"></i> ที่อยู่ผู้ค้ำประกัน</p>
                                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group row mb-0">
                                    <label for="Code_Adds" class="col-sm-4 col-form-label text-end">ที่อยู่ส่งเอกสาร : </label>
                                    <div class="col-sm-7">

                                        {{-- <select id="Code_Adds" name="Code_Adds" class="form-control " data-tagtype="address" >
                                            <option value="" selected>--- Tag Address ---</option>
                                        </select> --}}
                                        <input type="text" id="houseNumber_Adds" value="{{ @$data->GuarantorToGuarantorCus->DataCusToDataCusAdds->Code_Adds }}" class="form-control " placeholder="บ้านเลขที่" readonly style="background-color: #FFFFFF;">

                                    </div>

                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group row mb-0">
                                        <p class="col-sm-4 col-form-label text-end">บ้านเลขที่ / หมู่ :</p>
                                        <div class="col-sm-3">
                                        <input type="text" id="houseNumber_Adds" value="{{ @$data->GuarantorToGuarantorCus->DataCusToDataCusAdds->houseNumber_Adds }}" class="form-control " placeholder="บ้านเลขที่" readonly style="background-color: #FFFFFF;">
                                        </div>
                                        <div class="col-sm-4">
                                        <input type="text" id="houseGroup_Adds" value="{{ @$data->GuarantorToGuarantorCus->DataCusToDataCusAdds->houseGroup_Adds }}" class="form-control " placeholder="หมู่" readonly style="background-color: #FFFFFF;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group row mb-0">
                                        <p class="col-sm-4 col-form-label text-end">จังหวัด :</p>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control " id="houseProvince_Adds" placeholder="--- จังหวัด ---" value="{{ @$data->GuarantorToGuarantorCus->DataCusToDataCusAdds->houseProvince_Adds }}" readonly style="background-color: #FFFFFF;">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                                    <div class="form-group row mb-0">
                                        <p class="col-sm-4 col-form-label text-end">เลขไปรษณีย์ :</p>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control " id="Postal_Adds" placeholder="--- สถานที่ทำงาน ---" value="{{ @$data->GuarantorToGuarantorCus->DataCusToDataCusAdds->Postal_Adds }}" readonly style="background-color: #FFFFFF;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 border border-bottom my-3"></div>
                                <div class="row">
                                    <p class="fw-semibold"><i class="bx bx-briefcase-alt"></i> ทรัพย์ผู้ค้ำประกัน</p>
                                    <div class="col-xl-12">
                                        <div class="d-flex px-2 pb-2" style="overflow-x : scroll;">
                                            @php
                                            $arr = [];
                                            foreach(@$data->GuarantorToDataGuarAsset as $item){
                                                array_push($arr, $item->GuarAsset_id);
                                            }
                                            @endphp
                                        @foreach(@$data->GuarantorToGuarantorCus->DataCusToDataCusAssetsMany as $value)
                                                <div class="col-4 me-1">
                                                    <label class="card-radio-label form-label"
                                                            data-bs-placement="top"
                                                            data-bs-toggle="popover" data-bs-placement="right"
                                                            data-bs-custom-class="custom-popover border border-2 border-primary"
                                                            data-bs-title="รายละเอียดทรัพย์"
                                                            data-bs-content="
                                                            <div class='row'>
                                                                <div class='col-6 bg-light py-2 fw-semibold'>ประเภททรัพย์</div>
                                                                <div class='col-6 bg-light py-2 text-end'>{{$value->Type_Asset}}</div>
                                                                <div class='col-6 py-2 fw-semibold'>เลขที่โฉนด</div>
                                                                <div class='col-6 py-2 text-end'>{{$value->Type_Asset}}</div>
                                                                <div class='col-6 py-2 bg-light fw-semibold'>เนื้อที่</div>
                                                                <div class='col-6 py-2 bg-light text-end'>{{$value->Type_Asset}}</div>
                                                                <div class='col-6 py-2 fw-semibold'>ภูมิภาค</div>
                                                                <div class='col-6 py-2 text-end'>{{$value->houseZone_Asset}}</div>
                                                                <div class='col-6 py-2 bg-light fw-semibold'>จังหวัด</div>
                                                                <div class='col-6 py-2 bg-light text-end'>{{$value->houseProvince_Asset}}</div>
                                                                <div class='col-6 py-2 fw-semibold'>อำเภอ</div>
                                                                <div class='col-6 py-2 text-end'>{{$value->houseDistrict_Asset}}</div>
                                                                <div class='col-6 py-2 bg-light fw-semibold'>ตำบล</div>
                                                                <div class='col-6 py-2 bg-light text-end'>{{$value->houseTambon_Asset}}</div>
                                                                <div class='col-6 py-2 fw-semibold'>รหัสไปรษณีย์</div>
                                                                <div class='col-6 py-2 text-end'>{{$value->Postal_Asset}}</div>
                                                                <div class='col-6 py-2 bg-light fw-semibold'>รายละเอียด</div>
                                                                <div class='col-6 py-2 bg-light text-end'>{{$value->Note_Asset}}</div>
                                                                <div class='col-6 py-2 fw-semibold'>พิกัด</div>
                                                                <div class='col-6 py-2 text-end'>{{$value->Coordinates_Asset}}</div>
                                                            </div>">

                                                    <input name="idAsset[]" value="{{ $value->id }}" type="checkbox" class="card-radio-input form-check-input" {{ in_array($value->id,$arr) == true ? 'checked' : '' }}>
                                                        <div class="card-radio">
                                                            <i class="fas fa-toolbox font-size-24 text-primary align-middle me-2"></i>
                                                            <span>ทรัพย์ค้ำประกัน {{$loop->iteration}}</span>
                                                        </div>
                                                    </label>
                                                </div>

                                        @endforeach
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-success btn-sm textSize-13 hover-up" id="UpdateGuarantorBtn" >
            <i class="fas fa-download icon"></i> <span class="addSpin"></span> อัพเดทข้อมูล
        </button>
        <button type="button" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">ปิด</button>
    </div>
</div>

<script>
    $('[data-bs-toggle="popover"]').popover({
        html: true,
        trigger: 'hover'
    })
</script>
