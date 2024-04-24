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

function initMaxTemperature() {
    console.log('debug');
    let roomTemperature;
    let datePicked;
    let room1;

    let chartMaxTemperature = document.getElementById('chartContainerMaxTemp');
    let maxTempChart = new Chart(chartMaxTemperature, {
        type: "line",
        data: {
            labels: [],
            datasets: [
                {
                    label: "Maximum Temperature",
                    data: [],
                    borderWidth: 1,
                    borderColor: "rgb(255,0,41)",
                    backgroundColor: "rgba(255,117,133,0.4)",
                    fill: 'origin'
                }
            ]
        },
    });

    document.getElementById('start').addEventListener('change', function () {
        datePicked = document.getElementById('start').value;

        let maxTemperatureData = [];
        let maxTemperatureLabels = [];

        for (let i = 8; i < 18; i++) {
            let hourMaxTemp = -Infinity;

            for (let j = 0; j < room1.length; j++) {
                const roomTime = room1[j]['dateAndTime']['time'];
                const temperature = room1[j]['temperature'];

                const hour = parseInt(roomTime.split(':')[0]);

                if (hour === i && checkWorkingTime(roomTime) && temperature > hourMaxTemp && room1[j]['dateAndTime']['date'] === datePicked) {
                    hourMaxTemp = temperature;
                }
            }

            maxTemperatureData.push(hourMaxTemp);
            maxTemperatureLabels.push(`${i}:00 - ${i + 1}:00`);
        }

        maxTempChart.data.labels = maxTemperatureLabels;
        maxTempChart.data.datasets[0].data = maxTemperatureData;
        maxTempChart.options.scales.y.min = Math.min(...maxTemperatureData) - 1;
        maxTempChart.options.scales.y.max = Math.max(...maxTemperatureData) + 1;
        maxTempChart.update();
    });

    async function loadData() {
        roomTemperature = await getData('/co2-and-temperature-data');
        room1 = roomTemperature[0]['roomTimes'];

        // Calculate maximum temperature for each time span and date
        let maxTemperatures = {};

        for (let i = 8; i < 18; i++) {
            let hourMaxTemp = -Infinity;

            for (let j = 0; j < room1.length; j++) {
                const roomTime = room1[j]['dateAndTime']['time'];
                const temperature = room1[j]['temperature'];
                const roomDate = room1[j]['dateAndTime']['date'];

                const hour = parseInt(roomTime.split(':')[0]);

                if (hour === i && temperature > hourMaxTemp && roomDate === datePicked) {
                    hourMaxTemp = temperature;
                }
            }

            maxTemperatures[i] = hourMaxTemp;
        }

        // Display maximum temperature for each time span and date
        for (let hour in maxTemperatures) {
            console.log(`Maximum temperature for ${hour}:00 - ${parseInt(hour) + 1}:00 on ${datePicked}: ${maxTemperatures[hour]}`);
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

    if ((hour >= 8 && hour <= 17) || (hour === 18 && minute === 0)) {
        return true;
    } else {
        return false;
    }
}

window.addEventListener('load', initMaxTemperature);
