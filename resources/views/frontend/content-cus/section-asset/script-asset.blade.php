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
            }else{
                isvalid = true;
            }
        });
        return isvalid;
    }
</script>

{{-- add asset --}}
<script>
	$('#btn_SubmitAsset').click(function() {
		var dataform = document.querySelectorAll('.needs-validation');
		var validate = validateForms(dataform);
		if (validate == true) {
		var funs = 'manage-asset';
		var _token = $('input[name="_token"]').val();
		var data = {};$("#CreateAsset").serializeArray().map(function(x){data[x.name] = x.value;});
		$('#btn_SubmitAsset').prop('disabled', true);
        $('<span />', {
				class : "spinner-border spinner-border-sm",
				role : "status"
		}).appendTo(".addSpin");
		$.ajax({
            url:"{{ route('cus.store') }}",
            method:"post",
            data:{_token:_token,funs:funs,data:data},

            success: async (result) => {
                $('#user-asset').html(result);
                $('#btn_SubmitAsset').prop('disabled', false);
                $('.addSpin').empty()

            await   Swal.fire({
                    icon: 'success',
                    text: 'เพิ่มทรัพย์ค้ำให้ลูกค้าเรียบร้อย',
                    showConfirmButton: false,
                    timer: 1500
                    });
					await $('.modal').modal('hide');

            },
            error : async (err) => {
                $('#btn_SubmitAsset').prop('disabled', false);
                $('.addSpin').empty()

            await Swal.fire({
                    icon: 'error',
                    title  :'ERROR !',
                    text: 'เพิ่มทรัพย์ค้ำให้ลูกค้าไม่สำเร็จ'+err.mess,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
	    })
	}
	});
</script>

{{-- update asset --}}
<script>
	  $('#btn_EditAsset').click(function() {
		if ($("#edit_Asset").valid() == true) {
			var id = $('#id').val();
			var funs = 'manage-asset';
			var _token = $('input[name="_token"]').val();
			var data = {};$("#edit_Asset").serializeArray().map(function(x){data[x.name] = x.value;});

            $('#btn_EditAsset').prop('disabled', true);

			$('.addSpin').empty();
            $('<span />', {
                    class : "spinner-border spinner-border-sm",
                    role : "status"
            }).appendTo(".addSpin");
            
			$.ajax({
                url:'{{ route("cus.update",0) }}',
                method:"put",
                data:{
                    _token:_token,
                    funs:funs,
                    data:data
                },
                success : async (result) => {
                    await Swal.fire({
                        icon: 'success',
                        text: 'อัพเดททรัพย์ค้ำให้ลูกค้าเรียบร้อย !',
                        showConfirmButton: false,
                        timer: 1500
                    });
                    
                    await $('.modal').modal('hide');
                    $('#user-asset').html(result);
                },
                error : async (err)=>{
                    await Swal.fire({
                        icon: 'error',
                        title: 'ERROR !',
                        text : 'อัพเดททรัพย์ค้ำให้ลูกค้าไม่สำเร็จ !',
                        showConfirmButton: false,
                        timer: 1500
                    });
                },
                complete : async (result) => {
                    $('#btn_EditAsset').prop('disabled', false);
					$('.addSpin').html('<i class="fas fa-download"></i>');
                }
			})
		}
      });
</script>


<script>
	$('#SwitchStatus_Asst').change(()=>{
		$('#text-status').empty();
		let SwitchStatus_Asst =  $('#SwitchStatus_Asst');
		if (SwitchStatus_Asst.is(':checked') == true){
			$('#text-status').append('กำลังใช้งาน').addClass('text-success');
			$('#Status_Asset').val('active');
		}
		else{
			$('#text-status').append('ปิดใช้งาน').addClass('text-mute').removeClass('text-success');
			$('#Status_Asset').val('inactive');
		}
	})
</script>
