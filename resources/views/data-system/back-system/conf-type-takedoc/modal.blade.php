<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div style="display: flex; align-items: end; gap: 10px;">
                    <img src="{{ URL::asset('assets/images/gif/approved.gif') }}" style="width: 40px;" alt="">
                    <h5>เพิ่มประเภทการเบิกเอกสาร</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="TYPEFFORM">
                <div class="modal-body">
                    <div class="formData">
                        <div class="input-bx">
                            <input type="text" class="form-control py-2 form-control-sm textSize-13" name="name_th" id="name_th" value="" placeholder="" required>
                            <span>ชื่อประเภท (TH)</span>
                        </div>
                        <div class="input-bx">
                            <input type="text" class="form-control py-2 form-control-sm textSize-13" name="name_en" id="name_en" value="" placeholder="" required>
                            <span>ชื่อประเภท (ENG)</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"><i class='bx bx-save' ></i> Add Now</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#TYPEFFORM").submit(function(e) {
            try {
                e.preventDefault();
            
                let data = {};
                $("#TYPEFFORM").serializeArray().map(function(x) {
                    data[x.name] = x.value;
                });

                $.ajax({
                    url: "{{ route('takeDoc.store') }}",
                    type: "POST",
                    data: {
                        data: data,
                        page: 'createTypeTakeDoc',
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            text: 'เพิ่มข้อมูลเสร็จสิ้น',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $(".btn-close").click();
                        $('#dataTable').html(res.resHtml).slideDown('slow');
                    },
                    error: function(err) {
                        Swal.fire({
                            position: "center",
                            icon: "error",
                            text: 'กรุณาลองใหม่อีกครั้ง',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
            } catch (error) {
                Swal.fire({
                    position: "center",
                    icon: "error",
                    text: error,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    });
</script>