{{-- Check Expired date Card --}}
<script>
  $(function() {
    let checkExpired = $('#checkExpired').val();
    if(checkExpired == 'expired') {
      Swal.fire({
        icon: 'error',
        title: "บัตรประชาชนหมดอายุแล้ว !",
        text: "กรุณากตรวจสอบวันหมดอายุบัตรประชาชนอีกครั้ง !",
      })
    }
  });
</script>