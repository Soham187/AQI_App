<?php
session_start();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Search AQI by City</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
  body {
    font-family: 'Segoe UI', sans-serif;
    margin: 0;
    background: linear-gradient(to bottom right, #f0f2f5, #ffffff);
    color: #333;
    padding: 0;
  }

  .container {
    margin: 60px auto 30px auto;
    max-width: 500px;
    padding: 20px;
    position: relative;
  }

  .card {
    border-radius: 15px;
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
    background-color: #fff;
    padding: 30px;
  }

  .back-btn {
    display: inline-block;
    margin-bottom: 20px;
    font-size: 16px;
    font-weight: 500;
    color: #0d6efd;
    text-decoration: none;
    border: 1px solid #0d6efd;
    padding: 6px 16px;
    border-radius: 30px;
    transition: all 0.3s ease;
  }

  .back-btn:hover {
    background-color: #0d6efd;
    color: white;
  }

  .results p {
    margin-bottom: 5px;
  }
</style>
</head>
<body>

<a href="dashboard.php" class="back-btn">← Back</a>

<div class="container">
    <h4 class="text-center mb-4">Search AQI by City</h4>
    <form id="cityForm">
        <div class="input-group mb-3">
            <input type="text" id="cityInput" class="form-control" placeholder="Enter city name..." required>
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>

    <div id="aqiResult" class="card p-3 d-none">
        <h5 id="cityName"></h5>
        <div class="results">
            <p><strong>AQI:</strong> <span id="aqi">--</span></p>
            <p><strong>PM2.5:</strong> <span id="pm25">--</span></p>
            <p><strong>PM10:</strong> <span id="pm10">--</span></p>
            <p><strong>O3 (Ozone):</strong> <span id="o3">--</span></p>
            <p><strong>NO2:</strong> <span id="no2">--</span></p>
            <p><strong>CO:</strong> <span id="co">--</span></p>
            <p><strong>SO2:</strong> <span id="so2">--</span></p>
            <p><strong>NH3 (Ammonia):</strong> <span id="nh3">--</span></p>
        </div>
    </div>

    <div id="errorBox" class="alert alert-danger mt-3 d-none"></div>
</div>

<script>
    const form = document.getElementById('cityForm');
    const token = "ca324e4dcdc8bd23536091c613faeac6685b81d0";

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const city = document.getElementById('cityInput').value.trim();
        const resultCard = document.getElementById('aqiResult');
        const errorBox = document.getElementById('errorBox');

        resultCard.classList.add('d-none');
        errorBox.classList.add('d-none');

        if (city === "") return;

        fetch(`https://api.waqi.info/feed/${encodeURIComponent(city)}/?token=${token}`)
            .then(response => response.json())
            .then(data => {
                if (data.status === "ok") {
                    const iaqi = data.data.iaqi || {};
                    const getVal = (key) => iaqi[key]?.v ?? "N/A";

                    document.getElementById("cityName").innerText = data.data.city.name;
                    document.getElementById("aqi").innerText = data.data.aqi ?? "N/A";
                    document.getElementById("pm25").innerText = getVal("pm25");
                    document.getElementById("pm10").innerText = getVal("pm10");
                    document.getElementById("o3").innerText = getVal("o3");
                    document.getElementById("no2").innerText = getVal("no2");
                    document.getElementById("co").innerText = getVal("co");
                    document.getElementById("so2").innerText = getVal("so2");
                    document.getElementById("nh3").innerText = getVal("nh3");

                    resultCard.classList.remove('d-none');
                } else {
                    errorBox.innerText = "City not found or AQI unavailable.";
                    errorBox.classList.remove('d-none');
                }
            })
            .catch(() => {
                errorBox.innerText = "Failed to fetch data. Please try again.";
                errorBox.classList.remove('d-none');
            });
    });
</script>

</body>
</html>
