<?php
include('session_customer.php');
if(!isset($_SESSION['login_customer'])){
    session_destroy();
    header("location: customerlogin.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('config.php'); // Include database configuration file

    $game_id = isset($_POST['hidden_gameid']) ? $conn->real_escape_string($_POST['hidden_gameid']) : '';
    $rent_start_date = isset($_POST['rent_start_date']) ? date('Y-m-d', strtotime($_POST['rent_start_date'])) : '';
    $rent_end_date = isset($_POST['rent_end_date']) ? date('Y-m-d', strtotime($_POST['rent_end_date'])) : '';
    $cardNumber = isset($_POST['cardNumber']) ? $conn->real_escape_string($_POST['cardNumber']) : '';
    $cardName = isset($_POST['cardName']) ? $conn->real_escape_string($_POST['cardName']) : '';
    $expiryDate = isset($_POST['expiryDate']) ? $conn->real_escape_string($_POST['expiryDate']) : '';
    $cvv = isset($_POST['cvv']) ? $conn->real_escape_string($_POST['cvv']) : '';
    $customer_username = $_SESSION['login_customer'];

    // Validate required fields
    if (empty($game_id) || empty($rent_start_date) || empty($rent_end_date) || empty($cardNumber) || empty($cardName) || empty($expiryDate) || empty($cvv)) {
        die("All fields are required.");
    }

    // Validate dates
    function dateDiff($start, $end) {
        $start_ts = strtotime($start);
        $end_ts = strtotime($end);
        $diff = $end_ts - $start_ts;
        return round($diff / 86400);
    }

    $err_date = dateDiff($rent_start_date, $rent_end_date);
    $no_of_days = $err_date > 0 ? $err_date : 1;

    // Calculate fare
    $sql0 = "SELECT * FROM videogame WHERE game_id = '$game_id' AND game_availability = 'yes'";
    $result0 = $conn->query($sql0);
    
    if ($result0->num_rows === 0) {
        die("Game not available or invalid game ID.");
    }
    
    $row0 = mysqli_fetch_assoc($result0);
    $fare = $row0["price_day"];
    $total = $fare * $no_of_days;

    // Placeholder for payment processing.
    $payment_successful = true; // This should be based on actual payment processing result

    if ($payment_successful) {
        // Save booking information to the database
        $sql1 = "INSERT INTO rentedgames (customer_username, game_id, booking_date, rent_start_date, rent_end_date, fare, no_of_days, total_amount, return_status) 
                 VALUES ('$customer_username', '$game_id', CURDATE(), '$rent_start_date', '$rent_end_date', '$fare', '$no_of_days', '$total', 'NR')";
        
        $sql2 = "UPDATE videogame SET game_availability = 'no' WHERE game_id = '$game_id'";

        if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
            echo "Booking successful!";
            // You can redirect to a confirmation page
            // header("location: booking_confirmed.php");
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Payment failed. Please try again.";
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
