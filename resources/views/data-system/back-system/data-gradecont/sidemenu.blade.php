@extends('layouts.master')
@section('title', 'System Setting')
@section('System-p1-active', 'mm-active')
@section('page-frontend','d-none')
@section(@$set,'show')

@section('content')
    <style>
        /* Add some basic styling for the button */
        #button {
            display: none;
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 45px;
            height: 50px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 50%;
            text-align: center;
            line-height: 50px;
            cursor: pointer;
            z-index: 1000;
        }
        #button.show {
            display: inline-block;
        }
    </style>
    
    <input type="hidden" id="page" value="{{@$page}}">

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18">System Setting <small class="font-small">({{@$title_small}})</small></h4>
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
                        @if(@$set == 'data-gradecont')
                            <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 menuClick active-tabs-1 rounded-pill" id="tabs-1" data-set="gradecont" data-bs-toggle="pill" type="button">
                                <i class="mdi mdi-cog text-danger me-1"></i> เกรดสัญญา
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
                                <img src="{{ asset('assets/images/undraw/inoffice.svg') }}" alt="" class="img-fluid mx-auto d-block" style="max-height: 500px;">
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

    <!-- <a id="button" href="#top" class="font-size-14"><i class="mdi mdi-triangle mdi-24px"></i></a> -->

    <script>
        // --------- button-to-top --------------
        var btn = $('#button');
        $(window).scroll(function() {
            if ($(window).scrollTop() > 300) {
            btn.addClass('show');
            } else {
            btn.removeClass('show');
            }
        });
        btn.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({scrollTop:0}, '300');
        });
    </script>

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



