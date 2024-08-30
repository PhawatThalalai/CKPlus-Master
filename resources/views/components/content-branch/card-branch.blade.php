<style>
	.btnAdd:hover {
		opacity: 0.7;
		cursor: pointer;
	}

	#container {
		position: relative;
		width: 100%;
		white-space: nowrap;
		scroll-snap-type: x mandatory;
	}

	.slide-content {
		display: inline-block;
	}

	.scroll-slide {
		cursor: pointer;
		overflow-y: auto;
		overflow-x: hidden;
		height: auto;
		white-space: nowrap;
		scroll-snap-type: x mandatory;
	}

	.scroll-slide::-webkit-scrollbar {
		width: 5px;
		height: 7px;
		background-color: #F5F5F5;
	}

	.scroll-slide::-webkit-scrollbar-thumb {
		border-radius: 10px;
		-webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
		background-color: #ddd;
	}

	.resize {
		transform-origin: 100% 50%;
	}
</style>
@foreach ($data['dataBranch'] as $branch)
	<div class="slide-content">
		<div class="nav flex-column nav-pills mb-2" id="v-pills-tab" role="tablist" aria-orientation="vertical">
			<button class="btn btn-soft-info waves-effect waves-light d-flex mb-1 active d-none" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">
				<i class="bx bxs-map me-1"></i> Home
			</button>
			<button class="btn-soft-info waves-effect waves-light  gap-2 branchClickCard activecard-tabs-{{ $branch->id }} rounded-pill px-3" id="tabs-{{ $branch->id }}" data-bs-toggle="pill" data-bs-target="#tab-{{ $branch->id }}" type="button" role="tab" aria-controls="tab-{{ $branch->id }}" aria-selected="true">
				<i class="fas fa-map-marker-alt"></i> สาขา{{ $branch->Name_Branch }}
				<span class="badge text-bg-danger rounded-circle countBranch-{{ $branch->id }}">
					{{ @$data['countDataBranch'][$branch->id] }}
				</span>
			</button>

		</div>
	</div>
@endforeach


