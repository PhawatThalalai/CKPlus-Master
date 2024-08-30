
@php
    switch (@$FlagBtn) {
        case 'LOCAT':
            $_constant_data = \App\Models\TB_Constants\TB_Frontend\TB_Branchs::where('Zone_Branch',auth()->user()->zone)
                ->where('Branch_Active','yes')
                ->orderBY('id_Contract', 'asc')
                ->get();
            break;
        default:
            $_constant_data = null;
            break;
    }
@endphp

@if(@$FlagBtn == 'LOCAT')
    <script>
        var _constant_locat_data_json = @json($_constant_data);
        $(document).ready(function(){
            $('.LOCAT').on('input blur', function (){
                var GetVal = $(this).val();
                if (GetVal != ''){
                    var getName = GetVal;
                    var getNumber = '';
                    var getCode = '';
                    $.each(_constant_locat_data_json, function(index, value){
                        if (GetVal == value.NickName_Branch) {
                            getNumber = value.Name_Branch;
                            getCode = value.id;
                        }
                    });
                    //----------------------------------------
                    $('.LOCATNAME').val(getNumber);
                    $('.ID_LOCAT').val(getCode);
                    if (getNumber == '') {
                        $('.LOCAT').addClass('is-invalid', true);
                        $('.LOCATNAME').addClass('is-invalid', true);
                    } else {
                        $('.LOCAT').removeClass('is-invalid', true);
                        $('.LOCATNAME').removeClass('is-invalid', true);
                    }
                } else {
                    $('.LOCAT').removeClass('is-invalid', true);
                    $('.LOCATNAME').removeClass('is-invalid', true);
                    $('.LOCATNAME').val('');
                    $('.ID_LOCAT').val('');
                }
            });
        });
    </script>
@endif