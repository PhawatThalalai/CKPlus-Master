<style>
    .scroll-slide::-webkit-scrollbar
    {
        width: 5px;
        height : 7px;
        background-color: #F5F5F5;
    }
    .scroll-slide::-webkit-scrollbar-thumb
    {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
        background-color: #ddd;
    }
    .resize{
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
                manage-adds
                @endslot
            @endcomponent
        @endcan
    </span>
    <div style="cursor: pointer; overflow: auto;  height: auto; min-height : 16rem;" onscroll="PositionScroll('scroll-slide-1')" id="scroll-slide-1" class="scroll-slide">
        @if($data->DataCusToDataCusAddsMany != NULL && count($data->DataCusToDataCusAddsMany ) != 0)
        <div class="d-flex">
            <div class="resize me-1">
                {{-- btn lerge --}}
                @can('create-customer')
                    @component('components.content-user-about.btnAdd-large')
                        @slot('id')
                            {{ @$data->id }}
                        @endslot
                        @slot('funs')
                            manage-adds
                        @endslot
                    @endcomponent
                @endcan
            </div>

                @foreach($data->DataCusToDataCusAddsMany as $value)
                    <div class="me-1">
                        @component('components.content-user-about.card-user-info')
                            @slot('data',[
                                'img' => 'assets/images/undraw/undraw_home.svg',
                                'DataCus_id' => $value->DataCus_id,
                                'code' => $value->Code_Adds,
                                'title' => $value->DataCusAddsToTypeAdds->Name_Address,
                                'Status' => ($value->Status_Adds == 'active' ? 'กำลังใช้งาน' : 'ปิดใช้งาน'),
                                'data1' => $value->houseTambon_Adds,
                                'data2' => $value->houseDistrict_Adds,
                                'data3' => $value->houseProvince_Adds,
                                'data4' => @$value->created_at->Locale('th_TH')->DiffForHumans(),
                                'UserInsert' => $value->UserInsert,
                                'id' => $value->id,
                                'Type_Adds' => $value->Type_Adds,
                                ])
                            @slot('funs')
                            manage-adds
                            @endslot
                        @endcomponent
                    </div>
                @endforeach
        </div>
        @else
        <div class="row" >
            <div class="col text-center">
                <img src="{{URL::asset('\assets\images\out-of-stock.png')}}" class="up-down mt-4" style="width:100px;">
                <h5 class=" fw-semibold mt-2">ยังไม่มีข้อมูลที่อยู่ในลูกค้านี้</h5>
                @can('create-customer')
                    <button class="btn btn-primary btn-sm rounded-pill data-modal-xl" type="button" data-link="{{ route('cus.create') }}?id={{@$data->id}}&funs={{'manage-adds'}}"> 
                        <i class="bx bx-add-to-queue"></i> เพิ่มที่อยู่
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
        let result = 1 - (x/165) ;
        document.getElementById ("demo").innerHTML = "Horizontally: " + x.toFixed() + "<br>Vertically: " +result;
        let size = $('.resize').width();

        if (x >= 120){
            $('.showScroll').show();
        }else{
            $('.showScroll').hide();
            $('.resize').css('scale',`${result}`);
        }
    }
    function resetScroll(ElementID) {
        const element = document.getElementById(ElementID);
        element.scrollLeft = 0;
        PositionScroll(ElementID);
    }
</script>




