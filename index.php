<?php
session_start();
require('razorpay-php/Razorpay.php');
include('config.php');

use Razorpay\Api\Api;

$api_key = $razorpay_config['api_key'];
$api_secret = $razorpay_config['api_secret'];

$api = new Api($api_key, $api_secret);

$input = json_decode(file_get_contents("php://input"), true);

$_SESSION['fullName'] = $input['name'] ?? '';
$_SESSION['email'] = $input['email'] ?? '';
$_SESSION['phone'] = $input['phone'] ?? '';
$amount = 1;

$user = $_SESSION['fullName'];
$email = $_SESSION['email'];
$contact = $_SESSION['phone'];

$order = $api->order->create([
    'amount' => $amount * 100,
    'currency' => 'INR',
    'receipt' => 'order_receipt_12asa3'
]);

$order_id = $order->id;
$_SESSION['order_id'] = $order_id;

$callback_url = "http://localhost:8080/event_registration/success.php";

$response = [
    'key' => $api_key,
    'order_id' => $order_id,
    'amount' => $order->amount,
    'currency' => $order->currency,
    'name' => 'YAICESS',
    'description' => 'Payment for session',
    'image' => 'https://cdn.razorpay.com/logos/GhRQcyean79PqE_medium.png',
    'prefill' => [
        'name' => $user,
        'email' => $email,
        'contact' => $contact
    ],
    'theme' => [
        'color' => '#3399cc'
    ],
    'callback_url' => $callback_url
];

header('Content-Type: application/json');
echo json_encode($response);
?>
