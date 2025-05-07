<?php

$servername = "codembs.com";
$username = "codembsc_aqi";
$password = "Aqi@0101@aqi";
$dbname = "codembsc_aqi";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}


?>