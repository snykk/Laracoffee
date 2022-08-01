window.addEventListener("DOMContentLoaded", (event) => {
    $("#datatablesSimple").dataTable({
        oSearch: { sSearch: $("#username").val() },
        columnDefs: [
            { orderable: false, targets: 6 },
            { className: "dt-center", targets: "_all" },
        ],
        lengthMenu: [
            [5, 10, 25, 50, 100, -1],
            [5, 10, 25, 50, 100, "All"],
        ],
    });
});
