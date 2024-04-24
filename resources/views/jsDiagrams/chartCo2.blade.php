<script>
    window.addEventListener("load", function (event) {
        var chartCo2 = new CanvasJS.Chart("chartContainerCo2", {
            theme: "light1", // "light1", "light2", "dark1", "dark2"
            animationEnabled: true,
            zoomEnabled: true,
            backgroundColor: "transparent",
            fontFamily: "roboto",
            data: [{
                type: "area",
                dataPoints: <?php echo json_encode($dataPointsCo2, JSON_NUMERIC_CHECK); ?>,
                xValueType: "dateTime"
            }],
            toolTip: {
                content: "{hour}:{minute} | {y} ppm"
            },
            axisX: {
                valueFormatString: "HH:mm"
            }
        });
        chartCo2.render();
    }, false);
</script>