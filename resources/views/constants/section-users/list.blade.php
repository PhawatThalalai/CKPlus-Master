<table id="table-user" class="table align-middle table-nowrap table-hover table-user">
	<thead class="table-light">
		<tr>
			<th scope="col">Name</th>
			<th scope="col" class="text-center">Status</th>
			<th scope="col" class="text-center">Brachs</th>
			<th scope="col" class="text-center">Roles</th>
			<th scope="col" class="text-center">Created at</th>
			<th scope="col" class="text-center">Updated at</th>
			<th scope="col">Action</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($users as $key => $user)
			<tr data-id="{{ $user->id }}">
				<td>
					<h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">{{ @$user->name }}</a></h5>
					<span class="mb-0 badge badge-pill font-size-12 badge-soft-success">{{ @$user->email }}</span>

				</td>
				<td class="text-start">
					<button type="button" class="btn btn-outline-warning btn-sm btn-rounded waves-effect waves-light">
						{{ @$user->status }}
					</button>
				</td>
				<td class="text-center">
					<button type="button" class="btn btn-outline-info btn-sm btn-rounded waves-effect waves-light">
						{{ @$user->UserToBranch->Name_Branch }}
					</button>
				</td>
				<td class="text-center">
					@if ($user->getRoleNames()->isNotEmpty())
						@foreach ($user->getRoleNames() as $role)
							<span class="badge badge-soft-success font-size-11">
								{{ $role }}
							</span>
						@endforeach
					@endif
				</td>
				{{-- <td>
					{{ $user->permissions->count() + $user->getPermissionsViaRoles()->count() }}
				</td> --}}
				<td>{{ $user->created_at }}</td>
				<td>{{ $user->updated_at }}</td>
				<td class="text-end">
					<ul class="list-inline font-size-20 contact-links mb-0">
						<li class="list-inline-item">
							<a role="button" class="btn-edit modal_lg" data-link="{{ route('permission.edit', $user->id) }}?page={{ 'users-edit' }}" data-bs-toggle="tooltip" data-bs-placement="top" title="edit">
								<i class="bx bx-edit text-warning"></i>
							</a>
						</li>
						<li class="list-inline-item">
							<a role="button" class="btn_destroyUser" data-id="{{ $user->id }}" data-name="{{ $user->name }}" data-bs-toggle="tooltip" data-bs-placement="top" title="delete">
								<i class="bx bx-trash-alt text-danger"></i>
							</a>
						</li>
					</ul>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>

<script>
	$('.btn_destroyUser').click(function(event) {
		event.preventDefault();
		let id = $(this).data('id');
		let name = $(this).data('name');

		Swal.fire({
			icon: 'question',
			title: 'ลบสมาชิกผู้ใช้งาน',
			text: `ต้องการลบผู้ใช้งาน ` + name + ` ออกหรือไม่ ?`,
			showCancelButton: true,
			confirmButtonText: 'ตกลง',
			cancelButtonText: 'ยกเลิก',
			preConfirm: async () => {
				Swal.showLoading();
				let link = "{{ route('permission.destroy', 'id') }}";
				let url = link.replace('id', id);

				try {
					let response = await $.ajax({
						url: url,
						method: 'delete',
						data: {
							_token: "{{ @csrf_token() }}", // แก้ไขตรงนี้เป็น csrf_token()
							page: 'users-delete'
						},
					});

					$('.content-user').html(response.view_data);
					Swal.fire({
						icon: 'success',
						text: response.message,
						showConfirmButton: false,
						timer: 1500
					});

				} catch (err) {
					Swal.fire({
						icon: 'error',
						title: `ERROR ` + err.status + ` !!!`,
						text: err.responseJSON.message,
						showConfirmButton: true,
					});
				}
			},
			allowOutsideClick: () => !Swal.isLoading(),
			showLoaderOnConfirm: true,
			focusConfirm: false, // ปุ่มยกเลิกไม่สามารถคลิกได้ขณะที่กำลังทำงาน
		}).then((result) => {
			if (result.isConfirmed) {
				console.log('The user clicked "ตกลง"');
			}
		});
	});

	$(document).ready(function() {
		var table = $('.table-user').DataTable({
			order: [
				[0, 'asc']
			],
			columnDefs: [{
					orderable: false,
					targets: [0, -1]
				}, // Disable ordering for the hidden column
			],
			rowReorder: {
				selector: 'tr td:nth-child(1)',
				dataSrc: 1, // Specify the index of the column containing the icon
			}
		})
	});
</script>
