    <!-- Payee -->
<div class="card p-3 mb-2">
    <div class="row mt-4 ">
        <div class="col-12">
            <div class="d-flex">
                <div class="flex-grow-1 overflow-hidden">
                    @if(count(@$data->ContractToPayee) != 0 && @$data->ContractToPayee != NULL)
                        <h5 class="text-primary fw-semibold"><i class="bx bx-detail"></i> ผู้รับเงิน (Payee Detail)</h5>
                    @else
                        <h5 class="text-primary fw-semibold"><i class="bx bx-detail"></i> ผู้รับเงิน (Payee Detail)</h5><h6 class="text-danger">สัญญานี้ไม่มีผู้รับเงิน !</h6>
                    @endif
                </div>
            </div>
            <p class="border-primary border-bottom"></p>
        </div>
    </div>
    @if(count(@$data->ContractToPayee) != 0 && @$data->ContractToPayee != NULL)
        <div class="row">
            <div class="col-12">
                <div class="scroll-slide">
                    <div class="d-flex p-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">

                        @foreach(@$data->ContractToPayee as $payee)
                        @php 
                            if(@$payee->PayeetoCus->image_cus){
                                $image = @$payee->PayeetoCus->image_cus;
                            }else{
                                $image = '\assets\images\users\user-1.png';
                            }
                        @endphp
                        <div class="card card-hover border border-2 border-primary border-opacity-50 mb-1 me-1 {{ $loop->index == 0 ? 'show active' : ' ' }}" id="tab-{{$payee->id}}" data-bs-toggle="pill" data-bs-target="#v-pills-{{$payee->id}}" role="tab" aria-controls="v-pills-{{$payee->id}}" aria-selected="true" style="max-width:250px; min-width:250px; cursor:pointer;">
                                <div class="py-2 border-bottom">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 align-self-center mx-3">
                                            <img src="{{ URL::asset($image) }}" class="rounded-circle p-1 border border-2 border-primary border-opacity-50" style="width: 50px;">
                                        </div>
                                        <div class="flex-grow-1 align-self-center">
                                            <h5 class="font-size-15 mb-1 fw-semibold">{{ @$payee->PayeetoCus->Name_Cus }}</h5>
                                            <p class="text-muted mb-0"><i class="mdi mdi-circle text-success align-middle me-1"></i>ผู้รับเงิน {{$loop->iteration}}</p>
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

                @foreach(@$data->ContractToPayee as $payee)
                <div class="tab-pane fade {{ $loop->index == 0 ? 'show active' : ' ' }}" id="v-pills-{{$payee->id}}" role="tabpanel" aria-labelledby="tab-{{$payee->id}}" tabindex="0">
                    <table class="table table-nowrap mb-0">
                        <tbody>
                            <tr>
                                <th>ชื่อ-นามสกุล. :</th>
                                <td class="text-end">{{ @$payee->PayeetoCus->Name_Cus }}</td>
                                <th>เบอร์ติดต่อ :</th>
                                <td class="text-end">{{ @$payee->PayeetoCus->Phone_cus }}</td>
                            </tr>
                            <tr>
                                <th>เลข ปชช :</th>
                                <td class="text-end">{{ @$payee->PayeetoCus->IDCard_cus }}</td>
                                <th>วันเดือนปีเกิด :</th>
                                <td class="text-end">{{ @$payee->PayeetoCus->Birthday_cus }}</td>
                            </tr>
                            <tr>
                                <th>บัตรหมดอายุ :</th>
                                <td class="text-end">{{ @$payee->PayeetoCus->IdcardExpire_cus }}</td>
                                <th>คู่สมรส :</th>
                                <td class="text-end">{{ @$payee->PayeetoCus->Mate_cus }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                @endforeach

                </div>
            </div>
        </div>
    @else
    @endif
</div>
<!-- Payee -->
