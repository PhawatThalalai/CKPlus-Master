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
            </tr>
        </thead>
        <tbody>
            @foreach (@$data['data'] as $item)
            <tr>
                <td>{{ @$item->created_at }}</td>
                <td>{{ @$item->status }}</td>
                <td>@php echo implode("<br/>",explode(',', @$item->details)) @endphp</td>
                <td>{{ @$item->LogsToUser->name }}</td>

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
