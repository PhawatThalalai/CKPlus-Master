<!-- Guaran -->
<div class="card p-3 mb-2">
    <div class="row mt-4 ">
        <div class="col-12">
            <div class="d-flex">
                <div class="flex-grow-1 overflow-hidden">
                    @if(count(@$data->ContractToGuarantor) != 0 && @$data->ContractToGuarantor != NULL)
                        <h5 class="text-primary fw-semibold"><i class="bx bx-detail"></i> ผู้ค้ำประกัน (Guarantor Detail)</h5>
                    @else
                        <h5 class="text-primary fw-semibold"><i class="bx bx-detail"></i> ผู้ค้ำประกัน (Guarantor Detail)</h5> <h6 class="text-danger">สัญญานี้ไม่มีผู้ค้ำประกัน !</h6>
                    @endif
                </div>
            </div>
            <p class="border-primary border-bottom"></p>
        </div>
    </div>
    @if(count(@$data->ContractToGuarantor) != 0 && @$data->ContractToGuarantor != NULL)
        <div class="row">
            <div class="col-12">
                <div class="scroll-slide">
                    <div class="d-flex p-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        @foreach(@$data->ContractToGuarantor as $guar)
                        @php 
                            if(@$guar->GuarantorToGuarantorCus->image_cus){
                                $image = @$guar->GuarantorToGuarantorCus->image_cus;
                            }else{
                                $image = '\assets\images\users\user-1.png';
                            }
                        @endphp
                        <div class="card card-hover border border-2 border-primary border-opacity-50 mb-1 me-1 {{ $loop->index == 0 ? 'show active' : '' }}" id="tab-{{$guar->id}}" data-bs-toggle="pill" data-bs-target="#v-pills-{{$guar->id}}" role="tab" aria-controls="v-pills-{{$guar->id}}" aria-selected="true" style="max-width:250px; min-width:250px; cursor:pointer;">
                            <div class="py-2 border-bottom">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 align-self-center mx-3">
                                        <img src="{{ URL::asset($image) }}" class="rounded-circle p-1 border border-2 border-primary border-opacity-50" style="width: 50px;">
                                    </div>
                                    <div class="flex-grow-1 align-self-center">
                                        <h5 class="font-size-15 mb-1 fw-semibold">{{ @$guar->GuarantorToGuarantorCus->Name_Cus }}</h5>
                                        <p class="text-muted mb-0"><i class="mdi mdi-circle text-success align-middle me-1"></i>ผู้ค้ำ {{$loop->iteration}}</p>
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

                @foreach(@$data->ContractToGuarantor as $guar)
                <div class="tab-pane fade {{ $loop->index == 0 ? 'show active' : ' ' }}" id="v-pills-{{$guar->id}}" role="tabpanel" aria-labelledby="tab-{{$guar->id}}" tabindex="0">
                    <table class="table table-nowrap mb-0">
                        <tbody>
                            <tr>
                                <th>ชื่อ-นามสกุล. :</th>
                                <td class="text-end">{{ @$guar->GuarantorToGuarantorCus->Name_Cus }}</td>
                                <th>เบอร์ติดต่อ :</th>
                                <td class="text-end">{{ @$guar->GuarantorToGuarantorCus->Phone_cus }}</td>
                            </tr>
                            <tr>
                                <th>เลข ปชช :</th>
                                <td class="text-end">{{ @$guar->GuarantorToGuarantorCus->IDCard_cus }}</td>
                                <th>วันเดือนปีเกิด :</th>
                                <td class="text-end">{{ @$guar->GuarantorToGuarantorCus->Birthday_cus }}</td>
                            </tr>
                            <tr>
                                <th>บัตรหมดอายุ :</th>
                                <td class="text-end">{{ @$guar->GuarantorToGuarantorCus->IdcardExpire_cus }}</td>
                                <th>คู่สมรส :</th>
                                <td class="text-end">{{ @$guar->GuarantorToGuarantorCus->Mate_cus }}</td>
                            </tr>
                            <tr>
                                <th>ความสัมพันธ์ :</th>
                                <td class="text-end">{{ @$guar->GuarantorToGuarantorCus->GuarantorToTypeRelation->Name_Rela }}</td>
                                <th>แบบค้ำ :</th>
                                <td class="text-end">{{ @$guar->GuarantorToGuarantorCus->Name_Secur }}</td>
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
<!-- endGuaran -->
