
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
                            'Class' => 'addBroker'
                        ]);

                    @endcomponent
                </span>
                <div style="cursor: pointer; overflow: auto;  height: auto;" onscroll="PositionScroll('scroll-slide-broker')" id="scroll-slide-broker" class="scroll-slide mx-4 my-2">
                    <div class="d-flex mt-2">
                        <div class="resize ">
                            <div class="card rounded-4 bg-primary text-center bg-soft me-2 card-hover addBroker" data-flag="false" style = "min-width:10rem; max-width:10rem;  min-height:18rem; max-height:18rem; justify-content:center;" title="เพิ่มข้อมูลผู้ค้ำ">
                                <div class="row">
                                    <div class="col">
                                        <img src="{{ URL::asset('\assets\images\plus.png') }}" alt="เพิ่ม" style="width: 70%;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="content-Broker d-flex">
                            @foreach(@$data as $item)
                                @component('components.content-contract.section-cardCon.cardCon')
                                    @slot('data', [
                                        'img' => @$item->BrokertoCus->image_cus,
                                        'id' => @$item->id,
                                        'name-index' => 'ผู้แนะนำ', //ชื่อ index
                                        'index' => $loop->iteration, // ลำดับที่
                                        'title-left' => 'ชื่อเล่น', // หัวข้อการ์ดฝั่งซ้าย
                                        'Name_Cus' => @$item->BrokertoCus->Name_Cus ."  ( ".@$item->BrokertoCus->DataCusToBroker->BrokerToType->Name_typeBroker." )",
                                        'data-left' => @$item->BrokertoCus->Nickname_cus ,
                                        'title-right' => 'ค่าคอม ฯ',
                                        'data-right' => number_format(@$item->SumCom_Broker,0),
                                        'content-head' => 'ข้อมูลผู้แนะนำ (Broker Details)',
                                        'content-1' => 'เลข ปชช',
                                        'data-1' => @$item->BrokertoCus->IDCard_cus,
                                        'content-2' => 'เบอร์ติดต่อ',
                                        'data-2' => @$item->BrokertoCus->Phone_cus,
                                        'content-3' => 'ธนาคาร',
                                        'data-3' => @$item->BrokertoCus->Name_Account,
                                        'content-4' => 'สาขา',
                                        'data-4' => @$item->BrokertoCus->Branch_Account,
                                        'content-5' => 'เลขบัญชี',
                                        'data-5' => @$item->BrokertoCus->Number_Account,
                                        'data-linkview' => route("contract.show",$item->id)."?funs=showBroker" , // link ดูข้อมูลเพิ่มเติม
                                        'data-linkedit' => '', // link แก้ไข
                                        'type-broker' => true,
                                        'btn-edit' => false,
                                        'datacom' => @$com, // ประเภทค่าคอม Broker
                                        'Commission_Broker' => @$item->Commission_Broker,
                                        'SumCom_Broker' => number_format(@$item->SumCom_Broker,2),
                                        'textAlert' => @$item->SumCom_Broker == NULL ? 'กรุณาเพิ่มค่าคอมให้ผู้แนะนำ !' : NULL,
                                        'TypeCom' => @$item->TypeCom,
                                        'PactCon_id' => @$item->PactCon_id,
                                        'classRemove' => 'removeBroker', // คลาสตอนลบการ์ดออก
                                        'UserInsert' => @$item->BrokertoUser->name,
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
                'headtitle' => 'ยังไม่มีผู้แนะนำในสัญญานี้ !',
                'title' => 'สามารถเพิ่มผู้แนะนำได้ที่นี่',
                'title_btn' => 'เพิ่มผู้แนะนำ',
                'name_btn' => 'addBroker',
                ])
            @endcomponent
        </div>
    </div>
@endif

    @include('frontend\content-con\section-broker\script-broker')

    {{-- กดเพิ่มผู้แนะนำ --}}
    <script type="text/javascript">
        $(".addBroker").click(function() {
            var search = $('.header_inputSearch').val();
            var typeSr = 'namecus';
            var page_type = $('.page_type').val();
            var page = $('.page').val();
            var pageUrl = 'add-Broker';
            var _token = $('input[name="_token"]').val();
            var flagTab = 'add-Broker';
            getDataCus(search,typeSr,page,pageUrl,page_type,_token,flagTab)
        });
    </script>

<script>
    saveCom = (index,idBrk,PactCon_id) =>{
        $('.btn-saveCom').prop('disabled', true);
        let commission = $(`.commission-${index}`).val();
        let typeCom = $(`.typeCom-${index}`).val();
        let totalCom  = $(`.totalCom-${index}`).val();
        $.ajax({
            url : ' {{route('contract.update',0) }}',
            type : 'put',
            data : {
                commission:commission,
                typeCom:typeCom,
                totalCom:totalCom,
                idBrk : idBrk,
                PactCon_id:PactCon_id,
                funs : 'UpdateCom',
                flag : 'yes',
                _token : '{{ @csrf_token() }}'
            },
            success :async (res) => {
                if(res.FlagCon == 'fail'){
                    swal.fire({
                        icon : 'error',
                        title : 'Success !',
                        text : 'ไม่สามารถเพิ่มค่าคอมฯ สัญญาอนุมัติเเล้ว',
                        timer : 2000,
                    })
                } else {
                    $('.btn-saveCom').prop('disabled', false);
                    await swal.fire({
                        icon: 'success',
                        text : 'เพิ่มค่าคอมมิชชั่นผู้แนะนำเรียบร้อย',
                        timer : 2000
                    })
                    $('#section-content').html(res.html);
                    $('#section-Tab').html(res.renderTab);
                }
            },
            error :async (err) => {
                $('.btn-saveCom').prop('disabled', false);
                await swal.fire({
                    icon: 'error',
                    title : `ERROR !${err.status}`,
                    text : `${ err.responseJSON.message }`
                })
            }
        })
    }
</script>

<script>

    $('.typeCom').change(function(){
        var id = $(this).attr('id');
        var id_br = id.split('-');
        var total = 0;
        var typeCom =$('option:selected', this).attr('dataVal');
        var commission = $('#commission-'+id_br[1]).val().replace(/[,]/g, '');

        total = parseFloat(commission) - ( parseFloat(commission) * ( parseInt(typeCom)/100 ) );
        $('#totalCom-'+id_br[1]).val(total);


    });
</script>



