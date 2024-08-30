<div class="modal-content">
    <div class="modal-header">
        <h5 class="text-primary fw-semibold modal-title"> <i class="bx bx-receipt"></i> ตั้งค่ายอดเงินประจำวัน ( Manage Credit )</h5>
        <button type="button" class="btn-close btntest" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
	<div class="modal-body">
        <div id="content-Credit">
            @include('frontend.content-treas.content-credit')
        </div>
    </div>

    <div class="modal-footer mt-4">
        <button type="button" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">ปิด</button>
    </div>
</div>


<script>

    $('.btn-NextPre').click(()=>{
        $('.expenses').val('')
        $('.Memo').val('')

        setTimeout(() => {
            $('.first-tab').trigger('click')
        }, 500);
    })

    $('.btn-submitCredit').click((e)=>{
        //let expenses = $('.expenses').val()
        let _bankid = $(e.currentTarget).data('bankid');
        let expenses = $(`.expenses[data-bankid="${_bankid}"]`).val();
        if(expenses != ''){
            $('.btn-submitCredit').prop('disabled',true)
            $('.icon').hide()
             $('<span />', {
                    class: "spinner-border spinner-border-sm",
                    role: "status"
            }).appendTo(".addSpin");

            let dataBank = $(e.currentTarget).attr('dataBank')
            let tran = $(e.currentTarget).attr('tran')
            let tranTxt = $(e.currentTarget).attr('tranTxt')
            $('#TransactionDetail-'+dataBank).val(tran)
            $('#TransactionTxt-'+dataBank).val(tranTxt)

            $.ajax({
                url : '{{  route('treas.store') }}',
                type : 'POST',
                data : $('#formCredit-'+dataBank).serialize(),
                success : (res)=>{

                    $('.btn-submitCredit').prop('disabled',false)
                    $('.icon').show()
                    $('.addSpin').empty()

                    $('#Show_Amount_after-'+res.idBank).html((res.Amount_after).toLocaleString())
                    $('#content-transaction-'+res.idBank).html(res.viewTran)

                    swal.fire({
                        icon : 'success',
                        title :  'successfully !',
                        text : '',
                        timer : 2000

                    })
                },
                error : (err)=>{
                    $('.btn-submitCredit').prop('disabled',false)
                    $('.icon').show()
                    $('.addSpin').empty()
                    swal.fire({
                        icon : 'error',
                        title :  'error !',
                        text : '',
                        timer : 2000

                    })
                }
            })
        } else {
            swal.fire({
                icon : 'warning',
                title : 'ข้อมูลไม่ครบ !',
                text : 'กรุณากรอกจำนวนเงินก่อนดำเนินการ'
            })
        }
    })
</script>
