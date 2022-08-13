Chart.defaults.global.defaultFontFamily =
    '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = "#292b2c";

$(window).on("load", function () {
    $.ajax({
        url: "/chart/profits_chart",
        method: "get",
        dataType: "json",
        success: function (response) {
            console.log(response);

            var response_length = response["data"].length;
            var begin = new Date(response["six_month_ago"]);
            var end = new Date(response["now"]);

            month_list = [];
            montly_profit = [];

            var month_iterate = new Date(begin);

            while (month_iterate <= end) {
                is_get = false;
                let month = month_iterate.getMonth();

                for (let i = 0; i < response_length; i++) {
                    let month_selected = new Date(
                        response["data"][i]["date"]
                    ).getMonth();
                    if (month == month_selected) {
                        montly_profit.push(
                            parseInt(response["data"][i]["profits"])
                        );
                        is_get = true;
                    }
                }
                if (!is_get) {
                    montly_profit.push(0);
                }

                let m = month_iterate.toLocaleString("default", {
                    month: "long",
                });
                month_list.push(`${m}`);

                var newMonth = month_iterate.setMonth(
                    month_iterate.getMonth() + 1
                );
                newMonth = new Date(newMonth);
            }

            var ctx = document.getElementById("profits_chart");
            new Chart(ctx, {
                type: "bar",
                data: {
                    labels: month_list,
                    datasets: [
                        {
                            label: "Profit",
                            backgroundColor: "rgba(2,117,216,1)",
                            borderColor: "rgba(2,117,216,1)",
                            data: montly_profit,
                        },
                    ],
                },
                options: {
                    scales: {
                        xAxes: [
                            {
                                time: {
                                    unit: "month",
                                },
                                gridLines: {
                                    display: false,
                                },
                                ticks: {
                                    maxTicksLimit: 6,
                                },
                            },
                        ],
                        yAxes: [
                            {
                                ticks: {
                                    min:
                                        Math.min.apply(Math, montly_profit) < 0
                                            ? Math.min.apply(
                                                  Math,
                                                  montly_profit
                                              ) * 1.3
                                            : 0,
                                    max:
                                        Math.max.apply(Math, montly_profit) *
                                        1.3,
                                    maxTicksLimit: 8,
                                },
                                gridLines: {
                                    display: true,
                                },
                            },
                        ],
                    },
                    legend: {
                        display: false,
                    },
                },
            });
        },
    });
});
