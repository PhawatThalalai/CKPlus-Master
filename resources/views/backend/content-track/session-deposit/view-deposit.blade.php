<div class="row">
  <div class="col-lg-12">
    @if(count(@$contract->PactToHDpayment) > 0)
      <div class="table-responsive font-size-11" data-simplebar="init" style="max-height: 415px; min-height : 415px;">
        <table class="table table-bordered table-head-fixed text-nowrap font-size-10" cellspacing="0" width="100%">
          <thead class="table-primary sticky-top" style="line-height: 100%;">
            <tr class="text-center">
              <th class="sorting">เลขใบรับเงิน</th>
              <th class="sorting">วันที่รับเงิน</th>
              <th class="sorting">รหัสชำระ</th>
              <th class="sorting bg-primary text-light">ยอดชำระ</th>
              <th class="sorting bg-primary text-light">ส่วนลด</th>
              <th class="sorting bg-primary text-light">ยอดสุทธิ</th>
              <th class="sorting">พนักเก็บเงิน</th>
              <th class="sorting">สถานะ</th>
              <th class="sorting">หักหนี้แล้ว</th>
              <th class="sorting bg-primary text-light">ยอดคงเหลือ</th>
              {{--<th class="sorting text-center"><i class="dripicons-gear"></i></th>--}}
            </tr>
          </thead>
          <tbody class="font-size-11">
              @foreach(@$contract->PactToHDpayment as $key => $value)
                <tr @if($value->STATUS == 'Cancel') class="text-decoration-line-through text-danger" @endif style="line-height: 200%;">
                    <!-- <td scope="row" class="dtr-control sorting_1 text-center" tabindex="0">{{$key+1}}</td> -->
                    <td>{{$value->TEMPBILL}}</td>
                    <td>{{date('d-m-Y',strtotime($value->TEMPDATE))}}</td>
                    <td>{{$value->TYPCODE}}</td>
                    <td class="text-end">{{number_format(@$value->TOTAMT,2)}}</td>
                    <td class="text-end">{{number_format(@$value->BILLAMT,2)}}</td>
                    <td class="text-end">{{number_format(@$value->TOTAMT - @$value->BILLAMT,2)}}</td>
                    <td>{{$value->BILLCOLL}}</td>
                    <td>{{$value->STATUS}}</td>
                    <td class="text-end">0</td>
                    <td class="text-end"><span class="font-size-12" data-bs-toggle="tooltip" data-bs-placement="top" title="">0</span></td>
                    {{--
                    <td class="text-center">
                      @if($value->FLAG == 'Y' and $value->STATUS == 'Active')
                        <!-- <button type="button" class="btn btn-sm btn-rounded btn-danger waves-effect waves-light DeleteDeposit" data-id="{{@$value->id}}" data-title="{{@$value->TEMPBILL}}" data-loan="{{@$loanType}}" data-cusid="{{@$contract->DataCus_id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="ยกเลิกใบเสร็จ">
                          ยกเลิก
                        </button> -->
                        <a href="#" class="DeleteDeposit" data-id="{{@$value->id}}" data-title="{{@$value->TEMPBILL}}" data-loan="{{@$loanType}}" data-cusid="{{@$contract->DataCus_id}}" data-bs-toggle="tooltip" data-bs-placement="top" title="ยกเลิกเลขใบรับเงิน">
                          <i class="mdi mdi-delete-circle-outline mdi-24px text-danger"></i>
                        </a>
                      @elseif($value->STATUS == 'Cancel')
                        <i class="mdi mdi-file-cancel-outline mdi-24px text-muted" data-bs-toggle="tooltip" data-bs-placement="top" title="วันยกเลิก : {{@$value->updated_at}}"></i>
                      @endif
                    </td>
                    --}}
                </tr>
              @endforeach
          </tbody>
          <tfoot class="table-primary sticky-bottom">
            <tr>
              <th class="sorting sorting_asc text-end" colspan="3">
                  ทั้งหมด {{@$contract->PactToHDpayment()->count()}} รายการ
              </th>
              <th class="sorting text-end">{{ number_format(@$contract->PactToHDpayment()->sum('TOTAMT'), 2) }}</th>
              <th class="sorting text-end">{{ number_format(@$contract->PactToHDpayment()->sum('BILLAMT'), 2) }}</th>
              <th class="sorting text-end">{{ number_format(@$contract->PactToHDpayment()->sum('TOTAMT') - @$contract->PactToHDpayment()->sum('BILLAMT'), 2) }}</th>
              <th class="sorting" colspan="2"></th>
              <th class="sorting text-end">0</th>
              <th class="sorting text-end">0</th>
              {{--<th class="sorting"></th>--}}
            </tr>
            <tr>
              <th class="sorting sorting_asc text-end" colspan="3">
                  ปกติ {{@$contract->PactToHDpayment()->where('STATUS','Active')->count()}} รายการ
              </th>
              <th class="sorting text-end">{{ number_format(@$contract->PactToHDpayment()->where('STATUS','Active')->sum('TOTAMT'), 2) }}</th>
              <th class="sorting text-end">{{ number_format(@$contract->PactToHDpayment()->where('STATUS','Active')->sum('BILLAMT'), 2) }}</th>
              <th class="sorting text-end">{{ number_format(@$contract->PactToHDpayment()->where('STATUS','Active')->sum('TOTAMT') - @$contract->PactToHDpayment()->where('STATUS','Cancle')->sum('BILLAMT'), 2) }}</th>
              <th class="sorting" colspan="2"></th>
              <th class="sorting text-end">0</th>
              <th class="sorting text-end">0</th>
              {{--<th class="sorting"></th>--}}
            </tr>
            <tr>
              <th class="sorting sorting_asc text-end" colspan="3">
                  ยกเลิก {{@$contract->PactToHDpayment()->where('STATUS','Cancel')->count()}} รายการ
              </th>
              <th class="sorting text-end">{{ number_format(@$contract->PactToHDpayment()->where('STATUS','Cancel')->sum('TOTAMT'), 2) }}</th>
              <th class="sorting text-end">{{ number_format(@$contract->PactToHDpayment()->where('STATUS','Cancel')->sum('BILLAMT'), 2) }}</th>
              <th class="sorting text-end">{{ number_format(@$contract->PactToHDpayment()->where('STATUS','Cancel')->sum('TOTAMT') - @$contract->PactToHDpayment()->where('STATUS','Cancle')->sum('BILLAMT'), 2) }}</th>
              <th class="sorting" colspan="2"></th>
              <th class="sorting text-end">0</th>
              <th class="sorting text-end">0</th>
              {{--<th class="sorting"></th>--}}
            </tr>
          </tfoot>
        </table>
      </div>
    @else
      <div class="maintenance-img content-image mt-3">
        <!-- <h5 class="text-danger text-center">--- ไม่มีรายการรับฝากค่างวด ---</h5> -->
        <img src="{{ URL::asset('assets/images/undraw/user_folder.svg') }}" alt="" class="img-fluid mx-auto d-block" style="max-height: 40vh;">
      </div>
    @endif
  </div>
</div>

<script type="text/javascript">
  $(function() {
    $(".DeleteDeposit").click( function() {
      removeDeposit('{{@$contract->id}}' ,$(this).data('id'), $(this).data('title'), $(this).data('loan'),$(this).data('cusid'))
    });
  });
</script>

{{-- Delete Job Aro --}}
<script>
  function removeDeposit(pact_id, id, title, loan, cusid){
    //------------------------------------------------------
    Swal.fire({
      title: 'คุณแน่ใจหรือไม่?',
      text: "ยกเลิกใบเสร็จ " + title,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
    })
    .then( (value) => {
      if (value.isConfirmed) { // กด OK 
        var page = 'del-deposit';
        var _url = "{{ route('datatrack.destroy', ':id' ) }}";
        _url = _url.replace(':id', id);
        $.ajax({
          url: _url,
          method:"DELETE",
          data:{page:page,_token:'{{ csrf_token() }}',pact_id:pact_id,loan:loan,cusid:cusid},
            success:function(result){ //เสร็จแล้วทำอะไรต่อ
              Swal.fire({
                icon: 'success',
                // title: 'ยกเลิกสำเร็จ!',
                text: "ยกเลิกใบเสร็จเรียบร้อย",
                timer: 3000
              });
              $("#DepositDetails").html(result);
            },
            error: function(err) {
                Swal.fire({
                    icon: 'error',
                    title: `ERROR ` + err.status + ` !!!`,
                    text: err.responseJSON.message,
                    showConfirmButton: true,
                });
            }
        });
      }
      else{
        // Swal.fire('Changes are not saved', '', 'info');
      }
    });
  }
</script>
