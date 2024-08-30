  <section>
    <div class="table-responsive font-size-11" data-simplebar="init" style="max-height: 355px;">
      <table id="" class="table table-striped table-bordered text-nowrap table-hover font-size-11 text-center table-installments" cellspacing="0" width="100%">
        @if (@$contract->PatchToPact->ContractToTypeLoan->Loan_Com == 1) <!--  เงินกู้ -->
          <thead class="sticky-top table-warning" style="line-height: 130%;">
            <tr class="">
              <th>งวดที่</th>
              <th>กำหนดชำระ</th>
              <th>ค่างวด</th>
              <th>ดอกเบี้ย</th>
              <th>เงินต้น</th>
              <th>เงินต้นคงเหลือ</th>
            </tr>
          </thead>
          <tbody>
            @isset($contract)
              @if($contract->CONTTYP==1)
              @foreach(@$contract->ContractPaydue2 as $key => $value)
                <tr class="">
                  <td class="">{{$value->nopay}}</td>
                  <td class="">{{ date('d-m-Y', strtotime(@$value->ddate)) }}</td>
                  <td class="">{{number_format($value->damt,2)}}</td>
                  <td class="">{{number_format($value->interest,2)}}</td>
                  <td class="">{{number_format($value->capital,2)}}</td>
                  <td class="">{{number_format($value->capitalbl,2)}}</td>
                </tr>

              @endforeach
              </tbody>
              <tfoot class="table-warning sticky-bottom text-center" style="line-height: 130%;">
                <tr>
                  <th>ผ่อน {{ @$contract->ContractPaydue2->count('nopay') }}</th>
                  <th></th>
                  <th>{{ number_format(@$contract->ContractPaydue2->sum('damt'),2) }}</th>
                  <th>{{ number_format(@$contract->ContractPaydue2->sum('interest'),2) }}</th>
                  <th>{{ number_format(@$contract->ContractPaydue2->sum('capital'),2) }}</th>
                  <th></th>
                </tr>
              </tfoot>
              @elseif($contract->CONTTYP==2||$contract->CONTTYP==3)
                @foreach(@$contract->ContractPaydueLoan as $key => $value)
                  <tr class="">
                    <td class="">{{$value->nopay}}</td>
                    <td class="">{{ date('d-m-Y', strtotime(@$value->ddate)) }}</td>
                    <td class="">{{number_format($value->damt,2)}}</td>
                    <td class="">{{number_format($value->interest,2)}}</td>
                    <td class="">{{number_format($value->capital,2)}}</td>
                    <td class="">{{number_format($value->capitalbl,2)}}</td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot class="table-warning sticky-bottom text-center" style="line-height: 130%;">
                <tr>
                  <th>ผ่อน {{ @$contract->ContractPaydueLoan->count('nopay') }}</th>
                  <th></th>
                  <th>{{ number_format(@$contract->ContractPaydueLoan->sum('damt'),2) }}</th>
                  <th>{{ number_format(@$contract->ContractPaydueLoan->sum('interest'),2) }}</th>
                  <th>{{ number_format(@$contract->ContractPaydueLoan->sum('capital'),2) }}</th>
                  <th></th>
                </tr>
              </tfoot>
              @endif
            @endisset

        @else   <!--  เช่าซื้อ -->
          <thead class="sticky-top table-warning" style="line-height: 130%;">
            <tr class="bg-primary bg-soft">
              <th>งวดที่</th>
              <th>กำหนดชำระ</th>
              <th>ค่างวด</th>
              <th>เงินต้น</th>
              <th>ดอกเบี้ย</th>
              <th>ภาษีมูลค่าเพิ่ม</th>
              <th>เงินต้นคงค้าง</th>
              <th>ดอกเบี้ยเช่าซื้อ</th>
            </tr>
          </thead>
          <tbody>
            @isset($contract)
              @php
                $INTHP = @$contract->ContractPaydue->sum('interest');
              @endphp
            @foreach(@$contract->ContractPaydue as $key => $value)

                <tr>
                  <td class="text-center">{{$value->nopay}}</td>
                  <td class="text-center">{{ date('d-m-Y', strtotime(@$value->ddate)) }}</td>
                  <td class="text-center">{{number_format($value->damt,2)}}</td>
                  <td class="text-center">{{ number_format( $value->capital ,2) }}</td>
                  <td class="text-center">{{ number_format( $value->interest ,2) }}</td>
                  <td class="text-center">{{ number_format( $value->damt_v ,2) }}</td>
                  <td class="text-center">{{ number_format( $value->capitalbl ,2) }}</td>
                  <td class="text-center">{{ number_format( (@$INTHP - $value->interest) ,2) }}</td>
                </tr>

                @php
                 $INTHP = @$INTHP - $value->interest;
                @endphp

              @endforeach
            @endisset
          </tbody>
          <tfoot class="table-warning sticky-bottom text-center" style="line-height: 130%;">
						<tr>
              <th>ผ่อน {{ @$contract->ContractPaydue->count('nopay') }}</th>
              <th></th>
              <th>{{ number_format ( @$contract->ContractPaydue->sum('damt') ,2)}}</th>
              <th>{{ number_format ( @$contract->ContractPaydue->sum('capital') ,2)}}</th>
              <th>{{ number_format ( @$contract->ContractPaydue->sum('interest') ,2)}}</th>
              <th>{{ number_format ( @$contract->ContractPaydue->sum('damt_v') ,2)}}</th>
              <th></th>
              <th></th>
						</tr>
					</tfoot>
        @endif
      </table>
    </div>
  </section>

@pushOnce('scripts')
<script>
  $(document).ready(function () {
    //$('#table-installments').DataTable();
    // $('.table-installments').DataTable();
  });
</script>
@endPushOnce
