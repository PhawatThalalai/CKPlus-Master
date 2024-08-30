<style>
    .form-floating {
		position: relative;
		display: flex;
		width: 100%;
		font-size: 12px;
		/* width: 300px; */
	}
</style>

<form name="formUpdate" id="formUpdate" action="#" method="post" enctype="multipart/form-data" novalidate style="font-family: 'Prompt', sans-serif;">
    @csrf
    @method('put')
    <div class="modal-content">
        <div class="d-flex m-3 mb-0">
            <div class="flex-shrink-0 me-2">
                <img src="{{ asset('assets/images/payment.png') }}" alt="" class="avatar-sm">
            </div>
            <div class="flex-grow-1 overflow-hidden">
                <h5 class="text-primary fw-semibold pt-2 font-size-15">เเก้ไขเลขสัญญา</h5>
                <h6 class="text-secondary fw-semibold font-size-12"><i class="bx bxs-map me-1"></i>{{@$page}}</h6>
                <p class="border-primary border-bottom mt-2"></p>
            </div>
            <input type="hidden" id="page" name="PAGE" value="{{@$page}}">
            <input type="hidden" id="id" name="ID" value="{{@$data->id}}">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body mt-n4">
            <div class="row">
                <div class="col-md-12 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-2 mb-1">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" id="CONT_TYPE" value="{{@$data->Type_Contract}}" class="form-control bg-light" placeholder="ประเภทสัญญา" readonly>
                                        <label for="Contract">ประเภทสัญญา</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2 mb-1">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" value="{{@$data->UserAdd_Contract}}" class="form-control bg-light" placeholder="สาขา" readonly>
                                        <label for="Contract">User Create</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2 mb-1">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="datetime" value="{{@$data->created_at}}" class="form-control bg-light" placeholder="สาขา" readonly>
                                        <label for="Contract">Date Create</label>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-2 mb-1">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" id="BRANCH" value="{{@$data->ContractToBranch->Name_Branch}}" class="form-control bg-light" placeholder="สาขา" readonly>
                                        <label for="Contract">สาขา</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-2 mb-1">
                                <div class="col-12">
                                    <div class="form-floating">
                                        <input type="text" id="CONTNO" name="CONTNO" value="{{@$data->Code_Contract}}" class="form-control" placeholder="เลขที่สัญญา" required>
                                        <label for="Contract">เลขที่สัญญา</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="mt-4 mt-lg-0">
                                        <h5 class="font-size-12 mb-1">สถานะสัญญา</h5>
                                        <div class="d-flex">
                                            <div class="square-switch">
                                                <input type="checkbox" id="square-switch3" switch="bool" name="FLAG" value="Y" {{(@$data->Flag_Contract == 'Y')?'checked':''}}>
                                                <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer mt-n4">
            <!-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button> -->
            <button type="button" id="UpdateData" class="btn btn-primary rounded-pill me-2">
                <i class="mdi mdi-content-save-move"></i> Update
            </button>
        </div>
    </div>
</form>

{{-- Update Data --}}
<script>
    $("#UpdateData").click(function(){
        var data = {};$("#formUpdate").serializeArray().map(function(x){data[x.name] = x.value;});
        if ($("#formUpdate").valid() == true) {
            $.ajax({
                url: "{{ route('dataStatic.update',0) }}",
                method: 'PUT',
                // data:data,
                data:{
                    _token:'{{ csrf_token() }}',
                    update: 'contract-number',
                    data:data,
                },

                success: function(result) {
                    // $('.modal-backdrop').remove();
                    $('#Modal-xl').modal('hide');
                    swal.fire({
                        icon : 'success',
                        title : 'อัพเดทข้อมูลสำเร็จ',
                        timer: 1500,
                        showConfirmButton: false,
                    })
                    $("#dataContractNo").html(result).show('slow');
                }
            });
        }    
    });
</script>

{{-- validate form --}}
<script>
    $(function () {
        $('#formAdd,#formUp').validate({
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

