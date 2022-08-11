import { previewImage } from "./image_preview.js";

// modal order detail
$("span.order-detail-link[title='order detail']").click(function (event) {
    setVisible("#loading", true);
    var id = $(this).attr("data-id");

    $.ajax({
        url: "/order/data/" + id,
        method: "get",
        dataType: "json",
        success: function (response) {
            const date = new Date(response["created_at"]).toLocaleDateString(
                "id-id",
                {
                    weekday: "long",
                    year: "numeric",
                    month: "short",
                    day: "numeric",
                }
            );

            $("#username_detail").html("@" + response["user"]["username"]);
            $("#order_date_detail").html(date);
            $("#quantiity_detail").html(response["quantity"]);
            $("#address_detail").html(response["address"]);
            $("#payment_method_detail").html(
                response["payment"]["payment_method"]
            );
            $("#status_detail").html(response["status"]["order_status"]);
            $("#style_status_detail")
                .removeClass()
                .addClass(
                    "spinner-grow spinner-grow-sm text-" +
                        response["status"]["style"]
                );
            $("#bank_detail").html(
                response["bank"] ? response["bank"]["bank_name"] : ""
            );
            $("#account_number_detail").html(
                response["bank"] ? response["bank"]["account_number"] : ""
            );
            $("#notes_transaction_detail").html(
                response["refusal_reason"]
                    ? response["refusal_reason"]
                    : response["note"]["order_notes"]
            );
            $("#total_price_detail").html(response["total_price"]);

            if (response["payment_id"] == 1) {
                $("#transaction_doc_detail").attr(
                    "src",
                    "/storage/" + response["transaction_doc"]
                );
            }

            $("#product_name_detail").html(response["product"]["product_name"]);
            $("#image_product_detail").attr(
                "src",
                "/storage/" + response["product"]["image"]
            );
            $("#link_bukti_transfer").attr("data-id", response["id"]);
            $("#form_cancel_order").attr(
                "action",
                "/order/cancel_order/" + response["id"]
            );

            // transfer proof url
            $("#link_transfer_proof").attr(
                "data-imageUrl",
                "/storage/" + response["transaction_doc"]
            );

            // reject order form
            $("#form_reject_order").attr(
                "action",
                "/order/reject_order/" +
                    response["id"] +
                    "/" +
                    response["product_id"]
            );

            // end order form
            $("#form_end_order").attr(
                "action",
                "/order/end_order/" +
                    response["id"] +
                    "/" +
                    response["product_id"]
            );

            // approve order form
            $("#form_approve_order").attr(
                "action",
                "/order/approve_order/" +
                    response["id"] +
                    "/" +
                    response["product_id"]
            );

            // edit order
            $("#link_edit_order").attr(
                "href",
                "/order/edit_order/" + response["id"]
            );

            if (response["coupon_used"] != null) {
                $("#content-kuponUsed").html(
                    `<span class="link-danger" style="cursor: pointer; ">` +
                        response["coupon_used"] +
                        ` kupon</span> digunakan untuk pemesanan ini`
                );
            } else {
                $("#content-kuponUsed").html(
                    `tidak ada kupon yang digunakan untuk pemesanan ini`
                );
            }

            // restrict proof of transfer for COD payment method
            if (response["payment"]["payment_method"] == "COD") {
                // menghilangkan element sesuai metode pembayaran
                $("#modal_section_payment_proof").css("display", "none");
                $("#row_bank").css("display", "none");
            } else {
                // to restore undisplayed elements
                $("#modal_section_payment_proof").css("display", "unset");
                $("#row_bank").css("display", "table-row");
            }

            // if order has been canceled by user
            if (response["status_id"] == 5) {
                console.log("benerkah");
                $("#link_edit_order > button").css("display", "none");
                $("#form_cancel_order > button").css("display", "none");
                $("#message").css("display", "unset");
                $("#message").html("Order has been canceled by user");
            } else if (response["status_id"] == 3) {
                // if order has been rejected by admin
                $("#link_edit_order").css("display", "none");
                $("#form_cancel_order").css("display", "none");
                $("#message").css("display", "unset");
                $("#message").html("Order has been rejected by admin");
            } else {
                // to restore undisplayed elements
                $("#link_edit_order > button").css("display", "unset");
                $("#form_cancel_order > button").css("display", "unset");
                $("#message").css("display", "none");
            }

            // considered the listener on reject order
            $("#message_reject_order").css("display", "none");
            $("#message_reject_order").html();

            $("#OrderDetailModal").modal("show");
            setVisible("#loading", false);
        },
    });
});

const setVisible = (elementOrSelector, visible) =>
    ((typeof elementOrSelector === "string"
        ? document.querySelector(elementOrSelector)
        : elementOrSelector
    ).style.display = visible ? "block" : "none");

$("a.uploadProof[title='Upload Transfer Proof']").click(function (event) {
    setVisible("#loading", true);
    var id = $(this).attr("data-id");

    $.ajax({
        url: "/order/getProof/" + id,
        method: "get",
        dataType: "json",
        success: function (response) {
            $("#form_upload_proof").attr(
                "action",
                "/order/upload_proof/" + response["id"]
            );
            $("#old_image_proof").val(
                "/storage/" + response["transaction_doc"]
            );

            $("#image_review_upload").attr(
                "src",
                response["transaction_doc"] !=
                    "proof/fmg7fWMmb7mNvnHHA70IlRXxRF4wsD9J6dQAUZkV.png"
                    ? "/storage/" + response["transaction_doc"]
                    : "/storage/" +
                          "proof/fmg7fWMmb7mNvnHHA70IlRXxRF4wsD9J6dQAUZkV.png"
            );
            $("#message_upload_proof").html(
                $("#image_review_upload").attr("src") !=
                    "/storage/proof/fmg7fWMmb7mNvnHHA70IlRXxRF4wsD9J6dQAUZkV.png"
                    ? "image selected"
                    : "no selected image"
            );

            if (response["status_id"] == "2") {
                $("#ProofUploadModal").modal("show");
            } else if (response["status_id"] != "4") {
                Swal.fire(
                    `Action denied, order is already ${
                        response["status"]["order_status"]
                    } by ${response["status_id"] != "5" ? "admin" : "you"}`
                );
            }

            setVisible("#loading", false);
        },
    });
});

$("#image_upload_proof").on("change", function () {
    previewImage({
        image: "image_upload_proof",
        image_preview: "image_review_upload",
        image_preview_alt: "transfer proof",
    });
});

$("#form_upload_proof").submit(function (event) {
    if (
        $("#old_image_proof").val() != $("#image_upload_proof").val() &&
        $("#image_upload_proof").val() != ""
    ) {
        return;
    }

    $("#message_upload_proof").html("Please select an image");
    $("#message_upload_proof").css("color", "red");

    event.preventDefault();
});

$("#link_transfer_proof").click(function () {
    Swal.fire({
        title: "Transfer Proof",
        imageUrl: $("#link_transfer_proof").attr("data-imageUrl"),
        imageWidth: 600,
        imageHeight: 350,
        imageAlt: "Transfer Proof",
    });
});

// cancel order [customer]
$("#button_cancel_order").click(function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Are you sure?",
        text: "after this process, this order is no longer valid and can't be change",
        icon: "question",
        confirmButtonText: "Confirm",
        cancelButtonColor: "#d33",
        showCancelButton: true,
        confirmButtonColor: "#08a10b",
        timer: 10000,
    }).then((result) => {
        if (result.isConfirmed) {
            setVisible("#loading", true);
            $("#OrderDetailModal").modal("hide");

            $("#form_cancel_order").submit();
        } else if (result.isDismissed) {
            Swal.fire("Action canceled", "", "info");
        }
    });
});

// approve order [admin]
$("#button_approve_order").click(function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Are you sure?",
        text: "the order will be considered valid and ready to be handed over to the customer",
        icon: "question",
        confirmButtonText: "Confirm",
        cancelButtonColor: "#d33",
        showCancelButton: true,
        confirmButtonColor: "#08a10b",
        timer: 10000,
    }).then((result) => {
        if (result.isConfirmed) {
            setVisible("#loading", true);
            $("#OrderDetailModal").modal("hide");

            $("#form_approve_order").submit();
        } else if (result.isDismissed) {
            Swal.fire("Action canceled", "", "info");
        }
    });
});

// end order [admin]
$("#button_end_order").click(function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Are you sure?",
        text: "after the order is completed, this data will be considered as company income",
        icon: "question",
        confirmButtonText: "Confirm",
        cancelButtonColor: "#d33",
        showCancelButton: true,
        confirmButtonColor: "#08a10b",
        timer: 10000,
    }).then((result) => {
        if (result.isConfirmed) {
            setVisible("#loading", true);
            $("#OrderDetailModal").modal("hide");

            $("#form_end_order").submit();
        } else if (result.isDismissed) {
            Swal.fire("Action canceled", "", "info");
        }
    });
});

// reject order [admin]
$("#button_reject_order").click(function (e) {
    e.preventDefault();

    if ($("#refusal_reason").val() == "") {
        console.log("hms");
        $("#message_reject_order").html("Refusal reason cannot be empty");
        $("#message_reject_order").css("display", "unset");
        return;
    }

    Swal.fire({
        title: "Are you sure?",
        text: "after this process, this order is no longer valid and can't be change",
        icon: "question",
        confirmButtonText: "Confirm",
        cancelButtonColor: "#d33",
        showCancelButton: true,
        confirmButtonColor: "#08a10b",
        timer: 10000,
    }).then((result) => {
        if (result.isConfirmed) {
            setVisible("#loading", true);
            $("#ModalRejectOrder").modal("hide");

            $("#form_reject_order").submit();
        } else if (result.isDismissed) {
            Swal.fire("Action canceled", "", "info");
            $("#ModalRejectOrder").modal("hide");
            $("#OrderDetailModal").modal("show");
        }
    });
});
