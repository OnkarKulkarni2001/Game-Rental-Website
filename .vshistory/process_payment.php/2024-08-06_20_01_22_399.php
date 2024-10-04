<?php
session_start();

// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "videogamerental";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['login_customer'])) {
    session_destroy();
    header("location: customerlogin.php");
    exit();
}

$message = '';
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $orderId = isset($_POST['orderId']) ? $conn->real_escape_string($_POST['orderId']) : '';
    $cardNumber = isset($_POST['cardNumber']) ? $conn->real_escape_string($_POST['cardNumber']) : '';
    $cardName = isset($_POST['cardName']) ? $conn->real_escape_string($_POST['cardName']) : '';
    $expDate = isset($_POST['expDate']) ? $conn->real_escape_string($_POST['expDate']) : '';
    $cvv = isset($_POST['cvv']) ? $conn->real_escape_string($_POST['cvv']) : '';

    // Validate required fields
    if (empty($orderId) || empty($cardNumber) || empty($cardName) || empty($expDate) || empty($cvv)) {
        $message = "All fields are required.";
        $error = true;
    } else {
        // Placeholder for payment processing
        $payment_successful = true; // This should be replaced with actual payment gateway integration

        if ($payment_successful) {
            // Update the booking status
            $sql = "UPDATE rentedgames SET payment_status = 'Completed' WHERE game_id = '$orderId'";

            if ($conn->query($sql) === TRUE) {
                $message = "Payment Successful! Booking Confirmed!";
            } else {
                $message = "Error updating booking status: " . $conn->error;
                $error = true;
            }
        } else {
            $message = "Payment failed. Please try again.";
            $error = true;
        }
    }

    $conn->close();
} else {
    $message = "Invalid request method.";
    $error = true;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment Status</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header">
                        <h3 class="text-center">Payment Status</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger">
                                <?php echo $message; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-success">
                                <?php echo $message; ?>
                            </div>
                        <?php endif; ?>
                        <div class="text-center mt-4">
                            <a href="index.php" class="btn btn-primary">Go to Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
