<div class="card card-hover rounded-3 mb-2 me-2 card-branch" card-id="{{ @$data['id_branch'] }}" style="max-width: 250px; min-width: 250px; cursor:pointer;">
    <div class="card-body">
        <div class="d-flex justify-content-between mt-2">
            <div class="avatar-sm">
                <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                    <img src="{{ URL::asset('/assets/images/CK-location.png') }}" class="bg-light p-1 w-100 rounded-circle" alt="">
                </div>
            </div>
            <div class="text-end">
                {{-- <h5 class="mb-0">120</h5> --}}
                <span class="badge rounded-3 bg-warning text-dark fs-6 fw-semibold mb-2">{{ $data['NickName_Branch'] }}</span>
                <h6 class="fw-semibold">{{ $data['Name_Branch'] }}</h6>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col text-center div-countDoc-{{ @$data['id_branch'] }}">
                @if ($data['countData'])
                    <button type="button" id="countDoc_{{ @$data['id_branch'] }}" class="btn btn-danger btn-sm btn-rounded waves-effect waves-light up-down">
                        <i class="mdi mdi-email-plus up-down me-1"></i>เอกสารใหม่  {{ $data['countData'] }} รายการ
                    </button>
                @else
                    <span class="text-secondary text-opacity-50"><em>-- ว่าง --</em></span>
                @endif
            </div>
        </div>
    </div> 
</div>
