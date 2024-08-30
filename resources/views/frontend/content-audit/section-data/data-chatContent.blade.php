<style>
	.liChat {
		min-height: 400px;
		max-height: 400px;
		overflow: auto;
		display: flex;
		flex-direction: column-reverse;
	}
</style>
<div class="chat-conversation">
	<div class="liChat px-4">
		<ul class="list-unstyled mb-0" id="liChat">
			@php
				$currentDay = null;
			@endphp
			@foreach (@$audit->auditTagToTagpart as $tagpart)
				@php
					$tagpartDay = \Carbon\Carbon::parse($tagpart->created_at)
					    ->locale('th')
					    ->isoFormat('LL');
					$isToday = \Carbon\Carbon::parse($tagpart->created_at)->isToday();
				@endphp
				@if ($currentDay != $tagpartDay)
					<li>
						<div class="chat-day-title">
							<span class="title">{{ $isToday ? 'วันนี้' : $tagpartDay }}</span>
						</div>
					</li>
					@php
						$currentDay = $tagpartDay;
					@endphp
				@endif

				@if (@$tagpart->UserInsert == auth()->user()->id)
					<li class="right">
						<div class="conversation-list">
							@if (!empty($tagpart->TagpartToLog))
								<div class="dropdown">
									<a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="bx bx-dots-vertical-rounded"></i>
									</a>
									<div class="dropdown-menu" style="">
										<a role="button" class="dropdown-item d-flex justify-content-between pe-auto modal_lg" data-link="{{ route('audit.edit', @$tagpart->id) }}?page={{ 'chat-history' }}">
											รายละเอียด <i class="bx bx-history fs-5 text-warning"></i>
										</a>
									</div>
								</div>
							@endif
							
							<div class="ctext-wrap">
								<div class="conversation-name">{{ @$tagpart->TagpartToUser->name }}</div>
								{{-- <p>สถานะ : <span class="badge rounded-pill bg-success bg-soft text-success fs-6">{{ $item->Status_TrackPart }}</span></p> --}}
								<p> {{ @$tagpart->Detail_TrackPart }} </p>
								<p class="chat-time mb-0"><i class="bx bx-time-five align-middle me-1"></i> {{ date('d-m-Y H:i:s', strtotime($tagpart->created_at)) }}</p>
							</div>
						</div>
					</li>
				@else
					<li class="">
						<div class="conversation-list">
							@if (!empty($tagpart->TagpartToLog))
								<div class="dropdown">
									<a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<i class="bx bx-dots-vertical-rounded"></i>
									</a>
									<div class="dropdown-menu" style="">
										<a role="button" class="dropdown-item d-flex justify-content-between pe-auto modal_lg" data-link="{{ route('audit.edit', @$tagpart->id) }}?page={{ 'chat-history' }}">
											รายละเอียด <i class="bx bx-history fs-5 text-bg-warning"></i>
										</a>
									</div>
								</div>
							@endif

							<div class="ctext-wrap">
								<div class="conversation-name">{{ @$tagpart->TagpartToUser->name }}</div>
								<p> {{ @$tagpart->Detail_TrackPart }} </p>
								<p class="chat-time mb-0"><i class="bx bx-time-five align-middle me-1"></i> {{ date('d-m-Y H:i:s', strtotime($tagpart->created_at)) }}</p>
							</div>
						</div>
					</li>
				@endif

				{{-- <li class="last-chat">
					<div class="conversation-list">
						<div class="dropdown">
							<a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="bx bx-dots-vertical-rounded"></i>
							  </a>
							<div class="dropdown-menu" style="">
								<a class="dropdown-item" href="#">Copy</a>
								<a class="dropdown-item" href="#">Save</a>
								<a class="dropdown-item" href="#">Forward</a>
								<a class="dropdown-item" href="#">Delete</a>
							</div>
						</div>
						<div class="ctext-wrap">
							<div class="conversation-name">Steven Franklin</div>
							<p>&amp; Next meeting tomorrow 10.00AM</p>
							<p class="chat-time mb-0"><i class="bx bx-time-five align-middle me-1"></i> 10:06</p>
						</div>
					</div>
				</li> --}}
			@endforeach
		</ul>
	</div>
</div>
