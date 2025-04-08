var options5 = {
    series: [{ data: [10, 20, 15, 40, 20, 50, 70, 60, 90, 70, 110] }],
    chart: { type: "bar", height: 50, sparkline: { enabled: !0 } },
    plotOptions: { bar: { columnWidth: "50%" } },
    tooltip: {
        fixed: { enabled: !1 },
        y: {
            title: {
                formatter: function (e) {
                    return "";
                },
            },
        },
    },
    colors: ["#038edc"],
},
chart5 = new ApexCharts(document.querySelector("#sparkline-chart-1"), options5);
chart5.render();
var options = {
    series: [{ name: "Series A", data: [10, 90, 30, 60, 50, 90, 25, 55, 30, 40] }],
    chart: { height: 50, type: "area", sparkline: { enabled: !0 }, toolbar: { show: !1 } },
    dataLabels: { enabled: !1 },
    stroke: { curve: "smooth", width: 2 },
    fill: { type: "gradient", gradient: { shadeIntensity: 1, inverseColors: !1, opacityFrom: 0.45, opacityTo: 0.05, stops: [50, 100, 100, 100] } },
    colors: ["#038edc", "transparent"],
},
chart = new ApexCharts(document.querySelector("#sparkline-chart-2"), options);
chart.render();
options5 = {
series: [{ data: [40, 20, 30, 40, 20, 60, 55, 70, 95, 65, 110] }],
chart: { type: "bar", height: 50, sparkline: { enabled: !0 } },
plotOptions: { bar: { columnWidth: "50%" } },
tooltip: {
    fixed: { enabled: !1 },
    y: {
        title: {
            formatter: function (e) {
                return "";
            },
        },
    },
},
colors: ["#038edc"],
};


(chart5 = new ApexCharts(document.querySelector("#sparkline-chart-3"), options5)).render();
options = {
series: [{ name: "Series A", data: [10, 90, 30, 60, 50, 90, 25, 55, 30, 40] }],
chart: { height: 50, type: "area", sparkline: { enabled: !0 }, toolbar: { show: !1 } },
dataLabels: { enabled: !1 },
stroke: { curve: "smooth", width: 2 },
fill: { type: "gradient", gradient: { shadeIntensity: 1, inverseColors: !1, opacityFrom: 0.45, opacityTo: 0.05, stops: [50, 100, 100, 100] } },
colors: ["#038edc", "transparent"],
};


(chart = new ApexCharts(document.querySelector("#sparkline-chart-4"), options)).render();
options = {
chart: { height: 332, type: "line", stacked: !1, offsetY: -5, toolbar: { show: !1 } },
stroke: { width: [0, 0, 0, 1], curve: "smooth" },
plotOptions: { bar: { columnWidth: "30%" } },
colors: ["#5fd0f3", "#038edc", "#dfe2e6", "#51d28c"],
series: [
    { name: "Formations effectuées", type: "column", data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30] },
    { name: "Personnes formées", type: "column", data: [19, 8, 26, 21, 18, 36, 30, 28, 40, 39, 15] },
    { name: "Budget par personne", type: "area", data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43] },
    { name: "Formateurs", type: "line", data: [9, 11, 13, 12, 10, 8, 6, 9, 14, 17, 22] },
],
fill: { opacity: [0.85, 1, 0.25, 1], gradient: { inverseColors: !1, shade: "light", type: "vertical", opacityFrom: 0.85, opacityTo: 0.55, stops: [0, 100, 100, 100] } },
labels: ["01/01/2003", "02/01/2003", "03/01/2003", "04/01/2003", "05/01/2003", "06/01/2003", "07/01/2003", "08/01/2003", "09/01/2003", "10/01/2003", "11/01/2003"],
markers: { size: 0 },
xaxis: { type: "datetime" },
yaxis: { title: { text: "Analyse Financière", style: { fontWeight: 500 } } },
tooltip: {
    shared: !0,
    intersect: !1,
    y: {
        formatter: function (e) {
            return void 0 !== e ? e.toFixed(0) : e;
        },
    },
},
grid: { borderColor: "#f1f1f1", padding: { bottom: 15 } },
};
(chart = new ApexCharts(document.querySelector("#sales-analytics-chart"), options)).render();
