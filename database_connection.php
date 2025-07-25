<?php
$servername = "localhost";
$username = "root";
$password = "Sql@2005";
$database = "event_registration";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
/*if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}*/

if ($conn->connect_error) {
  echo json_encode(["message" => "Connection failed: " . $conn->connect_error]);
  exit();
}

?>