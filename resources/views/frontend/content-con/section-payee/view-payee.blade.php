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

@if(@$dataPay != NULL && count($dataPay) != 0)

    <div class="ms-4">
        <div class="row">
            <div class="col-12">
                <p id="demo" style="display:none;"></p>
                <span class="showScroll" style="display:none;">
                    {{-- btn smaller --}}
                    @component('components.content-user-about.btnAdd-small')
                        @slot('data', [
                            'Class' => 'addPayee'
                        ]);
                    @endcomponent
                </span>
                <div style="cursor: pointer; overflow: auto;  height: auto;" onscroll="PositionScroll('scroll-slide-payee')" id="scroll-slide-payee" class="scroll-slide mx-4 my-2">
                    <div class="d-flex mt-2">
                        @if (count(@$dataPay) <1 || (in_array(@$dataPay[0]->PayeetoCon->ContractToDataCusTags->Type_Customer,['CUS-0004' , 'CUS-0005' , 'CUS-0006']) && count(@$dataPay)  < 2   ))
                            <div class="resize ">
                                <div class="card rounded-4 bg-primary text-center bg-soft me-2 addPayee card-hover" data-flag="false" style = "min-width:10rem; max-width:10rem;  min-height:18rem; max-height:18rem; justify-content:center;" title="เพิ่มข้อมูลผู้ค้ำ">
                                    <div class="row">
                                        <div class="col">
                                            <img src="{{ URL::asset('\assets\images\plus.png') }}" alt="เพิ่ม" style="width: 70%; ">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                        <div class="resize ">
                            <div class="card rounded-4 bg-secondary text-center bg-soft me-2" data-flag="false" style = "min-width:10rem; max-width:10rem;  min-height:18rem; max-height:18rem; justify-content:center; cursor:no-drop;" title="เพิ่มข้อมูลผู้ค้ำ">
                                <div class="row">
                                    <div class="col">
                                        <img src="{{ URL::asset('\assets\images\plus.png') }}" alt="เพิ่ม" style="width: 70%; filter: grayscale(100%);">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="content-cardcon d-flex">
                            @foreach(@$dataPay as $item)
                                @component('components.content-contract.section-cardCon.cardCon')
                                    @slot('data', [
                                        'img' => @$item->PayeetoCus->image_cus,
                                        'id' => @$item->id,
                                        'name-index' => $item->status_Payee=='Payee'?'ผู้รับเงิน':'ผู้รับยอดปิดบัญชี', //ชื่อ index
                                        'index' => $loop->iteration, // ลำดับที่
                                        'title-left' => 'ชื่อเล่น', // หัวข้อการ์ดฝั่งซ้าย
                                        'Name_Cus' => @$item->PayeetoCus->Name_Cus,
                                        'data-left' => @$item->PayeetoCus->Nickname_cus,
                                        'title-right' => 'เบอร์ติดต่อ',
                                        'data-right' => @$item->PayeetoCus->Phone_cus,
                                        'content-head' => 'ข้อมูลผู้รับเงิน (Payee Details)',
                                        'content-1' => 'เลข ปชช',
                                        'data-1' => @$item->PayeetoCus->IDCard_cus,
                                        'content-2' => 'เบอร์ติดต่อ',
                                        'data-2' => @$item->PayeetoCus->Phone_cus,
                                        'content-3' => 'ธนาคาร',
                                        'data-3' => @$item->PayeetoCus->Name_Account,
                                        'content-4' => 'สาขา',
                                        'data-4' => @$item->PayeetoCus->Branch_Account,
                                        'content-5' => 'เลขบัญชี',
                                        'data-5' => @$item->PayeetoCus->Number_Account,
                                        'data-linkview' => route("contract.show",$item->id)."?funs=showPayee" , // link ดูข้อมูลเพิ่มเติม
                                        'data-linkedit' => '', // link แก้ไข
                                        'type-broker' => false,
                                        'btn-edit' => false,
                                        'datacom' => '', // ประเภทค่าคอม Broker
                                        'Commission_Broker' => '',
                                        'SumCom_Broker' => '',
                                        'TypeCom' => @$item->TypeCom,
                                        'PactCon_id' => @$item->PactCon_id,
                                        'classRemove' => 'removePayee', // คลาสตอนลบการ์ดออก
                                        'UserInsert' => @$item->PayeetoUser->name,
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
        <div class="col text-center" style = "min-height:20rem; max-height:20rem;">

            @component('components.content-empty.view-empty')
            @slot('btn_icon')
                <i class="bx bxs-user-plus"></i>
            @endslot
            @slot('data', [
            // 'id' => @$item->id,
            'headtitle' => 'ยังไม่มีผู้รับเงินในสัญญานี้ !',
            'title' => 'สามารถเพิ่มผู้รับเงินได้ที่นี่',
            'title_btn' => 'เพิ่มผู้รับเงิน',
            'name_btn' => 'addPayee',
            ])
        @endcomponent


        </div>
    </div>
@endif

@include('frontend.content-con.section-payee.script-payee')
<script type="text/javascript">
    $(".addPayee").click(function() {
        var search = $('.header_inputSearch').val();
        var PactCon_id = $('#PactCon_id').val();
        var typeSr = 'namecus';
        var page_type = $('.page_type').val();
        var page = $('.page').val();
        var pageUrl = 'add-Payee';
        var _token = $('input[name="_token"]').val();
        var flagTab = 'add-Payee';
        var dataFlag = $('.addPayee').attr('data-flag');
        getDataCus(search,typeSr,page,pageUrl,page_type,_token,flagTab,dataFlag)
    });
</script>





