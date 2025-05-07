<?php
include 'db.php';

function getLatestReading($conn) {
    $sql = "SELECT * FROM sensor_readings ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function getReadingsByRange($conn, $start, $end) {
    $sql = "SELECT * FROM sensor_readings WHERE DATE(created_at) BETWEEN '$start' AND '$end' ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
    $readings = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $readings[] = $row;
    }
    return $readings;
}

// Daily average data for the past 7 days
function getDailyAverageReadings($conn) {
    $sql = "SELECT DATE(created_at) as day, 
                   AVG(temperature) as avg_temp, 
                   AVG(humidity) as avg_humidity, 
                   AVG(dust) as avg_dust 
            FROM sensor_readings 
            WHERE created_at >= CURDATE() - INTERVAL 7 DAY 
            GROUP BY DATE(created_at)";
    $result = mysqli_query($conn, $sql);
    $averages = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $averages[] = $row;
    }
    return $averages;
}

$today = date("Y-m-d");
$weekAgo = date("Y-m-d", strtotime("-7 days"));
$monthAgo = date("Y-m-d", strtotime("-30 days"));

$latest = getLatestReading($conn);
$weekly = getReadingsByRange($conn, $weekAgo, $today);
$monthly = getReadingsByRange($conn, $monthAgo, $today);
$dailyAverages = getDailyAverageReadings($conn);

$customData = [];
if (isset($_GET['from']) && isset($_GET['to'])) {
    $from = $_GET['from'];
    $to = $_GET['to'];
    $customData = getReadingsByRange($conn, $from, $to);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sensor Values</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 and Chart.js CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background: #f8f9fa;
            font-size: 14px;
        }

        .sensor-card {
            background: #fff;
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }

        @media (max-width: 576px) {
            .sensor-card {
                padding: 0.75rem;
            }
            .table {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

<div class="container py-4">

    <!-- Latest Sensor Reading -->
    <div class="sensor-card">
        <h5>🌡️ Latest Sensor Reading</h5>
        <?php if ($latest): ?>
            <ul class="list-group">
                <li class="list-group-item">Temperature: <strong><?= $latest['temperature'] ?> °C</strong></li>
                <li class="list-group-item">Humidity: <strong><?= $latest['humidity'] ?> %</strong></li>
                <li class="list-group-item">Dust Density: <strong><?= $latest['dust'] ?></strong></li>
                <li class="list-group-item">MQ135: <strong><?= $latest['mq135'] ? 'HIGH' : 'LOW' ?></strong></li>
                <li class="list-group-item">MQ137: <strong><?= $latest['mq137'] ? 'Detected' : 'None' ?></strong></li>
                <li class="list-group-item text-muted small">Time: <?= $latest['created_at'] ?></li>
            </ul>
        <?php else: ?>
            <p>No data available.</p>
        <?php endif; ?>
    </div>

    <!-- Chart for Daily Averages -->
    <div class="sensor-card">
        <h6>📈 Daily Average Readings (Last 7 Days)</h6>
        <div style="overflow-x:auto;">
            <canvas id="dailyChart" height="200"></canvas>
        </div>
    </div>

    <!-- Weekly Data -->
    <div class="sensor-card">
        <h6>📆 Weekly Data</h6>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Time</th><th>Temp</th><th>Humidity</th><th>Dust</th><th>MQ135</th><th>MQ137</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($weekly as $row): ?>
                        <tr>
                            <td><?= date("m/d H:i", strtotime($row['created_at'])) ?></td>
                            <td><?= $row['temperature'] ?></td>
                            <td><?= $row['humidity'] ?></td>
                            <td><?= $row['dust'] ?></td>
                            <td><?= $row['mq135'] ? 'HIGH' : 'LOW' ?></td>
                            <td><?= $row['mq137'] ? 'Yes' : 'No' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Monthly Data -->
    <div class="sensor-card">
        <h6>📅 Monthly Data</h6>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Time</th><th>Temp</th><th>Humidity</th><th>Dust</th><th>MQ135</th><th>MQ137</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($monthly as $row): ?>
                        <tr>
                            <td><?= date("m/d", strtotime($row['created_at'])) ?></td>
                            <td><?= $row['temperature'] ?></td>
                            <td><?= $row['humidity'] ?></td>
                            <td><?= $row['dust'] ?></td>
                            <td><?= $row['mq135'] ? 'HIGH' : 'LOW' ?></td>
                            <td><?= $row['mq137'] ? 'Yes' : 'No' ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Custom Range Filter -->
    <div class="sensor-card">
        <h6>🔎 Custom Range</h6>
        <form method="GET" class="row g-2 mb-2">
            <div class="col-12 col-sm-6">
                <input type="date" name="from" class="form-control" required>
            </div>
            <div class="col-12 col-sm-6">
                <input type="date" name="to" class="form-control" required>
            </div>
            <div class="col-12">
                <button type="submit" class="btn btn-primary w-100">Get Data</button>
            </div>
        </form>
        <?php if (!empty($customData)): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr><th>Time</th><th>Temp</th><th>Humidity</th><th>Dust</th><th>MQ135</th><th>MQ137</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customData as $row): ?>
                            <tr>
                                <td><?= $row['created_at'] ?></td>
                                <td><?= $row['temperature'] ?></td>
                                <td><?= $row['humidity'] ?></td>
                                <td><?= $row['dust'] ?></td>
                                <td><?= $row['mq135'] ? 'HIGH' : 'LOW' ?></td>
                                <td><?= $row['mq137'] ? 'Yes' : 'No' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php elseif (isset($_GET['from'])): ?>
            <p>No data found for the selected range.</p>
        <?php endif; ?>
    </div>

    <!-- Back Button -->
    <div class="mb-3">
        <a href="dashboard.php" class="btn btn-outline-primary w-100">⬅️ Back to Dashboard</a>
    </div>

</div>

<script>
    const dailyData = <?= json_encode($dailyAverages) ?>;

    const labels = dailyData.map(item => item.day);
    const tempData = dailyData.map(item => parseFloat(item.avg_temp));
    const humidityData = dailyData.map(item => parseFloat(item.avg_humidity));
    const dustData = dailyData.map(item => parseFloat(item.avg_dust));

    const ctx = document.getElementById('dailyChart').getContext('2d');
    const dailyChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: 'Temperature (°C)',
                    data: tempData,
                    borderColor: '#ff6384',
                    backgroundColor: 'rgba(255,99,132,0.2)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Humidity (%)',
                    data: humidityData,
                    borderColor: '#36a2eb',
                    backgroundColor: 'rgba(54,162,235,0.2)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Dust Density',
                    data: dustData,
                    borderColor: '#ffce56',
                    backgroundColor: 'rgba(255,206,86,0.2)',
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' }},
            scales: {
                x: { title: { display: true, text: 'Date' } },
                y: { title: { display: true, text: 'Value' }, beginAtZero: true }
            }
        }
    });
</script>

</body>
</html>
