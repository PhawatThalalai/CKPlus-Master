<div class="card p-2 h-100">
    <div class="d-flex">
        <div class="flex-shrink-0 me-2 mt-1">
            <!-- <img src="assets/images/signature.png" alt="" style="width: 40px;"> -->
            <img class="" src="{{ URL::asset('assets/images/gif/wired-qr-code.gif') }}" alt="" style="width:50px;">
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h5 class="text-primary fw-semibold pt-2 font-size-15">เลขที่สัญญาสัญญา ( Contract Numbers )</h5>
            <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>มี {{count(@$data)}} รายการ</h6>
            <p class="border-primary border-bottom mt-2"></p>
        </div>
    </div>

    <div class="table-responsive" data-simplebar="init" style="max-height: 390px;">
        <table class="table align-middle table-nowrap table-hover">
            <thead class="table-light sticky-top">
                <tr>
                    <th scope="col" style="width: 70px;">#</th>
                    <th scope="col">ประเภทสัญญา</th>
                    <th scope="col">เลขที่สัญญา</th>
                    <th scope="col">สาขา</th>
                    <th scope="col">user</th>
                    <th scope="col">FLAG</th>
                    <th scope="col">Created</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $value)
                    <tr class="">
                        <td>
                            <div class="avatar-xs">
                                <span class="avatar-title rounded-circle bg-warning bg-gradient">
                                    {{$key+1}}
                                </span>
                            </div>
                        </td>
                        <td>{{@$value->Type_Contract}}</td>
                        <td>{{@$value->Code_Contract}}</td>
                        <td>
                            <p class="mb-0">{{@$value->ContractToBranch->Name_Branch}}</p>
                        </td>
                        <td>
                            <p class="mb-0">{{$value->UserAdd_Contract}}</p>
                        </td>
                        <td>
                            <p class="mb-0">{{$value->Flag_Contract}}</p>
                        </td>
                        <td>
                            <h5 class="font-size-12 mb-1"><a href="javascript: void(0);" class="text-muted">{{@$value->created_at}}</a></h5>
                            <p class="badge badge-soft-primary font-size-10 mb-0">{{(@$value->created_at != NULL)?@$value->created_at->diffForHumans():''}}</p>
                        </td>
                        <td>
                            <ul class="list-inline font-size-20 contact-links mb-0">
                                <li class="list-inline-item px-2">
                                    <a class="dropdown-item edit-details Modal-xl" data-bs-toggle="modal" data-bs-target="#Modal-xl" data-link="{{ route('dataStatic.edit', $value->id) }}?page={{'frontend'}}&modal={{'contract-number'}}&mode={{'edit'}}" style="cursor:pointer;">
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