<style>
	.scroller::-webkit-scrollbar-thumb {
		border-radius: 5px;
		-webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
		background-color: #fff;
	}

	.scroller::-webkit-scrollbar {
		width: 5px;
	}

	.scroller {
		max-height: 800px;
		overflow: scroll;
		padding-right: 5px;
	}
</style>


<div class="card p-1 h-100">
	<button class="nav-link btn btn-sm btn-info p-2 border border-white mb-2 rounded-pill" id="v-pills-disabled-tab" data-bs-toggle="pill" data-bs-target="#v-pills-disabled" type="button" role="tab" aria-controls="v-pills-disabled" aria-selected="false" disabled>รายการ</button>
	<div class="d-grid gap-2 scroller">
		<div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
			<div class="d-none ">
				<button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 active branchHome" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">
					<i class="bx bxs-map me-1"></i> Home
				</button>
			</div>

			@foreach ($data['dataBranch'] as $branch)
				<button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 font-size-12 branchClick active-tabs-{{ $branch->id }} rounded-pill" id="tabs-{{ $branch->id }}" data-bs-toggle="pill" data-bs-target="#tab-{{ $branch->id }}" type="button" role="tab" aria-controls="tab-{{ $branch->id }}" aria-selected="true">
					<i class="bx bxs-map me-1"></i> สาขา{{ $branch->Name_Branch }}
					<span class="col text-end"> <span class="badge rounded-pill bg-danger countBranch-{{ $branch->id }}">{{ @$data['countDataBranch'][$branch->id] }}</span> </span>
				</button>
			@endforeach
		</div>
	</div>
</div>
