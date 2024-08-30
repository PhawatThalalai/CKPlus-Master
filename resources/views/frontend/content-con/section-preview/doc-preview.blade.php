<!-- approve -->
<div class="card p-3 mb-0">
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex">
                <h5 class="text-primary fw-semibold"><i class="bx bx-detail"></i> เอกสารการอนุมัติ (Documents Detail)</h5>
            </div>
            <p class="border-primary border-bottom"></p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <div class="form-check">
                <i class="fs-5 {{ @$data->ContractToAudittor->B1_Check_1 == 'Y' ? 'text-success bx bx-check-circle' : 'text-danger bx bx-x-circle' }} "></i>
                <label class="custom-control-label" for="B1_Check_1">เล่มทะเบียนตัวจริงและรายการต่อภาษี </label>
            </div>
            <div class="form-check">
                <i class="fs-5 {{ @$data->ContractToAudittor->B1_Check_2 == 'Y' ? 'text-success bx bx-check-circle' : 'text-danger bx bx-x-circle' }}"></i>
                <label class="custom-control-label" for="B1_Check_2">วันครอบครองและยอดจัด ตรงตามกำหนด</label>
            </div>
            <div class="form-check">
                <i class="fs-5 {{ @$data->ContractToAudittor->B1_Check_3 == 'Y' ? 'text-success bx bx-check-circle' : 'text-danger bx bx-x-circle' }}"></i>
                <label class="custom-control-label" for="B1_Check_3">บัตรประชาชนตัวจริงและไม่หมดอายุ</label>
            </div>
            <div class="form-check">
                <i class="fs-5 {{ @$data->ContractToAudittor->B1_Check_4 == 'Y' ? 'text-success bx bx-check-circle' : 'text-danger bx bx-x-circle' }}"></i>
                <label class="custom-control-label" for="B1_Check_4">ตรวจสอบทะเบียนบ้าน</label>
            </div>
            <div class="form-check">
                <i class="fs-5 {{ @$data->ContractToAudittor->B1_Check_5 == 'Y' ? 'text-success bx bx-check-circle' : 'text-danger bx bx-x-circle' }}"></i>
                <label class="custom-control-label" for="B1_Check_5">รายละเอียดในเล่มทะเบียนตรงกับรูปในอัลบั้ม </label>
            </div>
            <div class="form-check">
                <i class="fs-5 {{ @$data->ContractToAudittor->B1_Check_6 == 'Y' ? 'text-success bx bx-check-circle' : 'text-danger bx bx-x-circle' }}"></i>
                <label class="custom-control-label" for="B1_Check_6">รูปถ่ายลูกค้าคู่กับรถ</label>
            </div>
            <div class="form-check">
                <i class="fs-5 {{ @$data->ContractToAudittor->B1_Check_7 == 'Y' ? 'text-success bx bx-check-circle' : 'text-danger bx bx-x-circle' }}"></i>
                <label class="custom-control-label" for="B1_Check_7">รูปถ่ายลูกค้าตอนเซ็นสัญญา </label>
            </div>
            <div class="form-check">
                <i class="fs-5 {{ @$data->ContractToAudittor->B1_Check_8 == 'Y' ? 'text-success bx bx-check-circle' : 'text-danger bx bx-x-circle' }}"></i>
                <label class="custom-control-label" for="B1_Check_8">เอกสารเซ็นต์รับเงินลูกค้า(ใบสั้นสีขาว)</label>
            </div>
            <div class="form-check">
                <i class="fs-5 {{ @$data->ContractToAudittor->B1_Check_9 == 'Y' ? 'text-success bx bx-check-circle' : 'text-danger bx bx-x-circle' }}"></i>
                <label class="custom-control-label" for="B1_Check_9">แผนที่บ้าน </label>
            </div>

        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <div class="form-check">
                <i class="fs-5 {{ @$data->ContractToAudittor->B1_Check_10 == 'Y' ? 'text-success bx bx-check-circle' : 'text-danger bx bx-x-circle' }}"></i>
                <label class="custom-control-label" for="B1_Check_10">ยอดจัด ยอดผ่อน จำนวนงวดและดอกเบี้ย</label>
            </div>
            <div class="form-check">
                <i class="fs-5 {{ @$data->ContractToAudittor->B1_Check_11 == 'Y' ? 'text-success bx bx-check-circle' : 'text-danger bx bx-x-circle' }}"></i>
                <label class="custom-control-label" for="B1_Check_11">รายการตรวจสอบเล่มทะเบียน</label>
            </div>
            <div class="form-check">
                <i class="fs-5 {{ @$data->ContractToAudittor->B1_Check_12 == 'Y' ? 'text-success bx bx-check-circle' : 'text-danger bx bx-x-circle' }}"></i>
                <label class="custom-control-label" for="B1_Check_12">เอกสาร PDPA</label>
            </div>
            <div class="form-check">
                <i class="fs-5 {{ @$data->ContractToAudittor->B1_Check_13 == 'Y' ? 'text-success bx bx-check-circle' : 'text-danger bx bx-x-circle' }}"></i>
                <label class="custom-control-label" for="B1_Check_13">เบอร์โทรศัพท์ผู้กู้หรือผู้เช่าซื้อ / ผู้ค้ำ</label>
            </div>
            <div class="form-check">
                <i class="fs-5 {{ @$data->ContractToAudittor->B1_Check_14 == 'Y' ? 'text-success bx bx-check-circle' : 'text-danger bx bx-x-circle' }}"></i>
                <label class="custom-control-label" for="B1_Check_14">เลขที่บัญชีผู้กู้หรือผู้เช่าซื้อ</label>
            </div>
            <div class="form-check">
                <i class="fs-5 {{ @$data->ContractToAudittor->B1_Check_15 == 'Y' ? 'text-success bx bx-check-circle' : 'text-danger bx bx-x-circle' }}"></i>
                <label class="custom-control-label" for="B1_Check_15">เซ็นสัญญาลูกค้าครบถ้วนตรงตามประเภทสัญญา</label>
            </div>
        </div>
    </div>
</div>
<!-- endapprove -->
