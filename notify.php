<?php
// PayHere secret for validating the notification
$merchant_secret = "MzA1MDMzNjE4NzQwNDUyNzc1MDIxMTE4NzQ1MjcwMjA5Nzk0MjgyNA=="; // Replace with your Sandbox Secret Key

// Retrieve the notification data
$notificationData = $_POST;

// Log the notification (optional: for debugging)
file_put_contents("payhere_notifications.log", json_encode($notificationData) . PHP_EOL, FILE_APPEND);

// Check if notification data is received
if (!empty($notificationData)) {
    // Extract data
    $merchant_id = $notificationData['merchant_id'];
    $order_id = $notificationData['order_id'];
    $payment_id = $notificationData['payment_id'];
    $status_code = $notificationData['status_code'];
    $payhere_amount = $notificationData['payhere_amount'];
    $payhere_currency = $notificationData['payhere_currency'];
    $checksum = $notificationData['md5sig'];

    // Generate the checksum for validation
    $local_checksum = strtoupper(md5(
        $merchant_id . $order_id . $payment_id . $payhere_amount . $payhere_currency . strtoupper(md5($merchant_secret))
    ));

    // Validate the checksum
    if ($checksum === $local_checksum) {
        // Check payment status
        if ($status_code == "2") {
            // Payment was successful
            file_put_contents("successful_payments.log", "Order ID: $order_id, Payment ID: $payment_id" . PHP_EOL, FILE_APPEND);
            http_response_code(200); // Send success response to PayHere
            echo "Payment verified successfully.";
        } else {
            // Payment failed or was canceled
            file_put_contents("failed_payments.log", "Order ID: $order_id, Status Code: $status_code" . PHP_EOL, FILE_APPEND);
            http_response_code(400); // Send failure response to PayHere
            echo "Payment verification failed.";
        }
    } else {
        // Invalid checksum
        file_put_contents("invalid_checksum.log", "Order ID: $order_id, Invalid checksum received." . PHP_EOL, FILE_APPEND);
        http_response_code(400); // Send failure response to PayHere
        echo "Invalid checksum. Verification failed.";
    }
} else {
    // No notification data received
    http_response_code(400);
    echo "No notification data received.";
}
?>
