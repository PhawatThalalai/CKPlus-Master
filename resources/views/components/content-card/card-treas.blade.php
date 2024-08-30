<div class="mb-3">
        <div class="card-radio card-com type_loan" data-typeloan = " {{ @$data['typeLoan'] }}" data-tab = {{ @$data['tab'] }}>
            <div class="row">
                <div class="col-3 border-end">
                    <img class="asset-tab img-defualt" src="{{ URL::asset('\assets\images\contract\asset-management.png') }}" alt="" style="width: 75%;">
                </div>
                <div class="col m-auto text-center">
                    <h5 class="fw-semibold">{{ @$data['title'] }} ( {{ @$data['AKACom'] }} )</h5>
                    <span class="badge rounded-pill bg-danger">
                        <span class="span-{{ @$data['AKACom'] }}-{{ @$data['record_stat'] }}">{{ @$data['listCount'] != NULL ? @$data['listCount'] : 0 }} </span>
                        <span class="text-list">รายการ</span>
                    </span>
                </div>
               
            </div>
        </div>

    <div class="row">
        <div class="ms-2 col m-auto">
            {{-- <p class="text-muted mb-1 fw-semibold">ยอดคงเหลือ : <span class="text-success fw-semibold">{{ @$data['creditBalance'] }}</span>  </p> --}}
            <p class="text-muted my-2 fw-semibold">จัดการยอดเคดิต  </p>
        </div>
        <div class="ms-2 col text-end mt-1">
            <button type="button" class="btn btn-success btn-sm rounded-pill modal_md" data-link="{{ route('treas.create') }}?page={{'addCredit'}}&com={{ @$data['com'] }}">Credit-Add <i class="bx bxs-plus-circle"></i></button>
        </div>
    </div>
</div>