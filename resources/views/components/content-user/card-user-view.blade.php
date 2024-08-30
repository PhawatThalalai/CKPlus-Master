<div class="card mt-n1">
	<div class="card-header bg-transparent border-bottom fw-semibold d-inline mt-2">
		<span class="card-title fs-6 text-primary">
			<span class="d-block d-sm-none"><i class="far fa-user"></i> {{ @$title }}</span>
			<span class="d-none d-sm-block">
				<i class="far fa-user"></i>
				{{ @$title }} ({{ @$title_eng }})
			</span>
		</span>
		@isset($data['id'])
			<span class="float-end mt-n4" data-bs-toggle="tooltip" title="แก้ไข">
				<ul class="list-inline user-chat-nav mb-0">
					<li class="list-inline-item d-sm-inline-block me-auto">
						<div class="dropdown">
							@can('edit-customer')
								<button class="btn nav-btn hover-up data-modal-xl" type="button" data-link="{{ route('cus.edit', @$data['id']) }}?funs={{ 'edit-dataCus' }}">
									<i class="bx bx-edit-alt bx-xs"></i>
								</button>
							@endcan
						</div>
					</li>
				</ul>
			</span>
		@endisset
	</div>
	<div class="card-body p-3 pt-1">
		<div class="row">
			<div class="col-12 col-md-6 col-lg-6">
				<div class="table-responsive">
					<table class="table table-sm table-nowrap mb-0">
						<tbody>
							<tr>
								<th scope="row">วันเดือนปีเกิด :</th>
								<td>
									@isset($data['Birthday'])
										{{ formatDateThai(@$data['Birthday']) }}
										<em> ({{ calculateAge(@$data['Birthday']) }} ปี)</em>
									@else
										-
									@endisset
								</td>
							</tr>
							<tr>
								<th scope="row">เพศ :</th>
								<td>
									@isset($data['Gender'])
										{{ @$Display_Gender }}
									@else
										-
									@endisset
								</td>
							</tr>
							<tr>
								<th scope="row">สัญชาติ :</th>
								<td>
									@isset($data['Nationality'])
										{{ @$data['Nationality'] }}
									@else
										-
									@endisset
								</td>
							</tr>
							<tr>
								<th scope="row">ศาสนา :</th>
								<td>
									@isset($data['Religion'])
										{{ @$data['Religion'] }}
									@else
										-
									@endisset
								</td>
							</tr>
							<tr>
								<th scope="row">สถานะสมรส :</th>
								<td>
									@isset($data['Marital'])
										{{ @$data['Marital'] }}
										@if (@$data['Marital'] != 'โสด')
											<ul class="list-unstyled mb-0 text-primary">
												<li>
													<ul>
														<li>คู่สมรส <b>{{ @$data['Mate'] }}</b></li>
														<li>เบอร์โทรคู่สมรส <b>{{ @$data['MatePhone'] }}</b></li>
													</ul>
												</li>
											</ul>
										@endif
									@else
										-
									@endisset
								</td>
							</tr>
							<tr>
								<th scope="row">ธนาคาร :</th>
								<td>
									@isset($data['Account'])
										{{ @$data['Account'] }}
										<ul class="list-unstyled mb-0 text-primary">
											<li>
												<ul>
													<li>สาขา <b>{{ @$data['AccountBranch'] }}</b></li>
													<li>เลขที่บัญชี <b>{{ @$data['AccountNumber'] }}</b></li>
												</ul>
											</li>
										</ul>
									@else
										-
									@endisset
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="col-12 col-md-6 col-lg-6">
				<p class="m-0" style="color: var(--bs-table-color); --bs-table-color: var(--bs-body-color);"><strong>หมายเหตุ :</strong></p>
				<p class="m-0 p-3 rounded-3 bg-light" data-simplebar style="max-height: 170px; min-height: 170px;">
					@isset($data['Note'])
						{{ @$data['Note'] }}
					@else
						<em>- ยังไม่มีบันทึก -</em>
					@endisset
				</p>
			</div>
		</div>
		<div class="mt-3 d-flex flex-wrap align-items-center">
			@isset($data['facebook'])
				<span class="text-primary p-2">
					<i class="bx bxl-facebook-square fs-5" data-bs-toggle="tooltip" title="Facebook"></i>
					<b>
						{{ @$data['facebook'] }}
					</b>
				</span>
			@endisset
			@isset($data['Line'])
				<span class="text-success p-2">
					<i class="fab fa-line fs-5" data-bs-toggle="tooltip" title="Line ID"></i>
					<b>
						{{ @$data['Line'] }}
					</b>
				</span>
			@endisset
			@isset($data['Driver'])
				{{ @$Display_Driver }}
			@endisset
			@isset($data['Namechange'])
				{{ @$Display_Namechange }}
			@endisset
		</div>
	</div>
</div>

{{-- @pushOnce('scripts')
	<script>
		$(document).on('click', '.data-modal-xl', function(e) {
			e.preventDefault();
			var url = $(this).attr('data-link');
			$('#data-modal-xl .data-modal-xl-body').load(url);
		});
	</script>
@endPushOnce --}}
