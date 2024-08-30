  <section>
    <div class="table-responsive font-size-11">
      <table id="table-installment-schedule" class="table table-striped table-bordered text-nowrap table-hover table-sm font-size-13 table-installment-schedule" cellspacing="0" width="100%">
        @if (@$contract->PatchToPact->ContractToTypeLoan->Loan_Com == 1) <!-- เงินกู้ -->
          <thead>
            <tr>
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
                @foreach(@$contract->ContractDUEPAYMENT as $key => $value)
                  <tr>
                    <td class="text-center">{{$value->NOPAY}}</td>
                    <td class="text-center">{{ date('d-m-Y', strtotime(@$value->DUEDATE)) }}</td>
                    <td class="text-center">{{number_format($value->DUEAMT,2)}}</td>
                    <td class="text-center">{{number_format($value->DUEINEFF,2)}}</td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                  </tr>
                @endforeach
              @elseif($contract->CONTTYP==2||$contract->CONTTYP==3)
                  @foreach(@$contract->ContractDUEPAYLOAN as $key => $value)
                  <tr>
                    <td class="text-center">{{$value->nopay}}</td>
                    <td class="text-center">{{ date('d-m-Y', strtotime(@$value->ddate)) }}</td>
                    <td class="text-center">{{number_format($value->damt,2)}}</td>
                    <td class="text-center">{{number_format($value->interest,2)}}</td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                  </tr>
                @endforeach
              @endif
            @endisset
          </tbody>
        @else <!-- เช่าซื้อ -->
          <thead>
            <tr>
              <th>งวดที่</th>
              <th>กำหนดชำระ</th>
              <th>ค่างวด</th>
              <th>วันที่ชำระ</th>
              <th>ยอดชำระ</th>
              <th>เลขที่ใบกำกับ</th>
              <th>วันที่ใบกำกับ</th>
            </tr>
          </thead>
          <tbody>
            @isset($contract)
              @foreach(@$contract->ContractPaydue as $key => $value)
                <tr>
                  <td class="text-center">{{$value->nopay}}</td>
                  <td class="text-center">{{ date('d-m-Y', strtotime(@$value->ddate)) }}</td>
                  <td class="text-center">{{number_format($value->damt,2)}}</td>
                  <td class="text-center">{{ date('d-m-Y', strtotime(@$value->date1)) }}</td>
                  <td class="text-center">{{number_format($value->payment,2)}}</td>
                  <td class="text-center">{{$value->taxno}}</td>
                  <td class="text-center">{{$value->taxdate}}</td>
                </tr>
              @endforeach
            @endisset
          </tbody>
        @endif
      </table>
    </div>
  </section>

@pushOnce('scripts')
<script>
  $(document).ready(function () {
    //$('#table-installments').DataTable();
    $('#table-installment-schedule').DataTable();
  });
</script>
@endPushOnce