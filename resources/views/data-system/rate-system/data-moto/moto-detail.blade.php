<div id="YearcarDetails">
    <div class="card task-box border" id="cmptask-3">
        <div data-simplebar="init" style="height: 68vh;">
            <table class="table align-middle">
                <thead>
                    <tr class="table-dark">
                        <th colspan="5" class="rounded-start rounded-end">
                            {{@$model_name}}
                            <small><span class="text-danger">(  มี {{@count($data)}} ปีย่อย )</span></small> 
                            <!-- <button class="text-white float-end btn btn-sm btn-warning rounded-pill" type="button"> -->
                            @if(@count($data) > 0)
                                <!-- <button type="button" class="text-white float-end btn btn-sm btn-warning rounded-pill me-1 Modal-lg" data-bs-toggle="modal" data-bs-target="#Modal-lg" data-link="{{ route('MotoRate.edit',0) }}?edit={{'yearcar'}}&BrandID={{@$brand_id}}&GroupID={{@$group_id}}&RateID={{@$rate_id}}&ModelID={{@$model_id}}&Modelname={{str_replace(' ','',@$model_name)}}" style="cursor:pointer;">
                                    <span class="d-block d-sm-none"><i class="bx bx-edit-alt"></i></span>
                                    <b class="d-none d-sm-block"><i class="bx bx-edit-alt"></i> แก้ไข</b>
                                </button> -->
                                <div class="btn-group float-end">
                                    <!-- <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">Warning <i class="mdi mdi-chevron-down"></i></button> -->
                                    <button type="button" class="text-white btn btn-sm btn-warning dropdown-toggle rounded-pill me-1" data-bs-toggle="dropdown">
                                        <span class="d-block d-sm-none"><i class="bx bx-edit-alt"></i></span>
                                        <b class="d-none d-sm-block"><i class="bx bx-cog"></i> ตัวเลือก</b>
                                    </button>
                                    <div class="dropdown-menu" style="">
                                        <a class="dropdown-item Modal-lg" href="#" data-bs-toggle="modal" data-bs-target="#Modal-lg" data-link="{{ route('MotoRate.edit',0) }}?edit={{'yearcar'}}&BrandID={{@$brand_id}}&GroupID={{@$group_id}}&RateID={{@$rate_id}}&ModelID={{@$model_id}}&Modelname={{str_replace(' ','',@$model_name)}}" style="cursor:pointer;">
                                            <i class="bx bx-edit-alt"></i> แก้ไขข้อมูลแบบกลุ่ม
                                        </a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item Modal-lg" href="#" data-bs-toggle="modal" data-bs-target="#Modal-lg" data-link="{{ route('MotoRate.edit',0) }}?edit={{'yearprice'}}&BrandID={{@$brand_id}}&GroupID={{@$group_id}}&RateID={{@$rate_id}}&ModelID={{@$model_id}}&Modelname={{str_replace(' ','',@$model_name)}}" style="cursor:pointer;">
                                            <i class="bx bx-directions"></i> ปรับราคาแบบกลุ่ม
                                        </a>
                                    </div>
                                </div>
                            @endif
                            <button type="button" class="text-white float-end btn btn-sm btn-success rounded-pill me-1 Modal-lg" data-bs-toggle="modal" data-bs-target="#Modal-lg" data-link="{{ route('MotoRate.create') }}?create={{'yearcar'}}&BrandID={{@$brand_id}}&GroupID={{@$group_id}}&RateID={{@$rate_id}}&ModelID={{@$model_id}}&Modelname={{str_replace(' ','',@$model_name)}}" style="cursor:pointer;">
                                <span class="d-block d-sm-none"><i class="bx bx-plus-circle"></i></span>
                                <b class="d-none d-sm-block"><i class="bx bx-plus-circle"></i> เพิ่มปีรถ</b>
                            </button>
                        </th>
                    </tr>
                    <tr class="table-light">
                        <th class="font-size-12">
                            NO.
                        </th>
                        <th class="font-size-12">
                            ประเภท
                        </th>
                        <th class="font-size-12">
                            ปีรถ
                        </th>
                        <th class="font-size-12">
                            ราคารถ
                        </th>
                        <th class="font-size-12 text-end">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if(count(@$data) != 0)
                        @foreach($data as $key => $value)
                            <tr style="cursor:grab;">
                                <td style="width: 10%;" class="btn_detail active-detail-{{$key+1}}" id="detail-{{$key+1}}" data-id="{{@$value->id}}">
                                    <div class="avatar-xs">
                                        <span class="avatar-title rounded-circle bg-warning bg-gradient">
                                            {{$key+1}}
                                        </span>
                                    </div>
                                </td>
                                <td style="width: 20%;" class="btn_detail active-detail-{{$key+1}}" id="detail-{{$key+1}}" data-id="{{@$value->id}}">
                                    <h5 class="font-size-12 m-0">{{@$value->yearMototype->nametype_car}}</h5>
                                </td>
                                <td style="width: 15%;" class="btn_detail active-detail-{{$key+1}}" id="detail-{{$key+1}}" data-id="{{@$value->id}}">
                                    <h5 class="font-size-12 m-0">{{@$value->Year_moto}}</h5>
                                </td>
                                <td style="width: 30%;" class="btn_detail active-detail-{{$key+1}}" id="detail-{{$key+1}}" data-id="{{@$value->id}}">
                                    <h5 class="font-size-12 mb-1">AT : {{number_format(@$value->PriceAT_moto)}}</h5>
                                    <p class="font-size-12 text-muted mb-0">MT : {{number_format(@$value->PriceMT_moto)}}</p>
                                </td>
                                <td style="width: 25%;" class="btn_detail active-detail-{{$key+1}}" id="detail-{{$key+1}}" data-id="{{@$value->id}}">
                                    <ul class="text-end list-inline font-size-20 contact-links mb-0">
                                        <li class="list-inline-item">
                                            <a class="dropdown-item edit-details Modal-lg" data-bs-toggle="modal" data-bs-target="#Modal-lg" data-link="{{ route('MotoRate.edit',@$value->id) }}?edit={{'pricecar'}}" style="cursor:pointer;">
                                                <i class="{{(@$value->Status_year == 'yes')?'mdi mdi-eye-off-outline':'bx bx-edit-alt'}} text-warning"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a class="dropdown-item del-Details" data-id="{{@$value->id}}" data-name="{{@$value->Year_moto}}" data-brand="{{@$value->Brand_id}}" data-group="{{@$value->Group_id}}" data-model="{{@$value->Model_id}}" data-rate="{{@$value->Ratetype_id}}" data-dm="{{@$model_name}}" style="cursor:pointer;">
                                                <i class="bx bx-trash text-danger"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    @if(@$value->updated_at != NULL)
                                    <h5 class="font-size-10 text-muted mb-0 text-end"><i class="mdi mdi-account-edit-outline text-primary"></i>แก้ไข : {{formatDateThaiShort_monthNum(@$value->updated_at)}}</h5>
                                    @endif
                                </td>
                            </tr>
                        @endforeach 
                    @else 
                        <tr style="cursor:grab;">
                            <td colspan="5" class="text-center">
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

<script>
    $(document).ready(function() {
        $(function() {
            $(".input-mask").inputmask();
            $('[data-bs-toggle="tooltip"]').tooltip();

            $('textarea').maxlength({
                alwaysShow: true,
                warningClass: "badge bg-info",
                limitReachedClass: "badge bg-danger"
            });
        });
    });
</script>

{{-- btn click --}}
<script>
	$(function() {
		$(".btn_detail").on('click', function() {
            var detail_id = $(this).data("id");
            var detail_name = $(this).attr("id");
            

            $(`.btn_detail`).removeClass('bg-info text-white border border-info border-2');
            $(`.active-${detail_name}`).addClass('bg-info text-white border border-info border-2');

		});
	})
</script>

{{-- delete --}}
<script>
    $(document).on('click', '.del-Details', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let name = $(this).data("name");
        let brand_id = $(this).data("brand");
        let group_id = $(this).data("group");
        let model_id = $(this).data("model");
        let rate_id = $(this).data("rate");
        let model_name = $(this).data("dm");
        let csrf = '{{ csrf_token() }}';
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
                var del = 'cardetail';
                var _url = "{{ route('MotoRate.destroy', ':id' ) }}";
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
                        model_id:model_id,
                        rate_id:rate_id,
                        model_name:model_name,
                    },
                    success:function(result){ //เสร็จแล้วทำอะไรต่อ
                        Swal.fire({
                            icon: 'success',
                            // title: 'นำออกสำเร็จ!',
                            text: "ลบข้อมูลเรียบร้อย",
                            timer: 3000
                        });
                        $("#YearcarDetails").html(result);
                        // $("#TrackDetails").html(result);
                    }
                });
            }
            else{
                // Swal.fire('Changes are not saved', '', 'info');
            }
        });
    });
</script>
