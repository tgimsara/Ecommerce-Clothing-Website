<?php
// PayHere sandbox API endpoint
$payhereURL = "https://sandbox.payhere.lk/pay/checkout";

// Define merchant details
$merchant_id = "1229275"; // Replace with your Sandbox Merchant ID
$secret_key = "MzA1MDMzNjE4NzQwNDUyNzc1MDIxMTE4NzQ1MjcwMjA5Nzk0MjgyNA=="; // Replace with your Sandbox Secret Key

// Collect payment details
$paymentData = array(
    // Merchant and return/cancel/notify URLs
    "merchant_id" => $merchant_id,
    "return_url" => "return.php", // URL for successful payment
    "cancel_url" => "cancel.php", // URL for canceled payment
    "notify_url" => "notify.php", // Server-to-server notification URL

    // Transaction details
    "order_id" => "ORDER12345", // Unique order ID
    "items" => "Clothing Order", // Item description
    "currency" => "LKR", // Payment currency
    "amount" => "500.00", // Payment amount

    // Customer details
    "first_name" => "John",
    "last_name" => "Doe",
    "email" => "johndoe@example.com",
    "phone" => "0771234567",
    "address" => "123, ABC Street",
    "city" => "Colombo",
    "country" => "Sri Lanka"
);

// Initialize cURL session
$ch = curl_init();

// Configure cURL options
curl_setopt($ch, CURLOPT_URL, $payhereURL);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($paymentData)); // Encode data for HTTP POST
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Authorization: Bearer $secret_key"
));

// Execute the API call
$response = curl_exec($ch);

// Check for errors in the cURL request
if (curl_errno($ch)) {
    echo "Error: " . curl_error($ch);
} else {
    // Decode JSON response (if applicable)
    $responseData = json_decode($response, true);

    // Handle response
    if (isset($responseData['status']) && $responseData['status'] === "success") {
        echo "Payment request successfully sent!";
        // Redirect user to PayHere payment page
        header("Location: " . $responseData['payment_url']);
        exit;
    } else {
        echo "Payment request failed: " . $responseData['message'];
    }
}

// Close the cURL session
curl_close($ch);
?>
