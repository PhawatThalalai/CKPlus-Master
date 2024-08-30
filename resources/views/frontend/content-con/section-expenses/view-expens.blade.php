@if( $data != NULL )
    @component('components.content-contract.section-expens.view')
        @slot('data', [
            'Pactcon_id' => @$data->PactCon_id,
            'Cash_Car' => @$data->OperatedToCusCal->Cash_Car,
            'Process_Car' => @$data->OperatedToCusCal->Process_Car,
            'StatusProcess_Car' => @$data->OperatedToCusCal->StatusProcess_Car,
            'Include_PA' => @$data->OperatedToCusCal->Include_PA,
            'Buy_PA' => @$data->OperatedToCusCal->Buy_PA,
            'Insurance_PA' => @$data->OperatedToCusCal->Insurance_PA,
            'AccountClose_Price' => $data->AccountClose_Price,
            'AccountClose_Price_fee' => $data->AccountClose_Price_fee,
            'P2_Price' => $data->P2_Price,
            // 'Insurance_PA' => $data->Insurance_PA,
            'Act_Price' => $data->Act_Price,
            'Tax_Price' => $data->Tax_Price,
            'Tran_Price' => $data->Tran_Price,
            'Other_Price' => $data->Other_Price,
            'Evaluetion_Price' => $data->Evaluetion_Price,
            'Duty_Price' => $data->Duty_Price,
            'Marketing_Price' => $data->Marketing_Price,
            'Downpay_Price' => $data->Downpay_Price,
            'DuePrepaid_Price' => $data->DuePrepaid_Price,
            'Process_Price' => $data->Process_Price,
            'Total_Price' => $data->Total_Price,
            'Balance_Price' => $data->Balance_Price,
            'AccountClose_Place' => $data->AccountClose_Place,
            'Installment' => $data->Installment,
            'ReceiveCashBefore' => $data->ReceiveCashBefore,
            'LastTransfer' => $data->LastTransfer,
        ]);
    @endcomponent
@else
    <div class="row" >
        <div class="col-12 text-center">
            <img src="{{URL::asset('\assets\images\out-of-stock.png')}}" class="up-down mt-4" alt="" style="width:100px;">
        </div>
        <div class="col-12 text-center" style = " min-height:20rem; max-height:20rem;">
            <h5 class=" fw-semibold mt-2">ยังไม่มีรายละเอียดการชำระเงิน</h5>
            <a id="" class="col-xl col-lg col-md col-sm text-center btn btn-primary btn-sm me-1 rounded-pill data-modal-xl-2" data-bs-toggle="modal" data-bs-target="#modal_xl_2" data-link="{{ route('contract.create') }}?id={{@$PactCon_id}}&type={{'EditExpenses'}}"><i class="bx bxs-user-plus"></i> เพิ่มรายละเอียดการชำระเงิน</a>
        </div>
    </div>
@endif



