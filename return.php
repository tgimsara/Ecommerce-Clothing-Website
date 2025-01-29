<?php
// Check if PayHere has returned any data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture the data returned by PayHere
    $paymentStatus = $_POST['status'];
    $orderId = $_POST['order_id'];
    $paymentId = $_POST['payment_id'];
    $message = $_POST['message'];

    // Validate the response
    if ($paymentStatus === "2") { // Status 2 indicates a successful payment
        echo "<h1>Payment Successful!</h1>";
        echo "<p>Thank you for your payment. Your transaction was successful.</p>";
        echo "<p><strong>Order ID:</strong> $orderId</p>";
        echo "<p><strong>Payment ID:</strong> $paymentId</p>";
    } else {
        echo "<h1>Payment Failed!</h1>";
        echo "<p>Unfortunately, your payment could not be completed.</p>";
        echo "<p><strong>Reason:</strong> $message</p>";
    }
} else {
    echo "<h1>No Data Received</h1>";
    echo "<p>It seems no data was sent from PayHere.</p>";
}
?>
