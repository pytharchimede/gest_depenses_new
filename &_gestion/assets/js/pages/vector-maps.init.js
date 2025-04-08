var worldemapmarkers = new jsVectorMap({
    map: "world_merc",
    selector: "#world-map-markers",
    zoomOnScroll: !1,
    zoomButtons: !1,
    selectedMarkers: [0, 2],
    markersSelectable: !0,
    markers: [
        { name: "Palestine", coords: [31.9474, 35.2272] },
        { name: "Russia", coords: [61.524, 105.3188] },
        { name: "Canada", coords: [56.1304, -106.3468] },
        { name: "Greenland", coords: [71.7069, -42.6043] },
    ],
    markerStyle: { initial: { fill: "#038edc" }, selected: { fill: "red" } },
    labels: {
        markers: {
            render: function (e) {
                return e.name;
            },
        },
    },
});
