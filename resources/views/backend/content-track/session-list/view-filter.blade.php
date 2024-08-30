
<div class="row">
    <div class="">
        <p class="fw-semibold" id="tabStatus" style="display:none; cursor:pointer;"> สถานะ :
            <span class="badge rounded-pill bg-success bg-soft text-success fs-6" id="filterStatus"></span>
            <span class="badge rounded-pill bg-danger bg-soft text-danger fs-6" id="" onclick="clearChecked('formStatus')"> <i class="bx bx-trash"></i> </span>
        </p>
        <p class="fw-semibold" id="tabTeam" style="display:none; cursor:pointer;"> ทีมตาม :
            <span class="badge rounded-pill bg-warning bg-soft text-warning fs-6" id="filterTeam"></span>
            <span class="badge rounded-pill bg-danger bg-soft text-danger fs-6" id="" onclick="clearChecked('formTeam')"> <i class="bx bx-trash"></i> </span>
        </p>
        <p class="fw-semibold" id="tabGroupdebt" style="display:none; cursor:pointer;"> กลุ่มค้างงวด :
            <span class="badge rounded-pill bg-primary bg-soft text-primary fs-6" id="filterGroupdebt"></span>
            <span class="badge rounded-pill bg-danger bg-soft text-danger fs-6" id="" onclick="clearChecked('formGroupDebt')"> <i class="bx bx-trash"></i> </span>
        </p>

        <p id="clearBtn" class="card-branch" card-id="allBranch " style="display: none; cursor:pointer;"> <span class="badge rounded-pill bg-danger bg-soft text-danger fs-6" id="" onclick="clearChecked('all')"> <i class="bx bx-trash"></i> ล้างการค้นหา</span></p>
    </div>
</div>

<span class="d-none">
    <span class="notiTag">
        <div class="dropdown d-inline-block text-dark">
            <button type="button" class="py-1 btn border-white noti-icon waves-effect" id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="true" fdprocessedid="2txkh">
                <i class="bx bx-bell bx-tada"></i>
                    <span class="position-absolute top-75 start-75 translate-middle p-1 bg-danger border border-light rounded-circle">
                   </span>
            </button>

            <div class="row dropdown-menu dropdown-menu-lg dropdown-menu-end p-0" aria-labelledby="page-header-notifications-dropdown" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(0px, 72px, 0px);" data-popper-placement="bottom-end">
                <div class="row mb-2">
                    <div class="col-2">
                        <p class="text-primary fs-5"><i class="bx bxs-user-voice"></i> </p>
                    </div>
                    <div class="col text-dark">
                        <p>นัดชำระวันนี้ <span class="fw-semibold">18</span>  รายการ</p>
                    </div>
                    <div class="col-3 border-start text-dark">
                        <p>ดูข้อมูล</p>
                    </div>
                </div>


                <div class="row mb-2">
                    <div class="col-2">
                        <p class="text-primary fs-5"><i class="bx bxs-user-voice"></i> </p>
                    </div>
                    <div class="col text-dark">
                        <p>ดีลวันนี้ <span class="fw-semibold">27</span>  รายการ</p>
                    </div>
                    <div class="col-3 border-start text-dark">
                        <p>ดูข้อมูล</p>
                    </div>
                </div>

            </div>
        </div>
    </span>
</span>
