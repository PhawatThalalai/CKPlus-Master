<script>
    let lastClickedTabButton = null;
    $(document).ready(function(){
        $(".nav-tab-contract-b-end a").click(function(){
            const currentClickedTabButton = $(this).attr('href');
            if ( currentClickedTabButton === lastClickedTabButton) {
                //console.log('คุณกำลังเปิดแท็บเดิม!');
                $('.nav-tab-contract-b-end a[href="#data_home"]').tab('show');
                lastClickedTabButton = "#data_home";
            } else {
                // Update the last clicked tab button variable
                lastClickedTabButton = currentClickedTabButton;
            }
        });
    });
</script>