{{-- function and variable php  --}}
@php
    // dump(@$checkboxValue);
    // dump(@$editProcess_Car);
    // dump(@$InterestValue);
    // dump(@$InterestYearValue);
    // dump(@$ProcessValue);
    $dataArr = [];
    $AddOPR = [];
    $NonOPR = [];
    function CalPA($dataPA, $Installment, $totalPeriod)
    {
        $Installment = 'TimeRack' . $Installment;
        foreach ($dataPA as $itemPA) {
            if ($totalPeriod < $dataPA[count($dataPA) - 1]->Limit_Insur) {
                if ($itemPA->Limit_Insur > $totalPeriod) {
                    $InstallmentPA = $itemPA[$Installment];
                    $textPlan = $itemPA['Plan_Insur'];
                    $Plan = $itemPA->id;
                    $Limit_Insur = $itemPA['Limit_Insur'];
                    $num_plan = $itemPA['PlanId'];
                    break;
                }
            } else {
                $InstallmentPA = $dataPA[count($dataPA) - 1][$Installment];
                $Plan = $dataPA[count($dataPA) - 1]->id;
                $textPlan = $dataPA[count($dataPA) - 1]['Plan_Insur'];
                $Limit_Insur = $dataPA[count($dataPA) - 1]['Limit_Insur'];
                $num_plan = $dataPA[count($dataPA) - 1]['PlanId'];
            }
        }
        $Data = [
            'InstallmentPA' => $InstallmentPA,
            'Plan' => $Plan,
            'textPlan' => $textPlan,
            'Limit_Insur' => $Limit_Insur,
            'PlanId' => $num_plan,
        ];
        return $Data;
    }
    // $editProcess_Car = $editProcess_Car ?? 'off'; // กำหนดค่าเริ่มต้นเป็น 'off' หากยังไม่มีการกำหนดค่า
    // $checkboxValue = $checkboxValue ?? 'off';
@endphp

{{-- ตารางค่างวด --}}
@if (@$data != null)

    <div class="table-responsive mt-2">
        <table class="table table-sm text-center table-hover ">
            <thead class="bg-secondary bg-soft">
                <tr class="boerder border-1 border-bottom border-dark">
                    <th>งวด</th>
                    <th>ยอดจัด</th>
                    <th>ดอกเบี้ย</th>
                    <th>ยอดผ่อน</th>
                    <th class="show_PA">ยอดผ่อน + PA</th>
                    <th class="show_diff">ส่วนต่าง</th>
                </tr>
            </thead>
            <tbody id="TB-Installment">
                @foreach ($data as $item)
                    @php
                        if ($Type_Customer == 'CUS-0009') {
                            $interestInput = @$IntSpecial;
                        } else {
                            $interestInput = $item->Interest;
                        }
                        $arrLeasing = ['16', '18'];
                        if (in_array($item->Type_Leasing, $arrLeasing) != true) {
                            // ไม่ใช่เงินกู้ที่ดินระยะสั้น
                            $Vat = $item->Vat / 100 + 1; // Vat

                            // $Flag_operate_fee = floor(($Cash_Car * ($item->Operation_Fee / 100)) / 100) * 100; // ค่าดำเนินการ

                            // กรณีที่ checkbox เปิดอยู่ ให้ใช้ค่าจาก ProcessValue โดยตรง
                            if (@$editProcess_Car == 'on') {
                                $Flag_operate_fee = $ProcessValue;
                                $operate_fee = $ProcessValue;
                            } else {
                                // ใช้เงื่อนไขเดิมในการคำนวณค่าดำเนินการ
                                if (@$Type_Customer == 'CUS-0004') {
                                    if ($item->Type_Leasing == '04') {
                                        $Flag_operate_fee =
                                            floor(($Cash_Car * ($item->Operation_Fee / 100)) / 100) * 100; // ค่าดำเนินการ
                                    } else {
                                        $Flag_operate_fee = floor(($Cash_Car * 0.023) / 100) * 100; // ค่าดำเนินการ
                                    }
                                } else {
                                    $Flag_operate_fee = floor(($Cash_Car * ($item->Operation_Fee / 100)) / 100) * 100; // ค่าดำเนินการ
                                }

                                // เช็คค่าดำเนินการขั้นต่ำ
                                if ($Flag_operate_fee < $item->MinOperation_Fee) {
                                    $Flag_operate_fee = $item->MinOperation_Fee;
                                }
                            }

                            // สำหรับการคำนวณดอกเบี้ย
                            if (@$checkboxValue == 'on') {
                                $interestInput = $InterestValue;
                            } else {
                                $interestInput = $item->Interest;
                            }
                            // dd($Flag_operate_fee);
                            // รวมค่าดำเนินการ
                            $operate_feeInclude = $Flag_operate_fee; // ค่าดำเนินการ
                            $periodInclude =
                                ((($Cash_Car + $operate_feeInclude) * ($interestInput / 100) * $item->Installment +
                                    ($Cash_Car + $operate_feeInclude)) /
                                    $item->Installment) *
                                $Vat; // ค่างวดปกติไม่มี PA
                            $totalPeriodInclude =
                                ($Cash_Car + $operate_feeInclude) * ($interestInput / 100) * $item->Installment +
                                ($Cash_Car + $operate_feeInclude); // ยอดผ่อนรวม

                            $CalPAInOPR = CalPA($dataPA, $item->Installment, $totalPeriodInclude);
                            $Flag_InstallmentPAInclude = $CalPAInOPR['InstallmentPA'];
                            $InstallmentPAInclude = $CalPAInOPR['InstallmentPA'];
                            $totalPeriodInclude = ceil($periodInclude) * $item->Installment; // ดอกเบี้ยรวม
                            $Period_PAInclude =
                                ((($Cash_Car + $InstallmentPAInclude + $operate_feeInclude) *
                                    ($interestInput / 100) *
                                    $item->Installment +
                                    ($Cash_Car + $InstallmentPAInclude + $operate_feeInclude)) /
                                    $item->Installment) *
                                $Vat; // ค่างวดมี PA
                            $totalIntInclude =
                                $totalPeriodInclude - ($Cash_Car + $InstallmentPAInclude + $operate_feeInclude); // ดอกเบี้ย

                            // ไม่รวมค่าดำเนินการ
                            $operate_fee = 0; // ค่าดำเนินการ
                            $period =
                                (($Cash_Car * ($interestInput / 100) * $item->Installment +
                                    ($Cash_Car + $operate_fee)) /
                                    $item->Installment) *
                                $Vat; // ค่างวดปกติไม่มี PA
                            $totalPeriod =
                                ($Cash_Car + $operate_fee) * ($interestInput / 100) * $item->Installment +
                                ($Cash_Car + $operate_fee); // ยอดผ่อนรวม

                            $CalPANonOPR = CalPA($dataPA, $item->Installment, $totalPeriod);
                            $Flag_InstallmentPA = $CalPANonOPR['InstallmentPA'];
                            $InstallmentPA = $CalPANonOPR['InstallmentPA'];
                            $totalPeriod = ceil($period) * $item->Installment; // ดอกเบี้ยรวม
                            $Period_PA =
                                ((($Cash_Car + $InstallmentPA + $operate_fee) *
                                    ($interestInput / 100) *
                                    $item->Installment +
                                    ($Cash_Car + $InstallmentPA + $operate_fee)) /
                                    $item->Installment) *
                                $Vat; // ค่างวดมี PA
                            $totalInt = $totalPeriod - ($Cash_Car + $InstallmentPA + $operate_fee); // ดอกเบี้ย
                        } else {
                            // จำนอง ขายฝาก
                            $Vat = $item->Vat / 100 + 1; // Vat
                            $operate_feeInclude = floor(($Cash_Car * ($item->Operation_Fee / 100)) / 100) * 100; // ค่าดำเนินการ

                            if (@$Type_Customer == 'CUS-0009') {
                                $Flag_operate_fee = 0; // ค่าดำเนินการ
                            } else {
                                $Flag_operate_fee = floor(($Cash_Car * ($item->Operation_Fee / 100)) / 100) * 100; // ค่าดำเนินการ
                            }

                            if ($Flag_operate_fee > floatVal($item->MinOperation_Fee)) {
                                $Flag_operate_fee = $Flag_operate_fee;
                            } else {
                                $Flag_operate_fee = $item->MinOperation_Fee;
                            }

                            //  รวมค่าดำเนินการ
                            $operate_feeInclude = $Flag_operate_fee; // ค่าดำเนินการ
                            $periodInclude =
                                ((($Cash_Car + $operate_feeInclude) * ($interestInput / 100) * $item->Installment +
                                    ($Cash_Car + $operate_feeInclude)) /
                                    $item->Installment) *
                                $Vat; // ค่างวดปกติไม่มี PA
                            $totalPeriodInclude = ceil($periodInclude) * $item->Installment; // ยอดผ่อนรวม
                            $periodInclude = ($totalPeriodInclude - $Cash_Car - $Flag_operate_fee) / $item->Installment;

                            $CalPAInOPR = CalPA($dataPA, $item->Installment, $totalPeriodInclude);
                            $Flag_InstallmentPAInclude = $CalPAInOPR['InstallmentPA'];
                            $InstallmentPAInclude = $CalPAInOPR['InstallmentPA'];
                            $totalPeriodInclude = ceil($periodInclude) * $item->Installment; // ดอกเบี้ยรวม
                            $Period_PAInclude =
                                ((($Cash_Car + $InstallmentPAInclude + $operate_feeInclude) *
                                    ($interestInput / 100) *
                                    $item->Installment +
                                    ($Cash_Car + $InstallmentPAInclude + $operate_feeInclude)) /
                                    $item->Installment) *
                                $Vat; // ค่างวดมี PA
                            $totalIntInclude = $Period_PAInclude * $item->Installment; // ดอกเบี้ย
                            $Period_PAInclude =
                                ($totalIntInclude - ($Cash_Car + $InstallmentPAInclude + $operate_feeInclude)) /
                                $item->Installment;

                            // ไม่รวมค่าดำเนินการ
                            $operate_fee = 0; // ค่าดำเนินการ
                            $period =
                                ((($Cash_Car + $operate_fee) * ($interestInput / 100) * $item->Installment +
                                    ($Cash_Car + $operate_fee)) /
                                    $item->Installment) *
                                $Vat; // ค่างวด
                            $totalPeriod = $period * $item->Installment; // ยอดผ่อนรวม
                            $period = ($totalPeriod - $Cash_Car - $operate_fee) / $item->Installment;

                            $CalPANonOPR = CalPA($dataPA, $item->Installment, $totalPeriod);
                            $Flag_InstallmentPA = $CalPANonOPR['InstallmentPA'];
                            $InstallmentPA = $CalPANonOPR['InstallmentPA'];
                            $totalPeriod = ceil($period) * $item->Installment; // ดอกเบี้ยรวม
                            $Period_PA =
                                ((($Cash_Car + $InstallmentPA + $operate_fee) *
                                    ($interestInput / 100) *
                                    $item->Installment +
                                    ($Cash_Car + $InstallmentPA + $operate_fee)) /
                                    $item->Installment) *
                                $Vat; // ค่างวดมี PA
                            $totalInt = $Period_PA * $item->Installment; // ดอกเบี้ย
                            $Period_PA = ($totalInt - ($Cash_Car + $InstallmentPA + $operate_fee)) / $item->Installment;
                        }
                        // loopData
                        $Installment = $item->Installment;
                        $Interest = $interestInput;
                        $Type_Leasing = $item->Type_Leasing;

                        // คำนวณค่าคอมมิชชั่น

                        //เก็บตัวแปรไว้คำนวนค่าคอม
                        if ($item->Installment > 48) {
                            $Installment_com = 48;
                        } else {
                            $Installment_com = $item->Installment;
                        }

                        $VAL_IntPeriod_com = (($Cash_Car * floatval($interestInput)) / 100) * intval($Installment_com); //ดอกเบั้ยรวม
                        $Total_IntPeriod_com = round($VAL_IntPeriod_com); //ดอกเบั้ยรวมปัดเศษ

                        if ($Buy_PA == 'yes' && $Include_PA == 'yes') {
                            $Period_TB = $Period_PA;
                            $totalPeriod_TB = $totalPeriod;
                            $topupPA = $InstallmentPA;
                        } else {
                            $Period_TB = $period;
                            $totalPeriod_TB = $totalPeriod;
                            $topupPA = 0;
                        }

                        if (
                            $item->Type_Leasing == 04 ||
                            $item->Type_Leasing == 15 ||
                            $item->Type_Leasing == 16 ||
                            $item->Type_Leasing == 18
                        ) {
                            // เช็คค่าแนะนำที่ดิน
                            $Commission = round((intval($Cash_Car) * (intval($item->Commission) / 100)) / 100) * 100; //ค่าแนะนำ
                            if ($Commission >= 2000) {
                                // ค่าคอมมิชชั่นต้องไม่มากกว่า 3000
                                $Commission = 2000;
                            }
                        } elseif ($item->Type_Leasing == 01) {
                            // เช็คค่าแนะนำเช่าซื้อ
                            $Commission =
                                floor(
                                    (((floatval($interestInput) * $Installment_com) / 100) *
                                        intval($Cash_Car + $topupPA) *
                                        (intval($item->Commission) / 100)) /
                                        100,
                                ) * 100;
                            if ($Commission >= 3000) {
                                // ค่าคอมมิชชั่นต้องไม่มากกว่า 3000
                                $Commission = 3000;
                            }
                        } else {
                            // เช็คค่าแนะนำเงืินกู้

                            $Commission =
                                round((intval($Total_IntPeriod_com) * (intval($item->Commission) / 100)) / 100) * 100; //ค่าแนะนำ
                            if ($Commission >= 3000) {
                                // ค่าคอมมิชชั่นต้องไม่มากกว่า 3000
                                $Commission = 3000;
                            }
                        }

                        // เก็บค่าลง Session
                        array_push($dataArr, [
                            'AddOPR' => [
                                'Cash_Car' => $Cash_Car + $Flag_operate_fee,
                                'Period' => ceil(@$periodInclude),
                                'Type_Leasing' => $item->Type_Leasing,
                                'Installment' => $Installment,
                                'Interest' => $Interest,
                                'totalInt' => $totalIntInclude,
                                'Period_PA' => ceil(@$Period_PAInclude),
                                0,
                                'totalPeriod' => $totalPeriodInclude,
                                'Flag_operate_fee' => $Flag_operate_fee,
                                'Flag_InstallmentPA' => $Flag_InstallmentPAInclude,
                                'Plan' => $CalPAInOPR['Plan'],
                                'Limit_Insur' => $CalPAInOPR['Limit_Insur'],
                                'Commission' => $Commission,
                                'totalPeriod_HasPA' =>
                                    ceil(@$Period_PAInclude) * $Installment +
                                    (in_array($item->Type_Leasing, $arrLeasing) == true
                                        ? $Cash_Car + $Flag_operate_fee
                                        : 0),
                                'totalPeriod_NonPA' =>
                                    ceil($periodInclude) * $Installment +
                                    (in_array($item->Type_Leasing, $arrLeasing) == true
                                        ? $Cash_Car + $Flag_operate_fee
                                        : 0),
                                'PlanId' => $CalPAInOPR['PlanId'],
                            ],
                            'NonOPR' => [
                                'Cash_Car' => $Cash_Car,
                                'Period' => ceil($period),
                                'Type_Leasing' => $item->Type_Leasing,
                                'Installment' => $Installment,
                                'Interest' => $Interest,
                                'totalInt' => $totalInt,
                                'Period_PA' => ceil(@$Period_PA),
                                'totalPeriod' => $totalPeriod,
                                'Flag_operate_fee' => $Flag_operate_fee,
                                'Flag_InstallmentPA' => $Flag_InstallmentPA,
                                'Plan' => $CalPANonOPR['Plan'],
                                'Limit_Insur' => $CalPANonOPR['Limit_Insur'],
                                'Commission' => $Commission,
                                'totalPeriod_HasPA' =>
                                    ceil(@$Period_PA) * $Installment +
                                    (in_array($item->Type_Leasing, $arrLeasing) == true ? $Cash_Car : 0),
                                'totalPeriod_NonPA' =>
                                    ceil($period) * $Installment +
                                    (in_array($item->Type_Leasing, $arrLeasing) == true ? $Cash_Car : 0),
                                'PlanId' => $CalPAInOPR['PlanId'],
                            ],
                        ]);
                    @endphp
                    @if ($statusOPR == 'yes')
                        <tr id="row-{{ $item->Installment }}"
                            class="row-hilight {{ $item->Installment == @$Timelack_Car ? 'fw-semibold bg-success text-light px-4' : '' }}">
                            <th>{{ $item->Installment }}</th>
                            @if ($Include_PA == 'yes')
                                <td>{{ number_format($Cash_Car + $InstallmentPAInclude + $operate_feeInclude, 0) }}</td>
                            @else
                                <td>{{ number_format($Cash_Car + $operate_feeInclude, 0) }}</td>
                            @endif

                            <td>{{ $interestInput }}</td>
                            <th>{{ number_format(ceil($periodInclude), 0) }}</th>
                            <th class="show_PA">{{ number_format(ceil(@$Period_PAInclude), 0) }}</th>
                            <td class="show_diff">{{ ceil(@$Period_PAInclude) - ceil($periodInclude) }}</td>
                        </tr>
                    @elseif($statusOPR == 'no')
                        <tr id="row-{{ $item->Installment }}"
                            class="row-hilight {{ $item->Installment == @$Timelack_Car ? 'fw-semibold bg-success text-light px-4' : '' }}">
                            <th>{{ $item->Installment }} </th>
                            @if ($Include_PA == 'yes')
                                <td>{{ number_format($Cash_Car + $InstallmentPA + $operate_fee, 0) }}</td>
                            @else
                                <td>{{ number_format($Cash_Car + $operate_fee, 0) }}</td>
                            @endif
                            <td>{{ $interestInput }} </td>
                            <th>{{ number_format(ceil($period), 0) }}</th>
                            <th class="show_PA"> {{ number_format(ceil(@$Period_PA), 0) }}</th>
                            <td class="show_diff">{{ ceil(@$Period_PA) - ceil($period) }}</td>
                        </tr>
                    @else
                        <tr id="row-{{ $item->Installment }}"
                            class="row-hilight {{ $item->Installment == @$Timelack_Car ? 'fw-semibold bg-success text-light px-4' : '' }}">
                            <th>{{ $item->Installment }}</th>
                            <td>{{ number_format($Cash_Car, 0) }}</td>
                            <td>{{ $interestInput }}</td>
                            <th>{{ number_format(ceil($period), 0) }}</th>
                            <th class="show_PA">{{ number_format(ceil(@$Period_PA), 0) }}</th>
                            <td class="show_diff">{{ ceil(@$Period_PA) - ceil($period) }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="row">
        <div class="col text-center ">
            <img id="ImageBrok" src="{{ asset('/assets/images/empty-cart.png') }}"
                style="min-width: 8rem;height: 8rem;" class="mb-1">
        </div>
    </div>
@endif

{{-- ไว้เก็บข้อมูลลง SESSION --}}
<textarea hidden name="" id="dataArr" cols="30" rows="10">{{ json_encode(@$dataArr) }}</textarea>
<script>
    $(function() {
        let dataArr = $('#dataArr').val()
        sessionStorage.setItem('DataArr', dataArr) //บันทึกข้อมูลลง session

        let getdataArr = sessionStorage.getItem('DataArr') // เรียก session
        dataArr2 = JSON.parse(getdataArr)
        if (dataArr2 != '') {
            $('#Process_Car').val(dataArr2[0].AddOPR.Flag_operate_fee) // เก็บค่าดำเนินการลง input
        }
    })
</script>
