@extends('layouts.master')
@section('title', 'Group Branchs')
@section('System-p1-active', 'mm-active')

@section('content')
@include('components.content-toast.view-toast')

	<div class="container-fluid">
		<div class="row mt-n5">
			<div class="col-12">
				<div class="page-title-box d-sm-flex align-items-center justify-content-between">
					<h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>

					<div class="page-title-right">
						<ol class="breadcrumb m-0">
							<li class="breadcrumb-item"><a href="javascript: void(0);">Mega Menu</a></li>
							<li class="breadcrumb-item">ข้อมูลค่าคงที</li>
							<li class="breadcrumb-item active">กำหนดกลุ่มงาน</li>
						</ol>
					</div>
				</div>
			</div>
		</div>

		<div class="content-page">
			@include('constants.section-constants.content-groups.data-groups')
			{{-- <livewire:section-constants.content-groups.view-groups /> --}}
		</div>
	</div>

@endsection
