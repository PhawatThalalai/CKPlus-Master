@extends('layouts.master')
@section('title', 'Rate Setting')
@section('Rate-p1-active', 'mm-active')
@section('page-backend','d-none')

@section('content')
<script src="{{ URL::asset('/assets/js/bootstrap-dialog.min.js') }}"></script>

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
		background-color: #F5F5F5;
	}

	.scroll-slide::-webkit-scrollbar-thumb {
		border-radius: 10px;
		-webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
		background-color: #ddd;
	}

	.resize {
		transform-origin: 100% 50%;
	}
</style>

<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Rate Setting <small class="font-small">({{@$title_small}})</small></h4>

            <div class="page-title-right font-size-14">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item text-primary">
                        <!-- <a href="{{route('dataStatic.index')}}?page={{'frontend'}}&set={{'data-rate'}}&setsub={{'rate-car'}}"> -->
                            รถยนต์
                        <!-- </a> -->
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{route('dataStatic.index')}}?page={{'frontend'}}&set={{'data-rate'}}&setsub={{'rate-moto'}}" class="">
                            มอเตอร์ไซต์
                        </a>
                    </li>
                </ol>
            </div>

        </div>
    </div>
</div>

<div class="row p-2 d-xl-none d-lg-none d-md-none">
    <div class="card shadow-sm p-3 bg-light">
        <!-- <h5 class="font-size-14"><b>รายการยี่ห้อ</b></h5> -->
        <table class="table align-middle table-hover rounded-top bg-dark">
            <!-- <thead class="table-dark"> -->
            <tr class="table-dark">
                <th class="rounded-start" id="show-v-tabContent">
                    <span class="mt-n1">รายการยี่ห้อ</span>
                </th>
                <th class="rounded-end">
                    <ul class="text-end list-inline ont-size-18 contact-links mb-0">
                        <li class="list-inline-item">
                            <a class="dropdown-item edit-details Modal-xl" data-bs-toggle="modal" data-bs-target="#Modal-xl" data-link="{{ route('CarRate.create') }}?create={{'brand'}}" style="cursor:pointer;">
                                <i class="bx bx-plus-circle text-white"></i>
                            </a>
                        </li>
                    </ul>
                </th>
            </tr>
        </table>
        <div style="cursor: pointer; overflow: auto;  height: auto;" class="scroll-slide">
            <div id="container">
                @foreach ($data as $key => $car)
                    <div class="slide-content">
                        <div class="nav flex-column nav-pills mb-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                            <!-- <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 active d-none" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">
                                <i class="bx bxs-map me-1"></i> Home
                            </button> -->

                            <button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 rounded-pill BrandClick active-tabs-{{$key+1}}" id="tabs-{{$key+1}}" data-id="{{$car->id}}" data-bs-toggle="pill">
                                <i class="mdi mdi-car-wash font-size-14 text-danger me-2"></i> {{$car->Brand_car}}
                                <span class="col text-end"> <span title="{{$car->Brand_car}}"></span> </span>
                            </button>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-12 d-none d-sm-none d-md-block">
        <div class="card p-1">
            <table class="table align-middle bg-dark">
                <!-- <thead class="table-dark"> -->
                <tr class="table-dark">
                    <th class="" id="show-v-tabContent">
                        <span class="mt-n1">รายการยี่ห้อ</span>
                    </th>
                    <th class="">
                        <ul class="text-end list-inline ont-size-18 contact-links mb-0">
                            <li class="list-inline-item">
                                <a class="dropdown-item edit-details Modal-xl" data-bs-toggle="modal" data-bs-target="#Modal-xl" data-link="{{ route('CarRate.create') }}?create={{'brand'}}" style="cursor:pointer;">
                                    <i class="bx bx-plus-circle text-white"></i>
                                </a>
                            </li>
                        </ul>
                    </th>
                </tr>
            </table>
            <!-- <div id="BrandDetails2"> -->
                <div class="d-grid gap-1 scroller mt-n2">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        {{csrf_field()}}
                        @foreach ($data as $key => $car)
                            <!-- <button class="btn btn-soft-info waves-effect waves-light mb-1 rounded-pill BrandClick active-tabs-{{$key+1}} d-flex bd-highlight" id="tabs-{{$key+1}}" data-id="{{$car->id}}" data-bs-toggle="pill">
                                <span class="me-auto bd-highlight">
                                    <i class="mdi mdi-car-wash font-size-14 text-danger me-2"></i> 
                                    {{$car->Brand_car}}
                                </span>
                                <a class="Modal-lg bd-highlight d-none edit-btn edit-{{$key+1}}" data-bs-toggle="modal" data-bs-target="#Modal-lg" data-link="{{ route('CarRate.edit',@$car->id) }}?edit={{'brandcar'}}" style="cursor:pointer;">
                                    <i class="bx bx-edit-alt text-warning"></i>
                                </a>
                                <a class="Modal-lg bd-highlight d-none edit-tabs-{{$key+1}}" data-bs-toggle="modal" data-bs-target="#Modal-lg" data-link="{{ route('CarRate.edit',@$car->id) }}?edit={{'brandcar'}}" style="cursor:pointer;">
                                    <i class="bx bx-trash text-danger"></i>
                                </a>
                            </button> -->
                            <table class="rounded-pill mb-1">
                                <tr>
                                    <td class="p-2 bg-info bg-soft rounded-pill rounded-5 BrandClick active-tabs-{{$key+1}} active-{{$key+1}}" id="tabs-{{$key+1}}" data-id="{{$car->id}}" data-bs-toggle="pill" style="width:400px;cursor:pointer;">
                                            <a href="#" class="text-dark">
                                                <i class="mdi mdi-car-wash text-danger me-1"></i> 
                                                <span class="text-info text-btn text-{{$key+1}}" id="brand-{{$key+1}}" style="line-height:120%;">{{$car->Brand_car}}</span>
                                            </a>
                                    </td>
                                    <td class="p-2 d-none bg-info edit-btn edit-{{$key+1}} rounded-end rounded-5">
                                            <a class="edit-brand Modal-lg" data-bs-toggle="modal" data-bs-target="#Modal-lg" data-link="{{ route('CarRate.edit',@$car->id) }}?edit={{'brandcar'}}&key={{$key+1}}" style="cursor:pointer;">
                                                <i class="bx bx-edit-alt text-warning"></i>
                                            </a>
                                    </td>
                                </tr>
                            </table>
                        @endforeach
                    </div>
                </div>
            <!-- </div> -->
        </div>
    </div>
    <div class="col-xl-10 col-lg-9 col-md-8 col-sm-12">
        <div class="tab-content text-muted" id="ShowContent" style="display:none;">
            <div class="col" id="viewDataCar"></div>
        </div>
        <div class="tab-content" id="v-tabContent">
            <div class="card card-body h-100">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="maintenance-img">
                            <img src="{{ asset('assets/images/undraw/car_stock2.svg') }}" alt="" class="img-fluid mx-auto d-block" style="height: 63vh;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<a id="buttonTop"></a>

<div class="modal fade" id="Modal-xl" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="ModalScrollableTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog"></div><!-- /.modal-dialog -->
</div>

<div class="modal fade" id="Modal-lg" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2">
    <div class="modal-dialog modal-lg" role="document"></div><!-- /.modal-dialog -->
</div>

<script>
    $(document).on('click', '.Modal-xl', function(e) {
        e.preventDefault();
        var url = $(this).attr('data-link');
        $('#Modal-xl .modal-dialog').load(url);
    });
    $(document).on('click', '.Modal-lg', function(e) {
        e.preventDefault();
        var url = $(this).attr('data-link');
        $('#Modal-lg .modal-dialog').load(url);
    });
</script>

{{-- Drag Modal --}}
<!-- <script>
    $('#Modal-lg .modal-dialog').resizable({
        minWidth: 625,
        minHeight: 175,
        handle: 'n, e, s, w, ne, sw, se, nw',
    })
    $('.modal-dialog').draggable({
        cursor: "move",
        handle: "#Modal-drag"
    });
</script> -->
<script>
    $('.modal-content').resizable({
        //alsoResize: ".modal-dialog",
        minHeight: 300,
        minWidth: 300
    });
    $('.modal-dialog').draggable();
</script>

<script>
    $(function() {
        $("#show-v-tabContent").click(function() {
            $('#ShowContent').hide();
            $('#v-tabContent').show();
        });
        $('.BrandClick').click(function() {
            var idName = $(this).attr("id");
            var id = idName.split("-");
            var brand_id = $(this).data("id");
            var brand_name = $(this).text();
            viewData(id[1],brand_id,brand_name,idName);
            // $(`.BrandClick`).removeClass('btn-info text-white');
            // $(`.active-${idName}`).addClass('btn-info text-white');
            // $(`.text-${id}`).addClass('text-white');
            $(`.BrandClick`).addClass('bg-soft');
            $(`.edit-btn`).addClass('d-none');
            $(`.text-${id}`).addClass('text-info');
            $(`.text-btn`).removeClass('text-white');
            // $(`.text-btn`).addClass('text-info');
        });

        viewData = (id,brand_id,brand_name,idName) => {
            $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
            $.ajax({
                url: "{{ route('CarRate.index') }}",
                method:"GET",
                data: {
                    id: id,
                    type: 1,
                    brand_id: brand_id,
                    brand_name: brand_name,
                    _token: "{{@csrf_token()}}",
                },
                success: (response) => {
                    $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                    $(`.edit-${id}`).removeClass('d-none');
                    $(`.text-${id}`).addClass('text-white');
                    $(`.active-${id}`).removeClass('bg-soft');
                    $('#v-tabContent').hide();
                    $('#ShowContent').show();
                    $('#viewDataCar').html(response.html).show('slow');
                }
            });
        }
    });
</script>
@endsection



