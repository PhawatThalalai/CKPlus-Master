<div class="row">
  <div class="col-lg-12">
    <span class="showScroll2 float-end">
        <a class="Modal-xl hover-up" data-bs-toggle="modal" data-bs-target="#Modal-xl" data-link="{{ route('dataStatic.create') }}?page={{'frontend'}}&modal={{'interest_PTN'}}&mode={{'create'}}" style="cursor:pointer;">
          <div class="bg-dark" style="left:-43px; top:10px; z-index:1; position:relative; width: 100%; opacity:0.9;">
            <div class="bg-dark bg-gradient" style="z-index:-1; left: -6px; position:absolute; width: 50px; height: 45px; border-radius:30px 0px 0px 30px;"></div>
            <div class="bg-light border border-light border-5" style="z-index:3; position:absolute; top: 5px; left: 2px; border-radius:50px;">
              <div style="width:25px;">
                <img src="{{ asset('assets/images/plus.png') }}" alt="เพิ่ม" width="100%" height="100%">
              </div>
            </div>
          </div>
        </a>
    </span>
  </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card p-2 h-100">
            <!-- <div class="card-body"> -->

                <div class="d-flex">
                    <div class="flex-shrink-0 me-2 mt-1">
                        <!-- <img src="assets/images/signature.png" alt="" style="width: 40px;"> -->
                        <img class="" src="{{ URL::asset('assets/images/gif/wired-qr-code.gif') }}" alt="" style="width:50px;">
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <h5 class="text-primary fw-semibold pt-2 font-size-15">จัดการดอกเบี้ย ( Interest - {{@$f_zone}} )</h5>
                        <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>มี {{count(@$data)}} รายการ</h6>
                        <p class="border-primary border-bottom mt-2"></p>
                    </div>
                </div>

                <div class="table-responsive" data-simplebar="init" style="max-height: 390px;">
                    <table class="table align-middle table-nowrap table-hover">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th scope="col" style="width: 70px;">#</th>
                                <th scope="col">ประเภท</th>
                                <th scope="col">ช่วงปีรถ</th>
                                <th scope="col">ช่วงระยะเวลาผ่อน</th>
                                <th scope="col">เรทดอกเบี้ย</th>
                                <th scope="col">Last Update</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $key => $value)
                                @php
                                    if($value->FlagRate=="no"){
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
                                    <td>{{@$value->InterestToRateType->nametype_car}}</td>
                                    <td>{{@$value->YearStart_rate." - ".@$value->YearEnd_rate}}</td>
                                    <td>
                                        <p class="mb-0">{{@$value->InstalmentStart_rate." - ".@$value->InstalmentEnd_rate}}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0">{{$value->Interest_rate}}</p>
                                    </td>
                                    <td>
                                        <h5 class="font-size-12 mb-1"><a href="javascript: void(0);" class="text-muted">{{@$value->updated_at}}</a></h5>
                                        <p class="badge badge-soft-primary font-size-10 mb-0">{{(@$value->updated_at != NULL)?@$value->updated_at->diffForHumans():''}}</p>
                                    </td>
                                    <td>
                                        <ul class="list-inline font-size-20 contact-links mb-0">
                                            <li class="list-inline-item px-2">
                                                <a class="dropdown-item edit-details Modal-xl" data-bs-toggle="modal" data-bs-target="#Modal-xl" data-link="{{ route('dataStatic.edit', $value->id) }}?page={{'frontend'}}&modal={{'interest_PTN'}}&mode={{'edit'}}" style="cursor:pointer;">
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

            <!-- </div> -->
        </div>
    </div> <!-- end col -->
</div>
