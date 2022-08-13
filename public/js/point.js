const setVisible = (elementOrSelector, visible) =>
    ((typeof elementOrSelector === "string"
        ? document.querySelector(elementOrSelector)
        : elementOrSelector
    ).style.display = visible ? "block" : "none");

// convert point
$("#button_convert_point").click(function (e) {
    e.preventDefault();
    const isValid = $(this).attr("data-isCanConvert");
    console.log($(this).attr("data-isCanConvert"));
    console.log(isValid == "true");

    if (isValid == "true") {
        Swal.fire({
            title: "Are you sure?",
            text: "after this process, your points will be converted as coupon",
            icon: "question",
            confirmButtonText: "Confirm",
            cancelButtonColor: "#d33",
            showCancelButton: true,
            confirmButtonColor: "#08a10b",
            timer: 5000,
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "Action is in progress",
                    showConfirmButton: false,
                    timer: 2000,
                }).then((_) => {
                    setVisible("#loading", true);
                    $("#form_convert_point").submit();
                });
            } else if (result.isDismissed) {
                Swal.fire("Action canceled", "", "info");
            }
        });
    } else {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Your points are not enough",
            text: "collect 50 points to get 1 coupon",
            showConfirmButton: false,
            timer: 2000,
        });
    }
});
