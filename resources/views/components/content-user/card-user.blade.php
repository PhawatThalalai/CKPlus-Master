<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>
@component('components.content-user.card-user-view')
    @slot('title')
        @if (@$page == 'profile-cus')
            ข้อมูลลูกค้า
        @endif
    @endslot
    @slot('title_eng')
        @if (@$page == 'profile-cus')
            Customer Details
        @endif
    @endslot
    @slot('page')
        {{@$page}}
    @endslot
    @slot('type')
        1
    @endslot

    @if (@$page == 'profile-cus')
        @slot('Display_Driver')
            @if( @$data->Driver_cus == "มี" )
                <span class="text-warning p-2">
                    <i class="mdi mdi-card-bulleted fs-5" ></i>
                    <b>มีใบขับขี่</b>
                </span>
            @else
                <span class="text-secondary p-2">
                    <i class="mdi mdi-card-bulleted-off fs-5"></i>
                    <b>ไม่มีใบขับขี่</b>
                </span>
            @endif
        @endslot
        @slot('Display_Namechange')
            @if( @$data->Namechange_cus == "ไม่เคยเปลี่ยนชื่อและนามสกุล" )
                <span class="text-secondary p-2">
                    <i class="mdi mdi-file-document fs-5"></i>
                    <b>{{@$data->Namechange_cus}}</b>
                </span>
            @else
                <span class="text-info p-2">
                    <i class="mdi mdi-file-document-edit fs-5"></i>
                    <b>{{@$data->Namechange_cus}}</b>
                </span>
            @endif
        @endslot

        @slot('Display_Gender')
            @if( @$data->Gender_cus == "ชาย" )
                <span class="text-info">
                    {{@$data->Gender_cus}}
                    <i class="mdi mdi-gender-male"></i>
                </span>
            @endif
            @if( @$data->Gender_cus == "หญิง" )
                <span class="text-danger">
                    {{@$data->Gender_cus}}
                    <i class="mdi mdi-gender-female"></i>
                </span>
            @endif
        @endslot

        @slot('data', [
            'id' => @$data->id,
            'Prefix' => @$data->Prefix,
            'name' => @$data->Name_Cus,
            'nickname' => @$data->Nickname_cus,
            'code' => @$data->Code_Cus,
            'NameEng' => @$data->NameEng_cus,

            'typeidcard' => @$data->Type_Card,//@$data->DataCusToTypeCard->Detail_Card,
            'idcard' => @$data->IDCard_cus,
            'idcardExpire' => @$data->IdcardExpire_cus,
            'Birthday' => @$data->Birthday_cus,
            'Gender' => @$data->Gender_cus,
            'phone' => @$data->Phone_cus,
            'Nationality' => @$data->Nationality_cus,
            'Religion' => @$data->Religion_cus,
            'Marital' => @$data->Marital_cus,
            'Mate' => @$data->Mate_cus,
            'MatePhone' => @$data->Mate_Phone,

            'facebook' => @$data->Social_facebook,
            'Line' => @$data->Social_Line,
            'Driver' => @$data->Driver_cus,
            'Namechange' => @$data->Namechange_cus,
            'Account' => @$data->Name_Account,
            'AccountBranch' => @$data->Branch_Account,
            'AccountNumber' => @$data->Number_Account,
            'Note' => @$data->Note_cus,
        ])
    @endif
@endcomponent
