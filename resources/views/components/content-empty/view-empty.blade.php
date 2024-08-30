<div class="row">
	<div class="col text-center" {{ @$tb_style }}>
		<img src="{{ URL::asset('\assets\images\out-of-stock.png') }}" class="up-down mt-4" style="width:100px;">
		<h5 class=" fw-semibold mt-2 text-danger">{{ @$data['headtitle'] }}</h5>
		<h6 class=" fw-semibold mt-2">{{ @$data['title'] }}</h6>
		<a class="btn btn-primary btn-sm rounded-pill {{ @$data['name_btn'] }}" type="button" {{ @$data_link }}> {{ @$btn_icon }} {{ @$data['title_btn'] }}</a>
	</div>
</div>