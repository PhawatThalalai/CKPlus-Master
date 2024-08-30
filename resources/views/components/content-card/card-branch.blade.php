@php
	if (@$data['percent'] >= 0 && @$data['percent'] < 50) {
	    $color = 'badge-soft-danger';
	    $colorPG = 'bg-danger';
	} elseif (@$data['percent'] >= 50 && @$data['percent'] < 100) {
	    $color = 'badge-soft-warning';
	    $colorPG = 'bg-warning';
	} else {
	    $color = 'badge-soft-success';
	    $colorPG = 'bg-success';
	}
@endphp
<div class="card card-hover card-branch rounded-3 mb-2 me-2" card-active="{{ @$data['permiss_billcoll'] }}" card-id=" {{ @$data['id_branch'] }} " style="max-width: 250px; min-width: 250px; cursor:pointer;">
	<div class="card-body mb-0">
		<div class="row mb-3">
			<div class="col">
				<img src="{{ URL::asset('/assets/images/CK-location.png') }}" alt="" class="bg-light p-1 w-50 rounded-circle" alt="">
			</div>
			<div class="col text-end">
				<span class="badge rounded-pill badge-soft-warning font-size-11 fw-semibold">{{ @$data['NickName_Branch'] }}</span>

			</div>
		</div>

		<div class="row">
			<div class="col">
				<h5 class="fw-semibold font-size-13">{{ @$data['Name_Branch'] }}</h5>
			</div>
		</div>

		<div class="row">
			<div class="col px-2">
				<div class="progress">
					<div class="progress-bar animated-progess progress-bar-striped {{ @$colorPG }} progress-bar-animated" role="progressbar" style="width: {{ @$data['percent'] }}%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
			</div>
		</div>

		<div class="row mt-1">
			<div class="col text-center border-end" style="font-size:12px;">
				<span class="badge rounded-pill badge-soft-info font-size-11 fw-semibold">จำนวน : {{ @$data['count'] }}</span>
			</div>
			<div class="col text-center" style="font-size:12px;">
				<span class="badge rounded-pill {{ $color }} font-size-11 fw-semibold">ผ่าน : {{ number_format(@$data['percent'], 0) }} %</span>
			</div>
		</div>
	</div>
</div>
