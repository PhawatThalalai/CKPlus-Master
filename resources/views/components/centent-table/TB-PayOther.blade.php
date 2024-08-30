@php
    if(@$flagCom == 'getToCal'){
        $collection = @$PayOther;
        $page = 'payments';
    }else{
        $collection = @$data['PayOther'];
        $page = @$data['page'];

    }
@endphp

@isset($collection)
@if(count(@$collection) > 0)
<p class="text-muted mb-2 mt-2 fw-semibold d-flex justify-content-between">
    <span><i class="mdi mdi-wallet me-1"></i>รายการลูกหนี้อื่น</span>
    <span class="badge rounded-pill text-bg-danger d-flex align-self-center">{{ count(@$collection) }} รายการ</span>
</p>
    <div class="table-responsive scroll" style="max-height: 200px;">
        <table class="table align-middle table-nowrap text-nowrap table-hover table-check font-size-12 table-sm text-center">
            <thead class="table-info sticky-top">
                <tr class="">
                    <th>งวด</th>
                    <th>รหัสชำระ</th>
                    <th>รายการ</th>
                    <th>ยอดลูกหนี้</th>
                    <th class="editAroth" style="display: none;">ส่วนลด</th>
                    <th class="editAroth" style="display: none;">#</th>
                </tr>
            </thead>
            <tbody class="tbody-pay">
                @foreach (@$collection as $key => $item)
                <tr>
                    <td class="text-body fw-bold text-center">{{ @$item->NOPAY}}</td>
                    <td>
                        <button type="button" class="btn btn-soft-success waves-effect waves-light btn btn-secondary btn-sm btn-rounded" style="pointer-events: none;">
                            {{@$item->FORCODE}}
                        </button>
                    </td>
                    <td>
                        <button type="button" class="btn btn-soft-success waves-effect waves-light btn btn-secondary btn-sm btn-rounded" style="pointer-events: none;">
                            {{@$item->FORDESC}}
                        </button>
                    </td>
                    <th>{{number_format($item->PAYAMT,0)}}</th>
                    <th class="editAroth" style="display: none;">
                        @php
                        $ArrDISCAROTH = explode(",",@$data->DISCAROTH);
                        @endphp
                        <span class="DISCVAL-{{$item->id}} TBDISC-{{$item->id}}" id="{{$page}}-{{$item->id}}">{{ @$data->DISCAROTH != NULL ? @$ArrDISCAROTH[$loop->index] : 0 }}</span>
                        <input name="INPUTDISC[]" class="form-control form-control-sm inputall INPUTDISC-{{$item->id}}" id="{{$page}}input-{{$item->id}}" value="{{ @$data->DISCAROTH != NULL ? @$ArrDISCAROTH[$loop->index] : 0 }}" style="display:none;" type="text" onClick="this.setSelectionRange(0, this.value.length)">
                    </th>
                    <td class="editAroth" style="display: none;">
                        <i class="bx bx-save text-success fs-5 TBDISC-{{$item->id}}" style="display: none;" onclick="save({{$item->id}})"></i>
                        <i class="bx bx-edit-alt text-warning fs-5 TBDISC-{{$item->id}}" onclick="edit({{$item->id}})"></i>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="table-info sticky-bottom">
                <tr class="">
                    <th colspan="2" style="width: 20px;">
                        รวม
                    </th>
                    <th></th>
                    {{-- <th></th> --}}
                    <th class="text-decoration-underline">{{ number_format(@$collection->sum('PAYAMT'),2) }}</th>
                    <th class="editAroth" style="display: none;"> <span class="text-decoration-underline" class="{{$page}}sum" id="{{$page}}sum">{{ @$data->DISCAROTH != NULL ? array_sum(@$ArrDISCAROTH) : 0 }}</span> </th>
                    <th class="editAroth" style="display: none;"></th>
                </tr>
            </tfoot>
        </table>
    </div>



@else
    <blockquote class="blockquote font-size-16 mb-0">
        <p class="font-size-14">ไม่พบข้อมูล.</p>
        <footer class="blockquote-footer"><cite title="Source Title">โปรดตรวจสอบ รายการลูกหนี้อื่นของลูกค้า</cite></footer>
    </blockquote>
@endif
@endisset

@empty(@$collection)
<blockquote class="blockquote font-size-16 mb-0">
    <p class="font-size-14">ไม่พบข้อมูล.</p>
    <footer class="blockquote-footer"><cite title="Source Title">โปรดตรวจสอบ รายการลูกหนี้อื่นของลูกค้า</cite></footer>
</blockquote>
@endempty





