<script>
    import * as CanvasJS from "chart.js";

    window.addEventListener("load",function(){
        var chartMinTemp = new CanvasJS.Chart("chartContainerMinTemp", {
            theme: "dark2",
            animationEnabled: true,
            zoomEnabled: true,
            backgroundColor: "transparent",
            fontFamily: "roboto",
            data: [{
                type: "area",
                dataPoints: <?php echo json_encode($dataPointsMinTemp, JSON_NUMERIC_CHECK); ?>,
                xValueType: "dateTime"
            }],
            toolTip: {
                content: "{hour}:{minute} | {y} ppm"
            },
            axisX: {
                valueFormatString: "HH:mm"
            }
        });
        chartMinTemp.render();
    },false);
</script>
