<div class="card p-2 h-100">
    <div class="d-flex">
        <div class="flex-shrink-0 me-2 mt-1">
            <!-- <img src="assets/images/signature.png" alt="" style="width: 40px;"> -->
            <img class="" src="{{ URL::asset('assets/images/gif/wired-qr-code.gif') }}" alt="" style="width:50px;">
        </div>
        <div class="flex-grow-1 overflow-hidden">
            <h5 class="text-primary fw-semibold pt-2 font-size-15">เป้าสาขา ( Target Management )</h5>
            <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>มี {{count(@$data)}} รายการ</h6>
            <p class="border-primary border-bottom mt-2"></p>
        </div>
    </div>

    @if(count(@$data) > 0)
        <div class="accordion" id="accordionExample">
            @foreach(@$data as $key => $value)
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading{{$key+1}}">
                        <button class="accordion-button fw-medium collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$key+1}}" aria-expanded="false" aria-controls="collapse{{$key+1}}">
                            <strong class="text-body-emphasis">{{@$value->created_month}}</strong> - <code>{{@$value->Target_Year}}</code>
                        </button>
                    </h2>
                    <div id="collapse{{$key+1}}" class="accordion-collapse collapse" aria-labelledby="heading{{$key+1}}" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">
                            @php 
                                @$data = \App\Models\TB_Constants\TB_Frontend\TB_TargetAmount::where('created_month',@$value->created_month)->where('Target_Year',@$value->Target_Year)->where('Target_Zone',@$value->Target_Zone)->get();
                            @endphp

                            <div class="mt-n2" data-simplebar="init" style="max-height: 390px;">
                                <table id="example" class="table align-middle table-hover">
                                    <thead class="table-light sticky-top">
                                        <tr>
                                            <th scope="col" style="width: 70px;">#</th>
                                            <th scope="col">เป้าเดือน</th>
                                            <th scope="col">สาขา</th>
                                            <th scope="col">กลุ่มลูกค้า</th>
                                            <th scope="col">พนักงาน</th>
                                            <th scope="col">ยอดเป้า</th>
                                            <!-- <th scope="col">Zone</th> -->
                                            <th scope="col">
                                                <a class="dropdown-item edit-details Modal-xxl" data-bs-toggle="modal" data-bs-target="#Modal-xxl" data-link="{{ route('dataStatic.create') }}?page={{'frontend'}}&modal={{'targets'}}&mode={{'edit'}}&month={{@$value->created_month}}&year={{@$value->Target_Year}}" style="cursor:pointer;">
                                                    <strong>Edit</strong> <i class="bx bx-edit-alt"></i>
                                                </a>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach(@$data as $key => $value)
                                            <tr class="">
                                                <td>
                                                    <div class="avatar-xs">
                                                        <span class="avatar-title rounded-circle bg-warning bg-gradient">
                                                            {{$key+1}}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-muted">{{@$value->Target_Month}}</a></h5>
                                                    <p class="badge badge-soft-primary font-size-10 mb-0">{{@$value->Target_Year}}</p>
                                                </td>
                                                <td>{{@$value->ToBranch->Name_Branch}}</td>
                                                <td>{{@$value->Target_Typcus}}</td>
                                                <td>{{@$value->ToUser->name}}</td>
                                                <td>{{number_format(@$value->Target_Amount,2)}}</td>
                                                <!-- <td>{{@$value->Target_Zone}}</td> -->
                                                <td>
                                                    <ul class="list-inline font-size-20 contact-links mb-0">
                                                        <li class="list-inline-item px-2">
                                                            <a class="dropdown-item edit-details Modal-xl" data-bs-toggle="modal" data-bs-target="#Modal-xl" data-link="{{ route('dataStatic.edit', $value->id) }}?page={{'frontend'}}&modal={{'target-branch'}}&mode={{'edit'}}" style="cursor:pointer;">
                                                                <i class="bx bx-edit-alt" title="{{@$value->id}}"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </td>
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
    @else 
        <div class="card card-body h-100">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="maintenance-img">
                        <img src="{{ asset('assets/images/undraw/undraw_performance.svg') }}" alt="" class="img-fluid mx-auto d-block" style="max-height: 200px;">
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- <script type="text/javascript">
    $(function() {
        $('.menuSelected').click(function() {
            var idName = $(this).attr("id");
            var id = idName.split("-");
            var month = $(this).data("month");
            var year = $(this).data("year");
            // console.log(idName,month,year);

            viewData(id[1], month, year);
            // $(`.menuSelected`).removeClass('collapsed');
            // $(`.select-${idName}`).addClass('collapsed');

        });

        viewData = (id, month, year) => {
            $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
            // $(".content-loading").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
            $.ajax({
                url: '{{ route('dataStatic.show',[0]) }}',
                method:"GET",
                data: {
                    page: 'frontend',
                    setpage: 'target-detail',
                    id: id,
                    month: month,
                    year: year,
                    _token: "{{ @csrf_token() }}",
                },
                success: (response) => {
                    $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                    $('#accordion-info').html(response.html).show('slow');
                }
            });

        }
    });
</script> -->