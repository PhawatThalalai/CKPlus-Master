<div class="bg-white section mb-1" style="padding-top:0px; padding-bottom:0px;">
    <!-- END TAB NEW -->
    <div class="row p-2">
        <div id="scrollContentLeft" class="col-xl-1  m-auto border-end">
            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill btn-scroll-left">
                <span class="d-block d-sm-none"><i class="bx bx bxs-left-arrow"></i></span>
                <span class="d-none d-sm-block">
                        <i class="bx bx bxs-left-arrow"></i>
                        <b>Back</b>
                    </span>
            </button>
        </div>
        <div class="col-xl-10 ">
            <ul class="nav nav-pills nav-justified section  p-1 pb-1" role="tablist">
                <div id="scrollTab" class="d-flex scrollTab" style="overflow-x : hidden;">
                    <li class="nav-item waves-effect waves-light" role="presentation" style="min-width:250px;">
                        <a class="nav-link btn-nav" onclick="getTab('contract-details')" data-bs-toggle="tab" href="#card-contracts-details" role="tab" aria-selected="true" >
                            <span class="d-block d-sm-none"><i class="mdi mdi-book-open-page-variant font-size-15"></i></span>
                            <span class="d-none d-sm-block">
                                <i class="mdi mdi-book-open-page-variant font-size-15"></i>
                                <b>รายละเอียดสัญญา</b>
                            </span>
                        </a>
                    </li>

                    <li class="nav-item waves-effect waves-light" role="presentation" style="min-width:250px;">
                        <a class="nav-link btn-nav" onclick="getTab('table-install')" data-bs-toggle="tab" href="#card-installment-schedule" role="tab" aria-selected="true">
                            <span class="d-block d-sm-none"><i class="fas fa-calendar-day"></i></span>
                            <span class="d-none d-sm-block">
                                <i class="fas fa-calendar-day"></i>
                                <b>ตารางค่างวด</b>
                            </span>
                        </a>
                    </li>

                    <li class="nav-item waves-effect waves-light {{ @$flag }}" role="presentation" style="min-width:250px;">
                        <a class="nav-link btn-nav" onclick="getTab('table-payment')" data-bs-toggle="tab" href="#card-payment-schedule" role="tab" aria-selected="false" tabindex="-1">
                            <span class="d-block d-sm-none"><i class="fas fa-file-invoice-dollar"></i></span>
                            <span class="d-none d-sm-block">
                                <i class="fas fa-file-invoice-dollar"></i>
                                <b>ตารางรับชำระ</b>
                            </span>
                        </a>
                    </li>

                    <li class="nav-item waves-effect waves-light {{ @$flag }}" role="presentation" style="min-width:250px;">
                        <a class="nav-link btn-nav" onclick="getTab('table-fee')" data-bs-toggle="tab" href="#card-table-fee" role="tab" aria-selected="false" tabindex="-1">
                            <span class="d-block d-sm-none"><i class="mdi mdi-cash-plus font-size-16"></i></span>
                            <span class="d-none d-sm-block">
                                <i class="mdi mdi-cash-plus font-size-16"></i>
                                <b>ค่าธรรมเนียมอื่นๆ</b>
                            </span>
                        </a>
                    </li>

                    <li class="nav-item waves-effect waves-light {{ @$flag }}" role="presentation" style="min-width:250px;">
                        <a class="nav-link btn-nav" onclick="getTab('table-deposit')" data-bs-toggle="tab" href="#card-table-deposit" role="tab" aria-selected="false" tabindex="-1">
                            <span class="d-block d-sm-none"><i class="fas fa-hand-holding-usd"></i></span>
                            <span class="d-none d-sm-block">
                                <i class="fas fa-hand-holding-usd"></i>
                                <b>รับฝากค่างวด</b>
                            </span>
                        </a>
                    </li>

                    <li class="nav-item waves-effect waves-light {{ @$flag }}" role="presentation" style="min-width:250px;">
                        <a class="nav-link btn-nav" onclick="getTab('table-installments')" data-bs-toggle="tab" href="#card-debt-schedule" role="tab" aria-selected="false" tabindex="-1">
                            <span class="d-block d-sm-none"><i class="fas fa-hand-holding-usd"></i></span>
                            <span class="d-none d-sm-block">
                                <i class="fas fa-hand-holding-usd"></i>
                                <b>ตารางภาระหนี้</b>
                            </span>
                        </a>
                    </li>

                </div>
            </ul>
        </div>
        <div id="scrollContentRight" class="col-xl-1 m-auto border-start text-end">
            <button type="button" class="btn btn-outline-primary btn-sm rounded-pill btn-scroll-right">
                <span class="d-block d-sm-none"><i class="bx bx bxs-right-arrow"></i></span>
                <span class="d-none d-sm-block">
                        <i class="bx bx bxs-right-arrow"></i>
                        <b>Next</b>
                    </span>
            </button>
        </div>
    </div>
</div>

<div class="tab-content" id="myTabContent">

    <div class="tab-pane fade show active" id="card-contracts-details" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
        <div class="contract-details_tab" id="contract-details_tab">
            <div class="card text-center" id="img-empty">
                <div class="card-body">
                    <img src="{{ asset('assets/images/undraw/datasync.svg') }}" class="w-50" alt="" srcset="">
                </div>
            </div>
        </div>
        <div class="contract-details_loading" style="display:none;">
            @include('backend.content-contract.section-content.table-loading')
        </div>
    </div>


    <div class="tab-pane fade" id="card-installment-schedule" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
        <div class="table-install_tab" id="table-install_tab"></div>

        <div class="table-install_loading" style="display:none;">
            @include('backend.content-contract.section-content.table-loading')
        </div>
    </div>

    <div class="tab-pane fade" id="card-payment-schedule" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
        <div class="table-payment_tab" id="table-payment_tab"> </div>
        <div class="table-payment_loading" style="display:none;">
            @include('backend.content-contract.section-content.table-loading')
        </div>
    </div>

    <div class="tab-pane fade" id="card-table-fee" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">
        <div class="table-fee_tab" id="table-fee_tab"> </div>

        <div class="table-fee_loading" style="display:none;">
            @include('backend.content-contract.section-content.table-loading')
        </div>
    </div>

    <div class="tab-pane fade" id="card-table-deposit" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">
        <div class="table-deposit_tab" id="table-deposit_tab"> </div>

        <div class="table-deposit_loading" style="display:none;">
            @include('backend.content-contract.section-content.table-loading')
        </div>
    </div>

    <div class="tab-pane fade" id="card-debt-schedule" role="tabpanel" aria-labelledby="disabled-tab" tabindex="0">
        <div class="table-installments_tab" id="table-installments_tab"></div>

        <div class="table-installments_loading" style="display:none;">
            @include('backend.content-contract.section-content.table-loading')
        </div>
    </div>
</div>
<!-- ENDTAB  -->




<script>

$(function() {
        let countScroll = 0;
        let widthScroll = 200;
        let TotalwidthScroll = $('.scrollTab')[0].scrollWidth != 0 ? $('.scrollTab')[0].scrollWidth : 1500;

        //console.log(TotalwidthScroll)
        $('.btn-scroll-left').prop('disabled',true);
        $('.btn-scroll-right').click(()=>{

            $('.scrollTab').animate({ scrollLeft: '+=' + TotalwidthScroll }, 200);
            countScroll += TotalwidthScroll ;
            checkScroll(countScroll);
        })
        $('.btn-scroll-left').click(()=>{

            $('.scrollTab').animate({ scrollLeft: '-=' + TotalwidthScroll }, 200);
            countScroll -= TotalwidthScroll ;
            checkScroll(countScroll);
        })

        checkScroll = (countScroll) =>{
            if(countScroll >= TotalwidthScroll){
                $('.btn-scroll-right').prop('disabled',true);
                $('.btn-scroll-left').prop('disabled',false);
            }else{
                $('.btn-scroll-right').prop('disabled',false);
                $('.btn-scroll-left').prop('disabled',true);
            }
        }

    })

</script>
