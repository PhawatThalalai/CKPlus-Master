$(document).ready(function () {
    $(function () {
        $(".input-mask").inputmask();
        $('[data-bs-toggle="tooltip"]').tooltip();

        $('textarea').maxlength({
            alwaysShow: true,
            warningClass: "badge bg-info",
            limitReachedClass: "badge bg-danger"
        });
    });
    
    //*************** แจ้งเตือน *************//
    function blinker() {
        $('.prem').fadeOut(1500);
        $('.prem').fadeIn(1500);
    }
    setInterval(blinker, 1500);
});


// (function() {
//     var forms = document.querySelectorAll('.needs-validation');
//     Array.prototype.slice.call(forms)
//     .forEach(function(form) {
//         var submitBtn = form.querySelector('button[id="btn_editUser"]');
//         submitBtn.onclick = function(event) {
//             if (!form.checkValidity()) {
//                 event.preventDefault();
//                 event.stopPropagation();

//                 form.classList.add('was-validated');
//             }else{

//                 console.log(!form.checkValidity());

//             }
//         };
//     });
// })()
