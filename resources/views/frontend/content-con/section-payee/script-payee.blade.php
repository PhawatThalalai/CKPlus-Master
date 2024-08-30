

 {{-- ผู้รับเงิน --}}
 <script>
    $('.selectPayee').click((evt)=>{
        $('.selectPayee').prop('disablde',true)
        $('.iconCus').hide()
        $('.loadCusCon').show()
        PactCon_id = $('#PactCon_id').val();

        const idCus = $(evt.currentTarget).attr('idCus');
        const status_Payee = $(evt.currentTarget).attr('status_Payee');
        $.ajax({
            url : '{{route('contract.store')}}',
            type : 'post',
            data : {
                idCus : idCus,
                PactCon_id : PactCon_id,
                status_Payee : status_Payee ,
                func : 'addPayee',
                _token : '{{ @csrf_token() }}',
            },
            success :async (res) => {
                if(res.Payee == 'fail'){
                    await  swal.fire({
                        icon : 'error',
                        title : 'ไม่สำเร็จ !',
                        text : `${res.message}`,
                        timer : 2000,
                        })
                    $('.iconCus').show()
                    $('.loadCusCon').hide()
                    $('.selectPayee').prop('disablde',false)
                }else if(res.StatusPayee == 'fail'){
                    await swal.fire({
                        icon : 'error',
                        title : 'ไม่สำเร็จ !',
                        text : `${res.message}`,
                        timer : 2000,
                    })
                    $('.iconCus').show()
                    $('.loadCusCon').hide()
                    $('.selectPayee').prop('disablde',false)
                }else{
                    $('.iconCus').show()
                    $('.loadCusCon').hide()
                    $('.selectPayee').prop('disablde',false)
                    await swal.fire({
                        icon: 'success',
                        text : 'เพิ่มข้อมูลผู้รับเงินเรียบร้อย',
                        timer : 2000
                    })
                    $('#section-content').html(res.html);
                    $('#section-Tab').html(res.renderTab);
                    $('.data-modal-search').modal('hide');
                }

            },
            error :async (err) => {
                $('.iconCus').show()
                $('.loadCusCon').hide()
                $('.selectPayee').prop('disablde',false)
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


{{-- ลบ ผู้รับเงิน --}}
<script>
    $('.removePayee').click((evt)=>{
    let id =  $(evt.currentTarget).attr('data-id')
    let urltxt = "{{ route('contract.destroy','ID') }}";
    let url = urltxt.replace('ID',id)
        Swal.fire({
            title: 'ต้องการลบผู้รับเงินออกจากสัญญานี้ หรือไม่?',
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
                    func  : 'removePayee',
                    PactCon_id : sessionStorage.getItem('PactCon_id'),
                    _token : '{{ @csrf_token() }}'
                },
                success : async (res)=>{
                    if(res.FlagCon == 'fail'){
                        swal.fire({
                            icon : 'error',
                            title : 'Success !',
                            text : 'ไม่สามารถลบผู้รับเงินออกจากสัญญาได้',
                            timer : 2000,
                        })
                    } else {
                        await swal.fire({
                                icon : 'success',
                                title : 'Success !',
                                text : 'ลบผู้รับเงินออกจากสัญญาเรียบร้อย',
                                timer : 2000,
                            })

                            await $('.cardCus-'+id).fadeOut(500,()=>{
                                $('.cardCus-'+id).remove()
                                $('.content-card .d-flex').each(function(index){
                                    $(this).find('.index').html(index+1)
                                });
                            })
                            $('#section-content').html(res.html);
                            $('#section-Tab').html(res.renderTab);
                    }
                },
                error : (err)=>{
                    swal.fire({
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
