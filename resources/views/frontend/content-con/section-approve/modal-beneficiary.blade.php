
<div class="modal-content">
    <div class="modal-header">
        <h5 class="text-primary fw-semibold modal-title"> <i class="bx bx-receipt"></i> ผู้รับผลประโยชน์ ( PA )</h5>
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
                    <input type="hidden" name="funs" value="addBeneficiary">
                    <input type="hidden" name="PactCon_id" value="{{ $data->id }}">
                    <input type="hidden" name="_token" value="{{ @csrf_token() }}">

                    <div class="mb-3">
                        <label for="nameRef" class="form-label fw-semibold">ชื่อ - สกุล ผู้รับผลประโยชน์</label>
                        <input type="text" class="form-control" id="Beneficiary_PA" name="Beneficiary_PA" value="{{@$data->Beneficiary_PA}}" placeholder="ชื่อ - สกุลผู้รับผลประโยชน์" required>
                    </div>
                    {{-- <div class="mb-3">
                        <label for="phoneRef" class="form-label fw-semibold">เบอร์ติดต่อ</label>
                        <input type="tel" class="form-control" id="PhoneCus_Ref" name="PhoneCus_Ref" value="{{@$data->PhoneCus_Ref}}" placeholder="เบอร์ติดต่อ" required>
                    </div> --}}
                    <div class="mb-3">
                        <label for="phoneRef" class="form-label fw-semibold">ความสัมพันธ์</label>
                        <select class="form-select" name="Relations_PA" id="Relations_PA" aria-label="Default select example">
                            <option value="" selected>-- เลือกความสัมพันธ์ --</option>
                            @foreach ($TBRealtion as $item){
                                <option value="{{ $item->name }}" {{ $item->name == @$data->Relations_PA ? 'selected' : '' }}>{{ $item->name }}</option>
                            }
                            @endforeach
                            <option value="otherRelation" id="otherRelation"  {{@$data->Beneficiary_PA && !in_array(@$data->Relations_PA , array_column(@$TBRealtion->toArray(),"name")) ? 'selected' : '' }}>อื่นๆ</option>
                          </select>
                    </div>
                    <div class="mb-3" id="contentOther" style="{{@$data->Beneficiary_PA && !in_array(@$data->Relations_PA , array_column(@$TBRealtion->toArray(),"name")) ? '' : 'display:none;' }}">
                        <label for="InputRelation" class="form-label fw-semibold">ระบุความสัมพันธ์</label>
                        <input type="text" class="form-control" id="InputRelation" name="InputRelation" value="{{@$data->Relations_PA}}" placeholder="ระบุความสัมพันธ์">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" id="btn-saveBeneficiary" class="btn btn-primary btn-sm waves-effect waves-light hover-up"> <span class="addSpin"></span> บันทึก</button>
        <button type="button" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">ปิด</button>
    </div>
</div>


<script>
    $('#Relations_PA').on("change",()=>{
        let Relations_PA = $('#Relations_PA').val()

        if(Relations_PA == 'otherRelation'){
            $('#contentOther').show()
            $('#InputRelation').prop('required',true).val('')
        }else{
            $('#contentOther').hide()
            $('#InputRelation').prop('required',false)


        }
    })
</script>


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
    $('#btn-saveBeneficiary').click(()=>{
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
                    $('#cusBeneficiary').html(res.html)
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
