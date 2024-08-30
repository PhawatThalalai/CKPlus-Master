<style>
    .cardstyle {
        background: rgb(246,183,255);
        background: linear-gradient(331deg, rgba(246,183,255,1) 0%, rgba(232,234,255,1) 50%, rgba(147,157,255,1) 100%);
    }
    .bg-violet {
        background-color : #939dff
    }
    .bg-pinks {
        background-color : #fbdcff
    }
</style>


@php
    if (@$data['CONTYPE'] == '03'){
        $img =  asset('assets/images/scooter.png') ;
    }
    elseif (@$data['CONTYPE'] == '04'){
        $img =  asset('assets/images/land2.png');
    }
    else {
        $img =  asset('assets/images/car3d.png');
    }
@endphp

<div class="card pt-3 ps-2 rounded-4">
    <div class="">
        <div class="accordion accordion-flush" id="accordionFlushExample">
            <div class="accordion-item ">
                <div class="row">
                    <div class="col-4">
                        <div class="collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-ConPoss" aria-expanded="false" aria-controls="flush-ConPoss" fdprocessedid="e4uohn">
                            <div class="card cardstyle text-white rounded-4 hover-up">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">
                                            <label for="">ยอดกู้</label>
                                        </div>
                                        <div class="col text-end">
                                            <div class="badge text-bg-success fs-5 rounded-pill">{{ @$data['STATUS'] }}</div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <h3>฿ {{ number_format( @$data['TCSHPRC'],2 ) }}</h3>
                                            <h4 class="fw-semibold font-monospace">{{ @$data['CONTNO'] }}</h4><small>(เงินกู้)</small>
                                            <h5>{{ @$data['T_NOPAY'] }} งวด</h5>
                                        </div>
                                        <div class="col m-auto text-end">
                                            <img href = "#" class="" src ="{{ @$img }}" style="max-width : 70%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-8 p-2 m-auto">
                        <div class="">
                            <div class="row">
                                <div class="col border-end">
                                    <div class="">
                                        <h4 class="card-title mb-3 text-dark">ช้อมูลทรัพย์ค้ำประกัน</h4>
                                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                            @foreach(@$data['ASST'] as $value)
                                                <div class="carousel-item {{ ( $loop->index == 0 ) ? 'active' : '' }}" data-bs-interval="5000">
                                                    <div class=" p-3 d-flex mb-3 rounded">
                                                        <img src="{{ asset('assets/images/users/avatar-5.jpg') }}" alt="" class="avatar-sm rounded-circle me-3">
                                                        <div class="flex-grow-1">
                                                            <h5 class="font-size-15 mb-2"><a href="candidate-overview.html" class="text-body">{{ ( @$value->IndenAssetToDataOwner->AssetToCarBrand->Brand_car != NULL ) ? @$value->IndenAssetToDataOwner->AssetToCarBrand->Brand_car : @$value->IndenAssetToDataOwner->Land_Type  }}</a> <span class="badge badge-soft-info">ประเภททรัพย์</span></h5>
                                                            <!-- <p class="mb-0 text-muted"><i class="bx bx-map text-body align-middle"></i> Germany</p> -->
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="">
                                        <h4 class="card-title mb-3 text-dark">ช้อมูลผู้ค้าประกัน</h4>
                                        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                @foreach(@$data['GUAR'] as $value)
                                                <div class="carousel-item {{ ( $loop->index == 0 ) ? 'active' : '' }}" data-bs-interval="5000">
                                                    <div class="p-3 d-flex mb-3 rounded">
                                                        <img src="{{ asset('assets/images/users/avatar-5.jpg') }}" alt="" class="avatar-sm rounded-circle me-3">
                                                        <div class="flex-grow-1">
                                                            <h5 class="font-size-15 mb-2"><a href="candidate-overview.html" class="text-body text-dark">{{ @$value->GuarantorToGuarantorCus->Name_Cus }}</a></h5>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="flush-ConPoss" class="accordion-collapse collapse" aria-labelledby="flush-ConPoss" data-bs-parent="#accordionFlushExample" style="">
                    <div class="row border-top p-3">
                        <div class="col-4 text-center">
                            <div class="row">
                                <div class="col">
                                    <div class="accordion-body text-muted">
                                        <div class="row">
                                            <div class="col">
                                                <label class="fs-6 fw-semibold">ผ่อน</label><br>
                                                <label class="fs-4 fw-semibold">{{ number_format( @$data['T_NOPAY'],2 ) }}</label>
                                                <div class="progress">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-violet" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <label class="fs-6 fw-semibold">คงเหลือ</label><br>
                                                <label class="fs-4 fw-semibold">72,000</label>
                                                <div class="progress">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-pinks" role="progressbar" aria-label="Animated striped example" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%"></div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col text-center mt-4">
                                                <button type="button" class=" seemore btn btn-primary rounded-pill p-2 nav-pills" data-bs-toggle="tab" href="#contract" role="tab" aria-selected="false" tabindex="-1">ดูเพิ่มเติม</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-8">
                            <h4 class="card-title mt-3 mb-3 text-dark">รายละเอียดสัญญา</h4>
                            <div class="table-responsive ">
                                <table class="table table-nowrap table-sm mb-0">
                                    <tbody class="fs-6">
                                        <tr>
                                            <th scope="row">ยอดกู้ :</th>
                                            <td class="text-end">{{ number_format( @$data['TCSHPRC'],2 ) }}</td>
                                        </tr>
                                        <tr>
                                            <th scope="row">ดอกเบี้ยต่อปี :</th>
                                            <td class="text-end">{{ number_format( @$data['Interest_IRR'],2 ) }}</td>
                                        </tr>

                                        <tr>
                                            <th scope="row">ค่างวด :</th>
                                            <td class="text-end">{{ number_format( @$data['TOT_UPAY'],2 ) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
