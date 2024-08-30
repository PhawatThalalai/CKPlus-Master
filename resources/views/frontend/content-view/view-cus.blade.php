@extends('layouts.master')
@section('title', 'view customers')
@section(@$sidebarMain, 'mm-active')
@section(@$sidebarSec, 'mm-active')
@section(@$sidebarTs, 'mm-active')
@section('page-backend', 'd-none')

@section('content')
	<style>
		/* .dateHide span{
                display:none;
        } */
		.dateHide p {
			display: none;
		}
        .h-loading {
            /* height: 500px;
            min-height: 500px; */
            top: 30%;
        }
	</style>
	<!-- <link rel="stylesheet" href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"> -->

    {{-- setup search --}}
    @include('components.content-search.view-search',['page_type' => @$page_type, 'page' => @$page, 'pageUrl' => @$pageUrl, 'typeSreach' => @$typeSreach, 'dataSreach' => @$dataSreach])
	@include('components.content-toast.view-toast')
	@component('components.breadcrumb')
		@slot('title')
			{{ $title }}
		@endslot
		@slot('title_small')
			{{ $title_small }}
		@endslot
        @slot('menu')
			{{ $menu }}
		@endslot
		@slot('sub_menu')
			{{ $sub_menu }}
		@endslot
	@endcomponent

    @component('components.content-date.date-range')
        @slot('data', [
			'page' => @$page,
			'Fdate' => @$Fdate1,
			'Tdate' => @$Tdate1,
            'statusTxt' => @$statusTxt,
            'status_cus' => @$status_cus,
		])
		@slot('btn', [
			'btn_statuscus' => true,
			'btn_print' => false,
		])
    @endcomponent
    
    {{-- <div class="d-flex bd-highlight">
        <div class="me-auto bd-highlight">
            <div class="search-box-top">
                <div class="float-sm-start d-sm-flex flex-wrap gap-2 align-items-center">
                    <button type="button" class="btn btn-light w-lg btn-rounded waves-effect">Light</button>
                    <button type="button" class="btn btn-light w-lg btn-rounded waves-effect">Light</button>
                </div>
            </div>
        </div>
        <div class="bd-highlight">
            @component('components.content-date.date-range')
                @slot('data', ['status_cus' => @$status_cus, 'type' => @$type, 'Fdate' => @$Fdate1, 'Tdate' => @$Tdate1, 'statusTxt' => @$statusTxt])
            @endcomponent
        </div>
    </div> --}}

    {{-- <div class="clearfix">
        <div class="float-end">
            <div class="input-group input-group-sm">
                <select class="form-select form-select-sm">
                    <option value="JA" selected="">Jan</option>
                    <option value="DE">Dec</option>
                    <option value="NO">Nov</option>
                    <option value="OC">Oct</option>
                </select>
                <label class="input-group-text">Month</label>
            </div>
        </div>
        <h4 class="card-title mb-4">Earning</h4>
    </div> --}}

    <div class="row p-2 d-xl-none d-lg-none d-md-none">
        <div class="card shadow-sm p-3 bg-light">
            <h5 class="font-size-14"><b>สาขาทั้งหมด (All Branch)</b></h5>
            <div class="row mb-2">
                <div class="col d-grid">
                    <button class="btn btn-soft-warning btn-rounded waves-effect waves-light data-modal-xl-2" data-link="{{ route('ControlCenter.create') }}?funs={{'calculates'}}&zone={{Auth::user()->zone}}&FlagPage=Y">
                        <i class="bx bxs-map me-1"></i> คำนวณ
                    </button>
                </div>
            </div>
			<div style="cursor: pointer; overflow: auto;  height: auto;" class="scroll-slide">
				<div id="container">
					@component('components.content-branch.card-branch')
						@slot('data', [
							'dataBranch' => @$dataBranch,
							'countDataBranch' => @$countDataBranch,
						])
					@endcomponent
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-1">
        <div class="col-xl-2 col-lg-2 col-md-3 shadow-sm d-none d-sm-none d-md-block">
            <div class="row g-2">
                <div class="col-12">
                    <div class="d-grid gap-2">        
                        <button type="button" class="btn btn-soft-warning btn-rounded waves-effect waves-light data-modal-xl-2" data-link="{{ route('ControlCenter.create') }}?funs={{'calculates'}}&zone={{Auth::user()->zone}}&FlagPage=Y">
                            <i class="bx bx-calculator bx-tada font-size-16 align-middle"></i> คำนวณ
                        </button>
                    </div>
                </div>
            </div>
            <div class="mt-1">
                @component('components.content-branch.select-branch')
                    @slot('data', [
                        'dataBranch' => @$dataBranch,
                        'countDataBranch' => @$countDataBranch,
                    ])
                @endcomponent
            </div>
        </div>
        <div class="col-xl-10 col-lg-10 col-md-9">
            <div class="tab-content" id="v-pills-tabContent">
                @component('components.content-page.welcome-select')
					@slot('title')
						ข้อมูลลูกค้า
					@endslot
				@endcomponent
                <div class="content-loading" style="display: none !important">
                    <div class="lds-facebook h-loading">
                        <div></div>
                        <div></div>
                        <div></div>
                    </div>
                </div>

                <div class="col" id="viewDataBranch"></div>
            </div>
        </div>
    </div>



    @pushOnce('scripts')
        <script>
            $(".viewWalkin1").DataTable({
                "responsive": false,
                "autoWidth": false,
                "ordering": true,
                "lengthChange": true,
                "order": [
                    [0, "asc"]
                ],
                "pageLength": 10,
            });
        </script>

        <script>
            $('.branchClick,.branchClickCard').click(function() {
                var idName = $(this).attr("id");
                var id = idName.split("-");
                var page = $('#page').val();
                var fdate = $('#start').val();
                var tdate = $('#end').val();
                var statusTxt = $('#statusTxt').val();
                var BranchChk = $("#id_branch").val();
               
                if(idName!='tabs-'+BranchChk){
                   viewData(id[1], page, fdate, tdate, statusTxt); 
                }
                
                $(`.branchClickCard`).removeClass('btn btn-info text-white');
                $(`.activecard-${idName}`).addClass('btn btn-info text-white');
                $(`.branchClick`).removeClass('btn-info text-white');
                $(`.active-${idName}`).addClass('btn-info text-white');
            });

            viewData = (id, page, fdate, tdate, statusTxt) => {
                $('#viewDataBranch').hide();
			    $(".content-loading").fadeIn().attr('style', ''); //** แสดงตัวโหลด **

                $.ajax({
                    url: '{{ route('view.store') }}',
                    type: 'POST',
                    data: {
                        page: page,
                        id: id,
                        start: fdate,
                        end: tdate,
                        statusTxt: statusTxt,
                        _token: "{{ @csrf_token() }}",
                    },
                    success: (response) => {
					    $(".content-loading").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                        $('#viewDataBranch').html(response.html).slideDown('slow');
                    }
                });

            }
        </script>
    @endpushOnce
@endsection
