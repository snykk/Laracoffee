$("button.detail").click(function (event) {
    console.log("jalan");
    var id = $(this).attr("data-id");
    console.log(id);
    var url = "/product/:id";
    url = url.replace(":id", id);
    $.ajax({
        url: url,
        method: "get",
        dataType: "json",
        success: function (response) {
            $("#modal-image").attr("src", "/storage/" + response["image"]);
            $(".text-uppercase").html(response["product_name"]);
            $(".orientation").html(response["orientation"]);
            $(".description").html(response["description"]);
            $(".stock").html(
                "Available: " + "<em>" + response["stock"] + " unit" + "</em>"
            );
            if (response["discount"] == 0) {
                $(".price").html(
                    "Price: " + "<strong>Rp. " + response["price"] + "</strong>"
                );
                $(".discount").html(
                    "Discount: " +
                        "<em class='text-danger'>No discount available</em>"
                );
            } else {
                $(".price").html(
                    "Price: " +
                        "<strong class='me-2'>" +
                        ((100 - response["discount"]) / 100) *
                            response["price"] +
                        "</strong>" +
                        "<strong class='strikethrough'>" +
                        response["price"] +
                        "</strong>"
                );
                $(".discount").html(
                    "Discount: " +
                        "<em class='text-danger'>" +
                        response["discount"] +
                        "%" +
                        "</em>"
                );
            }
        },
    });
});
