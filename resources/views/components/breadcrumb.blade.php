<!-- start page title -->
<div class="row">
	<div class="col-12">
		<div class="page-title-box d-sm-flex align-items-center justify-content-between">
			<h4 class="mb-sm-0 font-size-18">{{ $title }} <small class="font-small">{{ @$title_small }}</small></h4>
			<div class="page-title-right">
				@if(!empty($menu) || !empty(@$sub_menu))
					<ol class="breadcrumb m-0">
						<li class="breadcrumb-item"><a href="javascript: void(0);">{{ @$menu }}</a></li>
						<li class="breadcrumb-item active">{{ @$sub_menu }}</li>
					</ol>
				@endIf
				@if(@$btnSearch == true)
					<a class="btn btn-primary w-md waves-effect waves-light btn header_btnSearch">สอบถาม <i class="bx bx-search"></i></a>
				@endif
			</div>
		</div>
	</div>
</div>
<!-- end page title -->
