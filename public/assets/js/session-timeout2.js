// var token = $("input[name='_token']").val();
// $.sessionTimeout({
//     keepAliveUrl: "homeside",
//     logoutButton: "Logout",
//     logoutUrl: "homeside",
//     redirUrl: "",
//     ajaxData: { _token: token },
//     warnAfter: 3e3,
//     redirAfter: 3e4,
//     countdownMessage: "Redirecting in {timer} seconds.",
// }),
//     $("#session-timeout-dialog  [data-dismiss=modal]").attr(
//         "data-bs-dismiss",
//         "modal"
//     );

var token = $("input[name='_token']").val();
$.sessionTimeout({
    keepAliveUrl: "homeside",
    logoutButton: "Logout",
    logoutUrl: "homeside",
    redirUrl: "", // ตรวจสอบ URL ที่ต้องการใช้งาน
    ajaxData: { _token: token },
    warnAfter: 3000, // ใช้ค่าเป็นมิลลิวินาที (3 วินาที)
    redirAfter: 30000, // ใช้ค่าเป็นมิลลิวินาที (30 วินาที)
    countdownMessage: "Redirecting in {timer} seconds.",
});

$("#session-timeout-dialog [data-dismiss=modal]").attr(
    "data-bs-dismiss",
    "modal"
);