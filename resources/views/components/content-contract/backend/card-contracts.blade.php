@component('components.content-contract.backend.contract-info')
	@slot('icon_contstat')
		bx bx-check-circle
	@endslot
	@slot('state')
		{{-- สถานะสัญญา --}}
		@isset($contract)
			{{ @$contract->PactToStatus->CONTDESC }}
		@else
			-
		@endisset
	@endslot
	@slot('grade')
		{{-- เกรดสัญญา --}}
		{{ @$contract->GRDCOD != null ? @$contract->GRDCOD : '-' }}
	@endslot
	@slot('payamt')
		{{-- ค่างวด --}}
		{{ @$contract->TOT_UPAY != null ? number_format(@$contract->TOT_UPAY, 0) : '-' }}
	@endslot
	@slot('balance')
		{{-- ยอดคงเหลือ --}}
		@if (@$contract->CODLOAN == 1)
			@if (@$contract->CONTTYP == 1)
				{{ number_format(@$contract->TONBALANCE, 2) }}
			@else
				{{ number_format(@$contract->TOTPRC - @$contract->SMPAY, 2) }}
			@endif
		@else
			{{ number_format(@$contract->TOTPRC - @$contract->SMPAY, 2) }}
		@endif
	@endslot
	@slot('LPAYD')
		{{-- วันชำระล่าสุด --}}
		{{ @$contract->LPAYD != null ? formatDateThai(@$contract->LPAYD) : '-' }}
	@endslot
	@slot('LPAYA')
		{{-- ยอดชำระล่าสุด --}}
		{{ @$contract->LPAYA != null ? number_format(@$contract->LPAYA, 0) : '0' }}
	@endslot
	@slot('overdue_balance')
		{{-- ยอดค้างชำระ --}}
		{{ @$contract->EXP_AMT != null ? number_format(@$contract->EXP_AMT, 0) : '0' }}
	@endslot
	@slot('hold_EXP_PRD')
		{{-- งวดค้าง --}}
		{{ @$contract->EXP_PRD != null ? @$contract->EXP_PRD : '-' }}
	@endslot
	@slot('hold_HLDNO')
		{{-- งวดค้างจริง --}}
		{{ @$contract->HLDNO != null ? @$contract->HLDNO : '-' }}
	@endslot
	@slot('hold_EXP_FRM')
		{{-- งวดค้างที่ --}}
		{{ @$contract->EXP_FRM != null ? @$contract->EXP_FRM : '-' }}
	@endslot
	@slot('hold_EXP_TO')
		{{-- ถึงงวดค้างที่ --}}
		{{ @$contract->EXP_TO != null ? @$contract->EXP_TO : '-' }}
	@endslot
	@slot('active_memo')
		{{-- active_memo --}}
		{{ @$active_memo }}
	@endslot
	@slot('memo')
		{{-- หมายเหตุ --}}
		@isset($contract)
			@if ($contract->MEMO != null)
				{{-- nl2br($contract->MEMO, false) --}}
				@php
					echo nl2br($contract->MEMO, false);
				@endphp
			@else
				- ยังไม่มีบันทึก -
			@endif
		@endisset
	@endslot
@endcomponent
