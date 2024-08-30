<script src="{{ URL::asset('/assets/js/pages/form-validation.init.js')}}"></script>
<link href="{{ URL::asset('/assets/css/select2-custom.css') }}" rel="stylesheet" type="text/css" />
<style>
    .select2-selection__clear {
        display: none !important;
    }
    .select2-search {
        display: none !important;
    }
    .select2-search--inline {
        display: none !important;
    }
</style>
<form name="formUp" id="formUp" action="#" method="post" enctype="multipart/form-data" novalidate style="font-family: 'Prompt', sans-serif;">
    @csrf
    @method('put')
    <div class="modal-content">
        <div class="d-flex m-3 mb-0">
            <div class="flex-shrink-0 me-2">
                <img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
            </div>
            <div class="flex-grow-1 overflow-hidden">
                <h5 class="text-primary fw-semibold pt-2 font-size-15">เเก้ไข เป้าสาขา{{@$data->ToBranch->Name_Branch}}</h5>
                <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>{{@$page}}</h6>
                <p class="border-primary border-bottom mt-2"></p>
            </div>
            <input type="hidden" id="page" value="{{@$page}}">
            <input type="hidden" id="id" value="{{@$data->id}}">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body mt-n4">
            {{--<div class="row">
                <div class="col-md-12 col-lg-6">
                    <!-- <div class="card">
                        <div class="card-body"> -->
                            <div class="row g-2 mb-3">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <select name="TARGET_TYPE" id="TARGET_TYPE" class="form-select" placeholder="ประเภทเป้า" required>
                                            <option value="">---เลือกประเภทเป้า---</option>
                                            @foreach($codeType as $key => $value)
                                            <option value="{{@$value->id}}" {{(@$data->TypeTarget_id == @$value->id)?'selected':''}}>{{@$value->Target_Name}}</option>
                                            @endforeach
                                        </select>
                                        <label for="Contract">ประเภทเป้า</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-12">
                                    <!-- <div class="form-floating">
                                        <select name="TARGET_TYPE" id="TARGET_TYPE" class="form-select" placeholder="กลุ่มลูกค้า" required>
                                            <option value="">---เลือกกลุ่มลูกค้า---</option>
                                        </select>
                                        <label for="Contract">กลุ่มลูกค้า</label>
                                    </div> -->
                                    @php 
                                        @$TypeCus = explode(",",@$data->Target_Typcus);
                                    @endphp
                                    <div class="col-lg-12 cl-select2">
                                        <div class="input-group">
                                            <select id="TARGET_TYPECUS{{$key+1}}" class="form-select select2" data-placeholder="เลือกกลุ่มลูกค้า" required multiple="">
                                                    @foreach($dataTypecus as $key1 => $value1)
                                                        <option value="{{$value1->id}}" {{($value1->id == @$TypeCus[$key1] || $value1->id == @$TypeCus[1] || $value1->id == @$TypeCus[2] || $value1->id == @$TypeCus[3] || $value1->id == @$TypeCus[4])?'selected':''}}>{{$value1->Name_Cus}}</option>
                                                    @endforeach
                                            </select>
                                        </div>
                                        <input type="hidden" id="TARGET_DETAIL{{$key+1}}" name="TARGET_TYPECUS[]" value="{{@$value->Target_Typcus}}" class="form-control w-25" placeholder=" " data-bs-toggle="tooltip" title="ชื่อสาขา"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <select name="TARGET_TYPE" id="TARGET_TYPE" class="form-select" placeholder="พนักงาน" required>
                                            <option value="">---เลือกพนักงาน---</option>
                                        </select>
                                        <label for="Contract">พนักงาน</label>
                                    </div>
                                </div>
                            </div>
                            
                        <!-- </div>
                    </div> -->
                </div>
                <div class="col-md-12 col-lg-6">
                    <!-- <div class="card">
                        <div class="card-body"> -->
                            <div class="row g-2 mb-3">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" id="TARGET_MONTH" name="TARGET_MONTH" value="{{@$data->Target_Month}}" class="form-control" placeholder="เป้าเดือน">
                                        <label for="Contract">เป้าเดือน</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" id="TARGET_YEAR" name="TARGET_YEAR" value="{{@$data->Target_Year}}" class="form-control" placeholder="เป้าปี">
                                        <label for="Contract">เป้าปี</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2 mb-3">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="number" id="TARGET_AMOUNT" name="TARGET_AMOUNT" value="{{@$data->Target_Amount}}" class="form-control" placeholder="ยอดเป้า">
                                        <label for="Contract">ยอดเป้า</label>
                                    </div>
                                </div>
                            </div>
                        <!-- </div>
                    </div> -->
                </div>
            </div>--}}
            <div class="card">
                <div class="card-body">
                    <div class="row mb-2">
                        <label for="horizontal-firstname-input" class="col-sm-3 col-form-label text-end">เป้าเดือน / เป้าปี</label>
                        <div class="col-sm-4">
                            <input type="text" id="TARGET_MONTH" name="TARGET_MONTH" value="{{@$data->Target_Month}}" class="form-control" placeholder="เป้าเดือน">
                        </div>
                        <div class="col-sm-4">
                            <input type="text" id="TARGET_YEAR" name="TARGET_YEAR" value="{{@$data->Target_Year}}" class="form-control" placeholder="เป้าปี">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="horizontal-firstname-input" class="col-sm-3 col-form-label text-end">ประเภทเป้า</label>
                        <div class="col-sm-9">
                            <select name="TARGET_TYPE" id="TARGET_TYPE" class="form-select" placeholder="ประเภทเป้า" required>
                                <option value="">---เลือกประเภทเป้า---</option>
                                @foreach($codeType as $key => $value)
                                <option value="{{@$value->id}}" {{(@$data->TypeTarget_id == @$value->id)?'selected':''}}>{{@$value->Target_Name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="horizontal-email-input" class="col-sm-3 col-form-label text-end">กลุ่มลูกค้า</label>
                        <div class="col-sm-9">
                            @php 
                                @$TypeCus = explode(",",@$data->Target_Typcus);
                            @endphp
                            <select id="TARGET_TYPECUS{{$key+1}}" class="form-select select2" data-placeholder="เลือกกลุ่มลูกค้า" required multiple="">
                                    @foreach($dataTypecus as $key1 => $value1)
                                        <option value="{{$value1->id}}" {{($value1->id == @$TypeCus[$key1] || $value1->id == @$TypeCus[1] || $value1->id == @$TypeCus[2] || $value1->id == @$TypeCus[3] || $value1->id == @$TypeCus[4])?'selected':''}}>{{$value1->Name_Cus}}</option>
                                    @endforeach
                            </select>
                            <input type="hidden" id="TARGET_DETAIL{{$key+1}}" name="TARGET_TYPECUS[]" value="{{@$data->Target_Typcus}}" class="form-control w-25" placeholder=" " data-bs-toggle="tooltip" title="ชื่อสาขา"/>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="horizontal-password-input" class="col-sm-3 col-form-label text-end">พนักงาน</label>
                        <div class="col-sm-9">
                            @php 
                                @$dataStaff = \App\Models\User::where('zone',auth()->user()->zone)->where('branch',@$data->Target_Branch)->get();
                            @endphp
                            <select id="TARGET_USER" name="TARGET_USER[]" class="form-select" data-placeholder="เลือกพนักงาน">
                                <option value="">เลือกพนักงาน</option>
                                @foreach($dataStaff as $key2 => $value2)
                                    <option value="{{$value2->id}}" {{($value2->id == @$data->Target_User)?'selected':''}}>{{$value2->id}} - {{$value2->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <label for="horizontal-firstname-input" class="col-sm-3 col-form-label text-end">ยอดเป้า</label>
                        <div class="col-sm-9">
                            <input type="number" id="TARGET_AMOUNT" name="TARGET_AMOUNT" value="{{@$data->Target_Amount}}" class="form-control" placeholder="ยอดเป้า">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer mt-n4">
            <button type="button" id="updateData" class="btn btn-primary rounded-2 me-2">
                <i class="mdi mdi-content-save-move"></i> Update
            </button>
        </div>
    </div>
</form>

{{-- select2 --}}
<script>
	$(document).ready(function() {
		initSelect2();
	});

	function initSelect2() {
		$('.select2').select2({
			theme: "bootstrap-5",
			language: "th",
			// width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
			placeholder: $(this).data('placeholder'),
			allowClear: true,
			// กำหนดขนาดข้อความในตัวเลือก
			templateResult: function(state) {
				if (!state.id) {
					return state.text;
				}
				return $('<span>' + state.text + '</span>').css('font-size', '12px'); // ตัวอย่าง: กำหนดขนาดเป็น 16px
			},
			templateSelection: function(state) {
				if (!state.id) {
					return state.text;
				}
				return $('<span>' + state.text + '</span>').css('font-size', '10px'); // ตัวอย่าง: กำหนดขนาดเป็น 16px
			}
		});
	}
</script>