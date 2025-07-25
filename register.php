<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include('database_connection.php');

// Create table if not exists
/*$sql_create_table = "CREATE TABLE IF NOT EXISTS user_accounts (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($sql_create_table);*/

// Insert only if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form values
    $input = json_decode(file_get_contents("php://input"), true);
    $user = $input['name'] ?? '';
    $email = $input['email'] ?? '';
    $phone = $input['phone'] ?? ''; // Optional: Validate email and phone number format here
    $pass = $input['password'] ?? '';

    if (empty($user) || empty($email) || empty($pass)) {
        echo json_encode(["message" => "Please provide all required fields (username, email, password)."]);
        exit; // Stop execution if required fields are missing
    }

    // Hash the password for security
    $hashed_pass = password_hash($pass, PASSWORD_DEFAULT);

    // Insert data
    $sql_insert = "INSERT INTO users (username, email, phone, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_insert);
    $stmt->bind_param("ssss", $user, $email, $phone, $hashed_pass);

    try{
        if ($stmt->execute()) {
            echo json_encode(["message" => "Contact saved successfully!"]);
        } else {
            echo json_encode(["message" => "Error saving contact."]);
        }
    }
    catch(Exception $e) { // Catching more general exceptions
        echo json_encode(["message: " => $e->getMessage() . "\n"]);
    }
    finally{
        $stmt->close();
        $conn->close();
    }
    
}
?>
