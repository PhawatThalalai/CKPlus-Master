<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>

<div class="modal-content">
	<form id="edit_dataUser" class="needs-validation" action="#" novalidate>
        <input type="hidden" name="page" id="page" value="{{@$page}}">
        <input type="hidden" name="title" value="{{@$title}}">
        <input type="hidden" name="id" value="{{@$data->id}}">

		<div class="modal-header bg-info bg-soft ">
			<h5 class="modal-title fw-semibold" id="data-modal-xl-label">{{@$title}}</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body">
			<div class="row mx-auto">
				<div class="col-lg-6 col-md-12">
					<div class="row mb-1">
						<label class="col-sm-3 col-form-label d-none d-sm-block text-danger">ชื่อสกุล :</label>
						<div class="col-12 col-sm-8">
							<div class="row">
								<div class="col-4 pe-0">
									<label class="col-12 d-sm-none col-form-label text-danger">คำนำหน้า :</label>
									<select name="Prefix" class="form-control" required>
										<option value="" selected>-- คำนำหน้า --</option>
										@foreach (@$TBPrefix as $value)
											<option value="{{ $value->Detail_Prefix }}" {{($value->Detail_Prefix == @$data['Prefix']) ?'selected' : ''}}>{{ $value->Detail_Prefix }}</option>
										@endforeach
									</select>
								</div>
								<div class="col-8">
									<label class="col-12 d-sm-none col-form-label text-danger">ชื่อ-นามสกุล :</label>
									<input type="text" name="Name_Cus" value="{{@$data['Name_Cus']}}" class="form-control" data-bs-toggle="tooltip" title="ชื่อ-นามสกุล" placeholder="ชื่อ-นามสกุล" required />
									<section class="invalid-tooltip">
										Enter first name
									</section>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="row mb-1">
						<label for="nickname" class="col-sm-3 col-form-label d-none d-sm-block">ชื่อเล่น :</label>
						<div class="col-12 col-sm-8">
							<div class="row">
								<div class="col-4 pe-0">
									<label for="nickname" class="col-12 d-sm-none col-form-label">ชื่อเล่น :</label>
									<input type="text" name="Nickname_cus" value="{{@$data['Nickname_cus']}}" class="form-control" data-bs-toggle="tooltip" title="ชื่อเล่น" placeholder="ชื่อเล่น">
								</div>
								<div class="col-8">
									<label for="code" class="col-12 d-sm-none col-form-label text-danger">รหัสลูกค้า :</label>
									<input type="text" value="{{ @$data['Code_Cus'] }}" class="form-control" data-bs-toggle="tooltip" title="รหัสลูกค้า" placeholder="รหัสลูกค้า" readonly>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="row mb-1">
						<label class="col-sm-3 col-form-label text-danger">ชื่ออังกฤษ: </label>
						<div class="col-sm-8">
							<input type="text" name="NameEng_cus" value="{{ @$data['NameEng_cus'] }}" class="form-control" data-bs-toggle="tooltip" title="ชื่อภาษาอังกฤษ" placeholder="ชื่อภาษาอังกฤษ">
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="row mb-1">
						<label class="col-sm-3 col-form-label text-danger">บัตรประจำตัว:</label>
						<div class="col-sm-8">
							<input type="text" name="Type_Card" value="{{ @$data['Type_Card'] }}" class="form-control" data-bs-toggle="tooltip" title="บัตรประจำตัว" placeholder="บัตรประจำตัว">
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="row mb-1">
						<label class="col-sm-3 col-form-label text-danger">เลข ปชช:</label>
						<div class="col-sm-8">
							<div class="input-group">
								<input type="text" name="IDCard_cus" value="{{ @$data['IDCard_cus'] }}" class="form-control input-mask" data-inputmask="'mask': '9-9999-99999-99-9'" data-bs-toggle="tooltip" title="เลขบัตรประชาชน" placeholder="เลขบัตรประชาชน">
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="row mb-1">
						<label for="view_IdcardExpire_cus" class="col-sm-3 col-form-label text-danger">บัตรหมดอายุ :</label>
						<div class="col-sm-8">
							<input type="date" name="IdcardExpire_cus" value="{{ @$data['IdcardExpire_cus'] }}" class="form-control" data-bs-toggle="tooltip" title="บัตรหมดอายุ"/>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="row mb-1">
						<label for="view_Birthday_cus" class="col-sm-3 col-form-label text-danger">วันเดือนปีเกิด :</label>
						<div class="col-sm-8">
							<input type="date" name="Birthday_cus" value="{{ @$data['Birthday_cus'] }}" class="form-control" data-bs-toggle="tooltip" title="วันเดือนปีเกิด"/>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="row mb-1">
						<label for="view_Phone_cus" class="col-sm-3 col-form-label text-danger">เบอร์ติดต่อ :</label>
						<div class="col-sm-8">
							<input type="text" name="Phone_cus" value="{{ @$data['Phone_cus'] }}" class="form-control input-mask" data-inputmask="'mask': '999-9999999,999-9999999'" data-bs-toggle="tooltip" title="เบอร์ติดต่อ" placeholder="เบอร์ติดต่อ" />
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="row mb-1">
						<label for="Nationality_cus" class="col-sm-3 col-form-label">สัญชาติ :</label>
						<div class="col-sm-8">
							<input type="text" name="Nationality_cus" value="{{ @$data['Nationality_cus'] }}" class="form-control" data-bs-toggle="tooltip" title="สัญชาติ" placeholder="สัญชาติ" />
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="row mb-1">
						<label for="religion" class="col-sm-3 col-form-label">ศาสนา:</label>
						<div class="col-sm-8">
							<input type="text" name="Religion_cus" value="{{ @$data['Religion_cus'] }}" class="form-control" data-bs-toggle="tooltip" title="ศาสนา" placeholder="ศาสนา" />
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="row mb-1">
						<label for="marital" class="col-sm-3 col-form-label">สถานะสมรส:</label>
						<div class="col-sm-8">
							<input type="text" name="Marital_cus" value="{{ @$data['Marital_cus'] }}" class="form-control" data-bs-toggle="tooltip" title="สถานะสมรส" placeholder="สถานะสมรส" />
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="row mb-1">
						<label class="col-sm-3 col-form-label d-none d-sm-block">คู่สมรส :</label>
						<div class="col-12 col-sm-8">
							<div class="row">
								<div class="col-6 pe-0">
									<label class="col-12 d-sm-none col-form-label">คู่สมรส :</label>
									<input type="text" name="Mate_cus" value="{{ @$data['Mate_cus'] }}" class="form-control" data-bs-toggle="tooltip" title="คู่สมรส" placeholder="คู่สมรส" />
								</div>
								<div class="col-6">
									<label class="col-12 d-sm-none col-form-label">เบอร์โทรคู่สมรส :</label>
									<input type="text" name="Mate_Phone" value="{{ @$data['Mate_Phone'] }}" class="form-control" data-bs-toggle="tooltip" title="เบอร์โทรคู่สมรส" placeholder="เบอร์โทรคู่สมรส" />
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="row mb-1">
						<label class="col-sm-3 col-form-label d-none d-sm-block">Social :</label>
						<div class="col-12 col-sm-8">
							<div class="row">
								<div class="col-6 pe-0">
									<label class="col-12 d-sm-none col-form-label">Facebook :</label>
									<input type="text" name="Social_facebook" value="{{ @$data['Social_facebook'] }}" class="form-control" data-bs-toggle="tooltip" title="Facebook" placeholder="Facebook" />
								</div>
								<div class="col-6">
									<label class="col-12 d-sm-none col-form-label">Line ID :</label>
									<input type="text" name="Social_Line" value="{{ @$data['Social_Line'] }}" class="form-control" data-bs-toggle="tooltip" title="Line ID" placeholder="Line ID" />
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="row mb-1">
						<label for="driver-license" class="col-sm-3 col-form-label">ใบขับขี่ :</label>
						<div class="col-sm-8">
							<input type="text" name="Driver_cus" value="{{ @$data['Driver_cus'] }}" class="form-control" data-bs-toggle="tooltip" title="ใบขับขี่" placeholder="ใบขับขี่" />
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="row mb-1">
						<label for="name-change" class="col-sm-3 col-form-label">ประวัติ :</label>
						<div class="col-sm-8">
							<input type="text" name="Namechange_cus" value="{{ @$data['Namechange_cus'] }}" class="form-control" data-bs-toggle="tooltip" title="ประวัติ" placeholder="ประวัติ" />
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="row mb-1">
						<label for="name-change" class="col-sm-3 col-form-label">ธนาคาร :</label>
						<div class="col-sm-8">
							<input type="text" name="Name_Account" value="{{ @$data['Name_Account'] }}" class="form-control" data-bs-toggle="tooltip" title="ธนาคาร" placeholder="ธนาคาร" />
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="row mb-1">
						<label class="col-sm-3 col-form-label d-none d-sm-block">สาขา :</label>
						<div class="col-12 col-sm-8">
							<div class="row">
								<div class="col-6 pe-0">
									<label class="col-12 d-sm-none col-form-label">สาขา :</label>
									<input type="text" name="Branch_Account" value="{{ @$data['Branch_Account'] }}" class="form-control" data-bs-toggle="tooltip" title="สาขา" placeholder="สาขา" />
								</div>
								<div class="col-6">
									<label class="col-12 d-sm-none col-form-label">เลขบัญชี :</label>
									<input type="text" name="Number_Account" value="{{ @$data['Number_Account'] }}" class="form-control" data-bs-toggle="tooltip" title="เลขบัญชี" placeholder="เลขบัญชี" />
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12">
					<div class="row mb-1">
						<label for="name-change" class="col-sm-3 col-form-label">หมายเหตุ :</label>
						<div class="col-sm-8">
							<textarea name="Note_cus" id="textarea" rows="2" class="form-control" maxlength="225" placeholder="หมายเหตุ...">{{ @$data['Note_cus'] }}</textarea>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-primary btn-sm waves-effect waves-light hover-up btn_editUser">Update</button>
			<button type="button" class="btn btn-secondary btn-sm waves-effect hover-up" data-bs-dismiss="modal">Close</button>
		</div>
	</form>
</div>

<script>
    $(document).ready(function() {
        $('.btn_editUser').click(function() {
            var dataform = document.querySelectorAll('.needs-validation');
            var validate = validateForms(dataform);
            if (validate == true) {
                var type = 1;
                var _token = $('input[name="_token"]').val();
                var data = {};$("#edit_dataUser").serializeArray().map(function(x){data[x.name] = x.value;});

                if ($('#page').val() == 'Customer') {
                    var url = '{{ route("cus.update",0) }}';
                }else{
                    var url = '{{ route("broker.update",0) }}';
                }

                $.ajax({
                    url: url,
                    method: "PUT",
                    data: {_token:_token,type:type,data:data},
                    success:function(result){
                        $('#data-modal-xl').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            text: 'successful !',
                            showConfirmButton: false,
                            timer: 1500
                        });

                        $('#content_cus').html(result);
                    }
                })
            }
        });
    });
</script>

<script>
    function validateForms(dataform) {
        var isvalid = false;
        Array.prototype.slice.call(dataform).forEach(function(form) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();

                form.classList.add('was-validated');

                isvalid = false;
            }else{
                isvalid = true;
            }
        });
        return isvalid;
    }
</script>
