<style>
    .dataCus-popover {
  --bs-popover-max-width: 200px;
  --bs-popover-border-color: var(--bs-primary);
  --bs-popover-header-bg: var(--bs-primary);
  --bs-popover-header-color: var(--bs-white);
  --bs-popover-body-padding-x: 1rem;
  --bs-popover-body-padding-y: .5rem;
}
</style>
<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title">แก้ไขสถานะสัญญา (Edit Contracts)</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    <div class="modal-body">
        <div class="row g-1">
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="col-md-12">
                    <div class="row px-3">
                        @if(auth()->user()->position != 'staff')
                            @foreach($StatusCon as $item)
                                <div class="col-12">
                                    <label class="card-radio-label mb-2" data-bs-toggle="popover" data-bs-placement="right" data-bs-trigger="hover" data-bs-title="<p class='fw-semibold mb-0'> <i class='bx bx-error-circle'></i> {{ $item->Memo_StatusCon }} </p>" data-bs-custom-class="dataCus-popover" data-bs-content="
                                        <div class='row'>
                                            <div class='col-12 fs-6 text-center fw-semibold border-top border-light py-2'>
                                                {{ @$item->Description }}
                                            </div>
                                        </div>">
                                        <input type="radio" name="Status_Con" memo = "{{ $item->Memo_StatusCon }}"  value="{{ $item->Name_StatusCon }}" class="card-radio-input Status_Con" {{ @$data->Status_Con == $item->Name_StatusCon ? 'checked' : '' }}>
                                        <div class="card-radio">
                                            @if ($item->Name_StatusCon == 'active')
                                                <i class="fas fa-book-open font-size-24 text-info align-middle me-2 text-info"></i>
                                            @elseif($item->Name_StatusCon == 'cancel')
                                                <i class="fas fa-times font-size-24 text-primary align-middle me-2 text-danger"></i>
                                            @elseif($item->Name_StatusCon == 'complete')
                                                <i class="fas fa-check font-size-24 text-primary align-middle me-2 text-success"></i>
                                            @elseif($item->Name_StatusCon == 'transfered')
                                                <i class="fas fa-donate font-size-24 text-primary align-middle me-2 text-success"></i>
                                            @elseif($item->Name_StatusCon == 'close')
                                                <i class="fas fa-file-archive font-size-24 text-primary align-middle me-2 text-success"></i>
                                            @elseif($item->Name_StatusCon == 'pending')
                                                <i class="fas fa-user-clock font-size-24 text-primary align-middle me-2 text-warning"></i>
                                            @endif
                                            <span>{{ $item->Memo_StatusCon }}</span>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12">
                <div class="col-md-12 mb-2">
                    <div class="form-floating">

                        @hasrole(['administrator','audit'])
                        <input type="date" class="form-control Date_monetary" name="Date_monetary" value="{{ substr(@$data->Date_monetary,0,10) }}" placeholder="วันที่โอนเงิน" style=" {{ @$data->Flag_Inside == 'Y' ? 'pointer-events: none;' : '' }} ">
                        <label for="floatingInputGrid">วันที่โอนเงิน</label>
                        @else
                        <input type="date" class="form-control Date_monetary" name="Date_monetary" value="{{  substr(@$data->Date_monetary,0,10) }}" placeholder="วันที่โอนเงิน" readonly>
                        <label for="floatingInputGrid">วันที่โอนเงิน</label>
                        @endhasrole
                    </div>
                </div>

                <div id="content-statusCon">
                    <div class="col-12">
                        <div class="">
                            {{-- <label class="fw-semibold label_Memo">หมายเหตุ</label> --}}
                            <textarea type="text" class="form-control bg-light Memo_Contracts" name="Memo_Contracts" id="Memo_Contracts" rows="16"  placeholder="หมายเหตุสัญญา" {{ @$data->Status_Con == 'cancel' ? '' : 'readonly' }}>{{@$data->Memo_Con}}</textarea>
                        </div>
                        <div class="row {{ @$data->Status_Con == 'cancel' ? '' : 'd-none' }}">
                            <div class="col text-end">
                                <p class="text-danger">ผู้ยกเลิก : {{ $data->UserCancel_Con }} วันที่ยกเลิก : {{ substr($data->DateCancel_Con,0,10) }} </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" id="btn-UpdateStatusCon" class="btn btn-primary btn-sm">บันทึก</button>
        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
    </div>
</div>



{{-- <script>
    $('#Status_Con').change(()=>{
        let status = $('#Status_Con').val()
        if (status == 'cancel'){
            $('#content-statusCon').show()
        }else{
            $('#content-statusCon').hide()
        }
    })
</script> --}}

<script>
	$('[data-bs-toggle="popover"]').popover({
		html: true,
		trigger: 'hover'
	})
</script>


<script>
    $('.Status_Con').click(()=>{
        let status =  $("input[name='Status_Con']:checked").val()
        if (status == 'cancel'){
            $('#Memo_Contracts').prop('readonly', false)
            $('#Memo_Contracts').removeClass('bg-light')
        }else{
            $('#Memo_Contracts').prop('readonly', true)
            $('#Memo_Contracts').addClass('bg-light')
        }


    });
</script>

{{-- บันทึกโปรไฟล์สัญญา --}}
<script>
	$('#btn-UpdateStatusCon').click(()=>{
        let PactCon_id = sessionStorage.getItem('PactCon_id');
        let url = '{{ route('contract.update','ID') }}';
        let Status_Con = $("input[name='Status_Con']:checked").val()
        let Memo_Contracts = $('#Memo_Contracts').val()
        let Date_monetary = $('.Date_monetary').val()
        let StatusApp_Con = $("input[name='Status_Con']:checked").attr('memo');
        url = url.replace('ID', PactCon_id);

        $('#btn-UpdateStatusCon').prop('disabled', true);
        $('<span />', {
        class : "spinner-border spinner-border-sm",
        role : "status"
        }).appendTo(".spinner");

        if(Status_Con == 'cancel' && Memo_Contracts == ''){
            $('.spinner').empty();
            swal.fire({
                icon: 'warning',
                title : 'กรุณาระบุหมายเหตุ !',
                text : 'การยกเลิกสัญญาต้องมีการระบุหมายเหตุทุกครั้ง ก่อนทำการบันทึก',
                showConfirmButton : true,
            })
            $('#btn-UpdateStatusCon').prop('disabled', false);
            $('.label_Memo').addClass('text-danger')
            $('.Memo_Contracts').addClass('border border-danger').focus()
        }else{
            $.ajax({
                url : url,
                method : 'put',
                data : {
                    _token : '{{ @CSRF_TOKEN() }}',
                    PactCon_id : PactCon_id ,
                    Status_Con : Status_Con ,
                    Memo_Contracts : Memo_Contracts,
                    Date_monetary : Date_monetary,
                    StatusApp_Con :StatusApp_Con,
                    funs : 'editStatusCon',
                },
                success :async (res)=>{
                        $('#btn-UpdateStatusCon').prop('disabled', false);
                        $('.spinner').empty();

                        await swal.fire({
                            icon : 'success',
                            title : 'บันทึกข้อมูลสำเร็จ',
                            text :'อัพเดทข้อมูลเรียบร้อย',
                            timer: 2000,
                            showConfirmButton: false,
                        })
                        $('#section-cardCon').html(res.htmlheader)
						$('#section-Tab').html(res.renderTab)
                        $('#asset-tab').trigger('click')
                        await $('.modal').modal('hide');

                },
                error :async (err)=>{
                    $('#btn-UpdateStatusCon').prop('disabled', false);
                    $('.spinner').empty();

                    await swal.fire({
                        icon : 'error',
                        title : `${ err.responseJSON.message}`,
                        text : `${ err.responseJSON.text}`,
                        showConfirmButton: true,
                    })
                }
            })
        }
	})
</script>
