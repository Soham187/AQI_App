<!-- header.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Air Quality Monitoring</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional: Custom styles -->
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f9ff;
        }
        .navbar {
            background-color: #007bff;
        }
        .navbar-brand {
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <!-- Optional: Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="dashboard.php">🌍 AQ Monitor</a>
        </div>
    </nav>
    <style>
        body {
            background: #f9f9f9;
        }
        .card-header {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
<div class="container py-4">
    <!-- Back Button -->
    <div class="mb-3">
        <a href="dashboard.php" class="btn btn-outline-primary w-100">⬅️ Back to Dashboard</a>
    </div>

    <h4 class="mb-3 text-center">🧪 Air Pollutant Information</h4>

    <div class="accordion" id="pollutantAccordion">

        <!-- PM2.5 -->
        <div class="accordion-item mb-2">
            <h2 class="accordion-header" id="headingPM25">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePM25" aria-expanded="true">
                    PM2.5 (Fine Particulate Matter)
                </button>
            </h2>
            <div id="collapsePM25" class="accordion-collapse collapse show" data-bs-parent="#pollutantAccordion">
                <div class="accordion-body">
                    <p><strong>Description:</strong> PM2.5 refers to airborne particles with diameters ≤ 2.5 micrometers. These particles are small enough to penetrate deep into the lungs and even enter the bloodstream.</p>
                    <p><strong>Sources:</strong> Vehicle emissions, industrial processes, residential burning, construction activities.</p>
                    <p><strong>Health Effects:</strong> Increases risk of respiratory diseases, cardiovascular problems, asthma, and premature death.</p>
                    <p><strong>WHO Guideline:</strong> Annual mean ≤ <strong>5 µg/m³</strong>, 24-hour mean ≤ <strong>15 µg/m³</strong></p>
                </div>
            </div>
        </div>

        <!-- PM10 -->
        <div class="accordion-item mb-2">
            <h2 class="accordion-header" id="headingPM10">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePM10">
                    PM10 (Particulate Matter)
                </button>
            </h2>
            <div id="collapsePM10" class="accordion-collapse collapse" data-bs-parent="#pollutantAccordion">
                <div class="accordion-body">
                    <p><strong>Description:</strong> PM10 are inhalable particles with diameters ≤ 10 micrometers. While larger than PM2.5, they can still affect respiratory health.</p>
                    <p><strong>Sources:</strong> Dust from roads, construction, industries, and natural sources.</p>
                    <p><strong>Health Effects:</strong> Can cause coughing, wheezing, and chronic bronchitis.</p>
                    <p><strong>WHO Guideline:</strong> Annual mean ≤ <strong>15 µg/m³</strong>, 24-hour mean ≤ <strong>45 µg/m³</strong></p>
                </div>
            </div>
        </div>

        <!-- CO -->
        <div class="accordion-item mb-2">
            <h2 class="accordion-header" id="headingCO">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCO">
                    CO (Carbon Monoxide)
                </button>
            </h2>
            <div id="collapseCO" class="accordion-collapse collapse" data-bs-parent="#pollutantAccordion">
                <div class="accordion-body">
                    <p><strong>Description:</strong> CO is a colorless, odorless gas formed from incomplete combustion of carbon-containing fuels.</p>
                    <p><strong>Sources:</strong> Vehicle exhaust, indoor heating, burning of wood and fossil fuels.</p>
                    <p><strong>Health Effects:</strong> Reduces oxygen delivery to organs; causes dizziness, headaches, and in high amounts, can be fatal.</p>
                    <p><strong>WHO Guideline:</strong> 8-hour mean ≤ <strong>4 mg/m³</strong></p>
                </div>
            </div>
        </div>

        <!-- NO2 -->
        <div class="accordion-item mb-2">
            <h2 class="accordion-header" id="headingNO2">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNO2">
                    NO₂ (Nitrogen Dioxide)
                </button>
            </h2>
            <div id="collapseNO2" class="accordion-collapse collapse" data-bs-parent="#pollutantAccordion">
                <div class="accordion-body">
                    <p><strong>Description:</strong> NO₂ is a reddish-brown gas formed from burning fossil fuels. It contributes to smog and acid rain.</p>
                    <p><strong>Sources:</strong> Motor vehicle emissions, power plants, heating systems.</p>
                    <p><strong>Health Effects:</strong> Irritates airways, worsens asthma, increases susceptibility to respiratory infections.</p>
                    <p><strong>WHO Guideline:</strong> Annual mean ≤ <strong>10 µg/m³</strong>, 1-hour mean ≤ <strong>200 µg/m³</strong></p>
                </div>
            </div>
        </div>

        <!-- O3 -->
        <div class="accordion-item mb-2">
            <h2 class="accordion-header" id="headingO3">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseO3">
                    O₃ (Ozone)
                </button>
            </h2>
            <div id="collapseO3" class="accordion-collapse collapse" data-bs-parent="#pollutantAccordion">
                <div class="accordion-body">
                    <p><strong>Description:</strong> Ground-level ozone is a major component of smog, formed by reactions between sunlight and pollutants like NOx and VOCs.</p>
                    <p><strong>Sources:</strong> Photochemical reactions involving vehicle and industrial emissions.</p>
                    <p><strong>Health Effects:</strong> Reduces lung function, worsens asthma, and causes chest pain and throat irritation.</p>
                    <p><strong>WHO Guideline:</strong> 8-hour mean ≤ <strong>100 µg/m³</strong></p>
                </div>
            </div>
        </div>

    </div> <!-- End accordion -->
</div>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
