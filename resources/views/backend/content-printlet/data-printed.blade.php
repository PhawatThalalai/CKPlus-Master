<style>
	/* width */
	::-webkit-scrollbar {
	width: 10px;
	}

	/* Track */
	::-webkit-scrollbar-track {
	/* box-shadow: inset 0 0 5px grey;  */
	border-radius: 10px;
	}
	
	/* Handle */
	::-webkit-scrollbar-thumb {
	/* background: red;  */
	border-radius: 10px;
	}
	/* Add background color on hover for the table row */
	tr:hover {
		background-color: #f5f5f5;
	}
</style>

@if(@$countData > 0)
	<div class="card p-2 mt-n1 border-top">
		<input type="hidden" id="GCODE" value="{{@$gcode}}">
		<input type="hidden" id="START" value="{{@$start}}">
		<input type="hidden" id="END" value="{{@$end}}">
		<div class="row p-1 mt-n2">
			<div class="col-xxl-12">
				<div class="font-size-11 border" data-simplebar="init" style="max-height: 380px; min-height : 380px;">
					<table class="table table-bordered table-head-fixed text-nowrap font-size-10" cellspacing="0" width="100%" id="dataTable">
						<thead class="table-info sticky-top">
							<tr class="text-left">
								<th>NO.</th>
								<th>สาขา</th>
								<th>วันออกจดหมาย</th>
								<th>เลขเอกสาร</th>
								<th>เลขที่สัญญา</th>
								<th>ชื่อ-สกุล</th>
								<th>กลุ่มค้าง</th>
								<th>ผู้บันทึก</th>
								<th class="text-center">
									<a href="#" id="btn_printAll" class="text-dark">
										<i class="bx bxs-printer bx-xs bx-tada" data-bs-toggle="tooltip" title="ปริ้นทั้งหมด"></i>
									</a>
								</th>
							</tr>
						</thead>
						<tbody>
							@foreach($data as $key => $row)
								<tr class="text-left" style="cursor:pointer;">
									<td>
										<div class="avatar-xs">
											<span class="avatar-title rounded-circle bg-warning bg-gradient">
												{{$key+1}}
											</span>
										</div>
									</td>
									<td>{{@$row->LOCAT}}</td>
									<td>{{date('d/m/Y',strtotime(@$row->PRINTDT))}}</td>
									<td>{{@$row->LETDOC}}</td>
									<td>{{@$row->CONTNO}}</td>
									<td>{{@$row->ToPact->ContractToCus->Name_Cus}}</td>
									<td>{{@$row->GCODE}}</td>
									<td>{{@$row->ToUser->name}}</td>
									<td class="text-center">
										@php 
											@$Guarantor1 = @$row->ToPact->ContractToGuarantor[0]->GuarantorToGuarantorCus;
										@endphp
										@if(@$Guarantor1 != NULL)
											<button type="button" class="btn btn-sm hover-up text-info btn_printOne" data-id="{{@$row->id}}" data-bs-toggle="tooltip" title="พิมพ์หนังสือ">
												<i class="bx bxs-printer bx-xs"></i>
											</button>
										@endif
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<p class="text-end">
					<span>จำนวนรายการ : </span><span id="dataTableCount" class="me-2">{{count(@$data)}}</span>
				</p>
			</div>
		</div>
	</div>
@else 
	<div class="tab-content" id="v-tabContent" style="max-height: 100vh;">
		<div class="card card-body h-100">
			<div class="row">
				<div class="col-12">
					<img src="{{ URL::asset('assets/images/undraw/undraw_notify.svg') }}" alt="" class="img-fluid mx-auto d-block mt-5 mb-4" style="width:300px;">
					<h4 class="text-danger d-flex justify-content-center">ไม่พบข้อมูล !</h4>
					<p class="text-muted font-size-14 mb-4 d-flex justify-content-center">กรุณาระบุข้อมูล Reprint ใหม่.</p>
				</div>
			</div>
		</div>                       
	</div>
@endif

<!-- @php
	echo "<pre>";
	echo print_r($data);
	echo "</pre>";
@endphp -->

<script>
	$(document).ready(function() {
		$(function() {
			$(".input-mask").inputmask();
			$('[data-bs-toggle="tooltip"]').tooltip();
		});
	});
</script>

<script>
	$("#btn_printAll").click(function(){
		let getForm = $('#form-selcted').val();
		let getCode = $("#GCODE").val();
		let getStart = $("#START").val();
		let getEnd = $("#END").val();
		let url = "{{route('letter.show', 0)}}?page={{'reprint-form'}}&form={{':getForm'}}&gcode={{':gcode'}}&start={{':start'}}&end={{':end'}}";
			url = url.replace(':getForm', getForm);
			url = url.replace(':gcode', getCode);
			url = url.replace(':start', getStart);
			url = url.replace(':end', getEnd);
		window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes");
	});
	$(".btn_printOne").click(function(){
		let id = $(this).data('id');
		let getForm = $('#form-selcted').val();
		let getCode = $("#GCODE").val();
		let getStart = $("#START").val();
		let getEnd = $("#END").val();
		let url = "{{route('letter.show', ':id')}}?page={{'reprint-oneform'}}&form={{':getForm'}}&gcode={{':gcode'}}&start={{':start'}}&end={{':end'}}";
			url = url.replace(':id', id);
			url = url.replace(':getForm', getForm);
			url = url.replace(':gcode', getCode);
			url = url.replace(':start', getStart);
			url = url.replace(':end', getEnd);
		window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes");
		  
	});
</script>