<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
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
                                     {{-- <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input  checkAll "> --}}
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
                                    <td><input class="form-check-input mt-0" total="{{ $item->PAYAMT - $item->DISCOUNT }}" type="checkbox" value="{{ $item->id }}" aria-label="Checkbox for following text input checkOther"> </td>
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
    </div>
</div>