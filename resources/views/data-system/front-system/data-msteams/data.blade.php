<div class="card p-2 h-100">
    <div class="d-flex">
        <div class="flex-shrink-0 me-2 mt-1">
            <!-- <img src="assets/images/signature.png" alt="" style="width: 40px;"> -->
            <img class="" src="{{ URL::asset('assets/images/gif/wired-qr-code.gif') }}" alt="" style="width:50px;">
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h5 class="text-primary fw-semibold pt-2 font-size-15">MS Teams ( MS Teams Management )</h5>
            <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>มี {{count(@$data)}} รายการ</h6>
            <p class="border-primary border-bottom mt-2"></p>
        </div>
    </div>

    <div class="table-responsive" data-simplebar="init" style="max-height: 390px;">
        <table class="table align-middle table-hover">
            <thead class="table-light sticky-top">
                <tr>
                    <th scope="col" style="width: 70px;">#</th>
                    <th scope="col">ClientSecret_Id</th>
                    <th scope="col">Tenant_Id</th>
                    <th scope="col">Client_Id</th>
                    <th scope="col">Teams_Chanel</th>
                    <th scope="col">Group_Id</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $value)
                    <tr>
                        <td>
                            <div class="avatar-xs">
                                <span class="avatar-title rounded-circle bg-warning bg-gradient">
                                    {{$key+1}}
                                </span>
                            </div>
                        </td>
                        <td>{{@$value->ClientSecret_Id}}</td>
                        <td>{{@$value->Tenant_Id}}</td>
                        <td>{{@$value->Client_Id}}</td>
                        <td>{{@$value->Teams_Chanel}}</td>
                        <td>{{@$value->Group_Id}}</td>
                        <td>{{@$value->Teams_Active}}</td>
                        <td>
                            <ul class="list-inline font-size-20 contact-links mb-0">
                                <li class="list-inline-item px-2">
                                    <a class="dropdown-item edit-details Modal-xl" data-bs-toggle="modal" data-bs-target="#Modal-xl" data-link="{{ route('dataStatic.edit', $value->id) }}?page={{'frontend'}}&modal={{'ms-teams'}}&mode={{'edit'}}" style="cursor:pointer;">
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