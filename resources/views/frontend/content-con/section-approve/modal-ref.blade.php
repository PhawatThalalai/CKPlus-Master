
<div class="modal-content">
    <div class="modal-header">
        <h5 class="text-primary fw-semibold modal-title"> <i class="bx bx-receipt"></i> บุคคลอ้างอิง ( Reference )</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
	<div class="modal-body">
        <div class="row">
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 text-center ">
                <img src="{{ URL::asset('\assets\images\undraw\cus-ref.svg') }}" alt="" style="width: 70%;">
            </div>
            <div class="col-xl-6 col-lg col-md-6 col-sm-12">
                <form id="formRef">
                    {{-- hidden value --}}
                    <input type="hidden" name="funs" value="addRef">
                    <input type="hidden" name="PactCon_id" value="{{ $data->id }}">
                    <input type="hidden" name="_token" value="{{ @csrf_token() }}">

                    <div class="mb-3">
                    <label for="nameRef" class="form-label fw-semibold">ชื่อ - สกุล บุคคลอ้างอิง</label>
                    <input type="text" class="form-control" id="Cus_Ref" name="Cus_Ref" value="{{@$data->Cus_Ref}}" placeholder="ชื่อ - สกุลบุคคลอ้างอิง" required>
                    </div>
                    <div class="mb-3">
                    <label for="phoneRef" class="form-label fw-semibold">เบอร์ติดต่อ</label>
                    <input type="tel" class="form-control" id="PhoneCus_Ref" name="PhoneCus_Ref" value="{{@$data->PhoneCus_Ref}}" placeholder="เบอร์ติดต่อ" required>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" id="btn-saveRef" class="btn btn-primary btn-sm waves-effect waves-light hover-up"> <span class="addSpin"></span> บันทึก</button>
        <button type="button" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">ปิด</button>
    </div>
</div>



{{-- validate js --}}
<script>
	function validateForms(dataform) {
		var isvalid = false;
		Array.prototype.slice.call(dataform).forEach(function(form) {
			if (!form.checkValidity()) {
				event.preventDefault();
				event.stopPropagation();

				form.classList.add('was-validated');

				isvalid = false;
			} else {
				isvalid = true;
			}
		});
		return isvalid;
	}
</script>

{{-- เพิ่มผู้อ้างอิง --}}
<script>
    $('#btn-saveRef').click(()=>{
        let dataform = $('#formRef');
        let validate = validateForms(dataform);
        if (validate == true) {
            $('#btn-saveRef').prop('disabled', true)
            $('<span />', {
                class: "spinner-border spinner-border-sm",
                role: "status"
            }).appendTo(".addSpin");

            let idCon = sessionStorage.getItem('PactCon_id');
            let url = "{{ route('contract.update','ID') }}"
            url = url.replace('ID',idCon)
            $.ajax({
                url : url,
                type : 'PUT',
                data : $('#formRef').serialize(),
                success :async (res)=>{
                    $('.addSpin').empty()
                    $('#btn-saveRef').prop('disabled', false)
                    $('.RefText').html(res.RefText)
                        await swal.fire({
                            icon : 'success',
                            title : 'Success!',
                            text : 'เพิ่มบุคคลอ้างอิงในสัญญาเรียบร้อย',
                            timer : 3000,
                        })
                    $('#section-cardCon').html(res.htmlHeaderCard)
                    $('#cusref').html(res.html)
                    $('.modal').modal('hide');

                },
                error : async (err)=>{
                    $('.addSpin').empty()
                    $('#btn-saveRef').prop('disabled', false)

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
