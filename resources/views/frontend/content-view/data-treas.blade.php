@if( count(@$data) != 0)
    <div class="p-2 h-100" id="appendTB" style="overflow: hidden;">
        <div class="table-responsive" id="viewTable">
            <table id="data-treas" class="table table-bordered view-treas align-middle table-striped">
                <thead class="">
                    <tr class="">
                        <th class="text-center" style="width: 5%"></th>
                        <th class="text-center">เลขสัญญา</th>
                        <th class="text-center">สาขา</th>
                        <th class="text-center">ชื่อลูกค้า</th>
                        <th class="text-center">ยอดจัด</th>
                        <th class="text-center">ผู้อนุมัติ</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (@$data as $row)
                        <tr id="row_{{ @$row->id }}">
                            <td class="">
                                <div class="d-flex justify-content-center">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar-xs">
                                            @if (!empty(@$row->image_cus))
                                                <img class="avatar-title rounded-circle" src="{{ URL::asset(@$row->image_cus) }}" alt="">
                                            @else
                                                <div class="avatar-title bg-primary text-primary bg-soft rounded-circle">
                                                    {{ @$row->CodeLoan_Con }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h5 class="font-size-13 mb-1"><a role="button" class="text-dark">สัญญา : <a href="{{ route('contract.edit', $row->id) }}?funs={{'contract'}}" target="_blank" data-bs-toggle="tooltip" title="รายละเอียดสัญญา">{{ @$row->Contract_Con }}</a></h5>
                                <span class="mb-0 badge badge-pill font-size-12 badge-soft-success">สถานะ : {{ @$row->StatusApp_Con }}</span>
                            </td>
                            <td> {{ @$row->Name_Branch }} </td>
                            <td class="">
                                <h5 class="font-size-13 mb-1"><a role="button" class="text-dark">ชื่อ-สกุล : {{ @$row->Name_Cus }}</a></h5>
                                <span class="mb-0 badge badge-pill font-size-12 badge-soft-warning">ประเภท : {{ @$row->type_customer }}</span>
                            </td>
                            <td>
                                <button type="button" class="btn btn-outline-warning btn-sm btn-rounded waves-effect waves-light">
                                    {{ number_format(@$row->Balance_Price,2) }}
                                </button>
                            </td>
                            <td class="">
                                <h5 class="font-size-13 mb-1"><a role="button" class="text-dark">ผู้อนุมัติ : {{ @$row->nameConfirm }}</a></h5>
                                <button type="button" class="btn btn-light btn-sm btn-rounded waves-effect waves-light">
									<i class="bx bx-calendar-event text-success"></i>
								</button>
								<span class="">{{ date('d-m-Y', strtotime($row->DateConfirmApp_Con)) }}</span>
                                {{-- <span class="mb-0 badge badge-pill font-size-12 badge-soft-warning"> <i class="bx bx-calendar-event"></i> {{ date('d-m-Y', strtotime($row->DateConfirmApp_Con)) }}</span> --}}
                            </td>
                            <td class="text-center">
                                <a type="button" class="btn btn-primary data-modal-xl-2 btn btn-sm" data-bs-toggle="" data-link="{{ route('treas.create') }}?page={{'transfer'}}&id={{ @$row->id }}">ทำรายการ <i class="bx bx-transfer"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@else
    <div class="maintenance-img content-image p-3" id="content-image">
        <img src="{{ asset('assets/images/undraw/undraw_transfer_money.svg') }}" alt="" class="img-fluid mx-auto d-block" style="max-height: 400px;">
    </div>
@endif

<script>
    $(function(){
        $(".view-treas").DataTable({
                "responsive": false,
                "autoWidth": false,
                "ordering": true,
                "lengthChange": true,
                "order": [
                    [0, "asc"]
                ],
                "pageLength": 10,
            });
    });
</script>
