(function ($) {
    $(".item-quantity").on("change", function () {
        $.ajax({
            url: "/cart/" + $(this).data("id"),
            method: "PUT",
            data: {
                quantity: $(this).val(),
                _token: csrf_token,
            },
        });
    });

    $(".remove-item").on("click", function () {
        let id = $(this).data("id");
        $.ajax({
            url: "/cart/" + id,
            method: "DELETE",
            data: {
                _token: csrf_token,
            },
            success: response => {
                $(`#${id}`).remove();
            },
        });
    });
})(jQuery);
