
{{-- script validate form --}}
<script>
    function validateForms(dataform) {
        var isvalid = false;
        Array.prototype.slice.call(dataform).forEach(function(form) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();

                form.classList.add('was-validated');

                isvalid = false;
            }else{
                isvalid = true;
            }
        });
        return isvalid;
    }
</script>

{{-- กลับไปหน้าค้นหา --}}
  <script>
    $('.backGuaran').click(()=>{
        $('.main-modal').toggle(500);
		$('.guaran-modal').toggle(500);
    })
      $('.card').click((e)=>{
        let target = $(e.currentTarget);
      })

  </script>

{{-- บันทึกผู้ค้ำ --}}
  <script>
    $('#submitGuarantorBtn').click(()=>{

        var dataform = document.querySelectorAll('.needs-validation');
        var validate = validateForms(dataform);
            if (validate == true) {
                $('#submitGuarantorBtn').prop('disabled',true)
                var data = $('#editGuarantor').serialize()
                var PactCon_id = $('#PactCon_id').val();
                var DataTag_id = $('#DataTag_id').val();
                var concat = '&PactCon_id='+PactCon_id+'&DataTag_id='+DataTag_id
                $.ajax({
                    url : '{{route('contract.store')}}',
                    type : 'POST',
                    data : data.concat(concat),
                    success : async (res)=>{
                        $('#submitGuarantorBtn').prop('disabled',false)
                        await swal.fire({
                            icon: 'success',
                            text : 'เพิ่มข้อมูลผู้ค้ำในสัญญาเรียบร้อย',
                            timer : 2000
                        })
                        $('#section-content').html(res.html)
                        $('#section-Tab').html(res.renderTab);
                        $('.data-modal-search').modal('hide');
                    },
                    error : async (err)=>{
                        $('#submitGuarantorBtn').prop('disabled',false)
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


{{-- อัพเดทผู้ค้ำ --}}
  <script>
    $('#UpdateGuarantorBtn').click(()=>{
        var dataform = document.querySelectorAll('.needs-validation');
        var validate = validateForms(dataform);
        if (validate == true) {
            $('#UpdateGuarantorBtn').prop('disabled',true)
            var data = $('#editGuarantor').serialize()
            var PactCon_id = $('#PactCon_id').val();
            var DataTag_id = $('#DataTag_id').val();
            var concat = '&PactCon_id='+PactCon_id+'&DataTag_id='+DataTag_id
            $.ajax({
                url : '{{route('contract.update',0)}}',
                type : 'PUT',
                data : data.concat(concat),
                success : async (res)=>{
                    $('#UpdateGuarantorBtn').prop('disabled',false)
                    await swal.fire({
                        icon: 'success',
                        text : 'อัพเดทข้อมูลผู้ค้ำเรียบร้อย',
                        timer : 2000
                    })
                    $('#section-content').html(res.html)
                    $('#section-Tab').html(res.renderTab);
                    $('.modal').modal('hide');
                },
                error : async (err)=>{
                    $('#UpdateGuarantorBtn').prop('disabled',false)
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


{{-- ลบ ผู้ค้ำ --}}
<script>
    $('.removeGuaran').click((evt)=>{
       let idcard = $(evt.currentTarget).attr('data-id')
       let urltxt = "{{ route('contract.destroy','ID') }}";
       let url = urltxt.replace('ID',idcard)

        Swal.fire({
                title: 'ต้องการลบผู้ค้ำประกันออกจากสัญญานี้ หรือไม่?',
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
                        funs  : 'removeGuaran',
                        PactCon_id : sessionStorage.getItem('PactCon_id'),
                        _token : '{{ @csrf_token() }}'
                    },
                    success : (res)=>{
                            swal.fire({
                                icon : 'success',
                                title : 'Success !',
                                text : 'ลบผู้ค้ำประกันออกจากสัญญาเรียบร้อย',
                                timer : 2000,
                            })
                            $('.cardCus-'+idcard).fadeOut(500,()=>{
                                $('.cardCus-'+idcard).remove()
                                $('.content-guarantor .d-flex').each(function(index){
                                    $(this).find('.index').html(index+1)
                                });
                            })
                            if($('.content-guarantor .d-flex').length == 1){ // เหลือการ์ดเดียว return append data ใหม่
                                $('#section-content').html(res.html)
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

