<div class="card">
	<div class="modal-content">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title d-flex align-items-center"><i class="bx bx-user-plus me-2 font-size-22 text-info"></i> Create User</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<form id="create-user" class="needs-validation" action="#" method="post" enctype="multipart/form-data" novalidate>
					@csrf
					<div class="row">
						<div class="mb-2 col-6">
							<label for="name" class="form-label">Name</label>
							<input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Name" required autocomplete="off">
						</div>
						<div class="mb-2 col-6">
							<label for="name" class="form-label">Username</label>
							<input type="text" class="form-control" id="username" name="username" placeholder="Enter Your Username" required autocomplete="off">
						</div>
					</div>
					<div class="row">
						<div class="mb-2 col-6">
							<label for="password" class="form-label">Password</label>
							<div class="input-group auth-pass-inputgroup">
								<input type="password" class="form-control" name="password" id="password" required autocomplete="new-password" autocomplete="off">
							</div>
						</div>
						<div class="mb-2 col-6">
							<label for="password_confirmation" class="form-label">Confirm Password</label>
							<div class="input-group auth-pass-inputgroup">
								<input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required autocomplete="new-password">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="mb-2 col-6">
							<label for="email" class="form-label">E-mail</label>
							<input type="email" class="form-control" id="email" name="email" required autocomplete="off">
						</div>
						<div class="mb-2 col-6">
							<label for="password_Team" class="form-label">Password team</label>
							<div class="input-group auth-pass-inputgroup">
								<input type="password" class="form-control" name="password_Team" id="password_Team" required autocomplete="new-password-Team" autocomplete="off">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="mb-2 col-12">
							<label for="phone" class="form-label">Phone</label>
							<input type="text" class="form-control" id="phone" name="phone" autocomplete="off">
						</div>
					</div>
					<div class="row">
						<div class="mb-2 col-6">
							<label for="zone" class="form-label">Zone</label>
							<select class="form-select" name="zone" id="zone" required>
								<option value="" selected>select to zones...</option>
								@foreach ($zones as $key => $zone)
									<option value="{{ $zone->Zone_Code }}"> {{ $zone->Zone_Code }} - {{ $zone->Zone_Name }}</option>
								@endforeach
							</select>
						</div>
						<div class="mb-2 col-6">
							<label for="branch" class="form-label">Branch</label>
							<select class="form-select" name="branch" id="branch" required>
								<option value="" selected>select to branch...</option>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col mb-2">
							<label for="roles" class="form-label">Role (Ctrl + click To multiple select)</label>
							<select class="form-select" name="roles[]" multiple="multiple" id="create-roles" required>
								@foreach ($roles as $key => $role)
									<option value="{{ $role->id }}">{{ $key + 1 }} - {{ $role->name }} ({{ $role->name_th }})</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="text-center">
						<button type="button" id="btn_createUser" class="btn btn-primary btn-sm waves-effect waves-light hover-up">Create User</button>
						<button type="button" class="btn btn-secondary btn-sm waves-effect waves-light hover-up" data-bs-dismiss="modal" aria-label="Close">Discard</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$("#btn_createUser").click(function() {
			var dataform = document.querySelectorAll('#create-user');
			var validate = validateForms(dataform);

			if (validate == true) {
				let data = {};
				data['roles'] = $("#create-roles").val();
				data['roles'] = Array.isArray(data['roles']) ? data['roles'] : [data['roles']];
				$("#create-user").serializeArray().map(function(x) {
					if (x.name !== 'roles[]') {
						data[x.name] = x.value;
					}
				});

				// Check passwords and show error message if needed
				if (!checkPassword(data['password'], data['password_confirmation'])) {
					return; // Exit the function if passwords don't match or are too short
				}

				$(".loading-overlay").fadeIn().attr('style', ''); //** แสดงตัวโหลด **
				$.ajax({
					url: "{{ route('permission.store') }}",
					method: 'post',
					data: {
						_token: "{{ @csrf_token() }}",
						page: 'users-create',
						data: data
					},
					success: function(result) {
						$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
						swal.fire({
							icon: 'success',
							text: 'บันทึกข้อมูลสำเร็จ',
							timer: 1500,
						})

						$('.content-user').html(result.view_data).slideDown('slow');
						$('#modal_lg').modal('hide');
					},
					error: function(err) {
						$(".loading-overlay").fadeOut().attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
						Swal.fire({
							icon: 'error',
							title: `ERROR ` + err.status + ` !!!`,
							text: err.responseJSON.message,
							showConfirmButton: true,
						});
						$('#modal_lg').modal('hide');
					}
				});
			} else {
				swal.fire({
					icon: 'warning',
					title: 'ข้อมูลไม่ครบ !',
					text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
					timer: 3000,
					showConfirmButton: true,
				})
			}
		});
		$("#zone").change(function() {
			var zone = $(this).val();

			$('#btn_createUser').attr('disabled', true);
			$.ajax({
				url: "{{ route('permission.create') }}",
				method: 'get',
				data: {
					zone: zone,
					page: 'getBranch',
					fun: 'ignore'
				},
				success: function(result) {
					let branchSelect = $("#branch");

					branchSelect.html('<option value="" selected>select to branch...</option>');
					$.each(result.branchs, function(key, value) {
						branchSelect.append('<option value="' + value.id + '">' + value.Name_Branch + ' (' + value.NickName_Branch + ') ' + '</option>');
					});
				},
				error: function(err) {
					Swal.fire({
						icon: 'error',
						title: `ERROR ` + err.status + ` !!!`,
						text: err.responseJSON.message,
						showConfirmButton: true,
					});
				},
				complete: function() {
					$('#btn_createUser').attr('disabled', false);
				}
			});
		});

		$('#phone').inputmask({
			"mask": "(999) 999-9999"
		}); // รูปแบบของหมายเลขโทรศัพท์

		function checkPassword(password, confirmPassword) {
			if (password.length >= 6 && confirmPassword.length >= 6) {
				if (password === confirmPassword) {
					console.log('Password matched.');
					return true; // Passwords match
				} else {
					swal.fire({
						icon: 'error',
						title: 'รหัสผ่านไม่ตรงกัน',
						text: 'กรุณากรอกรหัสผ่านให้ตรงกัน',
						timer: 3000,
						showConfirmButton: true,
					})
				}
			} else {
				swal.fire({
					icon: 'error',
					title: 'รหัสผ่านสั้นเกินไป',
					text: 'กรุณากรอกรหัสผ่านที่มีความยาวมากกว่า 6 ตัวอักษร',
					timer: 3000,
					showConfirmButton: true,
				})
			}

			return false; // Passwords don't match or are too short
		}
	});
</script>
