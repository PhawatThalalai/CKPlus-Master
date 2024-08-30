<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
	<div data-simplebar class="h-100">
		@php
			if (!empty($__env->yieldContent('page-backend'))) {
			    $typeLoan = \App\Models\TB_Constants\TB_Frontend\TB_TypeLoanCom::generateQuery();
			    $loantype = [];
			    foreach ($typeLoan as $loan) {
			        $loantype[$loan->Loan_Code] = $loan->Loan_Group;
			    }
			}
		@endphp
		<!--- Sidemenu -->
		<div id="sidebar-menu">
			@if (!empty($__env->yieldContent('page-backend')))
				<!-- Left Menu Start front-end-->
				<ul class="metismenu list-unstyled @yield('page-frontend')" id="side-menu">
					{{-- <li>
						<a href="{{ route('logs') }}" target="_blank">
							<i class="bx bx-bug-alt"></i>
							<span key="t-log">Logs</span>
						</a>
					</li> --}}

					<li class="menu-title" key="t-menu">ระบบ ข้อมูลประจำวัน</li>
					<li>
						<a href="javascript: void(0);" class="has-arrow waves-effect @yield('trackcus-active')">
							<i class="bx bx-book-content"></i>
							<span key="t-dashboards">ข้อมูลประจำวัน</span>
						</a>

						<ul class="sub-menu" aria-expanded="true">
							<li>
								<a href="javascript: void(0);" class="has-arrow  @yield('12-active')" key="ploan">ข้อมูลลูกค้า</a>
								<ul class="sub-menu" aria-expanded="true">
									<li><a href="{{ route('view.index') }}?page={{ 'walkin-cus' }}" key="Track-01" class="@yield('viewcus-active')">รายการ รับลูกค้า</a></li>
									<li><a href="{{ route('view.index') }}?page={{ 'tracking-cus' }}" key="Track-02" class="@yield('Track02-active')">รายการ ติดตามลูกค้า</a></li>
									<li><a href="{{ route('view.index') }}?page={{ 'tracking-gm' }}" key="Track-03" class="@yield('Track03-active')">รายการ ติดตามส่ง GM</a></li>
								</ul>
							</li>
							<li>
								<a href="{{ route('view.index') }}?page={{ 'brokers' }}" key="t-default" class=" @yield('broker-active')">
									<span key="t-layouts">รายการ ผู้แนะนำ</span>
								</a>
							</li>
							<li>
								<a href="{{ route('view.index') }}?page={{ 'assets' }}" key="t-default" class="@yield('data-asset-active')">
									<span key="t-layouts">รายการ ทรัพย์สิน</span>
								</a>
								{{-- <ul class="sub-menu" aria-expanded="false">
									<li><a href="{{ route('view.index') }}?page={{ 'assets' }}" key="t-default" class="@yield('data-asset-active')">ข้อมูลทรัพย์สิน</a></li>
								</ul> --}}
							</li>
						</ul>
					</li>

					<li class="menu-title" key="t-datacus">ระบบ ฐานลูกค้า</li>
					<li>
						<a href="javascript: void(0);" class="has-arrow waves-effect @yield('datacus-active')">
							<i class="bx bxs-user-detail"></i>
							<span key="t-dashboards">รายการ ลูกค้า</span>
						</a>
						<ul class="sub-menu" aria-expanded="false">
							<li><a href="{{ route('view.index') }}?page={{ 'profile-cus' }}" key="t-cus" class="@yield('cus-active')">ข้อมูลลูกค้า</a></li>
							@hasrole(['administrator', 'superadmin'])
								<li><a href="{{ route('view.index') }}?page={{ 'new-cus' }}" key="t-newcus" class="@yield('newcus-active')">สร้างลูกค้าใหม่</a></li>
							@endhasrole
						</ul>
					</li>

					<li class="menu-title" key="t-assets">ระบบ ฐานทรัพย์</li>
					<li>
						<a href="{{ route('view.index') }}?page={{ 'data-assets' }}" class="@yield('assets-active')">
							<i class="bx bx-hive"></i>
							<span key="t-user-plus">รายการ ทรัพย์</span>
						</a>
					</li>

					<li class="menu-title" key="t-components">ระบบ อนุมัติสินเชือ</li>
					<li>
						<a href="javascript: void(0);" class="has-arrow waves-effect @yield('2-active')">
							<i class="bx bx-layout"></i>
							<span key="t-chat">สินเชื่อ เช่าซื้อ</span>
						</a>
						<ul class="sub-menu" aria-expanded="true">
							@foreach (@$typeLoan as $loan)
								@if (@$loan->Loan_Group == 1)
									<li class="nav-item">
										<a href="{{ route('view.index') }}?page={{ 'approve-loans' }}&loanCode={{ @$loan->Loan_Code }}" key="{{ @$loan->Loan_Code }}" class="@yield(@$loan->id_rateType . @$loan->Loan_Code . '-active')">({{ @$loan->Loan_Code }}) {{ @$loan->Loan_Name }}</a>
									</li>
								@endif
							@endforeach
						</ul>
					</li>
					<li>
						<a href="javascript: void(0);" class="has-arrow waves-effect  @yield('1-active')">
							<i class="bx bx-layout"></i>
							<span key="micro-ploan">สินเชื่อ เงินกู้</span>
						</a>
						<ul class="sub-menu" aria-expanded="true">
							<li>
								<a href="javascript: void(0);" class="has-arrow  @yield('12-active')" key="ploan">สินเชื่อเงินกู้ PLoan</a>
								<ul class="sub-menu" aria-expanded="true">
									@foreach (@$typeLoan as $loan)
										@if (@$loan->Loan_Group == 2)
											<li>
												<a href="{{ route('view.index') }}?page={{ 'approve-loans' }}&loanCode={{ @$loan->Loan_Code }}" key="{{ @$loan->Loan_Code }}" class="@yield(@$loan->id_rateType . @$loan->Loan_Code . '-active')">({{ @$loan->Loan_Code }}) {{ @$loan->Loan_Name }}</a>
											</li>
										@endif
									@endforeach
								</ul>
							</li>

							<li>
								<a href="javascript: void(0);" class="has-arrow  @yield('13-active')" key="micro">สินเชื่อเงินกู้ Micro</a>
								<ul class="sub-menu" aria-expanded="true">
									@foreach (@$typeLoan as $loan)
										@if (@$loan->Loan_Group == 3)
											<li>
												<a href="{{ route('view.index') }}?page={{ 'approve-loans' }}&loanCode={{ @$loan->Loan_Code }}" key="{{ @$loan->Loan_Code }}" class="@yield(@$loan->id_rateType . @$loan->Loan_Code . '-active')">({{ @$loan->Loan_Code }}) {{ @$loan->Loan_Name }}</a>
											</li>
										@endif
									@endforeach
								</ul>
							</li>
						</ul>
					</li>

					<li class="menu-title" key="t-pages">ระบบ ตรวจสอบสินเชื่อ</li>
					<li>
						<a href="javascript: void(0);" class="has-arrow waves-effect @yield('adBranch-active')">
							<i class="bx bx-receipt"></i>
							<span key="t-dashboards">รายการ เอกสาร</span>
						</a>
						<ul class="sub-menu" aria-expanded="false">
							<li><a href="{{ route('view.index') }}?page={{ 'sendoffice' }}" key="t-default" class="@yield('sendoffice-active')">เอกสาร รอนำส่ง</a></li>
							<li><a href="{{ route('view.index') }}?page={{ 'rejectDocs' }}" key="t-new" class="@yield('rejectDocs-active')">เอกสาร ไม่สมบูรณ์</a></li>
						</ul>
					</li>
					@can('data-warehoure')
						<li>
							<a href="javascript: void(0);" class="has-arrow waves-effect @yield('audit-active')">
								<i class="bx bx-receipt"></i>
								<span key="t-dashboards">รายการ ตรวจสอบ</span>
							</a>
							<ul class="sub-menu" aria-expanded="false">
								<li><a href="{{ route('view.index') }}?page={{ 'credit-loans' }}" key="t-default" class="@yield('credit-loans-active')">เอกสาร ตรวจสอบ</a></li>
								<li><a href="{{ route('view.index') }}?page={{ 'data-warehoure' }}" key="t-new" class="@yield('data-warehoure-active')">เอกสาร เข้าเซฟ</a></li>
							</ul>
						</li>
					@endcan
					@can('financial-approval')
						<li class="menu-title" key="t-components">ระบบ การเงิน</li>
						<li>
							<a href="{{ route('view.index') }}?page={{ 'financial-approval' }}" class="@yield('financial-approval-active')">
								<i class="bx bx-money"></i>
								<span key="t-chat">รายการ โอนเงินสินเชือ</span>
							</a>
						</li>
					@endcan
					<li class="menu-title" key="t-components">ระบบ รายงาน</li>
					<li>
						<a href="#" class="" data-bs-toggle="offcanvas" data-bs-target="#offcanvasWithBackdrop" aria-controls="offcanvasWithBackdrop">
							<i class="bx bx-spreadsheet"></i>
							<span key="report-front">รายงาน</span>
						</a>
					</li>
				</ul>
			@elseif(!empty($__env->yieldContent('page-frontend')))
				<!-- Left Menu Start back-end-->
				<ul class="metismenu list-unstyled @yield('page-backend')" id="side-menu">
					<li class="menu-title" key="t-apps">ระบบ การ์ดลูกหนี้</li>
					<li>
						<a href="{{ route('view-backend.index') }}?page={{ 'create-cont' }}" class="@yield('center-p1-active')">
							<i class="bx bxs-user-plus"></i>
							<span key="t-user-plus">สร้างการ์ดลูกหนี้</span>
						</a>
					</li>
					<li>
						<a href="{{ route('view-backend.index') }}?page={{ 'contract' }}" class="@yield('contract-p1-active')">
							<i class="bx bxs-user-circle"></i>
							<span key="t-contact">สอบถามข้อมูลลูกหนี้</span>
						</a>
					</li>

					<li class="menu-title" key="t-payments">ระบบ ติดตามลูกหนี้</li>
					<li>
						<a href="javascript: void(0);" class="has-arrow waves-effect @yield('datatrack-active')">
							<i class="bx bxs-user-detail"></i>
							<span key="t-dashboards">ระบบ ติดตามลูกหนี้</span>
						</a>
						<ul class="sub-menu" aria-expanded="false">
							<li><a href="{{ route('view-backend.index') }}?page={{ 'track-follow-up' }}" key="t-default" class="@yield('datatrack-p4-active')">บันทึกข้อมูลลูกหนี้</a></li>
							<li><a href="{{ route('view-backend.index') }}?page={{ 'track-create-task' }}" key="t-default" class="@yield('datatrack-p1-active')">บันทึกแบ่งกลุ่มลูกหนี้</a></li>
							<li class="@yield('datatrack')">
								<a href="javascript: void(0);" class="has-arrow" key="t-level-1-2" aria-expanded="true">รายการแบ่งกลุ่มลูกหนี้</a>
								<ul class="sub-menu mm-collapse" aria-expanded="true">
									<li><a href="{{ route('view-backend.index') }}?page={{ 'track-list-call' }}" key="t-level-2-1" class="@yield('datatrack-p2-active')">รายการกลุ่มงานโทร</a></li>
									<li><a href="{{ route('view-backend.index') }}?page={{ 'track-list-follow' }}" key="t-level-2-2" class="@yield('datatrack-p3-active')">รายการกลุ่มงานตาม</a></li>
								</ul>
							</li>
						</ul>
					</li>

					<li class="menu-title" key="t-payments">ระบบ การเงิน</li>
					<li>
						<a href="javascript: void(0);" class="has-arrow waves-effect @yield('payments-active')">
							<i class="bx bxs-wallet-alt"></i>
							<span key="t-dashboards">ระบบ การเงิน</span>
						</a>
						<ul class="sub-menu" aria-expanded="false">
							<li><a href="{{ route('view-backend.index') }}?page={{ 'payments' }}" class="@yield('payments-paydue-active')">รับชำระค่างวด</a></li>
							<li><a href="{{ route('view-backend.index') }}?page={{ 'cn-pays' }}" class="@yield('payments-cancel-active')">ยกเลิกใบรับค่างวด</a></li>
							<li class="@yield('payments-auto-active')">
								<a href="javascript: void(0);" class="has-arrow" key="t-level-1-2" aria-expanded="true">ระบบตัดเงินอัตโมนัติ</a>
								<ul class="sub-menu mm-collapse" aria-expanded="true">
									<li><a href="{{ route('view-backend.index') }}?page={{ 'imp-pays' }}" class="@yield('importpay-active')">นำเข้าไฟล์</a></li>
									<li><a href="{{ route('view-backend.index') }}?page={{ 'imp-payslist' }}" class="@yield('autopaylist-active')">รายการนำเข้า</a></li>
									<li><a href="{{ route('view-backend.index') }}?page={{ 'imp-autopayment' }}" class="@yield('autopayment-active')">รายการเตรียมชำระ</a></li>
								</ul>
							</li>
						</ul>
					</li>
					
					<li class="menu-title" key="t-payments">ระบบ บัญชี</li>
					<li>
						<a href="javascript: void(0);" class="has-arrow waves-effect @yield('account-active')">
							<i class="bx bxs-package"></i>
							<span key="t-dashboards">ระบบ บัญชี</span>
						</a>
						<ul class="sub-menu" aria-expanded="false">
							<li class="@yield('account-sub1-active')">
								<a href="javascript: void(0);" class="has-arrow" key="t-level-1-2" aria-expanded="true">ระบบรับรู้รายได้ลูกหนี้</a>
								<ul class="sub-menu mm-collapse" aria-expanded="true">
									<li><a href="{{ route('view-backend.index') }}?page={{ 'stopcont-vats' }}" class="@yield('account-p1-active')">บันทึกหยุดรับรู้รายได้ตามดิว</a></li>
									<li><a href="{{ route('view-backend.index') }}?page={{ 'cancelcont-vats' }}" class="@yield('account-p2-active')">ยกเลิกหยุดรับรู้รายได้ตามดิว</a></li>
								</ul>
							</li>
							<li class="@yield('account-sub2-active')">
								<a href="javascript: void(0);" class="has-arrow" key="t-level-1-2" aria-expanded="true">ระบบลูกหนี้เพื่อบัญชี</a>
								<ul class="sub-menu mm-collapse" aria-expanded="true">
									<li><a href="{{ route('view-backend.index') }}?page={{ 'view-seized' }}" class="@yield('account-p3-active')">บันทึกยึดรถรอไถ่ถอน</a></li>
									<li><a href="{{ route('view-backend.index') }}?page={{ 'veh-confiscation' }}" class="@yield('account-p4-active')">บันทึกยึดตัดทำขาย</a></li>
									<li><a href="{{ route('view-backend.index') }}?page={{ 'bad-debt' }}" class="@yield('account-p5-active')">บันทึกรายการหนี้สูญ</a></li>
									<li><a href="{{ route('view-backend.index') }}?page={{ 'terminate-letter' }}" class="@yield('account-p6-active')">บันทึกหนังสือยืนยันบอกเลิก</a></li>
									<li><a href="{{ route('view-backend.index') }}?page={{ 'renew-contract' }}" class="@yield('account-p7-active')">บันทึกต่อสัญญาขายฝาก</a></li>

								</ul>
							</li>
						</ul>
					</li>

					<li class="menu-title" key="t-payments">ระบบ ภาษี</li>
					<li>
						<a href="javascript: void(0);" class="has-arrow waves-effect @yield('tax-active')">
							<i class="bx bxs-report"></i>
							<span key="t-dashboards">ระบบ ภาษี</span>
						</a>
						<ul class="sub-menu" aria-expanded="false">
							<li>
								<a href="{{ route('view-backend.index') }}?page={{ 'invoice-normal' }}" class="@yield('tax-sub1-active')" key="t-level-1-2" aria-expanded="true">ออกใบกำกับค่างวดปกติ</a>
							</li>
							<li>
								<a href="{{ route('view-backend.index') }}?page={{ 'invoice-before' }}" class="@yield('tax-sub2-active')" key="t-level-1-2" aria-expanded="true">ออกใบกำกับค่างวดก่อนดิว</a>
							</li>
							<!-- <li class="@yield('tax-sub2-active')">
								<a href="javascript: void(0);" class="has-arrow" key="t-level-1-2" aria-expanded="true">ระบบลูกหนี้เพื่อบัญชี</a>
								<ul class="sub-menu mm-collapse" aria-expanded="true">
									<li><a href="{{ route('view-backend.index') }}?page={{ 'view-seized' }}" class="@yield('tax-p3-active')">บันทึกยึดรถรอไถ่ถอน</a></li>
									<li><a href="{{ route('view-backend.index') }}?page={{ 'veh-confiscation' }}" class="@yield('tax-p4-active')">บันทึกยึดตัดทำขาย</a></li>
									<li><a href="{{ route('view-backend.index') }}?page={{ 'bad-debt' }}" class="@yield('tax-p5-active')">บันทึกรายการหนี้สูญ</a></li>
									<li><a href="{{ route('view-backend.index') }}?page={{ 'terminate-letter' }}" class="@yield('tax-p6-active')">บันทึกหนังสือยืนยันบอกเลิก</a></li>
									<li><a href="{{ route('view-backend.index') }}?page={{ 'renew-contract' }}" class="@yield('tax-p7-active')">บันทึกต่อสัญญาขายฝาก</a></li>

								</ul>
							</li> -->
						</ul>
					</li>

					<li class="menu-title" key="t-payments">ระบบ รายงาน</li>
					<li>
						<a href="javascript: void(0);" class="has-arrow waves-effect @yield('report-active')">
							<i class="bx bxs-news"></i>
							<span key="t-dashboards">ระบบ รายงาน</span>
						</a>
						<ul class="sub-menu" aria-expanded="false">
							<li class="@yield('report-sub1-active')">
								<a href="javascript: void(0);" class="has-arrow" key="t-level-1-1" aria-expanded="true">รายงานการเงิน</a>
								<ul class="sub-menu mm-collapse" aria-expanded="true">
									<li><a href="{{ route('view-backend.index') }}?page={{ 'payments' }}" class="@yield('report-p1-active')">รายงานสรุปการชำระ</a></li>
								</ul>
							</li>
							<li class="@yield('report-sub2-active')">
								<a href="javascript: void(0);" class="has-arrow" key="t-level-1-2" aria-expanded="true">รายงานทางบัญชี</a>
								<ul class="sub-menu mm-collapse" aria-expanded="true">
									<li><a href="#" class="@yield('report-p2-active')">รายงาน...</a></li>
								</ul>
							</li>
							<li class="@yield('report-track-active')">
								<a href="javascript: void(0);" class="has-arrow" key="t-level-1-3" aria-expanded="true">รายงานลูกหนี้</a>
								<ul class="sub-menu mm-collapse" aria-expanded="true">
									<li><a href="{{ route('view-backend.index') }}?page={{ 'daily' }}" class="@yield('report-track-daily')">รายงาน Daily</a></li>
									<li><a href="{{ route('view-backend.index') }}?page={{ 'monthly' }}" class="@yield('report-track-monthly')">รายงาน Monthly</a></li>
									<li><a href="{{ route('view-backend.index') }}?page={{ 'printlet' }}" class="@yield('report-track-printlet')">พิมพ์จดหมายลูกหนี้</a></li>
									<li><a href="{{ route('view-backend.index') }}?page={{ 'billing-stmt' }}" class="@yield('report-track-billstmt')">หนังสือแจ้งค่างวด</a></li>
								</ul>
							</li>

						</ul>
					</li>

				</ul>
			@endif
		</div>
		<!-- Sidebar -->
	</div>
</div>
<!-- Left Sidebar End -->

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

					@if(auth()->user()->zone == 10 or auth()->user()->zone == 40)
						<li>
							<a href="javascript: void(0);" class="modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('report.index') }}?form={{ 'commission' }}&report={{ 'ReportCommission' }}">4. รายงานคอมมิชชั่น</a>
						</li>
					@endif
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
						<a href="javascript: void(0);" class="modal_lg" data-toggle="modal" data-target="#modal_lg" data-link="{{ route('report.index') }}?form={{ 'Datacus' }}&report={{ 'PPbyTraget' }}">8.รายงาน Traget</a>
					</li>
				</ul>
			</li>
		</div>
	</div>
@elseif(!empty($__env->yieldContent('page-frontend')))
@endif
