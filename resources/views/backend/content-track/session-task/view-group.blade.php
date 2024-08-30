{{--
<style>
    .navs-carousel .owl-nav button {
        width: 30px;
        height: 30px;
        line-height: 28px !important;
        font-size: 20px !important;
        border-radius: 50% !important;
        background-color: rgba(85, 110, 230, 0.25) !important;
        color: #556ee6 !important;
        margin: 4px 8px !important;
    }

    .owl-prev {
        width: 15px;
        height: 78px;
        position: absolute;
        top: 40%;
        margin-left: -25px;
        display: block !important;
        border: 0px solid black;
        font-size: xx-large !important;
    }

    .owl-next {
        width: 15px;
        height: 78px;
        position: absolute;
        top: 40%;
        right: 5px;
        display: block !important;
        border: 0px solid black;
        font-size: xx-large !important;
    }

    .owl-prev i,
    .owl-next i {
        transform: scale(1, 6);
        color: #ccc;
    }
</style>
--}}

{{-- 
<h1 class="d-block d-sm-none">XS</h1>
<h1 class="d-none d-sm-block d-md-none">SM</h1>
<h1 class="d-none d-sm-none d-md-block d-lg-none">MD</h1>
<h1 class="d-none d-md-none d-lg-block d-xl-none">LG</h1>
<h1 class="d-none d-xl-block">XL</h1>
--}}

@if(@$data != NULL)

    @if(@$group == 'phone')
        <p class="text-primary">แบ่งงานได้ทั้งหมด <strong>{{ count($data) }}</strong> สาขา, จำนวนงานทั้งหมด <strong>{{ $count_all }}</strong> งาน</p>
        <div class="row">
            @foreach( $data as $index => $item)
                @php
                    $progressbar = number_format( $item->TOTAL * 100 / $count_all );
                @endphp
                <div class="col-12 col-sm-6 col-md-4 col-lg-6 col-xl-4">
                    <div class="card border border-dark">
                        <div class="text-uppercase" style="position: absolute; left: 1rem; top: 1rem;">
                            #{{ $loop->index + 1 }} 
                            @if( !empty($item->ToBranch->NickName_Branch) )
                                - {{$item->ToBranch->NickName_Branch}}
                            @endif
                        </div>
                        <div class="card-body p-3">

                            <div class="d-flex justify-content-end mb-3">
                                <a class="btn btn-secondary waves-effect waves-light data-modal-xl-2" data-link="{{ route('spast.edit', @$item->LOCAT) }}?page=group&TYPECONT={{@$TYPECONT}}&FPERIOD={{@$FPERIOD}}&TPERIOD={{@$TPERIOD}}&GROUP={{@$group}}&COUNT={{$item->TOTAL}}&locat_index={{$loop->index + 1}}">
                                    <i class="bx bx-log-in"></i> จัดกลุ่มงาน
                                </a>
                            </div>

                            <h4 class="card-title">{{$item->ToBranch->Name_Branch}}</h4>

                            <div class="progress progress-lg">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: {{$progressbar}}%;" aria-valuenow="{{$progressbar}}" aria-valuemin="0" aria-valuemax="100"><strong>{{$progressbar}}%</strong></div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <small class="text-muted float-start">
                                จำนวน {{ number_format($item->TOTAL) }} งาน
                            </small>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    {{-- 
    @php  
        //dump($data);
    @endphp
    
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="mb-2">
                    <div class="btn-group btn-xs btn-group-example" role="group">
                        <button id="V1" type="button" class="btn btn-outline-success active"><i class="bx bx-grid-horizontal"></i></button>
                        <button id="V2" type="button" class="btn btn-outline-success"><i class="bx bx-list-ul"></i></button>
                    </div>
                </div>
            </div>
            @if(@$group == 'กลุ่มงานโทร')
                <div class="row mb-3" id="View1">
                    <div class="owl-carousel">
                        @foreach($data as $i => $value)
                            <div class="item" data-slide-index="{{$i}}">
                                <div class="card task-box border border-secondary" id="cmptask-1">
                                    <div class="card-body">
                                        <div class="dropdown float-end">
                                            <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item edittask-details Modal-xl-3" data-bs-toggle="modal" data-bs-target="#Modal-xl-3" data-link="{{ route('datatrack.edit', @$value->LOCAT) }}?type={{5}}&TYPECONT={{@$TYPECONT}}&COUNT={{@$value->TOTAL}}&GROUP={{@$group}}" style="cursor:pointer;">
                                                <!-- <a class="dropdown-item edittask-details" href="{{ route('datatrack.edit', @$value->LOCAT) }}?type={{5}}&TYPECONT={{@$TYPECONT}}" style="cursor:pointer;"> -->
                                                    <i class="bx bx-log-in text-primary"></i> จัดกลุ่มงาน
                                                </a>
                                            </div>
                                        </div>
                                        <div class="float-end">
                                            <span class="badge rounded-pill {{(@$value->STATUS == 'Complete')?'badge-soft-success':'badge-soft-warning'}} font-size-12" id="task-status">{{@$value->STATUS}}</span><br>
                                        </div>
                                        <div>
                                            <h5 class="font-size-15 card-title">
                                                <a href="javascript: void(0);" class="text-dark" id="task-name">
                                                    <!-- กลุ่มงานที่ {{$i+1}} -->
                                                    ({{@$value->LOCAT}}) สาขา{{@$value->ToBranch->Name_Branch}}
                                                </a>
                                            </h5>
                                            <div class="row">
                                                <div class="text-muted mt-4">
                                                    <h4 class="mb-2"><i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>
                                                    <div class="custom-progess mb-4">
                                                        <div class="progress progress-sm">
                                                            <div class="progress-bar bg-info" role="progressbar" style="width: 62%" aria-valuenow="62" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                        <div class="avatar-xs progress-icon">
                                                            <span class="avatar-title rounded-circle border border-info">
                                                                <i class="bx bxl-jquery text-info font-size-18"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <!-- <div class>
                                                        <div class="progress">
                                                            <div class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                                                        </div>
                                                    </div> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <small class="text-muted float-start">
                                            จำนวน: {{@$value->TOTAL}} ราย.
                                        </small>
                                        @if($value->BILLCOLL != NULL)
                                            <small class="text-muted float-end">
                                                BILLCOLL: {{@$value->BILLCOLL}}.
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="row" id="View2" style="display:none">
                    <div class="col-lg-12" data-simplebar="init" style="max-height: 420px;">
                        <div class="accordion" id="accordionExample">
                            @foreach($data as $i => $value)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{$i}}" aria-expanded="false" aria-controls="collapse-{{$i}}">
                                            <!-- Group #{{$i+1}} -->
                                            ({{@$value->LOCAT}}) สาขา{{@$value->ToBranch->Name_Branch}}
                                        </button>
                                    </h2>
                                    <div id="collapse-{{$i}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="text-muted">
                                                @php 
                                                    if(@$TYPECONT == 'HP'){
                                                        @$dataSpastdue = \App\Models\TB_PatchContracts\TB_InsideTrackings\PatchHP\PatchHP_SPASTDUE::where('LOCAT', $value->LOCAT)->get();
                                                    }
                                                    else if(@$TYPECONT == 'PSL'){
                                                        @$dataSpastdue = \App\Models\TB_PatchContracts\TB_InsideTrackings\PatchPSL\PatchPSL_SPASTDUE::where('LOCAT', $value->LOCAT)->get();
                                                    }
                                                @endphp
                                                <table class="table table-sm m-0 table-group">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>CONTNO</th>
                                                            <th>NAME</th>
                                                            <th>BILLCOLL</th>
                                                            <th>SALECOD</th>
                                                            <th>CONSTAT</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach(@$dataSpastdue as $key => $row)
                                                            <tr>
                                                                <th scope="row">{{@$key+1}}</th>
                                                                <td>{{@$row->CONTNO}}</td>
                                                                <td>{{@$row->ToContract->PatchToPact->ContractToCus->Name_Cus}}</td>
                                                                <td>{{@$row->BILLCOLL}}</td>
                                                                <td>{{@$row->SALECOD}}</td>
                                                                <td>{{@$row->CONTSTAT}}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>     
                    </div>
                </div>
            @elseif(@$group == 'กลุ่มงานตาม')
                <div class="row mb-3" id="View1">
                    <div class="owl-carousel">
                        @for ($i = 0; $i < $amount; $i++)
                                <div class="item" data-slide-index="{{$i}}">
                                    <div class="card task-box border border-secondary" id="cmptask-1">
                                        <div class="card-body">
                                            <div class="dropdown float-end">
                                                <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item edittask-details Modal-xl-2" data-bs-toggle="modal" data-bs-target="#Modal-xl-2" data-link="{{ route('datatrack.edit', 1) }}?type={{4}}&TYPECONT={{@$TYPECONT}}&GROUP={{@$group}}" style="cursor:pointer;">
                                                        <i class="bx bx-log-in text-primary"></i> มอบหมายงาน
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="float-end">
                                                <span class="badge rounded-pill badge-soft-warning font-size-12" id="task-status">Wait</span><br>
                                            </div>
                                            <div>
                                                <h5 class="font-size-15 card-title">
                                                    <a href="javascript: void(0);" class="text-dark" id="task-name">
                                                        กลุ่มงานที่ {{$i+1}}
                                                    </a>
                                                </h5>
                                                <div class="row">
                                                    <div class="text-muted mt-4">
                                                        <h4 class="mb-2"><i class="mdi mdi-chevron-up ms-1 text-success"></i></h4>
                                                        <div class>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-success" role="progressbar" style="width: 25%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <small class="text-muted float-start">
                                                จำนวน: {{50}} ราย.
                                            </small>
                                            <small class="text-muted float-end">
                                                BILLCOLL: ....
                                            </small>
                                        </div>
                                    </div>
                                </div>
                        @endfor
                    </div>
                </div>
                <div class="row" id="View2" style="display:none">
                    <div class="col-lg-12" data-simplebar="init" style="max-height: 420px;">
                        <div class="accordion" id="accordionExample">
                            @for ($i = 0; $i < $amount; $i++)
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-{{$i}}" aria-expanded="false" aria-controls="collapse-{{$i}}">
                                            Group #{{$i+1}}
                                        </button>
                                    </h2>
                                    <div id="collapse-{{$i}}" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            <div class="text-muted">
                                                <table class="table table-sm m-0 table-group">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>First Name</th>
                                                            <th>Last Name</th>
                                                            <th>Username</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th scope="row">1</th>
                                                            <td>Mark</td>
                                                            <td>Otto</td>
                                                            <td>@mdo</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">2</th>
                                                            <td>Jacob</td>
                                                            <td>Thornton</td>
                                                            <td>@fat</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">3</th>
                                                            <td>Larry</td>
                                                            <td>the Bird</td>
                                                            <td>@twitter</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">4</th>
                                                            <td>Mark</td>
                                                            <td>Otto</td>
                                                            <td>@mdo</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">5</th>
                                                            <td>Jacob</td>
                                                            <td>Thornton</td>
                                                            <td>@fat</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>     
                    </div>
                </div>
            @endif
        </div>
    </div>
    --}}

@endif

<script type="text/javascript">
  $(function() {
    $("#V1").click( function() {
        $('#V1').addClass('active');
        $('#V2').removeClass('active');
        $('#View1').show();
        $('#View2').hide();
    });
    $("#V2").click( function() {
        $('#V2').addClass('active');
        $('#V1').removeClass('active');
        $('#View1').hide();
        $('#View2').show();
    });
  });
</script>

{{-- DataTable --}}
<script>
  $(document).ready(function() {
        $('.table-group').DataTable( {
            "responsive": true,
            "autoWidth": false,
            "ordering": true,
            "lengthChange": true,
            "order": [[ 0, "asc" ]]
        });
  });
</script>

{{-- carousel --}}
<script>
    $(document).ready(function() {
        var el = $('.owl-carousel');

        var carousel;
        var carouselOptions = {
            margin: 25,
            nav: true,
            dots: false,
            merge: true,
            autoHeight: true,
            slideBy: 'page',
            navText: ["<i class='mdi mdi-arrow-left-circle'></i>", "<i class='mdi mdi-arrow-right-circle'></i>"],
            //stagePadding: 25,
            responsive: {
                0: {
                    mergeFit: true,
                    items: 1,
                    rows: 2 //custom option not used by Owl Carousel, but used by the algorithm below
                },
                768: {
                    mergeFit: true,
                    items: 3,
                    rows: 2 //custom option not used by Owl Carousel, but used by the algorithm below
                },
                991: {
                    mergeFit: true,
                    items: 3,
                    rows: 2 //custom option not used by Owl Carousel, but used by the algorithm below
                }
            }
        };

        //Taken from Owl Carousel so we calculate width the same way
        var viewport = function() {
            var width;
            if (carouselOptions.responsiveBaseElement && carouselOptions.responsiveBaseElement !== window) {
                width = $(carouselOptions.responsiveBaseElement).width();
            } else if (window.innerWidth) {
                width = window.innerWidth;
            } else if (document.documentElement && document.documentElement.clientWidth) {
                width = document.documentElement.clientWidth;
            } else {
                console.warn('Can not detect viewport width.');
            }
            return width;
        };

        var severalRows = false;
        var orderedBreakpoints = [];
        for (var breakpoint in carouselOptions.responsive) {
            if (carouselOptions.responsive[breakpoint].rows > 1) {
                severalRows = true;
            }
            orderedBreakpoints.push(parseInt(breakpoint));
        }

        //Custom logic is active if carousel is set up to have more than one row for some given window width
        if (severalRows) {
            orderedBreakpoints.sort(function(a, b) {
                return b - a;
            });
            var slides = el.find('[data-slide-index]');
            var slidesNb = slides.length;
            if (slidesNb > 0) {
                var rowsNb;
                var previousRowsNb = undefined;
                var colsNb;
                var previousColsNb = undefined;

                //Calculates number of rows and cols based on current window width
                var updateRowsColsNb = function() {
                    var width = viewport();
                    for (var i = 0; i < orderedBreakpoints.length; i++) {
                        var breakpoint = orderedBreakpoints[i];
                        if (width >= breakpoint || i == (orderedBreakpoints.length - 1)) {
                            var breakpointSettings = carouselOptions.responsive['' + breakpoint];
                            rowsNb = breakpointSettings.rows;
                            colsNb = breakpointSettings.items;
                            break;
                        }
                    }
                };

                var updateCarousel = function() {
                    updateRowsColsNb();

                    //Carousel is recalculated if and only if a change in number of columns/rows is requested
                    if (rowsNb != previousRowsNb || colsNb != previousColsNb) {
                        var reInit = false;
                        if (carousel) {
                            //Destroy existing carousel if any, and set html markup back to its initial state
                            carousel.trigger('destroy.owl.carousel');
                            carousel = undefined;
                            slides = el.find('[data-slide-index]').detach().appendTo(el);
                            el.find('.fake-col-wrapper').remove();
                            reInit = true;
                        }


                        //This is the only real 'smart' part of the algorithm

                        //First calculate the number of needed columns for the whole carousel
                        var perPage = rowsNb * colsNb;
                        var pageIndex = Math.floor(slidesNb / perPage);
                        var fakeColsNb = pageIndex * colsNb + (slidesNb >= (pageIndex * perPage + colsNb) ? colsNb : (slidesNb % colsNb));

                        //Then populate with needed html markup
                        var count = 0;
                        for (var i = 0; i < fakeColsNb; i++) {
                            //For each column, create a new wrapper div
                            var fakeCol = $('<div class="fake-col-wrapper"></div>').appendTo(el);
                            for (var j = 0; j < rowsNb; j++) {
                                //For each row in said column, calculate which slide should be present
                                var index = Math.floor(count / perPage) * perPage + (i % colsNb) + j * colsNb;
                                if (index < slidesNb) {
                                    //If said slide exists, move it under wrapper div
                                    slides.filter('[data-slide-index=' + index + ']').detach().appendTo(fakeCol);
                                }
                                count++;
                            }
                        }
                        //end of 'smart' part

                        previousRowsNb = rowsNb;
                        previousColsNb = colsNb;

                        if (reInit) {
                            //re-init carousel with new markup
                            carousel = el.owlCarousel(carouselOptions);
                        }
                    }
                };

                //Trigger possible update when window size changes
                $(window).on('resize', updateCarousel);

                //We need to execute the algorithm once before first init in any case
                updateCarousel();
            }
        }

        //init
        carousel = el.owlCarousel(carouselOptions);
    });
</script>

<!-- สคริปต์สร้าง Tooltip -->
<script>
    $(document).ready(function(){
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>