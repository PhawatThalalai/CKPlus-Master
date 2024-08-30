<script>
	$(function() {
		lockinput();
	})

	$('.Type_Carreer').change(() => {
		Unlockinput();
	})
</script>

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


<script>
	lockinput = () => {
		$('#CreateCareer input[type=text]').attr('disabled', true).css('cursor', 'no-drop');
		$('#CreateCareer select').attr('disabled', true).css('cursor', 'no-drop');
		$('#btn_SubmitCareer').attr('disabled', true);
	}
	Unlockinput = () => {
		$('#CreateCareer input[type=text]').attr('disabled', false).css('cursor', 'default');
		$('#CreateCareer select').attr('disabled', false).css('cursor', 'auto');
		$('#btn_SubmitCareer').attr('disabled', false);
	}
</script>





<script>
	$('#SwitchStatus_Cus').change(() => {
		$('#text-status').empty();
		let SwitchStatus_Cus = $('#SwitchStatus_Cus');
		if (SwitchStatus_Cus.is(':checked') == true) {
			$('#text-status').append('กำลังใช้งาน').addClass('text-success');
			$('#Status_Cus').val('active');
		} else {
			$('#text-status').append('ปิดใช้งาน').addClass('text-mute').removeClass('text-success');
			$('#Status_Cus').val('inactive');
		}
	})
</script>

{{-- add Carreer --}}
<script>
	$('#btn_SubmitCareer').click(function() {
		var dataform = document.querySelectorAll('.needs-validation');
		var validate = validateForms(dataform);

		if (validate == true) {
			let funs = 'manage-carreer';
			var _token = $('input[name="_token"]').val();
			var data = {};
			$("#CreateCareer").serializeArray().map(function(x) {
				data[x.name] = x.value;
			});
			$('#btn_SubmitCareer').prop('disabled', true);
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
                    $('#btn_SubmitCareer').prop('disabled', false);
			        $('.addSpin').empty();
					await Swal.fire({
						icon: 'success',
                        title : 'Success !',
						text: 'เพิ่มอาชีพให้ลูกค้าเรียบร้อย',
						showConfirmButton: false,
						timer: 1500
					});

					await $('.modal').modal('hide');
					$('#user-career').html(result);


				},
                error : async (err)=>{

                    $('#btn_SubmitCareer').prop('disabled', false);
			        $('.addSpin').empty();

                    await Swal.fire({
						icon: 'error',
                        title : 'ERROR !',
						text: 'เพิ่มอาชีพให้ลูกค้าไม่สำเร็จ !',
						showConfirmButton: false,
						timer: 1500
					});

                }
			})
		}
	});
</script>


{{-- update carreer --}}
<script>
	$('#btn_EditCareer').click(function() {
		if ($("#edit_Careers").valid() == true) {
			var id = $('#id').val();
			var funs = 'manage-carreer';
			var _token = $('input[name="_token"]').val();
			var data = {};
			$("#edit_Careers").serializeArray().map(function(x) {
				data[x.name] = x.value;
			});
            $('#btn_EditCareer').prop('disabled', true);

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
					_token: '{{ @CSRF_TOKEN() }}',
					funs: funs,
					data: data
				},

				success : async (result) => {
                    $('.addSpin').empty();

					await Swal.fire({
						icon: 'success',
                        title : 'Success !',
						text: 'อัพเดทอาชีพให้ลูกค้าเรียบร้อย',
						showConfirmButton: false,
						timer: 1500
					});
					
					await $('.modal').modal('hide');
					$('#user-career').html(result);

				},
                error : async (err)=>{
                    $('.addSpin').empty();

                    await Swal.fire({
                        icon: 'error',
                        title : 'ERROR !',
                        text: 'เพิ่มอาชีพให้ลูกค้าไม่สำเร็จ !',
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
				compelete: async (result) => {
					$('#btn_EditCareer').prop('disabled', false);
					$('.addSpin').html('<i class="fas fa-download"></i>');
				}
			})
		}
	});
</script>