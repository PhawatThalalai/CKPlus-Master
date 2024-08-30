@include('backend.content-track.script')
@include('components.content-toast.view-toast')
<script src="{{ URL::asset('assets/js/plugin.js') }}"></script>

<style>
    .form-floating {
		position: relative;
		display: flex;
		width: 100%;
		font-size: 12px;
		/* width: 300px; */
	}

	.input-bx {
		position: relative;
		display: flex;
		width: 100%;
		/* width: 300px; */
	}

	.input-bx input {
		width: 100%;
		padding: 7px;
		border: 1px solid #cacfd6;
		border-radius: 4px;
		outline: none;
		transition: 0.4s;
	}

	.input-bx span {
		position: absolute;
		left: 0;
		padding: 10px;
		font-size: 12px;
		color: #7f8fa6;
		text-transform: uppercase;
		pointer-events: none;
		transition: 0.4s;
	}

	.input-bx input:valid~span,
	.input-bx input:focus~span {
		/* color: #3742fa; */
		transform: translateX(10px) translateY(-7px);
		font-size: 0.65rem;
		font-weight: 600;
		padding: 0 10px;
		background: #fff;
		letter-spacing: 0.1rem;
	}

    .BtnStatus{
        padding: 10px 25px 10px 25px;
    }
</style>

<form name="FormAddData" id="FormAddData" action="{{ route('datatrack.update',@$data[0]->LOCAT) }}" method="post" enctype="multipart/form-data" novalidate style="font-family: 'Prompt', sans-serif;">
  @csrf
  @method('put')
  <input type="hidden" name="type" value="2">
  <input type="hidden" name="TYPECONT" value="{{@$TYPECONT}}">
  <input type="hidden" name="LOCAT" value="{{@$data[0]->LOCAT}}">
  <input type="hidden" name="GROUP" value="{{@$GROUP}}">
  
    <div class="modal-content">
        <div class="d-flex m-3 mb-0">
            <div class="flex-shrink-0 me-2">
                <img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
            </div>
            @if(@$LAYER == 2)
                <div class="flex-grow-1 overflow-hidden">
                    <h4 class="text-primary fw-semibold">มอบหมายงาน</h4>
                    <p class="text-muted mt-n1">({{@$data[0]->LOCAT}}) สาขา{{@$data[0]->ToBranch->Name_Branch}}</p>
                    <p class="border-primary border-bottom mt-n2"></p>
                </div>
                <button type="button" class="btn-close text-danger" data-bs-toggle="modal" data-bs-target="#Modal-xl-3" aria-label="Close"></button>
            @else 
                <div class="flex-grow-1 overflow-hidden">
                    <h4 class="text-primary fw-semibold">มอบหมายงาน</h4>
                    <p class="text-muted mt-n1">(กลุ่มงานที่ {{@$GROUP_ID}})</p>
                    <p class="border-primary border-bottom mt-n2"></p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            @endif
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <div class="bg-primary bg-soft rounded-5">
                        <div class="row">
                            <div class="col-8 text-center">
                                <div class="text-primary mt-4">
                                   <h5>กลุ่มที {{@$GROUP_NO}}</h5> 
                                </div>
                            </div>
                            <div class="col-4">
                                <img src="{{ URL::asset('/assets/images/profile-img.png') }}" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="card border" data-simplebar="init" style="max-height: 500px;">
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-6 col-md-6">
                                    <div class="input-bx">
                                        <input type="text" id="FOLLOWCODE" name="BILL_COLL" value="{{@$data[0]->BILLCOLL}}" class="form-control" placeholder=" " required/>
                                        <span>BILLCOLL</span>
                                        <button class="input-group-text Modal-xl-2" type="button" data-bs-toggle="modal" data-bs-target="#Modal-xl-2" data-link="{{ route('constants.create') }}?page={{'backend'}}&FlagBtn={{'FOLCODE'}}&modalID={{'Modal-xl'}}">
                                            <i class="dripicons-menu"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6">
                                    <div class="input-bx">
                                        <input type="text" id="FOLLOWNAME" value="{{@$data[0]->ToUser->name}}" class="form-control" readonly/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-12 col-lg-6">
                    <div class="card border" data-simplebar="init" style="max-height: 500px;">
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-6 col-md-6">
                                    <div class="input-bx">
                                        <input type="text" id="SALECODE" name="SALE_CODE" value="{{@$data[0]->SALECOD}}" class="form-control" placeholder=" " required/>
                                        <span>SALECODE</span>
                                        <button class="input-group-text Modal-xl-2" type="button" data-bs-toggle="modal" data-bs-target="#Modal-xl-2" data-link="{{ route('constants.create') }}?page={{'backend'}}&FlagBtn={{'SALECODE'}}&modalID={{'Modal-xl'}}">
                                            <i class="dripicons-menu"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="col-6 col-md-6">
                                    <div class="input-bx">
                                        <input type="text" id="SALENAME" value="{{@$data[0]->ToSalecode->name}}" class="form-control" readonly/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <div class="col-md-12 col-lg-12 mt-n3">
                    <div class="card border" data-simplebar="init" style="max-height: 300px;">
                        <div class="card-body">
                            <table class="table m-0 table-group">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>CONTNO</th>
                                        <th>NAME</th>
                                        <th>BILLCOLL</th>
                                        <th>SALECOD</th>
                                        <th>CONSTAT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(@$data as $key => $row)
                                        <tr>
                                            <th scope="row">{{@$key+1}}</th>
                                            <td>{{@$row->CONTNO}}</td>
                                            <td>{{@$row->ToContract->PatchToPact->ContractToCus->Name_Cus}}</td>
                                            <td>{{@$row->BILLCOLL}}</td>
                                            <td>{{@$row->SALECOD}}</td>
                                            <td>{{@$row->CONTSTAT}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer mt-n3">
            <button type="button" id="AddData" class="btn btn-primary">
                <i class="bx bx-save"></i> Update
            </button>
        </div>
    </div>
</form>

{{-- Update BILLCOLL --}}
<script>
  $("#AddData").click(function(){

    var data = {};$("#FormAddData").serializeArray().map(function(x){data[x.name] = x.value;});
    // console.log(data);
      
    if ($("#FormAddData").valid() == true) {
      $.ajax({
          url: "{{ route('datatrack.update',0) }}",
          method: 'PUT',
          data:{
            _token:'{{ csrf_token() }}',
            type: 2,
            data:data,
          },

        success: function(result) {
            $('#Modal-xl').modal('hide');
            swal.fire({
            icon : 'success',
            title : 'บันทึกข้อมูลสำเร็จ',
            timer: 1500,
            showConfirmButton: false,
            })
            $("#GroupDetails").html(result);
        }
      });
    }
    else{
        swal.fire({
            icon : 'warning',
            title : 'ข้อมูลไม่ครบ !',
            text : 'กรุณากรอกข้อมูลให้ครบถ้วน',
            timer: 2000,
            showConfirmButton: false,
        })
    }      
  });
</script>

{{-- validate form --}}
<script>
    $(function () {
        $('#FormAddData').validate({
            errorElement: 'span',
                errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
