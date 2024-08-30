@php 
//dd(@$data[0]);
@endphp
<div id="ModelDetails">
    <div class="card task-box border" id="cmptask-2">
        <div data-simplebar="init" style="height: 68vh;">
            <table class="table table-nowrap align-middle mb-0 border-none">
                <thead class="sticky-top">
                    <tr class="table-dark">
                        <th colspan="3" class="rounded-start rounded-end">
                            {{@$group_name}}
                            <small><span class="text-danger">(  มี {{@count($data)}} รุ่นย่อย )</span></small> 
                            <button type="button" class="text-white float-end btn btn-sm btn-success rounded-pill Modal-lg" data-bs-toggle="modal" data-bs-target="#Modal-lg" data-link="{{ route('CarRate.create') }}?create={{'model'}}&ModelID={{@$data[0]->id}}&GroupID={{@$group_id}}&BrandID={{@$brand_id}}" style="cursor:pointer;">
                                <span class="d-block d-sm-none"><i class="bx bx-plus-circle"></i></span>
                                <b class="d-none d-sm-block"><i class="bx bx-plus-circle"></i> เพิ่มรุ่น</b>
                            </button>
                        </th>
                    </tr>
                    <tr class="table-light">
                        <th colspan="2" class="font-size-12">
                            รุ่นรถ
                        </th>
                        <th class="font-size-12 text-end">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                @if(count(@$data) != 0)
                    @foreach($data as $key => $value)
                        <tr style="cursor:grab;" class="{{(@$value->Status_model == 'yes')?'text-danger':''}}">
                            <td class="btn_model active-model-{{$key+1}}" id="model-{{$key+1}}" data-id="{{@$value->id}}" data-brand="{{@$value->Brand_id}}" data-group="{{@$value->Group_id}}" data-rate="{{@$value->Ratetype_id}}" style="width: 10%;">
                                <div class="avatar-xs">
                                    <span class="avatar-title rounded-circle {{(@$value->Topcar == 'yes')?'bg-success':'bg-warning'}} bg-gradient">
                                        <i class="bx bx-car {{(@$value->Topcar == 'yes')?'bx-fade-right':''}} font-size-16"></i>
                                    </span>
                                </div>
                            </td>
                            <td class="btn_model active-model-{{$key+1}}" id="model-{{$key+1}}" data-id="{{@$value->id}}" data-brand="{{@$value->Brand_id}}" data-group="{{@$value->Group_id}}" data-rate="{{@$value->Ratetype_id}}" style="width: 60%;">
                                <h5 class="font-size-12 m-0">{{@$value->Model_car}}</h5>
                                @if(@$value->Tank_No != NULL)<h5 class="font-size-12 m-0 text-primary">เลขถัง: {{@$value->Tank_No}}</h5>@endif
                            </td>
                            <td class="btn_option active-model-{{$key+1}}" id="model-{{$key+1}}" data-id="{{@$value->id}}" style="width: 30%;">
                                <ul class="text-end list-inline font-size-20 contact-links mb-0">
                                    <li class="list-inline-item">
                                        <a class="dropdown-item edit-details Modal-lg" data-bs-toggle="modal" data-bs-target="#Modal-lg" data-link="{{ route('CarRate.edit',@$value->id) }}?edit={{'modelcar'}}" style="cursor:pointer;">
                                            <i class="{{(@$value->Status_model == 'yes')?'mdi mdi-eye-off-outline':'bx bx-edit-alt'}} text-warning"></i>
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a class="dropdown-item del-Model" data-id="{{@$value->id}}" data-name="{{@$value->Model_car}}" data-brand="{{@$value->Brand_id}}" data-group="{{@$value->Group_id}}" data-gm="{{@$group_name}}" style="cursor:pointer;">
                                            <i class="bx bx-trash text-danger"></i>
                                        </a>
                                    </li>
                                </ul>
                                <!-- @if(@$value->updated_at != NULL)
                                <h5 class="font-size-10 text-muted mb-0 text-end"><i class="mdi mdi-account-edit-outline text-primary"></i>แก้ไข : {{formatDateThaiShort_monthNum(@$value->updated_at)}}</h5>
                                @endif -->
                            </td>
                        </tr>
                    @endforeach
                @else 
                    <tr style="cursor:grab;">
                        <td colspan="3" class="text-center">
                            <span class="bg-warning bg-gradient rounded-pill">
                                --- <i class="mdi mdi-car font-size-16"></i> ไม่มีข้อมูล ---
                            </span>
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- btn_model --}}
<script>
	$(function() {
        $(".btn_model").on('click', function() {
            var model_id = $(this).data("id");
            var model_tab = $(this).attr("id");
            var brand_id = $(this).data("brand");
            var group_id = $(this).data("group");
            var rate_id = $(this).data("rate");
            var Setmodel_name = $(this).text().split('เลขถัง:');
            var model_name = Setmodel_name[0];

            $(`.btn_model`).removeClass('bg-info text-white border border-info border-2');
            $(`.btn_option`).removeClass('bg-info text-white border border-info border-2');
            $(`.active-${model_tab}`).addClass('bg-info text-white border border-info border-2');

            $.ajax({
                url: "{{ route('CarRate.index') }}",
                method:"GET",
                data: {
                    type: 3,
                    brand_id: brand_id,
                    group_id: group_id,
                    model_id: model_id,
                    rate_id: rate_id,
                    model_name:model_name,
                    _token: "{{@csrf_token()}}",
                },
                success: (response) => {
                    $("#showModelDetail").show();
                    $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                    $('#showModelDetail').removeClass('d-none');
                    $('#viewDetailCar').html(response.html).show('slow');
                }
            });

		});
	})
</script>

{{-- btn_option --}}
<script>
	$(function() {
        $(".btn_option").on('click', function() {
            var option_id = $(this).data("id");
            var option_name = $(this).attr("id");
            // console.log(brand_id,group_id);
            $(`.btn_model`).removeClass('bg-info text-white border border-info border-2');
            $(`.btn_option`).removeClass('bg-info text-white border border-info border-2');
            $(`.active-${option_name}`).addClass('bg-info text-white border border-info border-2');

		});
	})
</script>

{{-- next owl --}}
<script>
    $(function() {
        $('.btn_model').click(function () {
            var slider = $('.owl-carousel');
            slider.owlCarousel();
            slider.trigger('next.owl.carousel');
        });
    });
</script>

{{-- delete --}}
<script>
    $(document).on('click', '.del-Model', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let name = $(this).data("name");
        let brand_id = $(this).data("brand");
        let group_id = $(this).data("group");
        let group_name = $(this).data("gm");

        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: "ลบรายการ " + name,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
        })
        .then( (value) => {
            if (value.isConfirmed) { // กด OK 
                let del = 'model';
                let _url = "{{ route('CarRate.destroy', ':id' ) }}";
                _url = _url.replace(':id', id);
                $.ajax({
                url: _url,
                method:"DELETE",
                data:{
                        _token:'{{ csrf_token() }}',
                        del:del,
                        id:id,
                        brand_id:brand_id,
                        group_id:group_id,
                        group_name:group_name,
                    },
                    success:function(result){ //เสร็จแล้วทำอะไรต่อ
                        Swal.fire({
                            icon: 'success',
                            // title: 'นำออกสำเร็จ!',
                            text: "ลบข้อมูลเรียบร้อย",
                            timer: 3000
                        });
                        $("#ModelDetails").html(result);
                        $("#showModelDetail").hide();
                        // $("#TrackDetails").html(result);
                        var slider = $('.owl-carousel');
                        slider.owlCarousel();
                        slider.trigger('prev.owl.carousel');
                    }
                });
            }
            else{
                // Swal.fire('Changes are not saved', '', 'info');
            }
        });
    });
</script>
