


{{-- เพิ่มทรัพย์ในสัญญา --}}
<script>
    $('.addAsset').click((evt)=>{
        const idasst = $(evt.currentTarget).attr('idasst');
        $('.addAsset').prop('disabled',true)
        $('.addAsset').hide()
        $('.iconLoading').show()

        $.ajax({
            url : '{{route('contract.store')}}',
            type : 'post',
            data : {
                func : 'addAsset',
                idasst : idasst,
                PactCon_id : $('#PactCon_id').val(),
                DataTag_id : $('#DataTag_id').val(),
                _token : '{{ @csrf_token() }}'
            },
            success :async (res) => {
                    $('.addAsset').prop('disabled',false)
                    $('.addSpin').empty();
                    await swal.fire({
                            icon: 'success',
                            text : 'เพิ่มข้อมูลทรัพย์เรียบร้อย',
                            timer : 2000
                    })
                    $('.modal').modal('hide');
                    $('#section-content').html(res.html);
                    $('#section-Tab').html(res.renderTab);

                },
                error :async (err) => {
                    $('.addAsset').prop('disabled',false)
                    $('.addAsset').show()
                    $('.iconLoading').hide()
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

{{-- ลบ ทรัพย์ --}}
<script>
    $('.removeAsst').click((evt)=>{
       let id =  $(evt.currentTarget).attr('data-id')
       let urltxt = "{{ route('contract.destroy','ID') }}";
       let url = urltxt.replace('ID',id);
       Swal.fire({
            title: 'ต้องการลบทรัพย์ออกจากสัญญานี้ หรือไม่?',
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
                 func  : 'removeAsset',
                 PactCon_id : sessionStorage.getItem('PactCon_id'),
                 _token : '{{ @csrf_token() }}'
             },
             success : (res)=>{
                    swal.fire({
                        icon : 'success',
                        title : 'Success !',
                        text : 'ลบทรัพย์ออกจากสัญญาเรียบร้อย',
                        timer : 2000,
                     })

                     $('.cardAsset-'+id).fadeOut(500,()=>{
                         $('.cardAsset-'+id).remove()
                         $('.content-asset .cardasst').each(function(index){
                            $(this).find('.index').html(index+1)
                         });
                     })
                     if($('.content-asset .cardasst').length == 1){ // เหลือการ์ดเดียว return append data ใหม่
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

<script>

    //$(document).on('click', '.view-dataAssetBtn', function(e) {
    $('.view-dataAssetBtn').unbind("click").bind("click", function(e) {
        e.preventDefault();
        var url = $(this).attr('data-link');
        $('#modal_xl .modal-dialog').empty();
        $(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
        $('#modal_xl .modal-dialog').load(url, function( response, status, xhr ) {
            $(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
            if ( status == "success" ) {
                //var msg = "Sorry but there was an error: ";
                //$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
            }
            if ( status == "error" ) {
                //var msg = "Sorry but there was an error: ";
                //$( "#error" ).html( msg + xhr.status + " " + xhr.statusText );
            }
        });

    });
</script>
