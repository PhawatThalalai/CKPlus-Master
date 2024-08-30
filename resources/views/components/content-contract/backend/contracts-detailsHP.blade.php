<div class="card p-2">
    @if(true)
    <div class="col text-end">
        <div class="btn-group" data-bs-toggle="tooltip" title="เพิ่มเติม">
            <button type="button" id="btn-Payother" class="btn btn-soft-info btn-rounded chat-send waves-effect waves-light dropdown-toggle py-1" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bx bx-list-plus"></i>
            </button>
            <div class="dropdown-menu" style="cursor:pointer;">

                {{-- <button type="button" class="dropdown-item d-flex justify-content-start editContract_btn" href="#modal_editContract" data-link="{{ route('contracts.edit', @$data['DataPact_id'] )}}?CODLOAN=2&page=viewContract&funs=edit" role="button" data-bs-toggle="tooltip" title="เปลี่ยนแปลงสถานะสัญญา">
                    <i class="bx bx-edit-alt text-info fs-4"></i><span class="ms-2"> เปลี่ยนแปลงสถานะสัญญา</span>
                </button> --}}
                <button type="button" class="dropdown-item d-flex justify-content-start btn_printForm" data-id="{{@$data['DataPact_id']}}" data-bs-toggle="tooltip" title="ฟอร์มสัญญาเช่าซื้อ">
                    <i class="bx bx-receipt text-info fs-4"></i><span class="ms-2"> ฟอร์มสัญญาเช่าซื้อ</span>
                </button>
                <button type="button" class="dropdown-item d-flex justify-content-start btn_printFormGrant" data-id="{{@$data['DataPact_id']}}" data-bs-toggle="tooltip" title="ฟอร์มสัญญาค้ำประกัน">
                    <i class="bx bx-receipt text-info fs-4"></i><span class="ms-2"> ฟอร์มสัญญาค้ำประกัน</span>
                </button>
                <button type="button" class="dropdown-item data-modal-xl-2 d-flex justify-content-start">
                    <i class="bx bx-table text-info fs-4"></i><span class="ms-2"> ตารางแสดงยอดเบี้ยปรับ</span>
                </button>
            </div>
        </div>

    </div>
    @endif
        <div class="row mb-2">
            <div class="col border-end 1">
                <div class="table-responsive ">
                    <table class="table table-nowrap table-sm mb-0">
                        <tbody class="fs-6">
                            <tr >
                                <th scope="row">ราคาขาย :</th>
                                <td class="text-end">{{ @$data['SellingPrice'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">เงินดาวน์ :</th>
                                <td class="text-end">{{ @$data['NDAWN'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">เงินลงทุน :</th>
                                <td class="text-end">{{ @$data['Investment'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">งวดแรก :</th>
                                <td class="text-end">{{ @$data['FDATE'] }}</td>
                            </tr>

                            <tr>
                                <th scope="row">ค่างวด :</th>
                                <td class="text-end">{{ @$data['InstallmentsHP'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">ดอกเบี้ยต่อเดือน :</th>
                                <td class="text-end">{{ @$data['InterestHP'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">ผู้ตรวจสอบ :</th>
                                <td class="text-end">{{ @$data['inspector'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">วันที่เปลี่ยนสัญญา :</th>
                                <td class="text-end">{{ @$data['installments'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col border-end">
                <div class="table-responsive">
                    <table class="table table-nowrap table-sm mb-0">
                        <tbody class="fs-6">
                            <tr>
                                <th scope="row">ภาษีขาย :</th>
                                <td class="text-end">{{ @$data['SaleTax'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">ภาษีดาวน์ :</th>
                                <td class="text-end">{{ @$data['DownTax'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">จำนวนผ่อน :</th>
                                <td class="text-end">{{ @$data['T_NOPAY'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">งวดสุดท้าย :</th>
                                <td class="text-end">{{ @$data['LDATE'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">ภาษี :</th>
                                <td class="text-end">{{ @$data['TAX'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">ชำระเงินแล้ว :</th>
                                <td class="text-end">{{ @$data['PaidHP'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">พนักงานเก็บเงิน :</th>
                                <td class="text-end">{{ @$data['BILLCOLL'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">วันที่หยุด Vat :</th>
                                <td class="text-end">{{ @$data['DTSTOPV'] != NULL ? @$data['DTSTOPV'] : '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col border-end">
                <div class="table-responsive">
                    <table class="table table-nowrap table-sm mb-0">
                        <tbody class="fs-6">
                            <tr>
                                <th scope="row">ราคาขายรวม :</th>
                                <td class="text-end">{{ @$data['TOTPRC'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">เงินดาวน์รวม :</th>
                                <td class="text-end">{{ @$data['TOTDAWN'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">ดอกเบี้ย(%) :</th>
                                <td class="text-end">{{ @$data['interest_IRR'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">เบี้ยปรับ(%) :</th>
                                <td class="text-end">{{ @$data['INTLATE'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">รวมภาษี :</th>
                                <td class="text-end">{{ @$data['TOT_UPAY'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">ลูกหนี้คงเหลือ :</th>
                                <td class="text-end">{{ @$data['CAPITALBL'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">พนักงานขาย :</th>
                                <td class="text-end">{{ @$data['SalespersonHP'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">วันที่ทำสัญญา :</th>
                                <td class="text-end">{{ @$data['SDATE'] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</div>

<script>
	$(".btn_printForm").click(function(){
		let id = $(this).data('id');
		let getForm = 'HP_Cus';
		let url = "{{route('contracts.show', ':id')}}?page={{'print-contractform'}}&form={{':getForm'}}";
			url = url.replace(':id', id);
            url = url.replace(':getForm', getForm);
		window.open(url, "_blank","toolbar=yes,scrollbars=yes");

	});
    $(".btn_printFormGrant").click(function(){
		let id = $(this).data('id');
		let getForm = 'HP_Grant';
		let url = "{{route('contracts.show', ':id')}}?page={{'print-contractform'}}&form={{':getForm'}}";
			url = url.replace(':id', id);
            url = url.replace(':getForm', getForm);
		window.open(url, "_blank","toolbar=yes,scrollbars=yes");

	});
</script>
