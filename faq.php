<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ | AQI Monitor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Adding Font Awesome CDN for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
   
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f7fa;
        }

        .container {
            margin-top: 50px;
        }

        .faq-section {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .faq-item {
            margin-bottom: 20px;
            border-bottom: 1px solid #f1f1f1;
            padding-bottom: 15px;
        }

        .faq-item h5 {
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #007bff;
        }

        .faq-item h5:hover {
            color: #0056b3;
        }

        .faq-item .answer {
            display: none;
            margin-top: 15px;
            padding: 10px 15px;
            background-color: #f8f9fa;
            border-radius: 5px;
        }

        .faq-item.active .answer {
            display: block;
        }

        .btn-back {
            width: 100%;
            margin-top: 30px;
        }

        .faq-item h5::after {
            content: "\f0dc";
            font-family: FontAwesome;
            float: right;
            font-size: 14px;
            color: #007bff;
        }

        .faq-item.active h5::after {
            content: "\f0de";
            color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="faq-section">
        <h3 class="text-center mb-4">Frequently Asked Questions (FAQ)</h3>

        <!-- FAQ Item 1 -->
        <div class="faq-item">
            <h5 onclick="toggleAnswer(0)">What is AQI?</h5>
            <div class="answer">
                <p>AQI stands for Air Quality Index. It is a system used to measure and compare the level of air pollution. The AQI value ranges from 0 to 500, with higher values indicating worse air quality.</p>
            </div>
        </div>

        <!-- FAQ Item 2 -->
        <div class="faq-item">
            <h5 onclick="toggleAnswer(1)">How is the AQI calculated?</h5>
            <div class="answer">
                <p>The AQI is calculated based on the concentration of specific pollutants in the air, including PM2.5, PM10, NO2, O3, and CO. These concentrations are then translated into an AQI value using standardized formulas.</p>
            </div>
        </div>

        <!-- FAQ Item 3 -->
        <div class="faq-item">
            <h5 onclick="toggleAnswer(2)">How can I check AQI in my city?</h5>
            <div class="answer">
                <p>You can check the AQI for your city by using our app or website. Simply enter the city name or use your current location to fetch the AQI and other related details.</p>
            </div>
        </div>

        <!-- FAQ Item 4 -->
        <div class="faq-item">
            <h5 onclick="toggleAnswer(3)">What are the health effects of poor air quality?</h5>
            <div class="answer">
                <p>Exposure to poor air quality can cause respiratory issues, aggravate asthma, and increase the risk of heart disease. Long-term exposure can lead to more serious conditions like lung cancer and other chronic diseases.</p>
            </div>
        </div>

        <!-- FAQ Item 5 -->
        <div class="faq-item">
            <h5 onclick="toggleAnswer(4)">How can I improve air quality?</h5>
            <div class="answer">
                <p>To improve air quality, reduce vehicle emissions, use renewable energy sources, avoid burning of fossil fuels, and promote green spaces. Additionally, you can use air purifiers and regularly monitor AQI levels in your area.</p>
            </div>
        </div>

        <!-- FAQ Item 6 -->
        <div class="faq-item">
            <h5 onclick="toggleAnswer(5)">What should I do when AQI is high?</h5>
            <div class="answer">
                <p>When AQI levels are high, it is recommended to stay indoors, avoid strenuous outdoor activities, wear a mask, and limit exposure to air pollutants. Consider using air purifiers indoors.</p>
            </div>
        </div>

        <!-- FAQ Item 7 -->
        <div class="faq-item">
            <h5 onclick="toggleAnswer(6)">What are the sources of air pollution?</h5>
            <div class="answer">
                <p>Air pollution comes from various sources, including vehicle emissions, industrial activities, deforestation, waste burning, and natural sources such as wildfires and volcanic eruptions.</p>
            </div>
        </div>

        <!-- FAQ Item 8 -->
        <div class="faq-item">
            <h5 onclick="toggleAnswer(7)">How does air pollution affect climate change?</h5>
            <div class="answer">
                <p>Air pollution contributes to climate change by increasing the concentration of greenhouse gases like CO2 in the atmosphere. It also creates fine particulate matter that can influence cloud formation and weather patterns.</p>
            </div>
        </div>

        <!-- FAQ Item 9 -->
        <div class="faq-item">
            <h5 onclick="toggleAnswer(8)">How can I reduce my carbon footprint?</h5>
            <div class="answer">
                <p>You can reduce your carbon footprint by using public transportation, driving less, conserving energy at home, reducing waste, and adopting a more sustainable lifestyle.</p>
            </div>
        </div>

        <!-- Back Button -->
        <a href="dashboard.php">
            <button class="btn btn-secondary btn-back">Back to Dashboard</button>
        </a>
    </div>
</div>

<script>
    function toggleAnswer(index) {
        const faqItem = document.getElementsByClassName('faq-item')[index];
        faqItem.classList.toggle('active');
    }
</script>

</body>
</html>
