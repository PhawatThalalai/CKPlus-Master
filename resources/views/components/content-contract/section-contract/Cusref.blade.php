<h5 class="fw-semibold text-primary"><i class="bx bx-user-check"></i> บุคคลอ้างอิง</h5>
<div class="row bg-light py-3">
    <div class="col m-auto">
        <span class="fw-semibold fs-3"><i class="bx bx-user-check text-success"></i> </span>
    </div>
    <div class="col-7 m-auto">
        <span class="fw-semibold RefText {{ @$data->Cus_Ref != null ? '' : 'text-danger' }}">{{ @$data->Cus_Ref != null ? @$data->Cus_Ref : 'ไม่มีข้อมูล !' }}</span>
    </div>
    <div class="col-3 text-end m-auto  ">
        <div class="dropdown">
            <button class="btn btn-outline-primary btn-sm rounded-pill dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            <span class="d-flex"> <span class="d-none d-lg-block me-1">แก้ไข</span><i class="bx bx-edit-alt"></i> </span>
            </button>
            <ul class="dropdown-menu" style="cursor:pointer;">
              <li><a  class="dropdown-item modal_lg  fw-semibold" data-link="{{route('contract.edit',@$data->id)}}?type={{'editRef'}}"><i class="bx bx-edit-alt"></i> แก้ไข </a></li>
              <li class=" {{ @$data->Cus_Ref == null ? 'd-none' : '' }}"><a class="dropdown-item text-danger fw-semibold removeRef" onclick="removeRef()"><i class="bx bxs-eraser"></i> นำออก</a></li>
            </ul>
          </div>
    </div>
</div>


