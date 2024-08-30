<div class="d-flex gap-3">
    <div class="card px-2 py-2" style="width: 50%">
        <div class="d-flex pb-2 align-items-end gap-1">
            <img src="{{ URL::asset("assets/images/gif/search.gif") }}" style="width: 45px" alt="">
            <span style="font-size: 18px; font-weight: 700;">สถานะกำลังขอเอกสาร</span>
        </div>
        <div class="table-responsive" data-simplebar="init" style="max-height: 390px;">
            <table class="table align-middle table-nowrap table-hover">
                <thead class="table-light sticky-top">
                    <tr>
                        <th scope="col" style="width: 70px;">#</th>
                        <th scope="col">ชื่อผู้เบิก</th>
                        <th scope="col">ประเภทเอกสารที่เบิก</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataList as $key => $value)
                        <tr>
                            <td>
                                <div class="avatar-xs">
                                    <span class="avatar-title rounded-circle bg-warning bg-gradient">
                                        {{$key+1}}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <p class="text-muted mb-0">{{@$value->ToUser->name}}</p>
                            </td>
                            <td>
                                <p class="text-muted mb-0">{{@$value->ToTypeTake->name_th}}</p>
                            </td>
                            <td>
                                <p class="text-muted mb-0">{{@$value->flag_st}}</p>
                            </td>
                            <td>
                                <ul class="list-inline font-size-20 contact-links mb-0">
                                    {{-- <li class="list-inline-item px-2">
                                        <a class="dropdown-item edit-details Modal-xl" data-bs-toggle="modal" data-bs-target="#Modal-xl" data-link="{{ route('dataStatic.edit', $value->id) }}?page={{'frontend'}}&modal={{'branches'}}&mode={{'edit'}}" style="cursor:pointer;">
                                            <i class="bx bx-edit-alt"></i>
                                        </a>
                                    </li> --}}
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="card px-2 py-2" style="width: 50%">
        <div class="d-flex pb-2 align-items-end gap-1">
            <img src="{{ URL::asset("assets/images/gif/approved.gif") }}" style="width: 45px" alt="">
            <span style="font-size: 18px; font-weight: 700;">ยืนยันการเบิกเรียบร้อยแล้ว</span>
        </div>
        <div class="table-responsive" data-simplebar="init" style="max-height: 390px;">
            <table class="table align-middle table-nowrap table-hover">
                <thead class="table-light sticky-top">
                    <tr>
                        <th scope="col" style="width: 70px;">#</th>
                        <th scope="col">ชื่อผู้เบิก</th>
                        <th scope="col">ประเภทเอกสารที่เบิก</th>
                        <th scope="col">ชื่อผู้ตรวจสอบ</th>
                        <th scope="col">สถานะเอกสาร</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dataList as $key => $value)
                        <tr>
                            <td>
                                <div class="avatar-xs">
                                    <span class="avatar-title rounded-circle bg-warning bg-gradient">
                                        {{$key+1}}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <p class="text-muted mb-0">{{@$value->ToUser->name}}</p>
                            </td>
                            <td>
                                <p class="text-muted mb-0">{{@$value->ToTypeTake->name_th}}</p>
                            </td>
                            <td>
                                <p class="text-muted mb-0 bg-primary px-2 text-white rounded-3 bg-opacity-50">{{@$value->PERSON !== null ? @$value->PERSON : 'ยังไม่ตรวจสอบ'}}</p>
                            </td>
                            <td>
                                <p class="text-muted mb-0">{{@$value->flag_st}}</p>
                            </td>
                            <td>
                                <ul class="list-inline font-size-20 contact-links mb-0">
                                    {{-- <li class="list-inline-item px-2">
                                        <a class="dropdown-item edit-details Modal-xl" data-bs-toggle="modal" data-bs-target="#Modal-xl" data-link="{{ route('dataStatic.edit', $value->id) }}?page={{'frontend'}}&modal={{'branches'}}&mode={{'edit'}}" style="cursor:pointer;">
                                            <i class="bx bx-edit-alt"></i>
                                        </a>
                                    </li> --}}
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>