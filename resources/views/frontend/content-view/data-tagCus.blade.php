<div class="card p-2 table-responsive h-100" id="appendTB" style="overflow: hidden;">
    <div class="d-flex m-3">
        <div class="flex-shrink-0 me-4 mt-2">
            <img class=" " src="assets/images/add-user.png" alt="" style="width: 50px;">
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h5 class="text-primary fw-semibold pt-2">รายการติดตามลูกค้า (Data Tracking Customers)</h5>
            <h6 class="text-secondary fw-semibold"><i class="bx bxs-map me-1"></i> สาขา {{@$dataBranch2->Name_Branch}}</h6>
            <p class="border-primary border-bottom mt-2"></p>
            <input type="hidden" id="id_branch" value="{{ @$dataBranch2->id }}">
        </div>
    </div>
    @php
        // สุ่มสีของ UserInsert แต่ละคน ให้แสดงสีต่างกัน
        $_userInsert_color = array();
        $_userInsert_name = @$dataCus->groupBy('user_insert_name')->toArray();
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
                <th class="">เบอร์โทร</th>
                <th class="">วันที่รับ<br/>วันที่ติดตาม</th>
                <th class="">Tags</th>
                <th class="">ประเภทสินเชื่อ</th>
                <th class="">ผู้ลงบันทึก</th>
                <th class="">#</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataCus as $row)
                <tr>
                    <td class="">
                        <div>
                            <img class="rounded-circle avatar-xs" src="{{ isset($row->image_cus) ? URL::asset(@$row->image_cus) : asset('/assets/images/users/user-1.png') }}" alt="">
                        </div>
                    </td>
                    <td>
                        <h5 class="font-size-13 mb-1"><a role="button" class="text-dark">
                            {{-- ของเก่า   @$row->Prefix }} : {{ @$row->Name_Cus --}}
                            {{ @$row->Name_Cus }}
                        </a></h5>
                        @if (@$row->Status_Cus == 'active')
                            <span class="mb-0 badge badge-pill font-size-12 badge-soft-success">สถานะ : ปกติ</span>
                        @elseif (@$row->Status_Cus == 'cancel')
                            <span class="mb-0 badge badge-pill font-size-12 badge-soft-warning">สถานะ : ยกเลิก</span>
                        @else
                            <span class="mb-0 badge badge-pill font-size-12 badge-soft-danger">สถานะ : blacklist</span>
                        @endif

                        @if(@$row->successor_status == 'active')
                            <span class="mb-0 badge badge-pill font-size-12 badge-soft-danger fw-semibold">ส่ง GM</span>
                        @endif

                    </td>
                    <td class="">
                        @if ( !empty( getFirstPhone_php(@$row->Phone_cus) ) )
                            <div class="d-flex align-items-center mb-1">
                                <span class="badge badge-soft-info rounded-pill py-1 me-1">
                                    <i class="fas fa-phone font-size-10 pe-1"></i>1
                                </span>
                                {{formatPhoneNumber( getFirstPhone_php(@$row->Phone_cus), '99 9999 9999' )}}
                            </div>
                        @endif
                        @php
							$phone_cus_2 = "";
							if ( empty(@$row->Phone_cus2) ) {
								$_phone_numbers = explode(',', @$row->Phone_cus);
								if ( isset($_phone_numbers[1]) ) {
									$phone_cus_2 = $_phone_numbers[1];
								}
							} else {
								$phone_cus_2 = @$row->Phone_cus2;
							}
						@endphp
						@if ( !empty( $phone_cus_2 ) )
                            <div class="d-flex align-items-center mb-1">
                                <span class="badge badge-soft-info rounded-pill py-1 me-1">
                                    <i class="fas fa-phone font-size-10 pe-1"></i>2
                                </span>
                                {{formatPhoneNumber( $phone_cus_2, '99 9999 9999' )}}
                            </div>
						@endif
                        
                        {{-- ของเก่า
                        <i class="btn btn-soft-info btn-sm rounded-pill fas fa-phone"></i>
                        {{ @$row->Phone_cus }}
                        --}}

                    </td>
                    <td class="">
                        <i class="btn btn-soft-warning btn-sm rounded-pill bx bx-calendar-event"></i>
                        <p>{{ date_format(date_create(@$row->date_Tag), 'Ymd') }} </p>
                        {{ date('d-m-Y', strtotime(substr(@$row->date_Tag, 0, 10))) }}
                    <br/>
                        @if( @$row->flag_reject =='y')
                            <i class="bx bx-error text-danger bx-tada fs-4 error " data-toggle="tooltip" title="ล่าช้า" ></i>
                        @else
                            <i class="btn btn-soft-warning btn-sm rounded-pill bx bx-calendar-event"></i>
                        @endif
                        <p>{{ date_format(date_create(@$row->QueryTagPart->date_TrackPart), 'Ymd') }} </p>
                        {{  @$row->QueryTagPart->date_TrackPart !=NULL ? date('d-m-Y', strtotime(substr(@$row->QueryTagPart->date_TrackPart , 0, 10))):'' }}

                    </td>
                    <td>
                        @if (isset($row->Code_Tag))
                            <h5 class="font-size-12 mb-1"><a role="button" class="text-dark">Tag : {{ @$row->Code_Tag }}</a></h5>
                            @if (@$row->Status_Tag == 'complete')
                                <span class="mb-0 badge badge-pill font-size-12 badge-soft-success">สถานะ : ส่งจัดไฟแนนซ์</span>
                            @elseif (@$row->Status_Tag == 'inactive')
                                <span class="mb-0 badge badge-pill font-size-12 badge-soft-danger">สถานะ : ยกเลิกติดตาม</span>
                            @elseif (@$row->Status_Tag == 'active' && count($row->TagToTagPart) > 0 )
                                <span class="mb-0 badge badge-pill font-size-12 badge-soft-warning">สถานะ : ติดตาม</span>
                            @else
                                <span class="mb-0 badge badge-pill font-size-12 badge-soft-danger">สถานะ : ไม่พบข้อมูล</span>
                            @endif
                        @else
                            <h5 class="font-size-12 mb-1"><a role="button" class="text-secondary fst-italic text-opacity-50">ไม่พบข้อมูล</a></h5>
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
                    <td class="" data-userinsert="{{ @$row->user_insert_name }}">
                        <i class="btn btn-sm rounded-pill fas fa-user" style="color: {{$_userInsert_color[@$row->user_insert_name]}}"></i>
                        {{ getFirstName(@$row->user_insert_name) }}
                    </td>
                    <td class="">
                        <ul class="list-inline font-size-20 contact-links mb-0">
                            <li class="list-inline-item ">
                                <a data-link="{{ route('cus.show', @$row->cusid) }}?funs={{ 'view-tagparts' }}" title="ข้อมูลการติดตาม" class="data-modal-xl" style="cursor: pointer;"><i class="bx bx-message-alt-dots hover-up text-info bg-soft"></i></a>
                            </li>
                            <li class="list-inline-item ">
                                <a href="{{ route('cus.index') }}?page={{ 'profile-cus' }}&id={{ @$row->cusid }}" title="Profile"><i class="bx bx-user-circle hover-up text-warning bg-soft"></i></a>
                            </li>
                        </ul>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>

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
