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
                        @if(@$set == 'data-companies')
                            <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-1 rounded-pill" id="tabs-1" data-set="company" data-bs-toggle="pill" type="button">
                                <i class="mdi mdi-cog text-danger me-1"></i> รายชื่อบริษัท
                                <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                            </button>

                            <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-2 rounded-pill" id="tabs-2" data-set="branch" data-bs-toggle="pill" type="button">
                                <i class="mdi mdi-cog text-danger me-1"></i> จัดการสาขา
                                <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                            </button>

                            <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-3 rounded-pill" id="tabs-3" data-set="bank" data-bs-toggle="pill" type="button">
                                <i class="mdi mdi-cog text-danger me-1"></i> จัดการบัญชีบริษัท
                                <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                            </button>

                            <!-- <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-19 rounded-pill" id="tabs-19" data-set="target-type" data-bs-toggle="pill" type="button">
                                <i class="mdi mdi-cog text-danger me-1"></i> ประเภทเป้าสาขา
                                <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                            </button>

                            <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-4 rounded-pill" id="tabs-4" data-set="target-branch" data-bs-toggle="pill" type="button">
                                <i class="mdi mdi-cog text-danger me-1"></i> จัดการเป้าสาขา
                                <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                            </button> -->

                            <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-5 rounded-pill" id="tabs-5" data-set="ms-teams" data-bs-toggle="pill" type="button">
                                <i class="mdi mdi-cog text-danger me-1"></i> Ms Teams
                                <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                            </button>

                            <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-6 rounded-pill" id="tabs-6" data-set="categories" data-bs-toggle="pill" type="button">
                                <i class="mdi mdi-cog text-danger me-1"></i> หมวดเอกสาร
                                <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                            </button>

                            <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-billcoll rounded-pill" id="tabs-billcoll" data-set="billcoll" data-bs-toggle="pill" type="button">
                                <i class="mdi mdi-cog text-danger me-1"></i> พนักงานเก็บเงิน
                                <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                            </button>

                        @elseif(@$set == 'data-contract')
                            <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-7 rounded-pill" id="tabs-7" data-set="contract-type" data-bs-toggle="pill" type="button">
                                <i class="mdi mdi-cog text-danger me-1"></i> ตั้งค่าประเภทสัญญา
                                <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                            </button>

                            <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-8 rounded-pill" id="tabs-8" data-set="contract-number" data-bs-toggle="pill" type="button">
                                <i class="mdi mdi-cog text-danger me-1"></i> จัดการเลขที่สัญญา
                                <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                            </button>

                            <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-9 rounded-pill" id="tabs-9" data-set="promotion" data-bs-toggle="pill" type="button">
                                <i class="mdi mdi-cog text-danger me-1"></i> Promotion!
                                <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                            </button>
                        @elseif(@$set == 'data-interest')
                            <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-10 rounded-pill" id="tabs-10" data-set="interest" data-bs-toggle="pill" type="button">
                                <i class="mdi mdi-cog text-danger me-1"></i> จัดการดอกเบี้ย
                                <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                            </button>
                        @elseif(@$set == 'data-general')
                            <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-11 rounded-pill" id="tabs-11" data-set="status-customer" data-bs-toggle="pill" type="button">
                                <i class="mdi mdi-cog text-danger me-1"></i> จัดการสถานะลูกค้า
                                <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                            </button>
                            <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-12 rounded-pill" id="tabs-12" data-set="resoure" data-bs-toggle="pill" type="button">
                                <i class="mdi mdi-cog text-danger me-1"></i> จัดการที่มาลูกค้า
                                <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                            </button>
                            <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-13 rounded-pill" id="tabs-13" data-set="career" data-bs-toggle="pill" type="button">
                                <i class="mdi mdi-cog text-danger me-1"></i> จัดการอาชีพ
                                <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                            </button>
                            <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-14 rounded-pill" id="tabs-14" data-set="address" data-bs-toggle="pill" type="button">
                                <i class="mdi mdi-cog text-danger me-1"></i> จัดการที่อยู่
                                <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                            </button>
                            <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-15 rounded-pill" id="tabs-15" data-set="relation" data-bs-toggle="pill" type="button">
                                <i class="mdi mdi-cog text-danger me-1"></i> จัดการความสัมพันธ์
                                <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                            </button>
                            <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-16 rounded-pill" id="tabs-16" data-set="status-loan" data-bs-toggle="pill" type="button">
                                <i class="mdi mdi-cog text-danger me-1"></i> จัดการสถานะการกู้
                                <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                            </button>
                            <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-17 rounded-pill" id="tabs-17" data-set="status-credo" data-bs-toggle="pill" type="button">
                                <i class="mdi mdi-cog text-danger me-1"></i> จัดการสถานะ Credo
                                <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                            </button>
                            <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-18 rounded-pill" id="tabs-18" data-set="score-credo" data-bs-toggle="pill" type="button">
                                <i class="mdi mdi-cog text-danger me-1"></i> จัดการ Score Credo
                                <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                            </button>
                        @elseif(@$set == 'data-intogroup')
                            <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-19 rounded-pill" id="tabs-19" data-set="target-type" data-bs-toggle="pill" type="button">
                                <i class="mdi mdi-cog text-danger me-1"></i> ประเภทเป้าสาขา
                                <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                            </button>

                            <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-4 rounded-pill" id="tabs-4" data-set="target-branch" data-bs-toggle="pill" type="button">
                                <i class="mdi mdi-cog text-danger me-1"></i> จัดการเป้าสาขา
                                <span class="col text-end"> <span class="badge rounded-pill bg-danger"></span> </span>
                            </button>
                        @endif  
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
                    var page = $('#page').val();
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



