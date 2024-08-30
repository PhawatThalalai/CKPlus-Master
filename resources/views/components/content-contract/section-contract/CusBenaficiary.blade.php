<h5 class="fw-semibold text-primary"><i class="bx bx-user-check"></i> ผู้รับผลประโยชน์ (PA)</h5>
<div class="row bg-light py-3">
    <div class="col m-auto">
        <span class="fw-semibold fs-3"><i class="bx bx-user-check text-success"></i> </span>
    </div>
    <div class="col-7 m-auto">
        <span class="fw-semibold RefText {{ @$data->Beneficiary_PA != null ? '' : 'text-danger' }}">{{ @$data->Beneficiary_PA != null ? @$data->Beneficiary_PA : 'ไม่มีข้อมูล !' }}</span>
    </div>
    <div class="col-3 text-end m-auto ">
        <div class="dropdown">
            <button class="btn btn-outline-primary btn-sm rounded-pill dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="d-flex"> <span class="d-none d-lg-block me-1">แก้ไข</span><i class="bx bx-edit-alt"></i> </span>
            </button>
            <ul class="dropdown-menu" style="cursor:pointer;">
              <li><a  class="dropdown-item modal_lg  fw-semibold" data-link="{{route('contract.edit',@$data->id)}}?type={{'editBeneficiary'}}"><i class="bx bx-edit-alt"></i> แก้ไข </a></li>
              <li class=" {{ @$data->Beneficiary_PA == null ? 'd-none' : '' }}"><a class="dropdown-item text-danger fw-semibold removeRef" onclick="removeRef('removeBeneficiary','cusBeneficiary')"><i class="bx bxs-eraser"></i> นำออก</a></li>
            </ul>
          </div>
    </div>
</div>


