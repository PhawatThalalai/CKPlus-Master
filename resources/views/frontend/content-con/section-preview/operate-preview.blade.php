<!-- OPR -->
<div class="card p-3 mb-2">
    <div class="row mt-4">
        <div class="col-12">
            <div class="d-flex">
                <h5 class="text-primary fw-semibold"><i class="bx bx-detail"></i> รายละเอียดค่าใช้จ่าย (Expenses Detail)</h5>
            </div>
            <p class="border-primary border-bottom"></p>
        </div>
    </div>
    <div class="row mb-2">
        <h6 class="fw-semibold">- รายละเอียดการจัดไฟแนนซ์ (TOP-UP)</h6>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <div class="table-responsive">
                <table class="table table-nowrap mb-0">
                    <tbody>
                        <tr>
                            <th><i class="bx bxs-up-arrow-circle text-success"></i> ยอดจัด :</th>
                            <td class="text-end border-bottom border-danger">{{ number_format(@$data->ContractToCal->Cash_Car,2) }} บาท</td>
                            <th><i class="bx bxs-up-arrow-circle text-success"></i> ค่าดำเนินการ :</th>
                            <td class="text-end border-bottom border-danger">{{ number_format(@$data->ContractToCal->Process_Car,2) }} บาท</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <div class="table-responsive">
                <table class="table table-nowrap mb-0">
                    <tbody>
                        <tr>
                            <th><i class="bx bxs-up-arrow-circle text-success"></i> ประกัน PA :</th>
                            <td class="text-end border-bottom border-danger">
                                {{ number_format( @$data->ContractToDataCusTags->TagToCulculate->Include_PA == 'yes' ? @$data->ContractToDataCusTags->TagToCulculate->Insurance_PA : 0,2) }} บาท
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="row">
        <h6 class="fw-semibold">- รายละเอียดค่าใช่จ่าย (หัก)</h6>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <div class="table-responsive">
                <table class="table table-striped table-nowrap mb-0">
                    <tbody>
                        <tr>
                            <th>พรบ. :</th>
                            <td class="text-end">{{ number_format(@$data->ContractToOperated->Act_Price,2)}} บาท</td>
                            <th>ภาษี :</th>
                            <td class="text-end">{{ number_format(@$data->ContractToOperated->Tax_Price,2) }} บาท</td>
                        </tr>
                        <tr>
                            <th>ประเมิน :</th>
                            <td class="text-end">{{ number_format(@$data->ContractToOperated->Evaluetion_Price,2) }} บาท</td>
                            <th>อากร :</th>
                            <td class="text-end">{{ number_format(@$data->ContractToOperated->Duty_Price,2) }} บาท</td>
                        </tr>
                        <tr>
                            <th>ประกันรถ :</th>
                            <td class="text-end">{{number_format(@$data->ContractToOperated->P2_Price,2)}} บาท</td>
                            <th>ประกัน PA :</th>
                            <td class="text-end">{{ number_format( @$data->ContractToOperated->id == NULL ? @$Insurance_PA : @$data->ContractToOperated->Insurance_PA,2) }} บาท</td>
                        </tr>
                        <tr>
                            <th>ปิดบัญชี ณ ที่ :</th>
                            <td class="text-end">{{@$data->ContractToOperated->AccountClose_Place }} บาท</td>
                            <th>การผ่อน :</th>
                            <td class="text-end">{{ @$data->ContractToOperated->Installment }}</td>
                        </tr>

                        <tr>
                            <th>ยอดปิดบัญชี :</th>
                            <td class="text-end">{{ number_format(@$data->ContractToOperated->AccountClose_Price) }} บาท</td>
                            <th>ค่าปิดบัญชี :</th>
                            <td class="text-end">{{ number_format(@$data->ContractToOperated->AccountClose_Price_fee) }} บาท</td>
                        </tr>
                        <tr>
                            <th>คชจ-ขนส่ง :</th>
                            <td class="text-end">{{ number_format(@$data->ContractToOperated->Tran_Price,2) }} บาท</td>
                            <th>อื่นๆ. :</th>
                            <td class="text-end">{{ number_format(@$data->ContractToOperated->Other_Price,2) }} บาท</td>
                        </tr>
                        <tr>
                            <th>การตลาด :</th>
                            <td class="text-end">{{ number_format(@$data->ContractToOperated->Marketing_Price,2) }} บาท</td>
                            <th>ค่าดำเนินการ :</th>
                            <td class="text-end">{{ number_format(@$data->ContractToOperated->Process_Price,2) }} บาท</td>
                        </tr>
                        <tr>
                            <th>หักค่างวดล่วงหน้า :</th>
                            <td class="text-end">{{ number_format(@$data->ContractToOperated->DuePrepaid_Price,2) }} บาท</td>
                            <th>เงินดาวน์ :</th>
                            <td class="text-end">{{number_format(@$data->ContractToOperated->Downpay_Price,2)}} บาท</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <div class="table-responsive">
                <table class="table table-nowrap mb-0">
                    <tbody>
                        <tr class="border-bottom border-danger">
                            <th>รวมค่าใช้จ่าย :</th>
                            <td class="text-end">{{ number_format(@$data->ContractToOperated->Total_Price,2) }} บาท</td>
                        </tr>
                        <tr class="bg-light border-bottom border-danger">
                            <th>คงเหลือสุทธิ :</th>
                            <th class="text-end">{{ number_format(@$data->ContractToOperated->Balance_Price,2) }} บาท</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
<!-- endOPR -->
