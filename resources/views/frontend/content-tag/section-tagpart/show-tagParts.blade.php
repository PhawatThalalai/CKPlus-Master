<div class="modal-content">
    {{-- <div class="modal-header">
        <h5 class="modal-title">รายละเอียดติดตาม</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div> --}}
    <div class="d-flex m-3">
        <div class="flex-shrink-0 me-2">
            <img src="{{ asset('assets/images/gif/demand.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h5 class="text-primary fw-semibold">รายละเอียดการติดตาม (Tracking Deatails)</h5>
            <p class="text-muted mt-n1 fw-semibold font-size-12">No. : {{ @$tags->Code_Tag }}</p>
            <p class="border-primary border-bottom mt-n2 m-2"></p>
        </div>
        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
    </div>
    <div class="modal-body">
        <div class="container">
            <div class="row g-2 mb-3">
                <div class="col-xl-3 col-lg-3 col-ms-12 col-sm-12 m-auto text-center">
                    <div class="card text-center ">
                        <div class="card-body">
                            <div class="mb-3">
                                <span class="">
                                    <img class="rounded-circle avatar-md p-1 border border-3 border-light" src="{{ @$tags->TagToDataCus->image_cus != NULL ? URL::asset(@$tags->TagToDataCus->image_cus) : asset('/assets/images/users/user-1.png') }}" alt="">
                                </span>
                            </div>
                            <h5 class="font-size-15 mb-3"><a href="javascript: void(0);" class="text-dark">{{ @$tags->TagToDataCus->Name_Cus }}</a></h5>
                            {{-- <p class="border border-light"></p> --}}
                            <div>
                                <a href="javascript: void(0);" class="badge bg-warning font-size-13">{{ @$tags->TagToStatusCus->Name_Cus }}</a>
                                <a href="javascript: void(0);" class="badge bg-info font-size-13">{{ @$tags->TagToTypeCusRe->Name_CusResource }}</a>
                                @if(@$tags->successor_status == 'active')
                                    <span class="mb-0 badge badge-pill font-size-13 badge-soft-danger fw-semibold mt-1">ส่ง GM</span>
                                @endif
                            </div>
                        </div>
                        {{-- <div class="card-footer">
                           <p class="text-mute fw-semibold">{{ @$tags->TagToDataCus->date_Cus}}</p> 
                        </div> --}}
                    </div>
                </div>
                <div class="col-xl-9 col-lg-9 col-ms-12 col-sm-12">
                    @include('frontend\content-tag\section-tagpart\data-tagParts')
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn btn-sm" data-bs-dismiss="modal">Close</button>
      </div>
</div>