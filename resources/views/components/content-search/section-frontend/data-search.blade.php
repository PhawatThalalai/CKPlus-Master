<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>
@include('frontend.content-con.section-payee.script-payee')
@include('frontend.content-con.section-broker.script-broker')

<style>
	.spinner-border {
		display: block;
		position: fixed;
		top: calc(50% - (58px / 2));
		right: calc(50% - (58px / 2));
	}

	.dataSearch-popover {
		--bs-popover-max-width: 300px;
		--bs-popover-border-color: var(--bs-danger);
		--bs-popover-header-bg: var(--bs-danger);
		--bs-popover-header-color: var(--bs-white);
		--bs-popover-body-padding-x: 1rem;
		--bs-popover-body-padding-y: .5rem;
	}
</style>
<style>

</style>
<div class="modal-content main-modal">
	<div id="load" style="z-index: 999; display:none;">
		<div class="text-center loading">
			<div class="spinner-border" role="status"style="width: 3rem; height: 3rem;">
				<span class="sr-only">Loading...</span>
			</div>
		</div>
	</div>
	<form class="needs-validation" action="#" novalidate>
		<div class="modal-body">
			@if (@$typeSr == 'namecus' or @$typeSr == 'idcardcus' or @$typeSr == 'license' or @$typeSr == 'phone')
				@if (@$pageUrl == 'add-Guaran' or @$pageUrl == 'add-Payee' or @$pageUrl == 'add-Broker')
					<h6 class="fw-semibold"><i class="bx bxs-star text-warning"></i> 10 รายการที่เพิ่มล่าสุด</h6>
				@endif
				<div class="table-responsive" data-simplebar="init" style="max-height: 420px;  min-height : 420px;">
					@if (count($data) != 0)
						<table class="table align-middle table-nowrap text-nowrap table-hover font-size-12">
							<thead class="table-light sticky-top text-center">
								<tr>
									<th scope="col" colspan="2">ชื่อ - สกุล</th>
									<th scope="col">บัตรประชาชน</th>
									<th scope="col">วันที่รับ</th>
									<th scope="col">ประเภทลูกค้า</th>
									<th scope="col">Tags</th>
									<th scope="col">เลขทรัพย์</th>
									<th scope="col">#</th>
								</tr>
							</thead>
							<tbody>
								@foreach (@$data as $item)
									<tr>
										<td>
											<div>
												<img class="rounded-circle avatar-xs" src="{{ isset($item->image_cus) ? URL::asset(@$item->image_cus) : asset('/assets/images/users/user-1.png') }}" alt="">
											</div>
										</td>
										<td>
											<h5 class="font-size-13 mb-1"><a role="button" class="text-dark">{{ @$item->Prefix }} : {{ @$item->Name_Cus }}</a></h5>
											@if (@$item->Status_Cus == 'active')
												<span class="mb-0 badge badge-pill font-size-12 badge-soft-success">สถานะ : ปกติ</span>
											@elseif (@$item->Status_Cus == 'cancel')
												<span class="mb-0 badge badge-pill font-size-12 badge-soft-warning">สถานะ : ยกเลิก</span>
											@else
												<span class="mb-0 badge badge-pill font-size-12 badge-soft-danger">สถานะ : blacklist</span>
											@endif
											@if(@$item->Type_Card =='324003')
												<span class="mb-0 badge badge-pill font-size-12 badge-soft-danger">สาขา : {{ $item->Status_Com == 'IN' ? $item->DataCusToZone->Zone_Name : $item->Branch_Account }}</span>
											@endif
										</td>
										<td class="text-center">
											<div class="d-flex justify-content-center align-items-center mb-1">
												@if (!empty(@$item->IDCard_cus))
													<span class="badge badge-soft-primary badge-pill me-1 d-flex align-items-center">
														<i class="bx bxs-id-card font-size-14"></i>
													</span>
													<span class="input-mask" data-inputmask="'mask': '9-9999-99999-99-9'">{{ @$item->IDCard_cus }}</span>
												@else
													<span class="text-secondary fst-italic text-opacity-50 textcenter">ไม่พบข้อมูล</span>
												@endif
											</div>

											@if ( !empty( getFirstPhone_php(@$item->Phone_cus) ) )
												<span class="badge badge-soft-info" data-bs-toggle="tooltip" title="{{formatPhoneNumber( getFirstPhone_php(@$item->Phone_cus), '99 9999 9999' )}}">
													<i class="bx bxs-phone font-size-13 pe-1"></i>1
												</span>
											@endif
											@php
												$phone_cus_2 = "";
												if ( empty(@$item->Phone_cus2) ) {
													$_phone_numbers = explode(',', @$item->Phone_cus);
													if ( isset($_phone_numbers[1]) ) {
														$phone_cus_2 = $_phone_numbers[1];
													}
												} else {
													$phone_cus_2 = @$item->Phone_cus2;
												}
											@endphp
											@if ( !empty( $phone_cus_2 ) )
												<span class="badge badge-soft-info" data-bs-toggle="tooltip" title="{{formatPhoneNumber( $phone_cus_2, '99 9999 9999')}}">
													<i class="bx bxs-phone font-size-13 pe-1"></i>2
												</span>
											@endif
											
										</td>
										<td class="text-center">{{ date('d-m-Y', strtotime(@$item->date_Cus)) }}</td>
										<td class="text-center">
											<button type="button" class="btn btn-primary btn-sm btn-rounded waves-effect waves-light">
												@if(@$item->Type_Card !='324003')
													@if (isset($item->CusToCusTagOne) && isset($item->DataCusToBroker))
														ลูกค้า / ผู้แนะนำ
													@else
														@if (isset($item->CusToCusTagOne))
															ลูกค้า
														@elseif (isset($item->DataCusToBroker))
															ผู้แนะนำ
														@else
															ทั่วไป
														@endif
													@endif
												@else
													บริษัท
												@endif
											</button>
										</td>
										<td class="small">
											@if (isset($item->CusToCusTagOne))
												<h5 class="font-size-12 mb-1"><a role="button" class="text-dark">Tag : {{ @$item->CusToCusTagOne->Code_Tag }}</a></h5>
												@if (@$item->CusToCusTagOne->Status_Tag == 'complete')
													<p class="mb-0 badge badge-pill font-size-12 badge-soft-success">สถานะ : ส่งจัดไฟแนนซ์</p>
												@elseif (@$item->CusToCusTagOne->Status_Tag == 'inactive')
													<p class="mb-0 badge badge-pill font-size-12 badge-soft-danger">สถานะ : ยกเลิกติดตาม</p>
												@else
													<p class="mb-0 badge badge-pill font-size-12 badge-soft-warning">สถานะ : ติดตาม</p>
												@endif
											@else
												<h5 class="font-size-12 mb-1"><a role="button" class="text-secondary fst-italic text-opacity-50">ไม่พบข้อมูล</a></h5>
											@endif
										</td>
										<td class="text-center">
											{{-- @$item->DataCusToDataAsset->Vehicle_OldLicense --}}
											@if( count(@$item->DataCusToDataAsset) > 0 )
												@foreach(@$item->DataCusToDataAsset as $key => $value)
													<div>
														<span class="text-dark text-center">{{$value->Vehicle_OldLicense}}</span>
													</div>
												@endforeach
											@else
												-
											@endif
										</td>
										<td class="text-center">
											<ul class="list-inline font-size-20 contact-links mb-0">
												<li class="list-inline-item px-2 d-flex">
													<a href="{{ route('cus.index') }}?page={{ 'profile-cus' }}&id={{ @$item->id }}" title="Profile" class=""><i class="bx bx-user-circle hover-up text-warning bg-soft me-1"></i></a>
													{{-- @if (@$pageUrl == 'customer')
														<a href="{{ route('cus.index') }}?type={{ 1 }}&id={{ @$row->id }}" title="Profile"><i class="bx bx-user-circle hover-up text-warning bg-soft"></i></a>
													@else
														<a href="" title="Profile"><i class="bx bx-user-circle hover-up"></i></a>
													@endif --}}

													@if (@$flagTab == 'add-Guaran')
														<a type="button" class="selectGuaran" idCus="{{ @$item->id }}" title="Guaran"><i class="bx bx-check-square hover-up text-success bg-soft"></i></a>
													@elseif (@$flagTab == 'add-Payee')
														@if( @$item->Type_Card =='324003')
															@if((@$item->IDCard_cus == null))
																<a type="button" class="" data-bs-toggle="dropdown" aria-expanded="false">
																	<i class="bx bx-error-circle text-danger bg-soft iconCus" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" data-bs-title="<p class='fw-semibold mb-0'> <i class='bx bx-error-circle'></i> ข้อมูลไม่ครบ ! </p>" data-bs-custom-class="dataSearch-popover" data-bs-content="
																		<div class='row'>
																			<div class='col-6 fs-6 fw-semibold'>เลขบัตรปชช.</div>
																			<div class='col-6 text-end'> <i class='fs-5 {{ @$item->IDCard_cus == null ? 'bx bx-x-circle text-danger' : 'bx bx-check-circle text-success' }}'></i> </div>
																			<div class='col-12 fs-6 text-center text-danger fw-semibold border-top border-light py-2 bg-light'><i class='bx bx-bulb'></i> เพิ่มข้อมูลให้ครบถ้วนก่อนทำการเลือก</div>
																		</div>">
																	</i>
																</a>
															@else
																{{-- เคสปกติ --}}
																<span class="content-payee">
																	<a type="button" class="selectPayee" idCus="{{ @$item->id }}" status_Payee = "Payee"><i class="bx bx-check-square hover-up text-success bg-soft iconCus"></i> </a>
																</span>
																{{-- เคสรีไฟแนนซ์ --}}
																<div class="dropstart content-payeeRe">
																	<a type="button" class=""  title="Payee"  data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-check-square hover-up text-success bg-soft iconCus"></i></a>
																	<ul class="dropdown-menu" style="z-index:9999;">
																		<li><a class="dropdown-item selectPayee" idCus="{{ @$item->id }}" status_Payee = "CloseAcount" href="#">ปิดบัญชี</a></li>
																		<li><a class="dropdown-item selectPayee" idCus="{{ @$item->id }}" status_Payee = "Payee" href="#">ผู้รับเงิน</a></li>
																	</ul>
																</div>
																{{-- เคสปรับโครงสร้าง --}}
																<span class="content-cus0009">
																	<a type="button" class="selectPayee" idCus="{{ @$item->id }}" status_Payee = "CloseAcount"><i class="bx bx-check-square hover-up text-success bg-soft iconCus"></i> </a>
																</span>
															@endif
														@else
															@if((@$item->IDCard_cus == null || @$item->Name_Account == null || @$item->Number_Account == null))
																<a type="button" class="" data-bs-toggle="dropdown" aria-expanded="false">
																	<i class="bx bx-error-circle text-danger bg-soft iconCus" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" data-bs-title="<p class='fw-semibold mb-0'> <i class='bx bx-error-circle'></i> ข้อมูลไม่ครบ ! </p>" data-bs-custom-class="dataSearch-popover" data-bs-content="
																		<div class='row'>
																			<div class='col-6 fs-6 fw-semibold'>เลขบัตรปชช.</div>
																			<div class='col-6 text-end'> <i class='fs-5 {{ @$item->IDCard_cus == null ? 'bx bx-x-circle text-danger' : 'bx bx-check-circle text-success' }}'></i> </div>
																			<div class='col-6 fs-6 fw-semibold'>ธนาคาร</div>
																			<div class='col-6 text-end'> <i class='fs-5 {{ @$item->Name_Account == null ? 'bx bx-x-circle text-danger' : 'bx bx-check-circle text-success' }}'></i> </div>
																			<div class='col-6 fs-6 fw-semibold'>เลขบัญชี</div>
																			<div class='col-6 text-end'> <i class='fs-5 mb-1 {{ @$item->Number_Account == null ? 'bx bx-x-circle text-danger' : 'bx bx-check-circle text-success' }}'></i> </div>
																			<div class='col-12 fs-6 text-center text-danger fw-semibold border-top border-light py-2 bg-light'><i class='bx bx-bulb'></i> เพิ่มข้อมูลให้ครบถ้วนก่อนทำการเลือก</div>
																		</div>">
																	</i>
																</a>
																@else
																	{{-- เคสปกติ --}}
																	<span class="content-payee">
																		<a type="button" class="selectPayee" idCus="{{ @$item->id }}" status_Payee = "Payee"><i class="bx bx-check-square hover-up text-success bg-soft iconCus"></i> </a>
																	</span>
																	{{-- เคสรีไฟแนนซ์ --}}
																	<div class="dropstart content-payeeRe">
																		<a type="button" class=""  title="Payee"  data-bs-toggle="dropdown" aria-expanded="false"><i class="bx bx-check-square hover-up text-success bg-soft iconCus"></i></a>
																		<ul class="dropdown-menu" style="z-index:9999;">
																			<li><a class="dropdown-item selectPayee" idCus="{{ @$item->id }}" status_Payee = "CloseAcount" href="#">ปิดบัญชี</a></li>
																			<li><a class="dropdown-item selectPayee" idCus="{{ @$item->id }}" status_Payee = "Payee" href="#">ผู้รับเงิน</a></li>
																		</ul>
																	</div>
																	{{-- เคสปรับโครงสร้าง --}}
																	{{-- <span class="content-cus0009">
																		<a type="button" class="selectPayee" idCus="{{ @$item->id }}" status_Payee = "CloseAcount"><i class="bx bx-check-square hover-up text-info bg-soft iconCus"></i> </a>
																	</span> --}}
															@endif
																{{-- แสดงตอนโหลด --}}
																<a type="button" class="loadCusCon" style="display: none;"><i class="bx bxs-hourglass-top text-secondary bg-soft bx-tada"></i> </a>
														@endif
													@elseif (@$flagTab == 'add-Broker')
														@if (@$item->IDCard_cus == null || @$item->Name_Account == null || @$item->Number_Account == null)
															<a type="button" class="">
																<i class="bx bx-error-circle text-danger bg-soft" data-bs-toggle="popover" data-bs-placement="top" data-bs-trigger="hover" data-bs-title="<p class='fw-semibold mb-0'> <i class='bx bx-error-circle'></i> ข้อมูลไม่ครบ ! </p>" data-bs-custom-class="dataSearch-popover" data-bs-content="
																	<div class='row'>
																		<div class='col-6 fs-6 fw-semibold'>เลขบัตรปชช.</div>
																		<div class='col-6 text-end'> <i class='fs-5 {{ @$item->IDCard_cus == null ? 'bx bx-x-circle text-danger' : 'bx bx-check-circle text-success' }}'></i> </div>
																		<div class='col-6 fs-6 fw-semibold'>ธนาคาร</div>
																		<div class='col-6 text-end'> <i class='fs-5 {{ @$item->Name_Account == null ? 'bx bx-x-circle text-danger' : 'bx bx-check-circle text-success' }}'></i> </div>
																		<div class='col-6 fs-6 fw-semibold'>เลขบัญชี</div>
																		<div class='col-6 text-end'> <i class='fs-5 mb-1 {{ @$item->Number_Account == null ? 'bx bx-x-circle text-danger' : 'bx bx-check-circle text-success' }}'></i> </div>
																		<div class='col-12 fs-6 text-center text-danger fw-semibold border-top border-light py-2 bg-light'><i class='bx bx-bulb'></i> เพิ่มข้อมูลให้ครบถ้วนก่อนทำการเลือก</div>
																	</div>">
																</i>
															</a>
														@else
															<a type="button" class="selectBroker" data-t="{{ $item }}" idCus="{{ @$item->id }}" title="Broker"><i class="bx bx-check-square hover-up text-success bg-soft iconCus"></i></a>
															<a type="button" class="loadCusCon" style="display: none;"><i class="bx bxs-hourglass-top text-secondary bg-soft bx-tada"></i> </a>
														@endif
													@endif
												</li>
											</ul>
										</td>
									</tr>
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

											<p class="text-muted font-size-14 mb-4">ไม่พบข้อมูลที่ค้นหา โปรดตรวจสอบความถูกต้องอีกครั้ง หรือกดปุ่มเพื่อเพิ่ม <span class="text-primary">ลูกค้าใหม่.</span></p>
											<a href="{{ route('view.index') }}?page={{ 'new-cus' }}">
												<button type="button" class="btn btn-success btn-rounded w-lg w-75 waves-effect waves-light">ลูกค้าใหม่</button>
											</a>

									</div>
								</div>
							</div>
						</div>
					@endif
				</div>
			@elseif(@$typeSr == 'contract')
				<div class="table-responsive" data-simplebar="init" style="max-height: 420px;  min-height : 420px;">
					<table class="table align-middle table-nowrap text-nowrap table-hover">
						<thead class="table-light sticky-top text-center">
							<tr class="bg-light">
								<th class="text-center" style="width: 5%">#</th>
								<th class="text-center">เลขสัญญา</th>
								<th class="text-center">สถานะ</th>
								<th class="text-center">วันส่งสัญญา</th>
								<th class="text-center">ชื่อลูกค้า</th>
								<th class="text-center">ทะเบียน</th>
								<th class="text-center">ยอดจัด</th>
								<th class="text-center" style="width: 8%"></th>
							</tr>
						</thead>
						<tbody>
							@foreach (@$data as $row)
							<tr id="row{{ $row->id }}">
								<td class="text-center">
									<div class="d-flex justify-content-center">
										<div class="flex-shrink-0 me-3">
											<div class="avatar-xs">
												@if (!empty(@$row->image_cus))
													<img class="avatar-title rounded-circle" src="{{ URL::asset(@$row->image_cus) }}" alt="">
												@else
													<div class="avatar-title bg-primary text-primary bg-soft rounded-circle">
														{{ @$row->CodeLoan_Con }}
													</div>
												@endif
											</div>
										</div>
									</div>
								</td>
								<td>
									<h5 class="font-size-13 mb-1"><a role="button" class="text-dark">สัญญา : {{ @$row->Contract_Con }}</a></h5>
									@if (@$row->Status_Con == 'cancel')
										<span class="mb-0 badge badge-pill font-size-12 badge-soft-danger">สถานะ : ยกเลิกสัญญา</span>
									@else
										@if (!empty(@$row->ConfirmApp_Con))
											<span class="mb-0 badge badge-pill font-size-12 badge-soft-success">สถานะ : อนุมัติ</span>
										@else
											<span class="mb-0 badge badge-pill font-size-12 badge-soft-warning">สถานะ : รออนุมัติ</span>
										@endif
									@endif
								</td>
								<td class="text-center">
									@if (@$row->id_rateType != 'land' || @$row->id_rateType != 'person')
										<button type="button" class="btn {{empty(@$row->DateCheck_Bookcar)? 'btn-warning' : 'btn-success'}} btn-sm btn-rounded waves-effect waves-light" data-bs-toggle="tooltip" title="เช็คเล่มทะเบียน : {{empty(@$row->DateCheck_Bookcar)? 'No' : 'Yes'}}">
											<i class="mdi mdi-shield-car prem"></i>
										</button>
									@endif
									<button type="button" class="btn {{empty(@$row->DocApp_Con)? 'btn-warning' : 'btn-success'}} btn-sm btn-rounded waves-effect waves-light" data-bs-toggle="tooltip" title="ขออนุมัติ : {{empty(@$row->DocApp_Con)? 'No' : 'Yes'}}">
										<i class="mdi mdi-book-check-outline prem"></i>
									</button>
									<button type="button" class="btn {{empty(@$row->statusDoc)? 'btn-warning' : 'btn-success'}} btn-sm btn-rounded waves-effect waves-light" data-bs-toggle="tooltip" title="ตรวจสอบเอกสาร : {{empty(@$row->statusDoc)? 'No' : 'Yes'}}">
										<i class="bx bx-receipt prem"></i>
									</button>
								</td>
								<td class="text-center">{{ date('d-m-Y', strtotime($row->Date_con)) }}</td>
								<td> {{ @$row->Name_Cus }} </td>
								<td> {{ @$row->licence }} </td>
								<td class="text-end"> {{ number_format(@$row->cash, 0) }} </td>
								<td class="text-center">
									<ul class="list-inline font-size-18 contact-links mb-0">
										<li class="list-inline-item px-2">
											{{-- <div class="btn-group">
												<a type="button" class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" data-bs-toggle="tooltip" title="พิมพ์">
													<i class="bx bxs-printer hover-up text-info bg-soft"></i>
												</a>
												<div class="dropdown-menu">
													<a class="dropdown-item" href="{{ route('report.create') }}?report={{'PaymentForm'}}&id={{@$row->id}}" target="_blank"><i class="bx bx-customize"></i> Payments</a>
													<a class="dropdown-item" href="{{ route('report.create') }}?report={{'ContractForm'}}&id={{@$row->id}}" target="_blank"><i class="bx bx-id-card"></i> ฟอร์มสัญญา</a>
												</div>
											</div> --}}
											<a href="{{ route('contract.edit', $row->id) }}?funs={{'contract'}}&loanCode={{ @$row->CodeLoan_Con }}" data-bs-toggle="tooltip" title="รายละเอียดสัญญา">
												<i class="bx bx-fridge hover-up text-warning bg-soft"></i>
											</a>
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
		<!-- btn add customers -->
		@if (count($data) != 0)
			<div class="modal-foter">
				<div class="p-2 chat-input-section">
					<div class="float-end mb-1">
							<a href="{{ route('view.index') }}?page={{ 'new-cus' }}" class="btn btn-success btn-rounded btn-sm w-md waves-effect waves-light">
								<i class="bx bx-plus"></i> เพิ่มลูกค้าใหม่
							</a>
					</div>
				</div>
			</div>
		@endif
	</form>
</div>

<input type="hidden" class="flagTab" value="{{ @$flagTab }}">

<div class="modal-content guaran-modal" style="display:none;">
		<div id="guaran-content"></div>
</div>

<script>
	$(function(){
		let arrTypeCus = ['CUS-0004','CUS-0005','CUS-0006'];
		let arrCus0009 = ['CUS-0009'];
		let TypeCus = sessionStorage.getItem('TypeCus')

		if(arrCus0009.includes(TypeCus) == true){
			$('.content-cus0009').show();
			$('.content-payeeRe').hide();
			$('.content-payee').hide();
		}else{
			if(arrTypeCus.includes(TypeCus) == true){
				$('.content-cus0009').hide();
				$('.content-payeeRe').show();
				$('.content-payee').hide();

			}else {
				$('.content-cus0009').hide();
				$('.content-payeeRe').hide();
				$('.content-payee').show();
			}
		}


	})
</script>

<script>
	$('[data-bs-toggle="popover"]').popover({
		html: true,
		trigger: 'hover'
	})
</script>
{{-- กดเลือกผู้ค้ำ --}}
<script>
	$('.selectGuaran').click((evt) => {
		$('.selectGuaran').prop('disabled', true)
		const idCus = $(evt.currentTarget).attr('idCus');
		$.ajax({
			url: '{{ route('contract.show', 0) }}',
			type: 'GET',
			data: {
				type: 'GuaranInfo',
				idCus: idCus,
				_token: '{{ @csrf_token() }}'
			},
			success: (res) => {
				$('.selectGuaran').prop('disabled', false)

				$('.main-modal').toggle(500);
				$('.guaran-modal').toggle(500);
				console.log(res);
				$('#guaran-content').html(res.html)
			},
			error: (err) => {
				$('.selectGuaran').prop('disabled', false)



			},
		})
	})
</script>
