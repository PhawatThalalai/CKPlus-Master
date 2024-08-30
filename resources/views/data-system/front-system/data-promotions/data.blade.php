<div class="card p-2 h-100">
    <div class="d-flex">
        <div class="flex-shrink-0 me-2 mt-1">
            <!-- <img src="assets/images/signature.png" alt="" style="width: 40px;"> -->
            <img class="" src="{{ URL::asset('assets/images/gif/wired-qr-code.gif') }}" alt="" style="width:50px;">
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h5 class="text-primary fw-semibold pt-2 font-size-15">จัดการโปรโมชั่น ( Promotions )</h5>
            <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>มี {{count(@$data)}} รายการ</h6>
            <p class="border-primary border-bottom mt-2"></p>
        </div>
    </div>
    <div class="table-responsive" data-simplebar="init" style="max-height: 390px;">
        <table class="table align-middle table-nowrap table-hover">
            <thead class="table-light sticky-top">
                <tr>
                    <th scope="col" style="width: 70px;">#</th>
                    <th scope="col">Code โปรโมชั่น</th>
                    <th scope="col">ชื่อโปรโมชั่น</th>
                    <th scope="col">สถานะลด</th>
                    <th scope="col">ค่าส่วนลด</th>
                    <th scope="col">รายละเอียด</th>
                    <th scope="col">วันเริ่ม-สิ้นสุด</th>
                    <th scope="col">Created</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key => $value)
                    @php
                        if($value->Branch_Active=="no"){
                            $text_hide = "text-decoration-line-through text-danger" ;
                        }else{
                            $text_hide = "";
                        } 
                    @endphp
                    <tr class="{{$text_hide}}">
                        <td>
                            <div class="avatar-xs">
                                <span class="avatar-title rounded-circle bg-warning bg-gradient">
                                    {{$key+1}}
                                </span>
                            </div>
                        </td>
                        <td>{{@$value->Code_pro}}</td>
                        <td>{{@$value->Name_pro}}</td>
                        <td>{{@$value->Type_pro}}</td>
                        <td>{{@$value->Value_pro}}</td>
                        <td>{{@$value->Detail_pro}}</td>
                        <td>
                            <p class="bg-success rounded-pill text-white font-size-12 mb-1 p-1"><i class="bx bx-calendar-check me-1"></i>{{date('d-m-Y',strtotime(@$value->Start_pro))}}</p>
                            <h5 class="bg-danger rounded-pill text-white font-size-12 mb-0 p-1"><i class="bx bx-calendar-x me-1"></i>{{date('d-m-Y',strtotime(@$value->End_pro))}}</h5>
                        </td>
                        <td>
                            <h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-muted">{{@$value->created_at}}</a></h5>
                            <p class="badge badge-soft-primary font-size-10 mb-0">{{(@$value->created_at != NULL)?@$value->created_at->diffForHumans():''}}</p>
                        </td>
                        <td>
                            <ul class="list-inline font-size-20 contact-links mb-0">
                                <li class="list-inline-item px-2">
                                    <a class="dropdown-item edit-details Modal-xl" data-bs-toggle="modal" data-bs-target="#Modal-xl" data-link="{{ route('dataStatic.edit', $value->id) }}?page={{'frontend'}}&modal={{'promotion'}}&mode={{'edit'}}" style="cursor:pointer;">
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