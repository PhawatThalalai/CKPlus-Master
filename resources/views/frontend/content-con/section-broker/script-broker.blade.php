

{{-- เพิ่มผู้แนะนำในสัญญา --}}
<script>
    $('.selectBroker').click((evt)=>{
        var StatusCon = $('#Status_Con').val();
        var StatusAudit = $('#Status_Audit').val();
        var StatusArr = ['active','pending'];
            $('.iconCus').hide()
            $('.loadCusCon').show()
            $('.selectBroker').prop('disablde',true)
            PactCon_id = $('#PactCon_id').val();
            const idCus = $(evt.currentTarget).attr('idCus');
            let testdata = $(evt.currentTarget).attr('data-t');
            $.ajax({
                url : '{{route('contract.store')}}',
                type : 'post',
                data : {
                    idCus : idCus,
                    PactCon_id : PactCon_id,
                    testdata : testdata,
                    func : 'addBroker',
                    _token : '{{ @csrf_token() }}',
                },
                success :async (res) => {
                    $('.iconCus').show()
                    $('.loadCusCon').hide()
                    $('.selectBroker').prop('disablde',false)
                    await swal.fire({
                        icon: 'success',
                        text : 'เพิ่มข้อมูลผู้แนะนำเรียบร้อย',
                        timer : 2000
                    })
                    // $('#section-content').html(res.html);
                    $('#section-content').html(res.html);
                    $('#section-Tab').html(res.renderTab);
                    $('.data-modal-search').modal('hide');
                },
                error :async (err) => {
                    $('.iconCus').show()
                    $('.loadCusCon').hide()
                    $('.selectBroker').prop('disablde',false)
                    await swal.fire({
                        icon : 'error',
                        title : `${ err.responseJSON.message}`,
                        text : `${ err.responseJSON.text}`,
                        showConfirmButton: true,
                })
                }
            })

    })
</script>

{{-- ลบผู้แนะนำออกจากสัญญา --}}
<script>
    $('.removeBroker').click((evt)=>{
       let id =  $(evt.currentTarget).attr('data-id')
       let urltxt = "{{ route('contract.destroy','ID') }}";
       let url = urltxt.replace('ID',id)
       let count = 0
       Swal.fire({
            title: 'ต้องการลบผู้แนะนำออกจากสัญญานี้ หรือไม่?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'ใช่, ต้องการลบ !'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
             url : url,
             type : 'DELETE',
             data : {
                 func  : 'removeBroker',
                 PactCon_id : sessionStorage.getItem('PactCon_id'),
                 _token : '{{ @csrf_token() }}'
             },
             success : (res)=>{
                swal.fire({
                    icon : 'success',
                    title : 'Success !',
                    text : 'ลบผู้แนะนำออกจากสัญญาเรียบร้อย',
                    timer : 2000,
                    })

                    $('.cardCus-'+id).fadeOut(500,()=>{
                        $('.cardCus-'+id).remove()
                        $('.content-Broker .d-flex').each(function(index){
                        $(this).find('.index').html(index+1)
                        });
                    })
                    if($('.content-Broker .d-flex').length == 1){ // เหลือการ์ดเดียว return append data ใหม่
                    $('#section-content').html(res.html);
                    $('#section-Tab').html(res.renderTab);
                    }

             },
             error : async (err)=>{
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


    })
</script>

