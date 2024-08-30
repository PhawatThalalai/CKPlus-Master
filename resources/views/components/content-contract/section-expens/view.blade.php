
<div class="row gap-2 m-2">

    <div class="col border border-primary p-3 rounded-3">
        <h5 class="fw-semibold my-3">รายละเอียดการจัดไฟแนนซ์ (TOP-UP)</h5>
        <table class="table table-nowrap table-sm mb-0">
            <tbody>
                <tr>
                    <td><i class="bx bxs-up-arrow-circle text-success"></i> ยอดจัด :</td>
                    <th class="text-end">{{ number_format(@$data['Cash_Car'],2) }}</th>
                </tr>
                <tr>
                    <td><i class="bx {{ @$data['StatusProcess_Car'] == 'yes' ? 'bx-plus-circle text-success' : 'bx-minus-circle text-danger' }}"></i> ค่าดำเนินการ :</td>
                    <th class="text-end">{{ number_format(@$data['Process_Car'],2) }}</th>
                </tr>
                @if( strtoupper(@$data['Buy_PA']) == 'YES')
                <tr>
                    <td><i class="bx {{ strtoupper(@$data['Include_PA']) == 'YES' ? 'bx-plus-circle text-success' : 'bx-minus-circle text-danger' }}"></i> ประกัน PA :</td>
                    <th class="text-end">{{number_format( @$data['Insurance_PA'],2) }}</th>
                </tr>
                @endif
            </tbody>
        </table>
    </div>

    <div class="col border border-primary p-3 rounded-3">
        <h5 class="fw-semibold my-3">รายละเอียดค่าใช้จ่าย (Payment Details)</h5>
        <table class="table table-striped table-sm table-nowrap mb-0">
            <thead>
                <tr>
                    <th>รายการ</th>
                    <th class="text-end">จำนวน (บาท)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>พรบ. :</td>
                    <th class="text-end">{{ number_format(@$data['Act_Price'],2) }}</th>
                </tr>
                <tr>
                    <td>ประเมิน :</td>
                    <th class="text-end">{{ number_format(@$data['Evaluetion_Price'],2) }}</th>
                </tr>
                <tr>
                    <td>ประกันรถ :</td>
                    <th class="text-end">{{ number_format(@$data['P2_Price'],2) }}</th>
                </tr>
                <tr>
                    <td>ปิดบัญชี ณ ที่ :</td>
                    <th class="text-end">{{ @$data['AccountClose_Place'] }}</th>
                </tr>

                <tr>
                    <td>ยอดปิดบัญชี :</td>
                    <th class="text-end">{{ number_format(@$data['AccountClose_Price'],2) }}</th>
                </tr>
                <tr>
                    <td>คชจ-ขนส่ง :</td>
                    <th class="text-end">{{ number_format(@$data['Tran_Price'],2) }}</th>
                </tr>
                <tr>
                    <td>การตลาด :</td>
                    <th class="text-end">{{ number_format(@$data['Marketing_Price'],2) }}</th>
                </tr>
                <tr>
                    <td>หักค่างวดล่วงหน้า :</td>
                    <th class="text-end">{{ number_format(@$data['DuePrepaid_Price'],2) }}</th>
                </tr>
                <tr>
                    <td>โอนเงินให้ลูกค้าล่วงหน้า :</td>
                    <th class="text-end">{{ number_format(@$data['ReceiveCashBefore'],2) }}</th>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="col border border-primary p-3 rounded-3">
        <h5 class="fw-semibold my-3">รายละเอียดค่าใช้จ่าย (Payment Details)</h5>
        <table class="table table-striped table-sm table-nowrap mb-0">
             <thead>
                <tr>
                    <th>รายการ</th>
                    <th class="text-end">จำนวน (บาท)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>ภาษี :</td>
                    <th class="text-end">{{ number_format(@$data['Tax_Price'],2) }}</th>
                </tr>
                <tr>
                    <td>อากร :</td>
                    <th class="text-end">{{ number_format(@$data['Duty_Price'],2) }}</th>
                </tr>
                <tr>
                    <td>ประกัน PA :</td>
                    <th class="text-end">{{ strtoupper(@$data['Include_PA']) == 'YES' ? number_format(@$data['Insurance_PA'],2) : 0.00 }}</th>
                </tr>
                <tr>
                    <td>การผ่อน :</td>
                    <th class="text-end">{{ @$data['Installment'] }}</th>
                </tr>

                <tr>
                    <td>ค่าปิดบัญชี :</td>
                    <th class="text-end">{{ number_format(@$data['AccountClose_Price_fee'],2) }}</th>
                </tr>
                <tr>
                    <td>ค่าดำเนินการ :</td>
                    <th class="text-end">{{ number_format(@$data['Process_Price'],2) }}</th>
                </tr>
                <tr>
                    <td>เงินดาวน์ :</td>
                    <th class="text-end">{{ number_format(@$data['Downpay_Price'],2) }}</th>
                </tr>
                <tr>
                    <td>อื่นๆ. :</td>
                    <th class="text-end">{{ number_format(@$data['Other_Price'],2) }}</th>
                </tr>
                <tr>
                    <td>กำหนดวันโอนส่วนที่เหลือ :</td>
                    @if($data['LastTransfer'] != NULL)
                        <th class="text-end">{{ formatDateThai($data['LastTransfer']) }}</th>
                    @else
                        <th class="text-end">-</th>
                    @endif
                </tr>
            </tbody>
        </table>
    </div>

    <div class="col border border-success p-3 rounded-3">
        <h5 class="fw-semibold my-3">สรุปค่าใช้จ่าย (Total Payments)</h5>
        <table class="table table-nowrap table-sm mb-0">
            <tbody>
                <tr class="border-bottom border-danger">
                    <th>รวมค่าใช้จ่าย :</th>
                    <td class="text-end">{{ number_format(@$data['Total_Price'],2) }} บาท</td>
                </tr>
                <tr class="border-bottom border-danger">
                    <th>คงเหลือสุทธิ :</th>
                    <th class="text-end">{{ number_format(@$data['Balance_Price'],2) }} บาท</th>
                </tr>
            </tbody>
        </table>
    </div>

</div>

<div class="row ">
    <div class="col text-end">
        <a id="" class="col-xl col-lg col-md col-sm text-center btn btn-primary me-1 data-modal-xl-2"  data-link="{{ route('contract.create') }}?id={{ @$data['Pactcon_id'] }}&type={{'EditExpenses'}}">แก้ไข</a>
    </div>
</div>
