<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>
@include('frontend\content-con\section-guaran\script-guaran')
<style>
  .popst{
    background-color : red;
  }
</style>


    <div class="modal-body">
        <div class="row">
            <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 border border-primary border-opacity-75 border-2 rounded-4 shadow-sm">
              <div class="row">
                <div class="col text-center">
                  <h6 class="mt-2 fw-semibold">
                    <button type="button" class="btn btn-xs btn-primary btn-sm rounded-pill backGuaran me-2">
                      <i class="fas fa-arrow-left"></i>
                    </button>
                    สอบถามข้อมูลผู้ค้ำ
                </h6>
                </div>
              </div>
              <div class="col-12 text-center">
                <img src="{{ @$data->image_cus != NULL ? @$data->image_cus : URL::asset('\assets\images\users\avatar-1.jpg') }}" alt="" class="p-1 mb-2 rounded-circle border border-3" style="width:100px; height:100px;">
              </div>
              <div class="row">
                <div class="col-6 py-2 text-start fw-semibold">ชื่อ</div>
                <div class="col-6 py-2 text-end ">{{ @$data->Firstname_Cus }}</div>
                <div class="col-6 py-2 text-start fw-semibold">นามสกุล</div>
                <div class="col-6 py-2 text-end ">{{ @$data->Surname_Cus }}</div>
                <div class="col-6 py-2 text-start fw-semibold">เลขบัตรประชาชน</div>
                <div class="col-6 py-2 text-end ">{{ @$data->IDCard_cus }}</div>
                <div class="col-6 py-2 text-start fw-semibold">วันที่รับ</div>
                <div class="col-6 py-2 text-end ">{{ @$data->date_Cus }}</div>
              </div>
            </div>

          <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12">
            <form id="editGuarantor" class="needs-validation"  novalidate>
                <input type="hidden" name="func" value="addGuaran">
                <input type="hidden" name="Guarantor_id" value="{{ @$data->id}}">
                {{-- <input type="hidden" name="idasst" value="{{ @$data->id }}"> --}}
                @csrf
                <div class="">
                    <div class=" textSize-13" >
                        <div class="row g-1">
                            <p class="fw-semibold"><i class="bx bx-user-check"></i> ช้อมูลผู้ค้ำประกัน</p>
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                            <div class="form-group row mb-0">
                                <label for="RelationsCus" class="col-sm-4 col-form-label text-end text-red">ความสัมพันธ์ : </label>
                                <div class="col-sm-7">
                                <select class="form-select " id="RelationsCus" name="RelationsCus" required>
                                    <option value="" selected>--- ความสัมพันธ์ ---</option>
                                    @foreach(@$relaCus as $value)
                                    <option value="{{@$value->Code_Rela }}">{{$loop->iteration}}. {{ @$value->Name_Rela }}</option>
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
                                    <option value="{{@$value->Code_Secur }}">{{$loop->iteration}}. {{ @$value->Name_Secur }}</option>
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
                                    <input type="text" id="houseNumber_Adds" value="{{ @$data->DataCusToDataCusAddsMany[0]->Code_Adds }}" class="form-control " placeholder="บ้านเลขที่" readonly style="background-color: #FFFFFF;">

                                </div>

                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group row mb-0">
                                    <p class="col-sm-4 col-form-label text-end">บ้านเลขที่ / หมู่ :</p>
                                    <div class="col-sm-3">
                                    <input type="text" id="houseNumber_Adds" value="{{ @$data->DataCusToDataCusAddsMany[0]->houseNumber_Adds }}" class="form-control " placeholder="บ้านเลขที่" readonly style="background-color: #FFFFFF;">
                                    </div>
                                    <div class="col-sm-4">
                                    <input type="text" id="houseGroup_Adds" value="{{ @$data->DataCusToDataCusAddsMany[0]->houseGroup_Adds }}" class="form-control " placeholder="หมู่" readonly style="background-color: #FFFFFF;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group row mb-0">
                                    <p class="col-sm-4 col-form-label text-end">จังหวัด :</p>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control " id="houseProvince_Adds" placeholder="--- จังหวัด ---" value="{{ @$data->DataCusToDataCusAddsMany[0]->houseProvince_Adds }}" readonly style="background-color: #FFFFFF;">
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-6 col-lg-12 col-md-12 col-sm-12">
                                <div class="form-group row mb-0">
                                    <p class="col-sm-4 col-form-label text-end">เลขไปรษณีย์ :</p>
                                    <div class="col-sm-7">
                                        <input type="text" class="form-control " id="Postal_Adds" placeholder="--- สถานที่ทำงาน ---" value="{{ @$data->DataCusToDataCusAddsMany[0]->Postal_Adds }}" readonly style="background-color: #FFFFFF;">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 border border-bottom my-3"></div>

                        <div class="row">
                            <p class="fw-semibold"><i class="bx bx-briefcase-alt"></i> ทรัพย์ผู้ค้ำประกัน</p>
                            @if(count(@$data->DataCusToDataCusAssetsMany) != 0 && @$data->DataCusToDataCusAssetsMany != NULL)
                            <div class="col-xl-12">
                                <div class="d-flex px-2 pb-2" style="overflow-x : scroll;">

                                    @foreach(@$data->DataCusToDataCusAssetsMany as $value)
                                        @if($value != 'inactive')
                                            <div class="col-4 me-1">
                                                <label class="card-radio-label form-label"
                                                        data-bs-placement="top"
                                                        data-bs-toggle="popover" data-bs-placement="right"
                                                        data-bs-custom-class="custom-popover border border-2 border-primary"
                                                        data-bs-title="รายละเอียดทรัพย์"
                                                        data-bs-content="
                                                        <div class='row'>
                                                            <div class='col-6 bg-light py-2 fw-semibold'>ประเภททรัพย์</div>
                                                            <div class='col-6 bg-light py-2 text-end'>{{@$value->DataCusAssetToTypeAsset->Name_Assets}}</div>
                                                            <div class='col-6 py-2 fw-semibold'>เลขที่โฉนด</div>
                                                            <div class='col-6 py-2 text-end'>{{@$value->Deednumber_Asset}}</div>
                                                            <div class='col-6 py-2 bg-light fw-semibold'>เนื้อที่</div>
                                                            <div class='col-6 py-2 bg-light text-end'>{{@$value->Area_Asset}}</div>
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

                                                <input name="idAsset[]" value="{{ $value->id }}" type="checkbox" class="card-radio-input form-check-input">
                                                    <div class="card-radio">
                                                        <i class="fas fa-toolbox font-size-24 text-primary align-middle me-2"></i>
                                                        <span>ทรัพย์ค้ำประกัน {{$loop->iteration}}</span>
                                                    </div>
                                                </label>
                                            </div>
                                        @endif
                                    @endforeach

                                </div>
                            </div>
                            @else
                            <div class="col-xl-12 text-center">
                                <p class="fw-semibold text-danger">ไม่มีทรัพย์ค้ำ</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

            </form>
          </div>
        </div>
    </div>
    <div class="modal-footer">
		<button type="button" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-success btn-sm textSize-13 hover-up" id="submitGuarantorBtn" >
            <i class="fas fa-download"></i> บันทึก <span class="addSpin"></span>
        </button>
    </div>


<script>
    $('[data-bs-toggle="popover"]').popover({
        html: true,
        trigger: 'hover'
    })
</script>
