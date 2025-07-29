
<?php
session_start();

$_POST = $_POST ?: json_decode(file_get_contents('php://input'), true); // In case Razorpay sends JSON

$verification = include('verify.php'); // verify.php returns an array

if ($verification['status'] === 'success') {
    if (isset($_POST['razorpay_payment_id'])) {
      include 'register.php'; // Now you can use $_POST in register.php
    }
} else {
    echo "<h2>Payment verification failed</h2><p>{$verification['message']}</p>";
    exit();
}
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
        <a href="home.html" class="button">Back to Home</a>
    </div>
</body>
</html>
