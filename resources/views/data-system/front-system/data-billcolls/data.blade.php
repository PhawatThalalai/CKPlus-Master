<div class="card p-2 h-100">
    <div class="d-flex">
        <div class="flex-shrink-0 me-2 mt-1">
            <!-- <img src="assets/images/signature.png" alt="" style="width: 40px;"> -->
            <img class="" src="{{ URL::asset('assets/images/gif/wired-qr-code.gif') }}" alt="" style="width:50px;">
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h5 class="text-primary fw-semibold pt-2 font-size-15">พนักงานเก็บเงิน ( BillColl )</h5>
            <h6 class="text-secondary fw-semibold font-size-12"><i class="fas fa-users me-1"></i>มี {{count(@$data)}} รายการ</h6>
            <p class="border-primary border-bottom mt-2"></p>
        </div>
    </div>

    <div class="table-responsive" data-simplebar="init" style="max-height: 390px;">
        <table class="table align-middle table-nowrap table-hover text-center">
            <thead class="table-light sticky-top">
                <tr>
                    <th scope="col" style="width: 70px;">#</th>
                    <th scope="col">พนักงานเก็บเงิน</th>
                    <th scope="col">ประเภท</th>
                    <th scope="col">หมายเหตุ</th>
                    <th scope="col">สถานะ</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $value)
                    <tr @class(['table-danger text-danger text-decoration-line-through' => $value->status == null])>
                        <td>
                            <div class="avatar-xs">
                                <span class="avatar-title rounded-circle bg-warning bg-gradient">
                                    {{$key+1}}
                                </span>
                            </div>
                        </td>
                        <td class="text-start">
                            <p class="mb-0 fw-semibold">{{@$value->code_billcoll}}</p>
                            <p class="mb-0">{{@$value->name_billcoll}}</p>
                        </td>
                        <td class="text-start">
                            @if(@$value->type_billcoll == 'B')
                                <span class="badge badge-soft-info font-size-12">ประเภทสาขา</span>
                                @if( @$value->BillCollToBranch )
                                    <p class="text-muted fs-14 mb-0"><i class="mdi mdi-map-marker"></i>{{@$value->BillCollToBranch->first()->Name_Branch}}</p>
                                @endif
                            @else
                                <span class="badge badge-soft-dark font-size-12">ประเภทอื่น</span>
                            @endif
                        </td>
                        <td>
                            <p class="text-muted mb-0 small">
                                @php
                                    echo nl2br(@$value->note_billcoll,false);
                                @endphp
                            </p>
                        </td>
                        <td>
                            @if(@$value->status == 'Y')
                                <i class="fas fa-check-circle fs-4 text-success" data-bs-toggle="tooltip" title='กำลังใช้งาน'></i>
                            @else
                                <i class="fas fa-times-circle fs-4 text-danger" data-bs-toggle="tooltip" title='ยกเลิก'></i>
                            @endif
                        </td>
                        <td>
                            <ul class="list-inline font-size-20 contact-links mb-0">
                                <li class="list-inline-item px-2">
                                    <a class="dropdown-item edit-details Modal-xl" data-bs-toggle="modal" data-bs-target="#Modal-xl" data-link="{{ route('dataStatic.edit', $value->id) }}?page={{'frontend'}}&modal={{'billcolls'}}&mode={{'edit'}}" style="cursor:pointer;">
                                        <i class="bx bx-edit-alt"></i>
                                    </a>
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
