<script src="{{ URL::asset('/assets/js/bootstrap-dialog.min.js')}}"></script>
@include('backend.content-track.session-call.script')
@include('backend.content-track.session-call.style')
<div class="row">
    <div class="col-xl-12">
        <div class="d-flex align-items-center float-end mt-n4">
          <form name="formRefresh" id="formRefresh" action="#" method="post" enctype="multipart/form-data" novalidate>
            @csrf
            @method('put')
            <input type="hidden" name="ContractID" value="{{@$contract->id}}">
            <input type="hidden" name="loanType" value="{{@$contract->CODLOAN}}">
            <input type="hidden" name="CONTNO" value="{{@$contract->CONTNO}}">
            <input type="hidden" name="page" value="refresh-track">
            <button type="button" id="RefreshDT" class="btn btn-link float-end" data-bs-placement="right" title="รีเฟรซ" aria-label="Close">
              <span class="addSpin2"><i class="bx bx-rotate-right font-size-20"></i></span>
            </button>
          </form>
        </div>
    </div>
</div>
<div class="row">
  @if(@$contract != NULL)
    @if(count(@$contract->ToView_PatchSPASTDUE) > 0)
      <div class="owl-carousel placeholder-glow">
        @foreach(@$contract->ToView_PatchSPASTDUE as $key => $value)
          @php 
            @$checkID = @$value->select('spast_id')->where('CONTNO',@$value->CONTNO)->whereMonth('LAST_ASSIGNDT',date('m'))->first();
          @endphp
          <div class="item" data-slide-index="{{$key}}">
            <div class="card rounded-4 border-2 border border-opacity-50 {{(@$value->STATUS == 'CLOSE' and @$value->stdept == 'ไม่ผ่าน' ? 'border-danger' : (@$value->STATUS == 'CLOSE' and @$value->stdept == 'ผ่าน' ? 'border-success' : ''))}}" id="cmptask-1"> 
              <div class="card-header bg-transparent border-bottom text-uppercase">
                <div class="d-flex align-items-center">
                    <!-- <i class="{{(@$key == 0)?'bx bx-tada':''}} bi bi-{{$key+1}}-square-fill"></i> -->
                    <span class="badge rounded-pill fs-6 px-3 text-bg-dark" data-bs-toggle="tooltip" data-bs-placement="right">
                      <u class="placeholder">{{formatDateThaiMY(substr(@$value->created_at,0,10))}}</u>
                    </span>
                    @php 
                      if(@$value->ToSPASTDETAIL->last()->DDATE != NULL){
                        if(@$value->ToSPASTDETAIL->last()->DDATE >= date('Y-m-d')) {
                          $DateDue = date_create(@$value->ToSPASTDETAIL->last()->DDATE);
                          $NowDate = date_create(date('Y-m-d'));
                          $DateDiff = date_diff($NowDate,$DateDue);
                          $DateShow = 'อีก '.$DateDiff->format("%a วัน");
                        }else{
                          $DateDiff = 0;
                          $DateShow = 'เลยกำหนด';
                        }
                      }
                    @endphp
                    @if(@$value->ToSPASTDETAIL->last()->DDATE)<span class="badge rounded-pill font-size-12 badge-soft-warning ms-4" title="{{(@$value->ToSPASTDETAIL->last()->DDATE)?date('d-m-Y',strtotime(@$value->ToSPASTDETAIL->last()->DDATE)):''}}">{{@$DateShow}}</span>@endif
                    <div class="ms-auto dropdown">
                      <a href="#" class="dropdown-toggle arrow-none placeholder" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical m-0 text-muted h5"></i>
                      </a>
                      <div class="dropdown-menu dropdown-menu-end">
                          @if(@$checkID->spast_id == @$value->spast_id)
                          <a href="#" class="dropdown-item d-flex justify-content-between pe-auto modal_lg" data-bs-toggle="modal" data-bs-target="#modal_lg" data-link="{{ route('datatrack.edit', @$value->spast_id) }}?page={{'view-invoice'}}&loanType={{@$loanType}}&Contno={{@$contract->CONTNO}}">
                            ออกใบแจ้งหนี้ <i class="bx bx-printer fs-4 text-warning"></i>
                          </a>
                          <li><hr class="dropdown-divider"></li>
                          <a href="#" class="dropdown-item d-flex justify-content-between pe-auto modal_lg" data-bs-toggle="modal" data-bs-target="#modal_lg" data-link="{{ route('datatrack.edit', @$value->spast_id) }}?page={{'deliver-track'}}&loanType={{@$loanType}}&Contno={{@$contract->CONTNO}}">
                            มอบหมายงาน <i class="mdi mdi-account-switch-outline text-danger"></i>
                          </a>
                          <li><hr class="dropdown-divider"></li>
                          @endif
                          <a href="#" class="dropdown-item d-flex justify-content-between pe-auto modal_lg" data-bs-toggle="modal" data-bs-target="#modal_lg" data-link="{{ route('datatrack.edit', @$value->spast_id) }}?page={{'view-track'}}&loanType={{@$loanType}}&Contno={{@$contract->CONTNO}}">
                            ดูประวัติ <i class="bx bx-history fs-4 text-primary"></i>
                          </a>
                      </div>
                    </div>
                </div>
                <div class="d-flex flex-row-reverse asset-flag-bookmark-card-info" style="position: absolute; right: 2.5rem; top: -0.5rem;">
                  @if(@$value->stdept == 'ไม่ผ่าน')
                    <div class="pe-2">
                      <span class="badge rounded-0 font-size-13 text-white triangle-year flag-bookmark fw-bold">
                        <i class="bx bx-x-circle m-0 mt-2 placeholder"></i> 
                        <span class="placeholder">{{@$value->stdept}}</span>
                      </span>
                      <div class="triangle-year triangle"></div>
                    </div>
                  @elseif(@$value->stdept == 'ตกชั้น')
                    <div class="pe-2">
                      <span class="badge rounded-0 font-size-13 text-white triangle-gear flag-bookmark fw-bold">
                        <i class="bx bx-x-circle m-0 mt-2 placeholder"></i>
                        <span class="placeholder">{{@$value->stdept}}</span>
                      </span>
                      <div class="triangle-gear triangle"></div>
                    </div>
                  @elseif(@$value->stdept == 'ผ่าน')
                    <div class="pe-2">
                      <span class="badge rounded-0 font-size-13 text-white triangle-gear flag-bookmark fw-bold">
                        <i class="bx bx-check-circle m-0 mt-2 placeholder"></i>
                        <span class="placeholder">{{@$value->stdept}}</span>
                      </span>
                      <div class="triangle-gear triangle"></div>
                    </div>
                  @endif  
                </div>
              </div>
              <div class="card-body p-2">

                <div class="row h-100">
                  <div class="col border-end">
                    <!-- แสดงสถานะ -->
                      <div class="float-start d-flex flex-column">
                          <span style="vertical-align: top;cursor:pointer;" @if(@$value->PAYAMT > 0) data-bs-toggle="tooltip" data-bs-placement="right" title="รับชำระ : {{number_format(@$value->PAYAMT)}}" @endif class="fa-stack fs-5 {{@$value->PAYAMT > 0?'text-info':'text-white'}}">
                            <i class="fas fa-square fa-stack-2x"></i>
                            <i class="fas fa-money-bill-wave fa-stack-1x fa-inverse"></i>
                          </span>
                          <span style="vertical-align: top;cursor:pointer;" @if(@$value->MustPay > 0) data-bs-toggle="tooltip" data-bs-placement="right" title="ยอดนัดชำระ : {{number_format(@$value->MustPay)}}" @endif class="fa-stack fs-5 {{@$value->MustPay > 0?'text-warning':'text-white'}}">
                            <i class="fas fa-square fa-stack-2x"></i>
                            <i class="fas fa-money-bill-wave fa-stack-1x fa-inverse"></i>
                          </span>
                          <span style="vertical-align: top;cursor:pointer;" @if(@$value->AreaPay > 0) data-bs-toggle="tooltip" data-bs-placement="right" title="ค่าลงพื้นที่ : {{number_format(@$value->AreaPay)}}" @endif class="fa-stack fs-5 {{@$value->AreaPay > 0?'text-danger':'text-white'}}">
                            <i class="fas fa-square fa-stack-2x"></i>
                            <i class="fas fa-map fa-stack-1x fa-inverse"></i>
                          </span>
                        
                      </div>
                    
                    <!-- รูปภาพทรัพย์ -->
                    <div class="col-12 m-auto text-center">
                        <img src="{{ asset('assets/images/task-phone.png') }}" class="rounded-circle border border-2 {{(@$value->stdept == 'ไม่ผ่าน')?'border-danger':'border-success'}} p-1" alt="เพิ่ม" style="width: 90px; height: 90px;">
                        <div class="overlay placeholder">{{@$value->ASSIGN}}</div>
                    </div>

                    <div class="col-12 mt-2 text-center">
                      <div class="row">
                        <h5 class="fw-semibold d-flex justify-content-center text-center"><ins class="placeholder">{{@$value->GroupingType == 'P' ? 'งานโทร' : (@$value->GroupingType == 'T' ? 'งานตาม' : (@$value->GroupingType == 'L' ? 'งานที่ดิน' : '.'))}}</ins></h5>
                        <div class="col-6 text-center border-end px-1">
                          <p class="fw-semibold fs-6 font-size-12 mb-0 placeholder">ประเภท</p>
                          <p class="m-0 placeholder">{{(@$value->ToSPASTDETAIL->last()->STATUS)?@$value->ToSPASTDETAIL->last()->STATUS:'-'}}</p>
                        </div>
                        <div class="col-6 text-center px-1">
                          <p class="fw-semibold fs-6 font-size-12 mb-0 placeholder">สถานะ</p>
                          <p class="m-0 placeholder">{{(@$value->ToSPASTDETAIL->last()->RESULT)?@$value->ToSPASTDETAIL->last()->RESULT:'-'}}</p>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-md-7 d-md-block">
                    <table class="table table-sm table-nowrap mb-0 asset-table-card-info placeholder">
                      <tbody class="fw-normal">
                        @if(@$value->ToSPASTDETAIL->last()->STATUS != 'งานลงพื้นที่')
                          <tr>
                            <th scope="row" class="fw-normal"><i class="bx bx-info-circle text-success"></i> วันที่บันทึก :</th>
                            <td class="text-end">{{(@$value->ToSPASTDETAIL->last()->INPUTDT)?date('d-m-Y',strtotime(@$value->ToSPASTDETAIL->last()->INPUTDT)):'-'}}</td>
                          </tr>
                          <tr>
                            <th scope="row" class="fw-normal"><i class="bx bx-info-circle text-success"></i> วันที่นัดชำระ :</th>
                            <td class="text-end">
                              {{-- @if(@$value->ToSPASTDETAIL->last()->DDATE)<span class="badge rounded-pill font-size-12 badge-soft-warning" title="{{(@$value->ToSPASTDETAIL->last()->DDATE)?date('d-m-Y',strtotime(@$value->ToSPASTDETAIL->last()->DDATE)):''}}">{{@$DateShow}}</span>@endif --}}
                              {{(@$value->ToSPASTDETAIL->last()->DDATE)?date('d-m-Y',strtotime(@$value->ToSPASTDETAIL->last()->DDATE)):'-'}}
                            </td>
                          </tr>
                          @if(@$value->ToSPASTDETAIL->last()->PAYDUE)
                          <tr>
                            <th scope="row" class="fw-normal"><i class="bx bx-info-circle text-success"></i> ยอดนัดชำระ :</th>
                            <td class="text-end">{{(@$value->ToSPASTDETAIL->last()->PAYDUE)?number_format(@$value->ToSPASTDETAIL->last()->PAYDUE):'-'}}</td>
                          </tr>
                          @endif
                          <tr>
                            <th scope="row" class="fw-normal"><i class="bx bx-info-circle text-success"></i> รายละเอียด :</th>
                            <td class="text-end">
                              <span id="minimumPayout" style="cursor: pointer;"
                                  data-toggle="popover" data-bs-placement="top"
                                  data-bs-trigger="hover focus"
                                  data-bs-custom-class="custom-popover"
                                  data-bs-title="รายละเอียดติดตาม"
                                  data-bs-content="
                                  <div class='row'>
                                      <div class='col-12 fw-semibold'> {{ @$value->ToSPASTDETAIL->last()->NOTE }}</div>
                                  </div>"
                                >
                                {{ (@$value->ToSPASTDETAIL->last()->NOTE)? Str::limit( @$value->ToSPASTDETAIL->last()->NOTE, 15, '...'):'-' }}
                              </span>
                            </td>
                          </tr>
                        @else
                          <tr>
                            <th scope="row" class="fw-normal"><i class="bx bx-info-circle text-success"></i> วันที่ลงพื้นที่ :</th>
                            <td class="text-end">{{(@$value->ToSPASTDETAIL->last()->ToAREA->DATE_AREA)?date('d-m-Y',strtotime(@$value->ToSPASTDETAIL->last()->ToAREA->DATE_AREA)):'-'}}</td>
                          </tr>
                          <tr>
                            <th scope="row" class="fw-normal"><i class="bx bx-info-circle text-success"></i> สถานที่ลงพื้นที่ :</th>
                            <td class="text-end">{{(@$value->ToSPASTDETAIL->last()->ToAREA->PLACE_AREA)?@$value->ToSPASTDETAIL->last()->ToAREA->PLACE_AREA:'-'}}</td>
                          </tr>
                          @if(@$value->ToSPASTDETAIL->last()->ToAREA->PAY_AREA)
                          <tr>
                            <th scope="row" class="fw-normal"><i class="bx bx-info-circle text-success"></i> ค่าลงพื้นที่ :</th>
                            <td class="text-end">{{(@$value->ToSPASTDETAIL->last()->ToAREA->PAY_AREA)?@$value->ToSPASTDETAIL->last()->ToAREA->PAY_AREA:'-'}}</td>
                          </tr>
                          @endif
                          <tr>
                            <th scope="row" class="fw-normal"><i class="bx bx-info-circle text-success"></i> สถานะทรัพย์ :</th>
                            <td class="text-end">{{(@$value->ToSPASTDETAIL->last()->ToAREA->STATUS_ASSET)?@$value->ToSPASTDETAIL->last()->ToAREA->STATUS_ASSET:'-'}} {{(@$value->ToSPASTDETAIL->last()->ToAREA->FLAG_ASSET)?'('.@$value->ToSPASTDETAIL->last()->ToAREA->FLAG_ASSET.')':'-'}}</td>
                          </tr>
                          <tr>
                            <th scope="row" class="fw-normal"><i class="bx bx-info-circle text-success"></i> สถานะผู้กู้ :</th>
                            <td class="text-end">{{(@$value->ToSPASTDETAIL->last()->ToAREA->STATUS_DEBT)?@$value->ToSPASTDETAIL->last()->ToAREA->STATUS_DEBT:'-'}} {{(@$value->ToSPASTDETAIL->last()->ToAREA->FLAG_DEBT)?'('.@$value->ToSPASTDETAIL->last()->ToAREA->FLAG_DEBT.')':'-'}}</td>
                          </tr>
                          <tr>
                            <th scope="row" class="fw-normal"><i class="bx bx-info-circle text-success"></i> พิกัด :</th>
                            <td class="text-end">{{(@$value->ToSPASTDETAIL->last()->ToAREA->LATLONG)?@$value->ToSPASTDETAIL->last()->ToAREA->LATLONG:'-'}}</td>
                          </tr>
                          <tr>
                            <th scope="row" class="fw-normal"><i class="bx bx-info-circle text-success"></i> รายละเอียด :</th>
                            <td class="text-end">
                              <span id="minimumPayout" style="cursor: pointer;"
                                  data-toggle="popover" data-bs-placement="top"
                                  data-bs-trigger="hover focus"
                                  data-bs-custom-class="custom-popover"
                                  data-bs-title="รายละเอียดลงพื้นที่"
                                  data-bs-content="
                                  <div class='row'>
                                      <div class='col-12 fw-semibold'> {{ @$value->ToSPASTDETAIL->last()->ToAREA->NOTE }}</div>
                                  </div>"
                                >
                                {{ (@$value->ToSPASTDETAIL->last()->ToAREA->NOTE)?Str::limit( @$value->ToSPASTDETAIL->last()->ToAREA->NOTE, 15, '...'):'-' }}
                              </span>
                            </td>
                          </tr>
                        @endif
                      </tbody>
                    </table>

                  </div>
                </div>

              </div>
              <div class="card-footer">
                <div class="row px-2">
                  <div class="col-5">
                    <div class="row">
                      <div class="col d-grid text-center">
                        <button type="button" class="rounded-pill btn-sm btn btn-outline-primary Modal-xxl" data-bs-toggle="modal" data-bs-target="#Modal-xxl" data-link="{{ route('datatrack.edit', @$value->spast_id) }}?page={{'edit-track'}}&ContractID={{@$contract->id}}&Contno={{@$contract->CONTNO}}&loanType={{@$loanType}}&EXP={{@$value->EXPREAL}}" {{(@$checkID->spast_id != @$value->spast_id)?'disabled':''}}>
                          <!-- <button type="button" class="rounded-pill btn-sm btn btn-outline-primary Modal-xxl" data-bs-toggle="modal" data-bs-target="#Modal-xxl" data-link="{{ route('datatrack.edit', @$value->spast_id) }}?page={{'edit-track'}}&ContractID={{@$contract->id}}&Contno={{@$contract->CONTNO}}&loanType={{@$loanType}}&EXP={{@$value->EXPREAL}}" title="บันทึกข้อมูล"> -->
                          <span class="font-size-14"><i class="bx bxs-edit"></i></span>
                          <span class="" data-bs-toggle="tooltip" title="บันทึกข้อมูล">บันทึก</span> 
                        </button>
                      </div>
                    </div>
                  </div>
                  <div class="col d-flex justify-content-between align-items-center ps-4">
                    <small class="fw-semibold text-secondary" data-bs-toggle="tooltip">
                      <span class="d-flex align-items-center">
                        @if(@$value->ToSPASTDETAIL->last()->updated_at != NULL) 
                          <i class="bx bxs-time-five fs-5 me-1 d-none d-sm-block"></i> 
                          <span class="d-block d-sm-none font-size-8"></span>
                          <span class="d-none d-sm-block font-size-8">{{(@$value->ToSPASTDETAIL->last()->updated_at != NULL)?\Carbon\Carbon::parse(@$value->ToSPASTDETAIL->last()->updated_at)->locale('th_TH')->diffForHumans():''}}</span>
                        @endif
                      </span>
                    </small>
                    <small class="fw-semibold text-secondary d-flex align-items-center">
                      @if(@$value->ToSPASTDETAIL->last()->ToUsername->name != NULL)
                        <i class="bx bxs-user-circle fs-5 me-1"></i> 
                        {{(@$value->ToSPASTDETAIL->last()->ToUsername->name != NULL)?@$value->ToSPASTDETAIL->last()->ToUsername->name:auth()->user()->name}} 
                      @endif
                    </small>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @else
      <div class="maintenance-img content-image mt-3">
        <img src="{{ URL::asset('assets/images/undraw/user_folder.svg') }}" alt="" class="img-fluid mx-auto d-block" style="max-height: 40vh;">
      </div>
    @endif
  @endif
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
    // $(document).on('click', '.Modal-xxl', function(e) {
    //     e.preventDefault();
    //     var url = $(this).attr('data-link');
    //     $('#modal-xxl .modal-dialog').empty();
    //     $('#Modal-xxl .modal-dialog').load(url);
    // });
</script>

<script>
  $(document).on('click', '.Modal-xxl', function(e) {
    $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
    e.preventDefault();
    var url = $(this).attr('data-link');
    $('#Modal-xxl .modal-dialog').load(url, function(response, status, xhr) {
      if (status === 'success') {
        $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
        $('#Modal-xxl').modal('show');
      } else {
        $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
      }
    });
  });
</script>

<script>
    $(function() {
      $('[data-toggle="popover"]').popover({
          html: true,
      sanitize: false,
      })
    })
</script>

{{-- Delete Job Call --}}
<script>
  function removeTrack(pact_id, id, title, loan, cusid){
    //------------------------------------------------------
    Swal.fire({
      title: 'คุณแน่ใจหรือไม่?',
      text: "ลบรายการ " + title,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
    })
    .then( (value) => {
      if (value.isConfirmed) { // กด OK 
        var type = 1;
        var _url = "{{ route('datatrack.destroy', ':id' ) }}";
        _url = _url.replace(':id', id);
        $.ajax({
          url: _url,
          method:"DELETE",
          data:{type:type,_token:'{{ csrf_token() }}',pact_id:pact_id,loan:loan,cusid:cusid},
              success:function(result){ //เสร็จแล้วทำอะไรต่อ
                Swal.fire({
                  icon: 'success',
                  // title: 'นำออกสำเร็จ!',
                  text: "ลบข้อมูลเรียบร้อย",
                  timer: 3000
                });
                $("#TrackDetails").html(result);
                // $("#TrackDetails").html(result);
              }
        });
      }
      else{
        // Swal.fire('Changes are not saved', '', 'info');
      }
    });
  }
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
      merge:true,
      autoHeight:true,
      slideBy: 'page',
      navText: ["<i class='mdi mdi-chevron-double-left'></i>", "<i class='mdi mdi-chevron-double-right'></i>"],
      //stagePadding: 25,
        responsive: {
          0: {
        mergeFit:true,
            items: 1,
            rows: 1 //custom option not used by Owl Carousel, but used by the algorithm below
          },
          768: {
        mergeFit:true,
            items: 2,
            rows: 1 //custom option not used by Owl Carousel, but used by the algorithm below
          },
          991: {
        mergeFit:true,
            items: 2,
            rows: 1 //custom option not used by Owl Carousel, but used by the algorithm below
          }
        }
    };

    //init
    carousel = el.owlCarousel(carouselOptions);
  });
</script>

{{-- Refresh Trackings --}}
<script>
  $("#RefreshDT").click(function(){

    var dataform = document.querySelectorAll('#formRefresh');
    var validate = validateForms(dataform);
    var data = $('#formRefresh').serialize();
        
    if (validate == true) {
        $('#RefreshDT').prop('disabled', true);
        $('.addSpin2').empty();
        $('<span />', {
            class: "spinner-border spinner-border-sm",
            role: "status"
        }).appendTo(".addSpin2");

        $.ajax({
            url: "{{ route('datatrack.update',0) }}",
            method: 'PUT',
            data:data,

            success: function(result) {
              // $('[data-bs-toggle="tooltip"]').tooltip('hide');
              $(".toast-success").toast({
                delay: 5000
              }).toast("show");
              $(".toast-success .toast-body .text-body").text('รีเฟรซสำเร็จ');
              $('[data-bs-toggle="tooltip"]').tooltip();
              $('#RefreshDT').prop('disabled', false);
              $("#TrackDetails").html(result).slideDown('slow');
            }
        });
    }    
  });
</script>

<script>
  $('#CloseModal').click(function(){
    $('#modal_lg').modal('hide');
  });
</script>

<script>
  $(document).ready(function() {
      // Set a timeout to remove the .placeholder class after 3 seconds (3000 milliseconds)
      setTimeout(function() {
          $('.placeholder').removeClass('placeholder');
      }, 3000); // 3000 milliseconds = 3 seconds
  });
</script>