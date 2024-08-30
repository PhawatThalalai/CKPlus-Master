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
                    manage-asset
                @endslot
            @endcomponent
        @endcan
	</span>
	<div style="cursor: pointer; overflow: auto;  height: auto; min-height : 16rem;" onscroll="PositionScroll('scroll-slide-3')" id="scroll-slide-3" class="scroll-slide">
		@if($data->DataCusToDataCusAssetsMany != NULL && count($data->DataCusToDataCusAssetsMany) != 0)
            <div class="d-flex">
                <div class="resize me-1">
                    {{-- btn lerge --}}
                    @can('create-customer')
                        @component('components.content-user-about.btnAdd-large')
                            @slot('id')
                                {{ @$data->id }}
                            @endslot
                            @slot('funs')
                                manage-asset
                            @endslot
                        @endcomponent
                    @endcan
                </div>

                @foreach ($data->DataCusToDataCusAssetsMany as $value)
                    <div class="me-1">
                        @component('components.content-user-about.card-user-info')
                            @slot('data', [
                                'img' => 'assets/images/undraw/asset.svg',
                                'code' => $value->Code_Asset,
                                'title' => $value->DataCusAssetToTypeAsset->Name_Assets,
                                'Status' => $value->Status_Asset == 'active' ? 'กำลังใช้งาน' : 'ปิดใช้งาน',
                                'data1' => $value->houseProvince_Asset,
                                'data2' => $value->houseDistrict_Asset,
                                'data3' => $value->houseTambon_Asset,
                                'data4' => $value->created_at->Locale('th_TH')->DiffForHumans(),
                                'UserInsert' => $value->UserInsert,
                                'id' => $value->id,
                                'Main' => $value->Main_Asset,
                            ])
                            @slot('funs')
                                manage-asset
                            @endslot
                        @endcomponent
                    </div>
                @endforeach
            </div>
        @else
            <div class="row" >
                <div class="col text-center">
                    <img src="{{URL::asset('\assets\images\out-of-stock.png')}}" class="up-down mt-4" style="width:100px;">
                    <h5 class=" fw-semibold mt-2">ยังไม่มีข้อมูลทรัพย์ค้ำในลูกค้านี้</h5>
                    @can('create-customer')
                        <button class="btn btn-primary btn-sm rounded-pill data-modal-xl" type="button" data-link="{{ route('cus.create') }}?id={{@$data->id}}&funs={{'manage-asset'}}">
                            <i class="bx bx-add-to-queue"></i> เพิ่มทรัพย์ค้ำ
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
