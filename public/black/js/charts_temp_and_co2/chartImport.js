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

let roomTemperature;
let datePicked;
let room1;
let roomPicked;
let outsideTemperatures;
const roomNumberDisplay = document.getElementById('room-number-display');

function initDiagrams() {
    roomPicked = 0;
    roomNumberDisplay.innerHTML = 'Loading RC210...';
    let chartCO2 = document.getElementById('chartContainerCo2');
    let co2Chart = new Chart(chartCO2, {
        type: "line",
        data: {
            labels: [],
            datasets: [
                {
                    label: "CO2",
                    data: [],
                    borderWidth: 1,
                    borderColor: "rgb(227,227,227)",
                    backgroundColor: "rgba(231,231,231,0.25)",
                    fill: 'origin'
                },
                {
                    label: "Occupancy threshold",
                    data: Array.from({ length: 100 }, () =>475),
                    borderWidth: 2,
                    borderColor: "rgb(255,0,0)",
                    backgroundColor: "rgba(255,0,0,0.63)",
                    fill: false
                }
            ]
        },
        options: {
            plugins: {
                zoom: {
                    zoom: {
                        drag: {
                            enabled: true
                        },
                        mode: 'xy',
                    }
                }
            },
            scales: {
                y: {
                    min: 300,
                    max: 1000
                    },
            }
        }
    });


    let chartTemperature = document.getElementById('chartContainerTemperature');
    let tempChart = new Chart(chartTemperature, {
        type: "line",
        data: {
            labels: [],
            datasets: [
                {
                    label: "Temperature",
                    data: [],
                    borderWidth: 1,
                    borderColor: "rgb(114,101,197)",
                    backgroundColor: "rgba(95,79,217,0.4)",
                    fill: 'origin'
                }
            ]
        },
    });

    let chartOutsideTemperature = document.getElementById('chartContainerOutsideTemperature');
    let outtempChart = new Chart(chartOutsideTemperature, {
        type: "line",
        data: {
            labels: [],
            datasets: [
                {
                    label: "Temperature",
                    data: [],
                    borderWidth: 1,
                    borderColor: "rgb(0,176,255)",
                    backgroundColor: "rgba(100,168,227,0.38)",
                    fill: 'origin'
                }
            ]
        },
    });

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
                    borderColor: "rgb(255,75,75)",
                    backgroundColor: "rgba(243,69,69,0.38)",
                    fill: 'origin'
                }
            ]
        },
    });

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
                    borderColor: "rgba(0,80,110,0.34)",
                    backgroundColor: "rgba(33,115,190,0.44)",
                    fill: 'origin'
                }
            ]
        },
    });

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
                    borderColor: "rgb(255,222,0)",
                    backgroundColor: "rgba(255,237,65,0.6)",
                    fill: 'origin'
                }
            ]
        },
    });

    document.getElementById('start').addEventListener('change', function (){ updateCharts();});

    let rooms = document.getElementsByClassName('rooms');
    Array.from(rooms).forEach(element => {
       element.addEventListener('click', function (){
           let elementId = element.id;
           let roomsMappingElement = roomsMapping[elementId];
           roomNumberDisplay.innerHTML = 'Loading '+ element.id +'...';
           loadDataForRoom(roomsMappingElement).then(r => {
               updateCharts();
               roomNumberDisplay.innerHTML = element.id;
           });
       });
    });

    function updateCharts() {
        datePicked = document.getElementById('start').value;
        let co2Data = [];
        let co2Labels = [];
        let temperatureData = [];
        let temperatureLabels = [];
        for (let i = 0; i < room1.length ; i++) {
            const roomDate = room1[i]['dateAndTime']['date'];
            if (roomDate === datePicked) {
                if (getMinuteFromTime(room1[i]['dateAndTime']['time']) % 10 === 0 && checkWorkingTime(room1[i]['dateAndTime']['time'])) { // Display data every 10 minutes
                    co2Data.push(room1[i]['co2']);
                    co2Labels.push(room1[i]['dateAndTime']['time']);
                    temperatureData.push(room1[i]['temperature']);
                    temperatureLabels.push(room1[i]['dateAndTime']['time']);
                }
            }
        }

        let maxTemperatureData = [];
        let maxTemperatureLabels = [];
        let minTemperatureData = [];
        let minTemperatureLabels = [];
        let averageTemperatureData = [];
        let averageTemperatureLabels = [];

        for (let i = 8; i < 18; i++) {
            let hourMaxTemp = -Infinity;
            let hourMinTemp = Infinity;
            let hourSum = 0;
            let count = 0;

            for (let j = 0; j < room1.length; j++) {
                const roomTime = room1[j]['dateAndTime']['time'];
                const temperature = room1[j]['temperature'];

                const hour = parseInt(roomTime.split(':')[0]);

                if (hour === i && checkWorkingTime(roomTime) && temperature > hourMaxTemp && room1[j]['dateAndTime']['date'] === datePicked) {
                    hourMaxTemp = temperature;
                }
                if (hour === i && checkWorkingTime(roomTime) && temperature < hourMinTemp && room1[j]['dateAndTime']['date'] === datePicked) {
                    hourMinTemp = temperature;
                }
                if (hour === i && checkWorkingTime(roomTime) && room1[j]['dateAndTime']['date'] === datePicked) {
                    hourSum += temperature;
                    count++;
                }
            }

            maxTemperatureData.push(hourMaxTemp);
            maxTemperatureLabels.push(`${i}:00 - ${i + 1}:00`);
            minTemperatureData.push(hourMinTemp);
            minTemperatureLabels.push(`${i}:00 - ${i + 1}:00`);
            const averageTemperature = count > 0 ? hourSum / count : 0;
            averageTemperatureData.push(averageTemperature);
            averageTemperatureLabels.push(`${i}:00 - ${i + 1}:00`);
        }

        maxTempChart.data.labels = maxTemperatureLabels;
        maxTempChart.data.datasets[0].data = maxTemperatureData;
        maxTempChart.options.scales.y.min = Math.min(...maxTemperatureData) - 1;
        maxTempChart.options.scales.y.max = Math.max(...maxTemperatureData) + 1;
        maxTempChart.update();
        minTempChart.data.labels = minTemperatureLabels;
        minTempChart.data.datasets[0].data = minTemperatureData;
        minTempChart.options.scales.y.min = Math.min(...minTemperatureData) - 1;
        minTempChart.options.scales.y.max = Math.max(...minTemperatureData) + 1;
        minTempChart.update();
        averageTempChart.data.labels = averageTemperatureLabels;
        averageTempChart.data.datasets[0].data = averageTemperatureData;
        averageTempChart.options.scales.y.min = Math.min(...averageTemperatureData) - 1;
        averageTempChart.options.scales.y.max = Math.max(...averageTemperatureData) + 1;
        averageTempChart.update();

        let outsideTemperatureData = [];
        let outsideTemperatureLabels = [];
        outsideTemperatures.forEach(element => {
           if(element['dateAndTime']['date'] === datePicked) {
               if (getMinuteFromTime(element['dateAndTime']['time']) % 10 === 0 && checkWorkingTime(element['dateAndTime']['time'])) { // Display data every 10 minutes
                     outsideTemperatureLabels.push(element['dateAndTime']['time']);
                     outsideTemperatureData.push(element['outside_temperature']);
               }
           }
        });

        co2Chart.data.labels = co2Labels;
        co2Chart.data.datasets[0].data = co2Data;
        co2Chart.update();
        tempChart.data.labels = temperatureLabels;
        tempChart.data.datasets[0].data = temperatureData;
        tempChart.options.scales.y.min = Math.min(...temperatureData) - 1;
        tempChart.options.scales.y.max = Math.max(...temperatureData) + 1;
        tempChart.update();
        outtempChart.data.labels = outsideTemperatureLabels;
        outtempChart.data.datasets[0].data = outsideTemperatureData;
        outtempChart.options.scales.y.min = Math.min(...outsideTemperatureData) - 1;
        outtempChart.options.scales.y.max = Math.max(...outsideTemperatureData) + 1;
        outtempChart.update();

        if(co2Chart.data.datasets[0].data.length <= 0 || tempChart.data.datasets[0].data.length <= 0 || outtempChart.data.datasets[0].data.length <= 0) {
            document.getElementById('noData').style.display = 'block';
            if(co2Chart.data.datasets[0].data.length <= 0 && tempChart.data.datasets[0].data.length <= 0 && outtempChart.data.datasets[0].data.length <= 0) {
                document.getElementById('noDataContent').innerHTML = 'No data for this day! / Geen gegevens voor deze dag!';
            }
            else {
                document.getElementById('noDataContent').innerHTML = 'Lack of some data for this day! / Een deel van de gegevens ontbreekt!';
            }
        }
        else{
            document.getElementById('noData').style.display = 'none';
        }
    }

    loadDataForRoom(roomPicked).then(r => {
        updateCharts();
        roomNumberDisplay.innerHTML = 'RC210';
    });

}

async function loadDataForRoom(roomPicked) {
    roomTemperature = await getData('/co2-and-temperature-data');
    outsideTemperatures = roomTemperature[roomTemperature.length - 1];
    room1 = roomTemperature[roomPicked]['roomTimes'];
}

function getMinuteFromTime(time) {
    return parseInt(time.split(':')[1]);
}

function checkWorkingTime(time) {
    let hour = parseInt(time.split(':')[0]);
    let minute = parseInt(time.split(':')[1]);

    return (hour >= 8 && hour <= 17) || (hour === 18 && minute === 0);
}

let roomsMapping = {
    'RC210': 0,
    'RC211': 1,
    'RC212': 2,
    'RC213': 3,
    'RC214': 4
};

window.addEventListener('load', initDiagrams);
