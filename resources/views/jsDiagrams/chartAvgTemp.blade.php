<script>
    import * as CanvasJS from "chart.js";

    window.addEventListener("load", function() {
        var chartAvgTemp = new CanvasJS.Chart("chartContainerAvgTemp", {
            theme: "dark2",
            animationEnabled: true,
            zoomEnabled: true,
            backgroundColor: "transparent",
            fontFamily: "roboto",
            data: [{
                type: "area",
                dataPoints: <?php echo json_encode($dataPointsAvgTemp, JSON_NUMERIC_CHECK); ?>,
                xValueType: "dateTime"
            }],
            toolTip: {
                content: "{x} | {y} °C"
            },
            axisX: {
                valueFormatString: "HH"
            }
        });
        chartAvgTemp.render();
    }, false);
</script>
