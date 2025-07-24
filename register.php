<?php
// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$database = "datascience";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create table if not exists
$sql_create_table = "CREATE TABLE IF NOT EXISTS user_accounts (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql_create_table);

// Insert only if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form values
    $user = $_POST['username'] ?? '';
    $pass = $_POST['password'] ?? '';

    // Hash the password for security
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    // Insert data
    $sql_insert = "INSERT INTO user_accounts (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("ss", $user, $hashed_pass);

    if ($stmt->execute()) {
        echo "User registered successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
