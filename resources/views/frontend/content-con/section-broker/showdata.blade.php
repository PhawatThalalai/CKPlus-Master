
<div class="modal-content">
    <div class="d-flex m-3">
        <div class="flex-shrink-0 me-2">
            <img src="{{ asset('assets/images/gif/avatar.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h5 class="text-primary fw-semibold">ดูข้อมูลผู้แนะนำ (Broker Detail)</h5>
            <p class="text-muted mt-n1 fw-semibold font-size-12">No. : {{ @$data->BrokertoCus->IDCard_cus }}</p>
            <p class="border-primary border-bottom mt-n2 m-2"></p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">

        @component('components.content-contract.scetion-showdata.showdata')
        @slot('data',[
            'title-general' => 'ข้อมูลทั้วไป (Broker General)',
            'title-address' => 'ข้อมูลที่อยู่ผู้แนะนำ (Broker Address)',
            'data' => @$data->BrokertoCus
        ])  
        @endcomponent
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">ปิด</button>
    </div>
</div>

