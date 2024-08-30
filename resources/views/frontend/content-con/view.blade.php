@extends('layouts.master')
@section('title', 'approve loans')
@section(@$sidebarMain, 'mm-active')
@section(@$sidebarSec, 'mm-active')
@section(@$sidebarTs, 'mm-active')
@section('page-backend', 'd-none')
@section('content')
    @include('components.content-search.view-search', [
        'page_type' => $page_type,
        'page' => $page,
        'pageUrl' => $pageUrl,
        'typeSreach' => $typeSreach,
        'dataSreach' => $dataSreach,
    ])

    <style>
        .btnAdd:hover {
            opacity: 0.7;
            cursor: pointer;
        }

        #container {
            position: relative;
            width: 100%;
            white-space: nowrap;
            scroll-snap-type: x mandatory;
        }

        .slide-content {
            display: inline-block;
        }

        .scroll-slide::-webkit-scrollbar {
            width: 5px;
            height: 7px;
            background-color: #fff;
        }

        .scroll-slide::-webkit-scrollbar-thumb {
            background-color: #fff;
        }

        .resize {
            transform-origin: 100% 50%;
        }

        .filter-img {
            filter: invert(1);
            scale: 1.2;
            transition: 0.3s;
        }

        .btnTab:hover {
            filter: invert(1);
            scale: 1.2;
            transition: 0.1s;
        }


        .block-card {
            pointer-events: none;
        }

        .filter-grey {
            filter: grayscale(1);
        }

        .con-popover {
            --bs-popover-max-width: 300px;
            --bs-popover-border-color: var(--bs-danger);
            --bs-popover-header-bg: var(--bs-danger);
            --bs-popover-header-color: var(--bs-white);
            --bs-popover-body-padding-x: 1rem;
            --bs-popover-body-padding-y: .5rem;
        }

    /*  button fixed */
        .action-button {
            display: block;
            position: fixed;
            width: 4em;
            height: 4em;
            z-index: 10;
            bottom: 4em;
            right: 4em;
            border-radius: 50%;
            cursor: pointer;
        }
    </style>


    <style>
        .alert-help {
            --bs-popover-max-width: 300px;
            --bs-popover-border-color: var(--bs-primary);
            --bs-popover-header-bg: var(--bs-primary);
            --bs-popover-header-color: var(--bs-white);
            --bs-popover-body-padding-x: 1rem;
            --bs-popover-body-padding-y: .5rem;
        }
    </style>

    <!-- hidden input -->
    <input type="hidden" value="{{ @$data->id }}" id="PactCon_id">
    <input type="hidden" value="{{ @$data->DataTag_id }}" id="DataTag_id">
    <input type="hidden" id="Status_Con" value="{{@$data['Status_Con']}}">
    <input type="text" hidden id="Status_Audit" value="{{$roleNum}}" placeholder="ค่าถูก set มาจาก controller">

    <div id="section-cardCon">
        @include('frontend.content-con.view-headerCon')
    </div>

    <div class="card pt-1" style="min-height : 550px;">
        <!-- tab approve -->
        <div id="section-Tab">
            @include('frontend.content-con.view-tab')
        </div>

        <div class="tab-pane fade active show" id="asset-tab-pane" role="tabpanel" aria-labelledby="asset-tab"
            tabindex="0">
            <div class="loading">
                <div class="lds-facebook">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <div id="section-content">
            </div>
        </div>


        {{-- <button class="action-button btn btn-primary help-alert modal_md"
            data-link="{{ route('contract.show',@$data->id) }}?funs={{'showHelper'}}"
            data-toggle="popover" data-bs-placement="left" data-bs-title="<p class='fw-semibold mb-0'> <i class='bx bx-error-circle'></i> ข้อมูลผู้แนะนำ ! </p>" data-bs-custom-class="alert-help" data-bs-content="
            <div class='row'>
                <div class='col-12 fs-6 fw-semibold'>
                    * ตรวจสอบ
                </div>
                <div class='col-12 fs-6 text-center text-danger fw-semibold border-top border-light py-2 bg-light'><i class='bx bx-bulb'></i> เพิ่มข้อมูลให้ครบถ้วนก่อนทำการขออนุมัติ</div>
            </div>">
            <i class="fs-4 bx bx-tada mdi mdi-chat-processing-outline"></i>
        </button> --}}
    </div>

    <script>
        $(function(){
            $('.help-alert').popover('show');
            setTimeout(() => {
                $('.help-alert').popover('hide');
            }, 10000);
        })
    </script>

    {{-- js modal content --}}

    {{-- <script>
        var myModalEl = document.getElementById('modal_xl_2')
        myModalEl.addEventListener('hidden.bs.modal', function(event) {
            $('#modal_xl_2 .modal-xl').empty();
        })
    </script> --}}


    {{-- click tab content --}}
    <script>
        $(function() {
            sessionStorage.removeItem('element');
            sessionStorage.removeItem('PactCon_id');
            sessionStorage.removeItem('DataCus_id');
            sessionStorage.setItem('PactCon_id', '{{ @$data->id }}')
            sessionStorage.setItem('DataCus_id', '{{ @$data->DataCus_id }}')
            sessionStorage.setItem('TypeCus', '{{ @$data->ContractToDataCusTags->Type_Customer }}')
            getContent('section-asset', 'section-asset')
        })
        getContent = (type, element) => {
            let datasession = sessionStorage.getItem('element');
            let PactCon_id = sessionStorage.getItem('PactCon_id')

            if (element != datasession && PactCon_id != '') {
                $(".contenthead").addClass('block-card filter-grey');
                sessionStorage.setItem('element', element);

                $('#' + element).html('')
                $(".loading").fadeIn()
                $.ajax({
                    url: '{{ route('contract.show', 0) }}',
                    type: 'GET',
                    data: {
                        PactCon_id: PactCon_id,
                        type: type,
                        _token: '{{ @csrf_token() }}'
                    },
                    success: (res) => {
                        $(".loading").hide()
                        $('#section-content').html(res.html)
                        $(".contenthead").removeClass('block-card filter-grey');

                        $('.img-defualt').removeClass('filter-img')
                        $('.' + type).addClass('filter-img ')
                    },
                    error: (err) => {
                        $('#section-content').html('error !')
                        $(".loading").hide()
                        $(".contenthead").removeClass('block-card filter-grey');
                        $('.img-defualt').removeClass('filter-img')
                        $('.' + type).addClass('filter-img ')
                    }
                })
            } else {
                //
            }
        }
    </script>


    <script>
        function PositionScroll(ElementID) {
            const element = document.getElementById(ElementID);
            let x = element.scrollLeft;
            let y = element.scrollTop;
            let result = 1 - (x / 165);
            document.getElementById("demo").innerHTML = "Horizontally: " + x.toFixed() + "<br>Vertically: " + result;
            let size = $('.resize').width();

            if (x >= 120) {
                $('.showScroll').show();
            } else {
                $('.showScroll').hide();
                $('.resize').css('scale', `${result}`);
            }
        }

        function resetScroll(ElementID) {
            const element = document.getElementById(ElementID);
            element.scrollLeft = 0;
            PositionScroll(ElementID);
        }
    </script>





@endsection
