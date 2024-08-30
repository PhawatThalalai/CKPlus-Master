@extends('layouts.master')
@section('title', 'Task Group')
@section('datatrack-p1-active', 'mm-active')
@section('page-frontend','d-none')

<style>
    .reset {
        all: revert;
    }
    .input-fieldset{
        padding-bottom: 2px;
    }
</style>
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

@section('content')
  {{--
  <div class="row">
    <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="d-flex m-1">
          <div class="flex-shrink-0 me-4 mt-2">
          <img src="{{ URL::asset('/assets/images/signature.png') }}" alt="" style="width: 50px;">
          </div>
          <div class="flex-grow-1 overflow-hidden">
              <h5 class="text-primary fw-semibold pt-2">สร้างสัญญา</h5>
              <h6 class="text-secondary fw-semibold"><i class="bx bxs-map me-1"></i>สาขา</h6>
              <p class="border-primary border-bottom mt-2"></p>
          </div>
        </div>
        <div class="card-body">
          <div class="row g-2 mb-2">
            <div class="col-12 col-sm-12">
                <div class="form-floating">
                    <input type="text" id="CONTNO" name="CONTNO" class="form-control" placeholder="เลขสัญญา" required>
                    <label for="floatingnameInput"><strong><i class="bx bx-label"></i> เลขสัญญา</strong></label>
                </div>
            </div>
            <div class="col-12 col-sm-12">
                <div class="form-floating">
                    <input type="number" id="AMOUNTG" name="AMOUNTG" class="form-control" placeholder="จำนวนกลุ่ม" required>
                    <label for="floatingnameInput"><strong><i class="bx bx-label"></i> จำนวนกลุ่ม</strong></label>
                </div>
            </div>
          </div>
          <div class="row g-2 mb-1">
            <div class="col-12">
              <div class="text-center">
                <button type="button" id="ExcuteBtn1" class="btn btn-block btn-primary waves-effect">
                    <!-- <i class="bx bx-search-alt bx-spin font-size-14 align-middle"></i> สอบถาม -->
                    <i class="bx bx-hourglass bx-spin font-size-14 align-middle"></i> ประมวล
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12">
      <div class="card">
        <div class="card-body">
            <h4 class="card-title">Captions</h4>
            <p class="card-title-desc">A <code>&lt;caption&gt;</code> functions like a heading for a table. It helps users with screen readers to find a table and understand what it’s about and decide if they want to read it.</p>    
            
            <div class="table-responsive">
                <table class="table mb-0">
                    <caption>List of users</caption>
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
                    </tbody>
                </table>

            </div>

        </div>
      </div>
    </div>
  </div>
  --}}

    @component('components.breadcrumb')
        @slot('title')
            Track Task
        @endslot
        @slot('title_small')
            (กลุ่มงานโทร)
        @endslot
    @endcomponent
    <div class="row">
        <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12">
            <div class="card overflow-hidden m-0 shadow-none" style="z-index: 1;">
                <div class="bg-primary bg-soft">
                    <div class="row">
                        <div class="col-7">
                            <div class="text-primary">
                                
                            </div>
                        </div>
                        <div class="col-5">
                            <img src="{{ URL::asset('/assets/images/profile-img.png') }}" alt="" class="img-fluid">
                        </div>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div class="row py-3">
                        <div class="avatar-md profile-user-wid mb-3 col text-center">
                            <img src="{{ asset('/assets/images/balancer.gif') }}" style="width: 130px; height: 130px;" class="img-thumbnail rounded-circle hover-up boreder-img" alt="User-Profile-Image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12">
          <div class="card">
            <div class="card-body">
              <form name="formExcute" id="formExcute" action="#" method="post" enctype="multipart/form-data" novalidate>
                  @csrf
                  <div class="row">
                      <div class="col-sm-8">
                          <!-- <h5 class="text-primary p-2 font-size-14 fw-semibold"><i class="bx bx-user"></i> จัดกลุ่มงานติดตาม (Group Details)</h5> -->
                          <fieldset class="reset form-group border p-3">
                              <legend class="reset w-auto px-2 text-left text-bold text-primary font-size-14 fw-semibold">จัดกลุ่มงานติดตาม</legend>
                              <div class="row g-2 mb-1">
                                  <div class="col-12 col-sm-6">
                                      <div class="form-floating">
                                        <input type="number" id="CONT" name="CONT" class="form-control" placeholder="เลขสัญญา" required>
                                        <label for="floatingnameInput"><strong><i class="bx bx-label"></i> เลขสัญญา</strong></label>
                                      </div>
                                  </div>
                                  <div class="col-12 col-sm-6">
                                      <div class="form-floating">
                                        <input type="number" id="AMOUNTG" name="AMOUNTG" class="form-control" placeholder="จำนวนกลุ่ม" required>
                                        <label for="floatingnameInput"><strong><i class="bx bx-label"></i> จำนวนกลุ่ม</strong></label>
                                      </div>
                                  </div>
                              </div>
                          </fieldset>
                      </div>
                      <div class="col-sm-4">
                          <fieldset class="reset form-group border p-3">
                              <legend class="reset w-auto px-2 text-left text-bold text-primary font-size-14 fw-semibold">การรายงาน</legend>
                              <div class="row g-2 mb-2">
                                  <div class="col-12">
                                      <div class="text-center">
                                        <button type="button" id="ExcuteBtn1" class="btn btn-primary waves-effect">
                                          <i class="bx bx-hourglass font-size-14 align-middle"></i> สอบถาม
                                        </button>
                                        <button type="button" id="ExcuteBtn1" class="btn btn-dark waves-effect">
                                          <i class="bx bx-hourglass font-size-14 align-middle"></i> ประมวล
                                        </button>
                                      </div>
                                  </div>
                              </div>
                          </fieldset>
                      </div>
                  </div>
              </form>
            </div>
            <div class="card-footer">
            </div>
          </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="tab-content text-muted">
                <div class="tab-pane fade active show" role="tabpanel">
                  <div class="owl-carousel">
                    @for ($i = 0; $i < 10; $i++)
                        <div class="item" data-slide-index="{{$i}}">
                            <div class="card task-box border border-secondary" id="cmptask-1">
                                <div class="card-body">
                                    <div class="dropdown float-end">
                                        <a href="#" class="dropdown-toggle arrow-none" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item edittask-details Modal-xl-2" data-bs-toggle="modal" data-bs-target="#Modal-xl-2" data-link="{{ route('datatrack.edit', 0) }}?type={{4}}" style="cursor:pointer;">
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
            </div>
        </div>
    </div>


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
                    items: 4,
                    rows: 2 //custom option not used by Owl Carousel, but used by the algorithm below
                },
                991: {
                    mergeFit: true,
                    items: 4,
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
@endsection