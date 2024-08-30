<style>
	.ribbon-2 {
		--f: 10px;
		/* control the folded part*/
		--r: 15px;
		/* control the ribbon shape */
		--t: 10px;
		/* the top offset */
		position: absolute;
		inset: var(--t) calc(-1*var(--f)) auto auto;
		padding: 0 10px var(--f) calc(10px + var(--r));
		clip-path:
			polygon(0 0, 100% 0, 100% calc(100% - var(--f)), calc(100% - var(--f)) 100%,
				calc(100% - var(--f)) calc(100% - var(--f)), 0 calc(100% - var(--f)),
				var(--r) calc(50% - var(--f)/2));
		/* background: #f54462; */
		box-shadow: 0 calc(-1*var(--f)) 0 inset #0005;
	}
</style>

    @php
    if (@$data['Status_Con'] == 'complete' || @$data['Status_Con'] == 'transfered' || @$data['Status_Con'] == 'close'){
        $color = 'bg-success';
        $border = 'border-success';
    }
    elseif(@$data['Status_Con'] == 'active'){
        $color = 'bg-warning';
        $border = 'border-warning';
    }
    else{
        $color = 'bg-danger';
        $border = 'border-danger';
    }
    @endphp

<div class="card rounded-4 me-3 border-2 border {{ @$data['TOTPRC'] - @$data['SMPAY'] > 0 ? 'border-info' : @$border }} mb-1" style = "min-width:30rem; max-width:30rem; ">
    <div class="box">
        <div class="ribbon-2 {{ @$data['TOTPRC'] - @$data['SMPAY'] > 0 ? 'bg-info' : @$color }} text-light">{{ @$data['TOTPRC'] - @$data['SMPAY'] > 0 ? 'อยู่ระหว่างผ่อนสัญญา' : @$data['StatusCon'] }} &nbsp;</div>
    </div>
    <div class="row m-1 py-3">
        <div class="col-5 m-auto border-end">
            <div class="col-12 m-auto text-center">
                <img src="{{ @$data['img'] != NULL ? @$data['img'] : URL::asset('\assets\images\OIP.png') }}" class="rounded-circle border border-3 {{ @$data['TOTPRC'] - @$data['SMPAY'] > 0 ? 'border-info' : @$border }}  p-1" alt="เพิ่ม" style="width: 100px; height: 100px;">
            </div>
            <div class="col-12 mt-2 text-center">
                <h5 class="fw-semibold">{{ @$data['Name_Cus'] }}</h5>
                <span class="badge rounded-pill text-bg-success fs-6 px-2">{{ @$data['name-index'] }}</span>
            </div>
            <div class="col-12 mt-2 text-center">
                <a href="{{ route('contract.edit', @$data['id']) }}?funs={{'contract'}}" target="_blank" type="button" class="btn btn-primary btn-sm rounded-pill">ดูสัญญา <i class="bx bx-link-external"></i></a>
            </div>
        </div>
        <div class="col-7">
            <h6 class="fw-semibold my-3">{{ @$data['content-head'] }}  </h6>
            <table class="table table-nowrap table-striped table-sm mb-0">
                <tbody>
                    <tr>
                        <th><i class="bx bx-info-circle text-success"></i> {{ @$data['content-1'] }} :</th>
                        <td class="text-end" title="{{ @$data['data-1'] }}">{{ Str::limit(@$data['data-1'], 15) }}</td>
                    </tr>
                    <tr>
                        <th><i class="bx bx-info-circle text-success"></i> {{ @$data['content-2'] }} :</th>
                        <td class="text-end" title="{{@$data['data-2']}}">{{ Str::limit(@$data['data-2'], 12) }}</td>
                    </tr>
                    <tr>
                        <th><i class="bx bx-info-circle text-success"></i> {{ @$data['content-3'] }} :</th>
                        <td class="text-end" title="{{@$data['data-3']}}"> {{ Str::limit(@$data['data-3'], 15) }}</td>
                    </tr>
                    <tr>
                        <th><i class="bx bx-info-circle text-success"></i> {{ @$data['content-4'] }} :</th>
                        @if(@$data['data-4'] != NULL)
                            <td class="text-end"> <a type="button" class="btn btn-primary btn-sm rounded-pill" href="{{ @$data['data-4'] }}" target="_blank">ดูอัลบั้ม <i class="bx bx-link-external"></i></a> </td>
                        @else
                            <td class="text-end"> - </td>
                        @endif
                    </tr>
                    <tr>
                        <th><i class="bx bx-info-circle text-success"></i> {{ @$data['content-5'] }} :</th>
                        @if(@$data['data-5'] != NULL)
                            <td class="text-end"> <a type="button" class="btn btn-primary btn-sm rounded-pill" href="{{ @$data['data-5'] }}" target="_blank">ดูอัลบั้ม <i class="bx bx-link-external"></i></a> </td>
                        @else
                            <td class="text-end"> - </td>
                        @endif
                    </tr>

                </tbody>
            </table>
        </div>
    </div>

    @if(@$data['TOTPRC'] != NULL)
    <div class="row m-1">
        <ul class="list-group list-group-flush">
            <li class="list-group-item">
                <div class="py-2">
                    <h5 class="font-size-14 text-mute fw-semibold">ยอดทั้งสัญญา <span class="float-end text-mute fw-semibold">ยอดชำระแล้ว</span></h5>
                    <h5 class="font-size-14">{{ number_format(@$data['TOTPRC'],2) }} <span class="float-end">{{ number_format(@$data['SMPAY'],2) }}</span></h5>
                    <div class="progress animated-progess progress-sm">
                        <div class="progress-bar {{ @$data['TOTPRC'] - @$data['SMPAY'] == 0 ? 'bg-success' : 'bg-warning' }}"  role="progressbar" style="width: {{ number_format((@$data['SMPAY'] / @$data['TOTPRC']) * 100,0) }}%" aria-valuenow="{{ (@$data['SMPAY'] / @$data['TOTPRC']) * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </li>

        </ul>
    </div>
    @endif

</div>











