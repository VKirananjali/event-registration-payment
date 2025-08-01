<?php
// Include the Razorpay PHP library
require('razorpay-php/Razorpay.php');

use Razorpay\Api\Api;

// Initialize Razorpay with your key and secret
$api_key = $razorpay_config['api_key'];
$api_secret = $razorpay_config['api_secret'];

$api = new Api($api_key, $api_secret);

// Check if payment is successful
$success = true;

$error = null;

// Get the payment ID and the signature from the callback
$payment_id = $_POST['razorpay_payment_id'];
$razorpay_signature = $_POST['razorpay_signature'];

try {
    // Verify the payment
    $attributes = array(
        'razorpay_order_id' => $_POST['razorpay_order_id'],
        'razorpay_payment_id' => $payment_id,
        'razorpay_signature' => $razorpay_signature
    );
    $api->utility->verifyPaymentSignature($attributes);
} catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {
    $success = false;
    $error = 'Razorpay Signature Verification Failed';
}

$response = ['status' => $success, 'message' => $error];
return $response; // Return true if verification is successful, false otherwise

?>
