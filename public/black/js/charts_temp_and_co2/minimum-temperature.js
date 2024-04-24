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

function initMinTemperature() {
    let roomTemperature;
    let datePicked;
    let room1;

    let chartMinTemperature = document.getElementById('chartContainerMinTemp');
    let minTempChart = new Chart(chartMinTemperature, {
        type: "line",
        data: {
            labels: [],
            datasets: [
                {
                    label: "Minimum Temperature",
                    data: [],
                    borderWidth: 1,
                    borderColor: "rgb(0,176,255)",
                    backgroundColor: "rgba(110,185,252,0.4)",
                    fill: 'origin'
                }
            ]
        },
    });

    document.getElementById('start').addEventListener('change', function () {
        datePicked = document.getElementById('start').value;

        let minTemperatureData = [];
        let minTemperatureLabels = [];

        for (let i = 8; i < 18; i++) {
            let hourMinTemp = Infinity;

            for (let j = 0; j < room1.length; j++) {
                const roomTime = room1[j]['dateAndTime']['time'];
                const temperature = room1[j]['temperature'];

                const hour = parseInt(roomTime.split(':')[0]);

                if (hour === i && checkWorkingTime(roomTime) && temperature < hourMinTemp && room1[j]['dateAndTime']['date'] === datePicked) {
                    hourMinTemp = temperature;
                }
            }

            minTemperatureData.push(hourMinTemp);
            minTemperatureLabels.push(`${i}:00 - ${i + 1}:00`);
        }

        minTempChart.data.labels = minTemperatureLabels;
        minTempChart.data.datasets[0].data = minTemperatureData;
        minTempChart.options.scales.y.min = Math.min(...minTemperatureData) - 1;
        minTempChart.options.scales.y.max = Math.max(...minTemperatureData) + 1;
        minTempChart.update();
    });

    async function loadData() {
        console.log('hello world');
        roomTemperature = await getData('/co2-and-temperature-data');
        room1 = roomTemperature[0]['roomTimes'];

        // Calculate lowest temperature for each time span and date
        let minTemperatures = {};

        for (let i = 8; i < 18; i++) {
            let hourMinTemp = Infinity;

            for (let j = 0; j < room1.length; j++) {
                const roomTime = room1[j]['dateAndTime']['time'];
                const temperature = room1[j]['temperature'];
                const roomDate = room1[j]['dateAndTime']['date'];

                const hour = parseInt(roomTime.split(':')[0]);

                if (hour === i && temperature < hourMinTemp && roomDate === datePicked) {
                    hourMinTemp = temperature;
                }
            }

            minTemperatures[i] = hourMinTemp;
        }

        // Display lowest temperature for each time span and date
        for (let hour in minTemperatures) {
            console.log(`Lowest temperature for ${hour}:00 - ${parseInt(hour) + 1}:00 on ${datePicked}: ${minTemperatures[hour]}`);
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

window.addEventListener('load', initMinTemperature);
