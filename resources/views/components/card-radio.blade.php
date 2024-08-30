@foreach (@$data['data-arr'] as $item)
    @if ($item['width'] == 'full')
        @php
        $n = 1;
        $n++;
        $iconRes = true;

        $ch = curl_init($item['icon-url']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode == 200) {
            $iconRes = true;
        } else {
            $iconRes = false;
        }
        @endphp
        <style>
        .card__radio_display {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .radio__card {
            padding: 1px 0 1px 0;
            width: 100%;
        }

        .card__radio__lable {
            width: 100%;
        }

        /* input:checked + .radio__card{{ $n }} {
            background-color: {{ $item['color'] != '' ? $item['color'] : '#dc2f02' }};
        } */

        .radio__card__el {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media screen and (max-width: 992px) {
            .radio__card {
                width: 100%;
            }

            .card__radio_display {
                display: inline;
            }
        }
        </style>

        <label class="card-radio-label card__radio__lable">
        <input type="radio" name="{{ $item['radio-name'] }}" class="btn-check card-radio-input card-input" id="radio_id" value="{{ @$item['btn-value'] }}" autocomplete="off">
        <div class="radio__card  btn btn-outline-{{ $item['color'] != '' ? $item['color']  : 'success' }} waves-effect waves-light">
            <div class="radio__card__el">
                @if ($iconRes == true)
                <lord-icon
                    id="icon"
                    src="{{ @$item['icon-url'] }}"
                    trigger="loop"
                    delay="2000"
                    stroke="{{ @$item['icon-stroke'] != '' ? @$item['icon-stroke'] : '' }}"
                    colors="{{ @$item['icon-color'] != '' ? @$item['icon-color'] : '' }}"
                    style="width:30px;height:30px; margin-right: 3px">
                </lord-icon>
                @else
                    @if ($item['sub-icon'] != '')
                        <i class="{{ $item['sub-icon'] }}" style="display: flex; justify-content: center; align-items: center; width:30px;height:30px; font-size: 20px; margin-right: 3px"></i>
                    @else
                        <i style="height:30px;"></i>
                    @endif
                @endif
                <span style="margin-left: 2px">{{ @$item['btn-name'] }}</span>
            </div>
        </div>
        </label>
    @else
        @php
        $n = 1;
        $n++;
        $iconRes = true;

        $ch = curl_init($item['icon-url']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($httpCode == 200) {
            $iconRes = true;
        } else {
            $iconRes = false;
        }
        @endphp
        <style>
        .card__radio_display {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
        }

        .radio__card {
            padding: 5px 50px 5px 50px;
        }

        /* input:checked + .radio__card{{ $n }} {
            background-color: {{ $item['color'] != '' ? $item['color'] : '#dc2f02' }};
        } */

        .radio__card__el {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        @media screen and (max-width: 992px) {
            .radio__card {
                width: 100%;
            }

            .card__radio_display {
                display: inline;
            }
        }
        </style>

        <label class="card-radio-label mb-2">
        <input type="radio" name="{{ $item['radio-name'] }}" class="btn-check card-radio-input card-input" id="card-radio" value="{{ @$item['btn-value'] }}" autocomplete="off">
        <div class="radio__card  btn btn-outline-{{ $item['color'] != '' ? $item['color']  : 'success' }} waves-effect waves-light">
            <div class="radio__card__el">
                @if ($iconRes == true)
                <lord-icon
                    id="icon"
                    src="{{ @$item['icon-url'] }}"
                    trigger="loop"
                    delay="2000"
                    stroke="{{ @$item['icon-stroke'] != '' ? @$item['icon-stroke'] : '' }}"
                    colors="{{ @$item['icon-color'] != '' ? @$item['icon-color'] : '' }}"
                    style="width:30px;height:30px; margin-right: 3px">
                </lord-icon>
                @else
                    @if ($item['sub-icon'] != '')
                        <i class="{{ $item['sub-icon'] }}" style="display: flex; justify-content: center; align-items: center; width:30px;height:30px; font-size: 20px; margin-right: 3px"></i>
                    @else
                        <i style="height:30px;"></i>
                    @endif
                @endif
                <span style="margin-left: 2px">{{ @$item['btn-name'] }}</span>
            </div>
        </div>
        </label>
    @endif
@endforeach
{{-- <script>
    $(document).ready(function () {
        let selectedValue = $("input[name='{{ $item['radio-name'] }}']:checked").length;
        let renderHtml = "<span class='text-danger err_con rounded px-2 py-1 bg-danger bg-opacity-50'>{{ $item['MsgValid'] }}</span>";
        console.log(selectedValue);
        const formBtn = document.getElementById('formdata');

        $('#formdata').submit(function(e) {
            e.preventDefault();

            if($("input[name='{{ $item['radio-name'] }}']:checked").length !== 0) {
                $(this).submit();
                $('#showMsg_{{ $item['radio-name'] }}').hide();
            } else {
                $('#showMsg_{{ $item['radio-name'] }}').html(renderHtml).slideDown('slow');
            }
        });
    });
</script> --}}