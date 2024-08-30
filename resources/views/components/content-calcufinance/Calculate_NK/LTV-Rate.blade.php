<style>
    .dataCal-popover {
  --bs-popover-border-color: var(--bs-primary);
  --bs-popover-header-bg: var(--bs-primary);
  --bs-popover-header-color: var(--bs-white);
  --bs-popover-body-padding-x: 1rem;
  --bs-popover-body-padding-y: .5rem;
}
</style>

@if(@$LTV != NULL)
    <div class="table-responsive fw-semibold ">
        <table class="table table-hover">
            <tbody>
                @foreach(@$LTV as $item)
                {{-- Check Credo --}}
                    @php
                         if(@$Credo_Score > $item->CredoScore){
                            $credo = @$item->Credo;
                         } else {
                            $credo = 0;
                         }
                    @endphp
                <tr OcuStart = "{{ $item->OcuStart }}" OcuEnd = "{{ $item->OcuEnd }}">
                    @if($item->LTV == 0)
                        <th> <small class="text-success">( {{ $item->LTV + $credo }} % )</small> เรท {{ $item->OcuStart }} {{ $item->OcuEnd }}</th>
                        <td class="text-end text-danger"> จัดไม่ได้ </td>
                        <td><i class="bx bx-lock-alt text-danger bx-tada"></i></td>
                    @else
                            <th> <small class="text-success">( {{ $item->LTV + $credo }} % )</small> เรท {{ $item->OcuStart }} {{ $item->OcuEnd }}</th>
                            <td class="text-end"> {{ number_format( floor(@$RatePrices * ( ( $item->LTV + $credo ) / 100) / 1000) * 1000 ,0)  }}</td>
                            <td data-bs-toggle="{{ $item->LTV == 0 ? '' : 'popover' }}" data-bs-placement="left" data-bs-custom-class="dataCal-popover" data-bs-trigger="hover focus" data-bs-title="รายละเอียด (เรท {{ $item->OcuStart }} {{ $item->OcuEnd }})"
                                data-bs-content="
                                <div class='row'>
                                    <div class='col-12 fs-6 fw-semibold'>- อยู่ในพื้นที่.</div>
                                    <div class='col-12 ms-2'> {{ $item->InArea }} ปี</div>
                                    <div class='col-12 fs-6 fw-semibold'>- ยอดจัดสูงสุด.</div>
                                    <div class='col-12 ms-2'> {{ number_format($item->MaxCashCar,0) }} บาท</div>
                                    <div class='col-12 fs-6 fw-semibold'>- การจัด</div>
                                    <div class='col-12 ms-2'>{{ $item->TextIncome != NULL ? $item->TextIncome : '-' }} </div>
                                    <div class='col-12 fs-6 fw-semibold'>- ค้ำประกัน</div>
                                    <div class='col-12 ms-2'>{{ $item->TextGuaran != NULL ? $item->TextGuaran : '-' }} </div>
                                    <div class='col-12 ms-2 mt-2 text-center'><span class='fw-semibold text-danger text-center'>{{ @$txtCar }}</span></div>

                                </div> ">
                                <i class="bx bxs-comment-dots bx-tada fs-5 text-primary"></i>
                            </td>
                        @endif
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="row">
        <div class="col text-center">
            <img id="ImageBrok" src="{{ asset('/assets/images/empty-cart.png') }}" style="min-width: 8rem;height: 8rem;" class="mb-1">
        </div>
    </div>
@endif

<script>
	$('[data-bs-toggle="popover"]').popover({
		html: true,
		trigger: 'hover'
	})
</script>







