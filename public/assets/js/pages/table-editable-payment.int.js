/******/ (function() { // webpackBootstrap
var __webpack_exports__ = {};
/*!**************************************************!*\
  !*** ./resources/js/pages/table-editable.int.js ***!
  \**************************************************/
/*
Template Name: Skote - Admin & Dashboard Template
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: Table editable Init Js File
*/
// table edits table
$(function () {
  var pickers = {};
  $('.table-edits tr').editable({
    dropdowns: {
      gender: ['Male', 'Female']
    },
    edit: function edit(values) {
      $('#isActiveTable').val('true');
      $(".edit i", this).removeClass('fa-pencil-alt').addClass('fa-save').attr('title', 'Save');
    },
    save: function save(values) {
      $('#isActiveTable').val('false');
      $(".edit i", this).removeClass('fa-save').addClass('fa-pencil-alt').attr('title', 'Edit');
      
      var officer = $('#dic_officer').val();
      var payamtString = $(this).find('td.PAYAMT').html().replace(/,/g, '');
      var payamt = parseInt(payamtString);
      
      var dicintString = $(this).find('td.dicint').html();
      var dicint = dicintString ? parseInt(dicintString) : 0;

      if(dicint > officer) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'สิทธิ์ส่วนลดเกินกว่าที่ได้รับอนุมัติ กรุณาติดต่อผู้ที่เกี่ยวข้อง.',
        })

        $(this).find('td.dicint').empty().text('');
        return false;
      }

      if (dicint > payamt) {
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'ส่วนลดไม่ถูกต้อง ไม่สามารถให้ส่วนลดเกินยอดชำระได้.',
        })

        $(this).find('td.dicint').empty().text('');
        return false;
      }
     
      if (this in pickers) {
        pickers[this].destroy();
        delete pickers[this];
      }
    },
    cancel: function cancel(values) {
      $(".edit i", this).removeClass('fa-save').addClass('fa-pencil-alt').attr('title', 'Edit');

      if (this in pickers) {
        pickers[this].destroy();
        delete pickers[this];
      }
    }
  });
});
/******/ })()
;