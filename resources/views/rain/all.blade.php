<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Rain Data</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap & Chart.js -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <style>
        body {
            background-color: #f4f6f8;
            font-family: 'Segoe UI', sans-serif;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.08);
        }
        .chart-title {
            font-size: 1.25rem;
            font-weight: 500;
            margin-bottom: 20px;
            color: #333;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card p-4">
        <div class="top-bar">
            <div class="chart-title">🌧️ Total Rainfall by Device</div>
            <a href="/" class="btn btn-outline-primary">⬅ Back to Home</a>
        </div>
        <canvas id="allChart" height="120"></canvas>
    </div>
</div>

<script>
    let chart;

    function renderChart(data) {
        const labels = Object.keys(data);
        const values = Object.values(data);

        if (chart) {
            chart.data.labels = labels;
            chart.data.datasets[0].data = values;
            chart.update();
        } else {
            const ctx = document.getElementById('allChart').getContext('2d');
            chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Rain Amount (mm)',
                        data: values,
                        backgroundColor: 'rgba(54, 162, 235, 0.7)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        title: {
                            display: true,
                            text: 'Rainfall by Device',
                            font: { size: 18 }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Rain Amount (mm)'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Device ID'
                            }
                        }
                    }
                }
            });
        }
    }

    function fetchData() {
        $.getJSON("{{ route('rain-data.chart') }}", function(data) {
            renderChart(data);
        });
    }

    // Initial chart render
    fetchData();

    // Refresh every 10 seconds
    setInterval(fetchData, 10000);
</script>

</body>
</html>
