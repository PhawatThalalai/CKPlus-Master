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

@if ($reqType === 'create')
    <form name="formAdd" id="formAdd" action="#" method="post" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="modal-content">
            <div class="d-flex m-3 mb-0">
                <div class="flex-shrink-0 me-2">
                    <img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
                </div>
                <div class="flex-grow-1 overflow-hidden">
                    <h5 class="text-primary fw-semibold pt-2 font-size-15">เพิ่มค่าคงที่สินเชื้อ</h5>
                    <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>{{@$typeLoan}}</h6>
                    <p class="border-primary border-bottom mt-2"></p>
                </div>
                <input type="hidden" id="page" value="{{@$page}}">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-n4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <!-- <div class="card">
                                    <div class="card-body"> -->
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="LATEPER" name="LATEPER" class="form-control" placeholder="เบี้ยปรับล้าช้า" required>
                                                    <label for="Contract">เบี้ยปรับล้าช้า</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="LATENFINE" name="LATENFINE" class="form-control" placeholder="จำนวนวันล้าช้าไม่มีเบี้ยปรับ">
                                                    <label for="Contract">จำนวนวันล้าช้าไม่มีเบี้ยปรับ</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="DISCOUNT" name="DISCOUNT" class="form-control" placeholder="ส่วนลด">
                                                    <label for="Contract">ส่วนลด</label>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- </div>
                                </div> -->
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <!-- <div class="card">
                                    <div class="card-body"> -->
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="INT" name="INT" class="form-control" placeholder="ดอกเบี้ย" required>
                                                    <label for="Contract">ดอกเบี้ย</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="VAT" name="VAT" class="form-control" placeholder="ภาษี" required>
                                                    <label for="Contract">ภาษี</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="MTHDDIS" name="MTHDDIS" class="form-control" placeholder="วิธีคำนวณส่วนลดตัดสด" required>
                                                    <label for="Contract">วิธีคำนวณส่วนลดตัดสด</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mt-4 mt-lg-0">
                                                    <h5 class="font-size-12 mb-1">เปิดปิดสาขา</h5>
                                                    <div class="d-flex">
                                                        <div class="square-switch">
                                                            <input type="checkbox" id="square-switch3" switch="bool" name="FLAG" value="yes" id="BranchActive" checked>
                                                            <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-n4">
                    <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> -->
                    <button type="submit" id="SaveData" class="btn btn-primary rounded-pill me-2">
                        <i class="mdi mdi-content-save-edit"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </form>
@elseif($reqType == 'edit')
    <form name="formUpdate" id="formUpdate" action="#" method="post" enctype="multipart/form-data" novalidate>
        @csrf
        <div class="modal-content">
            <div class="d-flex m-3 mb-0">
                <div class="flex-shrink-0 me-2">
                    <img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
                </div>
                <div class="flex-grow-1 overflow-hidden">
                    <h5 class="text-primary fw-semibold pt-2 font-size-15">เพิ่มค่าคงที่สินเชื้อ</h5>
                    <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>{{@$typeLoan}}</h6>
                    <p class="border-primary border-bottom mt-2"></p>
                </div>
                <input type="hidden" id="page" value="{{@$page}}">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mt-n4">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <!-- <div class="card">
                                    <div class="card-body"> -->
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="LATEPER" name="LATEPER" value="{{ $resModal->LATEPER }}" class="form-control" placeholder="เบี้ยปรับล้าช้า" required>
                                                    <label for="Contract">เบี้ยปรับล้าช้า</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="LATENFINE" name="LATENFINE" value="{{ $resModal->LATENFINE }}" class="form-control" placeholder="จำนวนวันล้าช้าไม่มีเบี้ยปรับ">
                                                    <label for="Contract">จำนวนวันล้าช้าไม่มีเบี้ยปรับ</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="DISCOUNT" name="DISCOUNT" value="{{ $resModal->DISCOUNT }}" class="form-control" placeholder="ส่วนลด">
                                                    <label for="Contract">ส่วนลด</label>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- </div>
                                </div> -->
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <!-- <div class="card">
                                    <div class="card-body"> -->
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="INT" name="INT" value="{{ $resModal->INT }}" class="form-control" placeholder="ดอกเบี้ย" required>
                                                    <label for="Contract">ดอกเบี้ย</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="VAT" name="VAT" value="{{ $resModal->VAT }}" class="form-control" placeholder="ภาษี" required>
                                                    <label for="Contract">ภาษี</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row g-2 mb-1">
                                            <div class="col-12">
                                                <div class="form-floating">
                                                    <input type="text" id="MTHDDIS" name="MTHDDIS" value="{{ $resModal->MTHDDIS }}" class="form-control" placeholder="วิธีคำนวณส่วนลดตัดสด" required>
                                                    <label for="Contract">วิธีคำนวณส่วนลดตัดสด</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="mt-4 mt-lg-0">
                                                    <h5 class="font-size-12 mb-1">เปิดปิดสาขา</h5>
                                                    <div class="d-flex">
                                                        <div class="square-switch">
                                                            <input type="checkbox" id="square-switch3" switch="bool" name="FLAG" value="yes" id="BranchActive" {{ $resModal->FLAG === 'active' ? 'checked' : '' }}>
                                                            <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <!-- </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-n4">
                    <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> -->
                    <button type="submit" id="SaveData" class="btn btn-primary rounded-pill me-2">
                        <i class="mdi mdi-content-save-edit"></i> Save
                    </button>
                </div>
            </div>
        </div>
    </form>
@endif
<script>
    $(document).ready(function() {
        $("#formAdd").submit(function(e) {
            try {
                e.preventDefault();
                let data = {};
                $("#formAdd").serializeArray().map(function(x) {
                    data[x.name] = x.value;
                });
                $.ajax({
                    url: "{{ route('dataStatic.store') }}",
                    type: "POST",
                    data: {
                        data: data,
                        type: "{{ @$typeLoan }}",
                        store: 'createTypeLoan',
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        $('#Modal-xl').modal('hide');
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            text: "เพิ่มข้อมูลเสร็จสิ้น",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#viewDataBranch').html(res.resHtml).show('slow');
                    },
                    error: function(err) {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            text: "ไม่สามารถบันทึกข้อมูลได้กรุณาลองไม่ภายหลัง",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            } catch (error) {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    text: `${error}`,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });

        $("#formUpdate").submit(function(e) {
            try {
                e.preventDefault();
                let data = {};
                $("#formUpdate").serializeArray().map(function(x) {
                    data[x.name] = x.value;
                });

                $.ajax({
                    url: "{{ route('dataStatic.store') }}",
                    type: "POST",
                    data: {
                        id: "{{ empty($resModal->id) ? '' : $resModal->id }}",
                        data: data,
                        typeLoan: "{{ @$typeLoan }}",
                        up: 'updateTypeLoan',
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        $('#Modal-xl').modal('hide');
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            text: "บันทึกข้อมูลสำเร็จ",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#viewDataBranch').html(res.resHtml).show('slow');
                    },
                    error: function(err) {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            text: "ไม่สามารถบันทึกข้อมูลได้กรุณาลองใหม่ภายหลัง",
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            } catch (error) {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    text: `${error}`,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    });
</script>