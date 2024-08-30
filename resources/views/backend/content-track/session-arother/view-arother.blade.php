<style>
	/* width */
	::-webkit-scrollbar {
	height: 5px;
	}

	/* Track */
	::-webkit-scrollbar-track {
	box-shadow: inset 0 0 5px grey; 
	border-radius: 10px;
	}
	
	/* Handle */
	::-webkit-scrollbar-thumb {
	background: #959696; 
	border-radius: 10px;
	}

	/* Handle on hover */
	::-webkit-scrollbar-thumb:hover {
	background: #b30000; 
	}
</style>
<div class="row">
  <div class="col-lg-12">
	@if(@$contract != NULL)
		@if(count(@$contract->PactToAroth) > 0)
			@if($page == 'VIEW-AROTH')
				<div class="table-responsive font-size-11" data-simplebar="init" style="max-height: 415px; min-height : 415px;">
					<table class="table table-bordered table-sm table-head-fixed text-nowrap font-size-11" cellspacing="0" width="100%">
						<thead class="table-warning sticky-top">
							<tr class="text-center">
								<th class="sorting text-center"><i class="dripicons-gear"></i></th>
								<th class="sorting sorting_asc">เลขเอกสาร</th>
								<th class="sorting">วันที่ตั้งหนี้</th>
								<th class="sorting">รหัสชำระ</th>
								<th class="sorting">รายละเอียด</th>
								<th class="sorting bg-danger text-light">ยอดชำระ</th>
								<th class="sorting bg-danger text-light">ส่วนลด</th>
								<th class="sorting bg-danger text-light">คงเหลือ</th>
								<th class="sorting">วันนัดชำระ</th>
								@if($page == 'VIEW-AROTH')
								<th class="sorting">พนักงาน</th>
								@endif
							</tr>
						</thead>
						<tbody>
							@foreach(@$contract->PactToAroth as $key => $value)
								<tr @if(@$value->STATUS == 'Cancel') class="text-decoration-line-through text-danger" @endif>
									<td class="text-center">
										@if($value->FLAG == 'H' and $value->STATUS == 'Active')
											<a href="#" class="DeleteAroth" data-id="{{@$value->id}}" data-title="{{@$value->ARCONT}}" data-loan="{{@$loanType}}" data-cusid="{{@$contract->DataCus_id}}">
												<i class="mdi mdi-delete-circle-outline text-danger" data-bs-toggle="tooltip" title="ยกเลิกเลขเอกสาร"></i>
											</a>
										@endif
										<a class="modal_lg" data-bs-toggle="modal" data-bs-target="#modal_lg" data-link="{{ route('datatrack.edit', $value->id) }}?page={{'edit-aroth'}}&loantype={{$contract->CODLOAN}}" style="cursor:pointer;">
											<i class="mdi mdi-circle-edit-outline text-warning" data-bs-toggle="tooltip" title="แก้ไขรายการ"></i>
										</a>
									</td>
									<td scope="row" class="dtr-control sorting_1 text-start" tabindex="0">{{@$value->ARCONT}}</td>
									<td>{{date('d-m-Y',strtotime(@$value->INPDT))}}</td>
									<td>{{@$value->PAYFOR}}</td>
									<td>{{@$value->PAYCODE->FORDESC}}</td>
									<td class="text-end">{{number_format(@$value->PAYAMT,2)}}</td>
									<td class="text-end">{{number_format(@$value->DISCOUNT,2)}}</td>
									<td class="text-end">{{number_format(@$value->BALANCE,2)}}</td>
									<td>{{(@$value->DDATE != NULL)?date('d-m-Y',strtotime(@$value->DDATE)):'-'}}</td>
									@if(@$page == 'VIEW-AROTH')
									<td class="text-center"><span data-bs-toggle="tooltip" data-bs-placement="top" title="{{@$value->PAYUSERID->name}}">{{@$value->PAYUSERID->name}}</span></td>
									@endif
								</tr>
							@endforeach
						</tbody>
						<tfoot class="table-warning sticky-bottom">
							<tr>
								<th class="sorting text-start text-end" colspan="5">
									ทั้งหมด {{@$contract->PactToAroth()->count()}} รายการ
								</th>
								<th class="sorting text-end">{{ number_format(@$contract->PactToAroth()->sum('PAYAMT'), 2) }}</th>
								<th class="sorting text-end">{{ number_format(@$contract->PactToAroth()->sum('DISCOUNT'), 2) }}</th>
								<th class="sorting text-end">{{ number_format(@$contract->PactToAroth()->sum('BALANCE'), 2) }}</th>
								<th class="sorting" colspan="2"></th>
							</tr>
							<tr>
								<th class="sorting text-start text-end" colspan="5">
									ปกติ {{@$contract->PactToAroth()->where('STATUS','Active')->count()}} รายการ
								</th>
								<th class="sorting text-end">{{ number_format(@$contract->PactToAroth()->where('STATUS','Active')->sum('PAYAMT'), 2) }}</th>
								<th class="sorting text-end">{{ number_format(@$contract->PactToAroth()->where('STATUS','Active')->sum('DISCOUNT'), 2) }}</th>
								<th class="sorting text-end">{{ number_format(@$contract->PactToAroth()->where('STATUS','Active')->sum('BALANCE'), 2) }}</th>
								<th class="sorting" colspan="2"></th>
							</tr>
							<tr>
								<th class="sorting text-start text-end" colspan="5">
									ยกเลิก {{@$contract->PactToAroth()->where('STATUS','Cancel')->count()}} รายการ
								</th>
								<th class="sorting text-end">{{ number_format(@$contract->PactToAroth()->where('STATUS','Cancel')->sum('PAYAMT'), 2) }}</th>
								<th class="sorting text-end">{{ number_format(@$contract->PactToAroth()->where('STATUS','Cancel')->sum('DISCOUNT'), 2) }}</th>
								<th class="sorting text-end">{{ number_format(@$contract->PactToAroth()->where('STATUS','Cancel')->sum('BALANCE'), 2) }}</th>
								<th class="sorting" colspan="2"></th>
							</tr>
						</tfoot>
					</table>
				</div>
			@elseif($page == 'TRACK-AROTH') 
				<div class="table-responsive font-size-11" data-simplebar="init" style="max-height: 180px; min-height : 180px;">
					<table class="table table-striped table-bordered table-hover table-head-fixed text-nowrap font-size-10" cellspacing="0" width="100%">
						<thead class="table-warning sticky-top" style="line-height: 100%;">
							<tr class="text-center">
								<th class="sorting sorting_asc">เลขเอกสาร</th>
								<th class="sorting">วันที่ตั้งหนี้</th>
								<th class="sorting">รหัสชำระ</th>
								<th class="sorting">รายละเอียด</th>
								<th class="sorting bg-danger text-light">ยอดชำระ</th>
								<th class="sorting bg-danger text-light">ชำระแล้ว</th>
								<th class="sorting bg-danger text-light">คงเหลือ</th>
								<th class="sorting">วันนัดชำระ</th>
								@if($page == 'VIEW-AROTH')
								<th class="sorting">พนักงาน</th>
								@endif
								{{-- <th class="sorting text-center"><i class="dripicons-gear"></i></th> --}}
							</tr>
						</thead>
						<tbody class="font-size-11">
							@foreach(@$contract->PactToAroth as $key => $value)
								@if($value->PAYFOR == '602' or $value->PAYFOR == '800')
									@if($value->STATUS == 'Active')
										@php
										@$TotalPAYAMT += $value->PAYAMT; 
										@$TotalSMCHQ += $value->SMCHQ; 
										@$TotalBALANCE += $value->BALANCE;
										@$Total = count(@$contract->PactToAroth); 
										@endphp
									@endif
									<tr @if($value->STATUS == 'Cancel') class="text-decoration-line-through text-danger" @endif style="line-height: 250%;">
										<td scope="row" class="dtr-control sorting_1 text-start" tabindex="0">{{@$value->ARCONT}}</td>
										<td>{{date('d-m-Y',strtotime(@$value->INPDT))}}</td>
										<td>{{@$value->PAYFOR}}</td>
										<td>{{@$value->PAYCODE->FORDESC}}</td>
										<td class="text-end">{{number_format(@$value->PAYAMT,2)}}</td>
										<td class="text-end">{{number_format(@$value->SMCHQ,2)}}</td>
										<td class="text-end">{{number_format(@$value->BALANCE,2)}}</td>
										<td>{{(@$value->DDATE != NULL)?date('d-m-Y',strtotime(@$value->DDATE)):'-'}}</td>
										@if(@$page == 'VIEW-AROTH')
											<td class="text-center"><span class="font-size-12" data-bs-toggle="tooltip" data-bs-placement="top" title="{{@$value->PAYUSERID->name}}">{{@$value->PAYUSERID->name}}</span></td>
										@endif
									</tr>
								@endif
							@endforeach
						</tbody>
						<tfoot class="table-warning sticky-bottom">
							<tr>
								<th class="sorting text-start text-end" colspan="4">
									รวม {{@$contract->PactToAroth()->whereIn('PAYFOR',['602','800'])->where('STATUS','Active')->count()}} รายการ
								</th>
								<th class="sorting text-end">{{ number_format(@$contract->PactToAroth()->whereIn('PAYFOR',['602','800'])->where('STATUS','Active')->sum('PAYAMT'), 2) }}</th>
								<th class="sorting text-end">{{ number_format(@$contract->PactToAroth()->whereIn('PAYFOR',['602','800'])->where('STATUS','Active')->sum('DISCOUNT'), 2) }}</th>
								<th class="sorting text-end">{{ number_format(@$contract->PactToAroth()->whereIn('PAYFOR',['602','800'])->where('STATUS','Active')->sum('BALANCE'), 2) }}</th>
								<th class="sorting" colspan="3"></th>
							</tr>
						</tfoot>
					</table>
				</div>
			@endif
		@else 
			<div class="maintenance-img content-image mt-3">
				<img src="{{ URL::asset('assets/images/undraw/user_folder.svg') }}" alt="" class="img-fluid mx-auto d-block" style="max-height: 40vh;">
			</div>
		@endif
	@endif
  </div>
</div>

<script type="text/javascript">
  $(function() {
    $(".DeleteAroth").click( function() {
      removeAroth('{{@$contract->id}}' ,$(this).data('id'), $(this).data('title'), $(this).data('loan'),$(this).data('cusid'))
    });
  });
</script>

{{-- Delete Job Aro --}}
<script>
  function removeAroth(pact_id, id, title, loan, cusid){
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
        var page = 'del-aroth';
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
				$("#ArotherDetails").html(result);
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