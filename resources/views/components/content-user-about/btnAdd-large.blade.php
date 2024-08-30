<style>
	.icon-add {
		border-radius: 50px;
		position: relative;
		top: 50px;
	}

	.cardAdd {
		/* height: 250px; */
		transition: 0.3s;
	}

	.cardAdd:hover {
		opacity: 0.7;
		transition: 0.3s;
	}
</style>

<div class="cardAdd">
	<a id="add-large-btn" class="data-modal-xl"  data-link="{{ route('cus.create') }}?funs={{ @$funs }}&id={{ @$id }}">
		<div class="card bg-secondary p-2" style="height : 223px;">
			<div class="bg-light icon-add">
				<img src="{{URL::asset('assets/images/plus.png')}}" alt="เพิ่ม" style="width: 100px;" class="btnAdd">
			</div>
		</div>
	</a>
</div>
