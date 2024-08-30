<script>
	$(function() {
		// $('#CreateAddress input[type=radio]').attr('disabled', true).css('cursor', 'no-drop');
		$('#Type_Adds').addClass('border-danger border border-2')
		lockinput();

	})


    $('#Registration_number').on("input",()=>{
        let Registration_number = $('#Registration_number').val().replace(/_/g, '')
        let getAdds = $('#Type_Adds').val()


        if(Registration_number.length > 0 && Registration_number.length == 11){
            $('#alertRegis').html('<i class="bx bxs-check-circle"></i> ข้อมูลถูกต้อง').addClass('text-success').removeClass('text-danger')
            $('#Registration_number').removeClass('border border-danger').addClass('border border-success')
        }
        else if(Registration_number.length > 0 && Registration_number.length < 11){
            $('#alertRegis').html('<i class="bx bxs-x-circle"></i> ต้องมี 11 หลัก !').addClass('text-danger').removeClass('text-success')
            $('#Registration_number').removeClass('border border-success').addClass('border border-danger')
            return 0
        }
        else{
            $('#alertRegis').html('')
            $('#Registration_number').removeClass('border border-danger')
            $('#Registration_number').removeClass('border border-success')
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

{{-- add address --}}
<script>
	$('#btn_SubmitAdds').click(function() {

        let Registration_number = $('#Registration_number').val().replace(/_/g, '')
        let getAdds = $('.getAdds:checked').val()

        if(Registration_number.length > 0 && Registration_number.length < 11){
            $('#alertRegis').html('<i class="bx bxs-x-circle"></i> ต้องมี 11 หลัก !').addClass('text-danger').removeClass('text-success')
            $('#Registration_number').removeClass('border border-success').addClass('border border-danger')
            return 0
        }

        if(getAdds == 'ADR-0003' && Registration_number.length < 11){
            $('#alertRegis').html('<i class="bx bxs-x-circle"></i> จำเป็นต้องระบุ !').addClass('text-danger').removeClass('text-success')
            $('#Registration_number').removeClass('border border-success').addClass('border border-danger')
            return 0
        }

		let dataform = $('#CreateAddress');
		let validate = validateForms(dataform);

		if (validate == true) {
			let funs = 'manage-adds';
			let _token = $('input[name="_token"]').val();
			let data = {};
			$("#CreateAddress").serializeArray().map(function(x) {
				data[x.name] = x.value;
			});

			$('#btn_SubmitAdds').prop('disabled', true);
			$('<span />', {
				class: "spinner-border spinner-border-sm",
				role: "status"
			}).appendTo(".addSpin");

			$.ajax({
				url: "{{ route('cus.store') }}",
				method: "post",
				data: {
					_token: _token,
					funs: funs,
					data: data
				},
				success : async (result) => {
                    $('.addSpin').empty();
					$('#user-address').html(result);
					$('#btn_SubmitAdds').prop('disabled', false);

					await Swal.fire({
						icon: 'success',
                        title : 'Success !',
						text: 'เพิ่มที่อยู่ให้ลูกค้าเรียบร้อย',
						showConfirmButton: false,
						timer: 1500
					});

					await $('.modal').modal('hide');
				},
				error: async (err)=> {
                    $('.addSpin').empty();
                    $('#btn_SubmitAdds').prop('disabled', false);
					Swal.fire({
						icon: 'error',
                        title : 'ERROR !',
						text: 'เพิ่มที่อยู่ไม่สำเร็จ กรุณาลองใหม่อีกครั้ง !',
						showConfirmButton: false,
						timer: 1500
					});
				}
			})
		}
	});
</script>

{{-- edit address --}}
<script>
	$('#btn_EditAdds').click(function() {

        let getAdds = $('#Type_Adds').val()
        let Registration_number = $('#Registration_number').val().replace(/_/g, '')

        if(Registration_number.length > 0 && Registration_number.length < 11){
            $('#alertRegis').html('<i class="bx bxs-x-circle"></i> ต้องมี 11 หลัก !').addClass('text-danger').removeClass('text-success')
            $('#Registration_number').removeClass('border border-success').addClass('border border-danger')
            return 0
        }

        if(getAdds == 'ADR-0003' && Registration_number.length < 11){
            $('#alertRegis').html('<i class="bx bxs-x-circle"></i> จำเป็นต้องระบุ !').addClass('text-danger').removeClass('text-success')
            $('#Registration_number').removeClass('border border-success').addClass('border border-danger')
            return 0
        }


		let dataform = $('#edit_Address');
		let validate = validateForms(dataform);
		if (validate == true) {
			var id = $('#id').val();
			var funs = 'manage-adds';
			var _token = $('input[name="_token"]').val();
			var data = {};
			$("#edit_Address").serializeArray().map(function(x) {
				data[x.name] = x.value;
			});

			$('.addSpin').empty();
			$('<span />', {
				class: "spinner-border spinner-border-sm",
				role: "status"
			}).appendTo(".addSpin");

			$.ajax({
				url: '{{ route('cus.update', 0) }}',
				method: "put",
				// dataType : 'json',
				data: {
					_token: _token,
					funs: funs,
					data: data
				},

				success : async (result) => {
					$('#user-address').html(result);

					await Swal.fire({
						icon: 'success',
                        title : 'Success !',
						text: 'อัพเดทที่อยู่ให้ลูกค้าเรียบร้อย',
						showConfirmButton: false,
						timer: 1500
					});

					$('#DataAdds').html(result);
                    // await $('#modal_xl_2').modal('hide');
					await $('.modal').modal('hide');
				},
                error: async (err)=> {
                    $('#btn_SubmitAdds').prop('disabled', false);

					Swal.fire({
						icon: 'error',
                        title : 'ERROR !',
						text: 'เพิ่มที่อยู่ไม่สำเร็จ กรุณาลองใหม่อีกครั้ง !',
						showConfirmButton: false,
						timer: 1500
					});
				},
				complete: (result) => {
					$('#btn_EditAdds').prop('disabled', false);
					$('.addSpin').html('<i class="fas fa-download"></i>');
				}
			})
		}
	});
</script>

{{-- event app --}}
<script>
	$('.Type_Adds').change(() => {
		Unlockinput();
	})
</script>

<script>

	lockinput = () => {
		$('#CreateAddress input[type=text]').attr('disabled', true).css('cursor', 'no-drop');
		$('#CreateAddress select').attr('disabled', true).css('cursor', 'no-drop');
		$('#Type_Adds').attr('disabled', false).css('cursor', 'default');
		$('#btn_SubmitAdds').attr('disabled', true);
        // $('.btn-share').hide()
	}
	Unlockinput = () => {
		$('#CreateAddress input[type=text]').attr('disabled', false).css('cursor', 'default');
		$('#btn_SubmitAdds').attr('disabled', false);
		$('#CreateAddress select').attr('disabled', false).css('cursor', 'auto');
		$('#Type_Adds').attr('disabled', false).css('cursor', 'auto');
        $('.btn-share').show()
	}

</script>


<script>
	$('#SwitchStatus_Adds').change(() => {
		$('#text-status').empty();
		let SwitchStatus_Adds = $('#SwitchStatus_Adds');
		if (SwitchStatus_Adds.is(':checked') == true) {
			$('#text-status').append('กำลังใช้งาน').addClass('text-success');
			$('#Status_Adds').val('active');
		} else {
			$('#text-status').append('ปิดใช้งาน').addClass('text-mute').removeClass('text-success');
			$('#Status_Adds').val('inactive');
			lockinput();
		}
	})
</script>

<script>
    getaddress = (flag,idCus,typeAddress) => {
        $('#loadingAdds').toggle()
        $.ajax({
            url : '{{ route('cus.SearchData') }}',
            type : 'POST',
            data : {
                flag : flag,
                idCus : idCus,
                typeAddress : typeAddress,
                type : 'searchAdds',
                _token : '{{ @csrf_token() }}'
            },
            success : (res)=>{
            $('#loadingAdds').toggle()
                $('.content-view').html(res.html)
            },
            error : (err)=>{

            }
        })
    }
</script>

