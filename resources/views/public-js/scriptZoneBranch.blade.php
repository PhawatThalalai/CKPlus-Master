<script>
	$(function() {
		$('#zone-input').change(function() {
			let zone = $(this).val();
			$.ajax({
				url: "{{ route('search') }}",
				method: "post",
				data: {
					_token: "{{ @csrf_token() }}",
					page_type: 'constants',
					typeSr: 'selectZones',
					zone: zone,
				},
				success: function(result) {
					Swal.fire({
						icon: 'success',
						text: result.message,
						showConfirmButton: false,
						timer: 1500
					});
				},
				error: function(err) {
					Swal.fire({
						icon: 'error',
						title: `ERROR ` + err.status + ` !!!`,
						text: err.responseJSON.message,
						showConfirmButton: true,
					});
				}
			})
		});

		// zone
		$('.zone_input').change(function(e) {
			e.preventDefault();
			var zone = this.value;

			$(this).attr('disabled', true);
			$('.branch_input').attr('disabled', true);

			$('.addSpinZone').empty();
			$('<span />', {
				class: "spinner-border spinner-border-sm",
				role: "status"
			}).appendTo(".addSpinZone");

			$.ajax({
				url: "{{ route('constants.index') }}",
				method: "get",
				data: {
					_token: "{{ @csrf_token() }}",
					page: 'frontend',
					module: 'select-branch',
					zone: zone
				},
				success: function(result) {
					for (var i = 0, len = result.length; i < len; ++i) {
						var data = result[i];
						$('.branch_input').append($('<option/>').attr("value", data.id).text(data.Name_Branch + ' (' + data.NickName_Branch + ')'));
					}

					$(".toast-success").toast({
						delay: 1500
					}).toast("show");
					$(".toast-success .toast-body .text-body").text('success');
				},
				error: function(err) {
					Swal.fire({
						icon: 'error',
						title: `ERROR ` + err.status + ` !!!`,
						text: err.responseJSON.message,
						showConfirmButton: true,
					});
				},
				complete: function(data) {
					$('.zone_input,.branch_input').attr('disabled', false);
					$('.addSpinZone').html('<i class="bx bxs-map-pin"></i>');
				}
			})
		});
	})
</script>
