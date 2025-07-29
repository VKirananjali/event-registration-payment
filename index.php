<?php
// Include the Razorpay PHP library
session_start();
require('razorpay-php/Razorpay.php');
include('config.php');

use Razorpay\Api\Api;

// Initialize Razorpay with your key and secret
$api_key = $razorpay_config['api_key'];
$api_secret = $razorpay_config['api_secret'];

$api = new Api($api_key, $api_secret);
// Create an order

$input = json_decode(file_get_contents("php://input"), true);

$_SESSION['fullName']= $input['name'];
$_SESSION['email']= $input['email'];
$_SESSION['phone']= $input['phone'];
$amount=1; // change the amount

$user = $_SESSION['fullName'];
$email = $_SESSION['email'];
$contact = $_SESSION['phone'];

$order = $api->order->create([
    'amount' => $amount*100, // amount in paise (100 paise = 1 rupee)
    'currency' => 'INR',
    'receipt' => 'order_receipt_12asa3'
]);
// Get the order ID
$order_id = $order->id;
$_SESSION['order_id'] = $order_id;
// Set your callback URL
$callback_url = "http://localhost:8080/success.php";  // change the path

// Include Razorpay Checkout.js library
echo '<script src="https://checkout.razorpay.com/v1/checkout.js"></script>';


// Add a script to handle the payment
echo '<script>
    function startPayment() {
        var options = {
            key: "' . $api_key . '",
            amount: ' . $order->amount . ',
            currency: "' . $order->currency . '",
            name: "YAICESS",
            description: "Payment for -- session",
            image: "https://cdn.razorpay.com/logos/GhRQcyean79PqE_medium.png",
            order_id: "' . $order_id . '",
            prefill: {
                name: $user,
                email: $email,
                contact: $contact
            },
            theme:
            {
                "color": "#738276"
            },
            callback_url: "' . $callback_url . '"
        };
        var rzp = new Razorpay(options);
        rzp.open();
    }
</script>';
?>
