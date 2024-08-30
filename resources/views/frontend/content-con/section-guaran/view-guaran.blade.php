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

@if(@$data != NULL && count($data) != 0)

    <div class="ms-4">
        <div class="row">
            <div class="col-12">
                <p id="demo" style="display:none;"></p>
                <span class="showScroll" style="display:none;">
                    {{-- btn small --}}
                    @component('components.content-user-about.btnAdd-small')
                        @slot('data', [
                            'Class' => 'addGuaran'
                        ]);
                    @endcomponent
                </span>

                <div style="cursor: pointer; overflow: auto;  height: auto;" onscroll="PositionScroll('scroll-slide-guaran')" id="scroll-slide-guaran" class="scroll-slide mx-4 my-2">
                    <div class="d-flex mt-2">
                        <div class="resize ">
                            <div class="card rounded-4 bg-primary text-center bg-soft me-2 card-hover addGuaran" data-flag="false" style = "min-width:10rem; max-width:10rem;  min-height:18rem; max-height:18rem; justify-content:center;" title="เพิ่มข้อมูลผู้ค้ำ">
                                <div class="row">
                                    <div class="col">
                                        <img src="{{ URL::asset('\assets\images\plus.png') }}" alt="เพิ่ม" style="width: 70%;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="content-guarantor d-flex">
                            @foreach(@$data as $item)
                                {{-- {{ @$item->GuarantortoUser->name}} --}}
                                @component('components.content-contract.section-cardCon.cardCon')
                                    @slot('data', [
                                        'img' => @$item->GuarantorToGuarantorCus->image_cus,
                                        'id' => @$item->id,
                                        'name-index' => 'ผู้ค้ำสัญญา', //ชื่อ index
                                        'index' => $loop->iteration, // ลำดับที่
                                        'title-left' => 'ชื่อเล่น', // หัวข้อการ์ดฝั่งซ้าย
                                        'Name_Cus' => @$item->GuarantorToGuarantorCus->Name_Cus,
                                        'data-left' => @$item->GuarantorToGuarantorCus->Nickname_cus,
                                        'title-right' => 'เบอร์ติดต่อ',
                                        'data-right' => @$item->GuarantorToGuarantorCus->Phone_cus,
                                        'content-head' => 'ข้อมูลผู้ค้ำ (Guaran Details)',
                                        'content-1' => 'เลข ปชช',
                                        'data-1' => @$item->GuarantorToGuarantorCus->IDCard_cus,
                                        'content-2' => 'เบอร์ติดต่อ',
                                        'data-2' => @$item->GuarantorToGuarantorCus->Phone_cus,
                                        'content-3' => 'ธนาคาร',
                                        'data-3' => @$item->GuarantorToGuarantorCus->Name_Account,
                                        'content-4' => 'สาขา',
                                        'data-4' => @$item->GuarantorToGuarantorCus->Branch_Account,
                                        'content-5' => 'เลขบัญชี',
                                        'data-5' => @$item->GuarantorToGuarantorCus->Number_Account,
                                        'data-linkview' => route("contract.show",$item->id)."?funs=showGuaran" , // link ดูข้อมูลเพิ่มเติม
                                        'data-linkedit' => route("contract.edit",$item->id)."?funs=editGuaran", // link แก้ไข
                                        'type-broker' => false,
                                        'btn-edit' => true,
                                        'datacom' => @$com, // ประเภทค่าคอม Broker
                                        'Commission_Broker' => '',
                                        'SumCom_Broker' => '',
                                        'TypeCom' => '',
                                        'PactCon_id' => @$item->PactCon_id,
                                        'classRemove' => 'removeGuaran', // คลาสตอนลบการ์ดออก
                                        'UserInsert' => @$item->GuarantortoUser->name,
                                        'LastUpdate' => @$item->updated_at,
                                    ])
                                @endcomponent
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


@else
    <div class="row" >
        <div class="col text-center" style = " min-height:20rem; max-height:20rem;">
            @component('components.content-empty.view-empty')
                @slot('btn_icon')
                     <i class="bx bxs-user-plus"></i>
                @endslot
                @slot('data', [
                // 'id' => @$item->id,
                'headtitle' => 'ยังไม่มีผู้ค้ำประกันในสัญญานี้ !',
                'title' => 'สามารถเพิ่มผู้ค้ำประกันได้ที่นี่',
                'title_btn' => 'เพิ่มผู้ค้ำประกัน',
                'name_btn' => 'addGuaran',
                ])
            @endcomponent
        </div>
    </div>
@endif

@include('frontend\content-con\section-guaran\script-guaran')
{{-- กดเพิ่มผู้ค้ำ --}}
<script type="text/javascript">
    $(".addGuaran").click(function() {
        var search = $('.header_inputSearch').val();
        var typeSr = 'namecus';
        var page_type = $('.page_type').val();
        var page = $('.page').val();
        var pageUrl = 'add-Guaran';
        var _token = $('input[name="_token"]').val();
        var flagTab = 'add-Guaran';

        getDataCus(search,typeSr,page,pageUrl,page_type,_token,flagTab)
    });
</script>



