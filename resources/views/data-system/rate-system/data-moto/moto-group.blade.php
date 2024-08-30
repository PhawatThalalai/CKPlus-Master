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
        top: -1%;
        margin-left: -20px;
        display: block !important;
        border:0px solid black;
        font-size: xx-large !important;
    }

    .owl-next {
        width: 15px;
        height: 78px;
        position: absolute;
        top: -1%;
        right: -15px;
        display: block !important;
        border:0px solid black;
        font-size: xx-large !important;
    }
    .owl-prev i, .owl-next i {transform : scale(1,6); color: #ccc;}

    .input-bx select~span,
    .input-bx textarea~span {
        /* color: #3742fa; */
        transform: translateX(10px) translateY(-7px);
        font-size: 0.65rem;
        font-weight: 600;
        padding: 0 10px;
        background: var(--bs-light);
        letter-spacing: 0.1rem;
    }

</style>

<div id="GroupDetails">
    <input type="hidden" id="BN" value="{{@$brand_name}}">
    <input type="hidden" id="KEY" value="{{@$key}}">
    <div class="owl-carousel">
        <div class="item me-2" id="showGroup" data-slide-index="3">
            <div class="card task-box border" id="cmptask-1">
                <div data-simplebar="init" style="height: 68vh;">
                    <table class="table align-middle">
                        <thead class="sticky-top">
                            <tr class="table-dark">
                                <th colspan="3" class="rounded-start rounded-end">
                                    {{@$brand_name}}
                                    <small><span class="text-danger">(  มี {{@count($data)}} กลุ่ม )</span></small> 
                                    <button type="button" class="text-white float-end btn btn-sm btn-success rounded-pill Modal-lg" data-bs-toggle="modal" data-bs-target="#Modal-lg" data-link="{{ route('MotoRate.create') }}?create={{'group'}}&brand_id={{@$brand_id}}&brand_name={{@$brand_name}}" style="cursor:pointer;">
                                        <span class="d-block d-sm-none"><i class="bx bx-plus-circle"></i></span>
                                        <b class="d-none d-sm-block"><i class="bx bx-plus-circle"></i> เพิ่มกลุ่ม</b>
                                    </button>
                                </th>
                            </tr>
                            <tr class="table-light">
                                <th colspan="2" class="font-size-12">
                                    Group
                                </th>
                                <th class="font-size-12 text-end">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                                @if(count(@$data) != 0)
                                    @foreach($data as $key => $value)
                                        <tr style="cursor:grab;" class="{{(@$value->Status_group == 'yes')?'text-danger':''}}">
                                            <td class="btn_group active-group-{{$key+1}}" id="group-{{$key+1}}" data-id="{{@$value->id}}" data-brand="{{@$value->Brand_id}}" style="width: 10%;">
                                                <div class="avatar-xs">
                                                    <span class="avatar-title rounded-circle {{(@$value->Status_group == 'yes')?'bg-danger':'bg-warning'}} bg-gradient">
                                                        <i class="fas fa-motorcycle fa-sm font-size-16"></i>
                                                    </span>
                                                </div>
                                            </td>
                                            <td class="btn_group active-group-{{$key+1}}" id="group-{{$key+1}}" data-id="{{@$value->id}}" data-brand="{{@$value->Brand_id}}" style="width: 60%;">
                                                <h5 class="font-size-12 m-0">{{@$value->Group_moto}}</h5>
                                            </td>
                                            <td class="btn_action active-group-{{$key+1}}" id="group-{{$key+1}}" data-id="{{@$value->id}}" data-brand="{{@$value->Brand_id}}" style="width: 30%;">
                                                <ul class="text-end list-inline font-size-20 contact-links mb-0">
                                                    <li class="list-inline-item">
                                                        <a class="dropdown-item edit-Group Modal-lg" data-bs-toggle="modal" data-bs-target="#Modal-lg" data-link="{{ route('MotoRate.edit',@$value->id) }}?edit={{'groupcar'}}" style="cursor:pointer;">
                                                            <i class="{{(@$value->Status_group == 'yes')?'mdi mdi-eye-off-outline':'bx bx-edit-alt'}} text-warning"></i>
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item">
                                                        <a class="dropdown-item del-Group" data-id="{{@$value->id}}" data-name="{{@$value->Group_moto}}" data-brand="{{@$value->Brand_id}}" data-bm="{{@$brand_name}}" style="cursor:pointer;">
                                                            <i class="bx bx-trash text-danger"></i>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else 
                                    <tr style="cursor:grab;">
                                        <td colspan="3" class="text-center">
                                            <span class="bg-warning bg-gradient rounded-pill">
                                                --- <i class="fas fa-motorcycle fa-sm font-size-16"></i> ไม่มีข้อมูล ---
                                            </span>
                                        </td>
                                    </tr>
                                @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="item me-2" id="showModel" data-slide-index="2">
            <div id="viewModelMoto"></div>
        </div>

        <div class="item me-2" id="showModelDetail" data-slide-index="1">
            <div id="viewDetailMoto"></div>
        </div>

    </div>
</div>

<script>
    // --------- button-to-top --------------
    var btn = $('#buttonTop');
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

{{-- btn click --}}
<script>
	$(function() {
		$(".btn_group").on('click', function() {
            var brand_id = $(this).data("brand");
            var group_id = $(this).data("id");
            var group_tab = $(this).attr("id");
            var group_name = $(this).text();
            // console.log(group_id,group_tab);
            $(`.btn_action`).removeClass('bg-info text-white');
            $(`.btn_group`).removeClass('bg-info text-white');
            $(`.active-${group_tab}`).addClass('bg-info text-white');

            $.ajax({
                url: "{{ route('MotoRate.index') }}",
                method:"GET",
                data: {
                    type: 2,
                    brand_id:brand_id,
                    group_id: group_id,
                    group_name: group_name,
                    _token: "{{@csrf_token()}}",
                },
                success: (response) => {
                    $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                    $('#showModel').removeClass('d-none');
                    $('#showModelDetail').addClass('d-none');
                    $('#viewModelMoto').html(response.html).show('slow');
                }
            });

		});
	})
</script>

{{-- btn_action --}}
<script>
	$(function() {
        $(".btn_action").on('click', function() {
            var action_id = $(this).data("id");
            var action_name = $(this).attr("id");
            // console.log(action_id,action_name);
            $(".btn_group").removeClass('bg-info text-white');
            $(".btn_action").removeClass('bg-info text-white');
            $(`.active-${action_name}`).addClass('bg-info text-white');

		});
	})
</script>

{{-- next owl on small display --}}
<script>
    $(function() {
        $('.btn_group').click(function () {
            // console.log($(window).width());
            if ($(window).width() < 1001) {
                var slider = $('.owl-carousel');
                slider.owlCarousel();
                slider.trigger('next.owl.carousel');
            }
        });
    });
</script>

{{-- carousel --}}
<script>
  $(document).ready(function() {
    var el = $('.owl-carousel');

    var carousel;
    var carouselOptions = {
    //   margin: 25,
      nav: true,
      dots: true,
      merge:true,
    //   autoHeight:true,
    //   slideBy: 'page',
    //   navText: ["<i class='mdi mdi-arrow-left-circle text-dark'></i>", "<i class='mdi mdi-arrow-right-circle text-dark'></i>"],
    //   stagePadding: 25,
        responsive: {
          0: {
        mergeFit:true,
            items: 1,
            rows: 1 //custom option not used by Owl Carousel, but used by the algorithm below
          },
          768: {
        mergeFit:true,
            items: 1,
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

{{-- delete --}}
<script>
    $(document).on('click', '.del-Group', function(e) {
        e.preventDefault();
        let id = $(this).data('id');
        let name = $(this).data("name");
        let brand_id = $(this).data("brand");
        let brand_name = $(this).data("bm");

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
                let del = 'group';
                let _url = "{{ route('MotoRate.destroy', ':id' ) }}";
                _url = _url.replace(':id', id);
                $.ajax({
                url: _url,
                method:"DELETE",
                data:{
                        _token:'{{ csrf_token() }}',
                        del:del,
                        id:id,
                        brand_id:brand_id,
                        brand_name:brand_name,
                    },
                    success:function(result){ //เสร็จแล้วทำอะไรต่อ
                        Swal.fire({
                            icon: 'success',
                            // title: 'นำออกสำเร็จ!',
                            text: "ลบข้อมูลเรียบร้อย",
                            timer: 3000
                        });
                        $("#GroupDetails").html(result);
                        $('#showModel').addClass('d-none');
                        $('#showModelDetail').addClass('d-none');
                    }
                });
            }
            else{
                // Swal.fire('Changes are not saved', '', 'info');
            }
        });
    });
</script>

<script>
    var new_brand = $('#BN').val();
    var key = $('#KEY').val();
    // console.log(new_brand,key);
    $(`#brand-${key}`).text(new_brand);
</script>
