    <style>

        .slider {
        height: 15px;
        overflow: hidden;
        }

        .slider > div {
        box-sizing: border-box;
        height: 40px;
        margin-bottom: 60px;
        text-align: center;
        }

        .text1 {
        animation: slide 5s linear infinite;

        }
        @keyframes slide {
        0% { margin-top: -250px; }
        5% { margin-top: -200px; }
        33% { margin-top: -200px; }
        38% { margin-top: -100px; }
        66% { margin-top: -100px; }
        72% { margin-top: -0; }
        100% { margin-top: 0; }
        }

    </style>

<!-- tab content -->
    <div class="">
        <div class="section bg-white p-1 mb-1">
            <ul class="nav nav-pills nav-fill bg-transparent " id="pills-tab" id="formTabs" role="tablist">
                <li class="nav-item me-1" role="presentation">
                    <div onclick="getTab('data-main-contract')" class=" mini-stats-wid nav-link border border-primary  waves-effect waves-light active " id="step1-tab" role="tab" data-bs-toggle="tab" data-bs-target='#step1-tab-pane'  aria-controls="step1-tab-pane" aria-selected="false">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="fw-medium mb-2 fs-5">ข้อมูลสัญญา</p>
                                    <h6 class="mb-0">{{@$contract->CONTNO}}</h6>
                                </div>
                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle">
                                        <span class="avatar-title bg-info bg-soft text-info font-size-24">
                                            <i class="bx bx-book-bookmark"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item me-1" role="presentation">
                    <div onclick="getTab('data-main-asset')" class=" mini-stats-wid nav-link border border-primary   waves-effect waves-light" id="step2-tab" role="tab" data-bs-toggle="tab" data-bs-target='#step2-tab-pane'  aria-controls="step2-tab-pane" aria-selected="false">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="fw-medium mb-2 fs-5">ข้อมูลทรัพย์</p>
                                    <h6 class="mb-0">{{ @$contract->PatchToPact->ContractToIndentureAsset->IndenAssetToDataOwner->Code_Asset }}</h6>
                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle">
                                        <span class="avatar-title bg-warning bg-soft text-warning font-size-24">
                                            <i class="bx bx-money"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="nav-item me-1" role="presentation">
                    <div onclick="getTab('data-main-guaran')" class=" mini-stats-wid nav-link border border-primary waves-effect waves-light" id="step3-tab" role="tab" data-bs-toggle="tab" data-bs-target='#step3-tab-pane'  aria-controls="step3-tab-pane" aria-selected="false">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="flex-grow-1">
                                    <p class="fw-medium mb-2 fs-5">ข้อมูลผู้ค้ำประกัน</p>

                                    @if(@$contract->PatchToPact != NULL )
                                        @if(@count (@$contract->PatchToPact->ContractToGuarantor) > 1 )
                                            <div class="slider mb-0">
                                                <div class="text1"></div>
                                                @foreach(@$contract->PatchToPact->ContractToGuarantor as $value)
                                                    <div class="text{{$loop->iteration+1}}" >{{ textFormat($value->GuarantorToGuarantorCus->IDCard_cus) }}</div>
                                                @endforeach
                                            </div>
                                        @else
                                            @foreach(@$contract->PatchToPact->ContractToGuarantor as $value)
                                                <h6 class="mb-0">{{ textFormat(@$value->GuarantorToGuarantorCus->IDCard_cus) }}</h6>
                                            @endforeach
                                        @endif
                                    @else
                                        <h6 class="text-danger mb-0">สัญญานี้ไม่มีผู้ค้ำประกัน</h6>
                                    @endif


                                </div>

                                <div class="flex-shrink-0 align-self-center">
                                    <div class="mini-stat-icon avatar-sm rounded-circle">
                                            <span class="avatar-title bg-success bg-soft text-success font-size-24">
                                            <i class="bx bxs-user-check"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <form action="#">
        <div class="tab-content" id="formTabsContent">
            <div class="tab-pane fade active show" id="step1-tab-pane" role="tabpanel" aria-labelledby="step1-tab" tabindex="0">
                <div class="data-main-contract_tab" id="data-main-contract_tab"></div>
                <div class="data-main-contract_loading" style="display:none;">
                    @include('backend.content-contract.section-content.table-loading')
                </div>
            </div>

            <!-- ทรัพย์ -->
            <div class="tab-pane fade" id="step2-tab-pane" role="tabpanel" aria-labelledby="step2-tab" tabindex="0">
                <div class="data-main-asset_tab" id="data-main-asset_tab"></div>
                <div class="data-main-asset_loading" style="display:none;">
                    @include('backend.content-contract.section-content.table-loading')
                </div>
            </div>

            <!-- ผู้ค้ำ -->
            <div class="tab-pane fade" id="step3-tab-pane" role="tabpanel" aria-labelledby="step3-tab" tabindex="0">
                <div class="data-main-guaran_tab" id="data-main-guaran_tab"></div>
                <div class="data-main-guaran_loading" style="display:none;">
                    @include('backend.content-contract.section-content.table-loading')
                </div>
            </div>
        </div>
    </form>
<!-- end tab content -->














