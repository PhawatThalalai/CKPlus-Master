<style>
    .expens-popover {
      --bs-popover-max-width: 300px;
      --bs-popover-border-color: var(--bs-warning);
      --bs-popover-header-bg: var(--bs-warning);
      --bs-popover-header-color: var(--bs-white);
      --bs-popover-body-padding-x: 1rem;
      --bs-popover-body-padding-y: .5rem;
    }

    .bg-content {
        /* position: relative;
        display: flex;
        justify-content: end;
        background-color: rgba(255,255,255,0.6);
        background-image: url("{{ asset('assets/images/undraw/bgTarnsfer.svg') }}");
        background-repeat: no-repeat;
        background-position: right;
        background-size : contain; */
    }
</style>

<div class="modal-content">
    <div class="d-flex m-3">
		<div class="flex-shrink-0 me-2">
			<img src="{{ asset('assets/images/gif/suitcase.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
		</div>
		<div class="flex-grow-1 overflow-hidden">
			<h5 class="text-primary fw-semibold">ทำรายการโอนเงิน (Operate transfer)</h5>
			<p class="text-muted mt-n1 fw-semibold font-size-12">User. : {{ auth()->user()->name }}</p>
			<p class="border-primary border-bottom"></p>
		</div>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>
    <div class="row">
        <input type="hidden" id='PactCon' value={{ @$data->id }}>
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            <div class="nav nav-pills justify-content-center" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <button class="btn btn-outline-primary btn-sm rounded-pill active mb-2 me-2" id="v-pills-shipping-tab" data-bs-toggle="pill" href="#v-pills-shipping" role="tab" aria-controls="v-pills-shipping" aria-selected="false" tabindex="-1">
                   <i class="bx bx-file bx-tada"></i> รายอะเอียดค่าใช้จ่าย
                </button>
                <button class="btn btn-outline-primary btn-sm rounded-pill mb-2" id="v-pills-payment-tab" data-bs-toggle="pill" href="#v-pills-payment" role="tab" aria-controls="v-pills-payment" aria-selected="true">
                    <i class="bx bx-transfer bx-tada"></i> รายการที่ต้องโอน
                </button>
            </div>
        </div>
    </div>
	<div class="modal-body">
        <div class="">
            <div class="row g-2">
                <div class="col-12">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade active show" id="v-pills-shipping" role="tabpanel" aria-labelledby="v-pills-shipping-tab">
                                @include('frontend.content-treas.view-expenses')
                        </div>
                        <div class="tab-pane fade" id="v-pills-payment" role="tabpanel" aria-labelledby="v-pills-payment-tab">
                            <div class="row">
                                <div class="col bg-content">
                                    <div id="content-transfer">
                                        @include('frontend.content-treas.list-transfer')
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
            @if(@$data->Status_Con == 'complete' && @$data->ContractToPayee->sum('transferCash')==NULL && @$data->ContractToBrokers->sum('transferCash') == NULL)
            <button type="button" id="cancelApprove" class="btn btn-secondary btn-sm w-md waves-effect hover-up btn-danger" >
                <i class="mdi mdi-close-circle-outline"></i> Reject
            </button>
             
            @endif
            @if (@$is_flag == true)
            <button type="button" class="btn btn-secondary btn-sm w-md waves-effect hover-up btn-closeDetail" data-bs-toggle="modal" data-bs-target="#modal_xl_2" data-bs-dismiss="modal">
                <i class="mdi mdi-close-circle-outline"></i> ปิด
            </button>
            @else
            <button type="button" class="btn btn-secondary btn-sm w-md waves-effect hover-up" data-bs-dismiss="modal">
                <i class="mdi mdi-close-circle-outline"></i> ปิด
            </button>
            @endif
    </div>
</div>

<script>
    $('[data-bs-toggle="popover"]').popover({
        html: true,
        trigger: 'hover'
    })
</script>

<script>
  $(".btn-closeDetail").on('click', function(){
    $('#modal_xl_static').modal('hide');
    $('#modal_xl_2').modal('show');
  });
</script>

<script>
// ยกเลิกขออนุมัติ
$('#cancelApprove').click(function() {

    Swal.fire({
        icon: "warning",
        text: 'ต้องการ Reject สัญญานี้ใช่หรือไม่',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ตกลง',
        cancelButtonText: 'ยกเลิก',
    }).then((value) => {
        if (value.isConfirmed == true) {
            let url = '{{ route('treas.update', 'ID') }}'
                url = url.replace('ID', $('#PactCon').val())

            $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
            $.ajax({
                url: url,
                method: "PUT",
                dataType: 'JSON',
                data : {
                    _token : '{{ @CSRF_TOKEN() }}',
                    fun : 'reject'
                    
                },
                success: function(res) {
                    $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                    swal.fire({
                        icon: 'success',
                        title: 'Success !',
                        text: 'Reject สัญญา เรียบร้อย',
                        timer: 2000,
                    })

                    $('.modal').modal('hide');
                    location.reload(true);         
                },
                error: function(err) {
                    $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                    console.log(err);
                    // swal.fire({
                    //     icon : 'error',
                    //     title : `${ err.responseJSON.message}`,
                    //     text : `${ err.responseJSON.message}`,
                    //     showConfirmButton: true,
                    // })
                }
            });

        }
    });

});
</script>
{{-- <script>
    $(function(){
        // กดโอนเงิน ปิดบัญชี ผู้รับเงิน ผู้แนะนำ 
        transferedCash = (ElementsBank) => {
            let cusID = $(this).attr("cusID");
            let status = $(this).attr("status");
            let Bank = $('#Bank_id-'+ElementsBank).val() // เลือกบัญชีธนาคารที่จะโอน
            if(Bank != ''){
                $('.btn-transfer').prop('disabled', true);
                    $('<span />', {
                        class: "spinner-border spinner-border-sm",
                        role: "status"
                    }).appendTo(".addSpin");
                $.ajax({
                    url : '{{  route('treas.store') }}',
                    type : 'POST',
                    data : $('#transfer'+status+'-'+cusID).serialize(),
                    success : (res) => {
                        $('.addSpin').empty();
                        $('.btn-transfer').prop('disabled', false);
                        $('#content-transfer').html(res.pageTransfer)
                        swal.fire({
                            icon : 'success',
                            title :  'successfully !',
                            text : '',
                            timer : 2000
                        })
                    },
                    error : (err)=>{
                        $('.addSpin').empty();
                        $('.btn-transfer').prop('disabled', false);
                        swal.fire({
                            icon : 'error',
                            title :  'error !',
                            text : `${ err.responseJSON.message }`,
                            timer : 2000
                        })
                    }
                })
            } else {
                swal.fire({
                    icon : 'info',
                    title : 'โอนเงินไม่สำเร็จ !',
                    text : 'กรุณาเลือกบัญชีธนาคารที่จะทำการโอนเงินออก',
                })
            }
        }
    })
</script> --}}
