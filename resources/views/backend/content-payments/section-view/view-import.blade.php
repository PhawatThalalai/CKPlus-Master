@extends('layouts.master')
@section('title', 'Payments')
@section('payments-active', 'mm-active')
@section('payments-auto-active', 'mm-active')
@section('importpay-active', 'mm-active')
@section('page-frontend', 'd-none')

@section('content')
	<link href="{{ URL::asset('/assets/libs/dropzone/dropzone.min.css') }}" rel="stylesheet" type="text/css" />

	<style>
		/* ปรับขนาดของ Dropzone */
		.dropzone {
			/* height: 180px; */
			border: 2px dashed #ccc;
			padding: 20px;
			margin: 0 auto;
		}
	</style>

	<style>
		.col-xl-12,
		.col-xl-4 {
			transition: all 0.50s ease;
			/* เปลี่ยนคลาสด้วย transition ที่ smooth เป็นเวลา 0.5 วินาที */
		}
	</style>

	@include('components.content-search.view-search', ['page_type' => $page_type, 'page' => $page, 'typeSreach' => $typeSreach, 'dataSreach' => $dataSreach])
	@component('components.breadcrumb')
		@slot('title')
			นำเข้าไฟล์
		@endslot
		@slot('title_small')
			(file imports)
		@endslot
		@slot('menu')
			การเงิน
		@endslot
		@slot('sub_menu')
			ระบบตัดเงินอัตโมนัติ
		@endslot
	@endcomponent

	<div class="row g-3 content-import">
		<div class="col-xl-12">
			<div class="card-company"></div>
			<div class="card" style="border-radius: 10px;">
				<div class="card-body">
					<h4 class="card-title">เลือกไฟล์</h4>
					<div>
						<form id="fileUpload" class="dropzone" action="{{ route('import.store') }}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="fallback">
								<input name="fileItem" id="fileItem" type="file" multiple="multiple">
							</div>
							<div class="dz-message needsclick" style="margin-top: 20px;">
								<div class="mb-3">
									<i class="display-4 text-muted bx bxs-cloud-upload"></i>
								</div>
								<h5>Drop files here or click to upload.</h5>
							</div>
						</form>
					</div>
					<div class="text-center mt-4">
						<button type="button" id="btn_process" class="btn btn-success btn-rounded waves-effect waves-light hover-up d-none">Process</button>
						<button type="button" id="btn_import" class="btn btn-primary btn-rounded waves-effect waves-light hover-up">Send Files</button>
						<button id="btn_delete" class="btn btn-danger waves-effect btn-rounded waves-light hover-up" disabled>Clear Files</button>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xl-8 col-lg-12">
			<div class="card-body data-imports"></div>
		</div>
	</div>

	<div class="row content-data" style="display: none !important">
		<div class="col">
			@include('backend.content-payments.section-import.data-process')
		</div>
	</div>

	{{-- <script>
		window.addEventListener("beforeunload", function(e) {
			e.preventDefault(); // ยกเลิกการปิดหน้าเว็บเริ่มต้น
	
			Swal.fire({
				title: "คุณแน่ใจหรือไม่?",
				text: "คุณต้องการออกจากหน้าเว็บหรือไม่?",
				icon: "question",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "ใช่, ฉันต้องการออก",
				cancelButtonText: "ยกเลิก"
			}).then((result) => {
				if (result.isConfirmed) {
					// ตอบ "ใช่" คือต้องการออก
					// ทำอย่างไรก็ตามที่คุณต้องการทำที่นี่
				} else {
					// ตอบ "ยกเลิก" คือไม่ต้องการออก
					// ทำอย่างไรก็ตามที่คุณต้องการทำที่นี่
				}
			});
		});
	</script> --}}

	{{-- <script>
		window.addEventListener("beforeunload", function(e) {
			var confirmationMessage = "\หกดกหดหกดหกดกหดหกด/";

			(e || window.event).returnValue = confirmationMessage; //Gecko + IE
			return confirmationMessage; //Webkit, Safari, Chrome
		});
	</script> --}}

	<script src="{{ URL::asset('/assets/libs/dropzone/dropzone.min.js') }}"></script>
	<script>
		Dropzone.autoDiscover = false;
		var myDropzone = new Dropzone(".dropzone", {
			autoProcessQueue: false,
			parallelUploads: 1, // Number of files process at a time (default 2)
			acceptedFiles: '.txt', // Type of files
			init: function() {
				this.on('success', function(file, response) {
					// เมื่อมีไฟล์ถูกเพิ่มเข้ามาใน Dropzone ให้อัพโหลดตามลำดับ
					if (!myDropzone.processing && myDropzone.getQueuedFiles().length > 0) {
						myDropzone.processQueue();
					} else {
						$(".loading-overlay").fadeOut().attr('style', 'display:none !important');

						Swal.fire({
							icon: 'question',
							title: response.message,
							text: 'ต้องการอัพโหลดไฟล์เพิ่มเติมหรือไม่ ?',
							showConfirmButton: true,
							showCancelButton: true,
							confirmButtonText: 'ไม่ใช่',
							cancelButtonText: 'ใช่',
							confirmButtonColor: '#42bd41',
							cancelButtonColor: '#3085d6',
							allowOutsideClick: false,
						}).then((result) => {
							if (result.isConfirmed) {
								$(".loading-overlay").fadeIn().attr('style', '');

								$.ajax({
									url: "{{ route('import.create') }}",
									method: "get",
									data: {
										_token: "{{ @csrf_token() }}",
										funs: 'create-dataImport',
									},

									success: function(result) {
										$(".loading-overlay").fadeOut().attr('style', 'display:none !important');

										Swal.fire({
											icon: 'success',
											text: 'Success !',
											showConfirmButton: false,
											timer: 1500
										})

										$('.card-company').slideUp(function() {
											$(this).html(result.company).slideDown('slow');
										});
										$('.data-imports').slideUp(function() {
											$(this).html(result.import).slideDown('slow');
										});

										var colDiv = document.querySelector(".col-xl-12");
										if (colDiv !== null) {
											if (!colDiv.classList.contains("col-xl-4")) {
												setTimeout(function() {
													colDiv.classList.remove("col-xl-12");
													colDiv.classList.add("col-xl-4");
													requestAnimationFrame(function() {});
												}, 0);
											}
										}

										$('#btn_process').addClass('d-none');
									}
								})
							} else {
								$('#btn_process').removeClass('d-none');
							}
						});
					}
				});

				this.on('error', function(file, errorMessage) {
					Swal.fire({
						icon: 'error',
						title: `ERROR ` + errorMessage + ` !!!`,
						text: errorMessage.responseJSON.message,
						showConfirmButton: true,
					});
				});

				// ตรวจสอบชื่อไฟล์ที่มีการอัปโหลดซ้ำ
				this.on('addedfile', function(file) {
					var existingFiles = myDropzone.files.filter(function(existingFile) {
						return existingFile.name === file.name;
					});

					if (existingFiles.length > 1) {
						Swal.fire({
							icon: 'warning',
							title: `Error ` + file.name,
							text: `ชื่อไฟล์นี้ มีการอัปโหลดไปแล้ว !`,
							showConfirmButton: true,
						});

						myDropzone.removeFile(file);
					}
				});
			}
		});

		// เพิ่มการตรวจสอบเมื่อมีไฟล์ถูกเลือก
		myDropzone.on("addedfile", function(file) {
			document.getElementById("btn_delete").disabled = false;
		});

		$('#btn_delete').click(function() {
			Swal.fire({
				icon: 'question',
				title: 'Clear Files',
				text: 'ต้องการล้างไฟล์ทั้งหมด หรือไม่ ?',
				showCancelButton: true,
				confirmButtonText: 'ตกลง',
				cancelButtonText: 'ยกเลิก',
				cancelButtonColor: '#d33',
				confirmButtonColor: '#3085d6',
			}).then((result) => {
				if (result.isConfirmed) {
					var sessionKeys = ['detailBank', 'dataHeader', 'dataDetails', 'dataFooter'];
					$.ajax({
						url: "{{ route('import.create') }}",
						method: "get",
						data: {
							_token: "{{ csrf_token() }}",
							funs: 'clear-session',
							session_keys: sessionKeys,
						},
						success: function(result) {
							$('#btn_process').addClass('d-none');
							Swal.fire({
								icon: 'success',
								text: 'deleted !',
								showConfirmButton: false,
								timer: 1500
							})

							myDropzone.removeAllFiles();
							document.getElementById("btn_delete").disabled = true;

							var colDiv = document.querySelector(".col-xl-4");
							if (colDiv !== null) {
								setTimeout(function() {
									colDiv.classList.remove("col-xl-4");
									colDiv.classList.add("col-xl-12");

									$('.card-company').slideUp();
									$('.data-imports').slideUp();
									requestAnimationFrame(function() {});
								}, 0);
							}
						},
						error: function(result) {
							Swal.fire({
								icon: 'error',
								title: 'Error!',
								text: 'ไม่สามารถลบ session หรือเกิดข้อผิดพลาด',
								showConfirmButton: true,
							});
						}
					});
				}
			});
		});

		$('#btn_import').click(function() {
			if (myDropzone.getQueuedFiles().length > 0) {
				$(".loading-overlay").fadeIn().attr('style', '');
				myDropzone.processQueue();
			} else {
				Swal.fire({
					icon: 'warning',
					title: 'แจ้งเตือน',
					text: `โปรดเลือกไฟล์ที่ต้องอัปโหลดก่อนคลิกปุ่มอัปโหลด !`,
					showConfirmButton: false,
					timer: 1500
				});
			}
		});

		$('#btn_process').click(function() {
			$.ajax({
				url: "{{ route('import.create') }}",
				method: "get",
				data: {
					_token: "{{ @csrf_token() }}",
					funs: 'create-dataImport',
				},

				success: function(result) {
					Swal.fire({
						icon: 'success',
						title: 'Success!',
						showConfirmButton: false,
						timer: 1500
					})

					$('.card-company').slideUp(function() {
						$(this).html(result.company).slideDown('slow');
					});
					$('.data-imports').slideUp(function() {
						$(this).html(result.import).slideDown('slow');
					});

					var colDiv = document.querySelector(".col-xl-12");
					if (colDiv !== null) {
						if (!colDiv.classList.contains("col-xl-4")) {
							setTimeout(function() {
								colDiv.classList.remove("col-xl-12");
								colDiv.classList.add("col-xl-4");
								requestAnimationFrame(function() {});
							}, 0);
						}
					}

					$('#btn_process').addClass('d-none');
				}
			})
		});
	</script>

	{{-- <script>
		Dropzone.options.myDropzone = {
			autoProcessQueue: false,
			init: function() {
				var myDropzone = this;

				// Add an event listener to the submit button or any other element
				document.querySelector("#btn_import").addEventListener("click", function(e) {
					console.log('ss');
					e.preventDefault();
					myDropzone.processQueue(); // Manually trigger the file upload
				});

				// Add event listeners for other events as needed
				myDropzone.on("addedfile", function(file) {
					// Do something when a file is added to the queue
				});

				// You can add more event listeners here for other Dropzone events
			},
		};
	</script> --}}

	{{-- <script>
		$(document).ready(function () {
			// Initialize Dropzone with custom options
			Dropzone.options.myDropzone = {
				autoProcessQueue: false,  // Prevent auto-uploading
				init: function () {
					var myDropzone = this;

					// Attach a click event handler to your button
					$("#btn_import").on("click", function () {
						myDropzone.processQueue();  // Start uploading when the button is clicked
					});

					// Add a complete event handler to display success or error messages
					myDropzone.on("complete", function (file) {
						if (file.status === "success") {
							// File upload was successful
							console.log("File uploaded successfully: " + file.name);
						} else {
							// File upload failed
							console.error("File upload failed: " + file.name);
						}

						// Reset the Dropzone after upload (optional)
						myDropzone.removeAllFiles();
					});
				}
			};
		});

	</script> --}}

	{{-- upload file --}}
	{{-- <script>
		$("#btn_import").click(function(e) {
			e.preventDefault();

			var files = $("#fileItem")[0].files; // รับรายการของไฟล์ที่ถูกเลือก

			// ตรวจสอบว่ามีไฟล์ที่ถูกเลือกหรือไม่
			if (files.length > 0) {
				var formData = new FormData(document.getElementById('upload-form'));

				// เพิ่มไฟล์ที่ถูกเลือกลงใน FormData
				for (var i = 0; i < files.length; i++) {
					formData.append('file[]', files[i]);
				}

				console.log(formData);

				// ต่อไปคุณสามารถทำ Ajax request ดังกล่าวเช่นเดียวกับก่อนหน้านี้
				// ...

			} else {
				// ถ้าไม่มีไฟล์ที่ถูกเลือก
				alert("โปรดเลือกไฟล์ที่คุณต้องการอัพโหลด");
			}
		});

		// $(document).ready(function() {
		// 	$("#btn_import").click(function(e) {
		// 		e.preventDefault();
				

		// 		$('#file').attr('required', true);
		// 		// var formData = new FormData(document.getElementById('upload-form'));

		// 		var formData = new FormData();
      	// 		var file = $('#file').prop('file')[0];
				
		// 		formData.append('file', file);
		// 		formData.append('_token', '{{ @csrf_token() }}');

		// 		console.log(file);


		// 		// $.ajax({
		// 		// 	url: "{{ route('import.store') }}",
		// 		// 	method: 'POST',
		// 		// 	data: formData,
		// 		// 	cache: false,
		// 		// 	processData: false,
		// 		// 	contentType: false,
		// 		// 	success: function(response) {
		// 		// 		console.log(response);
		// 		// 		swal({
		// 		// 			icon: 'success',
		// 		// 			text: 'อัพโหลดข้อมูลสำเร็จ',
		// 		// 			dangerMode: true,
		// 		// 			timer: 3500,
		// 		// 		})
		// 		// 	}
		// 		// });
		// 	});
		// });
	</script> --}}
@endsection
