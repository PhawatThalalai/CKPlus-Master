<div class="card p-2 table-responsive h-100" id="appendTB" style="overflow: hidden;">
    <div class="d-flex m-3">
        <div class="flex-shrink-0 me-4 mt-2">
            <img class=" " src="assets/images/add-user.png" alt="" style="width: 50px;">
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h5 class="text-primary fw-semibold pt-2">สัญญาประกัน PA ไม่สมบูรณ์ (CONTRACTS PA REJECTED)</h5>
            <h6 class="text-secondary fw-semibold"><i class="bx bxs-map me-1"></i> สาขา {{@$dataBranch2->Name_Branch}}</h6>
            <p class="border-primary border-bottom mt-2"></p>
            <input type="hidden" id="id_branch" value="{{ @$dataBranch2->id }}">
        </div>
    </div>
    @php
        // สุ่มสีของ UserInsert แต่ละคน ให้แสดงสีต่างกัน
        $_userInsert_color = array();
        $_userInsert_name = @$dataCon->groupBy('user_insert_name')->toArray();
        if ($_userInsert_name != null) {
            $_userInsert_name = array_keys($_userInsert_name);
        } else {
            $_userInsert_name = array();
        }
        // เลือกสีที่จะให้สุ่ม เลือกสีที่แตกต่างกันชัด ๆ
        $_colorArray = array(
            'var(--bs-blue)',
            //'var(--bs-indigo)',
            'var(--bs-purple)',
            'var(--bs-pink)',
            //'var(--bs-red)',
            //'var(--bs-orange)',
            'var(--bs-yellow)',
            'var(--bs-green)',
            //'var(--bs-teal)',
            'var(--bs-cyan)'
        );
        shuffle($_colorArray);
        $_colorArraySize = count($_colorArray);
        foreach ($_userInsert_name as $key => $value) {
            $_userInsert_color[$value] = $_colorArray[$key % $_colorArraySize];
        }
    @endphp
<div class="table-responsive">
    <table class="viewWalkin dateHide table align-middle table-hover text-nowrap createContract border border-light font-size-12" id="table1">
        <thead>
            <tr class="bg-light">
                <th class="">#</th>
                <th class="">ชื่อ-สกุล</th>
                <th class="">วันที่ทำสัญญา <br> วันที่โอนเงิน</th>
                <th class="">เลขที่สัญญา</th>
                <th class="">ประเภทสินเชื่อ</th>
                <th class="">#</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataCon as $row)
                <tr>
                    <td class="">
                        <div>
                            <img class="rounded-circle avatar-xs" src="{{ isset($row->image_cus) ? URL::asset(@$row->image_cus) : asset('/assets/images/users/user-1.png') }}" alt="">
                        </div>
                    </td>
                    <td>
                        <h5 class="font-size-13 mb-1"><a role="button" class="text-dark">{{ @$row->Prefix }} : {{ @$row->Name_Cus }}</a></h5>
                        @if (@$row->ViewtoDataCus->Status_Cus == 'active')
                            <span class="mb-0 badge badge-pill font-size-12 badge-soft-success">สถานะ : ปกติ</span>
                        @elseif (@$row->ViewtoDataCus->Status_Cus == 'cancel')
                            <span class="mb-0 badge badge-pill font-size-12 badge-soft-warning">สถานะ : ยกเลิก</span>
                        @else
                            <span class="mb-0 badge badge-pill font-size-12 badge-soft-danger">สถานะ : blacklist</span>
                        @endif

                        @if(@$row->successor_status == 'active')
                            <span class="mb-0 badge badge-pill font-size-12 badge-soft-danger fw-semibold">ส่ง GM</span>
                        @endif

                    </td>
                    <td class="">
                        <i class="btn btn-soft-warning btn-sm rounded-pill bx bx-calendar-event"></i>
                        {{@$row->Date_con}}<br>
                        <i class="btn btn-soft-warning btn-sm rounded-pill bx bx-calendar-event"></i>
                        {{ date_format(date_create(@$row->Date_monetary), 'Y-m-d')}}
                    </td>
                    <td>

                            <h5 class="font-size-12 mb-1"><a role="button" class="text-dark">Contno. : {{ @$row->Contract_Con }}</a></h5>
                            @if (@$row->Status_Con == 'transfered')
                                <span class="mb-0 badge badge-pill font-size-12 badge-soft-success">สถานะ : โอนเงินเรียบร้อย</span>
                            @elseif (@$row->Status_Con == 'close')
                                <span class="mb-0 badge badge-pill font-size-12 badge-soft-danger">สถานะ : ปิดบัญชี</span>
                            @elseif (@$row->Status_Con == 'cancel' && count($row->TagToTagPart) > 0 )
                                <span class="mb-0 badge badge-pill font-size-12 badge-soft-warning">สถานะ : ยกเลิกสัญญา</span>
                            @else
                                <span class="mb-0 badge badge-pill font-size-12 badge-soft-danger">สถานะ : ไม่พบข้อมูล</span>
                            @endif

                    </td>
                    <td class="">
                        @if (isset($row->Loan_Name))
                            <button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
                                {{ @$row->Loan_Name }}
                            </button>
                        @else
                            <h5 class="font-size-12 mb-1"><a role="button" class="text-secondary fst-italic text-opacity-50">ไม่พบข้อมูล</a></h5>
                        @endif
                    </td>
                    <td class="">
                        <ul class="list-inline font-size-20 contact-links mb-0">
                            <li class="list-inline-item ">
                                <a class="text-danger btn btn-soft-danger btn-rounded btn-sm data-modal-xl-2" data-link="{{ route('view.show',@$row->id_con) }}?funs={{'getLogRejectedPA'}}">
                                    รายละเอียด <i class="mdi mdi-alert-rhombus bx-tada"></i>
                                </a>
                                <button type="button" onclick="sendPAAgain('{{@$row->id_con}}')" class="btn btn-soft-info btn-sm btn-rounded btn-sendAgain">ยื่นประกัน <i class="mdi mdi-reload"></i></button>
                            </li>
                            <li class="list-inline-item ">
                                <a href="{{ route('cus.index') }}?page={{ 'profile-cus' }}&id={{ @$row->DataCus_id }}" title="Profile"><i class="bx bx-user-circle hover-up text-warning bg-soft"></i></a>

                            </li>
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>


{{-- test btn PA --}}
<script>
    sendPAAgain = (id_con) =>{
Swal.fire({
        icon : 'info',
        title: "ยืนยันการส่งข้อมูลประกัน ?",
        showCancelButton: true,
        confirmButtonText: "ยื่นขอประกัน",
    }).then((result) => {
        if (result.isConfirmed) {
            $('.btn-sendAgain').prop('disabled',true);
			$(".loading-overlay").attr('style', ''); //** แสดงตัวโหลด **
            $.ajax({
                url : "{{ route('ControlCenter.create') }}",
                type : "GET",
                data : {
                    id_con : id_con,
                    funs : 'sendPaAgain',
                    _token : '{{ @CSRF_TOKEN() }}'
                },
                success : ()=>{
					$(".loading-overlay").attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                    $('.btn-sendAgain').prop('disabled',false);
                    swal.fire({
                        icon : 'success',
                        title : "สำเร็จ !",
                        text : "ยื่นขอประกันทาง Chubb เรียบร้อย",
                        timer : 2000,
                    })
                },
                error : (err)=>{
					$(".loading-overlay").attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                    let html =                 `
                    <p>ไม่สามารถยื่นขอประกันได้ กรุณาตรวจสอบข้อมูลให้เรียบร้อย ${id_con}</p>
                    <a onclick="swal.close();" class="btn btn-danger waves-effect waves-light data-modal-xl-2" data-link="{{ route('view.show', 'MY_CONSTANT') }}?funs={{ 'getLogRejectedPA' }}">
                        <i class="bx bxs-map me-1"></i> กดเพื่อดูรายละเอียด
                    </a> `;
                    $('.btn-sendAgain').prop('disabled',false);
                    Swal.fire({
                    icon : "error",
                    title: "ยื่นประกันไม่สำเร็จ !",
                    html: html.replace("MY_CONSTANT",id_con),
                    showConfirmButton: false
                });
                }
            })
        }
    });
    }
</script>

<script>

$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    var table = $('.viewWalkin').DataTable({
        "responsive": false,
        // "autoWidth": true,
        "ordering": true,
        "lengthChange": true,
        "order": [
            [0, "asc"]
        ],
        "pageLength": 10,
    });
});
</script>
