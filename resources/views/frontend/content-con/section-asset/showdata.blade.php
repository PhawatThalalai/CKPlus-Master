
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">ข้อมูลผู้รับเงิน</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 ">
                <div class="col-12 text-center pt-4">
                    <img src="{{ URL::asset('\assets\images\users\avatar-1.jpg') }}" alt="" class="p-1 mb-2 rounded-circle border border-3" style="width:150px;">
                </div>
                <div class="row">
                    <div class="col-6 py-2 text-start fw-semibold">ชื่อ</div>
                    <div class="col-6 py-2 text-end ">{{ @$data->PayeetoCus->Firstname_Cus }}</div>
                    <div class="col-6 py-2 text-start fw-semibold">นามสกุล</div>
                    <div class="col-6 py-2 text-end ">{{ @$data->PayeetoCus->Surname_Cus }}</div>
                    <div class="col-6 py-2 text-start fw-semibold">เลขบัตรประชาชน</div>
                    <div class="col-6 py-2 text-end ">{{ @$data->PayeetoCus->IDCard_cus }}</div>
                    <div class="col-6 py-2 text-start fw-semibold">วันที่รับ</div>
                    <div class="col-6 py-2 text-end ">{{ @$data->PayeetoCus->date_Cus }}</div>
                </div>
            </div>
            <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12">
                <form id="editGuarantor" class="needs-validation"  novalidate>
                    <input type="hidden" name="func" value="addGuaran">
                    <input type="hidden" name="Guarantor_id" value="{{ @$data->id }}">
                    @csrf
                    <div class="row mb-3 fw-semibold">
                        <p class="fw-semibold"><i class="bx bx-briefcase-alt"></i> ข้อมูลผู้รับเงิน</p>
                        <div class="col text-primary">ประเภทที่อยู่ : </div>
                        <div class="col text-end fw-semibold">{{ @$data->PayeetoCus->DataCusToDataCusAdds->Code_Adds }}</div>
                        <div class="col text-primary">บ้านเลขที่ / หมู่ : : </div>
                        <div class="col text-end fw-semibold">{{ @$data->PayeetoCus->DataCusToDataCusAdds->houseNumber_Adds }} / {{ @$data->PayeetoCus->DataCusToDataCusAdds->houseGroup_Adds }}</div>
                    </div>

                    
                    <div class="row mb-3 fw-semibold">
                        <p class="fw-semibold"><i class="bx bx-briefcase-alt"></i> ข้อมูลที่อยู่ผู้ค้ำ</p>
                        <div class="col text-primary">ประเภทที่อยู่ : </div>
                        <div class="col text-end fw-semibold">{{ @$data->PayeetoCus->DataCusToDataCusAdds->Code_Adds }}</div>
                        <div class="col text-primary">บ้านเลขที่ / หมู่ : : </div>
                        <div class="col text-end fw-semibold">{{ @$data->PayeetoCus->DataCusToDataCusAdds->houseNumber_Adds }} / {{ @$data->PayeetoCus->DataCusToDataCusAdds->houseGroup_Adds }}</div>
                    </div>
                    <div class="row mb-3 fw-semibold">
                        <div class="col text-primary">ตำบล : </div>
                        <div class="col text-end fw-semibold">{{ @$data->PayeetoCus->DataCusToDataCusAdds->houseTambon_Adds }}</div>
                        <div class="col text-primary">อำเภอ : </div>
                        <div class="col text-end fw-semibold">{{ @$data->PayeetoCus->DataCusToDataCusAdds->houseDistrict_Adds }}</div>
                    </div>
                    <div class="row fw-semibold">
                        <div class="col text-primary">จังหวัด : </div>
                        <div class="col text-end fw-semibold">{{ @$data->PayeetoCus->DataCusToDataCusAdds->houseProvince_Adds }}</div>
                        <div class="col text-primary">รหัสไปรษณีย์ : </div>
                        <div class="col text-end fw-semibold">{{ @$data->PayeetoCus->DataCusToDataCusAdds->Postal_Adds }}</div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

