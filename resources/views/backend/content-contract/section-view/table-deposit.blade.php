<section>
    <div class="table-responsive font-size-11" data-simplebar="init" style="max-height: 355px;">
    <table id="" class="table table-striped table-bordered text-nowrap font-size-11 table-depositspayments" cellspacing="0" width="100%">
      <thead class="table-warning" style="line-height: 130%;">
        <tr>
          <th>สาขา</th>
          <th>เลขใบรับเงิน</th>
          <th>วันที่รับเงิน</th>
          <th>รหัสรับชำระ</th>
          <th>รายละเอียดชำระ</th>
          <th>ยอดชำระ</th>
          <th>ส่วนลด</th>
          <th>ยอดสุทธิ</th>
          <th>พนักงานเก็บเงิน</th>
          <th>สถานะ</th>
          <th>หักหนี้แล้ว</th>
          <th>ยอดคงเหลือ</th>
        </tr>
      </thead>
      <tbody>
        @isset($contract)
          @foreach(@$contract->PactToHDpayment as $value)
        <tr>
        <td>{{ @$value->LOCAT }}</td>
        <td>{{ @$value->ARCONT }}</td>
        <td>{{ @$value->ARDATE }}</td>
        <td>{{ @$value->PAYFOR }}</td>
        <td>dd</td>
        <td>{{ @$value->PAYAMT }}</td>
        <td>dd</td>
        <td>dd</td>
        <td>{{ @$value->PAYUSERID->name }}</td>
        <td>{{ @$value->STATUS }}</td>
        <td>dd</td>
        <td>dd</td>

        </tr>
          @endforeach
         @endisset
      </tbody>
    </table>
  </div>
</section>


