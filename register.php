<?php
session_start();
$input = json_decode(file_get_contents("php://input"), true);
include('database_connection.php');

$user = $_SESSION['fullName'];
$email = $_SESSION['email'];
$phone = $_SESSION['phone']; 
$orderid = $_SESSION['order_id'];

//$paymentId = $input['payment_id'];

$sql_insert = "INSERT INTO users (username, email, phone, payment_id) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql_insert);
$stmt->bind_param("ssss", $user, $email, $phone, $orderid);

$stmt->execute();

$id= $stmt->insert_id;

$stmt->close();
$conn->close();


//emailer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Adjust based on your installation method

$mail = new PHPMailer(true); // Enable exceptions

// SMTP Configuration
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com'; // Your SMTP server
$mail->SMTPAuth = true;
$mail->Username = 'kirananjali318@gmail.com'; // Your Mailtrap username
$mail->Password = 'ekmsmneqggejmosw'; // Your Mailtrap password
$mail->SMTPSecure = 'tls';
$mail->Port = 587;

// Sender and recipient settings
$mail->setFrom('kirananjali318@gmail.com', 'YAICESS');
$mail->addAddress($email, $user);

// Sending plain text email
$mail->isHTML(false); // Set email format to plain text
$mail->Subject = 'Registration Confirmation';
$mail->Body    = 'thanks for registering with us, ' . $user . '. Your registration is successful. Your order ID is: ' . $orderid . '.';

// Send the email
try{
    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>