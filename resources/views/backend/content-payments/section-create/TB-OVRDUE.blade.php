<input type="hidden" value="{{ $CODLOAN }}" id="CODLOAN">
<input type="hidden" value="{{ $CONTTYP }}" id="CONTTYP">

<div class="table-responsive" data-simplebar="init" style="max-height: 400px;">
    <table class="table  table-bordered table-hover table-head-fixed text-nowrap font-size-11" id="tbl_overdue">
        <thead class="table-warning sticky-top" style="line-height: 130%;">
            <tr>
                <th scope="col" class="text-center">งวดที่</th>
                <th scope="col" class="text-center">วันครบกำหนด</th>
                <th scope="col" class="text-center">ค่างวด</th>
                <th scope="col" class="text-center">ดอกเบี้ย</th>
                <th scope="col" class="text-center">เงินต้น</th>
                <th scope="col" class="text-center">วันที่ชำระ</th>
                <th scope="col" class="text-center">ชำระงวดนี้</th>
                @if ($CODLOAN == 1)
                    <th scope="col" class="text-center">ชำระดอกเบี้ย</th>
                    <th scope="col" class="text-center">ชำระเงินต้น</th>
                @endif
                <th scope="col" class="text-center">วันล่าช้า</th>
                <th scope="col" class="text-center">ดอกเบี้ย</th>
                @if ($CODLOAN == 1)
                    <th scope="col" class="text-center">เงินต้นคงเหลือ</th>
                    <th scope="col" class="text-center">วันคิดดอกเบี้ย</th>
                @endif
            </tr>
        </thead>

        @php
            $sumInt = 0;
            $sumPAYAMT = 0;
            $balanceInt = 0;
            $PAYINT = $dataInt != null ? $dataInt[0]->PAYINT : 0;
            $DSCINT = $dataInt != null ? $dataInt[0]->DSCINT : 0;
        @endphp
        @if ($CODLOAN == 1)
            <tbody class="font-size-11">
                @if ($CONTTYP == 1)
                    @foreach ($data as $key => $value)
                        <tr class="{{ $value->date1 == null && date('Y-m-d', strtotime($value->ddate)) < date('Y-m-d') ? 'bg-danger bg-soft' : '' }}">
                            <td class="text-center">{{ $value->nopay }}</td>
                            <td class="text-center">{{ date('d-m-Y', strtotime($value->ddate)) }}</td>
                            <td class="text-end">{{ number_format($value->damt, 2) }}</td>
                            <td class="text-end">{{ number_format($value->interest, 2) }}</td>
                            <td class="text-end">{{ number_format($value->capital, 2) }}</td>
                            <td class="text-center">{{ $value->date1 != null ? date('d-m-Y', strtotime($value->date1)) : '' }}</td>
                            <td class="text-end">{{ number_format(@$value->PaydueToDuepay->PAYAMT, 2) }}</td>
                            <td class="text-end">{{ number_format(@$value->PaydueToDuepay->PAYINTEFF, 2) }}</td>
                            <td class="text-end">{{ number_format(@$value->PaydueToDuepay->PAYTON, 2) }}</td>
                            <td class="text-danger text-center">{{ number_format(@$value->PaydueToDuepay->INTLATEDAY, 0) }}</td>
                            <td class="text-danger text-end">{{ @$value->PaydueToDuepay->INTLATEAMT }}</td>
                            <td class="text-end">{{ number_format(@$value->PaydueToDuepay->TONBALANCE, 2) }}</td>
                            <td class="text-end">{{ $value->daycalint }}</td>
                        </tr>
                        @php
                            $sumPAYAMT += @$value->PaydueToDuepay->PAYAMT;
                            $sumInt += @$value->PaydueToDuepay->INTLATEAMT;
                        @endphp
                    @endforeach
                @endif
            </tbody>
            <tfoot class="table-warning sticky-bottom" style="line-height: 130%;">
                <tr >
                    <th class="text-center">ผ่อน {{ $data->count('nopay') }}</th>
                    <th></th>
                    <th></th>
                    <th class="text-end">{{ number_format($data->sum('interest'), 2) }}</th>
                    <th class="text-end">{{ number_format($data->sum('capital'), 2) }}</th>
                    <th></th>
                    <th class="text-end">{{ number_format($data->sum('payment'), 2) }}</th>
                    <th class="text-end">{{ number_format($data->sum('V_PAYMENT'), 2) }}</th>
                    <th class="text-end">{{ number_format($data->sum('N_PAYMENT'), 2) }}</th>
                    <th class="text-end"></th>
                    <th class="text-end"></th>
                    <th class="text-end"></th>
                    <th class="text-end"></th>
                </tr>
            </tfoot>
        @else
            <tbody class="font-size-11">
                @foreach ($data as $key => $value)
                    <tr class="{{ $value->date1 == null && date('Y-m-d', strtotime($value->ddate)) < date('Y-m-d') ? 'bg-danger bg-soft' : '' }}">
                        <td class="text-center">{{ $value->nopay }}</td>
                        <td class="text-center">{{ date('d-m-Y', strtotime($value->ddate)) }}</td>
                        <td class="text-end">{{ number_format($value->damt, 2) }}</td>
                        <td class="text-end">{{ number_format($value->interest, 2) }}</td>
                        <td class="text-end">{{ number_format($value->capital, 2) }}</td>
                        <td class="text-center">{{ $value->date1 != null ? date('d-m-Y', strtotime($value->date1)) : '' }}</td>
                        <td class="text-end">{{ number_format($value->payment, 2) }}</td>
                        <td class="text-danger text-center">{{ $value->delayday }}</td>
                        <td class="text-danger text-end">{{ $value->intamt }}</td>
                    </tr>
                    @php
                        $sumInt = $sumInt + $value->intamt;
                    @endphp
                @endforeach
            </tbody>
            <tfoot class="table-warning sticky-bottom" style="line-height: 130%;">
                <tr>
                    <th class="text-center">ผ่อน {{ $data->count('nopay') }}</th>
                    <th style="text-center"></th>
                    <th style="text-center"></th>
                    <th class="text-end">{{ number_format($data->sum('interest'), 2) }} บาท</th>
                    <th class="text-end">{{ number_format($data->sum('capital'), 2) }} บาท</th>
                    <th style="text-center"></th>
                    <th style="text-center"></th>
                    <th style="text-center"></th>
                    <th style="text-center"></th>
                </tr>
            </tfoot>
        @endif
    </table>
</div>


@if ($CODLOAN == 1)
<table class="table">
    <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col">เบี้ยปรับ</th>
            <th scope="col">{{ $sumInt }} บาท</th>
            <th scope="col"></th>
            <th scope="col">ชำระเเล้ว</th>
            <th scope="col">{{ number_format(@$sumPAYAMT, 2) }} บาท</th>
            <th scope="col"></th>
            <th scope="col">ส่วนลด</th>
            <th scope="col">{{ $DSCINT }}</th>
            <th scope="col"></th>
            <th scope="col">คงเหลือ</th>
            <th scope="col">{{ $sumInt - (floatval($PAYINT) + floatval($DSCINT)) }} บาท</th>
            <th scope="col"></th>
        </tr>
    </thead>
</table>
@else
<table class="table">
    <thead>
        <tr>
            <th scope="col"></th>
            <th scope="col">เบี้ยปรับ</th>
            <th scope="col">{{ $sumInt }} บาท</th>
            <th scope="col"></th>
            <th scope="col">ชำระเเล้ว</th>
            <th scope="col">{{ isset($data->PaydueToDuepay) ? number_format($data->PaydueToDuepay->sum('PAYAMT'), 2) : 0 }} บาท</th>
            <th scope="col"></th>
            <th scope="col">ส่วนลด</th>
            <th scope="col">{{ $DSCINT }}</th>
            <th scope="col"></th>
            <th scope="col">คงเหลือ</th>
            <th scope="col">{{ $sumInt - (floatval($PAYINT) + floatval($DSCINT)) }} บาท</th>
            <th scope="col"></th>
        </tr>
    </thead>
</table>
@endif
