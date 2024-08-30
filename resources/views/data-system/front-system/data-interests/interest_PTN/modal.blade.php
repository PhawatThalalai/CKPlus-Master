<script src="{{ URL::asset('/assets/js/pages/form-validation.init.js')}}"></script>

<style>
    .form-floating {
		position: relative;
		display: flex;
		width: 100%;
		font-size: 12px;
		/* width: 300px; */
	}
</style>

@if(@$mode == 'create')
    <form name="formAdd" id="formAdd" action="#" method="post" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="modal-content">
            <div class="d-flex m-3 mb-0">
                <div class="flex-shrink-0 me-2">
                    <img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
                </div>
                <div class="flex-grow-1 overflow-hidden">
                    <h5 class="text-primary fw-semibold pt-2 font-size-15">เพิ่มดอกเบี้ย</h5>
                    <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>{{@$page}}</h6>
                    <p class="border-primary border-bottom mt-2"></p>
                </div>
                <input type="hidden" id="page" value="{{@$page}}">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-n4">
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <select id="PROMOTION_TYPE" name="PROMOTION_TYPE" class="form-select" required>
                                                <option value="">--- เลือกประเภท ---</option>
                                                @foreach($rateType as $row)
                                                    <option value="{{$row->code_car}}">{{$row->nametype_car}}</option>
                                                @endforeach
                                            </select>
                                            <label for="floatingSelectGrid">ประเภท</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-1">
                                    <div class="col-6">
                                        <div class="form-floating">
                                            <select id="START_YEARCAR" name="START_YEARCAR" class="form-select" required>
                                                <option value="">--- เลือก ---</option>
                                                @php
                                                    $Year = date('Y');
                                                @endphp
                                                @for ($i = 0; $i < 15; $i++)
                                                    <option value="{{ $Year }}">{{ $Year }}</option>
                                                    @php
                                                        $Year -= 1;
                                                    @endphp
                                                @endfor
                                            </select>
                                            <label for="floatingSelectGrid">ปีเริ่มต้นรถ</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating">
                                            <select id="END_YEARCAR" name="END_YEARCAR" class="form-select" required>
                                                <option value="">--- เลือก ---</option>
                                                @php
                                                    $Year = date('Y');
                                                @endphp
                                                @for ($i = 0; $i < 15; $i++)
                                                    <option value="{{ $Year }}">{{ $Year }}</option>
                                                    @php
                                                        $Year -= 1;
                                                    @endphp
                                                @endfor
                                            </select>
                                            <label for="floatingSelectGrid">ปีสิ้นสุดรถ</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="INTEREST_RATE" name="INTEREST_RATE" class="form-control" placeholder="ดอกเบี้ยต่อเดือน" required>
                                            <label for="Contract">ดอกเบี้ยต่อเดือน</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-1">
                                    <div class="col-6">
                                        <div class="form-floating">
                                            <select id="START_PERIOD" name="START_PERIOD" class="form-select" required>
                                                <option value="">--- เลือก ---</option>
                                                @for($t=12;$t<85;$t=$t+6)
                                                    <option value="{{$t}}">{{$t}} งวด</option>
                                                @endfor
                                            </select>
                                            <label for="floatingSelectGrid">จำนวนงวดเริ่มต้น</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating">
                                            <select id="END_PERIOD" name="END_PERIOD" class="form-select" required>
                                                <option value="">--- เลือก ---</option>
                                                @for($t=12;$t<85;$t=$t+6)
                                                    <option value="{{$t}}">{{$t}} งวด</option>
                                                @endfor
                                            </select>
                                            <label for="floatingSelectGrid">จำนวนงวดสิ้นสุด</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer mt-n4">
                <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> -->
                <button type="button" id="SaveData" class="btn btn-primary rounded-pill me-2">
                    <i class="mdi mdi-content-save-edit"></i> Save
                </button>
            </div>
        </div>
    </form>
@elseif(@$mode == 'edit')
    <form name="formUp" id="formUp" action="#" method="post" enctype="multipart/form-data" novalidate style="font-family: 'Prompt', sans-serif;">
        @csrf
        @method('put')
        <div class="modal-content">
            <div class="d-flex m-3 mb-0">
                <div class="flex-shrink-0 me-2">
                    <img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
                </div>
                <div class="flex-grow-1 overflow-hidden">
                    <h5 class="text-primary fw-semibold pt-2 font-size-15">เเก้ไขดอกเบี้ย</h5>
                    <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>{{@$page}}</h6>
                    <p class="border-primary border-bottom mt-2"></p>
                </div>
                <input type="hidden" id="page" value="{{@$page}}">
                <input type="hidden" id="id" value="{{@$data->id}}">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-n4">
                <div class="row">
                    <div class="col-md-12 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <select id="PROMOTION_TYPE" name="PROMOTION_TYPE" class="form-select" required>
                                                <option value="">--- เลือกประเภท ---</option>
                                                @foreach($rateType as $row)
                                                    <option value="{{$row->code_car}}" {{(@$data->Ratetype_rate==$row->code_car)?'selected':''}}>{{$row->nametype_car}}</option>
                                                @endforeach
                                            </select>
                                            <label for="floatingSelectGrid">ประเภท</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-5">
                                    <div class="col-6">
                                        <div class="form-floating">
                                            <select id="START_YEARCAR" name="START_YEARCAR" class="form-select" required>
                                                <option value="{{@$data->YearStart_rate}}">{{@$data->YearStart_rate}}</option>
                                                @php
                                                    $Year = date('Y');
                                                @endphp
                                                @for ($i = 0; $i < 15; $i++)
                                                    <option value="{{ $Year }}">{{ $Year }}</option>
                                                    @php
                                                        $Year -= 1;
                                                    @endphp
                                                @endfor
                                            </select>
                                            <label for="floatingSelectGrid">ปีเริ่มต้นรถ</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating">
                                            <select id="END_YEARCAR" name="END_YEARCAR" class="form-select" required>
                                                <option value="{{@$data->YearEnd_rate}}">{{@$data->YearEnd_rate}}</option>
                                                @php
                                                    $Year = date('Y');
                                                @endphp
                                                @for ($i = 0; $i < 15; $i++)
                                                    <option value="{{ $Year }}" {{ (@$data->YearEnd_rate==$Year) ? 'selected' : '' }}>{{ $Year }}</option>
                                                    @php
                                                        $Year -= 1;
                                                    @endphp
                                                @endfor
                                            </select>
                                            <label for="floatingSelectGrid">ปีสิ้นสุดรถ</label>
                                        </div>
                                    </div>
                                </div>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row g-2 mb-1">
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" id="INTEREST_RATE" name="INTEREST_RATE" value="{{@$data->Interest_rate}}" class="form-control" placeholder="ดอกเบี้ยต่อเดือน" required>
                                            <label for="Contract">ดอกเบี้ยต่อเดือน</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-2 mb-1">
                                    <div class="col-6">
                                        <div class="form-floating">
                                            <select id="START_PERIOD" name="START_PERIOD" class="form-select" required>
                                                <option value="">--- เลือก ---</option>
                                                @for($t=12;$t<85;$t=$t+6)
                                                    <option value="{{$t}}" {{(@$data->InstalmentStart_rate==$t)?'selected':''}}>{{$t}} งวด</option>
                                                @endfor
                                            </select>
                                            <label for="floatingSelectGrid">จำนวนงวดเริ่มต้น</label>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating">
                                            <select id="END_PERIOD" name="END_PERIOD" class="form-select" required>
                                                <option value="">--- เลือก ---</option>
                                                @for($t=12;$t<85;$t=$t+6)
                                                    <option value="{{$t}}" {{(@$data->InstalmentEnd_rate==$t)?'selected':''}}>{{$t}} งวด</option>
                                                @endfor
                                            </select>
                                            <label for="floatingSelectGrid">จำนวนงวดสิ้นสุด</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                        <div class="col-12">
                                            <div class="mt-4 mt-lg-0">
                                                <h5 class="font-size-12 mb-1">เปิดปิดช่วงดอกเบี้ย</h5>
                                                <div class="d-flex">
                                                    <div class="square-switch">
                                                        <input type="checkbox" id="square-switch3" switch="bool">
                                                        <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
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
            <div class="modal-footer mt-n4">
                <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> -->
                <button type="button" id="SaveData" class="btn btn-primary rounded-pill me-2">
                    <i class="mdi mdi-content-save-move"></i> Update
                </button>
            </div>
        </div>
    </form>
@endif

{{-- Create Data --}}
<script>
  $("#SaveData").click(function(){

    var data = {};$("#formAdd").serializeArray().map(function(x){data[x.name] = x.value;});
    console.log(data);
    
    if ($("#formAdd").valid() == true) {
        
    }
    else{
      // $("#loading_editGuarantor").attr('style', ''); // ***** แสดงตัวโหลด *****
      swal.fire({
              icon : 'warning',
              title : 'ข้อมูลไม่ครบ !',
              text : 'กรุณากรอกข้อมูลให้ครบถ้วน',
              timer: 3000,
              showConfirmButton: true,
            })
    }      
  });
</script>

{{-- validate form --}}
<script>
    $(function () {
        $('#formAdd,#formUp').validate({
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

