<div class="card">
	<div class="modal-content">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title d-flex align-items-center">
					<i class="mdi mdi-account-clock me-2 font-size-22 text-danger"></i> รายชื่อผู้ใช้งานที่ถูกลบ
				</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<div class="table-responsive">
					<table class="table align-middle table-nowrap mb-0">
						<thead class="table-light">
							<tr>
								<th class="align-middle text-center" style="width: 5px;">#</th>
								<th class="align-middle text-start">ชื่อ-สกุล</th>
								<th class="align-middle text-start">สถานะ</th>
								<th class="align-middle text-center">deleted_at</th>
								<th class="align-middle text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($users as $key => $user)
								<tr class="tr_{{$user->id}}">
									<td>
										<div class="avatar-xs">
											<span class="avatar-title rounded-circle bg-light bg-gradient">
												{{ $key + 1 }}
											</span>
										</div>
									</td>
									<td>
										<h5 class="font-size-14 mb-1"><a href="javascript: void(0);" class="text-dark">{{ @$user->name }}</a></h5>
										<span class="mb-0 badge badge-pill font-size-12 badge-soft-success">{{ @$user->email }}</span>
									</td>
									<td class="text-start">
										<button type="button" class="btn btn-outline-danger btn-sm btn-rounded waves-effect waves-light">
											{{ @$user->status }}
										</button>
									</td>
									<td class="text-center">{{ @$user->deleted_at }}</td>
									<td class="text-center">
										<ul class="list-inline font-size-20 contact-links mb-0">
											<li class="list-inline-item">
												<a role="button" class="btn_restores" data-id="{{@$user->id}}" data-name="{{@$user->name}}" data-bs-toggle="tooltip" data-bs-placement="top" title="คืนค่าผู้ใช้งาน">
													<i class="mdi mdi-account-reactivate-outline text-warning"></i>
												</a>
											</li>
										</ul>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function () {
		$(function () {
			$(".input-mask").inputmask();
			$('[data-bs-toggle="tooltip"]').tooltip();
		});

		$('.btn_restores').click(function(event) {
			event.preventDefault();

			let id = $(this).data('id');
			let name = $(this).data('name');

			Swal.fire({
				icon: 'question',
				title: 'คืนค่าผู้ใช้งาน',
				text: `ต้องการคืนค่าผู้ใช้งาน ` + name + ` หรือไม่ ?`,
				showCancelButton: true,
				confirmButtonText: 'ตกลง',
				cancelButtonText: 'ยกเลิก',
				preConfirm: async () => {
					Swal.showLoading();
					let link = "{{ route('permission.update', 'id') }}";
					let url = link.replace('id', id);

					try {
						let response = await $.ajax({
							url: url,
							method: 'PUT',
							data: {
								_token: "{{ @csrf_token() }}", // แก้ไขตรงนี้เป็น csrf_token()
								page: 'users-restore',
							},
						});

						$('.tr_' + id).remove();
						$('.content-user').html(response.view_data);
						Swal.fire({
							icon: 'success',
							text: response.message,
							showConfirmButton: false,
							timer: 1500
						});
						// Swal.fire({
						// 	icon: 'success',
						// 	title: 'คืนค่าผู้ใช้งานสำเร็จ',
						// 	showConfirmButton: false,
						// 	timer: 1500
						// }).then(function () {
						// 	location.reload();
						// });
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
	});
</script>