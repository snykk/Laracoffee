const setVisible = (elementOrSelector, visible) =>
    ((typeof elementOrSelector === "string"
        ? document.querySelector(elementOrSelector)
        : elementOrSelector
    ).style.display = visible ? "block" : "none");

var isUseCoupon = false;
var couponTotal;
var currentNum = 0;
var couponUsed = 0;

var quantity;

$(document).ready(function () {
    quantity = parseInt($("#quantity").val());
    price = parseInt($("#product_price").attr("data-truePrice"));
    sub_total = price * quantity;
    shipping = $("#total_price").val() - sub_total;

    $("#sub-total").val(sub_total);
    $("#sub-total").html(sub_total);

    $("#shipping").attr("data-shippingCost", shipping);
    $("#shipping").html(shipping);
});

function changeStatesCoupon() {
    isUseCoupon = !isUseCoupon;
}

// ================ order summary ==================
var sub_total;
var total;
var shipping;
// ===============================================

// counter order summary [buat ]
function myCounter() {
    var num = parseInt($("#quantity").val());
    var price = parseInt($("#product_price").attr("data-truePrice"));
    shipping = parseInt($("#shipping").attr("data-shippingCost"));

    if (quantity != null && product_id != null && destinasi != null) {
        setOngkir({ destination: destinasi, quantity: num });
    }

    if (isUseCoupon && couponTotal > 0 && currentNum < num) {
        // ketika user menggunakan coupon
        couponTotal = couponTotal - 1;
        couponUsed = couponUsed + 1;
    } else if (isUseCoupon && couponUsed > 0 && currentNum > num) {
        couponTotal = couponTotal + 1;
        couponUsed = couponUsed - 1;
    } else if (!isUseCoupon && couponUsed > 0) {
        couponTotal = couponTotal + 1;
        couponUsed = couponUsed - 1;
    }

    sub_total = price * (num - couponUsed);
    total = sub_total + shipping;

    $("#coupon").html(`${couponTotal} coupon`);
    $("#couponUsed").val(couponUsed);
    $("#couponUsedShow").html(`${couponUsed} coupon`);

    refresh_data({ sub_total: sub_total, total: total });
    currentNum = num;
}

function refresh_data({ sub_total = 0, shipping = 0, total = 0 }) {
    if (total >= 0) {
        $("#total_price").val(total);
        $("#total").html(total);
    }
    if (sub_total >= 0) {
        $("#sub-total").html(sub_total);
    }
    if (shipping >= 0) {
        $("#shipping").attr("data-shippingCost", shipping);
        $("#shipping").html(shipping);
    }
}

// ===================================  Ongkir  =======================================
// ==== DATA ====
var product_id;
var destinasi;

// ==============

function getLokasi() {
    $op = $("#province");

    $.getJSON("/shipping/province", function (data) {
        $.each(data, function (i, field) {
            $op.append(
                '<option value="' +
                    field.province_id +
                    '">' +
                    field.province +
                    "</option>"
            );
        });
    });
}

getLokasi();

$("#province").on("change", function (e) {
    e.preventDefault();
    var option = $("option:selected", this).val();
    $("#city option:gt(0)").remove();
    $("#kurir").val("");

    if (option === "") {
        alert("null");
        $("#city").prop("disabled", true);
        $("#kurir").prop("disabled", true);
    } else {
        $("#city").prop("disabled", false);
        getCity(option);
    }
});

var currentCity = "0";
$("#city").on("click", function (e) {
    console.log("hehe" + $(this).val());
    console.log("hehe" + currentCity);
    if ($(this).val() != currentCity) {
        console.log("jalanninh");
        currentCity = $(this).val();
        setCity();
    }
});

function setCity() {
    destinasi = $("#city").val();
    quantity = $("#quantity").val();

    setOngkir({
        destination: destinasi,
        quantity: quantity,
    });
}

function getCity(province_id) {
    var op = $("#city");

    $.getJSON("/shipping/city/" + province_id, function (data) {
        $.each(data, function (i, field) {
            op.append(
                '<option value="' +
                    field.city_id +
                    '">' +
                    field.type +
                    " " +
                    field.city_name +
                    "</option>"
            );
        });
    });
}

function setOngkir({
    origin = 42, // banyuwangi
    destination,
    quantity,
    courier = "jne",
}) {
    if (quantity == 0) {
        refresh_data({
            shipping: 0,
            sub_total: 0,
            total: 0,
        });

        return;
    }
    destination = parseInt(destination);
    quantity = parseInt(quantity);

    setVisible("#transaction", false);
    setVisible("#loading_transaction", true);
    console.log("jalan dahal");

    $.ajax({
        url: `/shipping/cost/${origin}/${destination}/${quantity}/${courier}`,
        method: "get",
        dataType: "json",
        success: function (data) {
            var city = $("#city option:selected");
            var province = $("#province option:selected");
            $("#shipping_address").val(city.html() + ", " + province.html());
            shipping = data[0]["costs"][0]["cost"][0]["value"];
            total = sub_total + shipping;
            refresh_data({
                shipping: shipping,
                sub_total: sub_total,
                total: total,
            });

            setVisible("#transaction", true);
            setVisible("#loading_transaction", false);
            console.log("end");
        },
    });
}

// cancel order
$("#button_edit_order").click(function (e) {
    e.preventDefault();
    Swal.fire({
        title: "Are you sure?",
        text: "order data will be changed",
        icon: "warning",
        confirmButtonText: "Confirm",
        cancelButtonColor: "#d33",
        showCancelButton: true,
        confirmButtonColor: "#08a10b",
        timer: 10000,
    }).then((result) => {
        if (result.isConfirmed) {
            $("#form_edit_order").submit();
        } else if (result.isDismissed) {
            Swal.fire("Action canceled", "", "info");
        }
    });
});
