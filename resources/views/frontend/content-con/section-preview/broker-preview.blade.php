<!-- Broker -->
<div class="card p-3 mb-2">
    <div class="row mt-4 ">
        <div class="col-12">
            <div class="d-flex">
                <div class="flex-grow-1 overflow-hidden">
                    @if (@$data->ContractToBrokers != NULL && count($data->ContractToBrokers) != 0)
                        <h5 class="text-primary fw-semibold"><i class="bx bx-detail"></i> ผู้แนะนำ</h5>
                    @else
                        <h5 class="text-primary fw-semibold"><i class="bx bx-detail"></i> ผู้แนะนำ</h5> <h6 class="text-danger">สัญญานี้ไม่มีผู้แนะนำ !</h6>
                    @endif
                </div>
            </div>
            <p class="border-primary border-bottom"></p>
        </div>
    </div>
    @if (@$data->ContractToBrokers != NULL && count($data->ContractToBrokers) != 0)
    <div class="row">
        <div class="col-12">
            <div class="scroll-slide">
                <div class="d-flex p-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                    @foreach(@$data->ContractToBrokers as $broker)
                        @php 
                            if(@$broker->BrokertoCus->image_cus){
                                $image = @$payee->BrokertoCus->image_cus;
                            }else{
                                $image = '\assets\images\users\user-1.png';
                            }
                        @endphp
                    <div class="card card-hover border border-2 border-primary border-opacity-50 mb-1 me-1 {{ $loop->index == 0 ? 'active' : ' ' }}" id="tab-{{$broker->id}}" data-bs-toggle="pill" data-bs-target="#v-pills-{{$broker->id}}" role="tab" aria-controls="v-pills-{{$broker->id}}" aria-selected="true" style="max-width:250px; min-width:250px; cursor:pointer;">
                        <div class="py-2 border-bottom">
                            <div class="d-flex">
                                <div class="flex-shrink-0 align-self-center mx-3">
                                    <img src="{{ URL::asset($image) }}" class="rounded-circle p-1 border border-2 border-primary border-opacity-50" style="width: 50px;">
                                </div>
                                <div class="flex-grow-1 align-self-center">
                                    <h5 class="font-size-15 mb-1 fw-semibold">{{ @$broker->BrokertoCus->Name_Cus }}</h5>
                                    <p class="text-muted mb-0"><i class="mdi mdi-circle text-success align-middle me-1"></i>ผู้แนะนำ {{$loop->iteration}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>

        </div>
        <div class="col-12 mt-2">

            <div class="tab-content" id="v-pills-tabContent">
            @foreach(@$data->ContractToBrokers as $broker)
                <div class="tab-pane fade {{ $loop->index == 0 ? 'show active' : ' ' }}" id="v-pills-{{$broker->id}}" role="tabpanel" aria-labelledby="tab-{{$broker->id}}">
                    <table class="table table-nowrap mb-0">
                        <tbody>
                            <tr>
                                <th>ชื่อ-นามสกุล. :</th>
                                <td class="text-end">{{ @$broker->BrokertoCus->Name_Cus }}</td>
                                <th>เบอร์ติดต่อ :</th>
                                <td class="text-end">{{ @$broker->BrokertoCus->Phone_cus }}</td>
                            </tr>
                            <tr>
                                <th>เลข ปชช :</th>
                                <td class="text-end">{{ @$broker->BrokertoCus->IDCard_cus }}</td>
                                <th>วันเดือนปีเกิด :</th>
                                <td class="text-end">{{ @$broker->BrokertoCus->Birthday_cus }}</td>
                            </tr>
                            <tr>
                                <th>บัตรหมดอายุ :</th>
                                <td class="text-end">{{ @$broker->BrokertoCus->IdcardExpire_cus }}</td>
                                <th>คู่สมรส :</th>
                                <td class="text-end">{{ @$broker->BrokertoCus->Mate_cus }}</td>
                            </tr>
                            <tr>
                                <th>ธนาคาร :</th>
                                <td class="text-end">{{ @$broker->BrokertoCus->Name_Account }}</td>
                                <th>เลขบัญชี :</th>
                                <td class="text-end">{{ @$broker->BrokertoCus->Number_Account }}</td>
                            </tr>
                            <tr>
                                <th>ค่าคอมมิชชั่น :</th>
                                <td class="text-end">{{ @$broker->Commission_Broker }}</td>
                                <th>ค่าคอมคงเหลือ :</th>
                                <td class="text-end">{{ @$broker->SumCom_Broker }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endforeach



            </div>
        </div>
    </div>
    @else
    {{-- box empty --}}
    <div class="row d-none" >
        <div class="col-12 text-center">
            <img src="{{URL::asset('\assets\images\out-of-stock.png')}}" class="up-down mt-4" alt="" style="width:50px;">
        </div>
        <div class="col-12 text-center">
            <h5 class="fw-semibold mt-2 text-danger fs-6">สัญญานี้ไม่มีผู้แนะนำ !</h5>
        </div>
    </div>
    @endif
</div>
<!-- Broker -->
