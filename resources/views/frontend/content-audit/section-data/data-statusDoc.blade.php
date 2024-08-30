@if ($audit->Flag_Status == 3)
	<div class="alert alert-warning" role="alert">
		<span class="fw-semibold"><i class="bx bxs-hourglass text-warning bx-tada fs-5"></i> {{$audit->StatusAudit->name_th}} !</span>
	</div>
@elseif ($audit->Flag_Status == 4)
	<div class="alert alert-danger" role="alert">
		<div class="row">
			<div class="col">
				<span class="fw-semibold"><i class="bx bx-error text-danger bx-tada fs-5"></i> {{$audit->StatusAudit->name_th}} !</span> โปรดแจ้งรายละเอียดกับผู้เกี่ยวข้อง เกี่ยวกับสาเหตุและการแก้ไข
			</div>
		</div>
	</div>
@elseif ($audit->Flag_Status == 5 or $audit->Flag_Status == 6 or $audit->Flag_Status == 7)
	<div class="alert alert-success" role="alert">
		<span class="fw-semibold"><i class="bx bx-check-circle text-success bx-tada fs-5"></i> {{$audit->StatusAudit->name_th}} !</span>
	</div>
@endif
