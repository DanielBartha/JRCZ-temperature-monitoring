<script>
    import * as CanvasJS from "chart.js";

    window.addEventListener("load", function() {
        var chartMaxTemp = new CanvasJS.Chart("chartContainerMaxTemp", {
            theme: "dark2",
            animationEnabled: true,
            zoomEnabled: true,
            backgroundColor: "transparent",
            fontFamily: "roboto",
            data: [{
                type: "area",
                dataPoints: <?php echo json_encode($dataPointsMaxTemp, JSON_NUMERIC_CHECK); ?>,
                xValueType: "dateTime"
            }],
            toolTip: {
                content: "{x} | {y} °C"
            },
            axisX: {
                valueFormatString: "HH"
            }
        });
        chartMaxTemp.render();
    },false);
</script>
