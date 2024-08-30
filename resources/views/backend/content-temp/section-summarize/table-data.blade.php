<style>
     table {
        font-size: 13px;
    }

</style>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable" class="table table-bordered align-middle nowrap">
                        <thead>
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">สาขา</th>
                                <th scope="col">เลขที่สัญญา</th>
                                <th scope="col">ชื่อลูกค้า</th>
                                <th scope="col">วันที่ทำสัญญา</th>
                                <th scope="col">ยอดผ่อนชำระ</th>
                                <th scope="col">ค้างงวด</th>
                                <th scope="col">ค้างจาก</th>
                                <th scope="col">ค้างถึง</th>
                                <th scope="col">เงินค้างงวด</th>
                                <th scope="col">กู้บันทึก</th>
                                <th scope="col">วันหยุดรับรู้</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $count = 1;
                            @endphp
                            @foreach ($res_data as $item)
                                <tr>
                                    <th scope="row">{{ $count++ }}</th>
                                    @if ($table == 'HP')
                                        <td>{{ @$item->StopVATLocat->NickName_Branch }}</td>
                                    @else
                                        <td>{{ @$item->StopVATLocat->NickName_Branch }}</td>
                                    @endif
                                    <td>{{ $item->CONTNO }}</td>
                                    <td>{{ $item->UserStopVat->Name_Cus }}</td>
                                    <td>{{ $item->SDATE }}</td>
                                    <td>{{ $item->TOTPRC }}</td>
                                    <td><span class="badge badge-soft-success">{{ $item->EXP_PRD }}</span></td>
                                    <td>{{ $item->EXP_FRM }}</td>
                                    <td>{{ $item->EXP_TO }}</td>
                                    <td>{{ $item->EXP_AMT }}</td>
                                    <td>{{ $item->EXP_AMT }}</td>
                                    <td>{{ $item->STOPVDT }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="assets/js/pages/datatables.init.js"></script>
