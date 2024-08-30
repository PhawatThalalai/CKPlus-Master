@if (count($dataTHR) != 0 && $dataTHR != NULL)
<div class="table-responsive font-size-11" data-simplebar="init" style="max-height: 355px;">
	<table class="table table-bordered table-sm mb-0 text text-nowrap table-hover table-payment" style="font-size: 11px;">
		<thead class="sticky-top">
			<tr class="bg-info bg-opacity-80 text-light">
				<th>วันตั้งหนี้</th>
				<th>เลขเอกสาร</th>
				<th>รหัสชำระ</th>
				<th>รายการ</th>
				<th>ยอดลูกหนี้</th>
				<th>ส่วนลด</th>
				<th>ยอดชำระ</th>
				<th>คงเหลือ</th>
				<th>ทีมติดตาม</th>
				<th>วันนัดชำระ</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($dataTHR as $item)
				<tr>
					<td scope="row" class="text-center">{{ date('d-m-Y', strtotime(@$item->ARDATE)) }}</td>
					<td scope="row" class="text-center">{{ @$item->ARCONT }}</td>
					<td scope="row" class="bg-danger bg-soft text text-center">{{ @$item->PAYFOR }}</td>
					<td scope="row" class="text-center">{{ isset($FlagBtn) ? $item->FORDESC : @$item->PAYCODE->FORDESC }}</td>
					<td scope="row" class="bg-danger bg-soft text-end">{{ number_format(@$item->PAYAMT, 2) }}</td>
					<td scope="row" class="bg-danger bg-soft text-end">{{ number_format(@$item->DISCOUNT, 2) }}</td>
					<td scope="row" class="bg-danger bg-soft text-end">{{ number_format(@$item->SMPAY, 2) }}</td>
					<td scope="row" class="bg-danger bg-soft text-end">{{ number_format(@$item->BALANCE, 2) }}</td>
					<td scope="row" class="text-center">{{ isset($FlagBtn) ? $item->name : @$item->ARBILLCOLL->name }}</td>
					<td scope="row" class="text-center">{{ date('d-m-Y', strtotime(@$item->DDATE)) }}</td>
				</tr>
			@endforeach
			<tr style="line-height: 200%;">
				<td></td>
			</tr>
		</tbody>
        <tfoot class="sticky-top">
            <tr class="bg-info bg-soft fw-bold text-decoration-underline">
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td scope="cal" class="text-end">{{ number_format($dataTHR->sum('PAYAMT'), 2) }}</td>
                <td scope="cal" class="text-end">{{ number_format($dataTHR->sum('DISCOUNT'), 2) }}</td>
                <td scope="cal" class="text-end">{{ number_format($dataTHR->sum('SMPAY'), 2) }}</td>
                <td scope="cal" class="text-end">{{ number_format($dataTHR->sum('BALANCE'), 2) }}</td>
                <td></td>
                <td></td>
            </tr>
        </tfoot>
	</table>
</div>
@else
	<blockquote class="blockquote font-size-16 mb-0">
		<p class="font-size-14">ไม่พบข้อมูล.</p>
		<footer class="blockquote-footer">
			<cite title="Source Title">ลูกค้าไม่มีค่าธรรมเนียมอื่นๆ ณ. ปัจจุบัน
				<i>&#128525;</i>
			</cite>
		</footer>
	</blockquote>
@endif
