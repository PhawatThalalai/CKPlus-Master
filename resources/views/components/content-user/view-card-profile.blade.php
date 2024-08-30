@component('components.content-user.card-profile')
	@slot('id_card_name')
		@if (empty(@$data->Type_Card))
			{{-- Default Value --}}
			เลขประจำตัวประชาชน
		@else
			{{ @$data->DataCusToTypeCard->Detail_Card }}
		@endif
	@endslot

	@if (empty(@$data->Type_Card) || $data->Type_Card == '324001') {{-- บัตรป่ระชาชน --}}

		@slot('id_card_icon')
			<i class="bx bx-id-card text-primary fs-4"></i>
		@endslot
		@slot('id_card_exp')
			<span class="text-primary">
				<span class="font-size-12 fw-semibold">วันหมดอายุ : </span>
				@empty(@$data->IdcardExpire_cus)
					<b>-</b>
					<i class="bx bx-error fs-5 fa-fade bx-tada text-warning" data-bs-toggle="tooltip" title="ยังไม่ได้ระบุวันหมดอายุบัตร"></i>
				@else
					<span class="font-size-12 fw-semibold">{{ formatDateShort(@$data->IdcardExpire_cus) }}</span>
					@if (!empty(isCardExpired(@$data->IdcardExpire_cus)))
						<i class="bx bx-error fs-5 fa-fade bx-tada text-danger" data-bs-toggle="tooltip" title="{{ isCardExpired(@$data->IdcardExpire_cus) }}"></i>
					@else
						<i class="bx bx-check fs-5 fa-fade bx-tada text-success" data-bs-toggle="tooltip" title="บัตรประชาชนยังไม่หมดอายุ"></i>
					@endif
				@endempty
			</span>
		@endslot
	@elseif($data->Type_Card == '324002')
		{{-- หนังสือเดินทาง --}}
		@slot('id_card_icon')
			<i class="bx bxs-book-content text-primary fs-4"></i>
		@endslot
	@elseif($data->Type_Card == '324003')
		{{-- เลขประจำตัวผู้เสียภาษี --}}
		@slot('id_card_icon')
			<i class="bx bx-building-house text-primary fs-4"></i>
		@endslot
	@elseif($data->Type_Card == '324004')
		{{-- รหัสอื่น ๆ --}}
		@slot('id_card_icon')
			<i class='bx bx-question-mark text-primary fs-4'></i>
		@endslot
	@endif

	@slot('data_broker')
		@isset($data->DataCusToBroker)
			{{ @$data->DataCusToBroker->status_Broker }}
		@else
			false
		@endisset
	@endslot

	@slot('class_broker')
		@isset($data->DataCusToBroker)
			@if (@$data->DataCusToBroker->status_Broker == 'ปกติ')
				btn-outline-warning
			@elseif (@$data->DataCusToBroker->status_Broker == 'ยกเลิก' or @$data->DataCusToBroker->status_Broker == 'backlist')
				btn-outline-danger
			@endif
		@else
			btn-outline-secondary
		@endisset
	@endslot

	@slot('data', [
		'id' => @$data->id,
		'image' => @$data->image_cus,
		'status' => @$data->Status_Cus,
		//'Prefix' => @$data->Prefix,
		//'name' => @$data->Name_Cus,
		//'surname' => @$data->Surname_Cus,
		'fullname' => $data ? GetFullName(@$data->Firstname_Cus, @$data->Surname_Cus, @$data->Prefix, @$data->PrefixOther) : '',
		'nickname' => @$data->Nickname_cus,
		'NameEng' => @$data->NameEng_cus,
		'typeidcard' => @$data->Type_Card,
		'idcard' => @$data->IDCard_cus,
		'idcardExpire' => @$data->IdcardExpire_cus,
		'phone' => @$data->Phone_cus,
		'phone2' => @$data->Phone_cus2,
		'dateinput' => @$data->date_Cus,
		'UserInsert' => $data ? @$data->getUserInsert() : '',
		])
	@endcomponent
