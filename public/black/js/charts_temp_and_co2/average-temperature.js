async function getData(url) {
    try {
        console.log('processing data');
        let response = await fetch(url);
        let data = await response.json();
        console.log('data retrieved');
        return data;
    } catch (err) {
        console.error("Error: ", err);
    }
}

function initAverageTemperature() {
    console.log('debug');
    let roomTemperature;
    let datePicked;
    let room1;

    let chartAverageTemperature = document.getElementById('chartContainerAverageTemperature');
    let averageTempChart = new Chart(chartAverageTemperature, {
        type: "line",
        data: {
            labels: [],
            datasets: [
                {
                    label: "Average Temperature",
                    data: [],
                    borderWidth: 1,
                    borderColor: "rgb(53,89,153)",
                    backgroundColor: "rgba(53,89,153,0.4)",
                    fill: 'origin'
                }
            ]
        },
    });

    document.getElementById('start').addEventListener('change', function () {
        datePicked = document.getElementById('start').value;

        let averageTemperatureData = [];
        let averageTemperatureLabels = [];

        for (let i = 8; i < 18; i++) {
            let hourSum = 0;
            let count = 0;

            for (let j = 0; j < room1.length; j++) {
                const roomTime = room1[j]['dateAndTime']['time'];
                const temperature = room1[j]['temperature'];

                const hour = parseInt(roomTime.split(':')[0]);

                if (hour === i && checkWorkingTime(roomTime) && room1[j]['dateAndTime']['date'] === datePicked) {
                    hourSum += temperature;
                    count++;
                }
            }

            const averageTemperature = count > 0 ? hourSum / count : 0;
            averageTemperatureData.push(averageTemperature);
            averageTemperatureLabels.push(`${i}:00 - ${i + 1}:00`);
        }

        averageTempChart.data.labels = averageTemperatureLabels;
        averageTempChart.data.datasets[0].data = averageTemperatureData;
        averageTempChart.options.scales.y.min = Math.min(...averageTemperatureData) - 1;
        averageTempChart.options.scales.y.max = Math.max(...averageTemperatureData) + 1;
        averageTempChart.update();
    });

    async function loadData() {
        console.log('hello world');
        roomTemperature = await getData('/co2-and-temperature-data');
        room1 = roomTemperature[0]['roomTimes'];

        // Calculate average temperature for each time span and date
        let averageTemperatures = {};

        for (let i = 8; i < 18; i++) {
            let hourSum = 0;
            let count = 0;

            for (let j = 0; j < room1.length; j++) {
                const roomTime = room1[j]['dateAndTime']['time'];
                const temperature = room1[j]['temperature'];
                const roomDate = room1[j]['dateAndTime']['date'];

                const hour = parseInt(roomTime.split(':')[0]);

                if (hour === i && checkWorkingTime(roomTime) && roomDate === datePicked) {
                    hourSum += temperature;
                    count++;
                }
            }

            const averageTemperature = count > 0 ? hourSum / count : 0;
            averageTemperatures[i] = averageTemperature;
        }

        // Display average temperature for each time span and date
        for (let hour in averageTemperatures) {
            console.log(`Average temperature for ${hour}:00 - ${parseInt(hour) + 1}:00: ${averageTemperatures[hour]}`);
        }
    }

    loadData();
}

function getMinuteFromTime(time) {
    return parseInt(time.split(':')[1]);
}

function checkWorkingTime(time) {
    let hour = parseInt(time.split(':')[0]);
    let minute = parseInt(time.split(':')[1]);

    if ((hour >= 8 && hour < 18) || (hour === 18 && minute === 0)) {
        return true;
    } else {
        return false;
    }
}

window.addEventListener('load', initAverageTemperature);
