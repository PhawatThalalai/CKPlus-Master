<div class="card p-2 h-100">
    <div class="d-flex">
        <div class="flex-shrink-0 me-2 mt-1">
            <!-- <img src="assets/images/signature.png" alt="" style="width: 40px;"> -->
            <img class="" src="{{ URL::asset('assets/images/gif/wired-qr-code.gif') }}" alt="" style="width:50px;">
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h5 class="text-primary fw-semibold pt-2 font-size-15">จัดการค่าคงที่ {{ @$setpage === 'configPsl' ? 'PSL' : 'HP' }} ( Management {{ @$setpage === 'configPsl' ? 'PSL' : 'HP' }} Loan)</h5>
            <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>มี {{count(@$response)}} รายการ</h6>
            <p class="border-primary border-bottom mt-2"></p>
        </div>
    </div>

    <div class="table-responsive" data-simplebar="init" style="max-height: 390px;">
        <table class="table align-middle table-nowrap table-hover">
            <thead class="table-light sticky-top">
                <tr>
                    <th scope="col" style="width: 70px;">#</th>
                    <th scope="col">เบี้ยปรับล้าช้า</th>
                    <th scope="col">ดอกเบี้ย</th>
                    <th scope="col">จำนวนวันช้าไม่มีเบี้ยปรับ</th>
                    <th scope="col">ภาษี</th>
                    <th scope="col">ส่วนลด</th>
                    <th scope="col">วิธีคำนวณส่วนลดตัดสด</th>
                    <th scope="col">FLAG</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($response as $key => $value)
                    <tr>
                        <td>
                            <div class="avatar-xs">
                                <span class="avatar-title rounded-circle bg-warning bg-gradient">
                                    {{$key+1}}
                                </span>
                            </div>
                        </td>
                        <td>{{@$value->LATEPER}}</td>
                        <td>
                            <p class="text-muted mb-0">{{@$value->INT}}</p>
                        </td>
                        <td>
                            <p class="text-muted mb-0">{{@$value->LATENFINE}}</p>
                        </td>
                        <td>
                            <p class="text-muted mb-0">{{@$value->VAT}}</p>
                        </td>
                        <td>
                            <p class="text-muted mb-0">{{@$value->DISCOUNT}}</p>
                        </td>
                        <td>
                            <p class="text-muted mb-0">{{@$value->MTHDDIS}}</p>
                        </td>
                        <td>
                            <p class="text-muted mb-0">{{@$value->FLAG}}</p>
                        </td>
                        <td>
                            <ul class="list-inline font-size-20 contact-links mb-0">
                                <li class="list-inline-item px-2">
                                    <a class="dropdown-item edit-details Modal-xl" data-bs-toggle="modal" data-bs-target="#Modal-xl" data-link="{{ route('dataStatic.edit', $value->id) }}?page={{'backend'}}&modal={{'confLoan'}}&typeLoan={{ @$setpage === 'configPsl' ? 'PSL' : 'HP' }}&reqType={{'edit'}}" style="cursor:pointer;">
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
