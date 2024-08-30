<div class="modal-content">
	<div class="d-flex m-3 mb-0">
		<div class="flex-shrink-0 me-2">
			<img src="{{ asset('assets/images/gif/book.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
		</div>
		<div class="flex-grow-1 overflow-hidden">
			<h5 class="text-primary fw-semibold">ตารางแสดงยอดเบี้ยปรับ</h5>
			<p class="text-muted mt-n1 fw-semibold font-size-12">( View Liquidated )</p>
			<p class="border-primary border-bottom mt-n2"></p>
		</div>
		<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
	</div>
	<div class="modal-body">

        <div class="row g-1 align-items-center mb-2">
            <div class="col-auto">
                <div class="" id="datepicker1">
                    <input type="text" value="{{ date('Y-m-d') }}" id="dateSearch"
                        class="form-control rounded-0 rounded-start text-start" placeholder="วันที่ค้นหา"
                        data-date-format="yyyy-mm-dd" data-date-container="#datepicker1"
                        data-provide="datepicker" data-date-disable-touch-keyboard="true"
                        data-date-language="th" data-date-today-highlight="true"
                        data-date-enable-on-readonly="true" data-date-clear-btn="true"
                        autocomplete="off" data-date-autoclose="true" required>
                </div>
            </div>
            <div class="col-auto">
                <button type="button" id="searchInt" class="btn btn-primary">ค้นหา</button>
            </div>
        </div>

        <div id="contentlaod" style="display: none;">
            <table class="table  table-bordered table-hover table-head-fixed text-nowrap font-size-11" id="tbl_overdue">
                <thead class="table-warning sticky-top" style="line-height: 130%;">
                    <tr>
                        <th scope="col" class="text-center">งวดที่</th>
                        <th scope="col" class="text-center">วันครบกำหนด</th>
                        <th scope="col" class="text-center">ค่างวด</th>
                        <th scope="col" class="text-center">ดอกเบี้ย</th>
                        <th scope="col" class="text-center">เงินต้น</th>
                        <th scope="col" class="text-center">วันที่ชำระ</th>
                        <th scope="col" class="text-center">ชำระงวดนี้</th>
                        <th scope="col" class="text-center">วันล่าช้า</th>
                        <th scope="col" class="text-center">ดอกเบี้ย</th>
                    </tr>
                </thead>
                <tbody class="font-size-11 placeholder-glow">

                    @for($i=0;$i<8;$i++)
                    <tr>
                        <td scope="col" class="text-center"><span class="placeholder col-8"></span></td>
                        <td scope="col" class="text-center"><span class="placeholder col-8"></span></td>
                        <td scope="col" class="text-center"><span class="placeholder col-8"></span></td>
                        <td scope="col" class="text-center"><span class="placeholder col-8"></span></td>
                        <td scope="col" class="text-center"><span class="placeholder col-8"></span></td>
                        <td scope="col" class="text-center"><span class="placeholder col-8"></span></td>
                        <td scope="col" class="text-center"><span class="placeholder col-8"></span></td>
                        <td scope="col" class="text-center"><span class="placeholder col-8"></span></td>
                        <td scope="col" class="text-center"><span class="placeholder col-8"></span></td>
                    </tr>
                    @endfor
                </tbody>
                {{-- <tfoot class="table-warning">
                    <tr>
                        <td scope="col" class="text-center"><span class="placeholder col-8"></span></td>
                        <td scope="col" class="text-center"><span class="placeholder col-8"></span></td>
                        <td scope="col" class="text-center"><span class="placeholder col-8"></span></td>
                        <td scope="col" class="text-center"><span class="placeholder col-8"></span></td>
                        <td scope="col" class="text-center"><span class="placeholder col-8"></span></td>
                        <td scope="col" class="text-center"><span class="placeholder col-8"></span></td>
                        <td scope="col" class="text-center"><span class="placeholder col-8"></span></td>
                        <td scope="col" class="text-center"><span class="placeholder col-8"></span></td>
                        <td scope="col" class="text-center"><span class="placeholder col-8"></span></td>
                    </tr>
                </tfoot> --}}

            </table>
        </div>

        <div id="content-tb">
            @include('backend.content-payments.section-create.TB-OVRDUE')
        </div>

	</div>
	<div class="modal-footer">
        <button class="btn btn-sm btn-secondary waves-effect waves-light w-sm hover-up close-modal" type="button" data-bs-dismiss="modal" aria-label="Close">ย้อนกลับ</button>
	</div>
</div>


<script>
    $('#searchInt').click(()=>{
        $('#searchInt').prop('disabled',true)
        $('#contentlaod').show()
        $('#content-tb').hide()

        let PatchCon_id = sessionStorage.getItem('PatchCon_id')
        let url = '{{ route('payments.show',':ID') }}'

        $.ajax({
            url : url.replace(':ID',PatchCon_id),
            type : 'GET',
            data : {
                FlagBtn : 'OVRDUE',
                func : 'search',
                date : $('#dateSearch').val(),
                CODLOAN : $('#CODLOAN').val(),
                CONTTYP : $('#CONTTYP').val(),
                _token : '{{ @CSRF_TOKEN() }}'
            },
            success : (res)=>{
                $('#searchInt').prop('disabled',false)
                $('#contentlaod').hide()
                $('#content-tb').show()


                $('#content-tb').html(res.html)
            },
            error : (err)=>{
                $('#searchInt').prop('disabled',false)
                $('#contentlaod').hide()
                $('#content-tb').show()

                alert('error !')

            }
        })
    })
</script>
