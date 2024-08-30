/******/ (function () {
    // webpackBootstrap
    var __webpack_exports__ = {};
    /*!****************************************************!*\
  !*** ./resources/js/pages/session-timeout.init.js ***!
  \****************************************************/
    /*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Session Timeout Js File
*/
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
    });

    const currentPath = window.location.pathname;
    const baseUrl = window.location.origin;

    $.sessionTimeout({
        keepAliveUrl: null,
        // keepAliveUrl: baseUrl + currentPath, // ดึง path ปัจจุบัน
        logoutButton: "ออกจากระบบ",
        logoutUrl: "/logout", // ใช้ URL แบบตรงแทน
        // redirUrl: "/auth-lock-screen", // ใช้ URL แบบตรงแทน
        warnAfter: 300000, //300000
        redirAfter: 600000, //360000
        countdownMessage: "นับถอยหลัง ใน {timer}",
    });

    $("#session-timeout-dialog  [data-dismiss=modal]").attr(
        "data-bs-dismiss",
        "modal"
    );

    $(document).on("click", "#session-timeout-dialog-logout", function (event) {
        event.preventDefault();
        var form = $("<form>", {
            method: "POST",
            action: "/logout", // URL ที่ใช้สำหรับออกจากระบบ
        });

        form.append(
            $("<input>", {
                name: "_token",
                type: "hidden",
                value: $('meta[name="csrf-token"]').attr("content"),
            })
        );

        $("body").append(form);
        form.submit();
    });

    // Ensure the backdrop of the modal is always in front
    $(document).on("show.bs.modal", ".modal", function () {
        var zIndex = 1040 + 10 * $(".modal:visible").length;
        $(this).css("z-index", zIndex);
        setTimeout(function () {
            $(".modal-backdrop")
                .not(".modal-stack")
                .css("z-index", zIndex - 1)
                .addClass("modal-stack");
        }, 0);
    });

    /******/
})();
