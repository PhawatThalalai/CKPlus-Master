<style>
    div.dataTables_processing div {
        display: none;

    }
    div.dataTables_processing {
        display: none;
        background-color: transparent;
        
    }
</style>
<div id="showAll">
   @php
        $branchArr = $branch->pluck('NickName_Branch', 'id')->all()  ;
   @endphp
    <div class="table-responsive mt-2 " style="overflow-x:hidden">
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
            {{-- <div class="row">
            <div class="col-sm-12 col-md-6">
                <div class="dataTables_length" id="DataTables_Table_0_length"><label>Show <select
                            name="DataTables_Table_0_length" aria-controls="DataTables_Table_0"
                            class="custom-select custom-select-sm form-control form-control-sm form-select form-select-sm">
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select> entries</label></div>
            </div>
            <div class="col-sm-12 col-md-6">
                <div id="DataTables_Table_0_filter" class="dataTables_filter"><label>Search:<input
                            type="search" class="form-control form-control-sm" placeholder=""
                            aria-controls="DataTables_Table_0"></label></div>
            </div>
            </div> --}}
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="table-resposive">
                        <table id="show-all-table"
                            class="table dailytable table-hover datatable  nowrap dataTable no-footer dtr-inline">
                            <thead>
                                <tr role="row">
                                    <th>#</th>
                                    <th>สาขา</th>
                                    <th>เลขที่สัญญา</th>
                                    <th>ชื่อ-สกุล</th>

                                    <th>BILLCOLL</th>
                                    <th>พนง.ขาย</th>
                                    <th>วันดิวงวด</th>
                                    <th>ผ่อนงวดละ</th>
                                    <th>เงินค้างงวด</th>
                                    <th>รวมยอด</th>
                                    <th>ค้างจริง</th>
                                    <th>กลุ่มค้างงวด</th>
                                    <th>วันชำระล่าสุด</th>
                                    <th>ยอดชำระล่าสุด</th>
                                    <th>ยอดจ่ายขั้นต่ำ</th>                
                                    <th>ผ่านเกณฑ์</th>

                                </tr>

                            </thead>

                            <tbody>

                            @if ($data != null)
                                @foreach ($data as $key => $item)
                                    <tr class="odd">
                                        <td class="sorting_1 dtr-control">{{ @$loop->iteration }}</td>
                                        <td> {{$branchArr[$item->LOCAT]}} </td>
                                        <td>{{ $item->CONTNO }}</td>
                                        <td>{{ $item->Name_Cus }}</td>
                                        <td>
                                            {{@$branchArr[$item->BILLCOLL]}}
                                        </td>
                                        <td>{{ $item->SALECOD }}</td>
                                        <td>{{ $item->DUEDATE }}</td>
                                        <td>{{$item->TOTUPAY}}</td>
                                        <td>{{ $item->KDAMT }}</td>
                                        <td>{{ ($item->TOTUPAY+$item->KDAMT) }}</td>
                                        <td>{{ $item->NEXT_EXPREAL }}</td>
                                        <td>{{ $item->SWEXPPRD }}</td>
                                        <td>{{ $item->LPAYD }}</td>
                                        <td>{{ $item->LPAYA }}</td>
                                        <td>{{ $item->MinPay }}</td>                                                            
                                        <td><span class="badge bg-success font-size-10">{{ $item->stdept }}</span></td>

                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                        </table>
                    </div>


                </div>
            </div>

        </div>
    </div>
</div>

<script>
    $(function() {
        $("#show-all-table").DataTable({
            "responsive": false,
            "autoWidth": false,
            "ordering": true,
            "lengthChange": true,
            "order": [
                [0, "asc"]
            ],
            "pageLength": 10,
            "scrollX": true,
        });
    })
</script>

{{-- 
<script>
    $("#dailytable").DataTable({
        "responsive": false,
        "autoWidth": false,
        "ordering": true,
        "lengthChange": true,
        "order": [
            [0, "asc"]
        ],
        "pageLength": 5,
        "scrollX": true,
    });
</script> --}}
