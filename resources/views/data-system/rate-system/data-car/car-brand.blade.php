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

@if(@$scale == 'small')
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
@elseif(@$scale == 'large')
    <div class="d-grid gap-1 scroller mt-n2">
        <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
            {{csrf_field()}}
            @foreach ($data as $key => $car)
                <button class="btn btn-soft-info waves-effect waves-light mb-1 rounded-pill BrandClick active-tabs-{{$key+1}} d-flex bd-highlight" id="tabs-{{$key+1}}" data-id="{{$car->id}}" data-bs-toggle="pill">
                    <span class="me-auto bd-highlight">
                        <i class="mdi mdi-car-wash font-size-14 text-danger me-2"></i> 
                        {{$car->Brand_car}}
                    </span>
                    <!-- <a class="Modal-lg bd-highlight d-none edit-{{$key+1}}" data-bs-toggle="modal" data-bs-target="#Modal-lg" data-link="{{ route('CarRate.edit',@$car->id) }}?edit={{'brandcar'}}" style="cursor:pointer;">
                        <i class="bx bx-edit-alt text-warning"></i>
                    </a> -->
                    <!-- <a class="Modal-lg bd-highlight d-none edit-tabs-{{$key+1}}" data-bs-toggle="modal" data-bs-target="#Modal-lg" data-link="{{ route('CarRate.edit',@$car->id) }}?edit={{'brandcar'}}" style="cursor:pointer;">
                        <i class="bx bx-trash text-danger"></i>
                    </a> -->
                </button>
                <!-- <table class="bg-info bg-opacity-25 waves-effect waves-light d-flex mb-1 rounded-pill">
                    <tr>
                        <th class="p-2">
                            <div class="d-flex justify-content-between">
                                <a href="#" class="text-dark BrandClick active-tabs-{{$key+1}}" id="tabs-{{$key+1}}" data-id="{{$car->id}}" data-bs-toggle="pill">
                                    <i class="mdi mdi-car-wash text-danger me-1"></i> 
                                    <span style="line-height:120%;">{{$car->Brand_car}}</span>
                                </a>
                                <a class="edit-brand Modal-lg" data-bs-toggle="modal" data-bs-target="#Modal-lg" data-link="{{ route('CarRate.edit',@$car->id) }}?edit={{'brandcar'}}" style="cursor:pointer;">
                                    <i class="bx bx-edit-alt text-warning"></i>
                                </a>
                            </div>
                        </th>
                    </tr>
                </table> -->
            @endforeach
        </div>
    </div>
@endif

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
            $(`.BrandClick`).removeClass('btn-info text-white');
            $(`.active-${idName}`).addClass('btn-info text-white');
        });

        viewData = (id,brand_id,brand_name) => {
            $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
            // console.log(id-1);
            // $(`.edit-${id-1}`).addClass('d-none');
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
                    // $(`.edit-${id}`).removeClass('d-none');
                    $('#v-tabContent').hide();
                    $('#ShowContent').show();
                    $('#viewDataCar').html(response.html).show('slow');
                }
            });
        }
    });
</script>