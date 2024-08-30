<div class="modal-content">
	<div class="d-flex m-3 mb-0">
		<div class="flex-shrink-0 me-2">
			<img src="{{ asset('assets/images/gif/dividends.gif') }}" alt="report" class="avatar-sm" style="width:50px;height:50px">
		</div>
		<div class="flex-grow-1 overflow-hidden">
			<h5 class="text-primary fw-semibold">รายละเอียดการค้างชำระ (ใบแจ้งหนี้) </h5>
			<p class="text-muted mt-n1 fw-semibold font-size-12">เลขที่เอกสาร : {{ @$runBill }}</p>
			<p class="border-primary border-bottom mt-n2"></p>
		</div>
		<a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></a>
	</div>
	<div class="modal-body" style="">
		<div id="content-form">
			@include('backend.content-payments.section-create.form-invoice')
		</div>

		<div id="content-search"></div>

        <div id="content-pay" style="display: none;">
            @include('backend.content-payments.section-create.form-payments')
        </div>

	</div>
	<div class="modal-footer">
        <form id = "dataContract">
        <input type="hidden" value="{{ @$data->CODLOAN ?? @$contract->CODLOAN}}" name="CODLOAN" id="CODLOAN" class="CODLOAN">
        <input type="hidden" value="{{ @$data->PatchCon_id ?? @$contract->id }}" id="PatchCon_id" name="PatchCon_id">
        <input type="hidden" value="{{ @$data->PactCon_id ?? @$contract->DataPact_id}}" name="PactCon_id" id="PactCon_id">
        <input type="hidden" value="{{ @$data->LOCAT ?? @$contract->LOCAT }}" name="LOCAT">
        <input type="hidden" name="_token" value="{{ @CSRF_TOKEN() }}">

        </form>

		<div class="row">
			<div class="d-flex justify-content-end flex-wrap gap-2">
                {{-- <button type="button" id="" class="btn btn-sm btn-primary waves-effect waves-light w-sm hover-up btn-next" style="display:none;" disabled>ถัดไป</button> --}}

				<button type="button" id="btn-saveInvoice" class="btn btn-sm btn-success waves-effect waves-light w-sm hover-up" disabled>
					<span class="d-block d-sm-none"><i class="fas fa-download"></i></span>
					<span class="d-none d-sm-block">
						<i class="fas fa-download icon-save"></i> <span class="spinner-border spinner-border-sm spinner-save" style="display:none;"></span>
						บันทึก
					</span>
				</button>

                <button type="button" id="receivePay" class="btn btn-sm btn-success waves-effect waves-light w-sm hover-up" style="display:none;">
					<span class="d-block d-sm-none"><i class="fas fa-download"></i></span>
					<span class="d-none d-sm-block">
						<i class="fas fa-download icon-save"></i> <span class="spinner-border spinner-border-sm spinner-save" style="display:none;"></span>
						รับชำระ
					</span>
				</button>

                <button type="button" id="printInvoice" onclick="rpPayments({{ $contract->CODLOAN }})" class="btn btn-sm btn-secondary waves-effect waves-light w-sm hover-up" style="display:none;">
					<span class="d-block d-sm-none"><i class="fas fa-download"></i></span>
					<span class="d-none d-sm-block">
						<i class="fas fa-download icon-save"></i> <span class="spinner-border spinner-border-sm spinner-save" style="display:none;"></span>
						พิมพ์ใบเสร็จ
					</span>
				</button>

				<button type="button" id="btn-back" class="btn btn-sm btn-danger waves-effect waves-light w-sm hover-up btn-back btn-DisplayDetail" style="display:none;">
					<span class="d-block d-sm-none"><i class="fas fa-share"></i></span>
					<span class="d-none d-sm-block">
						<i class="fas fa-share"></i>
						ย้อนกลับ
					</span>
				</button>

                <button type="button" id="btn-newInvoice" class="btn btn-sm btn-primary waves-effect waves-light w-sm hover-up" style="display:none;">
                    <span class="d-block d-sm-none"><i class="fas fa-download"></i></span>
                    <span class="d-none d-sm-block">
                        เพิ่มใหม่
                    </span>
                </button>


                <button type="button" id="btn-nextPage" class="btn btn-sm btn-primary waves-effect waves-light w-sm hover-up nextPage btn-next" style="display:none;" data-bs-toggle="modal" data-bs-target="#modal_xl" data-link="{{ route('payments.create') }}?funs={{ 'contentPaymentINV' }}&modalID={{ 'modal_xl_2' }}&PatchCon_id={{ @$contract->id }}">
                    <span class="d-block d-sm-none"><i class="fas fa-download"></i></span>
                    <span class="d-none d-sm-block">
                        ถัดไป
                    </span>
                </button>

                <div class="dropup btn-DisplayDetail">
					<button class="btn btn-sm btn-info waves-effect waves-light w-sm hover-up dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
						<i class="bx bx-list-ol"></i>
					</button>
					<ul class="dropdown-menu" style="z-index: 9999;">
						<li id="btn-print"><a class="dropdown-item" href="#" onclick="rpPayments({{ $contract->CODLOAN }})"><i class="fa fa-print"></i> พิมพ์</a></li>
						<li ><a class="dropdown-item " id="search-inv" data-bs-toggle="modal" data-bs-target="#modal_xl" data-link="{{ route('payments.show',@$data->PactCon_id ?? @$contract->DataPact_id) }}?FlagBtn={{ 'getHistoryInvoice' }}&modalID={{ 'modal_xl_2' }}" style="cursor: pointer;"><i class="fa fa-search"></i> สอบถาม</a></li>
					</ul>
				</div>

				<button type="button" id="btn-close" class="btn btn-sm btn-secondary waves-effect waves-light w-sm hover-up" data-bs-dismiss="modal" aria-label="Close">
					<span class="d-block d-sm-none"><i class="mdi mdi-close-circle-outline"></i></span>
					<span class="d-none d-sm-block">
						<i class="mdi mdi-close-circle-outline"></i>
						ปิด
					</span>
				</button>
			</div>
		</div>
	</div>
</div>

    <script>
        $(document).on('click', '#btn-nextPage', function(e) {
			$(".loading-overlay").attr('style', ''); //** แสดงตัวโหลด **
            e.preventDefault();
            var url = $(this).attr('data-link');
            let ContentTBINS = $('#ContentTBINS').html()
            $('#modal_xl .modal-dialog').empty();
            $('#modal_xl .modal-dialog').load(url, function(response, status, xhr) {
                if (status === 'success') {
                    $('#modal_xl').modal('show');
                    $("#ContentTBINS").html(ContentTBINS)
					$(".loading-overlay").attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **

                } else {
                    // console.log('Load failed');
                }
            });
        });

    </script>



    {{-- เพิ่มใบแจ้งหนี้ใหม่ --}}
    <script>
        $('#btn-newInvoice').click(()=>{
            $.ajax({
                url : '{{ route('payments.show',0) }}',
                type : 'GET',
                data : {
                    FlagBtn : 'newINV',
                    CODLOAN : $('#CODLOAN').val(),
                    id :$('#PatchCon_id').val(),
                    _token : '{{ @CSRF_TOKEN() }}'
                },
                success : (res) => {

			        $('#form-invoice input[type="text"],input[type="number"],.btn-blocked-operate').prop('disabled', true)
                    $('#content-form').html(res.html);
                    $('.btn-DisplayDetail').show()
                    $('#btn-saveInvoice').show()
					$("#btn-newInvoice,#btn-back,.btn-next").hide()
                    $('.content-PayOther').empty()

                },
                error : (err) => {

                }
            })
        })

    </script>

	<script>
		$(document).ready(function() {
            sessionStorage.removeItem('SSinput');
			$('#tb-invoice').DataTable();
			$('#form-invoice input[type="text"],input[type="number"],.btn-blocked-operate').prop('disabled', true)
			$('#formStyle').addClass('opacity-50');
		})

	</script>



    {{-- บันทึกใบแจ้งหนี้  --}}
	<script>
		$('#btn-saveInvoice').click(() => {
            let PatchCon_id = $('#PatchCon_id').val()
			let dataform = $('#form-invoice');
            let dataContract = $('#dataContract');
            let dataPayments = $('#form-payments');
			let validate = validateForms(dataform);
            let INPUTPAY = $('#INPUTPAY').val()

			if (validate == true) {
                let DataCus_id = sessionStorage.getItem('DataCus_id')
                $("#DataCus_id").val(DataCus_id)
				$('#btn-saveInvoice').prop('disabled', true)
				let data = dataform.serialize() + '&' + dataContract.serialize()
				$('.icon-save').toggle()
				$('.spinner-save').toggle()
				$.ajax({
					url: '{{ route('payments.store') }}',
					type: 'POST',
					data: data,
					success: (res) => {
                        $('#id_invoice').val(res.id)
                        $('#paymentPatch').val(PatchCon_id)

                        sessionStorage.setItem('TOTBLC',INPUTPAY)
						$('#content-search').html(res.html);
						$('#statInvoice').val(res.statInvoice);
                        $('#totblc').val(res.TOTBLC);
                        $('.btn-next').show().prop('disabled',false)
                        $('#btn-saveInvoice').hide()
                        $('#btn-newInvoice').show()
                        $('.btn-DisplayDetail').hide()
                        $('#form-invoice input[type="text"],input[type="number"],.btn-blocked').prop('disabled', true)
                        $('.elementCal').hide()
						swal.fire({
							icon: 'success',
							title: 'สำเร็จ !',
                            text : 'เพิ่มใบแจ้งหนี้เรียบร้อย',
							timer: 2000
						})
                        $('#content-search').hide()

					},
					error: (err) => {
						swal.fire({
							icon: 'error',
							title: 'ERROR !',
							timer: 2000
						})
					},
					complete: () => {
						$('#btn-saveInvoice').prop('disabled', false)
						$('.icon-save').toggle()
						$('.spinner-save').toggle()
                        // $('.modal').modal('hide')
					}
				})
			}
		})
	</script>

	<script>
		function rpPayments(codloan) {
            let reportArr = sessionStorage.getItem("reportArr")
			let id = $('#print_payments').attr('data-mas_id');
			let url = `{{ route('report-backend.show', 'id') }}?codloan=${codloan}&page=rp-transferPay&reportArr=${reportArr}`;
			url = url.replace('id', id);

			let newWindow = window.open(url, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=400,name=ใบเสร็จรับเงิน");
			let flag_pt = "{{ session()->put('flag_pt', 'active') }}";

			if (newWindow) {
				let browserWidth = window.innerWidth || document.documentElement.clientWidth || document.body.clientWidth;
				let browserHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;

				window.blur(); // ล่วงหน้าต่างของเบราว์เซอร์

				newWindow.focus(); // กลับมาโฟกัสที่หน้าต่าง Modal
				newWindow.resizeTo(browserWidth, browserHeight);

                $('.modal').modal('hide')
			}
		}
	</script>



	{{-- validate js --}}
	<script>
		function validateForms(dataform) {
			var isvalid = false;
			Array.prototype.slice.call(dataform).forEach(function(form) {
				if (!form.checkValidity()) {
					event.preventDefault();
					event.stopPropagation();

					form.classList.add('was-validated');

					isvalid = false;
				} else {
					isvalid = true;
				}
			});
			return isvalid;
		}
	</script>



    {{-- กดปุ่มให้ส่วนลด --}}
    <script>
        $("#btn-discount").click(function () {
                let TOTPAY = parseFloat($('#TOTPAY').val())
                let DISCAROTH = parseFloat($('#DISCAROTH').val() || 0) // ส่วนลดลูกหนี้อื่น
                let sum = TOTPAY
                $('.calpayments').each(function(){
                    sum += parseFloat($(this).val()) || 0;
                });

                $("#btn-discount").text(function(i, text){
                    if(text.trim() == 'ดูส่วนลด'){
                        $('#discount-content').fadeIn(500)
                        $(this).removeClass('btn-outline-info')
                        $(this).addClass('btn-outline-danger')
                        $('#TOTBLC').val(sum)
                    }else{
                        $('#discount-content').fadeOut(500)
                        $(this).removeClass('btn-outline-danger')
                        $(this).addClass('btn-outline-info')
                    }
                    return text.trim() == "ดูส่วนลด" ? "ซ่อนส่วนลด" : "ดูส่วนลด";
                })
        });
    </script>

<script>
    $('#closeSerach').click(()=>{
        $('#modal_xl_2').modal('show')
    })
</script>


<script>
    $('#search-inv').click((e)=>{
		$(".loading-overlay").attr('style', ''); //** แสดงตัวโหลด **
        var url = $(e.currentTarget).attr('data-link');
        $('#modal_xl .modal-dialog').empty();
        $('#modal_xl .modal-dialog').load(url, function(response, status, xhr) {
            if (status === 'success') {
				$(".loading-overlay").attr('style', 'display:none !important'); // ** ซ่อนตัวโหลด **
                $('#modal_xl').modal('show');
            } else {
                // console.log('Load failed');
            }
        });
    });
</script>


