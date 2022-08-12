$(".button_edit_transaction").click(function () {
    var id = $(this).attr("data-transactionId");

    if ($(this).attr("data-isOutcome") == "0") {
        Swal.fire("Oops, you can not edit income data");
    } else {
        window.location = "/transaction/edit_outcome/" + id;
    }
});
