<script>
    window.addEventListener("load", function (event) {
    window.addEventListener("load",function() {
        var chartTemperature = new CanvasJS.Chart("chartContainerTemperature", {
            theme: "dark2", // "light1", "light2", "dark1", "dark2"
            animationEnabled: true,
            zoomEnabled: true,
            backgroundColor: "transparent",
            fontFamily: "roboto",
            data: [{
                type: "area",
                dataPoints: <?php echo json_encode($dataPointsTemperature, JSON_NUMERIC_CHECK); ?>,
                xValueType: "dateTime"
            }],
            toolTip: {
                content: "{hour}:{minute} | {y} °C"
            },
            axisX: {
                valueFormatString: "HH:mm"
            }
        });
        chartTemperature.render();
    }, false);
</script>