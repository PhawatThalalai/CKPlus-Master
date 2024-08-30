<div class="topnav " style="font-family: 'Prompt', sans-serif;">
	<div class="container-fluid">
		<nav class="navbar navbar-light navbar-expand-lg topnav-menu">
			<div class="collapse navbar-collapse active" id="topnav-menu-content">
				@php
					if (!empty($__env->yieldContent('page-backend'))) {
					    $typeLoan = \App\Models\TB_Constants\TB_Frontend\TB_TypeLoanCom::generateQuery();
					    $loantype = [];
					    foreach ($typeLoan as $loan) {
					        $loantype[$loan->Loan_Code] = $loan->Loan_Group;
					    }
					}
				@endphp

				@if (!empty($__env->yieldContent('page-backend')))
					<ul class="navbar-nav active">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle arrow-none @yield('trackcus-active')" href="#" id="trackcus" role="button">
								<i class="bx bx-book-content me-1"></i><span key="t-layouts">ข้อมูลประจำวัน</span>
								<div class="arrow-down"></div>
							</a>
							<div class="dropdown-menu" aria-labelledby="report-legis">
								<div class="dropdown">
									<a class="dropdown-item dropdown-toggle arrow-none" href="#" id="topnav-layout-hori" role="button">
										<span key="t-horizontal">รายการลูกค้า</span>
										<div class="arrow-down"></div>
									</a>
									<div class="dropdown-menu" aria-labelledby="topnav-layout-hori">
										<a href="{{ route('view.index') }}?page={{ 'walkin-cus' }}" key="Track-01" class="@yield('viewcus-active') dropdown-item d-flex align-items-center">
											รายการ รับลูกค้า
										</a>
										<a href="{{ route('view.index') }}?page={{ 'PP-Lead' }}" key="Track-04" class="@yield('PP-Lead-active') dropdown-item d-flex align-items-center">
											รายการ ลูกค้าออนไลน์ (PP)
										</a>
										<a href="{{ route('view.index') }}?page={{ 'tracking-cus' }}" key="Track-02" class="@yield('Track02-active') dropdown-item d-flex align-items-center">
											รายการ ติดตามลูกค้า
										</a>
										<a href="{{ route('view.index') }}?page={{ 'tracking-gm' }}" key="Track-03" class="@yield('Track03-active') dropdown-item d-flex align-items-center">
											รายการ ติดตามส่ง GM
										</a>
									</div>
								</div>
								<div class="dropdown">
									<a href="{{ route('view.index') }}?page={{ 'brokers' }}" key="t-default" class=" @yield('broker-active') dropdown-item d-flex align-items-center">
										<span key="t-layouts">รายการ ผู้แนะนำ
									</a>
								</div>
								<div class="dropdown">
									<a href="{{ route('view.index') }}?page={{ 'assets' }}" key="t-default" class="@yield('data-asset-active') dropdown-item d-flex align-items-center">
										<span key="t-layouts">รายการ ทรัพย์สิน</span>
									</a>
								</div>
							</div>
						</li>

						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle arrow-none  @yield('datacus-active')" href="#" id="datacus" role="button">
								<i class="mdi mdi-account-circle me-1"></i><span key="t-layouts">ระบบ ฐานลูกค้า</span>
								<div class="arrow-down"></div>
							</a>
							<div class="dropdown-menu" aria-labelledby="datacus">
								<div class="dropdown">
									<a href="{{ route('view.index') }}?page={{ 'profile-cus' }}" key="t-cus" class="@yield('cus-active') dropdown-item d-flex align-items-center">
										ข้อมูลลูกค้า
									</a>
									@hasrole(['administrator', 'superadmin'])
										<a href="{{ route('view.index') }}?page={{ 'new-cus' }}" key="t-newcus" class="@yield('newcus-active') dropdown-item d-flex align-items-center">
											สร้างลูกค้าใหม่
										</a>
									@endhasrole
								</div>
							</div>
						</li>

						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle arrow-none  @yield('assets-active')" href="{{ route('view.index') }}?page={{ 'data-assets' }}" id="assets" role="button">
								<i class="mdi mdi-database me-1"></i><span key="t-layouts">ระบบ ฐานทรัพย์</span>
							</a>
						</li>

						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle arrow-none" href="#" id="approved-loan" role="button">
								<i class="mdi mdi-book-check me-1"></i><span key="t-layouts">ระบบ อนุมัติสินเชือ</span>
								<div class="arrow-down"></div>
							</a>
							<div class="dropdown-menu" aria-labelledby="approved-loan">
								<div class="dropdown">
									<a class="dropdown-item dropdown-toggle arrow-none @yield('2-active')" href="#" id="loan-HP" role="button">
										<span key="t-horizontal">สินเชื่อ เช่าซื้อ</span>
										<div class="arrow-down"></div>
									</a>
									<div class="dropdown-menu" aria-labelledby="loan-HP">
										@foreach (@$typeLoan as $loan)
											@if (@$loan->Loan_Group == 1)
												<a href="{{ route('view.index') }}?page={{ 'approve-loans' }}&loanCode={{ @$loan->Loan_Code }}" key="{{ @$loan->Loan_Code }}" class="@yield(@$loan->id_rateType . @$loan->Loan_Code . '-active') dropdown-item d-flex align-items-center">
													({{ @$loan->Loan_Code }})
													{{ @$loan->Loan_Name }}
												</a>
											@endif
										@endforeach
									</div>
								</div>
								<div class="dropdown">
									<a class="dropdown-item dropdown-toggle arrow-none @yield('1-active')" href="#" id="loan-PSL" role="button">
										<span key="t-email">สินเชื่อ เงินกู้</span>
										<div class="arrow-down"></div>
									</a>
									<div class="dropdown-menu" aria-labelledby="topnav-email">
										<div class="dropdown">
											<a class="dropdown-item dropdown-toggle arrow-none @yield('12-active')" href="#" id="P-loan" role="button">
												<span key="t-email-templates">สินเชื่อเงินกู้ PLoan</span>
												<div class="arrow-down"></div>
											</a>
											<div class="dropdown-menu" aria-labelledby="P-loan">
												@foreach (@$typeLoan as $loan)
													@if (@$loan->Loan_Group == 2)
														<a href="{{ route('view.index') }}?page={{ 'approve-loans' }}&loanCode={{ @$loan->Loan_Code }}" key="{{ @$loan->Loan_Code }}" class="@yield(@$loan->id_rateType . @$loan->Loan_Code . '-active') dropdown-item d-flex align-items-center">
															({{ @$loan->Loan_Code }})
															{{ @$loan->Loan_Name }}
														</a>
													@endif
												@endforeach
											</div>
										</div>
										<div class="dropdown">
											<a class="dropdown-item dropdown-toggle arrow-none @yield('13-active')" href="#" id="Micro" role="button">
												<span key="t-email-templates">สินเชื่อเงินกู้ Micro</span>
												<div class="arrow-down"></div>
											</a>
											<div class="dropdown-menu" aria-labelledby="Micro">
												@foreach (@$typeLoan as $loan)
													@if (@$loan->Loan_Group == 3)
														<a href="{{ route('view.index') }}?page={{ 'approve-loans' }}&loanCode={{ @$loan->Loan_Code }}" key="{{ @$loan->Loan_Code }}" class="@yield(@$loan->id_rateType . @$loan->Loan_Code . '-active') dropdown-item d-flex align-items-center">
															({{ @$loan->Loan_Code }})
															{{ @$loan->Loan_Name }}
														</a>
													@endif
												@endforeach
											</div>
										</div>
									</div>
								</div>

							</div>
						</li>

						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle arrow-none @yield('Checkerloans-active')" href="#" id="auditsDoc" role="button">
								<i class="mdi mdi-clipboard-check-multiple me-1"></i><span key="t-layouts">ระบบ ตรวจสอบสินเชื่อ</span>
								<div class="arrow-down"></div>
							</a>

							<div class="dropdown-menu" aria-labelledby="auditsDoc">

								<div class="dropdown">
									<a class="dropdown-item dropdown-toggle arrow-none @yield('adBranch-active')" href="#" id="document" role="button">
										<span key="t-horizontal">รายการเอกสาร</span>
										<div class="arrow-down"></div>
									</a>
									<div class="dropdown-menu" aria-labelledby="document">
										<a href="{{ route('view.index') }}?page={{ 'sendoffice' }}" key="t-default" class="@yield('sendoffice-active') dropdown-item d-flex align-items-center">
											เอกสาร รอนำส่ง
										</a>
										<a href="{{ route('view.index') }}?page={{ 'rejectDocs' }}" key="t-new" class="@yield('rejectDocs-active') dropdown-item d-flex align-items-center">
											เอกสาร ไม่สมบูรณ์
										</a>
									</div>
								</div>
								<div class="dropdown">
									<a class="dropdown-item dropdown-toggle arrow-none @yield('audit-active')" href="#" id="audit" role="button">
										<span key="t-horizontal">รายการตรวจสอบ</span>
										<div class="arrow-down"></div>
									</a>
									<div class="dropdown-menu" aria-labelledby="audit">
										<a href="{{ route('view.index') }}?page={{ 'credit-loans' }}" key="t-default" class="@yield('credit-loans-active') dropdown-item d-flex align-items-center">
											เอกสาร ตรวจสอบ
										</a>
										<a href="{{ route('view.index') }}?page={{ 'data-warehoure' }}" key="t-new" class="@yield('data-warehoure-active') dropdown-item d-flex align-items-center">
											เอกสาร เข้าเซฟ
										</a>
									</div>
								</div>
								<div class="dropdown">
									<a href="{{ route('view.index') }}?page={{ 'rejectedPA' }}" key="t-default" class=" @yield('navPa-active') dropdown-item d-flex align-items-center">
										<span key="t-layouts">รายการ แก้ไข PA
									</a>
								</div>
							</div>
						</li>

						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle arrow-none @yield('financial-approval-active')" href="{{ route('view.index') }}?page={{ 'financial-approval' }}" id="financial-approval" role="button">
								<i class="mdi mdi-cash-usd me-1"></i><span key="t-layouts">ระบบ การเงิน</span>
							</a>
						</li>

						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle arrow-none" id="financial-approval" role="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop">
								<i class="mdi mdi-file-document-multiple me-1"></i><span key="t-layouts">ระบบ รายงาน</span>
							</a>
						</li>
					</ul>
				@elseif(!empty($__env->yieldContent('page-frontend')))
					<ul class="navbar-nav active">
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle arrow-none @yield('page-backend')" href="#" id="topnav-dashboard" role="button">
								<i class="mdi mdi-briefcase-account me-1"></i><span key="t-dashboards">ระบบการ์ดลูกหนี้</span>
								<div class="arrow-down"></div>
							</a>
							<div class="dropdown-menu" aria-labelledby="topnav-dashboard">
								<a href="{{ route('view-backend.index') }}?page={{ 'create-cont' }}" class="@yield('center-p1-active') dropdown-item d-flex align-items-center" key="t-Jobs">
									<i class="bx bxs-user-plus me-1"></i>
									สร้างการ์ดลูกหนี้
								</a>
								<a href="{{ route('view-backend.index') }}?page={{ 'contract' }}" class="@yield('contract-p1-active') dropdown-item d-flex align-items-center" key="t-Jobs">
									<i class="bx bxs-user-circle me-1"></i>
									สอบถามข้อมูลลูกหนี้
								</a>
							</div>
						</li>

						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle arrow-none @yield('datatrack-active')" href="#" id="datatrack" role="button">
								<i class="mdi mdi-account-circle me-1"></i><span key="t-layouts">ระบบลูกหนี้</span>
								<div class="arrow-down"></div>
							</a>
							<div class="dropdown-menu" aria-labelledby="datatrack">
								<div class="dropdown">
									<a href="{{ route('view-backend.index') }}?page={{ 'track-follow-up' }}" class="@yield('datatrack-p4-active') dropdown-item d-flex align-items-center" style="cursor:pointer">
										บันทึกติดตามลูกหนี้
									</a>
								</div>
								<div class="dropdown">
									<a class="dropdown-item dropdown-toggle arrow-none @yield('datatrack-p1-active') @yield('datatrack-p2-active') @yield('datatrack-p3-active')" href="#" id="manage-cus" role="button">
										<span key="t-horizontal">ระบบจัดการลูกหนี้</span>
										<div class="arrow-down"></div>
									</a>
									<div class="dropdown-menu" aria-labelledby="manage-cus">
										<a href="{{ route('view-backend.index') }}?page={{ 'track-create-task' }}" class="@yield('datatrack-p1-active') dropdown-item d-flex align-items-center">
											บันทึกแบ่งกลุ่มลูกหนี้
										</a>
										<div class="dropdown">
											<a class="dropdown-item dropdown-toggle arrow-none @yield('datatrack')" href="#" id="datatrack" role="button">
												<span key="t-horizontal">รายการแบ่งกลุ่มลูกหนี้</span>
												<div class="arrow-down"></div>
											</a>
											<div class="dropdown-menu" aria-labelledby="datatrack">
												<a href="{{ route('view-backend.index') }}?page={{ 'track-list-call' }}" key="t-level-2-1" class="@yield('datatrack-p2-active') dropdown-item d-flex align-items-center">
													รายการกลุ่มงานโทร
												</a>
												<a href="{{ route('view-backend.index') }}?page={{ 'track-list-follow' }}" key="t-level-2-2" class="@yield('datatrack-p3-active') dropdown-item d-flex align-items-center">
													รายการกลุ่มงานตาม
												</a>
											</div>
										</div>
										{{-- <a href="" key="t-level-2-2" class="dropdown-item">บันทึกส่งจดหมาย
										</a>
										<a href="" key="t-level-2-2" class="dropdown-item">บันทึกตอบกลับจดหมาย
										</a> --}}
									</div>
								</div>
								<div class="dropdown">
									<a class="dropdown-item dropdown-toggle arrow-none @yield('datatrack-active')" href="#" id="manage-cus" role="button">
										<span key="t-horizontal">ระบบขอเบิกเอกสาร</span>
										<div class="arrow-down"></div>
									</a>
									<div class="dropdown-menu" aria-labelledby="manage-cus">
										<a href="{{ route('view-backend.index') }}?page={{ 'take-document' }}" class="@yield('datatrack-p1-active') dropdown-item d-flex align-items-center">
											ขอเบิกเอกสาร
										</a>
										<div class="dropdown">
											<a class="dropdown-item dropdown-toggle arrow-none" href="#" id="datatrack" role="button">
												<span key="t-horizontal">รายการขอเบิกเอกสาร</span>
												<div class="arrow-down"></div>
											</a>
											<div class="dropdown-menu" aria-labelledby="datatrack">
												<a href="{{ route('view-backend.index') }}?page={{ 'list-take-doc' }}" key="t-level-2-1" class="@yield('datatrack-p2-active') dropdown-item d-flex align-items-center">
													รายการขอเบิกเอกสาร
												</a>
												<a href="{{ route('view-backend.index') }}?page={{ 'process-document' }}" class="@yield('datatrack-p1-active') dropdown-item d-flex align-items-center">
													ติดตามลการเบิกเอกสาร
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</li>

						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle arrow-none @yield('payments-active')" href="#" id="payments" role="button">
								<i class="bx bx-layout me-2"></i><span key="t-layouts">ระบบการเงิน</span>
								<div class="arrow-down"></div>
							</a>
							<div class="dropdown-menu" aria-labelledby="payments">
								<div class="dropdown">
									<a href="{{ route('view-backend.index') }}?page={{ 'payments' }}" class="@yield('payments-paydue-active') dropdown-item d-flex align-items-center">
										รับชำระค่างวด
									</a>
									<a href="{{ route('view-backend.index') }}?page={{ 'cn-pays' }}" class="@yield('payments-cancel-active') dropdown-item d-flex align-items-center">
										ยกเลิกใบรับค่างวด
									</a>
								</div>
								<div class="dropdown">
									<a class="dropdown-item dropdown-toggle arrow-none @yield('payments-auto-active')" href="#" id="autopayments" role="button">
										<span key="t-horizontal">ระบบตัดเงินอัตโมนัติ</span>
										<div class="arrow-down"></div>
									</a>
									<div class="dropdown-menu" aria-labelledby="autopayments">
										<a href="{{ route('view-backend.index') }}?page={{ 'imp-pays' }}" class="@yield('importpay-active') dropdown-item d-flex align-items-center">
											นำเข้าไฟล์
										</a>
										<a href="{{ route('view-backend.index') }}?page={{ 'imp-payslist' }}" class="@yield('autopaylist-active') dropdown-item d-flex align-items-center">
											รายการนำเข้า
										</a>
										<a href="{{ route('view-backend.index') }}?page={{ 'imp-autopayment' }}" class="@yield('autopayment-active') dropdown-item d-flex align-items-center">
											รายการเตรียมชำระ
										</a>
									</div>
								</div>
							</div>
						</li>

						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle arrow-none @yield('account-active')" href="#" id="account" role="button">
								<i class="bx bx-layout me-2"></i><span key="t-layouts">ระบบบัญชี</span>
								<div class="arrow-down"></div>
							</a>
							<div class="dropdown-menu" aria-labelledby="account">
								<div class="dropdown">
									<a class="dropdown-item dropdown-toggle arrow-none @yield('account-sub1-active')" href="#" id="account-sub1" role="button">
										<span key="t-horizontal">ระบบรับรู้รายได้ลูกหนี้</span>
										<div class="arrow-down"></div>
									</a>
									<div class="dropdown-menu" aria-labelledby="account-sub1">
										<a href="{{ route('view-backend.index') }}?page={{ 'stopcont-vats' }}" class="@yield('account-p1-active') dropdown-item d-flex align-items-center">
											บันทึกหยุดรับรู้รายได้ตามดิว
										</a>
										<a href="{{ route('view-backend.index') }}?page={{ 'summarize-vats' }}" class="@yield('account-p2-active') dropdown-item d-flex align-items-center">
											สอบถามหยุดรับรู้รายได้ตามดิว
										</a>
									</div>
								</div>
								<div class="dropdown">
									<a class="dropdown-item dropdown-toggle arrow-none @yield('account-sub2-active')" href="#" id="account-sub2" role="button">
										<span key="t-horizontal">ระบบลูกหนี้เพื่อบัญชี</span>
										<div class="arrow-down"></div>
									</a>
									<div class="dropdown-menu" aria-labelledby="account-sub2">
										<a href="{{ route('view-backend.index') }}?page={{ 'view-seized' }}" class="@yield('account-p3-active') dropdown-item d-flex align-items-center">
											บันทึกยึดรถรอไถ่ถอน
										</a>
										<a href="{{ route('view-backend.index') }}?page={{ 'veh-confiscation' }}" class="@yield('account-p4-active') dropdown-item d-flex align-items-center">
											บันทึกยึดตัดทำขาย
										</a>
										<a href="{{ route('view-backend.index') }}?page={{ 'bad-debt' }}" class="@yield('account-p5-active') dropdown-item d-flex align-items-center">
											บันทึกรายการหนี้สูญ
										</a>
										<a href="{{ route('view-backend.index') }}?page={{ 'terminate-letter' }}" class="@yield('account-p6-active') dropdown-item d-flex align-items-center">
											บันทึกหนังสือยืนยันบอกเลิก
										</a>
										<a href="{{ route('view-backend.index') }}?page={{ 'renew-contract' }}" class="@yield('account-p7-active') dropdown-item d-flex align-items-center">
											บันทึกต่อสัญญาขายฝาก
										</a>
									</div>
								</div>
							</div>
						</li>

						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle arrow-none @yield('tax-active')" href="#" id="taxs" role="button">
								<i class="mdi mdi-account-circle me-1"></i><span key="t-layouts">ระบบภาษี</span>
								<div class="arrow-down"></div>
							</a>
							<div class="dropdown-menu" aria-labelledby="taxs">
								<div class="dropdown">
									<a href="{{ route('view-backend.index') }}?page={{ 'invoice-normal' }}" class="@yield('tax-sub1-active') dropdown-item d-flex align-items-center">
										ออกใบกำกับค่างวดปกติ
									</a>
									<a href="{{ route('view-backend.index') }}?page={{ 'invoice-before' }}" class="@yield('tax-sub2-active') dropdown-item d-flex align-items-center">
										ออกใบกำกับค่างวดก่อนดิว
									</a>
								</div>
							</div>
						</li>

						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle arrow-none @yield('report-active')" href="#" id="reports" role="button">
								<i class="bx bx-home-circle me-2"></i><span key="t-dashboards">ระบบรายงาน</span>
								<div class="arrow-down"></div>
							</a>
							<div class="dropdown-menu" aria-labelledby="reports">
								<div class="dropdown">
									<a class="dropdown-item dropdown-toggle arrow-none @yield('report-sub1-active')" href="#" id="report-sub1" role="button">
										<span key="t-horizontal">รายงานการเงิน</span>
										<div class="arrow-down"></div>
									</a>
									<div class="dropdown-menu" aria-labelledby="report-sub1">
										<a href="javascript: void(0);" key="t-level-1" class="@yield('report-p1-active') dropdown-item d-flex align-items-center modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('ReportAcc.index') }}?form={{ 'Account' }}&report={{ 'Payment' }}&reportTitle={{ 'รายงานการรับชำระ' }}">
											รายงานการรับชำระ
										</a>
									</div>
								</div>
								<div class="dropdown">
									<a class="dropdown-item dropdown-toggle arrow-none @yield('report-sub2-active')" href="#" id="report-sub2" role="button">
										<span key="t-horizontal">รายงานทางบัญชี</span>
										<div class="arrow-down"></div>
									</a>
									<div class="dropdown-menu" aria-labelledby="report-sub2">
										<a href="javascript: void(0);" key="t-level-1" class="@yield('report-p1-active') dropdown-item d-flex align-items-center modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('ReportAcc.index') }}?form={{ 'Account' }}&report={{ 'ApproveLoan' }}">
											รายงานการทำสัญญา
										</a>
										<a href="javascript: void(0);" key="t-level-1" class="@yield('report-p1-active') dropdown-item d-flex align-items-center modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('ReportAcc.index') }}?form={{ 'Account' }}&report={{ 'ArReport' }}&reportTitle={{ 'รายงานลูกหนี้คงเหลือ' }}">
											รายงานลูกหนี้คงเหลือ
										</a>
										<a href="javascript: void(0);" key="t-level-1" class="@yield('report-p1-active') dropdown-item d-flex align-items-center modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('ReportAcc.index') }}?form={{ 'Account' }}&report={{ 'outstanding' }}&reportTitle={{ 'รายงานลูกหนี้' }}">
											รายงานลูกหนี้
										</a>
										<a href="javascript: void(0);" key="t-level-1" class="@yield('report-p1-active') dropdown-item d-flex align-items-center modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('ReportAcc.index') }}?form={{ 'Account' }}&report={{ 'profit' }}&reportTitle={{ 'รายงานกำไรตามวันครบกำหนดชำระ' }}">
											รายงานกำไรตามวันครบกำหนดชำระ
										</a>
										<a href="javascript: void(0);" key="t-level-1" class="@yield('report-p1-active') dropdown-item d-flex align-items-center modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('ReportAcc.index') }}?form={{ 'Account' }}&report={{ 'ApproveLoan' }}">
											รายงานกำไรตามวันที่รับเงิน
										</a>
										<a href="javascript: void(0);" key="t-level-1" class="@yield('report-p1-active') dropdown-item d-flex align-items-center modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('ReportAcc.index') }}?form={{ 'Account' }}&report={{ 'profit' }}&reportTitle={{ 'รายงานกำไรคงเหลือ' }}">
											รายงานกำไรคงเหลือ
										</a>
										<a href="javascript: void(0);" key="t-level-2" class="@yield('report-p2-active') dropdown-item d-flex align-items-center modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('ReportAcc.index') }}?form={{ 'Account' }}&report={{ 'Debtor' }}&reportTitle={{ 'รายงานลูกหนี้หยุดรับรู้รายได้' }}">
											รายงานลูกหนี้หยุดรับรู้รายได้
										</a>
									</div>

								</div>
								<div class="dropdown">
									<a class="dropdown-item dropdown-toggle arrow-none @yield('report-track-active')" href="#" id="report-sub3" role="button">
										<span key="t-horizontal">รายงานลูกหนี้</span>
										<div class="arrow-down"></div>
									</a>
									<div class="dropdown-menu" aria-labelledby="report-sub3">
										<a href="{{ route('view-backend.index') }}?page={{ 'daily' }}" class="@yield('report-track-daily') dropdown-item d-flex align-items-cente">
											รายงาน Daily
										</a>
										<a href="{{ route('view-backend.index') }}?page={{ 'monthly' }}" class="@yield('report-track-monthly') dropdown-item d-flex align-items-cente">
											รายงาน Monthly
										</a>
										<a href="{{ route('view-backend.index') }}?page={{ 'printlet' }}" class="@yield('report-track-printlet') dropdown-item d-flex align-items-cente">
											พิมพ์จดหมายลูกหนี้
										</a>
										<a href="{{ route('view-backend.index') }}?page={{ 'savePrintlet' }}" class="@yield('report-track-savePrintlet') dropdown-item d-flex align-items-cente">
											บันทึกส่งจดหมาย
										</a>
										<a href="{{ route('view-backend.index') }}?page={{ 'billing-stmt' }}" class="@yield('report-track-billstmt') dropdown-item d-flex align-items-cente">
											หนังสือแจ้งค่างวด
										</a>
										<a href="javascript: void(0);" key="t-level-2" class="@yield('report-p2-active') dropdown-item d-flex align-items-center modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('ReportAcc.index') }}?form={{ 'Account' }}&report={{ 'Store' }}&reportTitle={{ 'รายงานการจัดเก็บ' }}">
											รายงานการจัดเก็บ
										</a>
									</div>
								</div>
								<div class="dropdown">
									<a class="dropdown-item dropdown-toggle arrow-none @yield('report-tax-active')" href="#" id="report-sub3" role="button">
										<span key="t-horizontal">รายงานระบบภาษี</span>
										<div class="arrow-down"></div>
									</a>
									<div class="dropdown-menu" aria-labelledby="report-sub3">
										<a href="javascript: void(0);" key="t-level-2" class="@yield('report-p2-active') dropdown-item d-flex align-items-center modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('ReportAcc.index') }}?form={{ 'Account' }}&report={{ 'Normaltax' }}&reportTitle={{ 'รายงานภาษีขายยื่นปกติ' }}">
											รายงานภาษีขายยื่นปกติ
										</a>
										<a href="javascript: void(0);" key="t-level-2" class="@yield('report-p2-active') dropdown-item d-flex align-items-center modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('ReportAcc.index') }}?form={{ 'Account' }}&report={{ 'TaxSlip' }}&reportTitle={{ 'ใบกำกับภาษี' }}">
											ใบกำกับภาษี
										</a>
									</div>
								</div>
							</div>
						</li>
					</ul>
				@endif
			</div>
		</nav>
	</div>
</div>

{{-- offcanvas --}}
@if (!empty($__env->yieldContent('page-backend')))
	<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasWithBackdrop" aria-labelledby="offcanvasWithBackdropLabel">
		<div class="offcanvas-header">
			<h3 class="offcanvas-title" id="offcanvasWithBackdropLabel">รายงาน</h3>
			<button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
		</div>
		<div class="offcanvas-body">
			<li>
				<a href="#" class="title-topbar-menu">รายงานข้อมูลลูกค้า</a>
				<ul class="sub-topbar-menu" aria-expanded="false">
					<li>
						<a href="javascript: void(0);" class="modal_lg " data-toggle="modal" data-target="#modal_lg" data-link="{{ route('report.index') }}?form={{ 'Datacus' }}&report={{ 'tracking-cus' }}">1. รายงานรับลูกค้า</a>
					</li>
					<li>
						<a href="javascript: void(0);" class="modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('report.index') }}?form={{ 'Datacus' }}&report={{ 'monthlyCredo' }}">2. รายงานสรุปCredo</a>
					</li>

					{{-- <li>
						<a href="javascript: void(0);" class="modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('report.index') }}?form={{ 'Datacus' }}&report={{ 'ScoreCredo' }}">3.รายงานScoreCredo</a>
					</li> --}}
					<li>
						<a href="javascript: void(0);" class="modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('report.index') }}?form={{ 'Datacus' }}&report={{ 'monthlyPA' }}">3. รายงานสรุป PA</a>
					</li>

				</ul>
			</li>
			<li>
				<a href="#" class="title-topbar-menu">รายงานข้อมูลสินเชื่อ</a>
				<ul class="sub-topbar-menu" aria-expanded="false">
					<li>
						<a href="javascript: void(0);" class="modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('report.index') }}?form={{ 'Contract' }}&report={{ 'Approve' }}">1. รายงานอนุมัติสินเชื่อ</a>
					</li>
					<li>
						<a href="javascript: void(0);" class="modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('report.index') }}?form={{ 'Contract' }}&report={{ 'ReportCondate' }}">2. รายงานตามเลขที่สัญญา</a>
					</li>
					<li>
						<a href="javascript: void(0);" class="modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('report.index') }}?form={{ 'Contract' }}&report={{ 'ReportExecutive' }}">3. รายงานตามยอดจัดรวม</a>
					</li>
					{{-- <li>
						<a href="javascript: void(0);" class="modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('report.index') }}?form={{ 'Contract' }}&report={{ 'CheckerReport' }}">4. รายงานตรวจสอบการลงพื้นที่</a>
					</li> --}}
				</ul>
			</li>
			<li>
				<a href="#" class="title-topbar-menu">รายงานตรวจสอบสินเชื่อ</a>
				<ul class="sub-topbar-menu" aria-expanded="false">
					<li>
						<a href="javascript: void(0);" class="modal_lg " data-toggle="modal" data-target="#modal_lg" data-link="{{ route('report.index') }}?form={{ 'audit' }}&report={{ 'statusDoc' }}">1. สรุปสถานะเอกสาร</a>
					</li>
					<li>
						<a href="javascript: void(0);" class="modal_lg " data-toggle="modal" data-target="#modal_lg" data-link="{{ route('report.index') }}?form={{ 'audit' }}&report={{ 'statusDocCheck' }}">2. สถานะเอกสาร</a>
					</li>
				</ul>
			</li>
			<li>
				<a href="#" class="title-topbar-menu">รายงานข้อมูลการเงินและบัญชี</a>
				<ul class="sub-topbar-menu" aria-expanded="false">
					<li>
						<a href="javascript: void(0);" class="modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('report.index') }}?form={{ 'Contract' }}&report={{ 'AccCash' }}">1. รายงานยอดจัด</a>
					</li>
					<li>
						<a href="javascript: void(0);" class="modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('report.index') }}?form={{ 'Contract' }}&report={{ 'PAReport' }}">2. รายงานการทำประกัน</a>
					</li>
					<li>
						<a href="javascript: void(0);" class="modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('report.index') }}?form={{ 'Contract' }}&report={{ 'contractSuccess' }}">3. รายงานตามเลขที่สัญญา</a>
					</li>
					<li>
						<a href="javascript: void(0);" class="modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('report.index') }}?form={{ 'Contract' }}&report={{ 'PANVR' }}">4. ประกัน PA + ทะเบียนรถ</a>
					</li>
					<li>
						<a href="javascript: void(0);" class="modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('report.index') }}?form={{ 'Contract' }}&report={{ 'OS4KH' }}">5. อส 4ข.</a>
					</li>
					<li>
						<a href="javascript: void(0);" class="modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('report.index') }}?form={{ 'Contract' }}&report={{ 'DataPrivot' }}">6. รายงานPrivot</a>
					</li>
					<li>
						<a href="javascript: void(0);" class="modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('report.index') }}?form={{ 'Contract' }}&report={{ 'extendLand' }}">7. รายงานต่อสัญญาที่ดิน</a>
					</li>
					<li>
						<a href="javascript: void(0);" class="modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('report.index') }}?form={{ 'Datacus' }}&report={{ 'credofragments' }}">8. รายงานData Credo</a>
					</li>
					<li>
						<a href="javascript: void(0);" class="modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('report.index') }}?form={{ 'Datacus' }}&report={{ 'PPbyTraget' }}">9. รายงาน Target</a>
					</li>
				</ul>
			</li>
		</div>
	</div>
@elseif(!empty($__env->yieldContent('page-frontend')))
@endif
