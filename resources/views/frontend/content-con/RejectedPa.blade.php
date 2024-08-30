<div class="modal-content">
    <div class="d-flex m-3 mb-0">
        <div class="flex-shrink-0 me-4">
            <img src="{{ URL::asset('\assets\images\signature.png') }}" alt="" style="width: 30px;">
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h4 class="text-primary fw-semibold">รายการที่ต้องแก้ไขในการซื้อประกัน (Rejected Details)</h4>
            <p class="text-muted mt-n1 fw-semibold font-size-12">เลขสัญญา : {{@$data_con[0]->LogsToPact->Contract_Con}}</p>
            <p class="border-primary border-bottom mt-n2"></p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" tabindex="-1" aria-label="Close"></button>
    </div>
    <div class="modal-body mx-3">
        @php
            $LogAssets = @$data_con->filter(function ($query)  {
                return  $query->model=='LogRejected-PA';
            });
            // dump($LogAssets);
         @endphp
<div class="table-responsive">
    <table class="align-middle table-nowrap mb-0 table table-hover TB-History" id="">
        <thead class="table-primary">
            <tr>
                <th colspan="1" class="sorting sorting_desc">
                    <div class="cursor-pointer select-none">วันที่</div>
                </th>
                <th colspan="1" class="sorting sorting_desc">
                    <div class="cursor-pointer select-none">Status</div>
                </th>
                <th colspan="1" class="sorting sorting_desc">
                    <div class="cursor-pointer select-none">รายละเอียด</div>
                </th>
                <th colspan="1" class="sorting sorting_desc">
                    <div class="cursor-pointer select-none">ผู้ลงบันทึก</div>
                </th>
                <th>
                    #
                </th>
            </tr>
        </thead>
        <tbody>
            @foreach (@$LogAssets as $item)
            <tr>
                <td>{{ @$item->created_at }}</td>
                <td>{{ @$item->status }}</td>
                <td>@php echo implode("<br/>",explode(',', @$item->details)) @endphp</td>
                <td>{{ @$item->LogsToUser->name }}</td>
                <td>
                    
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


<script>
    $(function(){
        $('.TB-History').DataTable()
    })
</script>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">ปิด</button>
    </div>
</div>
