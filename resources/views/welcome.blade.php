<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rain Monitoring Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            background: linear-gradient(to right, #83a4d4, #b6fbff);
            font-family: 'Segoe UI', sans-serif;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .hero {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 60px 20px;
        }

        .hero-content {
            text-align: center;
            background: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            max-width: 600px;
            margin: auto;
        }

        .hero h1 {
            font-size: 2.5rem;
            font-weight: bold;
        }

        .hero p {
            font-size: 1.1rem;
            margin: 20px 0;
        }

        .hero-buttons a {
            margin: 10px;
        }

        footer {
            text-align: center;
            padding: 20px;
            background-color: rgba(255,255,255,0.6);
        }
    </style>
</head>
<body>

    <div class="hero">
        <div class="hero-content">
            <h1>🌧️ Rain Monitoring System</h1>
            <p>Track rainfall patterns from multiple devices in real time. Analyze historical data and gain insights with interactive charts.</p>
            
            <div class="hero-buttons">
                <a href="/all-data" class="btn btn-primary btn-lg">📊 View All Data</a>
                <a href="/filtered-data" class="btn btn-success btn-lg">🔍 Filtered Analytics</a>
            </div>
        </div>
    </div>

    <footer>
        &copy; {{ date('Y') }} Rain Monitoring System | Built with Laravel + Chart.js
    </footer>

</body>
</html>
