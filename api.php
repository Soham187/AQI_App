<?php
include 'db.php'; // assumes $conn is your DB connection

// Collect GET values
$temperature = isset($_GET['temperature']) ? floatval($_GET['temperature']) : null;
$humidity    = isset($_GET['humidity']) ? floatval($_GET['humidity']) : null;
$dust        = isset($_GET['dust']) ? floatval($_GET['dust']) : null;
$mq135       = isset($_GET['mq135']) ? intval($_GET['mq135']) : null;
$mq137       = isset($_GET['mq137']) ? intval($_GET['mq137']) : null;

if ($temperature !== null && $humidity !== null && $dust !== null && $mq135 !== null && $mq137 !== null) {
    $unixTime = time();

    $stmt = $conn->prepare("INSERT INTO sensor_readings (temperature, humidity, dust, mq135, mq137, unix_time) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ddddii", $temperature, $humidity, $dust, $mq135, $mq137, $unixTime);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success"]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Missing or invalid parameters"]);
}
?>
