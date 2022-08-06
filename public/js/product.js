$("button.detail").click(function (event) {
    var id = $(this).attr("data-id");
    $.ajax({
        url: "/product/data/" + id,
        method: "get",
        dataType: "json",
        success: function (res) {
            $("#modal-image").attr("src", "/storage/" + res["image"]);
            $(".text-uppercase").html(res["product_name"]);
            $(".orientation").html(res["orientation"]);
            $(".description").html(res["description"]);
            $(".stock").html(
                "Available: " + "<em>" + res["stock"] + " unit" + "</em>"
            );
            if (res["discount"] == 0) {
                $(".price").html(
                    "Price: " + "<strong>Rp. " + res["price"] + "</strong>"
                );
                $(".discount").html(
                    "Discount: " +
                        "<em class='text-danger'>No discount available</em>"
                );
            } else {
                $(".price").html(
                    "Price: " +
                        "<strong class='me-2'>" +
                        ((100 - res["discount"]) / 100) * res["price"] +
                        "</strong>" +
                        "<strong class='strikethrough'>" +
                        res["price"] +
                        "</strong>"
                );
                $(".discount").html(
                    "Discount: " +
                        "<em class='text-danger'>" +
                        res["discount"] +
                        "%" +
                        "</em>"
                );
            }
        },
    });
});
