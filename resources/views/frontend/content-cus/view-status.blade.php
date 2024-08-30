<style>
    .dataCus-popover {
  --bs-popover-max-width: 200px;
  --bs-popover-border-color: var(--bs-primary);
  --bs-popover-header-bg: var(--bs-primary);
  --bs-popover-header-color: var(--bs-white);
  --bs-popover-body-padding-x: 1rem;
  --bs-popover-body-padding-y: .5rem;
}
</style>

<div class="modal-content">
    <input type="hidden" id="IDCus" value="{{ $data->id }}">
    <div class="modal-header">
        <h6 class="modal-title fw-semibold">สถานะลูกค้า (Status Cus)</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <label class="card-radio-label mb-3" data-bs-toggle="popover" data-bs-placement="right" data-bs-trigger="hover" data-bs-title="<p class='fw-semibold mb-0'> <i class='bx bx-error-circle'></i> สถานะกำลังใช้งาน </p>" data-bs-custom-class="dataCus-popover" data-bs-content="
                    <div class='row'>
                        <div class='col-12 fs-6 text-center fw-semibold border-top border-light py-2'>
                           ลูกค้าพร้อมสำหรับการส่งจัดไฟแนนซ์
                        </div>
                    </div>">
                    <input type="radio" name="status-cus" id="" value="active" class="card-radio-input status-cus" {{ $data->Status_Cus == 'active' ? 'checked' : '' }}>
                    <div class="card-radio">
                        <i class="fas fa-check font-size-24 text-primary align-middle me-2 text-success"></i>
                        <span>ใช้งาน</span>
                    </div>
                </label>
            </div>

            <div class="col-12">
                <label class="card-radio-label mb-3" data-bs-toggle="popover" data-bs-placement="right" data-bs-trigger="hover" data-bs-title="<p class='fw-semibold mb-0'> <i class='bx bx-error-circle'></i> สถานะยกเลิก </p>" data-bs-custom-class="dataCus-popover" data-bs-content="
                    <div class='row'>
                        <div class='col-12 fs-6 text-center fw-semibold border-top border-light py-2'>
                           ลูกค้ารายนี้จะไม่สามารค้นหาได้อีกต่อไปจนกว่าจะมีการเปลี่ยนสถานะกลับมาเป็น <span class='fw-semibold text-decoration-underline'>ใช้งาน</span>
                        </div>
                    </div>">
                    <input type="radio" name="status-cus" id="" value="cancel" class="card-radio-input status-cus" {{ $data->Status_Cus == 'cancel' ? 'checked' : '' }}>

                    <div class="card-radio">
                        <i class="fas fa-times font-size-24 text-primary align-middle me-2 text-warning"></i>
                        <span>ยกเลิก</span>
                    </div>
                </label>
            </div>

            <div class="col-12">
                <label class="card-radio-label mb-3" data-bs-toggle="popover" data-bs-placement="right" data-bs-trigger="hover" data-bs-title="<p class='fw-semibold mb-0'> <i class='bx bx-error-circle'></i> สถานะแบล็คลิสต์ </p>" data-bs-custom-class="dataCus-popover" data-bs-content="
                    <div class='row'>
                        <div class='col-12 fs-6 text-center fw-semibold border-top border-light py-2'>
                           ลูกค้าแบล็คลิสต์ !
                        </div>
                    </div>">
                    <input type="radio" name="status-cus" id=""  value="blacklist" class="card-radio-input status-cus" {{ $data->Status_Cus == 'blacklist' ? 'checked' : '' }}>

                    <div class="card-radio">
                        <i class="fas fa-user-lock font-size-24 text-primary align-middle me-2 text-danger"></i>
                        <span>แบล็คลิสต์</span>
                    </div>
                </label>
            </div>
        </div>
    </div>
    <div class="modal-footer d-block">
        <div class="row g-1">
            <div class="col-6 d-grid">
                <button type="button" id="btn-UpdateStatusCus" class="btn btn-primary btn-sm">
                    บันทึก 
                    <span class="spinner-border spinner-border-sm spinner" role="status" aria-hidden="true" style="display: none;"></span>
                </button>
            </div>
            <div class="col-6 d-grid">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
    
            </div>
        </div>
    </div>
</div>


<script>
	$('[data-bs-toggle="popover"]').popover({
		html: true,
		trigger: 'hover'
	})
</script>

<script>
    $('#btn-UpdateStatusCus').click(()=>{
        $('.spinner').show()
        $('#btn-UpdateStatusCus').prop('disabled',true)
        let statusCus = $("input[name='status-cus']:checked").val();
        let ID = $('#IDCus').val()
        let url = '{{ route('cus.update',':ID') }}'
        url = url.replace(':ID', ID)
        $.ajax({
            url : url,
            type : 'PUT',
            data : {
                _token : '{{ @CSRF_TOKEN() }}',
                statusCus : statusCus,
                funs : 'update-statusCus',
            },
            success : async (res) =>{
                $('.spinner').hide()
                $('#btn-UpdateStatusCus').prop('disabled',false)
               await swal.fire({
                    icon : 'success',
                    title : 'สำเร็จ !',
                    text : 'อัพเดทสถานะลูกค้าเรียบร้อย',
                    timer : 2000,
                })
                $('#card-profile').html(res.html_view_profile)
                $('.modal').modal('hide');
            },
            error : (err) =>{
                $('.spinner').hide()
                $('#btn-UpdateStatusCus').prop('disabled',false)
                swal.fire({
                    icon : 'error',
                    title : 'ผิดพลาด !',
                    text : 'อัพเดทสถานะลูกค้าไม่สำเร็จ',
                    timer : 2000,
                })
            }

        })
    })
</script>