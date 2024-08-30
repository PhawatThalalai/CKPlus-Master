<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>
@include('backend.content-temp.section-recontract.script')
@include('backend.content-temp.section-seized.script')
@include('backend.content-temp.section-terminate.script')
@include('backend.content-temp.section-badDebt.script')

<div class="modal-content">
	<form class="needs-validation" action="#" novalidate>
		<div class="modal-body">
			@if (@$typeSr == 'namecus' or @$typeSr == 'idcardcus' or @$typeSr == 'license')
				<div class="table-responsive" data-simplebar="init" style="max-height: 420px;  min-height : 420px;">
					@if (count($data) != 0)
						<table class="table align-middle table-nowrap text-nowrap table-hover font-size-12">
							<thead class="table-light sticky-top text-center">
								<tr>
									<th scope="col" colspan="2">ชื่อ - สกุล</th>
									<th scope="col">บัตรประชาชน</th>
									<th scope="col">ประเภทสัญญา</th>
									<th scope="col">เลขที่สัญญา</th>
									<th scope="col">เลขทรัพย์</th>
									{{-- <th scope="col">สถานะสัญญา</th> --}}
									<th scope="col">#</th>
								</tr>
							</thead>
							<tbody>
								@foreach ($data as $item)
									@foreach ($item->DataCusToContracts as $cont)
										<tr>
											<td>
												<div>
													<img class="rounded-circle avatar-xs" src="{{ isset($item->image_cus) ? URL::asset(@$item->image_cus) : asset('/assets/images/users/user-1.png') }}" alt="">
												</div>
											</td>
											<td>
												<h5 class="font-size-13 mb-1"><a role="button" class="text-dark">{{ @$item->Prefix }} : {{ @$item->Name_Cus }}</a></h5>
												<p class="mb-0 badge badge-pill font-size-12 {{ @$item->Status_Cus == 'active' ? ' badge-soft-warning' : ' badge-soft-danger' }}">สถานะ :
													{{ @$item->Status_Cus }}
												</p>
											</td>
											<td><span class="input-mask" data-inputmask="'mask': '9-9999-99999-99-9'">{{ $item->IDCard_cus }}</span></td>
											<td class="text-center">
												<button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
													{{ @$cont->ContractToTypeLoan->Loan_Name }}
												</button>
											</td>
											<td>
												<h5 class="font-size-13 mb-1"><a role="button" class="text-dark">สัญญา : {{ @$cont->Contract_Con }}</a></h5>
												@php
													if (@$cont->ContractToTypeLoan->Loan_Com == 2) {
													    $id = @$cont->ContractToConHP->id;
													    $CONTSTAT = @$cont->ContractToConHP->PactToStatus->CONTDESC;
													} else {
													    $id = @$cont->ContractToConPSL->id;
													    $CONTSTAT = @$cont->ContractToConPSL->PactToStatus->CONTDESC;
													}
												@endphp
												<span class="mb-0 badge badge-pill font-size-12 badge-soft-warning {{ @$CONTSTAT == 'ลูกหนี้ปกติ' ? 'badge-soft-success' : 'badge-soft-warning' }}">สถานะ : {{ @$CONTSTAT }}</span>
											</td>
											<td class="text-center">
												{{-- @$item->DataCusToDataAsset->Vehicle_OldLicense --}}
												@if (count(@$item->DataCusToDataAsset) > 0)
													@foreach (@$item->DataCusToDataAsset as $key => $value)
														<div>
															<span class="text-dark text-center">{{ $value->Vehicle_OldLicense }}</span>
														</div>
													@endforeach
												@else
													-
												@endif
											</td>
											{{-- <td>
												<button type="button" class="btn btn-success btn-sm btn-rounded waves-effect waves-light">
													ปิดบัญชี
												</button>
											</td> --}}
											{{-- @php
												dd($pageUrl);
											@endphp --}}
											<td>
												<ul class="list-inline font-size-20 contact-links mb-0">
													<li class="list-inline-item px-2">
														{{-- Profile Contract --}}
														<a href="{{ route('contracts.edit', @$cont->id) }}?page={{ 'contract' }}" title="Contract"><i class="mdi mdi-book-account-outline hover-up text-success bg-soft me-1"></i></a>

														@if (@$page == 'payments')
															<a href="{{ route('payments.edit', @$cont->id) }}?page={{ 'payments' }}" title="เลือกรายการ"><i class="mdi mdi-check-box-multiple-outline hover-up text-warning bg-soft"></i></a>
														@elseif ($page == 'track-follow-up')
															<a href="{{ route('datatrack.edit', @$cont->id) }}?page={{ 'track-follow-up' }}" title="เลือกรายการ"><i class="mdi mdi-check-box-multiple-outline hover-up text-warning bg-soft"></i></a>
														@elseif ($page == 'terminate-letter')
															<!-- <a href="#" class="terminate" data-id="{{ @$cont->id }}" data-sub="{{ @$page_tmp }}" title="เลือกรายการ"><i class="mdi mdi-file-compare hover-up text-warning bg-soft"></i></a> -->
															<!-- <a href="{{ route('account.edit', @$cont->id) }}?page={{ 'terminate-letter' }}" title="เลือกรายการ Link"><i class="mdi mdi-file-compare hover-up text-danger bg-soft"></i></a> -->
															<a href="#" class="terminate" data-id="{{ @$cont->id }}" title="เลือกรายการ"><i class="mdi mdi-file-compare hover-up text-warning bg-soft"></i></a>
														@elseif ($page == 'view-seized' && $page_tmp != 'search-seized')
															@if (@$item->CusToHLD != null)
																<a class="btn-getSeized" data-bs-toggle="tooltip" title="บันทึกยึดรอไถ่ถอนแล้ว" PactCon_id="{{ @$cont->id }}"><span class="showIcon"><i class="mdi mdi-car-key hover-up text-warning bg-soft"></i></span> <span class="showIcon" style="display: none;"> <i class="bx bxs-hourglass-top bx-tada"></i> </span> </a>
															@else
																<a class="btn-seized" data-bs-toggle="tooltip" title="บันทึกยึดรอไถ่ถอน" PactCon_id="{{ @$cont->id }}"><span class="showIcon"><i class="mdi mdi-file-compare hover-up text-danger bg-soft"></i></span> <span class="showIcon" style="display: none;"> <i class="bx bxs-hourglass-top bx-tada"></i> </span> </a>
															@endif
														@elseif ($page == 'bad-debt' && @$page_tmp == null)
															<a class="btn-Baddebt" data-bs-toggle="tooltip" title="บันทึกหนี้สูญ" PactCon_id="{{ @$cont->id }}"><span class="showIcon"><i class="mdi mdi-file-compare hover-up text-danger bg-soft"></i></span> <span class="showIcon" style="display: none;"> <i class="bx bxs-hourglass-top bx-tada"></i> </span> </a>
														@elseif ($page == 'view-recontracts' && @$page_tmp == null)
															<a class="btn-recontracts" PactCon_id="{{ @$cont->id }}"><span class="showIcon"><i class="mdi mdi-file-compare hover-up text-danger bg-soft"></i></span> <span class="showIcon" style="display: none;"> <i class="bx bxs-hourglass-top bx-tada"></i> </span> </a>
														@endif

														{{-- สอบถามรายการที่เคยเพิ่มมาแล้ว --}}
														@if ($page_tmp == 'search-seized')
															<a class="btn-getSeized" PactCon_id="{{ @$cont->id }}"><span class="showIcon"><i class="mdi mdi-book-edit-outline hover-up text-danger bg-soft"></i></span> <span class="showIcon" style="display: none;"> <i class="bx bxs-hourglass-top bx-tada"></i> </span> </a>
														@elseif($page_tmp == 'search-baddebt')
															<a class="btn-getBaddebt" PactCon_id="{{ @$cont->id }}"><span class="showIcon"><i class="mdi mdi-book-edit-outline hover-up text-danger bg-soft"></i></span> <span class="showIcon" style="display: none;"> <i class="bx bxs-hourglass-top bx-tada"></i> </span> </a>
														@elseif($page_tmp == 'search-recontract')
															<a class="btn-getRecontract" PactCon_id="{{ @$cont->id }}"><span class="showIcon"><i class="mdi mdi-book-edit-outline hover-up text-danger bg-soft"></i></span> <span class="showIcon" style="display: none;"> <i class="bx bxs-hourglass-top bx-tada"></i> </span> </a>
														@endif

														{{-- @if (@$page == 'payments')
                                                            <a href="{{route('payments.edit',@$cont->id)}}?type={{1}}" title="เลือก"><i class="bx bx-user-circle hover-up"></i></a>
                                                        @elseif (@$page == 'tracking')
                                                            <a href="{{route('datatrack.edit',@$cont->id)}}?type={{1}}&tab={{1}}" title="selected"><i class="bx bx-user-circle hover-up"></i></a>
                                                        @endif
                                                        @if (@$page == 'contracts')
                                                            <a href="{{route('contracts.edit',@$cont->id)}}?type={{1}}" title="เลือก"><i class="bx bx-user-circle hover-up"></i></a>
                                                        @endif --}}
													</li>
												</ul>
											</td>
										</tr>
									@endforeach
								@endforeach
							</tbody>
						</table>
					@else
						<div class="card-body p-4 m-4">
							<div class="text-center">
								<div class="avatar-md mx-auto mb-4">
									<div class="avatar-title bg-light rounded-circle text-primary h1">
										<img src="{{ asset('assets/images/gif/error.gif') }}" alt="report" class="avatar-sm" style="width:80px;height:80px">
									</div>
								</div>

								<div class="row justify-content-center">
									<div class="col-xl-10">
										<h4 class="text-warning">ไม่พบข้อมูล !</h4>
										<p class="text-muted font-size-14 mb-4">ไม่พบข้อมูลที่ค้นหา โปรดตรวจสอบความถูกต้องอีกครั้ง.</p>
									</div>
								</div>
							</div>
						</div>
					@endif
				</div>
			@elseif(@$typeSr == 'contract')
				<div class="table-responsive" data-simplebar="init" style="max-height: 420px;  min-height : 420px;">
					<table class="table align-middle table-nowrap text-nowrap table-hover font-size-12">
						<thead class="table-light sticky-top text-center">
							<tr>
								<th scope="col" colspan="2">ชื่อ - สกุล</th>
								<th scope="col">บัตรประชาชน</th>
								<th scope="col">ประเภทสัญญา</th>
								<th scope="col">เลขที่สัญญา</th>
								<th scope="col">เลขทรัพย์</th>

								{{-- <th scope="col">สถานะสัญญา</th> --}}
								<th scope="col">#</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($data as $item)
								<tr>
									<td>
										<div>
											<img class="rounded-circle avatar-xs" src="{{ isset($item->ContractToCus->image_cus) ? URL::asset(@$item->ContractToCus->image_cus) : asset('/assets/images/users/user-1.png') }}" alt="">
										</div>
									</td>
									<td>
										<h5 class="font-size-13 mb-1"><a role="button" class="text-dark">{{ @$item->ContractToCus->Prefix }} : {{ @$item->ContractToCus->Name_Cus }}</a></h5>
										<p class="mb-0 badge badge-pill font-size-12 {{ @$item->ContractToCus->Status_Cus == 'active' ? ' badge-soft-warning' : ' badge-soft-danger' }}">เกรด :
											@php
												if (@$item->ContractToTypeLoan->Loan_Com == 2) {
												    echo @$item->ContractToConHP->GRDCOD;
												} else {
												    echo @$item->ContractToConPSL->GRDCOD;
												}
											@endphp
										</p>
									</td>
									<td><span class="input-mask" data-inputmask="'mask': '9-9999-99999-99-9'">{{ @$item->ContractToCus->IDCard_cus }}</span></td>
									<td class="text-center">
										<button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
											{{ @$item->ContractToTypeLoan->Loan_Name }}
										</button>
									</td>
									<td>
										@php
											if (@$item->ContractToTypeLoan->Loan_Com == 2) {
											    $id = @$item->ContractToConHP->id;
											    $CONTSTAT = @$item->ContractToConHP->CONTSTAT;
											} else {
											    $id = @$item->ContractToConPSL->id;
											    $CONTSTAT = @$item->ContractToConPSL->CONTSTAT;
											}
										@endphp
										<h5 class="font-size-13 mb-1"><a role="button" class="text-dark">สัญญา : {{ @$item->Contract_Con }}</a></h5>
										@if (@$CONTSTAT == 'N')
											<span class="mb-0 badge badge-pill font-size-12 badge-soft-warning">สถานะ : ปกติ</span>
										@else
											<span class="mb-0 badge badge-pill font-size-12 badge-soft-success">สถานะ : ยกเลิก</span>
										@endif
									</td>
									<td>
										@if (@$item->ContractToTypeLoan->id_rateType == 'car' or @$item->ContractToTypeLoan->id_rateType == 'moto')
											<span class="text-dark text-center">{{ @$item->ContractToIndentureAsset->IndenAssetToDataOwner->Vehicle_OldLicense }}</span>
										@else
											<span class="text-dark text-center">{{ @$item->ContractToIndentureAsset->IndenAssetToDataOwner->Land_ParcelNumber }}</span>
										@endif
									</td>
									{{-- <td class="text-center">
										<button type="button" class="btn btn-success btn-sm btn-rounded waves-effect waves-light">
											ปิดบัญชี
										</button>
									</td> --}}
									<td>
										<ul class="list-inline font-size-20 contact-links mb-0">
											<a data-bs-toggle="tooltip" title="ไปยังหน้าสัญญา" href="{{ route('contracts.edit', @$item->id) }}?page={{ 'contract' }}" title="Contract"><i class="mdi mdi-book-account-outline hover-up text-success bg-soft me-1"></i></a>
											@if (@$page == 'payments')
												<a href="{{ route('payments.edit', @$item->id) }}?page={{ 'payments' }}" title="เลือกรายการ"><i class="mdi mdi-check-box-multiple-outline hover-up text-warning bg-soft"></i></a>
											@elseif ($page == 'track-follow-up')
												<a href="{{ route('datatrack.edit', @$item->id) }}?page={{ 'track-follow-up' }}" title="เลือกรายการ"><i class="mdi mdi-check-box-multiple-outline hover-up text-warning bg-soft"></i></a>
											@elseif ($page == 'terminate-letter')
												<a href="#" class="terminate" data-id="{{ @$item->id }}" data-sub="{{ @$page_tmp }}" title="เลือกรายการ"><i class="mdi mdi-file-compare hover-up text-warning bg-soft"></i></a>
											@elseif ($page == 'bad-debt' && @$page_tmp == null)
												{{-- <a href="{{ route('account.edit', @$item->id) }}?page={{ 'bad-debt' }}" title="เลือกรายการ"><i class="mdi mdi-file-compare hover-up text-danger bg-soft"></i></a> --}}
												<a class="btn-Baddebt" data-bs-toggle="tooltip" title="บันทึกหนี้สูญ" PactCon_id="{{ @$item->id }}"><span class="showIcon"><i class="mdi mdi-file-compare hover-up text-danger bg-soft"></i></span> <span class="showIcon" style="display: none;"> <i class="bx bxs-hourglass-top bx-tada"></i> </span> </a>
											@elseif ($page == 'view-seized' && @$page_tmp == null)
												@if (@$item->ContractToConHP->YSTAT == 'Y' || @$item->ContractToConPSL->YSTAT == 'Y')
													<a class="btn-getSeized" data-bs-toggle="tooltip" title="บันทึกยึดรอไถ่ถอนแล้ว" PactCon_id="{{ @$item->id }}"><span class="showIcon"><i class="mdi mdi-car-key hover-up text-warning bg-soft"></i></span> <span class="showIcon" style="display: none;"> <i class="bx bxs-hourglass-top bx-tada"></i> </span> </a>
												@else
													<a class="btn-seized" data-bs-toggle="tooltip" title="บันทึกยึดรอไถ่ถอน" PactCon_id="{{ @$item->id }}"><span class="showIcon"><i class="mdi mdi-file-compare hover-up text-danger bg-soft"></i></span> <span class="showIcon" style="display: none;"> <i class="bx bxs-hourglass-top bx-tada"></i> </span> </a>
												@endif
											@elseif ($page == 'mega-edit-con')
												<a href="{{ route('contracts.edit', @$item->id) }}?page={{ 'edit-contract' }}" title="เลือกรายการ"><i class="mdi mdi-check-box-multiple-outline hover-up text-warning bg-soft"></i></a>
											@elseif ($page == 'renew-contract')
												<a class="btn-recontracts" PactCon_id="{{ @$item->id }}"><span class="showIcon"><i class="mdi mdi-file-compare hover-up text-danger bg-soft"></i></span> <span class="showIcon" style="display: none;"> <i class="bx bxs-hourglass-top bx-tada"></i> </span> </a>
											@endif

											{{-- สอบถามรายการที่เคยเพิ่มมาแล้ว --}}
											@if ($page_tmp == 'search-seized')
												<a class="btn-getSeized" PactCon_id="{{ @$item->id }}"><span class="showIcon"><i class="mdi mdi-book-edit-outline hover-up text-danger bg-soft"></i></span> <span class="showIcon" style="display: none;"> <i class="bx bxs-hourglass-top bx-tada"></i> </span> </a>
											@elseif($page_tmp == 'search-baddebt')
												<a class="btn-getBaddebt" PactCon_id="{{ @$item->id }}"><span class="showIcon"><i class="mdi mdi-book-edit-outline hover-up text-danger bg-soft"></i></span> <span class="showIcon" style="display: none;"> <i class="bx bxs-hourglass-top bx-tada"></i> </span> </a>
											@elseif($page_tmp == 'search-recontract')
												<a class="btn-getRecontract" PactCon_id="{{ @$item->id }}"><span class="showIcon"><i class="mdi mdi-book-edit-outline hover-up text-danger bg-soft"></i></span> <span class="showIcon" style="display: none;"> <i class="bx bxs-hourglass-top bx-tada"></i> </span> </a>
											@endif
											</li>
										</ul>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			@endif
		</div>
	</form>
</div>

<script>
	$(function() {
		$('[data-bs-toggle="tooltip"]').tooltip();
	})
</script>
<script>
	$(".table-search").DataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": false,
		"info": true,
		"autoWidth": false,
		"order": [
			[0, "asc"]
		],
		"pageLength": 10,
	});
</script>
