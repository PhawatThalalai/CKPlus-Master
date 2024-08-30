
    <div id="CardContracts">
        <style>
            .custom-popover {
            --bs-popover-max-width: 35rem;/* 300px; */
            --bs-popover-border-color: var(--bs-primary);
            --bs-popover-header-bg: var(--bs-primary);
            --bs-popover-header-color: var(--bs-white);
            --bs-popover-body-padding-x: 1rem;
            --bs-popover-body-padding-y: .5rem;
            overflow-y: auto;
            max-height: 30rem;
            }
        </style>

        @php
            if (@$data['Status_Con'] == 'complete' || @$data['Status_Con'] == 'transfered' || @$data['Status_Con'] == 'close'){
                $color = 'text-success';
                $colorbadge = 'btn-outline-success';
                $bordercolor = 'border-success';
            }
            elseif(@$data['Status_Con'] == 'pending'){
                $color = 'text-warning';
                $colorbadge = 'btn-outline-warning';
                $bordercolor = 'border-warning';
            }
            elseif(@$data['Status_Con'] == 'active' ){
                $color = 'text-info';
                $colorbadge = 'btn-outline-info';
                $bordercolor = 'border-info';
            }
            else{
                $color = 'text-danger';
                $colorbadge = 'btn-outline-danger';
                $bordercolor = 'border-danger';
            }
        @endphp

        <div class="card mb-2">
            <div class="card-body">
                <div class="row">
                    @if(@$data['cardProfile'] == true)
                    <div class="col-xl col-lg col-md col-sm-12 col-md-12 text-center border-end " >
                        <div id="Header-Details">
                            @include('components.content-contract.section-cardCon.Header-Deatils')
                        </div>
                    </div>
                    @endif

                    <div class="col-xl col-lg col-md col-sm-12 col-md-12 border-end">
                        <div id="Contract-Details">
                            @include('components.content-contract.section-cardCon.Contract-Details')
                        </div>
                    </div>

                    <div class="col-xl col-lg col-md col-sm-12 col-md-12">
                        <div id="Customer-Details">
                            @include('components.content-contract.section-cardCon.Customer-Details')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


