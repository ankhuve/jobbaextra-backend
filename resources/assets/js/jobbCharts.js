import Chart from '../../../node_modules/chart.js';

const ctx = document.getElementById("pageviewsChart");
const usersCtx = document.getElementById("usersChart");

if(ctx){
    $.ajax({
        type: 'GET',
        url: '/api/statistics/newjobs/14',
        success: (data) => {
            let dates = [];
            let counts = [];
            for(let i in data){
                for(let j in data[i]){
                    dates.push(j);
                    counts.push(data[i][j]);
                }
            }

            let myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: 'Publicerade jobbannonser',
                        data: counts,
                        backgroundColor: [
                            'rgba(27, 128, 158, 0.5)',
                        ],
                        borderColor: [
                            'rgba(27, 128, 158, 1)',
                        ],
                        pointHoverBorderColor: 'rgba(27, 128, 158, 1)',
                        pointBackgroundColor: 'rgba(27, 128, 158, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1
                            }
                        }]
                    },
                    tooltips: {
                        mode: 'nearest',
                        intersect: false,
                        displayColors: false
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    intersect: false,
                    elements: {
                        line: {
                            tension: 0.2
                        }
                    }
                }
            });
            // $.publish('form.submitted', form);

        },
        error: function(e){
            console.log('Kunde inte hämta jobbstatistik.', e);
        }

    });
}

if(usersCtx) {
    $.ajax({
        type: 'GET',
        url: '/api/statistics/newusers/14',
        success: (data) => {
            let dates = [];
            let counts = [];
            for (let i in data) {
                for (let j in data[i]) {
                    dates.push(j);
                    counts.push(data[i][j]);
                }
            }

            let myChart = new Chart(usersCtx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: 'Nya användare',
                        data: counts,
                        backgroundColor: [
                            'rgba(72, 180, 66, 0.5)',
                        ],
                        borderColor: [
                            'rgba(57, 132, 51, 1)',
                        ],
                        pointHoverBorderColor: 'rgba(57, 132, 51, 1)',
                        pointBackgroundColor: 'rgba(57, 132, 51, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1
                            }
                        }]
                    },
                    tooltips: {
                        mode: 'nearest',
                        intersect: false,
                        displayColors: false
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                    intersect: false,
                    elements: {
                        line: {
                            tension: 0.2
                        }
                    }
                }
            });
            // $.publish('form.submitted', form);

        },
        error: function (e) {
            console.log('Kunde inte hämta användarstatistik.', e);
        }

    });
}