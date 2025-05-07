<?php
session_start();
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AeroSync Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@500&family=Poppins&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #eef2f3, #8e9eab);
            margin: 0;
        }

        .header {
            background: linear-gradient(135deg, #fc466b, #3f5efb);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: 'Orbitron', sans-serif;
        }

        .menu-toggle {
            font-size: 1.8rem;
            cursor: pointer;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: -240px;
            height: 100%;
            width: 220px;
            background: linear-gradient(135deg, #3f5efb, #fc466b);
            padding-top: 60px;
            transition: 0.4s ease-in-out;
            z-index: 1000;
        }

        .sidebar.open {
            left: 0;
        }

        .sidebar a {
            padding: 15px 20px;
            display: block;
            color: white;
            text-decoration: none;
            font-size: 1rem;
        }

        .sidebar a:hover {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #fff;
        }

        .sidebar .close-btn {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 1.5rem;
            color: white;
            cursor: pointer;
        }

        .main {
            padding: 25px;
        }

        .aqi-card {
            background: #ffffffc7;
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 25px;
            backdrop-filter: blur(4px);
            transition: transform 0.3s;
        }

        .aqi-card:hover {
            transform: translateY(-5px);
        }

        .share-btn {
            background-color: #00b894;
            border: none;
            color: white;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: bold;
            transition: background 0.3s;
        }

        .share-btn:hover {
            background-color: #00cec9;
        }

        .btn-outline-primary {
            border-radius: 20px;
        }

        @media (min-width: 768px) {
            .sidebar {
                left: 0;
                width: 200px;
                padding-top: 15px;
                position: relative;
            }
            .main {
                margin-left: 220px;
            }
            .menu-toggle, .close-btn {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="header">
    <span class="menu-toggle" onclick="toggleSidebar()">☰</span>
    <h4>AeroSync AQI Monitor</h4>
</div>

<div id="sidebar" class="sidebar">
    <span class="close-btn" onclick="toggleSidebar()">✖</span>
    <a href="dashboard.php"><i class="bi bi-house-fill"></i> Dashboard</a>
    <a href="sensor_values.php"><i class="bi bi-graph-up"></i> Sensor Values</a>
    <a href="feedback.php"><i class="bi bi-chat-dots-fill"></i> Feedback</a>
    <a href="faq.php"><i class="bi bi-question-circle-fill"></i> FAQ</a>
    <a href="https://aqi-community.vercel.app/"><i class="bi bi-box-arrow-right">Community</i></a>
    <a href="https://soham187.github.io/Ranking_AQI/"><i class="bi bi-box-arrow-right">Ranking System</i></a>
    <a href="login.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
</div>

<div class="main">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5><i class="bi bi-geo-alt-fill text-danger"></i> Your Location AQI</h5>
        <a href="city.php" class="btn btn-outline-primary btn-sm">🌍 View by City</a>
    </div>

    <p><strong>Location:</strong> <span id="locationName">Loading...</span></p>
    <p><strong>Coordinates:</strong> <span id="coordinates">Detecting...</span></p>

    <div class="aqi-card mt-4">
        <p><strong>AQI:</strong> <span id="aqi">--</span></p>
        <p><strong>PM2.5:</strong> <span id="pm25">--</span></p>
        <p><strong>PM10:</strong> <span id="pm10">--</span></p>
        <p><strong>O3 (Ozone):</strong> <span id="o3">--</span></p>
        <p><strong>NO2:</strong> <span id="no2">--</span></p>
        <p><strong>CO:</strong> <span id="co">--</span></p>
        <p><strong>SO2:</strong> <span id="so2">--</span></p>
        <p><strong>NH3:</strong> <span id="nh3">--</span></p>
    </div>

    <div class="text-center mt-4">
        <button class="share-btn" onclick="shareReport()">📱 Share Report</button>
    </div>

    <div class="mt-3">
        <a href="polutant.php" class="btn btn-outline-primary w-100">✨ Polutant Explanation</a>
    </div>
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
    }

    function reverseGeocode(lat, lon) {
        fetch(`https://nominatim.openstreetmap.org/reverse?lat=${lat}&lon=${lon}&format=json`)
            .then(res => res.json())
            .then(data => {
                document.getElementById('locationName').innerText = data.display_name || "Unknown location";
            })
            .catch(() => {
                document.getElementById('locationName').innerText = 'Unable to fetch address';
            });
    }

    navigator.geolocation.getCurrentPosition(
        function(position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;
            document.getElementById('coordinates').innerText = `Lat: ${lat}, Lon: ${lon}`;
            reverseGeocode(lat, lon);
            fetchAQI(lat, lon);
        },
        function(error) {
            document.getElementById('coordinates').innerText = 'Location access denied';
        }
    );

    function fetchAQI(lat, lon) {
        const token = "ca324e4dcdc8bd23536091c613faeac6685b81d0";
        const url = `https://api.waqi.info/feed/geo:${lat};${lon}/?token=${token}`;

        fetch(url)
            .then(res => res.json())
            .then(data => {
                if (data.status === "ok") {
                    const iaqi = data.data.iaqi || {};
                    const getVal = (param) => iaqi[param]?.v ?? "N/A";

                    document.getElementById("aqi").innerText = data.data.aqi ?? "N/A";
                    document.getElementById("pm25").innerText = getVal("pm25");
                    document.getElementById("pm10").innerText = getVal("pm10");
                    document.getElementById("o3").innerText = getVal("o3");
                    document.getElementById("no2").innerText = getVal("no2");
                    document.getElementById("co").innerText = getVal("co");
                    document.getElementById("so2").innerText = getVal("so2");
                    document.getElementById("nh3").innerText = getVal("nh3");
                } else {
                    document.querySelector(".aqi-card").innerHTML = "<p>Failed to fetch AQI data.</p>";
                }
            })
            .catch(() => {
                document.querySelector(".aqi-card").innerHTML = "<p>Error fetching data.</p>";
            });
    }

    function shareReport() {
        const locationName = document.getElementById('locationName').innerText;
        const aqi = document.getElementById('aqi').innerText;
        const pm25 = document.getElementById('pm25').innerText;
        const pm10 = document.getElementById('pm10').innerText;

        const message = `AQI Report for ${locationName}:\nAQI: ${aqi}\nPM2.5: ${pm25}\nPM10: ${pm10}`;

        const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(message)}`;
        const facebookUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(message)}`;
        const twitterUrl = `https://twitter.com/intent/tweet?text=${encodeURIComponent(message)}`;

        window.open(whatsappUrl, "_blank");
        window.open(facebookUrl, "_blank");
        window.open(twitterUrl, "_blank");
    }
</script>
</body>
</html>
