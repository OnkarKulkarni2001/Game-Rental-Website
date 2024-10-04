<?php
include('db_connection.php');
include('session_customer.php');

if (!isset($_SESSION['login_customer'])) {
    session_destroy();
    header("location: customerlogin.php");
    exit();
}

// Retrieve POST data
$cardNumber = $_POST['cardNumber'];
$cardName = $_POST['cardName'];
$expDate = $_POST['expDate'];
$cvv = $_POST['cvv'];
$orderId = $_POST['orderId'];

// Validate inputs
if (empty($cardNumber) || empty($cardName) || empty($expDate) || empty($cvv) || empty($orderId)) {
    die("All fields are required.");
}

// Simulate payment processing (replace this with actual payment gateway API call)
$paymentSuccess = true; // Set to false if payment fails

if ($paymentSuccess) {
    // Update the database with payment status
    $sql = "UPDATE rentedgames SET payment_status = 'Paid' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $orderId);
    
    if (!$stmt->execute()) {
        die("Error updating payment status: " . $conn->error);
    }

    // Redirect to confirmation page
    header("Location: bookingconfirm.php?orderId=" . $orderId);
} else {
    // Redirect to failure page
    header("Location: payment_failure.php");
}
?>
