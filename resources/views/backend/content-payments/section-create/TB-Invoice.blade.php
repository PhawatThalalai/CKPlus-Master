   <div class="row">
        {{-- ตารางลูกหนี้อื่่น  --}}
       {{-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
           @isset($PayOther)
               @if (count(@$PayOther) > 0)
                   <p class="text-muted mb-2 mt-2 fw-semibold d-flex justify-content-between">
                       <span><i class="mdi mdi-wallet me-1"></i>รายการลูกหนี้อื่น</span>
                       <span class="badge rounded-pill text-bg-danger d-flex align-self-center">{{ count(@$PayOther) }}
                           รายการ</span>
                   </p>
                   <div class="table-responsive scroll" style="max-height: 200px;">
                       <table id="PayOther"
                           class="table align-middle table-nowrap text-nowrap table-hover table-check font-size-12 table-sm text-center">
                           <thead class="table-info sticky-top">
                               <tr class="">
                                   <th class="d-none">#</th>
                                   <th>งวด</th>
                                   <th>รหัสชำระ</th>
                                   <th>รายการ</th>
                                   <th>ยอดลูกหนี้</th>
                                   <th>ส่วนลด</th>
                                   <th >
                                        #
                                   </th>
                               </tr>
                           </thead>
                           <tbody id="body-payotherINV" class="tbody-pay">
                            @php
                                $arrPay = [];
                            @endphp
                               @foreach ($PayOther as $key => $item)
                                   <tr>
                                       <td class="bg-danger bg-soft idOth d-none">{{ @$item->id }}</td>
                                       <td class="bg-danger bg-soft">{{ @$item->NOPAY }}</td>
                                       <td class="payfor">{{ @$item->FORCODE }} </td>
                                       <td>{{ @$item->FORDESC }} </td>
                                       <th class="bg-danger bg-soft payamt" >{{ number_format($item->PAYAMT, 0) }}</th>
                                       <th class="bg-danger bg-soft dicint">{{ number_format($item->DISCOUNT, 0) }}</th>
                                       <td><input class="form-check-input mt-0" total="{{ $item->PAYAMT - $item->DISCOUNT }}" type="checkbox" value="{{ $item->id }}" aria-label="Checkbox for following text input checkOther" checked> </td>
                                   </tr>
                               @endforeach
                           </tbody>
                           <tfoot class="table-info sticky-bottom">
                               <tr class="">
                                   <th style="width: 20px;">
                                       รวม
                                   </th>
                                   <th></th>
                                   <th></th>
                                   <th class="text-decoration-underline" >{{ number_format($PayOther->sum('PAYAMT'), 2) }}
                                   </th>
                                   <th class="text-decoration-underline">{{ number_format($PayOther->sum('DISCOUNT'), 2) }}
                                   <th class="text-decoration-underline" id="totalPayAr">0.00</th>

                               </tr>
                           </tfoot>
                       </table>
                   </div>

               @endif
           @endisset
       </div> --}}
       {{-- ตารางชำระค่างวด --}}
       {{-- <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
            @php
                $setdueamt = 0;
                $followamt = 0;
                $payfollow = 0;
                $setSum = 0;
                $sumDiff = 0;
            @endphp
           @isset($dataPayduePayment)
               @if (count(@$dataPayduePayment) > 0)
                   <p class="text-muted mb-2 mt-2 fw-semibold d-flex justify-content-between">
                       <span><i class="mdi mdi-wallet me-1"></i>ตารางชำระค่างวด</span>
                       <span class="badge rounded-pill text-bg-danger d-flex align-self-center">{{ count(@$dataPayduePayment) }}
                           รายการ</span>
                   </p>
                   <div class="table-responsive scroll" style="max-height: 200px;">
                       <table
                           class="table align-middle table-nowrap text-nowrap table-hover table-check font-size-12 table-sm text-center">
                           <thead class="table-info sticky-top">
                               <tr class="">
                                   <th>งวดที่</th>
                                   <th>วันที่</th>
                                   <th>ค่างวด</th>
                                   <th>เบี้ยปรับ</th>
                                   <th>ค่าทวงถาม</th>
                                   <th>รวมต้องชำระ</th>

                               </tr>
                           </thead>
                           <tbody class="tbody-pay">
                               @foreach ($dataPayduePayment as $key => $row)
                               @php
                                $setdueamt += @$row['dueamt'] - @$row['payamt'];
                                $followamt += @$row['followamt'];
                                $setSum += @$dueamt + @$row['intamt'] + (@$row['followamt'] - @$row['payfollow']) - @$payamt;
                                $payfollow += @$row['payfollow'];
                                $sumDiff += @$row['Sumdiff'];
                            @endphp
                                   <tr>
                                    <td scope="row" class="bg-danger bg-soft text-center">{{ @$row['nopay'] }}</td>
                                    <td scope="row" class="text-center">{{ date('d-m-Y', strtotime(@$row['duedate'])) }}</td>
                                    <td scope="row" class="bg-danger bg-soft">{{ number_format(@$row['dueamt'] - @$row['payamt'],2) }}</td>
                                    <td scope="row" class="text-danger">{{ @$row['intamt'] }}</td>
                                    <td scope="row" class="text-danger">{{ @$row['followamt'] - @$row['payfollow'] }}</td>
                                    <td scope="row" class="text-danger">{{ @$row['Sumdiff'] }}</td>

                                   </tr>
                               @endforeach
                           </tbody>
                           <tfoot class="table-info sticky-bottom">
                            <tr class="">
                                <th>รวม</th>
                                <th></th>
                                <th class="text-center">{{ number_format(@$setdueamt,2) }}</th>
                                <th class="text-center">{{ number_format(@$setSum,2) }}</th>
                                <th class="text-center">{{ number_format(@$payfollow,2) }}</th>
                                <th class="text-center">{{ number_format(@$sumDiff,2) }}</th>
                            </tr>
                        </tfoot>
                       </table>
                   </div>
               @endif
           @endisset

           @empty($dataPayduePayment)
               <blockquote class="blockquote font-size-16 mb-0">
                   <p class="font-size-14">ไม่พบข้อมูล.</p>
                   <footer class="blockquote-footer"><cite title="Source Title">โปรดตรวจสอบ
                           รายการค่างวดของลูกค้า</cite>
                   </footer>
               </blockquote>
           @endempty
       </div> --}}


       <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
        @php
            $setdueamt = 0;
            $followamt = 0;
            $payfollow = 0;
            $setSum = 0;
            $sumDiff = 0;
        @endphp
       @isset($dataPayduePayment)
           @if (count(@$dataPayduePayment) > 0)
               <p class="text-muted mb-2 mt-2 fw-semibold d-flex justify-content-between">
                   <span><i class="mdi mdi-wallet me-1"></i>ตารางชำระค่างวด</span>
                   <span class="badge rounded-pill text-bg-danger d-flex align-self-center">{{ count(@$dataPayduePayment) }}
                       รายการ</span>
               </p>
               <div class="table-responsive scroll" style="max-height: 200px;">
                   <table
                       class="table align-middle table-nowrap text-nowrap table-hover table-check font-size-12 table-sm text-center">
                       <thead class="table-info sticky-top">
                           <tr class="">
                               <th>งวดที่</th>
                               <th>วันที่</th>
                               <th>ค่างวด</th>
                               <th>เบี้ยปรับ</th>
                               <th>ค่าทวงถาม</th>
                               <th>รวมต้องชำระ</th>

                           </tr>
                       </thead>
                       <tbody class="tbody-pay">
                           @foreach ($dataPayduePayment as $key => $row)
                           @php
                            $setdueamt += @$row['dueamt'] - @$row['payamt'];
                            $followamt += @$row['followamt'];
                            $setSum += @$dueamt + @$row['intamt'] + (@$row['followamt'] - @$row['payfollow']) - @$payamt;
                            $payfollow += @$row['payfollow'];
                            $sumDiff += @$row['Sumdiff'];


                        @endphp
                               <tr>
                                <td scope="row" class="bg-danger bg-soft text-center">{{ @$row['nopay'] }}</td>
                                <td scope="row" class="text-center">{{ date('d-m-Y', strtotime(@$row['duedate'])) }}</td>
                                <td scope="row" class="bg-danger bg-soft">{{ number_format(@$row['dueamt'],2) }}</td>
                                <td scope="row" class="text-danger">{{ @$row['intamt'] }}</td>
                                <td scope="row" class="text-danger">{{ @$row['followamt'] - @$row['payfollow'] }}</td>
                                <td scope="row" class="text-danger">{{ number_format(@$row['dueamt'] - @$row['payamt'],2) }}</td>

                               </tr>
                           @endforeach
                       </tbody>
                       <tfoot class="table-info sticky-bottom">
                        <tr class="">
                            <th>รวม</th>
                            <th></th>
                            <th class="text-center">{{ number_format(@$setdueamt,2) }}</th>
                            <th class="text-center">{{ number_format(@$setSum,2) }}</th>
                            <th class="text-center">{{ number_format(@$payfollow,2) }}</th>
                            <th class="text-center">{{ number_format(@$sumDiff,2) }}</th>
                        </tr>
                    </tfoot>
                   </table>
               </div>
           @endif
       @endisset

       @empty($dataPayduePayment)
           <blockquote class="blockquote font-size-16 mb-0">
               <p class="font-size-14">ไม่พบข้อมูล.</p>
               <footer class="blockquote-footer"><cite title="Source Title">โปรดตรวจสอบ
                       รายการค่างวดของลูกค้า</cite>
               </footer>
           </blockquote>
       @endempty
   </div>
   </div>


   <script>

        $('.checkAll').on( "click", ()=>{

            $( "#PayOther input[type=checkbox]" ).not('.checkAll').prop('checked',true)
            // checkBox()
        })

        $( "#PayOther input[type=checkbox]" ).not('.checkAll').on( "click", ()=>{
            checkBox()
        } );


        checkBox = () =>{
            let INPUTPAYPLUS = $('#INPUTPAYPLUS').val()
            let INPUTPAY = parseFloat($('#INPUTPAY').val())
            let DEBTOTH = parseFloat($('#DEBTOTH').val())
            let arr = []
            var checkedelemids = $( "#PayOther input:checked" ).map(function(){
                arr = [{
                    id : this.value ,
                    debt: $(this).attr('total')
                }]
                return arr;
            }).get()

            var ids = checkedelemids.map(function(item) {
                return item.id;
            }).join();

            var totalDebt = checkedelemids.reduce(function(sum, item) {
                return sum + parseFloat(item.debt);
            }, 0);

            $('#AROTHR').val(ids)
            $('#totalPayAr').html(totalDebt.toLocaleString())
            $('#INPUTPAYPLUS').val(INPUTPAY + (DEBTOTH - totalDebt))
            console.log(ids , totalDebt);
        }

        </script>

