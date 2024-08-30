<div class="table-responsive">
	<table id="table-role" class="table align-middle table-nowrap table-hover table-role">
		<thead class="table-light">
			<tr>
				<th scope="col" style="width: 70px;">#</th>
				<th scope="col">Code</th>
				<th scope="col">Name</th>
				<th scope="col">Created at</th>
				<th scope="col">Updated at</th>
				<th scope="col">Action</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($roles as $role)
				<tr>
					<th scope="row">{{ $loop->iteration }}</th>
					<td>
						<div class="avatar-xs">
							<span class="avatar-title rounded-circle">
								{{ $role->code }}
							</span>
						</div>
					</td>
					<td>
						<h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">{{ $role->name_en }}</a></h5>
						<p class="text-muted mb-0">{{ $role->name_th }}</p>
					</td>
					<td>
						{{ $role->created_at->format('d-m-Y H:i:s') }}
					</td>
					<td>
						{{ $role->updated_at->format('d-m-Y H:i:s') }}
					</td>
					<td>
						<ul class="list-inline font-size-20 contact-links mb-0">
							<li class="list-inline-item px-2">
								<a href="{{ route('permission.edit', $role->id) }}?page={{ 'roles-edit' }}" data-bs-toggle="tooltip" title="manage role">
									<i class="bx bx-cog"></i>
								</a>
							</li>
							<li class="list-inline-item px-2">
								<a role="button" class="btn_deleterole" data-id="{{ $role->id }}" data-name="{{ $role->name }}" data-bs-toggle="tooltip" data-bs-placement="top" title="delete">
									<i class="bx bx-trash-alt text-danger"></i>
								</a>
							</li>
						</ul>
					</td>
				</tr>
			@endforeach
		</tbody>
	</table>
</div>

<script>
	$(document).ready(function() {
		$('.table-role').DataTable({
			"responsive": false,
			"autoWidth": false,
			"ordering": true,
			"lengthChange": true,
			"order": [
				[0, "asc"]
			],
			"pageLength": 10,
		});
	});

	$('.btn_deleterole').click(function(event) {
		event.preventDefault();
		let id = $(this).data('id');
		let name = $(this).data('name');

		Swal.fire({
			icon: 'question',
			title: 'ลบบทบาทผู้ใช้งาน',
			text: `ต้องการลบบทบาท ` + name + ` ออกหรือไม่ ?`,
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
						},
					});

					$('.content-roles').html(response.view_data);
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
</script>
