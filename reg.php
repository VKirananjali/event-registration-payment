<?php
session_start();
include('connection.php');

$user = $_POST['fullName'];
$email = $_POST['email'];
$phone = $_POST['phone']; 


$sql_insert = "INSERT INTO users_reg (username, email, phone) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql_insert);
$stmt->bind_param("ssss", $user, $email, $phone, $orderid);

$stmt->execute();

$id= $stmt->insert_id;

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/css/success.css">
</head>
<body>
    <div class="container">
        <div class="icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <h1>Payment Successful!</h1>
        <p>Thank you for your payment. Your transaction was successful.</p>
        <a href="index.html" class="button">Back to Home</a>
    </div>
</body>
</html>

