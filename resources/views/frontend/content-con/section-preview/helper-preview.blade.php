<div class="modal-content">
    <div class="d-flex m-3 mb-0">
        <div class="flex-shrink-0 me-4">
            <img src="{{ URL::asset('\assets\images\signature.png') }}" alt="" style="width: 30px;">
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h4 class="text-primary fw-semibold">ศุนย์การช่วยเหลือ (Helper)</h4>
            <p class="text-muted mt-n1 fw-semibold font-size-12">Support</p>
            <p class="border-primary border-bottom mt-n2"></p>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" tabindex="-1" aria-label="Close"></button>
    </div>

    <div class="modal-body mx-3">

        {{-- check --}}
        @php
            $iconSuccess = 'bx bx-check-circle text-success fs-4';
            $iconWarning = 'bx bx-x-circle text-danger bx-tada fs-4';

                // ทรัพย์ในการทำสัญญา
                if(count(@$data->ContractToIndentureAsset2) != 0){
                    $iconAsset = $iconSuccess;
                    $asset = true;
                } else {
                    $iconAsset = $iconWarning;
                    $asset = false;

                }

                //ทรัพย์ที่ผูกในสัญญาอื่น
                if($assetIndent){
                    $iconAssetIndent = $iconWarning;
                    $AssetIndent = true;
                }else{
                    $iconAssetIndent = $iconSuccess;
                    $AssetIndent = false;

                }

                $ArrTypeCus = ['CUS-0004','CUS-0005','CUS-0006'];
                // ผู้ปิดบัญชี
                $hasPayeeClose = $data->ContractToPayee->filter(function($query) use($ArrTypeCus,$data){
                    return $query->status_Payee == 'CloseAcount';
                });
                if (in_array(@$data->ContractToDataCusTags->Type_Customer,$ArrTypeCus) == true ){
                    if(count($hasPayeeClose) != 0){
                        $iconPayeeClose = $iconSuccess;
                        $PayeeClose = true;
                    }else{
                        $iconPayeeClose = $iconWarning;
                        $PayeeClose = false;
                    }
                } else {
                    $iconPayeeClose = $iconSuccess;
                    $PayeeClose = true;

                }

                // ผู้รับเงิน
                $hasPayee = $data->ContractToPayee->filter(function($query) use($ArrTypeCus,$data){
                    return $query->status_Payee == 'Payee';
                });
                if (in_array(@$data->ContractToDataCusTags->Type_Customer,$ArrTypeCus) == true ){
                    if(count($hasPayee) != 0){
                        $iconPayee = $iconSuccess;
                        $Payee = true;
                    }else{
                        $iconPayee = $iconWarning;
                        $Payee = false;
                    }
                } else {
                    if(count($hasPayee) != 0){
                        $iconPayee = $iconSuccess;
                        $Payee = true;
                    }else{
                        $iconPayee = $iconWarning;
                        $Payee = false;
                    }
                }

                // ผู้แนะนำ 
                $arrBRKCheck = [];
                if (count(@$data->ContractToBrokers) != 0) {
                    foreach (@$data->ContractToBrokers as $item){
                            array_push($arrBRKCheck,@$item->SumCom_Broker) ;
                    }
                }

            
                if(count(@$data->ContractToBrokers) != 0){
                    $iconBRK = $iconSuccess;
                    $BRK = true;
                } else {
                    $iconBRK = $iconWarning;
                    $BRK = false;

                }

                // ค่าคอมผู้แนะนำ
                if(count(@$data->ContractToBrokers) != 0 && in_array(null, $arrBRKCheck) != true ){
                    $iconComBRK = $iconSuccess;
                    $ComBRK = true;
                } else {
                    if(count(@$data->ContractToBrokers) == 0){
                        $iconComBRK = $iconSuccess;
                        $ComBRK = true;
                    } else {
                        $iconComBRK = $iconWarning;
                        $ComBRK = false;
                    }
                }



                // รายละเอยดค่าใช้จ่าย
                if(@$data->ContractToOperated != NULL){
                    $iconEpenses = $iconSuccess; 
                    $Epenses = true;
                } else {
                    $iconEpenses = $iconWarning;
                    $Epenses = false;

                }


            // ลิงก์สัญญา
                if(@$data->LinkUpload_Con != NULL){
                    $iconConLink = $iconSuccess; 
                    $ConLink = true;
                } else {
                    $iconConLink = $iconWarning;
                    $ConLink = false;

                }
            // ขออนุมัติพิเศษ
                if(@$data->DateSpecial_Bookcar != NULL || @$data->DateCheck_Bookcar != NULL){
                    $iconSpecialApp = $iconSuccess; 
                    $SpecialApp = true;
                } else {
                    $iconSpecialApp = $iconWarning;
                    $SpecialApp = false;

                }
            // เช็คเล่มทะเบียน // not
                if(@$data->DateCheck_Bookcar != NULL){
                    $iconCheck_Bookcar = $iconSuccess; 
                    $Check_Bookcar = true;
                } else {
                    $iconCheck_Bookcar = $iconWarning;
                    $Check_Bookcar = false;
                }

                // ได้รับเล่มทะเบียน
                if(@$data->BookSpecial_Trans != NULL){
                    $iconBookSpecial_Trans= $iconSuccess; 
                    $Check_Bookcar = true;
                } else {
                    $iconBookSpecial_Trans = $iconWarning;
                    $Check_Bookcar = false;
                }
            // ตรวจสอบเอกสาร
                if(@$data->ContractToAudittor->StatusApprove == 'Y'){
                    $iconCheck_Audit = $iconSuccess; 
                    $Check_Audit = true;
                } else {
                    $iconCheck_Audit = $iconWarning;
                    $Check_Audit = false;

                }
            // เพิ่มที่อยู่ที่ใช้ทำสัญญา
                if(@$data->Adds_Con != NULL){
                    $iconAdds_Con = $iconSuccess; 
                    $Adds_Con = true;
                } else {
                    $iconAdds_Con = $iconWarning;
                    $Adds_Con = false;

                }


                // ตรวจสอบเอกสาร ผู้อนุมัติ
                if(@$data->ContractToAudittor->statusDoc == 'Pass'){
                    $iconCheck_AppCon = $iconSuccess; 
                    $Check_AppCon = true;
                } else {
                    $iconCheck_AppCon = $iconWarning;
                    $Check_AppCon = false;

                }
        
        @endphp
        <h5 class="fw-semibold"> สำหรับผู้ขออนุมัติ </h5>
        @if($asset && $PayeeClose && $Payee && $ComBRK && $Epenses && $ConLink && $SpecialApp && $Check_Audit && $Adds_Con)
            <div class='row mb-2'>
                <div class="col-12">
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <div>
                            <i class="mdi mdi-check-circle fs-4"></i> ข้อมูลครบแล้ว พร้อมสำหรับการขออนุมัติ 
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class='row mb-2'>
                <div class="col-12">
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <div>
                            <i class="mdi mdi-alert-circle fs-4"></i> เพิ่มข้อมูลให้ครบถ้วนก่อนทำการขออนุมัติ 
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col">
                <div class="faq-box d-flex">
                <div class="flex-shrink-0 m-auto faq-icon">
                    <img class="section-guarantor img-defualt ms-3" src="{{ URL::asset('\assets\images\contract\asset-management.png') }}" alt="" style="width: 40px;">
                </div>
                <div class="flex-grow-1 ms-4">
                    <h5 class="text-decoration-underline">ข้อมูลทรัพย์</h5>

                    <p class="text-muted">
                        <span class="{{ @$data_Approve->ConfigApproveToDesApprove->TxtAsset1 == NULL ? 'd-none' : '' }}"><i class=" {{ $iconAsset }} "></i> {{ @$data_Approve->ConfigApproveToDesApprove->TxtAsset1 }}</span> <br>
                        {{-- <span class="{{ @$data_Approve->ConfigApproveToDesApprove->TxtAsset2 == NULL ? 'd-none' : '' }}"><i class=" {{ $iconAssetIndent }} "></i> {{ @$data_Approve->ConfigApproveToDesApprove->TxtAsset2 }}</span> <br> --}}
                    </p>
                </div>
                </div>
            </div>
            <p class="border-light border-bottom mt-2"></p>
        </div>

        <div class="row">
            <div class="col">
                <div class="faq-box d-flex">
                <div class="flex-shrink-0 m-auto faq-icon">
                    <img class="section-guarantor img-defualt ms-3" src="{{ URL::asset('\assets\images\contract\qualification.png') }}" alt="" style="width: 40px;">
                </div>
                <div class="flex-grow-1 ms-4">
                    <h5 class="text-decoration-underline">ข้อมูลผู้ค้ำ</h5>
                    <p class="text-muted">
                       <span class="{{ @$data_Approve->ConfigApproveToDesApprove->TxtGauran1 == NULL ? 'd-none' : '' }}"><i class=""></i> {{ @$data_Approve->ConfigApproveToDesApprove->TxtGauran1 }}</span> <br>
                    </p>
                </div>
                </div>
            </div>
            <p class="border-light border-bottom mt-2"></p>
        </div>

        <div class="row">
            <div class="col">
                <div class="faq-box d-flex">
                <div class="flex-shrink-0 m-auto faq-icon">
                    <img class="section-guarantor img-defualt ms-3" src="{{ URL::asset('\assets\images\contract\coin.png') }}" alt="" style="width: 40px;">
                </div>
                <div class="flex-grow-1 ms-4">
                    <h5 class="text-decoration-underline">ข้อมูลผู้รับเงิน</h5>
                    <p class="text-muted">
                       <span class="{{ @$data_Approve->ConfigApproveToDesApprove->TxtPayee1 == NULL ? 'd-none' : '' }}"><i class="{{ @$iconPayee }}"></i> {{ @$data_Approve->ConfigApproveToDesApprove->TxtPayee1 }}</span> <br>
                       <span class="{{ @$data_Approve->ConfigApproveToDesApprove->TxtPayee2 == NULL ? 'd-none' : '' }}"><i class="{{ @$iconPayeeClose }}"></i> {{ @$data_Approve->ConfigApproveToDesApprove->TxtPayee2 }}</span>  <br>
                    </p>
                </div>
                </div>
            </div>
            <p class="border-light border-bottom mt-2"></p>
        </div>

        @if(count(@$data->ContractToBrokers) != 0)
        <div class="row">
            <div class="col">
                <div class="faq-box d-flex">
                <div class="flex-shrink-0 m-auto faq-icon">
                    <img class="section-guarantor img-defualt ms-3" src="{{ URL::asset('\assets\images\contract\broker.png') }}" alt="" style="width: 40px;">
                </div>
                <div class="flex-grow-1 ms-4">
                    <h5 class="text-decoration-underline">ข้อมูลผู้แนะนำ</h5>
                    <p class="text-muted">
                        <i class="{{ $iconBRK }}"></i> {{ @$data_Approve->ConfigApproveToDesApprove->TxtBroker1 }} <br>
                       <span class="{{ @$data_Approve->ConfigApproveToDesApprove->TxtBroker2 == NULL ? 'd-none' : '' }}"> <i class="{{ $iconComBRK }}"></i> {{ @$data_Approve->ConfigApproveToDesApprove->TxtBroker2 }}</span> <br>
                    </p>
                </div>
                </div>
            </div>
            <p class="border-light border-bottom mt-2"></p>
        </div>
        @endif

        <div class="row">
            <div class="col">
                <div class="faq-box d-flex">
                <div class="flex-shrink-0 m-auto faq-icon">
                    <img class="section-guarantor img-defualt ms-3" src="{{ URL::asset('\assets\images\contract\money.png') }}" alt="" style="width: 40px;">
                </div>
                <div class="flex-grow-1 ms-4">
                    <h5 class="text-decoration-underline">ข้อมูลค่าใช้จ่าย</h5>
                    <p class="text-muted">
                        <span class="{{ @$data_Approve->ConfigApproveToDesApprove->TxtExpenses1 == NULL ? 'd-none' : '' }}"><i class="{{ $iconEpenses }}"></i> {{ @$data_Approve->ConfigApproveToDesApprove->TxtExpenses1 }} </span> <br>
                    </p>
                </div>
                </div>
            </div>
            <p class="border-light border-bottom mt-2"></p>
        </div>

        <div class="row">
            <div class="col">
                <div class="faq-box d-flex">
                <div class="flex-shrink-0 m-auto faq-icon">
                    <img class="section-guarantor img-defualt ms-3" src="{{ URL::asset('\assets\images\contract\approve2.png') }}" alt="" style="width: 40px;">
                </div>
                <div class="flex-grow-1 ms-4">
                    <h5 class="text-decoration-underline">ข้อมูลสัญญา</h5>
                    <p class="text-muted">
                        <span class="{{ @$data_Approve->ConfigApproveToDesApprove->TxtApprove1 == NULL ? 'd-none' : '' }}"><i class="{{ $iconConLink  }}"></i> {{ @$data_Approve->ConfigApproveToDesApprove->TxtApprove1 }}</span> <br>
                        <span class="{{ @$data_Approve->ConfigApproveToDesApprove->TxtApprove2 == NULL ? 'd-none' : '' }}"><i class="{{ $iconSpecialApp }}"></i> {{ @$data_Approve->ConfigApproveToDesApprove->TxtApprove2 }}</span> <br>
                        <span class="{{ @$data_Approve->ConfigApproveToDesApprove->TxtApprove3 == NULL ? 'd-none' : '' }}"><i class="{{ $iconBookSpecial_Trans }}"></i> {{ @$data_Approve->ConfigApproveToDesApprove->TxtApprove3 }}</span> <br>
                        <span class="{{ @$data_Approve->ConfigApproveToDesApprove->TxtApprove4 == NULL ? 'd-none' : '' }}"><i class="{{ $iconCheck_Audit }}"></i> {{ @$data_Approve->ConfigApproveToDesApprove->TxtApprove4 }}</span> <br>
                        <span class="{{ @$data_Approve->ConfigApproveToDesApprove->TxtApprove5 == NULL ? 'd-none' : '' }}"><i class="{{ $iconAdds_Con }}"></i> {{ @$data_Approve->ConfigApproveToDesApprove->TxtApprove5 }}</span> <br>
                    </p>
                </div>
                </div>
            </div>
            <p class="border-light border-bottom mt-2"></p>
        </div>
        <h5 class="fw-semibold"> สำหรับผู้อนุมัติ </h5>
        @if($Check_AppCon && $AssetIndent != true)
            <div class='row mb-2'>
                <div class="col-12">
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <div>
                            <i class="mdi mdi-check-circle fs-4"></i> สัญญาพร้อมได้รัยการอนุมัติ 
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class='row mb-2'>
                <div class="col-12">
                    <div class="alert alert-danger d-flex align-items-center" role="alert">
                        <div>
                            <i class="mdi mdi-alert-circle fs-4"></i>  เพิ่มข้อมูลให้ครบถ้วนก่อนทำการอนุมัติ 
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col">
                <div class="faq-box d-flex">
                <div class="flex-shrink-0 m-auto faq-icon">
                    <img class="section-guarantor img-defualt ms-3" src="{{ URL::asset('\assets\images\contract\approve2.png') }}" alt="" style="width: 40px;">
                </div>
                <div class="flex-grow-1 ms-4">
                    <h5 class="text-decoration-underline">ข้อมูลสัญญา</h5>
                    <p class="text-muted">
                        <span class="{{ @$data_Approve->ConfigApproveToDesApprove->TxtApprove4 == NULL ? 'd-none' : '' }}"><i class="{{ $iconCheck_AppCon }}"></i> {{ @$data_Approve->ConfigApproveToDesApprove->TxtApprove4 }}</span> <br>
                        @if(count(@$CheckIndent) > 0)
                            <span class="{{ @$data_Approve->ConfigApproveToDesApprove->TxtAsset2 == NULL ? 'd-none' : '' }}"><i class=" {{ $iconAssetIndent }} "></i> {{ @$data_Approve->ConfigApproveToDesApprove->TxtAsset2 }}</span> <br>
                            <a href="{{ route('contract.edit', implode(', ', @$CheckIndent->pluck('id')->toArray())) }}?funs={{'contract'}}" target="_blank" class="{{ @$data_Approve->ConfigApproveToDesApprove->TxtAsset2 == NULL ? 'd-none' : '' }} ms-4"> {{ implode(', ', @$CheckIndent->pluck('Contract_Con')->toArray()) }} </a> <br>
                        @endif

                    </p>
                </div>
                </div>
            </div>
            <p class="border-light border-bottom mt-2"></p>
        </div>


    </div>

    <div class="modal-body mx-3">
        @foreach (@$data_Approve->ConfigApproveToDesApproveMany as $item)
            <div class="row">
                <div class="col">
                    <div class="faq-box d-flex">
                    <div class="flex-shrink-0 m-auto faq-icon">
                        <img class="section-guarantor img-defualt ms-3" src="{{ URL::asset('\assets\images\contract\asset-management.png') }}" alt="" style="width: 40px;">
                    </div>
                    <div class="flex-grow-1 ms-4">
                        <h5 class="text-decoration-underline">{{ @$item->header }}</h5>

                        <p class="text-muted">
                            <span class=""><i class="{{ @$iconAsset }}"></i> {{ @$item->Text_Value }}</span> <br>
                        </p>
                    </div>
                    </div>
                </div>
                <p class="border-light border-bottom mt-2"></p>
            </div>
        @endforeach
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">ปิด</button>
    </div>
</div>
