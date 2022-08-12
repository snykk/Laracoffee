window.addEventListener("DOMContentLoaded", (event) => {
    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector("#sidebarToggle");
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        if (localStorage.getItem("sb|sidebar-toggle") == "true") {
            document.body.classList.toggle("sb-sidenav-toggled");
        }
        sidebarToggle.addEventListener("click", (event) => {
            event.preventDefault();
            document.body.classList.toggle("sb-sidenav-toggled");
            localStorage.setItem(
                "sb|sidebar-toggle",
                document.body.classList.contains("sb-sidenav-toggled")
            );
        });
    }
});

// sweetalert 2
$("button.auth_logout").click(function (e) {
    e.preventDefault();
    const form = document.getElementById("form_auth_logout");

    Swal.fire({
        title: "Are you sure?",
        text: "click logout if you want to end your session",
        confirmButtonText: "Logout",
        cancelButtonColor: "#d33",
        showCancelButton: true,
        confirmButtonColor: "#08a10b",
        timer: 10000,
    }).then((result) => {
        if (result.isConfirmed) {
            let timerInterval;
            Swal.fire({
                title: "Auto close alert!",
                html: "I will close in <b></b> milliseconds.",
                timer: 1000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading();
                    const b = Swal.getHtmlContainer().querySelector("b");
                    timerInterval = setInterval(() => {
                        b.textContent = Swal.getTimerLeft();
                    }, 100);
                },
                willClose: () => {
                    clearInterval(timerInterval);
                },
            }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    form.submit();
                }
            });
        } else {
            Swal.fire("Failed, request timeout", "", "info");
        }
    });
});
