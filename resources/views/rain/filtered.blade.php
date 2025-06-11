<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rain Monitoring Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }
        .dashboard-container {
            max-width: 900px;
            margin: 40px auto;
        }
        .card {
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .summary-list li {
            margin-bottom: 0.5rem;
        }
        .form-select {
            max-width: 250px;
        }
    </style>
</head>
<body>
<div class="dashboard-container">
    <div class="card p-4 mb-4">
        <div class="d-flex justify-content-between mb-3">
            <h3>Rain Data Filter</h3>
            <a href="/" class="btn btn-outline-primary">⬅ Back to Home</a>
        </div>
        <form method="get" action="/filtered-data">
            <div class="mb-3">
                <select name="filter" class="form-select" onchange="this.form.submit()">
                    <option value="daily" {{ $filter == 'daily' ? 'selected' : '' }}>Daily (This Week)</option>
                    <option value="monthly" {{ $filter == 'monthly' ? 'selected' : '' }}>Monthly (This Month)</option>
                    <option value="yearly" {{ $filter == 'yearly' ? 'selected' : '' }}>Yearly (This Year)</option>
                </select>
            </div>
        </form>
    </div>

    <div class="card p-4 mb-4">
        <h4 class="mb-3">Rain Amount Chart</h4>
        <canvas id="filteredChart" height="120"></canvas>
    </div>

    <div class="card p-4">
        <h4 class="mb-3">Summary</h4>
        <ul class="list-group summary-list">
            <li class="list-group-item d-flex justify-content-between">
                <span>Total Rain:</span>
                <strong>{{ number_format($summary['total_rain'], 2) }} mm</strong>
            </li>
            <li class="list-group-item d-flex justify-content-between">
                <span>Rain Days:</span>
                <strong>{{ $summary['rain_days'] }}</strong>
            </li>
            {{-- <li class="list-group-item d-flex justify-content-between">
                <span>Average Rain:</span>
                <strong>{{ number_format($summary['average_rain'], 2) }} mm</strong>
            </li> --}}
        </ul>
    </div>
</div>

<script>
    const data = @json($data);
    const labels = Object.keys(data);
    const values = Object.values(data);

    new Chart(document.getElementById('filteredChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Avg Rain (mm)',
                data: values,
                backgroundColor: 'rgba(40, 167, 69, 0.7)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: {
                    display: true,
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Rain Amount (mm)'
                    }
                }
            }
        }
    });
</script>
</body>
</html>
