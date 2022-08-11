import { previewImage } from "/js/image_preview.js";

$("button.detail").click(function (event) {
    var id = $(this).attr("data-id");
    setVisible("#loading", true);

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

            $("#ProductDetailModal").modal("show");
            setVisible("#loading", false);
        },
    });
});

const setVisible = (elementOrSelector, visible) =>
    ((typeof elementOrSelector === "string"
        ? document.querySelector(elementOrSelector)
        : elementOrSelector
    ).style.display = visible ? "block" : "none");

$("#image").on("change", function () {
    previewImage({
        image: "image",
        image_preview: "image-preview",
        image_preview_alt: "Product Image",
    });
});

// cancel order
$("#button_edit_product").click(function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Are you sure?",
        text: "after this process, product data will be changed",
        icon: "warning",
        confirmButtonText: "Confirm",
        cancelButtonColor: "#d33",
        showCancelButton: true,
        confirmButtonColor: "#08a10b",
        timer: 10000,
    }).then((result) => {
        if (result.isConfirmed) {
            $("#form_edit_product").submit();
        } else if (result.isDismissed) {
            Swal.fire("Action canceled", "", "info");
        }
    });
});
