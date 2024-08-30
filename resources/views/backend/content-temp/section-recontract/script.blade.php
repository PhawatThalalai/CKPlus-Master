<script>
    $('.btn-recontracts').click((e)=>{
        $('.showIcon').toggle()
        let id = $(e.currentTarget).attr('PactCon_id')
        let route = "{{ route('account.show',':ID') }}"
        let url = route.replace(':ID',id)
        $.ajax({
            url : url,
            type : 'GET',
            data : {
                 page : 'reContract',
                _token : '{{ @CSRF_TOKEN() }}'
            },
            success : (res)=>{
                 $('.showIcon').toggle()
                 $('.modal').modal('hide')
                console.log(res);
                $('#form-recontracts').html(res.html)
                swal.fire({
                    icon : 'success',
                    title : 'สำเร็จ !',
                    text : 'เรียกข้อมูลสัญญาเรียบร้อย',
                    timer : 2000
                })
            },
            error : (err)=>{
                $('.showIcon').toggle()
                swal.fire({
                    icon : 'error',
                    title : 'ไม่สำเร็จ !',
                    text : 'เกิดข้อผิดพลาดในการเรียกข้อมูลสัญญาโปรดลองอีกครั้ง',
                    timer : 2000
                })
            }
        })
    })
</script>


<script>
    $('.btn-getRecontract').click((e)=>{
        $('.showIcon').toggle()
        let id = $(e.currentTarget).attr('PactCon_id')
        let route = "{{ route('account.show',':ID') }}"
        let url = route.replace(':ID',id)
        $.ajax({
            url : url,
            type : 'GET',
            data : {
                 page : 'getRecontractFromSearch',
                _token : '{{ @CSRF_TOKEN() }}'
            },
            success : (res)=>{
                 $('.showIcon').toggle()
                 $('.modal').modal('hide')
                console.log(res);
                $('#contentForm').html(res.html)
                swal.fire({
                    icon : 'success',
                    title : 'สำเร็จ !',
                    text : 'เรียกข้อมูลสัญญาเรียบร้อย',
                    timer : 2000
                })
            },
            error : (err)=>{
                $('.showIcon').toggle()
                swal.fire({
                    icon : 'error',
                    title : 'ไม่สำเร็จ !',
                    text : 'เกิดข้อผิดพลาดในการเรียกข้อมูลสัญญาโปรดลองอีกครั้ง',
                    timer : 2000
                })
            }
        })
    })
</script>
