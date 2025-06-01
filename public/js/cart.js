/******/ (() => { // webpackBootstrap
/*!******************************!*\
  !*** ./resources/js/cart.js ***!
  \******************************/
(function ($) {
  $(".item-quantity").on("change", function () {
    $.ajax({
      url: "/cart/" + $(this).data("id"),
      method: "PUT",
      data: {
        quantity: $(this).val(),
        _token: csrf_token
      }
    });
  });
  $(".remove-item").on("click", function () {
    var id = $(this).data("id");
    $.ajax({
      url: "/cart/" + id,
      method: "DELETE",
      data: {
        _token: csrf_token
      },
      success: function success(response) {
        $("#".concat(id)).remove();
      }
    });
  });
})(jQuery);
/******/ })()
;