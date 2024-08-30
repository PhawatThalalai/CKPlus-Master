{{-- <script>
    function calculatebtn() {
        let Vat = 0.07;
        let Cash_Car = parseFloat($('#Cash_Car').val().replace(/,/g, ''));
        let Timelack_Car = parseInt($('#Timelack_Car').val());
        let Timelack_CarYear = Timelack_Car / 12;
        let Interest_Car = parseFloat($('#Interest_Car').val()) / 100;

        // ดึงค่าของ Process_Car
        let Process_Car = parseFloat($('#Process_Car').val().replace(/,/g, '') || 0);
        let StatusProcess_Car = $('#StatusProcess_Car').val();

        // ตรวจสอบเงื่อนไขของ StatusProcess_Car
        if (StatusProcess_Car === 'yes') {
            Cash_Car += Process_Car; // ถ้า "yes" ให้นำ Process_Car มาบวกกับ Cash_Car
            console.log('ยอดจัดรวมค่าดำเนินการ:', Cash_Car); // แสดงยอดจัดรวมค่าดำเนินการ
        } else {
            Process_Car = 0; // ถ้าไม่ใช่ "yes" ให้ Process_Car เป็น 0
            console.log('ยอดจัด:', Cash_Car);
        }

        let ratePerYear = (Interest_Car * 12 * 100).toFixed(2);
        let sumOfRatePerYear = (Cash_Car * (ratePerYear / 100)).toFixed(2); // คำนวณดอกเบี้ยที่ต้องใช้ผ่อน
        let sumOfInstallment = (sumOfRatePerYear * Timelack_CarYear).toFixed(2); // คำนวณดอกเบี้ยที่ต้องจ่ายทั้งหมด
        let sumOfPayment = parseFloat(Cash_Car) + parseFloat(sumOfInstallment); // ยอดทั้งหมดที่ต้องจ่ายก่อนรวม VAT
        let sumOfPaymentWithVAT = (sumOfPayment * (1 + Vat)).toFixed(2); // ยอดทั้งหมดที่ต้องจ่ายรวม VAT
        let monthlyPayment = Math.ceil((sumOfPaymentWithVAT / Timelack_Car).toFixed(
        2)); // ค่างวดในแต่ละเดือนหลังรวม VAT


        console.log('จำนวนงวด:', Timelack_Car);
        console.log('อัตราดอกเบี้ยต่อปี:', ratePerYear);
        console.log('ดอกเบี้ยรายปี:', sumOfRatePerYear);
        console.log('จำนวนดอกเบี้ยที่ต้องจ่าย:', sumOfInstallment);
        console.log('ยอดทั้งหมดที่ต้องจ่าย:', sumOfPayment);
        console.log('ยอดทั้งหมดที่ต้องจ่าย (รวม VAT):', sumOfPaymentWithVAT);
        console.log('ค่างวดต่อเดือน (รวม VAT):', monthlyPayment);

        $('#InterestYear_Car').val(ratePerYear);
    }
</script> --}}
