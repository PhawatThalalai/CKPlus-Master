<style>
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
<div>
	<p id="demo" style="display:none;"></p>
	<span class="showScroll" style="display:none;">
		{{-- btn small --}}
        @can('create-customer')
            @component('components.content-user-about.btnAdd-small')
                @slot('id')
                    {{ @$data->id }}
                @endslot
                @slot('funs')
                    manage-carreer
                @endslot
            @endcomponent
        @endcan
	</span>
	<div style="cursor: pointer; overflow: auto;  height: auto; min-height : 16rem;" onscroll="PositionScroll('scroll-slide-2')" id="scroll-slide-2" class="scroll-slide">
        @if($data->DataCusToDataCusCareerMany != NULL && count($data->DataCusToDataCusCareerMany) != 0)
            <div class="d-flex">
                <div class="resize me-1">
                    {{-- btn lerge --}}
                    @can('create-customer')
                        @component('components.content-user-about.btnAdd-large')
                            @slot('id')
                                {{ @$data->id }}
                            @endslot
                            @slot('funs')
                                manage-carreer
                            @endslot
                        @endcomponent
                    @endcan
                </div>
                @foreach ($data->DataCusToDataCusCareerMany as $value)
                    <div class="me-1">
                        {{-- btn lerge --}}
                        @component('components.content-user-about.card-user-info')
                            @slot('data', [
                                'img' => 'assets/images/undraw/career.svg',
                                'code' => @$value->Code_Cus,
                                'title' => @$value->CusCareerToTBCareerCus->Name_Career,
                                'Status' => @$value->Status_Cus == 'active' ? 'กำลังใช้งาน' : 'ปิดใช้งาน',
                                'data1' => @$value->Career_Cus,
                                'data2' => @$value->Workplace_Cus,
                                'data3' => @$value->AfterIncome_Cus,
                                'data4' => @$value->created_at->Locale('th_TH')->DiffForHumans(),
                                'UserInsert' => $value->UserInsert,
                                'id' => $value->id,
                                ])
                            @slot('funs')
                                manage-carreer
                            @endslot
                        @endcomponent
                    </div>
                @endforeach
            </div>
        @else
            <div class="row" >
                <div class="col text-center">
                    <img src="{{URL::asset('\assets\images\out-of-stock.png')}}" class="up-down mt-4" style="width:100px;">
                    <h5 class=" fw-semibold mt-2">ยังไม่มีข้อมูลอาชีพในลูกค้านี้</h5>
                    @can('create-customer')
                        <button class="btn btn-primary btn-sm rounded-pill data-modal-xl" type="button" data-link="{{ route('cus.create') }}?id={{@$data->id}}&funs={{'manage-carreer'}}">
                            <i class="bx bx-add-to-queue"></i> เพิ่มอาชีพ
                        </button>
                    @endcan
                </div>
            </div>
        @endif
    </div>
</div>

	<script>
		function PositionScroll(ElementID) {
			const element = document.getElementById(ElementID);
			let x = element.scrollLeft;
			let y = element.scrollTop;
			let result = 1 - (x / 165);
			document.getElementById("demo").innerHTML = "Horizontally: " + x.toFixed() + "<br>Vertically: " + result;
			let size = $('.resize').width();

			if (x >= 120) {
				$('.showScroll').show();
			} else {
				$('.showScroll').hide();
				$('.resize').css('scale', `${result}`);
			}
		}
	</script>
