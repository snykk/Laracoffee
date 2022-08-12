var ratingNow;

function isClickStar(ratingN) {
    ratingNow = ratingN;
    console.log(ratingNow);
}

const setVisible = (elementOrSelector, visible) =>
    ((typeof elementOrSelector === "string"
        ? document.querySelector(elementOrSelector)
        : elementOrSelector
    ).style.display = visible ? "block" : "none");

$(".link_edit_review").click(function (e) {
    var id = $(this).attr("data-idReview");

    setVisible("#loading", true);

    $.ajax({
        url: "/review/data/" + id,
        method: "get",
        dataType: "json",
        success: function (response) {
            ratingNow = parseInt(response["rating"]);
            $("#message_edit_review").html("");

            $("#form_edit_review").attr(
                "action",
                "/review/edit_review/" + response["id"]
            );

            $("#review_edit").attr("data-oldRating", response["rating"]);
            $("#review_edit").attr("data-oldReview", response["review"]);

            $("#review_edit").val(response["review"]);
            $("input[type=radio][value=" + response["rating"] + "]").prop(
                "checked",
                true
            );

            $("#EditReviewModal").modal("show");
            setVisible("#loading", false);
        },
    });
});

$("#form_edit_review").submit(function (event) {
    if ($("#review_edit").val() == "") {
        $("#message_edit_review").html("Review field can not be empty!");

        event.preventDefault();
    } else if (
        parseInt($("#review_edit").attr("data-oldRating")) == ratingNow &&
        $("#review_edit").attr("data-oldReview") == $("#review_edit").val()
    ) {
        console.log(ratingNow);

        $("#message_edit_review").html("No changes detected");

        event.preventDefault();
    }

    return;
});

// delete review [customer]
$("#button_delete_review").click(function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Are you sure?",
        text: "your review will be deleted",
        icon: "question",
        confirmButtonText: "Confirm",
        cancelButtonColor: "#d33",
        showCancelButton: true,
        confirmButtonColor: "#08a10b",
        timer: 10000,
    }).then((result) => {
        if (result.isConfirmed) {
            $("#form_delete_review").submit();
        } else if (result.isDismissed) {
            Swal.fire("Action canceled", "", "info");
        }
    });
});
