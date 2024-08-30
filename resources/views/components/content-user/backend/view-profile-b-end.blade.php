@component('components.content-user.backend.card-profile-b-end')
	@slot('page', $page)
	@slot('id_card_name')
		{{ empty(@$pact) && @$pact->ContractToCus->Type_Card ? @$pact->ContractToCus->DataCusToTypeCard->Detail_Card : 'เลขบัตรประชาชน' }}
	@endslot
	@if (empty(@$pact->ContractToCus->Type_Card) || @$pact->ContractToCus->Type_Card == '324001') {{-- บัตรป่ระชาชน --}}
		@slot('id_card_icon')
			<i class="bx bx-id-card text-primary fs-4"></i>
		@endslot
		@slot('id_card_exp')
			<span class="text-primary">
				<span class="font-size-12 fw-semibold">วันหมดอายุ</span>
				@empty(@$pact->ContractToCus->IdcardExpire_cus)
					<b>-</b>
					<i class="bx bx-error fs-5 fa-fade bx-tada text-warning" data-bs-toggle="tooltip" title="ยังไม่ได้ระบุวันหมดอายุบัตร"></i>
				@else
					<span class="font-size-12 fw-semibold">{{ formatDateThai(@$pact->ContractToCus->IdcardExpire_cus) }}</span>
					@if (!empty(isCardExpired(@$pact->ContractToCus->IdcardExpire_cus)))
						<i class="bx bx-error fs-5 fa-fade bx-tada text-danger" data-bs-toggle="tooltip" title="{{isCardExpired(@$pact->ContractToCus->IdcardExpire_cus)}}"></i>
					@else
						<i class="bx bx-check fs-5 fa-fade bx-tada text-success" data-bs-toggle="tooltip" title="บัตรประชาชนยังไม่หมดอายุ"></i>
					@endif
				@endempty
			</span>
		@endslot
	@elseif(@$pact->ContractToCus->Type_Card == '324002')
		{{-- หนังสือเดินทาง --}}
		@slot('id_card_icon')
			<i class="bx bxs-book-content text-primary fs-4"></i>
		@endslot
	@elseif(@$pact->ContractToCus->Type_Card == '324003')
		{{-- เลขประจำตัวผู้เสียภาษี --}}
		@slot('id_card_icon')
			<i class="bx bx-building-house text-primary fs-4"></i>
		@endslot
	@elseif(@$pact->ContractToCus->Type_Card == '324004')
		{{-- รหัสอื่น ๆ --}}
		@slot('id_card_icon')
			<i class='bx bx-question-mark text-primary fs-4'></i>
		@endslot
	@endif

	@if (@$pact->ContractToIndenture->IndentureToAsset->TypeAsset_Code == 'car' or @$pact->ContractToIndenture->IndentureToAsset->TypeAsset_Code == 'moto')
		@slot('asset_icon')
			<i class="bx bx-car text-primary fs-4"></i>
		@endslot
		@slot('asset_data', [
			'title' => 'เลขทะเบียน',
			'value' => @$pact->ContractToIndenture->IndentureToAsset->Vehicle_OldLicense,
			'value_1' => @$pact->ContractToIndenture->IndentureToAsset->Vehicle_NewLicense,
		])
	@elseif(@$pact->ContractToIndenture->IndentureToAsset->TypeAsset_Code == 'land')
		@slot('asset_icon')
			<i class="bx bx-map-alt text-primary fs-4"></i>
		@endslot
		@slot('asset_data', [
			'title' => 'ประเภทที่ดิน',
			'value' => @$pact->ContractToIndenture->IndentureToAsset->DataAssetToLandType->nametype_car,
		])
	@endif

	@slot('data', [
		'contract' => @$pact->Contract_Con,
		'contractId' => @$pact->id,
		'NameCon' => @$pact->ContractToTypeLoan->Loan_Name,
		'typeCon' => @$pact->ContractToTypeLoan->Loan_Code,

		'assets' => @$pact->ContractToTypeLoan->Loan_Code,

		'branchName' => @$pact->ContractToBranch->Name_Branch,
		'branchCode' => @$pact->ContractToBranch->id_Contract,

		'id' => @$pact->ContractToCus->id,
		'image' => @$pact->ContractToCus->image_cus,
		'status' => @$contract->PactToStatus->CONTDESC,

		'fullname' => @$pact ? GetFullName(@$pact->ContractToCus->Firstname_Cus, @$pact->ContractToCus->Surname_Cus, @$pact->ContractToCus->Prefix, @$pact->ContractToCus->PrefixOther) : '',
		'nickname' => @$pact->ContractToCus->Nickname_cus,
		'NameEng' => @$pact->ContractToCus->NameEng_cus,

		'typeidcard' => @$pact->ContractToCus->DataCusToTypeCard->Code,
		'idcard' => @$pact->ContractToCus->IDCard_cus,
		'idcardExpire' => @$pact->ContractToCus->IdcardExpire_cus,
		'phone' => @$pact->ContractToCus->Phone_cus,
	])

	@slot('megaMenu', @$megaMenu)
@endcomponent
