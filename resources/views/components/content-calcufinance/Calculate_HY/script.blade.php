{{-- ready function --}}
<script>
    $(function() {
        let form = $('#form-Calculates').serializeArray();

        $('#text-alert').show();
        // โชว์ข้อความ กรุณากด enter
        var Cash_Car = document.getElementById("Cash_Car");

        Cash_Car.addEventListener("keypress", function(event) {
            $('#text-alert').show();
            $('#content-table').addClass("d-none");
            if (event.key === "Enter") {
                $('#content-table').removeClass("d-none");
                showRateTB()
                $('#text-alert').hide();
            }
        });



        // ลบแล้วโชว์ข้อความ กรุณากด enter
        Cash_Car.addEventListener("keydown", function(event) {
            if (event.keyCode == 8) {
                $('#content-table').addClass("d-none");
                $('#text-alert').show();
            }
        });

        // หลุดโฟกัส แล้วแสดงตารางคำนวณ
        Cash_Car.addEventListener("blur", function() {
            $('#content-table').removeClass("d-none");
            showRateTB()
            $('#text-alert').hide();
        });

        $('#modelAsset,#RateGears,#Vehicle_Model').on('change', () => {
            showLTV()
        })

        $('#AppraisalPrice').on('input', () => {
            let input = $('#AppraisalPrice').val()
            $('#RatePrices').val(input)

        })
        //show hide PA ในตาราง

        if ($('#Include_PA').val() == '' || $('#Include_PA').val() == 'no') {
            $('.show_PA').hide();
        }


        // คำนวน % LTV
        $('#Cash_Car,#AppraisalPrice').on('input', () => {
            let Cash_Car = $('#Cash_Car').val()
            let RatePrices = $('#RatePrices').val()
            let result = ((Cash_Car.replace(/,/g, '') / RatePrices.replace(/,/g, '')) * 100).toFixed(0)
            $('.ShowRateLTV').html(result)
            $('#LTVRate').val(result)
        })

        $('.TypeLoans').change(() => {
            let typeLoans = $('.TypeLoans').val()
            let CodeLoans = $('#CodeLoans').val()

            if (typeLoans == 'land') {
                $('#content-LTV').hide()
                $('#formAppraisalPrice').show()
                $('.AppraisalPrice-land').show()
                $('.AppraisalPrice-micro').hide()
                $('.land').prop('disabled', true)
            } else if (CodeLoans == 11) {
                $('#content-LTV').show()
                $('#formAppraisalPrice').show()
                $('.AppraisalPrice-land').hide()
                $('.AppraisalPrice-micro').show()

            } else {
                $('#content-LTV').show()
                $('#formAppraisalPrice').hide()
                $('.land').prop('disabled', false)
            }
        })

        $('.addOPR').change(() => {
            let getdataArr = sessionStorage.getItem('DataArr') // เรียก session
            dataArr = JSON.parse(getdataArr)
            let opr = $('.addOPR').val()
            let result = ''
            if (opr == 'yes') {
                result = DisplayTB(dataArr, 'no')
                $('#TB-Installment').html(result)
            } else {
                result = DisplayTB(dataArr, 'no')
                $('#TB-Installment').html(result)
            }
        })
    })
</script>

{{-- เรียกข้อมูลในตาราง --}}
<script>
    showRateTB = () => {
        let form = $('#form-Calculates').serializeArray();
        let Cash_Car = $('#Cash_Car').val();
        $("#StatusProcess_Car").prop("disabled", true);
        $("#Timelack_Car").prop("disabled", true);
        $("#Interest_Car").prop("disabled", true);
        $("#InterestYear_Car").prop("disabled", true);
        $("#Buy_PA").prop("disabled", true);
        $("#Include_PA").prop("disabled", true);
        $("#Promotions").prop("disabled", true);
        if (Cash_Car === '') {
            //
        } else {

            $.ajax({
                url: "{{ route('ControlCenter.SearchData') }}",
                type: 'POST',
                data: $('#form-Calculates').serialize(),
                success: (res) => {
                    clearInput('formFinance')
                    $('#content-table').html(res.html);
                    $("#StatusProcess_Car").prop("disabled", false);
                    $("#Timelack_Car").prop("disabled", false);
                    $("#Interest_Car").prop("disabled", false);
                    $("#InterestYear_Car").prop("disabled", false);
                    $("#Buy_PA").prop("disabled", false);
                    $("#Include_PA").prop("disabled", false);
                    $("#Promotions").prop("disabled", false);
                },
                error: (err) => {
                    $("#StatusProcess_Car").prop("disabled", false);
                    $("#Timelack_Car").prop("disabled", false);
                    $("#Interest_Car").prop("disabled", false);
                    $("#InterestYear_Car").prop("disabled", false);
                    $("#Buy_PA").prop("disabled", false);
                    $("#Include_PA").prop("disabled", false);
                    $("#Promotions").prop("disabled", false);
                }
            })

        }
    }
</script>

{{-- โชว์ LTV --}}
<script>
    showLTV = () => {
        var RateCartypes = $('select[name=RateCartypes]').val()
        var RateBrands = $('select[name=RateBrands]').val()
        var RateGroups = $('select[name=RateGroups]').val()
        var RateYears = $('#RateYears').val()
        var RateModals = $('select[name=RateModals]').val()
        var RateGears = $('select[name=RateGears]').val()
        let Type_Leasing = $('#CodeLoans').val()
        let RatePrices = $('#RatePrices').val()
        let idYear = $('#idYear').val()
        let Type_Customer = $('#SLType_Customer').val();
        let Credo_Score = $('#Credo_Score').val()
        let TypeAssetsPoss = $('#TypeAssetsPoss').val();
        let TypeAssetCode = $('option:selected', '#TypeAssetsPoss').attr('data-code');

        $('#content-LTV').html('')
        if (RatePrices != '') {
            $.ajax({
                url: "{{ route('ControlCenter.SearchData') }}",
                type: 'POST',
                data: {
                    funs: 'Interest-HYNK',
                    Flagtag: 1,
                    LTV: 'getLTV',
                    Type_Leasing: Type_Leasing,
                    RateCartypes: RateCartypes,
                    RatePrices: RatePrices,
                    Type_Customer: Type_Customer,
                    RateBrands: RateBrands,
                    RateGroups: RateGroups,
                    RateYears: RateYears,
                    RateModals: RateModals,
                    RateGears: RateGears,
                    idYear: idYear,
                    Credo_Score: Credo_Score,
                    TypeAssetsPoss: TypeAssetsPoss,
                    TypeAssetCode: TypeAssetCode,
                    _token: '{{ @csrf_token() }}'
                },
                success: (res) => {
                    $('#content-LTV').html(res.html)
                },
                error: (err) => {

                }
            })
        }
    }
</script>
{{-- บันทึกคำนวน --}}
<script>
    $('#save').click(function() {
        let Credo_Score = $('#Credo_Score').val()
        var dataform = document.querySelectorAll('#form-Calculates input:not([disabled]), #form-Calculates select:not([disabled])');
        var validate = validateForms(dataform);
        if (validate == true) {
            if(Credo_Score > 0){
                $('#Note_Credo').val('ใช้ Score คำนวณ')
            }else{
                $('#Note_Credo').val('ไม่ใช้ Score')
            }
            let _token = $('input[name="_token"]').val();
            let data = {};
            $('#form-Calculates').serializeArray().map(function(x) {
                data[x.name] = x.value;
            });
            $('.addSpin').empty();
            $('<span />', {
                class: "spinner-border spinner-border-sm",
                role: "status"
            }).appendTo(".addSpin");

            var flag = $('#flag').val();
            var Cal_id = $('#Cal_id').val();
            var Period_Rate = $('#Period_Rate input:not([disabled])').val();
            var type = 6;
            let sess = sessionStorage.getItem('element');
            if (Cal_id != "") {
                let link = "{{ route('ControlCenter.update', 'id') }}";
                var url = link.replace('id', Cal_id);
                var method = "put";
            } else {
                var url = "{{ route('ControlCenter.store') }}";
                var method = "post";
            }

            if (Period_Rate != '') {
                $('#save').prop('disabled', true);
                $.ajax({
                    url: url,
                    method: method,
                    data: {
                        _token: _token,
                        type: 6,
                        data: data
                    },

                    success: function(result) {
                        Swal.fire({
                            icon: 'success',
                            text: result.message,
                            showConfirmButton: false,
                            timer: 1500
                        });

                        if (sess == 'section-expens') {
                            $('#section-content').html(result.html);
                        }

                        $('#modal_xl_2').modal('hide');
                    },
                    error: function(err) {
                        $('#save').prop('disabled', false);
                        $('.addSpin').empty();
                        Swal.fire({
                            icon: 'error',
                            title: `ERROR ` + err.status + ` !!!`,
                            text: err.responseJSON.message,
                            showConfirmButton: true,
                        });

                        // $('#modal_xl_2').modal('hide');

                    }
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: "ข้อมูลไม่ถูกต้อง",
                    text: "โปรดตรวจสอบข้อมูลให้ครบถ้วนก่อนบันทึก. !",
                })
            }

        } else {
            swal.fire({
                icon: 'info',
                title: 'ข้อมูลไม่ครบ !',
                text: 'กรุณาตรวจสอบข้อมูลให้ครบถ้วนอีกครั้ง ก่อนทำการบันทึก'
            })
        }
    });

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
{{-- วันครอบครอง --}}
<script>
    countDateoccupy = (dateStart, dateEnd) => { //จำนวนวันครอบครอง
        date1 = new Date(dateStart);
        date2 = new Date(dateEnd);
        var one_day = 1000 * 60 * 60 * 24;
        var defDate = (date2.getTime() - date1.getTime()) / one_day;
        return defDate;
    }

    $("#DateInArea").on('change', () => { // นับจำนวนวันที่อยู่ในพื้นที่
        var dayOcc = countDateoccupy($("#DateInArea").val(), $("#todayOcc").val());
        $("#NumDateInArea").val((dayOcc / 365).toFixed(1));
    });

    $("#DateOccupiedcar").on('change', () => { // นับจำนวนวันที่ครอบครอง
        var dayOcc = countDateoccupy($("#DateOccupiedcar").val(), $("#todayOcc").val());
        $("#NumDateOccupiedcar").val(dayOcc);
    });
</script>

{{-- ตอนกดคำนวณ --}}
<script>
    $('#btn-cal').click(() => {
        getDataToInput()
    })
</script>
{{-- ตอนเลือกงวด --}}
<script>
    $('#Timelack_Car').change(() => {
        let Timelack_Car = $('#Timelack_Car').val()
        let getdataArr = sessionStorage.getItem('DataArr') // เรียก session
        dataArr = JSON.parse(getdataArr)
        let Datafilter = dataArr.filter(x => x.AddOPR.Installment === Timelack_Car)
        if (Datafilter != '') {
            $('#Interest_Car').val(Datafilter[0].AddOPR.Interest)
            $('#InterestYear_Car').val((Datafilter[0].AddOPR.Interest * 12).toFixed(2))
            $('.row-hilight').removeClass('fw-semibold bg-success text-light px-4')
            $('#row-' + Timelack_Car).addClass('fw-semibold bg-success text-light px-4')
            getDataToInput()
        } else {
            swal.fire({
                icon: 'info',
                title: 'จำนวนงวดไม่มีในตารางดอกเบี้ย',
                text: 'กรุณาตรวจสอบจำนวนงวดและเลือกรายการใหม่อีกครั้ง'
            })
            $('#Timelack_Car').val('').find('option :eq(0)').attr('selected', true)

        }


    })
</script>

{{-- ตอนเลือก รวม ไม่รวม PA --}}
<script>
    $('#Include_PA').change(() => {
        let getdataArr = sessionStorage.getItem('DataArr') // เรียก session
        dataArr = JSON.parse(getdataArr)
        let Include_PA = $('#Include_PA').val()


        // updateCashCarSession({Cash_Car: 654},'DataArr')
        result = DisplayTB(dataArr, Include_PA)

        $('#TB-Installment').html(result)
        getDataToInput()

        //show hide ยอดผ่อน + PA
        if (Include_PA == 'yes') {
            $('.show_PA').show();
            $('.show_diff').show();

        } else {
            $('.show_PA').hide();
            $('.show_diff').hide();

        }



    })
</script>

{{-- function ในระบบ --}}

{{-- DisplayTB --}}
<script>
    DisplayTB = (data, FlagPA) => {
        let html = ''
        let opr = $('.addOPR').val()
        let CashCar = 0;
        if (opr == 'yes') {
            for (let item of data) {
                if (FlagPA == 'yes') {
                    CashCar = parseFloat(item.AddOPR.Cash_Car) + parseFloat(item.AddOPR.Flag_InstallmentPA)
                } else {
                    CashCar = item.AddOPR.Cash_Car
                }
                html += `
                <tr id="row-${item.AddOPR.Installment}" class="row-hilight">
                    <th> ${item.AddOPR.Installment} </th>
                    <td> ${CashCar.toLocaleString()} </td>
                    <td> ${item.AddOPR.Interest} </td>
                    <th> ${item.AddOPR.Period.toLocaleString()} </th>
                    <th class="show_PA"> ${item.AddOPR.Period_PA.toLocaleString()} </th>
                    <td class="show_diff"> ${item.AddOPR.Period_PA - item.AddOPR.Period}</td>
                </tr>
                `;
            }
        } else {
            for (let item of data) {
                if (FlagPA == 'yes') {
                    CashCar = parseFloat(item.NonOPR.Cash_Car) + parseFloat(item.NonOPR.Flag_InstallmentPA)
                } else {
                    CashCar = item.NonOPR.Cash_Car
                }
                html += `
            <tr id="row-${item.NonOPR.Installment}" class="row-hilight">
                <th> ${item.NonOPR.Installment} </th>
                <td> ${CashCar.toLocaleString()} </td>
                <td> ${item.NonOPR.Interest} </td>
                <th> ${item.NonOPR.Period.toLocaleString()} </th>
                <th  class="show_PA"> ${item.NonOPR.Period_PA.toLocaleString()} </th>
                <td class="show_diff"> ${item.NonOPR.Period_PA - item.NonOPR.Period}</td>
            </tr>
            `;
            }
        }
        return html;
    }
</script>
{{-- clear input --}}
<script>
    clearInput = (form) => {
        $('#' + form + ' input[type=date]').val('')
        $('#' + form + ' .input-user').val('')
        $('#' + form + ' select').val('').find('option :eq(0)').attr('selected', true)
    }
</script>
{{-- เรียกข้อมูลในตารางค่างวด --}}

{{-- แสดงค่าใน input hidden --}}
<script>
    getDataToInput = () => {
        let Type_Leasing = $('#CodeLoans').val()
        let opr = $('.addOPR').val()
        let Timelack_Car = $('#Timelack_Car').val()
        let getdataArr = sessionStorage.getItem('DataArr') // เรียก session
        let Include_PA = $('#Include_PA').val()
        dataArr = JSON.parse(getdataArr)
        let Datafilter = dataArr.filter(x => x.AddOPR.Installment === Timelack_Car)
        let obj;
        if (opr.toLowerCase()  == 'yes') {
            let Datafilter = dataArr.filter(x => x.AddOPR.Installment === Timelack_Car)
            obj = Datafilter[0].AddOPR
        } else if(opr.toLowerCase() == 'notHas'){
            let Datafilter = dataArr.filter(x => x.NonOPR.Installment === Timelack_Car)
            obj = Datafilter[0].NotOPR
        } else {
            let Datafilter = dataArr.filter(x => x.NonOPR.Installment === Timelack_Car)
            obj = Datafilter[0].NonOPR
        }
        $('#Interest_Car').val(obj.Interest)
        $('#InterestYear_Car').val((obj.Interest * 12).toFixed(2))
        $('#row-' + Timelack_Car).removeClass('fw-semibold bg-success text-light px-4')
        $('#row-' + Timelack_Car).addClass('fw-semibold bg-success text-light px-4')

        profit_rate = parseFloat(obj.totalPeriod) - parseFloat(obj.Cash_Car)
        $('#Profit_Rate').val(profit_rate) //ดอกเบี้ย

        var vatLoan = ['01', '05', '07'];
        if (Include_PA == 'yes') {
            if (vatLoan.includes(Type_Leasing) == true) { //ถ้าเป็นเช่าซื้อ
                var Duerate = (parseFloat(obj.Period_PA) * 100) / 107; //ยอด no vat
                var Duerate2 = Duerate.toFixed(2) * Timelack_Car; //ยอดทั้งสัญญา no vat
                var Tax = parseFloat(obj.Period_PA) - parseFloat(Duerate); //ภาษีต่องวด
                var Tax2 = Tax.toFixed(2) * Timelack_Car; //ภาษีทั้งสัญญา
                var Profit = obj.totalPeriod - obj.Period_PA;
            } else { //ถ้าไม่เป็นเช่าซื้อ
                var Duerate = 0; //ยอด no vat
                var Duerate2 = 0; //ยอดทั้งสัญญา no vat
                var Tax = 0; //ภาษีต่องวด
                var Tax2 = 0; //ภาษีทั้งสัญญา
                var Profit = 0;
            }
            $("#Duerate_Rate").val(Duerate); // ค่างวดถอด Vat
            $("#Period_Rate").val(obj.Period_PA); // ค่างวดต่อเดือน
            $('#ShowPeriod').html(obj.Period_PA.toLocaleString())
            $('#ShowTotalPeriod').html(obj.totalPeriod_HasPA.toLocaleString())
            $("#SumTotalPeriod").val(obj.totalPeriod_HasPA); // ยอดทั้งสัญญา
            profit_rate = parseFloat(obj.totalPeriod_HasPA) - parseFloat(obj.Cash_Car) - parseFloat(obj
                .Flag_InstallmentPA) //ดอกผลทั้งหมด
            $('#Profit_Rate').val(profit_rate)

        } else {
            if (vatLoan.includes(Type_Leasing) == true) { //ถ้าเป็นเช่าซื้อ
                var Duerate = (parseFloat(obj.Period) * 100) / 107; //ยอด no vat
                var Duerate2 = Duerate.toFixed(2) * Timelack_Car; //ยอดทั้งสัญญา no vat
                var Tax = parseFloat(obj.Period) - parseFloat(Duerate); //ภาษีต่องวด
                var Tax2 = Tax.toFixed(2) * Timelack_Car; //ภาษีทั้งสัญญา
                var Profit = obj.totalPeriod - obj.Period;
            } else { //ถ้าไม่เป็นเช่าซื้อ
                var Duerate = 0; //ยอด no vat
                var Duerate2 = 0; //ยอดทั้งสัญญา no vat
                var Tax = 0; //ภาษีต่องวด
                var Tax2 = 0; //ภาษีทั้งสัญญา
                var Profit = 0;
            }

            $("#Duerate_Rate").val(Duerate); // ค่างวดถอด Vat
            $("#Period_Rate").val(obj.Period); // ค่างวดต่อเดือน

            $('#ShowPeriod').html(obj.Period.toLocaleString())
            $('#ShowTotalPeriod').html(obj.totalPeriod_NonPA.toLocaleString())
            $("#SumTotalPeriod").val(obj.totalPeriod_NonPA); // ยอดทั้งสัญญา
            profit_rate = parseFloat(obj.totalPeriod_NonPA) - parseFloat(obj.Cash_Car) //ดอกผลทั้งหมด
            $('#Profit_Rate').val(profit_rate)

        }

        $("#Tax_Rate").val((Tax.toFixed(2))); // ภาษี
        $("#Tax2_Rate").val((Tax2.toFixed(2))); // ระยะผ่อน-1
        $("#Duerate2_Rate").val((Duerate2.toFixed(2))); // ระยะผ่อน-2

        $('#Process_Car').val(obj.Flag_operate_fee.toLocaleString())
        $('#ShowOPR').html(obj.Flag_operate_fee.toLocaleString())

        $('#Insurance_PA').val(obj.Flag_InstallmentPA)
        $('.periodPAtotal').html(parseInt(obj.Flag_InstallmentPA).toLocaleString())
        $('#PlanID').val(obj.Plan)
        $('.showPlan_PA').html(obj.PlanId)

        $('.TimeLackPA').html(Timelack_Car / 12)
        $('.capital_PA').html(parseInt(obj.Limit_Insur).toLocaleString())

        $('#totalInterest_Car').val(obj.Interest) //ดอกเบี้ยรวม

        $('#Commissions').val(obj.Commission) // ค่าคอม
        $('#viewCommision').html(parseInt(obj.Commission).toLocaleString())
    }
</script>

<script>
    function updateCashCarSession(value, nameSS) {
        let data = JSON.parse(sessionStorage.getItem(nameSS));
        Object.keys(value).forEach(function(val, key) {
            data[0].AddOPR.Cash_Car = value[val];
        })
        sessionStorage.setItem(nameSS, JSON.stringify(data));
    }
</script>
