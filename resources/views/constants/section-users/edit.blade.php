<div class="modal-content">
	<form id="edit_dataUser" class="needs-validation" action="#" novalidate>
		@csrf
		<div class="modal-body">
			<div class="card">
				<h5 class="card-header bg-transparent border-bottom text-uppercase"><i class="mdi mdi-account-edit me-2 font-size-22 text-warning"></i>Account & Profile</h5>
				<div class="card-body">
					<div class="row mb-1">
						<label for="name-input" class="col-sm-3 col-form-label fw-semibold">Name</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="name" id="name" value="{{ @$user->name }}" placeholder="Enter Your Name" required autocomplete="off">
						</div>
					</div>
					<div class="row mb-1">
						<label for="username-input" class="col-sm-3 col-form-label fw-semibold">Username</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="username" id="username" value="{{ @$user->username }}" placeholder="Enter Your Username" required autocomplete="off">
						</div>
					</div>
					<div class="row mb-1">
						<label for="password-input" class="col-sm-3 col-form-label fw-semibold">Password</label>
						<div class="col-sm-9">
							<div class="input-group auth-pass-inputgroup">
								<input type="password" class="form-control" name="password" id="password" value="{{ @$user->password_token }}" required autocomplete="current-password">
								<button class="btn btn-light " type="button" id="password-addon"><i class="mdi mdi-eye-outline"></i></button>
							</div>
						</div>
					</div>
					<div class="row mb-1">
						<label for="email-input" class="col-sm-3 col-form-label fw-semibold">Email (or teams)</label>
						<div class="col-sm-9">
							<input type="email" class="form-control" name="email" id="email" value="{{ @$user->email }}" placeholder="Enter Your Email ID" required autocomplete="off">
						</div>
					</div>
					<div class="row mb-1">
						<label for="password_Team" class="col-sm-3 col-form-label fw-semibold">Password teams</label>
						<div class="col-sm-9">
							<div class="input-group auth-pass-inputgroup">
								<input type="password" class="form-control" name="password_Team" id="password_Team" value="{{ base64_decode(@$user->password_teams) }}" required autocomplete="team-password">
								<button class="btn btn-light " type="button" id="passwordteams-addon"><i class="mdi mdi-eye-outline"></i></button>
							</div>
						</div>
					</div>
					<div class="row mb-1">
						<label for="phone-input" class="col-sm-3 col-form-label fw-semibold">Phone</label>
						<div class="col-sm-9">
							<input type="text" class="form-control" name="phone" id="phone" value="{{ @$user->phone }}" placeholder="Enter Your phone" autocomplete="off">
						</div>
					</div>
					<div class="row mb-1">
						<label for="zone" class="col-sm-3 col-form-label fw-semibold">Zone</label>
						<div class="col-sm-9">
							<select name="zone" id="zone" class="form-select" required placeholder="Enter Your Zone">
								<option selected>zone...</option>
								@foreach (@$zones as $zone)
									<option value="{{ $zone->Zone_Code }}" {{ $zone->Zone_Code == @$user->zone ? 'selected' : '' }}>{{ $zone->Zone_Code }} - {{ $zone->Zone_Name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="row mb-1">
						<label for="branch" class="col-sm-3 col-form-label fw-semibold">Branch</label>
						<div class="col-sm-9">
							<select name="branch" id="branch" class="form-select" required placeholder="Enter Your branch">
								<option selected="">branch...</option>
								@foreach (@$branchs as $branch)
									<option value="{{ $branch->id }}" {{ $branch->id == @$user->branch ? 'selected' : '' }}>{{ $branch->Name_Branch }} ({{ $branch->NickName_Branch }})</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="row mb-1">
						<label for="roles" class="col-sm-3 col-form-label fw-semibold">Role
							<i class="bx bx-info-circle bx-xs" data-bs-toggle="tooltip" data-bs-placement="top" title="(Ctrl + click To multiple select)"></i>
						</label>
						<div class="col-sm-9">
							<select class="form-select" name="roles[]" multiple="multiple" id="edit-roles">
								@foreach ($roles as $key => $role)
									<option value="{{ $role->id }}" {{ $userRoles->contains($role->name) ? 'selected' : '' }}>{{ $key + 1 }} - {{ $role->name_en }} ({{ $role->name_th }})</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-warning btn-sm waves-effect waves-light hover-up btn_editUser" data-id="{{ @$user->id }}">
				<span class="addSpin"><i class="fas fa-download"></i></span> update
			</button>
			<button type="button" class="btn btn-secondary btn-sm waves-effect hover-up close-editUser" data-bs-dismiss="modal">
				<i class="mdi mdi-close-circle-outline"></i> close
			</button>
		</div>
	</form>
</div>

@include('public-js.scriptZoneBranch')
<script>
	$(document).ready(function() {
		$('.btn_editUser').click(function() {
			let id = $(this).data('id');
			var dataform = document.querySelectorAll('#edit_dataUser');
			var validate = validateForms(dataform);

			if (validate == true) {
				let data = {};
				data['roles'] = $("#edit-roles").val();
				data['roles'] = Array.isArray(data['roles']) ? data['roles'] : [data['roles']];
				$("#edit_dataUser").serializeArray().map(function(x) {
					if (x.name !== 'roles[]') {
						data[x.name] = x.value;
					}
				});

				$('.btn_editUser,.close-editUser').prop('disabled', true);
				$('.addSpin').empty();
				$('<span />', {
					class: "spinner-border spinner-border-sm",
					role: "status"
				}).appendTo(".addSpin");

				let link = "{{ route('permission.update', 'id') }}";
				let url = link.replace('id', id);

				$.ajax({
					url: url,
					method: "PUT",
					data: {
						_token: "{{ @csrf_token() }}",
						page: 'users-edit',
						data: data,
					},
					success: function(result) {
						$('.content-user').html(result.view_data).slideDown('slow');
						Swal.fire({
							icon: 'success',
							text: result.message,
							showConfirmButton: false,
							timer: 1500
						});

						$('#modal_lg').modal('hide');
					},
					error: function(err) {
						Swal.fire({
							icon: 'error',
							title: `ERROR ` + err.status + ` !!!`,
							text: err.responseJSON.message,
							showConfirmButton: true,
						});

						$('#modal_lg').modal('hide');
					}
				})
			}
		});
		$("#zone").change(function() {
			var zone = $(this).val();

			$('#btn_editUser').attr('disabled', true);
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
		$('#password-addon').click(function() {
			var passwordInput = $('#password');
			if (passwordInput.attr('type') === 'password') {
				passwordInput.attr('type', 'text');
			} else {
				passwordInput.attr('type', 'password');
			}
		});
		$('#passwordteams-addon').click(function() {
			var passwordInput = $('#password_Team');
			if (passwordInput.attr('type') === 'password') {
				passwordInput.attr('type', 'text');
			} else {
				passwordInput.attr('type', 'password');
			}
		});
		$('[data-bs-toggle="tooltip"]').tooltip();
		$('#phone').inputmask({
			"mask": "(999) 999-9999"
		}); // รูปแบบของหมายเลขโทรศัพท์
	});
</script>
