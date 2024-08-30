<div class="modal-content">
		<div class="d-flex m-3 mb-0">
			<div class="flex-shrink-0 me-4">
				<img src="{{ URL::asset('\assets\images\signature.png') }}" alt="" style="width: 30px;">
			</div>
			<div class="flex-grow-1 overflow-hidden">
				<h4 class="text-primary fw-semibold">ประวัติการใช้งาน (History Contract)</h4>
				<p class="text-muted mt-n1 fw-semibold font-size-12">เลขสัญญา : {{@$data_con[0]->LogsToPact->Contract_Con}}</p>
				<p class="border-primary border-bottom mt-n2"></p>
			</div>
			<button type="button" class="btn-close" data-bs-dismiss="modal" tabindex="-1" aria-label="Close"></button>
		</div>
		<div class="modal-body mx-3">

            @php

             $LogAssets = @$data_con->filter(function ($query)  {
                return  $query->model=='LogAssetsContract';
             });

             $LogGuaran = @$data_con->filter(function ($query)  {
                return  $query->model=='LogGuaranContract';
             });

             $LogPayee = @$data_con->filter(function ($query)  {
                return  $query->model=='LogPayeeContract';
             });

             $LogBroker = @$data_con->filter(function ($query)  {
                return  $query->model=='LogBrokerContract';
             });

             $LogExpenses = @$data_con->filter(function ($query)  {
                return  $query->model=='LogExpensesContract';
             });

             $LogContract = @$data_con->filter(function ($query)  {
                return  $query->model=='LogDataContract';
             });
            @endphp

			<!-- content -->
            <div class="row g-2">
                <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">
                                    <div class="d-flex justify-content-between">
                                        ทั้งหมด
                                        <span class="badge rounded-pill text-bg-danger bx-tada">{{ count((@$data_con)) }}</span>
                                    </div>
                                </button>
                                <button class="nav-link" id="v-pills-assets-tab" data-bs-toggle="pill" data-bs-target="#v-pills-assets" type="button" role="tab" aria-controls="v-pills-assets" aria-selected="false">
                                    <div class="d-flex justify-content-between">
                                        ทรัพย์
                                        <span class="badge rounded-pill text-bg-danger bx-tada">{{ count((@$LogAssets)) }}</span>
                                    </div>
                                </button>
                                <button class="nav-link" id="v-pills-Guaran-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Guaran" type="button" role="tab" aria-controls="v-pills-Guaran" aria-selected="false">
                                    <div class="d-flex justify-content-between">
                                        ผู้ค้ำ
                                        <span class="badge rounded-pill text-bg-danger bx-tada">{{ count((@$LogGuaran)) }}</span>
                                    </div>
                                </button>
                                <button class="nav-link" id="v-pills-payee-tab" data-bs-toggle="pill" data-bs-target="#v-pills-payee" type="button" role="tab" aria-controls="v-pills-payee" aria-selected="false">
                                    <div class="d-flex justify-content-between">
                                        ผู้รับเงิน
                                        <span class="badge rounded-pill text-bg-danger bx-tada">{{ count((@$LogPayee)) }}</span>
                                    </div>
                                </button>
                                <button class="nav-link" id="v-pills-Broker-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Broker" type="button" role="tab" aria-controls="v-pills-Broker" aria-selected="false">
                                    <div class="d-flex justify-content-between">
                                        ผู้แนะนำ
                                        <span class="badge rounded-pill text-bg-danger bx-tada">{{ count((@$LogBroker)) }}</span>
                                    </div>
                                </button>
                                <button class="nav-link" id="v-pills-Expenses-tab" data-bs-toggle="pill" data-bs-target="#v-pills-Expenses" type="button" role="tab" aria-controls="v-pills-Expenses" aria-selected="false">
                                    <div class="d-flex justify-content-between">
                                        ค่าใช้จ่าย
                                        <span class="badge rounded-pill text-bg-danger bx-tada">{{ count((@$LogExpenses)) }}</span>
                                    </div>
                                </button>
                                <button class="nav-link" id="v-pills-cons-tab" data-bs-toggle="pill" data-bs-target="#v-pills-cons" type="button" role="tab" aria-controls="v-pills-cons" aria-selected="false">
                                    <div class="d-flex justify-content-between">
                                        ข้อมูลการอนุมัติ
                                        <span class="badge rounded-pill text-bg-danger bx-tada">{{ count((@$LogContract)) }}</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
                    <div class="card h-100">
                        <div class="card-body">
                            <div class="tab-content" id="v-pills-tabContent">
                                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab" tabindex="0">
                                    @component('components.content-contract.scetion-showdata.data-history')
                                    @slot('data', [
                                        'data' => @$data_con
                                    ]);
                                    @endcomponent
                                </div>
                                <div class="tab-pane fade" id="v-pills-assets" role="tabpanel" aria-labelledby="v-pills-assets-tab" tabindex="0">
                                    @component('components.content-contract.scetion-showdata.data-history')
                                    @slot('data', [
                                        'data' => @$LogAssets
                                    ]);
                                    @endcomponent
                                </div>
                                <div class="tab-pane fade" id="v-pills-Guaran" role="tabpanel" aria-labelledby="v-pills-Guaran-tab" tabindex="0">
                                    @component('components.content-contract.scetion-showdata.data-history')
                                    @slot('data', [
                                        'data' => @$LogGuaran
                                    ]);
                                    @endcomponent
                                </div>
                                <div class="tab-pane fade" id="v-pills-payee" role="tabpanel" aria-labelledby="v-pills-payee-tab" tabindex="0">
                                    @component('components.content-contract.scetion-showdata.data-history')
                                    @slot('data', [
                                        'data' => @$LogPayee
                                    ]);
                                    @endcomponent
                                </div>
                                <div class="tab-pane fade" id="v-pills-Broker" role="tabpanel" aria-labelledby="v-pills-Broker-tab" tabindex="0">
                                    @component('components.content-contract.scetion-showdata.data-history')
                                    @slot('data', [
                                        'data' => @$LogBroker
                                    ]);
                                    @endcomponent
                                </div>
                                <div class="tab-pane fade" id="v-pills-Expenses" role="tabpanel" aria-labelledby="v-pills-Expenses-tab" tabindex="0">
                                    @component('components.content-contract.scetion-showdata.data-history')
                                    @slot('data', [
                                        'data' => @$LogExpenses
                                    ]);
                                    @endcomponent
                                </div>
                                <div class="tab-pane fade" id="v-pills-cons" role="tabpanel" aria-labelledby="v-pills-cons-tab" tabindex="0">
                                    @component('components.content-contract.scetion-showdata.data-history')
                                    @slot('data', [
                                        'data' => @$LogContract
                                    ]);
                                    @endcomponent
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<!-- endcontent -->

        </div>

		<div class="modal-footer">
			<button type="button" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">ปิด</button>
		</div>
</div>
