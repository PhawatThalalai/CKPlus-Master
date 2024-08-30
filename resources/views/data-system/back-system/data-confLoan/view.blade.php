@extends('layouts.master')
@section('title', 'System Setting')
@section('System-p1-active', 'mm-active')
@section('page-backend','d-none')
@section(@$set,'show')

@section('content')
    <input type="hidden" id="page" value="{{@$page}}">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">System Setting <small class="font-small">({{@$title_small}})</small></h4>

                {{--<div class="page-title-right font-size-14">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item active"><a href="#">รถยนต์</a></li>
                        <li class="breadcrumb-item"><a href="#">มอเตอร์ไซต์</a></li>
                    </ol>
                </div>--}}

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-2 col-lg-3 col-md-4 col-sm-12">
            <div class="card p-1">
                <button id="show-v-tabContent" class="text-white nav-link btn btn-sm btn-dark p-2 border border-white mb-2 rounded-pill" type="button" role="tab">
                    รายการตั้งค่า
                </button>
                <div class="d-grid gap-2 scroller">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical" >
                        <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-4 rounded-pill" id="tabs-4" data-set="configPsl" data-page="ConfLoan" data-bs-toggle="pill" type="button">
                            <i class="mdi mdi-cog text-danger me-1"></i> จัดการค่าคงที่ PSL
                            <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                        </button>
                        <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-4 rounded-pill" id="tabs-4" data-set="configHp" data-page="ConfLoan" data-bs-toggle="pill" type="button">
                            <i class="mdi mdi-cog text-danger me-1"></i> จัดการค่าคงที่ HP
                            <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-10 col-lg-9 col-md-8 col-sm-12">
            <div class="tab-content text-muted" id="ShowContent" style="display:none;">
                <div class="col" id="viewDataBranch"></div>
            </div>
            <div class="tab-content" id="v-tabContent">
                <div class="card card-body h-100">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="maintenance-img">
                                <img src="{{ asset('assets/images/undraw/undraw_performance.svg') }}" alt="" class="img-fluid mx-auto d-block" style="max-height: 500px;">
                            </div>
                        </div>
                    </div>
                </div>                       
            </div>
        </div>
    </div>

    <div class="modal fade bs-example-modal-center" id="Modal-xl" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-lg modal-dialog-scrollable"></div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade bs-example-modal-center" id="Modal-xxl" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog modal-xl modal-dialog-scrollable"></div><!-- /.modal-dialog -->
    </div>

    <script>
        $(document).on('click', '.Modal-xl', function(e) {
            e.preventDefault();
            var url = $(this).attr('data-link');
            $('#modal-xl .modal-dialog').empty();
            $('#Modal-xl .modal-dialog').load(url);
        });
        $(document).on('click', '.Modal-xxl', function(e) {
            e.preventDefault();
            var url = $(this).attr('data-link');
            $('#modal-xxl .modal-dialog').empty();
            $('#Modal-xxl .modal-dialog').load(url);
        });
    </script>

    @pushOnce('scripts')
        <script type="text/javascript">
            $(function() {
                $("#show-v-tabContent").click( function() {
                    $('#ShowContent').hide();
                    $('#v-tabContent').show();
                });
                $('.menuClick').click(function() {
                    var idName = $(this).attr("id");
                    var id = idName.split("-");
                    var page = $(this).data("page");
                    var setpage = $(this).data("set");

                    viewData(id[1], page, setpage);
                    $(`.menuClick`).removeClass('btn-info text-white');
                    $(`.active-${idName}`).addClass('btn-info text-white');

                });

                viewData = (id, page, setpage) => {
                    $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
                    // $(".content-loading").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
                    $.ajax({
                        url: '{{ route('dataStatic.show',[0]) }}',
                        // type: 'GET',
                        method:"GET",
                        data: {
                            page: page,
                            id: id,
                            setpage: setpage,
                            _token: "{{ @csrf_token() }}",
                        },
                        success: (response) => {
                            $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                            // $(".content-loading").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                            $('#v-tabContent').hide();
                            $('#ShowContent').show();
                            $('#viewDataBranch').html(response.html).show('slow');
                        }
                    });

                }
            });
        </script>
    @endpushOnce
@endsection