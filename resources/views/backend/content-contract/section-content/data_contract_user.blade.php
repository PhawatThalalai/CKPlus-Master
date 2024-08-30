@component('components.content-user.card-user-view-b-end')
@slot('id_card_name')
    @if( empty(@$pact->ContractToCus->Type_Card) ) {{-- Default Value --}}
        เลขประจำตัวประชาชน
    @else
        {{ @$pact->ContractToCus->DataCusToTypeCard->Detail_Card }}
    @endif
@endslot
@if( empty(@$pact->ContractToCus->Type_Card) || $pact->ContractToCus->Type_Card == '324001' ) {{-- บัตรป่ระชาชน --}}
    @slot('id_card_icon')
        <i class="bx bx-id-card text-primary fs-4"></i>
    @endslot
@elseif( $pact->ContractToCus->Type_Card == '324002' ) {{-- หนังสือเดินทาง --}}
    @slot('id_card_icon')
        <i class="bx bxs-book-content text-primary fs-4"></i>
    @endslot
@elseif( $pact->ContractToCus->Type_Card == '324003' ) {{-- เลขประจำตัวผู้เสียภาษี --}}
    @slot('id_card_icon')
        <i class="bx bx-building-house text-primary fs-4"></i>
    @endslot
@elseif( $pact->ContractToCus->Type_Card == '324004' ) {{-- รหัสอื่น ๆ --}}
    @slot('id_card_icon')
        <i class='bx bx-question-mark text-primary fs-4'></i>
    @endslot
@endif
@slot('Display_Driver')
    @if( @$pact->ContractToCus->Driver_cus == "มี" )
        <span class="text-warning p-2">
            <i class="mdi mdi-card-bulleted fs-4" ></i>
            <b>มีใบขับขี่</b>
        </span>
    @else
        <span class="text-secondary p-2">
            <i class="mdi mdi-card-bulleted-off fs-4"></i>
            <b>ไม่มีใบขับขี่</b>
        </span>
    @endif
@endslot
@slot('Display_Namechange')
    @if( @$pact->ContractToCus->Namechange_cus == "ไม่เคยเปลี่ยนชื่อและนามสกุล" )
        <span class="text-secondary p-2">
            <i class="mdi mdi-file-document fs-4" ></i>
            <b>{{@$pact->ContractToCus->Namechange_cus}}</b>
        </span>
    @else
        <span class="text-info p-2">
            <i class="mdi mdi-file-document-edit fs-4"></i>
            <b>{{@$pact->ContractToCus->Namechange_cus}}</b>
        </span>
    @endif
@endslot
@slot('Display_Gender')
    @if( @$pact->ContractToCus->Gender_cus == "ชาย" )
        <span class="text-info">
            {{@$pact->ContractToCus->Gender_cus}}
            <i class="mdi mdi-gender-male"></i>
        </span>
    @endif
    @if( @$pact->ContractToCus->Gender_cus == "หญิง" )
        <span class="text-danger">
            {{@$pact->ContractToCus->Gender_cus}}
            <i class="mdi mdi-gender-female"></i>
        </span>
    @endif
@endslot
@slot('data', [
    'id' => @$pact->ContractToCus->id,
    'code' => @$pact->ContractToCus->Code_Cus,

    'fullname' => ($pact->ContractToCus ? GetFullName(@$pact->ContractToCus->Firstname_Cus, @$pact->ContractToCus->Surname_Cus, @$pact->ContractToCus->Prefix, @$pact->ContractToCus->PrefixOther) : ''),
    'nickname' => @$pact->ContractToCus->Nickname_cus,
    'NameEng' => @$pact->ContractToCus->NameEng_cus,

    'typeidcard' => @$pact->ContractToCus->Type_Card,//@$contract->DataCusToTypeCard->Detail_Card,
    'idcard' => @$pact->ContractToCus->IDCard_cus,
    'grade' => 'A',

    'Birthday' => @$pact->ContractToCus->Birthday_cus,
    'Gender' => @$pact->ContractToCus->Gender_cus,
    'phone' => @$pact->ContractToCus->Phone_cus,
    'Nationality' => @$pact->ContractToCus->Nationality_cus,
    'Religion' => @$pact->ContractToCus->Religion_cus,
    'Marital' => @$pact->ContractToCus->Marital_cus,
    'Mate' => @$pact->ContractToCus->Mate_cus,
    'MatePhone' => @$pact->ContractToCus->Mate_Phone,

    'facebook' => @$pact->ContractToCus->Social_facebook,
    'Line' => @$pact->ContractToCus->Social_Line,
    'Driver' => @$pact->ContractToCus->Driver_cus,
    'Namechange' => @$pact->ContractToCus->Namechange_cus,
    'Account' => @$pact->ContractToCus->Name_Account,
    'AccountBranch' => @$pact->ContractToCus->Branch_Account,
    'AccountNumber' => @$pact->ContractToCus->Number_Account,

    'dataCus' => @$pact->ContractToCus,
])
@endcomponent
