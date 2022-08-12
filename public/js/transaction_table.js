window.addEventListener("DOMContentLoaded", (event) => {
    $("#transaction_table").dataTable({
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
