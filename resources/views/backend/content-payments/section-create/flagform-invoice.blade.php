<form id="form-invoice">
    @component('components.content-invoice.form-invoice')
    @slot( 'data', [
        "data" => @$data,
        "FLAGINV" => @$FLAGINV

    ])
    @endcomponent
</form>


<script>
    $(document).ready(function() {
        let check = $('#deleted_at').val()
        let STATUSPAY = $('#STATUSPAY').val()
        if(check != '' || STATUSPAY != ''){
            $('#btn-newInvoice,.btn-DisplayDetail,#btn-close').show()
            $('#btn-saveInvoice,#receivePay,#printInvoice,#btn-back,.btn-next').hide()
        }
    })
</script>




