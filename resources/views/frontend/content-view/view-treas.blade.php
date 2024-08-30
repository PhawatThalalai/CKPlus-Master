@extends('layouts.master')
@section('title', 'financial-approval')
@section('financial-approval-active', 'mm-active')
@section('page-backend', 'd-none')

@section('content')
    @include('components.content-search.view-search',['page_type' => @$page_type, 'page' => @$page, 'pageUrl' => @$pageUrl, 'typeSreach' => @$typeSreach, 'dataSreach' => @$dataSreach])

	@component('components.breadcrumb')
		@slot('title')
			{{ $title }}
		@endslot
		@slot('title_small')
			{{ $title_small }}
		@endslot
		@slot('menu')
			ระบบ โอนเงินสินเชื่อ
		@endslot
		@slot('sub_menu')
			รายการโอนเงิน
		@endslot
	@endcomponent

    <div class="pt-2 px-2 mb-1">
        <div class="row g-2">
            <div class=" col-xl-3">
                <div class="card p-2 h-100">
                    <div class="row g-2">
                        <div class="col-12">
                            <div class="d-grid gap-2 mb-2 border-bottom border-2 border-danger pb-3">
                                <button type="button" class="btn btn-soft-warning btn-rounded waves-effect waves-light data-modal-xl-2" data-link="{{ route('treas.create') }}?page={{'history-transfer'}}">
                                    <i class="bx bx-history font-size-16 align-middle"></i> history transfer
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="row mx-1 mb-2 ">
                        <div class="col text-center">
                            <label class="form-label fw-semibold">All Company</label>
                        </div>
                    </div>
                    <ul class="nav nav-pills mb-3 row" id="pills-tab" role="tablist">
                        <li class="nav-item col d-grid" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" data-tabCont="nav-now" data-count="{{ array_sum(@$countContractNow) }}" type="button" role="tab" aria-controls="pills-home" aria-selected="true">
                                รายการล่าสุด 
                                <span class="badge rounded-pill bg-danger nav-countContNew">{{ array_sum(@$countContractNow) }} </span>
                                <span>รายการ</span>
                            </button>
                        </li>
                        <li class="nav-item col d-grid" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" data-tabCont="nav-old" data-count="{{ array_sum(@$countContractOld) }}" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">
                                รายการตกค้าง 
                                <span class="badge rounded-pill bg-danger nav-countContOld">{{ array_sum(@$countContractOld) }} </span>
                                <span>รายการ</span>
                            </button>
                        </li>
                      </ul>
                      <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
                            @component('components.content-card.card-treas')
                            @slot('data',[
                                'title' => 'รายการเช่าซื้อ',
                                'tab' => 'tabNow',
                                'typeLoan' => '2',
                                'AKACom' => 'CKL',
                                'record_stat'=>'NEW',
                                'listCount' => @$countContractNow[2],
                                'creditBalance' => '999,999',
                                'com' => '2',
                            ])
                            @endcomponent

                            @component('components.content-card.card-treas')
                            @slot('data',[
                                'title' => 'รายการเงินกู้',
                                'tab' => 'tabNow',
                                'typeLoan' => '1',
                                'AKACom' => 'CKP',
                                'record_stat'=>'NEW',
                                'listCount' => @$countContractNow[1],
                                'creditBalance' => '999,999',
                                'com' => '1'
                            ])
                            @endcomponent
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab" tabindex="0">
                            @component('components.content-card.card-treas')
                            @slot('data',[
                                'title' => 'รายการเช่าซื้อ',
                                'tab' => 'tabOld',
                                'typeLoan' => '2',
                                'AKACom' => 'CKL',
                                'record_stat'=>'OLD',
                                'listCount' => @$countContractOld[2],
                                'creditBalance' => '999,999',
                                'com' => '2'
                            ])
                            @endcomponent

                            @component('components.content-card.card-treas')
                            @slot('data',[
                                'title' => 'รายการเงินกู้',
                                'tab' => 'tabOld',
                                'typeLoan' => '1',
                                'AKACom' => 'CKP',
                                'record_stat'=>'OLD',
                                'listCount' => @$countContractOld[1],
                                'creditBalance' => '999,999',
                                'com' => '1'
                            ])
                            @endcomponent
                        </div>
                      </div>
                </div>
            </div>

            <div class="col">
                <div class="card p-2 h-100">
                    <div id="viewTable">
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    $('.type_loan').click(function() {
        $('.type_loan').removeClass('border-primary');
        var  id_type =  $(this).attr("id");
        var type_loan = $(this).data("typeloan");
        var dataTab = $(this).attr("data-tab");

        $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
        $.ajax({
            url: "{{ route('view.store') }}",
            type: 'POST',
            data: {
                page : 'financial-approval',
                dataTab : dataTab,
                type_loan : type_loan,
                _token: "{{ @csrf_token() }}",
            },
            success: (response) => {
                $(this).addClass('border-primary active');
                $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                $('#viewTable').html(response.html).slideDown('slow');
            }

        });
    });
</script>
@endsection
