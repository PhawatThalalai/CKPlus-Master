@if (@$contract->CODLOAN == 1)
	@component('components.content-contract.backend.contracts-detailsPSL')
		@slot('data', [
			'DataPact_id' => @$contract->DataPact_id,
			'page' => @$page,
			'LoanAmount' => number_format(@$contract->TCSHPRC, 2),
			'Interest' => number_format(@$contract->Interest_IRR / 100, 6),
			'Period' => number_format(@$contract->T_NOPAY, 2),
			'fine' => number_format(@$contract->INTLATE, 2),
			'Fee' => '(ลบออก)',
			'Total' => number_format(@$contract->TOTPRC - @$contract->TCSHPRC, 2),
			'installments' => number_format(@$contract->TOT_UPAY, 2),
			'NetBalance' => '(ลบออก)',
			'InstallPInt' => number_format(@$contract->TOTPRC, 2),
			'FirstPeriod' => formatDateThai(@$contract->FDATE),
			'LastPeriod' => formatDateThai(@$contract->LDATE),
			'SDATE' => formatDateThai(@$contract->SDATE),
			'DTSTOPV' => @$contract->DTSTOPV, // วันที่หยุด Vat
			'Paid' => number_format(@$contract->SMPAY, 2),
			'OutstandingDebt' => number_format(@$contract->TOTPRC - @$contract->SMPAY, 2),
			// 'LowPayment' => number_format(@$contract->TOT_UPAY*@$minCal,2),
			'inspector' => @$contract->PatchToPact->ContractToConfirmApp->name,
			'Cashier' => @$contract->ContractLocat->NickName_Branch,
			'Salesperson' => @$contract->PatchToPact->ContractToUserBranch->name,
			])
		@endcomponent
	@else
		@component('components.content-contract.backend.contracts-detailsHP')
			@slot('data', [
				'DataPact_id' => @@$contract->DataPact_id,
				'page' => @$page,
				'SellingPrice' => number_format(@$contract->TOTPRC - (@$contract->TOTPRC * 7) / 107, 2), //ราคาขาย
				'NDAWN' => number_format(@$contract->NDAWN, 2), //เงินดาวน์
				'Investment' => number_format(@$contract->TCSHPRC + @$contract->NDAWN, 2), //เงินลงทุน
				'FDATE' => @$contract->FDATE, //งวดแรก
				'InstallmentsHP' => number_format(@$contract->TOT_UPAY - (@$contract->TOT_UPAY * 7) / 107, 2), //ค่างวดไม่รวม Vat
				'SDATE' => formatDateThai(@$contract->SDATE),
				'InterestHP' => number_format(@$contract->NPRICE - @$contract->NCSHPRC, 2), //ดอกเบี้ย
				'inspector' => @$contract->PatchToPact->ContractToConfirmApp->name, //ผู้ตรวจสอบ
				'ConCHD' => @$contract->somevalue, //วันที่เปลี่ยนสัญญา

				'SaleTax' => number_format((@$contract->TOTPRC * 7) / 107, 2), // ภาษีขาย
				'DownTax' => number_format(@$contract->VATDAWN, 2), // ภาษีดาวน์
				'T_NOPAY' => number_format(@$contract->T_NOPAY, 2), // จำนวนผ่อน
				'LDATE' => @$contract->LDATE, // งวดสุดท้าย
				'TAX' => number_format((@$contract->TOT_UPAY * 7) / 107, 2), // ภาษี
				'PaidHP' => number_format(@$contract->SMPAY, 2), // ชำระเงินแล้ว
				'BILLCOLL' => is_numeric(@$contract->BILLCOLL) ? @$contract->ContractBILLCOLLToBranch->NickName_Branch : @$contract->BILLCOLL, // พนักงานเก็บเงิน
				'DTSTOPV' => @$contract->DTSTOPV, // วันที่หยุด Vat

				'TOTPRC' => number_format(@$contract->TOTPRC, 2), // ราคาขายรวม
				'TOTDAWN' => number_format(@$contract->TOTDAWN, 2), // เงินดาวน์รวม
				'interest_IRR' => number_format(@$contract->Interest_IRR, 6), // ดอกเบี้ย(%)
				'INTLATE' => number_format(@$contract->INTLATE, 2), // เบี้ยปรับ(%)
				'TOT_UPAY' => number_format(@$contract->TOT_UPAY, 2), // รวมภาษี
				'CAPITALBL' => number_format(@$contract->TOTPRC - @$contract->SMPAY, 2), // ลูกหนี้คงเหลือ
				'SalespersonHP' => @$contract->ContractToBranch->NickName_Branch, // พนักงานขาย
				'FDATEHP' => @$contract->FDATE, // เริ่มผ่อนชำระจากงวด
				])
			@endcomponent
		@endif
