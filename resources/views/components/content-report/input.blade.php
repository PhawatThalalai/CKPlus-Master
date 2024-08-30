<input type="hidden" name="form" value="{{ @$data['form'] }}" />
<input type="hidden" name="report" value="{{ @$data['report'] }}" />
<input type="hidden" name="typeProfit" value="{{ @$data['reportTitle'] === 'รายงานกำไรตามวันครบกำหนดชำระ' ? 'profitFollowDate' : 'profit' }}" />
<div class="mx-3">
    <div class="row d-flex justify-content-center">
        <div class="row mb-2">
                <div class="col-12 col-lg-6" style="{{@$data['report'] == 'Store' ? 'width: 100%;' : '' }}">
                    <div id="search_box">
                        <div class="input-daterange input-group" id="datepicker6" data-date-format="dd-mm-yyyy" data-date-autoclose="true" data-provide="datepicker" data-date-container="#search_box" data-date-format="dd-mm-yyyy" data-date-language="th">
                            <div class="form-group {{@$data['report'] == 'Store' ? 'col-12' : 'col-6' }}  mb-0">
                                <label class="col col-form-label text-right textSize-13">{{@$data['report'] == 'Store' ? 'เดือนที่' : 'จากวันที่ ' }}:</label>
                                <input type="text" class="form-control form-control-sm textSize-13" style="width: 100%;" name="Fdate" id="Fdate" value="{{date('d-m-Y')}}" placeholder="Start Date"  readonly>
                            </div>
                            <div class="form-group col-6 mb-0" style="{{@$data['report'] == 'Store' ? 'display: none;' : '' }}">
                                <label class="col col-form-label text-right textSize-13">ถึงวันที่ :</label>
                                <input type="text" class="form-control form-control-sm textSize-13" name="Tdate" id="Tdate" value="{{date('d-m-Y')}}" placeholder="End Date" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6" style="{{@$data['report'] == 'Store'  ? 'display: none;' : '' }}">
                    <div class="form-group col mb-0">
                        <label class="col-sm-3 col-form-label text-right textSize-13">สาขา :</label>
                        <select name="Branch_Con" class="form-control form-control-sm textSize-13"  >
                            <option value="" selected>--- สาขา ---</option>
                            @foreach (@$data['dataBranchs'] as $key => $value)
                                <option value="{{ $value->id }}">({{ $value->NickName_Branch }}) - {{ $value->Name_Branch }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-4" style="{{@$data['report'] == 'profit'  ? '' : 'display: none; width: 100%;' }}">
                    <div class="col-12" style="width: 100%;">
                        <div class="input-bx">
                            <input type="text" class="form-control form-control-sm textSize-13" name="CONTNO" id="CONTNO" value="" placeholder="" >
                            <span>เลขที่สัญญา</span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6" style="{{@$data['report'] == 'Payment' ? '':'display: none;' }}">
                    <div class="form-group col mb-0">
                        <label class="col-sm-3 col-form-label text-right textSize-13">เจ้าหน้าที่ :{{@$data['report']}} </label>
                        <select id="slEmpy" name="empy" class="form-control form-control-sm textSize-13" >
                            <option value="" selected>--- เจ้าหน้าที่ ---</option>
                            @foreach (@$data['dataEmpy'] as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @hasrole(['administrator', 'superadmin'])
                <div class="col-12 col-lg-6" style="{{@$data['report'] == 'Store' || @$data['report'] == 'profit' || @$data['report'] == 'Debtor' || @$data['report'] == 'ApproveLoan' ? 'display: none;' : '' }}">
                    <div class="form-group col mb-0">
                        <label class="col-sm-3 col-form-label text-right textSize-13">โซน :</label>
                        <select id="slZone" name="zone" class="form-control form-control-sm textSize-13" >
                            <option value="" selected>--- โซน ---</option>
                            @foreach (@$data['dataZone'] as $key => $value)
                                <option value="{{ $value->Zone_Code }}">{{ $value->Zone_Name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                @endhasrole
            </div>
            <div  class="row mb-2">
                <div class="col-12 col-lg-6" style="{{@$data['report'] === 'Normaltax' || @$data['report'] == 'Store' ? 'display: none;' : '' }}">
                    <div class="form-group col-12 mb-0">
                        <label class="col-sm-12 col-form-label text-right textSize-13">ประเภทเงินกู้ : <label id="showMsg_tableLoan"></label></label>
                        <div class="card__radio_display">
                            @php
                                $card_radio_data = [
                                        [
                                            'icon-url' => 'https://cdn.lordicon.com/jtiihjyw.json',
                                            'icon-color' => 'primary:#1d6f42,secondary:#ebe6ef',
                                            'icon-stroke' => 'bold',
                                            'sub-icon' => 'fas fa-biking',
                                            'radio-name' => 'tableLoan',
                                            'btn-name' => 'เงินกู้',
                                            'btn-value' => 'PSL',
                                            'btn-checked' => true,
                                            'color' => 'info',
                                            'width' => '',
                                            'MsgValid' => 'กรุณาเลือกประเภทเงินกู้',
                                        ],
                                        [
                                            'icon-url' => 'https://cdn.lordicon.com/jtiihjyw.json',
                                            'icon-color' => 'primary:#dc2f02,secondary:#ebe6ef',
                                            'icon-stroke' => 'bold',
                                            'sub-icon' => 'fas fa-biking',
                                            'radio-name' => 'tableLoan',
                                            'btn-name' => 'เช่าซื้อ',
                                            'btn-value' => 'HP',
                                            'btn-checked' => false,
                                            'color' => 'primary',
                                            'width' => '',
                                            'MsgValid' => 'กรุณาเลือกประเภทเงินกู้',
                                        ],
                                    ];
                            @endphp
                            @component('components.card-radio')
                                @slot('data', [
                                    'data-arr' => $card_radio_data
                                ])
                            @endcomponent
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6" style="{{@$data['report'] === 'Normaltax' || @$data['report'] == 'Store' ? 'display: none;' : '' }}">
                    <div class="form-group col-12 mb-0">
                        <label class="col-sm-12 col-form-label text-right textSize-13">ประเภท : <label id="showMsg_typeReport"></label></label>
                        <div class="card__radio_display">
                            @php
                                $card_radio_data = [
                                        [
                                            'icon-url' => 'https://cdn.lordicon.com/ujxzdfjx.json',
                                            'icon-color' => 'primary:#1d6f42,secondary:#ebe6ef',
                                            'icon-stroke' => 'bold',
                                            'sub-icon' => 'fas fa-biking',
                                            'radio-name' => 'typeReport',
                                            'btn-name' => 'EXCEL',
                                            'btn-value' => 'Excel',
                                            'btn-checked' => true,
                                            'color' => '',
                                            'width' => '',
                                            'MsgValid' => 'กรุณาเลือกประเภทไฟล์',
                                        ],
                                        [
                                            'icon-url' => 'https://cdn.lordicon.com/ujxzdfjx.json',
                                            'icon-color' => 'primary:#dc2f02,secondary:#ebe6ef',
                                            'icon-stroke' => 'bold',
                                            'sub-icon' => 'fas fa-biking',
                                            'radio-name' => 'typeReport',
                                            'btn-name' => 'PDF',
                                            'btn-value' => 'PDF',
                                            'btn-checked' => false,
                                            'color' => 'danger',
                                            'width' => '',
                                            'MsgValid' => 'กรุณาเลือกประเภทไฟล์',
                                        ],
                                    ];
                            @endphp
                            @component('components.card-radio')
                                @slot('data', [
                                    'data-arr' => $card_radio_data
                                ])
                            @endcomponent
                        </div>
                    </div>
                </div>
                <div id="redderHtml">

                </div>
                <div class="col" style="display: {{ @$data['report'] === 'Payment' ? '' : 'none' }}">
                    <div class="form-group col-12 mb-0">
                        <label class="d-flex col-sm-12 gap-x-2 col-form-label text-right textSize-13">ประเภทรายงานที่พิมพ์ : <label id="showMsg_tax"></label></label>
                        <div class="card__radio_display">
                            @php
                                $card_radio_data = [
                                        [
                                            'icon-url' => 'https://cdn.lordicon.com/zbbefawl.json',
                                            'icon-color' => 'primary:#1d6f42,secondary:#ebe6ef',
                                            'icon-stroke' => 'bold',
                                            'sub-icon' => 'fas fa-biking',
                                            'radio-name' => 'tax',
                                            'btn-name' => 'รับเงินค่างวด',
                                            'btn-value' => 'payReport',
                                            'btn-checked' => true,
                                            'color' => 'secondary',
                                            'width' => '',
                                            'MsgValid' => 'กรุณาเลือกประเภทรายงานที่พิมพ์',
                                        ],
                                        [
                                            'icon-url' => 'https://cdn.lordicon.com/zbbefawl.json',
                                            'icon-color' => 'primary:#dc2f02,secondary:#ebe6ef',
                                            'icon-stroke' => 'bold',
                                            'sub-icon' => 'fas fa-biking',
                                            'radio-name' => 'tax',
                                            'btn-name' => 'รับชำระทั้งหมด',
                                            'btn-value' => 'sumDetail',
                                            'btn-checked' => false,
                                            'color' => 'warning',
                                            'width' => '',
                                            'MsgValid' => 'กรุณาเลือกประเภทรายงานที่พิมพ์',
                                        ],
                                        [
                                            'icon-url' => 'https://cdn.lordicon.com/zbbefawl.json',
                                            'icon-color' => 'primary:#dc2f02,secondary:#ebe6ef',
                                            'icon-stroke' => 'bold',
                                            'sub-icon' => 'fas fa-biking',
                                            'radio-name' => 'tax',
                                            'btn-name' => 'สรุปรับชำระ',
                                            'btn-value' => 'sumPay',
                                            'btn-checked' => false,
                                            'color' => '',
                                            'width' => '',
                                            'MsgValid' => 'กรุณาเลือกประเภทรายงานที่พิมพ์',
                                        ],
                                    ];
                            @endphp
                            @component('components.card-radio')
                                @slot('data', [
                                    'data-arr' => $card_radio_data
                                ])
                            @endcomponent
                        </div>
                    </div>
                </div>
                {{-- <div class="col" style="display: {{ @$data['report'] === 'profit' ? '' : 'none' }}">
                    <div class="form-group col-12 mb-0">
                        <label class="d-flex col-sm-12 gap-x-2 col-form-label text-right textSize-13">ประเภทรายงานที่พิมพ์ : <label id="showMsg_tax"></label></label>
                        <div class="card__radio_display">
                            @php
                                $card_radio_data = [
                                        [
                                            'icon-url' => 'https://cdn.lordicon.com/lxizbtuq.json',
                                            'icon-color' => 'primary:#1d6f42,secondary:#ebe6ef',
                                            'icon-stroke' => 'bold',
                                            'sub-icon' => 'fas fa-biking',
                                            'radio-name' => 'typeProfit',
                                            'btn-name' => 'รายงานกำไรคงเหลือ',
                                            'btn-value' => 'profit',
                                            'btn-checked' => true,
                                            'color' => 'secondary',
                                            'width' => '',
                                            'MsgValid' => 'กรุณาเลือกประเภทรายงานที่พิมพ์',
                                        ],
                                        [
                                            'icon-url' => 'https://cdn.lordicon.com/lxizbtuq.json',
                                            'icon-color' => 'primary:#dc2f02,secondary:#ebe6ef',
                                            'icon-stroke' => 'bold',
                                            'sub-icon' => 'fas fa-biking',
                                            'radio-name' => 'typeProfit',
                                            'btn-name' => 'รายงานกำไรตามวันครบกำหนดชำระ',
                                            'btn-value' => 'profitFollowDate',
                                            'btn-checked' => false,
                                            'color' => 'warning',
                                            'width' => '',
                                            'MsgValid' => 'กรุณาเลือกประเภทรายงานที่พิมพ์',
                                        ],
                                    ];
                            @endphp
                            @component('components.card-radio')
                                @slot('data', [
                                    'data-arr' => $card_radio_data
                                ])
                            @endcomponent
                        </div>
                    </div>
                </div> --}}
            </div>
    </div>
</div>
@if (@$data['report'] === 'profit')
    <script>
        $(document).ready(function () {
            $('input[name="tableLoan"]').change(function () {
                let tableLoan = $('input[name="tableLoan"]:checked').val();
                const htmlElememt = `
                    <div class="col">
                        <div class="form-group col-12 mb-0">
                            <label class="d-flex col-sm-12 gap-x-2 col-form-label text-right textSize-13">ประเภทของเงินกู้ : <label id="showMsg_tax"></label></label>
                            <div class="card__radio_display">
                                @php
                                    $card_radio_data = [
                                            [
                                                'icon-url' => 'https://cdn.lordicon.com/kndkiwmf.json',
                                                'icon-color' => 'primary:#121331,secondary:#5c0a33',
                                                'icon-stroke' => 'bold',
                                                'sub-icon' => 'fas fa-biking',
                                                'radio-name' => 'CONTTYPE',
                                                'btn-name' => 'เงินกู้',
                                                'btn-value' => '1',
                                                'btn-checked' => true,
                                                'color' => 'secondary',
                                                'width' => '',
                                                'MsgValid' => 'กรุณาเลือกประเภทรายงานที่พิมพ์',
                                            ],
                                            [
                                                'icon-url' => 'https://cdn.lordicon.com/kndkiwmf.json',
                                                'icon-color' => 'primary:#121331,secondary:#5c0a33',
                                                'icon-stroke' => 'bold',
                                                'sub-icon' => 'fas fa-biking',
                                                'radio-name' => 'CONTTYPE',
                                                'btn-name' => 'เงินกู้ที่ดิน',
                                                'btn-value' => '2',
                                                'btn-checked' => false,
                                                'color' => 'warning',
                                                'width' => '',
                                                'MsgValid' => 'กรุณาเลือกประเภทรายงานที่พิมพ์',
                                            ],
                                            [
                                                'icon-url' => 'https://cdn.lordicon.com/kndkiwmf.json',
                                                'icon-color' => 'primary:#121331,secondary:#5c0a33',
                                                'icon-stroke' => 'bold',
                                                'sub-icon' => 'fas fa-biking',
                                                'radio-name' => 'CONTTYPE',
                                                'btn-name' => 'เงินกู้ที่ดินระยะสั้น',
                                                'btn-value' => '3',
                                                'btn-checked' => false,
                                                'color' => '',
                                                'width' => '',
                                                'MsgValid' => 'กรุณาเลือกประเภทรายงานที่พิมพ์',
                                            ],
                                        ];
                                @endphp
                                @component('components.card-radio')
                                    @slot('data', [
                                        'data-arr' => $card_radio_data
                                    ])
                                @endcomponent
                            </div>
                        </div>
                    </div>
                `;
                if (tableLoan === 'PSL') {
                    $("#redderHtml").html(htmlElememt).slideDown('slow');
                } else {
                    $("#redderHtml").html("").slideDown('slow');
                }
            })
        });
    </script>
@endif
