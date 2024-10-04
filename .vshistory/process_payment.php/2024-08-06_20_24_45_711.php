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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $orderId = isset($_POST['orderId']) ? $conn->real_escape_string($_POST['orderId']) : '';
    $cardNumber = isset($_POST['cardNumber']) ? $conn->real_escape_string($_POST['cardNumber']) : '';
    $cardName = isset($_POST['cardName']) ? $conn->real_escape_string($_POST['cardName']) : '';
    $expDate = isset($_POST['expDate']) ? $conn->real_escape_string($_POST['expDate']) : '';
    $cvv = isset($_POST['cvv']) ? $conn->real_escape_string($_POST['cvv']) : '';

    // Validate required fields
    if (empty($orderId) || empty($cardNumber) || empty($cardName) || empty($expDate) || empty($cvv)) {
        die("All fields are required.");
    }

    // Placeholder for payment processing
    $payment_successful = true; // This should be replaced with actual payment gateway integration

    if ($payment_successful) {
        // Update the booking status
        $sql = "UPDATE rentedgames SET payment_status = 'Completed' WHERE game_id = '$orderId'";
        if ($conn->query($sql) === TRUE) {
            $sql1 = "SELECT * FROM rentedgames WHERE game_id = '$orderId'";
            $result1 = $conn->query($sql1);
            if ($result1 && $result1->num_rows > 0) {
                $row1 = $result1->fetch_assoc();
                $game_id = $row1["game_id"];

                $sql2 = "SELECT * FROM videogame WHERE game_id = '$game_id'";
                $result2 = $conn->query($sql2);
                if ($result2 && $result2->num_rows > 0) {
                    $row2 = $result2->fetch_assoc();
                    $game_name = $row2["game_name"];
                } else {
                    die("Error fetching game details: " . $conn->error);
                }
            } else {
                die("Error fetching booking details: " . $conn->error);
            }

            $conn->close();
        } else {
            die("Error updating booking status: " . $conn->error);
        }
    } else {
        echo "Payment failed. Please try again.";
    }
} else {
    echo "Invalid request method.";
}
?>
