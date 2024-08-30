<style>
    .table-payment > tbody > tr:last-child  {
      border-bottom: 2px solid rgb(204, 122, 122);
    }
</style>

<div class="card">
	<div class="card-body">
		<!-- Nav tabs -->
		<ul class="nav nav-pills nav-justified" role="tablist">
			<li class="nav-item waves-effect waves-light" role="presentation">
				<a class="nav-link active" data-bs-toggle="tab" href="#table-1" role="tab" aria-selected="true">
					<span class="d-block d-sm-none"><i class="fas fa-home"></i></span>
					<span class="d-none d-sm-block">ตารางค่างวด</span>
				</a>
			</li>
			<li class="nav-item waves-effect waves-light" role="presentation">
				<a class="nav-link" data-bs-toggle="tab" href="#table-2" role="tab" aria-selected="false" tabindex="-1">
					<span class="d-block d-sm-none"><i class="far fa-user"></i></span>
					<span class="d-none d-sm-block">ลูกหนี้อื่นๆ</span>
				</a>
			</li>
		</ul>
		<!-- Tab panes -->
		<div class="tab-content pt-2 text-muted">
			<div class="tab-pane active show" id="table-1" role="tabpanel">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm mb-0 text text-nowrap table-hover table-payment" style="font-size: 11px;">
                        <thead>
                            <tr class="bg-info bg-soft">
                                <th>งวดที่</th>
                                <th>วันที่</th>
                                {{-- <th>จำนวนวัน</th> --}}
                                <th>ค่างวด</th>
                                <th>ดอกเบี้ย</th>
                                <th>เงินต้น</th>
                                <th>วันที่ชำระ</th>
                                <th>ยอดชำระ</th>
                                <th>ชำระดอกเบี้ย</th>
                                <th>ชำระเงินต้น</th>
                                <th>วันที่ล่าช้า</th>
                                <th>ดอกเบี้ยค้าง</th>
                                <th>รวมชำระ</th>
                            </tr>
                        </thead>
                        <tbody >
                            @php
                                $setdueamt = 0;
                                $setdueinteff = 0;
                                $setduetoneff = 0;
                                $setpayamt = 0;
                                $setpayinteff = 0;
                                $setpayton = 0;
                                $setINTLATEAMT = 0;
                                $setSum = 0;
                            @endphp
                            @if(!empty($Paydue))
                                @foreach($Paydue as $row)
                                    @php
                                        $setdueamt += $row['dueamt'];
                                        $setdueinteff += $row['dueinteff'];
                                        $setduetoneff += $row['duetoneff'];
                                        $setpayamt += $row['payamt'];
                                        $setpayinteff += $row['payinteff'];
                                        $setpayton += $row['payton'];
                                        $setINTLATEAMT += $row['INTLATEAMT'];
                                        $setSum += ($row['dueamt'] + $row['INTLATEAMT']);
                                    @endphp
                                    <tr>
                                        <td scope="row" class="bg-danger bg-soft text-center">{{$row['nopay']}}</td>
                                        <td scope="row" class="text-center">{{ date('d-m-Y', strtotime($row['duedate'])) }}</td>
                                        {{-- <td scope="row">{{$row['delayday']}}</td> --}}
                                        <td scope="row" class="text-end">{{$row['dueamt']}}</td>
                                        <td scope="row" class="text-end">{{$row['dueinteff']}}</td>
                                        <td scope="row" class="text-end">{{$row['duetoneff']}}</td>
                                        <td scope="row" class="text-center">{{ date('d-m-Y', strtotime($row['paydate'])) }}</td>
                                        <td scope="row" class="bg-danger bg-soft text-end">{{$row['payamt']}}</td>
                                        <td scope="row" class="text-end">{{$row['payinteff']}}</td>
                                        <td scope="row" class="text-end">{{$row['payton']}}</td>
                                        <td scope="row" class="text-end text-danger">{{$row['intlateday']}}</td>
                                        <td scope="row" class="text-end text-danger">{{$row['INTLATEAMT']}}</td>
                                        <td scope="row" class="bg-danger bg-soft text-end">{{number_format($row['dueamt'] + $row['INTLATEAMT'],0)}}</td>
                                    </tr>
                                @endforeach
                                <tr style="line-height: 200%;">
                                    <td></td>
                                </tr>
                                <tr class="bg-info bg-soft fw-bold text-decoration-underline">
                                    <td></td>
                                    <td></td>
                                    <td scope="cal" class="text-end">{{number_format(@$setdueamt,2)}}</td>
                                    <td scope="cal" class="text-end">{{number_format(@$setdueinteff,2)}}</td>
                                    <td scope="cal" class="text-end">{{number_format(@$setduetoneff,2)}}</td>
                                    <td></td>
                                    <td scope="cal" class="text-end">{{number_format(@$setpayamt,2)}}</td>
                                    <td scope="cal" class="text-end">{{number_format(@$setpayinteff,2)}}</td>
                                    <td scope="cal" class="text-end">{{number_format(@$setpayton,2)}}</td>
                                    <td></td>
                                    <td scope="cal" class="text-end">{{number_format(@$setINTLATEAMT,2)}}</td>
                                    <td scope="cal" class="text-end">{{number_format(@$setSum,2)}}</td>
                                </tr>
                            @else
                                <tr>
                                    <td>ไม่พบข้อมูล</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
			</div>
			<div class="tab-pane" id="table-2" role="tabpanel">
				<p class="mb-0">
					Food truck fixie locavore, accusamus mcsweeney's marfa nulla
					single-origin coffee squid. Exercitation +1 labore velit, blog
					sartorial PBR leggings next level wes anderson artisan four loko
					farm-to-table craft beer twee. Qui photo booth letterpress,
					commodo enim craft beer mlkshk aliquip jean shorts ullamco ad
					vinyl cillum PBR. Homo nostrud organic, assumenda labore
					aesthetic magna 8-bit.
				</p>
			</div>
		</div>

        <div class="row">
            <div class="col-6"></div>
            <div class="col-6">
                <div class="table-responsive mt-3">
                    <table class="table table-nowrap table-sm">
                        <tbody class="fw-semibold font-size-12">
                            <tr>
                                <td width="30px" class="border-0 text-end">ยอดรับชำระ</td>
                                <td class="border-0 text-end">{{number_format(@$showPayment,2)}} บาท</td>
                            </tr>
                            <tr>
                                <td class="border-0 text-end">เบี้ยปรับล่าช้า</td>
                                <td class="border-0 text-end">{{number_format(@$showinterest,2)}} บาท</td>
                            </tr>
                            <tr class="text-danger text-decoration-underline border-danger border-bottom">
                                <td class="border-0 text-end">ยอดรวมต้องชำระ</td>
                                <td class="border-0 text-end">{{number_format(@$showSum,2)}} บาท</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
	</div>
</div>
